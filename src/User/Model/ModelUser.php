<?php
namespace User\Model;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Authentication\Result as Result;

define('ATIVO', 1);

class ModelUser
{
    private $em;
    private $repository;
    private $form;
    private $sm;


    public function __construct($em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('User\Entity\User');
    }
    
    public function setSm($sm)
    {
        $this->sm = $sm;
        return $this;
    }
    
    public function getSm()
    {
        return $this->sm;
    }
    
   public function autentica($username, $password) {
        $auth =  $this->getSm()->get('user.auth');
        $auth->setIdentity($username);
        $auth->setCredential($password);
        $result = $auth->authenticate();

        switch ($result->getCode()) {

            case Result::FAILURE_IDENTITY_NOT_FOUND:
                /** do stuff for nonexistent identity * */
                echo 'FAILURE_IDENTITY_NOT_FOUND';
                break;

            case Result::FAILURE_CREDENTIAL_INVALID:
                /** do stuff for invalid credential * */
                echo 'FAILURE_CREDENTIAL_INVALID';
                break;

            case Result::SUCCESS:
                /** do stuff for successful authentication * */
                echo 'SUCCESS';
                break;

            default:
                /** do stuff for other failure * */
                 echo 'default';
                break;
        }
        exit;
    }    

    public function getLogins($offset,$maxResults = 10) {
        $query = $this->em->createQuery('SELECT u FROM User\Entity\User u');
        $query->setMaxResults($maxResults);
        $query->setFirstResult($offset);
        return $query->getResult();
    }

    public function getLoginsAtivosCount() {
        $query = $this->em->createQuery("SELECT COUNT(u) FROM User\Entity\User u WHERE u.status = {ATIVO}"); //testar com constante desse jeito!
        return $query->getResult();
    }
    
//    public function cadastrarLogin($param)
//    {
//        $form = $this->getFormLoginCadastro();
//        $param['dataCriacao'] = new \DateTime('now');
//        $param['dataAlteracao'] = $param['dataCriacao'];
//        $param['status'] = ATIVO;
//        $form->setData($param);
//        //if($form->isValid()){
//            $login = new \Petcad\Entity\Usuario\Login();
//            $login->setLogin($param['login']);
//            $login->setEmail($param['email']);
//            $login->setSenha($param['password']);
//            $login->setStatus($param['status']);
//            $login->setDataCriacao($param['dataCriacao']);
//            $login->setDataAlteracao($param['dataAlteracao']);
//            $this->em->persist($login);
//            $this->em->flush();
//            if($param['nome']){
//                $profile = new \Petcad\Entity\Usuario\Profile();
//                $profile->setNome($param['nome']);
//                $profile->setLogin($login);
//                $profile->setStatus($param['status']);
//                $profile->setDataCriacao($param['dataCriacao']);
//                $profile->setDataAlteracao($param['dataAlteracao']);
//                $this->em->persist($profile);
//                $this->em->flush();
//            }
//            return $login;
//        //}
//    }
//
//    public function editarLogin($param)
//    {
//        if(!isset($param['id'])){
//            throw new \Exception('Id não deve ser null');
//        }
//        $form = $this->getFormLoginEdicao($param['id']);
//        if(!$login instanceof \Petcad\Entity\Usuario\Login){
//            throw new \Exception('Login não encontrado');
//        }
//        $param['dataCriacao'] = new \DateTime('now');
//        $param['dataAlteracao'] = $param['dataCriacao'];
//        $param['status'] = ATIVO;
//        $form->setData($param);
//        if($form->isValid()){
//            $login->setLogin($param['login']);
//            $login->setSenha($param['password']);
//            $login->setStatus($param['status']);
//            $login->setDataCriacao($param['dataCriacao']);
//            $login->setDataAlteracao($param['dataAlteracao']);
//            $this->em->persist($login);
//            $this->em->flush();
//            return $login;
//        }
//    }
//
//    public function getFormLoginCadastro()
//    {
//        if(!$this->form){
//            $builder = new AnnotationBuilder();
//            $this->form    = $builder->createForm('Petcad\Entity\Usuario\Login');
//            $this->form->add(array(
//                    'name' => 'send',
//                    'type'  => 'Submit',
//                    'attributes' => array(
//                            'value' => 'Submit',
//                    ),
//            ));
//        }
//        return $this->form;
//    }
//
//    public function getFormLoginEdicao($id)
//    {
//        if(!$this->form){
//            $builder = new AnnotationBuilder();
//            $this->form    = $builder->createForm('Petcad\Entity\Usuario\Login');
//            $this->form->add(array(
//                    'name' => 'send',
//                    'type'  => 'Submit',
//                    'attributes' => array(
//                            'value' => 'Submit',
//                    ),
//            ));
//        }
//        $login = $this->repository->findOneById($param['id']);
//        $this->form->bind($login);
//        return $this->form;
//    }    
}

