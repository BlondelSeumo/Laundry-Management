<?php  

$filename =  '../config.php';
$file = file_exists($filename);
if($file){
	if(!filesize($filename) > 0){					 										   
		header('location:../ld_install.php');									
	}	 
}else{
	echo "Config file does not exist";
}

session_start();
include(dirname(dirname(__FILE__)).'/header.php');
include(dirname(dirname(__FILE__))."/objects/class_adminprofile.php");
include(dirname(dirname(__FILE__)).'/objects/class_connection.php');
include(dirname(dirname(__FILE__))."/objects/class_dayweek_avail.php");
include(dirname(dirname(__FILE__)).'/objects/class_setting.php');
$database= new laundry_db();
$conn=$database->connect();
$database->conn=$conn; 
$settings=new laundry_setting();
$settings->conn=$conn;
$adminprofile = new laundry_adminprofile();
$adminprofile->conn = $conn;
$timeavailability= new laundry_dayweek_avail();
$timeavailability->conn = $conn;
$check_for_products  = "select * from ld_services,ld_service_units";
$hh = mysqli_query($conn,$check_for_products);
$t = $timeavailability->get_timeavailability_check();
$last = "";
if($settings->get_option('ld_company_address')=="" ||
    $settings->get_option('ld_company_city')=="" ||
    $settings->get_option('ld_company_state')=="" ||
    $settings->get_option('ld_company_name')=="" ||
    $settings->get_option('ld_company_email')=="" ||
    $settings->get_option('ld_company_zip_code')=="" ||
    $settings->get_option('ld_company_country')=="" ){
		$last = "cna";
	}else if(mysqli_num_rows($hh)==""){
		$last = "sna";
	}else if(mysqli_num_rows($t)==""){
	    $last = "pss";
	}else{
		header("Location:".BASE_URL); 
	}
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
}else{
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
<title><?php echo filter_var($settings->get_option("ld_page_title")); ?> | Maintainance</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/backgrounds/<?php echo filter_var($settings->get_option('ld_favicon_image'));?>"/>
<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/ld-thankyou.css" type="text/css" media="all"/> 															
</head>
<body>
    <div id="ld" class="ld-wrapper">
		<div class="ld-container">
			<div class="booking-tankyou">	
			<h1 class="header1"><?php echo filter_var($label_language_values['warning']); ?></h1>	
			<h3 class="header3">
			<?php  echo filter_var($label_language_values['please_fill_all_the_company_informations_and_add_some_services_and_addons']); ?></h3>
			<h3 class="header3">
			<?php 
				if($last!=""){
					if($last=="sna"){
						Echo filter_var("Please add atleast single service with enable status (Laundry->Admin->Services)");
					}else if($last=="cna"){
						Echo filter_var("Please add your company profile data (Laundry->Admin->Settings->Company)");
					}else if($last=="pss"){
						Echo filter_var("Please add availability schedule (Laundry->Admin->Schedule->availability)");
					}else{
						echo filter_var("");
					}
				}
			?>
			</h3>
																								  
			<?php   
			if(isset($_SESSION['ld_adminid']) && $_SESSION['ld_adminid'] != "")
			{
				
				if($last=="sna"){
						$link = "services.php";
					}else if($last=="cna"){
						$link = "settings.php";
					}else if($last=="pss"){
						$link = "schedule.php";
					}else{
						$link = "";
					}
				
				?>
				<div class="ld-col-12"><a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>admin/<?php echo filter_var($link); ?>" class="ld-button"><?php echo filter_var($label_language_values['configure_now_new']); ?></a></div>
				<?php  
			}
			?>			
			</div>
		</div>
	</div>
</body>
</html>