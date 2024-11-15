<?php  

class laundry_email_template{
		public $id;
		public $email_subject;
		public $email_message;
		public $default_message;
		public $email_template_status;
		public $email_template_type;
		public $user_type;
		public $conn;
		public $ld_email_templates="ld_email_templates";
		
		/* 
		* Function for Read All client_email_template
		*
		*/
		
		public function readall_client_email_template(){
			$query="select * from `".$this->ld_email_templates."` where `user_type` = 'C'";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		
		/* 
		* Function for Read All admin_email_template
		*
		*/
		
		public function readall_admin_email_template(){
			$query="select * from `".$this->ld_email_templates."` where `user_type` = 'A'";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		/* 
		* Function for Read All staff_email_template
		*
		*/
		
		public function readall_staff_email_template(){
			$query="select * from `".$this->ld_email_templates."` where `user_type` = 'S'";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		
		
		
		/* 
		* Function for Read one client_email_template
		*
		*/
		
		public function readone_client_email_template(){
			$query="select * from `".$this->ld_email_templates."` where `user_type` = 'C' and `email_template_type` = '".$this->email_template_type."'";
			$result=mysqli_query($this->conn,$query);
			$value=mysqli_fetch_array($result);
			return $value;
		}
		
		/* 
		* Function for Read one admin_email_template
		*
		*/
		
		public function readone_admin_email_template(){
			$query="select * from `".$this->ld_email_templates."` where `user_type` = 'A' and `email_template_type` = '".$this->email_template_type."'";
			$result=mysqli_query($this->conn,$query);
			$value=mysqli_fetch_array($result);
			return $value;
		}
		
		/* 
		* Function for Read one staff_email_template
		*
		*/
		
		public function readone_staff_email_template(){
			$query="select * from `".$this->ld_email_templates."` where `user_type` = 'S' and `email_template_type` = '".$this->email_template_type."'";
			$result=mysqli_query($this->conn,$query);
			$value=mysqli_fetch_array($result);
			return $value;
		}
		
		/* 
		* Function for update email_template
		*
		*/
		
		public function update_email_template(){
			 $query="update `".$this->ld_email_templates."` set `email_message`='".$this->email_message."' where `id` = ".$this->id;
			
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		
		/* 
		* Function for update email_template_status
		*
		*/
		
		public function update_email_template_status(){
			$query="update `".$this->ld_email_templates."` set `email_template_status`='".$this->email_template_status."' where `id` = '".$this->id."'";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
        /*
        * Function for get_default_email_template content
        *
        */
        public function get_default_email_template(){
            $query="select `default_message` from `".$this->ld_email_templates."` where `id` = '".$this->id."'";
            $result=mysqli_query($this->conn,$query);
            $value=mysqli_fetch_array($result);
            return $value[0];
        }
    /* Get Email Template Details */
    public function readone_client_email_template_body(){
        $query="select * from `".$this->ld_email_templates."` where `user_type` = '".$this->user_type."' and `email_subject` = '".$this->email_subject."' limit 0,1";
        $result=mysqli_query($this->conn,$query);
        $value=mysqli_fetch_row($result);
        return $value;
    }
	}
?>