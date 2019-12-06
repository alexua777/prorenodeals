

<script src="<?=JS?>mycustom.js"></script>

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

{},

{orderable: false, },

{ },

{orderable: false,},



],

});

} );

</script> 

<section id="mainpage">  

<div class="container-fluid">
<div class="row">
<?php $this->load->view('dashboard-left'); ?>
<aside class="col-lg-10 col-md-9 col-12">  
<?php echo $breadcrumb;?>
<div class="profile_right">

	<?php $this->load->view('freelancer-project-tab'); ?> 


        <table id="example" class="table table-hover">

          <thead>

            <tr>

              <th>Project Name</th>

              <th hidden>Project Type</th>

              <th>Posted By</th>

              <th>Posted date</th>

              <th>Action</th>

            </tr>

          </thead>

          <tbody>

            <?php

$this->load->model('projectdashboard_new/projectdashboard_model');

$user_id = $this->session->userdata('user')[0]->user_id;

if(count($working_projects)>0)

{

foreach($working_projects as $key=>$val)

{

$feedback = $this->projectdashboard_model->getProjectFeedback($val['project_id']);

$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);

$username=$this->auto_model->getFeild('fname','user','user_id',$val['user_id']);

$bidder_name=$this->auto_model->getFeild('fname','user','user_id',$val['bidder_id']);

$count_review=$this->dashboard_model->countReview($val['project_id'],$user_id,$val['user_id']);

$type="";

if($val['project_type']=="F")

{

$type="Fixed";

}

else

{

$type="Hourly";

}

?>

                <tr>

                  <td><?php echo $project_name;?></td>

                  <td hidden><?php echo $type;?></td>

                  <td><?php echo $username;?></td>

                  <td><?php echo $this->auto_model->date_format($val['post_date']);?></td>

                  <td>

				  <a href="<?=VPATH?>projectdashboard_new/freelancer/overview/<?php echo $val['project_id'];?>" title="Project Room"><i class="icon-feather-home"></i></a>
                  &nbsp;
				  <?php 

				    $employer_f_name = getField('fname', 'user', 'user_id', $val['user_id']);

				    $employer_l_name = getField('lname', 'user', 'user_id', $val['user_id']);

					$employer_name = $employer_f_name. ' '.$employer_l_name;

					$give_feedback = true;

					$is_employer_feedback_done = false;

					$employer_public_feedback = $employer_given_public_feedback = $employer_given_private_feedback = array();

					

					if(!empty($feedback['public'][$user_id.'|'.$val['user_id']])){

						$employer_public_feedback = $feedback['public'][$user_id.'|'.$val['user_id']];

						$give_feedback = false;

					}

		

		

					if(!empty($feedback['public'][$val['user_id'].'|'.$user_id])){

						$employer_given_public_feedback =$feedback['public'][$val['user_id'].'|'.$user_id];

						$is_employer_feedback_done=true;

					}

					

					 if(!empty($feedback['private'][$val['user_id'].'|'.$user_id])){

						$employer_given_private_feedback =$feedback['private'][$val['user_id'].'|'.$user_id];

						$is_employer_feedback_done=true;

					}

					

				  ?>

				  

				  <?php if($is_employer_feedback_done && check_user_review($user_id, $val['project_id'])){ ?>

					<a href="javascript:void(0);" onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($employer_given_public_feedback); ?>' data-private-feedback='<?php echo json_encode($employer_given_private_feedback); ?>' data-name="<?php echo $employer_name; ?>" title="Left Feedback"><i class="icon-feather-message-square"></i></a>

				<?php } ?>

				  <?php if($give_feedback){ ?>

					<a href="javascript:void(0);" title="Give Feedback" onclick="newFeedbackOpen(this)" data-employer-id="<?php echo $val['user_id']; ?>" data-project-id="<?php echo $val['project_id']; ?>" data-name="<?php echo $employer_name; ?>"><i class="icon-feather-message-square"></i></a>

				<?php }else{  ?>

				&nbsp;

				 <a href="javascript:void(0);" onclick="ReadGivenFeedback(this)" data-public-feedback='<?php echo json_encode($employer_public_feedback); ?>' data-name="<?php echo $employer_name; ?>" title="Left Feedback"><i class="icon-feather-message-square"></i></a>

				<?php } ?>

					

				  <?php 

		/* if($count_review>0)

		{

		echo "<a href='".VPATH."dashboard/viewfeedback/".$val['project_id']."/".$val['user_id']."/".$project_name."'>View Feedback</a>";	

		}

		else

		{

		echo "<a href='".VPATH."dashboard/rating/".$val['project_id']."/".$val['user_id']."/".$project_name."'>Give Feedback</a>";	

		} */

		

?></td>

                </tr>

                <?php

}

}



?>

              </tbody>

		</table>

 

<?php $this->load->view('projectdashboard_new/freelancer_rating_review'); ?> 

 

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

      <div class="addbox2">

        <?php 

echo $code;

?>

      </div>

      <?php                      

}

elseif($type=='B'&& $image!="")

{

?>

      <div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>

      <?php  

}

}



?>

      <div class="clearfix"></div>

    </div>

    

  </aside>

</div>

</div>

</section>