// mobile menu
jQuery(".prk-toggle-navigation").on("click", function (event) {
  event.preventDefault();
  jQuery(".modal-menu").toggleClass("toggle");
  jQuery(".modal-menu .sub-menu").removeClass("toggle");
  jQuery(".mobile-navbar-menu.havsecond").toggleClass("active");
  jQuery("html").toggleClass("remodal-is-locked");
  jQuery(".socials-box").toggleClass("active");
  jQuery(".navigation-overlay").fadeToggle(100);

});

if (document.getElementById("backer-button")) {

  document.getElementById("backer-button").onclick = function (e) {
    e.preventDefault();
    if (document.referrer == "" || document.referrer == "https://www.google.com/") {
      window.location = window.location.origin;
    } else {
      history.back();
    }
    return false;
  };

}

// mobile show all product dates
jQuery("li.more-tooltip").on("click", function (event) {
  event.preventDefault();
  jQuery("body.product-single .product-more-icon-dates").toggleClass("active");
  jQuery("html").toggleClass("remodal-is-locked");
  jQuery(".navigation-overlay").toggleClass("zindex-top");
  jQuery(".navigation-overlay").fadeToggle(100);

});


jQuery(".product-more-icon-dates ul li.action").on("click", function (event) {
  event.preventDefault();
  jQuery(".navigation-overlay").removeClass("zindex-top");
  jQuery(".navigation-overlay").fadeOut(80);
  jQuery("body.product-single .product-more-icon-dates").removeClass("active");

});

jQuery(".pars-style .show-navbar").on("click", function (event) {
  event.preventDefault();
  jQuery(".back_holder").toggleClass("active");
  jQuery(".mobile-navbar-menu").toggleClass("noindex");
  jQuery(".mobile-navbar-menu nav.inproduct").toggleClass("active");

});

jQuery(".fashion-style .show-navbar").on("click", function (event) {
  event.preventDefault();
  jQuery(".cart .button").toggleClass("active");
  jQuery(".mobile-navbar-menu").toggleClass("noindex");
  jQuery(".mobile-navbar-menu nav.inproduct").toggleClass("active");

});
