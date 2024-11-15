<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "includes.php";  

if($settings->get_option('ld_company_logo') != null && $settings->get_option('ld_company_logo') != ""){
	$business_logo= SITE_URL.'assets/images/services/'.$settings->get_option('ld_company_logo');
	$business_logo_alt= $settings->get_option('ld_company_name');
}else{
	$business_logo= '';
	$business_logo_alt= $settings->get_option('ld_company_name');
}

if (isset($_POST['action']) && $_POST['action'] == 'get_all_services') {

	verifyRequiredParams(array('api_key'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$readall = $objservices -> readall_for_frontend_services();

		$array = array();

		if (mysqli_num_rows($readall) > 0) {

			while ($data = mysqli_fetch_assoc($readall)) {

				foreach($data as $field => $value) {

					if ($data[$field] == '') {

						$data[$field] = null;
						
					}else if($field == "image"){						
						$image = $data[$field];
						$whole_url = SITE_URL."/assets/images/services/".$image;
						$data[$field] = $whole_url;
					}

				}
				
				array_push($array, $data);

			}

			$valid = ['status' => "true", "statuscode" => 200, 'response' => $array];

			setResponse($valid);

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No services found"];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'check_postal_code') {

	verifyRequiredParams(array('api_key', 'postal_code'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$postal_code_list = $objsettings -> get_option_postal();

		if ($postal_code_list == '') {

			$response = ['status' => "false", "statuscode" => 404, 'response' => "Postal code not found"];

			setResponse($response);

		} else {

			$res = explode(',', strtolower($postal_code_list));

			$check = 1;

			$p_code = strtolower($_POST['postal_code']);

			for ($i = 0; $i <= (count($res) - 1); $i++) {

				if ($res[$i] == $p_code) {

					$j = 10;

					$response = ['status' => "true", "statuscode" => 200, 'response' => "Postal code found"];

					setResponse($response);

					break;

				}

				elseif(substr($p_code, 0, strlen($res[$i])) === $res[$i]) {

					$j = 10;

					$response = ['status' => "true", "statuscode" => 200, 'response' => "Postal code found"];

					setResponse($response);

					break;

				} else {

					$j = 20;

				}

			}

			if ($j == 20) {

				$response = ['status' => "false", "statuscode" => 404, 'response' => "Postal code not found"];

				setResponse($response);

			}

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

/* ----------------created by arshad-------------------- */
elseif(isset($_POST['action']) && $_POST['action'] == 'get_units_of_services_method') {

	verifyRequiredParams(array('api_key'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$unt_values = $objservice_method_unit -> get_all_units();
		
		if (mysqli_num_rows($unt_values) > 0) {
			
			$array = array();
			while ($unit_value = mysqli_fetch_assoc($unt_values)) {
				$new['type']=$settings->get_option('ld_tax_vat_type');
				$new['value']=$settings->get_option('ld_tax_vat_value'); 
				$unit_value['tax']=$new; 
				array_push($array, $unit_value);
			}
			
			$response = ['status' => "true", "statuscode" => 200, 'response' => $array];
			setResponse($response);

		} else {

			$response = ['status' => "false",'no_of_dropdown' => 0, "statuscode" => 404, 'response' => "No units available"];

			setResponse($response);

		}

	} else {

		$invalid = ['status' => "false", 'no_of_dropdown' => 0, "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'check_login') {

	verifyRequiredParams(array('api_key', 'email', 'password'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$user -> existing_username = trim(strip_tags(mysqli_real_escape_string($conn, $_POST['email'])));

		$user -> existing_password = md5($_POST['password']);

		$existing_login = $user -> check_login_process();

		$array = array();

		if (mysqli_num_rows($existing_login) == 0) {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Incorrect Email Address or Password"];

			setResponse($invalid);

		} else {

			$data = mysqli_fetch_assoc($existing_login);

			if (isset($data['usertype'])) {

				$res = unserialize($data['usertype']);

				$data['usertype'] = $res[0];

				$data['fullname'] = $data['first_name'].

				" ".$data['last_name'];

			}

			if (isset($data['role'])) {

				$data['usertype'] = $data['role'];

				$data['user_email'] = $data['email'];

			}

			$valid = ['status' => "true", "statuscode" => 200, 'response' => $data];

			setResponse($valid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}


elseif(isset($_POST['action']) && $_POST['action'] == 'loading') {

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$existing_login = $user -> get_data();

		$array = array();

		if (mysqli_num_rows($existing_login) == 0) {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Incorrect Email Address or Password"];

			setResponse($invalid);

		} else {

			$data = mysqli_fetch_assoc($existing_login);

			$valid = ['status' => "true", "statuscode" => 200, 'response' => $data];

			setResponse($valid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'get_user_appointments_list') {

	verifyRequiredParams(array('api_key', 'user_id'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		if ($_POST['user_type'] == "client") {
			$limit = 5;
			$page = $_POST['page'];
			$offset = $limit * $page;
			
			$objuserdetails -> id = $_POST['user_id'];
			$objuserdetails -> limit = $limit;
			$objuserdetails -> offset = $offset;
			$details = $objuserdetails -> get_user_details();
			
			$array = array();

			if (mysqli_num_rows($details) == 0) {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No appointments found"];

				setResponse($invalid);

			} else {

				while ($data = mysqli_fetch_assoc($details)) {
					

					if ($data['staff_ids'] != '') {

						$staff_names = '';

						$exploded_staff_ids = explode(',', $data['staff_ids']);

						$i = 1;

						foreach($exploded_staff_ids as $id) {

							$objadmin -> id = $id;

							$staffdata = $objadmin -> readone();

							if ($i = 1) {

								$staff_names.= $staffdata['fullname'];

							} else {

								$staff_names.= ', '.$staffdata['fullname'];

							}

							$i++;

						}

						$data['staff_names'] = $staff_names;

					}

					foreach($data as $field => $value) {

						if ($data[$field] == '') {

							$data[$field] = null;

						}

					}

					$units = null;

					$Servicedname = null;

					$hh = $booking -> get_booking_units_from_order_api($data['order_id']);
					

					$count_units = mysqli_num_rows($hh);
					
					$hh1 = $booking -> get_booking_units_from_order_api($data['order_id']);
					
					if ($count_units > 0) {
						
						
						while ($jj = mysqli_fetch_array($hh1)) {
							

							if ($units == null) {

								$units = $jj['unit_name'].

								"-".$jj['unit_qty'];

							} else {

								$units = $units.

								",".$jj['unit_name'].

								"-".$jj['unit_qty'];

							}

							$Servicedname = $jj['service_id']; 

						}

					}
					/*
										$addons = null;

										$hh = $booking -> get_addons_ofbookings($data['order_id']);

										while ($jj = mysqli_fetch_array($hh)) {

												if ($addons == null) {

														$addons = $jj['addon_service_name'].

														"-".$jj['addons_service_qty'];

												} else {

														$addons = $addons.

														",".$jj['addon_service_name'].

														"-".$jj['addons_service_qty'];

												}

										}
										$data['addons'] = $addons; */
					$data['Service_name'] = $Servicedname;
					$data['units'] = $units;
					

					$booking_date_timestamp = strtotime($data['booking_pickup_date_time_start']);

					$data['appointment_date'] = date('l, d-M-Y', $booking_date_timestamp);

					$data['appointment_time'] = date('h:i A', $booking_date_timestamp);
					

					array_push($array, $data);

				}

				$valid = ['status' => "true", "statuscode" => 200, 'response' => $array];
				
				setResponse($valid);

			}

		}

		elseif($_POST['user_type'] == "staff") {

			$objuserdetails -> id = $_POST['user_id'];

			$details = $objuserdetails -> get_staff_details_api();
			

			$array = array();

			if (mysqli_num_rows($details) == 0) {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No appointments found"];

				setResponse($invalid);

			} else {

				while ($data = mysqli_fetch_assoc($details)) {
					

					if ($data['staff_ids'] != '') {

						$staff_names = '';

						$exploded_staff_ids = explode(',', $data['staff_ids']);

						$i = 1;

						foreach($exploded_staff_ids as $id) {

							$objadmin -> id = $id;

							$staffdata = $objadmin -> readone();

							if ($i = 1) {

								$staff_names.= $staffdata['fullname'];

							} else {

								$staff_names.= ', '.$staffdata['fullname'];

							}

							$i++;

						}

						$data['staff_names'] = $staff_names;

					}

					foreach($data as $field => $value) {

						if ($data[$field] == '') {

							$data[$field] = null;

						}

					}

					$units = null;

					$methodname = null;

					$hh = $booking -> get_booking_units_from_order_api($data['order_id']);
					

					$count_methods = mysqli_num_rows($hh);

					$hh1 = $booking -> get_booking_units_from_order_api($data['order_id']);
					$pay_method = $payment -> readone_payment_details_api($data['order_id']);
					$data['payment_method']=$pay_method['payment_method'];
					
					
					$oredre_user_info = $order_client_info -> readone_order_client_api($data['order_id']);
					
					/* $client_info=unserialize($oredre_user_info[5]); */
					$client_info=unserialize(base64_decode(($oredre_user_info[5])));
					/* print_r($client_info);
										exit */;
					$data['client_info_data']=$client_info;

					if ($count_methods > 0) {

						while ($jj = mysqli_fetch_array($hh1)) {
							

							if ($units == null) {

								$units = $jj['unit_name'].

								"-".$jj['unit_qty'];

							} else {

								$units = $units.

								",".$jj['unit_name'].

								"-".$jj['unit_qty'];

							}

							$methodname = $jj['method_title'];
							$Servicedname = $jj['service_id']; 

						}

					}
					

					$data['service_name'] = $Servicedname;

					$data['units'] = $units;

					$data['addons'] = $addons;

					$booking_date_timestamp = strtotime($data['booking_date_time']);

					$data['appointment_date'] = date('l, d-M-Y', $booking_date_timestamp);

					$data['appointment_time'] = date('h:i A', $booking_date_timestamp);
					
					

					array_push($array, $data);

				}

				$valid = ['status' => "true", "statuscode" => 200, 'response' => $array];

				setResponse($valid);

			}

		}


	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'get_appointment_detail') {

	verifyRequiredParams(array('api_key', 'order_id'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$appointment_detail = array();

		$order_id = $_POST['order_id'];

		$book_detail = $booking -> get_booking_details_appt_api($order_id);

		$appointment_detail['id'] = $order_id;

		$appointment_detail['booking_price'] = $book_detail[2];

		$appointment_detail['start_date'] = date('d-m-Y', strtotime($book_detail[1]));

		$appointment_detail['start_time'] = date("H:i", strtotime($book_detail[1]));
		$appointment_detail['booking_date_time'] = $book_detail[1];
		$units = '';

		$methodname = '';

		$hh = $booking -> get_booking_units_from_order_api($order_id);

		$count_units = mysqli_num_rows($hh);

		$hh1 = $booking -> get_booking_units_from_order_api($order_id);

		if ($count_units > 0) {

			while ($jj = mysqli_fetch_array($hh1)) {

				if ($units == null) {
					$units = $jj['unit_name'].
					"-".$jj['unit_qty'];
				} else {
					$units = $units.
					",".$jj['unit_name'].
					"-".$jj['unit_qty'];
				}

				$Servicedname = $jj['service_id']; 

			}

		}

		
		$appointment_detail['method_title'] = $methodname;

		$appointment_detail['unit_title'] = $units;

		$appointment_detail['service_title'] = $book_detail[8];

		$appointment_detail['gc_event_id'] = $book_detail[9];

		$appointment_detail['gc_staff_event_id'] = $book_detail['gc_staff_event_id'];

		$staff_names = '';

		if ($book_detail['staff_ids'] != '') {

			$exploded_staff_ids = explode(',', $book_detail['staff_ids']);

			$i = 1;

			foreach($exploded_staff_ids as $id) {

				$objadmin -> id = $id;

				$staffdata = $objadmin -> readone();

				if ($i = 1) {

					$staff_names.= $staffdata['fullname'];

				} else {

					$staff_names.= ', '.$staffdata['fullname'];

				}

				$i++;

			}

		}

		$appointment_detail['staff_names'] = $staff_names;

		$appointment_detail['staff_ids'] = $book_detail['staff_ids'];

		$ccnames = explode(" ", $book_detail[3]);

		$cnamess = array_filter($ccnames);

		$client_name = array_values($cnamess);

		if (sizeof($client_name) > 0) {

			if ($client_name[0] != "") {

				$client_first_name = $client_name[0];

			} else {

				$client_first_name = "";

			}

			if (isset($client_name[1]) && $client_name[1] != "") {

				$client_last_name = $client_name[1];

			} else {

				$client_last_name = "";

			}

		} else {

			$client_first_name = "";

			$client_last_name = "";

		}

		if ($client_first_name != "" || $client_last_name != "") {

			$appointment_detail['client_name'] = $client_first_name.

			" ".$client_last_name;

		} else {

			$appointment_detail['client_name'] = "";

		}

		$fetch_phone = strlen($book_detail[7]);

		if ($fetch_phone >= 6) {

			$appointment_detail['client_phone'] = $book_detail[7];

		} else {

			$appointment_detail['client_phone'] = "";

		}

		$appointment_detail['client_email'] = $book_detail[4];

		$temppp = unserialize(base64_decode($book_detail[5]));

		$tem = str_replace('\\', '', $temppp);

		if ($tem['notes'] != "") {

			$finalnotes = $tem['notes'];

		} else {

			$finalnotes = "";

		}

		if ($tem['address'] != "" || $tem['city'] != "" || $tem['zip'] != "" || $tem['state'] != "") {

			$app_address = "";

			$app_city = "";

			$app_zip = "";

			$app_state = "";

			if ($tem['address'] != "") {

				$app_address = $tem['address'].

				", ";

			}

			if ($tem['city'] != "") {

				$app_city = $tem['city'].

				", ";

			}

			if ($tem['zip'] != "") {

				$app_zip = $tem['zip'].

				", ";

			}

			if ($tem['state'] != "") {

				$app_state = $tem['state'];

			}

			$temper = $app_address.$app_city.$app_zip.$app_state;

			$temss = rtrim($temper, ", ");

			$appointment_detail['client_address'] = $temss;

		} else {

			$appointment_detail['client_address'] = "";

		}

		
		

		$appointment_detail['client_notes'] = $finalnotes;

		$appointment_detail['contact_status'] = $tem['contact_status'];

		$appointment_detail['payment_type'] = $book_detail[6];

		$appointment_detail['booking_status'] = $book_detail[0];

		$booking_day = date("Y-m-d", strtotime($book_detail[1]));

		$current_day = date("Y-m-d");

		if ($current_day > $booking_day) {

			$appointment_detail['past'] = 'yes';

		} else {

			$appointment_detail['past'] = 'no';

		}

		$get_staff_services = $objadmin -> readall_staff_booking();

		$booking -> order_id = $order_id;

		$get_staff_assignid = explode(",", $booking -> fetch_staff_of_booking());

		$array = array();

		foreach($appointment_detail as $field => $value) {

			if ($appointment_detail[$field] == '') {

				$appointment_detail[$field] = null;

			}

		}
		array_push($array, $appointment_detail);
		/*  print_r($array);
				exit; */

		$valid = ['status' => "true", "statuscode" => 200, 'response' => $array];

		setResponse($valid);

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'cancel_appointment') {

	verifyRequiredParams(array('api_key', 'order_id', 'cancel_reason'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$id = $order = $_POST['order_id'];

		$gc_event_id = $_POST['gc_event_id'];

		$gc_staff_event_id = $_POST['gc_staff_event_id'];

		$pid = $_POST['pid'];

		$lastmodify = date('Y-m-d H:i:s');

		$cancel_reson_book = $_POST['cancel_reason'];

		$objuserdetails -> update_booking_of_user($order, $cancel_reson_book, $lastmodify);

		$orderdetail = $objdashboard -> getclientorder_api($id);
		
		$clientdetail = $objdashboard -> clientemailsender($id); /* Delete in Google Calendar Start */

		if ($gc_hook -> gc_purchase_status() == 'exist') {

			if ($_POST['gc_event_id'] != 'none' && $_POST['gc_staff_event_id'] != 'none' && $_POST['pid'] != 'none') {

				echo $gc_hook -> gc_cancel_reject_booking_hook();

			}

		} /* Delete in Google Calendar End */ /*$booking_date = date("Y-m-d H:i", strtotime($clientdetail['booking_date_time']));*/

		$admin_company_name = $objsettings -> get_option('ld_company_name');

		$setting_date_format = $objsettings -> get_option('ld_date_picker_date_format');

		$setting_time_format = $objsettings -> get_option('ld_choose_time_format');

		$booking_date = date($setting_date_format, strtotime($clientdetail['booking_pickup_date_time_start']));

		if ($setting_time_format == 12) {

			$booking_time = date("h:i A", strtotime($clientdetail['booking_pickup_date_time_start']));

		} else {

			$booking_time = date("H:i", strtotime($clientdetail['booking_pickup_date_time_start']));

		}

		$company_name = $objsettings -> get_option('ld_email_sender_name');

		$company_email = $objsettings -> get_option('ld_email_sender_address');

		$service_name = $clientdetail['title'];

		if ($admin_email == "") {

			$admin_email = $clientdetail['email'];

		}

		$price = $general -> ld_price_format($orderdetail[2], $symbol_position, $decimal); /* methods */

		$units = $label_language_values['none'];

		$methodname = $label_language_values['none'];
		

		$hh = $booking -> get_booking_units_from_order_api($orderdetail[4]);

		$count_units = mysqli_num_rows($hh);

		$hh1 = $booking -> get_booking_units_from_order_api($orderdetail[4]);

		if ($count_units > 0) {
			
			while ($jj = mysqli_fetch_array($hh1)) {
				

				if ($units == null) {

					$units = $jj['unit_name'].

					"-".$jj['unit_qty'];

				} else {

					$units = $units.

					",".$jj['unit_name'].

					"-".$jj['unit_qty'];

				}

				$Servicedname = $jj['service_id']; 

			}


		} /*Guest User */

		if ($orderdetail[4] == 0) {

			$gc = $objdashboard -> getguestclient($orderdetail[4]);

			$temppp = unserialize(base64_decode($gc[5]));

			$temp = str_replace('\\', '', $temppp);
			
			$client_name = $gc[2];

			$client_email = $gc[3];

			$client_phone = $gc[4];

			$firstname = $client_name;

			$lastname = '';

			$booking_status = $orderdetail[6];
			
			$payment_status = $orderdetail[5];

			$client_address = $temp['address'];

			$client_notes = $temp['notes'];

			$client_status = $temp['contact_status'];

			$client_city = $temp['city'];

			$client_state = $temp['state'];

			$client_zip = $temp['zip'];

		} else /*Registered user */ {

			$c = $objdashboard -> getguestclient($orderdetail[4]);
			
			$temppp = unserialize(base64_decode($c[5]));

			$temp = str_replace('\\', '', $temppp);
			
			$client_phone_no = $c[4];

			$client_phone_length = strlen($client_phone_no);

			if ($client_phone_length > 6) {

				$client_phone = $client_phone_no;

			} else {

				$client_phone = "N/A";

			}

			$client_namess = explode(" ", $c[2]);

			$cnamess = array_filter($client_namess);

			$ccnames = array_values($cnamess);

			if (sizeof($ccnames) > 0) {

				$client_first_name = $ccnames[0];

				if (isset($ccnames[1])) {

					$client_last_name = $ccnames[1];

				} else {

					$client_last_name = '';

				}

			} else {

				$client_first_name = '';

				$client_last_name = '';

			}

			if ($client_first_name == "" && $client_last_name == "") {

				$firstname = "User";

				$lastname = "";

				$client_name = $firstname.

				' '.$lastname;

			}

			elseif($client_first_name != "" && $client_last_name != "") {

				$firstname = $client_first_name;

				$lastname = $client_last_name;

				$client_name = $firstname.

				' '.$lastname;

			}

			elseif($client_first_name != "") {

				$firstname = $client_first_name;

				$lastname = "";

				$client_name = $firstname.

				' '.$lastname;

			}

			elseif($client_last_name != "") {

				$firstname = "";

				$lastname = $client_last_name;

				$client_name = $firstname.

				' '.$lastname;

			}

			$client_notes = $temp['notes'];

			if ($client_notes == "") {

				$client_notes = "N/A";

			}

			$client_status = $temp['contact_status'];

			if ($client_status == "") {

				$client_status = "N/A";

			}

			$client_email = $c[3];

			$payment_status = $orderdetail[5];

			$client_address = $temp['address'];

			$client_city = $temp['city'];

			$client_state = $temp['state'];

			$client_zip = $temp['zip'];

		}

		$searcharray = array('{{service_name}}', '{{booking_date}}', '{{business_logo}}', '{{business_logo_alt}}', '{{client_name}}', '{{Servicedname}}', '{{units}}', '{{client_email}}', '{{phone}}', '{{payment_method}}', '{{vaccum_cleaner_status}}', '{{parking_status}}', '{{notes}}', '{{contact_status}}', '{{address}}', '{{price}}', '{{admin_name}}', '{{firstname}}', '{{lastname}}', '{{app_remain_time}}', '{{reject_status}}', '{{company_name}}', '{{booking_time}}', '{{client_city}}', '{{client_state}}', '{{client_zip}}', '{{company_city}}', '{{company_state}}', '{{company_zip}}', '{{company_country}}', '{{company_phone}}', '{{company_email}}', '{{company_address}}', '{{admin_name}}');

		$replacearray = array($service_name, $booking_date, $business_logo, $business_logo_alt, $client_name, $Servicedname, $units, $client_email, $client_phone, $payment_status, $client_notes, $client_status, $client_address, $price, $get_admin_name, $firstname, $lastname, '', '', $admin_company_name, $booking_time, $client_city, $client_state, $client_zip, $company_city, $company_state, $company_zip, $company_country, $company_phone, $company_email, $company_address, $get_admin_name); /* Client template */

		$emailtemplate -> email_subject = "Appointment Cancelled by you";

		$emailtemplate -> user_type = "C";

		$clientemailtemplate = $emailtemplate -> readone_client_email_template_body();

		if ($clientemailtemplate[2] != '') {

			$clienttemplate = base64_decode($clientemailtemplate[2]);

		} else {

			$clienttemplate = base64_decode($clientemailtemplate[3]);

		}

		$subject = $clientemailtemplate[1];

		if ($objsettings -> get_option('ld_client_email_notification_status') == 'Y' && $clientemailtemplate[4] == 'E') {

			$client_email_body = str_replace($searcharray, $replacearray, $clienttemplate);

			if ($objsettings -> get_option('ld_smtp_hostname') != '' && $objsettings -> get_option('ld_email_sender_name') != '' && $objsettings -> get_option('ld_email_sender_address') != '' && $objsettings -> get_option('ld_smtp_username') != '' && $objsettings -> get_option('ld_smtp_password') != '' && $objsettings -> get_option('ld_smtp_port') != '') {

				$mail -> IsSMTP();

			} else {

				$mail -> IsMail();

			}

			$mail -> SMTPDebug = 0;

			$mail -> IsHTML(true);

			$mail -> From = $company_email;

			$mail -> FromName = $company_name;

			$mail -> Sender = $company_email;

			$mail -> AddAddress($client_email, $client_name);

			$mail -> Subject = $subject;

			$mail -> Body = $client_email_body;

			$mail -> send();

			$mail -> ClearAllRecipients();

		} /* Admin Template */

		$emailtemplate -> email_subject = "Appointment Cancelled By Customer";

		$emailtemplate -> user_type = "A";

		$adminemailtemplate = $emailtemplate -> readone_client_email_template_body();

		if ($adminemailtemplate[2] != '') {

			$admintemplate = base64_decode($adminemailtemplate[2]);

		} else {

			$admintemplate = base64_decode($adminemailtemplate[3]);

		}

		$adminsubject = $adminemailtemplate[1];

		if ($objsettings -> get_option('ld_admin_email_notification_status') == 'Y' && $adminemailtemplate[4] == 'E') {

			$admin_email_body = str_replace($searcharray, $replacearray, $admintemplate);

			if ($objsettings -> get_option('ld_smtp_hostname') != '' && $objsettings -> get_option('ld_email_sender_name') != '' && $objsettings -> get_option('ld_email_sender_address') != '' && $objsettings -> get_option('ld_smtp_username') != '' && $objsettings -> get_option('ld_smtp_password') != '' && $objsettings -> get_option('ld_smtp_port') != '') {

				$mail_a -> IsSMTP();

			} else {

				$mail_a -> IsMail();

			}

			$mail_a -> SMTPDebug = 0;

			$mail_a -> IsHTML(true);

			$mail_a -> From = $company_email;

			$mail_a -> FromName = $company_name;

			$mail_a -> Sender = $company_email;

			$mail_a -> AddAddress($admin_email, $get_admin_name);

			$mail_a -> Subject = $adminsubject;

			$mail_a -> Body = $admin_email_body;

			$mail_a -> send();

			$mail -> ClearAllRecipients();

		} /*SMS SENDING CODE*/ /*GET APPROVED SMS TEMPLATE*/ /* TEXTLOCAL CODE */

		if ($objsettings -> get_option('ld_sms_textlocal_status') == "Y") {

			if ($objsettings -> get_option('ld_sms_textlocal_send_sms_to_client_status') == "Y") {

				$template = $objdashboard -> gettemplate_sms("CC", 'C');

				$phone = $client_phone;

				if ($template[4] == "E") {

					if ($template[2] == "") {

						$message = base64_decode($template[3]);

					} else {

						$message = base64_decode($template[2]);

					}

				}

				$message = str_replace($searcharray, $replacearray, $message);

				$data = "username=".$textlocal_username.

				"&hash=".$textlocal_hash_id.

				"&message=".$message.

				"&numbers=".$phone.

				"&test=0";

				$ch = curl_init('http://api.textlocal.in/send/?');

				curl_setopt($ch, CURLOPT_POST, true);

				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$result = curl_exec($ch);

				curl_close($ch);

			}

			if ($objsettings -> get_option('ld_sms_textlocal_send_sms_to_admin_status') == "Y") {

				$template = $objdashboard -> gettemplate_sms("CC", 'A');

				$phone = $objsettings -> get_option('ld_sms_textlocal_admin_phone');

				if ($template[4] == "E") {

					if ($template[2] == "") {

						$message = base64_decode($template[3]);

					} else {

						$message = base64_decode($template[2]);

					}

				}

				$message = str_replace($searcharray, $replacearray, $message);

				$data = "username=".$textlocal_username.

				"&hash=".$textlocal_hash_id.

				"&message=".$message.

				"&numbers=".$phone.

				"&test=0";

				$ch = curl_init('http://api.textlocal.in/send/?');

				curl_setopt($ch, CURLOPT_POST, true);

				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$result = curl_exec($ch);

				curl_close($ch);

			}

		} /*PLIVO CODE*/

		if ($objsettings -> get_option('ld_sms_plivo_status') == "Y") {

			$auth_id = $objsettings -> get_option('ld_sms_plivo_account_SID');

			$auth_token = $objsettings -> get_option('ld_sms_plivo_auth_token');

			$p = new Plivo\ RestAPI($auth_id, $auth_token, '', '');

			$plivo_sender_number = $objsettings -> get_option('ld_sms_plivo_sender_number');

			$twilio_sender_number = $objsettings -> get_option('ld_sms_twilio_sender_number');

			if ($objsettings -> get_option('ld_sms_plivo_send_sms_to_client_status') == "Y") {

				$template = $objdashboard -> gettemplate_sms("CC", 'C');

				$phone = $client_phone;

				if ($template[4] == "E") {

					if ($template[2] == "") {

						$message = base64_decode($template[3]);

					} else {

						$message = base64_decode($template[2]);

					}

					$client_sms_body = str_replace($searcharray, $replacearray, $message); /* MESSAGE SENDING CODE THROUGH PLIVO */

					$params = array('src' => $plivo_sender_number, 'dst' => $phone, 'text' => $client_sms_body, 'method' => 'POST');

					$response = $p -> send_message($params); /* MESSAGE SENDING CODE ENDED HERE*/

				}

			}

			if ($objsettings -> get_option('ld_sms_plivo_send_sms_to_admin_status') == "Y") {

				$template = $objdashboard -> gettemplate_sms("CC", 'A');

				$phone = $admin_phone_plivo;

				if ($template[4] == "E") {

					if ($template[2] == "") {

						$message = base64_decode($template[3]);

					} else {

						$message = base64_decode($template[2]);

					}

					$client_sms_body = str_replace($searcharray, $replacearray, $message);

					$params = array('src' => $plivo_sender_number, 'dst' => $phone, 'text' => $client_sms_body, 'method' => 'POST');

					$response = $p -> send_message($params); /* MESSAGE SENDING CODE ENDED HERE*/

				}

			}

		}

		if ($objsettings -> get_option('ld_sms_twilio_status') == "Y") {

			if ($objsettings -> get_option('ld_sms_twilio_send_sms_to_client_status') == "Y") {

				$template = $objdashboard -> gettemplate_sms("CC", 'C');

				$phone = $client_phone;

				if ($template[4] == "E") {

					if ($template[2] == "") {

						$message = base64_decode($template[3]);

					} else {

						$message = base64_decode($template[2]);

					}

					$client_sms_body = str_replace($searcharray, $replacearray, $message); /*TWILIO CODE*/

					$message = $twilliosms -> account -> messages -> create(array("From" => $twilio_sender_number, "To" => $phone, "Body" => $client_sms_body));

				}

			}

			if ($objsettings -> get_option('ld_sms_twilio_send_sms_to_admin_status') == "Y") {

				$template = $objdashboard -> gettemplate_sms("CC", 'A');

				$phone = $admin_phone_twilio;

				if ($template[4] == "E") {

					if ($template[2] == "") {

						$message = base64_decode($template[3]);

					} else {

						$message = base64_decode($template[2]);

					}

					$client_sms_body = str_replace($searcharray, $replacearray, $message); /*TWILIO CODE*/

					$message = $twilliosms -> account -> messages -> create(array("From" => $twilio_sender_number, "To" => $phone, "Body" => $client_sms_body));

				}

			}

		}

		if ($objsettings -> get_option('ld_nexmo_status') == "Y") {

			if ($objsettings -> get_option('ld_sms_nexmo_send_sms_to_client_status') == "Y") {

				$template = $objdashboard -> gettemplate_sms("CC", 'C');

				$phone = $client_phone;

				if ($template[4] == "E") {

					if ($template[2] == "") {

						$message = base64_decode($template[3]);

					} else {

						$message = base64_decode($template[2]);

					}

					$ct_nexmo_text = str_replace($searcharray, $replacearray, $message);

					$res = $nexmo_client -> send_nexmo_sms($phone, $ct_nexmo_text);

				}

			}

			if ($objsettings -> get_option('ld_sms_nexmo_send_sms_to_admin_status') == "Y") {

				$template = $objdashboard -> gettemplate_sms("CC", 'A');

				$phone = $objsettings -> get_option('ld_sms_nexmo_admin_phone_number');

				if ($template[4] == "E") {

					if ($template[2] == "") {

						$message = base64_decode($template[3]);

					} else {

						$message = base64_decode($template[2]);

					}

					$ct_nexmo_text = str_replace($searcharray, $replacearray, $message);

					$res = $nexmo_admin -> send_nexmo_sms($phone, $ct_nexmo_text);

				}

			}

		} /*SMS SENDING CODE END*/

		$valid = ['status' => "true", "statuscode" => 200, 'response' => "Your appointment cancelled successfully"];

		setResponse($valid);

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'check_couponcode') {

	verifyRequiredParams(array('api_key', 'coupon_code'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$coupon -> coupon_code = $_POST['coupon_code'];

		$result = $coupon -> checkcode();
		
		if ($result) {

			$coupon_exp_date = strtotime($result['coupon_expiry']);

			$today = date("Y-m-d");

			$curr_date = strtotime($today);

			if ($result['coupon_used'] < $result['coupon_limit'] && $curr_date <= $coupon_exp_date) {

				$array = array();

				foreach($result as $field => $value) {

					if (is_numeric($field)) {

						unset($result[$field]);

					} else {

						if ($result[$field] == '') {

							$result[$field] = null;

						}

					}

				}

				array_push($array, $result);

				$valid = ['status' => "true", "statuscode" => 200, 'response' => $array[0]];

				setResponse($valid);

			} else {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Coupon code expired"];

				setResponse($invalid);

			}

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Invalid coupon code"];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'get_setting') {

	verifyRequiredParams(array('api_key', 'option_name'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$array = array();

		$arr = array();

		$arr['option_value'] = $objsettings -> get_option($_POST['option_name']);

		array_push($array, $arr);

		$valid = ['status' => "true", "statuscode" => 200, 'response' => $array];

		setResponse($valid);

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'get_slots') {

	verifyRequiredParams(array('api_key', 'selected_date', 'staff_id'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$selected_date = $_POST['selected_date'];

		$staff_id = $_POST['staff_id'];

		$t_zone_value = $objsettings -> get_option('ld_timezone');

		$server_timezone = date_default_timezone_get();

		if (isset($t_zone_value) && $t_zone_value != '') {

			$offset = $first_step -> get_timezone_offset($server_timezone, $t_zone_value);

			$timezonediff = $offset / 3600;

		} else {

			$timezonediff = 0;

		}

		if (is_numeric(strpos($timezonediff, '-'))) {

			$timediffmis = str_replace('-', '', $timezonediff) * 60;

			$currDateTime_withTZ = strtotime("-".$timediffmis.

			" minutes", strtotime(date('Y-m-d H:i:s')));

		} else {

			$timediffmis = str_replace('+', '', $timezonediff) * 60;

			$currDateTime_withTZ = strtotime("+".$timediffmis.

			" minutes", strtotime(date('Y-m-d H:i:s')));

		}

		$select_time = date('Y-m-d', strtotime($selected_date));

		$start_date = date($select_time, $currDateTime_withTZ); /** Get Google Calendar Bookings **/

		$providerCalenderBooking = array();

		if ($gc_hook -> gc_purchase_status() == 'exist') {

			$gc_hook -> google_cal_TwoSync_hook();

		} /** Get Google Calendar Bookings **/

		$time_interval = $objsettings -> get_option('ld_time_interval');

		$time_slots_schedule_type = $objsettings -> get_option('ld_time_slots_schedule_type');

		$advance_bookingtime = $objsettings -> get_option('ld_min_advance_booking_time');

		$ct_service_padding_time_before = $objsettings -> get_option('ld_service_padding_time_before');

		$ct_service_padding_time_after = $objsettings -> get_option('ld_service_padding_time_after');

		$booking_padding_time = $objsettings -> get_option('ld_booking_padding_time');

		$time_schedule = $first_step -> get_day_time_slot_by_provider_id($time_slots_schedule_type, $start_date, $time_interval, $advance_bookingtime, $ct_service_padding_time_before, $ct_service_padding_time_after, $timezonediff, $booking_padding_time, $staff_id);

		$allbreak_counter = 0;

		$allofftime_counter = 0;

		$slot_counter = 0;

		$arr_of_slots = array();

		$week_day_avail_count = $week_day_avail -> get_data_for_front_cal();

		if (mysqli_num_rows($week_day_avail_count) > 0) {

			if ($time_schedule['off_day'] != true && isset($time_schedule['slots']) && sizeof($time_schedule['slots']) > 0 && $allbreak_counter != sizeof($time_schedule['slots']) && $allofftime_counter != sizeof($time_schedule['slots'])) {

				foreach($time_schedule['slots'] as $slot) { /* Checking in GC booked Slots START */

					$curreslotstr = strtotime(date(date('Y-m-d H:i:s', strtotime($select_time.

					' '.$slot)), $currDateTime_withTZ));

					$gccheck = 'N';

					if (sizeof($providerCalenderBooking) > 0) {

						for ($i = 0; $i < sizeof($providerCalenderBooking); $i++) {

							if ($curreslotstr >= $providerCalenderBooking[$i]['start'] && $curreslotstr < $providerCalenderBooking[$i]['end']) {

								$gccheck = 'Y';

							}

						}

					} /* Checking in GC booked Slots END */

					$ifbreak = 'N'; /* Need to check if the appointment slot come under break time. */

					foreach($time_schedule['breaks'] as $daybreak) {

						if (strtotime($slot) >= strtotime($daybreak['break_start']) && strtotime($slot) < strtotime($daybreak['break_end'])) {

							$ifbreak = 'Y';

						}

					} /* if yes its break time then we will not show the time for booking  */

					if ($ifbreak == 'Y') {

						$allbreak_counter++;

						continue;

					}

					$ifofftime = 'N';

					foreach($time_schedule['offtimes'] as $offtime) {

						if (strtotime($selected_date.

									' '.$slot) >= strtotime($offtime['offtime_start']) && strtotime($selected_date.

									' '.$slot) < strtotime($offtime['offtime_end'])) {

							$ifofftime = 'Y';

						}

					} /* if yes its offtime time then we will not show the time for booking  */

					if ($ifofftime == 'Y') {

						$allofftime_counter++;

						continue;

					}

					$complete_time_slot = mktime(date('H', strtotime($slot)), date('i', strtotime($slot)), date('s', strtotime($slot)), date('n', strtotime($time_schedule['date'])), date('j', strtotime($time_schedule['date'])), date('Y', strtotime($time_schedule['date'])));

					if ($objsettings -> get_option('ld_hide_faded_already_booked_time_slots') == 'on' && (in_array($complete_time_slot, $time_schedule['booked'])) || $gccheck == 'Y') {

						continue;

					}

					if ((in_array($complete_time_slot, $time_schedule['booked']) || $gccheck == 'Y') && ($objsettings -> get_option('ld_allow_multiple_booking_for_same_timeslot_status') != 'Y')) {} else {

						if ($objsettings -> get_option('ld_time_format') == 24) {

							$slot_time = date("H:i", strtotime($slot));

							$slotdbb_time = date("H:i", strtotime($slot));

							$ct_time_selected = date("H:i", strtotime($slot));

						} else {

							$slot_time = date("h:i A", strtotime($slot));

							$slotdbb_time = date("H:i", strtotime($slot));

							$ct_time_selected = date("h:iA", strtotime($slot));

						} 
						$start_time = date("H:i", strtotime($slot));
						$end_time = date("H:i",strtotime("+".$time_interval." minutes", strtotime($slot)));
						array_push($arr_of_slots, $start_time."   to   ".$end_time);

					}

					$slot_counter++;

				}

				if (sizeof($arr_of_slots) > 0) {

					$array = array();

					array_push($array, $arr_of_slots);

					$valid = ['status' => "true", "statuscode" => 200, 'response' => $arr_of_slots];

					setResponse($valid);

				}

				if ($allbreak_counter != 0 && $allofftime_counter != 0) {

					$invalid = ['status' => "false", "statuscode" => 404, 'response' => "None of time slot available please check another dates"];

					setResponse($invalid);

				}

				if ($allbreak_counter == sizeof($time_schedule['slots']) && sizeof($time_schedule['slots']) != 0) {

					$invalid = ['status' => "false", "statuscode" => 404, 'response' => "None of time slot available please check another dates"];

					setResponse($invalid);

				}

				if ($allofftime_counter > sizeof($time_schedule['offtimes']) && sizeof($time_schedule['slots']) == $allofftime_counter) {

					$invalid = ['status' => "false", "statuscode" => 404, 'response' => "None of time slot available please check another dates"];

					setResponse($invalid);

				}

			} else {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "None of time slot available please check another dates"];

				setResponse($invalid);

			}

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Availability is not configured from admin side"];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'add_customer') {

	verifyRequiredParams(array('api_key', 'email', 'password', 'first_name', 'last_name'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$user -> existing_username = $_POST['email'];

		$user -> existing_password = md5($_POST['password']);

		$existing_login = $user -> check_login();

		if ($existing_login) {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Customer already exist"];

			setResponse($invalid);

		} else {

			$phone = "";if(isset($_POST['phone'])){$phone = $_POST['phone'];}

			$address = "";if(isset($_POST['address'])){$address = $_POST['address'];}

			$zipcode = "";if(isset($_POST['zipcode'])){$zipcode = $_POST['zipcode'];}

			$city = "";if(isset($_POST['city'])){$city = $_POST['city'];}

			$state = "";if(isset($_POST['state'])){$state = $_POST['state'];}

			$user -> user_pwd = md5($_POST['password']);

			$user -> first_name = ucwords($_POST['first_name']);

			$user -> last_name = ucwords($_POST['last_name']);

			$user -> user_email = $_POST['email'];

			$user -> phone = $phone;

			$user -> address = $address;

			$user -> zip = $zipcode;

			$user -> city = ucwords($city);

			$user -> state = ucwords($state);

			$user -> notes = '';

			$user -> p_status = 'N';

			$user -> status = 'E';

			$user -> usertype = serialize(array('client'));

			$user -> contact_status = '';

			$add_user = $user -> add_user();

			if ($add_user) {

				$valid = ['status' => "true", "statuscode" => 200, 'response' => "Customer created successfully"];

				setResponse($valid);

			} else {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Error occurred please try again"];

				setResponse($invalid);

			}

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'book_appointment') { /* cart_detail */

	verifyRequiredParams(array('api_key', 'zipcode', 'city', 'state', 'staff_id', 'booking_pickup_date_time_start','booking_pickup_date_time_end','booking_delivery_date_time_start','booking_delivery_date_time_end','service_id', 'payment_method','user_type', 'sub_total', 'discount', 'tax', 'net_amount'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$appointment_auto_confirm = $settings -> get_option('ld_appointment_auto_confirm_status');

		$last_order_id = $booking -> last_booking_id();

		$client_phone = "";

		$coupon -> coupon_code= '';

		if (isset($_POST['coupon_code'])) {

			$coupon -> coupon_code = $_POST['coupon_code'];

		}
		$current_time = date('Y-m-d H:i:s');
		$result = $coupon -> checkcode();

		if ($result) {

			$coupon -> inc = $result['coupon_used'] + 1;

			$coupon_exp_date = strtotime($result['coupon_expiry']);

			$today = date("Y-m-d");

			$curr_date = strtotime($today);

			if ($result['coupon_used'] < $result['coupon_limit'] && $curr_date <= $coupon_exp_date) {

				$coupon -> update_coupon_limit();

			}

		}

		$zipcode = '';

		if (isset($_POST['zipcode'])) {

			$zipcode = $_POST['zipcode'];

		}

		$address = '';

		if (isset($_POST['address'])) {

			$address = $_POST['address'];

		}

		$city = '';

		if (isset($_POST['city'])) {

			$city = ucwords($_POST['city']);

		}

		$state = '';

		if (isset($_POST['state'])) {

			$state = ucwords($_POST['state']);

		}

		$notes = '';

		if (isset($_POST['notes'])) {

			$notes = $_POST['notes'];

		}

		$staff_id = '';

		if (isset($_POST['staff_id'])) {

			$staff_id = $_POST['staff_id'];

		}

		
		$contact_status = '';

		$contact_status_email = '';

		if (isset($_POST['contact_status'])) {

			$contact_status = mysqli_real_escape_string($conn, $_POST['contact_status']);

			$contact_status_email = $_POST['contact_status'];

		}

		if ($last_order_id == '0' || $last_order_id == null) {

			$orderid = 1000;

		} else {

			$orderid = $last_order_id + 1;

		}

		if (!function_exists('array_column')) {

			function array_column(array $input, $column_key, $index_key = null) {

				$result = array();

				foreach($input as $k => $v) $result[$index_key ? $v[$index_key] : $k] = $v[$column_key];

				return $result;

			}

		}

		if ($_POST['user_type'] == 'guest') {

			$client_id = 0;

			$cart_detail = $_POST['cart_detail'];

			$service_id = $_POST['service_id'];

			$payment_method = $_POST['payment_method'];

			$transaction_id = '';

			if (isset($_POST['transaction_id'])) {

				$transaction_id = $_POST['transaction_id'];

			}

			$partial_amount = '';

			if (isset($_POST['partial_amount'])) {

				$partial_amount = $_POST['partial_amount'];

			}

			$first_name = '';

			if (isset($_POST['first_name'])) {

				$first_name = $_POST['first_name'];

			}

			$last_name = '';

			if (isset($_POST['last_name'])) {

				$last_name = $_POST['last_name'];

			}

			$email = '';

			if (isset($_POST['email'])) {

				$email = $_POST['email'];

			}

			$phone = '';

			$client_phone = '';

			if (isset($_POST['phone'])) {

				$phone = $_POST['phone'];

				$client_phone = $_POST['phone'];

			}

			

			$sub_total = $_POST['sub_total'];

			$discount = $_POST['discount'];

			$tax = $_POST['tax'];

			$net_amount = $_POST['net_amount'];

			book_an_appointment($cart_detail, $key, $orderid, $client_id, $current_time,$booking_pickup_date_time_start,$booking_pickup_date_time_end,$booking_delivery_date_time_start,$booking_delivery_date_time_end ,$service_id, $appointment_auto_confirm, $staff_id, $payment_method, $transaction_id, $sub_total, $discount, $tax, $partial_amount, $net_amount, $first_name, $last_name, $email, $phone, $zipcode, $address, $city, $state, $notes, $contact_status, $booking, $payment, $order_client_info);
			
			


			$company_email = $settings -> get_option('ld_email_sender_address');

			$company_name = $settings -> get_option('ld_email_sender_name');

			$valid = ['status' => "true", "statuscode" => 200, 'response' => "Appointment booked successfully"];

			setResponse($valid);

		} 
		else if ($_POST['user_type'] == 'existing') {

			$user -> existing_username = $_POST['email'];

			$user -> existing_password =$_POST['password'];

			$existing_login = $user -> check_login(); /** check and add booking for existing customer **/
			
			if ($existing_login) {
				
				
				$client_id = $existing_login[0];

				$cart_detail = $_POST['cart_detail'];

				$service_id = $_POST['service_id'];
				
				$service->id = $service_id;
				$service_name = $service->get_service_name_for_mail();

				$payment_method = $_POST['payment_method'];
				

				$transaction_id = '';

				if (isset($_POST['transaction_id'])) {

					$transaction_id = $_POST['transaction_id'];

				}
				

				$partial_amount = '';

				if (isset($_POST['partial_amount'])) {

					$partial_amount = $_POST['partial_amount'];

				}
				

				$first_name = '';

				if (isset($_POST['first_name'])) {

					$first_name = $_POST['first_name'];

				}

				$last_name = '';

				if (isset($_POST['last_name'])) {

					$last_name = $_POST['last_name'];

				}
				
				$client_name = $first_name." ".$last_name;

				$email = '';

				if (isset($_POST['email'])) {

					$email = $_POST['email'];

				}

				$phone = '';

				$client_phone = '';

				if (isset($_POST['phone'])) {

					$phone = $_POST['phone'];

					$client_phone = $_POST['phone'];

				}

				$sub_total = $_POST['sub_total'];

				$discount = $_POST['discount'];

				$tax = $_POST['tax'];

				$net_amount = $_POST['net_amount'];
				$booking_pickup_date_time_start=$_POST['booking_pickup_date_time_start'];
				$booking_pickup_date_time_end=$_POST['booking_pickup_date_time_end'];
				$booking_delivery_date_time_start=$_POST['booking_delivery_date_time_start'];
				$booking_delivery_date_time_end=$_POST['booking_delivery_date_time_end'];
				
				$password = $existing_login[2];

				$user -> user_id = $client_id;

				$user -> user_pwd = $password;

				$user -> first_name = ucwords($first_name);

				$user -> last_name = ucwords($last_name);

				$user -> user_email = $email;

				$user -> phone = $phone;

				$user -> address = $address;

				$user -> zip = $zipcode;

				$user -> city = ucwords($city);

				$user -> state = ucwords($state);

				$user -> notes = mysqli_real_escape_string($conn, $notes);

				$user -> status = 'E';

				$user -> usertype = serialize(array('client'));

				$user -> contact_status = mysqli_real_escape_string($conn, $contact_status);
				
				$update_user = $user -> update_user();

				if ($update_user) {
					
					book_an_appointment($cart_detail, $orderid, $client_id, $current_time,$booking_pickup_date_time_start,$booking_pickup_date_time_end,$booking_delivery_date_time_start,$booking_delivery_date_time_end ,$service_id, $appointment_auto_confirm, $staff_id, $payment_method, $transaction_id, $sub_total, $discount, $tax, $partial_amount, $net_amount, $first_name, $last_name, $email, $phone, $zipcode, $address, $city, $state, $notes, $contact_status, $booking, $payment, $order_client_info);
					
					print_r($cart_detail); exit();

					$company_email = $settings -> get_option('ld_email_sender_address');

					$company_name = $settings -> get_option('ld_email_sender_name');
					
					if($settings->get_option('ld_client_email_notification_status') == 'Y'){	
						
						$searcharray = array('{{service_name}}','{{booking_date}}','{{business_logo}}','{{business_logo_alt}}','{{client_name}}','{{units}}','{{firstname}}','{{lastname}}','{{client_email}}','{{phone}}','{{payment_method}}','{{notes}}','{{contact_status}}','{{admin_name}}','{{price}}','{{address}}','{{app_remain_time}}','{{reject_status}}','{{company_name}}','{{booking_time}}','{{client_city}}','{{client_state}}','{{client_zip}}','{{client_promocode}}','{{company_city}}','{{company_state}}','{{company_zip}}','{{company_country}}','{{company_phone}}','{{company_email}}','{{company_address}}','{{admin_name}}','{{staff_name}}','{{staff_email}}');

						$replacearray = array($service_name, $booking_pickup_date_time_start , $business_logo, $business_logo_alt, stripslashes($client_name),$units,$client_fname ,$client_lname , $cemail,$client_phone_info, $payment_method,$client_notes, $contact_status_cont,$get_admin_name,$price,stripslashes($c_address),'','',$company_name,$booking_pickup_time_start,stripslashes($client_city),stripslashes($client_state),$client_zip,$promo_code,stripslashes($company_city),stripslashes($company_state),$company_zip,$company_country,$company_phone,$company_email,stripslashes($company_address),stripslashes($get_admin_name),stripslashes($get_staff_name),stripslashes($get_staff_email));
						
						$company_email = $objsettings -> get_option('ld_company_email');
						$company_name = $settings -> get_option('ld_company_name');
						$client_email = $_POST['email'];
						$client_name = 'cleaning';
						$subject = "Email Send for Otp";
						$otp_randome = rand(100000, 999999);

						$client_email_body = "Your Otp is :- ".$otp_randome; 
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
					else
					{
						$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Email not enabled for client."];
						setResponse($invalid);
					}

					

					$valid = ['status' => "true", "statuscode" => 200,'order_id'=>$orderid, 'response' => "Appointment booked successfully"];

					setResponse($valid);

				} else {

					$invalid = ['status' => "false", "statuscode" => 404, 'response' => "User details not updated"];

					setResponse($invalid);

				}

			} else {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "User not exist please register first"];

				setResponse($invalid);

			}

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Invalid user type."];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'get_all_enabled_payment_gateways') {

	verifyRequiredParams(array('api_key'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$payment_array = array();

		if ($settings -> get_option('ld_pay_locally_status') == 'on') {

			array_push($payment_array, 'pay_locally');

		}

		if ($settings -> get_option('ld_bank_transfer_status') == 'Y' && ($settings -> get_option('ld_bank_name') != '' || $settings -> get_option('ld_account_name') != '' || $settings -> get_option('ld_account_number') != '' || $settings -> get_option('ld_branch_code') != '' || $settings -> get_option('ld_ifsc_code') != '' || $settings -> get_option('ld_bank_description') != '')) {

			array_push($payment_array, 'bank_transfer');

		}

		if ($settings -> get_option('ld_paypal_express_checkout_status') == 'on') {

			array_push($payment_array, 'paypal');

		}

		if ($settings -> get_option('ld_payumoney_status') == 'Y') {

			array_push($payment_array, 'payumoney');

		}

		if ($settings -> get_option('ld_authorizenet_status') == 'on' && $settings -> get_option('ld_stripe_payment_form_status') != 'on' && $settings -> get_option('ld_2checkout_status') != 'Y') {

			array_push($payment_array, 'authorizenet');

		}

		if ($settings -> get_option('ld_authorizenet_status') != 'on' && $settings -> get_option('ld_stripe_payment_form_status') == 'on' && $settings -> get_option('ld_2checkout_status') != 'Y') {

			array_push($payment_array, 'stripe');

		}

		if ($settings -> get_option('ld_authorizenet_status') != 'on' && $settings -> get_option('ld_stripe_payment_form_status') != 'on' && $settings -> get_option('ld_2checkout_status') == 'Y') {

			array_push($payment_array, '2checkout');

		}

		if (sizeof($purchase_check) > 0) {

			foreach($purchase_check as $key => $val) {

				if ($val == 'Y') {

					array_push($payment_array, $key);

				}

			}

		}

		if (sizeof($payment_array) > 0) {

			$valid = ['status' => "true", "statuscode" => 200, 'response' => $payment_array];

			setResponse($valid);

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No staff found"];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'get_profile_detail') {

	verifyRequiredParams(array('api_key', 'user_id', 'type'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) { /* objadmin  	user */

		$user_id = $_POST['user_id'];

		$new_array = array();

		if ($_POST['type'] == "staff") {

			$objadmin -> id = $user_id;

			$array = array();

			$staff_detail = $objadmin -> readone();

			if (!empty($staff_detail)) {

				$array['id'] = $staff_detail['id'];

				$array['password'] = $staff_detail['password'];

				$array['user_email'] = $staff_detail['email'];

				$array['fullname'] = $staff_detail['fullname'];

				$array['phone'] = $staff_detail['phone'];

				$array['address'] = $staff_detail['address'];

				$array['city'] = $staff_detail['city'];

				$array['state'] = $staff_detail['state'];

				$array['zip'] = $staff_detail['zip'];

				$array['country'] = $staff_detail['country'];

				$array['role'] = $staff_detail['role'];

				$array['description'] = $staff_detail['description'];

				$array['enable_booking'] = $staff_detail['enable_booking'];

				$array['service_commission'] = $staff_detail['service_commission'];

				$array['commision_value'] = $staff_detail['commision_value'];

				$array['schedule_type'] = $staff_detail['schedule_type'];

				$array['image'] = $staff_detail['image'];

				$array['service_ids'] = $staff_detail['service_ids'];

				foreach($array as $field => $value) {

					if ($array[$field] == '') {

						$array[$field] = null;

					} else {

						$array[$field] = $value;

					}

				}

				array_push($new_array, $array);

				$valid = ['status' => "true", "statuscode" => 200, 'response' => $new_array];

				setResponse($valid);

			} else {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No Details Available"];

				setResponse($invalid);

			}

		}
		else if ($_POST['type'] == "user") {

			$user -> user_id = $user_id;

			$user_detail = $user -> readone();

			$array = array();
			
			if (!empty($user_detail)) {

				$array['id'] = $user_detail['id'];

				$array['user_email'] = $user_detail['user_email'];

				$array['user_pwd'] = $user_detail['user_pwd'];

				$array['fullname'] = $user_detail['first_name']." ".$user_detail['last_name'];
				$array['first_name'] = $user_detail['first_name'];
				$array['last_name'] =        $user_detail['last_name'];
				$array['phone'] = $user_detail['phone'];

				$array['zip'] = $user_detail['zip'];

				$array['address'] = $user_detail['address'];

				$array['city'] = $user_detail['city'];

				$array['state'] = $user_detail['state'];

				$array['notes'] = $user_detail['notes'];

				$array['contact_status'] = $user_detail['contact_status'];

				$array['status'] = $user_detail['status'];

				$array['usertype'] = $user_detail['usertype'];

				$array['cus_dt'] = $user_detail['cus_dt'];

				$user_date_timestamp = strtotime($user_detail['cus_dt']);

				$array['join_date'] = date('l, d-M-Y', $user_date_timestamp);

				$array['join_time'] = date('h:i A', $user_date_timestamp);

				foreach($array as $field => $value) {

					if ($array[$field] == '') {

						$array[$field] = null;

					} else {

						$array[$field] = $value;

					}

				}

				array_push($new_array, $array);

				$valid = ['status' => "true", "statuscode" => 200, 'response' => $new_array];

				setResponse($valid);

			} else {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No Details Available"];

				setResponse($invalid);

			}

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Type is mismatch"];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'profile_detail_update') {

	verifyRequiredParams(array('api_key', 'user_id', 'type'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$user_id = $_POST['user_id'];

		if ($_POST['type'] == "staff") {

			verifyRequiredParams(array('fullname', 'email', 'phone', 'address', 'city', 'state', 'zip', 'country'));

			$objadmin -> id = $user_id;

			$staff_detail = $objadmin -> readone();

			if (!empty($staff_detail)) {

				$objadmin -> password = $staff_detail['password'];

				$objadmin -> fullname = ucwords($_POST['fullname']);

				$objadmin -> email = $_POST['email'];

				$objadmin -> phone = $_POST['phone'];

				$objadmin -> address = $_POST['address'];

				$objadmin -> city = $_POST['city'];

				$objadmin -> state = $_POST['state'];

				$objadmin -> zip = $_POST['zip'];

				$objadmin -> country = $_POST['country'];

				if ($objadmin -> update_profile()) {

					$valid = ['status' => "true", "statuscode" => 200, 'response' => "Updated Successfully"];

					setResponse($valid);

				} else {

					$valid = ['status' => "true", "statuscode" => 404, 'response' => "Something Went Wrong"];

					setResponse($valid);

				}

			} else {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No Details Available"];

				setResponse($invalid);

			}

		} 
		else if ($_POST['type'] == "user") {

			$user -> user_id = $user_id;

			$user_detail = $user -> readone();

			if (!empty($user_detail)) { /* objuserdetails */

				verifyRequiredParams(array('firstname', 'phone','lastname', 'address', 'city', 'state', 'zip'));

				$objuserdetails -> password = $user_detail['user_pwd'];

				$objuserdetails -> firstname = $_POST['firstname'];

				$objuserdetails -> phone = $_POST['phone'];

				$objuserdetails -> lastname = $_POST['lastname'];

				$objuserdetails -> address = $_POST['address'];

				$objuserdetails -> city = $_POST['city'];

				$objuserdetails -> state = $_POST['state'];

				$objuserdetails -> zip = $_POST['zip'];

				$objuserdetails -> id = $user_id;
				
				
				if ($objuserdetails -> update_profile()) {

					$valid = ['status' => "true", "statuscode" => 200, 'response' => "Updated Successfully"];

					setResponse($valid);

				} else {

					$valid = ['status' => "true", "statuscode" => 404, 'response' => "Something Went Wrong"];

					setResponse($valid);

				}

				$valid = ['status' => "true", "statuscode" => 200, 'response' => $user_detail];

				setResponse($valid);

			} else {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No Details Available"];

				setResponse($invalid);

			}

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Type is mismatch"];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'change_password') {

	verifyRequiredParams(array('api_key', 'user_id', 'type', 'old_password', 'new_password', 'confirm_password'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$old_password = $_POST['old_password'];

		$new_password = $_POST['new_password'];

		$confirm_password = $_POST['confirm_password'];

		if ($new_password != $confirm_password) {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Please check your confirmed password!"];

			setResponse($invalid);

			die;

		} else {

			$old_password = md5($old_password);

		}

		$user_id = $_POST['user_id'];

		if ($_POST['type'] == "staff") {

			$objadmin -> id = $user_id;

			$staff_detail = $objadmin -> readone();

			if (!empty($staff_detail)) {

				$orignal_password = $staff_detail['password'];

				if ($orignal_password != $old_password) {

					$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Your Paasword Not Match"];

					setResponse($invalid);

				} else {

					$objadmin -> password = $new_password;

					$password_update = $objadmin -> update_password_api();

					if ($password_update) {

						$valid = ['status' => "true", "statuscode" => 200, 'response' => "Updated Successfully"];

						setResponse($valid);

					} else {

						$valid = ['status' => "true", "statuscode" => 404, 'response' => "Something Went Wrong"];

						setResponse($valid);

					}

				}

			} else {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No Details Available"];

				setResponse($invalid);

			}

		} else if ($_POST['type'] == "user") {

			$user -> user_id = $user_id;

			$user_detail = $user -> readone();

			if (!empty($user_detail)) {

				$orignal_password = $user_detail['user_pwd'];

				if ($orignal_password != $old_password) {

					$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Your Password Not Match"];

					setResponse($invalid);

				} else {

					$user -> user_pwd = $new_password;

					$password_update = $user -> update_password();

					if ($password_update) {

						$valid = ['status' => "true", "statuscode" => 200, 'response' => "Updated Successfully"];

						setResponse($valid);

					} else {

						$valid = ['status' => "true", "statuscode" => 404, 'response' => "Something Went Wrong"];

						setResponse($valid);

					}

				}

			} else {

				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No Details Available"];

				setResponse($invalid);

			}

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Type is mismatch"];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'get_all_past_appointment') {

	verifyRequiredParams(array('api_key','user_id','type'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {
		$limit = 5;
		$page = $_POST['page'];
		$offset = $limit * $page;
		$booking -> booking_start_datetime = $today_date." 00:00:00";

		$type = $_POST['type'];
		$user_id = $_POST['user_id'];
		$booking -> limit = $limit;
		$booking -> offset = $offset;
		$all_upcomming_appointment = $booking -> get_all_past_bookings_api();

		$array = array();

		$pass_array = array();

		if (mysqli_num_rows($all_upcomming_appointment) > 0) {

			while ($row = mysqli_fetch_assoc($all_upcomming_appointment)) {

				$array['order_id'] = $row['order_id'];

				$client_id = $row['client_id'];
				$staff_ids = explode(",", $row['staff_ids']);
				if($type == 'user'){
					if($client_id != $user_id){
						continue;
					}
				}else if($type == 'staff'){
					if(!in_array($user_id, $staff_ids)){
						continue;
					}
				}

				$order_detail = $booking -> get_detailsby_order_id($row['order_id']);

				$client_info = unserialize(base64_decode($order_detail['client_personal_info']));

				$array['booking_date_time'] = $order_detail['booking_date_time'];

				$array['booking_status'] = $order_detail['booking_status'];

				$array['reject_reason'] = $order_detail['reject_reason'];

				$array['title'] = $order_detail['service_title'];

				$array['total_payment'] = $order_detail['net_amount'];

				$array['gc_event_id'] = $order_detail['gc_event_id'];

				$array['gc_staff_event_id'] = $order_detail['gc_staff_event_id'];

				$array['staff_ids'] = $order_detail['staff_ids'];

				if ($order_detail['staff_ids'] != '') {

					$staff_names = '';

					$exploded_staff_ids = explode(',', $order_detail['staff_ids']);

					$i = 1;

					foreach($exploded_staff_ids as $id) {

						$objadmin -> id = $id;

						$staffdata = $objadmin -> readone();

						if ($i = 1) {

							$staff_names.= $staffdata['fullname'];

						} else {

							$staff_names.= ', '.$staffdata['fullname'];

						}

						$i++;

					}

					$array['staff_names'] = $staff_names;

				} else {

					$array['staff_names'] = null;

				}

				$units = null;

				$methodname = null;

				$hh = $booking -> get_methods_ofbookings($row['order_id']);

				$count_methods = mysqli_num_rows($hh);

				$hh1 = $booking -> get_methods_ofbookings($row['order_id']);

				if ($count_methods > 0) {

					while ($jj = mysqli_fetch_array($hh1)) {

						if ($units == null) {

							$units = $jj['units_title'].

							"-".$jj['qtys'];

						} else {

							$units = $units.

							",".$jj['units_title'].

							"-".$jj['qtys'];

						}

						$methodname = $jj['method_title'];

					}

				}

				$addons = null;

				$hh = $booking -> get_addons_ofbookings($row['order_id']);

				while ($jj = mysqli_fetch_array($hh)) {

					if ($addons == null) {

						$addons = $jj['addon_service_name'].

						"-".$jj['addons_service_qty'];

					} else {

						$addons = $addons.

						",".$jj['addon_service_name'].

						"-".$jj['addons_service_qty'];

					}

				}

				$array['method_name'] = $methodname;

				$array['units'] = $units;

				$array['addons'] = $addons;

				$booking_date_timestamp = strtotime($array['booking_date_time']);

				$array['appointment_date'] = date('l, d-M-Y', $booking_date_timestamp);

				$array['appointment_time'] = date('h:i A', $booking_date_timestamp);

				foreach($client_info as $field => $value) {

					if ($client_info[$field] == '') {

						$array[$field] = null;

					} else {

						$array[$field] = $value;

					}

				}

				foreach($array as $field => $value) {

					if ($array[$field] == '') {

						$array[$field] = null;

					} else {

						$array[$field] = $value;

					}

				}

				array_push($pass_array, $array);

			}

			$invalid = ['status' => "true", "statuscode" => 200, 'response' => $pass_array];

			setResponse($invalid);

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No Upcomming Appointment"];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'get_all_upcoming_appointment') {

	verifyRequiredParams(array('api_key','user_id','type'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {
		$limit = 5;
		$page = $_POST['page'];
		$offset = $limit * $page;
		
		$type = $_POST['type'];
		$user_id = $_POST['user_id'];
		$booking -> limit = $limit;
		$booking -> offset = $offset;
		$booking -> booking_start_datetime = $today_date." 00:00:00";

		$all_upcomming_appointment = $booking -> get_all_upcoming_bookings_api();

		$array = array();

		$pass_array = array();

		if (mysqli_num_rows($all_upcomming_appointment) > 0) {

			while ($row = mysqli_fetch_assoc($all_upcomming_appointment)) {

				$array['order_id'] = $row['order_id'];

				$client_id = $row['client_id'];
				$staff_ids = explode(",", $row['staff_ids']);
				if($type == 'user'){
					if($client_id != $user_id){
						continue;
					}
				}else if($type == 'staff'){
					if(!in_array($user_id, $staff_ids)){
						continue;
					}
				}

				$order_detail = $booking -> get_detailsby_order_id($row['order_id']);

				$client_info = unserialize(base64_decode($order_detail['client_personal_info']));

				$array['booking_date_time'] = $order_detail['booking_date_time'];

				$array['booking_status'] = $order_detail['booking_status'];

				$array['reject_reason'] = $order_detail['reject_reason'];

				$array['title'] = $order_detail['service_title'];

				$array['total_payment'] = $order_detail['net_amount'];

				$array['gc_event_id'] = $order_detail['gc_event_id'];

				$array['gc_staff_event_id'] = $order_detail['gc_staff_event_id'];

				$array['staff_ids'] = $order_detail['staff_ids'];

				if ($order_detail['staff_ids'] != '') {

					$staff_names = '';

					$exploded_staff_ids = explode(',', $order_detail['staff_ids']);

					$i = 1;

					foreach($exploded_staff_ids as $id) {

						$objadmin -> id = $id;

						$staffdata = $objadmin -> readone();

						if ($i = 1) {

							$staff_names.= $staffdata['fullname'];

						} else {

							$staff_names.= ', '.$staffdata['fullname'];

						}

						$i++;

					}

					$array['staff_names'] = $staff_names;

				} else {

					$array['staff_names'] = null;

				}

				$units = null;

				$methodname = null;

				$hh = $booking -> get_methods_ofbookings($row['order_id']);

				$count_methods = mysqli_num_rows($hh);

				$hh1 = $booking -> get_methods_ofbookings($row['order_id']);

				if ($count_methods > 0) {

					while ($jj = mysqli_fetch_array($hh1)) {

						if ($units == null) {

							$units = $jj['units_title'].

							"-".$jj['qtys'];

						} else {

							$units = $units.

							",".$jj['units_title'].

							"-".$jj['qtys'];

						}

						$methodname = $jj['method_title'];

					}

				}

				$addons = null;

				$hh = $booking -> get_addons_ofbookings($row['order_id']);

				while ($jj = mysqli_fetch_array($hh)) {

					if ($addons == null) {

						$addons = $jj['addon_service_name'].

						"-".$jj['addons_service_qty'];

					} else {

						$addons = $addons.

						",".$jj['addon_service_name'].

						"-".$jj['addons_service_qty'];

					}

				}

				$array['method_name'] = $methodname;

				$array['units'] = $units;

				$array['addons'] = $addons;

				$booking_date_timestamp = strtotime($array['booking_date_time']);

				$array['appointment_date'] = date('l, d-M-Y', $booking_date_timestamp);

				$array['appointment_time'] = date('h:i A', $booking_date_timestamp);

				foreach($client_info as $field => $value) {

					if ($client_info[$field] == '') {

						$array[$field] = null;

					} else {

						$array[$field] = $value;

					}

				}

				foreach($array as $field => $value) {

					if ($array[$field] == '') {

						$array[$field] = null;

					} else {

						$array[$field] = $value;

					}

				}

				array_push($pass_array, $array);

			}

			$invalid = ['status' => "true", "statuscode" => 200, 'response' => $pass_array];

			setResponse($invalid);

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No Upcomming Appointment"];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'otp') {

	verifyRequiredParams(array('api_key', 'email'));
	
	

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {
		
		if($settings->get_option('ld_client_email_notification_status') == 'Y'){
			if (isset($_POST['email'])) {	
				$company_email = $objsettings -> get_option('ld_company_email');
				$company_name = $settings -> get_option('ld_company_name');
				$client_email = $_POST['email'];
				$client_name = 'cleaning';
				$subject = "Email Send for Otp";
				$otp_randome = rand(100000, 999999);

				$client_email_body = "Your Otp is :- ".$otp_randome; 
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
				
				$user -> user_otp = $otp_randome;
				$user -> user_email = $client_email;
				$resadd = $user -> send_otp_using_mail();
				$valid = ['status' => "true", "statuscode" => 200, 'response' => "email exist"];
				setResponse($valid);
			}
			else {
				$email_error = ['status' => "false", "statuscode" => 404, 'response' => "email does not exist"];
				setResponse($email_error);
			}
		}
		else
		{
			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Email not enabled for client."];
			setResponse($invalid);
		}
		
	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "invalid credentials"];
		setResponse($invalid);
	}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'confirm_otp_email') {

	verifyRequiredParams(array('api_key', 'email', 'otp'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$user -> email = $_POST['email'];

		$optres = $user -> readall_opt();

		if ($optres == $_POST['otp']) {

			$valid = ['status' => "true", "statuscode" => 200, 'response' => "Otp match"];

			$user -> otp = $_POST['otp'];

			$optresa = $user -> opt_update_status();

			setResponse($valid);

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Otp not match"];

			setResponse($invalid);

		}

	}

}
elseif(isset($_POST['action']) && $_POST['action'] == 'forgot_password') {

	verifyRequiredParams(array('api_key', 'email', 'newpassword'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$user -> user_pwd = md5($_POST['newpassword']);

		$user -> user_email = $_POST['email'];

		$res = $user -> forgot_update_password();

		if ($res) {

			$valid = ['status' => "true", "statuscode" => 200, 'response' => "Password is change"];

			setResponse($valid);

		} else {

			$valid = ['status' => "false", "statuscode" => 404, 'response' => "Password Not change"];

			setResponse($valid);

		}

	}

}
elseif(isset($_POST['action']) && $_POST['action'] == 'feedback_email_send'){
	verifyRequiredParams(array('api_key','fullname','message'));
	if(isset($_POST['api_key']) && $_POST['api_key'] == $objsettings->get_option('ld_api_key')){
		$mess	  = $_POST['message'];
		$to       = 'anuj.sachdeva@broadviewinnovations.in';
		$subject  = 'Client Feedback';
		$message  = $mess;
		$headers  = 'From: anuj .sachdeva@broadviewinnovations.in' . "\r\n" .
		'MIME-Version: 1.0' . "\r\n" .
		'Content-type: text/html; charset=utf-8';
		if(mail($to, $subject, $message, $headers)){
			
			$valid = [ 'status' => "true", "statuscode"=> 200, 'response' =>"Email send" ];
			setResponse($valid); 
		}else{

			$invalid = [ 'status' => "false", "statuscode"=> 404, 'response' =>"Email sending failed" ];
			setResponse($invalid);
		}
	}
}
elseif(isset($_POST['action']) && $_POST['action'] == 'get_payment_order_rec') {

	verifyRequiredParams(array('api_key', 'user_id', 'type'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {
		
		$limit = 5;
		$page = $_POST['page'];
		$offset = $limit * $page;
		
		if ($_POST['type'] == 'client') {

			$user -> user_id = $_POST['user_id'];
			$user -> limit = $limit;
			$user -> offset = $offset;
			$userdata = $user -> get_payment_order_record();

			$array = array();

			if (mysqli_num_rows($userdata) > 0) {

				while ($row = mysqli_fetch_assoc($userdata)) {

					$order_date = strtotime($row['order_date']);

					$row['order_date_format'] = date('l, d-M-Y', $order_date);

					$booking_date_time = strtotime($row['booking_date_time']);

					$row['appointment_date'] = date('l, d-M-Y', $booking_date_time);

					$row['appointment_time'] = date('h:i A', $booking_date_time);

					$payment_date = strtotime($row['payment_date']);

					$row['payment_date_format'] = date('l, d-M-Y', $payment_date);

					array_push($array, $row);

				}

				$valid = ['status' => "true", "statuscode" => 200, 'response' => $array];

				setResponse($valid);

			} else {

				$valid = ['status' => "false", "statuscode" => 404, 'response' => "No Orders Details"];

				setResponse($valid);

			} 

		}

		elseif($_POST['type'] == 'staff') {

			$user -> user_id = $_POST['user_id'];
			$user -> limit = $limit;
			$user -> offset = $offset;
			$userdata = $user -> get_staff_payment_order_record();

			$array = array();

			if (mysqli_num_rows($userdata) > 0) {

				while ($row = mysqli_fetch_assoc($userdata)) {

					$order_date = strtotime($row['order_date']);

					$row['order_date_format'] = date('l, d-M-Y', $order_date);

					$booking_date_time = strtotime($row['booking_date_time']);

					$row['appointment_date'] = date('l, d-M-Y', $booking_date_time);

					$row['appointment_time'] = date('h:i A', $booking_date_time);

					$payment_date = strtotime($row['payment_date']);

					$row['payment_date_format'] = date('l, d-M-Y', $payment_date);

					array_push($array, $row);

				}

				$valid = ['status' => "true", "statuscode" => 200, 'response' => $array];

				setResponse($valid);

			} else {

				$valid = ['status' => "false", "statuscode" => 404, 'response' => "No Orders Details"];

				setResponse($valid);

			}

		}

	}

}
elseif(isset($_POST['action']) && $_POST['action'] == 'stripe_payment_method') {

	verifyRequiredParams(array('api_key', 'full_name', 'email', 'card_number', 'card_month', 'card_year', 'card_cvv', 'amount'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {
		if($objsettings -> get_option('ld_stripe_payment_form_status') != "off"){
			require_once(dirname(dirname(__FILE__)) . "/assets/stripe/stripe.php");
			
			$secret_key = $objsettings -> get_option('ld_stripe_secretkey');
			$currency = $objsettings -> get_option('ld_currency');
			\Stripe\Stripe::setApiKey($secret_key);
			$error = '';
			$success = '';
			
			try {
				$objtoken = new \Stripe\Token;
				
				$token = $objtoken::Create(array(
				"card" => array(
				"number" => $_POST['card_number'],
				"exp_month" => $_POST['card_month'],
				"exp_year" => $_POST['card_year'],
				"cvc" => $_POST['card_cvv']
				)
				));
				
				$token_id = $token->id;
				
				$objcharge = new \Stripe\Charge;
				
				$striperesponse = $objcharge::Create(array(
				"amount" => round($_POST['amount']*100),
				"currency" => $currency,
				"source" => $token_id,
				"description"=>$_POST['full_name']
				));
				$transaction_id = $striperesponse->id;
				
				$valid = ['status' => "true", "statuscode" => 200, 'response' => $transaction_id];
				setResponse($valid);
				
			}catch (Exception $e) {
				$error = $e->getMessage();
				$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Message Is - ".$error];
				setResponse($invalid);
				die;
			}
		}else{
			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Please Enable Stripe"];
			setResponse($invalid);
		}
	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

} 
elseif(isset($_POST['action']) && $_POST['action'] == 'my_copy_action_for_other') {

	verifyRequiredParams(array('api_key', 'user_id'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

} 
elseif(isset($_POST['action']) && $_POST['action'] == 'getAvailable_date'){
	verifyRequiredParams(array('api_key'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {
		
		

		/* Specify the start date. This date can be any English textual format   */
		$date_from = date("Y-m-d");   
		$date_from = strtotime($date_from);
		/* Specify the end date. This date can be any English textual format   */
		$date_to = "2025-09-10";  
		$date_to = strtotime($date_to); /*  Convert date to a UNIX timestamp   */
		
		$cnt=0;
		$array = array();
		$new = $objsettings -> get_option('ld_minimum_delivery_days');
		if($date_from){
			for ($i=$date_from; $i<=$date_to; $i+=86400) {
				$cnt++;
				
				$data['dateList']=	date('d F, Y', $i);
				
				array_push($array, $data);
				if($cnt==10){
					break;
				}
				
			} 
			$valid = ['status' => "true", "statuscode" => 200,'minimum_delivery_days'=>$new ,'response' => $array];

			setResponse($valid);

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No Date found"];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}
elseif(isset($_POST['action']) && $_POST['action'] == 'get_delivery_date'){
	verifyRequiredParams(array('api_key','limit_date','selected_date'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {
		
		// Specify the start date. This date can be any English textual format  
		$date_from = date("Y-m-d");   
		$date_from = strtotime($_POST['selected_date']);
		// Specify the end date. This date can be any English textual format  
		$date_to = "2025-09-10";  
		$date_to = strtotime($date_to); // Convert date to a UNIX timestamp  
		
		$cnt=0;
		$array = array();
		$new = $objsettings -> get_option('ld_minimum_delivery_days');
		if($date_from){
			for ($i=$date_from; $i<=$date_to; $i+=86400) {
				$cnt++;
				
				$data['dateList']=	date('d F, Y', $i);
				if($cnt>$_POST['limit_date']){
					array_push($array, $data);
				}
				
				if($cnt==(10+$_POST['limit_date'])){
					break;
				}
				
			} 
			$valid = ['status' => "true", "statuscode" => 200,'response' => $array];

			setResponse($valid);

		} else {

			$invalid = ['status' => "false", "statuscode" => 404, 'response' => "No Date found"];

			setResponse($invalid);

		}

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}
elseif(isset($_POST['action']) && $_POST['action'] == 'getCoupon_date'){
	verifyRequiredParams(array('api_key','action'));
	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {
		$couponList=$coupon->readall();
		if (mysqli_num_rows($couponList) > 0) {
			
			$array = array();
			while ($unit_value = mysqli_fetch_assoc($couponList)) {
				array_push($array, $unit_value);
			}
			
			$response = ['status' => "true", "statuscode" => 200, 'response' => $array];
			setResponse($response);

		} else {

			$response = ['status' => "false",'no_of_dropdown' => 0, "statuscode" => 404, 'response' => "No Coupon available"];

			setResponse($response);

		}

	}else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}
}
elseif(isset($_POST['action']) && $_POST['action'] == 'get_contact_us') {

	verifyRequiredParams(array('api_key', 'ld_company_name'));

	if (isset($_POST['api_key']) && $_POST['api_key'] == $objsettings -> get_option('ld_api_key')) {

		$array = array();

		$arr['company_name'] = $objsettings -> get_option($_POST['ld_company_name']);
		$arr['comapny_add'] = $objsettings -> get_option($_POST['ld_company_address']);
		$arr['comapny_email'] = $objsettings -> get_option($_POST['ld_company_email']);
		$arr['comapny_phone'] = $objsettings -> get_option($_POST['ld_company_phone']);

		array_push($array, $arr);

		$valid = ['status' => "true", "statuscode" => 200, 'response' => $array];

		setResponse($valid);

	} else {

		$invalid = ['status' => "false", "statuscode" => 404, 'response' => "API key mismatch"];

		setResponse($invalid);

	}

}
else {

	$invalid = ['status' => "false", "statuscode" => 404, 'response' => "Invalid request"];

	setResponse($invalid);

}

?>