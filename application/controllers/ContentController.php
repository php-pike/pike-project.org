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

        if (null === $contentItem) {
            throw new Zend_Controller_Action_Exception(
                    'Content item not found', 404
            );
        }
        
        $this->view->contentItem = $contentItem;
    }

}