<?php
include(dirname(__FILE__).'/header.php');

$_SESSION['ld_cart'] = array();
$_SESSION['freq_dis_amount'] = '';
$_SESSION['ld_details'] = '';
$_SESSION['service_id'] = '';
$_SESSION['single_service_id'] = '';

include(dirname(dirname(__FILE__)).'/objects/class_services.php');
include(dirname(dirname(__FILE__)).'/objects/class_users.php');
include(dirname(dirname(__FILE__)).'/objects/class_front_first_step.php');

$objservice = new laundry_services();
$objservice->conn = $conn;
$user = new laundry_users();
$user->conn = $conn;
$settings = new laundry_setting();
$settings->conn = $conn; 

$symbol_position=$settings->get_option('ld_currency_symbol_position');
$decimal=$settings->get_option('ld_price_format_decimal_places');
$getdateformat=$settings->get_option('ld_date_picker_date_format');
$time_format = $settings->get_option('ld_time_format');
$date_format=$settings->get_option('ld_date_picker_date_format');
$lang = $settings->get_option("ld_language");
$first_step=new laundry_first_step();
$first_step->conn=$conn;

?>

<script src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/ld-manual-booking-jquery.js" type="text/javascript"></script>

<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no">
			<link rel="stylesheet" href="assets/css/bootstrap.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css"> 
      <link rel="stylesheet" href="assets/css/style.css">
      <link rel="stylesheet" href="assets/css/responsive.css">
      <link rel="stylesheet" href="assets/css/font.css"> 
	    <link rel="stylesheet" href="assets/css/gijgo.min.css"> 
   </head>
   <body>
	 <div id="pos">
		<section class="main-body pt-32">
			<div class="container-fluid">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 float-left"> 
					<div class="product-category-main">			
						<div class="card tab-card">
							<div class="card-header tab-card-header border-0">
								<ul class="nav nav-pills card-header-tabs responsive-ul-set" id="myTab" role="tablist">
									<?php  
										$services_data = $objservice->readall_for_frontend_services();
										if (mysqli_num_rows($services_data) > 0) {
											while ($s_arr = mysqli_fetch_array($services_data)) {
												?>
												<li class="common-product">
												
												<?php   if($settings->get_option('ld_company_service_desc_status') != "" &&  $settings->get_option('ld_company_service_desc_status') == "Y"){ ?>
												
												<a  class="nav-link d-flex border-product-cs pos_details select_service" id="one-tab" data-toggle="pill" href="#one" role="tab" aria-controls="One" aria-selected="true" title='<?php  echo $s_arr['description'];?>'
												<?php   }else {
													
													echo "class='ld-sm-6 ld-md-4 ld-lg-3 ld-xs-12 remove_service_class pos_details'";	
													
													}  ?>
													data-servicetitle="<?php  echo filter_var($s_arr['title']); ?>"
													data-id="<?php  echo filter_var($s_arr['id']); ?>">
														<?php  
														if ($s_arr['image'] == '') {
															$s_image = 'default_service.png';
														} else {
															$s_image = $s_arr['image'];
														}
														?>
														<img src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/services/<?php  echo filter_var($s_image); ?>" class="common-width">
														<h3><?php  echo filter_var($s_arr['title']); ?></h3>
														</a>
												</li>
											<?php  
											} ?>
										 <?php   
													if (mysqli_num_rows($services_data) === 1){
														 $st_arry = mysqli_fetch_array($services_data)
															?>
															<script>
																jQuery(document).ready(function() {
																	jQuery('.select_service').trigger('click');
																});
															</script>
															<?php  
														}										 
										} else {
											?>
											<li class="ld-sm-12 ld-md-12 ld-xs-12 ld-no-service-box"><?php  echo filter_var($label_language_values['please_configure_first_laundry_services_and_settings_in_admin_panel']); ?>
											</li>
										<?php  
										}
										?>
									
								</ul>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 float-left main-content-div"> 
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 float-left p-0"> 
									<div class="main-product-search">
											<div class="product-filter common-div-product">
												<h3> All Products </h3>
											</div>
											<div class="after-none common-div-product">
												<h3> All Products </h3>
											</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade active in p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
									 <div class="main-cart-product add_on_lists ">
								
									</div>					 
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 float-left pt-17 fixed-sidebar-wrap">
					<div class="side-Summary-main">
					<div class="summery-product-cart">
						<div class="main-title-div">
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 float-left"> 
									<div class="common-heading">
										<h4> Name </h4>
									</div>
								</div>
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 float-left"> 
									<div class="common-heading">
										<h4> QTY </h4>
									</div>
								</div>
								<div class="col-xs-2 col-sm-3 col-md-4 col-lg-4 float-left"> 
									<div class="common-heading">
										<h4> Price </h4>
									</div>
								</div>
						</div>
						<h4 class="cart_empty_msg"><?php  echo filter_var($label_language_values['cart_is_empty']); ?></h4>
						<div class="summery-main-details cart_item_listing ld-addon-items-list">
			
						</div>
					</div>
					<div class="bottom-cart-main-detilas">
						<div class="pickup-main-div m-10-20 pickup_delivery_datas">
						
						</div>
						<div class="bottoom-summary-detilas">
								<div class="common-price-detilas">
									<div class="sub-total">
										<h4> Sub Total </h4>
									</div>
									<div class="sub-amount">
											<h4 class="cart_sub_total">0.00</h4>
									</div>
								</div>
								<div class="common-price-detilas">
									<div class="sub-total">
										<h4> Tax </h4>
									</div>
									<div class="sub-amount">
											<h4 class="cart_tax">0.00</h4>
									</div>
								</div>
								<div class="common-price-detilas">
									<div class="sub-total">
										<h4 class="fs-24"> Total</h4>
									</div>
									<div class="sub-amount">
											<h4 class="fs-24 cart_total">0.00</h4>
									</div>
								</div>
							</div>
							<div class="bottom-all-btns-main">
								<div class="common-all-btns d-flex">
								<?php if(isset($_SESSION['order_id'])){  ?>
								 <a  href="<?php if(isset($_SESSION['order_id'])){ echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>assets/lib/download_invoice_client.php?iid=<?php echo filter_var($_SESSION['order_id']);}else{ echo "#";}	?>" class="btn btn-primary custom-btn print-custom"><img src="assets/img/printer.png" class="btn-icone-size">Print</a>
								 <?php } ?> 
									<button type="button" class="btn btn-primary custom-btn pay-custom"  data-toggle="modal" data-target="#exampleModal-2">Pay <img src="assets/img/payment-method.png" class="btn-icone-size"></button>
									<button type="button" class="btn btn-primary custom-btn schedule-custom" data-toggle="modal" data-target="#exampleModal">Schedule <img src="assets/img/calendar.png" class="btn-icone-size"></button>
									
								</div>
							</div>
					</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	 
	 
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form id="pickup_delivery_datetime" class="" method="post">
      <div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
				<div class="main-schedule-popop">
					
						<div class="title-common">
							<h3>Select Pick-up Date & Time</h3>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 ct-datetime-select-main">
							<div class="ct-datetime-select">
								<div class="calendar-wrapper cal_info">
									<input type="text" class="btn btn-default" id="pickup_date_POS" name="pickup_date_POS" placeholder = "Select Pick-Up Date" />
								</div>
								<label class="delivery_date_error time-slot-set" id="date_time_error_id" for="complete_bookings"></label>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 ct-datetime-select-main">
							<div class="ct-datetime-select">
								<div class="calendar-wrapper cal_info time-slot-set">
									<select class="selectpicker pickup-slots">
										<option>Select Slot</option>
									</select>
								</div>
								<label class="delivery_time_error date_time_error" id="date_time_error_id" for="complete_bookings"></label>
							</div>
						</div>
						<div class="title-common">
							<h3>Select Delivery Date & Time</h3>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 ct-datetime-select-main">
							<div class="ct-datetime-select">
								<div class="calendar-wrapper cal_info">
									<input type="text"  class="btn btn-default" id="delivery_date_POS" name="delivery_date_POS" placeholder = "Select Delivery Date"/>
								</div>
								<label class="delivery_date_error" id="date_time_error_id" for="complete_bookings"></label>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 ct-datetime-select-main">
							<div class="ct-datetime-select">
								<div class="calendar-wrapper cal_info time-slot-set">
									<select class="selectpicker delivery-slots">
										<option>Select Slot</option>
									</select>
								</div>
									<label class="delivery_time_error date_time_error" id="date_time_error_id" for="complete_bookings"></label>
							</div>
						</div>
						
				</div>
      </div>
      <div class="modal-footer border-0 d-flex-root text-center w-100 ">
        <button type="button" class="btn btn-secondary submit-custom pickup_delivery_data">Submit</button>
      </div>
			</form>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="panel-body">
								<div class="ld-user-info-main ld-common-box existing_user_details hide_allsss">
									<div class="ld-list-header">
										<div class="ld-logged-in-user client_logout mb-50">
											<p class="welcome_msg_after_login pull-left"><?php  echo filter_var($label_language_values['you_are_logged_in_as']); ?> <span class='fname'></span> <span class='lname'></span></p>
											<a href="javascript:void(0)" class="ld-link ml-10" id="ld_change_customer" title="Change Customer">Change Customer</a>
										</div>
									</div>
									<div class="ld-main-details">
										<div class="ld-login-exist" id="ld-login">
											<div class="ld-custom-radio">
												<ul class="ld-radio-list hide_radio_btn_after_login mb_35">
													<?php  
													if($settings->get_option('ld_existing_and_new_user_checkout') == 'on' && $settings->get_option('ld_guest_user_checkout') == 'on'){
													?>
														<li class="ld-exiting-user ld-md-4 ld-sm-6 ld-xs-12">
															<input id="existing-user" type="radio" class="input-radio existing-user user-selection" name="user-selection" value="Existing User"/>
															<label for="existing-user" class=""><span></span><?php  echo filter_var($label_language_values['existing_user']); ?></label>
														</li>
														<li class="ld-new-user ld-md-4 ld-sm-6 ld-xs-12">
															<input id="new-user" type="radio" checked="checked" class="input-radio new-user user-selection" name="user-selection" value="New-User"/>
															<label for="new-user" class=""><span></span><?php  echo filter_var($label_language_values['new_user']); ?>
															</label>
														</li>
														<li class="ld-guest-user ld-md-4 ld-sm-6 ld-xs-12">
															<input id="guest-user" type="radio" class="input-radio guest-user user-selection" name="user-selection" value="Guest-User"/>
															<label for="guest-user" class=""><span></span><?php  echo filter_var($label_language_values['guest_user']); ?></label>
														</li>
													<?php  
													}else if($settings->get_option('ld_existing_and_new_user_checkout') == 'off' && $settings->get_option('ld_guest_user_checkout') == 'on'){
													?>
														<li class="ld-guest-user ld-md-4 ld-sm-6 ld-xs-12" style='display:none;'>
															<input id="guest-user" type="radio" class="input-radio guest-user user-selection" checked="checked"  name="user-selection" value="Guest-User"/>
															<label for="guest-user" class=""><span></span><?php  echo filter_var($label_language_values['guest_user']); ?></label>
														</li>						
													<?php  
													}else if($settings->get_option('ld_existing_and_new_user_checkout') == 'on' && $settings->get_option('ld_guest_user_checkout') == 'off'){
													?>
														<li class="ld-exiting-user ld-md-4 ld-sm-6 ld-xs-12">
															<input id="existing-user" type="radio" class="input-radio existing-user user-selection" name="user-selection" value="Existing User"/>
															<label for="existing-user" class=""><span></span><?php  echo filter_var($label_language_values['existing_user']); ?></label>
														</li>
														<li class="ld-new-user ld-md-4 ld-sm-6 ld-xs-12">
															<input id="new-user" type="radio" checked="checked" class="input-radio new-user user-selection" name="user-selection" value="New-User"/>
															<label for="new-user" class=""><span></span><?php  echo filter_var($label_language_values['new_user']); ?>
															</label>
														</li>
													<?php  
													}
													?>
												</ul>
											</div>
											<div class="ld-login-existing ld-hidden">
												<form id="user_login_form" class="" method="POST">
													<div class="ld-md-7 ld-sm-8 ld-xs-12 ld-form-row hide_login_email">
														<label for="ld-user-name">Select existing user</label>
														<select id="ld_mb_existing_login_dropdown" class="selectpicker" data-size="10" style="display: none;" data-live-search="true">
															<option value="0">Please select</option>
															<?php  
															$all_existing_users = $user->readall();
															while($data = mysqli_fetch_array($all_existing_users)){
																echo '<option value="'.$data['id'].'">'.$data['first_name'].' '.$data['last_name'].'</option>';
															}
															?>
														</select>
													</div>
												</form>
											</div>
										</div>  
										
										
										<input type="hidden" id="ld-user-name" value="" />
										<input type="hidden" id="ld-user-pass" value="" />
										
										<input type="hidden" id="color_box" data-id="<?php  echo filter_var($settings->get_option('ld_secondary_color')); ?>" value="<?php  echo filter_var($settings->get_option('ld_secondary_color')); ?>"/>

										<form id="user_details_form-2" class="" method="post" autocomplete="off">

											<div class="ld-new-user-details remove_preferred_password_and_preferred_email">
												<div class="row ld-xs-12">	
													<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">
														
														<input type="text" name="ld_email" id="ld-email" class="add_show_error_class error fancy_input" autocomplete="new-email"/>
															<span class="highlight"></span>
															<span class="bar"></span>
														<label for="ld-email" class="fancy_label"><?php  echo filter_var($label_language_values['preferred_email']); ?></label>
														
													</div>

													<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">

														<input type="password" name="ld_preffered_pass" id="ld-preffered-pass" class="add_show_error_class error fancy_input" autocomplete="new-password"/>
															<span class="highlight"></span>
															<span class="bar"></span>
														<label for="ld-preffered-pass" class="fancy_label"><?php  echo filter_var($label_language_values['preferred_password']); ?></label>

													</div>

												</div>
											</div>

											<div class="ld-peronal-details">

												
												<div class="row ld-xs-12">
												<?php   $fn_check = explode(",",$settings->get_option("ld_bf_first_name"));if($fn_check[0] == 'on'){ ?>
												
												<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">

													<input type="text" name="ld_first_name" class="add_show_error_class error fancy_input" id="ld-first-name" />
															<span class="highlight"></span>
															<span class="bar"></span>
													<label for="ld-first-name" class="fancy_label"><?php  echo filter_var($label_language_values['first_name']); ?></label>

												</div>

												<?php   } else {
													?>
													<input type="hidden" name="ld_first_name" id="ld-first-name" class="add_show_error_class error" value=""/>
													<?php   
												} ?>
												<?php   $ln_check = explode(",",$settings->get_option("ld_bf_last_name"));if($ln_check[0] == 'on'){ ?>
												
												<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">

													<input type="text" class="add_show_error_class error fancy_input" name="ld_last_name" id="ld-last-name" />
															<span class="highlight"></span>
															<span class="bar"></span>
													<label for="ld-last-pass" class="fancy_label"><?php  echo filter_var($label_language_values['last_name']); ?></label>

												</div>

												<?php   } else {
													?>
													<input type="hidden" name="ld_last_name" id="ld-last-name" class="add_show_error_class error" value=""/>
													<?php   
												} ?>
												</div>
												<div class="row ld-xs-12">
												<?php   $phone_check = explode(",",$settings->get_option("ld_bf_phone")); if($phone_check[0] == 'on'){ ?>
												
												<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap phone_no_wrap">
													
													<input type="tel" value="" id="ld-user-phone" class="add_show_error_class error fancy_input" name="ld_user_phone"/>
															<span class="highlight"></span>
															<span class="bar"></span>
													<label for="ld-user-phone" class="fancy_label"><?php  echo filter_var($label_language_values['phone']); ?></label>

												</div>

												<?php   } else {
													?>
													<input type="hidden" name="ld_user_phone" id="ld-user-phone" class="add_show_error_class error" value=""/>
													<?php   
												} ?>
												<?php   $address_check = explode(",",$settings->get_option("ld_bf_address"));if($address_check[0] == 'on'){ ?>
												
												<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">
													
													<input type="text" name="ld_street_address" id="ld-street-address" class="add_show_error_class error fancy_input" />
															<span class="highlight"></span>
															<span class="bar"></span>
													<label for="ld-street-address" class="fancy_label"><?php  echo filter_var($label_language_values['street_address']); ?></label>
												</div>

												<?php   } else {
													?>
													<input type="hidden" name="ld_street_address" id="ld-street-address" class="add_show_error_class error" value=""/>
													<?php   
												} ?>
												</div>
												<div class="row ld-xs-12">
												<?php   $zip_check = explode(",",$settings->get_option("ld_bf_zip_code"));if($zip_check[0] == 'on'){ ?>
												
												<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row remove_zip_code_class fancy_input_wrap">
													
													<input type="text" name="ld_zip_code" id="ld-zip-code" class="add_show_error_class error fancy_input" />
															<span class="highlight"></span>
															<span class="bar"></span>
													<label for="ld-zip-code" class="fancy_label"><?php  echo filter_var($label_language_values['zip_code']); ?></label>
												</div>

												<?php   } else {
													?>
													<input type="hidden" name="ld_zip_code" id="ld-zip-code" class="add_show_error_class error" value=""/>
													<?php   
												} ?>
												<?php   $city_check = explode(",",$settings->get_option("ld_bf_city")); if($city_check[0] == 'on'){ ?>
												
												<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row remove_city_class fancy_input_wrap">
													
													<input type="text" name="ld_city" id="ld-city" class="add_show_error_class error fancy_input" />
															<span class="highlight"></span>
															<span class="bar"></span>
													<label for="ld-city" class="fancy_label"><?php  echo filter_var($label_language_values['city']); ?></label>
												</div>

												<?php   } else {
													?>
													<input type="hidden" name="ld_city" id="ld-city" class="add_show_error_class error" value=""/>
													<?php   
												} ?>
												</div>
												<div class="row ld-xs-12">
												<?php   $state_check = explode(",",$settings->get_option("ld_bf_state")); if($state_check[0] == 'on'){ ?>
												
												<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row remove_state_class fancy_input_wrap">
													
													<input type="text" name="ld_state" id="ld-state" class="add_show_error_class error fancy_input" />
															<span class="highlight"></span>
															<span class="bar"></span>
													<label for="ld-state" class="fancy_label"><?php  echo filter_var($label_language_values['state']); ?></label>

												</div>

												<?php   } else {
													?>
													<input type="hidden" name="ld_state" id="ld-state" class="add_show_error_class error" value=""/>
													<?php   
												} ?>
												<?php   $notes_check = explode(",",$settings->get_option("ld_bf_notes")); if($notes_check[0] == 'on'){ ?>
												
												<div class="ld-md-12 ld-xs-12 ld-form-row fancy_input_wrap">
													
													<textarea id="ld-notes" class="add_show_error_class error fancy_input" rows="10"></textarea>
															<span class="highlight"></span>
															<span class="bar"></span>
													<label for="ld-notes" class="fancy_label"><?php  echo filter_var($label_language_values['special_requests_notes']); ?></label>

												</div>

												<?php   } else {
													?>
													<input type="hidden" id="ld-notes" class="add_show_error_class error" value=""/>
													<?php   
												} ?>
												</div>
												<?php   if($settings->get_option('ld_company_willwe_getin_status') != "" &&  $settings->get_option('ld_company_willwe_getin_status') == "Y"){?>
												<div class="ld-options-new ld-md-12 ld-xs-12 mb-10 ld-form-row">
													<label><?php  echo filter_var($label_language_values['how_will_we_get_in']); ?></label>

													<div class="ld-option-select">
														<select class="ld-option-select" id="contact_status">
															<option value="I'll be at home"><?php  echo filter_var($label_language_values['i_will_be_at_home']); ?></option>
															<option value="Please call me"><?php  echo filter_var($label_language_values['please_call_me']); ?></option>
															<option value="The key is with the doorman"><?php  echo filter_var($label_language_values['the_key_is_with_the_doorman']); ?></option>
															<option value="Other"><?php  echo filter_var($label_language_values['other']); ?></option>
														</select>
													</div>
													<div class="ld-option-others ld-md-12 pt-10 np ld-xs-12 ld-hidden">
														<input type="text" name="other_contact_status" class="add_show_error_class error" id="other_contact_status" />
													</div>
												</div>
												<?php   } ?>
												<?php   
												if( $settings->get_option('ld_appointment_details_display') == 'on' && ($address_check[0] == 'on' || $zip_check[0] == 'on' || $city_check[0] == 'on' || $state_check[0] == 'on'))
												{ ?>					  
												<div class="ld-md-12 ld-xs-12 ld-form-row np">
													<h3 class="header3 pull-left"><?php  echo filter_var($label_language_values['appointment_details']); ?></h3>
													<div class="pull-left ml-10">
													<div class="ld-custom-checkbox">
														<ul class="ld-checkbox-list">
															<li>
																<input type="checkbox" id="retype_status" /> 
																<label for="retype_status" class="">
																	(<?php  echo filter_var($label_language_values['same_as_above']); ?>) &nbsp;<span></span>
																</label>
															</li>
														</ul>
													</div>
													</div>
													<div class="cb"></div>
													
													
													
													<?php   
													if($address_check[0] == 'on')
													{ ?>
														<div class="ld-md-12 ld-xs-12 ld-form-row">
															<label for="app-notes"><?php  echo filter_var($label_language_values['appointment_address']); ?></label>
															<input type="text" id="app-street-address" name="app_street_address" class="add_show_error_class error" >
														</div><?php   
													} else {
													?>
													<input type="hidden" name="app_street_address" id="app-street-address" class="add_show_error_class error" value=""/>
													<?php   } ?>
													
													<?php   
													if($zip_check[0] == 'on')
													{ ?>
													<div class="ld-md-4 ld-sm-4 ld-xs-12 ld-form-row">
														<label for="app-zip-code"><?php  echo filter_var($label_language_values['appointment_zip']); ?></label>
														<input type="text" name="app_zip_code" id="app-zip-code" class="add_show_error_class error" />
													</div><?php   
													} else {
													?>
													<input type="hidden" name="app_zip_code" id="app-zip-code" class="add_show_error_class error" value=""/>
													<?php   
													} ?>
													
													<?php    
													if($city_check[0] == 'on')
													{ ?>
														<div class="ld-md-4 ld-sm-4 ld-xs-12 ld-form-row">
															<label for="app-city"><?php  echo filter_var($label_language_values['appointment_city']); ?></label>
															<input type="text" name="app_city" id="app-city" class="add_show_error_class error"/>
														</div><?php  
													} else {
													?>
													<input type="hidden" name="app_city" id="app-city" class="add_show_error_class error" value=""/>
													<?php   
													} ?>
												
													<?php   
													if($state_check[0] == 'on')
													{ ?>										  

													<div class="ld-md-4 ld-sm-4 ld-xs-12 ld-form-row">
														<label for="app-state"><?php  echo filter_var($label_language_values['appointment_state']); ?></label>
														<input type="text" name="app_state" id="app-state" class="add_show_error_class error" />
													</div><?php 
													} else {
													?>
													<input type="hidden" name="app_state" id="app-state" class="add_show_error_class error" value=""/>
													<?php   
												} ?>
													
												</div><?php 
											} ?>	
											</div>
									</div>
								</div>
								<label class="ld_all_booking_errors ld-md-12 mt-30" style="display: none;"></label>
								<div class="ld-complete-booking-main ld-sm-12 ld-md-12 mb-30 ld-xs-12 hide_allsss ">
									<div class="ld-list-header ld-hidden">
										<p class="ld-sub-complete-booking"></p>
									</div>
									
									<div class="text-center booking-com-btn-pos">
										<a href="javascript:void(0)" type='submit' data-currency_symbol="<?php  echo $settings->get_option('ld_currency_symbol'); ?>" id='complete_bookings' class="ld-button ld-btn-big ld_remove_id"><?php  echo filter_var($label_language_values['complete_booking']);?></a>
									</div>
								</div>

								</form>								
							</div>
			</div>
		
      </div>
      
    </div>
  </div>


	<script>
	
    var baseurlObj = {'base_url': '<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL);?>'};
    var siteurlObj = {'site_url': '<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL);?>'};
    var ajaxurlObj = {'ajax_url': '<?php  echo filter_var(AJAX_URL, FILTER_VALIDATE_URL);?>'};
    var fronturlObj = {'front_url': '<?php  echo filter_var(FRONT_URL, FILTER_VALIDATE_URL);?>'};
    var termsconditionObj = {'terms_condition': '<?php  echo filter_var($settings->get_option('ld_allow_terms_and_conditions'), FILTER_VALIDATE_URL);?>'};
    var privacypolicyObj = {'privacy_policy': '<?php  echo filter_var($settings->get_option('ld_allow_privacy_policy'), FILTER_VALIDATE_URL);?>'};
    <?php  
    
		if($settings->get_option('ld_thankyou_page_url') == ''){
        $thankyou_page_url = SITE_URL.'front/thankyou.php';
    }else{
        $thankyou_page_url = $settings->get_option('ld_thankyou_page_url');
    }
		$phone = explode(",",$settings->get_option('ld_bf_phone'));
		$check_password = explode(",",$settings->get_option('ld_bf_password'));
		$check_fn = explode(",",$settings->get_option('ld_bf_first_name'));
		$check_ln = explode(",",$settings->get_option('ld_bf_last_name'));
		$check_addresss = explode(",",$settings->get_option('ld_bf_address'));
		$check_zip_code = explode(",",$settings->get_option('ld_bf_zip_code'));
		$check_city = explode(",",$settings->get_option('ld_bf_city'));
		$check_state = explode(",",$settings->get_option('ld_bf_state'));
		$check_notes = explode(",",$settings->get_option('ld_bf_notes'));
	 
    ?>
		var thankyoupageObj = {'thankyou_page': '<?php  echo filter_var($thankyou_page_url, FILTER_VALIDATE_URL);?>'};
			
		var phone_status = {'statuss' : '<?php  echo filter_var($phone[0]);?>','required' : '<?php  echo filter_var($phone[1]);?>','min' : '<?php  echo filter_var($phone[2]);?>','max' : '<?php  echo filter_var($phone[3]);?>'};  
		
		var check_password = {'statuss' : '<?php  echo filter_var($check_password[0]);?>','required' : '<?php  echo filter_var($check_password[1]);?>','min' : '<?php  echo filter_var($check_password[2]);?>','max' : '<?php  echo filter_var($check_password[3]);?>'};
			
		var check_fn = {'statuss' : '<?php  echo filter_var($check_fn[0]);?>','required' : '<?php  echo filter_var($check_fn[1]);?>','min' : '<?php  echo filter_var($check_fn[2]);?>','max' : '<?php  echo filter_var($check_fn[3]);?>'};
			
		var check_ln = {'statuss' : '<?php  echo filter_var($check_ln[0]);?>','required' : '<?php  echo filter_var($check_ln[1]);?>','min' : '<?php  echo filter_var($check_ln[2]);?>','max' : '<?php  echo filter_var($check_ln[3]);?>'};
			
		var check_addresss = {'statuss' : '<?php  echo filter_var($check_addresss[0]);?>','required' : '<?php  echo filter_var($check_addresss[1]);?>','min' : '<?php  echo filter_var($check_addresss[2]);?>','max' : '<?php  echo filter_var($check_addresss[3]);?>'};
			
		var check_zip_code = {'statuss' : '<?php  echo filter_var($check_zip_code[0]);?>','required' : '<?php  echo filter_var($check_zip_code[1]);?>','min' : '<?php  echo filter_var($check_zip_code[2]);?>','max' : '<?php  echo filter_var($check_zip_code[3]);?>'};
			
		var check_city = {'statuss' : '<?php  echo filter_var($check_city[0]);?>','required' : '<?php  echo filter_var($check_city[1]);?>','min' : '<?php  echo filter_var($check_city[2]);?>','max' : '<?php  echo filter_var($check_city[3]);?>'};
			
		var check_state = {'statuss' : '<?php  echo filter_var($check_state[0]);?>','required' : '<?php  echo filter_var($check_state[1]);?>','min' : '<?php  echo filter_var($check_state[2]);?>','max' : '<?php  echo filter_var($check_state[3]);?>'};
		
		var check_notes = {'statuss' : '<?php  echo filter_var($check_notes[0]);?>','required' : '<?php  echo filter_var($check_notes[1]);?>','min' : '<?php  echo filter_var($check_notes[2]);?>','max' : '<?php  echo filter_var($check_notes[3]);?>'}; 
		<?php  
		$nacode = explode(',',$settings->get_option("ld_company_country_code"));
		$allowed = $settings->get_option("ld_phone_display_country_code");
		?>
		var countrycodeObj = {'numbercode': '<?php  echo filter_var($nacode[0]);?>', 'alphacode': '<?php  echo filter_var($nacode[1]);?>', 'countrytitle': '<?php  echo filter_var($nacode[2]);?>', 'allowed': '<?php  echo filter_var($allowed);?>'};
	 
		var subheaderObj = {'subheader_status': '<?php  echo filter_var($settings->get_option('ld_subheaders'));?>'};
			
		var appoint_details = {'status':'<?php  echo filter_var($settings->get_option('ld_appointment_details_display'));?>'};

		<?php   
		$t_zone_value = $settings->get_option('ld_timezone');
		$server_timezone = date_default_timezone_get();
		if(isset($t_zone_value) && $t_zone_value!=''){
			$offset= $first_step->get_timezone_offset($server_timezone,$t_zone_value);
			$timezonediff = $offset/3600;  
		}else{
			$timezonediff =0;
		}
		if(is_numeric(strpos($timezonediff,'-'))){
			$timediffmis = str_replace('-','',$timezonediff)*60;
			$currDateTime_withTZ= strtotime("-".$timediffmis." minutes",strtotime(date('Y-m-d H:i:s')));
		}else{
			$timediffmis = str_replace('+','',$timezonediff)*60;
			$currDateTime_withTZ = strtotime("+".$timediffmis." minutes",strtotime(date('Y-m-d H:i:s')));
		} 
		$current_date = date('Y-m-d',$currDateTime_withTZ);

		$advance_booking_time = $settings->get_option('ld_max_advance_booking_time');

		$advance_date = date('Y-m-d', strtotime("-1 day",strtotime("+".$advance_booking_time." months", $currDateTime_withTZ)));
		
		$dateFormat = $settings->get_option('ld_date_picker_date_format');
		
		function date_format_js($date_Format) {
			$chars = array(

				'd' => 'DD',
				'j' => 'DD',
			
				'm' => 'MM',
				'M' => 'MMM',
				'F' => 'MMMM',
			
				'Y' => 'YYYY',
				'y' => 'YYYY',
			);
			return strtr( (string) $date_Format, $chars );
		}
		?>
		var current_date = '<?php  echo filter_var($current_date); ?>';
		var advance_date = '<?php  echo filter_var($advance_date); ?>';
		var date_format_for_js = '<?php  echo filter_var(date_format_js($dateFormat)); ?>';
		var minimum_delivery_days = '<?php echo filter_var($settings->get_option('ld_minimum_delivery_days')); ?>';
		var advancebooking_days_limit = '<?php echo filter_var($settings->get_option('ld_max_advance_booking_time')); ?>';
		var show_delivery_date = '<?php echo filter_var($settings->get_option('ld_show_delivery_date')); ?>';
		var self_service_cart_title = '<?php echo filter_var($label_language_values['self_service']); ?>';	
		
	</script>
	  <script>
		jQuery(document).ready(function() {
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    var new_date = moment(today, date_format_for_js).add(advancebooking_days_limit, 'M');
    jQuery('#pickup_date_POS').daterangepicker({
        locale: {
            format: date_format_for_js
        },
        singleDatePicker: true,
        showDropdowns: true,
        minDate: today,
        maxDate: new_date
    });
});

jQuery(document).ready(function() {
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    jQuery('#delivery_date_POS').daterangepicker({
        locale: {
            format: date_format_for_js
        },
        singleDatePicker: true,
        showDropdowns: true,
        minDate: today
    });
});

    jQuery(".phone_no_wrap .fancy_input").on("keyup", function() {
        if (jQuery(this).val().length > 0) {
            jQuery(".phone_no_wrap").addClass("focused_label_wrap");
        } else if (jQuery(this).val().length <= 0) {
            jQuery(".phone_no_wrap").removeClass("focused_label_wrap");
        }
    });
  </script>
	
	<script type="text/javascript">
        function PrintElem(elem) {
            Popup($(elem).html());
        }

        function Popup(data) {
            var myWindow = window.open('', 'my div', 'height=400,width=600');
            myWindow.document.write('<html><head><title>my div</title>');
            /*optional stylesheet*/ //myWindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
            myWindow.document.write('</head><body >');
            myWindow.document.write(data);
            myWindow.document.write('</body></html>');
            myWindow.document.close(); // necessary for IE >= 10

            myWindow.onload=function(){ // necessary if the div contain images

                myWindow.focus(); // necessary for IE >= 10
                myWindow.print();
                myWindow.close();
            };
        }
    </script>
</body>    
</html>
<?php 
include(dirname(__FILE__).'/footer.php');
?>
