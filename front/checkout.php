<?php   
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ob_start();
session_start();
include(dirname(dirname(__FILE__)).'/header.php');
include(dirname(dirname(__FILE__)).'/objects/class_connection.php');
include(dirname(dirname(__FILE__)).'/objects/class_setting.php');
include(dirname(dirname(__FILE__)).'/objects/class_booking.php');
include(dirname(dirname(__FILE__)).'/objects/class_payment_hook.php');
include(dirname(dirname(__FILE__)).'/objects/class_services.php');

$con = new laundry_db();
$conn = $con->connect();

$setting = new laundry_setting();
$setting->conn = $conn;

$booking=new laundry_booking();
$booking->conn=$conn;

$service=new laundry_services();
$service->conn=$conn;

$payment_hook = new laundry_paymentHook();
$payment_hook->conn = $conn;
$payment_hook->payment_extenstions_exist();
$purchase_check = $payment_hook->payment_purchase_status();

$stripe_trans_id = '';
$twocheckout_trans_id = '';
if(isset($_POST['action']) && filter_var($_POST['action'])=='complete_booking'){
		if (isset($_POST['st_token']) && filter_var($_POST['st_token']!='' && $_POST['net_amount'])!=0) {			
			require_once('../assets/stripe/stripe.php');
			$partialdeposite_status = $setting->get_option('ld_partial_deposit_status');
			if($partialdeposite_status=='Y'){
				$stripe_amt = number_format(filter_var($_POST['partial_amount']),2,".",',');
			}else{
				$stripe_amt = number_format(filter_var($_POST['net_amount']),2,".",',');
			}
			if(filter_var($_POST['existing_username'])!=''){ 
				$emails=filter_var($_POST['existing_username']); 
			  }else{ 
				$emails=filter_var($_POST['email']); 
			  }
			\Stripe\Stripe::setApiKey($setting->get_option("ld_stripe_secretkey"));
			  $error = '';
			  $success = '';
			   
			 try { 				
				$objcharge = new \Stripe\Charge;
		
					$striperesponse = $objcharge::Create(array(
											"amount" => round(((double)$stripe_amt)*100),
											"currency" => $setting->get_option('ld_currency'),
											"source" => filter_var($_POST['st_token']),
											"description"=>filter_var($_POST['firstname']).' , '.$emails
											));
					$stripe_trans_id = $striperesponse->id;
												
			  }
			  catch (Exception $e) {
				$error = $e->getMessage();				
				echo filter_var($error);die;
			  }					 
					
	}else if (isset($_POST['twoctoken']) && filter_var($_POST['twoctoken']!='' && $_POST['net_amount'])!=0) {			
			require_once('../assets/twocheckout/Twocheckout.php');
			$twocc_private_key = $setting->get_option("ld_2checkout_privatekey");
			$twocc_sellerId = $setting->get_option("ld_2checkout_sellerid");
			$twocc_sandbox_mode = $setting->get_option("ld_2checkout_sandbox_mode");
			if($twocc_sandbox_mode == 'Y'){
				$twocc_sandbox = true;
			}else{
				$twocc_sandbox = false;
			}
			Twocheckout::privateKey($twocc_private_key); 
			Twocheckout::sellerId($twocc_sellerId); 
			Twocheckout::sandbox($twocc_sandbox);
			Twocheckout::verifySSL(false);
			if(filter_var($_POST['existing_username'])!=''){
				$emails=filter_var($_POST['existing_username']);
			}else{
				$emails=filter_var($_POST['email']);
			}
			$last_order_id=$booking->last_booking_id();
			if($last_order_id=='0' || $last_order_id==null){
				$orderid = 1000;
			}else{
				$orderid = $last_order_id+1;
			}
			$partialdeposite_status = $setting->get_option('ld_partial_deposit_status');
			if($partialdeposite_status=='Y'){
				$twocheckout_amt = number_format(filter_var($_POST['partial_amount']),2,".",',');
			}else{
				$twocheckout_amt = number_format(filter_var($_POST['net_amount']),2,".",',');
			}
			try {
				$charge = Twocheckout_Charge::auth(array(
					"merchantOrderId" => $orderid,
					"token"      => $_REQUEST['twoctoken'],
					"currency"   => $setting->get_option('ld_currency'),
					"total"      => $twocheckout_amt,
					"billingAddr" => array(
						"name" => filter_var($_POST['firstname'].' '.$_POST['lastname']),
						"addrLine1" => filter_var($_POST['address']),
						"city" => filter_var($_POST['city']),
						"state" => filter_var($_POST['state']),
						"zipCode" => filter_var($_POST['zipcode']),
						"country" => $setting->get_option('ld_company_country'),
						"email" => $emails,
						"phoneNumber" => filter_var($_POST['phone'])
					)
				));
				
				if ($charge['response']['responseCode'] == 'APPROVED') {
					$twocheckout_trans_id = $charge['response']['transactionId'];
				}
			} catch (Twocheckout_Error $e) {
				$error = $e->getMessage();
				echo filter_var($error);die;
			}	 
					
	}
	
	
	$total_discount =  addslashes(filter_var($_POST['discount']));

    $phone = "";
    if (substr(filter_var($_POST['phone']), 0, 1) === '+')
    {
        $phone = filter_var($_POST['phone']);
    }
    else
    {
        $country_codes = explode(',',$setting->get_option("ld_company_country_code"));
        $phone = $country_codes[0].filter_var($_POST['phone']);
    }
	if($setting->get_option("ld_tax_vat_status") == 'N'){
		$tax = 0;
	}else{
		$tax = filter_var($_POST['taxes']);
	}
	$service->id = $_SESSION['service_id'];
    $service_name = $service->get_service_name_for_mail();
	
	$email = addslashes(filter_var($_POST['email']));
	$firstname = addslashes(filter_var($_POST['firstname']));
	$lastname = addslashes(filter_var($_POST['lastname']));
	$address = addslashes(filter_var($_POST['address']));
	$zipcode = addslashes(filter_var($_POST['zipcode']));
	$city = addslashes(filter_var($_POST['city']));
	$state = addslashes(filter_var($_POST['state']));
	$user_address = addslashes(filter_var($_POST['user_address']));
	$user_zipcode = addslashes(filter_var($_POST['user_zipcode']));
	$coupon_code = addslashes(filter_var($_POST['coupon_code']));
	$user_city = addslashes(filter_var($_POST['user_city']));
	$user_state = addslashes(filter_var($_POST['user_state']));
	$notes = addslashes(filter_var($_POST['notes']));
	if($_POST['staff_id'] == ""){
		$staff_id = 1; 
	}else{
		$staff_id = addslashes($_POST['staff_id']);
	}

	$array_value = array('existing_username' => filter_var($_POST['existing_username']), 'existing_password' => $_POST['existing_password'], 'password' => $_POST['password'], 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'phone' => $phone, 'user_address' => $user_address, 'user_zipcode' => $user_zipcode, 'user_city' => $user_city, 'user_state' => $user_state, 'address' => $address, 'zipcode' => $zipcode, 'city' => $city, 'state' => $state, 'notes' => $notes, 'contact_status' => $_POST['contact_status'], 'payment_method' => $_POST['payment_method'], 'amount' => $_POST['amount'], 'discount' => $total_discount, 'taxes' => $tax, 'partial_amount' => $_POST['partial_amount'], 'net_amount' => $_POST['net_amount'], 'booking_pickup_date_time_start' => $_POST['booking_pickup_date_time_start'], 'booking_pickup_date_time_end' => $_POST['booking_pickup_date_time_end'], 'booking_delivery_date_time_start' => $_POST['booking_delivery_date_time_start'], 'booking_delivery_date_time_end' => $_POST['booking_delivery_date_time_end'], 'coupon_code' => $_POST['coupon_code'], 'action' => "complete_booking", 'coupon_discount' => $_POST['discount'], 'cc_card_num' => $_POST['cc_card_num'],'cc_exp_month' => $_POST['cc_exp_month'],'cc_exp_year' => $_POST['cc_exp_year'],'cc_card_code' => $_POST['cc_card_code'],'guest_user_status' => $_POST['guest_user_status'],'is_login_user' => $_POST['is_login_user'],'service_name' => $service_name,'coupon_code'=> $coupon_code,'self_service'=> $_POST["self_service_status"],'show_delivery_date'=> $_POST["show_delivery_date"],'special_offer_amount' => $_POST["special_offer_amount"],'staff_id' => $staff_id);

	$_SESSION['ld_details']=$array_value;
	
	/* payumoney payment method*/
	if(filter_var($_POST['payment_method']) == 'payumoney'){
		header('location:'.FRONT_URL.'payumoney_payment_process.php');
		exit(0);
	}	
	
	/*paypal payment method*/
	if(filter_var($_POST['payment_method']) == 'paypal'){
		header('location:'.FRONT_URL.'pp_payment_process.php');
		exit(0);
	}
	/*Stripe payment method*/
	if(filter_var($_POST['payment_method']) == 'stripe-payment'){
		$_SESSION['ld_details']['stripe_trans_id'] = 	$stripe_trans_id;
		header('location:'.FRONT_URL.'booking_complete.php');
		exit(0);
	}
	/*2checkout payment method*/
	if(filter_var($_POST['payment_method']) == '2checkout-payment'){
		$_SESSION['ld_details']['twocheckout_trans_id'] = 	$twocheckout_trans_id;
		header('location:'.FRONT_URL.'booking_complete.php');
		exit(0);
	}	
	/*pay locally payment method*/
	if(filter_var($_POST['payment_method']) == 'pay at venue'){
		$transaction_id ='';
		header('location:'.FRONT_URL.'booking_complete.php');
		exit(0);
	}	
	/*bank transfer payment method*/
	if(filter_var($_POST['payment_method']) == 'bank transfer'){
		$transaction_id ='';
		header('location:'.FRONT_URL.'booking_complete.php');
		exit(0);
	}
	/*card payment method*/
	else if(filter_var($_POST['payment_method']) == 'card-payment'){
		$transaction_id ='';
		header('location:'.FRONT_URL.'authorizenet_payment_process.php');
		exit(0);
	}
	
	/* Payment Extension method */
	
	if(sizeof($purchase_check)>0){
		$payment_status = "off";
		$check_pay = 'N';
		foreach($purchase_check as $key=>$val){
			if($val == 'Y'){
				echo filter_var($payment_hook->payment_checkout_hook($key));
			}
		}
	}
} ?>