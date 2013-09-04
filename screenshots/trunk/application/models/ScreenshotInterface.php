<?php

Interface Application_Model_ScreenshotInterface extends Common_ModelInterface {
	public function getTags();
	public function setTags($tags = array());
	public function getGame();
	public function getUser();
	public function getAverageRating();
	public function saveRating($vote);
}