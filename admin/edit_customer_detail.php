<?php   
include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/user_session_check.php');
include(dirname(dirname(__FILE__)).'/objects/class_users.php');
include(dirname(dirname(__FILE__)).'/objects/class_order_client_info.php');
include(dirname(dirname(__FILE__)).'/objects/class_booking.php');
include(dirname(dirname(__FILE__))."/objects/class_adminprofile.php");	
$database=new laundry_db();
$conn=$database->connect();
$user=new laundry_users();
$order_client_info=new laundry_order_client_info();
$user->conn=$conn;
$order_client_info->conn=$conn;
$booking = new laundry_booking();
$booking->conn = $conn;
$objadminprofile = new laundry_adminprofile();
$objadminprofile->conn = $conn;
if(isset($_GET['id'])){
      $customer_id =  $_GET['id'];
}
$user->user_id = $customer_id;
$customer_detail =  $user->get_client_details();
$time_format = $setting->get_option('ct_time_format');
?>
<div class="container">
	<div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h1 class="panel-title"><?php echo "Edit Customer Detail"; ?></h1>
            </div>
			<div class="panel-body">
				<form class="edit_new_user_add edit_ocean" id="edit_new_user_add">
      				<div class="row">
      					<div class="col-md-6 col-sm-6 col-sm-6 col-xs-12 mt-10">
							<label class="control-label"><?php echo $label_language_values['preferred_email'];?></label>
							<input type="email"   value="<?php echo $customer_detail['user_email'] ?>"id="admin_cus_edit_email" name="admin_cus_edit_email" placeholder="Your valid email address" class="form-control">
						</div>
      					<div class="col-md-6 col-sm-6 col-sm-6 col-xs-12 mt-10">
      						<label class="control-label"><?php echo $label_language_values['preferred_password'];?></label>
      						<input type="password" readonly id="admin_cus_edit_pwd" value="<?php echo $customer_detail['user_pwd']; ?>" name="admin_cus_edit_pwd" placeholder="" class="form-control">
      					</div>
      				</div>
      				<div class="row">
      					<div class="col-md-6 col-sm-6 col-sm-6 col-xs-12 mt-10">
      						<label class="control-label"><?php echo $label_language_values['first_name'];?></label>
      						<input type="text" value="<?php echo $customer_detail['first_name']; ?>" id="admin_cus_edit_fstnm" name="admin_cus_edit_fstnm" placeholder="" class="form-control">
      					</div>
      					<div class="col-md-6 col-sm-6 col-sm-6 col-xs-12 mt-10">
      						<label class="control-label"><?php echo $label_language_values['last_name'];?></label>
      						<input type="text" value="<?php echo $customer_detail['last_name']; ?>" id="admin_cus_edit_lstnm" name="admin_cus_edit_lstnm" placeholder="" class="form-control">
      					</div>
      				</div>
					<div class="row">
      					<div class="col-md-4 col-sm-4 col-sm-4 col-xs-12 mt-10">
      						<label class="control-label"><?php echo $label_language_values['phone'];?></label>
      						<input type="text" value="<?php echo $customer_detail['phone']; ?>" id="admin_cus_edit_phone" name="admin_cus_edit_phone" placeholder="" class="form-control">
      					</div>
      					<div class="col-md-4 col-sm-4 col-sm-4 col-xs-12 mt-10">
      						<label class="control-label"><?php echo $label_language_values['zip'];?></label>
      						<input type="text" value="<?php echo $customer_detail['zip']; ?>" id="admin_cus_edit_zip" name="admin_cus_edit_zip" placeholder="" class="form-control">
      					</div>
						<div class="col-md-4 col-sm-4 col-sm-4 col-xs-12 mt-10">
      						<label class="control-label"><?php echo $label_language_values['address'];?></label>
      						<input type="text" value="<?php echo $customer_detail['address']; ?>" id="admin_cus_edit_add" name="admin_cus_edit_add" placeholder="" class="form-control">
      					</div>
      				</div>
					<div class="row">
      					<div class="col-md-4 col-sm-4 col-sm-4 col-xs-12 mt-10">
      						<label class="control-label"><?php echo $label_language_values['city'];?></label>
      						<input type="text" value="<?php echo $customer_detail['city']; ?>" id="admin_cus_edit_city" name="admin_cus_edit_city" placeholder="" class="form-control">
      					</div>
      					<div class="col-md-4 col-sm-4 col-sm-4 col-xs-12 mt-10">
      						<label class="control-label"><?php echo $label_language_values['state'];?></label>
      						<input type="text" value="<?php echo $customer_detail['state']; ?>" id="admin_cus_edit_state" name="admin_cus_edit_state" placeholder="" class="form-control">
      					</div>
						<div class="col-md-4 col-sm-4 col-sm-4 col-xs-12 mt-10">
      						<label class="control-label"><?php echo $label_language_values['notes'];?></label>
      						<input type="text" value="<?php echo $customer_detail['notes']; ?>" id="admin_cus_edit_notes" name="admin_cus_edit_notes" placeholder="" class="form-control">
      					</div>
      				</div>
					<div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-id="<?php echo $_GET['id']; ?>" data-order_id="" id="new_cus_edit_add_admin"><?php echo $label_language_values['save'];?></button>
                        <button type="button" class="btn btn-default" onclick="history.back();"><?php echo "Back";?></button>
                    </div> 
						<div class="table-responsive">
							<table id="registered-client-booking-details_new" class="display table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th style="width: 9px !important;">#</th>
									<th style="width: 67px !important;"><?php echo 'Cleaning Service';?></th>
									<th style="width: 44px !important;"><?php echo 'Booking Serve Date';?></th>
									<th style="width: 39px !important;"><?php echo 'Booking Status';?></th>
									<th style="width: 70px !important;"><?php echo 'Payment Method';?></th>
									<th style="width: 170px !important;"><?php echo 'Staff Booking Status';?></th>
								</tr>
								</thead>
								<tbody> <?php 
									$user->user_id = $customer_id;
									$clientinfo = $user->readone();
									$client_id = $clientinfo[0];
									/* get all bookings of the selected client */
									$clientbooking = $user->get_user_all_bookings();
									$cnti = 1;
									while($cc = mysqli_fetch_array($clientbooking)){
										if($cc['booking_status']=='A')
										{
											$booking_stats=$label_language_values['active'];
										}
										elseif($cc['booking_status']=='C')
										{
											$booking_stats=$label_language_values['confirm'];
										}
										elseif($cc['booking_status']=='R')
										{
											$booking_stats=$label_language_values['reject'];
										}
										elseif($cc['booking_status']=='RS')
										{
											$booking_stats=$label_language_values["rescheduled"];
										}
										elseif($cc['booking_status']=='CC')
										{
											$booking_stats=$label_language_values['cancel_by_client'];
										}
										elseif($cc['booking_status']=='CS')
										{
											$booking_stats=$label_language_values['cancelled_by_service_provider'];
										}
										elseif($cc['booking_status']=='CO')
										{
											$booking_stats=$label_language_values['completed'];
										}
										else
										{
											$cc['booking_status']=='MN';
											$booking_stats=$label_language_values['mark_as_no_show'];
										}
										   ?>
										<tr>
											<td><?php echo $cnti;?></td>
											<td><?php
												$s_name = [];
												$services = $user->get_booking_service_name($cc['order_id']);
												while($service = mysqli_fetch_array($services)){
													$s_name[] = $service['sname'];
												}
												echo implode(', ', $s_name);
											?></td>
										   <?php 
											if($time_format == 12){
											?>
											<td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat." h:i A",strtotime($cc['booking_delivery_date_time_start'])));?></td>
											<?php 
											}else{
											?>
											<td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat." H:i",strtotime($cc['booking_delivery_date_time_start'])));?></td>
											<?php 
											}
											?>
											<td><?php echo $booking_stats;?></td>
											<td><?php  if($cc['pna'] != 0){ echo $cc['c_payment_method'];} else { echo "Free";};?></td>
											<!-- <td>
												<?php 
												/* methods */
												/* $units = $label_language_values['none'];
												$methodname=$label_language_values['none']; */
												/* $hh = $booking->get_methods_ofbookings($cc['order_id']);
												$count_methods = mysqli_num_rows($hh);
												$hh1 = $booking->get_methods_ofbookings($cc['order_id']);
												if($count_methods > 0){
													while($jj = mysqli_fetch_array($hh1)){
														if($units == $label_language_values['none']){
															$units = $jj['units_title']."-".$jj['qtys'];
														}
														else
														{
															$units = $units.",".$jj['units_title']."-".$jj['qtys'];
														}
														$methodname = $jj['method_title'];
													}
												} */
												/* $addons = $label_language_values['none'];
												$hh = $booking->get_addons_ofbookings($cc['order_id']);
												while($jj = mysqli_fetch_array($hh)){
													if($addons == $label_language_values['none']){
														$addons = $jj['addon_service_name']."-".$jj['addons_service_qty'];
													}
													else
													{
														$addons = $addons.",".$jj['addon_service_name']."-".$jj['addons_service_qty'];
													}
												} */
												?>
												
											</td> -->
											<td> 
											<?php  
											
											$booking->order_id = $cc['order_id'];
											$staff_status_detail = $booking->staff_status_read_one_by_or_id();
											if(mysqli_num_rows($staff_status_detail) > 0){
												while($row = mysqli_fetch_assoc($staff_status_detail)){
													$objadminprofile->id = $row['staff_id'];
													$result_staff_info = $objadminprofile->readone();
													
													?>
													
													<b><?php  echo $result_staff_info['fullname'];?></b> - <?php  if($row['status']=='A'){echo $label_language_values['accept'];}else{echo $label_language_values['decline'];}?> <br>
													
													<?php  
													
												}
											}
											/* if($booking_details['staff_ids'] != ""){
												for($i=0;$i<sizeof((array)$staff_ids);$i++){
													$objadminprofile->id = $staff_ids[$i];
													$result_staff_info = $objadminprofile->readone();
													$booking->staff_id = $staff_ids[$i];
													$staff_status_details = $booking->staff_status_read_one_by_or_id();
													?>
													
													<b><?php  echo $result_staff_info['fullname'];?></b> - <?php  if($staff_status_details['status']=='A'){echo $label_language_values['accept'];}else{echo $label_language_values['decline'];}?> <br>
													
													<?php  
												}s
											} */
											?>
										</tr>
									<?php 
									$cnti++;}?>
								</tbody>
							</table>
						</div>
				</form>
			</div>
        </div>
	</div>
</div>
	
<?php  
include(dirname(__FILE__).'/footer.php');
?>