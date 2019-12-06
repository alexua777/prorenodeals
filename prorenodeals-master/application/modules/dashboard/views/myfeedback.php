<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.css"/>

<script src="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.js"></script> 
     
<?php
$active_tab = 'received'; 

if(get('tab')){
	$active_tab = get('tab');
}

?>


<script src="<?=JS?>mycustom.js"></script>

<section id="mainpage">

<div class="container-fluid">

<div class="row">
<?php $this->load->view('dashboard-left'); ?> 
<aside class="col-lg-10 col-md-9 col-12">
<?php echo $breadcrumb;?>
<h3>Rating &amp; Reviews </h3>

<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item">
    <a class="nav-link <?php echo $active_tab == 'received' ? 'active' : '';?>" id="home-tab" href="<?php echo base_url('dashboard/myfeedback');?>" role="tab" aria-controls="home" aria-selected="true">Received</a>
	</li>
	<li class="nav-item">
    <a class="nav-link <?php echo $active_tab == 'given' ? 'active' : '';?>" id="profile-tab" href="<?php echo base_url('dashboard/myfeedback?tab=given');?>" role="tab" aria-controls="profile" aria-selected="false">Given</a>
	</li>
</ul>

<div class="tab-content" id="myTabContent">

<div class="tab-pane <?php echo $active_tab == 'received' ? 'show active' : 'fade';?>" id="home" role="tabpanel" aria-labelledby="home-tab">




<!--<th>Date</th><th>Job</th><th>Received from</th><th>Action</th>-->
  
<?php
if(count($allfeedback)>0)
{ foreach($allfeedback as $key=>$val)
{
$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);
/* $project_name=$this->auto_model->getFeild('title','jobs','job_id',$val['project_id']); */
$username=$this->auto_model->getFeild('username','user','user_id',$val['review_by_user']);
$employer_fname = $this->auto_model->getFeild('fname','user','user_id',$val['review_by_user']);
$employer_lname = $this->auto_model->getFeild('lname','user','user_id',$val['review_by_user']);
$employer_logo = get_user_logo($val['review_by_user']);
$employer_name = $employer_fname.' '.$employer_lname;
$private_feedback = get_row(array('select' => '*', 'from' => 'feedback', 'where' => array('project_id' => $val['project_id'], 'feedback_by_user' => $val['review_by_user'], 'feedback_to_user' => $val['review_to_user'])));

$u_type = getField('account_type','user','user_id',$val['review_by_user']);
if($val['review_by_agency'] > 0){
	$is_company = getField('is_company', 'agency', 'agency_id', $val['review_by_agency']);
	if($is_company > 0){
		$u_type = 'E';
	}else{
		$u_type = 'F';
	}
}


if(!$project_name){
	$project_name = '--';
}
if($val['review_by_agency'] > 0){
	$employer_name = getField('agency_name', 'agency', 'agency_id', $val['review_by_agency']);
	$username = $employer_name;
}
$username = $employer_name;
$username = get_full_name($val['review_by_user']);
?>
<div class="job-listing ratingreview">	
    <div class="job-listing-details">
    	<div class="job-listing-company-logo">
        	<img src="<?php echo $employer_logo;?>" alt="" class="rounded-circle" />
        </div>
        <div class="job-listing-description">
        <h4><?php echo ucwords($project_name);?></h4>
		<div class="star-rating" data-rating="<?php echo $val['average'];?>"></div>
        <div class="ratingAll" hidden>
            <p><a href="javascript:void(0)" class="seeAll">See all skills rating <i class="zmdi zmdi-chevron-down"></i></a></p>
            <div class="ratingtext" style="display:none">
            <p><span>Skills: </span>
			<?php
            for($i=1; $i<=5; $i++){
                if($i <= $val['skills']){
                    echo ' <i class="zmdi zmdi-star"></i>';
                }else{
                    echo ' <i class="zmdi zmdi-star-outline"></i>';
                }
            }
            ?>
            </p>
	   
            <p><span>Quality of works: </span>
            <?php
            for($i=1; $i<=5; $i++){
                if($i <= $val['quality_of_work']){
                    echo ' <i class="zmdi zmdi-star"></i>';
                }else{
                    echo ' <i class="zmdi zmdi-star-outline"></i>';
                }
            }
            ?>
           </p>
           
           <p><span>Availability: </span>
            <?php
            for($i=1; $i<=5; $i++){
                if($i <= $val['availablity']){
                    echo ' <i class="zmdi zmdi-star"></i>';
                }else{
                    echo ' <i class="zmdi zmdi-star-outline"></i>';
                }
            }
            ?>
           </p>
           
           <p><span>Communication: </span>
            <?php
            for($i=1; $i<=5; $i++){
                if($i <= $val['communication']){
                    echo ' <i class="zmdi zmdi-star"></i>';
                }else{
                    echo ' <i class="zmdi zmdi-star-outline"></i>';
                }
            }
            ?>
           </p>
           
            <p><span>Cooperation: </span> 
            <?php
            for($i=1; $i<=5; $i++){
                if($i <= $val['cooperation']){
                    echo ' <i class="zmdi zmdi-star"></i>';
                }else{
                    echo ' <i class="zmdi zmdi-star-outline"></i>';
                }
            }
            ?>
           </p>
            </div>
        </div>
        <p><?php echo $val['comment'];?></p>
        
    </div>
    </div>
	<div class="job-listing-footer with-button">
    	<ul>
        	<li><span>Review by:</span> <b><?php echo ucwords($username);?></b></li>
            <li><i class="icon-feather-calendar"></i> <?php echo date('d M,Y',strtotime($val['added_date']));?></li>
            <li><a href="javascript:void(0)" class="btn btn-site btn-sm" onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($val); ?>' data-private-feedback='<?php echo json_encode($private_feedback); ?>' data-user-type="<?php echo $u_type;?>" data-name="<?php echo $employer_name; ?>">View</a></li>
        </ul>
        
        
	</div>
    
</div>
<?php
}
}
else
{
?>
<p class="text-center">Nothing to display</p>
<?php
}
?>	 


</div>
  
<div class="tab-pane <?php echo $active_tab == 'given' ? 'show active' : 'fade';?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
<!--<th>Date</th><th>Job</th><th>Given to</th><th>Action</th>-->
<?php
if(count($allfeedback)>0)
{
foreach($allfeedback as $key=>$val)
{
$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);
/* $project_name=$this->auto_model->getFeild('title','jobs','job_id',$val['project_id']); */
$username=$this->auto_model->getFeild('username','user','user_id',$val['review_to_user']);
$employer_fname = $this->auto_model->getFeild('fname','user','user_id',$val['review_to_user']);
$employer_lname = $this->auto_model->getFeild('lname','user','user_id',$val['review_to_user']);
$employer_logo = get_user_logo($val['review_to_user']);
$employer_name = $employer_fname.' '.$employer_lname;
$private_feedback = get_row(array('select' => '*', 'from' => 'feedback', 'where' => array('project_id' => $val['project_id'], 'feedback_by_user' => $val['review_by_user'], 'feedback_to_user' => $val['review_to_user'])));

$u_type = getField('account_type','user','user_id',$val['review_by_user']);

if($val['review_by_agency'] > 0){
	$is_company = getField('is_company', 'agency', 'agency_id', $val['review_by_agency']);
	if($is_company > 0){
		$u_type = 'E';
	}else{
		$u_type = 'F';
	}
}


if($val['agency_id'] > 0){
	$username = $employer_name =getField('agency_name', 'agency', 'agency_id', $val['agency_id']);
}

if(!$project_name){
	$project_name = '--';
}

if($val['review_to_agency'] > 0){
	$employer_name = getField('agency_name', 'agency', 'agency_id', $val['review_to_agency']);
	$username = $employer_name;
}
$username = $employer_name;
$username = get_full_name($val['review_to_user']);

?>
<div class="job-listing ratingreview">	
    <div class="job-listing-details">
    	<div class="job-listing-company-logo">
        	<img src="<?php echo $employer_logo;?>" alt="" class="rounded-circle" />
        </div>
        <div class="job-listing-description">
        <h4><?php echo ucwords($project_name);?></h4>
		<div class="star-rating" data-rating="<?php echo $val['average'];?>"></div>
        <div class="ratingAll" hidden>
            
            <p><a href="javascript:void(0)" class="seeAll">See all skills rating <i class="zmdi zmdi-chevron-down"></i></a></p>
            <div class="ratingtext" style="display:none">
            <p><span>Skills: </span>
			<?php
            for($i=1; $i<=5; $i++){
                if($i <= $val['skills']){
                    echo ' <i class="zmdi zmdi-star"></i>';
                }else{
                    echo ' <i class="zmdi zmdi-star-outline"></i>';
                }
            }
            ?>
            </p>
	   
            <p><span>Quality of works: </span>
            <?php
            for($i=1; $i<=5; $i++){
                if($i <= $val['quality_of_work']){
                    echo ' <i class="zmdi zmdi-star"></i>';
                }else{
                    echo ' <i class="zmdi zmdi-star-outline"></i>';
                }
            }
            ?>
           </p>
           
           <p><span>Availability: </span>
            <?php
            for($i=1; $i<=5; $i++){
                if($i <= $val['availablity']){
                    echo ' <i class="zmdi zmdi-star"></i>';
                }else{
                    echo ' <i class="zmdi zmdi-star-outline"></i>';
                }
            }
            ?>
           </p>
           
           <p><span>Communication: </span>
            <?php
            for($i=1; $i<=5; $i++){
                if($i <= $val['communication']){
                    echo ' <i class="zmdi zmdi-star"></i>';
                }else{
                    echo ' <i class="zmdi zmdi-star-outline"></i>';
                }
            }
            ?>
           </p>
           
            <p><span>Cooperation: </span> 
            <?php
            for($i=1; $i<=5; $i++){
                if($i <= $val['cooperation']){
                    echo ' <i class="zmdi zmdi-star"></i>';
                }else{
                    echo ' <i class="zmdi zmdi-star-outline"></i>';
                }
            }
            ?>
           </p>
            </div>
        </div>
        <p><?php echo $val['comment'];?></p>
        
    </div>
    </div>
	<div class="job-listing-footer with-button">
    	<ul>
        	<li><span>Review by:</span> <b><?php echo ucwords($username);?></b></li>
            <li><i class="icon-feather-calendar"></i> <?php echo date('d M,Y',strtotime($val['added_date']));?></li>
            <li><a href="javascript:void(0)" class="btn btn-site btn-sm" onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($val); ?>' data-private-feedback='<?php echo json_encode($private_feedback); ?>' data-user-type="<?php echo $u_type;?>" data-name="<?php echo $employer_name; ?>">View</a></li>
            <?php /*?><li class="hide"><a href="javascript:void(0)"  onclick="editReview('<?php echo $val['review_id'];?>')"><i class="icon-feather-edit" title="Edit feedback"></i></a></li><?php */?>
        </ul>                
	</div>    
</div>

<?php
}
}
else
{
?>
<p class="text-center">Nothing to display</p>
<?php
}
?>	 
</div>
</div>

<div class="spacer-20"></div>
</asise>
</div>
</div>
</section>        
<script>

$(document).ready(function(){ 

$('.seeAll').click(function(){

	var content=$(this).closest('.ratingAll').find('.ratingtext');

	if(content.is(':visible')){

		content.hide();

	}else{

		$('.ratingtext').hide();

		content.show();

	}

});

}); 

</script>


<!-- View Feedback Modal -->
<div class="modal fade" id="readReviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	 <div class="modal-header">		
     <h4 class="modal-title" id="myModalLabel">Feedback By Vk Bishu</h4>
        <button type="button" class="close" onclick="$('#readReviewModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body" style="background-color:#f5f5f5">
		<div class="feedback mb-20" id="private_feedback_readonly_box">
		 <h4>Private Feedback</h4>
		 <div class="row mb-10">
			<div class="col-sm-6">Reason for ending contract</div>
			<div class="col-sm-6"><span id="reason_readonly"></span></div>
		 </div>
		 
		  <div class="row mb-10">
			<div class="col-sm-6">Recommend to friend</div>
			<div class="col-sm-6"><span id="recommend_to_friend_readonly"></span></div>
		 </div>
		 
		  <div class="row mb-10">
			<div class="col-sm-6">Your strength</div>
			<div class="col-sm-6"><span id="strength_readonly"></span></div>
		 </div>
		 
		  <div class="row mb-10">
			<div class="col-sm-6">English proficiency</div>
			<div class="col-sm-6"><span id="english_proficiency_readonly"></span></div>
		 </div>
		 
		</div>
		
		<div class="feedback" id="public_feedback_readonly_box">
        <h4>Public Feedback</h4>
        <div class="form-group">
        <div class='rating-widget'>
          <div class='rating-stars'>  
			<table class="table-rating">
				<tr class="F_show">
					<td><div id="rating_behaviour_readonly"></div></td>
					<td>Behavior</td>
				</tr>
				<tr class="F_show">
					<td><div id="rating_payment_readonly"></div></td>
					<td>Payment</td>
				</tr>
				
				<tr class="E_show">
					<td><div id="rating_skills_readonly"></div></td>
					<td>Skills</td>
				</tr>
				<tr class="E_show">
					<td><div id="rating_quality_readonly"></div></td>
					<td>Quality of works</td>
				</tr>
				<tr>
					<td><div id="rating_availablity_readonly"></div></td>
					<td>Availability</td>
				</tr>
				<tr>
					<td><div id="rating_communication_readonly"></div></td>
					<td>Communication</td>
				</tr>
				<tr>
					<td><div id="rating_cooperation_readonly"></div></td>
					<td>Cooperation</td>
				</tr>
			</table>
			
          </div>
	   </div>
		</div>
		
        <div id="comment_readonly"></div>
        
        </div>
      </div>	        	
    </div>
  </div>
</div>

<div class="modal fade" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      
    </div>
  </div>
</div>


<script>
 $(function () {
	
	/* read only star */
	
	$("#rating_behaviour_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
	});
	
	$("#rating_payment_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
	});
	
	
	$("#rating_skills_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
	});
	
	$("#rating_quality_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	
	$("#rating_availablity_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	
	$("#rating_communication_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	
	$("#rating_cooperation_readonly").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		readOnly: true
		
	});
	

});
 </script>

 
<script>

function ReadFeedback(ele){
	
	<?php
		$this->config->load('rating_reviews', TRUE);
		$reason = $this->config->item('reason', 'rating_reviews');
		$strength = $this->config->item('strength', 'rating_reviews');
		$english_proficiency = $this->config->item('english_proficiency', 'rating_reviews');
		$reason_arr = $strength_arr = $english_proficiency_arr = array();
		if(count($reason) > 0){
			foreach($reason as $k => $v){
				$reason_arr[$v['val']] = $v['text'];
			}
		}
		
		if(count($strength) > 0){
			foreach($strength as $k => $v){
				$strength_arr[$v['val']] = $v['text'];
			}
		}
		
		if(count($english_proficiency) > 0){
			foreach($english_proficiency as $k => $v){
				$english_proficiency_arr[$v['val']] = $v['text'];
			}
		}
	?>
	
	var reason , strength , english_proficiency;
	reason = <?php echo json_encode($reason_arr);?>;
	strength = <?php echo json_encode($strength_arr);?>;
	english_proficiency = <?php echo json_encode($english_proficiency_arr);?>;
	
	var public_feedback = $(ele).data('publicFeedback');
	var private_feedback = $(ele).data('privateFeedback');
	var name = $(ele).data('name');
	var u_type = $(ele).data('userType');
	
	if(!$.isEmptyObject(private_feedback)){
		
		if(reason[private_feedback.reason]){
			$('#private_feedback_readonly_box').find('#reason_readonly').html(reason[private_feedback.reason]);
		}else{
			$('#private_feedback_readonly_box').find('#reason_readonly').html('');
		}
		
		if(english_proficiency[private_feedback.english_proficiency]){
			$('#private_feedback_readonly_box').find('#english_proficiency_readonly').html(english_proficiency[private_feedback.english_proficiency]);
		}else{
			$('#private_feedback_readonly_box').find('#english_proficiency_readonly').html('');
		}
		
		
		if(private_feedback.strength){
			
			var strength_text_arr = [];
			var strength_arr = JSON.parse(private_feedback.strength);
		
			for(var i=0; i<strength_arr.length;i++){
				var st_txt = strength[strength_arr[i]] || '';
				
				strength_text_arr.push(st_txt);
			}
			
			$('#private_feedback_readonly_box').find('#strength_readonly').html(strength_text_arr.join(', '));
			/* console.log(strength_text_arr.join(','));
			console.log(strength_text_arr); */
			
		}else{
			$('#private_feedback_readonly_box').find('#strength_readonly').html('');
		}
		
		$('#private_feedback_readonly_box').find('#recommend_to_friend_readonly').html(private_feedback.recommend_to_friend);
		
	}else{
		$('#private_feedback_readonly_box').hide();
	}
	
	if(u_type == 'E'){
		$('.E_show').show();
		$('.F_show').hide();
		$("#rating_skills_readonly").rateYo("rating", public_feedback.skills);
		$("#rating_quality_readonly").rateYo("rating", public_feedback.quality_of_work);
	}else{
		$('.F_show').show();
		$('.E_show').hide();
		$("#rating_behaviour_readonly").rateYo("rating", public_feedback.behaviour);
		$("#rating_payment_readonly").rateYo("rating", public_feedback.payment);
	}

	$("#rating_availablity_readonly").rateYo("rating", public_feedback.availablity);
	$("#rating_communication_readonly").rateYo("rating", public_feedback.communication);
	$("#rating_cooperation_readonly").rateYo("rating", public_feedback.cooperation);
	$('#comment_readonly').html(public_feedback.comment);
	$('#readReviewModal').find('.modal-title').html('Review -' +  name);
	$('#readReviewModal').modal('show');
	
}

function editReview(review_id){
	var url = '<?php echo base_url('review/load_ajax_page?page=rating_review_edit&review_id=');?>'+review_id;
	load_ajax_modal(url);
}

</script>              