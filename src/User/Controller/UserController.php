<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    /**
     * Login form
     */
    public function loginAction()
    {
        if ($this->userAuthentication()->hasIdentity() && $this->userAuthentication()->getIdentity()->getLogin() <> 'guest') {
            return $this->redirect()->toRoute('home');
        }

        $request = $this->getRequest();
        $form    = $this->getLoginForm();

        if ($request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }

        if (!$request->isPost()) {
            return array(
                'loginForm' => $form,
                'redirect'  => $redirect,
                //'enableRegistration' => $this->getOptions()->getEnableRegistration(),
            );
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            echo 'form nao valido!';exit;
            //$this->flashMessenger()->setNamespace('zfcuser-login-form')->addMessage($this->failedLoginMessage);
            //return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LOGIN).($redirect ? '?redirect='.$redirect : ''));
        }

        // clear adapters
        //$this->userAuthentication()->getAuthAdapter()->resetAdapters();
        $this->userAuthentication()->getAuthService()->clearIdentity();

        return $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'authenticate'));
    }
    
    public function authenticateAction()
    {
        $this->userAuthentication()->getAuthAdapter()->setIdentity('diego');
        $this->userAuthentication()->getAuthAdapter()->setCredential('102030');
        return $this->userAuthentication()->getAuthService()->authenticate();          
        
    }
    
    public function logoutAction()
    {
        $auth = new AuthenticationService();
        $auth->clearIdentity();

        return $this->redirect()->toRoute('home');
    }    
}
