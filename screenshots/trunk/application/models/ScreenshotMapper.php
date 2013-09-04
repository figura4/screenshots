<?php

class Application_Model_ScreenshotMapper extends Common_ModelMapperAbstract implements Application_Model_ScreenshotMapperInterface {
	function __construct() {
		parent::__construct();
		$this->_dbTableType = 'Application_Model_DbTable_Screenshots';
		$this->_MappedModelType = 'Application_Model_Screenshot';
		$this->_TagsScreenshotsTableType = 'Application_Model_DbTable_TagsScreenshots';
	}
	
	public function save(array $data = array()) {
		//$data["published"] = (array_key_exists('published', $data)) ? 1 : 0;
		$data["createdOn"] = new Zend_Db_Expr('NOW()');
		
		return $this->saveToDb($data);
	}
	
	public function getScreenshotTags($screenshotId) {
		$tagList = $this->getDbTable()->find($screenshotId)->current()->findManyToManyRowset('Application_Model_DbTable_Tags', 'Application_Model_DbTable_TagsScreenshots')->toArray();
		$tags = array();
		foreach ($tagList as $tag) {
			array_push($tags, new Application_Model_Screenshot($tag));
		}
		return $tags;
	}
	
	public function setScreenshotTags($screenshotId, $tagsId = array()) {
		$tagsScreenshotsTable = new $this->_TagsScreenshotsTableType();
		$tagsScreenshotsTable->delete('screenshotId = ' . $screenshotId);
		
		foreach ($tagsId as $tagId) {
			$tagsScreenshotsTable->insert(array(
						'tagId'     => $tagId, 
						'screenshotId' => $screenshotId
					)
			);
		}
		return true;
	}
	
	public function getRecentScreenshots($num = 5) {
		$select = $this->getDbTable()->select();
		$select->where('published = ?', '1');
		$select->where('pubDate <= NOW()');
		$select->order('createdOn DESC');
		$rowset = $this->getDbTable()->fetchAll($select);
		//$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
		$screenshotsArray = array();
		
		foreach ($rowset as $row) {
			array_push($screenshotsArray, new Application_Model_Screenshot($row->toArray()));
		}
		
		$adapter = new Zend_Paginator_Adapter_Array($screenshotsArray);
		$paginator = new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($num);
		
		return $paginator;		
	}
}

