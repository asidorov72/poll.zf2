<?php

return array(
  'controllers' => array(
        'invokables' => array(
            'Anketa\Controller\Anketa' => 'Anketa\Controller\AnketaController'
        ),
    ),
  
    'view_manager' => array(
        'template_path_stack' => array(
          'anketa' =>  __DIR__ . '/../view',
        ),
    ),
  
    'router' => array(
        'routes' => array(
            'anketa' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/anketa[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Anketa\Controller\Anketa',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
);
