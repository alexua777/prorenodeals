<link rel="stylesheet" href="<?=JS?>jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?=JS?>jquery-ui-1/development-bundle/jquery-1.6.2.js"></script>
<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>
<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>
<section id="content">
<div class="wrapper">
  <div class="crumb">
    <ul class="breadcrumb">
      <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
      <li class="active"><a href="<?= base_url() ?>affiliate">Affiliate</a></li>
      <li>PayPal Payment</li>
    </ul>
  </div>
  <div class="container-fluid">
    <?php
				if ($this->session->flashdata('succ_msg')) {
				?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="la la-check-circle la-2x"></i> Well done!</strong>
      <?= $this->session->flashdata('succ_msg') ?>
    </div>
    <?php
				}
				if ($this->session->flashdata('error_msg')) {
				?>
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="icon24 i-close-4"></i> Oh snap!</strong>
      <?= $this->session->flashdata('error_msg') ?>
    </div>
    <?php
				}
				?>
    <div id="prod">
      <?php
					$return_url = VPATH . 'affiliate/payment_confirm/'.$w_id;
					$cancel_url = VPATH . 'affiliate/payment_cancel/';
					$notify_url = VPATH . 'affiliate/paypal_notify/';
					$paypal_url = '';
					//echo DEMO;
				//$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
                                        
				if(DEMO=="DEMO"){
					 $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
				   }  
				 else{
					 $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';                                        
				   }  
				
					
				?>
      <form action="<?php echo $paypal_url; ?>" method="post">
        <div class="form-group">
          <input type="hidden" name="amount" id="amount" value="<?php echo $amount_paid; ?>"/>
          <input name="currency_code" type="hidden" value="USD">
          <input name="shipping" type="hidden" value="0">
          <input name="return" type="hidden" value="<?php echo $return_url; ?>">
          <input name="cancel_return" type="hidden" value="<?php echo $cancel_url; ?>">
          <input name="notify_url" type="hidden" value="<?php echo $notify_url; ?>">
          <input name="cmd" type="hidden" value="_xclick">
          <input name="business" type="hidden" value="<?php echo $paypal_acc;?>">
          <input name="item_name" type="hidden" value="Add Cash in Account">
          <input type="hidden" name="custom" value="<?php echo $w_id;?>">
          <input name="no_note" type="hidden" value="1">
          <input type="hidden" name="no_shipping" value="1">
          <input name="lc" type="hidden" value="">
          <input name="bn" type="hidden" value="PP-BuyNowBF">
          <input type="hidden" name="admin_paypal_acc" value="<?php echo $admin_paypal_acc; ?>" />
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="required">Payment To</label>
          <div class="col-lg-6">
            <input type="text" id="required" value="<?php echo $paypal_acc; ?>" name="meta_title" class="required form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="required">Amount</label>
          <div class="col-lg-6">
            <input type="text" id="required" value="<?php echo $amount_paid; ?>" name="meta_title" class="required form-control">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2">            
              <button type="submit" class="btn btn-primary">Pay</button>
              <button type="button" onclick="redirect_to('<?php echo base_url().'affiliate/withdraw'; ?>');" class="btn">Cancel</button>            
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- End .container-fluid  --> 
</div>
<!-- End .wrapper  -->
</section>
<style>
  @media print {
  body * {
    visibility: hidden;
  }
  #st{ display: none;}
  #ac{ display: none;}
  #stt{ display: none;}
  #acc{ display: none;}
  #example1_length{ display: none;}
  #example1_filter{ display: none;}
  .pagination{ display: none;}
  .crumb{ display: none;}
  #sidebar{ display: none;}
  #prod * {
    visibility: visible;
  }
  #prod {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
<script>
function prnt()
{
  window.print();
}

function srch(id)
{
	var elmnt=$('#'+id).val();
	//alert(elmnt);
	var dataString = 'cid='+elmnt;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>product/getprod/"+elmnt,
     success:function(return_data)
     {
      	$('#prod').html('');
		$('#prod').html(return_data);
     }
    });
}
</script>