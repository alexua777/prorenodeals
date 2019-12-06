<?php // $this->load->library('session');  ?>
<style>
.mybox {
	background-color: #ffffff;
    border: 1px solid #007aff;
    margin: 0;
    padding: 0 6px;
    display: inline-block;
}
.mybox:hover {
	background-color: #007aff;
	color:#fff;
}
.myactiveclass {
	background-color: #007aff;
	color:#fff;
}

.badge-primary {
    color: #fff;
    background-color: #007bff;
}
.badge-danger {
    color: #fff;
    background-color: #dc3545;
}
.badge-warning {
    color: #212529;
    background-color: #ffc107;
}
.badge-success {
    color: #fff;
    background-color: #28a745;
}
.badge-info {
    color: #fff;
    background-color: #17a2b8;
}
.badge-light {
    color: #212529;
    background-color: #f8f9fa;
}
.badge-dark {
    color: #fff;
    background-color: #343a40;
}
</style>
<section id="content">

<div class="wrapper">
	<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Member List</a> </li>
        <!--<li class="active"><a onclick="redirect_to('<?php echo base_url() . 'member/edit'; ?>');">View Member</a></li>-->
        </ol>
	</nav> 
<script>

    function getAllRecords(letter) {

        var basepath = $("#basepath").val();

        var userid = $("#userid").val();



       // var page = $("#page").val();

        var url = basepath + "member/member_list/" +letter;

        //alert(url);

        window.location = url;

    }

</script>
  <div class="container-fluid">    
    <?php $user_id = $this->uri->segment(3);

		//echo $id;

		?>
    <div class="row">
      <div class="col-sm-12">

      <h4>Member List</h4>
      <form action="<?= base_url() ?>member/page" method="post" class="hidden">
        <input type="hidden" id="basepath" value="<?php echo base_url(); ?>">
        <input type="hidden" id="userid" value="<?php echo $user_id; ?>">
        <div class="form-group">
          <div style="margin:auto;" class="lnk"> <label class="col-form-label">Search By User Name:</label> <br />
            <?php

			for ($i = 65; $i <= 90; $i++) {

				$st = '';

				?>
            <a href="javascript:void(0);" id="paggi" class='mybox <?php if ($letter === chr($i)) {

			echo "myactiveclass";

			} ?>' onclick="getAllRecords('<?= chr($i) ?>')"><b>
            <?= chr($i) ?>
            </b></a>
            <?php

			if ($i != 100) {

				echo"&nbsp;";

			}

		}

		?>
          </div>
        </div>
      </form>

        <!-- End .form-group  -->
        <form action="">
          <div class="form-group">
            <div class="input-group mb-3">
              <input type="text" id="srchkey" name="term" class="form-control" placeholder="Enter Name, Username or Email to search.." value="<?php echo !empty($srch['term']) ? $srch['term'] : ''; ?>">
              <div class="input-group-append">
                <select class="form-control" name="profile_type">
					<option value="">All Profiles</option>
					<option value="featured" <?php echo (!empty($srch['profile_type']) && $srch['profile_type']) == 'featured' ? 'selected' : ''; ?>>Featured Profiles</option>
					<option value="non-featured" <?php echo (!empty($srch['profile_type']) && $srch['profile_type']) == 'non-featured' ? 'selected' : ''; ?>>Non Featured Profies</option>
				</select>
              </div>
			  <div class="input-group-append">
                <button class="btn btn-secondary" type="submit">Search</button>
              </div>
            </div>            
          </div>
        </form>
        <div class="form-group" hidden>
          <div style="margin:auto;" class="lnk">
            <?php
			$membership=$this->member_model->getMembership();
			?>
            <label class="col-form-label">Search By Membership Plan</label>:<br />
            <select class="form-control" name="membership" id="membership" onchange="memsrch();">
              <option value="">Please select</option>
              <?php

                                        foreach($membership as $key=>$val)

										{

										?>
              <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
              <?php	

										}

										?>
            </select>
          </div>
        </div>
        <div class="text-right mb10">        
        <a href="<?php echo base_url();?>member/generateCSV" class="btn btn-primary">Export List</a>             		
        <a href="javascript:void(0);" onclick="hdd();" data-reveal-id="exampleModal" style="display:none;">
              <input class="btn btn-default" type="button" value="Send Mail">
		</a>
        </div>
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
        <table class="table table-hover table-bordered adminmenu_list checkAll" id="example1">
          <thead>
            <tr>
              <th style="vertical-align:top">
              <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input master-check" value="all" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1"></label>
                </div>
              </th>
              <th>Id</th>
              <th>Logo</th>
              <th>User Name/Email</th>
              <th>Name / Phone</th>
              <th>Balance[<?php echo CURRENCY;?>]</th>
              <!--<th>Plan</th>
              <th>Auto Renewal</th>-->			  			<th>User type</th> 			
              <th>Join Date</th>              
              <th>Last Login</th>
              <th>Status</th>
             <th>Bid/Post Approve</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="id2">
            <?php

					$attr = array(

					'onclick' => "javascript: return confirm('Do you want to delete?');",

					'class' => 'la la-times-2 _165x red',

					'title' => 'Delete'

					);

					$attr9 = array(

					'onclick' => "javascript: return confirm('Do you want to make feature this client?');",

					'class' => 'la la-check-circle _165x red',

					'title' => 'Normal'

					);

					$attr8 = array(

					'onclick' => "javascript: return confirm('Do you want to remove featured from this client?');",

					'class' => 'la la-check-circle _165x green',

					'title' => 'Featured'

					);

					$atr3 = array(

						'onclick' => "javascript: return confirm('Do you want to active this?');",

						'class' => 'la la-check-circle _165x red',

						'title' => 'Inactive'

					);

					$atr4 = array(

						'onclick' => "javascript: return confirm('Do you want to inactive this?');",

						'class' => 'la la-check-circle _165x green',

						'title' => 'Active'

					);





if (count($all_data) != 0) {

    foreach ($all_data as $key => $user) {

		$plan=$this->auto_model->getFeild('name','membership_plan','id',$user['membership_plan']);

        ?>
            <tr>
              <td>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="mailsend" id="mail_<?php echo $user['user_id'];?>" value="<?php echo $user['user_id'];?>" title="please check to send mail">
              <label class="custom-control-label" for="mail_<?php echo $user['user_id'];?>"></label>
            </div></td>
              <td><?php echo $user['user_id']; ?></td>                            
              <td><?php if($user['logo']!='')

                                            {

												

                                            ?>
                <img src="<?= SITE_URL?>assets/uploaded/<?=$user['logo']?>" height="48" width="48"/>
                <?php

                                            }

                                            else 

                                            {

                                            ?>
                <img src="<?= SITE_URL?>assets/images/face_icon.gif" height="48" width="48"/>
                <?php

                                            }

                                            ?></td>
                <td><?php echo $user['username']."<br/>".ucwords(substr($user['email'],'0','10')."..."); ?></td>                                          
                <td><?php echo ucwords($user['fname'])." ".ucwords($user['lname']); ?>
					<?php if($user['phone'] && $user['account_type'] == 'F'){ ?>
					<div><b>Phone : </b><?php echo $user['phone']; ?></div>
					<?php  } ?>
					<?php if($user['featured'] == '1'){ ?>
					<div>
						<span class="badge badge-primary">Featured</span>
						<span class="badge badge-pill badge-danger">Till : <?php echo date('d M, Y', strtotime($user['featured_till']));?></span>
					</div>
					<?php } ?>
					
				</td>
                <td><?php $user_wallet_id = get_user_wallet($user['user_id']) ;  echo get_wallet_balance($user_wallet_id); ?></td>
                <!--<td><?php echo $plan;?></td>
                <td><?php echo $user['membership_upgrade'];?></td>-->				
				<td><?php echo $user['account_type'] == 'F' ? 'Contractor' : 'Customer'; ?></td>
                <td style="width:120px"><?php echo date('d-M-Y H:i:s',strtotime($user['reg_date'])); ?></td>
                <td><?php echo !empty($user['last_seen']) ? date('d-M-Y H:i:s',$user['last_seen']) : 'Long Time Ago'; ?></td>
                <td><?php
                
                if ($user['status'] == 'Y')
                
                {
                
                    echo anchor(base_url() . 'member/change_status/' . $user['user_id'].'/inact/'.$user['status'], '&nbsp;', $atr4);
                
                }
                
                elseif($user['status'] == 'N')
                
                {
                
                    echo anchor(base_url() . 'member/change_status/' . $user['user_id'].'/act/'.$user['status'], '&nbsp;', $atr3);
                
                }
                
                else
                
                {
                
                    echo "Closed";	
                
                }
                
                ?></td>
              <td><?php

				if ($user['verify'] == 'Y')

				{

					echo anchor(base_url() . 'member/change_status/' . $user['user_id'].'/inapp_veryify/'.$user['verify'], '&nbsp;', $atr4);

				}

				else

				{

					echo anchor(base_url() . 'member/change_status/' . $user['user_id'].'/app_veryify/'.$user['verify'], '&nbsp;', $atr3);

				}

				

				?></td>
              <td align="center"><?php

                                            $atr1 = array('class' => 'la la-edit _165x', 'title' => 'Edit');

                                            $atr5= array('class' => 'la la-at _165x', 'title' => 'Send mail');

											$atr_view = array('class' =>'la la-eye _165x' ,'title'=> 'View Details');

                                            echo anchor(base_url() . 'member/edit_member/' . $user['user_id'],'&nbsp;', $atr1);

                                           // echo anchor(base_url() . 'member/send_mail/' . $user['user_id'],'&nbsp;', $atr5);

                                            echo anchor(base_url() . 'member/change_status/' . $user['user_id'].'/del/','&nbsp;', $attr);

                                            echo anchor(base_url() . 'member/view_documents/' .$user['user_id'],'&nbsp;', $atr_view);

											

											

											?>
                <a href="<?php echo base_url();?>member/add_fund/<?php echo $user['user_id'];?>/" title="Add Fund"><i class="la la-plus _165x"></i></a>
				
				 <a href="javascript:void(0)" onclick="closeAccount('<?php echo $user['user_id']?>', '<?php echo $user['account_type']?>')" title="Delete"><i class="la la-trash _165x"></i></a>
				</td>
				
            </tr>
            <?php } ?>
            <? } else { ?>
            <tr>
              <td colspan="10" align="center" class="red"> No Records Found </td>
            </tr>
            <? } ?>
          </tbody>
        </table>
        <?php echo $links; ?> 
        <!--<?php // if ($page>30) {?>    

                  

				    <div class="pagin"><p>Page:</p><a class="active"><?php //echo $links; ?></a></div>

				    <?php // }?>--> 
        
      </div>
      <!-- End .col-lg-6  --> 
      
    </div>
    <!-- End .row-fluid  -->
    
    <div id="exampleModal" class="reveal-modal hidden" style="width:70%;margin-left: -35%;" >
      <h3>Send Email to Invitees</h3>
      <div class="editprofile" style="padding-bottom: 14px;padding-top: 14px;">
        <div id="id3">
          <form name="mailsend" action="<?php echo base_url();?>member/send_mail/" method="post">
            <div class="form-group">
              <label class="col-lg-2 control-label">Email Id</label>
              <div class="col-lg-9">
                <textarea name="to" id="to" class="col-lg-7 valid form-control" rows="5" cols="40"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Subject</label>
              <div class="col-lg-9">
                <input type="text" class="col-lg-7 valid form-control" name="subject" id="subject" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Message</label>
              <div class="col-lg-9">
                <textarea name="body" id="body" class="col-lg-7 valid form-control" rows="5" cols="40"></textarea>
                <?php echo display_ckeditor($ckeditor); ?> </div>
            </div>
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
      <a class="close-reveal-modal">&#215;</a> </div>
	  
<div id="closeAccountModal" class="modal fade" role="dialog">
	<div class="modal-dialog">  
  <!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
	<h4 class="modal-title">Close account</h4>
	<button type="button" class="close" data-dismiss="modal" onclick="$('#closeAccountModal').modal('hide');">&times;</button>
  </div>
  <div class="modal-body">
	<p>Some text in the modal.</p>
  </div>

</div>
 </div> 
</div>

    <?php /*?><script src="<?php echo SITE_URL;?>assets/js/jquery.min.js"></script><?php */?>
    <script src="<?php echo SITE_URL;?>assets/js/app.js"></script> 
    <script src="<?php echo SITE_URL;?>assets/js/jquery.reveal.js"></script> 
  </div>
  <!-- End .container-fluid  --> 
  
</div>
<!-- End .wrapper  -->

</section>
<script>



function srch()

{

	var key=$('#srchkey').val();

	if(key=='')

	{

		window.location.href='<?php echo base_url();?>member/member_list/';	

	}

	else

	{

	var dataString="srchkey="+key;

	$.ajax({

     type:"POST",

     data:dataString,

     url:"<?php echo base_url();?>member/filtermember/"+key,

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

function closeAccount(user_id, user_type){
	if(!user_id || !user_type){
		return false;
	}
	$('#closeAccountModal').modal('show'); 
	$('#closeAccountModal').find('.modal-body').html('Checking...');
	$.ajax({
		url : '<?php echo base_url('member/close_user_account')?>',
		data: {user_id: user_id, user_type: user_type},
		type: 'POST',
		success: function(res){
			$('#closeAccountModal').find('.modal-body').html(res);
		}
	});
}


function deleteAccount(user_id){
	if(!user_id){
		return false;
	}
	
	$('#close_acc_btn').attr('disabled', 'disabled');
	$('#close_acc_btn').html('Processing...');
	$.ajax({
		url : '<?php echo base_url('member/delete_user_account_ajax')?>',
		data: {user_id: user_id},
		type: 'POST',
		dataType: 'json',
		success: function(res){
			if(res.status == 1){
				location.reload();
			}
		}
	});
	
	
}




</script>