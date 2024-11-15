<?php  

	include(dirname(__FILE__).'/header.php');
	include(dirname(__FILE__).'/user_session_check.php');
	include (dirname(dirname(__FILE__)).'/objects/class_users.php');
	include (dirname(dirname(__FILE__)).'/objects/class_services.php');
	include (dirname(dirname(__FILE__)).'/objects/class_booking.php');
	include (dirname(dirname(__FILE__)).'/objects/class_services_methods_units.php');
	
	$con = new laundry_db();
	$conn = $con->connect();
	$users = new laundry_users();
	$users->conn = $conn;
	$objservice = new laundry_services();
	$objservice->conn = $conn;
	$booking = new laundry_booking();
	$booking->conn = $conn;	
	$service_unit = new laundry_services_methods_units();
	$service_unit->conn = $conn;
?>
<div id="lda-export-details" class="panel tab-content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h1 class="panel-title"><?php echo filter_var($label_language_values['export_your_details']);	?></h1>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#booking-info-export"><?php echo filter_var($label_language_values['booking_information']);	?></a></li>
				<li><a data-toggle="tab" href="#staff-info-export"><?php echo filter_var($label_language_values['customer_information']);	?></a></li>
				<li><a data-toggle="tab" href="#services-info-export"><?php echo filter_var($label_language_values['services_information']);	?></a></li>
				
			</ul>
			
			<div class="tab-content">
				
				<div id="booking-info-export" class="tab-pane fade in active">
					<h3><?php echo filter_var($label_language_values['booking_information']);	?></h3>
					<div id="accordion" class="panel-group">
						
						<form id="" name="" class="" method="post">
							
				
							<hr id="hr" />
							<div class="table-responsive">
								<table id="booking-info-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>	
											<th>#</th>
											<th><?php echo filter_var($label_language_values['service']);	?></th>
											<th><?php echo filter_var($label_language_values['order_date']);	?></th>
											<th><?php echo filter_var($label_language_values['app_date']);	?></th>
											<th><?php echo filter_var($label_language_values['customer']);	?></th>
											<th><?php echo filter_var($label_language_values['phone']);	?></th>
											<th><?php echo filter_var($label_language_values['address']);	?></th>
											<th><?php echo filter_var($label_language_values['status']);	?></th>
											<th><?php echo filter_var($label_language_values['more']);	?></th>
										</tr>
									</thead>
									<tbody>
									<?php 
									$display_booking = $booking->get_all_bookings();
									$i = 1;
									while($row2=mysqli_fetch_array($display_booking)){
									  $service_ids = explode(",",$row2["service_id"]);
										$service_name = "";
										$color = "";
										foreach($service_ids as $id){
												$objservice->id = $id;
												$result = $objservice->readone();
												@$service_name .= $result["title"].","; 
												@$color=$result['color'];
										}
										$title = chop($service_name,","); 
								
										/* $users->id=$row2['client_id']; */
										$display_det_client=$users->get_client_info($row2['order_id']);
										
										if($row2['booking_status']=='A'){
											$booking_stats=$label_language_values['active'];
										}elseif($row2['booking_status']=='C'){
											$booking_stats=$label_language_values['confirm'];
										}elseif($row2['booking_status']=='R'){
											$booking_stats=$label_language_values['reject'];
										}elseif($row2['booking_status']=='RS'){
											$booking_stats=$label_language_values["rescheduled"];
										}elseif($row2['booking_status']=='CC'){
											$booking_stats=$label_language_values['cancel_by_client'];
										}elseif($row2['booking_status']=='CS'){
											$booking_stats=$label_language_values['cancelled_by_service_provider'];
										}elseif($row2['booking_status']=='CO'){
											$booking_stats=$label_language_values['completed'];
										}else{
											$row2['booking_status']=='MN';
											$booking_stats=$label_language_values['mark_as_no_show'];
										}
									?>
										<tr>	
											<td><?php echo filter_var($i);	?></td>
											<td><?php echo filter_var($title); ?></td>
											<td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($row2['order_date']))); ?></td>
											<td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($row2['booking_pickup_date_time_start']))); ?></td>
											<td>
											<?php 
											$ccnames = explode(" ",$display_det_client[2]);
											$cnamess = array_filter($ccnames);
											$client_name = array_values($cnamess);
											if(sizeof($client_name)>0){
												if($client_name[0]!=""){ 	
													$client_first_name =  $client_name[0];
												}else{
													$client_first_name = "";
													if(!isset($client_name[1]) || $client_name[1]==""){ 	
														$client_first_name =  'N/A'; 
													}
												} 
												
												if(isset($client_name[1]) && $client_name[1]!=""){ 	
													$client_last_name =  $client_name[1]; 
												}else{
													$client_last_name = "";
												} 
											}else{
												$client_first_name = "N/A";
												$client_last_name = "";
											}
											$client_name = $client_first_name.' '.$client_last_name;
											echo filter_var($client_name);
											?>
											</td>
											<td><?php $fetch_phone =  strlen($display_det_client[4]); if($fetch_phone >= 6){ echo filter_var($display_det_client[4]); }else{ echo filter_var('N/A'); } ?></td>
											<td>
											<?php  
											$array_decode = $display_det_client[5];
											$arr_address_dec=base64_decode($array_decode);
											$tt=unserialize($arr_address_dec);
											echo filter_var($tt['address']);
											?>
											</td>
											<td><?php echo filter_var($booking_stats);	?></td>
											<td class="ld-bookings-td">
												<a class="btn btn-success booking_units" id="<?php echo filter_var($row2['order_id']);	?>" href="#booking-units" data-toggle="modal"><?php echo filter_var($label_language_values['booking_article']);	?> <span class="badge"></span></a> </td>
										</tr>
									<?php 
									$i++;}
									?>
									</tbody>
								</table>
								<div id="booking-units" class="modal fade booking-details-modal">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title"><?php echo filter_var($label_language_values['booking_article']);	?></h4>
										</div>
										<div class="modal-body">
										<div class="table-responsive">
											<table id="table-booking-units" class="display table table-striped table-bordered" cellspacing="0" width="100%">
													<thead>
														<tr>
															<th style="width: 9px !important;">#</th>
															<th style="width: 48px !important;"><?php echo filter_var($label_language_values['article_name']);	?></th>
															<th style="width: 73px !important;"><?php echo filter_var($label_language_values['article_rate']);	?></th>
															<th style="width: 39px !important;"><?php echo filter_var($label_language_values['article_quantity']);	?></th>
														</tr>
													</thead>
													<tbody id="display_booking_units">
														
													</tbody>
											</table>
										</div>
										
										</div>
									</div>
								</div>
							</div>
							</div>	
						</form>	
					</div>
				</div>
				
				<div id="staff-info-export" class="tab-pane fade">
					<h3><?php echo filter_var($label_language_values['customer_information']);	?></h3>
					<div id="accordion" class="panel-group">
						
						<form id="" name="" class="" method="post">
							
							<hr id="hr" />
							<div class="table-responsive">
								<table id="staff-info-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>	
											<th>#</th>
											<th><?php echo filter_var($label_language_values['name']);	?></th>
											<th><?php echo filter_var($label_language_values['email']);	?></th>
											<th><?php echo filter_var($label_language_values['phone']);	?></th>
											<th><?php echo filter_var($label_language_values['city']);	?></th>
											<th><?php echo filter_var($label_language_values['state']);	?></th>
											<th><?php echo filter_var($label_language_values['notes']);	?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$cus_display = $users->display_customer();
										$i = 1;
										while($row=mysqli_fetch_array($cus_display)){
										?>
										<tr>
											<td><?php echo filter_var($i);	?></td>
											<td>
												<?php 
												$client_first_name = $row['first_name'];
												$client_last_name = $row['last_name'];
												if($client_first_name=="" && $client_last_name==""){
													$client_fname = "N/A";
													$client_lname = "";
												}elseif($client_first_name!="" && $client_last_name!=""){
													$client_fname = $client_first_name;
													$client_lname = $client_last_name;
												}elseif($client_first_name!=""){
													$client_fname = $client_first_name;
													$client_lname = "";
												}elseif($client_last_name!=""){
													$client_fname = "";
													$client_lname = $client_last_name;
												}
												$client_name = $client_fname.' '.$client_lname;
												echo filter_var($client_name);
												?>
											</td>
											<td><?php echo filter_var($row['user_email']);	?></td>
											<td><?php $fetch_phone =  strlen($row['phone']); if($fetch_phone >= 6){ echo filter_var($row['phone']); }else{ echo filter_var('N/A'); } ?></td>
											<td><?php if($row['city']==""){ echo filter_var("N/A"); }else{ echo filter_var($row['city']); } ?></td>
											<td><?php if($row['state']==""){ echo filter_var("N/A"); }else{ echo filter_var($row['state']); } ?></td>
											<td><?php if($row['notes']==""){ echo filter_var("N/A"); }else{ echo filter_var($row['notes']); } ?></td>
										</tr>
										<?php 
										$i++;}
										?>
									</tbody>
								</table>
							</div>	
						</form>	
					</div>
				</div>
				
				<div id="services-info-export" class="tab-pane fade">
					<h3><?php echo filter_var($label_language_values['services_information']);	?></h3>
					<div id="accordion" class="panel-group">
						<form id="" name="" class="" method="post">
							<hr id="hr" />
							<div class="table-responsive">
								<table id="services-info-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>	
											<th>#</th>
											<th><?php echo filter_var($label_language_values['service_title']);	?></th>
											<th><?php echo filter_var($label_language_values['description']);	?></th>
											<th><?php echo filter_var($label_language_values['more']);	?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$ser_display = $objservice->getalldata();
										$i = 1;
										while($row1=mysqli_fetch_array($ser_display)){
											/* $service_unit->services_id=$row1['id']; */
											$count_ser_units = $service_unit->count_units_by_service_methods();
										?>
										<tr>	
											<td><?php echo filter_var($i);	?></td>
											<td><?php echo filter_var($row1['title']);	?></td>
											<td><?php echo filter_var($row1['description']);	?></td>
											<td class="ld-bookings-td">
												<a class="btn btn-success service_units" id="<?php echo filter_var($row1['id']);	?>" href="#service-units" data-toggle="modal"><?php echo filter_var($label_language_values['articles']);	?><span class="badge br-10"><?php echo filter_var($count_ser_units[0]);	?></span></a> </td>
										</tr>
										<?php 
										$i++;}
										?>	
									</tbody>
								</table>	
							<div id="service-units" class="modal fade booking-details-modal">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title"><?php echo filter_var($label_language_values['service_article']);	?></h4>
										</div>
										<div class="modal-body">
										<div class="table-responsive">
											<table id="table-service-units" class="display table table-striped table-bordered" cellspacing="0" width="100%">
													<thead>
														<tr>
															<th style="width: 9px !important;">#</th>
															<th style="width: 48px !important;"><?php echo filter_var($label_language_values['article_name']);	?></th>
															<th style="width: 73px !important;"><?php echo filter_var($label_language_values['base_price']);	?></th>
															<th style="width: 39px !important;"><?php echo filter_var($label_language_values['minimum_limit']);	?></th>
															<th style="width: 39px !important;"><?php echo filter_var($label_language_values['maximum_limit']);	?></th>
														</tr>
													</thead>
													<tbody id="display_units">
														
														
													</tbody>
											</table>
										</div>
										
										</div>
									</div>
								</div>
							</div>
							</div>	
						</form>	
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>	
 
		
<?php  
	include(dirname(__FILE__).'/footer.php');
?>