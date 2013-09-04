<?php

Interface Application_Model_GameMapperInterface extends Common_ModelMapperInterface {
	public function getGameScreenshots(Application_Model_GameInterface $game, $published = true, $limit = null);
	public function getGameScreenshotsNumber($gameId, $published);
}