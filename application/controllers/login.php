<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    class Login extends CI_Controller
        {
                
                function __construct()
                {
                        parent::__construct();
                        $this->load->model('model_user');
                }
        
                public function index()
				{
                        if(($this->session->userdata('user_name')!=""))
                        {
                           $this->welcome();
                        }
                        else{
                           $this->load->view('login');
                        }
                }
                
                public function do_login()
                {
                      $email=$this->input->post('email');
                      $password=md5($this->input->post('password'));
                      $result=$this->model_user->login($email,$password);
                      //echo $password;
                      //echo $email;
                      if($result) 
                      {
                          $this->welcome();
                        //  echo 'login here';
                      
                      }
                      else        $this->index();
                }
                
                public function welcome()
                {
                      $this->load->view('header');
                      $this->load->view('user/welcome');
                      $this->load->view('footer');
                }
        }
?>
