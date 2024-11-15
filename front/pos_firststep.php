<?php   

ob_start();
session_start();
include (dirname(dirname(__FILE__)) . '/header.php');
include (dirname(dirname(__FILE__)) . '/objects/class_connection.php');
include (dirname(dirname(__FILE__)) . '/objects/class_users.php');
include (dirname(dirname(__FILE__)) . '/objects/class_order_client_info.php');
include (dirname(dirname(__FILE__)) . '/objects/class_setting.php');
include (dirname(dirname(__FILE__)) . '/objects/class_coupon.php');
include (dirname(dirname(__FILE__)) . '/objects/class_booking.php');
include (dirname(dirname(__FILE__)) . '/objects/class_payments.php');
include (dirname(dirname(__FILE__)) . '/objects/class_services.php');
include (dirname(dirname(__FILE__)) . '/objects/class.phpmailer.php');
include (dirname(dirname(__FILE__)) . '/objects/class_general.php');
include (dirname(dirname(__FILE__)) . "/objects/class_dayweek_avail.php");
include (dirname(dirname(__FILE__)) . '/objects/class_front_first_step.php');

include (dirname(dirname(__FILE__)) . '/objects/class_services_methods_units.php');

$mail = new laundry_phpmailer();
$mail_a = new laundry_phpmailer();

$database = new laundry_db();
$conn = $database->connect();
/* $database->conn = $conn; */

$first_step = new laundry_first_step();
$first_step->conn = $conn;

$general = new laundry_general();
$general->conn = $conn;

$user = new laundry_users();
$user->conn = $conn;

$order_client_info = new laundry_order_client_info();
$order_client_info->conn = $conn;

$settings = new laundry_setting();
$settings->conn = $conn;

$coupon = new laundry_coupon();
$coupon->conn = $conn;

$booking = new laundry_booking();
$booking->conn = $conn;

$payment = new laundry_payments();
$payment->conn = $conn;

$service = new laundry_services();
$service->conn = $conn;

$timeavailability = new laundry_dayweek_avail();
$timeavailability->conn = $conn;

$services_methods_units = new laundry_services_methods_units();
$services_methods_units->conn = $conn;
$unitimage_path = SITE_URL.'assets/images/article-icons/';


$appointment_auto_confirm = $settings->get_option('ld_appointment_auto_confirm_status');
$last_order_id = $booking->last_booking_id();
$symbol_position = $settings->get_option('ld_currency_symbol_position');
$decimal = $settings->get_option('ld_price_format_decimal_places');
$company_email = $settings->get_option('ld_company_email');
$company_name = $settings->get_option('ld_company_name');
$calculation_policy = $settings->get_option('ld_calculation_policy');

$taxamount = "";

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
		$label_decode_front_unserial = unserialize($label_decode_front);
		$label_language_arr = $label_decode_front_unserial;
		foreach($label_language_arr as $key => $value){
			$label_language_values[$key] = urldecode($value);
		}
}
else
{
    $default_language_arr = $settings->get_all_labelsbyid("en");
		$label_decode_front = base64_decode($default_language_arr[1]);
		$label_decode_front_unserial = unserialize($label_decode_front);
		$label_language_arr = $label_decode_front_unserial;
		foreach($label_language_arr as $key => $value){
			$label_language_values[$key] = urldecode($value);
		}
}

/*Code For POS Start*/

if (isset($_POST['add_to_pos_cart']))
{
	$check_cart_exist = false;
	$unit_html = "";
	$final_duration_value = 0;
	$total_price = 0;
	$cart_dynamic_key = $_POST["cart_dynamic_key"];
	$full_cart_tax = 0;
	$full_cart_sub_total = 0;
	$full_cart_freq_dis_total = 0;
	$full_cart_total_amount = 0;

	if(count((array)$_SESSION['ld_cart'][$_POST["cart_dynamic_key"]]) > 0)
	{
		foreach($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]] as $key => $ld_cart_val){
			if($_SESSION['single_service_id'] != $ld_cart_val['service_id']){
				$_SESSION['ld_cart'][$_POST["cart_dynamic_key"]] = array();
			}
		}
	}
	
	if($cart_dynamic_key <= 0 && count($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]]) > 0) {
		foreach($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]] as $key => $ld_cart_val){
			if($ld_cart_val['units_id'] == $_POST['units_id'] && $ld_cart_val['service_id'] == $_SESSION['single_service_id']){
				unset($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]][$key]);
			}
		}
	}else if (count($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]]) <= 0) {
			$services_methods_units->service_id = filter_var($_SESSION['single_service_id']);
			$services_methods_units->service_unit_id = filter_var($_POST['units_id']);
			$price_and_status = $services_methods_units->get_price_of_article();
			$value = mysqli_fetch_assoc($price_and_status);
			$price =  $value['price'];
			$status =  $value['article_status'];
			$cart_details               = array();
			$cart_details['units_id']   = filter_var($_POST['units_id']);
			$cart_details['service_id'] = $_SESSION['single_service_id'];
			$cart_details['unit_name']  = filter_var($_POST['unit_name']);
			$cart_details['unit_qty']   = filter_var($_POST['unit_qty']);
			$cart_details['unit_rate']  = $price;
			array_push($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]], $cart_details);	
	}else{
		
		$check_cart_exist = true;
		$cart_array  = $_SESSION['ld_cart'][$_POST["cart_dynamic_key"]];
		foreach($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]] as $key => $ld_cart_val){
			if($ld_cart_val['units_id'] == $_POST['units_id'] && $ld_cart_val['service_id'] == $_SESSION['single_service_id']){
				$_SESSION['ld_cart'][$_POST["cart_dynamic_key"]][$key]['unit_qty'] = filter_var($_POST['unit_qty']);
				$check_cart_exist = false;
			}
		}
	}
			
	if($check_cart_exist){
		$services_methods_units->service_id = filter_var($_SESSION['single_service_id']);
		$services_methods_units->service_unit_id = filter_var($_POST['units_id']);
		$price_and_status = $services_methods_units->get_price_of_article();
		
		$value = mysqli_fetch_assoc($price_and_status);
		$price =  $value['price'];
		$status =  $value['article_status'];
		$cart_details                = array();
		$cart_details['units_id'] 	 = filter_var($_POST['units_id']);
		$cart_details['service_id']  = filter_var($_SESSION['single_service_id']);
		$cart_details['unit_name']   = filter_var($_POST['unit_name']);
		$cart_details['unit_qty']    = filter_var($_POST['unit_qty']);
		$cart_details['unit_rate']   = $price;
		array_push($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]], $cart_details);
	}

	if (count($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]]) > 0) {
	
		foreach($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]] as $key => $ld_cart_val){
			
			$services_methods_units->service_unit_id = $ld_cart_val["units_id"];
			$services_methods_units->service_id = filter_var($_SESSION['single_service_id']);		
			$price_and_status = $services_methods_units->get_price_of_article();	
			$image_of_units = $services_methods_units->get_image_of_units();
			
			$value = mysqli_fetch_assoc($price_and_status);		
			$price =  $value['price'];
			$status =  $value['article_status'];
			$total_price += ((float)$price) * ((float) $ld_cart_val["unit_qty"]);
			$unit_total = ((float)$price) * ((float) $ld_cart_val["unit_qty"]);
			if($image_of_units['image'] == '' && $image_of_units['predefine_image'] == ''){
				$image = filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/services/default.png';
			}
			else
			{ 
				if($image_of_units['image'] == ''){
					$image = filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/article-icons/'.$image_of_units['predefine_image'];
				}else{
					$image = filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/services/'.$image_of_units['image'];
																												}
			}

			$unit_html .= '<div class="common-summery update_qty_of_s_m_'. $ld_cart_val["units_id"] . ''.$ld_cart_val["service_id"].'" data-service_id="' . $ld_cart_val["service_id"] . '" data-units_id="' . $ld_cart_val["units_id"] . '"> <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 float-left responsive-padding-small"> <div class="product-name-details"> <div class="summery-img"><img src='.$image.' class="summary-imgaset"> </div><div class="summery_-name"><span>'.$ld_cart_val["unit_name"].'</span></div></div></div><div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 float-left responsive-padding-small"><div class="input-group"><input type="text" name="quant[2]" class="form-control input-number counter-number" value = "'.$ld_cart_val["unit_qty"].'"></div></div><div class="col-xs-4 col-sm-3 col-md-4 col-lg-4 float-left price-common responsive-padding-small"><div class="summery-price"><p>'.$general->ld_price_format_without_symbol($unit_total, $decimal).'</p></div><div class="delete-btn"><i data-units_id="' . $ld_cart_val["units_id"] . '" data-service_id="' . $ld_cart_val["service_id"].'" data-key = "'.$_POST["cart_dynamic_key"].'" class="fa fa-times set-delete-btn pos_remove_item_from_cart cart_method_name"></i></div></div></div>';
				
		}
	}
	if($_POST['unit_qty'] == 0)
	{
		foreach($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]] as $key => $ld_cart_val){
			$method_type = '';
			if(isset($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]])){
				if ($ld_cart_val['unit_qty'] == filter_var($_POST['unit_qty'])){
					$unit_html = "";
					if($image_of_units['image'] == '' && $image_of_units['predefine_image'] == ''){
				$image = filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/services/default.png';
			}
			else
			{ 
				if($image_of_units['image'] == ''){
					$image = filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/article-icons/'.$image_of_units['predefine_image'];
				}else{
					$image = filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/services/'.$image_of_units['image'];
																												}
			}
					$unit_html .= '<div class="common-summery update_qty_of_s_m_'. $ld_cart_val["units_id"] . ''.$ld_cart_val["service_id"].'" data-service_id="' . $ld_cart_val["service_id"] . '" data-units_id="' . $ld_cart_val["units_id"] . '"> <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 float-left responsive-padding-small"> <div class="product-name-details"> <div class="summery-img"><img src='.$image.' class="summary-imgaset"> </div><div class="summery-name"><span>'.$ld_cart_val["unit_name"].'</span></div></div></div><div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 float-left responsive-padding-small"><div class="input-group"><input type="text" name="quant[2]" class="form-control input-number counter-number" value = "'.$ld_cart_val["unit_qty"].'"></div></div><div class="col-xs-4 col-sm-3 col-md-4 col-lg-4 float-left price-common responsive-padding-small"><div class="summery-price"><p>'.$general->ld_price_format_without_symbol($unit_total, $decimal).'</p></div><div class="delete-btn"><i data-units_id="' . $ld_cart_val["units_id"] . '" data-service_id="' . $ld_cart_val["service_id"].'" data-key = "'.$_POST["cart_dynamic_key"].'" class="fa fa-times set-delete-btn pos_remove_item_from_cart cart_method_name"></i></div></div></div>';
					 
					 unset($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]][$key]);	
				}
			}
		}
	} 						
	
	foreach($_SESSION['ld_cart'] as $key => $value){
				foreach($value as $get => $myval)
				{
					$full_cart_sub_total += $myval['unit_rate']*$myval['unit_qty'];
				}
	}

	$taxamount = 0;
	if ($settings->get_option('ld_tax_vat_status') == 'Y')
	{
		if ($settings->get_option('ld_tax_vat_type') == 'F')
		{
			$flatvalue = $settings->get_option('ld_tax_vat_value');
			$taxamount = $flatvalue;
		}
		elseif ($settings->get_option('ld_tax_vat_type') == 'P')
		{
			$percent = $settings->get_option('ld_tax_vat_value');
			$percentage_value = $percent / 100;
			$taxamount = $percentage_value * $full_cart_sub_total;
		}
	}
	
	$partial_amount = 0;
	$remain_amount = 0;
	if ($settings->get_option('ld_partial_deposit_status') == 'Y')
	{
		$grand_total = $full_cart_sub_total + $taxamount;
		if ($settings->get_option('ld_partial_type') == 'F')
		{
			$p_deposite_amount = $settings->get_option('ld_partial_deposit_amount');
			$partial_amount = $p_deposite_amount;
			$remain_amount = $grand_total - $partial_amount;
		}
		elseif ($settings->get_option('ld_partial_type') == 'P')
		{
			$p_deposite_amount = $settings->get_option('ld_partial_deposit_amount');
			$percentages = $p_deposite_amount / 100;
			$partial_amount = $grand_total * $percentages;
			$remain_amount = $grand_total - $partial_amount;
		}
		else
		{
			$partial_amount = 0; 
			$remain_amount = 0; 
		}
	}
	if($full_cart_sub_total == 0){
		$taxamount = 0;
	}

	$jsonn_array['partial_amount'] = $general->ld_price_format($partial_amount, $symbol_position, $decimal);
	$jsonn_array['remain_amount'] = $general->ld_price_format($remain_amount, $symbol_position, $decimal);	
	$jsonn_array["cart_html"] = $unit_html;
	$jsonn_array["cart_dynamic_key"] = $cart_dynamic_key;
	$jsonn_array["current_item_qty"] = $_POST['unit_qty'];												  
	$jsonn_array["subtotal"] = $general->ld_price_format($full_cart_sub_total, $symbol_position, $decimal);
	$jsonn_array["subtotal_amount"] = $full_cart_sub_total;
	$jsonn_array['cart_tax'] = $general->ld_price_format($taxamount, $symbol_position, $decimal);	
	$jsonn_array['total_amount'] = $general->ld_price_format(($full_cart_sub_total + $taxamount) , $symbol_position, $decimal);
	
	echo json_encode($jsonn_array);
} 

/*Code For POS End*/
?>