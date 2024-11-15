<?php   

class laundry_userdetails {
    public $id;
    public $firstname;
    public $lastname;
    public $password;
    public $phone;
    public $address;
    public $city;
    public $state;
    public $zip;
    public $tablename="ld_users";
    public $tableadmin="ld_admin_info";
    public $reason;
    public $conn;
    /*Function for Read Only one data matched with Id*/
    public function readone(){
        $query="select * from `".$this->tablename."` where `id`='".$this->id."'";
        $result=mysqli_query($this->conn,$query);
        $value=mysqli_fetch_row($result);
        return $value;
    }
    /*Function for Update service-Not Used in this*/
    public function update_profile(){
        $address = mysqli_real_escape_string($this->conn,$this->address);
        $query="update `".$this->tablename."` set `first_name`='".$this->firstname."'
        ,`phone`='".$this->phone."'
        ,`last_name`='".$this->lastname."'
        ,`address`='".$address."'
        ,`city`='".$this->city."'
        ,`state`='".$this->state."'
        ,`zip`='".$this->zip."'
        ,`user_pwd`='".$this->password."'
        where `id`='".$this->id."' ";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }
    /* GET USER DETAIL FOR MY_APPOINTMENT PAGE */
		public function get_user_details(){
		$query="select `p`.`order_id`,`b`.`service_id`, `b`.`booking_pickup_date_time_start`, `b`.`booking_delivery_date_time_start`, `b`.`booking_status`, `b`.`reject_reason`,`s`.`title`,`p`.`net_amount` as `total_payment`,`b`.`gc_event_id`,`b`.`gc_staff_event_id`,`b`.`staff_ids` from `ld_bookings` as `b`,`ld_payments` as `p`,`ld_services` as `s`,`ld_users` as `u` where `b`.`client_id` = `u`.`id` and `b`.`service_id` = `s`.`id` and `b`.`order_id` = `p`.`order_id` and `u`.`id` = $this->id GROUP BY `p`.`order_id`, `b`.`booking_pickup_date_time_start`, `b`.`booking_delivery_date_time_start`, `b`.`booking_status`, `b`.`reject_reason`,`s`.`title`,`p`.`net_amount` ,`b`.`gc_event_id`,`b`.`gc_staff_event_id`,`b`.`staff_ids` order by `b`.`order_id` desc";
		$result=mysqli_query($this->conn,$query);
		return $result;
		}
		/* This Function For API */
		public function get_user_details_api(){
        $query="select `p`.`order_id`, `b`.`booking_pickup_date_time_start`, `b`.`booking_status`, `b`.`reject_reason`,`s`.`title`,`p`.`net_amount` as `total_payment`,`b`.`gc_event_id`,`b`.`gc_staff_event_id`,`b`.`staff_ids` from `ld_bookings` as `b`,`ld_payments` as `p`,`ld_services` as `s`,`ld_users` as `u` where `b`.`client_id` = `u`.`id` and `b`.`service_id` = `s`.`id` and `b`.`order_id` = `p`.`order_id` and `u`.`id` = $this->id GROUP BY `p`.`order_id`, `b`.`booking_pickup_date_time_start`, `b`.`booking_status`, `b`.`reject_reason`,`s`.`title`,`p`.`net_amount` order by `b`.`order_id` desc limit ".$this->limit." offset ".$this->offset;
        $result=mysqli_query($this->conn,$query);
        return $result;
    }
		/* GET APPOINTMENTS ASSIGNED STAFF for API*/
    public function get_staff_details_api()
    {
        $query  = "select `p`.`order_id`, `b`.`booking_pickup_date_time_start`, `b`.`booking_status`, `b`.`reject_reason`,`s`.`title`,`p`.`net_amount` as `total_payment`,`b`.`gc_event_id`,`b`.`gc_staff_event_id`,`b`.`staff_ids` from `ld_bookings` as `b`,`ld_payments` as `p`,`ld_services` as `s`,`ld_admin_info` as `u` where `b`.`staff_ids` = $this->id and `b`.`service_id` = `s`.`id` and `b`.`order_id` = `p`.`order_id` and `u`.`role`= 'staff' GROUP BY `p`.`order_id`, `b`.`booking_pickup_date_time_start`, `b`.`booking_status`, `b`.`reject_reason`,`s`.`title`,`p`.`net_amount` order by `b`.`booking_pickup_date_time_start` desc";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    /* GET NOTES FO THE USER FOR RESCHEDULE */
    public function get_user_notes($orderid){
        $query="select `client_personal_info` from `ld_order_client_info` where `order_id` = $orderid";
        $result=mysqli_query($this->conn,$query);
        $value = mysqli_fetch_row($result);
        return $value;
    }
    /* update the booking datails of user */
    public function reschedule_booking($finaldate,$finaldate_end,$finaldate_delivery,$finaldate_end_delivery,$orderid,$bookingstatus,$readstatus,$lastmodify){
        $query ="UPDATE `ld_bookings` SET `booking_pickup_date_time_start` = '".$finaldate."',`booking_pickup_date_time_end` = '".$finaldate_end."',`booking_delivery_date_time_start` = '".$finaldate_delivery."',`booking_delivery_date_time_end` = '".$finaldate_end_delivery."',`booking_status` = '".$bookingstatus."',`read_status` = '".$readstatus."',`lastmodify` = '".$lastmodify."' where `order_id` = $orderid";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }
    /* UPDATE CLIENT PERSONAL INFO IN ORDER CLIENT INFO AFTER RESCHEDULE */
    public function update_notes($orderid,$client_personal_info){
        $query ="UPDATE `ld_order_client_info` SET `client_personal_info` = '".$client_personal_info."' where `order_id` = $orderid";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }
    /* UPDATE STATUS OF BOOKING IF USER CANCEL BY ITES OWN */
    public function update_booking_of_user($orderid,$reason,$lastmodify){
        $query ="UPDATE `ld_bookings` SET `booking_status` = 'CC' ,`reject_reason`='".$reason."',`lastmodify` = '".$lastmodify."' where `order_id` = $orderid";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }
	public function check_customer_email_existing(){
	  $query="select * from `".$this->tablename."` where `user_email`='".$this->email."'";
			$result=mysqli_query($this->conn,$query);
			$value = mysqli_num_rows($result);
			return $value;
	 }
	 
	 public function check_admin_email_existing(){
	  $query="select * from `".$this->tableadmin."` where `email`='".$this->email."'";
			$result=mysqli_query($this->conn,$query);
			$value = mysqli_num_rows($result);
			return $value;
	 }
}