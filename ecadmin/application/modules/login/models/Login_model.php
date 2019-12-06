<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

    public function logincheck() {
        $username = htmlentities(strip_tags(trim($this->input->post("username"))), ENT_QUOTES);
        $password = $this->input->post("password");
        $response = array();
        $this->db->select('admin_id,  username, email,type,last_login,password');
        $query = $this->db->get_where("admin", array("username" => $username, "password" => md5($password), "status" => 'Y'));
        $result = $query->row();
		//print_r()
        if (count($result) == 0) {
            $response['status'] = "error";
        } else {
            $response['status'] = "success";
            $this->session->set_userdata('user', $result);
	    $this->session->set_userdata('yellow_user_id', $result);	
            $remember = $this->input->post('remember');
            if ($remember == 1) {
                $this->load->helper('cookie');
                $user_cookie = array(
                    'name' => 'tsk_adm_uname',
                    'value' => $username,
                    'expire' => '86500',
                    'domain' => '192.168.0.123',
                    //'domain' => 'lab4.oneoutsource.com',
                    'path' => '/',
                    'prefix' => 'mrt_',
                );

                $this->input->set_cookie($user_cookie);
                
                $pwd_cookie = array(
                    'name' => 'tsk_adm_pwd',
                    'value' => $username,
                    'expire' => '86500',
                    'domain' => '192.168.0.123',
                    //'domain' => 'lab4.oneoutsource.com',
                    'path' => '/',
                    'prefix' => 'mrt_',
                );

                $this->input->set_cookie($pwd_cookie);
            }else
            {
                $this->load->helper('cookie');
                delete_cookie("mrt_tsk_adm_uname");
                delete_cookie("mrt_tsk_adm_pwd");
            }
        }
        return $response;
    }

    public function forgot() {
        //$username = trim($this->input->post("user"));
        $email = htmlentities(strip_tags(trim($this->input->post("email"))), ENT_QUOTES);
        $response = array();
        $this->db->select('admin_id');
        $query = $this->db->get_where("admin", array("email" => $email));

        $result = $query->row();
        if (count($result) == 0) {
            $response['status'] = "error";
        } else {
            $response['status'] = "success";
            //update pass send mail;
            $pass = rand();
            $data = array(
                'password' => md5($pass)
            );
            $this->db->update('admin', $data, array("email" => $email));
            $this->load->library('email');
            // echo ADMIN_EMAIL;exit;
            $this->email->from(ADMIN_EMAIL, 'Admin');
            $this->email->to($email);
            $this->email->subject('Reset your password');
            $this->email->message('your password has been changed.new password:' . $pass);

            $this->email->send();
        }
        return $response;
    }


}
