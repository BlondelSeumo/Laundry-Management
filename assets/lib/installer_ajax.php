<?php  

session_start();
include(dirname(dirname(dirname(__FILE__)))."/header.php");
include(dirname(dirname(dirname(__FILE__)))."/class_configure.php");
include(dirname(dirname(dirname(__FILE__)))."/config.php");
$configure = new laundry_configure();
?>
<script>
jQuery(document).ready(function() {
	jQuery('.cti-tooltip-link').tooltipster({
		animation: 'grow',
		delay: 20,
		theme: 'tooltipster-shadow',
		trigger: 'hover'
	});
});
</script>
<?php  
if(isset($_POST['t_c_check']) && filter_var($_POST['t_c_check']) == '1'){
$_SESSION['installer_mode'] = filter_var($_POST['installer_mode']);
?>
	<div id="sidebar" class="col-md-4 col-sm-4 col-lg-4 np">
		<div class="ldi-progress">
			<ul class="left-menu">
				<li>1. Start</li>
				<li class="active completed">2. Server Requirements</li>
				<li>3. Database Information</li>
				<li>4. Admin Information</li>
				<li>5. Completed</li>
			</ul>
		</div>
	</div>
	<div id="ldi-content" class="col-md-8 col-sm-8 col-lg-8">
		<div class="ldi-progress-bar">Step <b>2</b> out of 5 - Server Requirements</div>
		<table class="ldi-table" width="99%" cellspacing="2" cellpadding="0" border="0">
		<thead>
            <tr>
                <th> &nbsp; </th>
                <th> Server </th>
                <th> Current </th>
                <th> Status </th>
            </tr>
        </thead>
			<tbody>
				<tr class="active">
				<td>PHP Version</td>
				<td>5.3+</td>
				<td><span class="<?php echo (phpversion() >= '5.3') ? 'text-primary' : 'text-danger'; ?>"><strong><?php echo phpversion(); ?></strong></span></td>
			
				<td><span data-msg="Please update PHP version" class="sys_info <?php  echo (phpversion() >= '5.3') ? 'text-success' : 'text-danger'; ?>  strong"><i class="fa <?php  echo (phpversion() >= '5.3') ? 'fa-check-circle text-success' : 'fa-ban text-danger'; ?>"></i> <?php  echo (phpversion() >= '5.3') ? 'Passed' : 'Failed'; ?></span></td>
            </tr>
			<tr class="active">
				<td>Session Auto Start</td>
				<td>Off</td>
				<td>
					<span class="<?php echo (!ini_get('session_auto_start')) ? 'text-primary' : 'text-danger'; ?>"><strong><?php echo (ini_get('session_auto_start')) ? 'On' : 'Off'; ?></strong>
					</span>
				</td>
			
				<td><span data-msg="Please disable session auto start " class="sys_info <?php  echo (!ini_get('session_auto_start')) ? 'text-success' : 'text-danger'; ?> strong"><i class="fa <?php  echo (!ini_get('session_auto_start')) ? 'fa-check-circle text-success' : 'fa-ban text-danger'; ?>"></i> <?php  echo (!ini_get('session_auto_start')) ? 'Passed' : 'Failed'; ?></span></td>
            </tr>
			<tr class="active">
				<td>MySQLi </td>
				<td>On</td>
				<td>
					<span class="<?php echo extension_loaded('mysqli') ? 'text-primary' : 'text-danger'; ?>"><strong><?php echo extension_loaded('mysqli') ? 'On' : 'Off'; ?></strong></span>
				</td>
			
				<td><span data-msg="Please enable MySQLi " class="sys_info <?php  echo extension_loaded('mysqli') ? 'text-success' : 'text-danger'; ?> strong"><i class="fa <?php  echo extension_loaded('mysqli') ? 'fa-check-circle text-success' : 'fa-ban text-danger'; ?>"></i> <?php  echo extension_loaded('mysqli') ? 'Passed' : 'Failed'; ?></span></td>
            </tr>
			<tr class="active">
				<td>Zip </td>
				<td>On</td>
				<td>
					<span class="<?php echo extension_loaded('zip') ? 'text-primary' : 'text-danger'; ?>"><strong><?php echo extension_loaded('zip') ? 'On' : 'Off'; ?></strong></span>
				</td>
			
				<td><span data-msg="Please enable Zip" class="sys_info <?php  echo extension_loaded('zip') ? 'text-success' : 'text-danger'; ?> strong"><i class="fa <?php  echo extension_loaded('zip') ? 'fa-check-circle text-success' : 'fa-ban text-danger'; ?>"></i> <?php  echo extension_loaded('zip') ? 'Passed' : 'Failed'; ?></span></td>
            </tr>
			<tr class="active">
				<td>GD </td>
				<td>On</td>
				<td>
					<span class="<?php echo extension_loaded('gd') ? 'text-primary' : 'text-danger'; ?>"><strong><?php echo extension_loaded('gd') ? 'On' : 'Off'; ?></strong></span>
				</td>
			
				<td><span data-msg="Please enable GD " class="sys_info <?php  echo extension_loaded('gd') ? 'text-success' : 'text-danger'; ?> strong"><i class="fa <?php  echo extension_loaded('gd') ? 'fa-check-circle text-success' : 'fa-ban text-danger'; ?>"></i> <?php  echo extension_loaded('gd') ? 'Passed' : 'Failed'; ?></span></td>
            </tr>
			<tr class="active">
				<td>CURL</td>
				<td>Enable</td>
				<td>
					<span class="<?php echo (extension_loaded('curl') == 'true') ? 'text-primary' : 'text-danger'; ?>"><strong><?php echo (extension_loaded('curl') == 'true')  ? 'Enable' : 'Disable'; ?></strong></span>
				</td>
			
				<td><span data-msg="Please enable CURL "  class="sys_info <?php  echo (extension_loaded('curl') == 'true') ? 'text-success' : 'text-danger'; ?> strong"><i class="fa <?php  echo (extension_loaded('curl') == 'true') ? 'fa-check-circle text-success' : 'fa-ban text-danger'; ?>"></i> <?php  echo (extension_loaded('curl') == 'true') ? 'Passed' : 'Failed'; ?></span></td>
            </tr>
			<tr class="active">
				<td>config.php </td>
				<td>Writable</td>
				<td>
					<span class="<?php echo is_writable('./../../config.php') ? 'text-primary' : 'text-danger'; ?>"><strong><?php echo is_writable('./../../config.php') ? 'Writable' : 'Unwritable'; ?></strong></span>
				</td>
			
				<td><span data-msg="Please make config.php writable"  class="sys_info <?php  echo is_writable('./../../config.php') ? 'text-success' : 'text-danger'; ?> strong"><i class="fa <?php  echo is_writable('./../../config.php') ? 'fa-check-circle text-success' : 'fa-ban text-danger'; ?>"></i> <?php  echo is_writable('./../../config.php') ? 'Passed' : 'Failed'; ?></span></td>
            </tr>
			
			</tbody>
		</table>
		<?php  
if(((phpversion() >= '5.3') == false) || ((!ini_get('session_auto_start')) == false) || (extension_loaded('mysqli') == false) || (extension_loaded('zip') == false) || (extension_loaded('gd') == false) || ((extension_loaded('curl')) == false) || (is_writable('./../../config.php') == false)){
	?>
			<div class="ldi-info">You can not proceed if your server and PHP settings not fulfilling the minimum requirements. </div>
			<?php 
}
		?>	
		<!-- <a href="index.html" class="btn btn-primary">Back</a> -->
		<a href="javascript:void(0)" class="btn btn-primary server_config_btn">Next <i class="fa  fa-angle-double-right"></i></a>
		<br><br>
		<div class='alert alert-danger text-left' id="overall_errors" style="display:none;">
		Sorry please accept term and condition
		</div>
	</div>
	<?php  
}
elseif(isset($_POST['server_config_next']) && filter_var($_POST['server_config_next'])){
	?>
	<div id="sidebar" class="col-md-4 col-sm-4 col-lg-4 np">
		<div class="ldi-progress">
			<ul class="left-menu">
				<li>1. Start</li>
				<li>2. Server Requirements</li>
				<li class="active completed">3. Database Information</li>
				<li>4. Admin Information</li>
				<li>5. Completed</li>
			</ul>
		</div>
	</div>
	<div id="ldi-content" class="col-md-8 col-sm-8 col-lg-8">
		<div class="ldi-progress-bar">Step <b>3</b> out of 5 - Database Information</div>
			<form class="form-horizontal" id="ld_db_form">
				<div class="form-group">
					<label for="" class="control-label col-xs-3">Database Host</label>
					<div class="col-xs-5">
						<input type="text" class="form-control db_host" name="ld_db_hostname" id="ld_db_hostname" ><a class="ldi-tooltip-link" tabindex="-1" href="javascript:void(0)" data-toggle="tooltip" title="Database host with port e.g 127.0.0.1:3306 or in most cases its 'localhost'"><i class="fa fa-info-circle"></i></a>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-xs-3">Database Name</label>
					<div class="col-xs-5">
						<input type="text" class="form-control db_name" name="ld_db_dbname" id="ld_db_dbname" >
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-xs-3">Database Username</label>
					<div class="col-xs-5">
						<input type="text" class="form-control db_username" name="ld_db_username" id="ld_db_username" >
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-xs-3">Database Password</label>
					<div class="col-xs-5">
						<input type="password" class="form-control db_password" name="ld_db_password" id="ld_db_password" >
					</div>
				</div>
				<div id="purchase-code-verification stop_this" class="purchase_code_text">
					<div class="form-group">
						<label for="" class="control-label col-xs-3">Purchase Code</label>
						<div class="col-xs-5">
							<input type="text" class="form-control envato_code" name="ld_db_envatocode" id="ld_db_envatocode" >
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-offset-3 col-xs-10">
						<a href="javascript:void(0)" class="btn btn-info database_check_con">Test Connection</a>
						<img id="loading-test" src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL);?>/assets/images/preloader_installer.gif"/>
					</div>
				</div>
				<div class="connection_error" style="display:none;">
				<div class="alert alert-success text-center"></div>
				</div>
			</form>
			<!-- purchase code input show after testing connection is successfull -->
			
			<a href="javascript:void(0)" class="btn btn-success database_check_next">Next <i class="fa  fa-angle-double-right"></i></a>
	</div>
	<?php  
}
elseif(isset($_POST['db_check_next']) && filter_var($_POST['db_check_next']) == "1"){
	
	$database_host=	filter_var($_POST['host']);
	$database_name=	filter_var($_POST['dbname']);
	$database_username=	filter_var($_POST['uname']);
	$database_password=	filter_var($_POST['password']);  
	$envato_code=filter_var($_POST['code']);  
  
	$conn= @new mysqli($database_host,$database_username,$database_password,$database_name);
	if($conn->connect_error)
	{
		ob_clean();ob_start();
		echo "<div class='alert alert-danger text-center'>Connection failed: " . $conn->connect_error . "</div>";
	}
	else
	{
		$configure->conn = $conn;
		$configure->dh = $database_host;
		$configure->du = $database_username;
		$configure->dp = $database_password;
		$configure->dn = $database_name;
		$configure->pc = $envato_code;
		$configure->q8();   
		$configure->q28();
		$configure->q29();	
		/* $configure->q27(); */
		$configure->q34();
		$configure->q36();
		$configure->q0();
		session_destroy();
	}
}
elseif(isset($_POST['getadminlogin']) && filter_var($_POST['getadminlogin']) == "1"){
	?>
	<div id="sidebar" class="col-md-4 col-sm-4 col-lg-4 np">
		<div class="ldi-progress">
			<ul class="left-menu">
				<li>1. Start</li>
				<li>2. Server Requirements</li>
				<li>3. Database Information</li>
				<li class="active completed">4. Admin Information</li>
				<li>5. Completed</li>
			</ul>
		</div>
	</div>
	<div id="ldi-content" class="col-md-8 col-sm-8 col-lg-8">
		<div class="ldi-progress-bar">Step <b>4</b> out of 5 - Admin Information</div>
		<h4>Configure admin login credentials</h4>
		<form class="form-horizontal" id="ld_admin_detail_form">
			<div class="form-group">
				<label for="" class="control-label col-xs-2">Email</label>
				<div class="col-xs-5">
					<input type="email" class="form-control admin_email" id="ld_admin_email" name="ld_admin_email"	 placeholder="Email"><a  tabindex="-1"  class="ldi-tooltip-link" href="javascript:void(0)" data-toggle="tooltip" title="Please Set Your Username"><i class="fa fa-info-circle"></i></a>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-xs-2">Password</label>
				<div class="col-xs-5">
					<input type="password" class="form-control admin_password" id="ld_admin_password" name="ld_admin_password" placeholder="Password"><a  tabindex="-1" class="ldi-tooltip-link" href="javascript:void(0)" data-toggle="tooltip" title="Please Set Your Password"><i class="fa fa-info-circle"></i></a>
				</div>
			</div>
			<a href="javascript:void(0)" class="btn btn-success admin_credential_next">Next <i class="fa  fa-angle-double-right"></i></a>
		</form>
	</div>
	<?php  
}
elseif(isset($_POST['add_admin']) && filter_var($_POST['add_admin']) == "1"){
	$cvars = new laundry_myvariable();
	$host = trim($cvars->hostnames);
	$un = trim($cvars->username);
	$ps = trim($cvars->passwords); 
	$db = trim($cvars->database);
	$con = new mysqli($host, $un, $ps, $db);
	if($con->connect_error)
	{
	}
	else{
		$configure->conn = $con;
		$configure->email = filter_var($_POST['admin_email'], FILTER_SANITIZE_EMAIL);
		$configure->password = filter_var($_POST['admin_password']);
		$configure->q26();
		$returned_inserted_id = $configure->q23();
		$insertedadminid = $returned_inserted_id;
		$configure->q23();
		$_SESSION['ld_adminid'] = $insertedadminid;
		$_SESSION['ld_useremail'] = filter_var($_POST['admin_email'], FILTER_SANITIZE_EMAIL);
		$_SESSION['ld_admin_password']= filter_var($_POST['admin_password']);
		?>
		<div id="sidebar" class="col-md-4 col-sm-4 col-lg-4 np">
		<div class="ldi-progress">
			<ul class="left-menu">
				<li>1. Start</li>
				<li>2. Server Requirements</li>
				<li>3. Database Information</li>
				<li>4. Admin Information</li>
				<li class="active completed">5. Completed</li>
			</ul>
		</div>
	</div>
	<div id="ldi-content" class="col-md-8 col-sm-8 col-lg-8">
		<div class="ldi-progress-bar">Step <b>5</b> out of 5 - Completed</div>
		<h4 class="text-primary"> Woot..! Laundry Script is installed and license is activated successfully !!</h4>
		<div class="ldi-info"><b>Administrator's account has been successfully created.</b></div>
		<div class="ldi-info">
			<br />
			<div class="ldi-info"><b>Login Credentials are: </b><br />
				Email : <b><?php echo $_SESSION['ld_useremail'];?></b><br />
				Password : <b><?php echo $_SESSION['ld_admin_password'];?></b>
			</div>
			<div class="ldi-info">
				Getting Started : <a href="https://skymoonlabs.ticksy.com/articles/" target="_BLANK">Articles</a> <br />
				Video Tutorials : <a href="https://youtu.be/NLDuwmmxT9Y?list=PL31cBaqxDRtp-wu7GJ5PaTYmBu4b4vIAz" target="_BLANK">Videos</a>
			</div>
		</div>
		<div class="return_url">
			<a class="btn" href="index.php" target="_BLANK">Go to Booking Form</a>
			<a class="btn" href="admin/" target="_BLANK">Go to Admin Panel</a>
		</div>
	</div>
		<?php 
	}
}
?>