<?php

Interface Application_Model_ScreenshotMapperInterface extends Common_ModelMapperInterface {
	public function getScreenshotTags($screenshotId);
	public function setScreenshotTags($screenshotId, $tagsId = array());
	public function getRecentScreenshots($num = 5);
}