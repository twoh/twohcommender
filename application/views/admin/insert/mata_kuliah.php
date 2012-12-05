<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

    <div class="">      
        <?php 
        $attributes = array('class' => 'alert alert-info');
        echo form_open("admin/do_insert_mk",$attributes); ?>
        <?php echo validation_errors(''); ?>
        <h3>Insert Mata Kuliah</h3>
        <input type="text" class="input-block-level" name="namamk" placeholder="Nama MK"/>
        <input type="text" class="input-block-level" name="sks" placeholder="SKS"/>
        <textarea row="3" class="input-block-level" name="deskripsi" placeholder="Deskripsi"></textarea>
        <input type="text" class="input-block-level" name="kk" placeholder="Kelompok Keahlian"/>
        <button class="btn btn-large btn-primary" type="submit">Tambah</button>
        <?php echo form_close(); ?>      
    </div>
