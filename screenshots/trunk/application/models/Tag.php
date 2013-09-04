<?php

class Application_Model_Tag extends Common_ModelAbstract implements Application_Model_TagInterface {
	protected $_id;
	protected $_name;
	protected $_order;
	protected $_description;
	
	public function __construct(array $options = null) {
		$this->_mapperType = "tagMapper";
		parent::__construct($options);
	}
	
	public function getScreenshots() {
		return $this->_mapper->getTagScreenshots($this);
	}
	
	public function toArray() {
		$result = array(
				'id' => $this->id,
				'name' => $this->name,
				'description' => $this->description,
				'order' => $this->order
		);
		return $result;
	}
}

