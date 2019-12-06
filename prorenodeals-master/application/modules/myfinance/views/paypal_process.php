<div class="container text-center" style="padding: 30px;">
	<img src="<?php echo IMAGE;?>loader1.gif" width="150"/>
	<br/><br/><br/>
	<p>Please wait while your request is in progress. Don't refresh or reload this page. </p>
</div>

<script>

$(document).ready(function(){
	setInterval(function(){
		$.get('<?php echo base_url('myfinance/check_track_status/'.$track_id)?>', function(res){
			if(res == 1){
				window.location.href = '<?php echo $next ? $next : base_url('dashboard'); ?>';
			}
		});
		
	}, 10000);
});

</script>