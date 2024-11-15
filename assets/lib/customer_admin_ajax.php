<?php  
include(dirname(dirname(dirname(__FILE__)))."/objects/class_connection.php");
include(dirname(dirname(dirname(__FILE__))).'/objects/class_users.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_order_client_info.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_setting.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_booking.php');
include(dirname(dirname(dirname(__FILE__)))."/objects/class_adminprofile.php");			   
include(dirname(dirname(dirname(__FILE__)))."/objects/class_services.php");			   

$con = new laundry_db();
$conn = $con->connect();
$objadminprofile = new laundry_adminprofile();
$objadminprofile->conn = $conn;
$user=new laundry_users();
$order_client_info=new laundry_order_client_info();
$setting = new laundry_setting();
$setting->conn = $conn;
$booking = new laundry_booking();
$booking->conn = $conn;
$services = new laundry_services();
$services->conn = $conn;
$getdateformat=$setting->get_option('ld_date_picker_date_format');
$time_format = $setting->get_option('ld_time_format');
$user->conn=$conn;
$order_client_info->conn=$conn;

$lang = $setting->get_option("ld_language");
$label_language_values = array();
$language_label_arr = $setting->get_all_labelsbyid($lang);
if(isset($_POST['action']) && filter_var($_POST['action'])=='add_customer_registers'){	
	$user->user_email=filter_var($_POST['ld_email'], FILTER_SANITIZE_EMAIL);
	$user->user_pwd=md5(filter_var($_POST['ld_password']));
	$user->first_name=filter_var($_POST['ld_first_name']);
	$user->last_name=filter_var($_POST['ld_last_name']);
	$user->phone=filter_var($_POST['ld_phone']);
	$user->address=filter_var($_POST['ld_address']);
	$user->zip=filter_var($_POST['ld_zip_code']);
	$user->city=filter_var($_POST['ld_city']);
	$user->state=filter_var($_POST['ld_state']);
	$user->usertype=serialize(array('client'));	
	$add_customer_register=$user->add_customer_register(); 
}
if(isset($_POST['ld_email'])){
	$user->user_email = trim(strip_tags(mysqli_real_escape_string($conn, filter_var($_POST['ld_email'], FILTER_SANITIZE_EMAIL))));
	$check_customer_email_existing = $user->check_customer_email_existing();
	if($check_customer_email_existing > 0){
		echo filter_var('false');
	}else{
		echo filter_var("true");
	}
} 

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
if(isset($_POST['getclient_bookings_details'])){
	/*new file include*/
	include(dirname(dirname(dirname(__FILE__))).'/assets/lib/date_translate_array.php');
    /* client id */
    $user->user_id = filter_var($_POST['id']);
    $clientinfo = $user->readone();
    $client_id = $clientinfo[0];
    /* get all bookings of the selected client */
    $clientbooking = $user->get_user_bookingss();
    $cnti = 1;
    while($cc = mysqli_fetch_array($clientbooking)){
			$service_ids = explode(",",$cc["service_id"]);
				$service_name = "";
				$color = "";
				foreach($service_ids as $id){
						$services->id = $id;
						$result = $services->readone();
						$service_name .= $result["title"].","; 
						$color=$result['color'];
				}
				$title = chop($service_name,","); 
        if($cc['booking_status']=='A')
				{
					$booking_stats=$label_language_values['active'];
				}
				elseif($cc['booking_status']=='C')
				{
					$booking_stats=$label_language_values['confirm'];
				}
				elseif($cc['booking_status']=='R')
				{
					$booking_stats=$label_language_values['reject'];
				}
				elseif($cc['booking_status']=='RS')
				{
					$booking_stats=$label_language_values["rescheduled"];
				}
				elseif($cc['booking_status']=='CC')
				{
					$booking_stats=$label_language_values['cancel_by_client'];
				}
				elseif($cc['booking_status']=='CS')
				{
					$booking_stats=$label_language_values['cancelled_by_service_provider'];
				}
				elseif($cc['booking_status']=='CO')
				{
					$booking_stats=$label_language_values['completed'];
				}
				else
				{
					$cc['booking_status']=='MN';
					$booking_stats=$label_language_values['mark_as_no_show'];
				}
    ?>
        <tr>
            <td><?php echo filter_var($cnti);?></td>
            <td><?php echo filter_var($title);?></td>
           <?php 
			if($time_format == 12){
			?>
			<td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat." h:i A",strtotime($cc['booking_pickup_date_time_start'])));?></td>
			<?php 
			}else{
			?>
            <td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat." H:i",strtotime($cc['booking_pickup_date_time_start'])));?></td>
			<?php 
			}
			?>
            <td><?php echo filter_var($booking_stats);?></td>
            <td><?php  if($cc['pna'] != 0){ echo filter_var($cc['c_payment_method']);} else { echo filter_var($label_language_values['free']);};?></td>
            <td>
                <?php 
                /* methods */
                $units = $label_language_values['none'];
                
                $hh = $booking->get_units_ofbookings($cc['order_id']);
                while($jj = mysqli_fetch_array($hh)){
                    if($units == $label_language_values['none']){
                        $units = $jj['unit_name']."-".$jj['unit_qty'];
                    }
                    else
                    {
                        $units = $units.",".$jj['unit_name']."-".$jj['unit_qty'];
                    }
                }
                ?>
                <b><?php echo filter_var($label_language_values['units']);?></b> - <?php  echo filter_var($units);?>
            </td>
			<td> 
			<?php  
			$result_staff_info = array();
			$booking->order_id = $cc['order_id'];
			$staff_status_detail = $booking->staff_status_read_one_by_or_id();
			if(mysqli_num_rows($staff_status_detail) > 0){
				while($row = mysqli_fetch_assoc($staff_status_detail)){
					$objadminprofile->id = $row['staff_id'];
					$result_staff_info = $objadminprofile->readone();
					
					?>
					
					<b><?php  echo filter_var($result_staff_info['fullname']);?></b> - <?php  if($row['status']=='A'){ echo filter_var($label_language_values['accept']); }else{ echo filter_var($label_language_values['decline']); }?> <br>
					
					<?php  
					
				}
			}
			
			?>
			</td>
    </tr>
    <?php 
    $cnti++;}?>
<?php 
}
elseif(isset($_POST['guest'])){
	/*new file include*/
	include(dirname(dirname(dirname(__FILE__))).'/assets/lib/date_translate_array.php');
    /* get all bookings of the selected client */
    $order_id = filter_var($_POST['orderid']);
    $clientbooking = $user->get_bookings_guests($_POST['orderid'],filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $cntgi = 1;
        while($cc = mysqli_fetch_array($clientbooking)){
						$service_ids = explode(",",$cc["service_id"]);
						$service_name = "";
						$color = "";
						foreach($service_ids as $id){
								$services->id = $id;
								$result = $services->readone();
								$service_name .= $result["title"].","; 
								$color=$result['color'];
						}
						$title = chop($service_name,","); 
            if($cc['booking_status']=='A')
            {
                $booking_stats=$label_language_values['active'];
            }
            elseif($cc['booking_status']=='C')
            {
                $booking_stats=$label_language_values['confirm'];
            }
            elseif($cc['booking_status']=='R')
            {
                $booking_stats=$label_language_values['reject'];
            }
            elseif($cc['booking_status']=='RS')
            {
                $booking_stats=$label_language_values["rescheduled"];
            }
            elseif($cc['booking_status']=='CC')
            {
                $booking_stats=$label_language_values['cancel_by_client'];
            }
            elseif($cc['booking_status']=='CS')
            {
                $booking_stats=$label_language_values['cancelled_by_service_provider'];
            }
            elseif($cc['booking_status']=='CO')
            {
                $booking_stats=$label_language_values['completed'];
            }
            else
            {
                $cc['booking_status']=='MN';
                $booking_stats=$label_language_values['mark_as_no_show'];
            }
            ?>
            <tr>
                <td><?php echo filter_var($cntgi);?></td>
                <td><?php echo filter_var($title);?></td>
                <?php 
				if($time_format == 12){
				?>
				<td><?php echo str_replace($english_date_array,$selected_lang_label,date("".$getdateformat." h:i A",strtotime($cc['booking_pickup_date_time_start'])));?></td>
				<?php 
				}else{
				?>
				<td><?php echo str_replace($english_date_array,$selected_lang_label,date("".$getdateformat." H:i",strtotime($cc['booking_pickup_date_time_start'])));?></td>
				<?php 
				}
				?>
                <td><?php echo filter_var($booking_stats);?></td>
                <td><?php  if($cc['pna'] != 0){ echo filter_var($cc['c_payment_method']);} else { echo filter_var($label_language_values['free']);};?></td>
                <td>
                    <?php										
										$units = $label_language_values['none'];
    
										$booking->order_id = $order_id;
										$book_unit_detail = $booking->get_booking_units_from_order($order_id);
										if($book_unit_detail->num_rows > 0)
										{
											$units_array = array();
											while($unit_row = mysqli_fetch_assoc($book_unit_detail))
											{
												$units_array[] = $unit_row["unit_name"]." - ".$unit_row["unit_qty"];
											}
											$units = implode(", ",$units_array);
										}
                    ?>
             
                    <b><?php echo filter_var($label_language_values['units']);?></b> - <?php  echo filter_var($units);?>
                </td>
            </tr>
        <?php 
       $cntgi++; }?>
<?php  }
elseif(isset($_POST['delete_guest_bookings'])){
$order_id = filter_var($_POST['orderid']);
    $user->delete_bookings_guestcustomers($order_id);
}
elseif(isset($_POST['delete_registered_bookings'])){
	$usersid = filter_var($_POST['usersid']);
    $user->delete_bookings_registeredcustomers($usersid);
}
?>