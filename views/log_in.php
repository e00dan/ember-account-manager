<?php
require('../conf.sec.php');
require($conf['loc']['login']);
sec_session_start();

if(!$_SESSION['logged']) {
?>
<form id="login" action="engine/login.php" method="post">
	<label>Name:</label> <input type="text" name="name" /><br />
    <label>Password:</label> <input type="password" name="pass" /><br />
    <input type="submit" name="submit" value="Login" /> 
</form>
<script src="js/libs/ajaxform.js"></script>
<script>
function processJson(data) {
	if (data.success) {
		c.relAcc();
		c.getView('log_in');
	}
}
$("#login").ajaxForm({
	 dataType:  'json',
	 success:   processJson
});
</script>
<?php } else { ?>
<div class="alert alert-success">
	<button class="close" data-dismiss="alert">×</button>
	<strong>Success!</strong> You are logged in!
</div>
<?php } ?>
