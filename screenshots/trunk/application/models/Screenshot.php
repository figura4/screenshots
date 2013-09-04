<?php

class Application_Model_Screenshot extends Common_ModelAbstract implements Application_Model_ScreenshotInterface {
	protected $_id;
	protected $_gameId;
	protected $_resolution00;
	protected $_resolution01;
	protected $_resolution02;
	protected $_resolution03;
	protected $_resolution04;
	protected $_resolution05;
	protected $_resolution06;
	protected $_resolution07;
    protected $_description;
    protected $_pageTitle;
    protected $_userId;
    protected $_published;
    protected $_votes;
    protected $_ratingSum;
    protected $_pubDate;
    protected $_createdOn;
    protected $_updatedOn;
 
    public function __construct(array $options = null) {
    	$this->_mapperType = "screenshotMapper";
    	parent::__construct($options);
    }
    
    public function getTags() {
	   	$tagList = $this->_mapper->getDbTable()
	   	                         ->find($this->id)
	   	                         ->current()
	   	                         ->findManyToManyRowset('Application_Model_DbTable_Tags', 'Application_Model_DbTable_TagsScreenshots')
	   	                         ->toArray();
		$tags = array();
		foreach ($tagList as $tag) {
			array_push($tags, new Application_Model_Tag($tag));
		}
		return $tags;
    }
    
    public function setTags($tags = array()) {
    	$this->_mapper->setScreenshotTags($this->id, $tags);
    }
    
    public function getGame() {
    	$mapper = Zend_Registry::get('gameMapper');
    	$game = $mapper->find($this->gameId);
    	return $game;
    }
    
    public function getAverageRating() {
    	if ($this->votes >0 ) {
    		return round($this->ratingSum / $this->votes, 2);
    	} else {
    		return 0;
    	}
    }
    
    public function saveRating($vote = 0) {
    	$this->_ratingSum += $vote;
    	$this->_votes++;
    	$this->_mapper->save($this->toArray());
    }
    
    public function getUser() {
    	$mapper = Zend_Registry::get('userMapper');
    	$user = $mapper->find($this->userId);
    	return $user;
    }
    
    public function toArray() {
    	$result = array(
    			'id' => $this->id,
    			'gameId' => $this->gameId,
    			'pageTitle' => $this->pageTitle,
    			'description' => $this->description,
    			'resolution00' => $this->resolution00,
    			'resolution01' => $this->resolution01,
    			'resolution02' => $this->resolution02,
    			'resolution03' => $this->resolution03,
    			'resolution04' => $this->resolution04,
    			'resolution05' => $this->resolution05,
    			'resolution06' => $this->resolution06,
    			'resolution07' => $this->resolution07,
    			'published'    => $this->published,
    			'votes'        => $this->_votes,
    			'ratingSum'    =>$this->_ratingSum,
    			'userId'       => $this->userId,
    			'pubDate'      => $this->pubDate,
    			'createdOn'    => $this->createdOn,
    			'updatedOn'    => $this->updatedOn
    	);
    	return $result;
    }
}

