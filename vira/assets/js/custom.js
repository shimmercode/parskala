jQuery(document).ready(function(){
  if ( jQuery('header').hasClass('mobile ')) {
    jQuery(".content-area").addClass("line_boxed");
  }
  MicroModal.init({
    openTrigger: 'data-custom-open',
    disableScroll: true,
    awaitCloseAnimation: true
  });

  if ( jQuery('header').hasClass('mobile')){
    var swiper = new Swiper('.swiper-responsive-product-slider', {
      pagination:{
      el: '.swiper-pagination',
      dynamicBullets: false,
      lazy: true,
    },
    });
  }
 
  if ( jQuery('body').hasClass('ceckout_page')) {
    jQuery(".showlogin").on("click", function () {
      jQuery(".prk-checkout-login").slideToggle(0);
    });
  };

});












jQuery(document).ready(function($){



  if ( jQuery('body').hasClass('mousemove_3d') ) {

      VanillaTilt.init(document.querySelectorAll('.prk_3d_mousemove .banners.list1'), {
      	max: 5,
      	speed: 400,
        axis: "y"
      });
      VanillaTilt.init(document.querySelectorAll('.prk_3d_mousemove .banners.list2'), {
      	max: 5,
      	speed: 400
      });
      VanillaTilt.init(document.querySelectorAll('.prk_3d_mousemove .banners.list3'), {
      	max: 6,
      	speed: 400
      });
      VanillaTilt.init(document.querySelectorAll('.prk_3d_mousemove .banners.list4'), {
      	max: 5,
      	speed: 400
      });

  }

  if ( jQuery('img').hasClass('boxed_3d') ) {
    VanillaTilt.init(document.querySelectorAll('.elementor-widget-container img.boxed_3d'), {
      max: 10,
      speed: 400,
    });
  }

});

footbox=jQuery(".foot-box").find(".menu");
if (footbox.length > 0) {

  footbox.closest('.foot-box').addClass('has-menu');

}


  var msh = document.querySelectorAll(".foot-box.has-menu .foot-title");
  var ish;

    for (ish = 0; ish < msh.length; ish++) {
      msh[ish].addEventListener("click", function () {
        /* Toggle between adding and removing the "active" class,
        to highlight the button that controls the panel */
        this.classList.toggle("active");

        /* Toggle between hiding and showing the active panel */
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
          panel.style.display = "none";
        } else {
          panel.style.display = "block";
        }
      });
    }



  jQuery(".select_quantity").on("change", function () {
    var value = $(this).val();
    jQuery(this)
      .parent()
      .find(".ajax_add_to_cart")
      .attr("data-quantity", value);
    jQuery(this).parent().find(".ajax_add_to_cart").click();
  });

  /*!
   * jQuery Cookie Plugin v1.4.1
   * https://github.com/carhartl/jquery-cookie
   *
   * Copyright 2006, 2014 Klaus Hartl
   * Released under the MIT license
   */
  (function (factory) {
      if (typeof define === 'function' && define.amd) {
          // AMD (Register as an anonymous module)
          define(['jquery'], factory);
      } else if (typeof exports === 'object') {
          // Node/CommonJS
          module.exports = factory(require('jquery'));
      } else {
          // Browser globals
          factory(jQuery);
      }
  }(function ($) {

      var pluses = /\+/g;

      function encode(s) {
          return config.raw ? s : encodeURIComponent(s);
      }

      function decode(s) {
          return config.raw ? s : decodeURIComponent(s);
      }

      function stringifyCookieValue(value) {
          return encode(config.json ? JSON.stringify(value) : String(value));
      }

      function parseCookieValue(s) {
          if (s.indexOf('"') === 0) {
              // This is a quoted cookie as according to RFC2068, unescape...
              s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
          }

          try {
              // Replace server-side written pluses with spaces.
              // If we can't decode the cookie, ignore it, it's unusable.
              // If we can't parse the cookie, ignore it, it's unusable.
              s = decodeURIComponent(s.replace(pluses, ' '));
              return config.json ? JSON.parse(s) : s;
          } catch (e) {
          }
      }

      function read(s, converter) {
          var value = config.raw ? s : parseCookieValue(s);
          return $.isFunction(converter) ? converter(value) : value;
      }

      var config = $.cookie = function (key, value, options) {

          // Write

          if (arguments.length > 1 && !$.isFunction(value)) {
              options = $.extend({}, config.defaults, options);

              if (typeof options.expires === 'number') {
                  var days = options.expires, t = options.expires = new Date();
                  t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
              }

              return (document.cookie = [
                  encode(key), '=', stringifyCookieValue(value),
                  options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                  options.path ? '; path=' + options.path : '',
                  options.domain ? '; domain=' + options.domain : '',
                  options.secure ? '; secure' : ''
              ].join(''));
          }

          // Read

          var result = key ? undefined : {},
              // To prevent the for loop in the first place assign an empty array
              // in case there are no cookies at all. Also prevents odd result when
              // calling $.cookie().
              cookies = document.cookie ? document.cookie.split('; ') : [],
              i = 0,
              l = cookies.length;

          for (; i < l; i++) {
              var parts = cookies[i].split('='),
                  name = decode(parts.shift()),
                  cookie = parts.join('=');

              if (key === name) {
                  // If second argument (value) is a function it's a converter...
                  result = read(cookie, value);
                  break;
              }

              // Prevent storing a cookie that we couldn't decode.
              if (!key && (cookie = read(cookie)) !== undefined) {
                  result[name] = cookie;
              }
          }

          return result;
      };

      config.defaults = {};

      $.removeCookie = function (key, options) {
          // Must not alter options, thus extending a fresh object...
          $.cookie(key, '', $.extend({}, options, {expires: -1}));
          return !$.cookie(key);
      };

  }));



  jQuery(function(e){

    e(document).on("click",".topbar-close",function(t){
      e(".topbars").slideUp(500),t.preventDefault(),e.cookie("alert-box","closed",{path:"/"});
      e(".header").removeClass('top_stikey');
    }),

    e(document).on("click",".alert-app-close",function(){
      e.cookie("alert-app","closed",{path:"/"})
    }),

    jQuery(function(t){
      "closed"===t.cookie("alert-app")?t(".alert-app").hide():t(".alert-app").show()
    }),
    
    jQuery(function(t){
      "closed"===t.cookie("alert-app")?t(".header").removeClass('top_stikey'):t(".header").removeClass('top_stikey')
    }),

    jQuery(function(t){
      "closed"===t.cookie("alert-box")?t(".topbars").hide():t(".topbars").show();
    })

  }),



jQuery(document).on('click', '.increase-qty', function (e) {
    e.preventDefault();
    var $this = jQuery(this);
    var qtyInput = $this.prev('input');

    var maxVal = parseInt(qtyInput.attr('max'));
    maxVal = maxVal ? maxVal : 9999;
    var currentVal = parseInt(qtyInput.val());
    if (!isNaN(currentVal) && currentVal < maxVal) {
        console.log(currentVal);
        qtyInput.val(currentVal + 1);
    }
    qtyInput.trigger("change");
    jQuery('button.update_carter').click();
});

jQuery(document).on('click', '.decrease-qty', function (e) {
    e.preventDefault();
    var $this = jQuery(this);
    var qtyInput = $this.next('input');
    var minVal = parseInt(qtyInput.attr('min'));
    minVal = minVal ? minVal : 1;
    var currentVal = parseInt(qtyInput.val());
    if (!isNaN(currentVal) && currentVal > minVal) {
        qtyInput.val(currentVal - 1);
    }
    qtyInput.trigger("change");
    jQuery('button.update_carter').click();
});

jQuery('#advantage, #disadvantage').on('input', function () {
    var $this = jQuery(this);
    var $value = $this.val();
    if ($value.length > 0) {
        $this.addClass('focused');
    } else {
        $this.removeClass('focused');
    }
});




/* ------------------------------ archive product filters ---------------------- */
function prk_product_filters() {

jQuery(".widget.woocommerce.widget_layered_nav.woocommerce-widget-layered-nav .widgettitle").addClass("closed");

if (jQuery(".woocommerce-widget-layered-nav-list,widget_price_filter,.prk_filter_woocomerce,ul,.widget_product_categories").length) {
  jQuery(".widgettitle").on("click", function () {
    jQuery(this).next(".woocommerce-widget-layered-nav-list,.widget_price_filter form,ul,.widget_product_categories .select2-container").slideToggle(100);
    jQuery(this).toggleClass("closed");
  });



}




// mobile menu
jQuery(".order-title-mobile.sider").on("click", function ($) {
  $(".sides").addClass("active");
  $(".sides").show(100);
});
// mobile menu
jQuery(".close-slider-mobile").on("click", function ($) {
  $(".sides").removeClass("active");
  $(".sides").hide(100);
});

// mobile menu
jQuery(".order-title-mobile.order_el").on("click", function ($) {
  $(".back-order-mobile").addClass("active");
  $(".back-order-mobile").show(100);
});
// mobile menu
jQuery("#nav-order-mobile .close-mobile").on("click", function ($) {
  $(".back-order-mobile").removeClass("active");
  $(".back-order-mobile").hide(100);
});

if (jQuery(".box-filter-shop").length) {
jQuery(function($) {
  var Navigation    = jQuery(".box-filter-shop"),
    CurrentScroll = jQuery(document).scrollTop(),
    NavHeight     = Navigation.offset().top;

  function NavSticky() {
    var navScroll = jQuery(document).scrollTop();

    if ( navScroll > NavHeight ) {
      Navigation.addClass('stickyer');
    } else {
      Navigation.removeClass('stickyer');
    }

    if ( navScroll > CurrentScroll ) {
      Navigation.removeClass('tabs-appear');
    } else {
      Navigation.addClass('tabs-appear');
    }

    CurrentScroll = jQuery(document).scrollTop();
  }

  jQuery(window).scroll(NavSticky);

 });
}
 // filter shop page
 jQuery(".filter_by_botton.show_sidebar").on("click", function () {
   jQuery(".remodals.mob_tab_filter_sidebar").fadeIn(700);
   jQuery("html").addClass('remodal-is-locked');
 });
 jQuery(".remodal-back-tabs.filter_sides_close").on("click", function () {
   jQuery("html").removeClass('remodal-is-locked');
   jQuery(".remodals.mob_tab_filter_sidebar").fadeOut(100);
 });

 // sort by page
 jQuery(".filter_by_botton.show_sortby").on("click", function () {
   jQuery(".remodals.mob_tab_filter_sortby").fadeIn(700);
   jQuery("html").addClass('remodal-is-locked');
 });
 jQuery(".remodal-back-tabs.close_sortby").on("click", function () {
   jQuery("html").removeClass('remodal-is-locked');
   jQuery(".remodals.mob_tab_filter_sortby").fadeOut(100);
 });


  // archive readmore
  var readmore_parents = jQuery(".footer-description-shop");
  var readmore_parents_height = readmore_parents.height();
  if (readmore_parents_height > 70) {
    readmore_parents.addClass("boxed");
  }

 // short excerpt readmore
 var readmore_excerpt = jQuery(".excerpt_product");
 var excerpt_height = readmore_excerpt.height();
 if (excerpt_height > 90) {
  readmore_excerpt.addClass("cut");
  readmore_excerpt.toggleClass('boxed');
 }

 jQuery(".mask-handler").click(function (e) {
     e.preventDefault();
     var sumaryBox = jQuery(this).parents('.footer-description-shop');

     // short description content
     var des_sumaryBox = jQuery(this).parents('.show-export.content-product');
     des_sumaryBox.find('.right-des-pro').toggleClass('open');

     // footer paragraph
     var des_sumaryBox = jQuery(this).parents('.foot-core .foot-box.text');
     des_sumaryBox.find('p').toggleClass('open');

     var des_description = jQuery(this).parents('.footer-description-shop.boxed');
     des_description.find('.term-description').toggleClass('open');

     // short excerpt paragraph
     var des_sumaryBox = jQuery(this).parents('.excerpt_product');
     des_sumaryBox.toggleClass('boxed');

     des_sumaryBox.find('.readmore_box').toggleClass('open');
     des_sumaryBox.find('.shadow-box').fadeToggle(0);
     jQuery(this).find('.show-more').fadeToggle(0);
     jQuery(this).find('.show-less').fadeToggle(0);
 });

}


// footer about site readmore
var footreadmore_parents = jQuery(".foot-box.text p");
var footreadmore_parents_height = footreadmore_parents.height();
if (footreadmore_parents_height > 50) {
  jQuery(".foot-box.text").addClass("boxed");
}


// subdescriptions readmore
var des_footreadmore_parents = jQuery(".show-export.content-product .show-export-contents");
var des_footreadmore_parents_height = des_footreadmore_parents.height();
if (des_footreadmore_parents_height > 130) {
  jQuery(".show-export.content-product").addClass("boxed");
}

jQuery(document).on('opening', '.remodal.tabs_content_product', function () {
  // subdescriptions readmore
  var des_footreadmore_parents = jQuery(".remodal.tabs_content_product .show-export.content-product .show-export-contents");
  var des_footreadmore_parents_height = des_footreadmore_parents.height();
  if (des_footreadmore_parents_height > 100) {
    jQuery(".remodal.tabs_content_product .show-export.content-product").addClass("boxed");
  }
});

// short_excerpt readmore
var excerpt_eadmore_parents = jQuery(".excerpt_product.cut");
var excerpt_eadmore_parents_height = excerpt_eadmore_parents.height();
if (excerpt_eadmore_parents_height > 40) {
  jQuery(".excerpt_product.cut").addClass("boxed");
}


function prk_faq_apper(){

  var acc = document.getElementsByClassName("ask_accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.display === "block") {
        panel.style.display = "none";
      } else {
        panel.style.display = "block";
      }
    });
  }

}

jQuery(document).ready(function () {
  prk_product_filters();
  prk_faq_apper();

});


function prk_toper_tabs(){

    /*====== Smooth Scroll ======*/
     jQuery(".wc-tabs li").on("click", function (event) {

       event.preventDefault();
       jQuery('html,body').animate({scrollTop:jQuery('.prk_element_inline').offset().top,},500);

    });
    /*====== end Smooth Scroll ======*/

}

jQuery(document).on( 'click', '.wc-tabs li', function() {
  prk_toper_tabs();

});

/**
 *--------------------------------------------------------------------------
 * load ajax chart price
 *--------------------------------------------------------------------------
 */
function get_price_chart_product(product_id) {
  var data = {
    product_id: product_id,
    action: "product_price_chart",
  };

  jQuery.post(vira_values.ajax_url, data, function (response) {
    jQuery("#productchartprice").html(response);
  });

  jQuery("span.chart_price").attr("onclick", "");
}

setTimeout(function () {}, 1000);

// jQuery slider product


/**
 *--------------------------------------------------------------------------
 * ajax Quick view
 *--------------------------------------------------------------------------
 */


jQuery(".Quickview").click(function(){
  jQuery('.onliner_main_loading.product_view').show();
  jQuery('.product-detail-container').html('');
});

jQuery(".Quickview").click(ajax_popup_quickview);

function ajax_popup_quickview(){

  var productId = jQuery(this).attr('product-id');
      jQuery.post(vira_values.ajax_url,
        {
          action: "get_quick_view", productId: productId
        },
        function(data, status){
            jQuery('.onliner_main_loading.product_view').hide();
            jQuery('.product-detail-container').html(data);

            jQuery(".remodal-content").animate({
              transform: 'scale(1.08)',
              opacity: '1',
            });


        },

      );
}

jQuery(document).ready(function () {

    if ( ! jQuery('body').hasClass('product-single') ) {

      tippy('.mcarousel_product .Quickview', {
        content: "مشاهده سریع",
      });

      tippy('.mcarousel_product .before_add_wishlist', {
        content: "افزودن به علاقه مندی ها",
      });

      tippy('.mcarousel_product .after_add_wishlist', {
        content: "حذف از علاقه مندی ها",
      });

      tippy('.mcarousel_product .add_to_cart_button.ajax_add_to_cart', {
        content: "اضافه به سبد خرید",
      });

    }

});



/**

** prk search box

*/

jQuery(".desktop.search-section .prk_input_serach").click(function (e) {
  e.stopPropagation();
    jQuery(".main_results_ajax_search").fadeIn(100);
    jQuery('.blacki').addClass('activ');
    jQuery('.search-section').addClass('active');
    jQuery('.search-section input').addClass('active');
    jQuery('.search-box').addClass('active_full');
    jQuery('.form_search #submit_search').addClass('active');
    jQuery(".search-box").css("top", "0");
});

jQuery(document).click(function (e) {
  if (!jQuery(e.target).closest(".search-section").length) {
      jQuery(".main_results_ajax_search").fadeOut(100);
      jQuery('.blacki').removeClass('activ');
      jQuery('.search-section').removeClass('active');
      jQuery('.search-section input').removeClass('active');
      jQuery('.search-box').removeClass('active_full');
      jQuery('.form_search #submit_search').removeClass('active');
      jQuery("#submit_search i").show();
  }
});

jQuery('.prk_close_search_box').on('click',function(){
    jQuery(".main_results_ajax_search").hide();
    jQuery('body').removeClass('hidden_scroll');
    jQuery('.blacki').removeClass('activ');
    jQuery('.search-section').removeClass('active');
    jQuery('.search-section input').removeClass('active');
    jQuery('.search-box').removeClass('active_full');
    jQuery('.form_search #submit_search').removeClass('active');
    jQuery('.main_results_ajax_search .products_resulter').html('');
    jQuery('#txt_search').val('');
    jQuery(".search-box").css("top", "100%");
    jQuery("#submit_search i").show();
});





// prk factor
jQuery(function($){
    $('a.my_account_getfactor').each( function(){
        $(this).attr('target','_blank');
    })
});
//////////////


// mobile menu
jQuery(".toggle-navigation").on("click", function ($) {
  jQuery(".modal-menu").addClass("toggle");
  jQuery(".navigation-overlay").fadeIn(100);

});

// delivery popup
jQuery(".select_delivery_time").on("click", function ($) {
  jQuery(".order-delivery-times.delivery_mobile").addClass("active");
  jQuery(".navigation-overlay").fadeIn(100);
});

// delivery popup close
jQuery("span.close-delivery-times").on("click", function ($) {
  jQuery(".navigation-overlay").fadeOut(100);
  jQuery(".order-delivery-times.delivery_mobile").removeClass("active");
});


// app closes
jQuery(function(eapp){

  eapp(document).on("click","span.dn-app-closes",function(tapp){
    eapp(".continer-dnapp").slideUp(500),tapp.preventDefault(),eapp.cookie("alert-box","closed",{path:"/"})
  }),

  eapp(document).on("click",".alert-app-close",function(){
    eapp.cookie("alert-app","closed",{path:"/"})
  }),

  jQuery(function(tapp){
    "closed"===tapp.cookie("alert-app")?tapp(".alert-app").hide():tapp(".alert-app").show()
  }),

  jQuery(function(tapp){
    "closed"===tapp.cookie("alert-box")?tapp(".continer-dnapp").hide():tapp(".continer-dnapp").show()
  })

}),



jQuery(".off-canvas-main li.menu-item-has-children").append('<span class="toggle-submenu"></span>');
jQuery(".modal-menu.modern .off-canvas-main li.menu-item-has-children ul.sub-menu").append('<span class="close-submenu"></span>');

jQuery(
  ".off-canvas-main li.menu-item-has-children span.toggle-submenu"
).click(function () {
  jQuery(this).parent().find("ul:first").toggleClass("toggle");

  jQuery(this).toggleClass("opened");
});



jQuery(".off-canvas-main .close-submenu").on("click", function (event) {
  event.preventDefault();
  jQuery(this).parent(".sub-menu").removeClass("toggle");
});

jQuery(".off-canvas-main li.menu-item-has-children span.toggle-submenu").click(function () {

  if ( jQuery(this).parent().find("ul").hasClass("toggle") ) {
    var str = jQuery(this).parent().find("a").first().text();
    jQuery(this).parent().find("ul .close-submenu").html(str);
  }
  else {
    jQuery(this).parent().find("ul .close-submenu").html('');
  }
});

jQuery(".navigation-overlay").on("click", function (event) {
  if ( ! jQuery('body').hasClass('elementor-editor-active') ) {
    event.preventDefault();
    jQuery("#cart_content_modal").removeClass("toggle");
    jQuery("html").removeClass("inner_hidden");
    jQuery(".prk_open_mini_cart").removeClass("close");
    jQuery("#cart-sidebar").removeClass("nasa-active");
    jQuery(".modal-menu").removeClass("toggle");
    jQuery(".modal-menu .sub-menu").removeClass("toggle");
    jQuery(".navigation-overlay").fadeOut(80);
    jQuery(".order-delivery-times.delivery_mobile").removeClass("active");

    // caller
    jQuery("html").removeClass("sit-overflow-hidden");
    jQuery(".call_main").removeClass("showe");
    jQuery(".call_button").addClass("pluses");
    jQuery(".call_button .prk-close-caller").hide();
    jQuery(".call_button .prk-open-caller").show();
    jQuery(".call_button .prk-close-caller").removeClass("rotate_for");
  }

  if ( ! jQuery('header').hasClass('mobile-header') ) {
    jQuery(".mobile-navbar-menu.havsecond").removeClass("active");
    jQuery("html").removeClass("remodal-is-locked");
    jQuery(".socials-box").removeClass("active");
    jQuery("body.product-single .product-more-icon-dates").removeClass("active");
    jQuery(".navigation-overlay").removeClass("zindex-top");

  }
});


function pause_video(){
    jQuery('#modalvidoes video').each(function () { this.pause() });
    jQuery('#modalvidoes iframe').attr('src', jQuery('#modalvidoes iframe').attr('src'));
}


jQuery(document).on('closing', '.remodal', function (e) {

  pause_video()

});
jQuery( ".tabs_content_product .cooment_mobile_title" ).html('نظرات کاربران');
jQuery( ".tabs_content_product .title-insert" ).html('افزودن نظر');
jQuery( ".tabs_content_product .informationproduct_title_tab" ).html('مشخصات کلی');






/*====== CopyClipboard ======*/
jQuery(function($){

  if ($("h2").hasClass("wc-bacs-bank-details-heading")) {
    $( ".wc-bacs-bank-details-heading" ).html('مشخصات بانکی ما');
  }

  function copyClipboard(text) {
    var field = document.createElement("input");
    field.setAttribute("value", text);
    field.setAttribute("contenteditable", true); //IOS compatibility
    document.body.appendChild(field);
    field.select();
    document.execCommand("copy");
    document.body.removeChild(field);
  }

  jQuery(".copy-url-btn").on("click", function ($) {
    var btn = jQuery(this);
    copyClipboard(jQuery(this).data("copy"));
    jQuery(this).addClass("copied");
    jQuery(this).html("کپی شد");
    setTimeout(function () {
      btn.removeClass("copied");
      btn.html("کپی لینک");
    }, 2000);
  });

});
/*====== end CopyClipboard ======*/


var call_btn = 1;
jQuery(".call_button").click(function($){
	if ( call_btn == 1 ){

		jQuery(".call_main").addClass("showe");
    jQuery(".call_button").removeClass("pluser");
    jQuery(".call_button .prk-open-caller").hide();
    jQuery(".call_button .prk-close-caller").show();
    jQuery(".call_button .prk-close-caller").addClass("rotate_for");
    jQuery(".navigation-overlay").fadeIn(100);
		call_btn = 0;
	}else{

    jQuery(".call_main").removeClass("showe");
    jQuery(".call_button").addClass("pluser");
    jQuery(".call_button .prk-close-caller").hide();
    jQuery(".call_button .prk-open-caller").show();
    jQuery(".navigation-overlay").fadeOut(100);
    jQuery(".call_button .prk-close-caller").removeClass("rotate_for");
		call_btn = 1;
	}

});

jQuery(".call_close_mobile").click(function($){
  jQuery("html").removeClass("sit-overflow-hidden");
  jQuery(".call_main").removeClass("showe");
  jQuery(".call_button").addClass("pluser");
  jQuery(".call_button .prk-close-caller").hide();
  jQuery(".call_button .prk-open-caller").show();
  jQuery(".navigation-overlay").fadeOut(100);
  jQuery(".call_button .prk-close-caller").removeClass("rotate_for");
  call_btn = 1;
});





jQuery(".more_excerpt").click(function (e) {
    e.preventDefault();
    var sumaryBox = jQuery(this).parents('.des-right');
    sumaryBox.find('.excerpt_product.full').show();
    sumaryBox.find('.excerpt_product.cut').hide();
});

jQuery(".disble_excerpt").click(function (e) {
    e.preventDefault();
    var sumaryBox = jQuery(this).parents('.des-right');
    sumaryBox.find('.excerpt_product.full').hide();
    sumaryBox.find('.excerpt_product.cut').show();
});

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}







jQuery(document).ready(function ($) {
    //Get CurrentUrl variable by combining origin with pathname, this ensures that any url appendings (e.g. ?RecordId=100) are removed from the URL
    var CurrentUrl = window.location.origin+window.location.pathname;
    //Check which menu item is 'active' and adjust apply 'active' class so the item gets highlighted in the menu
    //Loop over each <a> element of the NavMenu container
    $('#NavMenu a').each(function(Key,Value)
        {
            //Check if the current url
            if(Value['href'] === CurrentUrl)
            {
                //We have a match, add the 'active' class to the parent item (li element).
                $(Value).parent().addClass('active');
            }
        });
 });


function support_open(){
  var x22 = document.getElementById("ques-box");
  if ( x22.className === "ques-box" ){
    x22.className += " opens";
  }
  else {
    x22.className = "ques-box";
  }

  var x222 = document.getElementById("support-tabs");
  if ( x222.className === "support-btn" ){
    x222.className += " closes-btn";
  }
  else {
    x222.className = "support-btn";
  }
};


function ques_cansel(){
  var x221 = document.getElementById("ques-box");
  if ( x221.className === "ques-box opens" ){
    x221.className = "ques-box";
  }
  else {
    x221.className = "ques-box opens";
  }

  var x2221 = document.getElementById("support-tabs");
  if ( x2221.className === "support-btn closes-btn" ){
    x2221.className = "support-btn";
  }
  else {
    x2221.className = "support-btn closes-bt";
  }
};

function faqs_mobile(){
  var x221 = document.getElementById("ques-box");
  if ( x221.className === "ques-box" ){
    x221.className += " opens";
  }
  else {
    x221.className = "ques-box";
  }
};


var accardionToggle = (slideMenu) => (e) => {
    slideMenu.forEach((links) => {
      var hidePanel = links.nextElementSibling;
        if (links === e.currentTarget) {
            e.currentTarget.classList.toggle('active');
            hidePanel.classList.toggle('active-block');
        } else {
            links.classList.remove('active');
            hidePanel.classList.remove('active-block');
        }
    });
};

var slideMenu = document.querySelectorAll('.accardion-link');

slideMenu.forEach((links) => {
    links.addEventListener('click', accardionToggle(slideMenu))
});






jQuery(function($) {

    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    jQuery('#nav-order a').each(function() {
     if (this.href === path) {
      jQuery(this).addClass('active');
     }
    });
   });



  jQuery( "div.overout" )
  .mouseover(function() {
    i += 1;
    jQuery( this ).find( "span" ).text( "mouse over x " + i );
  })
  .mouseout(function() {
    jQuery( this ).find( "span" ).text( "mouse out " );
  });



jQuery( ".mega_menu_two_level,.mega_menu_tree_level" )
  .mouseenter(function() {

    jQuery('.blacki').addClass('activ');
  })
  .mouseleave(function() {
    jQuery('.blacki').removeClass('activ');
  });


jQuery("a[href='#tops']").click(function() {
  jQuery("html, body").animate({ scrollTop: 0 }, "300");
  return false;
});


// header sticky
jQuery(function($) {

  if (jQuery(".header").length) {
    var Navigation    = jQuery(".header"),
      CurrentScroll = jQuery(document).scrollTop(),
      NavHeight     = Navigation.offset().top;

    function NavSticky() {
      var navScroll = jQuery(document).scrollTop();

      if ( jQuery(document).scrollTop() >= 80 ) {
        Navigation.addClass('hsticky');
      } else {
        Navigation.removeClass('hsticky');
      }

      CurrentScroll = jQuery(document).scrollTop();
    }

    jQuery(window).scroll(NavSticky);
  }

});




 // menu sticky
 jQuery(function($) {

   if (jQuery(".menus").length) {

     var Navigation    = jQuery(".menus"),
       CurrentScroll = jQuery(document).scrollTop(),
       NavHeight     = Navigation.offset().top;

     function NavSticky() {
       var navScroll = jQuery(document).scrollTop();

       if ( jQuery(document).scrollTop() >= 80  ) {
         Navigation.addClass('sticky');
       } else {
         Navigation.removeClass('sticky');
       }

       if ( navScroll > CurrentScroll ) {
         Navigation.removeClass('nav-appear');
       } else {
         Navigation.addClass('nav-appear');
       }

       CurrentScroll = jQuery(document).scrollTop();
     }

     jQuery(window).scroll(NavSticky);

 }

});


jQuery(function(e){

  e(document).on("click",".topbar-close",function(t){
    e(".topbars").slideUp(500),t.preventDefault(),e.cookie("alert-box","closed",{path:"/"});
    e(".header").removeClass('top_stikey');
  })
  
  e(document).on("click",".alert-app-close",function(){
    e.cookie("alert-app","closed",{path:"/"})
  })
  
  jQuery(function(t){
    "closed"===t.cookie("alert-app")?t(".alert-app").hide():t(".alert-app").show()
  })
  
  jQuery(function(t){
    "closed"===t.cookie("alert-app")?t(".header").removeClass('top_stikey'):t(".header").removeClass('top_stikey')
  })
  
  jQuery(function(t){
    "closed"===t.cookie("alert-box")?t(".topbars").hide():t(".topbars").show();
  })
  
  })


/**
 *--------------------------------------------------------------------------
 * register - login
 * digikala demo
 *--------------------------------------------------------------------------
 */
var oopend = 1;
jQuery(".account.opener").click(function (e) {

  if (oopend == 1) {
    e.stopPropagation();
    jQuery(".dashboard-menu").fadeIn(90);
    jQuery('.account.opener').addClass('active');
    oopend = 0;
  }else {
    jQuery(".dashboard-menu").fadeOut(50);
    jQuery('.account.opener').removeClass('active');
    oopend = 1;
  }

});

jQuery(document).click(function (e) {
  if (!jQuery(e.target).closest(".account.opener").length) {
    oopend = 1;
    jQuery(".dashboard-menu").fadeOut(50);
    jQuery('.account.opener').removeClass('active');
  }
});



 /**
  *--------------------------------------------------------------------------
  * register - login

  * prk plus demo
  *--------------------------------------------------------------------------
  */
  var opens = 1;
  jQuery(".prk-account.logined").click(function (e) {

    if ( opens == 1 ) {
    e.stopPropagation();
    jQuery(".prk-dashboard").fadeIn(80);
    jQuery('.prk-account').addClass('active');
    opens = 0;
  }else {
    jQuery(".prk-dashboard").fadeOut(40);
    jQuery('.prk-account').removeClass('active');
    opens = 1;
  }

  });

  jQuery(document).click(function (e) {
    if (!jQuery(e.target).closest(".prk-account.logined").length) {
      opens = 1;
      jQuery(".prk-dashboard").fadeOut(40);
      jQuery('.prk-account').removeClass('active');
    }
  });



function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabs-content");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tabs-links");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" activer", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " activer";
}



// login form tabs
var tabLinks = document.querySelectorAll(".tabs-form a");
var tabPanels = document.querySelectorAll(".tabs-panel");

for (let el of tabLinks) {
  el.addEventListener("click", e => {
    e.preventDefault();

    document.querySelector(".tabs-form li.active").classList.remove("active");
    document.querySelector(".tabs-panel.active").classList.remove("active");

    const parentListItem = el.parentElement;
    parentListItem.classList.add("active");
    const index = [...parentListItem.parentElement.children].indexOf(parentListItem);

    const panel = [...tabPanels].filter(el => el.getAttribute("data-index") == index);
    panel[0].classList.add("active");
    });
  }

/**

 * wishlist sestim

**/

(function ($) {

    $("body").on("click",".sit-wishlist-btn", function (e) {

        var btn = jQuery(this);
        var data_url = $(this).attr("data-admin-url");
        var data_post_id = $(this).attr("data-post-id");
        var data_action = $(this).attr("data-action");
        var data_nonce = $(this).attr("data-nonce");

        $.ajax({
            url: data_url,
            method: "POST",
            beforeSend: function () {
                btn.addClass("disabled");
                btn.prop("disabled", true);
                console.log("Requesting Wishlist Update");
                jQuery('.onliner_main_loading').show();
            },
            data: {
                sit_action: data_action,
                sit_post_id: data_post_id,
                sit_nonce: data_nonce,
                action: "sit_update_wishlist",
            },
            success: function (res) {
                res = JSON.parse(res);
                jQuery('.onliner_main_loading').hide();
                if ("btn_inner_html" in res && res["btn_inner_html"]) {
                    btn.html(res["btn_inner_html"]);
                }

                if ("modal_html" in res && res["modal_html"]) {
                    $("body #sit-wishlist-modal-placeholder").html(res["modal_html"]);
                }

                // change action attribute
                if (res.status == true) {
                    if (data_action == "remove") {
                        btn.attr("data-action", "add");
                        if (btn.hasClass("sit-dashboard-btn")) {
                            btn.parents(".w-post-item").hide();

                            btn.parents(".wishlist-item").slideUp();
                        }
                    }
                    if (data_action == "add") {
                        btn.attr("data-action", "remove");
                    }
                }

                btn.removeClass("disabled");
            },
            complete: function (res) {
                btn.prop("disabled", false);
                btn.removeClass("disabled");
            },
        });

        console.log(data_post_id, data_url, data_action);
    });
})(jQuery);

// Modal functionality
(function ($) {
    // visible the modal
    $("body .sit-show-my-wishlist-btn").on("click", function (e) {
        e.preventDefault();
        $(".sit-wishlist-modal-wrapper").fadeIn();
        $("html").addClass("sit-overflow-hidden");
    });



    // close the modal
    $("body").on("click", ".sit-wishlist-modal-close-btn", function (e) {
        e.preventDefault();
        $(".sit-wishlist-modal-wrapper").fadeOut();
        $("html").removeClass("sit-overflow-hidden");
    });

    // remove item after click remove

    $("body").on("click", ".sit-remove-wishlist-btn-from-modal", function (e) {
        var btn = jQuery(this);
        var data_url = $(this).attr("data-admin-url");
        var data_post_id = $(this).attr("data-post-id");
        var data_action = $(this).attr("data-action");
        var data_nonce = $(this).attr("data-nonce");

        $.ajax({
            url: data_url,
            method: "POST",
            beforeSend: function () {
                btn.addClass("disabled");
                btn.prop("disabled", true);
                console.log("Requesting Wishlist Update For modal");
                console.log(data_url, data_post_id, data_action, data_nonce);
            },
            data: {
                sit_action: data_action,
                sit_post_id: data_post_id,
                sit_nonce: data_nonce,
                action: "sit_update_wishlist",
            },
            success: function (res) {
                res = JSON.parse(res);

                // change action attribute
                if (res.status == true) {
                    // change main product  page btn wishlist add/remove button html
                    if ("btn_inner_html" in res && res["btn_inner_html"]) {
                        var main_page_btn = $('body .sit-wishlist-btn[data-post-id="' + data_post_id + '"]');

                        if (main_page_btn.length) {
                            main_page_btn.html(res["btn_inner_html"]);
                            var btn_action = main_page_btn.attr("data-action");
                            if (btn_action == "remove") {
                                main_page_btn.attr("data-action", "add");
                            } else {
                                main_page_btn.attr("data-action", "remove");
                            }
                        }
                    }

                    // hide the clicked item
                    btn.parents(".sit-modal-wishlist-item").slideUp(400, function () {
                        btn.parents(".sit-modal-wishlist-item").remove();

                        // if no item available show the no content div
                        if ($("body .sit-modal-wishlist-items div").length) {
                        } else {
                            $(".sit-modal-wishlist-items").html('<div class="sit-modal-no-item-wrapper"><div class="sit-modal-no-title">No item found</div><div class="sit-modal-no-detail">Your wishlist is empty!</div></div>');
                        }
                    });
                }

                // btn.removeClass("disabled");
            },
            complete: function (res) {
                btn.prop("disabled", false);
                btn.removeClass("disabled");
            },
        });

        console.log(data_post_id, data_url, data_action);
    });
})(jQuery);


/*====== Preloader ======*/
jQuery(window).on("load", function () {
  var preloaderFadeOutTime = 500;

  setTimeout(function () {
    jQuery("body").addClass("loaded");
    jQuery("body #loader").delay(150).fadeOut("slow");
  }, preloaderFadeOutTime);
});
/*====== end Preloader ======*/



if (jQuery('.prk_mega_menu').length && prk_borline_menu == true ) {
    jQuery(function () {

        jQuery('.prk_mega_menu').append("<li id='bor-line'></li>");
        var magicLine = jQuery('#bor-line');

        if (jQuery('body')) {
            magicLine.data('origRight', (jQuery('.prk_mega_menu').width() - (magicLine.width() + magicLine.position().left))).data('origWidth', magicLine.width());

            jQuery('.prk_mega_menu > .menu-item').hover(function () {
                var $thisBar = jQuery(this);
                var rightPos = jQuery('.prk_mega_menu').width() - ($thisBar.width() + $thisBar.position().left);
                var newWidth = $thisBar.width();
                magicLine.css({
                    "opacity": "1",
                    "right": rightPos,
                    "width": newWidth
                });
            }, function () {
                magicLine.css({
                    "opacity": "0",
                    "right": magicLine.data('origRight'),
                    "width": magicLine.data('origWidth')
                });
            });
        } else {
            magicLine.data('origLeft', magicLine.position().left).data('origWidth', magicLine.width());

            jQuery('.prk_mega_menu > .menu-item').hover(function () {
                var $thisBar = jQuery(this);
                var leftPos = $thisBar.position().left;
                var newWidth = $thisBar.width();
                magicLine.css({
                    "left": leftPos,
                    "width": newWidth
                });
            }, function () {
                magicLine.css({
                    "left": magicLine.data('origLeft'),
                    "width": magicLine.data('origWidth')
                });
            });
        }
    });
}



jQuery(document).ready((function(t) {

  t(".prk-sticky-add-cart").length && t(window).scroll((function() {
      var e = t(window).scrollTop(),
          a = t(".des-left").offset().top + t(".des-left").outerHeight(),
          n = t(".prk-sticky-add-cart").outerHeight(),
          o = t(window).scrollTop() + t(window).height(),
          s = t(document).height() - 100;
       a < e && o < s ? t(".prk-sticky-add-cart").addClass("prk-sticky-show") : t(".prk-sticky-add-cart").removeClass("prk-sticky-show");
       a < e && o < s ? t(".call_box .call_button").addClass("prk-sticky-show-uper") : t(".call_box .call_button").removeClass("prk-sticky-show-uper")
  }))

  t(document).on("click", ".go-to-add", (function() {
    return t("body,html").animate({
        scrollTop: t(".col-single1").offset().top - 300
    }, 800), !1
  }))

}));

jQuery(document).on('click', '.study-mode-btn', function () {
  jQuery(".single-page .left-cont").toggleClass("full-width");

  jQuery("aside.side-posts").fadeToggle({
    duration: 400,
    start: function () {
      // وقتی نمایش داده شد، !important رو حذف کن
      jQuery(this).css("display", "block");
    },
    complete: function () {
      // وقتی مخفی شد، !important اعمال کن
      if (jQuery(this).is(":hidden")) {
        this.style.setProperty("display", "none", "important");
      }
    }
  });
});

jQuery(".widget li.cat-item" ).has( "ul" ).addClass( "has-children");

if (jQuery(".widget li.cat-item").hasClass("has-children")) {
  jQuery(".widget li.cat-item.has-children").append('<span class="toggle-submenu"></span>');

}


jQuery(document).on('click', '.widget li.cat-item.has-children .toggle-submenu', function () {
  
  jQuery(this).parents('.widget li.cat-item.has-children').toggleClass("show-children");
  jQuery(this).toggleClass("active");

});

jQuery('.others-categories .term').click(function (e) {
  e.preventDefault();
  jQuery('.subcategories-list .row').toggleClass('show-all');
});





