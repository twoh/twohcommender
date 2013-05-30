<div class="container-fluid">
    <?php include 'admin_db.php'; ?>
    <div class="row-fluid">
        
            <h3>
                <a class="btn" href="<?php echo base_url() . 'admin/lihat_pengguna.twh' ?>" ><i id="back" class="icon-backward"></i></a>
                Akurasi Sistem Content Based                
            </h3>            
            <div class="span8">
            <div id="dataMK">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID User</th>
                            <th>Relevan</th>
                            <th>Dokumen Total</th>
                            <th>Relevan Total</th>
                            <th>Precision</th>
                            <th>Recall</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $precTotal = $reccTotal = 0;
                        foreach ($precision as $key => $value):
                            ?>
                            <tr>                                
                                <td><?php echo $key;
                            ?></td>
                                <td><?php echo $similar[$key];
                            ?></td>
                                <td><?php echo $total[$key];
                            ?></td>
                                <td><?php echo $relevan[$key];
                            ?></td>                                
                                <td><?php echo $value;//." = ".(round($value,4)*100)."%";
                                $precTotal += $value;
                            ?></td>
                                <td><?php echo $recall[$key];//." = ".(round($recall[$key],4)*100)."%";
                                $reccTotal += $recall[$key];
                            ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>                                
            </div>
                <span class="label label-info">Precision Total : <?php echo (round($precTotal/count($precision),4)*100)."%";?></span>
                <span class="label label-info">Recall Total : <?php echo (round($reccTotal/count($recall),4)*100)."%";?></span>                
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