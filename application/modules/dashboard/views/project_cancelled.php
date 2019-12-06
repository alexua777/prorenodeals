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

	
	<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.responsive.css">

<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.bootstrap.css">

<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.responsive.min.js"></script>

<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.bootstrap.js"></script>

<script type="text/javascript" charset="utf-8">

$(document).ready(function() {

$('#example').dataTable({

columns: [

{},


{ orderable:      false, },

{}


],

"order": [[2, "desc" ]]

});

} );

</script>

<div class="" id="editprofile">

<table id="example" class="table table-hover">

<thead><tr><th>Project Name</th><th>Posted By</th><th>Posted date</th></tr>

</thead>

<tbody>	

<?php

$this->load->model('projectdashboard_new/projectdashboard_model');
if(count($projects)>0)

{

foreach($projects as $key=>$val)

{

	

$allend=explode(",",$val['end_contractor']);

$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);

$username=$this->auto_model->getFeild('fname','user','user_id',$val['user_id']);



///////////////////////////Check Milestone Status/////////////////////////////

$count_milestone=$this->auto_model->count_results('id','project_milestone','project_id',$val['project_id']);

if($count_milestone>0)

{

$client_approval_Y=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'Y'));

$client_approval_N=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'N'));

$client_approval_D=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'D'));

$request_by=$this->auto_model->getFeild('request_by','project_milestone','project_id',$val['project_id']);

}

//////////////////////////End Checkinh Milestone////////////////////////////////

$type="";

if($val['project_type']=="F")

{

$type="Fixed";

}

else

{

$type="Hourly";

}



$is_escrowed = 0;

if($val['project_type']=="F"){

	$milestone_row_all = $this->projectdashboard_model->getsetMilestone($val['project_id']);

	$milestone_row = !empty($milestone_row_all[0]) ? $milestone_row_all[0] : array();

	if($milestone_row){

		$escrow_row = $this->db->where('milestone_id', $milestone_row['id'])->get('escrow_new')->row_array();

		if(!empty($escrow_row)){

			$is_escrowed = 1;

		}

	}



}else{

	$milestone_row = array();

}

?>

<tr>
<td>
	<a href="<?php echo VPATH.'job-'.seo_string($project_name).'-'.$val['project_id']; ?>"><?php echo $project_name;?></a>
</td>


<td><?php echo $username;?></td>

<td><?php echo $this->auto_model->date_format($val['post_date']);?></td>



</tr>

<?php

}

}



?>	

</tbody>

</table>



</div>

	</aside>
  </div>
</div>
</section>


<script>


$(document).ready(function(){
  $('[data-toggle="popover"]').popover(); 
});
</script>
