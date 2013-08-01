<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Authentication\Adapter;

use Zend\Authentication\Adapter\AbstractAdapter as AbstractAdapter;
use Zend\Authentication\Result as AuthenticationResult;
use Zend\Authentication\Exception as Exception;

/**
 * @deprecated
 */
class Doctrine extends AbstractAdapter {

    private $em, $repository;

    public function __construct($em, $username = '', $password = '') {
        $this->em = $em;
        $this->repository = $em->getRepository('User\Entity\User');
        $this->setIdentity($username);
        $this->setCredential($password);

        $this->authenticateResultInfo = array(
            'code'     => AuthenticationResult::FAILURE,
            'identity' => $this->identity,
            'messages' => array()
        );
    }

    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
     * @return Zend_Auth_Result
     */
    public function authenticate() {
        $resultIdentities = $this->authenticateQuerySelect();

        if (($authResult = $this->authenticateValidateResultSet($resultIdentities)) instanceof AuthenticationResult) {
            return $authResult;
        }

        // At this point, ambiguity is already done. Loop, check and break on success.
        foreach ($resultIdentities as $identity) {
            $authResult = $this->authenticateValidateResult($identity);
            if ($authResult->isValid()) {
                break;
            }
        }

        return $authResult;
    }

    /**
     * _authenticateValidateResult() - This method attempts to validate that
     * the record in the resultset is indeed a record that matched the
     * identity provided to this adapter.
     *
     * @param  array $resultIdentity
     * @return AuthenticationResult
     */
    protected function authenticateValidateResult($resultIdentity)
    {
        //retirar apos receber o algoritmo de validacao da intra!
        if(!$resultIdentity instanceof \User\Entity\User){
            $this->authenticateResultInfo['code']       = AuthenticationResult::FAILURE_CREDENTIAL_INVALID;
            $this->authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
            return $this->authenticateCreateAuthResult();
        }
        //$this->resultRow = $resultIdentity;
        $this->authenticateResultInfo['identity'] = $resultIdentity;
        $this->authenticateResultInfo['code']       = AuthenticationResult::SUCCESS;
        $this->authenticateResultInfo['messages'][] = 'Authentication successful.';
        return $this->authenticateCreateAuthResult();
    }

    protected function authenticateValidateResultSet(array $resultIdentities)
    {

        if (count($resultIdentities) < 1) {
            $this->authenticateResultInfo['code']       = AuthenticationResult::FAILURE_IDENTITY_NOT_FOUND;
            $this->authenticateResultInfo['messages'][] = 'A record with the supplied identity could not be found.';
            return $this->authenticateCreateAuthResult();
        } elseif (count($resultIdentities) > 1) {
            $this->authenticateResultInfo['code']       = AuthenticationResult::FAILURE_IDENTITY_AMBIGUOUS;
            $this->authenticateResultInfo['messages'][] = 'More than one record matches the supplied identity.';
            return $this->authenticateCreateAuthResult();
        }

        return true;
    }

    protected function authenticateQuerySelect() {
        try {
            $result = $this->repository->findBy(array(
                'login' => $this->getIdentity(),
                'senha' => md5($this->getCredential())
                ));
        } catch (\Exception $e) {
            throw new Exception\RuntimeException(
            'The supplied parameters to Doctrine failed to '
            . 'produce a valid sql statement, please check table and column names '
            . 'for validity.', 0, $e
            );
        }
        return $result;
    }

    /**
     * Creates a Zend\Authentication\Result object from the information that
     * has been collected during the authenticate() attempt.
     *
     * @return AuthenticationResult
     */
    protected function authenticateCreateAuthResult()
    {
        return new AuthenticationResult(
            $this->authenticateResultInfo['code'],
            $this->authenticateResultInfo['identity'],
            $this->authenticateResultInfo['messages']
        );
    }

}
