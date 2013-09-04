<?php

class Application_Model_User extends Common_ModelAbstract implements Application_Model_UserInterface {
	protected $_id;
    protected $_username;
    protected $_role;
    protected $_salt;
    protected $_password;
    protected $_hashedPassword;
    protected $_email;
    protected $_createdOn;
    protected $_updatedOn;
    
    public function __construct(array $options = null) {
		if (array_key_exists('password', $options)) {
			$this->setHashedPassword();
		}
		$this->_mapperType = "userMapper";
		parent::__construct($options);
    }
    
    public function setSalt() {
    	$this->_salt = md5($this->createSalt());
    }
    
    public function setPassword($password) {
    	$this->_password = $password;
    	$this->setHashedPassword();
    }

    public function setHashedPassword() {
    	$this->createSalt();
    	$this->_hashedPassword = sha1($this->_password . $this->salt);
    }
    
    private function createSalt() {
    	$salt = '';
    	for ($i = 0; $i < 50; $i++) {
    		$salt .= chr(rand(33, 126));
    	}
    	$this->_salt = $salt;
    	return $salt;
    }
    
    public function toArray() {
    	$result = array(
    			'id' => $this->id,
    			'username' => $this->username,
    			'role' => $this->role,
    			'email' => $this->email,
    			'hashedPassword' => $this->hashedPassword,
    			'salt' => $this->salt,
    			'createdOn' => $this->createdOn,
    			'updatedOn' => $this->updatedOn
    	);
    	return $result;
    }
}

