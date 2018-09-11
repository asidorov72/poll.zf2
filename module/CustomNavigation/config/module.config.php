<?php
use CustomNavigation\Navigation\NavigationFactory;

return [
    'router' => [
        'routes' => [
            'custom-navigation' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/custom-navigation',
                    'defaults' => [
                        'controller'    => 'CustomNavigation\Controller\Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'default' => [
                        'type'      => 'Segment',
                        'options'   => [
                            'route'         => '[/:action]',
                            'constraints'   => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                ],
            ],

        ],
    ],

    'controllers' => [
        'invokables' => [
            'CustomNavigation\Controller\Index' => 'CustomNavigation\Controller\IndexController',
        ],
    ],

    'service_manager' => [
        'factories' => [
            NavigationFactory::NAME => 'CustomNavigation\Navigation\NavigationFactory',
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__.'/../view',
        ],
    ],

    'navigation' => [
        NavigationFactory::NAME => [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
            [
                'label' => 'Anketa',
                'route' => 'anketa',
                'pages' => [
                    [
                        'label' => 'Questions',
                        'route' => 'anketa',
                        'action' => 'index',
                    ],
                    [
                        'label' => 'Creat a question',
                        'route' => 'anketa',
                        'action' => 'add',
                    ],
                    
                ],
            ]
            
        ],
    ],
];
