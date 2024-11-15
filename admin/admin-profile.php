<?php  

include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/user_session_check.php');
include(dirname(dirname(__FILE__)) . "/objects/class_adminprofile.php");
$con = new laundry_db();
$conn = $con->connect();
$objadminprofile = new laundry_adminprofile();
$objadminprofile->conn = $conn;
?>
    <script type="text/javascript">
        var ajax_url = '<?php echo filter_var(AJAX_URL, FILTER_VALIDATE_URL);	?>';
        var base_url = '<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>';
        var profile_site_url = {'prof_site_url':'<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>'};
    </script>
    <script>
        jQuery(document).on('change','input[name="second-widget-loading"]', function(){
            if(jQuery(this).val()=='on_btn_click'){
                jQuery('#button-click-content').show( "slide", {direction: "up" }, 1000 );
            }else{
                jQuery('#button-click-content').hide( "slide", {direction: "up" }, 500  );
            }
        });
        /* admin profile */
        jQuery(document).ready(function () {
            jQuery("#btn-change-pass").click(function () {
                jQuery(".ld-change-password").show( "blind", {direction: "vertical"}, 1000 );
                jQuery("#btn-change-pass").hide();
            });
        });
        /* phone number */
        jQuery(document).bind('ready ajaxComplete',function() {
            jQuery(".phone_number").intlTelInput({
                autoPlaceholder: false,
                utilsScript: "../assets/js/utils.js"
            });
        });
    </script>
<?php 
$userembeddcode ='<div id="laundry-booking" class="direct-load"></div><script src="'.SITE_URL.'" id="1" type="text/javascript" ></script>';
?>
    <div id="lda-profile" class="panel tab-content">
        <div class="ld-admin-staff ld-left-menu col-md-3 col-sm-3 col-xs-12 col-lg-3">
            <ul class="nav nav-tab nav-stacked">
                <li class="active"><a data-toggle="tab" href="#personal-info-tab"><i class="fa fa-user fa-2x"></i><br /><?php echo filter_var($label_language_values['personal_information']);	?></a></li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="ld-admin-profile-details tab-content col-md-9 col-sm-9 col-lg-9 col-xs-12">
                
                <div id="personal-info-tab" class="col-lg-10 col-md-10 col-sm-10 col-xs-12 tab-pane fade active in">
                    <?php 
                    $objadminprofile->id = $_SESSION['ld_adminid'];
                    $admininfo = $objadminprofile->readone();
					?>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <h4 class="header4"><?php echo filter_var($label_language_values['personal_information']);	?></h4>
                        <form novalidate="novalidate" id="admin_info_form">
                            <div class="form-group">
                                <label for="fullname"><?php echo filter_var($label_language_values['full_name']);	?></label>
                                <input class="form-control" name="fullnamess" id="adminfullname" value="<?php  echo filter_var($admininfo[3]);	?>" type="text">
                            </div>
                           <div class="form-group">
                                <label for="inputEmail"><?php echo filter_var($label_language_values['email']);	?></label>
                                <input class="form-control admin_inputEmail" name="fullemail" id="inputEmail" value="<?php  echo filter_var($admininfo[2]);	?>" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control admin_inputEmail_old" name="fullemailold" id="inputEmailold" value="<?php  echo filter_var($admininfo[2]);	?>" type="hidden">
                            </div>
                            <div class="form-group">
                                <label for="admin-phone-number"><?php echo filter_var($label_language_values['phone']);	?></label>
                                <input type="tel"  class="form-control" name="adminphoness" id="adminphone" value="<?php  echo filter_var($admininfo[4]);	?>" />
                            </div>
                            <div class="form-group">
                                <label for="admin-address"><?php echo filter_var($label_language_values['admin_profile_address']);	?></label>
                                <textarea class="form-control" id="adminaddress" name="adminaddressss" cols="6"><?php  echo filter_var($admininfo[5]);	?></textarea>
                            </div>
                            <div class="form-group fl w100">
                                <div class="lda-col6 ld-w-50 mb-6">
                                    <label for="city"><?php echo filter_var($label_language_values['city']);	?></label>
                                    <input class="form-control value_city" id="admincity" name="cityss" placeholder="<?php echo filter_var($label_language_values['city']);	?>" value="<?php  echo filter_var($admininfo[6]);	?>" type="text">
                                </div>
                                <div class="lda-col6 ld-w-50 mb-6 float-right">
                                    <label for="state"><?php echo filter_var($label_language_values['state']);	?></label>
                                    <input class="form-control value_state" id="adminstate" name="state" placeholder="<?php echo filter_var($label_language_values['state']);	?>" value="<?php  echo filter_var($admininfo[7]);	?>" type="text">
                                </div>
                            </div>
                            <div class="form-group fl w100">
                                <div class="lda-col6 ld-w-50 mb-6">
                                    <label for="zip"><?php echo filter_var($label_language_values['zip']);	?></label>
                                    <input class="form-control value_zip" id="adminzip" name="zipss" placeholder="<?php echo filter_var($label_language_values['zip']);	?>" value="<?php  echo filter_var($admininfo[8]);	?>" type="text">
                                </div>
                                <div class="lda-col6 ld-w-50 mb-6 float-right">
                                    <label for="country"><?php echo filter_var($label_language_values['country']);	?></label>
                                    <input class="form-control value_country" id="admincountry" name="countryss" placeholder="<?php echo filter_var($label_language_values['country']);	?>" value="<?php  echo filter_var($admininfo[9]);	?>" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="javascript:void(0)" id="btn-change-pass" class="btn btn-link"><?php echo filter_var($label_language_values['change_password']);	?></a>
                            </div>
                            <div class="ld-change-password hide-div">
                                <div class="form-group cb">
                                    <label for="oldpass"><?php echo filter_var($label_language_values['old_password']);	?></label>
                                    <input name="dboldpass" value="<?php echo filter_var($admininfo[1]);	?>" class="form-control" id="dboldpass" type="hidden">
                                    <input name="oldpass" class="form-control u_op" id="oldpass" type="password">
                                    <label id="msg_oldps" class="old_pass_msg" style="display: none;"></label>
                                </div>
                                <div class="form-group">
                                    <label for="newpass"><?php echo filter_var($label_language_values['new_password']);	?></label>
                                    <input name="newpasswrd" class="form-control" id="newpass" type="password">
                                </div>
                                <div class="form-group">
                                    <label for="retypenewpass"><?php echo filter_var($label_language_values['retype_new_password']);	?></label>
                                    <input name="renewpasswrd" class="form-control u_rp" id="retypenewpass" type="password">
                                    <label id="msg_retype" class="retype_pass_msg"></label>
                                </div>
                            </div>
                            <div class="form-group cb">
                                <a href="javascript:void(0)" data-id="<?php echo filter_var($_SESSION['ld_adminid']);	?>" id="" class="btn btn-success ld-btn-width mybtnadminprofile_save"><?php echo filter_var($label_language_values['save']);	?></a>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
<?php 
include(dirname(__FILE__).'/footer.php');
?>