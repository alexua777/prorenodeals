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
<nav>
  <ul class="nav nav-tabs" id="nav-tab" role="tablist">
    <li class="nav-item"><a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Hired Contractors</a></li>
    <li class="nav-item"><a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Invited Contractors</a></li>
    <li class="nav-item"><a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Favourite Contractors</a></li>
  </ul>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
  
  <div class="listings-container grid-layout">
	<?php if(count($hired_contractors) > 0){ foreach($hired_contractors as $k => $v){  
        $logo = get_user_logo($v['user_id']);
        $full_name = $v['fname'].' '.$v['lname']; 
        /* $full_name = format_name($v['fname'], $v['lname']); */
        $flag = get_country_flag($v['country']);
        $country_name = get_country_name($v['country']);
        $rating = get_user_rating($v['user_id']);
        $profile_link = base_url('clientdetails/showdetails/'.$v['user_id']);
        ?>
	  <div class="job-listing">
      <div class="job-listing-details"> 
        <div class="job-listing-company-logo">
			<a href="<?php echo $v['profile_link']; ?>"><img src="<?php echo $v['logo_url']; ?>" class="rounded-circle" alt="..." /></a>
        </div>
        
		<div class="job-listing-description">
		  <h4><a href="<?php echo $v['profile_link']; ?>"><?php echo $v['full_name']; ?></a></h4>
		  <div class="star-rating" data-rating="<?php echo $rating; ?>"></div>
		  <p><?php echo $v['title'];?></p>		  		  
		</div>
        </div>
      <div class="job-listing-footer">
      	<ul>
        	<li><b>Review:</b> <?php echo $v['review_count'];?></li>
        	<li><i class="icon-feather-calendar"></i> <b>Hired on :</b> <?php echo ($v['hired_date'] && $v['hired_date'] != '0000-00-00') ? date('d M,Y', strtotime($v['hired_date'])) : 'Not Available';?></li>
        </ul>
      </div>  
	  </div>
	<?php } } ?>
  
</div>
  </div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  <div class="listings-container grid-layout">
  <?php if(count($invited_contractors) > 0){ foreach($invited_contractors as $k => $v){  
        $flag = get_country_flag($v['country']);
        $country_name = get_country_name($v['country']);
        $rating = get_user_rating($v['user_id']);
       
        ?>
	  <div class="job-listing">
      <div class="job-listing-details"> 
        <div class="job-listing-company-logo">
			<a href="<?php echo $v['profile_link']; ?>"><img src="<?php echo $v['logo_url']; ?>" class="rounded-circle" alt="..." /></a>
        </div>
		<div class="job-listing-description">
		  <h4><a href="<?php echo $v['profile_link']; ?>"><?php echo $v['full_name']; ?></a></h4>
		   <div class="star-rating" data-rating="<?php echo $rating; ?>"></div>
		  <p><?php echo $v['title'];?></p>
		</div>
        </div>
        <div class="job-listing-footer">
        	<ul>
            	<li><i class="icon-feather-message-square"></i> <b>Review:</b> <?php echo $v['review_count'];?></li>
                <li><i class="icon-feather-calendar"></i> <b>Invited date :</b> <?php echo date('d M,Y', strtotime($v['invitation_date']));?></li>
            </ul>
        </div>
	  </div>
	<?php } } ?>
</div>
  </div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
  <div class="listings-container grid-layout">
	<?php if(count($freelancer) > 0){ foreach($freelancer as $k => $v){  
        $logo = get_user_logo($v['user_id']);
        $full_name = $v['fname'].' '.$v['lname']; 
        /* $full_name = format_name($v['fname'], $v['lname']); */
        $flag = get_country_flag($v['country']);
        $country_name = get_country_name($v['country']);
        $rating = get_user_rating($v['user_id']);
        $profile_link = base_url('clientdetails/showdetails/'.$v['user_id']);
        ?>
	<div class="job-listing">
		<div class="job-listing-details"> 
        <div class="job-listing-company-logo">
			<a href="<?php echo $profile_link ; ?>"><img src="<?php echo $logo; ?>" class="rounded-circle" alt="..." /></a>
    	</div>
    	<div class="job-listing-description">
      	<h4><a href="<?php echo $profile_link; ?>"><?php echo $full_name; ?></a> (Review : <?php echo $v['review_count'];?>)</h4>
		  <div class="star-rating" data-rating="<?php echo $rating;?>"></div>
		  <p><?php echo $v['overview']; ?></p>		  		  
		</div>
		</div>
        <div class="job-listing-footer">
        	<ul>
            	<li><i class="icon-feather-calendar"></i> <b>Member since :</b> <?php echo date('d M, Y', strtotime($v['reg_date']));?> . <b>Completed Project:</b> <?php echo $v['completed_project'];?></li>
                <li><a href="#" data-object-id="<?php echo $v['user_id'];?>" data-object-type="FREELANCER" class="delete_fav red-text">Remove</a></li>
			</ul>
		</div>
    </div>
   <?php } } ?>
  
</div>
  </div>
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
            <td><a data-object-id="<?php echo $v['user_id'];?>" data-object-type="FREELANCER" href="#" class="delete_fav">Remove</a></td>
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
$('.delete_fav').click(function(e){
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

