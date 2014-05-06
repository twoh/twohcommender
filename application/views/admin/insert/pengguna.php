<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="alert alert-info">      
        
        <h3>Tambah Pengguna</h3>
        <?php echo form_open("admin/do_insert_user") ?>
        
        <input type="text" class="input-block-level" name="user_name" placeholder="Username"/>
        <input type="text" class="input-block-level" name="password" placeholder="Password"/>
        <input type="text" class="input-block-level" name="email_address" placeholder="Email"/>
        <button class="btn btn-large btn-primary" type="submit">Tambah</button>
        <?php echo form_close(); ?>      
</div>