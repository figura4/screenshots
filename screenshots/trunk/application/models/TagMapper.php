<?php

class Application_Model_TagMapper extends Common_ModelMapperAbstract implements Application_Model_TagMapperInterface {
	function __construct() {
		parent::__construct();
		$this->_dbTableType = 'Application_Model_DbTable_Tags';
		$this->_MappedModelType = 'Application_Model_Tag';
	}
	
	public function save(array $data = array()) {
		return $this->saveToDb($data);
	}
	
	public function getTagScreenshots(Application_Model_TagInterface $tag) {
		$table = $this->getDbTable();
		$select = $table->select()
               		    ->where('published = 1')
				        ->where('pubDate <= NOW()');
		
		$rowset = $table->find($tag->id)->current()->findManyToManyRowset('Application_Model_DbTable_Screenshots', 'Application_Model_DbTable_TagsScreenshots', null, null, $select);
		$screenshots = array();
		foreach ($rowset as $screenshot) {
			array_push($screenshots, new Application_Model_Screenshot($screenshot->toArray()));
		}
		return $screenshots;		
	}
	
	public function tagExsists($tagName) {
		$table = $this->getDbTable();
		$select = $table->select();
		$select->where('name = ?', $tagName);
		$rows = $table->fetchAll($select);
		if (count($rows) > 0) {
			return TRUE;
		} else {	
			return FALSE;
		}
	}
}