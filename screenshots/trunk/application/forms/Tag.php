<?php

class Application_Form_Tag extends Zend_Form {
    public function init() {
        // Set the method for the form to POST
        $this->setMethod('post');
        
        $id = $this->createElement('hidden', 'id');
        $id->setRequired(FALSE);
        $id->setAttrib('size', 4);
        $id->addFilter('Digits');
        $id->addValidator('Digits');
        $this->addElement($id);
        
        $name = $this->createElement('text', 'name');
        $name->setLabel('Tag name:');
        $name->setRequired(TRUE);
        $name->setAttrib('size', 40);
        $name->addFilter('StringTrim');
        $name->addValidator('StringLength', FALSE, array(3, 80));
        //$name->addValidator(new Common_Validator_DuplicatedTag(), FALSE);
        $this->addElement($name);
        
        $description = $this->createElement('textarea', 'description');
        $description->setLabel('Description:');
        $description->setRequired(TRUE);
        $description->setAttrib('cols',40);
        $description->setAttrib('rows',10);
        $description->addFilter('StringTrim');
        $this->addElement($description);
        
        $order = $this->createElement('text', 'order');
        $order->setLabel('Nav menu order:');
        $order->setRequired(FALSE);
        $order->setAttrib('size', 2);
        $order->addFilter('StringTrim');
        $order->addValidator('Digits');
        $this->addElement($order);
 
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Submit',
        ));
    }
}