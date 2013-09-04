<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload() {
		$autoLoader = Zend_Loader_Autoloader::getInstance();
		$autoLoader->registerNamespace('Common_');
	}
	
	protected function _initDoctype() {
		$this->bootstrap('view');
		$this->bootstrap('GlobalParams');
		$view = $this->getResource('view');
		
		$view->doctype('XHTML1_STRICT');
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8')
					     ->appendHttpEquiv('Content-Language', 'en-US');
		
		$view->headMeta()->appendName('keywords', Zend_Registry::get('siteKeywords'));
		$view->headMeta()->appendName('author', Zend_Registry::get('siteAuthor'));
		$view->headMeta()->appendName('description', Zend_Registry::get('siteDescription'));
		
		$view->headTitle()->setSeparator(' - ');
		$view->headTitle('BitGrabbers');
		
		$view->headLink()->appendStylesheet(Zend_Registry::get('cssRelPath') . 'struttura.css');
		$view->headLink()->appendStylesheet(Zend_Registry::get('cssRelPath') . 'dropdown2liv.css');
		$view->headLink()->appendStylesheet('http://fonts.googleapis.com/css?family=Cuprum');
		$view->headLink()->headLink(array('rel' => 'shortcut icon', 'href' => '/public/immagini/favicon.ico'), 'PREPEND');
		$view->headLink()->appendAlternate('/rss/', 'application/rss+xml', 'RSS Feed');
	}
	
	protected function _initJavascript() {
		$this->bootstrap('view');
		$view = $this->getResource('view'); 

		$view->headScript()->appendFile('/public/rateit/src/jquery.rateit.min.js');
		
		$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
		
		$view->jQuery()->enable()
					->setVersion('1.8.3')
					->setUiVersion('1.9.2')
					->addStylesheet('https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/ui-lightness/jquery-ui.css')
					->uiEnable();
		
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
	}
	
	protected function _initRouter() {
		$frontController = Zend_Controller_Front::getInstance();
		$router = $frontController->getRouter();
		
		$route = new Zend_Controller_Router_Route(
				'page/:page',
				array(
						'controller' => 'index',
						'action'     => 'index'
				)
		);
		$router->addRoute('home', $route);
		
		$route = new Zend_Controller_Router_Route(
				'screenshot/:id/:title',
				array(
						'controller' => 'screenshot',
						'action'     => 'show'
				)
		);
		$router->addRoute('screenshots', $route);
		
		$route = new Zend_Controller_Router_Route(
				'developer/:name',
				array(
						'controller' => 'game',
						'action'     => 'developer'
				)
		);
		$router->addRoute('developer', $route);
		
		$route = new Zend_Controller_Router_Route(
				'game/:id/:title',
				array(
						'controller' => 'game',
						'action'     => 'show'
				)
		);
		$router->addRoute('games', $route);

		$route = new Zend_Controller_Router_Route(
				'tag/:id/:title',
				array(
						'controller' => 'tag',
						'action'     => 'show'
				)
		);
		$router->addRoute('tags', $route);
		
		
		$route = new Zend_Controller_Router_Route_Static(
				'about',
				array('controller' => 'index', 'action' => 'about')
		);
		$router->addRoute('about', $route);
		
		$route = new Zend_Controller_Router_Route_Static(
				'contact',
				array('controller' => 'index', 'action' => 'contact')
		);
		$router->addRoute('contact', $route);
		
		$route = new Zend_Controller_Router_Route_Static(
				'links',
				array('controller' => 'index', 'action' => 'links')
		);
		$router->addRoute('links', $route);
		
		$route = new Zend_Controller_Router_Route_Static(
				'rss',
				array('controller' => 'index', 'action' => 'rss')
		);
		$router->addRoute('rss', $route);
		
		$route = new Zend_Controller_Router_Route_Static(
				'sitemap',
				array('controller' => 'index', 'action' => 'sitemap')
		);
		$router->addRoute('sitemap', $route);
	}
	
	protected function _initLogger() {
		$writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . "/../logs/application.log");
		$logger = new Zend_Log($writer);
		Zend_Registry::set("logger", $logger);
	}
	
	protected function _initMappers() {
		$gameMapper = new Application_Model_GameMapper();
		Zend_Registry::set("gameMapper", $gameMapper);
		
		$screenshotMapper = new Application_Model_ScreenshotMapper();
		Zend_Registry::set("screenshotMapper", $screenshotMapper);
		
		$tagMapper = new Application_Model_TagMapper();
		Zend_Registry::set("tagMapper", $tagMapper);
		
		$userMapper = new Application_Model_UserMapper();
		Zend_Registry::set("userMapper", $userMapper);
	}
	
	protected function _initGlobalParams() {
		$this->bootstrap('view');
		$view = $this->getResource('view');
		
		$globalParams = $this->getOption('globalParams');
		Zend_Registry::set('siteName', $globalParams['siteName']);
		Zend_Registry::set('siteDescription', $globalParams['siteDescription']);
		Zend_Registry::set('siteSlogan', $globalParams['siteSlogan']);
		Zend_Registry::set('siteAuthor', $globalParams['siteAuthor']);
		Zend_Registry::set('siteKeywords', $globalParams['siteKeywords']);
		Zend_Registry::set('siteBaseUrl', $view->serverUrl());
		Zend_Registry::set('adminMail', $globalParams['adminMail']);
		Zend_Registry::set('imagesRelPath', $globalParams['imagesRelPath']);
		Zend_Registry::set('screenshotsRelPath', $globalParams['screenshotsRelPath']);
		Zend_Registry::set('smallThmubnailsRelPath', $globalParams['smallThmubnailsRelPath']);
		Zend_Registry::set('largeThmubnailsRelPath', $globalParams['largeThmubnailsRelPath']);
		Zend_Registry::set('cssRelPath', $globalParams['cssRelPath']);
		Zend_Registry::set('itemsInNavMenu', $globalParams['itemsInNavMenu']);
		Zend_Registry::set('twitterUsername', $globalParams['twitterUsername']);
		Zend_Registry::set('twitterAccessToken', $globalParams['twitterAccessToken']);
		Zend_Registry::set('twitterAccessTokenSecret', $globalParams['twitterAccessTokenSecret']);
		Zend_Registry::set('twitterConsumerKey', $globalParams['twitterConsumerKey']);
		Zend_Registry::set('twitterConsumerKeySecret', $globalParams['twitterConsumerKeySecret']);
	}
}

