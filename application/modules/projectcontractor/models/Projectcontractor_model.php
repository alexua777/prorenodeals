<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class projectcontractor_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

         public function getcontructor($user_id,$project_id){ 
             $bidder=array();
             $data=array();
             $query=$this->db->select('bidder_id')->get_where('projects',array('user_id'=>$user_id,'project_id'=>$project_id));
             if($query->num_rows()){
			 	$dt=$query->row();
			 	$bidder=explode(",",$dt->bidder_id);
			 }
             if($bidder && is_array($bidder)){
			 	$this->db->select('fname,lname,user_id');
			 	$res=$this->db->where_in('user_id',$bidder)->get('user');
				foreach($res->result() as $val){ 
					$data[]=array(		     
						 "name" => $val->fname." ".$val->lname,
			             "user_id" => $val->user_id,
						 "myfeedback"=>$this->getendstatus($user_id,$project_id),
						 "freelancer_feedback"=>$this->getendstatus($user_id,$project_id,1),
			             "end_status"=>$this->getendstatus($user_id,$project_id),
			             "update_status"=>$this->getupdatestatus($user_id,$project_id),
			             
					   );
				}
			 }
          
	      return $data; 
		
         }
		 
         public function givefeedbacktouser($data)
		 {
		 $this->db->delete('feedback_end',array('project_id'=>$data['project_id'],'given_user_id'=>$data['given_user_id']));
			$a=$this->db->insert('feedback_end',$data);	
			if($a){
			$query=$this->db->select('user_id')->get_where('projects',array('project_id'=>$data['project_id'],'user_id'=>$data['given_user_id']));
             if($query->num_rows()){
			 $this->db->where('project_id',$data['project_id'])->where('given_user_id',$data['given_user_id'])->update('feedback_end',array('project_owner'=>$data['given_user_id']));
			 $all_chosen=explode(",",$this->auto_model->getFeild('end_contractor','projects','project_id',$data['project_id']));
			 $get_key_chosen=array_search($data['user_id'],$all_chosen);
			$exi=trim(implode(",",$all_chosen));
			if($exi!='' && !$get_key_chosen){
				$alluser=trim(implode(",",$all_chosen)).",".$data['user_id'];
			}else{
				$alluser=$data['user_id'];
			}	
			$this->db->where('project_id',$data['project_id'])->update('projects',array('end_contractor'=>$alluser));
			 }
			$msg['status']='OK';  
			$msg['msg']='Feedback successfully added';
			}else{
			$msg['msg']='Error. Try again later!';
				$msg['status']='ERROR';	
			} 
			return json_encode($msg);
		}
		 public function getendstatus($user_id,$project_id,$tome='')
		 {	
		 	if($tome){
				$query=$this->db->select('status')->get_where('feedback_end',array('user_id'=>$user_id,'project_id'=>$project_id));
			}else{
				 $query=$this->db->select('status')->get_where('feedback_end',array('given_user_id'=>$user_id,'project_id'=>$project_id));
			 }
             if($query->num_rows()){
				 return 'Y';
			 }else{
			 	 return 'N';
			 }
		 }
		 public function getupdatestatus($user_id,$project_id,$tome='')
		 {	
		 	if($tome){
				$query=$this->db->select('update_status')->get_where('feedback_end',array('user_id'=>$user_id,'project_id'=>$project_id,'update_status'=>'Y'));
			}else{
				 $query=$this->db->select('update_status')->get_where('feedback_end',array('given_user_id'=>$user_id,'project_id'=>$project_id,'update_status'=>'Y'));
			 }
             if($query->num_rows()){
				 return 'Y';
			 }else{
			 	 return 'N';
			 }
		 }
		 public function getfeedback($post){
		 
		 	$query=$this->db->select('*')->get_where('feedback_end',array('given_user_id'=>$post['given_user'],'project_id'=>$post['project_id']));
		 	$msgtest="";
		 	if($query->num_rows()){
		 	$dt=$query->row();
		$msgtest.='<div class="acount_form"><p>Safety :</p><p style="text-align:left">';
		 for($i=1;$i<=$dt->safety;$i++){
		 	 $msgtest.='<img src="'.ASSETS.'images/1star.png" alt="review star"/>';
		 }
		$msgtest.='</p></div>';
		$msgtest.='<div class="acount_form"><p>Flexiblity :</p><p style="text-align:left">';
		 for($i=1;$i<=$dt->flexibility;$i++){
		 	 $msgtest.='<img src="'.ASSETS.'images/1star.png" alt="review star"/>';
		 }
		$msgtest.='</p></div>';

		$msgtest.='<div class="acount_form"><p>Performence :</p><p style="text-align:left">';
		 for($i=1;$i<=$dt->performence;$i++){
		 	 $msgtest.='<img src="'.ASSETS.'images/1star.png" alt="review star"/>';
		 }
		$msgtest.='</p></div>';

		$msgtest.='<div class="acount_form"><p>Initiative :</p><p style="text-align:left">';
		 for($i=1;$i<=$dt->initiative;$i++){
		 	 $msgtest.='<img src="'.ASSETS.'images/1star.png" alt="review star"/>';
		 }
		$msgtest.='</p></div>';

		$msgtest.='<div class="acount_form"><p>Knowledge :</p><p style="text-align:left">';
		 for($i=1;$i<=$dt->knowledge;$i++){
		 	 $msgtest.='<img src="'.ASSETS.'images/1star.png" alt="review star"/>';
		 }
		$msgtest.='</p></div>';
		
		
		if($dt->comments!=""){
		$msgtest.='<div class="acount_form">
						<p style="text-align:left !important;width:100%"><b>Comment :</b>'.$dt->comments.'</p>
					</div>	';
		}
		
		  $msg['msg']=$msgtest;
		 $msg['status']='OK';
		 }else{
		 	$msg['msg']='Error. Try again later!';
			$msg['status']='ERROR';
		 }
		return json_encode($msg); 
       }
       public function getclient($user_id,$project_id){ 
             $bidder=array();
             $data=array();
             $query=$this->db->select('user_id')->where('project_id',$project_id)->where("FIND_IN_SET('".$user_id."', bidder_id)")->get('projects');
             if($query->num_rows()){
			 	$dt=$query->row();
			 	$user=explode(",",$dt->user_id);
			 }
             if($user && is_array($user)){
			 	$this->db->select('fname,lname,user_id');
			 	$res=$this->db->where_in('user_id',$user)->get('user');
				foreach($res->result() as $val){ 
					$data[]=array(		     
						 "name" => $val->fname." ".$val->lname,
			             "user_id" => $val->user_id,
						 "myfeedback"=>$this->getendstatus($user_id,$project_id),
						 "freelancer_feedback"=>$this->getendstatus($user_id,$project_id,1),
			             "end_status"=>$this->getendstatus($user_id,$project_id)
					   );
				}
			 }
          
	      return $data; 
		
         }
	public function cron_end_contractor_up(){
		$ate=date('Y-m-d',strtotime('-15 days'));
	$res=$this->db->select('*')->where('project_owner !=',0)->where('update_status','N')->where('add_date <=',$ate)->get('feedback_end');
$t="";
		foreach($res->result() as $val){ 
		$t++;
		 $all_ended=explode(",",$this->auto_model->getFeild('ended_contractor','projects','project_id',$val->project_id));
			 $get_key_chosen=array_search($val->user_id,$all_ended);
			$exi=trim(implode(",",$all_ended));
			if($exi!='' && !$get_key_chosen){
				$alluser=trim(implode(",",$all_ended)).",".$val->user_id;
			}else{
				$alluser=$val->user_id;
			}
			
		$ended_contractor=$alluser;
		$up=$this->db->where('project_id',$val->project_id)->update('projects',array('ended_contractor'=>$ended_contractor));
		$this->db->where('project_id',$val->project_id)->where('user_id',$val->user_id)->update('feedback_end',array('update_status'=>'Y'));
		$this->db->where('project_id',$val->project_id)->where('given_user_id',$val->user_id)->update('feedback_end',array('update_status'=>'Y'));
		
		
					$new_data['user_id']=$val->user_id;
					$new_data['given_user_id']=$val->given_user_id;
					$new_data['project_id']=$val->project_id;
					$new_data['safety']=$val->safety;
					$new_data['flexibility']=$val->flexibility;
					$new_data['performence']=$val->performence;
					$new_data['initiative']=$val->initiative;
					$new_data['knowledge']=$val->knowledge;	
					$average=($new_data['safety']+$new_data['flexibility']+$new_data['performence']+$new_data['initiative']+$new_data['knowledge'])/5;
					$new_data['average']=$average;
					$new_data['comments']=	$val->comments;	
					$new_data['status']='Y';
					$new_data['add_date']=date('Y-m-d');

					$this->db->delete('review',array('project_id'=>$val->project_id,'given_user_id'=>$val->given_user_id));
					$this->db->insert('review',$new_data);
					
					$reso=$this->db->select('*')->where('given_user_id',$val->user_id)->where('project_id',$val->project_id)->get('feedback_end');

				foreach($reso->result() as $valo){ 
					$new_datao['user_id']=$valo->user_id;
					$new_datao['given_user_id']=$valo->given_user_id;
					$new_datao['project_id']=$valo->project_id;
					$new_datao['safety']=$valo->safety;
					$new_datao['flexibility']=$valo->flexibility;
					$new_datao['performence']=$valo->performence;
					$new_datao['initiative']=$valo->initiative;
					$new_datao['knowledge']=$valo->knowledge;	
					$average=($new_datao['safety']+$new_datao['flexibility']+$new_datao['performence']+$new_datao['initiative']+$new_datao['knowledge'])/5;
					$new_datao['average']=$average;
					$new_datao['comments']=	$valo->comments;	
					$new_datao['status']='Y';
					$new_datao['add_date']=date('Y-m-d');

					$this->db->delete('review',array('project_id'=>$valo->project_id,'given_user_id'=>$valo->given_user_id));
					$this->db->insert('review',$new_datao);
				}
		if($up){
			$t.="Success :".$val->project_id." | ".$val->user_id."<br>";
		}else{
			$t.="Failed :".$val->project_id." | ".$val->user_id."<br>";
		}
		
		 $all_ended_contractor=@explode(",",$this->auto_model->getFeild('ended_contractor','projects','project_id',$val->project_id));
		 $all_bidder_id=@explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$val->project_id));
		 if(count(array_diff($all_bidder_id, $all_ended_contractor))=='0'){
		 	$this->db->where('project_id',$val->project_id)->update('projects',array('status'=>'C'));
		 }
					
		}
		
		
	return $t;
	
	}
}
