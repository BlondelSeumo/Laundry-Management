<?php  

ob_start();
include(dirname(dirname(dirname(__FILE__)))."/objects/class_payments.php");
include(dirname(dirname(dirname(__FILE__)))."/header.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_connection.php");
include(dirname(dirname(dirname(__FILE__))).'/objects/class_setting.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_general.php');

$con = new laundry_db();
$conn = $con->connect();
$objpayment = new laundry_payments();
$objpayment->conn = $conn;

$general=new laundry_general();
$general->conn=$conn;


$setting = new laundry_setting();
$setting->conn = $conn;
$getdateformat=$setting->get_option('ld_date_picker_date_format');
$gettimeformat=$setting->get_option('ld_time_format');
$symbol_position=$setting->get_option('ld_currency_symbol_position');
$decimal=$setting->get_option('ld_price_format_decimal_places');

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
	if($language_label_arr[6] != ''){
		$label_decode_front_form_errors = base64_decode($language_label_arr[6]);
	}else{
		$label_decode_front_form_errors = base64_decode($default_language_arr[6]);
	}
	
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
	$label_decode_front_form_errors_unserial = unserialize($label_decode_front_form_errors);
    
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial,$label_decode_front_form_errors_unserial);
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}
else
{
	$default_language_arr = $setting->get_all_labelsbyid("en");
    
    $label_decode_front = base64_decode($default_language_arr[1]);
	$label_decode_admin = base64_decode($default_language_arr[3]);
	$label_decode_error = base64_decode($default_language_arr[4]);
	$label_decode_extra = base64_decode($default_language_arr[5]);
	$label_decode_front_form_errors = base64_decode($default_language_arr[6]);
	
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
	$label_decode_front_form_errors_unserial = unserialize($label_decode_front_form_errors);
    
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial,$label_decode_front_form_errors_unserial);
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}
include(dirname(dirname(dirname(__FILE__))).'/assets/lib/date_translate_array.php');
if(isset($_POST['getallpaymentbydate'])){
    $start = filter_var($_POST['startdate']);
    $end = filter_var($_POST['enddate']);
    $r = $objpayment->getallpaymentsbydate($start,$end);
    $rec = mysqli_num_rows($r);
    ?>
<table id="payments-details-ajax" class="display responsive nowrap table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th>
				<?php  echo filter_var($label_language_values['client']);?>
			</th>
			<th>
				<?php  echo filter_var($label_language_values['payment_method']);?>
			</th>
			<th>
				<?php  echo filter_var($label_language_values['transaction_id']);?>
			</th>
			<th>
				<?php  echo filter_var($label_language_values['payment_date']);?>
			</th>
			<th>
				<?php  echo filter_var($label_language_values['amount']);?>
			</th>
			<th>
				<?php  echo filter_var($label_language_values['discount']);?>
			</th>
			<th>
				<?php  echo filter_var($label_language_values['tax']);?>
			</th>
			<th>
				<?php  echo filter_var($label_language_values['net_total']);?>
			</th>
			<th>
				<?php  echo filter_var($label_language_values['partial_amount']);?>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php 
        $sr = 1;
        $r = $objpayment->getallpaymentsbydate($start,$end);
        while($rs = mysqli_fetch_array($r)){
            ?>
		<tr>
			<td>
				<?php  echo filter_var($rs['order_id']);?>
			</td>
			<td>
				<?php 
				$p_client_name = $objpayment->getclientname($rs['order_id']);
				$p_client_name_res = str_split($p_client_name,5);
				echo str_replace(","," ",implode(",",$p_client_name_res));
				?>
			</td>
			<?php 
                if($rs['net_amount']==0)
				{
                    ?>
					<td>
						<?php  
						if($rs['payment_method'] == "Stripe-payment" || strtolower(trim($rs['payment_method'])) == "card-payment")
						{
							echo filter_var($label_language_values['card_payment']);				
							if($rs['payment_method'] == "Stripe-payment")
							{	
							?>								
								<span class="ld-payment-img">
								<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/stripe-s.png" ?>" title="Stripe Payment" />
								</span>		
								<?php  
							}
							else if(strtolower(trim($rs['payment_method'])) == "card-payment")
							{
								?>								
								<span class="ld-payment-img">
								<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/authorize-a.png" ?>" title="Authorize.Net Payment" /></span>	
								<?php  
							}
							else if(strtolower(trim($rs['payment_method'])) == "2checkout-payment")
							{	
								?>								
								<span class="ld-payment-img">
								<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/2checkout.png" ?>" title="2Checkout Payment" /></span>	
								<?php  
							}		
						}
						else 
						{ 	
							echo filter_var($rs['payment_method']);				
						} ?>				
					</td>
						<td><?php if($rs['transaction_id'] == ""){ echo filter_var("-");}
							else{ $p_t_id_res = str_split($rs['transaction_id'],10);echo str_replace(","," ",implode(",",$p_t_id_res)); }?>
						</td>
						<td>
							<?php  echo 
							str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($rs['payment_date'])));?>
						</td>
						<td>
							<?php  if($rs['amount'] == 0){ echo filter_var($label_language_values['free']); }else{echo  $general->ld_price_format($rs['amount'],$symbol_position,$decimal);}?></td>
						<td>
							<?php  if($rs['frequently_discount'] == 'O')
                        {
                            echo filter_var($label_language_values['once'])." - ".$general->ld_price_format($rs['frequently_discount_amount'],$symbol_position,$decimal);
                        }
                        elseif($rs['frequently_discount'] == 'W')
                        {
                            echo filter_var($label_language_values['weekly'])." - ".$general->ld_price_format($rs['frequently_discount_amount'],$symbol_position,$decimal);
                        }
                        elseif($rs['frequently_discount'] == 'B')
                        {
                            echo filter_var($label_language_values['bi_weekly'])." - ".$general->ld_price_format($rs['frequently_discount_amount'],$symbol_position,$decimal);
                        }
                        elseif($rs['frequently_discount'] == 'M')
                        {
                            echo filter_var($label_language_values['monthly'])." - ".$general->ld_price_format($rs['frequently_discount_amount'],$symbol_position,$decimal);
                        }
                        else
                        {
                            echo  $label_language_values['none'];
                        }
                        ?>
					</td>
					<td>
						<?php  if($rs['taxes'] == 0){ echo filter_var($label_language_values['free']); }else{echo  $general->ld_price_format($rs['taxes'],$symbol_position,$decimal);}?></td>
					<td>
						<?php  if($rs['net_amount'] == 0){ echo filter_var($label_language_values['free']); }else{echo  $general->ld_price_format($rs['net_amount'],$symbol_position,$decimal);}?></td>
					<td>
						<?php  if($rs['partial_amount'] == 0){ echo filter_var($label_language_values['free']); }else{echo  $general->ld_price_format($rs['partial_amount'],$symbol_position,$decimal);}?></td>
					<?php 
                }
                else{
                    ?>
					<td>
					<?php  
					if($rs['payment_method'] == "Stripe-payment" || strtolower(trim($rs['payment_method'])) == "card-payment"){
					echo filter_var($label_language_values['card_payment']);				
					if($rs['payment_method'] == "Stripe-payment"){	
					?>								
									<span class="ld-payment-img">
										<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/stripe-s.png" ?>" title="Stripe Payment" /></span>		
											<?php  							}
					else if(strtolower(trim($rs['payment_method'])) == "card-payment"){	
					?>								
											<span class="ld-payment-img">
												<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/authorize-a.png" ?>" title="Authorize.Net Payment" /></span>	
													<?php  }	

						else if(strtolower(trim($rs['payment_method'])) == "2checkout-payment")
						{	
							?>								
						<span class="ld-payment-img">
							<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/2checkout.png" ?>" title="2Checkout Payment" /></span>	
								<?php  
						}							
					} else { 	
					echo filter_var($rs['payment_method']);				
					} ?>				
					</td>
					<td><?php if($rs['transaction_id'] == ""){ echo filter_var("-");}
					else{ $p_t_id_res = str_split($rs['transaction_id'],10);echo str_replace(","," ",implode(",",$p_t_id_res)); }?>
					</td>
					<td>
						<?php  echo 
							str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($rs['payment_date'])));?>
					</td>
					<td>
						<?php  echo  $general->ld_price_format($rs['amount'],$symbol_position,$decimal);?></td>
					<td>
						<?php  echo  $rs['discount']==0?"-":$general->ld_price_format($rs['discount'],$symbol_position,$decimal);?></td>
					<td>
						<?php  echo  $rs['taxes']==0?"-":$general->ld_price_format($rs['taxes'],$symbol_position,$decimal);?></td>
					<td>
						<?php  echo  $rs['net_amount']==0?"-":$general->ld_price_format($rs['net_amount'],$symbol_position,$decimal);?></td>
					<td>
						<?php  echo  $rs['partial_amount']==0?"-":$general->ld_price_format($rs['partial_amount'],$symbol_position,$decimal);?></td>
					<?php 
                }
                ?>
														</tr>
														<?php 
            $sr++;
        }

        ?>

													</tbody>
												</table>

												<?php 
}


if(isset($_POST['update_payment_status'])){
	$order_id = filter_var($_POST['order_id']);
	$update_status = filter_var($_POST['update_current_status']);
	echo $r = filter_var($objpayment->update_payment_status($order_id,$update_status));
	
}
?>