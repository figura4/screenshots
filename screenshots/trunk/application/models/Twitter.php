<?php

class Application_Model_Twitter  {
	protected $_username;
	protected $_accessToken;
	protected $_accessTokenSecret;
	protected $_consumerKey;
	protected $_consumerKeySecret;
	
	public function __construct() {
		$this->_username = Zend_Registry::get('twitterUsername');
		$this->_accessToken = Zend_Registry::get('twitterAccessToken');
		$this->_accessTokenSecret = Zend_Registry::get('twitterAccessTokenSecret');
		$this->_consumerKey = Zend_Registry::get('twitterConsumerKey');
		$this->_consumerKeySecret = Zend_Registry::get('twitterConsumerKeySecret');
	}
	
	public function updateStatus($message) {
		$token = new Zend_Oauth_Token_Access();
		
		$token->setParams(array(
				'oauth_token'        => $this->_accessToken,
				'oauth_token_secret' => $this->_accessTokenSecret,
		));
		
		$twitter = new Zend_Service_Twitter(array(
				'username'       => $this->_username,
				'consumerKey'    => $this->_consumerKey,
				'consumerSecret' => $this->_consumerKeySecret,
				'accessToken'    => $token
		));
		
		$response = $twitter->status->update($message);
		Zend_Registry::get('logger')->log('Updating twitter status: ' . $response->toString(), 5);
	}
}