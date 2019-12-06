<?php // $this->load->library('session');  ?>
<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Contact Us List</a></li>
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
            
            <table class="table table-hover table-bordered adminmenu_list">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Email</th>
                        <th>Ticket</th>
                        <th>Comments</th>
                        <th align="center">Status</th>
                        <th align="right">Action</th>
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
if(count($list)!=0){
foreach ($list as $key => $con) {
        ?>
                        <tr>
                            <td><?php echo $con['id']; ?></td>
                            <td><?php echo $con['name']; ?></td>
                            <td><?php echo $con['subject']; ?></td>
                            <td><?= ucwords(substr($con['email'],'0','25')."...") ?></td>
                            
                            <td><?php echo $con['ticket']; ?></td>                        
                            <td><?php 
                            if(strlen($con['comments'])>30){
                                echo substr($con['comments'],0,30)."...";
                            }else{
                                echo $con['comments'];
                            }
                            ?></td>
                            <td align="center">
                                <?php
                                if ($con['status'] == 'Y') {
                                echo anchor(base_url() . 'contact/change_contact_status/' . $con['id'].'/inact/'.$con['status'], '&nbsp;', $atr4);
                            
                                } else {
                            
                                echo anchor(base_url() . 'contact/change_contact_status/' . $con['id'].'/act/'.$con['status'], '&nbsp;', $atr3);
                                }
                        
                             ?>
                            </td>
                            <td align="right">
                                <?php
                                $atr2 = array('class' => 'la la-envelope _165x', 'title' => 'Send Reply', 'style' => 'text-decoration:none',);

                                echo anchor(base_url() . 'contact/reply/' . $con['id'], '&nbsp;', $atr2);                   
                                echo anchor(base_url() . 'contact/delete/' . $con['id'], '&nbsp;', $attr);
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
            <?php }?>
					
        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
