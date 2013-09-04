<?php

class Application_Form_Contact extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('contact-form');
        
        $this->addElement('text', 'email', array(
            'label' => 'Your e-mail: ',
            'required' => true,
        ));
        $this->getElement('email')->removeDecorator('DtDdWrapper')
                                  ->removeDecorator('HtmlTag');
        
        $this->addElement('textarea', 'message', array(
            'label' => 'Write a message: ',
            'required' => true,
        ));
        $this->getElement('message')->removeDecorator('DtDdWrapper')
                                    ->removeDecorator('HtmlTag')
                                    ->setAttrib('rows', 9);
        
        $this->addElement('submit', 'submit-contact', array(
            'label' => 'Send message',
            'ignore' => true,
        ));
        $this->getElement('submit-contact')->removeDecorator('DtDdWrapper')
                                           ->removeDecorator('HtmlTag');
        

     							 
    }
}