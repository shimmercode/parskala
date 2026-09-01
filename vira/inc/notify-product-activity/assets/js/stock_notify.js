
	jQuery(document).ready(function(){




   jQuery(".stock_data").click( function(e) {


		 var inst_notif = jQuery('[data-remodal-id=notifyproduct]').remodal();


      e.preventDefault();
			
			inst_notif.close();

      jQuery(".onliner_main_loading").addClass('stm-sms-load');
      id = jQuery('.stock_data_invis').attr("data-post_id");

      userid = jQuery('.stock_data_invis').attr("data-user_id");

	   tel = jQuery("#tel").val();

        var mojoodi = '';
		var shegeft = '';
      var notifyBy = [];





        if(jQuery('#mojoodi').prop('checked')) {

			mojoodi = 't';



            }




        if(jQuery('#shegeft').prop('checked')) {

			shegeft = 't';



            }


         if(jQuery('#notifyByEmail').prop('checked')) {

            notifyBy.push('email');
         }

         if(jQuery('#notifyBySMS').prop('checked')) {

            notifyBy.push('sms');
          }
      console.log()

      jQuery.ajax({
         type : "post",
		 dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "stock_notify", id : id, tel: tel , shegeft : shegeft , mojoodi : mojoodi , userid : userid,notifyBy:notifyBy },
         success: function(response) {


            if(response.type == "success") {
               jQuery("#notice").html(response.msg).fadeIn(2000);
			         jQuery("#notice").fadeOut(5000);


            }
            else {
              jQuery("#notice").html(response.msg).fadeIn(2000);
					    jQuery("#notice").fadeOut(5000);

            }
            jQuery(".onliner_main_loading").removeClass('stm-sms-load');
         }
      });



		   //      if(jQuery('#mojoodi').prop('checked')) {

			// localStorage.setItem('mojoodi', 't');
         //      localStorage.setItem('cururl',jQuery(location).attr('href'));


         //    }


		   //      if(jQuery('#shegeft').prop('checked')) {

			// localStorage.setItem('shegeft','t');
         //      localStorage.setItem('cururl',jQuery(location).attr('href'));


         //    }


   });
	});
