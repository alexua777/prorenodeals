<?php echo $breadcrumb;?>      

<script src="<?=JS?>mycustom.js"></script>
<section class="sec-60">
<div class="container">
<div class="row">
<?php echo $leftpanel;?> 
<!-- Sidebar End -->
<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">

<ul class="tab">
    <li><a class="selected" href="<?php echo VPATH?>disputes/">Disputes</a></li>
    <li><a href="<?php echo VPATH?>disputes/closed">Closed Disputes</a></li>
</ul>

<div class="editprofile" id="editprofile">
<div class="table-responsive">
<table class="table table-dashboard">
              <thead>
                <tr>
                  <th>Dispute ID</th>
                  <th>Project Name</th>
                  <th>Other Party</th>
                  <th>Disputed Amount</th>
                  <th>Status</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php 
  if(count($disput_list)>0){ 
      foreach($disput_list as $row){ 
          $milestone_detales=$this->disputes_model->getMilestoneDetails($row['milestone_id']);
       // print_r($milestone_detales);
          
?>
                <tr>
                  <td><a href="<?php echo VPATH;?>disputes/details/<?php echo $row['id'];?>">#<?php echo $row['id'];?> </a></td>
                  <td>
                      <?php
              echo $this->auto_model->getFeild("title","projects","project_id",$milestone_detales['project_id']);             
            ?>
                  </td>
                  <td>
                      <?php
          if($user_id==$row['employer_id']){ 
            $fname= $this->auto_model->getFeild("fname","user","user_id",$row['worker_id']);                 
            $lname= $this->auto_model->getFeild("lname","user","user_id",$row['worker_id']);                                 
            echo $fname." ".$lname;
          }
          else if($user_id==$row['worker_id']){ 
            $fname= $this->auto_model->getFeild("fname","user","user_id",$row['employer_id']);                 
            $lname= $this->auto_model->getFeild("lname","user","user_id",$row['employer_id']);                                 
            echo $fname." ".$lname;
          }              
        ?>
                    </td>
                  <td><?php echo CURRENCY;?>
                      <?php
              echo $row['disput_amt'];
            ?>
                  </td>
                  <td>
                      <?php 
               if($row['status']=="N"){ 
                  echo "Not Solved"; 
               }
               else{ 
                  echo "Solved"; 
               }
              
            ?>
                  </td>
                  <td>
                      <?php               
                  echo date("d M,Y",  strtotime($row['add_date']));              
            ?>
                </td>
                </tr>
                <?php    
      }
  }
  else{ 
?>
                <tr>
                  <td colspan="6"><p class="text-center">No Record Found</p></td>
                </tr>
                <?php    
  }

?>
              </tbody>
            </table> 
</div>
</div>
<div class="clearfix"></div>
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
        <div class="addbox2">
        <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
        </div>
        <?php  
 }
  }

?>
<div class="clearfix"></div>
                     </div>
                     <!-- Left Section End -->
                  </div>
               </div>
</section>      
<script>
function accept_offer(project_id)
{
    
        var pid=project_id;
		//alert(pid); die();
		var dataString = 'userid='+<?php echo $user_id?>+'&projectid='+pid;
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/acceptoffer",
			 success:function(return_data)
			 {
				$('#editprofile').html();
				$('#editprofile').html(return_data);
			 }
		});
}
function decline_offer(project_id)
{
    
        var pid=project_id;
		//alert(pid); die();
		var dataString = 'userid='+<?php echo $user_id?>+'&projectid='+pid;
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/declineoffer",
			 success:function(return_data)
			 {
				$('#editprofile').html();
				$('#editprofile').html(return_data);
			 }
		});
}
</script>