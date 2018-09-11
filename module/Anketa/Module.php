<?php

namespace Anketa;

use Anketa\Model\Question;
use Anketa\Model\QuestionTable;
use Anketa\Model\Result;
use Anketa\Model\ResultTable;
use Anketa\Model\AnketaUser;
use Anketa\Model\AnketaUserTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\ModuleManager\Feature\ViewHelperProviderInterface;

use Anketa\View\Helper\Dateformathelper;
use Anketa\View\Helper\Getzfcuserbyidhelper;


class Module implements
    AutoloaderProviderInterface, 
    ConfigProviderInterface, 
    ViewHelperProviderInterface
{
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'date_format_helper' => function($sm) {
                    $helper = new Dateformathelper;
                    return $helper;
                },
                'get_zfcuser_by_id_helper' => function($sm) {
                    $helper = new Getzfcuserbyidhelper;
                    return $helper;
                }
            )
        );   
    }
   
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    
    public function getServiceConfig()
    {
        return array(
          'factories' => array(
            'Anketa\Model\QuestionTable' => function($sm){
              $tableGateway = $sm->get('QuestionTableGateway');
              $table = new QuestionTable($tableGateway);
              return $table;
            },
            'QuestionTableGateway' => function($sm){
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $resultSetPrototype = new ResultSet();
              $resultSetPrototype->setArrayObjectPrototype(new Question());
              return new TableGateway('question', $dbAdapter, null, $resultSetPrototype);
            },
                    
            'Anketa\Model\ResultTable' => function($sm){
              $tableGateway = $sm->get('ResultTableGateway');
              $table = new ResultTable($tableGateway);
              return $table;
            },
            'ResultTableGateway' => function($sm){
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $resultSetPrototype = new ResultSet();
              $resultSetPrototype->setArrayObjectPrototype(new Result());
              return new TableGateway('result', $dbAdapter, null, $resultSetPrototype);
            },      
                    
            'Anketa\Model\AnketaUserTable' => function($sm){
              $tableAnketaUserGateway = $sm->get('AnketaUserTableGateway');
              $tableAnketaUser = new AnketaUserTable($tableAnketaUserGateway);
              return $tableAnketaUser;
            },
            'AnketaUserTableGateway' => function($sm){
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $resultSetPrototype = new ResultSet();
              $resultSetPrototype->setArrayObjectPrototype(new AnketaUser());
              return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
            },
          )
        );
    }
}
