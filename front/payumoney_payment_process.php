<?php  	
	session_start();
	ob_start();
	include(dirname(dirname(__FILE__)).'/header.php');
	include(dirname(dirname(__FILE__)).'/objects/class_connection.php');	
	require(dirname(dirname(__FILE__)).'/objects/class_pyapal_express_checkout.php');
	include(dirname(dirname(__FILE__)).'/objects/class_setting.php');
	include(dirname(dirname(__FILE__)).'/objects/class_services.php');
	$database= new laundry_db();
	$conn=$database->connect();
	$database->conn=$conn;
	$settings=new laundry_setting();
	$settings->conn=$conn;
	$service = new laundry_services();
	$service->conn=$conn;
	$booking_Info = $_SESSION['ld_details'];
	$partialdeposite_status = $settings->get_option('ld_partial_deposit_status');
	if($partialdeposite_status=='Y'){
		$amt = @number_format($booking_Info['partial_amount'],2,".",',');
	}else{
		$amt = @number_format($booking_Info['net_amount'],2,".",',');
	}
	if($booking_Info['existing_username']!=''){ 
		$emails=$booking_Info['existing_username']; 
	}else{ 
		$emails=$booking_Info['email']; 
	}
	$arr = array();
	$MERCHANT_KEY = $settings->get_option('ld_payumoney_merchant_key');
	$arr['merchant_key'] = $MERCHANT_KEY;
	$SALT = $settings->get_option('ld_payumoney_salt');
	$arr['salt'] = $SALT;
	$arr['amt'] = $amt;
	$arr['fname'] = $booking_Info['firstname'];
	$arr['email'] = $emails;
	$arr['phone'] = $booking_Info['phone'];
	
	$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
	$arr['txnid'] = $txnid;
	$productinfo = 'product description';
	$hash_string = $MERCHANT_KEY.'|'.$txnid.'|'.$amt.'|'.$productinfo.'|'.$booking_Info['firstname'].'|'.$emails.'|||||||||||'.$SALT;

	$arr['hash'] = strtolower(hash('sha512', $hash_string));
	$arr['productinfo'] = $productinfo;
	$arr['payu_surl'] = SITE_URL."front/payumoney_success.php";
	$arr['payu_furl'] = SITE_URL."front/payumoney_failure.php";
	$arr['service_provider'] = "payu_paisa";
	echo json_encode($arr);die;
?>