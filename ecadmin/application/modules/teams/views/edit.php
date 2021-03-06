<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="active"><a href="<?= base_url() ?>teams/">Team Management</a></li>

            </ul>
        </div>

        <div class="container-fluid">
            
			<?php
            $id = $this->uri->segment(3);
            ?>
            <div class="row">
                <div class="col-lg-12">
				
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
     
				
				
				
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                            <h4>Add/Modify Award </h4>
                        
                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->

                        <div class="panel-body">
                  <form id="validate" action="<?php echo base_url(); ?>teams/edit/<?=$all_data[0]['id']?>" class="form-horizontal" role="form" name="team" method="post" enctype="multipart/form-data">
			   
					  <input type="hidden" name="currimg" value="<?php echo $all_data[0]['image']; ?>" />

                               
								
								
								 <div class="form-group">
								<label class="col-lg-2 control-label" for="required">Member Name</label>
								<div class="col-lg-6">
									<input type="text" id="required" value="<?php if(isset($all_data[0]['name'])){ echo $all_data[0]['name'];  }?>" name="name" class="required form-control">
									<?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?>
								</div>
							</div>
							<!-- End .control-group  -->
								
							<div class="form-group">
								<label class="col-lg-2 control-label" for="required">Member Role</label>
								<div class="col-lg-6">
									<select id="required"  name="role" class="required form-control">
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach($desig as $key=>$val)
									{
									?>
                                    <option value="<?php echo $val['id'];?>" <?php if($val['id']==$all_data[0]['role']){echo "selected";}?>><?php echo $val['designation'];?></option>
                                    <?php
									}
									?>
                                    </select>
									<?php echo form_error('role', '<label class="error" for="required">', '</label>'); ?>
								</div>
							</div>
							<!-- End .control-group  -->				
						
						 <div class="form-group">
                                    <label class="col-lg-2 control-label" for="agree">Add image</label>
                                    <div class="col-lg-6">
                                    <?php
                                            if ($all_data[0]['image'] != '') {
                                                ?>
                                             
                                            <img src="<?php echo SITE_URL . "assets/team_image/" . $all_data[0]['image']; ?>" style="max-height: 75px; max-width: 100px;" />

                                            <?php }else{ ?>
											
											  <img src="<?php echo SITE_URL . "assets/award_image/noimg.jpg" ; ?>" style="max-height: 75px; max-width: 100px;" />
											<?php
											
											} ?><br />
                                        <input class="form-control" type="file" id="userfile" name="userfile"/>
								</div>
						</div>
                                 <!-- End .control-group  -->
								 
								 
								 		
							<div class="form-group">
						<label class="col-lg-2 control-label" for="elastic">Short Description</label>
						<div class="col-lg-6">
							<textarea class="required form-control elastic" id="textarea1" rows="3" name="description" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 76px;"><?php if(isset($all_data[0]['description'])){ echo $all_data[0]['description'];  }?></textarea>
						</div>
				</div>
				<!-- End .control-group  -->
						

					<div class="form-group">
						<label class="col-lg-2 control-label" for="agree">Status</label>
						<label class="checkbox-inline">
							<input class="form-control" type="radio" id="status" name="status" value="Y" checked="checked" <?php if (isset($all_data[0]['status']) && $all_data[0]['status'] == 'Y') {
					echo "checked";
					} ?> />Online<input class="form-control" <?php if (isset($all_data[0]['status']) && $all_data[0]['status'] == 'N') {
					echo "checked";
					} ?> type="radio" id="status" name="status" Value="N">Offline
						</label>
					</div>

                                <!-- End .control-group  -->
                                <div class="form-group">
                                    <div class="col-lg-offset-2">
                                        <div class="pad-left15">
                                            <input type="submit" name="submit" class="btn btn-primary" value="Add">
                                            <button type="button" onclick="redirect_to('<?php echo base_url() . 'teams/'; ?>');" class="btn">Cancel</button>
                                        </div>
                                    </div>
                                </div><!-- End .form-group  -->

                            </form>
                        </div><!-- End .panel-body -->
                    </div><!-- End .widget -->
                </div><!-- End .col-lg-12  --> 
            </div><!-- End .row-fluid  -->

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
