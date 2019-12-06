<style>
.mybox{
	background-color: #F7F7F7;
	border: 1px solid #C9C9C9;
	margin: 0;
	padding: 4px;

}
.mybox:hover{
	background-color: #C9C9C9;
	color:#fff;
}
.myactiveclass{
	background-color: #C9C9C9;
	color:#fff;
}

</style>

<section id="content">
    <div class="wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="la la-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url() ?>project/">Project List</a></li>
                <li class="breadcrumb-item active">Project Management <?php echo "(".$status.")";?></li>
            </ol>
        </nav>

        <div class="container-fluid">                                                    
            <div class="row">
                <div class="col-sm-12">
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

        													                    
					<form action="<?php echo base_url('project/search_project').'/'.$status; ?>" method="get">
                    <div class="input-group mb-3">
                      <input type="text" placeholder="Enter project title ..." class="searchfield form-control" name="search_element" id="srch" value="<?php echo !empty($srch['search_element'])?$srch['search_element'] : ''; ?>" >
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search...</button>
                      </div>
                    </div>                    		                    
					</form>                                          
						                    
                     <div id="prod">
                    <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>
                            <tr>
                                <th>Project Id</th>
                                <th>Title</th>
                                <th>Budget(Min/Max)</th>
                                <th>Type</th>
                                <th>Creator</th>
                                <th style="width:11%">Date</th>
                                <th>Bids</th>
                                
                                <?php
								
								if($this->uri->segment(2)=='open')
										{
											?>
                                <th>Status</th>
                                <?php
										}
								?>
                                <th style="width:15%" align="right" id="acc">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                       
                            <?php
                            $attr = array(
                                'onclick' => "javascript: return confirm('Do you want to delete?');",
                                'class' => 'la la-times _165x red',
                                'title' => 'Delete'
                            );
                            $atr3 = array(
                                'onclick' => "javascript: return confirm('Do you want to active this?');",
                                'class' => 'la la-check-circle _165x red',
                                'title' => 'Inactive'
                            );
                            $atr4 = array(
                                'onclick' => "javascript: return confirm('Do you want to inactive this?');",
                                'class' => 'la la-check-circle _165x green',
                                'title' => 'Active'
                            );
							  $atr5 = array(
                                'class' => 'la la-gavel _165x green',
                                'title' => 'Bid List'
                            );
							
							$atr6 = array(
                                'class' => 'la la-list-alt _165x red',
                                'title' => 'Milestone List'
                            );
							
							$atr7 = array(
                                'class' => 'la la-list _165x orange',
                                'title' => 'View Transaction History'
                            );
							$atr8 = array(
                                'class' => 'la la-home _165x yellow',
                                'title' => 'View Workroom'
                            );

                            //$atr3 = array('class' => 'i-close-4 red', 'title' => 'Inactive');
                            //$atr4 = array('class' => 'i-checkmark-4 green', 'title' => 'Active');
							?>
                            
                            
                            <div id="prodlist">
                            <?php
							
                            if (count($all_data) > 0) { 
                                foreach ($all_data as $key => $val) {
                                    ?>

                                    <tr>  
                                        <td><?=$val['project_id'] ?></td>
                                        <td><?= ucwords(substr($val['title'],'0','30')."...") ?></td>
                                        <td>
                                        <?php if($val['buget_min']==0){
												echo CURRENCY." ".$val['buget_max'];
											  }else{
											
											    echo CURRENCY." ".$val['buget_min']." / ".CURRENCY." ".$val['buget_max'] ;
										      }
										 ?>
                                        </td>
                                        
                                        <?php if($val['project_type']=='F'){
											
											$type = "Fixed";
										}elseif($val['project_type']=='H'){
											$type = "Hourly";
										}?>
                                        
                                        <td><?= $type ?></td>
                                         <td><?= $val['user_name'] ?></td>
                                        <td><?= date('d-M-Y',strtotime($val['post_date'])) ?></td>
                                        <td align="center"><?php echo $val['bid_count'] ;?></td>
                                 
                                        
                                        <?php 
										if( $this->uri->segment(2)=='open')
										{ echo " <td>";
                                         if ($val['projectstatus'] == 'Y') {
										echo anchor(base_url() . 'project/change_project_status/' . $val['id'].'/inact/'.$val['projectstatus'].'/'.$this->uri->segment(2), '&nbsp;', $atr4);
									
										} else {
									
										echo anchor(base_url() . 'project/change_project_status/' . $val['id'].'/act/'.$val['projectstatus'].'/'.$this->uri->segment(2), '&nbsp;', $atr3);
										}
										echo '</td>';
										}
                                        ?>
                                        <td align="right" id="ac">
                                            <?php
                                            $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit Project');
										      echo anchor(base_url() . 'project/bid_list/'.$val['project_id'], '&nbsp;', $atr5);
                                              if($val['status']=='O'){
											  echo anchor(base_url() . 'project/edit_project/' . $val['status'].'/'.$val['id'], '&nbsp;', $atr2);
                                              echo anchor(base_url() . 'project/change_status/'. $val['status'].'/' . $val['id'] . '/' . 'del', '&nbsp;', $attr);
											  }
											  
											  if($val['status']=='E'){
											   echo anchor(base_url() . 'project/change_status/'. $val['status'].'/' . $val['id'] . '/' . 'del', '&nbsp;', $attr);
											   }
											  
											  if($val['milestone_count']>0)
											  {
											  		echo anchor(base_url() . 'project/milestone_list/' . $val['project_id'], '&nbsp;', $atr6);											  
											  }
											  if($val['project_type']=='H'){
											
													echo anchor(base_url() . 'project/employer/' . $val['project_id'], '&nbsp;', $atr8);  
											  }
											echo anchor(base_url() . 'fund/project_all_transaction/' . $val['project_id'], '&nbsp;', $atr7);  
                                            ?>

                                        </td>
                                    </tr>
									</div>

                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" align="center" style="color:#F00;">No records found...</td>
                                </tr>
							
    <?php
}
?>
						
                        </tbody>
                    </table>
              		</div>
                  <?php echo $links; ?>
                </div><!-- End .col-lg-6  -->
            </div><!-- End .row-fluid  -->

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
<script>
/*
function hdd()
{
	var elmnt=$('#srch').val();
	
	window.location.href='<?php echo base_url();?>project/search_project/<?php echo $status;?>/'+elmnt+'/';		
}*/
</script>
 