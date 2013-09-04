<?php

class Zend_View_Helper_FriendlyUrl extends Zend_View_Helper_Abstract {
	public function friendlyUrl ($object, $type) {
		switch ($type) { 
			case 'screenshot': 
				$title = 'pageTitle';
				$route = 'screenshots';
				$controller = 'screenshot';
				break;
				
			case 'game': 
				$title = 'name';
				$route = 'games';
				$controller = 'game';	
				break;
				
			default:
				$title = 'name';
				$route = 'tags';
				$controller = 'tag';
				break;
		}
		
		$title = $object->urlify($title);
		$router = Zend_Controller_Front::getInstance()->getRouter();
		$url = $router->assemble(array('id' => $object->id, 'title' => $title), $route);
		
		return $url;
	}
}