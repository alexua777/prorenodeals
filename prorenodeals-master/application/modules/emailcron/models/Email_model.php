<?php 

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Email_model extends BaseModel {



    public function __construct() {

        return parent::__construct();

    }

    public function test(){ 
        $this->db->select("*");
       $this->db->from('projects');
       $this->db->where('post_time > DATEDIFF(NOW()-1, NOW())');
      $query = $this->db->get();
	   //echo  $sql = $this->db->last_query(); 
	  $result=$query->result_array();
		//echo "<pre>";
		//print_r($result);
		
		$i=1;
		foreach($result as $val){
		//echo '<pre>';
		
				 $Title=$val['title'];
				 $category=$val['category'];
				 $skills=$val['skills'];
				 $url='http://www.jobbid.org/staging/jobdetails/details/'.$val['project_id'];
				//print_r($val['skills']);
				$Skillarrays=explode(",",$val['skills']);
				
				//print_r($Skillarrays);
				//$i=0;
				$arrSkill = array();
				$format_Skill = "('".str_replace(',','\',\'',$val['skills'])."')"; //echo "<br/>";
				$sqlSelect = "SELECT id FROM serv_skills WHERE skill_name IN $format_Skill";
				$exeQuery = $this->db->query($sqlSelect);
				$resArr = $exeQuery->result_array();
				//print_r($resArr);				
				foreach ($resArr as $Skillarray)
				{
					$arrSkill[] = $Skillarray['id'];
				}
				$searchString = " AND (";
				foreach( $arrSkill as $sk => $skillId )
				{
					$searchString .= " FIND_IN_SET ('".$skillId."',skills_id) OR "; 	
				}
				//echo $searchString; echo "<br/>";
				$searchString = substr($searchString,0,-3).")";
				//$searchString = " ) ";
				//echo $searchString; echo "<br/>";
				//echo $format_Skill = "('".str_replace(',','\',\'',$inIds)."')"; //echo "<br/>";
				
				//print_r($arrSkill);
				 $sqlSelect = "SELECT s.id,s.user_id,u.email,u.fname FROM serv_user_skills AS s JOIN serv_user AS u ON s.user_id = u.user_id WHERE 1 $searchString";
				//echo $sqlSelect = "SELECT s.user_id,u.email FROM serv_user_skills AS s JOIN serv_user AS u ON s.user_id = u.user_id WHERE skills_id IN $format_Skill";
				
				$exeQuery = $this->db->query($sqlSelect);
				$resArr = $exeQuery->result_array(); 
				//foreach ($Skillarrays as $Skillarray){
				//echo '<pre>';
				//print_r($resArr);
				//echo "LoopCount=>".$i; echo "<br/>";	
				//if( $i <= 1)
				//{		
					//echo '<pre>';
					
					foreach($resArr as $ek =>$emailVal)
					{
						$from=ADMIN_EMAIL;
						$to=$emailVal['email'];
						$template='newjobsposted';
						$data_parse = array();
						$data_parse=array('username'=>$emailVal['fname'],
										  'jobtittle'=>$Title,
											'category' =>$category,
											'skills' => $skills,
											'copy_url'=>$url,
											'url_link'=>$url
									);
						$this->auto_model->send_email($from,$to,$template,$data_parse); 
						//mail(
					}
					
				//}
				//$resArr[0]['email'];
				
				//if( !empty($resArr) )
				
				// 
				/*  $from=ADMIN_EMAIL;
					$to=$resArr[0]['email'];
					$template='Job Match According to Your skill';
					$data_parse=array('name'=>$fname[$i],
								'username'=>$myname,
								'project_name' => $project_name,
								'copy_url'=>$url,
								'url_link'=>$url
								); */
					//$this->auto_model->send_email($from,$to,$template,$data_parse); 
				
		$i++;		
		}
        return $result;
    }
}