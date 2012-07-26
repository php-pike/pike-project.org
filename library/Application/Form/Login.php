<?php

class Application_Form_Login extends Pike_Form
{
    
    public function __construct(array $options = array('csrfToken' => false)) {
        parent::__construct($options);
    }

    public function init()
    {        
        $url = $this->getView()->url(array(
            'controller' => 'user', 'action' => 'login'
        ));

        $this->setAction($url);
        
        $this->addElement(new Zend_Form_Element_Text('username', array(
            'label' => 'Username',
            'required' => true,
            'class' => 'text'
        )));
        
        $this->addElement(new Zend_Form_Element_Password('password', array(
            'label' => 'Password',
            'required' => true,
            'class' => 'text'
        )));
        
        $this->addSubmitButton(new Zend_Form_Element_Submit('login', array(
            'label' => 'Login'
        )));
    }
    
}