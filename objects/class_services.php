<?php  

class laundry_services{
		
		public $id;
		public $title;
		public $description;
		public $color;
		public $image;
		public $status;
		public $position;
		public $service_limit;
		public $services_id;
		public $tablename="ld_services";
    	public $table_name="ld_setting_design";
		public $table_name_sm="ld_services_method";
		public $table_name_smu="ld_service_methods_units";
		public $table_name_smur="ld_services_methods_units_rate";
		public $table_name_smd="ld_service_methods_design";
		public $table_name_bk="ld_bookings";
		public $table_name_unit_price="ld_service_units_price";
		
        public $conn;
		/* Function for Add service*/
		public function add_service(){
		$query="insert into `".$this->tablename."` (`id`,`title`,`description`,`color`,`image`,`status`,`position`,`service_limit`) values(NULL,'".$this->title."','".$this->description."','".$this->color."','".$this->image."','".$this->status."','".$this->position."','".$this->service_limit."')";
            $result=mysqli_query($this->conn,$query);
			$value=mysqli_insert_id($this->conn);
			return $value;
		}
		/* Function for Update service-Not Used in this*/
		public function update_service(){
			$query="update `".$this->tablename."` set `title`='".$this->title."',`description`='".$this->description."',`image`='".$this->image."',`color`='".$this->color."',`service_limit`='".$this->service_limit."' where `id`='".$this->id."' ";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		
		/* Function for Delete service*/
		public function delete_service(){
			$query="delete from `".$this->tablename."` where `id`='".$this->id."' ";
			$result=mysqli_query($this->conn,$query);
			
			$query="delete from `".$this->table_name_unit_price."` where `service_id`='".$this->id."' ";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		
		/* function to get all methods if exist with the service id*/
        public function get_exist_methods_by_serviceid($id){
            $query="select `ld_services_method`.* from `ld_services`,`ld_services_method` where `ld_services`.`id` = `ld_services_method`.`service_id` and `ld_services`.`id` = $id";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }
		
		/* function to get all methods_unit if exist with the service id*/
        public function get_exist_methods_units_by_methodid($id){
			$query = "SELECT * FROM `ld_service_methods_units` where `methods_id` = $id";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }
		
		/* function to get all methods_unit if exist with the service id*/
        public function get_exist_methods_units_rate_by_unitid($id){
			$query = "SELECT * FROM `ld_services_methods_units_rate` WHERE `units_id`=$id";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }
		
		/*  delete all method unit rate */
		public function delete_service_method_unit_rate($method_unit_rate_id){
			$query="delete from `".$this->table_name_smur."` where `id`=$method_unit_rate_id";
			mysqli_query($this->conn,$query);
		}
		
		/*  delete all method unit */
		public function delete_method_unit($method_unit){
			$query="delete from `".$this->table_name_smu."` where `id`=$method_unit";
			mysqli_query($this->conn,$query);
		}
		
		/*  delete all method */
		public function delete_method($methodid){
			$query="delete from `".$this->table_name_sm."` where `id`=$methodid";
			mysqli_query($this->conn,$query);
			
			$query="delete from `".$this->table_name_smd."` where `service_methods_id`=$methodid";
			mysqli_query($this->conn,$query);
			
		}	
		
		
		/*  NEWLY ADDED */
		/* Function for Read All data from table */
		public function readall(){
			$query="select `ld_services`.* from `ld_services`, `ld_services_method`, `ld_service_methods_units` where `ld_services`.`status` = 'E' and `ld_services_method`.`status` = 'E' and `ld_service_methods_units`.`status` = 'E' and `ld_services_method`.`service_id` = `ld_services`.`id` and `ld_service_methods_units`.`services_id` = `ld_services`.`id` group by `ld_services`.`id`, `ld_services`.`title`, `ld_services`.`description`, `ld_services`.`color`, `ld_services`.`image`, `ld_services`.`status`, `ld_services`.`position` ORDER BY `ld_services`.`position`";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		/* Function for Read Only one data matched with Id*/
		public function readone(){
			$query="select * from `".$this->tablename."` where `id`='".$this->id."'";
			$result=mysqli_query($this->conn,$query);
			$value=mysqli_fetch_array($result);
			return $value;
		}
       
        /* Function to fetch all data in admin panel*/
        public function getalldata()
        {
					$query="select * from `".$this->tablename."` order by `position`";
					$result=mysqli_query($this->conn,$query);
					return $result;
        }
        /*  function to update the position of the services*/
        public function updateposition(){
            $query="update `".$this->tablename."` set `position`='".$this->position."' where `id`='".$this->id."' ";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }
        /* Function to update the status of  services */
        public function  changestatus()
        {
            $query="update `".$this->tablename."` set `status`='".$this->status."' where `id`='".$this->id."' ";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }
        /* function to count total no of services */
        public function countallservice()
        {
            $query="select count(*) as `c` from `".$this->tablename."`";
            $result=mysqli_query($this->conn,$query);
			if($result){
            $value=mysqli_fetch_row($result);
			  return $value= isset($value[0])? $value[0] : '' ;
			} else 
			{ return false; }
            
        }
        /*  to get design type to show in front end */
/*         public function get_setting_design($title){
            $this->title=$title;
            $query="select `design` from `".$this->table_name."` where `title`='".$this->title."'";
            $result=mysqli_query($this->conn,$query);
            
			
			if($result){
            $value=mysqli_fetch_row($result);
			  return $value= isset($value[0])? $value[0] : '' ;
			} 
			else 
			{ return false; }
        } */
        /*  get last inserted record */
        public function getlast_record_insert()
        {
            $query = "select MAX(`id`) from `ld_services`";
            $result=mysqli_query($this->conn,$query);
            $value=mysqli_fetch_row($result);
            return $value= isset($value[0])? $value[0] : '' ;
        }
        /*  update record to insert image name in the inserted record */
        public function update_recordfor_image($insertedid)
        {
            $query="update `".$this->tablename."` set `image`='".$this->image."' where `id`='".$insertedid."' ";
            $result=mysqli_query($this->conn,$query);
            return $result;
        }
        /*  Check for the bookings of the services */
        public function service_isin_use($id)
        {
            $query = "select * from `ld_booking_units` where `ld_booking_units`.`service_id` = $id  LIMIT 1";
            $result=mysqli_query($this->conn,$query);
            $value=mysqli_fetch_row($result);
            return $value= isset($value[0])? $value[0] : '' ;
        }
    /* Update Image in services*/
    public function update_image(){
        $query="update `".$this->tablename."` set `image`='".$this->image."' where `id`='".$this->id."'";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }
    /* Function for get service name for confirm booking mail in frontend*/
    public function get_service_name_for_mail(){
        $query="select `title` from `ld_services` where `id`='".$this->id."'";
        $result=mysqli_query($this->conn,$query);
        $value=mysqli_fetch_row($result);
        return $value= isset($value[0])? $value[0] : '' ;
    }
    /*  check for the entry of the same title */
    public function check_same_title(){
        $query = "select * from `ld_services` where `title`='".ucwords($this->title)."'";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }
    /*  TO GET ALL IMAGES NAMES FROM SERVICE,ADDONS TABLE FOR DELETING NOT USED IN DIRECTORY */
    public function get_used_images(){
        $query = "select `s`.`image` as `image` from `ld_services` as `s`
UNION select `u`.`image` as `unitimage` from `ld_service_units` as `u`
UNION
select `setim`.`option_value` as `setimage` from `ld_settings` as `setim` where `option_name` = 'ld_company_logo'";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }
	/*  TO GET ALL IMAGES NAMES FROM SERVICE,ADDONS TABLE FOR DELETING NOT USED IN DIRECTORY */
    public function get_used_staff_images(){
        $query = "select `image` as `image` from `ld_admin_info` where `role`='staff'";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }
	public function readall_for_frontend_services(){
		
		$query="(select `ld_services`.* from `ld_services`, `ld_service_units` where `ld_services`.`status` = 'E' and ((`ld_service_units`.`status` = 'E')) group by `ld_services`.`id`, `ld_services`.`title`, `ld_services`.`description`, `ld_services`.`color`, `ld_services`.`image`, `ld_services`.`status`, `ld_services`.`position` ORDER BY `position`) UNION (select `ld_services`.* from `ld_services` where `ld_services`.`status` = 'E' group by `ld_services`.`id`, `ld_services`.`title`, `ld_services`.`description`, `ld_services`.`color`, `ld_services`.`image`, `ld_services`.`status`, `ld_services`.`position`) ORDER BY `position`";
		
		$result=mysqli_query($this->conn,$query);
		return $result;
 }
 
 	public function get_count_service(){
		$query = "SELECT COUNT(service_id) AS service_count FROM `".$this->table_name_bk."` where `order_date` = CURDATE() and `service_id` ='".$this->services_id."'";
		$result=mysqli_query($this->conn,$query);
		$value = mysqli_fetch_assoc($result);
		return $value["service_count"];
	}
	
	public function get_count_service_limit(){
		$query = "select `service_limit` from `".$this->tablename."` where `id` ='".$this->services_id."'";
		$result=mysqli_query($this->conn,$query);
		$value = mysqli_fetch_assoc($result);
		return $value["service_limit"];
	}
	
}
?>