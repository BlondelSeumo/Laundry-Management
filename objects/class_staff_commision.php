<?php  
class laundry_staff_commision{		
	public $id;
	public $order_id;
	public $staff_id;
	public $amt_payable;
	public $advance_paid;
	public $net_total;
	public $payment_method;
	public $transaction_id;
	public $payment_date;
	public $table_name="ld_staff_commision";
	public $conn;

	public function readall_booking()
	{
		$query = "select `service_id`,`client_id`,`staff_ids`,`order_id`, `booking_status`, `booking_pickup_date_time_start` from `ld_bookings` where `staff_ids`<>'' group by `service_id`,`client_id`,`staff_ids`,`order_id`, `booking_status`, `booking_pickup_date_time_start` ";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}

	public function get_staff_bookingandpayment_by_date($start, $end)
	{
		$query = "select `service_id`,`client_id`,`staff_ids`,`order_id`, `booking_status`, `booking_pickup_date_time_start` from `ld_bookings` where `staff_ids`<>'' and `booking_pickup_date_time_start` between '".$start."' and '".$end."' group by  `service_id`,`client_id`,`staff_ids`,`order_id`, `booking_status`, `booking_pickup_date_time_start`";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}

	public function get_staff_bookingandpayment_by_dateser($start, $end, $sid)
	{
		$query = "select `service_id`,`client_id`,`staff_ids`,`order_id`, `booking_status`, `booking_pickup_date_time_start` from `ld_bookings` where `staff_ids`<>'' and `service_id` = '".$sid."' and `booking_pickup_date_time_start` between '".$start."' and '".$end."' group by `service_id`,`client_id`,`staff_ids`,`order_id`, `booking_status`, `booking_pickup_date_time_start`";
		
		$result=mysqli_query($this->conn,$query);
		return $result;
	}

	public function get_service_name($id)
	{
		$query = "select * from `ld_services` where `id`=".$id;
		$result = mysqli_query($this->conn,$query);
		if(!empty($result)){ 
		$value = mysqli_fetch_array($result);
		 }
		return $value= isset($value['title'])? $value['title'] : '' ;
	}

	public function get_client_name($id)
	{
		$query = "select * from `ld_users` where `id`=".$id;
		$result = mysqli_query($this->conn,$query);
		$value = mysqli_fetch_array($result);
		return $value['first_name'].' '.$value['last_name'];
	}

	public function get_staff_name($id)
	{
		$query = "select * from `ld_admin_info` where `id` IN (".$id.")";
		$result = mysqli_query($this->conn,$query);
		$staff_name = '';
		$total = mysqli_num_rows($result);
		if($total == 1){
			$value = mysqli_fetch_array($result);
			$staff_name = $value['fullname'];
		}else if($total > 1){
			while($value = mysqli_fetch_array($result)){
				$staff_name .= $value['fullname'].', ';
			}
		}
		return $staff_name;
	}

	public function get_staff_detail($id)
	{
		$query = "select * from `ld_admin_info` where `id` IN (".$id.")";
		$result = mysqli_query($this->conn,$query);
		return $result;
	}

	public function get_net_total($id)
	{
		$query = "SELECT * FROM `ld_payments` WHERE `order_id`=".$id;
		$result = mysqli_query($this->conn,$query);
		$value = mysqli_fetch_array($result);
		return $value['net_amount'];
	}
	
	public function insert_staff_commision($order_id,$staff_id,$amt_payable,$advance_paid,$net_total,$payment_method,$transaction_id,$payment_date)
	{
		$query = "INSERT INTO `ld_staff_commission` (`id`, `order_id`, `staff_id`, `amt_payable`, `advance_paid`, `net_total`, `payment_method`, `transaction_id`, `payment_date`) VALUES (NULL, '".$order_id."', '".$staff_id."', '".$amt_payable."', '".$advance_paid."', '".$net_total."', '".$payment_method."', '".$transaction_id."', '".$payment_date."');";
		$result = mysqli_query($this->conn,$query);
		return $result;
	}
	
	public function readall_ld_staff_commision()
	{
		$query="select * from `ld_staff_commission`";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	public function check_staff_commision_payment($order_id,$staff_id){
		$query = "select * from `ld_staff_commission` where `order_id`='".$order_id."' and `staff_id`='".$staff_id."'";
		$result = mysqli_query($this->conn,$query);
		$value = mysqli_num_rows($result);
		return $value;
	}
	
	public function update_staff_commision_payment($order_id,$staff_id,$amt_payable,$advance_paid,$net_total,$payment_date){
		$query = "update `ld_staff_commission` set `amt_payable`='".$amt_payable."', `advance_paid` ='".$advance_paid."', `net_total` ='".$net_total."', `payment_date`  ='".$payment_date."' where `order_id`='".$order_id."' and `staff_id`='".$staff_id."'";
		$result = mysqli_query($this->conn,$query);
		$value = mysqli_num_rows($result);
		return $value;
	}
	
	public function staff_service_details($staff_id){
		$arr = array();
		 $query = "select `order_id`, `service_id`, `booking_pickup_date_time_start`, `staff_ids`, `booking_status` from `ld_bookings` group by `booking_status`, `order_id`, `service_id`, `booking_pickup_date_time_start`, `staff_ids` ORDER BY `order_id` DESC";
		/* die; */
		$result=mysqli_query($this->conn,$query);
		if(!empty($result)){ 
		while($value = mysqli_fetch_assoc($result)){
			$stafid = explode(',',$value['staff_ids']);
			if(sizeof($stafid) > 0){
				foreach($stafid as $sid){
					if($sid == $staff_id){
						array_push($arr,$value);
					}
				}
			}
		 }   
		}
		return $arr;
	}
	
	public function readall_staff_pymt_ser(){
		$query = "select * from `ld_services`";
		$result = mysqli_query($this->conn,$query);
		return $result;
	}
	
	public function get_booking_nettotal($staff_id, $order_id)
	{
		$query = "SELECT sum(`net_total`) FROM `ld_staff_commission` WHERE `staff_id`='".$staff_id."' AND `order_id`='".$order_id."'";
		
		$result=mysqli_query($this->conn,$query);
		$value = mysqli_fetch_array($result);
		if(isset($value) && sizeof($value) > 0){
			return $value[0];
		}else{
			return 0;
		}
	}
	
	public function get_payment_staff_by_date($start, $end)
	{
		$query = "select * from `ld_staff_commission` where `payment_date` between '".$start."' and '".$end."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	public function get_booking_assign(){
	     $query = "select * from ld_staff_commission where staff_id='".$this->staff_id."'";
		
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	public function get_total_payment()
	{
		$query = "SELECT `net_amount` FROM `ld_payments` WHERE `order_id`='".$this->order_id."'";
		$result = mysqli_query($this->conn,$query);
		$value = mysqli_fetch_assoc($result);
		return $value['net_amount'];
	}
	
	/* GET APPOINTMENTS ASSIGNED STAFF*/
    public function get_staff_details_api() {
        $query = "select `p`.`order_id`, `b`.`booking_pickup_date_time_start`, `b`.`booking_status`, `b`.`reject_reason`,`s`.`title`,`p`.`net_amount` as `total_payment`,`b`.`gc_event_id`,`b`.`gc_staff_event_id`,`b`.`staff_ids` from `ld_bookings` as `b`,`ld_payments` as `p`,`ld_services` as `s`,`ld_admin_info` as `u` where `b`.`staff_ids` = $this->id and `b`.`service_id` = `s`.`id` and `b`.`order_id` = `p`.`order_id` and `u`.`role`= 'staff' GROUP BY `p`.`order_id`, `b`.`booking_pickup_date_time_start`, `b`.`booking_status`, `b`.`reject_reason`,`s`.`title`,`p`.`net_amount` order by `b`.`booking_pickup_date_time_start` desc";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
	
}
?>