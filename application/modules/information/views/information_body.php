<section class="sec">
<div class="breadcrumb-classic">  
  <div class="container">
    <div class="row">
    <aside class="col-sm-6 col-12">
		<h1 class="float-md-left"><?=ucwords($page_info[0]['content_title'])?></h1>
    </aside>

    <aside class="col-sm-6 col-12">
	<ol class="breadcrumb float-md-right">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
      <li class="breadcrumb-item active"><?=ucwords($page_info[0]['content_title'])?></li>
    </ol>
    </aside>            
    </div>
	</div>       
</div>
<div class="container">	       

    <div class="whiteSec post-content">    	

        <p><?=html_entity_decode(( $page_info[0]['contents']))?></p>

    </div>
</div>
</section>         
<style>
.post-content ul, .post-content ol, .post-content li {
	list-style:inherit
}
.post-content ul, .post-content ol {
	padding-left:30px
}
</style>