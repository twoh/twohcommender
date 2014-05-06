<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
 <div class="alert alert-warning">
            <h3>Edit Pengguna</h3>
            <?php        foreach ($users->result() as $mks): ?>
        <?php echo form_open("admin/do_edit_user"); ?>
        <?php echo validation_errors(''); ?>
            <input type="text" class="input-block-level" name="id_user" value="<?php echo $mks->id_user?>" readonly="readonly"/>
            <input type="text" class="input-block-level" name="username" value="<?php echo $mks->user_name?>"/>
            <input type="text" class="input-block-level" name="email" value="<?php echo $mks->email?>"/>
            <button class="btn btn-large btn-primary" type="submit">Edit</button>
            <a class="btn pull-right" href="" onclick="editUser(<?php echo $mks->id_user?>)">Cancel</a>
        <?php echo form_close(); ?>     
                <?php endforeach;?>
         
        
    </div>