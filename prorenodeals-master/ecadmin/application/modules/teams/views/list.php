<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>        
        <li class="breadcrumb-item active"><a>Team List</a></li>
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
                     <?php /*?><form action="<?= base_url() ?>footer/search_parent_footers/0" method="post">
                         <table class="table table-hover table-bordered adminmenu_list" style="height: 15px; padding: 0;">
                        <tr>
                            <td>
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td style="width: 45%;">
                                         <select id="usr_select" name="usr_select"  class="select2 select_country required  form-control">
                        <option value="">--- Search By ---</option>
                        <option value="all" <?php if (isset($usr_select)) {
                if ($usr_select == 'all') echo "selected";
            } ?> >All</option>
                        <option value="footer_id" <?php if (isset($usr_select)) {
                if ($usr_select == 'footer_id') echo "selected";
            } ?> >Footer Id</option>
                        <option value="footer_cat_name" <?php if (isset($usr_select)) {
                if ($usr_select == 'footer_cat_name') echo "selected";
            } ?>>Footer Category Name</option>
                        <option value="footer_link" <?php if (isset($usr_select)) {
                if ($usr_select == 'footer_link') echo "selected";
            } ?>>Footer Link</option>
                    </select>   
                                        </td>
                                        <td>
                                <input type="text" placeholder="Enter search element ..." class="searchfield " name="search_element" size="30" value="<?php if (isset($search_element)) {
                echo $search_element;
            } ?>">
                            </td>
                            <td>
                                <input type="submit" name='submit' id="submit" class="btn btn-default" value="SEARCH">
                            </td>
                                    </tr>
                                </table>
                                
                            </td>
                            
                            <td align="right" style="width: 10%;">
                                <table>
                                    <tr>
                                        <td>
                                   <a href="<?= base_url() ?>footer/add_parent_footer">	<input class="btn btn-default" type="button" value="Add Parent Footer"></a>         
                                        </td>
                                    </tr>
                                </table>
                                
                            </td>
                        </tr>
                    </table>
                     </form><?php */?>

                    <table class="table table-hover table-bordered adminmenu_list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Image</th>
                                <th>Description</th>
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

                            //$atr3 = array('class' => 'i-close-4 red', 'title' => 'Inactive');
                            //$atr4 = array('class' => 'i-checkmark-4 green', 'title' => 'Active');

                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
                                    ?>

                                    <tr>

                                        <td style="text-align:left;"><?= $val['id'] ?></td>
                                        <td><?= ucwords($val['name']) ?></td>
										<td><?= ucwords($val['role']); ?></td>
                                        <td align="center">
										<?php if($val['image']!='')
										{
										?>
                                        <img src="<?= SITE_URL?>assets/team_image/<?=$val['image']?>" height="60" width="60"/>
										<?php
										}else{ ?>
											
											  <img src="<?php echo SITE_URL . "assets/award_image/noimg.jpg" ; ?>" style="max-height: 60px; max-width: 60px;" />
											<?php
											
											} ?>
										</td>
                                        <td><?php echo ucwords($val['description']);?></td>
                                        <td align="center">
                                            <?php
                                            if ($val['status'] == 'Y') {
                                                echo anchor(base_url() . 'teams/change_status/' . $val['id'] .'/inact', '&nbsp;', $atr4);
                                            } else {

                                                echo anchor(base_url() . 'teams/change_status/' . $val['id'] . '/act', '&nbsp;', $atr3);
                                            }
                                            ?>




                                        </td>
                                        <td align="center">
                                            <?php
                                           $atr2 = array('class' => 'i-highlight', 'title' => 'Edit');
                                            echo anchor(base_url() . 'teams/edit/' . $val['id'], '&nbsp;', $atr2);
                                            echo anchor(base_url() . 'teams/change_status/' . $val['id'] . '/' . 'del/', '&nbsp;', $attr);
                                            ?>

                                        </td>
                                    </tr>



                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" align="center">No records found...</td>
                                </tr>

    <?php
}
?>
                        </tbody>
                    </table>
                    <?php /* if ($page>30) {?>    

                      <div class="pagin"><p>Page:</p><a class="active"><?php echo $links; ?></a></div>
                      <?php } */ ?>                

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
