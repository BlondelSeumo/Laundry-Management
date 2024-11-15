<?php 
	session_start();
	include(dirname(dirname(dirname(__FILE__)))."/header.php");
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_dummy.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_setting.php');
	if ( is_file(dirname(dirname(dirname(__FILE__))).'/extension/GoogleCalendar/google-api-php-client/src/Google_Client.php')){
		require_once dirname(dirname(dirname(__FILE__))).'/extension/GoogleCalendar/google-api-php-client/src/Google_Client.php';
	}
	include(dirname(dirname(dirname(__FILE__)))."/objects/class_gc_hook.php");
	
	$database = new laundry_db();
	$conn = $database->connect();
	$dummy = new laundry_dummy();
	$dummy->conn = $conn;
	
	$gc_hook = new laundry_gcHook();
	$gc_hook->conn = $conn;
	
	$setting = new laundry_setting();
	$setting->conn = $conn;
	
	$s1 = new laundry_dummy();
	$s1->conn = $conn;
	
if(isset($_POST['add_sample_data'])){
/*===================================== add first services ========================================*/
		$sample_data_status = $setting->get_option('ld_sample_data_status');
		$secondary_color = $setting->get_option('ld_primary_color');

		if($sample_data_status!="Y"){
			$s1->s_title = 'Washing';
			$s1->s_description = '<strong style="color:'.$secondary_color.'">Wash & Iron</strong> Wash & Iron ';
			$s1->s_color = '#00a87e';
			$s1->s_image = 'washing.png';
			$s1->s_status = 'E';
			$s1->s_position = '1';
			$s1->s_limit = '10';
			$add_service1 = $s1->add_service();
			
			$s1->s_title = 'Ironing';
			$s1->s_description = '<strong style="color:'.$secondary_color.'">Wash & Iron</strong> Wash & Iron ';
			$s1->s_color = '#d30000';
			$s1->s_image = 'ironing.png';
			$s1->s_status = 'E';
			$s1->s_position = '2';
			$s1->s_limit = '10';
			$add_service2 = $s1->add_service();
			
			$s1->s_title = 'Wash & Iron';
			$s1->s_description = '<strong style="color:'.$secondary_color.'">Wash & Iron</strong> Wash & Iron ';
			$s1->s_color = '#54a9ff';
			$s1->s_image = 'wash_iron.png';
			$s1->s_status = 'E';
			$s1->s_position = '3';
			$s1->s_limit = '10';
			$add_service3 = $s1->add_service();
			
			$s1->s_title = 'Dry Cleaning';
			$s1->s_description = 'We are ready to <strong style="color:'.$secondary_color.'">Dry Cleaning</strong> you can <u>trust!</u>';
			$s1->s_color = '#996600';
			$s1->s_image = 'dry-cleaning.png';
			$s1->s_status = 'E';
			$s1->s_position = '4';
			$s1->s_limit = '10';
			$add_service4 = $s1->add_service();
			
		/*add first unit */
			$s1->smu_units_title = 'Shirt(s)';
			$s1->smu_base_price = '0';
			$s1->smu_minlimit = '1';
			$s1->smu_maxlimit = '10';
			$s1->smu_status = 'E';
			$s1->smu_unit_symbol = '';
			$s1->smu_image = '';
			$s1->smu_predefine_image = 'unit_39670.png';
			$add_services_method_unit1 = $s1->add_services_method_unit();
			
		/*add second unit */
			$s1->smu_units_title = 'Pant(s)';
			$s1->smu_base_price = '0';
			$s1->smu_minlimit = '1';
			$s1->smu_maxlimit = '10';
			$s1->smu_status = 'E';
			$s1->smu_unit_symbol = '';
			$s1->smu_image = '';
			$s1->smu_predefine_image = 'unit_29883.png';
			$add_services_method_unit2 = $s1->add_services_method_unit();
			
		/*add third unit */
			$s1->smu_units_title = 'Tie(s)';
			$s1->smu_base_price = '0';
			$s1->smu_minlimit = '1';
			$s1->smu_maxlimit = '10';
			$s1->smu_status = 'E';
			$s1->smu_unit_symbol = '';
			$s1->smu_image = '';
			$s1->smu_predefine_image = 'unit_71894.png';
			$add_services_method_unit3 = $s1->add_services_method_unit();	
			
		/*add fourth unit */			
			$s1->smu_units_title = 'Jeans';
			$s1->smu_base_price = '0';
			$s1->smu_minlimit = '1';
			$s1->smu_maxlimit = '10';
			$s1->smu_status = 'E';
			$s1->smu_unit_symbol = '';
			$s1->smu_image = '';
			$s1->smu_predefine_image = 'unit_99817.png';
			$add_services_method_unit4 = $s1->add_services_method_unit();	
			
		/*add fifth unit */
			$s1->smu_units_title = 'Blazer';
			$s1->smu_base_price = '0';
			$s1->smu_minlimit = '1';
			$s1->smu_maxlimit = '5';
			$s1->smu_status = 'E';
			$s1->smu_unit_symbol = '';
			$s1->smu_image = '';
			$s1->smu_predefine_image = 'unit_61466.png';
			$add_services_method_unit5 = $s1->add_services_method_unit();
		/*add sixth unit */
			$s1->smu_units_title = 'Suit';
			$s1->smu_base_price = '0';
			$s1->smu_minlimit = '1';
			$s1->smu_maxlimit = '10';
			$s1->smu_status = 'E';
			$s1->smu_unit_symbol = '';
			$s1->smu_image = '';
			$s1->smu_predefine_image = 'unit_98252.png';
			$add_services_method_unit6 = $s1->add_services_method_unit();
			
			/* First Service */
			$s1->a_r_service_id = $add_service1;
			$s1->a_r_service_unit_id = $add_services_method_unit1;
			$s1->a_r_price = "4";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service1;
			$s1->a_r_service_unit_id = $add_services_method_unit2;
			$s1->a_r_price = "5";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service1;
			$s1->a_r_service_unit_id = $add_services_method_unit3;
			$s1->a_r_price = "1";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service1;
			$s1->a_r_service_unit_id = $add_services_method_unit4;
			$s1->a_r_price = "5";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service1;
			$s1->a_r_service_unit_id = $add_services_method_unit5;
			$s1->a_r_price = "6";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service1;
			$s1->a_r_service_unit_id = $add_services_method_unit6;
			$s1->a_r_price = "7";
			$s1->add_services_article_price();
			
			/* Second Service */
			$s1->a_r_service_id = $add_service2;
			$s1->a_r_service_unit_id = $add_services_method_unit1;
			$s1->a_r_price = "2";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service2;
			$s1->a_r_service_unit_id = $add_services_method_unit2;
			$s1->a_r_price = "2";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service2;
			$s1->a_r_service_unit_id = $add_services_method_unit3;
			$s1->a_r_price = "1";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service2;
			$s1->a_r_service_unit_id = $add_services_method_unit4;
			$s1->a_r_price = "3";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service2;
			$s1->a_r_service_unit_id = $add_services_method_unit5;
			$s1->a_r_price = "4";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service2;
			$s1->a_r_service_unit_id = $add_services_method_unit6;
			$s1->a_r_price = "5";
			$s1->add_services_article_price();
			
			/* Third Service */
			$s1->a_r_service_id = $add_service3;
			$s1->a_r_service_unit_id = $add_services_method_unit1;
			$s1->a_r_price = "5";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service3;
			$s1->a_r_service_unit_id = $add_services_method_unit2;
			$s1->a_r_price = "6";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service3;
			$s1->a_r_service_unit_id = $add_services_method_unit3;
			$s1->a_r_price = "1.5";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service3;
			$s1->a_r_service_unit_id = $add_services_method_unit4;
			$s1->a_r_price = "7";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service3;
			$s1->a_r_service_unit_id = $add_services_method_unit5;
			$s1->a_r_price = "8";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service3;
			$s1->a_r_service_unit_id = $add_services_method_unit6;
			$s1->a_r_price = "10";
			$s1->add_services_article_price();
			
			/* Fourth Service */
			$s1->a_r_service_id = $add_service4;
			$s1->a_r_service_unit_id = $add_services_method_unit1;
			$s1->a_r_price = "10";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service4;
			$s1->a_r_service_unit_id = $add_services_method_unit2;
			$s1->a_r_price = "12";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service4;
			$s1->a_r_service_unit_id = $add_services_method_unit3;
			$s1->a_r_price = "3";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service4;
			$s1->a_r_service_unit_id = $add_services_method_unit4;
			$s1->a_r_price = "14";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service4;
			$s1->a_r_service_unit_id = $add_services_method_unit5;
			$s1->a_r_price = "16";
			$s1->add_services_article_price();
			
			$s1->a_r_service_id = $add_service4;
			$s1->a_r_service_unit_id = $add_services_method_unit6;
			$s1->a_r_price = "20";
			$s1->add_services_article_price();
			
/************************** Add Off Day *****************************/
			$dummy->od_lastmodify = date('Y-m-d H:i:s');
			$dummy->od_off_date = date('Y-m-d', strtotime(' +5 day'));
			$add_off_days = $dummy->add_off_days();
			
			/*============ Add bookings ============*/
			$dummy->u_user_pwd = md5('12345678');
			$dummy->u_first_name = ucwords('John');
			$dummy->u_last_name = ucwords('Doe');
			$dummy->u_user_email = 'johndoe@example.com';
			$dummy->u_phone = '+100000000000';
			$dummy->u_address = 'Perrine, USA';
			$dummy->u_zip = '90001';
			$dummy->u_city = ucwords('Perrine');
			$dummy->u_state = ucwords('USA');
			$dummy->u_notes = 'Happy Booking';
			$dummy->u_status = 'E';
			$dummy->u_usertype = serialize(array('client'));
			$dummy->u_contact_status = 'Please call me';
			$add_user = $dummy->add_users();
		
		if($add_user){
			/* insert into bookings table */
			$dummy->b_order_id = '999';
			$dummy->b_client_id = $add_user;
			$dummy->b_order_date = date('Y-m-d H:i:s');
			$dummy->b_booking_delivery_date_time_start = date('Y-m-d', strtotime(' +6 day'))." 12:00:00";
			$dummy->b_booking_delivery_date_time_end = date('Y-m-d', strtotime(' +6 day'))." 14:00:00";
			$dummy->b_booking_pickup_date_time_start = date('Y-m-d', strtotime(' +3 day'))." 10:00:00";
			$dummy->b_booking_pickup_date_time_end = date('Y-m-d', strtotime(' +3 day'))." 12:00:00";
			$dummy->b_show_delivery_date = "E";
			$dummy->b_self_service = "N";
			$dummy->b_service_id = $add_service1;
			$dummy->b_booking_status = 'A';
			$dummy->b_lastmodify = date('Y-m-d H:i:s');
			$dummy->b_read_status = 'U';
			$add_bookings = $dummy->add_bookings();
			
			/* insert into booking_unit table */
			$dummy->bu_order_id = "999";
			$dummy->bu_service_id = $add_service1;
			$dummy->bu_unit_id = "1";
			$dummy->bu_unit_name = "Shirt(s)";
			$dummy->bu_unit_qty = "5";
			$dummy->bu_unit_rate = "20";
			$add_bookings = $dummy->add_booking_units();
			
			/* insert into payments table */
			$dummy->p_order_id = '999';
			$dummy->p_payment_method = ucwords('pay at venue');
			$dummy->p_transaction_id = '';
			$dummy->p_amount = 20;
			$dummy->p_discount = 0;
			$dummy->p_taxes = 10;
			$dummy->p_partial_amount = 0;
			$dummy->p_payment_date = date("Y-m-d H:i:s");
			$dummy->p_lastmodify = date("Y-m-d H:i:s");
			$dummy->p_net_amount = 30;
			$add_payment = $dummy->add_payments();
			
			/* client order info */
			$dummy->oci_order_id = '999';
			$dummy->oci_client_name = ucwords('John').' '.ucwords('Doe');
			$dummy->oci_client_email = 'johndoe@example.com';
			$dummy->oci_client_phone = '+100000000000';
			$dummy->oci_client_personal_info = base64_encode(serialize(array('zip'=>'90001','address'=>'Perrine, USA','city'=>'Perrine','state'=>'USA','notes'=>'Happy Booking','contact_status'=>'Please call me')));
			$add_new_user = $dummy->add_order_client_info();
		}
		
		$dummy_array = array($add_service1,$add_service2,$add_service3,$add_service4,$add_off_days,$add_user,$add_bookings,$add_payment,$add_new_user,$add_services_method_unit1,$add_services_method_unit2,$add_services_method_unit3,$add_services_method_unit4,$add_services_method_unit5,$add_services_method_unit6);
		
		$string_array=implode(',',$dummy_array);
		$dummy->ld_remove_data_array = $string_array;
		$dummy->add_settings();
		
	}
}
else if(isset($_POST['remove_sample_data'])){
	if($gc_hook->gc_purchase_status() == 'exist'){
		echo filter_var($gc_hook->gc_remove_sampledata_booking_hook());
	}
	$dummy->delete_all();
}
?>