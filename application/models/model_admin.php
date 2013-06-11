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
            'kode_mk'=>$this->input->post('kodemk'),
            'nama_mk'=>$this->input->post('namamk'),
            'sks'=>$this->input->post('sks'),
            'deskripsi'=>$this->input->post('deskripsi'),
            'kelompok_keahlian'=>$this->input->post('kk')
        );
        $this->db->insert('rs_matakuliah',$data);
    }
    
    public function insert_mk_wajib()
    {
        /*echo $this->input->post('namamk');
        echo $this->input->post('sks');
        echo $this->input->post('deskripsi');
        echo $this->input->post('kk');*/
        $data=array(
            'kode_mk'=>$this->input->post('kodemk'),
            'nama_mk'=>$this->input->post('namamk'),
            'sks'=>$this->input->post('sks'),
            'deskripsi'=>$this->input->post('deskripsi'),
            'kelompok_keahlian'=>$this->input->post('kk')
        );
        $this->db->insert('rs_mk_wajib',$data);
    }
    
    function get_all_mk()
    {
        $query = $this->db->get('rs_matakuliah');
        return $query;
    }
    
    function get_mk_paging($limit, $start)
    {
        //function untuk mengambil paging mata kuliah
        $this->db->limit($limit, $start);
        $this->db->where('`id_mk` NOT IN (SELECT `id_mk` FROM `rs_review` WHERE `rs_review`.`id_user` = '.$this->session->userdata('user_id').' AND `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk`)', NULL, FALSE);
        $query = $this->db->get('rs_matakuliah');
        return $query;
    }
    
    function get_mk_adm_paging($limit, $start)
    {
        //function untuk mengambil paging mata kuliah
        $this->db->limit($limit, $start);
        //$this->db->where('`id_mk` NOT IN (SELECT `id_mk` FROM `rs_review` WHERE `rs_review`.`id_user` = '.$this->session->userdata('user_id').' AND `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk`)', NULL, FALSE);
        $query = $this->db->get('rs_matakuliah');
        return $query;
    }
    
    function get_mk_wajib_paging($limit, $start)
    {
        //function untuk mengambil paging mata kuliah
        $this->db->limit($limit, $start);
       //$this->db->where('`id_mk` NOT IN (SELECT `id_mk` FROM `rs_review` WHERE `rs_review`.`id_user` = '.$this->session->userdata('user_id').' AND `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk`)', NULL, FALSE);
        $query = $this->db->get('rs_mk_wajib');
        return $query;
    }
    
    function get_user_paging($limit, $start)
    {
        //function untuk mengambil paging pengguna
        $this->db->limit($limit, $start);
        $query = $this->db->get('rs_user');
        return $query;
    }
    
    function update_mk()
    {
        $id = $this->input->post('idmk');
        //echo 'id = '.$id;
        if($id!=NULL)
        {
            $data = array(
            'nama_mk'=>$this->input->post('namamk'),
            'sks'=>$this->input->post('sks'),
            'deskripsi'=>$this->input->post('deskripsi'),
            'jenis_mk'=>$this->input->post('jenismk'),
            'kode_mk'=>$this->input->post('kodemk'),
            'kelompok_keahlian'=>$this->input->post('kk')
            );
            $this->db->where('id_mk', $id);
            $this->db->update('rs_matakuliah', $data); 
        }else
        {
            echo 'nggak ada data';
        }
    }
    
    function update_mk_wajib()
    {
        $id = $this->input->post('idmk');
        //echo 'id = '.$id;
        if($id!=NULL)
        {
            $data = array(
            'nama_mk'=>$this->input->post('namamk'),
            'sks'=>$this->input->post('sks'),
            'deskripsi'=>$this->input->post('deskripsi'),            
            'kode_mk'=>$this->input->post('kodemk'),
            'kelompok_keahlian'=>$this->input->post('kk')
            );
            $this->db->where('id_mk', $id);
            $this->db->update('rs_mk_wajib', $data); 
        }else
        {
            echo 'nggak ada data';
        }
    }
    
    function update_user()
    {
        $id = $this->input->post('id_user');
        echo 'id = '.$id;
        if($id!=NULL)
        {
            $data = array(
            'user_name'=>$this->input->post('username'),
            'email'=>$this->input->post('email'),
            );
            $this->db->where('id_user', $id);
            $this->db->update('rs_user', $data); 
        }else
        {
            echo 'nggak ada data';
        }
    }
}

?>
