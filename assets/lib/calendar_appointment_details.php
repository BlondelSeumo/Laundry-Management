<?php    
session_start();
include(dirname(dirname(dirname(__FILE__))) . '/objects/class_connection.php');
include(dirname(dirname(dirname(__FILE__))) . '/objects/class_services.php');
include(dirname(dirname(dirname(__FILE__))) . '/objects/class_services_methods_units.php');
include(dirname(dirname(dirname(__FILE__)))."/objects/class_adminprofile.php");
include_once(dirname(dirname(dirname(__FILE__))) . '/header.php');
include(dirname(dirname(dirname(__FILE__))) . '/objects/class_booking.php');
include(dirname(dirname(dirname(__FILE__))) . '/objects/class_users.php');
include(dirname(dirname(dirname(__FILE__))) . '/objects/class_payments.php');
include(dirname(dirname(dirname(__FILE__))) . '/objects/class_setting.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_general.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_dayweek_avail.php');
$database = new laundry_db();
$conn = $database->connect();
$database->conn = $conn;
$general=new laundry_general();
$general->conn=$conn;
$settings = new laundry_setting();
$settings->conn = $conn;
$symbol_position=$settings->get_option('ld_currency_symbol_position');
$decimal=$settings->get_option('ld_price_format_decimal_places');
$timeformat = $settings->get_option('ld_time_format');
$dateformat = $settings->get_option('ld_date_picker_date_format');
$service = new laundry_services();
$booking = new laundry_booking();
$payment = new laundry_payments();
$user = new laundry_users();
$obj_week_day = new laundry_dayweek_avail();
$obj_week_day->conn = $conn;
$service->conn = $conn;
$booking->conn = $conn;
$user->conn = $conn;
$payment->conn = $conn;

$appointment_detail = array();
$order_id = filter_var($_POST['appointment_id']);

$objadmin = new laundry_adminprofile();
$objadmin->conn=$conn;

$lang = $settings->get_option("ld_language");
$label_language_values = array();
$language_label_arr = $settings->get_all_labelsbyid($lang);

if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "")
{
	$default_language_arr = $settings->get_all_labelsbyid("en");
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
	
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
    
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);
	
	foreach($label_language_arr as $key => $value){
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
    
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);
	
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}



/*new file include*/
include(dirname(dirname(dirname(__FILE__))).'/assets/lib/date_translate_array.php');

/* NEW */
$book_detail = $booking->get_booking_details_appt($order_id);
$service_name = "";
			$service_ids = explode(",",$book_detail["service_id"]);
			
			$color = "";
			foreach($service_ids as $id){
					$service->id = $id;
					$result = $service->readone();
					$service_name .= $result["title"].","; 
			}
$service_name = chop($service_name,","); 

$appointment_detail['id'] = $order_id;
$appointment_detail['booking_price'] = " : " . $general->ld_price_format($book_detail["net_amount"],$symbol_position,$decimal);

$pickup_date = str_replace($english_date_array,$selected_lang_label,date($dateformat, strtotime($book_detail["booking_pickup_date_time_start"])));
if($timeformat == 12){
    $pickup_start_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($book_detail["booking_pickup_date_time_start"])));
}
else
{
    $pickup_start_time = date("H:i", strtotime($book_detail["booking_pickup_date_time_start"]));
}

$appointment_detail['pickup_endtime'] = str_replace($english_date_array,$selected_lang_label,date($dateformat, strtotime($book_detail["booking_pickup_date_time_end"])));
if($timeformat == 12){
    $pickup_end_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($book_detail["booking_pickup_date_time_end"])));
}
else
{
    $pickup_end_time = date("H:i", strtotime($book_detail["booking_pickup_date_time_end"]));
}

$appointment_detail['pickup_starttime'] = $pickup_date;
$appointment_detail['pickup_start_time'] = $pickup_start_time." to ".$pickup_end_time;
$appointment_detail['show_delivery_date'] = $book_detail["show_delivery_date"];
if($book_detail["show_delivery_date"] == "E")
{
	$delivery_date = str_replace($english_date_array,$selected_lang_label,date($dateformat, strtotime($book_detail["booking_delivery_date_time_start"])));
	if($timeformat == 12){
			$delivery_start_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($book_detail["booking_delivery_date_time_start"])));
	}
	else
	{
			$delivery_start_time = date("H:i", strtotime($book_detail["booking_delivery_date_time_start"]));
	}

	$appointment_detail['pickup_endtime'] = str_replace($english_date_array,$selected_lang_label,date($dateformat, strtotime($book_detail["booking_delivery_date_time_end"])));
	if($timeformat == 12){
			$delivery_end_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($book_detail["booking_delivery_date_time_end"])));
	}
	else
	{
			$delivery_end_time = date("H:i", strtotime($book_detail["booking_delivery_date_time_end"]));
	}

	$appointment_detail['delivery_starttime'] = $delivery_date;
	$appointment_detail['delivery_start_time'] = $delivery_start_time." to ".$delivery_end_time;
}
/* units */
$units = "";
$booking->order_id = $order_id;
$book_unit_detail = $booking->get_booking_units_from_order($order_id);
$units_array = array();
	if($book_unit_detail->num_rows > 0){
		while($unit_row = mysqli_fetch_assoc($book_unit_detail)){
			$units_array[$unit_row["service_id"]][] = $unit_row["unit_name"]." - ".$unit_row["unit_qty"];
		}
	}
	if(!empty($units_array)){
		foreach($units_array as $key => $val){
			$units .= implode(", ",$val)."<br />";
		}
	}

$appointment_detail['unit_title'] = ": " . $units;
$appointment_detail['service_title'] = ": " . $service_name;
$appointment_detail['gc_event_id'] = $book_detail["gc_event_id"];
$appointment_detail['gc_staff_event_id'] = $book_detail['gc_staff_event_id'];
$appointment_detail['staff_ids'] = $book_detail['staff_ids'];
$appointment_detail['edit_details'] = '<a class="btn btn-primary " href="edit_customer_detail.php?id='.$book_detail['client_id'].'"><i class="fa fa-edit"></i></a>';
	$ccnames = explode(" ",$book_detail["client_name"]);
	$cnamess = array_filter($ccnames);
	$client_name = array_values($cnamess);
	if(sizeof($client_name)>0){
		if($client_name[0]!=""){ 	
			$client_first_name =  $client_name[0];
		}else{
			$client_first_name = "";
		} 
		
		if(isset($client_name[1]) && $client_name[1]!=""){ 	
			$client_last_name =  $client_name[1]; 
		}else{
			$client_last_name = "";
		} 
	}else{
		$client_first_name = "";
		$client_last_name = "";
	}
	
	if($client_first_name !="" || $client_last_name !=""){ 
		$appointment_detail['client_name'] = " : ".$client_first_name . " ".$client_last_name;
	}else{
		$appointment_detail['client_name'] = "";
	} 


$fetch_phone =  strlen($book_detail["client_phone"]);
if($fetch_phone >= 6){
	$appointment_detail['client_phone'] = ": " . $book_detail["client_phone"];
}else{
	$appointment_detail['client_phone'] = "";
}
$appointment_detail['client_email'] = ": " . $book_detail["client_email"];
$temppp = unserialize(base64_decode($book_detail["client_personal_info"]));

$tem = str_replace('\\','',$temppp);

if($tem['notes']!=""){
	$finalnotes = " : ".$tem['notes'];
}else{
	$finalnotes = "";
}

if($tem['address']!="" || $tem['city']!="" || $tem['zip']!="" || $tem['state']!=""  ){ 	
	$app_address ="";
	$app_city ="";
	$app_zip ="";
	$app_state ="";
	if($tem['address']!=""){ $app_address = $tem['address'].", " ; } 
	if($tem['city']!=""){ $app_city = $tem['city'].", " ; } 
	if($tem['zip']!=""){ $app_zip = $tem['zip'].", " ; } 
	if($tem['state']!=""){ $app_state = $tem['state'] ; } 

	$temper = " : ".$app_address.$app_city.$app_zip.$app_state;
	$temss = rtrim($temper,", ");
	$appointment_detail['client_address'] = $temss;

}else{
	$appointment_detail['client_address'] = "";
}
$appointment_detail['client_notes'] = $finalnotes;
$appointment_detail['contact_status'] = ": " . $tem['contact_status'];
$self_service = "No";
if($book_detail["self_service"] == "Y")
{
	$self_service = "Yes";
}
$appointment_detail['self_service'] = ": " . $self_service;
$payment_status = strtolower($book_detail["payment_method"]);
if($payment_status == "pay at venue"){
	$payment_status = ucwords($label_language_values['pay_locally']);
}else{
	$payment_status = ucwords($payment_status);
}
$appointment_detail['payment_type'] = ": " . $payment_status;

if ($book_detail["booking_status"] == 'A') {
    $status = $label_language_values['active'];
	$appointment_detail['reason_view_status'] = "hide";
	$appointment_detail['reject_reason'] = "";
} elseif ($book_detail["booking_status"] == 'C') {
    $status = $label_language_values['confirm'];
	$appointment_detail['reason_view_status'] = "hide";
	$appointment_detail['reject_reason'] = "";
} elseif ($book_detail["booking_status"] == 'R') {
    $status = $label_language_values['reject'];
	$appointment_detail['reason_view_status'] = "show";
	if($book_detail['reject_reason'] != ""){
		$appointment_detail['reject_reason'] = ": " . $book_detail['reject_reason'];
	}else{
		$appointment_detail['reject_reason'] = "";
	}
} elseif ($book_detail["booking_status"] == 'RS') {
    $status = $label_language_values["rescheduled"];
	$appointment_detail['reason_view_status'] = "show";
	if($book_detail['reject_reason'] != ""){
		$appointment_detail['reject_reason'] = ": " . $book_detail['reject_reason'];
	}else{
		$appointment_detail['reject_reason'] = "";
	}
} elseif ($book_detail["booking_status"] == 'CC') {
    $status =$label_language_values['cancel_by_client'];
	$appointment_detail['reason_view_status'] = "show";
	if($book_detail['reject_reason'] != ""){
		$appointment_detail['reject_reason'] = ": " . $book_detail['reject_reason'];
	}else{
		$appointment_detail['reject_reason'] = "";
	}
} elseif ($book_detail["booking_status"] == 'CS') {
    $status = $label_language_values['cancelled_by_service_provider'];
	$appointment_detail['reason_view_status'] = "show";
	if($book_detail['reject_reason'] != ""){
		$appointment_detail['reject_reason'] = ": " . $book_detail['reject_reason'];
	}else{
		$appointment_detail['reject_reason'] = "";
	}
} elseif ($book_detail["booking_status"] == 'CO') {
    $status = $label_language_values['completed'];
	$appointment_detail['reason_view_status'] = "hide";
	$appointment_detail['reject_reason'] = "";
} else {
    $book_detail["booking_status"] == 'MN';
    $status = $label_language_values['mark_as_no_show'];
	$appointment_detail['reason_view_status'] = "hide";
	$appointment_detail['reject_reason'] = "";
}
$appointment_detail['booking_status'] = $book_detail["booking_status"];
if($status == "Confirm"){
    $appointment_detail['hider'] = "c";
}
else
{
    $appointment_detail['hider'] = "r";
}
$booking_day = date("Y-m-d", strtotime($book_detail["booking_pickup_date_time_start"]));
$current_day = date("Y-m-d");
if ($current_day > $booking_day)
{
    $appointment_detail['past'] = "Yes";
}
else
{
    $appointment_detail['past'] = "No";
}

$get_staff_services = $objadmin->readall_staff_booking();
$booking->order_id = $order_id;
$get_staff_assignid = explode(",",$booking->fetch_staff_of_booking());

$staff_html = "";
$staff_html .= "<select id='staff_select' class='selectpicker col-md-10' data-live-search='true' multiple data-actions-box='true' data-orderid='".$order_id."'>";

$booking->booking_pickup_date_time_start = $book_detail["booking_pickup_date_time_start"];
$staff_status = $booking->booked_staff_status();
$staff_status_arr = explode(",",$staff_status ?? '');

foreach($get_staff_services as $staff_details)
{
	$i = "no";
	$staffname = $staff_details['fullname'];
	$staffid = $staff_details['id'];
	$s_s = "";
	if(in_array($staffid,$staff_status_arr)){
		$s_s = "fa fa-calendar-check-o";
	}
	
	if(in_array($staffid,$get_staff_assignid)){
		$i = "yes";
	}
	if($i == "yes")
	{
		$staff_html .= "<option selected='selected' data-icon='".$s_s." booking-staff-assigned' value='$staffid'>$staffname</option>";
	}
	else{
		$staff_html .= "<option data-icon='".$s_s." booking-staff-assigned' value='$staffid'>$staffname</option>";
	}
}

$staff_html .= "</select><a href='javascript:void(0)' data-orderid='".$order_id."' class='save_staff_booking edit_staff btn btn-info'><i class='remove_add_fafa_class fa fa-pencil-square-o'></i></a>";
$appointment_detail['staff'] = ": " . $staff_html;
echo json_encode($appointment_detail);
die();