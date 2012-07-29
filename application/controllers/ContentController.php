<?php

class ContentController extends Zend_Controller_Action
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    public function init()
    {
        $this->_em = Zend_Registry::get('doctrine')
            ->getEntityManager();
    }

    public function indexAction()
    {
        $itemName = $this->_getParam('page');

        $contentItem = $this->_em
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
        
        $itemName = $this->_getParam('page');
        $form = new Application_Form_ContentItem(); 
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $new = false;
                $contentItem = $this->_em
                    ->getRepository('Application\Entity\ContentItem')
                    ->find($itemName);
                
                if(null === $contentItem) {
                    $new = true;
                    $contentItem = new Application\Entity\ContentItem;                    
                }
                
                $contentItem->id = $itemName;
                $contentItem->title = $form->getValue('title');
                $contentItem->pageTitle = $form->getValue('pageTitle');
                $contentItem->abstract = $form->getValue('abstract');
                $contentItem->content = $form->getValue('content');
                
                if($new) {
                    $this->_em->persist($contentItem);
                }
                
                $this->_em->flush();
                
                $this->getHelper('FlashMessenger')
                    ->setNamespace('normal')
                    ->addMessage('Content item is succesfully saved.');
                
//                $this->getHelper('Redirector')->gotoRouteAndExit(array(
//                    'controller' => 'content', 
//                    'action' => 'index', 
//                    'page' => $itemName
//                ), 'content', true);
            }
        }
         
        $this->view->form = $form;
        
        
    }
    
}