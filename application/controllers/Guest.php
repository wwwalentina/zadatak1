<?php

class Guest extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("ModelUser");
        $this->load->library('session');
        if (($this->session->userdata('user')) != NULL)
            redirect("User");
    }

    public function index($msg = NULL) {
        $data = array();
        if ($msg) {
            $data['msg'] = $msg;
            $this->load->view("login.php", $data);
        } else {
            $this->load->view("login.php", NULL);
        }
    }

    public function login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run()) {
            $this->ModelUser->username = $this->input->post('username');
            if (!$this->ModelUser->usernameCheck())
                $this->index("Wrong username!");
            else if (!$this->ModelUser->passwordCheck($this->input->post('password')))
                $this->index("Wrong password!");
            else {
                $this->load->library('session');
                $this->session->set_userdata('user', $this->ModelUser);
                redirect("User/home");
            }
        } else
            $this->login();
    }

}
