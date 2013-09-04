<?php

class Application_Form_User extends Zend_Form {
    public function init() {
        $this->setMethod('post');
        
        $id = $this->createElement('hidden', 'id');
        $id->setRequired(FALSE);
        $id->setAttrib('size', 4);
        $id->addFilter('Digits');
        $id->addValidator('Digits');
        $this->addElement($id);
        
        $username = $this->createElement('text', 'username');
        $username->setLabel('Username:');
        $username->setRequired(TRUE);
        $username->setAttrib('size', 40);
        $username->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => false)));
        $username->addValidator('StringLength', FALSE, array(5, 20));
        //$username->addValidator(new Common_Validator_DuplicatedUser(), FALSE);
        $this->addElement($username);
        
        $roles = new Application_Form_Element_RolesSelect('role');
        $this->addElement($roles);
        
        $email = $this->createElement('text', 'email');
        $email->setLabel('Email:');
        $email->setRequired(FALSE);
        $email->setAttrib('size', 40);
        $email->addValidator('EmailAddress');
        $this->addElement($email);

        $this->addElement('password', 'password', array(
        		'filters'    => array('StringTrim', 'StripTags'),
        		'validators' => array(
        				array('StringLength', true, array(6, 128))
        		),
        		'required'   => true,
        		'label'      => 'Password',
        ));
        
        $this->addElement('password', 'passwordVerify', array(
        		'filters'    => array('StringTrim', 'StripTags'),
        		'validators' => array(
        				new Common_Validator_PasswordVerification,
        		),
        		'required'   => true,
        		'label'      => 'Confirm password',
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Submit',
        ));
    }
}

