<?php

class Application_Model_Sitemap {
	private $_sitemap;
	
	public function __construct() {
		$tags = Zend_Registry::get('tagMapper')->fetchAll();
		$games = Zend_Registry::get('gameMapper')->fetchAll();
		$screenshots = Zend_Registry::get('screenshotMapper')->fetchAll(array('published' => '1', 'pubDate' => Zend_Date::now()));
		$currentDate = new Zend_Date();
		
		$container = new Zend_Navigation();
		
		$homepage = Zend_Navigation_Page::factory(array(
				'label'      => 'Bitgrabbers',
				'route'      => 'default',
				'action'     => 'index',
				'controller' => 'index'
		));
		$homepage->lastmod = $currentDate->get('YYYY-MM-dd HH:mm:ss');
		$homepage->changefreq = 'daily';
		$homepage->priority = 1;
		$container->addPage($homepage);
		
		foreach ($tags as $tag) {
			$tagPage = Zend_Navigation_Page::factory(array(
					'label'      => $tag->name,
					'route'      => 'tags',
					'params'	 => array(
										'id'    => $tag->id,
										'title' => $tag->urlify('name')
									)
			));
			$tagPage->lastmod = $currentDate->get('YYYY-MM-dd HH:mm:ss');
			$tagPage->changefreq = 'daily';
			$tagPage->priority = 0.6;
			$container->addPage($tagPage);
		}
		//$container->addPage($tagsPage);
		
		$gamesPage = Zend_Navigation_Page::factory(array(
				'label'      => 'Games',
				'route'      => 'default',
				'action'     => 'list',
				'controller' => 'game'
		));
		$gamesPage->lastmod = $currentDate->get('YYYY-MM-dd HH:mm:ss');
		$gamesPage->changefreq = 'daily';
		$gamesPage->priority = 0.9;
		
		foreach ($games as $game) {
			$gamePage = Zend_Navigation_Page::factory(array(
					'label'      => $game->name,
					'route'      => 'games',
					'params'	 => array(
										'id'    => $game->id,
										'title' => $game->urlify('name')
									)
			));
			$gamePage->lastmod = $currentDate->get('YYYY-MM-dd HH:mm:ss');
			$gamePage->changefreq = 'daily';
			$gamePage->priority = 0.8;
			$gamesPage->addPage($gamePage);
		}
		$container->addPage($gamesPage);
		
		foreach ($screenshots as $screenshot) {
			$screenshotPage = Zend_Navigation_Page::factory(array(
					'label'      => $screenshot->pageTitle,
					'route'      => 'screenshots',
					'params'	 => array(
										'id' => $screenshot->id,
										'title' => $screenshot->urlify('pageTitle')
									)
			));
			$screenshotPage->lastmod = $screenshot->createdOn;
			$screenshotPage->changefreq = 'never';
			$screenshotPage->priority = 0.7;
			$container->addPage($screenshotPage);
		}
		
		$aboutPage = Zend_Navigation_Page::factory(array(
				'label'      => 'About',
				'route'      => 'about',
				'action'     => 'about',
				'controller' => 'index'
		));
		$aboutPage->lastmod = $currentDate->get('YYYY-MM-dd HH:mm:ss');
		$aboutPage->changefreq = 'daily';
		$aboutPage->priority = 0.8;
		$container->addPage($aboutPage);
		
		$linksPage = Zend_Navigation_Page::factory(array(
				'label'      => 'Links',
				'route'      => 'links',
				'action'     => 'links',
				'controller' => 'index'
		));
		$linksPage->lastmod = $currentDate->get('YYYY-MM-dd HH:mm:ss');
        $linksPage->changefreq = 'weekly';
        $linksPage->priority = 0.9;
		$container->addPage($linksPage);
		
		$this->_sitemap = $container;
	}
	
	public function getSitemap() {
		return $this->_sitemap;
	}
}