<?php 
/*$sess_usr_id  =   $this->session->userdata('user_sl'); 
$user_type_id  = $this->session->userdata('user_type_id');*/
$sess_usr_id    = $this->session->userdata('int_userid');
$user_type_id   = $this->session->userdata('int_usertype');


$user_type_id_details          =   $this->Survey_model->get_usertype_master_header($user_type_id);
$data['user_type_id_details']=$user_type_id_details;
if(!empty($user_type_id_details))
{
	$name=$user_type_id_details[0]['user_type_type_name'];
}



if($user_type_id==10)
{
  $user_master          =   $this->Master_model->get_usertype_master_header($sess_usr_id);
}
else
{
  $user_master          =   $this->Survey_model->get_usertype_master_header($sess_usr_id);
}


$data['user_master']  =   $user_master;
@$user_type_name      =   $user_master[0]['user_type_type_name'];
@$official_name       =   $user_master[0]['user_master_fullname'];

if(@$count!='')
{
	$msg="You've got ".@$count." Request";
}
else
{
	$msg="";
}
if(@$count_task!='')
{
	$msg1="You've got ".@$count_task." Activity";
}
else
{
	$msg1="";
}

?>


<div class="row no-gutters ui-color profilesection d-flex align-content-middle">
	<div class="col-8 profilebg mt-5 mb-5 ml-4">
		<div class="row no-gutters border ">
			<div class="col-12">
				<div class="alert alert-info text-primary" role="alert">
  							<h5 class="mt-4 ml-4 alert-heading"><em>Welcome, <?php echo $user_type_name; ?> </em> </h5>
				</div>				
			</div> <!-- end of col12 -->
			<div class="col-12">
				<div class="alert alert-success text-primary" role="alert">
				  <h4 class="alert-heading"><?php echo $msg; ?><br><?php echo $msg1; ?></h4>
				  <p>Please check your Request Menu, for viewing notifications from the Vessel Owners and Surveyors. All the requests about survey activities is grouped under the Request menu.</p>
				  <hr>
				  <p class="mb-0"> All the activities planned by you, is grouped under the Activities menu.</p>
				</div>
			</div> <!-- end of col12 -->
			<div class="col-12 text-primary">
				<div class="card">
				  <div class="card-header">
				    <div class="row no-gutters">
				    	<div class="col-3 d-flex justify-content-left"> Email </div>
				    	<div class="col-6 d-flex justify-content-left"> ajayvijayan123@gmail.com</div>
				    	<div class="col-3 d-flex justify-content-left"> <button type="button" class="btn btn-info btn-flat btn-sm"> <i class="fas fa-pencil-alt"></i> Edit</button></div>
				    </div> <!-- end of row -->
				  </div>
				  <div class="card-header">
				    <div class="row no-gutters">
				    	<div class="col-3 d-flex justify-content-left"> Mobile Number </div>
				    	<div class="col-6 d-flex justify-content-left"> 9995140577 </div>
				    	<div class="col-3 d-flex justify-content-left"> <button type="button" class="btn btn-info btn-flat btn-sm"> <i class="fas fa-pencil-alt"></i> Edit</button></div>
				    </div> <!-- end of row -->
				  </div>
				</div>
			</div> <!-- end of col12 -->
		</div> <!-- inner row -->
	</div> <!-- end of col-8 -->
	<div class="col-3 mt-5 mb-5 border-left profilebg">
		<div class="row no-gutters ">
			<div class="col-12 mb-2 mt-5 d-flex justify-content-center">
				<img src="<?php echo base_url(); ?>plugins/img/admin_user.jpg" alt="cs" class="img-thumbnail" style="max-height: 160px; max-width: 160px;">
			</div> <!-- end of inner col-12 photograph -->
			<div class="col-12 d-flex justify-content-center mt-3"> 
				<button type="button" class="btn btn-info btn-flat "> <i class="far fa-edit"></i> Change Photograph</button>
			</div> <!-- end of inner col -->
			<div class="col-12 mt-3 d-flex justify-content-center"> 
				<button type="button" class="btn btn-success btn-flat "> <i class="fas fa-key"></i> Change Password</button>
			</div> <!-- end of inner col -->
		</div> <!-- inner row for photo section -->
	</div> <!-- end of col-4 -->
</div> <!-- end of row profile section --> 
