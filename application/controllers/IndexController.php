<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
        $this->view->headTitle('Zend Framework Datagrid with Doctrine!')->headTitle(' Pike Grid');
    }


}

