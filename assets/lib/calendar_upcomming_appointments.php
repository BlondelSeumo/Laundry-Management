<?php  

	session_start();
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');	
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_services.php');	
	include_once(dirname(dirname(dirname(__FILE__))).'/header.php');		
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_booking.php');
	include(dirname(dirname(dirname(__FILE__))).'/objects/class_users.php');
  include(dirname(dirname(dirname(__FILE__)))."/objects/class_dashboard.php");
	include(dirname(dirname(dirname(__FILE__)))."/objects/class_setting.php");
  include(dirname(dirname(dirname(__FILE__))).'/objects/class_general.php');
  include(dirname(dirname(dirname(__FILE__))).'/objects/class_payments.php');
		
		$database=new laundry_db();
		$conn=$database->connect();
		$database->conn=$conn;
		
		$setting = new laundry_setting();
		$setting->conn = $conn;
		$general=new laundry_general();
		$general->conn=$conn;
		$symbol_position=$setting->get_option('ld_currency_symbol_position');
		$decimal=$setting->get_option('ld_price_format_decimal_places');
		$getdateformate = $setting->get_option('ld_date_picker_date_format');
		$time_format = $setting->get_option('ld_time_format');
		$service=new laundry_services();	
		$booking=new laundry_booking();
		$payment=new laundry_payments();
		$payment->conn=$conn;		
		$user=new laundry_users();
		$service->conn=$conn;		
		$booking->conn=$conn;
		$user->conn=$conn;
		if(isset($_SESSION['cal_service_id'])){
		$booking->service_id=$_SESSION['cal_service_id'];
		
		}
		if(isset($_SESSION['cal_provider_id'])){
		$booking->provider_id=$_SESSION['cal_provider_id'];	
		}
		if(isset($_SESSION['cal_startdate'])){
			$booking->booking_start_datetime=$_SESSION['cal_startdate'];
		}
		
		if(isset($_SESSION['cal_enddate'])){
			$booking->booking_end_datetime=$_SESSION['cal_enddate'];
		}
		$appointment_array_for_cal = array();
			
		$searchcalendar=$booking->readall();
        $myarrbook = $booking->getallbookings();
        while($tt = mysqli_fetch_array($myarrbook)){
					$service_ids = explode(",",$tt["service_id"]);
					$service_name = "";
					$color = "";
					foreach($service_ids as $id){
							$service->id = $id;
							$result = $service->readone();
							$service_name .= isset($result["title"])? $result["title"] : ''.","; 
							$color=isset($result['color'])? $result['color'] : '';
					}
					$title = chop($service_name,","); 
					$order_id = $tt['order_id'];
			
					if($time_format == 12){
				
					$format= 'H:ia';
				
					}else{
				
					$format= 'H:i';
				
					}
            $start=$tt['booking_pickup_date_time_start'];
            $end=$tt['booking_pickup_date_time_start'];
            $price=$general->ld_price_format($tt['net_amount'],$symbol_position,$decimal);
            $status = $tt['booking_status'];
            if($tt['client_id'] == 0){
                $gcn = $user->readoneguest($tt['order_id']);
                $clientname = $gcn[2];
                $clientphone = $gcn[4];
                $clientemail = $gcn[3];
            }
            else
            {
                $user->user_id = $tt['client_id'];
                $cn = $user->readone();
                $clientname = $cn[3]."".$cn[4];
								$fetch_phone =  strlen($cn[5]);
								if($fetch_phone >= 6){
									$clientphone = $cn[5];
								}else{
									$clientphone = '';
								}
                $clientemail = $cn[1];
            }
            $appointment_array_for_cal[]= array(
                "id"=>"$order_id",
                "color_tag"=>"$color",
                "title"=>"$title",
                "start"=>"$start",
                "end"=>"$start",
                "event_status"=>"$status",
                "client_name"=>"$clientname",
                "client_phone"=>"$clientphone",
                "client_email"=>"$clientemail",
                "total_price"=>"$price",
								"date_format"=>"$getdateformate",
								"time_format"=>"$format"
				
            );
		}
			if(isset($appointment_array_for_cal)){
			$json_encoded_string_for_cal  =  json_encode($appointment_array_for_cal);
			echo json_encode($appointment_array_for_cal); die();
    }
?>