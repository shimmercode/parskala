var stm_timer;

jQuery(document).ready(function(){
  // footer menu mobile
  var $ = jQuery;

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });
  
  var el = document.querySelectorAll('.login-limit-counter');
  if (el.length == '1') {
      let time = jQuery('.login-limit-counter').data('countdown-seconds');
      limit_login_counter_timer(time,"login-limit-counter");
  }


  jQuery(document).on('input','#stm-sms-count-confirm--code',function() {
    var that=jQuery(this);
    if (that.val().length==that.attr('maxlength')) {
        that.closest('form').submit();
    }
});

jQuery(document).on('submit', '#stm-form-sms', function (e) {
  e.preventDefault();
  let type = '';
  let input = jQuery('.stm-user-type').val();

  if (stm_validate_Email(input)) {
    type = 'email';
  } else if (stm_phone_number(input)) {
    type = 'mobile';
  } else {
    jQuery('.stm-sms-holder').addClass('has-error');
    jQuery('#email_phone_error').css({'display': 'block'});
    return false;
  }
  jQuery("#stm-form-sms").addClass('stm-sms-load');
  jQuery(".onliner_main_loading").addClass('stm-sms-load');
  jQuery('.prk-sms-loginform').css({'display': 'none'});

  jQuery.ajax({
    url: parskala_values.ajax_url,
    type: 'post',
    dataType: 'json',
    data: {
      action: 'stm_login_register',
      type: type,
      input: input,
    },
    success: function (response) {

      if (response.success == true) {

        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'success',
          title: response.text,
          timer: 2000
        })
      jQuery(".onliner_main_loading").removeClass('stm-sms-load');
      jQuery('.prk-sms-loginform').css({'display': 'block'});
      jQuery('#stm-form-sms').css({'display': 'none'});
      jQuery('.copyright-login-footer').css({'display': 'none'});



        setTimeout(function () {
          jQuery("#stm-sms-form-holder").html(response.data);
          var el = document.querySelectorAll('.stm-sms-confirm---code-counter');
          if (el.length == '1') {
            let time = jQuery('.stm-sms-confirm---code-counter').data('countdown-seconds');
            stm_sms_counter_timer(time);
          }
        });

      } else {

        if(response.data !== undefined){
          jQuery('.stm-sms-holder').removeClass('has-error');
          jQuery('#email_phone_error').css({'display': 'none'});
          jQuery(".stm-sms-confirm--timer-holder").html(response.data);
          var el = document.querySelectorAll('.login-limit-counter-again');
          if (el.length == '1') {
            let time = jQuery('.login-limit-counter-again').data('countdown-seconds');
            clearInterval(stm_timer);
            limit_login_counter_timer(time,"login-limit-counter-again");
         }
        }
     
       
       

        jQuery("#stm-form-sms").removeClass('stm-sms-load');
        jQuery(".onliner_main_loading").removeClass('stm-sms-load');
        jQuery('.prk-sms-loginform').css({'display': 'block'});
        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'error',
          title: response.text,
          timer: 2500
        })
      }

    },
    error: function () {
    }
  });

});

jQuery(document).on('submit', '#stm-sms-count-confirm--code', function (e) {
  let key = jQuery('#authConfirm').data('phone-number');

  let value = jQuery('.stm-sms-confirm--code').val();
  let counter = document.getElementById('stm-counter').innerText;
  jQuery("#authConfirm").addClass('stm-sms-load');
  jQuery(".onliner_main_loading").addClass('stm-sms-load');
  jQuery('.prk-sms-loginform').css({'display': 'none'});
  console.log('POST key=', key, ' value=', value);
  jQuery.ajax({
    url: parskala_values.ajax_url,
    type: 'post',
    dataType: 'json',
    timeout: 20000,
    data: {
      action: 'stm_sms_check_log_reg',
      key: key,
      value: value,
      counter: counter,
    },
    success: function (response) {

      if (response.success == true) {

        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'success',
          title: response.text,
          timer: 2000
        })

     

      } else {
        jQuery("#authConfirm").removeClass('stm-sms-load');
        jQuery(".onliner_main_loading").removeClass('stm-sms-load');
        jQuery('.prk-sms-loginform').css({'display': 'none'});
        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'error',
          title: response.text,
          timer: 2500
        })
      }
    },
    error: function () {
    }
  });
});

jQuery(document).on('submit', '#authConfirm', function (e) {
  e.preventDefault();

  let key = jQuery(this).data('phone-number');

  let value = jQuery('.stm-sms-confirm--code').val();
  let counter="00:00";
  if(jQuery('#stm-counter').length){
     counter = document.getElementById('stm-counter').innerText;
  }

  jQuery("#authConfirm").addClass('stm-sms-load');
  jQuery(".onliner_main_loading").addClass('stm-sms-load');
  jQuery('.prk-sms-loginform').css({'display': 'none'});
  console.log('POST key=', key, ' value=', value);
  jQuery.ajax({
    url: parskala_values.ajax_url,
    type: 'post',
    dataType: 'json',
    timeout: 20000,
    data: {
      action: 'stm_sms_check_log_reg',
      key: key,
      value: value,
      counter: counter,
    },
    success: function (response) {

      if (response.success == true) {

        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'success',
          title: response.text,
          timer: 2000
        })
        setTimeout(function () {
          if(response.code == '1020'){
            jQuery("#stm-sms-form-holder").html(response.data);
            jQuery("#authConfirm").removeClass('stm-sms-load');
            jQuery(".onliner_main_loading").removeClass('stm-sms-load');
            jQuery('.prk-sms-loginform').show();
          }else{
            window.location.href=window.location.href

          }
  
        }, 2000)

      } else {
        jQuery("#authConfirm").removeClass('stm-sms-load');
        jQuery(".onliner_main_loading").removeClass('stm-sms-load');
        jQuery('.prk-sms-loginform').css({'display': 'block'});
        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'error',
          title: response.text,
          timer: 2500
        })
      }
    },
    error: function () {
    }
  });
});

jQuery(document).on('submit', '#authConfirm_password', function (e) {
  e.preventDefault();

  let key = jQuery(this).data('phone-number');

  let value = jQuery('.stm-sms-confirm--code').val();

  jQuery("#authConfirm_password").addClass('stm-sms-load');
  jQuery(".onliner_main_loading").addClass('stm-sms-load');
  jQuery('.prk-sms-loginform').css({'display': 'none'});
  jQuery.ajax({
    url: parskala_values.ajax_url,
    type: 'post',
    dataType: 'json',
    timeout: 20000,
    data: {
      action: 'stm_sms_check_pass_log_reg',
      key: key,
      value: value,
    },
    success: function (response) {

      if (response.success == true) {

        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'success',
          title: response.text,
          timer: 2000
        })

        setTimeout(function () {
          window.location.href=window.location.href
        }, 2000)

      } else {
        jQuery("#authConfirm_password").removeClass('stm-sms-load');
        jQuery(".onliner_main_loading").removeClass('stm-sms-load');
        jQuery('.prk-sms-loginform').css({'display': 'block'});
        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'error',
          title: response.text,
          timer: 2500
        })
      }
    },
    error: function () {
    }
  });
});
jQuery(document).on('click', '.stm-sms-confirm--retrieve', function (e) {
  e.preventDefault();

  let type = '';

  let input = document.getElementById('stm-otp-phone-number').innerText;

  if (stm_validate_Email(input)) {
    type = 'email';
  } else if (stm_phone_number(input)) {
    type = 'mobile';
  } else {
    Toast.fire({
      toast: true,
      position: 'top-right',
      icon: 'error',
      title: 'صفحه را مجدد بارگزاری کنید :)',
      timer: 2500
    })
    return false;
  }

  jQuery.ajax({
    url: parskala_values.ajax_url,
    type: 'post',
    dataType: 'json',
    data: {
      action: 'stm_retrieve_login_register',
      type: type,
      input: input,
    },
    success: function (response) {

      if (response.success == true) {
        jQuery("#stm-sms-form-holder").html(response.data);
        jQuery('.stm-sms-confirm--timer-holder').removeClass('d-none');
        jQuery('.stm-sms-confirm--retrieve').removeClass('d-block');

        let time = $('.stm-sms-confirm---code-counter').data('countdown-seconds');

        stm_sms_counter_timer(time);

        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'success',
          title: response.text,
          timer: 2000
        })

      } else {
        if(response.data !== undefined){
          jQuery('.stm-sms-confirm--timer-holder').removeClass('d-none');
          jQuery('.stm-sms-confirm--retrieve').removeClass('d-block');
          jQuery('.stm-sms-confirm--retrieve').addClass('d-none');
          jQuery(".stm-sms-confirm--timer-holder").html(response.data);
        }
      
        var el = document.querySelectorAll('.login-limit-counter-again');
        
         if (el.length == '1') {
             let time = jQuery('.login-limit-counter-again').data('countdown-seconds');
             clearInterval(stm_timer);
             limit_login_counter_timer(time,"login-limit-counter-again");
         }
        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'error',
          title: response.text,
          timer: 2500
        })
      }

    },
    error: function (error) {
      console.log(error)
    }
  });


});

jQuery(document).on('click', '.stm-change-email', function (e) {
  e.preventDefault();

  jQuery.ajax({
    url: parskala_values.ajax_url,
    type: 'post',
    dataType: 'json',
    data: {
      action: 'stm_change_email_auth',
    },
    success: function (response) {

      if (response.success == true) {

        jQuery("#stm-sms-form-holder").html(response.data);

        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'success',
          title: response.text,
          timer: 2000
        })

      } else {
        Toast.fire({
          toast: true,
          position: 'top-right',
          icon: 'error',
          title: response.text,
          timer: 2500
        })
      }

    },
    error: function (error) {
      console.log(error)
    }
  });

});

});



function limit_login_counter_timer(EXPDate,element_id) {

    var counter = 0;
    // clearInterval(stm_timer);
    stm_timer = setInterval(function () {
  

        var stm_rem = EXPDate - counter;
     
        if (!document.getElementById(element_id)) {
            clearInterval(stm_timer);

        }else{
          document.getElementById(element_id).innerHTML = stm_convToMMSS(stm_rem);

          counter++;

          if (counter >= EXPDate) {

              jQuery('.stm-sms-confirm--timer-holder').addClass('d-none');
              jQuery('.stm-sms-confirm--retrieve').addClass('d-block');

              clearInterval(stm_timer);

              document.getElementById(element_id).innerHTML = '00:00';

          }
        }

       

    }, 1000, true);

}

function stm_validate_Email(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  function stm_phone_number(input_txt) {
    var filter = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
    if (filter.test(input_txt)) {
      return true;
    } else {
      return false;
    }
  }


  function stm_sms_counter_timer(EXPDate) {

    var counter = 0;

    var stml_timer = setInterval(function () {

    var stm_rem = EXPDate - counter;

    if(!document.getElementById("stm-counter")){

        clearInterval(stml_timer);

    }

    document.getElementById("stm-counter").innerHTML = stm_convToMMSS(stm_rem);

    counter++;

    if (counter >= EXPDate) {

      jQuery('.stm-sms-confirm--timer-holder').addClass('d-none');
      jQuery('.stm-sms-confirm--retrieve').addClass('d-block');

      let input = document.getElementById('stm-otp-phone-number').innerText;

      jQuery.ajax({
        url: parskala_values.ajax_url,
        type: 'post',
        dataType: 'json',
        data: {
          action: 'stm_sms_delete_code',
          input: input,
        },
        success: function (response) {
        },
        error: function (error) {
        }
      });

      clearInterval(stml_timer);

      document.getElementById("stm-counter").innerHTML = '00:00';

    }

  }, 1000, true);

}

function stm_convToMMSS(stm_secondsTime) {
  var sec_num = parseInt(stm_secondsTime, 10);
  var hours = Math.floor(sec_num / 3600);
  var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
  var seconds = sec_num - (hours * 3600) - (minutes * 60);

  if (minutes < 10) {
    minutes = "0" + minutes;
  }
  if (seconds < 10) {
    seconds = "0" + seconds;
  }
  return minutes + ':' + seconds;
}

jQuery(".phone-loginbox input[name='login[email_phone]']").on("keyup change", function(e) {
      
  let faphonenumber = jQuery(this).val();
  toEnglishNumber(faphonenumber);

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
    
   
    jQuery(".phone-loginbox input[name='login[email_phone]']").val(cache);
}

})