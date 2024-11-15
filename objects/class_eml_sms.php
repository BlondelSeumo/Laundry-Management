<?php  
class eml_sms{
	public $conn;
	public $eml_sms_id;
	public $cus_ids;
	public $cus_from;
	public $cus_to;
	public $cus_sub;
	public $cus_msg;
	public $cus_img;
	public $cus_dtfmt;
	public $tableeml="ld_email_user";
	public $tablesms="ld_sms_user";

	public function ins_eml_data(){
		$query="INSERT into `".$this->tableeml."` (`id`,`cus_ids`,`cus_sub`,`cus_msg`,`cus_img`,`cus_dt`) VALUES(null,'".$this->cus_ids."','".$this->cus_sub."','".$this->cus_msg."','".$this->cus_img."','".$this->cus_dtfmt."')";
		$result=mysqli_query($this->conn,$query);
    	return $result;
	}

	public function ins_sms_data(){
		$query="INSERT into `".$this->tablesms."` (`id`,`cus_ids`,`cus_msg`,`cus_dt`) VALUES(null,'".$this->cus_ids."','".$this->cus_msg."','".$this->cus_dtfmt."')";
		$result=mysqli_query($this->conn,$query);
    	return $result;
	}
	
	public function sel_eml_data(){
		$query="select * from `".$this->tableeml."` order by `id` desc";
		$result=mysqli_query($this->conn,$query);
    	return $result;
	}
	
	public function sel_sms_data(){
		$query="select * from `".$this->tablesms."` order by `id` desc";
		$result=mysqli_query($this->conn,$query);
    	return $result;
	}
	
	public function eml_read_one(){
		$query="select * from `".$this->tableeml."` where `id`='".$this->eml_sms_id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_row($result);
    	return $value;
	}
	
	public function sms_read_one(){
		$query="select * from `".$this->tablesms."` where `id`='".$this->eml_sms_id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_row($result);
    	return $value;
	}
}
?>