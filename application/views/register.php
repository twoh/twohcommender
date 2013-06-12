<?php include 'header.php' ?>
<div class="container"  >
    <div class="row-fluid">
        <div class="span8">
            <ul class="thumbnails">
                <li class="span12">
                    <div class="thumbnail">
                        <img class="img-rounded" src="<?php echo base_url() ?>img/classroom.jpg" width="800px" height="600px" alt="">
                        <div class="caption">
                            <h3>Temukan Mata Kuliah Pilihan yang Cocok</h3>
                            <p>Daftar sekarang juga dan temukan mata kuliah pilihan yang cocok dengan bakat dan minatmu.
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>    
        <div class="span4">        
            <?php
            $attributes = array('class' => 'well');
            echo form_open("register/registration", $attributes);
            ?>

            <h2>Daftar</h2>

            <?php echo validation_errors(''); ?>

            <div class="input-prepend control-group">                
                <input class="input-block-level" id="prependedInput" name="user_name" type="text" placeholder="Username" value="<?php echo set_value('user_name'); ?>"/>
            </div>            
            <div class="input-prepend control-group">                
                <input class="input-block-level" id="prependedInput" name="email_address" type="text" placeholder="Email" value="<?php echo set_value('email_address'); ?>"/>
            </div>            
            <div class="input-prepend control-group">                
                <input class="input-block-level" id="prependedInput" name="password" value="<?php echo set_value('password'); ?>" type="password" placeholder="Password" />
            </div>            
            <div class="input-prepend control-group">                
                <input class="input-block-level" id="prependedInput" name="con_password" value="<?php echo set_value('con_password'); ?>" type="password" placeholder="Confirm Password"/>
            </div>            
            <input type="submit" class="btn btn-large btn-primary" value="Submit" />

            <?php echo form_close(); ?>
            
            <div class="well">
            <h2 >Sudah Mendaftar?</h2>            
            <a href="<?php echo base_url() ?>login/index.twh" class="btn btn-large btn-warning" type="submit">Login di Sini</a>
            </div>
        </div>   
    </div>
</div>
<?php include 'footer.php' ?>