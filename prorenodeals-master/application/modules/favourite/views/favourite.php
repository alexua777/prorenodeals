<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53a028a2284897c6"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
<?php

$user=$this->session->userdata('user');

?>               

<script src="<?=JS?>mycustom.js"></script>

<section id="mainpage">      
<div class="container-fluid">
<div class="row">
<?php $this->load->view('dashboard/dashboard-left'); ?>
<aside class="col-lg-10 col-md-9 col-12">
<?php echo $breadcrumb;?>
    <h4>Favourite Projects</h4>
    
    <?php /*?><table id="example" class="table table-striped table-bordered table-dashboard">[
        <thead>
        <tr>
            <th>Project ID</th>
            <th>Project</th>
            <th>category</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        <tbody>
        <?php if(count($project) > 0){ foreach($project as $k => $v){  ?>
        <tr>
            <td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']);?>"><?php echo $v['project_id'];?></a></td>
            <td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']);?>"><?php echo $v['title'];?></a></td>
            <td><?php if(is_numeric($v['category'])){ echo getField('cat_name', 'categories', 'cat_id', $v['category']); }else{ echo $v['category']; };?></td>
            <td><?php echo $v['project_type'] == 'H' ? 'Hourly' : 'Fixed';?></td>
            <!--<td><a href="<?php echo base_url('jobdetails/remove_fav/'.$v['project_id']).'?return=favourite';?>">Remove</a></td>-->
            <td><a data-object-id="<?php echo $v['user_id'];?>" data-object-type="FREELANCER" href="#" class="remove_fav">Remove</a></td>
        </tr>
        <?php } } ?>
        </tbody>
    </thead>
    </table><?php */?>
    
	<div class="listings-container compact-list-layout mb-4">
        <?php if(count($project) > 0){ foreach($project as $k => $v){  
		$user_logo =get_user_logo($v['user_id']);
		$fname = getField('fname', 'user', 'user_id', $v['user_id']);
		$lname = getField('lname', 'user', 'user_id', $v['user_id']);
		$dscr = getField('description', 'projects', 'project_id', $v['project_id']);
		$full_name = $fname.' '.$lname;
		?>
        
        
        <!-- Job Listing -->
        <div class="job-listing">
    
            <!-- Job Listing Details -->
            <div class="job-listing-details">
    
                <!-- Logo -->
                <div class="job-listing-company-logo">
                    <img src="<?php echo $user_logo;?>" alt="" />
                </div>
    
                <!-- Details -->
                <div class="job-listing-description">
                    <h3 class="job-listing-title"><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']);?>"><?php echo $v['title'];?></a></h3>
					
					<div class="mb-10"><?php echo $dscr;?></div>
    
                    <!-- Job Listing Footer -->
                    <div class="job-listing-footer">
                        <ul>
                        	<li><i class="icon-feather-user"></i> <?php echo $full_name;?></li>
                            <li><i class="icon-feather-hash"></i> <?php echo $v['project_id'];?></li>
                           
                            <!--<li><a href="<?php echo base_url('jobdetails/remove_fav/'.$v['project_id']).'?return=favourite';?>"><i class="icon-feather-trash"></i> Remove</a></li>-->
                          
                            <li><a data-object-id="<?php echo $v['project_id'];?>" data-object-type="JOB" href="#" class="remove_fav"><i class="icon-feather-trash"></i> Remove</a></li>
                        </ul>
                    </div>
                </div>
    
                <!-- Bookmark -->
                <span class="bookmark-icon" hidden></span>
            </div>
        </div>	
        <!-- Job Listing -->
        <?php } }else{  ?>
		<div class="well">Nothing to show</div>
		<?php } ?>
	</div>	
    
	<?php /*
	<h4>Favourite User</h4>
    <table id="table_2" class="table table-striped table-bordered table-dashboard">
        <thead>
        <tr>
            <th>User</th>
            <th>Name</th>
            <th>Country</th>
            <th>Action</th>
        </tr>
        <tbody>
        <?php if(count($freelancer) > 0){ foreach($freelancer as $k => $v){  
        $logo = get_user_logo($v['user_id']);
        $full_name = $v['fname'].' '.$v['lname']; 
        
        $flag = get_country_flag($v['country']);
        $country_name = get_country_name($v['country']);
        $rating = get_user_rating($v['user_id']);
        $profile_link = base_url('clientdetails/showdetails/'.$v['user_id']);
        ?>
        <tr>
            <td><a href="<?php echo $profile_link;?>"><img src="<?php echo $logo;?>" class="img-responsive" width="60"/></a></td>
            <td><a href="<?php echo $profile_link;?>"><?php echo $full_name;?></a></td>
            <td><?php echo $country_name; ?></td>
            <td><a data-object-id="<?php echo $v['user_id'];?>" data-object-type="FREELANCER" href="#" class="remove_fav">Remove</a></td>
        </tr>
        <?php } } ?>
        </tbody>
    </thead>
    </table>
	 */ ?>
		
</aside>
</div>

</div>
</section>
<div class="clearfix"></div>



<link rel="stylesheet" type="text/css" href="<?php echo CSS;?>datatable/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo CSS;?>datatable/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo CSS;?>datatable/dataTables.bootstrap.css">
<script type="text/javascript" language="javascript" src="<?php echo CSS;?>datatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo CSS;?>datatable/dataTables.responsive.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo CSS;?>datatable/dataTables.bootstrap.js"></script>
		
		
<script>
	jQuery(document).ready(function($) {
		$('#example,#table_2').DataTable();
	});
</script>

<script>
$('.remove_fav').click(function(e){
	e.preventDefault();
	var object_id = $(this).data('objectId');
	var object_type = $(this).data('objectType');
	
	removeFav(object_id, object_type, function(res){
		if(res.status == 1){
			location.reload();
		}
	});
});

</script>

