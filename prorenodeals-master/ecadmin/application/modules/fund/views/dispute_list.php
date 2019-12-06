<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li><a href="<?= base_url() ?>fund/dispute">Dispute Management</a></li>
                <li>Dispute List</li>
            </ul>
        </div>


        <div class="container-fluid">

  					<?php
                    if ($this->session->flashdata('succ_msg')) {
                        ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?= $this->session->flashdata('succ_msg') ?>
                        </div> 
                        <?php
                    }
                    if ($this->session->flashdata('error_msg')) {
                        ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('error_msg') ?>
                        </div>
    <?php
}
?>
                     <div id="prod">
                    <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>  	
                            <tr>
                                <th style="text-align:left;">Id</th>
                                <th style="text-align:left;">Details</th>
                                <th style="text-align:center;">Disputed Amount</th>
                                <th style="text-align:center;">Disputed Date</th>
                                <th style="text-align:center;" id="stt">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                       
                              <?php
                            $attr = array(
                                'onclick' => "javascript: return confirm('Do you want to delete?');",
                                'class' => 'i-cancel-circle-2 red',
                                'title' => 'Delete'
                            );
                            
							  $atr5 = array(
                                'class' => 'i-thumbs-up-3 green',
                                'title' => 'Release'
                            );

							?>
                         
                            <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
									$project_id=$this->auto_model->getFeild('project_id','milestone_payment','id',$val['milestone_id']);
									$project_name=$this->auto_model->getFeild('title','projects','project_id',$project_id);
									$employer_fname=$this->auto_model->getFeild('fname','user','user_id',$val['employer_id']);
									$employer_lname=$this->auto_model->getFeild('lname','user','user_id',$val['employer_id']);
									
                                    ?>

                                    <tr> 	

                                        <td style="text-align:left;"><?php echo $val['id'] ?></td>
                                        <td>
                                     	    Disputed By : <b><?php echo ucwords($employer_fname." ".$employer_lname) ?></b><br />
                                       	 	Project :  <?php echo ucwords($project_name) ?><br />
                                             
                                        </td>
                                        <td style="text-align:center;"><?php echo CURRENCY." ".$val['disput_amt'] ?></td>
                                        <td style="text-align:center;"><?php echo date('d-M-Y',strtotime($val['add_date'])); ?></td>
                                          <td align="center" id="ac">
											
                                         <?php
										 if($val['admin_involve']=="Y")
										 {
											$atr2 = array('class' => 'i-highlight', 'title' => 'View Details');
											echo anchor(base_url() . 'fund/dispute_details/' . $val['id'], '&nbsp;', $atr2);
										 }
										 else
										 {
										 	echo "N/A";
										 }
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
                    <?php if ($page>30) {?>    

                      <?php echo $links; ?>
                      <?php }  ?>               
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