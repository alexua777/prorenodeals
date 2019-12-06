<link rel="stylesheet" href="<?=JS?>jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
	<script src="<?=JS?>jquery-ui-1/development-bundle/jquery-1.6.2.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#datepicker_from" ).datepicker({
			showOn: "button",
			buttonImage: "<?=ASSETS?>/images/caln.png",
			buttonImageOnly: true
		});
	});
	$(function() {
		$( "#datepicker_to" ).datepicker({
			showOn: "button",
			buttonImage: "<?=ASSETS?>/images/caln.png",
			buttonImageOnly: true
		});
	});
	</script>


<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="active"><a href="<?= base_url() ?>fund/profit">Profit Details</a></li>
            </ul>
        </div>


        <div class="container-fluid">
            <div id="heading" class="page-header">
                <h1><i class="icon20 i-table-2"></i> Profit Details </h1>
            </div>
            <div class="row">

                <div class="col-lg-12">
                
  
                     <div id="prod">
                    <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>  	
                            <tr>
                                <th style="text-align:left;">Date</th>
                                <th style="text-align:left;">Details</th>
                                <th style="text-align:center;">Profit</th>
                             
                                
                            </tr>
                        </thead>
                        <tbody>
                       
                            <?php
							// 	id	paypal_transaction_id	user_id	amount	profit	transction_type CR=Credit DR=Debit	transaction_for	transction_date	status
                               $attr = array(
                                
                                'class' => 'i-cancel-circle-2 red',
                                'title' => 'Delete'
                            );
                            $atr3 = array(
                                
                                'class' => 'i-checkmark-3 red',
                                'title' => 'Inactive'
                            );
                            $atr4 = array(
                               
                                'class' => 'i-checkmark-3 green',
                                'title' => 'Active'
                            );
							?>
                            <div id="prodlist">
                            <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
									$user_name =$this->auto_model->getFeild('username','user','user_id',$val['user_id']);
									if($val['profit']!=0)
									{
                                    ?>

                                    <tr> 

                                        <td style="text-align:left;"><?= date('d-M-Y H:i:s',strtotime($val['transction_date'])); ?></td>
                                        <td>
                                       Transaction Id : <b><?= $val['paypal_transaction_id'] ?></b><br />
											User Name :   <?= ucwords($user_name) ?><br />
                                       	  Description :  <?= ucwords($val['transaction_for']) ?>
                                        </td>
                                        <td style="text-align:center;"><?= "$".$val['profit'] ?></td>
                                        
                                
                                      
                                    </tr>

				<?php  }
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" align="center" style="color:#F00">No records found...</td>
                                </tr>
							
    <?php
}
?>
						
                        </tbody>
                    </table>
              </div>
                    
                </div><!-- End .col-lg-6  -->
            </div><!-- End .row-fluid  -->

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
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