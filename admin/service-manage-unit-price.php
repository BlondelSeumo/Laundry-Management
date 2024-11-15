<?php  
include(dirname(__FILE__).'/header.php');
include(dirname(dirname(__FILE__)) . "/objects/class_services.php");
include(dirname(dirname(__FILE__)) . "/objects/class_services_methods_units.php");
include(dirname(__FILE__).'/user_session_check.php');
$con = new laundry_db();
$conn = $con->connect();
$objservice_m_unit = new laundry_services_methods_units();
$objservice_m_unit->conn = $conn;

$objservice = new laundry_services();
$objservice->conn = $conn;
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
			
			<div class="ld-clean-service-top-header">
				<span class="ld-clean-service-service-name pull-left mymethodtitleforunit"></span>
				
				<?php       
				$all_services = $objservice->getalldata();
				if(mysqli_num_rows($all_services) > 0){
				?>
				<div class="lda-unit-button-top">
					<ul class="nav navbar-nav lda-nav-tab lda-col12 services_for_articles">
						<?php         
						while($row = mysqli_fetch_assoc($all_services)){
							$id = $row["id"];
							$title = $row["title"];
							$image = "";
							if ($row['image'] == '') {
                                $image = 'default_service.png';
                            } else {
                                $image = $row['image'];
                            }
						?>
						<li class="ld-lg-2 service_set_session" data-service_id="<?php      echo filter_var($id); ?>">
							
								<img class="ld-image service-img" src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>assets/images/services/<?php  echo filter_var($image); ?>"/>
								<div class="btn service-title">
									<?php      echo filter_var($title); ?>
								</div>
							
						</li>
						<?php       } ?>
					</ul>
				</div>
				<?php       } ?>
				<div class="pull-right lda-unit-button-top">
					<table>
						<tbody>
							<tr>
								<td>
									<button id="ld-add-new-price-unit" class="btn btn-success" value="add new service"><i class="fa fa-plus"></i><?php echo filter_var($label_language_values['add_new']);	?></button>
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
						<ul class="nav nav-tab nav-stacked myservice_method_unitload" id="sortable-services-unit" > 
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
    var link_url = '<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL).'admin/';	?>';
</script>