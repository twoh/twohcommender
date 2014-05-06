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
                Daftar MK Pilihan                 
            </h3>
            <div id="dataMK">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>MK</th>
                            <th>Deskripsi</th>
                            <th>SKS</th>
                            <th>KK</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results->result() as $mks):
                            ?>
                            <tr>
                                <td><span class="label label-inverse"><?php echo $mks->id_mk; ?></span></td>
                                <td><?php echo $mks->nama_mk;
                            ?></td>
                                <td><?php echo $mks->deskripsi;
                            ?></td>
                                <td>
                                    <?php echo $mks->sks;
                                    ?>      
                                </td>
                                <td><?php echo $mks->kelompok_keahlian;
                                    ?></td>
                                <td>                                     
                                    <input id="fieldEdit<?php echo $mks->id_mk ?>" type="hidden" name="edit_mk" value="<?php echo $mks->id_mk ?>"/>
                                    <div class="" id="linkEdit<?php echo $mks->id_mk ?>"><a class="btn btn-info" href="#twh/#!/mk<?php echo $mks->id_mk ?>" onclick="addRating(<?php echo $mks->id_mk ?>)"><i id="addRating<?php echo $mks->id_mk ?>" class="icon-white icon-plus"></i></a></div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php echo $links; ?>
                </div>
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