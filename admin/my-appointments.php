<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/admin_session_check.php');
include(dirname(dirname(__FILE__))  . "/objects/class_userdetails.php");
include(dirname(dirname(__FILE__))  . "/objects/class_booking.php");
include(dirname(dirname(__FILE__))  . '/objects/class_front_first_step.php');
include(dirname(dirname(__FILE__))."/objects/class_gc_hook.php");
include(dirname(dirname(__FILE__))."/objects/class_rating_review.php");
include(dirname(dirname(__FILE__))."/objects/class_services.php");
if(!isset($_SESSION['ld_login_user_id'])){
    header('Location:'.SITE_URL."admin/");
}
$con = new laundry_db();
$conn = $con->connect();
$objuserdetails = new laundry_userdetails();
$objuserdetails->conn = $conn;
$booking = new laundry_booking();
$booking->conn = $conn;
$setting = new laundry_setting();
$setting->conn = $conn;
$general=new laundry_general();
$general->conn=$conn;
$gc_hook = new laundry_gcHook();
$gc_hook->conn = $conn;
$first_step=new laundry_first_step();
$first_step->conn=$conn;
$rating_review = new laundry_rating_review();
$rating_review->conn = $conn;
$service= new laundry_services();
$service->conn=$conn;
$symbol_position=$setting->get_option('ld_currency_symbol_position');
$decimal=$setting->get_option('ld_price_format_decimal_places');
$getdateformat=$setting->get_option('ld_date_picker_date_format');
$time_format = $setting->get_option('ld_time_format');
$date_format=$setting->get_option('ld_date_picker_date_format');
$getmaximumbooking = $setting->get_option('ld_max_advance_booking_time');
?>

<div id="lda-user-appointments">
    <div class="panel-body">
        <div class="tab-content">
            <h4 class="header4"><?php echo filter_var($label_language_values['my_appointments']);	?>
			<a href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>" class="btn btn-success pull-right" target="_BLANK"><?php echo filter_var($label_language_values['book_appointment']);	?></a>
			</h4>
            <form>
                <div class="table-responsive">
                    <table id="user-profile-booking-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?php echo filter_var($label_language_values['order']);	?>#</th>
                            <th><?php echo filter_var($label_language_values['order_date']);	?></th>
                            <th><?php echo filter_var($label_language_values['order_time']);	?></th>
                            <th><?php echo filter_var($label_language_values['show_all_bookings']);	?></th>
                            <th><?php echo filter_var($label_language_values['actions']);	?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($_SESSION['ld_login_user_id'])){
                        $id = $_SESSION['ld_login_user_id'];
                        $objuserdetails->id = $id;
                        $details = $objuserdetails->get_user_details();
                        if(mysqli_num_rows($details) > 0){
						while($dd = mysqli_fetch_array($details)){
                            ?>
                            <tr>
                                <td><?php echo filter_var($dd['order_id']);	?></td>
                                <?php 
                                if($time_format == 12){
                                    ?>
                                    <td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($dd['booking_pickup_date_time_start'])));	?></td>
                                <?php 
                                }else{
                                    ?>
                                    <td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($dd['booking_pickup_date_time_start'])));	?></td>
                                <?php 
                                }
                                ?>
                                <?php 
                                if($time_format == 12){
                                    ?>
                                    <td>
									<?php echo str_replace($english_date_array,$selected_lang_label,date(" h:i A",strtotime($dd['booking_pickup_date_time_start'])));	?></td>
                                <?php 
                                }else{
                                    ?>
                                    <td><?php echo date(" H:i",strtotime($dd['booking_pickup_date_time_start']));	?></td>
                                <?php 
                                }
                                ?>
                                <td>
                                    <a href="#user-booking-details<?php  echo filter_var($dd['order_id']);	?>" data-toggle="modal" data-target="#user-booking-details<?php  echo filter_var($dd['order_id']);	?>" class="ld-my-booking-user btn btn-info myappointment_popup"><i class="fa fa-eye"></i><?php echo filter_var($label_language_values['my_appointments']);	?></a>
                                </td>
                                <td>
                                    <a target="_blank" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>/assets/lib/download_invoice_client.php?iid=<?php echo filter_var($dd['order_id']);	?>" class="btn btn-primary"><i class="fa fa-download"></i><?php echo filter_var($label_language_values['download_invoice']);	?></a>
									
									<?php    
									$rating_review->order_id = $dd['order_id'];
									$rating = $rating_review->select_one();

									$bt = date("Y-m-d H:i:s",strtotime($dd['booking_pickup_date_time_start']));
									$booking_status = $dd['booking_status'];
									if($dd['staff_ids']!='' && $rating == 0 && $booking_status == "CO"){
										
									?>
									
									<button type="button" class="btn btn-info" data-toggle="modal" data-id="<?php echo filter_var($dd['order_id']);	?>"  data-target="#rating_model<?php echo filter_var($dd['order_id']);	?>"><?php echo filter_var("Rating & Review"); ?></button>
<div class="modal fade" id="rating_model<?php echo filter_var($dd['order_id']);	?>" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?php echo filter_var("Rating & Review"); ?></h4>
			</div>
			<div class="modal-body">
				<input id="ratings<?php echo filter_var($dd['order_id']);	?>" name="ratings<?php echo filter_var($dd['order_id']);	?>" class="rating" data-min="0" data-max="5" data-step="0.1" value="0" />
				<br />
				<label class="control-label"><?php echo filter_var("Feedback & Review"); ?></label>
				<textarea class="form-control custom_textarea_feedback" id="review_note<?php echo filter_var($dd['order_id']);	?>" name="review_note<?php echo filter_var($dd['order_id']);	?>"></textarea>
				<br />
				<button type="button" data-staff_id="<?php echo filter_var($dd['staff_ids']); ?>" data-id="<?php echo filter_var($dd['order_id']);	?>" id="rating_review_submit" class="btn btn-success"><?php echo filter_var($label_language_values['submit']); ?></button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo filter_var($label_language_values['close']); ?></button>
			</div>
		</div>
	</div>
</div>
						<?php    }?>
                                </td>
                            </tr>
                        <?php 
                        }
                    	}
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php 
                $details = $objuserdetails->get_user_details();
							
                while($dd = mysqli_fetch_array($details)){
											$service_name = "";
											$service_ids = explode(",",$dd["service_id"]);
											
											$color = "";
											foreach($service_ids as $id){
													$service->id = $id;
													$result = $service->readone();
													$service_name .= $result["title"].","; 
											}
											$service_name = chop($service_name,","); 
											?>
                    <div id="user-booking-details<?php  echo filter_var($dd['order_id']);	?>" class="user-booking-details modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title"><?php echo filter_var($label_language_values['my_appointments']);	?></h4>
								</div>
								<div class="modal-body">
									<div class="table-responsive">
										<table id="user-all-bookings-details" class="table table-striped table-bordered responsive nowrap" cellspacing="0" width="100%">
											<thead>
											<tr >
												<th><?php echo filter_var($label_language_values['order']);	?>#</th>
												<th><?php echo filter_var($label_language_values['service']);	?></th>
												<th style="width: 140px;"><?php echo filter_var($label_language_values['booking_date_and_time']);	?></th>
												<th style="width: 230px;"><?php echo filter_var($label_language_values['more_details']);	?></th>
												<th><?php echo filter_var($label_language_values['status']);	?></th>
												<th><?php echo filter_var($label_language_values['actions']);	?></th>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td><?php echo filter_var($dd['order_id']);	?></td>
												<td><?php echo filter_var($service_name);	?></td>
												<?php 
												if($time_format == 12){
													?>
													<td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat." h:i A",strtotime($dd['booking_pickup_date_time_start'])));	?></td>
												<?php 
												}else{
													?>
													<td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat." H:i",strtotime($dd['booking_pickup_date_time_start'])));	?></td>
												<?php 
												}
												?>
												<td>
													<?php 
													/* methods */
													$units = "None";
													$hh = $booking->get_units_ofbookings($dd['order_id']);
													while($jj = mysqli_fetch_array($hh)){
														if($units == "None"){
															$units = $jj['unit_name']."-".$jj['unit_qty'];
														}
														else
														{
															$units = $units.",".$jj['unit_name']."-".$jj['unit_qty'];
														}
													}
													?>
													<b><?php echo filter_var($label_language_values['units']);	?></b> - <?php  echo filter_var($units);	?>
													<br>
												</td>
												<td class="txt-success"><?php
													if($dd['booking_status']=='A')
													{
													$booking_stats=$label_language_values['active'];
													}
													elseif($dd['booking_status']=='C')
													{
														$booking_stats='<i class="fa fa-check txt-success">'.$label_language_values['confirm'].'</i>';
													}
													elseif($dd['booking_status']=='R')
													{
														$booking_stats='<i class="fa fa-ban txt-danger">'.$label_language_values['reject'].'</i><br><b class="txt-danger">Reason : '.$dd['reject_reason'].'</b>';
													}
													elseif($dd['booking_status']=='RS')
													{
														$booking_stats='<i class="fa fa-pencil-square-o txt-info">'.$label_language_values["rescheduled"].'</i>';
													}
													elseif($dd['booking_status']=='CC')
													{
														$booking_stats='<i class="fa fa-times txt-primary">'.$label_language_values['cancel_by_client'].'</i>';
													}
													elseif($dd['booking_status']=='CS')
													{
														$booking_stats='<i class="fa fa-times-circle-o txt-info">'.$label_language_values['cancelled_by_service_provider'].'</i>';
													}
													elseif($dd['booking_status']=='CO')
													{
														$booking_stats='<i class="fa fa-thumbs-o-up txt-success">'.$label_language_values['completed'].'</i>';
													}
													else
													{
														$dd['booking_status']=='MN';
														$booking_stats='<i class="fa fa-thumbs-o-down txt-danger">'.$label_language_values['mark_as_no_show'].'</i>';
													}
													?>
													<?php  echo filter_var($booking_stats);	?>
												</td>
												<td>
													<?php   
													$t_zone_value = $setting->get_option('ld_timezone');
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
													$current_times = date('Y-m-d H:i:s',$currDateTime_withTZ);
                                                    $bt = date("Y-m-d H:i:s",strtotime($dd['booking_pickup_date_time_start']));
													$td = date('Y-m-d H:i:s',strtotime($current_times));
													if($bt<$td)
													{
														?>
														<a  class="btn btn-danger"  rel="popover"  ><i class="fa fa-check"></i><?php echo filter_var($label_language_values['completed']);	?></a>
													<?php 
													}
													else
													{
														if($dd['booking_status'] == 'A' || $dd['booking_status'] == 'C' || $dd['booking_status'] == 'RS'){
															$booking_start_datetime=strtotime(date('Y-m-d H:i:s',strtotime($dd['booking_pickup_date_time_start'])));
															$reschedule_buffer_time=$setting->get_option('ld_reshedule_buffer_time');
															$cancellation_buffer_time=$setting->get_option('ld_cancellation_buffer_time');
															$t_zone_value = $setting->get_option('ld_timezone');
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
															$current_times = date('Y-m-d H:i:s',$currDateTime_withTZ);
															$current_time = strtotime($current_times);
															$remain_times=$booking_start_datetime - $current_time;
															$time_in_min=round($remain_times / 60 );
															if($time_in_min > $reschedule_buffer_time){
																?>
																<a data-toggle="modal" href="javascript:void(0)" data-total_price="<?php echo filter_var($general->ld_price_format($dd['total_payment'],$symbol_position,$decimal));	?>" data-target="#update-user-booking-details<?php  echo filter_var($dd['order_id']);	?>"  class="btn btn-success display_myappointment_data" data-order_id="<?php echo filter_var($dd['order_id']);	?>"><i class="fa fa-repeat"></i><?php echo filter_var($label_language_values['reschedule']);	?></a>
															<?php 
															}else{
																if($booking_start_datetime > $current_time){
																	?>
																	<a href="javascript:void(0)" class="btn btn-success"><i class="fa fa-repeat"></i><?php echo filter_var($label_language_values['cannot_reschedule_now']);	?></a>
																<?php 
																}else{
																	echo filter_var('');
																}
															}
															?>
															<?php 
															if($time_in_min > $cancellation_buffer_time){
																?>
																<a id="ld-user-cancel-appointment<?php  echo filter_var($dd['order_id']);?>" data-id="<?php echo filter_var($dd['order_id']);	?>" class="btn btn-danger cancel_appointment"  rel="popover" data-placement='left' title="<?php echo filter_var($label_language_values['booking_cancel_reason']);	?>?"><i class="fa fa-ban"></i><?php echo filter_var($label_language_values['cancel']);	?></a>
															<?php 
															}else{
																if($booking_start_datetime > $current_time){
																	?>
																	<a class="btn btn-danger" href="javascript:void(0)"><i class="fa fa-ban"></i><?php echo filter_var($label_language_values['cannot_cancel_now']);	?></a>
																<?php 
																}else{
																	echo filter_var('');
																}
															}
															?>
															<div id="popover-user-cancel-appointment<?php  echo filter_var($dd['order_id']); ?>" style="display: none;">
																<div class="arrow"></div>
																<table class="form-horizontal" cellspacing="0">
																	<tbody>
																	<tr>
																		<td>
																			<textarea class="form-control" id="reason_cancel<?php  echo filter_var($dd['order_id']); ?>" name="" placeholder="<?php echo filter_var($label_language_values['booking_cancel_reason']);	?>" required="required" ></textarea>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<a data-id="<?php echo filter_var($dd['order_id']); ?>" data-gc_event="<?php echo filter_var($dd['gc_event_id']); ?>" data-gc_staff_event="<?php echo filter_var($dd['gc_staff_event_id']); ?>" data-pid="<?php echo filter_var($dd['staff_ids']); ?>" value="Delete" class="btn btn-danger btn-sm mybtncancel_booking_user_details"><?php echo filter_var($label_language_values['yes']);	?></a>
																			<a id="ld-close-user-cancel-appointment" class="btn btn-default btn-sm" href="javascript:void(0)"><?php echo filter_var($label_language_values['cancel']);	?></a>
																		</td>
																	</tr>
																	</tbody>
																</table>
															</div>
														<?php 
														}else{
															echo filter_var('');
														}
													}
													?>
												</td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
                    </div>
                <?php 
                }
                }
                ?>
                <?php 
                if(isset($_SESSION['ld_login_user_id'])){
                    $details = $objuserdetails->get_user_details();
                    while($dd = mysqli_fetch_array($details)){
                        ?>
                        <div id="update-user-booking-details<?php  echo filter_var($dd['order_id']);	?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="vertical-alignment-helper">
                                <div class="modal-dialog modal-md vertical-align-center">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title"><?php echo filter_var($label_language_values['appointment_details']);	?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade in active">
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="ld-service-duration"><?php echo filter_var($label_language_values['amount']);	?></label></td>
                                                            <td>
                                                                <div class="lda-col6 ld-w-50 ">
                                                                    <div class="form-control booking_total_payment" readonly="readonly">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="ld-service-duration"><?php echo filter_var($label_language_values['date_and_time']);	?></label></td>
                                                            <td>
                                                                <div class="lda-col6 ld-w-50">
                                                                    <?php  $dates = date("d-m-Y",strtotime($dd['booking_pickup_date_time_start']));
                                                                    $slot_timess = date('H:i',strtotime($dd['booking_pickup_date_time_start']));
																	
											$get_staff_id = $booking->get_staff_ids_from_bookings($dd['order_id']);	
											
											if($get_staff_id==""){
												$staff_id=1;
											}else{
												$staff_id = $get_staff_id;
											}
																	
                                                                    ?>
                                            <input class="exp_cp_date form-control" id="expiry_date<?php  echo filter_var($dd['order_id']);	?>" data-staffid="<?php echo filter_var($staff_id); ?>" value=	"<?php echo filter_var($dates);	?>" data-date-format="yyyy/mm/dd" data-provide="datepicker" />
                                                                   
                                </div>
                                <div class="lda-col6 ld-w-50 float-right mytime_slots_booking" style="display:none;">
                                    <?php 
                                    $t_zone_value = $setting->get_option('ld_timezone');
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
                                          $select_time=date('Y-m-d',strtotime($dates));
                                  $start_date = date($select_time,$currDateTime_withTZ);
                                  $time_interval = $setting->get_option('ld_time_interval');
                                  $time_slots_schedule_type = $setting->get_option('ld_time_slots_schedule_type');
                                  $advance_bookingtime = $setting->get_option('ld_min_advance_booking_time');
                                  $ld_service_padding_time_before = $setting->get_option('ld_service_padding_time_before');
                                  $ld_service_padding_time_after = $setting->get_option('ld_service_padding_time_after');
                                  $booking_padding_time = $setting->get_option('ld_booking_padding_time');
                                  $time_schedule = $first_step->get_day_time_slot_by_provider_id($time_slots_schedule_type,$start_date,$time_interval,$advance_bookingtime,$ld_service_padding_time_before,$ld_service_padding_time_after,$timezonediff,$booking_padding_time,$staff_id);
                                  $allbreak_counter = 0;
                                  $allofftime_counter = 0;
                                  $slot_counter = 0;
                                  ?>
                                  <select class="selectpicker mydatepicker_appointment   form-control" id="myuser_reschedule_time" data-size="10" style="" >
                                                                        <?php 
                             if($time_schedule['off_day']!=true && isset($time_schedule['slots']) && sizeof($time_schedule['slots'])>0 && $allbreak_counter != sizeof($time_schedule['slots']) && $allofftime_counter != sizeof($time_schedule['slots'])){
                                 foreach($time_schedule['slots']  as $slot) {
                               $ifbreak = 'N';
                                /* Need to check if the appointment slot come under break time. */
                              foreach($time_schedule['breaks'] as $daybreak) {
                                 if(strtotime($slot) >= strtotime($daybreak['break_start']) && strtotime($slot) < strtotime($daybreak['break_end'])) {
                                   $ifbreak = 'Y';
                                    }
                                }
                                /* if yes its break time then we will not show the time for booking  */
                                if($ifbreak=='Y') { $allbreak_counter++; continue; }
                                $ifofftime = 'N';
                                foreach($time_schedule['offtimes'] as $offtime) {
                                if(strtotime($dates.' '.$slot) >= strtotime($offtime['offtime_start']) && strtotime($dates.' '.$slot) < strtotime($offtime['offtime_end'])) {
                                    $ifofftime = 'Y';
                                           }
                                       }
                                    /* if yes its offtime time then we will not show the time for booking  */
                                  if($ifofftime=='Y') { $allofftime_counter++; continue; }
                                 	$complete_time_slot = mktime(date('H',strtotime($slot)),date('i',strtotime($slot)),date('s',strtotime($slot)),date('n',strtotime($time_schedule['date'])),date('j',strtotime($time_schedule['date'])),date('Y',strtotime($time_schedule['date'])));
                                     if($setting->get_option('ld_hide_faded_already_booked_time_slots')=='on' && in_array($complete_time_slot,$time_schedule['booked'])) {
                                           continue;
                                            }
                                    if( in_array($complete_time_slot,$time_schedule['booked']) && ($setting->get_option('ld_allow_multiple_booking_for_same_timeslot_status')!='Y') ) { ?>
                                      <?php 
                                      if($setting->get_option('ld_hide_faded_already_booked_time_slots')=="on"){
                                        ?>
                                        <option value="<?php echo date("H:i",strtotime($slot));	?>" <?php  if(date("H:i",strtotime($slot)) == $slot_timess){ echo filter_var("selected");}?> class="time-slot br-2 ld-booked" >
                                         <?php 
                                         if($setting->get_option('ld_time_format')==24){
                                              echo date("H:i",strtotime($slot));
                                              }else{
											echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($slot)));
                                              }?>
                                           </option>
                                             <?php 
                                              }
                                              ?>
                                          <?php 
                                          } else {
                                          if($setting->get_option('ld_time_format')==24){
                                           $slot_time = date("H:i",strtotime($slot));
                                            }else{
                                          $slot_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($slot)));
                                            }
                                            ?>
                                          <option value="<?php echo date("H:i",strtotime($slot));	?>" <?php  if(date("H:i",strtotime($slot)) == $slot_timess){ echo filter_var("selected");}?> class="time-slot br-2 <?php  if(in_array($complete_time_slot,$time_schedule['booked'])){ echo' ld-booked';}else{ echo filter_var(' time_slotss'); }?>" <?php  if(in_array($complete_time_slot,$time_schedule['booked'])){echo filter_var(''); }else{ echo 'data-slot_date_to_display="'.date($date_format,strtotime($dates)).'" data-slot_date="'.$dates.'" data-slot_time="'.$slot_time.'"'; } ?>><?php if($setting->get_option('ld_time_format')==24){echo date("H:i",strtotime($slot));}else{echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($slot)));}?></option>
                                              <?php 
                                              } $slot_counter++;
                                          }
                                          if($allbreak_counter == sizeof($time_schedule['slots']) && sizeof($time_schedule['slots'])!=0){ ?>
                                           <option  class="time-slot"><?php echo filter_var($label_language_values['sorry_not_available']);	?></option>
                                           <?php  }
                                       } else {?>
                                           <option class="time-slot"><?php echo filter_var($label_language_values['sorry_not_available']);	?></option>
                                                                        <?php  } ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        
                           <tr>
                               <td><label for="ld-service-duration"><?php echo filter_var($label_language_values['date_and_time']);	?></label></td>
                               <td>
                                   <div class="lda-col6 ld-w-50">
                                  <?php  $dates = date("d-m-Y",strtotime(isset($dd['booking_delivery_date_time_start']) ? $dd['booking_delivery_date_time_start'] : ''));
                                    $slot_timess = date('H:i',strtotime(isset($dd['booking_delivery_date_time_start']) ? $dd['booking_delivery_date_time_start'] : ''));

											$get_staff_id = $booking->get_staff_ids_from_bookings($dd['order_id']);	
											
											if($get_staff_id==""){
												$staff_id=1;
											}else{
												$staff_id = $get_staff_id;
											}
																	
                                                                    ?>
                                            <input class="exp_cp_dates form-control" id="expiry_dates<?php  echo filter_var($dd['order_id']);	?>" data-staffid="<?php echo filter_var($staff_id); ?>" value=	"<?php echo filter_var($dates);	?>" data-date-format="yyyy/mm/dd" data-provide="datepicker" />
                                                                   
                                </div>
                                <div class="lda-col6 ld-w-50 float-right mytime_slots_bookings" style="display:none;">
                                    <?php 
                                    $t_zone_value = $setting->get_option('ld_timezone');
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
                                          $select_time=date('Y-m-d',strtotime($dates));
                                  $start_date = date($select_time,$currDateTime_withTZ);
                                  $time_interval = $setting->get_option('ld_time_interval');
                                  $time_slots_schedule_type = $setting->get_option('ld_time_slots_schedule_type');
                                  $advance_bookingtime = $setting->get_option('ld_min_advance_booking_time');
                                  $ld_service_padding_time_before = $setting->get_option('ld_service_padding_time_before');
                                  $ld_service_padding_time_after = $setting->get_option('ld_service_padding_time_after');
                                  $booking_padding_time = $setting->get_option('ld_booking_padding_time');
                                  $time_schedule = $first_step->get_day_time_slot_by_provider_id($time_slots_schedule_type,$start_date,$time_interval,$advance_bookingtime,$ld_service_padding_time_before,$ld_service_padding_time_after,$timezonediff,$booking_padding_time,$staff_id);
                                  $allbreak_counter = 0;
                                  $allofftime_counter = 0;
                                  $slot_counter = 0;
                                  ?>
                                  <select class="selectpicker mydatepicker_appointment   form-control" id="myuser_reschedule_time" data-size="10" style="" >
                                                                        <?php 
                             if($time_schedule['off_day']!=true && isset($time_schedule['slots']) && sizeof($time_schedule['slots'])>0 && $allbreak_counter != sizeof($time_schedule['slots']) && $allofftime_counter != sizeof($time_schedule['slots'])){
                                 foreach($time_schedule['slots']  as $slot) {
                               $ifbreak = 'N';
                                /* Need to check if the appointment slot come under break time. */
                              foreach($time_schedule['breaks'] as $daybreak) {
                                 if(strtotime($slot) >= strtotime($daybreak['break_start']) && strtotime($slot) < strtotime($daybreak['break_end'])) {
                                   $ifbreak = 'Y';
                                    }
                                }
                                /* if yes its break time then we will not show the time for booking  */
                                if($ifbreak=='Y') { $allbreak_counter++; continue; }
                                $ifofftime = 'N';
                                foreach($time_schedule['offtimes'] as $offtime) {
                                if(strtotime($dates.' '.$slot) >= strtotime($offtime['offtime_start']) && strtotime($dates.' '.$slot) < strtotime($offtime['offtime_end'])) {
                                    $ifofftime = 'Y';
                                           }
                                       }
                                    /* if yes its offtime time then we will not show the time for booking  */
                                  if($ifofftime=='Y') { $allofftime_counter++; continue; }
                                 	$complete_time_slot = mktime(date('H',strtotime($slot)),date('i',strtotime($slot)),date('s',strtotime($slot)),date('n',strtotime($time_schedule['date'])),date('j',strtotime($time_schedule['date'])),date('Y',strtotime($time_schedule['date'])));
                                     if($setting->get_option('ld_hide_faded_already_booked_time_slots')=='on' && in_array($complete_time_slot,$time_schedule['booked'])) {
                                           continue;
                                            }
                                    if( in_array($complete_time_slot,$time_schedule['booked']) && ($setting->get_option('ld_allow_multiple_booking_for_same_timeslot_status')!='Y') ) { ?>
                                      <?php 
                                      if($setting->get_option('ld_hide_faded_already_booked_time_slots')=="on"){
                                        ?>
                                        <option value="<?php echo date("H:i",strtotime($slot));	?>" <?php  if(date("H:i",strtotime($slot)) == $slot_timess){ echo filter_var("selected");}?> class="time-slot br-2 ld-booked" >
                                         <?php 
                                         if($setting->get_option('ld_time_format')==24){
                                              echo date("H:i",strtotime($slot));
                                              }else{
											echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($slot)));
                                              }?>
                                           </option>
                                             <?php 
                                              }
                                              ?>
                                          <?php 
                                          } else {
                                          if($setting->get_option('ld_time_format')==24){
                                           $slot_time = date("H:i",strtotime($slot));
                                            }else{
                                          $slot_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($slot)));
                                            }
                                            ?>
                                          <option value="<?php echo date("H:i",strtotime($slot));	?>" <?php  if(date("H:i",strtotime($slot)) == $slot_timess){ echo filter_var("selected");}?> class="time-slot br-2 <?php  if(in_array($complete_time_slot,$time_schedule['booked'])){ echo' ld-booked';}else{ echo filter_var(' time_slotss'); }?>" <?php  if(in_array($complete_time_slot,$time_schedule['booked'])){echo filter_var(''); }else{ echo 'data-slot_date_to_display="'.date($date_format,strtotime($dates)).'" data-slot_date="'.$dates.'" data-slot_time="'.$slot_time.'"'; } ?>><?php if($setting->get_option('ld_time_format')==24){echo date("H:i",strtotime($slot));}else{echo str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($slot)));}?></option>
                                              <?php 
                                              } $slot_counter++;
                                          }
                                          if($allbreak_counter == sizeof($time_schedule['slots']) && sizeof($time_schedule['slots'])!=0){ ?>
                                           <option  class="time-slot"><?php echo filter_var($label_language_values['sorry_not_available']);	?></option>
                                           <?php  }
                                       } else {?>
                                           <option class="time-slot"><?php echo filter_var($label_language_values['sorry_not_available']);	?></option>
                                                                        <?php  } ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                        $userinfo =  $objuserdetails->get_user_notes($dd['order_id']);
                                                        $temppp= unserialize(base64_decode($userinfo[0]));
                                                        $tem = str_replace('\\','',$temppp);
                                                        $finalnotes = $tem['notes'];
                                                        ?>
                                                        <tr>
                                                            <td><?php echo filter_var($label_language_values['notes']);	?></td>
                                                            <td><textarea class="form-control my_user_notes_reschedule<?php  echo filter_var($dd['order_id']);	?>"><?php echo filter_var($finalnotes);	?></textarea></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="lda-col12 ld-footer-popup-btn">
                                                <div class="lda-col6">
													<button type="button" data-order="<?php echo filter_var($dd['order_id']);	?>" class="btn btn-info my_user_btn_for_reschedule" data-gc_event="<?php echo filter_var($dd['gc_event_id']); ?>" data-gc_staff_event="<?php echo filter_var($dd['gc_staff_event_id']); ?>" data-pid="<?php echo filter_var($dd['staff_ids']); ?>"><?php echo filter_var($label_language_values['update_appointment']);	?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php  }
                }
                ?>
        </div>
        </form>
    </div>
</div>
<?php 
if($gc_hook->gc_purchase_status() == 'exist'){
	if($setting->get_option('ld_gc_status_configure') == 'Y' && $setting->get_option('ld_gc_status') == 'Y') {
		?>
		<input type="hidden" id="extension_js" value="true" />
		<?php 
	} else {
		?>
		<input type="hidden" id="extension_js" value="false" />
        <?php 
	}
}
include(dirname(__FILE__).'/footer.php');
?>		
	