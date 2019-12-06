<html>
<head>

<title>Set account type</title>
<script src="<?=JS?>jquery-2.1.1.min.js"></script>
<?php if($currLang == 'arabic'){ ?>
<link href="<?=CSS?>bootstrap.rtl.css" rel="stylesheet" type="text/css">
<link href="<?=CSS?>style_ar.css" rel="stylesheet" type="text/css">
<?php }else{ ?>
<link href="<?=CSS?>bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?=CSS?>style_en.css" rel="stylesheet" type="text/css">
<?php } ?>
<link href="<?=CSS?>feather.css" rel="stylesheet" type="text/css">
<style>

body {
    background-color: #f5f5f5;
}
header {
	background-color:#fff;
	border-bottom:1px solid #ddd;
	padding:10px;
}
.sec {
	padding:60px 0
}
.text-center {
	text-align:center
}
.uppercase {
	text-transform:uppercase
}
[data-toggle=buttons]>.btn input[type=checkbox], [data-toggle=buttons]>.btn input[type=radio], [data-toggle=buttons]>.btn-group>.btn input[type=checkbox], [data-toggle=buttons]>.btn-group>.btn input[type=radio] {
    position: absolute;
    clip: rect(0,0,0,0);
    pointer-events: none;
}
.btn-group {
	display:flex
}
</style>
</head>
<body>
<header>
<div class="container">
<?php if($currLang == 'arabic'){ ?>
    <img src="<?=ASSETS?>img/logo_ar.png" alt="" title="">
    <?php }else{ ?>
    <img src="<?=ASSETS?>img/<?php echo SITE_LOGO;?>" alt="" title="">
<?php } ?>
</div>
</header>
<section class="sec" id="work_hire">
<div class="container" style="max-width:500px">
<form id="acc_type_sub" class="text-center">
  <h5>Choose your account type:</h5>
  <br>
	<div data-toggle="buttons">
      <div class="btn-group">
        <label class="btn btn-secondary active">
        <input type="hidden" value="<?php echo $token?>" name="token" id="token">
         <input type="radio" name="account_type" id="employer" value="E" checked='checked'> <i class="icon-feather-briefcase"></i> CUSTOMER
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="account_type" class="magic-radio" id="freelancer" value="F"> <i class="icon-feather-user"></i> CONTRACTOR
        </label>
      </div>
	</div>
    
	<?php /*?><div class="radio radio-inline">
    <input type="hidden" value="<?php echo $token?>" name="token" id="token">
    <input type="radio" name="account_type" class="magic-radio" id="employer" value="E" checked='checked'>
    <label for="employer">EMPLOYER</label>
    </div>
    <div class="radio radio-inline">
    <input type="radio" name="account_type" class="magic-radio" id="freelancer" value="F">  
    <label for="freelancer">FREELANCER</label>
    </div><?php */?>
  
	<div class="clearfix" style="margin-bottom:30px"></div>
  
	<input type="submit" class="btn btn-primary" value="Continue">
</form>
</div>  
</section>
<script src="<?=JS?>bootstrap.min.js"></script>
<script>
		$( "#acc_type_sub" ).submit(function( event ) {
			event.preventDefault();
			var acc_type_data = {
				token: $("#token").val(),
				acc_type: $("input[name='account_type']:checked").val()
			};
			$.ajax({
				url : '<?php echo base_url('user/acc_type_update')?>',
				data: acc_type_data,
				type: 'POST',
				dataType: 'json',
				success: function(res){
					if(res.status == 1){
						if(res.next){
							location.href = res.next;
						}else{
							location.href = '<?php echo base_url('dashboard'); ?>';
						}
					}else{
						alert('Something went wrong');
					}
				}
			});
		});
	</script>
</body>
</html>