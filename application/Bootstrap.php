<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initTestApplication() {
        $isWriteable = is_writable(APPLICATION_PATH . '/../library/Application/Entity/Proxy');
        if(!$isWriteable) {
            throw new Exception('The proxy directory for Doctrine should be writable by apache user.');
        }
    }

}

