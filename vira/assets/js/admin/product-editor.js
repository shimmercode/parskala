jQuery(function($){

    // باز شدن آپلود مدیا و درج در فیلد تصویر دوم شاخص محصول
    $('body').on('click', '.aw_img_up_pro', function(e){
        e.preventDefault();

        var button = $(this),
        aw_uploader = wp.media({
            title: 'انتخاب',
            library : {
                uploadedTo : wp.media.view.settings.post.id,
                type : ''
            },
            button: {
                text: 'درج'
            },
            multiple: false
        }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();
            $('#img_up_pro').val(attachment.url);
        })
        .open();
    });

      // چک باکس محصول غیر اصل
      if($('#product_facke_brand_show').is(":checked")) {
          $(".product_facke_brand_text_field").show();
      }else{
          $(".product_facke_brand_text_field").hide();
      }
      // SHOW/HIDE ELEMENTS VIA CHECKBOX STATUS
      $('[id="product_facke_brand_show"]').change(function()
      {
        if ($(this).is(':checked'))
            $(".product_facke_brand_text_field").fadeIn();
        else
            $(".product_facke_brand_text_field").fadeOut();
      });

      // چک باکس بازگشت محصول
      if($('#product_return_show').is(":checked")) {
          $(".product_return_text_field").show();
      }else{
          $(".product_return_text_field").hide();
      }
      // SHOW/HIDE ELEMENTS VIA CHECKBOX STATUS
      $('[id="product_return_show"]').change(function()
      {
        if ($(this).is(':checked'))
            $(".product_return_text_field").fadeIn();
        else
            $(".product_return_text_field").fadeOut();
      });

        // چک باکس گارانتی محصول
        if($('#product_granti_show').is(":checked")) {
            $(".product_granti_text_field").hide();
        }else{
            $(".product_granti_text_field").show();
        }
        // SHOW/HIDE ELEMENTS VIA CHECKBOX STATUS
        $('[id="product_granti_show"]').change(function()
        {
          if ($(this).is(':checked'))
              $(".product_granti_text_field").fadeOut();
          else
              $(".product_granti_text_field").fadeIn();
        });

          // چک باکس اصالت محصول
          if($('#product_Original_show').is(":checked")) {
              $(".product_Original_text_field").hide();
          }else{
              $(".product_Original_text_field").show();
          }
          // SHOW/HIDE ELEMENTS VIA CHECKBOX STATUS
          $('[id="product_Original_show"]').change(function()
          {
            if ($(this).is(':checked'))
                $(".product_Original_text_field").fadeOut();
            else
                $(".product_Original_text_field").fadeIn();
          });

          // چک باکس سامانه همتا
          if($('#product_hamta_show').is(":checked")) {
              $(".product_hamta_text_field").show();
          }else{
              $(".product_hamta_text_field").hide();
          }
          // SHOW/HIDE ELEMENTS VIA CHECKBOX STATUS
          $('[id="product_hamta_show"]').change(function()
          {
            if ($(this).is(':checked'))
                $(".product_hamta_text_field").fadeIn();
            else
                $(".product_hamta_text_field").fadeOut();
          });

});