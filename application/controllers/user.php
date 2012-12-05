<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 class User extends CI_Controller
        {
                function __construct(){
                        parent::__construct();
                         $this->load->model('model_user');
                }
                public function logout()
                {
                  $newdata = array(
                  'user_id'   =>'',
                  'user_name'  =>'',
                  'user_email'     => '',
                  'logged_in' => FALSE,
                  );
                  $this->session->unset_userdata($newdata );
                  $this->session->sess_destroy();
                   redirect('');
                }
        }
?>


