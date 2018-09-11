<?php

namespace Anketa\Model;

use Zend\Db\TableGateway\TableGateway;


class AnketaUserTable {
  protected $tableGateway;
  
  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway;
  }
  
  public function fetchAll() {
    $resultSet = $this->tableGateway->select();
    return $resultSet;
  }
  
  public function getZfcUser($user_id) {
    $user_id = (int) $user_id;
    $rowset = $this->tableGateway->select(array('user_id' => $user_id));
    $row = $rowset->current();
    
    return $row;
  }
  
}

