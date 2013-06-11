<div class="container-fluid">
    <?php include 'admin_db.php'; ?>
    <div class="row-fluid">

        <h3>
            <a class="btn" href="<?php echo base_url() . 'admin/index.twh' ?>" ><i id="back" class="icon-backward"></i></a>
            Akurasi Sistem Collaborative Filtering                               
        </h3>
        <span class="label label-info">Mean Absolute Error : <?php echo $accuration; ?></span>
        <span class="label label-info">Mata Kuliah : <?php echo $mk; ?></span>
        <div class="span8">
            <div id="dataMK">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama User</th>
                            <th>Prediksi Rating</th>                                                                                
                            <th>Aktual Rating</th>
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
                                <td><?php echo $aktual[$key];
                        ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>                                
            </div>
            <span class="label label-info">Mean Absolute Error : <?php echo $accuration; ?></span>
            <span class="label label-info">Mata Kuliah : <?php echo $mk; ?></span>
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