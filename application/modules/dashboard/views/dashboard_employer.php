<section id="mainpage">
<div class="container-fluid">
<div class="row">
<?php $this->load->view('dashboard-left'); ?>
<aside class="col-lg-10 col-md-9 col-12">
	<?php echo $breadcrumb; ?>
    <div class="row">
    	<article class="col-sm-6 col-12">
    	<div class="well fun-fact" style="min-height:250px">

			<?php if($total_posted_work > 0){ ?>

			<div id="chartContainer" style="height: 220px; width: 100%;"></div>    	

			<?php }else{ ?>

			<h3>No projects</h3>

			<div class="text-center"><a href="<?php echo base_url('postjob')?>" class="btn btn-site">POST PROJECT NOW</a></div>

			<?php } ?>

    	</div>

        </article>

        <article class="col-sm-6 col-12">
        <div class="well fun-fact" style="min-height:250px;">
            <img src="<?php echo IMAGE;?>icon_project.png" alt="" />
            <h4>Posted Jobs</h4>
            <h2><?php echo $total_posted_work; ?></h2>
            <a href="<?php echo base_url('postjob');?>" class="btn btn-site">Post Job</a>
        </div>    	
        </article>
    </div>

    <div class="row">
    <article class="col-sm-4 col-12">
     <div class="well fun-fact">
     	<img src="<?php echo IMAGE;?>wallet-70x70.png" alt="" />
		<h4>Total spent on projects</h4>
		<h2><?php echo CURRENCY. ' '.format_money($spend_amount, TRUE);?></h2>
    </div>
    </article>
    <article class="col-sm-4 col-12">
     <div class="well fun-fact">
     	<img src="<?php echo IMAGE;?>project-70x70.png" alt="" />
		<h4>Total completed projects</h4>
		<h2><?php echo $total_completed_project;?></h2>
    </div>
    </article>
    <article class="col-sm-4 col-12">
     <div class="well fun-fact">
     	<img src="<?php echo IMAGE;?>ongoing-70x70.png" alt="" />
		<h4>Total on-going projects</h4>
		<h2><?php echo $total_ongoing_project;?></h2>
    </div>
    </article>
    <!--<article class="col-sm-6 col-12">
		<div class="well text-center mb-3">				
    	</div>
    </article>-->
	</div>
    
    <h3 class="mb-3">Project Payments</h3>
	<div data-ajaxify="<?php echo base_url('projectdashboard_new/get_all_payments?'.http_build_query(get())); ?>"></div>
    
    <h3>Financial Information</h3>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">In Progress</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Completed</a>
      </li>     
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="table-responsive mb-30">
		<table class="table table-middle table-borderless table-hover">
		  <thead> 
			<tr>
				<th>Profile</th>
                <th>#Project ID</th>
				<th>Project</th>
				<th>Total On Hold Amount(<?php echo CURRENCY; ?>)</th>
				<th>Total Paid Amount (<?php echo CURRENCY; ?>)</th>
			</tr>

			</thead>
			<tbody>

				<?php if(count($inprogress_project) > 0){foreach($inprogress_project as $k => $v){ ?>

				<tr>
					<td><a href="<?php echo $v['profile_url']; ?>"><img src="<?php echo get_user_logo($v['bidder_id']);?>" alt="" height="36" width="36" class="rounded-circle mr-2" /> <?php echo !empty($v['fname']) ? $v['fname'].' '.$v['lname'] : 'Unknown';?></a></td>
                    <td hidden><a href="<?php echo base_url('myfinance/project_all_transaction/'.$v['project_id'])?>"><?php echo !empty($v['project_id']) ? '#'.$v['project_id'] : ''; ?></a></td>
                    <td><?php echo !empty($v['project_id']) ? '#'.$v['project_id'] : ''; ?></td>

					<td><?php echo !empty($v['title']) ? (strlen($v['title']) > 60 ? substr($v['title'], 0, 60).'...' : $v['title']) : ''; ?></td>

					<td style="color:green;"><?php echo !empty($v['total_credit']) ? $v['total_credit'] : ''; ?></td>

					<td style="color:red;"><?php echo !empty($v['total_debit']) ? $v['total_debit'] : ''; ?></td>

				</tr>

				<?php } }else{  ?>

				<tr>

					<td colspan="10" style="text-align:center;">No records found</td>

				</tr>

				<?php } ?>

			</tbody>
		</table>
	</div>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <div class="table-responsive mb-30">
		<table class="table table-middle table-borderless table-hover">
		  <thead> 
			<tr>
				<th>Profile</th>
                <th>#Project ID</th>
				<th>Project</th>
				<th>Total On Hold Amount(<?php echo CURRENCY; ?>)</th>
				<th>Total Paid Amount (<?php echo CURRENCY; ?>)</th>
			</tr>

			</thead>
			<tbody>

				<?php if(count($completed_project) > 0){foreach($completed_project as $k => $v){ ?>

				<tr>
					<td><a href="<?php echo $v['profile_url']; ?>"><img src="<?php echo get_user_logo($v['bidder_id']);?>" alt="" height="36" width="36" class="rounded-circle mr-2" /> <?php echo !empty($v['fname']) ? $v['fname'].' '.$v['lname'] : 'Unknown';?></a></td>
                    <td hidden><a href="<?php echo base_url('myfinance/project_all_transaction/'.$v['project_id'])?>"><?php echo !empty($v['project_id']) ? '#'.$v['project_id'] : ''; ?></a></td>
                    <td><?php echo !empty($v['project_id']) ? '#'.$v['project_id'] : ''; ?></td>

					<td><?php echo !empty($v['title']) ? (strlen($v['title']) > 60 ? substr($v['title'], 0, 60).'...' : $v['title']) : ''; ?></td>

					<td style="color:green;"><?php echo !empty($v['total_credit']) ? $v['total_credit'] : ''; ?></td>

					<td style="color:red;"><?php echo !empty($v['total_debit']) ? $v['total_debit'] : ''; ?></td>

				</tr>

				<?php } }else{  ?>

				<tr>

					<td colspan="10" style="text-align:center;">No records found</td>

				</tr>

				<?php } ?>

			</tbody>
		</table>
	</div>
      </div>
    </div>

	

    <?php /*?>
	<h3 hidden>Escrow View</h3>
     <div class="table-responsive" hidden>
        <table class="table">
          <thead> 
            <tr>
                <th>#Project ID</th>
                <th>Project</th>
                <th>Escrowed Amount (<?php echo CURRENCY; ?>)</th>
                <th>Released Amount (<?php echo CURRENCY; ?>)</th>
            </tr>

            </thead>

            <tbody>

                <?php if(count($escrow_statics) > 0){foreach($escrow_statics as $k => $v){ ?>

                <tr>

                    <td><a href="<?php echo base_url('myfinance/project_all_transaction/'.$v['project_id'])?>"><?php echo !empty($v['project_id']) ? '#'.$v['project_id'] : ''; ?></a></td>

                    <td><?php echo !empty($v['title']) ? (strlen($v['title']) > 60 ? substr($v['title'], 0, 60).'...' : $v['title']) : ''; ?></td>

                    <td style="color:green;"><?php echo !empty($v['total_credit']) ? $v['total_credit'] : ''; ?></td>

                    <td style="color:red;"><?php echo !empty($v['total_debit']) ? $v['total_debit'] : ''; ?></td>

                </tr>

                <?php } }else{  ?>

                <tr>

                    <td colspan="10" style="text-align:center;">No records found</td>

                </tr>

                <?php } ?>



            </tbody>

            

        </table>
    </div>
	<?php */?>

    <h3>Recent Posted Work</h3>
    
    <div class="clearfix"></div>
    <div class="table-responsive mb-30">
        <table class="table table-borderless table-hover">
        <thead> 
        	<th>Project title</th><th>Bids</th><th>Hourly/Fixed</th><th>Posted on</th><th>Status</th>      	        	
        </thead>
        <tbody>

			<?php if(count($recent_project) > 0){foreach($recent_project as $k => $v){ 

			$url = '';

			

			if(($v['project_status'] == 'O') || ($v['project_status'] == 'E') || ($v['project_status'] == 'F')){

				/* $url =  base_url('jobdetails/details/'.$v['project_id'].'/'.seo_string($v['title']).'/'); */

				$url =  base_url('job-'.seo_string($v['title']).'-'.$v['project_id']);

			}else{

				$url = base_url('projectdashboard_new/employer/overview/'.$v['project_id']);

			}
			
			$status = '';
			switch($v['project_status']){
				case 'O':
					$status = '<span class="badge badge-warning">Open</span>';
				break;
				case 'P':
					$status = '<span class="badge badge-success">Progress</span>';
				break;
				case 'E':
					$status = '<span class="badge badge-danger">Expired</span>';
				break;
				case 'C':
					$status = '<span class="badge badge-info">Completed</span>';
				break;
				case 'S':
					$status = '<span class="badge badge-danger">Stopped</span>';
				break;
				
				default:
				$status = '<span class="badge badge-danger">Deleted</span>';
			}

			?>

            <tr>

              <td><a href="<?php echo $url; ?>"><?php echo strlen($v['title']) > 90 ? substr($v['title'], 0, 90).'...' : $v['title'];  ?></a></td>

			   <td><?php echo $v['total_bids']; ?></td>

			   <td><?php echo $v['project_type'] == 'F' ? 'Fixed' : 'Hourly';?></td>

			   <td><?php echo date('d M , Y', strtotime($v['post_date']));?></td>

			   <!--<td><a href="<?php echo  base_url('job-'.seo_string($v['title']).'-'.$v['project_id']); ?>">Details</a></td>-->
			   <td><?php echo $status; ?></td>

            </tr>             

			<?php } }else{  ?>

			<tr>

				<td colspan="10" style="text-align:center;">No recent project found</td>

			</tr>

			<?php } ?>

           

        </tbody>

        </table>

	</div>
	

</aside>

</div>

</div>

</section>



<script>

window.onload = function () {



var chart = new CanvasJS.Chart("chartContainer", {

	animationEnabled: true,	

	legend:{

		cursor: "pointer",

		horizontalAlign: "right",

		verticalAlign: "center",

		fontSize: 12,

		fontFamily: 'Montserrat'

	},

	data: [{

		type: "pie",

		showInLegend: true,

		//indexLabel: "{name} - {y}%",

		dataPoints:<?php echo json_encode($project_statics);?>

	}]

});

chart.render();

}

</script>

<script src="<?php echo ASSETS;?>plugins/canvasjs/canvasjs.min.js" type="text/javascript"></script>























