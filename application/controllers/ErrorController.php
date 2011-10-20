<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        // Grab the error object from the request
        $errors = $this->_getParam('error_handler');

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                $this->view->code = 404;

                echo $errors->exception->getMessage();
                echo $errors->exception->getFile();
                echo $errors->exception->getLine();

                if ($errors->type == Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER) {
                    $this->view->info = sprintf(
                            'Unable to find controller "%s" in module "%s"', $errors->request->getControllerName(), $errors->request->getModuleName()
                    );
                }
                if ($errors->type == Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION) {
                    $this->view->info = sprintf(
                            'Unable to find action "%s" in controller "%s" in module "%s"', $errors->request->getActionName(), $errors->request->getControllerName(), $errors->request->getModuleName()
                    );
                }
                break;
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                $this->view->code = 500;
                $this->view->info = $errors->exception;
                break;
        }

        $this->view->title = 'Error!';
        $this->view->heading = 'Error!';

        // pass the environment to the view script so we can conditionally
        // display more/less information
        $this->view->env = APPLICATION_ENV;

        // pass the actual exception object to the view
        $this->view->exception = $errors->exception;

        // pass the request to the view
        $this->view->request = $errors->request;
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

}

