<?php
function getVocationName ($voc, $promotion, $arr) {
	if ($promotion > 0) {
		return $arr[($voc * $promotion) + 4];
	} else {
		return $arr[$voc];
	}
}
?>