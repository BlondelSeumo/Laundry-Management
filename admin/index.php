<?php
include_once(dirname(dirname(__FILE__)) . '/header.php');
$filename = '../config.php';
$file = file_exists($filename);
if ($file) {
	if (filesize($filename) > 0) {
	} else {
		header('Location:' . SITE_URL . 'ld_install.php');
	}
}

include(dirname(dirname(__FILE__)) . '/objects/class_connection.php');
include(dirname(dirname(__FILE__)) . "/objects/class_setting.php");
include(dirname(dirname(__FILE__)) . "/objects/class_version_update.php");
session_start();
$con = new laundry_db();
$conn = $con->connect();
if (isset($_SESSION['ld_adminid'])) {
	header('Location:' . SITE_URL . "admin/calendar.php");
} elseif (isset($_SESSION['ld_staffid'])) {
	header('Location:' . SITE_URL . "staff/staff-dashboard.php");
} elseif (isset($_SESSION['ld_login_user_id'])) {
	header('Location:' . SITE_URL . "admin/user-profile.php");
}
$query = "select * from ld_admin_info";
$info =  $conn->query($query);
if (@mysqli_num_rows($info) == 0) {
	header("Location:../");
}
$settings = new laundry_setting();
$settings->conn = $conn;
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
$lang = $settings->get_option("ld_language");
$label_language_values = array();
$language_label_arr = $settings->get_all_labelsbyid($lang);

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
$loginimage = $settings->get_option('ld_login_image');
if ($loginimage != '') {
	$imagepath = SITE_URL . "assets/images/backgrounds/" . $loginimage;
} else {
	$imagepath = SITE_URL . "assets/images/login-bg.jpg";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo filter_var($settings->get_option("ld_page_title")); ?> | Login</title>
	<link rel="shortcut icon" type="image/png" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/backgrounds/<?php echo filter_var($settings->get_option('ld_favicon_image'));	?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/login-style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/bootstrap/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/bootstrap/bootstrap-theme.min.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/font-awesome/css/font-awesome.css" />
	<script type="text/javascript" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/jquery-2.1.4.min.js"></script>
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/login.js"></script>
	<script type="text/javascript">
		var ajax_url = '<?php echo filter_var(AJAX_URL, FILTER_VALIDATE_URL);	?>';
		var base_url = '<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>';
	</script>
	<style>
		body {
			font-family: 'Open_Sans', sans-serif;
			background: url(<?php echo filter_var($imagepath);	?>) no-repeat;
			background-image: url("<?php echo filter_var($imagepath);	?>");
			font-weight: 300;
			background-size: 100% 100% !important;
			font-size: 15px;
			color: #333;
			-webkit-font-smoothing: antialiased;
		}
	</style>
</head>
<?php
include(dirname(__FILE__) . "/language_js_objects.php");
?>

<body>
	<div id="ld-login">
		<section class="main">
			<div class="vertical-alignment-helper">
				<div class="vertical-align-center">
					<div class="ld-main-login visible animated fadeInUp">
						<div class="form-container">
							<div class="tab-content">
								<form id="login-form" name="" method="POST">
									<h1 class="log-in"><?php echo filter_var($label_language_values['log_in']);	?></h1>
									<div class="form-group fl">
										<label for="userEmail"><i class="icon-envelope-alt"></i><?php echo filter_var($label_language_values['email']);	?></label>
										<input type="email" id="userEmail" value="<?php echo isset($_COOKIE['laundry_username']) ? $_COOKIE['laundry_username'] : "";	?>" name="txtname" placeholder="<?php echo filter_var($label_language_values['email']);	?>" onkeydown="if (event.keyCode == 13) document.getElementById('mybtnlog').click()">
									</div>
									<div class="form-group fl">
										<label for="userPassword"><i class="icon-lock"></i><?php echo filter_var($label_language_values['password']);	?></label>
										<input type="password" id="userPassword" name="txtpassword" placeholder="<?php echo filter_var($label_language_values['password']);	?>" value="<?php echo isset($_COOKIE['laundry_password']) ?  filter_var($_COOKIE['laundry_password']) : "";	?>" class="showpassword" onkeydown="if (event.keyCode == 13) document.getElementById('mybtnlog').click()">
										<div class="ld-show-pass">
											<input id="show-pass" class="ld-checkbox" name="" value="" type="checkbox">
											<label for="show-pass"><span class="show-pass-text"></span></label>
										</div>
									</div>
									<div class="login-error" style="color:red;">
										<label><?php echo filter_var($label_language_values['sorry_wrong_email_or_password']);	?></label>
									</div>
									<div class="ld-custom-checkbox">
										<ul class="ld-checkbox-list">
											<li>
												<input type="checkbox" id="remember_me" class="ld-checkbox" name="remember_me" <?php if (isset($_COOKIE['laundry_remember'])) {
																																	echo filter_var("checked");
																																} else {
																																	echo filter_var("");
																																} ?> />
												<label for="remember_me"><span></span><?php echo filter_var($label_language_values['remember_me']);	?></label>
											</li>
										</ul>
									</div>
									<div class="clearfix">
										<a id="mybtnlog" class="btn ld-login-btn btn-lg col-xs-12 mybtnloginadmin" href="javascript:void(0)"><?php echo filter_var($label_language_values['login']);	?></a>
									</div>
									<div class="clearfix">
										<a class="btn btn-link col-xs-12" id="ld_forget_password" href="javascript:void(0)"><?php echo filter_var($label_language_values['forget_password']);	?></a>
									</div>

									<div class="bottom-forgot-pass">
										<?php
										if ($settings->get_option('ld_staff_registration') == 'Y') {
										?>
											<div class="clearfix">
												<a type="button" class="btn btn-link col-xs-12" id="register_as_staff_btn" href="javascript:void(0)">Register As Staff </a>
											</div>
										<?php } ?>
									</div>
								</form>
								<form id="forget_pass" name="acv" method="POST">
									<h1 class="forget-password"><?php echo filter_var($label_language_values['reset_password']);	?></h1>
									<h4><?php echo filter_var($label_language_values['enter_your_email_and_we_will_send_you_instructions_on_resetting_your_password']);	?></h4>
									<div class="form-group fl">
										<label for="userfpEmail"><i class="icon-envelope-alt"></i><?php echo filter_var($label_language_values['registered_email']);	?></label>
										<input type="email" id="rp_user_email" name="rp_user_email" placeholder="<?php echo filter_var($label_language_values['registered_email']);	?>">
										<label class="forget_pass_correct"></label>
										<label class="forget_pass_incorrect"></label>
									</div>
									<div class="forgotpassword-error" style="color:red;">
										<label><?php echo filter_var($label_language_values['sorry_wrong_email_or_password']);	?></label>
									</div>
									<div class="clearfix">
										<a class="btn ld-info-btn btn-lg col-xs-12 mybtnsendemail_forgotpass" id="reset_pass" href="javascript:void(0)"><?php echo filter_var($label_language_values['send_mail']);	?></a>
									</div>
									<div class="clearfix">
										<a class="btn btn-link col-xs-12" id="ld_login_user" href="javascript:void(0)"><?php echo filter_var($label_language_values['login']);	?></a>
									</div>
								</form>
								<form id="staff-form" name="staff_registration" method="POST">
									<p class="register-meesg" id="register-meesg" style="display:none"> Staff Register Successfully </p>
									<div class="top-heading-common">
										<h3> Register As Staff </h3>
									</div>
									<div class="form-group fl">
										<i class="fa fa-user staff_i" aria-hidden="true"></i>
										<input class="mt-7 form-control effect-2 staff_input" type="text" id="staff_name" name="staff_name" placeholder="Name">
										<span class="focus-border"></span>
									</div>
									<div class="form-group fl">
										<i class="fa fa-envelope staff_i" aria-hidden="true"></i>
										<input class="mt-7 form-control effect-2 staff_input" type="email" id="staff_email" name="staff_email" placeholder="Email">
										<span class="focus-border"></span>
									</div>
									<div class="form-group fl">
										<i class="fa fa-lock staff_i" aria-hidden="true"></i>
										<input class="mt-7 form-control effect-2 staff_input" type="password" id="staff_pass" name="staff_pass" placeholder="Password" class="showpass" onkeydown="if (event.keyCode == 13) document.getElementById('ct_staff_register').click()">
										<span class="focus-border"></span>
									</div>
									<div class="clearfix">
										<button class="btn ct-login-btn btn-lg col-xs-12 mt-0" id="ld_staff_register" href="">Register Yourself</button>
										<div class="clearfix">
											<a class="btn ct-login-btn btn-lg col-xs-12 mt-0" id="forgot_to_login_form" href="">Log In</a>
										</div>
									</div>

								</form>
							</div>​​
						</div>​​
					</div>​
				</div>
			</div>
		</section>
	</div>
	<script>
		jQuery(document).ready(function() {
			jQuery("#forget_pass").hide();
			jQuery("#staff-form").hide();
			jQuery(document).on("click", "#ld_forget_password", function() {
				jQuery('#login-form').hide();
				jQuery('#staff-form').hide();
				jQuery("#forget_pass").show();
			});
			jQuery(document).on("click", "#forgot_to_login_form", function() {
				jQuery("#forget_pass").hide();
				jQuery("#staff-form").hide();
				jQuery('#login-form').show();
			});
			jQuery(document).on("click", "#register_as_staff_btn", function() {
				jQuery("#login-form").hide();
				jQuery("#forget_pass").hide();
				jQuery('#staff-form').show();
			});
		});
	</script>
</body>

</html>