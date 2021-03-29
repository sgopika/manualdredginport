<?php  
/* $sess_usr_id  =   $this->session->userdata('user_sl');
$user_type_id=  $this->session->userdata('user_type_id');
*/
 $sess_usr_id    = $this->session->userdata('int_userid');
$user_type_id   = $this->session->userdata('int_usertype');
?>
<!-- Start of breadcrumb -->


 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
  <?php if($user_type_id==12) { ?> 
  <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>

   <?php } if($user_type_id==13)  { ?><li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li> <?php } ?>
   
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ui-innerpage">
  <div class="table-responsive">
 <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
  <thead>
     <tr><th colspan="9"><font size="4">Form 5/Form 6 entry</font></th></tr>
  <tr>
  <th>#</th>
  <th>Vessel Name</th>
  <th>Ref. No</th>
  <th>Vessel Type</th>
  <th>Owner Name</th>
  <th>Form</th>
  <th>Activity Type</th>
  <th>Forward Date</th>
  <th></th>
  </tr>
  </thead>
  <tbody>
  <?php
    $i=1;
    //@$customer_name1=$customer_details1[0]['user_name'];
    //  print_r($initial_data);
    foreach($initial_data as $res1)
    {
      @$vessel_sl2             = $res1['vessel_sl'];
      @$vessel_type_id        = $res1['vessel_type_id'];
      @$processflow_sl2        = $res1['processflow_sl'];
      @$current_status_id     = $res1['current_status_id'];
      @$status                = $res1['status'];
      @$reference_number      = $res1['reference_number'];

      @$process_id            = $res1['process_id'];
      @$survey_id2             = $res1['survey_id'];

      if($vessel_type_id!=0)
      {
        $vessel_type          =   $this->Survey_model->get_vessel_type_id($vessel_type_id);
        $data['vessel_type']  =   $vessel_type;
        $vessel_type_name     =   $vessel_type[0]['vesseltype_name'];
      }
      else
      {
        $vessel_type_name="-";
      } 

      $get_vessel_created_user         =   $this->Survey_model->get_vessel_created_user($vessel_sl2);
      $data['get_vessel_created_user'] =   $get_vessel_created_user;
      @$customer_name1                 =   $get_vessel_created_user[0]['user_name'];

      $application_date       =date("d-m-Y", strtotime($res1['status_change_date']));
      $process_name           =   $this->Survey_model->get_process_name($process_id);
      $data['process_name']   =   $process_name;
      $process                =   $process_name[0]['process_name'];

      $survey_name            = $this->Survey_model->get_survey_name($survey_id2);
      $data['survey_name']    =   $survey_name;
      if(!empty($survey_name))
      {
        $survey=$survey_name[0]['survey_name'];
      }
      else
      {
        $survey="";
      }

      $current_status         =   $this->Survey_model->get_status_details($vessel_sl2,$survey_id2);
      $data['current_status'] =   $current_status;

      if(!empty($current_status))
      {
        $status_details_sl  = $current_status[0]['status_details_sl'];
        @$status_id         = $current_status[0]['current_status_id'];
        @$sending_user_id   = $current_status[0]['sending_user_id'];
        @$receiving_user_id = $current_status[0]['receiving_user_id'];
        @$process_id_status = $current_status[0]['process_id'];
      }

      $user_type_details            =   $this->Survey_model->get_user_master($receiving_user_id);
      $data['user_type_details']    =   $user_type_details;
      @$usertype_name =$user_type_details[0]['user_type_type_name'];

      if($process_id_status==8)
      {
        $message1='<span class="badge bg-success">Form 5 </span>';
      }
      if($process_id_status==9)
      {
        $message1='<span class="badge bg-success">Form 6</span>';
      }
      if($process_id_status==19)
      {
        $message1='<span class="badge bg-success">Form 6</span>';
      }
      if($process_id_status==20)
      {
        $message1='<span class="badge bg-success">Form 6</span>';
      }

      $form_number           =   $this->Survey_model->get_form_number_cs($process_id);
      $data['form_number']    =   $form_number;
      @$form_no =$form_number[0]['form_no'];

$vessel_sl1 = $this->encrypt->encode($vessel_sl2); 
$vessel_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

$survey_id1 = $this->encrypt->encode($survey_id2); 
$survey_id=str_replace(array('+', '/', '='), array('-', '_', '~'), $survey_id1);

$processflow_sl1 = $this->encrypt->encode($processflow_sl2); 
$processflow_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $processflow_sl1);




      ?>

      <tr>
      <td><?php echo $i; ?></td>
      <td><?php echo $res1['vessel_name']; ?></td>
      <td><?php echo $reference_number; ?></td>
      <td><?php echo $vessel_type_name; ?></td>
      <td><?php echo $customer_name1; ?></td>
      <td>Form&nbsp; <?php echo $form_no;?></td>
      <td><?php echo $survey; ?></td>
      <td><?php echo $application_date; ?><?php //echo $status; ?> </td>
      <td>
      <?php if($status==1 && $process_id_status==8) { ?>
        <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/form5_entry/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-secondary btn-flat btn-sm"><?php echo $message1; ?></a>
      <?php
      }
      ?>
      <?php if($status==1 && $process_id_status==9) { ?>
        <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/form6_entry/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-secondary btn-flat btn-sm"><?php echo $message1; ?></a>
      <?php
      }
      ?>
      <?php if($status==1 && $process_id_status==19) { ?>
        <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/form5_view_annual/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-secondary btn-flat btn-sm"><?php echo $message1; ?></a>
      <?php
      }
      ?>
      <?php if($status==1 && $process_id_status==20) { ?>
        <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/form6_view_annual/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-secondary btn-flat btn-sm"><?php echo $message1; ?></a>
      <?php
      }
      ?>
      </td>
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
  <th>Ref. No</th>
  <th>Vessel Type</th>
  <th>Owner Name</th>
  <th>Form</th>
  <th>Activity Type</th>
  <th>Forward Date</th>
  <th></th>
  </tr>
  </tfoot>
</table>
</div>
</div>