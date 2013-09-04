<?php

class ScreenshotController extends Common_ControllerAbstract {
    public function init() {
        $this->_model = 'Application_Model_Screenshot';  			
		$this->_mapper = Zend_Registry::get('screenshotMapper'); 						
		$this->_form['create'] = 'Application_Form_Screenshot';   	
		$this->_form['edit'] = 'Application_Form_Screenshot';   	
		$this->_form['admin'] = 'Application_Form_ScreenshotList';   
		$this->_form['list'] = 'Application_Form_ScreenshotList';   	
    }

    public function createAction() {
    	$this->view->pageTitle = "New screenshot";
    	$this->view->headTitle()->prepend('New screenshot');
    	$this->view->headScript()->appendFile('/public/imagemanager/js/mcimagemanager.js');
    	//$this->view->headScript()->appendFile('/public/tiny_mce/tiny_mce.js');
    	  		
    	$this->view->form = $this->setFormProperties('create');
    	if($this->FormPostedAndValid($this->view->form)) {
    		$data = $this->view->form->getValues();
    		$data['resolution00'] = basename($this->view->form->resolution00->getValue());
    		$auth = Zend_Auth::getInstance();
    		$data['userId'] = $auth->getIdentity()->id;
    		$data['ratingSum'] = 4;
    		$data['votes'] = 1;
    		$tags = $data['tags'];
    		unset($data['tags']);
    		$id = $this->_mapper->save($data);
    		$this->_mapper->setScreenshotTags($id, $tags);
    		return $this->_helper->redirector('admin');
    	}
    }

    public function editAction() {
    	$this->view->pageTitle = "Edit screenshot";
    	$this->view->headTitle()->prepend('Edit screenshot');
    	$this->view->headScript()->appendFile('/public/imagemanager/js/mcimagemanager.js');
        $this->view->form = $this->setFormProperties('edit');
        $id = $this->getRequest()->getParam('id');
        $this->view->form->getElement('tags')->setSelectedOptions($id);
    	if($this->FormPostedAndValid($this->view->form)) {
    		$data = $this->view->form->getValues();
    		$data['resolution00'] = basename($this->view->form->resolution00->getValue());
    		$auth = Zend_Auth::getInstance();
    		$data['userId'] = $auth->getIdentity()->id;
    		$tags = $data['tags'];
    		unset($data['tags']);
    		$id = $this->_mapper->save($data);
    		$this->_mapper->setScreenshotTags($id, $tags);
    		return $this->_helper->redirector('admin');
    	}
    }
    
    public function showAction() {
    	$id = $this->getRequest()->getParam('id');
    	$title = $this->getRequest()->getParam('title');
    	$this->view->screenshot = $this->_mapper->find($id);
    	$urlyfiedTitle = $this->view->screenshot->urlify('pageTitle');
    	
    	if ($urlyfiedTitle != $title) {
    		$router = Zend_Controller_Front::getInstance()->getRouter();
    		$url = $router->assemble(array('id' => $id, 'title' => $urlyfiedTitle), 'screenshots');
    		$this->redirect($url);
    	} else {
    		$this->view->headLink()->appendStylesheet(Zend_Registry::get('cssRelPath') . 'scheda_screenshot.css');
    		$this->view->headLink()->appendStylesheet('/public/rateit/src/rateit.css');

    		$this->view->headScript()->appendFile('/public/rateit/src/jquery.rateit.min.js');
 
    		$this->view->game = $this->view->screenshot->getGame();
    		$this->view->tags = $this->view->screenshot->getTags();
    	
    		$this->view->headTitle()->prepend($this->view->game->name . ' screenshots: ' . $this->view->screenshot->pageTitle);
    		$this->view->headMeta()->setName('keywords', Zend_Registry::get('siteKeywords') . ', ' . implode(', ', array($this->view->game->name, )));
    		$this->view->headMeta()->setName('description', $this->view->screenshot->description . ' (screenshot taken by the bitgrabbers)');
    		$this->view->pageTitle = $this->view->game->name . ' - ' . $this->view->screenshot->pageTitle;
    	} 
    }  
    
    public function rateAction() {
    	$id = $this->getRequest()->getParam('id');
    	if ($this->checkCookie($id) == false) {
    		$vote = $this->getRequest()->getParam('value');
    		$screenshot = $this->_mapper->find($id);
    		$screenshot->saveRating($vote);	
    		$this->setCookie($id);
    		$message = "you rated this screenshot $vote / 5";
    	} else {
    		$message = 'you already voted today';    	
    	}
    	
    	$this->getResponse()
    		 ->setHeader('Content-Type', 'text/html')
    	     ->appendBody($message);
    	
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    }
    
    public function downloadAction() {
    	$id = $this->getRequest()->getParam('id');
    	$content = $this->_mapper->find($id);
    	
    	$image = Zend_Registry::get('screenshotsRelPath') . $content->resolution00;
    	list($width, $height, $type, $attr) = getimagesize('./' . $image);
    	
    	header('Content-Type: ' . image_type_to_mime_type($type));
    	header('Content-Disposition: attachment; filename="' . $content->resolution00 . '"');
    	
    	readfile('./' . $image);
    	$this->view->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    }
    
    protected function save($data = array()) {
    	$id = parent::save($data);
    	Zend_Registry::get($this->_mapper)->setScreenshotTags($id, $data['tags']);
    }
    
    protected function checkCookie($id) {
    	if (key_exists('screenshotId' . $id, $_COOKIE)) {
    		return true;
    	}
    	return false;
    }
    
    protected function setCookie($id) {
    	$domain = Zend_Controller_Front::getInstance()->getBaseUrl();
    	setcookie('screenshotId' . $id, 1, time() + 60 * 60 * 24, "/", $domain, false, true );
    }
}