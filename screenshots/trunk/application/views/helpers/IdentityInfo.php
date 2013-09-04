<?php

class Zend_View_Helper_IdentityInfo extends Zend_View_Helper_Abstract
{
    protected $_acl;
    protected $_auth;

    public function __construct()
    {
        $this->_acl = new Application_Model_AclRoles();
        $this->_auth = Zend_Auth::getInstance();
    }

    public function identityInfo ($info = 'role')
    {
        if ($this->_auth->hasIdentity()) {
            $identity = $this->_auth->getIdentity();
            return $identity->$info;
        }
        return 'guest';
    }
}