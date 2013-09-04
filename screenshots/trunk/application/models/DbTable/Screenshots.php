<?php

class Application_Model_DbTable_Screenshots extends Zend_Db_Table_Abstract {
    protected $_name = 'screenshots';
    protected $_primary = 'id';
    protected $_referenceMap    = array(
    		'Game' => array(
    				'columns'           => 'gameId',
    				'refTableClass'     => 'Application_Model_DbTable_Games',
    				'refColumns'        => 'id'
    		),
    		'User' => array(
    				'columns'           => 'userId',
    				'refTableClass'     => 'Application_Model_DbTable_Users',
    				'refColumns'        => 'id'
    		)
    );
}

