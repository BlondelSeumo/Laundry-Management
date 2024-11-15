<?php  

include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/admin_session_check.php');
include(dirname(dirname(__FILE__)) . "/objects/class_userdetails.php");
$con = new laundry_db();
$conn = $con->connect();
$objuserdetails = new laundry_userdetails();
$objuserdetails->conn = $conn;
?>
    <div id="lda-user-profile">
        <div class="panel-body">
            <div class="tab-content">
                <form novalidate="novalidate" id="user_info_form">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <?php 
                        /* SET SESSION VALUE HERE IN HARD CODED VALUE OF USERid FROM 1 TO SESSION id */
                        $objuserdetails->id = $_SESSION['ld_login_user_id'];
                        $userinfo = $objuserdetails->readone();
                        ?>
                    </div>
                    <div class="col-lg-8 col-md-8 col-xs-12 np">
                        <h4 class="header4"><?php echo filter_var($label_language_values['personal_information']);	?></h4>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="firstname"><?php echo filter_var($label_language_values['first_name']);	?></label>
                            <input class="form-control" name="userfirstname" id="userfirstname" value="<?php  echo filter_var($userinfo[3]);	?>" type="text">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="lastname"><?php echo filter_var($label_language_values['last_name']);	?></label>
                            <input class="form-control" name="userlastname" id="userlastname" value="<?php  echo filter_var($userinfo[4]);	?>" type="text">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="inputEmail"><?php echo filter_var($label_language_values['email']);	?></label>
                            <span class="form-control"><?php  echo filter_var($userinfo[1]);	?></span>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="admin-phone-number"><?php echo filter_var($label_language_values['phone']);	?></label>
                            <input type="tel" class="form-control phone_number" name="userphone" id="userphone" value="<?php  echo filter_var($userinfo[5]);	?>" />
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="admin-address"><?php echo filter_var($label_language_values['address']);	?></label>
                            <input class="form-control" id="useraddress" name="useraddress" value="<?php  echo filter_var($userinfo[7]);	?>" />
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="city"><?php echo filter_var($label_language_values['city']);	?></label>
                            <input class="form-control value_city" id="usercity" name="usercity" placeholder="<?php echo filter_var($label_language_values['city']);	?>" value="<?php  echo filter_var($userinfo[8]);	?>" type="text">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="state"><?php echo filter_var($label_language_values['state']);	?></label>
                            <input class="form-control value_state" id="userstate" name="userstate" placeholder="<?php echo filter_var($label_language_values['state']);	?>" value="<?php  echo filter_var($userinfo[9]);	?>" type="text">
                        </div>
						<?php  if($setting->get_option('ld_user_zip_code') == 'Y'){?>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="zip"><?php echo filter_var($label_language_values['zip']);	?></label>
                            <input class="form-control value_zip" id="userzip" name="userzip" placeholder="<?php echo filter_var($label_language_values['zip']);	?>" value="<?php  echo filter_var($userinfo[6]);	?>" type="text">
                        </div>
						<?php  } ?>
                        <div class="form-group">
                            <a href="javascript:void(0)" id="btn-change-pass" class="btn btn-link"><?php echo filter_var($label_language_values['change_password']);	?></a>
                        </div>
                        <div class="ld-change-password hide-div">
                            <div class="form-group">
                                <label for="useroldpass"><?php echo filter_var($label_language_values['old_password']);	?></label>
                                <input name="userdboldpass" value="<?php echo filter_var($userinfo[2]);	?>" class="form-control" id="userdboldpass" type="hidden">
                                <input name="useroldpass" class="form-control u_op" id="useroldpass" type="password">
                                <label id="msg_oldps" class="old_pass_msg"></label>
                            </div>
                            <div class="form-group">
                                <label for="usernewpasswrd"><?php echo filter_var($label_language_values['new_password']);	?></label>
                                <input name="usernewpasswrd" class="form-control" id="usernewpasswrd" type="password">
                            </div>
                            <div class="form-group">
                                <label for="userrenewpasswrd"><?php echo filter_var($label_language_values['retype_new_password']);	?></label>
                                <input name="userrenewpasswrd" class="form-control u_rp" id="userrenewpasswrd" type="password">
                                <label id="msg_retype" class="retype_pass_msg"></label>
                            </div>
                        </div>
                        <div class="form-group cb">
                            
                            <a href="javascript:void(0)" data-zip="<?php echo filter_var($setting->get_option('ld_user_zip_code'));	?>" data-id="<?php echo filter_var($_SESSION['ld_login_user_id']); ?>" class="btn btn-success ld-btn-width mybtnuserprofile_save"><?php echo filter_var($label_language_values['save']);	?></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php 
include(dirname(__FILE__).'/footer.php');
?>