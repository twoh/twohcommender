<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.MetaData.js"> </script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.rating.js"> </script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/css/jquery.rating.css"/>
<script type="text/javascript" language="javascript">
	$(function(){ 
	 $('#form1 :radio.star').rating(); 	 
	});
	</script>
	<!--<script>
	$(function(){
	 $('#tab-Testing form').submit(function(){	  
	  $('input',this).each(function(){
	   if(this.checked)
               {
                $rating=this.value;
                $('#ratingbox').attr('value',$rating);                                            
               }               
            });
	  return false;
	 });
	});
	</script>
        -->
<div class="alert alert-info">            
    <div id="tab-Testing">
            <?php foreach ($mk->result() as $mks): ?>
        <?php 
        $attributes = array('id' => 'form1');
        echo form_open("user/do_insert_rating",$attributes); ?>
        <?php echo validation_errors(''); ?>
        <h3 name="namamk"><?php echo $mks->nama_mk?></h3>                    
        <p><?php echo $mks->deskripsi;    
                ?></p> 
        <h4>Rating user lain :</h4>
        <?php 
        if($komentar == NULL)
        {
         ?>
        <p>Belum ada rating.</p>
             <?php   
        }else
        {
        foreach ($komentar as $key => $value) {
        ?>
        <p><?php echo $key." memberi rating ".$value ?></p> 
        <?php 
            }
        }
        ?>
        
        <h4>Beri rating : </h4>        
        <div id="rating">
                <input class="star {split:2}" type="radio" name="test-4-rating-3" value="0.5"/>
                <input class="star {split:2}" type="radio" name="test-4-rating-3" value="1"/>
                <input class="star {split:2}" type="radio" name="test-4-rating-3" value="1.5"/>
                <input class="star {split:2}" type="radio" name="test-4-rating-3" value="2"/>
                <input class="star {split:2}" type="radio" name="test-4-rating-3" value="2.5"/>
                <input class="star {split:2}" type="radio" name="test-4-rating-3" value="3"/>
                <input class="star {split:2}" type="radio" name="test-4-rating-3" value="3.5"/>
                <input class="star {split:2}" type="radio" name="test-4-rating-3" value="4"/>
                <input class="star {split:2}" type="radio" name="test-4-rating-3" value="4.5"/>
                <input class="star {split:2}" type="radio" name="test-4-rating-3" value="5"/>
        </div> 
        <br/>
        <br/>
        <input type="hidden" class="input-block-level" name="idmk" value="<?php echo $mks->id_mk?>" readonly="readonly"/>        
        <input type="hidden" id="iduser" class="input-block-level" name="iduser" value="<?php print_r($this->session->userdata('user_id'))?>" readonly="readonly"/>        
        <textarea rows="3" class="input-block-level" name="komentar" placeholder="Berikan Komentar"></textarea>            
        <button class="btn btn-large btn-primary" type="submit">Tambah</button>
        <a class="btn pull-right" onclick="addRating(<?php echo $mks->id_mk?>)">Cancel</a>                    
        <?php echo form_close(); ?>     
                <?php endforeach;?>         
        </div>    
    </div>