<?php echo $breadcrumb;?>
<script src="<?=JS?>mycustom.js"></script>
<section id="mainpage">  
<div class="container-fluid">
<div class="row">
<div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard/dashboard-left'); ?>
</div> 
<div class="posts-block col-md-10 col-sm-9 col-xs-12">
<div class="spacer-20"></div>
                 
	<ul class="tab">
        <li><a href="<?php echo VPATH;?>myfinance/"><?php echo __('myfinance_add_fund','Add Fund'); ?></a></li>
        <li class="hidden"><a href="<?php echo VPATH;?>myfinance"><?php echo __('myfinance_milestone','Milestone'); ?></a></li>
        <li><a href="<?php echo VPATH;?>myfinance"><?php echo __('myfinance_withdraw_fund','Withdraw Fund'); ?></a></li>
        <li><a href="<?php echo VPATH;?>myfinance/transaction"><?php echo __('myfinance_transaction_history','Transaction History'); ?></a></li>
        <li><a class="selected" href="<?php echo VPATH;?>membership/"> <?php echo __('myfinance_membership','Membership'); ?></a></li>
	</ul>           
          <!--EditProfile Start-->
          
      <div class="editprofile">
        <div class="methodbox">
          <div class="p_table pricing-table">
          <article class="price">
          	<div class="name"><h2>&nbsp;</h2><h4>&nbsp;</h4></div>
            <ul>
                <li><?php echo __('membership_days','Days'); ?></li>
                <li><?php echo __('membership_bids','Bids'); ?></li>
                <li><?php echo __('membership_skills','Skills'); ?></li>
                <li><?php echo __('membership_portfolio','Portfolio'); ?></li>
                <li><?php echo __('membership_project','Projects'); ?></li>
                <li><?php echo __('membership_unlimited_days','Unlimited Days'); ?></li>
                <li>&nbsp;</li>
            </ul>
          </article>
<?php 

 foreach($membership_plan as $k => $row){ 
    
	$price_cls = 'free';
	$style = 'background-color:#00e676;';
	$border = 'border-bottom: 5px solid #00e676;';
	if($k == 1){
		$price_cls = 'silver featured';
		$style = 'background-color:#29b6f6';
		$border = 'border-bottom: 5px solid #29b6f6;';
	}else if($k == 2){
		$price_cls = 'gold';
		$style = 'background-color:#ffb300';
		$border = 'border-bottom: 5px solid #ffb300;';
	}else if($k == 3){
		$price_cls = 'platinum';
		$style = 'background-color:#aa00ff';
		$border = 'border-bottom: 5px solid #aa00ff;';
	}
?>

    <article class="price <?php echo $price_cls;?>" style="<?php echo $border;?>">          
      <div class="name"  style="<?php echo $style;?>">
        <h2 class="col4" id="<?php echo strtoupper($row['name']);?>_h2"><?php echo strtoupper($row['name']);?></h2>
            <h4><?php echo CURRENCY;?> <?php echo $row['price'];?></h4>
        </div>       
        
      <ul>
        <li><?php echo $row['days'];?> <?php echo __('membership_days','Days'); ?></li>
        <li><span><?php echo $row['bids']?></span></li>
        <li><span><?php echo $row['skills']?></span></li>
        <li><span><?php echo $row['portfolio']?></span></li>
        <li><span><?php echo $row['project']?></span></li>
        <li> <span>
        <i class="zmdi zmdi-check"></i>
          <input id="<?php echo strtoupper($row['name']);?>_CHK" name="radio" type="radio" value="<?php echo $row['price'];?>" <?php if($user_membership==$row['id']){echo "checked='checked'";}?> >
          </span> </li>
        <li  class="footer_row">
          <?php if($user_membership==$row['id']){echo " <button class='btn btn-site btn-sm'> ".__('membership_subscribed','Subscribed')."</button>" ;}else {echo "<span style='min-height:12px;'>&nbsp;</span>";}?>
        </li>
      </ul>    
    </article>
    <?php 
    
      }
    
    ?>
          </div>
        </div>
        <div class="methodbox">
          <label style="margin:0px 4px 0px 7px;">
            <input name="auto_up" id="auto_up" type="checkbox" value="1" onmouseover="hds();" onmouseout="hdd();">
          </label>
          <?php echo __('membership_auto_renew_at_expiration','Auto-renew at expiration'); ?> <span id="tools" style="display:none;width: 300px;float: left;position: absolute;margin-left: -304px;margin-top: 27px;
background-color: black;font-size: 12px/16px;color: whitesmoke;padding: 0px 7px 0px 6px;opacity: 0.75;"><?php echo __('membership_subscription_charge_auto_renew_msg','Please check this box to auto-renew your subscription at expiration. Your account will be charged automatically. You will receive a message if your account is not sufficiently funded.'); ?></span>
          <button type="button" class="btn btn-site" onclick="return confirm('<?php echo __('membership_do_you_want_to_upgrade_your_plan','Do you want to upgrade your plan?'); ?>')?upgrade():''"><?php echo __('membership_upgrade_membership','Upgrade Membership'); ?></button>
        </div>
      </div>
          
  <!--EditProfile End--> 
  
             

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
      <div class="addbox"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
      <?php  

 }

  }

?>
    </div>
    
    <!-- Left Section End --> 
    
  </div>
</div>
</section>
<script>    

  function setbtn(v){ 

    if(v=="SILVER"){ 

      $("#SILVER").removeAttr("disabled");  

      $("#GOLD").attr("disabled", true);     

      $("#PLATINUM").attr("disabled", true);     

    }

    else if(v=="GOLD"){

         $("#GOLD").removeAttr("disabled");   

         $("#SILVER").attr("disabled", true);     

         $("#PLATINUM").attr("disabled", true);    

    }

    else if(v=="PLATINUM"){

         $("#PLATINUM").removeAttr("disabled"); 

         $("#GOLD").attr("disabled", true);     

         $("#SILVER").attr("disabled", true);     

    }    



  }         

  function upgrade(){ 

    var v="",a=0;

    if($('#SILVER_CHK').is(':checked')){        

        v="SILVER";

    }

    else if($('#GOLD_CHK').is(':checked')){       

        v="GOLD";    

    }

    else if($('#PLATINUM_CHK').is(':checked')){      

        v="PLATINUM";    

    }    

    

    if(v!=""){ 

       if($('#auto_up').is(':checked')){

           a=1;

       }

  var dataString = 'uptype='+v+'&autoup='+a;

    $.ajax({

       type:"POST",

       data:dataString,

       url:"<?php echo VPATH;?>membership/upgrade",

       success:function(return_data){

         if(return_data==2){ 

             alert("<?php echo __('membership_you_dont_have_enough_balance_add_fund','You don\'t have enough balance to upgrade membership. Please add fund'); ?>");

             window.location.href="<?php echo VPATH."myfinance/"?>"             

         }

         else if(return_data==1){ 

            window.location.href="<?php echo VPATH."membership/thankyou"?>"  

         }

       }

    });       

       

    }

  }

         

function hds()

{

	$('#tools').show();	

}

function hdd()

{

	$('#tools').hide();

}   

</script> 
