<?php

$prk_preloader_img = prk_option('prk_preloader_img');

 ?>
<div class="prk-preload-wrap">

 <?php if ($prk_preloader_img['url']): ?>
   <div id="prk-preload-logo">
     <img alt="prk-preload-logo" src="<?= $prk_preloader_img['url']?>">
   </div>
 <?php endif; ?>


<div id="prk-preload-gif">
  <div class="lds-ring">
    <div>
    </div>
    <div>
    </div>
    <div>
    </div>
    <div>
    </div>
  </div>
</div>

</div>
