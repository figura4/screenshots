<?php

class Application_Model_GameMapper extends Common_ModelMapperAbstract implements Application_Model_GameMapperInterface {
	function __construct() {
		parent::__construct();
		$this->_dbTableType = 'Application_Model_DbTable_Games';
		$this->_MappedModelType = 'Application_Model_Game';
	}
	
	public function save(array $data = array()) {
		$data["createdOn"] = new Zend_Db_Expr('NOW()');
		return $this->saveToDb($data);
	}
	
	public function getGameScreenshots(Application_Model_GameInterface $game, $published = true, $limit = null) {
		$table = Zend_Registry::get('screenshotMapper')->getDbTable();
		
		$select = $table->select()->where('gameId = ?', $game->id)
					              ->order('createdOn DESC');
		if ($published) {
			$select->where('published = 1')
				   ->where('pubDate <= NOW()');
		}	
	
		if (!is_null($limit))
			$select->limit($limit);
		
		$rowSet = $table->fetchAll($select);
		$screenshots = array();
		foreach ($rowSet as $screenshot) {
			array_push($screenshots, new Application_Model_Screenshot($screenshot->toArray()));
		}
		return $screenshots;
	}
	
	public function getGameScreenshotsNumber($gameId, $published = true) {
		$mapper = Zend_Registry::get('screenshotMapper');
		 
		$select = $mapper->getDbTable()->select();
		$select->from($mapper->getDbTable(), array('count(*) as quantity'))
			   ->where('gameId = ?', $gameId);
		
		if ($published) {
			$select->where('published = 1')
				   ->where('pubDate <= NOW()');
		}
		
		$rows = $mapper->getDbTable()->fetchAll($select);
	
		return($rows[0]->quantity);
	}
}