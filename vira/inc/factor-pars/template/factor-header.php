<html lang="fa" dir="rtl" ng-app="app">

<head>

	<meta http-equiv="Content-Type" content="text/html;">
  <meta charset="UTF-8">

	<?php

	 if ($taypes == 'print_label') {

		 echo '<title>چاپ برچسب</title>';
	 }
   if ($taypes == 'print_bill') {

    	echo '<title>چاپ فاکتور</title>';
   }

	?>


	<link href="<?php echo get_template_directory_uri(); ?>/assets/css/lunches/prk-factor.css" rel="stylesheet" media="screen,print" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
  <link rel="stylesheet" href="<?php bloginfo('template_url');?>/fonts/iransans/irsans-config.css" type="text/css">
  <link rel="stylesheet" href="<?php bloginfo('template_url');?>/assets/fonts/ri-fonts/remixicon.css" type="text/css">
  <script src="<?php echo get_template_directory_uri(); ?>/assets/js/fct/jquery-1.11.2.min.js"></script>
  <script src='<?php echo get_template_directory_uri(); ?>/assets/js/fct/nprogress.js'></script>
  <script src="<?php echo get_template_directory_uri(); ?>/assets/js/fct/prk_factor.js"></script>
</head>



<body style="display: none;">
