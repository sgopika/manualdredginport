<?php  
  $sess_usr_id          = $this->session->userdata('int_userid'); 
  $user_type_id         = $this->session->userdata('int_usertype');
?>
<!-- Start of breadcrumb -->


<nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
  <?php if($user_type_id==11) { /// After integration Vessel Owner New user_type_id=11?> 
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li> 
  <?php } else if($user_type_id==14) {/// After integration Registering Authority New user_type_id=14  ?> 
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li> 
  <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ui-innerpage">
  <div class="table-responsive">
  <!-- <table id="example" class="display mytableheader" style="width:100%" border="0"> -->
    <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
    <thead>
      <tr><th colspan="9"><font size="4">Transfer of Registered Vessels Outside Kerala</font></th></tr>  
      <tr>
        <th>#</th>
        <th>Vessel Name</th>
        <th>Vessel Type</th>
        <th>Vessel sub type</th>
        <th>Vessel category</th>
        <th>Port From</th>
        <th>Port To</th>
        <th>Seller</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $i=1;
    //print_r($transfervesl_det);
    foreach($transfervesl_det as $res1)
    {
      $vessel_sl                      = $res1['vesselmain_vessel_id'];
      $approved_id                    = $res1['transfer_approve_id'];
      $seller_id                      = $res1['transfer_seller_id'];
      $transfer_changetype            = $res1['transfer_based_changetype'];
      $buyer_id                       = $res1['transfer_buyer_id'];
      $pay_status                     = $res1['payment_status'];
      $transfer_status                = $res1['transfer_status'];
      @$user_type_name                = $res1['user_type_type_name'];
      $profile                        = $res1['transfer_changepending_status'];///1=no profile--2=profile created
      $transfer_portofregistry_from   = $res1['transfer_portofregistry_from'];
      $transfer_portofregistry_fm     = $this->Vessel_change_model->get_registry_port_id($transfer_portofregistry_from);
      if(!empty($transfer_portofregistry_fm)){
        foreach($transfer_portofregistry_fm as $port_fm){
          $port_fm                    = $port_fm['vchr_portoffice_name'];
        }
      }
      $transfer_portofregistry_to     = $res1['transfer_portofregistry_to'];
      $transfer_portofregistry_tto    = $this->Vessel_change_model->get_registry_port_id($transfer_portofregistry_to);
      if(!empty($transfer_portofregistry_tto)){
        foreach($transfer_portofregistry_tto as $port_to){
          $port_to                    = $port_to['vchr_portoffice_name'];
        }
      } else {
        $port_to                      = '';
      }
      $processid                      = 40;
      $approved_username              = $this->Vessel_change_model->get_user_master($approved_id); 
      if(!empty($approved_username)){
        foreach($approved_username as $res_appvname)
        {
          $appvd_usertyp              = $res_appvname['user_type_type_name'];
        }
      }
      if($seller_id!=0){
        $seller_det                   = $this->Vessel_change_model->get_vessel_owner_name($seller_id); //print_r($seller_det);
        foreach ($seller_det as $sell_res) {
          $seller_name                = $sell_res['user_master_fullname'];
        }
      } else { $seller_name = ''; }
      if($buyer_id!=0){
        $buyer_det                    = $this->Vessel_change_model->get_vessel_owner_name($buyer_id);
        foreach ($buyer_det as $buy_res) {
          $buyer_name                 = $buy_res['user_master_fullname'];
        }
      } else {
        if($transfer_changetype!=1){
          $buyer_name                 = "<font color='red'>Not a Registered User</font>";
        } else { 
          $buyer_name="";
        }
      } 
      $processflowsl                  = $this->Vessel_change_model->get_processflow_details_before_flow($vessel_sl);//print_r($processflowsl);
      if(!empty($processflowsl)){
        foreach($processflowsl as $process_res){
          $processflowsl1             = $process_res['processflow_sl'];
        }
      }
      $status_det                     = $this->Vessel_change_model->get_vesselnamechangestatus_details($vessel_sl); 
      $data['status_det']             = $status_det; 
      if(!empty($status_det)){
        foreach($status_det as $res_stat)
        {
          $status_details_sl          = $res_stat['status_details_sl'];
          $current_status_id          = $res_stat['current_status_id'];
          $receiving_user_id          = $res_stat['receiving_user_id'];
          $received_username          = $this->Vessel_change_model->get_user_master($receiving_user_id); 
          if(!empty($received_username)){
            foreach($received_username as $res_recvname)
            {
              $recvd_usertyp          = $res_recvname['user_type_type_name'];
            }
          }
        }
        if(!empty($approved_username)){ $curr_stat=5; $user=$appvd_usertyp; $status_vw=1;} else { $curr_stat=$current_status_id; $user=$recvd_usertyp;} 
        if($curr_stat==1)
        {
           $message='<span class="badge badge-success">INITIATED TO '.$user.'</span>';
        }
        if($curr_stat==2)
        {
           $message='<span class="badge badge-success">FORWARDED TO '.$user.'</span>';
        }
        if($curr_stat==3)
        {
           $message='<span class="badge badge-success">REJECTED TO '.$user.'</span>';
        }
        if($curr_stat==4)
        {
           $message='<span class="badge badge-success">REVERTED TO '.$user.'</span>';
        }
        if($curr_stat==5  && $pay_status==1)
        {
           $message='<span class="badge badge-success">APPROVED BY '.$user.'</span>';
           $button_message='<span class="badge bg-success">VIEW</span>';
        }
        if($curr_stat==6)
        {
           $message='<span class="badge badge-success">APPROVED & FORWARDED TO '.$user.'</span>';
        }
        if($curr_stat==7)
        {
           $message='<span class="badge badge-info">INTIMATION SEND BY '.$user.'</span>';
           $button_message='<span class="badge bg-success">VIEW</span>';
        }
        if($curr_stat==8)
        {
           $message='<span class="badge bg-success">Pending</span>';
        }
        if($pay_status==0){
           $message='<span class="badge badge-danger">PAYMENT PENDING</span>';
           $button_message='<span class="badge bg-success">Payment</span>';
        }
         if($transfer_status==2){
        $message='<span class="badge badge-info">REJECTED BY '.$user.'</span>';
        }
      } 

      $vessel_sl1                   = $this->encrypt->encode($vessel_sl); 
      $vessel_sl2                   = str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);
      $status_details_sl1           = $this->encrypt->encode($status_details_sl);
      $status_details_sl2           = str_replace(array('+', '/', '='), array('-', '_', '~'), $status_details_sl1);
      $processflowsl2               = $this->encrypt->encode($processflowsl1); 
      $processflowsl3               = str_replace(array('+', '/', '='), array('-', '_', '~'), $processflowsl2);
      
      ?>

      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $res1['vesselmain_vessel_name'];//."___".$vessel_sl; ?></td>
        <td><?php echo $res1['vesselmain_vessel_type']; ?></td>
        <td><?php echo $res1['vesselmain_vessel_subtype']; ?></td>
        <td><?php echo $res1['vesselmain_vessel_category'] ; ?></td>
         <td><?php echo $port_fm;?></td>
        <td><?php echo $port_to;?></td>
        <td><?php echo $seller_name;?></td>
      </tr>
    <?php
    $i++;
    }
    ?>
    </tbody>
    <tfoot>
      <tr>
        <th>#</th>
        <th>Vessel Name</th>
        <th>Vessel Type</th>
        <th>Vessel sub type</th>
        <th>Vessel category</th>
        <th>Port From</th>
        <th>Port To</th>
        <th>Seller</th>
      </tr>
    </tfoot>
  </table>
</div>
</div>