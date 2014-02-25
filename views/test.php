<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<div style="height: 1500px"></div>

<script>
$(function () {
	$(window).scroll(function () {
		alert('scrolled');
	});
	var pixels = 1000; // your pixels ammount
	var speed = 2000; // in miliseconds
	//$('html, body').animate({scrollTop: '+=' + pixels + 'px'}, speed);
});
    
</script>