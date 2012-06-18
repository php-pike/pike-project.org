<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initTestApplication()
    {
        $config = $this->getOptions();

        $directory = $config['resources']['doctrine']['orm']['entityManagers']
                ['default']['proxy']['dir'];

        if (!is_writable($directory)) {
            throw new Exception('The proxy directory for Doctrine should be '
                    . 'writable by apache user.');
        }
    }

    protected function _initAutoloaderNamespaces()
    {
        $autoloader = \Zend_Loader_Autoloader::getInstance();
        $fmmAutoloader = new \Doctrine\Common\ClassLoader('Bisna');
        $autoloader->pushAutoloader(array($fmmAutoloader, 'loadClass'), 'Bisna');
    }

}