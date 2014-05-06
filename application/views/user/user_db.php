<div class="row">
        <div class="span10 columns">
            <div class="page-header">
                <h2>Selamat Datang ! <small>Anda Berada di Halaman Pengguna</small>
            </h2>
            </div>
            <div class="alert alert-info">
                <p>
                    User :<span class="label label-info"><?php print_r($this->session->userdata('user_name'))?></span>
                    ID : <span class="label label-info"><?php print_r($this->session->userdata('user_id'))?></span>
                    <?php
            $data = array(
                'name' => 'logout',
                'id' => 'logout',
                'class' => 'btn btn-danger pull-right'
            );

            echo anchor('user/logout', 'Log Out', $data);

            ?>
                
                </p>
                
            </div>
    </div>      
</div>