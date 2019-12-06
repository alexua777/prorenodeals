<script src="<?=JS?>mycustom.js"></script>

<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.responsive.css">

<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.bootstrap.css">

<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/jquery.dataTables.min.js"></script> 

<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.responsive.min.js"></script> 

<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.bootstrap.js"></script> 



<section id="mainpage">  

<div class="container-fluid">

<div class="row">

<?php $this->load->view('dashboard-left'); ?>
<aside class="col-lg-10 col-md-9 col-12">
<?php echo $breadcrumb;?>
<div class="spacer-20"></div>



<div>

	<div class="pull-left">

		<h4>CONTESTS</h4>

	</div>

	<div class="pull-right">

		<a href="<?php echo base_url('contest/post_contest'); ?>" class="btn btn-default">Add Contest</a>

	</div>

</div>





<div class="profile_right">

	<div class="" id="editprofile">

        <table id="example" class="table table-hover">

          <thead>

            <tr>

              <th>Contest ID</th>

              <th>Contest</th>

              <th>Budget</th>

              <th>Entries</th>

              <th>Posted</th>

              <th>Ended</th>

              <th>Status</th>

             

            </tr>

          </thead>

			<tbody>

				<?php if(count($active_contest) > 0){foreach($active_contest as $k => $v){ ?>

				<tr>

					<td><?php echo $v['contest_id']; ?></td>

					<td><a href="<?php echo base_url('contest/contest-detail/'.$v['contest_id'].'-'.seo_string($v['title'])); ?>"><?php echo $v['title']; ?></a></td>

					<td><?php echo CURRENCY. $v['budget']; ?></td>

					<td><?php echo $v['total_entries']; ?></td>

					<td><?php echo date('d M, Y', strtotime($v['posted'])); ?></td>

					<td><?php echo date('d M, Y', strtotime($v['ended'])); ?></td>

					<td>

					<?php

					switch($v['status']){

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

				</tr>

				<?php } }else{  ?>

				<tr>

					<td colspan="10">No records found</td>

				</tr>

				<?php } ?>

            </tbody>

		</table>

         <?php echo $links; ?>  

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