<?php
//echo 'WELCOME halaman login';
?>
<div class="container">

    <style>
        .verticalLine {
            border-right: 1px solid #eeeeee;
            padding-right: 15px;
        }
    </style>

    <?php include 'admin_db.php'; ?>
    <div class="row">
        <div class="span3">
            
                <h4>Akurasi Sistem</h4>
                <div class="verticalLine">
                <div class="well">
                    <h5>Akurasi MAE</h5>            
                    <p> Cek akurasi prediksi rating menggunakan Mean Absolute Error
                    </p>
                    <a class="btn btn-large btn-primary" href="<?php echo base_url() . 'admin/cf_accuration.twh' ?>" onclick="">Cek MAE CF</a>                
                </div>
                <div class="well">
                    <h5>Akurasi Content-Based Filtering</h5>            
                    <p>
                        Cek akurasi precision recall pada Content-based Filtering pada kedua pengujian
                    </p>                
                    <h5>Pengujian Pertama</h5>

                    <a class="btn btn-large btn-inverse" href="<?php echo base_url() . 'admin/cb_accuration_a.twh' ?>" onclick="">Cek Akurasi CB</a>
                    <br/>
                    <br/>
                    <h5>Pengujian kedua</h5>

                    <a class="btn btn-large btn-inverse" href="<?php echo base_url() . 'admin/cb_accuration.twh' ?>" onclick="">Cek Akurasi CB</a>
                </div>

                <div class="well">
                    <h5>Akurasi Collaborative Filtering</h5>            
                    <p>    
                        Cek akurasi precision recall pada Collaborative Filtering
                    </p>
                    <a class="btn btn-large btn-success" href="<?php echo base_url() . 'admin/get_cf_recommendation_full.twh' ?>" onclick="">Cek Akurasi CF</a>
                </div>
            </div>
        </div>
        <div class="span7">
            <ul class="nav nav-pills">
                <li id="list1" class="active">
                    <a href="#home" onclick="sdata(1)">Home</a>
                </li>
                <li id="list2"><a href="#mk" onclick="sdata(2)">Mata Kuliah Pilihan</a></li>
                <li id="list3"><a href="#pengguna" onclick="sdata(3)">Pengguna</a></li>
                <li id="list4"><a href="#mkw" onclick="sdata(4)">Mata Kuliah Wajib</a></li>
            </ul>
            <hr/>
        </div>
        <div id="data" >

        </div>        
    </div>
    <script>
        $("#data").load("<?php echo base_url() ?>admin/data_home");
        function sdata(i){
            if(i == 1){
                $("#data").load("<?php echo base_url() ?>admin/data_home");
                $('#list1').attr('class','active');
                $('#list2').attr('class','');
                $('#list3').attr('class','');
                $('#list4').attr('class','');
            }
            else if(i == 2){
                $("#data").load("<?php echo base_url() ?>admin/data_matakuliah");
                $('#list2').attr('class','active');
                $('#list1').attr('class','');
                $('#list3').attr('class','');
                $('#list4').attr('class','');
            }
            else if(i == 3){
                $("#data").load("<?php echo base_url() ?>admin/data_pengguna");
                $('#list3').attr('class','active');
                $('#list2').attr('class','');
                $('#list1').attr('class','');
                $('#list4').attr('class','');
            }
            else if(i == 4){
                $("#data").load("<?php echo base_url() ?>admin/data_mk_wajib");
                $('#list3').attr('class','');
                $('#list2').attr('class','');
                $('#list1').attr('class','');
                $('#list4').attr('class','active');
            }
        }
                        
                        

    </script>


</div>
