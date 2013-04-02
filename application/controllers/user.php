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
                         $this->load->model('model_admin');
                         $this->load->library('pagination');
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
                public function welcome()
                {
                    if(($this->session->userdata('user_name')!=""))
                        {
                           $this->load->view('header');
                           $this->load->view('user/index');
                           $this->load->view('footer');
                        }
                        else{
                            redirect('login/index');
                        }
                      
                }
                
                public function data_matakuliah()
                {
                    if (($this->session->userdata('user_name') != null)) {
                            $this->load->view('user/user_data_matakuliah');
                        }
                        else
                            redirect ("login/index");
                }
                
                public function data_rating()
                {
                    if (($this->session->userdata('user_name') != null)) {
                            $this->load->view('user/user_data_rating');
                        }
                        else
                            redirect ("login/index");
                }
                
                public function data_profil()
                {
                    if (($this->session->userdata('user_name') != null)) {
                            $this->load->view('user/user_data_profil');
                        }
                        else
                            redirect ("login/index");
                }
                
                public function lihat_mk()
                {
                    if (($this->session->userdata('user_name') != null)) {
                    $string_query = "select * from rs_matakuliah";
                    $query = $this->db->query($string_query);
                    $config = array();
                    $config['total_rows'] = $query->num_rows();
                    $config['per_page'] = '5';
                    $config['uri_segment'] = 3;
                    $config['num_links'] = 2;
                    $config['base_url'] = base_url() . 'user/lihat_mk';
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
                    $this->load->view('user/user_view_mk', $data);
                    $this->load->view('footer');
                            
                        }
                        else
                            redirect ("login/index");
                }
                
                public function lihat_rating()
                {
                    if (($this->session->userdata('user_name') != null)) {
                        $string_query = "SELECT `nama_mk`, `rating`, `review` FROM `rs_review`,`rs_matakuliah` WHERE `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk`";
                        $query = $this->db->query($string_query);
                        $config = array();
                        $config['total_rows'] = $query->num_rows();
                        $config['per_page'] = '5';
                        $config['uri_segment'] = 3;
                        $config['num_links'] = 2;
                        $config['base_url'] = base_url() . 'user/lihat_rating';
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
                        $data['results'] = $this->model_user->get_rating_paging($config['per_page'], $offset);
                        $data['links'] = $this->pagination->create_links();
                        $this->load->view('header');
                        $this->load->view('user/user_view_rating', $data);
                        $this->load->view('footer');                            
                    }
                    else
                        redirect ("login/index");
                }
                
                public function addRating()
                {
                    if (($this->session->userdata('user_name') != null)) {
                        $id = $this->input->post('edit_mk');
                        //echo 'IDE SAMA DENGAN'.$id;
                        $this->db->where('id_mk', $id);
                        $query = $this->db->get("rs_matakuliah");
                        if ($query->num_rows() > 0) {
                            $data['mk'] = $query;
                            $this->load->view('user/insert/rating_mk', $data);
                        } else {
                            echo 'dataempty';
                        }                        
                    }else
                            redirect ("login/index");
                }
                
                 function do_insert_rating() {
                    //Melakukan insert mata kuliah
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('idmk', 'ID MK', 'trim|required|min_length[1]|xss_clean|max_length[4]');
                    $this->form_validation->set_rules('komentar', 'Komentar', 'trim|min_length[0]|max_length[1000]');
                    $this->form_validation->set_rules('test-4-rating-3', 'Rating', 'trim|required|min_length[1]|max_length[4]');
                    $this->form_validation->set_rules('iduser', 'ID User', 'trim|required|min_length[1]|max_length[4]');
                    if ($this->form_validation->run() == FALSE) {
                        echo "error";
                        redirect('user/lihat_mk');
                    } else {
                        $this->model_user->insert_rating();
                        redirect('user/lihat_mk');
                    }/**/
                }
                
        }
?>


