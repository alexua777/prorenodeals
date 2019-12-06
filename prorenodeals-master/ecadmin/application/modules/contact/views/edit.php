<section id="content">
<div class="wrapper">
<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'news'; ?>">News/Article List</a></li>
        <li class="breadcrumb-item active"><a>Modify News/Article</a></li>
      </ol>
	</nav>
<script>
$(function() {
$("#strtdt").datepicker();
});
</script>
<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="icon"><i class="icon20 i-stack-checkmark"></i></div>
				<h4>Modify News/Article Management</h4>
				<a href="#" class="minimize2"></a> </div>
			<!-- End .panel-heading -->
			<div class="panel-body">
				<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
				<form id="validate" action="<?php echo base_url(); ?>news/edit" class="form-horizontal" role="form" name="news" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $id; ?>" />					
					<div class="row">
                    <div class="col-lg-6">
						<label class="col-form-label" for="required">Select Type</label>
						
						<select name="type" for="required" class="select2 select_type required  form-control">
                         <option>Select Type</option>
						   <option <?php if ($type == 'news') echo 'selected'; ?> value="news">News</option>
                           <option <?php if ($type == 'article') echo 'selected'; ?> value="article">Article</option>	
						 </select>	
                    </div>
                    <div class="col-md-6">
                    <label class="col-form-label" for="required">Title</label>						
						 <input type="text" value="<?php echo $title; ?>" name="title" class="required form-control">
                         <?php echo form_error('title', '<label class="error" for="required">', '</label>'); ?>
                    </div>
					</div>

					<div class="form-group">
						<label class="col-form-label" for="required">Description</label>
                          <textarea name="description" id="text-editor" class="required form-control" rows="15" cols="40"><?php echo $description; ?></textarea>				 
						  <?php echo form_error('description', '<label class="error" for="required">', '</label>'); ?>
						
					</div>
					<div class="form-group">
						<label class="col-form-label" for="required">Date</label>						
                        <input type="text" value="<?php echo $news_date; ?>" name="news_date" 
                        class="required form-control" id="strtdt">
                        <?php echo form_error('news_date', '<label class="error" for="required">', '</label>'); ?>						 
					</div>
					<div class="form-group">
						<label class="col-form-label" for="required">Order</label>						
							<input type="text" value="<?php echo $order; ?>" name="order" class="required form-control">
                            <?php echo form_error('order', '<label class="error" for="required">', '</label>'); ?>
					</div>
					<div class="form-group">
						<label class="col-form-label" for="agree">Status</label><br />
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                          <label class="custom-control-label" for="status">Online</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status" name="status" value="N" <?php if ($status == 'N') {echo 'checked';} ?>>
                          <label class="custom-control-label" for="status_2">Offline</label>
                        </div>						
					</div>
					<button type="submit" class="btn btn-primary">Save</button>&nbsp;
					<button type="button" onclick="redirect_to('<?php echo base_url() . 'advertisement'; ?>');" class="btn btn-secondary">Cancel</button>
				</form>
			</div>
			<!-- End .panel-body -->
		</div>
</div>
<!-- End .container-fluid  -->
</div>
<!-- End .wrapper  -->
</section>
