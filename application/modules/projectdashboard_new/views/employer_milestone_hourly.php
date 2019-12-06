<section id="mainpage">
<div class="container-fluid">
<div class="row">
	<?php $this->load->view('dashboard/dashboard-left'); ?>

<aside class="col-lg-10 col-md-9 col-12">

    <div class="row">

    <div class="col-lg-9 col-12">
<?php echo $breadcrumb; ?>
    <!-- Nav tabs -->

    <?php $this->load->view('employer_tab'); ?>

    

    <!-- Tab panes -->

    <div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="overview">

            

            <?php 

            $succ_msg = get_flash('succ_msg');

            ?>

            <?php if(!empty($succ_msg)){ ?>

            <div class="alert alert-success alert-dismissable">

              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

              <strong>Success!</strong> <?php echo $succ_msg; ?>

            </div>

            <?php } ?>

            

            <h4>Work Record</h4> 

            <div class="clearfix"></div>

            <div class="table-responsive">

            <table class="table">

             <thead>

                <tr>

                    <th>Requested By</th>

                    <th>Start Date</th>

                    <th>End Date</th>

                    <th>Duration</th>

                    <th>Hourly Rate</th>

                    <th>Cost</th>

                    <th>Type</th>

                     <th>Payment Status</th>

                    <th>Action</th>

                </tr>

             </thead>

            <tbody>

                <?php

                if(count($tracker_details)>0){  foreach($tracker_details as $keys=>$vals){ 

                

                $total_cost_new = 0;

                $data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$vals['worker_id'])));

                $client_amt = $data['total_amt'];

                

                if($vals['minute'] > 0){

                    $minute_cost_min = ($client_amt/60);

                    $total_min_cost = $minute_cost_min *floatval($vals['minute']);

                    $total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);

                    $total_hours = floatval($vals['hour']);

                    $total_mins = floatval($vals['minute']);

                }else{

                    

                   /*  $seconds_new = 0;

                    $days_new    = 0;

                    $hours_new   = 0;

                    $minutes_new = 0;

                    $total_cost_new = 0;

                    

                    $seconds_new = strtotime($vals['stop_time']) - strtotime($vals['start_time']);

                    $days_new    = floor($seconds_new / 86400);

                    $hours_new   = floor(($seconds_new - ($days_new * 86400)) / 3600);

                    $minutes_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600))/60);

                    $seconds_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600) - ($minutes_new*60)));

                    $total_cost_new=$client_amt*(($days_new*24)+$hours_new+$minutes_new/60);

                    

                    $total_hours = ($days_new*24)+$hours_new;

                    $total_mins = $minutes_new; */

					

					$minute_cost_min = ($client_amt/60);

					$total_min_cost = 0; // 0 minutes 

					$total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);

					$total_hours = floatval($vals['hour']);

					$total_mins = floatval($vals['minute']);

				

                    

                }

                

                if(round($total_cost_new,2) == 0){

                    continue;

                }

                

                /* $minute_cost_min = ($client_amt/60);

                $total_min_cost = $minute_cost_min *floatval($vals['minute']);

                $total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost); */

                

                $name = getField('fname', 'user', 'user_id', $vals['worker_id']);

               if($vals['payment_status']=='N') {

				

                $payment='<span class="orange-text">Not invoiced</span>';

				

				}elseif($vals['payment_status']=='I') {

					

					$payment='<span class="blue-text">Invoiced</span>';

					

				}elseif($vals['payment_status']=='C') {

					

					$payment='<span class="blue-text">Cancelled</span>';

					

				}  elseif($vals['payment_status']=='P'){

					

					$payment='<span class="green-text">Paid</span>';

					

				}elseif($vals['payment_status']=='D'){

					

				   $payment='<span class="green-text">Disputed</span>';	

					

				}

                

                ?>

                <tr>

                    <td><?php echo $name; ?></td>

                    <td><?php echo date('d F, Y',strtotime($vals['start_time']));?></td>

                    <td><?php echo date('d F, Y',strtotime($vals['stop_time']));?></td>

                    <td> <?php echo $total_hours;?> hours <?php echo $total_mins;?> minutes</td>

                    <td class="text-center"><?php echo CURRENCY;?><?php echo format_money($client_amt) ;?></td> 

                    <td><?php echo CURRENCY; ?><?php echo format_money($total_cost_new);?></td>

                    <td>

					<?php 

					if($vals['is_manual'] == 0){ 

						echo 'Auto';

					}else{

						echo 'Manual';

					}

					?>

					

					</td>

                    <td><?php echo $payment;?></td>

                    

                    <td>

                    <?php /*if($vals['payment_status']!='P'){  ?>

                    <a href="javascript:void(0)" class="btn btn-xs btn-site" onclick="confirm_first(this)" data-action-btn="release" data-item-id="<?php echo $vals['id']; ?>" data-type="tracker">Release</a> <br/> <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="editHourRequest('<?php echo $vals['id']; ?>', 'tracker')">Edit Hours</a><br/>

                    

                    <?php }*/	?>

					<?php if($vals['is_manual'] == 0){ ?>

                    <a href="<?php echo base_url('projectdashboard_new/screenshot/'.$vals['id'])?>" class="btn btn-xs btn-info">View Screenshots</a>

					<?php } ?>

                    </td>

                    

                </tr> 

                <?php  } }else{ ?>

                <tr>

                    <td colspan="10" style="text-align:left;">No data found!!</td>

                </tr>

                <?php } ?>

                

                

            </tbody>

            </table>

            </div>

           

            

    </div>

    

    

    </div>

    </div>

    <?php $this->load->view('right-section');?>

	</div>

</aside>

</div>

</div>

</section>





<div id="editHourModal" class="modal fade" role="dialog">

  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
      <h5 class="modal-title">Edit Hour Request</h5>
        <button type="button" class="close" onclick="$('#editHourModal').modal('hide');">&times;</button>
      </div>

      <div class="modal-body">

		<form id="editRequestForm" class="form-horizontal" onsubmit="sendEditRequest(this, event)" action="<?php echo base_url('projectdashboard_new/hour_edit_request_ajax'); ?>">

			<input type="hidden" name="manual_tracker_id" value=""/>

			<input type="hidden" name="hour_type" value=""/>

			<div class="row">

                <label class="col-sm-4">Total Duration:</label>       

				<div class="col-sm-4 col-12">
					<div class="form-field">
                		<input type="number" class="form-control" placeholder="Total hour" required name="duration" value=""/>
                    </div>
               </div>

			   <div class="col-sm-4 col-12">
               <div class="form-field">
			   <select class="form-control" name="minute">

			   <option value="0">Minutes</option>

			    <?php for($i=5;$i<60;$i++){ 

				if($i%5 == 0){?>

				 <option value="<?php echo $i; ?>"><?php echo $i; ?></option>

				<?php } } ?>

			   </select>

			  </div>

               </div>

            </div>

			

			<div class="row">

                <label class="col-sm-4">Comments:</label>      

                <div class="col-sm-8 col-12">
                <div class="form-field">
                	<textarea name="comment" class="form-control"></textarea>
                </div>
                </div>

            </div>

			

			<div class="row">           

                <div class="col-sm-8 offset-sm-4 col-12">

                    <input type="submit" class="btn btn-site" value="Send Request" name="submit">

                    <button type="button" class="btn btn-default pull-right" onclick="$('#editHourModal').modal('hide');">Close</button>  

                </div>

            </div>

			

		</form>

      </div>

    </div>



  </div>

</div>





<div id="activityModal" class="modal fade" role="dialog">

  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
      <h5 class="modal-title">Activity</h5>
        <button type="button" class="close" onclick="$('#activityModal').modal('hide');">&times;</button>
      </div>

      <div class="modal-body">

	  

       <div id="activity_ajax"></div>

	   <b>Comment : </b>

	   <div id="activity_cmt"></div>

	   

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#activityModal').modal('hide');">Close</button>

      </div>

    </div>



  </div>

</div>



<div id="confirmModal" class="modal fade" role="dialog">

  <div class="modal-dialog">



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">
<h5 class="modal-title">Confirm</h5>
        <button type="button" class="close" onclick="$('#confirmModal').modal('hide');">&times;</button>

        

      </div>

      <div class="modal-body">

		<div id="fundError"></div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-site" id="confirm_ok_btn">OK</button>

        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#confirmModal').modal('hide');">Cancel</button>

      </div>

    </div>



  </div>

</div>



<script type="text/javascript">



$('body').on('click', function (e) {

    $('[data-toggle="popover"]').each(function () {

        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {

            $(this).popover('hide');

        }

    });

});





function sendEditRequest(f, e){

	

	ajaxSubmit(f , e , function(res){

		

		if(res.status == 1){

			location.reload();

		}

		

	});

}

	

function loadActivity(act, ele){

	var cmt = $(ele).data('comment');

	if(cmt == ''){

		cmt = 'N/A';

	}

	$('#activity_cmt').html(cmt);

	$.get('<?php echo base_url('projecthourly/getactivity?activity=')?>'+act, function(res){

		$('#activity_ajax').html(res);

		

	});

	$('#activityModal').modal('show');

	

}



function editHourRequest(req_id, type){

	var edit_type = type || 'manual';

	$('#editRequestForm').find('[name="manual_tracker_id"]').val(req_id);

	$('#editRequestForm').find('[name="hour_type"]').val(edit_type);

	$('#editHourModal').modal('show');

}





function ajaxSubmit(f, e , callback){

	

	$('.invalid').removeClass('invalid');

	e.preventDefault();

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

		}

	});

}





function confirm_first(ele){

	$('#confirmModal').modal('show');

	var action_btn = $(ele).data('actionBtn');

	var item_id = $(ele).data('itemId');

	var relase_type = $(ele).data('type') || 'manual';

	

	if(action_btn == 'release'){

		$('#confirmModal').find('.modal-body').html('Are you sure to relase this milestone ? ');

		if(relase_type == 'tracker'){

			$('#confirmModal').find('#confirm_ok_btn').attr('onclick', "releaseTracker('"+item_id+"', this)");

		}else{

			$('#confirmModal').find('#confirm_ok_btn').attr('onclick', "releaseManual('"+item_id+"', this)");

		}

		

	}

}





function releaseManual(id, ele){

	$(ele).attr('disabled', 'disabled').html('Checking...');

	

	$.ajax({

		url : '<?php echo base_url('projectdashboard_new/release_manual_hour');?>',

		data: {id : id},

		dataType: 'json',

		type: 'POST',

		success: function(res){

			if(res.status == 1){

				location.reload();

			}else{

				var errors = res.errors;

				if(errors){

					for(var i in errors){

						$('#'+i+'Error').html(errors[i]);

					}

				}

			}

			

			//$(ele).removeAttr('disabled').html('OK').attr('onclick', "$('#confirmModal').modal('hide')");

		}

	});

}



function releaseTracker(id, ele){

	$(ele).attr('disabled', 'disabled').html('Checking...');

	

	$.ajax({

		url : '<?php echo base_url('projectdashboard_new/release_hour');?>',

		data: {id : id},

		dataType: 'json',

		type: 'POST',

		success: function(res){

			if(res.status == 1){

				location.reload();

			}else{

				var errors = res.errors;

				if(errors){

					for(var i in errors){

						$('#'+i+'Error').html(errors[i]);

					}

				}

			}

			

		}

	});

}

</script>

