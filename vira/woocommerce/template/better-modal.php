<?php
  global $woocommerce;
  global $product;

 ?>
 <!-- start of quick-view-modal -->
 <div class="remodal modal-better remodal-lg remodal-maxed" data-remodal-id="modal-better" data-remodal-options="hashTracking: false">

   <div class="remodal-header">
      <span class="title-feed">گزارش قیمت برای  <?php the_title();?></span>
      <button data-remodal-action="close" class="remodal-close"></button>
   </div>

      <div class="cover-loading-replay"></div>

        <div class="flexright">
         <div class="img-feed">
             <?php echo get_the_post_thumbnail(get_the_ID(), 'shop_catalog', array( 'class' => 'center' ) ); ?>
         </div>
				 <div class="info-feed">
        <p class="form-better show">
      <label for="better_price">این کالا را با چه قیمتی دیده‌اید؟</label>
      <input type="text" name="better_price" id="better_price" placeholder="<?= _e('For example, 42,000','vira') ?>">
      <span class="input_better">تومان</span>
        </p>
       <div class="flex_right swicher">
        <label class="switch">
          <input id="swich_before" type="checkbox" class="check_before" checked>
          <span class="slider"></span>
          </label>
            <label class="swich_before" for="swich_before">در فروشگاه اینترنتی دیده‌ام</label>
           </div>
        <p class="form-better site show">
      <label for="better_price">آدرس اینترنتی فروشگاه</label>
      <input type="text" name="better_url" id="better_url" placeholder="www.example.com">
        </p>
        <p class="form-better shop">
      <label for="better_price">نام فروشگاه</label>
      <input type="text" name="better_name" id="better_name">
        </p>
        <p class="form-better shop">
      <label for="better_price">مکان فروشگاه</label>
      <input type="text" name="better_city" id="better_city" placeholder="تهران">
        </p>
        <span data-remodal-action="close" class="insert-better">ثبت اطلاعات</span>
         </div>
        </div>
</div>

	<script>
	    jQuery(document).ready(function($){

        $('.check_before').on('click', function(){
            is_checked = $(this).is(':checked');
            if(is_checked == true){
              $('.form-better.site').addClass('show');
              $('.form-better.shop').removeClass('show');
             }else{
               $('.form-better.site').removeClass('show');
               $('.form-better.shop').addClass('show');
            }
          });

	        $('.insert-better').click(function(){
            var button_replay = $(this);
             if ( button_replay.parent().parent().find('#better_price').val() == '' ) {
                 alert('<?php _e('لطفا قیمت را وارد کنید.', 'vira'); ?>');
                 return;
             }
	            $('.cover-loading-replay').show(0);

	            $.post(vira_values.ajax_url,
	            {
	                action: "inset_better_product",
	                product_id: "<?php echo $product->get_id(); ?>",
                  shop_price: $('#better_price').val(),
                  website_url: $('#better_url').val(),
                  shop_name: $('#better_name').val(),
                  shop_city: $('#better_city').val(),
	            },
	            function(data, status){
	                alert(data);
	                $('.user-feed').val('');
	                $('.feed.micromodal-slide').removeClass('is-open');
									$(".body").css("overflow", "unset");
									$(".body").css("height", "unset");
									$('.better-btn').removeClass('show');
									$('.better-btn.thanks').addClass('show');
	                $('.cover-loading-replay').hide(0);
	            });
	        });

	    });
	</script>
