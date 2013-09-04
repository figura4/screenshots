<?php

class Application_Model_Game extends Common_ModelAbstract implements Application_Model_GameInterface {
	protected $_id;
    protected $_description;
    protected $_name;
    protected $_publisher;
    protected $_year;
    protected $_order;
    protected $_createdOn;
    protected $_updatedOn;
    
   	public function __construct(array $options = null) {
   		$this->_mapperType = "gameMapper";	
   		parent::__construct($options);
   	}
    
    public function getScreenshots($limit = null) {
    	return $this->_mapper->getGameScreenshots($this, true, $limit);
    }
    
    public function getScreenshotsNumber() {
    	return $this->_mapper->getGameScreenshotsNumber($this->id, true);
    }
    
    public function toArray() {
    	$result = array(
    				'id' => $this->id,
    				'description' => $this->description,
    				'name' => $this->name,
    				'publisher' => $this->publisher,
    				'year' => $this->year,
    				'order' => $this->order,
    				'createdOn' => $this->createdOn,
    				'updatedOn' => $this->updatedOn
    			);
    	return $result;
    }
}
