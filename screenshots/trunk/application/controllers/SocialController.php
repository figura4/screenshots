<?php

class SocialController extends Zend_Controller_Action {
    public function updateTwitterStatusAction() {
    	$screenshotId = $this->getRequest()->getParam('id');
    	$screenshot = Zend_Registry::get('screenshotMapper')->find($screenshotId);
    	$game = $screenshot->getGame();
    	$twitter = new Application_Model_Twitter();
    	$message = 'Posted new screenshot for ' . $game->name;
    	$twitter->updateStatus($message);
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    }
}
    