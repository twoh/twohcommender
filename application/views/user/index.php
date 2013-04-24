<?php

//echo 'WELCOME halaman login';
?>
<div class="container">
	
    <?php include 'user_db.php';?>
    <div class="row">
        <div class="span3">
            <h4>Rekomendasi Mata Kuliah</h4>
            <p>
            Setelah Anda memberikan rating pada mata kuliah. Cek mata kuliah pilihan yang kami rekomendasikan untuk Anda.
            </p>
            <a class="btn btn-large btn-primary" href="<?php echo base_url().'user/get_recommendation.twh'?>" onclick="">Cek Rekomendasi</a>
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
             </ul>
            <hr/>
`       </div>
        <div class="" id="data" ></div>
    <div class="span3">
            
    </div>
    
        
    </div>
    <script>
        $("#data").load("<?php echo base_url()?>user/data_matakuliah");
                        function sdata(i){
                                if(i == 1){
                                     $("#data").load("<?php echo base_url()?>user/data_matakuliah");
                                     $('#list1').attr('class','active');
                                     $('#list2').attr('class','');
                                     $('#list3').attr('class','');
                                }
                                else if(i == 2){
                                    $("#data").load("<?php echo base_url()?>user/data_rating");
                                    $('#list2').attr('class','active');
                                    $('#list1').attr('class','');
                                    $('#list3').attr('class','');
                                }
                                else if(i == 3){
                                    $("#data").load("<?php echo base_url()?>user/data_profil");
                                    $('#list3').attr('class','active');
                                    $('#list2').attr('class','');
                                    $('#list1').attr('class','');
                                }
                        }
                        
                        

    </script>
</div>
