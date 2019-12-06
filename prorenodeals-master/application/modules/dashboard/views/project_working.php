<script src="<?=JS?>mycustom.js"></script> 

<section id="mainpage">                

<div class="container-fluid">

  <div class="row">
<?php $this->load->view('dashboard-left'); ?>
     

<aside class="col-lg-10 col-md-9 col-12">
<?php echo $breadcrumb;?>  
<?php $this->load->view('freelancer-project-tab'); ?> 

<?php   if ($this->session->flashdata('error_msg')){?>

<div class="error alert-danger alert "><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close" style="    line-height: 1.2;font-size: 18px;">×</a> <?php  echo $this->session->flashdata('error_msg');?></div>

<?php }?>

	
	<?php $this->load->view('project_working_ajax'); ?>
	
	</aside>
  </div>
</div>
</section>

