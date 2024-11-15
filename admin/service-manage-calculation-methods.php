<?php  

include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/user_session_check.php');
?>
<script>
    function goBack() {
        window.history.back();
    }
</script>
<link rel="stylesheet" href="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/css/bootstrap-toggle.min.css" type="text/css" media="all">
<script src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/js/bootstrap-toggle.min.js" type="text/javascript" ></script>
<div id="lda-clean-services-panel" class="panel tab-content">
    <div class="panel-body">
        <div class="ld-clean-service-details tab-content col-md-12 col-sm-12 col-lg-12 col-xs-12">
            <ul class="breadcrumb">
                <li><a href="services.php" style="cursor:pointer" class="myservicetitleformethod"></a></li>
                <li><a href="#" class=""><?php echo filter_var($label_language_values['price_calculation_method']);	?></a></li>
            </ul>
            
            <div class="ld-clean-service-top-header">
                <span class="ld-clean-service-service-name pull-left"><i class="myservicetitleformethod"></i> - <?php  echo filter_var($label_language_values['price_calculation_method']);	?></span>
                <input type="hidden" class="myhiddenserviceid" value="">
                <div class="pull-right">
                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <button id="ld-add-new-price-method" class="btn btn-success" value="add new service"><i class="fa fa-plus"></i><?php echo filter_var($label_language_values['add_method']);	?></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="hr"></div>
            <div class="tab-pane active">
                <div class="tab-content ld-clean-services-right-details">
                    <div class="tab-pane active col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="accordion" class="panel-group">
                            <ul class="nav nav-tab nav-stacked myservicemethodload" id="sortable-services-methods" > 
                            </ul>
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
</script>