<?php // $this->load->library('session'); ?>
        <section id="content">
            <div class="wrapper">
                <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="#"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a onclick="" href="#">Settings</a></li>
                      <li class="active">settings list</li>
                    </ul>
                </div>
                
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
                            <table class="table table-hover table-bordered adminmenu_list">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="text-align:left;"></th>
                                        
										<th style="text-align:left;">Email</th>
										
										<th style="text-align:left;">City</th>
										
										<th style="text-align:left;">Mobile</th>
										<th >Create Date</th>
										<th>Active Status</th>
										<th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php
									 $onclick = "javascript: return confirm('Are you want to delete?');";
									$attr = array(
											      'onclick'=>$onclick,
												  'class'=>'i-cancel-circle-2 red',
												  'user_name'=>'Delete'
											      );
												  
    $atr3 = array('class'=>'i-close-4 red','title'=>'Inactive');
	$atr4 = array('class'=>'i-checkmark-4 green','title'=>'Active');
												  
foreach($list as $key=> $user ){ ?>

<tr>

<td><?php echo $user['id']?></td>
<td><?php echo $user['full_name']; ?></td>
<td><?php echo $user['email']; ?></td>
<td><?php echo $user['city']; ?></td>
<td><?php echo $user['mobile']; ?></td>
<td style="text-align:center"><?php echo $user['create_date']; ?></td>

<td align="center">
<?php
if($user['active_status']=='N'){ echo '<i class="i-close-4 red"></i>';
									}else{
									echo '<i class="i-checkmark-4 green"></i>';
									} 
?>
</td>
<td><?php
if($user['status']=='N'){ echo '<i class="i-close-4 red"></i>';
									}else{
									echo '<i class="i-checkmark-4 green"></i>';
									} 
?></td>

<td align="center">
	<?php 
	$atr1 = array('class'=>'i-eye-7','title'=>'View');
	$atr2 = array('class'=>'i-highlight','title'=>'Edit');
	$atr3 = array('class'=>'i-profile','title'=>'Profile');
	
	echo anchor(base_url().'user/edit/'.$user['id'],'&nbsp;',$atr1) ;
	
	echo anchor(base_url().'user/delete_user/'.$user['id'],'&nbsp;',$attr) ;
    echo anchor(base_url().'user/profile/'.$user['id'],'&nbsp;',$atr3) ;	
	?>
</td>
</tr>



<?php } ?>
                                </tbody>
                            </table>
                        
                </div> <!-- End .container-fluid  -->
            </div> <!-- End .wrapper  -->
        </section>
    