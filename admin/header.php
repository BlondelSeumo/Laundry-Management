<?php    
$filename =  dirname(dirname(__FILE__)) . '/config.php';
$file = file_exists($filename);
if ($file) {
   if (!filesize($filename) > 0) {
      header('location:../ld_install.php');
   } else {
      include(dirname(dirname(__FILE__)) . "/objects/class_connection.php");
      $cvars = new laundry_myvariable();
      $host = trim($cvars->hostnames);
      $un = trim($cvars->username);
      $ps = trim($cvars->passwords);
      $db = trim($cvars->database);
      $con = new laundry_db();
      $conn = $con->connect();
      if (($conn->connect_errno == '0' && ($host == '' || $db == '')) || $conn->connect_errno != '0') {
         header('Location: ../config_index.php');
      }
   }
} else {
   echo "Config file does not exist";
}
ob_start();
session_start();
include(dirname(dirname(__FILE__)) . '/header.php');
if(!isset($_SESSION['ld_adminid']) && !isset($_SESSION['ld_login_user_id']))
{
    ?>
    <script>
        var loginObj={'site_url':'<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>'};
        var login_url=loginObj.site_url;
        window.location=login_url+"admin/";
    </script>
<?php  
}
include(dirname(dirname(__FILE__)) . '/class_configure.php');
include(dirname(dirname(__FILE__))."/objects/class_dashboard.php");
include(dirname(dirname(__FILE__))."/objects/class_setting.php");
include(dirname(dirname(__FILE__))."/objects/class_general.php");
include(dirname(dirname(__FILE__))."/objects/class_off_days.php");
include(dirname(dirname(__FILE__))."/objects/class_version_update.php");
$cvars = new laundry_myvariable();
$host = trim($cvars->hostnames);
$un = trim($cvars->username);
$ps = trim($cvars->passwords); 
$db = trim($cvars->database);
$con = new laundry_db();
$conn = $con->connect();
if(($conn->connect_errno=='0' && ($host=='' || $db=='')) || $conn->connect_errno!='0' ) {
	header('Location: '.BASE_URL.'/config_index.php');
    exit(0);
}
$objdashboard = new laundry_dashboard();
$objdashboard->conn = $conn;
$general=new laundry_general();
$general->conn=$conn;
$setting = new laundry_setting();
$setting->conn = $conn;
$setting->readAll();
$getdateformat=$setting->get_option('ld_date_picker_date_format');
$gettimeformat=$setting->get_option('ld_time_format');
$offday=new laundry_provider_off_day();
$offday->conn = $conn;
$symbol_position=$setting->get_option('ld_currency_symbol_position');
$cal_amount=$setting->get_option('ld_partial_deposit_amount');
$decimal=$setting->get_option('ld_price_format_decimal_places');
$objcheckversion = new laundry_version_update();
$objcheckversion->conn = $conn;
$current = $setting->get_option('ld_version');
if($current == ""){
  $objcheckversion->insert_option("ld_version","1.0");
}
if($current < 1.1){
  $setting->set_option("ld_version","1.1");
}
if($current < 1.2){
  $setting->set_option("ld_version","1.2");
	$objcheckversion->update1_2();
}
if($current < 1.3){
  $setting->set_option("ld_version","1.3");
	$objcheckversion->update1_3();
}  
if($current < 1.4){
  $setting->set_option("ld_version","1.4");
	$objcheckversion->update1_4();
}  
if ($current < 2.0) {
	$settings->set_option("ld_version", "2.0");
	$objcheckversion->update2_0();
}
$lang = $setting->get_option("ld_language");
$label_language_values = array();
$language_label_arr = $setting->get_all_labelsbyid($lang);
if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "" || $language_label_arr[6] != "")
{
	$default_language_arr = $setting->get_all_labelsbyid("en");
	if($language_label_arr[1] != ''){
		$label_decode_front = base64_decode($language_label_arr[1]);
	}else{
		$label_decode_front = base64_decode($default_language_arr[1]);
	}
	if($language_label_arr[3] != ''){
		$label_decode_admin = base64_decode($language_label_arr[3]);
	}else{
		$label_decode_admin = base64_decode($default_language_arr[3]);
	}
	if($language_label_arr[4] != ''){
		$label_decode_error = base64_decode($language_label_arr[4]);
	}else{
		$label_decode_error = base64_decode($default_language_arr[4]);
	}
	if($language_label_arr[5] != ''){
		$label_decode_extra = base64_decode($language_label_arr[5]);
	}else{
		$label_decode_extra = base64_decode($default_language_arr[5]);
	}
	if($language_label_arr[6] != ''){
		$label_decode_front_form_errors = base64_decode($language_label_arr[6]);
	}else{
		$label_decode_front_form_errors = base64_decode($default_language_arr[6]);
	}
	
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
	$label_decode_front_form_errors_unserial = unserialize($label_decode_front_form_errors);
    
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial,$label_decode_front_form_errors_unserial);
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}
else
{
    $default_language_arr = $setting->get_all_labelsbyid("en");
    
    $label_decode_front = base64_decode($default_language_arr[1]);
	$label_decode_admin = base64_decode($default_language_arr[3]);
	$label_decode_error = base64_decode($default_language_arr[4]);
	$label_decode_extra = base64_decode($default_language_arr[5]);
	$label_decode_front_form_errors = base64_decode($default_language_arr[6]);
	
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
	$label_decode_front_form_errors_unserial = unserialize($label_decode_front_form_errors);
    
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial,$label_decode_front_form_errors_unserial);
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}

?>
<!Doctype html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="shortcut icon" type="image/png" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/backgrounds/<?php echo filter_var($setting->get_option('ld_favicon_image'));	?>"/>
    <title><?php echo filter_var($setting->get_option("ld_page_title")); ?> |
        <?php  
            if(strpos($_SERVER['SCRIPT_NAME'],'my-appointments.php')!=false)
            {
                echo filter_var('My Appointments');
            }
            else if(strpos($_SERVER['SCRIPT_NAME'],'user-profile.php')!=false)
            {
                echo filter_var('Profile');
            }
            else
            {
                echo filter_var("Admin");
            }
        ?>
</title>
    <meta name="description" content="" />
    <meta name="author" content="" />
	
	
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/ld-main.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/ld-common.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/tooltipster.bundle.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/tooltipster-sideTip-shadow.min.css" type="text/css" media="all" />
	<?php   
	if(in_array($lang,array('ary','ar','azb','fa_IR','haz'))){ ?>	
	
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/lda-front-rtl.css" type="text/css" media="all" />
	
	<?php   } ?>
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/jquery_editor/jquery-te-1.4.0.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/ld-responsive.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/ld-manual-booking.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/ld-reset.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/jquery-ui.theme.min.css" type="text/css" media="all" />
	
	<style>
        .error {
            color: red;
        }
    </style>
	<style>#ld .not-scroll-custom{ margin-top: 0 !important; }</style>
	
	
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/lda-reset.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/lda-admin-style.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/lda-admin-common.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/lda-admin-responsive.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/bootstrap/bootstrap.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/daterangepicker.css" type="text/css" media="all">
	
	<?php   
	if(in_array($lang,array('ary','ar','azb','fa_IR','haz'))){ ?>	
	
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/bootstrap/bootstrap-rtl.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/lda-admin-rtl.css" type="text/css" media="all">
	<?php   } ?>
     
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/fullcalendar.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/jquery.Jcrop.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/intlTelInput.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/bootstrap/bootstrap-theme.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/bootstrap-toggle.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/bootstrap-select.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/jquery.minicolors.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/jquery.dataTables.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/responsive.dataTables.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/dataTables.bootstrap.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/buttons.dataTables.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/jquery-ui.min.css" type="text/css" media="all">
		<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/star_rating.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/font-awesome/css/font-awesome.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/line-icons/simple-line-icons.css" type="text/css" media="all">
		<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/fonts/Open_Sans/stylesheet.css" type="text/css" media="all">
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/jquery-2.1.4.min.js" type="text/javascript"></script>
	  <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/bootstrap-multiselect.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/jquery-ui.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/moment.min.js" type="text/javascript" ></script>   
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/jquery.Jcrop.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/jquery.color.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/fullcalendar.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/lang-all.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/intlTelInput.js" type="text/javascript" ></script>
	  <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/jquery.nicescroll.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/bootstrap.min.js" type="text/javascript" ></script>
	  <?php   if(strpos($_SERVER['SCRIPT_NAME'],'service-extra-addons.php')==false && strpos($_SERVER['SCRIPT_NAME'],'service-manage-unit-price.php')==false && strpos($_SERVER['SCRIPT_NAME'],'service-manage-calculation-methods.php')==false ){ ?>	
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/bootstrap-toggle.min.js" type="text/javascript" ></script>
	  <?php   } ?>
	  <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/vue.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/bootstrap-select.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/daterangepicker.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/Chart.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/jquery.minicolors.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/datatable/jquery.dataTables.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/datatable/dataTables.responsive.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/datatable/dataTables.bootstrap.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/datatable/dataTables.buttons.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/datatable/jszip.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/datatable/pdfmake.min.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/datatable/vfs_fonts.js" type="text/javascript" ></script>
    <script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/datatable/buttons.html5.min.js" type="text/javascript" ></script>
		<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/star_rating_min.js" type="text/javascript"></script>
		<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/jquery.validate.min.js"></script>
	<?php   
	include(dirname(dirname(__FILE__)) . "/objects/class_payment_hook.php");
	$payment_hook = new laundry_paymentHook();
	$payment_hook->conn = $conn;
	$payment_hook->payment_extenstions_exist();
	$purchase_check = $payment_hook->payment_purchase_status();
	include(dirname(dirname(__FILE__)) . "/extension/ld-common-extension-js.php");
	?>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/ld-common-admin-jquery.js?<?php    echo time(); ?>" type="text/javascript"></script>
	<?php  
    echo "<style>
	
	#lda #lda-main-navigation .navbar-inverse{
		background:".$setting->get_option('ld_primary_color_admin')." !important;
	}
	#lda #lda-main-navigation .navbar .nav.lda-nav-tab > .active > a,
	#lda #lda-main-navigation .navbar .nav.user-nav-bar > .active > a,
	#lda #lda-top-nav .navbar .nav > .active > a:focus{
		background-color: ".$setting->get_option('ld_secondary_color_admin')." ;
		color: ".$setting->get_option('ld_text_color_admin')."  ;
	}
	#lda #lda-main-navigation .navbar .nav.lda-nav-tab > li > a:hover,
	#lda #lda-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
		background-color: ".$setting->get_option('ld_secondary_color_admin')." ;
		color: ".$setting->get_option('ld_text_color_admin')."  ;
	}
	#lda #lda-main-navigation .navbar .nav.lda-nav-tab > li > a,
	#lda #lda-main-navigation .navbar .nav.user-nav-bar > li > a{
		color: ".$setting->get_option('ld_text_color_admin')."  ;
	}
	#lda .noti_color{
		color: ".$setting->get_option('ld_text_color_admin')." !important ;
	}
	#lda a#ld-notifications i.icon-bell.lda-new-booking{
		color: ".$setting->get_option('ld_secondary_color_admin')." !important ;
	}
	
	#lda a.ld-tooltip-link{
		color: ".$setting->get_option('ld_primary_color_admin')." !important ;
	}
	.navbar-inverse .navbar-nav>.open>a, .navbar-inverse .navbar-nav>.open>a:focus,
	.navbar-inverse .navbar-nav>.open>a:hover{
		background-color: ".$setting->get_option('ld_secondary_color_admin')." !important  ;
	}
	#lda #lda-staff-panel .ld-staff-right-details .member-offdays .ld-custom-checkbox  ul.ld-checkbox-list label span,
	#lda .ld-custom-radio ul.ld-radio-list label span{
		border-color: ".$setting->get_option('ld_primary_color_admin')." !important;
	}
	#lda #lda-staff-panel .ld-staff-right-details .member-offdays .ld-custom-checkbox  	ul.ld-checkbox-list input[type='checkbox']:checked + label span{
		border-color: ".$setting->get_option('ld_secondary_color_admin')." !important;
		background-color: ".$setting->get_option('ld_secondary_color_admin')." !important;
	}
	#lda .ld-custom-radio ul.ld-radio-list input[type='radio']:checked + label span{
		border-color: ".$setting->get_option('ld_secondary_color_admin')." !important;
	}
	#lda ul li.service_set_session.active{
		border: 2px solid ".$setting->get_option('ld_secondary_color_admin')." !important;
	}
	#lda .fc-toolbar {
		background-color: ".$setting->get_option('ld_primary_color_admin')." !important;
	}
	#lda .ld-notification-main .notification-header{
		color: ".$setting->get_option('ld_text_color_admin')." !important;
		background-color: ".$setting->get_option('ld_secondary_color_admin')." !important;
	}
	
	#lda .fc-toolbar {
		border-top: 1px solid ".$setting->get_option('ld_primary_color_admin')." !important;
		border-left: 1px solid ".$setting->get_option('ld_primary_color_admin')." !important;
		border-right: 1px solid ".$setting->get_option('ld_primary_color_admin')." !important;
	}
	#lda .fc button,
	#lda .ld-notification-main .notification-header #ld-close-notifications{
		color: ".$setting->get_option('ld_text_color_admin')." !important ;
	}
	#lda .ld-notification-main .notification-header #ld-close-notifications:hover{
		background-color: ".$setting->get_option('ld_primary_color_admin')." !important;
	}
	#lda .fc button:hover{
		color: ".$setting->get_option('ld_secondary_color_admin')." !important ;
	}
	
	
	/* iPads (portrait and landscape) ----------- */
	@media only screen and (min-width : 768px) and (max-width : 1024px) {
		#lda #lda-main-navigation .navbar-header,
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > li > a:hover,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			color: ".$setting->get_option('ld_secondary_color_admin')."  ;
		}
		
	}
	/* iPads (landscape) ----------- */
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) {
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > li > a:hover,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			background-color: ".$setting->get_option('ld_secondary_color_admin')." ;
			color: ".$setting->get_option('ld_text_color_admin')."  ;
		}
	
	}
	/* iPads (portrait) ----------- */
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : portrait) {
		#lda #lda-top-nav .navbar-header,
		#lda #lda-main-navigation .navbar-header,
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > .active > a,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#lda #lda-top-nav .navbar .nav > .active > a:focus,
		#lda #lda-top-nav .navbar-nav > li > a:hover,
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > li > a:hover,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			color: ".$setting->get_option('ld_secondary_color_admin')."  ;
		}
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > .active > a,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#lda #lda-top-nav .navbar .nav > .active > a:focus{
			background: unset !important;
		}
	}	
	/********** iPad 3 **********/
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) and (-webkit-min-device-pixel-ratio : 2) {
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > li > a:hover,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			background-color: ".$setting->get_option('ld_secondary_color_admin')." ;
			color: ".$setting->get_option('ld_text_color_admin')."  ;
		}
	}
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : portrait) and (-webkit-min-device-pixel-ratio : 2) {	
		#lda #lda-top-nav .navbar-header,
		#lda #lda-main-navigation .navbar-header,
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > .active > a,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#lda #lda-top-nav .navbar .nav > .active > a:focus,
		#lda #lda-top-nav .navbar-nav > li > a:hover,
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > li > a:hover,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			color: ".$setting->get_option('ld_secondary_color_admin')."  ;
		}
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > .active > a,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#lda #lda-top-nav .navbar .nav > .active > a:focus{
			background: unset !important;
		}
	}
	/* Smartphones (landscape) ----------- */
	@media only screen and (max-width: 767px) {
		#lda #lda-top-nav .navbar-header,
		#lda #lda-main-navigation .navbar-header,
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > .active > a,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#lda #lda-top-nav .navbar .nav > .active > a:focus,
		#lda #lda-top-nav .navbar-nav > li > a:hover,
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > li > a:hover,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			color: ".$setting->get_option('ld_secondary_color_admin')."  ;
		}
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > .active > a,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#lda #lda-top-nav .navbar .nav > .active > a:focus{
			background: unset !important;
		}
		
	}	
	/* Smartphones (portrait and landscape) ----------- */
	@media only screen and (min-width : 320px) and (max-width : 480px) {
		
		#lda #lda-top-nav .navbar-header,
		#lda #lda-main-navigation .navbar-header,
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > .active > a,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#lda #lda-top-nav .navbar .nav > .active > a:focus,
		#lda #lda-top-nav .navbar-nav > li > a:hover,
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > li > a:hover,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			color: ".$setting->get_option('ld_secondary_color_admin')."  ;
		}
		#lda #lda-main-navigation .navbar .nav.lda-nav-tab > .active > a,
		#lda #lda-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#lda #lda-top-nav .navbar .nav > .active > a:focus{
			background: unset !important;
		}
	}
</style>
";
    ?>
</head>
<body>
<div id="rtl-width-setter-enable" style="display:none;"><?php echo filter_var($label_language_values['enable']);	?></div>
<div id="rtl-width-setter-disable" style="display:none;"><?php echo filter_var($label_language_values['disable']);	?></div>
<div id="rtl-width-setter-on" style="display:none;"><?php echo filter_var($label_language_values['o_n']);	?></div>
<div id="rtl-width-setter-off" style="display:none;"><?php echo filter_var($label_language_values['off']);	?></div> 
<div class="ld-wrapper"  id="lda"> 
    
	<?php   if($setting->get_option("ld_loader")== 'css' && $setting->get_option("ld_custom_css_loader") != ''){ ?>
		<div class="ld-loading-main" align="center">
			<?php   echo filter_var($setting->get_option("ld_custom_css_loader")); ?>
		</div>
	<?php   }elseif($setting->get_option("ld_loader")== 'gif' && $setting->get_option("ld_custom_gif_loader") != ''){ ?>
		<div class="ld-loading-main" align="center">
			<img style="margin-top:18%;" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/gif-loader/<?php echo filter_var($setting->get_option("ld_custom_gif_loader"), FILTER_VALIDATE_URL); ?>"></img>
		</div>
	<?php   }else{ ?>
		<div class="ld-loading-main">
			<div class="loader">Loading...</div>
		</div>
	<?php   } ?>	
    <header class="ld-header">
        <?php  
        if(isset($_SESSION['ld_adminid']))
        {
        ?>
		<div id="lda-top-nav" class="navbar-inner">
            <nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
                
				<div class="container">
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapsetop" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-cog"></i>
                    </button>
                    <a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>" class="navbar-brand"><?php echo filter_var($setting->get_option('ld_company_name'));	?></a>
                </div>
                
                <div id="navbarCollapsetop" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li><a  href="<?php echo BASE_URL; ?>/admin/laundry-welcome.php"><span><?php echo $label_language_values['whats_new'];?></span></a></li>
						<?php   
						/*** auto updater code  ***/
						$version_updated_checker = $setting->get_contents('http://skymoonlabs.com/laundry/versioncheck.php?'.time());
						if($version_updated_checker > $setting->get_option("ld_version")){
						?>
						<li><a href="#ld-update-version-modal" class="pulse-update" title="Laundry Update Available"  data-toggle="modal"><i class="fa fa-download"></i></a></li>
						<?php   } /*** auto updater code  ***/?>
						<li><a href="#ld-buy-support-modal" class="pulse-update" title="Laundry Support" data-toggle="modal"><i class="fa fa-ticket"></i> Support</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						 <li>
                           <a id="ld-notifications" href="javascript:void(0);">
                               <?php                                    
								$t = @mysqli_num_rows($objdashboard->getallbookingsunread_count()); ?>
								<i class="icon-bell <?php    if ($t != 0) { ?> lda-new-booking <?php   } ?>"></i>
								 <?php                                    
									
                                    if ($t != 0) {
                                        ?>
                                        <span class="total_notification noti_color" id="ld-notification-top"><?php
                                            $t = mysqli_num_rows($objdashboard->getallbookingsunread_count());
                                            if ($t != 0) {
                                                echo mysqli_num_rows($objdashboard->getallbookingsunread_count());
                                            }
                                            ?>
										</span>
                                    <?php  
                                    }else{
										?>
										<span class="total_notification noti_color" id="ld-notification-top"></span>
										<?php  
									}
                                    ?>
                                <i class="fa fa-angle-down"></i>
                            </a>
                           
                        </li>
						<li><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL) . "admin/admin-profile.php" ?>"><i class="fa fa-user"></i><span><?php echo filter_var($label_language_values['profile']);	?></span></a></li>
						<li><a id="logout" href="javascript:void(0)"><i class="fa fa-power-off"></i><span><?php echo filter_var($label_language_values['logout']);	?></span></a></li>
						
                    </ul>
                </div>
				</div>
            </nav>
        </div>
		
		<div class="ld-overlay-notification"></div>
		<div id="ld-notification-container">
			<div class="ld-notifications-inner">
				<div class="ld-notification-main">
					<div class="ld-notification-main">
						<h4 class="notification-header"><?php echo filter_var($label_language_values['booking_notifications']);	?>
							<a id="ld-close-notifications" class="pull-right"
							   href="javascript:void(0);" title="<?php echo filter_var($label_language_values['close_notifications']);	?>"><i>×</i></a></h4>
						<div class="ld-recent-booking-container">
							<ul class="ld-recent-booking-list myloadednotification">
								<div class="ld-load-bar">
									  <div class="ld-bar"></div>
									  <div class="ld-bar"></div>
									  <div class="ld-bar"></div>
								</div>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
			
	    <?php   }?>
	
		 <?php  
			if(isset($_SESSION['ld_adminid'])) {
				?>
        <div id="lda-main-navigation" class="navbar-inner">
            <nav role="navigation" class="navbar navbar-inverse navbar-fixed-top lda-admin-nav">
			<div class="container">
                
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapseMain" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars"></i>
                    </button>
					<a href="javascript:void(0);" class="navbar-brand">Menu</a> 
                </div>
                
                <div id="navbarCollapseMain" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav lda-nav-tab">
                        <li class="<?php if (strpos($_SERVER['SCRIPT_NAME'], 'calendar.php') != false) {
                            echo filter_var('active');
                        } ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/calendar.php"><i class="fa fa-calendar"></i><span><?php echo filter_var($label_language_values['appointments']);	?></span></a>
                        </li>
						 <li class="<?php if (strpos($_SERVER['SCRIPT_NAME'], 'pos.php') != false) {
                            echo filter_var('active');
                        } ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/pos.php"><i class="fa fa-calendar-plus-o"></i><span><?php echo "POS";	?></span></a> 
                        </li>
                        <li class="<?php if (strpos($_SERVER['SCRIPT_NAME'], 'services.php') != false) {
                            echo filter_var('active');
                        } ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/services.php"><i class="fa fa-tasks"></i><span><?php echo filter_var($label_language_values['services']);	?></span> </a></li>
												
												<li class="<?php if (strpos($_SERVER['SCRIPT_NAME'], 'service-manage-unit-price.php') != false) {
                            echo filter_var('active');
                        } ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/service-manage-unit-price.php"><i class="fa fa-puzzle-piece"></i><span><?php echo filter_var($label_language_values['articles']); ?></span> </a></li>
												
                        <li class="<?php if (strpos($_SERVER['SCRIPT_NAME'], 'schedule.php') != false) {
                            echo filter_var('active');
                        } ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/schedule.php"><i class="fa fa-clock-o"></i><span><?php echo filter_var($label_language_values['schedule']);	?></span></a>
                        </li>
												<li class="<?php if (strpos($_SERVER['SCRIPT_NAME'], 'staff.php') != false) {
                            echo filter_var('active');
                        } ?>"><a class="staff_link_clicked" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/staff.php"><i class="fa fa-user-circle-o"></i><span> <?php   echo filter_var($label_language_values['staff']);	?></span></a>
                        </li>
                        
						<li class="<?php if (strpos($_SERVER['SCRIPT_NAME'], 'crmn.php') != false) {
                            echo filter_var('active');
                        }if (strpos($_SERVER['SCRIPT_NAME'], 'emlsms.php') != false) {
                            echo filter_var('active');
                        } ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/crmn.php"><i class="fa fa-users"></i><span><?php echo  $label_language_values['crm'];	?></span></a></li>
                        <li class="<?php if (strpos($_SERVER['SCRIPT_NAME'], 'payments.php') != false) {
                            echo filter_var('active');
                        } ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/payments.php"><i class="fa fa-money"></i> <span><?php echo filter_var($label_language_values['payments']);	?></span></a>
                        </li>
                        <li class="<?php if (strpos($_SERVER['SCRIPT_NAME'], 'settings.php') != false) {
                            echo filter_var('active');
                        } ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/settings.php"><i class="fa fa-cog"></i><span><?php echo filter_var($label_language_values['settings']);	?></span></a>
                        </li>
                        <li class="<?php if (strpos($_SERVER['SCRIPT_NAME'], 'export.php') != false) {
                            echo filter_var('active');
                        } ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/export.php"><i class="fa fa-file-pdf-o"></i> <span><?php echo filter_var($label_language_values['export']);	?></span></a>
                        </li>
						<li class="<?php if (strpos($_SERVER['SCRIPT_NAME'], 'embedcode.php') != false) {
                            echo filter_var('active');
                        } ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/embedcode.php"><i class="fa fa-square-o"></i> <span><?php echo filter_var($label_language_values['embed_code']);	?></span></a>
                        </li>
						
						 <?php   
						if($setting->get_option('ld_sample_data_status') == 'N'){
                        ?>
                            <li class=""><a href="javascript:void(0);" id="ld-sample-data"><i class="fa fa-download"></i><span><?php echo filter_var($label_language_values['add_sample_data']);	?></span></a>
                            </li>
                        <?php  
                       }else if($setting->get_option('ld_sample_data_status') == 'Y'){
                            ?>
                            <li class=""><a href="javascript:void(0);" id="ld-remove-sample-data"><i class="fa fa-eraser"></i><span><?php echo filter_var($label_language_values['remove_sample_data']);	?></span></a>
                            </li>
                            <?php  
                        }
                        ?>
						
						
                    </ul>
					</div>
				</div>
            </nav>
        </div>
		
		<?php  
		}else{
			?>
			
		<div id="lda-main-navigation" class="navbar-inner">
            <nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
                
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapseMain" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars"></i>
                    </button>
					<a href="javascript:void(0);" class="navbar-brand">Menu</a> 
                </div>
                
                <div id="navbarCollapseMain" class="collapse navbar-collapse">
					<ul class="nav navbar-nav user-nav-bar">
                        <li class="<?php if(strpos($_SERVER['SCRIPT_NAME'],'my-appointments.php')!=false){ echo filter_var('active');} ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/my-appointments.php"><i class="fa fa-calendar"></i><span><?php echo filter_var($label_language_values['my_appointments']);	?></span></a></li>
                        <li class="<?php if(strpos($_SERVER['SCRIPT_NAME'],'user-profile.php')!=false){ echo filter_var('active');} ?>"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/user-profile.php"><i class="fa fa-user"></i><span><?php echo filter_var($label_language_values['profile']);	?></span></a></li>
                        <li><a id="logout" data-id="user"  href="javascript:void(0)"><i class="fa fa-power-off"></i><span><?php echo filter_var($label_language_values['logout']);	?></span></a></li>
                    </ul>
                </div>
				</div>
            </nav>
        </div>
         <?php  	 }	 ?>
        <div id="booking-details-dashboard" class="modal fade booking-details-index-dashboard" tabindex="-1" role="dialog" aria-hidden="true">
        </div>
		<div class="modal fade" id="myModal_reschedual" role="dialog"></div>
    </header>
    <?php  
    include(dirname(__FILE__)."/language_js_objects.php");
   ?>
	
    <script type="text/javascript">
		var ajax_url = '<?php echo filter_var(AJAX_URL, FILTER_VALIDATE_URL);	?>';
		var base_url = '<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>';
		var times={'time_format_values':"<?php echo filter_var($gettimeformat);	?>"};
		var language_new ={'selected_language':"<?php echo substr($lang, strpos($lang,chr(0)), strpos($lang, "chr(_)")); ;	?>"};
		var titles ={
			'selected_today':"<?php echo filter_var($label_language_values['calendar_today']);	?>",
			'selected_month':"<?php echo filter_var($label_language_values['calendar_month']);	?>",
			'selected_week':"<?php echo filter_var($label_language_values['calendar_week']);	?>",
			'selected_day':"<?php echo filter_var($label_language_values['calendar_day']);	?>"};
		var site_ur = {'site_url':"<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>"};
		<?php  
  $nacode = explode(',',$setting->get_option("ld_company_country_code"));
  $allowed = $setting->get_option("ld_phone_display_country_code");
	?>
  var ld_calendar_defaultView = '<?php if($setting->get_option("ld_calendar_defaultView") != ''){ echo filter_var($setting->get_option("ld_calendar_defaultView")); }else{ echo filter_var('month'); } ?>';
  var ld_calendar_firstDay = '<?php if($setting->get_option("ld_calendar_firstDay") != ''){ echo filter_var($setting->get_option("ld_calendar_firstDay")); }else{ echo filter_var('1'); } ?>';
  var countrycodeObj = {'numbercode': '<?php echo filter_var($nacode[0]);	?>', 'alphacode': '<?php echo filter_var($nacode[1]);	?>', 'countrytitle': '<?php echo filter_var($nacode[2]);	?>', 'allowed': '<?php echo filter_var($allowed);	?>'};
  var month = {
	'january' : '<?php echo ucfirst(strtolower($label_language_values['january']));	?>',
	'feb' : '<?php echo ucfirst(strtolower($label_language_values['february']));	?>',
	'mar' : '<?php echo ucfirst(strtolower($label_language_values['march']));	?>',
	'apr' : '<?php echo ucfirst(strtolower($label_language_values['april']));	?>',
	'may' : '<?php echo ucfirst(strtolower($label_language_values['may']));	?>',
	'jun' : '<?php echo ucfirst(strtolower($label_language_values['june']));	?>',
	'jul' : '<?php echo ucfirst(strtolower($label_language_values['july']));	?>',
	'aug' : '<?php echo ucfirst(strtolower($label_language_values['august']));	?>',
	'sep' : '<?php echo ucfirst(strtolower($label_language_values['september']));	?>',
	'oct' : '<?php echo ucfirst(strtolower($label_language_values['october']));	?>',
	'nov' : '<?php echo ucfirst(strtolower($label_language_values['november']));	?>',
	'dec' : '<?php echo ucfirst(strtolower($label_language_values['december']));	?>'};
	var days_date = {
	'sun':'<?php echo ucfirst($label_language_values['su']);	?>',
	'mon':'<?php echo ucfirst($label_language_values['mo']);	?>',
	'tue':'<?php echo ucfirst($label_language_values['tu']);	?>',
	'wed':'<?php echo ucfirst($label_language_values['we']);	?>',
	'thu':'<?php echo ucfirst($label_language_values['th']);	?>',
	'fri':'<?php echo ucfirst($label_language_values['fr']);	?>',
	'sat':'<?php echo ucfirst($label_language_values['sa']);	?>'};
	</script>
	
    <div class="ld-alert-msg-show-main mainheader_message">
        <div class="ld-all-alert-messags alert alert-success mainheader_message_inner">
            
        <strong><?php echo filter_var($label_language_values['success'])." ";	?></strong><span id="ld_sucess_message"> </span>
        </div>
    </div>
    <div class="ld-alert-msg-show-main mainheader_message_fail">
        <div class="ld-all-alert-messags alert alert-danger mainheader_message_inner_fail">
            
            <strong><?php echo filter_var($label_language_values['failed'])." ";	?></strong> <span id="ld_sucess_message_fail"></span>
        </div>
    </div>
	<div id="ld-remove-sample-data-popup" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		
		<div class="modal-content" style="margin-top: 180px;">
		  <div class="modal-body">
			<h4><?php echo filter_var($label_language_values['remove_sample_data_message']);	?></h4>
		  </div>
		  <div class="modal-footer">
			<button id="ld-remove-sample-data-ok" class="btn btn-success" data-dismiss="modal"><?php echo filter_var($label_language_values['ok_remove_sample_data']);	?></button>
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo filter_var($label_language_values['cancel']);	?></button>
		  </div>
		</div>
	  </div>
	</div>
	<?php   
	$english_date_array = array(
"January","Jan","February","Feb","March","Mar","April","Apr","May","June","Jun","July","Jul","August","Aug","September","Sep","October","Oct","November","Nov","December","Dec","Sun","Mon","Tue","Wed","Thu","Fri","Sat","su","mo","tu","we","th","fr","sa","AM","PM");
	$selected_lang_label = array(
ucfirst(strtolower($label_language_values['january'])),
ucfirst(strtolower($label_language_values['jan'])),
ucfirst(strtolower($label_language_values['february'])),
ucfirst(strtolower($label_language_values['feb'])),
ucfirst(strtolower($label_language_values['march'])),
ucfirst(strtolower($label_language_values['mar'])),
ucfirst(strtolower($label_language_values['april'])),
ucfirst(strtolower($label_language_values['apr'])),
ucfirst(strtolower($label_language_values['may'])),
ucfirst(strtolower($label_language_values['june'])),
ucfirst(strtolower($label_language_values['jun'])),
ucfirst(strtolower($label_language_values['july'])),
ucfirst(strtolower($label_language_values['jul'])),
ucfirst(strtolower($label_language_values['august'])),
ucfirst(strtolower($label_language_values['aug'])),
ucfirst(strtolower($label_language_values['september'])),
ucfirst(strtolower($label_language_values['sep'])),
ucfirst(strtolower($label_language_values['october'])),
ucfirst(strtolower($label_language_values['oct'])),
ucfirst(strtolower($label_language_values['november'])),
ucfirst(strtolower($label_language_values['nov'])),
ucfirst(strtolower($label_language_values['december'])),
ucfirst(strtolower($label_language_values['dec'])),
ucfirst(strtolower($label_language_values['sun'])),
ucfirst(strtolower($label_language_values['mon'])),
ucfirst(strtolower($label_language_values['tue'])),
ucfirst(strtolower($label_language_values['wed'])),
ucfirst(strtolower($label_language_values['thu'])),
ucfirst(strtolower($label_language_values['fri'])),
ucfirst(strtolower($label_language_values['sat'])),
ucfirst(strtolower($label_language_values['su'])),
ucfirst(strtolower($label_language_values['mo'])),
ucfirst(strtolower($label_language_values['tu'])),
ucfirst(strtolower($label_language_values['we'])),
ucfirst(strtolower($label_language_values['th'])),
ucfirst(strtolower($label_language_values['fr'])),
ucfirst(strtolower($label_language_values['sa'])),
strtoupper($label_language_values['am']),
strtoupper($label_language_values['pm']));

echo $setting->get_contents('http://skymoonlabs.com/laundry/supportpopup.php?'.time());
echo $setting->get_contents('http://skymoonlabs.com/laundry/versiondetailpopup.php?'.time());
?>