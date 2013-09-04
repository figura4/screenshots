<?php

class Application_Form_UserLogin extends Zend_Form
{
	public function init()
	{
		$username = $this->createElement('text', 'username');
		$username->setLabel('Username:');
		$username->setRequired(TRUE);
		$username->setAttrib('size', 20);
		$username->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => false)));
		$username->addValidator('StringLength', FALSE, array(5, 20));
		$this->addElement($username);

		$this->addElement('password', 'password', array(
				'filters'    => array('StringTrim', 'StripTags'),
				'validators' => array(
						array('StringLength', true, array(6, 128))
				),
				'required'   => true,
				'label'      => 'Password:',
		));
		
		$this->addElement('submit', 'submit', array(
				'ignore'   => true,
				'label'    => 'Submit',
		));
	}
}