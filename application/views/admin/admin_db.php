<div class="row">
        <div class="span10 columns">
            <div class="page-header">
                <h2>Selamat Datang ! <small>Anda Berada di Halaman Admin</small>
            </h2>
            </div>
            <div class="alert alert-info">
                <p>
                    Admin :<span class="label label-info"><?php print_r($this->session->userdata('user_name'))?></span>
                    <?php
            $data = array(
                'name' => 'logout',
                'id' => 'logout',
                'class' => 'btn btn-small btn-danger pull-right'
            );
            echo anchor('admin/logout', 'Log Out', $data);
            ?>
                
                </p>
                
            </div>
    </div>      
    </div>
            
        
    