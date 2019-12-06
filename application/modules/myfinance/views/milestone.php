
<script src="<?=JS?>mycustom.js"></script>

<section id="mainpage">
  <div class="container-fluid">
    <div class="row">
      <?php $this->load->view('dashboard/dashboard-left'); ?>
      <aside class="col-lg-10 col-md-9 col-12">
        <?php echo $breadcrumb;?>
        <ul class="tab">
          <li><a href="<?php echo VPATH;?>myfinance/"><?php echo __('myfinance_add_fund','Add Fund'); ?></a></li>
          <li class="hidden"><a class="selected" href="<?php echo VPATH;?>myfinance/milestone"><?php echo __('myfinance_milestone','Milestone'); ?></a></li>
          <li><a href="<?php echo VPATH;?>myfinance/withdraw"><?php echo __('myfinance_withdraw_fund','Withdraw Fund'); ?></a></li>
          <li><a href="<?php echo VPATH;?>myfinance/transaction"><?php echo __('myfinance_transaction_history','Transaction History'); ?></a></li>
          <li><a href="<?php echo VPATH;?>membership/"><?php echo __('myfinance_membership','Membership'); ?></a></li>
        </ul>
        <div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> <?php echo __('myfinance_balance','Balance'); ?>: </span><?php echo CURRENCY;?> <?php echo $balance;?></div>
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
        <?php



if($project_id>0)



{



$title=$this->auto_model->getFeild('title','projects','project_id',$project_id);



?>
        <div class="notiftextHead"><span>Milestone Chart for Project : <?php echo ucwords($title);?></span></div>
        <div class="table-responsive hidden">
          <table class="table">
            <thead>
              <tr>
                <th>Milestone No</th>
                <th>Amount(<?php echo CURRENCY;?>)</th>
                <th>Date</th>
                <th>Project</th>
                <th>Title</th>
                <th>Fund Release Request</th>
                <th>Release Payment Request</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php 



if(count($set_milestone_list)>0){  



foreach($set_milestone_list as $row){ 







?>
              </tr>
              <tr>
                <td><?php echo $row['milestone_no']; ?></td>
                <td><?php echo CURRENCY;?> <?php echo $row['amount'];?></td>
                <td class="width10per"><?php echo date("d M,Y", strtotime($row['mpdate'])) ;?></td>
                <td><?php



$project_name=$this->auto_model->getFeild("title","projects","project_id",$row['project_id']);



echo $project_name;



?></td>
                <td><?php echo $row['title'];?></td>
                <?php



if($row['client_approval']=='N')



{



?>
                <td>Not Approved Yet</td>
                <td>Not Approved Yet</td>
                <?php	



}



elseif($row['client_approval']=='D')



{



?>
                <td>Milestone Declined</td>
                <td>Milestone Declined</td>
                <?php	



}



else



{ 



if($row['fund_release']=="P"){



?>
                <td>Pending</td>
                <td>Not Set Yet</td>
                <?php



}



else if($row['fund_release']=="R")



{



?>
                <td class="color1"><a href="<?php echo VPATH;?>myfinance/releaseFund/<?php echo $row['id'];?>/A/" style="float:none;">Accept</a>&nbsp;|&nbsp;<a href="<?php echo VPATH;?>myfinance/releaseFund/<?php echo $row['id'];?>/P/" style="float:none;">Declined</a></td>
                <td>Not Set Yet</td>
                <?php



}



else if($row['fund_release']=="A"){



?>
                <td><img alt="Fund Approve" title="Fund Approve" src="<?=IMAGE?>/apply.png" /></td>
                <?php



}



if($row['fund_release']=="A" && $row['release_payment']=="R"){



?>
                <td class="color1 width20per" ><a href="<?php echo VPATH;?>myfinance/releasepayment/<?php echo $row['id'];?>">Release|</a><a href="<?php echo VPATH;?>myfinance/cancelpayment/<?php echo $row['id'];?>">Cancel</a><a href="<?php echo VPATH;?>myfinance/dispute/<?php echo $row['id'];?>">|Dispute</a></td>
                <?php



}



else if($row['fund_release']=="A" && $row['release_payment']=="N"){



?>
                <td>Not Requested Yet</td>
                <?php



} 



else if($row['fund_release']=="A" && $row['release_payment']=="Y"){



?>
                <td><img alt="Payment Approve" title="Payment Approve" src="<?=IMAGE?>/approved_img.jpg" /></td>
                <?php



}



else if($row['fund_release']=="A" && $row['release_payment']=="C"){



?>
                <td><img alt="Payment Canceled" title="Payment Canceled" src="<?=IMAGE?>/rejected_img.jpg" /></td>
                <?php



}



else if($row['fund_release']=="A" && $row['release_payment']=="D"){



?>
                <td><a href="<?php echo VPATH;?>disputes">Payment Disputed</a></td>
              </tr>
              <?php



}  



}



?>
              <?php

}



if($row['client_approval']=="N"){



?>
            <a href="<?=VPATH?>myfinance/ClientApproval/<?php echo $project_id;?>/Y/" class="btn-normal btn-color submit top-pad2">Accept This Milestone</a> <a href="<?=VPATH?>myfinance/ClientApproval/<?php echo $project_id;?>/D/" class="btn-normal btn-color submit top-pad2">Decline This Milestone</a>
            <?php 



}



}



else{ 



?>
            <tr>
              <td colspan="6" align="center">No Records Found</td>
            </tr>
            <?php    



} 



?>
              </tbody>
            
          </table>
        </div>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Milestone No</th>
                <th>Amount(<?php echo CURRENCY;?>)</th>
                <th>Date</th>
                <th>Project</th>
                <th>Title</th>
                <th> Payment Request</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php 



if(count($set_milestone_list)>0){  



foreach($set_milestone_list as $row){ 







?>
              </tr>
              <tr>
                <td><?php echo $row['milestone_no']; ?></td>
                <td><?php echo CURRENCY;?> <?php echo $row['amount'];?></td>
                <td class="width10per"><?php echo date("d M,Y", strtotime($row['mpdate'])) ;?></td>
                <td><?php



$project_name=$this->auto_model->getFeild("title","projects","project_id",$row['project_id']);



echo $project_name;



?></td>
                <td><?php echo $row['title'];?></td>
                <?php



if($row['client_approval']=='N')



{



?>
                <td>Not Approved Yet</td>
                <?php	



}



elseif($row['client_approval']=='D')



{



?>
                <td>Milestone Declined</td>
                <?php	



}else{ 

if($row['release_payment']=='R'){

?>
                <td><a href="<?php echo base_url('/dashboard/invoice/'.$row['invoice_id'].'/'.'F')?>" target="_blank">Invoice</a> | <a href="javascript:void(0);" onclick="milestone_action('<?php echo VPATH;?>myfinance/releaseFund/<?php echo $row['id'];?>/A/', 'release')">Release</a> | <a href="javascript:void(0);" onclick="milestone_action('<?php echo VPATH;?>myfinance/cancelpayment/<?php echo $row['id'];?>', 'cancel')">Cancel</a></td>
                <?php 

}else if($row['release_payment'] == 'N'){

	echo '<td>Not Requested Yet</td>';

} else if($row['release_payment'] == 'D'){

	echo '<td>Dispute</td>';

} else if($row['release_payment'] == 'C'){

	echo '<td>Cancelled</td>';

}else if($row['release_payment'] == 'Y'){

	echo '<td> <a href="'.base_url('/dashboard/invoice/'.$row['invoice_id'].'/'.'F').'">Invoice</a> | Paid </td>';

} 



}  

?>
                <?php

}





}



else{ 



?>
              <tr>
                <td colspan="6" align="center">No Records Found</td>
              </tr>
              <?php    



} 



?>
            </tbody>
          </table>
        </div>
        <?php



}



?>
        <div class="notiftextHead"><span><?php echo __('myfinance_outgoing_milestone_payments','Outgoing Milestone Payments'); ?></span></div>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th><?php echo __('myfinance_date','Date'); ?>/<?php echo __('myfinance_time','Time'); ?></th>
                <th><?php echo __('myfinance_amount','Amount'); ?>(<?php echo CURRENCY;?>)</th>
                <th><?php echo __('myfinance_receiver','Receiver'); ?></th>
                <th><?php echo __('myfinance_project','Project'); ?></th>
                <th><?php echo __('myfinance_reason','Reason'); ?></th>
                <th><?php echo __('myfinance_actions','Actions'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php 



if(count($outgoint_milestone_list)>0){  



foreach($outgoint_milestone_list as $row){ 



?>
              <tr>
                <td><?php echo date("d", strtotime($row['add_date'])) ;?> <?php echo __(strtolower(date("M,", strtotime($row['add_date']))),date("M,", strtotime($row['add_date'])));?> <?php echo date("Y H:i:s", strtotime($row['add_date'])) ;?></td>
                <td><?php echo CURRENCY;?> <?php echo $row['payamount'];?></td>
                <td><?php 



$wfname=$this->auto_model->getFeild("fname","user","user_id",$row['worker_id']);



$wlname=$this->auto_model->getFeild("lname","user","user_id",$row['worker_id']);



echo $wfname." ".$wlname;



?></td>
                <td><?php



$pname=$this->auto_model->getFeild("title","projects","project_id",$row['project_id']);



echo $pname;



?></td>
                <td><?php  echo $row['reason_txt'];?></td>
                <?php 



/*if($row['release_type']=="U"){       



?>



<td>



<select name="action_select" id="action_select_<?php echo $row['id'];?>" class="from_input_box2" style="width:100px">



<option value="select">Take Action. . .</option>



<option value="R">Release Payment</option>



<option value="D">Dispute This Milestone</option>



</select>



</td>



<?php 



}



else */if($row['release_type']=="P"){ 



echo "<td>".__('myfinance_paid','Paid')."</td>";



}



else { 



echo "<td>".__('myfinance_payment_canceled','Payment Canceled')."</td>";



}      



?>
                <?php 



/*if($row['release_type']=="U"){       



?>    



<td class="color1">



<input class="btn-normal btn-color submit bottom-pad2 top-pad2" type="button" value="Submit" name="submit_pay" onclick="if(confirm('Are you sure to take action?')){paytoWorker('<?php echo $row['id'];?>')}">



</td>



<?php 



}*/



?>
              </tr>
              <?php  



}



}



else{ 



?>
              <tr>
                <td colspan="6" align="center"><?php echo __('myfinance_no_records_found','No Records Found') ?></td>
              </tr>
              <?php    



} 



?>
            </tbody>
          </table>
        </div>
        <div class="notiftextHead"><span><?php echo __('myfinance_incoming_milestone_payment','Incoming Milestone Payments'); ?></span></div>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th><?php echo __('myfinance_date','Date'); ?>/<?php echo __('myfinance_time','Time'); ?></th>
                <th><?php echo __('myfinance_amount','Amount'); ?>(<?php echo CURRENCY;?>)</th>
                <th><?php echo __('myfinance_sender','Sender'); ?></th>
                <th><?php echo __('myfinance_project','Project'); ?></th>
                <th><?php echo __('myfinance_reason','Reason'); ?></th>
                <th><?php echo __('myfinance_status','Status'); ?></th>
              </tr>
              <?php 



if(count($incoming_milestone_list)>0){ 



foreach($incoming_milestone_list as $row){ 



?>
            </thead>
            <tbody>
              <tr>
                <td><?php echo date("d",  strtotime($row['add_date']));?><?php echo __(strtolower(date("M,",strtotime($row['add_date']))),date("M,",  strtotime($row['add_date']))).'ppp';?><?php echo date("Y H:i:s",  strtotime($row['add_date']));?></td>
                <td><?php echo CURRENCY;?> <?php echo $row['bider_to_pay'];?></td>
                <td><?php 



$efname=$this->auto_model->getFeild("fname","user","user_id",$row['employer_id']);



$elname=$this->auto_model->getFeild("lname","user","user_id",$row['employer_id']);



echo $efname." ".$elname;



?></td>
                <td><?php



	  $pname=$this->auto_model->getFeild("title","projects","project_id",$row['project_id']);



	  echo $pname;



	?></td>
                <td><?php echo $row['reason_txt'];?></td>
                <td><?php 



if($row['release_type']=="P"){ 



  echo __('myfinance_paid','Paid');



}



else if($row['release_type']=="D"){ 



 $dstatus=$this->auto_model->getFeild("status","dispute","milestone_id",$row['id']);



 if($dstatus=="Y"){ 



	 echo __('myfinance_resolved','Resolved');



 }



 else{



	 echo __('myfinance_disputed','Disputed')."<a style='float:right;' href='".VPATH."disputes/'>".__('myfinance_view','View')."</a>";



 } 



}  



else



{



echo __('myfinance_pending','Pending');	  



}      



?></td>
              </tr>
              <?php 



}



}



else{ 



?>
              <tr>
                <td colspan="6" align="center"><?php echo __('myfinance_no_records_found','No Records Found') ?></td>
              </tr>
              <?php    



}



?>
            </tbody>
          </table>
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
      </aside>
    </div>
  </div>
</section>
<div id="infoModal" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#infoModal').modal('hide');">&times;</button>
      </div>
      <div class="modal-body" id="infoContent"> </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#infoModal').modal('hide');">Close</button>
        <a type="button" class="btn btn-primary" id="release-action-btn" style="display:none">Accept</a> <a type="button" class="btn btn-primary" id="cancel-action-btn" style="display:none">Cancel</a> </div>
    </div>
  </div>
</div>
<script>

	

	function milestone_action(link, action){

		if(action == 'release'){

			$('#release-action-btn').attr('href', link);

			$('#release-action-btn').show();

			$('#cancel-action-btn').hide();

			$('#infoContent').html('Are you sure to release payment ?');

		}else if(action == 'cancel'){

			$('#cancel-action-btn').attr('href', link);

			$('#cancel-action-btn').show();

			$('#release-action-btn').hide();

			$('#infoContent').html('Are you sure to cancel payment ?');

		}

		$('#infoModal').modal('show');

	}



           function getWorker(v){ 



              var dataString = 'pid='+v;



                $.ajax({



                   type:"POST",



                   data:dataString,



                   url:"<?php echo VPATH;?>myfinance/workerDetails",



                   success:function(return_data){                       



                      $("#provide_user").html(return_data);



                      $("#provide_user").show();



                   }



               }); 



           }



         



           function valcheck(v){ 



		   



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



            }



         



         </script> 
