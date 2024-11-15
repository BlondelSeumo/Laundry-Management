<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$filename =  './config.php';
$file = file_exists($filename);
if($file){
  if(!filesize($filename) > 0){
    header('location:ld_install.php');
  }
  else{
    include(dirname(__FILE__) . "/objects/class_connection.php");
    $cvars = new laundry_myvariable();
    $host = trim($cvars->hostnames);
    $un = trim($cvars->username);
    $ps = trim($cvars->passwords); 
    $db = trim($cvars->database);

    $con = new laundry_db();
    $conn = $con->connect();
    
    if(($conn->connect_errno=='0' && ($host=='' || $db=='')) || $conn->connect_errno!='0' ) {
      header('Location: ./config_index.php');
    }
  }
}else{
  echo "Config file does not exist";
}

session_start();
$_SESSION['ld_cart'] = array();
$_SESSION['ld_details'] = '';
$_SESSION['staff_id_cal'] = '';
$_SESSION['service_id'] = '';
$_SESSION['single_service_id'] = '';
$_SESSION['selected_pickup_date'] = '';
$_SESSION['selected_pickup_time'] = '';
$_SESSION['selected_delivery_dates'] = '';
$_SESSION['selected_delivery_time'] = '';



include(dirname(__FILE__) . '/class_configure.php');
include(dirname(__FILE__) . "/header.php");
include(dirname(__FILE__) . "/objects/class_services.php");
include(dirname(__FILE__) . "/objects/class_users.php");
include(dirname(__FILE__) . '/objects/class_setting.php');
include(dirname(__FILE__) . "/objects/class_version_update.php");
include(dirname(__FILE__) . "/objects/class_payment_hook.php");
include(dirname(__FILE__) . "/objects/class_promo_code.php");
include(dirname(__FILE__) . "/objects/class_front_first_step.php");

$cvars = new laundry_myvariable();
$host = trim($cvars->hostnames);
$un = trim($cvars->username);
$ps = trim($cvars->passwords);
$db = trim($cvars->database);

$con = @new laundry_db();
$conn = $con->connect();

if (($conn->connect_errno == '0' && ($host == '' || $db == '')) || $conn->connect_errno != '0') {
	header('Location: ' . BASE_URL . '/config_index.php');
	exit(0);
}

$check_existing_tables_index = $con->check_existing_tables_index($conn);
if ($check_existing_tables_index == 'table_not_exist' || $check_existing_tables_index == 'table_exist_but_no_data') {
?>
	<script type="text/javascript">
		var AdminloginCredentialObj = {
			'site_url': '<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>'
		};
		var AdminloginCredential_url = AdminloginCredentialObj.site_url;
		window.location = AdminloginCredential_url + "config_index.php";
	</script>
<?php
}

$promo = new laundry_promo_code();
$promo->conn = $conn;

$first_step = new laundry_first_step();
$first_step->conn = $conn;

/*
Language
*/
$language_names = array(
	"en" => urlencode("English (United States)"),
	"ary" => urlencode("العربية المغربية"),
	"ar" => urlencode("العربية"),
	"az" => urlencode("Azərbaycan dili"),
	"azb" => urlencode("گؤنئی آذربایجان"),
	"bg_BG" => urlencode("Български"),
	"bn_BD" => urlencode("বাংলা"),
	"bs_BA" => urlencode("Bosanski"),
	"ca" => urlencode("Català"),
	"ceb" => urlencode("Cebuano"),
	"cs_CZ" => urlencode("Čeština‎"),
	"cy" => urlencode("Cymraeg"),
	"da_DK" => urlencode("Dansk"),
	"de_CH_informal" => urlencode("Deutsch (Schweiz, Du)"),
	"de_DE_formal" => urlencode("Deutsch (Sie)"),
	"de_DE" => urlencode("Deutsch"),
	"de_CH" => urlencode("Deutsch (Schweiz)"),
	"el" => urlencode("Ελληνικά"),
	"en_CA" => urlencode("English (Canada)"),
	"en_GB" => urlencode("English (UK)"),
	"en_NZ" => urlencode("English (New Zealand)"),
	"en_ZA" => urlencode("English (South Africa)"),
	"en_AU" => urlencode("English (Australia)"),
	"eo" => urlencode("Esperanto"),
	"es_ES" => urlencode("Español"),
	"et" => urlencode("Eesti"),
	"eu" => urlencode("Euskara"),
	"fa_IR" => urlencode("فارسی"),
	"fi" => urlencode("Suomi"),
	"fr_FR" => urlencode("Français"),
	"gd" => urlencode("Gàidhlig"),
	"gl_ES" => urlencode("Galego"),
	"gu" => urlencode("ગુજરાતી"),
	"haz" => urlencode("هزاره گی"),
	"hi_IN" => urlencode("हिन्दी"),
	"hr" => urlencode("Hrvatski"),
	"hu_HU" => urlencode("Magyar"),
	"hy" => urlencode("Հայերեն"),
	"id_ID" => urlencode("Bahasa Indonesia"),
	"is_IS" => urlencode("Íslenska"),
	"it_IT" => urlencode("Italiano"),
	"ja" => urlencode("日本語"),
	"ka_GE" => urlencode("ქართული"),
	"ko_KR" => urlencode("한국어"),
	"lt_LT" => urlencode("Lietuvių kalba"),
	"lv" => urlencode("Latviešu valoda"),
	"mk_MK" => urlencode("Македонски јазик"),
	"mr" => urlencode("मराठी"),
	"ms_MY" => urlencode("Bahasa Melayu"),
	"my_MM" => urlencode("ဗမာစာ"),
	"nb_NO" => urlencode("Norsk bokmål"),
	"nl_NL" => urlencode("Nederlands"),
	"nl_NL_formal" => urlencode("Nederlands (Formeel)"),
	"nn_NO" => urlencode("Norsk nynorsk"),
	"oci" => urlencode("Occitan"),
	"pl_PL" => urlencode("Polski"),
	"pt_PT" => urlencode("Português"),
	"pt_BR" => urlencode("Português do Brasil"),
	"ro_RO" => urlencode("Română"),
	"ru_RU" => urlencode("Русский"),
	"sk_SK" => urlencode("Slovenčina"),
	"sl_SI" => urlencode("Slovenščina"),
	"sq" => urlencode("Shqip"),
	"sr_RS" => urlencode("Српски језик"),
	"sv_SE" => urlencode("Svenska"),
	"szl" => urlencode("Ślōnskŏ gŏdka"),
	"th" => urlencode("ไทย"),
	"tl" => urlencode("Tagalog"),
	"tr_TR" => urlencode("Türkçe"),
	"ug_CN" => urlencode("Uyƣurqə"),
	"uk" => urlencode("Українська"),
	"vi" => urlencode("Tiếng Việt"),
	"zh_TW" => urlencode("繁體中文"),
	"zh_HK" => urlencode("香港中文版"),
	"zh_CN" => urlencode("简体中文"),
);
/* NAME */
$objservice = new laundry_services();
$objservice->conn = $conn;
$user = new laundry_users();
$user->conn = $conn;
$settings = new laundry_setting();
$settings->conn = $conn;
$payment_hook = new laundry_paymentHook();
$payment_hook->conn = $conn;
$payment_hook->payment_extenstions_exist();
$purchase_check = $payment_hook->payment_purchase_status();

$objcheckversion = new laundry_version_update();
$objcheckversion->conn = $conn;
$current = $settings->get_option('ld_version');
if ($current == "") {
	$objcheckversion->insert_option("ld_version", "1.0");
}
if ($current < 1.1) {
	$settings->set_option("ld_version", "1.1");
}
if ($current < 1.2) {
	$settings->set_option("ld_version", "1.2");
	$objcheckversion->update1_2();
}
if ($current < 1.3) {
	$settings->set_option("ld_version", "1.3");
	$objcheckversion->update1_3();
}
if ($current < 1.4) {
	$settings->set_option("ld_version", "1.4");
	$objcheckversion->update1_4();
}
if ($current < 2.0) {
	$settings->set_option("ld_version", "2.0");
	$objcheckversion->update2_0();
}
$label_language_values = array();
if (isset($_SESSION['current_lang'])) {
	$lang = $_SESSION['current_lang'];
	$language_label_arr = $settings->get_all_labelsbyid($_SESSION['current_lang']);
} else {
	$lang = $settings->get_option("ld_language");
	$language_label_arr = $settings->get_all_labelsbyid($lang);
}
if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "" || $language_label_arr[6] != "") {
	$default_language_arr = $settings->get_all_labelsbyid("en");
	if ($language_label_arr[1] != '') {
		$label_decode_front = base64_decode($language_label_arr[1]);
	} else {
		$label_decode_front = base64_decode($default_language_arr[1]);
	}
	if ($language_label_arr[3] != '') {
		$label_decode_admin = base64_decode($language_label_arr[3]);
	} else {
		$label_decode_admin = base64_decode($default_language_arr[3]);
	}
	if ($language_label_arr[4] != '') {
		$label_decode_error = base64_decode($language_label_arr[4]);
	} else {
		$label_decode_error = base64_decode($default_language_arr[4]);
	}
	if ($language_label_arr[5] != '') {
		$label_decode_extra = base64_decode($language_label_arr[5]);
	} else {
		$label_decode_extra = base64_decode($default_language_arr[5]);
	}
	if ($language_label_arr[6] != '') {
		$label_decode_front_form_errors = base64_decode($language_label_arr[6]);
	} else {
		$label_decode_front_form_errors = base64_decode($default_language_arr[6]);
	}

	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
	$label_decode_front_form_errors_unserial = unserialize($label_decode_front_form_errors);

	$label_language_arr = array_merge($label_decode_front_unserial, $label_decode_admin_unserial, $label_decode_error_unserial, $label_decode_extra_unserial, $label_decode_front_form_errors_unserial);
	foreach ($label_language_arr as $key => $value) {
		$label_language_values[$key] = urldecode($value);
	}
} else {
	$default_language_arr = $settings->get_all_labelsbyid("en");

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

	$label_language_arr = array_merge($label_decode_front_unserial, $label_decode_admin_unserial, $label_decode_error_unserial, $label_decode_extra_unserial, $label_decode_front_form_errors_unserial);
	foreach ($label_language_arr as $key => $value) {
		$label_language_values[$key] = urldecode($value);
	}
}
$frontimage = $settings->get_option('ld_front_image');
if ($frontimage != '') {
	$imagepath = SITE_URL . "assets/images/backgrounds/" . $frontimage;
} else {
	$imagepath = '';
}
$english_date_array = array(
	"January", "Jan", "February", "Feb", "March", "Mar", "April", "Apr", "May", "June", "Jun", "July", "Jul", "August", "Aug", "September", "Sep", "October", "Oct", "November", "Nov", "December", "Dec", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "su", "mo", "tu", "we", "th", "fr", "sa", "AM", "PM"
);
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
	strtoupper($label_language_values['pm'])
);
?>
<!Doctype html>

<head>
	<title><?php echo filter_var($settings->get_option("ld_page_title")); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/png" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/backgrounds/<?php echo filter_var($settings->get_option('ld_favicon_image')); ?>" />
	<?php if ($settings->get_option('ld_seo_meta_description') != '') { ?>
		<meta name="description" content="<?php echo filter_var($settings->get_option('ld_seo_meta_description')); ?>">
	<?php   } ?>
	<?php if ($settings->get_option('ld_seo_og_title') != '') { ?>
		<meta property="og:title" content="<?php echo filter_var($settings->get_option('ld_seo_og_title')); ?>" />
	<?php   } ?>
	<?php if ($settings->get_option('ld_seo_og_type') != '') { ?>
		<meta property="og:type" content="<?php echo filter_var($settings->get_option('ld_seo_og_type')); ?>" />
	<?php   } ?>
	<?php if ($settings->get_option('ld_seo_og_url') != '') { ?>
		<meta property="og:url" content="<?php echo filter_var($settings->get_option('ld_seo_og_url'), FILTER_VALIDATE_URL); ?>" />
	<?php   } ?>
	<?php if ($settings->get_option('ld_seo_og_image') != '') { ?>
		<meta property="og:image" content="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/og_tag_img/<?php echo filter_var($settings->get_option('ld_seo_og_image')); ?>" />
	<?php   } ?>
	<?php
	if ($settings->get_option('ld_google_analytics_code') != '') {
	?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo filter_var($settings->get_option('ld_google_analytics_code')); ?>"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());
			gtag('config', '<?php echo filter_var($settings->get_option('ld_google_analytics_code'), FILTER_VALIDATE_URL); ?>');
		</script>
	<?php
	}
	?>
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/ld-main.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/ld-common.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/tooltipster.bundle.min.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/tooltipster-sideTip-shadow.min.css" type="text/css" media="all" />
	<?php
	if (in_array($lang, array('ary', 'ar', 'azb', 'fa_IR', 'haz'))) { ?>

		<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/lda-front-rtl.css" type="text/css" media="all" />
	<?php   }
	$check_zip_code = explode(",", $settings->get_option('ld_bf_zip_code'));
	$dateFormat = $settings->get_option('ld_date_picker_date_format');
	function date_format_js($date_Format)
	{

		$chars = array(
			/* Day */
			'd' => 'DD',
			'j' => 'DD',
			/* Month */
			'm' => 'MM',
			'M' => 'MMM',
			'F' => 'MMMM',
			/* Year */
			'Y' => 'YYYY',
			'y' => 'YYYY',
		);
		return strtr((string) $date_Format, $chars);
	}
	?>
	<script>
		var ld_postalcode_statusObj = {
			'ld_postalcode_status': '<?php echo filter_var($settings->get_option('ld_postalcode_status')); ?>',
			'zip_show_status': '<?php echo filter_var($check_zip_code[0]); ?>'
		};
		var date_format_for_js = '<?php echo date_format_js($dateFormat); ?>';
		var scrollable_cartObj = {
			'scrollable_cart': '<?php echo filter_var($settings->get_option('ld_cart_scrollable')); ?>'
		};
	</script>

	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/login-style.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/ld-responsive.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/ld-reset.min.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/jquery-ui.min.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/intlTelInput.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/jquery-ui.theme.min.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/font-awesome/css/font-awesome.min.css" type="text/css" media="all">

	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/fonts/Open_Sans/stylesheet.css" type="text/css" media="all">

	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/line-icons/simple-line-icons.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/daterangepicker.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/bootstrap/bootstrap.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/slick.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/slick-theme.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/star_rating.min.css" type="text/css" media="all">

	<?php if ($settings->get_option('ld_stripe_payment_form_status') == 'on') {  ?>
		<script src="https://js.stripe.com/v2/" type="text/javascript"></script>
	<?php   } ?>
	<?php if ($settings->get_option('ld_2checkout_status') == 'Y') {  ?>
		<script src="https://www.2checkout.com/checkout/api/2co.min.js" type="text/javascript"></script>
	<?php   } ?>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/jquery-2.1.4.min.js" type="text/javascript"></script>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/jquery.mask.js" type="text/javascript"></script>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/moment.min.js" type="text/javascript"></script>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/slick.min.js" type="text/javascript"></script>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/daterangepicker.js" type="text/javascript"></script>
	<?php
	include(dirname(__FILE__) . '/extension/ld-common-front-extension-js.php');
	?>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/ld-common-jquery.js?<?php echo time(); ?>" type="text/javascript"></script>

	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/tooltipster.bundle.min.js" type="text/javascript"></script>


	<?php
	include(dirname(__FILE__) . "/admin/language_js_objects.php");
	?>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/jquery.nicescroll.min.js" type="text/javascript"></script>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/intlTelInput.js" type="text/javascript"></script>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/jquery.payment.min.js" type="text/javascript"></script>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/star_rating_min.js" type="text/javascript"></script>

	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/jquery.validate.min.js"></script>
	<style>
		.error {
			color: red;
		}
	</style>
	<?php if ($imagepath != '') { ?>
		<style>
			#ld .ld-fixed-background {
				background-image: url(<?php echo filter_var($imagepath); ?>) !important;
			}
		</style>
	<?php   } else { ?>
		<style>
			#ld .ld-fixed-background {
				background: #F0F0F5 !important;
			}
		</style>
	<?php   } ?>
	<?php
	if ($settings->get_option('ld_cart_scrollable') == 'N') {
		$ld_cart_scrollable_position = 'relative !important';
	?>
		<style>
			#ld .not-scroll-custom {
				margin-top: 0 !important;
			}
		</style>
	<?php
	} else {
		$ld_cart_scrollable_position = 'relative';
	}
	?>
	<?php
	echo "<style>
	/* primary color */
		.laundry{
			color: " . $settings->get_option('ld_text_color') . " !important;
		}
		.slick-prev:before, .slick-next:before{
			color:" . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-link.ld-mybookings{
			color:" . $settings->get_option('ld_text_color_on_bg') . " !important;
			background:" . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-link.ld-mybookings:hover{
			color:" . $settings->get_option('ld_text_color_on_bg') . " !important;
			background:" . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-complete-booking-main .ld-link,
		.laundry .ld-discount-coupons a.ld-apply-coupon.ld-link{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
			background:" . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-link:hover,
		.laundry .ld-main-left .ld-list-header .ld-logged-in-user a.ld-link:hover,
		.laundry .ld-complete-booking-main .ld-link:hover,
		.laundry .ld-discount-coupons a.ld-apply-coupon.ld-link:hover{
			color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry a,
		.laundry .ld-link,
		.laundry .ld-addon-count .ld-btn-group .ld-btn-text{
			color: " . $settings->get_option('ld_text_color') . " !important;
		}
		.laundry a.ld-back-to-top i.icon-arrow-up,
		.laundry .calendar-wrapper .calendar-header a.next-date:hover .icon-arrow-right:before,
		.laundry .calendar-wrapper .calendar-header a.previous-date:hover .icon-arrow-left:before{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.laundry .calendar-body .ld-week:hover a span,
		.laundry .ld-extra-services-list ul.addon-service-list li .ld-addon-ser:hover .addon-price{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.laundry #ld-type-2 .service-selection-main .ld-services-dropdown .ld-service-list:hover,
		.laundry #ld-type-method .ld-services-method-dropdown .ld-service-method-list:hover,
		.laundry .common-selection-main .common-data-dropdown .data-list:hover{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
			background:" . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .selected-is:hover,
		.laundry #ld-type-2 .service-is:hover,
		.laundry #ld-type-method .service-method-is:hover{
			border-color:" . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-extra-services-list ul.addon-service-list li .ld-addon-ser:hover span:before{
			border-top-color:" . $settings->get_option('ld_primary_color') . " !important;
		}
		
		.laundry .calendar-wrapper .calendar-header a.next-date:hover,
		.laundry .calendar-wrapper .calendar-header a.previous-date:hover,
		.laundry .calendar-body .ld-week:hover{
			background:" . $settings->get_option('ld_secondary_color') . " !important;
		}
		.laundry .calendar-body .ld-show-time .time-slot-container ul li.time-slot{
			background:" . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .calendar-body .dates .ld-week.by_default_today_selected.active_today span,
		.laundry .calendar-body .ld-show-time .time-slot-container ul li.time-slot,
		.laundry .calendar-body .dates .ld-week.active span {
			color:" . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.laundry .calendar-header a.previous-date,
		.laundry .calendar-header a.next-date{
			color:" . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		
		.laundry .ld-custom-checkbox  ul.ld-checkbox-list label:hover span,
		.laundry .ld-custom-radio ul.ld-radio-list label:hover span{
			border:1px solid " . $settings->get_option('ld_secondary_color') . " !important;
		}
		#ld-login .ld-main-forget-password .ld-info-btn,
		.laundry #ld-front-forget-password .ld-front-forget-password .ld-info-btn,	
		.laundry .ld-button{
			color:" . $settings->get_option('ld_text_color_on_bg') . ";
			background:" . $settings->get_option('ld_primary_color') . " !important;
			border: 2px solid " . $settings->get_option('ld_primary_color') . ";
		}
		.laundry .ld-display-coupon-code .ld-coupon-value{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
			background:" . $settings->get_option('ld_secondary_color') . " !important;
		}
		/* for front date legends */
		.laundry .calendar-body .ld-show-time .time-slot-container .ld-slot-legends .ld-available-new,
		#ld .ld-addon-count .ld-btn-group .ld-btn-left, #ld .ld-addon-count .ld-btn-group .ld-btn-right{
			background: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .calendar-body .ld-show-time .time-slot-container .ld-slot-legends .ld-selected-new{
			background: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		/* seconday color */
		.nicescroll-cursors{
			background-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
				
	    .laundry .calendar-body .dates .ld-week.active,
	    .laundry .calendar-body .ld-show-time.shown{
	    	background: " . $settings->get_option('ld_secondary_color') . " !important;
	    }
	/* background color all css  HOVER */
		.ld-white-color a{
			color: #FFFFFF !important;
			background: #FFFFFF !important;	
		}
		.laundry .ld-selected,
		.laundry .ld-selected-data,
		.laundry .ld-provider-list ul.provders-list li input[type='radio']:checked + lable span,
		.laundry .ld-list-services ul.services-list li input[type='radio']:checked + lable span,
		.laundry .ld-extra-services-list ul.addon-service-list li input[type='checkbox']:checked label span,
		.laundry .ld-discount-list ul.ld-discount-often li input[type='radio']:checked + .ld-btn-discount,
		.laundry #ld-tslots .ld-date-time-main .time-slot-selection-main .time-slot.ld-selected,
		.laundry .ld-button:hover,
		.laundry-login .ld-main-forget-password .ld-info-btn:hover,
		.laundry #ld-front-forget-password .ld-front-forget-password .ld-info-btn:hover,
		.laundry  input[type='submit']:hover,
		.laundry  input[type='reset']:hover,
		.laundry  input[type='button']:hover{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
			background: " . $settings->get_option('ld_primary_color') . " !important;
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-step-heading{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
			background: " . $settings->get_option('ld_primary_color') . " !important;
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
			border-radius: 2px;
			box-shadow: 0 4px 4px " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .promocodes{
		   color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		   background: " . $settings->get_option('ld_secondary_color') . " !important;
		   border-color: " . $settings->get_option('ld_secondary_color') . " !important;
		  }
		.laundry #ld-price-scroll{
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
			box-shadow: 0 4px 4px #ccc !important;
			position: " . $ld_cart_scrollable_position . ";
		}
		
		.laundry .ld-cart-wrapper .ld-cart-label-total-amount,
		.laundry .ld-cart-wrapper .ld-cart-total-amount{
			color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		
		.laundry .ld-list-services ul.services-list li input[type='radio']:checked + .ld-service ,
		.laundry .ld-provider-list ul.provders-list li input[type='radio']:checked + .ld-provider ,
		.laundry .ld-extra-services-list ul.addon-service-list li input[type='checkbox']:checked + .ld-addon-ser {
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
			box-shadow: 0 0 1px 1px " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-extra-services-list ul.addon-service-list li input[type='checkbox']:checked + .ld-addon-ser span:before,
		.ld-list-services ul.services-list li .ld-service::before{
			border-top-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		
		.laundry .ld-extra-services-list ul.addon-service-list li input[type='checkbox']:checked + .ld-addon-ser .addon-price{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		
		
		.laundry .border-c:hover,
		.laundry .ld-list-services ul.services-list li .ld-service:hover,
		.laundry .ld-list-services ul.addon-service-list li .ld-addon-ser:hover,
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bedroom-box .ld-bedroom-btn:hover,
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bathroom-box .ld-bathroom-btn:hover,
		.laundry #ld-duration-main.ld-service-duration .ld-duration-list .duration-box .ld-duration-btn:hover,
		.laundry .ld-extra-services-list .ld-addon-extra-count .ld-common-addon-list .ld-addon-box .ld-addon-btn:hover,
		.laundry .ld-discount-list ul.ld-discount-often li .ld-btn-discount:hover,
		.laundry .ld-custom-radio ul.ld-radio-list label:hover span,
		.laundry .ld-custom-checkbox  ul.ld-checkbox-list label:hover span{
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
			
		}
		.laundry .cart_toggle_head{
			background-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		
		
		.laundry .ld-custom-checkbox  ul.ld-checkbox-list input[type='checkbox']:checked + label span{
			border: 1px solid " . $settings->get_option('ld_primary_color') . " !important;
			background: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-custom-radio ul.ld-radio-list input[type='radio']:checked + label span{
			border:5px solid " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bedroom-box .ld-bedroom-btn.ld-bed-selected,
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bathroom-box .ld-bathroom-btn.ld-bath-selected,
		.laundry #ld-duration-main.ld-service-duration .ld-duration-list .duration-box .ld-duration-btn.duration-box-selected,
		.laundry .ld-extra-services-list .ld-addon-extra-count .ld-common-addon-list .ld-addon-box .ld-addon-selected{
			background: " . $settings->get_option('ld_secondary_color') . " !important;
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
			border-color: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		
		.laundry .ld-button.ld-btn-abs,
		.laundry .calendar-header,
		.laundry .panel-login .panel-heading .col-xs-6,
		.laundry a.ld-back-to-top {
			background-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry a.ld-back-to-top:hover,
		.laundry .weekdays{
			background-color: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		
		.laundry .calendar-body .dates .ld-week.by_default_today_selected{
			background-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .calendar-body .dates .ld-week.by_default_today_selected a span{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		
		.laundry .calendar-body .dates .ld-week.selected_date.active{
			background-color: " . $settings->get_option('ld_secondary_color') . " !important;
			border-bottom: thin solid " . $settings->get_option('ld_secondary_color') . " !important;
		}
		.laundry .calendar-body .ld-show-time .time-slot-container ul li.time-slot:hover,
		.laundry .calendar-body .ld-show-time .time-slot-container ul li.time-slot.ld-booked,
		.laundry .calendar-body .ld-show-time.shown{
			background-color: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		
		
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bedroom-box .ld-bedroom-btn.ld-bed-selected,
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bathroom-box .ld-bathroom-btn.ld-bath-selected,
		.laundry #ld-duration-main.ld-service-duration .ld-duration-list .duration-box .ld-duration-btn.duration-box-selected,
		.laundry .ld-extra-services-list .ld-addon-extra-count .ld-common-addon-list .ld-addon-box .ld-addon-selected{
			
		}
		
		
		
		/* hover inputs */
		.laundry input[type='text']:hover,
		.laundry input[type='password']:hover,
		.laundry input[type='email']:hover,
		.laundry input[type='url']:hover,
		.laundry input[type='tel']:hover,
		.laundry input[type='number']:hover,
		.laundry input[type='range']:hover,
		.laundry input[type='date']:hover,
		.laundry textarea:hover,
		.laundry select:hover,
		.laundry input[type='search']:hover,
		.laundry input[type='submit']:hover,
		.laundry input[type='button']:hover{
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		
		/* Focus inputs */
		.laundry input[type='text']:focus,
		.laundry input[type='password']:focus,
		.laundry input[type='email']:focus,
		.laundry input[type='url']:focus,
		.laundry input[type='tel']:focus,
		.laundry input[type='number']:focus,
		.laundry input[type='range']:focus,
		.laundry input[type='date']:focus,
		.laundry textarea:focus,
		.laundry select:focus,
		.laundry input[type='search']:focus,
		.laundry input[type='submit']:focus,
		.laundry input[type='button']:focus{
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
			
		}
		.laundry .ld-tooltip-link {color: " . $settings->get_option('ld_secondary_color') . " !important;}
	    /* for custom css option */
		" . $settings->get_option('ld_custom_css') . "
		
		.laundry .ld_method_tab-slider--nav .ld_method_tab-slider-tabs {
		  background: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld_method_tab-slider--nav .ld_method_tab-slider-tabs:after {
		  background: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		.laundry .ld_method_tab-slider--nav .ld_method_tab-slider-trigger {
		  color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.laundry .ld_method_tab-slider--nav .ld_method_tab-slider-trigger.active {
		  color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.ld-list-services ul.services-list li input[type=\"radio\"]:checked + .ld-service::after{
			background-color: " . $settings->get_option('ld_primary_color') . " !important;
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.rating-md{
			font-size: 1.5em !important ;
			display: table;
			margin: auto;
		}
		.laundry .bar:before, .bar:after {
			background-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
	</style>";
	?>
	<script>
		jQuery(document).ready(function() {
			var $sidebar = jQuery("#ld-price-scroll"),
				$window = jQuery(window),
				offset = $sidebar.offset(),
				topPadding = 250;
			fulloffset = jQuery("#ld").offset();

			$window.scroll(function() {
				var color = jQuery('#color_box').val();
				jQuery("#ld-price-scroll").css({
					'box-shadow': '0px 0px 1px ' + color + '',
					'position': 'absolute'
				});
			});
		});
	</script>
	<script type="text/javascript">
		function myFunction() {
			var input = document.getElementById('coupon_val')
			var div = document.getElementById('display_code');
			div.innerHTML = input.value;
		}
	</script>

</head>

<body>
	<div class="ld-wrapper laundry" id="ld">
		<div class="ld-fixed-background"></div>

		<?php if ($settings->get_option("ld_loader") == 'css' && $settings->get_option("ld_custom_css_loader") != '') { ?>
			<div class="ld-loading-main" align="center">
				<?php echo $settings->get_option("ld_custom_css_loader"); ?>
			</div>
		<?php   } elseif ($settings->get_option("ld_loader") == 'gif' && $settings->get_option("ld_custom_gif_loader") != '') { ?>
			<div class="ld-loading-main" align="center">
				<img style="margin-top:18%;" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/gif-loader/<?php echo filter_var($settings->get_option("ld_custom_gif_loader")); ?>"></img>
			</div>
		<?php   } else { ?>
			<div class="ld-loading-main">
				<div class="loader">Loading...</div>
			</div>
		<?php   } ?>
		<?php  
  $today_date = date("Y-m-d");
  $promo->today_date = $today_date;
  $get_offer = $promo->special_offer();

  if ($get_offer->num_rows) {
    if($get_offer->num_rows > 0){
      while($spe_text = mysqli_fetch_array($get_offer)){
      if($today_date == $spe_text['coupon_date']){ ?>
        <div class="promocodes" id="promocodes"><?php  echo $spe_text['special_text']; ?></div>
      <?php  
       }
      }
    }
  }

  ?>
		<div class="ld-main-wrapper">
			<div class="ld_container">


				<?php
				/* added for display flags start */
				$langs_selects = $settings->count_lang();
				if ($settings->get_option("ld_front_language_selection_dropdown") == "Y"  && $langs_selects > 1) {
				?>
					<div class="ld-sm-12 np">
						<span class="pull-left ld-link np" style="text-decoration: none;"><?php echo filter_var($label_language_values['set_language']); ?>
							<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/flags/flags.min.css" type="text/css" media="all" />
							<?php
							$langs_select = $settings->get_all_languages();
							$langs_array = array('en' => 'us', 'ary' => 'ma', 'ar' => 'ar', 'az' => 'az', 'azb' => 'az', 'bg_BG' => 'bg', 'bn_BD' => 'bn', 'bs_BA' => 'bs', 'ca' => 'catalonia', 'ceb' => 'ph', 'cs_CZ' => 'cz', 'cy' => 'cy', 'da_DK' => 'dk', 'de_CH_informal' => 'de', 'de_DE_formal' => 'de', 'de_DE' => 'de', 'de_CH' => 'de', 'el' => 'gr', 'en_CA' => 'ca', 'en_GB' => 'gb', 'en_NZ' => 'nz', 'en_ZA' => 'za', 'en_AU' => 'au', 'eo' => 'sa', 'es_ES' => 'es', 'et' => 'et', 'eu' => 'eu', 'fa_IR' => 'ir', 'fi' => 'fi', 'fr_FR' => 'fr', 'gd' => 'gd', 'gl_ES' => 'gl', 'gu' => 'in', 'haz' => 'pe', 'hi_IN' => 'in', 'hr' => 'hr', 'hu_HU' => 'hu', 'hy' => 'pe', 'id_ID' => 'id', 'is_IS' => 'is', 'it_IT' => 'it', 'ja' => 'jp', 'ka_GE' => 'ge', 'ko_KR' => 'kr', 'lt_LT' => 'lt', 'lv' => 'lv', 'mk_MK' => 'mk', 'mr' => 'in', 'ms_MY' => 'my', 'my_MM' => 'mm', 'nb_NO' => 'no', 'nl_NL' => 'nl', 'nl_NL_formal' => 'nl', 'nn_NO' => 'no', 'oci' => 'es', 'pl_PL' => 'pl', 'pt_PT' => 'pt', 'pt_BR' => 'br', 'ro_RO' => 'ro', 'ru_RU' => 'ru', 'sk_SK' => 'sk', 'sl_SI' => 'si', 'sq' => 'al', 'sr_RS' => 'rs', 'sv_SE' => 'se', 'szl' => 'pl', 'th' => 'th', 'tl' => 'ph', 'tr_TR' => 'tr', 'ug_CN' => 'az', 'uk' => 'ua', 'vi' => 'vi', 'zh_TW' => 'tw', 'zh_HK' => 'hk', 'zh_CN' => 'cn');
							while ($res = mysqli_fetch_array($langs_select)) {
								if ($res['language_status'] == 'Y') {
							?>
									<a href="javascript:void(0);" class="select_language_view" data-langs="<?php echo filter_var($res['language']); ?>" title="<?php echo urldecode($language_names[$res['language']]); ?>"><img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/flags/blank.gif" class="flag flag-<?php echo filter_var($langs_array[$res['language']]); ?>" /></a>
							<?php
								} else {
								}
							}
							?>
						</span>
					</div>
				<?php
				}
				/* added for display flags end */
				?>
				<?php
				/* added for display flags start */
				$langs_selects = $settings->count_lang();
				if ($settings->get_option("ld_front_language_selection_dropdown") == "Y"  && $langs_selects > 1) {
				?>
					<div class="ld-main-left ld-sm-7 ld-md-7 ld-xs-12 br-5 np mb-30">
					<?php
				} else {
					?>
						<div class="ld-main-left ld-sm-7 ld-md-7 ld-xs-12 mt-30 br-5 np mb-30">
						<?php
					}
						?>
						<div class="ld-sm-12 ld-md-12 ta-c ld-location-header">
							<?php if ($settings->get_option('ld_company_logo') != "" &&  $settings->get_option('ld_company_logo_display') == "Y") { ?>

								<div id="ld-logo">
									<a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>">
										<img style="max-height: 150px; max-width: 150px;" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL) . "assets/images/services/" . $settings->get_option('ld_company_logo'); ?>" />
									</a>
								</div>
							<?php   } ?>
							<?php if ($settings->get_option('ld_company_title_display') == "Y") { ?>
								<h2 class="header2"><?php echo filter_var($settings->get_option('ld_company_name')); ?></h2>
							<?php   } ?>
							<?php
							if ($settings->get_option('ld_company_header_address') == "Y") {
								$address = $settings->get_option('ld_company_address');
								$city = $settings->get_option('ld_company_city');
								$state = $settings->get_option('ld_company_state');
								$phone = $settings->get_option('ld_company_phone');
							?>

								<h6 class="header6"><?php if ($address == '') {
														echo filter_var('');
													} else {
														echo filter_var($address) . ', ';
													} ?><?php if ($city == '') {
									echo filter_var('');
								} else {
									echo filter_var($city) . ', ';
								} ?><?php if ($state == '') {
									echo filter_var('');
								} else {
									echo filter_var($state);
								} ?><span class="ld-company-phone">
										<?php if ($phone == '' || strlen($phone) <= 6) {
											echo filter_var('');
										} else {
											echo filter_var($phone);
										} ?>
									</span>

								</h6>
							<?php   } ?>

							<a class="ld-link ld-mybookings" target="_blank" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL) . "admin/my-appointments.php"; ?>"><?php echo filter_var($label_language_values['my_bookings']); ?></a><?php if ($settings->get_option("ld_front_tool_tips_status") == 'on' && $settings->get_option("ld_front_tool_tips_my_bookings") != '') { ?>
								<a class="ld-tooltip mybooking-tt" href="#" data-placement="right" data-toggle="tooltip" title="<?php echo $settings->get_option("ld_front_tool_tips_my_bookings"); ?>"><i class="fa fa-info-circle fa-lg"></i></a>
							<?php   } ?>

						</div>
						<?php if ($settings->get_option("ld_postalcode_status") == 'Y') { ?>
							<div class="ld-list-services ld-common-box">
								<div class="ld-list-header">
									<h3 class="header3 header_bg"><?php echo filter_var($label_language_values['where_would_you_like_us_to_provide_service']); ?></h3>

								</div>
								<div class="ld-address-area-main">

									<div class="ld-postal-code">
										<h6 class="header6"><?php echo filter_var($label_language_values['your_postal_code']); ?>
											<?php if ($settings->get_option("ld_front_tool_tips_status") == 'on' && $settings->get_option("ld_front_tool_tips_postal_code") != '') { ?>
												<a class="ld-tooltip" href='#' title="<?php echo $settings->get_option("ld_front_tool_tips_postal_code"); ?>"><i class="fa fa-info-circle fa-lg"></i></a>
											<?php   } ?>
										</h6>
										<div class="ld-md-3 ld-sm-6 ld-xs-12 remove_show_error_class">
											<?php
											$postalcode_placeholder = explode(',', $settings->get_option_postal("ld_postal_code"));
											?>
											<input type="text" class="ld-postal-input" name="ld_postal_code" id="ld_postal_code" placeholder="<?php echo filter_var($postalcode_placeholder[0]); ?>" />
											<label class="postal_code_error error"></label>
											<label class="postal_code_available"></label>
										</div>
									</div>
								</div>
							</div>
						<?php   } ?>


						<div class="ld-list-services ld-common-box fl hide_allsss">
							<div class="ld-list-header">
								<h3 class="header3 header_bg"><?php echo filter_var($label_language_values['choose_service']); ?>
									<?php if ($settings->get_option("ld_front_tool_tips_status") == 'on' && $settings->get_option("ld_front_tool_tips_services") != '') { ?>
										<a class="ld-tooltip" href="#" data-toggle="tooltip" title="<?php echo $settings->get_option("ld_front_tool_tips_services"); ?>"><i class="fa fa-info-circle fa-lg"></i></a>
									<?php   } ?>
								</h3>

								<label class="service_not_selected_error" id="service_not_selected_error"></label>
							</div>
							<input id="total_cart_count" type="hidden" name="total_cart_count" value='1' />

							<?php
							if ($settings->get_option('ld_service_default_design') == 1) {
							?>

								<ul class="services-list">
									<?php
									$services_data = $objservice->readall_for_frontend_services();
									if (mysqli_num_rows($services_data) > 0) {
										while ($s_arr = mysqli_fetch_array($services_data)) {
											$objservice->services_id = $s_arr['id'];
											$countser = $objservice->get_count_service();
											$countserlim = $objservice->get_count_service_limit();
											if ($countser < $countserlim) {
									?>
												<li <?php if ($settings->get_option('ld_company_service_desc_status') != "" &&  $settings->get_option('ld_company_service_desc_status') == "Y") { ?> title='<?php echo filter_var($s_arr['description']); ?>' class="ld-sm-6 ld-md-4 ld-lg-3 ld-xs-12 remove_service_class ser_details ld-tooltip-services tooltipstered" <?php   } else {
																																																																																											echo "class='ld-sm-6 ld-md-4 ld-lg-3 ld-xs-12 remove_service_class ser_details'";
																																																																																										}  ?> data-servicetitle="<?php echo filter_var($s_arr['title']); ?>" data-id="<?php echo filter_var($s_arr['id']); ?>">
													<input type="radio" name="service-radio" id="ld-service-<?php echo filter_var($s_arr['id']); ?>" class="make_service_disable" />
													<label class="ld-service border-c" for="ld-service-<?php echo filter_var($s_arr['id']); ?>">
														<?php
														if ($s_arr['image'] == '') {
															$s_image = 'default_service.png';
														} else {
															$s_image = $s_arr['image'];
														}
														?>
														<div class="ld-service-img"><img class="ld-image" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/services/<?php echo filter_var($s_image); ?>" />

															<div class="service-name fl ta-c"><?php echo filter_var($s_arr['title']); ?></div>
														</div>

													</label>

												</li>
										<?php
											}
										} ?>
									<?php    } else {
									?>
										<li class="ld-sm-12 ld-md-12 ld-xs-12 ld-no-service-box"><?php echo filter_var($label_language_values['please_configure_first_laundry_services_and_settings_in_admin_panel']); ?>
										</li>
									<?php
									}
									?>
								</ul>

								<?php
								if (mysqli_num_rows($services_data) === 1) {
									$ser_arry = mysqli_fetch_array($services_data)
								?>
									<script>
										/** Make Service Selected **/
										jQuery(document).ready(function() {
											jQuery('.ser_details').trigger('click');
										});
									</script>
								<?php
								}
							} else {
								?>
								<input type="radio" style="display:none;" name="service-radio" id="ld-service-0" value='off' class="make_service_disable" />

								<?php
								$services_data = $objservice->readall_for_frontend_services();
								if (mysqli_num_rows($services_data) > 0) {
								?>
									<label class="service_not_selected_error_d2" id="service_not_selected_error_d2"><?php echo filter_var($label_language_values['please_select_service']); ?></label>
									<div class="services-list-dropdown fl" id="ld-type-2">
										<div class="service-selection-main">
											<div class="service-is" title="<?php echo filter_var($label_language_values['choose_your_service']); ?>">
												<div class="ld-service-list" id="ld_selected_service">
													<i class="icon-settings service-image icons"></i>

													<h3 class="service-name ser_name_for_error"><?php echo filter_var($label_language_values['laundry_service']); ?></h3>
												</div>
											</div>
											<div class="ld-services-dropdown remove_service_data"> <?php
																									while ($s_arr = mysqli_fetch_array($services_data)) { ?>
													<div class="ld-service-list select_service remove_service_class ser_details" data-servicetitle="<?php echo filter_var($s_arr['title']); ?>" data-id="<?php echo filter_var($s_arr['id']); ?>">
														<?php
																										if ($s_arr['image'] == '') {
																											$s_image = 'default_service.png';
																										} else {
																											$s_image = $s_arr['image'];
																										}
														?>
														<img class="service-image" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/services/<?php echo filter_var($s_image); ?>" title="<?php echo filter_var($label_language_values['service_image']); ?>" />

														<h3 class="service-name"><?php echo filter_var($s_arr['title']); ?></h3>
													</div>
												<?php   }
												?>
											</div>
										</div>
									</div><?php
											if (mysqli_num_rows($services_data) === 1) {
												$st_arry = mysqli_fetch_array($services_data)
											?>
										<script>
											/** Make Service Selected **/
											jQuery(document).ready(function() {
												jQuery('.select_service').trigger('click');
											});
										</script>
									<?php
											}
										} else {
									?>
									<div class="ld-sm-12 ld-md-12 ld-xs-12 ld-no-service-box"><?php echo filter_var($label_language_values['please_configure_first_laundry_services_and_settings_in_admin_panel']); ?></div>
								<?php
										}
								?>

							<?php
							}
							?>
							<div class="ld-scroll-meth-unit"></div>
							<!--<label class="empty_cart_error" id="empty_cart_error"></label>
					<label class="no_units_in_cart_error" id="no_units_in_cart_error"></label>-->
							<input type='hidden' id="no_units_in_cart_err" value=''>
							<input type='hidden' id="no_units_in_cart_err_count" value=''>

							<div class="ld-service-duration ld-md-12 ld-sm-12 s_m_units_design_1" id="ld-duration-main">
								<div class="ld-inner-box border-c">

									<div class="fl ld-md-12 mt-5 mb-15 np duration_hrs">
									</div>

								</div>
							</div>



						</div>







						<div class="ld-extra-services-list ld-common-box add_on_lists hide_allsss_addons">

						</div>
						<div class=" ">
							<label class="empty_cart_error" id="empty_cart_error"></label>
							<label class="no_units_in_cart_error" id="no_units_in_cart_error"></label>
						</div>

						<input type="hidden" id="self_service" value="<?php echo filter_var($settings->get_option('ld_show_self_service')); ?>">
						<?php if ($settings->get_option('ld_show_self_service') == "E") { ?>
							<div class="ld-date-time-main ld-md-12 ld-xs-12 ld-form-row np">
								<h3 class="header3 pull-left ml-10" id="pad-15"><?php echo filter_var($label_language_values['self_service']); ?></h3>
								<div class="pull-left" id="pad-pad-l">
									<div class="ld-custom-checkbox">
										<ul class="ld-checkbox-list">
											<li>
												<input type="checkbox" id="self_service_status" />
												<label for="self_service_status" class="">
													<span></span>
												</label>
											</li>
										</ul>
									</div>
								</div>
							</div>
						<?php   } ?>


						<div class="ld-common-box hide_allsss mt-5">
							<div class="ld-list-header">
								<h3 class="header3 header_bg"><?php echo filter_var($label_language_values['select_pick_up_date_and_time']); ?>
									<?php if ($settings->get_option("ld_front_tool_tips_status") == 'on' && $settings->get_option("ld_front_tool_tips_time_slots") != '') { ?>
										<a class="ld-tooltip" href="#" data-toggle="tooltip" title="<?php echo $settings->get_option("ld_front_tool_tips_time_slots"); ?>"><i class="fa fa-info-circle fa-lg"></i></a>
									<?php   } ?>
								</h3>
							</div>

							<div class="ld-md-6 ld-sm-12 ld-xs-12 ld-datetime-select-main">
								<div class="ld-datetime-select">
									<label class="pickup_date_error" id="date_time_error_id" for="complete_bookings"></label>
									<div class="calendar-wrapper cal_info">
										<input type="text" id="pickup_date" name="datetimes" />
									</div>

								</div>
							</div>
							<div class="ld-md-6 ld-sm-12 ld-xs-12 ld-datetime-select-main">
								<div class="ld-datetime-select">
									<label class="pickup_time_error" id="date_time_error_id" for="complete_bookings"></label>
									<div class="calendar-wrapper cal_info">
										<select class="selectpicker pickup-slots">
											<option>Select Slot</option>
										</select>
									</div>

								</div>
							</div>
						</div>
						<?php if ($settings->get_option('ld_show_delivery_date') == "E") { ?>
							<div class="ld-common-box hide_allsss">
								<div class="ld-list-header">
									<h3 class="header3 header_bg"><?php echo filter_var($label_language_values['select_delivery_date_and_time']); ?>
										<?php if ($settings->get_option("ld_front_tool_tips_status") == 'on' && $settings->get_option("ld_front_tool_tips_time_slots") != '') { ?>
											<a class="ld-tooltip" href="#" data-toggle="tooltip" title="<?php echo $settings->get_option("ld_front_tool_tips_time_slots"); ?>"><i class="fa fa-info-circle fa-lg"></i></a>
										<?php   } ?>
									</h3>
								</div>

								<div class="ld-md-6 ld-sm-12 ld-xs-12 ld-datetime-select-main">
									<div class="ld-datetime-select">
										<label class="delivery_date_error" id="date_time_error_id" for="complete_bookings"></label>
										<div class="calendar-wrapper cal_info">
											<input type="text" id="delivery_date" name="datetimes" />
										</div>

									</div>
								</div>
								<div class="ld-md-6 ld-sm-12 ld-xs-12 ld-datetime-select-main">
									<div class="ld-datetime-select">
										<label class="delivery_time_error" id="date_time_error_id" for="complete_bookings"></label>
										<div class="calendar-wrapper cal_info">
											<select class="selectpicker delivery-slots">
												<option>Select Slot</option>
											</select>
										</div>

									</div>
								</div>
							</div>
						<?php   } ?>


						<div class="ld-provider-list ct-common-box">

							<div class="ld-list-header">

								<h3 class="header3 show_select_staff_title" style="display:none;"><?php echo 'Please Select Provider'; ?></h3>

								<ul class="provders-list"></ul>

							</div>

						</div>
						<div class="row ld-user-info-main ld-date-time-main ld-common-box existing_user_details hide_allsss">
							<div class="ld-list-header">
								<h3 class="header3 header_bg"><?php echo filter_var($label_language_values['your_personal_details']); ?>
									<?php if ($settings->get_option("ld_front_tool_tips_status") == 'on' && $settings->get_option("ld_front_tool_tips_personal_details") != '') { ?>
										<a class="ld-tooltip" href="#" data-toggle="tooltip" title="<?php echo $settings->get_option("ld_front_tool_tips_personal_details"); ?>"><i class="fa fa-info-circle fa-lg"></i></a>
									<?php   } ?>
								</h3>

								<p class="ld-sub"><?php echo filter_var($label_language_values['please_provide_your_address_and_contact_details']); ?></p>

								<div class="ld-logged-in-user client_logout mb-20">
									<p class="welcome_msg_after_login pull-left"><?php echo filter_var($label_language_values['you_are_logged_in_as']); ?> <span class='fname'></span> <span class='lname'></span></p>
									<a href="javascript:void(0)" class="ld-link ml-10" id="logout" data-id="<?php if (isset($_SESSION['ld_login_user_id'])) {
																												echo filter_var($_SESSION['ld_login_user_id']);
																											} ?>" title="<?php echo filter_var($label_language_values['log_out']); ?>"><?php echo filter_var($label_language_values['log_out']); ?></a>
								</div>
							</div>
							<div class="ld-main-details">
								<div class="ld-login-exist" id="ld-login">
									<div class="ld-custom-radio">
										<ul class="ld-radio-list hide_radio_btn_after_login">
											<?php
											if ($settings->get_option('ld_existing_and_new_user_checkout') == 'on' && $settings->get_option('ld_guest_user_checkout') == 'on') {
											?>
												<li class="ld-exiting-user ld-md-4 ld-sm-6 ld-xs-12">
													<input id="existing-user" type="radio" class="input-radio existing-user user-selection" name="user-selection" value="Existing User" />
													<label for="existing-user" class=""><span></span><?php echo filter_var($label_language_values['existing_user']); ?></label>
												</li>
												<li class="ld-new-user ld-md-4 ld-sm-6 ld-xs-12">
													<input id="new-user" type="radio" checked="checked" class="input-radio new-user user-selection" name="user-selection" value="New-User" />
													<label for="new-user" class=""><span></span><?php echo filter_var($label_language_values['new_user']); ?>
													</label>
												</li>
												<li class="ld-guest-user ld-md-4 ld-sm-6 ld-xs-12">
													<input id="guest-user" type="radio" class="input-radio guest-user user-selection" name="user-selection" value="Guest-User" />
													<label for="guest-user" class=""><span></span><?php echo filter_var($label_language_values['guest_user']); ?></label>
												</li>
											<?php
											} else if ($settings->get_option('ld_existing_and_new_user_checkout') == 'off' && $settings->get_option('ld_guest_user_checkout') == 'on') {
											?>
												<li class="ld-guest-user ld-md-4 ld-sm-6 ld-xs-12" style='display:none;'>
													<input id="guest-user" type="radio" class="input-radio guest-user user-selection" checked="checked" name="user-selection" value="Guest-User" />
													<label for="guest-user" class=""><span></span><?php echo filter_var($label_language_values['guest_user']); ?></label>
												</li>
											<?php
											} else if ($settings->get_option('ld_existing_and_new_user_checkout') == 'on' && $settings->get_option('ld_guest_user_checkout') == 'off') {
											?>
												<li class="ld-exiting-user ld-md-4 ld-sm-6 ld-xs-12">
													<input id="existing-user" type="radio" class="input-radio existing-user user-selection" name="user-selection" value="Existing User" />
													<label for="existing-user" class=""><span></span><?php echo filter_var($label_language_values['existing_user']); ?></label>
												</li>
												<li class="ld-new-user ld-md-4 ld-sm-6 ld-xs-12">
													<input id="new-user" type="radio" checked="checked" class="input-radio new-user user-selection" name="user-selection" value="New-User" />
													<label for="new-user" class=""><span></span><?php echo filter_var($label_language_values['new_user']); ?>
													</label>
												</li>
											<?php
											}
											?>
										</ul>
									</div>

									<div class="ld-login-existing ld_hidden">
										<form id="user_login_form" class="" method="POST" autocomplete="off">

											<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row hide_login_email fancy_input_wrap">

												<input type="text" class="add_show_error_class_for_login error fancy_input" name="ld_user_name" id="ld-user-name" onkeydown="if (event.keyCode == 13) document.getElementById('login_existing_user').click()" />
												<span class="highlight"></span>
												<span class="bar"></span>
												<label for="ld-user-name" class="fancy_label"><?php echo filter_var($label_language_values['your_email']); ?></label>
											</div>

											<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row hide_password fancy_input_wrap">

												<input type="password" class="add_show_error_class_for_login error fancy_input" name="ld_user_pass" id="ld-user-pass" onkeydown="if (event.keyCode == 13) document.getElementById('login_existing_user').click()" autocomplete="new-password"/>
												<span class="highlight"></span>
												<span class="bar"></span>
												<label for="ld-user-pass" class="fancy_label"><?php echo filter_var($label_language_values['your_password']); ?>
												</label>
											</div>

											<label class="login_unsuccessfull"></label>

											<div class="ld-md-12 ld-xs-12 mb-15 hide_login_btn">
												<input type="hidden" value='not' id="check_login_click" />
												<a href="javascript:void(0)" class="ld-button" id="login_existing_user" title="<?php echo filter_var($label_language_values['log_in']); ?>"><?php echo filter_var($label_language_values['log_in']); ?></a>
												<a href="javascript:void(0)" id="ld_forget_password" class="ld-link" title="<?php echo filter_var($label_language_values['forget_password']); ?>?"><?php echo filter_var($label_language_values['forget_password']); ?></a>
											</div>
										</form>
									</div>
								</div>
								<input type="hidden" id="color_box" data-id="<?php echo filter_var($settings->get_option('ld_secondary_color')); ?>" value="<?php echo filter_var($settings->get_option('ld_secondary_color')); ?>" />

								<form id="user_details_form" class="" method="post" autocomplete="off">
									<div class="ld-new-user-details remove_preferred_password_and_preferred_email">

										<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">

											<input type="text" name="ld_email" id="ld-email" class="add_show_error_class error fancy_input" required />
											<span class="highlight"></span>
											<span class="bar"></span>
											<label for="ld-email" class="fancy_label"><?php echo filter_var($label_language_values['preferred_email']); ?></label>

										</div>

										<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">

											<input type="password" name="ld_preffered_pass" id="ld-preffered-pass" class="add_show_error_class error fancy_input" autocomplete="new-password"/>
											<span class="highlight"></span>
											<span class="bar"></span>
											<label for="ld-preffered-pass" class="fancy_label"><?php echo filter_var($label_language_values['preferred_password']); ?></label>

										</div>

									</div>
									<div class="ld-peronal-details">

										<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row remove_guest_user_preferred_email fancy_input_wrap">


											<input type="text" name="ld_email_guest" class="add_show_error_class error fancy_input" id="ld-email-guest" />
											<span class="highlight"></span>
											<span class="bar"></span>
											<label for="ld-email-guest" class="fancy_label"><?php echo filter_var($label_language_values['preferred_email']); ?>
											</label>

										</div>

										<?php $fn_check = explode(",", $settings->get_option("ld_bf_first_name"));
										if ($fn_check[0] == 'on') { ?>

											<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">


												<input type="text" name="ld_first_name" class="add_show_error_class error fancy_input" id="ld-first-name" />
												<span class="highlight"></span>
												<span class="bar"></span>
												<label for="ld-first-name" class="fancy_label"><?php echo filter_var($label_language_values['first_name']); ?></label>

											</div>

										<?php   } else {
										?>
											<input type="hidden" name="ld_first_name" id="ld-first-name" class="add_show_error_class error" value="" />
										<?php
										} ?>
										<?php $ln_check = explode(",", $settings->get_option("ld_bf_last_name"));
										if ($ln_check[0] == 'on') { ?>

											<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">

												<input type="text" class="add_show_error_class error fancy_input" name="ld_last_name" id="ld-last-name" />
												<span class="highlight"></span>
												<span class="bar"></span>
												<label for="ld-last-pass" class="fancy_label"><?php echo filter_var($label_language_values['last_name']); ?></label>
											</div>

										<?php   } else {
										?>
											<input type="hidden" name="ld_last_name" id="ld-last-name" class="add_show_error_class error" value="" />
										<?php
										} ?>
										<?php $phone_check = explode(",", $settings->get_option("ld_bf_phone"));
										if ($phone_check[0] == 'on') { ?>

											<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap phone_no_wrap">

												<input type="tel" value="" id="ld-user-phone" class="add_show_error_class error fancy_input" name="ld_user_phone" />
												<span class="highlight"></span>
												<span class="bar"></span>
												<label for="ld-user-phone" class="fancy_label"><?php echo filter_var($label_language_values['phone']); ?></label>
											</div>

										<?php   } else {
										?>
											<input type="hidden" name="ld_user_phone" id="ld-user-phone" class="add_show_error_class error" value="" />
										<?php
										} ?>
										<?php $address_check = explode(",", $settings->get_option("ld_bf_address"));
										if ($address_check[0] == 'on') { ?>

											<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">

												<input type="text" name="ld_street_address" id="ld-street-address" class="add_show_error_class error fancy_input" />
												<span class="highlight"></span>
												<span class="bar"></span>
												<label for="ld-street-address" class="fancy_label"><?php echo filter_var($label_language_values['street_address']); ?></label>

											</div>

										<?php   } else {
										?>
											<input type="hidden" name="ld_street_address" id="ld-street-address" class="add_show_error_class error" value="" />
										<?php
										} ?>
										<?php $zip_check = explode(",", $settings->get_option("ld_bf_zip_code"));
										if ($zip_check[0] == 'on') { ?>

											<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row remove_zip_code_class fancy_input_wrap">

												<input type="text" name="ld_zip_code" id="ld-zip-code" class="add_show_error_class error fancy_input" />
												<span class="highlight"></span>
												<span class="bar"></span>
												<label for="ld-zip-code" class="fancy_label"><?php echo filter_var($label_language_values['zip_code']); ?></label>
											</div>

										<?php   } else {
										?>
											<input type="hidden" name="ld_zip_code" id="ld-zip-code" class="add_show_error_class error" value="" />
										<?php
										} ?>
										<?php $city_check = explode(",", $settings->get_option("ld_bf_city"));
										if ($city_check[0] == 'on') { ?>

											<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row remove_city_class fancy_input_wrap">

												<input type="text" name="ld_city" id="ld-city" class="add_show_error_class error fancy_input" />
												<span class="highlight"></span>
												<span class="bar"></span>
												<label for="ld-city" class="fancy_label"><?php echo filter_var($label_language_values['city']); ?></label>

											</div>

										<?php   } else {
										?>
											<input type="hidden" name="ld_city" id="ld-city" class="add_show_error_class error" value="" />
										<?php
										} ?>
										<?php $state_check = explode(",", $settings->get_option("ld_bf_state"));
										if ($state_check[0] == 'on') { ?>

											<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row remove_state_class fancy_input_wrap">

												<input type="text" name="ld_state" id="ld-state" class="add_show_error_class error fancy_input" />
												<span class="highlight"></span>
												<span class="bar"></span>
												<label for="ld-state" class="fancy_label"><?php echo filter_var($label_language_values['state']); ?></label>
											</div>

										<?php   } else {
										?>
											<input type="hidden" name="ld_state" id="ld-state" class="add_show_error_class error" value="" />
										<?php
										} ?>
										<?php $notes_check = explode(",", $settings->get_option("ld_bf_notes"));
										if ($notes_check[0] == 'on') { ?>

											<div class="ld-md-12 ld-xs-12 ld-form-row fancy_input_wrap">

												<textarea id="ld-notes" class="add_show_error_class error fancy_input" rows="10"></textarea>
												<span class="highlight"></span>
												<span class="bar"></span>
												<label for="ld-notes" class="fancy_label"><?php echo filter_var($label_language_values['special_requests_notes']); ?></label>
											</div>

										<?php   } else {
										?>
											<input type="hidden" id="ld-notes" class="add_show_error_class error" value="" />
										<?php
										} ?>
										<?php if ($settings->get_option('ld_company_willwe_getin_status') != "" &&  $settings->get_option('ld_company_willwe_getin_status') == "Y") { ?>
											<div class="ld-options-new ld-md-12 ld-xs-12 mb-10 ld-form-row">
												<label><?php echo filter_var($label_language_values['how_will_we_get_in']); ?></label>

												<div class="ld-option-select">
													<select class="ld-option-select" id="contact_status">
														<option value="I'll be at home"><?php echo filter_var($label_language_values['i_will_be_at_home']); ?></option>
														<option value="Please call me"><?php echo filter_var($label_language_values['please_call_me']); ?></option>
														<option value="The key is with the doorman"><?php echo filter_var($label_language_values['the_key_is_with_the_doorman']); ?></option>
														<option value="Other"><?php echo filter_var($label_language_values['other']); ?></option>
													</select>
												</div>
												<div class="ld-option-others pt-10 ld_hidden">
													<input type="text" name="other_contact_status" class="add_show_error_class error" id="other_contact_status" />
												</div>
											</div>
										<?php   } ?>
									</div>

							</div>

						</div>



						<div class="ld-common-box hide_allsss">

							<div class="ld-list-header">
								<h3 class="header3 header_bg"><?php echo filter_var($label_language_values['preferred_payment_method']); ?>
									<?php if ($settings->get_option("ld_front_tool_tips_status") == 'on' && $settings->get_option("ld_front_tool_payment_method") != '') { ?>
										<a class="ld-tooltip" href="#" data-toggle="tooltip" title="<?php echo $settings->get_option("ld_front_tool_payment_method"); ?>"><i class="fa fa-info-circle fa-lg"></i></a>
									<?php   } ?>
								</h3>

							</div>

							<div class="ld-main-payments fl">
								<div class="payments-container f-l" id="ld-payments">
									<label class="ld-error-msg"><?php echo filter_var($label_language_values['please_select_one_payment_method']); ?></label>
									<label class="ld-error-msg ld-paypal-error" id="paypal_error"></label>

									<div class="ld-custom-radio ld-payment-methods f-l">
										<ul class="ld-radio-list ld-all-pay-methods">
											<?php if ($settings->get_option('ld_pay_locally_status') == 'on') { ?>
												<li class="ld-md-3 ld-sm-6 ld-xs-12" id="pay-at-venue">
													<input type="radio" name="payment-methods" value="pay at venue" class="input-radio payment_gateway" id="pay-cash" checked="checked" />
													<label for="pay-cash" class="locally-radio"><span></span><?php echo filter_var($label_language_values['pay_locally']); ?></label>
												</li>

											<?php   } ?>


											<?php if ($settings->get_option('ld_bank_transfer_status') == 'Y' && ($settings->get_option('ld_bank_name') != '' || $settings->get_option('ld_account_name') != ''  || $settings->get_option('ld_account_number') != '' || $settings->get_option('ld_branch_code') != '' || $settings->get_option('ld_ifsc_code') != '' || $settings->get_option('ld_bank_description') != '')) { ?>
												<li class="ld-md-3 ld-sm-6 ld-xs-12" id="ld-bank-transer">
													<input type="radio" name="payment-methods" value="bank transfer" class="input-radio bank_transfer payment_gateway" id="bank-transer" />
													<label for="bank-transer" class="locally-radio"><span></span><?php echo filter_var($label_language_values['bank_transfer']); ?></label>
												</li>
											<?php   } ?>

											<?php
											if ($settings->get_option('ld_paypal_express_checkout_status') == 'on') {
											?>

												<li class="ld-md-3 ld-sm-6 ld-xs-12" id="pay-at-venue">
													<input type="radio" name="payment-methods" value="paypal" class="input-radio payment_gateway" id="pay-paypal" checked="checked" />
													<label for="pay-paypal" class="locally-radio"><span></span><?php echo filter_var($label_language_values['paypal']); ?><img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/cards/paypal.png" class="ld-paypal-image" alt="PayPal"></label>
												</li>
											<?php
											} ?>

											<?php
											if ($settings->get_option('ld_payumoney_status') == 'Y') {
											?>

												<li class="ld-md-3 ld-sm-6 ld-xs-12" id="pay-at-venue">
													<input type="radio" name="payment-methods" value="payumoney" class="input-radio payment_gateway" id="payumoney" checked="checked" />
													<label for="payumoney" class="locally-radio"><span></span> <?php echo filter_var($label_language_values['payumoney']); ?></label>
												</li>
											<?php
											} ?>
											<?php if ($settings->get_option('ld_authorizenet_status') == 'on' && $settings->get_option('ld_stripe_payment_form_status') != 'on' && $settings->get_option('ld_2checkout_status') != 'Y') {  ?>

												<li class="ld-md-3 ld-sm-6 ld-xs-12" id="card-payment">
													<input type="radio" name="payment-methods" value="card-payment" class="input-radio payment_gateway cccard" id="pay-card" checked="checked" />
													<label for="pay-card" class="card-radio"><span></span><?php echo filter_var($label_language_values['card_payment']); ?></label>
												</li>
											<?php    }  ?>
											<?php if ($settings->get_option('ld_authorizenet_status') != 'on' && $settings->get_option('ld_stripe_payment_form_status') == 'on' && $settings->get_option('ld_2checkout_status') != 'Y') {  ?>

												<li class="ld-md-3 ld-sm-6 ld-xs-12" id="card-payment">
													<input type="radio" name="payment-methods" value="stripe-payment" class="input-radio payment_gateway cccard" id="pay-card" checked="checked" />
													<label for="pay-card" class="card-radio"><span></span><?php echo filter_var($label_language_values['card_payment']); ?></label>
												</li>
											<?php    }  ?>
											<?php if ($settings->get_option('ld_authorizenet_status') != 'on' && $settings->get_option('ld_stripe_payment_form_status') != 'on' && $settings->get_option('ld_2checkout_status') == 'Y') {  ?>

												<li class="ld-md-3 ld-sm-6 ld-xs-12" id="card-payment">
													<input type="radio" name="payment-methods" value="2checkout-payment" class="input-radio payment_gateway cccard" id="pay-card" checked="checked" />
													<label for="pay-card" class="card-radio"><span></span><?php echo filter_var($label_language_values['card_payment']); ?></label>
												</li>
											<?php    } ?>

											<?php
											if (sizeof($purchase_check) > 0) {
												foreach ($purchase_check as $key => $val) {
													if ($val == 'Y') {
														echo filter_var($payment_hook->payment_payment_selection_hook($key));
													}
												}
											}
											?>

										</ul>
									</div>
								</div>



								<div id="ld-pay-methods" class="payment-method-container f-l">

									<div class="card-type-center f-l">
										<div class="common-payment-style ld_hidden" <?php
																					if ($settings->get_option('ld_authorizenet_status') == 'on' || $settings->get_option('ld_stripe_payment_form_status') == 'on' || $settings->get_option('ld_2checkout_status') == 'Y') {
																						echo " style='display:block;' ";
																					} else if (sizeof($purchase_check) > 0) {
																						$check_pay = 'N';
																						$display_check = '';
																						foreach ($purchase_check as $key => $val) {
																							if ($val == 'Y') {
																								if ($payment_hook->payment_display_cardbox_condition_hook($key) == true) {
																									if ($display_check == '') {
																										$display_check = " style='display:block;' ";
																										$check_pay = 'Y';
																									} else if ($display_check == " style='display:none;' ") {
																										$display_check = " style='display:block;' ";
																										$check_pay = 'Y';
																									}
																								} else {
																									if ($display_check == '') {
																										$display_check = " style='display:none;' ";
																										$check_pay = 'Y';
																									} else if ($display_check == " style='display:block;' ") {
																										$display_check = " style='display:none;' ";
																										$check_pay = 'Y';
																									}
																								}
																							}
																						}
																						echo filter_var($display_check);
																					} ?>>
											<div class="payment-inner">
												<?php if ($settings->get_option('ld_2checkout_status') == 'Y') { ?>
													<input id="token" name="token" type="hidden" value="">
												<?php   } ?>
												<div id="card-payment-fields">
													<div class="ld-md-12 ld-xs-12 ld-header-bg">
														<h4 class="header4"><?php echo filter_var($label_language_values['card_details']); ?></h4>
														<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/cards/card-images.png" class="ld-stripe-image float-right img-responsive" alt="Stripe" />
													</div>
													<div class="ld-md-12">
														<label id="ld-card-payment-error" class="ld-error-msg ld-payment-error"><?php echo filter_var($label_language_values['invalid_card_number']); ?><?php echo filter_var($label_language_values['expiry_date_or_csv']); ?></label>
													</div>
													<div class="ld-md-9 ld-sm-9 ld-xs-12 ld-card-details">
														<div class="ld-form-row ld-md-12 ld-xs-12">
															<label><?php echo filter_var($label_language_values['card_number']); ?></label>
															<i class="icon-credit-card icons"></i>
															<input class="cc-number ld-card-number" maxlength="20" size="20" data-stripe="number" type="tel">
															<span class="card" aria-hidden="true"></span>

														</div>

														<div class="ld-form-row ld-md-8 ld-sm-8 ld-xs-12 ld-exp-mnyr">
															<label><?php echo filter_var($label_language_values['expiry']); ?><?php echo filter_var($label_language_values['mm_yyyy']); ?></label>
															<i class="icon-calendar icons"></i>
															<input data-stripe="exp-month" class="cc-exp-month ld-exp-month" maxlength="2" type="tel" placeholder="<?php echo date('m'); ?>" />/

															<input data-stripe="exp-year" class="cc-exp-year ld-exp-year" maxlength="4" type="tel" placeholder="<?php echo date('Y'); ?>" />
														</div>
														<div class="ld-form-row ld-md-4 ld-sm-4 ld-xs-12 ld-stripe-cvc">
															<label><?php echo filter_var($label_language_values['cvc']); ?></label>
															<i class="icon-lock icons"></i>
															<input type="password" placeholder="●●●" maxlength="4" size="4" data-stripe="cvc" class="cc-cvc ld-cvc-code" type="tel" />

														</div>
													</div>
													<div class="ld-md-3 ld-sm-3 ld-xs-12 ld-lock-image">
														<div class="ld-lock-img"></div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>

								<div id="ld-bank-transfer-box" class="payment-method-container f-l">
									<div class="card-type-center f-l">
										<div class="common-payment-style-bank-transfer ld_hidden">
											<div class="payment-inner">
												<div id="card-payment-fields" style="">
													<div class="ld-md-12 ld-xs-12 ld-header-bg">
														<h4 class="header4"><?php echo filter_var($label_language_values['bank_details']); ?></h4>
													</div>
													<div class="ld-md-12">
														<table>
															<tbody>
																<?php if ($settings->get_option('ld_bank_name') != "") { ?>
																	<tr class="dc_acc_name">
																		<th><strong><?php echo filter_var($label_language_values['bank_name']); ?></strong></th>
																		<td><span class="amount"><?php echo filter_var($settings->get_option('ld_bank_name')); ?></span></td>
																	</tr>
																<?php   }
																if ($settings->get_option('ld_account_name') != "") { ?>
																	<tr class="dc_acc_name">
																		<th><strong><?php echo filter_var($label_language_values['account_name']); ?></strong></th>
																		<td><span class="amount"><?php echo filter_var($settings->get_option('ld_account_name')); ?></span></td>
																	</tr>
																<?php   }
																if ($settings->get_option('ld_account_number') != "") { ?>
																	<tr class="dc_acc_number">
																		<th><strong><?php echo filter_var($label_language_values['account_number']); ?></strong></th>
																		<td><span class="amount"><?php echo filter_var($settings->get_option('ld_account_number')); ?></span></td>
																	</tr>
																<?php   }
																if ($settings->get_option('ld_branch_code') != "") { ?>
																	<tr class="dc_branch_code">
																		<th><strong><?php echo filter_var($label_language_values['branch_code']); ?></strong></th>
																		<td><span class="amount"><?php echo filter_var($settings->get_option('ld_branch_code')); ?></span></td>
																	</tr>
																<?php   }
																if ($settings->get_option('ld_ifsc_code') != "") { ?>
																	<tr class="dc_ifc_code">
																		<th><strong><?php echo filter_var($label_language_values['ifsc_code']); ?></strong></th>
																		<td><span class="amount"><?php echo filter_var($settings->get_option('ld_ifsc_code')); ?></span></td>
																	</tr>
																<?php   }
																if ($settings->get_option('ld_bank_description') != "") { ?>
																	<tr class="dc_ifc_code">
																		<th><strong><?php echo filter_var($label_language_values['bank_description']); ?></strong></th>
																		<td><span class="amount"><?php echo filter_var($settings->get_option('ld_bank_description')); ?></span></td>
																	</tr>
																<?php   } ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>

						</div>

						<div class="ld-list-header">
							<p class="ld-sub-complete-booking"></p>
						</div>
						<?php if ($settings->get_option('ld_cancelation_policy_status') == 'Y') { ?>

							<div class="ld-complete-booking ld-md-12 cb">
								<h5 class="ld-cancel-booking"><?php echo filter_var($label_language_values['cancellation_policy']); ?></h5>

								<div class="ld-cancel-policy">
									<p><?php echo filter_var($settings->get_option('ld_cancel_policy_header')); ?></p>
									<span class="show-more-toggler ld-link"><?php echo filter_var($label_language_values['show_more']); ?></span>
									<ul class="bullet-more">
										<li><?php echo filter_var($settings->get_option('ld_cancel_policy_textarea')); ?></li>
									</ul>
								</div>
							</div>
						<?php   } ?>

						<?php if ($settings->get_option('ld_allow_terms_and_conditions') == 'Y' || $settings->get_option('ld_allow_privacy_policy') == 'Y') { ?>
							<div class="bi-terms-agree ld-md-12">
								<div class="ld-custom-checkbox">
									<ul class="ld-checkbox-list">
										<li>
											<input type="checkbox" name="accept-conditions" class="input-radio" id="accept-conditions" />
											<label for="accept-conditions" class="">
												<span></span>
												<?php echo filter_var($label_language_values['i_have_read_and_accepted_the']); ?>
												<?php if ($settings->get_option('ld_allow_terms_and_conditions') == 'Y' && $settings->get_option('ld_allow_privacy_policy') == 'N') { ?>
													<a href="<?php if ($settings->get_option('ld_terms_condition_link') != '') {
																	echo filter_var($settings->get_option('ld_terms_condition_link'), FILTER_VALIDATE_URL);
																} else {
																	echo 'javascript:void(0)';
																} ?>" <?php if ($settings->get_option('ld_terms_condition_link') != '') { ?> target="-BLANK" <?php   } ?> class="ld-link">
														<?php echo filter_var($label_language_values['terms_and_condition']); ?>
													</a>.
												<?php   } else if ($settings->get_option('ld_allow_terms_and_conditions') == 'N' && $settings->get_option('ld_allow_privacy_policy') == 'Y') { ?>
													<a href="<?php if ($settings->get_option('ld_privacy_policy_link') != '') {
																	echo filter_var($settings->get_option('ld_privacy_policy_link'), FILTER_VALIDATE_URL);
																} else {
																	echo 'javascript:void(0)';
																} ?>" <?php if ($settings->get_option('ld_privacy_policy_link') != '') { ?> target="-BLANK" <?php   } ?> class="ld-link"><?php echo filter_var($label_language_values['privacy_policy']); ?></a>.
												<?php   } else { ?>
													<a href="<?php if ($settings->get_option('ld_terms_condition_link') != '') {
																	echo filter_var($settings->get_option('ld_terms_condition_link'), FILTER_VALIDATE_URL);
																} else {
																	echo 'javascript:void(0)';
																} ?>" <?php if ($settings->get_option('ld_terms_condition_link') != '') { ?> target="-BLANK" <?php   } ?> class="ld-link"><?php echo filter_var($label_language_values['terms_and_condition']); ?></a>
													<?php echo filter_var($label_language_values['and']); ?>
													<a href="<?php if ($settings->get_option('ld_privacy_policy_link') != '') {
																	echo filter_var($settings->get_option('ld_privacy_policy_link'), FILTER_VALIDATE_URL);
																} else {
																	echo 'javascript:void(0)';
																} ?>" <?php if ($settings->get_option('ld_privacy_policy_link') != '') { ?> target="-BLANK" <?php   } ?> class="ld-link"><?php echo filter_var($label_language_values['privacy_policy']); ?></a>.
												<?php   } ?>
											</label>
										</li>
									</ul>
								</div>
								<label class="terms_and_condition"></label>
							</div>
						<?php   } ?>

						<div class="ta-center fl">
							<?php if ($settings->get_option("ld_loader") == 'css' && $settings->get_option("ld_custom_css_loader") != '') { ?>
								<div class="ld-loading-main-complete_booking" align="center">
									<?php echo $settings->get_option("ld_custom_css_loader"); ?>
								</div>
							<?php   } elseif ($settings->get_option("ld_loader") == 'gif' && $settings->get_option("ld_custom_gif_loader") != '') { ?>
								<div class="ld-loading-main-complete_booking" align="center">
									<img style="margin-top:18%;" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/gif-loader/<?php echo filter_var($settings->get_option("ld_custom_gif_loader")); ?>"></img>
								</div>
							<?php   } else { ?>
								<div class="ld-loading-main-complete_booking">
									<div class="loader">Loading...</div>
								</div>
							<?php   } ?>

							<a href="javascript:void(0)" type='submit' data-currency_symbol="<?php echo $settings->get_option('ld_currency_symbol'); ?>" id='complete_bookings' class="ld-button ld-btn-big ld_remove_id"><?php echo filter_var($label_language_values['complete_booking']); ?></a>
						</div>
						<center class="ld-white-color"><a href="https://codecanyon.net/item/appointment-booking-software-for-laundry-maintenance-businesses-laundry/18397969">Powered by </a><a href="https://www.laundry.net/">Laundry</a></center>
						</div>



						<?php
						/* added for display flags start */
						$langs_selects = $settings->count_lang();
						if ($settings->get_option("ld_front_language_selection_dropdown") == "Y"  && $langs_selects > 1) {
						?>
							<div class="ld-main-right ld-sm-4 ld-md-4 ld-xs-12 mb-30 br-5 pull-right hide_allsss">
							<?php
						} else {
							?>
								<div class="ld-main-right ld-sm-4 ld-md-4 ld-xs-12 mt-30 mb-30 br-5 pull-right hide_allsss">
								<?php
							}
								?>


								<?php
								if ($settings->get_option('ld_partial_deposit_status') == 'Y' || $settings->get_option('ld_allow_front_desc') == 'Y') {
								?>
									<div class="main-inner-container ld-static-right-side border-c <?php if ($settings->get_option('ld_partial_deposit_status') == 'Y' && $settings->get_option('ld_allow_front_desc') == 'N') {
																										echo filter_var(' hide_right_side_box');
																									} ?>" id="ld-not-scroll">

										<div class="ld-cart-wrapper f-l">
											<div class="main-inner-container">

												<?php
												if ($settings->get_option('ld_partial_deposit_status') == 'Y' && $settings->get_option('ld_stripe_payment_form_status') == 'off' && $settings->get_option('ld_pay_locally_status') == 'on' && $settings->get_option('ld_paypal_express_checkout_status') == 'off' && $settings->get_option('ld_2checkout_status') == 'N' && $settings->get_option('ld_payumoney_status') == 'N' && $settings->get_option('ld_authorizenet_status') != 'on') {
													echo filter_var('');
												} else {
												}
												?>
												<div class="mb-30"></div>
												<?php if ($settings->get_option('ld_allow_front_desc') == 'Y' && $settings->get_option('ld_front_desc') != "") { ?>
													<div class="features-list">
														<?php
														$var = $settings->get_option('ld_front_desc');
														echo $var;
														?>
													</div>
												<?php   } ?>
											</div>
										</div>
									</div>
								<?php   } ?>

								<div class="fl">
									<div class="main-inner-container border-c ld-price-scroll" id="ld-price-scroll">
										<div class="ld-step-heading">
											<h3 class="header3"><?php echo filter_var($label_language_values['booking_summary']); ?></h3>
										</div>
										<div class="ld-cart-wrapper f-l" id="">
											<div class="ld-summary hideservice_name">
												<div class="ld-image">
													<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/icon-service.png" alt="">
												</div>
												<p class="ld-text sel-service"></p>
											</div>
											<div class="ld-summary hidedatetime_value">
												<div class="ld-image">
													<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/pick-up-date.png" alt="">
												</div>
												<p class="ld-text sel-datetime"><span class='cart_date' data-date_val=""></span><span class="space_between_date_time"> @ </span><span class='cart_time' data-time_val=""></span></p>
											</div>
											<div class="ld-summary hidedatetime_del_value">
												<div class="ld-image">
													<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/delivery-date.png" alt="">
												</div>
												<p class="ld-text sel-datetime"><span class='cart_del_date' data-date_del_val=""></span><span class="space_between_date_time_del"> @ </span><span class='cart_del_time' data-time_del_val=""></span></p>
											</div>
											<?php if ($settings->get_option('ld_show_self_service') == "E") { ?>
												<div class="ld-summary hide_self_service">
													<div class="ld-image">
														<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/self-service.png" alt="">
													</div>
													<p class="ld-text sel-self-service"></p>
												</div>
											<?php } ?>
											<div class="ld-form-rown ld-addons-list-main">
												<div class="step_heading f-l">
													<h6 class="header6 ld-item-list"><?php echo filter_var($label_language_values['cart_items']); ?></h6>
												</div>
												<div class="cart-items-main f-l">
													<label class="cart_empty_msg"><?php echo filter_var($label_language_values['cart_is_empty']); ?></label>
													<!-- <ul class="ld-addon-items-list cart_item_listing">

                                    </ul> -->
													<ul class="ld-addon-items-list-main cart_item_listing">

													</ul>
												</div>
											</div>
											<div class="ld-form-rown d_flex">
												<div class="ld-cart-label-common ofh"><?php echo filter_var($label_language_values['sub_total']); ?></div>
												<div class="ld-cart-amount-common ofh">
													<span class="ld-sub-total cart_sub_total"></span>
												</div>
											</div>
											<?php
											$today_date = date("Y-m-d");
											$promo->today_date = $today_date;
											$get_offer = $promo->special_offer();
											if ($get_offer->num_rows) {
											if($get_offer->num_rows > 0){
												while($spe_text = mysqli_fetch_array($get_offer)){
												
												if($today_date == $spe_text['coupon_date']){ ?>
												
													<div class="ld-form-rown d_flex">

													<div class="ld-cart-label-common ofh"><?php  echo "Special Discount"; ?></div>

													<div class="ld-cart-amount-common ofh">

														<span class="ld-sub-total special_offer"></span>

													</div>

													</div>

												<?php  
												}
												}
											}
											}
											if ($settings->get_option('ld_show_coupons_input_on_checkout') == 'on') {
											?>
												<div class="ld-form-rown coupon_display">
													<div class="ld-cart-label-common ofh" style="display:contents;"><?php echo filter_var($label_language_values['coupon_discount']); ?></div>
													<div class="ld-cart-amount-common ofh">
														<span class="ld-coupon-discount cart_discount"></span>
													</div>
												</div>
											<?php
											}
											
											?>
											<?php
											if ($settings->get_option('ld_tax_vat_status') == 'Y') {
											?>
												<div class="ld-form-rown d_flex">
													<div class="ld-cart-label-common ofh"><?php echo filter_var($label_language_values['tax']); ?></div>
													<div class="ld-cart-amount-common ofh">
														<span class="ld-tax-amount cart_tax"></span>
													</div>
												</div>
											<?php
											}
											if ($settings->get_option('ld_partial_deposit_status') == 'Y') {
											?>
												<div class="ld-form-rown partial_amount_hide_on_load mb-15">
													<div class="ld-partial-amount-wrapper border-c border-2">
														<div class="ld-partial-amount-message">
															<?php echo filter_var($settings->get_option('ld_partial_deposit_message')); ?>
														</div>
														<div class="ld-form-rown d_flex mt-10 mb-10">
															<div class="ld-cart-label-common ofh"><?php echo filter_var($label_language_values['partial_deposit']); ?></div>
															<div class="ld-cart-amount-common ofh">
																<span class="ld-partial-deposit partial_amount"></span>
															</div>
														</div>
														<div class="ld-form-rown d_flex mt-10 mb-10">
															<div class="ld-cart-label-common ofh"><?php echo filter_var($label_language_values['remaining_amount']); ?></div>
															<div class="ld-cart-amount-common ofh">
																<span class="ld-remaining-amount remain_amount"></span>
															</div>
														</div>
													</div>
												</div>
											<?php
											}
											?>

											<?php
											if ($settings->get_option('ld_show_coupons_input_on_checkout') == 'on') {
											?>
												<div class="ld-discount-coupons ld-md-12">
													<div class="ld-form-rown">
														<div class="ld-coupon-input ld-md-12 ld-sm-12 ld-xs-12 mt-10 np">
															<input id="coupon_val" type="text" name="coupon_apply" class="ld-coupon-input-text hide_coupon_textbox" placeholder="<?php echo filter_var($label_language_values['have_a_promocode']); ?>" maxlength="22" onchange="myFunction()" />
															<a href="javascript:void(0);" class="ld-apply-coupon ld-link hide_coupon_textbox" name="apply-coupon" id="apply_coupon"><?php echo filter_var($label_language_values['apply']); ?></a>
															<?php if ($settings->get_option("ld_front_tool_tips_status") == 'on' && $settings->get_option("ld_front_tool_tips_promocode") != '') { ?>
																<a class="ld-tooltip" href="#" data-toggle="tooltip" title="<?php echo $settings->get_option("ld_front_tool_tips_promocode"); ?>"><i class="fa fa-info-circle fa-lg"></i></a>
															<?php   } ?>
															<label class="ld-error ofh coupon_invalid_error"></label>

															<div class="ld-display-coupon-code">
																<div class="ld-form-rown">

																	<div class="ld-coupon-value-main ld-md-5 ld-xs-12">
																		<span class="ld-coupon-value border-2" id="display_code"></span>
																		<img id="ld-remove-applied-coupon" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/ld-close.png" class="reverse_coupon" title="<?php echo filter_var($label_language_values['remove_applied_coupon']); ?>" />
																	</div>
																	<div class="ld-column ld-md-7 ld-xs-12 ofh">
																		<label><?php echo filter_var($label_language_values['applied_promocode']); ?></label>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											<?php
											}
											?>
											<div class="ld-form-rown d_flex">
												<div class="ld-cart-label-total-amount ofh"><?php echo filter_var($label_language_values['total']); ?></div>
												<div class="ld-cart-total-amount ofh">
													<span class="ld-total-amount cart_total"></span>
												</div>
											</div>

											<div class="ld-clear"></div>

										</div>



									</div>
								</div>
								</div>


								</form>
								<a href="javascript:void(0)" class="ld-back-to-top br-2"><i class="icon-arrow-up icons"></i></a>
								<?php
								if ($settings->get_option('ld_payumoney_status') == 'Y') {
								?>
									<form action="https://secure.payu.in/_payment" method="post" name="payuForm" id="payuForm">
										<input type="hidden" name="key" id="payu_key" value="" />
										<input type="hidden" name="hash" id="payu_hash" value="" />
										<input type="hidden" name="txnid" id="payu_txnid" value="" />
										<input type="hidden" name="amount" id="payu_amount" value="" />
										<input type="hidden" name="firstname" id="payu_fname" value="" />
										<input type="hidden" name="email" id="payu_email" value="" />
										<input type="hidden" name="phone" id="payu_phone" value="" />
										<input type="hidden" name="productinfo" id="payu_productinfo" value="" />
										<input type="hidden" name="surl" id="payu_surl" value="" />
										<input type="hidden" name="furl" id="payu_furl" value="" />
										<input type="hidden" name="service_provider" id="payu_service_provider" value="" />
									</form>
								<?php
								}
								?>
								<?php
								if (sizeof($purchase_check) > 0) {
									foreach ($purchase_check as $key => $val) {
										if ($val == 'Y') {
											echo filter_var($payment_hook->payment_form_hook($key), FILTER_VALIDATE_URL);
										}
									}
								}
								?>
							</div>

					</div>


					<div class="main">
						<div id="ld-front-forget-password">

							<div class="vertical-alignment-helper">
								<div class="vertical-align-center">
									<div class="ld-front-forget-password visible">
										<div class="form-container">
											<div class="tab-content">
												<form id="forget_pass" name="" method="POST">
													<h1 class="forget-password"><?php echo filter_var($label_language_values['reset_password']); ?></h1>
													<h4><?php echo filter_var($label_language_values['enter_your_email_and_we_send_you_instructions_on_resetting_your_password']); ?></h4>

													<div class="form-group fl mt-15">
														<label for="userEmail"><i class="icon-envelope-alt"></i><?php echo filter_var($label_language_values['email']); ?></label>
														<input type="email" class="add_show_error_class error" id="rp_user_email" name="rp_user_email" placeholder="<?php echo filter_var($label_language_values['registered_email']); ?>">
													</div>
													<label class="forget_pass_correct"></label>
													<label class="forget_pass_incorrect"></label>

													<div class="clearfix">
														<a class="btn ld-info-btn btn-lg ld-xs-12" href="javascript:void(0)" id="reset_pass"><?php echo filter_var($label_language_values['send_mail']); ?></a>
													</div>
													<div class="clearfix">
														<a class="btn btn-link ld-xs-12" id="ld_login_user" href="javascript:void(0)"><?php echo filter_var($label_language_values['back_to_login']); ?></a>
													</div>

												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

			</div>
			<?php if (isset($_SESSION['current_lang']) && $_SESSION['current_lang']  == "de_DE") { ?>
				<script type="text/javascript">
					$("#ld").addClass("lg-Deutsch");
				</script>
			<?php
			} elseif (isset($_SESSION['current_lang']) && $_SESSION['current_lang']  == "es_ES") {  ?>
				<script type="text/javascript">
					$("#ld").addClass("lg-Español");
				</script>
			<?php
			} elseif (isset($_SESSION['current_lang']) && $_SESSION['current_lang']  == "fr_FR") {  ?>
				<script type="text/javascript">
					$("#ld").addClass("lg-Français");
				</script>
			<?php
			} elseif (isset($_SESSION['current_lang']) && $_SESSION['current_lang']  == "pt_PT") {  ?>
				<script type="text/javascript">
					$("#ld").addClass("lg-Português");
				</script>
			<?php
			} elseif (isset($_SESSION['current_lang']) && $_SESSION['current_lang']  == "ru_RU") {  ?>
				<script type="text/javascript">
					$("#ld").addClass("lg-Русский");
				</script>
			<?php
			} elseif (isset($_SESSION['current_lang']) && $_SESSION['current_lang']  == "ar") {  ?>
				<script type="text/javascript">
					$("#ld").addClass("lg-العربية");
				</script>
			<?php
			} elseif (isset($_SESSION['current_lang']) && $_SESSION['current_lang']  == "zh_CN") {  ?>
				<script type="text/javascript">
					$("#ld").addClass("lg-简体中文");
				</script>
			<?php
			}
			?>
			<script>
				var baseurlObj = {
					'base_url': '<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>',
					'stripe_publishkey': '<?php echo filter_var($settings->get_option('ld_stripe_publishablekey')); ?>',
					'stripe_status': '<?php echo filter_var($settings->get_option('ld_stripe_payment_form_status')); ?>'
				};
				var siteurlObj = {
					'site_url': '<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>'
				};
				var ajaxurlObj = {
					'ajax_url': '<?php echo filter_var(AJAX_URL, FILTER_VALIDATE_URL); ?>'
				};
				var fronturlObj = {
					'front_url': '<?php echo filter_var(FRONT_URL, FILTER_VALIDATE_URL); ?>'
				};
				var termsconditionObj = {
					'terms_condition': '<?php echo filter_var($settings->get_option('ld_allow_terms_and_conditions')); ?>'
				};
				var privacypolicyObj = {
					'privacy_policy': '<?php echo filter_var($settings->get_option('ld_allow_privacy_policy')); ?>'
				};
				<?php

				if ($settings->get_option('ld_thankyou_page_url') == '') {
					$thankyou_page_url = SITE_URL . 'front/thankyou.php';
				} else {
					$thankyou_page_url = $settings->get_option('ld_thankyou_page_url');
				}

				$phone = explode(",", $settings->get_option('ld_bf_phone'));
				$check_password = explode(",", $settings->get_option('ld_bf_password'));
				$check_fn = explode(",", $settings->get_option('ld_bf_first_name'));
				$check_ln = explode(",", $settings->get_option('ld_bf_last_name'));
				$check_addresss = explode(",", $settings->get_option('ld_bf_address'));
				$check_zip_code = explode(",", $settings->get_option('ld_bf_zip_code'));
				$check_city = explode(",", $settings->get_option('ld_bf_city'));
				$check_state = explode(",", $settings->get_option('ld_bf_state'));
				$check_notes = explode(",", $settings->get_option('ld_bf_notes'));
				$check_notes = explode(",", $settings->get_option('ld_bf_notes'));

				$ld_currency_symbol = $settings->get_option('ld_currency_symbol');
				$ld_express_booking_price = $settings->get_option('ld_express_booking_price');
				$ld_currency_symbol_position = $settings->get_option('ld_currency_symbol_position');
				$ld_price_format_decimal_places = $settings->get_option('ld_price_format_decimal_places');
				?>

				var currency_symbol = '<?php echo filter_var($ld_currency_symbol); ?>';
				var express_booking_price = '<?php echo filter_var($ld_express_booking_price); ?>';
				var currency_symbol_position = '<?php echo filter_var($ld_currency_symbol_position); ?>';
				var price_format_decimal_places = '<?php echo filter_var($ld_price_format_decimal_places); ?>';

				var thankyoupageObj = {
					'thankyou_page': '<?php echo filter_var($thankyou_page_url); ?>'
				};

				var phone_status = {
					'statuss': '<?php echo filter_var($phone[0]); ?>',
					'required': '<?php echo filter_var($phone[1]); ?>',
					'min': '<?php echo filter_var($phone[2]); ?>',
					'max': '<?php echo filter_var($phone[3]); ?>'
				};

				var check_password = {
					'statuss': '<?php echo filter_var($check_password[0]); ?>',
					'required': '<?php echo filter_var($check_password[1]); ?>',
					'min': '<?php echo filter_var($check_password[2]); ?>',
					'max': '<?php echo filter_var($check_password[3]); ?>'
				};

				var check_fn = {
					'statuss': '<?php echo filter_var($check_fn[0]); ?>',
					'required': '<?php echo filter_var($check_fn[1]); ?>',
					'min': '<?php echo filter_var($check_fn[2]); ?>',
					'max': '<?php echo filter_var($check_fn[3]); ?>'
				};

				var check_ln = {
					'statuss': '<?php echo filter_var($check_ln[0]); ?>',
					'required': '<?php echo filter_var($check_ln[1]); ?>',
					'min': '<?php echo filter_var($check_ln[2]); ?>',
					'max': '<?php echo filter_var($check_ln[3]); ?>'
				};

				var check_addresss = {
					'statuss': '<?php echo filter_var($check_addresss[0]); ?>',
					'required': '<?php echo filter_var($check_addresss[1]); ?>',
					'min': '<?php echo filter_var($check_addresss[2]); ?>',
					'max': '<?php echo filter_var($check_addresss[3]); ?>'
				};

				var check_zip_code = {
					'statuss': '<?php echo filter_var($check_zip_code[0]); ?>',
					'required': '<?php echo filter_var($check_zip_code[1]); ?>',
					'min': '<?php echo filter_var($check_zip_code[2]); ?>',
					'max': '<?php echo filter_var($check_zip_code[3]); ?>'
				};

				var check_city = {
					'statuss': '<?php echo filter_var($check_city[0]); ?>',
					'required': '<?php echo filter_var($check_city[1]); ?>',
					'min': '<?php echo filter_var($check_city[2]); ?>',
					'max': '<?php echo filter_var($check_city[3]); ?>'
				};

				var check_state = {
					'statuss': '<?php echo filter_var($check_state[0]); ?>',
					'required': '<?php echo filter_var($check_state[1]); ?>',
					'min': '<?php echo filter_var($check_state[2]); ?>',
					'max': '<?php echo filter_var($check_state[3]); ?>'
				};

				var check_notes = {
					'statuss': '<?php echo filter_var($check_notes[0]); ?>',
					'required': '<?php echo filter_var($check_notes[1]); ?>',
					'min': '<?php echo filter_var($check_notes[2]); ?>',
					'max': '<?php echo filter_var($check_notes[3]); ?>'
				};
				<?php
				$nacode = explode(',', $settings->get_option("ld_company_country_code"));
				$allowed = $settings->get_option("ld_phone_display_country_code");
				?>
				var countrycodeObj = {
					'numbercode': '<?php echo filter_var($nacode[0]); ?>',
					'alphacode': '<?php echo filter_var($nacode[1]); ?>',
					'countrytitle': '<?php echo filter_var($nacode[2]); ?>',
					'allowed': '<?php echo filter_var($allowed); ?>'
				};

				var subheaderObj = {
					'subheader_status': '<?php echo filter_var($settings->get_option('ld_subheaders')); ?>'
				};
				var twocheckout_Obj = {
					'sellerId': '<?php echo filter_var($settings->get_option('ld_2checkout_sellerid')); ?>',
					'publishKey': '<?php echo filter_var($settings->get_option('ld_2checkout_publishkey')); ?>',
					'twocheckout_status': '<?php echo filter_var($settings->get_option('ld_2checkout_status')); ?>'
				};
				var appoint_details = {
					'status': '<?php echo filter_var($settings->get_option('ld_appointment_details_display')); ?>'
				};
				<?php $is_login_user = "N";
				if (isset($_SESSION['ld_login_user_id'])) {
					$is_login_user = "Y";
				} ?>
				var is_login_user = '<?php echo filter_var($is_login_user); ?>';
				var self_service_cart_title = '<?php echo filter_var($label_language_values['self_service']); ?>';
				var minimum_delivery_days = '<?php echo filter_var($settings->get_option('ld_minimum_delivery_days')); ?>';
				var advancebooking_days_limit = '<?php echo filter_var($settings->get_option('ld_max_advance_booking_time')); ?>';
				var show_delivery_date = '<?php echo filter_var($settings->get_option('ld_show_delivery_date')); ?>';
			</script>
</body>

</html>