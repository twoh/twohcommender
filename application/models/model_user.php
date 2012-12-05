<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_user extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function add_user()
    {
        $data=array(
            'user_name'=>$this->input->post('user_name'),
            'email'=>$this->input->post('email_address'),
            'user_pass'=>md5($this->input->post('password'))
        );
        $this->db->insert('rs_user',$data);
    }
    
    function login($email,$password)
    {
        $this->db->where("email",$email);
        $this->db->where("user_pass",$password);
        $query=$this->db->get("rs_user");
        if($query->num_rows()>0)
        {
           foreach($query->result() as $rows)
           {
            //add all data to session
            $newdata = array(
              'user_id'  => $rows->id_user,
              'user_name'  => $rows->user_name,
              'user_email'    => $rows->email,
              'logged_in'  => TRUE,
            );
           }
         $this->session->set_userdata($newdata);
         return true;
        }else
        {
            return false;
        }
    }
}

?>
