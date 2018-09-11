<?php

namespace Anketa\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AnketaUser implements InputFilterAwareInterface {
  
  public $user_id;
  public $username;
  public $email;
  public $display_name;
  public $state;
  
  public function exchangeArray($data) {
    $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
    $this->username = (!empty($data['username'])) ? $data['username'] : null;
    $this->email = (!empty($data['email'])) ? $data['email'] : null;
    $this->display_name = (!empty($data['display_name'])) ? $data['display_name'] : null;
    $this->state = (!empty($data['state'])) ? $data['state'] : null;
  }
  
  public function getArrayCopy() {
    return get_object_vars($this);
  }
  
  public function setInputFilter(InputFilterInterface $inputFilter) {}

  public function getInputFilter() {}
}

