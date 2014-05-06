<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.MetaData.js"> </script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.rating.js"> </script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/css/jquery.rating.css"/>
<script type="text/javascript" language="javascript">
    $(function(){ 
        $('#form1 :radio.star').rating(); 	 
    });
</script>
<div class="alert alert-info">
    <h3>Edit Rating
        <small><?php echo $namaMK ?></small>
    </h3>

    <?php foreach ($mk->result() as $mks): ?>
        <?php echo form_open("user/do_edit_rating"); ?>
        <?php echo validation_errors(''); ?>
        <input type="text" class="input-block-level" name="idmk" value="<?php echo $mks->id_mk ?>" readonly="readonly"/>                                
        <p>Rating: </p>
        <div id="rating">
            <?php
            for ($i = 1; $i < 6; $i++) {
                if ($i == $mks->rating) {
                    ?>
                    <input class="star" type="radio" name="rating" value="<?php echo $mks->rating ?>" checked="checked"/>                
                    <?php
                } else {
                    ?>            
                    <input class="star" type="radio" name="rating" value="<?php echo $i ?>"/>
                    <?php
                }
            }
            ?>
        </div>
        <br>
        <textarea maxlength="280" rows="3" class="input-block-level" name="review"><?php echo $mks->review ?></textarea>            
        <button class="btn btn-large btn-primary" type="submit">Edit</button>
        <a class="btn pull-right" onclick="editMK(<?php echo $mks->id_mk ?>)">Cancel</a>
    <?php echo form_close(); ?>     
<?php endforeach; ?>


</div>
