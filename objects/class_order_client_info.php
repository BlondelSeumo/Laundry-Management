<?php

class laundry_order_client_info
{
	public $order_client_info_id;
	public $order_id;
	public $order_id1;
	public $client_id;
	public $client_name;
	public $client_email;
	public $client_phone;
	public $client_personal_info;
	public $order_duration = 0;
	public $user_id;
	public $service_id;
	public $conn;
	public $table_name = "ld_order_client_info";
	public $tablename3 = "ld_users";

	/* 
	* Function for add Order Client 
	*
	*/

	public function add_order_client()
	{
		$query = "insert into `" . $this->table_name . "` (`id`,`order_id`,`client_name`,`client_email`,`client_phone`,`client_personal_info`) values(NULL,'" . $this->order_id . "','" . $this->client_name . "','" . $this->client_email . "','" . $this->client_phone . "','" . $this->client_personal_info . "')";
		$result = mysqli_query($this->conn, $query);
		return $result;
	}
	public function readone_for_email()
	{
		$query = "select `email`,`fullname` from `ld_admin_info`";
		$result = mysqli_query($this->conn, $query);
		$value = mysqli_fetch_array($result);
		return $value;
	}
	public function readone_order_client()
	{
		$query = "select * from " . $this->table_name . " WHERE order_id = '" . $this->order_id . "'";
		$result = mysqli_query($this->conn, $query);
		$value = mysqli_fetch_array($result);
		return $value;
	}
}
?>