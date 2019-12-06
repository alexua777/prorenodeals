<?php 	

$user1 = $this->session->userdata('user');

if(!isset($user1)){

	redirect('/login', 'refresh');

}

$admin_user_id=$user1->admin_id;

$admin_user_name=$user1->username;

$admin_name=$this->auto_model->getFeild('name', 'admin', 'admin_id', $admin_user_id);

$pic = $this->auto_model->getFeild('image', 'admin', 'admin_id', $admin_user_id);



if(!empty($pic)){

 $pic = base_url('admin_images/'.$pic);

}

?>

<body class="fixed-navbar">
<header id="header">
  <nav class="navbar navbar-expand-md navbar-dark bg-success fixed-top"> <a class="navbar-brand" href="<?=VPATH?>"><img src="<?php echo IMAGE; ?>logo.png" alt="Admin" class="img-responsive"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="navbar-wrapper">
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item active"> <a class="nav-link" href="javascript:void(0)" id="collapse-nav"><i class="la la-navicon"></i></a> </li>
            <?php /*?><li class="nav-item">

        <a class="nav-link" href="#"><i class="la la-search la-2x"></i></a>        

      </li>

      <li class="nav-item"><form class="form-inline my-2 my-lg-0">

          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" style="border:0; border-radius:0; margin-top:6px">

        </form></li><?php */?>
          </ul>
          <ul class="nav navbar-nav float-right">
            <li class="dropdown dropdown-user nav-item"> <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown" aria-expanded="false"> <span class="mr-1">Hello, <span style="font-weight:600"><?php echo !empty($admin_name) ? $admin_name : $admin_user_name; ?></span> </span> <span class="avatar avatar-online">
              <?php if(!empty($pic)){ ?>
              <img src="<?php echo $pic;?>" width="36" height="36"/>
              <?php }else{ ?>
              <i class="la la-user" style="font-size:2.3em; vertical-align:middle"></i>
              <?php } ?>
              </span> </a>
              <div class="dropdown-menu dropdown-menu-right"> <a class="dropdown-item" href="<?=SITE_URL?>" target="_blank"><i class="la la-eye _165x"></i> View Site</a> <a class="dropdown-item" hidden href="#"><i class="la la-user _165x"></i> Edit Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?=VPATH?>logout"><i class="la la-sign-out _165x"></i> Logout</a> </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>
<!-- End #header  -->

<div class="main">
