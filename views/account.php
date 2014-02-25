<?php
require('../conf.sec.php');
require $conf['loc']['login'];

sec_session_start();
if ($_SESSION['logged']) {
	require($conf['loc']['db']);
	require('../engine/libs/functions.php');
	$id = (int)$_SESSION['acc_id'];
	
	$db = new Database;
	$db->connect($conf['db']['host'], $conf['db']['user'], $conf['db']['pass']);
	$db->select_db($conf['db']['db']);
	$db->query('SET CHARACTER SET utf8');
	$acc = $db->query('SELECT `email`, `premium_points` FROM `accounts` WHERE `id` = ' . $id)->fetch_assoc();
	$chars = $db->fetch_real_assoc($db->query('SELECT `name`, `level`, `vocation`, `promotion` FROM `players` WHERE `account_id` = ' . $id . ' AND `deleted` = 0'));
	?>
	<h1>account management</h1>
	<div class="liner"></div>
	
	<h3>basic information</h3>
	<table class="table table-striped table-bordered table-condensed">
		<tbody>
			<tr>
				<td>Account name</td>
				<td><?php echo $_SESSION['acc_name']; ?></td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td><?php echo $acc['email'] ?></td>
			</tr>
			<tr>
				<td>Premium points</td>
				<td><?php echo $acc['premium_points'] ?></td>
			</tr>
			<tr>
				<td>IP Address</td>
				<td><?php echo $_SERVER['REMOTE_ADDR'] ?></td>
			</tr>
		</tbody>
	</table>
	
	<h3>characters</h3>
	<table class="table table-striped table-bordered table-condensed">
		<thead>
			<th>Name</th>
			<th>Level & Vocation</th>
			<th>Edit</th>
		</thead>
		<tbody>
			<?php foreach ($chars as $char) { ?>
			<tr>
				<td><?php echo $char['name']; ?></td>
				<td><?php echo $char['level'] . ' ' . getVocationName($char['vocation'], $char['promotion'], $conf['game']['vocations']); ?></td>
				<td><a href="#/v/account">click</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<p class="text-center">
		<button class="btn btn-inverse">change password</button>
		<button class="btn btn-inverse">create character</button>
		<button class="btn btn-inverse">create guild</button>
	</p>
<?php } else { ?>
Please click <a href="#/v/log_in">here</a> to log in.
<?php } ?>