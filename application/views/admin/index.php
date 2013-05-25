<?php
//echo 'WELCOME halaman login';
?>
<div class="container">


    <?php include 'admin_db.php'; ?>
    <div class="row">
        <div class="span3">
            <h4>Akurasi Sistem</h4>
            <p>
            <h5>Akurasi Collaborative Filtering</h5>            
            </p>
            <a class="btn btn-large btn-primary" href="<?php echo base_url() . 'admin/cf_accuration.twh' ?>" onclick="">Cek Akurasi CF</a>
            <h5>Akurasi Content-Based Filtering</h5>            
            </p>
            <a class="btn btn-large btn-info" href="<?php echo base_url() . 'admin/cb_accuration.twh' ?>" onclick="">Cek Akurasi CB</a>
        </div>
        <div class="span7">
            <ul class="nav nav-pills">
                <li id="list1" class="active">
                    <a href="#home" onclick="sdata(1)">Home</a>
                </li>
                <li id="list2"><a href="#mk" onclick="sdata(2)">Mata Kuliah</a></li>
                <li id="list3"><a href="#pengguna" onclick="sdata(3)">Pengguna</a></li>
            </ul>
            <hr/>
            `       </div>

        <div class="span7" id="data" >

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
            }
            else if(i == 2){
                $("#data").load("<?php echo base_url() ?>admin/data_matakuliah");
                $('#list2').attr('class','active');
                $('#list1').attr('class','');
                $('#list3').attr('class','');
            }
            else if(i == 3){
                $("#data").load("<?php echo base_url() ?>admin/data_pengguna");
                $('#list3').attr('class','active');
                $('#list2').attr('class','');
                $('#list1').attr('class','');
            }
        }
                        
                        

    </script>


</div>
