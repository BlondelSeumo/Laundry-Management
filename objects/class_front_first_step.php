<?php  

class laundry_first_step
{
	public $day_id;
	public $week_id;
	public $time_interval;
	public $provider_id;
	public $datetime;
	public $staff_id;
	public $table_name="ld_week_days_available";
	public $table_name1="ld_off_days";
	public $table_name2="ld_schedule_breaks";
	public $table_name3="ld_bookings";
	public $table_name4="ld_schedule_offtimes";
	public $conn;
	
	/**     
	* Get Week of the month from date	 
	* @param date that need be checked	 
	* @return week number     
	*/
    function get_week_of_month_by_date($date)
    {	
		
        $dmy    = explode('-', $date);
        $weekid = ceil(($dmy[2] + date("w", mktime(0, 0, 0, $dmy[1], 1, $dmy[0]))) / 7);
        if ($weekid == 6) {
            $idweek = $weekid - 1;
        } else {
            $idweek = $weekid;
        }	
        return $idweek;
		
    }
    
	/**     
	* print time slots	 
	* @param Day ID	 
	* @param Week ID	 
	* @param Time Interval default 10	 
	* @param Time provider ID	 
	* @return array time slots result     
	*/
    function time_slots($day_id, $week_id, $time_int,$staff_id) 
    {
		$dayid=$day_id;
		$weekid=$week_id;
		$time_interval=$time_int;
        $results = array();
		$query="SELECT `day_start_time`,`day_end_time` FROM `".$this->table_name."` WHERE `weekday_id`=" .$dayid . " AND `off_day`='N' AND `week_id`=" .$weekid. " AND provider_id=" .$staff_id;			
			$result=mysqli_query($this->conn,$query);
			$value=mysqli_fetch_row($result);		
				if(isset($value) && $value != ""){
					$results['daystart_time'] = $value[0];
					$results['dayend_time']   = $value[1];
				}else{
					$results['daystart_time'] = "";
					$results['dayend_time']   = "";
				}
				
        return $results;	
    }
	
	function check_off_day($date,$staff_id)
    {
		$dates=$date;
		$query="select * from `".$this->table_name1."` where `off_date`='".$dates."' and user_id='".$staff_id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_num_rows($result);	
        if ($value> 0) {
            return true;
        } else {
            return false;
        }
    }
    
	
	function get_day_breaks($week_id, $day_id, $provider_schedule_type,$staff_id)
	{
		$provider_schedule_type;
		$weekid=$week_id;
		$dayid=$day_id;
		$providerschedule_type=$provider_schedule_type;
		$return_arr = array();
        if ($providerschedule_type == 'W'){
			$query="SELECT `break_start`,`break_end` FROM `".$this->table_name2."` WHERE `week_id`='1' AND `weekday_id`='" . $dayid . "' AND provider_id='" . $staff_id . "'";
			$result=mysqli_query($this->conn,$query);	
			
        }else{
			
			$query="SELECT `break_start`,`break_end` FROM `".$this->table_name2."` WHERE `week_id`='".$weekid."' AND `weekday_id`='" . $dayid . "' AND provider_id='" . $staff_id . "'";
			$result=mysqli_query($this->conn,$query);	
        }
			$counter = 0;
		
			while($breaks=mysqli_fetch_array($result)){
				 $return_arr[$counter]['break_start'] = $breaks['break_start'];
				$return_arr[$counter]['break_end']   = $breaks['break_end'];
				$counter++;
			}
        return $return_arr;
		
    }
    
	
	function get_already_booked_slots($selected_date,$cur_time_interval,$service_padding_before,$service_padding_after,$booking_padding_time,$staff_id){
		$use_date=$selected_date;
		$return_arr = array();
		$query="select `booking_pickup_date_time_start` from `ld_bookings` where CAST(`booking_pickup_date_time_start` as date)='".$use_date."' and (staff_ids='".$staff_id."' or staff_ids='') and (`booking_status`='A' OR `booking_status`='C') group by `id`, `order_id`, `client_id`, `order_date`, `booking_pickup_date_time_start`, `service_id`, `booking_status`, `reject_reason`, `reminder_status`, `lastmodify`, `read_status`, `staff_ids`, `gc_event_id`, `gc_staff_event_id`";
		$value=mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_array($value)){
			$service_duration = $cur_time_interval;
			$loop_tmp_storage = strtotime($row['booking_pickup_date_time_start']);
			if ($service_padding_before != '') {
				$loop_tmp_storage = strtotime("-$service_padding_before minutes", $loop_tmp_storage);	  
				$service_duration =  $service_duration+$service_padding_before;
      } 
			if ($service_padding_after != '') {
				$service_duration =  $service_duration+$service_padding_after;
      } 
			if ($booking_padding_time != '') {
				$service_duration =  $service_duration+$booking_padding_time;
      }
			$return_arr[] = $loop_tmp_storage;	
			if ($service_duration > $cur_time_interval) {
				$times_greater = ceil($service_duration / $cur_time_interval - 1);
				for ($tg = 1; $tg <= $times_greater; $tg++) {	
					 $return_arr[]     = strtotime("+$cur_time_interval minutes", $loop_tmp_storage);
					 $loop_tmp_storage = strtotime("+$cur_time_interval minutes", $loop_tmp_storage);
				}
			}
    }
		return $return_arr;
	}
	
	/* Get Provider offtimes **/
	function get_provider_offtime($staff_id)
	{
       $return_arr = array();
        
 $query="SELECT `start_date_time`,`end_date_time` FROM `".$this->table_name4."` where provider_id = '".$staff_id."'" ;
		$result=mysqli_query($this->conn,$query);	
		$counter = 0;
		while($offtimes=mysqli_fetch_array($result)){
			 $return_arr[$counter]['offtime_start'] = $offtimes['start_date_time'];
			$return_arr[$counter]['offtime_end']   = $offtimes['end_date_time'];
			$counter++;
		}
        return $return_arr;
    }
		
    /* A new function for new design */
    function get_day_time_slot_by_provider_id($provider_schedule_type, $start_date, $time_int,$advance_bookingtime=0,$service_padding_before=0,$service_padding_after=0,$timezonediff=0,$booking_padding_time=0,$staff_id=0)    
    {
		if(is_numeric(strpos($timezonediff,'-'))){
			$timediffmis = str_replace('-','',$timezonediff)*60;
			$currDateTime_withTZ= strtotime("-".$timediffmis." minutes",strtotime(date('Y-m-d H:i:s')));
		}else{
			$timediffmis = str_replace('+','',$timezonediff)*60;
			$currDateTime_withTZ = strtotime("+".$timediffmis." minutes",strtotime(date('Y-m-d H:i:s')));	
		}
		
		$providerschedule_type=$provider_schedule_type;
		
		$cal_starting_date=$start_date;
		$time_interval=$time_int;		
		
        $day_time_slots = array();
        
		/* showing time schedule for ONE DAY ONLY days */
        /* Get Week number of month for starting date (between 1 to 5) */
        if ($providerschedule_type == 'weekly') {
            $week_id = 1;
        } else {
            $week_id = $this->get_week_of_month_by_date(date('Y-m-d', strtotime($cal_starting_date)));
        }
    
		/* if calendar starting date is missing then it will take starting date to current date */
        if ($cal_starting_date == '') {
            $day_id                 = date('N', $currDateTime_withTZ);
            
			/*  add Date as heading of the day column */
            $day_time_slots['date'] = date('Y-m-d', $currDateTime_withTZ);
        } else {
            $day_id                 = date('N', strtotime($cal_starting_date));
           
			/* add Date as heading of the day column */
            $day_time_slots['date'] =date('Y-m-d', strtotime($cal_starting_date));
		
        }
        
		/* check if the day is off day */
        $day_time_slots['off_day'] = $this->check_off_day($day_time_slots['date'],$staff_id);
		
		/* function return day start time and day end time of given provider */
        $time_intervals            = $this->time_slots($day_id, $week_id, $time_interval,$staff_id);
		
		/* calculating starting and end time of day into mintues */				
		if(isset($time_intervals['daystart_time'],$time_intervals['dayend_time'])){		
		$min_day_start_time        = (date('G', strtotime($time_intervals['daystart_time'])) * 60) + date('i',strtotime($time_intervals['daystart_time']));
        $min_day_end_time          = (date('G', strtotime($time_intervals['dayend_time'])) * 60) + date('i',strtotime($time_intervals['dayend_time']));
		
		$min_advnce_allow='Y';
		$advancemins='N';
		if($advance_bookingtime>=1440){
			$advancemins='Y';
			$currdatestr = strtotime(date('Y-m-d '.date('H:i:s',$currDateTime_withTZ)));					
			$withadncebooktime = strtotime("+$advance_bookingtime minutes", $currdatestr);
			$withadncebookdate = date('Y-m-d',strtotime("+$advance_bookingtime minutes", $currdatestr));
			$daystarttimeofdate = strtotime(date($withadncebookdate.' '.$time_intervals['daystart_time']));
			$withadncetime = date('H:i:s',$withadncebooktime);
							
			if(strtotime($cal_starting_date)>strtotime($withadncebookdate)){
				$withadncetime = $time_intervals['daystart_time'];
			}
			
			if(strtotime($cal_starting_date)>=strtotime($withadncebookdate)){
				if($withadncebooktime<$daystarttimeofdate){
					$min_day_start_time = (date('G', strtotime($time_intervals['daystart_time'])) * 60) + date('i',strtotime($time_intervals['daystart_time']));								
						$min_advnce_allow='Y';					
				}else{
				
					$min_day_start_time = (date('G', strtotime($withadncetime)) * 60) + date('i',strtotime($withadncetime));						
					if($min_day_start_time%$time_interval!=0){
						$extraminsadd =  $time_interval-($min_day_start_time%$time_interval);
						$min_day_start_time = $min_day_start_time+$extraminsadd;
					}
				
					$min_advnce_allow='Y';
				}
			}else{
				$min_advnce_allow='N';
			}
		}
		
		
		
		
		$starting_min              = $min_day_start_time;
		
		
		/* Adding Service Before Padding Time For First Slot */
		if ($service_padding_before != '') {
			  $starting_min =  $starting_min+$service_padding_before;
        } 
		
		
        /* check if selected date is today  if yes calculate current time's min to avoid past booking */
        $today                     = false;
        $conditional_min_mins      = 0;
		
        if (strtotime($day_time_slots['date']) == strtotime(date('Y-m-d',$currDateTime_withTZ)) && $advancemins=='N') {
            $today                = true;
            /* total mins of current time */
           $conditional_min_mins = date('G',strtotime(date('Y-m-d H:i:s',$currDateTime_withTZ))) * 60 + date('i',strtotime(date('Y-m-d H:i:s',$currDateTime_withTZ))) ;
        } else {
            $today = false;
        }
		
		
       
	   /* add minimum advance booking mins with starting mins for slots */
		 if($advance_bookingtime<1440){
				$conditional_min_mins += $advance_bookingtime;
		}
		
		
        /* check breaks of the day */
        $day_time_slots['breaks'] = $this->get_day_breaks($week_id, $day_id, $providerschedule_type,$staff_id);
				
        /* check already booked timeslots */
        $day_time_slots['booked'] = $this->get_already_booked_slots($cal_starting_date,$time_interval,$service_padding_before,$service_padding_after,$booking_padding_time,$staff_id);
		
		/* Check provider Offtimes */
		$day_time_slots['offtimes'] = $this->get_provider_offtime($staff_id);
		
        /* Converting time into slots based on given daystart time and dayend time */
        if ($time_intervals['daystart_time'] != '' && $time_intervals['dayend_time'] != '' && $min_advnce_allow=='Y') {
            while ($starting_min < $min_day_end_time) {
                if ($today) {
					if ($starting_min > $conditional_min_mins) {						
                        $day_time_slots['slots'][] = date('G:i:s', mktime(0, $starting_min, 0, 1, 1, date('Y',$currDateTime_withTZ)));
                    }
                } else {					
                    $day_time_slots['slots'][] = date('G:i:s', mktime(0, $starting_min, 0, 1, 1, date('Y',$currDateTime_withTZ)));
                }
                $starting_min = $starting_min + $time_interval;
            }
        } else {
            $day_time_slots['slots'] = array();
        }		}
		
        return $day_time_slots;		
		
    }
    /* end of function */
	
	
	
	
	function get_timezone_offset($remote_tz, $origin_tz = null) {
		if($origin_tz === null) {
			if(!is_string($origin_tz = date_default_timezone_get())) {
				return false; /* A UTC timestamp was returned -- bail out! */
			}
		}
		$origin_dtz = new DateTimeZone($origin_tz);
		$remote_dtz = new DateTimeZone($remote_tz);
		$origin_dt = new DateTime("now", $origin_dtz);
		$remote_dt = new DateTime("now", $remote_dtz);
		
		$offset = $origin_dtz->getOffset($remote_dt) - $remote_dtz->getOffset($origin_dt);
		return $offset;
	}
	
	
}
?>