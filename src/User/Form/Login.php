<?php
namespace User\Form; 

use Zend\Captcha; 
use Zend\Form\Element; 
use Zend\Form\Form; 

class Login extends Form 

{ 
    public function __construct($name = null) 
    { 
        parent::__construct(''); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'email', 
            'type' => 'Zend\Form\Element\Email', 
            'attributes' => array( 
                'placeholder' => 'Email Address...', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Email', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'password', 
            'type' => 'Zend\Form\Element\Password', 
            'attributes' => array( 
                'placeholder' => 'Password Here...', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Password', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'password_verify', 
            'type' => 'Zend\Form\Element\Password', 
            'attributes' => array( 
                'placeholder' => 'Verify Password Here...', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Verify Password', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'csrf', 
            'type' => 'Zend\Form\Element\Csrf', 
        ));        
    } 
} 