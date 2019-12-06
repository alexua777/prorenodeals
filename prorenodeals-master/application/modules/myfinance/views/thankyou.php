
<script src="<?=JS?>mycustom.js"></script>

<section id="mainpage">
  <div class="container-fluid">
    <div class="row">
      <?php $this->load->view('dashboard/dashboard-left'); ?>
      <div class="col-lg-10 col-md-9 col-12">
      <?php echo $breadcrumb;?>
        <ul class="nav nav-tabs">
          <li class="nav-item"><a class="nav-link active" href="<?php echo VPATH;?>myfinance/">Add Fund</a></li>
          <?php /*?><li><a href="<?php echo VPATH;?>myfinance/milestone">Milestone</a></li>

			<li><a href="<?php echo VPATH;?>membership/">Membership</a></li><?php */?>
          <li class="nav-item"><a class="nav-link" href="<?php echo VPATH;?>myfinance">Withdraw Fund</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo VPATH;?>myfinance/transaction">Transaction History</a></li>
        </ul>
        <div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> <?php echo __('myfinance_balance','Balance'); ?>: </span><?php echo CURRENCY;?> <?php echo $balance;?></div>        
        <br />
        <div class="alert alert-success"> <i class="zmdi zmdi-check-circle"></i> Your payment is successful. Fund was added to your wallet. </div>
      </div>
      
      <!-- Left Section End --> 
      
    </div>
  </div>
</section>
