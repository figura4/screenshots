<?php

class Application_Model_AclRoles extends Zend_Acl
{
	public function __construct()
	{
		// add the roles
		$this->addRole(new Zend_Acl_Role('guest'));
		$this->addRole(new Zend_Acl_Role('user'), 'guest');
		$this->addRole(new Zend_Acl_Role('admin'), 'user');

		// add the resources
		$this->addResource(new Zend_Acl_Resource('index'));
		$this->addResource(new Zend_Acl_Resource('error'));
		$this->addResource(new Zend_Acl_Resource('game'));
		$this->addResource(new Zend_Acl_Resource('screenshot'));
		$this->addResource(new Zend_Acl_Resource('tag'));
		$this->addResource(new Zend_Acl_Resource('user'));
		$this->addResource(new Zend_Acl_Resource('social'));
		$this->addResource(new Zend_Acl_Resource('favicon.ico'));

		// set up the access rules
		$this->allow(null, array('index', 'error'));

		// a guest can only read content and login
		$this->allow('guest', 'index', array('index', 'rss'));
		$this->allow('guest', 'user', array('index', 'login', 'logout'));
		$this->allow('guest', 'error', array('index', 'noauth', 'error'));
		$this->allow('guest', 'screenshot', array('show', 'rate', 'list', 'download'));
		$this->allow('guest', 'game', array('show', 'list', 'developer'));
		$this->allow('guest', 'tag', array('show', 'list'));

		// cms users can also work with content
		$this->allow('user', 'game', array('create', 'edit', 'delete', 'admin'));
		$this->allow('user', 'screenshot', array('create', 'edit', 'delete', 'admin'));
		$this->allow('user', 'tag', array('create', 'edit', 'delete', 'list', 'admin'));

		// administrators can do anything
		$this->allow('admin', null);
	}
}