      

<script src="<?=JS?>mycustom.js"></script>
<section class="sec-60">
<div class="container">
<?php echo $breadcrumb;?>
<div class="row">
<?php echo $leftpanel;?> 
<!-- Sidebar End -->
<div class="col-md-9 col-sm-8 col-xs-12">

<ul class="tab">
    <li><a  href="<?php echo VPATH;?>myfinance/" >Add Fund</a></li>
    <li><a  href="<?php echo VPATH;?>myfinance/milestone" >Milestone</a></li> 
    <li><a href="<?php echo VPATH;?>myfinance/withdraw" >Withdraw Fund</a></li> 
    <li><a class="selected" href="<?php echo VPATH;?>myfinance/transaction" >Transaction History</a></li> 
    <li><a href="<?php echo VPATH;?>membership/" >Membership</a></li> 
</ul>
<div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> Balance: </span>$<?php echo $balance;?></div>
<!--EditProfile Start-->
<div class="table-responsive"> 	 
<table class="table table-dashboard">	
<thead> 	
<tr>
    <th>Transaction For</th>	
    <th>Transaction Amount</th> 	
    <th>Transaction Date</th>
    <th>Transaction Status</th>
</tr>
</thead>
<tbody>
<tr>
<?php 
 if($transaction_count){ 
    foreach($transaction_list as $row){ 
?>
<td>
    <?php echo $row['transaction_for'];?>
</td>    
<td>$ <?php echo $row['amount'];?></td>
<td><?php echo date("d M,Y",  strtotime($row['transction_date']));?></td>    
<td>         

        <?php 
          if($row['status']=="Y"){ 
              echo "Success";
          }
          else{ 
              echo "Faild";
          }
        
        ?>
</td>
<?php    
    }  
    echo $this->pagination->create_links();   
 }
 else{ 
?>
<td colspan="4">No Record Found</td>
       
<?php    
 }

?>   

</tr>
</tbody>
</table> 
</div>
<!--EditProfile End-->

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
</section>    
         
<script> 
  function setamt(){ 
    $("#amount").val($("#depositamt_txt").val());
  }
</script>
         <?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
