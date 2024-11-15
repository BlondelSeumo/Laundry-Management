<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1); 
include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/user_session_check.php');
$setting = new laundry_setting();
$setting->conn = $conn;
$gettimeformat=$setting->get_option('ld_time_format');
?>

<div id="ld-calendar-all">
	<div class="ld-legends-panel-body">
        <div class="ld-legends-main">
			<div class="ld-legends-inner">
				<ul class="list-inline nm">
					<li><h4><?php  echo filter_var($label_language_values['legends']);	?>:</h4></li>
					<li><i class="fa fa-thumbs-o-up txt-completed"></i><?php  echo filter_var($label_language_values['completed']);	?></li>
					<li><i class="fa fa-check txt-success"></i><?php  echo filter_var($label_language_values['confirmed']);	?></li>
					<li><i class="fa fa-pencil-square-o txt-info"></i> <?php    echo filter_var($label_language_values['rescheduled']);	?></li>
					<li><i class="fa fa-ban txt-danger"></i> <?php    echo filter_var($label_language_values['rejected']);	?></li>
					<li><i class="fa fa-times txt-primary"></i> <?php    echo filter_var($label_language_values['cancelled_by_client']);	?></li>
					<li><i class="fa fa-info-circle txt-warning"></i><?php  echo filter_var($label_language_values['pending']);	?></li>
			   </ul>
			</div>
		</div>
	</div>
	
	<div id="calendar" class="ld-booking-calendar"></div>

	
<div id="booking-details-calendar" class="modal fade booking-details-calendar" tabindex="-1" role="dialog" aria-hidden="true"> 
		<div class="vertical-alignment-helper">
			<div class="modal-dialog modal-md vertical-align-center">
				<div class="modal-content">
					<div class="modal-header">
					
						<button type="button" id="info_modal_close" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title"><?php  echo filter_var($label_language_values['booking_details']);	?></h4>
					</div>
					<div class="modal-body mb-20">
						<ul class="list-unstyled ld-cal-booking-details">
							<li>
								<label style="width: 120px; margin-right: 0;"><?php  echo filter_var($label_language_values['booking_status']);	?></label>
								<div class="ld-booking-status"></div>
							</li>
							<li>
									<label><?php  echo filter_var($label_language_values['self_service']);	?></label>
									<span class="self-service-html span-scroll"></span>
							</li>
							<li>
								<label><?php  echo filter_var($label_language_values['pickup']); ?></label>
								<i class="fa fa-calendar pull-left mt-2"></i><span class="pickup_starttime pull-left"></span> &nbsp;<i class="fa fa-clock-o ml-10 mt-2 pull-left"></i><span class="pickup_start_time"></span>
							</li>
							<li class="delivery_date">
								<label><?php  echo filter_var($label_language_values['delivery']); ?></label>
								<i class="fa fa-calendar pull-left mt-2"></i><span class="delivery_starttime pull-left"></span> &nbsp;<i class="fa fa-clock-o ml-10 mt-2 pull-left"></i><span class="delivery_start_time"></span>
							</li>
							<li>
									<label><?php  echo filter_var($label_language_values['service']);	?></label>
									<span class="service-html span-scroll"></span>
							</li>
							<li>
									<label><?php  echo filter_var($label_language_values['articles']);	?></label>
									<span class="units-html span-scroll"></span>
							</li>
							<li>
								<label><?php  echo filter_var($label_language_values['price']);	?></label>
								<span class="price span-scroll"></span>
							</li>
							
							<li class="edit_customer_detail">
								<h6 class="ld-customer-details-hr"><?php  echo filter_var($label_language_values['customer']);	?></h6>
								<div class="edit_customer_div"></div>
							</li>
							<li>
								<label><?php  echo filter_var($label_language_values['name']);	?></label>
								<span class="client_name span-scroll"></span>
							</li>
							<li>
								<label><?php  echo filter_var($label_language_values['email']);	?></label>
								<span class="client_email span-scroll"></span>
							</li>
							<li>
								<label><?php  echo filter_var($label_language_values['phone']);	?></label>
								<span class="client_phone span-scroll"></span>
							</li>
							
							 <li>
                                <label><?php  echo filter_var($label_language_values['company_address']);	?></label>
                                <span class="client_address span-scroll"></span>
                            </li>
                            <li>
                                <label><?php  echo filter_var($label_language_values['payment']);	?></label>
                                <span class="client_payment span-scroll"></span>
                            </li>
                            <li class="li_of_notes">
                                <label><?php  echo filter_var($label_language_values['notes']);	?></label>
                                <span class="notes span-scroll"></span>
                            </li>
							<li class="li_of_reason">
                                <label><?php echo filter_var($label_language_values['reason']);	?></label>
                                <span class="reason span-scroll"></span>
                            </li>
							<?php    if($setting->get_option("ld_company_willwe_getin_status") == "Y") { ?>
                            <li>
                                <label><?php  echo filter_var($label_language_values['contact_status']);	?></label>
                                <span class="contact_status span-scroll"></span>
                            </li>
							<?php    } ?>
							<hr>
							<li>
                                <label class="assign-app-staff"><?php  echo filter_var($label_language_values['assign_appointment_to_staff']);	?></label>
                                <span class="staff_list span-scroll-staff"></span>
                            </li>
							
						</ul>
					</div>
					
					<div class="modal-footer">
						<div class="col-xs-12 np ld-footer-popup-btn text-center">

							<div class="fln-mrat-dib">
								<span class="col-xs-4 pr-70 ld-w-32 mycompleteclass">
									<a id="ld-complete-appointment" class="btn btn-link ld-small-btn confirm_book ld-complete-appointment-cal" data-id="" title="<?php  echo filter_var($label_language_values['complete_appointment']);	?>"><i class="fa fa-thumbs-up fa-2x"></i><br /><?php  echo filter_var($label_language_values['complete']);	?></a>
								</span>
								<span class="col-xs-4 np ld-w-32 myconfirmclass">
									<a id="ld-confirm-appointment" class="btn btn-link ld-small-btn confirm_book ld-confirm-appointment-cal" data-id="" title="<?php  echo filter_var($label_language_values['confirm_appointment']);	?>"><i class="fa fa-check fa-2x"></i><br /><?php  echo filter_var($label_language_values['confirm']);	?></a>
								</span>
								<span class="col-xs-4 np ld-w-32 myconfirmclass">
									<a id="ld-reschedual-appointment" class="btn btn-link ld-small-btn rescedual_book ld-reschedual-appointment-cal" data-id="" title="<?php    echo filter_var($label_language_values['rescheduled']);	?>" ><i class="fa fa-pencil-square-o fa-2x"></i><br /><?php    echo filter_var($label_language_values['rescheduled']);	?></a>
								</span>
								<span class="col-xs-4 np ld-w-32 myrejectclass">
									<a id="ld-reject-appointment-cal-popup" data-id="" class="btn btn-link ld-small-btn book_rejct" data-bkid="" rel="popover" data-placement='top' title="<?php  echo filter_var($label_language_values['reject_reason']);	?>?"><i class="fa fa-thumbs-o-down fa-2x"></i><br /><?php  echo filter_var($label_language_values['reject']);	?></a>
									<div id="popover-reject-appointment-cal-popup" class="reject_book" style="display: none;">
										<div class="arrow"></div>
										<table class="form-horizontal" cellspacing="0">
											<tbody>
											<tr>
												<td><textarea class="form-control reject_rea_appt" id="reason_reject" name="" placeholder="<?php  echo filter_var($label_language_values['appointment_reject_reason']);	?>" required="required" ></textarea></td>
											</tr>
											<tr>
												<td>
													<button id="reject_appt" data-gc_event="" data-pid="" data-gc_staff_event="" value="Delete" class="btn btn-danger btn-sm reject_bookings" data-id="" type="submit"><?php  echo filter_var($label_language_values['reject']);	?></button>
													<button id="ld-close-reject-appointment-cal-popup" class="btn btn-default btn-sm" href="javascript:void(0)"><?php  echo filter_var($label_language_values['cancel']);	?></button>
												</td>
											</tr>
											</tbody>
										</table>
									</div>
								</span>
								<span class="col-xs-4 np ld-w-32">
									<a id="ld-delete-appointment-cal-popup" class="ld-delete-appointment-cal-popup pull-left btn btn-link ld-small-btn book_cancel" data-id="" data-bkid="" rel="popover" data-placement='top' title="<?php  echo filter_var($label_language_values['delete_this_appointment']);	?>?"><i class="fa fa-trash-o fa-2x"></i><br /> <?php    echo filter_var($label_language_values['delete']);	?></a>
								</span>	
								<div id="popover-delete-appointment-cal-popup" class="popup_display_cancel" style="display: none;">
									<div class="arrow"></div>
									<table class="form-horizontal" cellspacing="0">
										<tbody>
											<tr>
												<td>
													<button id="delete_appt" value="Delete" data-id="" data-gc_event="" data-pid="" data-gc_staff_event="" class="btn btn-danger btn-sm delete_bookings delete_bookings_dash" type="submit"><?php  echo filter_var($label_language_values['delete']);	?></button>
													<button id="ld-close-del-appointment-cal-popup" class="btn btn-default btn-sm" href="javascript:void(0)"><?php  echo filter_var($label_language_values['cancel']);	?></button>
												</td>
											</tr>
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
		
		<div class="ld-new-customer-image-popup-view">
			<div id="ld-image-upload-popup" class="modal fade" tabindex="-1" role="dialog">
				<div class="vertical-alignment-helper">
					<div class="modal-dialog modal-md vertical-align-center">
						<div class="modal-content">
							<div class="modal-header">
								<div class="col-md-12 col-xs-12">
									<button type="submit" class="btn btn-success"><?php  echo filter_var($label_language_values['crop_and_save']);	?></button>
									<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php  echo filter_var($label_language_values['cancel']);	?></button>
								</div>	
							</div>
							<div class="modal-body">
								<img id="ld-preview-img" />
							</div>
							<div class="modal-footer">
								<div class="col-md-12 np">
									<div class="col-md-4 col-xs-12">
										<label class="pull-left"><?php  echo filter_var($label_language_values['file_size']);	?></label> <input type="text" class="form-control" id="filesize" name="filesize" />
									</div>	
									<div class="col-md-4 col-xs-12">	
										<label class="pull-left">H</label> <input type="text" class="form-control" id="h" name="h" /> 
									</div>
									<div class="col-md-4 col-xs-12">	
										<label class="pull-left">W</label> <input type="text" class="form-control" id="w" name="w" />
									</div>
								</div>
							</div>							
						</div>		
					</div>			
				</div>			
			</div>	
		</div>			
		<div id="add-new-booking" class="modal fade ld-manual-booking-modal">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">						
					<div class="modal-header">
						<button type="button" id="info_modal_close" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
						<h4 class="modal-title"><?php  echo filter_var($label_language_values['Add_Manual_booking']);	?></h4>
					</div>
					<div class="modal-body">
						<?php    
						include_once(dirname(dirname(__FILE__)).'/manual_booking.php');
						?>
					</div>
					<div class="modal-footer cb">
						<button type="button" class="btn btn-warning" data-dismiss="modal"><?php  echo filter_var($label_language_values['cancel']);	?></button>
					</div>
				</div>
			</div>
		</div>
</div>
<?php    
	include(dirname(__FILE__).'/footer.php');
?>
<script>
	var ajax_url = '<?php  echo filter_var(AJAX_URL, FILTER_VALIDATE_URL);	?>';
	var base_url = '<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>';
	var calObj={'ajax_url':'<?php  echo filter_var(AJAX_URL, FILTER_VALIDATE_URL);	?>'};
	var times={'time_format_values':'<?php  echo filter_var($gettimeformat);	?>'};
	var siteurlObj = {'site_url':'<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>'};
</script>