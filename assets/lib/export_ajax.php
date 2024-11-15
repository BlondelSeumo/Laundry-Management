<?php 
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_setting.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_general.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_booking.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_services_methods_units.php');
	
	$con = new laundry_db();
	$conn = $con->connect();
	$general=new laundry_general();
	$general->conn=$conn;
	$setting = new laundry_setting();
	$setting->conn = $conn;
	$booking = new laundry_booking();
	$booking->conn = $conn;
	$service_unit = new laundry_services_methods_units();
	$service_unit->conn = $conn;
	
	$symbol_position=$setting->get_option('ld_currency_symbol_position');
	$decimal=$setting->get_option('ld_price_format_decimal_places');
	
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
	
	
	/* Below Code is use for display details of service addons*/
	if(isset($_POST['action']) && filter_var($_POST['action'])=='display_ser_units'){
		$service_unit->services_id=filter_var($_POST['id']);
		$display_ser_unit = $service_unit->get_all_units();
        $cnt = 1;
		while($row=mysqli_fetch_array($display_ser_unit)){
		?>
		<tr>
            <td><?php echo filter_var($cnt);?></td>
			<td><?php echo filter_var($row['units_title']);?></td>											
			<td><?php echo filter_var($general->ld_price_format($row['base_price'],$symbol_position,$decimal)); ?></td>
			<td><?php echo filter_var($row['minlimit']);?></td>
			<td><?php echo filter_var($row['maxlimit']);?></td>
		</tr>
		<?php 
		$cnt++;}
	}
	
	/* Below Code is use for display details of Booking service addons*/
	if(isset($_POST['action']) && filter_var($_POST['action'])=='display_booking_units'){
		$booking->order_id = filter_var($_POST['id']);
		$display_booking_units = $booking->get_booking_units_from_order();
    $cnt = 1;
		while($row2=mysqli_fetch_array($display_booking_units)){
			if($row2['unit_qty']==0){
				break;
			}
		?>
		<tr>
			<td><?php echo filter_var($cnt);?></td>
			<td><?php echo filter_var($row2["unit_name"]); ?></td>
			<td><?php echo filter_var($general->ld_price_format($row2['unit_rate'],$symbol_position,$decimal)); ?></td>
            <td><?php echo filter_var($row2['unit_qty']); ?></td>
        </tr>
		<?php 
            $cnt++;
		}
	}
?>