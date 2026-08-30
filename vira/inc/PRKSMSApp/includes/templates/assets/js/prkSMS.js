var $ = jQuery;
function prkSMSChangeTab(a) {
    $("div.prk-sms-tab").hide(), $("a.nav-tab ").removeClass("nav-tab-active"), $("div#prkSMS" + a + "Tab").show(), $("a[href='#" + a + "']").addClass("nav-tab-active");
}
function showprkSMSModal(a, s = "system") {
    $("#prkSMSModalType").val(a);
        $("#prkSMSTemplateParameter").html($("span[name='" + a + "_parameter']").html());
        $("#prkSMSModalMobile").val($("input[name='" + a + "_mobile']").val());
        $("#prkSMSModalTemplate").val($("input[name='" + a + "_template']").val());
        $("#prkSMSModalText").val($("input[name='" + a + "_text']").val());
        // اگر متن پیامک خالی بود → متن پیش‌فرض OTP ست کن
        // اگر متن پیامک خالی بود → متن پیش‌فرض OTP ست کن
        if (!$("#prkSMSModalText").val().trim()) {
           $("#prkSMSModalText").val("کاربر عزیز کد تایید شما \n#code# \nمیباشد").trigger("input");
        }


        $("#prkSMSModalText").trigger('input');
        "admin" == s
            ? ($("#prkSMSModalMobile").show(),
              $("#prkSMSModalMobileLabel").html(
                  "شماره مدیران را وارد نمایید: <i class='dashicons dashicons-info' title='شماره موبایل مقصد از طریق این قسمت در سیستم ثبت می گردد. شما می توانید شماره موبایل مدیران سایت را در حالتی که قصد ارسال پیامک به ادمین را دارید، در این قسمت طبق ساختار گفته شده، وارد نمایید.'></i>"
              ),
              $("#prkSMSModalMobileSmall").html("شماره موبایل مدیران را با<code>,</code> جدا کنید."),
              $("#prkSMSModalMobileError").html("*شماره تلفن های وارد شده صحیح نمی باشند"),
              $("#prkSMSModalMobile").attr("data-validation", "admin"),
              $("#prkSMSModalMobile").attr("placeholder", "0911*******,0912*******,0913*******"),
              $("#prkSMSModalMobile").removeClass("prk-sms-right-placeholder").addClass("prk-sms-left-placeholder"))
            : "system" == s
            ? ($("#prkSMSModalMobile").val(0).hide(),
              $("#prkSMSModalMobile").attr("data-validation", "none"),
              $("#prkSMSModalMobileLabel").html(
                  "انتخاب خودکار شماره موبایل کاربر: <i class='dashicons dashicons-info' title='شماره موبایل مقصد از طریق این قسمت در سیستم ثبت می گردد. ارسال پیامک در مراحل مختلف ورود/ثبت نام به صورت کاملا خودکار و توسط سیستم انجام خواهد شد.'></i>"
              ),
              $("#prkSMSModalMobileSmall").text("") )
            : "order" == s
            ? ($("#prkSMSModalMobile").val(0).hide(),
              $("#prkSMSModalMobile").attr("data-validation", "none"),
              $("#prkSMSModalMobileLabel").html(
                  "انتخاب خودکار شماره موبایل کاربر: <i class='dashicons dashicons-info' title='شماره موبایل مقصد از طریق این قسمت در سیستم ثبت می گردد. ارسال پیامک در ووکامرس به صورت کاملا خودکار و توسط سیستم انجام خواهد شد.'></i>"
              ),
              $("#prkSMSModalMobileSmall").text("مراحل تشخیص شماره موبایل و ارسال پیامک از طریق شماره موبایل موجود در فاکتور خواهد بود."))
            : ($("#prkSMSModalMobile").show(),
              $("#prkSMSModalMobileLabel").html(
                  "ورودی شماره موبایل کاربر را وارد نمایید: <i class='dashicons dashicons-info' title='شماره موبایل مقصد از طریق این قسمت در سیستم ثبت می گردد. شماره موبایل کاربران در فرم سازهای Gravity و Contact7 نیز به وسیله شناسه یکتای هر کدام از ورودی ها (Input)، شناسایی و ارسال پیامک انجام خواهد شد. لیست شناسه ها و ورودی های هر فرم نیز در انتهای این پاپ آپ قرار داده شده است.'></i>"
              ),
              $("#prkSMSModalMobileSmall").text("پارامترهای مورد قبول در انتهای این صفحه قرار دارند. مثال #phone1.#"),
              $("#prkSMSModalMobileError").html("*ورودی شماره موبایل کاربر وارد شده صحیح نمی باشد"),
              $("#prkSMSModalMobile").attr("placeholder", "ورودی شماره موبایل را از بین پارامترهای مورد قبول انتخاب نمایید"),
              $("#prkSMSModalMobile").attr("data-validation", "template"),
              $("#prkSMSModalMobile").removeClass("prk-sms-left-placeholder").addClass("prk-sms-right-placeholder")),
        // 0 != $("#prkSMSModalTemplate").val() ? ($("input.prk-sms-check").prop("checked", !0), prkSMSSenderType(1)) : ($("input.prk-sms-check").prop("checked", !1), prkSMSSenderType(0)),
        $("#prkSMSModal").show();
}
function saveprkSMSModal() {
    const a = $("#prkSMSModalMobile").attr("data-validation");
    let s = 0;
    switch (a) {
        case "admin":
            $("#prkSMSModalMobile")
                .val()
                .split(",")
                .forEach((a) => {
                    a.length < 10 &&
                        ($("#prkSMSModalMobileError").show(),
                        s++,
                        $("#prkSMSModalMobile").on("keyup", () => {
                            const a = $("#prkSMSModalMobile").val().split(",");
                            (newError = 0),
                                a.forEach((a) => {
                                    a.length < 10 && newError++;
                                }),
                                0 == newError && $("#prkSMSModalMobileError").hide();
                        }));
                });
            break;
        case "template":


            const a = new RegExp("#[\\S]{2,}#");
            a.test($("#prkSMSModalMobile").val()) ||
                ($("#prkSMSModalMobileError").show(),
                s++,
                $("#prkSMSModalMobile").on("keyup", (s) => {
                    a.test($("#prkSMSModalMobile").val()) && $("#prkSMSModalMobileError").hide();
                }));
    }
    if (
        (
            (console.log("ok"),
            $("#prkSMSModalTemplate").val() < 100 &&
                ($("#prkSMSModalTemplateError").show(),
                s++,
                $("#prkSMSModalTemplate").on("keyup", () => {
                    $("#prkSMSModalTemplate").val() >= 100 && $("#prkSMSModalTemplateError").hide();
                }))),
        s > 0)
    )
        return !1;
    var o = $("#prkSMSModalType").val();
    1 == $(".prk-sms-check").prop("checked")
        ? $("span[name='" + o + "_parameter']")
              .find(".prk-sms-setting-parameter")
              .each(function () {})
        : '',
        $(".prk-sms-modal-form-control").each(function () {
            if (($(this).removeClass("prk-sms-modal-form-control-error"), 0 == $(this).val().length)) throw ($(this).addClass("prk-sms-modal-form-control-error"), 422);
        }),
        $("input[name='" + o + "_mobile']").val($("#prkSMSModalMobile").val()),
        $("input[name='" + o + "_template']").val($("#prkSMSModalTemplate").val()),
        $("input[name='" + o + "_text']").val($("#prkSMSModalText").val()),
        $("input[name='" + o + "']").prop("checked", !0),
        $("input[name='" + o + "_status']").val(1),
        $("i[data-name='" + o + "']").show(),
        hideprkSMSModal();
}
function hideprkSMSModal() {
    $("#prkSMSModal").hide(),
        $("#prkSMSModalMobileError,#prkSMSModalTemplateError").hide(),
        $(".prk-sms-modal-form-control").each(function () {
            $(this).removeClass("prk-sms-modal-form-control-error");
        });
}
// function prkSMSSenderType(a) {
//     a ? $("#prkSMSModalMobileVerify").show() : ($("#prkSMSModalMobileVerify").show(), $("#prkSMSModalMobileBulk").show());
// }
$(document).ready(function () {
    $(".prk-sms-setting-checkbox").change(function () {
        var a = $(this).attr("name"),
            s = $(this).attr("data-type");
        $("i[data-name='" + a + "']").hide(), this.checked ? ($(this).prop("checked", !1), showprkSMSModal(a, s)) : $("input[name='" + a + "_status']").val(0);
    }),
        $(".dashicons-visibility").click(function () {
            showprkSMSModal($(this).data("name"), $(this).data("type"));
        }),
        $(document).on("click", ".prk-sms-setting-parameter", function () {
            const textarea = $("#prkSMSModalText");
            const paramText = $(this).text();

            textarea.val(textarea.val() + paramText + "\r\n").trigger("input").focus();
        });
}),
    jQuery(document).ready(function (a) {
        a("[name='prk_sms_setting_button']").click(function(e){
            submit_settings=a(this);
            submit_settings.text('ذخیره سازی ...');
            e.preventDefault();
            var datasss = $('form').serialize();
            jQuery.post(prk_sms_handler.ajaxurl, {action: "prk_sms_submit_settings",data:datasss,security: prk_sms_handler.ajaxnonce}, function(response){
                response =JSON.parse(response);
                submit_settings.text('ذخیره سازی');
                if(response.success){
                    submit_settings.after('<div id="prksmsapp-settings-form-save-result" class="prksmsapp-settings-form-success-save-result csf-form-success">'+response.message+'</div>')
                }else{
                    submit_settings.after('<div id="prksmsapp-settings-form-save-result" class="prksmsapp-settings-form-error-save-result csf-form-success">'+response.error+'</div>')
                }
               
                setTimeout(function(){
                    a('#prksmsapp-settings-form-save-result').remove()
                }, 2000);
            });
    
        })
        a("[name='prk_sms_test_button']").click(function(e){
            submit_send_test=a(this);
            submit_send_test.text('در حال ارسال ...');
            submit_send_test.attr('disabled','disabled')
            e.preventDefault();
            var datasss = $('form').serialize();
            jQuery.post(prk_sms_handler.ajaxurl, {action: "prk_sms_test_send",data:datasss,security: prk_sms_handler.ajaxnonce}, function(response){
                response =JSON.parse(response);
                submit_send_test.text('تست ارسال پیامک');
                submit_send_test.removeAttr('disabled')

                if(response.success){
                    submit_send_test.after('<div id="prksmsapp-settings-form-save-result" class="prksmsapp-settings-form-success-save-result csf-form-success">'+response.message+'</div>')
                }else{
                    submit_send_test.after('<div id="prksmsapp-settings-form-save-result" class="prksmsapp-settings-form-error-save-result">'+response.error+'</div>')
                }
               
                setTimeout(function(){
                    a('#prksmsapp-settings-form-save-result').remove()
                }, 2000);
            });
    
        })
        a("#promotionSave").click(function (s) {
            var o = { action: "prkSMSAjax", type: "promotion", name: a("#promotionName").val(), mobile: a("#promotionMobile").val(), product_id: a("#comment_post_ID").val(), security: prk_sms_handler.ajaxnonce };
            s.preventDefault(),
                a.post(prk_sms_handler.ajaxurl, o, function (s) {
                    s.success
                        ? a("#promotionError").html(s.data.message).css("color", "green")
                        : s.data
                        ? a("#promotionError").html(s.data.error).css("color", "red")
                        : a("#promotionError").html("پاسخی از سمت سرور دریافت نشد.").css("color", "red");
                });
        }),
            a("#inventorySave").click(function (s) {
                var o = { action: "prkSMSAjax", type: "inventory", name: a("#inventoryName").val(), mobile: a("#inventoryMobile").val(), product_id: a("#comment_post_ID").val(), security: prk_sms_handler.ajaxnonce };
                s.preventDefault(),
                    a.post(prk_sms_handler.ajaxurl, o, function (s) {
                        s.success
                            ? a("#inventoryError").html(s.data.message).css("color", "green")
                            : s.data
                            ? a("#inventoryError").html(s.data.error).css("color", "red")
                            : a("#inventoryError").html("پاسخی از سمت سرور دریافت نشد.").css("color", "red");
                    });
            });
    });


// الگو ساز سامانه ها ********//
function formatPreviewParams(rawText, gateway) {
  const text = String(rawText || '');
  const paramRegex = /#([\w]+)#/g;

  // چندکلمه‌ای/بلند → ترجیح token20
  const LONG_PARAMS = new Set(['items','description','address1','address2','company']);
  // چندکلمه‌ای کوتاه → ترجیح token10
  const SOFTSPACE_PARAMS = new Set(['firstname','lastname','productname','clientname','paymentmethod','city','state','country']);

  if (gateway === 'kavenegar') {
    // هر توکن فقط یکبار
    const available = { token:true, token2:true, token3:true, token10:true, token20:true };
    const assigned = new Map(); // هر پارامتر → چه توکنی گرفت

    const nextCompact = () => {
      if (available.token)  { available.token  = false; return 'token';  }
      if (available.token2) { available.token2 = false; return 'token2'; }
      if (available.token3) { available.token3 = false; return 'token3'; }
      return null;
    };

    const out = text.replace(paramRegex, (_m, p1) => {
      const name = (p1 || '').toLowerCase();

      // قبلاً مپ شده؟
      if (assigned.has(name)) return '%' + assigned.get(name) + '%';

      // OTP/code → حتماً token
      if (name === 'code') {
        if (!available.token) return ''; // ظرفیت تمام
        available.token = false;
        assigned.set(name, 'token');
        return '%token%';
      }

      // بلندها → token20 سپس token10 سپس کامپکت‌ها
      if (LONG_PARAMS.has(name)) {
        let tk = '';
        if (available.token20)      { tk='token20'; available.token20=false; }
        else if (available.token10) { tk='token10'; available.token10=false; }
        else                        { tk = nextCompact(); }
        if (!tk) return '';
        assigned.set(name, tk);
        return '%' + tk + '%';
      }

      // چندکلمه‌ای کوتاه → token10 سپس کامپکت‌ها
      if (SOFTSPACE_PARAMS.has(name)) {
        let tk = '';
        if (available.token10) { tk='token10'; available.token10=false; }
        else                   { tk = nextCompact(); }
        if (!tk) return '';
        assigned.set(name, tk);
        return '%' + tk + '%';
      }

      // سایر پارامترها → به ترتیب token, token2, token3
      const tk = nextCompact();
      if (!tk) return '';
      assigned.set(name, tk);
      return '%' + tk + '%';
    });

    // هشدار نرم: اگر هیچ %token% در پیش‌نمایش نیست، به کاربر بگو یکی از پارامترهای بدون فاصله بگذارد
    if (!/%token\b/.test(out)) {
      // می‌تونی این را هر جا نشان بدی؛ اینجا فقط متن را برمی‌گردانم
      // مثلا کنار باکس پیش‌نمایش بنویس:
      // "⚠️ در کاوه‌نگار وجود %token% الزامی است."
    }
    return out;
  }

  // بقیه پنل‌ها: همان مپ قبلی اما پایدار و بدون تکرار شماره
  const assigned = new Map();

  if (gateway === 'farazsms') {
    return text.replace(paramRegex, (_m, p1) => `%${(p1||'').toLowerCase()}%`);
  }
  if (gateway === 'smsir') {
    return text.replace(paramRegex, (_m, p1) => `#${(p1||'').toLowerCase()}#`);
  }
  if (gateway === 'msgway') {
    let idx = 0;
    return text.replace(paramRegex, (_m, p1) => {
      const k = (p1||'').toLowerCase();
      if (!assigned.has(k)) assigned.set(k, ++idx);
      return `[param${assigned.get(k)}]`;
    });
  }
  if (gateway === 'Mediana') {
    let idx = 0;
    return text.replace(paramRegex, (_m, p1) => {
      const k = (p1||'').toLowerCase();
      if (k === 'carturl' || k === 'orderurl' || k === 'rateurl') return '{{url}}';
      if (!assigned.has(k)) assigned.set(k, ++idx);
      return `{{token${assigned.get(k)}}}`;
    });
  }
  if (gateway === 'melipayamak') {
    let idx = -1;
    return text.replace(paramRegex, (_m, p1) => {
      const k = (p1||'').toLowerCase();
      if (!assigned.has(k)) assigned.set(k, ++idx);
      return `{${assigned.get(k)}}`;
    });
  }

  // fallback
  return text.replace(paramRegex, (_m, p1) => `%${(p1||'').toLowerCase()}%`);
}


// بقیه کد رویدادها همون قبلی‌ت بمونه


$("#prkSMSModalText").on("input", function () {
    const rawText = $(this).val();
    const gateway = $("#gatewaysPanel").val();
    const formattedText = formatPreviewParams(rawText, gateway);
    $("#prkSMSLivePreview .text").text(formattedText);
});

$(document).on("click", ".prk-sms-preview-box .copy-btn", function () {
    // ابتدا clone می‌گیریم از باکس پیش‌نمایش
    const clonedBox = $("#prkSMSLivePreview .text").clone();

    // تبدیل همه ایموجی‌ها از <img> به متن alt
    clonedBox.find("img.emoji").each(function () {
        const emojiAlt = $(this).attr("alt") || "";
        $(this).replaceWith(emojiAlt);
    });

    // ساخت textarea برای کپی
    const textToCopy = clonedBox.text();
    const tempTextarea = document.createElement("textarea");
    tempTextarea.value = textToCopy;
    tempTextarea.setAttribute("readonly", "");
    tempTextarea.style.position = "absolute";
    tempTextarea.style.left = "-9999px";

    document.body.appendChild(tempTextarea);
    tempTextarea.select();

    const successful = document.execCommand("copy");
    document.body.removeChild(tempTextarea);

    if (successful) {
        $(".prk-sms-preview-box .copied-msg").fadeIn(200).delay(1000).fadeOut(300);
    } else {
        alert("خطا در کپی متن");
    }
});
// الگو ساز سامانه ها  اتمام********//




// راهنمای قالب پیامک********//
document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  
  if (!hash) return;

  const hashID = hash.replace('#', '');
  const $targetRow = document.querySelector(`tr[data-hash-id="${hashID}"]`);
  if (!$targetRow || typeof tourguide === 'undefined') return;

  const checkbox = $targetRow.querySelector('input.prk-sms-setting-checkbox');
  const name = checkbox?.getAttribute('name');
  const type = checkbox?.getAttribute('data-type');

  const tg = new tourguide.TourGuideClient({
    steps: [
      {
        target: $targetRow,
        title: getSMSGuideTitle(hash),
        content:
          `<p class="tg-sms-text">${getSMSGuideContent(hash)}</p>` +
          `<div class="tg-sms-btn-box"><button id="${hashID}-confirm" class="tg-sms-btn">متوجه شدم</button></div>`,
        position: 'bottom',
        padding: 4
      }
    ],
    exitOnClickOutside: false,
    targetPadding: 6,
    backdropColor: 'rgba(0, 0, 0, 0.7)',
    hidePrev: true,
    hideNext: true,
    dialogClass: 'tg-sms-dialog',
    showStepDots: false,
    showStepProgress: false,
    exitOnClickOutside: true,
  });

  tg.start();

  // وقتی دکمه داخل راهنما کلیک شد
  document.addEventListener('click', function confirmClickHandler(e) {
    if (e.target.id === `${hashID}-confirm`) {
      tg.exit();
      if (name && type) {
        showprkSMSModal(name, type); // پاپ‌آپ باز شه
      }
      document.removeEventListener('click', confirmClickHandler);
    }
  });

  // اگه کاربر رو خود چک‌باکس کلیک کرد => اول راهنما ببند بعد پاپ‌آپ باز کن
  if (checkbox) {
    checkbox.addEventListener('click', function (e) {
      e.preventDefault();
      tg.exit();
      showprkSMSModal(name, type);
    });
  }
});


// عنوان راهنما بر اساس هش
function getSMSGuideTitle(hash) {
  switch (hash) {
    case '#promo-guide':
      return 'راهنمای پیامک شگفت‌انگیز';
        
    case '#otpPattern':
      return 'راهنمای پیامک ورود/عضویت';

    case '#remcartPattern':
      return 'راهنمای الگوی تنظیم پیامک';
    case '#remrderPattern':

      return 'راهنمای الگوی تنظیم پیامک';
    case '#ratePattern':
      return 'راهنمای الگوی تنظیم پیامک';

    default:
      return 'راهنمای پیامک';

  }
}

// متن راهنما بر اساس هش
function getSMSGuideContent(hash) {
  switch (hash) {
    case '#promo-guide':
      return 'با فعال کردن این گزینه، پیامک پیشنهادات شگفت‌انگیز برای کاربران ارسال خواهد شد.';

    case '#otpPattern':
      return '۱) متن پیامک پیش‌فرض شامل کد تایید (#code#) را وارد کنید یا همان متن آماده را استفاده کنید.<br>۲) سپس همین متن را در سامانه پیامکی خود به عنوان یک پترن (الگو) ذخیره کنید.<br>۳) در نهایت، کد پترن ساخته شده را در فیلد بالا وارد نمایید.';
    
    case '#remcartPattern':
      return 'با فعال کردن این گزینه، پیامک یاداوری سبدخرید پرداخت نشده برای کاربران ارسال خواهد شد.';
    case '#remrderPattern':
      return 'با فعال کردن این گزینه، پیامک یاداوری پرداخت سفارش برای کاربران ارسال خواهد شد.';
    case '#ratePattern':
      return 'با فعال کردن این گزینه، پیامک نظرسنجی محصول برای کاربران ارسال خواهد شد.';
    default:
      return 'از اینجا می‌توانید تنظیمات ارسال پیامک را انجام دهید.';
  }
}
