<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use DoctrineORMModule\Service\EntityManagerFactory;
use DoctrineORMModule\Service\DBALConnectionFactory;
use User\Auth\Adapter\Doctrine as AuthAdapter;
use User\Model\ModelUser as ModelUser;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'doctrine.entitymanager.orm_default' => new EntityManagerFactory('orm_default'),
                'doctrine.connection.orm_default' => new DBALConnectionFactory('orm_default'),
                'user.model_user' => function($sm) {
                    $auth = new ModelUser($sm->get('doctrine.entitymanager.orm_default'));
                    $auth->setSm($sm);
                    return $auth;
                },                
                'user.auth' => function($sm) {
                    $auth = new AuthAdapter($sm->get('doctrine.entitymanager.orm_default'));
                    return $auth;
                },
            ),
        );
    }

}