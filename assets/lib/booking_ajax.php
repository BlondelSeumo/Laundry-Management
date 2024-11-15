<?php  

	session_start();
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_users.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_booking.php');
	include (dirname(dirname(dirname(__FILE__))).'/objects/class_setting.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_front_first_step.php');
	
	$database= new laundry_db();
	$conn=$database->connect();
	/* $database->conn=$conn; */
	
	$settings = new laundry_setting();
	$settings->conn = $conn;
	
$first_step=new laundry_first_step();
$first_step->conn=$conn;
	
	$user=new laundry_users();
	$user->conn=$conn;
	$booking= new laundry_booking();
	$booking->conn=$conn;
	
	if(isset($_POST['action']) && filter_var($_POST['action'])=='update_status_confirm_book'){
	$booking->booking_id=filter_var($_POST['data_id']);
	$booking->booking_status="C";
	$result=$booking->confirm_booking();
	if($result){
		echo filter_var("Status Updated");
	}else{
		echo filter_var("Status Not Updated");
	}
	
	}
	
	if(isset($_POST['action']) && filter_var($_POST['action'])=='reject_booking'){
		$t_zone_value = $settings->get_option('ld_timezone');
			$server_timezone = date_default_timezone_get();
			if(isset($t_zone_value) && $t_zone_value!=''){
			$offset= $first_step->get_timezone_offset($server_timezone,$t_zone_value);
			$timezonediff = $offset/3600;  
			}else{
			$timezonediff =0;
			}
			if(is_numeric(strpos($timezonediff,'-'))){
			$timediffmis = str_replace('-','',$timezonediff)*60;
			$currDateTime_withTZ= strtotime("-".$timediffmis." minutes",strtotime(date('Y-m-d H:i:s')));
			}else{
			$timediffmis = str_replace('+','',$timezonediff)*60;
			$currDateTime_withTZ = strtotime("+".$timediffmis." minutes",strtotime(date('Y-m-d H:i:s')));
			} 
			$current_time = date('Y-m-d H:i:s',$currDateTime_withTZ);
			$booking->order_id=filter_var($_POST['booking_id']);
			$booking->reject_reason=filter_var($_POST['reject_reason_book']);
			$booking->lastmodify=$current_time;
			$update_status1=$booking->update_reject_status();		
			if($update_status1){
				echo filter_var('booking Rejected');
			}else{
				echo filter_var("failed");
			}
	
	}
	
	/*Delete Appointments*/
		if(isset($_POST['action']) && filter_var($_POST['action'])=='update_delete_book'){	
			/*Get Order id from booking id */
			$booking->booking_id=filter_var($_POST['booking_id']);
			$booking_details=$booking->readone();
			$order_id=$booking_details[1];
			/*Check occurance of order id in booking table */
			$booking->order_id=$order_id;	
			$cnb=$booking->count_order_id_bookings();
			var_dump($cnb);
			if($cnb['ordercount']>1){
			$booking->booking_id=filter_var($_POST['booking_id']);
			$delete_myapp=$booking->delete_booking();
			}else{
			$booking->order_id=$order_id;
			$delete_myapp=$booking->delete_appointments();
			}
			if($delete_myapp){
			echo filter_var("Cancel My appointment");
			}
	}
	
	
	
	
?>