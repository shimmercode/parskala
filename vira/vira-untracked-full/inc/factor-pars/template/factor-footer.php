<?php
/*
فوتر مشترک فاکتور و برچسب

**/

// options setting factor

$f_preview = prk_option('f_preview');
?>
</body>
<footer>

<?php if ($f_preview!= "1") { ?>

<input type="hidden" id="prntaset" value=""/>

<?php } else { ?>

<input type="hidden" id="prntaset" value="enabled"/>

<?php } ?>

<script>

	 var pr = $('#prntaset').val();
    $('body').show();
    $('.version').text(NProgress.version);
    NProgress.start();
    setTimeout(function() { NProgress.done(); $('.fade').removeClass('out'); }, 400);

	 if(pr != 'enabled'){

	  setTimeout(function() { window.print(); }, 2000);

	 }

  document.querySelector("#pdf_saver").addEventListener("click", function() {
     document.getElementById('factors').style.paddingRight='20%';
     document.getElementById('factors').style.paddingTop='20px';
     document.getElementById('factors').style.paddingLeft='20%';

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

</script>
<?php

 ?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/fct/jspdf.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/fct/addimage.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/fct/jspdf.debug.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/fct/html2canvas.min.js"></script>

</footer>
</html>
