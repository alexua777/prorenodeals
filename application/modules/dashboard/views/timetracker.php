<section class="breadcrumb-classic">  
  <div class="container">
    <div class="row">
    <aside class="col-sm-6 col-xs-12">
		<h3>Timetracker</h3>
    </aside>
    <aside class="col-sm-6 col-xs-12">
    <ol class="breadcrumb text-right">
      <li><a href="<?php echo base_url();?>">Home</a></li>
      <li class="active">Download Timetracker</li>
    </ol>        
    </aside>            
    </div>
	</div>       
</section>
<section class="sec">
<div class="container"> 
    
  <div class="row">
    <div class="howworkarea"></div>
    <div class="col-lg-4 col-md-4 col-sm-4">
      <div class="content-box big ch-item bottom-pad-small">
        <div class="ch-info-wrap">
          <div class="ch-info">
            <div class="ch-info-front ch-img-1"><i class="fa fa-download"></i></div>
            <div class="ch-info-back"> <i class="fa fa-download"></i> </div>
          </div>
        </div>
        <div class="content-box-info">
          <h3>Download & Install Timetracker</h3>
          <p> The first step is to post a project and describe it, tell us the skills you are looking for to get this project done.
            We will then send this information to our vast network of professionals. </p>
          <?php
			if($os=="Mac")
			{
				$link = "http://jobbid.org/demo/time_tracker/timetracker-mac.zip";
			}else
			{
				$link = "http://jobbid.org/demo/time_tracker/tracker.zip";	
			}
				
		  ?>
          <a href="<?php echo $link; ?>" target="_blank" class="btn btn-site" style="margin-right: 10px;">Download Timetracker</a> </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4">
      <div class="content-box big ch-item bottom-pad-small">
        <div class="ch-info-wrap">
          <div class="ch-info">
            <div class="ch-info-front ch-img-1"><i class="fa fa-sign-in"></i></div>
            <div class="ch-info-back"> <i class="fa fa-sign-in"></i> </div>
          </div>
        </div>
        <div class="content-box-info">
          <h3>Login on your timetracker</h3>
          <p> Once the proposals are submitted you will be able to check the price and profile of each professional interested in working on your project.
            
            
            
            Feel free to ask all the questions you want and talk to them as much as needed to make sure they understand the job. </p>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4">
      <div class="content-box big ch-item">
        <div class="ch-info-wrap">
          <div class="ch-info">
            <div class="ch-info-front ch-img-1"><i class="fa fa-edit"></i></div>
            <div class="ch-info-back"> <i class="fa fa-edit"></i> </div>
          </div>
        </div>
        <div class="content-box-info">
          <h3>View screenshot/total Working hrs</h3>
          <p> Once you select proposal, you and the professional will be able to exchange messages, files and create milestones in a private and safe environment.
            
            
            
            The project will finalize once the professional delivers the work, </p>
        </div>
      </div>
    </div>
  </div>
  
  <!--Howitworks End--> 
  
</div>
</section>