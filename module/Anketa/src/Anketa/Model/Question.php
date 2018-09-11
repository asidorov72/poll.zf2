<?php

namespace Anketa\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Question implements InputFilterAwareInterface {
  
  public $id;
  public $date;
  public $type;
  public $title;
  public $question;
  public $user_id;
  public $answer;
  public $prompts;
  
  protected $inputFilter;
  
  public function exchangeArray($data) {
    $this->id = (!empty($data['id'])) ? $data['id'] : null;
    $this->type = (!empty($data['type'])) ? $data['type'] : null;
    $this->date = (!empty($data['date'])) ? $data['date'] : null;
    $this->title = (!empty($data['title'])) ? $data['title'] : null;
    $this->question = (!empty($data['question'])) ? $data['question'] : null;
    $this->prompts = (!empty($data['prompts'])) ? $data['prompts'] : null;
    $this->answer = (!empty($data['answer'])) ? $data['answer'] : null;
    $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : 0;
  
  }
  
  public function getArrayCopy() {
    return get_object_vars($this);
  }
  
  public function setInputFilter(InputFilterInterface $inputFilter) {
     throw new \Exception("Not used");
  }

  public function getInputFilter() {

    if (!$this->inputFilter) {
      $inputFilter = new InputFilter();
      
      $inputFilter->add(
        array(
          'name' => 'id',
          'required' => true,
          'filters' => array(
            array('name' => 'Int')
          ),
        )
      );
      
      $inputFilter->add(
        array(
          'name' => 'title',
          'required' => true,
          'filters' => array(
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array(
              'name' => 'StringLength',
              'options' => array(
                'encoding' => 'UTF-8',
                'min' => 1,
                'max' => 100,
              )
            ),
          ),
        )
      );
      
      $inputFilter->add(
        array(
          'name' => 'question',
          'required' => true,
          'filters' => array(
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array(
              'name' => 'StringLength',
              'options' => array(
                'encoding' => 'UTF-8',
                'min' => 1,
                'max' => 1000,
              )
            ),
          ),
        )
      );
      
      $this->inputFilter = $inputFilter;
    }
    
    return $this->inputFilter;
  }
}

