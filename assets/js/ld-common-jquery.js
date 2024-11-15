/* front language dropdown show hide list */
jQuery(document).on("click", ".select-custom", function() {
    jQuery(".common-selection-main").addClass('clicked');
    jQuery(".custom-dropdown").slideDown();

});

/* front language select on click on custom */
jQuery(document).on("click", ".select_custom", function() {
    jQuery('#selected_custom').html(jQuery(this).html());
    jQuery(".common-selection-main").removeClass('clicked');
    jQuery(".custom-dropdown").slideUp();
});

/* tooltipster jquery */

jQuery(document).ready(function() {
    jQuery('.ld-tooltip').tooltipster({
        animation: 'grow',
        delay: 20,
        theme: 'tooltipster-shadow',
        trigger: 'hover'
    });
    jQuery('.ld-tooltipss').tooltipster({
        animation: 'grow',
        delay: 20,
        theme: 'tooltipster-shadow',
        trigger: 'hover'
    });
    jQuery('.ld-tooltip-services').tooltipster({
        animation: 'grow',
        side: 'bottom',
        interactive: 'true',
        theme: 'tooltipster-shadow',
        trigger: 'hover',
        delayTouch: 300,
        maxWidth: 400,
        functionPosition: function(instance, helper, position) {
            position.coord.top -= 70;
            return position;
        },
        contentAsHTML: 'true'
    });

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

var ld_postalcode_status_check = ld_postalcode_statusObj.ld_postalcode_status;
var ld_postalcode_zip_status = ld_postalcode_statusObj.zip_show_status;
var guest_user_status = 'off';

/* scroll to next step */
jQuery(document).ready(function() {
    jQuery('.ld-service').on('click', function() {
        jQuery('html, body').stop().animate({
            'scrollTop': jQuery('.ld-scroll-meth-unit').offset().top - 30
        }, 800, 'swing', function() {});
    });
});

/* forget password */
jQuery(document).ready(function() {
    jQuery('#ld_forget_password').click(function() {
        jQuery('#rp_user_email').val('');
        jQuery('.forget_pass_correct').hide();
        jQuery('.forget_pass_incorrect').hide();
        jQuery('.ld-front-forget-password').addClass('show-data');
        jQuery('.ld-front-forget-password').removeClass('hide-data');
        jQuery('.main').css('display', 'block');

    });
    jQuery('#ld_login_user').click(function() {
        jQuery('.ld-front-forget-password').removeClass('show-data');
        jQuery('.ld-front-forget-password').addClass('hide-data');
        jQuery('.main').css('display', 'none');
    });
});


/* card payment validations */
jQuery(document).ready(function() {

    jQuery('input.cc-number').payment('formatCardNumber');
    jQuery('input.cc-cvc').payment('formatCardCVC');
    jQuery('input.cc-exp-month').payment('restrictNumeric');
    jQuery('input.cc-exp-year').payment('restrictNumeric');

});

jQuery(document).ready(function() {
    /* jQuery('body').niceScroll(); */
    jQuery('.common-data-dropdown').niceScroll();
    jQuery('.ld-services-dropdown').niceScroll();

    var frequently_discount_id = jQuery("input[name=frequently_discount_radio]:checked").data('id');
    var frequently_discount_name = jQuery("input[name=frequently_discount_radio]:checked").data('name');
    if (frequently_discount_id == 0) {
        jQuery('.f_dis_img').hide();
    } else {
        jQuery('.f_dis_img').show();
        jQuery(".f_discount_name").text(frequently_discount_name);
    }
});

jQuery(document).ready(function() {
    jQuery('.ld-loading-main').hide();
    var subheader_status = subheaderObj.subheader_status;
    if (subheader_status == 'Y') {
        jQuery('.ld-sub').show();
    } else {
        jQuery('.ld-sub').hide();
    }
    if (ld_postalcode_status_check == 'Y') {
        jQuery('.ld_remove_id').attr('id', '');
        jQuery(document).on('click', '.ld_remove_id', function() {
            jQuery('#ld_postal_code').focus();
            jQuery('#ld_postal_code').keyup();
        });
    }
    jQuery('.ld-sub').show();
    jQuery('.ld-loading-main-complete_booking').hide();
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
    jQuery('.hide_self_service').hide();
    jQuery('.hidedatetime_value').hide();
    jQuery('.hidedatetime_del_value').hide();
    jQuery('.hideduration_value').hide();
    jQuery('.s_m_units_design_1').hide();
    jQuery('.s_m_units_design_2').hide();
    jQuery('.s_m_units_design_3').hide();
    jQuery('.s_m_units_design_4').hide();
    jQuery('.s_m_units_design_5').hide();
    jQuery('.ld-provider-list').hide();

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

/* checkout payment method listing show hide */
jQuery(document).ready(function() {
    jQuery(".cccard").click(function() {
        var test = jQuery(this).val();

        jQuery(".common-payment-style").show("blind", {
            direction: "vertical"
        }, 300);
    });

    jQuery("input[name=payment-methods]").click(function() {
        if (jQuery(this).hasClass('cccard')) {
            jQuery(".common-payment-style-bank-transfer").hide();
        } else {
            jQuery(".common-payment-style").hide();
            jQuery(".common-payment-style-bank-transfer").hide();
        }
    });

});

/* bank transfer */
jQuery(document).ready(function() {
    jQuery(".bank_transfer").click(function() {
        jQuery(".common-payment-style-bank-transfer").show("blind", {
            direction: "vertical"
        }, 300);
    });

    jQuery("input[name=payment-methods]").click(function() {
        if (jQuery(this).hasClass('bank_transfer')) {
            jQuery(".common-payment-style").hide();
        } else {
            jQuery(".common-payment-style-bank-transfer").hide();
        }
    });

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

/* right side scrolling cart */
var scrollable_cart_value = scrollable_cartObj.scrollable_cart;

if (scrollable_cart_value == 'Y') {
    function laundry_sidebar_scroll() {

        var $sidebar = jQuery(".ld-price-scroll"),
            $window = jQuery(window),
            offset = $sidebar.offset(),
            sel_service = jQuery(".sel-service").text();

        if (sel_service != "") {
            $window.scroll(function() {
                if (offset.top > $window.scrollTop()) {
                    $sidebar.stop().animate({
                        marginTop: 20
                    });
                } else {
                    $sidebar.stop().animate({
                        marginTop: ($window.scrollTop() - offset.top) + 40
                    });
                }
            });
        } else {
            $window.scroll(function() {
                if (offset.top > $window.scrollTop()) {
                    $sidebar.stop().animate({
                        marginTop: 20
                    });
                } else {
                    $sidebar.stop().animate({
                        marginTop: ($window.scrollTop() - offset.top) + 20
                    });
                }
            });
        }
    }
} else {
    function laundry_sidebar_scroll() {

    }
}

/*  create the back to top button */
jQuery(document).ready(function() {
    jQuery('body').prepend('<a href="javascript:void(0)" class="ld-back-to-top"></a>');
    var amountScrolled = 500;
    jQuery(window).scroll(function() {
        if (jQuery(window).scrollTop() > amountScrolled) {
            jQuery('a.ld-back-to-top').fadeIn('slow');
        } else {
            jQuery('a.ld-back-to-top').fadeOut('slow');
        }
    });
    jQuery('a.ld-back-to-top, a.ld-simple-back-to-top').click(function() {
        jQuery('html, body').animate({
            scrollTop: 0
        }, 2000);
        return false;
    });
});




/************* Code by developer side --- ****************/

jQuery(document).on('keyup keydown blur', '.add_show_error_class', function(event) {
    jQuery('.ld-loading-main').hide();
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

jQuery(document).ready(function() {
    var two_checkout_status = twocheckout_Obj.twocheckout_status;
    if (two_checkout_status == 'Y') {
        TCO.loadPubKey('sandbox');
    }

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


var clicked = false;
jQuery(document).on('click', '#complete_bookings', function(e) {

    var stripe_pubkey = baseurlObj.stripe_publishkey;
    var stripe_status = baseurlObj.stripe_status;
    if (stripe_status == 'on') {
        Stripe.setPublishableKey(stripe_pubkey);
    }
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var terms_condition_setting_value = termsconditionObj.terms_condition;
    var privacy_policy_setting_value = privacypolicyObj.privacy_policy;
    var thankyou_page_setting_value = thankyoupageObj.thankyou_page;
    var front_url = fronturlObj.front_url;
    var existing_username = jQuery("#ld-user-name").val();
    var existing_password = jQuery("#ld-user-pass").val();
    var password = jQuery("#ld-preffered-pass").val();
    var firstname = jQuery("#ld-first-name").val();
    var lastname = jQuery("#ld-last-name").val();
    var staff_id = jQuery(".provider_disable:checked").attr("data-staff_id");
    if (staff_id == undefined) {
        var staff_id = "";
    } else {
        var staff_id = staff_id;
    }
    var email = "";
    if (guest_user_status == "on") {
        email = jQuery("#ld-email-guest").val();
    } else {
        if (is_login_user == "Y") {
            email = existing_username;
        } else {
            email = jQuery("#ld-email").val();
        }
    }

    var phone = jQuery("#ld-user-phone").val();

    /***newly added start***/
    var user_address = jQuery("#ld-street-address").val();
    var user_zipcode = jQuery("#ld-zip-code").val();
    var user_city = jQuery("#ld-city").val();
    var user_state = jQuery("#ld-state").val();
    var address = jQuery("#ld-street-address").val();
    var zipcode = jQuery("#ld-zip-code").val();
    var city = jQuery("#ld-city").val();
    var state = jQuery("#ld-state").val();

    /***newly added end***/

    var notes = jQuery("#ld-notes").val();
    var payment_method = jQuery('.payment_gateway:checked').val();
    var con_status = jQuery("#contact_status").val();

    if (con_status == 'Other') {
        var contact_status = jQuery("#other_contact_status").val();
    } else if (con_status == undefined) {
        var contact_status = '';
    } else {
        var contact_status = jQuery("#contact_status").val();
    }

    var terms_condition = jQuery("#accept-conditions").prop("checked");
    var tc_check = 'N';
    if (terms_condition_setting_value == 'Y' || privacy_policy_setting_value == 'Y') {
        if (terms_condition == true) {
            var tc_check = 'Y';
        }
    } else {
        var tc_check = 'Y';
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

    var booking_del_date_text = "";
    var booking_del_date = "";
    var booking_del_time_slot = "";
    var booking_del_time_start = "";
    var booking_del_time_end = "";
    var booking_del_time_text = "";
    var booking_del_date_time_start = "";
    var booking_del_date_time_end = "";

    if (show_delivery_date == "E") {
        booking_del_date_text = jQuery(".cart_del_date").text();
        booking_del_date = jQuery(".cart_del_date").attr('data-date_del_val');
        booking_del_time_slot = jQuery(".cart_del_time").attr('data-time_del_val').split(" to ");
        booking_del_time_start = booking_del_time_slot[0];
        booking_del_time_end = booking_del_time_slot[1];
        booking_del_time_text = jQuery(".cart_del_time").text();
        booking_del_date_time_start = booking_del_date + ' ' + booking_del_time_start;
        booking_del_date_time_end = booking_del_date + ' ' + booking_del_time_end;
    }

    var booking_date_text = jQuery(".cart_date").text();
    var booking_date = jQuery(".cart_date").attr('data-date_val');
    var booking_time_slot = jQuery(".cart_time").attr('data-time_val').split(" to ");;
    var booking_time_start = booking_time_slot[0];
    var booking_time_end = booking_time_slot[1];
    var booking_time_text = jQuery(".cart_time").text();
    var booking_pickup_date_time_start = booking_date + ' ' + booking_time_start;
    var booking_pickup_date_time_end = booking_date + ' ' + booking_time_end;
    var currency_symbol = jQuery(this).data('currency_symbol');
    var cart_sub_total = jQuery('.cart_sub_total').text();
    var cart_total = jQuery('.cart_total').text();
    var partialamount = jQuery('.partial_amount').text();
    var cart_discount = jQuery('.cart_discount').text().substring(2);
    var cart_tax = jQuery('.cart_tax').text();
    var special_offer = jQuery('.special_offer').text();
    var amount = cart_sub_total.replace(currency_symbol, '');
    var discount = cart_discount.replace(currency_symbol, '');
    var taxes = cart_tax.replace(currency_symbol, '');
    var special_offer_amounts = special_offer.replace(currency_symbol, '');
    var partial_amount = partialamount.replace(currency_symbol, '');
    var net_amount = cart_total.replace(currency_symbol, '');
    var cart_counting = jQuery("#total_cart_count").val();
    var coupon_code = jQuery('#coupon_val').val();
    var no_units_in_cart_err = jQuery('#no_units_in_cart_err').val();
    var no_units_in_cart_err_count = jQuery('#no_units_in_cart_err_count').val();
    var cc_card_num = jQuery('.cc-number').val();
    var cc_exp_month = jQuery('.cc-exp-month').val();
    var cc_exp_year = jQuery('.cc-exp-year').val();
    var cc_card_code = jQuery('.cc-cvc').val();

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
        amount: amount,
        discount: discount,
        taxes: taxes,
        special_offer_amounts: special_offer_amounts,
        partial_amount: partial_amount,
        net_amount: net_amount,
        booking_pickup_date_time_start: booking_pickup_date_time_start,
        booking_pickup_date_time_end: booking_pickup_date_time_end,
        booking_delivery_date_time_start: booking_del_date_time_start,
        booking_delivery_date_time_end: booking_del_date_time_end,
        self_service_status: self_service_status,
        show_delivery_date: show_delivery_date,
        coupon_code: coupon_code,
        cc_card_num: cc_card_num,
        cc_exp_month: cc_exp_month,
        cc_exp_year: cc_exp_year,
        cc_card_code: cc_card_code,
        guest_user_status: guest_user_status,
        is_login_user: is_login_user,
        staff_id: staff_id,
        action: "complete_booking"
    };

    jQuery('.pickup_time_error').hide();
    jQuery('.delivery_time_error').hide();

    if (jQuery('#user_details_form').valid()) {
        if (jQuery("input[name='service-radio']:checked").val() != 'on' && jQuery("#ld-service-0").val() != 'off' && cart_counting == 1) {
            clicked = false;
            jQuery('.ld-loading-main-complete_booking').hide();
            jQuery('.service_not_selected_error').css('display', 'block');
            jQuery('.service_not_selected_error').css('color', 'red');
            jQuery('.service_not_selected_error').html(errorobj_please_select_a_service);
            jQuery(this).attr("href", '#service_not_selected_error');

        } else if (jQuery('.ser_name_for_error').text() == 'Cleaning Service' && cart_counting == 1) {
            clicked = false;
            jQuery('.ld-loading-main-complete_booking').hide();
            jQuery('.service_not_selected_error_d2').css('color', 'red');
            jQuery('.service_not_selected_error_d2').html(errorobj_please_select_a_service);
            jQuery(this).attr("href", '#service_not_selected_error_d2');
        } else if (cart_counting == 1) {
            clicked = false;
            jQuery('.ld-loading-main-complete_booking').hide();
            jQuery('.empty_cart_error').css('display', 'block');
            jQuery('.empty_cart_error').css('color', 'red');
            jQuery('.empty_cart_error').html(errorobj_please_select_units_or_addons);
            jQuery(this).attr("href", '#empty_cart_error');
        } else if (jQuery("#pickup_date").val() == '') {
            clicked = false;
            jQuery('.ld-loading-main-complete_booking').hide();
            jQuery('.pickup_date_error').css('display', 'block');
            jQuery('.pickup_date_error').css('color', 'red');
            jQuery('.pickup_date_error').html(errorobj_please_select_pickup_date);
            jQuery(this).attr("href", '#date_time_error_id');
        } else if (booking_time_text == '') {
            clicked = false;
            jQuery('.ld-loading-main-complete_booking').hide();
            jQuery('.pickup_time_error').css('display', 'block');
            jQuery('.pickup_time_error').css('color', 'red');
            jQuery('.pickup_time_error').html(errorobj_please_select_pickup_slot);
            jQuery(this).attr("href", '#date_time_error_id');
        } else if (jQuery("#delivery_date").val() == '' && show_delivery_date == "E") {
            clicked = false;
            jQuery('.ld-loading-main-complete_booking').hide();
            jQuery('.delivery_date_error').css('display', 'block');
            jQuery('.delivery_date_error').css('color', 'red');
            jQuery('.delivery_date_error').html(errorobj_please_select_delivery_date);
            jQuery(this).attr("href", '#date_time_error_id');

        } else if (booking_del_time_text == '' && show_delivery_date == "E") {
            clicked = false;
            jQuery('.ld-loading-main-complete_booking').hide();
            jQuery('.delivery_time_error').css('display', 'block');
            jQuery('.delivery_time_error').css('color', 'red');
            jQuery('.delivery_time_error').html(errorobj_please_select_delivery_slot);
            jQuery(this).attr("href", '#date_time_error_id');

        } else if (no_units_in_cart_err == 'units_and_addons_both_exists' && no_units_in_cart_err_count == 'unit_not_added') {
            clicked = false;
            jQuery('.ld-loading-main-complete_booking').hide();
            jQuery('.no_units_in_cart_error').show();
            jQuery('.no_units_in_cart_error').css('color', 'red');
            jQuery('.no_units_in_cart_error').html(errorobj_please_select_atleast_one_unit);
            jQuery(this).attr("href", '#no_units_in_cart_error');
        } else if (jQuery('#check_login_click').val() == 'not' && jQuery('#existing-user').prop("checked") == true) {
            clicked = false;
            jQuery('.ld-loading-main-complete_booking').hide();
            jQuery('.login_unsuccessfull').css('display', 'block');
            jQuery('.login_unsuccessfull').css('color', 'red');
            jQuery('.login_unsuccessfull').css('margin-left', '15px');
            jQuery('.login_unsuccessfull').html(errorobj_please_login_to_complete_booking);
            jQuery(this).attr("href", '#login_unsuccessfull');
        } else {
            if (tc_check == 'Y') {
                if (clicked === false) {
                    jQuery(this).attr("href", 'javascript:void(0);');
                    clicked = true;
                    if (payment_method == 'paypal') {
                        jQuery('.ld-loading-main-complete_booking').show();
                        jQuery.ajax({
                            type: "POST",
                            url: front_url + "checkout.php",
                            data: dataString,
                            success: function(response) {
                                var response_detail = jQuery.parseJSON(response);
                                if (response_detail.status == 'success') {
                                    jQuery('.ld-loading-main-complete_booking').hide();
                                    window.location = response_detail.value;
                                }
                                if (response_detail.status == 'error') {
                                    clicked = false;
                                    jQuery('.ld-loading-main-complete_booking').hide();
                                    jQuery('#paypal_error').show();
                                    jQuery('#paypal_error').text(response_detail.value);
                                }
                            }
                        })
                    } else if (payment_method == 'card-payment') {
                        jQuery('.ld-loading-main-complete_booking').show();
                        jQuery.ajax({
                            type: "POST",
                            url: front_url + "checkout.php",
                            data: dataString,
                            success: function(response) {
                                var response_detail = jQuery.parseJSON(response);
                                if (response_detail.success == false) {
                                    clicked = false;
                                    jQuery('.ld-loading-main-complete_booking').hide();
                                    jQuery('#ld-card-payment-error').show();
                                    jQuery('#ld-card-payment-error').text(response_detail.error);
                                } else {
                                    jQuery.ajax({
                                        type: "POST",
                                        url: front_url + "booking_complete.php",
                                        data: {
                                            transaction_id: response_detail.transaction_id
                                        },
                                        success: function(response) {
                                            if (jQuery.trim(response) == 'ok') {
                                                jQuery('.ld-loading-main-complete_booking').hide();
                                                window.location = thankyou_page_setting_value;
                                            }
                                        }
                                    })
                                }
                            }
                        })

                    } else if (payment_method == 'stripe-payment') {
                        jQuery('.ld-loading-main-complete_booking').show();
                        var stripeResponseHandler = function(status, response) {
                            if (response.error) {
                                /* Show the errors on the form*/
                                clicked = false;
                                jQuery('.ld-loading-main-complete_booking').hide();
                                jQuery('#ld-card-payment-error').show();
                                jQuery('#ld-card-payment-error').text(response.error.message);
                            } else {
                                /* token contains id, last4, and card type*/
                                var token = response.id;

                                function waitForElement() {
                                    if (typeof token !== "undefined" && token != '') {

                                        var st_token = token;
                                        dataString['st_token'] = st_token;
                                        jQuery.ajax({
                                            type: "POST",
                                            url: front_url + "checkout.php",
                                            data: dataString,
                                            success: function(response) {
                                                if (jQuery.trim(response) == 'ok') {
                                                    jQuery('.ld-loading-main-complete_booking').hide();
                                                    window.location = thankyou_page_setting_value;
                                                } else {
                                                    clicked = false;
                                                    jQuery('.ld-loading-main-complete_booking').hide();
                                                    jQuery('#ld-card-payment-error').show();
                                                    jQuery('#ld-card-payment-error').text(response);
                                                }
                                            }
                                        });



                                    } else {
                                        setTimeout(function() {
                                            waitForElement();
                                        }, 2000);
                                    }
                                }

                                waitForElement();
                            }
                        };

                        /*Disable the submit button to prevent repeated clicks*/
                        Stripe.card.createToken({
                            number: jQuery('.ld-card-number').val(),
                            cvc: jQuery('.ld-cvc-code').val(),
                            exp_month: jQuery('.ld-exp-month').val(),
                            exp_year: jQuery('.ld-exp-year').val()
                        }, stripeResponseHandler);

                    } else if (payment_method == '2checkout-payment') {
                        var seller_id = twocheckout_Obj.sellerId;
                        var publishable_Key = twocheckout_Obj.publishKey;
                        /*  Called when token created successfully. */
                        jQuery('.ld-loading-main-complete_booking').show();

                        function successCallback(data) {
                            /* Set the token as the value for the token input */
                            var twoctoken = data.response.token.token;
                            dataString['twoctoken'] = twoctoken;
                            jQuery.ajax({
                                type: "POST",
                                url: front_url + "checkout.php",
                                data: dataString,
                                success: function(response) {
                                    if (jQuery.trim(response) == 'ok') {
                                        jQuery('.ld-loading-main-complete_booking').hide();
                                        window.location = thankyou_page_setting_value;
                                    } else {
                                        clicked = false;
                                        jQuery('.ld-loading-main-complete_booking').hide();
                                        jQuery('#ld-card-payment-error').show();
                                        jQuery('#ld-card-payment-error').text(response);
                                    }
                                }
                            });
                        };

                        /*  Called when token creation fails. */
                        function errorCallback(data) {
                            if (data.errorCode === 200) {
                                clicked = false;
                                jQuery('.ld-loading-main-complete_booking').hide();
                                tokenRequest();
                            } else {
                                clicked = false;
                                jQuery('.ld-loading-main-complete_booking').hide();
                                jQuery('#ld-card-payment-error').show();
                                jQuery('#ld-card-payment-error').text(response.error.message);
                            }
                        };

                        function tokenRequest() {
                            /* Setup token request arguments */
                            var args = {
                                sellerId: seller_id,
                                publishableKey: publishable_Key,
                                ccNo: jQuery('.ld-card-number').val(),
                                cvv: jQuery('.ld-cvc-code').val(),
                                expMonth: jQuery('.ld-exp-month').val(),
                                expYear: jQuery('.ld-exp-year').val()
                            };
                            /* Make the token request */
                            TCO.requestToken(successCallback, errorCallback, args);
                        };

                        tokenRequest();
                    } else if (payment_method == 'payumoney') {
                        jQuery.ajax({
                            type: "POST",
                            url: front_url + "checkout.php",
                            data: dataString,
                            success: function(response) {
                                var pm = jQuery.parseJSON(response);
                                jQuery("#payu_key").val(pm.merchant_key);
                                jQuery("#payu_hash").val(pm.hash);
                                jQuery("#payu_txnid").val(pm.txnid);
                                jQuery("#payu_amount").val(pm.amt);
                                jQuery("#payu_fname").val(pm.fname);
                                jQuery("#payu_email").val(pm.email);
                                jQuery("#payu_phone").val(pm.phone);
                                jQuery("#payu_productinfo").val(pm.productinfo);
                                jQuery("#payu_surl").val(pm.payu_surl);
                                jQuery("#payu_furl").val(pm.payu_furl);
                                jQuery("#payu_service_provider").val(pm.service_provider);
                                jQuery("#payuForm").submit();
                            }
                        });
                    } else if (payment_method == 'pay at venue' || payment_method == 'bank transfer' || payment_method == '') {
                        jQuery('.ld-loading-main-complete_booking').show();
                        jQuery.ajax({
                            type: "POST",
                            url: front_url + "checkout.php",
                            data: dataString,
                            success: function(response) {
                                if (jQuery.trim(response) == 'ok') {
                                    jQuery('.ld-loading-main-complete_booking').hide();
                                    window.location = thankyou_page_setting_value;
                                }
                            }
                        })
                    }
                    payment_process_js(payment_method, thankyou_page_setting_value, dataString, front_url);
                } else {
                    e.preventDefault();
                }
            } else {
                if (terms_condition_setting_value == 'Y' || privacy_policy_setting_value == 'Y') {
                    jQuery(this).attr("href", 'javascript:void(0);');
                    clicked = false;
                    jQuery('.ld-loading-main-complete_booking').hide();
                    jQuery('.terms_and_condition').show();
                    jQuery('.terms_and_condition').css('color', 'red');
                    jQuery('.terms_and_condition').html(errorobj_please_accept_terms_and_conditions);
                }
            }
        }
    }

    jQuery('.add_show_error_class').each(function() {
        jQuery(this).trigger('keyup');
    });

});

jQuery(document).on('click', '#accept-conditions', function() {
    jQuery('.terms_and_condition').hide();
});
jQuery(document).on('click', '#login_existing_user', function() {
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
    var existing_username = jQuery("#ld-user-name").val();
    var existing_password = jQuery("#ld-user-pass").val();
    dataString = {
        existing_username: existing_username,
        existing_password: existing_password,
        action: "get_existing_user_data"
    };

    if (!jQuery('#user_login_form').valid()) {
        return false;
    }

    jQuery.ajax({
        type: "POST",
        url: ajax_url + "front_ajax.php",
        data: dataString,
        success: function(response) {

            var userdata = jQuery.parseJSON(response);
            if (userdata.status == 'Incorrect Email Address or Password') {
                jQuery('.login_unsuccessfull').css('display', 'block');
                jQuery('.login_unsuccessfull').css('color', 'red');
                jQuery('.login_unsuccessfull').css('margin-left', '15px');
                jQuery('#check_login_click').val('not');
                jQuery('.login_unsuccessfull').html(errorobj_incorrect_email_address_or_password);
                is_login_user = "N";
            } else {
                is_login_user = "Y";
                jQuery('#check_login_click').val('clicked');
                jQuery('.client_logout').css('display', 'block');
                jQuery(".fancy_input").parent().addClass("focused_label_wrap");
                jQuery(".phone_no_wrap").addClass("focused_label_wrap");
                jQuery('.client_logout').show();
                jQuery("#ld-email").val(existing_username);
                jQuery(".fname").text(userdata.firstname);
                jQuery(".lname").text(userdata.lastname);

                jQuery('.hide_login_btn').hide();
                jQuery('.hide_radio_btn_after_login').hide();
                jQuery('.hide_email').hide();
                jQuery('.hide_login_email').hide();
                jQuery('.hide_password').hide();
                jQuery('.ld-peronal-details').show();
                jQuery('.login_unsuccessfull').hide();
                jQuery('.ld-sub').hide();

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
        }
    });

});
jQuery(document).on('click', '#ld-user-name', function() {
    jQuery('.login_unsuccessfull').hide();
});

jQuery(document).on('click', '#ld-user-pass', function() {
    jQuery('.login_unsuccessfull').hide();
});

jQuery(document).ready(function() {
    var password_check = check_password;
    jQuery('#user_login_form').validate({
        rules: {
            ld_user_name: {
                required: true,
                email: true
            },
            ld_user_pass: {
                required: true,
                minlength: password_check.min,
                maxlength: password_check.max
            }
        },
        messages: {
            ld_user_name: {
                required: errorobj_please_enter_email_address,
                email: errorobj_please_enter_valid_email_address
            },
            ld_user_pass: {
                required: errorobj_please_enter_password,
                minlength: errorobj_min_ps,
                maxlength: errorobj_max_ps
            }
        }
    });
});

jQuery(document).ready(function() {
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

    /* validaition condition*/
    jQuery("#user_details_form").validate();

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
                maxlength: errorobj_max_ph
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
                url: front_url + "firststep.php",
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
    /* end validaition condition*/

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

jQuery(document).on("change", ".guest-user", function() {
    if (jQuery('.guest-user').is(':checked')) {
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
        jQuery('.remove_preferred_password_and_preferred_email').hide("blind", {
            direction: "vertical"
        }, 300);
        jQuery('.remove_guest_user_preferred_email').show("blind", {
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
        guest_user_status = 'on';
    }
});
jQuery(document).ready(function() {
    if (jQuery('.guest-user').is(':checked')) {
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
        jQuery('.remove_preferred_password_and_preferred_email').hide("blind", {
            direction: "vertical"
        }, 300);
        jQuery('.remove_guest_user_preferred_email').show("blind", {
            direction: "vertical"
        }, 300);
        if (jQuery(".remove_zip_code_class").hasClass("ld-md-4")) {
            jQuery('.remove_zip_code_class').removeClass('ld-md-4');
            jQuery('.remove_zip_code_class').addClass('ld-md-6');
        }
        if (jQuery(".remove_city_class").hasClass("ld-md-4")) {
            jQuery('.remove_city_class').removeClass('ld-md-4');
            jQuery('.remove_city_class').addClass('ld-md-6');
        }
        if (jQuery(".remove_state_class").hasClass("ld-md-4")) {
            jQuery('.remove_state_class').removeClass('ld-md-4');
            jQuery('.remove_state_class').addClass('ld-md-6');
        }
        guest_user_status = 'on';
    }
});
jQuery(document).on("click", "#logout", function() {
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var id = jQuery(this).data('id');
    dataString = {
        id: id,
        action: "logout"
    };
    jQuery.ajax({
        type: "POST",
        url: ajax_url + "front_ajax.php",
        data: dataString,
        success: function(response) {
            if (jQuery.trim(response) == 'logout successful') {
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
                jQuery('.ld-sub').show();
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
                jQuery("#existing-user").prop('checked', true);
                jQuery(".existing-user").trigger('change');
                is_login_user = "N";
            }
        }
    })
});

/*For Multicart(multi service add)*/

var count_cart = 0;
var current_service_name = "";
var cart_dynamic_key = "";
var check_cart_details = true;

jQuery(document).on('click', '.ser_details', function() {

    check_cart_details = false;
    jQuery(":input", this).prop('checked', true);
    jQuery('.ld-loading-main').show();
    jQuery('.show_methods_after_service_selection').show();
    jQuery('.ld_method_tab-slider-tabs').removeClass('ld_methods_slide');
    jQuery('.service_not_selected_error_d2').removeAttr('style', '');
    jQuery('.service_not_selected_error_d2').html(errorobj_please_select_a_service);
    jQuery('.freq_discount_display').hide();
    jQuery('.service_not_selected_error').hide();
    jQuery('.partial_amount_hide_on_load').hide();
    jQuery('.hide_right_side_box').hide();
    jQuery('.freq_disc_empty_cart_error').hide();
    jQuery('.s_m_units_design_1').hide();
    jQuery('.s_m_units_design_2').hide();
    jQuery('.s_m_units_design_3').hide();
    jQuery('.s_m_units_design_4').hide();
    jQuery('.s_m_units_design_5').hide();
    jQuery('#apply_coupon').show();
    jQuery('#coupon_val').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.show_select_staff_title').show();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var id = jQuery(this).data('id');
    var name = jQuery(this).data('servicetitle');
    current_service_name = name;
    jQuery('.sel-service').html(name);
    var check_li_exist = true;
    var force_hidden = "";
    var old_cart_dynamic_key = 0;

    jQuery('.cart_toggle_head').each(function() {
        var service_head_id = jQuery(this).attr("data-service_id");
        var service_head_cart_dynamic_key = jQuery(this).attr("data-id");
        var remove_li_class = "cart_service_item_listing_li" + service_head_cart_dynamic_key;
        var check_ul_class = "ld-addon-items-list_" + service_head_cart_dynamic_key;
        if (jQuery("." + check_ul_class + " li").length == 0) {
            jQuery("." + remove_li_class).remove();
        }
        if (service_head_id == id) {
            check_li_exist = false;
            old_cart_dynamic_key = service_head_cart_dynamic_key;
        }
    });

    if (check_li_exist) {
        count_cart++;
        cart_dynamic_key = id + "_" + count_cart;
        var ser_ids_lis = "cart_service_item_listing_li" + cart_dynamic_key;
        var ser_ids_h4_class = "cart_toggle_head_4_" + cart_dynamic_key;
        var ser_ids_uls = "cart_item_listing" + cart_dynamic_key;
        var ser_ids_divs = "cart_toggle_content_" + cart_dynamic_key;
        var ser_ids_iis = "ct_icon_check_" + cart_dynamic_key;

        var ser_datetime = "hidedatetime_value_" + cart_dynamic_key;
        var ser_cart_date = "cart_date_" + cart_dynamic_key;
        var ser_cart_time = "cart_time_" + cart_dynamic_key;

        var lidtls = "<li class='" + ser_ids_lis + "'><h4 class='cart_toggle_head " + ser_ids_h4_class + "' data-id='" + cart_dynamic_key + "' data-service_id='" + id + "' >" + current_service_name + "<i class='fa fa-plus pull-right " + ser_ids_iis + "'></i></h4> <div id='" + ser_ids_divs + "' class='cart_toggle_content' style='display:none ;'><ul class='ld-addon-items-list_" + cart_dynamic_key + "'></ul></li>";

        jQuery(".cart_item_listing").append(lidtls);

    } else {
        cart_dynamic_key = old_cart_dynamic_key;
    }

    jQuery('.addon_qty').each(function() {
        jQuery(this).val(0);
        jQuery('.add_minus_button').hide();
    });

    if (jQuery('.ser_name_for_error').text() != 'Cleaning Service' && jQuery('.service-method-name').text() == 'Service Usage Methods') {
        jQuery('.method_not_selected_error').css('display', 'block');
        jQuery('.method_not_selected_error').css('color', 'red');
        jQuery('.method_not_selected_error').html("Please Select Method");
    } else if (jQuery("input[name='service-radio']:checked").val() == 'on' && jQuery('.service-method-name').text() == 'Service Usage Methods') {
        jQuery('.method_not_selected_error').css('display', 'block');
        jQuery('.method_not_selected_error').css('color', 'red');
        jQuery('.method_not_selected_error').html("Please Select Method");
    }

    /* display all units of the selected services */
    jQuery.ajax({
        type: 'post',
        data: {
            'service_id': id,
            'cart_dynamic_key': cart_dynamic_key,
            'get_service_units': 1
        },
        url: ajax_url + "front_ajax.php",
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
                responsive: [{
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

            laundry_sidebar_scroll();
        }
    });
    /* jQuery.ajax({
        type: 'post',
        data: {
          'service_id': id,
          'operationgetmethods': 1
        },
        url: ajax_url + "front_ajax.php",
        success: function (res) {
          jQuery('.ld-loading-main').hide();
          var methods_data = jQuery.parseJSON(res);
          jQuery('.service_select').trigger('click'); */


    var ld_postal_input = jQuery(".ld-postal-input").val();
    // alert(ld_postal_input);
    jQuery.ajax({
        type: 'post',
        data: {
            'service_id': id,
            ld_postal_input: ld_postal_input,
            'staff_select_according_service': 1
        },
        url: ajax_url + "front_ajax.php",
        success: function(res) {


            var search_session_data = jQuery.parseJSON(res);


            if (search_session_data.found_status == 'found') {
                jQuery('.ld-provider-list').show();

                var search_staff_id = search_session_data.staff_id;

                jQuery.ajax({
                    type: "POST",
                    url: ajax_url + "front_ajax.php",
                    data: {
                        'staff_search': search_staff_id,
                        'get_search_staff_detail': 1
                    },
                    success: function(res) {
                        jQuery('.provders-list').html(res);
                    }
                });

            } else if (search_session_data.found_status == 'not found') {
                jQuery('.ct-provider-list').hide();

            }
        }
    });

    var ld_postal_input = jQuery(".ld-postal-input").val();
    /* alert(ld_postal_input); */
    jQuery.ajax({
        type: 'post',
        data: {
            'service_id': id,
            ld_postal_input: ld_postal_input,
            'staff_select_according_service': 1
        },
        url: ajax_url + "front_ajax.php",
        success: function(res) {



            var search_session_data = jQuery.parseJSON(res);


            if (search_session_data.found_status == 'found') {
                jQuery('.ct-provider-list').show();
                /* jQuery('.staff_search_id').html(search_session_data.staff_id); */
                /* jQuery('.staff_search_id').attr("data-id",search_session_data.staff_id); */
                var search_staff_id = search_session_data.staff_id;

                jQuery.ajax({
                    type: "POST",
                    url: ajax_url + "front_ajax.php",
                    data: {
                        'staff_search': search_staff_id,
                        'get_search_staff_detail': 1
                    },
                    success: function(res) {
                        jQuery('.provders-list').html(res);
                    }
                });

            } else if (search_session_data.found_status == 'not found') {
                jQuery('.ct-provider-list').hide();

            }

        }
    });

    jQuery(document).on('click', '.provider_select', function() {
        var site_url = siteurlObj.site_url;
        var staff_id = jQuery(this).data('id');

        jQuery.ajax({
            type: 'post',
            data: {
                'staff_id': staff_id,
                'get_staff_sess': 1
            },
            url: site_url + "front/firststep.php",
            success: function(res) {

            }
        });


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

/* counting for units */
jQuery(document).on('click', '.add', function() {

    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var ids = jQuery(this).data('ids');
    var db_qty = jQuery(this).data('db-qty');
    var unit_name = jQuery(this).data('unit_name');
    var units_id = jQuery(this).data('units_id');
    var u_name = jQuery(this).data('unamee');
    var minlimit = jQuery(this).data('minlimit');

    var express_status = jQuery("#express_status").prop("checked");
    if (express_status == true) {
        express_status = "on";
    } else {
        express_status = "off";
    }

    jQuery('.coupon_display').hide();
    jQuery('.hide_coupon_textbox').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_invalid_error').hide();
    var qty_val = parseInt(jQuery('.qtyyy_' + u_name).val());
    var qty_vals = qty_val + 1;
    if (qty_val < db_qty) {
        jQuery('.qtyyy_' + u_name).val(qty_vals);
        var final_qty_val = qty_vals;

        jQuery.ajax({
            type: 'post',
            data: {
                'unit_qty': final_qty_val,
                'express_status': express_status,
                'units_id': units_id,
                'unit_name': unit_name,
                'ids': ids,
                "s_m_rate": 0,
                'cart_dynamic_key': cart_dynamic_key,
                'add_to_cart': 1
            },
            url: site_url + "front/firststep.php",
            success: function(res) {
                jQuery('.empty_cart_error').hide();
                var cart_session_data = jQuery.parseJSON(res);
                if (cart_session_data.subtotal_amount == 0) {
                    jQuery('.hideduration_value').hide();
                    jQuery(".cart_empty_msg").show();
                    jQuery('.partial_amount_hide_on_load').hide();
                    jQuery('.cart_sub_total').empty();
                    jQuery('.cart_tax').empty();
                    jQuery('.express_booking_price').empty();
                    jQuery('.cart_total').empty();
                    jQuery(".special_offer").empty();
                    jQuery('.cart_item_listing').html(cart_session_data.cart_html);
                    jQuery('.partial_amount').html(cart_session_data.partial_amount);
                    jQuery('.remain_amount').html(cart_session_data.remain_amount);
                    jQuery("#total_cart_count").val('1');
                } else {
                    var lidtls = cart_session_data.cart_html;
                    jQuery('.hideduration_value').show();
                    jQuery(".cart_empty_msg").hide();
                    jQuery('.partial_amount_hide_on_load').show();
                    jQuery('.ld-addon-items-list_' + cart_dynamic_key).html(lidtls);
                    jQuery('.cart_sub_total').html(cart_session_data.subtotal);
                    jQuery('.cart_tax').html(cart_session_data.cart_tax);
                    jQuery('.express_booking_price').html(cart_session_data.ex_booking_price);
                    jQuery('.cart_total').html(cart_session_data.total_amount);
                    jQuery(".special_offer").html(cart_session_data.special_offer_amount);
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

    var express_status = jQuery("#express_status").prop("checked");
    if (express_status == true) {
        express_status = "on";
    } else {
        express_status = "off";
    }

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
            'express_status': express_status,
            'unit_qty': qty_vals,
            'units_id': units_id,
            'unit_name': unit_name,
            "s_m_rate": res,
            'cart_dynamic_key': cart_dynamic_key,
            'add_to_cart': 1
        },
        url: site_url + "front/firststep.php",
        success: function(res) {
            jQuery('.empty_cart_error').hide();
            var cart_session_data = jQuery.parseJSON(res);
            if (cart_session_data.current_item_qty == 0) {
                jQuery(".update_qty_of_s_m_" + units_id + service_id).remove();
                jQuery('.cart_sub_total').html(cart_session_data.subtotal);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.express_booking_price').html(cart_session_data.ex_booking_price);
                jQuery('.cart_total').html(cart_session_data.total_amount);
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery(".special_offer").html(cart_session_data.special_offer_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
            } else if (cart_session_data.subtotal_amount == 0) {
                jQuery('.hideduration_value').hide();
                jQuery(".cart_empty_msg").show();
                jQuery('.partial_amount_hide_on_load').hide();
                jQuery('.cart_sub_total').empty();
                jQuery('.cart_tax').empty();
                jQuery('.express_booking_price').empty();
                jQuery('.cart_total').empty();
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery(".special_offer").empty();
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
            } else {
                var lidtls = cart_session_data.cart_html;
                jQuery('.hideduration_value').show();
                jQuery(".cart_empty_msg").hide();
                jQuery('.partial_amount_hide_on_load').show();
                jQuery('.ld-addon-items-list_' + cart_dynamic_key).html(lidtls);
                jQuery('.cart_sub_total').html(cart_session_data.subtotal);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.express_booking_price').html(cart_session_data.ex_booking_price);
                jQuery('.cart_total').html(cart_session_data.total_amount);
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery(".special_offer").html(cart_session_data.special_offer_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery("#total_cart_count").val('2');
            }
        }
    });
});


/* new existing user */


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

function price_format_with_symbol(ld_amount) {
    var ld_amount = parseFloat(ld_amount);
    if (currency_symbol_position == "$100") {
        return currency_symbol + ld_amount.toFixed(price_format_decimal_places);
    } else {
        return ld_amount.toFixed(price_format_decimal_places) + currency_symbol;
    }
}



jQuery(document).on("change", "#contact_status", function() {
    var contact_status = jQuery("#contact_status").val();
    if (contact_status == 'Other') {
        jQuery(".ld-option-others").show();
    } else {
        jQuery(".ld-option-others").hide();
    }
});

/* service checkbox */

jQuery(document).ready(function() {
    jQuery("input[name=service-radio]").click(function() {

    });
});

jQuery(document).on("click", ".select-language", function() {
    jQuery(".ld-language-dropdown").toggle("blind", {
        direction: "vertical"
    }, 300);
});
jQuery(document).on("click", ".select_language_view", function() {
    jQuery('.ld-loading-main').show();
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
        url: ajax_url + "front_ajax.php",
        success: function(res) {
            location.reload();
        }
    });
});


/* remove item btn-from the cart */
jQuery(document).on("click", ".remove_item_from_cart", function() {
    var ajax_url = ajaxurlObj.ajax_url;
    var unit_id = jQuery(this).data('units_id');
    var unit_qty = jQuery(this).data('unit_qty');
    var service_id = jQuery(this).data('service_id');
    var delete_key = jQuery(this).data('delete_key');
    var cart_dynamic_key = jQuery(this).data('key');

    jQuery('#apply_coupon').show();
    jQuery('#coupon_val').show();
    jQuery('.ld-display-coupon-code').hide();
    jQuery('.coupon_display').hide();
    jQuery.ajax({
        type: 'POST',
        data: {
            'unit_id': unit_id,
            'unit_qty': unit_qty,
            'service_id': service_id,
            'delete_key': delete_key,
            'cart_dynamic_key': cart_dynamic_key,
            'cart_item_remove': 1
        },
        url: ajax_url + "front_ajax.php",
        success: function(res) {
            var cart_session_data = jQuery.parseJSON(res);
            jQuery('#ld_area_m_units').val('');
            jQuery('#qty' + unit_id).val('0');
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
                jQuery(".special_offer").empty();
                jQuery(".cart_discount").empty();
            } else if (cart_session_data.status == 'cart not empty') {
                jQuery("#total_cart_count").val('2');
                jQuery(".cart_empty_msg").hide();
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery(".special_offer").html(cart_session_data.special_offer_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery(".update_qty_of_s_m_" + unit_id + service_id).remove();
                jQuery('.cart_sub_total').html(cart_session_data.subtotal_amount);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
                jQuery('.cart_total').html(cart_session_data.total_amount);
            } else {
                jQuery("#total_cart_count").val('2');
                jQuery(".cart_empty_msg").hide();
                jQuery('.partial_amount').html(cart_session_data.partial_amount);
                jQuery(".special_offer").html(cart_session_data.special_offer_amount);
                jQuery('.remain_amount').html(cart_session_data.remain_amount);
                jQuery(".update_qty_of_s_m_" + unit_id + service_id).remove();
                jQuery('.cart_sub_total').html(cart_session_data.subtotal_amount);
                jQuery('.cart_tax').html(cart_session_data.cart_tax);
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
                url: site_url + "front/firststep.php",
                data: {
                    'coupon_code': coupon_code,
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
                        jQuery('.hide_coupon_textbox').hide();
                        jQuery('.coupon_display').show();
                        jQuery('.partial_amount').html(cart_session_data.partial_amount);
                        jQuery(".special_offer").html(cart_session_data.special_offer_amount);
                        jQuery('.remain_amount').html(cart_session_data.remain_amount);
                        jQuery('.cart_sub_total').html(cart_session_data.cart_sub_total);
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
    jQuery.ajax({
        type: "POST",
        url: site_url + "front/firststep.php",
        data: {
            'coupon_reverse': coupon_reverse,
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
                jQuery(".special_offer").html(cart_session_data.special_offer_amount);
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
            jQuery(".pickup-slots").html(res);
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
    /* alert(pickup_date); */
    var pickup_slots = jQuery(".pickup-slots").val();
    /* alert(pickup_slots) */
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
            /* alert(res); */
            $(".delivery-slots").html(res);
        }
    });
});

var get_all_postal_code = [];
jQuery(document).ready(function() {
    jQuery('.space_between_date_time').hide();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    jQuery.ajax({
        type: "POST",
        url: ajax_url + "front_ajax.php",
        data: {
            'get_postal_code': 1
        },
        success: function(res) {
            get_all_postal_code = jQuery.parseJSON(res);
            laundry_sidebar_scroll();
        }
    });
});

jQuery(document).ready(function() {
    jQuery('.space_between_date_time_del').hide();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    jQuery.ajax({
        type: "POST",
        url: ajax_url + "front_ajax.php",
        data: {
            'get_postal_code': 1
        },
        success: function(res) {
            get_all_postal_code = jQuery.parseJSON(res);
            laundry_sidebar_scroll();
        }
    });
});

jQuery(document).on("change", ".pickup-slots", function() {
    jQuery('.pickup_time_error').hide();
    jQuery('.delivery_time_error').hide();
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
    jQuery('.pickup_time_error').hide();
    jQuery('.delivery_time_error').hide();
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

    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var pickup_date = jQuery("#pickup_date").val();
    var delivery_date = jQuery("#delivery_date").val();
    var date1 = new Date(pickup_date);
    var date2 = new Date(delivery_date);
    var Difference_In_Time = date2.getTime() - date1.getTime();
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

    if (Difference_In_Days == 1) {
        Argent_book_delivary = 20;
    } else if (Difference_In_Days == 2) {
        Argent_book_delivary = 10;
    } else {
        Argent_book_delivary = 0;
    }

    jQuery.ajax({
        type: 'post',
        data: {
            'Argent_book_delivary': Argent_book_delivary,
            'Argent_delivary': 1
        },
        url: site_url + "front/firststep.php",
        success: function(res) {}
    });

});

/*** calendar code end ***/
/* Display Country Code on click flag on phone*/
jQuery(document).on('click', '.country', function() {
    var country_code = jQuery(this).data("dial-code");
    jQuery("#ld-user-phone").val('+' + country_code);
});

/** Code for area code **/
if (ld_postalcode_status_check == 'Y') {
    jQuery(document).on('keyup', '#ld_postal_code', function(event) {

        var ajax_url = ajaxurlObj.ajax_url;
        var postal_code = jQuery(this).val().toLowerCase();
        if (ld_postalcode_zip_status == 'on') {
            jQuery('#app-zip-code').val(postal_code);
        }
        if (postal_code == '') {
            jQuery('.remove_show_error_class').addClass('show-error');
            jQuery('#complete_bookings').addClass('ld_remove_id');
            jQuery(document).on('click', '.ld_remove_id', function() {
                jQuery('#ld_postal_code').focus();
            });
            jQuery('.ld_remove_id').attr('id', '');
            jQuery('.postal_code_available').hide();
            jQuery('.postal_code_error').show();
            jQuery('.postal_code_error').html(errorobj_please_enter_postal_code);
        } else {
            var check_postal_code = false;
            jQuery('.postal_code_error').hide();
            jQuery('.postal_code_available').hide();
            if (jQuery.inArray(postal_code, get_all_postal_code) !== -1) {
                check_postal_code = true;
            } else {
                jQuery.each(get_all_postal_code, function(key, value) {
                    if (postal_code.substr(0, value.length) === value) {
                        check_postal_code = true;
                    }
                });
            }
            if (check_postal_code) {
                jQuery('.ld_remove_id').attr('id', 'complete_bookings');
                jQuery('#complete_bookings').removeClass('ld_remove_id');
                jQuery('.remove_show_error_class').removeClass('show-error');
                jQuery('.postal_code_error').hide();
            } else {
                jQuery('.remove_show_error_class').addClass('show-error');
                jQuery('#complete_bookings').addClass('ld_remove_id');
                jQuery(document).on('click', '.ld_remove_id', function() {
                    jQuery('#ld_postal_code').focus();
                });
                jQuery('.ld_remove_id').attr('id', '');
                jQuery('.postal_code_error').show();
                jQuery('.postal_code_error').html(errorobj_our_service_not_available_at_your_location);
            }
        }
    });
}

/*Reset Password*/
jQuery(document).on('click', '#reset_pass', function() {

    jQuery('.ld-loading-main').show();
    jQuery('.add_show_error_class').each(function() {
        jQuery(this).trigger('keyup');
    });
    var front_url = fronturlObj.front_url;
    var site_url = siteurlObj.site_url;

    var email = jQuery('#rp_user_email').val();
    var dataString = {
        email: email,
        action: "forget_password"
    };
    if (jQuery('#forget_pass').valid()) {
        jQuery.ajax({
            type: "POST",
            url: front_url + "firststep.php",
            data: dataString,
            success: function(response) {
                jQuery('.ld-loading-main').hide();
                if (response == 'not') {
                    jQuery('.forget_pass_incorrect').css('display', 'block');
                    jQuery('.forget_pass_incorrect').css('color', 'red');
                    jQuery('.forget_pass_incorrect').html(errorobj_invalid_email_id_please_register_first);
                } else {
                    jQuery('.forget_pass_correct').css('display', 'block');
                    jQuery('.forget_pass_correct').css('color', 'green');
                    jQuery('.forget_pass_correct').html(errorobj_your_password_send_successfully_at_your_registered_email_id);

                    jQuery('#reset_pass').unbind('click');
                    jQuery('#reset_pass').css({
                        "pointer-events": "none",
                        "cursor": "default"
                    });
                    setTimeout(function() {
                        window.location.href = site_url;
                    }, 5000);
                    event.preventDefault();
                }
            },
        });
    }
});
/* validation for reset_password.php */
jQuery(document).ready(function(e) {
    jQuery('#forget_pass').submit(function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
    });

    jQuery("#forget_pass").validate({
        rules: {
            rp_user_email: {
                required: true,
                email: true,
            }
        },
        messages: {
            rp_user_email: {
                required: errorobj_please_enter_email_address,
                email: errorobj_please_enter_valid_email_address
            },
        }
    });
});

/* validation for reset_new_password.php */
jQuery(document).ready(function() {
    jQuery('#reset_new_passwd').submit(function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
    });
    jQuery.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "No space allowed");
    jQuery("#reset_new_passwd").validate({
        rules: {
            n_password: {
                required: true,
                minlength: 8,
                maxlength: 10,
                noSpace: true

            },
            rn_password: {
                required: true,
                minlength: 8,
                maxlength: 10,
                noSpace: true
            }
        },
        messages: {
            n_password: {
                required: errorobj_please_enter_new_password,
                minlength: errorobj_password_must_be_8_character_long,
                maxlength: errorobj_please_enter_maximum_10_chars
            },
            rn_password: {
                required: errorobj_please_enter_confirm_password,
                minlength: errorobj_password_must_be_8_character_long,
                maxlength: errorobj_please_enter_maximum_10_chars
            },
        }
    });
});

jQuery(document).on('click', '#rp_user_email', function() {
    jQuery('.forget_pass_incorrect').hide();
});
jQuery(document).on('click', '#rn_password', function() {
    jQuery('.mismatch_password').hide();
});
jQuery(document).on('click', '#n_password', function() {
    jQuery('.mismatch_password').hide();
});
jQuery(document).on('click', '#password', function() {
    jQuery('.succ_password').hide();
});
jQuery(document).on('click', '#email', function() {
    jQuery('.succ_password').hide();
});

/*Reset New Password*/
jQuery(document).on('click', '#reset_new_password', function() {
    jQuery('.ld-loading-main').show();
    var front_url = fronturlObj.front_url;
    var new_reset_pass = jQuery('#n_password').val();
    var retype_new_reset_pass = jQuery('#rn_password').val();
    var dataString = {
        retype_new_reset_pass: retype_new_reset_pass,
        action: "reset_new_password"
    };
    if (jQuery('#reset_new_passwd').valid()) {
        if (new_reset_pass == retype_new_reset_pass) {
            jQuery.ajax({
                type: "POST",
                url: front_url + "firststep.php",
                data: dataString,
                success: function(response) {
                    jQuery('.ld-loading-main').hide();
                    if (response == 'password reset successfully') {
                        jQuery('.succ_password').css('display', 'block');
                        jQuery('.succ_password').addClass('txt-success');
                        jQuery('.succ_password').html(errorobj_your_password_reset_successfully_please_login);
                    }
                },
            });
        } else {
            jQuery('.ld-loading-main').hide();
            jQuery('.mismatch_password').css('display', 'block');
            jQuery('.mismatch_password').addClass('error');
            jQuery('.mismatch_password').html(errorobj_new_password_and_retype_new_password_mismatch);
        }
    }
});

jQuery(document).ready(function() {
    var front_url = fronturlObj.front_url;
    jQuery.ajax({
        type: 'post',
        data: {
            check_for_option: 1
        },
        url: front_url + "firststep.php",
        success: function(res) {
            if (jQuery.trim(res) != "") {
                window.location = front_url + 'maintainance.php';
            }
        }
    });
});
jQuery(document).ready(function() {
    jQuery('[data-toggle="tooltip"]').tooltip({
        'placement': 'right'
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
    if (is_login_user == "Y") {
        var site_url = siteurlObj.site_url;
        var ajax_url = ajaxurlObj.ajax_url;
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
        var existing_username = jQuery("#ld-user-name").val();
        var existing_password = jQuery("#ld-user-pass").val();

        if (!jQuery('#user_login_form').valid()) {
            return false;
        }

        dataString = {
            action: "get_login_user_data"
        };

        jQuery.ajax({
            type: "POST",
            url: ajax_url + "front_ajax.php",
            data: dataString,
            success: function(response) {
                var userdata = jQuery.parseJSON(response);
                if (userdata.status == 'No Login') {
                    is_login_user = "N";
                    return false;
                } else if (userdata.status == 'Incorrect Email Address or Password') {
                    is_login_user = "N";
                    return false;
                } else {
                    is_login_user = "Y";

                    jQuery(".fancy_input").parent().addClass("focused_label_wrap");
                    jQuery(".phone_no_wrap").addClass("focused_label_wrap");
                    jQuery('#check_login_click').val('clicked');
                    jQuery('.client_logout').css('display', 'block');
                    jQuery('.client_logout').show();

                    jQuery(".fname").text(userdata.firstname);
                    jQuery(".lname").text(userdata.lastname);
                    jQuery("#ld-email").val(userdata.email);
                    jQuery("#existing-user").attr('checked', true);

                    jQuery('.hide_login_btn').hide();
                    jQuery('.hide_radio_btn_after_login').hide();
                    jQuery('.hide_email').hide();
                    jQuery('.hide_login_email').hide();
                    jQuery('.hide_password').hide();
                    jQuery('.ld-peronal-details').show();
                    jQuery('.login_unsuccessfull').hide();
                    jQuery('.ld-new-user-details').hide();
                    jQuery('.ld-sub').hide();

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
            }
        });
    }
});

jQuery(document).on('click', ".cart_toggle_head", function() {
    var id = jQuery(this).data('id');
    jQuery('.cart_toggle_head').each(function() {
        var nID = jQuery(this).data('id');
        if (nID == id) {
            if (jQuery('.ct_icon_check_' + nID).hasClass('fa-plus')) {
                jQuery('.ct_icon_check_' + nID).removeClass('fa-plus');
                jQuery('.ct_icon_check_' + nID).addClass('fa-minus');
                jQuery("#cart_toggle_content_" + nID).slideToggle();
            } else {
                jQuery('.ct_icon_check_' + nID).addClass('fa-plus');
                jQuery('.ct_icon_check_' + nID).removeClass('fa-minus');
                jQuery("#cart_toggle_content_" + nID).slideUp();
            }
        } else {
            jQuery('.ct_icon_check_' + nID).addClass('fa-plus');
            jQuery('.ct_icon_check_' + nID).removeClass('fa-minus');
            jQuery("#cart_toggle_content_" + nID).slideUp();
        }
    });
});

/* jQuery(document).on("click", ".provider_select", function () {
    jQuery(".ct-loading-main").show();
    var site_url = siteurlObj.site_url;
    var ajax_url = ajaxurlObj.ajax_url;
    var staff_id = jQuery(this).attr("data-id");
    jQuery.ajax({
      type: "post",
      data: { "staff_id": staff_id, "get_staff_sess": 1 },
      url: site_url + "front/firststep.php",
      success: function (res) {
        jQuery.ajax({
          type: "POST",
          url: ajax_url + "calendar_ajax.php",
          data: { "get_calendar_on_page_load": 1 },
          success: function (res) {
            jQuery(".cal_info").html(res);
            var d = new Date();
            var month = d.getMonth() + 1;
            var day = d.getDate();
            var year = d.getFullYear();
            var output = day + "-" + (month < 10 ? "0" : "") + month + "-" + year;
            var selected_dates = jQuery(".selected_date").data("selected_dates");
            var cur_dates = jQuery(".selected_date").attr("data-cur_dates");
            jQuery(".hidedatetime_value").hide();
            jQuery(".cart_date").attr("data-date_val", "");
            jQuery(".cart_date").html("");
            jQuery(".space_between_date_time").hide();
            jQuery(".cart_time").attr("data-time_val", "");
            jQuery(".cart_time").html("");
            jQuery(".ct-loading-main").hide();
            if (output == cur_dates) {
              jQuery(".by_default_today_selected").addClass("active_today");
            }
          }
        });
      }
    });
    jQuery("#ct-provider-" + staff_id).prop("checked", true);
    return false;
  }); */