<?php

class Application_Form_ChangePassword extends Zend_Form {
    public function init() {
        $this->setMethod('post');
        
        $id = $this->createElement('hidden', 'id');
        $id->setRequired(FALSE);
        $id->setAttrib('size', 4);
        $id->addFilter('Digits');
        $id->addValidator('Digits');
        $this->addElement($id);
        
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