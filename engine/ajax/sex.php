<?php
require('../../conf.sec.php');
require($conf['loc']['db']);

$db = new Database;
$db->connect($conf['db']['host'], $conf['db']['user'], $conf['db']['pass']);
$db->select_db($conf['db']['db']);
$db->query('SET CHARACTER SET utf8');

$male = $db->query('SELECT COUNT(*) FROM `players` WHERE `sex` = 1')->fetch_row();
$female = $db->query('SELECT COUNT(*) FROM `players` WHERE `sex` = 0')->fetch_row();
$a = $male[0] + $female[0];
$male['p'] = round(($male[0] * 100) / $a);
echo json_encode(array(
	array('count' => $male[0],
			'name' => 'male',
		'procent' => $male['p']
	),
	array('count' => $female[0],
			'name' => 'female',
		'procent' => (100 - $male['p']))
));
?>
