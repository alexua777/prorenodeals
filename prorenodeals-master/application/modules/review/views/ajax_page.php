<?php if($page=='rating_review'){ ?>
<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.css"/>
<script src="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.js"></script>

<style>
.table-rating td {
    padding: 7px 16px 8px 0px;
}
</style>

<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLabel"><?php echo $title; ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<form class="form-horizontal" onsubmit="return false;" action="<?php echo base_url('review/post_review_ajax');?>" id="ratingReviewForm">
		
		<input type="hidden" name="review_to_user" value="<?php echo $review_to_user;?>"/>
		<input type="hidden" name="review_from_agency" value="<?php echo $review_from_agency;?>"/>
		<input type="hidden" name="review_to_agency" value="<?php echo $review_to_agency;?>"/>
		<input type="hidden" name="agency_id" value="<?php echo $agency_id;?>"/>
		<input type="hidden" name="job_id" value="<?php echo $job_id; ?>"/>
		<input type="hidden" name="review_to" value="<?php echo $review_to; ?>"/>
		
		<div class="feedback">
			<h4>Public Feedback</h4>
			<h6>This feedback share worldwide</h6>
			<div class="form-group">
			<div class="col-xs-12">
			<label hidden>Feedback to Freelancer</label>  
			
			<?php if($review_to == 'freelancer' || $review_to == 'agency'){ ?>
			<div class='rating-widget'>
			  <div class='rating-stars'>  
				<table class="table-rating">
					<tr>
						<td><div id="rating_skills"></div></td>
						<td>Skills</td>
					</tr>
					<tr>
						<td><div id="rating_quality"></div></td>
						<td>Quality of works</td>
					</tr>
					<tr>
						<td><div id="rating_availablity"></div></td>
						<td>Availability</td>
					</tr>
					<tr>
						<td><div id="rating_communication"></div></td>
						<td>Communication</td>
					</tr>
					<tr>
						<td><div id="rating_cooperation"></div></td>
						<td>Cooperation</td>
					</tr>
				</table>
				
				
				<input type="hidden" name="public[skills]" value="0" id="rating_skills_input"/>
				<input type="hidden" name="public[quality_of_work]" value="0" id="rating_quality_input"/>
				<input type="hidden" name="public[availablity]" value="0" id="rating_availablity_input"/>
				<input type="hidden" name="public[communication]" value="0" id="rating_communication_input"/>
				<input type="hidden" name="public[cooperation]" value="0" id="rating_cooperation_input"/>
				<input type="hidden" name="public[average]" value="0" id="rating_average_input"/>
			  </div>
		   </div>
		   <?php } ?>
		   
		   <?php if($review_to == 'employer' || $review_to == 'company'){ ?>
		   <div class='rating-widget'>
			  <div class='rating-stars'>  
				<table class="table-rating">
					<tr>
						<td><div id="rating_behaviour"></div></td>
						<td>Behavior</td>
					</tr>
					<tr>
						<td><div id="rating_payment"></div></td>
						<td>Payment</td>
					</tr>
					<tr>
						<td><div id="rating_availablity"></div></td>
						<td>Availability</td>
					</tr>
					<tr>
						<td><div id="rating_communication"></div></td>
						<td>Communication</td>
					</tr>
					<tr>
						<td><div id="rating_cooperation"></div></td>
						<td>Cooperation</td>
					</tr>
				</table>
				
				
				<input type="hidden" name="public[behaviour]" value="0" id="rating_behaviour_input"/>
				<input type="hidden" name="public[payment]" value="0" id="rating_payment_input"/>
				<input type="hidden" name="public[availablity]" value="0" id="rating_availablity_input"/>
				<input type="hidden" name="public[communication]" value="0" id="rating_communication_input"/>
				<input type="hidden" name="public[cooperation]" value="0" id="rating_cooperation_input"/>
				<input type="hidden" name="public[average]" value="0" id="rating_average_input"/>
			  </div>
		   </div>
			<?php } ?>
			
			<h4>Total Score: <span id="avg_rating_view">0</span></h4>
			
			</div>
			</div>
			<div class="form-group">
			<div class="col-xs-12">
			<label>Comments:</label>
			<div data-error-wrapper="comment">
			<textarea rows="4" class="form-control"  name="public[comment]" placeholder="Type your comment here.."></textarea>
			</div>
			</div>
			</div>
			
			<div id="freelancer_payment_endError"></div>
			<div id="succ_msg"></div>
		</div>
	</form>
</div>

 <div class="modal-footer">
	<button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary" onclick="submitRating()" id="submit_btn">Submit</button>
</div>

<?php if($review_to == 'freelancer' || $review_to == 'agency'){ ?>
<script>
 $(function () {
	 
	$("#rating_skills").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_skills_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_quality").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_quality_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_availablity").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_availablity_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_communication").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_communication_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_cooperation").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_cooperation_input').val(rating);
			check_total_rating();
		}
	});
	
	/* read only star */
	
	/* $("#rating_behaviour_readonly").rateYo({
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
		
	}); */
	

});


function check_total_rating(){
	var rating_skills_input = parseInt($('#rating_skills_input').val());
	var rating_quality_input = parseInt($('#rating_quality_input').val());
	var rating_availablity_input = parseInt($('#rating_availablity_input').val());
	var rating_communication_input = parseInt($('#rating_communication_input').val());
	var rating_cooperation_input = parseInt($('#rating_cooperation_input').val());
	
	var avg = ((rating_skills_input + rating_quality_input + rating_availablity_input + rating_communication_input + rating_cooperation_input) / 5); 
	$('#rating_average_input').val(avg);
	$('#avg_rating_view').html(avg);
}

</script>
<?php } ?>
 
 <?php if($review_to == 'employer' || $review_to == 'company'){ ?>
<script>
 $(function () {
	 
	$("#rating_behaviour").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_behaviour_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_payment").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_payment_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_availablity").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_availablity_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_communication").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_communication_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_cooperation").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : 0,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_cooperation_input').val(rating);
			check_total_rating();
		}
	});
	
	/* read only star */
	
	/* $("#rating_skills_readonly").rateYo({
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
		
	}); */
	
	

});

function check_total_rating(){
	var rating_behaviour_input = parseInt($('#rating_behaviour_input').val());
	var rating_payment_input = parseInt($('#rating_payment_input').val());
	var rating_availablity_input = parseInt($('#rating_availablity_input').val());
	var rating_communication_input = parseInt($('#rating_communication_input').val());
	var rating_cooperation_input = parseInt($('#rating_cooperation_input').val());
	
	var avg = ((rating_behaviour_input + rating_payment_input + rating_availablity_input + rating_communication_input + rating_cooperation_input) / 5); 
	$('#rating_average_input').val(avg);
	$('#avg_rating_view').html(avg);
}

</script>

<?php } ?>
 
<script>
 
function submitRating(){
	var redirect_to = '<?php echo $next ? base_url($next) : ''; ?>';
	$('.error-bx').empty();
	$('.invalid').removeClass('invalid');
	$('.incorrect_parent').removeClass('incorrect_parent');
	
	var f_data = $('#ratingReviewForm').serialize();
	var action =  $('#ratingReviewForm').attr('action');
	var submit_btn_txt  = $('#submit_btn').text();
	$('#submit_btn').attr('disabled', 'disabled');
	$('#submit_btn').text('Processing..');
	$.ajax({
		url : action,
		data: f_data,
		dataType: 'json',
		type: 'POST',
		success: function(res){
			if(res.errors){
				for(var i in res.errors){
					i = i.replace('[]', '');
					$('[name="'+i+'"]').addClass('invalid');
					$('[data-error-wrapper="'+i+'"]').addClass('incorrect_parent');
					$('#'+i+'Error').html(res.errors[i]).addClass('error-bx');
				}
				
				var offset = $('.invalid:first').offset();
				
				if(offset){
					$('html, body').animate({
						scrollTop: offset.top - 150
					});
				}
				
				
			}else{
				$('#succ_msg').html('<div class="alert alert-success"><strong>Success!</strong> '+res.msg+' </div>');
				if(redirect_to){
					window.location.href = redirect_to;
				}
			}
			
			$('#submit_btn').removeAttr('disabled');
			$('#submit_btn').text(submit_btn_txt);
			
		}
	});
}

</script>

<?php } ?>


<?php if($page=='rating_review_edit'){ ?>

<style>
.table-rating td {
    padding: 7px 16px 8px 0px;
}
</style>

<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLabel"><?php echo $title; ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<form class="form-horizontal" onsubmit="return false;" action="<?php echo base_url('review/post_review_ajax');?>" id="ratingReviewForm">
		
		<input type="hidden" name="review_to_user" value="<?php echo $review_to_user;?>"/>
		<input type="hidden" name="review_from_agency" value="<?php echo $review_from_agency;?>"/>
		<input type="hidden" name="review_to_agency" value="<?php echo $review_to_agency;?>"/>
		<input type="hidden" name="agency_id" value="<?php echo $review_to_agency;?>"/>
		<input type="hidden" name="job_id" value="<?php echo $job_id; ?>"/>
		<!--<input type="hidden" name="review_id" value="<?php echo $review_id; ?>"/>-->
		<input type="hidden" name="review_to" value="<?php echo $review_to; ?>"/>
		
		<div class="feedback">
			<h4>Public Feedback</h4>
			<h6>This feedback share worldwide</h6>
			<div class="form-group">
			<div class="col-xs-12">
			<label hidden>Feedback to Freelancer</label>  
			
			<?php if($review_to == 'freelancer' || $review_to == 'agency'){ ?>
			<div class='rating-widget'>
			  <div class='rating-stars'>  
				<table class="table-rating">
					<tr>
						<td><div id="rating_skills"></div></td>
						<td>Skills</td>
					</tr>
					<tr>
						<td><div id="rating_quality"></div></td>
						<td>Quality of works</td>
					</tr>
					<tr>
						<td><div id="rating_availablity"></div></td>
						<td>Availability</td>
					</tr>
					<tr>
						<td><div id="rating_communication"></div></td>
						<td>Communication</td>
					</tr>
					<tr>
						<td><div id="rating_cooperation"></div></td>
						<td>Cooperation</td>
					</tr>
				</table>
				
				
				<input type="hidden" name="public[skills]" value="<?php echo $skills;?>" id="rating_skills_input"/>
				<input type="hidden" name="public[quality_of_work]" value="<?php echo $quality_of_work;?>" id="rating_quality_input"/>
				<input type="hidden" name="public[availablity]" value="<?php echo $availablity;?>" id="rating_availablity_input"/>
				<input type="hidden" name="public[communication]" value="<?php echo $communication;?>" id="rating_communication_input"/>
				<input type="hidden" name="public[cooperation]" value="<?php echo $cooperation;?>" id="rating_cooperation_input"/>
				<input type="hidden" name="public[average]" value="<?php echo $average;?>" id="rating_average_input"/>
			  </div>
		   </div>
		   <?php } ?>
		   
		   <?php if($review_to == 'employer' || $review_to == 'company'){ ?>
		   <div class='rating-widget'>
			  <div class='rating-stars'>  
				<table class="table-rating">
					<tr>
						<td><div id="rating_behaviour"></div></td>
						<td>Behavior</td>
					</tr>
					<tr>
						<td><div id="rating_payment"></div></td>
						<td>Payment</td>
					</tr>
					<tr>
						<td><div id="rating_availablity"></div></td>
						<td>Availability</td>
					</tr>
					<tr>
						<td><div id="rating_communication"></div></td>
						<td>Communication</td>
					</tr>
					<tr>
						<td><div id="rating_cooperation"></div></td>
						<td>Cooperation</td>
					</tr>
				</table>
				
				
				<input type="hidden" name="public[behaviour]" value="<?php echo $behaviour;?>" id="rating_behaviour_input"/>
				<input type="hidden" name="public[payment]" value="<?php echo $payment;?>" id="rating_payment_input"/>
				<input type="hidden" name="public[availablity]" value="<?php echo $availablity;?>" id="rating_availablity_input"/>
				<input type="hidden" name="public[communication]" value="<?php echo $communication;?>" id="rating_communication_input"/>
				<input type="hidden" name="public[cooperation]" value="<?php echo $cooperation;?>" id="rating_cooperation_input"/>
				<input type="hidden" name="public[average]" value="<?php echo $average;?>" id="rating_average_input"/>
			  </div>
		   </div>
			<?php } ?>
			
			<h4>Total Score: <span id="avg_rating_view"><?php echo $average > 0 ? $average : 0; ?></span></h4>
			
			</div>
			</div>
			<div class="form-group">
			<div class="col-xs-12">
			<label>Comments:</label>
			<div data-error-wrapper="comment">
			<textarea rows="4" class="with-border"  name="public[comment]" placeholder="Type your comment here.."><?php echo $comment;?></textarea>
			</div>
			</div>
			</div>
			
			<div id="freelancer_payment_endError"></div>
			<div id="succ_msg"></div>
		</div>
	</form>
</div>

 <div class="modal-footer">
	<button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary" onclick="submitRating()" id="submit_btn">Submit</button>
</div>

<?php if($review_to == 'freelancer' || $review_to == 'agency'){ ?>
<script>
 $(function () {
	 
	$("#rating_skills").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : <?php echo $skills > 0 ? $skills : 0; ?>,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_skills_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_quality").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : <?php echo $quality_of_work > 0 ? $quality_of_work : 0; ?>,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_quality_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_availablity").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : <?php echo $availablity > 0 ? $availablity : 0; ?>,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_availablity_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_communication").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : <?php echo $communication > 0 ? $communication : 0; ?>,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_communication_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_cooperation").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : <?php echo $cooperation > 0 ? $cooperation : 0; ?>,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_cooperation_input').val(rating);
			check_total_rating();
		}
	});
	
	/* read only star */
	
	/* $("#rating_behaviour_readonly").rateYo({
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
		
	}); */
	

});


function check_total_rating(){
	var rating_skills_input = parseInt($('#rating_skills_input').val());
	var rating_quality_input = parseInt($('#rating_quality_input').val());
	var rating_availablity_input = parseInt($('#rating_availablity_input').val());
	var rating_communication_input = parseInt($('#rating_communication_input').val());
	var rating_cooperation_input = parseInt($('#rating_cooperation_input').val());
	
	var avg = ((rating_skills_input + rating_quality_input + rating_availablity_input + rating_communication_input + rating_cooperation_input) / 5); 
	$('#rating_average_input').val(avg);
	$('#avg_rating_view').html(avg);
}

</script>
<?php } ?>
 
 <?php if($review_to == 'employer' || $review_to == 'company'){ ?>
<script>
 $(function () {
	 
	$("#rating_behaviour").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : <?php echo $behaviour > 0 ? $behaviour : 0; ?>,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_behaviour_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_payment").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : <?php echo $payment > 0 ? $payment : 0; ?>,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_payment_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_availablity").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : <?php echo $availablity > 0 ? $availablity : 0; ?>,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_availablity_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_communication").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : <?php echo $communication > 0 ? $communication : 0; ?>,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_communication_input').val(rating);
			check_total_rating();
		}
	});
	
	$("#rating_cooperation").rateYo({
		normalFill: "#ddd",
		ratedFill: "#FF912C",
		rating    : <?php echo $cooperation > 0 ? $cooperation : 0; ?>,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			$('#rating_cooperation_input').val(rating);
			check_total_rating();
		}
	});
	
	/* read only star */
	
	/* $("#rating_skills_readonly").rateYo({
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
		
	}); */
	
	

});

function check_total_rating(){
	var rating_behaviour_input = parseInt($('#rating_behaviour_input').val());
	var rating_payment_input = parseInt($('#rating_payment_input').val());
	var rating_availablity_input = parseInt($('#rating_availablity_input').val());
	var rating_communication_input = parseInt($('#rating_communication_input').val());
	var rating_cooperation_input = parseInt($('#rating_cooperation_input').val());
	
	var avg = ((rating_behaviour_input + rating_payment_input + rating_availablity_input + rating_communication_input + rating_cooperation_input) / 5); 
	$('#rating_average_input').val(avg);
	$('#avg_rating_view').html(avg);
}

</script>

<?php } ?>
 
<script>
 
function submitRating(){
	var redirect_to = '<?php echo $next ? base_url($next) : ''; ?>';
	$('.error-bx').empty();
	$('.invalid').removeClass('invalid');
	$('.incorrect_parent').removeClass('incorrect_parent');
	
	var f_data = $('#ratingReviewForm').serialize();
	var action =  $('#ratingReviewForm').attr('action');
	var submit_btn_txt  = $('#submit_btn').text();
	$('#submit_btn').attr('disabled', 'disabled');
	$('#submit_btn').text('Processing..');
	$.ajax({
		url : action,
		data: f_data,
		dataType: 'json',
		type: 'POST',
		success: function(res){
			if(res.errors){
				for(var i in res.errors){
					i = i.replace('[]', '');
					$('[name="'+i+'"]').addClass('invalid');
					$('[data-error-wrapper="'+i+'"]').addClass('incorrect_parent');
					$('#'+i+'Error').html(res.errors[i]).addClass('error-bx');
				}
				
				var offset = $('.invalid:first').offset();
				
				if(offset){
					$('html, body').animate({
						scrollTop: offset.top - 150
					});
				}
				
				
			}else{
				location.reload();
			}
			
			$('#submit_btn').removeAttr('disabled');
			$('#submit_btn').text(submit_btn_txt);
			
		}
	});
}

</script>

<?php } ?>
