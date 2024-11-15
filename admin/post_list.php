<?php 

include(dirname(dirname(__FILE__)).'/objects/class_connection.php');
include(dirname(dirname(__FILE__)).'/objects/class_users.php');
include(dirname(dirname(__FILE__)).'/objects/class_setting.php');
$database=new laundry_db();
$con=$database->connect();
$user=new laundry_users();
$user->conn=$con;
$setting = new laundry_setting();
$setting->conn = $con;
$get_date_format = $setting->get_option('ld_date_picker_date_format');
$get_time_format = $setting->get_option('ld_time_format');
$times = "";
if($get_time_format == 12){
	$times = " h:i A";
}else{
	$times = " H:i";
}

$lang = $setting->get_option("ld_language");
$label_language_values = array();
$language_label_arr = $setting->get_all_labelsbyid($lang);
if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "" || $language_label_arr[6] != "")
{
	$default_language_arr = $setting->get_all_labelsbyid("en");
	if($language_label_arr[1] != ''){
		$label_decode_front = base64_decode($language_label_arr[1]);
	}else{
		$label_decode_front = base64_decode($default_language_arr[1]);
	}
	
	$label_decode_front_unserial = unserialize($label_decode_front);
    
	$label_language_values = array_merge($label_decode_front_unserial);
	
	foreach($label_language_values as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}
else
{
    $default_language_arr = $setting->get_all_labelsbyid("en");
    
	$label_decode_front = base64_decode($default_language_arr[1]);
    
	
	$label_decode_front_unserial = unserialize($label_decode_front);
    
	$label_language_values = array_merge($label_decode_front_unserial);
	foreach($label_language_values as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}

$english_date_array = array(
"January","Jan","February","Feb","March","Mar","April","Apr","May","June","Jun","July","Jul","August","Aug","September","Sep","October","Oct","November","Nov","December","Dec","Sun","Mon","Tue","Wed","Thu","Fri","Sat","su","mo","tu","we","th","fr","sa","AM","PM");
	$selected_lang_label = array(
ucfirst(strtolower($label_language_values['january'])),
ucfirst(strtolower($label_language_values['jan'])),
ucfirst(strtolower($label_language_values['february'])),
ucfirst(strtolower($label_language_values['feb'])),
ucfirst(strtolower($label_language_values['march'])),
ucfirst(strtolower($label_language_values['mar'])),
ucfirst(strtolower($label_language_values['april'])),
ucfirst(strtolower($label_language_values['apr'])),
ucfirst(strtolower($label_language_values['may'])),
ucfirst(strtolower($label_language_values['june'])),
ucfirst(strtolower($label_language_values['jun'])),
ucfirst(strtolower($label_language_values['july'])),
ucfirst(strtolower($label_language_values['jul'])),
ucfirst(strtolower($label_language_values['august'])),
ucfirst(strtolower($label_language_values['aug'])),
ucfirst(strtolower($label_language_values['september'])),
ucfirst(strtolower($label_language_values['sep'])),
ucfirst(strtolower($label_language_values['october'])),
ucfirst(strtolower($label_language_values['oct'])),
ucfirst(strtolower($label_language_values['november'])),
ucfirst(strtolower($label_language_values['nov'])),
ucfirst(strtolower($label_language_values['december'])),
ucfirst(strtolower($label_language_values['dec'])),
ucfirst(strtolower($label_language_values['sun'])),
ucfirst(strtolower($label_language_values['mon'])),
ucfirst(strtolower($label_language_values['tue'])),
ucfirst(strtolower($label_language_values['wed'])),
ucfirst(strtolower($label_language_values['thu'])),
ucfirst(strtolower($label_language_values['fri'])),
ucfirst(strtolower($label_language_values['sat'])),
ucfirst(strtolower($label_language_values['su'])),
ucfirst(strtolower($label_language_values['mo'])),
ucfirst(strtolower($label_language_values['tu'])),
ucfirst(strtolower($label_language_values['we'])),
ucfirst(strtolower($label_language_values['th'])),
ucfirst(strtolower($label_language_values['fr'])),
ucfirst(strtolower($label_language_values['sa'])),
strtoupper($label_language_values['am']),
strtoupper($label_language_values['pm']));

	$params = $columns = $totalRecords = $data = array();

	$params = $_REQUEST;

	$columns = array(
		0 => 'id',
		1 => 'user_email', 
		2 => 'first_name',
		3 => 'last_name'
	);

	$where_condition = $sqlTot = $sqlRec = "";

	if( !empty($params['search']['value']) ) {
		$where_condition .=	" WHERE ";
		$where_condition .= " ( user_email LIKE '%".$params['search']['value']."%' ";    
		$where_condition .= " OR first_name LIKE '%".$params['search']['value']."%' ";
		$where_condition .= " OR last_name LIKE '%".$params['search']['value']."%' ";
		$where_condition .= " OR phone LIKE '%".$params['search']['value']."%' ";
		$where_condition .= " OR zip LIKE '%".$params['search']['value']."%' ";
		$where_condition .= " OR city LIKE '%".$params['search']['value']."%' ";
		$where_condition .= " OR state LIKE '%".$params['search']['value']."%' ";
		$where_condition .= " OR cus_dt LIKE '%".$params['search']['value']."%' )";
	}

	$sql_query = " SELECT * FROM ld_users ";
	$sqlTot .= $sql_query;
	$sqlRec .= $sql_query;
	
	if(isset($where_condition) && $where_condition != '') {

		$sqlTot .= $where_condition;
		$sqlRec .= $where_condition;
	}

 	$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";

	$queryTot = mysqli_query($con, $sqlTot) or die("Database Error:". mysqli_error($con));

	$totalRecords = mysqli_num_rows($queryTot);

	$queryRecords = mysqli_query($con, $sqlRec) or die("Error to Get the Post details.");

	while( $row = mysqli_fetch_row($queryRecords) ) { 
	
	$row[16] = $booking_date = $row[14];
	$bk="myregistercust_bookings";
	$booking = $user->get_users_totalbookings($row[0]);
	
	array_push($row,$booking);
	if($booking == 0){
		$bk="disabled";
	}
	array_push($row,$bk);
		$data[] = $row;
		
	}	
	

	$json_data = array(
		"draw"            => intval( $params['draw'] ),   
		"recordsTotal"    => intval( $totalRecords ),  
		"recordsFiltered" => intval($totalRecords),
		"data"            => $data
	);

	echo json_encode($json_data);
?>	