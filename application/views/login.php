<?php include 'header.php'; ?>
<div class="container">
    <div class="row-fluid">
        <div class="span8">
            <ul class="thumbnails">
                <li class="span12">
                    <div class="thumbnail">
                        <img class="img-rounded" src="<?php echo base_url() ?>img/student.jpg" width="800px" height="600px" alt="">
                        <div class="caption">
                            <h3>Masuk</h3>
                            <p>Login dan temukan mata kuliah pilihan yang cocok untukmu berdasarkan histori nilai.
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="span4">
            <?php
            $attributes = array('class' => 'well');
            echo form_open("login/do_login", $attributes);
            ?>
            <h2 >Masuk</h2>
            <input type="text" class="input-block-level" name="email" placeholder="Email address"/>
            <input type="password" class="input-block-level" name="password" placeholder="Password"/>            
            <button class="btn btn-large btn-primary" type="submit">Sign in</button>
            <?php echo form_close(); ?>

            <div class="well">
                <h2 >Belum Punya Akun?</h2>            
                <a href="<?php echo base_url() ?>register/index.twh" class="btn btn-large btn-warning" type="submit">Daftar di Sini</a>
            </div>
        </div>

    </div>
</div>
<?php include 'footer.php' ?>