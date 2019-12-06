<section class="sec-60">
  <div class="container">
    <div class="row"> <?php echo $leftpanel;?>
      <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="profile_right">
          <div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> Balance: </span><?php echo CURRENCY;?> <?php echo $balance;?></div>
          
          <!--EditProfile Start-->
          
          <?php 

   if ($this->session->flashdata('mile_succ'))

   {

?>
          <div class="success alert-success alert">
            <?php  echo $this->session->flashdata('mile_succ');?>
          </div>
          <?php

    }

    ?>
          <?php 

   if ($this->session->flashdata('succ_msg'))

   {

?>
          <div class="success alert-success alert">
            <?php  echo $this->session->flashdata('succ_msg');?>
          </div>
          <?php

        }

    ?>
          <?php 

   if ($this->session->flashdata('error_msg'))

        {

     ?>
          <div class="error alert-error alert">
            <?php  echo $this->session->flashdata('error_msg');?>
          </div>
          <?php

        }

 ?>
 		  <div class="notiftext">
                <div class="proposalcss">Set up the milestone for <?php echo ucwords($project_name);?>.</div>
                <div class="proposalcss" style="float: right;">Total Bid Amount: <?php echo CURRENCY.$bidder_amt;?></div>
              </div>
          <div class="whiteSec">
            <form method="post" action="<?php echo VPATH;?>dashboard/MilestoneEdit/<?php echo $project_id;?>" onSubmit='return checksum()'>
              
              <div style="clear:both; height:20px;"></div>
              <div id="mile_fields">
                <?php

					$array[1] = "First";

					$array[2] = "Second"; 

					$array[3] = "Third"; 

					$array[4] = "Forth"; 

					$array[5] = "Fifth";

					$array[6] = "Sixth"; 

					$array[7] = "Seventh"; 

					$array[8] = "Eighth"; 

					$array[9] = "Ninth"; 

					$array[10] = "Tenth";

					

					$i=1;

					



							

					foreach($set_milestone_list as $key=>$val)

					{

					

					?>
                <div class='login_form'>
                  <p>
                    <?=$array[$i]?>
                    Milestone Amount <?php echo CURRENCY;?> :</p>
                  <input type='text' class='form-control milestonesum' onblur='checknumber();' id='amount_<?php echo $i;?>' size='15' value="<?php echo $val['amount'];?>" name='amount_<?php echo $val['id'];?>' title='Enter your Milestone Amount' tooltipText='Milestone Amount '/>
                  <?php echo form_error('amount_'.$val['id'], '<div class="error-msg3" style="float:left;margin-left:0px;">', '</div>');?></div>
                <div class='login_form'>
                  <p>Date :</p>
                  <input type='text' class='form-control mdt' id='date_<?php echo $i;?>' size='15' name='mpdate_<?php echo $val['id'];?>' title='Enter Milestone Date' value="<?php echo $val['mpdate'];?>"  readonly='readonly'/>
                  <?php echo form_error('mpdate_'.$val['id'], '<div class="error-msg3" style="float:left;margin-left:0px;">', '</div>');?> </div>
                <div class='login_form'>
                  <p>Title :</p>
                  <input type="text" name='title_<?php echo $val['id'];?>' id='title_<?php echo $i;?>' class='form-control' size='15' title='Please give a short title' tooltipText='Milestone Title' value="<?php echo $val['title'];?>"/>
                  <?php echo form_error('title_'.$val['id'], '<div class="error-msg3" style="float:left;margin-left:0px;">', '</div>');?> </div>
                <div class='login_form'>
                  <p>Description :</p>
                  <textarea name='description_<?php echo $val['id'];?>' id='description_<?php echo $i;?>' class='form-control' cols='30' rows='3' title='Please give a short Description for this Milestone transfer' tooltipText='Milestone Description'><?php echo $val['description'];?></textarea>
                  <?php echo form_error('description_'.$val['id'], '<div class="error-msg3" style="float:left;margin-left:0px;">', '</div>');?> </div>
                <?php

					$i++;

					}

					?>
                <div class='login_form'>
                  <p></p>
                  <input class='btn btn-site' type='submit' name='pay_btn' id='pay_btn' value='Create'/>
                </div>
              </div>
            </form>
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

jQuery(document).ready(function(){
	$( ".mdt" ).datepicker({

			minDate: new Date()

			/*showOn: "button",

			buttonImage: "<?php echo ASSETS;?>images/caln.png",

			buttonImageOnly: true*/

		});
});
function checknumber()

{

	var sum= 0;

	$('.milestonesum').each(function() {

	sum += Number($(this).val());

	});

	//alert(sum);

	var bidder_amt = <?=$bidder_amt?>;

	if(parseInt(sum)>parseInt(bidder_amt))

	{

		alert("Invalid amount. must not be grater than Bid amount");

		$('.milestonesum').val("");

		$('#amount_1').focus();



	}

	

}

 function checksum()

 {

	 var sum= 0;

	 var f=true;

	$('.milestonesum').each(function() {

		sum += Number($(this).val());

	});

	var bidder_amt = <?=$bidder_amt?>;

	

	if(parseInt(sum)!=parseInt(bidder_amt))

	{

		alert("Invalid amount. must be Equal to Bid amount");

		f=false;

	}

	else{

		f=true;	

	}

	return f;

		

 }

	   

  /* function getWorker(v){ 

	  var dataString = 'pid='+v;

		$.ajax({

		   type:"POST",

		   data:dataString,

		   url:"<?php echo VPATH;?>dashboard/workerDetails",

		   success:function(return_data){                       

			  $("#provide_user").html(return_data);

			  $("#provide_user").show();

		   }

	   }); 

   }*/

 

  /* function valcheck(v){ 

   

	  var balance=<?php echo $balance;?>;

	 

	  if(parseInt(v)>parseInt(balance)){ 

		alert("Insufficiant Balance..");

		 $("#payamount").val("");

		 $("#payamount").focus();

	  }

	  var rmn_amt=$('#remaining_amount').val();

	  if(parseInt(v)>parseInt(rmn_amt))

	  {

		 alert("Invalid amount. must not be grater than remaining amount");

		 $("#payamount").val("");

		 $("#payamount").focus();

	  }



   }

   

   function putval(v){ 

   if(v!='')

	  { 

	  var hrt=$('#hour_amount').val();

	  

		var payamt=parseFloat(v)*parseFloat(hrt);

		

	 

	 $("#payamount").val(payamt);

	 $("#payamount").focus();

	 }

	 else

	 {

		$("#total_hour").attr('placeholder','Please Put Total Hour of Payment'); 

		$("#total_hour").attr('style','border-color:red!important');

	 }



   }

   

   function paytoWorker(v){

	  

	  var opt=$("#action_select_"+v).val();

	  if(opt!="") { 

			var dataString = 'mid='+v;

			var url="";

			

			if(opt=="R"){ 

			  url="<?php echo VPATH;?>myfinance/releasepayment";

			}

			else if(opt=="D"){		 

			  url="<?php echo VPATH;?>myfinance/dispute";

			}

			

			

			$.ajax({

			   type:"POST",

			   data:dataString,

			   url:url,

			   success:function(return_data){

				   if(return_data){

					 if(opt=="R") 

					 {

						 alert('You have successfully release this milestone');

						window.location.href="<?php echo VPATH;?>myfinance/milestone";

					 }

					 else if(opt=="D"){

						window.location.href="<?php echo VPATH;?>disputes/details/"+return_data; 

					 }

					 

				   }     

			   }

		   });                             

	  }

	}*/

 

 </script> 
