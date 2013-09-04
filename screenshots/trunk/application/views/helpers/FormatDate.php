<?php

class Zend_View_Helper_FormatDate extends Zend_View_Helper_Abstract {
    public function formatDate ($date) {
		$date = new Zend_Date($date, Zend_Date::ISO_8601, 'en_UK');
    	return $date->toString('MMM d, YYYY');
    }
}