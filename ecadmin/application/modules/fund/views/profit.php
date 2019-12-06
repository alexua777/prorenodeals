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
                <li class="active"><a href="<?= base_url() ?>fund/profit">Profit List</a></li>
            </ul>
        </div>


        <div class="container-fluid">
            <div id="heading" class="page-header">
                <h1><i class="icon20 i-table-2"></i> Profit List</h1>
            </div>
            <div class="row">

                <div class="col-lg-12">
                     <div id="prod">
                    <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>  	
                            <tr>
                                <th style="text-align:left;">Month</th>
                                <th style="text-align:center;">Amount</th>
                               
                                <th style="text-align:center;" id="stt">Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                       
                            <?php
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
									
                                    ?>

                                    <tr> 

                                        <td style="text-align:left;"><?= date('M-Y',strtotime($val['transction_date'])); ?></td>
                                   
                                        <td style="text-align:center;">$
										<?php if($val['profit']!=''){echo $val['profit'];} else{echo '0.00';}?>
                                        </td>
                                          <td align="center" id="ac">
											
                                             <?php
                                                        
                                                        $atr2 = array('class' => 'i-highlight', 'title' => 'View Details');

                                                       
                                                        echo anchor(base_url() . 'fund/profit_details/' . $val['transction_date'], '&nbsp;', $atr2);
                                                        
                                              ?>

                                        </td>
                                        
                                
                                      
                                    </tr>



                                    <?php
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