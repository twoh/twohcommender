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
                Daftar Rating MK Pilihan                 
            </h3>
            <div id="dataMK">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama MK</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results->result() as $mks):
                            ?>
                            <tr>                                
                                <td><?php echo $mks->nama_mk;
                            ?></td>
                                <td><?php echo $mks->rating;
                            ?></td>
                                <td>
                                    <?php echo $mks->review;
                                    ?>      
                                </td>                                                                
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-small btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-book icon-white"></i><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <input id="fieldEdit<?php echo $mks->id_mk ?>" type="hidden" name="edit_mk" value="<?php echo $mks->id_mk ?>"/>
                                            <input id="namaMK<?php echo $mks->id_mk ?>" type="hidden" name="nama_mk" value="<?php echo $mks->nama_mk ?>"/>
                                            <li class="" id="linkEdit<?php echo $mks->id_mk ?>"><a href="#twh/#!/mk<?php echo $mks->id_mk ?>" onclick="editMK(<?php echo $mks->id_mk ?>)"><i class="icon-pencil"></i> Edit</a></li>
                                            <li class="" id="linkDelete<?php echo $mks->id_mk ?>"><a href="#twh/#!/mk<?php echo $mks->id_mk ?>" onclick="hapusMK(<?php echo $mks->id_mk ?>)"><i class="icon-trash"></i> Hapus</a></li>
                                        </ul>
                                    </div>
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
        function editMK($id_mk,event)
        {
            if($("#insertMK").attr("toggle")=="no")
            {
                $("#insertMK").load("<?php echo base_url() ?>user/edit_rating.twh",{
                    edit_mk: $("#fieldEdit"+$id_mk).val(),
                    nama_mk: $("#namaMK"+$id_mk).val()
                });
                $('#insertMK').attr('toggle','yes');
                $('#linkEdit'+$id_mk).attr('class','disabled');
                event.preventDefault();
            }
            else if($("#insertMK").attr("toggle")=="yes")
            {
                $("#insertMK").empty();
                $('#insertMK').attr('toggle','no');
                $('#linkEdit'+$id_mk).attr('class','');
                event.preventDefault();
            }
        }

        function hapusMK($id_mk,event)
        {
            
            $("#insertMK").load("<?php echo base_url() ?>user/delete_rating.twh",{
                edit_mk: $("#fieldEdit"+$id_mk).val()
            });
            $("#dataMK").load("<?php echo base_url() . 'user/lihat_rating' ?> #dataMK");
            event.preventDefault();
        
        }     
    </script>
</div>