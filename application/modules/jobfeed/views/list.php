<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/chosen/chosen.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/chosen/chosen.jquery.min.js" type="text/javascript"></script>
<?php

$this->load->model('jobdetails/jobdetails_model');
$user=$this->session->userdata('user');

$lang=$this->session->userdata('lang');

?>

<section id="mainpage">
<div class="container-fluid">

  <div class="row">
    <?php $this->load->view('dashboard/dashboard-left'); ?>
    <aside class="col-lg-10 col-md-9 col-12">
    <?php echo $breadcrumb;?>
      <div class="topcontrol_box" style="display:none">
        <div class="topcbott"></div>
        
      </div>
     
      
	  <div class="alert alert-info text-left">
	   <h3>JOB FEED</h3>
	   <p>Here are some project suggestions matching your skills.</p>
	</div>

      <?php if (!empty($srch_param['category']) || !empty($srch_param['sub_catgory'])){ ?>
      <div class="skill_search">
        <?php if(!empty($srch_param) && !empty($srch_param['category']) && !empty($srch_param['category_id'])){ 

	$catagory_name = getField('cat_name','categories','cat_id',$srch_param['category_id']);

	$arabic_catagory_name = getField('arabic_cat_name','categories','cat_id',$srch_param['category_id']);

	$spanish_catagory_name = getField('spanish_cat_name','categories','cat_id',$srch_param['category_id']);

	$swedish_catagory_name = getField('swedish_cat_name','categories','cat_id',$srch_param['category_id']);



			switch($lang){

				case 'arabic':

					$categoryName = !empty($arabic_catagory_name)? $arabic_catagory_name : $catagory_name;

					break;

				case 'spanish':

					

					$categoryName = !empty($spanish_catagory_name)? $spanish_catagory_name : $catagory_name;

					break;

				case 'swedish':

				

					

					$categoryName = !empty($swedish_catagory_name)? $swedish_catagory_name : $catagory_name;

					break;

				default :

					$categoryName = $catagory_name;

					break;

			}



?>
        <span class="chip"> <?php echo !empty($categoryName) ? $categoryName : ''; ?> <a href="<?php echo base_url('findjob/browse'); ?>"><i class="zmdi zmdi-close"></i></a> </span>
        <?php } ?>
        <?php if(!empty($srch_param) && !empty($srch_param['sub_catgory']) && !empty($srch_param['sub_catgory_id'])){ 

	$sub_catagory_name = getField('cat_name','categories','cat_id',$srch_param['sub_catgory_id']);

	$sub_arabic_catagory_name = getField('arabic_cat_name','categories','cat_id',$srch_param['sub_catgory_id']);

	$sub_spanish_catagory_name = getField('spanish_cat_name','categories','cat_id',$srch_param['sub_catgory_id']);

	$sub_swedish_catagory_name = getField('swedish_cat_name','categories','cat_id',$srch_param['sub_catgory_id']);



			switch($lang){

				case 'arabic':

					$sub_categoryName = !empty($sub_arabic_catagory_name)? $sub_arabic_catagory_name : $sub_catagory_name;

					break;

				case 'spanish':

					

					$sub_categoryName = !empty($sub_spanish_catagory_name)? $sub_spanish_catagory_name : $sub_catagory_name;

					break;

				case 'swedish':

					

					$sub_categoryName = !empty($sub_swedish_catagory_name)? $sub_swedish_catagory_name : $sub_catagory_name;

					break;

				default :

					$sub_categoryName = $sub_catagory_name;

					break;

			}



?>
        
        <span class="chip"> <?php echo 'Sub Category'; ?> <?php echo !empty($sub_categoryName) ? $sub_categoryName : ''; ?> <a href="<?php echo base_url('findjob/browse').'/'.$srch_param['category'].'/'.$srch_param['category_id']; ?>"><i class="zmdi zmdi-close"></i></a> </span>
        <?php } ?>
      </div>
      <?php } ?>
      <div class="listings-container listing" id="prjct"> 
        
        <?php

if(count($projects)>0)

{
	$login_user_id = null;
	$login_u = $this->session->userdata('user');
	$login_user_id= $login_u[0]->user_id;

foreach($projects as $key=>$val)

{
	
$action = 'add';
$fav_cls = '';
if(is_fav($val['project_id'], 'JOB', $login_user_id)){
	$action = 'remove';
	$fav_cls = 'bookmarked';
}

$buget="";

$buget = get_project_budget($val['project_id'], true);
?>
        <div class="job-listing listBox">
        <div class="job-listing-details">
          <?php
/*if($val['featured']=='Y')

{

?>
          <div class="featuredimg">
            <?php 

	$curr_lang=$this->session->userdata('lang');

	if($curr_lang == 'arabic'){

		$featured_icon = 'featured_ar.png';

	}else{

		$featured_icon = 'featured.png';

	}

	?>
            <img src="<?php echo VPATH;?>assets/images/<?php echo $featured_icon;?>" alt="" title="<?php echo __('findjob_featured','Featured'); ?>"> </div>
          <?php }*/ ?>
		  
         <!-- Bookmark Icon -->
          <span class="bookmark-icon mark-fav-button <?php echo $fav_cls;?>" data-object-id="<?php echo $val['project_id'];?>" data-object-type="JOB" data-action="<?php echo $action;?>"></span>
          
          <h3 class="job-listing-title"><a href="<?php echo VPATH;?>job-<?php echo $this->auto_model->getcleanurl(htmlentities($val['title']));?>-<?php echo $val['project_id'];?>"><?php echo ucwords(htmlentities($val['title']));?> </a></h3>
          <?php

if($val['visibility_mode']=='Private')

{

?>
          <input type="button" value="Private: bidding by invitation only" class="logbtn2" name="tt" style="float:right;margin-right: 50%;margin-top: -4%;">
          <?php

}

?>
          <div class="addthis_sharing_toolbox hidden" data-url="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>" style="float: right;margin-top: -30px;margin-right: 12px;"></div>
          <div class="addthis_sharing_toolbox hidden" data-url="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>" style="float: right;margin-top: -30px;margin-right: 12px;"></div>
          
          <?php

$totalbid=$this->jobdetails_model->gettotalbid($val['project_id']);

?>
          
          <?php


$pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";

$replacement = "[*****]";

 $val['description'] = htmlentities( $val['description']);

$val['description']=preg_replace($pattern, $replacement, $val['description']);

$pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";

$replacement = "[*****]";

$val['description']=preg_replace($pattern, $replacement, $val['description']);



$healthy = explode(",",BAD_WORDS);

$yummy   = array("[*****]");

$val['description'] = str_replace($healthy, $yummy, $val['description']);





$pattern = "/(?:1-?)?(?:\(\d{3}\)|\d{3})[-\s.]?\d{3}[-\s.]?\d{4}/x";

$replacement = "[*****]";

$val['description'] = preg_replace($pattern, $replacement, $val['description']);


?>
          <p><?php echo substr($val['description'],0,250);?> ... <a href="<?php echo VPATH;?>job-<?php echo $this->auto_model->getcleanurl(htmlentities($val['title']));?>-<?php echo $val['project_id'];?>"><?php echo __('findjob_more','more'); ?></a></p>
          
     
          
          <?php

	$q = array(

		'select' => 's.skill_name,s.arabic_skill_name,s.spanish_skill_name,s.swedish_skill_name , s.id',

		'from' => 'project_skill ps',

		'join' => array(array('skills s' , 'ps.skill_id = s.id' , 'INNER')),

		'offset' => 200,

		'where' => array('ps.project_id' => $val['project_id'])

	);

	$skills = get_results($q);


	?>
          <ul class="skills mb-0">
            <?php

		foreach($skills as $k => $v)

		{

			$skill_name=$v['skill_name'];

			switch($lang){

				case 'arabic':

					$skill_name = !empty($v['arabic_skill_name'])? $v['arabic_skill_name'] : $v['skill_name'];

					break;

				case 'spanish':

					$skill_name = !empty($v['spanish_skill_name'])? $v['spanish_skill_name'] : $v['skill_name'];

					break;

				case 'swedish':

				
					

					$skill_name = !empty($v['swedish_skill_name'])? $v['swedish_skill_name'] : $v['skill_name'];

					break;

				default :

					$skill_name = $v['skill_name'];

					break;

			}

		?>
            <li><a href="javascript:void(0);"><?php echo $skill_name;?></a> </li>
            <?php } ?>
          </ul>
          <?php

if($cat!='All')

{

	if(in_array($val['category'],$cate))

	{

		$lnki=$category;	

	} 

	else

	{

		$lnki=$category."-".$val['category'];	

	}  

}

else

{

	$lnki=$val['category'];	

}

if(is_numeric($val['sub_category'])){

	$sub_category_name = $this->auto_model->getFeild('cat_name' , 'categories' , 'cat_id' , $val['sub_category']);

	$arabic_sub_category_name = $this->auto_model->getFeild('arabic_cat_name' , 'categories' , 'cat_id' , $val['sub_category']);

	$spanish_sub_category_name = $this->auto_model->getFeild('spanish_cat_name' , 'categories' , 'cat_id' , $val['sub_category']);

	$swedish_sub_category_name = $this->auto_model->getFeild('swedish_cat_name' , 'categories' , 'cat_id' , $val['sub_category']);

	switch($lang){

				case 'arabic':

					$val['sub_category_name'] = !empty($arabic_sub_category_name)? $arabic_sub_category_name : $sub_category_name;

					break;

				case 'spanish':

					

					$val['sub_category_name'] = !empty($spanish_sub_category_name)? $spanish_sub_category_name : $sub_category_name;

					break;

				case 'swedish':

					$val['sub_category_name'] = !empty($swedish_sub_category_name)? $swedish_sub_category_name : $sub_category_name;

					break;

				default :

					$val['sub_category_name'] = $sub_category_name;

					break;

			}

}else{

	$val['sub_category_name'] = $val['sub_category'];

}



$par_cat = $this->auto_model->getFeild('cat_name' , 'categories' , 'cat_id' , $val['category']);

?>
          <p class="mar-top hidden"><?php echo __('findjob_category','Category'); ?><span>: <a href="<?php echo base_url('findjob/browse').'/'.$this->auto_model->getcleanurl($par_cat).'/'.$val['category'].'/'.$this->auto_model->getcleanurl($val['sub_category_name']).'/'.$val['sub_category'];?>"><?php echo $val['sub_category_name'];?></a> </span></p>
          <ul class="job-list f20">
              <li><?php echo $buget;?></li>
              <li><i class="fas fa-gavel"></i> <b>Bids:</b> <?php echo $totalbid;?></li>          
          </ul>
             
        </div>
        <div class="job-listing-footer">
        	<ul>
            	<li><span><?php echo __('findjob_posted','Posted'); ?>:</span> <b><?php echo __(strtolower(date('M',strtotime($val['post_date']))),date('M',strtotime($val['post_date']))).' '.date('d',strtotime($val['post_date'])).','.date('Y',strtotime($val['post_date']));?></b></li>
            	<li><span><?php echo __('findjob_posted_by','Posted by'); ?>:</span> <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $val['user_id'];?>"> <img src="<?php echo get_user_logo($val['user_id']);?>" class="img-circle mr-2" width="35"/><?php echo $val['fname'].' '.$val['lname']?></a> </li>
                <li><i class="icon-feather-map-pin"></i> <?php echo get_user_city($val['user_id']); ?></li>
                <li><a href="<?php echo VPATH;?>job-<?php echo $this->auto_model->getcleanurl(htmlentities($val['title']));?>-<?php echo $val['project_id'];?>" class="btn btn-site btn-sm pull-right"><?php echo __('findjob_select_this_job','Select this job'); ?></a></li>
            </ul>
        </div>
        </div>
        <?php } } else {

	echo "<div class='alert alert-danger'>".__('findjob_no_jobs_found','No jobs found')."</div>";	

} ?>
      </div>
      <nav aria-label="Page navigation" id="nav_bar"> 
        
        <?php  

if(isset($links)){                     
	echo $links;   
}

 ?>
      </nav>
    </aside>
  </div>
</div>
</section>
<div class="clearfix"></div>
<script type="text/javascript">
	

$('.inputtag').chosen()

.change(function(){

	$('#srchForm').submit();

});

function submitSearch(){
	$('#srchForm').submit();
}

</script> 
<script src="<?=JS?>bootstrap-select.min.js" type="text/javascript"></script>

<script>
$('.remove_fav').click(function(e){
	e.preventDefault();
	var object_id = $(this).data('objectId');
	var object_type = $(this).data('objectType');
	
	removeFav(object_id, object_type, function(res){
		if(res.status == 1){
			location.reload();
		}
	});
});

</script>
