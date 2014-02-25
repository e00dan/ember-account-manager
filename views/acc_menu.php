<?php
require '../conf.sec.php';
require $conf['loc']['login'];

sec_session_start();
if($_SESSION['logged']) {
	require $conf['loc']['db'];
	$db = new Database;
	$db->connect($conf['db']['host'], $conf['db']['user'], $conf['db']['pass']);
	$db->select_db($conf['db']['db']);
	$db->query('SET CHARACTER SET utf8');
	$pp = $db->query('SELECT `premium_points` AS `p` FROM `accounts` WHERE `id` = ' . $_SESSION['acc_id'])->fetch_assoc();
?>
<br />
Logged in as:<br /><br />
<div class="text-center"><span class="label label-info"><?php echo $_SESSION['acc_name']; ?></span></div><br />
Points: <?php echo $pp['p']; ?>
<li class="divider"></li>
<p class="text-center"><a href="#/v/account"><button class="btn btn-primary">Manage</button></a>&nbsp;<button class="btn btn-danger" id="logout">Logout</button></p>
<script>
$( function () {
			$('#logout').click(function () {
				$.getJSON(appPath + '/engine/logoff.php', function (data) {
					if (data.success == true) {
						$('#stats').after('<div id="logoutModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="myModalLabel">Message</h3></div><div class="modal-body"><p>You have logged out successfully!</p></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Close</button></div></div>');
						c.relAcc();
						$('#logoutModal').fadeIn(500).modal('show');
						setTimeout(function () {
							$('#logoutModal').fadeOut(500);
						}, 3000);
						setTimeout(function () {
							$('#logoutModal').modal('hide');
						}, 3500);
					}
				});
			});
		});
</script>
<?php } else {?>
Click <a href="#/v/log_in">here</a> to log in.
<?php } ?>