<?php      
ob_start();

$filename =  './config.php';

$file = file_exists($filename);

if($file){

	if(filesize($filename) > 0){

		header('location:index.php');

	}

}else{

	echo "file not exist";

}

include "header.php";
?>
<!Doctype html>
	<head>
		<title>Laundry Script Installer</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="assets/css/ld-installer.css" type="text/css" media="all" />
		<link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css" type="text/css" media="all" />
		<link rel="stylesheet" href="assets/css/bootstrap/bootstrap-theme.min.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/font-awesome/css/font-awesome.min.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/tooltipster.bundle.min.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/css/tooltipster-sideTip-shadow.min.css" type="text/css" media="all" />
		
		<script src="assets/js/jquery-2.1.4.min.js" type="text/javascript"></script>
		<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="assets/js/ld-installer-jquery.js" type="text/javascript"></script>
		<script src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/tooltipster.bundle.min.js" type="text/javascript"></script>
		<script src="<?php  echo filter_var(SITE_URL, FILTER_VALIDATE_URL); ?>/assets/js/jquery.validate.min.js"></script>

		<style> .error{ color:red; } </style>
	</head>
	<body>
		<div class="ldi-wrapper" id="ldi"> 
			<div class="ldi-main-wrapper">
				<div class="container">
					<div class="ldi-inner">
						<div id="laundry-installer">
							<h4>Laundry Script Installer<div class="pull-right">Version 2.0</div></h4>
							<div class="col-md-12 col-sm-12 col-lg-12 np total_text">
								<div class="text_changed"> 
									<div id="sidebar" class="col-md-4 col-sm-4 col-lg-4 np">
										<div class="ldi-progress">
											<ul class="left-menu">
												<li class="active completed">1. Start</li>
												<li>2. Server Requirements</li>
												<li>3. Database Information</li>
												<li>4. Admin Information</li>
												<li>5. Completed</li>
											</ul>
										</div>
									</div>
									<div id="ldi-content" class="col-md-8 col-sm-8 col-lg-8">
										<div class="ldi-progress-bar">Step <b>1</b> out of 5 - Start</div>
										<div class="ldi-info">
											<img src="assets/images/laundry-logo-new.png" height="40%" width="40%">
										</div>
										<div class="radio">
										  <label><input type="radio" name="optradio" value='u'>Update</label>
										</div>
										<div class="radio">
										  <label><input type="radio" name="optradio" checked='checked' value='f'>Fresh Install</label>
										</div>
										
										<br/><br/>
										<a href="javascript:void(0)" class="btn btn-primary installer_t_c_submit" id="first_next">Start Install <i class="fa  fa-angle-double-right"></i></a>
										<br/><br/>
										<div class='alert alert-danger text-left' id="overall_errors" style="display:none;">
										Sorry please accept term and condition
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>	
<script type="text/javascript">
	var obj_installer = {'ajax_url':'<?php  echo filter_var(AJAX_URL, FILTER_VALIDATE_URL);?>','site_url':'<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL);?>'};
</script>