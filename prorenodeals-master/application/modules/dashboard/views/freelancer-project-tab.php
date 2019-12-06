<?php
$curr_controller = $this->router->fetch_class();
$curr_method = $this->router->fetch_method();
$active_fun = $curr_controller.'/'.$curr_method;
?>
<ul class="nav nav-tabs">

	<li class="nav-item"><a class="nav-link <?php echo $active_fun == 'dashboard/myproject_professional' ? 'active' : ''; ?>" href="<?php echo VPATH?>dashboard/myproject_professional">My Bid</a></li>

	<li class="nav-item"><a class="nav-link <?php echo $active_fun == 'dashboard/myproject_working' ? 'active' : ''; ?>" href="<?php echo VPATH?>dashboard/myproject_working">In Progress Projects</a></li>

	<li class="nav-item"><a class="nav-link <?php echo $active_fun == 'dashboard/myproject_completed' ? 'active' : ''; ?>" href="<?php echo VPATH?>dashboard/myproject_completed">Completed Projects</a></li>
	
	<li class="nav-item"><a class="nav-link <?php echo $active_fun == 'dashboard/myproject_cancelled' ? 'active' : ''; ?>" href="<?php echo VPATH?>dashboard/myproject_cancelled">Cancelled Project</a></li>

	<li class="nav-item" hidden><a class="nav-link <?php echo $active_fun == 'dashboard/mycontest_entry' ? 'active' : ''; ?> hide" href="<?php echo VPATH?>dashboard/mycontest_entry">My Contests</a></li>

</ul>