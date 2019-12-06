<ul class="nav nav-tabs" role="tablist">

<li class="nav-item"><a class="nav-link <?php echo $active_tab == 'overview' ? 'active' : '';?>" href="<?php echo base_url('projectdashboard_new/freelancer/overview/'.$project_id);?>">Overview</a></li>

<li class="nav-item"><a class="nav-link <?php echo $active_tab == 'milestone' ? 'active' : '';?>" href="<?php echo base_url('projectdashboard_new/freelancer/milestone/'.$project_id);?>">Payments</a></li>

<li class="nav-item"><a class="nav-link <?php echo $active_tab == 'invoices' ? 'active' : '';?>" href="<?php echo base_url('projectdashboard_new/invoices/'.$project_id);?>">Invoices</a></li>

</ul>