jQuery(document).ready(function () {
    jQuery("#show-pass").click(function () {
        if (jQuery(".showpassword").attr("type")=="password") {
            jQuery(".showpassword").attr("type", "text");
        }
        else{
            jQuery(".showpassword").attr("type", "password");
        }
    });
    jQuery('.login-error').hide();
    jQuery('#show-pass').click(function(){
        if(jQuery("#show-pass").is(":checked")) {
            jQuery('.icon-lock').addClass('icon-unlock');
            jQuery('.icon-unlock').removeClass('icon-lock');
        } else {
            jQuery('.icon-unlock').addClass('icon-lock');
            jQuery('.icon-lock').removeClass('icon-unlock');
        }
    });
    jQuery('#ld_forget_password').click(function(){
        /* jQuery('.ld-main-login').addClass('hide-data'); */
        jQuery('.login-error').hide();
        jQuery('.forgotpassword-error').hide();
        jQuery('.forget_pass_incorrect').text("");
        jQuery('.forget_pass_correct').text("");
        jQuery('.ld-main-forget-password').removeClass('hide-data');
        jQuery('.ld-main-forget-password').addClass('show-data');
    });
    jQuery('#ld_login_user').click(function(){
        jQuery('.login-error').hide();
        jQuery('#login-form').show();
        jQuery('#forget_pass').hide();
        jQuery('.forgotpassword-error').hide();
        jQuery('.forget_pass_incorrect').text("");
        jQuery('.forget_pass_correct').text("");
        jQuery('.ld-main-forget-password').removeClass('show-data');
        jQuery('.ld-main-forget-password').addClass('hide-data');
        jQuery('.ld-main-login').addClass('show-data');
        jQuery('.ld-main-login').removeClass('hide-data');
    });
      /* login check */
    jQuery(document).on('click','.mybtnloginadmin',function(){
        var name = jQuery('#userEmail').val();
        var password = jQuery('#userPassword').val();
        var remember;
        if(jQuery('#remember_me').prop("checked")){
            remember = true;
        }
        else{
            remember = false;
        }
        jQuery('.login-error').hide();
        jQuery.ajax({
            type : 'post',
            data : {
                name : name,
                password : password,
                remember : remember,
                checkadmin : 1
            },
            url : ajax_url+"admin_login_ajax.php",
            success : function(res){
                
                if(res.trim() == "yesuser"){
                    /* alert(1); */
                   window.location.replace(base_url+"admin/my-appointments.php");
                }
                else if(res.trim() == "yesadmin"){
                    /* alert(2); */
                    window.location.replace(base_url+"admin/calendar.php");
                }else if(res.trim() == "yesstaff"){
                    /* alert(3); */
					window.location.replace(base_url+"staff/staff-dashboard.php");
				}
                else
                {
                    /* return false; */
                    jQuery('.login-error').show();
                }
            }
        });
    });
    /*Reset Password*/
    jQuery(document).on('click','#reset_pass',function(){				       
	var email=jQuery('#rp_user_email').val();
        var dataString={email:email,action:"forget_password"};
        if(jQuery('#forget_pass').valid()){
            jQuery.ajax({
                type:"POST",
                url:ajax_url+"admin_login_ajax.php",
                data:dataString,
                success:function(response){
                    if(response=='not'){
						jQuery('.forget_pass_correct').hide();
                        jQuery('.forget_pass_incorrect').css('display','block');
                        jQuery('.forget_pass_incorrect').css('color','red');
						jQuery('.forget_pass_incorrect').html(errorobj_invalid_email_id_please_register_first);
                    }
                    else{
						jQuery('.forget_pass_incorrect').hide();
                        jQuery('.forget_pass_correct').css('display','block');
                        jQuery('.forget_pass_correct').css('color','green');
                        jQuery('.forget_pass_correct').html(errorobj_your_password_send_successfully_at_your_email_id);																		
						jQuery('#reset_pass').css({"pointer-events": "none", "cursor": "default"});
						jQuery('#reset_pass').unbind('click');
						setTimeout(function() { window.location.href = base_url;  },5000);
						event.preventDefault();		
                    }
                }
            });
        }
    });
    /* validation for reset_password.php */
    jQuery(document).ready(function(e)  {
        jQuery('#forget_pass').submit(function(event){
            event.preventDefault();
            event.stopImmediatePropagation();
        });
        jQuery("#forget_pass").validate({
            rules: {
                rp_user_email: {
                    required: true,
                    email: true
                }
            },
            messages:{
                rp_user_email: {
                    required : errorobj_please_enter_email_address,
                    email : errorobj_please_enter_valid_email_address
                }
            }
        });
    });
    /* validation for reset_new_password.php */
    jQuery(document).ready(function()  {
        jQuery('#reset_new_passwd').submit(function(event){
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
            messages:{
                n_password: {
                    required : errorobj_please_enter_new_password,
                    minlength: errorobj_password_at_least_have_8_characters,
                    maxlength: errorobj_password_must_be_only_10_characters
                },
                rn_password: {
                    required: errorobj_please_enter_retype_new_password,
                    minlength: errorobj_password_at_least_have_8_characters,
                    maxlength: errorobj_password_must_be_only_10_characters
                }
            }
        });
    });
    jQuery(document).on('click','#rn_password',function(){
        jQuery('.mismatch_password').hide();
    });
    jQuery(document).on('click','#n_password',function(){
        jQuery('.mismatch_password').hide();
    });
    jQuery(document).on('click','#password',function(){
        jQuery('.succ_password').hide();
    });
    jQuery(document).on('click','#email',function(){
        jQuery('.succ_password').hide();
    });
    /*Reset New Password*/
    jQuery(document).on('click','#reset_new_password',function(){
        var new_reset_pass=jQuery('#n_password').val();
        var retype_new_reset_pass=jQuery('#rn_password').val();
        var dataString={retype_new_reset_pass:retype_new_reset_pass,action:"reset_new_password"};
        if(jQuery('#reset_new_passwd').valid()){
            if(new_reset_pass == retype_new_reset_pass){
                jQuery.ajax({
                    type:"POST",
                    url:ajax_url+"admin_login_ajax.php",
                    data:dataString,
                    success:function(response){
                        if(response=='password reset successfully'){
                            jQuery('.succ_password').css('display','block');
                            jQuery('.succ_password').addClass('txt-success');
                            jQuery('.succ_password').html(errorobj_your_password_reset_successfully_please_login);
                            window.location = base_url+"/admin";
                        }
                    }
                });
            }else{
                jQuery('.mismatch_password').css('display','block');
                jQuery('.mismatch_password').addClass('error');
                jQuery('.mismatch_password').html(errorobj_new_password_and_retype_new_password_mismatch);
            }
        }
    });
    jQuery(document).on("click", "#ld_staff_register", function () {
        var fullname=jQuery("#staff_name").val();
        var email=jQuery("#staff_email").val();
        var pass=jQuery("#staff_pass").val();
        /* var service_ids=jQuery("#get_service_data").val(); */
      jQuery.ajax({
        type: "post",
        data: { "fullname":fullname,"email":email,"pass":pass,action:"staff_reg" },
        url: ajax_url + "admin_login_ajax.php",
        success: function (res) {
            
           /*  alert(res); */
          /* jQuery(".ct-loading-main").hide();
          jQuery("#register-meesg").css('display','block');
           setTimeout(function() {
			    location.reload();
			}, 5000); */
          }
        }); 
           
    });
});