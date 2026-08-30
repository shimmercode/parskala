jQuery(document).ready((function(t) {

    t(".woocommerce-feature-enabled-activity-panels #publishing-action").length && t(window).scroll((function() {
        var e = t(window).scrollTop(),
            a = t("#submitpost").offset().top + t("#submitpost").outerHeight(),
            o = t(window).scrollTop() + t(window).height(),
            s = t(document).height() - 20;
         a < e && o < s ? t("#publishing-action").addClass("prk-sticky-show") : t("#publishing-action").removeClass("prk-sticky-show");
    }))
  
  }));


  