<?php
class Player {
	var $id 	= null;
	var $name 	= null;
	var $db 	= null;
	
	public function __construct ($i, $db_class) {
		$id = $i;
		$db = $db_class;
	}
	
	public function load ($cols) {

	}
	
	public function get ($str) {
		return $name;
	}
}
?>