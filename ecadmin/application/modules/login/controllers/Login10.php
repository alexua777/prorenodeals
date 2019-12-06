<?php

class Login extends MX_Controller {

    function index() {
        $data['error'] = "";
        $this->load->helper('cookie');
        $data['username'] = get_cookie('mrt_tsk_adm_uname');
        $data['password'] = get_cookie('mrt_tsk_adm_pwd');
	    $data['up_logo'] = $this->auto_model->getfeild("site_logo","setting","id",45);
        $this->load->view('login', $data);
    }

    function loginprocess() {
        $data['up_logo'] = $this->auto_model->getfeild("site_logo","setting","id",45);
        if ($this->input->post('login_val') == 1) {

            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = "";
                $this->load->view('login', $data);
            } else {
                $this->load->model('login_model');
                $result = $this->login_model->logincheck();
                $response = $result;
                if ($response['status'] == "success") {
                        //redirect(VPATH, "refesh");
                    //redirect(VPATH);
                    ?>
                    <script>window.parent.location.href = "<?php echo VPATH; ?>"</script>
                    <?
                    //redirect(base_url());
                } else {
                    $data['error'] = "Error in username or password";
                    $this->load->view('login', $data);
                }
            }
        } else {
            $data['error'] = "";
            $this->load->view('login', $data);
        }
    }

    function forgotpass() {
        $data['success'] = "";
        $data['error'] = "";
		$data['up_logo'] = $this->auto_model->getfeild("site_logo","setting","id",45);
        if ($this->input->post('forgot_val') == 1) {

            $this->load->library('form_validation');
            $this->form_validation->set_rules('user', 'Username', 'required');
            $this->form_validation->set_rules('email', 'Password', 'required|valid_email');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = "";
                $this->load->view('forgotpass', $data);
            } else {
                $this->load->model('login_model');
                $result = $this->login_model->forgot();
                $response = $result;

                if ($response['status'] == "success") {
                    $data['success'] = "Mail send to your email";
                    $this->load->view('forgotpass', $data);
                } else {
                    $data['error'] = "Error in username or password";
                    $this->load->view('forgotpass', $data);
                }
            }
        } else {
            $data['error'] = "";
            $this->load->view('forgotpass', $data);
        }
    }

    public function logout() {
        $this->session->unset_userdata('user');
        redirect(VPATH . "login");
    }
	
	
	
	
	
	

}
