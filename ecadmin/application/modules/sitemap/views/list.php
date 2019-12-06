<?php // $this->load->library('session');   ?>
<section id="content">
<div class="wrapper">

<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'sitemap/add'; ?>">Add Sitemap </a></li>
        <li class="breadcrumb-item active"><a>Sitemap List</a> </li>        
        </ol>
	</nav> 

<div class="container-fluid">
<div class="row">

<div class="col-sm-12">	
	<?php
	if ($this->session->flashdata('succ_msg')) {
		echo '<div class="succ_msg alert-success">';
		echo $this->session->flashdata('succ_msg');
		echo '</div>';
	}
	if ($this->session->flashdata('error_msg')) {
		echo '<div class="alert-error error_msg">';
		echo $this->session->flashdata('error_msg');
		echo '</div>';
	}
	?>
	<table class="table table-hover adminmenu_list">
		<thead>
			<tr>
				<th>#</th>
				<th>Sitemap Name</th>
				<th>Url</th>
				<th align="right">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$onclick = "javascript: return confirm('Are you want to delete?');";
			$attr = array(
				'onclick' => $onclick,
				'class' => 'la la-times _165x red',
				'sitemap_name' => 'Delete'
			);

			$atr3 = array('class' => 'i-close-4 red', 'title' => 'Inactive');
			$atr4 = array('class' => 'i-checkmark-4 green', 'title' => 'Active');
           if(count($list)!==0) {
			foreach ($list as $key => $sitemap) {
				?>

				<tr>

					<td align="center"><?php  echo $key+1;?></td>
					<td><?php echo $sitemap['name']; ?></td>
					<td><?php echo $sitemap['url']; ?></td>
				
					<td align="right">
						<?php
						
						$atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit');

					   
						echo anchor(base_url() . 'sitemap/edit/' . $sitemap['id'], '&nbsp;', $atr2);
						echo anchor(base_url() . 'sitemap/delete_sitemap/' . $sitemap['id'], '&nbsp;', $attr);
						?>
					</td>
				</tr>



			<?php } ?>
			<? }else {?>
<tr>
<td colspan="4" align="center" class="red">
No Records Found
</td>
</tr>
<? }?>
		</tbody>
	</table>
		<?php if ($page>30) {?>    
                  
		 <div class="pagin"><p>Page:</p><a class="active"><?php echo $links; ?></a></div>
		 <?php }?>
</div><!-- End .col-lg-6  -->
</div><!-- End .row-fluid  -->

</div> <!-- End .container-fluid  -->
</div> <!-- End .wrapper  -->
</section>
