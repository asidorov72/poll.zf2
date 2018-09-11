<?php

namespace Anketa\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class QuestionTable {
  protected $tableGateway;
  
  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway;
  }
  
  public function fetchAll() {
    
    $resultSet = $this->tableGateway->select(function (Select $select) {
          $select->order('id DESC');
    });
    
    return $resultSet;
  }
  
  public function getQuestion($id) {
    $id = (int) $id;
    $rowset = $this->tableGateway->select(array('id' => $id));
    $row = $rowset->current();
    
    if (!$row) {
      throw new Exception("Could not find row $id");
    }
    
    return $row;
  }
  
  public function saveQuestion(Question $question) {
      
    $data = array(
      'title' => $question->title,
      'type' => $question->type,
      'question' => $question->question,
      'prompts' => $question->prompts,
      'answer' => $question->answer,
    );
    
    if (isset($question->date)) {
        $data['date'] = $question->date;
    }
    
    $user_id = (int) $question->user_id;
    
    if ($user_id) {
      $data['user_id'] = $user_id;
    }
   
    $id = (int) $question->id;
    
    if ($id == 0) {
      $this->tableGateway->insert($data);
    } else {
      if ($this->getQuestion($id)) {
        $this->tableGateway->update($data, array('id' => $id));
      } else {
        throw new Exception('The Post does not exist');
      }
    }
  }
  
  public function deleteQuestion($id) {
    $id = (int) $id;
    $this->tableGateway->delete(array('id' => $id));
  }
  
  
  public function getZfcUserName($id) {
    $id = (int) $id;
    $rowset = $this->tableGateway->select('user', array('user_id' => $id));
    $row = $rowset->current();
    
    if (!$row) {
      throw new Exception("Could not find row $id");
    }
    
    return $row;
  }
  
}

