<h5><i>Account Summary</i></h5>
<p><b>Account Balance :</b> <?php echo CURRENCY. $wallet_balance;?></p>
<p><b>Pending Payment (approx) :</b> <?php echo CURRENCY. $pending_payments;?></p>
<p><b>Active project :</b> <?php echo $active_projects;?> </p>

<?php if($wallet_balance > 0 || $pending_payments > 0 || $active_projects > 0){ ?>
<div class="alert alert-danger">
  <strong>Note !</strong> This account cannot be deleted . 
</div>
<?php }else{ ?>
<button class="btn btn-success" onclick="deleteAccount('<?php echo $user_id; ?>')" id="close_acc_btn">Delete this account</button>
<?php } ?>
