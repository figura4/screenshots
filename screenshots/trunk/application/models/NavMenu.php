<?php

class Application_Model_NavMenu {
	private $_navMenu;
	
	public function __construct(array $options = null) {
		$num = null;
		$admin = false;
		if (is_array($options)) {
			array_key_exists('itemsNumber', $options) ? $num = $options['itemsNumber'] : $num = null;
			array_key_exists('admin', $options) ? $admin = $options['admin'] : $admin = false;
		} 

		$tags = Zend_Registry::get('tagMapper')->fetchAll(null, 'order', $num);
		$games = Zend_Registry::get('gameMapper')->fetchAll(null, 'order', $num);
		
		$h1page = Zend_Navigation_Page::factory(array(
				'label'      => '<h1>Titolo pagina completo in tag h1</h1>',
				'route'      => 'default',
				'action'     => 'index',
				'controller' => 'index'
		));
		$h1page->setClass('ultimo');
		
		$tagsPage = Zend_Navigation_Page::factory(array(
				'label'      => 'Tags',
				'route'      => 'default',
				'action'     => 'list',
				'controller' => 'tag'
		));
		
		foreach ($tags as $tag) {
			$tagPage = Zend_Navigation_Page::factory(array(
					'label'      => $tag->name,
					'route'      => 'default',
					'action'     => 'show',
					'controller' => 'tag',
					'params'	 => array('id' => $tag->id)
			));
			$tagsPage->addPage($tagPage);
		}
		
		$gamesPage = Zend_Navigation_Page::factory(array(
				'label'      => 'Games',
				'route'      => 'default',
				'action'     => 'list',
				'controller' => 'game'
		));
		
		foreach ($games as $game) {
			$gamePage = Zend_Navigation_Page::factory(array(
					'label'      => $game->name,
					'route'      => 'default',
					'action'     => 'show',
					'controller' => 'game',
					'params'	 => array('id' => $game->id)
			));
			$gamesPage->addPage($gamePage);
		}
		
		$aboutPage = Zend_Navigation_Page::factory(array(
				'label'      => 'About',
				'route'      => 'about',
				'action'     => 'about',
				'controller' => 'index'
		));
		
		$adminPage = Zend_Navigation_Page::factory(array(
				'label'      => 'Admin',
				'route'      => 'default',
				'action'     => 'admin',
				'controller' => 'screenshot'
		)); 
		
		$ap = Zend_Navigation_Page::factory(array(
				'label'      => 'Games',
				'route'      => 'default',
				'action'     => 'admin',
				'controller' => 'game'
		));
		$adminPage->addPage($ap);
		
		$ap = Zend_Navigation_Page::factory(array(
				'label'      => 'Screenshots',
				'route'      => 'default',
				'action'     => 'admin',
				'controller' => 'screenshot'
		));
		$adminPage->addPage($ap);
		
		$ap = Zend_Navigation_Page::factory(array(
				'label'      => 'Tags',
				'route'      => 'default',
				'action'     => 'admin',
				'controller' => 'tag'
		));
		$adminPage->addPage($ap);
		
		$ap = Zend_Navigation_Page::factory(array(
				'label'      => 'Users',
				'route'      => 'default',
				'action'     => 'admin',
				'controller' => 'user'
		));
		$adminPage->addPage($ap);
		
		$ap = Zend_Navigation_Page::factory(array(
				'label'      => 'Logout',
				'route'      => 'default',
				'action'     => 'logout',
				'controller' => 'user'
		));
		$adminPage->addPage($ap);
		
		$homePage = Zend_Navigation_Page::factory(array(
				'label'      => 'Home',
				'route'      => 'default',
				'action'     => 'index',
				'controller' => 'index'
		));
		
		$linksPage = Zend_Navigation_Page::factory(array(
				'label'      => 'Links',
				'route'      => 'links',
				'action'     => 'links',
				'controller' => 'index'
		));
		
		$contactPage = Zend_Navigation_Page::factory(array(
				'label'      => 'Contacts',
				'route'      => 'contact',
				'action'     => 'contact',
				'controller' => 'index'
		));
		
		$container = new Zend_Navigation();
		$container->addPage($h1page);
		$container->addPage($homePage);
		$container->addPage($gamesPage);
		$container->addPage($tagsPage);
		$container->addPage($linksPage);
		$container->addPage($aboutPage);	

		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity() and $admin) {
			$identity = $auth->getIdentity();
			$role = strtolower($identity->role);
			if ($role == 'admin') {
				$container->addPage($adminPage);
			}
		}
		
		$container->addPage($contactPage);
		
		$this->_navMenu = $container;
	}
	
	public function getMenu() {
		return $this->_navMenu;
	}
}