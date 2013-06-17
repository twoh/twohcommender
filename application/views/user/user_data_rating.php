<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    
?>

<div class="row">
    <div class="span8">        
            <h3>Lihat Data Rating Mata Kuliah Pilihan</h3>
            <p>
            Di halaman ini Anda bisa melihat rating terhadap mata kuliah yang pernah diambil.
        </p>
        <?php
        if($rating->num_rows())
        {
        ?>
        <a class="btn" href="<?php echo base_url().'user/lihat_rating.twh'?>">Lihat Rating Matakuliah</a>
        <?php
        }else{
            ?>
        <p>
            Belum ada data rating.
        </p>
        <a class="btn" href="<?php echo base_url() . 'user/lihat_mk.twh' ?>">Tambah Rating</a>
        <?php
        }
        ?>                        
    </div>
    
</div>
