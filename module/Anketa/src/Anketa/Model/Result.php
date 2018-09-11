<?php

namespace Anketa\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Result implements InputFilterAwareInterface {
  
  public $id;
  public $user_id;
  public $question_id;
  public $result;
  public $date;
  
  public $title;
  public $question;
 
  protected $inputFilter;
  
  public function exchangeArray($data) {
    $this->id = (!empty($data['id'])) ? $data['id'] : null;
    $this->date = (!empty($data['date'])) ? $data['date'] : null;
    $this->question_id = (!empty($data['question_id'])) ? $data['question_id'] : null;
    $this->result = (!empty($data['result'])) ? $data['result'] : null;
    $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : 0;
    
    $this->title = (!empty($data['title'])) ? $data['title'] : null;
    $this->question = (!empty($data['question'])) ? $data['question'] : null;
  }
  
  public function getArrayCopy() {
    return get_object_vars($this);
  }
  
  public function setInputFilter(InputFilterInterface $inputFilter) {
     throw new \Exception("Not used");
  }

  public function getInputFilter() {
  }
}

