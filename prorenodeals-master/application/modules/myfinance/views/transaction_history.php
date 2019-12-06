
<script src="<?=JS?>mycustom.js"></script>
<?php
$user = $this->session->userdata('user');
$account_type = $user[0]->account_type;
?>
<section id="mainpage">
  <div class="container-fluid">
    <div class="row">      
      <?php $this->load->view('dashboard/dashboard-left'); ?>
      <aside class="col-lg-10 col-md-9 col-12">
	<?php echo $breadcrumb;?>
        <ul class="nav nav-tabs">
          <li class="nav-item"><a class="nav-link" href="<?php echo VPATH;?>myfinance/" ><?php echo __('myfinance_add_fund','Add Fund'); ?></a></li>
          <li class="nav-item hidden"><a class="nav-link" href="<?php echo VPATH;?>myfinance/milestone" ><?php echo __('myfinance_milestone','Milestone'); ?></a></li>
          <?php if($account_type == 'F'){ ?>
		
        <li class="nav-item"><a class="nav-link" href="<?php echo VPATH;?>myfinance/withdraw" ><?php echo __('myfinance_withdraw_fund','Withdraw Fund'); ?></a></li> 
		<?php } ?>
          <li class="nav-item"><a class="nav-link active" href="<?php echo VPATH;?>myfinance/transaction" ><?php echo __('myfinance_transaction_history','Transaction History'); ?></a></li>
          <li class="nav-item hide"><a class="nav-link" href="<?php echo VPATH;?>membership/" ><?php echo __('myfinance_membership','Membership'); ?></a></li>
        </ul>
        <div class="balance"> <span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> <?php echo __('myfinance_balance','Balance'); ?>: </span><?php echo CURRENCY;?> <?php echo format_money($balance,TRUE);?> </div>
        
        <!--EditProfile Start-->
        
        <div class="editprofile">
          <div class="row">
            <aside class="col-md-9 col-12">
              <h4><?php echo __('myfinance_select_date_for_which_transaction_history_want','Select date for which you want your transaction history'); ?></h4>
            </aside>
            <aside class="col-md-3 col-12"> <a href="<?php echo VPATH;?>myfinance/generateCSV_new/" class="btn btn-sm btn-site pull-right" style="margin-bottom:10px"><?php echo __('myfinance_download_statement','Download Statement'); ?></a> </aside>
          </div>
          <div class="transbox">
            <form class="form-horizontal">
              <div class="row mt-3">
                <div class="col-sm-5 col-12">
                    <label><?php echo __('myfinance_from','From'); ?>:</label>
                    <div class='input-group'>
                      <input type='text' class="form-control datepicker" id="datepicker_from" name="from" size="15" value="<?php echo !empty($srch['from']) ? $srch['from'] : '';?>" />
                      <div class="input-group-append"><span class="input-group-text"> <i class="icon-feather-calendar"></i></span></div>
                    </div>
                </div>
                <div class="col-sm-5 col-12">
                    <label><?php echo __('myfinance_to','To'); ?>:</label>
                    <div class='input-group'>
                      <input type='text' class="form-control datepicker" id="datepicker_to" name="to" size="15"  value="<?php echo !empty($srch['to']) ? $srch['to'] : '';?>" />
                      <div class="input-group-append"><span class="input-group-text"> <i class="icon-feather-calendar"></i></span></div>
                      </div>
                </div>
                <div class="col-sm-2 col-12">
                  <div class="form-field">
                      <label class="d-none d-sm-block">&nbsp;</label>
                      <input type="submit" name="submit" class="btn btn-site btn-block" value="<?php echo __('myfinance_go','Go'); ?>">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_statement_period','Statement Period'); ?>:</h5>
            <p><span><?php echo __('myfinance_all_transaction','All transactions'); ?></span></p>
          </div>
          <div class="transbox hide">
            <h5><?php echo __('myfinance_beginning_balance','Beginning Balance');; ?>:</h5>
            <p><span><?php echo CURRENCY;?> 0.00 </span></p>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_total_debits','Total Debits'); ?>:</h5>
            <p> <span class="hidden"><?php echo CURRENCY;?>
              <?php if($tot_debit[0]->amount!='') {echo $tot_debit[0]->amount;} else {echo '0.00';}?>
              </span> <span> <?php echo !empty($debit_total) ? CURRENCY.' '.format_money($debit_total,TRUE) : CURRENCY. ' 0.00'; ?> </span> </p>
          </div>
          <div class="transbox hide">
            <h5><?php echo __('myfinance_total_cradits','Total Credits'); ?>:</h5>
            <p> <span class="hidden"><?php echo CURRENCY;?>
              <?php if($tot_credit[0]->amount!='') {echo $tot_credit[0]->amount;} else {echo '0.00';}?>
              </span> <span> <?php echo !empty($credit_total) ? CURRENCY.' '.format_money($credit_total,TRUE) : CURRENCY. ' 0.00'; ?> </span> </p>
          </div>
          <div class="transbox">
            <h5><?php echo __('myfinance_ending_balance','Ending Balance'); ?>:</h5>
            <p><span><?php echo CURRENCY;?> <?php echo format_money($balance,TRUE);?></span></p>
          </div>
        </div>
        
        <!--EditProfile End-->
        
        <div class="spacer-20"></div>
        <div class="clearfix"></div>
        
        <!-- new transaction history (Bishu) -->
        
        <h4><?php echo __('myfinance_transaction_details','Transaction Details'); ?></h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th style="width:115px"><?php echo strtoupper(__('myfinance_date','DATE')); ?></strong></th>
                <th style="min-width: 65px"><?php echo strtoupper(__('myfinance_txn_id','TXN ID')); ?></strong></th>
                <th><?php echo __('myfinance_info','Info'); ?></strong></th>
                <th><?php echo __('myfinance_cradit_cr','Credit (Cr)'); ?></strong></th>
                <th><?php echo __('myfinance_debit_dr','Debit (Dr)'); ?></strong></th>
                <th><?php echo __('myfinance_status','Status'); ?></strong></th>
                <th><?php echo __('myfinance_invoice','Invoice'); ?></strong></th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($all_data) > 0){foreach($all_data as $k => $v){ 

						$u_type = $this->session->userdata('user')[0]->account_type;

						if($u_type == 'F'){

							$u_type_str = 'freelancer';

						}else{

							$u_type_str = 'employer';

						}

						

						?>
              <tr>
                <td><?php echo !empty($v['datetime']) ? date('d M, Y h:i A', strtotime($v['datetime'])) : '' ;?></td>
                <td><?php echo !empty($v['txn_id']) ? $v['txn_id'] : '' ;?></td>
                <td><?php

							$project_pattern = '/#(\d{10,})/';

							$link = '<a href="'.base_url('projectroom/'.$u_type_str.'/overview/$1').'">#$1</a>';

							

							if($v['txn_type'] == PROJECT_FEATURED){

								$link = '<a href="'.base_url('jobdetails/details/$1').'">#$1</a>';

							}

							

							$info = preg_replace($project_pattern, $link, $v['info']);

							echo $info;

							?></td>
                <td><?php echo !empty($v['credit']) ? CURRENCY.' '.$v['credit'] : CURRENCY. ' 0.00' ;?></td>
                <td><?php echo !empty($v['debit']) ? CURRENCY. ' '.$v['debit'] : CURRENCY. ' 0.00' ;?></td>
                <td><?php

								$status = '';

								switch($v['status']){

									case 'Y' : 

										$status = '<font color="green">'.__('myfinance_success','Success').'</font>';

									break;

									case 'P' : 

										$status = '<font color="blue">'.__('myfinance_pending','Pending').'</font>';

									break;

									case 'N' : 

										$status = '<font color="red">'.__('myfinance_rejected','Rejected').'</font>';

									break;

								}

								echo $status;

								?></td>
                <td><?php if($v['invoice_id'] > 0){ ?>
                  <a href="<?php echo base_url('invoice/detail/'.$v['invoice_id']); ?>" target="_blank">Invoice</a>
                  <?php	} ?></td>
              </tr>
              <?php } }else{  ?>
              <tr>
                <td colspan="10" align="center"><?php echo __('myfinance_no_transaction_found','No transacion found'); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <?php  echo $links2; ?>
        <?php 



if(isset($ad_page)){ 

$type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));

if($type=='A') 

{

$code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 

}

else

{

$image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));

$url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 

}

}



?>
      </aside>
            
    </div>
  </div>
</section>
<script src="<?=JS?>jquery.min.js"></script> 
<script type="text/javascript">

	$(function () {

		$('.datepicker').datetimepicker({

			format: 'YYYY-MM-DD',

			debug:true

		});

	});

</script> 