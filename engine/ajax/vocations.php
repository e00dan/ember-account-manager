<?php
require('../../conf.sec.php');
require($conf['loc']['db']);

$db = new Database;
$db->connect($conf['db']['host'], $conf['db']['user'], $conf['db']['pass']);
$db->select_db($conf['db']['db']);
$db->query('SET CHARACTER SET utf8');

$sorc = $db->query('SELECT COUNT(*) FROM `players` WHERE `vocation` = 1')->fetch_row();
$druid = $db->query('SELECT COUNT(*) FROM `players` WHERE `vocation` = 2')->fetch_row();
$pall = $db->query('SELECT COUNT(*) FROM `players` WHERE `vocation` = 3')->fetch_row();
$kina = $db->query('SELECT COUNT(*) FROM `players` WHERE `vocation` = 4')->fetch_row();
$a = $sorc[0] + $druid[0] + $pall[0] + $kina[0];
$sorc['p'] = round(($sorc[0] * 100) / $a);
$druid['p'] = round(($druid[0] * 100) / $a);
$pall['p'] = round(($pall[0] * 100) / $a);
$kina['p'] = round(($kina[0] * 100) / $a);

echo json_encode(array(
	array('count' => $sorc[0],
			'name' => 'sorcerer',
		'procent' => $sorc['p']
	),
	array('count' => $druid[0],
			'name' => 'druid',
		'procent' => $druid['p']
	),
	array('count' => $pall[0],
			'name' => 'palladin',
		'procent' => $pall['p']
	),
	array('count' => $kina[0],
			'name' => 'knight',
		'procent' => $kina['p']
	)
));
?>
