function prk_show_add_to_cart_success_massage() {

  jQuery("#cart_content_modal").addClass("toggle");
  jQuery(".prk_open_mini_cart").addClass("close");
  jQuery("html").addClass("inner_hidden");
  jQuery(".navigation-overlay").fadeIn(100);

}

(function ($) {

  $(document.body).on("added_to_cart", function () {

    if ($(".single_add_to_cart_button ").hasClass("opnened_mcart") && jQuery('header ').hasClass('desctop')){

      function isEmpty( el ){
          return !$.trim(el.html())
      }
      if (isEmpty($('.wc-variation-is-unavailable'))) {
        prk_show_add_to_cart_success_massage();
      }

    }

  });

})(jQuery);



/* Wc add to cart version 2.2 */
jQuery(function ($) {
  // wc_add_to_cart_params is required to continue, ensure the object exists
  if (typeof wc_add_to_cart_params === "undefined") return false;

  // Ajax add to cart
  $(document).on(
    "click",
    ".variations_form .single_add_to_cart_button",
    function (e) {
      e.preventDefault();

      $variation_form = $(this).closest(".variations_form");
      var var_id = $variation_form.find("input[name=variation_id]").val();
      var product_id = $variation_form.find("input[name=product_id]").val();
      var quantity = $variation_form.find("input[name=quantity]").val();

      //attributes = [];
      $(".ajaxerrors").remove();
      var item = {},
        check = true;

      variations = $variation_form.find("select[name^=attribute]");

      /* Updated code to work with radio button - mantish - WC Variations Radio Buttons - 8manos */
      if (!variations.length) {
        variations = $variation_form.find("[name^=attribute]:checked");
      }

      /* Backup Code for getting input variable */
      if (!variations.length) {
        variations = $variation_form.find("input[name^=attribute]");
      }

      variations.each(function () {
        var $this = $(this),
          attributeName = $this.attr("name"),
          attributevalue = $this.val(),
          index,
          attributeTaxName;

        $this.removeClass("error");

        if (attributevalue.length === 0) {
          index = attributeName.lastIndexOf("_");
          attributeTaxName = attributeName.substring(index + 1);

          $this
            .addClass("required error")
            .before(
              '<div class="ajaxerrors"><p>Please select ' +
                attributeTaxName +
                "</p></div>"
            );

          check = false;
        } else {
          item[attributeName] = attributevalue;
        }
      });

      if (!check) {
        return false;
      }

      var $thisbutton = $(this);

      if ($thisbutton.is(".variations_form .single_add_to_cart_button")) {
        $thisbutton.removeClass("added");
        $thisbutton.addClass("loading");

        var data = {
          action: "woocommerce_add_to_cart_variable_rc",
        };

        $variation_form.serializeArray().map(function (attr) {
          if (attr.name !== "add-to-cart") {
            if (attr.name.endsWith("[]")) {
              let name = attr.name.substring(0, attr.name.length - 2);
              if (!(name in data)) {
                data[name] = [];
              }
              data[name].push(attr.value);
            } else {
              data[attr.name] = attr.value;
            }
          }
        });

        // Trigger event
        $("body").trigger("adding_to_cart", [$thisbutton, data]);

        // Ajax action
        $.post(wc_add_to_cart_params.ajax_url, data, function (response) {
          if (!response) {
            return;
          }

          if (response.error && response.product_url) {
            window.location = response.product_url;
            return;
          }

          // Redirect to cart option
          if (wc_add_to_cart_params.cart_redirect_after_add === "yes") {
            window.location = wc_add_to_cart_params.cart_url;
            return;
          }

          // Trigger event so themes can refresh other areas.
          $(document.body).trigger("added_to_cart", [
            response.fragments,
            response.cart_hash,
            $thisbutton,
          ]);
          $("a.added_to_cart").hide(0);
        });

        return false;
      } else {
        return true;
      }
    }
  );
});

jQuery(document).ready(function ($) {
  $(".product-type-simple .single_add_to_cart_button").on(
    "click",
    function (e) {
      e.preventDefault();

      ($thisbutton = $(this)),
        ($form = $thisbutton.closest("form.cart")),
        (id = $thisbutton.val()),
        (product_qty = $form.find("input[name=quantity]").val() || 1),
        (product_id = $form.find("input[name=product_id]").val() || id),
        (variation_id = $form.find("input[name=variation_id]").val() || 0);
      /*
    var data = {

            action: 'ql_woocommerce_ajax_add_to_cart',

            product_id: product_id,

            product_sku: '',

            quantity: product_qty,

            variation_id: variation_id,

        };
*/
      var data = {
        action: "ql_woocommerce_ajax_add_to_cart1",
        product_id: product_id,
      };

      $form.serializeArray().map(function (attr) {
        if (attr.name !== "add-to-cart") data[attr.name] = attr.value;
      });

      $.ajax({
        type: "post",

        url: wc_add_to_cart_params.ajax_url,

        data: data,

        beforeSend: function (response) {
          $thisbutton.removeClass("added").addClass("loading");

        },

        complete: function (response) {
          $thisbutton.addClass("added").removeClass("loading");

        },

        success: function (response) {

          if (response.error && response.product_url) {
            window.location = response.product_url;

            return;
          } else {
            $(document.body).trigger("added_to_cart", [
              response.fragments,
              response.cart_hash,
              $thisbutton,
            ]);
            $("a.added_to_cart").hide(0);
          }
        },
      });
    }
  );
});


if (jQuery(".product_type_simple.add_to_cart_button.ajax_add_to_cart,.single_add_to_cart_button").length ){

  jQuery(".product_type_simple.add_to_cart_button.ajax_add_to_cart,.single_add_to_cart_button:not(.disabled)").on("click", function () {
    if ( ! jQuery('button').hasClass('disabled') ) {
      jQuery(".onliner_main_loading").addClass('stm-sms-load');
    }
  });



}


jQuery(document.body).on("added_to_cart", function () {
if ( ! jQuery('body').hasClass('elementor-editor-active') && ! jQuery('button').hasClass('disabled') ) {


  jQuery(".onliner_main_loading").removeClass('stm-sms-load');


}
});