<div class="container-fluid">
    <?php include 'admin_db.php'; ?>
    <div class="row-fluid">
        
            <h3>
                <a class="btn" href="<?php echo base_url() . 'admin/lihat_pengguna.twh' ?>" ><i id="back" class="icon-backward"></i></a>
                Akurasi Sistem                
                <span class="label label-info">Akurasi : <?php echo $accuration;?></span>
                <span class="label label-info">Mata Kuliah : <?php echo $mk;?></span>
            </h3>            
            <div class="span4">
            <div id="dataMK">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama User</th>
                            <th>Prediksi Rating</th>                                                                                
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach ($prediksi as $key => $value):
                            ?>
                            <tr>                                
                                <td><?php echo $key;
                            ?></td>
                                <td><?php echo $value;
                            ?></td>                                                                                 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>                                
            </div>
        </div>
        <div class="span4" id="insertMK" toggle="no">
            <table class="table table-hover">
                    <thead>
                        <tr>                            
                            <th>Aktual Rating</th>                                                                                
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach ($aktual as $key => $value):
                            ?>
                            <tr>                                                            
                                <td><?php echo $value;
                            ?></td>                                                                                 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
    </div> <!--row-->
    <script>                                
        function addRating($id_mk,event)
        {
            if($("#insertMK").attr("toggle")=="no")
            {
                $("#insertMK").load("<?php echo base_url() ?>user/addRating.twh",{
                    edit_mk: $("#fieldEdit"+$id_mk).val()
                });
                $('#insertMK').attr('toggle','yes');                
                $("#addRating"+$id_mk).attr('class','icon-white icon-minus');
                event.preventDefault();
            }
            else if($("#insertMK").attr("toggle")=="yes")
            {
                $("#insertMK").empty();
                $('#insertMK').attr('toggle','no');                
                $("#addRating"+$id_mk).attr('class','icon-white icon-plus');
                event.preventDefault();
            }
        }        
    </script>
</div>