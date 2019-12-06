<section class="breadcrumb-classic">  
  <div class="container">
    <div class="row">
    <aside class="col-sm-6 col-xs-12">
		<h3>Site Map</h3>
    </aside>
    <aside class="col-sm-6 col-xs-12">    
    <ol class="breadcrumb pull-right">
      <li><a href="<?php echo base_url();?>">Home</a></li>
      <li class="active">Site Map</li>
    </ol>        
    </aside>            
    </div>
	</div>       
</section>
<section class="sec">
<div class="container">
    <div class="whiteSec">
        <ul class="sitemap">
        <?php
        foreach($sitemap as $key=>$val)
        {
        ?>                   
        	<li><a href="<?php echo $val['url'];?>" target="_blank"><?php echo $val['page']?></a></li>                    
        <?php 
        }?> 
		</ul> 
        
    </div>
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
<div class="clearfix"></div>
            