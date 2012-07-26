<?php
class Application_Controller_Plugin_Navigation extends Zend_Controller_Plugin_Abstract
{
    /**
     * Called before Zend_Controller_Front enters its dispatch loop.
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $file = APPLICATION_PATH . '/configs/navigation.xml';

        if (!file_exists($file)) {
            throw new Buza_Exception('Navigation.xml not found in configs directory.');
        }

        $config = new Zend_Config_Xml($file, 'nav');

        $navigation = new Zend_Navigation($config);

        $this->_addClassToContainer('link', $navigation);

        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $layout = $bootstrap->getResource('layout');

        /**
         */
        $view = $layout->getView();
        $view->navigation()
            ->menu($navigation);       
    }

    /**
     * Adds a custom CSS class to every page item in the container
     *
     * @param string                    $className
     * @param Zend_Navigation_Container $container
     */
    protected function _addClassToContainer($className, Zend_Navigation_Container $container)
    {
        $items = new RecursiveIteratorIterator($container, RecursiveIteratorIterator::SELF_FIRST);

        foreach ($items as $page) {
            if ($page instanceof Zend_Navigation_Page) {
                if ($page->getClass() != null && strpos($page->getClass(), $className) !== false) {
                    $page->setClass($page->getClass() . ' ' . $className);
                } else {
                    $page->setClass($className);
                }
            }
        }
    }
}