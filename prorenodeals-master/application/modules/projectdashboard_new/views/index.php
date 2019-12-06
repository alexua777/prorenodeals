<script>

    $(window).load(function(){

      $("#sticky_panel").sticky({ topSpacing: 75 , bottomSpacing: 485});

    });

</script>

<section style="min-height:600px">

<div class="container-fluid">

<div class="row">

<aside class="col-lg-10 col-md-9 col-12">

<!-- Nav tabs -->

<ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#overview" aria-controls="home" role="tab" data-toggle="tab">Overview</a></li>

<li role="presentation"><a href="#milestones" aria-controls="profile" role="tab" data-toggle="tab">Milestones</a></li>

<li role="presentation"><a href="#faq" aria-controls="messages" role="tab" data-toggle="tab">Q & A</a></li>

</ul>



<!-- Tab panes -->

<div class="tab-content whiteBg" style="padding: 15px">

<div role="tabpanel" class="tab-pane active" id="overview">

	<div class="row">

    <article class="col-sm-5 col-12">

    	<h4>When would you like to start the project?</h4>

        <form class="form-horizontal">

        <div class="form-group">

            <div class='input-group datepicker'>

            <input type='text' class="form-control" id="datepicker_from" name="from" size="15" value="<?php echo !empty($srch['from']) ? $srch['from'] : '';?>" />

            <span class="input-group-addon">

                <span class="glyphicon glyphicon-calendar"></span>

            </span>

            </div>


        </div>

        <div class="form-group">

            	<textarea rows="4" class="form-control" placeholder="Comments"></textarea>

        </div>

        

        <button class="btn btn-site">Send Request</button>

        </form>

    </article>

    <article class="col-sm-7 col-12">

    	<h4>&nbsp;</h4>

    	<div class="alert alert-info text-left">        	

        	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>

        </div>

    </article>

    </div>

    <h4>Freelancer request</h4>

    	<div class="table-responsive">

		<table class="table">

        <tbody>

            <tr>

               <td>Venky wants to start his project on 15 Jan, 2018</td><td><a href="javascript:void(0)">Accept</a> | <a href="javascript:void(0)" class="red-text">Deny</a></td>

            </tr>    

            <tr>

               <td>Jane Robinson wants to start his project on 20 Jan, 2018</td><td><a href="javascript:void(0)">Accept</a> | <a href="javascript:void(0)" class="red-text">Deny</a></td>

            </tr>

            <tr>

               <td>Michael wants to start his project on 23 Jan, 2018</td><td><a href="javascript:void(0)">Accept</a> | <a href="javascript:void(0)" class="red-text">Deny</a></td>

            </tr>

            <tr>

               <td>Mohan wants to start his project on 30 Jan, 2018</td><td><a href="javascript:void(0)">Accept</a> | <a href="javascript:void(0)" class="red-text">Deny</a></td>

            </tr>       

        </tbody>

        </table>

        </div>

        <hr />

    <h4>Starting Schedule</h4>

    	<div class="table-responsive">

        <table class="table">

        <thead>

        	<tr>

            	<th>Freelancer</th><th>Project start date</th><th>Status</th><th>Action</th>

            </tr>

        </thead>

        <tbody>

            <tr>

               <td>Venky</td><td>18 Jan, 2018</td><td><span class="orange-text">Pending</span></td><td><a href="javascript:void(0)"><i class="zmdi zmdi-shield-check zmdi-18x"></i></a> &nbsp; <a href="javascript:void(0)"><i class="zmdi zmdi-comment-text zmdi-18x"></i></a> &nbsp; <a href="javascript:void(0)"><i class="zmdi zmdi-email-open zmdi-18x"></i></a></td>

            </tr>

            <tr>

               <td>Venky</td><td>18 Jan, 2018</td><td><span class="green-text">Active</span></td><td><a href="javascript:void(0)"><i class="zmdi zmdi-shield-check zmdi-18x"></i></a> &nbsp; <a href="javascript:void(0)"><i class="zmdi zmdi-comment-text zmdi-18x"></i></a> &nbsp; <a href="javascript:void(0)"><i class="zmdi zmdi-email-open zmdi-18x"></i></a></td>

            </tr>

            <tr>

               <td>Venky</td><td>18 Jan, 2018</td><td><span class="red-text">Expire</span></td><td><a href="javascript:void(0)"><i class="zmdi zmdi-shield-check zmdi-18x"></i></a> &nbsp; <a href="javascript:void(0)"><i class="zmdi zmdi-comment-text zmdi-18x"></i></a> &nbsp; <a href="javascript:void(0)"><i class="zmdi zmdi-email-open zmdi-18x"></i></a></td>

            </tr>

            <tr>

               <td>Venky</td><td>18 Jan, 2018</td><td><span class="orange-text">Paused</span></td><td><a href="javascript:void(0)"><i class="zmdi zmdi-shield-check zmdi-18x"></i></a> &nbsp; <a href="javascript:void(0)"><i class="zmdi zmdi-comment-text zmdi-18x"></i></a> &nbsp; <a href="javascript:void(0)"><i class="zmdi zmdi-email-open zmdi-18x"></i></a></td>

            </tr>

        </tbody>

        </table>

        </div>

        <div class="alert alert-info">        	

        	<p>The project will be started on: 12 Jan, 2018</p>            

        </div>

        <div class="alert alert-warning">        	

        	<p>Project is paused form now, because "Employer" has not desposited the working amount yet.</p>            

        </div>

        

        <h4 class="pull-left">Work Record</h4> <a href="javascript:void(0)" class="btn btn-site pull-right">Request Manual Hour</a>

        <div class="clearfix"></div>

        <div class="table-responsive">

        <table class="table">

        <thead>        	

        </thead>

        <tbody>

            <tr>

               <td>05 Feb, 2018 | 08:30 AM</td><td>Andrew V. Stewart</td><td>Duration</td><td>Hourly Rate</td><td>Cost</td><td><a href="javascript:void(0)"><i class="zmdi zmdi-eye"></i></a></td><td><span class="green-text">Active</span></td>

            </tr>

            <tr>

               <td>05 Feb, 2018 | 08:30 AM</td><td>Andrew V. Stewart</td><td>Duration</td><td>Hourly Rate</td><td>Cost</td><td><a href="javascript:void(0)"><i class="zmdi zmdi-eye"></i></a></td><td><span class="red-text">Expire</span></td>

            </tr>

            <tr>

               <td>05 Feb, 2018 | 08:30 AM</td><td>Andrew V. Stewart</td><td>Duration</td><td>Hourly Rate</td><td>Cost</td><td><a href="javascript:void(0)"><i class="zmdi zmdi-eye"></i></a></td><td><span class="orange-text">Paused</span></td>

            </tr>            

        </tbody>

        </table>

        </div>

        <h4>Work Record</h4> 

        <div class="clearfix"></div>

        <div class="table-responsive">

        <table class="table">

        <thead>        	

        </thead>

        <tbody>

            <tr>

               <td>05 Feb, 2018 | 08:30 AM</td><td>Andrew V. Stewart</td><td>Duration</td><td>Hourly Rate</td><td>Cost</td><td><a href="javascript:void(0)"><i class="zmdi zmdi-eye"></i></a></td><td><a href="javascript:void(0)" class="btn btn-xs btn-site">Release</a> &nbsp; <a href="javascript:void(0)" class="btn btn-xs btn-danger">Edit Hours</a></td>

            </tr> 

            <tr>

               <td>05 Feb, 2018 | 08:30 AM</td><td>Andrew V. Stewart</td><td>Duration</td><td>Hourly Rate</td><td>Cost</td><td><a href="javascript:void(0)"><i class="zmdi zmdi-eye"></i></a></td><td><a href="javascript:void(0)" class="btn btn-xs btn-site">Release</a> &nbsp; <a href="javascript:void(0)" class="btn btn-xs btn-danger">Edit Hours</a></td>

            </tr>

            <tr>

               <td>05 Feb, 2018 | 08:30 AM</td><td>Andrew V. Stewart</td><td>Duration</td><td>Hourly Rate</td><td>Cost</td><td><a href="javascript:void(0)"><i class="zmdi zmdi-eye"></i></a></td><td><a href="javascript:void(0)" class="btn btn-xs btn-site">Release</a> &nbsp; <a href="javascript:void(0)" class="btn btn-xs btn-danger">Edit Hours</a></td>

            </tr>           

        </tbody>

        </table>

        </div>

        <div class="table-responsive">

        <table class="table">

        <thead> 

        	<tr>

            	<th>Start time</th><th>End time</th><th>Duration</th><th>Hourly rate</th><th>Ammount</th><th>Status</th>

            </tr>       	

        </thead>

        <tbody>

            <tr>

               <td>20 Jan, 2018</td><td>19 Feb, 2018</td><td>500 hrs</td><td>$50/hrs</td><td>$6000</td><td>Active</td>

            </tr> 

            <tr>

               <td>20 Jan, 2018</td><td>19 Feb, 2018</td><td>500 hrs</td><td>$50/hrs</td><td>$6000</td><td>Active</td>

            </tr>

            <tr>

               <td>20 Jan, 2018</td><td>19 Feb, 2018</td><td>500 hrs</td><td>$50/hrs</td><td>$6000</td><td>Active</td>

            </tr>

            <tr>

               <td>20 Jan, 2018</td><td>19 Feb, 2018</td><td>500 hrs</td><td>$50/hrs</td><td>$6000</td><td>Active</td>

            </tr>    

        </tbody>

        <tfoot>

        	<tr>

            	<th colspan="2">Total</th><th>2000 hrs</th><th>$200</th><th>$32,000</th><th><a href="javascript:void(0)" class="btn btn-sm btn-site">Request</a></th>

            </tr>

        </tfoot>

        </table>

        </div>

        

</div>

<div role="tabpanel" class="tab-pane" id="milestones">



</div>

<div role="tabpanel" class="tab-pane" id="faq">

</div>

</div>

</aside>



<aside class="col-md-2 col-sm-3 col-12">

<div class="right_panel panel" id="sticky_panel">

<div class="panel-body">

<div class="profile">

  <div class="profile_pic">

  	<span><a href="#"><img src="<?php echo IMAGE;?>user.png" class="media-object"></a></span>

  </div>

<div class="profile-details text-center">

    <h4><a href="#">Asim Patra</a></h4>

    <h4>

    <i class="zmdi zmdi-star"></i>

    <i class="zmdi zmdi-star"></i>

    <i class="zmdi zmdi-star"></i>

    <i class="zmdi zmdi-star-outline"></i>

    <i class="zmdi zmdi-star-outline"></i>

    </h4>

    <p><img src="<?php echo ASSETS;?>images/cuntryflag/IN.png">

    <span>Gaya</span> , India</p>

    

    <p><i class="zmdi zmdi-case"></i> 15 Jobs Posted</p>

     

    <p><i class="zmdi zmdi-money-box"></i> $300.00 Total Spent</p>

</div>

</div>

<h4 class="f16">I need a PHP Developer for my project</h4>

<table class="table">

<tbody>

    <tr>

        <th>Posted on: </th><td>10 Jan, 2018</td>

    </tr>

    <tr>

        <th>Budget: </th><td>$100 - $150</td>

    </tr>

    <tr>

        <th>Status: </th><td>Active</td>

    </tr>

</tbody>

</table>



</div>

</div>

</aside>

</div>

</div>

</section>

