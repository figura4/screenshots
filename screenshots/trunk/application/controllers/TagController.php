<?php

class TagController extends Common_ControllerAbstract {
    public function init()
    {
    	$this->_model = 'Application_Model_Tag';  	
		$this->_mapper = Zend_Registry::get('tagMapper'); 				
		$this->_form['create'] = 'Application_Form_Tag';   	
		$this->_form['edit'] = 'Application_Form_Tag';   	
		$this->_form['admin'] = 'Application_Form_TagList';   
		$this->_form['list'] = 'Application_Form_TagList';   	
    }
    
	public function adminAction() {
		$this->view->form = $this->setFormProperties('admin');
		
		$sort = 'name';
		$filter = null;
		
		if($this->FormPostedAndValid($this->view->form)) {
			$sort = $this->view->form->getValue('sort');
			$filterFieldValue = $this->view->form->getValue('filter_field');
			$filter[$filterFieldValue] = $this->view->form->getValue('filter');
		}
		
		$this->view->paginator = $this->_mapper->fetchAll($filter, $sort, null, true, 15);
	}
    
    public function showAction() {
    	$id = $this->getRequest()->getParam('id');
    	$title = $this->getRequest()->getParam('title');
    	$this->view->tag = $this->_mapper->find($id);
    	$urlyfiedTitle = $this->view->tag->urlify('name');
    	 
    	if ($urlyfiedTitle != $title) {
    		$router = Zend_Controller_Front::getInstance()->getRouter();
    		$url = $router->assemble(array('id' => $id, 'title' => $urlyfiedTitle), 'tags');
    		$this->redirect($url);
    	} else {
    		$this->view->headLink()->prependStylesheet(Zend_Registry::get('cssRelPath') . 'tablesorter.css');
    		$this->view->headScript()->appendFile('/public/jquery.tablesorter/jquery.tablesorter.js');
    	
    		$this->view->headTitle()->prepend(ucfirst($this->view->tag->name));
    		$this->view->screenshots = $this->view->tag->getScreenshots();
    	 
    		$this->view->headMeta()->setName('keywords', Zend_Registry::get('siteKeywords') . ', ' . implode(', ', array($this->view->tag->name, 'tag')));
    		$this->view->headMeta()->setName('description', $this->view->tag->description);
    		$this->view->pageTitle = ucfirst($this->view->tag->name) . ' screenshots';
    	}
    } 
}





