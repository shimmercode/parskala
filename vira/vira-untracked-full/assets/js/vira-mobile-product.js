jQuery(document).ready(function($){

  Fancybox.bind('[data-fancybox="gallery-mob"]',{
    Toolbar: {
    display: [
      { id: "prev", position: "center" },
      { id: "counter", position: "center" },
      { id: "next", position: "center" },
      "zoom",
      "slideshow",
      "fullscreen",
      "thumbs",
      "close",
    ],
  },
  closeButton: "top",
  });


  jQuery(".single-pro .thwvsf-checkbox").on('click', function (e) {
    e.preventDefault();
    swiper.slideTo(0);
  })

});
