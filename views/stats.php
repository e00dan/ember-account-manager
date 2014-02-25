<?php
require('../conf.sec.php');
require($conf['loc']['db']);

try {
	$db = new Database;
	$db->connect($conf['db']['host'], $conf['db']['user'], $conf['db']['pass']);
	$db->select_db($conf['db']['db']);
	$last 		= $db->query('SELECT `name` FROM `players` ORDER BY `id` DESC LIMIT 1;')->fetch_assoc();
	$ammount 	= $db->query('SELECT COUNT(*) FROM `players` WHERE `id` > 0;')->fetch_row();
	$best 		= $db->query('SELECT `name`, `level` FROM `players` ORDER BY `level` DESC LIMIT 1')->fetch_assoc();
	$houses 	= $db->query('SELECT COUNT(*) FROM `houses` WHERE `owner` = 0;')->fetch_row();
	$accounts	= $db->query('SELECT COUNT(*) FROM `accounts`')->fetch_row();
	$end 		= array(
				'last'		=> $last['name'],
				'ammount' 	=> $ammount[0],
				'best' 		=> $best['name'],
				'level'		=> $best['level'],
				'houses' 	=> $houses[0],
				'accounts' 	=> $accounts[0]
	);
	echo json_encode($end);
} catch (Exception $e) {
	echo $e->getMessage();
}