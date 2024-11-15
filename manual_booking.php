<?php 

$_SESSION['ld_cart'] = array();
$_SESSION['freq_dis_amount'] = '';
$_SESSION['ld_details'] = '';
$_SESSION['service_id'] = '';
$_SESSION['single_service_id'] = '';
include(dirname(__FILE__) . "/objects/class_services.php");
include(dirname(__FILE__) . "/objects/class_users.php");
include(dirname(__FILE__) . '/objects/class_front_first_step.php');

/* NAME */
$objservice = new laundry_services();
$objservice->conn = $conn;
$user = new laundry_users();
$user->conn = $conn;
$settings = new laundry_setting();
$settings->conn = $conn; 

$first_step=new laundry_first_step();
$first_step->conn=$conn;
?>
	
	<link rel="stylesheet" href="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/slick.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/slick-theme.css" type="text/css" media="all" />

	<script src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/jquery.mask.js" type="text/javascript"></script>
	<script src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/ld-manual-booking-jquery.js" type="text/javascript"></script>
	<script src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/slick.min.js" type="text/javascript"></script>
	<script src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/tooltipster.bundle.min.js" type="text/javascript"></script>
	<?php   
	$ld_cart_scrollable_position = 'relative !important';
	
    echo "<style>
	/* primary color */
		.laundry{
			color: " . $settings->get_option('ld_text_color') . " !important;
		}
		.laundry .ld-link.ld-mybookings{
			color:" . $settings->get_option('ld_text_color_on_bg') . " !important;
			background:" . $settings->get_option('ld_secondary_color') . " !important;
		}
		.laundry .ld-link.ld-mybookings:hover{
			color:" . $settings->get_option('ld_text_color_on_bg') . " !important;
			background:" . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-main-left .ld-list-header .ld-logged-in-user a.ld-link,
		.laundry .ld-complete-booking-main .ld-link,
		.laundry .ld-discount-coupons a.ld-apply-coupon.ld-link{
			color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-link:hover,
		.laundry .ld-main-left .ld-list-header .ld-logged-in-user a.ld-link:hover,
		.laundry .ld-complete-booking-main .ld-link:hover,
		.laundry .ld-discount-coupons a.ld-apply-coupon.ld-link:hover{
			color: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		.laundry a,
		.laundry .ld-link,
		.laundry .ld-addon-count .ld-btn-group .ld-btn-text{
			color: " . $settings->get_option('ld_text_color') . " !important;
		}
		.laundry a.ld-back-to-top i.icon-arrow-up,
		.laundry .calendar-wrapper .calendar-header a.next-date:hover .icon-arrow-right:before,
		.laundry .calendar-wrapper .calendar-header a.previous-date:hover .icon-arrow-left:before{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.laundry .calendar-body .ld-week:hover a span,
		.laundry .ld-extra-services-list ul.addon-service-list li .ld-addon-ser:hover .addon-price{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.laundry #ld-type-2 .service-selection-main .ld-services-dropdown .ld-service-list:hover,
		.laundry #ld-type-method .ld-services-method-dropdown .ld-service-method-list:hover,
		.laundry .common-selection-main .common-data-dropdown .data-list:hover{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
			background:" . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .selected-is:hover,
		.laundry #ld-type-2 .service-is:hover,
		.laundry #ld-type-method .service-method-is:hover{
			border-color:" . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-extra-services-list ul.addon-service-list li .ld-addon-ser:hover span:before{
			border-top-color:" . $settings->get_option('ld_primary_color') . " !important;
		}
		
		.laundry .calendar-wrapper .calendar-header a.next-date:hover,
		.laundry .calendar-wrapper .calendar-header a.previous-date:hover,
		.laundry .calendar-body .ld-week:hover{
			background:" . $settings->get_option('ld_secondary_color') . " !important;
		}
		.laundry .calendar-body .ld-show-time .time-slot-container ul li.time-slot{
			background:" . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .calendar-body .dates .ld-week.by_default_today_selected.active_today span,
		.laundry .calendar-body .ld-show-time .time-slot-container ul li.time-slot,
		.laundry .calendar-body .dates .ld-week.active span {
			color:" . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.laundry .calendar-header a.previous-date,
		.laundry .calendar-header a.next-date{
			color:" . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		
		.laundry .ld-custom-checkbox  ul.ld-checkbox-list label:hover span,
		.laundry .ld-custom-radio ul.ld-radio-list label:hover span{
			border:1px solid " . $settings->get_option('ld_secondary_color') . " !important;
		}
		#ld-login .ld-main-forget-password .ld-info-btn,
		.laundry button,
		.laundry #ld-front-forget-password .ld-front-forget-password .ld-info-btn,	
		.laundry .ld-button{
			color:" . $settings->get_option('ld_text_color_on_bg') . ";
			background:" . $settings->get_option('ld_primary_color') . ";
			border: 2px solid " . $settings->get_option('ld_primary_color') . ";
		}
		.laundry .ld-display-coupon-code .ld-coupon-value{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
			background:" . $settings->get_option('ld_secondary_color') . " !important;
		}
		/* for front date legends */
		.laundry .calendar-body .ld-show-time .time-slot-container .ld-slot-legends .ld-available-new {
			background: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .calendar-body .ld-show-time .time-slot-container .ld-slot-legends .ld-selected-new{
			background: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		/* seconday color */
		.nicescroll-cursors{
			background-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
				
	    .laundry .calendar-body .dates .ld-week.active,
	    .laundry .calendar-body .ld-show-time.shown{
	    	background: " . $settings->get_option('ld_secondary_color') . " !important;
	    }
	/* background color all css  HOVER */
		
		.laundry .ld-selected,
		.laundry .ld-selected-data,
		.laundry .ld-provider-list ul.provders-list li input[type='radio']:checked + lable span,
		.laundry .ld-list-services ul.services-list li input[type='radio']:checked + lable span,
		.laundry .ld-extra-services-list ul.addon-service-list li input[type='checkbox']:checked label span,
		.laundry .ld-discount-list ul.ld-discount-often li input[type='radio']:checked + .ld-btn-discount,
		.laundry #ld-tslots .ld-date-time-main .time-slot-selection-main .time-slot.ld-selected,
		.laundry .ld-button:hover,
		.laundry-login .ld-main-forget-password .ld-info-btn:hover,
		.laundry #ld-front-forget-password .ld-front-forget-password .ld-info-btn:hover,
		.laundry  input[type='submit']:hover,
		.laundry  input[type='reset']:hover,
		.laundry  input[type='button']:hover{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
			background: " . $settings->get_option('ld_primary_color') . " !important;
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-step-heading{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
			background: " . $settings->get_option('ld_primary_color') . " !important;
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry #ld-price-scroll{
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
			box-shadow: 0px 0px 1px " . $settings->get_option('ld_primary_color') . " !important;
			position: ".$ld_cart_scrollable_position.";
		}
		.slick-prev:before, .slick-next:before{
			color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-cart-wrapper .ld-cart-label-total-amount,
		.laundry .ld-cart-wrapper .ld-cart-total-amount{
			color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		
		.laundry .ld-list-services ul.services-list li input[type='radio']:checked + .ld-service ,
		.laundry .ld-provider-list ul.provders-list li input[type='radio']:checked + .ld-provider ,
		.laundry .ld-extra-services-list ul.addon-service-list li input[type='checkbox']:checked + .ld-addon-ser {
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
			box-shadow: 0 0 1px 1px " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-extra-services-list ul.addon-service-list li input[type='checkbox']:checked + .ld-addon-ser span:before{
			border-top-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld-extra-services-list ul.addon-service-list li input[type='checkbox']:checked + .ld-addon-ser .addon-price{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.laundry .cart_toggle_head { background-color:  " . $settings->get_option('ld_primary_color') . " !important;font-size: 18px;
    padding: 7px;
    color: #fff;
    cursor: pointer;
    margin: 5px;
    border-radius: 4px;
    overflow: hidden;}
		
		.laundry .border-c:hover,
		.laundry .ld-list-services ul.services-list li .ld-service:hover,
		.laundry .ld-list-services ul.addon-service-list li .ld-addon-ser:hover,
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bedroom-box .ld-bedroom-btn:hover,
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bathroom-box .ld-bathroom-btn:hover,
		.laundry #ld-duration-main.ld-service-duration .ld-duration-list .duration-box .ld-duration-btn:hover,
		.laundry .ld-extra-services-list .ld-addon-extra-count .ld-common-addon-list .ld-addon-box .ld-addon-btn:hover,
		.laundry .ld-discount-list ul.ld-discount-often li .ld-btn-discount:hover,
		.laundry .ld-custom-radio ul.ld-radio-list label:hover span,
		.laundry .ld-custom-checkbox  ul.ld-checkbox-list label:hover span{
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
			
		}
		#lda .ld-custom-radio ul.ld-radio-list input[type='radio']:checked + label span{
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		
		.laundry .ld-custom-checkbox  ul.ld-checkbox-list input[type='checkbox']:checked + label span{
			border: 1px solid " . $settings->get_option('ld_secondary_color') . " !important;
			background: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		.laundry .ld-custom-radio ul.ld-radio-list input[type='radio']:checked + label span{
			border:5px solid " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bedroom-box .ld-bedroom-btn.ld-bed-selected,
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bathroom-box .ld-bathroom-btn.ld-bath-selected,
		.laundry #ld-duration-main.ld-service-duration .ld-duration-list .duration-box .ld-duration-btn.duration-box-selected,
		.laundry .ld-extra-services-list .ld-addon-extra-count .ld-common-addon-list .ld-addon-box .ld-addon-selected{
			background: " . $settings->get_option('ld_secondary_color') . " !important;
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
			border-color: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		
		.laundry .ld-button.ld-btn-abs,
		.laundry .calendar-header,
		.laundry .panel-login .panel-heading .col-xs-6,
		.laundry a.ld-back-to-top {
			background-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry a.ld-back-to-top:hover,
		.laundry .weekdays{
			background-color: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		
		.laundry .calendar-body .dates .ld-week.by_default_today_selected{
			background-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .calendar-body .dates .ld-week.by_default_today_selected a span{
			color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		
		.laundry .calendar-body .dates .ld-week.selected_date.active{
			background-color: " . $settings->get_option('ld_secondary_color') . " !important;
			border-bottom: thin solid " . $settings->get_option('ld_secondary_color') . " !important;
		}
		.laundry .calendar-body .ld-show-time .time-slot-container ul li.time-slot:hover,
		.laundry .calendar-body .ld-show-time .time-slot-container ul li.time-slot.ld-booked,
		.laundry .calendar-body .ld-show-time.shown{
			background-color: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		
		
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bedroom-box .ld-bedroom-btn.ld-bed-selected,
		.laundry #ld-meth-unit-type-2.ld-meth-unit-count .bathroom-box .ld-bathroom-btn.ld-bath-selected,
		.laundry #ld-duration-main.ld-service-duration .ld-duration-list .duration-box .ld-duration-btn.duration-box-selected,
		.laundry .ld-extra-services-list .ld-addon-extra-count .ld-common-addon-list .ld-addon-box .ld-addon-selected{
		}
		
		
		
		/* hover inputs */
		.laundry input[type='text']:hover,
		.laundry input[type='password']:hover,
		.laundry input[type='email']:hover,
		.laundry input[type='url']:hover,
		.laundry input[type='tel']:hover,
		.laundry input[type='number']:hover,
		.laundry input[type='range']:hover,
		.laundry input[type='date']:hover,
		.laundry textarea:hover,
		.laundry select:hover,
		.laundry input[type='search']:hover,
		.laundry input[type='submit']:hover,
		.laundry input[type='button']:hover{
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
		}
		
		/* Focus inputs */
		.laundry input[type='text']:focus,
		.laundry input[type='password']:focus,
		.laundry input[type='email']:focus,
		.laundry input[type='url']:focus,
		.laundry input[type='tel']:focus,
		.laundry input[type='number']:focus,
		.laundry input[type='range']:focus,
		.laundry input[type='date']:focus,
		.laundry textarea:focus,
		.laundry select:focus,
		.laundry input[type='search']:focus,
		.laundry input[type='submit']:focus,
		.laundry input[type='button']:focus{
			border-color: " . $settings->get_option('ld_primary_color') . " !important;
			
		}
		.laundry .ld-tooltip-link {color: " . $settings->get_option('ld_secondary_color') . " !important;}
	    /* for custom css option */
		".$settings->get_option('ld_custom_css')."
		
		.laundry .ld_method_tab-slider--nav .ld_method_tab-slider-tabs {
		  background: " . $settings->get_option('ld_primary_color') . " !important;
		}
		.laundry .ld_method_tab-slider--nav .ld_method_tab-slider-tabs:after {
		  background: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		.laundry .ld_method_tab-slider--nav .ld_method_tab-slider-trigger {
		  color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.laundry .ld_method_tab-slider--nav .ld_method_tab-slider-trigger.active {
		  color: " . $settings->get_option('ld_text_color_on_bg') . " !important;
		}
		.ld-list-services ul.services-list li input[type=\"radio\"]:checked + .ld-service::after{
			background-color: " . $settings->get_option('ld_secondary_color') . " !important;
		}
		.rating-md{
			font-size: 1.5em !important ;
			display: table;
			margin: auto;
		}
	</style>";
    ?>
    <script>
        jQuery(document).ready(function () {
            var $sidebar = jQuery("#ld-price-scroll"),
                $window = jQuery(window),
                offset = $sidebar.offset(),
                topPadding = 250;
            fulloffset = jQuery("#ld").offset();

            $window.scroll(function () {
                var color = jQuery('#color_box').val();
                jQuery("#ld-price-scroll").css({'box-shadow': '0px 0px 1px ' + color + '', 'position': 'absolute'});
            });
        });
    </script>
    <script type="text/javascript">
        function myFunction() {
            var input = document.getElementById('coupon_val')
            var div = document.getElementById('display_code');
            div.innerHTML = input.value;
        }
    </script>
	
<div class="ld-wrapper laundry mb" id="ld"> 
    <div class="ld-main-wrapper">
	    <div class="container">
		    
			<div class="ld-main-left ld-sm-12 ld-md-12 ld-xs-12 mt-10 br-5 np">
                 <div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading active">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#ld-services-mb"><?php  echo filter_var($label_language_values['choose_service']); ?></a>
							</h4>
						</div>
						<div id="ld-services-mb" class="panel-collapse collapse in">
							<div class="panel-body">
								<div class="ld-list-services ld-common-box">
									<div class="ld-list-header"></div>
								</div>
							
								<div class="ld-list-services ld-common-box fl hide_allsss">
									
									<input id="total_cart_count" type="hidden" name="total_cart_count" value='1'/>
									
									<?php  
									if ($settings->get_option('ld_service_default_design') == 1) {
										?>
										
										<ul class="services-list">
											<?php  
											$services_data = $objservice->readall_for_frontend_services();
											if (mysqli_num_rows($services_data) > 0) {
												while ($s_arr = mysqli_fetch_array($services_data)) {
													?>
													<li 
													<?php   if($settings->get_option('ld_company_service_desc_status') != "" &&  $settings->get_option('ld_company_service_desc_status') == "Y"){ ?>
													
													
													title='<?php  echo $s_arr['description'];?>' class="ld-sm-6 ld-md-4 ld-lg-3 ld-xs-12 remove_service_class ser_details ld-tooltip-services tooltipstered"
													<?php   } else {
														echo "class='ld-sm-6 ld-md-4 ld-lg-3 ld-xs-12 remove_service_class ser_details'";										
													}  ?>
														data-servicetitle="<?php  echo filter_var($s_arr['title']); ?>"
														data-id="<?php  echo filter_var($s_arr['id']); ?>">
														<input type="radio" name="service-radio"
															   id="ld-service-<?php  echo filter_var($s_arr['id']); ?>"
															   class="make_service_disable"/>
														<label class="ld-service border-c" for="ld-service-<?php  echo filter_var($s_arr['id']); ?>">
															<?php  
															if ($s_arr['image'] == '') {
																$s_image = 'default_service.png';
															} else {
																$s_image = $s_arr['image'];
															}
															?>
															<div class="ld-service-img"><img class="ld-image"
																	src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/services/<?php  echo filter_var($s_image); ?>"/>
															</div>

															<div class="service-name fl ta-c"><?php  echo filter_var($s_arr['title']); ?></div>
														</label>
														
													</li>
												<?php  
												} ?>
										   <?php    } else {
												?>
												<li class="ld-sm-12 ld-md-12 ld-xs-12 ld-no-service-box"><?php  echo filter_var($label_language_values['please_configure_first_laundry_services_and_settings_in_admin_panel']); ?>
												</li>
											<?php  
											}
											?>
										</ul>
										
										<?php  
										if (mysqli_num_rows($services_data) === 1){
											$ser_arry = mysqli_fetch_array($services_data)
											?>
											<script>
											/** Make Service Selected **/
											jQuery(document).ready(function() {
												jQuery('.ser_details').trigger('click');
											});
											</script>
											<?php  
										}
									} else {
										?>
										<input type="radio" style="display:none;" name="service-radio" id="ld-service-0" value='off' class="make_service_disable"/>
										
									<?php  
										$services_data = $objservice->readall_for_frontend_services();
										if (mysqli_num_rows($services_data) > 0) {
											?>
											<label class="service_not_selected_error_d2" id="service_not_selected_error_d2"><?php  echo filter_var($label_language_values['please_select_service']); ?></label>
											<div class="services-list-dropdown fl" id="ld-type-2">
											<div class="service-selection-main">
												<div class="service-is" title="<?php  echo filter_var($label_language_values['choose_your_service']);?>">
													<div class="ld-service-list" id="ld_selected_service">
														<i class="icon-settings service-image icons"></i>

														<h3 class="service-name ser_name_for_error"><?php  echo filter_var($label_language_values['laundry_service']); ?></h3>
													</div>
												</div>
												<div class="ld-services-dropdown remove_service_data"> <?php  
													while ($s_arr = mysqli_fetch_array($services_data)) { ?>
														<div class="ld-service-list select_service remove_service_class ser_details"
															 data-servicetitle="<?php  echo filter_var($s_arr['title']); ?>"
															 data-id="<?php  echo filter_var($s_arr['id']); ?>">
															<?php  
															if ($s_arr['image'] == '') {
																$s_image = 'default_service.png';
															} else {
																$s_image = $s_arr['image'];
															}
															?>
															<img class="service-image"
																 src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/services/<?php  echo filter_var($s_image); ?>"
																 title="<?php  echo filter_var($label_language_values['service_image']); ?>"/>

															<h3 class="service-name"><?php  echo filter_var($s_arr['title']); ?></h3>
														</div>
													<?php   }
												?></div>
											</div> </div><?php 
											if (mysqli_num_rows($services_data) === 1){
													$st_arry = mysqli_fetch_array($services_data)
													?>
													<script>
													/** Make Service Selected **/
													jQuery(document).ready(function() {
														jQuery('.select_service').trigger('click');
													});
													</script>
													<?php  
												}
										} else {
											?>
											<div class="ld-sm-12 ld-md-12 ld-xs-12 ld-no-service-box"><?php  echo filter_var($label_language_values['please_configure_first_laundry_services_and_settings_in_admin_panel']); ?></div>
										<?php  
										}
										?>
									
									<?php  
									}
									?>

									<div class="services-method-list-dropdown fl show_methods_after_service_selection show_single_service_method" id="ld-type-method">
										<div class="service-method-selection-main">
											<div class="ld-services-method-dropdown s_method_names">
											</div>
										</div>
									</div>
									<label class="empty_cart_error" id="empty_cart_error"></label>
									<label class="no_units_in_cart_error" id="no_units_in_cart_error"></label>
									<input type='hidden' id="no_units_in_cart_err" value=''>
									<input type='hidden' id="no_units_in_cart_err_count" value=''>
								</div>
								

								<div class="ld-extra-services-list ld-common-box add_on_lists hide_allsss_addons">

								</div>
								
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#ld-calendar-date-mb"><?php  echo filter_var($label_language_values['when_would_you_like_us_to_pickup_and_deliver_your_clothes?']); ?></a>
							</h4>
						</div>
						<div id="ld-calendar-date-mb" class="panel-collapse collapse">
							<div class="panel-body">
								
								<div class="ld-date-time-main ld-common-box hide_allsss">
									<input type="hidden" id="self_service" value="<?php echo filter_var($settings->get_option('ld_show_self_service')); ?>">
									<?php   if($settings->get_option('ld_show_self_service') == "E") { ?>
									<div class="ld-list-header">
											<h3 class="header3"><?php  echo filter_var($label_language_values['self_service']); ?>
												<div class="ld-custom-checkbox">
													<ul class="ld-checkbox-list">
														<li>
															<input type="checkbox" id="self_service_status" /> 
															<label for="self_service_status" class="">
																<span></span>
															</label>
														</li>
													</ul>
												</div>
											</h3>
									</div>
									<?php }	?>									
                    <div class="ld-list-header">
                        <h3 class="header3 header_bg"><?php  echo filter_var($label_language_values['select_pick_up_date_and_time']); ?>
												 <?php   if($settings->get_option("ld_front_tool_tips_status")=='on' && $settings->get_option("ld_front_tool_tips_time_slots")!=''){?>
												<a class="ld-tooltip" href="#" data-toggle="tooltip" title="<?php  echo $settings->get_option("ld_front_tool_tips_time_slots");?>"><i class="fa fa-info-circle fa-lg"></i></a>	
												<?php   } ?>
												</h3>
                    </div>

                    <div class="ld-md-6 ld-sm-12 ld-xs-12 ld-datetime-select-main">
                        <div class="ld-datetime-select">
                            <label class="pickup_date_error" id="date_time_error_id" for="complete_bookings"></label>
                            <div class="calendar-wrapper cal_info">
															<input type="text" id="pickup_date" name="datetimes" />
                            </div>
                            
                        </div>
                    </div>
										<div class="ld-md-6 ld-sm-12 ld-xs-12 ld-datetime-select-main">
                        <div class="ld-datetime-select">
                            <label class="pickup_time_error" id="date_time_error_id" for="complete_bookings"></label>
                            <div class="calendar-wrapper1 cal_info">
															<select class="pickup-slots">
																<option>Select Slot</option>
															</select>
                            </div>
                            
                        </div>
                    </div>
                </div>
								<input type="hidden" id="show_delivery_date" value="<?php echo filter_var($settings->get_option('ld_show_delivery_date')); ?>">
								<?php   if($settings->get_option('ld_show_delivery_date') == "E") { ?>
								<div class="ld-date-time-main ld-common-box hide_allsss">
                    <div class="ld-list-header">
                        <h3 class="header3 header_bg"><?php  echo filter_var($label_language_values['select_delivery_date_and_time']); echo $settings->get_option("ld_front_tool_tips_status"); ?>
												 <?php   if($settings->get_option("ld_front_tool_tips_status")=='on' && $settings->get_option("ld_front_tool_tips_time_slots")!=''){?>
												<a class="ld-tooltip" href="#" data-toggle="tooltip" title="<?php  echo $settings->get_option("ld_front_tool_tips_time_slots");?>"><i class="fa fa-info-circle fa-lg"></i></a>	
												<?php   } ?>
												</h3>
                    </div>

                    <div class="ld-md-6 ld-sm-12 ld-xs-12 ld-datetime-select-main">
                        <div class="ld-datetime-select">
                            <label class="delivery_date_error" id="date_time_error_id" for="complete_bookings"></label>
                            <div class="calendar-wrapper cal_info">
															<input type="text" id="delivery_date" name="datetimes" />
                            </div>
                            
                        </div>
                    </div>
										<div class="ld-md-6 ld-sm-12 ld-xs-12 ld-datetime-select-main">
                        <div class="ld-datetime-select">
                            <label class="delivery_time_error" id="date_time_error_id" for="complete_bookings"></label>
                            <div class="calendar-wrapper1 cal_info">
															<select class="delivery-slots">
																<option>Select Slot</option>
															</select>
                            </div>
                            
                        </div>
                    </div>
                </div>
								<?php } ?>
								
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#ld-personal-info-mb"><?php  echo filter_var($label_language_values['your_personal_details']); ?></a>
							</h4>
						</div>
						<div id="ld-personal-info-mb" class="panel-collapse collapse">
							<div class="panel-body">
								
								<div class="ld-user-info-main ld-common-box existing_user_details hide_allsss">
									<div class="ld-list-header">
										
										<div class="ld-logged-in-user client_logout mb-20">
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

										<form id="user_details_form" class="" method="post">

											<div class="ld-new-user-details remove_preferred_password_and_preferred_email">
												<div class="row ld-xs-12">	
													<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">
														
														<input type="text" name="ld_email" id="ld-email" class="add_show_error_class error fancy_input" />
															<span class="highlight"></span>
															<span class="bar"></span>
														<label for="ld-email" class="fancy_label"><?php  echo filter_var($label_language_values['preferred_email']); ?></label>
														
													</div>

													<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row fancy_input_wrap">

														<input type="password" name="ld_preffered_pass" id="ld-preffered-pass" class="add_show_error_class error fancy_input" />
															<span class="highlight"></span>
															<span class="bar"></span>
														<label for="ld-preffered-pass" class="fancy_label"><?php  echo filter_var($label_language_values['preferred_password']); ?></label>

													</div>

												</div>
											</div>

											<div class="ld-peronal-details">

												<div class="ld-md-6 ld-sm-6 ld-xs-12 ld-form-row remove_guest_user_preferred_email fancy_input_wrap">

													<input type="text" name="ld_email_guest" class="add_show_error_class error fancy_input" id="ld-email-guest" />
														<span class="highlight"></span>
														<span class="bar"></span>
													<label for="ld-email-guest" class="fancy_label"><?php  echo filter_var($label_language_values['preferred_email']); ?>
													</label>
													
												</div>
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
								
								

								<div class="ld-payment-main ld-common-box hide_allsss">
									
											<div class="ld-list-header ld-hidden">
												<h3 class="header3 header_bg"><?php  echo filter_var($label_language_values['preferred_payment_method']); ?>
												  <?php   if($settings->get_option("ld_front_tool_tips_status")=='on' && $settings->get_option("ld_front_tool_payment_method")!=''){?>
												<a class="ld-tooltip" href="#" data-toggle="tooltip" title="<?php  echo $settings->get_option("ld_front_tool_payment_method");?>"><i class="fa fa-info-circle fa-lg"></i></a>	
												<?php   } ?>
												</h3>
												
											</div>
									   
										<div class="ld-main-payments fl ld-hidden">
											<div class="payments-container f-l" id="ld-payments">
												<label class="ld-error-msg"><?php  echo filter_var($label_language_values['please_select_one_payment_method']); ?></label>
												<label class="ld-error-msg ld-paypal-error" id="paypal_error"></label>

												<div class="ld-custom-radio ld-payment-methods f-l">
													<ul class="ld-radio-list ld-all-pay-methods">
														<?php    if ($settings->get_option('ld_pay_locally_status') == 'on') { ?>
														<li class="ld-md-3 ld-sm-6 ld-xs-12" id="pay-at-venue">
															<input type="radio" name="payment-methods" value="pay at venue" class="input-radio payment_gateway" id="pay-cash"  checked="checked"/>
															<label for="pay-cash" class="locally-radio"><span></span><?php  echo filter_var($label_language_values['pay_locally']); ?></label>
														</li>
														
														<?php   } ?>	
														
														
														<?php    if ($settings->get_option('ld_bank_transfer_status') == 'Y' && ($settings->get_option('ld_bank_name') != '' || $settings->get_option('ld_account_name') != ''  || $settings->get_option('ld_account_number') != '' || $settings->get_option('ld_branch_code') != '' || $settings->get_option('ld_ifsc_code') != '' || $settings->get_option('ld_bank_description') != '')) { ?>
														<li class="ld-md-3 ld-sm-6 ld-xs-12" id="ld-bank-transer">
															<input type="radio" name="payment-methods" value="bank transfer" class="input-radio bank_transfer payment_gateway" id="bank-transer"  />
															<label for="bank-transer" class="locally-radio"><span></span><?php  echo filter_var($label_language_values['bank_transfer']); ?></label>
														</li>
														<?php   }?>
												
														<?php  
														if ($settings->get_option('ld_paypal_express_checkout_status') == 'on') {
															?>
														   
															<li class="ld-md-3 ld-sm-6 ld-xs-12" id="pay-at-venue">
																<input type="radio" name="payment-methods" value="paypal"
																	   class="input-radio payment_gateway" id="pay-paypal" checked="checked" />
																<label for="pay-paypal"  class="locally-radio"><span></span><?php  echo filter_var($label_language_values['paypal']); ?><img src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/cards/paypal.png" class="ld-paypal-image" alt="PayPal"></label>
															</li>
														<?php  
														} ?>
														
														<?php  
														if ($settings->get_option('ld_payumoney_status') == 'Y') {
															?>
														   
															<li class="ld-md-3 ld-sm-6 ld-xs-12" id="pay-at-venue">
																<input type="radio" name="payment-methods" value="payumoney"
																	   class="input-radio payment_gateway" id="payumoney" checked="checked" />
																<label for="payumoney"  class="locally-radio"><span></span> <?php   echo filter_var($label_language_values['payumoney']); ?></label>
															</li>
														<?php  
														} ?>
														 <?php   if($settings->get_option('ld_authorizenet_status') == 'on' && $settings->get_option('ld_stripe_payment_form_status') != 'on' && $settings->get_option('ld_2checkout_status') != 'Y'){  ?>
														
														<li class="ld-md-3 ld-sm-6 ld-xs-12" id="card-payment">
															<input type="radio" name="payment-methods" value="card-payment" class="input-radio payment_gateway cccard" id="pay-card" checked="checked"/>
															<label for="pay-card" class="card-radio"><span></span><?php  echo filter_var($label_language_values['card_payment']); ?></label>
														</li>
														<?php    }  ?>
														<?php   if ($settings->get_option('ld_authorizenet_status') != 'on' && $settings->get_option('ld_stripe_payment_form_status') == 'on' && $settings->get_option('ld_2checkout_status') != 'Y'){  ?>
														
														<li class="ld-md-3 ld-sm-6 ld-xs-12" id="card-payment">
															<input type="radio" name="payment-methods" value="stripe-payment" class="input-radio payment_gateway cccard" id="pay-card" checked="checked"/>
															<label for="pay-card" class="card-radio"><span></span><?php  echo filter_var($label_language_values['card_payment']); ?></label>
														</li>
														<?php    }  ?>
														<?php   if ($settings->get_option('ld_authorizenet_status') != 'on' && $settings->get_option('ld_stripe_payment_form_status') != 'on' && $settings->get_option('ld_2checkout_status') == 'Y'){  ?>
														
														<li class="ld-md-3 ld-sm-6 ld-xs-12" id="card-payment">
															<input type="radio" name="payment-methods" value="2checkout-payment" class="input-radio payment_gateway cccard" id="pay-card" checked="checked"/>
															<label for="pay-card" class="card-radio"><span></span><?php  echo filter_var($label_language_values['card_payment']); ?></label>
														</li>
														<?php    } ?>
													  </ul>
												</div>
											</div>
										</div>
								  
								</div>
								
								
								
								<div class="ld-complete-booking-main ld-sm-12 ld-md-12 mb-30 ld-xs-12 hide_allsss">

									<div class="ld-list-header ld-hidden">
										<p class="ld-sub-complete-booking"></p>
									</div>
									<label class="ld_all_booking_errors ld-md-12 mt-30" style="display: none;"></label>
									<div class="ta-center fl">
										<a href="javascript:void(0)" type='submit' data-currency_symbol="<?php  echo $settings->get_option('ld_currency_symbol'); ?>" id='complete_bookings' class="ld-button ld-btn-big ld_remove_id"><?php  echo filter_var($label_language_values['complete_booking']);?></a>
									</div>
								</div>

								</form>								
							</div>
						</div>
					</div>
					
					
					<div class="ld-main-right ld-sm-8 ld-md-6 ld-xs-12 mt-30 mb-30 br-5 hide_allsss">
						<div class="fl">
							<div class="main-inner-container border-c ld-price-scroll p-scroll-height" id="ld-price-scroll">
								<div class="ld-step-heading"><h3 class="header3"><?php  echo filter_var($label_language_values['booking_summary']); ?></h3></div>
								<div class="ld-cart-wrapper f-l" id="">
									<!--<div class="ld-summary hideservice_name">
										<div class="ld-image">
											<img src="<?php  //echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/icon-service.png" alt="">
										</div>
										<p class="ld-text sel-service"></p>
									</div>-->
									<div class="ld-summary hidedatetime_value">
											<div class="ld-image">
													<img src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/icon-calendar.png" alt="">
											</div>
											<p class="ld-text sel-datetime"><span class='cart_date' data-date_val=""></span><span class="space_between_date_time"> @ </span><span class='cart_time' data-time_val=""></span></p>
									</div>
									<div class="ld-summary hidedatetime_del_value">
											<div class="ld-image">
													<img src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/icon-calendar.png" alt="">
											</div>
											<p class="ld-text sel-datetime"><span class='cart_del_date' data-date_del_val=""></span><span class="space_between_date_time_del"> @ </span><span class='cart_del_time' data-time_del_val=""></span></p>
									</div>
									<?php   if($settings->get_option('ld_show_self_service') == "E") { ?>
									<div class="ld-summary hide_self_service">
											<div class="ld-image">
													<img src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/self-service.png" alt="">
											</div>
											<p class="ld-text sel-self-service"></p>
									</div>
									<?php } ?>
									<div class="ld-form-rown ld-addons-list-main">
										<div class="step_heading f-l"><h6 class="header6 ld-item-list"><?php  echo filter_var($label_language_values['cart_items']); ?></h6>
										</div>
										<div class="cart-items-main f-l">
											<label class="cart_empty_msg"><?php  echo filter_var($label_language_values['cart_is_empty']); ?></label>
											<ul class="ld-addon-items-list cart_item_listing">

											</ul>
										</div>
									</div>
									<div class="ld-form-rown">
										<div class="ld-cart-label-common ofh pull-left"><?php  echo filter_var($label_language_values['sub_total']); ?></div>
										<div class="ld-cart-amount-common ofh">
											<span class="ld-sub-total cart_sub_total"></span>
										</div>
									</div>
									<?php  
									if ($settings->get_option('ld_show_coupons_input_on_checkout') == 'on') {
										?>
										<div class="ld-form-rown coupon_display">
											<div class="ld-cart-label-common ofh pull-left"><?php  echo filter_var($label_language_values['coupon_discount']); ?></div>
											<div class="ld-cart-amount-common ofh">
												<span class="ld-coupon-discount cart_discount"></span>
											</div>
										</div>
									<?php  
									}
									?>
									<?php  
									if ($settings->get_option('ld_tax_vat_status') == 'Y') {
										?>
										<div class="ld-form-rown">
											<div class="ld-cart-label-common ofh pull-left"><?php  echo filter_var($label_language_values['tax']); ?></div>
											<div class="ld-cart-amount-common ofh">
												<span class="ld-tax-amount cart_tax"></span>
											</div>
										</div>
									<?php  
									}
									?>
									
									<?php  
									if ($settings->get_option('ld_show_coupons_input_on_checkout') == 'on') {
										?>
										<div class="ld-discount-coupons ld-md-12">
											<div class="ld-form-rown">
												<div class="ld-coupon-input ld-md-12 ld-sm-12 ld-xs-12 mt-10 mb-15 np">
													<input id="coupon_val" type="text" name="coupon_apply"
														   class="ld-coupon-input-text hide_coupon_textbox"
														   placeholder="<?php  echo filter_var($label_language_values['have_a_promocode']); ?>" maxlength="22" onchange="myFunction()"/>
													<a href="javascript:void(0);" class="ld-apply-coupon ld-link hide_coupon_textbox"
													   name="apply-coupon" id="apply_coupon"><?php  echo filter_var($label_language_values['apply']); ?></a>
														  <?php   if($settings->get_option("ld_front_tool_tips_status")=='on' && $settings->get_option("ld_front_tool_tips_promocode")!=''){?>
														<a class="ld-tooltip" href="#" data-toggle="tooltip" title="<?php  echo $settings->get_option("ld_front_tool_tips_promocode");?>"><i class="fa fa-info-circle fa-lg"></i></a>	
														<?php   } ?>
													<label class="ld-error ofh coupon_invalid_error"></label>
													
													<div class="ld-display-coupon-code">
														<div class="ld-form-rown">
															<div class="ld-column ld-md-7 ld-xs-12 ofh">
																<label><?php  echo filter_var($label_language_values['applied_promocode']); ?></label>
															</div>
															<div class="ld-coupon-value-main ld-md-5 ld-xs-12">
																<span class="ld-coupon-value border-2" id="display_code"></span>
																<img id="ld-remove-applied-coupon"
																	 src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/images/ld-close.png"
																	 class="reverse_coupon" title="<?php  echo filter_var($label_language_values['remove_applied_coupon']); ?>"/>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php  
									}
									?>
									<div class="ld-clear"></div>
									<div id="ld-line"></div>
									<div class="ld-form-rown d_flex">
										<div class="ld-cart-label-total-amount ofh"><?php  echo filter_var($label_language_values['total']); ?></div>
										<div class="ld-cart-total-amount ofh">
											<span class="ld-total-amount cart_total"></span>
										</div>
									</div>

									<div class="ld-clear"></div>
									
								</div>
								


							</div>
						</div>
					</div>
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
			/* Day */
			'd' => 'DD',
			'j' => 'DD',
			/* Month */
			'm' => 'MM',
			'M' => 'MMM',
			'F' => 'MMMM',
			/* Year */
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
</body>
</html>