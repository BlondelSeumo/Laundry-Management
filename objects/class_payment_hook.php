<?php  
class laundry_paymentHook{
	public $conn;
	public function payment_purchase_status() {
		$payment_extensions_res=$this->get_p_pay_option('ld_payment_extensions');
		$final_result = unserialize($payment_extensions_res);
		$check_arr = array();
		if(isset($final_result) && $final_result !== false){
			foreach($final_result as $key=>$value) {
				$ext_pstatus = "ld_".base64_encode($key."_pstatus");
				$chk_pstatus_option = $this->get_p_pay_option($ext_pstatus);
				
				/* $ext_pcode = "ld_".$key."_purchase_code";
				$get_pcode = $this->get_p_pay_option($ext_pcode);
				
				$mixedstring = substr($get_pcode,-4).'sm';
				$checkstring = base64_encode('valid'.$mixedstring);
				
				if($chk_pstatus_option == $checkstring){ */
					$option = $value['option_name'];
					$include_path = $value['include_path'];
					$vals=$this->get_p_pay_option($option);
					$file_path = dirname(dirname(__FILE__)).$include_path;
					if($vals == 'Y'){
						if(file_exists($file_path)) {
							$check_arr[$option]="Y";
						}else{
							$check_arr[$option]="N";
						}
					}else{
						$check_arr[$option]="N";
					}
		
			}
		}
		return $check_arr;
	}
	public function payment_extenstions_exist() {
		include(dirname(dirname(__FILE__)).'/extension/payment_check.php');
	}
	public function payment_setting_hook($hook_name) {
		return payment_setting($hook_name);
	}
	public function payment_settings_save_js_hook($hook_name) {
		return payment_settings_save_js($hook_name);
	}
	public function payment_settings_save_ajax_hook($hook_name) {
		return payment_settings_save_ajax($hook_name);
	}
	public function payment_payment_selection_hook($hook_name) {
		return payment_payment_selection($hook_name);
	}
	public function payment_checkout_hook($hook_name) {
		return payment_checkout($hook_name);
	}
	public function payment_display_cardbox_condition_hook($hook_name) {
		return payment_display_cardbox_condition($hook_name);
	}
	public function payment_partial_deposit_toggle_condition_hook($hook_name) {
		return payment_partial_deposit_toggle_condition($hook_name);
	}
	public function payment_currency_check_js_hook($hook_name) {
		return payment_currency_check_js($hook_name);
	}
	public function payment_validation_js_hook($hook_name) {
		return payment_validation_js($hook_name);
	}
	public function payment_process_js_hook($hook_name) {
		return payment_process_js($hook_name);
	}
	public function payment_form_hook($hook_name) {
		return payment_form($hook_name);
	}
	public function get_p_pay_option($option_name)
    {
        $query = "select `option_value` from `ld_settings` where `option_name`='" . $option_name . "'";
        $result = mysqli_query($this->conn, $query);
        $ress = @mysqli_fetch_row($result);
        return $ress= isset($ress[0])? $ress[0] : '' ;
    }
	public function payment_js_objects_hook($hook_name) {
		return payment_js_objects($hook_name);
	}
}
?>