<?php

class laundry_dashboard
{
    /* get all data for popup of the click */
    /* get cleint detail */
    public $recurring_id;
    public $conn;
    public function getclient($id)
    {
        $query = "SELECT * FROM `ld_users` WHERE `id` = $id";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }
    /* get guest client info */
    public function getguestclient($orderid)
    {
        $query = "SELECT * FROM `ld_order_client_info` WHERE `order_id` = $orderid";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }
    /* get client order for popup */
    public function getclientorder($orderid)
    {
        $query = "SELECT `b`.`booking_pickup_date_time_start`,
					`p`.`net_amount`,
					`b`.`client_id`,
					`b`.`service_id`,
					`b`.`order_id`,
					`p`.`payment_method`,
					`b`.`booking_status`,
					`b`.`reject_reason`,
					`b`.`booking_pickup_date_time_end`,
					`b`.`show_delivery_date`,
					`b`.`booking_delivery_date_time_start`,
					`b`.`booking_delivery_date_time_end`,
					`b`.`self_service`
					FROM `ld_bookings` as `b`,`ld_services` as `s`,`ld_payments` as `p`,`ld_order_client_info` as `oci`
                    WHERE `b`.`service_id` = `s`.`id`
                    and `b`.`order_id` = `p`.`order_id`
					and `b`.`order_id` = `oci`.`order_id`
                    and `b`.`order_id` = $orderid GROUP BY `b`.`booking_pickup_date_time_start`,
                    `b`.`service_id`,
                    `p`.`net_amount`,
                    `b`.`client_id`,
                    `b`.`order_id`,
                    `p`.`payment_method`,
                    `b`.`booking_status`,
                    `b`.`reject_reason`,
                    `b`.`booking_pickup_date_time_end`,
                    `b`.`show_delivery_date`,
                    `b`.`booking_delivery_date_time_start`,
                    `b`.`booking_delivery_date_time_end`,
                    `b`.`self_service`";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }
    /* notificatrion code */
    /* get total no of bookings */
    public function getallbookings_notify()
    {
        $query = "SELECT `b`.`read_status`, `b`.`service_id`, `b`.`order_id`, `b`.`booking_status`, `b`.`booking_pickup_date_time_start`, `b`.`lastmodify`, `b`.`client_id` FROM `ld_bookings` as `b` GROUP BY `b`.`order_id`, `b`.`read_status`, `b`.`booking_status`, `b`.`booking_pickup_date_time_start`, `b`.`lastmodify`, `b`.`client_id` ORDER BY `b`.`lastmodify` DESC";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* get total no of bookings */
    public function getallbookingsunread_count()
    {
        $query = "SELECT `order_id` FROM `ld_bookings` WHERE `read_status` = 'U' GROUP BY `order_id` ORDER BY `order_id` DESC";
        $result = mysqli_query($this->conn, $query);

        return $result;
    }
    /* Confirm the booking */
    public function confirm_bookings($orderid, $lastmodify)
    {
        $query = "update `ld_bookings` set `booking_status`='C',`lastmodify` = '" . $lastmodify . "' where `order_id`='" . $orderid . "' ";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* function to update the read ststus of the notification */
    public function update_read_status($orderid)
    {
        $query = "update `ld_bookings` set `read_status`='R' where `order_id`='" . $orderid . "' ";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* reject the order/bookings */
    public function reject_bookings($orderid, $reason, $lastmodify)
    {
        $query = "update `ld_bookings` set `booking_status`='R',`reject_reason`='" . $reason . "',`lastmodify` = '" . $lastmodify . "' where `order_id`='" . $orderid . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /*  delete the booking */
    public function delete_booking($orderid)
    {
        /* ld_staff_commission */
        $query5 = "delete from `ld_staff_commission` where `order_id`='" . $orderid . "'";
        $result5 = mysqli_query($this->conn, $query5);
        /* bookings */
        $query1 = "delete from `ld_bookings` where `order_id`='" . $orderid . "'";
        $result = mysqli_query($this->conn, $query1);
        /* booking_addons */
        $query2 = "delete from `ld_booking_units` where `order_id`='" . $orderid . "'";
        $result = mysqli_query($this->conn, $query2);
        /* payments */
        $query3 = "delete from `ld_payments` where `order_id`='" . $orderid . "'";
        $result = mysqli_query($this->conn, $query3);
        /* order_client_info */
        $query4 = "delete from `ld_order_client_info` where `order_id`='" . $orderid . "'";
        $result = mysqli_query($this->conn, $query4);
    }
    /* get total guest users */
    public function total_guest_users()
    {
        $query = "select count(*) from `ld_bookings` where `client_id` = 0 GROUP BY `id`, `order_id`, `client_id`, `order_date`, `booking_pickup_date_time_start`, `service_id`, `method_id`, `method_unit_id`, `method_unit_qty`, `method_unit_qty_rate`, `booking_status`, `reject_reason`, `reminder_status`, `lastmodify`, `read_status`, `staff_ids`, `gc_event_id`, `gc_staff_event_id` ORDER BY `order_id`;";
        $result = mysqli_query($this->conn, $query);
        return count(mysqli_num_rows($result));
    }

    /* newly added */
    public function clientemailsender($orderid)
    {
        $query = "select `s`.`title`,`oci`.`client_name`,`oci`.`client_email`,`b`.`booking_pickup_date_time_start`,`b`.`booking_delivery_date_time_start`,`a`.`email`, `a`.`fullname`
            from
            `ld_order_client_info` as `oci`,`ld_bookings` as `b`,`ld_services` as `s` , `ld_admin_info` as `a`
            where
            `b`.`order_id` = '" . $orderid . "'
            and `b`.`order_id`  = `oci`.`order_id`
            and `b`.`service_id` = `s`.`id`";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_array($result);
        return $value;
    }


    /*function to count total no of services */
    public function countallservice()
    {
        $query = "select count(*) as `c` from `ld_services`";
        $result = mysqli_query($this->conn, $query);
        $value = @mysqli_fetch_row($result);
        return $value[0];
    }
    /*NEWLY ADDED FUNCTIONS */
    /*SMS TEMPLATE GET FOR CONFIRM*/
    public function gettemplate_sms($action, $user)
    {
        $query = "select * from `ld_sms_templates` where `sms_template_type` = '" . $action . "' and `user_type` = '" . $user . "'";
        $result = mysqli_query($this->conn, $query);
        $value = @mysqli_fetch_row($result);
        return $value;
    }
    /* get client order for popup api */
    public function getclientorder_api($orderid)
    {
        $query = "SELECT `b`.`booking_pickup_date_time_start`,
					`s`.`title`,
					`p`.`net_amount`,
					`b`.`client_id`,
					`b`.`order_id`,
					`p`.`payment_method`,
					`b`.`booking_status`
					FROM `ld_bookings` as `b`,`ld_services` as `s`,`ld_payments` as `p`
                    WHERE `b`.`service_id` = `s`.`id`
                    and `b`.`order_id` = `p`.`order_id`
                    and `b`.`order_id` = $orderid GROUP BY `b`.`order_id`, `b`.`booking_pickup_date_time_start`, `s`.`title`, `p`.`net_amount`, `b`.`client_id`, `p`.`payment_method`, `b`.`booking_status`";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }
}
