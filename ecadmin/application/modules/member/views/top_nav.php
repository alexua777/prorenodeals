<?php
$page = $this->router->fetch_method();

?><h3><?php echo $user_details['fname'].' '.$user_details['lname']; ?></h3>

<ul class="nav nav-pills">
        <li class="nav-item" hidden> <a class="nav-link <?php echo $page == 'view_details' ? 'active' : '';?>" href="<?php echo base_url();?>member/view_details/<?php echo $user_details['user_id'];?>"> Certificate </a> </li>
        <li class="nav-item"> <a class="nav-link <?php echo $page == 'view_skill' ? 'active' : '';?>" href="<?php echo base_url();?>member/view_skill/<?php echo $user_details['user_id'];?>"> Skill </a> </li>
        <li class="nav-item" hidden> <a class="nav-link <?php echo $page == 'view_qualification' ? 'active' : '';?>" href="<?php echo base_url();?>member/view_qualification/<?php echo $user_details['user_id'];?>"> Qualification </a> </li>
        <li class="nav-item"> <a class="nav-link <?php echo $page == 'view_portfolio' ? 'active' : '';?>" href="<?php echo base_url();?>member/view_portfolio/<?php echo $user_details['user_id'];?>"> Portfolio </a> </li>
        <li class="nav-item" hidden> <a class="nav-link <?php echo $page == 'view_education' ? 'active' : '';?>" href="<?php echo base_url();?>member/view_education/<?php echo $user_details['user_id'];?>"> Education /Others </a> </li>
        <li class="nav-item"> <a class="nav-link <?php echo $page == 'view_appliedjob' ? 'active' : '';?>" href="<?php echo base_url();?>member/view_appliedjob/<?php echo $user_details['user_id'];?>"> Applied Jobs </a> </li>
        <li class="nav-item"> <a class="nav-link <?php echo $page == 'view_transition' ? 'active' : '';?>" href="<?php echo base_url();?>member/view_transition/<?php echo $user_details['user_id'];?>"> Transaction </a> </li>
        <li class="nav-item"> <a class="nav-link <?php echo $page == 'view_message' ? 'active' : '';?>" href="<?php echo base_url();?>member/view_message/<?php echo $user_details['user_id'];?>"> Message </a> </li>
        <li class="nav-item" hidden> <a class="nav-link <?php echo $page == 'view_referee' ? 'active' : '';?>" href="<?php echo base_url();?>member/view_referee/<?php echo $user_details['user_id'];?>"> Referees List </a> </li>        <li class="nav-item"> <a class="nav-link <?php echo $page == 'view_documents' ? 'active' : '';?>" href="<?php echo base_url();?>member/view_documents/<?php echo $user_details['user_id'];?>"> Documents </a> </li>				 <li class="nav-item">             <?php             $bUrl =  base_url();            $fUrl = str_replace("/ecadmin","",$bUrl);            $access_token_key = 'ORIGINATE_SOFT_FLANCE_@123--'.date('Y-m-d');            $access_token = md5($access_token_key);            ?>          <a class="nav-link" href="<?php echo $fUrl?>clientdetails/showdetails/<?php echo $user_details['user_id'];?>?access_token=<?php echo $access_token; ?>" target="_blank">View Profile</a> </li>		  
  </ul>