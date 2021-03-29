<?php
/*$sess_usr_id  =   $this->session->userdata('user_sl');
$user_type_id = $this->session->userdata('user_type_id');*/
$sess_usr_id  =   $this->session->userdata('int_userid');
       $user_type_id =   $this->session->userdata('int_usertype');

$transferownerchg_pending       =  $this->Vessel_change_model->get_transferownerchange_pending($sess_usr_id); 
//print_r($transferownerchg_pending);exit;
if(!empty($transferownerchg_pending)) {
  foreach($transferownerchg_pending as $result){
    $transfer_buyer_id    = $result['transfer_buyer_id'];
    $transfer_buyer_name  = $result['transfer_buyer_name'];
    if($transfer_buyer_id!=0){
      $message='<strong>The Buyer '.$transfer_buyer_name.' has registered in the port website!!!</strong>';
    }
  } 
  /*foreach($transferownerchg_pending as $result){
    $transfer_sl = $result['transfer_sl'];
    $mobile      = $result['transfer_buyer_mobile'];
    $email       = $result['transfer_buyer_email_id'];
  }
  $user_check = $this->Vessel_change_model->get_owner_check($mobile,$email);
  $cnt_rws    = count($user_check); 
  if($cnt_rws>0){
    foreach($user_check as $user_res){
      $user_name =$user_res['user_name'];
      $user_sl =$user_res['user_sl'];
    }
    $data_tranown = array(
      'transfer_buyer_id'=> $user_sl
    );
   $ownchg_update_status  = $this->Vessel_change_model->update_transownerchg_status('tbl_transfer_ownershipchange',$data_tranown, $transfer_sl);
    if($ownchg_update_status){
      $message='<strong>The Buyer '.$user_name.' has registered in the port website!!!</strong>';
    }
  }*/
}
////transfervessel
$transfervessel_pending       =  $this->Vessel_change_model->get_transfervessel_pending($sess_usr_id); 
//print_r($transferownerchg_pending);exit;
if(!empty($transfervessel_pending)) {
  foreach($transfervessel_pending as $result1){
    $transfer_buyer_id    = $result1['transfer_buyer_id'];
    $transfer_buyer_name  = $result1['transfer_buyer_name'];
    if($transfer_buyer_id!=0){
      $message='<strong>The Buyer '.$transfer_buyer_name.' has registered in the port website!!!</strong>';
      
    }
  }
  /*foreach($transfervessel_pending as $result1){
    $transfer_sl1 = $result1['transfer_sl'];
    $mobile1      = $result1['transfer_buyer_mobile'];
    $email1       = $result1['transfer_buyer_email_id'];
  }
  $user_check1 = $this->Vessel_change_model->get_owner_check($mobile1,$email1);
  $cnt_rws1    = count($user_check1); 
  if($cnt_rws1>0){
    foreach($user_check1 as $user_res1){
      $user_name1 =$user_res1['user_name'];
      $user_sl1 =$user_res1['user_sl'];
    }
    $data_tranown1 = array(
      'transfer_buyer_id'=> $user_sl1
    );
   $ownchg_update_status1  = $this->Vessel_change_model->update_transownerchg_status('tbl_transfer_ownershipchange',$data_tranown1, $transfer_sl1);
    if($ownchg_update_status1){
      $message='<strong>The Buyer '.$user_name1.' has registered in the port website!!!</strong>';
    }
  }*/
}
$transfervessel_pending       =  $this->Vessel_change_model->get_transfervessel_pending($sess_usr_id); 
if(!empty($transfervessel_pending)) {
  foreach($transfervessel_pending as $result1){
    $transfer_buyer_id    = $result1['transfer_buyer_id'];
    $transfer_buyer_name  = $result1['transfer_buyer_name'];
    if($transfer_buyer_id!=0){
      $message='<strong>The Buyer '.$transfer_buyer_name.' has registered in the port website!!!</strong>';
    }
  }
} 
$user_type_id_details          =   $this->Survey_model->get_user_master_header($user_type_id);//print_r($transfervessel_pending);exit;
$data['user_type_id_details']=$user_type_id_details;
if(!empty($user_type_id_details))
{
	$name=$user_type_id_details[0]['user_type_type_name'];
}
else
{
  $name="";
}


if($user_type_id==10)
{
  $user_master          =   $this->Survey_model->get_user_master_header($sess_usr_id);
}
else
{
  $user_master          =   $this->Survey_model->get_user_master_header($sess_usr_id);
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


<div class="row no-gutters ui-color  profilesection d-flex align-content-middle">
	<div class="col-12 mt-5">
		<div class="card mt-3">
  <div class="card-header">
    Notifications
  </div>
  <div class="card-body"><?php if(isset($message)){?>
    <div class="alert alert-danger" role="alert">
  <?php echo $message; ?>
</div><?php }?>
<div class="alert alert-secondary" role="alert">
  A simple secondary alert—check it out!
</div>
<div class="alert alert-success" role="alert">
  A simple success alert—check it out!
</div>
<div class="alert alert-danger" role="alert">
  A simple danger alert—check it out!
</div>
<div class="alert alert-warning" role="alert">
  A simple warning alert—check it out!
</div>

<nav aria-label="...">
  <ul class="pagination justify-content-end">
    <li class="page-item disabled">
      <span class="page-link">Previous</span>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item active" aria-current="page">
      <span class="page-link">
        2
        <span class="sr-only">(current)</span>
      </span>
    </li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>


  </div>
</div>
	</div> <!-- end of col12 -->
</div> <!-- end of row profile section --> 
