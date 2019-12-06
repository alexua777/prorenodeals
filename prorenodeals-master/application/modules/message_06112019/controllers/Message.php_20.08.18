<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Message extends MX_Controller {

/**
* Description: this used for check the user is exsts or not if exists then it redirect to this site
* Paremete: username and password 
*/
public function __construct() {
$this->load->model('message_model');
$idiom=$this->session->userdata('lang');
$this->lang->load('message',$idiom);
$this->lang->load('dashboard',$idiom);
$this->load->helper('project');
parent::__construct();
}

public function send_msg(){
	$resp=array();
	if($this->input->post()){
		$post = filter_data($this->input->post());
		//echo '<pre>'; 
		//print_r($post); die();
		$image=""; 
		$config['upload_path'] ='assets/question_file/';
		$config['allowed_types'] = 'bmp|gif|jpg|jpeg|png|pdf|txt|docx|xls|doc|zip|xl|xlsx';
		$this->load->library('upload', $config);
		
		$uploaded = $this->upload->do_upload();
		$upload_data = $this->upload->data();
		//print_r($upload_data); die();
		$fname = $upload_data['file_name'];                     
		 
		            

		$post_data["message"]=  $this->input->post("message");
		$post_data["attachment"]=  $fname;
		$post_data["project_id"]=  $this->input->post("project_id");
		if(!empty($post_data["project_id"])){
			$p_status = $this->auto_model->getFeild('status' , 'projects' , 'project_id' , $post_data["project_id"]);
			if($p_status == 'O' || $p_status == 'F'){
				$post_data["interview"] = 'Y';
			}
		}
		$post_data["recipient_id"]=  $this->input->post("recipient_id");
		$post_data["sender_id"]=  $this->input->post("sender_id");
		$post_data["add_date"]=  date('Y-m-d H:i:s');

		$insert=  $this->message_model->insertMessage($post_data); 
		if($insert){
			$dir = "user_message/";
			if(!is_dir($dir)){
				mkdir($dir);
			}
			if($post_data["recipient_id"] != 'room'){
				$count = file_get_contents($dir."user_".$post_data["recipient_id"].".newmsg");
				if($count > 0){
					$count += 1;
				}else{
					$count = 1;
				}
				file_put_contents($dir."user_".$post_data["recipient_id"].".newmsg" , $count);
			}
		}
		//print_r($insert); die();
		if($insert){
			$from=ADMIN_EMAIL;
			
			$fname=$this->auto_model->getFeild('fname','user','user_id',$this->input->post("recipient_id"));
			$lname=$this->auto_model->getFeild('lname','user','user_id',$this->input->post("recipient_id"));
			$to=$this->auto_model->getFeild('email','user','user_id',$this->input->post("recipient_id"));
			$template='pm_alert';
			
			$data_parse=array('name'=>$fname." ".$lname
								);
			/* $this->auto_model->send_email($from,$to,$template,$data_parse); */
			if($post_data["recipient_id"] == 'room'){
				$lst_msg = $this->message_model->getMsgById($insert , 'room');
			}else{
				$lst_msg = $this->message_model->getMsgById($insert);
			}
			/*$sender_logo=$this->auto_model->getFeild('logo','user','user_id',$post_data["sender_id"]);   
			if($sender_logo && file_exists('./assets/uploaded/cropped_'.$sender_logo)){
				$sender_logo='cropped_'.$sender_logo;
			}
			$logo=  ($sender_logo)? 'uploaded/'.$sender_logo: 'images/user.png';
			$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$post_data["sender_id"]);     
			$status=((time()-60) > $last_seen)?false:true;*/
			if($lst_msg){
				$d = ($post_data["recipient_id"] == 'room') ? $lst_msg['send_date'] : $lst_msg['add_date'];
                
                $resp['status']='OK';
                $resp['message']=$lst_msg['message'];
                $resp['attach']=$lst_msg['attachment'];
                $resp['date']=ucwords(date('d M,Y H:i:s',strtotime($d)));
                if($post_data["recipient_id"] != 'room') {
                $resp['add_fav']=$lst_msg['id'];
                }else{
				$resp['add_fav']=0;
				}
				/*
                ?>
				<div class="conversation_loop me">						
						<div class="media-body">
						<div class="info-conversation">
						<!--<div class="arrow"></div>-->												
												
						<div class="messge_body" id="txt_msg"><p><?php echo $lst_msg['message'];?>
						</p>

						<a href="<?php echo VPATH;?>/assets/question_file/<?php echo $lst_msg['attachment'];?>" target="_blank"><?php if(!empty($lst_msg['attachment'])){ echo $lst_msg['attachment']; }?></a>

						</p> 
						</div>
						</div>
						<p class="chat_date">Sent</p>
						<p class="chat_date"><?php echo ucwords(date('d M,Y H:i:s',strtotime($d)));?></p>
						</div>

						<div class="media-right media-middle">
						
						
                        <?php if($post_data["recipient_id"] != 'room') { ?>
						<i class="fa fa-star add_fav" style="cursor:pointer" data-msg-id="<?php echo $lst_msg['id'];?>"></i>
						<?php } ?>
						</div>
					</div>
			<?php
			*/
			}
			}
			else{
				$resp['status']='FAIL';
				//echo 'Fail to send message';
			}
		
		}
	ob_start();
	ob_clean();
	echo json_encode($resp);
}


public function unread_msg(){
	$user=$this->session->userdata('user');
	$user_id = $user[0]->user_id;
	$project_id = get('project_id');
	$sender_id = get('user_id');
	$sendID = $sender_id;
	$unseen_msg = $this->db->where(array('sender_id' => $sender_id, 'recipient_id' => $user_id, 'project_id' => $project_id, 'read_status' => 'N'))->get('message')->result_array();
	if(count($unseen_msg) > 0){
		$this->db->where(array('project_id' => $project_id, 'recipient_id' => $user_id))->update('message' ,array('read_status' => 'Y'));
		foreach($unseen_msg as $key => $val){
			$sender_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$sendID));
			$sender_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$sendID));    
			$sender_logo=$this->auto_model->getFeild('logo','user','user_id',$val['sender_id']);

			if($sender_logo && file_exists('assets/uploaded/cropped_'.$sender_logo)){
				$sender_logo = 'cropped_'.$sender_logo;
			}

			$logo=($sender_logo)?'uploaded/'.$sender_logo:'images/user.png';

			$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$val['sender_id']);     
			$status=((time()-60) > $last_seen)?false:true;
			$reciever_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$user_id));
			$reciever_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$user_id));
			?>
			
			<div class="conversation_loop <?php echo $val['sender_id'] == $user_id ? 'me' : 'other';?>">

				<div class="posted_by_name">
				<?php if($val['sender_id']!=$user_id) {?>
				<div class="media-left">
				<figure class="profile-imgEc pull-left">
				<img src="<?php echo ASSETS.$logo?>" alt="">
				<?php if($status){ ?>
				<div class="online-sign"></div>
				<?php } else{ ?>
				<div class="online-sign" style="background:#ddd"></div>
				<?php } ?>
				</figure>
				</div>
				<?php } ?>
				<div class="media-body">
				<div class="info-conversation">


				<div class="messge_body" id="txt_msg"><p><?php echo $val['message'];?>

				<?php if(isset($val['attachment'])){ ?>

				<a href="<?php echo VPATH;?>assets/question_file/<?php echo $val['attachment']?>" target="_blank"><?php echo $val['attachment'];?></a>

				<?php } ?>
				</p> 
				</div></div>
				<?php if($val['sender_id']==$user_id){ ?><p class="chat_date"><?php echo $val['read_status'] == 'Y' ? 'Seen' : 'Sent'; ?></p><?php } ?>
				<p class="chat_date"><?php echo ucwords(date('d M,Y H:i:s',strtotime($val['add_date'])));?></p>
				<span class="starred">
				<?php
				if(!in_array($val['id'] , $fav_msg)){
				?>
				<i class="fa fa-star add_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']?>"></i>
				<?php
				}else{
				?>
				<i class="fa fa-star remove_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']?>"></i>
				<?php	
				}
				?>
                </span>
				</div>

				</div>
			</div>
<?php
		}
	}else{
		echo 0;
	}
	
}


public function get_fav_msg(){
	$user=$this->session->userdata('user');
	$user_id = $user[0]->user_id;
	$fav_msg = $this->message_model->getFavMsg($user_id);
	//echo '<pre>'; print_r($fav_msg);
	if(count($fav_msg) > 0){
?>
<div class="">
<?php foreach($fav_msg as $k => $v){ 
$logo=$logo_file=$this->auto_model->getFeild('logo','user','user_id',$v['sender_id']);

if($logo==''){
	$logo="images/user.png";
}else{
	$logo="uploaded/".$logo;
	if(file_exists('./assets/uploaded/cropped_'.$logo_file)){
		$logo="uploaded/cropped_".$logo_file;
	}
}
?>

<div class="conversation_loop">
<?php if($val['sender_id']!=$user_id) {?>
<div class="media-left">
<figure class="profile-imgEc">
<img src="<?=VPATH?>assets/<?=$logo?>" alt="">

</figure>
</div>
<?php } ?>
<div class="media-body" style="width:100%;">
<div class="">

<?php
$sender_fname=$this->auto_model->getFeild('fname','user','user_id',$v['sender_id']);
$sender_lname=$this->auto_model->getFeild('lname','user','user_id',$v['sender_id']);   
$sid = $v['sender_id'];
if($sid == $user_id){
	$sid = $v['recipient_id'];
}
?>
<!--<em><a target="_blank" href="<?php // echo VPATH."clientdetails/showdetails/".$v['sender_id'] ?>"><?php // if($v['sender_id']==$user_id){echo "Me";}else{echo ucwords($sender_fname)." ".ucwords($sender_lname);}?></a></em>-->
<div class="messge_body" id="txt_msg">
<a href="<?php echo base_url("message/browse/".$v['project_id'].'/'.$sid);?>">
<p><b><?php echo $sender_fname.' '.$sender_lname; ?></b></p>
<p><?php echo $v['message'];?></p></a>
<a href="<?php echo VPATH;?>/assets/question_file/<?php echo $v['attachment'];?>" target="_blank"><?php if(!empty($v['attachment'])){ echo $v['attachment']; }?></a>
</p> 
</div>
</div>
</div>

<div class="media-right" style="min-width:132px;">
<p class="chat_date text-center"><?php echo ucwords(date('d M,Y H:i:s',strtotime($v['add_date'])));?></p>
	<i class="fa fa-star remove_fav" style="cursor:pointer" data-msg-id="<?php echo $v['id'];?>"></i>
</div>
</div>
<?php } ?>
</div>
<?php
	
	}else{
		echo '<p style="color:red;">No favorite message ..</p>';
	}
}

public function browse($project_id='', $other_user='') {
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
	
		
		$data['rooms']= $this->message_model->getallRooms($data['user_id']);
		$data['allusers']= $this->message_model->getallUsers($data['user_id']);
		
		if(!$project_id && !$other_user){
			$data['load_first'] = true;
		}else{
			$data['load_first'] = false;
		}
		$data['project_user'] = $other_user;
		$data['project_id'] = $project_id;
		if(!empty($project_id) && !empty($other_user)){
			
			$data['messages'] = $this->message_model->getProjectMessage($project_id, $other_user);
			
			$data['project_info'] = get_row(array('select' => 'project_id,title,user_id', 'from' => 'projects', 'where' => array('project_id' => $project_id)));
			$data['user_info'] = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $other_user)));
			
		}else{
			$data['messages'] =  array();
			$data['project_info'] = array();
			$data['user_info'] = array();
		}
		
		$data['all_messages'] = $this->message_model->getMessage($data['user_id'], 10, 0);
		//get_print($data['all_messages']);
		
		//get_print($data);
		$data['per_page'] = 10;
		$breadcrumb=array(
		array(
				'title'=>'Message','path'=>''
		)
		);

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Message');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
		$logo="images/user.png";
		}
		else{
		$logo="uploaded/".$logo;
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='membership';

		$head['ad_page']='inbox';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		//print_r($detail); 
		$this->layout->set_assest($head);
		

		$data['fav_msg'] = array();
		$msg = $this->auto_model->get_results('serv_fav_msg' , array('user' => $data['user_id']) , 'msg_id');
		if(count($msg) > 0){
			foreach($msg as $k => $v){
				$data['fav_msg'][] = $v['msg_id'];
			}
		}
		$data['message']=$this->message_model->getMessage($user[0]->user_id,$config['per_page'], $start);	
		//print_r($data['message']);	
		//$data['interview_message']=$this->message_model->getInterviewMessage($user[0]->user_id,$config['per_page'], $start);		
		if(count($detail)>0){
			$data['messageone']=$this->message_model->getAllMessageRight($project_id,$sender_id,$user[0]->user_id);
			$data['sender_id']=$sender_id;
			$data['project_id']=$project_id;
		}
		
		$this->autoload_model->getsitemetasetting("meta","pagename","Message");

		$this->layout->view('message',$lay,$data,'normal');

	}        
}


public function get_left_msg($type='Y'){
	$counter = 0;
	$user=$this->session->userdata('user');
	$user_id=$user[0]->user_id;
	$message = $this->message_model->getMessage($user_id,10, 0 , trim($type));
	//echo '<pre>'; print_r($this->db->last_query()); die();
	if(count($message) > 0){
		foreach($message as $k => $v){
			if($v['project_id'] == ''){
				continue;
			}
			$project_name=$this->auto_model->getFeild('title','projects','project_id',$v['project_id']);
			
			if(empty($project_name)){
				$project_name = 'Project Deleted';
			}
			
			if(strlen($project_name) > 25){
				$project_name = substr($project_name, 0, 25).'...';
			}
			//Sender
			if($v['sender_id'] != $user_id){
				$sender_fname=$this->auto_model->getFeild('fname','user','user_id',$v['sender_id']);
				$sender_lname=$this->auto_model->getFeild('lname','user','user_id',$v['sender_id']); 
			}else{
				$sender_fname=$this->auto_model->getFeild('fname','user','user_id',$v['recipient_id']);
				$sender_lname=$this->auto_model->getFeild('lname','user','user_id',$v['recipient_id']); 
			}
			
			$recipient_fname=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);
			$recipient_lname=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);
			
			$val['sender_user'] = '';
			if($v['sender_id'] != $user_id){
				$v['sender_user']  = $v['sender_id'];
			}else{
				$v['sender_user']  = $v['recipient_id'];
			}
			
			if(($v['sender_user'] > 0 == false)){
				continue;
			}
			
			$counter++;

			$msg = (strlen($v['message']) > 10) ? substr($v['message'] , 0 , 10)."..." : $v['message']; 
			$v['unread_msg'] = ($v['unread_msg'] > 0) ? $v['unread_msg'] : '';
			//rampage(\''.$v['project_id'].'\',\''.$v['sender_id'].'\');
			echo '<div class="messagtext2" id="msg_project_'.$v['project_id'].'">';
			if($v['unread_msg']>0){
			echo '<div class="msg-count"><span class="notification" id="unread">'.$v['unread_msg'].'</span></div>';
			}
			echo '<div class="setting-circle dropdown hidden"><i class="fa fa-ellipsis-h"></i></div><a id="anchor" href="javascript:void(0);" onclick="rampage(\''.$v['project_id'].'\',\''.$v['sender_user'].'\' , $(this));"><i class="far fa-comment"></i> <span class="menu active">'.$sender_fname.' , '.$recipient_fname .'<span class="pull-right hide" id="unread" style="color:red;">'.$v['unread_msg'].'</span></span><p>'.$project_name.'</p></a><p style="font-weight:normal;padding:5px 0px; display:none;">'.$msg.'</p></div>';
		}
		
		if($counter == 0){
			echo '<div class="info grey">No message found</div>';
		}
		
	}else{
		echo '<div class="info grey">No message found</div>';
	}
}

public function load_more_lft($limit=10){
	$user=$this->session->userdata('user');
	$user_id=$user[0]->user_id;
	$message = $this->message_model->getMessage($user_id,10, $limit);
	//echo '<pre>'; print_r($this->db->last_query()); die();
	if(count($message) > 0){
		foreach($message as $k => $v){
			if($v['project_id'] == ''){
				continue;
			}
			$project_name=$this->auto_model->getFeild('title','projects','project_id',$v['project_id']);
			
			if(empty($project_name)){
				$project_name = 'Project Deleted';
			}
			//Sender
			if($v['sender_id'] != $user_id){
				$sender_fname=$this->auto_model->getFeild('fname','user','user_id',$v['sender_id']);
				$sender_lname=$this->auto_model->getFeild('lname','user','user_id',$v['sender_id']); 
			}else{
				$sender_fname=$this->auto_model->getFeild('fname','user','user_id',$v['recipient_id']);
				$sender_lname=$this->auto_model->getFeild('lname','user','user_id',$v['recipient_id']); 
			}
			
			$recipient_fname=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);
			$recipient_lname=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);
			
			$val['sender_user'] = '';
			if($v['sender_id'] != $user_id){
				$v['sender_user']  = $v['sender_id'];
			}else{
				$v['sender_user']  = $v['recipient_id'];
			}
			
			if(($v['sender_user'] > 0 == false)){
				continue;
			}
			
			$msg = (strlen($v['message']) > 10) ? substr($v['message'] , 0 , 10)."..." : $v['message']; 
			$v['unread_msg'] = ($v['unread_msg'] > 0) ? $v['unread_msg'] : '';
			//rampage(\''.$v['project_id'].'\',\''.$v['sender_id'].'\');
			echo '<div class="messagtext2" id="msg_project_'.$v['project_id'].'">';
			if($v['unread_msg']>0){
				echo '<div class="msg-count"><span class="notification" id="unread">'.$v['unread_msg'].'</span></div>';
			}
			
			echo '<div class="setting-circle dropdown hidden"><i class="fa fa-ellipsis-h"></i></div><a id="anchor" href="javascript:void(0);" onclick="rampage(\''.$v['project_id'].'\',\''.$v['sender_user'].'\' , $(this));"><i class="far fa-comment"></i> <span class="menu active">'.$sender_fname.' , '.$recipient_fname .'<span class="pull-right hide" id="unread" style="color:red;">'.$v['unread_msg'].'</span></span><p>'.$project_name.'</p></a><p style="font-weight:normal;padding:5px 0px; display:none;">'.$msg.'</p></div>';
				
		}
	}else{
		echo 0;
	}
}

public function add_fav($msg_id=''){
	
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		$msg = $this->db->where(array('user' => $user_id , 'msg_id' => $msg_id))->count_all_results('serv_fav_msg');
		if($msg == 0){
			// add to favoriate
			$ins = $this->db->insert('serv_fav_msg' , array('user' => $user_id , 'msg_id' => $msg_id));
			if($ins){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 1;
		}
	}
}

public function remove_fav($msg_id=''){
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		$del = $this->db->where(array('user' => $user_id , 'msg_id' => $msg_id))->delete('serv_fav_msg');
		if($del){
			echo 1;
		}else{
			echo 0;
		}
	}
} 

/*public function details($sender_id='',$project_id='',$limit_from='') {
if(!$this->session->userdata('user')){
redirect(VPATH."login/");
}
else{

$user=$this->session->userdata('user');

$data['user_id']=$user[0]->user_id;
//$data['user_membership']=$user[0]->membership_plan;

$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);

$data['ldate']=$user[0]->ldate;
$data['sender_id']=$sender_id;
$data['project_id']=$project_id;

$breadcrumb=array(
array(
		'title'=>'Notifications','path'=>''
)
);

$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Notification');

///////////////////////////Leftpanel Section start//////////////////

$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

if($logo==''){
$logo="images/user.png";
}
else{
$logo="uploaded/".$logo;
}
$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

///////////////////////////Leftpanel Section end//////////////////

$head['current_page']='membership';

$head['ad_page']='inbox';

$load_extra=array();

$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

$this->layout->set_assest($head);
$this->load->library('pagination');
$config['base_url'] = VPATH.'message/details/'.$sender_id.'/'.$project_id.'/';
$config['total_rows'] =$this->message_model->countAllMessage($project_id,$sender_id,$user[0]->user_id);
$config['per_page'] = 4; 
$config["uri_segment"] = 5;
$config['use_page_numbers'] = TRUE;   
$this->pagination->initialize($config); 
$page = ($limit_from) ? $limit_from : 0;
$per_page = $config["per_page"];
$start = 0;
if ($page > 0) {
for ($i = 1; $i < $page; $i++) {
	$start = $start + $per_page;
}
}
$data['page_number']=$page;
$data['message']=$this->message_model->getAllMessage($project_id,$sender_id,$user[0]->user_id,$config['per_page'], $start); $data['messageone']=$this->message_model->getAllMessageRight($project_id,$sender_id,$user[0]->user_id);  
$data['links']=$this->pagination->create_links();

$this->autoload_model->getsitemetasetting("meta","pagename","Message");

$lay['client_testimonial']="inc/footerclient_logo";
if($this->input->post("submit")){
$page = $this->input->post("page_id");
$data['page_number']=$page;
$this->form_validation->set_rules('message', 'Message', 'required');

if($this->form_validation->run()==FALSE){ 

 redirect(base_url()."message/index/".$page."/".$sender_id."/".$project_id);                     
}
else{
 $image="";   

 
$config['upload_path'] ='assets/question_file/';
$config['allowed_types'] = 'bmp|gif|jpg|jpeg|png|pdf|txt|docx|xls|doc|zip|xl|xlsx';


$this->load->library('upload', $config);
 
$uploaded = $this->upload->do_upload();
$upload_data = $this->upload->data();
//print_r($upload_data); die();
$fname = $upload_data['file_name'];                     
 
               

$post_data["message"]=  $this->input->post("message");
$post_data["attachment"]=  $fname;
$post_data["project_id"]=  $this->input->post("project_id");
$post_data["recipient_id"]=  $this->input->post("recipient_id");
$post_data["sender_id"]=  $this->input->post("sender_id");
$post_data["add_date"]=  date('Y-m-d H:i:s');

$insert=  $this->message_model->insertMessage($post_data);
$data['page_number']=$page;
if($insert){
	$from=ADMIN_EMAIL;
	
	$fname=$this->auto_model->getFeild('fname','user','user_id',$this->input->post("recipient_id"));
	$lname=$this->auto_model->getFeild('lname','user','user_id',$this->input->post("recipient_id"));
	$to=$this->auto_model->getFeild('email','user','user_id',$this->input->post("recipient_id"));
	$template='pm_alert';
	
	$data_parse=array('name'=>$fname." ".$lname
						);
	$this->auto_model->send_email($from,$to,$template,$data_parse);
	
   redirect(base_url()."message/index/".$page.'/'.$sender_id."/".$project_id);                        
}
else{
	$this->session->set_flashdata('msg_failed',"Message sending failed"); 
redirect(base_url()."message/index/".$page.'/'.$sender_id."/".$project_id);  
//redirect(VPATH."message/");	
}
}
}
else
{

$this->layout->view('msg_details',$lay,$data,'normal');
}

}        
}*/

public function details($sender_id='',$project_id='',$limit_from='') {
if(!$this->session->userdata('user')){
redirect(VPATH."login/");
}
else{

$user=$this->session->userdata('user');

$data['user_id']=$user[0]->user_id;
//$data['user_membership']=$user[0]->membership_plan;

$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);

$data['ldate']=$user[0]->ldate;
$data['sender_id']=$sender_id;
$data['project_id']=$project_id;

$breadcrumb=array(
array(
		'title'=>'Notifications','path'=>''
)
);

$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Notification');

///////////////////////////Leftpanel Section start//////////////////

$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

if($logo==''){
$logo="images/user.png";
}
else{
$logo="uploaded/".$logo;
}
$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

///////////////////////////Leftpanel Section end//////////////////

$head['current_page']='membership';

$head['ad_page']='inbox';

$load_extra=array();

$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

$this->layout->set_assest($head);
$this->load->library('pagination');
$config['base_url'] = VPATH.'message/details/'.$sender_id.'/'.$project_id.'/';
$config['total_rows'] =$this->message_model->countAllMessage($project_id,$sender_id,$user[0]->user_id);
$config['per_page'] = 4; 
$config["uri_segment"] = 5;
$config['use_page_numbers'] = TRUE;   
$this->pagination->initialize($config); 
$page = ($limit_from) ? $limit_from : 0;
$per_page = $config["per_page"];
$start = 0;
if ($page > 0) {
for ($i = 1; $i < $page; $i++) {
	$start = $start + $per_page;
}
}
$data['page_number']=$page;
$data['message']=$this->message_model->getAllMessage($project_id,$sender_id,$user[0]->user_id,$config['per_page'], $start); $data['messageone']=$this->message_model->getAllMessageRight($project_id,$sender_id,$user[0]->user_id);  
$data['links']=$this->pagination->create_links();

$this->autoload_model->getsitemetasetting("meta","pagename","Message");

$lay['client_testimonial']="inc/footerclient_logo";
if($this->input->post("submit")){
$page = $this->input->post("page_id");
$data['page_number']=$page;
$this->form_validation->set_rules('message', 'Message', 'required');

if($this->form_validation->run()==FALSE){ 

 redirect(base_url()."message/index/".$page."/".$sender_id."/".$project_id);                     
}
else{
 $image="";   

 
$config['upload_path'] ='assets/question_file/';
$config['allowed_types'] = 'bmp|gif|jpg|jpeg|png|pdf|txt|docx|xls|doc|zip|xl|xlsx';


$this->load->library('upload', $config);
 
$uploaded = $this->upload->do_upload();
$upload_data = $this->upload->data();
//print_r($upload_data); die();
$fname = $upload_data['file_name'];                     
 
/*?> if (!$uploaded AND $fname == ''){
	$error = array('error' => $this->upload->display_errors());
	$this->session->set_flashdata('error_msg', $error['error']);
	 redirect(base_url()."ireportupload");
}   <?php */                 

$post_data["message"]=  $this->input->post("message");
$post_data["attachment"]=  $fname;
$post_data["project_id"]=  $this->input->post("project_id");
$post_data["recipient_id"]=  $this->input->post("recipient_id");
$post_data["sender_id"]=  $this->input->post("sender_id");
$post_data["add_date"]=  date('Y-m-d H:i:s');

$insert=  $this->message_model->insertMessage($post_data);
$data['page_number']=$page;
if($insert){
	$from=ADMIN_EMAIL;
	
	$fname=$this->auto_model->getFeild('fname','user','user_id',$this->input->post("recipient_id"));
	$lname=$this->auto_model->getFeild('lname','user','user_id',$this->input->post("recipient_id"));
	$to=$this->auto_model->getFeild('email','user','user_id',$this->input->post("recipient_id"));
	$template='pm_alert';
	
	$data_parse=array('name'=>$fname." ".$lname
						);
	$this->auto_model->send_email($from,$to,$template,$data_parse);
	
   redirect(base_url()."message/index/".$page.'/'.$sender_id."/".$project_id);                        
}
else{
	$this->session->set_flashdata('msg_failed',"Message sending failed"); 
redirect(base_url()."message/index/".$page.'/'.$sender_id."/".$project_id);  
//redirect(VPATH."message/");	
}
}
}
else
{

$this->layout->view('msg_details',$lay,$data,'normal');
}

}        
}

public function detailsmsg($pid='',$sid='',$limit_from='',$interview_status=''){

$projectid = $pid;
$sendID=$sid;
$user=$this->session->userdata('user');

$user_id=$user[0]->user_id;

/* $user[0]->user_id; */

$messageOne= $this->message_model->getAllMessageRight($projectid,$sendID,$user[0]->user_id , $interview_status);  

$project_name=filter_data($this->auto_model->getFeild('title','projects','project_id',$projectid));

$this->autoload_model->getsitemetasetting("meta","pagename","Message");

$lay['client_testimonial']="inc/footerclient_logo";

$sender_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$sendID));
$sender_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$sendID)); 

$p_link = base_url('jobdetails/details/'.$projectid.'/'.seo_string($project_name));
$p_sts = getField('status', 'projects', 'project_id', $projectid);
if(is_bidder($user_id, $projectid)){
	$p_link = base_url('projectroom/freelancer/overview/'.$projectid);
}
if(is_employer($user_id, $projectid) && ($p_sts != 'O' && $p_sts != 'E' && $p_sts != 'S')){
	$p_link = base_url('projectroom/employer/overview/'.$projectid);
}

 ?>

<div class="top-setting-bar">
	<h3><a href="javascript:void(0)" class="backArrow" onclick="showListFragment()"><i class="fas fa-arrow-left"></i></a> <?php echo ucfirst($sender_fname)." ".ucfirst($sender_lname);?> <span class="star-style"><i class="fa fa-star"></i></span><br>
	<small> <a href="<?php echo $p_link; ?>"><?php echo $project_name;?> </a></small>
	</h3>
	
	<ul class="pull-right hide">
	<li class="mar-lft-10"><a title="<?php echo __('message_files','Files'); ?>" style="cursor: pointer;" class="toggle_file"><i class="fa fa-file"></i></a></li>
	<li class="mar-lft-10"><a title="<?php echo __('message_people','People'); ?>" style="cursor: pointer;" class="toggle_user"><i class="fa fa-user"></i></a></li>
	
	</ul>
</div>

<!--ProfileRight Start-->
<div class="profile_right profile_right_mofify">
<div class="row">
<div class="col-sm-8 col-xs-12" id="msg_wrap">
<!--MessageDetais Start-->

<div class="editprofile whiteBg" id="output">
<div class="leftWidth">
<?php
$fav_msg = array();
$msg = $this->auto_model->get_results('serv_fav_msg' , array('user' => $user_id) , 'msg_id');
if(count($msg) > 0){
	foreach($msg as $k => $v){
		$fav_msg[] = $v['msg_id'];
	}
	unset($msg);
}
if(count($messageOne)>0){
$this->db->where(array('project_id' => $projectid, 'recipient_id' => $user_id))->update('message' ,array('read_status' => 'Y'));
foreach($messageOne as $key=>$val)
{
$sender_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$sendID));
$sender_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$sendID));    
$sender_logo=$this->auto_model->getFeild('logo','user','user_id',$val['sender_id']);

if($sender_logo && file_exists('assets/uploaded/cropped_'.$sender_logo)){
	$sender_logo = 'cropped_'.$sender_logo;
}

$logo=($sender_logo)?'uploaded/'.$sender_logo:'images/user.png';

$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$val['sender_id']);     
$status=((time()-60) > $last_seen)?false:true;
$reciever_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$user_id));
$reciever_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$user_id)); 

    
?>

<div class="conversation_loop <?php echo $val['sender_id'] == $user_id ? 'me' : 'other';?>">

<div class="posted_by_name">
<?php if($val['sender_id']!=$user_id) {?>
<div class="media-left">
<figure class="profile-imgEc pull-left">
<img src="<?php echo ASSETS.$logo?>" alt="">
<?php if($status){ ?>
<div class="online-sign"></div>
<?php } else{ ?>
<div class="online-sign" style="background:#ddd"></div>
<?php } ?>
</figure>
</div>
<?php } ?>
<div class="media-body">
<div class="info-conversation">


<div class="messge_body" id="txt_msg"><p><?php echo $val['message'];?>

<?php if(isset($val['attachment'])){ ?>

<a href="<?php echo VPATH;?>assets/question_file/<?php echo $val['attachment']?>" target="_blank"><?php echo $val['attachment'];?></a>
<?php } ?>
</p> 
</div></div>
<?php if($val['sender_id']==$user_id){ ?><p class="chat_date"><?php echo $val['read_status'] == 'Y' ? 'Seen' : 'Sent'; ?></p><?php } ?>
<p class="chat_date"><?php echo ucwords(date('d M,Y H:i:s',strtotime($val['add_date'])));?></p>
<span class="starred">
<?php
if(!in_array($val['id'] , $fav_msg)){
?>
<i class="fa fa-star add_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']?>"></i>
<?php
}else{
?>
<i class="fa fa-star remove_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']?>"></i>
<?php	
}
?>
</span>
</div>

</div>
</div>
<?php
}
}else{
echo "No conversation yet..";	
}
?>
</div>
</div>
<div class="loaded " style="display:none;text-align: right;padding: 5px;position: absolute;right: 0px;margin-top: 10px;margin-right: 90px;z-index: 99;"><i class="fa fa-spinner fa-spin "></i></div>
<div class="editprofile editprofile-form">


<form method="post" name="uploadmessage" id="myform" action="" enctype="multipart/form-data">

<input type="hidden" name="recipient_id" id="recipient_id" value="<?php echo $sendID;?>">

<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $user_id;?>">

<input type="hidden" name="project_id" id="project_id" value="<?php echo $projectid;?>">
<input type="hidden" name="page_id" id="page_id" value="0">
<div class="acount_form inputBox">
<div class="input-group">
<textarea id="message" name="message" class="form-control" placeholder="Write your message here"></textarea>
<span class="input-group-btn">
    <span class="btn btn-default btn-file"><i class="fa fa-paperclip"></i>
    <input type="file" name="userfile">
    </span>
</span>
<span class="input-group-btn">
    <button type="submit" name="submit" id="newsubmit" class="btn btn-site" title=""><i class="fa fa-paper-plane"></i></button>
</span>
</div>

<div class="error-msg2"></div>

  
</div>
</form>

</div>



</div>


<!--MessageDetais End-->
<div class="col-sm-4 col-xs-12 hidden-xs hide" id="more_people">
<div class="col-3-outer">
<h3><?php echo __('message_people','People'); ?> <span class="pull-right"><a style="cursor: pointer;"></a></span></h3>
<div id="roompeople"></div>
<div class="conversation_loop">

<?php 
$rec_logo=$this->auto_model->getFeild('logo','user','user_id',$user_id);

if($rec_logo && file_exists('assets/uploaded/cropped_'.$rec_logo)){
	$rec_logo = 'cropped_'.$rec_logo;
}

$r_logo = ($rec_logo)?'uploaded/'.$rec_logo:'images/user.png'; 
$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$user_id);     
$status=((time()-60) > $last_seen)?false:true;
?>

<div class="media">
<div class="media-left">
	<figure class="profile-imgEc pull-left">
	<img src="<?php echo ASSETS.$r_logo;?>" alt="">
	<?php if($status){ ?>
	<div class="online-sign"></div>
	<?php } else { ?>
	<div class="online-sign" style="background:#ddd"></div> 
	<?php } ?>
	</figure>
</div>
<div class="media-body media-middle">
	<?php echo $reciever_fname . " ". $reciever_lname; ?><br>
</div>
</div>


</div>

<?php 
$sen_logo=$this->auto_model->getFeild('logo','user','user_id',$sendID);

if($sen_logo && file_exists('assets/uploaded/cropped_'.$sen_logo)){
	$sen_logo = 'cropped_'.$sen_logo;
}

$s_logo = ($sen_logo)?'uploaded/'.$sen_logo:'images/user.png'; 
$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$sendID);     
$status=((time()-60) > $last_seen)?false:true;
?>

<div class="conversation_loop">

<div class="media">
	<div class="media-left">
		<figure class="profile-imgEc pull-left">
		<img src="<?php echo ASSETS.$s_logo;?>" alt="">
		<?php if($status){ ?>
		<div class="online-sign"></div>
		<?php } else { ?>
		<div class="online-sign" style="background:#ddd"></div> 
		<?php } ?>
		</figure>
	</div>


	<div class="media-body media-middle">
		<?php echo $sender_fname . " ". $sender_lname; ?><br>
	</div>
</div>

</div>


</div>

<!--MessageDetais End-->

</div>


<?php 
$files = $this->db->where('project_id' , $projectid)->get('message')->result_array();
?>

<div class="col-sm-4 col-xs-12 hidden-xs" id="files_list">
<div class="col-3-outer">
<h3><?php echo __('message_files','Files'); ?></h3>
<div class="attachment_sec">
<?php if(count($files) > 0){
	foreach($files as $k => $v){
		if(!empty($v['attachment'])){
			echo '<p><a href="'.base_url().'/assets/question_file/'.$v['attachment'].'" target="_blank">'.$v['attachment'].'</a></p>';
		}
		
	}
} else{
	//echo '<div class="well">'.__('message_no_file','No file').'</div>';
}?>
</div>
</div>
</div>
</div>
</div>
<!-- end of article -->

<?php
}


public function detailmsgroom($rid='',$sid=''){
	$room_id = $rid;
	$sender_id = $sid;
	$user=$this->session->userdata('user');
	$user_id=$user[0]->user_id;
	$chat_room_det = $this->db->where('id' , $room_id)->get('chatroom')->row_array();
	$messages = $this->db->where('room_id' , $room_id)->order_by('id' , 'DESC')->get('room_message')->result_array();
?>
<div class="top-setting-bar">
	<div class="pull-left">
	<h3><a href="javascript:void(0)" class="backArrow" onclick="showListFragment()"><i class="fas fa-arrow-left"></i></a> <?php echo ucfirst($chat_room_det['name']);?> <span class="star-style"><i class="fa fa-star"></i></span><br>
	<small> <?php echo ucfirst($chat_room_det['topic']);?> </small>
	</h3>
	</div>
	
	<ul class="pull-right">
	<li><a title="Files" style="cursor: pointer;" class="toggle_file"><i class="fa fa-file-text"></i></a></li>
	<li><a title="People" style="cursor: pointer;" class="toggle_user"><i class="fa fa-user"></i></a></li>
	<!--<li>
	<div class="dropdown">
	<a title="Action" class="dropdown-toggle" type="button" data-toggle="dropdown" style="cursor: pointer;"><i class="fa fa-ellipsis-h"></i></a>
	<ul class="dropdown-menu">
	<li><a style="cursor: pointer;">Add People</a></li>
	</ul>
	</div>
	</li>-->
	</ul>
</div>

<!--ProfileRight Start-->
<div class="col-sm-8 col-xs-12" id="msg_wrap">
<div class="profile_right profile_right_mofify">
<div class="editprofile whiteBg" id="output">

<div class="leftWidth">
<?php
/*$fav_msg = array();
$msg = $this->auto_model->get_results('serv_fav_msg' , array('user' => $user_id) , 'msg_id');
if(count($msg) > 0){
	foreach($msg as $k => $v){
		$fav_msg[] = $v['msg_id'];
	}
	unset($msg);
}*/
if(count($messages) > 0)
{
foreach($messages as $key=>$val)
{
$sender_fname=$this->auto_model->getFeild('fname','user','user_id',$val['sender']);
$sender_lname=$this->auto_model->getFeild('lname','user','user_id',$val['sender']); 
$sender_logo=$this->auto_model->getFeild('logo','user','user_id',$val['sender']);    
$logo=  ($sender_logo)? 'uploaded/'.$sender_logo: 'images/user.png';
$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$val['sender']);     
$status=((time()-60) > $last_seen)?false:true;
//echo $logo;
?>
<div class="conversation_loop <?php echo $val['sender']==$user_id ? 'me' : 'other';?>">

<div class="posted_by_name">
<div class="media-left">
<figure class="profile-imgEc pull-left">
<img src="<?php echo ASSETS.$logo;?>" alt="">
<?php if($status) {?>
<div class="online-sign"></div> 
<?php }else{?>
	<div class="online-sign" style="background:#ddd"></div> 
	<?php }?>
</figure>
</div>
<div class="media-body">
<div class="info-conversation">
<div class="arrow"></div>
<?php
/* if(!in_array($val['id'] , $fav_msg)){
?>
<i class="fa fa-star add_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']?>"></i>
<?php
}else{
?>
<i class="fa fa-star remove_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']?>"></i>
<?php	
} */ 
?>
<em><a target="_blank" href="<?php echo VPATH."clientdetails/showdetails/".$val['sender'] ?>"><?php if($val['sender']==$user_id){echo "Me";}else{echo ucwords($sender_fname)." ".ucwords($sender_lname);}?></a></em>

<div class="messge_body" id="txt_msg"><p><?php echo $val['message'];?>

<?php if(isset($val['attachment'])){ ?>

<a href="<?php echo VPATH;?>assets/question_file/<?php echo $val['attachment']?>" target="_blank"><?php echo $val['attachment'];?></a>

<?php } ?>
</p> 
</div></div></div>
<div class="media-right">
<span><?php echo ucwords(date('d M,Y H:i:s',strtotime($val['send_date'])));?></span>
</div>

</div>
</div>
<?php
}
}
else
{
echo "No conversation yet..";	
}
?>
</div>
</div>
</div>

<?php /*
<div class="editprofile editprofile-form">


<form method="post" name="uploadmessage" id="myform" action="" enctype="multipart/form-data">

<input type="hidden" name="recipient_id" id="recipient_id" value="room">

<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $user_id;?>">

<input type="hidden" name="project_id" id="project_id" value="<?php echo $room_id;?>">
<input type="hidden" name="page_id" id="page_id" value="0">
<div class="acount_form inputBox">
<div class="input-group">
<textarea id="message" name="message" class="form-control"></textarea>
<!--<div class="acount_form linkButton"><input type="file" name="userfile" size="30" class="acount-input"></div>-->
<span class="input-group-btn">
    <span class="btn btn-default btn-file"><i class="fa fa-paperclip"></i>
    <input type="file" name="userfile">
    </span>
</span>
<span class="input-group-btn">
    <button type="submit" name="submit" id="newsubmit" class="btn btn-site" title="" style="height:44px;"><i class="fa fa-paper-plane"></i></button>
    <!--<input type="button" name="button" class="btn-normal btn-color submit bottom-pad2" value="Cancel" onClick="javascript:window.history.back(-1);">-->    
</span>
</div>

<div class="error-msg2"></div>

  
</div>
</form>
</div>

*/ ?>
</div>

<!--MessageDetais End-->
<div class="col-sm-4 col-xs-12" id="more_people">
<div class="col-3-outer">
<h3><?php echo __('message_people','People'); ?> <span class="pull-right" data-toggle="modal" data-target="#myModal2"><a style="cursor: pointer;"><i class="fa fa-plus"></i></a></span></h3>
<div id="roompeople"></div>
<?php 
$room_member = $this->db->where('room_id' , $room_id)->get('room_members')->result_array(); 
//echo '<pre>'; print_r($room_member); die();
if(count($room_member) > 0){
	foreach($room_member as $k => $v){
		$member_fname=$this->auto_model->getFeild('fname','user','user_id',$v['member_id']);
		$member_lname=$this->auto_model->getFeild('lname','user','user_id',$v['member_id']); 
		$sender_logo=$this->auto_model->getFeild('logo','user','user_id',$v['member_id']); 
		$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$v['member_id']);     
		$status=((time()-60) > $last_seen)?false:true;   
		$logo=  ($sender_logo)? 'uploaded/'.$sender_logo: 'images/user.png';
?>


<div class="conversation_loop">


<div class="col-sm-3 col-xs-12 pad0">
<figure class="profile-imgEc pull-left">
<img src="<?php echo ASSETS.$logo;?>" alt="">
<?php if($status) {?>
<div class="online-sign"></div>
<?php } else{?>
	<div class="online-sign" style="background:#ddd"></div>
	<?php }?>

</figure>
</div>


<div class="col-sm-9 col-xs-12">
<?php echo $member_fname." ".$member_lname;?> 
</div>
</div>
<?php
	}
}
?>


<!--MessageDetais End-->


</div>
</div>
<div class="col-sm-4 col-xs-12" id="files_list">
<div class="col-3-outer">
<h3><?php echo __('message_files','Files'); ?></h3>
<?php if(count($messages) > 0){
	foreach($messages as $k => $v){
		if(!empty($v['attachment'])){
			echo '<a href="'.base_url().'/assets/question_file/'.$v['attachment'].'" target="_blank">'.$v['attachment'].'</a><br/>';
		}
		
	}
}else{
	echo '<div class="well">No file</div>';
}?>
</div>
</div> 

<?php
	
}

 
/*public function addroom(){
	if($this->input->post()){
		$user=$this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$room_name="Unnamed room";
		if($this->input->post('room_name')!=''){
			$room_name=$this->input->post('room_name');
		}
		$insertdata=array('name'=>$room_name,'topic'=>$this->input->post('topic'),'user_id'=>$user_id,'created'=>date('Y-m-d H:i:s'));
		$this->db->insert('chatroom',$insertdata);
		$insertid=$this->db->insert_id();
		$this->db->insert('room_members',array('room_id'=>$insertid,'member_id'=>$user_id,'type'=>1,'status'=>'Y','joindate'=>date('Y-m-d H:i:s')));
		if($this->input->post('msg') && $this->input->post('msg')!=''){
			$this->db->insert('room_message',array('room_id'=>$insertid,'sender'=>$user_id,'message'=>$this->input->post('msg'),'send_date'=>date('Y-m-d H:i:s')));
		} 

		echo json_encode(array('message'=>'success','data'=>$insertid));
	}
}
public function roomusers(){
	$roomid=$this->input->post('roomid');
	
}*/

public function addroom(){
	if($this->input->post()){
		$user=$this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$room_name="Unnamed room";
		if($this->input->post('room_name')!=''){
			$room_name=$this->input->post('room_name');
		}
		$insertdata=array('name'=>$room_name,'topic'=>$this->input->post('topic'),'user_id'=>$user_id,'created'=>date('Y-m-d H:i:s'));
		$this->db->insert('chatroom',$insertdata);
		$insertid=$this->db->insert_id();
		$this->db->insert('room_members',array('room_id'=>$insertid,'member_id'=>$user_id,'type'=>1,'status'=>'Y','joindate'=>date('Y-m-d H:i:s')));
		if($this->input->post('msg') && $this->input->post('msg')!=''){
			$this->db->insert('room_message',array('room_id'=>$insertid,'sender'=>$user_id,'message'=>$this->input->post('msg'),'send_date'=>date('Y-m-d H:i:s')));
		} 
		$topic=($this->input->post('topic'))?$this->input->post('topic'):"Topic here";
		$roomhtml='<div class="messagtext2" id="room'.$insertid.'"><p><a id="anchor" href="#" onclick="roomdetails('.$insertid.');"><span class="menu">'.$room_name.'</span></a></p><h4><a id="anchor" href="#" onclick="roomdetails('.$insertid.');">'.$topic.'</a></h4></div>';
		echo json_encode(array('message'=>'success','data'=>$insertid,'room'=>$roomhtml));
	}
}

public function roomusers(){
	$user=$this->session->userdata('user');
	$user_id = $user[0]->user_id;
	$roomid=$this->input->post('roomid');
	$users=$this->db->dbprefix('user');
	$members=$this->db->dbprefix('room_members');
	$res=$this->db->select("$users.user_id as userid,$users.username,$users.fname,$users.lname,$users.logo,$members.type,$members.joindate")->from('room_members')->join("user","$members.member_id=$users.user_id",'left')->where(array("$members.room_id"=>$roomid))->get()->result_array();
	$data['user']=$user_id;
	$data['roomid']=$roomid;
	$data['members']=$res;
	$this->layout->view('room_users',"",$data,'ajax'); 
}


public function addusers(){
	$post_data=$this->input->post();
	//echo '<pre>'; print_r($post_data); die();
	if(is_array($post_data['roomusers'])){
		foreach($post_data['roomusers'] as $k => $v){
			$count = $this->db->where(array('member_id' => $v , 'room_id' => $post_data['roomid'] , 'type' => 2))->count_all_results('room_members');
			if($count == 0){
				$this->db->insert('room_members',array('room_id'=>$post_data['roomid'],'member_id'=>$v,'type'=>2,'status'=>'Y','joindate'=>date('Y-m-d H:i:s')));
			}
			
		}
	}
	/*foreach ($post_data as $key => $value) {
		$this->db->insert('room_members',array('room_id'=>$post_data['roomid'],'member_id'=>$value,'type'=>2,'status'=>'Y','joindate'=>date('Y-m-d H:i:s')));
	}*/
}

public function hide_msg($msg='' , $type='P'){
	$user=$this->session->userdata('user');
	$user_id = $user[0]->user_id;
	$count = $this->db->where(array('uid' => $user_id, 'msg_obj_id' => $msg , 'type' => $type))->count_all_results('hidden_msg');
	if($count == 0){
		$this->db->insert('hidden_msg',array('uid'=>$user_id,'msg_obj_id'=>$msg,'type'=>$type));
	}
	echo 1;
}

public function update_msg(){
	$user=$this->session->userdata('user');
	$user_id = $user[0]->user_id;
	$res = file_get_contents("user_message/user_".$user_id.".newmsg");
	if($res == 1){
		echo 1;
		file_put_contents("user_message/user_".$user_id.".newmsg" , 0);
	}else{
		echo 0;
	}
}

}
?>
