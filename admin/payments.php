<?php  
include(dirname(__FILE__).'/header.php');
include(dirname(dirname(__FILE__)) ."/objects/class_payments.php");
include(dirname(dirname(__FILE__)) ."/objects/class_staff_commision.php");
include(dirname(__FILE__).'/user_session_check.php');
include(dirname(dirname(__FILE__)) ."/objects/class_adminprofile.php");

$con = new laundry_db();
$conn = $con->connect();
$objpayment = new laundry_payments();
$objpayment->conn = $conn;

$staffpayment=new laundry_staff_commision();
$staffpayment->conn=$conn;

$admin_profile=new laundry_adminprofile();
$admin_profile->conn=$conn;

/* general setting object */
$general=new laundry_general();
$general->conn=$conn;
$settings = new laundry_setting();
$settings->conn = $conn;
$symbol_position=$settings->get_option('ld_currency_symbol_position');
$cal_amount=$setting->get_option('ld_partial_deposit_amount');
$decimal=$settings->get_option('ld_price_format_decimal_places');	
?>
<div id="lda-payments" class="panel tab-content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title"><?php echo filter_var($label_language_values['payments_history_details']);	?></h1>
        </div>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#client-payments"><?php echo filter_var($label_language_values['client_payments']);	?></a></li>
			<li><a data-toggle="tab" href="#staff-payments"><?php echo filter_var($label_language_values['staff_payments']);	?></a></li>
		</ul>
        <div class="tab-content">
        <div id="client-payments" class="tab-pane fade in active">
			<div id="accordion" class="panel-group">
                <form id="" name="" class="" method="post">

					<div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
						<label><?php echo filter_var($label_language_values['select_payment_option_export_details']);	?></label>
						<div id="reportrange" class="form-control" >
							<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
							<span></span> <i class="fa fa-caret-down"></i>
						</div>

					</div>
					<div class="col-md-2 col-sm-2 col-xs-12 col-lg-2">
						<br />
						<button type="button" class="btn btn-info mb-10 mybtngetpaymentdate" name=""><?php echo filter_var($label_language_values['submit']);	?></button>
					</div>

				</div>
				<div class="mb-5" id="hr"></div>
				<div class="mytabledisplaypayment">
				<table id="payments-details" class="display responsive nowrap table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
					<tr>
						<th>#</th>
						<th><?php echo filter_var($label_language_values['client']);	?></th>
						<th><?php echo filter_var($label_language_values['payment_method']);	?></th>
						<th><?php echo filter_var($label_language_values['transaction_id']);	?></th>
						<th><?php echo filter_var($label_language_values['payment_date']);	?></th>
						<th><?php echo filter_var($label_language_values['amount']);	?></th>
						<th><?php echo filter_var($label_language_values['discount']);	?></th>
						<th><?php echo filter_var($label_language_values['tax']);	?></th>
						<th><?php echo filter_var($label_language_values['net_total']);	?></th>
						<th><?php echo filter_var($label_language_values['partial_amount']);	?></th>
						<th><?php echo filter_var($label_language_values['status']);	?></th>
						<th><?php echo filter_var($label_language_values['email']);	?></th>
					</tr>
					</thead>
					<tbody>

					<?php 
					$r = $objpayment->getallpayment();
					while($rs = mysqli_fetch_array($r)){
						?>
						<tr>
							<td><?php echo filter_var($rs['order_id']);	?></td>
							<td>
								<?php 
								$p_client_name = $objpayment->getclientname($rs['order_id']);
								echo filter_var($p_client_name);
								?>
							</td>
							<?php 
							if($rs['net_amount']==0){
								?>
								<td><?php 						
									if($rs['payment_method'] == "Stripe-payment" || strtolower(trim($rs['payment_method'])) == "card-payment" || $rs['payment_method'] == "Payway-payment")
									{
										echo filter_var($label_language_values['card_payment']);
										if($rs['payment_method'] == "Stripe-payment")
										{										?>										
											<span class="ld-payment-img"><img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/stripe-s.png" ?> " title="Stripe Payment" /></span>	
											<?php  								
										}								
										else if(strtolower(trim($rs['payment_method'])) == "Card-payment")
										{
											?>									
											<span class="ld-payment-img"><img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/authorize-a.png" ?> " title="Authorize.Net Payment" /></span>	<?php  
										}	
										else if(strtolower(trim($rs['payment_method'])) == "2checkout-payment")
										{	
											?>								
											<span class="ld-payment-img"><img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/2checkout.png" ?>" title="2Checkout Payment" /></span>	
											<?php  
										}	
									}
									else
									{ 			
										echo filter_var($label_language_values[str_replace(" ", "_", strtolower($rs['payment_method']))]);
									} ?>					
								</td>
								<td><?php if($rs['transaction_id'] == ""){ echo filter_var("-");}
								else{ $p_t_id_res = str_split($rs['transaction_id'],10);echo str_replace(","," ",implode(",",$p_t_id_res)); }?>
								</td>
								<td><?php echo 
								str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($rs['payment_date'])));	?></td>
								<td><?php if($rs['discount'] == 0){ echo filter_var($label_language_values['free']); }else{echo filter_var( $general->ld_price_format($rs['discount']),$symbol_position,$decimal);}?></td>
								<td><?php if($rs['taxes'] == 0){ echo filter_var($label_language_values['free']); }else{echo  filter_var($general->ld_price_format($rs['taxes']),$symbol_position,$decimal);}?></td>
								<td><?php if($rs['net_amount'] == 0){ echo filter_var($label_language_values['free']); }else{echo  filter_var($general->ld_price_format($rs['net_amount']),$symbol_position,$decimal);}?></td>
								<td><?php if($rs['partial_amount'] == 0){ echo filter_var($label_language_values['free']); }else{echo  filter_var($general->ld_price_format($rs['partial_amount']),$symbol_position,$decimal);}?></td>
							<?php 
							}
							else{
								?>
								<td><?php 		
									if($rs['payment_method'] == "Stripe-payment" || strtolower(trim($rs['payment_method'])) == "card-payment" || $rs['payment_method'] == "Payway-payment"){
										echo filter_var($label_language_values['card_payment']);
										if($rs['payment_method'] == "Stripe-payment"){		
										?>									
										<span class="ld-payment-img"><img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/stripe-s.png" ?> " title="Stripe Payment" /></span>			
										<?php  }					
										else if(strtolower(trim($rs['payment_method'])) == "card-payment"){	
										?>				
										<span class="ld-payment-img"><img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/authorize-a.png" ?> " title="Authorize.Net Payment"/></span>		
										<?php  }	
										else if(strtolower(trim($rs['payment_method'])) == "2checkout-payment")
										{	
											?>								
											<span class="ld-payment-img"><img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/images/2checkout.png" ?>" title="2Checkout Payment" /></span>	
											<?php  
										}										
									} 
									else 
									{
										echo filter_var($label_language_values[str_replace(" ", "_", strtolower($rs['payment_method']))]);
									}
									?>
								</td>
								<td><?php if($rs['transaction_id'] == ""){ echo filter_var("-");}
								else{$p_t_id_res = str_split($rs['transaction_id'],10);echo str_replace(","," ",implode(",",$p_t_id_res)); }?>
								</td>
								<td><?php echo 
								str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($rs['payment_date'])));	?></td>
								<td><?php echo  $general->ld_price_format($rs['amount'],$symbol_position,$decimal);	?></td>
								<td><?php echo  $rs['discount']==0?"-":$general->ld_price_format($rs['discount'],$symbol_position,$decimal);	?></td>
								<td><?php echo  $rs['taxes']==0?"-":$general->ld_price_format($rs['taxes'],$symbol_position,$decimal);	?></td>
								<td><?php echo  $rs['net_amount']==0?"-":$general->ld_price_format($rs['net_amount'],$symbol_position,$decimal);	?></td>
								<td><?php echo  $rs['partial_amount']==0?"-":$general->ld_price_format($rs['partial_amount'],$symbol_position,$decimal);	?></td>
								<td><?php echo filter_var($rs['payment_status']);	?>   <a class="btn btn-primary update_payment_status" href="javascript:void(0);" id="update_payment_status" data-status="<?php echo filter_var($rs['payment_status']);	?>" data-order_id="<?php echo filter_var($rs['order_id']); ?>"><?php  echo filter_var($label_language_values['update']); ?></a></td>
								<?php 
								$p_client_email = $objpayment->getclientemail($rs['order_id']);
								$p_client_name = $objpayment->getclientname($rs['order_id']);
								$p_client_name_res = str_split($p_client_name,5);
								$client_name = str_replace(","," ",implode(",",$p_client_name_res));
								?>
								<td><a class="btn btn-primary send_inovoice" href="javascript:void(0);" id="send_inovoice" data-link="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/lib/download_invoice_client.php?iid=<?php echo filter_var($rs['order_id']); ?>" data-email="<?php echo filter_var($p_client_email); ?>" data-name="<?php echo filter_var($client_name); ?>">
								<i class="fa fa-envelope"></i>
								<?php  echo filter_var($label_language_values['Send_Invoice']); ?></a></td>
							<?php 
							}
							?>

						</tr>
						<?php 
					}
					?>
					</tbody>
				</table>
				</div>
				</form>
        </div>
		<div id="staff-payments" class="tab-pane fade">
				<h3><?php echo filter_var($label_language_values['staff_payments_details']);	?></h3>
				<div id="accordion" class="panel-group">
					<form id="" name="" class="" method="post">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
							<label><?php echo filter_var($label_language_values['select_payment_option_export_details']);	?></label>
							<div id="reportrange-staff-payment" class="form-control" >
								<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
								<span></span> <i class="fa fa-caret-down"></i>
							</div>

						</div>
						<div class="col-md-2 col-sm-2 col-xs-12 col-lg-2">
							<br />
							<button type="button" class="btn btn-info mb-10 get_payment_staff_by_date" name=""><?php echo filter_var($label_language_values['submit']);	?></button>
						</div>
					</div>	
					<div class="mb-5" id="hr"></div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="table-responsive get_payment_staff_by_date_append">
							<table id="staff-payments-details" class="display responsive nowrap table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>#</th>
										<th><?php echo filter_var($label_language_values['client']);	?></th>
										<th><?php echo filter_var($label_language_values['staff_name']);	?></th>
										<th><?php echo filter_var($label_language_values['payment_method']);	?></th>
										<th><?php echo filter_var($label_language_values['payment_date']);	?></th>
										<th><?php echo filter_var($label_language_values['amount']);	?></th>
										<th><?php echo filter_var($label_language_values['advance_paid']);	?></th>
										<th><?php echo filter_var($label_language_values['net_total']);	?></th>
									</tr>
								</thead>
								<tbody>
									<?php  
									$readall_ld_staff_commision = $staffpayment->readall_ld_staff_commision();
									if(mysqli_num_rows($readall_ld_staff_commision) >0){
										$i=1;
										while($row = mysqli_fetch_array($readall_ld_staff_commision)){
											?>
											<tr>
												<td><?php echo filter_var($i); ?></td>
												<td>
													<?php 
													$p_client_name = $objpayment->getclientname($row['order_id']);
													$p_client_name_res = str_split($p_client_name,5);
													echo str_replace(","," ",implode(",",$p_client_name_res));
													?>
												</td>
												<td>
													<?php 
													$admin_profile->id=$row['staff_id'];
													$s_client_name = $admin_profile->readone();
													echo filter_var($s_client_name['fullname']);
													?>
												</td>
												<td><?php echo filter_var($row['payment_method']); ?></td>
												<td><?php echo str_replace($english_date_array,$selected_lang_label,date($getdateformat,strtotime($row['payment_date'])));	?></td>
												<td><?php echo  $general->ld_price_format($row['amt_payable'],$symbol_position,$decimal);	?></td>
												<td><?php echo  $general->ld_price_format($row['advance_paid'],$symbol_position,$decimal);	?></td>
												<td><?php echo  $general->ld_price_format($row['net_total'],$symbol_position,$decimal);	?></td>
											</tr>
											<?php 
											$i++;
										}
									}
									?>
								</tbody>
							</table>
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
<script type="text/javascript">
    var ajax_url = '<?php echo filter_var(AJAX_URL, FILTER_VALIDATE_URL);	?>';
    var servObj={'site_url':'<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL).'assets/images/business/';	?>'};
    var imgObj={'img_url':'<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL).'assets/images/';	?>'};
</script>