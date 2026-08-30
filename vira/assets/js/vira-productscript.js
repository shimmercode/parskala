/* app/Woocommerce/Single/Features/assets/js/prk-variation-features.js */
(function ($) {

  function ensureTargetAfterTable($form){
    var $table  = $form.find('table.variations').first();
    if (!$table.length) return;

    var $target = $('#prk-variation-features');
    if (!$target.length) {
      $target = $('<div id="prk-variation-features" class="prk-variation-features" aria-live="polite"></div>');
    }

    // اگر همین‌جا نیست، بیارش دقیقاً بعد از جدول
    if (!$target.prev().is($table)) {
      $table.after($target);
    }
  }

  function bindVariationEvents($form){
    var $target = $('#prk-variation-features');
    if (!$target.length) return;

    $form.on('found_variation', function (e, variation) {
      var html = variation && variation.variation_description ? variation.variation_description : '';
      if (html && html.trim()) {
        $target.html(html).stop(true,true).slideDown(150);
      } else {
        $target.empty().hide();
      }
    });

    $form.on('reset_data hide_variation', function () {
      $target.empty().hide();
    });

    // اگر از قبل وریشن ست شده
    var vid = $form.find('input.variation_id').val();
    if (vid) {
      var vars = $form.data('product_variations') || [];
      var match = vars.find(v => String(v.variation_id) === String(vid));
      if (match) $form.trigger('found_variation', [match]);
    }
  }

  $(function () {
    $('form.variations_form').each(function(){
      var $form = $(this);
      ensureTargetAfterTable($form);
      bindVariationEvents($form);
    });

    // اگر افزونه‌ها جدول را بازسازی کنند، دوباره جابجا کن
    $(document).on(
      'wc_variation_form woocommerce_update_variation_values woocommerce_variation_has_changed',
      'form.variations_form',
      function(){ ensureTargetAfterTable($(this)); }
    );
  });

})(jQuery);
