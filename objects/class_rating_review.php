<?php  

class laundry_rating_review {

    public $id;
	public $staff_id;
	public $order_id;
    public $rating;
    public $review;
    public $table_rating_review="ld_rating_review";
    public $conn;
	
	/* Add Rating In Table */
	public function add_rating(){
		$query = "INSERT INTO `".$this->table_rating_review."` (`id`,`staff_id`,`order_id`,`rating`,`review`) VALUES(NULL,'".$this->staff_id."','".$this->order_id."','".$this->rating."','".$this->review."')";
		$result = mysqli_query($this->conn,$query);
		$value = mysqli_insert_id($this->conn);	
		return $value;
	}

	/* select & check order_id in rating */
	public function select_one(){
        $query = "SELECT * FROM `".$this->table_rating_review."` WHERE `order_id`='".$this->order_id."'";
        $result = mysqli_query($this->conn,$query);
        $value = mysqli_num_rows($result);
        return $value;
    }
	
	/*Readone by order id*/
    public function readone_order(){
        $query = "SELECT * FROM `".$this->table_rating_review."` WHERE `order_id`='".$this->order_id."'";
        $result = mysqli_query($this->conn,$query);
        $value = mysqli_fetch_assoc($result);
        return $value;
    }
	
	/*Readone by order id*/
    public function readall_by_staff_id(){
        $query = "SELECT * FROM `".$this->table_rating_review."` WHERE `staff_id`='".$this->staff_id."'";
        $result = mysqli_query($this->conn,$query);
        return $result;
    }
}   
?>