<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="container-fluid">
    <?php include 'user_db.php'; ?>
    <div class="row-fluid">
        <div class="span6">
            <h3>
                <a class="btn" href="<?php echo base_url() . 'user/welcome/' ?>" ><i id="back" class="icon-backward"></i></a>
                Daftar Rekomendasi Mata Kuliah Pilihan                 
            </h3>
            <div id="dataMK">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama MK</th>
                            <th>Prediksi Rating</th>                                                                                
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach ($recom as $key => $value):
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