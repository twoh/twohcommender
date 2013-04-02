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
    
    public function insert_rating()
    {
        echo $this->input->post('idmk');
        echo $this->input->post('komentar');
        echo $this->input->post('test-4-rating-3');
        echo $this->input->post('iduser');
        
        $data=array(
            'id_mk'=>$this->input->post('idmk'),
            'review'=>$this->input->post('komentar'),
            'rating'=>$this->input->post('test-4-rating-3'),
            'id_user'=>$this->input->post('iduser')
        );
        $this->db->insert('rs_review',$data);
    }
    
    function get_rating_paging($limit, $start)
    {
        //function untuk mengambil paging mata kuliah
        $string_query = "SELECT `nama_mk`, `rating`, `review` FROM `rs_review`,`rs_matakuliah` WHERE `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk` LIMIT ".$start.", ".$limit;
        $query = $this->db->query($string_query);
        return $query;
    }
}

?>
