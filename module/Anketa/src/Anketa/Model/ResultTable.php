<?php

namespace Anketa\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class ResultTable {
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
  
  public function getResult($id) {
    $id = (int) $id;
    $rowset = $this->tableGateway->select(array('id' => $id));
    $row = $rowset->current();
    
    if (!$row) {
      throw new Exception("Could not find row $id");
    }
    
    return $row;
  }
  
  public function saveResult(Result $result) {
      
    $data = array(
      'result' => $result->result,
    );
    
    if (isset($result->date)) {
        $data['date'] = $result->date;
    }
    
    $user_id = (int) $result->user_id;
    
    if ($user_id) {
      $data['user_id'] = $user_id;
    }
   
    $id = (int) $result->id;
    
    $question_id = (int) $result->question_id;
    
    if ($question_id) {
      $data['question_id'] = $question_id;
    }
    
    
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
  
  public function deleteResult($id) {
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
  
  
  
   public function getAnketaResults($id) {
       $user_id = (int) $id;
       
        $sqlSelect = $this->tableGateway->getSql()->select();
	$sqlSelect->columns(array('*'));
	$sqlSelect->join('question', 'question.id = result.question_id', array('question', 'title'), 'left');
        $sqlSelect->where(array('result.user_id' => $id));
	$resultSet = $this->tableGateway->selectWith($sqlSelect);
       
        return $resultSet;
    }
  
}

