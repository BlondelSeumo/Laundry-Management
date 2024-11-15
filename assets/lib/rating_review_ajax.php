<?php  

include(dirname(dirname(dirname(__FILE__)))."/header.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_connection.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_adminprofile.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_setting.php");
include(dirname(dirname(dirname(__FILE__))).'/objects/class_booking.php');
include(dirname(dirname(dirname(__FILE__)))."/objects/class_rating_review.php");

$con = new laundry_db();
$conn = $con->connect();
$rating_review = new laundry_rating_review();
$rating_review->conn = $conn;
$objadminprofile = new laundry_adminprofile();
$objadminprofile->conn = $conn;
$settings = new laundry_setting();
$settings->conn = $conn;
$booking= new laundry_booking();
$booking->conn=$conn;
if(isset($_POST['action']) && filter_var($_POST['action'])=='rating_review'){
	$staff_ids_array = explode(",",filter_var($_POST['staff_id']));
	foreach($staff_ids_array as $staff_id){
		$rating_review->rating=filter_var($_POST['rating']);
		$rating_review->review=filter_var($_POST['review']);
		$rating_review->order_id=filter_var($_POST['order_id']);
		$rating_review->staff_id=$staff_id;  
		$rating_review->add_rating();
	}
}
?>