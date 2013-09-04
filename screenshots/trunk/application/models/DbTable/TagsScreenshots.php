<?php

class Application_Model_DbTable_TagsScreenshots extends Zend_Db_Table_Abstract {
    protected $_name = 'tagsScreenshots';
    protected $_referenceMap    = array(
        'Screenshot' => array(
            'columns'           => array('screenshotId'),
            'refTableClass'     => 'Application_Model_DbTable_Screenshots',
            'refColumns'        => array('id')
        ),
        'Tag' => array(
            'columns'           => array('tagId'),
            'refTableClass'     => 'Application_Model_DbTable_Tags',
            'refColumns'        => array('id')
        )
    );
}