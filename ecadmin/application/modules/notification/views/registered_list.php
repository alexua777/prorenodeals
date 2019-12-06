<?php // $this->load->library('session');  ?>
<section id="content">
    <div class="wrapper">        
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>        
        <li class="breadcrumb-item active"><a>Registered Invitee List</a></li>
      </ol>
    </nav> 

        <div class="container-fluid">            				
				<table class="table table-hover table-bordered adminmenu_list">
				<tr>
                <td align="left">
				<a href="<?php echo base_url();?>invite/generateCSV"><input class="btn btn-default" type="button" value="Generate CSV"></a>
				</td>
				<td colspan="5" align="right">
				<a href="javascript:void(0);" onclick="hdd();" data-reveal-id="exampleModal"><input class="btn btn-default" type="button" value="Send Mail"></a>
				</td>
				</tr>
				</table>
					
					
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
                    
                    <table class="table table-hover table-bordered adminmenu_list">
                        <thead>
                            <tr>
                                <th style="text-align:left;">Id</th>
                                <th>Freelancer Name</th>
                                <th>Freelancer Email</th>
                                <th>User Name</th>
                                <th>Invite Project Name</th>
								<th>Invite Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
					$attr = array(
					'onclick' => "javascript: return confirm('Do you want to delete?');",
					'class' => 'i-cancel-circle-2 red',
					'title' => 'Delete'
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
		if(count($list)!=0){
		foreach ($list as $key => $con) {
				$uid=$this->auto_model->getFeild('user_id','projects','project_id',$con['project_id']);
				$inv_name=$this->auto_model->getFeild('fname','user','user_id',$con['invite_userid'])." ".$this->auto_model->getFeild('lname','user','user_id',$con['invite_userid']);
				$fname=$this->auto_model->getFeild('fname','user','user_id',$uid);
				$lname=$this->auto_model->getFeild('lname','user','user_id',$uid);
				$pname=$this->auto_model->getFeild('title','projects','project_id',$con['project_id']);
				$visibility_mode=$this->auto_model->getFeild('visibility_mode','projects','project_id',$con['project_id']);
				?>
                                <tr>
                                    <td><?php echo $con['id']; ?></td>
                                    <td><?php echo $inv_name; ?></td>
                                    <td align="center"><?php echo $con['inviteuser_email']; ?></td>
									<td align="center"><?php echo $fname." ".$lname; ?><br />
                                    <?php
                                    if($uid>0)
									{
										echo "(Registered User)";	
									}
									else
									{
										echo "(Guest User)";	
									}
									?>
                                    </td>
                                    <td align="center"><?php echo $pname; ?><br />
                                    (<?php
                                    echo $visibility_mode;
									?>)
                                    </td>
									
                                    
									<td align="center"><?php echo date('d-M-Y',strtotime($con['invite_date']));?></td>
									
                                    <td align="center">
                                                         
                                        <input type="checkbox" name="mailsend" id="mail_<?php $con['id'];?>" value="<?php echo $con['id'];?>" class="mailcheck" title="please check to send mail"/>
                                        
                                    </td>
                                </tr>

<?php }
	}else{
	
 ?>
 							<tr>
                            	<td colspan="6" align="center" class="red">Records Not Found</td>                                                          	
                            </tr>
 
 <?php } ?>
                        </tbody>
                    </table>
					<?php if ($links) {?>    
                  
				    <?php echo $links; ?>
				    <?php }?>
					
                
			<div id="exampleModal" class="reveal-modal" style="width:70%;margin-left: -35%;" >
            <h3>Send Email to Invitees</h3>
  					<div class="editprofile" style="padding-bottom: 14px;padding-top: 14px;">
                    	<div id="id2">
                        <form name="mailsend" action="<?php echo base_url();?>invite/send_mail/" method="post">
                        <div class="form-group">
				<label class="col-lg-2 control-label">Email Id</label>
				<div class="col-lg-9">
			<textarea name="to" id="to" class="col-lg-7 valid form-control" rows="5" cols="40"></textarea>
			</div></div>
		<div class="form-group">
				<label class="col-lg-2 control-label">Message</label>
				<div class="col-lg-9">
			<textarea name="body" id="body" class="col-lg-7 valid form-control" rows="5" cols="40"></textarea>
			<?php echo display_ckeditor($ckeditor); ?>
			</div></div>

		<div class="form-group">
				<div class="col-lg-offset-2">
					<div class="pad-left15">
						 <button type="submit" class="btn btn-primary">Send</button>
					</div>
				</div>
			</div>
            </form>
                        </div>
                        </div>
  						<a class="close-reveal-modal">&#215;</a>
                    </div>
<?php /*?><script src="<?php echo SITE_URL;?>assets/js/jquery.min.js"></script><?php */?>
<script src="<?php echo SITE_URL;?>assets/js/app.js"></script>
<script src="<?php echo SITE_URL;?>assets/js/jquery.reveal.js"></script>
        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
<script>
function hdd()
{
	var matches = [];
	$(".mailcheck:checked").each(function() {
   	 	matches.push(this.value);
	});
	if(matches=='')
	{
		$('#id2').html("");
		$('#id2').html("You haven't select anyone to send mail!");	
	}
	else
	{
		
		var dataString="user="+matches;
		$.ajax({
		 type:"POST",
		 data:dataString,
		 url:"<?php echo base_url();?>invite/getMails/"+matches,
		 success:function(return_data)
		 {
			
			$('#to').html('');
			$('#to').html(return_data);
		 }
		});	
	}	
}
</script>