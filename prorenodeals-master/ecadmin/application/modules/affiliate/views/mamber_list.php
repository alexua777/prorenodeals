<?php // $this->load->library('session');  ?>
<style>
    .mybox{
        background-color: #F7F7F7;
        border: 1px solid #C9C9C9;
        margin: 0;
        padding: 4px;

    }
    .mybox:hover{
        background-color: #C9C9C9;
        color:#fff;
    }
    .myactiveclass{
        background-color: #C9C9C9;
        color:#fff;
    }

</style>
<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
               <li class="active"><a href="<?= base_url()?>"><i class="icon16 i-home-4"></i>Home</a></li>
               <li class="active">Member List</li>
               <li>Affiliate Member</li>
             <!--  <li class="active"><a onclick="redirect_to('<?php echo base_url() . 'member/edit'; ?>');">View Member</a></li>-->
            </ul>
        </div>
        
        
<script>
    function getAllRecords(letter) {
        var basepath = $("#basepath").val();
        var userid = $("#userid").val();

       // var page = $("#page").val();
        var url = basepath + "affiliate/member_list/" +letter;
        //alert(url);
        window.location = url;
    }
</script>

        <div class="container-fluid">
            

        <?php $user_id = $this->uri->segment(3);
		//echo $id;
		?>
			

                    <!-- End .form-group  -->
                        <div class="form-group">
                       <div class="col-lg-12">
                    <input type="text" id="srchkey" name="srchkey" class="form-control" placeholder="Type Name, Username or Email to search.." onkeyup="srch();"><br />
                    </div> 
                     </div>
                     
                    
                     	
                   
                   
					<div class="row">
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
                                    </div>
                    <table class="table table-hover table-bordered adminmenu_list checkAll" id="example1">
                        <thead>
                            <tr>                            	                                
                                <th>Id</th>                                                                                              
                                <th>User Name/Email</th>                                
                                <th>Name</th>                                                                						
								<th>Balance[<?php echo CURRENCY;?>]</th>                               
                                 <th>Join Date/Last Login</th>
								<th>Verify Status</th>
                                <th>Status</th>                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="id2">
<?php
					$attr = array(
					'onclick' => "javascript: return confirm('Do you want to delete?');",
					'class' => 'i-cancel-circle-2 red',
					'title' => 'Delete'
					);
					$attr9 = array(
					'onclick' => "javascript: return confirm('Do you want to make feature this client?');",
					'class' => 'i-checkmark-3 red',
					'title' => 'Normal'
					);
					$attr8 = array(
					'onclick' => "javascript: return confirm('Do you want to remove featured from this client?');",
					'class' => 'i-checkmark-3 green',
					'title' => 'Featured'
					);
					$atr3 = array(
						'onclick' => "javascript: return confirm('Do you want to active this?');",
						'class' => 'i-checkmark-3 red',
						'title' => 'Inactive'
					);
					$atr4 = array(
						'onclick' => "javascript: return confirm('Do you want to inactive this?');",
						'class' => 'i-checkmark-3 green',
						'title' => 'Active'
					);


if (count($all_data) != 0) {
    foreach ($all_data as $key => $user) {

        ?>

                                    <tr>
										
                                        <td align="center"><?php echo $user['user_id']; ?></td>
                                       
                                        <td><?php echo $user['username']."<br/>".$user['email']; ?></td> 
                                        <td><?php echo ucwords($user['fname'])." ".ucwords($user['lname']); ?></td>
                                         <td><?php echo $user['acc_balance']; ?></td>

                                          <td><?php echo date('d-M-Y H:i:s',strtotime($user['reg_date']))."<br/>".date('d-M-Y H:i:s',strtotime($user['edit_date'])); ?></td> 
												<td><?=$user['v_status']?></td>
                                        <td>   <?php
                                                if ($user['status'] == 'Y')
                                                {
                                                    echo anchor(base_url() . 'affiliate/change_status_member/' . $user['user_id'].'/inact/'.$user['status'], '&nbsp;', $atr4);
                                                }
                                                elseif($user['status'] == 'N')
                                                {
                                                    echo anchor(base_url() . 'affiliate/change_status_member/' . $user['user_id'].'/act/'.$user['status'], '&nbsp;', $atr3);
                                                }
												else
												{
													echo "Closed";	
												}
                                                ?>
                                        </td>

                                        <td align="center">
                                         
                                            <?php
                                            $atr1 = array('class' => 'i-highlight', 'title' => 'Edit');
                                            $atr5= array('class' => 'i-mail-2', 'title' => 'Send mail');
											$atr_view = array('class' =>'i-eye' ,'title'=> 'View Details');
                                          
                                            echo anchor(base_url() . 'affiliate/change_status_member/' . $user['user_id'].'/del/','&nbsp;', $attr);
                                            
											
											
											?>
                                           
                                        </td>
                                    </tr>

    <?php } ?>

                            <? } else { ?>
                                <tr>
                                    <td colspan="6" align="center" class="red">
                                        No Records Found
                                    </td>
                                </tr>
<? } ?>


                        </tbody>
                    </table>
					<?php  if ($page>30) {?>                      
				    	<?php echo $links; ?>
				    <?php  }?>
               
		
<?php /*?><script src="<?php echo SITE_URL;?>assets/js/jquery.min.js"></script><?php */?>
<script src="<?php echo SITE_URL;?>assets/js/app.js"></script>
<script src="<?php echo SITE_URL;?>assets/js/jquery.reveal.js"></script>
        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>

<script>

function srch()
{
	var key=$('#srchkey').val();
	if(key=='')
	{
		window.location.href='<?php echo base_url();?>affiliate/member_list/';	
	}
	else
	{
	var dataString="srchkey="+key;
	$.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>affiliate/filtermember/"+key,
     success:function(return_data)
     {
	 	
      	$('#id2').html('');
		$('#id2').html(return_data);
     }
    });
	}
}
</script>
<script>
function hdd()
{
	var matches = [];
	$(".mailcheck:checked").each(function() {
   	 	matches.push(this.value);
	});
	if(matches=='')
	{
		$('#id3').html("");
		$('#id3').html("You haven't select anyone to send mail!");	
	}
	else
	{
		var dataString="user="+matches;
		$.ajax({
		 type:"POST",
		 data:dataString,
		 url:"<?php echo base_url();?>member/getMails/"+matches,
		 success:function(return_data)
		 {
			
			$('#to').html('');
			$('#to').html(return_data);
		 }
		});	
	}	
}
function memsrch()
{
	var plan=$('#membership').val();
	window.location.href='<?php echo base_url();?>member/plan_list/'+plan;	
}


</script>