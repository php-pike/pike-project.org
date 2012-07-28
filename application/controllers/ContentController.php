<?php

class ContentController extends Zend_Controller_Action
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_entityManager;

    public function init()
    {
        $this->_entityManager = Zend_Registry::get('doctrine')
            ->getEntityManager();
    }

    public function indexAction()
    {
        $itemName = $this->_getParam('page');

        $contentItem = $this->_entityManager
            ->find('Application\Entity\ContentItem', $itemName);

        if (null === $contentItem && false === Zend_Auth::getInstance()->hasIdentity()) {
            throw new Zend_Controller_Action_Exception(
                'Content item not found', 404
            );
        } elseif (null === $contentItem && Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/content/edit/page/' . $itemName);
        }

        $this->view->page = $itemName;
        $this->view->contentItem = $contentItem;
    }

    public function editAction() {
        if(false === Zend_Auth::getInstance()->hasIdentity()) {
            throw new Zend_Controller_Action_Exception(
                'You are not allowed to edit this page.', 403
            );            
        }
        
        $form = new Application_Form_ContentItem(); 
        
        $this->view->form = $form;
        
        
    }
    
}