<?php
// سرویس های محصول

function prk_services(){

  $product_services = "";
  $pic1 = $pic2 = $pic3 = $pic4 = $pic5 = "";

$product_services = prk_option('single_product_services');
$services_sngl_1_pic = prk_option('services_sngl_1_pic');

if(isset($services_sngl_1_pic['url']) && $services_sngl_1_pic['url'] != '') { $pic1 = $services_sngl_1_pic['url']; }

$services_sngl_2_pic = prk_option('services_sngl_2_pic');
if(isset($services_sngl_2_pic['url']) && $services_sngl_2_pic['url'] != '') { $pic2 = $services_sngl_2_pic['url']; }

$services_sngl_3_pic = prk_option('services_sngl_3_pic');
if(isset($services_sngl_3_pic['url']) && $services_sngl_3_pic['url'] != '') { $pic3 = $services_sngl_3_pic['url']; }

$services_sngl_4_pic = prk_option('services_sngl_4_pic');
if(isset($services_sngl_4_pic['url']) && $services_sngl_4_pic['url'] != '') { $pic4 = $services_sngl_4_pic['url']; }

$services_sngl_5_pic = prk_option('services_sngl_5_pic');
if(isset($services_sngl_5_pic['url']) && $services_sngl_5_pic['url'] != '') { $pic5 = $services_sngl_5_pic['url']; }

$flexed = prk_option('subservices_1') ? 'flexed' : '';

$have_sub = prk_option('subservices_1') ? 'have_sub' : '';

?>
<?php if ($product_services): ?>


  <?php if ( $pic1 || $pic2 || $pic3 || $pic4 || $pic5 ):?>
  <div class="servesis-single <?= $have_sub ?>" id="servesis-single">

    <?php if ($pic1): ?>
  	<article class="servis-single">
  		<a class="<?= $flexed ?>" href="<?php echo prk_option('services_sngl_1_url');?>">
      	<img src="<?php echo esc_url($pic1); ?>" alt="servises">

        <div class="flexed-clomen">
          
           <span><?php echo prk_option('services_sngl_1');?></span>
            <?php if (prk_option('subservices_1')){
              echo '<p>'.prk_option('subservices_1').'</p>';
            }?>
           

        </div>
      	
  	  </a>
  	</article>
    <?php endif; ?>

    <?php if ($pic2): ?>
      <article class="servis-single">
    		<a class="<?= $flexed ?>" href="<?php echo prk_option('services_sngl_2_url');?>">
        	<img src="<?php echo esc_url($pic2); ?>" alt="servises">
          <div class="flexed-clomen">
          
          <span><?php echo prk_option('services_sngl_2');?></span>
           <?php if (prk_option('subservices_2')){
             echo '<p>'.prk_option('subservices_2').'</p>';
           }?>
          

       </div>
      	</a>
    	</article>
    <?php endif; ?>


    <?php if ($pic3): ?>
      <article class="servis-single">
        <a class="<?= $flexed ?>" href="<?php echo prk_option('services_sngl_3_url');?>">
      <img src="<?php echo esc_url($pic3); ?>" alt="servises">
      <div class="flexed-clomen">
          
          <span><?php echo prk_option('services_sngl_3');?></span>
           <?php if (prk_option('subservices_3')){
             echo '<p>'.prk_option('subservices_3').'</p>';
           }?>
          

       </div>
      </a>
      </article>
    <?php endif; ?>


    <?php if ($pic4): ?>
      <article class="servis-single">
    		<a class="<?= $flexed ?>" href="<?php echo prk_option('services_sngl_4_url');?>">
    	<img src="<?php echo esc_url($pic4); ?>" alt="servises">
      <div class="flexed-clomen">
          
          <span><?php echo prk_option('services_sngl_4');?></span>
           <?php if (prk_option('subservices_4')){
             echo '<p>'.prk_option('subservices_4').'</p>';
           }?>
          

       </div>
    	</a>
    	</article>
    <?php endif; ?>


    <?php if ($pic5): ?>
      <article class="servis-single">
        <a class="<?= $flexed ?>" href="<?php echo prk_option('services_sngl_5_url');?>">
      <img src="<?php echo esc_url($pic5); ?>" alt="servises">
      <div class="flexed-clomen">
          
          <span><?php echo prk_option('services_sngl_5');?></span>
           <?php if (prk_option('subservices_5')){
             echo '<p>'.prk_option('subservices_5').'</p>';
           }?>
          

       </div>
      </a>
      </article>
    <?php endif; ?>


  </div>
<?php endif; ?>
  <?php endif;?>

  <?php

}
