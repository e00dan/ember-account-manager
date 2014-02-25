<?php
require('../engine/db.php');
require('/var/www/config.php');
try {
	$db = new Database;
	$db->connect($config['database']['host'], $config['database']['login'], $config['database']['password']);
	$db->select_db($config['database']['database']);
	$res = $db->fetch_real_assoc($db->query('SELECT * FROM `players` WHERE `group_id` > 3 LIMIT 5'));
} catch (Exception $e) {
	echo $e->getMessage();
}
foreach ($res as $mem) {
	echo $mem['name'] . ' with level ' . $mem['level'] .'<br />';
}
?>