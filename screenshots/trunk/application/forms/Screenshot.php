<?php

class Application_Form_Screenshot extends Zend_Form {

    public function init() {
        // Set the method for the form to POST
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        
        $id = $this->createElement('hidden', 'id');
        $id->setRequired(FALSE);
        $id->setAttrib('size', 4);
        $id->addFilter('Digits');
        $id->addValidator('Digits');
        $this->addElement($id);
        
        $pageTitle = $this->createElement('text', 'pageTitle');
        $pageTitle->setLabel('Screenshot title:');
        $pageTitle->setRequired(TRUE);
        $pageTitle->setAttrib('size', 40);
        $pageTitle->addFilter('StringTrim');
        $pageTitle->addValidator('StringLength', FALSE, array(3, 80));
        $this->addElement($pageTitle);
        
        $gameId = new Zend_Form_Element_Select('gameId');
        $gameId->setLabel('Game: ')
               ->setRequired(true);
        $gameList = Zend_Registry::get('gameMapper')->fetchAll(array(), $order = 'name');
        foreach ($gameList as $game) {
        	$gameId->addMultiOption($game->id, $game->name);
        }
        $this->addElement($gameId);
        
        $description = $this->createElement('textarea', 'description');
        $description->setLabel('Description:');
        $description->setRequired(TRUE);
        $description->setAttrib('cols',40);
        $description->setAttrib('rows',10);
        $description->addFilter('StringTrim');
        $this->addElement($description);
        
        $tags = new Application_Form_Element_TagsMultiCheckbox('tags');
        $tags->setLabel('Tags:');
        $this->addElement($tags);
        
        $published = new Zend_Form_Element_Checkbox('published');
        $published->setLabel('Published: ')
        		  ->addValidator('NotEmpty')
        		  ->setValue(true);
        $this->addElement($published);
        
        $pubDate = $this->createElement('text', 'pubDate');
        $pubDate->setLabel('Publication date (yyyy-mm-dd):');
        $pubDate->setRequired(TRUE);
        $pubDate->setAttrib('size', 10);
        $pubDate->addFilter('StringTrim');
        $date = Zend_Date::now();
        $pubDate->setValue($date->get('yyyy-MM-dd') );
        $pubDate->addValidator('Date', FALSE, array('format' => 'yyyy-MM-dd'));
        $pubDate->class = "datePicker";
        $this->addElement($pubDate);
        
        $resolution00 = $this->createElement('text', 'resolution00');
        $resolution00->setLabel('Screenshot:');
        $resolution00->setDescription('<a href="javascript:mcImageManager.browse({fields : \'resolution00\', relative_urls : true });">[MCImageManager]</a>');
        $resolution00->getDecorator('Description')->setOption('escape', false);
        $resolution00->setRequired(TRUE);
        $resolution00->setAttrib('size', 40);
        $resolution00->addFilter('StringTrim');
        $resolution00->addValidator('StringLength', FALSE, array(3, 80));
        $this->addElement($resolution00);
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
        		'ignore'   => true,
        		'label'    => 'Submit',
        ));
    }
}

