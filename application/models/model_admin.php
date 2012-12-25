<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_admin extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    function login($email,$password)
    {
        $this->db->where("email",$email);
        $this->db->where("password",$password);
        $query=$this->db->get("rs_admin");
        if($query->num_rows()>0)
        {
           foreach($query->result() as $rows)
           {
            //add all data to session
            $newdata = array(
              'user_id'  => $rows->id_admin,
              'user_name'  => $rows->username,
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
    
    function get_all_user()
    {
        //Mengambil semua data pengguna
        $query = $this->db->get('rs_user');
        return $query;
    }
    
    public function insert_user()
    {
        //Menambahkan pengguna baru
        $data=array(
            'user_name'=>$this->input->post('user_name'),
            'email'=>$this->input->post('email_address'),
            'user_pass'=>md5($this->input->post('password'))
        );
        $this->db->insert('rs_user',$data);
    }
    
    public function insert_mk()
    {
        /*echo $this->input->post('namamk');
        echo $this->input->post('sks');
        echo $this->input->post('deskripsi');
        echo $this->input->post('kk');*/
        $data=array(
            'nama_mk'=>$this->input->post('namamk'),
            'sks'=>$this->input->post('sks'),
            'deskripsi'=>$this->input->post('deskripsi'),
            'kelompok_keahlian'=>$this->input->post('kk')
        );
        $this->db->insert('rs_matakuliah',$data);
    }
    
    function get_all_mk()
    {
        $query = $this->db->get('rs_matakuliah');
        return $query;
    }
    
    function get_mk_paging($limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get('rs_matakuliah');
        return $query;
    }
    
    function update_mk()
    {
        $id = $this->input->post('idmk');
        echo 'id = '.$id;
        if($id!=NULL)
        {
            $data = array(
            'nama_mk'=>$this->input->post('namamk'),
            'sks'=>$this->input->post('sks'),
            'deskripsi'=>$this->input->post('deskripsi'),
            'kelompok_keahlian'=>$this->input->post('kk')
            );
            $this->db->where('id_mk', $id);
            $this->db->update('rs_matakuliah', $data); 
        }else
        {
            echo 'nggak ada data';
        }
    }
}

?>
