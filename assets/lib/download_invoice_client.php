<?php   

	ob_start();	session_start();
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
	include_once(dirname(dirname(dirname(__FILE__))).'/header.php');	
	include(dirname(dirname(dirname(__FILE__))).'/assets/pdf/tfpdf/tfpdf.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_booking.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_services.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_setting.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_users.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_front_first_step.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_order_client_info.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_payments.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_general.php');	
		
	$database=new laundry_db();
	$conn=$database->connect();
	$database->conn=$conn;
	
	$booking=new laundry_booking();
	$service=new laundry_services();	
	$setting=new laundry_setting();
	$first_step=new laundry_first_step();
	$user=new laundry_users();
	$order=new laundry_order_client_info();
	$payments=new laundry_payments();	
	$general=new laundry_general();
	
	$service->conn=$conn;
	$booking->conn=$conn;	
	$setting->conn=$conn;
	$first_step->conn=$conn;
	$user->conn=$conn;
	$order->conn=$conn;
	$payments->conn=$conn;
	$general->conn=$conn;
	
	$lang = $setting->get_option("ld_language");
$label_language_values = array();
$language_label_arr = $setting->get_all_labelsbyid($lang);

if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "")
{
	$default_language_arr = $setting->get_all_labelsbyid("en");
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
    $default_language_arr = $setting->get_all_labelsbyid("en");
	
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

	$dateformat=$setting->get_option('ld_date_picker_date_format');
    $symbol_position=$setting->get_option('ld_currency_symbol_position');    
    $symbol=$setting->get_option('ld_currency_symbol');    
    $decimal=$setting->get_option('ld_price_format_decimal_places');	
	$dateformat=$setting->get_option('ld_date_picker_date_format');	
	$time_format=$setting->get_option('ld_time_format');		
	/*Invoice Details*/
	$order_id = $_GET['iid'];
	$booking->order_id=$order_id;
	$bookings = $booking->get_details_for_invoice_client();
	
	/*Business Id by location id*/
	
	$business_name=$setting->get_option('ld_company_name');
	$business_email=$setting->get_option('ld_company_email');
	$business_address=$setting->get_option('ld_company_address');
	$business_city=$setting->get_option('ld_company_city');
	$business_state=$setting->get_option('ld_company_state');
	$business_zip=$setting->get_option('ld_company_zip_code');
	$business_country=$setting->get_option('ld_company_country');	
	$business_logo=$setting->get_option('ld_company_logo');
	
	
	$invoice_number = strtoupper(date('M',strtotime($bookings[2]))).'-'.$order_id;
	$invoice_date = date($dateformat,strtotime($bookings[2]));	
	
	/*Client info*/
	$booking->client_id=$bookings[4];
	$cinfo=$booking->get_client_info();
	$client_name=$cinfo[3];
	$client_email=$cinfo[1];
	$client_phone='N/A';
	if(strlen($cinfo[5]) >= 6){
		$client_phone=$cinfo[5];
	}
	$client_address=$cinfo[7];
	$client_notes=$cinfo[10];	
	$client_city=$cinfo[8];
	$client_state=$cinfo[9];
	$client_zip=$cinfo[6];
	$client_country=$cinfo[8];
	

	/*Payment Info */
	$payments->order_id=$order_id;
	$payinfo=$payments->get_payment_details();	
		
	$payment_transaction_id=$payinfo[3];
	$payment_amount=$payinfo[4];
	$payment_discount=$payinfo[5];
	$payment_taxes=$payinfo[6];
	$payment_partial_amount=$payinfo[7];
	$payment_date=$payinfo[8];
	$payment_net_amount=$payinfo[9];
	if($payinfo[2]=='Pay At Venue')
	{ 
		$payment_method = $label_language_values['cash']; 
	}			
	else if($payinfo[2]=='Card Payment')
	{
		$payment_method = $label_language_values['card_payment']; 
	}	
	else if($payinfo[2]=='Bank Transfer')
	{ 
		$payment_method = 'Bank Transfer';
	}	
	else if($payinfo[2]=='Paypal')
	{ 
		$payment_method = 'Paypal';
	}	
	else if($payinfo[2]=='Stripe-payment' || $payinfo[2]=='Card-payment' || $payinfo[2]=='2checkout-payment')
	{ 
		$payment_method = 'Card Payment'; 
	}	
	else
	{	
		$payment_method = ''; 	
	}
		
	
	/* Booking Details */
	$booking_info_details=array();
	
	$booking->booking_id = $order_id;
	$bookings_info = $booking->readall_bookings();	
	
	while($row=mysqli_fetch_array($bookings_info)){
		$all_booking_details[]=$row;
	}
	$service_name="";
	foreach($all_booking_details as $book_info){
	/*Service Details*/
	
		$service->id=$book_info['service_id'];
		$s_info=$service->readone();
		$service_name=$s_info[1];

	}
	
	/* Addon's details */

	$sainfo=$booking->get_units_ofbookings($order_id);
	
	if(isset($sainfo) && !empty($sainfo)){
	while($rows=mysqli_fetch_array($sainfo)){
		$all_addon_details[]=$rows;
	}
	if(!empty($all_addon_details)){
	foreach($all_addon_details as $book_add_info){
	
		$service->id=$book_add_info['service_id'];
		$s_info=$service->readone();
		$addon_service_name=$s_info[1];
	
		$addonname=$book_add_info["unit_name"];
		$addonqty=$book_add_info['unit_qty'];
		
		$addonprice=$general->ld_price_format_for_pdf($book_add_info['unit_rate'],$symbol_position,$decimal);
		
		$booking_addon_details[]= array(
		"service_name"=>"$addon_service_name",
		"addonname"=>"$addonname",
		"addonqty"=>"$addonqty",
		"addonprice"=>"$addonprice"		
		);
	
	}
	}
	}

	$backgroundimage=SITE_URL."assets/images/background_image_client.jpeg";
	
	if($business_logo!=='' || $business_logo!==null){
		$logo=SITE_URL."assets/images/services/".$business_logo;
	}else{
		
		$logo='';
	}
	
	$client_city_state = '';
	if($client_city != '' && $client_state != ''){
		$client_city_state = $client_city.",".$client_state;
	}elseif($client_city != '' && $client_state == ''){
		$client_city_state = $client_city;
	}elseif($client_city == '' && $client_state != ''){
		$client_city_state = $client_state;
	}
	
	$pdf = new tFPDF();
	$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
	$pdf->SetFont('DejaVu','',14);
	$pdf->SetMargins(0,0);
	$pdf->SetTopMargin(0);
	$pdf->SetAutoPageBreak(true,0);
	$pdf->AddPage();
	$pdf->SetFillColor(242,242,242);
    $pdf->SetTextColor(102,103,102);
    $pdf->SetDrawColor(128,255,0);
    $pdf->SetLineWidth(0);
   
	$pdf->Cell(210,297,'',0,1,'C',true);
	$pdf->Image($backgroundimage,0,0,210); /* background */
	$pdf->SetFont('DejaVu','',12);
	$pdf->Text(25,10,$business_name);
	$pdf->Text(25,15,$business_address);
	$pdf->Text(25,20,$business_city.",".$business_state);
	$pdf->Text(25,25,$business_country);
	$pdf->Text(25,30,$business_email);
	
	$pdf->SetFont('DejaVu','',13);
	$pdf->Text(133,10,$label_language_values['invoice_to']);
	
	$pdf->SetFont('DejaVu','',10);
	$pdf->Text(133,15,ucwords($client_name));
	
	$pdf->SetFont('DejaVu','',9);
	
	/* here first no.is position from left and second is from top ok */
	$pdf->Text(133,20,$client_address);
	$pdf->Text(133,25,$client_city_state);
	$pdf->Text(140,33,$client_phone);
	$pdf->Text(140,38,$client_email);
	
	$pdf->SetFont('DejaVu','',30);
	$pdf->SetTextColor(55,55,55);
	$pdf->Text(30,60,$label_language_values['invoice']);
	$pdf->SetFont('DejaVu','',22);
	$pdf->Text(31,75,"#".strtoupper(date('M',strtotime($invoice_date)))."-".sprintf("%04d",$order_id));

	$pdf->SetFont('DejaVu','',13);
	$pdf->SetTextColor(255,255,255);
	$pdf->Text(98,60 ,$label_language_values['invoice_date']);
	$pdf->Text(160,60,$label_language_values['payment_method']);
	$pdf->SetFont('DejaVu','',11);
    $pdf->SetTextColor(255,255,255);
	$pdf->Text(100,68,$invoice_date);
	if($payment_method == 'Bank Transfer'){
		$pdf->Text(173-($pdf->GetStringWidth($payment_method)/2),68,strtoupper($payment_method));
	}else{
		$pdf->Text(177-($pdf->GetStringWidth($payment_method)/2),68,strtoupper($payment_method));
	}
	
	$pdf->SetFont('DejaVu','',13);
	$pdf->SetTextColor(55,55,55);
	$pdf->Text(20,107,$label_language_values['service_name']);
	$pdf->Text(135,107,$label_language_values['qty']);
	$pdf->Text(179,107,$label_language_values['price']);
	
	$addondetails_startpoint = 122;
	$pdf->SetFont('DejaVu','',11);
	$pdf->Text(20,118,$service_name);
	$pdf->SetFont('DejaVu','',9);
	foreach($booking_info_details as $book_detail){	
		if($book_detail['unitname'] != "")
		{		
			$pdf->Text(22,$addondetails_startpoint,$book_detail['unitname']);
			$pdf->Text(137,$addondetails_startpoint,$book_detail['methodqty']);
			$pdf->Text(190-$pdf->GetStringWidth($book_detail["service_price"]),$addondetails_startpoint,$book_detail['service_price']);
			$addondetails_startpoint=$addondetails_startpoint+5;	
		}
	}
	
	$addondetails_sttpoint = 0;
	if(!empty($booking_addon_details)){
	$addondetails_sttpoint = $addondetails_startpoint+10;
	$pdf->SetFont('DejaVu','',11);
	$pdf->Text(22,$addondetails_sttpoint-5,"Units");
	$pdf->SetFont('DejaVu','',9);
	
	foreach($booking_addon_details as $booking_addon){	
			$pdf->Text(22,$addondetails_sttpoint,$booking_addon['addonname']);
			$pdf->Text(137,$addondetails_sttpoint,$booking_addon['addonqty']);
			$pdf->Text(190-$pdf->GetStringWidth($booking_addon["addonprice"]),$addondetails_sttpoint,$booking_addon['addonprice']);
			
			$addondetails_sttpoint=$addondetails_sttpoint+5;
	
	}
	}
	
	$pdf->SetFont('DejaVu','',10);
	
	
	if($addondetails_sttpoint==0) {
		$addondetails_sttpoint = $addondetails_startpoint;
	}
	$pdf->Text(155-$pdf->GetStringWidth($label_language_values['sub_total']),$addondetails_sttpoint+5,$label_language_values['sub_total']);
	
	$pdf->Text(155-$pdf->GetStringWidth($label_language_values['coupon_discount']),$addondetails_sttpoint+15,$label_language_values['coupon_discount']);
	$pdf->Text(155-$pdf->GetStringWidth($label_language_values['tax']),$addondetails_sttpoint+20,$label_language_values['tax']);
	
	 $printamount=$general->ld_price_format_for_pdf($payment_amount,$symbol_position,$decimal); 
	 $printtaxes=$general->ld_price_format_for_pdf($payment_taxes,$symbol_position,$decimal);	  
	 $printdiscount='-'.$general->ld_price_format_for_pdf($payment_discount,$symbol_position,$decimal);	
	 $printnetamount=$general->ld_price_format_for_pdf($payment_net_amount,$symbol_position,$decimal);
	   
	$pdf->SetFont('DejaVu','',10);
	$pdf->Text(190-$pdf->GetStringWidth($printamount),$addondetails_sttpoint+5,$printamount);
	$pdf->Text(190-$pdf->GetStringWidth($printdiscount),$addondetails_sttpoint+15,$printdiscount);
	$pdf->Text(190-$pdf->GetStringWidth($printtaxes),$addondetails_sttpoint+20,$printtaxes);
	
	$pdf->SetFont('DejaVu','',13);
	$pdf->SetTextColor(255,255,255);
	$pdf->Text(150-$pdf->GetStringWidth($label_language_values['total']),265,$label_language_values['total']);
	$pdf->Text(188-$pdf->GetStringWidth($printtaxes),265,$printnetamount);

	$pdf->SetFont('DejaVu','',12);
	$pdf->SetTextColor(102,103,102);
	
	$pdf->SetFont('DejaVu','',12);
	$pdf->Text(15,265,$label_language_values['booked_on']." : ");
	/* for booking date and time */
	$book_times;
	if ($time_format == 24) {
		$book_times =  date("H:i", strtotime($bookings[1]));
	} else {
		$book_times = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($bookings[1])));
	}
	$datevar = date($dateformat,strtotime($bookings[1]));
	$pdf->Text($pdf->GetStringWidth(($label_language_values['booked_on']))+15,265,date($dateformat,strtotime($bookings[1])));
	$pdf->Text($pdf->GetStringWidth(($label_language_values['booked_on']))+ $pdf->GetStringWidth(($datevar)) + 18,265,$book_times);
	
	ob_start();
	$pdf->Output("#".$invoice_number.".pdf","D");
?>