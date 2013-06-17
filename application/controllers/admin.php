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
        $this->load->model('model_user');
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

    function data_mk_wajib() {
        //Melihat data mata kuliah
        if (($this->session->userdata('user_name') == "herdi")) {
            $this->load->view('admin/admin_mk_wajib');
        }
        else
            $this->login();
    }

    public function lihat_mk_wajib() {
        if (($this->session->userdata('user_name') == "herdi")) {
            //MELIHAT DATA MATA KULIAH <PAGING VERSION>
            $string_query = "select * from rs_mk_wajib";
            $query = $this->db->query($string_query);
            $config = array();
            $config['total_rows'] = $query->num_rows();
            $config['per_page'] = '7';
            $config['uri_segment'] = 3;
            $config['num_links'] = 2;
            $config['base_url'] = base_url() . 'admin/lihat_mk_wajib';
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

            $data['results'] = $this->model_admin->get_mk_wajib_paging($config['per_page'], $offset);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('header');
            $this->load->view('admin/admin_view_mk_wajib', $data);
            $this->load->view('footer');
        }
        else
            $this->login();
    }

    function edit_mk_wajib() {
        //Meload Halaman edit mata kuliah
        if (($this->session->userdata('user_name') == "herdi")) {
            $id = $this->input->post('edit_mk');
            //echo 'IDE SAMA DENGAN'.$id;
            $this->db->where('id_mk', $id);
            $query = $this->db->get("rs_mk_wajib");
            if ($query->num_rows() > 0) {
                $data['mk'] = $query;
                $this->load->view('admin/edit/mk_wajib', $data);
            } else {
                echo 'dataempty';
            }
        }
        else
            $this->login();
    }

    function do_edit_mk_wajib() {
        //Melakukan update mata kuliah
        if (($this->session->userdata('user_name') == "herdi")) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('namamk', 'Nama Matakuliah', 'trim|required|min_length[4]|xss_clean|max_length[75]');
            $this->form_validation->set_rules('sks', 'SKS', 'trim|required|min_length[1]|max_length[1]');
            $this->form_validation->set_rules('deskripsi', 'Deskripsi MK', 'trim|required|min_length[0]|max_length[1400]');
            if ($this->form_validation->run() == FALSE) {
//            echo 'salaaah';
                redirect('admin/lihat_mk_wajib');
            } else {
//                        $id = $this->input->post('idmk');
//                        $nama = $this->input->post('namamk');
//                        $sks = $this->input->post('sks');
//                        $deskripsi = $this->input->post('deskripsi');
//                        echo $id;
//                        echo $nama;
//                        echo $deskripsi;
//                        echo $sks;
                $this->model_admin->update_mk_wajib();
                redirect('admin/lihat_mk_wajib');
//            echo 'sukses';
//            echo 'dijalankan';
            }
        }
        else
            $this->login();
    }

    function delete_mk_wajib() {
        //fungsi untuk menghapus mata kuliah
        if (($this->session->userdata('user_name') == "herdi")) {
            $id = $this->input->post('edit_mk');
            $this->db->where('id_mk', $id);
            $this->db->delete('rs_mk_wajib');
            $this->load->view('admin/delete/mata_kuliah');
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

            $data['results'] = $this->model_admin->get_mk_adm_paging($config['per_page'], $offset);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('header');
            $this->load->view('admin/admin_matakuliah', $data);
            $this->load->view('footer');
        }
        else
            $this->login();
    }

    function insert_mk_wajib() {
        //Meload Halaman Insert Mata Kuliah
        if (($this->session->userdata('user_name') == "herdi"))
            $this->load->view('admin/insert/mk_wajib');
        else
            $this->login();
    }

    function do_insert_mk_wajib() {
        //Melakukan insert mata kuliah
        if (($this->session->userdata('user_name') == "herdi")) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('namamk', 'Nama Matakuliah', 'trim|required|min_length[4]|xss_clean|max_length[75]');
            $this->form_validation->set_rules('sks', 'SKS', 'trim|required|min_length[1]|max_length[1]');
            $this->form_validation->set_rules('deskripsi', 'Deskripsi MK', 'trim|required|min_length[0]|max_length[140]');
            if ($this->form_validation->run() == FALSE) {
                redirect('admin/lihat_mk');
            } else {
                $this->model_admin->insert_mk_wajib();
                redirect('admin/lihat_mk_wajib');
            }
        }
        else
            $this->login();
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
        if (($this->session->userdata('user_name') == "herdi")) {
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
        else
            $this->login();
    }

    function do_insert_mk() {
        //Melakukan insert mata kuliah
        if (($this->session->userdata('user_name') == "herdi")) {
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
        else
            $this->login();
    }

    function delete_mk() {
        //fungsi untuk menghapus mata kuliah
        if (($this->session->userdata('user_name') == "herdi")) {
            $id = $this->input->post('edit_mk');
            $this->db->where('id_mk', $id);
            $this->db->delete('rs_matakuliah');
            $this->load->view('admin/delete/mata_kuliah');
        }
        else
            $this->login();
    }

    function delete_user() {
        if (($this->session->userdata('user_name') == "herdi")) {
            //fungsi untuk menghapus mata kuliah
            $id = $this->input->post('edit_user');
            $this->db->where('id_user', $id);
            $this->db->delete('rs_user');
            $this->load->view('admin/delete/pengguna');
        }
        else
            $this->login();
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
        if (($this->session->userdata('user_name') == "herdi")) {
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
        else
            $this->login();
    }

    public function do_insert_user() {
        //Melakukan insert user
        if (($this->session->userdata('user_name') == "herdi")) {
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
        else
            $this->login();
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

    function cf_accuration() {
        //Akurasi MAE
        require_once 'ItemBased.php';
        // tempat menyimpan hasil rating sistem
        $system_ratings = array();
        $actual_ratings = array();
        $total = 0;
        $mk = "Rekayasa Aplikasi Internet";
        $result = mysql_query(
                "SELECT `id_user`, `rating`,`nama_mk` 
                FROM `rs_review`,`rs_matakuliah`
                WHERE `rs_matakuliah`.`id_mk` = `rs_review`.`id_mk` and `rating` > 0 
                ORDER BY `rs_review`.`id_user` ASC;");
        $ratings = array();
        while ($row = mysql_fetch_array($result)) {
            $userID = $row{'id_user'};
            $ratings[$userID][$row{'nama_mk'}] = $row{'rating'};
        }
        //print_r($ratings);
        //echo "<br>";
        $recommend = new ItemBased();
        $transform = $recommend->transformPreferences($ratings);
        $similiarity = $recommend->generateSimilarities($transform);
        //$recom = $recommend->recommend(13, $transform, $similiarity,10);                                        
        $users = $recommend->getUserByMK($mk);

        $jumlah_user = count($users);

        for ($i = 0; $i < $jumlah_user; $i++) {
            $system_ratings[$users[$i]] = $recommend->accuration($users[$i], $transform, $similiarity, $mk);
        }

        for ($i = 0; $i < $jumlah_user; $i++) {
            $actual_ratings[$users[$i]] = $recommend->getRatingByUserMK($users[$i], $mk);
        }
        for ($i = 0; $i < $jumlah_user; $i++) {
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
        /* echo "<br>Mata kuliah : <br>";
          print_r($mk);
          echo "<br>Sistem rating<br>";
          print_r($system_ratings);
          echo "<br>Aktual rating<br>";
          print_r($actual_ratings);
          echo "<br>Akurasi sistem<br>";
          print_r($accuration); */

        //$data['recom'] = $recom;
        //$this->load->view('header');
        //$this->load->view('user/user_view_rekomendasi', $data);
        //$this->load->view('footer');
    }
    
    function get_recommendation() {
        //Mendapatkan rekomendasi collaborative filtering
        if (($this->session->userdata('user_name') == "herdi")) {
            require_once 'ItemBased.php';
            $user_id = $_GET['id'];
            $result = mysql_query(
                    "SELECT `id_user`, `rating`,`nama_mk` 
                FROM `rs_review`,`rs_matakuliah`
                WHERE `rs_matakuliah`.`id_mk` = `rs_review`.`id_mk` and `rating` > 0 
                ORDER BY `rs_review`.`id_user` ASC;");
            $ratings = array();
            while ($row = mysql_fetch_array($result)) {
                $userID = $row{'id_user'};
                $ratings[$userID][$row{'nama_mk'}] = $row{'rating'};
            }
            //print_r($ratings);
            //echo "<br>";
            $recommend = new ItemBased();
            $transform = $recommend->transformPreferences($ratings);
            $similiarity = $recommend->generateSimilarities($transform);
            $recom = $recommend->recommend($user_id, $transform, $similiarity, 10);
            //print_r($recom);
            $data['recom'] = $recom;
            $this->load->view('header');
            $this->load->view('admin/admin_view_rekomendasi', $data);
            $this->load->view('footer');
        }
        else
            $this->login();
    }

    function get_cf_recommendation_full() {
        //Mendapatkan akurasi precision recall Content based
        if (($this->session->userdata('user_name') == "herdi")) {
            require_once 'ItemBased.php';
            require_once 'ContentBased.php';
            $user_id = $this->getUsers();
            $result = mysql_query(
                    "SELECT `id_user`, `rating`,`nama_mk` 
                FROM `rs_review`,`rs_matakuliah`
                WHERE `rs_matakuliah`.`id_mk` = `rs_review`.`id_mk` and `rating` > 0 
                ORDER BY `rs_review`.`id_user` ASC;");
            $recommend = new ItemBased();
            $recommendCB = new ContentBased();
            $ratings = array();
            $recom = array();
            $totalUsers = count($user_id);
            for ($i = 0; $i < $totalUsers; $i++) {
                while ($row = mysql_fetch_array($result)) {
                    $userID = $row{'id_user'};
                    $ratings[$userID][$row{'nama_mk'}] = $row{'rating'};
                }
                //print_r($ratings);
                //echo "<br>";            
                $transform = $recommend->transformPreferences($ratings);
                $similiarity = $recommend->generateSimilarities($transform);
                $recom[$i] = $recommend->full_recommend($user_id[$i], $transform, $similiarity, 20);
                $user_rating = $recommendCB->getuserMkRating($user_id[$i]);
                $relevant = array_intersect($recom[$i], $user_rating);
                //print_r($recom[$i]);
                //print_r($user_rating);

                $jumlahS[$user_id[$i]] = count($relevant);
                $jumlahM[$user_id[$i]] = count($recom[$i]);
                $jumlahR[$user_id[$i]] = count($user_rating);
                $precision[$user_id[$i]] = count($relevant) / count($recom[$i]);
                $recall[$user_id[$i]] = count($relevant) / count($user_rating);
                //print_r($recom[$i]);
                //$data['recom'] = $recom;
            }
            $data['similar'] = $jumlahS;
            $data['total'] = $jumlahM;
            $data['relevan'] = $jumlahR;
            $data['precision'] = $precision;
            $data['recall'] = $recall;

            //print_r($precision);
            //print_r($recall);
            $this->load->view('header');
            $this->load->view('admin/admin_view_cf_precision_recall', $data);
            $this->load->view('footer');
        }
        else
            $this->login();
    }

    function getUsers() {
        /* $query = "SELECT `id_user` 
          FROM `rs_review`
          WHERE `id_user` > 29
          GROUP BY(`id_user`)
          ORDER BY count(`id_mk`) DESC
          LIMIT 0, 20";
          $result = mysql_query($query); */
        $users = array(101, 118, 84, 137, 57, 59, 91, 129, 98, 31, 51, 67, 100, 116, 36, 103, 90, 124, 76, 92);
        /* while ($row = mysql_fetch_array($result)) {
          $users[] = $row{'id_user'};
          } */
        return $users;
    }

    function getKeywordMKWajib() {
        if (($this->session->userdata('user_name') == "herdi")) {
            $string_query = "SELECT `kode_mk`, `deskripsi` FROM `rs_mk_wajib`";
            $query = $this->db->query($string_query);
            $data['results'] = $query;
            $this->load->view('header');
            $this->load->view('admin/admin_view_keyword', $data);
            $this->load->view('footer');
        }
        else
            $this->login();
    }    

    function getKeywordMKPilihan() {
        if (($this->session->userdata('user_name') == "herdi")) {
            $string_query = "SELECT `kode_mk`, `deskripsi` FROM `rs_matakuliah`";
            $query = $this->db->query($string_query);
            $data['results'] = $query;
            $this->load->view('header');
            $this->load->view('admin/admin_view_keyword', $data);
            $this->load->view('footer');
        }
        else
            $this->login();
    }

    public function showAllHistoriNilai() {
        // Melihat data histori nilai dari mahasiswa bersangkutan
        if (($this->session->userdata('user_name') == "herdi")) {
            $userID = $this->getUsers();
            $userCount = count($userID);
            for ($i = 0; $i < $userCount; $i++) {
                $user_ID = $userID[$i];
                $string_query = "SELECT `kode_mk`, `nama_mk`, 
             CASE 
                  WHEN rating = '5' 
                     THEN 'A'
                  ELSE CASE
                  WHEN rating = '4' 
                     THEN 'B'
                  ELSE CASE
                  WHEN rating = '3' 
                     THEN 'C'
                  ELSE CASE
                  WHEN rating = '2' 
                     THEN 'D'
                  ELSE CASE
                  WHEN rating = '1' 
                     THEN 'E'
             END END END END END as nilai FROM `rs_histori_nilai`,`rs_mk_wajib` WHERE `rs_histori_nilai`.`id_mk` = `rs_mk_wajib`.`id_mk` AND `rs_histori_nilai`.`id_user` =" . $user_ID;
                $query = $this->db->query($string_query);
                $data['results'][$userID[$i]] = $query;
            }
            $this->load->view('header');
            $this->load->view('admin/admin_view_all_histori_nilai', $data);
            $this->load->view('footer');
        }
        else
            $this->login();
    }

    function showDataRating() {
        if (($this->session->userdata('user_name') == "herdi")) {
            $userID = $this->getUsers();
            $userCount = count($userID);
            for ($i = 0; $i < $userCount; $i++) {
                $user_ID = $userID[$i];
                $string_query = "SELECT `nama_mk`, `rating`, `review` FROM `rs_review`,`rs_matakuliah` WHERE `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk` AND `rs_review`.`id_user` = " . $user_ID;
                $query = $this->db->query($string_query);
                $config = array();
                $config['total_rows'] = $query->num_rows();
                $config['per_page'] = '50';
                $config['uri_segment'] = 3;
                $config['num_links'] = 2;
                $config['base_url'] = base_url() . 'admin/lihat_rating';
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
                $data['results'][$userID[$i]] = $this->model_user->get_rating_paging($config['per_page'], $offset, $user_ID);
                $data['links'] = $this->pagination->create_links();
            }
            $this->load->view('header');
            $this->load->view('admin/admin_view_all_rating', $data);
            $this->load->view('footer');
        }
        else
            $this->login();
    }

    function cb_accuration() {
        //Akurasi dari content based
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        //Mendapatkan rekomendasi
        require_once 'ContentBased.php';
        //print_r($ratings);
        $userID = $this->getUsers();
        $recommend = new ContentBased();
        //$index = $recommend->getIndexCol();
        $userCount = count($userID);
        $precision = array();
        $recall = array();
        $matchDocs = array();
        $matchDocs2 = array();
        $index = $recommend->getIndexAcc();
        for ($i = 0; $i < $userCount; $i++) {
            $query = $recommend->getHistory($userID[$i]);
            $queryRating = $recommend->getuserMkRating($userID[$i]);
            //$docCount = count($index['docCount']);
            foreach ($query as $qterm) {
                $entry = $index['dictionary'][$qterm];
                echo $entry['dictionary'][$qterm];
                if (is_array($entry['postings'])) {
                    foreach ($entry['postings'] as $docID => $posting) {
                        //if(!isset($matchDocs[$docID]))
                        $matchDocs[$i][] = $docID;
                    }
                }
            }
            //echo "<br>hasil<br>";
            // length normalise
            //echo "<br>MULAIIIII <br>";            
            $matchDocs2[$i] = array_slice(array_values(array_unique($matchDocs[$i])), 0, 20);
            $similarity = array_intersect($matchDocs2[$i], $queryRating);
            //$total = array_values(array_unique(array_merge($matchDocs2[$i], $queryRating)));
            $jumlahS[$userID[$i]] = count($similarity);
            $jumlahM[$userID[$i]] = count($matchDocs2[$i]);
            $jumlahR[$userID[$i]] = count($queryRating);
            $precision[$userID[$i]] = count($similarity) / count($matchDocs2[$i]);
            $recall[$userID[$i]] = count($similarity) / count($queryRating);
            /* echo "<br>QUERY <br>";
              print_r($query);
              echo "<br>QUERY RATING <br>";
              print_r($queryRating);
              echo "<br>MATCH DOCS <br>";
              print_r($matchDocs2[$i]);
              echo "<br>Similarity : <br>";
              print_r($similarity); */
        }
        $data['similar'] = $jumlahS;
        $data['total'] = $jumlahM;
        $data['relevan'] = $jumlahR;
        $data['precision'] = $precision;
        $data['recall'] = $recall;
        $data['jenis'] = "kedua";
        //print_r($precision);
        //print_r($recall);
        $this->load->view('header');
        $this->load->view('admin/admin_view_cb_accuration', $data);
        $this->load->view('footer');
    }

    function cb_accuration_a() {
        //Akurasi dari content based
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        //Mendapatkan rekomendasi
        require_once 'ContentBased.php';
        //print_r($ratings);
        $userID = $this->getUsers();
        $recommend = new ContentBased();
        //$index = $recommend->getIndexCol();
        $userCount = count($userID);
        $precision = array();
        $recall = array();
        $matchDocs = array();
        $matchDocs2 = array();
        $index = $recommend->getIndexAcc();
        for ($i = 0; $i < $userCount; $i++) {
            $query = $recommend->getHistoryA($userID[$i]);
            $queryRating = $recommend->getuserMkRating($userID[$i]);
            //$docCount = count($index['docCount']);
            foreach ($query as $qterm) {
                $entry = $index['dictionary'][$qterm];
                echo $entry['dictionary'][$qterm];
                if (is_array($entry['postings'])) {
                    foreach ($entry['postings'] as $docID => $posting) {
                        //if(!isset($matchDocs[$docID]))
                        $matchDocs[$i][] = $docID;
                    }
                }
            }
            //echo "<br>hasil<br>";
            // length normalise
            //echo "<br>MULAIIIII <br>";            
            $matchDocs2[$i] = array_slice(array_values(array_unique($matchDocs[$i])), 0, 20);
            $similarity = array_intersect($matchDocs2[$i], $queryRating);
            //$total = array_values(array_unique(array_merge($matchDocs2[$i], $queryRating)));
            $jumlahS[$userID[$i]] = count($similarity);
            $jumlahM[$userID[$i]] = count($matchDocs2[$i]);
            $jumlahR[$userID[$i]] = count($queryRating);
            $precision[$userID[$i]] = count($similarity) / count($matchDocs2[$i]);
            $recall[$userID[$i]] = count($similarity) / count($queryRating);
            /* echo "<br>QUERY <br>";
              print_r($query);
              echo "<br>QUERY RATING <br>";
              print_r($queryRating);
              echo "<br>MATCH DOCS <br>";
              print_r($matchDocs2[$i]);
              echo "<br>Similarity : <br>";
              print_r($similarity); */
        }
        $data['similar'] = $jumlahS;
        $data['total'] = $jumlahM;
        $data['relevan'] = $jumlahR;
        $data['precision'] = $precision;
        $data['recall'] = $recall;
        $data['jenis'] = "pertama";
        //print_r($precision);
        //print_r($recall);
        $this->load->view('header');
        $this->load->view('admin/admin_view_cb_accuration', $data);
        $this->load->view('footer');
    }

    function constrain_nilai($id_user) {
        $query = "SELECT count(rs_histori_nilai.id_mk) jumlah, tingkat FROM `rs_histori_nilai`,rs_mk_wajib WHERE rs_histori_nilai.id_user = " . $id_user . " AND rs_histori_nilai.id_mk = rs_mk_wajib.id_mk GROUP BY tingkat";
        $result = mysql_query($query);
        $histori = array();
        while ($row = mysql_fetch_array($result)) {
            $histori[$row{'tingkat'}] = $row{'jumlah'};
        }
        if (($histori[0] > 0) AND ($histori[1] >= 10) AND ($histori[2] >= 10)) {
            $lulus = TRUE;
        }
        else
            $lulus = FALSE;
        print_r($histori);
        return $lulus;
    }

    function save_terms() {
        //Menyimpan terms ke dalam database
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        //Mendapatkan rekomendasi
        require_once 'ContentBased.php';
        $recommend = new ContentBased();
        $index = $recommend->getIndexAcc();
        $docCount = count($index['docCount']);
        foreach ($index['dictionary'] as $term => $df)
        {
            foreach($df as $keys => $values)
            {
                foreach($values as $nama_mk => $tf)
                {
                    //print_r($keys);
                    $tfidf=($tf['tf'] *log($docCount / $df['df'], 2));
                    //echo $term." dan ".$df['df']." dan ".$values." dan ".$nama_mk." dan ".$tf['tf']." dan $tfidf <br/>";
                    $query = "INSERT INTO `rs_term`(`term`, `nama_mk`, `tf`, `idf`, `tfidf`) VALUES ('".$term."','".$nama_mk."','".$tf['tf']."','".$df['df']."','".$tfidf."')";
                    mysql_query($query);
                    //$tfidf=0;
                }                
            }
            
        }
    }
    
    
    function get_cb_recommendation() {
        // Melihat rekomendasi pengguna menggunakan konten based method
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        //Mendapatkan rekomendasi
        require_once 'ContentBased.php';
        //print_r($ratings);
        $userID = $_GET['id'];

        $recommend = new ContentBased();
        //$index = $recommend->getIndexCol();
        $query = $recommend->getHistory($userID);
        if ($query != NULL AND $this->constrain_nilai($userID) == TRUE) {
            //print_r($query);
            $index = $recommend->getIndexCol($userID);
            $matchDocs = array();
            $docCount = count($index['docCount']);
            //echo " <br/><br/><br/><br/><br/>";
            //print_r($index);
            foreach ($query as $qterm) {
                $entry = $index['dictionary'][$qterm];
                //echo $entry['dictionary'][$qterm];
                if (is_array($entry['postings'])) {
                    foreach ($entry['postings'] as $docID => $posting) {
                        //if(!isset($matchDocs[$docID]))
                        $matchDocs[$docID] +=
                                $posting['tf'] *
                                log($docCount / $entry['df'], 2);
                    }
                }
            }

            //echo "<br>hasil<br>";
            // length normalise
            $matchDocs2 = $recommend->normalise($matchDocs);
            //print_r($matchDocs2);
            /* print_r($matchDocs);
              foreach ($matchDocs2 as $docID => $score) {
              $matchDocs2[$docID] = $score / $index['docCount'][$docID];
              echo "doccount: $docCount docID: $docID score : $score index : " . $index['docCount'][$docID] . " matchDocs: " . $matchDocs2[$docID] . "<br>";
              } */

            arsort($matchDocs2); // high to low
            //var_dump($matchDocs2);
            $data['recom'] = $matchDocs2;
            $this->load->view('header');
            $this->load->view('admin/admin_view_cb_rekomendasi', $data);
            $this->load->view('footer');
        } else {
            $data['recom'] = 0;
            $this->load->view('header');
            $this->load->view('admin/admin_view_cb_rekomendasi', $data);
            $this->load->view('footer');
        }
    }

    public function lihat_rating() {
        // Melihat data rating dari suatu mahasiswa
        if (($this->session->userdata('user_name') == "herdi")) {
            $userID = $_GET['id'];
            $string_query = "SELECT `nama_mk`, `rating`, `review` FROM `rs_review`,`rs_matakuliah` WHERE `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk` AND `rs_review`.`id_user` = " . $userID;
            $query = $this->db->query($string_query);
            $config = array();
            $config['total_rows'] = $query->num_rows();
            $config['per_page'] = '50';
            $config['uri_segment'] = 3;
            $config['num_links'] = 2;
            $config['base_url'] = base_url() . 'admin/lihat_rating';
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
            $data['results'] = $this->model_user->get_rating_paging($config['per_page'], $offset, $userID);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('header');
            $this->load->view('admin/admin_view_rating', $data);
            $this->load->view('footer');
        }
        else
            redirect("login/index");
    }

    public function lihat_histori_nilai() {
        // Melihat data histori nilai dari mahasiswa bersangkutan
        if (($this->session->userdata('user_name') == "herdi")) {
            $userID = $_GET['id'];
            $string_query = "SELECT `kode_mk`, `nama_mk`, 
             CASE 
                  WHEN rating = '5' 
                     THEN 'A'
                  ELSE CASE
                  WHEN rating = '4' 
                     THEN 'B'
                  ELSE CASE
                  WHEN rating = '3' 
                     THEN 'C'
                  ELSE CASE
                  WHEN rating = '2' 
                     THEN 'D'
                  ELSE CASE
                  WHEN rating = '1' 
                     THEN 'E'
             END END END END END as nilai FROM `rs_histori_nilai`,`rs_mk_wajib` WHERE `rs_histori_nilai`.`id_mk` = `rs_mk_wajib`.`id_mk` AND `rs_histori_nilai`.`id_user` =" . $userID;
            $query = $this->db->query($string_query);
            $data['results'] = $query;
            $this->load->view('header');
            $this->load->view('admin/admin_view_histori_nilai', $data);
            $this->load->view('footer');
        }
        else
            redirect("login/index");
    }

}

?>
