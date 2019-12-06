     

<script src="<?=JS?>mycustom.js"></script>

<section id="mainpage">  

<div class="container-fluid">

<div class="row">

<?php $this->load->view('dashboard/dashboard-left'); ?>

<aside class="col-lg-10 col-md-9 col-12">
<?php echo $breadcrumb;?> 
<div class="editprofile">

<h4><b><?php echo __('notification_notification','Notifications'); ?></b>  <span><?php echo __('notification_date','Date'); ?></span></h4>

<?php 

if(!empty($notification)){

foreach($notification as $key=>$val)

{

?>

<input type="hidden" name="notif_id[]" class="notifid <?php if($val['read_status']=='N'){?> <?php echo __('notification_unread','unread'); ?> <? }?>" value="<?php echo $val['id'];?>"/>

<div class="notifbox <?php if($val['read_status']=='N'){?>notif_active<?php }?>">

<p><a class="rmv_notof" href="javascript:void(0)" onclick="javascript: if(confirm('<?php echo __('notification_are_u_sure_want_to_delete','Are you sure want to delete?'); ?>')){window.location.href='<?php echo VPATH.'notification/delete/'.$val['id'];?>'}"><i class="zmdi zmdi-close"></i></a>

<a href="<?php echo base_url($val['link']);?>"><?php echo strip_tags(html_entity_decode($val['notification']));?></a></p>

<span><?php echo date('d M, Y',strtotime($val['add_date']));?></span>

</div>

<?php

}}else{

?>



<div class="notifbox notif_active">

<p><a class="rmv_notof" href="javascript:void(0)"><img src="<?php echo ASSETS;?>images/bid_icon.png" /></a>

<?php echo __('notification_no_notifivation_found','No Notifications found !!!'); ?></p>

<span>--</span>

</div>

<?php } ?>

</div>


<div class="spacer-20"></div>
<?php 

echo $links;

?>

 </aside>

</div>

</div>

</section>

<style>

.zmdi-close {

	color:#f00;

}

</style>