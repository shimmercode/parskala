jQuery(document).ready( function() {

    jQuery(".submit_newsletter_form").click( function(e) {
       e.preventDefault(); 
       newsletter_mobile = jQuery(this).closest("form.prk_sms_newsletter_form").find("input.prk_sms_newsletter_mobile").val()
       nonce = jQuery(this).closest("form.prk_sms_newsletter_form").find("input.prk_sms_newsletter_mobile").attr("data-nonce")

       jQuery.ajax({
          type : "post",
          dataType : "json",
          url : myAjax.ajaxurl,
          data : {action: "prk_sms_newsletter", newsletter_mobile : newsletter_mobile, nonce: nonce},
          success: function(response) {
             if(response.success == true) {
                alert(response.message)
             }else{
                alert(response.message)
             }
          }
       })   
 
    })
 
 })