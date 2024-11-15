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
$order_client_info = new laundry_order_client_info();
$settings = new laundry_setting();
$coupon = new laundry_coupon();
$booking = new laundry_booking();
$payment = new laundry_payments();
$service = new laundry_services();
$user->conn = $conn;
$order_client_info->conn = $conn;
$settings->conn = $conn;
$coupon->conn = $conn;
$booking->conn = $conn;
$payment->conn = $conn;
$service->conn = $conn;
$appointment_auto_confirm = $settings->get_option('ld_appointment_auto_confirm_status');
$last_order_id = $booking->last_booking_id();
$symbol_position = $settings->get_option('ld_currency_symbol_position');
$decimal = $settings->get_option('ld_price_format_decimal_places');
$company_email = $settings->get_option('ld_company_email');
$company_name = $settings->get_option('ld_company_name');
$calculation_policy = $settings->get_option('ld_calculation_policy');
$timeavailability = new laundry_dayweek_avail();
$timeavailability->conn = $conn;
$taxamount = "";

$services_methods_units = new laundry_services_methods_units();
$services_methods_units->conn = $conn;

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


if($settings->get_option('ld_smtp_authetication') == 'true'){
	$mail_SMTPAuth = '1';
	if($settings->get_option('ld_smtp_hostname') == "smtp.gmail.com"){
		$mail_SMTPAuth = 'Yes';
	}
	
}else{
	$mail_SMTPAuth = '0';
	if($settings->get_option('ld_smtp_hostname') == "smtp.gmail.com"){
		$mail_SMTPAuth = 'No';
	}
}


$mail->SMTPSecure = $settings->get_option('ld_smtp_encryption');
$mail->SMTPAuth = $mail_SMTPAuth;
$mail->CharSet = "UTF-8";

if (isset($_POST['add_to_cart']))
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
			$value = mysqli_fetch_assoc($price_and_status);		
			$price =  $value['price'];
			$status =  $value['article_status'];
			$total_price += ((float)$price) * ((float) $ld_cart_val["unit_qty"]);
			$unit_total = ((float)$price) * ((float) $ld_cart_val["unit_qty"]);
			
			$unit_html .= '<li class="update_qty_of_s_m_' . $ld_cart_val["units_id"] . ''.$ld_cart_val["service_id"].'" data-service_id="' . $ld_cart_val["service_id"] . '" data-units_id="' . $ld_cart_val["units_id"] . '" ><i data-units_id="' . $ld_cart_val["units_id"] . '" data-service_id="' . $ld_cart_val["service_id"].'" data-key = "'.$_POST["cart_dynamic_key"].'" class="fa fa-times remove_item_from_cart cart_method_name" style="color: #f00;"></i><div class="ld-item ofh " ><span class="cart_method_name">' . $ld_cart_val["unit_name"] . '</span> - <span class="cart_qty">'. $ld_cart_val["unit_qty"] .'</span>'.'<span class="cart_price">'.$general->ld_price_format_without_symbol($unit_total, $decimal) . '</span></div></li>';
			
	
		}
	}
	if($_POST['unit_qty'] == 0)
	{
		foreach($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]] as $key => $ld_cart_val){
			$method_type = '';
			if(isset($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]])){
				if ($ld_cart_val['unit_qty'] == filter_var($_POST['unit_qty'])){
					$unit_html = "";
					$unit_html .= '<li class="update_qty_of_s_m_' .$ld_cart_val["units_id"]. ''.$ld_cart_val["service_id"].'" data-service_id="' . $ld_cart_val["service_id"] . '" data-units_id="' . $ld_cart_val["units_id"] . '"></li>';	
					 unset($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]][$key]);	
				}
			}
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
			$taxamount = $percentage_value * $total_price;
		}
	}
	
	foreach($_SESSION['ld_cart'] as $key => $value){
				foreach($value as $get => $myval)
				{
					$full_cart_sub_total += $myval['unit_rate']*$myval['unit_qty'];
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

/* code for apply coupon */
elseif (isset($_POST['coupon_check']))
{
	$jsonn_array = array();
	$_SESSION['ld_cart'] = array_values($_SESSION['ld_cart']);
	$c_rates = 0;

	foreach($_SESSION['ld_cart'] as $key => $value){
		foreach($value as $get => $myval)
		{
			$c_rates += $myval['unit_rate']*$myval['unit_qty'];
		}
	}

	$totals = $c_rates;
	if (filter_var($_POST['coupon_code']) != '')
	{
		$coupon->coupon_code = filter_var($_POST['coupon_code']);
		$result = $coupon->checkcode();
		if ($result)
		{
			$coupon_exp_date = strtotime($result['coupon_expiry']);
			$today = date("Y-m-d");
			$curr_date = strtotime($today);
			if ($result['coupon_used'] < $result['coupon_limit'] && $curr_date <= $coupon_exp_date)
			{
					if ($result['coupon_type'] == 'F')
					{
						$discount_values = $result['coupon_value'];
					}
					else
					if ($result['coupon_type'] == 'P')
					{
						$percent = $result['coupon_value'];
						$percentage_value = $percent / 100;
						$discount_values = $percentage_value * $totals;
					}

					$final_subtotal = $totals - $discount_values;
					if($settings->get_option('ld_tax_vat_status') == 'Y')
					{
						if ($settings->get_option('ld_tax_vat_type') == 'F')
						{
							$flatvalue = $settings->get_option('ld_tax_vat_value');
							$taxamount = $flatvalue;
						}
						else
						if ($settings->get_option('ld_tax_vat_type') == 'P')
						{
							$percent = $settings->get_option('ld_tax_vat_value');
							$percentage_value = $percent / 100;
							$taxamount = $percentage_value * $final_subtotal;
						}
					}
					else
					{
						$taxamount = 0;
					}

					if ($settings->get_option('ld_partial_deposit_status') == 'Y')
					{
						$grand_total = $final_subtotal + $taxamount;
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
				  else
					{
						$partial_amount = 0;
						$remain_amount = 0;
					}
					$alltot=($final_subtotal + $taxamount);
					if($alltot <= 0){
							$alltot=0;
					}
					$jsonn_array['partial_amount'] = $general->ld_price_format($partial_amount, $symbol_position, $decimal);
					$jsonn_array['remain_amount'] = $general->ld_price_format($remain_amount, $symbol_position, $decimal);
					$jsonn_array['discount_status'] = "available";
					$jsonn_array['cart_discount'] = $general->ld_price_format($discount_values, $symbol_position, $decimal);
					$jsonn_array['cart_tax'] = $general->ld_price_format($taxamount, $symbol_position, $decimal);
					$jsonn_array['total_amount'] = $general->ld_price_format($alltot , $symbol_position, $decimal);
					$jsonn_array['cart_sub_total'] = $general->ld_price_format($totals, $symbol_position, $decimal);
					echo json_encode($jsonn_array);
			}
			else
			{
				$jsonn_array['discount_status'] = "not";
				echo json_encode($jsonn_array);
			}
		}
		else
		{
			$jsonn_array['discount_status'] = "wrongcode";
			echo json_encode($jsonn_array);
		}
	}
} 

/* Below code is use for reverse coupon */
elseif (isset($_POST['coupon_reversed']))
{
	$jsonnn_array = array();
	$coupon->coupon_code = filter_var($_POST['coupon_reverse']);
	$result = $coupon->checkcode();
	if ($result['coupon_used'] >= 0)
	{
				$_SESSION['ld_cart'] = array_values($_SESSION['ld_cart']);
				$c_rates = 0;
				foreach($_SESSION['ld_cart'] as $key => $value){
					foreach($value as $get => $myval)
					{
						$c_rates += $myval['unit_rate']*$myval['unit_qty'];
					}
				}

				$totals = $c_rates;
				$final_subtotal = $c_rates;
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
						$taxamount = $percentage_value * $final_subtotal;
					}
				}
				else
				{
					$taxamount = 0;
				}

				if($settings->get_option('ld_partial_deposit_status') == 'Y')
				{
					$grand_total = $final_subtotal + $taxamount;
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
				else
				{
					$partial_amount = 0;
					$remain_amount = 0;
				}

				$jsonnn_array['cart_tax'] = $general->ld_price_format($taxamount, $symbol_position, $decimal);
				$jsonnn_array['partial_amount'] = $general->ld_price_format($partial_amount, $symbol_position, $decimal);
				$jsonnn_array['remain_amount'] = $general->ld_price_format($remain_amount, $symbol_position, $decimal);
				$jsonnn_array['total_amount'] = $general->ld_price_format(($final_subtotal + $taxamount) , $symbol_position, $decimal);
				$jsonnn_array['frequent_discount'] = '- ' . $general->ld_price_format($_SESSION['freq_dis_amount'], $symbol_position, $decimal);
				$jsonnn_array['cart_sub_total'] = $general->ld_price_format($totals, $symbol_position, $decimal);
				$jsonnn_array['status'] = 'reversed';
				echo json_encode($jsonnn_array);
	}
}	

elseif (isset($_POST['action']) && filter_var($_POST['action']) == 'check_user_email')
{
		$user->user_email = trim(strip_tags(mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL))));
		$check_user_mail = $user->check_email();
		if (mysqli_num_rows($check_user_mail) > 0)
		{
			echo json_encode("Email is already exists");
		} else
		{
			echo filter_var("true");
		}
}

elseif (isset($_POST['action']) && filter_var($_POST['action']) == 'forget_password')
{
		$user->user_email = trim(strip_tags(mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL))));
		$res = $user->forget_password();
		$userid = $res[0];
		if (count($res) >= 1)
		{
			$current_time = date('Y-m-d H:i:s');
			$ency_code = base64_encode(base64_encode($userid + 135) . '#' . strtotime("+60 minutes", strtotime($current_time)));
			$to = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$subject = "Forget Password";
			$from = $company_email;
			$body = '<html>			<head>				<meta name="viewport" content="width=device-width, initial-scale=1.0"/>				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />				<title>Welcome to ' . $company_name . '</title>			</head>			<body>				<div style="margin: 0;padding: 0;font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;font-size: 100%;line-height: 1.6;box-sizing: border-box;">						<div style="display: block !important;max-width: 600px !important;margin: 0 auto !important;clear: both !important;">						<table style="border: 1px solid #c2c2c2;width: 100%;float: left;margin: 30px 0px;-webkit-border-radius: 5px;-moz-border-radius: 5px;-o-border-radius: 5px;border-radius: 5px;">							<tbody>								<tr>									<td>										<div style="padding: 25px 30px;background: #fff;float: left;width: 90%;display: block;">											<div style="border-bottom: 1px solid #e6e6e6;float: left;width: 100%;display: block;">												<h3 style="color: #606060;font-size: 20px;margin: 15px 0px 0px;font-weight: 400;">Hi,</h3><br />												<p style="color: #606060;font-size: 15px;margin: 10px 0px 15px;">Forgot your password - <a href="' . SITE_URL . 'admin/forgot-password.php?code=' . $ency_code . '" >Reset it here</a></p>											</div>											<div style="padding: 15px 0px;float: left;width: 100%;">												<h5 style="color: #606060;font-size: 13px;margin: 10px 0px px;">Regards,</h5> 												<h6 style="color: #606060;font-size: 14px;font-weight: 600;margin: 10px 0px 15px;">' . $company_name . '</h6>											</div>										</div>									</td>								</tr>							</tbody>						</table>					</div>				</div>			</body>			</html>';
			if ($settings->get_option('ld_smtp_hostname') != '' && $settings->get_option('ld_email_sender_name') != '' && $settings->get_option('ld_email_sender_address') != '' && $settings->get_option('ld_smtp_username') != '' && $settings->get_option('ld_smtp_password') != '' && $settings->get_option('ld_smtp_port') != '')
			{
				$mail->IsSMTP();
				$mail->Host = $settings->get_option('ld_smtp_hostname');
				$mail->Username = $settings->get_option('ld_smtp_username');
				$mail->Password = $settings->get_option('ld_smtp_password');
				$mail->Port = $settings->get_option('ld_smtp_port');
				
			}
			else
			{
				$mail->IsMail();	
			}

			$mail->SMTPDebug = 1;
			$mail->IsHTML(true);
			$mail->From = $company_email;
			$mail->FromName = $company_name;
			$mail->Sender = $company_email;
			$mail->AddAddress($user->user_email);
			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->send();
			$mail->ClearAllRecipients();
		}
	  else
		{
			echo filter_var("not");
		}
}
elseif (isset($_POST['action']) && filter_var($_POST['action']) == 'reset_new_password')
{
	$user->user_id = $_SESSION['user_id'];
	$user->user_pwd = filter_var($_POST['retype_new_reset_pass']);
	$reset_new_pass = $user->update_password();
	if ($reset_new_pass)
	{
		echo filter_var("password reset successfully");
	}
}

elseif (isset($_POST['check_for_option']))
{
	$check_for_products = "select * from ld_services,ld_services_method,ld_service_methods_units";
	$hh = mysqli_query($conn, $check_for_products);
	$t = $timeavailability->get_timeavailability_check();
	$last = "";
	if ($settings->get_option('ld_company_address') == "" || $settings->get_option('ld_company_city') == "" || $settings->get_option('ld_company_state') == "" || $settings->get_option('ld_company_name') == "" || $settings->get_option('ld_company_email') == "" || $settings->get_option('ld_company_zip_code') == "" || $settings->get_option('ld_company_country') == "" || mysqli_num_rows($hh) == "" || mysqli_num_rows($t) == "")
	{
		$last = "Please complete configurations before you created laundry website embed code. ";
	}
	if (trim($last) != "")
	{
		echo filter_var($last);
	}
	
} ?>