
(function ($, window, document, undefined) {

 'use strict';

 var $html = $('html');

 $html.on('click.ui.dropdown', '.save-factor', function (e) {
	 e.preventDefault();
	 $(this).toggleClass('is-open');
 });

 $html.on('click.ui.dropdown', '.save-factor [data-dropdown-value]', function (e) {
	 e.preventDefault();
	 var $item = $(this);
	 var $dropdown = $item.parents('.save-factor');
 });

 $html.on('click.ui.dropdown', function (e) {
	 var $target = $(e.target);
	 if (!$target.parents().hasClass('save-factor')) {
		 $('.save-factor').removeClass('is-open');
	 }
 });

})(jQuery, window, document);



document.querySelector("#pdf_saver").addEventListener("click", function() {
	document.getElementById('factors').style.paddingRight='10%';
	document.getElementById('factors').style.paddingTop='20px';
	document.getElementById('factors').style.paddingLeft='10%';

		 html2canvas(document.getElementById('factors')).then(function(canvas) {
				 var imgData = canvas;
				 var imgWidth = 210;
				 var pageHeight = 295;
				 var imgHeight = canvas.height * imgWidth / canvas.width;
				 var heightLeft = imgHeight;

				 var doc = new jsPDF('p', 'mm');
				 var position = 0;

				 doc.addImage(imgData, 'TIF', 0, position, imgWidth, imgHeight);
				 heightLeft -= pageHeight;

				 while (heightLeft >= 0) {
					 position = heightLeft - imgHeight;
					 doc.addPage();
					 doc.addImage(imgData, 'TIF', 0, position, imgWidth, imgHeight);
					 heightLeft -= pageHeight;
				 }

				doc.save('Factor-Export.pdf');
				document.getElementById('factors').style.paddingRight='20%';
				document.getElementById('factors').style.paddingLeft='20%';
				document.getElementById('factors').style.paddingTop='0px';
	 });

}, false);

document.querySelector("#img_saver").addEventListener("click", function() {
	document.getElementById('factors').style.paddingRight='22%';
	document.getElementById('factors').style.paddingTop='20px';
	document.getElementById('factors').style.paddingLeft='22%';

 html2canvas(document.getElementById('factors')).then(function(canvas) {

		 var a = document.createElement('a');
		 // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
		 a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");

		a.download = 'image-Export.jpg';
		a.click();
		document.getElementById('factors').style.paddingRight='20%';
		document.getElementById('factors').style.paddingLeft='20%';
		document.getElementById('factors').style.paddingTop='0px';

 });

}, false);

jQuery(document).ready(function($) {
	"use strict";
	$('.html-invoice').click(function (event){
		var url = $(this).attr("href");
		if ($.browser.webkit) {
			window.open(url, "Print", "width=800, height=600");
		} else {
			window.open(url, "Print", "scrollbars=1, width=800, height=600");
		}
		event.preventDefault();
		return false;
  });
});

jQuery(document).ready(function($) {
	"use strict";
	$('.factor-link').click(function (event){
		var url = $(this).attr("href");
		if ($.browser.webkit) {
			window.open(url, "Print", "width=800, height=980");
		} else {
			window.open(url, "Print", "scrollbars=1, width=800, height=980");
		}
		event.preventDefault();

		return false;
  });

	$('.0').click(function (event){
		var url = $(this).attr("href");
		if ($.browser.webkit) {
			window.open(url, "Print", "width=800, height=980");
		} else {
			window.open(url, "Print", "scrollbars=1, width=800, height=980");
		}

		event.preventDefault();
		return false;
  });

});
