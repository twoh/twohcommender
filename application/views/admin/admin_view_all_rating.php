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
                <a class="btn" href="javascript:javascript:history.go(-1)" ><i id="back" class="icon-backward"></i></a>
                Dataset Rating MK Pilihan
            </h3>
            <div id="dataMK">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Nama MK</th>
                            <th>Rating</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php $in=0; foreach ($results as $mks=>$value){                            
                                    foreach ($value->result() as $values):                                        
                            ?>
                            <tr>
                                <td><?php 
                                if($in==0)
                                echo $mks;
                            ?></td>   
                                <td><?php echo $values->nama_mk;
                            ?></td>
                                <td><?php echo $values->rating;
                            ?></td>                                                                                        
                            </tr>
                        <?php $in++;
                        endforeach;
                        $in=0;
                        } ?>
                    </tbody>
                </table>
                <div class="pagination">                    
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