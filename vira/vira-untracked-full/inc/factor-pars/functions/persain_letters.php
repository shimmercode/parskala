<?php

 // تبدیل اعداد به حروف فارسی

function prk_persain_letters($money) {
    $one = array('صفر', 'يک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه');
    $ten = array('', 'ده', 'بيست', 'سي', 'چهل', 'پنجاه', 'شصت', 'هفتاد', 'هشتاد', 'نود',);
    $hundred = array('', 'يکصد', 'دويست', 'سيصد', 'چهارصد', 'پانصد', 'ششصد', 'هفتصد', 'هشتصد', 'نهصد',);
    $categories = array('', 'هزار', 'ميليون', 'ميليارد',);
    $exceptions = array('', 'يازده', 'دوازده', 'سيزده', 'چهارده', 'پانزده', 'شانزده', 'هفده', 'هجده', 'نوزده',);

    if (strlen($money) > count($categories) + 10) {
        throw new Exception('number is longger!');
    }
    $letters_separator = ' و ';
    $money = (string)(int)$money;
    $money_len = strlen($money);
    $persian_letters = '';
    for ($i = $money_len - 1;$i >= 0;$i-= 3) {
        $i_one = (int)isset($money[$i]) ? $money[$i] : -1;
        $i_ten = (int)isset($money[$i - 1]) ? $money[$i - 1] : -1;
        $i_hundred = (int)isset($money[$i - 2]) ? $money[$i - 2] : -1;
        $i_thousand = (int)isset($money[$i - 3]) ? $money[$i - 3] : -1;

        $isset_one = false;
        $isset_ten = false;
        $isset_hundred = false;
        $letters = '';

        if ($i_one == 0 && $i_ten < 0 && $i_hundred < 0) {
            $letters = $one[$i_one];
        }

        if (($i >= 0) && $i_one > 0 && $i_ten != 1 && isset($one[$i_one])) {
            $letters = $one[$i_one];
            $isset_one = true;
        }

        if (($i - 1 >= 0) && $i_ten > 0 && isset($ten[$i_ten])) {
            if ($isset_one) {
                $letters = $letters_separator . $letters;
            }
            if ($i_one == 0) {
                $letters = $ten[$i_ten];
            } elseif ($i_ten == 1 && $i_one > 0) {
                $letters = $exceptions[$i_one];
            } else {
                $letters = $ten[$i_ten] . $letters;
            }
            $isset_ten = true;
        }

        if (($i - 2 >= 0) && $i_hundred > 0 && isset($hundred[$i_hundred])) {
            if ($isset_ten || $isset_one) {
                $letters = $letters_separator . $letters;
            }
            $letters = $hundred[$i_hundred] . $letters;
            $isset_hundred = true;
        }
        if ($i_one < 1 && $i_ten < 1 && $i_hundred < 1) {
            $letters = '';
        } else {
            $letters.= ' ' . $categories[($money_len - $i - 1) / 3];
        }
        if (!empty($letters) && $i >= 3) {
            $letters = $letters_separator . $letters;
        }
        $persian_letters = $letters . $persian_letters;
    }
    return $persian_letters;

}

function state_text($state) {

	if ($state == 'TE') {
       $state = 'تهران';
    }
    if ($state == 'THR') {
        $state = 'تهران';
    }
    if ($state == 'KZ') {
        $state = 'خوزستان';
    }
    if ($state == 'KHZ') {
        $state = 'خوزستان';
    }
    if ($state == 'AL') {
        $state = 'البرز';
    }
    if ($state == 'ABZ') {
        $state = 'البرز';
    }
    if ($state == 'Al') {
        $state = 'اردبیل';
    }
    if ($state == 'ADL') {
        $state = 'اردبیل';
    }
    if ($state == 'AE') {
        $state = 'آذربایجان شرقی';
    }
    if ($state == 'EAZ') {
        $state = 'آذربایجان شرقی';
    }
    if ($state == 'AW') {
        $state = 'آذربایجان غربی';
    }
    if ($state == 'WAZ') {
        $state = 'آذربایجان غربی';
    }
    if ($state == 'BU') {
        $state = 'بوشهر';
    }
    if ($state == 'BHR') {
        $state = 'بوشهر';
    }
    if ($state == 'CM') {
        $state = 'چهارمحال و بختیاری';
    }
    if ($state == 'CHB') {
        $state = 'چهارمحال و بختیاری';
    }
    if ($state == 'FA') {
        $state = 'فارس';
    }
    if ($state == 'FRS') {
        $state = 'فارس';
    }
    if ($state == 'GI') {
        $state = 'گیلان';
    }
    if ($state == 'GIL') {
        $state = 'گیلان';
    }
    if ($state == 'GO') {
        $state = 'گلستان';
    }
    if ($state == 'GLS') {
        $state = 'گلستان';
    }
    if ($state == 'HD') {
        $state = 'همدان';
    }
    if ($state == 'HDN') {
        $state = 'همدان';
    }
    if ($state == 'HG') {
        $state = 'هرمزگان';
    }
    if ($state == 'HRZ') {
        $state = 'هرمزگان';
    }
    if ($state == 'IL') {
        $state = 'ایلام';
    }
    if ($state == 'ILM') {
        $state = 'ایلام';
    }
    if ($state == 'IS') {
        $state = 'اصفهان';
    }
    if ($state == 'ESF') {
        $state = 'اصفهان';
    }
    if ($state == 'KE') {
        $state = 'کرمان';
    }
    if ($state == 'KRN') {
        $state = 'کرمان';
    }
    if ($state == 'BK') {
        $state = 'کرمانشاه';
    }
    if ($state == 'KRH') {
        $state = 'کرمانشاه';
    }
    if ($state == 'KS') {
        $state = 'خراسان شمالی';
    }
    if ($state == 'NKH') {
        $state = 'خراسان شمالی';
    }
    if ($state == 'KV') {
        $state = 'خراسان رضوی';
    }
    if ($state == 'RKH') {
        $state = 'خراسان رضوی';
    }
    if ($state == 'KJ') {
        $state = 'خراسان جنوبی';
    }
    if ($state == 'SKH') {
        $state = 'خراسان جنوبی';
    }
    if ($state == 'KB') {
        $state = 'کهگیلویه و بویراحمد';
    }
    if ($state == 'KBD') {
        $state = 'کهگیلویه و بویراحمد';
    }
    if ($state == 'KD') {
        $state = 'کردستان';
    }
    if ($state == 'KRD') {
        $state = 'کردستان';
    }
    if ($state == 'LO') {
        $state = 'لرستان';
    }
    if ($state == 'LRS') {
        $state = 'لرستان';
    }
    if ($state == 'MK') {
        $state = 'مرکزی';
    }
    if ($state == 'MKZ') {
        $state = 'مرکزی';
    }
    if ($state == 'MN') {
        $state = 'مازندران';
    }
    if ($state == 'MZN') {
        $state = 'مازندران';
    }
    if ($state == 'QZ') {
        $state = 'قزوین';
    }
    if ($state == 'GZN') {
        $state = 'قزوین';
    }
    if ($state == 'QM') {
        $state = 'قم';
    }
    if ($state == 'QHM') {
        $state = 'قم';
    }
    if ($state == 'SM') {
        $state = 'سمنان';
    }
    if ($state == 'SMN') {
        $state = 'سمنان';
    }
    if ($state == 'YA') {
        $state = 'یزد';
    }
    if ($state == 'YZD') {
        $state = 'یزد';
    }
    if ($state == 'ZA') {
        $state = 'زنجان';
    }
    if ($state == 'ZJN') {
        $state = 'زنجان';
    }
    if ($state == 'SB') {
        $state = 'سیستان و بلوچستان';
    }
    if ($state == 'SBN') {
        $state = 'سیستان و بلوچستان';
    }
    if ($state == '') {
        $state = 'همه';
    }
	return $state;
}


function status_text($status) {
	if($status == "processing"){
		$status ='<span class="processing">درحال انجام</div>';
	}
	if($status == "on-hold"){
		$status ='<span class="on-hold">درحال بررسی</div>';
	}
	if($status == "pending"){
		$status ='<span class="on-hold">درحال بررسی</div>';
	}
	if($status == "cancelled"){
		$status ='<span class="on-hold">لغو سفارش</div>';
	}
	if($status == "completed"){
		$status ='<span class="completed">تکمیل شده</div>';
	}
	if($status == "post_status"){
		$status ='<span class="post-status">ارسال به پست</div>';
	}
	return $status;
}


// perchecker
function perchecker($checkpersian){

  $rtl_chars_pattern = '/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u';
  return preg_match($rtl_chars_pattern, $checkpersian);

}

// convertPersianToEnglish
function convert_PersianToEnglish($string) {

  $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
  $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

  $output= str_replace($persian, $english, $string);
  return $output;

}
