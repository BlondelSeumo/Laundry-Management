<?php  
class laundry_setting
{
    public $option_id;
    public $option_name;
    public $option_value;
    /* below variable is use for General setting*/
    public $ld_timezone;
    public $ld_company_name;
    public $ld_company_email;
    public $ld_company_address;
    public $ld_company_city;
    public $ld_company_state;
    public $ld_company_zip_code;
    public $ld_company_country;
    public $ld_company_country_code;
    public $ld_company_logo;
    public $ld_company_phone;
	public $ld_company_header_address;
	public $ld_company_logo_display;
	public $ld_appointment_details_section;
    /* below variable is use for General setting*/
    public $ld_languages;
    public $ld_time_interval;
    public $ld_min_advance_booking_time;
    public $ld_max_advance_booking_time;
    public $ld_booking_padding_time;
    public $ld_service_padding_time_before;
    public $ld_service_padding_time_after;
    public $ld_cancellation_buffer_time;
    public $ld_reshedule_buffer_time;
    public $ld_currency;
    public $ld_currency_symbol_position;
    public $ld_price_format_decimal_places;
    public $ld_tax_vat_status;
    public $ld_tax_vat_type;
    public $ld_tax_vat_value;
    public $ld_partial_deposit_status;
    public $ld_partial_type;
    public $ld_partial_deposit_amount;
    public $ld_partial_deposit_message;
    public $ld_thankyou_page_url;
    public $ld_cancelation_policy_status;
    public $ld_cancel_policy_header;
    public $ld_cancel_policy_textarea;
    public $ld_allow_multiple_booking_for_same_timeslot_status;
    public $ld_appointment_auto_confirm_status;
    public $ld_allow_day_closing_time_overlap_booking;
    public $ld_allow_terms_and_conditions;
    public $ld_choose_time_format;
    public $ld_choose_display_location;
    public $ld_postal_code;
    public $ld_terms_condition_link; 
    public $ld_addons_default_design;
    public $ld_service_default_design;
    public $ld_method_default_design;
    public $ld_front_desc;
    public $ld_subheaders;
    public $ld_cart_scrollable;
    public $ld_privacy_policy_link;
    public $ld_allow_privacy_policy;
    public $ld_allow_front_desc;
    public $ld_currency_symbol;
	public $ld_user_zip_code;
	public $ld_calculation_policy;
    public $ld_recurrence_booking_type;
    public $ld_star_show_on_front;
    public $ld_sms_twilio_send_sms_to_staff_status;
    public $ld_sms_plivo_send_sms_to_staff_status;
    public $ld_sms_nexmo_send_sms_to_staff_status;
    public $ld_sms_textlocal_send_sms_to_staff_status;
    public $ld_show_self_service;
    public $ld_show_delivery_date;
    public $ld_express_booking_price;
    public $ld_appointment_details_display;
    public $ld_recurrence_booking_status;
    public $ld_company_title_display;
    public $ld_company_address1;
    public $ld_company_address2;
    public $ld_staff_registration;
    public $ld_staff_zipcode;
   /*  public $ld_appointment_details_display;
    public $ld_company_address1; */

    
	
    /* below variable is use for Appearance setting*/
    public $ld_primary_color;
    public $ld_secondary_color;
    public $ld_text_color;
    public $ld_text_color_on_bg;
    public $ld_primary_color_admin;
    public $ld_secondary_color_admin;
    public $ld_text_color_admin;
    public $ld_show_service_provider;
    public $ld_show_provider_avatars;
    public $ld_show_service_dropdown;
    public $ld_show_service_description;
    public $ld_show_coupons_input_on_checkout;
    public $ld_hide_faded_already_booked_time_slots;
    public $ld_guest_user_checkout;
    public $ld_time_format;
    public $ld_date_picker_date_format;
	public $ld_custom_css;
	public $ld_existing_and_new_user_checkout;
	public $ld_phone_display_country_code;
    /* below variable is use for payment setting*/
    public $ld_all_payment_gateway_status;
    public $ld_pay_locally_status;
    public $ld_paypal_express_checkout_status;
    public $ld_paypal_api_username;
    public $ld_paypal_api_password;
    public $ld_paypal_api_signature;
    public $ld_paypal_guest_payment_status;
    public $ld_paypal_test_mode_status;
    public $ld_stripe_payment_form_status;
    public $ld_stripe_secretkey;
    public $ld_stripe_publishablekey;
	public $ld_authorizenet_status;
	public $ld_authorizenet_API_login_ID;
	public $ld_authorizenet_transaction_key;
	public $ld_authorize_sandbox_mode;
	public $ld_2checkout_status;
	public $ld_2checkout_sellerid;
	public $ld_2checkout_publishkey;
	public $ld_2checkout_privatekey;
	public $ld_2checkout_sandbox_mode;
	public $ld_postalcode_status;
	public $ld_payway_status;
	public $ld_payway_publishable_key;
	public $ld_payway_secure_key;
	public $ld_payway_purchase_status;
	/* below variable is use for email setting */
	public $ld_payumoney_status;
	public $ld_payumoney_merchant_key;
	public $ld_payumoney_salt;
	
    /* below variable is use for email setting */
    public $ld_admin_email_notification_status;
    public $ld_staff_email_notification_status;
    public $ld_client_email_notification_status;
    public $ld_email_sender_name;
    public $ld_email_sender_address;
    public $ld_admin_optional_email;
    public $ld_email_appointment_reminder_buffer;
    public $ld_smtp_hostname;
    public $ld_smtp_username;
    public $ld_smtp_password;
    public $ld_smtp_port;
	public $ld_smtp_encryption;
	public $ld_smtp_authetication;
    /* below variable use for Client email template */
    public $ld_client_email_appointment_approved_by_service_provider_status;
    public $ld_client_email_appointment_rejected_by_service_provider_status;
    public $ld_client_email_appointment_cancelled_by_you_status;
    public $ld_client_email_appointment_cancelled_by_service_provider_status;
    public $ld_client_email_appointment_completed_status;
    public $ld_client_email_appointment_request_status;
    public $ld_client_email_appointment_reminder_status;
    public $ld_client_email_appointment_marked_as_no_show_status;
    /* below variable use for Admin/service provider email template*/
    public $ld_admin_email_new_appointment_request_requires_approval_status;
    public $ld_admin_email_appointment_approved_status;
    public $ld_admin_email_appointment_cancelled_by_customer_status;
    public $ld_admin_email_appointment_rejected_status;
    public $ld_admin_email_appointment_cancelled_status;
    public $ld_admin_email_admin_appointment_marked_as_no_show_status;
    public $ld_admin_email_appointment_reminder_status;
    public $ld_admin_email_appointment_completed_with_client_status;
    /* below variable is use for SMS notification*/
    public $ld_sms_service_status;
    public $ld_sms_twilio_account_SID;
    public $ld_sms_twilio_auth_token;
    public $ld_sms_twilio_sender_number;
    public $ld_sms_twilio_send_sms_to_service_provider_status;
    public $ld_sms_twilio_send_sms_to_client_status;
    public $ld_sms_twilio_send_sms_to_admin_status;
    public $ld_sms_twilio_admin_phone_number;
    public $ld_sms_plivo_account_SID;
    public $ld_sms_plivo_auth_token;
    public $ld_sms_plivo_sender_number;
    public $ld_sms_plivo_send_sms_to_client_status;
    public $ld_sms_plivo_send_sms_to_admin_status;
    public $ld_sms_plivo_admin_phone_number;
    public $ld_sms_plivo_status;
    public $ld_sms_twilio_status;
    public $ld_sms_template_admin_notification;
    public $ld_sms_template_service_provider;
    public $ld_sms_template_client_notification;
	public $ld_sms_textlocal_account_username;
    public $ld_sms_textlocal_admin_phone;
	public $ld_sms_textlocal_account_hash_id;
	public $ld_sms_textlocal_send_sms_to_client_status;
	public $ld_sms_textlocal_send_sms_to_admin_status;
	public $ld_sms_textlocal_status;
	public $ld_sms_nexmo_status;
	public $ld_nexmo_api_key;
	public $ld_nexmo_api_secret;
	public $ld_nexmo_from;
	public $ld_nexmo_status;
	public $ld_sms_nexmo_send_sms_to_client_status;
	public $ld_sms_nexmo_send_sms_to_admin_status;
	public $ld_sms_nexmo_admin_phone_number;
    /* Below variable is use for client sms template setting */
    public $ld_client_sms_approved_by_provider;
    public $ld_client_sms_rejected_by_provider;
    public $ld_client_sms_cancel_by_you;
    public $ld_client_sms_cancelled_by_provider;
    public $ld_client_sms_appointment_completed;
    public $ld_client_sms_appointment_request;
    public $ld_client_sms_appointment_reminder;
    public $ld_client_sms_appoitment_marked_as_no_show;
    /* Below variable is use for admin sms template setting*/
    public $ld_admin_client_new_appointment_request_requires_approval;
    public $ld_admin_client_new_appointment_approved;
    public $ld_admin_client_appointment_cancelled_by_customer;
    public $ld_admin_client_appointment_rejected;
    public $ld_admin_client_appointment_cancelled;
    public $ld_admin_client_appointment_marked_as_no_show;
    public $ld_admin_client_appointment_reminder;
    public $ld_admin_client_appointment_completed_with_client;
    /* below variable is use for Label setting*/
    public $ld_label_choose_service1;
    public $ld_label_choose_service2;
    public $ld_label_your_appointments;
    public $ld_label_total;
    /* below variable is use for Manual form field setting*/
    public $ld_email;
    public $ld_password;
    public $ld_firstname;
    public $ld_lastname;
    public $ld_phonenumber;
    public $ld_gender;
    public $ld_age;
    public $ld_postcode;
    public $ld_streetaddress;
    public $ld_town_city;
    public $ld_state;
    public $ld_country;
    public $ld_skype;
    public $ld_notes;
    /* below variable is use for Manager setting*/
    public $ld_manager_dashboard;
    public $ld_manager_appointment;
    public $ld_manager_location;
    public $ld_manager_services;
    public $ld_manager_staff;
    public $ld_manager_customers;
    public $ld_manager_payments;
    public $ld_manager_main_settings;
    public $ld_manager_company_setting;
    public $ld_manager_general_setting;
    public $ld_manager_appearance_setting;
    public $ld_manager_payment_setting;
    public $ld_manager_email_notification_setting;
    public $ld_manager_email_template_setting;
    public $ld_manager_sms_notification_setting;
    public $ld_manager_sms_template_setting;
    public $ld_manager_label_setting;
    public $ld_manager_manage_form_field_setting;
    public $ld_manager_custom_form_field_setting;
    public $ld_manager_promocode_setting;
    public $ld_manager_manager_capability_setting;
    public $ld_manager_export_setting;
    public $ld_manager_notification;
    public $conn;
    public $table_name = "ld_settings";
    public $ld_language;
    public $table_language = "ld_languages";
	
	/*below variable for front tooltips */
	public $ld_front_tool_tips_status;
	public $ld_front_tool_tips_my_bookings;
	public $ld_front_tool_tips_postal_code;
	public $ld_front_tool_tips_services;
	public $ld_front_tool_tips_addons_services;
	public $ld_front_tool_tips_frequently_discount;
	public $ld_front_tool_tips_time_slots;
	public $ld_front_tool_tips_personal_details;
	public $ld_front_tool_tips_promocode;
	public $ld_front_tool_payment_method;
	/*bank variable*/
	public $ld_bank_name;
	public $ld_account_name;
	public $ld_account_number;
	public $ld_branch_code;
	public $ld_ifsc_code;
	public $ld_bank_description;
	public $ld_bank_transfer_status;
	
	public $ld_bf_first_name;
	public $ld_bf_last_name;
	public $ld_bf_email;
	public $ld_bf_password;
	public $ld_bf_phone;
	public $ld_bf_address;
	public $ld_bf_zip_code;
	public $ld_bf_city;
	public $ld_bf_state;
	public $ld_bf_notes;
	
	public $ld_front_language_selection_dropdown;
	
	public $ld_loader;

	/* For Google Calender Settings */
	
	public $ld_gc_status;
	public $ld_gc_id;
	public $ld_gc_client_id;
	public $ld_gc_client_secret;
	public $ld_gc_status_configure;
	public $ld_gc_status_sync_configure;
	public $ld_gc_token;
	public $ld_gc_frontend_url;
	public $ld_gc_admin_url;
	
	public $ld_special_offer_text;
	public $ld_special_offer;
	public $ld_minimum_delivery_days;
	public $ld_advance_booking_days_limit;
    public $coupon_value;
    public $coupon_date;
    public $coupon_type;
    public $special_text;
    public $business_id;
    public $lang;
    public $language_status;
	
    /*
    * Function for add Settings
    *
    */
    public function add_option($option_name, $option_value)
    {
        $this->option_name = $option_name;
        $this->option_value = $option_value;
        $query = "insert into `" . $this->table_name . "` (`id`,`option_name`,`option_value`,`postalcode`) values(NULL,'" . $this->option_name . "','" . $this->option_value . "','')";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function update_option()
    {
        $query = "update `" . $this->table_name . "` set `business_id`='" . $this->business_id . "',`option_name`='" . $this->option_name . "',`option_value`='" . $this->option_value . "' where `id`='" . $this->option_id . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
		
		public function __construct()
    {
        $this->chk_pc();
    }
    
    /*
    * Function for Read and Display Settings
    */
	public function readall()
    {
        $Allsettings = array('ld_loader','ld_sms_textlocal_admin_phone','ld_sms_textlocal_account_username','ld_sms_textlocal_account_hash_id','ld_sms_textlocal_send_sms_to_client_status','ld_sms_textlocal_send_sms_to_admin_status','ld_sms_textlocal_status','ld_payumoney_status','ld_payumoney_merchant_key','ld_payumoney_salt','ld_company_logo_display','ld_company_title_display','ld_user_zip_code','ld_express_booking_price','ld_existing_and_new_user_checkout','ld_company_header_address','ld_postalcode_status','ld_2checkout_sandbox_mode','ld_2checkout_privatekey','ld_2checkout_publishkey','ld_2checkout_sellerid','ld_2checkout_status','ld_admin_optional_email','ld_company_phone','ld_sms_twilio_status','ld_sms_plivo_status','ld_sms_twilio_account_SID','ld_sms_twilio_auth_token','ld_sms_twilio_sender_number','ld_sms_twilio_send_sms_to_service_provider_status','ld_sms_twilio_send_sms_to_client_status','ld_sms_twilio_send_sms_to_admin_status','ld_sms_twilio_admin_phone_number','ld_sms_plivo_account_SID','ld_sms_plivo_auth_token','ld_sms_plivo_sender_number','ld_sms_plivo_send_sms_to_client_status','ld_sms_plivo_send_sms_to_admin_status','ld_sms_plivo_admin_phone_number','ld_custom_css','ld_language', 'ld_company_country_code', 'ld_timezone', 'ld_smtp_hostname', 'ld_smtp_username', 'ld_smtp_password', 'ld_smtp_port', 'ld_currency_symbol', 'ld_allow_front_desc', 'ld_privacy_policy_link', 'ld_allow_privacy_policy', 'ld_service_default_design', 'ld_subheaders', 'ld_cart_scrollable', 'ld_front_desc', 'ld_addons_default_design', 'ld_method_default_design', 'ld_terms_condition_link', 'ld_company_name', 'ld_company_email', 'ld_company_address', 'ld_company_city', 'ld_company_state', 'ld_company_zip_code', 'ld_company_country', 'ld_company_logo', 'ld_languages', 'ld_time_interval', 'ld_min_advance_booking_time', 'ld_max_advance_booking_time', 'ld_booking_padding_time', 'ld_service_padding_time_before', 'ld_service_padding_time_after', 'ld_cancellation_buffer_time', 'ld_reshedule_buffer_time', 'ld_currency', 'ld_currency_symbol_position', 'ld_price_format_decimal_places', 'ld_tax_vat_status', 'ld_tax_vat_type', 'ld_tax_vat_value', 'ld_partial_deposit_status', 'ld_partial_type', 'ld_partial_deposit_amount', 'ld_partial_deposit_message', 'ld_thankyou_page_url', 'ld_cancelation_policy_status', 'ld_cancel_policy_header', 'ld_cancel_policy_textarea', 'ld_allow_multiple_booking_for_same_timeslot_status', 'ld_appointment_auto_confirm_status', 'ld_allow_day_closing_time_overlap_booking', 'ld_allow_terms_and_conditions', 'ld_choose_time_format', 'ld_choose_display_location', 'ld_company_name', 'ld_company_email', 'ld_company_address1', 'ld_company_address2', 'ld_company_logo', 'ld_primary_color', 'ld_secondary_color', 'ld_text_color', 'ld_text_color_on_bg', 'ld_primary_color_admin', 'ld_secondary_color_admin', 'ld_text_color_admin', 'ld_show_service_provider', 'ld_show_provider_avatars', 'ld_show_service_dropdown', 'ld_show_service_description', 'ld_show_coupons_input_on_checkout', 'ld_hide_faded_already_booked_time_slots', 'ld_guest_user_checkout', 'ld_time_format', 'ld_date_picker_date_format', 'ld_all_payment_gateway_status', 'ld_pay_locally_status', 'ld_paypal_express_checkout_status', 'ld_paypal_api_username', 'ld_paypal_api_password', 'ld_paypal_api_signature', 'ld_paypal_guest_payment_status', 'ld_paypal_test_mode_status', 'ld_stripe_payment_form_status', 'ld_stripe_secretkey', 'ld_stripe_publishablekey','ld_authorizenet_status','ld_authorizenet_API_login_ID','ld_authorizenet_transaction_key','ld_authorize_sandbox_mode','ld_client_email_appointment_approved_by_service_provider_status', 'ld_client_email_appointment_rejected_by_service_provider_status', 'ld_client_email_appointment_cancelled_by_you_status', 'ld_client_email_appointment_cancelled_by_service_provider_status', 'ld_client_email_appointment_completed_status', 'ld_client_email_appointment_request_status', 'ld_client_email_appointment_reminder_status', 'ld_client_email_appointment_marked_as_no_show_status', 'ld_admin_email_new_appointment_request_requires_approval_status', 'ld_admin_email_appointment_approved_status', 'ld_admin_email_appointment_cancelled_by_customer_status', 'ld_admin_email_appointment_rejected_status', 'ld_admin_email_appointment_cancelled_status', 'ld_admin_email_admin_appointment_marked_as_no_show_status', 'ld_admin_email_appointment_reminder_status', 'ld_admin_email_appointment_completed_with_client_status', 'ld_admin_email_notification_status', 'ld_staff_email_notification_status', 'ld_client_email_notification_status', 'ld_email_sender_name', 'ld_email_sender_address', 'ld_email_appointment_reminder_buffer', 'ld_sms_service_status', 'ld_sms_twilio_account_SID', 'ld_sms_twilio_auth_token', 'ld_sms_twilio_sender_number', 'ld_sms_twilio_send_sms_to_service_provider_status', 'ld_sms_twilio_send_sms_to_client_status', 'ld_sms_twilio_send_sms_to_admin_status', 'ld_sms_twilio_admin_phone_number', 'ld_sms_template_admin_notification', 'ld_sms_template_service_provider', 'ld_sms_template_client_notification','ld_sms_nexmo_status','ld_nexmo_api_key','ld_nexmo_api_secret','ld_nexmo_from','ld_nexmo_status','ld_sms_nexmo_send_sms_to_client_status','ld_sms_nexmo_send_sms_to_admin_status','ld_sms_nexmo_admin_phone_number', 'ld_client_sms_approved_by_provider', 'ld_client_sms_rejected_by_provider', 'ld_client_sms_cancel_by_you', 'ld_client_sms_cancelled_by_provider', 'ld_client_sms_appointment_completed', 'ld_client_sms_appointment_request', 'ld_client_sms_appointment_reminder', 'ld_client_sms_appoitment_marked_as_no_show', 'ld_admin_client_new_appointment_request_requires_approval', 'ld_admin_client_new_appointment_approved', 'ld_admin_client_appointment_cancelled_by_customer', 'ld_admin_client_appointment_rejected', 'ld_admin_client_appointment_cancelled', 'ld_admin_client_appointment_marked_as_no_show', 'ld_admin_client_appointment_reminder', 'ld_admin_client_appointment_reminder', 'ld_admin_client_appointment_completed_with_client', 'ld_label_choose_service1', 'ld_label_choose_service2', 'ld_label_your_appointments', 'ld_label_total', 'ld_email', 'ld_password', 'ld_firstname', 'ld_lastname', 'ld_phonenumber', 'ld_gender', 'ld_age', 'ld_postcode', 'ld_streetaddress', 'ld_town_city', 'ld_state', 'ld_country', 'ld_skype', 'ld_notes', 'ld_manager_dashboard', 'ld_manager_appointment', 'ld_manager_location', 'ld_manager_services', 'ld_manager_staff', 'ld_manager_customers', 'ld_manager_payments', 'ld_manager_main_settings', 'ld_manager_company_setting', 'ld_manager_general_setting', 'ld_manager_appearance_setting', 'ld_manager_payment_setting', 'ld_manager_email_notification_setting', 'ld_manager_email_template_setting', 'ld_manager_sms_notification_setting', 'ld_manager_sms_template_setting', 'ld_manager_label_setting', 'ld_manager_manage_form_field_setting', 'ld_manager_custom_form_field_setting', 'ld_manager_promocode_setting', 'ld_manager_manager_capability_setting', 'ld_manager_export_setting', 'ld_manager_notification','ld_front_tool_tips_status','ld_front_tool_tips_my_bookings','ld_front_tool_tips_postal_code','ld_front_tool_tips_services','ld_front_tool_tips_addons_services','ld_front_tool_tips_frequently_discount','ld_front_tool_tips_time_slots','ld_front_tool_tips_personal_details','ld_front_tool_tips_promocode','ld_front_tool_payment_method','ld_bank_transfer_status','ld_phone_display_country_code','ld_smtp_authetication','ld_smtp_encryption','ld_bf_first_name','ld_bf_last_name','ld_bf_email','ld_bf_password','ld_bf_phone','ld_bf_address','ld_bf_zip_code','ld_bf_city','ld_bf_state','ld_bf_notes','ld_front_language_selection_dropdown','ld_calculation_policy','ld_appointment_details_section','ld_appointment_details_display','ld_recurrence_booking_status','ld_recurrence_booking_type','ld_gc_status','ld_gc_id','ld_gc_client_id','ld_gc_client_secret','ld_gc_status_configure','ld_gc_status_sync_configure','ld_gc_token','ld_gc_frontend_url','ld_gc_admin_url','ld_payway_status','ld_payway_publishable_key','ld_payway_secure_key','ld_payway_purchase_status','ld_star_show_on_front','ld_sms_twilio_send_sms_to_staff_status','ld_sms_plivo_send_sms_to_staff_status','ld_sms_nexmo_send_sms_to_staff_status','ld_sms_textlocal_send_sms_to_staff_status','ld_show_self_service','ld_advance_booking_days_limit','ld_minimum_delivery_days','ld_show_delivery_date','ld_express_booking_price','ld_staff_registration','ld_staff_zipcode');
        foreach ($Allsettings as $settingname) {
            $this->$settingname = $this->get_option($settingname);
        }
    }
    /*
    * Function for Read One Settings
    *
    */
    public function readone()
    {
        $query = "select * from `" . $this->table_name . "` where `id`='" . $this->option_id . "'";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_row($result);
        return $value;
    }
    /*
    * Function for Update Settings
    *
    */
    public function set_option($option_name, $option_value)
    {
        $this->option_name = $option_name;
		if($option_name == "ld_front_desc"){
			$this->option_value = mysqli_real_escape_string($this->conn, $option_value);
		}else{
			$this->option_value = $option_value;
		}
        $query = "update `" . $this->table_name . "` set `option_value`='" . $this->option_value . "' where `option_name`='" . $this->option_name . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function set_staff_option($option_name, $option_value, $staff_id)
    {
		$query = "select * from `ld_staff_gc` where `staff_id`='".$staff_id."'";
        $result = mysqli_query($this->conn, $query);
		$ress = mysqli_num_rows($result);
        if($ress>0){
			$query = "update `ld_staff_gc` set `".$option_name."` = '".$option_value."' where `staff_id`='".$staff_id."'";
			$result = mysqli_query($this->conn, $query);
			return $result;
		}else{
			$query = "insert into `ld_staff_gc` (`".$option_name."`, `staff_id`) VALUES ('".$option_value."', '".$staff_id."')";
			$result = mysqli_query($this->conn, $query);
			return $result;
		}
    }
	public function set_option_postal($option_value)
	{
		$this->option_name = 'ld_postal_code';
		$this->option_value = $option_value;
		$query = "update `" . $this->table_name . "` set `postalcode`='" . $this->option_value . "' where `option_name`='" . $this->option_name . "'";
		$result = mysqli_query($this->conn, $query);
		return $result;
	}
		
    public function get_option($option_name)
    {
        $this->option_name = $option_name;
        $query = "select `option_value` from `" . $this->table_name . "` where `option_name`='" . $this->option_name . "'";
        $result = mysqli_query($this->conn, $query);
        $ress = @mysqli_fetch_row($result);
        return $ress= isset($ress[0])? $ress[0] : '' ;
    }
    public function get_staff_option($option_name,$staff_id)
    {
        $query = "select `".$option_name."` from `ld_staff_gc` where `staff_id`='".$staff_id."';";
        $result = mysqli_query($this->conn, $query);
        $ress = @mysqli_fetch_row($result);
        return $ress[0];
    }
		public function get_option_postal()
    {
        $this->option_name = 'ld_postal_code';
        $query = "select `postalcode` from `" . $this->table_name . "` where `option_name`='" . $this->option_name . "'";
        $result = mysqli_query($this->conn, $query);
        $ress = @mysqli_fetch_row($result);
	    return $ress[0];
    }
		
		 public function chk_pc()
    { 
	   base64_decode('aW5jbHVkZV9vbmNlKGRpcm5hbWUoX19GSUxFX18pLiIvY2xhc3NfY29ubmVjdGlvbi5waHAiKTsgCiRjb24gPSBuZXcgbGF1bmRyeV9kYigpOyAKJGNvbm4gPSAkY29uLT5jb25uZWN0KCk7IAoKCiRjbGllbnRfbmFtZV9ub253d3d3ID0gc3RyX3JlcGxhY2UoJ3d3dy4nLCcnLCRfU0VSVkVSWydTRVJWRVJfTkFNRSddKTsgCiRjbGllbnRfbmFtZV93d3cgPSAnd3d3LicuJGNsaWVudF9uYW1lX25vbnd3d3c7CgkKCQoJCiRjaGtxdWVyeSA9ICJzZWxlY3QgKiBmcm9tIGxkX29yZGVyX2NsaWVudF9pbmZvIHdoZXJlIG9yZGVyX2lkPScwJyBhbmQgKGNsaWVudF9uYW1lPSciLiRjbGllbnRfbmFtZV9ub253d3d3LiInIG9yIGNsaWVudF9uYW1lPSciLiRjbGllbnRfbmFtZV93d3cuIicpICI7ICRyZXN1bHQgPSBteXNxbGlfcXVlcnkoJGNvbm4sJGNoa3F1ZXJ5KTsgCiRyZXN1bHRyID0gbXlzcWxpX2ZldGNoX3JvdygkcmVzdWx0KTsgCmlmKG15c3FsaV9udW1fcm93cygkcmVzdWx0KT09MCl7IAokZmlsZW5hbWUgPSAnLi4vY29uZmlnLnBocCc7IGlmIChmaWxlX2V4aXN0cygkZmlsZW5hbWUpICYmIGRhdGUgKCJkIiwgZmlsZW10aW1lKCRmaWxlbmFtZSkpID09IGRhdGUoImQiKSkgeyAKaW5jbHVkZV9vbmNlKGRpcm5hbWUoZGlybmFtZShfX0ZJTEVfXykpIC4gJy9jb25maWcucGhwJyk7IAokdHQgPSBuZXcgTGF1bmRyeV9teXZhcmlhYmxlKCk7IAokcGMgPSAkdHQtPmVwY29kZTsgJHBvc3R1cmwgPSBzdHJfcm90MTMoJ3VnZ2M6Ly9qamouZnhsemJiYXlub2YucGJ6L3luaGFxZWwvcHVycHhfY2hlcHVuZnJfcGJxci5jdWMnKTsgCiRjaCA9IGN1cmxfaW5pdCgpOyAKY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1VSTCwkcG9zdHVybCk7IGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9QT1NULCAxKTsgCmN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9QT1NURklFTERTLCJwdXJjaGFzZV9jb2RlPSIuJF9TRVJWRVJbJ1NFUlZFUl9OQU1FJ10uIiQkIi4kcGMpOyAKY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1JFVFVSTlRSQU5TRkVSLCB0cnVlKTsKIAokcmVzdWx0ZCA9IGN1cmxfZXhlYygkY2gpOyBpZigkcmVzdWx0ZD09J1ZhbGlkJykgeyAKJG9yZGVyX2luc2VydF9xdWVyeSA9ICJpbnNlcnQgaW50byBsZF9vcmRlcl9jbGllbnRfaW5mbyBzZXQgb3JkZXJfaWQ9JzAnLGNsaWVudF9uYW1lPSciLiRfU0VSVkVSWydTRVJWRVJfTkFNRSddLiInIjsgbXlzcWxpX3F1ZXJ5KCRjb25uLCAkb3JkZXJfaW5zZXJ0X3F1ZXJ5KTsgZWNobyAiWW91ciBjb3B5IG9mIExhdW5kcnkgaXMgYWN0aXZhdGVkIG5vdyEiOyB9IGVsc2UgeyBlY2hvICJZb3VyIGNvcHkgb2YgTGF1bmRyeSBpcyBub3QgcmVnaXN0ZXJlZCwgUGxlYXNlIHVzZSBjb3JyZWN0IEVudmF0byBQdXJjaGFzZSBjb2RlIHRvIGFjdGl2YXRlIGl0LiI7IH0gY3VybF9jbG9zZSAoJGNoKTsgfSBlbHNlIHsgZWNobyAiWW91ciBjb3B5IG9mIExhdW5kcnkgaXMgbm90IGFjdGl2YXRlZCwgUGxlYXNlIHVzZSBjb3JyZWN0IEVudmF0byBQdXJjaGFzZSBjb2RlIHRvIGFjdGl2YXRlIGl0LiI7IH0gZGllOyB9');
    }
	
    public function get_all_languages()
    {
        $query = "select * from `" . $this->table_language."`";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
	public function count_lang(){
		$query = "select count(`id`) as `c` from `" . $this->table_language."`";
        $result = mysqli_query($this->conn, $query);
        $value = mysqli_fetch_array($result);
        return $value[0];
	}
    public function delete_labels_languages($lang)
    {
        $query = "delete from `" . $this->table_language . "` where `language`='" . $lang . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function insert_labels_languages($language_front_arr,$language_admin_arr,$language_error_arr,$language_extra_arr,$language_front_error_arr, $language)
    {
		$query = "insert into `" . $this->table_language . "` (`id`,`label_data`,`language`, `admin_labels`, `error_labels`, `extra_labels`, `front_error_labels`) values(NULL,'" . $language_front_arr . "','" . $language . "','" . $language_admin_arr . "','" . $language_error_arr . "','" . $language_extra_arr . "','" . $language_front_error_arr . "')";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function insert_ferror_labels_languages($language_arr, $language)
    {
		$query = "insert into `" . $this->table_language . "` (`id`,`label_data`,`language`, `admin_labels`, `error_labels`, `extra_labels`, `front_error_labels`) values(NULL,'','" . $language . "','','','','" . $language_arr . "')";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function insert_extra_labels_languages($language_arr, $language)
    {
		$query = "insert into `" . $this->table_language . "` (`id`,`label_data`,`language`, `admin_labels`, `error_labels`, `extra_labels`, `front_error_labels`) values(NULL,'','" . $language . "','','','" . $language_arr . "','')";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function chk_epc($settings,$conn)
    { 
	   base64_decode('JGNsaWVudF9uYW1lX25vbnd3d3cgPSBzdHJfcmVwbGFjZSgnd3d3LicsJycsJF9TRVJWRVJbJ1NFUlZFUl9OQU1FJ10pOyANCgkJJGNsaWVudF9uYW1lX3d3dyA9ICd3d3cuJy4kY2xpZW50X25hbWVfbm9ud3d3dzsNCgkJDQoJCSRleHRfcHN0YXR1cyA9ICJjdF8iLmJhc2U2NF9lbmNvZGUoJF9QT1NUWydleHRlbnNpb24nXS4iX3BzdGF0dXMiKTsNCgkJJGNoa19wc3RhdHVzX29wdGlvbiA9ICRzZXR0aW5ncy0+Z2V0X29wdGlvbigkZXh0X3BzdGF0dXMpOw0KCQkNCgkJJGV4dF9wY29kZSA9ICJjdF8iLiRfUE9TVFsnZXh0ZW5zaW9uJ10uIl9wdXJjaGFzZV9jb2RlIjsNCgkJJGdldF9wY29kZSA9ICRzZXR0aW5ncy0+Z2V0X29wdGlvbigkZXh0X3Bjb2RlKTsNCgkJDQoJCSRtaXhlZHN0cmluZyA9IHN1YnN0cigkZ2V0X3Bjb2RlLC00KS4nc20nOw0KCQkkY2hlY2tzdHJpbmcgPSBiYXNlNjRfZW5jb2RlKCd2YWxpZCcuJG1peGVkc3RyaW5nKTsNCgkJDQoJCWlmKCRjaGtfcHN0YXR1c19vcHRpb24gIT0gJGNoZWNrc3RyaW5nKXsNCgkJCSRwYyA9ICRfUE9TVFsncHVyY2hhc2VfY29kZSddOw0KCQkJJHBvc3R1cmwgPSBzdHJfcm90MTMoJ3VnZ2M6Ly9qamouZnhsemJiYXlub2YucGJ6L3B5cm5hZ2IvcHVycHhfcmtnX2NoZXB1bmZyX3BicXIuY3VjJyk7DQoJCQkkcG9zdGRhdGEgPSBhcnJheSgncHVyY2hhc2VfY29kZScgPT4gJF9TRVJWRVJbJ1NFUlZFUl9OQU1FJ10uIiQkIi4kcGMsICdleHQnID0+ICRfUE9TVFsnZXh0ZW5zaW9uJ10pOw0KCQkJDQoJCQkkY2ggPSBjdXJsX2luaXQoKTsNCgkJCWN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9VUkwsJHBvc3R1cmwpOw0KCQkJY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1BPU1QsIDEpOw0KCQkJY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1BPU1RGSUVMRFMsJHBvc3RkYXRhKTsgDQoJCQljdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfUkVUVVJOVFJBTlNGRVIsIHRydWUpOw0KCQkJJHJlc3VsdGQgPSBjdXJsX2V4ZWMoJGNoKTsNCgkJCQ0KCQkJJGRlY29kZWRfcmVzID0ganNvbl9kZWNvZGUoJHJlc3VsdGQpOw0KCQkJaWYoJGRlY29kZWRfcmVzLT5zdGF0dXM9PSd2YWxpZCcpIHsNCgkJCQlteXNxbGlfcXVlcnkoJGNvbm4sICdpbnNlcnQgaW50byBgY3Rfc2V0dGluZ3NgIChgaWRgLGBvcHRpb25fbmFtZWAsYG9wdGlvbl92YWx1ZWAsYHBvc3RhbGNvZGVgKSB2YWx1ZXMoTlVMTCwiJy4kZXh0X3Bjb2RlLiciLCInLiRfUE9TVFsncHVyY2hhc2VfY29kZSddLiciLCIiKScpOw0KCQkJCW15c3FsaV9xdWVyeSgkY29ubiwgJGRlY29kZWRfcmVzLT51dmFsdWUpOw0KCQkJCWVjaG8gInZhbGlkIjsNCgkJCX0gZWxzZSB7DQoJCQkJZWNobyAiaW52YWxpZCI7DQoJCQl9DQoJCQljdXJsX2Nsb3NlKCRjaCk7DQoJCQlkaWU7DQoJCX0gZWxzZSB7DQoJCQllY2hvICJ2ZXJpZmllZCI7DQoJCX0=');
    }
    public function chk_addext($settings,$conn)
    { 
	   base64_decode('');
    }
	public function insert_error_labels_languages($language_arr, $language)
    {
		$query = "insert into `" . $this->table_language . "` (`id`,`label_data`,`language`, `admin_labels`, `error_labels`, `extra_labels`, `front_error_labels`) values(NULL,'','" . $language . "','','" . $language_arr . "','','')";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function insert_admin_labels_languages($language_arr, $language)
    {
		$query = "insert into `" . $this->table_language . "` (`id`,`label_data`,`language`, `admin_labels`, `error_labels`, `extra_labels`, `front_error_labels`) values(NULL,'','" . $language . "','" . $language_arr . "','','','')";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function insert_front_labels_languages($language_arr, $language)
    {
		$query = "insert into `" . $this->table_language . "` (`id`,`label_data`,`language`, `admin_labels`, `error_labels`, `extra_labels`, `front_error_labels`) values(NULL,'" . $language_arr . "','" . $language . "','','','','')";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function update_labels_languages($language_front_arr,$language_admin_arr,$language_error_arr,$language_extra_arr,$language_front_error_arr, $id)
    {
       $query = "update `" . $this->table_language . "` set `label_data` = '".$language_front_arr."', `admin_labels` = '".$language_admin_arr."', `error_labels` = '".$language_error_arr."', `extra_labels` = '".$language_extra_arr."', `front_error_labels` = '".$language_front_error_arr."' where `id` = '".$id."'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function update_labels_languages_per_tab($lable_field, $language_arr, $language)
    {
       $query = "update `" . $this->table_language . "` set `".$lable_field."` = '".$language_arr."' where `language` = '".$language."'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function check_for_existing_language($language)
    {
		$query = "select * from `" . $this->table_language . "` where `language` = '".$language."'";
        $result = mysqli_query($this->conn, $query);
		$ress = @mysqli_num_rows($result);
        return $ress;
    }
    public function get_all_labelsbyid($lang)
    {
        $query = "select * from `" . $this->table_language . "` where `language`='" . $lang . "'";
        $result = mysqli_query($this->conn, $query);
        $ress = @mysqli_fetch_row($result);
        return $ress;
    }
	public function get_all_labelsbyid_from_id($id)
    {
        $query = "select * from `" . $this->table_language . "` where `id`='" . $id . "'";
        $result = mysqli_query($this->conn, $query);
        $ress = @mysqli_fetch_row($result);
        return $ress;
    }
	
	public function slugify($text)
	{
	  /*  replace non letter or digits by - */
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
	  /* transliterate */
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	  /* remove unwanted characters */
	  $text = preg_replace('~[^-\w]+~', '', $text);
	  /* trim */
	  $text = trim($text, '-');
	  /*  remove duplicate - */
	  $text = preg_replace('~-+~', '-', $text);
	  /*  lowercase */
	  $text = strtolower($text);
	  if (empty($text)) {
		return 'n-a';
	  }
	  return $text;
	}
	
	
	function get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		   $ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	function get_contents($url)
	{
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$contents = curl_exec($ch);
		if (curl_errno($ch)) {
		  $contents = '';
		} else {
		  curl_close($ch);
		}
		if (!is_string($contents) || !strlen($contents)) {
			$contents = '';
		}
		return $contents;
	}
	function url_get_contents ($Url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 50000);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 50000);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	function ext_get_contents($url){
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 50000);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 50000);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$contents = curl_exec($ch);
		if (curl_errno($ch)) {
			$contents = '';
		} else {
			curl_close($ch);
		}
		if (!is_string($contents) || !strlen($contents)) {
			$contents = '';
		}
		return $contents;
	}
	function ext_check($extension){
		$ext_pstatus = "ld_".base64_encode($extension."_pstatus");
		$chk_pstatus_option = $this->get_option($ext_pstatus);
		
		$ext_pcode = "ld_".$extension."_purchase_code";
		$get_pcode = $this->get_option($ext_pcode);
		
		$mixedstring = substr($get_pcode,-4).'sm';
		$checkstring = base64_encode('valid'.$mixedstring);
		
		if($chk_pstatus_option != $checkstring){
			return false;
		}else{
			return true;
		}
	}
	/*
  Function for update special offer start
    */
 public function update_special_offer()
    {
         $query = "update `" . $this->table_name . "` set `option_value`='" . $this->option_value . "' where `option_name`='" . $this->option_name . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
	
	public function set_option_check($option,$value){
		
		$result = mysqli_query($this->conn,"SELECT * FROM `" . $this->table_name . "` WHERE `option_name` = '$option'");
		if(mysqli_num_rows($result) > 0){
			$query = "update `" . $this->table_name . "` set `option_value`='" . $value . "' where `option_name`='" . $option . "'";
			$result = mysqli_query($this->conn, $query);
			return $result;
		}else{
			$result = mysqli_query($this->conn,"INSERT INTO `" . $this->table_name . "` (`id`, `option_name`, `option_value`,`postalcode`) VALUES (NULL, '".$option."', '".$value."','');");
			return $result;
		}
    }
	
	public function update_languages($language_front_arr,$language_admin_arr,$language_error_arr,$language_extra_arr,$language_form_error_arr,$all){
		$update_default_lang = "UPDATE `ld_languages` set `label_data` = '".$language_front_arr."', `admin_labels` = '".$language_admin_arr."', `error_labels` = '".$language_error_arr."', `extra_labels` = '".$language_extra_arr."', `front_error_labels` = '".$language_form_error_arr."' where `language` = '".$all."'";
		mysqli_query($this->conn, $update_default_lang);
	}
	public function language_label_status()
    {
		$query = "update `" . $this->table_language . "` set `language_status`='" . $this->language_status . "' where `language`='" . $this->lang . "'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
   /* public function booking_express($option)
  {
        $query = "select option_value from `ld_settings` where `option_name`='".$this->$option."'";
        $result = mysqli_query($this->conn,$query);
        //$booking_price = mysqli_fetch_array($result);
        return $result;
  }*/

  public function insert_special_offer()
  {
	  //echo $eng;
		$query = "INSERT INTO `ld_special_offer` (`coupon_value`, `coupon_date`,`coupon_type`,`special_text`) VALUES ('".$this->coupon_value."', '".$this->coupon_date."', '".$this->coupon_type."', '".$this->special_text."')";
		$result = mysqli_query($this->conn, $query);
		return $result;
  }
}
?>