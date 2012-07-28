<?php

class UserController extends Zend_Controller_Action
{

    /**
     * @var $_em \Doctrine\ORM\EntityManager
     */
    protected $_em;

    public function init()
    {
        $this->_em = Zend_Registry::get('doctrine')->getEntityManager();
    }

    public function loginAction()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/');
        }

        if ($this->getRequest()->isPost()) {
            $form = new Application_Form_Login();
            if ($form->isValid($this->_getAllParams())) {
                $adapter = new Application_Auth_Adapter_Doctrine($this->_em);
                $adapter
                    ->setEntityName('Application\Entity\User')
                    ->setIdentityField('username')
                    ->setCredentialField('password')
                    ->setCredential(sha1($form->getValue('password')))
                    ->setIdentity($form->getValue('username'));

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($adapter);

                if ($result->isValid()) {
                    $user = $this->_em
                        ->getRepository('Application\Entity\User')
                        ->findOneByUsername($form->getValue('username'));

                    $storage = $auth->getStorage();
                    $storage->write($user);

                    $this->_redirect('/');
                } else {
                    $this->getHelper('FlashMessenger')
                        ->setNamespace('error')
                        ->addMessage('Invalid credentials');
                    $this->view->result = $result;
                }
            }
        }
    }

    public function logoutAction()
    {
        $this->getHelper('ViewRenderer')->setNoRender(true);
        
        Zend_Auth::getInstance()->clearIdentity();
        
        $this->_redirect('/');
    }

}