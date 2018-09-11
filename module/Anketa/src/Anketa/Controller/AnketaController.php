<?php

namespace Anketa\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Anketa\Model\Question;
use Anketa\Model\Result;
use Anketa\Form\QuestionForm;

class AnketaController extends AbstractActionController {
  
    protected $questionTable;
    protected $resultTable;
    protected $anketaUserTable;
    public $messages;
  
    public function getQuestionTable() {
        if (!$this->questionTable) {
            $sm = $this->getServiceLocator();
            $this->questionTable = $sm->get('Anketa\Model\QuestionTable');
        }
        return $this->questionTable;
    }
  
    public function getResultTable() {
        if (!$this->resultTable) {
            $sm = $this->getServiceLocator();
            $this->resultTable = $sm->get('Anketa\Model\ResultTable');
        }
        return $this->resultTable;
    }
  
    public function getAnketaUserTable() {
        if (!$this->anketaUserTable) {
            $sm = $this->getServiceLocator();
            $this->anketaUserTable = $sm->get('Anketa\Model\AnketaUserTable');
        }
        return $this->anketaUserTable;
    }
  
    public function indexAction() {
      
        $form = new QuestionForm();
        $questions = $this->getQuestionTable()->fetchAll();
        $usersRes = $this->getAnketaUserTable()->fetchAll();
     
        $u = new ViewModel($usersRes);
        $users = $u->getVariables(); 
     
        return array(
            'questions' => $questions,
            'users' => $users,
            'form' => $form,
        );
    }
  
    public function addAction() {
        $form = new QuestionForm();
        $form->get('submit')->setValue('Create');

        $user_id = 0;
    
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            $user = $this->zfcUserAuthentication()->getIdentity();
            $user_id = (int) $user->getID();
        }
    
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $question = new Question();
      
            $form->setInputFilter($question->getInputFilter());
            $form->setData($request->getPost());

            $answer = $request->getPost('answer');
            $prompts = $request->getPost('prompts');
      
            if ($form->isValid()) {

                $question->exchangeArray($form->getData());
                $question->user_id = $user_id;
        
                if (count($prompts)) {
                    $question->prompts = serialize($prompts);
                    $question->answer = serialize($answer);
                }
        
                $this->getQuestionTable()->saveQuestion($question); 
        
                return $this->redirect()->toRoute('anketa');
            }
        }
    
        return array('form' => $form);
    }
  
    public function editAction() {
   
        $id = (int) $this->params()->fromRoute('id', 0);
    
        if (!$id) {
            return $this->redirect()->toRoute('anketa', array('action' => 'add'));
        }
    
        try {
            $question = $this->getQuestionTable()->getQuestion($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('anketa', array('action' => 'index'));
        }
    
        $question->answer = unserialize($question->answer);
        $question->prompts = unserialize($question->prompts);
    
        $form = new QuestionForm();
        $form->bind($question);
    
        foreach($question->prompts as $k => $v) {
            $form->get("prompts[$k][prompt]")->setValue($v['prompt']);
        }
    
        $form->get('date')->setValue(date("Y-m-d H:i:s"));
        $form->get('submit')->setValue('Edit');
    
        $request = $this->getRequest();
        
        if ($request->isPost()) {
        
            $form->setInputFilter($question->getInputFilter());
            $form->setData($request->getPost());
        
            $answer = $request->getPost('answer');
            $prompts = $request->getPost('prompts');
      
            if ($form->isValid()) {
          
                if (count($prompts)) {
                    $question->prompts = serialize($prompts);
                    $question->answer = serialize($answer);
                }

                $this->getQuestionTable()->saveQuestion($question);

                return $this->redirect()->toRoute('anketa');
            }
        }
    
        return array(
            'id' => $id,
            'form' => $form,
        );
    }
  
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
    
        if (!$id) {
            return $this->redirect()->toRoute('anketa');
        }
    
        try {
            $question = $this->getQuestionTable()->getQuestion($id);
            $zfcuser  = $this->getAnketaUserTable()->getZfcUser($question->user_id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('anketa', array('action' => 'index'));
        }
    
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del === 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getQuestionTable()->deleteQuestion($id);
            }

            return $this->redirect()->toRoute('anketa');
        }
    
        return array(
            'id' => $id,
            'post' => $question,
            'user' => $zfcuser,
        );
    }
  
    public function applyAction() {
      
        $user_id = 0;
    
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            $user = $this->zfcUserAuthentication()->getIdentity();
            $user_id = (int) $user->getID();
        }
    
        $id = (int) $this->params()->fromRoute('id', 0);
    
        if (!$id) {
            return $this->redirect()->toRoute('anketa', array('action' => 'add'));
        }
    
        $request = $this->getRequest();
    
        if ( $request->isXmlHttpRequest()){

            if ($request->isPost()){

                $data = $request->getPost();
                $answerQuery = str_replace("answer[]=", "", urldecode($data['answer']));
                $answerArray = explode('&', $answerQuery);

                try {
                    $question = $this->getQuestionTable()->getQuestion($id);
                } catch (\Exception $ex) {
                    return $this->redirect()->toRoute('anketa', array('action' => 'index'));
                }

                $question->answer = unserialize($question->answer);

                $resultArr = array_diff($question->answer, $answerArray);
                $response  = (empty($resultArr)) ? 'correct' : 'incorrect';

                $result = new Result();

                $result->question_id = $id;
                $result->result = $response;
                $result->user_id = $user_id;

                $this->getResultTable()->saveResult($result); 
            }
        }
        exit();
    }
  
  

  public function viewAction() {
    
        $user_id = 0;
    
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            $user = $this->zfcUserAuthentication()->getIdentity();
            $user_id = (int) $user->getID();
        }
        
        $results = $this->getResultTable()->getAnketaResults($user_id);
        
        return array(
            'user' => $user,
            'results' => $results,
        );
    }
  
  
}

