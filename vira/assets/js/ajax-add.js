/* =========================================================
 * THWVSF Fix: prevent jQuery selector crash on % encoded class names
 * MUST load before thwvsf-public.js
 * ========================================================= */
(function ($) {
  const esc = $.escapeSelector || function (sel) {
    return String(sel).replace(/([ !"#$%&'()*+,./:;<=>?@[\\\]^`{|}~])/g, '\\$1');
  };

  const _find = $.fn.find;

  $.fn.find = function (selector) {
    if (typeof selector === 'string' && selector.indexOf('%') !== -1) {
      selector = selector.replace(/(^|[\s>+~])([.#])([^\s>+~]+)/g, function (_, pre, sig, name) {
        if (name.indexOf('%') === -1) return _;
        return pre + sig + esc(name);
      });
    }
    return _find.call(this, selector);
  };
})(jQuery);

function prk_show_add_to_cart_success_massage() {
  
  jQuery("#cart-sidebar").addClass("nasa-active");
  jQuery(".prk_open_mini_cart").addClass("close");
  jQuery("html").addClass("inner_hidden");
  jQuery(".navigation-overlay").fadeIn(100);
  // init_shipping_free_notification($);
}


function prk_after_added_to_cart(){
  // init_shipping_free_notification($);
  if ( prk_popup_go_cart == true && !jQuery(".single_add_to_cart_button").hasClass("opnened_mcart")  ) {
    const Toast = Swal.mixin({
      position: "center",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
  
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      },
    });
    Swal.fire({
        title: ajax_added_text,
        icon: "success",
        customClass: {
          popup: 'go-cart-popup',
        },
        showCancelButton: true,
        confirmButtonColor: prk_general_color,
        cancelButtonColor: "#5C677D",
        confirmButtonText: ajax_added_confirm_text,
        cancelButtonText: ajax_added_cancel_text,
      }).then((result) => {
        if (result.isConfirmed) {
          location.href=cart_url.ajax_url
        }else if ( result.dismiss  ){
          jQuery(".navigation-overlay").fadeOut(100);
          jQuery("html").removeClass("inner_hidden");
          if (jQuery('.prk_open_mini_cart').length) {
            jQuery(".prk_open_mini_cart").removeClass("close");
          }
          if (jQuery('.prk-static-sidebar').length) {
            jQuery('.prk-static-sidebar').removeClass('nasa-active');
          }
        }


      });


  }else {
      const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      Toast.fire({
        icon: 'success',
        title: ajax_added_text,
      })
  }

}

(function ($) {

  $(document.body).on("added_to_cart", function () {

    if ($(".single_add_to_cart_button ").hasClass("opnened_mcart") && jQuery('header').hasClass('desctop')){

      function isEmpty( el ){
          return !$.trim(el.html())
      }
      if (isEmpty($('.wc-variation-is-unavailable'))) {
        prk_show_add_to_cart_success_massage();
      }

    }

  });

})(jQuery);

(function ($) {

  $.fn.serializeArrayAll = function () {
    var rCRLF = /\r?\n/g;
    return this.map(function () {
      return this.elements ? jQuery.makeArray(this.elements) : this;
    }).map(function (i, elem) {
      var val = jQuery(this).val();
      if (val == null) {
        return val == null
        //next 2 lines of code look if it is a checkbox and set the value to blank 
        //if it is unchecked
      } else if (this.type == "checkbox" && this.checked === false) {
        return {name: this.name, value: this.checked ? this.value : ''}
        //next lines are kept from default jQuery implementation and 
        //default to all checkboxes = on
	  } else if (this.type === 'radio') {
        if (this.checked) {
          return {name: this.name, value: this.checked ? this.value : ''};
        }  	  
      } else {
        return jQuery.isArray(val) ?
                jQuery.map(val, function (val, i) {
                  return {name: elem.name, value: val.replace(rCRLF, "\r\n")};
                }) :
                {name: elem.name, value: val.replace(rCRLF, "\r\n")};
      }
    }).get();
  };


  $(document).on('click', '.single_add_to_cart_button:not(.disabled)', function (e) {

    var $thisbutton = $(this),
            $form = $thisbutton.closest('form.cart'),
            //quantity = $form.find('input[name=quantity]').val() || 1,
            //product_id = $form.find('input[name=variation_id]').val() || $thisbutton.val(),
            data = $form.find('input:not([name="product_id"]), select, button, textarea').serializeArrayAll() || 0;

    $.each(data, function (i, item) {
      if (item.name == 'add-to-cart') {
        item.name = 'product_id';
        item.value = $form.find('input[name=variation_id]').val() || $thisbutton.val();
      }
    });

    e.preventDefault();

    $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

//     console.log('ADD TO CART DATA:', data);
// console.log('variation_id in form:', $form.find('input[name="variation_id"]').val());

    $.ajax({
      type: 'POST',
      url: woocommerce_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
      data: data,
      beforeSend: function (response) {
        $thisbutton.removeClass('added').addClass('loading');
        jQuery(".onliner_main_loading").addClass('stm-sms-load');
      },
        complete: function (response) {
          $thisbutton.addClass('added').removeClass('loading');
          jQuery(".onliner_main_loading").removeClass('stm-sms-load');
        },
        success: function (response) {

          if (response.error && response.product_url) {
            window.location = response.product_url;
            return;
          }

          $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);

          prk_after_added_to_cart();
        },

    });

    return false;

  });
})(jQuery);




