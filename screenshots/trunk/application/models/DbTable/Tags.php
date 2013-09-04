<?php

class Application_Model_DbTable_Tags extends Zend_Db_Table_Abstract {
    protected $_name = 'tags';
    protected $_primary = 'id';
    /*protected $_referenceMap    = array(
    		'tagsScreenshots' => array(
    				'columns'           => 'tagId',
    				'refTableClass'     => 'Application_Model_DbTable_TagsScreenshots',
    				'refColumns'        => 'id'
    		)
    );*/
}