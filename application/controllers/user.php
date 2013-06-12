<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_user');
        $this->load->model('model_admin');
        $this->load->library('pagination');
    }

    public function logout() {
        //function untuk logout
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

    public function welcome() {
        //setelah login
        if (($this->session->userdata('user_name') != "")) {
            $data['rating'] = $this->cek_rating();
            $data['histori'] = $this->cek_histori();
            $this->load->view('header');
            $this->load->view('user/index', $data);
            $this->load->view('footer');
        } else {
            redirect('login/index');
        }
    }

    public function data_matakuliah() {
        // fungsi untuk melihat data mata kuliah
        if (($this->session->userdata('user_name') != null)) {
            $this->load->view('user/user_data_matakuliah');
        }
        else
            redirect("login/index");
    }

    public function data_rating() {
        //fungsi untuk melihat data rating pengguna
        if (($this->session->userdata('user_name') != null)) {
            $this->load->view('user/user_data_rating');
        }
        else
            redirect("login/index");
    }

    public function data_histori() {
        //fungsi untuk melihat data profil
        if (($this->session->userdata('user_name') != null)) {
            $data['histori'] = $this->cek_histori();
            $this->load->view('user/user_data_histori', $data);
        }
        else
            redirect("login/index");
    }

    public function data_profil() {
        //fungsi untuk melihat data profil
        if (($this->session->userdata('user_name') != null)) {
            $this->load->view('user/user_data_profil');
        }
        else
            redirect("login/index");
    }

    public function lihat_mk() {
        //Melihat mata kuliah yang belum dirating
        if (($this->session->userdata('user_name') != null)) {
            $string_query = "SELECT * FROM `rs_matakuliah` WHERE `id_mk` NOT IN (SELECT `id_mk` FROM `rs_review` WHERE `rs_review`.`id_user` = " . $this->session->userdata('user_id') . " AND `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk`)";
            $query = $this->db->query($string_query);
            $config = array();
            $config['total_rows'] = $query->num_rows();
            $config['per_page'] = '10';
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
            redirect("login/index");
    }

    public function cek_rating() {
        // Cek apakah ada data rating
        $userID = $this->session->userdata('user_id');
        $string_query = "SELECT `nama_mk`, `rating`, `review` FROM `rs_review`,`rs_matakuliah` WHERE `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk` AND `rs_review`.`id_user` = " . $userID;
        $result = $this->db->query($string_query);
        return $result;
    }

    public function cek_histori() {
        // Cek apakah ada data histori nilai
        $userID = $this->session->userdata('user_id');
        $string_query = "SELECT * FROM `rs_histori_nilai` WHERE `id_user` =" . $userID;
        $result = $this->db->query($string_query);
        return $result;
    }

    public function lihat_rating() {
        // Melihat data mata kuliah yang sudah dirating
        if (($this->session->userdata('user_name') != null)) {
            $userID = $this->session->userdata('user_id');
            $string_query = "SELECT `nama_mk`, `rating`, `review` FROM `rs_review`,`rs_matakuliah` WHERE `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk` AND `rs_review`.`id_user` = " . $userID;
            $query = $this->db->query($string_query);
            $config = array();
            $config['total_rows'] = $query->num_rows();
            $config['per_page'] = '10';
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
            $data['results'] = $this->model_user->get_rating_paging($config['per_page'], $offset, $userID);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('header');
            $this->load->view('user/user_view_rating', $data);
            $this->load->view('footer');
        }
        else
            redirect("login/index");
    }

    function edit_rating() {
        //Meload Halaman edit mata kuliah
        if (($this->session->userdata('user_name') != null)) {
            $userID = $this->session->userdata('user_id');
            $id = $this->input->post('edit_mk');
            $namaMK = $this->input->post('nama_mk');
            //echo 'IDE SAMA DENGAN'.$id;
            $this->db->where('id_mk', $id);
            $this->db->where('id_user', $userID);
            $query = $this->db->get("rs_review");
            if ($query->num_rows() > 0) {
                $data['mk'] = $query;
                $data['namaMK'] = $namaMK;
                $this->load->view('user/edit/rating', $data);
            } else {
                echo 'dataempty';
            }
        }
        else
            $this->login();
    }
    
    function do_edit_rating() {
        //Melakukan update mata kuliah
        $userID = $this->session->userdata('user_id');
        $this->load->library('form_validation');                
        $this->form_validation->set_rules('review', 'Review MK', 'trim|required|min_length[0]|max_length[280]');
        $this->form_validation->set_rules('rating', 'Rating', 'trim|required|min_length[0]|max_length[1]');
        if ($this->form_validation->run() == FALSE) {
//            echo 'salaaah';
            redirect('user/lihat_rating');
        } else {
//                        $id = $this->input->post('idmk');
//                        $nama = $this->input->post('namamk');
//                        $sks = $this->input->post('sks');
//                        $deskripsi = $this->input->post('deskripsi');
//                        echo $id;
//                        echo $nama;
//                        echo $deskripsi;
//                        echo $sks;
            $this->model_user->update_rating($userID);
            redirect('user/lihat_rating');
//            echo 'sukses';
//            echo 'dijalankan';
        }
    }
    
    function delete_rating() {
        //fungsi untuk menghapus mata kuliah
        if (($this->session->userdata('user_name') != null)) {
        $userID = $this->session->userdata('user_id');
        $id = $this->input->post('edit_mk');
        $this->db->where('id_mk', $id);
        $this->db->where('id_user', $userID);
        $this->db->delete('rs_review');
        $this->load->view('user/delete/rating');        
        }else
            redirect("login/index");
    }
    
    public function addRating() {
        // menambah data Rating
        if (($this->session->userdata('user_name') != null)) {
            $id = $this->input->post('edit_mk');
            //echo 'IDE SAMA DENGAN'.$id;
            $this->db->where('id_mk', $id);
            $query2 = $this->db->get("rs_matakuliah");
            $query = mysql_query("SELECT `user_name`, `rating` FROM `rs_review`, `rs_user` WHERE rs_review.id_user != " . $this->session->userdata('user_id') . " AND `rs_review`.`id_user` = `rs_user`.`id_user` AND id_mk = " . $id);
            $komentar = array();
            while ($row = mysql_fetch_array($query)) {
                $userID = $row{'user_name'};
                $komentar[$userID] = $row{'rating'};
            }
            if ($query2->num_rows() > 0) {
                $data['mk'] = $query2;
                $data['komentar'] = $komentar;
                $this->load->view('user/insert/rating_mk', $data);
            } else {
                echo 'dataempty';
            }
        }else
            redirect("login/index");
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

    function get_recommendation() {
        //Mendapatkan rekomendasi
        require_once 'ItemBased.php';
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
        $recom = $recommend->recommend($this->session->userdata('user_id'), $transform, $similiarity, 10);
        //print_r($recom);
        if(!empty($recom))
        {
            $data['recom'] = $recom;
        }else
        {
            $data['recom'] = 0;
        }
        $this->load->view('header');
        $this->load->view('user/user_view_rekomendasi', $data);
        $this->load->view('footer');
    }

    function get_cb_recommendation() {
        //fungsi untuk mendapat rekomendasi berdasarkan content based recommendation
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        //Mendapatkan rekomendasi
        require_once 'ContentBased.php';
        //print_r($ratings);
        $userID = $this->session->userdata('user_id');
        $recommend = new ContentBased();
        //$index = $recommend->getIndexCol();
        $query = $recommend->getHistory($userID);
        $index = $recommend->getIndexCol($userID);
        $matchDocs = array();
        $docCount = count($index['docCount']);
        foreach ($query as $qterm) {
            $entry = $index['dictionary'][$qterm];
            //echo $entry['dictionary'][$qterm];
            if (is_array($entry['postings'])) {
                foreach ($entry['postings'] as $docID => $posting) {
                    //if(!isset($matchDocs[$docID]))
                    $matchDocs[$docID] +=
                            $posting['tf'] *
                            log($docCount + 1 / $entry['df'] + 1, 2);
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
        $this->load->view('user/user_view_cb_rekomendasi', $data);
        $this->load->view('footer');
    }

    public function edit_histori_nilai() {
        $userID = $this->session->userdata('user_id');
        $string_query = "SELECT `rs_histori_nilai`.`id_mk`,`kode_mk`, `nama_mk`, `rating`
              FROM `rs_histori_nilai`,`rs_mk_wajib` WHERE `rs_histori_nilai`.`id_mk` = `rs_mk_wajib`.`id_mk` AND `rs_histori_nilai`.`id_user` =" . $userID;
        $query = $this->db->query($string_query);

        $string_query2 = "SELECT `id_mk`,`kode_mk`, `nama_mk` FROM `rs_mk_wajib`";
        $query2 = $this->db->query($string_query2);

        $data['results'] = $query;
        $data['results2'] = $query2;
        $this->load->view('header');
        $this->load->view('user/edit/histori_nilai', $data);
        $this->load->view('footer');
    }

    public function do_edit_histori_nilai() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $userID = $this->session->userdata('user_id');
        $string_query = "SELECT `id_mk` FROM `rs_histori_nilai` WHERE `id_user` =" . $userID;
        $result = $this->db->query($string_query);
        $mk = array();
        foreach ($result->result_array() as $row) {
             $mk[$row['id_mk']]=$row['id_mk'];            
        }
        $idMK = $this->input->post('idMK');
        $nilai = $this->input->post('nilai');
        foreach ($idMK as $key => $values) {
            if ($mk[$values] == $values) {
                $this->model_user->edit_histori_nilai($values, $userID, $nilai[$key]);
            } elseif (($nilai[$key] != 0) AND ($mk[$values] != $values)) {
                $this->model_user->insert_histori_nilai($values, $userID, $nilai[$key]);
                //echo "Mata kuliah : ".$values." nilai : ".$nilai[$key]."<br>";
            }
        }
        $this->lihat_histori_nilai();
    }

    public function tambah_histori_nilai() {
        $userID = $this->session->userdata('user_id');
        $string_query = "SELECT `id_mk`,`kode_mk`, `nama_mk` FROM `rs_mk_wajib`";
        $query = $this->db->query($string_query);
        $data['results'] = $query;
        $this->load->view('header');
        $this->load->view('user/insert/histori_nilai', $data);
        $this->load->view('footer');
    }

    public function do_tambah_histori_nilai() {
        $userID = $this->session->userdata('user_id');
        $idMK = $this->input->post('idMK');
        $nilai = $this->input->post('nilai');
        foreach ($idMK as $key => $values) {
            if ($nilai[$key] != 0) {
                $this->model_user->insert_histori_nilai($values, $userID, $nilai[$key]);
                //echo "Mata kuliah : ".$values." nilai : ".$nilai[$key]."<br>";
            }
        }
        $this->lihat_histori_nilai();
    }

    public function lihat_histori_nilai() {
        // Melihat data histori nilai
        if (($this->session->userdata('user_name') != null)) {
            $userID = $this->session->userdata('user_id');
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
            $this->load->view('user/user_view_histori_nilai', $data);
            $this->load->view('footer');
        }
        else
            redirect("login/index");
    }

}
?>


