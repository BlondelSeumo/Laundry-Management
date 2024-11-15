<?php  

	
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_promo_code.php');
	
	$database=new laundry_db();
	$conn=$database->connect();
	$promo=new laundry_promo_code();
	$promo->conn=$conn;
	
	$alldata=$promo->readall_service();
	
/* Code for Add */
if(isset($_POST['action']) && filter_var($_POST['action'])=='add_promo_code'){
    $promo->coupon_code = filter_var($_POST['coupon_code']);
    $t = $promo->check_same_title();
    $cnt = mysqli_num_rows($t);
    if($cnt == 0) {
        $promo->coupon_code = filter_var($_POST['coupon_code']);
        $promo->coupon_type = filter_var($_POST['coupon_type']);
        $promo->value = filter_var($_POST['value']);
        $promo->limit_use = filter_var($_POST['limit']);
        $promo->expiry_date = $_POST['expiry_date'];
        $promo->add_promo_code();
    }
    else{
        echo filter_var("1");
    }
}
if(isset($_POST['action']) && filter_var($_POST['action'])=='edit_promo_code'){
	    $promo->id=filter_var($_POST['recordid']);
        $promo->coupon_code=filter_var($_POST['edit_coupon_code']);
        $promo->coupon_type=filter_var($_POST['edit_coupon_type']);
        $promo->value=filter_var($_POST['edit_value']);
        $promo->limit_use=filter_var($_POST['edit_limit']);
        $promo->expiry_date= $_POST['edit_expiry_date'];
        $savedata=$promo->update_promo_code();
        
        if($savedata){
            echo filter_var("Data Updated");
        }else{
            echo filter_var("Data Not Updated");
        }
}
if(isset($_POST['action']) && filter_var($_POST['action'])=='delete_record'){
	
	$promo->id=filter_var($_POST['recordid']);
	$delete=$promo->delete_promo_code();
	if($delete){
		echo filter_var("Record Deleted");
	}else{
		echo filter_var("Record Not Deleted");
	}
}

if(isset($_POST['action']) && $_POST['action']=='edit_special_offer'){
    $promo->id=$_POST['recordid'];
    $promo->special_text=$_POST['edit_special_text'];
    $promo->coupon_type=$_POST['edit_offer_type'];
    $promo->coupon_value=$_POST['edit_special_value'];
    $promo->coupon_date=$_POST['edit_special_date'];
    $savedata=$promo->update_special_offer();
    if($savedata){
        echo "Data Updated";
    }else{
        echo "Data Not Updated";
    }
}

if(isset($_POST['action']) && $_POST['action']=='delete_record'){
	
	$promo->id=$_POST['recordid'];
	$delete=$promo->delete_promo_code();
	if($delete){
		echo "Record Deleted";
	}else{
		echo "Record Not Deleted";
	}
}

if(isset($_POST['action']) && $_POST['action']=='delete_specoff_record'){
	
	$promo->specoff_id=$_POST['recordid'];
	$delete=$promo->delete_spec_off();
	if($delete){
		echo "Record Deleted";
	}else{
		echo "Record Not Deleted";
	}
}