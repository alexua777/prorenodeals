<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.js" type="text/javascript"></script>

<section class="breadcrumb-classic">
  <div class="container">
    <div class="row">
      <aside class="col-sm-6 col-xs-12">
        <h3>FIND CONTEST</h3>
      </aside>
      <aside class="col-sm-6 col-xs-12">
        <ol class="breadcrumb text-right">
          <li><a href="<?php echo base_url('dashboard/dashboard_new');?>">Home</a></li>
          <li class="active">Contest</li>
        </ol>
      </aside>
    </div>
  </div>
</section>
<section class="sec">
  <div class="container">
    <div class="row">
      <aside class="col-md-3 col-sm-12 col-xs-12">
        <div class="left_sidebar">
          <h4 class="title-sm">Category</h4>
          <ul class="list-group scroll-bar">
            <?php if(count($categories) > 0){foreach($categories as $k => $v){ ?>
            <li><a href="<?php echo base_url('contest/browse/'.$v['cat_id'].'/'.seo_string($v['cat_name'])); ?>"><?php echo $v['cat_name']; ?></a></li>
            <?php } } ?>
          </ul>
        </div>
      </aside>
      <aside class="col-md-9 col-sm-12 col-xs-12">
        <div class="topcontrol_box" style="display:none">
          <div class="topcbott"></div>
        </div>
        <h4 class="title-sm">&nbsp;</h4>
        <div class="searchbox">
          <form id="srchForm">
			  <div class="form-group">
				<select class="form-control inputtag" name="skills[]" multiple>
				<?php if(count($selected_skills) > 0){foreach($selected_skills as $k => $v){ ?>
					<option value="<?php echo $v['id']; ?>" selected="selected"><?php echo $v['skill_name']; ?></option>
				<?php } } ?>
				</select>
			</div>
	
            <div class="input-group input-group-lg">
              <input type="text" class="form-control" placeholder="Search contest by title..." name="term" value="<?php echo !empty($srch['term']) ? $srch['term'] : ''; ?>" autocomplete="off">
              <span class="input-group-addon" id="basic-addon1">
              <button type="submit" class="btn btn-site"><i class="zmdi zmdi-search"></i> Search</button>
              </span> </div>
          </form>
          <p class="text-right" style="display:none;"><a style="cursor: pointer;">Advanced Search</a></p>
        </div>
        <div class="listing">
          <?php if(count($contest_list) > 0){foreach($contest_list as $k => $v){ ?>
          <div class="listBox">
            <p class="designation"><a href="<?php echo base_url('contest/contest-detail/'.$v['contest_id'].'-'.seo_string($v['title'])); ?>"><?php echo $v['title']; ?></a></p>
            <div class="pull-left"><p> <b><?php echo $v['total_entries'];?></b> Entries</p></div>
            <div class="pull-right">
			<?php if($v['is_featured'] == 1){ ?><span class="label-tag label-warning"><i class="zmdi zmdi-star"></i> FEATURED</span> <?php } ?>
			<?php if($v['is_sealed'] == 1){ ?><span class="label-tag label-info"><i class="zmdi zmdi-shield-security"></i> SEALED</span> <?php } ?>
			<?php if($v['is_guranteed'] == 1){ ?><span class="label-tag label-success"><i class="zmdi zmdi-thumb-up"></i> GURANTEED</span> <?php } ?>
			</div>
            <div class="clearfix"></div>
            <p><?php echo strlen($v['description']) > 200 ? substr($v['description'], 0, 200).'...' : $v['description']; ?></p>
            <ul class="skills">
              <li>Skills: </li>
              <?php if(count($v['skills']) > 0){foreach($v['skills'] as $skill){ ?>
              <li><a href="javascript:void(0);"><?php echo $skill['skill_name']; ?></a> </li>
              <?php } } ?>
            </ul>
            <p> <span class="border-tag border-tag-success">Started: <?php echo date('d M , Y', strtotime($v['posted'])); ?></span> &nbsp; <span class="border-tag border-tag-danger">End : <?php echo date('d M , Y', strtotime($v['ended'])); ?></span> <a href="<?php echo base_url('contest/contest-detail/'.$v['contest_id'].'-'.seo_string($v['title'])); ?>" class="btn btn-site btn-sm pull-right">View Contest</a> </p>
          </div>
          <?php } }else{  ?>
          <p>Sorry , No Results Found</p>
          <?php  } ?>
          <?php echo $links; ?> </div>
      </aside>
    </div>
  </div>
</section>

<script>
$('.inputtag').tokenize2({
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
	$('#srchForm').submit();
});
</script>
<script src="<?php echo JS;?>jquery.nicescroll.min.js"></script>
<script>
  $(document).ready(function() {  	    
	$(".scroll-bar").niceScroll();
  });
</script>