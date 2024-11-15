<?php  
include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/user_session_check.php');
include(dirname(dirname(__FILE__)).'/objects/class_users.php');
include(dirname(dirname(__FILE__)).'/objects/class_order_client_info.php');
include(dirname(dirname(__FILE__))."/objects/class_eml_sms.php");
$database=new laundry_db();
$conn=$database->connect();
/* $database->conn=$conn; */
$user=new laundry_users();
$order_client_info=new laundry_order_client_info();
$user->conn=$conn;
$order_client_info->conn=$conn;

$emlsms=new eml_sms();
$emlsms->conn=$conn;
?>

    <div id="lda-customers-listing" class="panel tab-content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title"><?php echo filter_var($label_language_values['message']);	?></h1>
            </div>
			<div class="panel-body">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#registered-customers-listing"><?php echo filter_var($label_language_values['email']);	?></a></li>
					<li><a data-toggle="tab" href="#guest-customers-listing"><?php echo filter_var($label_language_values['sms']);	?></a></li>
				</ul>
				<div class="tab-content">
					<div id="registered-customers-listing" class="tab-pane fade in active">
						<h3 class="pull-left"><?php echo filter_var($label_language_values['email']);	?></h3>
						<div id="accordion" class="panel-group">
							<table id="email_msg_table" class="display responsive nowrap table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
								<tr>
									
									<th><?php echo filter_var($label_language_values['subject']);	?></th>
									<th><?php echo filter_var($label_language_values['message']);	?></th>
									<th><?php echo filter_var($label_language_values['attachment']);	?></th>
									<th><?php echo filter_var($label_language_values['date']);	?></th>
									<th><?php echo filter_var($label_language_values['actions']);	?></th>
								</tr>
								</thead>
								<tbody>
								<?php 
								$res = $emlsms->sel_eml_data();
								if($res){
								while($r = mysqli_fetch_array($res)){
									$atch="../assets/images/emails/".$r['cus_img'];
									$cnt=sizeof(explode(",",$r['cus_ids']));
									?>
									<tr>
									<td><?php echo filter_var($r['cus_sub']); ?></td>
									<td><?php echo filter_var($r['cus_msg']); ?></td>
									<td>
									<?php 
									if($r['cus_img'] != ""){
									?>
									<a target="_blank" class="btn btn-primary" href="<?php echo filter_var($atch); ?>"><?php echo filter_var($label_language_values['see_attachment']);	?></a>
									<?php  }else{
										?>
										<a target="_blank" class="btn btn-danger" href="javascript:void(0)"><?php echo filter_var($label_language_values['no_attachment']);	?></a>
										<?php 
									} ?>
									</td>
									<td><?php echo filter_var($r['cus_dt']); ?></td>
									<td><a class="btn btn-primary all_cus_show_click" data-id="<?php echo filter_var($r['id']);	?>" href="#all_customers_show"  data-toggle="modal">
													<i class="fa fa-users"></i><span class="badge br-10"><?php echo filter_var($cnt);	?></span>
												</a></td>
									</tr>
									<?php 
								}}
								?>
								</tbody>
							</table>
						</div>
					</div>
					<div id="guest-customers-listing" class="tab-pane fade">
						<h3><?php echo filter_var($label_language_values['sms']);	?></h3>
						<div id="accordion" class="panel-group">
							<table id="guest-client-table" class="display responsive nowrap table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th><?php echo filter_var($label_language_values['message']);	?></th>
									<th><?php echo filter_var($label_language_values['date']);	?></th>
									<th><?php echo filter_var($label_language_values['actions']);	?></th>
								</tr>
								</thead>
								<tbody>
								<?php 
								$res = $emlsms->sel_sms_data();
								if($res){
								while($r = mysqli_fetch_array($res)){
									$cnt=sizeof(explode(",",$r['cus_ids']));
									?>
									<tr>
									<td><?php echo filter_var($r['cus_msg']); ?></td>
									<td><?php echo filter_var($r['cus_dt']); ?></td>
									<td><a class="btn btn-primary sms_cus_show_click" data-id="<?php echo filter_var($r['id']);	?>" href="#all_customers_show"  data-toggle="modal">
													<i class="fa fa-users"></i><span class="badge br-10"><?php echo filter_var($cnt);	?></span>
												</a></td>
									</tr>
									<?php 
								}
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
	
 <div class="modal fade" id="all_customers_show" role="dialog">
    <div class="modal-dialog modal-lg">
    
      
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo filter_var($label_language_values['customers']);	?></h4>
        </div>
        <div class="modal-body of-h">
			<div class="col-md-12 col-sm-12 col-sm-12 col-xs-12 mt-20 custmrdtl">
			<button type="button" class="btn btn-default fc btn-xs">Extra small button</button>
			</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo filter_var($label_language_values['close']);	?></button>
        </div>
      </div>
      
    </div>
  </div>
<?php 
include(dirname(__FILE__).'/footer.php');
?>