<?php  
	
class laundry_coupon{
	
	public $coupon_id;
	public $coupon_code;
	public $coupon_type;
	public $coupon_limit;
	public $coupon_value;
	public $coupon_expiry;
	public $status;
	public $today_date;
	public $conn;
	public $inc;
	public $dec;
	public $coupon_status;
	public $table_name="ld_coupons";
	
	
	/* 
	* Function for add Coupon in setting 
	*
	*/
	
	public function add_coupon(){
		$query="insert into `".$this->table_name."` (`id`,`coupon_code`,`coupon_type`,`coupon_limit`,`coupon_used`,`coupon_value`,`coupon_expiry`,`status`) values(NULL,'".$this->coupon_code."','".$this->coupon_type."','".$this->coupon_limit."','0','".$this->coupon_value."','".$this->coupon_expiry."','".$this->status."')";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_insert_id($this->conn);
		return $value;
	}
	
	/* 
	* Function for Update Coupon in setting 
	*
	*/
	
	public function update_coupon(){
		$query="update `".$this->table_name."` set `coupon_code`='".$this->coupon_code."',`coupon_type`='".$this->coupon_type."',`coupon_limit`='".$this->coupon_limit."',`coupon_used`='0',`coupon_value`='".$this->coupon_value."',`coupon_expiry`='".$this->coupon_expiry."',`status`='".$this->status."' where `id`='".$this->coupon_id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* 
	*Function for Delete Coupon in setting
	*
	*/
	
	public function delete_coupon(){
		$query="delete from `".$this->table_name."` where `id`='".$this->coupon_id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* 
	* Function for Read All Coupon in setting
	*
	*/
	
	public function readall(){
		$query="select * from `".$this->table_name."`";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* 
	* Function for Read One Coupon in setting
	* 
	*/
	
	public function readone(){
		$query="select * from `".$this->table_name."` where `id`='".$this->coupon_id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	
	/* 
	* Function for Update Status of Coupon in setting
	*
	*/
	
	public function updatestatus(){
		$query="update `".$this->table_name."` set `status`='".$this->coupon_status."' where `id`='".$this->coupon_id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	/**/
	public function checkcode(){
       $query="select * from `".$this->table_name."` where `coupon_code`='".$this->coupon_code."'";
       $result=mysqli_query($this->conn,$query);
       $value=mysqli_fetch_array($result);
       return $value;
   }
   
	   public function getdate(){
		   $query="select `coupon_expire` from `".$this->table_name."` where `coupon_code`='".$this->coupon_code."'";
		   $result=mysqli_query($this->conn,$query);
		   $value=mysqli_fetch_array($result);
		   return $value;
	   }
	   /**/
	   public function update_coupon_limit(){
		   $query="update `".$this->table_name."` set `coupon_used`='".$this->inc."' where `coupon_code`='".$this->coupon_code."'";
		   $result=mysqli_query($this->conn,$query);
		   return $result;
	   }
	   /**/
	   public function update_coupon_used(){
		   $query="update `".$this->table_name."` set `coupon_used`='".$this->dec."' where `coupon_code`='".$this->coupon_code."'";
		   $result=mysqli_query($this->conn,$query);
		   return $result;
	   }

	   public function special_offer() {
		$query="SELECT * FROM `ld_special_offer` WHERE `coupon_date` = '".$this->today_date."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
}
?>