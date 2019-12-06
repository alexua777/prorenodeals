<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/chosen/chosen.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/chosen/chosen.jquery.min.js" type="text/javascript"></script>
<?php

if(isset($category))

{

	$cat=$category=str_replace('%20',' ',$category);

	$cate=explode("-",$category);

	$parentc=array();

	foreach($cate as $rw)

	{

		$pcat=$this->auto_model->getFeild('parent_id','categories','cat_name',$rw);

		$parentc[]=$pcat;	

	}

}

else{

	$parentc=array();

	$cat='All';

}

if(isset($project_type))

{

	$ptype=$project_type;

}

else

{

	$ptype='All';

}

if(isset($min_budget))

{

	$minb=$min_budget;

}

else

{

	$minb='0';

}

if(isset($max_budget))

{

	$maxb=$max_budget;

}

else{

	$maxb='0';

}

if(isset($posted))

{

	$post_with=$posted;

}

else{

	$post_with='All';

}

if(isset($country))

{

	$coun=$country;

}

else{

	$coun='All';

}

if(isset($city))

{

	$ct=$city;

}

else{

	$ct='All';

}

if(isset($featured))

{

	$featured=$featured;

}

else{

	$featured='All';

}

if(isset($environment))

{

	$environment=$environment;

}

else{

	$environment='All';

}

if(isset($uid))

{

	$uid=$uid;

}

else{

	$uid='0';

}

$user=$this->session->userdata('user');

$lang=$this->session->userdata('lang');

?>

<section class="sec">
<div class="container">
<?php echo $breadcrumb;?>
  <div class="row">
    <?php $this->load->view('left_sidebar'); ?>
    <aside class="col-lg-9 col-12">
      
      <div class="topcontrol_box" style="display:none">
        <div class="topcbott"></div>
        
        <!-- <input type="text" class="topcontrol" id="srch" onkeypress="catdtls1(this.id);" placeholder="Enter Job Name to Search"> --> 
        
      </div>
	  	
      <div class="searchbox">
        <form id="srchForm">
          <input type="hidden" name="append_skill" value="<?php echo $srch_param['append_skill'] == 1 ? $srch_param['append_skill'] : 0;?>"/>
          
            <?php 

		$selected_skills_array = array();

		$skill = $this->db->limit(150)->get('skills')->result_array();

		if($selected_skills){

			foreach($selected_skills as $k => $v){

				$selected_skills_array[] = $v['id'];

			}

		}

		?>
            <?php /*?><select class="form-control inputtag" name="skills[]" multiple>
              <?php if(count($skill) > 0){foreach($skill as $k => $v){ ?>
              <option value="<?php echo $v['id']; ?>" <?php echo in_array($v['id'], $selected_skills_array) ? 'selected="selected"' : '';?>><?php echo $v['skill_name']; ?></option>
              <?php } } ?>
            </select><?php */?>
        	<div class="sort-by mb-15">
                <span>Sort by:</span>
                <select class="selectpicker hide-tick" name="sort_by" onchange="submitSearch();">
                    <option value="relevance" <?php echo (!empty($srch_param['sort_by']) && $srch_param['sort_by'] == 'relevance') ? 'selected' : '';?>>Relevance</option>
                    <option value="new" <?php echo (!empty($srch_param['sort_by']) && $srch_param['sort_by'] == 'new') ? 'selected' : '';?>>Newest</option>
                    <option value="old" <?php echo (!empty($srch_param['sort_by']) && $srch_param['sort_by'] == 'old') ? 'selected' : '';?>>Oldest</option>
                </select>
            </div>
            <div class="clearfix"></div>
            <div class="input-group">
                <input type="text" class="form-control form-control-lg" name="term" placeholder="<?php echo __('findjob_search_job_by_title','Search job by title'); ?>..." autocomplete="off" value="<?php echo !empty($srch_param['term']) ? $srch_param['term'] : ''; ?>">
                <div class="input-group-append">            
                    <button type="submit" class="btn btn-site"><?php echo __('findjob_search','Search'); ?></button>            
                </div>
                </div>
                                          
        </form>
        
		<p class="text-right" style="display:none;"><a style="cursor: pointer;"><?php echo __('findjob_advance_search','Advanced Search'); ?></a></p>
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

					//$categoryName = $val['spanish_cat_name'];

					$categoryName = !empty($spanish_catagory_name)? $spanish_catagory_name : $catagory_name;

					break;

				case 'swedish':

					//$categoryName = $val['swedish_cat_name'];

					

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

 // $sub_catagory_name = getField('cat_name','categories','cat_id',$srch_param['sub_catgory_id']);

	$sub_catagory_name = getField('cat_name','categories','cat_id',$srch_param['sub_catgory_id']);

	$sub_arabic_catagory_name = getField('arabic_cat_name','categories','cat_id',$srch_param['sub_catgory_id']);

	$sub_spanish_catagory_name = getField('spanish_cat_name','categories','cat_id',$srch_param['sub_catgory_id']);

	$sub_swedish_catagory_name = getField('swedish_cat_name','categories','cat_id',$srch_param['sub_catgory_id']);



			switch($lang){

				case 'arabic':

					$sub_categoryName = !empty($sub_arabic_catagory_name)? $sub_arabic_catagory_name : $sub_catagory_name;

					break;

				case 'spanish':

					//$categoryName = $val['spanish_cat_name'];

					$sub_categoryName = !empty($sub_spanish_catagory_name)? $sub_spanish_catagory_name : $sub_catagory_name;

					break;

				case 'swedish':

					//$categoryName = $val['swedish_cat_name'];

					

					$sub_categoryName = !empty($sub_swedish_catagory_name)? $sub_swedish_catagory_name : $sub_catagory_name;

					break;

				default :

					$sub_categoryName = $sub_catagory_name;

					break;

			}



?>
        <?php // echo 'Sub Category: '; ?>
        <span class="chip"> <?php echo 'Sub Category'; ?> <?php echo !empty($sub_categoryName) ? $sub_categoryName : ''; ?> <a href="<?php echo base_url('findjob/browse').'/'.$srch_param['category'].'/'.$srch_param['category_id']; ?>"><i class="zmdi zmdi-close"></i></a> </span>
        <?php } ?>
      </div>
      <?php } ?>
      <div class="listings-container listing" id="prjct"> 
        
        <!--<p>(<?php// echo $total_projects;?>) Results found</p>-->
        
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
/*  if($val['buget_min']!=0 && $val['buget_max']!=0 && $val['buget_max'] !== $val['buget_min']){ 
     $buget=CURRENCY." ".$val['buget_min']. " To ".CURRENCY." ".$val['buget_max'];     
 }else if($val['buget_max'] == $val['buget_min']){
	 $buget=CURRENCY." ".$val['buget_min'];
 }
 else if($val['buget_min']!=0 && $val['buget_max']==0){ 
   $buget="Over ".CURRENCY." ".$project[0]['buget_min'];          
 }
 else if($val['buget_min']==0 && $val['buget_max']!=0){ 
   $buget="Less than ".CURRENCY." ".$project[0]['buget_max'];          
 } */ 
$buget = get_project_budget($val['project_id'], true);
?>
        <div class="job-listing">
        <div class="job-listing-details">
          <?php

/*if($val['featured']=='Y')

{

?>
          <div class="featuredimg" hidden>
            <?php 

	$curr_lang=$this->session->userdata('lang');

	if($curr_lang == 'arabic'){

		$featured_icon = 'featured_ar.png';

	}else{

		$featured_icon = 'featured.png';

	}

	?>
            <img src="<?php echo VPATH;?>assets/images/<?php echo $featured_icon;?>" alt="" title="<?php echo __('findjob_featured','Featured'); ?>"> </div>
          <?php } */ ?>
		  
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

//////////////////////For Email/////////////////////////////

$pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";

$replacement = "[*****]";

 $val['description'] = htmlentities( $val['description']);

$val['description']=preg_replace($pattern, $replacement, $val['description']);

/////////////////////Email End//////////////////////////////////



//////////////////////////For URL//////////////////////////////

$pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";

$replacement = "[*****]";

$val['description']=preg_replace($pattern, $replacement, $val['description']);

/////////////////////////URL End///////////////////////////////



/////////////////////////For Bad Words////////////////////////////

$healthy = explode(",",BAD_WORDS);

$yummy   = array("[*****]");

$val['description'] = str_replace($healthy, $yummy, $val['description']);



/////////////////////////Bad Words End////////////////////////////



/******************** For Mobile ***************************/



$pattern = "/(?:1-?)?(?:\(\d{3}\)|\d{3})[-\s.]?\d{3}[-\s.]?\d{4}/x";

$replacement = "[*****]";

$val['description'] = preg_replace($pattern, $replacement, $val['description']);



/********************  Mobile End ***************************/ 

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

					//$categoryName = $val['spanish_cat_name'];

					$skill_name = !empty($v['spanish_skill_name'])? $v['spanish_skill_name'] : $v['skill_name'];

					break;

				case 'swedish':

					//$categoryName = $val['swedish_cat_name'];

					

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
          <ul class="job-list f20">
          <li><?php echo $buget;?></li>
          <li><i class="fas fa-gavel"></i> <b>Bids:</b> <?php echo $totalbid;?></li>
          </li>
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

					//$categoryName = $val['spanish_cat_name'];

					$val['sub_category_name'] = !empty($spanish_sub_category_name)? $spanish_sub_category_name : $sub_category_name;

					break;

				case 'swedish':

					//$categoryName = $val['swedish_cat_name'];

					

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
          

			
            
            <?php

 /*if($val['project_type']=='F')

 {

 ?>
            <img src="<?php echo VPATH;?>assets/images/fixed.png">
            <?php

 }

 else

 {

 ?>
            <img src="<?php echo VPATH;?>assets/images/hourly.png">
            <?php

 }*/

 ?>
             
        </div>
        <?php
			$city_info = null;
			if(!empty($val['user_city'])){
				$code=strtolower($this->auto_model->getFeild('code2','country','Code',$val['country']));
				$city_info = getField('Name', 'city', 'id', $val['user_city']);
				$city_info .= ', ';
				$city_info .= getField('Name', 'country', 'Code', $val['country']);
				$city_info .= ' &nbsp;&nbsp';
				$city_info .= '<img src="'.VPATH.'assets/images/cuntryflag/'.$code.'.png" />';
			}else if(!empty($val['country'])){
				$code=strtolower($this->auto_model->getFeild('code2','country','Code',$val['country']));
				$city_info = getField('Name', 'country', 'Code', $val['country']);
				$city_info .= ' &nbsp;&nbsp';
				$city_info .= '<img src="'.VPATH.'assets/images/cuntryflag/'.$code.'.png" />';
			}
			
			
			?>
        <div class="job-listing-footer">
        	<ul>
            	<li><?php echo __('findjob_posted','Posted'); ?>: <b><?php echo __(strtolower(date('M',strtotime($val['post_date']))),date('M',strtotime($val['post_date']))).' '.date('d',strtotime($val['post_date'])).','.date('Y',strtotime($val['post_date']));?></b></li>
            	<li><a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $val['user_id'];?>"> <img src="<?php echo get_user_logo($val['user_id']);?>" class="img-circle mr-2" width="35"/><?php echo $val['fname'].' '.$val['lname']?></a></li>
                <li><?php echo $city_info;?></li>
                <li></li>
                <li><a href="<?php echo VPATH;?>job-<?php echo $this->auto_model->getcleanurl(htmlentities($val['title']));?>-<?php echo $val['project_id'];?>" class="btn btn-site btn-sm pull-right"><?php echo __('findjob_','Bid Now'); ?></a></li>
            </ul>
        </div>
        </div>
        <?php } } else {

	echo "<div class='alert alert-danger'>".__('findjob_no_jobs_found','No jobs found')."</div>";	

} ?>
      </div>
      <nav aria-label="Page navigation" id="nav_bar"> 
        
        <?php  

if(isset($links))

{                     

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

function catdtls1(id)

{

	var cat=$('#'+id).val();

	if(cat=='')

	{

		cat='_';	

	}

	//alert(cat);

	var category='<?php echo str_replace('&','_',$cat);?>';

	//alert(category);die():

	var ptype='<?php echo $ptype;?>';

	var minb='<?php echo $minb;?>';

	var maxb='<?php echo $maxb;?>';

	var post_with='<?php echo $post_with;?>';

	var coun='<?php echo $coun;?>';

	var ct='<?php echo $ct;?>';

	var featured='<?php echo $featured;?>';

	var environment='<?php echo $environment;?>';

	var uid='<?php echo $uid;?>';

	

	var dataString = 'cid='+cat+'&category='+category+'&ptype='+ptype+'&minb='+minb+'&maxb='+maxb+'&post_with='+post_with+'&coun='+coun+'&ct='+ct+'&featured='+featured+'&environment='+environment;

  $.ajax({

     type:"POST",

     data:dataString,

     url:"<?php echo base_url();?>findjob/getsrch/"+cat+"/"+category+"/"+ptype+"/"+minb+"/"+maxb+"/"+post_with+"/"+coun+"/"+ct+"/"+featured+"/"+environment,

     success:function(return_data)

     {

		 $("#pagi").hide();

	 	//alert(return_data);

      	$('#prjct').html('');

		$('#prjct').html(return_data);

		$('#nav_bar').hide();

     }

    });

}



/* $('.inputtag').tokenize2({

	placeholder: "<?php echo __('postjob_select_a_skill','Select a Skill'); ?>",

	dataSource: function(search, object){

		$.ajax({

			url : '<?php echo base_url('contest/get_skills')?>',

			data: {search: search},

			dataType: 'json',

			success: function(data){

				var $items = [];

				$.each(data, function(k, v){

					$items.push(v);

				});

				object.trigger('tokenize:dropdown:fill', [$items]);

			}

		});

	}

});



$('.inputtag').on('tokenize:tokens:add', function(o){

	$('#srchForm').submit();

});



$('.inputtag').on('tokenize:tokens:remove', function(o){

	$('#srchForm').find('[name="append_skill"]').val(0);

	$('#srchForm').submit();

}); */

	

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
