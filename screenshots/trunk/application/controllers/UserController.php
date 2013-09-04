<?php

class UserController extends Common_ControllerAbstract {
    public function init() {
        $this->_model = 'Application_Model_User';  				
		$this->_mapper = Zend_Registry::get('userMapper'); 							
		$this->_form['create'] = 'Application_Form_User';   	
		$this->_form['edit'] = 'Application_Form_User';   		
		$this->_form['admin'] = 'Application_Form_UserList';   	
		$this->_form['login'] = 'Application_Form_UserLogin';   
		$this->_form['changepwd'] = 'Application_Form_ChangePassword';   
    }

    public function createAction() {
    	$this->view->pageTitle = "New user";
    	$this->view->headTitle()->prepend('New user');
    	$this->view->form = $this->setFormProperties('create');
    	$this->view->form->getElement('username')->addValidator(new Common_Validator_DuplicatedUser(), FALSE);
    	if($this->FormPostedAndValid($this->view->form)) {
    		$data = $this->view->form->getValues();
    		$this->_mapper->save($data);
    		return $this->_helper->redirector('admin');
    	}
    }
    
    public function editAction() {
    	$this->view->pageTitle = "Edit user";
    	$this->view->headTitle()->prepend('Edit user');
    	$this->view->form = $this->setFormProperties('edit');
    	$this->view->form->removeElement('passwordVerify');
    	$this->view->form->removeElement('password');
    	if($this->FormPostedAndValid($this->view->form)) {
    		$data = $this->view->form->getValues();
    		$this->_mapper->save($data);
    		return $this->_helper->redirector('admin');
    	}
    }
    
    public function loginAction() {
    	$this->view->pageTitle = "Login";
    	$this->view->headTitle()->prepend('login');
    	$this->view->form = $this->setFormProperties('login');
    
    	if ($this->FormPostedAndValid($this->view->form)) {
    		$data = $this->view->form->getValues();
    
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users',
    				'username', 'hashedPassword', 'SHA1(CONCAT(?,salt))');
    
    		$authAdapter->setIdentity($data['username']);
    		$authAdapter->setCredential($data['password']);
    		$authAdapter->setCredentialTreatment('SHA1(CONCAT(?,salt))');
    		$result = $authAdapter->authenticate();
    
    		// verifico le credenziali
    		if ($result->isValid()) {
    			$auth = Zend_Auth::getInstance();
    			$storage = $auth->getStorage();
    			$storage->write($authAdapter->getResultRowObject(
    					array('username', 'role', 'id', 'email')));
    			$_SESSION['isLoggedIn'] = true;
    			$this->_redirect('/');
    		} else {
    			$this->view->loginMessage = "Wrong username and/or password";
    		}
    	}
    }
    
    public function logoutAction () {
    	$authAdapter = Zend_Auth::getInstance();
    	$authAdapter->clearIdentity();
    	//$_SESSION['isLoggedIn'] = false;
    	unset($_SESSION['isLoggedIn']);
    	$this->_redirect('/');
    }
    
    public function changepwdAction() {
    	$this->view->pageTitle = "Change password";
    	$this->view->headTitle()->prepend('Change password');
    	$this->view->form = $this->setFormProperties('changepwd');
    	$id = $this->getRequest()->getParam('id');
    	$this->view->form->getElement('id')->setValue($id);
    	if($this->FormPostedAndValid($this->view->form)) {
    		$data = $this->view->form->getValues();
    		$this->_mapper->save($data);
    		return $this->_helper->redirector('admin');
    	}
    }
}

