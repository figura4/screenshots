<?php

class GameController extends Common_ControllerAbstract {

    public function init() {
    	$this->_model = 'Application_Model_Game';  				
		$this->_mapper = Zend_Registry::get('gameMapper'); 		
		$this->_form['create'] = 'Application_Form_Game';   	
		$this->_form['edit'] = 'Application_Form_Game';   		
		$this->_form['admin'] = 'Application_Form_GameList';   
		$this->_form['list'] = 'Application_Form_GameList';   	
    }
   
    public function listAction() {
    	$this->view->pageTitle = "Featured videogames";
    	$this->view->headTitle()->prepend("Featured videogames");
    	$this->view->headMeta()->setName('keywords', Zend_Registry::get('siteKeywords') . ', featured games');
    	$this->view->headMeta()->setName('description', 'list of videogames featured on the website and carefully screenshotted by the bitgrabbers');
    	$this->getList(null, 'name', null, false);
    }
    
    public function developerAction() {
    	$this->view->headScript()->appendFile('/public/jquery.tablesorter/jquery.tablesorter.js');
    	
    	$developer = $this->getRequest()->getParam('name');
    	$this->view->pageTitle = "Featured videogames developed by $developer";
    	$this->view->headTitle()->prepend("Featured videogames developed by $developer");
    	$this->view->headMeta()->setName('keywords', Zend_Registry::get('siteKeywords') . ', developer, ' . $developer);
    	$this->view->headMeta()->setName('description', "videogames developed by $developer software studios and featured by the bitgrabbers");
    	$this->view->developer = $developer;
    	
    	$this->view->items = $this->_mapper->fetchAll(array('publisher' => $developer), 'name', false);
    }

    public function createAction() {
    	$this->view->pageTitle = "New game";
    	$this->view->headTitle()->prepend('New game');
		parent::createAction();	
    }

    public function editAction() {
    	$this->view->pageTitle = "Edit game";
    	$this->view->headTitle()->prepend('Edit game');
    	parent::editAction();
    }
    
    public function showAction() {
    	$id = $this->getRequest()->getParam('id');
    	$title = $this->getRequest()->getParam('title');
    	$this->view->game = $this->_mapper->find($id);
    	$urlyfiedTitle = $this->view->game->urlify('name');
    	
    	if ($urlyfiedTitle != $title) {
    		$router = Zend_Controller_Front::getInstance()->getRouter();
    		$url = $router->assemble(array('id' => $id, 'title' => $urlyfiedTitle), 'games');
    		$this->redirect($url);
    	} else {
    		$this->view->headLink()->prependStylesheet(Zend_Registry::get('cssRelPath') . 'tablesorter.css');
    		$this->view->headScript()->appendFile('/public/jquery.tablesorter/jquery.tablesorter.js');
    		$this->view->screenshots = $this->view->game->getScreenshots();
    		$this->view->headTitle()->prepend($this->view->game->name);
    		$this->view->pageTitle = $this->view->game->name . ' screenshots';
    		$this->view->headMeta()->setName('keywords', Zend_Registry::get('siteKeywords') . ', ' . implode(', ', array($this->view->game->name, )));
    		$this->view->headMeta()->setName('description', $this->view->game->name . ' is a ' . $this->view->game->description . '. These are the screenshots taken by the bitgrabbers!');
    	}
    }
}