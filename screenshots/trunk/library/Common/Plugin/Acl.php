<?php

class Common_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	protected $_acl;

	public function __construct()
	{
		$this->acl = new Application_Model_AclRoles();
	}

	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
			$role = strtolower($identity->role);
		} else {
			$role = 'guest';
		}

		$controller = $request->controller;
		$action = $request->action;
		
		if (!($this->acl->has($controller))) {
			$request->setControllerName('error');
			$request->setActionName('noauth');
		} else {
			if (!$this->acl->isAllowed($role, $controller, $action)) {
				if ($role == 'guest') {
					$request->setControllerName('user');
					$request->setActionName('login');
				} else {
					$request->setControllerName('error');
					$request->setActionName('noauth');
				}
			}
		}
	}
}