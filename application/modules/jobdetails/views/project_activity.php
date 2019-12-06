<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53a028a2284897c6"></script>
<script type="text/javascript" src="<?php echo JS;?>jQuery-plugin-progressbar.js"></script>
<link href="<?php echo CSS;?>jQuery-plugin-progressbar.css" rel="stylesheet" type="text/css">
<?php //print_r($project);?>
<section class="breadcrumb-classic">  
  <div class="container">
    <div class="row">
    <aside class="col-sm-6 col-xs-12">
		<h3>job Activity</h3>
    </aside>
    <aside class="col-sm-6 col-xs-12">
         <ol class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li><a href="<?php echo base_url('findjob');?>">Find Job</a></li>
      <li class="active"><a href="<?php echo base_url('projectdashboard/employer/'.$pid);?>">Project dashboard</a></li>
      <li class="active">job Activity</li>
  </ol>  
    </aside>            
    </div>
	</div>       
</section>            
<div class="clearfix"></div>
<section class="sec">
	<div class="container">
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10 col-xs-12">
				<h3><?php echo $project[0]['title']; ?></h3>
				<br/>
				<h4>Activity List <?php if($uid == $owner_id){ ?><a href="#myModal" class="btn btn-site pull-right btn-sm" data-toggle="modal" data-target="#myModal">Create Activity</a><?php } ?></h4>
				
				
				<div class="panel-group" id="accordion" style="margin-top: 20px;">	
				<?php if(count($activity_list) > 0){foreach($activity_list as $k => $v){ 
				?>
					
					  <div class="panel panel-default">
						<div class="panel-heading">
						  <h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $k+1;?>">
							<?php echo $v['task'];?><span class="badge pull-right"><?php echo count($v['assigned_user']); ?></span>
                            <span class="pull-right" style="font-size:18px;padding: 0 10px;margin-top:-3px"><i class="fa fa-eye" title="View detail"></i></span></a>
						  </h4>
						</div>
						<div id="collapse<?php echo $k+1;?>" class="panel-collapse collapse" style="padding:20px;">
							<p><b>Description : </b><?php echo !empty($v['desc']) ? $v['desc'] : 'N/A';?></p>							
							<p><b>Assigned To</b></p>							
							<?php if(count($v['assigned_user']) > 0){foreach($v['assigned_user'] as $u){ ?>
								<p><?php echo $u['fname'].' '.$u['lname']; ?>
								<?php if($u['approved'] == 'Y'){
									echo '<span class="pull-right">Approved</span>';
								}else{
									echo '<span class="pull-right">Not Approved yet</span>';
								}								
								?>
								</p>
							<?php } }else{ ?>
							 <p>Not assigned to anyone</p>
							<?php } ?>
							
						</div>
					  </div>
					
				<?php } } ?>
				</div>
			</div>
		</div>
	</div>
</section>          
 
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Activity</h4>
      </div>
      <div class="modal-body">
        <?php if($uid == $owner_id){ ?>
				<form action="<?php echo base_url('jobdetails/activity/'.$project[0]['project_id'])?>" method="post" id="create_activity_form">
					<label>Project</label>
					<p><b><?php echo $project[0]['title']; ?></b></p>
					<div class="form-group">
						<label>Title</label>
						<input type="text" class="form-control" name="task" value="">
						<?php echo form_error('task', '<div class="error">', '</div>');?>
					 </div>
					 
					 <div class="form-group">
						<label>Description</label>
						<textarea class="form-control" name="desc"></textarea>
						<?php echo form_error('desc', '<div class="error">', '</div>');?>
					 </div>
					
							<div class="form-group">
					<label>Assigned To</label>
					<?php
						$bidder = !empty($project[0]['bidder_id']) ? explode(',', $project[0]['bidder_id']) : array();
						
						if(count($bidder) > 0){
							foreach($bidder as $k => $v){
								
															
					//$user_detail = get_row(array('select' => 'fname,lname,user_id', 'from' => 'user', 'where' => array('user_id' => $v)));
					$user_detail = $this->db->select('fname,lname,user_id')->where(array('user_id' => $v))->get('user')->row_array();
						?>
						<div class="checkbox">
						  <label><input type="checkbox" name="freelancer[]" value="<?php echo $user_detail['user_id']; ?>"><?php echo $user_detail["fname"].' '.$user_detail["lname"]; ?></label>
						</div>
						<?php 	} } ?>
						<?php echo form_error('freelancer[]', '<div class="error">', '</div>');?>
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-site">Create</button>
					 </div>
					 
				</form>
				<?php } ?>	
      </div>
      
    </div>

  </div>
</div>

<?php if(!empty($_GET['action']) AND $_GET['action'] == 'add'){ ?>
<script>
	$(document).ready(function(){
		$('#myModal').modal('show');
	});
</script>
<?php } ?>