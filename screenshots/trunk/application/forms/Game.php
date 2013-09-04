<?php

class Application_Form_Game extends Zend_Form {
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
        $name->setLabel('Game title:');
        $name->setRequired(TRUE);
        $name->setAttrib('size', 40);
        $name->addFilter('StringTrim');
        $name->addValidator('StringLength', FALSE, array(3, 80));
        $this->addElement($name);
        
        $publisher = $this->createElement('text', 'publisher');
        $publisher->setLabel('Developer:');
        $publisher->setRequired(TRUE);
        $publisher->setAttrib('size', 40);
        $publisher->addFilter('StringTrim');
        $publisher->addValidator('StringLength', FALSE, array(3, 80));
        $this->addElement($publisher);
        
        $description = $this->createElement('textarea', 'description');
        $description->setLabel('Description:');
        $description->setRequired(TRUE);
        $description->setAttrib('cols',40);
        $description->setAttrib('rows',10);
        $description->addFilter('StringTrim');
        $this->addElement($description);
        
        $year = $this->createElement('text', 'year');
        $year->setLabel('Release year:');
        $year->setRequired(FALSE);
        $year->setAttrib('size', 4);
        //$year->addFilter('Digits');
        $year->addValidator('StringLength', FALSE, array(4, 4));
        $year->addValidator('Digits');
        $this->addElement($year);
        
        $order = $this->createElement('text', 'order');
        $order->setLabel('Nav menu order:');
        $order->setAttrib('size', 4);
        $order->addFilter('StringTrim');
        $order->addValidator('Digits');
        $order->setRequired(TRUE);
        $order->setValue('1000');
        $this->addElement($order);
 
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Submit',
        ));
    }
}

