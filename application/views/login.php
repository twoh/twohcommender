<?php include 'header.php';?>
<div class="container">
    <div class="span4">
      
        <?php 
        $attributes = array('class' => 'well');
        echo form_open("login/do_login",$attributes); ?>
        <h2 >Sign in</h2>
        <input type="text" class="input-block-level" name="email" placeholder="Email address"/>
        <input type="password" class="input-block-level" name="password" placeholder="Password"/>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"/> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
        <?php echo form_close(); ?>
      
    </div>
</div>
<?php include 'footer.php'?>