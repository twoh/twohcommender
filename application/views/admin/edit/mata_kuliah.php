<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    
?>

    <div class="alert alert-warning">      
        <?php 
        echo form_open("admin/do_insert_mk"); ?>
        <?php echo validation_errors(''); ?>
        <h3>Edit Mata Kuliah</h3>
        <?php        foreach ($mk->result() as $mks): ?>
        <input type="text" class="input-block-level" name="namamk" value="<?php echo $mks->nama_mk?>"/>
        <input type="text" class="input-block-level" name="sks" value="<?php echo $mks->sks?>"/>
        <textarea rows="3" class="input-block-level" name="deskripsi"><?php echo $mks->deskripsi?></textarea>
        <input type="text" class="input-block-level" name="kk" value="<?php echo $mks->kelompok_keahlian?>"/>
        <button class="btn btn-large btn-primary" type="submit">Edit</button>
        <a class="btn pull-right" onclick="editMK(<?php echo $mks->id_mk?>)">Cancel</a>
        <?php endforeach;?>
        <?php echo form_close(); ?>      
        
    </div>