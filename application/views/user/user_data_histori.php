<div class="row">
    <div class="span8">
        
        <h3>Lihat Data Histori Nilai</h3>
        <p>
        Di halaman ini Anda bisa melihat data histori nilai Anda.
        <br/>        
        </p>
        <?php
        if($histori->num_rows())
        {
        ?>
        <a class="btn" href="<?php echo base_url() . 'user/lihat_histori_nilai.twh' ?>">Lihat Histori Nilai</a>
        <?php
        }else{
            ?>
        <p>
            Belum ada histori nilai.
        </p>
        <a class="btn" href="<?php echo base_url() . 'user/tambah_histori_nilai.twh' ?>">Tambah Histori Nilai</a>
        <?php
        }
        ?>
    </div>

</div>
