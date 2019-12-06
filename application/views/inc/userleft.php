<div class="wrapper">
<section>
<div class="prof_lft">
  <div class="prof_lft_inner margin-top10">
    <h2>Company Profile</h2>
    <ul>
      <li><a href="<?php echo base_url();?>user/productlist">My Product List</a></li>
      <li><a href="<?php echo base_url();?>user/addproduct">Add New Product</a></li>
      
      <!--<li><a href="#">My Company Profile</a></li>

                    <li><a href="#">My Company Profile</a></li>-->
      
    </ul>
  </div>
  <div class="prof_lft_inner margin-top10">
    <h2>User Profile</h2>
    <ul>
      <li><a href="<?php echo base_url();?>user/profile">My Profile</a></li>
      <li><a href="<?php echo base_url();?>user/editprofile/<?php echo $this->session->userdata('user_id');?>/">Edit My Profile</a></li>
      
      <!--<li><a href="#">My Company Profile</a></li>

                    <li><a href="#">My Company Profile</a></li>-->
      
    </ul>
  </div>
  <div class="prof_lft_inner margin-top10">
    <h2>Security </h2>
    <ul>
      <li><a href="#">Change Password</a></li>
      
      <!--<li><a href="#">My Company Profile</a></li>

                    <li><a href="#">My Company Profile</a></li>

                    <li><a href="#">My Company Profile</a></li>-->
      
    </ul>
  </div>
</div>
