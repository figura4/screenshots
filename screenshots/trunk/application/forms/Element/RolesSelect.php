<?php

class Application_Form_Element_RolesSelect extends Zend_Form_Element_Select
{
	public function __construct($name = 'role') {
		parent::__construct($name);
		$this->addOptions();
		$this->setLabel('Role:');
	}

	public function addOptions() {
		$this->addMultiOption('guest', 'guest');
		$this->addMultiOption('user', 'user');
		$this->addMultiOption('admin', 'admin');
	}
}