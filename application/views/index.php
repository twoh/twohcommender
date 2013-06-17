<?php include 'header.php'; ?>

<div class="container">
    <div class="row-fluid">
        <!-- SPAN9-->
        <div class="span12">
            <div class="jumbotron hero-unit">
                <h1>Selamat Datang !</h1>
                <p>Herdi Course Recommender adalah sistem perekomendasi mata kuliah pilihan bagi mahasiswa.
                </p>
                <p><a href="<?php echo base_url() ?>login/index.twh" class="btn btn-primary btn-large">Login &raquo;</a>
                    <a href="<?php echo base_url() ?>register/index.twh" class="btn btn-large">Register &raquo;</a></p>
            </div>
        </div>
        <ul class="thumbnails">
            <li class="span4">
                <div class="thumbnail">
                    <img class="img-rounded" src="<?php echo base_url() ?>img/rating.png" width="200px" height="200px" alt="">
                    <div class="caption">
                        <h3>Berikan Rating</h3>
                        <p>Tambahkan rating ke mata kuliah pilihan berdasarkan minat kalian. Tentukan mata kuliah pilihan mana yang kalian sukai, dan mana yang tidak kalian sukai.</p>
                    </div>
                </div>
            </li>                
            <li class="span4">
                <div class="thumbnail">
                    <img class="img-rounded" src="<?php echo base_url() ?>img/grade.png" width="200px" height="200px" alt="">
                    <div class="caption">
                        <h3>Rekomendasi Mata Kuliah</h3>
                        <p>Dapatkan rekomendasi mata kuliah berdasarkan histori nilai atau rating. Sistem rekomendasi kami menggunakan metode <i>switching hybrid</i> yang memungkinkan kalian untuk mendapatkan rekomendasi
                            yang sesuai dengan kondisi.</p>
                    </div>
                </div>
            </li>
            <li class="span4">
                <div class="thumbnail">
                    <img class="img-rounded" src="<?php echo base_url() ?>img/groups.png" width="200px" height="200px" alt="">
                    <div class="caption">
                        <h3>Kolaborasi Mahasiswa</h3>
                        <p>Temukan mata kuliah pilihan yang disukai teman kalian. Temukan mata kuliah pilihan yang sesuai dengan melihat preferensi dari mahasiswa lain.</p>
                    </div>
                </div>
            </li>
        </ul>            
        <div class="span12">
            <div class="well">
                <div style="margin: 0 auto 10px; text-align: center;">
                <h2>Gabung Sekarang</h2>
                <p>
                <a href="<?php echo base_url() ?>login/index.twh" class="btn btn-primary btn-large">Login &raquo;</a>
                    <a href="<?php echo base_url() ?>register/index.twh" class="btn btn-large">Register &raquo;</a></p>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /container -->

<?php include 'footer.php'; ?>