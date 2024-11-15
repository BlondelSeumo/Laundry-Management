<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	session_start(); 
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
	include(dirname(dirname(dirname(__FILE__))).'/header.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_front_first_step.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_setting.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_dayweek_avail.php');
	if ( is_file(dirname(dirname(dirname(__FILE__))).'/extension/GoogleCalendar/google-api-php-client/src/Google_Client.php')){
		require_once dirname(dirname(dirname(__FILE__))).'/extension/GoogleCalendar/google-api-php-client/src/Google_Client.php';
	}
	include(dirname(dirname(dirname(__FILE__)))."/objects/class_gc_hook.php");
	  
	$database= new laundry_db();
	$conn=$database->connect();
	
	$gc_hook = new laundry_gcHook();
	$gc_hook->conn = $conn;
	
	$first_step=new laundry_first_step();
	$first_step->conn=$conn;
	
	$week_day_avail=new laundry_dayweek_avail();
	$week_day_avail->conn=$conn;
	
	$setting=new laundry_setting();
	$setting->conn=$conn;
	$date_format = $setting->get_option('ld_date_picker_date_format');
	$time_interval = $setting->get_option('ld_time_interval');	
	$time_slots_schedule_type = $setting->get_option('ld_time_slots_schedule_type');
	$advance_bookingtime = $setting->get_option('ld_min_advance_booking_time');
	$ld_service_padding_time_before = $setting->get_option('ld_service_padding_time_before');
	$ld_service_padding_time_after = $setting->get_option('ld_service_padding_time_after');
	$ld_calendar_firstDay = $setting->get_option('ld_calendar_firstDay');
	$booking_padding_time = $setting->get_option('ld_booking_padding_time');
	$lang = "";
	if(isset($_SESSION['current_lang'])){
		$lang = $_SESSION['current_lang'];
	}else{
		$lang = $setting->get_option("ld_language");
	}
$label_language_values = array();
$language_label_arr = $setting->get_all_labelsbyid($lang);

if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "" || $language_label_arr[6] != "")
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
	if($language_label_arr[6] != ''){
		$label_decode_front_form_errors = base64_decode($language_label_arr[6]);
	}else{
		$label_decode_front_form_errors = base64_decode($default_language_arr[6]);
	}
	
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
	$label_decode_front_form_errors_unserial = unserialize($label_decode_front_form_errors);
    
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial,$label_decode_front_form_errors_unserial);
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
	$label_decode_front_form_errors = base64_decode($default_language_arr[6]);
	
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
	$label_decode_front_form_errors_unserial = unserialize($label_decode_front_form_errors);
    
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial,$label_decode_front_form_errors_unserial);
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}

/*new file include*/
include(dirname(dirname(dirname(__FILE__))).'/assets/lib/date_translate_array.php');

if(isset($_SESSION['staff_id_cal']) && $_SESSION['staff_id_cal']!=""){
	$staff_id = $_SESSION['staff_id_cal'];
}else{
	$staff_id = '1';
}

if(isset($_POST['get_pickup_slots'])){
		$t_zone_value = $setting->get_option('ld_timezone');
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
		
		$select_time=date('Y-m-d',strtotime($_POST['selected_dates']));
		$start_date = date($select_time,$currDateTime_withTZ);

		
/** Get Google Calendar Bookings **/
		$providerCalenderBooking = array();
		if($gc_hook->gc_purchase_status() == 'exist'){
			$gc_hook->google_cal_TwoSync_hook();
		}
		/** Get Google Calendar Bookings **/
		
		$time_interval = $setting->get_option('ld_time_interval');	
		$time_slots_schedule_type = $setting->get_option('ld_time_slots_schedule_type');
		$advance_bookingtime = $setting->get_option('ld_min_advance_booking_time');
		$ld_service_padding_time_before = $setting->get_option('ld_service_padding_time_before');
		$ld_service_padding_time_after = $setting->get_option('ld_service_padding_time_after');
		
		$booking_padding_time = $setting->get_option('ld_booking_padding_time');
		$time_schedule = $first_step->get_day_time_slot_by_provider_id($time_slots_schedule_type,$start_date,$time_interval,$advance_bookingtime,$ld_service_padding_time_before,$ld_service_padding_time_after,$timezonediff,$booking_padding_time,$staff_id); 
		
		
		$allbreak_counter = 0;	
		$allofftime_counter = 0;
		$slot_counter = 0;
		$week_day_avail_count = $week_day_avail->get_data_for_front_cal();
	?>
			<?php  
			if(mysqli_num_rows($week_day_avail_count) > 0)
			{
				if($time_schedule['off_day']!=true && isset($time_schedule['slots']) && sizeof($time_schedule['slots'])>0 && $allbreak_counter != sizeof($time_schedule['slots']) && $allofftime_counter != sizeof($time_schedule['slots']))
				{ 
					for($i = 0 ; $i < (count($time_schedule['slots']) - 1) ; $i++)
					{ 
						$curreslotstr = strtotime(date(date('Y-m-d H:i:s',strtotime($select_time.' '.$time_schedule['slots'][$i])),$currDateTime_withTZ));
						
						$gccheck = 'N';
						
						if(sizeof($providerCalenderBooking)>0){
							for($i = 0; $i < sizeof($providerCalenderBooking); $i++) {
								if($curreslotstr >= $providerCalenderBooking[$i]['start'] && $curreslotstr < $providerCalenderBooking[$i]['end']){
									$gccheck = 'Y';
								}
							}
						}
						
						
						$ifbreak = 'N';
						
						foreach($time_schedule['breaks'] as $daybreak) {
							if(strtotime($time_schedule['slots'][$i]) >= strtotime($daybreak['break_start']) && strtotime($time_schedule['slots'][$i]) < strtotime($daybreak['break_end'])) {
							   $ifbreak = 'Y';   
							}
						}
						
	 


				   

													 
																																									   
					 
	  
	 

						if($ifbreak=='Y') { $allbreak_counter++; continue; } 
						
			  
	 

						$ifofftime = 'N';
														
						foreach($time_schedule['offtimes'] as $offtime) {
							if(strtotime($_POST['selected_dates'].' '.$time_schedule['slots'][$i]) >= strtotime($offtime['offtime_start']) && strtotime($_POST['selected_dates'].' '.$time_schedule['slots'][$i]) < strtotime($offtime['offtime_end'])) {
							   $ifofftime = 'Y';
							}
						 }
						
						if($ifofftime=='Y') { $allofftime_counter++; continue; }
						
			  
	 

						$complete_time_slot = mktime(date('H',strtotime($time_schedule['slots'][$i])),date('i',strtotime($time_schedule['slots'][$i])),date('s',strtotime($time_schedule['slots'][$i])),date('n',strtotime($time_schedule['date'])),date('j',strtotime($time_schedule['date'])),date('Y',strtotime($time_schedule['date']))); 
									
						 if($setting->get_option('ld_hide_faded_already_booked_time_slots')=='on' && (in_array($complete_time_slot,$time_schedule['booked'])) || $gccheck=='Y') {
							 continue;
						 }
						if( (in_array($complete_time_slot,$time_schedule['booked']) || $gccheck=='Y') && ($setting->get_option('ld_allow_multiple_booking_for_same_timeslot_status')!='Y') ) { ?>
							<?php 
							if($setting->get_option('ld_hide_faded_already_booked_time_slots')=="off"){
								?>
								<option class="time-slot br-2 ld-slot-booked">
									<?php  
									if($setting->get_option('ld_time_format')==24){
										
										echo date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));
									}else{
										echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i])))." to ".str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i+1])));
									}?>
								</option>
							<?php 
							}
							?>
						<?php 
						} else { 
							if($setting->get_option('ld_time_format')==24){
								$slot_time = date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));
								$slotdbb_time = date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));
								$ld_time_selected = date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));
							}else{
								$slot_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i])))." to ".str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i+1])));
								$slotdbb_time = date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));
								$ld_time_selected = str_replace($english_date_array,$selected_lang_label,date("h:iA",strtotime($time_schedule['slots'][$i])))." to ".str_replace($english_date_array,$selected_lang_label,date("h:iA",strtotime($time_schedule['slots'][$i+1])));
							}
							
							if($i == 0)
							{
							?>
							<option>-Select Slot Interval-</option>
							<?php
							}						
							?>
							
							<option class="time-slot br-2 time_slotss" data-slot_date_to_display="<?php echo str_replace($english_date_array,$selected_lang_label,date($date_format,strtotime($_POST["selected_dates"]))); ?>" data-ld_date_selected="<?php echo  str_replace($english_date_array,$selected_lang_label,date('D, j F, Y',strtotime($_POST["selected_dates"]))); ?>"  data-slot_date="<?php echo $_POST["selected_dates"]; ?>" data-slot_time="<?php echo $slot_time; ?>" data-slotdb_time="<?php echo $slotdbb_time; ?>" data-slotdb_date="<?php echo date('Y-m-d',strtotime($_POST["selected_dates"])); ?>" data-ld_time_selected="<?php echo $ld_time_selected; ?>">
								<?php 
									if($setting->get_option('ld_time_format')==24){echo date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));}else{echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i])))." to ".str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i+1])));}

																																	
			   
																																																																													  
								?>
							</option>
						<?php  
						} $slot_counter++; 
					}
	   
		  
			
														
																																		  
																																			 
																																				 
			 
																																																																															 
																																			 
																																																																																   
	  

				   
	   
											 
		  
	  
	   

																																																																																																																																																																																																																									
		   
														 
																																   
			  
																																																																													
	   
		
			  
		 
	 
					
	
					if($allbreak_counter != 0 && $allofftime_counter != 0){ ?>
					<option class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo $label_language_values['none_of_time_slot_available_please_check_another_dates']; ?></option>
				   <?php  }
				   
				   if($allbreak_counter == sizeof($time_schedule['slots']) && sizeof($time_schedule['slots'])!=0){ ?>
					<option class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo $label_language_values['none_of_time_slot_available_please_check_another_dates']; ?></option>
				   <?php  }
				   if($allofftime_counter > sizeof($time_schedule['offtimes']) && sizeof($time_schedule['slots'])==$allofftime_counter){?>
					<option class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo $label_language_values['none_of_time_slot_available_please_check_another_dates']; ?></option>
				   <?php  }      
				   } else {?>
					<option class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo $label_language_values['none_of_time_slot_available_please_check_another_dates']; ?></option>
				   <?php  } 
				   } else {?>
					<option class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo $label_language_values['availability_is_not_configured_from_admin_side']; ?></option>
				   <?php  } ?>
	
	<?php 
}

if(isset($_POST['get_delivery_slots'])){
		$t_zone_value = $setting->get_option('ld_timezone');
		$minimum_delivery_minutes = $setting->get_option('ld_minimum_delivery_minutes');
		$minimum_delivery_hours =((int)$minimum_delivery_minutes/60);
		$pickup_date = $_POST['pickup_date'];	
		$pickup_slots = $_POST['pickup_slots'];
		/* if($minimum_delivery_hours < 24){
			
		} */
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
		
		$select_time=date('Y-m-d',strtotime($_POST['selected_dates']));
		$start_date = date($select_time,$currDateTime_withTZ);
		
		/** Get Google Calendar Bookings **/
		$providerCalenderBooking = array();
		if($gc_hook->gc_purchase_status() == 'exist'){
			$gc_hook->google_cal_TwoSync_hook();
		}
		/** Get Google Calendar Bookings **/
		
		$time_interval = $setting->get_option('ld_time_interval');	
		$time_slots_schedule_type = $setting->get_option('ld_time_slots_schedule_type');
		$advance_bookingtime = $setting->get_option('ld_min_advance_booking_time');
		$ld_service_padding_time_before = $setting->get_option('ld_service_padding_time_before');
		$ld_service_padding_time_after = $setting->get_option('ld_service_padding_time_after');
		
		$booking_padding_time = $setting->get_option('ld_booking_padding_time');
		$time_schedule = $first_step->get_day_time_slot_by_provider_id($time_slots_schedule_type,$start_date,$time_interval,$advance_bookingtime,$ld_service_padding_time_before,$ld_service_padding_time_after,$timezonediff,$booking_padding_time,$staff_id); 
		
		$allbreak_counter = 0;	
		$allofftime_counter = 0;
		$slot_counter = 0;
		$week_day_avail_count = $week_day_avail->get_data_for_front_cal();
	?>
			<?php  
			if(mysqli_num_rows($week_day_avail_count) > 0)
			{
				if($time_schedule['off_day']!=true && isset($time_schedule['slots']) && sizeof($time_schedule['slots'])>0 && $allbreak_counter != sizeof($time_schedule['slots']) && $allofftime_counter != sizeof($time_schedule['slots']))
				{ 
					for($i = 0 ; $i < (count($time_schedule['slots']) - 1) ; $i++)
					{ 
						$curreslotstr = strtotime(date(date('Y-m-d H:i:s',strtotime($select_time.' '.$time_schedule['slots'][$i])),$currDateTime_withTZ));
						
						$gccheck = 'N';
						
						if(sizeof($providerCalenderBooking)>0){
							for($i = 0; $i < sizeof($providerCalenderBooking); $i++) {
								if($curreslotstr >= $providerCalenderBooking[$i]['start'] && $curreslotstr < $providerCalenderBooking[$i]['end']){
									$gccheck = 'Y';
								}
							}
						}
						
						
						$ifbreak = 'N';
						
						foreach($time_schedule['breaks'] as $daybreak) {
							if(strtotime($time_schedule['slots'][$i]) >= strtotime($daybreak['break_start']) && strtotime($time_schedule['slots'][$i]) < strtotime($daybreak['break_end'])) {
							   $ifbreak = 'Y';   
							}
						}
						
	 


				   

													 
																																									   
					 
	  
	 

						if($ifbreak=='Y') { $allbreak_counter++; continue; } 
						
			  
	 

						$ifofftime = 'N';
														
						foreach($time_schedule['offtimes'] as $offtime) {
							if(strtotime($_POST['selected_dates'].' '.$time_schedule['slots'][$i]) >= strtotime($offtime['offtime_start']) && strtotime($_POST['selected_dates'].' '.$time_schedule['slots'][$i]) < strtotime($offtime['offtime_end'])) {
							   $ifofftime = 'Y';
							}
						 }
						
						if($ifofftime=='Y') { $allofftime_counter++; continue; }
						
			  
	 

						$complete_time_slot = mktime(date('H',strtotime($time_schedule['slots'][$i])),date('i',strtotime($time_schedule['slots'][$i])),date('s',strtotime($time_schedule['slots'][$i])),date('n',strtotime($time_schedule['date'])),date('j',strtotime($time_schedule['date'])),date('Y',strtotime($time_schedule['date']))); 
									
						 if($setting->get_option('ld_hide_faded_already_booked_time_slots')=='on' && (in_array($complete_time_slot,$time_schedule['booked'])) || $gccheck=='Y') {
							 continue;
						 }
						if( (in_array($complete_time_slot,$time_schedule['booked']) || $gccheck=='Y') && ($setting->get_option('ld_allow_multiple_booking_for_same_timeslot_status')!='Y') ) { ?>
							<?php 
							if($setting->get_option('ld_hide_faded_already_booked_time_slots')=="off"){
								?>
								<li class="time-slot br-2 ld-slot-booked">
									<?php  
									if($setting->get_option('ld_time_format')==24){
										
										echo date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));
									}else{
										echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i])))." to ".str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i+1])));
									}?>
								</li>
							<?php 
							}
							?>
						<?php 
						} else { 
							if($setting->get_option('ld_time_format')==24){
								$slot_time = date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));
								$slotdbb_time = date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));
								$ld_time_selected = date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));
							}else{
								$slot_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i])))." to ".str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i+1])));
								$slotdbb_time = date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));
								$ld_time_selected = str_replace($english_date_array,$selected_lang_label,date("h:iA",strtotime($time_schedule['slots'][$i])))." to ".str_replace($english_date_array,$selected_lang_label,date("h:iA",strtotime($time_schedule['slots'][$i+1])));
							}
							
							if($i == 0)
							{
							?>
							<option>-Select Slot Interval-</option>
							<?php
							}						
							?>
						
							<option class="time-slot br-2 time_slotss" data-slot_date_to_display="<?php echo str_replace($english_date_array,$selected_lang_label,date($date_format,strtotime($_POST["selected_dates"]))); ?>" data-ld_date_selected="<?php echo  str_replace($english_date_array,$selected_lang_label,date('D, j F, Y',strtotime($_POST["selected_dates"]))); ?>"  data-slot_date="<?php echo $_POST["selected_dates"]; ?>" data-slot_time="<?php echo $slot_time; ?>" data-slotdb_time="<?php echo $slotdbb_time; ?>" data-slotdb_date="<?php echo date('Y-m-d',strtotime($_POST["selected_dates"])); ?>" data-ld_time_selected="<?php echo $ld_time_selected; ?>">
								<?php 
									if($setting->get_option('ld_time_format')==24){echo date("H:i",strtotime($time_schedule['slots'][$i]))." to ".date("H:i",strtotime($time_schedule['slots'][$i+1]));}else{echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i])))." to ".str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($time_schedule['slots'][$i+1])));}

																																	
			   
																																																																													  
								?>
							</option>
							<?php 
						} $slot_counter++; 
					}
	   
		  
			
														
																																		  
																																			 
																																				 
			 
																																																																															 
																																			 
																																																																																   
	  

				   
	   
											 
		  
	  
	   

																																																																																																																																																																																																																									
		   
														 
																																   
			  
																																																																													
	   
		
			  
		 
	 
					
	
					if($allbreak_counter != 0 && $allofftime_counter != 0){ ?>
					<option class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo $label_language_values['none_of_time_slot_available_please_check_another_dates']; ?></option>
				   <?php  }
				   
				   if($allbreak_counter == sizeof($time_schedule['slots']) && sizeof($time_schedule['slots'])!=0){ ?>
					<option class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo $label_language_values['none_of_time_slot_available_please_check_another_dates']; ?></option>
				   <?php  }
				   if($allofftime_counter > sizeof($time_schedule['offtimes']) && sizeof($time_schedule['slots'])==$allofftime_counter){?>
					<option class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo $label_language_values['none_of_time_slot_available_please_check_another_dates']; ?></option>
				   <?php  }      
				   } else {?>
					<option class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo $label_language_values['none_of_time_slot_available_please_check_another_dates']; ?></option>
				   <?php  } 
				   } else {?>
					<option class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo $label_language_values['availability_is_not_configured_from_admin_side']; ?></option>
				   <?php  } ?>
	<?php 
}
?>