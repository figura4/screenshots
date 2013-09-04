<?php

class Application_Model_RssFeedGenerator {
	protected $_mapper;
	
	public function __construct() {
		$this->_mapper = Zend_Registry::get('screenshotMapper');
	}
	
    public function getEmbeddedImagesFeed($numberOfEntries = 5) {
    	$contents = $this->_mapper->getRecentScreenshots($numberOfEntries);
    	 
    	$contents_array = array();
    	 
    	foreach ($contents as $content) {
    		$router = Zend_Controller_Front::getInstance()->getRouter();
    		$url    = $router->assemble(array('id' => $content->id, 'title' => $content->urlify('pageTitle')), 'screenshots');
    
    		$element = array();
    		$element['title'] = $content->getGame()->name . ' - ' . $content->pageTitle;
    		$element['description'] = '<p>' . ($content->description == NULL) ? '' : $content->description . '/<p>';
    		$element['description'] .= '<p><img src="' . Zend_Registry::get('siteBaseUrl') . Zend_Registry::get('largeThmubnailsRelPath') . 'thmbl_' . $content->resolution00 . '" alt="' . $content->pageTitle . '" title="' . $content->pageTitle . '" /></p>';
    		$element['link'] = Zend_Registry::get('siteBaseUrl') . $url;
    		$element['guid'] = Zend_Registry::get('siteBaseUrl') . $url;
    		$element['lastUpdate'] = strtotime($content->updatedOn);
    		
    		$image = Zend_Registry::get('screenshotsRelPath') . $content->resolution00;
    		list($width, $height, $type, $attr) = getimagesize('./' . $image);
    		$element['enclosure'] = array(array(
    				'url' => Zend_Registry::get('siteBaseUrl') . $image,
    				'type' => image_type_to_mime_type($type),
    				'length' => filesize('./' . $image)
    		));
    		
    		array_push($contents_array, $element);
    	}
    
    	$feedData = array(
    			'title' => Zend_Registry::get('siteName'),
    			'description' => Zend_Registry::get('siteDescription'),
    			'link' => Zend_Registry::get('siteBaseUrl'),
    			'charset' => 'utf8',
    			'entries' => $contents_array
    	);
    	return Zend_Feed::importArray($feedData, 'rss');
    }
}