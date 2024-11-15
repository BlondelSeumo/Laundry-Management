<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include(dirname(__FILE__) . '/header.php');
include_once(dirname(dirname(__FILE__)) . '/header.php');
include(dirname(dirname(__FILE__)) . "/objects/class_sms_template.php");
include(dirname(dirname(__FILE__)) . "/objects/class_email_template.php");
include(dirname(__FILE__) . '/user_session_check.php');
include(dirname(dirname(__FILE__)) . "/objects/class_promo_code.php");
include(dirname(dirname(__FILE__)) . "/objects/class_adminprofile.php");
if (is_file(dirname(dirname(__FILE__)) . '/extension/GoogleCalendar/google-api-php-client/src/Google_Client.php')) {
	require_once dirname(dirname(__FILE__)) . '/extension/GoogleCalendar/google-api-php-client/src/Google_Client.php';
}
include(dirname(dirname(__FILE__)) . "/objects/class_gc_hook.php");
$manage_form_errors_message =
	array(
		"min_ff_ps" => "Minimum characters message for Password",
		"max_ff_ps" => "Maximum characters message for Password",
		"req_ff_fn" => "Required message for First Name",
		"min_ff_fn" => "Minimum characters message for First Name",
		"max_ff_fn" => "Maximum characters message for First Name",
		"req_ff_ln" => "Required message for Last Name",
		"min_ff_ln" => "Minimum characters message for Last Name",
		"max_ff_ln" => "Maximum characters message for Last Name",
		"req_ff_ph" => "Required message for Phone",
		"min_ff_ph" => "Minimum characters message for Phone",
		"max_ff_ph" => "Maximum characters message for Phone",
		"req_ff_sa" => "Required message for Street Address",
		"min_ff_sa" => "Minimum characters message for Street Address",
		"max_ff_sa" => "Maximum characters message for Street Address",
		"req_ff_zp" => "Required message for Zip Code",
		"min_ff_zp" => "Minimum characters message for Zip Code",
		"max_ff_zp" => "Maximum characters message for Zip Code",
		"req_ff_ct" => "Required message for City",
		"min_ff_ct" => "Minimum characters message for City",
		"max_ff_ct" => "Maximum characters message for City",
		"req_ff_st" => "Required message for State",
		"min_ff_st" => "Minimum characters message for State",
		"max_ff_st" => "Maximum characters message for State",
		"req_ff_srn" => "Required message for Notes",
		"min_ff_srn" => "Minimum characters message for Notes",
		"max_ff_srn" => "Maximum characters message for Notes",
		"Transaction_failed_please_try_again" => "Transaction failed please try again",
		"Please_Enter_valid_card_detail" => "Please Enter valid card detail"
	);
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
?>
<div class="ld-alert-msg-show-main mainheader_message_fail_appearance_setting">
	<div class="ld-all-alert-messags alert alert-danger mainheader_message_inner_fail_appearance_setting">

		<strong><?php echo filter_var($label_language_values['failed']);	?></strong> <span id="ld_sucess_message_fail_appearance_setting"></span>
	</div>
</div>
<?php
$database = new laundry_db();
$conn = $database->connect();
/* $database->conn=$conn; */
$promo = new laundry_promo_code();
$promo->conn = $conn;

$sms_template = new laundry_sms_template();
$sms_template->conn = $conn;
$setting->readAll();

$email_template = new laundry_email_template();
$email_template->conn = $conn;

$admin_profile = new laundry_adminprofile();
$admin_profile->conn = $conn;

$gc_hook = new laundry_gcHook();
$gc_hook->conn = $conn;

$admin_profile->id = $_SESSION['ld_adminid'];
$admin_get_email = $admin_profile->readone();

$admin_optional_email = $setting->get_option('ld_admin_optional_email');
if ($admin_optional_email == "") {
	$admin_optional_email = $admin_get_email[2];
}

if ($setting->get_option('ld_paypal_express_checkout_status') == 'on' || $setting->get_option('ld_stripe_payment_form_status') == 'on' || $setting->get_option('ld_authorizenet_status') == 'on' || $setting->get_option('ld_2checkout_status') == 'Y'  || $setting->get_option('ld_payumoney_status') == 'Y') {
	$payment_status = "on";
} else if (sizeof($purchase_check) > 0) {
	$payment_status = "off";
	$check_pay = 'N';
	foreach ($purchase_check as $key => $val) {
		if ($val == 'Y') {
			if ($payment_hook->payment_partial_deposit_toggle_condition_hook($key) == true && $check_pay == 'N') {
				$payment_status = "on";
				$check_pay = 'Y';
			}
		}
	}
} else {
	$payment_status = "off";
}
/* Dynamic Payment Error Code By Jay */
if (sizeof($purchase_check) > 0) {
	foreach ($purchase_check as $key => $val) {
		if ($val == 'Y') {
			echo filter_var($payment_hook->payment_js_objects_hook($key));
		}
	}
}
/* Dynamic Payment Error Code By Jay */
/* Add Appearance Settings */
$upload1 = $upload2 = '';
if (isset($_POST['appreance'])) {
	if (isset($_FILES['ld_frontend_gif_loader_file'])) {
		$gif_mixno = time();
		$gif_ext = pathinfo($_FILES['ld_frontend_gif_loader_file']['name'], PATHINFO_EXTENSION);
		$gif_img_type1 = array('jpg', 'jpeg', 'png', 'gif');
		$gif_destination = dirname(dirname(__FILE__)) . "/assets/images/gif-loader/" . $gif_mixno . "." . $gif_ext . "";
		$gif_lg_image_type = pathinfo($gif_destination, PATHINFO_EXTENSION);
		if (in_array($gif_lg_image_type, $gif_img_type1)) {
			move_uploaded_file($_FILES['ld_frontend_gif_loader_file']['tmp_name'], $gif_destination);
			$upload1 = '1';
			$ld_frontend_gif_imagename = $gif_mixno . "." . $gif_ext . "";
		} else {
			$message = "Invalid Image Type";
			$ld_frontend_gif_imagename = '';
		}
	}

	if (isset($_FILES['loginimg'])) {
		$mixno = rand(1, 1000);
		$ext = pathinfo($_FILES['loginimg']['name'], PATHINFO_EXTENSION);
		$img_type1 = array('jpg', 'jpeg', 'png', 'gif');
		$destination = dirname(dirname(__FILE__)) . "/assets/images/backgrounds/" . "lg_" . $mixno . "." . $ext . "";
		$lg_image_type = pathinfo($destination, PATHINFO_EXTENSION);
		if (in_array($lg_image_type, $img_type1)) {
			move_uploaded_file($_FILES['loginimg']['tmp_name'], $destination);
			$upload1 = '1';
			$loginimagename = "lg_" . $mixno . "." . $ext . "";
		} else {
			$message = "Invalid Image Type";
			$loginimagename = '';
		}
	}

	if (isset($_FILES['frontimage'])) {
		$frmixno = rand(1001, 9999);
		$frext = pathinfo($_FILES['frontimage']['name'], PATHINFO_EXTENSION);
		$img_type2 = array('jpg', 'jpeg', 'png', 'gif');
		$destination2 = dirname(dirname(__FILE__)) . "/assets/images/backgrounds/" . "fr_" . $frmixno . "." . $frext . "";
		$fr_image_type = pathinfo($destination2, PATHINFO_EXTENSION);
		if (in_array($fr_image_type, $img_type2)) {
			move_uploaded_file($_FILES['frontimage']['tmp_name'], $destination2);
			$upload2 = '1';
			$frontimagename = "fr_" . $frmixno . "." . $frext . "";
		} else {
			$message = "Invalid Image Type";
			$frontimagename = '';
		}
	}

	if (isset($_FILES['faviconimage'])) {
		$favmixno = rand(1001, 9999);
		$favext = pathinfo($_FILES['faviconimage']['name'], PATHINFO_EXTENSION);
		$img_type3 = array('jpg', 'jpeg', 'png', 'gif');
		$destination3 = dirname(dirname(__FILE__)) . "/assets/images/backgrounds/" . "fr_" . $favmixno . "." . $favext . "";
		$favicon_image_type = pathinfo($destination3, PATHINFO_EXTENSION);
		if (in_array($favicon_image_type, $img_type3)) {
			move_uploaded_file($_FILES['faviconimage']['tmp_name'], $destination3);
			$upload2 = '1';
			$favimagename = "fr_" . $favmixno . "." . $favext . "";
		} else {
			$message = "Invalid Image Type";
			$favimagename = '';
		}
	}

	if (!isset($_POST['selected_country_code_display'])) {
		$phone_country_code  = "";
	} else {
		$phone_country_code = implode(",", $_POST['selected_country_code_display']);
	}

	$ld_calendar_defaultView = filter_var($_POST['ld_calendar_defaultView']);
	$ld_calendar_firstDay = filter_var($_POST['ld_calendar_firstDay']);
	$slotstatus = (isset($_POST["fadded_slots"]) && filter_var($_POST["fadded_slots"]) == 'on') ? 'on' : 'off';
	$gucstatus = (isset($_POST["guc_check"]) && filter_var($_POST["guc_check"]) == 'on') ? 'on' : 'off';
	$eu_nu_status = (isset($_POST["eu_nu_check"]) && filter_var($_POST["eu_nu_check"]) == 'on') ? 'on' : 'off';
	$ld_cart_scrollable_status = (isset($_POST['ld_cart_scrollable']) && filter_var($_POST['ld_cart_scrollable']) == 'on') ? 'Y' : 'N';
	$array1 = array('ld_primary_color', 'ld_secondary_color', 'ld_text_color', 'ld_text_color_on_bg', 'ld_primary_color_admin', 'ld_secondary_color_admin', 'ld_text_color_admin', 'ld_hide_faded_already_booked_time_slots', 'ld_guest_user_checkout', 'ld_time_format', 'ld_date_picker_date_format', 'ld_custom_css', 'ld_front_image', 'ld_login_image', 'ld_favicon_image', 'ld_existing_and_new_user_checkout', 'ld_cart_scrollable', 'ld_phone_display_country_code', 'ld_loader', 'ld_custom_gif_loader', 'ld_custom_css_loader', 'ld_calendar_defaultView', 'ld_calendar_firstDay');

	$array2 = array($_POST['ld_primary_color'], $_POST['ld_secondary_color'], $_POST['ld_text_color'], $_POST['ld_text_color_on_bg'], $_POST['ld_primary_color_admin'], $_POST['ld_secondary_color_admin'], $_POST['ld_text_color_admin'], $slotstatus, $gucstatus, $_POST['ld_time_format'], $_POST['ld_date_picker_date_format'], $_POST['cust_css'], $frontimagename, $loginimagename, $favimagename, $eu_nu_status, $ld_cart_scrollable_status, $phone_country_code, $_POST['ld_loader_option'], $ld_frontend_gif_imagename, $_POST['ld_custom_css_loader'], $ld_calendar_defaultView, $ld_calendar_firstDay);

	if ($gucstatus == 'off' && $eu_nu_status == 'off') {
	} else {
		for ($i = 0; $i < sizeof($array1); $i++) {
			if ($i == 12) {
				if ($array2[12] != "") {
					$add3 = $setting->set_option($array1[$i], $array2[$i]);
				}
			} elseif ($i == 13) {
				if ($array2[13] != "") {
					$add3 = $setting->set_option($array1[$i], $array2[$i]);
				}
			} elseif ($i == 14) {
				if ($array2[14] != "") {
					$add3 = $setting->set_option($array1[$i], $array2[$i]);
				}
			} elseif ($i == 20) {
				if ($array2[20] != "") {
					$add3 = $setting->set_option($array1[$i], $array2[$i]);
				}
			} else {
				$add3 = $setting->set_option($array1[$i], $array2[$i]);
			}
		}
		header("location:" . SITE_URL . "admin/settings.php");
	}
	exit();
}
/* save email templates */
for ($kk = 1; $kk <= 18; $kk++) {
	if (isset($_POST['template' . $kk])) {
		$id = filter_var($_POST['hdntemplate' . $kk]);
		$email_template->id = $id;
		$email_template->email_message = base64_encode($_POST['email_message' . $kk]);
		$email_template->update_email_template();
		header("Location:settings.php");
		exit();
	}
}

if (isset($_POST['btn_submit_frontend_labels'])) {
	$update_labels = filter_var($_POST['ld_selected_lang_labels']);
	$language_front = array();
	foreach ($_POST as $key => $value) {
		if (is_numeric(strpos($key, 'ctfrontlabelct'))) {
			$language_front[str_replace('ctfrontlabelct', '', $key)] = urlencode($value);
		}
	}
	$language_front_arr = base64_encode(serialize($language_front));

	if ($setting->check_for_existing_language($update_labels) > 0) {
		$setting->update_labels_languages_per_tab('label_data', $language_front_arr, $update_labels);
	} else {

		$setting->insert_front_labels_languages($language_front_arr, $update_labels);
	}
	header('Location: ' . SITE_URL . "admin/settings.php");
	exit;
}
if (isset($_POST['btn_submit_admin_labels'])) {
	$update_labels = filter_var($_POST['ld_selected_lang_labels']);
	$language_admin = array();
	foreach ($_POST as $key => $value) {
		if (is_numeric(strpos($key, 'ctadminlabelct'))) {
			$language_admin[str_replace('ctadminlabelct', '', $key)] = urlencode($value);
		}
	}
	$language_admin_arr = base64_encode(serialize($language_admin));
	if ($setting->check_for_existing_language($update_labels) > 0) {
		$setting->update_labels_languages_per_tab('admin_labels', $language_admin_arr, $update_labels);
	} else {
		$setting->insert_admin_labels_languages($language_admin_arr, $update_labels);
	}
	header('Location: ' . SITE_URL . "admin/settings.php");
	exit;
}
if (isset($_POST['btn_submit_error_labels'])) {
	$update_labels = filter_var($_POST['ld_selected_lang_labels']);
	$language_error = array();
	foreach ($_POST as $key => $value) {
		if (is_numeric(strpos($key, 'cterrorlabelct'))) {
			$language_error[str_replace('cterrorlabelct', '', $key)] = urlencode($value);
		}
	}
	$language_error_arr = base64_encode(serialize($language_error));
	if ($setting->check_for_existing_language($update_labels) > 0) {
		$setting->update_labels_languages_per_tab('error_labels', $language_error_arr, $update_labels);
	} else {
		$setting->insert_error_labels_languages($language_error_arr, $update_labels);
	}
	header('Location: ' . SITE_URL . "admin/settings.php");
	exit;
}
if (isset($_POST['btn_submit_extra_labels'])) {
	$update_labels = filter_var($_POST['ld_selected_lang_labels']);
	$language_extra = array();
	foreach ($_POST as $key => $value) {
		if (is_numeric(strpos($key, 'ctextralabelct'))) {
			$language_extra[str_replace('ctextralabelct', '', $key)] = urlencode($value);
		}
	}
	$language_extra_arr = base64_encode(serialize($language_extra));
	if ($setting->check_for_existing_language($update_labels) > 0) {
		$setting->update_labels_languages_per_tab('extra_labels', $language_extra_arr, $update_labels);
	} else {
		$setting->insert_extra_labels_languages($language_extra_arr, $update_labels);
	}
	header('Location: ' . SITE_URL . "admin/settings.php");
	exit;
}
if (isset($_POST['btn_submit_ferror_labels'])) {
	$update_labels = filter_var($_POST['ld_selected_lang_labels']);
	$language_front_error = array();
	foreach ($_POST as $key => $value) {
		if (is_numeric(strpos($key, 'ctfr_errorlabelct'))) {
			$language_front_error[str_replace('ctfr_errorlabelct', '', $key)] = urlencode($value);
		}
	}
	$language_front_error_arr = base64_encode(serialize($language_front_error));
	if ($setting->check_for_existing_language($update_labels) > 0) {
		$setting->update_labels_languages_per_tab('front_error_labels', $language_front_error_arr, $update_labels);
	} else {
		$setting->insert_ferror_labels_languages($language_front_error_arr, $update_labels);
	}
	header('Location: ' . SITE_URL . "admin/settings.php");
	exit;
}
?>
<script>
	var payment_status = '<?php echo filter_var($payment_status);	?>';
</script>
<div class="panel lda-panel-default" id="ld-settings">
	<div class="ld-settings ld-left-menu col-md-3 col-sm-3 col-xs-12 col-lg-3">
		<ul class="nav nav-tab nav-stacked" id="lda-settings-nav">
			<li class="active"><a href="#company-details" class="sot-company-details" data-toggle="pill"><i class="fa fa-building-o fa-2x"></i><br /><?php echo filter_var($label_language_values['company']);	?></a></li>
			<li><a href="#general-setting" class="sot-general-setting" data-toggle="pill"><i class="fa fa-cog fa-2x"></i><br /><?php echo filter_var($label_language_values['general']);	?></a></li>
			<li><a href="#appearance-setting" class="sot-appearance-setting" data-toggle="pill"><i class="fa fa-tachometer fa-2x"></i><br /><?php echo filter_var($label_language_values['appearance']);	?></a></li>
			<li><a href="#payment-setting" class="sot-payment-setting" data-toggle="pill"><i class="fa fa-money fa-2x"></i><br /><?php echo filter_var($label_language_values['payments_setting']);	?></a></li>
			<li><a href="#email-setting" class="sot-email-setting" data-toggle="pill"><i class="fa fa-paper-plane fa-2x"></i><br /><?php echo filter_var($label_language_values['email_notification']);	?></a></li>
			<li><a href="#email-template" class="sot-email-template" data-toggle="pill"><i class="fa fa-envelope fa-2x"></i><br /><?php echo filter_var($label_language_values['email_template']);	?></a></li>
			<li><a href="#sms-reminder" class="sot-sms-reminder" data-toggle="pill"><i class="fa fa-mobile fa-2x"></i><br /><?php echo filter_var($label_language_values['sms_notification']);	?></a></li>
			<li><a href="#sms-template" class="sot-sms-template" data-toggle="pill"><i class="fa fa-comments fa-2x"></i><br /><?php echo filter_var($label_language_values['sms_template']);	?></a></li>
			<li><a href="#promocode" class="sot-promocode" data-toggle="pill"><i class="fa fa-tags fa-2x"></i><br /><?php echo filter_var($label_language_values['promocode']);	?></a></li>
			<li><a href="#labels" class="sot-labels" data-toggle="pill"><i class="fa fa-language fa-2x"></i><br /><?php echo filter_var($label_language_values['labels']);	?></a></li>

			<li><a href="#front_tooltips" class="sot-labels" data-toggle="pill"><i class="fa fa-language fa-2x"></i><br /><?php echo filter_var($label_language_values['front_tool_tips']);	?></a></li>
			<li><a href="#manageable-form-fields" class="sot-form-fields" data-toggle="pill"><i class="fa fa-list fa-2x"></i><br /><?php echo filter_var($label_language_values['manageable_form_fields']);	?></a></li>
			<li><a href="#seo-ga" class="sot-form-fields" data-toggle="pill"><i class="fa fa-line-chart fa-2x"></i><br /><?php echo filter_var($label_language_values['SEO']);	?></a></li>
			<?php
			if ($gc_hook->gc_purchase_status() == 'exist') {
				echo filter_var($gc_hook->gc_setting_menu_hook());
			}
			?>
		</ul>
	</div>
	<div class="panel-body">
		<div class="ld-setting-details tab-content col-md-9 col-sm-9 col-lg-9 col-xs-12">
			<div class="company-details tab-pane fade in active" id="company-details">
				<form id="business_setting_form" method="post" type="" class="ld-company-details">
					<div class="panel panel-default">
						<div class="panel-heading lda-top-right">
							<h1 class="panel-title"><?php echo filter_var($label_language_values['company_info_settings']);	?></h1>
							<span class="pull-right lda-setting-fix-btn"> <a id="company_setting" name="" class="btn btn-success"><?php echo filter_var($label_language_values['save_setting']);	?></a></span>
						</div>
						<div class="panel-body pt-50 plr-10">
							<table class="form-inline ld-common-table">
								<tbody>

									<tr>
										<td><label><?php echo filter_var($label_language_values['select_language_to_display']);	?></label></td>
										<td>
											<div class="form-group">
												<select name="ld_setted_language" id="display_language_user" class="selectpicker" data-size="10" data-live-search="true" data-live-search-placeholder="<?php echo filter_var($label_language_values['search']);	?>" style="display: none;">
													<option value=""><?php echo filter_var($label_language_values['set_language']);	?></option>
													<option value="en" <?php echo ($setting->get_option("ld_language") == "en" ? "selected" : "");	?>>English (United States)</option>
													<option value="ary" <?php echo ($setting->get_option("ld_language") == "ary" ? "selected" : "");	?>>العربية المغربية</option>
													<option value="ar" <?php echo ($setting->get_option("ld_language") == "ar" ? "selected" : "");	?>>العربية</option>
													<option value="az" <?php echo ($setting->get_option("ld_language") == "az" ? "selected" : "");	?>>Azərbaycan dili</option>
													<option value="azb" <?php echo ($setting->get_option("ld_language") == "azb" ? "selected" : "");	?>>گؤنئی آذربایجان</option>
													<option value="bg_BG" <?php echo ($setting->get_option("ld_language") == "bg_BG" ? "selected" : "");	?>>Български</option>
													<option value="bn_BD" <?php echo ($setting->get_option("ld_language") == "bn_BD" ? "selected" : "");	?>>বাংলা</option>
													<option value="bs_BA" <?php echo ($setting->get_option("ld_language") == "bs_BA" ? "selected" : "");	?>>Bosanski</option>
													<option value="ca" <?php echo ($setting->get_option("ld_language") == "ca" ? "selected" : "");	?>>Català</option>
													<option value="ceb" <?php echo ($setting->get_option("ld_language") == "ceb" ? "selected" : "");	?>>Cebuano</option>
													<option value="cs_CZ" <?php echo ($setting->get_option("ld_language") == "cs_CZ" ? "selected" : "");	?>>Čeština‎</option>
													<option value="cy" <?php echo ($setting->get_option("ld_language") == "cy" ? "selected" : "");	?>>Cymraeg</option>
													<option value="da_DK" <?php echo ($setting->get_option("ld_language") == "da_DK" ? "selected" : "");	?>>Dansk</option>
													<option value="de_CH_informal" <?php echo ($setting->get_option("ld_language") == "de_CH_informal" ? "selected" : "");	?>>Deutsch (Schweiz, Du)</option>
													<option value="de_DE_formal" <?php echo ($setting->get_option("ld_language") == "de_DE_formal" ? "selected" : "");	?>>Deutsch (Sie)</option>
													<option value="de_DE" <?php echo ($setting->get_option("ld_language") == "de_DE" ? "selected" : "");	?>>Deutsch</option>
													<option value="de_CH" <?php echo ($setting->get_option("ld_language") == "de_CH" ? "selected" : "");	?>>Deutsch (Schweiz)</option>
													<option value="el" <?php echo ($setting->get_option("ld_language") == "el" ? "selected" : "");	?>>Ελληνικά</option>
													<option value="en_CA" <?php echo ($setting->get_option("ld_language") == "en_CA" ? "selected" : "");	?>>English (Canada)</option>
													<option value="en_GB" <?php echo ($setting->get_option("ld_language") == "en_GB" ? "selected" : "");	?>>English (UK)</option>
													<option value="en_NZ" <?php echo ($setting->get_option("ld_language") == "en_NZ" ? "selected" : "");	?>>English (New Zealand)</option>
													<option value="en_ZA" <?php echo ($setting->get_option("ld_language") == "en_ZA" ? "selected" : "");	?>>English (South Africa)</option>
													<option value="en_AU" <?php echo ($setting->get_option("ld_language") == "en_AU" ? "selected" : "");	?>>English (Australia)</option>
													<option value="eo" <?php echo ($setting->get_option("ld_language") == "eo" ? "selected" : "");	?>>Esperanto</option>
													<option value="es_ES" <?php echo ($setting->get_option("ld_language") == "es_ES" ? "selected" : "");	?>>Español</option>
													<option value="et" <?php echo ($setting->get_option("ld_language") == "et" ? "selected" : "");	?>>Eesti</option>
													<option value="eu" <?php echo ($setting->get_option("ld_language") == "eu" ? "selected" : "");	?>>Euskara</option>
													<option value="fa_IR" <?php echo ($setting->get_option("ld_language") == "fa_IR" ? "selected" : "");	?>>فارسی</option>
													<option value="fi" <?php echo ($setting->get_option("ld_language") == "fi" ? "selected" : "");	?>>Suomi</option>
													<option value="fr_FR" <?php echo ($setting->get_option("ld_language") == "fr_FR" ? "selected" : "");	?>>Français</option>
													<option value="gd" <?php echo ($setting->get_option("ld_language") == "gd" ? "selected" : "");	?>>Gàidhlig</option>
													<option value="gl_ES" <?php echo ($setting->get_option("ld_language") == "gl_ES" ? "selected" : "");	?>>Galego</option>
													<option value="gu" <?php echo ($setting->get_option("ld_language") == "gu" ? "selected" : "");	?>>ગુજરાતી</option>
													<option value="haz" <?php echo ($setting->get_option("ld_language") == "haz" ? "selected" : "");	?>>هزاره گی</option>
													<option value="hi_IN" <?php echo ($setting->get_option("ld_language") == "hi_IN" ? "selected" : "");	?>>हिन्दी</option>
													<option value="hr" <?php echo ($setting->get_option("ld_language") == "hr" ? "selected" : "");	?>>Hrvatski</option>
													<option value="hu_HU" <?php echo ($setting->get_option("ld_language") == "hu_HU" ? "selected" : "");	?>>Magyar</option>
													<option value="hy" <?php echo ($setting->get_option("ld_language") == "hy" ? "selected" : "");	?>>Հայերեն</option>
													<option value="id_ID" <?php echo ($setting->get_option("ld_language") == "id_ID" ? "selected" : "");	?>>Bahasa Indonesia</option>
													<option value="is_IS" <?php echo ($setting->get_option("ld_language") == "is_IS" ? "selected" : "");	?>>Íslenska</option>
													<option value="it_IT" <?php echo ($setting->get_option("ld_language") == "it_IT" ? "selected" : "");	?>>Italiano</option>
													<option value="ja" <?php echo ($setting->get_option("ld_language") == "ja" ? "selected" : "");	?>>日本語</option>
													<option value="ka_GE" <?php echo ($setting->get_option("ld_language") == "ka_GE" ? "selected" : "");	?>>ქართული</option>
													<option value="ko_KR" <?php echo ($setting->get_option("ld_language") == "ko_KR" ? "selected" : "");	?>>한국어</option>
													<option value="lt_LT" <?php echo ($setting->get_option("ld_language") == "lt_LT" ? "selected" : "");	?>>Lietuvių kalba</option>
													<option value="lv" <?php echo ($setting->get_option("ld_language") == "lv" ? "selected" : "");	?>>Latviešu valoda</option>
													<option value="mk_MK" <?php echo ($setting->get_option("ld_language") == "mk_MK" ? "selected" : "");	?>>Македонски јазик</option>
													<option value="mr" <?php echo ($setting->get_option("ld_language") == "mr" ? "selected" : "");	?>>मराठी</option>
													<option value="ms_MY" <?php echo ($setting->get_option("ld_language") == "ms_MY" ? "selected" : "");	?>>Bahasa Melayu</option>
													<option value="my_MM" <?php echo ($setting->get_option("ld_language") == "my_MM" ? "selected" : "");	?>>ဗမာစာ</option>
													<option value="nb_NO" <?php echo ($setting->get_option("ld_language") == "nb_NO" ? "selected" : "");	?>>Norsk bokmål</option>
													<option value="nl_NL" <?php echo ($setting->get_option("ld_language") == "nl_NL" ? "selected" : "");	?>>Nederlands</option>
													<option value="nl_NL_formal" <?php echo ($setting->get_option("ld_language") == "nl_NL_formal" ? "selected" : "");	?>>Nederlands (Formeel)</option>
													<option value="nn_NO" <?php echo ($setting->get_option("ld_language") == "nn_NO" ? "selected" : "");	?>>Norsk nynorsk</option>
													<option value="oci" <?php echo ($setting->get_option("ld_language") == "oci" ? "selected" : "");	?>>Occitan</option>
													<option value="pl_PL" <?php echo ($setting->get_option("ld_language") == "pl_PL" ? "selected" : "");	?>>Polski</option>
													<option value="pt_PT" <?php echo ($setting->get_option("ld_language") == "pt_PT" ? "selected" : "");	?>>Português</option>
													<option value="pt_BR" <?php echo ($setting->get_option("ld_language") == "pt_BR" ? "selected" : "");	?>>Português do Brasil</option>
													<option value="ro_RO" <?php echo ($setting->get_option("ld_language") == "ro_RO" ? "selected" : "");	?>>Română</option>
													<option value="ru_RU" <?php echo ($setting->get_option("ld_language") == "ru_RU" ? "selected" : "");	?>>Русский</option>
													<option value="sk_SK" <?php echo ($setting->get_option("ld_language") == "sk_SK" ? "selected" : "");	?>>Slovenčina</option>
													<option value="sl_SI" <?php echo ($setting->get_option("ld_language") == "sl_SI" ? "selected" : "");	?>>Slovenščina</option>
													<option value="sq" <?php echo ($setting->get_option("ld_language") == "sq" ? "selected" : "");	?>>Shqip</option>
													<option value="sr_RS" <?php echo ($setting->get_option("ld_language") == "sr_RS" ? "selected" : "");	?>>Српски језик</option>
													<option value="sv_SE" <?php echo ($setting->get_option("ld_language") == "sv_SE" ? "selected" : "");	?>>Svenska</option>
													<option value="szl" <?php echo ($setting->get_option("ld_language") == "szl" ? "selected" : "");	?>>Ślōnskŏ gŏdka</option>
													<option value="th" <?php echo ($setting->get_option("ld_language") == "th" ? "selected" : "");	?>>ไทย</option>
													<option value="tl" <?php echo ($setting->get_option("ld_language") == "tl" ? "selected" : "");	?>>Tagalog</option>
													<option value="tr_TR" <?php echo ($setting->get_option("ld_language") == "tr_TR" ? "selected" : "");	?>>Türkçe</option>
													<option value="ug_CN" <?php echo ($setting->get_option("ld_language") == "ug_CN" ? "selected" : "");	?>>Uyƣurqə</option>
													<option value="uk" <?php echo ($setting->get_option("ld_language") == "uk" ? "selected" : "");	?>>Українська</option>
													<option value="vi" <?php echo ($setting->get_option("ld_language") == "vi" ? "selected" : "");	?>>Tiếng Việt</option>
													<option value="zh_TW" <?php echo ($setting->get_option("ld_language") == "zh_TW" ? "selected" : "");	?>>繁體中文</option>
													<option value="zh_HK" <?php echo ($setting->get_option("ld_language") == "zh_HK" ? "selected" : "");	?>>香港中文版</option>
													<option value="zh_CN" <?php echo ($setting->get_option("ld_language") == "zh_CN" ? "selected" : "");	?>>简体中文</option>
												</select>
											</div>
										</td>
									</tr>


									<tr>
										<td><label><?php echo filter_var($label_language_values['timezone']);	?></label></td>
										<td>
											<div class="form-group">
												<select class="selectpicker" id="time-zone" data-live-search="true" data-live-search-placeholder="<?php echo filter_var($label_language_values['search']);	?>" data-size="10" style="display: none;">
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Niue') {
																echo filter_var("selected");
															} ?> value="Pacific/Niue" data-posinset="3">(GMT-11:00) Niue Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Pago_Pago') {
																echo filter_var("selected");
															} ?> value="Pacific/Pago_Pago" data-posinset="4">(GMT-11:00) Samoa Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Rarotonga') {
																echo filter_var("selected");
															} ?> value="Pacific/Rarotonga" data-posinset="5">(GMT-10:00) Cook Islands Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Honolulu') {
																echo filter_var("selected");
															} ?> value="Pacific/Honolulu" data-posinset="6">(GMT-10:00) Hawaii-Aleutian Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Tahiti') {
																echo filter_var("selected");
															} ?> value="Pacific/Tahiti" data-posinset="7">(GMT-10:00) Tahiti Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Marquesas') {
																echo filter_var("selected");
															} ?> value="Pacific/Marquesas" data-posinset="8">(GMT-09:30) Marquesas Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Gambier') {
																echo filter_var("selected");
															} ?> value="Pacific/Gambier" data-posinset="9">(GMT-09:30) Gambier Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Anchorage') {
																echo filter_var("selected");
															} ?> value="America/Anchorage" data-posinset="10">(GMT-08:00) Alaska Time - Anchorage</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Pitcairn') {
																echo filter_var("selected");
															} ?> value="Pacific/Pitcairn" data-posinset="11">(GMT-08:00) Pitcairn Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Hermosillo') {
																echo filter_var("selected");
															} ?> value="America/Hermosillo" data-posinset="12">(GMT-07:00) Mexican Pacific Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Dawson_Creek') {
																echo filter_var("selected");
															} ?> value="America/Dawson_Creek" data-posinset="13">(GMT-07:00) Mountain Standard Time - Dawson Creek</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Phoenix') {
																echo filter_var("selected");
															} ?> value="America/Phoenix" data-posinset="14">(GMT-07:00) Mountain Standard Time - Phoenix</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Dawson') {
																echo filter_var("selected");
															} ?> value="America/Dawson" data-posinset="15">(GMT-07:00) Pacific Time - Dawson</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Los_Angeles') {
																echo filter_var("selected");
															} ?> value="America/Los_Angeles" data-posinset="16">(GMT-07:00) Pacific Time - Los Angeles</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Tijuana') {
																echo filter_var("selected");
															} ?> value="America/Tijuana" data-posinset="17">(GMT-07:00) Pacific Time - Tijuana</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Vancouver') {
																echo filter_var("selected");
															} ?> value="America/Vancouver" data-posinset="18">(GMT-07:00) Pacific Time - Vancouver</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Whitehorse') {
																echo filter_var("selected");
															} ?> value="America/Whitehorse" data-posinset="19">(GMT-07:00) Pacific Time - Whitehorse</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Belize') {
																echo filter_var("selected");
															} ?> value="America/Belize" data-posinset="20">(GMT-06:00) Central Standard Time - Belize</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Costa_Rica') {
																echo filter_var("selected");
															} ?> value="America/Costa_Rica" data-posinset="21">(GMT-06:00) Central Standard Time - Costa Rica</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/El_Salvador') {
																echo filter_var("selected");
															} ?> value="America/El_Salvador" data-posinset="22">(GMT-06:00) Central Standard Time - El Salvador</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Guatemala') {
																echo filter_var("selected");
															} ?> value="America/Guatemala" data-posinset="23">(GMT-06:00) Central Standard Time - Guatemala</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Managua') {
																echo filter_var("selected");
															} ?> value="America/Managua" data-posinset="24">(GMT-06:00) Central Standard Time - Managua</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Regina') {
																echo filter_var("selected");
															} ?> value="America/Regina" data-posinset="25">(GMT-06:00) Central Standard Time - Regina</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Tegucigalpa') {
																echo filter_var("selected");
															} ?> value="America/Tegucigalpa" data-posinset="26">(GMT-06:00) Central Standard Time - Tegucigalpa</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Easter') {
																echo filter_var("selected");
															} ?> value="Pacific/Easter" data-posinset="27">(GMT-06:00) Easter Island Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Galapagos') {
																echo filter_var("selected");
															} ?> value="Pacific/Galapagos" data-posinset="28">(GMT-06:00) Galapagos Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Mazatlan') {
																echo filter_var("selected");
															} ?> value="America/Mazatlan" data-posinset="29">(GMT-06:00) Mexican Pacific Time - Mazatlan</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Boise') {
																echo filter_var("selected");
															} ?> value="America/Boise" data-posinset="30">(GMT-06:00) Mountain Time - Boise</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Denver') {
																echo filter_var("selected");
															} ?> value="America/Denver" data-posinset="31">(GMT-06:00) Mountain Time - Denver</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Edmonton') {
																echo filter_var("selected");
															} ?> value="America/Edmonton" data-posinset="32">(GMT-06:00) Mountain Time - Edmonton</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Yellowknife') {
																echo filter_var("selected");
															} ?> value="America/Yellowknife" data-posinset="33">(GMT-06:00) Mountain Time - Yellowknife</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Rio_Branco') {
																echo filter_var("selected");
															} ?> value="America/Rio_Branco" data-posinset="34">(GMT-05:00) Acre Standard Time - Rio Branco</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Chicago') {
																echo filter_var("selected");
															} ?> value="America/Chicago" data-posinset="35">(GMT-05:00) Central Time - Chicago</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Mexico_City') {
																echo filter_var("selected");
															} ?> value="America/Mexico_City" data-posinset="36">(GMT-05:00) Central Time - Mexico City</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Winnipeg') {
																echo filter_var("selected");
															} ?> value="America/Winnipeg" data-posinset="37">(GMT-05:00) Central Time - Winnipeg</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Bogota') {
																echo filter_var("selected");
															} ?> value="America/Bogota" data-posinset="38">(GMT-05:00) Colombia Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Cancun') {
																echo filter_var("selected");
															} ?> value="America/Cancun" data-posinset="39">(GMT-05:00) Eastern Standard Time - Cancun</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Jamaica') {
																echo filter_var("selected");
															} ?> value="America/Jamaica" data-posinset="40">(GMT-05:00) Eastern Standard Time - Jamaica</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Panama') {
																echo filter_var("selected");
															} ?> value="America/Panama" data-posinset="41">(GMT-05:00) Eastern Standard Time - Panama</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Guayaquil') {
																echo filter_var("selected");
															} ?> value="America/Guayaquil" data-posinset="42">(GMT-05:00) Ecuador Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Lima') {
																echo filter_var("selected");
															} ?> value="America/Lima" data-posinset="43">(GMT-05:00) Peru Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Boa_Vista') {
																echo filter_var("selected");
															} ?> value="America/Boa_Vista" data-posinset="44">(GMT-04:00) Amazon Standard Time - Boa Vista</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Manaus') {
																echo filter_var("selected");
															} ?> value="America/Manaus" data-posinset="45">(GMT-04:00) Amazon Standard Time - Manaus</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Porto_Velho') {
																echo filter_var("selected");
															} ?> value="America/Porto_Velho" data-posinset="46">(GMT-04:00) Amazon Standard Time - Porto Velho</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Campo_Grande') {
																echo filter_var("selected");
															} ?> value="America/Campo_Grande" data-posinset="47">(GMT-04:00) Amazon Time - Campo Grande</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Cuiaba') {
																echo filter_var("selected");
															} ?> value="America/Cuiaba" data-posinset="48">(GMT-04:00) Amazon Time - Cuiaba</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Barbados') {
																echo filter_var("selected");
															} ?> value="America/Barbados" data-posinset="49">(GMT-04:00) Atlantic Standard Time - Barbados</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Curacao') {
																echo filter_var("selected");
															} ?> value="America/Curacao" data-posinset="50">(GMT-04:00) Atlantic Standard Time - Curaçao</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Martinique') {
																echo filter_var("selected");
															} ?> value="America/Martinique" data-posinset="51">(GMT-04:00) Atlantic Standard Time - Martinique</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Port_of_Spain') {
																echo filter_var("selected");
															} ?> value="America/Port_of_Spain" data-posinset="52">(GMT-04:00) Atlantic Standard Time - Port of Spain</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Puerto_Rico') {
																echo filter_var("selected");
															} ?> value="America/Puerto_Rico" data-posinset="53">(GMT-04:00) Atlantic Standard Time - Puerto Rico</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Santo_Domingo') {
																echo filter_var("selected");
															} ?> value="America/Santo_Domingo" data-posinset="54">(GMT-04:00) Atlantic Standard Time - Santo Domingo</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/La_Paz') {
																echo filter_var("selected");
															} ?> value="America/La_Paz" data-posinset="55">(GMT-04:00) Bolivia Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Santiago') {
																echo filter_var("selected");
															} ?> value="America/Santiago" data-posinset="56">(GMT-04:00) Chile Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Havana') {
																echo filter_var("selected");
															} ?> value="America/Havana" data-posinset="57">(GMT-04:00) Cuba Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Detroit') {
																echo filter_var("selected");
															} ?> value="America/Detroit" data-posinset="58">(GMT-04:00) Eastern Time - Detroit</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Grand_Turk') {
																echo filter_var("selected");
															} ?> value="America/Grand_Turk" data-posinset="59">(GMT-04:00) Eastern Time - Grand Turk</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Iqaluit') {
																echo filter_var("selected");
															} ?> value="America/Iqaluit" data-posinset="60">(GMT-04:00) Eastern Time - Iqaluit</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Nassau') {
																echo filter_var("selected");
															} ?> value="America/Nassau" data-posinset="61">(GMT-04:00) Eastern Time - Nassau</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/New_York') {
																echo filter_var("selected");
															} ?> value="America/New_York" data-posinset="62">(GMT-04:00) Eastern Time - New York</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Port-au-Prince') {
																echo filter_var("selected");
															} ?> value="America/Port-au-Prince" data-posinset="63">(GMT-04:00) Eastern Time - Port-au-Prince</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Toronto') {
																echo filter_var("selected");
															} ?> value="America/Toronto" data-posinset="64">(GMT-04:00) Eastern Time - Toronto</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Guyana') {
																echo filter_var("selected");
															} ?> value="America/Guyana" data-posinset="65">(GMT-04:00) Guyana Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Asuncion') {
																echo filter_var("selected");
															} ?> value="America/Asuncion" data-posinset="66">(GMT-04:00) Paraguay Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Caracas') {
																echo filter_var("selected");
															} ?> value="America/Caracas" data-posinset="67">(GMT-04:00) Venezuela Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Argentina/Buenos_Aires') {
																echo filter_var("selected");
															} ?> value="America/Argentina/Buenos_Aires" data-posinset="68">(GMT-03:00) Argentina Standard Time - Buenos Aires</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Argentina/Cordoba') {
																echo filter_var("selected");
															} ?> value="America/Argentina/Cordoba" data-posinset="69">(GMT-03:00) Argentina Standard Time - Cordoba</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Atlantic/Bermuda') {
																echo filter_var("selected");
															} ?> value="Atlantic/Bermuda" data-posinset="70">(GMT-03:00) Atlantic Time - Bermuda</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Halifax') {
																echo filter_var("selected");
															} ?> value="America/Halifax" data-posinset="71">(GMT-03:00) Atlantic Time - Halifax</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Thule') {
																echo filter_var("selected");
															} ?> value="America/Thule" data-posinset="72">(GMT-03:00) Atlantic Time - Thule</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Araguaina') {
																echo filter_var("selected");
															} ?> value="America/Araguaina" data-posinset="73">(GMT-03:00) Brasilia Standard Time - Araguaina</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Bahia') {
																echo filter_var("selected");
															} ?> value="America/Bahia" data-posinset="74">(GMT-03:00) Brasilia Standard Time - Bahia</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Belem') {
																echo filter_var("selected");
															} ?> value="America/Belem" data-posinset="75">(GMT-03:00) Brasilia Standard Time - Belem</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Fortaleza') {
																echo filter_var("selected");
															} ?> value="America/Fortaleza" data-posinset="76">(GMT-03:00) Brasilia Standard Time - Fortaleza</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Maceio') {
																echo filter_var("selected");
															} ?> value="America/Maceio" data-posinset="77">(GMT-03:00) Brasilia Standard Time - Maceio</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Recife') {
																echo filter_var("selected");
															} ?> value="America/Recife" data-posinset="78">(GMT-03:00) Brasilia Standard Time - Recife</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Sao_Paulo') {
																echo filter_var("selected");
															} ?> value="America/Sao_Paulo" data-posinset="79">(GMT-03:00) Brasilia Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Atlantic/Stanley') {
																echo filter_var("selected");
															} ?> value="Atlantic/Stanley" data-posinset="80">(GMT-03:00) Falkland Islands Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Cayenne') {
																echo filter_var("selected");
															} ?> value="America/Cayenne" data-posinset="81">(GMT-03:00) French Guiana Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Antarctica/Palmer') {
																echo filter_var("selected");
															} ?> value="Antarctica/Palmer" data-posinset="82">(GMT-03:00) Palmer Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Punta_Arenas') {
																echo filter_var("selected");
															} ?> value="America/Punta_Arenas" data-posinset="83">(GMT-03:00) Punta Arenas Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Antarctica/Rothera') {
																echo filter_var("selected");
															} ?> value="Antarctica/Rothera" data-posinset="84">(GMT-03:00) Rothera Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Paramaribo') {
																echo filter_var("selected");
															} ?> value="America/Paramaribo" data-posinset="85">(GMT-03:00) Suriname Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Montevideo') {
																echo filter_var("selected");
															} ?> value="America/Montevideo" data-posinset="86">(GMT-03:00) Uruguay Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/St_Johns') {
																echo filter_var("selected");
															} ?> value="America/St_Johns" data-posinset="87">(GMT-02:30) Newfoundland Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Noronha') {
																echo filter_var("selected");
															} ?> value="America/Noronha" data-posinset="88">(GMT-02:00) Fernando de Noronha Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Atlantic/South_Georgia') {
																echo filter_var("selected");
															} ?> value="Atlantic/South_Georgia" data-posinset="89">(GMT-02:00) South Georgia Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Miquelon') {
																echo filter_var("selected");
															} ?> value="America/Miquelon" data-posinset="90">(GMT-02:00) St. Pierre &amp; Miquelon Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Godthab') {
																echo filter_var("selected");
															} ?> value="America/Godthab" data-posinset="91">(GMT-02:00) West Greenland Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Atlantic/Cape_Verde') {
																echo filter_var("selected");
															} ?> value="Atlantic/Cape_Verde" data-posinset="92">(GMT-01:00) Cape Verde Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Atlantic/Azores') {
																echo filter_var("selected");
															} ?> value="Atlantic/Azores" data-posinset="93">(GMT+00:00) Azores Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Scoresbysund') {
																echo filter_var("selected");
															} ?> value="America/Scoresbysund" data-posinset="94">(GMT+00:00) East Greenland Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Etc/GMT') {
																echo filter_var("selected");
															} ?> value="Etc/GMT" data-posinset="95">(GMT+00:00) Greenwich Mean Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Abidjan') {
																echo filter_var("selected");
															} ?> value="Africa/Abidjan" data-posinset="96">(GMT+00:00) Greenwich Mean Time - Abidjan</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Accra') {
																echo filter_var("selected");
															} ?> value="Africa/Accra" data-posinset="97">(GMT+00:00) Greenwich Mean Time - Accra</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Bissau') {
																echo filter_var("selected");
															} ?> value="Africa/Bissau" data-posinset="98">(GMT+00:00) Greenwich Mean Time - Bissau</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'America/Danmarkshavn') {
																echo filter_var("selected");
															} ?> value="America/Danmarkshavn" data-posinset="99">(GMT+00:00) Greenwich Mean Time - Danmarkshavn</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Monrovia') {
																echo filter_var("selected");
															} ?> value="Africa/Monrovia" data-posinset="100">(GMT+00:00) Greenwich Mean Time - Monrovia</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Atlantic/Reykjavik') {
																echo filter_var("selected");
															} ?> value="Atlantic/Reykjavik" data-posinset="101">(GMT+00:00) Greenwich Mean Time - Reykjavik</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'UTC') {
																echo filter_var("selected");
															} ?> value="UTC" data-posinset="102">UTC</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Algiers') {
																echo filter_var("selected");
															} ?> value="Africa/Algiers" data-posinset="103">(GMT+01:00) Central European Standard Time - Algiers</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Tunis') {
																echo filter_var("selected");
															} ?> value="Africa/Tunis" data-posinset="104">(GMT+01:00) Central European Standard Time - Tunis</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Dublin') {
																echo filter_var("selected");
															} ?> value="Europe/Dublin" data-posinset="105">(GMT+01:00) Ireland Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/London') {
																echo filter_var("selected");
															} ?> value="Europe/London" data-posinset="106">(GMT+01:00) United Kingdom Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Lagos') {
																echo filter_var("selected");
															} ?> value="Africa/Lagos" data-posinset="107">(GMT+01:00) West Africa Standard Time - Lagos</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Ndjamena') {
																echo filter_var("selected");
															} ?> value="Africa/Ndjamena" data-posinset="108">(GMT+01:00) West Africa Standard Time - Ndjamena</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Sao_Tome') {
																echo filter_var("selected");
															} ?> value="Africa/Sao_Tome" data-posinset="109">(GMT+01:00) West Africa Standard Time - São Tomé</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Atlantic/Canary') {
																echo filter_var("selected");
															} ?> value="Atlantic/Canary" data-posinset="110">(GMT+01:00) Western European Time - Canary</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Casablanca') {
																echo filter_var("selected");
															} ?> value="Africa/Casablanca" data-posinset="111">(GMT+01:00) Western European Time - Casablanca</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/El_Aaiun') {
																echo filter_var("selected");
															} ?> value="Africa/El_Aaiun" data-posinset="112">(GMT+01:00) Western European Time - El Aaiun</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Atlantic/Faroe') {
																echo filter_var("selected");
															} ?> value="Atlantic/Faroe" data-posinset="113">(GMT+01:00) Western European Time - Faroe</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Lisbon') {
																echo filter_var("selected");
															} ?> value="Europe/Lisbon" data-posinset="114">(GMT+01:00) Western European Time - Lisbon</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Khartoum') {
																echo filter_var("selected");
															} ?> value="Africa/Khartoum" data-posinset="115">(GMT+02:00) Central Africa Time - Khartoum</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Maputo') {
																echo filter_var("selected");
															} ?> value="Africa/Maputo" data-posinset="116">(GMT+02:00) Central Africa Time - Maputo</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Windhoek') {
																echo filter_var("selected");
															} ?> value="Africa/Windhoek" data-posinset="117">(GMT+02:00) Central Africa Time - Windhoek</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Amsterdam') {
																echo filter_var("selected");
															} ?> value="Europe/Amsterdam" data-posinset="118">(GMT+02:00) Central European Time - Amsterdam</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Andorra') {
																echo filter_var("selected");
															} ?> value="Europe/Andorra" data-posinset="119">(GMT+02:00) Central European Time - Andorra</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Belgrade') {
																echo filter_var("selected");
															} ?> value="Europe/Belgrade" data-posinset="120">(GMT+02:00) Central European Time - Belgrade</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Berlin') {
																echo filter_var("selected");
															} ?> value="Europe/Berlin" data-posinset="121">(GMT+02:00) Central European Time - Berlin</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Brussels') {
																echo filter_var("selected");
															} ?> value="Europe/Brussels" data-posinset="122">(GMT+02:00) Central European Time - Brussels</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Budapest') {
																echo filter_var("selected");
															} ?> value="Europe/Budapest" data-posinset="123">(GMT+02:00) Central European Time - Budapest</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Ceuta') {
																echo filter_var("selected");
															} ?> value="Africa/Ceuta" data-posinset="124">(GMT+02:00) Central European Time - Ceuta</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Copenhagen') {
																echo filter_var("selected");
															} ?> value="Europe/Copenhagen" data-posinset="125">(GMT+02:00) Central European Time - Copenhagen</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Gibraltar') {
																echo filter_var("selected");
															} ?> value="Europe/Gibraltar" data-posinset="126">(GMT+02:00) Central European Time - Gibraltar</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Luxembourg') {
																echo filter_var("selected");
															} ?> value="Europe/Luxembourg" data-posinset="127">(GMT+02:00) Central European Time - Luxembourg</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Madrid') {
																echo filter_var("selected");
															} ?> value="Europe/Madrid" data-posinset="128">(GMT+02:00) Central European Time - Madrid</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Malta') {
																echo filter_var("selected");
															} ?> value="Europe/Malta" data-posinset="129">(GMT+02:00) Central European Time - Malta</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Monaco') {
																echo filter_var("selected");
															} ?> value="Europe/Monaco" data-posinset="130">(GMT+02:00) Central European Time - Monaco</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Oslo') {
																echo filter_var("selected");
															} ?> value="Europe/Oslo" data-posinset="131">(GMT+02:00) Central European Time - Oslo</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Paris') {
																echo filter_var("selected");
															} ?> value="Europe/Paris" data-posinset="132">(GMT+02:00) Central European Time - Paris</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Prague') {
																echo filter_var("selected");
															} ?> value="Europe/Prague" data-posinset="133">(GMT+02:00) Central European Time - Prague</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Rome') {
																echo filter_var("selected");
															} ?> value="Europe/Rome" data-posinset="134">(GMT+02:00) Central European Time - Rome</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Stockholm') {
																echo filter_var("selected");
															} ?> value="Europe/Stockholm" data-posinset="135">(GMT+02:00) Central European Time - Stockholm</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Tirane') {
																echo filter_var("selected");
															} ?> value="Europe/Tirane" data-posinset="136">(GMT+02:00) Central European Time - Tirane</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Vienna') {
																echo filter_var("selected");
															} ?> value="Europe/Vienna" data-posinset="137">(GMT+02:00) Central European Time - Vienna</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Warsaw') {
																echo filter_var("selected");
															} ?> value="Europe/Warsaw" data-posinset="138">(GMT+02:00) Central European Time - Warsaw</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Zurich') {
																echo filter_var("selected");
															} ?> value="Europe/Zurich" data-posinset="139">(GMT+02:00) Central European Time - Zurich</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Cairo') {
																echo filter_var("selected");
															} ?> value="Africa/Cairo" data-posinset="140">(GMT+02:00) Eastern European Standard Time - Cairo</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Kaliningrad') {
																echo filter_var("selected");
															} ?> value="Europe/Kaliningrad" data-posinset="141">(GMT+02:00) Eastern European Standard Time - Kaliningrad</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Tripoli') {
																echo filter_var("selected");
															} ?> value="Africa/Tripoli" data-posinset="142">(GMT+02:00) Eastern European Standard Time - Tripoli</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Johannesburg') {
																echo filter_var("selected");
															} ?> value="Africa/Johannesburg" data-posinset="143">(GMT+02:00) South Africa Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Baghdad') {
																echo filter_var("selected");
															} ?> value="Asia/Baghdad" data-posinset="144">(GMT+03:00) Arabian Standard Time - Baghdad</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Qatar') {
																echo filter_var("selected");
															} ?> value="Asia/Qatar" data-posinset="145">(GMT+03:00) Arabian Standard Time - Qatar</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Riyadh') {
																echo filter_var("selected");
															} ?> value="Asia/Riyadh" data-posinset="146">(GMT+03:00) Arabian Standard Time - Riyadh</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Africa/Nairobi') {
																echo filter_var("selected");
															} ?> value="Africa/Nairobi" data-posinset="147">(GMT+03:00) East Africa Time - Nairobi</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Amman') {
																echo filter_var("selected");
															} ?> value="Asia/Amman" data-posinset="148">(GMT+03:00) Eastern European Time - Amman</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Athens') {
																echo filter_var("selected");
															} ?> value="Europe/Athens" data-posinset="149">(GMT+03:00) Eastern European Time - Athens</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Beirut') {
																echo filter_var("selected");
															} ?> value="Asia/Beirut" data-posinset="150">(GMT+03:00) Eastern European Time - Beirut</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Bucharest') {
																echo filter_var("selected");
															} ?> value="Europe/Bucharest" data-posinset="151">(GMT+03:00) Eastern European Time - Bucharest</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Chisinau') {
																echo filter_var("selected");
															} ?> value="Europe/Chisinau" data-posinset="152">(GMT+03:00) Eastern European Time - Chisinau</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Damascus') {
																echo filter_var("selected");
															} ?> value="Asia/Damascus" data-posinset="153">(GMT+03:00) Eastern European Time - Damascus</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Gaza') {
																echo filter_var("selected");
															} ?> value="Asia/Gaza" data-posinset="154">(GMT+03:00) Eastern European Time - Gaza</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Helsinki') {
																echo filter_var("selected");
															} ?> value="Europe/Helsinki" data-posinset="155">(GMT+03:00) Eastern European Time - Helsinki</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Kiev') {
																echo filter_var("selected");
															} ?> value="Europe/Kiev" data-posinset="156">(GMT+03:00) Eastern European Time - Kiev</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Nicosia') {
																echo filter_var("selected");
															} ?> value="Asia/Nicosia" data-posinset="157">(GMT+03:00) Eastern European Time - Nicosia</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Riga') {
																echo filter_var("selected");
															} ?> value="Europe/Riga" data-posinset="158">(GMT+03:00) Eastern European Time - Riga</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Sofia') {
																echo filter_var("selected");
															} ?> value="Europe/Sofia" data-posinset="159">(GMT+03:00) Eastern European Time - Sofia</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Tallinn') {
																echo filter_var("selected");
															} ?> value="Europe/Tallinn" data-posinset="160">(GMT+03:00) Eastern European Time - Tallinn</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Vilnius') {
																echo filter_var("selected");
															} ?> value="Europe/Vilnius" data-posinset="161">(GMT+03:00) Eastern European Time - Vilnius</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Jerusalem') {
																echo filter_var("selected");
															} ?> value="Asia/Jerusalem" data-posinset="162">(GMT+03:00) Israel Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Minsk') {
																echo filter_var("selected");
															} ?> value="Europe/Minsk" data-posinset="163">(GMT+03:00) Moscow Standard Time - Minsk</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Moscow') {
																echo filter_var("selected");
															} ?> value="Europe/Moscow" data-posinset="164">(GMT+03:00) Moscow Standard Time - Moscow</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Antarctica/Syowa') {
																echo filter_var("selected");
															} ?> value="Antarctica/Syowa" data-posinset="165">(GMT+03:00) Syowa Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Istanbul') {
																echo filter_var("selected");
															} ?> value="Europe/Istanbul" data-posinset="166">(GMT+03:00) Turkey Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Yerevan') {
																echo filter_var("selected");
															} ?> value="Asia/Yerevan" data-posinset="167">(GMT+04:00) Armenia Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Baku') {
																echo filter_var("selected");
															} ?> value="Asia/Baku" data-posinset="168">(GMT+04:00) Azerbaijan Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Tbilisi') {
																echo filter_var("selected");
															} ?> value="Asia/Tbilisi" data-posinset="169">(GMT+04:00) Georgia Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Dubai') {
																echo filter_var("selected");
															} ?> value="Asia/Dubai" data-posinset="170">(GMT+04:00) Gulf Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Indian/Mauritius') {
																echo filter_var("selected");
															} ?> value="Indian/Mauritius" data-posinset="171">(GMT+04:00) Mauritius Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Indian/Reunion') {
																echo filter_var("selected");
															} ?> value="Indian/Reunion" data-posinset="172">(GMT+04:00) Réunion Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Europe/Samara') {
																echo filter_var("selected");
															} ?> value="Europe/Samara" data-posinset="173">(GMT+04:00) Samara Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Indian/Mahe') {
																echo filter_var("selected");
															} ?> value="Indian/Mahe" data-posinset="174">(GMT+04:00) Seychelles Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Kabul') {
																echo filter_var("selected");
															} ?> value="Asia/Kabul" data-posinset="175">(GMT+04:30) Afghanistan Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Tehran') {
																echo filter_var("selected");
															} ?> value="Asia/Tehran" data-posinset="176">(GMT+04:30) Iran Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Indian/Kerguelen') {
																echo filter_var("selected");
															} ?> value="Indian/Kerguelen" data-posinset="177">(GMT+05:00) French Southern &amp; Antarctic Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Indian/Maldives') {
																echo filter_var("selected");
															} ?> value="Indian/Maldives" data-posinset="178">(GMT+05:00) Maldives Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Antarctica/Mawson') {
																echo filter_var("selected");
															} ?> value="Antarctica/Mawson" data-posinset="179">(GMT+05:00) Mawson Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Karachi') {
																echo filter_var("selected");
															} ?> value="Asia/Karachi" data-posinset="180">(GMT+05:00) Pakistan Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Dushanbe') {
																echo filter_var("selected");
															} ?> value="Asia/Dushanbe" data-posinset="181">(GMT+05:00) Tajikistan Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Ashgabat') {
																echo filter_var("selected");
															} ?> value="Asia/Ashgabat" data-posinset="182">(GMT+05:00) Turkmenistan Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Tashkent') {
																echo filter_var("selected");
															} ?> value="Asia/Tashkent" data-posinset="183">(GMT+05:00) Uzbekistan Standard Time - Tashkent</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Aqtau') {
																echo filter_var("selected");
															} ?> value="Asia/Aqtau" data-posinset="184">(GMT+05:00) West Kazakhstan Time - Aqtau</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Aqtobe') {
																echo filter_var("selected");
															} ?> value="Asia/Aqtobe" data-posinset="185">(GMT+05:00) West Kazakhstan Time - Aqtobe</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Yekaterinburg') {
																echo filter_var("selected");
															} ?> value="Asia/Yekaterinburg" data-posinset="186">(GMT+05:00) Yekaterinburg Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Colombo') {
																echo filter_var("selected");
															} ?> value="Asia/Colombo" data-posinset="187">(GMT+05:30) India Standard Time - Colombo</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Calcutta') {
																echo filter_var("selected");
															} ?> value="Asia/Calcutta" data-posinset="188">(GMT+05:30) India Standard Time - Kolkata</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Katmandu') {
																echo filter_var("selected");
															} ?> value="Asia/Katmandu" data-posinset="189">(GMT+05:45) Nepal Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Dhaka') {
																echo filter_var("selected");
															} ?> value="Asia/Dhaka" data-posinset="190">(GMT+06:00) Bangladesh Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Thimphu') {
																echo filter_var("selected");
															} ?> value="Asia/Thimphu" data-posinset="191">(GMT+06:00) Bhutan Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Almaty') {
																echo filter_var("selected");
															} ?> value="Asia/Almaty" data-posinset="192">(GMT+06:00) East Kazakhstan Time - Almaty</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Indian/Chagos') {
																echo filter_var("selected");
															} ?> value="Indian/Chagos" data-posinset="193">(GMT+06:00) Indian Ocean Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Bishkek') {
																echo filter_var("selected");
															} ?> value="Asia/Bishkek" data-posinset="194">(GMT+06:00) Kyrgyzstan Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Omsk') {
																echo filter_var("selected");
															} ?> value="Asia/Omsk" data-posinset="195">(GMT+06:00) Omsk Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Antarctica/Vostok') {
																echo filter_var("selected");
															} ?> value="Antarctica/Vostok" data-posinset="196">(GMT+06:00) Vostok Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Indian/Cocos') {
																echo filter_var("selected");
															} ?> value="Indian/Cocos" data-posinset="197">(GMT+06:30) Cocos Islands Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Yangon') {
																echo filter_var("selected");
															} ?> value="Asia/Yangon" data-posinset="198">(GMT+06:30) Myanmar Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Indian/Christmas') {
																echo filter_var("selected");
															} ?> value="Indian/Christmas" data-posinset="199">(GMT+07:00) Christmas Island Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Antarctica/Davis') {
																echo filter_var("selected");
															} ?> value="Antarctica/Davis" data-posinset="200">(GMT+07:00) Davis Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Hovd') {
																echo filter_var("selected");
															} ?> value="Asia/Hovd" data-posinset="201">(GMT+07:00) Hovd Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Bangkok') {
																echo filter_var("selected");
															} ?> value="Asia/Bangkok" data-posinset="202">(GMT+07:00) Indochina Time - Bangkok</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Saigon') {
																echo filter_var("selected");
															} ?> value="Asia/Saigon" data-posinset="203">(GMT+07:00) Indochina Time - Ho Chi Minh City</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Krasnoyarsk') {
																echo filter_var("selected");
															} ?> value="Asia/Krasnoyarsk" data-posinset="204">(GMT+07:00) Krasnoyarsk Standard Time - Krasnoyarsk</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Jakarta') {
																echo filter_var("selected");
															} ?> value="Asia/Jakarta" data-posinset="205">(GMT+07:00) Western Indonesia Time - Jakarta</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Antarctica/Casey') {
																echo filter_var("selected");
															} ?> value="Antarctica/Casey" data-posinset="206">(GMT+08:00) Australian Western Standard Time - Casey</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Australia/Perth') {
																echo filter_var("selected");
															} ?> value="Australia/Perth" data-posinset="207">(GMT+08:00) Australian Western Standard Time - Perth</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Brunei') {
																echo filter_var("selected");
															} ?> value="Asia/Brunei" data-posinset="208">(GMT+08:00) Brunei Darussalam Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Makassar') {
																echo filter_var("selected");
															} ?> value="Asia/Makassar" data-posinset="209">(GMT+08:00) Central Indonesia Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Macau') {
																echo filter_var("selected");
															} ?> value="Asia/Macau" data-posinset="210">(GMT+08:00) China Standard Time - Macau</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Shanghai') {
																echo filter_var("selected");
															} ?> value="Asia/Shanghai" data-posinset="211">(GMT+08:00) China Standard Time - Shanghai</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Choibalsan') {
																echo filter_var("selected");
															} ?> value="Asia/Choibalsan" data-posinset="212">(GMT+08:00) Choibalsan Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Hong_Kong') {
																echo filter_var("selected");
															} ?> value="Asia/Hong_Kong" data-posinset="213">(GMT+08:00) Hong Kong Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Irkutsk') {
																echo filter_var("selected");
															} ?> value="Asia/Irkutsk" data-posinset="214">(GMT+08:00) Irkutsk Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Kuala_Lumpur') {
																echo filter_var("selected");
															} ?> value="Asia/Kuala_Lumpur" data-posinset="215">(GMT+08:00) Malaysia Time - Kuala Lumpur</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Manila') {
																echo filter_var("selected");
															} ?> value="Asia/Manila" data-posinset="216">(GMT+08:00) Philippine Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Singapore') {
																echo filter_var("selected");
															} ?> value="Asia/Singapore" data-posinset="217">(GMT+08:00) Singapore Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Taipei') {
																echo filter_var("selected");
															} ?> value="Asia/Taipei" data-posinset="218">(GMT+08:00) Taipei Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Ulaanbaatar') {
																echo filter_var("selected");
															} ?> value="Asia/Ulaanbaatar" data-posinset="219">(GMT+08:00) Ulaanbaatar Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Dili') {
																echo filter_var("selected");
															} ?> value="Asia/Dili" data-posinset="220">(GMT+09:00) East Timor Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Jayapura') {
																echo filter_var("selected");
															} ?> value="Asia/Jayapura" data-posinset="221">(GMT+09:00) Eastern Indonesia Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Tokyo') {
																echo filter_var("selected");
															} ?> value="Asia/Tokyo" data-posinset="222">(GMT+09:00) Japan Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Pyongyang') {
																echo filter_var("selected");
															} ?> value="Asia/Pyongyang" data-posinset="223">(GMT+09:00) Korean Standard Time - Pyongyang</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Seoul') {
																echo filter_var("selected");
															} ?> value="Asia/Seoul" data-posinset="224">(GMT+09:00) Korean Standard Time - Seoul</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Palau') {
																echo filter_var("selected");
															} ?> value="Pacific/Palau" data-posinset="225">(GMT+09:00) Palau Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Yakutsk') {
																echo filter_var("selected");
															} ?> value="Asia/Yakutsk" data-posinset="226">(GMT+09:00) Yakutsk Standard Time - Yakutsk</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Australia/Darwin') {
																echo filter_var("selected");
															} ?> value="Australia/Darwin" data-posinset="227">(GMT+09:30) Australian Central Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Australia/Adelaide') {
																echo filter_var("selected");
															} ?> value="Australia/Adelaide" data-posinset="228">(GMT+09:30) Central Australia Time - Adelaide</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Australia/Brisbane') {
																echo filter_var("selected");
															} ?> value="Australia/Brisbane" data-posinset="229">(GMT+10:00) Australian Eastern Standard Time - Brisbane</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Guam') {
																echo filter_var("selected");
															} ?> value="Pacific/Guam" data-posinset="230">(GMT+10:00) Chamorro Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Chuuk') {
																echo filter_var("selected");
															} ?> value="Pacific/Chuuk" data-posinset="231">(GMT+10:00) Chuuk Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Antarctica/DumontDUrville') {
																echo filter_var("selected");
															} ?> value="Antarctica/DumontDUrville" data-posinset="232">(GMT+10:00) Dumont-d’Urville Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Australia/Hobart') {
																echo filter_var("selected");
															} ?> value="Australia/Hobart" data-posinset="233">(GMT+10:00) Eastern Australia Time - Hobart</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Australia/Melbourne') {
																echo filter_var("selected");
															} ?> value="Australia/Melbourne" data-posinset="234">(GMT+10:00) Eastern Australia Time - Melbourne</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Australia/Sydney') {
																echo filter_var("selected");
															} ?> value="Australia/Sydney" data-posinset="235">(GMT+10:00) Eastern Australia Time - Sydney</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Port_Moresby') {
																echo filter_var("selected");
															} ?> value="Pacific/Port_Moresby" data-posinset="236">(GMT+10:00) Papua New Guinea Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Vladivostok') {
																echo filter_var("selected");
															} ?> value="Asia/Vladivostok" data-posinset="237">(GMT+10:00) Vladivostok Standard Time - Vladivostok</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Kosrae') {
																echo filter_var("selected");
															} ?> value="Pacific/Kosrae" data-posinset="238">(GMT+11:00) Kosrae Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Magadan') {
																echo filter_var("selected");
															} ?> value="Asia/Magadan" data-posinset="239">(GMT+11:00) Magadan Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Noumea') {
																echo filter_var("selected");
															} ?> value="Pacific/Noumea" data-posinset="240">(GMT+11:00) New Caledonia Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Norfolk') {
																echo filter_var("selected");
															} ?> value="Pacific/Norfolk" data-posinset="241">(GMT+11:00) Norfolk Island Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Pohnpei') {
																echo filter_var("selected");
															} ?> value="Pacific/Pohnpei" data-posinset="242">(GMT+11:00) Ponape Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Guadalcanal') {
																echo filter_var("selected");
															} ?> value="Pacific/Guadalcanal" data-posinset="243">(GMT+11:00) Solomon Islands Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Efate') {
																echo filter_var("selected");
															} ?> value="Pacific/Efate" data-posinset="244">(GMT+11:00) Vanuatu Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Fiji') {
																echo filter_var("selected");
															} ?> value="Pacific/Fiji" data-posinset="245">(GMT+12:00) Fiji Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Tarawa') {
																echo filter_var("selected");
															} ?> value="Pacific/Tarawa" data-posinset="246">(GMT+12:00) Gilbert Islands Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Kwajalein') {
																echo filter_var("selected");
															} ?> value="Pacific/Kwajalein" data-posinset="247">(GMT+12:00) Marshall Islands Time - Kwajalein</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Majuro') {
																echo filter_var("selected");
															} ?> value="Pacific/Majuro" data-posinset="248">(GMT+12:00) Marshall Islands Time - Majuro</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Nauru') {
																echo filter_var("selected");
															} ?> value="Pacific/Nauru" data-posinset="249">(GMT+12:00) Nauru Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Auckland') {
																echo filter_var("selected");
															} ?> value="Pacific/Auckland" data-posinset="250">(GMT+12:00) New Zealand Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Asia/Kamchatka') {
																echo filter_var("selected");
															} ?> value="Asia/Kamchatka" data-posinset="251">(GMT+12:00) Petropavlovsk-Kamchatski Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Funafuti') {
																echo filter_var("selected");
															} ?> value="Pacific/Funafuti" data-posinset="252">(GMT+12:00) Tuvalu Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Wake') {
																echo filter_var("selected");
															} ?> value="Pacific/Wake" data-posinset="253">(GMT+12:00) Wake Island Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Wallis') {
																echo filter_var("selected");
															} ?> value="Pacific/Wallis" data-posinset="254">(GMT+12:00) Wallis &amp; Futuna Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Apia') {
																echo filter_var("selected");
															} ?> value="Pacific/Apia" data-posinset="255">(GMT+13:00) Apia Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Enderbury') {
																echo filter_var("selected");
															} ?> value="Pacific/Enderbury" data-posinset="256">(GMT+13:00) Phoenix Islands Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Fakaofo') {
																echo filter_var("selected");
															} ?> value="Pacific/Fakaofo" data-posinset="257">(GMT+13:00) Tokelau Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Tongatapu') {
																echo filter_var("selected");
															} ?> value="Pacific/Tongatapu" data-posinset="258">(GMT+13:00) Tonga Standard Time</option>
													<option <?php if ($setting->get_option('ld_timezone') == 'Pacific/Kiritimati') {
																echo filter_var("selected");
															} ?> value="Pacific/Kiritimati" data-posinset="259">(GMT+14:00) Line Islands Time</option>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['companyname']);	?></label></td>
										<td>
											<div class="form-group">
												<input type="text" id="company_name" class="form-control" size="35" name="ld_company_name" value="<?php echo filter_var($setting->get_option('ld_company_name'));	?>" placeholder="<?php echo filter_var($label_language_values['company_name']);	?>" />
												<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['company_name_is_used_for_invoice_purpose']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
											</div>

										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['company_email']);	?></label></td>
										<td>
											<div class="form-group">
												<input type="email" class="form-control" id="company_email" size="35" name="ld_company_email" value="<?php echo filter_var($setting->get_option('ld_company_email'), FILTER_SANITIZE_EMAIL);	?>" placeholder="<?php echo filter_var($label_language_values['company_email']);	?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td><?php echo filter_var($label_language_values['default_country_code']);	?></td>
										<td>
											<div class="form-group">
												<div class="lda-country-code-flag" id="country_phone_code_div">
													<?php $country_codes = explode(',', $setting->get_option("ld_company_country_code"));	?>
													<input type="tel" id="company_country_code" class="form-control lda-col6" value="<?php echo filter_var($country_codes[0]);	?>" name="ld_company_country_code" />
													<label class="numbercode hide"><?php echo filter_var($country_codes[0]);	?></label>
													<label class="alphacode hide"><?php echo filter_var($country_codes[1]);	?></label>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['company_phone']);	?></label></td>
										<td>
											<div class="input-group">
												<span class="input-group-addon"><span class="company_country_code_value"><?php echo filter_var($country_codes[0]);	?></span></span>
												<input type="text" class="form-control" id="company_phone" name="ld_company_phone" value="<?php echo str_replace($country_codes[0], '', $setting->get_option('ld_company_phone'));	?>" placeholder="<?php echo filter_var($label_language_values['company_phone']);	?>" />
											</div>
											<label for="company_phone" generated="true" class="error"></label>

										</td>
									</tr>


									<tr>
										<td><label><?php echo filter_var($label_language_values['company_address']);	?></label></td>

										<td>
											<div class="form-group">
												<div class="lda-col12"><textarea id="company_address" name="ld_company_address" class="form-control" cols="44"><?php echo filter_var($setting->get_option('ld_company_address'));	?></textarea></div>
											</div>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<div class="form-group">
												<div class="lda-col6 ld-w-50">
													<input type="text" class="form-control" id="company_city" name="ld_company_city" value="<?php echo filter_var($setting->get_option('ld_company_city'));	?>" placeholder="<?php echo filter_var($label_language_values['city']);	?>" />
												</div>
												<div class="lda-col6 ld-w-50 float-right">
													<input type="text" class="form-control" id="company_state" name="ld_company_state" value="<?php echo filter_var($setting->get_option('ld_company_state'));	?>" placeholder="<?php echo filter_var($label_language_values['state']);	?>" />
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<div class="form-group">
												<div class="lda-col6 ld-w-50">
													<input type="text" class="form-control" id="company_zip" name="ld_company_zip" value="<?php echo filter_var($setting->get_option('ld_company_zip_code'));	?>" placeholder="<?php echo filter_var($label_language_values['zip']);	?>" />
												</div>
												<div class="lda-col6 ld-w-50 float-right">
													<input type="text" class="form-control" id="company_country" name="ld_company_country" value="<?php echo filter_var($setting->get_option('ld_company_country'));	?>" placeholder="<?php echo filter_var($label_language_values['country']);	?>" />
												</div>
											</div>

										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['company_logo']);	?></label></td>
										<td>
											<div class="form-group">
												<div class="ld-company-logo-uploader">
													<?php
													if ($setting->get_option('ld_company_logo') == '') {
														$imagepath = SITE_URL . "assets/images/company-logo.png";
													} else {
														$imagepath = SITE_URL . "assets/images/services/" . $setting->get_option('ld_company_logo');
													} ?>
													<img id="ctsisalonlogo" src="<?php echo filter_var($imagepath);	?>" class="ld-company-logo br-5">
													<?php
													if ($setting->get_option('ld_company_logo') == '') {
													?>
														<label for="ld-upload-imagectsi" class="ld-company-logo-icon-label set_cam_icon">
															<i class="ld-camera-icon-common br-100 fa fa-camera"></i>
															<i class="pull-left fa fa-plus-circle fa-2x"></i>
														</label>
													<?php
													}
													?>
													<input data-us="ctsi" class="hide ld-upload-images" type="file" name="" id="ld-upload-imagectsi" />
													<label for="ld-upload-imagectsi" class="ld-company-logo-icon-label set_newcam_icon">
														<i class="ld-camera-icon-common br-100 fa fa-camera"></i>
														<i class="pull-left fa fa-plus-circle fa-2x"></i>
													</label>
													<?php
													if ($setting->get_option('ld_company_logo') !== '') {
													?>
														<a id="ld-remove-company-logo-new" class="pull-left br-100 btn-danger bt-remove-company-logo btn-xs del_set_popup" rel="popover" data-placement='left' title="<?php echo filter_var($label_language_values['remove_image']);	?>?"> <i class="fa fa-trash" title="<?php echo filter_var($label_language_values['remove_company_logo']);	?>"></i></a>
													<?php
													}
													?>
													<a id="ld-remove-company-logo-new" class="pull-left br-100 btn-danger bt-remove-company-logo btn-xs del_btn" rel="popover" data-placement='left' title="<?php echo filter_var($label_language_values['remove_image']);	?>?"> <i class="fa fa-trash" title="<?php echo filter_var($label_language_values['remove_company_logo']);	?>"></i></a>
													<div id="popover-ld-remove-company-logo-new" style="display: none;">
														<div class="arrow"></div>
														<table class="form-horizontal" cellspacing="0">
															<tbody>
																<tr>
																	<td>
																		<a id="ld-close-popover-salon-logo" value="Delete" class="btn btn-danger btn-sm delete_com_logo" data-comp_id="<?php echo filter_var($setting->ld_company_logo);	?>" type="submit"><?php echo filter_var($label_language_values['yes']);	?></a>
																		<a href="javascript:void(0)" id="ld-close-popover-salon-logoctsi" class="btn btn-default btn-sm" href="javascript:void(0)"><?php echo filter_var($label_language_values['cancel']);	?></a>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
													<label class="error_image"></label>
													<div class="ld-salon-logo-popup-view">

														<div id="ld-image-upload-popupctsi" class="ld-image-upload-popup modal fade" tabindex="-1" role="dialog">
															<div class="vertical-alignment-helper">
																<div class="modal-dialog modal-md vertical-align-center">
																	<div class="modal-content">
																		<div class="modal-header">
																			<div class="col-md-12 col-xs-12">

																				<a data-us="ctsi" class="btn btn-success ld_upload_img3" data-imageinputid="ld-upload-imagectsi"><?php echo filter_var($label_language_values['crop_and_save']);	?></a>

																				<button type="button" class="btn btn-default hidemodal" data-dismiss="modal" aria-hidden="true"><?php echo filter_var($label_language_values['cancel']);	?></button>
																			</div>
																		</div>
																		<div class="modal-body">
																			<img id="ld-preview-imgctsi" class="ld-preview-img" name="image" />
																		</div>
																		<div class="modal-footer">
																			<div class="col-md-12 np">
																				<div class="col-md-4 col-xs-12">
																					<label class="pull-left"><?php echo filter_var($label_language_values['file_size']);	?></label> <input type="text" class="form-control" id="ctsifilesize" name="filesize" />
																				</div>
																				<div class="col-md-4 col-xs-12">
																					<label class="pull-left">H</label> <input type="text" class="form-control" id="ctsih" name="h" />
																				</div>
																				<div class="col-md-4 col-xs-12">
																					<label class="pull-left">W</label> <input type="text" class="form-control" id="ctsiw" name="w" />
																				</div>
																				<input type="hidden" id="ctsix1" name="x1" />
																				<input type="hidden" id="ctsiy1" name="y1" />
																				<input type="hidden" id="ctsix2" name="x2" />
																				<input type="hidden" id="ctsiy2" name="y2" />
																				<input type="hidden" id="ctsiid" name="id" value="1" />
																				<input type="hidden" name="ctimage" id="ctsictimage" />
																				<input type="hidden" id="ctsictimagename" name="ctimagename" value="<?php echo filter_var($setting->ld_company_logo);	?>" />
																				<input type="hidden" id="ctsinewname" value="company_" />
																			</div>

																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

												</div>
											</div>
											<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['company_logo_is_used_for_invoice_purpose']);	?>."><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
								</tbody>

								<tfoot>
									<tr>
										<td class="res-hide"></td>
										<td>
											<a id="company_setting" name="" class="btn btn-success"><?php echo filter_var($label_language_values['save_setting']);	?></a>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</form>
			</div>



			<div class="tab-pane fade in" id="general-setting">
				<form id="general_setting_form" method="post" type="" class="ld-general-setting">
					<div class="panel panel-default">
						<div class="panel-heading lda-top-right">
							<h1 class="panel-title"><?php echo filter_var($label_language_values['general_settings']);	?></h1>
							<span class="pull-right lda-setting-fix-btn"> <a id="general_setting" name="" class="btn btn-success"><?php echo filter_var($label_language_values['save_setting']);	?></a></span>
						</div>
						<div class="panel-body pt-50 plr-10">
							<table class="form-inline ld-common-table">
								<tbody>
									<tr>
										<td><label><?php echo filter_var($label_language_values['postal_codes']);	?></label></td>
										<td>
											<div class="form-group">
												<div class="form-group">
													<label class="ctoggle-postal-code" for="postal-code">
														<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_postalcode_status == 'Y') {
																																						echo filter_var('checked');
																																					} ?> id="postalcode" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

														<a class="ld-tooltip-link" href="javascript:void(0)" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['postal_codes_ed']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
													</label>
													<div class="hide-div mycollapse_postalcode pt-15" <?php if ($setting->ld_postalcode_status == 'Y') {
																											echo 'style="display:block;"';
																										} ?>>
														<textarea class="form-control" name="ld_postal_code" id="ld_postal_code" row="4" cols="40"><?php echo filter_var($setting->get_option_postal());	?></textarea>

														<a class="ld-tooltip-link" href="javascript:void(0)" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['postal_codes_info']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
													</div>
												</div>
											</div>

										</td>
									</tr>
									<tr>
										<td><label> <?php echo filter_var($label_language_values['time_interval']);	?></label></td>
										<td>
											<div class="form-group">
												<select name="ld_time_interval" id="time_interval" class="selectpicker" data-size="5" style="display: none;">
													<option value="10" <?php if ($setting->ld_time_interval == '10') {
																			echo filter_var('selected');
																		} ?>>10 <?php echo filter_var($label_language_values['minutes']);	?></option>
													<option value="15" <?php if ($setting->ld_time_interval == '15') {
																			echo filter_var('selected');
																		} ?>>15 <?php echo filter_var($label_language_values['minutes']);	?></option>
													<option value="20" <?php if ($setting->ld_time_interval == '20') {
																			echo filter_var('selected');
																		} ?>>20 <?php echo filter_var($label_language_values['minutes']);	?></option>
													<option value="30" <?php if ($setting->ld_time_interval == '30') {
																			echo filter_var('selected');
																		} ?>>30 <?php echo filter_var($label_language_values['minutes']);	?></option>
													<option value="45" <?php if ($setting->ld_time_interval == '45') {
																			echo filter_var('selected');
																		} ?>>45 <?php echo filter_var($label_language_values['minutes']);	?></option>
													<option value="60" <?php if ($setting->ld_time_interval == '60') {
																			echo filter_var('selected');
																		} ?>>1 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="90" <?php if ($setting->ld_time_interval == '90') {
																			echo filter_var('selected');
																		} ?>>1.5 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="120" <?php if ($setting->ld_time_interval == '120') {
																			echo filter_var('selected');
																		} ?>>2 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="150" <?php if ($setting->ld_time_interval == '150') {
																			echo filter_var('selected');
																		} ?>>2.5 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="180" <?php if ($setting->ld_time_interval == '180') {
																			echo filter_var('selected');
																		} ?>>3 <?php echo filter_var($label_language_values['hours']);	?></option>
												</select>
											</div>
											<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['time_interval_is_helpful_to_show_time_difference_between_availability_time_slots']);	?>."><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
									<tr>
										<td><label> <?php echo filter_var($label_language_values['minimum_advance_booking_time']);	?></label></td>
										<td>
											<div class="form-group">
												<select name="ld_min_advance_booking_time" id="ld_min_advance_booking_time" class="selectpicker" data-size="5" style="display: none;">
													<option value=""><?php echo filter_var($label_language_values['minimum_advance_booking_time']);	?></option>
													<option value="10" <?php if ($setting->ld_min_advance_booking_time == '10') {
																			echo filter_var('selected');
																		} ?>>10 <?php echo filter_var($label_language_values['minutes']);	?></option>
													<option value="20" <?php if ($setting->ld_min_advance_booking_time == '20') {
																			echo filter_var('selected');
																		} ?>>20 <?php echo filter_var($label_language_values['minutes']);	?></option>
													<option value="30" <?php if ($setting->ld_min_advance_booking_time == '30') {
																			echo filter_var('selected');
																		} ?>>30 <?php echo filter_var($label_language_values['minutes']);	?></option>
													<option value="40" <?php if ($setting->ld_min_advance_booking_time == '40') {
																			echo filter_var('selected');
																		} ?>>40 <?php echo filter_var($label_language_values['minutes']);	?></option>
													<option value="60" <?php if ($setting->ld_min_advance_booking_time == '60') {
																			echo filter_var('selected');
																		} ?>>1 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="120" <?php if ($setting->ld_min_advance_booking_time == '120') {
																			echo filter_var('selected');
																		} ?>>2 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="180" <?php if ($setting->ld_min_advance_booking_time == '180') {
																			echo filter_var('selected');
																		} ?>>3 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="240" <?php if ($setting->ld_min_advance_booking_time == '240') {
																			echo filter_var('selected');
																		} ?>>4 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="300" <?php if ($setting->ld_min_advance_booking_time == '300') {
																			echo filter_var('selected');
																		} ?>>5 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="360" <?php if ($setting->ld_min_advance_booking_time == '360') {
																			echo filter_var('selected');
																		} ?>>6 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="420" <?php if ($setting->ld_min_advance_booking_time == '420') {
																			echo filter_var('selected');
																		} ?>>7 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="480" <?php if ($setting->ld_min_advance_booking_time == '480') {
																			echo filter_var('selected');
																		} ?>>8 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="720" <?php if ($setting->ld_min_advance_booking_time == '720') {
																			echo filter_var('selected');
																		} ?>>12 <?php echo filter_var($label_language_values['hours']);	?></option>

													<option value="1440" <?php if ($setting->ld_min_advance_booking_time == '1440') {
																				echo filter_var('selected');
																			} ?>>24 <?php echo filter_var($label_language_values['hours']);	?></option>

													<option value="1440" <?php if ($setting->ld_min_advance_booking_time == '1440') {
																				echo filter_var('selected');
																			} ?>>1 <?php echo str_replace("s", "", $label_language_values['days']);	?></option>

													<option value="2880" <?php if ($setting->ld_min_advance_booking_time == '2880') {
																				echo filter_var('selected');
																			} ?>>2 <?php echo filter_var($label_language_values['days']);	?></option>

													<option value="4320" <?php if ($setting->ld_min_advance_booking_time == '4320') {
																				echo filter_var('selected');
																			} ?>>3 <?php echo filter_var($label_language_values['days']);	?></option>
													<option value="5760" <?php if ($setting->ld_min_advance_booking_time == '5760') {
																				echo filter_var('selected');
																			} ?>>4 <?php echo filter_var($label_language_values['days']);	?></option>
													<option value="7200" <?php if ($setting->ld_min_advance_booking_time == '7200') {
																				echo filter_var('selected');
																			} ?>>5 <?php echo filter_var($label_language_values['days']);	?></option>
													<option value="8640" <?php if ($setting->ld_min_advance_booking_time == '8640') {
																				echo filter_var('selected');
																			} ?>>6 <?php echo filter_var($label_language_values['days']);	?></option>

													<option value="10080" <?php if ($setting->ld_min_advance_booking_time == '10080') {
																				echo filter_var('selected');
																			} ?>>7 <?php echo filter_var($label_language_values['days']);	?></option>
												</select>
											</div>
											<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['minimum_advance_booking_time_restrict_client_to_book_last_minute_booking_so_that_you_should_have_sufficient_time_before_appointment']);	?>."><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['maximum_advance_booking_time']);	?></label></td>
										<td>
											<div class="form-group">
												<select name="ld_max_advance_booking_time" id="ld_max_advance_booking_time" class="selectpicker" data-size="5" style="display: none;">
													<option value="" <?php if ($setting->ld_max_advance_booking_time == '') {
																			echo filter_var('selected');
																		} ?>><?php echo filter_var($label_language_values['maximum_advance_booking_time']);	?></option>
													<option value="1" <?php if ($setting->ld_max_advance_booking_time == '1') {
																			echo filter_var('selected');
																		} ?>>1 <?php echo filter_var($label_language_values['months']);	?></option>
													<option value="2" <?php if ($setting->ld_max_advance_booking_time == '2') {
																			echo filter_var('selected');
																		} ?>>2 <?php echo filter_var($label_language_values['months']);	?></option>
													<option value="3" <?php if ($setting->ld_max_advance_booking_time == '3') {
																			echo filter_var('selected');
																		} ?>>3 <?php echo filter_var($label_language_values['months']);	?></option>
													<option value="4" <?php if ($setting->ld_max_advance_booking_time == '4') {
																			echo filter_var('selected');
																		} ?>>4 <?php echo filter_var($label_language_values['months']);	?></option>
													<option value="5" <?php if ($setting->ld_max_advance_booking_time == '5') {
																			echo filter_var('selected');
																		} ?>>5 <?php echo filter_var($label_language_values['months']);	?></option>
													<option value="6" <?php if ($setting->ld_max_advance_booking_time == '6') {
																			echo filter_var('selected');
																		} ?>>6 <?php echo filter_var($label_language_values['months']);	?></option>
													<option value="12" <?php if ($setting->ld_max_advance_booking_time == '12') {
																			echo filter_var('selected');
																		} ?>>1 <?php echo filter_var($label_language_values['year']);	?></option>
													<option value="24" <?php if ($setting->ld_max_advance_booking_time == '24') {
																			echo filter_var('selected');
																		} ?>>2 <?php echo filter_var($label_language_values['year']);	?></option>
													<option value="36" <?php if ($setting->ld_max_advance_booking_time == '36') {
																			echo filter_var('selected');
																		} ?>>3 <?php echo filter_var($label_language_values['year']);	?></option>
													<option value="48" <?php if ($setting->ld_max_advance_booking_time == '48') {
																			echo filter_var('selected');
																		} ?>>4 <?php echo filter_var($label_language_values['year']);	?></option>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['cancellation_buffer_time']);	?></label></td>
										<td>
											<div class="form-group">
												<select name="ld_cancellation_buffer_time" id="ld_cancellation_buffer_time" class="selectpicker" data-size="5" style="display: none;">
													<option value=""><?php echo filter_var($label_language_values['cancellation_buffer_time']);	?></option>
													<option value="60" <?php if ($setting->ld_cancellation_buffer_time == '60') {
																			echo filter_var('selected');
																		} ?>>1 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="120" <?php if ($setting->ld_cancellation_buffer_time == '120') {
																			echo filter_var('selected');
																		} ?>>2 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="180" <?php if ($setting->ld_cancellation_buffer_time == '180') {
																			echo filter_var('selected');
																		} ?>>3 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="240" <?php if ($setting->ld_cancellation_buffer_time == '240') {
																			echo filter_var('selected');
																		} ?>>4 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="300" <?php if ($setting->ld_cancellation_buffer_time == '300') {
																			echo filter_var('selected');
																		} ?>>5 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="360" <?php if ($setting->ld_cancellation_buffer_time == '360') {
																			echo filter_var('selected');
																		} ?>>6 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="420" <?php if ($setting->ld_cancellation_buffer_time == '420') {
																			echo filter_var('selected');
																		} ?>>7 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="480" <?php if ($setting->ld_cancellation_buffer_time == '480') {
																			echo filter_var('selected');
																		} ?>>8 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="540" <?php if ($setting->ld_cancellation_buffer_time == '540') {
																			echo filter_var('selected');
																		} ?>>9 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="600" <?php if ($setting->ld_cancellation_buffer_time == '600') {
																			echo filter_var('selected');
																		} ?>>10 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="660" <?php if ($setting->ld_cancellation_buffer_time == '660') {
																			echo filter_var('selected');
																		} ?>>11 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="720" <?php if ($setting->ld_cancellation_buffer_time == '720') {
																			echo filter_var('selected');
																		} ?>>12 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="1440" <?php if ($setting->ld_cancellation_buffer_time == '1440') {
																				echo filter_var('selected');
																			} ?>>24 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="2880" <?php if ($setting->ld_cancellation_buffer_time == '2880') {
																				echo filter_var('selected');
																			} ?>>48 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="4320" <?php if ($setting->ld_cancellation_buffer_time == '4320') {
																				echo filter_var('selected');
																			} ?>>72 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="5760" <?php if ($setting->ld_cancellation_buffer_time == '5760') {
																				echo filter_var('selected');
																			} ?>>96 <?php echo filter_var($label_language_values['hours']);	?></option>
												</select>
											</div>
											<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['cancellation_buffer_helps_service_providers_to_avoid_last_minute_cancellation_by_their_clients']);	?>."><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['reshedule_buffer_time']);	?> </label></td>
										<td>
											<div class="form-group">
												<select class="selectpicker" name="ld_reshedule_buffer_time" id="ld_reshedule_buffer_time" data-size="5" style="display: none;">
													<option value=""><?php echo filter_var($label_language_values['reshedule_buffer_time']);	?></option>
													<option value="60" <?php if ($setting->ld_reshedule_buffer_time == '60') {
																			echo filter_var('selected');
																		} ?>>1 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="120" <?php if ($setting->ld_reshedule_buffer_time == '120') {
																			echo filter_var('selected');
																		} ?>>2 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="180" <?php if ($setting->ld_reshedule_buffer_time == '180') {
																			echo filter_var('selected');
																		} ?>>3 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="240" <?php if ($setting->ld_reshedule_buffer_time == '240') {
																			echo filter_var('selected');
																		} ?>>4 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="300" <?php if ($setting->ld_reshedule_buffer_time == '300') {
																			echo filter_var('selected');
																		} ?>>5 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="360" <?php if ($setting->ld_reshedule_buffer_time == '360') {
																			echo filter_var('selected');
																		} ?>>6 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="420" <?php if ($setting->ld_reshedule_buffer_time == '420') {
																			echo filter_var('selected');
																		} ?>>7 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="480" <?php if ($setting->ld_reshedule_buffer_time == '480') {
																			echo filter_var('selected');
																		} ?>>8 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="540" <?php if ($setting->ld_reshedule_buffer_time == '540') {
																			echo filter_var('selected');
																		} ?>>9 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="600" <?php if ($setting->ld_reshedule_buffer_time == '600') {
																			echo filter_var('selected');
																		} ?>>10 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="660" <?php if ($setting->ld_reshedule_buffer_time == '660') {
																			echo filter_var('selected');
																		} ?>>11 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="720" <?php if ($setting->ld_reshedule_buffer_time == '720') {
																			echo filter_var('selected');
																		} ?>>12 <?php echo filter_var($label_language_values['hours']);	?></option>
												</select>
											</div>

										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['currency']);	?></label></td>
										<td>
											<div class="form-group">
												<select name="ld_currency" class="selectpicker form-control" data-live-search="true" id="ld_currency" data-size="5" data-live-search-placeholder="<?php echo filter_var($label_language_values['search']);	?>" data-actions-box="true">
													<option value=""><?php echo "-- Select Currency --";	?></option>
													<option value="ALL" <?php if ($setting->ld_currency == 'ALL') {
																			echo filter_var(' selected ');
																		} ?>>Lek <?php echo filter_var("Albania Lek");	?></option>

													<option value="AED" <?php if ($setting->ld_currency == 'AED') {
																			echo filter_var(' selected ');
																		} ?>>د.إ <?php echo filter_var("UAE Dirham");	?></option>

													<option value="AFN" <?php if ($setting->ld_currency == 'AFN') {
																			echo filter_var(' selected ');
																		} ?>>؋ <?php echo filter_var("Afghanistan Afghani");	?></option>
													<option value="ARS" <?php if ($setting->ld_currency == 'ARS') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Argentina Peso");	?></option>


													<option value="ANG" <?php if ($setting->ld_currency == 'ANG') {
																			echo filter_var(' selected ');
																		} ?>>NAƒ <?php echo filter_var("Neth Antilles Guilder");	?></option>

													<option value="AWG" <?php if ($setting->ld_currency == 'AWG') {
																			echo filter_var(' selected ');
																		} ?>>ƒ <?php echo filter_var("Aruba Guilder");	?></option>
													<option value="AUD" <?php if ($setting->ld_currency == 'AUD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Australia Dollar");	?></option>
													<option value="AZN" <?php if ($setting->ld_currency == 'AZN') {
																			echo filter_var(' selected ');
																		} ?>>ман <?php echo filter_var("Azerbaijan Manat");	?></option>
													<option value="BSD" <?php if ($setting->ld_currency == 'BSD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Bahamas Dollar");	?></option>
													<option value="BBD" <?php if ($setting->ld_currency == 'BBD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Barbados Dollar");	?></option>
													<option value="BYR" <?php if ($setting->ld_currency == 'BYR') {
																			echo filter_var(' selected ');
																		} ?>>p <?php echo filter_var("Belarus Ruble");	?></option>
													<option value="BZD" <?php if ($setting->ld_currency == 'BZD') {
																			echo filter_var(' selected ');
																		} ?>>BZ$ <?php echo filter_var("Belize Dollar");	?></option>
													<option value="BMD" <?php if ($setting->ld_currency == 'BMD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Bermuda Dollar");	?></option>
													<option value="BOB" <?php if ($setting->ld_currency == 'BOB') {
																			echo filter_var(' selected ');
																		} ?>>$b <?php echo filter_var("Bolivia	Boliviano");	?></option>
													<option value="BAM" <?php if ($setting->ld_currency == 'BAM') {
																			echo filter_var(' selected ');
																		} ?>>KM <?php echo filter_var("Bosnia and Herzegovina Convertible Marka");	?></option>
													<option value="BWP" <?php if ($setting->ld_currency == 'BWP') {
																			echo filter_var(' selected ');
																		} ?>>P <?php echo filter_var("Botswana Pula");	?></option>
													<option value="BGN" <?php if ($setting->ld_currency == 'BGN') {
																			echo filter_var(' selected ');
																		} ?>>лв <?php echo filter_var("Bulgaria Lev");	?></option>
													<option value="BRL" <?php if ($setting->ld_currency == 'BRL') {
																			echo filter_var(' selected ');
																		} ?>>R$ <?php echo filter_var("Brazil Real");	?></option>
													<option value="BND" <?php if ($setting->ld_currency == 'BND') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Brunei Darussalam Dollar");	?></option>

													<option value="BDT" <?php if ($setting->ld_currency == 'BDT') {
																			echo filter_var(' selected ');
																		} ?>>Tk <?php echo filter_var("Bangladesh Taka");	?></option>
													<option value="BIF" <?php if ($setting->ld_currency == 'BIF') {
																			echo filter_var(' selected ');
																		} ?>>FBu <?php echo filter_var("Burundi Franc");	?></option>

													<option value="CHF" <?php if ($setting->ld_currency == 'CHF') {
																			echo filter_var(' selected ');
																		} ?>>CHF<?php echo filter_var("Swiss Franc");	?></option>


													<option value="KHR" <?php if ($setting->ld_currency == 'KHR') {
																			echo filter_var(' selected ');
																		} ?>>៛ <?php echo filter_var("Cambodia Riel");	?></option>
													<option value="KMF" <?php if ($setting->ld_currency == 'KMF') {
																			echo filter_var(' selected ');
																		} ?>>KMF <?php echo filter_var("Comoros Franc");	?></option>

													<option value="CAD" <?php if ($setting->ld_currency == 'CAD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Canada Dollar");	?></option>
													<option value="KYD" <?php if ($setting->ld_currency == 'KYD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Cayman Dollar");	?></option>

													<option value="CLP" <?php if ($setting->ld_currency == 'CLP') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Chile Peso");	?></option>
													<option value="CYN" <?php if ($setting->ld_currency == 'CYN') {
																			echo filter_var(' selected ');
																		} ?>>¥ <?php echo filter_var("China Yuan Renminbi");	?></option>

													<option value="CVE" <?php if ($setting->ld_currency == 'CVE') {
																			echo filter_var(' selected ');
																		} ?>>Esc <?php echo filter_var("Cape Verde Escudo");	?></option>

													<option value="COP" <?php if ($setting->ld_currency == 'COP') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Colombia Peso");	?></option>
													<option value="CRC" <?php if ($setting->ld_currency == 'CRC') {
																			echo filter_var(' selected ');
																		} ?>>₡ <?php echo filter_var("Costa Rica Colon");	?></option>
													<option value="HRK" <?php if ($setting->ld_currency == 'HRK') {
																			echo filter_var(' selected ');
																		} ?>>kn <?php echo filter_var("Croatia	Kuna");	?></option>
													<option value="CUP" <?php if ($setting->ld_currency == 'CUP') {
																			echo filter_var(' selected ');
																		} ?>>₱ <?php echo filter_var("Cuba Peso");	?></option>
													<option value="CZK" <?php if ($setting->ld_currency == 'CZK') {
																			echo filter_var(' selected ');
																		} ?>>Kč <?php echo filter_var("Czech Republic Koruna");	?></option>
													<option value="DKK" <?php if ($setting->ld_currency == 'DKK') {
																			echo filter_var(' selected ');
																		} ?>>kr <?php echo filter_var("Denmark	Krone");	?></option>
													<option value="DOP" <?php if ($setting->ld_currency == 'DOP') {
																			echo filter_var(' selected ');
																		} ?>>RD$ <?php echo filter_var("Dominican Republic Peso");	?></option>

													<option value="DJF" <?php if ($setting->ld_currency == 'DJF') {
																			echo filter_var(' selected ');
																		} ?>>Fdj <?php echo filter_var("Djibouti Franc");	?></option>
													<option value="DZD" <?php if ($setting->ld_currency == 'DZD') {
																			echo filter_var(' selected ');
																		} ?>>دج <?php echo filter_var("Algerian Dinar");	?></option>


													<option value="XCD" <?php if ($setting->ld_currency == 'XCD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("East Caribbean Dollar");	?></option>
													<option value="EGP" <?php if ($setting->ld_currency == 'EGP') {
																			echo filter_var(' selected ');
																		} ?>>£ <?php echo filter_var("Egypt Pound");	?></option>

													<option value="ETB" <?php if ($setting->ld_currency == 'ETB') {
																			echo filter_var(' selected ');
																		} ?>>Br <?php echo filter_var("Ethiopian Birr");	?></option>

													<option value="SVC" <?php if ($setting->ld_currency == 'SVC') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("El Salvador Colon");	?></option>
													<option value="EEK" <?php if ($setting->ld_currency == 'EEK') {
																			echo filter_var(' selected ');
																		} ?>>kr <?php echo filter_var("Estonia Kroon");	?></option>
													<option value="EUR" <?php if ($setting->ld_currency == 'EUR') {
																			echo filter_var(' selected ');
																		} ?>>€ <?php echo filter_var("Euro Member Euro");	?></option>
													<option value="FKP" <?php if ($setting->ld_currency == 'FKP') {
																			echo filter_var(' selected ');
																		} ?>>£ <?php echo filter_var("Falkland Islands Pound");	?></option>
													<option value="FJD" <?php if ($setting->ld_currency == 'FJD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Fiji Dollar");	?></option>

													<option value="GHC" <?php if ($setting->ld_currency == 'GHC') {
																			echo filter_var(' selected ');
																		} ?>>¢ <?php echo filter_var("Ghana Cedis");	?></option>
													<option value="GIP" <?php if ($setting->ld_currency == 'GIP') {
																			echo filter_var(' selected ');
																		} ?>>£ <?php echo filter_var("Gibraltar Pound");	?></option>

													<option value="GMD" <?php if ($setting->ld_currency == 'GMD') {
																			echo filter_var(' selected ');
																		} ?>>D <?php echo filter_var("Gambian Dalasi");	?></option>
													<option value="GNF" <?php if ($setting->ld_currency == 'GNF') {
																			echo filter_var(' selected ');
																		} ?>>FG <?php echo filter_var("Guinea Franc");	?></option>

													<option value="GTQ" <?php if ($setting->ld_currency == 'GTQ') {
																			echo filter_var(' selected ');
																		} ?>>Q <?php echo filter_var("Guatemala Quetzal");	?></option>
													<option value="GGP" <?php if ($setting->ld_currency == 'GGP') {
																			echo filter_var(' selected ');
																		} ?>>£ <?php echo filter_var("Guernsey Pound");	?></option>
													<option value="GYD" <?php if ($setting->ld_currency == 'GYD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Guyana Dollar");	?></option>

													<option value="HNL" <?php if ($setting->ld_currency == 'HNL') {
																			echo filter_var(' selected ');
																		} ?>>L <?php echo filter_var("Honduras Lempira");	?></option>
													<option value="HKD" <?php if ($setting->ld_currency == 'HKD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Hong Kong Dollar");	?></option>

													<option value="HRK" <?php if ($setting->ld_currency == 'HRK') {
																			echo filter_var(' selected ');
																		} ?>>kn <?php echo filter_var("Croatian Kuna");	?></option>
													<option value="HTG" <?php if ($setting->ld_currency == 'HTG') {
																			echo filter_var(' selected ');
																		} ?>>G <?php echo filter_var("Haitian Gourde");	?></option>


													<option value="HUF" <?php if ($setting->ld_currency == 'HUF') {
																			echo filter_var(' selected ');
																		} ?>>Ft <?php echo filter_var("Hungary	Forint");	?></option>
													<option value="ISK" <?php if ($setting->ld_currency == 'ISK') {
																			echo filter_var(' selected ');
																		} ?>>kr <?php echo filter_var("Iceland	Krona");	?></option>
													<option value="INR" <?php if ($setting->ld_currency == 'INR') {
																			echo filter_var(' selected ');
																		} ?>>Rs <?php echo filter_var("India Rupee");	?></option>
													<option value="IDR" <?php if ($setting->ld_currency == 'IDR') {
																			echo filter_var(' selected ');
																		} ?>>Rp <?php echo filter_var("Indonesia Rupiah");	?></option>
													<option value="IRR" <?php if ($setting->ld_currency == 'IRR') {
																			echo filter_var(' selected ');
																		} ?>>﷼ <?php echo filter_var("Iran Rial");	?></option>
													<option value="IMP" <?php if ($setting->ld_currency == 'IMP') {
																			echo filter_var(' selected ');
																		} ?>>£ <?php echo filter_var("Isle of Man Pound");	?></option>
													<option value="ILS" <?php if ($setting->ld_currency == 'ILS') {
																			echo filter_var(' selected ');
																		} ?>>₪ <?php echo filter_var("Israel Shekel");	?></option>
													<option value="JMD" <?php if ($setting->ld_currency == 'JMD') {
																			echo filter_var(' selected ');
																		} ?>>J$ <?php echo filter_var("Jamaica Dollar");	?></option>
													<option value="JPY" <?php if ($setting->ld_currency == 'JPY') {
																			echo filter_var(' selected ');
																		} ?>>¥ <?php echo filter_var("Japan Yen");	?></option>
													<option value="JEP" <?php if ($setting->ld_currency == 'JEP') {
																			echo filter_var(' selected ');
																		} ?>>£ <?php echo filter_var("Jersey Pound");	?></option>
													<option value="KZT" <?php if ($setting->ld_currency == 'KZT') {
																			echo filter_var(' selected ');
																		} ?>>лв <?php echo filter_var("Kazakhstan Tenge");	?></option>
													<option value="KPW" <?php if ($setting->ld_currency == 'KPW') {
																			echo filter_var(' selected ');
																		} ?>>₩ <?php echo filter_var("Korea(North) Won");	?></option>
													<option value="KRW" <?php if ($setting->ld_currency == 'KRW') {
																			echo filter_var(' selected ');
																		} ?>>₩ <?php echo filter_var("Korea(South) Won");	?></option>
													<option value="KGS" <?php if ($setting->ld_currency == 'KGS') {
																			echo filter_var(' selected ');
																		} ?>>лв <?php echo filter_var("Kyrgyzstan Som");	?></option>

													<option value="KES" <?php if ($setting->ld_currency == 'KES') {
																			echo filter_var(' selected ');
																		} ?>>KSh <?php echo filter_var("Kenyan Shilling");	?></option>


													<option value="LAK" <?php if ($setting->ld_currency == 'LAK') {
																			echo filter_var(' selected ');
																		} ?>>₭ <?php echo filter_var("Laos	Kip");	?></option>
													<option value="LVL" <?php if ($setting->ld_currency == 'LVL') {
																			echo filter_var(' selected ');
																		} ?>>Ls <?php echo filter_var("Latvia Lat");	?></option>
													<option value="LBP" <?php if ($setting->ld_currency == 'LBP') {
																			echo filter_var(' selected ');
																		} ?>>£ <?php echo filter_var("Lebanon Pound");	?></option>
													<option value="LRD" <?php if ($setting->ld_currency == 'LRD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Liberia Dollar");	?></option>
													<option value="LTL" <?php if ($setting->ld_currency == 'LTL') {
																			echo filter_var(' selected ');
																		} ?>>Lt <?php echo filter_var("Lithuania Litas");	?></option>
													<option value="MKD" <?php if ($setting->ld_currency == 'MKD') {
																			echo filter_var(' selected ');
																		} ?>>ден <?php echo filter_var("Macedonia Denar");	?> </option>
													<option value="MYR" <?php if ($setting->ld_currency == 'MYR') {
																			echo filter_var(' selected ');
																		} ?>>RM <?php echo filter_var("Malaysia Ringgit");	?></option>
													<option value="MUR" <?php if ($setting->ld_currency == 'MUR') {
																			echo filter_var(' selected ');
																		} ?>>₨ <?php echo filter_var("Mauritius Rupee");	?></option>
													<option value="MXN" <?php if ($setting->ld_currency == 'MXN') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Mexico Peso");	?></option>
													<option value="MNT" <?php if ($setting->ld_currency == 'MNT') {
																			echo filter_var(' selected ');
																		} ?>>₮ <?php echo filter_var("Mongolia Tughrik");	?></option>
													<option value="MZN" <?php if ($setting->ld_currency == 'MZN') {
																			echo filter_var(' selected ');
																		} ?>>MT <?php echo filter_var("Mozambique Metical");	?></option>

													<option value="MAD" <?php if ($setting->ld_currency == 'MAD') {
																			echo filter_var(' selected ');
																		} ?>>د.م. <?php echo filter_var("Moroccan Dirham");	?></option>
													<option value="MDL" <?php if ($setting->ld_currency == 'MDL') {
																			echo filter_var(' selected ');
																		} ?>>MDL <?php echo filter_var("Moldovan Leu");	?></option>
													<option value="MOP" <?php if ($setting->ld_currency == 'MOP') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Macau Pataca");	?></option>
													<option value="MRO" <?php if ($setting->ld_currency == 'MRO') {
																			echo filter_var(' selected ');
																		} ?>>UM <?php echo filter_var("Mauritania Ougulya");	?></option>
													<option value="MVR" <?php if ($setting->ld_currency == 'MVR') {
																			echo filter_var(' selected ');
																		} ?>>Rf <?php echo filter_var("Maldives Rufiyaa");	?></option>
													<option value="PGK" <?php if ($setting->ld_currency == 'PGK') {
																			echo filter_var(' selected ');
																		} ?>>K <?php echo filter_var("Papua New Guinea Kina");	?></option>



													<option value="NAD" <?php if ($setting->ld_currency == 'NAD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Namibia Dollar");	?></option>
													<option value="NPR" <?php if ($setting->ld_currency == 'NPR') {
																			echo filter_var(' selected ');
																		} ?>>₨ <?php echo filter_var("Nepal Rupee");	?></option>
													<option value="ANG" <?php if ($setting->ld_currency == 'ANG') {
																			echo filter_var(' selected ');
																		} ?>>ƒ <?php echo filter_var("Netherlands Antilles Guilder");	?></option>
													<option value="NZD" <?php if ($setting->ld_currency == 'NZD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("New Zealand Dollar");	?></option>
													<option value="NIO" <?php if ($setting->ld_currency == 'NIO') {
																			echo filter_var(' selected ');
																		} ?>>C$ <?php echo filter_var("Nicaragua Cordoba");	?></option>
													<option value="NGN" <?php if ($setting->ld_currency == 'NGN') {
																			echo filter_var(' selected ');
																		} ?>>₦ <?php echo filter_var("Nigeria Naira");	?></option>
													<option value="NOK" <?php if ($setting->ld_currency == 'NOK') {
																			echo filter_var(' selected ');
																		} ?>>kr <?php echo filter_var("Norway Krone");	?></option>
													<option value="OMR" <?php if ($setting->ld_currency == 'OMR') {
																			echo filter_var(' selected ');
																		} ?>>﷼ <?php echo filter_var("Oman Rial");	?></option>
													<option value="MWK" <?php if ($setting->ld_currency == 'MWK') {
																			echo filter_var(' selected ');
																		} ?>>MK <?php echo filter_var("Malawi Kwacha");	?></option>



													<option value="PKR" <?php if ($setting->ld_currency == 'PKR') {
																			echo filter_var(' selected ');
																		} ?>>₨ <?php echo filter_var("Pakistan Rupee");	?></option>
													<option value="PAB" <?php if ($setting->ld_currency == 'PAB') {
																			echo filter_var(' selected ');
																		} ?>>B/ <?php echo filter_var("Panama Balboa");	?></option>
													<option value="PYG" <?php if ($setting->ld_currency == 'PYG') {
																			echo filter_var(' selected ');
																		} ?>>Gs <?php echo filter_var("Paraguay Guarani");	?></option>
													<option value="PEN" <?php if ($setting->ld_currency == 'PEN') {
																			echo filter_var(' selected ');
																		} ?>>S/ <?php echo filter_var("Peru Nuevo Sol");	?></option>
													<option value="PHP" <?php if ($setting->ld_currency == 'PHP') {
																			echo filter_var(' selected ');
																		} ?>>₱ <?php echo filter_var("Philippines Peso");	?></option>
													<option value="PLN" <?php if ($setting->ld_currency == 'PLN') {
																			echo filter_var(' selected ');
																		} ?>>zł <?php echo filter_var("Poland Zloty");	?></option>
													<option value="QAR" <?php if ($setting->ld_currency == 'QAR') {
																			echo filter_var(' selected ');
																		} ?>>﷼ <?php echo filter_var("Qatar Riyal");	?></option>
													<option value="RON" <?php if ($setting->ld_currency == 'RON') {
																			echo filter_var(' selected ');
																		} ?>>lei <?php echo filter_var("Romania New Leu");	?></option>
													<option value="RUB" <?php if ($setting->ld_currency == 'RUB') {
																			echo filter_var(' selected ');
																		} ?>>руб <?php echo filter_var("Russia Ruble");	?></option>
													<option value="SHP" <?php if ($setting->ld_currency == 'SHP') {
																			echo filter_var(' selected ');
																		} ?>>£ <?php echo filter_var("Saint Helena Pound");	?></option>
													<option value="SAR" <?php if ($setting->ld_currency == 'SAR') {
																			echo filter_var(' selected ');
																		} ?>>﷼ <?php echo filter_var("Saudi Arabia	Riyal");	?></option>
													<option value="RSD" <?php if ($setting->ld_currency == 'RSD') {
																			echo filter_var(' selected ');
																		} ?>>Дин <?php echo filter_var("Serbia Dinar");	?></option>
													<option value="SCR" <?php if ($setting->ld_currency == 'SCR') {
																			echo filter_var(' selected ');
																		} ?>>₨ <?php echo filter_var("Seychelles Rupee");	?></option>
													<option value="SGD" <?php if ($setting->ld_currency == 'SGD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Singapore	Dollar");	?></option>
													<option value="SBD" <?php if ($setting->ld_currency == 'SBD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Solomon Islands Dollar");	?></option>
													<option value="SOS" <?php if ($setting->ld_currency == 'SOS') {
																			echo filter_var(' selected ');
																		} ?>>S <?php echo filter_var("Somalia Shilling");	?></option>

													<option value="SLL" <?php if ($setting->ld_currency == 'SLL') {
																			echo filter_var(' selected ');
																		} ?>>Le <?php echo filter_var("Sierra Leone Leone");	?></option>
													<option value="STD" <?php if ($setting->ld_currency == 'STD') {
																			echo filter_var(' selected ');
																		} ?>>Db <?php echo filter_var("Sao Tome Dobra");	?></option>
													<option value="SZL" <?php if ($setting->ld_currency == 'SZL') {
																			echo filter_var(' selected ');
																		} ?>>SZL <?php echo filter_var("Swaziland Lilageni");	?></option>

													<option value="ZAR" <?php if ($setting->ld_currency == 'ZAR') {
																			echo filter_var(' selected ');
																		} ?>>R <?php echo filter_var("South Africa Rand");	?></option>
													<option value="LKR" <?php if ($setting->ld_currency == 'LKR') {
																			echo filter_var(' selected ');
																		} ?>>₨ <?php echo filter_var("Sri Lanka Rupee");	?></option>
													<option value="SEK" <?php if ($setting->ld_currency == 'SEK') {
																			echo filter_var(' selected ');
																		} ?>>kr <?php echo filter_var("Sweden Krona");	?></option>
													<option value="CHF" <?php if ($setting->ld_currency == 'CHF') {
																			echo filter_var(' selected ');
																		} ?>>CHF <?php echo filter_var("Switzerland Franc");	?> </option>
													<option value="SRD" <?php if ($setting->ld_currency == 'SRD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Suriname Dollar");	?></option>
													<option value="SYP" <?php if ($setting->ld_currency == 'SYP') {
																			echo filter_var(' selected ');
																		} ?>>£ <?php echo filter_var("Syria	Pound");	?></option>

													<option value="TWD" <?php if ($setting->ld_currency == 'TWD') {
																			echo filter_var(' selected ');
																		} ?>>NT <?php echo filter_var("Taiwan New Dollar");	?></option>
													<option value="THB" <?php if ($setting->ld_currency == 'THB') {
																			echo filter_var(' selected ');
																		} ?>>฿ <?php echo filter_var("Thailand Baht");	?></option>

													<option value="TOP" <?php if ($setting->ld_currency == 'TOP') {
																			echo filter_var(' selected ');
																		} ?>>T$ <?php echo filter_var("Tonga Pa'ang");	?></option>
													<option value="TZS" <?php if ($setting->ld_currency == 'TZS') {
																			echo filter_var(' selected ');
																		} ?>>x <?php echo filter_var("Tanzanian Shilling");	?></option>


													<option value="TTD" <?php if ($setting->ld_currency == 'TTD') {
																			echo filter_var(' selected ');
																		} ?>>TTD <?php echo filter_var("Trinidad and Tobago Dollar");	?></option>
													<option value="TRY" <?php if ($setting->ld_currency == 'TRY') {
																			echo filter_var(' selected ');
																		} ?>>₤ <?php echo filter_var("Turkey Lira");	?></option>
													<option value="TVD" <?php if ($setting->ld_currency == 'TVD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("Tuvalu Dollar");	?></option>
													<option value="UAH" <?php if ($setting->ld_currency == 'UAH') {
																			echo filter_var(' selected ');
																		} ?>>₴ <?php echo filter_var("Ukraine Hryvna");	?></option>

													<option value="UGX" <?php if ($setting->ld_currency == 'UGX') {
																			echo filter_var(' selected ');
																		} ?>>USh <?php echo filter_var("Ugandan Shilling");	?></option>

													<option value="GBP" <?php if ($setting->ld_currency == 'GBP') {
																			echo filter_var(' selected ');
																		} ?>>£ <?php echo filter_var("United Kingdom Pound");	?></option>
													<option value="USD" <?php if ($setting->ld_currency == 'USD') {
																			echo filter_var(' selected ');
																		} ?>>$ <?php echo filter_var("United States	Dollar");	?></option>
													<option value="UYU" <?php if ($setting->ld_currency == 'UYU') {
																			echo filter_var(' selected ');
																		} ?>>$U <?php echo filter_var("Uruguay Peso");	?></option>
													<option value="UZS" <?php if ($setting->ld_currency == 'UZS') {
																			echo filter_var(' selected ');
																		} ?>>лв <?php echo filter_var("Uzbekistan Som");	?></option>
													<option value="VEF" <?php if ($setting->ld_currency == 'VEF') {
																			echo filter_var(' selected ');
																		} ?>>Bs <?php echo filter_var("Venezuela Bolivar Fuerte");	?></option>
													<option value="VND" <?php if ($setting->ld_currency == 'VND') {
																			echo filter_var(' selected ');
																		} ?>>₫ <?php echo filter_var("Viet Nam Dong");	?></option>

													<option value="VUV" <?php if ($setting->ld_currency == 'VUV') {
																			echo filter_var(' selected ');
																		} ?>>Vt <?php echo filter_var("Vanuatu Vatu");	?></option>

													<option value="XAF" <?php if ($setting->ld_currency == 'XAF') {
																			echo filter_var(' selected ');
																		} ?>>BEAC <?php echo filter_var("CFA Franc (BEAC)");	?></option>
													<option value="XOF" <?php if ($setting->ld_currency == 'XOF') {
																			echo filter_var(' selected ');
																		} ?>>BCEAO <?php echo filter_var("CFA Franc (BCEAO)");	?></option>
													<option value="XPF" <?php if ($setting->ld_currency == 'XPF') {
																			echo filter_var(' selected ');
																		} ?>>F <?php echo filter_var("Pacific Franc");	?></option>

													<option value="YER" <?php if ($setting->ld_currency == 'YER') {
																			echo filter_var(' selected ');
																		} ?>>﷼ <?php echo filter_var("Yemen	Rial");	?></option>

													<option value="WST" <?php if ($setting->ld_currency == 'WST') {
																			echo filter_var(' selected ');
																		} ?>>WS$ <?php echo filter_var("Samoa Tala");	?></option>


													<option value="ZAR" <?php if ($setting->ld_currency == 'ZAR') {
																			echo filter_var(' selected ');
																		} ?>>R <?php echo filter_var("South African Rand");	?></option>
													<option value="ZWD" <?php if ($setting->ld_currency == 'ZWD') {
																			echo filter_var(' selected ');
																		} ?>>Z$ <?php echo filter_var("Zimbabwe Dollar");	?></option>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['price_format_decimal_places']);	?></label></td>
										<td>
											<div class="form-group">
												<select class="selectpicker" id="ld_price_format_decimal_places" name="ld_price_format_decimal_places" data-size="10" style="display: none;">
													<option value="0" <?php if ($setting->ld_price_format_decimal_places == '0') {
																			echo filter_var('selected');
																		} ?>>0 (e.g.$100)</option>
													<option value="1" <?php if ($setting->ld_price_format_decimal_places == '1') {
																			echo filter_var('selected');
																		} ?>>1 (e.g.$100.0)</option>
													<option value="2" <?php if ($setting->ld_price_format_decimal_places == '2') {
																			echo filter_var('selected');
																		} ?>>2 (e.g.$100.00)</option>
													<option value="3" <?php if ($setting->ld_price_format_decimal_places == '3') {
																			echo filter_var('selected');
																		} ?>>3 (e.g.$100.000)</option>
													<option value="4" <?php if ($setting->ld_price_format_decimal_places == '4') {
																			echo filter_var('selected');
																		} ?>>4 (e.g.$100.0000)</option>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['currency_symbol_position']);	?></label></td>
										<td>
											<div class="form-group">
												<select name="ld_currency_symbol_position" id="ld_currency_symbol_position" class="selectpicker" style="display: none;">
													<option value="$100" <?php if ($setting->ld_currency_symbol_position == '$100') {
																				echo filter_var('selected');
																			} ?>><?php echo filter_var($label_language_values['before_e_g_100']);	?></option>
													<option value="100$" <?php if ($setting->ld_currency_symbol_position == '100$') {
																				echo filter_var('selected');
																			} ?>><?php echo filter_var($label_language_values['after_e_g_100']);	?></option>
												</select>
											</div>
										</td>
									</tr <tr>
									<td><label><?php echo filter_var($label_language_values['tax_vat']);	?></label></td>
									<td>
										<div class="form-group">
											<label class="ctoggle-tax-vat" for="tax-vat">
												<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_tax_vat_status == 'Y') {
																																				echo filter_var('checked');
																																			} ?> id="tax-vat" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
											</label>
											<div class="hide-div mycollapse_tax-vat" <?php if ($setting->ld_tax_vat_status == 'Y') {
																							echo 'style="display:block;"';
																						} ?>>
												<div class="ld-custom-radio">
													<ul class="ld-radio-list">
														<li>
															<input type="radio" id="tax-vat-percentage" class="lda-radio tax_vat_radio" name="tax-vat-radio" <?php if ($setting->ld_tax_vat_type == 'P') {
																																									echo filter_var('checked');
																																								} ?> value="P" />
															<label for="tax-vat-percentage"><span></span> <?php echo filter_var($label_language_values['percentage']);	?> </label>
														</li>
														<li>
															<input type="radio" id="tax-vat-flatfree" class="ld_radio tax_vat_radio" name="tax-vat-radio" <?php if ($setting->ld_tax_vat_type == 'F') {
																																								echo filter_var('checked');
																																							} ?> value="F" />
															<label for="tax-vat-flatfree"><span></span><?php echo filter_var($label_language_values['flat_fee']);	?></label>
														</li>
														<li class="ld-tax-vat-input-container">
															<input type="text" class="form-control" name="ld_tax_vat_value" id="ld_tax_vat_value" value="<?php echo ($setting->ld_tax_vat_value); ?>" size="3" maxlength="5" />
															<i class="ld-tax-percent <?php if ($setting->ld_tax_vat_type == 'P') {
																							echo filter_var('fa fa-percent');
																						} ?>"></i>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['partial_deposit']);	?></label></td>
										<td>
											<div class="form-group">
												<label class="ctoggle-patial-deposit" for="patial-deposit">
													<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_partial_deposit_status == 'Y') {
																																					echo filter_var('checked');
																																				} ?> id="patial-deposit" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
												</label>
												<a class="ld-tooltip-link pr-t0" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['partial_payment_option_will_help_you_to_charge_partial_payment_of_total_amount_from_client_and_remaining_you_can_collect_locally']);	?>."><i class="fa fa-info-circle fa-lg"></i></a>
												<div <?php if ($setting->ld_partial_deposit_status == 'Y') {
															echo 'style="display:block;"';
														} ?> class="hide-div mycollapse_patial-deposit">
													<div class="ld-custom-radio">
														<ul class="ld-radio-list">
															<li class="ld-partial-li-width">
																<input type="radio" id="partial-percentage" class="lda-radio partial_radio" checked="checked" name="partial-radio" <?php if ($setting->ld_partial_type == 'P') {
																																														echo filter_var('checked');
																																													} ?> value="P" />
																<label for="partial-percentage"><span></span> <?php echo filter_var($label_language_values['percentage']);	?> </label>
															</li>
															<li class="ld-partial-li-width">
																<input type="radio" id="partial-flatfree" class="ld_radio partial_radio" name="partial-radio" <?php if ($setting->ld_partial_type == 'F') {
																																									echo filter_var('checked');
																																								} ?> value="F" />
																<label for="partial-flatfree"><span></span><?php echo filter_var($label_language_values['flat_fee']);	?></label>
															</li>
															<li class="ld-tax-vat-input-container">
																<span class="ld-tax-vat-input-container">
																	<label class="pull-left mr-10"><?php echo filter_var($label_language_values['partial_deposit_amount']);	?></label>
																	<span class="ld-partial-input-per"><input type="text" class="form-control" id="ld_partial_deposit_amount" name="lda-partial-deposit" value="<?php echo ($setting->ld_partial_deposit_amount) ?>" size="3" maxlength="3" /> <i class="ld-partial-deposit-percent <?php if ($setting->ld_partial_type == 'P') {
																																																																																		echo filter_var('fa fa-percent');
																																																																																	} ?>"></i></span>
																</span><br />
															</li>
															<li>
																<label><?php echo filter_var($label_language_values['partial_deposit_message']);	?></label>

																<textarea class="form-control" id="ld_partial_deposit_message" row="4" cols="40"><?php echo ($setting->ld_partial_deposit_message) ?></textarea>
															</li>
														</ul>
													</div>
												</div>
											</div>

											<span id="ld-partial-depost_error" style="color:red;"><?php echo filter_var($label_language_values['please_enable_payment_gateway']);	?></span>
										</td>
									</tr>
									<tr>
										<td><label>'<?php echo filter_var($label_language_values['thankyou_page_url']);	?>'</label></td>
										<td>
											<div class="form-group">
												<input type="text" id="ld_thankyou_page_url" class="form-control" size="50" name="ld_thankyou_page_url" value="<?php echo ($setting->ld_thankyou_page_url) ?>" placeholder="<?php echo filter_var($label_language_values['custom_thankyou_page_url']);	?>" /><br />
												<i><?php echo filter_var($label_language_values['default_url_is']);	?> : <?php if ($setting->ld_thankyou_page_url == '') {
																																echo filter_var(SITE_URL, FILTER_VALIDATE_URL) . 'front/thankyou.php';
																															} else {
																																echo ($setting->ld_thankyou_page_url);
																															} ?></i>
											</div>
										</td>
										</td>
									</tr>
									<tr>
										<td>
											<hr />
										</td>
										<td>
											<hr />
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['cancellation_policy']);	?></label></td>
										<td>
											<div class="form-group">
												<label class="ctoggle-cancel-policy" for="cancel-policy">
													<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' name="ld_cancelation_policy_status" <?php if ($setting->ld_cancelation_policy_status == 'Y') {
																																														echo filter_var('checked');
																																													} ?> id="cancel-policy" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
												</label>

												<div <?php if ($setting->ld_cancelation_policy_status == 'Y') {
															echo 'style="display:block;"';
														} ?> class="hide-div mycollapse_cancel-policy">
													<div class="ld-custom-radio">
														<ul class="ld-radio-list np mb-15">
															<li class="w100">
																<label><?php echo filter_var($label_language_values['cancellation_policy_header']);	?></label>
																<input type="text" class="w100 form-control" id="ld_cancel_policy_header" name="ld_cancel_policy_header" value="<?php echo ($setting->ld_cancel_policy_header) ?>" />
															</li>
														</ul>
													</div>
													<label><?php echo filter_var($label_language_values['cancellation_policy_textarea']);	?></label>
													<textarea class="form-control w100" id="ld_cancel_policy_textarea" name="ld_cancel_policy_textarea" row="4" cols="40"><?php echo ($setting->ld_cancel_policy_textarea) ?></textarea>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<hr />
										</td>
										<td>
											<hr />
										</td>

									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['allow_multiple_booking_for_same_timeslot']);	?></label></td>
										<td>
											<div class="form-group">
												<label class="ctoggle-multiple-booking-same-time" for="multiple-booking-same-time">
													<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' name="ld_allow_multiple_booking_for_same_timeslot_status" <?php if ($setting->ld_allow_multiple_booking_for_same_timeslot_status == 'Y') {
																																																			echo filter_var('checked');
																																																		} ?> id="multiple-booking-same-time" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
												</label>
											</div>
											<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['allow_multiple_appointment_booking_at_same_time_slot_will_allow_you_to_show_availability_time_slot_even_you_have_booking_already_for_that_time']);	?>."><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
									<tr>
										<td><label><?php echo "Show Staff Registration"; ?></label></td>
										<td>
											<div class="form-group">
												<label class="ctoggle-staff-regist" for="ctoggle-staff-regist">
													<input data-toggle="toggle" data-size="small" type='checkbox' name="ld_staff_regist" <?php if ($setting->ld_staff_registration == 'Y') {
																																				echo 'checked';
																																			} ?> id="ld_staff_regist" data-on="<?php echo $label_language_values['enable']; ?>" data-off="<?php echo $label_language_values['disable']; ?>" data-onstyle='success' data-offstyle='danger' />
												</label>
											</div>
											<a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo "With enable this feature shows staff registration by admin "; ?>."><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
									<tr>
										<td><label><?php echo "Front Staff Showing On Zipcode"; ?></label></td>
										<td>
											<div class="form-group">
												<label class="ctoggle-staff-zipcode" for="ctoggle-staff-zipcode">
													<input data-toggle="toggle" data-size="small" type='checkbox' name="ld_staff_zipcodes" <?php if ($setting->ld_staff_zipcode == 'Y') {
																																				echo 'checked';
																																			} ?> id="ld_staff_zipcodes" data-on="<?php echo $label_language_values['enable']; ?>" data-off="<?php echo $label_language_values['disable']; ?>" data-onstyle='success' data-offstyle='danger' />
												</label>
											</div>
											<a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo "With enable this feature front staff showing on zipcode by admin "; ?>."><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['appointment_auto_confirm']);	?></label></td>
										<td>
											<div class="form-group">
												<label class="ctoggle-appointment-auto-confirm" for="appointment-auto-confirm">
													<input data-toggle="toggle" data-size="small" type='checkbox' name="ld_appointment_auto_confirm_status" <?php if ($setting->ld_appointment_auto_confirm_status == 'Y') {
																																								echo filter_var('checked');
																																							} ?> id="appointment-auto-confirm" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
												</label>
											</div>
											<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['with_Enable_of_this_feature_Appointment_request_from_clients_will_be_auto_confirmed']);	?>."><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['show_frontend_staff_rating']);	?></label></td>
										<td>
											<div class="form-group">
												<label class="ctoggle-star_show_on_front" for="star_show_on_front">
													<input data-toggle="toggle" data-size="small" type='checkbox' name="ld_star_show_on_front" <?php if ($setting->ld_star_show_on_front == 'Y') {
																																					echo filter_var('checked');
																																				} ?> id="star_show_on_front" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
												</label>
											</div>
											<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['with_enable_of_this_feature_shows_staff_rating_on_front_side']);	?>."><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['terms_and_condition']);	?></label></td>
										<td>
											<div class="form-group">
												<label class="ctoggle-allow-dc-terms-condition" for="allow-dc-terms-condition">
													<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' name="ld_allow_terms_and_conditions" <?php if ($setting->ld_allow_terms_and_conditions == 'Y') {
																																														echo filter_var('checked');
																																													} ?> id="allow-dc-terms-condition" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
												</label>
												<a class="ld-tooltip-link" href="javascript:void(0)" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['terms_and_condition']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
												<div <?php if ($setting->ld_allow_terms_and_conditions == 'Y') {
															echo 'style="display:block;"';
														} ?> class="hide-div mycollapse_allow-dc-terms-condition">
													<div class="ld-custom-radio">
														<ul class="ld-radio-list">
															<li>
																<label><?php echo filter_var($label_language_values['terms_and_condition_link']);	?></label>
																<input type="text" class="form-control" size="50" id="ld_terms_condition_header" name="ld_terms_condition_header" value="<?php echo ($setting->ld_terms_condition_link);	?>"></textarea>
															</li>
														</ul>
													</div>
												</div>

											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['privacy_policy']);	?></label></td>
										<td>
											<div class="form-group">
												<label class="ctoggle-allow-dc-privacy_policy" for="allow-dc-privacy_policy">
													<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' name="allow-dc-privacy_policy" <?php if ($setting->ld_allow_privacy_policy == 'Y') {
																																													echo filter_var('checked');
																																												} ?> id="allow-dc-privacy_policy" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
												</label>
												<a class="ld-tooltip-link" href="javascript:void(0)" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['privacy_policy']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
												<div <?php if ($setting->ld_allow_privacy_policy == 'Y') {
															echo 'style="display:block;"';
														} ?> class="hide-div mycollapse_allow-dc-privacy_policy">
													<div class="ld-custom-radio">
														<ul class="ld-radio-list">
															<li class="ld-privacy-policy-li-width">
																<label><?php echo filter_var($label_language_values['privacy_policy']);	?></label>
																<input type="text" class="form-control" size="50" id="ld_privacy_policy_link" name="ld_privacy_policy_link" value="<?php echo ($setting->ld_privacy_policy_link);	?>"></textarea>
															</li>
														</ul>
													</div>
												</div>

											</div>
										</td>
									</tr>


									<!-- <tr>
<td><label><?php echo filter_var($label_language_values['default_design_for_methods_with_multiple_units']);	?></label></td>
<td>
<div class="form-group">
<select name="ld_method_default_design" id="ld_method_default_design" class="selectpicker" style="display: none;">
<option value="2" <?php if ($setting->ld_method_default_design == '2') {
						echo filter_var('selected');
					} ?>><?php echo filter_var($label_language_values['dropdown_design']);	?></option>
<option value="3" <?php if ($setting->ld_method_default_design == '3') {
						echo filter_var('selected');
					} ?>><?php echo filter_var($label_language_values['blocks_as_button_design']);	?></option>
<option value="4" <?php if ($setting->ld_method_default_design == '4') {
						echo filter_var('selected');
					} ?>><?php echo filter_var($label_language_values['qty_control_design']);	?></option>
</select>

</div>
</td>
</tr> -->
									<tr>
										<td><label><?php echo filter_var($label_language_values['default_design_for_addons']);	?></label></td>
										<td>
											<div class="form-group">
												<select name="ld_addons_default_design" id="ld_addons_default_design" class="selectpicker" style="display: none;">
													<option value="1" <?php if ($setting->ld_addons_default_design == '1') {
																			echo filter_var('selected');
																		} ?>><?php echo filter_var($label_language_values['qty_control_design']);	?></option>
													<option value="2" <?php if ($setting->ld_addons_default_design == '2') {
																			echo filter_var('selected');
																		} ?>><?php echo filter_var($label_language_values['blocks_as_button_design']);	?></option>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['default_design_for_services']);	?></label></td>
										<td>
											<div class="form-group">
												<select name="ld_service_default_design" id="ld_service_default_design" class="selectpicker" style="display: none;">
													<option value="1" <?php if ($setting->ld_service_default_design == '1') {
																			echo filter_var('selected');
																		} ?>><?php echo filter_var($label_language_values['big_images_radio']);	?></option>
													<option value="2" <?php if ($setting->ld_service_default_design == '2') {
																			echo filter_var('selected');
																		} ?>><?php echo filter_var($label_language_values['dropdown_design']);	?></option>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['change_calculation_policyy']);	?></label></td>
										<td>
											<div class="form-group">
												<select name="ld_service_default_design" id="ld_price_calculation_method" class="selectpicker" style="display: none;">
													<option value="M" <?php if ($setting->get_option("ld_calculation_policy") == 'M') {
																			echo filter_var('selected');
																		} ?>><?php echo filter_var($label_language_values['multiply']);	?></option>
													<option value="E" <?php if ($setting->get_option("ld_calculation_policy") == 'E') {
																			echo filter_var('selected');
																		} ?>><?php echo filter_var($label_language_values['equal']);	?></option>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['right_side_description']);	?></label></td>
										<td>
											<div class="form-group">
												<label class="ctoggle-ld_allow_front_desc" for="ld_allow_front_desc">
													<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' name="ld_allow_front_desc" <?php if ($setting->ld_allow_front_desc == 'Y') {
																																												echo filter_var('checked');
																																											} ?> id="ld_allow_front_desc" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
												</label>
												<a class="ld-tooltip-link" href="javascript:void(0)" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['write_html_code_for_the_right_side_panel']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>

											</div>
											<div <?php if ($setting->ld_allow_front_desc == 'Y') {
														echo 'style="display:block;"';
													} ?> class="hide-div mycollapse_ld_allow_front_desc">
												<textarea class="form-control" id="ld_front_desc" row="12" cols="80"><?php echo urldecode($setting->get_option('ld_front_desc'));	?></textarea>
											</div>
										</td>
									</tr>
									<?php
									$ld_minimum_delivery_days = $setting->ld_minimum_delivery_days;
									?>
									<tr>
										<td>
											<label><?php echo filter_var($label_language_values['minimum_delivery_days']);	?></label>
										</td>
										<td>
											<div class="input-group spinner">
												<div class="input-group-btn-horizontal input-plus-minus">
													<button class="btn ld-subtraction-btn1 btn-default input-group-addon" type="button" data-id="input-min"><i class="fa fa-minus nm"></i></button>
													<input placeholder="00" size="2" maxlength="2" type="text" name="minimumhours" id="txtedtminimumhours" class="form-control ld_minimum_delivery_days input-min" value="<?php echo filter_var($ld_minimum_delivery_days); ?>" />
													<button data-id="input-min" class="btn ld-addition-btn1 btn-default input-group-addon" type="button"><i class="fa fa-plus nm"></i></button>
												</div>
											</div>

										</td>
									</tr>
									<tr>
										<td>
											<label><?php echo filter_var($label_language_values['show_self_service_option']);	?></label>
										</td>
										<td>
											<div class="form-group">
												<label class="ctoggle-ld_self_pickup_delivery" for="ld_self_pickup_delivery">
													<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' name="ld_self_pickup_delivery" <?php if ($setting->ld_show_self_service == 'E') {
																																													echo filter_var('checked');
																																												} ?> id="ld_show_self_service" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
												</label>
												<a class="ld-tooltip-link" href="javascript:void(0)" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['show_self_service_option']); ?>"><i class="fa fa-info-circle fa-lg"></i></a>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<label><?php echo filter_var($label_language_values['show_delivery_date']);	?></label>
										</td>
										<td>
											<div class="form-group">
												<label class="ctoggle-ld_pickup_delivery" for="ld_pickup_delivery">
													<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' name="ld_pickup_delivery" <?php if ($setting->ld_show_delivery_date == 'E') {
																																											echo filter_var('checked');
																																										} ?> id="ld_show_delivery_date" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
												</label>
												<a class="ld-tooltip-link" href="javascript:void(0)" data-toggle="tooltip" title="Pickup And Delivery."><i class="fa fa-info-circle fa-lg"></i></a>
											</div>
										</td>
									</tr>
								</tbody>

								<tfoot>
									<tr>
										<td></td>
										<td>
											<a id="general_setting" name="" class="btn btn-success"><?php echo filter_var($label_language_values['save_setting']);	?></a>
										</td>
									</tr>
								</tfoot>
							</table>

						</div>
					</div>
				</form>
			</div>
			<div class="tab-pane fade in" id="appearance-setting">
				<form id="loginpageimage" method="post" enctype="multipart/form-data" class="ld-appearance-settings">

					<div class="panel panel-default">
						<div class="panel-heading lda-top-right">
							<h1 class="panel-title"><?php echo filter_var($label_language_values['appearance_settings']);	?></h1>
							<span class="pull-right lda-setting-fix-btn"><button id="appearance_settings" type="submit" name="appreance" class="btn btn-success appearance_settings_btn_check"><?php echo filter_var($label_language_values['save_setting']);	?></button></span>
						</div>
						<div class="panel-body pt-50 plr-10">
							<table class="form-inline ld-common-table">

								<tbody>
									<tr>
										<td><label><?php echo filter_var($label_language_values['color_scheme']);	?></label></td>
										<td>
											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-15 npl">
												<label><?php echo filter_var($label_language_values['primary_color']);	?></label>
												<input type="text" name="ld_primary_color" id="ld-primary-color" class="form-control demo primary_color" data-control="saturation" value="<?php echo ($setting->ld_primary_color) ?>" />
											</div>
											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-15">
												<label><?php echo filter_var($label_language_values['secondary_color']);	?></label>
												<input type="text" name="ld_secondary_color" id="ld-secondary-color" class="form-control demo secondary_color" data-control="saturation" value="<?php echo ($setting->ld_secondary_color) ?>" />
											</div>
											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-15">
												<label><?php echo filter_var($label_language_values['text_color']);	?></label>
												<input type="text" name="ld_text_color" id="ld-text-color" class="form-control demo text_color" data-control="saturation" value="<?php echo ($setting->ld_text_color) ?>" />
											</div>
											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-15">
												<label><?php echo filter_var($label_language_values['text_color_on_bg']);	?></label>
												<input type="text" name="ld_text_color_on_bg" id="ld-text-color-bg" class="form-control demo text_color_bg" data-control="saturation" value="<?php echo ($setting->ld_text_color_on_bg) ?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td><label> <?php echo filter_var($label_language_values['admin_area_color_scheme']);	?></label></td>
										<td>
											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 npl mb-15">
												<label><?php echo filter_var($label_language_values['primary_color']);	?></label>
												<input type="text" name="ld_primary_color_admin" id="ld-primary-color-admin" class="form-control demo ld_primary_color_admin" data-control="saturation" value="<?php echo ($setting->ld_primary_color_admin) ?>" />
											</div>
											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-15">
												<label><?php echo filter_var($label_language_values['secondary_color']);	?></label>
												<input type="text" name="ld_secondary_color_admin" id="ld-secondary-color-admin" class="form-control demo secondary_color_admin" data-control="saturation" value="<?php echo ($setting->ld_secondary_color_admin) ?>" />
											</div>
											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-15">
												<label><?php echo filter_var($label_language_values['text_color']);	?></label>
												<input type="text" name="ld_text_color_admin" id="ld-text-color-admin" class="form-control demo text_color_admin" data-control="saturation" value="<?php echo ($setting->ld_text_color_admin) ?>" />
											</div>

											<div class="col-lg-3 col-md-3 col-sm-6 mb-15">
											</div>
											<div class="col-lg-3 col-md-3 col-sm-6 mb-15">
												<p class="btn" style="color:#31b0d5;" name="reset_color" id="reset_color"><?php echo filter_var($label_language_values['Reset_Color']);	?></p>
											</div>
										</td>
									</tr>

									<tr>
										<td><label><?php echo filter_var($label_language_values['hide_faded_already_booked_time_slots']);	?></label></td>
										<td>
											<div class="form-group">
												<label for="hide-booked-slot">
													<input data-toggle="toggle" data-size="small" name="fadded_slots" type='checkbox' <?php if ($setting->ld_hide_faded_already_booked_time_slots == 'on') {
																																			echo filter_var('checked');
																																		} ?> id="hide-booked-slot" data-on="<?php echo filter_var($label_language_values['o_n']);	?>" data-off="<?php echo filter_var($label_language_values['off']);	?>" data-onstyle='primary' data-offstyle='default' />
												</label>
											</div>
											<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="With this you can hide the already booked slots just to hide your bookings from your Competitors."><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['guest_user_checkout']);	?></label></td>
										<td>
											<div class="form-group">
												<label for="guest-user-checkout">
													<input data-toggle="toggle" name="guc_check" data-size="small" type='checkbox' <?php if ($setting->ld_guest_user_checkout == 'on') {
																																		echo filter_var('checked');
																																	} ?> name="" id="guest-user-checkout" data-on="<?php echo filter_var($label_language_values['o_n']);	?>" data-off="<?php echo filter_var($label_language_values['off']);	?>" data-onstyle='primary' data-offstyle='default' />
												</label>
											</div>
											<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['with_this_feature_you_can_allow_a_visitor_to_book_appointment_without_registration']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['existing_and_new_user_checkout']);	?> </label></td>
										<td>
											<div class="form-group">
												<label for="existing-and-new-user-checkout">
													<input data-toggle="toggle" name="eu_nu_check" data-size="small" type='checkbox' <?php if ($setting->ld_existing_and_new_user_checkout == 'on') {
																																			echo filter_var('checked');
																																		} ?> id="existing-and-new-user-checkout" data-on="<?php echo filter_var($label_language_values['o_n']);	?>" data-off="<?php echo filter_var($label_language_values['off']);	?>" data-onstyle='primary' data-offstyle='default' />
												</label>
											</div>
											<a class="ld-tooltip-link" href="javascript:void(0)" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['it_will_allow_option_for_user_to_get_booking_with_new_user_or_existing_user']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['time_format']);	?></label></td>
										<td>
											<div class="form-group">
												<select class="selectpicker" id="ld_time_format" data-size="5" name="ld_time_format" style="display: none;width:auto">
													<option value="12" <?php if ($setting->ld_time_format == '12') {
																			echo filter_var('selected');
																		} ?>>12 <?php echo filter_var($label_language_values['hours']);	?></option>
													<option value="24" <?php if ($setting->ld_time_format == '24') {
																			echo filter_var('selected');
																		} ?>>24 <?php echo filter_var($label_language_values['hours']);	?></option>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['scrollable_cart']);	?></label></td>
										<td>
											<div class="form-group">
												<label for="ld_cart_scrollable">
													<input data-toggle="toggle" name="ld_cart_scrollable" data-size="small" type='checkbox' <?php if ($setting->ld_cart_scrollable == 'Y') {
																																				echo filter_var('checked');
																																			} ?> id="ld_cart_scrollable" data-on="<?php echo filter_var($label_language_values['o_n']);	?>" data-off="<?php echo filter_var($label_language_values['off']);	?>" data-onstyle='primary' data-offstyle='default' />
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['date_picker_date_format']);	?></label></td>
										<td>
											<div class="form-group">
												<select name="ld_date_picker_date_format" id="date_format_datepicker" class="selectpicker form-control" data-size="5" data-live-search="true" data-live-search-placeholder="<?php echo filter_var($label_language_values['search']);	?>" data-actions-box="true">
													<option value="d-m-Y" <?php if ($setting->ld_date_picker_date_format == 'd-m-Y') {
																				echo filter_var('selected');
																			} ?>>dd-mm-yyyy (eg. <?php echo date('d-m-Y');	?>)</option>
													<option value="j-m-Y" <?php if ($setting->ld_date_picker_date_format == 'j-m-Y') {
																				echo filter_var('selected');
																			} ?>>d-mm-yyyy (eg. <?php echo date('j-n-Y');	?>)</option>
													<option value="d-M-Y" <?php if ($setting->ld_date_picker_date_format == 'd-M-Y') {
																				echo filter_var('selected');
																			} ?>>dd-m-yyyy (eg. <?php echo date('d-M-Y');	?>)</option>
													<option value="d-F-Y" <?php if ($setting->ld_date_picker_date_format == 'd-F-Y') {
																				echo filter_var('selected');
																			} ?>>dd-m-yyyy (eg. <?php echo date('d-F-Y');	?>)</option>
													<option value="j-M-Y" <?php if ($setting->ld_date_picker_date_format == 'j-M-Y') {
																				echo filter_var('selected');
																			} ?>>d-m-yyyy (eg. <?php echo date('j-M-Y');	?>)</option>
													<option value="j-F-Y" <?php if ($setting->ld_date_picker_date_format == 'j-F-Y') {
																				echo filter_var('selected');
																			} ?>>dd-m-yyyy (eg. <?php echo date('j-F-Y');	?>)</option>


													<option value="d/m/Y" <?php if ($setting->ld_date_picker_date_format == 'd/m/Y') {
																				echo filter_var('selected');
																			} ?>>dd/mm/yyyy (eg. <?php echo date('d/m/Y');	?>)</option>
													<option value="j/m/Y" <?php if ($setting->ld_date_picker_date_format == 'j/m/Y') {
																				echo filter_var('selected');
																			} ?>>d/mm/yyyy (eg. <?php echo date('j/m/Y');	?>)</option>
													<option value="d/M/Y" <?php if ($setting->ld_date_picker_date_format == 'd/M/Y') {
																				echo filter_var('selected');
																			} ?>>dd/m/yyyy (eg. <?php echo date('d/M/Y');	?>)</option>
													<option value="d/F/Y" <?php if ($setting->ld_date_picker_date_format == 'd/F/Y') {
																				echo filter_var('selected');
																			} ?>>dd/M/yyyy (eg. <?php echo date('d/F/Y');	?>)</option>
													<option value="j/M/Y" <?php if ($setting->ld_date_picker_date_format == 'j/M/Y') {
																				echo filter_var('selected');
																			} ?>>d/m/yyyy (eg. <?php echo date('j/M/Y');	?>)</option>
													<option value="j/F/Y" <?php if ($setting->ld_date_picker_date_format == 'j/F/Y') {
																				echo filter_var('selected');
																			} ?>>d/M/yyyy (eg. <?php echo date('j/F/Y');	?>)</option>


													<option value="m-d-Y" <?php if ($setting->ld_date_picker_date_format == 'm-d-Y') {
																				echo filter_var('selected');
																			} ?>>mm-dd-yyyy (eg. <?php echo date('m-d-Y');	?>)</option>
													<option value="m-j-Y" <?php if ($setting->ld_date_picker_date_format == 'm-j-Y') {
																				echo filter_var('selected');
																			} ?>>mm-d-yyyy (eg. <?php echo date('m-j-Y');	?>)</option>
													<option value="M-d-Y" <?php if ($setting->ld_date_picker_date_format == 'M-d-Y') {
																				echo filter_var('selected');
																			} ?>>m-dd-yyyy (eg. <?php echo date('M-d-Y');	?>)</option>
													<option value="F-d-Y" <?php if ($setting->ld_date_picker_date_format == 'F-d-Y') {
																				echo filter_var('selected');
																			} ?>>m-dd-yyyy (eg. <?php echo date('F-d-Y');	?>)</option>
													<option value="M-j-Y" <?php if ($setting->ld_date_picker_date_format == 'M-j-Y') {
																				echo filter_var('selected');
																			} ?>>m-d-yyyy (eg. <?php echo date('M-j-Y');	?>)</option>
													<option value="F-j-Y" <?php if ($setting->ld_date_picker_date_format == 'F-j-Y') {
																				echo filter_var('selected');
																			} ?>>m-dd-yyyy (eg. <?php echo date('F-j-Y');	?>)</option>

													<option value="m/d/Y" <?php if ($setting->ld_date_picker_date_format == 'm/d/Y') {
																				echo filter_var('selected');
																			} ?>>mm/dd/yyyy (eg. <?php echo date('m/d/Y');	?>)</option>
													<option value="m/j/Y" <?php if ($setting->ld_date_picker_date_format == 'm/j/Y') {
																				echo filter_var('selected');
																			} ?>>mm/d/yyyy (eg. <?php echo date('m/j/Y');	?>)</option>
													<option value="M/d/Y" <?php if ($setting->ld_date_picker_date_format == 'M/d/Y') {
																				echo filter_var('selected');
																			} ?>>m/dd/yyyy (eg. <?php echo date('M/d/Y');	?>)</option>
													<option value="F/d/Y" <?php if ($setting->ld_date_picker_date_format == 'F/d/Y') {
																				echo filter_var('selected');
																			} ?>>m/dd/yyyy (eg. <?php echo date('F/d/Y');	?>)</option>
													<option value="M/j/Y" <?php if ($setting->ld_date_picker_date_format == 'M/j/Y') {
																				echo filter_var('selected');
																			} ?>>m/d/yyyy (eg. <?php echo date('M/j/Y');	?>)</option>
													<option value="F/j/Y" <?php if ($setting->ld_date_picker_date_format == 'F/j/Y') {
																				echo filter_var('selected');
																			} ?>>m/dd/yyyy (eg. <?php echo date('F/j/Y');	?>)</option>

													<option value="j M,Y" <?php if ($setting->ld_date_picker_date_format == 'j M,Y') {
																				echo filter_var('selected');
																			} ?>>dd m,yyyy (eg. <?php echo date('j M,Y');	?>)</option>
													<option value="M j, Y" <?php if ($setting->ld_date_picker_date_format == 'M j, Y') {
																				echo filter_var('selected');
																			} ?>>m dd,yyyy (eg. <?php echo date('M j, Y');	?>)</option>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td><?php echo filter_var($label_language_values['default_country_code']);	?></td>
										<?php
										$arrs = explode(",", $setting->get_option("ld_phone_display_country_code"));
										$country_code_alpha_array = array(
											array("af", "Afghanistan (&#8235;افغانستان&#8236;&lrm;)", "+93"), array("al", "Albania (Shqipëri)", "+355  "), array("dz", "Algeria (&#8235;الجزائر&#8236;&lrm;)", "+213"), array("as", "American Samoa", "+1684 "), array("ad", "Andorra", "+376"), array("ao", "Angola", "+244"), array("ai", "Anguilla", "+1264"), array("ag", "Antigua and Barbuda", "+1268"), array("ar", "Argentina", "+54"), array("am", "Armenia (Հայաստան)", "+374"), array("aw", "Aruba", "+297"), array("au", "Australia", "+61"), array("at", "Austria (Österreich)", "+43"), array("az", "Azerbaijan (Azərbaycan)", "+994"), array("bs", "Bahamas", "+1242"), array("bh", "Bahrain (&#8235;البحرين&#8236;&lrm;)", "+973"), array("ct", "Bangladesh (বাংলাদেশ)", "+880"), array("bb", "Barbados", "+1246"), array("by", "Belarus (Беларусь)", "+375"), array("be", "Belgium (België)", "+32"), array("bz", "Belize", "+501"), array("bj", "Benin (Bénin)", "+229"), array("bm", "Bermuda", "+1441"), array("bt", "Bhutan (འབྲུག)  ", "+975"), array("bo", "Bolivia", "+591"), array("ba", "Bosnia and Herzegovina (Босна и Херцеговина)", "+387"), array("bw", "Botswana", "+267"), array("br", "Brazil (Brasil)", "+55"), array("io", "British Indian Ocean Territory", "+246"), array("vg", "British Virgin Islands", "+1284"), array("bn", "Brunei", "+673"), array("bg", "Bulgaria (България)", "+359"), array("bf", "Burkina Faso", "+226"), array("bi", "Burundi (Uburundi)", "+257"), array("kh", "Cambodia (កម្ពុជា)", "+855 "), array("cm", "Cameroon (Cameroun)", "+237"), array("ca", "Canada", "+1"), array("cv", "Cape Verde (Kabu Verdi)", "+238 "), array("bq", "Caribbean Netherlands", "+599 "), array("ky", "Cayman Islands", "+1345"), array("cf", "Central African Republic (République centrafricaine)", "+236"), array("td", "Chad (Tchad)", "+23"), array("cl", "Chile", "+56"), array("cn", "China (中国)", "+86"), array("cx", "Christmas Island", "+61"), array("cc", "Cocos (Keeling) Islands", "+61"), array("co", "Colombia", "+57"), array("km", "Comoros (&#8235;جزر القمر&#8236;&lrm;)", "+269"), array("cd", "Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)", "+243"), array("cg", "Congo (Republic) (Congo-Brazzaville)", "+242"), array("ck", "Cook Islands", "+682"), array("cr", "Costa Rica", "+506"), array("ci", "Côte d’Ivoire", "+225"), array("hr", "Croatia (Hrvatska)", "+385"), array("cu", "Cuba", "+53"), array("cw", "Curaçao", "+599"), array("cy", "Cyprus (Κύπρος)", "+357"), array("cz", "Czech Republic (Česká republika)", "+420"), array("dk", "Denmark (Danmark)", "+45"), array("dj", "Djibouti", "+253"), array("dm", "Dominica", "+1767"), array("do", "Dominican Republic (República Dominicana)", "+1"), array("ec", "Ecuador", "+593"), array("eg", "Egypt (&#8235;مصر&#8236;&lrm;)", "+20 "), array("sv", "El Salvador", "+503"), array("gq", "Equatorial Guinea (Guinea Ecuatorial)", "+240"), array("er", "Eritrea", "+291"), array("ee", "Estonia (Eesti)", "+372"), array("et", "Ethiopia", "+251"), array("fk", "Falkland Islands (Islas Malvinas)", "+500"), array("fo", "Faroe Islands (Føroyar)", "+298"), array("fj", "Fiji", "+679"), array("fi", "Finland (Suomi)", "+358"), array("fr", "France", "+33"), array("gf", "French Guiana (Guyane française)", "+594"), array("pf", "French Polynesia (Polynésie française)", "+689"), array("ga", "Gabon", "+241"), array("gm", "Gambia", "+220"), array("ge", "Georgia (საქართველო)", "+995"), array("de", "Germany (Deutschland)", "+49"), array("gh", "Ghana (Gaana)", "+233"), array("gi", "Gibraltar", "+350"), array("gr", "Greece (Ελλάδα)", "+30"), array("gl", "Greenland (Kalaallit Nunaat)", "+299"), array("gd", "Grenada", "+1473"), array("gp", "Guadeloupe", "+590"), array("gu", "Guam", "+1671"), array("gt", "Guatemala", "+502"), array("gg", "Guernsey", "+44"), array("gn", "Guinea (Guinée)", "+224"), array("gw", "Guinea-Bissau (Guiné Bissau)", "+245"), array("gy", "Guyana", "+592"), array("ht", "Haiti", "+509"), array("hn", "Honduras", "+504"), array("hk", "Hong Kong (香港)", "+852"), array("hu", "Hungary (Magyarország)", "+36"), array("is", "Iceland (Ísland)", "+354"), array("in", "India (भारत)", "+91"), array("id", "Indonesia", "+62"), array("ir", "Iran (&#8235;ایران&#8236;&lrm;)", "+98"), array("iq", "Iraq (&#8235;العراق&#8236;&lrm;)", "+964"), array("ie", "Ireland", "+353"), array("im", "Isle of Man", "+44"), array("il", "Israel (&#8235;ישראל&#8236;&lrm;)", "+972"), array("it", "Italy (Italia)", "+39"), array("jm", "Jamaica", "+1876"), array("jp", "Japan (日本)", "+81"), array("je", "Jersey", "+44"), array("jo", "Jordan (&#8235;الأردن&#8236;&lrm;)", "+962"), array("kz", "Kazakhstan (Казахстан)", "+7"), array("ke", "Kenya", "+254"), array("ki", "Kiribati", "+686"), array("kw", "Kuwait (&#8235;الكويت&#8236;&lrm;)", "+965"), array("kg", "Kyrgyzstan (Кыргызстан)", "+996"), array("la", "Laos (ລາວ)", "+856"), array("lv", "Latvia (Latvija)", "+371"), array("lb", "Lebanon (&#8235;لبنان&#8236;&lrm;)", "+961"), array("ls", "Lesotho", "+266"), array("lr", "Liberia", "+231"), array("ly", "Libya (&#8235;ليبيا&#8236;&lrm;)", "+218"), array("li", "Liechtenstein", "+423"), array("lt", "Lithuania (Lietuva)", "+370"), array("lu", "Luxembourg", "+352"), array("mo", "Macau (澳門)", "+853"), array("mk", "Macedonia (FYROM) (Македонија)", "+389"), array("mg", "Madagascar (Madagasikara)", "+261"), array("mw", "Malawi", "+265"), array("my", "Malaysia", "+60"), array("mv", "Maldives", "+960"), array("ml", "Mali", "+223"), array("mt", "Malta", "+356"), array("mh", "Marshall Islands", "+692"), array("mq", "Martinique", "+596"), array("mr", "Mauritania (&#8235;موريتانيا&#8236;&lrm;)", "+222"), array("mu", "Mauritius (Moris)", "+230"), array("yt", "Mayotte", "+262"), array("mx", "Mexico (México)", "+52"), array("fm", "Micronesia", "+691"), array("md", "Moldova (Republica Moldova)", "+373"), array("mc", "Monaco", "+377"), array("mn", "Mongolia (Монгол)", "+976"), array("me", "Montenegro (Crna Gora)", "+382"), array("ms", "Montserrat", "+1664"), array("ma", "Morocco (&#8235;المغرب&#8236;&lrm;)", "+212"), array("mz", "Mozambique (Moçambique)", "+258"), array("mm", "Myanmar (Burma) (မြန်မာ)", "+95"), array("na", "Namibia (Namibië)", "+264"), array("nr", "Nauru", "+674"), array("np", "Nepal (नेपाल)", "+977"), array("nl", "Netherlands (Nederland)", "+31"), array("nc", "New Caledonia (Nouvelle-Calédonie)", "+687"), array("nz", "New Zealand", "+64"), array("ni", "Nicaragua", "+505"), array("ne", "Niger (Nijar)", "+227"), array("ng", "Nigeria", "+234"), array("nu", "Niue", "+683"), array("nf", "Norfolk Island", "+672"), array("kp", "North Korea (조선 민주주의 인민 공화국)", "+850"), array("mp", "Northern Mariana Islands", "+1670"), array("no", "Norway (Norge)", "+47"), array("om", "Oman (&#8235;عُمان&#8236;&lrm;)", "+968"), array("pk", "Pakistan (&#8235;پاکستان&#8236;&lrm;)", "+92"), array("pw", "Palau", "+680"), array("ps", "Palestine (&#8235;فلسطين&#8236;&lrm;)", "+970"), array("pa", "Panama (Panamá)", "+507"), array("pg", "Papua New Guinea", "+675"), array("py", "Paraguay", "+595"), array("pe", "Peru (Perú)", "+51"), array("ph", "Philippines", "+63"), array("pl", "Poland (Polska)", "+48"), array("pt", "Portugal", "+351"), array("pr", "Puerto Rico", "+1"), array("qa", "Qatar (&#8235;قطر&#8236;&lrm;)", "+974"), array("re", "Réunion (La Réunion)", "+262"), array("ro", "Romania (România)", "+40"), array("ru", "Russia (Россия)", "+7"), array("rw", "Rwanda", "+250"), array("bl", "Saint Barthélemy (Saint-Barthélemy)", "+590"), array("sh", "Saint Helena", "+290"), array("kn", "Saint Kitts and Nevis", "+1869"), array("lc", "Saint Lucia", "+1758"), array("mf", "Saint Martin (Saint-Martin (partie française))", "+590"), array("pm", "Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)", "+508"), array("vc", "Saint Vincent and the Grenadines", "+1784"), array("ws", "Samoa", "+685"), array("sm", "San Marino", "+378"), array("st", "São Tomé and Príncipe (São Tomé e Príncipe)", "+239"), array("sa", "Saudi Arabia (&#8235;المملكة العربية السعودية&#8236;&lrm;)", "+966"), array("sn", "Senegal (Sénégal)", "+221"), array("rs", "Serbia (Србија)", "+381"), array("sc", "Seychelles", "+248"), array("sl", "Sierra Leone", "+232"), array("sg", "Singapore", "+65"), array("sx", "Sint Maarten", "+1721"), array("sk", "Slovakia (Slovensko)", "+421"), array("si", "Slovenia (Slovenija)", "+386"), array("sb", "Solomon Islands", "+677"), array("so", "Somalia (Soomaaliya)", "+252"), array("za", "South Africa", "+27"), array("kr", "South Korea (대한민국)", "+82"), array("ss", "South Sudan (&#8235;جنوب السودان&#8236;&lrm;)", "+211"), array("es", "Spain (España)", "+34"), array("lk", "Sri Lanka (ශ්&zwj;රී ලංකාව)", "+94"), array("sd", "Sudan (&#8235;السودان&#8236;&lrm;)", "+249"), array("sr", "Suriname", "+597"), array("sj", "Svalbard and Jan Mayen", "+47"), array("sz", "Swaziland", "+268"), array("se", "Sweden (Sverige)", "+46"), array("ch", "Switzerland (Schweiz)", "+41"), array("sy", "Syria (&#8235;سوريا&#8236;&lrm;)", "+963"), array("tw", "Taiwan (台灣)", "+886"), array("tj", "Tajikistan", "+992"), array("tz", "Tanzania", "+255"), array("th", "Thailand (ไทย)", "+66"), array("tl", "Timor-Leste", "+670"), array("tg", "Togo", "+228"), array("tk", "Tokelau", "+690"), array("to", "Tonga", "+676"), array("tt", "Trinidad and Tobago", "+1868"), array("tn", "Tunisia (&#8235;تونس&#8236;&lrm;)", "+216"), array("tr", "Turkey (Türkiye)", "+90"), array("tm", "Turkmenistan", "+993"), array("tc", "Turks and Caicos Islands", "+1649"), array("tv", "Tuvalu", "+688"), array("vi", "U.S. Virgin Islands", "+1340"), array("ug", "Uganda", "+256"), array("ua", "Ukraine (Україна)", "+380"), array("ae", "United Arab Emirates (&#8235;الإمارات العربية المتحدة&#8236;&lrm;)", "+971"), array("gb", "United Kingdom", "+44"), array("us", "United States", "+1"), array("uy", "Uruguay", "+598"), array("uz", "Uzbekistan (Oʻzbekiston)", "+998"), array("vu", "Vanuatu", "+678"), array("va", "Vatican City (Città del Vaticano)", "+39"), array("ve", "Venezuela", "+58"), array("vn", "Vietnam (Việt Nam)", "+84"), array("wf", "Wallis and Futuna", "+681"), array("eh", "Western Sahara (&#8235;الصحراء الغربية&#8236;&lrm;)", "+212"), array("ye", "Yemen (&#8235;اليمن&#8236;&lrm;)", "+967"), array("zm", "Zambia", "+260"), array("zw", "Zimbabwe", "+263"), array("ax", "Åland Islands", "+358")
										); ?>
										<td>
											<select name="selected_country_code_display[]" multiple class="selectpicker" data-size="10" data-live-search="true" data-live-search-placeholder="search">

												<?php
												for ($i = 0; $i < count($country_code_alpha_array); $i++) {
												?>
													<option <?php if (in_array($country_code_alpha_array[$i][0], $arrs)) {
																echo filter_var("selected");
															} ?> data-subtext="<?php echo filter_var($country_code_alpha_array[$i][1]); ?> - <?php echo filter_var($country_code_alpha_array[$i][2]); ?>" value="<?php echo filter_var($country_code_alpha_array[$i][0]);	?>"><?php echo filter_var($country_code_alpha_array[$i][0]); ?></option>
												<?php
												}
												?>
											</select>

										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['custom_css']);	?></label></td>
										<td>
											<div class="form-group col-xs-12 np">
												<textarea class="form-control" style="width: 100%; min-height: 150px;" name="cust_css" id="ld_custom_css"><?php echo filter_var($setting->get_option("ld_custom_css"));	?></textarea>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['login_page']);	?></label></td>
										<td>
											<div class="form-group">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<span class="btn btn-default btn-file mt-15"><input type="file" id="login_page" name="loginimg" /></span>
													<a id="loginbg" class="mt-15 btn btn-info"><i class="fa fa-edit"></i><?php echo filter_var($label_language_values['restore_default']);	?></a><br>
													<span class="fileinput-filename"><?php echo filter_var($label_language_values['recommended_image_type_jpg_jpeg_png_gif']);	?></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['front_page']);	?></label></td>
										<td>
											<div class="form-group">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<span class="btn btn-default btn-file mt-15"><input type="file" id="front_page" name="frontimage" /></span>
													<a id="frontbg" class="mt-15 btn btn-info"><i class="fa fa-edit"></i><?php echo filter_var($label_language_values['restore_default']);	?></a><br>
													<span class="fileinput-filename"><?php echo filter_var($label_language_values['recommended_image_type_jpg_jpeg_png_gif']);	?></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td><label><?php echo filter_var($label_language_values['favicon_image']);	?></label></td>
										<td>
											<div class="form-group">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<span class="btn btn-default btn-file mt-15"><input type="file" id="favicon_page" name="faviconimage" /></span>
													<br>
													<span class="fileinput-filename"><?php echo filter_var($label_language_values['recommended_image_type_jpg_jpeg_png_gif']);	?></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td><?php echo filter_var($label_language_values['Loader']);	?></td>
										<td>
											<div class="ld-custom-radio">
												<ul class="ld-radio-list">
													<label class="radio-inline"><input type="radio" name="ld_loader_option" id="ld_cssloader" <?php if ($setting->get_option("ld_loader") == 'css') {
																																					echo filter_var('checked');
																																				} ?> value="css"><?php echo filter_var($label_language_values['CSS_Loader']);	?></label>

													<label class="radio-inline"><input type="radio" name="ld_loader_option" id="ld_gifloader" <?php if ($setting->get_option("ld_loader") == 'gif') {
																																					echo filter_var('checked');
																																				} ?> value="gif"><?php echo filter_var($label_language_values['GIF_Loader']);	?></label>

													<label class="radio-inline"><input type="radio" name="ld_loader_option" id="ld_defaultloader" <?php if ($setting->get_option("ld_loader") == 'default') {
																																						echo filter_var('checked');
																																					} ?> value="default"><?php echo filter_var($label_language_values['Default_Loader']);	?></label>
												</ul>
											</div>
										</td>
									</tr>
									<tr class="ld_GIF_Loader_div">
										<td><?php echo filter_var($label_language_values['GIF_Loader']);	?></td>
										<td>
											<div class="form-group">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<span class="btn btn-default btn-file mt-15"><input type="file" class="ld_frontend_gif_loader_file" name="ld_frontend_gif_loader_file" /></span>
													&nbsp;
													<img id="ld_upload_gif_loader_preview" <?php if ($setting->get_option("ld_custom_gif_loader") == '') {
																								echo filter_var('style="display:none;"');
																							} ?> class="mt-15" height="40px" width="40px" <?php if ($setting->get_option("ld_custom_gif_loader") != '') {
																																																														echo 'src="' . SITE_URL . '/assets/images/gif-loader/' . $setting->get_option("ld_custom_gif_loader") . '"';
																																																													} ?> />
													<br>
													<span class="fileinput-filename"><?php echo filter_var($label_language_values['recommended_image_type_jpg_jpeg_png_gif']);	?></span>
												</div>
											</div>
										</td>
									</tr>
									<tr class="ld_CSS_Loader_div">
										<td><?php echo filter_var($label_language_values['CSS_Loader']);	?></td>
										<td>
											<div class="form-group col-xs-12 np">
												<div class="col-md-7 np">
													<textarea class="form-control" style="width: 100%; min-height: 150px;" name="ld_custom_css_loader" id="ld_custom_css_loader"><?php echo filter_var($setting->get_option("ld_custom_css_loader"));	?></textarea>
												</div>
												<div class="col-md-4 ld_custom_css_loader_preview_overlay">
													<?php echo filter_var($setting->get_option("ld_custom_css_loader")); ?>
												</div>
											</div>
										</td>
									</tr>
									<tr class="ld_calendar_defaultView">
										<td><?php echo filter_var($label_language_values['Calendar_Default_View']);	?></td>
										<td>
											<div class="form-group col-xs-12 np">
												<div class="col-md-7 np">
													<select name="ld_calendar_defaultView" class="selectpicker">
														<option <?php if ($setting->get_option("ld_calendar_defaultView") == 'month') {
																	echo filter_var("selected");
																} ?> value="month">Month</option>
														<option <?php if ($setting->get_option("ld_calendar_defaultView") == 'agendaWeek') {
																	echo filter_var("selected");
																} ?> value="agendaWeek">Week</option>
														<option <?php if ($setting->get_option("ld_calendar_defaultView") == 'agendaDay') {
																	echo filter_var("selected");
																} ?> value="agendaDay">Day</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr class="ld_calendar_firstDay">
										<td><?php echo filter_var($label_language_values['Calendar_Fisrt_Day']);	?></td>
										<td>
											<div class="form-group col-xs-12 np">
												<div class="col-md-7 np">
													<select name="ld_calendar_firstDay" class="selectpicker">
														<option <?php if ($setting->get_option("ld_calendar_firstDay") == '0') {
																	echo filter_var("selected");
																} ?> value="0">Sunday</option>
														<option <?php if ($setting->get_option("ld_calendar_firstDay") == '1') {
																	echo filter_var("selected");
																} ?> value="1">Monday</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td></td>
										<td>
											<button id="appreance" value="Save Member" class="btn btn-success appearance_settings_btn_check" type="submit" name="appreance"><?php echo filter_var($label_language_values['save_setting']);	?></button>
										</td>
									</tr>
								</tfoot>
							</table>

						</div>
					</div>
				</form>
			</div>
			<div class="tab-pane fade in" id="payment-setting">
				<form id="payment_getway_form" method="post" type="" class="ld-payment-settings">
					<div class="panel panel-default">
						<div class="panel-heading lda-top-right">
							<h1 class="panel-title"><?php echo filter_var($label_language_values['payment_gateways']);	?></h1>
							<span class="pull-right lda-setting-fix-btn"><a id="payment_setting" name="save-payment-gateways-setting" class="btn btn-success ld-btn-width"><?php echo filter_var($label_language_values['save_setting']);	?></a></span>
						</div>
						<div class="panel-body pt-50 pt plr-10">
							<div id="accordion" class="panel-group">
								<div class="panel panel-default ld-all-payments-main">

									<div style="display:block;" id="collapseOne" class="panel-collapse collapse mycollapse_all-payment-gateways">
										<div class="panel-body p-10">

											<div class="alert alert-danger payment_warning" style="display:none;">
												<a href="#" class="payment_warning_close close">&times;</a>
												<strong>Warning! </strong>
												<p id="payment_warning" style="display: inline;" class=""></p>
											</div>
											<div id="accordion" class="panel-group">
												<div class="panel panel-default ld-payment-methods">
													<div class="panel-heading">
														<h4 class="panel-title">
															<span><?php echo filter_var($label_language_values['pay_locally']);	?></span>
															<div class="ld-enable-disable-right ld-pay-locally pull-right">
																<label class="ctoggle-pay-locally" for="pay-locally">
																	<input class='lda-toggle-checkbox payment_choice' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_pay_locally_status == 'on') {
																																															echo filter_var('checked');
																																														} ?> id="pay-locally" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

																</label>
															</div>

														</h4>
													</div>
												</div>

												<div class="panel panel-default ld-payment-methods">
													<div class="panel-heading">
														<h4 class="panel-title">
															<span><?php echo filter_var($label_language_values['paypal_express_checkout']);	?><img class="lda-paypal-img-payments" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/paypal.png" /></span>
															<div class="ld-enable-disable-right pull-right">
																<label class="ctoggle-paypal-checkout" for="paypal-checkout">
																	<input class='lda-toggle-checkbox payment_choice' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_paypal_express_checkout_status == 'on') {
																																															echo filter_var('checked');
																																														} ?> id="paypal-checkout" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

																</label>
															</div>

														</h4>
													</div>
													<div <?php if ($setting->ld_paypal_express_checkout_status == 'on') {
																echo 'style="display:block"';
															} ?> id="collapseOne" class="panel-collapse collapse mycollapse_paypal-checkout">
														<div class="panel-body p-10">
															<table class="form-inline ld-common-table">
																<tbody>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['api_username']);	?></label></td>
																		<td>
																			<div class="form-group ld-lgf">
																				<input type="text" class="form-control" id="ld_paypal_api_username" value="<?php echo ($setting->ld_paypal_api_username) ?>" name="ld-paypal-api-username" size="50" />
																				<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['paypal_api_username_can_get_easily_from_developer_paypal_com_account']);	?>"><i class="fa fa-info-circle fa-lg lgf"></i></a>
																			</div>

																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['api_password']);	?></label></td>
																		<td>
																			<div class="form-group ld-lgf">
																				<input type="text" class="form-control" id="ld_paypal_api_password" value="<?php echo ($setting->ld_paypal_api_password) ?>" name="ld-paypal-api-password" size="50" />
																				<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['paypal_api_password_can_get_easily_from_developer_paypal_com_account']);	?>"><i class="fa fa-info-circle fa-lg lgf"></i></a>
																			</div>

																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['signature']);	?></label></td>
																		<td>
																			<div class="form-group ld-lgf">
																				<input type="text" class="form-control" id="ld_paypal_api_signature" value="<?php echo ($setting->ld_paypal_api_signature) ?>" name="ld-paypal-api-signature" size="50" />
																				<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['paypal_api_signature_can_get_easily_from_developer_paypal_com_account']);	?>"><i class="fa fa-info-circle fa-lg lgf"></i></a>
																			</div>

																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['paypal_guest_payment']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<label class="ctoggle-paypal-guest-payment" for="paypal-guest-payment">
																					<input data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_paypal_guest_payment_status == 'on') {
																																						echo filter_var('checked');
																																					} ?> name="" id="paypal-guest-payment" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

																				</label>
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['let_user_pay_through_credit_card_without_having_paypal_account']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['test_mode']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<label class="ctoggle-paypal-test-mode" for="paypal-test-mode">
																					<input data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_paypal_test_mode_status == 'on') {
																																						echo filter_var('checked');
																																					} ?> name="" id="paypal-test-mode" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

																				</label>
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['you_can_enable_paypal_test_mode_for_sandbox_account_testing']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>

												<div class="panel panel-default ld-payment-methods">
													<div class="panel-heading">
														<h4 class="panel-title">
															<span><?php echo filter_var($label_language_values['authorize_net']);	?> <?php echo filter_var($label_language_values['payment_form']);	?></span><img class="lda-authorize-img-payments" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/authorize-net.png" />
															<div class="ld-enable-disable-right pull-right">
																<label class="ctoggle-authorizedotnet-payment-checkout" for="authorizedotnet-payment-checkout">
																	<input class='lda-toggle-checkbox payment_choice' data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_authorizenet_status == 'on') {
																																													echo filter_var('checked');
																																												} ?> name="" id="authorizedotnet-payment-checkout" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

																</label>
															</div>
														</h4>
													</div>
													<div id="collapseOne" <?php if ($setting->ld_authorizenet_status == 'on') {
																				echo 'style="display:block"';
																			} ?> class="panel-collapse collapse mycollapse_authorizedotnet-payment-checkout">
														<div class="panel-body p-10">
															<table class="form-inline ld-common-table">
																<tbody>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['api_login_id']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld-authorizenet-API-login-ID" value="<?php echo ($setting->ld_authorizenet_API_login_ID);	?>" name="ld-authorizenet-API-login-ID" size="50" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['transaction_key']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld-authorize-transaction-key" name="ld-authorize-transaction-key" value="<?php echo ($setting->ld_authorizenet_transaction_key);	?>" size="50" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['sandbox_mode']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<label class="ctoggle-authorize-sandbox-mode" for="authorize-sandbox-mode">
																					<input data-toggle="toggle" data-size="small" type='checkbox' id="authorize-sandbox-mode" <?php if ($setting->ld_authorize_sandbox_mode == 'on') {
																																													echo filter_var('checked');
																																												} ?> data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																				</label>
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['you_can_enable_authorize_net_test_mode_for_sandbox_account_testing']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																		</td>
																	</tr>

																</tbody>
															</table>
														</div>
													</div>
												</div>

												<div class="panel panel-default ld-payment-methods">
													<div class="panel-heading">
														<h4 class="panel-title">
															<span><?php echo filter_var($label_language_values['stripe']);	?> <?php echo filter_var($label_language_values['payment_form']);	?></span><img class="lda-authorize-img-payments" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/stripe.jpg" />
															<div class="ld-enable-disable-right pull-right">
																<label class="ctoggle-stripe-payment-checkout" for="stripe-payment-checkout">
																	<input class="lda-toggle-checkbox payment_choice" data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_stripe_payment_form_status == 'on') {
																																													echo filter_var('checked');
																																												} ?> name="" id="stripe-payment-checkout" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

																</label>
															</div>
														</h4>
													</div>
													<div id="collapseOne" <?php if ($setting->ld_stripe_payment_form_status == 'on') {
																				echo 'style="display:block"';
																			} ?> class="panel-collapse collapse mycollapse_stripe-payment-checkout">
														<div class="panel-body p-10">
															<table class="form-inline ld-common-table">
																<tbody>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['secret_key']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_stripe_secretkey" value="<?php echo ($setting->ld_stripe_secretkey) ?>" name="ld-stripe-secretKey" size="50" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['publishable_key']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_stripe_publishablekey" value="<?php echo ($setting->ld_stripe_publishablekey) ?>" name="ld-paypal-stripe- publishableKey" size="50" />
																			</div>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>

												<div class="panel panel-default ld-payment-methods">
													<div class="panel-heading">
														<h4 class="panel-title">
															<span><?php echo filter_var($label_language_values['checkout_title']);	?> <?php echo filter_var($label_language_values['payment_form']);	?></span><img class="lda-authorize-img-payments" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/2checkout.png" />
															<div class="ld-enable-disable-right pull-right">
																<label class="ctoggle-twocheckout-payment-checkout" for="twocheckout-payment-checkout">
																	<input class="lda-toggle-checkbox payment_choice" data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_2checkout_status == 'Y') {
																																													echo filter_var('checked');
																																												} ?> name="" id="twocheckout-payment-checkout" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

																</label>
															</div>
														</h4>
													</div>
													<div id="collapseOne" <?php if ($setting->ld_2checkout_status == 'Y') {
																				echo 'style="display:block"';
																			} ?> class="panel-collapse collapse mycollapse_twocheckout-payment-checkout">
														<div class="panel-body p-10">
															<table class="form-inline ld-common-table">
																<tbody>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['publishable_key']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_2checkout_publishkey" value="<?php echo filter_var($setting->ld_2checkout_publishkey); ?>" name="ld_2checkout_publishkey" size="50" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['private_key']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_2checkout_privatekey" value="<?php echo filter_var($setting->ld_2checkout_privatekey); ?>" name="ld_2checkout_privatekey" size="50" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['seller_id']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_2checkout_sellerid" value="<?php echo filter_var($setting->ld_2checkout_sellerid); ?>" name="ld_2checkout_sellerid" size="50" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['test_mode']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<label class="ctoggle-2checkout-test-mode" for="ld_2checkout_sandbox_mode">
																					<input data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_2checkout_sandbox_mode == 'Y') {
																																						echo filter_var('checked');
																																					} ?> name="" id="ld_2checkout_sandbox_mode" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

																				</label>
																			</div>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>



												<div class="panel panel-default ld-payment-methods">
													<div class="panel-heading">
														<h4 class="panel-title">
															<span><?php echo filter_var($label_language_values['payumoney']);	?></span><img class="lda-authorize-img-payments" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/payumoney.jpg" />
															<div class="ld-enable-disable-right pull-right">
																<label class="ctoggle-payumoney-payment-checkout" for="payu-money">
																	<input class="lda-toggle-checkbox payment_choice" data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_payumoney_status == 'Y') {
																																													echo filter_var('checked');
																																												} ?> name="" id="payu-money" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																</label>
															</div>
														</h4>
													</div>
													<div id="collapseOne" <?php if ($setting->ld_payumoney_status == 'Y') {
																				echo 'style="display:block"';
																			} ?> class="panel-collapse collapse mycollapse_payu-money">
														<div class="panel-body p-10">
															<table class="form-inline ld-common-table">
																<tbody>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['merchant_key']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_payumoney_merchant_key" value="<?php echo filter_var($setting->ld_payumoney_merchant_key); ?>" name="ld_payumoney_merchant_key" size="50" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['salt_key']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_payumoney_salt" value="<?php echo filter_var($setting->ld_payumoney_salt); ?>" name="ld_payumoney_salt" size="50" />
																			</div>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>

												<div class="panel panel-default ld-payment-methods">
													<div class="panel-heading">
														<h4 class="panel-title">
															<span><?php echo filter_var($label_language_values['bank_transfer']);	?></span>
															<div class="payment-icon"><i class="fa fa-money" aria-hidden="true"></i></div>
															<div class="ld-enable-disable-right pull-right">
																<label class="ctoggle-bank-transfer-payment-checkout" for="bank-transfer-payment-checkout">
																	<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_bank_transfer_status == 'Y') {
																																									echo filter_var('checked');
																																								} ?> name="" id="bank-transfer-payment-checkout" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

																</label>
															</div>
														</h4>

													</div>


													<div id="collapseOne" <?php if ($setting->ld_bank_transfer_status == 'Y') {
																				echo 'style="display:block"';
																			} ?> class="panel-collapse collapse mycollapse_bank-transfer-payment-checkout">
														<div class="panel-body p-10">
															<table class="form-inline ld-common-table">
																<tbody>

																	<tr>
																		<td><label><?php echo filter_var($label_language_values['bank_name']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_bank_name" value="<?php echo  $setting->get_option('ld_bank_name');	?>" name="" size="50" />

																			</div>
																		</td>
																	</tr>

																	<tr>
																		<td><label><?php echo filter_var($label_language_values['account_name']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_account_name" value="<?php echo  $setting->get_option('ld_account_name');	?>" name="" size="50" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['account_number']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_account_number" value="<?php echo  $setting->get_option('ld_account_number');	?>" name="" size="50" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['branch_code']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_branch_code" value="<?php echo  $setting->get_option('ld_branch_code');	?>" name="" size="10" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['ifsc_code']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<input type="text" class="form-control" id="ld_ifsc_code" value="<?php echo  $setting->get_option('ld_ifsc_code');	?>" name="" size="30" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['bank_description']);	?></label></td>
																		<td>
																			<div class="form-group">
																				<textarea class="form-control" id="ld_bank_description" value="" cols="48" rows="3"><?php echo  $setting->get_option('ld_bank_description');	?></textarea>
																			</div>
																		</td>
																	</tr>

																</tbody>
															</table>
														</div>
													</div>
												</div>


												<?php
												if (sizeof($purchase_check) > 0) {
													foreach ($purchase_check as $key => $val) {
														if ($val == 'Y') {
															echo filter_var($payment_hook->payment_setting_hook($key));
														}
													}
												}
												?>


											</div>

										</div>
									</div>
								</div>
								<a id="payment_setting" name="save-payment-gateways-setting" class="btn btn-success ld-btn-width mt-20 ml-10"><?php echo filter_var($label_language_values['save_setting']);	?></a>

							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="tab-pane fade in" id="email-setting">
				<form method="post" type="" class="ld-email-settings">
					<div class="panel panel-default">
						<div class="panel-heading lda-top-right">
							<h1 class="panel-title"><?php echo filter_var($label_language_values['email_settings']);	?></h1>
							<span class="pull-right lda-setting-fix-btn"> <a id="email_setting" name="" class="btn btn-success"><?php echo filter_var($label_language_values['save_setting']);	?></a></span>
						</div>
						<div class="panel-body pt-50 plr-10">

							<div class="panel-body">
								<table class="form-inline ld-common-table">
									<tbody>
										<tr>
											<td><label><?php echo filter_var($label_language_values['admin_email_notifications']);	?></label></td>
											<td>
												<div class="form-group">
													<label class="ctoggle-admin-email-notification" for="admin-email-notification">
														<input data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_admin_email_notification_status == 'Y') {
																															echo filter_var('checked');
																														} ?> name="" id="admin-email-notification" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

													</label>
												</div>
											</td>
										</tr>

										<tr>
											<td><label><?php echo filter_var($label_language_values['client_email_notifications']);	?></label></td>
											<td>
												<div class="form-group">
													<label class="ctoggle-client-email-notification" for="client-email-notification">
														<input data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_client_email_notification_status == 'Y') {
																															echo filter_var('checked');
																														} ?> name="" id="client-email-notification" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

													</label>
												</div>
											</td>
										</tr>
										<tr>
											<td><label><?php echo filter_var($label_language_values['staff_email_notification']);	?></label></td>
											<td>
												<div class="form-group">
													<label class="ctoggle-client-email-notification" for="client-email-notification">
														<input data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_staff_email_notification_status == 'Y') {
																															echo filter_var('checked');
																														} ?> name="" id="staff-email-notification" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

													</label>
												</div>
											</td>
										</tr>

										<tr>
											<td><label><?php echo filter_var($label_language_values['administrator_email']);	?></label></td>
											<td>
												<div class="form-group">
													<input type="" value="<?php echo filter_var($admin_optional_email);	?>" class="form-control w-300" name="admin_optional_email" id="admin_optional_email" placeholder="admin@example.com" />
												</div>
											</td>
										</tr>
										<tr>
											<td class="np">
												<hr />
											</td>
											<td class="np">
												<hr />
											</td>
										</tr>
										<tr>
											<td><label><?php echo filter_var($label_language_values['sender_name']);	?></label></td>
											<td>
												<div class="form-group">
													<input type="" value="<?php echo $setting->ld_email_sender_name;	?>" class="form-control w-300" name="" id="sender_name" />
												</div>
											</td>
										</tr>
										<tr>
											<td><label><?php echo filter_var($label_language_values['sender_email_address_laundry_admin_email']);	?></label></td>
											<td>
												<div class="form-group">
													<input type="" value="<?php echo ($setting->ld_email_sender_address) ?>" class="form-control w-300" name="ld_email_sender_address" id="sender_email" placeholder="admin@example.com" />
												</div>
											</td>
										</tr>
										<tr>
											<td class="np">
												<hr />
											</td>
											<td class="np">
												<hr />
											</td>
										</tr>

										<tr>
											<td><label>SMTP <?php echo filter_var($label_language_values['hostname']);	?></label></td>
											<td>
												<div class="form-group">
													<input type="" value="<?php echo ($setting->ld_smtp_hostname);	?>" class="form-control w-300" name="" id="ld_smtp_hostname" />
												</div>
											</td>
										</tr>
										<tr>
											<td><label>SMTP <?php echo filter_var($label_language_values['username']);	?></label></td>
											<td>
												<div class="form-group">
													<input type="" value="<?php echo ($setting->ld_smtp_username) ?>" class="form-control w-300" name="" id="ld_smtp_username" />
												</div>
											</td>
										</tr>
										<tr>
											<td><label>SMTP <?php echo filter_var($label_language_values['password']);	?></label></td>
											<td>
												<div class="form-group">
													<input type="" value="<?php echo ($setting->ld_smtp_password) ?>" class="form-control w-300" name="" id="ld_smtp_password" />
												</div>
											</td>
										</tr>

										<tr>
											<td><label>SMTP <?php echo filter_var($label_language_values['port']);	?></label></td>
											<td>
												<div class="form-group">
													<input type="" value="<?php echo ($setting->ld_smtp_port) ?>" class="form-control w-300" name="" id="ld_smtp_port" />
												</div>
											</td>
										</tr>
										<tr>
											<td><label><?php echo filter_var($label_language_values['encryption_type']);	?></label></td>
											<td>
												<div class="form-group">
													<select name="ld_email_appointment_encryption" id="encryption_val" class="selectpicker" data-size="5" style="display: none;">
														<option <?php if ($setting->ld_smtp_encryption == '') {
																	echo filter_var("selected");
																} ?> value=""><?php echo filter_var($label_language_values['plain']);	?></option>
														<option <?php if ($setting->ld_smtp_encryption == 'tls') {
																	echo filter_var("selected");
																} ?> value="tls">TLS</option>
														<option <?php if ($setting->ld_smtp_encryption == 'ssl') {
																	echo filter_var("selected");
																} ?> value="ssl">SSL</option>
													</select>
												</div>
											</td>
										</tr>
										<tr>
											<td><label>SMTP <?php echo filter_var($label_language_values['authetication']);	?></label></td>
											<td>
												<div class="form-group">
													<select name="ld_email_appointment_authentication" id="authentication_val" class="selectpicker" data-size="5" style="display: none;">
														<option <?php if ($setting->ld_smtp_authetication == 'false') {
																	echo filter_var("selected");
																} ?> value="false"><?php echo filter_var($label_language_values['false']);	?></option>
														<option <?php if ($setting->ld_smtp_authetication == 'true') {
																	echo filter_var("selected");
																} ?> value="true"><?php echo filter_var($label_language_values['true']);	?></option>
													</select>
												</div>
											</td>
										</tr>
										<tr>
											<td class="np">
												<hr />
											</td>
											<td class="np">
												<hr />
											</td>
										</tr>

										<tr>
											<td><label><?php echo filter_var($label_language_values['appointment_reminder_buffer']);	?></label></td>
											<td>
												<div class="form-group">
													<select name="ld_email_appointment_reminder_buffer" id="appointment_reminder" class="selectpicker" data-size="5" style="display: none;">
														<option value=""><?php echo filter_var($label_language_values['set_email_reminder_buffer']);	?></option>
														<option value="60" <?php if ($setting->ld_email_appointment_reminder_buffer == '60') {
																				echo filter_var('selected');
																			} ?>>1 <?php echo filter_var($label_language_values['hours']);	?></option>
														<option value="120" <?php if ($setting->ld_email_appointment_reminder_buffer == '120') {
																				echo filter_var('selected');
																			} ?>>2 <?php echo filter_var($label_language_values['hours']);	?></option>
														<option value="180" <?php if ($setting->ld_email_appointment_reminder_buffer == '180') {
																				echo filter_var('selected');
																			} ?>>3 <?php echo filter_var($label_language_values['hours']);	?></option>
														<option value="240" <?php if ($setting->ld_email_appointment_reminder_buffer == '240') {
																				echo filter_var('selected');
																			} ?>>4 <?php echo filter_var($label_language_values['hours']);	?></option>
														<option value="300" <?php if ($setting->ld_email_appointment_reminder_buffer == '300') {
																				echo filter_var('selected');
																			} ?>>5 <?php echo filter_var($label_language_values['hours']);	?></option>
														<option value="360" <?php if ($setting->ld_email_appointment_reminder_buffer == '360') {
																				echo filter_var('selected');
																			} ?>>6 <?php echo filter_var($label_language_values['hours']);	?></option>
														<option value="420" <?php if ($setting->ld_email_appointment_reminder_buffer == '420') {
																				echo filter_var('selected');
																			} ?>>7 <?php echo filter_var($label_language_values['hours']);	?></option>
														<option value="480" <?php if ($setting->ld_email_appointment_reminder_buffer == '480') {
																				echo filter_var('selected');
																			} ?>>8 <?php echo filter_var($label_language_values['hours']);	?></option>
														<option value="1440" <?php if ($setting->ld_email_appointment_reminder_buffer == '1440') {
																					echo filter_var('selected');
																				} ?>>1 <?php echo filter_var($label_language_values['days']);	?></option>
													</select>
												</div>
												<div class="ld-reminder-buffer">
													Note: You can set the following file as a cron job on your server to make the 'appointment reminder notification' working.<br />
													<b>Cronjob file:</b>&nbsp;<?php echo ROOT_PATH; ?>assets/lib/email_reminder_ajax.php
												</div>
											</td>
										</tr>


									</tbody>
									<tfoot>
										<tr>
											<td></td>
											<td>
												<a id="email_setting" name="" class="btn btn-success"><?php echo filter_var($label_language_values['save_setting']);	?></a>
											</td>
										</tr>
									</tfoot>
								</table>


							</div>

						</div>
					</div>
				</form>
			</div>

			<div class="tab-pane fade in" id="email-template">
				<div class="ld-email-template-panel panel panel-default wf-100">
					<div class="panel-heading">
						<h1 class="panel-title"><?php echo filter_var($label_language_values['email_template_settings']);	?></h1>
					</div>

					<ul class="nav nav-tabs nav-justified">
						<li class="active"><a data-toggle="tab" href="#client-email-template"><?php echo filter_var($label_language_values['client_email_templates']);	?></a></li>
						<li><a data-toggle="tab" href="#admin-email-template"><?php echo filter_var($label_language_values['admin_email_template']);	?></a></li>
						<li><a data-toggle="tab" href="#staff-email-template"><?php echo filter_var($label_language_values['staff_email_template']);	?></a></li>
					</ul>
					<div class="tab-content">
						<div id="client-email-template" class="tab-pane fade in active">
							<h3><?php echo filter_var($label_language_values['client_email_templates']);	?></h3>
							<div id="accordion" class="panel-group">
								<ul class="nav nav-tab nav-stacked">
									<?php
									$readall_client_email_template = $email_template->readall_client_email_template();
									$ti = 1;
									while ($readall_client = mysqli_fetch_array($readall_client_email_template)) {
									?>
										<li class="panel panel-default ld-client-email-temp-panel">
											<div class="panel-heading br-2">
												<h4 class="panel-title">
													<div class="lda-col11">
														<div class="pull-left">
															<div class="ld-yes-no-email-right pull-left">
																<label class="ld-toggle" for="email-client<?php echo filter_var($readall_client['id']); ?>">
																	<input class='lda-toggle-checkbox save_client_email_template_status' <?php if ($readall_client['email_template_status'] == 'E') { ?> checked <?php  } ?> data-toggle="toggle" data-size="small" type='checkbox' data-id="<?php echo filter_var($readall_client['id']);; ?>" id="email-client<?php echo filter_var($readall_client['id']); ?>" data-on="<?php echo filter_var($label_language_values['o_n']);	?>" data-off="<?php echo filter_var($label_language_values['off']);	?>" data-onstyle='primary' data-offstyle='default' />

																</label>
															</div>
														</div>
														<span class="ld-template-name"><?php echo filter_var($label_language_values[strtolower(str_replace(" ", "_", $readall_client['email_subject']))]); ?></span>
													</div>
													<div class="pull-right lda-col1">
														<div class="pull-right">
															<div class="ld-show-hide pull-right">
																<input type="checkbox" name="ld-show-hide" class="ld-show-hide-checkbox ld_open_close_email_template" id="ce<?php echo filter_var($readall_client['id']); ?>" data-id="<?php echo filter_var($readall_client['id']); ?>">
																<label class="ld-show-hide-label" for="ce<?php echo filter_var($readall_client['id']); ?>"></label>
															</div>
														</div>
													</div>

												</h4>
											</div>
											<div id="detail_email_templates_<?php echo filter_var($readall_client['id']); ?>" class="panel-collapse collapse email_content detail_ce<?php echo filter_var($readall_client['id']); ?>">
												<div class="panel-body p-10">
													<div class="ld-email-temp-collapse-div col-md-12 col-lg-12 col-xs-12 np">
														<form id="" method="post" type="" class="slide-toggle email_template_form">
															<div class="col-md-8 col-sm-8 col-xs-12">
																<textarea class="form-control" name="email_message<?php echo filter_var($ti);	?>" id="email_message_<?php echo filter_var($readall_client['id']); ?>" cols="50" rows="20" placeholder="Add here your message"><?php if ($readall_client['email_message'] != '') {
																																																																						echo base64_decode($readall_client['email_message']);
																																																																					} else {
																																																																						echo base64_decode($readall_client['default_message']);
																																																																					} ?></textarea>

																<input type="submit" class="btn btn-success ld-btn-width pull-left cb ml-15 mt-20" name="template<?php echo filter_var($ti);	?>" value="Save Template">
																<input type="hidden" name="hdntemplate<?php echo filter_var($ti);	?>" value="<?php echo filter_var($readall_client['id']); ?>">

																<a id="default_email_contents" name="" data-id="<?php echo filter_var($readall_client['id']); ?>" class="btn btn-primary ld-btn-width cb ml-15 mt-20" type="submit"><?php echo filter_var($label_language_values['default_template']);	?></a>

																<a name="" data-id="<?php echo filter_var($readall_client['id']); ?>" class="btn btn-warning ld-btn-width cb ml-15 mt-20 preview_email_contents" data-title="<?php echo filter_var($label_language_values[strtolower(str_replace(" ", "_", $readall_client['email_subject']))]); ?>" type="submit"><?php echo filter_var($label_language_values['preview_template']);	?></a>
															</div>
															<div class="col-md-4 col-sm-4 col-xs-12">
																<div class="ld-email-content-tags">
																	<b><?php echo filter_var($label_language_values['tags']);	?></b><br>
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{booking_date}}">{{<?php echo filter_var($label_language_values['booking_date']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{booking_time}}">{{<?php echo filter_var($label_language_values['booking_time']);	?>}}</a><br />
																	<?php if ($setting->get_option('ld_show_delivery_date') == 'E') { ?>
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{booking_delivery_date}}">{{<?php echo filter_var('delivery_date');	?>}}</a><br />
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{booking_delivery_time}}">{{<?php echo filter_var('delivery_time');	?>}}</a><br />
																	<?php } ?>
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{service_name}}">{{<?php echo filter_var($label_language_values['service_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{client_name}}">{{<?php echo filter_var($label_language_values['client_name']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{units}}">{{<?php echo filter_var($label_language_values['units']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{firstname}}">{{<?php echo filter_var($label_language_values['firstname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{lastname}}">{{<?php echo filter_var($label_language_values['lastname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{client_email}}">{{<?php echo filter_var($label_language_values['client_email']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{phone}}">{{<?php echo filter_var($label_language_values['client__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{payment_method}}">{{<?php echo filter_var($label_language_values['payment_method']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{notes}}">{{<?php echo filter_var($label_language_values['notes']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{contact_status}}">{{<?php echo filter_var($label_language_values['contact_status']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{price}}">{{<?php echo filter_var($label_language_values['price']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{address}}">{{<?php echo filter_var($label_language_values['client__address']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{client_city}}">{{<?php echo filter_var($label_language_values['client__city']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{client_state}}">{{<?php echo filter_var($label_language_values['client__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{client_zip}}">{{<?php echo filter_var($label_language_values['client__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{client_promocode}}">{{<?php echo filter_var($label_language_values['client__promocode']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{app_remain_time}}">{{<?php echo filter_var($label_language_values['app_remain_time']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{reject_status}}">{{<?php echo filter_var($label_language_values['reject_status']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{business_logo}}">{{<?php echo filter_var($label_language_values['business_logo']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{admin_name}}">{{<?php echo filter_var($label_language_values['admin_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{company_name}}">{{<?php echo filter_var($label_language_values['company__name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{company_address}}">{{<?php echo filter_var($label_language_values['company__address']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{company_city}}">{{<?php echo filter_var($label_language_values['company__city']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{company_state}}">{{<?php echo filter_var($label_language_values['company__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{company_zip}}">{{<?php echo filter_var($label_language_values['company__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{company_country}}">{{<?php echo filter_var($label_language_values['company__country']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{company_phone}}">{{<?php echo filter_var($label_language_values['company__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_client['id']); ?>" class="tags email_short_tags" data-value="{{company_email}}">{{<?php echo filter_var($label_language_values['company__email']);	?>}}</a><br />
																</div>
															</div>
															<?php  /*
															<a id="save_email_template" name="" data-id="<?php echo filter_var($readall_client['id']); ?>" class="btn btn-success ld-btn-width pull-left cb ml-15 mt-20" type="submit"><?php echo filter_var($label_language_values['save_template']);	?></a>
															*/
															?>
															<?php $ti++;	?>
														</form>
													</div>
												</div>
											</div>
										</li>
									<?php
									}
									?>
								</ul>
							</div>
						</div>
						<div id="admin-email-template" class="tab-pane fade">
							<h3><?php echo filter_var($label_language_values['admin_email_template']);	?></h3>
							<div id="accordion" class="panel-group">
								<ul class="nav nav-tab nav-stacked">
									<?php
									$readall_admin_email_template = $email_template->readall_admin_email_template();
									while ($readall_admin = mysqli_fetch_array($readall_admin_email_template)) {
									?>
										<li class="panel panel-default ld-admin-email-temp-panel">
											<div class="panel-heading br-2">
												<h4 class="panel-title">
													<div class="lda-col11">
														<div class="pull-left">
															<div class="ld-yes-no-email-right pull-left">
																<label class="ld-toggle" for="email-admin<?php echo filter_var($readall_admin['id']); ?>">

																	<input class='lda-toggle-checkbox save_admin_email_template_status' <?php if ($readall_admin['email_template_status'] == 'E') { ?> checked <?php  } ?> data-toggle="toggle" data-size="small" type='checkbox' data-id="<?php echo filter_var($readall_admin['id']); ?>" id="email-admin<?php echo filter_var($readall_admin['id']); ?>" data-on="<?php echo filter_var($label_language_values['o_n']);	?>" data-off="<?php echo filter_var($label_language_values['off']);	?>" data-onstyle='primary' data-offstyle='default' />

																</label>
															</div>
														</div>
														<span class="ld-template-name"><?php echo filter_var($label_language_values[strtolower(str_replace(" ", "_", $readall_admin['email_subject']))]); ?></span>
													</div>
													<div class="pull-right lda-col1">
														<div class="pull-right">
															<div class="ld-show-hide pull-right">
																<input type="checkbox" name="ld-show-hide" class="ld-show-hide-checkbox ld_open_close_email_template" id="ae<?php echo filter_var($readall_admin['id']); ?>" data-id="<?php echo filter_var($readall_admin['id']); ?>">
																<label class="ld-show-hide-label" for="ae<?php echo filter_var($readall_admin['id']); ?>"></label>
															</div>
														</div>
													</div>

												</h4>
											</div>
											<div id="detail_email_templates_<?php echo filter_var($readall_admin['id']); ?>" class="panel-collapse collapse email_content detail_ae<?php echo filter_var($readall_admin['id']); ?>">
												<div class="panel-body p-10">
													<div class="ld-email-temp-collapse-div col-md-12 col-lg-12 col-xs-12 np">
														<form id="" method="post" type="" class="slide-toggle email_template_form">
															<div class="col-md-8 col-sm-8 col-xs-12">
																<textarea class="form-control" name="email_message<?php echo filter_var($ti);	?>" id="email_message_<?php echo filter_var($readall_admin['id']); ?>" cols="50" rows="20" placeholder="Add here your message"><?php if ($readall_admin['email_message'] != '') {
																																																																						echo base64_decode($readall_admin['email_message']);
																																																																					} else {
																																																																						echo base64_decode($readall_admin['default_message']);
																																																																					} ?></textarea>

																<input type="submit" class="btn btn-success ld-btn-width pull-left cb ml-15 mt-20" name="template<?php echo filter_var($ti);	?>" value="Save Template">

																<input type="hidden" name="hdntemplate<?php echo filter_var($ti);	?>" value="<?php echo filter_var($readall_admin['id']); ?>">

																<a id="default_email_contents" name="" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="btn btn-primary ld-btn-width cb ml-15 mt-20" type="submit"><?php echo filter_var($label_language_values['default_template']);	?></a>
																<a name="" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="btn btn-warning ld-btn-width cb ml-15 mt-20 preview_email_contents" data-title="<?php echo filter_var($label_language_values[strtolower(str_replace(" ", "_", $readall_admin['email_subject']))]); ?>" type="submit"><?php echo filter_var($label_language_values['preview_template']);	?></a>
															</div>
															<div class="col-md-4 col-sm-4 col-xs-12">
																<div class="ld-email-content-tags">
																	<b><?php echo filter_var($label_language_values['tags']);	?></b><br>
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{booking_date}}">{{<?php echo filter_var($label_language_values['booking_date']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{booking_time}}">{{<?php echo filter_var($label_language_values['booking_time']);	?>}}</a><br />
																	<?php if ($setting->get_option('ld_show_delivery_date') == 'E') { ?>
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{booking_delivery_date}}">{{<?php echo filter_var('delivery_date');	?>}}</a><br />
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{booking_delivery_time}}">{{<?php echo filter_var('delivery_time');	?>}}</a><br />
																	<?php } ?>
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{service_name}}">{{<?php echo filter_var($label_language_values['service_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{client_name}}">{{<?php echo filter_var($label_language_values['client_name']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{units}}">{{<?php echo filter_var($label_language_values['units']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{firstname}}">{{<?php echo filter_var($label_language_values['firstname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{lastname}}">{{<?php echo filter_var($label_language_values['lastname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{client_email}}">{{<?php echo filter_var($label_language_values['client_email']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{phone}}">{{<?php echo filter_var($label_language_values['client__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{payment_method}}">{{<?php echo filter_var($label_language_values['payment_method']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{notes}}">{{<?php echo filter_var($label_language_values['notes']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{contact_status}}">{{<?php echo filter_var($label_language_values['contact_status']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{price}}">{{<?php echo filter_var($label_language_values['price']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{address}}">{{<?php echo filter_var($label_language_values['client__address']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{client_city}}">{{<?php echo filter_var($label_language_values['client__city']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{client_state}}">{{<?php echo filter_var($label_language_values['client__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{client_zip}}">{{<?php echo filter_var($label_language_values['client__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{client_promocode}}">{{<?php echo filter_var($label_language_values['client__promocode']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{app_remain_time}}">{{<?php echo filter_var($label_language_values['app_remain_time']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{reject_status}}">{{<?php echo filter_var($label_language_values['reject_status']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{business_logo}}">{{<?php echo filter_var($label_language_values['business_logo']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{admin_name}}">{{<?php echo filter_var($label_language_values['admin_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{company_name}}">{{<?php echo filter_var($label_language_values['company__name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{company_address}}">{{<?php echo filter_var($label_language_values['company__address']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{company_city}}">{{<?php echo filter_var($label_language_values['company__city']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{company_state}}">{{<?php echo filter_var($label_language_values['company__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{company_zip}}">{{<?php echo filter_var($label_language_values['company__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{company_country}}">{{<?php echo filter_var($label_language_values['company__country']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{company_phone}}">{{<?php echo filter_var($label_language_values['company__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_admin['id']); ?>" class="tags email_short_tags" data-value="{{company_email}}">{{<?php echo filter_var($label_language_values['company__email']);	?>}}</a><br />
																</div>
															</div>
															<?php $ti++;	?>
														</form>
													</div>
												</div>
											</div>
										</li>
									<?php
									}
									?>
								</ul>
							</div>
						</div>
						<div id="staff-email-template" class="tab-pane fade">
							<h3><?php echo filter_var($label_language_values['staff_email_template']);	?></h3>
							<div id="accordion" class="panel-group">
								<ul class="nav nav-tab nav-stacked">
									<?php
									$readall_staff_email_template = $email_template->readall_staff_email_template();

									while ($readall_staff = mysqli_fetch_array($readall_staff_email_template)) {
									?>
										<li class="panel panel-default ld-staff-email-temp-panel">
											<div class="panel-heading br-2">
												<h4 class="panel-title">
													<div class="lda-col11">
														<div class="pull-left">
															<div class="ld-yes-no-email-right pull-left">
																<label class="ld-toggle" for="email-staff<?php echo filter_var($readall_staff['id']); ?>">

																	<input class='lda-toggle-checkbox save_staff_email_template_status' <?php if ($readall_staff['email_template_status'] == 'E') { ?> checked <?php  } ?> data-toggle="toggle" data-size="small" type='checkbox' data-id="<?php echo filter_var($readall_staff['id']); ?>" id="email-staff<?php echo filter_var($readall_staff['id']); ?>" data-on="<?php echo filter_var($label_language_values['o_n']);	?>" data-off="<?php echo filter_var($label_language_values['off']);	?>" data-onstyle='primary' data-offstyle='default' />

																</label>
															</div>
														</div>
														<span class="ld-template-name"><?php echo filter_var($label_language_values[strtolower(str_replace(" ", "_", $readall_staff['email_subject']))]); ?></span>
													</div>
													<div class="pull-right lda-col1">
														<div class="pull-right">
															<div class="ld-show-hide pull-right">
																<input type="checkbox" name="ld-show-hide" class="ld-show-hide-checkbox ld_open_close_email_template" id="ae<?php echo filter_var($readall_staff['id']); ?>" data-id="<?php echo filter_var($readall_staff['id']); ?>">
																<label class="ld-show-hide-label" for="ae<?php echo filter_var($readall_staff['id']); ?>"></label>
															</div>
														</div>
													</div>

												</h4>
											</div>
											<div id="detail_email_templates_<?php echo filter_var($readall_staff['id']); ?>" class="panel-collapse collapse email_content detail_ae<?php echo filter_var($readall_staff['id']); ?>">
												<div class="panel-body p-10">
													<div class="ld-email-temp-collapse-div col-md-12 col-lg-12 col-xs-12 np">
														<form id="" method="post" type="" class="slide-toggle email_template_form">
															<div class="col-md-8 col-sm-8 col-xs-12">
																<textarea class="form-control" name="email_message<?php echo filter_var($ti);	?>" id="email_message_<?php echo filter_var($readall_staff['id']); ?>" cols="50" rows="20" placeholder="Add here your message"><?php if ($readall_staff['email_message'] != '') {
																																																																						echo base64_decode($readall_staff['email_message']);
																																																																					} else {
																																																																						echo base64_decode($readall_staff['default_message']);
																																																																					} ?></textarea>

																<input type="submit" class="btn btn-success ld-btn-width pull-left cb ml-15 mt-20" name="template<?php echo filter_var($ti);	?>" value="Save Template">

																<input type="hidden" name="hdntemplate<?php echo filter_var($ti);	?>" value="<?php echo filter_var($readall_staff['id']); ?>">
																<a id="default_email_contents" name="" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="btn btn-primary ld-btn-width cb ml-15 mt-20" type="submit"><?php echo filter_var($label_language_values['default_template']);	?></a>

																<a name="" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="btn btn-warning ld-btn-width cb ml-15 mt-20 preview_email_contents" data-title="<?php echo filter_var($label_language_values[strtolower(str_replace(" ", "_", $readall_staff['email_subject']))]); ?>" type="submit"><?php echo filter_var($label_language_values['preview_template']);	?></a>
															</div>
															<div class="col-md-4 col-sm-4 col-xs-12">
																<div class="ld-email-content-tags">
																	<b><?php echo filter_var($label_language_values['tags']);	?></b><br>
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{booking_date}}">{{<?php echo filter_var($label_language_values['booking_date']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{booking_time}}">{{<?php echo filter_var($label_language_values['booking_time']);	?>}}</a><br />
																	<?php if ($setting->get_option('ld_show_delivery_date') == 'E') { ?>
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{booking_delivery_date}}">{{<?php echo filter_var('delivery_date');	?>}}</a><br />
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{booking_delivery_time}}">{{<?php echo filter_var('delivery_time');	?>}}</a><br />
																	<?php } ?>
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{service_name}}">{{<?php echo filter_var($label_language_values['service_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{client_name}}">{{<?php echo filter_var($label_language_values['client_name']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{units}}">{{<?php echo filter_var($label_language_values['units']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{firstname}}">{{<?php echo filter_var($label_language_values['firstname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{lastname}}">{{<?php echo filter_var($label_language_values['lastname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{client_email}}">{{<?php echo filter_var($label_language_values['client_email']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{phone}}">{{<?php echo filter_var($label_language_values['client__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{payment_method}}">{{<?php echo filter_var($label_language_values['payment_method']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{notes}}">{{<?php echo filter_var($label_language_values['notes']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{contact_status}}">{{<?php echo filter_var($label_language_values['contact_status']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{price}}">{{<?php echo filter_var($label_language_values['price']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{address}}">{{<?php echo filter_var($label_language_values['client__address']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{client_city}}">{{<?php echo filter_var($label_language_values['client__city']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{client_state}}">{{<?php echo filter_var($label_language_values['client__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{client_zip}}">{{<?php echo filter_var($label_language_values['client__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{client_promocode}}">{{<?php echo filter_var($label_language_values['client__promocode']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{app_remain_time}}">{{<?php echo filter_var($label_language_values['app_remain_time']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{reject_status}}">{{<?php echo filter_var($label_language_values['reject_status']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{business_logo}}">{{<?php echo filter_var($label_language_values['business_logo']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{admin_name}}">{{<?php echo filter_var($label_language_values['admin_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{company_name}}">{{<?php echo filter_var($label_language_values['company__name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{company_address}}">{{<?php echo filter_var($label_language_values['company__address']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{company_city}}">{{<?php echo filter_var($label_language_values['company__city']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{company_state}}">{{<?php echo filter_var($label_language_values['company__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{company_zip}}">{{<?php echo filter_var($label_language_values['company__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{company_country}}">{{<?php echo filter_var($label_language_values['company__country']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{company_phone}}">{{<?php echo filter_var($label_language_values['company__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{company_email}}">{{<?php echo filter_var($label_language_values['company__email']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{staff_name}}">{{<?php echo filter_var($label_language_values['staff__name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="tags email_short_tags" data-value="{{staff_email}}">{{<?php echo filter_var($label_language_values['staff__email']);	?>}}</a><br />
																</div>
															</div>
															<?php  /*
														<a id="save_email_template" name="" data-id="<?php echo filter_var($readall_staff['id']); ?>" class="btn btn-success ld-btn-width pull-left cb ml-15 mt-20" type="submit"><?php echo filter_var($label_language_values['save_template']);	?></a>
															*/
															?>
															<?php $ti++;	?>
														</form>
													</div>
												</div>
											</div>
										</li>
									<?php
									}
									?>
								</ul>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="tab-pane fade in" id="sms-reminder">
				<form id="sms_setting_form" method="post" type="" class="ld-sms-reminder">
					<div class="panel panel-default ">
						<div class="panel-heading lda-top-right">
							<h1 class="panel-title"><?php echo filter_var($label_language_values['sms_reminder']);	?></h1>
							<span class="pull-right lda-setting-fix-btn"> <a class="btn btn-success" id="btnsave_sms_service"><?php echo filter_var($label_language_values['save_sms_settings']);	?></a></span>
						</div>
						<div class="panel-body plr-10 pt-50">
							<div id="accordion" class="panel-group">
								<div class="panel panel-default ld-all-sms-gateway-main">

									<div id="collapseOne" style="display: block;" class="panel-collapse collapse mycollapse_sms-service-ena-dis ld-sms-reminder-input pb-p">
										<div class="panel-body p-10">
											<div id="accordion" class="panel-group">
												<div class="panel panel-default ld-sms-gateway">
													<div class="panel-heading">
														<h4 class="panel-title">
															<span><?php echo filter_var($label_language_values['twilio_sms_gateway']);	?></span><img class="lda-sms-gateway-img" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/twilio-logo.png" />
															<div class="ld-enable-disable-right pull-right">
																<label class="ctoggle-sms-noti-twilio" for="sms-noti-twilio">
																	<input class='lda-toggle-checkbox' data-toggle="toggle" <?php if ($setting->ld_sms_twilio_status == "Y") {
																																echo filter_var("checked");
																															} else {
																																echo filter_var("");
																															} ?> data-size="small" type='checkbox' name="" id="sms-noti-twilio" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																</label>
															</div>
														</h4>
													</div>
													<div <?php if ($setting->ld_sms_twilio_status == "Y") { ?> style="display:block;" <?php  } ?> id="collapseOne" class="panel-collapse collapse mycollapse_sms-noti-twilio">
														<div class="panel-body p-10">
															<table class="form-inline table ld-common-table table-hover table-bordered table-striped">
																<tr>
																	<th colspan="3"><?php echo filter_var($label_language_values['twilio_account_settings']);	?></th>
																</tr>
																<tbody>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['account_sid']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group ld-lgf">
																				<input type="text" id="mytwilio_account_sid" class="form-control" value="<?php echo filter_var($setting->ld_sms_twilio_account_SID);	?>" name="mytwilio_account_sid" size="70" />
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['available_from_within_your_twilio_account']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																			<label for="mytwilio_account_sid" generated="true" class="error" style="display: none;"></label>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['auth_token']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group ld-lgf">
																				<input type="password" id="mytwilio_auth_token" class="form-control" value="<?php echo filter_var($setting->ld_sms_twilio_auth_token);	?>" name="mytwilio_auth_token" size="70" />
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['available_from_within_your_twilio_account']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																			<label for="mytwilio_auth_token" generated="true" class="error"></label>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['twilio_sender_number']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group ld-lgf">
																				<input type="text" id="mytwilio_sender_number" class="form-control" value="<?php echo filter_var($setting->ld_sms_twilio_sender_number);	?>" name="mytwilio_sender_number" size="70" />
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['must_be_a_valid_number_associated_with_your_twilio_account']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																			<label for="mytwilio_sender_number" generated="true" class="error"></label>
																		</td>
																	</tr>
																	<tr>
																		<td id="hr"></td>
																		<td id="hr"></td>
																		<td id="hr"></td>
																	</tr>
																</tbody>
																<tbody>
																	<th colspan="3"><?php echo filter_var($label_language_values['twilio_sms_settings']);	?></th>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['send_sms_to_client']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group">
																				<label class="ctoggle-ld-sms-reminder-client-status" for="ld-sms-reminder-client-status">
																					<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_sms_twilio_send_sms_to_client_status == "Y") {
																																								echo filter_var("checked");
																																							} else {
																																								echo filter_var("");
																																							} ?> id="ld-sms-reminder-client-status" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																				</label>
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['enable_or_disable_send_sms_to_client_for_appointment_booking_info']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['send_sms_to_admin']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group">
																				<label class="ctoggle-ld-sms-reminder-admin-status" for="ld-sms-reminder-admin-status">
																					<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_sms_twilio_send_sms_to_admin_status == "Y") {
																																								echo filter_var("checked");
																																							} else {
																																								echo filter_var("");
																																							} ?> id="ld-sms-reminder-admin-status" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																				</label>
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['enable_or_disable_send_sms_to_client_for_appointment_booking_info']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['send_sms_to_staff']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group">
																				<label class="ctoggle-ld-sms-reminder-staff-status" for="ld-sms-reminder-staff-status">
																					<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_sms_twilio_send_sms_to_staff_status == "Y") {
																																								echo filter_var("checked");
																																							} else {
																																								echo filter_var("");
																																							} ?> id="ld-sms-reminder-staff-status" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																				</label>
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['enable_or_disable_send_sms_to_staff_for_appointment_booking_info']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['admin_phone_number']); ?></label></td>
																		<td colspan="2">
																			<div class="input-group">
																				<span class="input-group-addon"><span class="company_country_code_value_twilio"><?php echo filter_var($country_codes[0]);	?></span></span>
																				<input type="text" class="form-control" value="<?php echo str_replace($country_codes[0], '', $setting->get_option('ld_sms_twilio_admin_phone_number'));	?>" name="myadmin_phone_number" id="myadmin_phone_number" />
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td id="hr"></td>
																		<td id="hr"></td>
																		<td id="hr"></td>
																	</tr>
																</tbody>

															</table>
														</div>
													</div>
												</div>
												<div class="panel panel-default ld-sms-gateway">
													<div class="panel-heading">
														<h4 class="panel-title">
															<span><?php echo filter_var($label_language_values['plivo_sms_gateway']);	?></span><img class="lda-sms-gateway-img" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/plivo-logo.png" />
															<div class="ld-enable-disable-right pull-right">
																<label class="ctoggle-sms-noti-plivo" for="sms-noti-plivo">
																	<input class='lda-toggle-checkbox' data-toggle="toggle" <?php if ($setting->ld_sms_plivo_status == "Y") {
																																echo filter_var("checked");
																															} else {
																																echo filter_var("");
																															} ?> data-size="small" type='checkbox' name="" id="sms-noti-plivo" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																</label>
															</div>

														</h4>
													</div>
													<div id="collapseOne" <?php if ($setting->ld_sms_plivo_status == "Y") { ?> style="display:block;" <?php  } ?> class="panel-collapse collapse mycollapse_sms-noti-plivo">
														<div class="panel-body p-10">
															<div class="table-responsive">
																<table class="form-inline table ld-common-table table-hover table-bordered table-striped">
																	<tr>
																		<th colspan="3"><?php echo filter_var($label_language_values['plivo_account_settings']);	?></th>
																	</tr>
																	<tbody>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['account_sid']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group ld-lgf">
																					<input type="text" id="myplivo_account_sid" class="form-control" value="<?php echo filter_var($setting->ld_sms_plivo_account_SID);	?>" name="myplivo_account_sid" size="70" />
																				</div>
																				<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['available_from_within_your_plivo_account']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																				<label for="myplivo_account_sid" generated="true" class="error" style="display: none;"></label>
																			</td>
																		</tr>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['auth_token']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group ld-lgf">
																					<input type="password" id="myplivo_auth_token" class="form-control" value="<?php echo filter_var($setting->ld_sms_plivo_auth_token);	?>" name="myplivo_auth_token" size="70" />
																				</div>
																				<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['available_from_within_your_plivo_account']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																				<label for="myplivo_auth_token" generated="true" class="error"></label>
																			</td>
																		</tr>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['plivo_sender_number']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group ld-lgf">
																					<input type="text" id="myplivo_sender_number" class="form-control" value="<?php echo filter_var($setting->ld_sms_plivo_sender_number);	?>" name="myplivo_sender_number" size="70" />
																				</div>
																				<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['must_be_a_valid_number_associated_with_your_plivo_account']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																				<label for="myplivo_sender_number" generated="true" class="error"></label>
																			</td>
																		</tr>
																		<tr>
																			<td id="hr"></td>
																			<td id="hr"></td>
																			<td id="hr"></td>
																		</tr>
																	</tbody>

																	<tbody>

																		<th colspan="3"><?php echo filter_var($label_language_values['plivo_sms_settings']);	?></th>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['send_sms_to_client']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group">
																					<label class="ctoggle-ld-sms-reminder-client-status-plivo" for="ld-sms-reminder-client-status-plivo">
																						<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_sms_plivo_send_sms_to_client_status == "Y") {
																																									echo filter_var("checked");
																																								} else {
																																									echo filter_var("");
																																								} ?> id="ld-sms-reminder-client-status-plivo" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																					</label>
																				</div>
																				<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['enable_or_disable_send_sms_to_client_for_appointment_booking_info']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																			</td>
																		</tr>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['send_sms_to_admin']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group">
																					<label class="ctoggle-ld-sms-reminder-admin-status-plivo" for="ld-sms-reminder-admin-status-plivo">
																						<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_sms_plivo_send_sms_to_admin_status == "Y") {
																																									echo filter_var("checked");
																																								} else {
																																									echo filter_var("");
																																								} ?> id="ld-sms-reminder-admin-status-plivo" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																					</label>
																				</div>
																				<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['enable_or_disable_send_sms_to_admin_for_appointment_booking_info']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																			</td>
																		</tr>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['send_sms_to_staff']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group">
																					<label class="ctoggle-ld-sms-reminder-staff-status-plivo" for="ld-sms-reminder-staff-status-plivo">
																						<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_sms_plivo_send_sms_to_staff_status == "Y") {
																																									echo filter_var("checked");
																																								} else {
																																									echo filter_var("");
																																								} ?> id="ld-sms-reminder-staff-status-plivo" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																					</label>
																				</div>
																				<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['enable_or_disable_send_sms_to_staff_for_appointment_booking_info']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																			</td>
																		</tr>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['admin_phone_number']); ?></label></td>
																			<td colspan="2">
																				<div class="input-group">
																					<span class="input-group-addon"><span class="company_country_code_value_plivo"><?php echo filter_var($country_codes[0]);	?></span></span>
																					<input type="text" class="form-control" value="<?php echo str_replace($country_codes[0], '', $setting->get_option('ld_sms_plivo_admin_phone_number'));	?>" name="myadmin_phone_number_plivo" id="myadmin_phone_number_plivo" />
																				</div>
																			</td>

																		</tr>
																		<tr>
																			<td id="hr"></td>
																			<td id="hr"></td>
																			<td id="hr"></td>
																		</tr>
																	</tbody>
																</table>
															</div>

														</div>
													</div>
												</div>


												<div class="panel panel-default ld-sms-gateway">
													<div class="panel-heading">
														<h4 class="panel-title">
															<span><?php echo filter_var($label_language_values['nexmo_sms_gateway']);	?></span><img class="lda-sms-gateway-img" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/nexmo_logo.png" />
															<div class="ld-enable-disable-right pull-right">
																<label class="ctoggle-sms-noti-plivo" for="sms-noti-nexmo">
																	<input class='lda-toggle-checkbox' data-toggle="toggle" <?php if ($setting->ld_sms_nexmo_status == "Y") {
																																echo filter_var("checked");
																															} else {
																																echo filter_var("");
																															} ?> data-size="small" type='checkbox' name="" id="sms-noti-nexmo" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																</label>
															</div>

														</h4>
													</div>
													<div id="collapseOne" <?php if ($setting->ld_sms_nexmo_status == "Y") { ?> style="display:block;" <?php  } ?> class="panel-collapse collapse mycollapse_sms-noti-nexmo">
														<div class="panel-body p-10">
															<div class="table-responsive">
																<table class="form-inline table ld-common-table table-hover table-bordered table-striped">
																	<tr>
																		<th colspan="3"><?php echo filter_var($label_language_values['nexmo_sms_setting']);	?></th>
																	</tr>
																	<tbody>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['nexmo_api_key']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group ld-lgf">
																					<input type="text" id="ld_nexmo_api_key" class="form-control" value="<?php echo filter_var($setting->ld_nexmo_api_key);	?>" name="ld_nexmo_api_key" size="70" />
																				</div>
																				<label for="myplivo_account_sid" generated="true" class="error" style="display: none;"></label>
																			</td>
																		</tr>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['nexmo_api_secret']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group ld-lgf">
																					<input type="password" id="ld_nexmo_api_secret" class="form-control" value="<?php echo filter_var($setting->ld_nexmo_api_secret);	?>" name="ld_nexmo_api_secret" size="70" />
																				</div>
																				<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['available_from_within_your_plivo_account']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																				<label for="myplivo_auth_token" generated="true" class="error"></label>
																			</td>
																		</tr>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['nexmo_from']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group ld-lgf">
																					<input type="text" id="ld_nexmo_from" class="form-control" value="<?php echo filter_var($setting->ld_nexmo_from);	?>" name="ld_nexmo_from" size="70" />
																				</div>
																				<label for="myplivo_sender_number" generated="true" class="error"></label>
																			</td>
																		</tr>
																		<tr>
																			<td id="hr"></td>
																			<td id="hr"></td>
																			<td id="hr"></td>
																		</tr>
																	</tbody>

																	<tbody>


																		<tr>
																			<td><label><?php echo filter_var($label_language_values['nexmo_status']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group">
																					<label class="ctoggle-ld-sms-reminder-client-status-plivo" for="ld_nexmo_status">
																						<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_nexmo_status == "Y") {
																																									echo filter_var("checked");
																																								} else {
																																									echo filter_var("");
																																								} ?> id="ld_nexmo_status" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																					</label>
																				</div>
																				<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['enable_or_disable_send_sms_to_client_for_appointment_booking_info']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																			</td>
																		</tr>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['nexmo_send_sms_to_client_status']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group">
																					<label class="ctoggle-ld-sms-reminder-admin-status-plivo" for="ld_sms_nexmo_send_sms_to_client_status">
																						<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_sms_nexmo_send_sms_to_client_status == "Y") {
																																									echo filter_var("checked");
																																								} else {
																																									echo filter_var("");
																																								} ?> id="ld_sms_nexmo_send_sms_to_client_status" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																					</label>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['nexmo_send_sms_to_admin_status']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group">
																					<label class="ctoggle-ld-sms-reminder-admin-status-plivo" for="ld_sms_nexmo_send_sms_to_admin_status">
																						<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_sms_nexmo_send_sms_to_admin_status == "Y") {
																																									echo filter_var("checked");
																																								} else {
																																									echo filter_var("");
																																								} ?> id="ld_sms_nexmo_send_sms_to_admin_status" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																					</label>
																				</div>
																			</td>

																		</tr>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['send_sms_to_staff']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group">
																					<label class="ctoggle-ld-sms-reminder-staff-status-plivo" for="ld_sms_nexmo_send_sms_to_staff_status">
																						<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->ld_sms_nexmo_send_sms_to_staff_status == "Y") {
																																									echo filter_var("checked");
																																								} else {
																																									echo filter_var("");
																																								} ?> id="ld_sms_nexmo_send_sms_to_staff_status" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																					</label>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td><label><?php echo filter_var($label_language_values['nexmo_admin_phone_number']);	?></label></td>
																			<td colspan="2">
																				<div class="form-group ld-lgf">
																					<div class="input-group">
																						<span class="input-group-addon"><span class="company_country_code_value_plivo"><?php echo filter_var($country_codes[0]);	?></span></span>
																						<input type="text" id="ld_sms_nexmo_admin_phone_number" class="form-control" value="<?php echo filter_var($setting->ld_sms_nexmo_admin_phone_number);	?>" name="ld_sms_nexmo_admin_phone_number" size="70" />
																					</div>
																				</div>
																			</td>

																			<label for="ld_sms_nexmo_admin_phone_number" generated="true" class="error"></label>
																			</td>
																		</tr>
																		<tr>
																			<td id="hr"></td>
																			<td id="hr"></td>
																			<td id="hr"></td>
																		</tr>
																	</tbody>
																</table>
															</div>

														</div>
													</div>
												</div>
												<div class="panel panel-default ld-sms-gateway">
													<div class="panel-heading">
														<h4 class="panel-title"><span><?php echo filter_var($label_language_values['textlocal_sms_gateway']);	?></span><img class="lda-sms-gateway-img" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/textlocal-logo.png" />
															<div class="ld-enable-disable-right pull-right">
																<label class="ctoggle-sms-noti-plivo" for="sms-noti-textlocal">
																	<input class='lda-toggle-checkbox' data-toggle="toggle" <?php if ($setting->ld_sms_textlocal_status == "Y") {
																																echo filter_var("checked");
																															} else {
																																echo filter_var("");
																															} ?> data-size="small" type='checkbox' name="" id="sms-noti-textlocal" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																</label>
															</div>
														</h4>
													</div>
													<div <?php if ($setting->ld_sms_textlocal_status == "Y") { ?> style="display:block;" <?php  } ?> id="collapseOne" class="panel-collapse collapse mycollapse_sms-noti-textlocal">
														<div class="panel-body p-10">
															<table class="form-inline table ld-common-table table-hover table-bordered table-striped">
																<tr>
																	<th colspan="3"><?php echo filter_var($label_language_values['textlocal_account_settings']);	?></th>
																</tr>
																<tbody>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['account_username']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group ld-lgf">
																				<input type="text" id="mytextlocal_username" class="form-control" value="<?php echo filter_var($setting->ld_sms_textlocal_account_username);	?>" name="mytextlocal_username" size="70" />
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['email_id_registered_with_you_textlocal']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																			<label for="mytextlocal_username" generated="true" class="error" style="display: none;"></label>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['account_hash_id']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group ld-lgf">
																				<input type="password" id="mytextlocal_account_hash_id" class="form-control" value="<?php echo filter_var($setting->ld_sms_textlocal_account_hash_id);	?>" name="mytextlocal_account_hash_id" size="70" />
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['hash_id_provided_by_textlocal']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																			<label for="mytextlocal_account_hash_id" generated="true" class="error"></label>
																		</td>
																	</tr>
																	<tr>
																		<td id="hr" />
																		<td id="hr" />
																		<td id="hr" />
																	</tr>
																</tbody>
																<tbody>
																	<th colspan="3"><?php echo filter_var($label_language_values['textlocal_sms_settings']);	?></th>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['send_sms_to_client']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group">
																				<label class="ctoggle-ld-sms-reminder-client-status" for="ld-sms-reminder-client-status">
																					<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->get_option('ld_sms_textlocal_send_sms_to_client_status') == "Y") {
																																								echo filter_var("checked");
																																							} else {
																																								echo filter_var("");
																																							} ?> id="ld-textlocal-sms-reminder-client-status" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																				</label>
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['enable_or_disable_send_sms_to_client_for_appointment_booking_info']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['send_sms_to_admin']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group">
																				<label class="ctoggle-ld-sms-reminder-admin-status" for="ld-sms-reminder-admin-status">
																					<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->get_option('ld_sms_textlocal_send_sms_to_admin_status') == "Y") {
																																								echo filter_var("checked");
																																							} else {
																																								echo filter_var("");
																																							} ?> id="ld-textlocal-sms-reminder-admin-status" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																				</label>
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['enable_or_disable_send_sms_to_admin_for_appointment_booking_info']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																		</td>
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['send_sms_to_staff']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group">
																				<label class="ctoggle-ld-sms-reminder-staff-status" for="ld-sms-reminder-staff-status">
																					<input data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->get_option('ld_sms_textlocal_send_sms_to_staff_status') == "Y") {
																																								echo filter_var("checked");
																																							} else {
																																								echo filter_var("");
																																							} ?> id="ld-textlocal-sms-reminder-staff-status" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
																				</label>
																			</div>
																			<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['enable_or_disable_send_sms_to_staff_for_appointment_booking_info']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
																		</td>
																	</tr>
																	<tr>
																		<td id="hr" />
																		<td id="hr" />
																		<td id="hr" />
																	</tr>
																	<tr>
																		<td><label><?php echo filter_var($label_language_values['admin_phone_number']);	?></label></td>
																		<td colspan="2">
																			<div class="form-group ld-lgf">
																				<div class="input-group">
																					<span class="input-group-addon"><span class="company_country_code_value_plivo"><?php echo filter_var($country_codes[0]);	?></span></span>
																					<input type="text" id="ld_sms_textlocal_admin_phone" class="form-control" value="<?php echo filter_var($setting->ld_sms_textlocal_admin_phone);	?>" name="ld_sms_textlocal_admin_phone" size="70" />
																				</div>
																			</div>
																			<label for="ld_sms_textlocal_admin_phone" generated="true" class="error"></label>
																		</td>
																	</tr>
																	<tr>
																		<td id="hr" />
																		<td id="hr" />
																		<td id="hr" />
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
											<a id="btnsave_sms_service" name="" class="btn btn-success mt-20 ml-10"><?php echo filter_var($label_language_values['save_sms_settings']);	?></a>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="tab-pane fade in" id="sms-template">
				<div class="ld-sms-template-panel panel panel-default wf-100">
					<div class="panel-heading">
						<h1 class="panel-title"><?php echo filter_var($label_language_values['sms_template_settings']);	?></h1>
					</div>

					<ul class="nav nav-tabs nav-justified">
						<li class="active"><a data-toggle="tab" href="#client-sms-template"><?php echo filter_var($label_language_values['client_sms_templates']);	?></a></li>
						<li><a data-toggle="tab" href="#admin-sms-template"><?php echo filter_var($label_language_values['admin_sms_template']);	?></a></li>
						<li><a data-toggle="tab" href="#staff-sms-template">Staff SMS Template</a></li>

					</ul>
					<div class="tab-content">
						<div id="client-sms-template" class="tab-pane fade in active">
							<h3><?php echo filter_var($label_language_values['client_sms_templates']);	?></h3>
							<div id="accordion" class="panel-group">
								<ul class="nav nav-tab nav-stacked">
									<?php
									$readall_client_sms_template = $sms_template->readall_client_sms_template();
									while ($client_template = @mysqli_fetch_array($readall_client_sms_template)) {
									?>
										<li class="panel panel-default ld-client-sms-panel">
											<div class="panel-heading br-2">
												<h4 class="panel-title">
													<div class="lda-col11">
														<div class="pull-left">
															<div class="ld-yes-no-sms-right pull-left">
																<label for="sms-client<?php echo filter_var($client_template['id']);	?>">
																	<input class="save_client_sms_template_status" data-toggle="toggle" data-size="small" type='checkbox' <?php if ($client_template['sms_template_status'] == 'E') {
																																												echo filter_var("checked");
																																											} else {
																																												echo filter_var("");
																																											} ?> data-id="<?php echo filter_var($client_template['id']);	?>" id="sms-client<?php echo filter_var($client_template['id']);	?>" data-on="<?php echo filter_var($label_language_values['o_n']);	?>" data-off="<?php echo filter_var($label_language_values['off']);	?>" data-onstyle='primary' data-offstyle='default' />

																</label>
															</div>
														</div>
														<span class="ld-template-name"><?php echo filter_var($label_language_values[strtolower(str_replace(" ", "_", $client_template['sms_subject']))]); ?></span>
													</div>
													<div class="pull-right lda-col1">
														<div class="pull-right">
															<div class="ld-show-hide pull-right">
																<input type="checkbox" name="ld-show-hide" class="ld-show-hide-checkbox ld_show_hide_checkbox" id="cm<?php echo filter_var($client_template['id']);	?>" data-id="<?php echo filter_var($client_template['id']); ?>">
																<label class="ld-show-hide-label" for="cm<?php echo filter_var($client_template['id']);	?>"></label>
															</div>
														</div>
													</div>
												</h4>
											</div>
											<div id="detail_sms_template_<?php echo filter_var($client_template['id']);	?>" class="panel-collapse collapse sms_content detail_cm<?php echo filter_var($client_template['id']);	?> sms_template_detail">
												<div class="panel-body p-10">
													<div class="ld-sms-temp-collapse-div col-md-12 col-lg-12 col-xs-12 np">
														<form id="sms_template_form_<?php echo filter_var($client_template['id']);	?>" method="post" type="" class="slide-toggle">
															<div class="col-md-8 col-sm-8 col-xs-12">
																<textarea class="form-control" name="sms_message" id="sms_message_<?php echo filter_var($client_template['id']);	?>" cols="50" rows="20" placeholder="Add here your message for sms"><?php if ($client_template['sms_message'] != '') {
																																																																echo base64_decode($client_template['sms_message']);
																																																															} else {
																																																																echo base64_decode($client_template['default_message']);
																																																															} ?></textarea>

																<a id="save_sms_template" name="" data-id="<?php echo filter_var($client_template['id']);	?>" class="btn btn-success ld-btn-width pull-left cb ml-15 mt-20" type="submit"><?php echo filter_var($label_language_values['save_template']);	?></a>
																<a id="default_sms_contents" name="" data-id="<?php echo filter_var($client_template['id']);	?>" class="btn btn-primary ld-btn-width cb ml-15 mt-20" type="submit"><?php echo filter_var($label_language_values['default_template']);	?></a>
															</div>
															<div class="col-md-4 col-sm-4 col-xs-12">
																<div class="ld-sms-content-tags">
																	<b><?php echo filter_var($label_language_values['tags']);	?></b><br>

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_date}}">{{<?php echo filter_var($label_language_values['booking_date']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_time}}">{{<?php echo filter_var($label_language_values['booking_time']);	?>}}</a><br />
																	<?php if ($setting->get_option('ld_show_delivery_date') == 'E') { ?>
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_delivery_date}}">{{<?php echo filter_var('delivery_date');	?>}}</a><br />
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_delivery_time}}">{{<?php echo filter_var('delivery_time');	?>}}</a><br />
																	<?php } ?>
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{service_name}}">{{<?php echo filter_var($label_language_values['service_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_name}}">{{<?php echo filter_var($label_language_values['client_name']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{units}}">{{<?php echo filter_var($label_language_values['units']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{firstname}}">{{<?php echo filter_var($label_language_values['firstname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{lastname}}">{{<?php echo filter_var($label_language_values['lastname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_email}}">{{<?php echo filter_var($label_language_values['client_email']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{phone}}">{{<?php echo filter_var($label_language_values['client__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{payment_method}}">{{<?php echo filter_var($label_language_values['payment_method']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{notes}}">{{<?php echo filter_var($label_language_values['notes']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{contact_status}}">{{<?php echo filter_var($label_language_values['contact_status']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{price}}">{{<?php echo filter_var($label_language_values['price']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{address}}">{{<?php echo filter_var($label_language_values['client__address']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_city}}">{{<?php echo filter_var($label_language_values['client__city']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_state}}">{{<?php echo filter_var($label_language_values['client__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_zip}}">{{<?php echo filter_var($label_language_values['client__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_promocode}}">{{client_promocode}}</a><br />


																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{app_remain_time}}">{{<?php echo filter_var($label_language_values['app_remain_time']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{reject_status}}">{{<?php echo filter_var($label_language_values['reject_status']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{business_logo}}">{{<?php echo filter_var($label_language_values['business_logo']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{admin_name}}">{{<?php echo filter_var($label_language_values['admin_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_name}}">{{<?php echo filter_var($label_language_values['company__name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_address}}">{{<?php echo filter_var($label_language_values['company__address']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_city}}">{{<?php echo filter_var($label_language_values['company__city']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_state}}">{{<?php echo filter_var($label_language_values['company__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_zip}}">{{<?php echo filter_var($label_language_values['company__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_country}}">{{<?php echo filter_var($label_language_values['company__country']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_phone}}">{{<?php echo filter_var($label_language_values['company__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($client_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_email}}">{{<?php echo filter_var($label_language_values['company__email']);	?>}}</a><br />
																</div>
															</div>

														</form>
													</div>
												</div>
											</div>
										</li>
									<?php
									}
									?>
								</ul>
							</div>
						</div>
						<div id="admin-sms-template" class="tab-pane fade">
							<h3><?php echo filter_var($label_language_values['admin_sms_template']);	?></h3>
							<div id="accordion" class="panel-group">
								<ul class="nav nav-tab nav-stacked">
									<?php
									$readall_admin_sms_template = $sms_template->readall_admin_sms_template();
									while ($admin_template = @mysqli_fetch_array($readall_admin_sms_template)) {
									?>
										<li class="panel panel-default ld-admin-sms-temp-panel">
											<div class="panel-heading br-2">
												<h4 class="panel-title">
													<div class="lda-col11">
														<div class="pull-left">
															<div class="ld-yes-no-sms-right pull-left">
																<label for="sms-admin<?php echo filter_var($admin_template['id']);	?>">
																	<input class='save_admin_sms_template_status' data-toggle="toggle" data-size="small" type='checkbox' data-id="<?php echo filter_var($admin_template['id']);	?>" type="checkbox" name="" <?php if ($admin_template['sms_template_status'] == 'E') {
																																																																	echo filter_var("checked");
																																																																} else {
																																																																	echo filter_var("");
																																																																} ?> id="sms-admin<?php echo filter_var($admin_template['id']);	?>" data-on="<?php echo filter_var($label_language_values['o_n']);	?>" data-off="<?php echo filter_var($label_language_values['off']);	?>" data-onstyle='primary' data-offstyle='default' />

																</label>
															</div>
														</div>
														<span class="ld-template-name"><?php echo filter_var($label_language_values[strtolower(str_replace(" ", "_", $admin_template['sms_subject']))]); ?></span>
													</div>
													<div class="pull-right lda-col1">
														<div class="pull-right">
															<div class="ld-show-hide pull-right">
																<input type="checkbox" name="ld-show-hide" class="ld-show-hide-checkbox ld_show_hide_checkbox" id="as<?php echo filter_var($admin_template['id']);	?>" data-id="<?php echo filter_var($admin_template['id']); ?>">
																<label class="ld-show-hide-label" for="as<?php echo filter_var($admin_template['id']);	?>"></label>
															</div>
														</div>
													</div>
												</h4>
											</div>
											<div id="detail_sms_template_<?php echo filter_var($admin_template['id']);	?>" class="panel-collapse collapse sms_content detail_as<?php echo filter_var($admin_template['id']);	?> sms_template_detail_admin">
												<div class="panel-body p-10">
													<div class="ld-sms-temp-collapse-div col-md-12 col-lg-12 col-xs-12 np">
														<form id="sms_template_form_<?php echo filter_var($admin_template['id']);	?>" method="post" type="" class="slide-toggle">
															<div class="col-md-8 col-sm-8 col-xs-12">
																<textarea class="form-control" name="sms_message" id="sms_message_<?php echo filter_var($admin_template['id']);	?>" cols="50" rows="20" placeholder="Add here your message"><?php if ($admin_template['sms_message'] != '') {
																																																													echo base64_decode($admin_template['sms_message']);
																																																												} else {
																																																													echo base64_decode($admin_template['default_message']);
																																																												} ?></textarea>
																<a id="save_sms_template" name="" data-id="<?php echo filter_var($admin_template['id']);	?>" class="btn btn-success ld-btn-width pull-left cb ml-15 mt-20" type="submit"><?php echo filter_var($label_language_values['save_template']);	?></a>
																<a id="default_sms_contents" name="" data-id="<?php echo filter_var($admin_template['id']);	?>" class="btn btn-primary ld-btn-width pull-left cb ml-15 mt-20" type="submit"><?php echo filter_var($label_language_values['default_template']);	?></a>
															</div>
															<div class="col-md-4 col-sm-4 col-xs-12">
																<div class="ld-sms-content-tags">
																	<b><?php echo filter_var($label_language_values['tags']);	?></b><br>
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_date}}">{{<?php echo filter_var($label_language_values['booking_date']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_time}}">{{<?php echo filter_var($label_language_values['booking_time']);	?>}}</a><br />
																	<?php if ($setting->get_option('ld_show_delivery_date') == 'E') { ?>
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_delivery_date}}">{{<?php echo filter_var('delivery_date');	?>}}</a><br />
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_delivery_time}}">{{<?php echo filter_var('delivery_time');	?>}}</a><br />
																	<?php } ?>
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{service_name}}">{{<?php echo filter_var($label_language_values['service_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_name}}">{{<?php echo filter_var($label_language_values['client_name']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{units}}">{{<?php echo filter_var($label_language_values['units']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{firstname}}">{{<?php echo filter_var($label_language_values['firstname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{lastname}}">{{<?php echo filter_var($label_language_values['lastname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_email}}">{{<?php echo filter_var($label_language_values['client_email']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{phone}}">{{<?php echo filter_var($label_language_values['client__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{payment_method}}">{{<?php echo filter_var($label_language_values['payment_method']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{notes}}">{{<?php echo filter_var($label_language_values['notes']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{contact_status}}">{{<?php echo filter_var($label_language_values['contact_status']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{price}}">{{<?php echo filter_var($label_language_values['price']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{address}}">{{<?php echo filter_var($label_language_values['client__address']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_city}}">{{<?php echo filter_var($label_language_values['client__city']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_state}}">{{<?php echo filter_var($label_language_values['client__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_zip}}">{{<?php echo filter_var($label_language_values['client__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_promocode}}">{{client_promocode}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{app_remain_time}}">{{<?php echo filter_var($label_language_values['app_remain_time']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{reject_status}}">{{<?php echo filter_var($label_language_values['reject_status']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{business_logo}}">{{<?php echo filter_var($label_language_values['business_logo']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{admin_name}}">{{<?php echo filter_var($label_language_values['admin_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_name}}">{{<?php echo filter_var($label_language_values['company__name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_address}}">{{<?php echo filter_var($label_language_values['company__address']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_city}}">{{<?php echo filter_var($label_language_values['company__city']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_state}}">{{<?php echo filter_var($label_language_values['company__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_zip}}">{{<?php echo filter_var($label_language_values['company__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_country}}">{{<?php echo filter_var($label_language_values['company__country']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_phone}}">{{<?php echo filter_var($label_language_values['company__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($admin_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_email}}">{{<?php echo filter_var($label_language_values['company__email']);	?>}}</a><br />
																</div>
															</div>

														</form>
													</div>
												</div>
											</div>
										</li>
									<?php
									}
									?>

								</ul>

							</div>
						</div>

						<div id="staff-sms-template" class="tab-pane fade">
							<h3>Staff SMS Template</h3>
							<div id="accordion" class="panel-group">
								<ul class="nav nav-tab nav-stacked">
									<?php
									$readall_staff_sms_template = $sms_template->readall_staff_sms_template();
									while ($staff_template = @mysqli_fetch_array($readall_staff_sms_template)) {
									?>
										<li class="panel panel-default ld-staff-sms-temp-panel">
											<div class="panel-heading br-2">
												<h4 class="panel-title">
													<div class="lda-col11">
														<div class="pull-left">
															<div class="ld-yes-no-sms-right pull-left">
																<label for="sms-staff<?php echo filter_var($staff_template['id']);	?>">
																	<input class='save_staff_sms_template_status' data-toggle="toggle" data-size="small" type='checkbox' data-id="<?php echo filter_var($staff_template['id']);	?>" type="checkbox" name="" <?php if ($staff_template['sms_template_status'] == 'E') {
																																																																	echo filter_var("checked");
																																																																} else {
																																																																	echo filter_var("");
																																																																} ?> id="sms-staff<?php echo filter_var($staff_template['id']);	?>" data-on="<?php echo filter_var($label_language_values['o_n']);	?>" data-off="<?php echo filter_var($label_language_values['off']);	?>" data-onstyle='primary' data-offstyle='default' />

																</label>
															</div>
														</div>
														<span class="ld-template-name"><?php echo filter_var($staff_template['sms_subject']); ?></span>
													</div>
													<div class="pull-right lda-col1">
														<div class="pull-right">
															<div class="ld-show-hide pull-right">
																<input type="checkbox" name="ld-show-hide" class="ld-show-hide-checkbox ld_show_hide_checkbox" id="as<?php echo filter_var($staff_template['id']);	?>" data-id="<?php echo filter_var($staff_template['id']); ?>">
																<label class="ld-show-hide-label" for="as<?php echo filter_var($staff_template['id']);	?>"></label>
															</div>
														</div>
													</div>
												</h4>
											</div>
											<div id="detail_sms_template_<?php echo filter_var($staff_template['id']);	?>" class="panel-collapse collapse sms_content detail_as<?php echo filter_var($staff_template['id']);	?> sms_template_detail_admin">
												<div class="panel-body p-10">
													<div class="ld-sms-temp-collapse-div col-md-12 col-lg-12 col-xs-12 np">
														<form id="sms_template_form_<?php echo filter_var($staff_template['id']);	?>" method="post" type="" class="slide-toggle">
															<div class="col-md-8 col-sm-8 col-xs-12">
																<textarea class="form-control" name="sms_message" id="sms_message_<?php echo filter_var($staff_template['id']);	?>" cols="50" rows="20" placeholder="Add here your message"><?php if ($staff_template['sms_message'] != '') {
																																																													echo base64_decode($staff_template['sms_message']);
																																																												} else {
																																																													echo base64_decode($staff_template['default_message']);
																																																												} ?></textarea>
																<a id="save_sms_template" name="" data-id="<?php echo filter_var($staff_template['id']);	?>" class="btn btn-success ld-btn-width pull-left cb ml-15 mt-20" type="submit"><?php echo filter_var($label_language_values['save_template']);	?></a>
																<a id="default_sms_contents" name="" data-id="<?php echo filter_var($staff_template['id']);	?>" class="btn btn-primary ld-btn-width pull-left cb ml-15 mt-20" type="submit"><?php echo filter_var($label_language_values['default_template']);	?></a>
															</div>
															<div class="col-md-4 col-sm-4 col-xs-12">
																<div class="ld-sms-content-tags">
																	<b><?php echo filter_var($label_language_values['tags']);	?></b><br>
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_date}}">{{<?php echo filter_var($label_language_values['booking_date']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_time}}">{{<?php echo filter_var($label_language_values['booking_time']);	?>}}</a><br />
																	<?php if ($setting->get_option('ld_show_delivery_date') == 'E') { ?>
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_delivery_date}}">{{<?php echo filter_var('delivery_date');	?>}}</a><br />
																		<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{booking_delivery_time}}">{{<?php echo filter_var('delivery_time');	?>}}</a><br />
																	<?php } ?>
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{service_name}}">{{<?php echo filter_var($label_language_values['service_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_name}}">{{<?php echo filter_var($label_language_values['client_name']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{units}}">{{<?php echo filter_var($label_language_values['units']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{firstname}}">{{<?php echo filter_var($label_language_values['firstname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{lastname}}">{{<?php echo filter_var($label_language_values['lastname']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_email}}">{{<?php echo filter_var($label_language_values['client_email']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{phone}}">{{<?php echo filter_var($label_language_values['client__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{payment_method}}">{{<?php echo filter_var($label_language_values['payment_method']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{notes}}">{{<?php echo filter_var($label_language_values['notes']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{contact_status}}">{{<?php echo filter_var($label_language_values['contact_status']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{price}}">{{<?php echo filter_var($label_language_values['price']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{address}}">{{<?php echo filter_var($label_language_values['client__address']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_city}}">{{<?php echo filter_var($label_language_values['client__city']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_state}}">{{<?php echo filter_var($label_language_values['client__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_zip}}">{{<?php echo filter_var($label_language_values['client__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{client_promocode}}">{{client_promocode}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{app_remain_time}}">{{<?php echo filter_var($label_language_values['app_remain_time']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{reject_status}}">{{<?php echo filter_var($label_language_values['reject_status']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{business_logo}}">{{<?php echo filter_var($label_language_values['business_logo']);	?>}}</a><br />

																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{admin_name}}">{{<?php echo filter_var($label_language_values['admin_name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_name}}">{{<?php echo filter_var($label_language_values['company__name']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_address}}">{{<?php echo filter_var($label_language_values['company__address']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_city}}">{{<?php echo filter_var($label_language_values['company__city']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_state}}">{{<?php echo filter_var($label_language_values['company__state']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_zip}}">{{<?php echo filter_var($label_language_values['company__zip']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_country}}">{{<?php echo filter_var($label_language_values['company__country']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_phone}}">{{<?php echo filter_var($label_language_values['company__phone']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{company_email}}">{{<?php echo filter_var($label_language_values['company__email']);	?>}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{staff_email}}">{{staff_email}}</a><br />
																	<a href="javascript:void(0);" data-id="<?php echo filter_var($staff_template['id']); ?>" class="tags sms_short_tags" data-value="{{staff_name}}">{{staff_name}}</a><br />
																</div>
															</div>

														</form>
													</div>
												</div>
											</div>
										</li>
									<?php
									}
									?>

								</ul>

							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="tab-pane fade in" id="promocode">
        <!-- <form id="form_promo_code" method="post" type="" class="ct-promocode" >-->
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="panel-title"><?php echo $label_language_values['promocode_header']; ?></h1>
          </div>
          <ul class="nav nav-tabs">
            <li class="promocode-list-li active"><a data-toggle="tab" href="#promocode-list"><?php echo $label_language_values['promocodes']; ?></a></li>
            <li class="add_promocode"><a data-toggle="tab" href="#add-new-promocode"><?php echo $label_language_values['add_new']; ?></a></li>
            <li id="update-promocode" class="ct-update-promocode-li hide-div"><a data-toggle="tab" class="ct-update-promocode" href="#"><?php echo $label_language_values['update_promocode']; ?></a></li>
            <li class="special_offer"><a data-toggle="tab" href="#special_offer"><?php echo "Add Special Offer"; ?></a></li>
            <li class="special-offer-list"><a data-toggle="tab" href="#special-offer-list"><?php echo "Special Offer"; ?></a></li>
            <li id="ct-update-special-offer" class="ct-update-specoff-li hide-div"><a data-toggle="tab" class="ct-update-specialoff" href="#"><?php echo $label_language_values['update_promocode']; ?></a></li>
          </ul>
          <div class="tab-content">
            <div id="promocode-list" class="tab-pane fade in active edit_form_for_coupon">
              <h3><?php echo $label_language_values['promocodes_list']; ?></h3>
              <div class="table-responsive">
                <table id="ld-promocode-list" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th><?php echo $label_language_values['coupon']; ?> #</th>
                      <th><?php echo $label_language_values['coupon_code']; ?></th>
                      <th><?php echo $label_language_values['coupon_type']; ?></th>
                      <th><?php echo $label_language_values['coupon_limit']; ?></th>
                      <th><?php echo $label_language_values['coupon_used']; ?></th>
                      <th><?php echo $label_language_values['coupon_value']; ?></th>
                      <th><?php echo $label_language_values['expiry_date']; ?></th>
                      <th><?php echo $label_language_values['actions']; ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $allpromocode = $promo->readall();
                    $cp = 1;
                    while ($row = @mysqli_fetch_array($allpromocode)) {
                      if ($row['coupon_type'] == 'P') {
                        $coupon_type = "Percentage";
                      } else {
                        $coupon_type = "Flat";
                      }
                    ?>
                      <tr id="coupondata_row<?php echo $row['id']; ?>">
                        <td><?php echo $cp; ?></td>
                        <td><?php echo $row['coupon_code']; ?></td>
                        <td><?php echo $coupon_type; ?></td>
                        <td><?php echo $row['coupon_limit']; ?></td>
                        <td><?php echo $row['coupon_used']; ?></td>
                        <td><?php echo $row['coupon_value']; ?></td>
                        <td><?php echo str_replace($english_date_array, $selected_lang_label, date($getdateformat, strtotime($row['coupon_expiry']))); ?></td>
                        <td>
                          <a href="#update-promocode-form<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>" data-toggle="tab" class="btn-circle btn-info btn-xs ct-edit-coupon" title="<?php echo $label_language_values['edit_coupon_code']; ?>">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>

                          <a id="ld-delete-promocode" data-toggle="popover" class="pull-right btn-circle btn-danger btn-xs delete-promocode" data-id="<?php echo $row['id']; ?>" rel="popover" data-placement="left" title="<?php echo $label_language_values['delete_promocode']; ?>">
                            <i class="fa fa-trash"></i>
                          </a>
                          <div id="popover-delete-promocode<?php echo $row['id']; ?>" style="display: none;">
                            <div class="arrow"></div>
                            <table class="form-horizontal" cellspacing="0">
                              <tbody>
                                <tr>
                                  <td>
                                    <a id="promodata_delete" data-id="<?php echo $row['id']; ?>" value="Delete" class="btn btn-danger mybtndeletepromocode"><?php echo $label_language_values['yes']; ?></a>
                                    <a id="ld-close-popover-delete-promocode" class="btn btn-default"><?php echo $label_language_values['cancel']; ?></a>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </td>
                      </tr>
                    <?php
                      $cp++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div id="add-new-promocode" class="tab-pane fade">
              <h3><?php echo $label_language_values['add_new_promocode']; ?></h3>
              <!-- <form id="" method="post" type="" class="ct-promocode" >-->
              <form id="form_promo_code" method="post" type="" class="ct-promocode">
                <div class="table-responsive">
                  <table class="form-inline ld-common-table">
                    <tbody>
                      <tr>
                        <td><?php echo $label_language_values['coupon_code']; ?></td>
                        <td>
                          <div class="form-group">
                            <input type="text" class="form-control" id="coupon_code" name="coupon_code" value="" placeholder="<?php echo $label_language_values['coupon_code']; ?>" /><br />
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><?php echo $label_language_values['coupon_type']; ?></td>
                        <td>
                          <div class="form-group">
                            <select name="coupon_type" id="coupon_type" class="selectpicker" data-size="3" style="display: none;">
                              <option value="P"><?php echo $label_language_values['percentage']; ?></option>
                              <option value="F"><?php echo $label_language_values['flat']; ?></option>
                            </select>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><?php echo $label_language_values['value']; ?></td>
                        <td>
                          <div class="form-group">
                            <input type="text" class="form-control" name="coupon_value" id="coupon_value" value="" placeholder="<?php echo $label_language_values['value']; ?>" />
                            <a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo $label_language_values['coupon_value_would_be_consider_as_percentage_in_percentage_mode_and_in_flat_mode_it_will_be_consider_as_amount_no_need_to_add_percentage_sign_it_will_auto_added']; ?>"><i class="fa fa-info-circle fa-lg"></i></a>
                          </div>

                        </td>
                      </tr>
                      <tr>
                        <td><?php echo $label_language_values['limit']; ?></td>
                        <td>
                          <div class="form-group">
                            <input type="text" class="form-control" name="coupon_limit" id="coupon_limit" value="" placeholder="<?php echo $label_language_values['coupon_limit']; ?>" />
                            <a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo $label_language_values['coupon_code_will_work_for_such_limit']; ?>"><i class="fa fa-info-circle fa-lg"></i></a>
                          </div>

                        </td>
                      </tr>
                      <tr>
                        <td><?php echo $label_language_values['expiry_date']; ?></td>
                        <td>
                          <div class="form-group input-group">
                            <input class="form-control exp_cp_date" name="coupon_expiry_date" id="expiry_date" data-date-format="yyyy/mm/dd" data-provide="datepicker" readonly="readonly" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>

                          </div>
                          <label for="expiry_date" style="display:none" generated="true" class="error"></label>
                          <a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo $label_language_values['coupon_code_will_work_for_such_date']; ?>"><i class="fa fa-info-circle fa-lg"></i></a>

                        </td>
                      </tr>


                      <tr>
                        <td></td>
                        <td>
                          <a id="promo_code" name="promo_code" class="btn btn-success mt-20"><?php echo $label_language_values['create']; ?></a>
                        </td>
                      </tr>

                    </tbody>

                  </table>
                </div>
              </form>
            </div>
            <div id="special_offer" class="tab-pane fade">
              <h3><?php echo "Add New Special Offer"; ?></h3>
              <form id="special_offer_form">
                <div class="table-responsive">
                  <table class="form-inline ld-common-table">
                    <tbody>

                      <tr>
                        <td><?php echo "Special offer Text"; ?></td>
                        <td>
                          <div class="form-group">
                            <input type="text" name="special_text" required style="width: 400px;" class="form-control" id="special_text" name="special_text" value=""><br />
                          </div>

                        </td>
                      </tr>

                      <tr>
                        <td><?php echo $label_language_values['coupon_type']; ?></td>
                        <td>
                          <div class="form-group">
                            <select name="so_coupon_type" id="so_coupon_type" class="selectpicker" data-size="3" style="display: none;">
                              <option value="P"><?php echo $label_language_values['percentage']; ?></option>
                              <option value="F"><?php echo $label_language_values['flat']; ?></option>
                            </select>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><?php echo $label_language_values['value']; ?></td>
                        <td>
                          <div class="form-group">
                            <input type="text" class="form-control" name="so_coupon_value" id="so_coupon_value" value="" placeholder="<?php echo $label_language_values['value']; ?>" />
                            <a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo $label_language_values['coupon_value_would_be_consider_as_percentage_in_percentage_mode_and_in_flat_mode_it_will_be_consider_as_amount_no_need_to_add_percentage_sign_it_will_auto_added']; ?>"><i class="fa fa-info-circle fa-lg"></i></a>
                          </div>

                        </td>
                      </tr>

                      <tr>
                        <td><?php echo $label_language_values['expiry_date']; ?></td>
                        <td>
                          <div class="form-group input-group">
                            <input class="form-control so_exp_cp_date" name="so_coupon_expiry_date" id="so_expiry_date" data-date-format="yyyy/mm/dd" data-provide="datepicker" readonly="readonly" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>

                          </div>
                          <label for="expiry_date" style="display:none" generated="true" class="error"></label>
                          <a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo $label_language_values['coupon_code_will_work_for_such_date']; ?>"><i class="fa fa-info-circle fa-lg"></i></a>

                        </td>
                      </tr>

                    </tbody>

                  </table>
                </div>
              </form>

              <div class="col-xs-3 col-md-3 mt-20" style="margin-left:15px;">
                <a id="specail_offer_setting" name="specail_offer_setting" class="btn btn-success specail_offer_setting"><?php echo $label_language_values['save_setting']; ?></a>
              </div>
            </div>

            <div id="special-offer-list" class="tab-pane fade in edit_form_for_coupon">
              <h3><?php echo "Special Offer List"; ?></h3>
              <div class="table-responsive">
                <table id="ld-special-offer-list" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th><?php echo "Offer"; ?> #</th>
                      <th><?php echo "Special Offer Text"; ?></th>
                      <th><?php echo $label_language_values['coupon_type']; ?></th>
                      <th><?php echo $label_language_values['coupon_value']; ?></th>
                      <th><?php echo "Offer date"; ?></th>
                      <th><?php echo $label_language_values['actions']; ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $allspecialoffer = $promo->readalloffer();
                    $cp = 1;
                    while ($row = @mysqli_fetch_array($allspecialoffer)) {
                      if ($row['coupon_type'] == 'P') {
                        $coupon_type = "Percentage";
                      } else {
                        $coupon_type = "Flat";
                      }
                    ?>
                      <tr id="couponspecdata_row<?php echo $row['id']; ?>">
                        <td><?php echo $cp; ?></td>
                        <td><?php echo $row['special_text']; ?></td>
                        <td><?php echo $coupon_type; ?></td>
                        <td><?php echo $row['coupon_value']; ?></td>
                        <td><?php echo str_replace($english_date_array, $selected_lang_label, date($getdateformat, strtotime($row['coupon_date']))); ?></td>
                        <td>
                          <a href="#update-special-offer-form<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>" data-toggle="tab" class="btn-circle btn-info btn-xs ct-edit-specoff" title="<?php echo $label_language_values['edit_coupon_code']; ?>">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>

                          <a id="ld-delete-specialoffer" data-toggle="popover" class="pull-right btn-circle btn-danger btn-xs delete-specialoffer" data-id="<?php echo $row['id']; ?>" rel="popover" data-placement="left" title="<?php echo "Delete Special Offer"; ?>">
                            <i class="fa fa-trash"></i>
                          </a>
                          <div id="popover-delete-specialoffer<?php echo $row['id']; ?>" style="display: none;">
                            <div class="arrow"></div>
                            <table class="form-horizontal" cellspacing="0">
                              <tbody>
                                <tr>
                                  <td>
                                    <a id="specoffdata_delete" data-id="<?php echo $row['id']; ?>" value="Delete" class="btn btn-danger mybtndeletespecoff"><?php echo $label_language_values['yes']; ?></a>
                                    <a id="ld-close-popover-delete-specialoffer" class="btn btn-default"><?php echo $label_language_values['cancel']; ?></a>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </td>
                      </tr>
                    <?php
                      $cp++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

            <?php
            $readcp = $promo->readall();
            while ($rowcp = @mysqli_fetch_array($readcp)) {
            ?>
              <div id="update-promocode-form<?php echo $rowcp['id']; ?>" class="tab-pane fade update-promocode-new">
                <h3><?php echo $label_language_values['update_promocode']; ?></h3>
                <form id="update_promo_formss<?php echo $rowcp['id']; ?>" method="post" type="" class="">
                  <div class="table-responsive">
                    <table class="form-inline ld-common-table">
                      <tbody>
                        <tr>
                          <td><?php echo $label_language_values['coupon_code']; ?></td>
                          <td>
                            <div class="form-group">
                              <input type="hidden" class="form-control" id="recordid" value="<?php echo $rowcp['coupon_code']; ?>">
                              <input type="text" class="form-control" id="edit_coupon_code<?php echo $rowcp['id']; ?>" name="coupon_code<?php echo $rowcp['id']; ?>" value="<?php echo $rowcp[1]; ?>" placeholder="<?php echo $label_language_values['coupon_code']; ?>" /><br />
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo $label_language_values['coupon_type']; ?></td>
                          <td>
                            <div class="form-group">
                              <select name="coupon_type" id="edit_coupon_type<?php echo $rowcp['id']; ?>" class="selectpicker" data-size="3" style="display: none;">
                                <option value="P" <?php if ($rowcp['coupon_type'] == 'P') {
                                                    echo "selected";
                                                  } ?>><?php echo $label_language_values['percentage']; ?></option>
                                <option value="F" <?php if ($rowcp['coupon_type'] == 'F') {
                                                    echo "selected";
                                                  } ?>><?php echo $label_language_values['flat']; ?></option>
                              </select>
                            </div>
                          </td>
                        </tr>


                        <tr>
                          <td><?php echo $label_language_values['value']; ?></td>
                          <td>
                            <div class="form-group">
                              <input type="text" class="form-control" id="edit_value<?php echo $rowcp['id']; ?>" name="valuessd<?php echo $rowcp['id']; ?>" value="<?php echo $rowcp['coupon_value']; ?>" placeholder="<?php echo $label_language_values['value']; ?>" /><br />
                            </div>
                            <a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo $label_language_values['coupon_value_would_be_consider_as_percentage_in_percentage_mode_and_in_flat_mode_it_will_be_consider_as_amount_no_need_to_add_percentage_sign_it_will_auto_added']; ?>"><i class="fa fa-info-circle fa-lg"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo $label_language_values['limit']; ?></td>
                          <td>
                            <div class="form-group">
                              <input type="text" id="edit_limit<?php echo $rowcp['id']; ?>" class="form-control" name="limit<?php echo $rowcp['id']; ?>" value="<?php echo $rowcp['coupon_limit']; ?>" placeholder="<?php echo $label_language_values['coupon_limit']; ?>" /><br />
                            </div>
                            <a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo $label_language_values['coupon_code_will_work_for_such_limit']; ?>"><i class="fa fa-info-circle fa-lg"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo $label_language_values['expiry_date']; ?></td>
                          <td>
                            <div class="form-group input-group">
                              <input class="form-control exp_cp_date" id="edit_expiry_date<?php echo $rowcp['id']; ?>" value="<?php echo $rowcp['coupon_expiry']; ?>" data-date-format="yyyy/mm/dd" data-provide="datepicker" readonly="readonly" />
                              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                            <a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo $label_language_values['coupon_code_will_work_for_such_date']; ?>"><i class="fa fa-info-circle fa-lg"></i></a>
                          </td>
                        </tr>


                        <tr>
                          <td></td>
                          <td>
                            <a data-id="<?php echo $rowcp['id']; ?>" id="edit_form_data" name="edit_form" class="btn btn-success mybtnupdatepromocode" type="submit"><?php echo $label_language_values['update']; ?></a>
                          </td>
                        </tr>
                      </tbody>

                    </table>
                  </div>
                </form>

              </div>
            <?php
            }

            $allspecialoffer = $promo->readalloffer();
            while ($rowso = @mysqli_fetch_array($allspecialoffer)) {
            ?>
              <div id="update-special-offer-form<?php echo $rowso['id']; ?>" class="tab-pane fade update-specoff-new">
                <h3><?php echo 'Update Special Offer'; ?></h3>
                <form id="update_special_formss<?php echo $rowso['id']; ?>" method="post" type="" class="">
                  <div class="table-responsive">
                    <table class="form-inline ld-common-table">
                      <tbody>
                        <tr>
                          <td><?php echo 'Special Offer Text'; ?></td>
                          <td>
                            <div class="form-group">

                              <input type="hidden" class="form-control" id="recordid" value="<?php echo $rowso[4]; ?>">

                              <input type="text" required style="width: 400px;" class="form-control" id="edit_special_text<?php echo $rowso['id']; ?>" name="special_text<?php echo $rowso['id']; ?>" value="<?php echo $rowso[4]; ?>" placeholder="<?php echo 'special offer text'; ?>"><br />

                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo $label_language_values['coupon_type']; ?></td>
                          <td>
                            <div class="form-group">
                              <select name="coupon_type" id="edit_offer_type<?php echo $rowso['id']; ?>" class="selectpicker" data-size="3" style="display: none;">
                                <option value="P" <?php if ($rowso['coupon_type'] == 'P') {
                                                    echo "selected";
                                                  } ?>><?php echo $label_language_values['percentage']; ?></option>
                                <option value="F" <?php if ($rowso['coupon_type'] == 'F') {
                                                    echo "selected";
                                                  } ?>><?php echo $label_language_values['flat']; ?></option>
                              </select>
                            </div>
                          </td>
                        </tr>


                        <tr>
                          <td><?php echo $label_language_values['value']; ?></td>
                          <td>
                            <div class="form-group">
                              <input type="text" class="form-control" id="edit_special_value<?php echo $rowso['id']; ?>" name="special_off_val<?php echo $rowso['id']; ?>" value="<?php echo $rowso['coupon_value']; ?>" placeholder="<?php echo $label_language_values['value']; ?>" /><br />
                            </div>
                            <a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo $label_language_values['coupon_value_would_be_consider_as_percentage_in_percentage_mode_and_in_flat_mode_it_will_be_consider_as_amount_no_need_to_add_percentage_sign_it_will_auto_added']; ?>"><i class="fa fa-info-circle fa-lg"></i></a>
                          </td>
                        </tr>

                        <tr>
                          <td><?php echo 'Offer Date'; ?></td>
                          <td>
                            <div class="form-group input-group">
                              <input class="form-control edit_spe_date" id="edit_special_date<?php echo $rowso['id']; ?>" value="<?php echo $rowso['coupon_date']; ?>" data-date-format="yyyy/mm/dd" data-provide="datepicker" readonly="readonly" />
                              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                            <a class="ct-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo $label_language_values['coupon_code_will_work_for_such_date']; ?>"><i class="fa fa-info-circle fa-lg"></i></a>
                          </td>
                        </tr>


                        <tr>
                          <td></td>
                          <td>
                            <a data-id="<?php echo $rowso['id']; ?>" id="edit_spec_off_data" name="edit_spec_form" class="btn btn-success mybtnupdatespecialoffcode" type="submit"><?php echo $label_language_values['update']; ?></a>
                          </td>
                        </tr>
                      </tbody>

                    </table>
                  </div>
                </form>

              </div>
            <?php
            }
            ?>
          </div>
        </div>
        <!--</form>-->
      </div>

			<div class="tab-pane fade in" id="labels">

				<div class="panel panel-default">
					<div class="panel-heading lda-top-right">
						<h1 class="panel-title"><?php echo filter_var($label_language_values['labels_settings']);	?></h1>
					</div>
					<div class="panel-body pt-50 plr-10">
						<table class="form-inline ld-common-table">
							<tbody>

								<tr>
									<td><label><?php echo filter_var($label_language_values['select_language_to_change_label']);	?></label></td>
									<td>
										<div class="form-group">
											<select name="ld_update_labels" id="update_labels" class="selectpicker" data-size="10" data-live-search="true" data-live-search-placeholder="<?php echo filter_var($label_language_values['search']);	?>" style="display: none;">
												<option value="none"><?php echo filter_var($label_language_values['select_language_for_update']);	?></option>
												<option value="en">English (United States)</option>
												<option value="ary" lang="ar">العربية المغربية</option>
												<option value="ar" lang="ar">العربية</option>
												<option value="az">Azərbaycan dili</option>
												<option value="azb" lang="az">گؤنئی آذربایجان</option>
												<option value="bg_BG">Български</option>
												<option value="bn_BD">বাংলা</option>
												<option value="bs_BA">Bosanski</option>
												<option value="ca">Català</option>
												<option value="ceb">Cebuano</option>
												<option value="cs_CZ">Čeština‎</option>
												<option value="cy">Cymraeg</option>
												<option value="da_DK">Dansk</option>
												<option value="de_CH_informal">Deutsch (Schweiz, Du)</option>
												<option value="de_DE_formal">Deutsch (Sie)</option>
												<option value="de_DE">Deutsch</option>
												<option value="de_CH">Deutsch (Schweiz)</option>
												<option value="el">Ελληνικά</option>
												<option value="en_CA">English (Canada)</option>
												<option value="en_GB">English (UK)</option>
												<option value="en_NZ">English (New Zealand)</option>
												<option value="en_ZA">English (South Africa)</option>
												<option value="en_AU">English (Australia)</option>
												<option value="eo">Esperanto</option>
												<option value="es_ES">Español</option>
												<option value="et">Eesti</option>
												<option value="eu">Euskara</option>
												<option value="fa_IR" lang="fa">فارسی</option>
												<option value="fi">Suomi</option>
												<option value="fr_FR">Français</option>
												<option value="gd">Gàidhlig</option>
												<option value="gl_ES">Galego</option>
												<option value="gu">ગુજરાતી</option>
												<option value="haz" lang="haz">هزاره گی</option>
												<option value="hi_IN">हिन्दी</option>
												<option value="hr">Hrvatski</option>
												<option value="hu_HU">Magyar</option>
												<option value="hy">Հայերեն</option>
												<option value="id_ID">Bahasa Indonesia</option>
												<option value="is_IS">Íslenska</option>
												<option value="it_IT">Italiano</option>
												<option value="ja">日本語</option>
												<option value="ka_GE">ქართული</option>
												<option value="ko_KR">한국어</option>
												<option value="lt_LT">Lietuvių kalba</option>
												<option value="lv">Latviešu valoda</option>
												<option value="mk_MK">Македонски јазик</option>
												<option value="mr">मराठी</option>
												<option value="ms_MY">Bahasa Melayu</option>
												<option value="my_MM">ဗမာစာ</option>
												<option value="nb_NO">Norsk bokmål</option>
												<option value="nl_NL">Nederlands</option>
												<option value="nl_NL_formal">Nederlands (Formeel)</option>
												<option value="nn_NO">Norsk nynorsk</option>
												<option value="oci">Occitan</option>
												<option value="pl_PL">Polski</option>
												<option value="pt_PT">Português</option>
												<option value="pt_BR">Português do Brasil</option>
												<option value="ro_RO">Română</option>
												<option value="ru_RU">Русский</option>
												<option value="sk_SK">Slovenčina</option>
												<option value="sl_SI">Slovenščina</option>
												<option value="sq">Shqip</option>
												<option value="sr_RS">Српски језик</option>
												<option value="sv_SE">Svenska</option>
												<option value="szl">Ślōnskŏ gŏdka</option>
												<option value="th">ไทย</option>
												<option value="tl">Tagalog</option>
												<option value="tr_TR">Türkçe</option>
												<option value="ug_CN">Uyƣurqə</option>
												<option value="uk">Українська</option>
												<option value="vi">Tiếng Việt</option>
												<option value="zh_TW">繁體中文</option>
												<option value="zh_HK">香港中文版</option>
												<option value="zh_CN">简体中文</option>
											</select>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<?php  /* <table class="form-inline ld-common-table show_all_labels" >
																<ul class="nav nav-tab nav-stacked ld-labels-lang-ul pl-15 pr-15 myall_lang_label">
									
								</ul>	
														</table> */ ?>
						<div class="myall_lang_label">
						</div>
						<table class="form-inline ld-common-table">
							<tfoot>
								<tr>
									<td></td>
									<td>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>

			</div>



			<div class="tab-pane fade in" id="front_tooltips">
				<form id="ld-fronttooltips-settings" method="post" type="" class="ld-labels-settings">
					<div class="panel panel-default">
						<div class="panel-heading lda-top-right">
							<h1 class="panel-title"><?php echo filter_var($label_language_values['front_tool_tips']);	?></h1>
							<span class="pull-right lda-setting-fix-btn"> <a class="btn btn-success front_tooltips_setting" type="submit"><?php echo filter_var($label_language_values['save_setting']);	?></a></span>
						</div>
						<div class="panel-body pt-50 plr-10">

							<div class="panel panel-default ld-payment-methods">
								<div class="panel-heading">
									<h4 class="panel-title">
										<span><?php echo filter_var($label_language_values['front_tool_tips_lower']);	?></span>
										<div class="ld-enable-disable-right pull-right">
											<label class="ctoggle-twocheckout-payment-checkout" for="front-tooltips">
												<input class="lda-toggle-checkbox" data-toggle="toggle" data-size="small" type='checkbox' <?php if ($setting->ld_front_tool_tips_status == 'on') {
																																				echo filter_var('checked');
																																			} ?> name="" id="front-tooltips" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />

											</label>
										</div>
									</h4>
								</div>
								<div id="collapseOne" <?php if ($setting->ld_front_tool_tips_status == 'on') {
															echo 'style="display:block"';
														} ?> class="panel-collapse collapse mycollapse_front-tooltips">
									<div class="panel-body p-10">
										<table class="form-inline ld-common-table">
											<tbody>
												<tr>
													<td><label><?php echo filter_var($label_language_values['tool_tip_my_bookings']);	?></label></td>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="ld_front_tool_tips_my_bookings" value="<?php echo filter_var($setting->ld_front_tool_tips_my_bookings); ?>" name="ld_front_tool_tips_my_bookings" size="50" />
														</div>
													</td>
												</tr>
												<tr>
													<td><label><?php echo filter_var($label_language_values['tool_tip_postal_code']);	?></label></td>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="ld_front_tool_tips_postal_code" value="<?php echo filter_var($setting->ld_front_tool_tips_postal_code); ?>" name="ld_front_tool_tips_postal_code" size="50" />
														</div>
													</td>
												</tr>
												<tr>
													<td><label><?php echo filter_var($label_language_values['tool_tip_services']);	?></label></td>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="ld_front_tool_tips_services" value="<?php echo filter_var($setting->ld_front_tool_tips_services); ?>" name="ld_front_tool_tips_services" size="50" />
														</div>
													</td>
												</tr>
												<tr>
													<td><label><?php echo filter_var($label_language_values['tool_tip_extra_service']);	?></label></td>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="ld_front_tool_tips_addons_services" value="<?php echo filter_var($setting->ld_front_tool_tips_addons_services); ?>" name="ld_front_tool_tips_addons_services" size="50" />
														</div>
													</td>
												</tr>
												<tr>
													<td><label><?php echo filter_var($label_language_values['tool_tip_when_would_you_like_us_to_come']);	?></label></td>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="ld_front_tool_tips_time_slots" value="<?php echo filter_var($setting->ld_front_tool_tips_time_slots); ?>" name="ld_front_tool_tips_time_slots" size="50" />
														</div>
													</td>
												</tr>
												<tr>
													<td><label><?php echo filter_var($label_language_values['tool_tip_your_personal_details']);	?></label></td>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="ld_front_tool_tips_personal_details" value="<?php echo filter_var($setting->ld_front_tool_tips_personal_details); ?>" name="ld_front_tool_tips_personal_details" size="50" />
														</div>
													</td>
												</tr>
												<tr>
													<td><label><?php echo filter_var($label_language_values['tool_tip_have_a_promocode']);	?></label></td>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="ld_front_tool_tips_promocode" value="<?php echo filter_var($setting->ld_front_tool_tips_promocode); ?>" name="ld_front_tool_tips_promocode" size="50" />
														</div>
													</td>
												</tr>
												<tr>
													<td><label><?php echo filter_var($label_language_values['tool_tip_preferred_payment_method']);	?></label></td>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="ld_front_tool_payment_method" value="<?php echo filter_var($setting->ld_front_tool_payment_method); ?>" name="ld_front_tool_payment_method" size="50" />
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<table class="form-inline ld-common-table">
								<tfoot>
									<tr>
										<td></td>
										<td>
											<a href="javascript:void(0);" name="" class="btn btn-success front_tooltips_setting" type="submit"><?php echo filter_var($label_language_values['save_setting']);	?></a>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</form>
			</div>


			<div class="tab-pane fade in" id="manageable-form-fields">
				<form id="ld-manageable-form-field-settings" method="post" type="" class="ld-labels-settings">
					<div class="panel panel-default">
						<div class="panel-heading lda-top-right">
							<h1 class="panel-title"><?php echo filter_var($label_language_values['manageable_form_fields_front_booking_form']);	?></h1>
							<span class="pull-right lda-setting-fix-btn"> <a class="btn btn-success save_manage_form_fields" type="submit"><?php echo filter_var($label_language_values['save_setting']);	?></a></span>
						</div>
						<div class="panel-body pt-50 plr-10">
							<div class="table-responsive">
								<table class="table table-hover table-bordered table-striped">
									<thead>
										<tr>
											<th><strong><?php echo filter_var($label_language_values['field_name']);	?></strong></th>
											<th><strong><?php echo filter_var($label_language_values['enable_disable']);	?></strong></th>
											<th><strong><?php echo filter_var($label_language_values['required']);	?></strong></th>
											<th><strong><?php echo filter_var($label_language_values['min_length']);	?></strong></th>
											<th><strong><?php echo filter_var($label_language_values['max_length']);	?></strong></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><label><?php echo filter_var($label_language_values['show_company_logo']);	?></label></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-postal-code" for="show_company_logo_header">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->get_option('ld_company_logo_display') == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="show_company_logo" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td><label>Show_company_title</label></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-postal-code" for="show_company_title_header">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->get_option('ld_company_title_display') == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="show_company_title" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td><label><?php echo filter_var($label_language_values['show_company_address_in_header']);	?></label></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-postal-code" for="Show_comapny_address_header">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->get_option('ld_company_header_address') == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="Show_comapny_address" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['front_language_flags_list']); ?></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="front_lang_dd">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->get_option('ld_front_language_selection_dropdown') == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="front_lang_dd" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td><label><?php echo filter_var($label_language_values['show_description']);	?></label></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-postal-code" for="show_company_logo_header">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->get_option('ld_company_service_desc_status') == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="show_desc_front" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td><label><?php echo filter_var($label_language_values['display_sub_headers_below_headers']);	?></label></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-ld_subheaders" for="ld_subheaders">
														<input data-toggle="toggle" data-size="small" type='checkbox' name="ld_subheaders" <?php if ($setting->ld_subheaders == 'Y') {
																																				echo filter_var('checked');
																																			} ?> id="ld_subheaders" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td><label><?php echo filter_var($label_language_values['appointment_details_section']);	?></label></td>
											<td>
												<div class="form-group">
													<label class="ctoggle-ld_subheaders" for="hide-appoint-details">
														<input data-toggle="toggle" data-size="small" name="appoint_details" type='checkbox' <?php if ($setting->ld_appointment_details_display == 'on') {
																																					echo filter_var('checked');
																																				} ?> id="hide_appoint_details" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
												<?php  /*
												<a class="ld-tooltip-link" href="#" data-toggle="tooltip" title="<?php echo filter_var($label_language_values['if_you_are_having_booking_system_which_need_the_booking_address_then_please_make_this_field_enable_or_else_it_will_not_able_to_take_the_booking_address_and_display_blank_address_in_the_booking']);	?>"><i class="fa fa-info-circle fa-lg"></i></a>
												*/ ?>
											</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['preferred_email']);	?></td>
											<td><?php echo filter_var($label_language_values['enabled']);	?></td>
											<td><?php echo filter_var($label_language_values['required']);	?></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['preferred_password']);	?></td>
											<td><?php echo filter_var($label_language_values['enabled']);	?></td>
											<td><?php echo filter_var($label_language_values['required']);	?></td>
											<td>
												<?php $password_check = explode(",", $setting->get_option('ld_bf_password')); ?>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="pass_min" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control pass_min v_c" data-names="pass" name="pass_min" value="<?php echo filter_var($password_check['2']); ?>">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="pass_min" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="pass_max" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control pass_max v_c_pass" value="<?php echo filter_var($password_check['3']); ?>" name="pass_max">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="pass_max" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['first_name']);	?><?php $check = explode(",", $setting->get_option('ld_bf_first_name')); ?></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="ld_bf_first_name_1">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[0] == "on") {
																																								echo filter_var("checked");
																																							} ?> id="ld_bf_first_name_1" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="ld_bf_first_name_2">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[1] == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="ld_bf_first_name_2" data-on="<?php echo filter_var("True");	?>" data-off="<?php echo filter_var("False");	?>" data-onstyle='primary' data-offstyle='default' />
													</label>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="fname_min" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control fname_min v_c" data-names="fname" name="fname_min" value="<?php echo filter_var($check[2]); ?>">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="fname_min" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="fname_max" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control fname_max v_c_fname" value="<?php echo filter_var($check[3]); ?>" name="fname_max">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="fname_max" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['last_name']); ?><?php $check = explode(",", $setting->get_option('ld_bf_last_name')); ?></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_last_name_1">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[0] == "on") {
																																								echo filter_var("checked");
																																							} ?> id="cff_last_name_1" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_last_name_2">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[1] == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="cff_last_name_2" data-on="<?php echo filter_var("True");	?>" data-off="<?php echo filter_var("False");	?>" data-onstyle='primary' data-offstyle='default' />
													</label>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="lname_min" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control lname_min v_c" data-names="lname" name="lname_min" value="<?php echo filter_var($check[2]); ?>">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="lname_min" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="lname_max" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control lname_max v_c_lname" value="<?php echo filter_var($check[3]); ?>" name="lname_max">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="lname_max" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
										</tr>

										<tr>
											<td><?php echo filter_var($label_language_values['phone']);	?><?php $check = explode(",", $setting->get_option('ld_bf_phone')); ?></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_phone_1">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[0] == "on") {
																																								echo filter_var("checked");
																																							} ?> id="cff_phone_1" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_phone_2">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[1] == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="cff_phone_2" data-on="<?php echo filter_var("True");	?>" data-off="<?php echo filter_var("False");	?>" data-onstyle='primary' data-offstyle='default' />
													</label>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="phone_min" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control phone_min v_c" data-names="phone" name="phone_min" value="<?php echo filter_var($check[2]);	?>">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="phone_min" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="phone_max" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control phone_max v_c_phone" value="<?php echo filter_var($check[3]); ?>" name="phone_max">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="phone_max" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['street_address']);	?><?php $check = explode(",", $setting->get_option('ld_bf_address'));	?></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_street_address_1">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[0] == "on") {
																																								echo filter_var("checked");
																																							} ?> id="cff_street_address_1" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_street_address_2">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[1] == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="cff_street_address_2" data-on="<?php echo filter_var("True");	?>" data-off="<?php echo filter_var("False");	?>" data-onstyle='primary' data-offstyle='default' />
													</label>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="street_address_min" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control street_address_min" name="street_address_min v_c" data-names="street_address" value="<?php echo filter_var($check[2]); ?>">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="street_address_min" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="street_address_max" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control street_address_max v_c_street_address" value="<?php echo filter_var($check[3]);	?>" name="street_address_max">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="street_address_max" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['zip_code']);	?><?php $check = explode(",", $setting->get_option('ld_bf_zip_code')); ?></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_zip_code_1">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[0] == "on") {
																																								echo filter_var("checked");
																																							} ?> id="cff_zip_code_1" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_zip_code_2">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[1] == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="cff_zip_code_2" data-on="<?php echo filter_var("True");	?>" data-off="<?php echo filter_var("False");	?>" data-onstyle='primary' data-offstyle='default' />
													</label>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="zip_code_min" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control zip_code_min" name="zip_code_min v_c" data-names="zip" value="<?php echo filter_var($check[2]); ?>">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="zip_code_min" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="zip_code_max" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control zip_code_max v_c_zip" value="<?php echo filter_var($check[3]); ?>" name="zip_code_max">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="zip_code_max" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['city']);	?><?php $check = explode(",", $setting->get_option('ld_bf_city')); ?></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_city_1">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[0] == "on") {
																																								echo filter_var("checked");
																																							} ?> id="cff_city_1" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_city_2">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[1] == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="cff_city_2" data-on="<?php echo filter_var("True");	?>" data-off="<?php echo filter_var("False");	?>" data-onstyle='primary' data-offstyle='default' />
													</label>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="city_min" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control city_min v_c" data-names="city" name="city_min" value="<?php echo filter_var($check[2]); ?>">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="city_min" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="city_max" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control city_max v_c_city" value="<?php echo filter_var($check[3]); ?>" name="city_max">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="city_max" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['state']);	?><?php $check = explode(",", $setting->get_option('ld_bf_state')); ?></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_state_1">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[0] == "on") {
																																								echo filter_var("checked");
																																							} ?> id="cff_state_1" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_state_2">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[1] == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="cff_state_2" data-on="<?php echo filter_var("True");	?>" data-off="<?php echo filter_var("False");	?>" data-onstyle='primary' data-offstyle='default' />
													</label>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="state_min" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control state_min v_c" data-names="state" name="state_min" value="<?php echo filter_var($check[2]); ?>">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="state_min" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="state_max" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control state_max v_c_state" value="<?php echo filter_var($check[3]); ?>" name="state_max">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="state_max" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['special_requests_notes']);	?><?php $check = explode(",", $setting->get_option('ld_bf_notes')); ?></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_notes_1">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[0] == "on") {
																																								echo filter_var("checked");
																																							} ?> id="cff_notes_1" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-large" for="cff_notes_2">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($check[1] == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="cff_notes_2" data-on="<?php echo filter_var("True");	?>" data-off="<?php echo filter_var("False");	?>" data-onstyle='primary' data-offstyle='default' />
													</label>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="notes_min" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control notes_min" name="notes_min v_c" data-names="notes" value="<?php echo filter_var($check[2]); ?>">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="notes_min" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
											<td>
												<div class="input-group spinner">
													<div class="input-group-btn-horizontal">
														<button class="btn ld-subtraction-btn btn-default input-group-addon" data-info="notes_max" type="button"><i class="fa fa-minus nm"></i></button>
														<input type="text" class="form-control notes_max v_c_notes" value="<?php echo filter_var($check[3]); ?>" name="notes_max">
														<button class="btn ld-addition-btn btn-default input-group-addon" data-info="notes_max" type="button"><i class="fa fa-plus nm"></i></button>
													</div>
												</div>
											</td>
										</tr>

										<tr>
											<td><label><?php echo filter_var($label_language_values['show_how_will_we_get_in']);	?></label></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-postal-code" for="show_company_logo_header">
														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" type='checkbox' name="" <?php if ($setting->get_option('ld_company_willwe_getin_status') == "Y") {
																																								echo filter_var("checked");
																																							} ?> id="show_how_willwe_getin_front" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td><label><?php echo filter_var($label_language_values['show_coupons_input_on_checkout']);	?></label></td>
											<td>
												<div class="form-group nm">
													<label class="ctoggle-postal-code" for="show-coupons-input-oc">

														<input class='lda-toggle-checkbox' data-toggle="toggle" data-size="small" name="" type='checkbox' <?php if ($setting->ld_show_coupons_input_on_checkout == 'on') {
																																								echo filter_var('checked');
																																							} ?> id="show-coupons-input-oc" data-on="<?php echo filter_var($label_language_values['enable']);	?>" data-off="<?php echo filter_var($label_language_values['disable']);	?>" data-onstyle='success' data-offstyle='danger' />
													</label>
												</div>
											</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>

									</tbody>
								</table>
							</div>
							<table class="form-inline ld-common-table">
								<tfoot>
									<tr>
										<td></td>
										<td>
											<a href="javascript:void(0);" name="" class="btn btn-success save_manage_form_fields" type="submit"><?php echo filter_var($label_language_values['save_setting']);	?></a>
										</td>
									</tr>
								</tfoot>
							</table>
							<ul class="nav nav-tab nav-stacked ld-labels-error-ul pl-15 pr-15">
								<?php
								$alllang = $setting->get_all_languages();
								while ($all = mysqli_fetch_array($alllang)) {
									$language_label_arr = $setting->get_all_labelsbyid($all[2]);
									if ($language_label_arr[6] != '') {
										$label_decode_form_field = base64_decode($language_label_arr[6]);

										$label_decode_form_field_unserial = unserialize($label_decode_form_field);
								?>
										<li class="panel panel-default ld-labels-error-listing">
											<div class="panel-heading">
												<h4 class="panel-title">
													<div class="lda-col8"><span><?php echo urldecode($language_names[$all[2]]);	?></span></div>
													<div class="ld-show-hide pull-right">
														<input type="checkbox" name="ld-show-hide" class="ld-show-hide-checkbox" id="myid<?php echo filter_var($all['id']);	?>">
														<label class="ld-show-hide-label" for="myid<?php echo filter_var($all['id']);	?>"></label>
													</div>
												</h4>
											</div>
											<div id="details_myid<?php echo filter_var($all['id']);	?>" class="panel-collapse collapse mycollapse_ct-manageable-errors">
												<div class="panel-body p-10">
													<table class="form-inline ld-common-table">
														<tbody>
															<?php
															foreach ($label_decode_form_field_unserial as $key => $value) {
															?>
																<tr>
																	<td><label class="englabel_<?php echo filter_var($key);	?>"><?php echo filter_var($manage_form_errors_message[$key]);	?></label></td>
																	<td>
																		<div class="form-group">
																			<input type="text" size="50" value="<?php echo urldecode($value);	?>" data-id="<?php echo filter_var($key);	?>" class="form-control langlabel_front_error_<?php echo filter_var($all['id']);	?>" name="ctextralabelct<?php echo filter_var($key);	?>" />
																		</div>
																	</td>
																</tr>
															<?php  } ?>
															<tr>
																<td></td>
																<td>
																	<a href="javascript:void(0);" name="" class="btn btn-success save_front_form_error_labels" data-id="<?php echo filter_var($all['id']);	?>" type="submit"><?php echo filter_var($label_language_values['save_setting']);	?></a>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</li>
								<?php
										/* UPDATE ALL CODE WITH NEW URLENCODE PATTERN */
										foreach ($label_decode_extra_unserial as $key => $value) {
											$label_decode_form_field_unserial[$key] = urldecode($value);
										}
									}
								}
								?>
							</ul>
						</div>
					</div>
				</form>
			</div>
			<div class="tab-pane fade in" id="seo-ga">
				<form id="ld-seo-ga-settings" method="post" type="" class="ld-labels-settings">
					<div class="panel panel-default">
						<div class="panel-heading lda-top-right">
							<h1 class="panel-title"><?php echo filter_var($label_language_values['SEO_Settings']);	?></h1>
							<span class="pull-right lda-setting-fix-btn"> <a class="btn btn-success save_seo_ga" type="submit"><?php echo filter_var($label_language_values['save_setting']);	?></a></span>
						</div>
						<div class="panel-body pt-50 plr-10">
							<div class="table-responsive">
								<table class="form-inline ld-common-table">
									<tbody>
										<tr>
											<td><?php echo filter_var($label_language_values['Google_Analytics_Code']);	?></td>
											<td>
												<div class="form-group">
													<input type="text" size="50" class="form-control" id="ld_google_analytics_code" name="ld_google_analytics_code" value="<?php echo filter_var($setting->get_option('ld_google_analytics_code'));	?>" placeholder="e.g. XX-XXXXXXXXX-X" />
												</div>

											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['Page_Meta_Tag']);	?></td>
											<td>
												<div class="form-group">
													<input type="text" size="50" class="form-control" id="ld_page_meta_tag" name="ld_page_meta_tag" value="<?php echo filter_var($setting->get_option('ld_page_title'));	?>" placeholder="<?php echo filter_var($label_language_values['Page_Meta_Tag']);	?>" />
												</div>

											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['Meta_Description']);	?></td>
											<td>
												<div class="form-group">
													<textarea cols="48" class="form-control" id="ld_seo_meta_description" name="ld_seo_meta_description" placeholder="<?php echo filter_var($label_language_values['Meta_Description']);	?>"><?php echo filter_var($setting->get_option('ld_seo_meta_description'));	?></textarea>
												</div>

											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['Page_Meta_Tag']);	?></td>
											<td>
												<div class="form-group">
													<input type="text" size="50" class="form-control" id="ld_seo_og_title" name="ld_seo_og_title" value="<?php echo filter_var($setting->get_option('ld_seo_og_title'));	?>" placeholder="<?php echo filter_var($label_language_values['og_tag_title']);	?>" />
												</div>

											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['og_tag_type']);	?></td>
											<td>
												<div class="form-group">
													<input type="text" size="50" class="form-control" id="ld_seo_og_type" name="ld_seo_og_type" value="<?php echo filter_var($setting->get_option('ld_seo_og_type'));	?>" placeholder="<?php echo filter_var($label_language_values['og_tag_type']);	?>" />
												</div>

											</td>
										</tr>
										<tr>
											<td><?php echo filter_var($label_language_values['og_tag_url']);	?></td>
											<td>
												<div class="form-group">
													<input type="text" size="50" class="form-control" id="ld_seo_og_url" name="ld_seo_og_url" value="<?php echo filter_var($setting->get_option('ld_seo_og_url'));	?>" placeholder="<?php echo filter_var($label_language_values['og_tag_url']);	?>" />
												</div>

											</td>
										</tr>
										<tr>
											<td><label><?php echo filter_var($label_language_values['og_tag_image']);	?></label></td>
											<td>
												<div class="form-group">
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<span class="btn btn-default btn-file mt-15"><input type="file" id="ld_seo_og_image" name="ld_seo_og_image" /></span>
														<br>
														<span class="fileinput-filename"><?php echo filter_var($label_language_values['recommended_image_type_jpg_jpeg_png_gif']);	?></span>
													</div>
												</div>
											</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td></td>
											<td>
												<a id="save_seo_ga" name="" class="btn btn-success save_seo_ga"><?php echo filter_var($label_language_values['save_setting']);	?></a>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>
			<?php
			if ($gc_hook->gc_purchase_status() == 'exist') {
				echo filter_var($gc_hook->gc_settings_menu_content_hook());
			}
			?>
		</div>
	</div>
</div>


<div id="email-template-preview-modal" class="email-template-preview-popup modal fade" tabindex="-1" role="dialog">
	<div class="vertical-alignment-helper">
		<div class="modal-dialog modal-lg vertical-align-center">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Email Template Preview</h4>
				</div>
				<div class="modal-body email_html_content" style="display: flow-root;">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default hidemodal" data-dismiss="modal" aria-hidden="true"><?php echo filter_var($label_language_values['close']);	?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var settingObj = {
		'ajax_url': '<?php echo filter_var(AJAX_URL, FILTER_VALIDATE_URL);	?>'
	};
	var ajax_url = '<?php echo filter_var(AJAX_URL, FILTER_VALIDATE_URL);	?>';
	var ajaxObj = {
		'ajax_url': '<?php echo filter_var(AJAX_URL, FILTER_VALIDATE_URL);	?>'
	};
	var servObj = {
		'site_url': '<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL) . 'assets/images/business/';	?>'
	};
	var imgObj = {
		'img_url': '<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL) . 'assets/images/';	?>'
	};
</script>
<?php
if ($gc_hook->gc_purchase_status() == 'exist') {
	echo filter_var($gc_hook->gc_settings_save_js_hook());
}
if ($gc_hook->gc_purchase_status() == 'exist') {
	echo filter_var($gc_hook->gc_setting_configure_js_hook());
}
if ($gc_hook->gc_purchase_status() == 'exist') {
	echo filter_var($gc_hook->gc_setting_disconnect_js_hook());
}
if ($gc_hook->gc_purchase_status() == 'exist') {
	echo filter_var($gc_hook->gc_setting_verify_js_hook());
}
include(dirname(__FILE__) . '/footer.php');
?>