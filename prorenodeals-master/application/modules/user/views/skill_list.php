<section class="sec skills">
  <div class="container">
    <h2 class="title">All Categories<br>
    </h2>
    <div class="row row-10">
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
	   <article class="col-md-3 col-sm-4 col-50 col-12">
        <div class="skill-widgets"> <a href="<?php echo base_url('findtalents/?cat_id='.$v['id']); ?>"> <img  src="<?php echo $img;?>" alt=""/> </a>
          <h5><a href="<?php echo base_url('findtalents/?cat_id='.$v['id']); ?>"><?php echo $v['cat_name']; ?></a></h5>
		  <div class="skill-list">
			<ul>
				<?php if($v['skills']){foreach($v['skills'] as $key => $skill){ ?>
				<li><a href="<?php echo base_url('findtalents/?skills[]='.$skill['id']); ?>"><?php echo $skill['skill_name'];?></a></li>
				<?php } } ?>
			</ul>
		  </div>
        </div>
      </article>
	  <?php } }?>
    </div>
    
  </div>
</section>