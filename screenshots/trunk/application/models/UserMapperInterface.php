<?php

Interface Application_Model_UserMapperInterface extends Common_ModelMapperInterface {
	public function userExsists($username);
}