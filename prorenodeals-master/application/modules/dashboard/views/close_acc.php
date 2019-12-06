<?php echo $breadcrumb;?>



<script src="<?=JS?>mycustom.js"></script>

<section id="mainpage">

<div class="container-fluid">

  <div class="row">

  <?php $this->load->view('dashboard/dashboard-left'); ?>

<aside class="col-lg-10 col-md-9 col-12">  

<div class="spacer-20"></div>

<!--ProfileRight Start-->

<div class="profile_right">

<?php



if($this->session->flashdata('succ_msg'))



{



?>



<div class="success alert-success alert"><?php echo $this->session->flashdata('succ_msg');?></div>



<?php



}



if($this->session->flashdata('error_msg'))



{



?>



<span id="agree_termsError" class="error-msg2"><?php echo $this->session->flashdata('error_msg');?></span>



<?php



}



?>



<!--EditProfile Start-->



<form name="testimonial" class="form-horizontal" id="testimonial" action="<?php echo VPATH;?>dashboard/closeacc/" method="post"> 

<div class="editprofile well">



<input type="hidden" name="uid" value="<?php echo $user_id;?>"/>

<p>We are sorry to see you go. Please spare a few minutes to tell us why you are leaving (optional) : </p>

<div class="form-group">
<textarea class="form-control" size="30" name="description" id="description" tooltipText="Write Your Reason for Leaving" ></textarea>

<div class="error-msg2"> <?php echo form_error('description'); ?></div>
</div>

<div class="acount_form">

<div class="masg3"></div>

<input class="btn btn-site" type="submit" id="submit-check" value="Confirm" />

</div>

</div>

</form>



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



  </div>



</div>

</section>

           

