<?php  

class laundry_ld_nexmo{  
	var $ld_nexmo_api_key; 	 
	var $ld_nexmo_api_secret; 
	var $ld_nexmo_from; 

	public function send_nexmo_sms($phone,$ld_nexmo_text) {
		$nexmo_api_key=$this->ld_nexmo_api_key;
		$ld_nexmo_api_secret=$this->ld_nexmo_api_secret;
		$ld_nexmo_from=$this->ld_nexmo_from;
		
		$queryinfo = array('api_key' => $nexmo_api_key, 'api_secret' => $ld_nexmo_api_secret, 'to' => $phone, 'from' => $ld_nexmo_from, 'text' => $ld_nexmo_text);
		$url = 'https://rest.nexmo.com/sms/json?' . http_build_query($queryinfo);
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		return $response;
	} 
}
?>