<?php /*?><link href="<?=CSS?>unveilEffects.css" rel="stylesheet" type="text/css">
<script src="<?=JS?>jquery.unveilEffects.js" type="text/javascript"></script><?php */?>

<?php

$page_skill=$this->auto_model->getFeild('skills','pagesetup','id','1');

$page_testimonial=$this->auto_model->getFeild('testimonial','pagesetup','id','1');

$page_cms=$this->auto_model->getFeild('cms','pagesetup','id','1');

$page_counting=$this->auto_model->getFeild('counting','pagesetup','id','1');

$cms_sec1=$this->auto_model->getalldata('','cms','id','1');

$cms_sec2=$this->auto_model->getalldata('','cms','id','2');

$cms_sec3=$this->auto_model->getalldata('','cms','id','3');



$lang = $this->session->userdata('lang');

$this->load->library('user_agent');

?>


<div class="banner">
  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
    <?php /*?><!-- Indicators -->
  <ol class="carousel-indicators">
  	<?php for($i=0; $i< count($banner); $i++){ ?>
     <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i;?>" class="<?php echo $i == 0 ? 'active' : '';?>"></li>
    <?php } ?>
  </ol><?php */?>
    
    <!-- Wrapper for slides -->
    <?php 
 $user = $this->session->userdata('user');
 if(!empty($user)){
 $user_id=$user[0]->user_id;
 }
 ?>
    <div class="carousel-inner" role="listbox">
      <?php if(count($banner) > 0){ foreach($banner as $key =>$val){ ?>
      <div class="carousel-item <?php if($key == 0){ echo 'active';} ?>">
      <img src="<?php echo ASSETS.'banner_image/'.$val['image'];?>" alt="...">
        <div class="carousel-caption">
          <div class="container">
          	<div class="spacer-50"></div>
            <h1><?php echo $val['title']; ?></h1>
            <p><?php echo $val['description']; ?></p>
            <form class="hidden-sm" action="<?php echo (!empty($_GET['lookin']) AND $_GET['lookin'] == 'findjob') ? VPATH.'findjob/browse' : VPATH.'findtalents';?>" id="header_search_form">
            <div class="form-group">
              <div class="input-group input-group-lg mb-4">
                  <span class="dropdown input-group-prepend">
                 
					<button class="btn btn-outline-success dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <span id="srch_txt"><?php echo (!empty($_GET['lookin']) AND $_GET['lookin'] == 'findjob') ? __('jobs','Jobs') : __('contractor','Contractor');?></span> <span class="caret"></span>
  </button>
  <div class="dropdown-menu" aria-labelledby="menu1" style="left:0;right:auto">
    <a class="dropdown-item srch_dropdown_item" href="#" data-srch="Freelancer"><?php echo __('contractor','Contractor'); ?></a>
    <a class="dropdown-item srch_dropdown_item" href="#" data-srch="Jobs"><?php echo __('jobs','Jobs'); ?></a>
  </div>
</span>

                  
                
                  <input type="hidden" name="lookin" value="<?php echo !empty($_GET['lookin']) ? $_GET['lookin'] : 'freelancer';?>" id="lookin"/>
                  <input type="text" class="form-control" placeholder="<?php echo __('search','Search'); ?>" name="q" value="<?php echo !empty($_GET['q']) ? $_GET['q'] : '';?>">
                </div>
            </div>
      		</form>
            <?php if(!empty($user_id)){ ?>
            
            
            <?php /*?>	<a href="<?=VPATH?>postjob" class="btn btn-lg btn-site btn-big">
        <?php echo __('home_post_job','Post Job'); ?><?php echo __('home_post_job','Post Job'); ?></a>
        <span class="hidden-xs">&nbsp;&nbsp;</span><?php */?>
            
            <?php }else{ ?>
            <a href="<?php echo base_url('signup')?>" class="btn btn-lg btn-site btn-big"><?php echo __('home_','Create Profile'); ?></a>
            <span class="hidden-xs">&nbsp;&nbsp;</span>
            <a href="<?=VPATH?>login?refer=postjob/" class="btn btn-lg btn-web btn-big"><?php echo __('home_','Post Projects'); ?></a>
            <?php } ?>
            <?php if(empty($user_id)){ ?>
            <?php /*?><a href="<?php echo base_url('signup');?>" class="btn btn-lg btn-border btn-big"><i class="zmdi zmdi-account" style="font-size: 22px;line-height: 1"></i> <?php echo __('home_register_now','Register now'); ?></a><?php */?>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } }else{ ?>
      <div class="carousel-item active"> <img src="<?php echo IMAGE;?>banner01.jpg" alt="..." class="hidden-mobile"> <img src="<?php echo IMAGE;?>mobile_banner01.jpg" alt="..." class="visible-mobile">
        <div class="carousel-caption text-left">
          <div class="container">
            <h1><?php echo __('home_get_more_done_with_freelancer','Get more done with freelancers'); ?></h1>
            <h4><?php echo __('home_grow_your_business_with_the_top_freelancing_website','Grow your business with the top freelancing website.'); ?></h4>
            <?php if(!empty($user_id)){ ?>
            <a href="<?=VPATH?>postjob" class="btn btn-lg btn-site btn-big"><img src="<?php echo IMAGE;?>tie.png" alt=""> <?php echo __('home_post_job','Post Job'); ?></a><span class="hidden-xs">&nbsp;&nbsp;</span>
            <?php }else{ ?>
            <a href="<?php echo base_url('login?refer=postjob')?>" class="btn btn-lg btn-site btn-big"><img src="<?php echo IMAGE;?>tie.png" alt=""> <?php echo __('home_post_job','Post Job'); ?> </a><span class="hidden-xs">&nbsp;&nbsp;</span>
            <?php } ?>
            <?php if(empty($user_id)){ ?>
            <a href="<?php echo base_url('signup');?>" class="btn btn-lg btn-border btn-big"><i class="zmdi zmdi-account" style="font-size: 22px;line-height: 1"></i> <?php echo __('home_register_now','Register now'); ?></a>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<?php if($page_skill=='Y') { ?>

<!-- skill secton start -->

<section class="sec skills pb-0">
  <div class="container">
    <div class="section-headline text-center">
        <h2 class="title"><?php echo __('home_','Top Categories'); ?></h2>
        <p>Choose from our wide variety of skilled professionals or simply post your renovation idea</p>
    </div>
   
    <div class="row">
      <?php



 /* if(count($skills) > 0){ foreach($skills as $k => $v){

	$img = !empty($v['image']) ? ASSETS.'skill_image/'.$v['image'] : IMAGE.'no-image_60x60.png';

	

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
      <article class="col-md-3 col-sm-4 col-50 col-12" data-effect="slide-left">
        <div class="skill-widgets"> <a href="<?php echo base_url('findtalents/?skills[]='.$v['id']); ?>" class="icon"> <img  src="<?php echo $img;?>" alt=""/> </a>
          <h5><a href="<?php echo base_url('findtalents/?skills[]='.$v['id']); ?>"><?php echo strlen($v['skill_name']) > 20 ? strip_tags(substr(ucwords($skill_name) , 0)).'..' : strip_tags(ucwords($skill_name));?></a></h5>
        </div>
      </article>
      <?php } } */ 
	  if(count($categories) > 0){ foreach($categories as $k => $v){ 
	  $img = !empty($v['image']) ? ASSETS.'skill_image/'.$v['image'] : IMAGE.'no-image_60x60.png';
	  ?>
	   <article class="col-xl-3 col-md-4 col-6" data-effect="slide-left">
        <a href="<?php echo base_url('findtalents/?cat_id='.$v['id']); ?>" class="card skill-widgets">
          <div class="card-body"><img  src="<?php echo $img;?>" alt=""/></div>
          <div class="card-footer"><h5><?php echo $v['cat_name']; ?></h5></div>
        </a>
      </article>
	  <?php } }?>
	  
	  
	  
    </div>
    <div class="text-center"> <a href="<?php echo base_url('user/skill_list');?>" class="btn btn-site"><?php echo __('home_see_all_','See All Categories'); ?></a> </div>
  </div>
</section>

<!-- skill section end -->

<?php } ?>

<!-- Features Jobs -->
<div class="sec section">
  <div class="container">
    <div class="section-headline text-center">
        <h2 class="title">Recent Jobs</h2>
        <p>We are dedicated to make your experience easy and hassle free</p>
    </div>
    <!-- Jobs Container -->
    <div class="listings-container grid-layout recent-jobs">
      <?php if($featured_projects){foreach($featured_projects as $k => $v){ 
		$budget = null;
		/* $budget_arr = array();
		if($v['buget_min'] > 0){
			$budget_arr[] = CURRENCY.$v['buget_min'];
		}
		if($v['buget_max'] > 0){
			$budget_arr[] = CURRENCY.$v['buget_max'];
		 } */
		$budget = get_project_budget($v['project_id'],true);
		$user_logo = get_user_logo($v['user_id']);
		?>
      <!-- Task -->
      <div class="job-listing"> 
        
        <!-- Job Listing Details -->
        <div class="job-listing-details"> 
        	<h3 class="job-listing-title"><a href="<?php echo $v['project_detail_url']; ?>"><?php echo $v['title'];?></a> <span class="h6 float-right text-muted"><i class="fas fa-gavel"></i> Bids : <?php echo $v['bid_count'];?></span></h3>            
          <!-- Logo -->
          <div class="job-listing-company-logo"> 
         <? if ($this->agent->is_mobile()){}else{?>
          <img src="<?php echo $user_logo;?>" alt="" />
          <?php }?>
           </div>
          <!-- Details -->
          <div class="job-listing-description">
            <p><?php echo $v['description'];?></p>
            <div class="task-tags">
              <?php if($v['skills']){foreach($v['skills'] as $skill){ ?>
              <span><?php echo $skill['name']; ?></span>
              <?php } } ?>
            </div>
              <p hidden><i class="icon-feather-map-pin"></i> San Francisco</p>
              <p class="text-muted"><i class="icon-feather-calendar"></i> <?php echo date('d M, Y', strtotime($v['post_date']));?></p>
            
          </div>
        </div>
        <div class="job-listing-footer">            
            <ul>
                <li class="f20"><?php echo ($budget);?></li>
                <li><a class="btn btn-site btn-sm" href="<?php echo $v['project_detail_url']; ?>">Bid Now</a></li>
            </ul>
        </div>
        <?php /*?><div class="task-listing-bid">
          <div class="task-listing-bid-inner">
            <div class="task-offers"> <strong><?php echo CURRENCY.$v['amount_spend'];?></strong> <span>Total Spent Amount</span> </div>
             </div>
        </div><?php */?>
      </div>
      <?php } } ?>
    </div>
    <!-- Jobs Container / End -->
    <div class="text-center "> <a href="<?php echo base_url('findjob');?>" class="btn btn-site"><?php echo __('home_see_all_','See All Jobs'); ?></a> </div>
  </div>
</div>
<!-- Featured Jobs / End -->

<section class="sec whiteBg" data-effect="slide-bottom">
  <div class="container">
    <div class="section-headline text-center">
        <h2 class="title"><?php echo __('home_how_it_works','How it works'); ?></h2>
        <p>We guarantee a safe and trusted environment where home owners and renovation professionals can connect to achieve great results</p>
    </div>
      <div class="row process">
        <div class="col-md-4 col-12">
          <div class="works-process">
				<img src="<?=IMAGE?>icon_project.png" alt="" />            
                <h4><?php echo __('home_po','Post Your Project'); ?></h4>
                <p><?php echo __('home_find_textpo','No matter how big or small your idea is, it only takes a few minutes to fill out our easy to use project questioner. There are no monthly or hidden fees and no obligation to hire. It’s simple!'); ?></p>
            
          </div>
        </div>
        
        <!--/column -->
        
        <div class="col-md-4 col-12">
          <div class="works-process">
              <img src="<?=IMAGE?>icon_review.png" alt="" />
              <h4><?php echo __('home_we','Review Bids'); ?></h4>
              <p><?php echo __('home_hire_textwe','Choose from our wide list of trusted and skilled professionals or accept the bid that suits your needs best. When you accept an offer, your payment is held securely until the task is finished and completely satisfactory. It’s so easy!'); ?></p>
          </div>
        </div>
        
        <!--/column -->
        
        <div class="col-md-4 col-12">
          <div class="works-process">
              <img src="<?=IMAGE?>icon_job.png" alt="" />
              <h4><?php echo __('home_qw','Get The Job Done'); ?></h4>
              <p><?php echo __('home_work_textas','When your project is complete, all you need to do is to release the payment held with our highly secure system to your contractor, leave a review and enjoy your freshly renovated home!'); ?></p>
          </div>
        </div>
        
        <!--/column --> 
        
      </div>
      
    
    <!--/.row --> 
    
  </div>
</section>

<?php if($featured_users){ ?>
<section class="sec ourTeam pb-0">
  <div class="container">
    <div class="section-headline text-center">
        <h2 class="title"><?php echo __('home_','FEATURED CONTRACTORS'); ?></h2>
        <p>Trusted professionals that can bring your most creative ideas to life</p>
    </div>
  </div>
  <div class="container testimonial-carousel-2 scrollable_"> 
    <!--<div class="row"></div>-->
      <?php if($featured_users){foreach($featured_users as $k => $v){ 
		$location = array();
		if(!empty($v['city_name'])){
			$location[] = $v['city_name'];
		}
		if(!empty($v['country'])){
			$location[] = get_country_name($v['country']);
		}
		$location_view = implode(',', $location);
		 $skill_list=$v['skills'];
		?>
        <div class="card team">
        <div class="card-body">
          <div class="hexagon"> <a href="<?php echo $v['profile_link'];?>"><img src="<?php echo get_user_logo($v['user_id']);?>" alt="" class="img-fluid" /></a> </div>
          <h4 class="mb-0"><a href="<?php echo $v['profile_link'];?>"><?php echo get_full_name($v['user_id']); ?></a></h4>
          <div class="star-rating" data-rating="<?php echo $v['user_rating'];?>"></div>
          <?php /*?><p>&nbsp;<?php echo $v['slogan'];?>&nbsp;</p><?php */?>
          <p class="text-muted mb-1"><i class="icon-feather-map-pin"></i> <?php echo $location_view;?></p>
          <div class="task-tags">
          <?php  if(count($skill_list)){
          	foreach($skill_list as $ks => $vs){
          	$skill_name=$vs['skill_name'];	
          	
          	?>
            <span><?php echo $skill_name;?></span>
        <?php }}?>
          </div>                          
        </div>
        <div class="card-footer">Earned: <b><?php echo CURRENCY;?> <?php echo round(get_earned_amount($v['user_id']));?></b> </div>
        </div>
      <!--<article class="col-xl-3 col-lg-4 col-md-6 col-12" data-effect="slide-left">
        
      </article>-->
      <?php } } ?>
    
    
  </div>
  <div class="text-center"><a href="<?php echo base_url('findtalents');?>" class="btn btn-site">See All Contractors</a></div>
</section>
<?php } ?>


<?php /*?>


<section class="sec wow pulse animated">

<div class="container">

<h2 class="title"><?php echo __('home_our_plans','Our Plans'); ?></h2>

<div class="plans">

<div class="pricing-table">

<div class="price" data-effect="slide-left">

    <div class="name"><h2>&nbsp;</h2><h4>&nbsp;</h4></div>

        <ul>

            <li><?php echo __('home_bids','Bids'); ?></li>

            <li><?php echo __('home_skills','Skills'); ?></li>

            <li><?php echo __('home_portfolio','Portfolio'); ?></li>

            <li><?php echo __('home_projects','Projects'); ?></li>

            <li><?php echo __('home_unlimited_days','Unlimited Days'); ?></li>

        </ul>						

	</div>

	<?php if(count($mem_plans) > 0){ foreach($mem_plans as $k => $v){ 

	$price_cls = 'free';

	$style = 'background-color:#00e676;';

	$border = 'border-bottom: 5px solid #00e676;';

	if($k == 1){

		$price_cls = 'silver featured';

		$style = 'background-color:#29b6f6';

		$border = 'border-bottom: 5px solid #29b6f6;';

	}else if($k == 2){

		$price_cls = 'gold';

		$style = 'background-color:#ffb300';

		$border = 'border-bottom: 5px solid #ffb300;';

	}else if($k == 3){

		$price_cls = 'platinum';

		$style = 'background-color:#aa00ff';

		$border = 'border-bottom: 5px solid #aa00ff;';

	}

?>



<div class="price <?php echo $price_cls;?>" data-effect="slide-left" style="<?php echo $border;?>">

    <div class="name" style="<?php echo $style;?>"><h2><?php echo ucfirst($v['name']);?></h2><h4><?php echo __('home_commission','Commission'); ?>: <span><?php echo round($v['bidwin_charge']);?></span> % </h4></div>

		<ul>

			<li><?php echo $v['bids'];?></li>

            <li><?php echo $v['skills'];?></li>

            <li><?php echo $v['portfolio'];?></li>

            <li><?php echo $v['project'];?></li>

			<?php if(strtolower($v['days']) == 'unlimited'){ ?>

			<li><i class="zmdi zmdi-check"></i></li>

			<?php } else { ?>

			 <li><i class="zmdi zmdi-close"></i></li>

			<?php } ?>

           

        </ul> 					

</div>

<?php } } ?>





</div>

</div>

<div class="spacer-10"></div>



  <a href="javascript:void(0)" id="compare">

    <i class="zmdi zmdi-unfold-more"></i> <!--<i class="zmdi zmdi-unfold-less">--></i>

    <span class="sr-only">Toggle Dropdown</span> <?php echo __('home_compare_details','Compare details'); ?>

  </a>  



</div>  

</section>

<script>

$(document).ready(function(){

    $('#compare').click(function(){

    $('.plans').toggleClass('autoH', 100000);

    });

});

</script>
<?php */?>

<?php if($page_testimonial=='Y') { ?>

<div dir="ltr" class="sec testimonials">
	<div class="section-headline text-center">
        <h2 class="title"><?php echo strtoupper(__('home_what_uor_client_saysa','WHAT OUR CLIENTS SAY?')); ?></h2>
        <p><?php echo __('home_find_out_that_people_say_about_us_textas','Find out what people say about us and think hundreds of satisfied customers.'); ?></p>
	</div>
	<div class="testimonial-style-5 testimonial-slider-2 poss--relative">
		<!-- Start Testimonial Nav -->
        <div class="testimonal-nav">
			<?php
			foreach($testimonials as $tkey=>$tval) {
				$client = $this->db->select('fname , lname , logo')->where('user_id' , $tval['user_id'])->get('user')->row_array();
				if(!empty($client['logo'])){
					if(file_exists('assets/uploaded/cropped_'.$client['logo'])){
						$client['logo']=base_url("assets/uploaded/cropped_".$client['logo']);
					}else{
						$client['logo']=base_url("assets/uploaded/".$client['logo']);
					}
				}else{
					$client['logo']=ASSETS.'images/user.png';
				}
				
			?>
            <div class="testimonal-img">
                <img src="<?php echo $client['logo'];?>" alt="author">
            </div>
			<?php
			}//for
			?>
        </div>
		<!-- End Testimonial Nav -->

		<!-- Start Testimonial For -->
        
        <div class="testimonial-for">			
            <?php
			$this->load->model('dashboard/dashboard_model');
			foreach($testimonials as $tkey=>$tval) {
				$client = $this->db->select('fname , lname , logo')->where('user_id' , $tval['user_id'])->get('user')->row_array();
				
				$rating = $this->dashboard_model->getrating_new($tval['user_id']);
				$avg_rating=0;
				if($rating[0]['num']>0){
					$avg_rating=round($rating[0]['avg']/$rating[0]['num'],2);
				}
			?>
            <div class="testimonial-desc">
                <div class="client">
                    <h4><?php echo strtoupper($client['fname'].' '.$client['lname']);?></h4>
                    <?php /*?><div class="star-rating" data-rating="<?php echo round($avg_rating, 1);?>"></div><?php */?>
                </div>
                <p><?php echo $tval['description'];?></p>
            </div>
			<?php
			}//for
			?>
        </div>        
		<!-- End Testimonial For -->



	</div>
                            
	<!-- Categories Carousel -->
	<div class="fullwidth-carousel-container margin-top-20 d-none">
		<div class="testimonial-carousel">
			<?php 
			  if(count($testimonials) > 0){ foreach($testimonials as $k => $v){   
				if($k > 3){
					break;
				}
				
				$client = $this->db->select('fname , lname , logo')->where('user_id' , $v['user_id'])->get('user')->row_array();
				$client['logo'] = !empty($client['logo']) ? ASSETS.'uploaded/'.$client['logo'] : ASSETS.'images/user.png';
			?>
			<!-- Item -->
			<div class="fw-carousel-review <?php if($k == 0){ echo 'active';} ?>">
				<div class="testimonial-box">
					<div class="testimonial-avatar">
						<img src="<?php echo $client['logo'];?>" alt="">
					</div>
					<div class="testimonial-author">
						<h3><?php echo strtoupper($client['fname'].' '.$client['lname']);?></h3>
						 <span><?php echo date('d M , Y' , strtotime($v['posted']));?></span>
					</div>
					<div class="testimonial"><?php echo $v['description'];?></div>
				</div>
			</div>			
            
		<?php   } } ?>
		</div>
	</div>
	<!-- Categories Carousel / End -->

</div>
<!-- Testimonial Start -->

<!-- end of client testimonial section -->


<?php } ?>
<?php /*?>
<section class="sec partner">

	<div class="container"> 

      <h4 style="margin:0 0 30px"><?php echo __('home_top_businesses_hiring_flance','Top businesses hiring on Flance'); ?></h4>

      

      <div class="carousel carousel-showsixmoveone slide" id="carousel123">

        <div class="carousel-inner">

        <?php if(count($partner) > 0){foreach($partner as $k => $v){ ?>

          <div class="carousel-item <?php if($k == 0){ echo 'active';} ?>">

            <div class="col-12 col-sm-4 col-md-2"><a href="#"><img src="<?php echo ASSETS.'partner_image/'.$v['image']?>" alt="<?php echo $v['name']?>"></a></div>

          </div>

          <?php } } ?>

          

        </div>

        <a class="left carousel-control" href="#carousel123" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>

        <a class="right carousel-control" href="#carousel123" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>

      </div>

	</div>

</section>
<?php */?>




<?php /*?>
<section class="sec experts hidden-xs" data-effect="slide-bottom" style="display:none">

	<div class="container">

    	<div class="row">

        <article class="col-sm-5 col-12">       

        	<div class="diamondSquare diamond-lg"><h3>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</h3></div>            

        </article>   

        <article class="col-sm-5 col-12 pull-right">       

        	<div class="diamondSquare diamond-sm">

            	<h3>Mr. Josef<br><span>CEO</span></h3>

            </div>            

        </article>     

        </div>

    </div>

</section> 

<section class="sec experts" data-effect="slide-bottom" style="display:none">

	<div class="container">

    	<div class="row">

        <article class="col-sm-5 col-12">       

        	<h3>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</h3>          

        </article>   

        <article class="col-sm-4 col-12">       

        	

            	<h3>Mr. Josef<br><span>CEO</span></h3>

                 

        </article>     

        </div>

    </div>

</section>
<?php */?>
<section class="sec whiteBg browseCat hide">
  <div class="container">
    <h2 class="title"><?php echo __('home_browae_top_skills','Browse top skills'); ?></h2>
    <div class="row">
      <?php /*

	$count = 0;

	// foreach($catagories as $k => $val){

	foreach($top_skill as $k => $val){	

		if($count == 0){

			$color = 'blue';

		}

		if($count ==1){

			$color = 'pink';

		}

		if($count == 2){

			$color = 'green';

		}

		if($count == 3){

			$color = 'yellow';

		}

		

		switch($lang){

				case 'arabic':

					$categoryName = !empty($val['arabic_cat_name'])? $val['arabic_cat_name'] : $val['skill_name'];

					$image = $val['image'];

					break;

				case 'spanish':

					//$categoryName = $val['spanish_cat_name'];

					$categoryName = !empty($val['spanish_cat_name'])? $val['spanish_cat_name'] : $val['skill_name'];

					$image = $val['image'];

					break;

				case 'swedish':

					//$categoryName = $val['swedish_cat_name'];

					

					$categoryName = !empty($val['swedish_cat_name'])? $val['swedish_cat_name'] : $val['skill_name'];

					$image = $val['image'];

					break;

				default :

					$categoryName = $val['skill_name'];

					$image = $val['image'];

					break;

			}

		

	?>

        <article class="col-sm-6 col-md-4 col-12 wowUp" data-wow-duration="1s" data-wow-delay="0s">

			<a href="<?php echo base_url('findjob/browse?skills[]='.$val['id']); ?>">

				<div class="box-color text-center <?php echo $color; ?>">

					<div class="icon-large">

						<?php if($image != ''){ 

						$image = str_replace('_thumb', '', $image);

						?>

						<img src="<?php echo ASSETS;?>skill_image/<?php echo $image?>" alt="Skill image"/>

						<?php } ?>

					</div>

					<!--<h4><?php echo $val['skill_name']; ?></h4>-->

					<h4><?php echo $categoryName; ?></h4>

					<!--<p> <?php echo $count_project[$val['id']]; ?> <?php echo __('home_projects','Projects'); ?></p>-->

					<p> <?php echo $count_project_top_skill[$val['id']]; ?> <?php echo __('home_projects','Projects'); ?></p>

				</div>

			</a>

        </article>

	<?php

	$count=$count+1;

if($count > 3){

	$count = 0;

}

	}
	*/ ?>
    </div>
    <div class="text-center"> <a href="<?php echo base_url('findjob'); ?>" class="btn btn-lg btn-border"><?php echo __('home_browae_all_prohects','Browse All Projects'); ?></a><span class="hidden-xs">&nbsp;&nbsp;</span> <a href="<?php echo base_url('signup');?>" class="btn btn-lg btn-site"><?php echo __('home_get_started','Get Started'); ?></a> </div>
  </div>
</section>
<?php  

$page_counting=$this->auto_model->getFeild('counting','pagesetup','id','1');

if($page_counting=='Y') { 

$user=$this->auto_model->getFeild('no_of_users', 'setting', 'id', 1);

$project=$this->auto_model->getFeild('no_of_projects', 'setting', 'id', 1);

$complete_project=$this->auto_model->getFeild('no_of_completed_prolects', 'setting', 'id', 1);
$no_of_contractors=$this->auto_model->getFeild('no_of_contractors', 'setting', 'id', 1);

?>
<section class="sec projects">
  <div class="container">
    <div class="row">
     <article class="col-md-3 col-sm-6 col-12">
        <div class="facts">
        <img src="<?php echo IMAGE;?>contractors.png" alt=""> 
          <h2><?php echo $no_of_contractors;?></h2>
          <h4>Contractors</h4>
          </div>
      </article>
      <article class="col-md-3 col-sm-6 col-12">
        <div class="facts">
        	<img src="<?php echo IMAGE;?>customers.png" alt="">
          <h2><?php echo $user;?></h2>
          <h4>Customers</h4>
           </div>
      </article>
	   
      <article class="col-md-3 col-sm-6 col-12">
        <div class="facts">
        <img src="<?php echo IMAGE;?>ongoing_projects.png" alt="">
          <h2><?php echo $project;?></h2>
          <h4>Ongoing Projects</h4>
           </div>
      </article>
      <article class="col-md-3 col-sm-6 col-12">
        <div class="facts">
        <img src="<?php echo IMAGE;?>completed_projects.png" alt="">
          <h2><?php echo $complete_project;?></h2>
          <h4>Completed Projects</h4>
           </div>
      </article>
    </div>
  </div>
</section>
<?php } ?>

<!-- fantastic facts section end --> 

<!-- social section start -->

<?php /*?><section class="triangle-icon">
  <ul class="social-icons diamondShape-icon">
    <?php

$popular=$this->auto_model->getalldata('','popular','id','1');

if(!empty($popular)){foreach($popular as $vals){ ?>
    <?php  if($vals->facebook=='Y' && ADMIN_FACEBOOK!=''){ ?>
    <li data-effect="helix"><a href="<?php echo ADMIN_FACEBOOK;?>" target="_blank"><i class="zmdi zmdi-facebook"></i></a></li>
    <?php } ?>
    <?php  if($vals->twitter=='Y' && ADMIN_TWITTER!=''){ ?>
    <li data-effect="helix"><a href="<?php echo ADMIN_TWITTER;?>" target="_blank"><i class="zmdi zmdi-twitter"></i></a></li>
    <?php } ?>
    <?php   if($vals->linkedin=='Y' && ADMIN_LINKEDIN!=''){ ?>
    <li data-effect="helix"><a href="<?php echo ADMIN_LINKEDIN;?>" target="_blank"><i class="zmdi zmdi-linkedin"></i></a></li>
    <?php } ?>
    <?php } } ?>
  </ul>
</section><?php */?>
<!-- social section end --> 

<style type="text/css">
@import url('<?=ASSETS?>plugins/testimonial/slick.min.css');
header .navbar {
	background-color:transparent;
	border:0
}
.is-sticky header .navbar {
	background-color:#fff;
	border-bottom: 1px solid #ddd;
}
#page-content {
    padding-top: 0;
}
@media (min-width: 992px){
header .navbar .navbar-nav .nav-link,
header .header-widget > a:not(.btn) {
    color: #fff;
}
.is-sticky .navbar .navbar-nav .nav-link,
.is-sticky .header-widget > a:not(.btn) {
    color: #333;
}
.is-sticky .navbar .navbar-nav .nav-link:hover,
.is-sticky .header-widget > a:not(.btn):hover {
    color: #52bf28;
}
}
.btn-outline-success {
    border-color: #28a745;
    color: #52bf28;
    background-color: #ffffff;
}
.mobile-menu {
	display:none
}
.unsticky .navbar-light .navbar-toggler {
    color: #fff;
    border-color: rgba(255, 255, 255, 0.25);
}
.unsticky .navbar-light .navbar-toggler-icon {
  background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}
</style>
<script src="<?=ASSETS?>plugins/testimonial/plugins.js"></script>
<script src="<?=ASSETS?>plugins/testimonial/slickjs.js"></script>
<script src="<?=ASSETS?>plugins/sticky/jquery.sticky.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('header').sticky({ topSpacing: 0,wrapperClassName :'sticky-wrapper unsticky'});
 	$('header').on('sticky-start', function() { 
  $('#sticky-wrapper').removeClass('unsticky');
   });
  $('header').on('sticky-end', function() { 
  $('#sticky-wrapper').addClass('unsticky');
   });
});
$(document).ready(function(){
	$('.navbar-toggler').click(function(){
    $('.sticky-wrapper').addClass('mobileNav');
	});
/*	$('.collapse-close').click(function(){
	$('.sticky-wrapper').removeClass('mobileNav');
	});*/
});
</script>
