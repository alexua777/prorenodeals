<script src="<?=JS?>mycustom.js"></script> 

  

<section id="mainpage">

<div class="container-fluid">

<div class="row">
<?php $this->load->view('dashboard-left'); ?>
<aside class="col-lg-10 col-md-9 col-12"> 
<?php echo $breadcrumb;?> 
  <?php $this->load->view('freelancer-project-tab'); ?>              

<!--EditProfile Start-->

<div style="max-height:600px">

<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.responsive.css">

		<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.bootstrap.css">

<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.responsive.min.js"></script>

		<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.bootstrap.js"></script>

		<script type="text/javascript" charset="utf-8">

			$(document).ready(function() {

				$('#example').dataTable({

				columns: [

					{},

					{ },

					{ orderable:      false, },

					{ orderable:      false, },

					{ },

					{ }

        		],

				"order": [[ 4, "desc" ]]

				});

			} );

		</script>

<table id="example" class="table table-hover">

<thead><tr><th>Project Name</th><th hidden>Project Type</th><th>Bid Amount</th><th>Duration</th><th>Posted date</th><th>Status</th></tr>

</thead>

<tbody>

<?php

if(count($proposals)>0)

{

foreach($proposals as $key=>$val)

{

	$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);

	$status=$this->auto_model->getFeild('status','projects','project_id',$val['project_id']);

	$bidder_id=explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$val['project_id']));

	$chosen_id=explode(",",$this->auto_model->getFeild('chosen_id','projects','project_id',$val['project_id']));

	$project_type=$this->auto_model->getFeild('project_type','projects','project_id',$val['project_id']);

	$project_status=$this->auto_model->getFeild('status','projects','project_id',$val['project_id']);

	$type="";

	if($project_type=="F")

	{

		$type="Fixed";

	}

	else

	{

		$type="Hourly";

	}

?>

<tr>

<td><a href="<?php echo VPATH;?>job-<?php echo seo_string($project_name);?>-<?php echo $val['project_id'];?>"><?php echo $project_name;?> <?php echo $project_status == 'PS' ? ' (Paused) ' : '';?></a></td>

<td hidden><?php echo $type;?></td>

<td> <?php echo CURRENCY;?> <?php echo format_money($val['bidder_amt']);?><?php if($project_type=='H'){ ?>/hr <?php } ?></td>

<!-------------------------Edit Bid Price-------------->

<?php if($val['amt_modified']=='Y') { echo " (Edited)"; } ?>

<!-------------------------Edit Bid Price-------------->

<td><?php if($project_type=='F'){?><?php echo $val['days_required'];?> days <?php }else{ echo "N/A";}?></td>

<td><?php echo $this->auto_model->date_format($val['add_date']);?></td>

<td>

<?php

if($bidder_id && in_array($user_id,$bidder_id) && $status!='O')

{

	echo "Bid Won";

	if($val['note']!='' && $project_type=='H'){

		echo "<br>".$val['note']."hr/week";

	}

}

elseif($chosen_id && in_array($user_id,$chosen_id) &&  ($status=='F' || $status=='P'))

{

?>

<!--<a href="javascript:void(0);" onclick="accept_offer('<?php echo $val['project_id'];?>')">Accept offer</a> | <a href="javascript:void(0);" onclick="decline_offer('<?php echo $val['project_id'];?>')">Decline offer</a>-->



<a href="javascript:void(0);" onclick="confirm_offer('<?php echo $val['project_id'];?>', 'accept')">Accept offer</a> | <a href="javascript:void(0);" onclick="confirm_offer('<?php echo $val['project_id'];?>', 'reject')">Decline offer</a>

<?php

}

elseif($bidder_id && !in_array($user_id,$bidder_id) && $status!='O' && $status!='F')

{

	echo "Bid Lost";

}

else

{

	echo "Offer Waiting";

}

?>

</td></tr>

<?php

}

}



?>	

</tbody>

</table>

</div>

<div class="spacer-30"></div>
<h4>Project Invitations</h4>

<div class="table-responsive">

<table id="example2" class="table table-hover">

<thead><tr><th>Project Name</th><th hidden>Project Type</th><th hidden>Amount</th><th colspan="2">Date</th></tr>

</thead>

<tbody>

<?php

if(count($invitation)>0) { foreach($invitation as $k=>$v){ ?>



<tr>

	<td><a href="<?php echo base_url('job-'.seo_string($v['title']).'-'.$v['project_id']); ?>"><?php echo $v['title']; ?></a></td>

	<td hidden><?php echo $v['project_type'] == 'F' ? 'Fixed' : 'Hourly'; ?></td>

	<td hidden><?php echo $v['invitation_amount'] != '0' ? CURRENCY. format_money($v['invitation_amount']) : '--'; ?></td>

	<td><?php echo $v['date']; ?></td>

	<td><a href="#"  data-toggle="modal" data-target="#msgModal"  data-message="<?php echo $v['message']; ?>" onclick="viewMsg(this);">Message</a></td>

</tr>

<?php } }else{  ?>

<tr>

	<td colspan="6">No data available in table</td>

</tr>

<?php } ?>	

</tbody>

</table>

</div>



<?php /*?>

<div class="notiftext"><h4>Project Name</h4><h4>Project Type</h4>	<h4>Bid Amount</h4> 	<h4>Duration</h4> 	<h4>Posted date</h4> 	<h4>Status</h4></div>

<?php

if(count($proposals)>0)

{

foreach($proposals as $key=>$val)

{

	$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);

	$status=$this->auto_model->getFeild('status','projects','project_id',$val['project_id']);

	$bidder_id=explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$val['project_id']));

	$chosen_id=explode(",",$this->auto_model->getFeild('chosen_id','projects','project_id',$val['project_id']));

	$project_type=$this->auto_model->getFeild('project_type','projects','project_id',$val['project_id']);

	$type="";

	if($project_type=="F")

	{

		$type="Fixed";

	}

	else

	{

		$type="Hourly";

	}

?>

<div class="methodbox">

<div class="methodtext1"><h2><strong><a href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>"><?php echo $project_name;?></a></strong></h2></div>

<div class="methodtext1"><h2><strong><?php echo $type;?></strong></h2></div>

<div class="methodtext1"><h2><strong> <?php echo CURRENCY;?> <?php echo $val['bidder_amt'];?><?php if($project_type=='H'){ ?>/hr <?php } ?></strong></h2></div>

<div class="methodtext1"><h2><strong><?php if($project_type=='F'){?><?php echo $val['days_required'];?> days <?php }else{ echo "N/A";}?></strong></h2></div>

<div class="methodtext1"><h2><strong><?php echo $this->auto_model->date_format($val['add_date']);?></strong></h2></div>

<div class="methodtext1"><h2><strong>

<?php

if($bidder_id && in_array($user_id,$bidder_id) && $status!='O')

{

	echo "Bid Won";

}

elseif($chosen_id && in_array($user_id,$chosen_id) &&  ($status=='F' || $status=='P'))

{

?>

<a href="javascript:void(0);" onclick="accept_offer('<?php echo $val['project_id'];?>')">Accept offer</a> | <a href="javascript:void(0);" onclick="decline_offer('<?php echo $val['project_id'];?>')">Decline offer</a>

<?php

}

elseif($bidder_id && !in_array($user_id,$bidder_id) && $status!='O' && $status!='F')

{

	echo "Bid Lost";

}

else

{

	echo "Offer Waiting";

}

?>

</strong></h2></div>

</div>

<?php

}

}

else

{

?>

<div class="myprotext"><p><strong>No active jobs to display</strong></p></div>

<?php

}

?>	

<?php */ ?> 


</aside>
<!--EditProfile End-->



<!-- Modal -->

<div id="infoModal" class="modal fade" role="dialog">

  <div class="modal-dialog">



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" onclick="$('#infoModal').modal('hide');">&times;</button>

		<h4>Confirm </h4>

      </div>

      <div class="modal-body" id="infoContent">

      

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#infoModal').modal('hide');">Cancel</button>

        <button type="button" class="btn btn-primary" id="accept-offer-btn" style="display:none;">Accept</button>

        <button type="button" class="btn btn-primary" id="reject-offer-btn" style="display:none;">Reject</button>

      </div>

    </div>



  </div>

</div>


<div id="msgModal" class="modal fade" role="dialog">

  <div class="modal-dialog">



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" onclick="$('#msgModal').modal('hide');">&times;</button>

		<h4>Message </h4>

      </div>

      <div class="modal-body">

      

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#msgModal').modal('hide');">Close</button>

      </div>

    </div>



  </div>

</div>









<?php 

  

  if(isset($ad_page)){ 

    $type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));

  if($type=='A') 

  {

   $code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 

  }

  else

  {

   $image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));

    $url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 

  }

        

      if($type=='A'&& $code!=""){ 

?>                      

<?php                      

      }

   elseif($type=='B'&& $image!="")

   {

  ?>

        

        <?php  

 }

  }



?>



     <!-- Left Section End -->

  </div>

</div>

</section>

<script>



function confirm_offer(project_id, type){

	

	if(type == 'accept'){

		$('#accept-offer-btn').attr("onclick", "accept_offer('"+project_id+"')");

		$('#accept-offer-btn').show();

		$('#reject-offer-btn').hide();

		$('#infoContent').html('Are you sure to accept this offer  ?');

	}else if(type == 'reject'){

		$('#reject-offer-btn').attr("onclick", "decline_offer('"+project_id+"')");

		$('#reject-offer-btn').show();

		$('#accept-offer-btn').hide();

		$('#infoContent').html('Are you sure to reject this offer  ?');

	}

	

	$('#infoModal').modal('show');

}

function accept_offer(project_id)

{

    

        var pid=project_id;

		//alert(pid); die();

		var dataString = 'userid='+<?php echo $user_id?>+'&projectid='+pid;

		  $.ajax({

			 type:"POST",

			 data:dataString,

			 url:"<?php echo VPATH?>dashboard/acceptoffer",

			 success:function(return_data)

			 {

				$('#editprofile').html();

				$('#editprofile').html(return_data);

				$('#infoModal').modal('hide');

			 }

		});

}

function decline_offer(project_id)

{

    

        var pid=project_id;

		//alert(pid); die();

		var dataString = 'userid='+<?php echo $user_id?>+'&projectid='+pid;

		  $.ajax({

			 type:"POST",

			 data:dataString,

			 url:"<?php echo VPATH?>dashboard/declineoffer",

			 success:function(return_data)

			 {

				$('#editprofile').html();

				$('#editprofile').html(return_data);

				$('#infoModal').modal('hide');

			 }

		});



}



function viewMsg(e){

	var msg = $(e).data('message');

	$('#msgModal').find('.modal-body').html(msg);

}

</script>