<?php
require('../conf.sec.php');
require($conf['loc']['db']);

$db = new Database;
$db->connect($conf['db']['host'], $conf['db']['user'], $conf['db']['pass']);
$db->select_db($conf['db']['db']);
$db->query('SET CHARACTER SET utf8');

$t = $db->fetch_real_assoc($db->query('SELECT * FROM `EventRewards` ORDER BY `date` DESC LIMIT 10'));

echo '<pre>' . print_r($t, TRUE) . '</pre><br />';

?>