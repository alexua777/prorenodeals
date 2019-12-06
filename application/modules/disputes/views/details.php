<?php echo $breadcrumb;?>      

<script src="<?=JS?>mycustom.js"></script>

<div class="container">
<div class="row">
<?php 

if ($this->session->flashdata('mile_succ'))

{

?>

<div class="success alert-success alert"><?php  echo $this->session->flashdata('mile_succ');?></div>

<?php

}

?>                

<?php

if($this->session->flashdata('amt_error'))

{

?>

<div class="success alert-success alert"><?php echo $this->session->flashdata('amt_error');?></div>

<?php

}

if($this->session->flashdata('msg_succ'))

{

?>

<div class="success alert-success alert"><?php echo $this->session->flashdata('msg_succ');?></div>

<?php

}

if($this->session->flashdata('msg_eror'))

{

?>

<div class="success alert-success alert"><?php echo $this->session->flashdata('msg_eror');?></div>

<?php

}

if($this->session->flashdata('msg_sent'))

{

?>

<div class="success alert-success alert"><?php echo $this->session->flashdata('msg_sent');?></div>

<?php

}

if($this->session->flashdata('msg_failed'))

{

?>

<div class="success alert-success alert"><?php echo $this->session->flashdata('msg_failed');?></div>

<?php

}

?>

<?php

if($this->session->flashdata('admin_request_sent'))

{

?>

<div class="success alert-success alert"><?php echo $this->session->flashdata('admin_request_sent');?></div>

<?php

}

if($this->session->flashdata('admin_request_failed'))

{

?>

<div class="success alert-success alert"><?php echo $this->session->flashdata('admin_request_failed');?></div>

<?php

}

?>              



<!--ProjectDetails Left Start-->                

<div class="col-lg-12 col-md-8 col-sm-6 col-xs-12" id="contact-form">

<!--<h3 class="title">Send Us an Email</h3>-->

<div class="dispute"><h3>Dispute ID : <?php echo $disput_details['id']?> </h3><div class="edit_bott" style="float:right;"><a href="javascript:void(0)" onclick="window.history.back(-1)">Back</a></div>

<?php

$projetc_name=$this->auto_model->getFeild("title","projects","project_id",$milestone_details['project_id']);

$employer_fname=$this->auto_model->getFeild("fname","user","user_id",$disput_details['employer_id']);

$employer_lname=$this->auto_model->getFeild("lname","user","user_id",$disput_details['employer_id']); 



$worker_fname=$this->auto_model->getFeild("fname","user","user_id",$disput_details['worker_id']);

$worker_lname=$this->auto_model->getFeild("lname","user","user_id",$disput_details['worker_id']); 
?>

<h2>Dispute on Project : <?php echo $projetc_name;?> by <?php echo $employer_fname." ".$employer_lname;?></h2>

<h2>Dispute By : <?php echo $employer_fname." ".$employer_lname;?></h2>

</div>

<div class="reply_box_left">

<?php

foreach($disput_conversation as $key=>$val)

{

$user_fname="Admin";

$user_lname="";

$user_pic="";

if($val['user_id']!='0')

{

$user_fname=$this->auto_model->getFeild("fname","user","user_id",$val['user_id']);

$user_lname=$this->auto_model->getFeild("lname","user","user_id",$val['user_id']); 

$user_pic=$this->auto_model->getFeild("logo","user","user_id",$val['user_id']); 

}

?>

<div class="reply_msg_box">

<div class="reply_img">

<?php

if($user_pic!='')

{

?>

<img src="<?php echo VPATH;?>assets/uploaded/<?php echo $user_pic;?>">

<?php	

}

else {

?>

<img src="<?php echo VPATH;?>assets/images/face_icon.gif">

<?php

}

?>

</div>

<div class="reply_massage">

<h2><?php echo $user_fname." ".$user_lname;?> <p><?php echo date('d M,Y',strtotime($val['add_date']));?></p></h2>

<p><?php echo $val['message'];?></p>

<p><a href="<?php echo VPATH;?>assets/dispute_file/<?php echo $val['attachment'];?>" target="_blank"><?php echo $val['attachment'];?></a></p>

</div>

</div><br>

<?php

}

?>

<form method="post" name="uploadmessage" action="<?php echo VPATH;?>disputes/message/<?php echo $disput_details['id']?>/<?php echo $projetc_name;?>" enctype="multipart/form-data">

<input type="hidden" name="recipient_id" value="<?php if($user_id==$disput_details["employer_id"]){ echo $disput_details["worker_id"];} else { echo $disput_details["employer_id"];}?>"/>

<input type="hidden" name="sender_id" value="<?php echo $user_id;?>"/>

<?php

$project_id=$this->auto_model->getFeild('project_id','milestone_payment','id',$disput_details["milestone_id"]);

?>

<input type="hidden" name="project_id" value="<?php echo $project_id;?>"/>

<div class="reply_from">

<p> Enter your reply to this dispute:</p><br>

<textarea class="msginput" rows="7" cols="" id="message" name="message"></textarea>

<div class="error-msg2"> <?php echo form_error('message'); ?></div>

</div>



<div class="reply_from">

<p>Attach documentation :</p><br>

<input type="file" name="userfile" size="30" class="msginput"><br/><h5><span style="color:red;width:100%;float:left;margin-top: 7px;">File must be zip ,jpg ,jpeg ,gif ,png ,doc ,docx ,pdf ,xls ,xlsx ,txt.</span></h5>

</div>



<div class="reply_from">

<div class="masg4">

<input type="submit" name="submit" class="btn-normal btn-color submit bottom-pad2" value="Submit" >

</div>

</div>

</form>

<?php

if($disput_details['admin_involve']=='N')

{

?>

<div class="reply_massage" style="float:left; width:94%;"><p style="padding-left:2%">Please <a href="<?php echo VPATH;?>disputes/admin_involve/<?php echo $disput_details['id']?>/<?php echo $projetc_name;?>">Click Here</a> to ask Elance Advance to resolve this dispute. By clicking on this link you confirm that you agree to accept Elance Advance's decision on this dispute as final</p></div>

<?php

}

?>

</div>

<div class="reply_box_right">

<div class="clear"></div>

<div class="proceed_bnt">Total amount disputed: <?php echo CURRENCY;?> <?php echo $disput_details['disput_amt']; ?> </div>

<div class="offer">

<table width="100%" cellspacing="0" cellpadding="0" border="0">

	<tbody><tr>

		<td style="border-right:#CDCDCD 1px dotted;"><p>Amount demanded by <?php echo $employer_fname." ".$employer_lname;?> <br><span><?php echo CURRENCY;?> <?php echo $disput_discuss[0]['employer_amt']; ?></span></p></td>

		<td><p>Amount demanded by <?php echo $worker_fname." ".$worker_lname;?><br><span><?php echo CURRENCY;?> <?php echo $disput_discuss[0]['worker_amt']; ?></span></p></td>

	</tr>

	<?php 

	  if($user_id==$disput_details["employer_id"] && $disput_discuss[0]['accept_opt']=="E"){ 

	?>

		<tr>

			<td style="border-right:#CDCDCD 1px dotted;"></td>

			<td><div class="edit_bott"><a onclick="if(confirm('Are you sure to accept this offer?')){window.location.href='<?php echo VPATH;?>disputes/acceptOffer/<?php echo $disput_details['id']?>/<?php echo $projetc_name;?>'}">Accept Offer</a></div></td>

		</tr>                            

	<?php

	  }

	   if($user_id==$disput_details["worker_id"] && $disput_discuss[0]['accept_opt']=="W"){ 

	?>

	<tr>

		<td><div class="edit_bott"><a onclick="if(confirm('Are you sure to accept this offer?')){window.location.href='<?php echo VPATH;?>disputes/acceptOffer/<?php echo $disput_details['id']?>/<?php echo $projetc_name;?>'}">Accept Offer</a></td>

		<td style="border-right:#CDCDCD 1px dotted;"></td>

	</tr>                                

	<?php    

	  }

	?>

  

	<tr>

		<td style="border-right:#CDCDCD 1px dotted;">&nbsp;</td>

		<td>&nbsp;</td>

	</tr>

</tbody></table>

</div>



<div style="clear:both;"></div>

<div class="new_offer">

<p>New amount you are willing to accept (if applicable)</p>

<div style="clear:both;"></div>

<form id="offer_frm" name="offer_frm" method="post" <?php if($user_id==$disput_details["employer_id"]){?> action="<?php echo VPATH;?>disputes/employer_offer"<?php } else {?> action="<?php echo VPATH;?>disputes/worker_offer"<?php }?> >

<input type="hidden" name="dispute_id" value="<?php echo $disput_details['id']?>"/>

<div style="padding-top:15px;" class="account"><?php echo CURRENCY;?> <input type="text" maxlength="5" size="5" style="color:#000000" class="account_box" name="offer_amt"></div>

<div class="account">

<input type="submit" class="btn-normal btn-color submit bottom-pad2" value="Submit" id="submit" name="submit"></div>

<div style="clear:both;"></div>

<p>Enter amount less than or equal to <?php echo CURRENCY;?> <?php echo $disput_details['disput_amt']; ?></p>

</form>

</div>

</div>

<div class="clear"></div>

</div>
</div>

<div class="divider"></div>

</div>

<div class="clearfix"></div>

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

<div class="addbox2">

<?php 

echo $code;

?>

</div>                      

<?php                      

}

elseif($type=='B'&& $image!="")

{

?>

<div class="addbox2">

<a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>

</div>

<?php  

}

}
?>
<div class="clearfix"></div>

</div>          