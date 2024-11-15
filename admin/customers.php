<?php  

include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/user_session_check.php');
include(dirname(dirname(__FILE__)).'/objects/class_users.php');
include(dirname(dirname(__FILE__)).'/objects/class_order_client_info.php');
$database=new laundry_db();
$conn=$database->connect();
$database->conn=$conn;
$user=new laundry_users();
$order_client_info=new laundry_order_client_info();
$user->conn=$conn;
$order_client_info->conn=$conn;
?>
    <div id="lda-customers-listing" class="panel tab-content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title"><?php echo filter_var($label_language_values['customers']);	?></h1>
            </div>
			<div class="panel-body">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#registered-customers-listing"><?php echo filter_var($label_language_values['registered_customers']);	?></a></li>
					<li><a data-toggle="tab" href="#guest-customers-listing"><?php echo filter_var($label_language_values['guest_customers']);	?></a></li>
				</ul>
				<div class="tab-content">
					<div id="registered-customers-listing" class="tab-pane fade in active">
						<h3><?php echo filter_var($label_language_values['registered_customers']);	?></h3>
						<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalregister"><?php echo filter_var($label_language_values['registered_customers']);	?></button>
						<div id="myModalregister" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Registered Customer Information</h4>
							  </div>
							  <div class="modal-body">
							  <form id="registered-client-table1" style="overflow:hidden;" method="post"> 
									<table class="form-horizontal col-xs-12" cellspacing="0">
										<tbody>
										<tr class="form-field form-required">
											<td class="col-xs-4"><label for="ab-newstaff-fullname" class="control-label"><?php echo filter_var($label_language_values['preferred_email']);	?></label></td>
											<td class=" col-xs-10 pull-left"><input type="text" class="form-control ld_email add_show_error_class show-error" id="ld_email" name="ld_email" required="required" placeholder="<?php echo filter_var($label_language_values['your_valid_email_address']); ?>" /></td>
										</tr>
										<tr class="form-field form-required">
											<td class="col-xs-4"><label for="ab-newstaff-fullname" class=""><?php echo filter_var($label_language_values['preferred_password']);	?></label></td>
											<td class=" col-xs-10 pull-left"><input type="password" class="form-control ld_password" id="ld_password" name="ld_password" required="required" placeholder="<?php echo filter_var($label_language_values['password']); ?>" /></td>
										</tr>
										<tr class="form-field form-required">
											<td class="col-xs-4"><label for="ab-newstaff-fullname" class=""><?php echo filter_var($label_language_values['first_name']);	?></label></td>
											<td class=" col-xs-10 pull-left"><input type="text" class="form-control ld_first_name" id="ld_first_name" name="ld_first_name" required="required"  placeholder="<?php echo filter_var($label_language_values['your_first_name']); ?>" /></td>
										</tr>
										<tr class="form-field form-required">
											<td class="col-xs-4"><label for="ab-newstaff-fullname" class=""><?php echo filter_var($label_language_values['last_name']);	?></label></td>
											<td class=" col-xs-10 pull-left"><input type="text" class="form-control ld_last_name" id="ld_last_name" name="ld_last_name" required="required"  placeholder="<?php echo filter_var($label_language_values['your_last_name']); ?>" /></td>
										</tr>
										<tr class="form-field form-required">
											<td class="col-xs-4"><label for="ab-newstaff-fullname" class=""><?php echo filter_var($label_language_values['phone']);	?></label></td>
											<td class="col-xs-10 pull-left"><input type="tel" class="form-control ld_phone" id="ld_phone" name="ld_phone" required="required" placeholder="Your Phone Number" /></td>
											
										</tr>
										<tr class="form-field form-required">
											<td class="col-xs-4"><label for="ab-newstaff-fullname" class=""><?php echo filter_var($label_language_values['street_address']);	?></label></td>
											<td class=" col-xs-10 pull-left"><textarea name="ld_address" id="ld_address" class="form-control ld_address" rows="" col="10" placeholder="<?php echo filter_var($label_language_values['street_address_placeholder']); ?>"></textarea>
										</tr>
										<tr class="form-field form-required">
											<td class="col-xs-4"><label for="ab-newstaff-fullname" class=""><?php echo filter_var($label_language_values['zip_code']);	?></label></td>
											<td class=" col-xs-10 pull-left"><input type="text" class="form-control ld_zip_code" id="ld_zip_code" name="ld_zip_code" required="required" placeholder="<?php echo filter_var($label_language_values['zip_code_placeholder']); ?>" /></td>
										</tr>
										<tr class="form-field form-required">
											<td class="col-xs-4"><label for="ab-newstaff-fullname" class=""><?php echo filter_var($label_language_values['city']);	?></label></td>
											<td class=" col-xs-10 pull-left"><input type="text" class="form-control ld_city" id="ld_city" name="ld_city" required="required" placeholder="<?php echo filter_var($label_language_values['city_placeholder']); ?>" /></td>
										</tr>
										<tr class="form-field form-required">
											<td class="col-xs-4"><label for="ab-newstaff-fullname" class=""><?php echo filter_var($label_language_values['state']);	?></label></td>
											<td class=" col-xs-10 pull-left"><input type="text" class="form-control ld_state" id="ld_state" name="ld_state" required="required" placeholder="<?php echo filter_var($label_language_values['state_placeholder']); ?>" /></td>
										</tr>
										
										</tbody>
									</table>
								
							</div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo filter_var($label_language_values['close']);	?></button>
								<button type="button" class="btn btn-success ld_register_customer_btn"><?php echo filter_var($label_language_values['create']);	?></button>
							</div>
							</div>
						  </div>
						  </form>
						</div>						
						<div id="accordion" class="panel-group">
							<table id="registered-client-table" class="display responsive nowrap table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th><?php echo filter_var($label_language_values['client_name']);	?></th>
									<th><?php echo filter_var($label_language_values['email']);	?></th>
									<th><?php echo filter_var($label_language_values['phone']);	?></th>
									<th><?php echo filter_var($label_language_values['bookings']);	?></th>
								</tr>
								</thead>
								<tbody>
								<?php 
								$reg_user_data = $user->readall();
								while($r_data = mysqli_fetch_array($reg_user_data)){
									
										$booking = $user->get_users_totalbookings($r_data['id']);
									?>
										<tr id="myregisted_<?php  echo filter_var($r_data['id']);	?>">
											<td><?php if($r_data['first_name'] != '' && $r_data['last_name'] != ''){echo filter_var($r_data['first_name'].' '.$r_data['last_name']);}elseif($r_data['first_name'] != '' && $r_data['last_name'] == ''){echo filter_var($r_data['first_name']);}elseif($r_data['first_name'] == '' && $r_data['last_name'] != ''){echo filter_var($r_data['last_name']);}elseif($r_data['first_name'] == '' && $r_data['last_name'] == ''){echo filter_var('N/A');} ?></td>
											<td><?php echo filter_var($r_data['user_email']); ?></td>
											<td><?php if(strlen($r_data['phone'])>6){echo filter_var($r_data['phone']);}else{echo filter_var('N/A');} ?></td>
											<td class="ld-bookings-td">
												<a class="btn btn-primary <?php  if($booking == 0){
													echo filter_var("disabled");
												}
												else{echo filter_var("myregistercust_bookings");}?>" data-id="<?php echo filter_var($r_data['id']);	?>" href="#registered-details"  data-toggle="modal">
													<?php  echo filter_var($label_language_values['bookings']);	?><span class="badge br-10"><?php echo filter_var($booking);	?></span>
												</a>
											
												
												<a data-id="<?php echo filter_var($r_data['id']);	?>" class="btn btn-danger col-sm-offset-1" data-toggle="popover" rel="popover" data-placement='left' title="Delete this customer?"><i class="fa fa-trash"></i> <?php  echo filter_var($label_language_values['delete']);	?></a>
												
												<div id="popover-delete-servicess" style="display: none;">
													<div class="arrow"></div>
													<table class="form-horizontal" cellspacing="0">
														<tbody>
														<tr>
															<td>
																<a data-id="<?php echo filter_var($r_data['id']);	?>" value="Delete" class="btn btn-danger btn-sm mybtndelete_register_customers_entry" ><?php echo filter_var($label_language_values['yes']);	?></a>
																<button id="ld-close-popover-customerss" class="btn btn-default btn-sm" href="javascript:void(0)"><?php echo filter_var($label_language_values['cancel']);	?></button>
															</td>
														</tr>
														</tbody>
													</table>
												</div>
												
											</td>
										</tr>
									<?php 
									
								}
								?>
								</tbody>
							</table>
							<div id="registered-details" class="modal fade booking-details-modal">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title"><?php echo filter_var($label_language_values['registered_customers_bookings']);	?></h4>
										</div>
										<div class="modal-body myregcust_modal">
											<div class="table-responsive">
												<table id="registered-client-booking-details_new" class="display table table-striped table-bordered" cellspacing="0" width="100%">
													<thead>
													<tr>
														<th style="width: 9px !important;">#</th>
														<th style="width: 67px !important;"><?php echo filter_var($label_language_values['cleaning_service']);	?></th>
														<th style="width: 44px !important;"><?php echo filter_var($label_language_values['booking_serve_date']);	?></th>
														<th style="width: 39px !important;"><?php echo filter_var($label_language_values['booking_status']);	?></th>
														<th style="width: 70px !important;"><?php echo filter_var($label_language_values['payment_method']);	?></th>
														<th style="width: 257px !important;"><?php echo filter_var($label_language_values['more_details']);	?></th>
													</tr>
													</thead>
													<tbody id="details_booking_display">
												  
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="guest-customers-listing" class="tab-pane fade">
						<h3><?php echo filter_var($label_language_values['guest_customers']);	?></h3>
						<div id="accordion" class="panel-group">
							<table id="guest-client-table" class="display responsive nowrap table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th><?php echo filter_var($label_language_values['client_name']);	?></th>
									<th><?php echo filter_var($label_language_values['email']);	?></th>
									<th><?php echo filter_var($label_language_values['phone']);	?></th>
									<th><?php echo filter_var($label_language_values['bookings']);	?></th>
								</tr>
								</thead>
								<tbody>
								<?php 
								$guest_user_data =  $user->read_all_guestuser();
								while($g_data = mysqli_fetch_array($guest_user_data)){
									?>
									<tr id="myguest_<?php  echo filter_var($g_data['order_id']);	?>">
										<td><?php if($g_data['client_name'] != ''){echo filter_var($g_data['client_name']);}else{echo filter_var('N/A');} ?></td>
										<td><?php echo filter_var($g_data['client_email']); ?></td>
										<td><?php if(strlen($g_data['client_phone'])>6){echo filter_var($g_data['client_phone']);}else{echo filter_var('N/A');} ?></td>
										<td class="ld-bookings-td">
											<a class="btn btn-primary myguestcust_bookings" data-email="<?php echo filter_var($g_data['client_email']; ?>" href="#guest-details" data-toggle="modal" data-id="<?php echo filter_var($g_data['order_id']);	?>">
												<?php  echo filter_var($label_language_values['bookings']);	?>
												
											</a>
											<a data-id="<?php echo filter_var($g_data['order_id']);	?>" class="btn btn-danger col-sm-offset-1 mybtndelete_guest_customers_entry"><i class="fa fa-trash"></i> <?php  echo filter_var($label_language_values['delete']);	?></a>
										</td>
									</tr>
								<?php 
								}
								?>
								</tbody>
							</table>
							<div id="guest-details" class="modal fade booking-details-modal">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title"><?php echo filter_var($label_language_values['guest_customers_bookings']);	?></h4>
										</div>
										<div class="modal-body">
											<div class="table-responsive">
												<table id="guest-client-booking-details_new" class="display responsive nowrap table table-striped table-bordered" cellspacing="0" width="100%">
													<thead>
													<tr>
														<th style="width: 9px !important;">#</th>
														<th style="width: 67px !important;"><?php echo filter_var($label_language_values['cleaning_service']);	?></th>
														<th style="width: 44px !important;"><?php echo filter_var($label_language_values['booking_serve_date']);	?></th>
														<th style="width: 39px !important;"><?php echo filter_var($label_language_values['booking_status']);	?></th>
														<th style="width: 70px !important;"><?php echo filter_var($label_language_values['payment_method']);	?></th>
														<th style="width: 257px !important;"><?php echo filter_var($label_language_values['more_details']);	?></th>
													</tr>
													</thead>
													<tbody id="details_booking_display_guest">
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
<?php 
include(dirname(__FILE__).'/footer.php');
?>