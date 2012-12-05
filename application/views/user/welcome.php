<?php

//echo 'WELCOME halaman login';
?>
<div class="container">
	
	<div class="span-12 pull-right">
            <?php
            $data = array(
                'name' => 'logout',
                'id' => 'logout',
                'class' => 'btn btn-danger'
            );

            echo anchor('user/logout', 'Log Out', $data);

            ?>
        </div>
</div>
