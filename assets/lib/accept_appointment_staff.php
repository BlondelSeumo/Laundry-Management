<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_booking.php');
include(dirname(dirname(dirname(__FILE__)))."/header.php");	
$con = new laundry_db();
$conn = $con->connect();
$booking= new laundry_booking();
$booking->conn=$conn;
if(isset($_GET['id'])){
	$booking->id=$_GET['id'];
	$booking->status=$_GET['status'];
	if($_GET['status'] == "A"){
	$result=$booking->update_staff_status();
	if($result){
			?>
			<script>window.close();</script>
			<?php
		}
	}
	/* Closes the new window */
	 if($_GET['status'] == "D"){
		$result1=$booking->update_staff_status();
		$result=$booking->readone_bookings_sid_staff();
		$s_idd=$result['staff_id'];
		$booking->order_id=$result['order_id'];
		$result=$booking->readone_bookings_details_by_order_id();	
	    $data=$result['staff_ids'];
		$array_val=explode(',',$data);
		$x=array();
		foreach($array_val as $kk)
		{
			if($kk != $s_idd){
				array_push($x,$kk);
			}
		}
		$ord_id=$result['order_id'];
	    $s_id=implode(',',$x);
		$booking->booking_id=$result['order_id'];
		$booking->staff_id=$s_id;
		$result=$booking->update_staff_id_bookings_details_by_order_id();
		if($result){
			?>
			<script>window.close();</script>
			<?php
		}
	 }
 }
 
if(isset($_POST['action']) && filter_var($_POST['action'])=='accept_appointment_staff'){
	$booking->id=filter_var($_POST['idd']);
	$booking->status=filter_var($_POST['staff_status']);
	$result = $booking->update_staff_status();
	/* print_r($result);
	die; */
}
if(isset($_POST['action']) && filter_var($_POST['action'])=='decline_appointmentt_staff'){
	$booking->order_id=filter_var($_POST['order_id']);
	$booking->status=filter_var($_POST['staff_status']);
	$result1=$booking->update_staff_status();
	$result=$booking->readone_bookings_sid_staff();
	/* print_r($result);
	die; */
	$s_idd=$result['staff_id'];
	$booking->order_id=$result['order_id'];
	$result=$booking->readone_bookings_details_by_order_id();
	/* print_r($result);
	die; */	
    $data=$result['staff_ids'];
	$array_val=explode(',',$data);
	/* print_r($array_val);
	die; */
	$x=array();
	foreach($array_val as $kk)
	{
		if($kk == $s_idd){
			array_push($x,$kk);
		}
	}	
	$ord_id=$result['order_id'];
	$s_id=implode(',',$x);
	/* print_r($x);
	print_r($s_id);
	die; */
	$booking->booking_id=$result['order_id'];
	$booking->staff_id=$s_id;
	$result = $booking->update_staff_id_bookings_details_by_order_id();
	/* print_r($result);
	die; */
}

if(isset($_POST['book_status'])){

	$booking->status=filter_var($_POST['status']);
	$booking->staff_id=filter_var($_POST['staff_id']);
	$booking->staff_order_id=filter_var($_POST['staff_order_id']);
	$result=$booking->staff_provide_status();
	if($result){
        echo filter_var("Okkk");
   
    }
    }
?>