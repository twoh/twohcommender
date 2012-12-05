<?php include 'header.php' ?>
<div class="container"  >
    <div class="span4">
        
        <?php 
        $attributes = array('class' => 'well');
        echo form_open("register/registration",$attributes); ?>
        
        <h2>Daftar</h2>
       
            <?php echo validation_errors(''); ?>
       
        <div class="input-prepend control-group">
            <span class="add-on span5">Username</span>
            <input class="input-medium" id="prependedInput" name="user_name" type="text" placeholder="Username" value="<?php echo set_value('user_name'); ?>"/>
        </div>
        <br/>
        <div class="input-prepend control-group">
            <span class="add-on span5">&nbsp;&nbsp;&nbsp;&nbsp;Email&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <input class="input-medium" id="prependedInput" name="email_address" type="text" placeholder="Email" value="<?php echo set_value('email_address'); ?>"/>
        </div>
        <br/>
        <div class="input-prepend control-group">
            <span class="add-on span5">&nbsp;Password&nbsp;</span>
            <input class="input-medium" id="prependedInput" name="password" value="<?php echo set_value('password'); ?>" type="password" placeholder="Password" />
        </div>
        <br/>
        <div class="input-prepend control-group">
            <span class="add-on span5">&nbsp;&nbsp;Confirm&nbsp;&nbsp;</span>
            <input class="input-medium" id="prependedInput" name="con_password" value="<?php echo set_value('con_password'); ?>" type="password" placeholder="Confirm Password"/>
        </div>
        <br/>
        <input type="submit" class="btn btn-primary" value="Submit" />
        
        <?php echo form_close(); ?>
    </div>
</div>
<?php include 'footer.php' ?>