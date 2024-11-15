<?php  

class laundry_services_methods_units{
		public $conn;
		public $id;
		public $units_id;
		public $methods_id;
		public $units_title;
		public $base_price = 0;
		public $position;
		public $minlimit = 1;
		public $maxlimit;
		public $image;
		public $predefine_image;
		public $unit_symbol;
		public $status;
		public $table_name="ld_service_units";
		public $service_id;
		public $service_unit_id;
		public $price = 0;
		public $services_id;
		public $table_unit_price="ld_service_units_price";
		/*Function for Add service*/
		public function add_services_method_unit(){
			$query="insert into `".$this->table_name."` (`id`,`units_title`,`base_price`,`minlimit`,`maxlimit`,`status`,`position`)
 values(NULL,'".$this->units_title."','".$this->base_price."','".$this->minlimit."','".$this->maxlimit."','".$this->status."','0')";
			$result=mysqli_query($this->conn,$query);
			$value=mysqli_insert_id($this->conn);
		    return $value;
		}
		public function add_services_method_unit_price(){
			$query="insert into `".$this->table_unit_price."` (`id`,`service_id`,`service_unit_id`,`price`) values(NULL,'".$this->service_id."','".$this->service_unit_id."','".$this->price."')";
			$result=mysqli_query($this->conn,$query);
			$value=mysqli_insert_id($this->conn);
		    return $value;
		}
		/*Function for Update service-Not Used in this*/
		public function update_services_method_unit(){
			$query="update `".$this->table_name."` set  `units_title`='".$this->units_title."',`base_price`='".$this->base_price."',`minlimit`='".$this->minlimit."',`maxlimit`='".$this->maxlimit."',`image`='".$this->image."',`predefine_image`='".$this->predefine_image."' where `id`=".$this->id;
			$result=mysqli_query($this->conn,$query);
			return $result;
    }
		/*Function for Delete service*/
		public function delete_services_method_unit(){
			$query="delete from `".$this->table_name."` where `id`='".$this->id."' ";
			$result=mysqli_query($this->conn,$query);
			
			$query="delete from `".$this->table_unit_price."` where `service_unit_id`='".$this->id."' ";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		public function get_price_of_article(){

		$query = "SELECT `price`,`article_status` from `".$this->table_unit_price."` where `service_unit_id`='".$this->service_unit_id."' AND `service_id`='".$this->service_id."'";
			$result=mysqli_query($this->conn,$query);
			
			return $result;
		}
		public function update_article_price(){
			$query="update `".$this->table_unit_price."` set `price`='".$this->price."' where `service_unit_id`='".$this->service_unit_id."' AND `service_id`='".$this->service_id."'";
			$result=mysqli_query($this->conn,$query);
			return $result;
    }
        /*Function to update the status of  services */
        public function  changestatus()
        {
            $query="update `".$this->table_name."` set `status`='".$this->status."' where `id`='".$this->id."' ";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }
		public function  change_articel_status_according_service()
        {
            $query="update `".$this->table_unit_price."` set `article_status`='".$this->status."' where `service_id`='".$this->service_id."' and `service_unit_id`= '".$this->id."'";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }
        /* Admin panel methods */
        /*Function for Read All data from table by service */
        public function get_all_units(){
            $query="select * from `".$this->table_name."` ORDER BY `ld_service_units`.`position` ASC";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }
				
		  	
		/* public function get_article_status_according_service(){
            $query="select * from `".$this->table_unit_price."` where `service_id`='".$this->service_id."'";
            $result=mysqli_query($this->conn,$query);
            return $result;
        } */
		
				
				/*Function for count All data from table by service*/
        public function count_units_by_service_methods(){
            $query="select count(*) from `".$this->table_name."`";
            $result=mysqli_query($this->conn,$query);
            $unit_count=mysqli_fetch_array($result);
            return $unit_count;
        }
				
        /* FUNRCTION FOR SET FRONT DESIGN */
       /*  public function get_units_for_front(){
        $query="select * from `".$this->table_unit_price."` where `article_status` = 'E' and `service_id`='".$this->service_id."'";
            $result=mysqli_query($this->conn,$query);
            return $result;
        } */ 
		public function get_units_for_front(){
       $query="SELECT `lsu`.`id`,`lsu`.`units_title`,`lsu`.`minlimit`,`lsu`.`maxlimit`,`lsu`.`unit_symbol`,`lsu`.`image`,`lsu`.`predefine_image`,`lsup`.`price`,`lsu`.`position` FROM `ld_services` as `ls`,`ld_service_units` as `lsu`,`ld_service_units_price` as `lsup` where `ls`.`id` = `lsup`.`service_id` AND `lsu`.`id` = `lsup`.`service_unit_id` AND `lsup`.`service_id`='".$this->service_id."' AND `lsup`.`article_status` = 'E' ORDER BY `position` ASC";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }
    
   
    /* Check for the bookings of the services */
    public function method_unit_isin_use($id)
    {
        $query = "select * from `ld_bookings` where `ld_bookings`.`service_id` = $id and `ld_bookings`.`booking_pickup_date_time_start` >= CURDATE() LIMIT 1";
        $result=mysqli_query($this->conn,$query);
        $value=mysqli_fetch_row($result);
        return $value= isset($value[0])? $value[0] : '' ;
    }
	/* check for the entry of the same title */
	public function check_same_title(){
		$query = "select * from `".$this->table_name."` where `units_title`='".ucwords($this->units_title)."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	public function readone(){
		$query="select * from `ld_service_units` where `id`='".$this->units_id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_assoc($result);
		return $value;
	}
	/*  function to update the position of the services_units*/
	public function updateposition(){
		$query="update `".$this->table_name."` set `position`='".$this->position."' where `id`='".$this->id."' ";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	/*  function for read half section */
	public function get_half_section(){
		$query="SELECT `half_section` FROM `".$this->table_name."` WHERE `id`='".$this->units_id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_assoc($result);
		return $value['half_section'];
	}
	
	/*  TO GET ALL IMAGES NAMES FROM SERVICE,ADDONS TABLE FOR DELETING NOT USED IN DIRECTORY */
	public function get_used_images(){
		$query = "select `u`.`image` as `image` from `ld_service_units` as `u` UNION select `s`.`image` as `serimage` from `ld_services` as `s`	UNION	select `setim`.`option_value` as `setimage` from `ld_settings` as `setim` where `option_name` = 'ld_company_logo'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/*Get Image of Units for Cart in POS*/
	public function get_image_of_units(){
			$query= "select predefine_image,image from `".$this->table_name."` where `id`='".$this->service_unit_id."'";
			$result=mysqli_query($this->conn,$query);
			$unit_count=mysqli_fetch_array($result);
			return $unit_count;
  }
			
}
?>