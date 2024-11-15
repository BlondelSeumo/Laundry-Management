<?php
class laundry_booking
{
    public $method_id;
    public $method_unit_id;
    public $method_unit_qty;
    public $method_unit_qty_rate;
    public $addons_service_id;
    public $addons_service_qty;
    public $addons_service_rate;
    public $booking_id;
    public $location_id;
    public $order_id;
    public $client_id;
    public $provider_id;
    public $service_id;
    public $booking_price;
    public $booking_pickup_date_time_start;
    public $booking_pickup_date_time_end;
    public $booking_delivery_date_time_start;
    public $booking_delivery_date_time_end;
    public $booking_status;
    public $reject_reason;
    public $cancel_reason;
    public $reminder_status;
    public $lastmodify;
    public $read_status;
    public $user_id;
    public $startdate;
    public $enddate;
    public $order_date;
    public $start_date;
    public $staff_id;
    public $end_date;
    public $id;
    public $conn;
    public $offset;
    public $limit;
    public $self_service;
    public $show_delivery_date;
    public $unit_id;
    public $unit_qty;
    public $unit_rate;
    public $unit_name;
    public $business_id;
    public $booking_endtime;
    public $booking_datetime;
    public $reminder;
    public $status;
    public $staff_order_id;
    public $booking_start_datetime;
    public $table_name = "ld_bookings";
    public $tablename1 = "ld_services";
    public $tablename2 = "ld_order_client_info";
    public $tablename3 = "ld_users";
    public $tablename4 = "ld_payments";
    public $tablename5 = "ld_booking_units";
    public $table_staff_status = "ld_staff_status";
    /*    * Function for add Booking    *    */
    public function add_booking()
    {
         $query  = "insert into `" . $this->table_name . "` (`id`,`order_id`,`client_id`,`order_date`,`booking_pickup_date_time_start`,`booking_pickup_date_time_end`,`booking_delivery_date_time_start`,`booking_delivery_date_time_end`,`service_id`,`booking_status`,`reject_reason`,`reminder_status`,`lastmodify`,`read_status`,`gc_event_id`,`gc_staff_event_id`,`self_service`,`show_delivery_date`,`staff_ids`) values(NULL,'" . $this->order_id . "','" . $this->client_id . "','" . $this->order_date . "','" . $this->booking_pickup_date_time_start . "','" . $this->booking_pickup_date_time_end . "','" . $this->booking_delivery_date_time_start . "','" . $this->booking_delivery_date_time_end . "','" . $this->service_id . "','" . $this->booking_status . "','" . $this->reject_reason . "','0','" . $this->lastmodify . "','" . $this->read_status . "','','','" . $this->self_service . "','" . $this->show_delivery_date . "','".$this->staff_id."')";
       
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_insert_id($this->conn);
        return $value;
		
    }
    public function add_booking_units()
    {
        $query  = "insert into `" . $this->tablename5 . "` (`id`,`order_id`,`service_id`,`unit_id`,`unit_name`,`unit_qty`,`unit_rate`) values(NULL,'" . $this->order_id . "','" . $this->service_id . "','" . $this->unit_id . "','" . $this->unit_name . "','" . $this->unit_qty . "','" . $this->unit_rate . "')";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_insert_id($this->conn);
        return $value;
    }
    /*    * Function for Update Booking    *    */
    public function update()
    {
        $query  = "update `" . $this->table_name . "` set `order_id`='" . $this->order_id . "',`business_id`='" . $this->business_id . "',`client_id`='" . $this->client_id . "',`service_id`='" . $this->service_id . "',`provider_id`='" . $this->provider_id . "',`booking_price`='" . $this->booking_price . "',`booking_datetime`='" . $this->booking_datetime . "',`booking_endtime`='" . $this->booking_endtime . "',`booking_status`='" . $this->booking_status . "',`reject_reason`='" . $this->reject_reason . "',`cancel_reason`='" . $this->cancel_reason . "',`reminder`='" . $this->reminder . "',`lastmodify`='" . $this->lastmodify . "' where `id`='" . $this->booking_id . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /*    * Function for Read All Booking    *    */
    public function readall()
    {
        $query  = "select * from `" . $this->table_name . "`";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function getallbookings()
    {
        $query  = "SELECT `p`.`order_id`, `b`.`service_id`, `b`.`booking_status`, `b`.`client_id`, `b`.`booking_pickup_date_time_start`, `p`.`net_amount` FROM `ld_bookings` as `b`,`ld_payments` as `p` WHERE `b`.`order_id` = `p`.`order_id` GROUP BY `p`.`order_id`, `b`.`booking_status`, `b`.`client_id`, `b`.`booking_pickup_date_time_start`, `p`.`net_amount` ORDER BY `b`.`order_id` DESC";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /*    * Function for Read One Booking    *    */
    public function readone()
    {
        $query  = "select * from `" . $this->table_name . "` where `id`='" . $this->booking_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_row($result);
        return $value;
    }
    public function get_staff_readone($staff_id)
    {
        $query  = "select `staff_ids` from `" . $this->table_name . "` where `id`='" . $staff_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_row($result);
        return $value;
    }
    /*Function to Get Last order id from booking table used in front end for add cart item in booking table*/
    public function last_booking_id()
    {
        $query  = "select max(`order_id`) from `" . $this->table_name . "`";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_row($result);
        return $value[0];
    }
    public function confirm_booking()
    {
        $query  = "update `" . $this->table_name . "` set `booking_status`='" . $this->booking_status . "' where `id`='" . $this->booking_id . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function update_reject_status()
    {
        $query  = "update `" . $this->table_name . "` set `booking_status`='R',`read_status`='U',`lastmodify`='" . $this->lastmodify . "',`reject_reason`='" . $this->reject_reason . "' where `order_id`='" . $this->order_id . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* Used in booking_ajax */
    public function count_order_id_bookings()
    {
        $query  = "select count(`order_id`) as `ordercount` from `" . $this->table_name . "` where `id`='" . $this->order_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value;
    }
    /* used in booking_ajax */
    public function delete_booking()
    {
        $query  = "delete from `" . $this->table_name . "` where `id`='" . $this->booking_id . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* used for delete appointments in booking_ajax */
    public function delete_appointments()
    {
        $query  = "delete `ld_bookings`.*,`ld_payments`.*,`ld_order_client_info`.* from `ld_bookings` INNER JOIN `ld_payments`,`ld_order_client_info` where `ld_bookings`.`order_id`=`ld_payments`.`order_id` and `ld_bookings`.`order_id`=`ld_order_client_info`.`order_id` and `ld_bookings`.`order_id`='" . $this->order_id . "' ";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* thi smethod is used in export page to list all bookings */
    public function get_all_bookings()
    {
        $query  = "select `order_id`, `client_id`, `service_id`, `booking_status`, `order_date`, `booking_pickup_date_time_start` from `ld_bookings` GROUP BY `order_id`, `client_id`, `service_id`, `booking_status`, `order_date`, `booking_pickup_date_time_start` ORDER BY `order_id` ";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* get all bookings details from the order_id */
    public function get_detailsby_order_id($orderid)
    {
        $query  = "select`b`.`booking_status`,`b`.`reject_reason`,`b`.`staff_ids`,`b`.`gc_event_id`,`b`.`gc_staff_event_id`,`b`.`booking_pickup_date_time_start`,`s`.`title` as `service_title`,`p`.`net_amount`,`sm`.`method_title`,`oci`.`client_name`,`oci`.`client_email`,`oci`.`client_personal_info`,`p`.`payment_method`,`oci`.`client_phone`from`ld_bookings` as `b`,`ld_services` as `s`,`ld_payments` as `p`,`ld_services_method` as `sm`,`ld_order_client_info` as `oci`where`b`.`service_id` = `s`.`id`and`b`.`order_id` = `p`.`order_id`and`b`.`method_id` = `sm`.`id`and`b`.`order_id` = '" . $orderid . "'and`b`.`order_id` = `oci`.`order_id`GROUP BY `b`.`id`, `b`.`order_id`, `b`.`client_id`, `b`.`order_date`, `b`.`booking_pickup_date_time_start`, `b`.`service_id`, `b`.`method_id`, `b`.`method_unit_id`, `b`.`method_unit_qty`, `b`.`method_unit_qty_rate`, `b`.`booking_status`, `b`.`reject_reason`, `b`.`reminder_status`, `b`.`lastmodify`, `b`.`read_status`, `b`.`staff_ids`, `b`.`gc_event_id`, `b`.`gc_staff_event_id`,`s`.`id`, `s`.`title`, `s`.`description`, `s`.`color`, `s`.`image`, `s`.`status`, `s`.`position`,`p`.`id`, `p`.`order_id`, `p`.`payment_method`, `p`.`transaction_id`, `p`.`amount`, `p`.`discount`, `p`.`taxes`, `p`.`partial_amount`, `p`.`payment_date`, `p`.`net_amount`, `p`.`lastmodify`, `p`.`frequently_discount`, `p`.`frequently_discount_amount`, `sm`.`id`, `sm`.`service_id`, `sm`.`method_title`, `sm`.`status`, `sm`.`position`, `oci`.`id`, `oci`.`order_id`, `oci`.`client_name`, `oci`.`client_email`, `oci`.`client_phone`, `oci`.`client_personal_info`";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value;
    }
    /* CODE FOR DISPLAY DETAIL IN POPUP */
		
		public function get_booking_details_appt($orderid)
    {
         $query  = "select `b`.`booking_status`,`b`.`service_id`,`b`.`booking_pickup_date_time_start`,`p`.`net_amount`,`oci`.`client_name`,`oci`.`client_email`,`oci`.`client_personal_info`,`p`.`payment_method`,`oci`.`client_phone`,`s`.`title` as `service_title`,`b`.`gc_event_id` ,`b`.`gc_staff_event_id` ,`b`.`staff_ids` ,`b`.`reject_reason` ,`b`.`booking_pickup_date_time_end`,`b`.`show_delivery_date`,`b`.`booking_delivery_date_time_start`,`b`.`booking_delivery_date_time_end`,`b`.`self_service`,`b`.`client_id` from`ld_bookings` as `b`,`ld_payments` as `p`,`ld_order_client_info` as `oci`,`ld_services` as `s` where `b`.`order_id` = `p`.`order_id`and `b`.`order_id` = '" . $orderid . "'and `b`.`order_id` = `oci`.`order_id`and `b`.`service_id` = `s`.`id` GROUP BY `b`.`service_id`,`b`.`booking_status`,`b`.`booking_pickup_date_time_start`,`p`.`net_amount`,`oci`.`client_name`,`oci`.`client_email`,`oci`.`client_personal_info`,`p`.`payment_method`,`oci`.`client_phone`,`s`.`title`,`b`.`gc_event_id` ,`b`.`gc_staff_event_id` ,`b`.`staff_ids` ,`b`.`reject_reason` ,`b`.`booking_pickup_date_time_end`,`b`.`show_delivery_date`,`b`.`booking_delivery_date_time_start`,`b`.`booking_delivery_date_time_end`,`b`.`self_service`";
       
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_assoc($result);
        return $value;
    }
    /* CODE FOR DISPLAY DETAIL IN POPUP API Function */
    public function get_booking_details_appt_api($orderid)
    {
        $query  = "select`b`.`booking_status`,`b`.`booking_pickup_date_time_start`,`p`.`net_amount`,`oci`.`client_name`,`oci`.`client_email`,`oci`.`client_personal_info`,`p`.`payment_method`,`oci`.`client_phone`,`s`.`title` as `service_title`,`b`.`gc_event_id` ,`b`.`gc_staff_event_id` ,`b`.`staff_ids` from`ld_bookings` as `b`,`ld_payments` as `p`,`ld_order_client_info` as `oci`,`ld_services` as `s` where `b`.`order_id` = `p`.`order_id`and `b`.`order_id` = '" . $orderid . "'and `b`.`order_id` = `oci`.`order_id`and `b`.`service_id` = `s`.`id`GROUP BY `b`.`booking_status`,`b`.`booking_pickup_date_time_start`,`p`.`net_amount`,`oci`.`client_name`,`oci`.`client_email`,`oci`.`client_personal_info`,`p`.`payment_method`,`oci`.`client_phone`,`s`.`title`";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value;
    }
    /* CODE FOR DISPLAY DETIAL IN POPUP  END */
    public function getdatabyorder_id($orderid)
    {
        $query  = "select * from `ld_bookings` where `order_id` = '" . $orderid . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* get all addons services of bookings */
    public function get_units_ofbookings($orderid)
    {
        $query  = "select `ba`.* from `ld_bookings` as `b`,`ld_booking_units` as `ba` where `b`.`order_id` = `ba`.`order_id` and `b`.`order_id` = '" . $orderid . "' GROUP BY `ba`.`id`, `ba`.`order_id`, `ba`.`service_id`, `ba`.`unit_id`, `ba`.`unit_qty`, `ba`.`unit_rate`";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /*Use function for Invoice Purpose*/
    public function get_details_for_invoice_client()
    {
        $query  = "select `b`.`order_id` as `invoice_number`,`b`.`booking_pickup_date_time_start` as `start_time`,`b`.`order_date` as `invoice_date`,`b`.`service_id` as `sid`,`b`.`client_id` as `cid` from `ld_bookings` as `b`,`ld_payments` as `p`,`ld_order_client_info` as `oc` where `b`.`order_id`='" . $this->order_id . "' and `b`.`order_id`=`p`.`order_id` and `b`.`order_id`=`oc`.`order_id` ";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_row($result);
        return $value;
    }
    /* Get Client Info from user table */
    public function get_client_info()
    {
        $query  = "select * from `" . $this->tablename3 . "` where `id`='" . $this->client_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_row($result);
        return $value;
    }
    /* Booking readall */
    public function readall_bookings()
    {
        $query  = "select * from `" . $this->table_name . "` where `order_id`='" . $this->order_id . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function email_reminder()
    {
        $query  = "select * from `" . $this->table_name . "` where (`reminder_status`='0' OR `reminder_status`='') and `booking_status`='C' GROUP BY `id`, `order_id`, `client_id`, `order_date`, `booking_pickup_date_time_start`, `service_id`, `method_id`, `method_unit_id`, `method_unit_qty`, `method_unit_qty_rate`, `booking_status`, `reject_reason`, `reminder_status`, `lastmodify`, `read_status`, `staff_ids`";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function update_reminder_booking($id)
    {
        $query  = "update `" . $this->table_name . "` set `reminder_status`='1' where `id`='" . $id . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function getalldetail_for_reminder($orderid)
    {
        $query  = "select`s`.`title`,`b`.`booking_pickup_date_time_start`,`oci`.`client_name`,`oci`.`client_email`,`b`.`duration`from`ld_bookings` as `b`,`ld_services` as `s`,`ld_order_client_info` as `oci`where`b`.`order_id` = '" . $orderid . "' and`b`.`service_id` = `s`.`id` and`b`.`order_id` = `oci`.`order_id` GROUP BY `b`.`id`, `b`.`order_id`, `b`.`client_id`, `b`.`order_date`, `b`.`booking_pickup_date_time_start`, `b`.`service_id`, `b`.`booking_status`, `b`.`reject_reason`, `b`.`reminder_status`, `b`.`lastmodify`, `b`.`read_status`, `b`.`staff_ids`, `b`.`gc_event_id`, `b`.`gc_staff_event_id`,`s`.`id`, `s`.`title`, `s`.`description`, `s`.`color`, `s`.`image`, `s`.`status`, `s`.`position`, `oci`.`id`, `oci`.`order_id`, `oci`.`client_name`, `oci`.`client_email`, `oci`.`client_phone`, `oci`.`client_personal_info`";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_row($result);
        return $value;
    }
    public function check_for_service_units_availabilities($sid)
    {
        $query  = "select count(`id`) as `count_of_method` from `ld_service_units` where `services_id` = '$sid'";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value['count_of_method'];
    }
    public function save_staff_to_booking($sid)
    {
         $query  = "update `" . $this->table_name . "` set `staff_ids`='" . $sid . "' where `order_id`='" . $this->order_id . "'";
        
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function fetch_staff_of_booking()
    {
        $query  = "SELECT `staff_ids` FROM `ld_bookings` where `order_id` = '" . $this->order_id . "' GROUP BY `id`, `order_id`, `client_id`, `order_date`, `booking_pickup_date_time_start`, `service_id`, `booking_status`, `reject_reason`, `reminder_status`, `lastmodify`, `read_status`, `staff_ids`, `gc_event_id`, `gc_staff_event_id`";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value[0];
    }
    function getWeeks($date, $rollover)
    {
        $cut       = substr($date, 0, 8);
        $daylen    = 86400;
        $timestamp = strtotime($date);
        $first     = strtotime($cut . "00");
        $elapsed   = ($timestamp - $first) / $daylen;
        $weeks     = 1;
        for ($i = 1; $i <= $elapsed; $i++) {
            $dayfind      = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);
            $day          = strtolower(date("l", $daytimestamp));
            if ($day == strtolower($rollover))
                $weeks++;
        }
        return $weeks;
    }
    function get_staff_detail_for_email($sid)
    {
        $query  = "select * from `ld_admin_info` where `id` = '" . $sid . "'";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value;
    }
    function get_staff_ids_from_bookings($oid)
    {
        $query  = "select * from `ld_bookings` where `order_id` = '" . $oid . "'";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value['staff_ids'];
    }
    function booked_staff_status()
    {
        $query  = "select GROUP_CONCAT(`staff_ids`) as `sc` from `" . $this->table_name . "` where `booking_pickup_date_time_start` = '" . $this->booking_pickup_date_time_start . "' and `staff_ids` != ''";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value= isset($value[0])? $value[0] : '' ;
    }
    /* Update GC Event ID */
    function update_gc_event_id($last_id, $gc_event_id)
    {
        $update_gc_event_query = "update " . $this->table_name . " set gc_event_id = '" . $gc_event_id . "' where order_id = '" . $last_id . "'";
        $res                   = mysqli_query($this->conn, $update_gc_event_query);
        return $res;
    }
    function update_gc_staffid_event_id($last_id, $gc_event_id)
    {
        $update_gc_event_query = "update " . $this->table_name . " set gc_staff_event_id = '" . $gc_event_id . "' where order_id = '" . $last_id . "'";
        $res                   = mysqli_query($this->conn, $update_gc_event_query);
        return $res;
    }
    public function readall_bookings_oid()
    {
        $query  = "select * from `" . $this->table_name . "` where `order_id`='" . $this->order_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value;
    }
    public function read_net_amt()
    {
        $query  = "select * from ld_payments where `order_id`='" . $this->order_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value;
    }
    public function check_for_booking_pickup_date_time_start($booking_pickup_date_time_start, $staff_id)
    {
        $query  = "select * from ld_bookings where `booking_pickup_date_time_start`='" . $booking_pickup_date_time_start . "'";
        $result = mysqli_query($this->conn, $query);
        if (mysqli_num_rows($result) > 0) {
            return false;
        } else {
            if ($staff_id != '') {
                $exploded_staffs = explode(',', $staff_id);
                $i               = 1;
                foreach ($exploded_staffs as $staff) {
                    $qry = "select * from ld_week_days_available where `provider_id`='" . $staff . "' limit 1";
                    $res = mysqli_query($this->conn, $qry);
                    if (sizeof($exploded_staffs) == $i) {
                        if (mysqli_num_rows($res) > 0) {
                            $val = mysqli_fetch_assoc($res);
                            if ($val['provider_schedule_type'] == 'monthly') {
                                $date       = date('Y-m-d', strtotime($booking_pickup_date_time_start));
                                $date_day   = date('l', strtotime($booking_pickup_date_time_start));
                                $week_id    = $this->ld_getWeeks($date, $date_day);
                                $weekday_id = date('N', strtotime($booking_pickup_date_time_start));
                                $q          = "select * from ld_week_days_available where `weekday_id`='" . $weekday_id . "' and `week_id`='" . $week_id . "' and `off_day`='Y'";
                                $r          = mysqli_query($this->conn, $q);
                                if (mysqli_num_rows($r) > 0) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                $date       = date('Y-m-d', strtotime($booking_pickup_date_time_start));
                                $week_id    = '1';
                                $weekday_id = date('N', strtotime($booking_pickup_date_time_start));
                                $q          = "select * from ld_week_days_available where `weekday_id`='" . $weekday_id . "' and `week_id`='" . $week_id . "' and `off_day`='Y'";
                                $r          = mysqli_query($this->conn, $q);
                                if (mysqli_num_rows($r) > 0) {
                                    return false;
                                } else {
                                    return true;
                                }
                            }
                        } else {
                            $qq = "select * from ld_week_days_available where `provider_id`='1' limit 1";
                            $rr = mysqli_query($this->conn, $qq);
                            if (mysqli_num_rows($rr) > 0) {
                                $val = mysqli_fetch_assoc($rr);
                                if ($val['provider_schedule_type'] == 'monthly') {
                                    $date       = date('Y-m-d', strtotime($booking_pickup_date_time_start));
                                    $date_day   = date('l', strtotime($booking_pickup_date_time_start));
                                    $week_id    = $this->ld_getWeeks($date, $date_day);
                                    $weekday_id = date('N', strtotime($booking_pickup_date_time_start));
                                    $q          = "select * from ld_week_days_available where `weekday_id`='" . $weekday_id . "' and `week_id`='" . $week_id . "' and `off_day`='Y'";
                                    $r          = mysqli_query($this->conn, $q);
                                    if (mysqli_num_rows($r) > 0) {
                                        return false;
                                    } else {
                                        return true;
                                    }
                                } else {
                                    $date       = date('Y-m-d', strtotime($booking_pickup_date_time_start));
                                    $week_id    = '1';
                                    $weekday_id = date('N', strtotime($booking_pickup_date_time_start));
                                    $q          = "select * from ld_week_days_available where `weekday_id`='" . $weekday_id . "' and `week_id`='" . $week_id . "' and `off_day`='Y'";
                                    $r          = mysqli_query($this->conn, $q);
                                    if (mysqli_num_rows($r) > 0) {
                                        return false;
                                    } else {
                                        return true;
                                    }
                                }
                            } else {
                                return false;
                            }
                        }
                    } else if (mysqli_num_rows($res) > 0) {
                        $val = mysqli_fetch_assoc($res);
                        if ($val['provider_schedule_type'] == 'monthly') {
                            $date       = date('Y-m-d', strtotime($booking_pickup_date_time_start));
                            $date_day   = date('l', strtotime($booking_pickup_date_time_start));
                            $week_id    = $this->ld_getWeeks($date, $date_day);
                            $weekday_id = date('N', strtotime($booking_pickup_date_time_start));
                            $q          = "select * from ld_week_days_available where `weekday_id`='" . $weekday_id . "' and `week_id`='" . $week_id . "' and `off_day`='Y'";
                            $r          = mysqli_query($this->conn, $q);
                            if (mysqli_num_rows($r) > 0) {
                                return false;
                            } else {
                                return true;
                            }
                        } else {
                            $date       = date('Y-m-d', strtotime($booking_pickup_date_time_start));
                            $week_id    = '1';
                            $weekday_id = date('N', strtotime($booking_pickup_date_time_start));
                            $q          = "select * from ld_week_days_available where `weekday_id`='" . $weekday_id . "' and `week_id`='" . $week_id . "' and `off_day`='Y'";
                            $r          = mysqli_query($this->conn, $q);
                            if (mysqli_num_rows($r) > 0) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    } else {
                        $i++;
                        continue;
                    }
                    $i++;
                }
            } else {
                $qq = "select * from ld_week_days_available where `provider_id`='1' limit 1";
                $rr = mysqli_query($this->conn, $qq);
                if (mysqli_num_rows($rr) > 0) {
                    $val = mysqli_fetch_assoc($rr);
                    if ($val['provider_schedule_type'] == 'monthly') {
                        $date       = date('Y-m-d', strtotime($booking_pickup_date_time_start));
                        $date_day   = date('l', strtotime($booking_pickup_date_time_start));
                        $week_id    = $this->ld_getWeeks($date, $date_day);
                        $weekday_id = date('N', strtotime($booking_pickup_date_time_start));
                        $q          = "select * from ld_week_days_available where `weekday_id`='" . $weekday_id . "' and `week_id`='" . $week_id . "' and `off_day`='Y'";
                        $r          = mysqli_query($this->conn, $q);
                        if (mysqli_num_rows($r) > 0) {
                            return false;
                        } else {
                            return true;
                        }
                    } else {
                        $date       = date('Y-m-d', strtotime($booking_pickup_date_time_start));
                        $week_id    = '1';
                        $weekday_id = date('N', strtotime($booking_pickup_date_time_start));
                        $q          = "select * from ld_week_days_available where `weekday_id`='" . $weekday_id . "' and `week_id`='" . $week_id . "' and `off_day`='Y'";
                        $r          = mysqli_query($this->conn, $q);
                        if (mysqli_num_rows($r) > 0) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                } else {
                    return false;
                }
            }
        }
    }
    public function staff_status_select_staff_id()
    {
        $query  = "select `id` from `" . $this->table_staff_status . "` where `staff_id`='" . $this->staff_id . "' and  `order_id`='" . $this->order_id . "'";
      
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_assoc($result);
        return $value;
    }
    public function readone_bookings_details_by_order_id_s_id()
    {
        $query  = "select status from `" . $this->table_staff_status . "` where `order_id`='" . $this->order_id . "' and `staff_id`='" . $this->staff_id . "'";
       /*  die; */
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value;
    }
    public function readone_bookings_details_by_order_id()
    {
        $query  = "select * from `" . $this->table_name . "` where `order_id`='" . $this->order_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        return $value;
    }
    public function update_staff_status()
    {
        $query  = "update `" . $this->table_staff_status . "` set `status`='" . $this->status . "' where  `order_id`='" . $this->order_id . "'";     
	    $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function readone_bookings_sid_staff()
    {
        $query  = "select * from `" . $this->table_staff_status . "` where `order_id`='" . $this->order_id . "' and `status`='" . $this->status . "' order by order_id DESC limit 1";
        /* die; */
        $result = mysqli_query($this->conn, $query);
        $value  = mysqli_fetch_array($result);
        
        return $value;
    }
    public function update_staff_id_bookings_details_by_order_id()
    {
        $query  = "update `" . $this->table_name . "` set `staff_ids`='" . $this->staff_id . "' and `booking_status`='" . $this->status . "' where `order_id`='" . $this->booking_id . "'";
      
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function staff_status_insert()
    {
        $query  = "INSERT INTO `" . $this->table_staff_status . "`(`id`,`staff_id`,`order_id`,`status`) VALUES(null,'" . $this->staff_id . "','" . $this->order_id . "','A')";
        $result = mysqli_query($this->conn, $query);
        return mysqli_insert_id($this->conn);
    }
    public function staff_status_read_one_by_or_id()
    {
        $query  = "SELECT * FROM `" . $this->table_staff_status . "` WHERE `order_id`='" . $this->order_id . "' ORDER BY `id` DESC";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function get_all_past_bookings()
    {
        $query  = "SELECT `order_id` FROM `ld_bookings` WHERE `booking_pickup_date_time_start`<='" . $this->booking_start_datetime . "' GROUP BY `order_id` ORDER BY `order_id` ";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function get_all_upcoming_bookings()
    {
        $query  = "SELECT `order_id` FROM `ld_bookings` WHERE `booking_pickup_date_time_start`>='" . $this->booking_start_datetime . "' GROUP BY `order_id` ORDER BY `order_id` ";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* API Function */
    public function get_all_past_bookings_api()
    {
        $query  = "SELECT `order_id`,`client_id`,`staff_ids` FROM `ld_bookings` WHERE `booking_pickup_date_time_start`<='" . $this->booking_start_datetime . "' GROUP BY `order_id` ORDER BY `booking_pickup_date_time_start` DESC limit " . $this->limit . " offset " . $this->offset;
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* API Function */
    public function get_all_upcoming_bookings_api()
    {
        $query  = "SELECT `order_id`,`client_id`,`staff_ids` FROM `ld_bookings` WHERE `booking_pickup_date_time_start`>='" . $this->booking_start_datetime . "' GROUP BY `order_id` ORDER BY `booking_pickup_date_time_start` limit " . $this->limit . " offset " . $this->offset;
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function complete_booking()
    {
        $query  = "UPDATE `" . $this->table_name . "` SET `booking_status`='" . $this->booking_status . "',`lastmodify`='" . $this->lastmodify . "' WHERE `order_id`='" . $this->order_id . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* Used in booking_ajax */
    public function get_booking_units_from_order()
    {
        $query  = "select * from `" . $this->tablename5 . "` where `order_id`='" . $this->order_id . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* Used in booking_ajax */
    public function get_booking_units_from_order_api($order_id)
    {
        $query  = "select * from `" . $this->tablename5 . "` where `order_id`='$order_id'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* staff provide status for booking */    
    public function staff_provide_status()
    {
        $query  =  "update `" . $this->table_name . "` set `status`='" . $this->status . "' where `order_id`='" . $this->staff_order_id . "' and `staff_ids`='" . $this->staff_id . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }

    /* public function get_methods_ofbookings($orderid){
		$query = "select `b`.`method_unit_qty` as `qtys`,`sm`.*,`smu`.* from `ld_bookings` as `b`,`ld_services_method` as `sm`,`ld_service_methods_units` as `smu` where `b`.`method_id` = `sm`.`id` and `b`.`method_unit_id` = `smu`.`id` and `b`.`order_id` ='".$orderid."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	} */

    /* public function get_addons_ofbookings($orderid){
		$query = "select DISTINCT `ba`.*,`sa`.* from `ld_bookings` as `b`,`ld_booking_addons` as `ba`,`ld_services_addon` as `sa` where `b`.`order_id` = `ba`.`order_id` and `ba`.`addons_service_id` = `sa`.`id` and `b`.`order_id` = '".$orderid."' ";
		$result=mysqli_query($this->conn,$query);
		return $result;
	} */
}
?>