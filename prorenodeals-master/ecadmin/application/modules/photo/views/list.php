<?php // $this->load->library('session');  ?>
<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
            <li class="active"><a href="<?= base_url()?>"><i class="icon16 i-home-4"></i>Home</a></li>
			<li class="active">Photo List</li>
			<!--<li class="active"><a onclick="redirect_to('<?php //echo base_url() . 'advertisement/add'; ?>');">Add Photo</a></li>-->
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
                                <th>Id</th>
                                <th>Photo Title</th>
								<th>Business Name</th>
                                <th>photo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
					$attr = array(
					'onclick' => "javascript: return confirm('Do you want to delete?');",
					'class' => 'i-cancel-circle-2 red',
					'title' => 'Delete'
					);
					$atr3 = array(
						'onclick' => "javascript: return confirm('Do you want to active this?');",
						'class' => 'i-checkmark-3 red',
						'title' => 'Inactive'
					);
					$atr4 = array(
						'onclick' => "javascript: return confirm('Do you want to inactive this?');",
						'class' => 'i-checkmark-3 green',
						'title' => 'Active'
					);
						if(count($list)!=0){
						foreach ($list as $key => $photo) {
						   // print_r($list);
							?>
                                <tr>
                                    <td><?php echo $photo['photo_id']; ?></td>
                                    <td><?php echo $photo['photo_title']; ?></td>
									<td><?php echo $photo['business_name']; ?></td>
                                    <td align="center"> 
									<?php 
									if($photo['photo']!='')
									{?>
									  <img src="<?php echo SITE_URL."assets/business_photo/".$photo['photo'];?>" alt="" width="100" />						
									<?php }else {?>
									<img src="<?php echo SITE_URL."assets/business_photo/no_photo.jpg"?>" alt="" width="100" />
									<?php } ?>									
									</td>
                                    <td align="center">
                                        <?php
										if ($photo['status'] == 'Y') {
										echo anchor(base_url() . 'photo/change_photo_status/' . $photo['photo_id'].'/inact/'.$photo['status'], '&nbsp;', $atr4);
									
										} else {
									
										echo anchor(base_url() . 'photo/change_photo_status/' . $photo['photo_id'].'/act/'.$photo['status'], '&nbsp;', $atr3);
										}
								
								     ?>
									</td>
                                    <td align="center">
                                        <?php

                                        echo anchor(base_url() . 'photo/delete/' . $photo['photo_id'], '&nbsp;', $attr);
                                        ?>
                                    </td>
                                </tr>

<?php }
	}else{
	
 ?>
 							<tr>
                            	<td colspan="6" align="center" class="red">Records Not Found</td>                                                          	
                            </tr>
 
 <?php } ?>
                        </tbody>
                    </table>
				<?php if ($page>30) {?>    
                  
				  <?php echo $links; ?>
				    <?php  }?>
					
        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
