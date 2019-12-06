<?php // $this->load->library('session');  ?>
<style>
.mybox {
	background-color: #F7F7F7;
	border: 1px solid #C9C9C9;
	margin: 0;
	padding: 4px;
}
.mybox:hover {
	background-color: #C9C9C9;
	color:#fff;
}
.myactiveclass {
	background-color: #C9C9C9;
	color:#fff;
}
</style>
<section id="content">
<div class="wrapper">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
      <li class="breadcrumb-item active"><a>Closed Member List</a></li>
    </ol>
  </nav>
  <div class="container-fluid">
    <?php $user_id = $this->uri->segment(3);
		//echo $id;
		?>
    <?php
                                    if ($this->session->flashdata('succ_msg')) {
                                        ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="la la-check-circle la-2x"></i> Well done!</strong>
      <?= $this->session->flashdata('succ_msg') ?>
    </div>
    <?php
                                    }
                                    if ($this->session->flashdata('error_msg')) {
                                        ?>
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="icon24 i-close-4"></i> Oh snap!</strong>
      <?= $this->session->flashdata('error_msg') ?>
    </div>
    <?php
                                    }
                                    ?>
    <table class="table table-bordered adminmenu_list checkAll" id="example1">
      <thead>
        <tr>
          <th>Id</th>
          <th>Logo</th>
          <th>User Name/Email</th>
          <th>Name</th>
          <th>Balance[<?php echo CURRENCY;?>]</th>
          <th>Membership Plan</th>
          <th>Join Date/Last Login</th>
          <th align="right">Action</th>
        </tr>
      </thead>
      <tbody id="id2">
        <?php
					$attr = array(
					'onclick' => "javascript: return confirm('Do you want to delete?');",
					'class' => 'i-cancel-circle-2 red',
					'title' => 'Delete'
					);
					$attr9 = array(
					'onclick' => "javascript: return confirm('Do you want to make feature this client?');",
					'class' => 'i-checkmark-3 red',
					'title' => 'Normal'
					);
					$attr8 = array(
					'onclick' => "javascript: return confirm('Do you want to remove featured from this client?');",
					'class' => 'i-checkmark-3 green',
					'title' => 'Featured'
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


if (count($all_data) != 0) {
    foreach ($all_data as $key => $user) {
		$plan=$this->auto_model->getFeild('name','membership_plan','id',$user['membership_plan']);
        ?>
        <tr>
          <td align="center"><?php echo $user['user_id']; ?></td>
          <td><?php if($user['logo']!='')
                                            {
												
                                            ?>
            <img src="<?= SITE_URL?>assets/uploaded/<?=$user['logo']?>" height="60" width="60"/>
            <?php
                                            }
                                            else 
                                            {
                                            ?>
            <img src="<?= SITE_URL?>assets/images/face_icon.gif" height="60" width="60"/>
            <?php
                                            }
                                            ?></td>
          <td><?php echo $user['username']."<br/>".$user['email']; ?></td>
          <td><?php echo ucwords($user['fname'])." ".ucwords($user['lname']); ?></td>
          <td><?php echo $user['acc_balance']; ?></td>
          <td><?php echo $plan;?></td>
          <td><?php echo date('d-M-Y H:i:s',strtotime($user['reg_date']))."<br/>".date('d-M-Y H:i:s',strtotime($user['edit_date'])); ?></td>
          <td align="right"><?php
                                            $atr1 = array('class' => 'la la-edit _165x', 'title' => 'Edit');
											$atr_view = array('class' =>'i-eye' ,'title'=> 'View Details');
                                            
                                            echo anchor(base_url() . 'member/edit_member/' . $user['user_id'],'&nbsp;', $atr1);
											echo anchor(base_url() . 'member/view_details/' .$user['user_id'],'&nbsp;', $atr_view);
                                          
											?></td>
        </tr>
        <?php } ?>
        <? } else { ?>
        <tr>
          <td colspan="10" align="center" class="red"> No Records Found </td>
        </tr>
        <? } ?>
      </tbody>
    </table>
    <!--<?php // if ($page>30) {?>    
                  
				    <div class="pagin"><p>Page:</p><a class="active"><?php //echo $links; ?></a></div>
				    <?php // }?>--> 
    
  </div>
  <!-- End .container-fluid  --> 
</div>
<!-- End .wrapper  -->
</section>
