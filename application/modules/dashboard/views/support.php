<style>
ul.list{
	
}

ul.list li.question-item{
	margin-bottom: 10px;
    padding: 10px 0px;
    border-bottom: 1px solid #ddd;
}

ul.list li.question-item .question{
	font-weight: bold;
    font-size: 17px;
}

ul.list li.question-item .question span{ 
	margin-left: 25px;
}

ul.list li.question-item .question-reply{
    font-size: 17px;
}

ul.list li.question-item ul.child{
	padding-left: 30px;
}

</style>

<?php echo $breadcrumb; ?> 
<section id="mainpage">
<div class="container-fluid">
<div class="row">
<?php $this->load->view('dashboard-left'); ?> 
<aside class="col-lg-10 col-md-9 col-12">
<div class="spacer-20"></div>
<form action="" method="post">
<div class="card">

<?php 
$category = array(
	'Help',
	'Suggestion',
	'Issues/Error',
);
$category_css_class = array(
	'Help' => 'badge-primary',
	'Suggestion' => 'badge-warning',
	'Issues/Error' => 'badge-danger',
);
?>

  <div class="card-body">
   <div class="alert alert-info" role="alert">
	  <strong>Info!</strong> Anytime you encounter any problems or you have any suggestions. Drop your message here. You can also use this panel in case you need any help from admin.
	</div>
	
	<div class="form-group">
		<select class="form-control" name="category">
			<option value="">Select Category</option>
			<?php print_select_option($category);?>
		
		</select>
		<?php echo form_error('category', '<div class="rerror">', '</div>');?>
	</div>
	
	<div class="form-group">
		<textarea class="form-control" name="support_message"></textarea>
		<?php echo form_error('support_message', '<div class="rerror">', '</div>');?>
	</div>
	
	
	<button class="btn btn-primary">Send</button>
	
  </div>
</div>
	
<ul class="list">
	<?php if($list){foreach($list as $k => $v){ ?>
	<li class="question-item">
		<div class="question"><?php echo $v['support_message']; ?> <span class="badge badge-pill <?php echo !empty($category_css_class[$v['category']]) ? $category_css_class[$v['category']] : 'badge-secondary'; ?>"><?php echo $v['category']; ?></span></div>
		<div class="sub-info"><b><i><?php echo $v['replied'] > 0 ? 'Replied' : 'Not Replied'; ?></i></b> . <span class="time"><?php echo date('d M, Y', strtotime($v['date'])); ?></span></div>
		<ul class="child">
			<li class="question-reply"><?php echo $v['reply']; ?> </li>
		</ul>
	</li>
	<?php } } ?>
</ul>
	
	
</form>
</aside>
</div>
</div>
</section>
