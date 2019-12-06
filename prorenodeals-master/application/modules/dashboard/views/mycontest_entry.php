<script src="<?=JS?>mycustom.js"></script>

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

{ },

{ },

{ },

{},

{ orderable:      false,},



],

"order": [[ 4, "desc" ]]

});

} );

</script> 



<section id="mainpage">  

<div class="container-fluid">

<div class="row">
<?php $this->load->view('dashboard-left'); ?>

<aside class="col-lg-10 col-md-9 col-12">
<?php echo $breadcrumb;?>
<div class="spacer-20"></div>

<div class="profile_right">

	<ul class="nav nav-tabs">

        <li><a href="<?php echo VPATH?>dashboard/myproject_professional">My Bid</a></li>

        <li><a href="<?php echo VPATH?>dashboard/myproject_working">Awarded Projects</a></li>

        <li><a href="<?php echo VPATH?>dashboard/myproject_completed">Completed Projects</a></li>

        <li class="active"><a href="<?php echo VPATH?>dashboard/mycontest_entry">My Contests</a></li>

    </ul>  

    <div class="" id="editprofile">

        <table id="example" class="table table-hover" cellspacing="0" width="100%">

          <thead>

            <tr>

              <th>Entry ID</th>

              <th>Contest</th>

              <th>Sale Price</th>

              <th>Contest Status</th>

              <th>Entry Status</th>

              <th>View</th>

            </tr>

          </thead>

			<tbody>

				<?php if(count($active_contest) > 0){foreach($active_contest as $k => $v){ ?>

				<tr>

					<td><?php echo $v['entry_id']; ?></td>

					<td><a href="<?php echo base_url('contest/contest_detail/'.$v['contest_id'].'-'.seo_string($v['contest_title'])); ?>"><?php echo $v['contest_title']; ?></a></td>

					<td><?php echo CURRENCY. format_money($v['sale_price']); ?></td>

					<td>

					<?php

					switch($v['contest_status']){

						case 'Y' : 

						echo 'Running';

						break;

						case 'N' :

						echo 'Ended';

						break;

						case 'C':

						echo 'Completed';

						break;

					}

					?>

					</td>

					<td>

					<?php

					if($v['contest_status'] == 'C' && $v['is_awarded'] == 1){

						echo 'Awarded';

					}else if($v['contest_status'] == 'Y'){

						echo 'Running';

					}else{

						if($v['is_sealed'] == 1){

							echo 'On Hold';

						}else{

							echo 'Lost';

						}

						

					}

					?>

					</td>

					<td><a href="<?php echo base_url('contest/entries/'.$v['contest_id'].'-'.seo_string($v['contest_title']))?>">View</a></td>

				</tr>

				<?php } } ?>

            </tbody>

		</table>

           

</div>

          

<?php 



if(isset($ad_page)){ 

$type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));

if($type=='A') 

{

$code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 

}

else

{

$image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));

$url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 

}



if($type=='A'&& $code!=""){ 

?>

      <div class="addbox2">

        <?php 

echo $code;

?>

      </div>

      <?php                      

}

elseif($type=='B'&& $image!="")

{

?>

      <div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>

      <?php  

}

}



?>

      <div class="clearfix"></div>

    </div>

    

  </div>

</div>

</div>

</section>