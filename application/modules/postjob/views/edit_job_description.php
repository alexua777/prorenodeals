

<style>

.item.selected {

    background-color: #e2dfdf;

}



.qBx{

	position: relative;

	padding: 10px;

}



.invalid {

    border: 1px solid red;

}

</style>

<?php $lang=$this->session->userdata('lang'); ?>

<?php echo $breadcrumb;?> 

        

<div class="clearfix"></div>

<section id="mainpage">

<div class="container-fluid">
<div class="row">
<?php $this->load->view('dashboard/dashboard-left'); ?>

<aside class="col-lg-10 col-md-9 col-12">

<div id="wrapper">

<h3 class="form-title" id="post_job_title">Edit Job:</h3>

<div class="post-form">

 <form id="editForm">

	<input type="hidden" name="project_id" value="<?php echo $project_id ?>"/>

 <div class="row">        	

		<div class="col-xs-12">

			<label for="" class="control-label">Edit job description </label>            	

			<textarea class="form-control" rows="5" name="description" id="description"></textarea>

			<span id="descriptionError" class="error-msg13 rerror"></span>

		</div>

	</div>

	

	<button class="btn btn-site" id="submit-btn">Update</button>

 </form>

</div>	

</div>

</aside>



	

</div>

</div>  

</section>



<script>

	$('#editForm').submit(function(e){

		e.preventDefault();

		var fdata = $(this).serialize();

		var dscr = $('#description').val();

		if(dscr.trim() == ''){

			$('#descriptionError').html('Please add some description');

			return;

		}else{

			$('#descriptionError').html('');

		}

		$('#submit-btn').attr('disabled', 'disabled');

		$('#submit-btn').html('Saving...');

		$.ajax({

			url : '<?php echo base_url('postjob/edit_description')?>',

			data: fdata,

			type: 'POST',

			dataType: 'JSON',

			success: function(res){

				if(res.status == 1){

					$('#wrapper').html(res.message);

				}

			}

		});

	});

</script>



