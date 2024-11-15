<?php  
include(dirname(dirname(dirname(__FILE__)))."/objects/class_connection.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_adminprofile.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_setting.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_dayweek_avail.php");
include(dirname(dirname(dirname(__FILE__)))."/header.php");
$con = new laundry_db();
$conn = $con->connect();
$objadminprofile = new laundry_adminprofile();
$objadminprofile->conn = $conn;
$settings = new laundry_setting();
$settings->conn = $conn;
    $timeavailability= new laundry_dayweek_avail();
    $timeavailability->conn = $conn;
if(isset($_POST['updateinfo'])){
    $objadminprofile->fullname = filter_var($_POST['fullname']);
    $objadminprofile->address = filter_var($_POST['address']);
    $objadminprofile->city = filter_var($_POST['city']);
    $objadminprofile->zip = filter_var($_POST['zip']);
    $objadminprofile->state = filter_var($_POST['state']);
    $objadminprofile->country = filter_var($_POST['country']);
    $objadminprofile->phone = filter_var($_POST['phone']);
    $objadminprofile->id = filter_var($_POST['id']);
    if($objadminprofile->update_profile()){
        echo filter_var("Info Updated");
    }
    else {
        echo filter_var("Not Updated");
    }
}
elseif(isset($_POST['updateinfowithpass'])){
    $objadminprofile->fullname = filter_var($_POST['fullname']);
    $objadminprofile->address = filter_var($_POST['address']);
    $objadminprofile->city = filter_var($_POST['city']);
    $objadminprofile->zip = filter_var($_POST['zip']);
    $objadminprofile->state = filter_var($_POST['state']);
    $objadminprofile->country = filter_var($_POST['country']);
    $objadminprofile->phone = filter_var($_POST['phone']);
    $objadminprofile->id = filter_var($_POST['id']);
    $objadminprofile->password = filter_var($_POST['password']);
    if($objadminprofile->update_profile_withpass()){
        echo filter_var("Info Updated");
    }
    else {
        echo filter_var("Not Updated");
    }
}
elseif(isset($_POST['updatepass'])){
    $objadminprofile->fullname = filter_var($_POST['fullname']);
	$objadminprofile->email = filter_var($_POST['adminemail'], FILTER_SANITIZE_EMAIL);
    $objadminprofile->address = filter_var($_POST['address']);
    $objadminprofile->city = filter_var($_POST['city']);
    $objadminprofile->zip = filter_var($_POST['zip']);
    $objadminprofile->state = filter_var($_POST['state']);
    $objadminprofile->country = filter_var($_POST['country']);
    $objadminprofile->phone = filter_var($_POST['phone']);
    $objadminprofile->id = filter_var($_POST['id']);
    $op=md5(filter_var($_POST['oldpassword']));
    $dp=filter_var($_POST['dboldpassword']);
    $np=filter_var($_POST['newpassword']);
    $rp=filter_var($_POST['retypepassword']);
    $operation = 1;
   if (filter_var($_POST['oldpassword']) != "") {
        if ($op != $dp) {
            $operation = 2;
            echo filter_var("sorry");
        }
        else {
            $operation = 3;
            if ($np == $rp) {
                $objadminprofile->password=md5($rp);
                $update=$objadminprofile->update_profile();
                if($update){
                    $_SESSION['ld_adminid']=filter_var($_POST['id']);
                }
            }
            else{
                echo filter_var("Please Retype Correct Password...");
            }
        }
    }
    if ($operation == 1) {
        $objadminprofile->password=$dp;
        $update=$objadminprofile->update_profile();
        if($update){
            $_SESSION['ld_adminid']=filter_var($_POST['id']);
        }
    }
}else if(isset($_POST['check_for_option'])){
    $check_for_products  = "select * from ld_services,ld_service_units";
    $hh = mysqli_query($conn,$check_for_products);
    $t = $timeavailability->get_timeavailability_check();
    $last = "";
    if($settings->get_option('ld_company_address')=="" ||
        $settings->get_option('ld_company_city')=="" ||
        $settings->get_option('ld_company_state')=="" ||
        $settings->get_option('ld_company_name')=="" ||
        $settings->get_option('ld_company_email')=="" ||
        $settings->get_option('ld_company_zip_code')=="" ||
        $settings->get_option('ld_company_country')=="" ||
        mysqli_num_rows($hh)=="" ||
        mysqli_num_rows($t)==""){
        $last = "Please Fill all the Company Informations and add some Services and Addons.";
    }
    if($last != ""){
        echo filter_var($last);
    }
}
?>