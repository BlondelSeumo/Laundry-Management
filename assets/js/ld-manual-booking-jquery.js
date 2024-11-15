
var ld_postalcode_status_check = 'N';
var guest_user_status = 'off';

jQuery(document).ready(function() {
    jQuery('.ld-loading-main').hide();
    var subheader_status = subheaderObj.subheader_status;
    if (subheader_status == 'Y') {
        jQuery('.ld-sub').show();
    } else {
        jQuery('.ld-sub').hide();
        jQuery('.ld-sub-complete-booking').html('<br>');
    }
    if (ld_postalcode_status_check == 'Y') {
        jQuery('.ld_remove_id').attr('id', '');
        jQuery(document).on('click', '.ld_remove_id', function() {
            jQuery('#ld_postal_code').focus();
            jQuery('#ld_postal_code').keyup();
        });
    }
    jQuery('.ld-loading-main').hide();
    jQuery('.remove_guest_user_preferred_email').hide();
    jQuery('.show_methods_after_service_selection').hide();
    jQuery('.freq_discount_display').hide();
    jQuery('.hide_allsss_addons').hide();
    jQuery('.partial_amount_hide_on_load').hide();
    jQuery('.hide_right_side_box').hide();
    jQuery('.client_logout').hide();
    jQuery('.postal_code_error').show();
    jQuery('.postal_code_error').html(errorobj_please_enter_postal_code);
    jQuery('.hideservice_name').hide();
    jQuery('.hidedatetime_value').hide();
    jQuery('.hideduration_value').hide();
    jQuery('.s_m_units_design_1').hide();
    jQuery('.s_m_units_design_2').hide();
    jQuery('.s_m_units_design_3').hide();
    jQuery('.s_m_units_design_4').hide();
    jQuery('.s_m_units_design_5').hide();
    jQuery('.hidedatetime_del_value').hide();
    jQuery('.hide_self_service').hide()
        jQuery('#new-user').trigger('click');

});

/* dropdown services list */
/* services dropdown show hide list */
jQuery(document).on("click", ".service-is", function() {
    jQuery(".ld-services-dropdown").toggle("blind", {
        direction: "vertical"
    }, 300);
});

jQuery(document).on("click", ".select_service", function() {
    jQuery("#ld_selected_service").html(jQuery(this).html());
    jQuery(".ld-services-dropdown").hide("blind", {
        direction: "vertical"
    }, 300);
});

/* select hours based service */
jQuery(document).on("click", ".ld-duration-btn", function() {
    jQuery('.ld-duration-btn').each(function() {
        jQuery(this).removeClass('duration-box-selected');
    });
    jQuery(this).addClass('duration-box-selected');
});


/* for show how many addon counting when checked */
jQuery(document).ready(function() {
    
    jQuery('input[type="checkbox"]').click(function() {
        
        if (jQuery('.addon-checkbox').is(':checked')) {
            
            jQuery('.common-selection-main.addon-select').show();
            
        } else {
            jQuery('.common-selection-main.addon-select').hide();
        }
    });
});


/* addons */
jQuery(document).on("click", ".ld-addon-btn", function() {
    var curr_methodname = jQuery(this).data('method_name');
    jQuery('.ld-addon-btn').each(function() {
        if (jQuery(this).data('method_name') == curr_methodname) {
            jQuery(this).removeClass('ld-addon-selected');
        }
    });
    jQuery(this).addClass('ld-addon-selected');
});



/* user contact no. */
jQuery(document).ready(function() {
    
    var site_url = siteurlObj.site_url;
    var country_alpha_code = countrycodeObj.alphacode;
    var allowed_country_alpha_code = countrycodeObj.allowed;
    var array = allowed_country_alpha_code.split(',');
    var phone_visi = phone_status.statuss;
    if (phone_visi == "on") {
        if (allowed_country_alpha_code != "") {
            jQuery("#ld-user-phone").intlTelInput({
                onlyCountries: array,
                autoPlaceholder: false,
                utilsScript: site_url + "assets/js/utils.js"
            });
            jQuery(".selected-flag .iti-flag").addClass(country_alpha_code);
            jQuery(".selected-flag").attr("title", countrycodeObj.countrytitle);
        } else {
            jQuery("#ld-user-phone").intlTelInput({
                autoPlaceholder: false,
                utilsScript: site_url + "assets/js/utils.js"
            });
            jQuery(".selected-flag .iti-flag").addClass(country_alpha_code);
            jQuery(".selected-flag").attr("title", countrycodeObj.countrytitle);
        }
    }
});

/* see more instructions in service popup */
jQuery(document).ready(function() {
    jQuery(".show-more-toggler").click(function() {
        jQuery(".bullet-more").toggle("blind", {
            direction: "vertical"
        }, 500);
        jQuery(".show-more-toggler:after").addClass('rotate');
    });
});

jQuery(document).ready(function() {
    jQuery('.panel-collapse').on('show.bs.collapse', function() {
        jQuery(this).siblings('.panel-heading').addClass('active');
    });

    jQuery('.panel-collapse').on('hide.bs.collapse', function() {
        jQuery(this).siblings('.panel-heading').removeClass('active');
    });

    if (jQuery("#self_service").val() == "E") {
        jQuery(document).on("change", "#self_service_status", function() {
            self_service_cart_status = jQuery("#self_service_status").prop("checked");
            if (self_service_cart_status == true) {
                jQuery('.hide_self_service').show();
                self_service_cart_status = self_service_cart_title;
            } else {
                jQuery('.hide_self_service').hide();
            }
            jQuery('.sel-self-service').html(self_service_cart_status);
        });
    }
});

/************* Code by developer side --- ****************/

jQuery(document).on('keyup keydown blur', '.add_show_error_class', function(event) {
    
    var id = jQuery(this).attr('id');
    var Number = /(?:\(?\+\d{2}\)?\s*)?\d+(?:[ -]*\d+)*$/;
    if (jQuery(this).hasClass('error')) {
        jQuery(this).removeClass('error');
        jQuery("#" + id).parent().removeClass('error');
        jQuery(this).addClass('show-error');

        jQuery("#" + id).parent().addClass('show-error');
        if (jQuery('#ld-user-phone').val() != '') {
            if (!jQuery('#ld-user-phone').val().match(Number)) {
                jQuery('.intl-tel-input').parent().addClass('show-error');
            }
        }
    } else {
        jQuery(this).removeClass('error');
        jQuery("#" + id).parent().removeClass('error');
        jQuery(this).removeClass('show-error');
        jQuery("#" + id).parent().removeClass('show-error');
        if (jQuery('#ld-user-phone').val() != '') {
            if (jQuery('#ld-user-phone').val().match(Number)) {
                jQuery('.intl-tel-input').parent().removeClass('show-error');
            }
        }
    }
});

jQuery(document).on('keyup keydown blur', '.add_show_error_class_for_login', function(event) {
    var id = jQuery(this).attr('id');
    if (jQuery(this).hasClass('error')) {
        jQuery(this).removeClass('error');
        jQuery("#" + id).parent().removeClass('error');
        jQuery(this).addClass('show-error');
        jQuery("#" + id).parent().addClass('show-error');
    } else {
        jQuery(this).removeClass('error');
        jQuery("#" + id).parent().removeClass('error');
        jQuery(this).removeClass('show-error');
        jQuery("#" + id).parent().removeClass('show-error');
    }
});

var clicked = false;

jQuery(document).on('click', '#complete_bookings', function(e) {
    
        jQuery('.ld-loading-main').show();
        jQuery('.ld_all_booking_errors').css('display', 'none'); 
        
        var front_url = fronturlObj.front_url;
        var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
        
    var existing_username = jQuery("#ld-user-name").val();
    var existing_password = jQuery("#ld-user-pass").val();
    var password = jQuery("#ld-preffered-pass").val();
    var firstname = jQuery("#ld-first-name").val();
    var lastname = jQuery("#ld-last-name").val();
    var email = jQuery("#ld-email").val();
    var phone = jQuery("#ld-user-phone").val();

    /***newly added start***/
    var user_address = jQuery("#ld-street-address").val();
    var user_zipcode = jQuery("#ld-zip-code").val();
    var user_city = jQuery("#ld-city").val();
    var user_state = jQuery("#ld-state").val();
    if (appoint_details.status == "on") {
        if (check_addresss.status = "on") {
            var address = jQuery("#app-street-address").val();
        } else {
            var address = jQuery("#ld-street-address").val();
        }

        if (check_zip_code.status = "on") {
            var zipcode = jQuery("#app-zip-code").val();
        } else {
            var zipcode = jQuery("#ld-zip-code").val();
        }

        if (check_city.status = "on") {
            var city = jQuery("#app-city").val();
        } else {
            var city = jQuery("#ld-city").val();
        }

        if (check_state.status = "on") {
            var state = jQuery("#app-state").val();
        } else {
            var state = jQuery("#ld-state").val();
        }
    } else {
        var address = jQuery("#ld-street-address").val();
        var zipcode = jQuery("#ld-zip-code").val();
        var city = jQuery("#ld-city").val();
        var state = jQuery("#ld-state").val();
    }

    var self_service_status = 'N';
    if (jQuery("#self_service").val() == "E") {
        self_service_status = jQuery("#self_service_status").prop("checked");

        if (self_service_status == true) {
            self_service_status = 'Y';
        } else {
            self_service_status = 'N';
        }
    }

    /***newly added end***/

    var notes = jQuery("#ld-notes").val();
    var payment_method = 'pay at venue';

    /** new **/
    var staff_id = jQuery('.provider_disable:checked').data('staff_id');

    if (staff_id == undefined) {
        var staff_id = '';
    } else {
        var staff_id = staff_id;
    }

    var con_status = jQuery("#contact_status").val();
    if (con_status == 'Other') {
        var contact_status = jQuery("#other_contact_status").val();
    } else if (con_status == undefined) {
        var contact_status = '';
    } else {
        var contact_status = jQuery("#contact_status").val();
    }

    var booking_del_date_text = "";
    var booking_del_date = "";
    var booking_del_time_slot = "";
    var booking_del_time_start = "";
    var booking_del_time_end = "";
    var booking_del_time_text = "";
    var booking_del_date_time_start = "";
    var booking_del_date_time_end = "";

    if (show_delivery_date == "E") {
             
        booking_del_date = jQuery(".delivery_date_pos").attr('data-date_del_val');
                var delivery_time = jQuery(".delivery_time_pos").attr('data-time_del_val');
                
                if (delivery_time == null){
                    booking_del_time_slot = '';
                }else{
                    booking_del_time_slot = delivery_time.split(" to ");
                }
        booking_del_time_start = booking_del_time_slot[0];
        booking_del_time_end = booking_del_time_slot[1];
        booking_del_time_text = jQuery(".delivery_time_pos").text();
        booking_del_date_time_start = booking_del_date + ' ' + booking_del_time_start;
        booking_del_date_time_end = booking_del_date + ' ' + booking_del_time_end;
        }

    var pickup_time = jQuery(".pickup_time_pos").attr('data-time_val');
        
        if (pickup_time == null){
                booking_time_slot = '';
        }else{
                booking_time_slot = pickup_time.split(" to ");
        }
        
    var booking_date = jQuery(".pickup_date_pos").attr('data-date_val');
    var booking_time_start = booking_time_slot[0];
    var booking_time_end = booking_time_slot[1];
    var booking_time_text = jQuery(".pickup_time_pos").text();
    var booking_pickup_date_time_start = booking_date + ' ' + booking_time_start;
    var booking_pickup_date_time_end = booking_date + ' ' + booking_time_end;

    var currency_symbol = jQuery(this).data('currency_symbol');
    var cart_sub_total = jQuery('.cart_sub_total').text();
    var cart_total = jQuery('.cart_total').text();
    var cart_discount = jQuery('.cart_discount').text().substring(2);
    var cart_tax = jQuery('.cart_tax').text();
    var amount = cart_sub_total.replace(currency_symbol, '');
    var discount = cart_discount.replace(currency_symbol, '');
    var taxes = cart_tax.replace(currency_symbol, '');
    var net_amount = cart_total.replace(currency_symbol, '');
    var cart_counting = jQuery("#total_cart_count").val();

    var no_units_in_cart_err = jQuery('#no_units_in_cart_err').val();
    var no_units_in_cart_err_count = jQuery('#no_units_in_cart_err_count').val();

    dataString = {
        existing_username: existing_username,
        existing_password: existing_password,
        password: password,
        firstname: firstname,
        lastname: lastname,
        email: email,
        phone: phone,
        user_address: user_address,
        user_zipcode: user_zipcode,
        user_city: user_city,
        user_state: user_state,
        address: address,
        zipcode: zipcode,
        city: city,
        state: state,
        notes: notes,
        contact_status: contact_status,
        payment_method: payment_method,
        staff_id: staff_id,
        amount: amount,
        discount: discount,
        taxes: taxes,
        net_amount: net_amount,
        booking_pickup_date_time_start: booking_pickup_date_time_start,
        booking_pickup_date_time_end: booking_pickup_date_time_end,
        booking_delivery_date_time_start: booking_del_date_time_start,
        booking_delivery_date_time_end: booking_del_date_time_end, 
        self_service_status: self_service_status,
        show_delivery_date: show_delivery_date,
        guest_user_status: guest_user_status,
        action: "complete_booking"
    };

     if (jQuery('#user_details_form-2').valid()) {
        if (jQuery("input[name='service-radio']:checked").val() != 'on' && jQuery("#ld-service-0").val() != 'off' && cart_counting == 1) {
            clicked = false;
            jQuery('.ld-loading-main').hide();
            jQuery('.ld_all_booking_errors').css('display', 'block');
            jQuery('.ld_all_booking_errors').css('color', 'red');
            jQuery('.ld_all_booking_errors').html(errorobj_please_select_a_service);
        }
                else if (jQuery('.ser_name_for_error').text() == 'Cleaning Service' && cart_counting == 1) {
            clicked = false;
            jQuery('.ld-loading-main').hide();
            jQuery('.ld_all_booking_errors').css('display', 'block');
            jQuery('.ld_all_booking_errors').css('color', 'red');
            jQuery('.ld_all_booking_errors').html(errorobj_please_select_a_service);
        } else if (jQuery('#ld_selected_servic_method .service-method-name').text() == 'Service Usage Methods' && cart_counting == 1) {
            clicked = false;
            jQuery('.ld-loading-main').hide();
            jQuery('.ld_all_booking_errors').css('display', 'block');
            jQuery('.ld_all_booking_errors').css('color', 'red');
            jQuery('.ld_all_booking_errors').html(errorobj_please_select_method);
        } else if (cart_counting == 1) {
            clicked = false;
            jQuery('.ld-loading-main').hide();
            jQuery('.ld_all_booking_errors').css('display', 'block');
            jQuery('.ld_all_booking_errors').css('color', 'red');
            jQuery('.ld_all_booking_errors').html(errorobj_please_select_units_or_addons);
        } else if (jQuery("#pickup_date").val() == '') {

            clicked = false;
            jQuery('.ld-loading-main').hide();
            jQuery('.ld_all_booking_errors').css('display', 'block');
            jQuery('.ld_all_booking_errors').css('color', 'red');
            jQuery('.ld_all_booking_errors').html(errorobj_please_select_pickup_date);

        } else if (booking_time_text == '') {

            clicked = false;
            jQuery('.ld-loading-main').hide();
            jQuery('.ld_all_booking_errors').css('display', 'block');
            jQuery('.ld_all_booking_errors').css('color', 'red');
            jQuery('.ld_all_booking_errors').html(errorobj_please_select_pickup_slot);
        } else if (jQuery("#delivery_date_POS").val() == '' && show_delivery_date == "E") {

            clicked = false;
            jQuery('.ld-loading-main').hide();
            jQuery('.ld_all_booking_errors').css('display', 'block');
            jQuery('.ld_all_booking_errors').css('color', 'red');
            jQuery('.ld_all_booking_errors').html(errorobj_please_select_delivery_date);

        } else if (booking_del_time_text == '' && show_delivery_date == "E") {

            clicked = false;
            jQuery('.ld-loading-main').hide();
            jQuery('.ld_all_booking_errors').css('display', 'block');
            jQuery('.ld_all_booking_errors').css('color', 'red');
            jQuery('.ld_all_booking_errors').html(errorobj_please_select_delivery_slot);

        } else if (no_units_in_cart_err == 'units_and_addons_both_exists' && no_units_in_cart_err_count == 'unit_not_added') {
            clicked = false;
            jQuery('.ld-loading-main').hide();
            jQuery('.ld_all_booking_errors').css('display', 'block');
            jQuery('.ld_all_booking_errors').css('color', 'red');
            jQuery('.ld_all_booking_errors').html(errorobj_please_select_atleast_one_unit);
                        
        } else if (jQuery('#check_login_click').val() == 'not' && jQuery('#existing-user').prop("checked") == true) {
            clicked = false;
            jQuery('.ld-loading-main').hide();
            jQuery('.ld_all_booking_errors').css('display', 'block');
            jQuery('.ld_all_booking_errors').css('color', 'red');
            jQuery('.ld_all_booking_errors').html(errorobj_please_login_to_complete_booking);
        } else {
            if (clicked === false) {
                clicked = true;
                jQuery('.ld-loading-main').show();
                jQuery.ajax({
                    type: "POST",
                    url: front_url + "manual_booking_checkout.php",
                    data: dataString,
                    success: function(response) {
                         if (jQuery.trim(response) == 'ok') {
                                                        
                              location.reload();
                        } 
                    }
                });

            } else {
                e.preventDefault();
            }
        }
    } else {
        jQuery('.ld-loading-main').hide();
        clicked = false;
    }
        
    jQuery('.add_show_error_class').each(function() {
        jQuery(this).trigger('keyup');
    });
});

jQuery(document).on('change', '#ld_mb_existing_login_dropdown', function() {
    jQuery('.ld-loading-main').show();
    jQuery('.add_show_error_class_for_login').each(function() {
        jQuery(this).trigger('keyup');
    });
    jQuery('.add_show_error_class').each(function() {
        var id = jQuery(this).attr('id');
        jQuery(this).removeClass('error');
        jQuery("#" + id).parent().removeClass('error');
        jQuery(this).removeClass('show-error');
        jQuery("#" + id).parent().removeClass('show-error');
        jQuery('.intl-tel-input').parent().removeClass('show-error');
    });
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var existing_userid = jQuery(this).val();
    if (existing_userid != 0) {
        var dataString = {
            existing_userid: existing_userid,
            action: "get_existing_user_data"
        };
        jQuery.ajax({
            type: "POST",
            url: ajax_url + "manual_booking_frontajax.php",
            data: dataString,
            success: function(response) {
                jQuery('.ld-loading-main').hide();
                jQuery('#check_login_click').val('clicked');
                var userdata = jQuery.parseJSON(response);
                                jQuery(".fancy_input").parent().addClass("focused_label_wrap");
                jQuery(".phone_no_wrap").addClass("focused_label_wrap");
                jQuery('.client_logout').css('display', 'block');
                jQuery('.client_logout').show();
                jQuery(".fname").text(userdata.firstname);
                jQuery(".lname").text(userdata.lastname);
                            
                jQuery('.hide_login_btn').hide();
                jQuery('.hide_radio_btn_after_login').hide();
                jQuery('.hide_email').hide();
                jQuery('.hide_login_email').hide();
                jQuery('.hide_password').hide();
                jQuery('.ld-peronal-details').show();
                jQuery('.login_unsuccessfull').hide();

                jQuery("#ld-user-name").val(userdata.email);
                jQuery("#ld-user-pass").val(userdata.password);

                jQuery("#ld-first-name").val(userdata.firstname);
                jQuery("#ld-last-name").val(userdata.lastname);
                jQuery("#ld-user-phone").intlTelInput("setNumber", userdata.phone);

                if (check_addresss.statuss == "on") {
                    jQuery("#ld-street-address").val(userdata.address);
                }

                if (check_zip_code.statuss == "on") {
                    jQuery("#ld-zip-code").val(userdata.zip);
                }

                if (check_city.statuss == "on") {
                    jQuery("#ld-city").val(userdata.city);
                }

                if (check_state.statuss == "on") {
                    jQuery("#ld-state").val(userdata.state);
                }

                jQuery("#ld-notes").val(userdata.notes);
                var con_staatus = userdata.contact_status;
                if (con_staatus == "I'll be at home" || con_staatus == 'Please call me' || con_staatus == 'The key is with the doorman') {
                    jQuery("#contact_status").val(userdata.contact_status);
                } else {
                    jQuery("#contact_status").val('Other');
                    jQuery(".ld-option-others").show();
                    jQuery("#other_contact_status").val(userdata.contact_status);
                }
            }
        });
    } else {
        jQuery('.ld-loading-main').hide();
    }
});

jQuery(document).on("click", "#existing-user", function() {
     jQuery('.hide_login_email').show();
});

jQuery(document).ready(function() {
     jQuery('.hide_login_email').hide();
    var front_url = fronturlObj.front_url;
    jQuery.validator.addMethod("pattern_phone", function(value, element) {
        return this.optional(element) || /^[0-9+]*$/.test(value);
    }, "Enter Only Numerics");

    jQuery.validator.addMethod("pattern_zip", function(value, element) {
        return this.optional(element) || /^[a-zA-Z 0-9\-\ ]*$/.test(value);
    }, "Enter Only Alphabets");

    jQuery.validator.addMethod("pattern_name", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ']+$/.test(value);
    }, "Enter Only Alphabets");

    jQuery.validator.addMethod("pattern_city_state", function(value, element) {
        return this.optional(element) || /^[a-zA-Z &]+$/.test(value);
    }, "Enter Only Alphabets");

    var phone_check = phone_status;
    var password_check = check_password;
    var fn_check = check_fn;
    var ln_check = check_ln;
    var address_check = check_addresss;
    var zip_check = check_zip_code;
    var city_check = check_city;
    var state_check = check_state;
    var notes_check = check_notes;

    jQuery("#user_details_form-2").validate();
    if (appoint_details.status == "on") {
        if (check_addresss.statuss == "on" && check_addresss.required == "Y") {
            jQuery("#app-street-address").rules("add", {
                required: true,
                minlength: check_addresss.min,
                maxlength: check_addresss.max,
                messages: {
                    required: errorobj_req_sa,
                    minlength: errorobj_min_sa,
                    maxlength: errorobj_max_sa
                }
            });
        }

        if (check_zip_code.statuss == "on" && check_zip_code.required == "Y") {
            jQuery("#app-zip-code").rules("add", {
                required: true,
                minlength: check_zip_code.min,
                maxlength: check_zip_code.max,
                messages: {
                    required: errorobj_req_zc,
                    minlength: errorobj_min_zc,
                    maxlength: errorobj_max_zc
                }
            });
        }

        if (check_city.statuss == "on" && check_city.required == "Y") {
            jQuery("#app-city").rules("add", {
                required: true,
                minlength: check_city.min,
                maxlength: check_city.max,
                messages: {
                    required: errorobj_req_ct,
                    minlength: errorobj_min_ct,
                    maxlength: errorobj_max_ct
                }
            });
        }

        if (check_state.statuss == "on" && check_state.required == "Y") {
            jQuery("#app-state").rules("add", {
                required: true,
                minlength: check_state.min,
                maxlength: check_state.max,
                messages: {
                    required: errorobj_req_st,
                    minlength: errorobj_min_st,
                    maxlength: errorobj_max_st
                }
            });
        }
    }

    if (fn_check.statuss == "on" && fn_check.required == "Y") {
        jQuery("#ld-first-name").rules("add", {
            required: true,
            minlength: fn_check.min,
            maxlength: fn_check.max,
            messages: {
                required: errorobj_req_fn,
                minlength: errorobj_min_fn,
                maxlength: errorobj_max_fn
            }
        });
    }

    if (ln_check.statuss == "on" && ln_check.required == "Y") {
        jQuery("#ld-last-name").rules("add", {
            required: true,
            minlength: ln_check.min,
            maxlength: ln_check.max,
            messages: {
                required: errorobj_req_ln,
                minlength: errorobj_min_ln,
                maxlength: errorobj_max_ln
            }
        });
    }

    if (phone_check.statuss == "on" && phone_check.required == "Y") {
        jQuery("#ld-user-phone").rules("add", {
            required: true,
            minlength: phone_check.min,
            maxlength: phone_check.max,
            messages: {
                required: errorobj_req_ph,
                minlength: errorobj_min_ph,
                maxlength: errorobj_max_ph,
            }
        });
    }

    if (address_check.statuss == "on" && address_check.required == "Y") {
        jQuery("#ld-street-address").rules("add", {
            required: true,
            minlength: address_check.min,
            maxlength: address_check.max,
            messages: {
                required: errorobj_req_sa,
                minlength: errorobj_min_sa,
                maxlength: errorobj_max_sa
            }
        });
    }

    if (zip_check.statuss == "on" && zip_check.required == "Y") {
        jQuery("#ld-zip-code").rules("add", {
            required: true,
            minlength: zip_check.min,
            maxlength: zip_check.max,
            messages: {
                required: errorobj_req_zc,
                minlength: errorobj_min_zc,
                maxlength: errorobj_max_zc
            }
        });
    }

    if (city_check.statuss == "on" && city_check.required == "Y") {
        jQuery("#ld-city").rules("add", {
            required: true,
            minlength: city_check.min,
            maxlength: city_check.max,
            messages: {
                required: errorobj_req_ct,
                minlength: errorobj_min_ct,
                maxlength: errorobj_max_ct
            }
        });
    }

    if (state_check.statuss == "on" && state_check.required == "Y") {
        jQuery("#ld-state").rules("add", {
            required: true,
            minlength: state_check.min,
            maxlength: state_check.max,
            messages: {
                required: errorobj_req_st,
                minlength: errorobj_min_st,
                maxlength: errorobj_max_st
            }
        });
    }

    if (notes_check.statuss == "on" && notes_check.required == "Y") {
        jQuery("#ld-notes").rules("add", {
            required: true,
            minlength: notes_check.min,
            maxlength: notes_check.max,
            messages: {
                required: errorobj_req_srn,
                minlength: errorobj_min_srn,
                maxlength: errorobj_max_srn
            }
        });
    }

    if (password_check.statuss == "on" && password_check.required == "Y") {
        jQuery("#ld-preffered-pass").rules("add", {
            required: true,
            minlength: password_check.min,
            maxlength: password_check.max,
            messages: {
                required: errorobj_please_enter_password,
                minlength: errorobj_min_ps,
                maxlength: errorobj_max_ps
            }
        });

        jQuery("#ld-email").rules("add", {
            required: true,
            email: true,
            remote: {
                url: front_url + "manual_booking_firststep.php",
                type: "POST",
                async: false,
                data: {
                    email: function() {
                        return jQuery("#ld-email").val();
                    },
                    action: "check_user_email"
                }
            },
            messages: {
                required: errorobj_please_enter_email_address,
                email: errorobj_please_enter_valid_email_address,
                remote: errorobj_email_already_exists
            }
        });
    }
});

jQuery(document).on("change", ".existing-user", function() {
    if (jQuery('.existing-user').is(':checked')) {
        jQuery("#ld-email-guest").val('');
        jQuery("#ld-user-name").val('');
        jQuery("#ld-user-pass").val('');
        jQuery("#ld-preffered-name").val('');
        jQuery("#ld-preffered-pass").val('');
        jQuery("#ld-first-name").val('');
        jQuery("#ld-last-name").val('');
        jQuery("#ld-email").val('');
        jQuery("#ld-user-phone").val('');
        jQuery("#ld-street-address").val('');
        jQuery("#ld-zip-code").val('');
        jQuery("#ld-city").val('');
        jQuery("#ld-state").val('');
        jQuery("#ld-notes").val('');
        jQuery('.ld-login-existing').show("blind", {
            direction: "vertical"
        }, 700);
        jQuery('.ld-new-user-details').hide("blind", {
            direction: "vertical"
        }, 300);
        jQuery('.ld-peronal-details').hide("blind", {
            direction: "vertical"
        }, 300);
        guest_user_status = 'off';
    }
});
jQuery(document).on("change", ".new-user", function() {
    if (jQuery('.new-user').is(':checked')) {
        jQuery("#ld-email-guest").val('');
        jQuery("#ld-user-name").val('');
        jQuery("#ld-user-pass").val('');
        jQuery("#ld-preffered-name").val('');
        jQuery("#ld-preffered-pass").val('');
        jQuery("#ld-first-name").val('');
        jQuery("#ld-last-name").val('');
        jQuery("#ld-email").val('');
        jQuery("#ld-user-phone").val('');
        jQuery("#ld-street-address").val('');
        jQuery("#ld-zip-code").val('');
        jQuery("#ld-city").val('');
        jQuery("#ld-state").val('');
        jQuery("#ld-notes").val('');
        jQuery('.ld-new-user-details').show("blind", {
            direction: "vertical"
        }, 700);
        jQuery('.ld-login-existing').hide("blind", {
            direction: "vertical"
        }, 300);
        jQuery('.ld-peronal-details').show("blind", {
            direction: "vertical"
        }, 300);
        jQuery('.remove_preferred_password_and_preferred_email').show("blind", {
            direction: "vertical"
        }, 300);
        jQuery('.remove_guest_user_preferred_email').hide("blind", {
            direction: "vertical"
        }, 300);
        if (jQuery(".remove_zip_code_class").hasClass("ld-md-6")) {
            jQuery('.remove_zip_code_class').removeClass('ld-md-6');
            jQuery('.remove_zip_code_class').addClass('ld-md-6');
        }
        if (jQuery(".remove_city_class").hasClass("ld-md-6")) {
            jQuery('.remove_city_class').removeClass('ld-md-6');
            jQuery('.remove_city_class').addClass('ld-md-6');
        }
        if (jQuery(".remove_state_class").hasClass("ld-md-6")) {
            jQuery('.remove_state_class').removeClass('ld-md-6');
            jQuery('.remove_state_class').addClass('ld-md-6');
        }
        guest_user_status = 'off';
    }
});

jQuery(document).on("click", "#ld_change_customer", function() {
    
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    jQuery('#check_login_click').val('not');
    jQuery('.client_logout').hide();
    jQuery('.client_logout').css('display', 'none');
    jQuery("#other_contact_status").hide();
    jQuery('.hide_login_btn').show();
    jQuery('.ld-peronal-details').hide();
    jQuery('.hide_radio_btn_after_login').show();
    jQuery('.hide_email').show();
    jQuery('.hide_login_email').show();
    jQuery('.hide_password').show();
    jQuery("#ld-user-name").val('');
    jQuery("#ld-user-pass").val('');
    jQuery("#ld-preffered-name").val('');
    jQuery("#ld-preffered-pass").val('');
    jQuery("#ld-first-name").val('');
    jQuery("#ld-last-name").val('');
    jQuery("#ld-email").val('');
    jQuery("#ld-user-phone").val('');
    jQuery("#ld-street-address").val('');
    jQuery("#ld-zip-code").val('');
    jQuery("#ld-city").val('');
    jQuery("#ld-state").val('');
    jQuery("#ld-notes").val('');
    jQuery("#vaccum-yes").prop('checked', true);
    jQuery("#parking-yes").prop('checked', true);
    jQuery("#contact_status").val("I'll be at home");
    jQuery("#other_contact_status").val('');
    jQuery("#ld_mb_existing_login_dropdown").val(jQuery("#ld_mb_existing_login_dropdown option:first").val());
    jQuery('#ld_mb_existing_login_dropdown').selectpicker('refresh');
});

/* dropdown services methods list */
/* services methods dropdown show hide list */
jQuery(document).on("click", ".service-method-is", function() {
    jQuery(".ld-services-method-dropdown").toggle("blind", {
        direction: "vertical"
    }, 300);
});

jQuery(document).on("click", ".select_service_method", function() {
    jQuery("#ld_selected_servic_method").html(jQuery(this).html());
    jQuery(".ld-services-method-dropdown").hide("blind", {
        direction: "vertical"
    }, 300);
    jQuery('#ld_selected_servic_method h3').removeClass('s_m_units_design');
});

var count_cart = 0;
var current_service_name = "";
var cart_dynamic_key = "";
var check_cart_details = true;

jQuery(document).on('click', '.ser_details', function() {

        check_cart_details = false;
    jQuery(":input", this).prop('checked', true);
    jQuery('.ld-loading-main').show();
    jQuery('.hideduration_value').hide();
    jQuery('.total_time_duration_text').html('');
    jQuery('.service_not_selected_error_d2').removeAttr('style', '');
    jQuery('.service_not_selected_error_d2').html(errorobj_please_select_a_service);
    jQuery('.add_addon_in_cart_for_multipleqty').data('status', '2');
    jQuery('.service_not_selected_error').hide();
    jQuery('.partial_amount_hide_on_load').hide();
    jQuery('.hide_right_side_box').hide();
    jQuery('.ld_all_booking_errors').hide();
    jQuery('.hideservice_name').show();
    jQuery('.empty_cart_error').hide();
    jQuery('.no_units_in_cart_error').hide();

    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var id = jQuery(this).data('id');
    var name = jQuery(this).data('servicetitle');
        var current_service_name =  name;

        var check_li_exist=true;
        var force_hidden = "";
      var old_cart_dynamic_key = 0;
        
    jQuery('.cart_toggle_head').each(function(){

        var service_head_id = jQuery(this).attr("data-service_id");
        var service_head_cart_dynamic_key = jQuery(this).attr("data-id");
        var remove_li_class = "cart_service_item_listing_li"+service_head_cart_dynamic_key;
        var check_ul_class = "ld-addon-items-list_"+service_head_cart_dynamic_key;
        if (jQuery("."+check_ul_class+" li").length == 0){
            jQuery("."+remove_li_class).remove();
        }
        if(service_head_id == id){
            check_li_exist = false;
            old_cart_dynamic_key = service_head_cart_dynamic_key;
        }
    });
    
    
    if(check_li_exist){
            count_cart++;
            cart_dynamic_key = id+"_"+count_cart;
            var ser_ids_lis="cart_service_item_listing_li"+cart_dynamic_key;
            var ser_ids_h4_class="cart_toggle_head_4_"+cart_dynamic_key;
            var ser_ids_uls="cart_item_listing"+cart_dynamic_key;
            var ser_ids_divs="cart_toggle_content_"+cart_dynamic_key;
            var ser_ids_iis="ct_icon_check_"+cart_dynamic_key;
            var ser_datetime="hidedatetime_value_"+cart_dynamic_key;
            var ser_cart_date="cart_date_"+cart_dynamic_key;
            var ser_cart_time="cart_time_"+cart_dynamic_key;
            var lidtls="<li class='"+ser_ids_lis+"'><h4 class='cart_toggle_head "+ser_ids_h4_class+"' data-id='"+cart_dynamic_key+"' data-service_id='"+id+"' >"+current_service_name+"<i class='fa fa-plus pull-right "+ser_ids_iis+"'></i></h4> <div id='"+ser_ids_divs+"' class='cart_toggle_content' style='display:none ;'><ul class='ld-addon-items-list_"+cart_dynamic_key+"'></ul></li>";
            jQuery(".cart_item_listing").append(lidtls);
    }else{
        cart_dynamic_key = old_cart_dynamic_key;
    } 
    jQuery('.addon_qty').each(function() {
            jQuery(this).val(0);
            jQuery('.add_minus_button').hide();
    });

    jQuery.ajax({
        type: 'post',
        data: {
            'service_id': id,
                        'cart_dynamic_key':cart_dynamic_key,
            'get_service_units': 1
        },
        url: ajax_url + "manual_booking_frontajax.php",
        success: function(res) {
            jQuery('.ld-loading-main').hide();
            if (res == 'Extra Services Not Available') {
                jQuery('.hide_allsss_addons').hide();
            } else {
                jQuery('.hide_allsss_addons').show();
                jQuery('.add_on_lists').html(res);
                jQuery('.add_addon_in_cart_for_multipleqty').each(function() {
                    var multiqty_addon_id = jQuery(this).data('id');
                    var value = jQuery(this).prop('checked');
                    if (value == true) {
                        jQuery('#ld-addon-' + multiqty_addon_id).attr('checked', false);
                    }
                });
            }
            jQuery('.addon-service-list').slick({
               dots: true,
              infinite: false,
              speed: 300,
              slidesToShow: 5,
              slidesToScroll: 1,
              responsive: [
                {
                  breakpoint: 1300,
                  settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                  }
                },
                {
                  breakpoint: 1023,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                  }
                },
                {
                  breakpoint: 991,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }
                 ]
            });
        }
    });
    jQuery(".remove_service_class").each(function() {
        jQuery(this).addClass("ser_details");
    });
    jQuery(this).removeClass("ser_details");
    return false;
});   


jQuery(document).on('click', '.addons_servicess_2', function() {
    var id = jQuery(this).data('id');
    jQuery('.add_minus_buttonid' + id).show();
    var u_name = jQuery(this).data('unamee');
    var value = jQuery(this).prop('checked');
    if (value == false) {
        jQuery('.qtyyy_' + u_name).val(0);
        var addon_id = jQuery(this).data('id');
        jQuery('#minus' + addon_id).trigger('click');
    } else if (value == true) {
        var addon_id = jQuery(this).data('id');
        jQuery('#add' + addon_id).trigger('click');
    }
});
/* bedroom and bathroom counting for addons */

jQuery(document).on('click', '.add', function() {

    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var ids = jQuery(this).data('ids');
    var db_qty = jQuery(this).data('db-qty');
    var service_id = jQuery(this).data('service_id');
    var unit_name = jQuery(this).data('unit_name');
    var units_id = jQuery(this).data('units_id');
    var u_name = jQuery(this).data('unamee');
    var minlimit = jQuery(this).data('minlimit');

    jQuery('.coupon_display').hide();
    jQuery('.hide_coupon_textbox').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_invalid_error').hide();
    var qty_val = parseInt(jQuery('.qtyyy_' + u_name).val());
    var qty_vals = qty_val + 1;

    if (qty_val < db_qty) {
        if (qty_val == 0) {
            qty_vals = minlimit;
        }
        jQuery('.qtyyy_' + u_name).val(qty_vals);
        var final_qty_val = qty_vals;
        jQuery.ajax({
            type: 'post',
            data: {
                'service_id': service_id,
                'unit_qty': final_qty_val,
                'units_id': units_id,
                'unit_name': unit_name,
                        'cart_dynamic_key':cart_dynamic_key,
                'add_to_cart': 1
            },
            url: site_url + "front/manual_booking_firststep.php",
            success: function(res) {
                jQuery('.ld_all_booking_errors').hide();
                var cart_session_data = jQuery.parseJSON(res);
                if (cart_session_data.subtotal_amount == 0) {
                    jQuery('.hideduration_value').hide();
                    jQuery(".cart_empty_msg").show();
                    jQuery('.partial_amount_hide_on_load').hide();
                    jQuery('.cart_sub_total').empty();
                    jQuery('.cart_tax').empty();
                    jQuery('.cart_total').empty();
                    jQuery('.cart_item_listing').html(cart_session_data.cart_html);
                    jQuery('.partial_amount').html(cart_session_data.partial_amount);
                    jQuery('.remain_amount').html(cart_session_data.remain_amount);
                    jQuery("#total_cart_count").val('1');
                } else {
                    var lidtls=cart_session_data.cart_html;
                                        jQuery('.hideduration_value').show();
                    jQuery(".cart_empty_msg").hide();
                    jQuery('.partial_amount_hide_on_load').show();
                    jQuery('.ld-addon-items-list_'+cart_dynamic_key).html(lidtls); 
                    jQuery('.cart_sub_total').html(cart_session_data.subtotal);
                    jQuery('.cart_tax').html(cart_session_data.cart_tax);
                    jQuery('.cart_total').html(cart_session_data.total_amount);
                    jQuery('.partial_amount').html(cart_session_data.partial_amount);
                    jQuery('.remain_amount').html(cart_session_data.remain_amount);
                    jQuery("#total_cart_count").val('2');
                }
            }
        });

    } else {
        jQuery('.ld-loading-main').hide();
        jQuery('.qtyyy_' + u_name).val(db_qty);
    }
});


jQuery(document).on('click', '.minus', function() {
    
    jQuery('.freq_disc_empty_cart_error').hide();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var ids = jQuery(this).data('ids');
    var service_id = jQuery(this).data('service_id');
    var unit_name = jQuery(this).data('unit_name');
    var units_id = jQuery(this).data('units_id');
    var u_name = jQuery(this).data('unamee');
    var minlimit = jQuery(this).data('minlimit');


    jQuery('.coupon_display').hide();
    jQuery('.hide_coupon_textbox').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_invalid_error').hide();
    var type = jQuery(this).data('type');

    var qty_val = parseInt(jQuery('.qtyyy_' + u_name).val());
    var qty_vals = qty_val - 1;

    var qty_val = parseInt(jQuery('.qtyyy_' + u_name).val());
    var qty_vals = qty_val - 1;
    var currentVal = parseInt(jQuery('.qtyyy_' + u_name).val());
    if (currentVal <= 0) {}

    if (qty_vals < minlimit) {
        qty_vals = 0;
        jQuery('.add_minus_buttonid' + units_id).hide();
        jQuery(".update_qty_of_s_m_" + u_name).remove();
        jQuery('#ld-addon-' + units_id).attr('checked', false);
        jQuery('#total_cart_count').val(1);
    }
    jQuery('.qtyyy_' + u_name).val(qty_vals);
    jQuery.ajax({
        type: 'post',
        data: {
            'service_id': service_id,
            'unit_qty': qty_vals,
            'units_id': units_id,
            'unit_name': unit_name,
                        'cart_dynamic_key':cart_dynamic_key,
            'add_to_cart': 1
        },
        url: site_url + "front/manual_booking_firststep.php",
        success: function(res) {
            jQuery('.ld_all_booking_errors').hide();
            var cart_session_data = jQuery.parseJSON(res);
                        if (cart_session_data.current_item_qty == 0) {
                                jQuery(".update_qty_of_s_m_"+units_id+service_id).remove();
                                jQuery('.cart_sub_total').html(cart_session_data.subtotal);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.cart_total').html(cart_session_data.total_amount);
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                        }else if (cart_session_data.subtotal_amount == 0) {
                jQuery('.hideduration_value').hide();
                jQuery(".cart_empty_msg").show();
                jQuery('.partial_amount_hide_on_load').hide();
                jQuery('.cart_sub_total').empty();
                jQuery('.cart_tax').empty();
                jQuery('.cart_total').empty();
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery("#total_cart_count").val('1');
            } else {
                jQuery('.hideduration_value').show();
                jQuery(".cart_empty_msg").hide();
                jQuery('.partial_amount_hide_on_load').show();
                        var lidtls=cart_session_data.cart_html;
                        jQuery('.ld-addon-items-list_'+cart_dynamic_key).html(lidtls); 
                jQuery('.cart_sub_total').html(cart_session_data.subtotal);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.cart_total').html(cart_session_data.total_amount);
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery("#total_cart_count").val('2');
            }
        }
    });
});

/* new existing user */

/* ld_user_radio_group */

jQuery(document).on("change", ".existing-user", function() {
    if (jQuery('.existing-user').is(':checked')) {
        jQuery('.ld-login-existing').show("blind", {
            direction: "vertical"
        }, 700);
        jQuery('.ld-new-user-details').hide("blind", {
            direction: "vertical"
        }, 300);
        jQuery('.ld-peronal-details').hide("blind", {
            direction: "vertical"
        }, 300);
    }
});
jQuery(document).on("change", ".new-user", function() {
    if (jQuery('.new-user').is(':checked')) {
        jQuery('.ld-new-user-details').show("blind", {
            direction: "vertical"
        }, 700);
        jQuery('.ld-login-existing').hide("blind", {
            direction: "vertical"
        }, 300);
        jQuery('.ld-peronal-details').show("blind", {
            direction: "vertical"
        }, 300);

    }
});



jQuery(document).on("click", "#contact_status", function() {
    var contact_status = jQuery("#contact_status").val();
    if (contact_status == 'Other') {
        jQuery(".ld-option-others").show();
    } else {
        jQuery(".ld-option-others").hide();
    }
});

/* service checkbox */

jQuery(document).ready(function() {

     jQuery('.pos_details').first().trigger('click');
    jQuery("input[name=service-radio]").click(function() {
    });
});


/* bedrooms dropdown show hide list */
jQuery(document).on("click", ".select-bedrooms", function() {
    var unit_id = jQuery(this).data('un_id');
    jQuery(".ct-" + unit_id + "-dropdown").toggle("blind", {
        direction: "vertical"
    }, 300);
});

/* select on click on bedroom */
jQuery(document).on("click", ".select_bedroom", function() {
    var units_id = jQuery(this).data('units_id');
    jQuery('#ld_selected_' + units_id).html(jQuery(this).html());
    jQuery(".ct-" + units_id + "-dropdown").hide("blind", {
        direction: "vertical"
    }, 300);
});



jQuery(document).on("click", ".select-language", function() {
    jQuery(".ld-language-dropdown").toggle("blind", {
        direction: "vertical"
    }, 300);
});
jQuery(document).on("click", ".select_language_view", function() {
    var ajax_url = ajaxurlObj.ajax_url;
    jQuery('#ld_selected_language').html(jQuery(this).html());
    jQuery(".ld-language-dropdown").hide("blind", {
        direction: "vertical"
    }, 300);
    jQuery.ajax({
        type: 'POST',
        data: {
            'select_language': "yes",
            "set_language": jQuery(this).data("langs")
        },
        url: ajax_url + "manual_booking_frontajax.php",
        success: function(res) {
            location.reload();
        }
    });
});


/* remove item btn-from the cart */
jQuery(document).on("click", ".remove_item_from_cart", function() {
    var ajax_url = ajaxurlObj.ajax_url;
    var unit_id = jQuery(this).data('units_id');
    var service_id = jQuery(this).data('service_id');
        var cart_dynamic_key = jQuery(this).data('key');
    jQuery('#apply_coupon').show();
    jQuery('#coupon_val').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_display').hide();
    jQuery.ajax({
        type: 'POST',
        data: {
            'unit_id': unit_id,
            'service_id': service_id,
                        'cart_dynamic_key': cart_dynamic_key,
            'cart_item_remove': 1
        },
        url: ajax_url + "manual_booking_frontajax.php",
        success: function(res) {
            var cart_session_data = jQuery.parseJSON(res);
            jQuery('#ld_area_m_units').val('');
            jQuery('#qty' +unit_id).val('0');
            jQuery('.add_minus_buttonid' + unit_id).hide();
            jQuery('.qtyyy_ad_unit' + unit_id).val('0');
            jQuery('#ld-addon-' + unit_id).data('status', '2');
            jQuery('#ld-addon-' + unit_id).prop('checked', false);

            if (cart_session_data.status == 'empty calculation') {
                jQuery('.hideduration_value').hide();
                jQuery('.total_time_duration_text').html('');
                jQuery("#total_cart_count").val('1');
                jQuery('.partial_amount_hide_on_load').hide();
                jQuery('.hide_right_side_box').hide();
                jQuery(".cart_empty_msg").show();
                jQuery(".cart_item_listing").empty();
                jQuery(".cart_sub_total").empty();
                jQuery(".cart_tax").empty();
                jQuery(".cart_total").empty();
                jQuery(".remain_amount").empty();
                jQuery(".partial_amount").empty();
                jQuery(".cart_discount").empty();
                                jQuery(".cart_item_listing").remove();                                                                                                                    
            }else if(cart_session_data.status == 'cart not empty'){
                                jQuery("#total_cart_count").val('2');
                jQuery(".cart_empty_msg").hide();
                                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                                jQuery(".update_qty_of_s_m_" + unit_id+service_id).remove();
                jQuery('.cart_sub_total').html(cart_session_data.subtotal_amount);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.cart_total').html(cart_session_data.total_amount);     
                        } else {
                jQuery("#total_cart_count").val('2');
                jQuery(".cart_empty_msg").hide();
                jQuery(".update_qty_of_s_m_" + unit_id+service_id).remove();
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                                jQuery('.cart_sub_total').html(cart_session_data.subtotal_amount);
                jQuery('.cart_total').html(cart_session_data.total_amount);
            }
        }
    });
});


/* bedroom counting */

jQuery(document).on("click", ".select_m_u_btn", function() {
    var units_id = jQuery(this).data('units_id');
    jQuery('.u_' + units_id + '_btn').each(function() {
        jQuery(this).removeClass('ld-bed-selected');
    });
    jQuery(this).addClass('ld-bed-selected');
});


/* bedroom and bathroom counting */
jQuery(document).on('click', '.addd', function() {
    jQuery('.freq_disc_empty_cart_error').hide();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var ids = jQuery(this).data('ids');
    var db_qty = jQuery(this).data('db-qty');
    var service_id = jQuery(this).data('service_id');
    var method_id = jQuery(this).data('method_id');
    var method_name = jQuery(this).data('method_name');
    var units_id = jQuery(this).data('units_id');
    var type = jQuery(this).data('type');
    var m_name = jQuery(this).data('mnamee');
    var hfsec = jQuery(this).data('hfsec');
    var unit_symbol = jQuery(this).data('unit_symbol');
    jQuery('.coupon_display').hide();
    jQuery('.hide_coupon_textbox').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_invalid_error').hide();
    var frequently_discount_id = jQuery("input[name=frequently_discount_radio]:checked").data('id');
    var qty_val = 0;
    if (unit_symbol != "") {
        var qty_val_orignal = jQuery('#qty' + ids).val();
        var qty_val_array = qty_val_orignal.split(" ");
        qty_val = parseFloat(qty_val_array[0]);
    } else {
        qty_val = parseFloat(jQuery('#qty' + ids).val());
    }
    var qty_vals = qty_val + hfsec;

    if (qty_val < db_qty) {
        jQuery('.qty' + ids).val(qty_vals + " " + unit_symbol);
        var final_qty_val = qty_vals;
        jQuery.ajax({
            type: 'post',
            data: {
                'method_id': method_id,
                'service_id': service_id,
                'units_id': units_id,
                'qty_vals': final_qty_val,
                'hfsec': hfsec,
                                'cart_dynamic_key':cart_dynamic_key,
                's_m_units_maxlimit_4_ratesss': 1
            },
            url: ajax_url + "manual_booking_frontajax.php",
            success: function(res) {
                jQuery('.data_qtyrate').attr("data-rate", res);
                jQuery.ajax({
                    type: 'post',
                    data: {
                        'method_id': method_id,
                        'service_id': service_id,
                        's_m_qty': final_qty_val,
                        's_m_rate': res,
                        'method_name': method_name,
                        'units_id': units_id,
                        'frequently_discount_id': frequently_discount_id,
                                                'cart_dynamic_key':cart_dynamic_key,
                        'type': type,
                        'add_to_cart': 1
                    },
                    url: site_url + "front/manual_booking_firststep.php",
                    success: function(res) {
                        jQuery('.freq_discount_display').show();
                        jQuery('.hide_right_side_box').show();
                        jQuery('.partial_amount_hide_on_load').show();
                        jQuery('.empty_cart_error').hide();
                        jQuery('.no_units_in_cart_error').hide();
                        jQuery('.coupon_invalid_error').hide();
                        jQuery("#total_cart_count").val('2');
                        var cart_session_data = jQuery.parseJSON(res);
                        jQuery('#no_units_in_cart_err').val(cart_session_data.unit_status);
                        jQuery('#no_units_in_cart_err_count').val(cart_session_data.unit_require);
                        if (cart_session_data.status == 'update') {
                            jQuery(".cart_empty_msg").hide();
                            jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).html(cart_session_data.s_m_html);
                            jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-service_id', service_id);
                            jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-method_id', method_id);
                            jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-units_id', units_id);
                            jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                            jQuery('.partial_amount').html(cart_session_data.partial_amount);
                            jQuery('.remain_amount').html(cart_session_data.remain_amount);
                            jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                            jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                            jQuery('.cart_tax').html(cart_session_data.cart_tax);
                            jQuery('.cart_total').html(cart_session_data.total_amount);
                        } else if (cart_session_data.status == 'insert') {
                            jQuery('.hideduration_value').show();
                            jQuery(".cart_empty_msg").hide();
                            jQuery('.cart_item_listing').append(cart_session_data.s_m_html);
                            jQuery('.partial_amount').html(cart_session_data.partial_amount);
                            jQuery('.remain_amount').html(cart_session_data.remain_amount);
                            jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                            jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                            jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                            jQuery('.cart_tax').html(cart_session_data.cart_tax);
                            jQuery('.cart_total').html(cart_session_data.total_amount);
                        } else if (cart_session_data.status == 'firstinsert') {
                            jQuery('.hideduration_value').show();
                            jQuery(".cart_empty_msg").hide();
                            jQuery('.cart_item_listing').append(cart_session_data.s_m_html);
                            jQuery('.partial_amount').html(cart_session_data.partial_amount);
                            jQuery('.remain_amount').html(cart_session_data.remain_amount);
                            jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                            jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                            jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                            jQuery('.cart_tax').html(cart_session_data.cart_tax);
                            jQuery('.cart_total').html(cart_session_data.total_amount);
                        } else if (cart_session_data.status == 'empty calculation') {
                            jQuery('.hideduration_value').hide();
                            jQuery('.total_time_duration_text').html('');
                            jQuery('.freq_discount_display').hide();
                            jQuery('.partial_amount_hide_on_load').hide();
                            jQuery('.hide_right_side_box').hide();
                            jQuery(".cart_empty_msg").show();
                            jQuery(".frequent_discount").empty();
                            jQuery(".cart_item_listing").empty();
                            jQuery(".cart_sub_total").empty();
                            jQuery(".cart_tax").empty();
                            jQuery(".cart_total").empty();
                            jQuery(".remain_amount").empty();
                            jQuery(".partial_amount").empty();
                            jQuery(".cart_discount").empty();
                        } else if (cart_session_data.status == 'delete particuler') {
                            jQuery(".cart_empty_msg").hide();
                             jQuery(".update_qty_of_s_m_" + units_id+service_id).remove();
                            jQuery('.partial_amount').html(cart_session_data.partial_amount);
                            jQuery('.remain_amount').html(cart_session_data.remain_amount);
                            jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                            jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                            jQuery('.cart_tax').html(cart_session_data.cart_tax);
                            jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                            jQuery('.cart_total').html(cart_session_data.total_amount);
                        }
                    }
                });
            }
        });
    } else {
        jQuery('.ld-loading-main').hide();
        jQuery('.qty' + ids).val(qty_vals + " " + unit_symbol);
    }

});
jQuery(document).on('click', '.minuss', function() {
    jQuery('.freq_disc_empty_cart_error').hide();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var ids = jQuery(this).data('ids');
    var service_id = jQuery(this).data('service_id');
    var method_id = jQuery(this).data('method_id');
    var method_name = jQuery(this).data('method_name');
    var hfsec = jQuery(this).data('hfsec');
    var units_id = jQuery(this).data('units_id');
    var type = jQuery(this).data('type');
    var unit_symbol = jQuery(this).data('unit_symbol');
    var frequently_discount_id = jQuery("input[name=frequently_discount_radio]:checked").data('id');
    jQuery('.coupon_display').hide();
    jQuery('.hide_coupon_textbox').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_invalid_error').hide();
    var currentVal = parseInt(jQuery('.qty' + ids).val());
    var m_name = jQuery(this).data('mnamee');
    var qty_val = 0;
    if (unit_symbol != "") {
        var qty_val_orignal = jQuery('#qty' + ids).val();
        var qty_val_array = qty_val_orignal.split(" ");
        qty_val = parseFloat(qty_val_array[0]);
    } else {
        qty_val = parseFloat(jQuery('#qty' + ids).val());
    }
    var qty_vals = qty_val - hfsec;

    if (currentVal <= 0) {
        jQuery('.ld-loading-main').hide();
        jQuery('.qty' + ids).val('0 ' + unit_symbol);
        jQuery(".update_qty_of_s_m_" + m_name).remove();
    } else if (currentVal > 0) {
        jQuery('.qty' + ids).val(qty_vals + " " + unit_symbol);
        jQuery.ajax({
            type: 'post',
            data: {
                'method_id': method_id,
                'service_id': service_id,
                'qty_vals': qty_vals,
                'units_id': units_id,
                'hfsec': hfsec,
                's_m_units_maxlimit_4_ratesss': 1
            },
            url: ajax_url + "manual_booking_frontajax.php",
            success: function(res) {
                jQuery('.data_qtyrate').attr("data-rate", res);
                jQuery.ajax({
                    type: 'post',
                    data: {
                        'method_id': method_id,
                        'service_id': service_id,
                        's_m_qty': qty_vals,
                        's_m_rate': res,
                        'method_name': method_name,
                        'units_id': units_id,
                        'type': type,
                        'frequently_discount_id': frequently_discount_id,
                                                'cart_dynamic_key':cart_dynamic_key,
                        'add_to_cart': 1
                    },
                    url: site_url + "front/manual_booking_firststep.php",
                    success: function(res) {
                        jQuery('.freq_discount_display').show();
                        jQuery('.hide_right_side_box').show();
                        jQuery('.partial_amount_hide_on_load').show();
                        jQuery('.empty_cart_error').hide();
                        jQuery('.no_units_in_cart_error').hide();
                        jQuery('.coupon_invalid_error').hide();
                        jQuery("#total_cart_count").val('2');
                        var cart_session_data = jQuery.parseJSON(res);
                        jQuery('#no_units_in_cart_err').val(cart_session_data.unit_status);
                        jQuery('#no_units_in_cart_err_count').val(cart_session_data.unit_require);
                        if (cart_session_data.status == 'update') {
                            jQuery(".cart_empty_msg").hide();
                            jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).html(cart_session_data.s_m_html);
                            jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-service_id', service_id);
                            jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-method_id', method_id);
                            jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-units_id', units_id);
                            jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                            jQuery('.partial_amount').html(cart_session_data.partial_amount);
                            jQuery('.remain_amount').html(cart_session_data.remain_amount);
                            jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                            jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                            jQuery('.cart_tax').html(cart_session_data.cart_tax);
                            jQuery('.cart_total').html(cart_session_data.total_amount);
                        } else if (cart_session_data.status == 'insert') {
                            jQuery('.hideduration_value').show();
                            jQuery(".cart_empty_msg").hide();
                            jQuery('.cart_item_listing').append(cart_session_data.s_m_html);
                            jQuery('.partial_amount').html(cart_session_data.partial_amount);
                            jQuery('.remain_amount').html(cart_session_data.remain_amount);
                            jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                            jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                            jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                            jQuery('.cart_tax').html(cart_session_data.cart_tax);
                            jQuery('.cart_total').html(cart_session_data.total_amount);
                        } else if (cart_session_data.status == 'firstinsert') {
                            jQuery('.hideduration_value').show();
                            jQuery(".cart_empty_msg").hide();
                            jQuery('.cart_item_listing').append(cart_session_data.s_m_html);
                            jQuery('.partial_amount').html(cart_session_data.partial_amount);
                            jQuery('.remain_amount').html(cart_session_data.remain_amount);
                            jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                            jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                            jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                            jQuery('.cart_tax').html(cart_session_data.cart_tax);
                            jQuery('.cart_total').html(cart_session_data.total_amount);
                        } else if (cart_session_data.status == 'empty calculation') {
                            jQuery('.hideduration_value').hide();
                            jQuery('.total_time_duration_text').html('');
                            jQuery('.freq_discount_display').hide();
                            jQuery('.partial_amount_hide_on_load').hide();
                            jQuery('.hide_right_side_box').hide();
                            jQuery(".cart_empty_msg").show();
                            jQuery(".cart_item_listing").empty();
                            jQuery(".cart_sub_total").empty();
                            jQuery(".frequent_discount").empty();
                            jQuery(".cart_tax").empty();
                            jQuery(".cart_total").empty();
                            jQuery(".remain_amount").empty();
                            jQuery(".partial_amount").empty();
                            jQuery(".cart_discount").empty();
                        } else if (cart_session_data.status == 'delete particuler') {
                            jQuery(".cart_empty_msg").hide();
                            jQuery(".update_qty_of_s_m_" + cart_session_data.method_name_without_space).remove();
                            jQuery('.partial_amount').html(cart_session_data.partial_amount);
                            jQuery('.remain_amount').html(cart_session_data.remain_amount);
                            jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                            jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                            jQuery('.cart_tax').html(cart_session_data.cart_tax);
                            jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                            jQuery('.cart_total').html(cart_session_data.total_amount);
                        }
                    }
                });
            }
        });
    }
});

jQuery(document).on('keyup', '#ld_area_m_units', function(event) {
    jQuery('.freq_disc_empty_cart_error').hide();
    jQuery('.error_of_invalid_area').hide();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var area_uniit = jQuery("#ld_area_m_units").val();
    var service_id = jQuery(this).data('service_id');
    var method_id = jQuery(this).data('method_id');
    var max_limitts = jQuery(this).data('maxx_limit');
    var method_name = jQuery(this).data('method_name');
    var units_id = jQuery(this).data('units_id');
    var type = jQuery(this).data('type');
    var frequently_discount_id = jQuery("input[name=frequently_discount_radio]:checked").data('id');
    jQuery('.coupon_display').hide();
    jQuery('.hide_coupon_textbox').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_invalid_error').hide();
    var m_name = jQuery(this).data('mnamee');
    var Number = /^[0-9]+$/;

    if (event.which == 8) {
        jQuery(".error_of_invalid_area").hide();
        jQuery(".error_of_max_limitss").hide();
    }
    if (/^[0-9]+$/.test(area_uniit) == false) {
        jQuery(".error_of_invalid_area").show();
        jQuery('.error_of_invalid_area').html('Invalid ' + method_name);
    }
    if (area_uniit == '') {
        jQuery.ajax({
            type: 'post',
            data: {
                'method_id': method_id,
                'service_id': service_id,
                's_m_qty': 0,
                's_m_rate': 0,
                'method_name': method_name,
                'units_id': units_id,
                'type': type,
                'frequently_discount_id': frequently_discount_id,
                                'cart_dynamic_key':cart_dynamic_key,
                'add_to_cart': 1
            },
            url: site_url + "front/manual_booking_firststep.php",
            success: function(res) {
                jQuery('.freq_discount_display').show();
                jQuery('.hide_right_side_box').show();
                jQuery('.partial_amount_hide_on_load').show();
                jQuery('.empty_cart_error').hide();
                jQuery('.no_units_in_cart_error').hide();
                jQuery('.coupon_invalid_error').hide();
                jQuery("#total_cart_count").val('2');
                var cart_session_data = jQuery.parseJSON(res);
                jQuery('#no_units_in_cart_err').val(cart_session_data.unit_status);
                jQuery('#no_units_in_cart_err_count').val(cart_session_data.unit_require);
                if (cart_session_data.status == 'empty calculation') {
                    jQuery('.hideduration_value').hide();
                    jQuery('.total_time_duration_text').html('');
                    jQuery('.freq_discount_display').hide();
                    jQuery('.partial_amount_hide_on_load').hide();
                    jQuery('.hide_right_side_box').hide();
                    jQuery(".cart_empty_msg").show();
                    jQuery(".cart_item_listing").empty();
                    jQuery(".frequent_discount").empty();
                    jQuery(".cart_sub_total").empty();
                    jQuery(".cart_tax").empty();
                    jQuery(".cart_total").empty();
                    jQuery(".remain_amount").empty();
                    jQuery(".partial_amount").empty();
                    jQuery(".cart_discount").empty();
                } else if (cart_session_data.status == 'delete particuler') {
                    jQuery(".cart_empty_msg").hide();
                    jQuery(".update_qty_of_s_m_" + m_name).remove();
                    jQuery('.partial_amount').html(cart_session_data.partial_amount);
                    jQuery('.remain_amount').html(cart_session_data.remain_amount);
                    jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                    jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                    jQuery('.cart_tax').html(cart_session_data.cart_tax);
                    jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                    jQuery('.cart_total').html(cart_session_data.total_amount);
                }
            }
        });
    } else if (area_uniit == 0) {
        jQuery(".error_of_invalid_area").show();
        jQuery('.error_of_invalid_area').html('Invalid ' + method_name);
    } else if (area_uniit > max_limitts) {
        jQuery(".error_of_max_limitss").show();
        jQuery('.error_of_max_limitss').html('Max Limit Reached');
    } else if (area_uniit <= max_limitts) {
        if (area_uniit.match(Number)) {
            jQuery.ajax({
                type: 'post',
                data: {
                    'method_id': method_id,
                    'service_id': service_id,
                    'units_id': units_id,
                    'qty_vals': area_uniit,
                    's_m_units_maxlimit_4_ratesss': 1
                },
                url: ajax_url + "manual_booking_frontajax.php",
                success: function(res) {
                    jQuery('.ld_area_m_units_rattee').attr("data-rate", res);
                    jQuery.ajax({
                        type: 'post',
                        data: {
                            'method_id': method_id,
                            'service_id': service_id,
                            's_m_qty': area_uniit,
                            's_m_rate': res,
                            'method_name': method_name,
                            'units_id': units_id,
                            'type': type,
                            'frequently_discount_id': frequently_discount_id,
                                                        'cart_dynamic_key':cart_dynamic_key,
                            'add_to_cart': 1
                        },
                        url: site_url + "front/manual_booking_firststep.php",
                        success: function(res) {
                            jQuery('.freq_discount_display').show();
                            jQuery('.hide_right_side_box').show();
                            jQuery('.partial_amount_hide_on_load').show();
                            jQuery('.empty_cart_error').hide();
                            jQuery('.no_units_in_cart_error').hide();
                            jQuery('.coupon_invalid_error').hide();
                            jQuery("#total_cart_count").val('2');
                            var cart_session_data = jQuery.parseJSON(res);
                            jQuery('#no_units_in_cart_err').val(cart_session_data.unit_status);
                            jQuery('#no_units_in_cart_err_count').val(cart_session_data.unit_require);
                            if (cart_session_data.status == 'update') {
                                jQuery(".cart_empty_msg").hide();
                                jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).html(cart_session_data.s_m_html);
                                jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-service_id', service_id);
                                jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-method_id', method_id);
                                jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-units_id', units_id);
                                jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                                jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                                jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                                jQuery('.cart_total').html(cart_session_data.total_amount);
                            } else if (cart_session_data.status == 'insert') {
                                jQuery('.hideduration_value').show();
                                jQuery(".cart_empty_msg").hide();
                                jQuery('.cart_item_listing').append(cart_session_data.s_m_html);
                                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                                jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                                jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                                jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                                jQuery('.cart_total').html(cart_session_data.total_amount);
                            } else if (cart_session_data.status == 'firstinsert') {
                                jQuery('.hideduration_value').show();
                                jQuery(".cart_empty_msg").hide();
                                jQuery('.cart_item_listing').append(cart_session_data.s_m_html);
                                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                                jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                                jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                                jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                                jQuery('.cart_total').html(cart_session_data.total_amount);
                            } else if (cart_session_data.status == 'empty calculation') {
                                jQuery('.hideduration_value').hide();
                                jQuery('.total_time_duration_text').html('');
                                jQuery('.freq_discount_display').hide();
                                jQuery('.partial_amount_hide_on_load').hide();
                                jQuery('.hide_right_side_box').hide();
                                jQuery(".cart_empty_msg").show();
                                jQuery(".cart_item_listing").empty();
                                jQuery(".cart_sub_total").empty();
                                jQuery(".frequent_discount").empty();
                                jQuery(".cart_tax").empty();
                                jQuery(".cart_total").empty();
                                jQuery(".remain_amount").empty();
                                jQuery(".partial_amount").empty();
                                jQuery(".cart_discount").empty();
                            } else if (cart_session_data.status == 'delete particuler') {
                                jQuery(".cart_empty_msg").hide();
                                jQuery(".update_qty_of_s_m_" + m_name).remove();
                                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                                jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                                jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                                jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                                jQuery('.cart_total').html(cart_session_data.total_amount);
                            }
                        }
                    });
                }
            });
        } else {
            jQuery('.ld-loading-main').hide();
            jQuery(".error_of_invalid_area").show();
            jQuery('.error_of_invalid_area').html('Invalid ' + method_name);
        }
    } else {
        jQuery('.ld-loading-main').hide();
        jQuery(".error_of_invalid_area").show();
        jQuery('.error_of_invalid_area').html('Invalid ' + method_name);
    }
});

jQuery(document).on('click', '.add_item_in_cart', function() {
    jQuery('.freq_disc_empty_cart_error').hide();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    jQuery('.coupon_display').hide();
    jQuery('.hide_coupon_textbox').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_invalid_error').hide();
    var s_m_qty = jQuery(this).data('duration_value');
    var s_m_rate = jQuery(this).data('rate');
    var service_id = jQuery(this).data('service_id');
    var method_id = jQuery(this).data('method_id');
    var method_name = jQuery(this).data('method_name');
    var units_id = jQuery(this).data('units_id');
    var type = jQuery(this).data('type');
    var frequently_discount_id = jQuery("input[name=frequently_discount_radio]:checked").data('id');
    var m_name = jQuery(this).data('mnamee');

    jQuery.ajax({
        type: 'post',
        data: {
            'method_id': method_id,
            'service_id': service_id,
            's_m_qty': s_m_qty,
            's_m_rate': s_m_rate,
            'method_name': method_name,
            'units_id': units_id,
            'type': type,
            'frequently_discount_id': frequently_discount_id,
                        'cart_dynamic_key':cart_dynamic_key,
            'add_to_cart': 1
        },
        url: site_url + "front/manual_booking_firststep.php",
        success: function(res) {
            jQuery('.freq_discount_display').show();
            jQuery('.hide_right_side_box').show();
            jQuery('.partial_amount_hide_on_load').show();
            jQuery('.empty_cart_error').hide();
            jQuery('.no_units_in_cart_error').hide();
            jQuery('.coupon_invalid_error').hide();
            jQuery("#total_cart_count").val('2');
            var cart_session_data = jQuery.parseJSON(res);
            jQuery('#no_units_in_cart_err').val(cart_session_data.unit_status);
            jQuery('#no_units_in_cart_err_count').val(cart_session_data.unit_require);
            if (cart_session_data.status == 'update') {
                jQuery(".cart_empty_msg").hide();
                jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).html(cart_session_data.s_m_html);
                jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-service_id', service_id);
                jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-method_id', method_id);
                jQuery('.update_qty_of_s_m_' + cart_session_data.method_name_without_space).val('data-units_id', units_id);

      
      jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                jQuery('.cart_total').html(cart_session_data.total_amount);
            } else if (cart_session_data.status == 'insert') {
                jQuery('.hideduration_value').show();
                jQuery(".cart_empty_msg").hide();
                jQuery('.cart_item_listing').append(cart_session_data.s_m_html);
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                jQuery('.cart_total').html(cart_session_data.total_amount);
            } else if (cart_session_data.status == 'firstinsert') {
                jQuery('.hideduration_value').show();
                jQuery(".cart_empty_msg").hide();
                jQuery('.cart_item_listing').append(cart_session_data.s_m_html);
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                jQuery('.cart_total').html(cart_session_data.total_amount);
            } else if (cart_session_data.status == 'empty calculation') {
                jQuery('.hideduration_value').hide();
                jQuery('.total_time_duration_text').html('');
                jQuery('.freq_discount_display').hide();
                jQuery('.partial_amount_hide_on_load').hide();
                jQuery('.hide_right_side_box').hide();
                jQuery(".cart_empty_msg").show();
                jQuery(".cart_item_listing").empty();
                jQuery(".cart_sub_total").empty();
                jQuery(".cart_tax").empty();
                jQuery(".cart_total").empty();
                jQuery(".remain_amount").empty();
                jQuery(".partial_amount").empty();
                jQuery(".cart_discount").empty();
                jQuery('.frequent_discount').empty();
            } else if (cart_session_data.status == 'delete particuler') {
                jQuery(".cart_empty_msg").hide();
                jQuery(".update_qty_of_s_m_" + m_name).remove();
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                jQuery('.cart_total').html(cart_session_data.total_amount);
            }
        }
    });
});


/*Coupon Apply*/
jQuery(document).ready(function() {
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_display').hide();
});
jQuery(document).on('click touchstart', '#apply_coupon', function() {
    jQuery('.ld-loading-main').show();
    jQuery('.freq_disc_empty_cart_error').hide();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var coupon_code = jQuery('#coupon_val').val();
    var subtotal = jQuery('.cart_sub_total').text();

    var frequently_discount_id = jQuery("input[name=frequently_discount_radio]:checked").data('id');
    if (subtotal == '') {
        jQuery('.ld-loading-main').hide();
        jQuery('.coupon_invalid_error').css('display', 'block');
        jQuery('.coupon_invalid_error').html(errorobj_your_cart_is_empty_please_add_laundry_services);
    } else {
        if (coupon_code == '') {
            jQuery('.ld-loading-main').hide();
            jQuery('.coupon_invalid_error').css('display', 'block');
            jQuery('.coupon_invalid_error').html(errorobj_please_enter_coupon_code);
        } else {
            jQuery.ajax({
                type: "POST",
                url: site_url + "front/manual_booking_firststep.php",
                data: {
                    'coupon_code': coupon_code,
                    'frequently_discount_id': frequently_discount_id,
                    'coupon_check': 1
                },
                success: function(res) {
                    jQuery('.ld-loading-main').hide();
                    var cart_session_data = jQuery.parseJSON(res);
                    if (cart_session_data.discount_status == 'not') {
                        jQuery('.coupon_invalid_error').css('display', 'block');
                        jQuery('.coupon_invalid_error').html(errorobj_coupon_expired);
                    } else if (cart_session_data.discount_status == 'wrongcode') {
                        jQuery('.coupon_invalid_error').css('display', 'block');
                        jQuery('.coupon_invalid_error').html(errorobj_invalid_coupon);
                    } else if (cart_session_data.discount_status == 'available') {
                        jQuery('.ld-display-coupon-code').show();
                        jQuery('.freq_discount_display').show();
                        jQuery('.hide_coupon_textbox').hide();
                        jQuery('.coupon_display').show();
                        jQuery('.partial_amount').html(cart_session_data.partial_amount);
                        jQuery('.remain_amount').html(cart_session_data.remain_amount);
                        jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                        jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                        jQuery('.cart_tax').html(cart_session_data.cart_tax);
                        jQuery('.cart_total').html(cart_session_data.total_amount);
                        jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                    }
                }
            });
        }
    }
});
jQuery(document).on('click', '#coupon_val', function() {
    jQuery('.coupon_invalid_error').hide();
});

/*Reverse Coupon Code*/
jQuery(document).on('click touchstart', '.reverse_coupon', function() {
    jQuery('.ld-loading-main').show();
    jQuery('.freq_disc_empty_cart_error').hide();
    var site_url = siteurlObj.site_url;
    var coupon_reverse = jQuery('#display_code').text();
    var frequently_discount_id = jQuery("input[name=frequently_discount_radio]:checked").data('id');
    jQuery.ajax({
        type: "POST",
        url: site_url + "front/manual_booking_firststep.php",
        data: {
            'coupon_reverse': coupon_reverse,
            'frequently_discount_id': frequently_discount_id,
            'coupon_reversed': 1
        },
        success: function(res) {
            jQuery('.ld-loading-main').hide();
            var cart_session_data = jQuery.parseJSON(res);
            if (cart_session_data.status == 'reversed') {
                jQuery('.freq_discount_display').show();
                jQuery('.ld-display-coupon-code').hide();
                jQuery('.hide_coupon_textbox').show();
                jQuery('.coupon_display').hide();
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                jQuery('.cart_total').html(cart_session_data.total_amount);
            }
        }
    });
});

/*** calendar code start ***/
/* time slots dropdown show hide list */
jQuery(document).on("click", ".time-slot-is", function() {
    jQuery(".time-slots-dropdown").show("blind", {
        direction: "vertical"
    }, 700);
});
jQuery(document).on("click", ".time-slot", function() {
    jQuery('.time-slot').each(function() {
        jQuery(this).removeClass('selected-time-slot');
    });
    jQuery(this).addClass('selected-time-slot');
    jQuery(".time-slots-dropdown").hide("blind", {
        direction: "vertical"
    }, 300);
});

jQuery(document).on('click', '.ld-week', function() {
    var valuess = jQuery(this).val();
    var s_date = jQuery(this).data('s_date');
    var c_date = jQuery(this).data('c_date');
    if (s_date >= c_date) {
        jQuery('.ld-week').each(function() {
            jQuery(this).removeClass('active');
            jQuery('.ld-show-time').removeClass('shown');
        });
        jQuery(this).addClass('active');
        jQuery('.ld-show-time').addClass('shown');
    } else if (s_date < c_date || valuess == '') {
        jQuery('.time_slot_box').hide();
    }
});
/******************/

jQuery(document).on("click", ".selected_date", function() {
    jQuery('.ld-loading-main').show();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var selected_dates = jQuery(this).data('selected_dates');
    var s_date = jQuery(this).data('s_date');
    var cur_dates = jQuery(this).data('cur_dates');
    var c_date = jQuery(this).data('c_date');
    var id = jQuery(this).data('id');

    var ld_time_selected = jQuery('.ld-time-selected').text();
    var ld_date = jQuery('#save_selected_date').val();

    jQuery.ajax({
        type: "POST",
        url: ajax_url + "calendar_ajax.php",
        data: {
            'selected_dates': selected_dates,
            'id': id,
            'cur_dates': cur_dates,
            'get_slots': 1
        },
        success: function(res) {
            jQuery('.ld-loading-main').hide();
            jQuery('.time_slot_box').hide();
            jQuery('.display_selected_date_slots_box' + id).html(res);
            jQuery('.display_selected_date_slots_box' + id).show();

            if (ld_time_selected != '') {
                jQuery('.time-slot').each(function() {
                    var selectedtime = jQuery(this).data('ld_time_selected');
                    var slot_date = jQuery(this).data('slot_date');

                    if (selectedtime == ld_time_selected && slot_date == ld_date) {
                        jQuery(this).addClass('ld-booked');
                    }
                });
            }
        }
    });
});

jQuery(document).on("change", "#pickup_date", function() {
    var selected_dates = $(this).val();
    var d = new Date();
    var ajax_url = ajaxurlObj.ajax_url;
    var month = d.getMonth() + 1;
    var day = d.getDate();

    var cur_dates = (day < 10 ? '0' : '') + day + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        d.getFullYear();
    

    jQuery.ajax({
        type: "POST",
        url: ajax_url + "calendar_ajax.php",
        data: {
            'selected_dates': selected_dates,
            'cur_dates': cur_dates,
            'get_pickup_slots': 1
        },
        success: function(res) {
            jQuery(".pickup-slots").selectpicker("destroy");
            jQuery(".pickup-slots").html(res);
            jQuery(".pickup-slots").selectpicker("refresh");

            var newDate = moment(selected_dates, date_format_for_js).add(minimum_delivery_days, 'days');
            jQuery('#delivery_date').daterangepicker({
                locale: {
                    format: date_format_for_js
                },
                singleDatePicker: true,
                showDropdowns: true,
                minDate: newDate
            });
        }
    });
});

jQuery(document).on("change", "#delivery_date", function() {
    var selected_dates = jQuery(this).val();
    var d = new Date();
    var ajax_url = ajaxurlObj.ajax_url;
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var pickup_date = jQuery("#pickup_date").val();
    var pickup_slots = jQuery(".pickup-slots").val();

    var cur_dates = (day < 10 ? '0' : '') + day + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        d.getFullYear();
    

    jQuery.ajax({
        type: "POST",
        url: ajax_url + "calendar_ajax.php",
        data: {
            'selected_dates': selected_dates,
            'cur_dates': cur_dates,
            'pickup_date': pickup_date,
            'pickup_slots': pickup_slots,
            'get_delivery_slots': 1
        },
        success: function(res) {
            jQuery(".delivery-slots").selectpicker("destroy");
            jQuery(".delivery-slots").html(res);
            jQuery(".delivery-slots").selectpicker("refresh");
        }
    });
});

jQuery(document).ready(function() {
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    var new_date = moment(today, date_format_for_js).add(advancebooking_days_limit, 'M');
    
    jQuery('#pickup_date').daterangepicker({
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

    
    jQuery('#delivery_date').daterangepicker({
        locale: {
            format: date_format_for_js
        },
        singleDatePicker: true,
        showDropdowns: true,
        minDate: today
    });
});

jQuery(document).on("change", ".pickup-slots", function() {
    jQuery('.ld-selected-date-view').removeClass('pulse');
    jQuery('.date_time_error').hide();
    jQuery('.time_slot_box').hide();
    jQuery('.space_between_date_time').show();
    jQuery('.hidedatetime_value').show();
    jQuery('.add_date').addClass('ld-date-selected');
    jQuery('.add_time').addClass('ld-time-selected');

    var slot_date_to_display = jQuery(this).children("option:selected").data("slot_date_to_display");
    var slot_date = jQuery(this).children("option:selected").data('slot_date');
    var slotdb_date = jQuery(this).children("option:selected").data('slotdb_date');
    var slot_time = jQuery(this).children("option:selected").data('slot_time');
    var slotdb_time = jQuery(this).children("option:selected").data('slotdb_time');

    var ld_date_selected = jQuery(this).children("option:selected").data('ld_date_selected');
    var ld_time_selected = jQuery(this).children("option:selected").data('ld_time_selected');

    jQuery('.ld-date-selected').attr('data-date', slot_date);
    jQuery('#save_selected_date').val(slot_date);
    jQuery('.ld-date-selected').html(ld_date_selected);
    jQuery('.ld-time-selected').html(ld_time_selected);
    jQuery('.ld-selected-date-view').addClass('pulse');
    jQuery('.cart_date').html(slot_date_to_display);
    jQuery('.cart_date').attr('data-date_val', slotdb_date);
    jQuery('.cart_time').html(slot_time);
    jQuery('.cart_time').attr('data-time_val', slotdb_time);

});

jQuery(document).on("change", ".delivery-slots", function() {
    jQuery('.ld-selected-date-view').removeClass('pulse');
    jQuery('.date_time_error').hide();
    jQuery('.time_slot_box').hide();
    jQuery('.space_between_date_time_del').show();
    jQuery('.hidedatetime_del_value').show();
    jQuery('.add_date').addClass('ld-date-selected');
    jQuery('.add_time').addClass('ld-time-selected');

    var slot_date_to_display = jQuery(this).children("option:selected").data("slot_date_to_display");
    var slot_date = jQuery(this).children("option:selected").data('slot_date');
    var slotdb_date = jQuery(this).children("option:selected").data('slotdb_date');
    var slot_time = jQuery(this).children("option:selected").data('slot_time');
    var slotdb_time = jQuery(this).children("option:selected").data('slotdb_time');

    var ld_date_selected = jQuery(this).children("option:selected").data('ld_date_selected');
    var ld_time_selected = jQuery(this).children("option:selected").data('ld_time_selected');

    jQuery('.ld-date-selected').attr('data-date', slot_date);
    jQuery('#save_selected_date').val(slot_date);
    jQuery('.ld-date-selected').html(ld_date_selected);
    jQuery('.ld-time-selected').html(ld_time_selected);
    jQuery('.ld-selected-date-view').addClass('pulse');
    jQuery('.cart_del_date').html(slot_date_to_display);
    jQuery('.cart_del_date').attr('data-date_del_val', slotdb_date);
    jQuery('.cart_del_time').html(slot_time);
    jQuery('.cart_del_time').attr('data-time_del_val', slotdb_time);

});


/*** calendar code end ***/
/* Display Country Code on click flag on phone*/
jQuery(document).on('click', '.country', function() {
    var country_code = jQuery(this).data("dial-code");
    jQuery("#ld-user-phone").val('+' + country_code);
});

jQuery(document).on('click', '.add_addon_in_cart_for_multipleqty', function() {
    jQuery('.freq_disc_empty_cart_error').hide();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    jQuery('.coupon_display').hide();
    jQuery('.hide_coupon_textbox').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_invalid_error').hide();
    var s_m_qty = jQuery(this).data('duration_value');
    var s_m_rate = jQuery(this).data('rate');
    var service_id = jQuery(this).data('service_id');
    var method_id = jQuery(this).data('method_id');
    var method_name = jQuery(this).data('method_name');
    var units_id = jQuery(this).data('units_id');
    var type = jQuery(this).data('type');
    var frequently_discount_id = jQuery("input[name=frequently_discount_radio]:checked").data('id');
    var m_name = jQuery(this).data('mnamee');
    var status = jQuery(this).data('status');

    if (parseInt(status) == 2) {
        jQuery(this).data('status', '1');

        jQuery.ajax({
            type: 'post',
            data: {
                'method_id': method_id,
                'service_id': service_id,
                's_m_qty': s_m_qty,
                's_m_rate': s_m_rate,
                'method_name': method_name,
                'units_id': units_id,
                'type': type,
                'frequently_discount_id': frequently_discount_id,
                'add_to_cart': 1
            },
            url: site_url + "front/manual_booking_firststep.php",
            success: function(res) {
                jQuery('.freq_discount_display').show();
                jQuery('.hide_right_side_box').show();
                jQuery('.partial_amount_hide_on_load').show();
                jQuery('.empty_cart_error').hide();
                jQuery('.coupon_invalid_error').hide();
                jQuery("#total_cart_count").val('2');
                var cart_session_data = jQuery.parseJSON(res);
                jQuery('#no_units_in_cart_err').val(cart_session_data.unit_status);
                jQuery('#no_units_in_cart_err_count').val(cart_session_data.unit_require);
                if (cart_session_data.status == 'insert') {
                    jQuery(".cart_empty_msg").hide();
                    jQuery('.cart_item_listing').append(cart_session_data.s_m_html);
                    jQuery('.partial_amount').html(cart_session_data.partial_amount);
                    jQuery('.remain_amount').html(cart_session_data.remain_amount);
                    jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                    jQuery('.cart_tax').html(cart_session_data.cart_tax);
                    jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                    jQuery('.cart_total').html(cart_session_data.total_amount);
                } else if (cart_session_data.status == 'empty calculation') {
                    jQuery('.hideduration_value').hide();
                    jQuery('.total_time_duration_text').html('');
                    jQuery('.total_time_duration_text').html('');
                    jQuery('.freq_discount_display').show();
                    jQuery('.partial_amount_hide_on_load').hide();
                    jQuery('.hide_right_side_box').hide();
                    jQuery(".cart_empty_msg").show();
                    jQuery(".cart_item_listing").empty();
                    jQuery(".cart_sub_total").empty();
                    jQuery(".frequent_discount").empty();
                    jQuery(".cart_tax").empty();
                    jQuery(".cart_total").empty();
                    jQuery(".remain_amount").empty();
                    jQuery(".partial_amount").empty();
                    jQuery(".cart_discount").empty();
                } else if (cart_session_data.status == 'delete particuler') {
                    jQuery(".cart_empty_msg").hide();
                    jQuery(".update_qty_of_s_m_" + m_name).remove();
                    jQuery('.partial_amount').html(cart_session_data.partial_amount);
                    jQuery('.remain_amount').html(cart_session_data.remain_amount);
                    jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                    jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                    jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                    jQuery('.cart_tax').html(cart_session_data.cart_tax);
                    jQuery('.cart_total').html(cart_session_data.total_amount);
                }
            }
        });
    } else {
        jQuery(this).data('status', '2');

        jQuery.ajax({
            type: 'post',
            data: {
                'method_id': method_id,
                'service_id': service_id,
                's_m_qty': s_m_qty,
                's_m_rate': s_m_rate,
                'method_name': method_name,
                'units_id': units_id,
                'type': type,
                'frequently_discount_id': frequently_discount_id,
                'add_to_cart': 1
            },
            url: site_url + "front/manual_booking_firststep.php",
            success: function(res) {
                jQuery('.freq_discount_display').show();
                jQuery('.hide_right_side_box').show();
                jQuery('.partial_amount_hide_on_load').show();
                jQuery('.empty_cart_error').hide();
                jQuery('.coupon_invalid_error').hide();
                jQuery("#total_cart_count").val('2');
                var cart_session_data = jQuery.parseJSON(res);
                jQuery('#no_units_in_cart_err').val(cart_session_data.unit_status);
                jQuery('#no_units_in_cart_err_count').val(cart_session_data.unit_require);
                if (cart_session_data.status == 'empty calculation') {
                    jQuery('.hideduration_value').hide();
                    jQuery('.total_time_duration_text').html('');
                    jQuery('.partial_amount_hide_on_load').hide();
                    jQuery('.hide_right_side_box').hide();
                    jQuery(".cart_empty_msg").show();
                    jQuery(".cart_item_listing").empty();
                    jQuery(".cart_sub_total").empty();
                    jQuery(".cart_tax").empty();
                    jQuery(".cart_total").empty();
                    jQuery(".frequent_discount").empty();
                    jQuery(".remain_amount").empty();
                    jQuery(".partial_amount").empty();
                    jQuery(".cart_discount").empty();
                } else if (cart_session_data.status == 'delete particuler') {
                    jQuery(".cart_empty_msg").hide();
                    jQuery(".update_qty_of_s_m_" + m_name).remove();
                    jQuery('.partial_amount').html(cart_session_data.partial_amount);
                    jQuery('.remain_amount').html(cart_session_data.remain_amount);
                    jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                    jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                    jQuery('.cart_tax').html(cart_session_data.cart_tax);
                    jQuery('.frequent_discount').html(cart_session_data.frequent_discount);
                    jQuery('.cart_total').html(cart_session_data.total_amount);
                }
            }
        });
    }
});

jQuery(document).ready(function() {
    jQuery('[data-toggle="tooltip"]').tooltip({
        'placement': 'right'
    });
});

/* same as above details  */
jQuery(document).on("change", "#retype_status", function() {
    var user_address = jQuery("#ld-street-address").val();
    var user_zipcode = jQuery("#ld-zip-code").val();
    var user_city = jQuery("#ld-city").val();
    var user_state = jQuery("#ld-state").val();
    if (jQuery('#retype_status').prop('checked')) {
        jQuery("#app-street-address").val(user_address);
        jQuery("#app-zip-code").val(user_zipcode);
        jQuery("#app-city").val(user_city);
        jQuery("#app-state").val(user_state);
    } else {
        jQuery("#app-street-address").val("");
        jQuery("#app-zip-code").val("");
        jQuery("#app-city").val("");
        jQuery("#app-state").val("");
    }

});
jQuery(document).ready(function() {
    jQuery(".ld_recurrence_end_date").datepicker({
        dateFormat: 'yy-mm-dd'
    });
});


jQuery(document).on('click', ".ld_method_tab-slider--nav li,.ld_method_tab-slider--nav li.active", function() {
    if (!jQuery(this).hasClass('ld_method_tab-blank_li')) {
        var totallis = 0;
        var selectedli = 0;
        var currentli = jQuery(this).html();
        var divid = jQuery(this).data('id');
        var maindivid = jQuery(this).data('maindivid');
        jQuery('.ld_method_tab-slider--nav').each(function() {
            var common_id = jQuery(this).data('id');
            if (jQuery('.ld_method_tab-slider--nav_dynamic' + common_id + ' li').length == 2) {
                jQuery('.ld_method_tab-slider--nav_dynamic' + common_id + ' ul').append("<li class='ld_method_tab-slider-trigger ld_method_tab-blank_li'>&nbsp;</li>");
            } else if (jQuery('.ld_method_tab-slider--nav_dynamic' + common_id + ' li').length == 1) {
                jQuery('.ld_method_tab-slider--nav_dynamic' + common_id + ' ul').append("<li class='ld_method_tab-slider-trigger ld_method_tab-blank_li'>&nbsp;</li><li class='ld_method_tab-slider-trigger ld_method_tab-blank_li'>&nbsp;</li>");
            }
        });
        jQuery('.ld_method_tab-slider--nav_dynamic' + maindivid + ' li').each(function() {
            if (jQuery(this).html() == currentli) {
                selectedli = totallis;
            }
            totallis++;
        });
        var leftpercent = 100 / totallis;
        var currentpercent = leftpercent * selectedli;
        jQuery('head').find('style').each(function() {
            var attr = jQuery(this).attr('data-dynmicstyle');
            if (typeof attr !== typeof undefined && attr !== false) {
                jQuery(this).remove();
            }
        });
        jQuery('<style data-dynmicstyle>.ld_method_tab-slider--nav_dynamic' + maindivid + ' .ld_method_tab-slider-tabs.ld_methods_slide:after{width:' + leftpercent + '% !important;left:' + currentpercent + '% !important;}</style>').appendTo('head');
        jQuery(".ld_method_tab-slider--nav_dynamic" + maindivid + " li").removeClass("active");

        jQuery(".ld_method_tab-slider-trigger_dynamic" + divid).addClass("active");
    }
});

jQuery(document).ready(function() {

    jQuery(".fancy_input").on("keyup", function() {
        if (jQuery(this).val().length > 0) {
            jQuery(this).parent().addClass("focused_label_wrap");
        } else if (jQuery(this).val().length <= 0) {
            jQuery(this).parent().removeClass("focused_label_wrap");
        }
    });

    jQuery(".phone_no_wrap .fancy_input").on("keyup", function() {
        if (jQuery(this).val().length > 0) {
            jQuery(".phone_no_wrap").addClass("focused_label_wrap");
        } else if (jQuery(this).val().length <= 0) {
            jQuery(".phone_no_wrap").removeClass("focused_label_wrap");
        }
    });
});

jQuery(document).on('click', ".cart_toggle_head", function() {
    var id = jQuery(this).data('id');
    jQuery('.cart_toggle_head').each(function(){
        var nID = jQuery(this).data('id');
        if(nID == id){
            if(jQuery('.ct_icon_check_'+nID).hasClass('fa-plus')){
                jQuery('.ct_icon_check_'+nID).removeClass('fa-plus');
                jQuery('.ct_icon_check_'+nID).addClass('fa-minus');
                jQuery("#cart_toggle_content_"+nID).slideToggle();
            }
            else{
                jQuery('.ct_icon_check_'+nID).addClass('fa-plus');
                jQuery('.ct_icon_check_'+nID).removeClass('fa-minus');
                jQuery("#cart_toggle_content_"+nID).slideUp();
            }
        }else{
            jQuery('.ct_icon_check_'+nID).addClass('fa-plus');
            jQuery('.ct_icon_check_'+nID).removeClass('fa-minus');
            jQuery("#cart_toggle_content_"+nID).slideUp();
        }
    });
});


/* For:- Laundry POS Add or Get All Articles for Particulr Method START */ 
        
var count_cart = 0;
var current_service_name = "";
var cart_dynamic_key = "";
var check_cart_details = true; 

jQuery(document).on('click', '.pos_details', function() {

        check_cart_details = false;
    jQuery(":input", this).prop('checked', true);
    jQuery('.ld-loading-main').show();
    
    jQuery('.hideduration_value').hide();
    jQuery('.total_time_duration_text').html('');
    jQuery('.service_not_selected_error_d2').removeAttr('style', '');
    jQuery('.service_not_selected_error_d2').html(errorobj_please_select_a_service);
    jQuery('.add_addon_in_cart_for_multipleqty').data('status', '2');
    jQuery('.service_not_selected_error').hide();
    jQuery('.partial_amount_hide_on_load').hide();
    jQuery('.hide_right_side_box').hide();
    jQuery('.ld_all_booking_errors').hide();
    jQuery('.hideservice_name').show();
    jQuery('.empty_cart_error').hide();
    jQuery('.no_units_in_cart_error').hide();

    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var id = jQuery(this).data('id');
    var name = jQuery(this).data('servicetitle');
        var current_service_name =  name;

        var check_li_exist=true;
        var force_hidden = "";
      var old_cart_dynamic_key = 0;
        
        jQuery('.cart_toggle_head').each(function(){

                var service_head_id = jQuery(this).attr("data-service_id");
                var service_head_cart_dynamic_key = jQuery(this).attr("data-id");
                var remove_li_class = "cart_service_item_listing_li"+service_head_cart_dynamic_key;
                var check_ul_class = "ld-addon-items-list_"+service_head_cart_dynamic_key;
                if (jQuery("."+check_ul_class+" div").length == 0){
                    jQuery("."+remove_li_class).remove();
                }
                if(service_head_id == id){
                        check_li_exist = false;
                    old_cart_dynamic_key = service_head_cart_dynamic_key;
                }
        });
    
        if(check_li_exist){
            count_cart++;
            cart_dynamic_key = id+"_"+count_cart;
            var ser_ids_lis="cart_service_item_listing_li"+cart_dynamic_key;
            var ser_ids_h4_class="cart_toggle_head_4_"+cart_dynamic_key;
            var ser_ids_uls="cart_item_listing"+cart_dynamic_key;
            var ser_ids_divs="cart_toggle_content_"+cart_dynamic_key;
            var ser_ids_iis="ct_icon_check_"+cart_dynamic_key;
            var ser_datetime="hidedatetime_value_"+cart_dynamic_key;
            var ser_cart_date="cart_date_"+cart_dynamic_key;
            var ser_cart_time="cart_time_"+cart_dynamic_key;
            var lidtls="<div class='"+ser_ids_lis+"'><h4 class='cart_toggle_head "+ser_ids_h4_class+"' data-id='"+cart_dynamic_key+"' data-service_id='"+id+"' >"+current_service_name+"<i class='fa fa-plus pull-right cr-pointer "+ser_ids_iis+"'></i></h4> <div id='"+ser_ids_divs+"' class='cart_toggle_content' style='display:none ;'><ul class='ld-addon-items-list_"+cart_dynamic_key+"'></ul></div>";
            jQuery(".cart_item_listing").append(lidtls);
        }else{
            cart_dynamic_key = old_cart_dynamic_key;
        } 
        jQuery('.addon_qty').each(function() {
                jQuery(this).val(0);
                jQuery('.add_minus_button').hide();
        });

    jQuery.ajax({
        type: 'post',
        data: {
            'service_id': id,
                        'cart_dynamic_key':cart_dynamic_key,
            'get_service_units': 1
        },
        url: ajax_url + "pos_ajax.php",
        success: function(res) {
            jQuery('.ld-loading-main').hide();
            if (res == 'Extra Services Not Available') {
                jQuery('.hide_allsss_addons').hide();
            } else {
                jQuery('.hide_allsss_addons').show();
                jQuery('.add_on_lists').html(res);
                jQuery('.add_addon_in_cart_for_multipleqty').each(function() {
                    var multiqty_addon_id = jQuery(this).data('id');
                    var value = jQuery(this).prop('checked');
                    if (value == true) {
                        jQuery('#ld-addon-' + multiqty_addon_id).attr('checked', false);
                    }
                });
            }  
        }
    });
    jQuery(".remove_service_class").each(function() {
        jQuery(this).addClass("ser_details");
        //jQuery(this).addClass("pos_details");
    });
    //jQuery(this).removeClass("pos_details");
    jQuery(this).removeClass("ser_details");
    return false;
}); 


     /* Laundry POS Add or Get All Articles for Particulr Method START */

/* For:- Laundry POS Bedroom and Bathroom counting for addons START */ 
        
jQuery(document).on('click', '.addons_servicess', function() {
    
    var id = jQuery(this).data('id');
    jQuery('.add_minus_buttonid' + id).show();
    var u_name = jQuery(this).data('unamee');
    var value = jQuery(this).prop('checked');
    if (value == false) {
        jQuery('.qtyyy_' + u_name).val(0);
        var addon_id = jQuery(this).data('id');
        jQuery('#minus' + addon_id).trigger('click');
    } else if (value == true) {
        var addon_id = jQuery(this).data('id');
        jQuery('#add' + addon_id).trigger('click');
    }
});

    /* Laundry POS bedroom and bathroom counting for addons END */


/* For:- Laundry POS Plus(Add) Button Event START */

 jQuery(document).on('click', '.pos_add', function() {
        
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var ids = jQuery(this).data('ids');
    var db_qty = jQuery(this).data('db-qty');
    var service_id = jQuery(this).data('service_id');
    var unit_name = jQuery(this).data('unit_name');
    var units_id = jQuery(this).data('units_id');
    var u_name = jQuery(this).data('unamee');
    var minlimit = jQuery(this).data('minlimit');

    jQuery('.coupon_display').hide();
    jQuery('.hide_coupon_textbox').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_invalid_error').hide();
    var qty_val = parseInt(jQuery('.qtyyy_' + u_name).val());
    var qty_vals = qty_val + 1;

    if (qty_val < db_qty) {
        if (qty_val == 0) {
            qty_vals = minlimit;
        }
        jQuery('.qtyyy_' + u_name).val(qty_vals);
        var final_qty_val = qty_vals;
        jQuery.ajax({
            type: 'post',
            data: {
                'service_id': service_id,
                'unit_qty': final_qty_val,
                'units_id': units_id,
                'unit_name': unit_name,
                        'cart_dynamic_key':cart_dynamic_key,
                'add_to_pos_cart': 1
            },
            url: site_url + "front/pos_firststep.php",
            success: function(res) {
                jQuery('.ld_all_booking_errors').hide();
                var cart_session_data = jQuery.parseJSON(res);
                if (cart_session_data.subtotal_amount == 0) {
                    jQuery('.hideduration_value').hide();
                    jQuery(".cart_empty_msg").show();
                    jQuery('.partial_amount_hide_on_load').hide();
                    jQuery('.cart_sub_total').empty();
                    jQuery('.cart_tax').empty();
                    jQuery('.cart_total').empty();
                    jQuery('.cart_item_listing').html(cart_session_data.cart_html);
                    jQuery('.partial_amount').html(cart_session_data.partial_amount);
                    jQuery('.remain_amount').html(cart_session_data.remain_amount);
                    jQuery("#total_cart_count").val('1');
                } else {
                    var lidtls=cart_session_data.cart_html;
                                        jQuery('.hideduration_value').show();
                    jQuery(".cart_empty_msg").hide();
                    jQuery('.partial_amount_hide_on_load').show();
                    jQuery('.ld-addon-items-list_'+cart_dynamic_key).html(lidtls); 
                    jQuery('.cart_sub_total').html(cart_session_data.subtotal);
                    jQuery('.cart_tax').html(cart_session_data.cart_tax);
                    jQuery('.cart_total').html(cart_session_data.total_amount);
                    jQuery('.partial_amount').html(cart_session_data.partial_amount);
                    jQuery('.remain_amount').html(cart_session_data.remain_amount);
                    jQuery("#total_cart_count").val('2');
                }
            }
        });

    } else {
    
        jQuery('.ld-loading-main').hide();
        jQuery('.qtyyy_' + u_name).val(db_qty);
    }
}); 
            /* Laundry POS Plus(Add) Button Event END */


/*  For:- Laundry POS Minus Button Event START */
        
jQuery(document).on('click', '.pos_minus', function() {
    jQuery('.freq_disc_empty_cart_error').hide();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var ids = jQuery(this).data('ids');
    var service_id = jQuery(this).data('service_id');
    var unit_name = jQuery(this).data('unit_name');
    var units_id = jQuery(this).data('units_id');
    var u_name = jQuery(this).data('unamee');
    var minlimit = jQuery(this).data('minlimit');

    jQuery('.coupon_display').hide();
    jQuery('.hide_coupon_textbox').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_invalid_error').hide();
        
    var type = jQuery(this).data('type');
    var qty_val = parseInt(jQuery('.qtyyy_' + u_name).val());
    var qty_vals = qty_val - 1;

    var qty_val = parseInt(jQuery('.qtyyy_' + u_name).val());
    var qty_vals = qty_val - 1;
    var currentVal = parseInt(jQuery('.qtyyy_' + u_name).val());
    if (currentVal <= 0) {}

    if (qty_vals < minlimit) {
        qty_vals = 0;
        jQuery('.add_minus_buttonid' + units_id).hide();
        jQuery(".update_qty_of_s_m_" + u_name).remove();
        jQuery('#ld-addon-' + units_id).attr('checked', false);
        jQuery('#total_cart_count').val(1);
    }
    jQuery('.qtyyy_' + u_name).val(qty_vals);
    jQuery.ajax({
        type: 'post',
        data: {
            'service_id': service_id,
            'unit_qty': qty_vals,
            'units_id': units_id,
            'unit_name': unit_name,
                'cart_dynamic_key':cart_dynamic_key,
            'add_to_pos_cart': 1
        },
        url: site_url + "front/pos_firststep.php",
        success: function(res) {
            
            jQuery('.ld_all_booking_errors').hide();
            var cart_session_data = jQuery.parseJSON(res);
                        if (cart_session_data.current_item_qty == 0) {
                
                                jQuery(".update_qty_of_s_m_"+units_id+service_id).remove();
                                jQuery('.cart_sub_total').html(cart_session_data.subtotal);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.cart_total').html(cart_session_data.total_amount);
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                        }else if (cart_session_data.subtotal_amount == 0) {
                
                jQuery('.hideduration_value').hide();
                jQuery(".cart_empty_msg").show();
                jQuery('.partial_amount_hide_on_load').hide();
                jQuery('.cart_sub_total').empty();
                jQuery('.cart_tax').empty();
                jQuery('.cart_total').empty();
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery("#total_cart_count").val('1');
            } else {
                
                jQuery('.hideduration_value').show();
                jQuery(".cart_empty_msg").hide();
                jQuery('.partial_amount_hide_on_load').show();
                        var lidtls=cart_session_data.cart_html;
                        jQuery('.ld-addon-items-list_'+cart_dynamic_key).html(lidtls); 
                jQuery('.cart_sub_total').html(cart_session_data.subtotal);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.cart_total').html(cart_session_data.total_amount);
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery("#total_cart_count").val('2');
            }
        }
    });
});
            /* Laundry POS Minus Event END */


/* For:- Laundry POS Add Pickup Date&Time START */

jQuery(document).on("change", "#pickup_date_POS", function() {
    
    var selected_dates = $(this).val();
    
    var d = new Date();
    var ajax_url = ajaxurlObj.ajax_url;
    var month = d.getMonth() + 1;
    var day = d.getDate();

    var cur_dates = (day < 10 ? '0' : '') + day + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        d.getFullYear();
    

    jQuery.ajax({
        type: "POST",
        url: ajax_url + "calendar_ajax.php",
        data: {
            'selected_dates': selected_dates,
            'cur_dates': cur_dates,
            'get_pickup_slots': 1
        },
        success: function(res) {
            jQuery(".pickup-slots").selectpicker("destroy");
            jQuery(".pickup-slots").html(res);
            jQuery(".pickup-slots").selectpicker("refresh");
                        
                        var newDate = moment(selected_dates, date_format_for_js).add(minimum_delivery_days, 'days');
            jQuery('#delivery_date_POS').daterangepicker({
                locale: {
                    format: date_format_for_js
                },
                singleDatePicker: true,
                showDropdowns: true,
                minDate: newDate
            });
        }
    });
});
            /* Laundry POS Add Pickup Date&Time START */
 
 
 

/*      For:- Laundry POS Add Delivery Date&Time START */
        
jQuery(document).on("change", "#delivery_date_POS", function() {

    var selected_dates = jQuery(this).val();
    var d = new Date();
    var ajax_url = ajaxurlObj.ajax_url;
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var pickup_date = jQuery("#delivery_date_POS").val();
        var pickup_slots = jQuery(".pickup-slots option:selected").val();

    var cur_dates = (day < 10 ? '0' : '') + day + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        d.getFullYear();
    
    jQuery.ajax({
        type: "POST",
        url: ajax_url + "calendar_ajax.php",
        data: {
            'selected_dates': selected_dates,
            'cur_dates': cur_dates,
            'pickup_date': pickup_date,
            'pickup_slots': pickup_slots,
            'get_delivery_slots': 1
        },
        success: function(res) {
            jQuery(".delivery-slots").selectpicker("destroy");
            jQuery(".delivery-slots").html(res);
            jQuery(".delivery-slots").selectpicker("refresh");
        }
    });
});
                /* Laundry POS Add Delivery Date&Time END */



/*  For:- Laundry POS Add Pickup Date&Time  and Delivery Date&Time START  */

jQuery(document).ready(function () {
    jQuery('#pickup_delivery_datetime').validate({
        rules: {
            pickup_date_POS:{
                required: true,
            },
            delivery_date_POS:{
                    required: true,
            },
        },
        messages: {
            pickup_date_POS:{
                required:errorobj_please_select_pickup_date,
            },
            delivery_date_POS:{
                required:errorobj_please_select_delivery_date,
            },
            
        }
    }); 
});

 jQuery(document).on("click", ".pickup_delivery_data", function() {
    
    jQuery('.ld-loading-main').show();
        if (!jQuery('#pickup_delivery_datetime').valid()) {
    
                jQuery('.ld-loading-main').hide();
                 return false;
    }
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
        var selected_pickup_dates = jQuery('#pickup_date_POS').val();
        var selected_pickup_time = jQuery(".pickup-slots option:selected").val();
        var selected_delivery_dates = jQuery('#delivery_date_POS').val();
        var selected_delivery_time = jQuery(".delivery-slots option:selected").val();

         jQuery.ajax({
                type: "POST",
                url: ajax_url + "pos_ajax.php",
                data: {
                        'selected_pickup_dates': selected_pickup_dates,
                        'selected_pickup_time': selected_pickup_time,
                        'selected_delivery_dates': selected_delivery_dates,
                        'selected_delivery_time': selected_delivery_time,
                        'selected_date_slot': 1
                },
                success: function(res) {
                    jQuery('.pickup_delivery_datas').html(res);
                    jQuery('.ld-loading-main').hide();
                    jQuery('#exampleModal').modal('hide');
                    jQuery('.delivery_date_pos').attr('data-date_del_val', selected_delivery_dates);
                    jQuery('.delivery_time_pos').attr('data-time_del_val', selected_delivery_time);
                    jQuery('.pickup_time_pos').attr('data-time_val', selected_pickup_time);
                    jQuery('.pickup_date_pos').attr('data-date_val', selected_pickup_dates);
                } 
        });
}); 


/* remove item btn-from the cart */

jQuery(document).on("click", ".pos_remove_item_from_cart", function() {
    var ajax_url = ajaxurlObj.ajax_url;
    var unit_id = jQuery(this).data('units_id');
    var service_id = jQuery(this).data('service_id');
        var cart_dynamic_key = jQuery(this).data('key');
    jQuery('#apply_coupon').show();
    jQuery('#coupon_val').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_display').hide();
    jQuery.ajax({
        type: 'POST',
        data: {
            'unit_id': unit_id,
            'service_id': service_id,
                        'cart_dynamic_key': cart_dynamic_key,
            'cart_item_remove': 1
        },
        url: ajax_url + "pos_ajax.php",
        success: function(res) {
            var cart_session_data = jQuery.parseJSON(res);
            jQuery('#ld_area_m_units').val('');
            jQuery('#qty' +unit_id).val('0');
            jQuery('.add_minus_buttonid' + unit_id).hide();
            jQuery('.qtyyy_ad_unit' + unit_id).val('0');
            jQuery('#ld-addon-' + unit_id).data('status', '2');
            jQuery('#ld-addon-' + unit_id).prop('checked', false);

            if (cart_session_data.status == 'empty calculation') {
                jQuery('.hideduration_value').hide();
                jQuery('.total_time_duration_text').html('');
                jQuery("#total_cart_count").val('1');
                jQuery('.partial_amount_hide_on_load').hide();
                jQuery('.hide_right_side_box').hide();
                jQuery(".cart_empty_msg").show();
                jQuery(".cart_item_listing").empty();
                jQuery(".cart_sub_total").empty();
                jQuery(".cart_tax").empty();
                jQuery(".cart_total").empty();
                jQuery(".remain_amount").empty();
                jQuery(".partial_amount").empty();
                jQuery(".cart_discount").empty();
                                jQuery(".cart_item_listing").remove();                                                                                                                    
            }else if(cart_session_data.status == 'cart not empty'){
                                jQuery("#total_cart_count").val('2');
                jQuery(".cart_empty_msg").hide();
                                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                                jQuery(".update_qty_of_s_m_" + unit_id+service_id).remove();
                jQuery('.cart_sub_total').html(cart_session_data.subtotal_amount);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.cart_total').html(cart_session_data.total_amount);     
                        } else {
                jQuery("#total_cart_count").val('2');
                jQuery(".cart_empty_msg").hide();
                jQuery(".update_qty_of_s_m_" + unit_id+service_id).remove();
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
                jQuery('.cart_discount').html('- ' + cart_session_data.cart_discount);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                                jQuery('.cart_sub_total').html(cart_session_data.subtotal_amount);
                jQuery('.cart_total').html(cart_session_data.total_amount);
            }
        }
    });
});

    /*Laundry POS Add Pickup Date&Time  and Delivery Date&Time END*/

