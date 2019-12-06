<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53a028a2284897c6"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
<?php

$user=$this->session->userdata('user');

?>              

<script src="<?=JS?>mycustom.js"></script>

<section class="sec-60">            
<div class="container">
<?php echo $breadcrumb;?> 
    <h3>Favourite Projects</h3>
    <table id="example" class="table table-striped table-bordered table-dashboard">
        <thead>
        <tr>
            <th>Project ID</th>
            <th>Project</th>
            <th>category</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        <tbody>
        <?php if(count($fav_projects) > 0){ foreach($fav_projects as $k => $v){  ?>
        <tr>
            <td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']).'';?>"><?php echo $v['project_id'];?></a></td>
            <td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']).'';?>"><?php echo $v['title'];?></a></td>
            <td><?php if(is_numeric($v['category'])){ echo getField('cat_name', 'categories', 'cat_id', $v['category']); }else{ echo $v['category']; };?></td>
            <td><?php echo $v['project_type'] == 'H' ? 'Hourly' : 'Fixed';?></td>
            <td><a href="<?php echo base_url('jobdetails/remove_fav/'.$v['project_id']).'?return=favourite';?>">Remove</a></td>
        </tr>
        <?php } } ?>
        </tbody>
    </thead>
    </table>
    

</div>
</section>
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

<!--<script src="<?php echo ASSETS;?>js/jquery.min.js"></script>
<script src="<?php echo ASSETS;?>js/app.js"></script>
<script src="<?php echo ASSETS;?>js/jquery.reveal.js"></script>-->


<link rel="stylesheet" type="text/css" href="<?php echo CSS;?>datatable/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo CSS;?>datatable/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo CSS;?>datatable/dataTables.bootstrap.css">
<script type="text/javascript" language="javascript" src="<?php echo CSS;?>datatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo CSS;?>datatable/dataTables.responsive.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo CSS;?>datatable/dataTables.bootstrap.js"></script>
		
		
<script>
	jQuery(document).ready(function($) {
		$('#example').DataTable();
	});
</script>
