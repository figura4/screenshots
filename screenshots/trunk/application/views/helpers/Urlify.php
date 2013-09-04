<?php

class Zend_View_Helper_Urlify extends Zend_View_Helper_Abstract {
	public function urlify ($field) {
		$result = $field;
		$result = strtolower($result);
		$result = preg_replace('/[^\w\d_ -]/si', '', $result);
		$result = preg_replace('/\s+/', '-', $result);
		return $result;
	}
}