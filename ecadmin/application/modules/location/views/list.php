<?php // $this->load->library('session');   ?>

<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url() . 'location/add'; ?>">Add City</a></li>
        <li class="breadcrumb-item active">City List</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <form name="srch_city" action="<?php echo VPATH;?>location/getcity/" method="post">
        <div class="row">
          <div class="col-md-4">
            <select class="form-control" name="country" disabled>
              <option value="">Please Select</option>
              <?php
                      foreach($country_list as $key=>$val)
                      {
                        ?>
              <option value="<?php echo $val['code'];?>" <?php echo $val['code'] == 'CAN' ? 'selected' : '';?>><?php echo $val['name']?></option>
              <?php	  
                        }
                      ?>
            </select>
          </div>
          <div class="col-md-4">
            <input type="submit" name="sub" value="Search" class="btn btn-primary" />
          </div>
          <div class="col-md-4 text-right"> <a href="<?= base_url() . 'location/add/' ?>" class="btn btn-primary"><i class="la la-plus"></i> Add City</a> </div>
        </div>
      </form>
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
      <table class="table table-hover table-bordered adminmenu_list">
        <thead>
          <tr>
            <th>Id</th>
            <th>City Name</th>
            <th>Country</th>
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
                    $atr6 = array(
                        'onclick' => "javascript: return confirm('Cancel default?');",
                        'class' => 'la la-plus _165x green',
                        'title' => 'Cancel default'
                    );
                    $atr7 = array(
                        'onclick' => "javascript: return confirm('Set as default?');",
                        'class' => 'la la-plus _165x red',
                        'title' => 'Set as default country'
                    );

                    if (count($list) != 0) {
                        foreach ($list as $key => $country) {
                            $country_name=$this->auto_model->getFeild('Name','country','Code',$country['countrycode']);
                            ?>
          <tr>
            <td><?php echo $country['id']; ?></td>
            <td><?php echo $country['name']; ?></td>
            <td><?php echo $country_name; ?></td>
            <td align="right"><?php
                                    
                                    $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit Country');

                                    echo anchor(base_url() . 'location/edit/' . $country['id'], '&nbsp;', $atr2);
                                    echo anchor(base_url() . 'location/delete/' . $country['id'], '&nbsp;', $attr);
                                    ?></td>
          </tr>
          <?php } ?>
          <? } else { ?>
          <tr>
            <td colspan="6" class="red"> No Records Found </td>
          </tr>
          <? } ?>
        </tbody>
      </table>
      <?php echo $links; ?>

    <!-- End .col-lg-6  --> 
  </div>
  <!-- End .row-fluid  -->
  
  </div>
  <!-- End .container-fluid  -->
  </div>
  <!-- End .wrapper  --> 
</section>
