
<?php echo $breadcrumb;?>

<script src="<?=JS?>mycustom.js"></script>  
<!-- Title, Breadcrumb End-->
<div class="container">
<div class="row">
<?php echo $leftpanel;?> 
<!-- Sidebar End -->
<div class="col-md-9 col-sm-8 col-xs-12">

<!--ProfileRight Start-->
<div class="profile_right">
<h1><a   href="<?php echo VPATH;?>affiliate/withdraw" >Withdraw Fund</a></h1> 
<h1><a  class="selected" href="<?php echo VPATH;?>affiliate/transaction" >Transaction History</a></h1> 

<div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> Balance: </span><?php echo CURRENCY;?> <?php echo $balance;?></div>
<!--EditProfile Start-->
<div class="editprofile"> 	 	 	
<div class="notiftext"><div class="proposalcss">Select date for which you want your transaction history</div></div>

<div class="transbox">
<form name="srch_date" action="<?php echo VPATH;?>affiliate/transaction" method="post">
<div class="transform"><p>From :</p> <div class="transform_box"><input type="text" id="datepicker_from" name="from_txt" readonly="readonly" size="15" class="transform-input"  value="<?php echo $from;?>"/></div></div>

<div class="transform2"><p>To :</p>  <div class="transform_box2"><input type="text" id="datepicker_to" name="to_txt" readonly="readonly" size="15" class="transform-input"  value="<?php echo $to;?>"/></div> 
<input name="submit" type="submit" class="transbnt" value="Go"></div>
</form>
</div>


<div class="transbox"><h2>Statement Period:</h2> <h3><span>All transactions</span></h3></div>

<div class="transbox"><h2>Beginning Balance:</h2> <h3><span><?php echo CURRENCY;?> 0.00 </span></h3></div>

<div class="transbox"><h2>Total Debits:</h2> <h3><span><?php echo CURRENCY;?> <?php if($tot_debit[0]->amount!='') {echo $tot_debit[0]->amount;} else {echo '0.00';}?></span></h3></div>

<div class="transbox"><h2>Total Credits:</h2> <h3><span><?php echo CURRENCY;?> <?php if($tot_credit[0]->amount!='') {echo $tot_credit[0]->amount;} else {echo '0.00';}?></span></h3></div>

<div class="boxline"></div>

<div class="transbox">
	<h2>Ending Balance:</h2> <h3><span><?php echo CURRENCY;?> <?php echo $balance;?></span></h3></div>
</div>
<!--EditProfile End-->


<div class="editprofile"><div class="notiftext"><div class="proposalcss">Transaction Details</div></div>
<div class="milestontext"><h3><strong>DATE</strong></h3> <h3><strong>Transaction ID</strong></h3> <h3><strong>Description</strong></h3> <h3><strong>Credit/Debit</strong></h3> <h3><strong>Status</strong></h3> <h3><strong>Amount</strong></h3></div>
<?php
if(count($transaction_list)>0)
{
foreach($transaction_list as $key=>$val)
{
?>
<div class="milestonebox">
<h3><?php echo date('M d, Y',strtotime($val['transction_date']));?></h3> 	
<h3><?php echo $val['id'];?></h3> 	
<h3><?php echo $val['transaction_for']?> </h3> 	
<h3><?php echo $val['transction_type']?></h3> 	
<h3 class="color2"><?php if($val['status']=='Y'){echo "Completed";} else {echo "Pending";}?></h3>	
<h3 ><?php echo CURRENCY;?> <?php echo $val['amount']?></h3> 
</div>
<?php
}
echo $links;
}
else
{
	echo "No transacion found";		
}
?>
<!--<div class="milestonebox">
<h3>Aug 02, 2014</h3> 	
<h3>68161406960295</h3> 	
<h3>abcd <br> <a href="#">Test job by shouvik1</a></h3> 	
<h3>DR</h3> 	
<h3 class="color2">Completed</h3> 	
<h3 >$10.00</h3> 
<h3 >$490.84</h3>
</div>

<div class="milestonebox"><h3>Aug 02, 2014</h3> 	<h3>68161406960295</h3> 	<h3>abcd <br> <a href="#">Test job by shouvik1</a></h3> 	<h3>DR</h3> 	<h3 class="color2">Completed</h3> 	<h3 >$10.00</h3> <h3 >$490.84</h3></div>

<div class="milestonebox"><h3>Aug 02, 2014</h3> 	<h3>68161406960295</h3> 	<h3>abcd <br> <a href="#">Test job by shouvik1</a></h3> 	<h3>DR</h3> 	<h3 class="color2">Completed</h3> 	<h3 >$10.00</h3> <h3 >$490.84</h3></div>

<div class="milestonebox"><h3>Aug 02, 2014</h3> 	<h3>68161406960295</h3> 	<h3>abcd <br> <a href="#">Test job by shouvik1</a></h3> 	<h3>DR</h3> 	<h3 class="color2">Completed</h3> 	<h3 >$10.00</h3> <h3 >$490.84</h3></div>

<div class="milestonebox"><h3>Aug 02, 2014</h3> 	<h3>68161406960295</h3> 	<h3>abcd <br> <a href="#">Test job by shouvik1</a></h3> 	<h3>DR</h3> 	<h3 class="color2">Completed</h3> 	<h3 >$10.00</h3> <h3 >$490.84</h3></div>

<div class="milestonebox"><h3>Aug 02, 2014</h3> 	<h3>68161406960295</h3> 	<h3>abcd <br> <a href="#">Test job by shouvik1</a></h3> 	<h3>DR</h3> 	<h3 class="color2">Completed</h3> 	<h3 >$10.00</h3> <h3 >$490.84</h3></div>

<div class="milestonebox"><h3>Aug 02, 2014</h3> 	<h3>68161406960295</h3> 	<h3>abcd <br> <a href="#">Test job by shouvik1</a></h3> 	<h3>DR</h3> 	<h3 class="color2">Completed</h3> 	<h3 >$10.00</h3> <h3 >$490.84</h3></div>

<div class="milestonebox"><h3>Aug 02, 2014</h3> 	<h3>68161406960295</h3> 	<h3>abcd <br> <a href="#">Test job by shouvik1</a></h3> 	<h3>DR</h3> 	<h3 class="color2">Completed</h3> 	<h3 >$10.00</h3> <h3 >$490.84</h3></div>-->

</div>


</div>                       

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
        
      if($type=='A'&& $code!=""){ 
?>
<div class="addbox">
 <?php 
   echo $code;
 ?>
</div>                      
<?php                      
      }
   elseif($type=='B'&& $image!="")
   {
  ?>
        <div class="addbox">
        <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
        </div>
        <?php  
 }
  }

?>
                     </div>
                     <!-- Left Section End -->
                  </div>
               </div>
            </div>
            <!-- Main Content end-->
         </div>
