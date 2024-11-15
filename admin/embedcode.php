<?php  

include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/user_session_check.php');
include(dirname(dirname(__FILE__)) . "/objects/class_adminprofile.php");
$con = new laundry_db();
$conn = $con->connect();
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
    </script>
<?php 
 $ld_cart_scrollable =  $setting->get_option('ld_cart_scrollable');

$userembeddcode ='<div id="laundry" class="direct-load" data-url="'.SITE_URL.'"></div><script src="'.SITE_URL.'assets/js/jquery-2.1.4.min.js" type="text/javascript"></script><script src="'.SITE_URL.'assets/js/embed.js?time='.time().'" type="text/javascript" ></script>';
?>
    <div id="lda-profile" class="panel tab-content">
        <div class="panel-body">
            <div class="ld-admin-profile-details tab-content col-md-9 col-sm-9 col-lg-9 col-xs-12">
                <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 ">
                    <h4 class="header4"><?php echo filter_var($label_language_values['get_embed_code_to_show_booking_widget_on_your_website']);	?></h4>
                   
                    <div class="lda-embed-button cb">
                        <form class="form-horizontal">
                            <ol class="ld-embed-code">
                                <li class="embed-code-li necessary_option_check">
                                    <span class="ld-embed-count"><?php echo filter_var($label_language_values['please_set_below_values']);	?></span>
                                    <div class="ld-embed-code">
                                        <div class="check_options_left_toset">
                                            
                                            
                                        </div>
                                    </div>
                                </li>
                                <li class="embed-code-li all_ok">
                                    <span class="ld-embed-count"><?php echo filter_var($label_language_values['0_1']);	?></span>
                                    <?php  echo filter_var($label_language_values['widget_loading_style']);	?>
                                    <div class="ld-embed-code">
                                        <div class="ld-custom-new-radio">
                                            <ul class="ld-new-radio-list np">
                                                <li>
                                                    <input id="show-on-page-load" class="ld-radio ad_button_type" name="second-widget-loading" value="show_on_page_load" checked="checked" type="radio">
                                                    <label for="show-on-page-load"><span></span>  <?php  echo filter_var($label_language_values['show_on_page_load']);	?></label>
                                                </li>
                                                <li>
                                                    <input id="show-on-btnclick" class="ld-radio ad_button_type" name="second-widget-loading" value="on_btn_click" type="radio">
                                                    <label for="show-on-btnclick"><span></span><?php echo filter_var($label_language_values['show_on_a_button_click']);	?></label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="show-on-btn-click" id="button-click-content">
                                        <ol class="ld-embed-code second-child-ol">
                                            <li class="embed-code-li">
                                                <span class="ld-embed-count"><?php echo filter_var($label_language_values['1_1']);	?></span>
                                                <?php  echo filter_var($label_language_values['button_position']);	?>
                                                <div class="ld-embed-code">
                                                    <div class="ld-custom-new-radio">
                                                        <ul class="ld-new-radio-list np">
                                                            <li>
                                                                <input id="show-embed-position" class="ld-radio ad_button_type" name="third-button-position" value="" checked="checked" type="radio">
                                                                <label for="show-embed-position"><span></span>
                                                                    <?php  echo filter_var($label_language_values['show_button_on_given_embeded_position']);	?></label>
                                                            </li>
                                                      
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="ld-embed-code col-md-12">
                                                    <label><?php echo filter_var($label_language_values['online_booking_button_style']);	?> </label>
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <h5 class="header5 mt-20"><?php echo filter_var($label_language_values['background_color']);	?></h5>
                                                        <input type="text" value="<?php echo filter_var($setting->get_option('ld_secondary_color_admin'));	?>" name="ld_bookbtn_bg_color" id="ld-bookbtn-bg-color" class="form-control demo" data-control="saturation" value="" />
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <h5 class="header5 mt-20"><?php echo filter_var($label_language_values['text_color']);	?></h5>
                                                        <input type="text" value="<?php echo filter_var($setting->get_option('ld_text_color_admin'));	?>" name="ld_bookbtn_text_color" id="ld-bookingtxt-color" class="form-control demo ld-bookbtn-text-color" data-control="saturation" value="" />
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <h5 class="header5 mt-20"><?php echo filter_var($label_language_values['button_text']);	?></h5>
                                                        <input id="lda-step3" class="form-control" placeholder="Book Now" type="text">
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <h5 class="header5 mt-20"><?php echo filter_var($label_language_values['button_preview']);	?></h5>
                                                        <a class="btn buttonpreview" id="buttonpreview" style="background-color: <?php  echo  filter_var($setting->get_option('ld_secondary_color_admin'));	?>;color: <?php  echo filter_var($setting->get_option('ld_text_color_admin'));	?>;"><?php echo filter_var($label_language_values['book_now']);	?></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <script>
                                                var tmpembedbackground = '<?php echo filter_var($setting->get_option('ld_secondary_color_admin'));	?>';
                                                var tmpembedcolor = '<?php echo filter_var($setting->get_option('ld_text_color_admin'));	?>';
                                                var tmpembedbuttontxt = "Book Now";
                                                var tmpembedClassname = "button-new";
                                                var encryptedbid = 1;
												var jquery_url = "<script type=text/javascript src=<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL) ?>assets/js/jquery-2.1.4.min.js>";
                                                var url = "<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL)."assets/js/embed.js?time=".time();	?>";
                                                var sites_urls = "<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>";
                                                jQuery(document).on('click','#show-on-btnclick',function(){
                                                    jQuery('#lda-user-embedd-code').html('&#x3C;a id=&#x22;laundry&#x22; data-url=\"'+sites_urls+'\"style=\&#x22;background:'+tmpembedbackground+';color:'+tmpembedcolor+'\&#x22;   class=\&#x22;'+tmpembedClassname+'\&#x22;&#x3E;'+tmpembedbuttontxt+'&#x3C;/a&#x3E;&#x3C;script src=\&#x22;'+url+'\&#x22; id=\&#x22;'+encryptedbid+'\&#x22; type=\&#x22;text/javascript\&#x22; &#x3E;&#x3C;/script&#x3E;');
                                                });
                                                jQuery(document).on('blur','#ld-bookbtn-bg-color',function(){
                                                    jQuery("#buttonpreview").css('background-color', jQuery('#ld-bookbtn-bg-color').val());
                                                    tmpembedbackground = jQuery('#ld-bookbtn-bg-color').val();
                                                    jQuery('#show-on-btnclick').trigger("click");
                                                });
                                                jQuery(document).on('blur','#ld-bookingtxt-color',function(){
                                                    jQuery("#buttonpreview").css('color', jQuery('#ld-bookingtxt-color').val());
                                                    tmpembedcolor = jQuery('#ld-bookingtxt-color').val();
                                                    jQuery('#show-on-btnclick').trigger("click");
                                                });
                                                jQuery(document).on('keyup','#lda-step3',function(){
                                                    jQuery("#buttonpreview").html( jQuery('#lda-step3').val());
                                                    tmpembedbuttontxt = jQuery('#lda-step3').val();
                                                    jQuery('#show-on-btnclick').trigger("click");
                                                });
                                                jQuery(document).on('click','#scroll-btn-to-website',function(){
                                                    if(jQuery(this).is(':checked')) {
                                                        tmpembedClassname = 'side-button-new';
                                                        jQuery('#show-on-btnclick').trigger("click");
                                                    }
                                                });
                                                jQuery(document).on('click','#show-embed-position',function(){
                                                    if(jQuery(this).is(':checked')) {
                                                        tmpembedClassname = 'button-new';
                                                        jQuery('#show-on-btnclick').trigger("click");
                                                    }
                                                });
                                                jQuery(document).on('click','#new-window-tab',function(){
                                                    if(jQuery(this).is(':checked')) {
                                                        tmpembedClassname = 'button-new';
                                                        jQuery('#show-on-btnclick').trigger("click");
                                                    }
                                                });
                                                jQuery(document).on('click','#show-popup-widget',function(){
                                                    if(jQuery(this).is(':checked')) {
                                                        tmpembedClassname = 'button-pop';
                                                        jQuery('#show-on-btnclick').trigger("click");
                                                    }
                                                });
                                                jQuery(document).on('click','#show-on-page-load',function(){
                                                    jQuery('#lda-user-embedd-code').html('&#x3C;div id=&#x22;laundry&#x22; data-url=\"'+sites_urls+'\" class=\&#x22;direct-load&#x22;&#x3E;&#x3C;/div&#x3E;&#x3C;script src=\"'+sites_urls+'assets/js/jquery-2.1.4.min.js\" type=\"text/javascript\"&#x3E;&#x3C;/script&#x3E;&#x3C;script src=\&#x22;'+url+'\&#x22; type=\&#x22;text/javascript\&#x22; &#x3E;&#x3C;/script&#x3E;');
                                                });
                                            </script>
                                            <li class="embed-code-li">
                                                <span class="ld-embed-count"><?php echo filter_var($label_language_values['1_2']);	?></span>
                                                <?php  echo filter_var($label_language_values['behaviour_on_click_of_button']);	?>
                                                <div class="ld-embed-code">
                                                    <div class="ld-custom-new-radio">
                                                        <ul class="ld-new-radio-list np">
                                                            <li>
                                                                <input id="new-window-tab" class="ld-radio ad_button_type" name="fourth-on-click-button" value="" checked="checked" type="radio">
                                                                <label for="new-window-tab"><span></span>
                                                                    <?php  echo filter_var($label_language_values['open_widget_in_a_new_page']);	?></label>
                                                            </li>
                                                      
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ol>
                                    </div>
                                </li>
                                <li class="embed-code-li  all_ok">
                                    <span class="ld-embed-count"><?php echo filter_var($label_language_values['0_2']);	?></span>
                                    <?php  echo filter_var($label_language_values['get_the_embeded_code']);	?>
                                    <div class="ld-embed-code">
                                        <textarea class="form-control lda-user-embedd-code" readonly="" id="lda-user-embedd-code" rows="6"><?php echo htmlspecialchars_decode($userembeddcode); ?></textarea>
                                        <div class="ld-embed-code-help"><?php echo filter_var($label_language_values['please_copy_above_code_and_paste_in_your_website']);	?></div>
                                    </div>
                                </li>
                            </ol>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
include(dirname(__FILE__).'/footer.php');
?>