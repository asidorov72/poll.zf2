<?php

namespace Anketa\Form;

use Zend\Form\Form;

class QuestionForm extends Form {
    
  public $countPrompts;
  
  public function __construct($name = null) {
      
    $this->countPrompts = 3;
    
    // sets the form's name 
    parent::__construct('questions');
    
    $this->add(
      array(
        'name' => 'id',
        'type' => 'Hidden',
      )
    );
    
    $this->add(
      array(
        'name' => 'date',
        'type' => 'Hidden',
      )
    );
    
    $this->add(
      array(
        'name' => 'title',
        'type' => 'Text',
        'attributes' => ['class' => 'form-control'],
        'options' => array(
          'label' => 'Title',
        )
      )
    );
    
    $this->add(
      array(
        'name' => 'question',
        'type' => 'Textarea',
        'attributes' => array(
          'rows'  => 4,
          'cols'  => 60,
          'class' => 'form-control'
        ),
        'options' => array(
          'label' => 'Question',
        )
      )
    );
    
    $this->add(array(
            'type' => 'MultiCheckbox',
            'name' => 'answer',
            'options' => array(
               'label' => 'Set as correct',
               'value_options' => array(
//                    array(
//                        'value' => '0'
//                    ),
//                    array(
//                        'value' => '1'
//                    ),
//                    array(
//                        'value' => '2'
//                    )
                )
            )
        ));
     
    for($n = 0; $n < $this->countPrompts; $n++) {
        $answerOptions[$n] = ' Set as correct';  
        $this->get("answer")->setValueOptions($answerOptions);
        
        $this->add(    
            array(
                'name' => "prompts[$n][prompt]",
                'type' => 'Text',
                'attributes' => ['class' => 'form-control'],
                'options' => array(
                  'label' => 'Prompts',
                )
            )
        );
        
       
    }
    
    $this->add(
      array(
        'name' => 'apply',
        'type' => 'Button',
        'attributes' => ['class' => 'btn btn-warning'],
        'options' => array(
          'value' => 'Apply',
          'id' => 'apply-btn',
        )
      )
    );
    
    $this->add(
      array(
        'name' => 'submit',
        'type' => 'Submit',
        'attributes' => ['class' => 'btn btn-primary'],
        'options' => array(
          'value' => 'Send',
          'id' => 'submitbutton',
        )
      )
    );
    
    
  }
  
  
  public function getCountPrompts() {
      return $this->countPrompts;
  }
}
