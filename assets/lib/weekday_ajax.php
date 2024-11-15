<?php  
include(dirname(dirname(dirname(__FILE__)))."/objects/class_connection.php");
include(dirname(dirname(dirname(__FILE__)))."/header.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_dayweek_avail.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_offtimes.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_offbreaks.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_off_days.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_setting.php");
$con = new laundry_db();
$conn = $con->connect();

$objdayweek_avail = new laundry_dayweek_avail();
$objdayweek_avail->conn = $conn;

$obj_offtime = new laundry_offtimes();
$obj_offtime->conn = $conn;

$objoffbreaks = new laundry_offbreaks();
$objoffbreaks->conn = $conn;

$time_int = $objdayweek_avail->getinterval();
$time_interval = $time_int[2];

$setting = new laundry_setting();
$setting->conn = $conn;
$getdateformat=$setting->get_option('ld_date_picker_date_format');
$time_format = $setting->get_option('ld_time_format');

$offday=new laundry_provider_off_day();
$offday->conn = $conn;

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
/*new file include*/
include(dirname(dirname(dirname(__FILE__))).'/assets/lib/date_translate_array.php');
/* check to display the time slot */
if(isset($_POST['change_schedule_type']))
{
    $values = $_POST['values'];
    $staff_id = $_POST['staff_id'];
    $objdayweek_avail->set_schedule_type($values,$staff_id);
    echo "yes";
}
elseif(isset($_POST['operation_insertmonthlyslots']))
{
	 $staff_id = filter_var($_POST['staff_id']);
	 $values = $_POST['values'];
    $objdayweek_avail->delete_schedule_weekly($staff_id);
    $objdayweek_avail->delete_schedule_breaks($staff_id);
    $chkday = $_POST['chkday'];
    $starttime = $_POST['starttime'];
    $endtime = $_POST['endtime'];
    
    $we = 1;
    $startsize = sizeof((array)$starttime);
    /* Weekly schedule */
    if($startsize==7){
        for($i=1;$i<=7;$i++)
        {
			
			if($chkday[$i-1]=='Y'){
				$objdayweek_avail->day_start_time=$starttime[$i-1];
				$objdayweek_avail->day_end_time=$endtime[$i-1];
			
			}else{
				$objdayweek_avail->day_start_time=$starttime[$i-1];
				$objdayweek_avail->day_end_time=$endtime[$i-1];
			
			}
			
            $objdayweek_avail->week_id=1;
			$objdayweek_avail->staff_id=$staff_id;
			$objdayweek_avail->provider_schedule_type=$values;
            $objdayweek_avail->weekday_id=$i;
            $objdayweek_avail->off_days=$chkday[$i-1];
            $objdayweek_avail->insert_schedule_weekly();
        }
    }else{
   /* Monthly schedule*/
        /* Month Loop */
        $k=0;
		/* week loop*/
		
		
        for($i=1;$i<=35;$i++)
        {   /* week day loop */
          
				if($chkday[$i-1]=='Y'){
					$objdayweek_avail->day_start_time=$starttime[$i-1];
					$objdayweek_avail->day_end_time=$endtime[$i-1];			
				}else{
					$objdayweek_avail->day_start_time=$starttime[$i-1];
					$objdayweek_avail->day_end_time=$endtime[$i-1];				
				}
			   if($i== 1 || $i<=7){
					$objdayweek_avail->week_id=1;
					$objdayweek_avail->weekday_id=$i;
				
			   }elseif($i==8 || $i<=14){
					$objdayweek_avail->week_id=2;
					$objdayweek_avail->weekday_id=$i-7;					
			   }elseif($i==15 || $i<=21){
					$objdayweek_avail->week_id=3;
					$objdayweek_avail->weekday_id=$i-14;
			   }elseif($i==22 || $i<=28){
					$objdayweek_avail->week_id=4;
					$objdayweek_avail->weekday_id=$i-21;
			   }else{
					$objdayweek_avail->week_id=5;
					$objdayweek_avail->weekday_id=$i-28;
			   }
               
                $objdayweek_avail->provider_id=0;
                
                $objdayweek_avail->staff_id=$staff_id;
                $objdayweek_avail->provider_schedule_type=$values;
                $objdayweek_avail->off_days=$chkday[$k];
                $objdayweek_avail->insert_schedule_weekly();
                $k++;
        
        }
    }
}
elseif(isset($_POST['add_offtime']))
{
    $startdate = filter_var($_POST['startdate']);
    $enddate = filter_var($_POST['enddate']);
    $staff_id = filter_var($_POST['staff_id']);
    $obj_offtime->startdate = $startdate;
    $obj_offtime->enddate = $enddate;
    $obj_offtime->staff_id = $staff_id;
    $obj_offtime->add_offtimes();
}
elseif(isset($_POST['getmy_offtimes']))
{
	$staff_id = filter_var($_POST['staff_id']);
    $res = $obj_offtime->get_all_offtimes($staff_id);
    $i=1;
	if($time_format == 12){
		$time_show = "h:i A";
	}
	else{
		$time_show = "H:i";
	}
    while($r = mysqli_fetch_array($res))
    {
        $st = $r['start_date_time'];
        $stt = explode(" ", $st);
        $sdates = $stt[0];
        $stime = $stt[1];
        $et = $r['end_date_time'];
        $ett = explode(" ", $et);
        $edates = $ett[0];
        $etime = $ett[1];
        ?>
        <tr id="myofftime_<?php  echo filter_var($r['id']);?>">
            <td><?php echo filter_var($i++, FILTER_SANITIZE_NUMBER_INT);?></td>
            <td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($sdates))); ?></td>
            <td><?php echo str_replace($english_date_array,$selected_lang_label,date($time_show,strtotime($stime)));?></td>
            <td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($edates))); ?></td>
            <td><?php echo str_replace($english_date_array,$selected_lang_label,date($time_show,strtotime($etime)));?></td>
            <td><a data-id="<?php echo filter_var($r['id']);?>" class='btn btn-danger ld_delete_provider left-margin'><span
                        class='glyphicon glyphicon-remove'></span></a></td>
        </tr>
        <?php 
    }
}
elseif(isset($_POST['delete_offtime']))
{
    $obj_offtime->id = filter_var($_POST['id']);
    $obj_offtime->delete_offtimes();
	if($obj_offtime){
        echo filter_var($label_language_values['off_time_deleted']);
    }else{
         echo filter_var($label_language_values['error_in_delete_of_off_time']);
	}
}
elseif(isset($_POST['newaddbreak']))
{
    $weekid = filter_var($_POST['weekid']);
    $weekday = filter_var($_POST['weekday']);
    $staff_id = filter_var($_POST['staff_id']);
    $off_starttime = filter_var($_POST['starttime']);
    $off_endtime = filter_var($_POST['endtime']);
    $objoffbreaks->week_id = $weekid;
    $objoffbreaks->weekday_id = $weekday;
    $objoffbreaks->staff_id = $staff_id;
    $objoffbreaks->break_start = $off_starttime;
    $objoffbreaks->break_end = $off_endtime;
    $lastid =  $objoffbreaks->insert_offbreaks();
    $lastrecord = $objoffbreaks->getlastidrecord($lastid);
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.selectpicker').selectpicker();
        });
    </script>
    <li>
        <select class="selectpicker selectpickerstart" id="start_break_<?php  echo filter_var($lastrecord[0]); ?>_<?php  echo filter_var($lastrecord[2]);?>_<?php  echo filter_var($lastrecord[3]);?>" data-id="<?php echo filter_var($lastrecord[0]);?>" data-weekid="<?php echo filter_var($lastrecord[2]);?>" data-weekday="<?php echo filter_var($lastrecord[3]);?>" data-size="10" style="" >
            <?php 
            $min = 0;
            while ($min < 1440) {
                if ($min == 1440) {
                    $timeValue = date('G:i', mktime(0, $min - 1, 0, 1, 1, 2015));
                } else {
                    $timeValue = date('G:i', mktime(0, $min, 0, 1, 1, 2015));
                }
                $timetoprint = date('G:i', mktime(0, $min, 0, 1, 1, 2014)); ?>
                <option <?php  if ($lastrecord[4] == date("H:i:s", strtotime($timeValue))) {
                    echo filter_var("selected");
					} elseif("10:00:00" == date("H:i:s", strtotime($timeValue))){ echo filter_var("selected");}?>
                    value="<?php echo date("H:i:s", strtotime($timeValue)); ?>">
                    <?php 
                    if ($time_format == 24) {
                        echo date("H:i", strtotime($timetoprint));
                    } else {
                        echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($timetoprint)));
                    }
                    ?>
                </option>
                <?php 
                $min = $min + $time_interval;
            }
            ?>
        </select>
        <span class="ld-staff-hours-to"> <?php  echo filter_var($label_language_values['to']);?> </span>
        <select class="selectpicker selectpickerend" data-id="<?php echo filter_var($lastrecord[0]);?>" data-weekid="<?php echo filter_var($lastrecord[2]);?>" data-weekday="<?php echo filter_var($lastrecord[3]);?>"" data-size="10">
            <?php 
            $min = 0;
            while ($min < 1440) {
                if ($min == 1440) {
                    $timeValue = date('G:i', mktime(0, $min - 1, 0, 1, 1, 2015));
                } else {
                    $timeValue = date('G:i', mktime(0, $min, 0, 1, 1, 2015));
                }
                $timetoprint = date('G:i', mktime(0, $min, 0, 1, 1, 2014)); ?>
                <option <?php  if ($lastrecord[5] == date("H:i:s", strtotime($timeValue))) {
                    echo filter_var("selected");
                } elseif("20:00:00" == date("H:i:s", strtotime($timeValue))){ echo filter_var("selected");}?>
                    value="<?php echo date("H:i:s", strtotime($timeValue)); ?>">
                    <?php 
                    if ($time_format == 24) {
                        echo date("H:i", strtotime($timetoprint));
                    } else {
                        echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($timetoprint)));
                    }
                    ?>
                </option>
                <?php 
                $min = $min + $time_interval;
            }
            ?>
        </select>
        <button id="ld-delete-staff-break<?php  echo filter_var($lastrecord[0]);?>_<?php  echo filter_var($weekid);?>_<?php  echo filter_var($weekday);?>" data-wiwdibi='<?php echo filter_var($lastrecord[0]);?>_<?php  echo filter_var($weekid);?>_<?php  echo filter_var($weekday);?>' data-break_id="<?php echo filter_var($lastrecord[0]);?>" class="pull-right btn btn-circle btn-default delete_break" rel="popover" data-placement='left' title="<?php echo filter_var($label_language_values['are_you_sure']);?>?"> <i class="fa fa-trash"></i></button>
        <div id="popover-delete-breaks<?php  echo filter_var($lastrecord[0]);?>_<?php  echo filter_var($weekid);?>_<?php  echo filter_var($weekday);?>" style="display: none;">
            <div class="arrow"></div>
            <table class="form-horizontal" cellspacing="0">
                <tbody>
                <tr>
                    <td>
                        <button id="" value="Delete" data-break_id='<?php echo filter_var($lastrecord[0]);?>' class="btn btn-danger mybtndelete_breaks" type="submit"><?php echo filter_var($label_language_values['yes']);?></button>
                        <button id="ld-close-popover-delete-breaks" class="btn btn-default close_popup" href="javascript:void(0)"><?php echo filter_var($label_language_values['cancel']);?></button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </li>
<?php 
}
elseif(isset($_POST['editstarttime_break'])){
    $objdayweek_avail->week_id = filter_var($_POST['weekid']);
    $objdayweek_avail->weekday_id = filter_var($_POST['weekday']);
    $avltime=$objdayweek_avail->get_avail_time();
    if(strtotime(filter_var($_POST['start_new_time'])<strtotime($avltime[4]))){
        echo filter_var("Please Select Time Between Day Availability time");
    }else{
        $objoffbreaks->id = filter_var($_POST['id']);
        $objoffbreaks->week_id = filter_var($_POST['weekid']);
        $objoffbreaks->weekday_id = filter_var($_POST['weekday']);
        $objoffbreaks->break_start = filter_var($_POST['start_new_time']);
        $objoffbreaks->update_starttime();
        echo filter_var("done");
    }
}
elseif(isset($_POST['editendtime_break']))
{
    $objdayweek_avail->week_id = filter_var($_POST['weekid']);
    $objdayweek_avail->weekday_id = filter_var($_POST['weekday']);
    $avlendtime=$objdayweek_avail->get_avail_time();
     if(strtotime(filter_var($_POST['end_new_time'])>strtotime($avlendtime[5]) || strtotime($_POST['end_new_time'])< strtotime($avlendtime[4]) || strtotime($_POST['end_new_time'])== strtotime($avlendtime[4]))){
        echo filter_var("Please Select Time Between Day Availability time");
    }else{
        $objoffbreaks->id = filter_var($_POST['id']);
        $objoffbreaks->week_id = filter_var($_POST['weekid']);
        $objoffbreaks->weekday_id = filter_var($_POST['weekday']);
        $objoffbreaks->break_end = filter_var($_POST['end_new_time']);
        $objoffbreaks->update_endtime();
        echo filter_var("End Break Time Updated");
    }
}
elseif(isset($_POST['delete_off_breaks'])){
    $objoffbreaks->id = filter_var($_POST['id']);
    $objoffbreaks->delete_off_breaks();
}
else if(isset($_POST['operation_insertmonthlyslots_staff']))
{
    
    /* $objdayweek_avail->delete_schedule_breaks_staff(); */
    $chkday = filter_var($_POST['chkday']);
    $starttime = filter_var($_POST['starttime']);
    $endtime = filter_var($_POST['endtime']);
	$staff_id = filter_var($_POST['staff_id']);
    $we = 1;
	$objdayweek_avail->delete_schedule_weekly_staff($staff_id);
    $startsize=sizeof($starttime);
    /* Weekly schedule */
    if($startsize==7){
        for($i=1;$i<=7;$i++)
        {
			
			if($chkday[$i-1]=='Y'){
				$objdayweek_avail->day_start_time=$starttime[$i-1];
				$objdayweek_avail->day_end_time=$endtime[$i-1];
			
			}else{
				$objdayweek_avail->day_start_time=$starttime[$i-1];
				$objdayweek_avail->day_end_time=$endtime[$i-1];
			
			}
			
            $objdayweek_avail->week_id=1;
            $objdayweek_avail->provider_id=$staff_id;
            $objdayweek_avail->weekday_id=$i;
            $objdayweek_avail->off_days=$chkday[$i-1];
            $objdayweek_avail->insert_schedule_weekly();
        }
    }else{
   /* Monthly schedule*/
        /* Month Loop */
        $k=0;
		/* week loop*/
		
		
        for($i=1;$i<=35;$i++)
        {   /* week day loop */
          
				if($chkday[$i-1]=='Y'){
					$objdayweek_avail->day_start_time=$starttime[$i-1];
					$objdayweek_avail->day_end_time=$endtime[$i-1];			
				}else{
					$objdayweek_avail->day_start_time=$starttime[$i-1];
					$objdayweek_avail->day_end_time=$endtime[$i-1];				
				}
			   if($i== 1 || $i<=7){
					$objdayweek_avail->week_id=1;
					$objdayweek_avail->weekday_id=$i;
				
			   }elseif($i==8 || $i<=14){
					$objdayweek_avail->week_id=2;
					$objdayweek_avail->weekday_id=$i-7;					
			   }elseif($i==15 || $i<=21){
					$objdayweek_avail->week_id=3;
					$objdayweek_avail->weekday_id=$i-14;
			   }elseif($i==22 || $i<=28){
					$objdayweek_avail->week_id=4;
					$objdayweek_avail->weekday_id=$i-21;
			   }else{
					$objdayweek_avail->week_id=5;
					$objdayweek_avail->weekday_id=$i-28;
			   }
               
                $objdayweek_avail->provider_id=$staff_id;
                
                $objdayweek_avail->off_days=$chkday[$k];
                $objdayweek_avail->insert_schedule_weekly();
                $k++;
        
        }
    }
}

/* Off Days */
/*The below code is used to Add and Delete off day*/
if(isset($_POST['status']) && filter_var($_POST['status'])=='off_day'){
    $offday->user_id=filter_var($_POST['prov_id']);
    $offday->off_date=filter_var($_POST['date_id']);
    $cdate=$offday->countdate();
    if($cdate['total']==0){
        $offday->user_id=filter_var($_POST['prov_id']);
        $offday->off_date=filter_var($_POST['date_id']);
        $add_day=$offday->add_off_day();
		if($add_day){
			$result_check = $label_language_values['off_days_added_successfully'];
		}
    }else{
        $offday->user_id=filter_var($_POST['prov_id']);
        $offday->off_date=filter_var($_POST['date_id']);
        $del_day=$offday->delete_off_day();
		if($del_day){
			$result_check = $label_language_values['off_days_deleted_successfully'];
		}
    }
	echo filter_var($result_check);
}
/* below code use for add and delete full month off-day-*/
if(isset($_POST['status']) && filter_var($_POST['status'])=='month_off_day'){
    $offday->user_id=filter_var($_POST['provider_id']);
    $offday->off_date=filter_var($_POST['date_id']);
    $cdate=$offday->countdate();
    if($cdate['total']==0){
        $offday->user_id=filter_var($_POST['provider_id']);
        $offday->off_year_month=filter_var($_POST['date_id']);
        $add_day=$offday->create_monthoff();
    }else{
        $offday->user_id=filter_var($_POST['provider_id']);
        $offday->off_year_month=filter_var($_POST['date_id']);
        $add_day1=$offday->delete_monthoff();
    }
}else{
    if(isset($_POST['status']) && filter_var($_POST['status'])=='delete_month_off_day'){
        $offday->user_id=filter_var($_POST['provider_id']);
        $offday->off_year_month=filter_var($_POST['date_id']);
        $add_day=$offday->delete_monthoff();
    }
}
?>