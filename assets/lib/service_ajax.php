<?php     
session_start();
include(dirname(dirname(dirname(__FILE__)))."/objects/class_connection.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_services.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_services_methods_units.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_design_settings.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_setting.php");
include(dirname(dirname(dirname(__FILE__)))."/header.php");
$con = new laundry_db();
$conn = $con->connect();
$objservice = new laundry_services();
$objservice_unit = new laundry_services_methods_units();
$objservice->conn = $conn;
$objservice_unit->conn = $conn;
$objdesignset = new laundry_design_settings();
$objdesignset->conn = $conn;
$settings = new laundry_setting();
$settings->conn = $conn;
$lang = $settings->get_option("ld_language");
$label_language_values = array();
$language_label_arr = $settings->get_all_labelsbyid($lang);
if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "")
{
	$default_language_arr = $settings->get_all_labelsbyid("en");
	if($language_label_arr[1] != ''){
		$label_decode_front = base64_decode($language_label_arr[1]);
	}else{
		$label_decode_front = base64_decode($default_language_arr[1]);
	}
	if($language_label_arr[3] != ''){
		$label_decode_admin = base64_decode($language_label_arr[3]);
	}else{
		$label_decode_admin = base64_decode($default_language_arr[3]);
	}
	if($language_label_arr[4] != ''){
		$label_decode_error = base64_decode($language_label_arr[4]);
	}else{
		$label_decode_error = base64_decode($default_language_arr[4]);
	}
	if($language_label_arr[5] != ''){
		$label_decode_extra = base64_decode($language_label_arr[5]);
	}else{
		$label_decode_extra = base64_decode($default_language_arr[5]);
	}
	
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
    
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);
	
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}
else
{
    $default_language_arr = $settings->get_all_labelsbyid("en");
    
	$label_decode_front = base64_decode($default_language_arr[1]);
	$label_decode_admin = base64_decode($default_language_arr[3]);
	$label_decode_error = base64_decode($default_language_arr[4]);
	$label_decode_extra = base64_decode($default_language_arr[5]);
		
	
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
    
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);
	
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}
if(isset($_POST['pos']) && isset($_POST['ids']))
{
    echo filter_var("yes in ");
    echo count(filter_var($_POST['ids']));
    for($i=0;$i<count($_POST['ids']);$i++)
    {
        $objservice->position=$_POST['pos'][$i];
        $objservice->id=$_POST['ids'][$i];
        $objservice->updateposition();
    }
}
else if(isset($_POST['deleteid']))
{
	$objservice->id=filter_var($_POST['deleteid']);
	chmod(dirname(dirname(dirname(__FILE__)))."/assets/images/services", 0777);

	/* CODE TO DELETE ADDONS AND SERVICE IMAGE BEFORE DELETE SERVICE FORM TABLE */ 
	/* $methods = $objservice->get_exist_methods_by_serviceid(filter_var($_POST['deleteid']));
	
	while($r = mysqli_fetch_array($methods)){
		$methods_units = $objservice->get_exist_methods_units_by_methodid($r['id']);
		while($t = mysqli_fetch_array($methods_units))
		{
			$methods_units_rate = $objservice->get_exist_methods_units_rate_by_unitid($t['id']);
			while($mur = mysqli_fetch_array($methods_units_rate))
			{
				$objservice->delete_service_method_unit_rate($mur['id']);
			}
			$objservice->delete_method_unit($t['id']);
		}
		$objservice->delete_method($r['id']);
	} */
  $objservice->delete_service();
}
elseif(isset($_POST['changestatus']))
{
    $objservice->id=filter_var($_POST['id']);
    $objservice->status = filter_var($_POST['changestatus']);
    $objservice->changestatus();
	if($objservice){
		if(filter_var($_POST['changestatus'])=='E'){
      echo filter_var($label_language_values['service_enable']);
		}else{
      echo filter_var($label_language_values['service_disable']);
		}
	}
}
elseif(isset($_POST['operationadd']))
{
    chmod(dirname(dirname(dirname(__FILE__)))."/assets/images/services", 0777);
    $objservice->title = filter_var(filter_var($_POST['title']));
    $t = $objservice->check_same_title();
    $cnt = mysqli_num_rows($t);
    if($cnt == 0){
        $objservice->color = filter_var($_POST['color']);
        $objservice->title = filter_var(mysqli_real_escape_string($conn,ucwords(filter_var($_POST['title']))));
        $objservice->description = mysqli_real_escape_string($conn,filter_var($_POST['description']));
        $objservice->status = filter_var($_POST['status']);
        $objservice->position = filter_var($_POST['position']);
				$objservice->service_limit = filter_var($_POST['max_order_per_day']);
        $insertid = $objservice->add_service();
				$all_units = $objservice_unit->get_all_units();
				$objservice_unit->service_id = $insertid;
				if(mysqli_num_rows($all_units) > 0){
					while($row = mysqli_fetch_assoc($all_units)){
						$objservice_unit->service_unit_id = filter_var($row["id"]);
						$objservice_unit->price = filter_var("0");
						$objservice_unit->add_services_method_unit_price();
					}
				}
        $objservice->image = filter_var($_POST['image']);
        $objservice->update_recordfor_image($insertid);
        /* REMOVE UNSED IMAGES FROM FOLDER */
        $used_images = $objservice->get_used_images();
        $imgarr = array();
        while($img  = mysqli_fetch_array($used_images)){
            $filtername = preg_replace('/\\.[^.\\s]{3,4}$/', '', $img[0]);
            array_push($imgarr,$filtername);
						$filtername = preg_replace('/\\.[^.\\s]{3,4}$/', '', $img[1]);
            array_push($imgarr,$filtername);
						$filtername = preg_replace('/\\.[^.\\s]{3,4}$/', '', $img[2]);
            array_push($imgarr,$filtername);
        }
        array_push($imgarr,"default");
        array_push($imgarr,"default_service");
        array_push($imgarr,"default_service1");
        print_r($imgarr);
        $dir = dirname(dirname(dirname(__FILE__)))."/assets/images/services/";
        $cnt = 1;
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if($cnt > 2){
                    $filtername = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);
                    if (in_array($filtername, $imgarr)) {
                    }
                    else{
                        unlink(dirname(dirname(dirname(__FILE__)))."/assets/images/services/".$file);
                    }
                }
                $cnt++;
            }
            closedir($dh);
        }
    }
    else{
       echo filter_var("1");
    }
}
elseif(isset($_POST['operationedit']))
{
    chmod(dirname(dirname(dirname(__FILE__)))."/assets/images/services", 0777);
    $objservice->id = filter_var($_POST['id']);
    $objservice->color = filter_var($_POST['color']);
    $objservice->title = filter_var(mysqli_real_escape_string($conn,ucwords(filter_var($_POST['title']))));
    $objservice->description = mysqli_real_escape_string($conn,filter_var($_POST['description']));
    $objservice->image = filter_var($_POST['image']);
    $objservice->service_limit = filter_var($_POST['max_order_per_day']);
    $objservice->update_service();
    /* REMOVE UNSED IMAGES FROM FOLDER */
    $used_images = $objservice->get_used_images();
    $imgarr = array();
    while($img  = mysqli_fetch_array($used_images)){
        $filtername = preg_replace('/\\.[^.\\s]{3,4}$/', '', $img[0]);
        array_push($imgarr,$filtername);
				$filtername = preg_replace('/\\.[^.\\s]{3,4}$/', '', $img[1]);
        array_push($imgarr,$filtername);
				$filtername = preg_replace('/\\.[^.\\s]{3,4}$/', '', $img[2]);
        array_push($imgarr,$filtername);
    }
    array_push($imgarr,"default");
    array_push($imgarr,"default_service");
    array_push($imgarr,"default_service1");
    print_r($imgarr);
    $dir = dirname(dirname(dirname(__FILE__)))."/assets/images/services/";
    $cnt = 1;
    if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if($cnt > 2){
					$filtername = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);
					if (in_array($filtername, $imgarr)) {
					}
					else{
							unlink(dirname(dirname(dirname(__FILE__)))."/assets/images/services/".$file);
					}
				}
				$cnt++;
			}
			closedir($dh);
    }
}
elseif(isset($_POST['assigndesign']))
{
    $objdesignset->title=filter_var($_POST['divname']);
    $objdesignset->design=filter_var($_POST['designid']);
    $having = $objdesignset->readone();
    if(count($having[0])>0)
    {
        $objdesignset->update_setting_design();
    }
    else
    {
        $objdesignset->add_setting_design();
    }
}
/*Delete Service Image*/
if(isset($_POST['action']) && filter_var($_POST['action'])=='delete_image'){
    $objservice->id=filter_var($_POST['service_id']);
    $objservice->image="";
    $del_image=$objservice->update_image();
}
?>