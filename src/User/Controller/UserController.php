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
        
        $login = NULL;
        $model = $this->getServiceLocator()->get('user.model_user');
        $request = $this->getRequest();
        
        if ($request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }
        
        $redirectUrl = $this->url()->fromRoute('user/login')
            . ($redirect ? '?redirect=' . $redirect : '');
        $prg = $this->prg($redirectUrl, true);
        
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'formLogin' => $model->getFormLogin(),
                //'enableRegistration' => $this->getOptions()->getEnableRegistration(),
                'redirect' => $redirect,
            );
        }        
        
        
        // clear adapters
        //$this->userAuthentication()->getAuthAdapter()->resetAdapters();
        $this->userAuthentication()->getAuthService()->clearIdentity();
        $form = $model->getFormLogin();
        $form->setData($request->getPost());
        if(!$form->isValid()){
            return array(
                'formLogin' => $form,
                //'enableRegistration' => $this->getOptions()->getEnableRegistration(),
                'redirect' => $redirect,
            );           
        }
        return $this->forward()->dispatch('User', array('action' => 'authenticate'));
        
    }
    
    public function authenticateAction()
    {
        $request = $this->getRequest();
        //$adapter = $this->userAuthentication()->getAuthAdapter();
        $redirect = $this->params()->fromPost('redirect', $this->params()->fromQuery('redirect', false));
        
        $posts = $request->getPost();
        $this->userAuthentication()->getAuthAdapter()->setIdentity($posts['usuario']);
        $this->userAuthentication()->getAuthAdapter()->setCredential($posts['senha']);
        $auth = $this->userAuthentication()->getAuthService()->authenticate();          

        if (!$auth->isValid()) {
            $this->flashMessenger()->setNamespace('user-login-form')->addMessage('falha');
            return $this->redirect()->toUrl($this->url()->fromRoute('user/login')
                . ($redirect ? '?redirect='.$redirect : ''));
        }
        
        return $this->redirect()->toUrl($redirect);
    }
    
    public function logoutAction()
    {
        $auth = new AuthenticationService();
        $auth->clearIdentity();

        return $this->redirect()->toRoute('home');
    }
    
    public function registerAction()
    {
        $login = NULL;
        $model = $this->getServiceLocator()->get('user.model_user');
        $request = $this->getRequest();
        
        if ($request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }
        
        $redirectUrl = $this->url()->fromRoute('user/register')
            . ($redirect ? '?redirect=' . $redirect : '');
        $prg = $this->prg($redirectUrl, true);
        
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'formLogin' => $model->getFormLoginCadastro(),
                //'enableRegistration' => $this->getOptions()->getEnableRegistration(),
                'redirect' => $redirect,
            );
        }
        $login = $model->cadastrarLogin($request->getPost());
//
        $redirect = ($request->getQuery()->get('redirect')) ? $request->getQuery()->get('redirect') : null;
//
        if (!$login) {
            return array(
                'formLogin' => $model->getFormLoginCadastro(),
                //'enableRegistration' => $this->getOptions()->getEnableRegistration(),
                'redirect' => $redirect,
            );
        }
        
        // TODO: Add the redirect parameter here...
        return $this->redirect()->toUrl($this->url()->fromRoute('user/login') . ($redirect ? '?redirect='.$redirect : ''));        
    }    
}
