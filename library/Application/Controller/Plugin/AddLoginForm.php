<?php
class Application_Controller_Plugin_AddLoginForm extends Zend_Controller_Plugin_Abstract
{
    /**
     * Called before Zend_Controller_Front enters its dispatch loop.
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $layout = $bootstrap->getResource('layout');

        $form = new Application_Form_Login();
        
        $view = $layout->getView();
        $view->assign('loginForm', $form);
    }

}