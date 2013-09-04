<?php

class Application_Form_Element_TagsMultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
	public function __construct($name = 'tags', $screenshotId = null) {
		parent::__construct($name);
		$this->addOptionsFromDatabase();
		if (!is_null($screenshotId))
			$this->setSelectedOptions($screenshotId);
	}

	public function addOptionsFromDatabase() {
		$tags = Zend_Registry::get('tagMapper')->fetchAll(array(), 'name');
		
		foreach($tags as $tag) {
			$this->addMultiOption($tag->id, $tag->name);
		}
	}
	
	public function setSelectedOptions($screenshotId) {
		$mapper = Zend_Registry::get('screenshotMapper');
		$tags = $mapper->getScreenshotTags($screenshotId);
		$setTags = array();
		
		foreach($tags as $tag) {
			$setTags[] = $tag->id;
		}
		$this->setValue($setTags);
	}
}