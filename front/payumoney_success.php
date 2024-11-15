<?php 
session_start();
include(dirname(dirname(__FILE__)).'/header.php');
include(dirname(dirname(__FILE__)).'/objects/class_connection.php');
include(dirname(dirname(__FILE__)).'/objects/class_setting.php');

$database= new laundry_db();
$conn=$database->connect();
/* $database->conn=$conn; */
$settings=new laundry_setting();
$settings->conn=$conn;

$status=filter_var($_POST["status"]);
$firstname=filter_var($_POST["firstname"]);
$amount=filter_var($_POST["amount"]);
$txnid=filter_var($_POST["txnid"]);
$_SESSION['ld_details']['paumoney_transaction_id'] = filter_var($_POST["txnid"]);
$posted_hash=filter_var($_POST["hash"]);
$key=filter_var($_POST["key"]);
$productinfo=filter_var($_POST["productinfo"]);
$email=filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$salt=$settings->get_option('ld_payumoney_salt');

If (isset($_POST["additionalCharges"])) {
	$additionalCharges=filter_var($_POST["additionalCharges"]);
	$retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
}else {	  
	$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
}
$hash = hash("sha512", $retHashSeq);
if ($hash != $posted_hash) {
	echo "Invalid Transaction. Please try again";
}else{
	?>
	<script>window.location = '<?php echo FRONT_URL; ?>booking_complete.php'; </script>
	<?php 
}
?>