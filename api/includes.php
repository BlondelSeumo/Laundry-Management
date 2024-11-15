<?php header_remove('Access-Control-Allow-Origin');
error_reporting(E_ALL);
ini_set('display_errors', 1);
	header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$object = file_get_contents('php://input');
$_POST = json_decode($object, true);

function setResponse($response)
{ 
   
    header("Content-type: application/json");

    echo json_encode($response, JSON_PRETTY_PRINT);
    die;
}
function verifyRequiredParams($required_fields)
{
    $error = false;
    $error_fields = "";
    $request_params = $_POST;
    foreach ($required_fields as $field)
    {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0)
        {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
    if ($error)
    {
        $message = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        $invalid = ['status' => "false", "statuscode" => 404, 'response' => $message];
        setResponse($invalid);
    }
}
$filename = dirname(dirname(__FILE__)) . '/config.php';
$file = file_exists($filename);
if ($file)
{
    if (!filesize($filename) > 0)
    {
			include($filename);
			if (!class_exists('laundry_myvariable')){
				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Invalid request"];
        setResponse($invalid);
			}
			include (dirname(dirname(__FILE__)) . "/objects/class_connection.php");
			$cvars = new laundry_myvariable();
			$host = trim($cvars->hostnames);
			$un = trim($cvars->username);
			$ps = trim($cvars->passwords);
			$db = trim($cvars->database);
			$con = new laundry_db();
			$conn = $con->connect();
			if (($conn->connect_errno == '0' && ($host == '' || $db == '')) || $conn->connect_errno != '0')
			{
					$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Invalid request"];
					setResponse($invalid);
			}
    }
    else
    {
			include($filename);
			if (!class_exists('laundry_myvariable')){
				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Invalid request"];
        setResponse($invalid);
			}
        include (dirname(dirname(__FILE__)) . "/objects/class_connection.php");
        $cvars = new laundry_myvariable();
        $host = trim($cvars->hostnames);
        $un = trim($cvars->username);
        $ps = trim($cvars->passwords);
        $db = trim($cvars->database);
        $con = new laundry_db();
        $conn = $con->connect();
        if (($conn->connect_errno == '0' && ($host == '' || $db == '')) || $conn->connect_errno != '0')
        {
            $invalid = ['status' => "false", "statuscode" => 404, 'response' => "Invalid request"];
            setResponse($invalid);
        }
    }
}
else
{
    $invalid = ['status' => "false", "statuscode" => 404, 'response' => "Invalid request"];
    setResponse($invalid);
}
include (dirname(dirname(__FILE__)) . "/header.php");
include (dirname(dirname(__FILE__)) . "/objects/class_services.php");
include (dirname(dirname(__FILE__)) . "/objects/class_setting.php");
include (dirname(dirname(__FILE__)) . "/objects/class_services_methods_units.php");
include (dirname(dirname(__FILE__)) . "/objects/class_users.php");
include (dirname(dirname(__FILE__)) . "/objects/class_userdetails.php");
include (dirname(dirname(__FILE__)) . "/objects/class_booking.php");
include (dirname(dirname(__FILE__)) . "/objects/class_email_template.php");
include (dirname(dirname(__FILE__)) . "/objects/class_dashboard.php");
include (dirname(dirname(__FILE__)) . "/objects/class_general.php");
include (dirname(dirname(__FILE__)) . "/objects/class.phpmailer.php");
include (dirname(dirname(__FILE__)) . "/objects/plivo.php");
include (dirname(dirname(__FILE__)) . "/assets/twilio/Services/Twilio.php");
include (dirname(dirname(__FILE__)) . "/objects/class_nexmo.php");
include (dirname(dirname(__FILE__)) . "/objects/class_eml_sms.php");
include (dirname(dirname(__FILE__)) . "/objects/class_adminprofile.php");
include (dirname(dirname(__FILE__)) . "/objects/class_front_first_step.php");
include (dirname(dirname(__FILE__)) . "/objects/class_coupon.php");
include (dirname(dirname(__FILE__)) . "/objects/class_dayweek_avail.php");
include (dirname(dirname(__FILE__)) . "/objects/class_payments.php");
include (dirname(dirname(__FILE__)) . "/objects/class_order_client_info.php");
include (dirname(dirname(__FILE__)) . "/objects/class_gc_hook.php");
include (dirname(dirname(__FILE__)) . "/objects/class_payment_hook.php");
$cvars = new laundry_myvariable();
$host = trim($cvars->hostnames);
$un = trim($cvars->username);
$ps = trim($cvars->passwords);
$db = trim($cvars->database);
$con = new laundry_db();
$conn = $con->connect();
if (($conn->connect_errno == '0' && ($host == '' || $db == '')) || $conn->connect_errno != '0')
{
    $invalid = ['status' => "false", "statuscode" => 404, 'response' => "Invalid request"];
    setResponse($invalid);
}
$objservices = new laundry_services();
$objservices->conn = $conn;
$service = new laundry_services();
$service->conn = $conn;
$objsettings = new laundry_setting();
$objsettings->conn = $conn;
$setting = new laundry_setting();
$setting->conn = $conn;
$settings = new laundry_setting();
$settings->conn = $conn;
$objservice_method_unit = new laundry_services_methods_units();
$objservice_method_unit->conn = $conn;
$user = new laundry_users();
$user->conn = $conn;
$objuserdetails = new laundry_userdetails();
$objuserdetails->conn = $conn;
$booking = new laundry_booking();
$booking->conn = $conn;
$gc_hook = new laundry_gcHook();
$gc_hook->conn = $conn;
$nexmo_admin = new laundry_ld_nexmo();
$nexmo_client = new laundry_ld_nexmo();
$emailtemplate = new laundry_email_template();
$emailtemplate->conn = $conn;
$email_template = new laundry_email_template();
$email_template->conn = $conn;
$objdashboard = new laundry_dashboard();
$objdashboard->conn = $conn;
$objadminprofile = new laundry_adminprofile();
$objadminprofile->conn = $conn;
$first_step = new laundry_first_step();
$first_step->conn = $conn;
$emlsms = new eml_sms();
$emlsms->conn = $conn;
$general = new laundry_general();
$general->conn = $conn;
$coupon = new laundry_coupon();
$coupon->conn = $conn;
$week_day_avail = new laundry_dayweek_avail();
$week_day_avail->conn = $conn;
$objadmin = new laundry_adminprofile();
$objadmin->conn = $conn;
$payment = new laundry_payments();
$payment->conn = $conn;
$order_client_info = new laundry_order_client_info();
$order_client_info->conn = $conn;
$payment_hook = new laundry_paymentHook();
$payment_hook->conn = $conn;
$payment_hook->payment_extenstions_exist();
$purchase_check = $payment_hook->payment_purchase_status();
$global_p_status = $objsettings->get_option('ld_p_status');
$timeformat = $objsettings->get_option('ld_time_format');
$dateformat = $objsettings->get_option('ld_date_picker_date_format');
$date_format = $objsettings->get_option('ld_date_picker_date_format');
$time_format = $objsettings->get_option('ld_time_format');
$getmaximumbooking = $objsettings->get_option('ld_max_advance_booking_time');
$symbol_position = $objsettings->get_option('ld_currency_symbol_position');
$decimal = $objsettings->get_option('ld_price_format_decimal_places');
if ($objsettings->get_option('ld_smtp_authetication') == 'true')
{
    $mail_SMTPAuth = '1';
    if ($objsettings->get_option('ld_smtp_hostname') == "smtp.gmail.com")
    {
        $mail_SMTPAuth = 'Yes';
    }
}
else
{
    $mail_SMTPAuth = '0';
    if ($objsettings->get_option('ld_smtp_hostname') == "smtp.gmail.com")
    {
        $mail_SMTPAuth = 'No';
    }
}
$mail = new laundry_phpmailer();
$mail->Host = $objsettings->get_option('ld_smtp_hostname');
$mail->Username = $objsettings->get_option('ld_smtp_username');
$mail->Password = $objsettings->get_option('ld_smtp_password');
$mail->Port = $objsettings->get_option('ld_smtp_port');
$mail->SMTPSecure = $objsettings->get_option('ld_smtp_encryption');
$mail->SMTPAuth = $mail_SMTPAuth;
$mail_a = new laundry_phpmailer();
$mail_a->Host = $objsettings->get_option('ld_smtp_hostname');
$mail_a->Username = $objsettings->get_option('ld_smtp_username');
$mail_a->Password = $objsettings->get_option('ld_smtp_password');
$mail_a->Port = $objsettings->get_option('ld_smtp_port');
$mail_a->SMTPSecure = $objsettings->get_option('ld_smtp_encryption');
$mail_a->SMTPAuth = $mail_SMTPAuth; /*NEXMO SMS GATEWAY VARIABLES*/
$nexmo_admin->ct_nexmo_api_key = $objsettings->get_option('ld_nexmo_api_key');
$nexmo_admin->ct_nexmo_api_secret = $objsettings->get_option('ld_nexmo_api_secret');
$nexmo_admin->ct_nexmo_from = $objsettings->get_option('ld_nexmo_from');
$nexmo_client->ct_nexmo_api_key = $objsettings->get_option('ld_nexmo_api_key');
$nexmo_client->ct_nexmo_api_secret = $objsettings->get_option('ld_nexmo_api_secret');
$nexmo_client->ct_nexmo_from = $objsettings->get_option('ld_nexmo_from'); /*SMS GATEWAY VARIABLES*/
$plivo_sender_number = $objsettings->get_option('ld_sms_plivo_sender_number');
$twilio_sender_number = $objsettings->get_option('ld_sms_twilio_sender_number'); /* textlocal gateway variables */
$textlocal_username = $objsettings->get_option('ld_sms_textlocal_account_username');
$textlocal_hash_id = $objsettings->get_option('ld_sms_textlocal_account_hash_id'); /*NEED VARIABLE FOR EMAIL*/
$company_city = $objsettings->get_option('ld_company_city');
$company_state = $objsettings->get_option('ld_company_state');
$company_zip = $objsettings->get_option('ld_company_zip_code');
$company_country = $objsettings->get_option('ld_company_country');
$company_phone = strlen($objsettings->get_option('ld_company_phone')) < 6 ? "" : $objsettings->get_option('ld_company_phone');
$company_email = $objsettings->get_option('ld_company_email');
$company_address = $objsettings->get_option('ld_company_address');
$admin_phone_twilio = $objsettings->get_option('ld_sms_twilio_admin_phone_number');
$admin_phone_plivo = $objsettings->get_option('ld_sms_plivo_admin_phone_number'); /*  set admin name */
$get_admin_name_result = $objadminprofile->readone_adminname();
$get_admin_name = $get_admin_name_result[3];
if ($get_admin_name == "")
{
    $get_admin_name = "Admin";
}
$admin_email = $objsettings->get_option('ld_admin_optional_email'); /* set admin name */ /* set business logo and logo alt */
if ($objsettings->get_option('ld_company_logo') != null && $objsettings->get_option('ld_company_logo') != "")
{
    $business_logo = SITE_URL . 'assets/images/services/' . $objsettings->get_option('ld_company_logo');
    $business_logo_alt = $objsettings->get_option('ld_company_name');
}
else
{
    $business_logo = '';
    $business_logo_alt = $objsettings->get_option('ld_company_name');
} /* set business logo and logo alt */
$lang = $objsettings->get_option("ld_language");
$label_language_values = array();
$language_label_arr = $objsettings->get_all_labelsbyid($lang);
if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "")
{
    $default_language_arr = $objsettings->get_all_labelsbyid("en");
    if ($language_label_arr[1] != '')
    {
        $label_decode_front = base64_decode($language_label_arr[1]);
    }
    else
    {
        $label_decode_front = base64_decode($default_language_arr[1]);
    }
    if ($language_label_arr[3] != '')
    {
        $label_decode_admin = base64_decode($language_label_arr[3]);
    }
    else
    {
        $label_decode_admin = base64_decode($default_language_arr[3]);
    }
    if ($language_label_arr[4] != '')
    {
        $label_decode_error = base64_decode($language_label_arr[4]);
    }
    else
    {
        $label_decode_error = base64_decode($default_language_arr[4]);
    }
    if ($language_label_arr[5] != '')
    {
        $label_decode_extra = base64_decode($language_label_arr[5]);
    }
    else
    {
        $label_decode_extra = base64_decode($default_language_arr[5]);
    }
    $label_decode_front_unserial = unserialize($label_decode_front);
    $label_decode_admin_unserial = unserialize($label_decode_admin);
    $label_decode_error_unserial = unserialize($label_decode_error);
    $label_decode_extra_unserial = unserialize($label_decode_extra);
    $label_language_arr = array_merge($label_decode_front_unserial, $label_decode_admin_unserial, $label_decode_error_unserial, $label_decode_extra_unserial);
    foreach ($label_language_arr as $key => $value)
    {
        $label_language_values[$key] = urldecode($value);
    }
}
else
{
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
    foreach ($label_language_arr as $key => $value)
    {
        $label_language_values[$key] = urldecode($value);
    }
}
function book_an_appointment($cart_detail, $orderid, $client_id, $current_time,$booking_pickup_date_time_start,$booking_pickup_date_time_end,$booking_delivery_date_time_start,$booking_delivery_date_time_end, $service_id, $appointment_auto_confirm, $staff_id, $payment_method, $transaction_id, $sub_total, $discount, $tax, $partial_amount, $net_amount,$first_name, $last_name, $email, $phone, $zipcode, $address, $city, $state, $notes, $contact_status, $booking, $payment, $order_client_info)
{
    /** Booking Code START **/
    for ($i = 0;$i < (count($cart_detail));$i++)
    {
			$booking->order_id = $orderid;
			$booking->client_id = $client_id;
			$booking->service_id = $service_id;
			$booking->unit_id = $cart_detail[$i]['id'];
			$booking->unit_name = $cart_detail[$i]['unit_name'];
			$booking->unit_qty = $cart_detail[$i]['unit_qty'];
			$booking->unit_rate = $cart_detail[$i]['unit_rate'];
			if ($appointment_auto_confirm == "Y")
			{
					$booking->booking_status = 'C';
			}
			else
			{
					$booking->booking_status = 'A';
			}
			$booking->lastmodify = $current_time;
			$booking->read_status = 'U';
			$booking->staff_id = $staff_id;
			$add_booking_units = $booking->add_booking_units();
       
    }
    $payment->order_id = $orderid;
		$payment->order_date = $current_time;
    $payment->payment_method = ucwords($payment_method);
    if (isset($transaction_id) && $transaction_id != '')
    {
        $payment->transaction_id = $transaction_id;
        $payment->payment_status = 'Completed';
    }
    else
    {
        $payment->transaction_id = '';
        $payment->payment_status = 'Pending';
    }
    $payment->amount = $sub_total;
    $payment->discount = $discount;
    $payment->taxes = $tax;
    $payment->partial_amount = $partial_amount;
    $payment->payment_date = $current_time;
    $payment->lastmodify = $current_time;
    $payment->net_amount = $net_amount;
		
		$add_payments = $payment->add_payments();
		
	 	$booking->order_date = $current_time;
		$booking->self_service = 'N';
		$booking->show_delivery_date = 'E';
		$booking->booking_pickup_date_time_start = $booking_pickup_date_time_start;
		$booking->booking_pickup_date_time_end = $booking_pickup_date_time_end;
		$booking->booking_delivery_date_time_start = $booking_delivery_date_time_start;
		$booking->booking_delivery_date_time_end = $booking_delivery_date_time_end; 
		
    $order_client_info->order_id = $orderid;
    $order_client_info->client_name = ucwords($first_name) . ' ' . ucwords($last_name);
    $order_client_info->client_email = $email;
    $order_client_info->client_phone = $phone;
    $order_client_info->client_personal_info = base64_encode(serialize(array(
        'zip' => $zipcode,
        'address' => $address,
        'city' => $city,
        'state' => $state,
        'notes' => $notes,
        'contact_status' => $contact_status
    )));
		
		
		
		$add_booking = $booking->add_booking();
    $add_guest_user = $order_client_info->add_order_client();
    /** Booking Code END **/
}
function send_email_and_sms($orderid, $booking_date_time, $service_id, $address, $city, $state, $notes, $phone, $zipcode, $net_amount, $symbol_position, $decimal, $booking, $payment, $order_client_info, $service, $settings, $general, $email, $admin_email, $p_status, $appointment_auto_confirm, $email_template, $first_name, $last_name, $contact_status, $company_email, $company_name, $objdashboard, $textlocal_username, $textlocal_hash_id, $client_phone, $nexmo_admin, $nexmo_client, $business_logo, $business_logo_alt, $get_admin_name, $company_city, $company_state, $company_zip, $company_country, $company_phone, $company_address, $payment_method, $mail, $mail_a)
{ /*** Email Code Start ***/
    $admin_infoo = $order_client_info->readone_for_email();
    $service->id = $service_id;
    $service_name = $service->get_service_name_for_mail(); /* methods */
    $units = "None";
    $methodname = "None";
    $hh = $booking->get_methods_ofbookings($orderid);
    $count_methods = mysqli_num_rows($hh);
    $hh1 = $booking->get_methods_ofbookings($orderid);
    if ($count_methods > 0)
    {
        while ($jj = mysqli_fetch_array($hh1))
        {
            if ($units == "None")
            {
                $units = $jj['units_title'] . "-" . $jj['qtys'];
            }
            else
            {
                $units = $units . "," . $jj['units_title'] . "-" . $jj['qtys'];
            }
            $methodname = $jj['method_title'];
        }
    } /* ADDONS */
    $addons = "None";
    $hh = $booking->get_addons_ofbookings($orderid);
    while ($jj = mysqli_fetch_array($hh))
    {
        if ($addons == "None")
        {
            $addons = $jj['addon_service_name'] . "-" . $jj['addons_service_qty'];
        }
        else
        {
            $addons = $addons . "," . $jj['addon_service_name'] . "-" . $jj['addons_service_qty'];
        }
    }
    if ($company_name == "")
    {
        $company_name = $settings->get_option('ld_company_name');
    }
    $setting_date_format = $settings->get_option('ld_date_picker_date_format');
    $setting_time_format = $settings->get_option('ld_choose_time_format');
    $booking_date = date($setting_date_format, strtotime($booking_date_time));
    if ($setting_time_format == 12)
    {
        $booking_time = date("h:i A", strtotime($booking_date_time));
    }
    else
    {
        $booking_time = date("H:i", strtotime($booking_date_time));
    }
    $price = $general->ct_price_format($net_amount, $symbol_position, $decimal);
    $c_address = $address;
    $client_city = $city;
    $client_state = $state;
    $client_zip = $zipcode;
    $client_email = $email;
    $subject = ucwords($service_name) . " on " . $booking_date;
    if ($admin_email == "")
    {
        $admin_email = $admin_infoo['email'];
    }
    
    $cemail = $email;
    if ($appointment_auto_confirm == "Y")
    {
        $email_template->email_template_type = 'C';
    }
    else
    {
        $email_template->email_template_type = 'A';
    }
    $clientemailtemplate = $email_template->readone_client_email_template();
    if ($clientemailtemplate['email_message'] != '')
    {
        $clienttemplate = base64_decode($clientemailtemplate['email_message']);
    }
    else
    {
        $clienttemplate = base64_decode($clientemailtemplate['default_message']);
    }
    if ($appointment_auto_confirm == "Y")
    {
        $email_template->email_template_type = 'C';
    }
    else
    {
        $email_template->email_template_type = 'A';
    }
    $adminemailtemplate = $email_template->readone_admin_email_template();
    if ($adminemailtemplate['email_message'] != '')
    {
        $admintemplate = base64_decode($adminemailtemplate['email_message']);
    }
    else
    {
        $admintemplate = base64_decode($adminemailtemplate['default_message']);
    }
    $client_phone_info = "";
    $client_phone_no = "";
    $client_phone_length = "";
    $client_first_name = "";
    $client_last_name = "";
    $client_fname = "";
    $client_lname = "";
    $email_notes = "";
    $client_notes = "";
    $client_phone_no = $phone;
    $client_phone_length = strlen($client_phone_no);
    if ($client_phone_length > 6)
    {
        $client_phone_info = $client_phone_no;
    }
    else
    {
        $client_phone_info = "N/A";
    }
    $client_first_name = ucwords(stripslashes($first_name));
    $client_last_name = ucwords(stripslashes($last_name));
    if ($client_first_name == "" && $client_last_name == "")
    {
        $client_fname = "User";
        $client_lname = "";
        $client_name = $client_fname . ' ' . $client_lname;
    }
    elseif ($client_first_name != "" && $client_last_name != "")
    {
        $client_fname = $client_first_name;
        $client_lname = $client_last_name;
        $client_name = $client_fname . ' ' . $client_lname;
    }
    elseif ($client_first_name != "")
    {
        $client_fname = $client_first_name;
        $client_lname = "";
        $client_name = $client_fname . ' ' . $client_lname;
    }
    elseif ($client_last_name != "")
    {
        $client_fname = "";
        $client_lname = $client_last_name;
        $client_name = $client_fname . ' ' . $client_lname;
    }
    $client_notes = stripslashes($notes);
    if ($client_notes == "")
    {
        $client_notes = "N/A";
    }
    $contact_status_cont = $contact_status;
    if ($contact_status_cont == "")
    {
        $contact_status_cont = "N/A";
    }
    $searcharray = array(
        '{{service_name}}',
        '{{booking_date}}',
        '{{business_logo}}',
        '{{business_logo_alt}}',
        '{{client_name}}',
        '{{methodname}}',
        '{{units}}',
        '{{addons}}',
        '{{firstname}}',
        '{{lastname}}',
        '{{client_email}}',
        '{{phone}}',
        '{{payment_method}}',
        '{{vaccum_cleaner_status}}',
        '{{parking_status}}',
        '{{notes}}',
        '{{contact_status}}',
        '{{admin_name}}',
        '{{price}}',
        '{{address}}',
        '{{app_remain_time}}',
        '{{reject_status}}',
        '{{company_name}}',
        '{{booking_time}}',
        '{{client_city}}',
        '{{client_state}}',
        '{{client_zip}}',
        '{{company_city}}',
        '{{company_state}}',
        '{{company_zip}}',
        '{{company_country}}',
        '{{company_phone}}',
        '{{company_email}}',
        '{{company_address}}',
        '{{admin_name}}'
    );
    $replacearray = array(
        $service_name,
        $booking_date,
        $business_logo,
        $business_logo_alt,
        stripslashes($client_name) ,
        $Servicedname,
        $units,
        $client_fname,
        $client_lname,
        $cemail,
        $client_phone_info,
        ucwords($payment_method) ,
        $p_status_v,
        $client_notes,
        $contact_status_cont,
        $get_admin_name,
        $price,
        stripslashes($c_address) ,
        '',
        '',
        $company_name,
        $booking_time,
        stripslashes($client_city) ,
        stripslashes($client_state) ,
        $client_zip,
        stripslashes($company_city) ,
        stripslashes($company_state) ,
        $company_zip,
        $company_country,
        $company_phone,
        $company_email,
        stripslashes($company_address) ,
        stripslashes($get_admin_name)
    );
    if ($settings->get_option('ld_client_email_notification_status') == 'Y' && $clientemailtemplate['email_template_status'] == 'E')
    {
        $client_email_body = str_replace($searcharray, $replacearray, $clienttemplate);
        if ($settings->get_option('ld_smtp_hostname') != '' && $settings->get_option('ld_email_sender_name') != '' && $settings->get_option('ld_email_sender_address') != '' && $settings->get_option('ld_smtp_username') != '' && $settings->get_option('ld_smtp_password') != '' && $settings->get_option('ld_smtp_port') != '')
        {
            $mail->IsSMTP();
        }
        else
        {
            $mail->IsMail();
        }
        $mail->SMTPDebug = 0;
        $mail->IsHTML(true);
        $mail->From = $company_email;
        $mail->FromName = $company_name;
        $mail->Sender = $company_email;
        $mail->AddAddress($client_email, $client_name);
        $mail->Subject = $subject;
        $mail->Body = $client_email_body;
        $mail->send();
        $mail->ClearAllRecipients();
    }
    if ($settings->get_option('ld_admin_email_notification_status') == 'Y' && $adminemailtemplate['email_template_status'] == 'E')
    {
        $admin_email_body = str_replace($searcharray, $replacearray, $admintemplate);
        if ($settings->get_option('ld_smtp_hostname') != '' && $settings->get_option('ld_email_sender_name') != '' && $settings->get_option('ld_email_sender_address') != '' && $settings->get_option('ld_smtp_username') != '' && $settings->get_option('ld_smtp_password') != '' && $settings->get_option('ld_smtp_port') != '')
        {
            $mail_a->IsSMTP();
        }
        else
        {
            $mail_a->IsMail();
        }
        $mail_a->SMTPDebug = 0;
        $mail_a->IsHTML(true);
        $mail_a->From = $company_email;
        $mail_a->FromName = $company_name;
        $mail_a->Sender = $company_email;
        $mail_a->AddAddress($admin_email, $get_admin_name);
        $mail_a->Subject = $subject;
        $mail_a->Body = $admin_email_body;
        $mail_a->send();
        $mail_a->ClearAllRecipients();
    } /*** Email Code End ***/ /*SMS SENDING CODE*/ /* TEXTLOCAL CODE */
    if ($settings->get_option('ld_sms_textlocal_status') == "Y")
    {
        if ($settings->get_option('ld_sms_textlocal_send_sms_to_client_status') == "Y")
        {
            $template = $objdashboard->gettemplate_sms("A", 'C');
            $phone = $client_phone;
            if ($template[4] == "E")
            {
                if ($template[2] == "")
                {
                    $message = base64_decode($template[3]);
                }
                else
                {
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
        if ($settings->get_option('ld_sms_textlocal_send_sms_to_admin_status') == "Y")
        {
            $template = $objdashboard->gettemplate_sms("A", 'A');
            $phone = $settings->get_option('ld_sms_textlocal_admin_phone');;
            if ($template[4] == "E")
            {
                if ($template[2] == "")
                {
                    $message = base64_decode($template[3]);
                }
                else
                {
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
    } /*PLIVO CODE*/
    if ($settings->get_option('ld_sms_plivo_status') == "Y")
    {
        if ($settings->get_option('ld_sms_plivo_send_sms_to_client_status') == "Y")
        {
            $auth_id = $settings->get_option('ld_sms_plivo_account_SID');
            $auth_token = $settings->get_option('ld_sms_plivo_auth_token');
            $p_client = new Plivo\RestAPI($auth_id, $auth_token, '', '');
            $template = $objdashboard->gettemplate_sms("A", 'C');
            $phone = $client_phone;
            if ($template[4] == "E")
            {
                if ($template[2] == "")
                {
                    $message = base64_decode($template[3]);
                }
                else
                {
                    $message = base64_decode($template[2]);
                }
                $client_sms_body = str_replace($searcharray, $replacearray, $message); /* MESSAGE SENDING CODE THROUGH PLIVO */
                $params = array(
                    'src' => $plivo_sender_number,
                    'dst' => $phone,
                    'text' => $client_sms_body,
                    'method' => 'POST'
                );
                $response = $p_client->send_message($params); /* MESSAGE SENDING CODE ENDED HERE*/
            }
        }
        if ($settings->get_option('ld_sms_plivo_send_sms_to_admin_status') == "Y")
        {
            $auth_id = $settings->get_option('ld_sms_plivo_account_SID');
            $auth_token = $settings->get_option('ld_sms_plivo_auth_token');
            $p_admin = new Plivo\RestAPI($auth_id, $auth_token, '', '');
            $admin_phone = $settings->get_option('ld_sms_plivo_admin_phone_number');
            $template = $objdashboard->gettemplate_sms("A", 'A');
            if ($template[4] == "E")
            {
                if ($template[2] == "")
                {
                    $message = base64_decode($template[3]);
                }
                else
                {
                    $message = base64_decode($template[2]);
                }
                $client_sms_body = str_replace($searcharray, $replacearray, $message);
                $params = array(
                    'src' => $plivo_sender_number,
                    'dst' => $admin_phone,
                    'text' => $client_sms_body,
                    'method' => 'POST'
                );
                $response = $p_admin->send_message($params); /* MESSAGE SENDING CODE ENDED HERE*/
            }
        }
    }
    if ($settings->get_option('ld_sms_twilio_status') == "Y")
    {
        if ($settings->get_option('ld_sms_twilio_send_sms_to_client_status') == "Y")
        {
            $AccountSid = $settings->get_option('ld_sms_twilio_account_SID');
            $AuthToken = $settings->get_option('ld_sms_twilio_auth_token');
            $twilliosms_client = new Services_Twilio($AccountSid, $AuthToken);
            $template = $objdashboard->gettemplate_sms("A", 'C');
            $phone = $client_phone;
            if ($template[4] == "E")
            {
                if ($template[2] == "")
                {
                    $message = base64_decode($template[3]);
                }
                else
                {
                    $message = base64_decode($template[2]);
                }
                $client_sms_body = str_replace($searcharray, $replacearray, $message); /*TWILIO CODE*/
                $message = $twilliosms_client
                    ->account
                    ->messages
                    ->create(array(
                    "From" => $twilio_sender_number,
                    "To" => $phone,
                    "Body" => $client_sms_body
                ));
            }
        }
        if ($settings->get_option('ld_sms_twilio_send_sms_to_admin_status') == "Y")
        {
            $AccountSid = $settings->get_option('ld_sms_twilio_account_SID');
            $AuthToken = $settings->get_option('ld_sms_twilio_auth_token');
            $twilliosms_admin = new Services_Twilio($AccountSid, $AuthToken);
            $admin_phone = $settings->get_option('ld_sms_twilio_admin_phone_number');
            $template = $objdashboard->gettemplate_sms("A", 'A');
            if ($template[4] == "E")
            {
                if ($template[2] == "")
                {
                    $message = base64_decode($template[3]);
                }
                else
                {
                    $message = base64_decode($template[2]);
                }
                $client_sms_body = str_replace($searcharray, $replacearray, $message); /*TWILIO CODE*/
                $message = $twilliosms_admin
                    ->account
                    ->messages
                    ->create(array(
                    "From" => $twilio_sender_number,
                    "To" => $admin_phone,
                    "Body" => $client_sms_body
                ));
            }
        }
    }
    if ($settings->get_option('ld_nexmo_status') == "Y")
    {
        if ($settings->get_option('ld_sms_nexmo_send_sms_to_client_status') == "Y")
        {
            $template = $objdashboard->gettemplate_sms("A", 'C');
            $phone = $client_phone;
            if ($template[4] == "E")
            {
                if ($template[2] == "")
                {
                    $message = base64_decode($template[3]);
                }
                else
                {
                    $message = base64_decode($template[2]);
                }
                $ct_nexmo_text = str_replace($searcharray, $replacearray, $message);
                $res = $nexmo_client->send_nexmo_sms($phone, $ct_nexmo_text);
            }
        }
        if ($settings->get_option('ld_sms_nexmo_send_sms_to_admin_status') == "Y")
        {
            $template = $objdashboard->gettemplate_sms("A", 'A');
            $phone = $settings->get_option('ld_sms_nexmo_admin_phone_number');
            if ($template[4] == "E")
            {
                if ($template[2] == "")
                {
                    $message = base64_decode($template[3]);
                }
                else
                {
                    $message = base64_decode($template[2]);
                }
                $ct_nexmo_text = str_replace($searcharray, $replacearray, $message);
                $res = $nexmo_admin->send_nexmo_sms($phone, $ct_nexmo_text);
            }
        }
    } /*SMS SENDING CODE END*/
}
$english_date_array = array(
    "January",
    "Jan",
    "February",
    "Feb",
    "March",
    "Mar",
    "April",
    "Apr",
    "May",
    "June",
    "Jun",
    "July",
    "Jul",
    "August",
    "Aug",
    "September",
    "Sep",
    "October",
    "Oct",
    "November",
    "Nov",
    "December",
    "Dec",
    "Sun",
    "Mon",
    "Tue",
    "Wed",
    "Thu",
    "Fri",
    "Sat",
    "su",
    "mo",
    "tu",
    "we",
    "th",
    "fr",
    "sa"
);
$selected_lang_label = array(
    ucfirst(strtolower($label_language_values['january'])) ,
    ucfirst(strtolower($label_language_values['jan'])) ,
    ucfirst(strtolower($label_language_values['february'])) ,
    ucfirst(strtolower($label_language_values['feb'])) ,
    ucfirst(strtolower($label_language_values['march'])) ,
    ucfirst(strtolower($label_language_values['mar'])) ,
    ucfirst(strtolower($label_language_values['april'])) ,
    ucfirst(strtolower($label_language_values['apr'])) ,
    ucfirst(strtolower($label_language_values['may'])) ,
    ucfirst(strtolower($label_language_values['june'])) ,
    ucfirst(strtolower($label_language_values['jun'])) ,
    ucfirst(strtolower($label_language_values['july'])) ,
    ucfirst(strtolower($label_language_values['jul'])) ,
    ucfirst(strtolower($label_language_values['august'])) ,
    ucfirst(strtolower($label_language_values['aug'])) ,
    ucfirst(strtolower($label_language_values['september'])) ,
    ucfirst(strtolower($label_language_values['sep'])) ,
    ucfirst(strtolower($label_language_values['october'])) ,
    ucfirst(strtolower($label_language_values['oct'])) ,
    ucfirst(strtolower($label_language_values['november'])) ,
    ucfirst(strtolower($label_language_values['nov'])) ,
    ucfirst(strtolower($label_language_values['december'])) ,
    ucfirst(strtolower($label_language_values['dec'])) ,
    ucfirst(strtolower($label_language_values['sun'])) ,
    ucfirst(strtolower($label_language_values['mon'])) ,
    ucfirst(strtolower($label_language_values['tue'])) ,
    ucfirst(strtolower($label_language_values['wed'])) ,
    ucfirst(strtolower($label_language_values['thu'])) ,
    ucfirst(strtolower($label_language_values['fri'])) ,
    ucfirst(strtolower($label_language_values['sat'])) ,
    ucfirst(strtolower($label_language_values['su'])) ,
    ucfirst(strtolower($label_language_values['mo'])) ,
    ucfirst(strtolower($label_language_values['tu'])) ,
    ucfirst(strtolower($label_language_values['we'])) ,
    ucfirst(strtolower($label_language_values['th'])) ,
    ucfirst(strtolower($label_language_values['fr'])) ,
    ucfirst(strtolower($label_language_values['sa']))
);
$today_date = date('Y-m-d');