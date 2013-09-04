<?php

class Zend_View_Helper_ScrollableThumbnails extends Zend_View_Helper_Abstract {
	public function scrollableThumbnails ($thumbnails = array(), $itemsPerPage = 4) {
		if (count($thumbnails) <= 1) return null;
		if ($itemsPerPage < 1) $itemsPerPage = 1;
		
    	$result  = '<div style="margin:0 auto; width: 940px; height:120px;">' . PHP_EOL;
		$result .= '<!-- "previous page" action -->' . PHP_EOL;
		$result .= '<a class="prev browse left"></a>' . PHP_EOL;
		$result .= '<!-- root element for scrollable -->'. PHP_EOL;
		$result .= '<div class="scrollable" id="scrollable">' . PHP_EOL;
		$result .= '<!-- root element for the items -->' . PHP_EOL;
		$result .= '<div class="items">' . PHP_EOL;
		
		$itemsNumber = count($thumbnails);
		$pages = ceil($itemsNumber / $itemsPerPage);
		if ($pages < 1) $pages = 1;
		
		for ($i=1; $i <= $pages; $i++) {
			$start = $itemsPerPage * ($i - 1);
			$end = $itemsPerPage * $i;
			if ($end > $itemsNumber) $end = $itemsNumber;
			
			$result .= '<div>' . PHP_EOL;
			for ($j = $start; $j < $end; $j++ ) {
				$result .= '<a href="' . $this->view->friendlyUrl($thumbnails[$j], 'screenshot') . '">' . PHP_EOL;
				$result .= '<img src="' . Zend_Registry::get('smallThmubnailsRelPath') . 'thmbs_' . $thumbnails[$j]->resolution00 . '" />' . PHP_EOL;
				$result .= '</a>' . PHP_EOL;
			}
			$result .= '</div>' . PHP_EOL;
		}
		
		$result .= '</div>' . PHP_EOL;
		$result .= '</div>' . PHP_EOL;
		$result .= '<!-- "next page" action -->' . PHP_EOL;
		$result .= '<a class="next browse right"></a>' . PHP_EOL;
		$result .= '</div>' . PHP_EOL;
		
		return $result;
    }
}