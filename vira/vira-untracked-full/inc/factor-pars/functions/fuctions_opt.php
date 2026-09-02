<?php

// opt setting to functions
// تبدیل متغییر های تنظیمات فاکتور به تابع

function factor_titles() {
    if (prk_option('f_costom_title') != '') {
        return prk_option('f_costom_title');
    }
}


// اطلاعات فروشگاه

function prk_factor_name() {
    if (prk_option('f_name')) {
        return prk_option('f_name');
    }
}

function prk_factor_logo() {
    if (prk_option('f_logo') ) {
        return prk_option('f_logo');
    }
}

function prk_factor_states() {
    if (prk_option('f_states')) {
        return prk_option('f_states');
    }
}

function prk_factor_citys() {
    if (prk_option('f_citys')) {
        return prk_option('f_citys');
    }
}

function prk_factor_address() {
    if (prk_option('f_address')) {
        return prk_option('f_address');
    }
}

function prk_factor_zipcode() {
    if (prk_option('f_zipcode')) {
        return prk_option('f_zipcode');
    }
}

function prk_factor_number() {
    if (prk_option('f_company_number')) {
        return prk_option('f_company_number');
    }
}

function prk_company_email() {
    if (prk_option('f_company_email')) {
        return prk_option('f_company_email');
    }
}

function prk_factor_company_code() {
    if (prk_option('f_company_code')) {
        return prk_option('f_company_code');
    }
}

function prk_factor_codesabt() {
    if (prk_option('f_codesabt')) {
        return prk_option('f_codesabt');
    }
}

function prk_seller_stamp() {
    if (prk_option('f_seller_stamp')) {
        return prk_option('f_seller_stamp');
    }
}

function prk_seller_sgn() {
    if (prk_option('f_seller_sgn')) {
        return prk_option('f_seller_sgn');
    }
}

function prk_order_sgn() {
    if (prk_option('f_order_sgn')) {
        return prk_option('f_order_sgn');
    }
}

function prk_note_footer() {
    if (prk_option('f_note_footer')) {
        return prk_option('f_note_footer');
    }
}


// تنظیمات فاکتور

function prk_show_logo() {
    if (prk_option('f_show_logo')) {
        return prk_option('f_show_logo');
    }
}

function prk_factor_preview() {
    if (prk_option('f_preview')  != '1') {
        return 'onload="window.print()"';
    }
}

function prk_factor_thankyou_link() {
    if (prk_option('f_thankyou_link') != '1') {
        return 'onload="window.print()"';
    }
}

function prk_getfactor() {
    if (prk_option('f_getfactor') == 1 ) {
        return prk_option('f_getfactor');
    }else {
      return false;
    }
}

function prk_barcode() {
    if (prk_option('f_barcode') == 1 ) {
        return prk_option('f_barcode');
    }else {
      return false;
    }
}

function prk_title() {
    if (prk_option('f_title') == 1 ) {
        return prk_option('f_title');
    }else {
      return false;
    }
}

function prk_Letters() {
    if (prk_option('f_Letters')) {
        return prk_option('f_Letters');
    }
}

////// اتمام ///////

// تنظیمات برچسب
function prk_label_logo() {
    if (prk_option('label_logo')) {
        return prk_option('label_logo');
    }
}

function prk_label_address() {
    if (prk_option('label_address') == 1 ) {
        return prk_option('label_address');
    }else {
      return false;
    }
}

function prk_label_send_order() {
    if (prk_option('label_send_order') == 1 ) {
        return prk_option('label_send_order');
    }else {
      return false;
    }
}

function prk_label_order_number() {
    if (prk_option('label_order_number') == 1 ) {
        return prk_option('label_order_number');
    }else {
      return false;
    }
}

function prk_label_website() {
    if (prk_option('label_website')) {
        return prk_option('label_website');
    }
}

function prk_label_Pmethod() {
    if (prk_option('label_Pmethod')) {
        return prk_option('label_Pmethod');
    }
}

function prk_label_date_print() {
    if (prk_option('label_date_print')) {
        return prk_option('label_date_print');
    }
}

////// اتمام ///////
