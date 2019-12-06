<section id="content">

  <div class="wrapper">

    <nav aria-label="breadcrumb">

      <ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>

        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'location'; ?>">City List</a></li>

		<li class="breadcrumb-item active"><a>Add City</a></li>

      </ol>

    </nav> 

    

    <div class="container-fluid">

      <div class="panel panel-default">

        <div class="panel-heading">

          <h5><i class="la la-plus-square"></i> Add Country</h5>

          <?php

                            if ($this->session->flashdata('succ_msg')) {

                                echo '<div class=" succ_msg alert-success">';

                                echo $this->session->flashdata('succ_msg');

                                echo '</div>';

                            }

                            if ($this->session->flashdata('error_msg')) {

                                echo '<div class="alert-error error_msg">';

                                echo $this->session->flashdata('error_msg');

                                echo '</div>';

                            }

                            ?>

          <a href="#" class="minimize2"></a> </div>        

        <div class="panel-body">

          <form id="validate" action="<?php echo base_url(); ?>location/add/" class="form-horizontal" role="form" name="country" method="post" >

            <div class="form-group">

              <label class="col-form-label" for="c_name">Choose Country</label>             

                <select id="c_name" name="c_name" class="required form-control">

                  <option value="">Please Select</option>

                  <?php

                                        foreach($country_list as $key=>$val)

										{

										?>

                  <option value="<?php echo $val['code']?>"><?php echo $val['name'];?></option>

                  <?php	

										}

										?>

                </select>

                <?php echo form_error('c_name', '<label class="error" for="required">', '</label>'); ?>

            </div>

            <!-- End .control-group  -->

            <div class="form-group">

              <label class="col-form-label" for="city">City Name</label>              

                <input type="text" id="city" value="<?php echo set_value('city'); ?>"  name="city" class="required form-control">

                <?php echo form_error('city', '<label class="error" for="required">', '</label>'); ?> 

            </div>

            <button type="submit" class="btn btn-primary">Save</button>&nbsp;

            <button type="button" onclick="redirect_to('<?php echo base_url() . 'location'; ?>');" class="btn btn-secondary">Cancel</button>                        

          </form>

        </div>

        <!-- End .panel-body --> 

      </div>

      <!-- End .widget --> 

      

    </div>

    <!-- End .container-fluid  --> 

  </div>

  <!-- End .wrapper  --> 

</section>

