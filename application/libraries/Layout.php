<?php

class Layout {

    private $CI;
    private $layout_title = NULL;
    private $layout_description = NULL;
    private $data;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function set_title($title) {
        $this->layout_title = $title;
    }

    public function set_description($description) {
        $this->layout_description = $description;
    }

    public function set_assest($params) {
        $this->data = $params;
    }

    public function view($view_name, $layouts = array(), $params = array(), $default = '', $include_search='Y') {
        if (is_array($layouts) && count($layouts) >= 1) {
            foreach ($layouts as $layout_key => $layout) {
                $params[$layout_key] = $this->CI->load->view($layout, $params, true);
            }
        }

        if ($default == 'normal') {
            $this->CI->load->view('inc/scriptsrc', $this->data);
			$this->CI->load->view('inc/header', $this->data);
			$this->CI->load->view($view_name, $params);
			$this->CI->load->view('inc/footer',$this->data);
        } elseif ($default == 'ajax') {
            //$this->CI->load->view('inc/header_blank', $this->data);
            $this->CI->load->view($view_name, $params);
        }elseif ($default == 'include') {
            $this->CI->load->view($view_name, $params);
        }elseif ($default == 'us') {
			$this->CI->load->model('user/user_model');
            $this->CI->load->view('inc/header', $this->data);
			$this->CI->load->view('inc/userleft', $this->data);
            $this->CI->load->view($view_name, $params);
            $this->CI->load->view('inc/footer', $this->data);
        }
		elseif ($default == 'feed') {
            $this->CI->load->view($view_name, $params);
        }
    }

}

?>