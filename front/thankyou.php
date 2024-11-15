<?php  
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include(dirname(dirname(__FILE__)).'/header.php');
include(dirname(dirname(__FILE__)) . "/objects/class_connection.php");
include(dirname(dirname(__FILE__)) . '/objects/class_setting.php');
$con = new laundry_db();
$conn = $con->connect();
$settings = new laundry_setting();
$settings->conn = $conn;
$lang = $settings->get_option("ld_language");
$label_language_values = array();
$language_label_arr = $settings->get_all_labelsbyid($lang);
if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "")
{
	$default_language_arr = $settings->get_all_labelsbyid("en");
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
    $default_language_arr = $settings->get_all_labelsbyid("en");
    
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
?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo filter_var($settings->get_option("ld_page_title")); ?> | Thank you</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
	
<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/ld-thankyou.css" type="text/css" media="all"/>

</head>
<body>
<div id="ld" class="ld-wrapper">
	<div class="ld-container">
		<div class="booking-tankyou">
            <h1 class="header1"><?php echo filter_var($label_language_values['thankyou']); ?></h1>
            <h3 class="header3"><?php echo filter_var($label_language_values['thankyou_for_booking_appointment']); ?>.</h3>
            <p class="thankyou-text"><?php echo filter_var($label_language_values['you_will_be_notified_by_email_with_details_of_appointment']); ?>.</p>
		</div>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
	var timer = 3; /* seconds */
    website = '<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>';
    function delayer() {
        window.location = website;
    }
    setTimeout('delayer()', 1000 * timer);
</script>