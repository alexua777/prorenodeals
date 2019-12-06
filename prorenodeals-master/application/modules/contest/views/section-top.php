<script>
    $(window).load(function(){
      $("#sticky_panel").sticky({ topSpacing: 65});
    });
</script>
<style type="text/css">
.heading {
    font-weight: 500;
    font-size: 17px;
    padding: 10px 0px;
    border-bottom: 1px solid #ddd;
}
.header-bottom {
	background-color: #2c597a;
	color: #fff;
    width: 100%;
    z-index: 99;
}
.nav-tabs {
    border-bottom: none
}
.nav-tabs > li a {
	display: block;
	color: white;
}
.nav-tabs > li {
	margin-bottom:0
}
.nav-tabs > li.active a, .nav-tabs > li.active > a:hover {
    color:#fff
}
</style>
<section class="breadcrumb-classic">
	<div class="text-right caption-text"><div class="container"><h5>Ended: <?php echo date('d M , Y', strtotime($details['ended'])); ?></h5></div></div>
   <div class="container" style="margin-top:15px">
      <div class="row">
		 <aside class="col-sm-8 col-xs-12">
			<h3><?php echo $details['title']; ?> <span class="pull-right"><?php echo CURRENCY.' '.$details['budget']; ?> USD</span></h3>
		 </aside>
		 <aside class="col-sm-4 col-xs-12">         	
			<ol class="breadcrumb text-right">								
				<li><a href="<?php echo base_url();?>">Home</a></li><li class="active">Post Contest</li></ol>
         </aside>					
      </div>	      			  				  
   </div>			   
</section>
<div class="header-bottom" id="sticky_panel">
   <div class="container">
    <div class="row">
        <div class="col-sm-8">
	
            <ul class="nav nav-tabs inline-block-list">
                <li class="<?php echo $active_tab == 'detail' ? 'active' : '';?>"><a href="<?php echo base_url('contest/contest-detail/'.$details['contest_id'].'-'.seo_string($details['title'])); ?>">Description</a></li>
                <li class="<?php echo $active_tab == 'entries' ? 'active' : '';?>"><a href="<?php echo base_url('contest/entries/'.$details['contest_id'].'-'.seo_string($details['title'])); ?>">Entries</a></li>
            </ul>
        </div>
        <div class="col-sm-4">
            <?php if(($details['user_id'] != $login_user_id) && ($details['status'] == 'Y')){ ?>
            <div style="text-align: right">
                <a class="btn btn-site" href="<?php echo base_url('contest/contest_entry/'.$details['contest_id']); ?>" style="margin-top:5px">Upload an Entry</a>
            </div>
            <?php } ?>
        </div>
	</div>
    </div>   
    </div>