<?php

class Common_Validator_DuplicatedUser extends Zend_Validate_Abstract {
    const DUPLICATED = 'duplicated';

    protected $_messageTemplates = array(
        self::DUPLICATED => 'Duplicated user'
    );

    public function isValid($value, $context = null) {
        $value = (string) $value;
        $this->_setValue($value);
		
        $mapper = Zend_Registry::get('userMapper');
        if (!$mapper->userExsists($value)) {
            return true;
        }

        $this->_error(self::DUPLICATED);
        return false;
    }
}