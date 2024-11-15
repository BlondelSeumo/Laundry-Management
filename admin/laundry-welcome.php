<?php   
include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/user_session_check.php');
include(dirname(dirname(__FILE__)) . "/objects/class_adminprofile.php");
$con = new laundry_db();
$conn = $con->connect();
$objadminprofile = new laundry_adminprofile();
$objadminprofile->conn = $conn;
?>
	<div class="container"> 
		<div id="lda-laundry-welcome">
			<div class="lda-welcome-main col-md-12 col-sm-12">
				<h1> Welcome to Laundry 2.0</h1>
				<div class="ld-into-text">
					Thank you for choosing Laundry! If this is your first time using Laundry, you will find some helpful "Getting Started" links below. If you just updated the plugin, you can find out what's new in the "What's New" section below. 
				</div>
				<div class="ld-laundry-badge">
					<img src="<?php echo filter_var(SITE_URL, FILTER_VALIDATE_URL);	?>/assets/images/laundry-logo-new.png" />
				</div>
			</div>
			<div class="lda-welcome-inner br-2">
				<div class=""></div>
				
				<div class="lda-cleato-articles col-md-6 col-lg-6 ">
					<div class="panel panel-default h-450 br-2">
						<div class="panel-heading bg-info">Getting Started</div>
						<div class="panel-body">
							<ul class="lda-articles-ul">
								<li><a href="https://skymoonlabs.ticksy.com/article/8625/" target="_BLANK">Introduction <i class="fa fa-external-link"></i></li>
								<li><a href="https://skymoonlabs.ticksy.com/article/8627/" target="_BLANK">Installation & Basic Configuration Guide <i class="fa fa-external-link"></i></li>
								<li><a href="https://skymoonlabs.ticksy.com/article/9030/" target="_BLANK">Update with New Version <i class="fa fa-external-link"></i></li>
								<li><a href="https://skymoonlabs.ticksy.com/article/8637/" target="_BLANK">Shortcode or embed code in website <i class="fa fa-external-link"></i></li>
								<li><a href="https://skymoonlabs.ticksy.com/article/8636/" target="_BLANK">Scheduling in Laundry <i class="fa fa-external-link"></i></li>
								<li><a href="https://skymoonlabs.ticksy.com/article/8632/" target="_BLANK">Services - Add method, units <i class="fa fa-external-link"></i></li>
								<li><a href="https://skymoonlabs.ticksy.com/article/8631/" target="_BLANK">Appointments Calender <i class="fa fa-external-link"></i></li>
								<a href="https://skymoonlabs.ticksy.com/articles/100005425" class="btn-primary btn btn-circle">Read all articles <i class="fa fa-external-link"></i></a>
								
							</ul>
						</div>
					</div>
				</div>
				<div class="lda-cleato-help col-md-6 col-lg-6 ">
					<!-- <div class="panel panel-default h-450 br-2">
						<div class="panel-heading bg-success">Help</div>
						<div class="panel-body">
							 <iframe width="100%" height="315" src="https://www.youtube.com/embed/videoseries?list=PL31cBaqxDRtp-wu7GJ5PaTYmBu4b4vIAz" frameborder="0" allowfullscreen></iframe> 
						</div>
					</div> -->
				</div>
				<div class="lda-cleato-changelog col-md-12 col-lg-12 ">
					<div class="panel panel-default br-2">
						<div class="panel-heading bg-primary">Laundry Change Log</div>
						<div class="panel-body">
							<div class="ld-changelog-menu col-md-3 col-sm-4 col-xs-12 col-lg-3 np">
								<ul class="nav nav-tab nav-stacked">	
						            <li class="active"><a href="#version2_0" data-toggle="pill">What's new in 2.0</a></li>							
									<li><a href="#version1_4" data-toggle="pill">Version 1.4</a></li>
									<li><a href="#version1_3" data-toggle="pill">Version 1.3</a></li>
									<li><a href="#version1_2" data-toggle="pill">Version 1.2</a></li>
									<li><a href="#version1_1" data-toggle="pill">Version 1.1</a></li>
									<li><a href="#version1_0" data-toggle="pill">Version 1.0</a></li>
								</ul>
							</div>
							<div class="panel-body">
								<div class="lda-changelog-details tab-content col-md-9 col-sm-8 col-lg-9 col-xs-12 container-fluid">
								<div class="changelog-details tab-pane active" id="version2_0">
										<h4 class="nm">What's new in Version 2.0?</h4>
										<ul class="lda-changelog-ul">
											<li><span class="ld-fixed bg-success br-3 b-shadow">Added</span> Compatible with PHP latest version 8.2</li>
											<li><span class="ld-fixed bg-success br-3 b-shadow">Added</span> Staff Registration</li>
											<li><span class="ld-fixed bg-success br-3 b-shadow">Added</span> Edit User</li>
											<li><span class="ld-fixed bg-success br-3 b-shadow">Added</span> Special Offer</li>
											<li><span class="ld-fixed bg-success br-3 b-shadow">Added</span> Staff Showing On Zipcode</li>
											<li><span class="ld-improved bg-info br-3 b-shadow">Improved</span> CRM </li>
										</ul>
								</div>
								<div class="changelog-details tab-pane" id="version1_4">
										<h4 class="nm">What's new in Version 1.4?</h4>
										<ul class="lda-changelog-ul">
											<li><span class="ld-fixed bg-success br-3 b-shadow">Added</span> Compatible with PHP latest version 7.x</li>
										</ul>
								</div>
								<div class="changelog-details tab-pane" id="version1_3">
										<h4 class="nm">What's new in Version 1.3?</h4>
										<ul class="lda-changelog-ul">
											<li><span class="ld-fixed bg-success br-3 b-shadow">Added</span> POS</li>
										</ul>
								</div>
									<div class="changelog-details tab-pane" id="version1_2">
										<h4 class="nm">What's new in Version 1.2?</h4>
										<ul class="lda-changelog-ul">
											<li><span class="ld-fixed bg-success br-3 b-shadow">Added</span> Articles Accordingl To Service</li>
											<li><span class="ld-fixed bg-danger br-3 b-shadow">Fixed</span> Guest User Booking Issue </li>
											<li><span class="ld-fixed bg-danger br-3 b-shadow">Fixed</span> Staff Payment Issue </li><li><span class="ld-fixed bg-danger br-3 b-shadow">Fixed</span> https:// Issue  </li>
											<li><span class="ld-improved bg-info br-3 b-shadow">Improved</span> PayUmoney </li>
											<li><span class="ld-fixed bg-success br-3 b-shadow">Added</span> Multiservice Booking</li>
										</ul>
									</div>
									<div class="changelog-details tab-pane" id="version1_1">
										<h4 class="nm">What's new in Version 1.1?</h4>
										<ul class="lda-changelog-ul">
											<li><span class="ld-fixed bg-success br-3 b-shadow">Added</span> Added. </li>
											<li><span class="ld-fixed bg-danger br-3 b-shadow">Fixed</span> Fixed. </li>
											<li><span class="ld-improved bg-info br-3 b-shadow">Improved</span> Improved. </li>
										</ul>
									</div>
									
									<div class="changelog-details tab-pane" id="version1_0">
										<h4 class="nm">Version 1.0</h4>
										<ul class="lda-changelog-ul">
											<li><span class="ld-fixed bg-success br-3 b-shadow">RELEASE</span> Initial Release. </li>
										</ul>
									</div>
								</div>
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