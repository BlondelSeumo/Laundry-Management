<?php  

session_start();
include(dirname(dirname(dirname(__FILE__))).'/header.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_users.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_order_client_info.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_setting.php');
include(dirname(dirname(dirname(__FILE__)))."/objects/class_services.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_services_methods_units.php");
include(dirname(dirname(dirname(__FILE__)))."/objects/class_design_settings.php");
include(dirname(dirname(dirname(__FILE__))).'/objects/class_general.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_front_first_step.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_adminprofile.php');

$database= new laundry_db();
$conn=$database->connect();
/* $database->conn=$conn; */

$first_step=new laundry_first_step();
$first_step->conn=$conn;


$general=new laundry_general();
$general->conn=$conn;

$objadmin=new laundry_adminprofile();
$objadmin->conn=$conn;

$user=new laundry_users();
$order_client_info=new laundry_order_client_info();
$settings=new laundry_setting();

$user->conn=$conn;
$order_client_info->conn=$conn;
$settings->conn=$conn;

$objservice = new laundry_services();
$objservice->conn = $conn;

$objservice_method_unit = new laundry_services_methods_units();
$objservice_method_unit->conn = $conn;

$objdesignset = new laundry_design_settings();
$objdesignset->conn = $conn;

$symbol_position=$settings->get_option('ld_currency_symbol_position');
$decimal=$settings->get_option('ld_price_format_decimal_places');
$getdateformat=$settings->get_option('ld_date_picker_date_format');
$time_format = $settings->get_option('ld_time_format');
$date_format=$settings->get_option('ld_date_picker_date_format');
$lang = $settings->get_option("ld_language");

$label_language_values = array();

$language_label_arr = $settings->get_all_labelsbyid($lang);
if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "" || $language_label_arr[6] != "")
{
	$default_language_arr = $settings->get_all_labelsbyid("en");
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
   $default_language_arr = $settings->get_all_labelsbyid("en");
    
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



if ($language_label_arr[1] != "" && $language_label_arr[3] != "" && $language_label_arr[4] != "" && $language_label_arr[5] != "")
{
	$label_decode_front = base64_decode($language_label_arr[1]);
	$label_decode_admin = base64_decode($language_label_arr[3]);
	$label_decode_error = base64_decode($language_label_arr[4]);
	$label_decode_extra = base64_decode($language_label_arr[5]);
		
	
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
$calculation_policy = $settings->get_option("ld_calculation_policy");
if(isset($_POST['s_m_units_maxlimit_5'])){
    $objservice_method_unit->services_id = filter_var($_POST['service_id']);
    $objservice_method_unit->methods_id = filter_var($_POST['method_id']);
    $maxx_limitts = $objservice_method_unit->get_maxlimit_by_service_methods_ids();
	$mmnameee = 'ad_unit'.$maxx_limitts['id'];
    ?>
    <div class="ld-list-header">
        <h3 class="header3"><?php  echo filter_var($maxx_limitts['units_title']); ?></h3>
	</div>
    <div class="ld-address-area-main">
        <div class="ld-area-type">
            <span class="area-header"><?php if($maxx_limitts['limit_title'] != ""){echo filter_var($maxx_limitts['limit_title']);}else{echo ucwords($maxx_limitts['units_title']);} ?></span>
            <input maxlength="5" type="text" class="ld-area-input ld_area_m_units_rattee" id="ld_area_m_units" data-service_id="<?php echo filter_var($_POST['service_id']); ?>" data-units_id="<?php echo filter_var($maxx_limitts['id']); ?>"  data-method_id="<?php echo filter_var($_POST['method_id']); ?>" data-rate="" data-method_name="<?php echo filter_var($maxx_limitts['units_title']); ?>" data-maxx_limit="<?php echo filter_var($maxx_limitts['maxlimit']); ?>" data-type="<?php echo filter_var("method_units"); ?>" data-mnamee="<?php echo filter_var($mmnameee); ?>"/>
            <span class="area-type"><?php echo filter_var($maxx_limitts['unit_symbol']); ?></span>
        </div>
    </div>
    <span class="error_of_max_limitss error"></span>
    <span class="error_of_invalid_area error"></span>

<?php 
}

/*  Develope By :- Ajay
    For:- Laundry POS Add Pickup Date&Time  and Delivery Date&Time START */
		
elseif(isset($_POST['selected_date_slot'])) {

		$_SESSION['selected_pickup_date']= $_POST['selected_pickup_dates'];
		$_SESSION['selected_pickup_time']= $_POST['selected_pickup_time'];
		$_SESSION['selected_delivery_dates']= $_POST['selected_delivery_dates'];
		$_SESSION['selected_delivery_time']= $_POST['selected_delivery_time'];
		?>
		
			<div class="main-common-date-time">
				<div class="pickup-img mr-5">
					<img src="assets/img/pick-up.png" class="pickup-imgset">
				</div>
				<div class="pick-up-time">
					<span class="clr-gray pickup_date_pos" data-date_val="">
					
					<?php 
								if($time_format == 12){ ?>
									<?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($_POST['selected_pickup_dates'])));	?>
								<?php }else{ ?>
								
									<?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($_POST['selected_pickup_dates'])));	?>
								<?php } ?>
					</span>
				</div>
				<div class="pickup-img ml-15 mr-5">
					<img src="assets/img/p-time.png" class="pickup-imgset">
				</div>
				<div class="pick-up-time">
				<span class="clr-gray pickup_time_pos" data-time_val="">
				 <?php 
							if($time_format == 12){
									?>
							<?php echo $_POST['selected_pickup_time'];	?>
							<?php 
							}else{
									?>
									<?php echo $_POST['selected_pickup_time'];	?>
							<?php 
							}
							?>
				</span>
				</div>
			</div>
			<div class="main-common-date-time mt-10">
				<div class="pickup-img mr-5">
					<img src="assets/img/pick-up.png" class="pickup-imgset">
				</div>
				<div class="pick-up-time">
				<span class="clr-gray delivery_date_pos" data-date_del_val="">
						<?php 
								if($time_format == 12){ ?>
									<?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($_POST['selected_delivery_dates'])));	?>
								<?php }else{ ?>
								
									<?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($_POST['selected_delivery_dates'])));	?>
								<?php } ?>
								

				</span>
				</div>
				<div class="pickup-img ml-15 mr-5">
					<img src="assets/img/p-time.png" class="pickup-imgset">
				</div>
				<div class="pick-up-time">
				<span class="clr-gray delivery_time_pos" data-time_del_val=""> 
				<?php 
							if($time_format == 12){
									?>
							<?php echo $_POST['selected_delivery_time'];	?>
							<?php 
							}else{
									?>
									<?php echo $_POST['selected_delivery_time'];	?>
							<?php 
							}
							?> </span>
				</div>
			</div>
		<?php	
}
    /* Laundry POS Add Pickup Date&Time  and Delivery Date&Time END */

elseif(isset($_POST['get_service_units'])) {
	
	if(!empty($_SESSION["ld_cart"])){
		foreach($_SESSION["ld_cart"] as $key => $value){
			if(count((array)$value) == 0){
				$ids_array = explode(",",$_SESSION['service_id']);
				array_pop($ids_array);
				$key_array = explode("_",$key);
				if (($key_r = array_search($key_array[0], $ids_array)) !== false) {
					unset($ids_array[$key_r]);
				}
				$_SESSION['service_id'] = implode(",",$ids_array).",";
				unset($_SESSION["ld_cart"][$key]);
			}
		}
	}
	
	if(isset($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]]))
	{
			$id_quantity_array = array();
		foreach($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]] as $value){
			$id_quantity_array[$value["units_id"]] = $value["unit_qty"];
		}
		$objservice_method_unit->service_id=filter_var($_POST['service_id']);
		$addons_data=$objservice_method_unit->get_units_for_front();
		$objservice->services_id=filter_var($_POST['service_id']);
		if(isset($_SESSION['service_id'])){
			$ids_array = explode(",",$_SESSION['service_id']);
			if(!in_array($_POST['service_id'],$ids_array)){
				$_SESSION['service_id'].=$_POST['service_id'].",";
			}
		} else {
			$_SESSION['service_id']=$_POST['service_id'].",";
		}
		$_SESSION['single_service_id']=filter_var($_POST['service_id']);
		$objservice_method_unit->service_id = filter_var($_POST['service_id']);
		$countser = $objservice->get_count_service();
		$countserlim = $objservice->get_count_service_limit();
		if($countser < $countserlim)	{
			
			if(mysqli_num_rows($addons_data) > 0){
					?>
					<script>
			/* 		jQuery(document).ready(function() {
						jQuery('.ld-tooltip-addon').tooltipster({
							animation: 'grow',
							delay: 20,
							theme: 'tooltipster-shadow',
							trigger: 'hover'
						});
					}); */
					</script>
						<?php 
						if(mysqli_num_rows($addons_data) > 0){
							while($adonsdata =mysqli_fetch_array($addons_data)){ 
							 	$uname = "unit_".$adonsdata['id'];
								$objservice_method_unit->service_unit_id = $adonsdata['id'];
								$price_and_status = $objservice_method_unit->get_price_of_article();
								$values = mysqli_fetch_assoc($price_and_status);
								$price =  $adonsdata['price'];
								$unit_checked = "";
								$unit_quantity = 0;
								$unit_button_show = "none";
								if(isset($id_quantity_array[$adonsdata['id']])){
									$unit_checked = "checked=\"checked\"";
									$unit_quantity = $id_quantity_array[$adonsdata['id']];
									$unit_button_show = "block";
								}
										?>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 float-left add_addon_class_selected"> 
										<label>
											 <input type="checkbox" name="s-dade addon-checkbox" class=" d-none addon-checkbox addons_servicess" data-id="<?php echo filter_var($adonsdata['id']); ?>" id="ld-addon-<?php echo filter_var($adonsdata['id']); ?>" data-unamee="<?php echo filter_var($uname); ?>" <?php     echo $unit_checked; ?>> 
												<div class="common-product-div">
												
													<div class="top-price-lable">
														<div class="price-lable">
															<p><?php echo filter_var($general->ld_price_format($price,$symbol_position,$decimal)); ?> </p>
														</div>
														<div class="product-img">	
															<img src="<?php
																if($adonsdata['image'] == '' && $adonsdata['predefine_image'] == ''){
																	echo filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/services/default.png';
																}
																else
																{ 
																	if($adonsdata['image'] == ''){
																		echo filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/article-icons/'.$adonsdata['predefine_image'];
																	}else{
																		echo filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/services/'.$adonsdata['image'];
																												}
																} ?>" class="product-set">
														</div>
														<div class="product_dec_data">
															<div class="product-title text-center mt-2">
																<h3><?php echo filter_var($general->ld_price_format($price,$symbol_position,$decimal)).' Per Item'; ?></h3>
															</div>
													
															<div class="product-name text-center mt-2">
																<p><?php echo filter_var($adonsdata['units_title']); ?></p>
															</div>
														</div>
														<div class="product-counter">
															<div class="input-group">
																	<span class="input-group-btn">
																			<button class="btn btn-danger btn-number costom-common-btn mr-1 pos_minus" data-type="minus" data-field="quant[2]"  id="minus<?php  echo filter_var($adonsdata['id']); ?>" type="button" data-units_id="<?php echo filter_var($adonsdata['id']); ?>" data-service_id="<?php echo filter_var($_POST['service_id']); ?>"  data-unit_name="<?php echo filter_var($adonsdata['units_title']); ?>" data-unamee="<?php echo filter_var($uname); ?>" data-minlimit="<?php echo filter_var($adonsdata['minlimit']); ?>">
																			
																					<i class="fa fa-minus common-icone-counter"></i>
																			</button>
																	</span>
																	<input type="text" name="quant[2]" class="form-control input-number counter-number ld-btn-text addon_qty data_addon_qtyrate qtyyy_<?php echo filter_var($uname); ?>" value="<?php     echo $unit_quantity; ?>" min="1" max="100">
																	
																	<span class="input-group-btn">
																				<button type="button" class="btn btn-success btn-number costom-common-btn ml-1 pos_add" data-type="plus" data-field="quant[2]"    id="add<?php  echo filter_var($adonsdata['id']); ?>" data-db-qty="<?php echo filter_var($adonsdata["maxlimit"]); ?>" type="button" data-units_id="<?php echo filter_var($adonsdata['id']); ?>" data-service_id="<?php echo filter_var($_POST['service_id']); ?>" data-unit_name="<?php echo filter_var($adonsdata['units_title']); ?>" data-unamee="<?php echo filter_var($uname); ?>" data-minlimit="<?php echo filter_var($adonsdata['minlimit']); ?>">
																				<i class="fa fa-plus common-icone-counter"></i>
																				</button>
																	</span>
															</div>
														</div>
													</div>
												</div>
										</label> 
									</div><?php 
							}
						}else{ ?>
								<p class="ld-sub"><?php echo filter_var($label_language_values['extra_services_not_available']); ?></p>
						<?php  } ?>
				<?php 
			}else{
			  echo filter_var($label_language_values["extra_services_not_available"]);
			}
		
		}else{
			?><label class="empty_cart_error" id="empty_cart_error" style="display: block; color: rgb(255, 0, 0);"><?php echo filter_var($label_language_values['sorry_this_service_is_closed_now']); ?></label><?php    
		}
	}else{
		$_SESSION['ld_cart'][$_POST["cart_dynamic_key"]] = array();
		
		$objservice_method_unit->service_id=filter_var($_POST['service_id']);
		
		$objservice_method_unit->service_id = filter_var($_POST['service_id']);
		
    $addons_data=$objservice_method_unit->get_units_for_front();
		$objservice->services_id=filter_var($_POST['service_id']);
		if(isset($_SESSION['service_id'])){
			$_SESSION['service_id'].=$_POST['service_id'].",";
		} else {
				$_SESSION['service_id']=$_POST['service_id'].",";
		} 
		$_SESSION['single_service_id']=filter_var($_POST['service_id']);
    if(mysqli_num_rows($addons_data) > 0){
		?>
			<script>
/* 			jQuery(document).ready(function() {
				jQuery('.ld-tooltip-addon').tooltipster({
					animation: 'grow',
					delay: 20,
					theme: 'tooltipster-shadow',
					trigger: 'hover'
				});
			}); */
			</script>
					<?php 
					if(mysqli_num_rows($addons_data) > 0){
							while($adonsdata =mysqli_fetch_array($addons_data)){
									$uname = "unit_".$adonsdata['id'];
									$objservice_method_unit->service_unit_id = $adonsdata['id'];
									$price_and_status = $objservice_method_unit->get_price_of_article();
									$value = mysqli_fetch_assoc($price_and_status);
									$price =  $value['price'];
									$status =  $value['article_status'];
									?>
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 float-left add_addon_class_selected"> 
											<label>
												 <input type="checkbox" name="s-dade addon-checkbox" class=" d-none addon-checkbox addons_servicess" data-id="<?php echo filter_var($adonsdata['id']); ?>" id="ld-addon-<?php echo filter_var($adonsdata['id']); ?>" data-unamee="<?php echo filter_var($uname); ?>"> 
													<div class="common-product-div">
														
														<div class="top-price-lable">
															<div class="price-lable">
																<p><?php echo filter_var($general->ld_price_format($price,$symbol_position,$decimal)); ?> </p>
															</div>
															<div class="product-img">	
																<img src="<?php
																					if($adonsdata['image'] == '' && $adonsdata['predefine_image'] == ''){
																							echo filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/services/default.png';
																					}
																					else
																					{ 
																						if($adonsdata['image'] == ''){
																							echo filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/article-icons/'.$adonsdata['predefine_image'];
																						}
																						else
																						{
																							echo filter_var(SITE_URL, FILTER_VALIDATE_URL).'/assets/images/services/'.$adonsdata['image'];
																						}
																					} ?>" class="product-set">
															</div>
															<div class="product_dec_data">
																<div class="product-title text-center mt-2">
																		<h3><?php echo filter_var($general->ld_price_format($price,$symbol_position,$decimal)).' Per Item'; ?></h3></div>
																<div class="product-name text-center mt-2">
																	<p><?php echo filter_var($adonsdata['units_title']); ?></p>
																</div>
															</div>
															<div class="product-counter">
																<div class="input-group">
																		<span class="input-group-btn">
																				<button class="btn btn-danger btn-number costom-common-btn mr-1 pos_minus" data-type="minus" data-field="quant[2]"  id="minus<?php  echo filter_var($adonsdata['id']); ?>" type="button" data-units_id="<?php echo filter_var($adonsdata['id']); ?>" data-service_id="<?php echo filter_var($_POST['service_id']); ?>"  data-unit_name="<?php echo filter_var($adonsdata['units_title']); ?>" data-unamee="<?php echo filter_var($uname); ?>" data-minlimit="<?php echo filter_var($adonsdata['minlimit']); ?>">
																				
																						<i class="fa fa-minus common-icone-counter"></i>
																				</button>
																		</span>
																		<input type="text" value="0" name="quant[2]" class="form-control input-number counter-number ld-btn-text addon_qty data_addon_qtyrate qtyyy_<?php echo filter_var($uname); ?>" id="qty<?php echo $adonsdata['id']; ?>">
																		
																		<span class="input-group-btn">
																					<button type="button" class="btn btn-success btn-number costom-common-btn ml-1 pos_add" data-type="plus" data-field="quant[2]"    id="add<?php  echo filter_var($adonsdata['id']); ?>" data-db-qty="<?php echo filter_var($adonsdata["maxlimit"]); ?>" type="button" data-units_id="<?php echo filter_var($adonsdata['id']); ?>" data-service_id="<?php echo filter_var($_POST['service_id']); ?>" data-unit_name="<?php echo filter_var($adonsdata['units_title']); ?>" data-unamee="<?php echo filter_var($uname); ?>" data-minlimit="<?php echo filter_var($adonsdata['minlimit']); ?>">
																						
																					<i class="fa fa-plus common-icone-counter"></i>
																					</button>
																		</span>
																</div>
															</div>
														</div>
													</div>
											</label> 
										</div>
                 <?php 
                    }
          }else{
                ?><p class="ld-sub"><?php echo filter_var($label_language_values['extra_services_not_available']); ?></p>
                <?php 
          }?>
        <?php 
    }else{
        echo filter_var("Extra Services Not Available");
    }
	}
}

if(isset($_POST['select_language'])){
	$_SESSION['current_lang'] = filter_var($_POST['set_language']);
}


/**item remove from cart**/

if(isset($_POST['cart_item_remove'])){
	$json_array = array();
	$final_duration_value = 0;
	$cart_dynamic_key = $_POST['cart_dynamic_key'];
	for ($i = 0; $i < (count($_SESSION['ld_cart'][$cart_dynamic_key])); $i++)
	{
		$method_type = '';
		if($_SESSION['ld_cart'][$cart_dynamic_key] != '')
		{
			if ($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]][$i]['units_id'] == filter_var($_POST['unit_id']))
			{
		 		$unit_html = "";
				$unit_html .= '<li class="update_qty_of_s_m_' .$_POST['unit_id']. ''.$_POST['service_id'].'" data-service_id="' . $_POST['service_id'] . '" data-units_id="' . $_POST['unit_id'] . '"></li>';	
				unset($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]][$i]);
			}
		}
	}
	
	 $_SESSION['ld_cart'][$cart_dynamic_key] = array_values($_SESSION['ld_cart'][$_POST["cart_dynamic_key"]]);
	
	$bool_val = true;

	if(sizeof($_SESSION['ld_cart']) == 0){
		$json_array['status'] = "empty calculation";
		$bool_val = false;
	}
		/**calculation start**/
	if($bool_val) {
		
	$c_rates = 0;
	
	$final_subtotal = 0; 
	$full_cart_sub_total = 0;

	for ($i = 0; $i < (count($_SESSION['ld_cart'][$cart_dynamic_key])); $i++)
	{
			$c_rates = ($c_rates + $_SESSION['ld_cart'][$cart_dynamic_key][$i]['unit_rate']);
	}
	
	$total = $c_rates;

	if ($settings->get_option('ld_tax_vat_status') == 'Y')
	{
		if ($settings->get_option('ld_tax_vat_type') == 'F')
			{
			$flatvalue = $settings->get_option('ld_tax_vat_value');
			$taxamount = $flatvalue;
			}
			else
		if ($settings->get_option('ld_tax_vat_type') == 'P')
			{
			$percent = $settings->get_option('ld_tax_vat_value');
			$percentage_value = $percent / 100;
			$taxamount = $percentage_value * $total;
			}
		}
	else
	{
	$taxamount = 0;
	}
	foreach($_SESSION['ld_cart'] as $key => $value){
		
				foreach($value as $get => $myval)
				{
					$full_cart_sub_total += $myval['unit_rate']*$myval['unit_qty'];
				}
	}
	$partial_amount = 0;
	$remain_amount = 0;
	
	if ($settings->get_option('ld_partial_deposit_status') == 'Y')
	{
		$grand_total = $full_cart_sub_total + $taxamount;
		if ($settings->get_option('ld_partial_type') == 'F')
		{
			$p_deposite_amount = $settings->get_option('ld_partial_deposit_amount');
			$partial_amount = $p_deposite_amount;
			$remain_amount = $grand_total - $partial_amount;
		}
		elseif ($settings->get_option('ld_partial_type') == 'P')
		{
			$p_deposite_amount = $settings->get_option('ld_partial_deposit_amount');
			$percentages = $p_deposite_amount / 100;
			$partial_amount = $grand_total * $percentages;
			$remain_amount = $grand_total - $partial_amount;
		}
		else
		{
			$partial_amount = 0; 
			$remain_amount = 0; 
		}
	}
	else
	{
	$partial_amount = 0;
	$remain_amount = 0;
	}
	if($full_cart_sub_total == 0){
		$taxamount = 0;
	}
	$json_array['status'] = "cart not empty";
	$json_array['partial_amount'] = $general->ld_price_format($partial_amount, $symbol_position, $decimal);
	$json_array['remain_amount'] = $general->ld_price_format($remain_amount, $symbol_position, $decimal);
	$json_array["subtotal"] = $general->ld_price_format($full_cart_sub_total, $symbol_position, $decimal);
	$json_array["subtotal_amount"] =  $general->ld_price_format($full_cart_sub_total, $symbol_position, $decimal);
	$json_array['cart_tax'] = $general->ld_price_format($taxamount, $symbol_position, $decimal);
	$json_array['total_amount'] = $general->ld_price_format(($full_cart_sub_total + $taxamount) , $symbol_position, $decimal);
	$json_array['current_total_amount'] = $general->ld_price_format($full_cart_sub_total, $symbol_position, $decimal);	
	}
	echo json_encode($json_array);
}

?>