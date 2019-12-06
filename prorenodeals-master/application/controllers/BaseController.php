<?php

class BaseController extends CI_Controller{
    function index()
    {
        $this->load->view('user');
    }
    
    function edit($id = '')
    {
       // $this->load->view('user');
    }
	
}