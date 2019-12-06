<?php echo $breadcrumb;?>
<script src="<?=JS?>mycustom.js"></script>

<section class="sec-60">
  <div class="container">
    <div class="row">
	<?php echo $leftpanel;?> 
      
      <!-- Sidebar End -->
      
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
          <div class="row" style="margin-bottom:15px">
            <div class="col-sm-6 col-xs-12">Set up the milestone for <?php echo ucwords($project_name);?>.</div>
            <div class="col-sm-6 col-xs-12 desk-text-right">Total Bid Amount: <?php echo CURRENCY.$bidder_amt;?></div>
          </div>
          <div class="clearfix"></div>
          <div class="whiteSec">
            <form method="post" class="form-horizontal" action="<?php echo VPATH;?>dashboard/setMilestone/<?php echo $project_id;?>" onSubmit='return checksum()'>
              
              <!--<div class="form-group">

<p>Select Number of Milestone :</p>

<select style="width:225px; margin-bottom:1%" class="form-control" onchange="getFields(this.value)" name="milestone_no" id="milestone_no" title="Please select a number to set milestone" tooltipText="Select Number of Milestone" />
<option value="select">Select Number of Milestone</option>

<?php 

for($i=1; $i<=10; $i++){ 

?>

<option value="<?php echo $i;?>"><?php echo $i;?></option>

<?php } ?>

</select>
</div>-->
              
              <input type="hidden" name="bidder_id" id="bidder_id" value="<?php echo $bidder_id; ?>" />
              <input type="hidden" name="bidder_amt" id="bidder_amt" value="<?php echo $bidder_amt;?>" />
              <input type="hidden" name="milestone_no" id="milestone_no" value="1"/>
              <div id="mile_fields">
                <div class="form-group">
                  <div class="col-xs-12">
                    <label>Milestone Amount <?php echo CURRENCY;?> :</label>
                    <input type='text' class='form-control milestonesum' onblur='checknumber();' id='' size='15' name='amount[]' title='Enter your Milestone Amount' tooltipText='Milestone Amount ' value='<?php echo set_value('amount[]');?>'/>
                    <?php echo form_error('amount[]', '<div class="error-msg3" style="float: left;">', '</div>');?> </div>
                </div>
                <div class='form-group'>
                  <div class="col-xs-12">
                    <label>Date :</label>
                    <input type='text' class='form-control mdt' id='' size='15' name='mpdate[]' title='Enter Milestone Date' readonly='readonly'/>
                    <?php echo form_error('mpdate[]', '<div class="error-msg3" style="float: left;">', '</div>');?> </div>
                </div>
                <div class='form-group'>
                  <div class="col-xs-12">
                    <label>Title :</label>
                    <input type="text" name='title[]' id='' class='form-control' size='15' title='Please give a short title' tooltipText='Milestone Title'/>
                    <?php echo form_error('title[]', '<div class="error-msg3" style="float: left;">', '</div>');?> </div>
                </div>
                <div class='form-group'>
                  <div class="col-xs-12">
                    <label>Description :</label>
                    <textarea name='description[]' id='' class='form-control' cols='30' rows='3' title='Please give a short Description for this Milestone transfer' tooltipText='Milestone Description'></textarea>
                    <?php echo form_error('description[]', '<div class="error-msg3" style="float: left;">', '</div>');?> </div>
                </div>
                <a href="javascript://" onclick="getFields()" class="pull-right btn btn-site btn-sm" style="margin-left: 8px"><i class='fa fa-plus-circle'></i> &nbsp;Add New</a> </div>
              <label></label>
              <input class='btn btn-site' type='submit' name='pay_btn' id='pay_btn' value='Create'/>
            </form>
          </div>
          <div class="space_20"></div>
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
    </div>
  </div>
</section>
<script>
$(document).ready(function(){
	$( ".mdt" ).datepicker({

			minDate: new Date()

			
		});
});
</script> 
<script>

		function getFields()

		{

			var a = '';

			var i=$("#milestone_no").val();

			

			i=parseInt(i)+1;

			

				a = a+"<div id='newdiv_"+i+"'><a href='javascript://' onclick=rmvths('"+i+"') class='pull-right btn btn-danger btn-sm'><i class='fa fa-trash'></i> &nbsp;Remove &nbsp;</a><div class='form-group'><div class='col-xs-12'><label> Milestone Amount <?php echo CURRENCY;?> :</label><input type='text' class='form-control milestonesum' onblur='checknumber();' id='' size='15' name='amount[]' title='Enter your Milestone Amount' tooltipText='Milestone Amount ' value='<?php echo set_value('amount[]');?>'/><?php echo form_error('amount[]', '<div class=error-msg3 style=float:left;>', '</div>');?></div></div><div class='form-group'><div class='col-xs-12'><label>Date :</label><input type='text' class='form-control mdt' id='' size='15' name='mpdate[]' title='Enter Milestone Date' readonly='readonly'/><?php echo form_error('mpdate[]', '<div class=error-msg3 style=float:left;>', '</div>');?></div></div><div class='form-group'><div class='col-xs-12'><label>Title :</label><input type='text' name='title[]' id='' class='form-control' size='15' title='Please give a short title' tooltipText='Milestone title'/><?php echo form_error('title[]', '<div class=error-msg3 style=float:left;>', '</div>');?></div></div><div class='form-group'><div class='col-xs-12'><label>Description :</label><textarea name='description[]' id='' class='form-control' cols='30' rows='3' title='Please give a short description for this transfer' tooltipText='Milestone Description'></textarea><?php echo form_error('description[]', '<div class=error-msg3 style=float:left;>', '</div>');?></div></div></div>";

			

			$('#mile_fields').append(a);

			$('#milestone_no').val(i);

			$( ".mdt" ).datepicker({

			minDate: new Date()

			/*showOn: "button",

			buttonImage: "<?php echo ASSETS;?>images/caln.png",

			buttonImageOnly: true*/

		});



		

		}

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

					$('.milestonesum:last').val("").focus();

					//$('#amount_1').focus();



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

		 

		 function rmvths(i)

		 {

			$("#newdiv_"+i).remove();	

			var j=$("#milestone_no").val();

			j=parseInt(j)-1;

			$('#milestone_no').val(j); 

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
