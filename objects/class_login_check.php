<?php  

class laundry_login_check{
    public $conn;
    public $remember;
    public $cookie_passwords;
    /* check the admin */
    public function checkadmin($name,$password){
         $query = "select * from `ld_admin_info` where `email` = '".$name."' and `password` = '".$password."' and `enable_booking` = 'Y' ";
       
        $result=mysqli_query($this->conn,$query);
        $value=mysqli_fetch_array($result);
        if($value){
            if($value['role']=="admin"){
				$_SESSION['ld_adminid'] = $value['id'];
				$_SESSION['ld_useremail'] = $value['email'];
			}else{

				$_SESSION['ld_staffid'] = $value['id'];
				$_SESSION['ld_useremail'] = $value['email'];				
			}
			
                if($this->remember == "true"){
                    setcookie('laundry_username',$name, time() + (86400 * 30), "/");
                    setcookie('laundry_password',$this->cookie_passwords, time() + (86400 * 30), "/");
                    setcookie('laundry_remember',"checked", time() + (86400 * 30), "/");
                }
                else{
                    unset($_COOKIE['laundry_username']);
                    unset($_COOKIE['laundry_password']);
                    unset($_COOKIE['laundry_remember']);
                    /* setcookie('laundry_username',null, -1, '/');
                    setcookie('laundry_password',null, -1, '/');
                    setcookie('laundry_remember',null, -1, '/'); */
                }
            echo filter_var("yesadmin");
        }else{
            $query = "select * from `ld_users` where `user_email` = '".$name."' and `user_pwd` = '".$password."'";
          
            $result=mysqli_query($this->conn,$query);
            $value=mysqli_fetch_assoc($result);
            if(isset($value['id']) && $value['id']!=0){
                $_SESSION['ld_login_user_id'] = $value['id'];
                $_SESSION['ld_useremail'] = $value['user_email'];
                    if($this->remember == "true"){
                        setcookie('laundry_username',$name, time() + (86400 * 30), "/");
                        setcookie('laundry_password',$this->cookie_passwords, time() + (86400 * 30), "/");
                        setcookie('laundry_remember',"checked", time() + (86400 * 30), "/");
                    }
                    else{
                        unset($_COOKIE['laundry_username']);
                        unset($_COOKIE['laundry_password']);
                        unset($_COOKIE['laundry_remember']);
                        /* setcookie('laundry_username',null, -1, '/');
                        setcookie('laundry_password',null, -1, '/');
                        setcookie('laundry_remember',null, -1, '/'); */
                    }
                echo filter_var("yesuser");
            }else{
                echo filter_var('no');
            }
        }
    }
    /* forgot password */
    public function getuserpassword($email){
        $query = "select `password` from `ld_admin_info` where `email` = '".$email."'";
        $result=mysqli_query($this->conn,$query);
        $value=mysqli_fetch_row($result);
        if($value[0]!=0){
           echo filter_var("yes");
        }
        else
        {
            echo filter_var("no");
        }
    }
    public function resetpassword($id,$newpassword){
        $query = "UPDATE `ld_users` SET `user_pwd` = '".$newpassword."' WHERE `id` = '".$id."'";
        $result=mysqli_query($this->conn,$query);
    }
}
?>