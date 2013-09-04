<?php

class Common_Validator_DuplicatedTag extends Zend_Validate_Abstract {
    const DUPLICATED = 'duplicated';

    protected $_messageTemplates = array(
        self::DUPLICATED => 'Duplicated tag'
    );

    public function isValid($value, $context = null) {
        $value = (string) $value;
        $this->_setValue($value);
		
        $mapper = Zend_Registry::get('tagMapper');
        if (!$mapper->tagExsists($value)) {
            return true;
        }

        $this->_error(self::DUPLICATED);
        return false;
    }
}