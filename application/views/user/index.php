<?php
//echo 'WELCOME halaman login';
?>
<div class="container">

    <?php include 'user_db.php'; ?>
    <div class="row">
        <div class="span3">
            <h4>Rekomendasi Mata Kuliah</h4>
            <?php
            if ($rating->num_rows() > 0) {
                ?>                
                    <h5>Berdasarkan Rating</h5>
                    <p>
                        Setelah Anda memberikan rating pada mata kuliah. Cek mata kuliah pilihan yang kami rekomendasikan untuk Anda.
                    </p>
                    <a class="btn btn-large btn-primary" href="<?php echo base_url() . 'user/get_recommendation.twh' ?>" onclick="">Cek Rekomendasi</a>                
                <?php
            } else {
                echo "<h5>Berdasarkan Rating</h5>";
                echo "<p>Belum ada data rating</p>";
            }

            if ($histori->num_rows() > 0) {
                ?>
                <h5>Berdasarkan Histori Nilai</h5>
                <p>
                    Anda dapat menggunakan histori nilai MK Wajib untuk mendapatkan rekomendasi mata kuliah pilihan untuk Anda.
                </p>
                <a class="btn btn-large btn-info" href="<?php echo base_url() . 'user/get_cb_recommendation.twh' ?>" onclick="">Cek Rekomendasi</a>
                <?php
            } else {
                echo "<h5>Berdasarkan Histori Nilai</h5>";
                echo "<p>Belum ada data histori nilai</p>";
            }
            ?>            
        </div>
        <div class="span7">
            <ul class="nav nav-pills">
                <li id="list1" class="active">
                    <a href="#rating" onclick="sdata(1)">Mata Kuliah</a>
                </li>
                <li id="list2">
                    <a href="#mk" onclick="sdata(2)">Rating</a>
                </li>
                <li id="list3">
                    <a href="#pengguna" onclick="sdata(3)">Profil</a>
                </li>
                <li id="list4">
                    <a href="#histori" onclick="sdata(4)">Histori Nilai</a>
                </li>
            </ul>
            <hr/>
            `       </div>
        <div class="" id="data" ></div>
        <div class="span3">

        </div>


    </div>
    <script>
        $("#data").load("<?php echo base_url() ?>user/data_matakuliah");
        function sdata(i){
            if(i == 1){
                $("#data").load("<?php echo base_url() ?>user/data_matakuliah");
                $('#list1').attr('class','active');
                $('#list2').attr('class','');
                $('#list3').attr('class','');
                $('#list4').attr('class','');
            }
            else if(i == 2){
                $("#data").load("<?php echo base_url() ?>user/data_rating");
                $('#list2').attr('class','active');
                $('#list1').attr('class','');
                $('#list3').attr('class','');
                $('#list4').attr('class','');
            }
            else if(i == 3){
                $("#data").load("<?php echo base_url() ?>user/data_profil");
                $('#list3').attr('class','active');
                $('#list2').attr('class','');
                $('#list1').attr('class','');
                $('#list4').attr('class','');
            }
            else if(i == 4){
                $("#data").load("<?php echo base_url() ?>user/data_histori");
                $('#list3').attr('class','');
                $('#list2').attr('class','');
                $('#list1').attr('class','');
                $('#list4').attr('class','active');
            }
        }
                        
                        

    </script>
</div>
