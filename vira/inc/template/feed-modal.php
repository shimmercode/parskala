<?php
global $woocommerce;
global $product;

 ?>
 <!-- start of quick-view-modal -->
 <div class="remodal modal-feed remodal-lg remodal-maxed" data-remodal-id="modal-feed" data-remodal-options="hashTracking: false">

   <div class="remodal-header">
      <span class="title-feed"><?= _e('Your feedback about','parskala') ?> <?php the_title();?></span>
      <button data-remodal-action="close" class="remodal-close"></button>
   </div>

   <div class="cover-loading-replay"></div>

   <div class="flexright">

     <div class="img-feed">
         <?php echo get_the_post_thumbnail(get_the_ID(), 'shop_catalog', array( 'class' => 'center' ) ); ?>
     </div>

  	 <div class="info-feed">
       <p class="p-chexboxed">
       <input type="checkbox" id="product_name"><label for="product_name"> <?= _e('The product name is not correct','parskala') ?> </label>
       </p>
       <p class="p-chexboxed">
       <input type="checkbox" id="product_thumb" ><label for="product_thumb"><?= _e('Product photos are not suitable','parskala') ?></label>
       </p>
       <p class="p-chexboxed">
       <input type="checkbox" id="product_checked"><label for="product_checked"><?= _e('The technical specifications of the product are not correct','parskala') ?></label>
       </p>
       <p class="p-chexboxed">
       <input type="checkbox" id="product_des"><label for="product_des"><?= _e('The product description is not correct','parskala') ?></label>
       </p>
      <span><?= _e('Write your feedback','parskala') ?></span>
  		<textarea class="user-feed" placeholder="<?= _e('Description','parskala') ?>"></textarea>
  		<span data-remodal-action="close" class="insert-feed"><?= _e('Record information','parskala') ?></span>
  	 </div>

   </div>

</div>


	<script>
	    jQuery(document).ready(function($){
	        $('.insert-feed').click(function(){

	            $('.cover-loading-replay').show(0);

				ch_product_name = $('#product_name').prop('checked');
				ch_product_thumb = $('#product_thumb').prop('checked');
				ch_product_checked = $('#product_checked').prop('checked');
				ch_product_des = $('#product_des').prop('checked');

				var checkboxes ={
					"product_name" : ch_product_name,
					"product_thumb" : ch_product_thumb,
					"product_checked" : ch_product_checked,
					"product_des" : ch_product_des
				};

	            $.post(parskala_values.ajax_url,
	            {
	                action: "inset_feed_product",
	                product_id: "<?php echo $product->get_id(); ?>",
	                content: $('.user-feed').val(),
					checkboxes : checkboxes
	            },
	            function(data, status){
	                alert(data);
	                $('.user-feed').val('');
	                $('.feed.micromodal-slide').removeClass('is-open');
									$(".body").css("overflow", "unset");
									$(".body").css("height", "unset");
									$('.feed-btn').removeClass('show');
									$('.feed-btn.thanks').addClass('show');
	                $('.cover-loading-replay').hide(0);
	            });
	        });

	    });
	</script>
