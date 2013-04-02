<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="container-fluid">
    <?php include 'admin_db.php'; ?>
    <div class="row-fluid">
        <div class="span6">
            <h3>
                <a class="btn" href="<?php echo base_url() . 'admin/index/' ?>" ><i id="back" class="icon-backward"></i></a>
                Daftar MK Pilihan 
                <a class="btn" href="#insertmk" onclick="insertMK()"><i id="addMK" class="icon-plus"></i></a>
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
                            <th>Action</th>
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
                                    <div class="btn-group">
                                        <a class="btn btn-small btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-book icon-white"></i><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <input id="fieldEdit<?php echo $mks->id_mk ?>" type="hidden" name="edit_mk" value="<?php echo $mks->id_mk ?>"/>
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
        function insertMK(event){
            if($("#insertMK").attr("toggle")=="no")
            {
                $("#insertMK").load("<?php echo base_url() ?>admin/insert_mk.twh");
                $('#insertMK').attr('toggle','yes');
                $("#addMK").attr('class','icon-minus');
                event.preventDefault();
            }
            else if($("#insertMK").attr("toggle")=="yes")
            {
                $("#insertMK").empty();
                $('#insertMK').attr('toggle','no');
                $("#addMK").attr('class','icon-plus');
                event.preventDefault();
            }
                                    
        }
                        
        function editMK($id_mk,event)
        {
            if($("#insertMK").attr("toggle")=="no")
            {
                $("#insertMK").load("<?php echo base_url() ?>admin/edit_mk.twh",{
                    edit_mk: $("#fieldEdit"+$id_mk).val()
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
            
            $("#insertMK").load("<?php echo base_url() ?>admin/delete_mk.twh",{
                edit_mk: $("#fieldEdit"+$id_mk).val()
            });
            $("#dataMK").load("<?php echo base_url() . 'admin/lihat_mk' ?> #dataMK");
            event.preventDefault();
        
        }
    </script>
</div>