<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li><a href="">Dispute Details</a></li>
				<li>Dispute Management</li>
            </ul>
        </div>

        <div class="container-fluid">
            
			<?php
            //$year = $this->uri->segment(3);
            ?>
				
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
					<?php
                    if ($this->session->flashdata('msg_sent')) {
                        ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?= $this->session->flashdata('msg_sent') ?>
                        </div> 
                        <?php
                    }
                    if ($this->session->flashdata('msg_failed')) {
                        ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('msg_failed') ?>
                        </div>
    <?php
}
if ($this->session->flashdata('amt_error')) {
                        ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('amt_error') ?>
                        </div>
    <?php
}
?>
     
				
				   <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5>Conversations</h5>
                                        <a href="#" class="minimize"></a>
                                    </div><!-- End .panel-heading -->
                                
                                    <div class="panel-body ">
                                        
                                        <div class="chat-layout">
                                            <ul>
                                            <?php
											$i=1;
                                            foreach($disput_conversation as $key=>$val)
											{
												if($i%2!=0)
												{
													$cl="leftside";	
												}
												else
												{
													$cl="rightside";	
												}
												$user_fname="Admin";
												$user_lname="";
												$user_pic="";
												if($val['user_id']!='0')
												{
												$user_fname=$this->auto_model->getFeild("fname","user","user_id",$val['user_id']);
												$user_lname=$this->auto_model->getFeild("lname","user","user_id",$val['user_id']); 
												$user_pic=$this->auto_model->getFeild("logo","user","user_id",$val['user_id']); 
												}
											?>
                                            <li class="clearfix <?php echo $cl;?>">
                                                    <div class="user">
                                                        <div class="avatar">
                                                        <?php
                                                        if($user_pic!='')
														{
														?>
                                                        <img src="<?php echo SITE_URL;?>assets/uploaded/<?php echo $user_pic;?>" alt="<?php echo $user_fname;?>">
                                                        <?php	
														}
														else
														{
														?>
                                                            <img src="<?php echo SITE_URL;?>assets/images/face_icon.gif" alt="<?php echo $user_fname;?>">
                                                       <?php
														}
													   ?>
                                                        </div>
                                                        <span class="ago"><?php echo date('M d',strtotime($val['add_date']));?></span>
                                                    </div>
                                                    <div class="message">
                                                        <span class="name"><?php echo $user_fname." ".$user_lname;?></span>
                                                        <span class="txt"><?php echo $val['message'];?></span><br>
                                                        <span class="txt"><a href="<?php echo SITE_URL;?>assets/dispute_file/<?php echo $val['attachment'];?>" target="_blank"><?php echo $val['attachment'];?></a></span>
                                                    </div>
                                                </li>
                                            <?php
												$i++;	
											}
											?>
                                             
                                            </ul>
                                            <form method="post" class="form-horizontal pad15 pad-bottom0" role="form" action="<?php echo VPATH;?>fund/message/<?php echo $disput_details['id']?>/">
                                                <div class="form-group">
                                                    <div class="col-lg-9">
                                                    <?php
													$project_id=$this->auto_model->getFeild('project_id','milestone_payment','id',$disput_details["milestone_id"]);
													?>
													<input type="hidden" name="project_id" value="<?php echo $project_id;?>"/>
                                                        <input class="form-control" type="text" name="message" placeholder="Enter your message ...">
                                                        <?php echo form_error('message', '<label class="error" for="required">', '</label>'); ?>
                                                    </div> 
                                                    <div class="col-lg-3">
                                                        <button class="btn btn-primary col-lg-12" type="submit">Send</button>
                                                    </div>                                                    
                                                    
                                                </div><!-- End .form-group  -->
                                            </form>
                                        </div>

                                    </div><!-- End .panel-body -->
                                </div>
				
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5>Settlemnet Dispute</h5>
                        
                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->

                        <div class="panel-body">
                  <form id="validate" action="<?php echo VPATH;?>fund/acceptOffer/<?php echo $disput_details['id']?>/" class="form-horizontal" role="form" name="team"  method="post" enctype="multipart/form-data">

                               
								<div class="form-group">
								<label class="col-lg-2 control-label" for="required">Total Disputed Amount (<?php echo CURRENCY;?>)</label>
								<div class="col-lg-6">
									<?php echo $disput_details['disput_amt'];?>
									<?php echo form_error('emp_amt', '<label class="error" for="required">', '</label>'); ?>
								</div>
							</div>
								
								<div class="form-group">
								<label class="col-lg-2 control-label" for="required">Employer Amount (<?php echo CURRENCY;?>)</label>
								<div class="col-lg-6">
									<input type="text" id="required" value="<?php echo $disput_discuss[0]['employer_amt']; ?>" name="emp_amt" class="required form-control">
									<?php echo form_error('emp_amt', '<label class="error" for="required">', '</label>'); ?>
								</div>
							</div>
							 
												
						
						 <div class="form-group">
								<label class="col-lg-2 control-label" for="required">Worker Amount (<?php echo CURRENCY;?>)</label>
								<div class="col-lg-6">
									<input type="text" id="required" value="<?php echo $disput_discuss[0]['worker_amt']; ?>" name="worker_amt" class="required form-control">
									<?php echo form_error('worker_amt', '<label class="error" for="required">', '</label>'); ?>
								</div>
							</div>
                           
      
                                <div class="form-group">
                                    <div class="col-lg-offset-2">
                                        <div class="pad-left15">
                                            <input type="submit" name="submit" class="btn btn-primary" value="Release Amount">
                                            <button type="button" onclick="redirect_to('<?php echo base_url() . 'fund/dispute/'; ?>');" class="btn">Cancel</button>
                                        </div>
                                    </div>
                                </div> 

                            </form>
                        </div><!-- End .panel-body -->
                    </div><!-- End .widget -->
                

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
