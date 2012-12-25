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
            $data['user'] = $this->model_admin->get_all_user();
            $this->load->view('admin/admin_pengguna', $data);
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
    
    function edit_user() {
        //Meload Halaman edit pengguna
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
        $this->form_validation->set_rules('deskripsi', 'Deskripsi MK', 'trim|required|min_length[0]|max_length[140]');
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

    function delete_mk()
    {
        //fungsi untuk menghapus mata kuliah
        $id = $this->input->post('edit_mk');
        $this->db->where('id_mk', $id);
        $this->db->delete('rs_matakuliah'); 
        $this->load->view('admin/delete/mata_kuliah');
    }


    function insert_user() {
        //Meload Halaman Insert User
        if (($this->session->userdata('user_name') == "herdi"))
            $this->load->view('admin/insert/pengguna');
        else
            $this->login();
    }

    public function do_insert_user() {
        //Melakukan insert user
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>');
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('email_address', 'Your Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        if ($this->form_validation->run() == FALSE) {
            redirect('admin/index');
        } else {
            $this->model_admin->insert_user();
            redirect('admin/index');
        }
    }

    public function lihat_mk() {
        //MELIHAT DATA MATA KULIAH <PAGING VERSION>
        $string_query = "select * from rs_matakuliah";
        $query = $this->db->query($string_query);
        $config = array();
        $config['total_rows'] = $query->num_rows();
        $config['per_page'] = '5';
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

}

?>
