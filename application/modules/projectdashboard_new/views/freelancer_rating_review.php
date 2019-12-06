<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.css"/>
<script src="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.js"></script>
<style>
.table-rating {
}
.table-rating td {
	padding : 7px 16px 8px 0px;
}
</style>

<!-- End Contract Modal -->

<div class="modal fade" id="readReviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Feedback By Vk Bishu</h5>
        <button type="button" class="close" onclick="$('#readReviewModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" style="background-color:#f5f5f5">
		<div style="display:none;">
        <div class="feedback" id="private_feedback_readonly_box">
          <h4>Private Feedback</h4>
          <div class="row">
            <div class="col-sm-6">Reason for ending contract</div>
            <div class="col-sm-6"><span id="reason_readonly"></span></div>
          </div>
          <div class="row">
            <div class="col-sm-6">Recommend to friend</div>
            <div class="col-sm-6"><span id="recommend_to_friend_readonly"></span></div>
          </div>
          <div class="row">
            <div class="col-sm-6">Your strength</div>
            <div class="col-sm-6"><span id="strength_readonly"></span></div>
          </div>
          <div class="row">
            <div class="col-sm-6">English proficiency</div>
            <div class="col-sm-6"><span id="english_proficiency_readonly"></span></div>
          </div>
        </div>
		</div>
        <div class="feedback" id="public_feedback_readonly_box">
          <h4>Public Feedback</h4>
          <div class="form-group">
            <div class="col-xs-12">
              <div class='rating-widget'>
                <div class='rating-stars'>
                  <table class="table-rating">
                    <tr class="employer_public_feedback">
                      <td><div id="rating_behaviour_readonly"></div></td>
                      <td>Behavior</td>
                    </tr>
                    <tr class="employer_public_feedback">
                      <td><div id="rating_payment_readonly"></div></td>
                      <td>Payment</td>
                    </tr>
                    <tr class="freelancer_public_feedback">
                      <td><div id="rating_skills_readonly"></div></td>
                      <td>Skills</td>
                    </tr>
                    <tr class="freelancer_public_feedback">
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
          </div>
          <div class="clearfix"></div>
          <div class="form-group">
            <div class="col-xs-12">
              <div id="comment_readonly"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  onclick="$('#readReviewModal').modal('hide');">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- End Contract Modal -->

<div class="modal fade" id="contractModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="form-horizontal" onsubmit="submitEndContractForm(this, event)" action="<?php echo base_url('projectdashboard_new/end_contract')?>" id="endContractForm">
        <input type="hidden" name="employer_id" value="<?php echo $project_detail['user_id']; ?>"/>
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>"/>
        <div class="modal-header">
          <h5 class="modal-title">End contract with VK Bishu </h5>
          <button type="button" class="close" onclick="$('#contractModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="background-color:#f5f5f5">
          <p>Share your experience</p>
          <div class="feedback">
            <h4>Public Feedback</h4>
            <h6>This feedback share worldwide</h6>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Feedback to Employer</label>
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
                <h4>Total Score: <span id="avg_rating_view">0</span></h4>
                <div id="review_id_field"></div>
                <div id="feedback_id_field"></div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Comments:</label>
                <textarea rows="4" class="form-control"  name="public[comment]" placeholder="Type your comment here.."></textarea>
              </div>
            </div>
            <div id="freelancer_payment_end"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default"  onclick="$('#contractModal').modal('hide');">Cancel</button>
          <button type="submit" class="btn btn-site">End Contract</button>
        </div>
      </form>
    </div>
  </div>
</div>
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

	

	$('.activityLOG').popover({

		 selector: '[rel=infopop]',

         trigger: "click",

		}).on("show.bs.popover", function(e){

		$("[rel=infopop]").not(e.target).popover("destroy");

		$(".popover").remove();                    

	});

	



});

 </script> 
<script type="text/javascript">



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





function requestDate(f, e){

	

	ajaxSubmit(f, e , function(res){

		if(res.status == 1){

			location.reload();

		}

	});

}





function ajaxSubmit(f, e , callback){

	

	$('.invalid').removeClass('invalid');

	e.preventDefault();

	var btn_txt = $(f).find('[type="submit"]').text();

	$(f).find('[type="submit"]').attr('disabled', 'disabled');

	$(f).find('[type="submit"]').html('Saving..');

	var fdata = $(f).serialize();

	var url = $(f).attr('action');

	$.ajax({

		url : url,

		data: fdata,

		dataType: 'json',

		type: 'POST',

		success: function(res){

			if(res.errors){

				for(var i in res.errors){

					i = i.replace('[]', '');

					$('[name="'+i+'"]').addClass('invalid');

					$('#'+i+'Error').html(res.errors[i]);

				}

				

				var offset = $('.invalid:first').offset();

				

				if(offset){

					$('html, body').animate({

						scrollTop: offset.top

					});

				}

				

				

			}

			

			if(typeof callback == 'function'){

				callback(res);

			}

			$(f).find('[type="submit"]').removeAttr('disabled');

			$(f).find('[type="submit"]').html(btn_txt);

		}

	});

}



function newFeedbackOpen(ele){

	var f_id = $(ele).data('employerId');

	var name = $(ele).data('name');

	var project_id = $(ele).data('projectId');

	

	if(project_id && project_id != ''){

		$('#endContractForm').find('[name="project_id"]').val(project_id);

	}

	

	if(f_id && f_id != ''){

		$('#endContractForm').find('[name="employer_id"]').val(f_id);

	}

	

	$('#endContractForm').find('button[type="submit"]').html('Submit Feedback');

	$('#endContractForm').attr('action', '<?php echo base_url('projectdashboard_new/update_review_employer')?>');

	

	$('#contractModal').find('.modal-title').html('Give feedback to ' + name);

	$('#contractModal').modal('show');

	

	resetPublicData();

}



function updateFeedback(ele){

	var f_id = $(ele).data('employerId');

	var name = $(ele).data('name');

	var project_id = $(ele).data('projectId');

	

	var public_feedback = $(ele).data('publicFeedback');



	if(public_feedback){

		setPublicData(public_feedback);

	}

	

	if(project_id && project_id != ''){

		$('#endContractForm').find('[name="project_id"]').val(project_id);

	}

	

	if(f_id && f_id != ''){

		$('#endContractForm').find('[name="employer_id"]').val(f_id);

	}

	

	$('#endContractForm').find('button[type="submit"]').html('Update Feedback');

	$('#endContractForm').attr('action', '<?php echo base_url('projectdashboard_new/update_review_employer')?>');

	

	$('#contractModal').find('.modal-title').html('Update feedback of ' + name);

	$('#contractModal').modal('show');

}



function setPublicData(data){

	

	var f = $('#endContractForm');

	var review_id = data.review_id;

	

	$('#review_id_field').html('<input type="hidden" name="review_id" value="'+review_id+'"/>');

	

	f.find('[name="public[behaviour]"]').val(data.behaviour);

	f.find('[name="public[payment]"]').val(data.payment);

	f.find('[name="public[availablity]"]').val(data.availablity);

	f.find('[name="public[communication]"]').val(data.communication);

	f.find('[name="public[cooperation]"]').val(data.cooperation);

	f.find('[name="public[average]"]').val(data.average);

	f.find('[name="public[comment]"]').val(data.comment);

	

	$("#rating_behaviour").rateYo("rating", data.behaviour);

	$("#rating_payment").rateYo("rating", data.payment);

	$("#rating_availablity").rateYo("rating", data.availablity);

	$("#rating_communication").rateYo("rating", data.communication);

	$("#rating_cooperation").rateYo("rating", data.cooperation);

	

}



function resetPublicData(){

	var f = $('#endContractForm');

	

	$('#review_id_field').html('');

	

	f.find('[name="public[behaviour]"]').val(0);

	f.find('[name="public[payment]"]').val(0);

	f.find('[name="public[availablity]"]').val(0);

	f.find('[name="public[communication]"]').val(0);

	f.find('[name="public[cooperation]"]').val(0);

	f.find('[name="public[average]"]').val(0);

	f.find('[name="public[comment]"]').val('');

	

	$("#rating_behaviour").rateYo("rating", 0);

	$("#rating_payment").rateYo("rating", 0);

	$("#rating_availablity").rateYo("rating", 0);

	$("#rating_communication").rateYo("rating", 0);

	$("#rating_cooperation").rateYo("rating", 0);

}



function submitEndContractForm(f , e){

	ajaxSubmit(f , e , function(res){

		if(res.status == 1){

			location.reload();

		}

	});

}



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

	

	$('tr.freelancer_public_feedback').show();

	$('tr.employer_public_feedback').hide();

	$('#private_feedback_readonly_box').show();

	

	$("#rating_skills_readonly").rateYo("rating", public_feedback.skills);

	$("#rating_quality_readonly").rateYo("rating", public_feedback.quality_of_work);

	$("#rating_availablity_readonly").rateYo("rating", public_feedback.availablity);

	$("#rating_communication_readonly").rateYo("rating", public_feedback.communication);

	$("#rating_cooperation_readonly").rateYo("rating", public_feedback.cooperation);

	$('#comment_readonly').html(public_feedback.comment);

	$('#readReviewModal').find('.modal-title').html('Feedback by ' +  name);

	$('#readReviewModal').modal('show');

	

}





function ReadGivenFeedback(ele){

	

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

			

		

		}else{

			$('#private_feedback_readonly_box').find('#strength_readonly').html('');

		}

		

		$('#private_feedback_readonly_box').find('#recommend_to_friend_readonly').html(private_feedback.recommend_to_friend);

		

	}else{

		$('#private_feedback_readonly_box').hide();

	}

	

	$('tr.freelancer_public_feedback').hide();

	$('tr.employer_public_feedback').show();

	

	$("#rating_behaviour_readonly").rateYo("rating", public_feedback.behaviour);

	$("#rating_payment_readonly").rateYo("rating", public_feedback.payment);

	$("#rating_availablity_readonly").rateYo("rating", public_feedback.availablity);

	$("#rating_communication_readonly").rateYo("rating", public_feedback.communication);

	$("#rating_cooperation_readonly").rateYo("rating", public_feedback.cooperation);

	$('#comment_readonly').html(public_feedback.comment);

	$('#readReviewModal').find('.modal-title').html('Feedback to ' +  name);

	$('#readReviewModal').modal('show');

	

}



</script>