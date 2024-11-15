<?php  
class laundry_dummy{
	public $ld_timezone;
	public $s_title;
	public $s_description;
	public $s_color;
	public $s_image;
	public $s_status;
	public $s_position;
	public $s_limit;
	public $conn;
	public $services="ld_services";
	
	public $smu_units_title;
	public $smu_base_price;
	public $smu_minlimit;
	public $smu_maxlimit;
	public $smu_status;
	public $smu_unit_symbol;
	public $smu_image;
	public $smu_predefine_image;
  public $service_methods_units="ld_service_units";
	
	public $wda_week_id;
	public $wda_weekday_id;
	public $wda_day_start_time;
	public $wda_day_end_time;
	public $wda_off_days;
  public $week_days_available="ld_week_days_available";
    
	public $od_lastmodify;
	public $od_off_date;
	public $off_days="ld_off_days";
	
	public $u_user_pwd;
	public $u_first_name;
	public $u_last_name;
	public $u_user_email;
	public $u_phone;
	public $u_address;
	public $u_zip;
	public $u_city;
	public $u_state;
	public $u_notes;
	public $u_status;
	public $u_usertype;
	public $u_contact_status;
	public $users="ld_users";
	
	public $b_order_id;
	public $b_client_id;
	public $b_order_date;
	public $b_booking_delivery_date_time_start;
	public $b_booking_delivery_date_time_end;
	public $b_booking_pickup_date_time_start;
	public $b_booking_pickup_date_time_end;
	public $b_show_delivery_date;
	public $b_self_service;
	public $b_service_id;
	public $b_booking_status;
	public $b_lastmodify;
	public $b_read_status;
	public $bookings="ld_bookings";
	
	public $bu_service_id;
	public $bu_unit_id;
	public $bu_unit_name;
	public $bu_unit_qty;
	public $bu_unit_rate;
	public $booking_units="ld_booking_units";
	
	public $p_order_id;
	public $p_payment_method;
	public $p_transaction_id;
	public $p_amount;
	public $p_discount;
	public $p_taxes;
	public $p_partial_amount;
	public $p_payment_date;
	public $p_lastmodify;
	public $p_net_amount;
	public $payments="ld_payments";
	
	public $oci_order_id;
	public $oci_client_name;
	public $oci_client_email;
	public $oci_client_phone;
	public $oci_client_personal_info;
	public $bu_order_id;
	public $order_client_info="ld_order_client_info";
	
	public $ld_remove_data_array;
	
	public $tablename="ld_services";
	public $table_name_smu="ld_service_units";
	
	public $a_r_id;
	public $a_r_service_id;
	public $a_r_service_unit_id;
	public $a_r_price = 0;
	public $article_status = 'E';
	public $table_unit_price="ld_service_units_price";
	
	public function __construct() {
		$this->ld_timezone = "America/Los_Angeles";
	}
	public function add_service(){
		$query="insert into `".$this->services."` (`id`,`title`,`description`,`color`,`image`,`status`,`position`,`service_limit`) values(NULL,'".$this->s_title."','".$this->s_description."','".$this->s_color."','".$this->s_image."','".$this->s_status."','".$this->s_position."','".$this->s_limit."')";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_insert_id($this->conn);
		return $value;
	}

	
	public function add_services_method_unit(){
		$query="insert into `".$this->service_methods_units."` (`id`,`units_title`,`base_price`,`minlimit`,`maxlimit`,`status`, `position`,`unit_symbol`,`image`,`predefine_image`) values(NULL,'".$this->smu_units_title."','".$this->smu_base_price."','".$this->smu_minlimit."','".$this->smu_maxlimit."','".$this->smu_status."', '0','".$this->smu_unit_symbol."','".$this->smu_image."','".$this->smu_predefine_image."')";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_insert_id($this->conn);
		return $value;
	}
	
	public function add_services_article_price(){
		$query="insert into `".$this->table_unit_price."` (`id`,`service_id`,`service_unit_id`,`price`,`article_status`) values(NULL,'".$this->a_r_service_id."','".$this->a_r_service_unit_id."','".$this->a_r_price."','".$this->article_status."')";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_insert_id($this->conn);
		return $value;
	}
	
	public function add_week_days_available(){
		$query="insert into `".$this->week_days_available."` (`id`,`provider_id`,`week_id`,`weekday_id`,`day_start_time`,`day_end_time`,`off_day`,`provider_schedule_type`) values(NULL,'1','".$this->wda_week_id."','".$this->wda_weekday_id."','".$this->wda_day_start_time."','".$this->wda_day_end_time."','".$this->wda_off_days."','weekly')";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_insert_id($this->conn);
		return $value;
	}
	
	public function add_off_days(){
		$query="insert into `".$this->off_days."` (`id`,`user_id`,`off_date`,`lastmodify`,`status`) values(NULL,'1','".$this->od_off_date."','".$this->od_lastmodify."','0')";
		$result=mysqli_query($this->conn,$query);		
		$value=mysqli_insert_id($this->conn);
		return $value;
	}
	
	public function add_users(){
		$query="insert into `".$this->users."` (`id`,`user_email`,`user_pwd`,`first_name`,`last_name`,`phone`,`zip`,`address`,`city`,`state`,`notes`,`contact_status`,`status`,`usertype`) values(NULL,'".$this->u_user_email."','".$this->u_user_pwd."','".$this->u_first_name."','".$this->u_last_name."','".$this->u_phone."','".$this->u_zip."','".$this->u_address."','".$this->u_city."','".$this->u_state."','".$this->u_notes."','".$this->u_contact_status."','".$this->u_status."','".$this->u_usertype."')";
		$result=mysqli_query($this->conn,$query);	
		$value=mysqli_insert_id($this->conn);
		return $value;
	}
	
	public function add_bookings(){
		$query="insert into `".$this->bookings."` (`id`,`order_id`,`client_id`,`order_date`,`booking_delivery_date_time_start`,`booking_delivery_date_time_end`,`booking_pickup_date_time_start`,`booking_pickup_date_time_end`,`service_id`,`booking_status`,`reject_reason`,`reminder_status`,`lastmodify`,`read_status`,`staff_ids`, `gc_event_id`,`gc_staff_event_id`,`show_delivery_date`,`self_service`) values(NULL,'".$this->b_order_id."','".$this->b_client_id."','".$this->b_order_date."','".$this->b_booking_delivery_date_time_start."','".$this->b_booking_delivery_date_time_end."','".$this->b_booking_pickup_date_time_start."','".$this->b_booking_pickup_date_time_end."','".$this->b_service_id."','".$this->b_booking_status."','','0','".$this->b_lastmodify."','".$this->b_read_status."','','','','".$this->b_show_delivery_date."','".$this->b_self_service."')";
		$result=mysqli_query($this->conn,$query); 
		$value=mysqli_insert_id($this->conn);	
		return $value;
	}
	
	public function add_booking_units(){
		$query="insert into `".$this->booking_units."` (`id`,`order_id`,`service_id`,`unit_id`,`unit_name`,`unit_qty`,`unit_rate`) values(NULL,'".$this->bu_order_id."','".$this->bu_service_id."','".$this->bu_unit_id."','".$this->bu_unit_name."','".$this->bu_unit_qty."','".$this->bu_unit_rate."')";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_insert_id($this->conn);	
		return $value;
	}
	
	public function add_payments(){
		$query="insert into `".$this->payments."` (`id`,`order_id`,`payment_method`,`transaction_id`,`amount`,`discount`,`taxes`,`partial_amount`,`payment_date`,`net_amount`,`lastmodify`,`payment_status`) values(NULL,'".$this->p_order_id."','".$this->p_payment_method."','".$this->p_transaction_id."','".$this->p_amount."','".$this->p_discount."','".$this->p_taxes."','".$this->p_partial_amount."','".$this->p_payment_date."','".$this->p_net_amount."','".$this->p_lastmodify."','Pending')";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_insert_id($this->conn);
		return $value;
	}
	
	public function add_order_client_info(){
		$query="insert into `".$this->order_client_info."` (`id`,`order_id`,`client_name`,`client_email`,`client_phone`,`client_personal_info`) values(NULL,'".$this->oci_order_id."','".$this->oci_client_name."','".$this->oci_client_email."','".$this->oci_client_phone."','".$this->oci_client_personal_info."')";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_insert_id($this->conn);
		return $value;

	}
	
	public function add_settings(){
		
		$qryupdate_sample_data = "update `ld_settings` set `option_value` = 'Y' where `option_name`='ld_sample_data_status'";        
		$qryupdate_remove_sample_data = "update `ld_settings` set `option_value` = '".$this->ld_remove_data_array."' where `option_name`='ld_remove_data_array'";
		
		$check_for_tax_vat_value_query = "SELECT * FROM `ld_settings` WHERE `option_name` = 'ld_tax_vat_value' and `option_value`<>''";
		$check_for_tax_vat_value = mysqli_query($this->conn, $check_for_tax_vat_value_query);
		$vat_value_check = mysqli_fetch_row($check_for_tax_vat_value);
		
		$check_for_tax_vat_type_query = "SELECT * FROM `ld_settings` WHERE `option_name` = 'ld_tax_vat_type' and `option_value`<>''";
		$check_for_tax_vat_type = mysqli_query($this->conn, $check_for_tax_vat_type_query);
		$vat_type_check = mysqli_fetch_row($check_for_tax_vat_type);
		
		if($vat_value_check[2] == '' || $vat_type_check == ''){
			$qryupdate_tax_vat_status = "update `ld_settings` set `option_value` = 'Y' where `option_name`='ld_tax_vat_status'";
			$qryupdate_tax_vat_value = "update `ld_settings` set `option_value` = '10' where `option_name`='ld_tax_vat_value'";
			$qryupdate_tax_vat_type = "update `ld_settings` set `option_value` = 'F' where `option_name`='ld_tax_vat_type'";
			mysqli_query($this->conn,$qryupdate_tax_vat_status);
			mysqli_query($this->conn,$qryupdate_tax_vat_value);
			mysqli_query($this->conn,$qryupdate_tax_vat_type);
		}
		
		mysqli_query($this->conn,$qryupdate_sample_data);  
		mysqli_query($this->conn,$qryupdate_remove_sample_data);
	}
	
	public function get_all_bookings_byserviceid($id){
        $query="select `order_id`, `gc_event_id`, `gc_staff_event_id`, `staff_ids` from `".$this->bookings."` where `service_id` = '".$id."' GROUP BY `id`, `order_id`, `client_id`, `order_date`, `booking_delivery_date_time_start`, `booking_delivery_date_time_end`, `booking_pickup_date_time_start`, `booking_pickup_date_time_end`, `service_id`, `booking_status`, `reject_reason`, `reminder_status`, `lastmodify`, `read_status`, `staff_ids`, `gc_event_id`, `gc_staff_event_id`";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }
		
		/* DELETE QUERY */
		
		/* delete all method unit*/
		public function delete_service_unit($serivce_unit){
			$query="delete from `".$this->table_name_smu."` where `id`='$serivce_unit'";
			mysqli_query($this->conn,$query);
			
			$query="delete from `".$this->table_unit_price."` where `service_unit_id`='$serivce_unit'";
			mysqli_query($this->conn,$query);
		}
		
		/* delete all method*/
		
		/*Function for Delete service*/
		public function delete_service($id){
			$query="delete from `".$this->tablename."` where `id`=$id";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		
	public function delete_all(){
        $qryy = "update `ld_settings` set `option_value` = 'N' where `option_name`='ld_sample_data_status'";
        mysqli_query($this->conn,$qryy);

        $q2 = "select `option_value` from `ld_settings` where `option_name` = 'ld_remove_data_array'";
        $reslt=mysqli_query($this->conn,$q2);
        $val = mysqli_fetch_array($reslt);
        $id = explode(',',$val[0]);
				
				

        /* delete dummy services */
		for($i=0;$i<=3;$i++){		
			$this->delete_service($id[$i]);
	
			/* get all bookings with above service id */
			$booking_with_service_id = $this->get_all_bookings_byserviceid($id[$i]);
			while($bsi = mysqli_fetch_array($booking_with_service_id)){
				$query13="delete from `ld_bookings` where `order_id` = ".$bsi['order_id'];
				$query14="delete from `ld_booking_units` where `order_id` = ".$bsi['order_id'];
				$query15="delete from `ld_payments` where `order_id` = ".$bsi['order_id'];
				$query16="delete from `ld_order_client_info` where `order_id` = ".$bsi['order_id'];
				mysqli_query($this->conn,$query13);
				mysqli_query($this->conn,$query14);
				mysqli_query($this->conn,$query15);
				mysqli_query($this->conn,$query16);
			}
		}
		
		for($i=9;$i<=14;$i++){		
			$this->delete_service_unit($id[$i]);
		}
		
		/* Delete the sample data user johndoe@example.com */
		$delete_user_sample = "delete from `ld_users` where `user_email` = 'johndoe@example.com'";
		mysqli_query($this->conn,$delete_user_sample);
		
	 /* delete offday */
		$query11="delete from `ld_off_days` where `id` = ".$id[4];
		$query12="delete from `ld_users` where `id` = ".$id[5];
		mysqli_query($this->conn,$query11);
		mysqli_query($this->conn,$query12);

		$qry = "update `ld_settings` set `option_value` = '' where `option_name`='ld_remove_data_array'";
		mysqli_query($this->conn,$qry);
	}
}
?>