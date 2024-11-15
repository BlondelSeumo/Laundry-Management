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
	
	for($i=0;$i<(count($_SESSION['ld_cart']['method']));$i++){
	$service_id = 	$_SESSION['ld_cart']['method'][$i]['service_id'];
	}
	
	$service->id=$service_id;
	$serviceInfo = $service->readone();
	$service_title = $serviceInfo[1];
	
	$api_username = urlencode($settings->get_option('ld_paypal_api_username'));
	$api_password = urlencode($settings->get_option('ld_paypal_api_password'));
	$api_signature = urlencode($settings->get_option('ld_paypal_api_signature'));
	$paypaltestmode = $settings->get_option('ld_paypal_test_mode_status');
	
	$guest_payment_st = $settings->get_option('ld_paypal_guest_payment_status');
	$partialdeposite_status = $settings->get_option('ld_partial_deposit_status');
	
	$version = urlencode('109.0');
	$pp_return_url = urlencode(FRONT_URL.'pp_payment_process.php');
	$pp_cancel_url = urlencode(SITE_URL);
	$currency_code = $settings->get_option('ld_currency'); /* 'USD'; */
	$payment_action = urlencode("SALE");
	$locale_code = 'US';
	
	
	$company_logo = $settings->get_option('ld_company_logo');
	
	if($company_logo!='') {		
			
	$thumb_image_name = explode("/",$company_logo);
    $site_logo = SITE_URL."assets/images/services/".$settings->get_option('ld_company_logo');
	}else{
	$site_logo='';
	}
	$border_color = '2285C6';
	$allow_note = 1;
	$p = new laundry_ld_paypal();
	
	if($paypaltestmode=='off'){
	 $p->mode = '';   					/* leave empty for 'Live' mode */
	 }else{ $p->mode = 'SANDBOX'; }
		
	
	/*set basic name and value pairs for curl post*/
	$basic_NVP = array(
					'VERSION'=>$version,
					'USER'=>$api_username,
					'PWD'=>$api_password,
					'SIGNATURE'=>$api_signature,
					'RETURNURL'=>$pp_return_url,
					'CANCELURL'=>$pp_cancel_url,
					'PAYMENTREQUEST_0_CURRENCYCODE'=>$currency_code,
					'NOSHIPPING'=>1,
					'PAYMENTREQUEST_0_PAYMENTACTION'=>$payment_action,
					'LOCALECODE'=>$locale_code,
					'CARTBORDERCOLOR'=>$border_color,
					'LOGOIMG'=>$site_logo,
					'ALLOWNOTE'=>1
				);  
	if($guest_payment_st=='on'){
		$basic_NVP['SOLUTIONTYPE']='Sole';
		$basic_NVP['LANDINGPAGE']='Billing';
	}			
	
	
	$booking_Info = $_SESSION['ld_details'];
	
	foreach($basic_NVP as $key => $value) {
	  $p->pv .= "&$key=$value";
	}
	
	if($partialdeposite_status=='Y'){
			$p->pv .= "&L_PAYMENTREQUEST_0_NAME0=Partial Payment for order";
			$p->pv .= "&L_PAYMENTREQUEST_0_DESC0=Partial payment for appointment order";	
			$p->pv .= "&L_PAYMENTREQUEST_0_AMT0=".number_format($booking_Info['partial_amount'],2,".",',');			
			$p->pv .= "&L_PAYMENTREQUEST_0_QTY0=1";	
		    $p->pv .= "&PAYMENTREQUEST_0_ITEMAMT=".number_format($booking_Info['partial_amount'],2,".",',');
			$p->pv .= "&PAYMENTREQUEST_0_TAXAMT=0"; 
			$p->pv .= "&PAYMENTREQUEST_0_AMT=".number_format($booking_Info['partial_amount'],2,".",',');
	}else{
				$cart_item_counter=0;	
				$p->pv .= "&L_PAYMENTREQUEST_0_NAME$cart_item_counter=$service_title";
				$p->pv .= "&L_PAYMENTREQUEST_0_DESC$cart_item_counter=".$booking_Info['booking_pickup_date_time_start'];		
				$p->pv .= "&L_PAYMENTREQUEST_0_AMT$cart_item_counter=".$booking_Info['amount'];		
				$p->pv .= "&L_PAYMENTREQUEST_0_QTY$cart_item_counter=1";			
		
				$cart_item_counter++;
			   		   			
			   if(isset($booking_Info['discount'])&& $booking_Info['discount']!=''){				   
			   $p->pv .= "&L_PAYMENTREQUEST_0_NAME$cart_item_counter='Discount'";					
			   $p->pv .= "&L_PAYMENTREQUEST_0_DESC$cart_item_counter='Discount'";							
			   $p->pv .= "&L_PAYMENTREQUEST_0_AMT$cart_item_counter=-".number_format($booking_Info['discount'],2,".",',');						
			   $p->pv .= "&L_PAYMENTREQUEST_0_QTY$cart_item_counter=1";									
				$temp_sub_total_val = number_format($booking_Info['amount'],2,".",',')-number_format($booking_Info['discount'],2,".",','); 				
			   }else{				
				$temp_sub_total_val = number_format($booking_Info['amount'],2,".",',');								
			   }					
			   
			    $p->pv .= "&PAYMENTREQUEST_0_ITEMAMT=".$temp_sub_total_val;
				$p->pv .= "&PAYMENTREQUEST_0_TAXAMT=".number_format($booking_Info['taxes'],2,".",',');
				$p->pv .= "&PAYMENTREQUEST_0_AMT=".number_format($booking_Info['net_amount'],2,".",',');					
	
	}	
	$p->pp_method_name = 'SetExpressCheckout';  /*method name using for API call*/
	$resultarray = array();
	if(!isset($_GET["token"])) {
	$response_array = $p->paypal_nvp_api_call();
	/*Respond according to message we receive from Paypal*/
		if("SUCCESS" == strtoupper($response_array["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($response_array["ACK"]))
		{
				if(strtoupper($p->mode)=='SANDBOX') {
				  $p->mode = '.sandbox';
				}
				/*Redirect user to PayPal store with Token received.*/
			 	$paypal_url ='https://www'.$p->mode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$response_array["TOKEN"].'';	
				
				$resultarray['status']='success';
				$resultarray['value']=$paypal_url;
				echo json_encode($resultarray);die();
				
						 
		}else{
			$resultarray['status']='error';
			$resultarray['value']=urldecode($response_array["L_LONGMESSAGE0"]);
			echo json_encode($resultarray);die();			
		}
	}	
	
	if(isset($_GET["token"]) && isset($_GET["PayerID"]))
	{
		/*we will be using these two variables to execute the "DoExpressCheckoutPayment"
		Note: we haven't received any payment yet.*/
		
		$token = $_GET["token"];
		$payer_id = $_GET["PayerID"];	
		$p->pv .= "&TOKEN=".urlencode($token)."&PAYERID=".urlencode($payer_id);
		$p->pp_method_name = 'DoExpressCheckoutPayment';  /*method name using for API call*/
		$payment_response_array = $p->paypal_nvp_api_call(); 
		if("SUCCESS" == strtoupper($payment_response_array["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($payment_response_array["ACK"])) 
		{		  
		   $transaction_id = urldecode($payment_response_array["PAYMENTINFO_0_TRANSACTIONID"]);		   
		   include('booking_complete.php');
		}
	}
?>