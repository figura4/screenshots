<?php

class IndexController extends Common_ControllerAbstract {
    public function init() {
    	
    }

    public function indexAction() {
    	$page = $this->getRequest()->getParam('page');
    	$page = ($page == null || $page == '1') ? '' : " - page $page";
    	$this->view->headTitle()->set(Zend_Registry::get('siteName') . ' - ' . Zend_Registry::get('siteSlogan') . $page);
    	$this->view->headMeta()->setName('description', Zend_Registry::get('siteDescription') . $page);
    	$paginator = Zend_Registry::get('screenshotMapper')->fetchAll(array('published' => '1', 'pubDate' => Zend_Date::now()), 'createdOn DESC', null, true, 5);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page'));
		$this->view->paginator = $paginator;
		$this->view->pageTitle = Zend_Registry::get('siteSlogan') . $page;
    }
    
    public function aboutAction() {
    	$this->view->pageTitle = "About the bitgrabbers";
    	$this->view->headTitle()->prepend('About the bitgrabbers');
    	$form = new Application_Form_Contact();
    	 
    	$request = $this->getRequest();
    	$post = $request->getPost(); // This contains the POST params
    	 
    	if ($request->isPost()) {
    		if ($form->isValid($post)) {
    			$message = 'From: ' . $post['email'] . chr(10) . 'Message: ' . $post['message'];
    			mail(Zend_Registry::get('adminMail'), 'Message from bitgrabbers.com', $message);
    			return $this->_helper->redirector('msgsent');
    		}
    	}
    	 
    	$this->view->form = $form;
    	
    	$this->view->headMeta()->setName('keywords', Zend_Registry::get('siteKeywords') . ', about');
    	$this->view->headMeta()->setName('description', "information and contacts for the bitgrabbers");
    }
    
    public function msgsentAction() {
    	
    }
    
    public function linksAction() {
    	$this->view->pageTitle = "Links";
    	$this->view->headTitle()->prepend('Links');
    	$this->view->headMeta()->setName('keywords', Zend_Registry::get('siteKeywords') . ', links');
    	$this->view->headMeta()->setName('description', "links for the bitgrabbers");
    }
    
    public function rssAction() {
    	$feedGenerator = new Application_Model_RssFeedGenerator();
    	$feed = $feedGenerator->getEmbeddedImagesFeed();
    	header('Content-type: text/xml');
    	
    	echo $feed->saveXML();
    	
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    } 
    
    public function sitemapAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $this->getResponse()->setHeader('Content-Type', 'text/xml; charset=utf-8');
        
        $sitemap = new Application_Model_Sitemap();
        
        $this->view->navigation($sitemap->getSitemap());
        echo $this->view->navigation()->sitemap();
    }
}