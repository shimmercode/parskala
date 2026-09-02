var captcha_codes = [];
var captcha_ids = [
    'ahura-login-captcha',
    'ahura-register-captcha',
    'ahura-resetpwd-captcha',
];

function iElement(selector){
    return typeof selector === 'function' ? selector : jQuery(selector);
}

function iWantLoader(element, type = ''){
    let el = iElement(element),
        loaderContent = iElement(`<div class="is-loader loader-line"></div>`);
    el.css('position', 'relative');
    if(type === 'text'){
        if(el.find('span')){
            el.data('text', el.find('span').text());
            el.find('span').text(assets_data.translate.doing);
        } else {
            el.data('text', el.text());
            el.text(assets_data.translate.doing);
        }

    } else {
        loaderContent.hide();
        el.append(loaderContent);
        el.find('.is-loader').slideDown();
    }
    el.addClass('has-loader');
}

function iCantLoader(element, type = 'text'){
    let el = iElement(element);
    if(type === 'text'){
        if(el.find('span')){
            el.find('span').text(el.data('text'));
        } else {
            el.text(el.data('text'));
        }
    } else {
        el.find('.is-loader').slideUp(function(){
            iElement(this).remove();
        });
    }
    el.removeClass('has-loader');
}

function ahuraSetCookie(name, value, exdays = 30) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function ahuraDeleteCookie(name, exdays = 35) {
    const d = new Date();
    d.setTime(d.getTime() + (-exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = name + "=;" + expires + ";path=/";
}

function ahuraGetCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function ahuraCheckCookie(name) {
    let data = ahuraGetCookie(name);
    if (data != "") {
        return true;
    }

    return false;
}

function ahuraDatetimeToCountdown(datetime, selector){
    const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;
    if (selector != null && selector !== undefined) {
        let TargetDate = Date.parse(datetime),
            startInterval = setInterval(function () {

                let now = Date.parse(new Date()),
                    distance = TargetDate - now;

                selector.querySelector('.days .num').innerText = Math.floor(distance / (day)),
                    selector.querySelector('.hours .num').innerText = Math.floor((distance % (day)) / (hour)),
                    selector.querySelector('.minutes .num').innerText = Math.floor((distance % (hour)) / (minute)),
                    selector.querySelector('.seconds .num').innerText = Math.floor((distance % (minute)) / second);

                if (distance < 0) {
                    selector.querySelector('.countdown-time').remove();
                    selector.querySelector('.time-end').style.display = 'inline-block';
                    clearInterval(startInterval);
                }
            }, second);
    }
}

function ahuraShowFixedMessage(message, type = 'success', timeout = 9000){
    let body = jQuery('body'), msgWrap;
    ahuraDestroyFixedMessages();

    body.append(
        jQuery('<div/>', {'class': 'fixed-message-wrap'}).append(
            jQuery('<div/>', {'class': 'fixed-message-content', text: message, 'data-type': type}).append(
                jQuery('<span/>', {'class': 'remove-fixed-message', text: '+'})
            )
        ),
    );

    msgWrap = body.find('.fixed-message-wrap');

    setTimeout(function(){
        msgWrap.addClass('fixed-message-show');
    }, 300);

    ahuraDestroyFixedMessages(timeout);
}

function ahuraDestroyFixedMessages(timeout = 500, remove = true){
    let body = jQuery('body'),
        msgWrap = body.find('.fixed-message-wrap');
    if(msgWrap.length > 0){
        setTimeout(function(){
            msgWrap.removeClass('fixed-message-show');
            if(remove){
                msgWrap.remove();
            }
        }, timeout);
    }
}

function ahuraGenerateCatptcha(element_id = 'captcha', type = 'number'){
    if(document.getElementById(element_id)){
        document.getElementById(element_id).innerHTML = "";
        var charsArray ="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$%^&*";
        if(type == 'number'){
            charsArray ="0123456789";
        }
        var lengthOtp = 6;
        var captcha = [];
        for (var i = 0; i < lengthOtp; i++) {
            var index = Math.floor(Math.random() * charsArray.length + 1);
            if (captcha.indexOf(charsArray[index]) == -1)
                captcha.push(charsArray[index]);
            else i--;
        }
        var canv = document.createElement("canvas");
        canv.id = element_id;
        canv.width = 100;
        canv.height = 50;
        var ctx = canv.getContext("2d");
        ctx.font = "25px Georgia";
        ctx.strokeText(captcha.join(""), 0, 30);
        captcha_codes[element_id] = captcha.join("");
        document.getElementById(element_id).appendChild(canv);
    }
}

function ahuraReGenerateCaptchaCodes(){
    if(typeof captcha_ids !== "undefined" && captcha_ids.length){
        jQuery.each(captcha_ids, function(i, val){
            ahuraGenerateCatptcha(val);
        });
    }
}

function ahuraScrollTo(element_id, time = 2000){
    let targetEl = jQuery('body').find(element_id);
    if(targetEl.length){

        if(window.matchMedia("(max-width: 767px)").matches){
            time = "slow";
        }

        jQuery('html, body').animate({
            scrollTop: targetEl.offset().top
        }, time);
    }
}

function ahuraGetQueryVarByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

jQuery(document).ready(function ($){
    ahuraReGenerateCaptchaCodes();

    $(document).on('click', '.reload-captcha', function (e) {
        e.preventDefault();
        let btn = $(this),
            captchaID;
        if(btn.hasClass('captcha-code')){
            captchaID = btn.attr('id');
        } else {
            captchaID = btn.parent().children('.captcha-code').attr('id');
        }
        ahuraGenerateCatptcha(captchaID);
    });
});