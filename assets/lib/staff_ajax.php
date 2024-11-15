<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_connection.php");
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_adminprofile.php");
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_setting.php");
include(dirname(dirname(dirname(__FILE__))) . "/header.php");
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_dayweek_avail.php");
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_offtimes.php");
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_offbreaks.php");
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_off_days.php");
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_booking.php");
include(dirname(dirname(dirname(__FILE__))) . '/objects/class.phpmailer.php');
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_dashboard.php");
include(dirname(dirname(dirname(__FILE__))) . '/objects/class_general.php');
include(dirname(dirname(dirname(__FILE__))) . '/objects/class_email_template.php');
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_staff_commision.php");
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_payments.php");
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_rating_review.php");
include(dirname(dirname(dirname(__FILE__))) . '/objects/plivo.php');
include(dirname(dirname(dirname(__FILE__))) . '/assets/twilio/Services/Twilio.php');
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_nexmo.php");
include(dirname(dirname(dirname(__FILE__))) . "/objects/class_services.php");

$con = new laundry_db();
$conn = $con->connect();

$nexmo_admin = new laundry_ld_nexmo();
$nexmo_client = new laundry_ld_nexmo();

$general = new laundry_general();
$general->conn = $conn;

$settings = new laundry_setting();
$settings->conn = $conn;

$bookings = new laundry_booking();
$bookings->conn = $conn;

/* ADDED START*/
$objdashboard = new laundry_dashboard();
$objdashboard->conn = $conn;

$general = new laundry_general();
$general->conn = $conn;

$staff_commision = new laundry_staff_commision();
$staff_commision->conn = $conn;

$objadminprofile = new laundry_adminprofile();
$objadminprofile->conn = $conn;

$emailtemplate = new laundry_email_template();
$emailtemplate->conn = $conn;
/* ADDED END*/

$objadmin = new laundry_adminprofile();
$objadmin->conn = $conn;

$objdayweek_avail = new laundry_dayweek_avail();
$objdayweek_avail->conn = $conn;

$obj_offtime = new laundry_offtimes();
$obj_offtime->conn = $conn;

$objoffbreaks = new laundry_offbreaks();
$objoffbreaks->conn = $conn;

$offday = new laundry_provider_off_day();
$offday->conn = $conn;

$objpayment = new laundry_payments();
$objpayment->conn = $conn;

$objrating_review = new laundry_rating_review();
$objrating_review->conn = $conn;

$objservices = new laundry_services();
$objservices->conn = $conn;

$time_int = $objdayweek_avail->getinterval();
$time_interval = $time_int[2];

$getdateformat = $settings->get_option('ld_date_picker_date_format');
$time_format = $settings->get_option('ld_time_format');
$timess = "";
if ($time_format == "24") {
	$timess = "H:i";
} else {
	$timess = "h:i A";
}
/* ADDED START */
$symbol_position = $settings->get_option('ld_currency_symbol_position');
$decimal = $settings->get_option('ld_price_format_decimal_places');
$getcurrency_symbol_position = $settings->get_option('ld_currency_symbol_position');
$getdateformate = $settings->get_option('ld_date_picker_date_format');

$gettimeformat = $settings->get_option('ld_time_format');

$get_admin_name_result = $objadminprofile->readone_adminname();
$get_admin_name = $get_admin_name_result[3];
if ($get_admin_name == "") {
	$get_admin_name = "Admin";
}
$admin_email = $settings->get_option('ld_admin_optional_email');
if ($settings->get_option('ld_company_logo') != null && $settings->get_option('ld_company_logo') != "") {
	$business_logo = SITE_URL . 'assets/images/services/' . $settings->get_option('ld_company_logo');
	$business_logo_alt = $settings->get_option('ld_company_name');
} else {
	$business_logo = '';
	$business_logo_alt = $settings->get_option('ld_company_name');
}
$company_city = $settings->get_option('ld_company_city');
$company_state = $settings->get_option('ld_company_state');
$company_zip = $settings->get_option('ld_company_zip_code');
$company_country = $settings->get_option('ld_company_country');
$company_phone = strlen($settings->get_option('ld_company_phone')) < 6 ? "" : $settings->get_option('ld_company_phone');
$company_email = $settings->get_option('ld_company_email');
$company_address = $settings->get_option('ld_company_address');
/************ END ************/


if ($settings->get_option('ld_smtp_authetication') == 'true') {
	$mail_SMTPAuth = '1';
	if ($settings->get_option('ld_smtp_hostname') == "smtp.gmail.com") {
		$mail_SMTPAuth = 'Yes';
	}
} else {
	$mail_SMTPAuth = '0';
	if ($settings->get_option('ld_smtp_hostname') == "smtp.gmail.com") {
		$mail_SMTPAuth = 'No';
	}
}

$mail = new laundry_phpmailer();
$mail->Host = $settings->get_option('ld_smtp_hostname');
$mail->Username = $settings->get_option('ld_smtp_username');
$mail->Password = $settings->get_option('ld_smtp_password');
$mail->Port = $settings->get_option('ld_smtp_port');
$mail->SMTPSecure = $settings->get_option('ld_smtp_encryption');
$mail->SMTPAuth = $mail_SMTPAuth;
$mail->CharSet = "UTF-8";


/*NEXMO SMS GATEWAY VARIABLES*/

$nexmo_admin->ld_nexmo_api_key = $settings->get_option('ld_nexmo_api_key');
$nexmo_admin->ld_nexmo_api_secret = $settings->get_option('ld_nexmo_api_secret');
$nexmo_admin->ld_nexmo_from = $settings->get_option('ld_nexmo_from');

$nexmo_client->ld_nexmo_api_key = $settings->get_option('ld_nexmo_api_key');
$nexmo_client->ld_nexmo_api_secret = $settings->get_option('ld_nexmo_api_secret');
$nexmo_client->ld_nexmo_from = $settings->get_option('ld_nexmo_from');

/*SMS GATEWAY VARIABLES*/
$plivo_sender_number = $settings->get_option('ld_sms_plivo_sender_number');
$twilio_sender_number = $settings->get_option('ld_sms_twilio_sender_number');

/* textlocal gateway variables */
$textlocal_username = $settings->get_option('ld_sms_textlocal_account_username');
$textlocal_hash_id = $settings->get_option('ld_sms_textlocal_account_hash_id');


$lang = $settings->get_option("ld_language");
$label_language_values = array();
$language_label_arr = $settings->get_all_labelsbyid($lang);

if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "") {
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

	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);

	$label_language_arr = array_merge($label_decode_front_unserial, $label_decode_admin_unserial, $label_decode_error_unserial, $label_decode_extra_unserial);

	foreach ($label_language_arr as $key => $value) {
		$label_language_values[$key] = urldecode($value);
	}
} else {
	$default_language_arr = $settings->get_all_labelsbyid("en");

	$label_decode_front = base64_decode($default_language_arr[1]);
	$label_decode_admin = base64_decode($default_language_arr[3]);
	$label_decode_error = base64_decode($default_language_arr[4]);
	$label_decode_extra = base64_decode($default_language_arr[5]);


	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);

	$label_language_arr = array_merge($label_decode_front_unserial, $label_decode_admin_unserial, $label_decode_error_unserial, $label_decode_extra_unserial);

	foreach ($label_language_arr as $key => $value) {
		$label_language_values[$key] = urldecode($value);
	}
}

include(dirname(dirname(dirname(__FILE__))) . '/assets/lib/date_translate_array.php');

if (isset($_POST['staff_email'])) {
	$objadmin->email = trim(strip_tags(mysqli_real_escape_string($conn, filter_var($_POST['staff_email']))));
	$check_staff_email_existing = $objadmin->check_staff_email_existing();
	if ($check_staff_email_existing > 0) {
		echo filter_var('false');
	} else {
		echo filter_var("true");
	}
}
if (isset($_POST['fullemail'])) {
	if ($_SESSION['ld_useremail'] != trim(strip_tags(mysqli_real_escape_string($conn, filter_var($_POST['fullemail']))))) {
		$objadmin->email = trim(strip_tags(mysqli_real_escape_string($conn, filter_var($_POST['fullemail']))));
		$check_staff_email_existing = $objadmin->check_staff_email_existing();
		if ($check_staff_email_existing > 0) {
			echo filter_var('false');
		} else {
			echo filter_var("true");
		}
	} else {
		echo filter_var("true");
	}
}
if (isset($_POST['u_member_email'])) {
	$objadmin->email = trim(strip_tags(mysqli_real_escape_string($conn, filter_var($_POST['u_member_email']))));
	$check_staff_email_existing = $objadmin->check_staff_email_existing();
	if ($check_staff_email_existing > 0) {
		echo filter_var('false');
	} else {
		echo filter_var("true");
	}
} else if (isset($_POST['staff_add'])) {
	$objadmin->email = filter_var($_POST['email']);
	$objadmin->fullname = ucwords(filter_var($_POST['name']));
	$objadmin->pass = filter_var($_POST['pass']);
	$objadmin->role = filter_var($_POST['role']);
	$staff_register = $objadmin->add_staff();
	if ($staff_register) {
		$values = "weekly";
		$staff_id = $staff_register;
		$objdayweek_avail->set_schedule_type($values, $staff_id);		
	}
} else if (isset($_POST['staff_update'])) {
	$objadmin->id = filter_var($_POST['id']);
	$objadmin->fullname = filter_var($_POST['name']);
	$objadmin->email = filter_var($_POST['email']);
	$objadmin->description = filter_var($_POST['desc']);
	$objadmin->phone = filter_var($_POST['phone']);
	$objadmin->address = filter_var($_POST['address']);
	$objadmin->enable_booking = filter_var($_POST['staff_booking']);
	$objadmin->city = filter_var($_POST['city']);
	$objadmin->state = filter_var($_POST['state']);
	$objadmin->zip = filter_var($_POST['zip']);
	$objadmin->country = filter_var($_POST['country']);
	$objadmin->image = filter_var($_POST['staff_image']);
	if ($_POST['ld_service_staff'] != '') {
		$new_service = implode(",", $_POST['ld_service_staff']);
	} else {
		$new_service = $_POST['ld_service_staff'];
	}


	$objadmin->ld_service_staff = $new_service;
	$objadmin->update_staff_details();
	/* print_r($objadmin);
	die; */
} else if (isset($_POST['staff_detail'])) {
	$objadmin->id = filter_var($_POST['staff_id']);
	$staff_id = filter_var($_POST['staff_id']);
	$staff_read = $objadmin->readone();
?>

	<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/star_rating.min.css" type="text/css" media="all">
	<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/star_rating_min.js" type="text/javascript"></script>
	<style>
		.rating-md {
			font-size: 2em !important;
		}
	</style>
	<script>
		jQuery(function() {
			jQuery('.selectpicker').selectpicker({
				container: 'body'
			});

			if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
				jQuery('.selectpicker').selectpicker('mobile');
			}

			jQuery("#ratings_staff_display").rating('refresh', {
				disabled: true,
				showClear: false
			});
		});
	</script>
	<div class="ld-staff-details tab-content col-md-9 col-sm-8 col-lg-9 col-xs-12">

		<div class="ld-staff-top-header">
			<span class="ld-staff-member-name pull-left"><?php echo filter_var($staff_read['fullname']); ?></span>

			<button id="ld-delete-staff-member" class="pull-right btn btn-circle btn-danger" rel="popover" data-placement='left' title="<?php echo filter_var($label_language_values['delete_member']); ?>"> <i class="fa fa-trash"></i></button>


			<div id="popover-delete-member" style="display: none;">
				<div class="arrow"></div>
				<table class="form-horizontal" cellspacing="0">
					<tbody>
						<tr>
							<td>
								<button id="" data-id="<?php echo filter_var($staff_id); ?>" value="Delete" class="staff_delete btn btn-danger" type="submit"><?php echo filter_var($label_language_values['yes']); ?></button>
								<button id="ld-close-popover-delete-staff" class="btn btn-default" href="javascript:void(0)"><?php echo filter_var($label_language_values['cancel']); ?></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
		<hr id="hr" />
		<ul class="nav nav-tabs nav-justified ld-staff-right-menu">
			<li class="active"><a href="#member-details" data-toggle="tab"><?php echo filter_var($label_language_values['staff_details']); ?></a></li>
			<li><a href="#member-service-details" data-toggle="tab"><?php echo filter_var($label_language_values['service_details']); ?></a></li>
			<li><a href="#member-availability-details" data-toggle="tab">Staff Availability</a></li>
		</ul>
		<div class="tab-pane active">
			<div class="container-fluid tab-content ld-staff-right-details">
				<div class="tab-pane col-lg-12 col-md-12 col-sm-12 col-xs-12 active" id="member-details">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<div class="ld-clean-service-image-uploader">
							<?php
							if ($staff_read['image'] == '') {
								$imagepath = SITE_URL . "assets/images/user.png";
							} else {
								$imagepath = SITE_URL . "assets/images/services/" . $staff_read['image'];
							}
							?>
							<img data-imagename="" id="pppp<?php echo filter_var($staff_read['id']); ?>staffimage" src="<?php echo filter_var($imagepath); ?>" class="ld-clean-staff-image br-100" height="100" width="100">
							<input data-us="pppp<?php echo filter_var($staff_read['id']); ?>" class="hide ld-upload-images" type="file" name="" id="ld-upload-imagepppp<?php echo filter_var($staff_read['id']); ?>" data-id="<?php echo filter_var($staff_read['id']); ?>" />
							<?php
							if ($staff_read['image'] == '') {
							?>
								<label for="ld-upload-imagepppp<?php echo filter_var($staff_read['id']); ?>" class="ld-clean-staff-img-icon-label old_cam_ser<?php echo filter_var($staff_read['id']); ?>">
									<i class="ld-camera-icon-common br-100 fa fa-camera" id="pcls<?php echo filter_var($staff_read['id']); ?>camera"></i>
									<i class="pull-left fa fa-plus-circle fa-2x" id="ctsc<?php echo filter_var($staff_read['id']); ?>plus"></i>
								</label>
							<?php
							}
							?>

							<label for="ld-upload-imagepppp<?php echo filter_var($staff_read['id']); ?>" class="ld-clean-staff-img-icon-label new_cam_ser ser_cam_btn<?php echo filter_var($staff_read['id']); ?>" id="ld-upload-imagepppp<?php echo filter_var($staff_read['id']); ?>" style="display:none;">
								<i class="ld-camera-icon-common br-100 fa fa-camera" id="pppp<?php echo filter_var($staff_read['id']); ?>camera"></i>
								<i class="pull-left fa fa-plus-circle fa-2x" id="ctsc<?php echo filter_var($staff_read['id']); ?>plus"></i>
							</label>
							<?php
							if ($staff_read['image'] !== '') {
							?>
								<a id="ld-remove-staff-imagepppp<?php echo filter_var($staff_read['id']); ?>" data-pclsid="<?php echo filter_var($staff_read['id']); ?>" data-staff_id="<?php echo filter_var($staff_read['id']); ?>" class="delete_staff_image pull-left br-100 btn-danger bt-remove-staff-img btn-xs ser_new_del<?php echo filter_var($staff_read['id']); ?>" rel="popover" data-placement='left' title="<?php echo filter_var($label_language_values['remove_image']); ?>"> <i class="fa fa-trash" title="<?php echo filter_var($label_language_values['remove_service_image']); ?>"></i></a>
							<?php
							}
							?>
							<label><b class="error-service error_image" style="color:red;"></b></label>
							<div id="popover-ld-remove-staff-imagepppp<?php echo filter_var($staff_read['id']); ?>" style="display: none;">
								<div class="arrow"></div>
								<table class="form-horizontal" cellspacing="0">
									<tbody>
										<tr>
											<td>
												<a href="javascript:void(0)" id="staff_del_images" value="Delete" data-staff_id="<?php echo filter_var($staff_read['id']); ?>" class="btn btn-danger btn-sm" type="submit"><?php echo filter_var($label_language_values['yes']); ?></a>
												<a href="javascript:void(0)" id="ld-close-popover-staff-image" class="btn btn-default btn-sm" href="javascript:void(0)"><?php echo filter_var($label_language_values['cancel']); ?></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div id="ld-image-upload-popuppppp<?php echo filter_var($staff_read['id']); ?>" class="ld-image-upload-popup modal fade" tabindex="-1" role="dialog">
							<div class="vertical-alignment-helper">
								<div class="modal-dialog modal-md vertical-align-center">
									<div class="modal-content">
										<div class="modal-header">
											<div class="col-md-12 col-xs-12">
												<a data-staff_id="<?php echo filter_var($staff_read['id']); ?>" data-us="pppp<?php echo filter_var($staff_read['id']); ?>" class="btn btn-success ld_upload_img_staff" data-imageinputid="ld-upload-imagepppp<?php echo filter_var($staff_read['id']); ?>" data-id="<?php echo filter_var($staff_read['id']); ?>"><?php echo filter_var($label_language_values['crop_and_save']); ?></a>
												<button type="button" class="btn btn-default hidemodal" data-dismiss="modal" aria-hidden="true"><?php echo filter_var($label_language_values['cancel']); ?></button>
											</div>
										</div>
										<div class="modal-body">
											<img id="ld-preview-imgpppp<?php echo filter_var($staff_read['id']); ?>" style="width: 100%;" />
										</div>
										<div class="modal-footer">
											<div class="col-md-12 np">
												<div class="col-md-12 np">
													<div class="col-md-4 col-xs-12">
														<label class="pull-left"><?php echo filter_var($label_language_values['file_size']); ?></label> <input type="text" class="form-control" id="ppppfilesize<?php echo filter_var($staff_read['id']); ?>" name="filesize" />
													</div>
													<div class="col-md-4 col-xs-12">
														<label class="pull-left">H</label> <input type="text" class="form-control" id="pppp<?php echo filter_var($staff_read['id']); ?>h" name="h" />
													</div>
													<div class="col-md-4 col-xs-12">
														<label class="pull-left">W</label> <input type="text" class="form-control" id="pppp<?php echo filter_var($staff_read['id']); ?>w" name="w" />
													</div>

													<input type="hidden" id="pppp<?php echo filter_var($staff_read['id']); ?>x1" name="x1" />
													<input type="hidden" id="pppp<?php echo filter_var($staff_read['id']); ?>y1" name="y1" />
													<input type="hidden" id="pppp<?php echo filter_var($staff_read['id']); ?>x2" name="x2" />
													<input type="hidden" id="pppp<?php echo filter_var($staff_read['id']); ?>y2" name="y2" />
													<input type="hidden" id="pppp<?php echo filter_var($staff_read['id']); ?>id" name="id" value="<?php echo filter_var($staff_read['id']); ?>" />
													<input id="ppppctimage<?php echo filter_var($staff_read['id']); ?>" type="hidden" name="ctimage" />
													<input type="hidden" id="recordid" value="<?php echo filter_var($staff_read['id']); ?>">
													<input type="hidden" id="pppp<?php echo filter_var($staff_read['id']); ?>ctimagename" class="ppppimg" name="ctimagename" value="<?php echo filter_var($staff_read['image']); ?>" />
													<input type="hidden" id="pppp<?php echo filter_var($staff_read['id']); ?>newname" value="staff_" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
						<form id="staff_update_details">
							<table class="ld-staff-common-table">

								<tbody>
									<tr>
										<td><label for="ld-member-name"><?php echo filter_var($label_language_values['name']); ?> </label></td>
										<td><input type="text" class="form-control" id="ld-member-name" value="<?php echo filter_var($staff_read['fullname']); ?>" name="u_member_name" /></td>
									</tr>
									<tr>
										<td><label for="ld-member-name"><?php echo filter_var($label_language_values['email']); ?></label></label></td>
										<td><input type="text" class="form-control" id="ld-member-email" value="<?php echo filter_var($staff_read['email']); ?>" name="u_member_email" /></td>
									</tr>

									<tr>
										<td><label for="ld-member-desc"><?php echo filter_var($label_language_values['description']); ?></label></label></td>
										<td><textarea class="form-control" id="ld-member-desc" name="ld-member-desc"><?php echo filter_var($staff_read['description']); ?></textarea></td>
									</tr>
									<tr>
										<td><label for="phone-number"><?php echo filter_var($label_language_values['phone']); ?> </label></td>
										<td><input type="tel" class="form-control" id="phone-number" name="phone-number" value="<?php echo filter_var($staff_read['phone']); ?>" /></td>
									</tr>

									<tr>
										<td><label for="address"><?php echo filter_var($label_language_values['address']); ?></label></td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control" name="ld-member-address" id="ld-member-address" placeholder="Member Street Address" value="<?php echo filter_var($staff_read['address']); ?>" />
											</div>
										</td>
									<tr>
										<td></td>
										<td>
											<div class="form-group fl w100">
												<div class="lda-col6 ld-w-50 mb-6">
													<label for="city"><?php echo filter_var($label_language_values['city']); ?></label>
													<input class="form-control value_city" id="ld-member-city" name="ld-member-city" value="<?php echo filter_var($staff_read['city']); ?>" type="text">
												</div>
												<div class="lda-col6 ld-w-50 mb-6 float-right">
													<label for="state"><?php echo filter_var($label_language_values['state']); ?></label>
													<input class="form-control value_state" id="ld-member-state" name="ld-member-state" type="text" value="<?php echo filter_var($staff_read['state']); ?>">
												</div>
											</div>
											<div class="form-group fl w100">
												<div class="lda-col6 ld-w-50 mb-6">
													<label for="zip"><?php echo filter_var($label_language_values['zip']); ?></label>
													<input class="form-control value_zip" id="ld-member-zip" name="ld-member-zip" type="text" value="<?php echo filter_var($staff_read['zip']); ?>">
												</div>
												<div class="lda-col6 ld-w-50 mb-6 float-right">
													<label for="country"><?php echo filter_var($label_language_values['country']); ?></label>
													<input class="form-control value_country" id="ld-member-country" name="ld-member-countrys" type="text" value="<?php echo filter_var($staff_read['country']); ?>">
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td><label for="enable-booking1"><?php echo filter_var($label_language_values['enable_booking']); ?></label></td>
										<td>
											<label for="enable-booking1">
												<input type="checkbox" id="enable-booking1" data-toggle="toggle" data-size="small" data-on="<?php echo filter_var($label_language_values['yes']); ?>" <?php if ($staff_read['enable_booking'] == "Y") {
																																																			echo filter_var("checked");
																																																		} ?> data-off="<?php echo filter_var($label_language_values['no']); ?>" data-onstyle="success" data-offstyle="danger" />
											</label>
										</td>
									</tr>
									<tr>
										<?php
										if ($settings->get_option('ld_staff_zipcode') == 'Y') {
											echo "";
										} else {
										?>

													<td><label><?php echo filter_var($label_language_values['services']);?></label></td>
													<td><div class="col-xs-8">
														<select class="selectpicker mb-10" id="ld_service_staff" multiple data-size="10" style="display: none;">
															<option value="" disabled><?php echo $label_language_values['choose_your_service']; ?></option>
															<?php
															$getservice = $objservices->getalldata();
															while ($arr = @mysqli_fetch_array($getservice)) {
																$get_service_assignid = explode(",", $staff_read[17]);
																if (in_array($arr[0], $get_service_assignid)) {
																	echo "<option selected='selected' value='" . $arr[0] . "'>" . $arr[1] . "</option>";
																} else {
																	echo "<option value='" . $arr[0] . "'>" . $arr[1] . "</option>";
																}
															}
															?>
														</select>
													</div>
												</div>
											</td>
										<?php } ?>
									</tr>
									<tr>
										<td></td>
										<td>
											<?php
											$objrating_review->staff_id = $staff_id;
											$rating_details = $objrating_review->readall_by_staff_id();
											$rating_count = 0;
											$divide_count = 0;
											if (mysqli_num_rows($rating_details) > 0) {
												while ($row_rating_details = mysqli_fetch_assoc($rating_details)) {
													$divide_count++;
													$rating_count += (float)$row_rating_details['rating'];
												}
											}
											$rating_point = 0;
											if ($divide_count != 0) {
												$rating_point = round(($rating_count / $divide_count), 1);
											}
											?>
											<input id="ratings_staff_display" name="ratings_staff_display" class="rating" data-min="0" data-max="5" data-step="0.1" value="<?php echo filter_var($rating_point); ?>" />
										</td>
									</tr>

									<tr>
										<td></td>
										<td><a id="update_staff_details" data-old_schedule_type="<?php echo filter_var($staff_read['schedule_type']); ?>" value="" name="" class="btn btn-success ld-btn-width mt-20" data-id="<?php echo filter_var($staff_read['id']); ?>" type="submit"><?php echo filter_var($label_language_values['save']); ?></a></td>
									</tr>
								</tbody>

							</table>
						</form>
					</div>
				</div>
				<div class="tab-pane member-service-details" id="member-service-details">
					<div class="panel panel-default">
						<div class="table-responsive">
							<table id="ld-staff-service-details-list" class="display responsive nowrap table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<th>#</th>
									<th><?php echo filter_var($label_language_values['client']); ?></th>
									<th><?php echo filter_var($label_language_values['staff_name']); ?></th>
									<th><?php echo filter_var($label_language_values['service_name']); ?></th>
									<th><?php echo filter_var($label_language_values['order_date']); ?></th>
									<th><?php echo filter_var($label_language_values['order_time']); ?></th>
									<th><?php echo filter_var($label_language_values['commission_total']); ?></th>
								</thead>
								<tbody>
									<?php
									$staff_service_details = $staff_commision->staff_service_details(filter_var($_POST['staff_id']));
									if (sizeof($staff_service_details) > 0) {
										foreach ($staff_service_details as $arr_staff) {
											$get_booking_nettotal = $staff_commision->get_booking_nettotal($_POST['staff_id'], $arr_staff['order_id']);
											$service_name = "";
											$service_ids = explode(",", $arr_staff['service_id']);
											$color = "";
											foreach ($service_ids as $id) {
												$result = $staff_commision->get_service_name($id);
												$service_name .= $result . ",";
											}
											$service_name = chop($service_name, ",");

									?>
											<tr>
												<td><?php echo filter_var($arr_staff['order_id']); ?></td>
												<td>
													<?php
													$p_client_name = $objpayment->getclientname($arr_staff['order_id']);
													echo $p_client_name_res = $p_client_name;

													?>
												</td>
												<td>
													<?php
													$objadminprofile->id = $arr_staff['staff_ids'];
													$s_client_name = $objadminprofile->readone();
													echo filter_var($s_client_name['fullname']);
													?>
												</td>
												<td><?php echo filter_var($service_name); ?></td>
												<td><?php echo str_replace($english_date_array, $selected_lang_label, date($getdateformat, strtotime($arr_staff['booking_pickup_date_time_start']))); ?></td>
												<td><?php echo str_replace($english_date_array, $selected_lang_label, date($timess, strtotime($arr_staff['booking_pickup_date_time_start']))); ?></td>
												<td><?php echo filter_var($general->ld_price_format($get_booking_nettotal, $symbol_position, $decimal)); ?></td>
											</tr>
									<?php
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="tab-pane member-availability-details" id="member-availability-details">

					<div class="panel panel-default">

						<ul class="nav nav-tabs nav-justified ld-staff-right-menu">
							<li class="active"><a href="#member-availabilty" class="availability" data-toggle="tab"><?php echo filter_var($label_language_values['availabilty']); ?></a></li>
							<li><a href="#member-addbreaks" data-toggle="tab"><?php echo filter_var($label_language_values['add_breaks']); ?></a></li>
							<li><a href="#member-offtime" data-toggle="tab" class="myoff_timeslink"><?php echo filter_var($label_language_values['off_time']); ?></a></li>
							<li><a href="#member-offdays" data-toggle="tab"><?php echo filter_var($label_language_values['off_days']); ?></a></li>
						</ul>
						<div class="tab-pane active">
							<div class="container-fluid tab-content ld-staff-right-details">
								<div class="tab-pane member-availabilty myloadedslots active" id="member-availabilty">
									<?php
									$option = $objdayweek_avail->get_schedule_type_according_provider($staff_id);
									$weeks = $objdayweek_avail->get_dataof_week();
									$weekname = array($label_language_values['first'], $label_language_values['second'], $label_language_values['third'], $label_language_values['fourth'], $label_language_values['fifth']);
									$weeknameid = array($label_language_values['first_week'], $label_language_values['second_week'], $label_language_values['third_week'], $label_language_values['fourth_week'], $label_language_values['fifth_week']);
									if ($option = isset($option[7]) ? $option[7] : 'monthly') {
										$minweek = 1;
										$maxweek = 5;
									} elseif ($option = isset($option[7]) ? $option[7] : 'weekly') {
										$minweek = 1;
										$maxweek = 1;
									} else {
										$minweek = 1;
										$maxweek = 1;
									}
									$time_interval = 30;
									?>
									<form id="" method="POST">
										<div class="panel panel-default">
											<div class="col-sm-3 col-md-3 col-lg-3 col-xs-12 ld-weeks-schedule-menu">
												<ul class="nav nav-pills nav-stacked">
													<?php
													if ($minweek == 1 && $maxweek == 5) {
														for ($i = $minweek; $i <= $maxweek; $i++) {
													?>
															<li class="<?php if ($i == 1) {
																			echo filter_var("active");
																		} ?>"><a href="#<?php echo filter_var($weeknameid[$i - 1]); ?>" data-toggle="tab"><?php echo filter_var($weeknameid[$i - 1]); ?> </a></li>
														<?php
														}
													} else {
														$i = 1; ?>
														<li class="<?php if ($i == 1) {
																		echo filter_var("active");
																	} ?>"><a href="#<?php echo filter_var($weeknameid[$i - 1]); ?>" data-toggle="tab"><?php echo filter_var($label_language_values['this_week']); ?></a></li>
													<?php
													}
													?>
												</ul>
											</div>
											<div class="col-sm-9 col-md-9 col-lg-9 col-xs-12">
												<hr id="vr" />
												<div class="tab-content">
													<span class="prove_schedule_type" style="visibility: hidden;"><?php echo filter_var($option[7]); ?></span>
													<?php
													for ($i = $minweek; $i <= $maxweek; $i++) {
													?>
														<div class="tab-pane <?php if ($i == 1) {
																					echo filter_var("active");
																				} ?>" id="<?php echo filter_var($weeknameid[$i - 1]); ?>">
															<div class="panel panel-default">
																<div class="panel-body">
																	<?php if ($minweek == 1 && $maxweek == 1) { ?>
																		<h4 class="ld-right-header"><?php echo filter_var($label_language_values['this_week_time_scheduling']); ?></h4>
																	<?php
																	} else {
																	?>
																		<h4 class="ld-right-header"><?php echo filter_var($weekname[$i - 1]); ?><?php echo " " . filter_var($label_language_values['week_time_scheduling']); ?></h4>
																	<?php
																	} ?>
																	<ul class="list-unstyled" id="ld-staff-timing">
																		<?php
																		for ($j = 1; $j <= 7; $j++) {
																			$objdayweek_avail->week_id = $i;
																			$objdayweek_avail->weekday_id = $j;
																			$getvalue = $objdayweek_avail->get_time_slots($staff_id);
																			$daystart_time = $getvalue = isset($getvalue[4]) ? $getvalue[4] : '';
																			$dayend_time = $getvalue = isset($getvalue[5]) ? $getvalue[5] : '';
																			$offdayst = $getvalue = isset($getvalue[6]) ? $getvalue[6] : '';
																		?>
																			<li class="active">
																				<span class="col-sm-3 col-md-3 col-lg-3 col-xs-12 ld-day-name"><?php echo filter_var($label_language_values[strtolower($objdayweek_avail->get_daynamebyid($j))]); ?></span>
																				<span class="col-sm-2 col-md-2 col-lg-2 col-xs-12">
																					<label class="lda-col2" for="ld-monFirst<?php echo filter_var($i); ?><?php echo filter_var($j); ?>_<?php echo filter_var($getvalue); ?>">
																						<?php if ($getvalue = isset($getvalue[6]) ? $getvalue[6] : 'Y' || $getvalue = isset($getvalue[6]) ? $getvalue[6] : '') {
																							echo filter_var($label_language_values['off']);
																						} else {
																							echo filter_var($label_language_values['o_n']);
																						} ?>
																					</label>
																				</span>
																				<span class="col-sm-7 col-md-7 col-lg-7 col-xs-12 ld-staff-time-schedule">
																					<div class="pull-right">
																						<?php
																						if ($time_format == 24) {
																							echo date("H:i", strtotime($getvalue = isset($getvalue[4]) ? $getvalue[4] : ''));
																						} else {
																							echo str_replace($english_date_array, $selected_lang_label, date("h:i A", strtotime($getvalue = isset($getvalue[4]) ? $getvalue[4] : '')));
																						}
																						?>
																						<span class="ld-staff-hours-to"> <?php echo filter_var($label_language_values['to']); ?> </span>
																						<?php
																						if ($time_format == 24) {
																							echo date("H:i", strtotime($getvalue = isset($getvalue[5]) ? $getvalue[5] : ''));
																						} else {
																							echo str_replace($english_date_array, $selected_lang_label, date("h:i A", strtotime($getvalue = isset($getvalue[5]) ? $getvalue[5] : '')));
																						}
																						?>
																					</div>
																				</span>
																			</li>
																		<?php
																		}
																		?>
																	</ul>
																</div>
															</div>
														</div>
													<?php
													}
													?>
												</div>
											</div>
										</div>

									</form>
								</div>
								<div class="tab-pane member-addbreaks" id="member-addbreaks">
									<div class="panel panel-default">
										<div class="panel-body">
											<?php
											$breaks_weekname = array($label_language_values['first'], $label_language_values['second'], $label_language_values['third'], $label_language_values['fourth'], $label_language_values['fifth']);
											$breaks_weeknameid = array($label_language_values['first_week'], $label_language_values['second_week'], $label_language_values['third_week'], $label_language_values['fourth_week'], $label_language_values['fifth_week']);
											if ($option = isset($option[7]) ? $option[7] : 'monthly') {
												$minweek = 1;
												$maxweek = 5;
											} elseif ($option = isset($option[7]) ? $option[7] : 'weekly') {
												$minweek = 1;
												$maxweek = 1;
											} else {
												$minweek = 1;
												$maxweek = 1;
											}
											?>

											<div class="col-sm-3 col-md-3 col-lg-3 col-xs-12 ld-weeks-breaks-menu">
												<ul class="nav nav-pills nav-stacked">
													<?php
													if ($minweek == 1 && $maxweek == 5) {
														for ($i = $minweek; $i <= $maxweek; $i++) {
													?>
															<li class="<?php if ($i == 1) {
																			echo filter_var("active");
																		} ?>"><a href="#<?php echo filter_var($breaks_weeknameid[$i - 1]) . "_br"; ?>" data-toggle="tab"><?php echo filter_var($breaks_weeknameid[$i - 1]); ?> </a></li>
														<?php
														}
													} else {
														$i = 1;
														?>
														<li class="<?php if ($i == 1) {
																		echo filter_var("active");
																	} ?>"><a href="#<?php echo filter_var($breaks_weeknameid[$i - 1]) . "_br"; ?>" data-toggle="tab"><?php echo filter_var($label_language_values['this_week']); ?></a></li>
													<?php
													}
													?>
												</ul>
											</div>
											<div class="col-sm-9 col-md-9 col-lg-9 col-xs-12 ld-weeks-breaks-details">
												<div class="tab-content">
													<?php
													$breaks_weekname = array($label_language_values['first'], $label_language_values['second'], $label_language_values['third'], $label_language_values['fourth'], $label_language_values['fifth']);
													$breaks_weeknameid = array($label_language_values['first_week'], $label_language_values['second_week'], $label_language_values['third_week'], $label_language_values['fourth_week'], $label_language_values['fifth_week']);
													?>
													<?php
													for ($i = $minweek; $i <= $maxweek; $i++) {
													?>
														<div class="tab-pane <?php if ($i == 1) {
																					echo filter_var("active");
																				} ?>" id="<?php echo filter_var($breaks_weeknameid[$i - 1]) . "_br"; ?>">
															<div class="panel panel-default">
																<div class="panel-body">
																	<?php if ($minweek == 1 && $maxweek == 1) { ?>
																		<h4 class="ld-right-header"><?php echo filter_var($label_language_values['this_week_breaks']); ?> </h4>
																	<?php
																	} else { ?>
																		<h4 class="ld-right-header"><?php echo filter_var($breaks_weekname[$i - 1]); ?><?php echo filter_var($label_language_values['week_breaks']); ?> </h4>
																	<?php
																	} ?>
																	<ul class="list-unstyled" id="ld-staff-breaks">
																		<?php
																		for ($j = 1; $j <= 7; $j++) {
																			$break_weekday = $j;
																			$objdayweek_avail->week_id = $i;
																			$objdayweek_avail->weekday_id = $j;
																			$getdatafrom_week_days = $objdayweek_avail->getdata_byweekid($staff_id);
																		?>
																			<li class="active">
																				<span class="col-sm-3 col-md-3 col-lg-3 col-xs-12 ld-day-name"><?php echo filter_var($label_language_values[strtolower($objdayweek_avail->get_daynamebyid($j))]); ?></span>
																				<?php
																				if ($getdatafrom_week_days = isset($getdatafrom_week_days[0]) ? $getdatafrom_week_days[0] : 'Y' || $getdatafrom_week_days = isset($getdatafrom_week_days[0]) ? $getdatafrom_week_days[0] : '') {
																				?>
																					<span class="col-sm-2 col-md-2 col-lg-2 col-xs-12">
																						<a class="btn btn-small btn-default ld-small-br-btn disabled"><?php echo filter_var($label_language_values['closed']); ?></a>
																					</span>
																				<?php
																				} else { ?>
																					<span class="col-sm-2 col-md-2 col-lg-2 col-xs-12">

																					</span>
																				<?php
																				}
																				?>
																				<span class="col-sm-7 col-md-7 col-lg-7 col-xs-12 ld-staff-breaks-schedule">
																					<ul class="list-unstyled" id="ld-add-break-ul<?php echo filter_var($i); ?>_<?php echo filter_var($j); ?>">
																						<?php
																						$objoffbreaks->week_id = $i;
																						$objoffbreaks->weekday_id = $j;
																						$jc = $objoffbreaks->getdataby_week_day_id($staff_id);
																						while ($rrr = mysqli_fetch_array($jc)) {
																						?>
																							<li>
																								<?php
																								if ($time_format == 24) {
																									echo date("H:i", strtotime($rrr['break_start']));
																								} else {
																									echo str_replace($english_date_array, $selected_lang_label, date("h:i A", strtotime($rrr['break_start'])));
																								}
																								?>
																								<span class="ld-staff-hours-to"> <?php echo filter_var($label_language_values['to']); ?> </span>
																								<?php
																								if ($time_format == 24) {
																									echo date("H:i", strtotime($rrr['break_end']));
																								} else {
																									echo str_replace($english_date_array, $selected_lang_label, date("h:i A", strtotime($rrr['break_end'])));
																								}
																								?>

																								<div id="popover-delete-breaks<?php echo filter_var($rrr['id']); ?>_<?php echo filter_var($i); ?>_<?php echo filter_var($j); ?>" style="display: none;">
																									<div class="arrow"></div>
																									<table class="form-horizontal" cellspacing="0">
																										<tbody>
																											<tr>
																												<td>
																													<button id="" value="Delete" data-break_id='<?php echo filter_var($rrr['id']); ?>' class="btn btn-danger mybtndelete_breaks" type="submit"><?php echo filter_var($label_language_values['yes']); ?></button>
																													<button id="ld-close-popover-delete-breaks" class="btn btn-default close_popup" href="javascript:void(0)"><?php echo filter_var($label_language_values['cancel']); ?></button>
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</div>
																							</li>
																						<?php
																						}
																						?>
																					</ul>
																			</li>
																		<?php
																		}
																		?>
																	</ul>
																</div>
															</div>
														</div>
													<?php
													}
													?>
												</div>

											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane member-offtime" id="member-offtime">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="ld-member-offtime-inner">
												<h3>Off times</h3>
											</div>
											<div class="ld-staff-member-offtime-list-main mytablefor_offtimes cb col-md-12 col-xs-12">
												<div class="table-responsive">
													<table id="ld-staff-member-offtime-list" class="ld-staff-member-offtime-lists table table-striped table-bordered dt-responsive nowrap myadded_offtimes" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>#</th>
																<th><?php echo filter_var($label_language_values['start_date']); ?></th>
																<th><?php echo filter_var($label_language_values['start_time']); ?></th>
																<th><?php echo filter_var($label_language_values['end_date']); ?></th>
																<th><?php echo filter_var($label_language_values['end_time']); ?></th>
															</tr>
														</thead>
														<tbody class="mytbodyfor_offtimes">
															<?php
															$res = $obj_offtime->get_all_offtimes($staff_id);
															$i = 1;
															while ($r = mysqli_fetch_array($res)) {
																$st = $r['start_date_time'];
																$stt = explode(" ", $st);
																$sdates = $stt[0];
																$stime = $stt[1];
																$et = $r['end_date_time'];
																$ett = explode(" ", $et);
																$edates = $ett[0];
																$etime = $ett[1];
															?>
																<tr id="myofftime_<?php echo filter_var($r['id']); ?>">
																	<td><?php echo filter_var($i++, FILTER_SANITIZE_NUMBER_INT); ?></td>
																	<td><?php echo str_replace($english_date_array, $selected_lang_label, date($getdateformat, strtotime($sdates))); ?></td>
																	<?php
																	if ($time_format == 12) {
																	?>
																		<td><?php echo str_replace($english_date_array, $selected_lang_label, date("h:i A", strtotime($stime))); ?></td>
																	<?php
																	} else {
																	?>
																		<td><?php echo date("H:i", strtotime($stime)); ?></td>
																	<?php
																	}
																	?>
																	<td><?php echo str_replace($english_date_array, $selected_lang_label, date($getdateformat, strtotime($edates))); ?></td>
																	<?php
																	if ($time_format == 12) {
																	?>
																		<td><?php echo str_replace($english_date_array, $selected_lang_label, date("h:i A", strtotime($etime))); ?></td>
																	<?php
																	} else {
																	?>
																		<td><?php echo date("H:i", strtotime($etime)); ?></td>
																	<?php
																	}
																	?>
																</tr>
															<?php
															}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane member-offdays" id="member-offdays">
									<div class="panel panel-default">
										<?php
										$offday->user_id = $staff_id;
										$displaydate = $offday->select_date();
										$arr_all_off_day = array();
										while ($readdate = mysqli_fetch_array($displaydate)) {
											$arr_all_off_day[] = $readdate['off_date'];
										}
										$year_arr = array(date('Y'), date('Y') + 1);
										$month_num = date('n');
										if (isset($_GET['y']) && in_array($_GET['y'], $year_arr)) {
											$year = $_GET['y'];
										} else {
											$year = date('Y');
										}
										$nextYear = date('Y') + 1;
										$date = date('d');
										$month = array(ucfirst(strtolower($label_language_values['january'])), ucfirst(strtolower($label_language_values['february'])), ucfirst(strtolower($label_language_values['march'])), ucfirst(strtolower($label_language_values['april'])), ucfirst(strtolower($label_language_values['may'])), ucfirst(strtolower($label_language_values['june'])), ucfirst(strtolower($label_language_values['july'])), ucfirst(strtolower($label_language_values['august'])), ucfirst(strtolower($label_language_values['september'])), ucfirst(strtolower($label_language_values['october'])), ucfirst(strtolower($label_language_values['november'])), ucfirst(strtolower($label_language_values['december'])));
										echo '<table class="offdaystable">';
										echo '<tr>';
										for ($reihe = 1; $reihe <= 12; $reihe++) { /* 4 */
											$this_month = ($reihe - 1) * 0 + $reihe; /*write 0 instead of 12*/
											$current_year = date('Y');
											$currnt_month = date('m');
											if (($currnt_month < $this_month) || ($currnt_month == $this_month)) {
												$year = $current_year;
											} else {
												$year = $current_year + 1;
											}
											$erster = date('w', mktime(0, 0, 0, $this_month, 1, $year));
											$insgesamt = date('t', mktime(0, 0, 0, $this_month, 1, $year));
											if ($erster == 0) $erster = 7;
											echo '<td class="ld-calendar-box col-lg-4 col-md-4 col-sm-6 col-xs-12 pull-left">';
											echo '<table align="center" class="table table-bordered table-striped monthtable">'; ?>
											<tbody class="ta-c">
												<div class="ld-schedule-month-name pull-right">
													<div class="pull-left">
														<div class="ld-custom-checkbox">
															<ul class="ld-checkbox-list">
																<li>
																	<label for="<?php echo filter_var($year . '-' . $this_month); ?>">
																		<?php echo filter_var($month[$reihe - 1] . " " . $year); ?>
																	</label>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</tbody>
										<?php
											echo '<tr><td><b>' . $label_language_values['mon'] . '</b></td><td><b>' . $label_language_values['tue'] . '</b></td>';
											echo '<td><b>' . $label_language_values['wed'] . '</b></td><td><b>' . $label_language_values['thu'] . '</b></td>';
											echo '<td><b>' . $label_language_values['fri'] . '</b></td><td class="sat"><b>' . $label_language_values['sat'] . '</b></td>';
											echo '<td class="sun"><b>' . $label_language_values['sun'] . '</b></td></tr>';
											echo '<tr class="dateline selmonth_' . $year . '-' . $this_month . '"><br>';
											$i = 1;
											while ($i < $erster) {
												echo filter_var('<td> </td>');
												$i++;
											}
											$i = 1;
											while ($i <= $insgesamt) {
												$rest = ($i + $erster - 1) % 7;
												$cal_cur_date = $year . "-" . sprintf('%02d', $this_month) . "-" . sprintf('%02d', $i);
												if (($i == $date) && ($this_month == $month_num)) {
													if (isset($arr_all_off_day) && in_array($cal_cur_date, $arr_all_off_day)) {
														echo '<td  id="' . $year . '-' . $this_month . '-' . $i . '" data-prov_id="' . $staff_id . '" class="selectedDate RR"  align=center >';
													} else {
														echo '<td  id="' . $year . '-' . $this_month . '-' . $i . '" data-prov_id="' . $staff_id . '"  class="date_single RR"  align=center>';
													}
												} else {
													if (isset($arr_all_off_day) && in_array($cal_cur_date, $arr_all_off_day)) {
														echo '<td  id="' . $year . '-' . $this_month . '-' . $i . '"  data-prov_id="' . $staff_id . '"  class="selectedDate RR highlight"  align=center>';
													} else {
														echo '<td  id="' . $year . '-' . $this_month . '-' . $i . '" data-prov_id="' . $staff_id . '" class="date_single RR"  align=center>';
													}
												}
												if (($i == $date) && ($this_month == $month_num)) {
													echo '<span style="color:#000;font-weight: bold;font-size: 15px;">' . $i . '</span>';
												} else if ($rest == 6) {
													echo '<span   style="color:#0000cc;">' . $i . '</span>';
												} else if ($rest == 0) {
													echo '<span  style="color:#cc0000;">' . $i . '</span>';
												} else {
													echo filter_var($i);
												}
												echo filter_var("</td>\n");
												if ($rest == 0) echo "</tr>\n<tr class='dateline selmonth_" . $year . "-" . $this_month . "'>\n";
												$i++;
											}
											echo '</tr>';
											echo '</tbody>';
											echo '</table>';
											echo '</td>';
										}
										echo '</tr>';

										echo '</table>';
										?>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>
<?php
} else if (isset($_POST['assign_staff_booking'])) {
	$staff_id = isset($_POST['staff_ids']) && is_array($_POST['staff_ids']) ? $_POST['staff_ids'] : [];
	$id = filter_var($_POST['order_id']);
	$final_staff = implode(",", $staff_id);
	$bookings->order_id = filter_var($_POST['order_id']);
	$ajjd = $bookings->save_staff_to_booking($final_staff);

	if (sizeof($staff_id) > 0) {
		/****************************************** EMAIL CODE START ************************************************/
		$orderdetail = $objdashboard->getclientorder($id);
		$clientdetail = $objdashboard->clientemailsender($id);

		$admin_company_name = $settings->get_option('ld_company_name');
		$setting_date_format = $settings->get_option('ld_date_picker_date_format');
		$setting_time_format = $settings->get_option('ld_time_format');
		$booking_date = date($setting_date_format, strtotime($clientdetail['booking_pickup_date_time_start']));
		if ($setting_time_format == 12) {
			$booking_time = str_replace($english_date_array, $selected_lang_label, date("h:i A", strtotime($clientdetail['booking_pickup_date_time_start'])));
		} else {
			$booking_time = date("H:i", strtotime($clientdetail['booking_pickup_date_time_start']));
		}

		$booking_delivery_date_start = str_replace($english_date_array, $selected_lang_label, date($setting_date_format, strtotime($clientdetail['booking_delivery_date_time_start'])));
		if ($setting_time_format == 12) {
			$booking_delivery_time_start = str_replace($english_date_array, $selected_lang_label, date("h:i A", strtotime($clientdetail['booking_delivery_date_time_start'])));
		} else {
			$booking_delivery_time_start = date("H:i", strtotime($clientdetail['booking_delivery_date_time_start']));
		}

		$company_name = $settings->get_option('ld_email_sender_name');
		$company_email = $settings->get_option('ld_email_sender_address');
		$service_name = $clientdetail['title'];
		if ($admin_email == "") {
			$admin_email = $clientdetail['email'];
		}

		$price = $general->ld_price_format($orderdetail[2], $symbol_position, $decimal);

		/* units */
		$units = $label_language_values['none'];
		$book_unit_detail = $bookings->get_booking_units_from_order($id);
		if ($book_unit_detail->num_rows > 0) {
			$units_array = array();
			while ($unit_row = mysqli_fetch_assoc($book_unit_detail)) {
				$units_array[] = $unit_row["unit_name"] . " - " . $unit_row["unit_qty"];
			}
			$units = implode(", ", $units_array);
		}


		/* if this is guest user than */
		if ($orderdetail[4] == 0) {
			$gc  = $objdashboard->getguestclient($orderdetail[4]);
			$temppp = unserialize(base64_decode($gc[5]));
			$temp = str_replace('\\', '', $temppp);

			$client_name = $gc[2];
			$client_email = $gc[3];
			$client_phone = $gc[4];
			$firstname = $client_name;
			$lastname = '';
			$booking_status = $orderdetail[6];
			$payment_status = $orderdetail[5];
			$client_address = $temp['address'];
			$client_notes = $temp['notes'];
			$client_status = $temp['contact_status'];
			$client_city = $temp['city'];
			$client_state = $temp['state'];
			$client_zip	= $temp['zip'];
		} else
		/*Registered user */ {
			$c  = $objdashboard->getguestclient($orderdetail[4]);
			$temppp = unserialize(base64_decode($c[5]));
			$temp = str_replace('\\', '', $temppp);
			$client_name = $c[2];
			$client_email = $c[3];
			$client_phone = $c[4];
			$firstname = $client_name;
			$lastname = '';
			$payment_status = $orderdetail[5];
			$client_address = $temp['address'];
			$client_notes = $temp['notes'];
			$client_status = $temp['contact_status'];
			$client_city = $temp['city'];
			$client_state = $temp['state'];
			$client_zip	= $temp['zip'];
		}
		foreach ($staff_id as $sid) {
			$staffdetails = $bookings->get_staff_detail_for_email($sid);
			$staff_name = $staffdetails['fullname'];
			$staff_email = $staffdetails['email'];
			$staff_phone = $staffdetails['phone'];

			$bookings->staff_id = $sid;
			$bookings->order_id = $id;
			$status_insert_id = $bookings->staff_status_insert();
			if ($settings->get_option('ld_show_delivery_date') == 'E') {
				$searcharray = array('{{service_name}}', '{{booking_date}}', '{{business_logo}}', '{{business_logo_alt}}', '{{client_name}}', '{{units}}', '{{client_email}}', '{{phone}}', '{{payment_method}}', '{{notes}}', '{{contact_status}}', '{{address}}', '{{price}}', '{{admin_name}}', '{{firstname}}', '{{lastname}}', '{{app_remain_time}}', '{{reject_status}}', '{{company_name}}', '{{booking_time}}', '{{client_city}}', '{{client_state}}', '{{client_zip}}', '{{company_city}}', '{{company_state}}', '{{company_zip}}', '{{company_country}}', '{{company_phone}}', '{{company_email}}', '{{company_address}}', '{{admin_name}}', '{{staff_name}}', '{{staff_email}}', '{{booking_delivery_date}}', '{{booking_delivery_time}}');

				$replacearray = array($service_name, $booking_date, $business_logo, $business_logo_alt, $client_name, $units, $client_email, $client_phone, $payment_status, $client_notes, $client_status, $client_address, $price, $get_admin_name, $firstname, $lastname, '', '', $admin_company_name, $booking_time, $client_city, $client_state, $client_zip, $company_city, $company_state, $company_zip, $company_country, $company_phone, $company_email, $company_address, $get_admin_name, $staff_name, $staff_email, $booking_delivery_date_start, $booking_delivery_time_start);
			} else {
				$searcharray = array('{{service_name}}', '{{booking_date}}', '{{business_logo}}', '{{business_logo_alt}}', '{{client_name}}', '{{units}}', '{{client_email}}', '{{phone}}', '{{payment_method}}', '{{notes}}', '{{contact_status}}', '{{address}}', '{{price}}', '{{admin_name}}', '{{firstname}}', '{{lastname}}', '{{app_remain_time}}', '{{reject_status}}', '{{company_name}}', '{{booking_time}}', '{{client_city}}', '{{client_state}}', '{{client_zip}}', '{{company_city}}', '{{company_state}}', '{{company_zip}}', '{{company_country}}', '{{company_phone}}', '{{company_email}}', '{{company_address}}', '{{admin_name}}', '{{staff_name}}', '{{staff_email}}');

				$replacearray = array($service_name, $booking_date, $business_logo, $business_logo_alt, $client_name, $units, $client_email, $client_phone, $payment_status, $client_notes, $client_status, $client_address, $price, $get_admin_name, $firstname, $lastname, '', '', $admin_company_name, $booking_time, $client_city, $client_state, $client_zip, $company_city, $company_state, $company_zip, $company_country, $company_phone, $company_email, $company_address, $get_admin_name, $staff_name, $staff_email);
			}

			$emailtemplate->email_subject = "New Appointment Assigned";
			$emailtemplate->user_type = "S";
			$staffemailtemplate = $emailtemplate->readone_client_email_template_body();

			if ($staffemailtemplate[2] != '') {
				$stafftemplate = base64_decode($staffemailtemplate[2]);
			} else {
				$stafftemplate = base64_decode($staffemailtemplate[3]);
			}
			$subject = $staffemailtemplate[1];

			$new_div = "<div style='width: 39%;float: left;margin-left: 270px;background-color: #cb2121;color: #fff;text-align: center;'>
						<label style='font-size: 15px;color: #999999;padding-right: 5px;min-width: 95px;white-space: nowrap;float: left;line-height: 25px;'> </label>
						<span style='font-size: 15px;font-weight: 400;color: #fff;line-height: 25px;float: left;width: 76%;word-wrap: break-word;max-height: 70px;overflow: auto;'>Appointment :<strong><a  style='color: #fff' href='" . AJAX_URL . "accept_appointment_staff.php?id=" . $status_insert_id . "&status=A' target='_blank'   id='accept_appointment' >Accept</a></strong> Or <strong><a style='color: #fff' href= '" . AJAX_URL . "accept_appointment_staff.php?id=" . $status_insert_id . "&status=D' id='decline_appointment' >Decline</a></strong></span></div>";

			if ($settings->get_option('ld_staff_email_notification_status') == 'Y' && $staffemailtemplate[4] == 'E') {
				$client_email_body = str_replace($searcharray, $replacearray, $stafftemplate) . $new_div;
				if ($settings->get_option('ld_smtp_hostname') != '' && $settings->get_option('ld_email_sender_name') != '' && $settings->get_option('ld_email_sender_address') != '' && $settings->get_option('ld_smtp_username') != '' && $settings->get_option('ld_smtp_password') != '' && $settings->get_option('ld_smtp_port') != '') {
					$mail->IsSMTP();
				} else {
					$mail->IsMail();
				}
				$mail->SMTPDebug  = 0;
				$mail->IsHTML(true);
				$mail->From = $company_email;
				$mail->FromName = $company_name;
				$mail->Sender = $company_email;
				$mail->AddAddress($staff_email, $staff_name);
				$mail->Subject = $subject;
				$mail->Body = $client_email_body;
				$mail->send();
				$mail->ClearAllRecipients();
			}

			/* TEXTLOCAL CODE */
			if ($settings->get_option('ld_sms_textlocal_status') == "Y") {
				if ($settings->get_option('ld_sms_textlocal_send_sms_to_staff_status') == "Y") {
					if (isset($staff_phone) && !empty($staff_phone)) {
						$template = $objdashboard->gettemplate_sms("RS", 'S');
						$phone = $staff_phone;
						if ($template[4] == "E") {
							if ($template[2] == "") {
								$message = base64_decode($template[3]);
							} else {
								$message = base64_decode($template[2]);
							}
						}
						$message = str_replace($searcharray, $replacearray, $message);
						$data = "username=" . $textlocal_username . "&hash=" . $textlocal_hash_id . "&message=" . $message . "&numbers=" . $phone . "&test=0";
						$ch = curl_init('http://api.textlocal.in/send/?');
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$result = curl_exec($ch);
						curl_close($ch);
					}
				}
			}
			/*PLIVO CODE*/
			if ($settings->get_option('ld_sms_plivo_status') == "Y") {
				if ($settings->get_option('ld_sms_plivo_send_sms_to_staff_status') == "Y") {
					if (isset($staff_phone) && !empty($staff_phone)) {
						$auth_id = $settings->get_option('ld_sms_plivo_account_SID');
						$auth_token = $settings->get_option('ld_sms_plivo_auth_token');
						$p_client = new Plivo\RestAPI($auth_id, $auth_token, '', '');

						$template = $objdashboard->gettemplate_sms("RS", 'S');
						$phone = $staff_phone;
						if ($template[4] == "E") {
							if ($template[2] == "") {
								$message = base64_decode($template[3]);
							} else {
								$message = base64_decode($template[2]);
							}
							$client_sms_body = str_replace($searcharray, $replacearray, $message);
							/* MESSAGE SENDING CODE THROUGH PLIVO */
							$params = array(
								'src' => $settings->get_option('ld_sms_plivo_sender_number'),
								'dst' => $phone,
								'text' => $client_sms_body,
								'method' => 'POST'
							);
							$response = $p_client->send_message($params);
							/* MESSAGE SENDING CODE ENDED HERE*/
						}
					}
				}
			}
			if ($settings->get_option('ld_sms_twilio_status') == "Y") {
				if ($settings->get_option('ld_sms_twilio_send_sms_to_staff_status') == "Y") {
					if (isset($staff_phone) && !empty($staff_phone)) {
						$AccountSid = $settings->get_option('ld_sms_twilio_account_SID');
						$AuthToken =  $settings->get_option('ld_sms_twilio_auth_token');
						$twilliosms_client = new Services_Twilio($AccountSid, $AuthToken);

						$template = $objdashboard->gettemplate_sms("RS", 'S');
						$phone = $staff_phone;
						if ($template[4] == "E") {
							if ($template[2] == "") {
								$message = base64_decode($template[3]);
							} else {
								$message = base64_decode($template[2]);
							}
							$client_sms_body = str_replace($searcharray, $replacearray, $message);
							/*TWILIO CODE*/
							$message = $twilliosms_client->account->messages->create(array(
								"From" => $twilio_sender_number,
								"To" => $phone,
								"Body" => $client_sms_body
							));
						}
					}
				}
			}
			if ($settings->get_option('ld_nexmo_status') == "Y") {
				if ($settings->get_option('ld_sms_nexmo_send_sms_to_staff_status') == "Y") {
					if (isset($staff_phone) && !empty($staff_phone)) {
						$template = $objdashboard->gettemplate_sms("RS", 'S');
						$phone = $staff_phone;
						if ($template[4] == "E") {
							if ($template[2] == "") {
								$message = base64_decode($template[3]);
							} else {
								$message = base64_decode($template[2]);
							}
							$ld_nexmo_text = str_replace($searcharray, $replacearray, $message);
							$res = $nexmo_client->send_nexmo_sms($phone, $ld_nexmo_text);
						}
					}
				}
			}
		}
		/****************************************** EMAIL CODE END ************************************************/
	}
} else if (isset($_POST['delete_staff'])) {
	$staff_id = filter_var($_POST['staff_id']);
	$objadmin->id = $staff_id;
	$objadmin->delete_staff();
}

if (isset($_POST['action']) && filter_var($_POST['action']) == 'delete_staff_image') {
	$objadmin->id = filter_var($_POST['staff_id']);
	$result = $objadmin->update_pic();
}

if (isset($_POST['get_staff_bookingandpayment_by_dateser'])) {
	$start = filter_var($_POST['startdate']);
	$end = filter_var($_POST['enddate']);
	$sid = filter_var($_POST['service_id']);
	if ($sid == 'all') {
		$all_bookings = $staff_commision->get_staff_bookingandpayment_by_date($start, $end);
	} else {
		$all_bookings = $staff_commision->get_staff_bookingandpayment_by_dateser($start, $end, $sid);
	}
?>
	<table id="payments-staff-bookingandpymnt-details-ajax" class="display responsive nowrap table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo filter_var($label_language_values['service']); ?></th>
				<th><?php echo filter_var($label_language_values['app_date']); ?></th>
				<th><?php echo filter_var($label_language_values['customer']); ?></th>
				<th><?php echo filter_var($label_language_values['status']); ?></th>
				<th><?php echo filter_var($label_language_values['staff_name']); ?></th>
				<th><?php echo filter_var($label_language_values['net_total']); ?></th>
				<th><?php echo filter_var($label_language_values['commission_total']); ?></th>
				<th><?php echo filter_var($label_language_values['action']); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (mysqli_num_rows($all_bookings) > 0) {
				while ($all = mysqli_fetch_array($all_bookings)) {
					$service_name = $staff_commision->get_service_name($all['service_id']);
					$client_name = $staff_commision->get_client_name($all['client_id']);
					$staff_name = $staff_commision->get_staff_name($all['staff_ids']);
					$net_total = $staff_commision->get_net_total($all['order_id']);
					$get_booking_nettotal = $staff_commision->get_booking_nettotal($all['staff_ids'], $all['order_id']);
					if ($all['booking_status'] == 'A') {
						$status = 'Active';
					} else if ($all['booking_status'] == 'C') {
						$status = 'Confirm';
					} else if ($all['booking_status'] == 'R') {
						$status = 'Rejected';
					} else if ($all['booking_status'] == 'CC') {
						$status = 'Cancelled By Client';
					} else if ($all['booking_status'] == 'CS') {
						$status = 'Cancelled By Staff';
					} else if ($all['booking_status'] == 'CO') {
						$status = 'Completed';
					} else if ($all['booking_status'] == 'MN') {
						$status = 'Mark As No Show';
					} else if ($all['booking_status'] == 'RS') {
						$status = 'Rescheduled';
					}
			?>
					<tr>
						<td><?php echo filter_var($all['order_id']); ?></td>
						<td><?php echo filter_var($service_name); ?></td>
						<td><?php echo str_replace($english_date_array, $selected_lang_label, date($getdateformat, strtotime($all['booking_pickup_date_time_start']))); ?></td>
						<td><?php echo filter_var($client_name); ?></td>
						<td><?php echo filter_var($status); ?></td>
						<td><?php echo rtrim($staff_name, ", "); ?></td>
						<td><?php echo filter_var($general->ld_price_format($net_total, $symbol_position, $decimal)); ?></td>
						<td><?php echo filter_var($general->ld_price_format($get_booking_nettotal, $symbol_position, $decimal)); ?></td>
						<td><a href="#add-staff-payment" role="button" class="btn btn-success show_staff_payment_details" data-toggle="modal" data-order_id="<?php echo filter_var($all['order_id']); ?>" data-staff_ids="<?php echo filter_var($all['staff_ids']); ?>"><?php echo filter_var($label_language_values['staff_payment']); ?></a></td>
					</tr>
			<?php
				}
			}
			?>
		</tbody>
	</table>
<?php
}

if (isset($_POST['get_payment_staff_by_date'])) {
	$start = filter_var($_POST['startdate']);
	$end = filter_var($_POST['enddate']);
	$all_bookings = $staff_commision->get_payment_staff_by_date($start, $end);
?>
	<table id="payments-staffp-details-ajax" class="display responsive nowrap table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo filter_var($label_language_values['client']); ?></th>
				<th><?php echo filter_var($label_language_values['staff_name']); ?></th>
				<th><?php echo filter_var($label_language_values['payment_method']); ?></th>
				<th><?php echo filter_var($label_language_values['payment_date']); ?></th>
				<th><?php echo filter_var($label_language_values['amount']); ?></th>
				<th><?php echo filter_var($label_language_values['advance_paid']); ?></th>
				<th><?php echo filter_var($label_language_values['net_total']); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (mysqli_num_rows($all_bookings) > 0) {
				$i = 1;
				while ($row = mysqli_fetch_array($all_bookings)) {
			?>
					<tr>
						<td><?php echo filter_var($i); ?></td>
						<td>
							<?php
							$p_client_name = $objpayment->getclientname($row['order_id']);
							$p_client_name_res = str_split($p_client_name, 5);
							echo str_replace(",", " ", implode(",", $p_client_name_res));
							?>
						</td>
						<td>
							<?php
							$objadminprofile->id = $row['staff_id'];
							$s_client_name = $objadminprofile->readone();
							echo filter_var($s_client_name['fullname']);
							?>
						</td>
						<td><?php echo filter_var($row['payment_method']); ?></td>
						<td><?php echo str_replace($english_date_array, $selected_lang_label, date($getdateformat, strtotime($row['payment_date']))); ?></td>
						<td><?php echo filter_var($general->ld_price_format($row['amt_payable'], $symbol_position, $decimal)); ?></td>
						<td><?php echo filter_var($general->ld_price_format($row['advance_paid'], $symbol_position, $decimal)); ?></td>
						<td><?php echo filter_var($general->ld_price_format($row['net_total'], $symbol_position, $decimal)); ?></td>
					</tr>
			<?php
					$i++;
				}
			}
			?>
		</tbody>
	</table>
<?php
}
if (isset($_POST['action']) && filter_var($_POST['action']) == 'payment_status_of_staff') {
	$objpayment->order_id = filter_var($_POST['order_id']);
	$objpayment->payment_status = "Completed";
	$result = $objpayment->update_payment_status_of_staff();
}
?>