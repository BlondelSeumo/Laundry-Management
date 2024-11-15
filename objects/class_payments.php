<?php  

class laundry_payments{
	public $payment_id;
	public $order_id;
	public $payment_method;
	public $transaction_id;
	public $amount;
	public $discount;
	public $taxes;
	public $partial_amount;
	public $payment_date;
	public $net_amount;
	public $lastmodify;
	public $payment_status;
	public $conn;
	public $table_name="ld_payments";
	public $tablename="ld_order_client_info";
	
	/* 
	* Function for add Payments
	*
	*/
	
	public function add_payments(){
		if($this->discount == 'undefined' || $this->discount == ''){
			$discount = 0;
		}else{
			$discount = $this->discount;
		}
		if($this->partial_amount == ''){
			$partial_amount = 0;
		}else{
			$partial_amount = $this->partial_amount;
		}
		$query="insert into `".$this->table_name."` (`id`,`order_id`,`payment_method`,`transaction_id`,`amount`,`discount`,`taxes`,`partial_amount`,`payment_date`,`net_amount`,`lastmodify`,`payment_status`) values(NULL,'".$this->order_id."','".$this->payment_method."','".$this->transaction_id."','".$this->amount."','".$discount."','".$this->taxes."','".$partial_amount."','".$this->payment_date."','".$this->net_amount."','".$this->lastmodify."','".$this->payment_status."')";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	
	/* 
	* Function for Read All Payments
	*
	*/
	
	public function readall(){
		$query="select * from `".$this->table_name."`";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	
	
	/* 
	* Function for Display listing of Payments
	*
	*/
/* get payment entry by given date */
	public function getallpaymentsbydate($startdate,$enddate){
		$query = "SELECT * FROM `".$this->table_name."` WHERE `payment_date` BETWEEN '$startdate' AND '$enddate'";
		$result = mysqli_query($this->conn,$query);
		return $result;
	}
	public function getallpayment(){
		$query = "SELECT * FROM `".$this->table_name."`";
		$result = mysqli_query($this->conn,$query);
		return $result;
	}
	/* get client name by order_id */
	public function getclientname($orderid){
		
		$query = "select `client_name` from `ld_order_client_info` where `order_id` = '".$orderid."'";
		$res = mysqli_query($this->conn,$query);
		$value = mysqli_fetch_row($res);
		return $value[0];
	}
	
	public function getclientemail($orderid){
		
		$query = "select `client_email` from `ld_order_client_info` where `order_id` = '".$orderid."'";
		$res = mysqli_query($this->conn,$query);
		$value = mysqli_fetch_row($res);
		return $value[0];
	}
	
	/* Get Payment Details using order id */
	public function get_payment_details(){
		$query="select * from `".$this->table_name."` where `order_id`='".$this->order_id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_row($result);
		return $value;
	}
	

	/* methods by end */
	public function readone_payment_details(){
		$query="select * from `".$this->table_name."` where `order_id`='".$this->order_id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_array($result);
		return $value;
	}
	public function update_payment_status_of_staff(){
		$query="update `".$this->table_name."` set `payment_status`='".$this->payment_status."' where `order_id`='".$this->order_id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
		/* update Payment status using order id */
	public function update_payment_status($order_id,$update_status){
		$query="update `".$this->table_name."` set `payment_status`='".$update_status."' where `order_id`='".$order_id."'";
		$result=mysqli_query($this->conn,$query);
		
		return $result;
	}
}
?>