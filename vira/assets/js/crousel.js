



jQuery(document).ready(function(){

if ( ! jQuery('body').hasClass('product-single') ) {

  jQuery(function (){
   const product_mini_SwiperSlider = new Swiper(
     ".product-mini-swiper-slider",
     {
       // Optional parameters
       spaceBetween: 10,

       // Navigation arrows
       navigation: {
         nextEl: ".swiper-button-next.mini_nav",
         prevEl: ".swiper-button-prev.mini_nav",
       },

       breakpoints: {
         1200: {
           slidesPerView: 6,
         },
         992: {
           slidesPerView: 5,
           spaceBetween: 10,
         },
         576: {
           slidesPerView: 7,
           spaceBetween: 8,
         },
         480: {
           slidesPerView: 5,
           spaceBetween: 8,
         },
         360: {
           slidesPerView: 4,
           spaceBetween: 8,
         },
         260: {
           slidesPerView: 3,
           spaceBetween: 8,
         },
       },
     }
   );
  });

  jQuery(function (){
    const productcarouselSwiperSlider = new Swiper(
      ".post-carousel-swiper-slider",
      {
        // Optional parameters
        spaceBetween: 15,

        // If we need pagination
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
          dynamicBullets: true,
        },

        // Navigation arrows
        navigation: {
          nextEl: ".swiper-button-next.mpostcarusel_nav",
          prevEl: ".swiper-button-prev.mpostcarusel_nav",
        },

        breakpoints: {
          1200: {
            slidesPerView: 4,
          },
          992: {
            slidesPerView: 3,
            spaceBetween: 10,
          },
          576: {
            slidesPerView: 3,
            spaceBetween: 10,
          },
          480: {
            slidesPerView: 2,
            spaceBetween: 8,
          },
          0: {
            slidesPerView: 1,
            spaceBetween: 8,
          },
        },
      }
    );

  });

  jQuery(function (){
    const productcarouselSwiperSlider = new Swiper(
      ".post-carousel-swiper-slider.box-imager",
      {
        // Optional parameters
        spaceBetween: 35,

        // If we need pagination
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
          dynamicBullets: true,
        },

        // Navigation arrows
        navigation: {
          nextEl: ".swiper-button-next.mpostcarusel_nav",
          prevEl: ".swiper-button-prev.mpostcarusel_nav",
        },

        breakpoints: {
          1200: {
            slidesPerView: 4,
          },
          992: {
            slidesPerView: 3,
            spaceBetween: 10,
          },
          576: {
            slidesPerView: 3,
            spaceBetween: 10,
          },
          480: {
            slidesPerView: 2,
            spaceBetween: 8,
          },
          0: {
            slidesPerView: 1,
            spaceBetween: 8,
          },
        },
      }
    );

  });


}

(function ($) {
  'use strict';

  var bootTimer = null;
  var owlRetry = 0;

  function toBool(v) {
    return v === true ||
      v === 1 ||
      String(v).toLowerCase() === 'true' ||
      String(v).toLowerCase() === 'yes';
  }

  function toNum(v, d) {
    var n = parseFloat(v);
    return isFinite(n) ? n : d;
  }

  function getSettings($el) {
    try {
      return JSON.parse($el.attr('settings-slider') || '{}') || {};
    } catch (e) {
      return {};
    }
  }

  function owlIsReady() {
    return $.fn && typeof $.fn.owlCarousel === 'function';
  }

  function ensureOwl(callback) {
    if (owlIsReady()) {
      owlRetry = 0;
      callback();
      return;
    }

    if (owlRetry < 30) {
      owlRetry++;

      setTimeout(function () {
        ensureOwl(callback);
      }, 100);
    }
  }

  function refreshIfLoaded($el) {
    if ($el.hasClass('owl-loaded') || $el.data('owl.carousel')) {
      $el.trigger('refresh.owl.carousel');
      return true;
    }

    return false;
  }

  function initCarouselItems($el) {
    if (!$el.length || refreshIfLoaded($el)) return;

    var settings = getSettings($el);

    $el.addClass('owl-carousel');

    $el.owlCarousel({
      items: toNum(settings.item, 3),
      margin: toNum(settings.margins, 0),
      loop: toBool(settings.loop),
      nav: toBool(settings.nav),
      navText: ["", ""],
      rtl: true,
      dots: false,

      autoplay: false,
      autoplayTimeout: 0,
      autoplayHoverPause: false,

      responsiveClass: true,
      responsive: {
        0:   { items: 3, nav: false, loop: false },
        360: { items: 3, nav: false, loop: false },
        480: { items: 4, nav: false, loop: false },
        860: { items: 6, nav: false, loop: false },
        990: { items: 8 }
      }
    });
  }

  function initArticleOff($el) {
    if (!$el.length || refreshIfLoaded($el)) return;

    var settings = getSettings($el);

    var item = toNum(settings.item, 5);
    var margin = toNum(settings.margins, 5);
    var marginMob = toNum(settings.margins_mob, margin);
    var baseStagePadding = toNum(settings.Paddings, 0);

    $el.addClass('owl-carousel');

    $el.owlCarousel({
      items: item,
      loop: toBool(settings.loop),
      margin: margin,
      stagePadding: baseStagePadding,

      autoplay: toBool(settings.autoplay),
      autoplayTimeout: toNum(settings.delay, 4000),
      autoplayHoverPause: true,

      nav: toBool(settings.nav),
      navText: ["", ""],
      rtl: true,
      dots: toBool(settings.dots),

      touchDrag: true,
      mouseDrag: true,
      pullDrag: true,
      freeDrag: false,
      smartSpeed: 250,
      responsiveRefreshRate: 100,

      responsiveClass: true,
      responsive: {
        0:    { items: 1, nav: false, margin: marginMob, stagePadding: 55 },
        340:  { items: 1, nav: false, margin: marginMob, stagePadding: 70 },
        400:  { items: 2, nav: false, margin: marginMob, stagePadding: 10 },
        470:  { items: 2, nav: false, margin: marginMob, stagePadding: 10 },
        570:  { items: 2, nav: false, margin: marginMob, stagePadding: 30 },
        780:  { items: 4, nav: false, margin: marginMob },
        1024: { items: 5, nav: toBool(settings.nav), margin: margin },
        1150: { items: 5, nav: toBool(settings.nav), margin: margin },
        1310: { items: item, nav: toBool(settings.nav), margin: margin }
      }
    });
  }

  function initSlideCarousel($el) {
    if (!$el.length || refreshIfLoaded($el)) return;

    var settings = getSettings($el);

    $el.addClass('owl-carousel');

    $el.owlCarousel({
      items: 1,
      loop: toBool(settings.loop),
      autoplay: toBool(settings.autoplay),
      autoplayTimeout: toNum(settings.delay, 4000),
      nav: toBool(settings.nav),
      rtl: true,
      dots: toBool(settings.dots),
      navText: ["", ""],
      smartSpeed: 250
    });
  }

  function bootNow() {
    ensureOwl(function () {
      $('.carousel-items').each(function () {
        initCarouselItems($(this));
      });

      $('.article-off').each(function () {
        initArticleOff($(this));
      });

      $('.slide-carousel').each(function () {
        initSlideCarousel($(this));
      });
    });
  }

  function boot() {
    clearTimeout(bootTimer);

    bootTimer = setTimeout(function () {
      bootNow();
    }, 60);
  }

  boot();

  if (document.readyState === 'complete') {
    boot();
  } else {
    $(window).on('load', boot);
  }

  $(window).on('pageshow resize orientationchange', boot);

  document.addEventListener('visibilitychange', function () {
    if (!document.hidden) {
      boot();
    }
  });

  $(window).on('elementor/frontend/init', function () {
    if (window.elementorFrontend && window.elementorFrontend.hooks) {
      window.elementorFrontend.hooks.addAction('frontend/element_ready/global', boot);
    }
  });

})(jQuery);

});


function toEnglishNumber(faphonenumber) {
  var pn = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
  var en = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
  var an = ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];
  var cache = faphonenumber;
  for (var i = 0; i < 10; i++) {
      var regex_fa = new RegExp(pn[i], 'g');
      var regex_ar = new RegExp(an[i], 'g');  
      cache = cache.replace(regex_fa, en[i]);
      cache = cache.replace(regex_ar, en[i]);
  }

  return cache;
}
 jQuery(".phone-loginbox input[name='login[email_phone]'] ").on("keyup change", function(e) {
      
      let faphonenumber = jQuery(this).val();
      var cache=toEnglishNumber(faphonenumber);
      
        jQuery(".phone-loginbox input[name='login[email_phone]']").val(cache);
    }
    
  )
  jQuery(".prk_sms_newsletter_mobile").on("keyup change", function(e) {
      
    let faphonenumber = jQuery(this).val();
    var cache=toEnglishNumber(faphonenumber);
    
      jQuery(".prk_sms_newsletter_mobile").val(cache);
  }
  
)


