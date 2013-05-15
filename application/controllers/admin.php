<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin extends CI_Controller {

    function __construct() {
        //konstruktor
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->library('pagination');
    }

    function index() {
        //Memuat halaman index
        if (($this->session->userdata('user_name') == "herdi")) {
            $this->load->view('header');
            $this->load->view('admin/index');
            $this->load->view('footer');
        } else {
            $this->login();
        }
    }

    function login() {
        //Memuat halaman Login Admin
        if (($this->session->userdata('user_name') == "herdi")) {
            redirect('admin/index');
        } else {
            $this->load->view('header');
            $this->load->view('admin/login');
            $this->load->view('footer');
        }
    }

    public function do_login() {
        //Melakukan aksi login
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $result = $this->model_admin->login($email, $password);
        //echo $password;
        //echo $email;
        if ($result) {

            redirect('admin/index');
            //echo 'login here';
        }
        else
            $this->login();
    }

    public function logout() {
        //Fungsi Logout Admin
        $newdata = array(
            'user_id' => '',
            'user_name' => '',
            'user_email' => '',
            'logged_in' => FALSE,
        );
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        redirect('');
    }

    // FOR EDITING
    function data_home() {
        //Melihat data halaman utama
        if (($this->session->userdata('user_name') == "herdi"))
            $this->load->view('admin/admin_home');
        else
            $this->login();
    }

    function data_pengguna() {
        //Melihat data pengguna
        if (($this->session->userdata('user_name') == "herdi")) {
            $this->load->view('admin/admin_pg');
        }else
            $this->login();
    }

    function data_matakuliah() {
        //Melihat data mata kuliah
        if (($this->session->userdata('user_name') == "herdi")) {
            $this->load->view('admin/admin_mk');
        }
        else
            $this->login();
    }

     public function lihat_mk() {
        if (($this->session->userdata('user_name') == "herdi")) {
        //MELIHAT DATA MATA KULIAH <PAGING VERSION>
        $string_query = "select * from rs_matakuliah";
        $query = $this->db->query($string_query);
        $config = array();
        $config['total_rows'] = $query->num_rows();
        $config['per_page'] = '7';
        $config['uri_segment'] = 3;
        $config['num_links'] = 2;
        $config['base_url'] = base_url() . 'admin/lihat_mk';
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="disabled"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        //$num = $config['per_page'];
        $offset = $this->uri->segment(3);

        //$offset = ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset; 
        if (empty($offset)) {
            $offset = 0;
        }

        $data['results'] = $this->model_admin->get_mk_paging($config['per_page'], $offset);
        $data['links'] = $this->pagination->create_links();
        $this->load->view('header');
        $this->load->view('admin/admin_matakuliah', $data);
        $this->load->view('footer');
        }
        else
            $this->login ();
    }
    
    function insert_mk() {
        //Meload Halaman Insert Mata Kuliah
        if (($this->session->userdata('user_name') == "herdi"))
            $this->load->view('admin/insert/mata_kuliah');
        else
            $this->login();
    }

    function edit_mk() {
        //Meload Halaman edit mata kuliah
        if (($this->session->userdata('user_name') == "herdi")) {
            $id = $this->input->post('edit_mk');
            //echo 'IDE SAMA DENGAN'.$id;
            $this->db->where('id_mk', $id);
            $query = $this->db->get("rs_matakuliah");
            if ($query->num_rows() > 0) {
                $data['mk'] = $query;
                $this->load->view('admin/edit/mata_kuliah', $data);
            } else {
                echo 'dataempty';
            }
        }
        else
            $this->login();
    }

    function do_edit_mk() {
        //Melakukan update mata kuliah
        $this->load->library('form_validation');
        $this->form_validation->set_rules('namamk', 'Nama Matakuliah', 'trim|required|min_length[4]|xss_clean|max_length[75]');
        $this->form_validation->set_rules('sks', 'SKS', 'trim|required|min_length[1]|max_length[1]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi MK', 'trim|required|min_length[0]|max_length[1400]');
        $this->form_validation->set_rules('kk', 'Kelompok Keahlian', 'trim|required|min_length[3]|max_length[4]');
        if ($this->form_validation->run() == FALSE) {
//            echo 'salaaah';
            redirect('admin/lihat_mk');
        } else {
//                        $id = $this->input->post('idmk');
//                        $nama = $this->input->post('namamk');
//                        $sks = $this->input->post('sks');
//                        $deskripsi = $this->input->post('deskripsi');
//                        echo $id;
//                        echo $nama;
//                        echo $deskripsi;
//                        echo $sks;
            $this->model_admin->update_mk();
            redirect('admin/lihat_mk');
//            echo 'sukses';
//            echo 'dijalankan';
        }
    }

    function do_insert_mk() {
        //Melakukan insert mata kuliah
        $this->load->library('form_validation');
        $this->form_validation->set_rules('namamk', 'Nama Matakuliah', 'trim|required|min_length[4]|xss_clean|max_length[75]');
        $this->form_validation->set_rules('sks', 'SKS', 'trim|required|min_length[1]|max_length[1]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi MK', 'trim|required|min_length[0]|max_length[140]');
        $this->form_validation->set_rules('kk', 'Kelompok Keahlian', 'trim|required|min_length[3]|max_length[4]');
        if ($this->form_validation->run() == FALSE) {
            redirect('admin/lihat_mk');
        } else {
            $this->model_admin->insert_mk();
            redirect('admin/lihat_mk');
        }
    }

    function delete_mk() {
        //fungsi untuk menghapus mata kuliah
        $id = $this->input->post('edit_mk');
        $this->db->where('id_mk', $id);
        $this->db->delete('rs_matakuliah');
        $this->load->view('admin/delete/mata_kuliah');
    }
    
    function delete_user() {
        //fungsi untuk menghapus mata kuliah
        $id = $this->input->post('edit_user');
        $this->db->where('id_user', $id);
        $this->db->delete('rs_user');
        $this->load->view('admin/delete/pengguna');
    }

    function insert_user() {
        //Meload Halaman Insert User
        if (($this->session->userdata('user_name') == "herdi"))
            $this->load->view('admin/insert/pengguna');
        else
            $this->login();
    }

    function edit_user() {
        //Meload Halaman edit pengguna
        if (($this->session->userdata('user_name') == "herdi")) {
            $id = $this->input->post('edit_user');
            //echo 'IDE SAMA DENGAN'.$id;
            $this->db->where('id_user', $id);
            $query = $this->db->get("rs_user");
            if ($query->num_rows() > 0) {
                $data['users'] = $query;
                $this->load->view('admin/edit/pengguna', $data);
            } else {
                echo 'dataempty';
            }
        }
        else
            $this->login();
    }
    
    function do_edit_user() {
        //Melakukan update mata kuliah
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>');
        $this->form_validation->set_rules('username', 'User Name', 'trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('email', 'Your Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
//            echo 'salaaah';
            redirect('admin/lihat_pengguna');
        } else {
            $this->model_admin->update_user();
            redirect('admin/lihat_pengguna');
//            echo 'sukses';
//            echo 'dijalankan';
        }
    }
    
    public function do_insert_user() {
        //Melakukan insert user
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>');
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('email_address', 'Your Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        if ($this->form_validation->run() == FALSE) {
            redirect('admin/lihat_pengguna');
        } else {
            $this->model_admin->insert_user();
            redirect('admin/lihat_pengguna');
        }
    }

    public function lihat_pengguna() {
        if (($this->session->userdata('user_name') == "herdi")) {
            //MELIHAT DATA PENGGUNA <PAGING VERSION>
            $string_query = "select * from rs_user";
            $query = $this->db->query($string_query);
            $config = array();
            $config['total_rows'] = $query->num_rows();
            $config['per_page'] = '10';
            $config['uri_segment'] = 3;
            $config['num_links'] = 2;
            $config['base_url'] = base_url() . 'admin/lihat_pengguna';
            $config['full_tag_open'] = '<ul>';
            $config['full_tag_close'] = '</ul>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="disabled"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $this->pagination->initialize($config);
            //$num = $config['per_page'];
            $offset = $this->uri->segment(3);

            //$offset = ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset; 
            if (empty($offset)) {
                $offset = 0;
            }
            $data['results'] = $this->model_admin->get_user_paging($config['per_page'], $offset);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('header');
            $this->load->view('admin/admin_pengguna', $data);
            $this->load->view('footer');
        }
        else
            $this->login();
    }
    
    function test_accuration()
    {                                        
        require_once 'ItemBased.php';
        // tempat menyimpan hasil rating sistem
        $system_ratings = array();
        $actual_ratings = array();
        $total = 0;
        $mk = "Data Mining";
        $result = mysql_query(
                "SELECT `id_user`, `rating`,`nama_mk` 
                FROM `rs_review`,`rs_matakuliah`
                WHERE `rs_matakuliah`.`id_mk` = `rs_review`.`id_mk` and `rating` > 0 
                ORDER BY `rs_review`.`id_user` ASC;");
        $ratings = array();
        while ($row = mysql_fetch_array($result)) 
        {
            $userID = $row{'id_user'};
            $ratings[$userID][$row{'nama_mk'}] =  $row{'rating'};               
        }
        //print_r($ratings);
        //echo "<br>";
        $recommend = new ItemBased();
        $transform = $recommend->transformPreferences($ratings);                    
        $similiarity = $recommend->generateSimilarities($transform);
        //$recom = $recommend->recommend(13, $transform, $similiarity,10);                                        
        $users = $recommend->getUserByMK($mk);

        $jumlah_user = count($users);

        for($i = 0; $i < $jumlah_user; $i++)
        {
            $system_ratings[$users[$i]] = $recommend->accuration($users[$i], $transform, $similiarity,$mk);
        }

        for($i = 0; $i < $jumlah_user; $i++)
        {
            $actual_ratings[$users[$i]] = $recommend->getRatingByUserMK($users[$i], $mk);
        }
        for($i = 0; $i < $jumlah_user; $i++)
        {
            //echo $total."<br>";
            $total += abs($system_ratings[$users[$i]] - $actual_ratings[$users[$i]]);                        
        }

        $accuration = $total / $jumlah_user;

        $data['accuration'] = $accuration;
        $data['aktual'] = $actual_ratings;
        $data['prediksi'] = $system_ratings;
        $data['mk'] = $mk;
        $this->load->view('header');
        $this->load->view('admin/admin_view_accuration', $data);
        $this->load->view('footer');
        /*echo "<br>Mata kuliah : <br>";
        print_r($mk);
        echo "<br>Sistem rating<br>";
        print_r($system_ratings);
        echo "<br>Aktual rating<br>";
        print_r($actual_ratings);
        echo "<br>Akurasi sistem<br>";
        print_r($accuration);*/

        //$data['recom'] = $recom;
        //$this->load->view('header');
        //$this->load->view('user/user_view_rekomendasi', $data);
        //$this->load->view('footer');
    }
    
    function get_recommendation()
    {
        //Mendapatkan rekomendasi
        require_once 'ItemBased.php';
        $user_id = $_GET['id'];
        $result = mysql_query(
                "SELECT `id_user`, `rating`,`nama_mk` 
                FROM `rs_review`,`rs_matakuliah`
                WHERE `rs_matakuliah`.`id_mk` = `rs_review`.`id_mk` and `rating` > 0 
                ORDER BY `rs_review`.`id_user` ASC;");
        $ratings = array();
        while ($row = mysql_fetch_array($result)) 
        {
            $userID = $row{'id_user'};
            $ratings[$userID][$row{'nama_mk'}] =  $row{'rating'};               
        }
        //print_r($ratings);
        //echo "<br>";
        $recommend = new ItemBased();
        $transform = $recommend->transformPreferences($ratings);                    
        $similiarity = $recommend->generateSimilarities($transform);
        $recom = $recommend->recommend($user_id, $transform, $similiarity,10);
        //print_r($recom);
        $data['recom'] = $recom;
        $this->load->view('header');
        $this->load->view('admin/admin_view_rekomendasi', $data);
        $this->load->view('footer');
    }

}

?>
