<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class autoload_model extends BaseModel {

    public function __construct() {

	

        return parent::__construct();

		

    }

    

    public function getsitemetasetting($tablename='',$by='',$value='')

    {

	

	if($tablename!=''){

	$dat=array($by=>$value);

	

		$query = $this->db->select('meta_title,meta_keys,meta_desc');

		$query = $this->db->get_where( $tablename,$dat );

		foreach( $query->result() as $filed=>$val ){

			define('SITE_TITLE', $val->meta_title); 

			define('SITE_KEY', $val->meta_keys); 

			define('SITE_DESC', $val->meta_desc); 



		}

	if(count($query->result())==0){

	

		$query = $this->db->select('site_title,meta_keys,meta_desc');

		$query = $this->db->get( 'setting' );

		foreach( $query->result() as $filed=>$val ){

			define('SITE_TITLE', $val->site_title); 

			define('SITE_KEY', $val->meta_keys); 

			define('SITE_DESC', $val->meta_desc); 

	

		}

	}

	}else{

	

	

		$query = $this->db->select('site_title,meta_keys,meta_desc');

		$query = $this->db->get( 'setting' );

		foreach( $query->result() as $filed=>$val ){

			define('SITE_TITLE', $val->site_title); 

			define('SITE_KEY', $val->meta_keys); 

			define('SITE_DESC', $val->meta_desc); 



		}

	}

    }

	

	public function getFeild($select,$table,$feild,$value){

		$this->db->select($select);	

		$rs = $this->db->get_where($table,array($feild=>$value));

		 $data = '';

		 foreach ($rs->result() as $row){

		  $data = $row->$select;

		 }

		 return $data;

		

	}

	public function getalldata($attr,$table,$by,$value){

	$this->db->select($attr);	

	$rs = $this->db->get_where($table,array($by=>$value));

	 $data = '';

	 

	 foreach ($rs->result() as $key=>$row){

	  $data["'".$key."'"] = $row;

	 }

	

	 return $data;

	

	}

	public function load_css_js($load_extra){

	$js='';

	$css='';

	$loadfile='';

	

	if(count($load_extra)>0){

	

		foreach($load_extra as $key=>$val){

		

			if($key=="css_to_load"){

				foreach($val as $sr){

				

				 $loadfile.='<link href="'.CSS.$sr.'" rel="stylesheet" type="text/css" />';

					

				}

			}

			if($key=="js_to_load"){

				foreach($val as $j){

					$loadfile.='<script type="text/javascript" src="'.JS.$j.'"></script>';

				}

			}

		}

	}

	

	 return $loadfile;

	

	}

	public function getprojectcountbyid($id){

	

	 //$rs = $this->db->where_in($id, 'skills');

		$this->db->where("FIND_IN_SET('".$id."',`skills`)!=", 0);

		 $rs = $this->db->count_all_results('projects');

	//echo $this->db->last_query();

	

	 

	 return $rs;

	

	}

	public function breadcrumb($breadcrumb,$title){

		$user = $this->session->userdata('user');

		

		$b=' <section class="breadcrumb-classic">

					<h1 class="float-md-left">'.__(strtolower($title),$title).'</h1>';

					 /*if($user){

						 

					 	$b.='<i class="fa fa-ellipsis-h fa-2x mobile-menu"></i>';

					 }*/

						$b.='<ol class="breadcrumb float-md-right">								

							<li class="breadcrumb-item"><a href="'.VPATH.'dashboard">'.__('home','Home').'</a></li>';		

							foreach($breadcrumb as $name){

							if($name['path']){

							$b.="<li class='breadcrumb-item'>";

							$b.=anchor(base_url().$name['path'],__(str_replace(' ','_',strtolower($name['title'])),$name['title']),'');

							$b.="</li>";

							 }else{

							$b.='<li class="breadcrumb-item active">';

							$b.=__(strtolower($name['title']),$name['title']);

							}

							$b.="</li>";								

							}

								

						$b.='</ol>

                  <div class="clearfix"></div>				  				  

            </section>';

		return $b;

	}

	public function project_leftpanel($project_id="")

	{

		$user = $this->session->userdata('user');

		$bidder_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_id);

		$owner_id=$this->auto_model->getFeild('user_id','projects','project_id',$project_id);

		$p_type=$this->auto_model->getFeild('project_type','projects','project_id',$project_id);

		$bidder_amt=$this->auto_model->getFeild('bidder_amt','bids','','',array('project_id'=>$project_id,'bidder_id'=>$bidder_id));

		$paid_amount=$this->getPaidAmount($project_id,$bidder_id);

		if($user[0]->account_type == 'F'){

			$link = VPATH.'projectdashboard/milestone/'.$project_id;

		}else{

			$link = VPATH.'myfinance/milestone/'.$project_id;

		}

		

		if($user[0]->account_type == 'F'){

			$msg_user = $owner_id;

		}else{

			$msg_user = $bidder_id;

		}

		

		if($p_type == 'H'){

			if($user[0]->account_type == 'F'){

				$extra_link = '<li><a href="'.VPATH.'projectdashboard/freelancer/'.$project_id.'">Manual Hour</a></li>';

			}else{

				$extra_link = '<li><a href="'.VPATH.'projectdashboard/employer/'.$project_id.'">Manual Hour</a></li>';

			}

			

		}else{

			$extra_link = '<li><a href="'.$link.'">Milestones</a></li>';

			

		}

		

		if($p_type == 'H'){

			 $total_cost_new = 0;

            $client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$project_id,"bidder_id"=>$user[0]->user_id));

			$req_rows = $this->db->where(array("project_id"=>$project_id,"worker_id"=>$user[0]->user_id))->get('project_tracker_manual')->result_array();

			

			$paid = $approved = $pending = $requested = array();

			if(count($req_rows) > 0){

				foreach($req_rows as $k => $vals){

					$minute_cost_min = ($client_amt/60);

					$total_min_cost = $minute_cost_min *floatval($vals['minute']);

					$total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);

					

					if($vals['status'] == 'Y' AND $vals['payment_status'] == 'P'){

						$paid[] = $total_cost_new;

						$approved[] = $total_cost_new;

					}else if($vals['status'] == 'Y'){

						$approved[] = $total_cost_new;

					}else if($vals['status'] == 'N'){

						$pending[] = $total_cost_new;

					}

					$requested[] = $total_cost_new;

				}

			}

			$extra_info = '

				<ul class="list-group proamount">

					<li class="list-group-item">Requested Amount: <span class="badge">'.CURRENCY.' '.round(array_sum($requested), 2).'</span></li>

					<li class="list-group-item">Approved Amount: <span class="badge">'.CURRENCY.' '.round(array_sum($approved), 2).'</span></li>

					<li class="list-group-item">Paid Amount: <span class="badge">'.CURRENCY.' '.round(array_sum($paid), 2).'</span></li>

					<li class="list-group-item">Pending Amount: <span class="badge">'.CURRENCY.' '.round(array_sum($pending), 2).'</span></li>

				</ul>			

			

			';

			

		}else{

			$extra_info = '

				<ul class="list-group proamount">

					<li class="list-group-item">Project Amount : <span class="badge">'.CURRENCY.' '.$bidder_amt.'</span></li>

					<li class="list-group-item">Paid Amount : <span class="badge">'.CURRENCY.' '.$paid_amount.'</span></li>

					<li class="list-group-item">Remaining Amount : <span class="badge">'.CURRENCY.' '.($bidder_amt-$paid_amount).'</span></li>

				</ul>			

			

			';

			

		}

		

		if($p_type == 'F'){

			$msg_link = '<li><a href="'.VPATH.'message/browse/'.$project_id.'/'.$msg_user.'">Messages</a></li>';

		}else{

			$msg_link = '<li><a href="'.VPATH.'message/browse/">Messages</a></li>';

		}

			

		$b='<div class="sidebar col-md-3 col-sm-4 col-xs-12">

			<div class="widget category left_sidebar">

			<ul class="list-group">                            

			'.  $msg_link .'

			<li><a href="'.VPATH.'projectdashboard/project_users/'.$project_id.'">Project Users</a></li>

			'.$extra_link.'

			<!--<li><a href="'.VPATH.'projectdashboard/payment_history/'.$project_id.'">Payment History</a></li>-->

			</ul>

			'.$extra_info.'

			</div>

			</div>';

			return $b;	

	}

	

	

	public function leftpanel($logo,$completeness){

		

		$plan=0;$img="";

		

		if($this->session->userdata('user'))

		{

		

		

			$user=$this->session->userdata('user');

			$plan=$user[0]->membership_plan;

		    $accountType=$user[0]->account_type;

			$user_id=$user[0]->user_id;

			

			$this->load->model('dashboard/dashboard_model');

			

			$rating=$this->dashboard_model->getrating($user[0]->user_id);

			$available_hr = $this->autoload_model->getFeild('available_hr','user','user_id',$user[0]->user_id);

			if(empty($available_hr)){

				$available_hr = 'N/A';

			}

			

		}else{

			$rating=array();

		}

		//$data=array('fname','lname');

		$user_name=$this->auto_model->getFeild('fname','user','user_id',$user_id);

		$user_name.= ' '.$this->auto_model->getFeild('lname','user','user_id',$user_id);

		//print_r($user_name);

		//die();

		if($plan==1)

		{

			$img="FREE_img.png";	

		}

		elseif($plan==2)

		{

			$img="SILVER_img.png";	

		}

		elseif($plan==3)

		{

			$img="GOLD_img.png";	

		}

		elseif($plan==4)

		{

			$img="PLATINUM_img.png";	

		}

		

		$all_ratings = '';

		if($rating[0]['num']>0)

		{

			$avg_rating=$rating[0]['avg']/$rating[0]['num'];

			for($i=0;$i < $avg_rating;$i++)

			{

		

				$all_ratings .= '<i class="zmdi zmdi-star"></i>';

			

			}

			for($i=0;$i < (5-$avg_rating);$i++)

			{

		

				$all_ratings .= '<i class="zmdi zmdi-star-outline"></i> ';

		

			}

		}

		else

		{

		

			$all_ratings .= '<i class="zmdi zmdi-star-outline"></i> ';

			$all_ratings .= '<i class="zmdi zmdi-star-outline"></i> ';

			$all_ratings .= '<i class="zmdi zmdi-star-outline"></i> ';

			$all_ratings .= '<i class="zmdi zmdi-star-outline"></i> ';

			$all_ratings .= '<i class="zmdi zmdi-star-outline"></i> ';

			

		}

		if($accountType == 'F'){

			$available_hr_str = '<p>'.$available_hr.' hrs/week</p>';

		}else{

			$available_hr_str = '';

		}

		

		$acc_balance=$this->getFeild('acc_balance','user','user_id',$user[0]->user_id);

		$user_wallet_id = get_user_wallet($user[0]->user_id);

		$acc_balance=get_wallet_balance($user_wallet_id);

		

		$b='<div class="col-md-3 col-sm-4 col-xs-12">

			<script>

			  $(window).load(function(){

			  	$("#sticky_panel").sticky({ topSpacing: 75, bottomSpacing: 485});

			  });

			

			  $(document).ready(function() {  	    

				$(".left_panel").niceScroll();

			  });

			</script>

	

			<div class="left_sidebar left_panel panel" id="sticky_panel">

			   <!--<h4 class="title-sm">Profile completeness</h4>-->

			   <div class="c_details">

			   <div class="profile">

				<div class="profile_pic">

				<span><a href="'.VPATH.'dashboard/profile_professional" class=""> <img src="'.VPATH.'assets/'.$logo.'"></a></span></div>

			   </div>

			  <div class="profile-details text-center">

				<h4><a href="'.VPATH.'dashboard/profile_professional" class="">'.$user_name.'</a></h4>

				'.$available_hr_str.'							

				<h4>'.$all_ratings.'</h4>  															                   					   

			   <div class="progress profile_progress">

				  <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="<?php echo round($completeness);?>
" aria-valuemin="0" aria-valuemax="100" style="width: '.round($completeness).'%">

				   '.round($completeness).' %
                   </div>
                   </div>
                   <a href="'.VPATH.'dashboard/profile_professional" class="btn btn-site btn-sm btn-block"> '.__('dashboard_leftpanel_edit_profile','Edit Profile').'</a>
                   </div>
                   </div>
                   <div class="myfund">
  <div class="body">
                       <h4 class="title-sm">'.__('dashboard_leftpanel_my_fund','My Fund').'</h4>
                       <a href="'.VPATH.'myfinance" class="btn btn-site btn-sm">'.__('dashboard_leftpanel_add_fund','Add Fund').'</a><span style="padding:6px 0" class="pull-right">'.CURRENCY.$acc_balance.'</span> </div>
</div>
                   <div class="mytracker hidden">
  <h5 class="heading">Time Tracker</h5>
  <div class="body"> <a href="'.VPATH.'dashboard/tracker/" target="_blank" class="btn btn-site btn-sm">Download Timetracker</a> </div>
</div>
                   <ul class="list-group">
  <li class="hidden"><a href="'.VPATH.'notification/">Notification <span class="count_list" style="display:none">12</span></a></li>
  <li> ';
                       
                       /** check whether it's employee/freelancer  **/
                       
                       if($accountType=='F'){
                       
                       
                       
                       $b .='<span><a href="'.VPATH.'dashboard/myproject_professional"><i class="zmdi zmdi-assignment-check"></i> '.__('dashboard_leftpanel_project','Project').'</a></span><br>
                       ';
                       
                       }
                       
                       
                       
                       if($accountType=='E'){
                       
                       $b.='<span><a href="'.VPATH.'dashboard/myproject_client"><i class="zmdi zmdi-assignment-check"></i> '.__('dashboard_leftpanel_project','Project').'</a></span>';
                       
                       }
                       
                       $b.= '</li>
  <li><a href="'.VPATH.'myfinance/"><i class="zmdi zmdi-money"></i> '.__('dashboard_leftpanel_my_finance','My Finance').'</a></li>
  <li class="hidden"><a href="'.VPATH.'dashboard/profile_professional"><i class="zmdi zmdi-account"></i> My Profile</a><br>
                       ';
                       
                       
                       
                       /*if($accountType=='freelancer'){
                       
                       $b .='<span><a href="'.VPATH.'dashboard/profile_professional"> As Freelancer</a></span><br>
                       ';
                       
                       }
                       
                       
                       
                       if($accountType=='employee'){		
                       
                       $b .='<span><a href="'.VPATH.'dashboard/profile_client"> As Employer</a></span></li>
  ';			
  
  $b .='
  <li><a href="'.VPATH.'findtalents/myfreelancer/">My Freelancer</a></li>
  ';
  
  }*/
  
  $b .='
  <li class="hide"><a href="'.VPATH.'membership/"><i class="zmdi zmdi-money"></i> '.__('dashboard_leftpanel_membership','Membership').'</a></li>
  <li><a href="'.VPATH.'dashboard/myfeedback/"><i class="zmdi zmdi-comment"></i> '.__('dashboard_leftpanel_feedback','Feedback').'</a></li>
  
  <!--<li><a href="'.VPATH.'disputes/">'.__('dashboard_leftpanel_disputes','Disputes').'</a></li>

				  <li><a href="'.VPATH.'references/"> My References</a></li>-->
  
  <li><a href="'.VPATH.'dashboard/setting"><i class="zmdi zmdi-settings"></i> '.__('dashboard_leftpanel_settings','Settings').'</a></li>
  <li><a href="'.VPATH.'testimonial/"><i class="zmdi zmdi-comments"></i> '.__('dashboard_leftpanel_give_testimonial','Give Testimonial').'</a></li>
  <li><a href="'.VPATH.'dashboard/closeacc"><i class="zmdi zmdi-account"></i> '.__('dashboard_leftpanel_close_account','Close Account').'</a></li>
</ul>
                   </div>
                   </div>
';

		 /* $b .='
<li><a href="'.VPATH.'membership/">Membership</a></li>
<li><a href="'.VPATH.'message/">Inbox</a></li>
<li><a href="'.VPATH.'dashboard/myfeedback/">Feedback</a></li>
<li><a href="'.VPATH.'disputes/">Disputes</a></li>
<li><a href="'.VPATH.'dashboard/setting">Settings</a></li>
<li><a href="'.VPATH.'testimonial/">Give Testimonial</a></li>

<!-- <li><a href="'.VPATH.'references/">My References</a></li>-->

<li><a href="'.VPATH.'dashboard/closeacc">Close Account</a></li>
</ul>
</div>
</div>
'*/

return $b;

}

        

     public function job_leftpanel($parent){ 

        $lft="
        <div class='sidebar col-lg-3 col-md-3 col-sm-4 col-xs-12'>
  <div class='accordionMod panel-group'>";
            
            
            
            foreach($parent as $key =>$val){ 
            
            
            
            $lft.="
            <div class='accordion-item'>
      <h4 class='accordion-toggle'>".$val['cat_name']."</h4>
      <section class='accordion-inner panel-body'>
                <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>
          ";
          
          
          
          $subcat=$this->auto_model->getcategory($val['cat_id']);
          
          
          
          foreach ($subcat as $key => $sval){ 
          
          $lft.="
          <li><a href='#'>".$sval['cat_name']."</a></li>
          "; 
          
          }
          
          
          
          
          
          
          
          $lft.="
        </ul>
              </section>
    </div>
            ";            
            
            
            
            
            
            }
            
            
            
            
            
            
            
            
            
            
            
            $lft.="
            <div class='accordion-item'>
      <h4 class='accordion-toggle'>Project Type</h4>
      <section class='accordion-inner panel-body'>
                <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>
          <li><a href='#'>All</a></li>
          <li><a href='#'>Hourly</a></li>
          <li><a href='#'>Fixed</a></li>
        </ul>
              </section>
    </div>
            <div class='accordion-item'>
      <h4 class='accordion-toggle'>Budget</h4>
      <section class='accordion-inner panel-body'>
                <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>
          <li>
                    <form method='post' action=''>
              <div style='display: block;' aria-hidden='false' class='doller clearfix'> $
                        <input type='text' value='0' name='budget_min' class='mini-inp'>
                        to $
                        <input type='text' value='0' name='budget_max' class='mini-inp'>
                        <input type='hidden' value='' name='cat_id'>
                        <input type='hidden' value='' name='posted_time'>
                        <input type='hidden' value='' name='country'>
                        <input type='submit' class='ok-btn' value='Ok'>
                      </div>
            </form>
                  </li>
        </ul>
              </section>
    </div>
            <div class='accordion-item'>
      <h4 class='accordion-toggle'>Radius</h4>
      <section class='accordion-inner panel-body'>
                <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>
          <li>
                    <form method='post' action=''>
              <div style='display: block;' aria-hidden='false' class='doller clearfix'> Miles
                        <input type='text' style='width:100px' value='0' class='mini-inp' name='radius'>
                        <input type='hidden' value='' name='cat_id'>
                        <input type='hidden' value='' name='posted_time'>
                        <input type='hidden' value='' name='country'>
                        <input type='submit' class='ok-btn' value='Ok'>
                      </div>
            </form>
                  </li>
        </ul>
              </section>
    </div>
            <div class='accordion-item'>
      <h4 class='accordion-toggle'>Postal Code</h4>
      <section class='accordion-inner panel-body'>
                <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>
          <li>
                    <form method='post' action=''>
              <div style='display: block;' aria-hidden='false' class='doller clearfix'> Postal Code
                        <input type='text' style='width:73px' value='0' name='p_code' class='mini-inp' >
                        <input type='hidden' value='' name='cat_id'>
                        <input type='hidden' value='' name='posted_time'>
                        <input type='hidden' value='' name='country'>
                        <input type='submit' class='ok-btn' value='Ok'>
                      </div>
            </form>
                  </li>
        </ul>
              </section>
    </div>
            <div class='accordion-item'>
      <h4 class='accordion-toggle'>Posted within</h4>
      <section class='accordion-inner panel-body'>
                <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>
          <li><a href='#'>All</a></li>
          <li><a href='#'>Posted within 24 hours</a></li>
          <li><a href='#'>Posted within 3 days</a></li>
          <li><a href='#'>Posted within 7 days</a></li>
        </ul>
              </section>
    </div>
            <div class='accordion-item'>
      <h4 class='accordion-toggle'>Country</h4>
      <section class='accordion-inner panel-body'>
                <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>
          <li><a href='#'><strong>All</strong></a></li>
          <li><a href='#'>Canada</a></li>
          <li><a href='#'>United States</a></li>
        </ul>
              </section>
    </div>
          </div>
</div>
";

        return $lft;

     }

        

   public function getCountry(){ 

       $this->db->select("Code,Name");

	   $this->db->order_by("Name", "asc");

       $res=  $this->db->get_where("country");

       

       $data=array();

       

       foreach ($res->result() as $row){ 

           $data[]=array(

              "code" => $row->Code,

              "name" => $row->Name

           );

       }

       return $data;

   }

   

   public function getCity($ccode){ 

       $this->db->select("id,Name");

	   $this->db->order_by("Name", "asc");

       $res=  $this->db->get_where("city",array("CountryCode"=>$ccode));

       

       $data=array();

       

       foreach ($res->result() as $row){ 

           $data[]=array(            

              "name" => $row->Name,

              "id" => $row->id

           );

       }

       return $data;

   }   

   

   public function isOwner($pid){ 

       $uid=$this->getFeild("user_id", "projects", "project_id", $pid);

       $user=$this->session->userdata('user');

       

       if($user[0]->user_id==$uid){ 

           return TRUE;

       }

       else{ 

           return FALSE;

       }               

   }

   

   public function isinvitees(){ 

           return FALSE;

   }

   public function getPaidAmount($pid,$wid){ 

        $this->db->select_sum("bider_to_pay"); 

        $this->db->where("project_id",$pid);

        $this->db->where("worker_id",$wid);

		$this->db->where("release_type",'P');

        $res=$this->db->get("milestone_payment");

		

        $data=array();

        if($this->db->count_all_results()>0){ 

            foreach($res->result() as $row){ 

                $data[]=$row->bider_to_pay;

            }            

        }

        else{ 

            $data[0]=0;

        }



        return $data[0];        

                

    }     

   

	

}