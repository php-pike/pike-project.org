<?php
class ExampleController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->ViewRenderer->setScriptAction('grid');
    }

    public function postDispatch() {
        $this->view->headTitle()->setSeparator(' - ');
        $this->view->headTitle('Pike Grid');               
    }
    
    public function indexAction()
    {
        // action body
    }

    /**
     * Just a simple and nice grid nothing more, nothing less!
     * 
     * @return void
     * @since 0.2
     */
    public function simpleAction()
    {
        $this->view->headTitle('Simple example');
                
        /* @var $entityManager Doctrine\ORM\EntityManager */
        $entityManager = Zend_Registry::get('doctrine')->getEntityManager();
        $request = $this->getRequest();        
        $query = $entityManager->createQuery('SELECT p.name AS model, m.name AS manufacturer, pt.name as type ' .
                                'FROM Application\Entity\Phone AS p JOIN p.manufacturer AS m JOIN p.phonetype as pt');
        
        $datasource = new Pike_Grid_Datasource_Doctrine($query);
        
        $grid = new Pike_Grid($datasource);
        $grid->setCaption('Example phones');
        
        $this->view->grid = $grid;
        $this->view->headScript()->appendScript($grid->getJavascript(), 'text/javascript');
        $this->view->headScript()->appendScript('Application.bindTooltipsToSimpleExample()', 'text/javascript');
        
        $this->view->source = $this->_highLight(__FUNCTION__);
        
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout(true);
            $viewRenderer = $this->_helper->ViewRenderer->setNoRender(true);
            
            $datasource->setParameters($request->getPost());
            echo $datasource->getJSON();
        }
    }

    /**
     *
     * See here how to use a callback to render data for a specific column
     * 
     * @return void
     * @since 0.2
     */
    public function dataCallbackAction() {
        $this->view->headTitle('Data callback example');
                
        /* @var $entityManager Doctrine\ORM\EntityManager */
        $entityManager = Zend_Registry::get('doctrine')->getEntityManager();
        $request = $this->getRequest();   
        $view = $this->view;
        $query = $entityManager->createQuery('SELECT p.name AS model, m.name AS manufacturer, pt.name as type ' .
                                'FROM Application\Entity\Phone AS p JOIN p.manufacturer AS m JOIN p.phonetype as pt');
        
        $datasource = new Pike_Grid_Datasource_Doctrine($query);
        
        $grid = new Pike_Grid($datasource);
        $grid->setColumnAttribute('model', 'data', function($row) use($view) {
            $url = $view->url(array('controller' => 'somecontroller', 'action' => 'someaction', 'name' => $row['model']));
            
            return '<a href="' . $url . '">' . $row['model'] . '</a>';
        });
        
        $this->view->grid = $grid;
        $this->view->headScript()->appendScript($grid->getJavascript(), 'text/javascript');
        $this->view->headScript()->appendScript('Application.bindTooltipsToSimpleDataCallback()', 'text/javascript');
        
        $this->view->source = $this->_highLight(__FUNCTION__);
        
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout(true);
            $viewRenderer = $this->_helper->ViewRenderer->setNoRender(true);
            
            $datasource->setParameters($request->getPost());
            echo $datasource->getJSON();
        }
    }        

    /**
     * The following peice of code enables default sorting of your grid. You can pass this thru query just like you used to.
     * 
     * @return void
     * @since 0.2
     */
    public function defaultSortingAction() {
        $this->view->headTitle('Default sorting example');
                
        /* @var $entityManager Doctrine\ORM\EntityManager */
        $entityManager = Zend_Registry::get('doctrine')->getEntityManager();
        $request = $this->getRequest();   
        $view = $this->view;
        $query = $entityManager->createQuery('SELECT p.name AS model, m.name AS manufacturer, pt.name as type ' .
                                'FROM Application\Entity\Phone AS p JOIN p.manufacturer AS m JOIN p.phonetype as pt ' .
                                'ORDER BY m.name ASC');
        
        $datasource = new Pike_Grid_Datasource_Doctrine($query);
        
        $grid = new Pike_Grid($datasource);
        
        $this->view->grid = $grid;
        $this->view->headScript()->appendScript($grid->getJavascript(), 'text/javascript');
        $this->view->headScript()->appendScript('Application.bindTooltipsToDefaultSorting()', 'text/javascript');
        
        $this->view->source = $this->_highLight(__FUNCTION__);
        
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout(true);
            $viewRenderer = $this->_helper->ViewRenderer->setNoRender(true);
            
            $datasource->setParameters($request->getPost());
            echo $datasource->getJSON();
        }
    }
    
    /**
     * With Pike_Grid you can add columns which aren't available from the query itself. For example add 
     * or edit columns. With <a href="/pikegrid/example/data-callback">data callbacks</a> you can do almost anything 
     * with you want to create these functions.
     * 
     * @return void
     * @since 0.2
     */
    public function extraColumnsAction() {
        $this->view->headTitle('Extra columns example');
                
        /* @var $entityManager Doctrine\ORM\EntityManager */
        $entityManager = Zend_Registry::get('doctrine')->getEntityManager();
        $request = $this->getRequest();   
        $view = $this->view;
        $query = $entityManager->createQuery('SELECT p.name AS model, m.name AS manufacturer, pt.name as type ' .
                                'FROM Application\Entity\Phone AS p JOIN p.manufacturer AS m JOIN p.phonetype as pt ');
        
        $datasource = new Pike_Grid_Datasource_Doctrine($query);
        
        $grid = new Pike_Grid($datasource);
        $grid->addColumn('technicalname', function($row) use($view) {
            $url = $view->url(array('controller' => 'some-controller', 'action' => 'edit', 'name' => $row['model']));
            return '<a href="'.$url.'">Edit '.$row['model'].'</a>';
        }, 'edit', 'p.name');
        
        $this->view->grid = $grid;
        $this->view->headScript()->appendScript($grid->getJavascript(), 'text/javascript');
        $this->view->headScript()->appendScript('Application.bindTooltipsToExtraColumns()', 'text/javascript');
        
        $this->view->source = $this->_highLight(__FUNCTION__);
        
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout(true);
            $viewRenderer = $this->_helper->ViewRenderer->setNoRender(true);
            
            $datasource->setParameters($request->getPost());
            echo $datasource->getJSON();
        }
    }
    
    /**
     *
     * With this feature you can exactly define on which positions each column 
     * should be. By default Pike_Grid renders every column in the same positions
     * as you write it in your (DQL) query. Extra columns will be appended. If you
     * don't like this behavior you can modify the column positions as follows
     * 
     * @return void
     * @since 0.2
     */
    public function positionsAction() {
        $this->view->headTitle('Defining positions example');
        
        /* @var $entityManager Doctrine\ORM\EntityManager */
        $entityManager = Zend_Registry::get('doctrine')->getEntityManager();
        
        $request = $this->getRequest();   
        $view = $this->view;
        $query = $entityManager->createQuery('SELECT p.name AS model, m.name AS manufacturer, pt.name as type ' .
                                'FROM Application\Entity\Phone AS p JOIN p.manufacturer AS m JOIN p.phonetype as pt ');
        
        $datasource = new Pike_Grid_Datasource_Doctrine($query);
        
        $grid = new Pike_Grid($datasource);
        $grid->setCaption('Column positions')
             ->addColumn('technicalname', function($row) use($view) {
            $url = $view->url(array('controller' => 'some-controller', 'action' => 'edit', 'name' => $row['model']));
            return '<a href="'.$url.'">Edit '.$row['model'].'</a>';
        }, 'edit', 'p.name')
             ->setColumnAttribute('technicalname', 'position', 5)
             ->setColumnAttribute('model', 'position', 4);
        
        $this->view->grid = $grid;
        $this->view->headScript()->appendScript($grid->getJavascript(), 'text/javascript');
        $this->view->headScript()->appendScript('Application.bindTooltipsToPositions()', 'text/javascript');
        
        $this->view->source = $this->_highLight(__FUNCTION__);
        
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout(true);
            $viewRenderer = $this->_helper->ViewRenderer->setNoRender(true);
            
            $datasource->setParameters($request->getPost());
            echo $datasource->getJSON();
        }        
    }
    
    /**
     *
     * Enables filtering on different kind of fields with the default built in
     * Doctrine LikeWalker. You can customize the search operation with $ds->setEventFilter(closure)
     * which needs to return a array of query hints telling Doctrine which records are matched.
     * 
     * @return void
     * @since 0.4
     */
    public function filteringAction() {
        $this->view->headTitle('Grid with filtertoolbar');
        
        /* @var $entityManager Doctrine\ORM\EntityManager */
        $entityManager = Zend_Registry::get('doctrine')->getEntityManager();
        
        $request = $this->getRequest();   
        $view = $this->view;
        $query = $entityManager->createQuery('SELECT p.name AS model, m.name AS manufacturer, pt.name as type ' .
                                'FROM Application\Entity\Phone AS p JOIN p.manufacturer AS m JOIN p.phonetype as pt ');
        
        $datasource = new Pike_Grid_Datasource_Doctrine($query);
        
        $grid = new Pike_Grid($datasource);
        $grid->setId('filtergrid')
             ->setAttribute('hidegrid', false)
             ->setCaption('Filter the grid')
             ->setRowsPerPage(20)
             ->setColumnAttribute('model', 'search', false)
             ->setColumnAttribute('type', 'search', false);
        
        $this->view->grid = $grid;
        $this->view->headScript()->appendScript($grid->getJavascript(), 'text/javascript');
        $this->view->headScript()->appendScript('Application.bindFilterToolbarToFilterGrid()', 'text/javascript');
        $this->view->headScript()->appendScript('Application.bindTooltipsToFilter()', 'text/javascript');
        
        $this->view->source = $this->_highLight(__FUNCTION__);
        
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout(true);
            $viewRenderer = $this->_helper->ViewRenderer->setNoRender(true);
            
            $datasource->setParameters($request->getPost());
            echo $datasource->getJSON();
        }        
    }    
    
    /**
     *
     * Function to highlight the source of a given method of this class.
     * 
     * @param string $method Method to highlight source
     * @return void
     */
    private function _highLight($method) {     
        $reflection = new Zend_Reflection_Class(__CLASS__);
        $method = $reflection->getMethod($method);
        
        if(strlen($method->getDocComment()) > 0) {
            
            $docBlock = $method->getDocblock();

            $this->view->intro = $docBlock->getShortDescription().$docBlock->getLongDescription();
            $this->view->version = $docBlock->getTag('since')->getDescription();
        }
        
        $start = $method->getStartLine() -1;
        $end = $method->getEndLine();
        $lines = $end - $start;
        
        if($end > $start) {
            $sourcefile = file(__FILE__);
            $source = '';
            
            for($i=$start; $i<=$end; $i++) {
                $source .= $sourcefile[$i];
            }
            $source = "<?php \n... \n" . $source . "\n... \n?>";
            return $this->_helper->highlight($source, true);
            
        }
    }  
}

