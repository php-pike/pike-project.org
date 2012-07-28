<?php

/*
 * @uses       Zend_Controller_Plugin_Abstract
 * @author     Kees Schepers <kees@skyconcepts.nl>
 */

class Application_Controller_Plugin_SetupAssets extends Zend_Controller_Plugin_Abstract
{

    private $appended = false;

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $layout = Zend_Controller_Action_HelperBroker::getStaticHelper('layout');
        $view = $layout->getView();

        $view->headScript()->prependFile($view->baseUrl() . '/js/application.js')
            ->prependFile($view->baseUrl() . '/js/jquery.jqGrid.min.js')
            ->prependFile($view->baseUrl() . '/js/i18n/grid.locale-nl.js')
            ->prependFile($view->baseUrl() . '/js/jquery.qtip.min.js')
            ->prependFile($view->baseUrl() . '/js/jquery.corner.js')
            ->prependFile($view->baseUrl() . '/js/jquery-ui-1.8.4.custom.js')
            ->prependFile($view->baseUrl() . '/js/jquery-1.5.2.min.js')
            ->appendScript(<<<EOS
$(document).ready(function() {
    Application.init();
})
EOS
                , 'text/javascript');

        if (Zend_Auth::getInstance()->hasIdentity()) {
            $view->headScript()
                ->appendFile($view->baseUrl() . '/js/tinymce/jscripts/tiny_mce/jquery.tinymce.js');
        }

        $view->headScript()->appendScript(<<<EOS
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-5372700-4']);
            _gaq.push(['_trackPageview']);
		
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
EOS
            , 'text/javascript');

        $view->headLink()
            ->prependStylesheet($view->baseUrl() . '/css/application.css')
            ->prependStylesheet($view->baseUrl() . '/css/forms.css')
            ->prependStylesheet($view->baseUrl() . '/css/jquery.qtip.css')
            ->prependStylesheet($view->baseUrl() . '/css/ui.jqgrid.css')
            ->prependStylesheet($view->baseUrl() . '/css/jquery-ui/smoothness/jquery-ui-1.8.2.custom.css');

        $view->headMeta()
            ->setHttpEquiv('Content-Type', 'text/html;charset=utf-8')
            ->setName('description', '')
            ->setName('robots', 'all')
            ->setName('author', 'Pike Project')
            ->setName('lall_anguage', 'NL');
    }

    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        $layout = Zend_Controller_Action_HelperBroker::getStaticHelper('layout');
        $view = $layout->getView();
        $path = '/css/application/' . $request->getControllerName() . '.css';

        if (file_exists(APPLICATION_PATH . '/../public' . $path)) {
            $view->headLink()->prependStylesheet($view->baseUrl() . $path);
        }

        $controller = strtolower($request->getControllerName());

        if (file_exists(APPLICATION_PATH . '/public/javascript/Application/' . $controller . '.js') && !$this->appended) {
            $view->headScript()->appendFile($view->baseUrl() . '/javascript/Application/' . $controller . '.js');

            $inflector = new Zend_Filter_Inflector(':string');
            $inflector->addRules(array(':string' => array('Word_DashToCamelCase')));
            $controller = $inflector->filter(array('string' => $controller));

            $view->headScript()->appendScript($controller . 'Controller.init()',
                'text/javascript');

            $this->appended = true;
        }
    }

}