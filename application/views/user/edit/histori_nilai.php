<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="container-fluid">
    <?php $this->load->view('user/user_db'); ?>
    <div class="row-fluid">
        <div class="span6">
            <h3>
                <a class="btn" href="javascript:javascript:history.go(-1)" ><i id="back" class="icon-backward"></i></a>
                Edit Histori Nilai User <?php $this->session->userdata('user_id') ?>
            </h3>
            <div id="dataMK">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID MK</th>
                            <th>Kode MK</th>
                            <th>Nama MK</th>
                            <th>Nilai</th>                                                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        echo form_open("user/do_edit_histori_nilai");
                        $nilai = array();
                        foreach ($results->result_array() as $rating):
                            $nilai[$rating['id_mk']]=$rating['rating'];                            
                        endforeach;
                        //$rows_array = $query->result_array();
                        //$nilai = $results->result();
                        foreach ($results2->result() as $mks):
                            ?>
                            <tr>     
                                <td>
                                    <input type="text" class="input-block-level" name="idMK[]" value="<?php echo $mks->id_mk?>" readonly="readonly"/>
                                </td>
                                <td><?php echo $mks->kode_mk;
                            ?></td>
                                <td><?php echo $mks->nama_mk;
                            ?></td>
                                <td>
                                    <select name="nilai[]"><?php
                                    if($nilai[$mks->id_mk]>0)
                                    {
                                        $the_key = $nilai[$mks->id_mk]; // or whatever you want
                                    }else
                                    {
                                        $the_key=0;
                                    }
                                foreach (
                                array(
                                    0 => '',
                                    5 => 'A',
                                    4 => 'B',
                                    3 => 'C',
                                    2 => 'D',
                                    1 => 'E'
                                ) as $key => $val) {
                                ?><option value="<?php echo $key; ?>"<?php
                                    if ($key == $the_key)
                                        echo ' selected="selected"';
                                ?>><?php echo $val; ?></option><?php
                                        }
                            ?></select>
                                </td>                                                                
                            </tr>
                            <?php
                        endforeach;
                        ?>
                           
                    </tbody>
                </table>    
                 <button class="btn btn-large btn-primary" type="submit">Edit</button>
                            <?php
                        echo form_close();
                        ?>
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