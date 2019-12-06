
                    <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>
                            <tr>
                                <th style="text-align:left;">Product Name</th>
                                <th style="text-align:left;">Company Name</th>
                                <th style="text-align:left;">Product No</th>
                                <th style="text-align:left;">NAFDAC No</th>
                                <th style="text-align:left;">Manufacture Date</th>
                                <th style="text-align:left;">Expire Date</th>
                                <th style="text-align:center;" id="stt">Status</th>
                                <th style="text-align:center;" id="acc">Action</th>
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
							?>
                            <div id="prodlist">
                            <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
                                    ?>

                                    <tr>

                                        <td style="text-align:left;"><?= ucwords($val['name']) ?></td>
                                        <td><?= ucwords($val['company']) ?></td>
                                        <td><?= $val['product_no'] ?></td>
                                        <td><?= $val['nafdac_no'] ?></td>
                                        <td><?= $val['manufacture_date'] ?></td>
                                        <td><?= $val['expire_date'] ?></td>
                                        <td align="center" id="st">
                                            <?php
                                            if ($val['status'] == 'Y') {
                                                echo anchor(base_url() . 'product/change_status/' . $val['id'] .'/inact', '&nbsp;', $atr4);
                                            } else {

                                                echo anchor(base_url() . 'product/change_status/' . $val['id'] . '/act', '&nbsp;', $atr3);
                                            }
                                            ?>




                                        </td>
                                        <td align="center" id="ac">
                                            <?php
                                            $atr2 = array('class' => 'i-pencil', 'title' => 'Edit Company');
                                            echo anchor(base_url() . 'product/edit_product/' . $val['id'].'/', '&nbsp;', $atr2);
                                            echo anchor(base_url() . 'product/change_status/' . $val['id'] . '/' . 'del/', '&nbsp;', $attr);
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
              </div>
                    <?php /* if ($page>30) {?>    

                      <div class="pagin"><p>Page:</p><a class="active"><?php echo $links; ?></a></div>
                      <?php } */ ?>
