<?php

class Zend_View_Helper_ScreenshotPath extends Zend_View_Helper_Abstract
{
	public function screenshotPath($screenshot, $thumbnail = false, $small = true)
	{
		if ($thumbnail) {
			$path = $small ? Zend_Registry::get('smallThmubnailsRelPath') : Zend_Registry::get('largeThmubnailsRelPath');
			$fileName = $small ? 'thmbs_' . $screenshot->resolution00 : 'thmbl_' . $screenshot->resolution00;
		} else {
			$path = Zend_Registry::get('screenshotsRelPath');
			$fileName = $screenshot->resolution00;
		}
		
		return $path . $fileName;
	}
}