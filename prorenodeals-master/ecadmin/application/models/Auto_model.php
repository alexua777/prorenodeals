<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auto_model extends BaseModel {

    public function __construct() {
        parent::__construct();
		
		$query = $this->db->get( 'setting' );
		foreach( $query->result() as $filed=>$val ){ 

			define('SITE_TITLE', $val->site_title); 

			define('SITE_KEY', $val->meta_keys); 

			define('SITE_DESC', $val->meta_desc); 

			define('CURRENCY', $val->currency);

			define('ADMIN_EMAIL', $val->admin_mail); 
			define('ADMIN_PHONE', $val->contact_no); 
			define('ADMIN_FACEBOOK', $val->facebook);
			define('ADMIN_TWITTER', $val->twitter);
			define('ADMIN_PINTEREST', $val->pinterest);
			define('ADMIN_LINKEDIN', $val->linkedin);
			define('ADMIN_GOOGLE', $val->google_plus);
			define('ADMIN_RSS', $val->rss);
			define('EMAIL_VERI', $val->email_verify);
			define('TOTAL_BID', $val->total_bid);
			define('TOTAL_POST', $val->total_post);
			define('FIXED_RATE', $val->fix_featured_charge);
			define('HOURLY_RATE', $val->featured_charge_hourly);

			define('PAYPAL', $val->paypal_mail);
			define('PAYPAL_MODE', $val->paypal_mode);
			define('BANK_AC', $val->bank_ac);
			define('BANK_NAME', $val->bank_name);
			define('BANK_ADDRESS', $val->bank_address);
			define('JOB_EXPIRATION', $val->job_expiration);

			define('ADMIN_ADDRESS', $val->corporate_address);
				
			define('DEMO',($val->demo == "Y") ? true : false);
			define('DEMO_USER',(DEMO) ? 'admin' : "");
			define('DEMO_MSG',(DEMO) ? "Your demo task is completed. You need to have further permission." : ""); 

		}
		
		$q2 = $this->db->get( 'finance_constants' );
		foreach( $q2->result() as $k=>$v ){
			define($v->key, $v->value);
		}

    }

    public function setting() {

        $this->db->select();
        $query = $this->db->get_where("setting", array());
		$data=array();
		foreach($query->result() as $row)
		{
			$data[]=array(
			"site_title"=>$row->site_title,
			"admin_mail"=>$row->admin_mail
			);
		}
        return $data;
    }

    public function leftPannel() {
        $result = array();
        $this->db->select();
        $this->db->order_by("ord", "asc");
        $query = $this->db->get_where("adminmenu", array("status" => 'Y', "parent_id" => 0));
        $i = 0;
        foreach ($query->result() as $row) {
            $i++;
            $result[$i]['id'] = $row->id;
            $result[$i]['name'] = $row->name;
            $result[$i]['url'] = $row->url;
            $result[$i]['parent_id'] = $row->parent_id;
            $result[$i]['status'] = $row->status;
            $result[$i]['title'] = $row->title;
            $result[$i]['style_class'] = $row->style_class;
        }
        return $result;
    }


    public function leftpanelchild($id) {
        $result = array();
        $this->db->select();
        $query = $this->db->get_where("adminmenu", array("status" => 'Y', "parent_id" => $id));
        $i = 0;
        foreach ($query->result() as $row) {
            $i++;
            $result[$i]['id'] = $row->id;
            $result[$i]['name'] = $row->name;
            $result[$i]['url'] = $row->url;
            $result[$i]['parent_id'] = $row->parent_id;
            $result[$i]['status'] = $row->status;
            $result[$i]['title'] = $row->title;
            $result[$i]['style_class'] = $row->style_class;
        }
        return $result;
    }
    
    public function get_current_controller($id)
    {
        $this->db->select();
        $query = $this->db->get_where("adminmenu", array("status" => 'Y', "parent_id" => $id), 1,0);
        $parent_url = '';
        foreach ($query->result() as $row) {
            $parent_url = explode("/", $row->url);
            $parent_url = $parent_url[0];
        }
        $result['parent_url'] = $parent_url;
        return $result;
    }

    //// Get Data by field name //////////////////

    public function getFeild($select, $table, $feild = "", $value = "", $where = null) {
        $this->db->select($select);
        if ($value != '' AND $feild != '') {
            $rs = $this->db->get_where($table, array($feild => $value));
        } else {
            $rs = $this->db->get_where($table, $where);
        }
      //echo $this->db->last_query();
        $data = '';
        foreach ($rs->result() as $row) {
            $data = $row->$select;
        }
		
        return $data;
    }

    function showdate($date, $format = 'Y-m-d H:i:s') {
        if ($format == 'Y-m-d H:i:s') {
            if ($date):
                $e = @explode("-", $date);
                $time = @explode(":", substr($e[2], 2));
                $day = @substr($e[2], 0, 2);
                if ($e[1] && $day && $e[0]):
                    return date('m-d-Y', mktime($time[0], $time[1], $time[2], $e[1], $day, $e[0]));
                endif;
            endif;
        }else {
            if ($date):
                //$e = @explode("-", $date);
                
                return date('m-d-Y', strtotime($date));
            endif;
        }
    }

    function sqldate($date) {
        if ($date) {
            return $date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date)));
        }
    }
	public function getcleanurl($name) {
        return strtolower(str_replace("&", "-", str_replace(",", "-",(str_replace("'", "", str_replace(" ", "-", str_replace("/", "-", str_replace("-", "", $name))))))));
    }
	
	public function send_email($from,$to,$template,$data_parse){
	            
			$mailcontent=$this->auto_model->getaldata('template,subject','mailtemplate','type',$template);
			//print_r($mailcontent); die();
                        $contents="";
                        $subject="";
			foreach($mailcontent as $key=>$val){
			$contents=$val['body'];
			$subject=$val['subject'];
			}
			$this->load->library('email');

			$this->email->from($from, 'admin');
			$this->email->to($to); 
			$this->email->subject($subject);
			$this->email->set_mailtype("html");
			foreach($data_parse as $key=>$val){
	
				$contents=str_replace('{'.trim($key).'}',$val,$contents);
			}
			$contents=str_replace('src="/','src="'.SITE_URL,$contents);
			$contents=html_entity_decode($contents);
			$this->email->message($contents);	                         
			return $this->email->send();
                         // echo $this->email->print_debugger();
			
	
	}
	public function getaldata($attr,$table,$by,$value){
	$this->db->select($attr);	
	$rs = $this->db->get_where($table,array($by=>$value));
	 $data = array();
	 
	 foreach ($rs->result() as $row){
	  $data[] = array(
	  'body'=>$row->template,
	  'subject'=>$row->subject
	  );
	 }
	 return $data;
	
   }

       public function getskill($pid){         
        $this->db->select("id,skill_name");
        $con=array( 
           "parent_id" => $pid,
            "status" => "Y"
        );
        $this->db->order_by("skill_name");
        $res=$this->db->get_where("skills",$con);
        $data=array();
        
        foreach ($res->result() as $row){ 
            $data[]=array(
               "id" => $row->id,
               "skill_name" => $row->skill_name 
            );
        }
        
        return $data;
    }
	public function getcategory($pid){         
        $this->db->select("cat_id,cat_name");
        $con=array( 
           "parent_id" => $pid,
            "status" => "Y"
        );
        $this->db->order_by("cat_name");
        $res=$this->db->get_where("categories",$con);
        $data=array();
        
        foreach ($res->result() as $row){ 
            $data[]=array(
               "cat_id" => $row->cat_id,
               "cat_name" => $row->cat_name 
            );
        }
        
        return $data;
    }
    public function getnumsubcat($pid){         
        $this->db->select("cat_id");
        $con=array( 
           "parent_id" => $pid,
            "status" => "Y"
        );
		$this->db->where($con);
		$this->db->from('categories');
		return $this->db->count_all_results();
    }
    
   public function get_results($table_name, $query = array(), $cols = "*", $offset = '', $limit = '0', $order_by = array()) 				   {
        $this->db->select($cols)->from($table_name);
        if ($query AND is_array($query)) {
            $this->db->where($query);
        }
        if (count($order_by) > 0 && is_array($order_by)) {
            foreach ($order_by as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        if (is_numeric($offset) && is_numeric($limit)) {
            $this->db->limit($offset, $limit);
        }

        $rs = $this->db->get();
        //echo $this->db->last_query();
        $rs = $rs->result_array();

        return $rs;
    }
    
function truncate($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
    if ($considerHtml) {
            if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                    return $text;
            }

            preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
            $total_length = strlen($ending);
            $open_tags = array();
            $truncate = '';
            foreach ($lines as $line_matchings) {
                    if (!empty($line_matchings[1])) {
                            if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                            } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                                    $pos = array_search($tag_matchings[1], $open_tags);
                                    if ($pos !== false) {
                                    unset($open_tags[$pos]);
                                    }
                            } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                            }
                            $truncate .= $line_matchings[1];
                    }
                    $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
                    if ($total_length+$content_length > $length) {
                            $left = $length - $total_length;
                            $entities_length = 0;
                            if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                                    foreach ($entities[0] as $entity) {
                                            if ($entity[1]+1-$entities_length <= $left) {
                                                    $left--;
                                                    $entities_length += strlen($entity[0]);
                                            } else {
                                                    break;
                                            }
                                    }
                            }
                            $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                            break;
                    } else {
                            $truncate .= $line_matchings[2];
                            $total_length += $content_length;
                    }
                    if($total_length >= $length) {
                            break;
                    }
            }
    } else {
            if (strlen($text) <= $length) {
                    return $text;
            } else {
                    $truncate = substr($text, 0, $length - strlen($ending));
            }
    }
    if (!$exact) {
            $spacepos = strrpos($truncate, ' ');
            if (isset($spacepos)) {
                    $truncate = substr($truncate, 0, $spacepos);
            }
    }
    $truncate .= $ending;
    if($considerHtml) {
            foreach ($open_tags as $tag) {
                    $truncate .= '</' . $tag . '>';
            }
    }
    return $truncate;
}    
        
   
}
function check_demo_admin($redirect_url = '', $default_page = 'page') {
        $CI = & get_instance();
        $class = $CI->router->fetch_class();
		if(in_array($class,explode("|",REDIRECTION)))
		{
			$default_page="index";	
		}
		elseif($class=='member')
		{
			$default_page="member_list";	
		}
		elseif($class=='membership_plan')
		{
			$default_page="membership_plan_list";	
		}
		elseif($class=='project')
		{
			$default_page="open";	
		}
		elseif($class=='faq')
		{
			$default_page="faq_list";	
		}
		elseif($class=='fund' || $class=='settings' )
		{
			$default_page=$CI->router->fetch_method();	
		}
		elseif($class=='adminmenu' || $class=='addnewmenu' )
		{
			$class="menulist";
			$default_page="";	
		}
		elseif($class=='adminuser')
		{
			$default_page="type_list";	
		}
		
		elseif($class=='knowledge')
		{
			$default_page="knowledge_list";	
		}
		elseif($class=='location')
		{
			$default_page="city";	
		}
        if (DEMO) {
            $CI->session->set_flashdata('succ_msg', DEMO_MSG);
            if ($redirect_url == '') {
                redirect(base_url() . $class . '/' . $default_page);
            } else {
                if (strpos($redirect_url, base_url()) == false) {
                    redirect(base_url() . $redirect_url);
                } else {
                    redirect($redirect_url);
                }
            }
        }
    }