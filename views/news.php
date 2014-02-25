<?php
require('../conf.sec.php');
require($conf['loc']['db']);

$a = (int)$_GET['a'];
$limit = ($a <= 10 && $a > 0) ? $a : 5;

$o = (int)$_GET['o'];
$off = ($o < 100) ? $o : 0;

try {
	$db = new Database;
	$db->connect($conf['db']['host'], $conf['db']['user'], $conf['db']['pass']);
	$db->select_db($conf['db']['db']);
	$db->query('SET CHARACTER SET utf8');
	$res = $db->fetch_real_assoc($db->query('SELECT `author`, `title`, `body`, `time` FROM `news` ORDER BY `id` DESC LIMIT ' . $off . ', ' . $limit . ';'));
	$end = array();
} catch (Exception $e) {
	echo $e->getMessage();
}
foreach ($res as $news) {
	$end[] = $news;
}
echo json_encode($end);
?>