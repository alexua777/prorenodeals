<link rel="stylesheet" href="<?=JS?>jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
	<script src="<?=JS?>jquery-ui-1/development-bundle/jquery-1.6.2.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#datepicker_from" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo IMAGE;?>caln.png",
			buttonImageOnly: true,
			dateFormat: 'yy-mm-dd'
		});
	});
	$(function() {
		$( "#datepicker_to" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo IMAGE;?>caln.png",
			buttonImageOnly: true,
			dateFormat: 'yy-mm-dd'
		});
	});
	</script>
<section id="content">
    <div class="wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url() ?>project/">Project List</a></li>
                <li class="breadcrumb-item active"><?php echo $project_name;?> <span>Workroom</span></li>
            </ol>
        </nav>


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
                	<form action="<?=base_url()?>project/employer_search/<?php echo $pid; ?>" method="get">
            
                    <div class="input-group-btn">
                   
					<input type="text" id="datepicker_from" name="from_txt" readonly="readonly" size="15" style="margin-right: 6px;"  value="<?php echo $from;?>"/>
					<input type="text" id="datepicker_to" name="to_txt" readonly="readonly" size="15" style="margin-right: 6px;"  value="<?php echo $to;?>"/>
                  
                    <input type="submit" name='' id="submit" class="btn" value="SEARCH">
                    </div></br>
                    </form>
						                    
                    
                    <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>
                            <tr>
                                <th style="text-align:left;">Freelancer Name</th>
                                <th style="text-align:left;">Date</th>
                                <th style="text-align:left;">Duration</th>
                                <th style="text-align:left;">Hourly Rate</th>
                                <th style="text-align:left;">Cost</th>
                                <th style="text-align:left;">Action</th>
                                <th style="text-align:left;">Payment Status</th>                                
                            </tr>
                        </thead>
                        
                   
<?php
//$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$pid,"bidder_id"=>$project_details[0]['bidder_id']));

foreach($tracker_details as $keys=>$vals)
{
	$freelancer_name=$this->auto_model->getFeild('fname','user','user_id',$project_details[0]['bidder_id'])." ".$this->auto_model->getFeild('lname','user','user_id',$project_details[0]['bidder_id']);
	
	$total_cost_new = 0;
	$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_details[0]['project_id'],'bidder_id'=>$vals['worker_id'])));
	$client_amt = $data['total_amt'];
			
	if($vals['minute'] > 0){
		$minute_cost_min = ($client_amt/60);
		$total_min_cost = $minute_cost_min *floatval($vals['minute']);
		$total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);
		$total_hours = floatval($vals['hour']);
		$total_mins = floatval($vals['minute']);
	}else{
		
		$seconds_new = 0;
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
		$total_mins = $minutes_new;
		
	}
	
	if(round($total_cost_new,2) == 0){
		continue;
	}

	/* $seconds_new = 0;
	$days_new    = 0;
	$hours_new   = 0;
	$minutes_new = 0;
	$seconds_new = 0;
	$total_cost_new = 0;
	
	$seconds_new = strtotime($vals['stop_time']) - strtotime($vals['start_time']);
	$days_new    = floor($seconds_new / 86400);
	$hours_new   = floor(($seconds_new - ($days_new * 86400)) / 3600);
	$minutes_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600))/60);
	$seconds_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600) - ($minutes_new*60)));
	$total_cost_new=$client_amt*(($days_new*24)+$hours_new+$minutes_new/60); */
	
	$payment='';
	if($vals['payment_status']=='N') {
				
		$payment='<span class="orange-text">Pending</span>';
		
	} elseif($vals['payment_status']=='P'){
		
		$payment='<span class="green-text">Paid</span>';
		
	}elseif($vals['payment_status']=='D'){
		
	   $payment='<span class="green-text">Disputed</span>';	
		
	}
			
?>




									<tbody>  
                                    <tr>  
                                        <td style="text-align:left;"><?php echo $freelancer_name;?></td>
                                        <td><?php echo date('d F, Y',strtotime($vals['start_time']));?></td>
                                       <td> <?php echo $total_hours;?> hours <?php echo $total_mins;?> minutes</td>
                                        
                                        <td><?php echo CURRENCY;?><?php echo $client_amt;?></td>
                                         <td><?php echo CURRENCY;?><?php echo $total_cost_new;?></td>
                                        <td><a href="<?php echo VPATH;?>project/screenshot/<?php echo $vals['id']?>/" class="view_screenshot">View screenshot</a></td>
                                        <td>
										<?php echo $payment;?>
										<?php if($vals['payment_status']!='P'){  ?>
										<a href="javascript:void(0)" class="btn btn-xs btn-site" onclick="confirm_first(this)" data-action-btn="release" data-item-id="<?php echo $vals['id']; ?>" data-type="tracker">Release</a>
										
										<?php }	?>
				
                                        </td> 
                                    </tr>	
                        			</tbody>
<?php
}
?>

              		</table>
                  <?php echo $links; ?>               

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>

<div id="confirmModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#confirmModal').modal('hide');">&times;</button>
        <h4 class="modal-title">Confirm</h4>
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


<script>

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
		url : '<?php echo base_url('project/release_manual_hour');?>',
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

function releaseTracker(id, ele){
	$(ele).attr('disabled', 'disabled').html('Checking...');
	
	$.ajax({
		url : '<?php echo base_url('project/release_hour');?>',
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