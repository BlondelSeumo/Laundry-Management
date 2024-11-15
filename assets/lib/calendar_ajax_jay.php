<?php  

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
	$database->conn=$conn;
	
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


if(isset($_POST['get_calendar']))
{
	?>
<script>
jQuery(document).ready(function() {
	jQuery('.ld-tooltipss-load').tooltipster({
		animation: 'grow',
		delay: 20,
		theme: 'tooltipster-shadow',
		trigger: 'hover'
	});
});
</script><?php
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
		
	  $ld_max_advance_booking_time = $setting->get_option('ld_max_advance_booking_time');
	  $datetime_withmaxtime = strtotime('+'.$ld_max_advance_booking_time.' month',strtotime(date('Y-m-d',$currDateTime_withTZ)));
	  
	  $month=filter_var($_POST['month']);
	  $year=filter_var($_POST['year']); 
	  $date = mktime(12, 0, 0, $month, 1, $year);

	  $yearss = date("Y",$date);
	  $monthss =  date("m",$date);
	  $prevmonthlink =  strtotime(date("Y-m-d",$date));
	  $currrmonthlink =  strtotime(date("Y-m-d",$currDateTime_withTZ));
	  
	  $daysInMonth = date("t", $date);
	  /* calculate the position of the first day in the calendar (sunday = 1st column, etc) */
	  if($ld_calendar_firstDay == '1'){
		$offset = date("N", $date);
	  }else{
		$offset = date("w", $date);
	  }
	  $rows = 1;
	  
	  $next_months=strtotime('+1 month', $date);
	  $prev_months=strtotime('-1 month', $date);
	  
	  ?>
	
	<div class="calender_months_full_detail <?php    echo filter_var($monthss."_".$yearss); ?>">
	  <div class="calendar-header">
			<?php 
			if($currrmonthlink < $prevmonthlink){
			?>
			<a data-istoday="N" class="previous-date previous_next" href="javascript:void(0)" data-next_month="<?php echo date("m", $prev_months); ?>" data-next_month_year="<?php echo date("Y", $prev_months); ?>"><i class="icon-arrow-left icons"></i></a>
			<?php 
			}else{
			?>
			<a class="previous-date" href="javascript:void(0)" ><i class="icon-arrow-left icons"></i></a>
			<?php 
			}
			?>
			
			<div class="calendar-title"><?php echo filter_var($label_language_values[strtolower(date("F", $date))]); ?></div>
			<div class="calendar-year"><?php echo date("Y", $date); ?></div>
			<?php 
			if(date('M',$datetime_withmaxtime) == date('M',$date) && date('Y',$datetime_withmaxtime) == date('Y',$date)){
			?>
				<a class="next-date" href="javascript:void(0)"><i class="icon-arrow-right icons"></i></a>
			<?php 
			}else{
			?>
			<a data-istoday="N" class="next-date previous_next" href="javascript:void(0)" data-next_month="<?php echo date("m", $next_months); ?>" data-next_month_year="<?php echo date("Y", $next_months); ?>"><i class="icon-arrow-right icons"></i></a>
			<?php 
			}
			?>
		</div>
	 <div class="calendar-body">
				<div class="weekdays fl">
					<?php  if($ld_calendar_firstDay == '0'){ ?>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['sun']); ?></span>
					</div>
					<?php  } ?>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['mon']); ?></span>
					</div>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['tue']); ?></span>
					</div>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['wed']); ?></span>
					</div>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['thu']); ?></span>
					</div>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['fri']); ?></span>
					</div>
					<?php  if($ld_calendar_firstDay == '0'){ ?>
					<div class="ld-day ld-last-day">
						<span><?php echo filter_var($label_language_values['sat']); ?></span>
					</div>
					<?php  } ?>
					<?php  if($ld_calendar_firstDay == '1'){ ?>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['sat']); ?></span>
					</div>
					<div class="ld-day ld-last-day">
						<span><?php echo filter_var($label_language_values['sun']); ?></span>
					</div>
					<?php  } ?>
				</div>
	  
	  <div class="dates">
	  <?php 
	  if($ld_calendar_firstDay == '1'){
			$get_first_day_starting = 2;
	  }else{
			$get_first_day_starting = 1;
	  }
	  for($i = $get_first_day_starting; $i <= $offset; $i++)
	  {
	  ?>
		<div class="ld-week hide_previous_dates"></div>
	  <?php 
	  }
	  $k = 0;
	  for($day = 1; $day <= $daysInMonth; $day++)
	  {
		$selected_dates = $day."-".$monthss."-".$yearss;
		$selected_dates_available = $day."-".$monthss."-".$yearss;
		$cur_dates = date('j-m-Y',$currDateTime_withTZ);
		$s_date = strtotime($selected_dates);
		$c_date = strtotime($cur_dates);
		
		/* COUNT TOTAL AVAILABLE SLOTS */
		
		$t_zone_value = $setting->get_option('ld_timezone');
		$server_timezone = date_default_timezone_get();
		if(isset($t_zone_value) && $t_zone_value!=''){
			$offset_available= $first_step->get_timezone_offset($server_timezone,$t_zone_value);
			$timezonediff = $offset_available/3600;  
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
		
		$select_time=date('Y-m-d',strtotime($selected_dates_available));
		$start_date = date($select_time,$currDateTime_withTZ);
		
		$time_interval = $setting->get_option('ld_time_interval');	
		$time_slots_schedule_type = $setting->get_option('ld_time_slots_schedule_type');
		$advance_bookingtime = $setting->get_option('ld_min_advance_booking_time');
		$ld_service_padding_time_before = $setting->get_option('ld_service_padding_time_before');
		$ld_service_padding_time_after = $setting->get_option('ld_service_padding_time_after');
		
		$time_schedule = $first_step->get_day_time_slot_by_provider_id($time_slots_schedule_type,$start_date,$time_interval,$advance_bookingtime,$ld_service_padding_time_before,$ld_service_padding_time_after,$timezonediff,$booking_padding_time,$staff_id); 
		
		$allbreak_counter = 0;	
		$allofftime_counter = 0;
		$allbooked_counter = 0;
		$slot_counter = 0;
		$check = 0;
		$week_day_avail_count = $week_day_avail->get_data_for_front_cal();
		if(isset($time_schedule['slots'])){ 
		    if(mysqli_num_rows($week_day_avail_count) > 0)
			{
				if($time_schedule['off_day']!=true && isset($time_schedule['slots']) && sizeof($time_schedule['slots'])>0 && $allbreak_counter != sizeof($time_schedule['slots']) && $allofftime_counter != sizeof($time_schedule['slots']))
				{
					foreach($time_schedule['slots']  as $slot) 
					{
						$ifbreak = 'N';
						foreach($time_schedule['breaks'] as $daybreak) {
							if(strtotime($slot) >= strtotime($daybreak['break_start']) && strtotime($slot) < strtotime($daybreak['break_end'])) {
							   $ifbreak = 'Y';
							   $check = $check+1;
							}
						}
						if($ifbreak=='Y') {  continue; } 
						
						$ifofftime = 'N';
													
						foreach($time_schedule['offtimes'] as $offtime) {
							if(strtotime($selected_dates.' '.$slot) >= strtotime($offtime['offtime_start']) && strtotime($selected_dates.' '.$slot) < strtotime($offtime['offtime_end'])) {
							   $ifofftime = 'Y';
							   $check = $check+1;
							}
						 }
						if($ifofftime=='Y') {  continue; }
						
						$complete_time_slot = mktime(date('H',strtotime($slot)),date('i',strtotime($slot)),date('s',strtotime($slot)),date('n',strtotime($time_schedule['date'])),date('j',strtotime($time_schedule['date'])),date('Y',strtotime($time_schedule['date']))); 
							
					 if($setting->get_option('ld_hide_faded_already_booked_time_slots')=='on' && in_array($complete_time_slot,$time_schedule['booked'])) {
						 $check = $check+1;
						 continue;
					 }
						if( in_array($complete_time_slot,$time_schedule['booked']) && ($setting->get_option('ld_allow_multiple_booking_for_same_timeslot_status')!='Y') ) { 
							if($setting->get_option('ld_hide_faded_already_booked_time_slots')=="off"){
								$check = $check+1;
							}
						} else { 
							if($setting->get_option('ld_time_format')==24){
								$slot_time = date("H:i",strtotime($slot));
								$slotdbb_time = date("H:i",strtotime($slot));
								$ld_time_selected = date("H:i",strtotime($slot));
							}else{
								$slot_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($slot)));
								$slotdbb_time = date("H:i",strtotime($slot));
								$ld_time_selected = str_replace($english_date_array,$selected_lang_label,date("h:iA",strtotime($slot)));
							}
						} $slot_counter++; 
					}
					$finals = sizeof($time_schedule['slots'])-$check;
					$available_time_slots = $finals;
				}
				else 
				{
					$available_time_slots =  "0";
				}
			}
		} else{  $available_time_slots =  "0";} 
		
		/* COUNT TOTAL AVAILABLE SLOTS */
		if($ld_calendar_firstDay == '1'){
			if( ($day + $offset - $get_first_day_starting) % 7 == 0 && $day >= 0){
			  $k = $k+7;
			  ?>
			  </div>
			  <div class="ld-show-time time_slot_box display_selected_date_slots_box<?php  echo filter_var($k); ?>"></div>
			  <div class="dates">
			  <?php 
			  $rows++;
			}
		}else{
			if( ($day + $offset - $get_first_day_starting) % 7 == 0 && $day != $get_first_day_starting){
			  $k = $k+7;
			  ?>
			  </div>
			  <div class="ld-show-time time_slot_box display_selected_date_slots_box<?php  echo filter_var($k); ?>"></div>
			  <div class="dates">
			  <?php 
			  $rows++;
			}
		}
		
		if(date('j',$datetime_withmaxtime) <= $day && date('M',$datetime_withmaxtime) == date('M',$date) && date('Y',$datetime_withmaxtime) == date('Y',$date)){
		?>
			<div class="ld-week hide_previous_dates"><?php echo filter_var($day); ?></div>
		<?php 
		}else{ 
		$available_text = "";
		if($s_date < $c_date){}
		elseif($available_time_slots <= 0){ $available_text = $label_language_values['none_available'];}
		else{ $available_text =  $available_time_slots." ".$label_language_values['available'];}
		?>
			<div title="<?php if($s_date < $c_date){}else{ echo filter_var($available_text);} ?>" class="<?php if($s_date < $c_date){}else{ echo filter_var("ld-tooltipss-ajax");}?> ld-week <?php  if($c_date == $s_date){ echo filter_var('by_default_today_selected'); } ?> <?php  if($s_date < $c_date){ echo filter_var('hide_previous_dates'); }else{ echo filter_var('selected_datess'.$selected_dates); echo filter_var(' remove_selection selected_date');} ?>"  data-id="<?php if($day < 35){echo filter_var($k+7, FILTER_SANITIZE_NUMBER_INT); }else{echo filter_var($k);} ?>" data-selected_dates="<?php echo filter_var($selected_dates); ?>" data-cur_dates="<?php echo filter_var($cur_dates); ?>" data-c_date="<?php echo filter_var($c_date); ?>" data-s_date="<?php echo filter_var($s_date); ?>"><a href="javascript:void(0)"><span><?php echo filter_var($day); ?></span></a></div>
		<?php 
		}
		?>
		<?php 		
	  }
	  
	  if($ld_calendar_firstDay == '1'){
		  while( (($day-1) + $offset) <= $rows * 7)
		  {
			?>
			<div class="ld-week hide_previous_dates"></div>
			<?php 
			$day++;
		  }
	  }else{
		  while( ($day + $offset) <= $rows * 7)
		  {
			?>
			<div class="ld-week hide_previous_dates"></div>
			<?php 
			$day++;
		  }
	  }
	  ?>
	  </div>
	  <div class="ld-show-time time_slot_box display_selected_date_slots_box<?php  echo  $k+7;?>"></div>
	  <div class="today-date"><a class="ld-button nm today_btttn ld-lg-offset-1" data-istoday="Y" data-cur_dates="<?php echo filter_var($cur_dates); ?>" data-next_month="<?php echo date("m",$currDateTime_withTZ); ?>" data-next_month_year="<?php echo date("Y",$currDateTime_withTZ); ?>"><?php echo filter_var($label_language_values['today']); ?></a>
	  <div class="ld-selected-date-view ld-lg-pull-1"><span class="add_date" data-date=""></span><span class="add_time"></span></div>
	  </div>
	  </div>
	  </div>
	  <?php
}
if(isset($_POST['get_calendar_on_page_load'])){
	?>
<script>
jQuery(document).ready(function() {
	jQuery('.ld-tooltipss-load').tooltipster({
		animation: 'grow',
		delay: 20,
		theme: 'tooltipster-shadow',
		trigger: 'hover'
	});
});
</script><?php 
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
		
	  list($year, $month, $iNowDay) = explode('-', date('Y-m-d',$currDateTime_withTZ));
	  $ld_max_advance_booking_time = $setting->get_option('ld_max_advance_booking_time');
	  $datetime_withmaxtime = strtotime('+'.$ld_max_advance_booking_time.' month',strtotime(date('Y-m-d',$currDateTime_withTZ)));
	  
	  $date = mktime(12, 0, 0, $month, 1, $year);
	  $yearss = date("Y",$date);
	  $monthss =  date("m",$date);
	  $monthssss =  date("M",$date);
	  
	  $daysInMonth = date("t", $date);
	  /* calculate the position of the first day in the calendar (sunday = 1st column, etc) */
	  if($ld_calendar_firstDay == '1'){
		$offset = date("N", $date);
	  }else{
		$offset = date("w", $date);
	  }
	  
	  $rows = 1; 
	  
	  $next_months=strtotime('+1 month', $date);
	  $prev_months=strtotime('-1 month', $date);
	  ?>
	  <div class="calender_months_full_detail <?php    echo filter_var($monthss."_".$yearss); ?>">
	  <div class="calendar-header">
					<?php 
					if($monthssss != date('M')){
					?>
					<a data-istoday="N" class="previous-date previous_next" href="javascript:void(0)" data-next_month="<?php echo date("m", $prev_months); ?>" data-next_month_year="<?php echo date("Y", $prev_months); ?>"><i class="icon-arrow-left icons"></i></a>
					<?php 
					}else{
					?>
					<a class="previous-date" href="javascript:void(0)" ><i class="icon-arrow-left icons"></i></a>
					<?php 
					}
					?>
					<div class="calendar-title"><?php echo filter_var($label_language_values[strtolower(date("F", $date))]); ?></div>
					<div class="calendar-year"><?php echo date("Y", $date); ?></div>
					<a data-istoday="N" class="next-date previous_next" href="javascript:void(0)" data-next_month="<?php echo date("m", $next_months); ?>" data-next_month_year="<?php echo filter_var(date("Y", $next_months)); ?>"><i class="icon-arrow-right icons"></i></a>
				</div>
	 <div class="calendar-body">
				<div class="weekdays fl">
					<?php  if($ld_calendar_firstDay == '0'){ ?>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['sun']); ?></span>
					</div>
					<?php  } ?>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['mon']); ?></span>
					</div>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['tue']); ?></span>
					</div>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['wed']); ?></span>
					</div>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['thu']); ?></span>
					</div>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['fri']); ?></span>
					</div>
					<?php  if($ld_calendar_firstDay == '0'){ ?>
					<div class="ld-day ld-last-day">
						<span><?php echo filter_var($label_language_values['sat']); ?></span>
					</div>
					<?php  } ?>
					<?php  if($ld_calendar_firstDay == '1'){ ?>
					<div class="ld-day">
						<span><?php echo filter_var($label_language_values['sat']); ?></span>
					</div>
					<div class="ld-day ld-last-day">
						<span><?php echo filter_var($label_language_values['sun']); ?></span>
					</div>
					<?php  } ?>
				</div>
	  
	  <div class="dates">
	  <?php 
	  if($ld_calendar_firstDay == '1'){
			$get_first_day_starting = 2;
	  }else{
			$get_first_day_starting = 1;
	  }
	  for($i = $get_first_day_starting; $i <= $offset; $i++)
	  {
	  ?>
		<div class="ld-week hide_previous_dates"></div>
	  <?php 
	  }
	  $k = 0;
	  for($day = 1; $day <= $daysInMonth; $day++)
	  {
		$selected_dates = $day."-".$monthss."-".$yearss;
		$selected_dates_available = $day."-".$monthss."-".$yearss;
		$cur_dates = date('j-m-Y',$currDateTime_withTZ);
		$s_date = strtotime($selected_dates);
		$c_date = strtotime($cur_dates);
		
		/* COUNT TOTAL AVAILABLE SLOTS */
		
		$t_zone_value = $setting->get_option('ld_timezone');
		$server_timezone = date_default_timezone_get();
		if(isset($t_zone_value) && $t_zone_value!=''){
			$offset_available= $first_step->get_timezone_offset($server_timezone,$t_zone_value);
			$timezonediff = $offset_available/3600;  
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
		
		$select_time=date('Y-m-d',strtotime($selected_dates_available));
		$start_date = date($select_time,$currDateTime_withTZ);
		
		$time_interval = $setting->get_option('ld_time_interval');	
		$time_slots_schedule_type = $setting->get_option('ld_time_slots_schedule_type');
		$advance_bookingtime = $setting->get_option('ld_min_advance_booking_time');
		$ld_service_padding_time_before = $setting->get_option('ld_service_padding_time_before');
		$ld_service_padding_time_after = $setting->get_option('ld_service_padding_time_after');
				
		$time_schedule = $first_step->get_day_time_slot_by_provider_id($time_slots_schedule_type,$start_date,$time_interval,$advance_bookingtime,$ld_service_padding_time_before,$ld_service_padding_time_after,$timezonediff,$booking_padding_time,$staff_id); 
		
		$allbreak_counter = 0;	
		$allofftime_counter = 0;
		$allbooked_counter = 0;
		$slot_counter = 0;
		$check = 0;
		$week_day_avail_count = $week_day_avail->get_data_for_front_cal();
		if(isset($time_schedule['slots'])){ 
		    if(mysqli_num_rows($week_day_avail_count) > 0)
			{
				if($time_schedule['off_day']!=true && isset($time_schedule['slots']) && sizeof($time_schedule['slots'])>0 && $allbreak_counter != sizeof($time_schedule['slots']) && $allofftime_counter != sizeof($time_schedule['slots']))
				{
					foreach($time_schedule['slots']  as $slot) 
					{
						$ifbreak = 'N';
						foreach($time_schedule['breaks'] as $daybreak) {
							if(strtotime($slot) >= strtotime($daybreak['break_start']) && strtotime($slot) < strtotime($daybreak['break_end'])) {
							   $ifbreak = 'Y';
							   $check = $check+1;
							}
						}
						if($ifbreak=='Y') {  continue; } 
						
						$ifofftime = 'N';
													
						foreach($time_schedule['offtimes'] as $offtime) {
							if(strtotime($selected_dates.' '.$slot) >= strtotime($offtime['offtime_start']) && strtotime($selected_dates.' '.$slot) < strtotime($offtime['offtime_end'])) {
							   $ifofftime = 'Y';
							   $check = $check+1;
							}
						 }
						if($ifofftime=='Y') {  continue; }
						
						$complete_time_slot = mktime(date('H',strtotime($slot)),date('i',strtotime($slot)),date('s',strtotime($slot)),date('n',strtotime($time_schedule['date'])),date('j',strtotime($time_schedule['date'])),date('Y',strtotime($time_schedule['date']))); 
							
					 if($setting->get_option('ld_hide_faded_already_booked_time_slots')=='on' && in_array($complete_time_slot,$time_schedule['booked'])) {
						 $check = $check+1;
						 continue;
					 }
						if( in_array($complete_time_slot,$time_schedule['booked']) && ($setting->get_option('ld_allow_multiple_booking_for_same_timeslot_status')!='Y') ) { 
							if($setting->get_option('ld_hide_faded_already_booked_time_slots')=="off"){
								$check = $check+1;
							}
						} else { 
							if($setting->get_option('ld_time_format')==24){
								$slot_time = date("H:i",strtotime($slot));
								$slotdbb_time = date("H:i",strtotime($slot));
								$ld_time_selected = date("H:i",strtotime($slot));
							}else{
								$slot_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($slot)));
								$slotdbb_time = date("H:i",strtotime($slot));
								$ld_time_selected = str_replace($english_date_array,$selected_lang_label,date("h:iA",strtotime($slot)));
							}
						} $slot_counter++; 
					}
					$finals = sizeof($time_schedule['slots'])-$check;
					$available_time_slots = $finals;
				}
				else 
				{
					$available_time_slots =  "0";
				}
			}
		} else{  $available_time_slots =  "0";} 
		
		/* COUNT TOTAL AVAILABLE SLOTS */
		
		if($ld_calendar_firstDay == '1'){
			if( ($day + $offset - $get_first_day_starting) % 7 == 0 && $day >= 0){
			  $k = $k+7;
			  ?>
			  </div>
			  <div class="ld-show-time time_slot_box display_selected_date_slots_box<?php  echo filter_var($k); ?>"></div>
			  <div class="dates">
			  <?php 
			  $rows++;
			}
		}else{
			if( ($day + $offset - $get_first_day_starting) % 7 == 0 && $day != $get_first_day_starting){
			  $k = $k+7;
			  ?>
			  </div>
			  <div class="ld-show-time time_slot_box display_selected_date_slots_box<?php  echo filter_var($k); ?>"></div>
			  <div class="dates">
			  <?php 
			  $rows++;
			}
		}
		
		$available_text = "";
		if($s_date < $c_date){}
		elseif($available_time_slots <= 0){ $available_text =  $label_language_values['none_available'];}
		else{ $available_text =  $available_time_slots." ".$label_language_values['available'];}
		?>
		<div  title="<?php if($s_date < $c_date){}else{ echo filter_var($available_text);} ?>" class=" <?php  if($s_date < $c_date){}else{ echo filter_var("ld-tooltipss-load");}?> ld-week <?php  if($c_date == $s_date){ echo filter_var('by_default_today_selected'); } ?> <?php  if($s_date < $c_date){ echo filter_var('hide_previous_dates'); }else{ echo filter_var('selected_datess'.$selected_dates);  echo filter_var(' remove_selection selected_date');} ?>"  data-id="<?php if($day < 35){echo filter_var($k+7, FILTER_SANITIZE_NUMBER_INT); }else{echo filter_var($k);} ?>" data-selected_dates="<?php echo filter_var($selected_dates); ?>" data-cur_dates="<?php echo filter_var($cur_dates); ?>" data-c_date="<?php echo filter_var($c_date); ?>" data-s_date="<?php echo filter_var($s_date); ?>"><a href="javascript:void(0)"><span><?php echo filter_var($day); ?></span></a></div>
		<?php 
	  }
	  if($ld_calendar_firstDay == '1'){
		  while( (($day-1) + $offset) <= $rows * 7)
		  {
			?>
			<div class="ld-week hide_previous_dates"></div>
			<?php 
			$day++;
		  }
	  }else{
		  while( ($day + $offset) <= $rows * 7)
		  {
			?>
			<div class="ld-week hide_previous_dates"></div>
			<?php 
			$day++;
		  }
	  }
	  ?>
	 </div> 
	  <div class="ld-show-time time_slot_box display_selected_date_slots_box<?php  echo  $k+7;?>"></div>
	  <div class="today-date"><a class="ld-button nm today_btttn ld-lg-offset-1" data-istoday="Y" data-cur_dates="<?php echo filter_var($cur_dates); ?>" data-next_month="<?php echo date("m",$currDateTime_withTZ); ?>" data-next_month_year="<?php echo date("Y",$currDateTime_withTZ); ?>"><?php echo filter_var($label_language_values['today']); ?></a>
	  <div class="ld-selected-date-view ld-lg-pull-1"><span class="add_date" data-date=""></span><span class="add_time"></span></div>
	  <input type="hidden" id="save_selected_date" value="" />
	  </div>
	  </div>
	  </div>
	  <?php 
}
if(isset($_POST['get_slots'])){
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
		
		$select_time=date('Y-m-d',strtotime(filter_var($_POST['selected_dates'])));
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
		<div class="time-slot-container">
			<div class="ld-slot-legends">
				<ul class="ld-legends-ul">
					<li><span class="ld-slot-legends-box ld-available-new"></span><?php echo filter_var($label_language_values['available']); ?></li>
					<li><span class="ld-slot-legends-box ld-selected-new"></span><?php echo filter_var($label_language_values['selected']); ?></li>
					<li><span class="ld-slot-legends-box ld-not-available-new"></span><?php echo filter_var($label_language_values['not_available']); ?></li><br>
				</ul>
			</div>
			<ul class="list-inline time-slot-ul br-5">
			<?php  
			if(mysqli_num_rows($week_day_avail_count) > 0)
			{
				if($time_schedule['off_day']!=true && isset($time_schedule['slots']) && sizeof($time_schedule['slots'])>0 && $allbreak_counter != sizeof($time_schedule['slots']) && $allofftime_counter != sizeof($time_schedule['slots']))
				{ 
					foreach($time_schedule['slots']  as $slot) 
					{ 
						/* Checking in GC booked Slots START */
						$curreslotstr = strtotime(date(date('Y-m-d H:i:s',strtotime($select_time.' '.$slot)),$currDateTime_withTZ));
						
						$gccheck = 'N';
						
						if(sizeof($providerCalenderBooking)>0){
							for($i = 0; $i < sizeof($providerCalenderBooking); $i++) {
								if($curreslotstr >= $providerCalenderBooking[$i]['start'] && $curreslotstr < $providerCalenderBooking[$i]['end']){
									$gccheck = 'Y';
								}
							}
						}
						/* Checking in GC booked Slots END */
						
						$ifbreak = 'N';
						/* Need to check if the appointment slot come under break time. */
						foreach($time_schedule['breaks'] as $daybreak) {
							if(strtotime($slot) >= strtotime($daybreak['break_start']) && strtotime($slot) < strtotime($daybreak['break_end'])) {
							   $ifbreak = 'Y';   
							}
						}
						/* if yes its break time then we will not show the time for booking  */
						if($ifbreak=='Y') { $allbreak_counter++; continue; } 
						
						$ifofftime = 'N';
														
						foreach($time_schedule['offtimes'] as $offtime) {
							if(strtotime(filter_var($_POST['selected_dates'].' '.$slot) >= strtotime($offtime['offtime_start']) && strtotime($_POST['selected_dates'].' '.$slot) < strtotime($offtime['offtime_end']))) {
							   $ifofftime = 'Y';
							}
						 }
						/* if yes its offtime time then we will not show the time for booking  */
						if($ifofftime=='Y') { $allofftime_counter++; continue; }
						
						$complete_time_slot = mktime(date('H',strtotime($slot)),date('i',strtotime($slot)),date('s',strtotime($slot)),date('n',strtotime($time_schedule['date'])),date('j',strtotime($time_schedule['date'])),date('Y',strtotime($time_schedule['date']))); 
									
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
										echo date("H:i",strtotime($slot));
									}else{
										echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($slot)));
									}?>
								</li>
							<?php 
							}
							?>
						<?php 
						} else { 
							if($setting->get_option('ld_time_format')==24){
								$slot_time = date("H:i",strtotime($slot));
								$slotdbb_time = date("H:i",strtotime($slot));
								$ld_time_selected = date("H:i",strtotime($slot));
							}else{
								$slot_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($slot)));
								$slotdbb_time = date("H:i",strtotime($slot));
								$ld_time_selected = str_replace($english_date_array,$selected_lang_label,date("h:iA",strtotime($slot)));
							}
							?>
							
							<li class="time-slot br-2 time_slotss" data-slot_date_to_display="<?php echo str_replace($english_date_array,$selected_lang_label,date($date_format,strtotime(filter_var($_POST["selected_dates"]))); ?>" data-ld_date_selected="<?php echo  str_replace($english_date_array,$selected_lang_label,date('D, j F, Y',strtotime($_POST["selected_dates"]))); ?>"  data-slot_date="<?php echo filter_var($_POST["selected_dates"]); ?>" data-slot_time="<?php echo filter_var($slot_time); ?>" data-slotdb_time="<?php echo filter_var($slotdbb_time); ?>" data-slotdb_date="<?php echo date('Y-m-d',strtotime($_POST["selected_dates"]))); ?>" data-ld_time_selected="<?php echo filter_var($ld_time_selected); ?>">
								<?php 
									if($setting->get_option('ld_time_format')==24){echo date("H:i",strtotime($slot));}else{echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($slot)));}
								?>
							</li>
						<?php  
						} $slot_counter++; 
					} 
					if($allbreak_counter != 0 && $allofftime_counter != 0){ ?>
					<li class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo filter_var($label_language_values['none_of_time_slot_available_please_check_another_dates']); ?></li>
				   <?php  }
				   
				   if($allbreak_counter == sizeof($time_schedule['slots']) && sizeof($time_schedule['slots'])!=0){ ?>
					<li class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo filter_var($label_language_values['none_of_time_slot_available_please_check_another_dates']); ?></li>
				   <?php  }
				   if($allofftime_counter > sizeof($time_schedule['offtimes']) && sizeof($time_schedule['slots'])==$allofftime_counter){?>
					<li class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo filter_var($label_language_values['none_of_time_slot_available_please_check_another_dates']); ?></li>
				   <?php  }      
				   } else {?>
					<li class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo filter_var($label_language_values['none_of_time_slot_available_please_check_another_dates']); ?></li>
				   <?php  } 
				   } else {?>
					<li class="time-slot ld-slot-booked" style="width: 99%;" ><?php echo filter_var($label_language_values['availability_is_not_configured_from_admin_side']); ?></li>
				   <?php  } ?>
			
			</ul>
		</div>
	
	<?php 
}
?>