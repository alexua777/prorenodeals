
<?php echo $breadcrumb; ?> 
<section>
<div class="container-fluid">
<div class="row">
<div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard-left'); ?>
</div> 
<aside class="col-md-10 col-sm-9 col-xs-12">
	<div class="spacer-20"></div>
    <div class="well text-center">
        <h4 class="text-uppercase">Looking for projects, Flance is here to help You!</h4>
        <a href="javascript:void(0)" class="btn btn-site">Browse Project</a>
    </div>

    <div class="row-0">
    	<div class="col-sm-6 col-xs-12">
    	<article class="well text-center">
    		<h3 class="text-uppercase">Earned Amount</h3>
            <h2>$ 3,000</h2>
    	</article>
        </div>
        <div class="col-sm-6 col-xs-12">
    	<article class="well text-center">
    		<h3 class="text-uppercase">Total Bids</h3>
            <h2>15</h2>
    	</article>
        </div>
    </div>
    
    <h4>Total Bidded Project</h4>
    <div class="table-responsive">
        <table class="table">
        <thead> 
        	<th>Project title</th><th>Posted on</th><th>Bid amount</th><th>Status</th>      	        	
        </thead>
        <tbody>
            <tr>
               <td>Convert PSD to HTML</td><td>18 Feb, 2018</td><td>$ 250</td><td><span class="green-text">Complete</span></td>
            </tr>             
            <tr>
               <td>Convert PSD to HTML</td><td>18 Feb, 2018</td><td>$ 250</td><td><span class="green-text">Complete</span></td>
            </tr>
            <tr>
               <td>Convert PSD to HTML</td><td>18 Feb, 2018</td><td>$ 250</td><td><span class="green-text">Complete</span></td>
            </tr>
            <tr>
               <td>Convert PSD to HTML</td><td>18 Feb, 2018</td><td>$ 250</td><td><span class="green-text">Complete</span></td>
            </tr>      
        </tbody>
        </table>
	</div>
    
    <hr />
    
    <div class="row-0">
    	<div class="col-sm-6 col-xs-12">
    	<article class="well">
        <div id="chartContainer" style="height: 180px; width: 100%;"></div>    		
    	</article>
        </div>
        <div class="col-sm-6 col-xs-12">
    	<article class="well text-center" style="min-height:212px">
    		<h3 class="text-uppercase">Posted Jobs</h3>
            <h2>15</h2>
    	</article>
        </div>
    </div>
    
     <div class="well text-center">
		<h3 class="text-uppercase">Total spended on project</h3>
		<h2>$ 3,000</h2>
    </div>
    
    <h4 class="pull-left">Recent Posted Work</h4>
    <a href="javascript:void(0)" class="btn btn-site pull-right">Post Job</a>
    <div class="clearfix"></div>
    <div class="table-responsive">
        <table class="table">
        <thead> 
        	<th>Project title</th><th>Budget</th><th>Hourly/Fixed</th><th>Posted on</th><th>Status</th>      	        	
        </thead>
        <tbody>
            <tr>
               <td>Mobile App Developer</td><td>$ 250</td><td>Fixed</td><td>18 Feb, 2018</td><td><a href="javascript:void(0)">Details</a></td>
            </tr>             
            <tr>
               <td>Mobile App Developer</td><td>$ 250</td><td>Fixed</td><td>18 Feb, 2018</td><td><a href="javascript:void(0)">Details</a></td>
            </tr>
            <tr>
               <td>Mobile App Developer</td><td>$ 250</td><td>Fixed</td><td>18 Feb, 2018</td><td><a href="javascript:void(0)">Details</a></td>
            </tr>
            <tr>
               <td>Mobile App Developer</td><td>$ 250</td><td>Fixed</td><td>18 Feb, 2018</td><td><a href="javascript:void(0)">Details</a></td>
            </tr>
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
		fontFamily: "Poppins"
	},
	data: [{
		type: "pie",
		showInLegend: true,
		//indexLabel: "{name} - {y}%",
		dataPoints: [
			{ y: 35, name: "Completed jobs", color:'#0c0'/*, exploded: true */},
			{ y: 20, name: "Open jobs", color:'#fc0' },
			{ y: 30, name: "Processing jobs", color:'#f06' },
			{ y: 15, name: "Cancelled jobs", color:'#0cf'}
		]
	}]
});
chart.render();
}
</script>
<script src="<?php echo ASSETS;?>plugins/canvasjs/canvasjs.min.js" type="text/javascript"></script>

<script>		
  
	$(".left_panel").niceScroll();

</script>










