<?php   

include(dirname(dirname(__FILE__))."/objects/class_gc_hook.php");

$gc_hook = new laundry_gcHook();
$gc_hook->conn = $conn;

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
$_SESSION['order_id'] = '';
$mail = new laundry_phpmailer();
$mail->Host = $settings->get_option('ld_smtp_hostname');
$mail->Username = $settings->get_option('ld_smtp_username');
$mail->Password = $settings->get_option('ld_smtp_password');
$mail->Port = $settings->get_option('ld_smtp_port');
$mail->SMTPSecure = $settings->get_option('ld_smtp_encryption');
$mail->SMTPAuth = $mail_SMTPAuth;
$mail->CharSet = "UTF-8";

$mail_a = new laundry_phpmailer();
$mail_a->Host = $settings->get_option('ld_smtp_hostname');
$mail_a->Username = $settings->get_option('ld_smtp_username');
$mail_a->Password = $settings->get_option('ld_smtp_password');
$mail_a->Port = $settings->get_option('ld_smtp_port');
$mail_a->SMTPSecure = $settings->get_option('ld_smtp_encryption');
$mail_a->SMTPAuth = $mail_SMTPAuth;
$mail_a->CharSet = "UTF-8";


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
$textlocal_username =$settings->get_option('ld_sms_textlocal_account_username');
$textlocal_hash_id = $settings->get_option('ld_sms_textlocal_account_hash_id');


/*NEED VARIABLE FOR EMAIL*/
$company_city = $settings->get_option('ld_company_city');
$company_state = $settings->get_option('ld_company_state');
$company_zip = $settings->get_option('ld_company_zip_code');
$company_country = $settings->get_option('ld_company_country');
$company_phone = strlen($settings->get_option('ld_company_phone')) < 6 ? "" : $settings->get_option('ld_company_phone');
$company_address = $settings->get_option('ld_company_address'); 

/*** complete checkout code ***/

/*  set admin name */
$get_admin_name_result = $objadminprofile->readone_adminname();
$get_admin_name = $get_admin_name_result[3];

if($get_admin_name == ""){
	$get_admin_name = "Admin";
}

$admin_email = $settings->get_option('ld_admin_optional_email');

/* set admin name */
/* set business logo and logo alt */
 if($settings->get_option('ld_company_logo') != null && $settings->get_option('ld_company_logo') != ""){
	$business_logo= SITE_URL.'assets/images/services/'.$settings->get_option('ld_company_logo');
	$business_logo_alt= $settings->get_option('ld_company_name');
}else{
	$business_logo= '';
	$business_logo_alt= $settings->get_option('ld_company_name');
}

/* set business logo and logo alt */
$client_phone = "";

$lang = $settings->get_option("ld_language");
$label_language_values = array();

$language_label_arr = $settings->get_all_labelsbyid($lang);
if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "" || $language_label_arr[6] != ""){
	
	$default_language_arr = $settings->get_all_labelsbyid("en");
	
	if($language_label_arr[1] != ''){
		$label_decode_front = base64_decode($language_label_arr[1]);
	}else{
		$label_decode_front = base64_decode($default_language_arr[1]);
	}
	
	$label_decode_front_unserial = unserialize($label_decode_front);
    
	$label_language_values = array_merge($label_decode_front_unserial);
	
	foreach($label_language_values as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}else{
	
    $default_language_arr = $settings->get_all_labelsbyid("en");
		$label_decode_front = base64_decode($default_language_arr[1]);
		$label_decode_front_unserial = unserialize($label_decode_front);
		$label_language_values = array_merge($label_decode_front_unserial);
		foreach($label_language_values as $key => $value){
			$label_language_values[$key] = urldecode($value);
		}
}

$english_date_array = array(
"January","Jan","February","Feb","March","Mar","April","Apr","May","June","Jun","July","Jul","August","Aug","September","Sep","October","Oct","November","Nov","December","Dec","Sun","Mon","Tue","Wed","Thu","Fri","Sat","su","mo","tu","we","th","fr","sa","AM","PM");

$selected_lang_label = array(
		ucfirst(strtolower($label_language_values['january'])),
		ucfirst(strtolower($label_language_values['jan'])),
		ucfirst(strtolower($label_language_values['february'])),
		ucfirst(strtolower($label_language_values['feb'])),
		ucfirst(strtolower($label_language_values['march'])),
		ucfirst(strtolower($label_language_values['mar'])),
		ucfirst(strtolower($label_language_values['april'])),
		ucfirst(strtolower($label_language_values['apr'])),
		ucfirst(strtolower($label_language_values['may'])),
		ucfirst(strtolower($label_language_values['june'])),
		ucfirst(strtolower($label_language_values['jun'])),
		ucfirst(strtolower($label_language_values['july'])),
		ucfirst(strtolower($label_language_values['jul'])),
		ucfirst(strtolower($label_language_values['august'])),
		ucfirst(strtolower($label_language_values['aug'])),
		ucfirst(strtolower($label_language_values['september'])),
		ucfirst(strtolower($label_language_values['sep'])),
		ucfirst(strtolower($label_language_values['october'])),
		ucfirst(strtolower($label_language_values['oct'])),
		ucfirst(strtolower($label_language_values['november'])),
		ucfirst(strtolower($label_language_values['nov'])),
		ucfirst(strtolower($label_language_values['december'])),
		ucfirst(strtolower($label_language_values['dec'])),
		ucfirst(strtolower($label_language_values['sun'])),
		ucfirst(strtolower($label_language_values['mon'])),
		ucfirst(strtolower($label_language_values['tue'])),
		ucfirst(strtolower($label_language_values['wed'])),
		ucfirst(strtolower($label_language_values['thu'])),
		ucfirst(strtolower($label_language_values['fri'])),
		ucfirst(strtolower($label_language_values['sat'])),
		ucfirst(strtolower($label_language_values['su'])),
		ucfirst(strtolower($label_language_values['mo'])),
		ucfirst(strtolower($label_language_values['tu'])),
		ucfirst(strtolower($label_language_values['we'])),
		ucfirst(strtolower($label_language_values['th'])),
		ucfirst(strtolower($label_language_values['fr'])),
		ucfirst(strtolower($label_language_values['sa'])),
		strtoupper($label_language_values['am']),
		strtoupper($label_language_values['pm']));

if(isset($_SESSION['ld_details']) && $_SESSION['ld_details']!=''){

    $current_time = date('Y-m-d H:i:s');
    $zipcode='';
    if(isset($_SESSION['ld_details']['zipcode'])){
        $zipcode=$_SESSION['ld_details']['zipcode'];
    }
    $address='';
    if(isset($_SESSION['ld_details']['address'])){
        $address=$_SESSION['ld_details']['address'];
    }
    $city='';
    if(isset($_SESSION['ld_details']['city'])){
        $city=ucwords($_SESSION['ld_details']['city']);
    }
    $state='';
    if(isset($_SESSION['ld_details']['state'])){
        $state=ucwords($_SESSION['ld_details']['state']);
    }
    $notes='';
    if(isset($_SESSION['ld_details']['notes'])){
        $notes=$_SESSION['ld_details']['notes'];
    }
		$staff_id='';
    if(isset($_SESSION['ld_details']['staff_id'])){
       $staff_id = $_SESSION['ld_details']['staff_id'];
    }
    $contact_status='';
    if(isset($_SESSION['ld_details']['contact_status'])){
        $contact_status=mysqli_real_escape_string($conn,$_SESSION['ld_details']['contact_status']);
    }
	
		$contact_status_email=$_SESSION['ld_details']['contact_status'];
	
		$self_service = $_SESSION['ld_details']['self_service'];
		$show_delivery_date = $_SESSION['ld_details']['show_delivery_date'];

    if($last_order_id=='0' || $last_order_id==null){
        $orderid = 1000;
    }else{
        $orderid = $last_order_id+1;
    }
		
		$booking_pickup_date_time_start = date("Y-m-d H:i:s", strtotime($_SESSION['ld_details']['booking_pickup_date_time_start']));
    $booking_pickup_date_time_end = date("Y-m-d H:i:s", strtotime($_SESSION['ld_details']['booking_pickup_date_time_end']));
		
		$booking_delivery_date_time_start = date("Y-m-d H:i:s", strtotime($_SESSION['ld_details']['booking_delivery_date_time_start']));
    $booking_delivery_date_time_end = date("Y-m-d H:i:s", strtotime($_SESSION['ld_details']['booking_delivery_date_time_end']));

    if( !function_exists( 'array_column' ) )
    {
        function array_column( array $input, $column_key, $index_key = null ) {
            $result = array();
            foreach( $input as $k => $v )
                $result[ $index_key ? $v[ $index_key ] : $k ] = $v[ $column_key ];
            return $result;
        }
    }
	
	$user->existing_username=$_SESSION['ld_details']['existing_username'];
	$user->existing_password=$_SESSION['ld_details']['existing_password'];
	$existing_login=$user->check_login();
	
	/** check and add booking for existing customer **/
	
	if($existing_login){
		$user->user_id=$existing_login[0];
		$user->user_pwd=$existing_login[2];
		$user->first_name=ucwords($_SESSION['ld_details']['firstname']);
		$user->last_name=ucwords($_SESSION['ld_details']['lastname']);
		$user->user_email=$existing_login[1];
		$user->phone=$_SESSION['ld_details']['phone'];
		$client_phone = $_SESSION['ld_details']['phone'];
		$user->address=$_SESSION['ld_details']['user_address'];
		$user->zip=$_SESSION['ld_details']['user_zipcode'];
		$user->city=ucwords($_SESSION['ld_details']['user_city']);
		$user->state=ucwords($_SESSION['ld_details']['user_state']);
		$user->notes=mysqli_real_escape_string($conn,$_SESSION['ld_details']['notes']);
		$user->status='E';
		$user->usertype=serialize(array('client'));
		$user->contact_status=mysqli_real_escape_string($conn,$_SESSION['ld_details']['contact_status']);
		$update_user=$user->update_user();
		if($update_user){
			$service_id = 0;
			foreach($_SESSION["ld_cart"] as $cart_key => $cart_detail) {
				for($i=0;$i<(count($cart_detail));$i++){
					$booking->order_id=$orderid;
					$booking->service_id=$cart_detail[$i]['service_id'];
					$service_id = $cart_detail[$i]['service_id'];
					$booking->unit_id=$cart_detail[$i]['units_id'];
					$booking->unit_name=$cart_detail[$i]['unit_name'];
					$booking->unit_qty=$cart_detail[$i]['unit_qty'];
					$booking->unit_rate=$cart_detail[$i]['unit_rate'];
					$add_booking=$booking->add_booking_units();				
				}
			}
			
			$service_id = ltrim($_SESSION['service_id'],",");
			$booking->service_id= chop($service_id,",");
			$booking->order_id=$orderid;
			$booking->client_id= $user->user_id;
			$booking->order_date=$current_time;
			$booking->booking_pickup_date_time_start=$booking_pickup_date_time_start;
			$booking->booking_pickup_date_time_end=$booking_pickup_date_time_end;
			$booking->booking_delivery_date_time_start=$booking_delivery_date_time_start;
			$booking->booking_delivery_date_time_end=$booking_delivery_date_time_end;
			$booking->self_service=$self_service;
			$booking->show_delivery_date=$show_delivery_date;
			
			
			if($appointment_auto_confirm=="Y"){
					$booking->booking_status='C';
			}else{
					$booking->booking_status='A';
			}
			
			$booking->lastmodify=$current_time;
			$booking->read_status='U';
			$booking->staff_id= $staff_id;
			$add_booking=$booking->add_booking();
				
			$payment->order_id =$orderid;
			$payment->payment_method=ucwords('pay at venue');
			
			if(isset($_POST['transaction_id'])){
				$payment->transaction_id= filter_var($_POST['transaction_id']);
			} else {
				$payment->transaction_id='';
			}
			
			$payment->order_id =$orderid;
			$payment->payment_method=ucwords('pay at venue');
			$payment->transaction_id= '';
			$payment->amount=$_SESSION['ld_details']['amount'];
			$payment->taxes=$_SESSION['ld_details']['taxes'];
			$payment->partial_amount=$_SESSION['ld_details']['partial_amount'];
			$payment->payment_date=$current_time;
			$payment->lastmodify=$current_time;
			$payment->net_amount=$_SESSION['ld_details']['net_amount'];
			$add_payment=$payment->add_payments();
			
			$order_client_info->order_id=$orderid;
			$order_client_info->client_name=ucwords($_SESSION['ld_details']['firstname']).' '.ucwords($_SESSION['ld_details']['lastname']);
			$order_client_info->client_email=$existing_login[1];
			$order_client_info->client_phone=$_SESSION['ld_details']['phone'];
			$order_client_info->client_personal_info=base64_encode(serialize(array('zip'=>$zipcode,'address'=>$address,'city'=>$city,'state'=>$state,'notes'=>$notes,'contact_status'=>$contact_status)));
			$add_existing_user=$order_client_info->add_order_client();
		}
	}else{
		
		/** check and add booking for new customer **/
		$user->user_pwd=md5($_SESSION['ld_details']['password']);
		$user->first_name=ucwords($_SESSION['ld_details']['firstname']);
		$user->last_name=ucwords($_SESSION['ld_details']['lastname']);
		$user->user_email=$_SESSION['ld_details']['email'];
		$user->phone=$_SESSION['ld_details']['phone'];
		$client_phone = $_SESSION['ld_details']['phone'];
		$user->address=$_SESSION['ld_details']['user_address'];
		$user->zip=$_SESSION['ld_details']['user_zipcode'];
		$user->city=ucwords($_SESSION['ld_details']['user_city']);
		$user->state=ucwords($_SESSION['ld_details']['user_state']);
		$user->notes=mysqli_real_escape_string($conn,$_SESSION['ld_details']['notes']);
		$user->status='E';
		$user->usertype=serialize(array('client'));
		$user->contact_status=mysqli_real_escape_string($conn,$_SESSION['ld_details']['contact_status']);
		$add_user=$user->add_user();

		$inserted_user = $conn->insert_id;
		$service_id = 0;
		foreach($_SESSION["ld_cart"] as $cart_key => $cart_detail) {
			for($i=0;$i<(count($cart_detail));$i++){
				$booking->order_id=$orderid;
				$booking->service_id=$cart_detail[$i]['service_id'];
				$service_id = $cart_detail[$i]['service_id'];
				$booking->unit_id=$cart_detail[$i]['units_id'];
				$booking->unit_name=$cart_detail[$i]['unit_name'];
				$booking->unit_qty=$cart_detail[$i]['unit_qty'];
				$booking->unit_rate=$cart_detail[$i]['unit_rate'];
		
				$add_booking=$booking->add_booking_units();				
			}
		}
		$service_id = ltrim($_SESSION['service_id'],",");
		$booking->service_id=	chop($service_id,",");
		$booking->order_id=$orderid;
		$booking->client_id=$inserted_user;
		$booking->order_date=$current_time;
		$booking->booking_pickup_date_time_start=$booking_pickup_date_time_start;
		$booking->booking_pickup_date_time_end=$booking_pickup_date_time_end;
		$booking->booking_delivery_date_time_start=$booking_delivery_date_time_start;
		$booking->booking_delivery_date_time_end=$booking_delivery_date_time_end;
		$booking->self_service=$self_service;
		$booking->show_delivery_date=$show_delivery_date;
		if($appointment_auto_confirm=="Y"){
				$booking->booking_status='C';
		}else{
				$booking->booking_status='A';
		}
		$booking->lastmodify=$current_time;
		$booking->read_status='U';
		$booking->staff_id= $staff_id;
		$add_booking=$booking->add_booking();
		
		$payment->order_id =$orderid;
		$payment->payment_method=ucwords('pay at venue');
		if(isset($_POST['transaction_id'])){
			$payment->transaction_id= filter_var($_POST['transaction_id']);
		} else {
			$payment->transaction_id='';
		}
		$payment->amount=$_SESSION['ld_details']['amount'];
		$payment->taxes=$_SESSION['ld_details']['taxes'];
		$payment->partial_amount=$_SESSION['ld_details']['partial_amount'];
		$payment->payment_date=$current_time;
		$payment->lastmodify=$current_time;
		$payment->net_amount=$_SESSION['ld_details']['net_amount'];
		$payment->payment_status = 'Pending';
		$add_payment=$payment->add_payments();
		
		$order_client_info->order_id=$orderid;
		$order_client_info->client_name=ucwords($_SESSION['ld_details']['firstname']).' '.ucwords($_SESSION['ld_details']['lastname']);
		$order_client_info->client_email=$_SESSION['ld_details']['email'];
		$order_client_info->client_phone=$_SESSION['ld_details']['phone'];
		$order_client_info->client_personal_info=base64_encode(serialize(array('zip'=>$zipcode,'address'=>$address,'city'=>$city,'state'=>$state,'notes'=>$notes,'contact_status'=>$contact_status)));
		$add_new_user=$order_client_info->add_order_client();
	}

	/* Add Booking in Google Calender */
	
	if($gc_hook->gc_purchase_status() == 'exist'){
		echo filter_var($gc_hook->gc_add_booking_ajax_hook());
		echo filter_var($gc_hook->gc_add_staff_booking_ajax_hook());
	}
	
	/* End Add Booking in Google Calender */
	
    /*** Email Code Start ***/
    $admin_infoo = $order_client_info->readone_for_email();
		$service->id = $_SESSION['service_id'];
    $service_name = $service->get_service_name_for_mail();
    for($i=0;$i<(count($_SESSION['ld_cart']));$i++){
        /* units */
        $units = "None";
				$booking->order_id = $orderid;
        $hh = $booking->get_booking_units_from_order($orderid);
        while($jj = mysqli_fetch_array($hh)){
            if($units == "None"){
                $units = $jj['unit_name']."-".$jj['unit_qty'];
            }
            else
            {
                $units = $units.",".$jj['unit_name']."-".$jj['unit_qty'];
            }
        }
    }
	if($company_name == ""){
		$company_name = $settings->get_option('ld_company_name');
	}
	$setting_date_format = $settings->get_option('ld_date_picker_date_format');
	$setting_time_format = $settings->get_option('ld_time_format');
	
	$booking_date = str_replace($english_date_array,$selected_lang_label,date($setting_date_format,strtotime($_SESSION['ld_details']['booking_pickup_date_time_start'])));
	
	if($setting_time_format == 12){
		
		$booking_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($_SESSION['ld_details']['booking_pickup_date_time_start'])));
	}else{
		
		$booking_time = date("H:i", strtotime($_SESSION['ld_details']['booking_pickup_date_time_start']));
	}
	$price = $general->ld_price_format($_SESSION['ld_details']['net_amount'],$symbol_position,$decimal);
	
	/* staff details */
	$get_staff_name = "";
	$get_staff_email = "";
	$staff_phone = "";
	if(isset($staff_id) && !empty($staff_id))
	{
		$objadminprofile->id = $staff_id;
		$staff_details = $objadminprofile->readone();
		$get_staff_name = $staff_details["fullname"];
		$get_staff_email = $staff_details["email"];
		$staff_phone = $staff_details["phone"];
	}
	
	$c_address = $_SESSION['ld_details']['address'];
	$client_city = $_SESSION['ld_details']['city'];
	$client_state = $_SESSION['ld_details']['state'];
	$client_zip = $_SESSION['ld_details']['zipcode'];
  $client_email = $_SESSION['ld_details']['email'];
	
	if(isset($_SESSION['ld_details']['email']) &&  $_SESSION['ld_details']['email']==''){		$client_email = $_SESSION['ld_details']['existing_username'];	}

	$subject = ucwords($service_name)." on ".$booking_date;
	if($admin_email == ""){
		$admin_email = $admin_infoo['email'];
	}
	if($_SESSION['ld_details']['email'] != ""){
			$cemail = $_SESSION['ld_details']['email'];
	}
	elseif($_SESSION['ld_details']['existing_username'] != ""){
			$cemail = $_SESSION['ld_details']['existing_username'];
	}

	if($appointment_auto_confirm=="Y"){
		$email_template->email_template_type = 'C';
	}else{
		$email_template->email_template_type = 'A';
	} 
	$clientemailtemplate = $email_template->readone_client_email_template();

	if($clientemailtemplate['email_message'] != ''){
			$clienttemplate = base64_decode($clientemailtemplate['email_message']);
	}else{
			$clienttemplate = base64_decode($clientemailtemplate['default_message']);
	}

	if($appointment_auto_confirm=="Y"){
		$email_template->email_template_type = 'C';
	}else{
		$email_template->email_template_type = 'A';
	}
		
	$adminemailtemplate = $email_template->readone_admin_email_template();
	
	if($adminemailtemplate['email_message'] != ''){
			$admintemplate = base64_decode($adminemailtemplate['email_message']);
	}else{
			$admintemplate = base64_decode($adminemailtemplate['default_message']);
	}

	$staffemailtemplate = $email_template->readone_staff_email_template();

	if($staffemailtemplate['email_message'] != ''){
			$stafftemplate = base64_decode($staffemailtemplate['email_message']);
	}else{
			$stafftemplate = base64_decode($staffemailtemplate['default_message']);
	}	
	
	$client_phone_info="";
	$client_phone_no="";
	$client_phone_length="";
	$client_first_name="";
	$client_last_name="";
	$client_fname="";
	$client_lname="";
	$email_notes="";
	$client_notes="";

	$client_phone_no = $_SESSION['ld_details']['phone'];
	$client_phone_length = strlen($client_phone_no);
			
	if($client_phone_length > 6){
		$client_phone_info = $client_phone_no;
	}else{
		$client_phone_info = "N/A";
	}
	
	$client_first_name = ucwords(stripslashes($_SESSION['ld_details']['firstname']));
	$client_last_name =	ucwords(stripslashes($_SESSION['ld_details']['lastname']));
	
	if($client_first_name=="" && $client_last_name==""){
		$client_fname = "User";
		$client_lname = "";
		$client_name = $client_fname.' '.$client_lname;
	}elseif($client_first_name!="" && $client_last_name!=""){
		$client_fname = $client_first_name;
		$client_lname = $client_last_name;
		$client_name = $client_fname.' '.$client_lname;
	}elseif($client_first_name!=""){
		$client_fname = $client_first_name;
		$client_lname = "";
		$client_name = $client_fname.' '.$client_lname;
	}elseif($client_last_name!=""){
		$client_fname = "";
		$client_lname = $client_last_name;
		$client_name = $client_fname.' '.$client_lname;
	}
	$client_notes = stripslashes($notes);	
	if($client_notes==""){
		$client_notes = "N/A";
	}	
	
	$contact_status_cont = $contact_status_email;	
	if($contact_status_cont==""){
		$contact_status_cont = "N/A";
	}

	$payment_method = $_SESSION['ld_details']['payment_method'];
	if($payment_method == "pay at venue"){
		$payment_method = ucwords($label_language_values['pay_locally']);
	}else{
		$payment_method = ucwords($payment_method);
	}	
	
	$searcharray = array('{{service_name}}','{{booking_date}}','{{business_logo}}','{{business_logo_alt}}','{{client_name}}','{{units}}','{{firstname}}','{{lastname}}','{{client_email}}','{{phone}}','{{payment_method}}','{{notes}}','{{contact_status}}','{{admin_name}}','{{price}}','{{address}}','{{app_remain_time}}','{{reject_status}}','{{company_name}}','{{booking_time}}','{{client_city}}','{{client_state}}','{{client_zip}}','{{company_city}}','{{company_state}}','{{company_zip}}','{{company_country}}','{{company_phone}}','{{company_email}}','{{company_address}}','{{admin_name}}','{{staff_name}}','{{staff_email}}');

	$replacearray = array($service_name, $booking_date , $business_logo, $business_logo_alt, stripslashes($client_name), $units,$client_fname ,$client_lname , $cemail,$client_phone_info, ucwords($_SESSION['ld_details']['payment_method']),$client_notes, $contact_status_cont,$get_admin_name,$price,stripslashes($c_address),'','',$company_name,$booking_time,stripslashes($client_city),stripslashes($client_state),$client_zip,stripslashes($company_city),stripslashes($company_state),$company_zip,$company_country,$company_phone,$company_email,stripslashes($company_address),stripslashes($get_admin_name),stripslashes($get_staff_name),stripslashes($get_staff_email));

	if($settings->get_option('ld_client_email_notification_status') == 'Y' && $clientemailtemplate['email_template_status'] == 'E'){
		 $client_email_body = str_replace($searcharray,$replacearray,$clienttemplate);
			if($settings->get_option('ld_smtp_hostname') != '' && $settings->get_option('ld_email_sender_name') != '' && $settings->get_option('ld_email_sender_address') != '' && $settings->get_option('ld_smtp_username') != '' && $settings->get_option('ld_smtp_password') != '' && $settings->get_option('ld_smtp_port') != ''){
					$mail->IsSMTP();
			}else{
					$mail->IsMail();
			}
			$mail->SMTPDebug  = 0;
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
	if($settings->get_option('ld_admin_email_notification_status') == 'Y' && $adminemailtemplate['email_template_status'] == 'E'){							
			$admin_email_body = str_replace($searcharray,$replacearray,$admintemplate);
			if($settings->get_option('ld_smtp_hostname') != '' && $settings->get_option('ld_email_sender_name') != '' && $settings->get_option('ld_email_sender_address') != '' && $settings->get_option('ld_smtp_username') != '' && $settings->get_option('ld_smtp_password') != '' && $settings->get_option('ld_smtp_port') != ''){
					$mail_a->IsSMTP();
			}else{
					$mail_a->IsMail();
			}
			$mail_a->SMTPDebug  = 0;
			$mail_a->IsHTML(true);
			$mail_a->From = $company_email;
			$mail_a->FromName = $company_name;
			$mail_a->Sender = $company_email;
			$mail_a->AddAddress($admin_email, $get_admin_name);
			$mail_a->Subject = $subject;
			$mail_a->Body = $admin_email_body;
			$mail_a->send();
			$mail_a->ClearAllRecipients();
	}
	if($settings->get_option('ld_staff_email_notification_status') == 'Y' && $adminemailtemplate['email_template_status'] == 'E'){							
			$staff_email_body = str_replace($searcharray,$replacearray,$stafftemplate);
			if($settings->get_option('ld_smtp_hostname') != '' && $settings->get_option('ld_email_sender_name') != '' && $settings->get_option('ld_email_sender_address') != '' && $settings->get_option('ld_smtp_username') != '' && $settings->get_option('ld_smtp_password') != '' && $settings->get_option('ld_smtp_port') != ''){
					$mail_a->IsSMTP();
			}else{
					$mail_a->IsMail();
			}
			$mail_a->SMTPDebug  = 0;
			$mail_a->IsHTML(true);
			$mail_a->From = $company_email;
			$mail_a->FromName = $company_name;
			$mail_a->Sender = $company_email;
			$mail_a->AddAddress($get_staff_email, $get_staff_name);
			$mail_a->Subject = $subject;
			$mail_a->Body = $staff_email_body;
			$mail_a->send();
			$mail_a->ClearAllRecipients();
	}

    /*** Email Code End    SMS SENDING CODE		GET APPROVED SMS TEMPLATE  ***/ 
		
	/* TEXTLOCAL CODE */
	
	if($settings->get_option('ld_sms_textlocal_status') == "Y")
	{
		if($settings->get_option('ld_sms_textlocal_send_sms_to_client_status') == "Y"){
			$template = $objdashboard->gettemplate_sms("A",'C');
			$phone = $client_phone;				
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
			}
			$message = str_replace($searcharray,$replacearray,$message);
			$data = "username=".$textlocal_username."&hash=".$textlocal_hash_id."&message=".$message."&numbers=".$phone."&test=0";
			$ch = curl_init('http://api.textlocal.in/send/?');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
		}
		if($settings->get_option('ld_sms_textlocal_send_sms_to_admin_status') == "Y"){
			$template = $objdashboard->gettemplate_sms("A",'A');
			$phone = $settings->get_option('ld_sms_textlocal_admin_phone');;				
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
			}
			$message = str_replace($searcharray,$replacearray,$message);
			$data = "username=".$textlocal_username."&hash=".$textlocal_hash_id."&message=".$message."&numbers=".$phone."&test=0";
			$ch = curl_init('http://api.textlocal.in/send/?');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
		}
		if($settings->get_option('ld_sms_textlocal_send_sms_to_staff_status') == "Y"){
			if(isset($staff_phone) && !empty($staff_phone))
			{
				$template = $objdashboard->gettemplate_sms("A",'S');
				$phone = $staff_phone;				
				if($template[4] == "E") {
					if($template[2] == ""){
						$message = base64_decode($template[3]);
					}
					else{
						$message = base64_decode($template[2]);
					}
				}
				$message = str_replace($searcharray,$replacearray,$message);
				$data = "username=".$textlocal_username."&hash=".$textlocal_hash_id."&message=".$message."&numbers=".$phone."&test=0";
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
		
	if($settings->get_option('ld_sms_plivo_status')=="Y")
	{
	   
	   if($settings->get_option('ld_sms_plivo_send_sms_to_client_status') == "Y"){
			$auth_id = $settings->get_option('ld_sms_plivo_account_SID');
			$auth_token = $settings->get_option('ld_sms_plivo_auth_token');
			$p_client = new Plivo\RestAPI($auth_id, $auth_token, '', '');

			$template = $objdashboard->gettemplate_sms("A",'C');
			$phone = $client_phone;
			if($template[4] == "E"){
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray,$replacearray,$message);
				/* MESSAGE SENDING CODE THROUGH PLIVO */
				$params = array(
					'src' => $plivo_sender_number,
					'dst' => $phone,
					'text' => $client_sms_body,
					'method' => 'POST'
				);
				$response = $p_client->send_message($params);
				echo filter_var($response);
				/* MESSAGE SENDING CODE ENDED HERE*/
			}
		}
		if($settings->get_option('ld_sms_plivo_send_sms_to_admin_status') == "Y"){
			$auth_id = $settings->get_option('ld_sms_plivo_account_SID');
			$auth_token = $settings->get_option('ld_sms_plivo_auth_token');
			$p_admin = new Plivo\RestAPI($auth_id, $auth_token, '', '');
			$admin_phone = $settings->get_option('ld_sms_plivo_admin_phone_number');
			$template = $objdashboard->gettemplate_sms("A",'A');
			
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray,$replacearray,$message);
				$params = array(
					'src' => $plivo_sender_number,
					'dst' => $admin_phone,
					'text' => $client_sms_body,
					'method' => 'POST'
				);
				$response = $p_admin->send_message($params);
				echo filter_var($response);
				/* MESSAGE SENDING CODE ENDED HERE*/
			}
		}
		
		if($settings->get_option('ld_sms_plivo_send_sms_to_staff_status') == "Y"){
			if(isset($staff_phone) && !empty($staff_phone))
			{	
				$auth_id = $settings->get_option('ld_sms_plivo_account_SID');
				$auth_token = $settings->get_option('ld_sms_plivo_auth_token');
				$p_client = new Plivo\RestAPI($auth_id, $auth_token, '', '');

				$template = $objdashboard->gettemplate_sms("A",'S');
				$phone = $staff_phone;
				if($template[4] == "E"){
					if($template[2] == ""){
						$message = base64_decode($template[3]);
					}
					else{
						$message = base64_decode($template[2]);
					}
					$client_sms_body = str_replace($searcharray,$replacearray,$message);
					/* MESSAGE SENDING CODE THROUGH PLIVO */
					$params = array(
						'src' => $plivo_sender_number,
						'dst' => $phone,
						'text' => $client_sms_body,
						'method' => 'POST'
					);
					$response = $p_client->send_message($params);
					echo filter_var($response);
					/* MESSAGE SENDING CODE ENDED HERE*/
				}
			}
		}
	}
	
	/*TWILIVO CODE*/
	
	if($settings->get_option('ld_sms_twilio_status') == "Y")
	{
		if($settings->get_option('ld_sms_twilio_send_sms_to_client_status') == "Y"){
			$AccountSid = $settings->get_option('ld_sms_twilio_account_SID');
			$AuthToken =  $settings->get_option('ld_sms_twilio_auth_token'); 
			$twilliosms_client = new Services_Twilio($AccountSid, $AuthToken);

			$template = $objdashboard->gettemplate_sms("A",'C');
			$phone = $client_phone;
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray,$replacearray,$message);
				/*TWILIO CODE*/
				$message = $twilliosms_client->account->messages->create(array(
					"From" => $twilio_sender_number,
					"To" => $phone,
					"Body" => $client_sms_body));
			}
		}
		if($settings->get_option('ld_sms_twilio_send_sms_to_admin_status') == "Y"){
			$AccountSid = $settings->get_option('ld_sms_twilio_account_SID');
			$AuthToken =  $settings->get_option('ld_sms_twilio_auth_token'); 
			$twilliosms_admin = new Services_Twilio($AccountSid, $AuthToken);
			$admin_phone = $settings->get_option('ld_sms_twilio_admin_phone_number');
			$template = $objdashboard->gettemplate_sms("A",'A');
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray,$replacearray,$message);
				/*TWILIO CODE*/
				$message = $twilliosms_admin->account->messages->create(array(
					"From" => $twilio_sender_number,
					"To" => $admin_phone,
					"Body" => $client_sms_body));
			}
		}
		if($settings->get_option('ld_sms_twilio_send_sms_to_staff_status') == "Y"){
			if(isset($staff_phone) && !empty($staff_phone))
			{	
				$AccountSid = $settings->get_option('ld_sms_twilio_account_SID');
				$AuthToken =  $settings->get_option('ld_sms_twilio_auth_token'); 
				$twilliosms_client = new Services_Twilio($AccountSid, $AuthToken);

				$template = $objdashboard->gettemplate_sms("A",'S');
				$phone = $staff_phone;
				if($template[4] == "E") {
					if($template[2] == ""){
						$message = base64_decode($template[3]);
					}
					else{
						$message = base64_decode($template[2]);
					}
					$client_sms_body = str_replace($searcharray,$replacearray,$message);
					/*TWILIO CODE*/
					$message = $twilliosms_client->account->messages->create(array(
						"From" => $twilio_sender_number,
						"To" => $phone,
						"Body" => $client_sms_body));
				}
			}
		}
	}
	
	/*NEXMO CODE*/
	
	if($settings->get_option('ld_nexmo_status') == "Y")
	{
		if($settings->get_option('ld_sms_nexmo_send_sms_to_client_status') == "Y"){
			$template = $objdashboard->gettemplate_sms("A",'C');
			$phone = $client_phone;				
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
				$ld_nexmo_text = str_replace($searcharray,$replacearray,$message);
				$res=$nexmo_client->send_nexmo_sms($phone,$ld_nexmo_text);
			}
			
		}
		if($settings->get_option('ld_sms_nexmo_send_sms_to_admin_status') == "Y"){
			$template = $objdashboard->gettemplate_sms("A",'A');
			$phone = $settings->get_option('ld_sms_nexmo_admin_phone_number');				
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
				$ld_nexmo_text = str_replace($searcharray,$replacearray,$message);
				$res=$nexmo_admin->send_nexmo_sms($phone,$ld_nexmo_text);
			}
			
		}
		
		if($settings->get_option('ld_sms_nexmo_send_sms_to_staff_status') == "Y"){
			if(isset($staff_phone) && !empty($staff_phone))
			{
				$template = $objdashboard->gettemplate_sms("A",'S');
				$phone = $staff_phone;				
				if($template[4] == "E") {
					if($template[2] == ""){
						$message = base64_decode($template[3]);
					}
					else{
						$message = base64_decode($template[2]);
					}
					$ld_nexmo_text = str_replace($searcharray,$replacearray,$message);
					$res=$nexmo_client->send_nexmo_sms($phone,$ld_nexmo_text);
				}
			}
		}
	}
    /*SMS SENDING CODE END*/
		
 /*   @ob_clean();
   ob_start(); */
		$_SESSION['order_id'] = $orderid;

   echo filter_var('ok');
}
?>