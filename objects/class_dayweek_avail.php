<?php
class laundry_dayweek_avail
{

    public $id;
    public $week_id;
    public $provider_id;
    public $weekday_id;
    public $day_start_time;
    public $day_end_time;
    public $staff_id;
    public $provider_schedule_type;
    public $staff_id_delete;
    public $off_days = 'N';
    public $table_name = "ld_week_days_available";
    public $table_name2 = "ld_schedule_breaks";
    public $conn;

    /* used  */
    /* function to set the schedult type monthly/weekly  */
    public function set_schedule_type($types, $staff_id)
    {
        if ($staff_id == 1) {
            $query = "update `ld_settings` set `option_value`='" . $types . "' where `option_name`='ld_time_slots_schedule_type'";
            mysqli_query($this->conn, $query);
        }
        $query = "delete from `" . $this->table_name . "` where `provider_id` = '" . $staff_id . "'";
        mysqli_query($this->conn, $query);
        $query = "delete from `" . $this->table_name2 . "` where `provider_id` = '" . $staff_id . "'";
        mysqli_query($this->conn, $query);

        $chkday = "N";
        $starttime = "08:00:00";
        $endtime = "17:00:00";

        if ($types == "weekly") {
            for ($i = 1; $i <= 7; $i++) {

                $this->day_start_time = $starttime;
                $this->day_end_time = $endtime;

                $this->week_id = 1;
                $this->staff_id = $staff_id;
                $this->provider_schedule_type = $types;
                $this->provider_id = 0;
                $this->weekday_id = $i;
                $this->off_days = $chkday;
                $this->insert_schedule_weekly();
            }
        } else {
            /* Monthly schedule*/
            /* Month Loop */
            $k = 0;
            /* week loop*/


            for ($i = 1; $i <= 35; $i++) {   /* week day loop */


                $this->day_start_time = $starttime;
                $this->day_end_time = $endtime;

                if ($i == 1 || $i <= 7) {
                    $this->week_id = 1;
                    $this->weekday_id = $i;
                } elseif ($i == 8 || $i <= 14) {
                    $this->week_id = 2;
                    $this->weekday_id = $i - 7;
                } elseif ($i == 15 || $i <= 21) {
                    $this->week_id = 3;
                    $this->weekday_id = $i - 14;
                } elseif ($i == 22 || $i <= 28) {
                    $this->week_id = 4;
                    $this->weekday_id = $i - 21;
                } else {
                    $this->week_id = 5;
                    $this->weekday_id = $i - 28;
                }

                $this->provider_id = 0;
                $this->staff_id = $staff_id;
                $this->provider_schedule_type = $types;
                $this->off_days = $chkday;
                $this->insert_schedule_weekly();
                $k++;
            }
        }
    }

    /* function to set the schedult type monthly/weekly  for staff */
    public function set_schedule_type_staff($staff_id)
    {
        $query = "delete from `" . $this->table_name . "` where `provider_id` = '" . $staff_id . "'";
        mysqli_query($this->conn, $query);
        $query = "delete from `" . $this->table_name2 . "` where `provider_id` = '" . $staff_id . "'";
        mysqli_query($this->conn, $query);
        die;
    }

    /* function to get the value from the setting table of schedule type for display in availability */
    public function get_schedule_type()
    {
        $query = "select * from `ld_settings` where `option_name`='ld_time_slots_schedule_type'";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }

    public function get_schedule_type_according_provider($staff_id)
    {
        $query = "select * from " . $this->table_name . " where provider_id='" . $staff_id . "' limit 0,1";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }
    /*  to get the current week of the month */
    function getWeeks($date, $rollover)
    {
        $cut = substr($date, 0, 8);
        $daylen = 86400;
        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;
        $weeks = 1;
        for ($i = 1; $i <= $elapsed; $i++) {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);
            $day = strtolower(date("l", $daytimestamp));
            if ($day == strtolower($rollover))  $weeks++;
        }
        return $weeks;
    }
    /* Get all data of the current week */
    public function get_dataof_week()
    {
        $query = "select * from `" . $this->table_name . "` where `provider_id` = '0'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* Get all data of staff the current week */
    public function get_dataof_week_staff($staff_id)
    {
        $query = "select * from `" . $this->table_name . "` where `provider_id` = '" . $staff_id . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }

    /* set all new time slots for the weekly schedule */
    public function delete_schedule_weekly_staff($staff_id)
    {
        $query = "delete from `" . $this->table_name . "` where `provider_id` = '" . $staff_id . "'";
        mysqli_query($this->conn, $query);
    }
    /* set all new time slots for the weekly schedule */
    public function delete_schedule_weekly($provider_id)
    {
        $query = "delete from `" . $this->table_name . "` where `provider_id` = '" . $provider_id . "'";
        mysqli_query($this->conn, $query);
    }
    /* set all new time slots for the weekly schedule */
    public function delete_schedule_breaks($provider_id)
    {
        $query = "delete from `" . $this->table_name2 . "` where `provider_id` = '" . $provider_id . "'";
        mysqli_query($this->conn, $query);
    }
    /* after delete insert all entry newly */
    public function insert_schedule_weekly()
    {
        $query = "insert into `" . $this->table_name . "` (`id`,`provider_id`,`week_id`,`weekday_id`,`day_start_time`,`day_end_time`,`off_day`,`provider_schedule_type`) values(NULL,'" . $this->staff_id . "','" . $this->week_id . "','" . $this->weekday_id . "','" . $this->day_start_time . "','" . $this->day_end_time . "','" . $this->off_days . "','" . $this->provider_schedule_type . "')";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_insert_id($this->conn);
        return $value;
    }
    /* Get day name by id */
    public function get_daynamebyid($id)
    {
        $name = "";
        switch ($id) {
            case 1:
                $name =  "Monday";
                break;
            case 2:
                $name =  "Tuesday";
                break;
            case 3:
                $name =  "Wednesday";
                break;
            case 4:
                $name =  "Thursday";
                break;
            case 5:
                $name =  "Friday";
                break;
            case 6:
                $name =  "Saturday";
                break;
            case 7:
                $name =  "Sunday";
                break;
        }
        return  $name;
    }

    /* get data by week and day id */
    public function get_time_slots($staff_id)
    {
        $query = "select * from `" . $this->table_name . "` where `provider_id` = '" . $staff_id . "' and `week_id`='" . $this->week_id . "' and `weekday_id`='" . $this->weekday_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }
    /* get data by week and day id for staff*/
    public function get_time_slots_staff($staff_id)
    {
        $query = "select * from `" . $this->table_name . "` where `provider_id` = '" . $staff_id . "' and `week_id`='" . $this->week_id . "' and `weekday_id`='" . $this->weekday_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }

    /* Get the time interval from the settings table */
    public function getinterval()
    {
        $query = "select * from `ld_settings` where `option_name`='ld_time_interval'";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }
    /* get the dat from the weekid */
    public function getdata_byweekid($staff_id)
    {
        $query = "select `off_day` from `" . $this->table_name . "` where `week_id` = '" . $this->week_id . "' and `weekday_id` = '" . $this->weekday_id . "' and provider_id = '" . $staff_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }
    /* function to get value of start and end time by weekid and dayid*/
    public function get_avail_time()
    {
        $query = "select * from `" . $this->table_name . "` where `week_id`='" . $this->week_id . "' and `weekday_id`='" . $this->weekday_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }

    /* function to get value of start and end time by weekid and dayid*/
    public function get_avail_time_staff($staff_id, $schedule_type, $date_time)
    {
        if ($schedule_type == "M") {
            $query = "select * from `" . $this->table_name . "` where `week_id`='" . $this->week_id . "' and `weekday_id`='" . $this->weekday_id . "' and `provider_id`='" . $staff_id . "'  and `off_day` = 'N' and `day_start_time` <= '" . date('H:i:s', strtotime($date_time)) . "' and `day_end_time` >= '" . date('H:i:s', strtotime($date_time)) . "'";
            $result = mysqli_query($this->conn, $query);
            $value = mysqli_fetch_row($result);
            return $value;
        } else {
            $query = "select * from `" . $this->table_name . "` where `week_id`='1' and `weekday_id`='" . $this->weekday_id . "' and `provider_id`='" . $staff_id . "' and `off_day` = 'N' and `day_start_time` <= '" . date('H:i:s', strtotime($date_time)) . "' and `day_end_time` >= '" . date('H:i:s', strtotime($date_time)) . "'";
            $result = mysqli_query($this->conn, $query);
            $value = mysqli_fetch_row($result);
            return $value;
        }
    }
    /* function to get value of start and end time by weekid and dayid*/
    public function get_off_day($staff_id, $date)
    {
        $query = "select * from `ld_off_days` where `off_date`='" . $date . "' and  `user_id`='" . $staff_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }


    /* Get all data  */
    public function get_data_for_front_cal()
    {
        $query = "select * from `" . $this->table_name . "`";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* newly added */
    public function get_timeavailability_check()
    {
        $query = "select * from `" . $this->table_name . "`";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
}
