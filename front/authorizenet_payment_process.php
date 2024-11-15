<?php  	

	include(dirname(dirname(__FILE__)).'/header.php');
	include(dirname(dirname(__FILE__)).'/objects/class_connection.php');
	include(dirname(dirname(__FILE__)).'/objects/class_setting.php');
	
	
	$database= new laundry_db();
	$conn=$database->connect();
	
	$settings = new laundry_setting();
	$settings->conn = $conn;
	$a = session_id();	if(empty($a)) session_start();
	$plugin_base_ralative_path =  dirname(dirname(__FILE__));	
	$partialdeposite_status = $settings->get_option('ld_partial_deposit_status');
	if($partialdeposite_status=='Y'){
		$app_net_amount = number_format($_SESSION['ld_details']['partial_amount'],2,".",',');
	}else{
		$app_net_amount = number_format($_SESSION['ld_details']['net_amount'],2,".",',');
	}
	
	require($plugin_base_ralative_path.'/assets/authorize.net/autoload.php');
	$response = null;
	define( 'AUTHORIZENET_API_LOGIN_ID',$settings->get_option('ld_authorizenet_API_login_ID'));
	define( 'AUTHORIZENET_TRANSACTION_KEY',$settings->get_option('ld_authorizenet_transaction_key'));
	if($settings->get_option('ld_authorize_sandbox_mode')=='on'){   
		define( 'AUTHORIZENET_SANDBOX',true); 
	}else{  
		define( 'AUTHORIZENET_SANDBOX',false);
	}
	$expirydate = $_SESSION['ld_details']['cc_exp_month'].'/'.$_SESSION['ld_details']['cc_exp_year'];
	$sale             = new AuthorizeNetAIM();
	$sale->amount     = $app_net_amount;
	$sale->card_num   = $_SESSION['ld_details']['cc_card_num'];
	$sale->card_code  = $_SESSION['ld_details']['cc_card_code'];
	$sale->exp_date   = $expirydate;
	$sale->first_name = $_SESSION['ld_details']['firstname'].''.$_SESSION['ld_details']['lastname'];
	$sale->email      = $_SESSION['ld_details']['email'];
	$sale->phone      = $_SESSION['ld_details']['phone'];
	$response = $sale->authorizeAndCapture();
	if ( $response->approved ) {				
		$return = array ( 'success' => true ,'error' =>'','transaction_id'=>$response->transaction_id);
		echo json_encode($return);die();
	} else {
		$return = array ('success' => false, 'error' => $response->error_message);
		echo json_encode($return);die();
	}
?>