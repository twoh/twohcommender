<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    class Register extends CI_Controller
        {
                function __construct(){
                        parent::__construct();
                         $this->load->model('model_user');
                }
            
                public function index(){
                    if(($this->session->userdata('user_name')!=""))
                        {
                           $this->welcome();
                        }
                        else{
                           $this->load->view('register');
                        }  
                }
                
                public function thanks(){
                    $data['title'] = 'Terima Kasih Sudah Mendaftar';
                    $this->load->view('thanks',$data);
                }
                
                public function registration(){
                      $this->load->library('form_validation');
                      $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>');
                      $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|min_length[4]|xss_clean');
                      $this->form_validation->set_rules('email_address', 'Your Email', 'trim|required|valid_email');
                      $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
                      $this->form_validation->set_rules('con_password', 'Password Confirmation', 'trim|required|matches[password]');

                      if($this->form_validation->run() == FALSE)
                      {
                       $this->index();
                      }
                      else
                      {
                       $this->model_user->add_user();
                       $this->thanks();
                      }
                }
                public function welcome()
                {
                      $this->load->view('header');
                      $this->load->view('user/welcome');
                      $this->load->view('footer');
                }
                
        }
?>
