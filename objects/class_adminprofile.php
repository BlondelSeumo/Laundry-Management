<?php  

class laundry_adminprofile {

    public $id;
    public $email;
    public $pass;
    public $fullname;
    public $password;
    public $phone;
    public $address;
    public $city;
    public $state;
    public $zip;
    public $country;
    public $role;
    public $description;
    public $enable_booking;
    public $service_commission;
    public $commission_value;
    public $staff_select_according_service;
    public $schedule_type;
    public $ld_service_staff;
    public $staff_select_according_zipcode;
    public $image;
    public $booking_date_time;
    public $staff_value;
    public $staff_id;
    public $update_wallet_value;
    public $tablename="ld_admin_info";
    public $tablename_user="ld_users";
    public $conn;


    /*Function for Read Only one data matched with Id*/
    public function readone(){
        $query="select * from `".$this->tablename."` where `id`='".$this->id."'";
        $result=mysqli_query($this->conn,$query);
        $value=mysqli_fetch_array($result);
        return $value;
    }
    /*Function for Update service-Not Used in this*/
    public function update_profile(){
        $address = mysqli_real_escape_string($this->conn,$this->address);
        $query="update `".$this->tablename."` set `fullname`='".$this->fullname."'
		,email='".$this->email."'
        ,`phone`='".$this->phone."'
        ,`address`='".$address."'
        ,`city`='".$this->city."'
        ,`state`='".$this->state."'
        ,`zip`='".$this->zip."'
        ,`country`='".$this->country."',`password`='".$this->password."'
        where `id`='".$this->id."' ";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }


    public function forget_password(){
        $query = "SELECT `id` as `user_id` FROM `".$this->tablename."` where `email`='".$this->email."'";
        $result=mysqli_query($this->conn,$query);
        $res = mysqli_fetch_row($result);

        if(count($res) != 0 ){
            $_SESSION['fp_admin'] = "yes";
            return $res;
        }
        else
        {
            $query = "SELECT `id` as `user_id` FROM `".$this->tablename_user."` where `user_email`='".$this->email."'";
            $result=mysqli_query($this->conn,$query);
            $res = mysqli_fetch_row($result);
            $_SESSION['fp_user'] = "yes";
            return $res;
        }

    }
	
    public function update_password(){
        if(isset($_SESSION['fp_admin'])){
            $query = "update `".$this->tablename."`  set `password`='".md5($this->password)."'  where `id`='".$this->id."'";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }
        elseif(isset($_SESSION['fp_user'])){
            $query = "update `".$this->tablename_user."` set `user_pwd`='".md5($this->password)."'  where `id`='".$this->id."'";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }

    }
	 public function readone_adminname(){
		 $query="select * from `".$this->tablename."` LIMIT 1";
		 $result=mysqli_query($this->conn,$query);
		 $value=mysqli_fetch_row($result);
		 return $value;
	}

	/* Function for add staff */
	public function add_staff(){
		$query="insert into `".$this->tablename."` (`id`, `password`, `email`, `fullname`, `phone`, `address`, `city`, `state`, `zip`, `country`,`role`, `description`, `enable_booking`, `service_commission`, `commision_value`, `schedule_type`, `image`, `service_ids`) values(NULL,'".md5($this->pass)."','".$this->email."','".$this->fullname."','', '', '', '', '', '', '".$this->role."', '', 'N', 'F', '0', 'W', '', '')";
		$result=mysqli_query($this->conn,$query);	
		$value=mysqli_insert_id($this->conn);
		return $value;
	}
	
	/* Function for count staff */
	public function countall_staff(){
		$query="select count(`id`) as `c_sid` from `".$this->tablename."` where `role` = 'staff'";
		$result=mysqli_query($this->conn,$query);	
		$value = mysqli_fetch_array($result);
		return $value[0];
	}	
	
	/*  display all staff in staff page in admin pane  */
    public function readall_staff(){
        $query  = "select * from `".$this->tablename."` where `role` = 'staff'";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }
	/*  display all staff available for booking  */
    public function readall_staff_booking(){
        $query  = "select * from `".$this->tablename."` where `role` = 'staff' and `enable_booking` = 'Y'";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }

	/* staff details update*/
	public function update_staff_details(){
		 $query="update `".$this->tablename."` set `fullname`='".$this->fullname."'
		,`email`='".$this->email."'
		,`description`='".$this->description."'
		,`phone`='".$this->phone."'
        ,`address`='".$this->address."'
        ,`city`='".$this->city."'
        ,`state`='".$this->state."'
        ,`zip`='".$this->zip."'
        ,`country`='".$this->country."'
		,`enable_booking`='".$this->enable_booking."'
        ,`image`='".$this->image."'
        ,`service_ids`='".$this->ld_service_staff."'
		where `id`='".$this->id."' ";
		$result=mysqli_query($this->conn,$query);

        return $result;
	
	}
	
	/* delete staff */
	public function delete_staff(){
		$query = "delete from `".$this->tablename."` where `id` = '".$this->id."'";
		$result=mysqli_query($this->conn,$query);
	}
	
	/* Update image in staff page */	
	public function update_pic(){
		$query="update `".$this->tablename."` set `image`='' where `id`='".$this->id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	
	/*display staff service details  in staff page*/
	public function staff_service_details(){
		$query="SELECT `ld_bookings`.`id`,`ld_services`.`title`,`ld_bookings`.`staff_ids`, `ld_admin_info`.`fullname`,`ld_payments`.`amount`,  `ld_admin_info`.`service_commission`, `ld_admin_info`.`commision_value`,`ld_bookings`.`booking_pickup_date_time_start`
		FROM `ld_bookings`, `ld_payments`, `ld_admin_info`,`ld_services`
		WHERE `ld_bookings`.`order_id` = `ld_payments`.`order_id`
		AND `ld_bookings`.`staff_ids` = `ld_admin_info`.`id` and `ld_bookings`.`service_id`=`ld_services`.`id` and `ld_bookings`.`staff_ids`='".$this->id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
		
	}
	
	/*display staff service details  in staff page*/
	public function check_staff_email_existing(){
		$query="select count(`id`) as `c` from `".$this->tablename."` where `email`='".$this->email."'";
        $result=mysqli_query($this->conn,$query);
		$value = mysqli_fetch_array($result);
        return $value[0];
	}
	
	public function get_service_acc_provider()
    {
			
      $query = "select id from ld_admin_info where service_ids like '%" . $this->staff_select_according_service . "%'";
        
		$result = mysqli_query($this->conn, $query);
	    return $result;
    }
	
	public function get_search_staff_detail_byid($staff_id){
		$query = "SELECT `fullname`,`image` FROM `ld_admin_info` WHERE `id`='".$staff_id."'";
		$result = mysqli_query($this->conn, $query);
		$ress = mysqli_fetch_array($result); 
		return $ress;
    }
	
	public function update_password_api(){
		$query = "update `".$this->tablename."`  set `password`='".md5($this->password)."'  where `id`='".$this->id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* API Function */
	public function get_service_acc_provider_api()
	{
		$query = "select id,fullname from ld_admin_info where service_ids like '%" . $this->staff_select_according_service . "%'";
		$result = mysqli_query($this->conn, $query);
		return $result;
	}
    public function reg_staff(){
         $query="insert into `".$this->tablename."` (`id`, `password`, `email`, `fullname`, `phone`, `address`, `city`, `state`, `zip`, `country`,`role`, `description`, `enable_booking`, `service_commission`, `commision_value`, `schedule_type`, `image`, `service_ids`) values(NULL,'".md5($this->pass)."','".$this->email."','".$this->fullname."','', '', '', '', '', '', 'staff', '', 'N', 'F', '0', 'W', '', '')";
      
        $result=mysqli_query($this->conn,$query); 
        $value=mysqli_insert_id($this->conn);
        return $value;
      }
      public function get_zipcode_acc_provider(){
		$query = "select id from ld_admin_info where zip ='" . $this->staff_select_according_zipcode ."'";
			$result = mysqli_query($this->conn, $query);
			return $result;
		}

        public function get_staff_id_acc_datetime(){
            $query = "select staff_ids from ld_bookings where `booking_delivery_date_time_start` like '%" . $this->booking_date_time . "%' and `staff_ids`='".$this->staff_value."'";
            $result = mysqli_query($this->conn, $query);
            $rows = mysqli_num_rows($result);
            return $rows;
           }

           /* public function get_staff_reve($staff_id){
            $query="select `revenue_percentage` from `".$this->tablename."` WHERE `id`='".$staff_id."'";
            $result=mysqli_query($this->conn,$query);
            $value=mysqli_fetch_array($result);
            return $value= isset($value[0])? $value[0] : '' ;
          } */

          public function get_previous_staff_wallet(){
            $query="select `staff_wallet_amount`,`email`,`fullname` from `".$this->tablename."` where `id`='".$this->id."'";
            $result=mysqli_query($this->conn,$query);
            $value=mysqli_fetch_row($result);
            return $value;
          }
          public function update_staff_wallet(){
            $query = "update `".$this->tablename."`  set `staff_wallet_amount`='".$this->update_wallet_value."' where `id`='".$this->id."'";
            $result=mysqli_query($this->conn,$query);
            return $result;
          }
	
}