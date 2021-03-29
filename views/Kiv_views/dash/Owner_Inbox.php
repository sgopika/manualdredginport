<?php  
/*$sess_usr_id  =   $this->session->userdata('user_sl'); 
  $user_type_id1  =   $this->session->userdata('user_type_id');*/
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id1   = $this->session->userdata('int_usertype');


   ?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
<?php if($user_type_id1==11) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>

    <?php if($user_type_id1==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id1==3) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id1==13) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ui-innerpage">
  <div class="table-responsive">

<table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">

<thead>
   <tr><th colspan="8"><font size="4">Inbox</font></th></tr>
  <tr>
  <th>#</th>
  <th>Ref. No</th>
  <th>Vessel Name</th>
  <th>Activity Type</th>
  <th>Form</th>
  <th>Process</th>
  <th>Status</th>
  <th>Action </th>
  </tr>
</thead>
<tbody>
<?php 
$i=1; 
$survey_id200=2;
$survey_id2 = $this->encrypt->encode($survey_id200); 
$survey_id2=str_replace(array('+', '/', '='), array('-', '_', '~'), $survey_id2);
//print_r($vessel_details);
foreach($vessel_details as $result_vessel)
{
  $vessel_sl100=$result_vessel['vessel_sl'];
  $reference_number=$result_vessel['reference_number'];
  $survey_id100=$result_vessel['survey_id'];
  $vessellist_owner=$this->Survey_model->get_vessellist_owner($vessel_sl100);
  $data['vessellist_owner']  = $vessellist_owner; //print_r($vessellist_owner);
  if(!empty($vessellist_owner))
  {
    $processing_status=$vessellist_owner[0]['processing_status'];
  }
  else
  {
    $processing_status=1;
  }
  //_________________________Annual Survey____________________________________//
  $processflow=$this->Survey_model->get_processflow_id($vessel_sl100,$survey_id100);
  $data['processflow']  = $processflow;
  //print_r($processflow);
  if(!empty($processflow))
  {
    $processflow_id_owner=$processflow[0]['processflow_sl'];
     $user_id=$processflow[0]['user_id'];
  }
  else
  {
    $processflow_id_owner=0;

  }

  $annual_survey=$this->Survey_model->get_annual_survey($vessel_sl100);
  $data['annual_survey']  = $annual_survey;
  if(!empty($annual_survey))
  {
    $scheduled_date=$annual_survey[0]['scheduled_date'];
    $now         = date("Y-m-d");
    $date1_ts    = strtotime($scheduled_date);
    $date2_ts    = strtotime($now);
    $diff        = $date1_ts - $date2_ts;
    $numberofdays= round($diff / 86400);
  }
  else
  {
    $numberofdays= 0;
  }
  //_________________________Drydock Survey____________________________________//
           
  $drydock_survey=$this->Survey_model->get_drydock_survey($vessel_sl100);
  $data['drydock_survey']  = $drydock_survey;
  //print_r($drydock_survey);
  if(!empty($drydock_survey))
  {
    $scheduled_date1=$drydock_survey[0]['scheduled_date']; 
    $now1         = date("Y-m-d"); 
    $date1_ts1    = strtotime($scheduled_date1);
    $date2_ts1    = strtotime($now1); 
    $diff1        = $date1_ts1 - $date2_ts1;
    $numberofdays1= round($diff1 / 86400);
  }
  else
  {
    $numberofdays1= 0;
  }



  $survey_defect_details      =   $this->Survey_model->get_survey_defect($vessel_sl100,$survey_id100);
  $data['survey_defect_details']  = $survey_defect_details;

  if(!empty($survey_defect_details))
  {
    $survey_defects_sl1=$survey_defect_details[0]['survey_defects_sl'];
  }
  //_________________________________process flow_________________________________________//

  $process_flow         =   $this->Survey_model->get_process_flow_show($vessel_sl100,$sess_usr_id);
  $data['process_flow'] =   $process_flow;
  //print_r($process_flow);


  if(!empty($process_flow)) 
  {
    @$current_status_id   =   $process_flow[0]['current_status_id'];
    @$processflow_sl2     =   $process_flow[0]['processflow_sl'];
    @$process_id          =   $process_flow[0]['process_id'];
    @$status              =   $process_flow[0]['status'];
    @$survey_id_cmn       =   $process_flow[0]['survey_id'];
    


    $date=date('Y-m-d');
    $form3_initiated_date=date('Y-m-d',strtotime($process_flow[0]['status_change_date']));
    $start = strtotime($form3_initiated_date);
    $end = strtotime($date);
    $days_between = ceil(abs($end - $start) / 86400);
  }

  $vessel_category_id=$result_vessel['vessel_category_id'];
  if($vessel_category_id!=0)
  {
    $vessel_category     =   $this->Survey_model->get_vessel_category($vessel_category_id);
    $data['vessel_category']  =   $vessel_category;
    $vesselcategory_name      =   $vessel_category[0]['vesselcategory_name'];
  }
  else
  {
    $vesselcategory_name="-";
  }

  $stage_count=$result_vessel['stage_count'];
  $sid=$result_vessel['sid'];

  $vessel_rejection     =   $this->Survey_model->get_vessel_rejection($vessel_sl100);
  $data['vessel_rejection']  = $vessel_rejection;
  @$reject_count= $vessel_rejection[0]['reject_count'];

  $current_status         =   $this->Survey_model->get_status_details($vessel_sl100,$survey_id100);
  $data['current_status'] =   $current_status;
  //print_r($current_status);

  @$status_id             =   $current_status[0]['current_status_id'];
  @$sending_user_id       =   $current_status[0]['sending_user_id'];
  @$receiving_user_id     =   $current_status[0]['receiving_user_id'];
  @$process_id_status     =   $current_status[0]['process_id'];
  @$status_details_sl     =   $current_status[0]['status_details_sl'];


  $survey_name       = $this->Survey_model->get_survey_name($sid);
  $data['survey_name']  =   $survey_name;
  if(!empty($survey_name)){
  $survey_name=$survey_name[0]['survey_name'];
  }
  else
  {
  //$survey_name=""; 
    if($process_id_status==14)
    {
      $survey_name="Registration";
    }
    elseif($process_id_status==16) {
      $survey_name="Registration";
    }
    elseif($process_id_status==38) {
      $survey_name="Name change";
    }
    elseif ($process_id_status==39) {
       $survey_name="Ownership change";
    } 
    elseif ($process_id_status==40) {
       $survey_name="Transfer of vessel";
    }
    elseif ($process_id_status==41) {
       $survey_name="Duplicate certificate";
    }
    elseif ($process_id_status==42) {
       $survey_name="Renewal of registration certificate";
    }
    elseif ($process_id_status==31) {
       $survey_name="Additional payment";
    }
    else { $survey_name="";}
  }


  $user_type_details           =   $this->Survey_model->get_user_master($receiving_user_id);
  $data['user_type_details']    =   $user_type_details;
  @$usertype_name =$user_type_details[0]['user_type_type_name'];

  $user_type_details1           =   $this->Survey_model->get_user_master($sending_user_id);
  $data['user_type_details1']    =   $user_type_details1;
  @$usertype_name_from =$user_type_details1[0]['user_type_type_name'];

  //_____________________Status Display_______________________________________________________//

  if($status_id=='' || $status_id==1)
  {
  $message='<span class="badge badge-info">Payment verification</span>';
  }

  if($status_id==2)
  {
  $message='<span class="badge badge-info">Forwarded to '.$usertype_name.'</span>';
  }
  if($status_id==3)
  {
  $message='<span class="badge badge-info">Application Rejected</span>';
  }

  if($status_id==4)
  {
  $message='<span class="badge badge-info">Revert from '.$usertype_name_from.'</span>';
  }
  if($status_id==5)
  {
  $message='<span class="badge badge-info">Approved</span>';
  }

  if($status_id==6)
  {
  $message='<span class="badge badge-info">Approved & Forward</span>';
  }
  if($status_id==7)
  {
  $message='<span class="badge badge-info">Survey Intimation Send</span>';
  }

  if($process_id_status==1 && $status_id==7)
  {
  $message='<span class="badge badge-info">Payment verified</span>';
  }

  if($process_id_status==16 && $status_id==7 && $survey_id==0)
  {
  $message='<span class="badge badge-info">Registration Intimation</span>';
  }

  /*if($status_id==7 && $survey_id==0)
  {
  $message='<span class="badge badge-info">-</span>';
  }*/


  if($status_id==2 && $process_id_status==2)
  {
  $message='<span class="badge badge-info">Started</span>';
  }

  if($status_id==2 && $process_id_status==3)
  {
  $message='<span class="badge badge-info">Started</span>';
  }
  if(($status_id==2 && $process_id_status==4) || ($status_id==1 && $process_id_status==5) || ($status_id==2 && $process_id_status==6) || ($status_id==1 && $process_id_status==8) || ($status_id==1 && $process_id_status==9)  || ($status_id==1 && $process_id_status==10))
  {
  $message='<span class="badge badge-info">Started</span>';
  }

  if($process_id_status==21 && $status_id==1)
  {
  $message='<span class="badge badge-info">Started</span>';
  }

  if($process_id_status==23 && $status_id==1)
  {
  $message='<span class="badge badge-info">Started</span>';
  }
  if($process_id_status==24 && $status_id==1)
  {
  $message='<span class="badge badge-info">Started</span>';
  }


  if($status_id==7 && $process_id_status==7)
  {
  $message='<span class="badge badge-info">PC verified</span>';
  }

  /*  if($status_id==7 && $process_id_status==7)
  {
  $message='<span class="badge badge-info">Defect Send</span>';
  }*/

  if($status_id==6 && $process_id_status==7)
  {
  $message='<span class="badge badge-info">Survey intimation</span>';
  }

  if($status_id==1 && $process_id_status==12)
  {
  $message='<span class="badge badge-info">Started</span>';
  }

  if($status_id==1 && $process_id_status==13)
  {
  $message='<span class="badge badge-info">Started</span>';
  }

  if($status_id==1 && $process_id_status==14)
  {
  $message='<span class="badge badge-info">Started</span>';
  }
  if($status_id==1 && $process_id_status==20)
  {
  $message='<span class="badge badge-info">Started</span>';
  }


  if($status_id==8 && $process_id_status==1)
  {
  $message='<span class="badge badge-info">Payment pending</span>';
  }

  if($status_id==8 && $process_id_status==5)
  {
  $message='<span class="badge badge-info">Payment pending</span>';
  }
  if($status_id==7 && $process_id_status==15)
  {
  $message='<span class="badge badge-info">pc verified</span>';
  }

  if($status_id==7 && $process_id_status==18)
  {
  $message='<span class="badge badge-info">Defect found</span>';
  } 
  if($status_id==1 && $process_id_status==26)
  {
  $message='<span class="badge badge-info">Payment verification</span>';
  }
  if($status_id==2 && $process_id_status==16)
  {
  $message='<span class="badge badge-info">Registration intimation</span>';
  }


  if($status_id==6 && $process_id_status==26)
  {
  $message='<span class="badge badge-info">Approved & Forward to '.$usertype_name.'</span>';
  //echo "ddgdfg";
  }

  if($status_id==1 && $process_id_status==28)
  {
  $message='<span class="badge badge-info">Forward to '.$usertype_name.'</span>';
  //echo "ddgdfg";
  }


  if($status_id==1 && $process_id_status==29)
  {
  $message='<span class="badge badge-info">Started</span>';

  }

  if($status_id==1 && $process_id_status==30)
  {
  $message='<span class="badge badge-info">Started</span>';

  }
  if($status_id==1 && $process_id_status==31)
  {
    $message='<span class="badge badge-info">Started</span>';
  }
   if($status_id==7 && $process_id_status==14)
  {
    $message='<span class="badge badge-info">PC verified</span>';
  }
  //___________________________________________Process Display_______________________________________________---//

  if($process_id_status==0)
  {
  $message1='<span class="badge badge-success">Initial</span>';
  }

  if($process_id_status==1)
  {
  $message1='<span class="badge badge-success">Form 1</span>';
  }

  if($process_id_status==1 && $status_id==8)
  {
  $message1='<span class="badge badge-success">Form 1</span>';
  }
  if($process_id_status==1 && $status_id==7)
  {
  $message1='<span class="badge badge-success">Form 1</span>';
  }

  if($process_id_status==2)

  {
  $message1='<span class="badge badge-success">Keel Laying </span>';
  }

  if($process_id_status==3)
  {
  $message1='<span class="badge badge-success">Hull Inspection</span>';
  }

  if($process_id_status==4)
  {
  $message1='<span class="badge badge-success">Final Inspection</span>';
  }

  if($process_id_status==5)
  {
  $message1='<span class="badge badge-success">Form 3</span>';
  }

  if($status_id==3)
  {
  $message1='<span class="badge badge-success">-</span>';
  }


  if($process_id_status==1 && $status_id==1)
  {
  $message1='<span class="badge badge-success">-</span>';  
  }

  if($process_id_status==5 && $status_id==2)
  {
  $message1='<span class="badge badge-success">Form 3</span>';  
  }

  if($process_id_status==6 && $status_id==2)
  {
  $message1='<span class="badge badge-success">Form 4</span>';  
  }
  if($process_id_status==6 && $status_id==7)
  {
  $message1='<span class="badge badge-success">Form 4</span>';  
  }
  if($process_id_status==7 && $status_id==7)
  {
  $message1='<span class="badge badge-success">Form 4</span>';  
  }

  if($process_id_status==7 && $status_id==1)
  {
  $message1='<span class="badge badge-success">Form 4</span>';  
  }
  if($process_id_status==7 && $status_id==2)
  {
  $message1='<span class="badge badge-success">Form 4</span>';  
  }


  if($process_id_status==8)
  {
  $message1='<span class="badge badge-success">Form 5</span>';  
  }
  if($process_id_status==9)
  {
  $message1='<span class="badge badge-success">Form 6</span>';  
  }

  if($process_id_status==10 && $status_id==2)
  {
  $message1='<span class="badge badge-success">Form 7</span>';  
  }
  if($process_id_status==10 && $status_id==5)
  {
  $message1='<span class="badge badge-success">Form 7</span>';  
  }
  if($process_id_status==10 && $status_id==1)
  {
  $message1='<span class="badge badge-success">Form 7</span>';  
  }

  if($process_id_status==11 )
  {
  $message1='<span class="badge badge-success">Form 8</span>';  
  }
  if($process_id_status==12 )
  {
  $message1='<span class="badge badge-success">Form 9</span>';  
  }
  if($process_id_status==13 )
  {
  $message1='<span class="badge badge-success">Form 10</span>';  
  }
  if($process_id_status==14 )
  {
  $message1='<span class="badge badge-success">Registration</span>';  
  }
  if($process_id_status==15 )
  {
  $message1='<span class="badge badge-success">Form2</span>';  
  }
  if($process_id_status==17 )
  {
  $message1='<span class="badge badge-success">Form4</span>';  
  }

  if($process_id_status==18 )
  {
  $message1='<span class="badge badge-success">Form4</span>';  
  }
  if($process_id_status==19)
  {
  $message1='<span class="badge badge-success">Form5</span>';  
  }
  if($process_id_status==20)
  {
  $message1='<span class="badge badge-success">Form6</span>';  
  }

  if($process_id_status==21 && $status_id==2)
  {
  $message1='<span class="badge badge-success">Form 7</span>';  
  }
  if($process_id_status==21 && $status_id==5)
  {
  $message1='<span class="badge badge-success">Form 7</span>';  
  }
  if($process_id_status==21 && $status_id==1)
  {
  $message1='<span class="badge badge-success">Form 7</span>';  
  }


  if($process_id_status==22 )
  {
  $message1='<span class="badge badge-success">Form 8</span>';  
  }

  if($process_id_status==23 )
  {
  $message1='<span class="badge badge-success">Form 9</span>';  
  }
  if($process_id_status==24 )
  {
  $message1='<span class="badge badge-success">Form 10</span>';  
  }

  if($process_id_status==24 && $survey_id==0)
  {
  $message1='<span class="badge badge-success"></span>';  
  }

  if($process_id_status==25)
  {
  $message1='<span class="badge badge-success">Annual survey</span>';
  }  
  if($process_id_status==26 )
  {
  $message1='<span class="badge badge-success">Drydock survey</span>';
  }
  if($process_id_status==27 )
  {
  $message1='<span class="badge badge-success">Drydock survey certificate</span>';
  }


  if($process_id_status==16)
  {
  $message1='<span class="badge badge-success">Form13</span>';  
  }
  if($process_id_status==28)
  {
  $message1='<span class="badge badge-success">Special survey </span>';  
  }

  if($process_id_status==29 && $status_id==1)
  {
  $message1='<span class="badge badge-success">Annual survey</span>';  
  }


  if($process_id_status==30 && $status_id==1)
  {
  $message1='<span class="badge badge-success">Drydock survey</span>';  
  }

  if($process_id_status==38)
  {
  $message1='<span class="badge badge-success">Form 11</span>';  
  }
  if($process_id_status==39)
  {
  $message1='<span class="badge badge-success">Form --</span>';  
  }
  if($process_id_status==40)
  {
  $message1='<span class="badge badge-success">Form --</span>';  
  }


  if($process_id_status==41)
  {
  $message1='<span class="badge badge-success">Duplicate certificate</span>';  
  }
  if($process_id_status==42)
  {
  $message1='<span class="badge badge-success">Renewal of registration</span>';  
  }
  if($process_id_status==31)
  {
  $message1='<span class="badge badge-success">Additional payment</span>';  
  }

  /* $form_number           =   $this->Survey_model->get_form_number($process_id);
  $data['form_number']    =   $form_number;
  @$form_no =$form_number[0]['form_no'];*/

  // if($survey_id!=0) {
  $form_number           =   $this->Survey_model->get_form_number($vessel_sl100); //print_r($form_number);
  $data['form_number']    =   $form_number;
  if (!empty($form_number)) {
  @$form_no =$form_number[0]['form_no'];
  }
  else
  {
  @$form_no =0;
  }

  // }


  $vessel_sl1 = $this->encrypt->encode($vessel_sl100); 
  $vessel_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

  $survey_id1 = $this->encrypt->encode($survey_id100); 
  $survey_id1=str_replace(array('+', '/', '='), array('-', '_', '~'), $survey_id1);

  if(!empty($survey_id_cmn)) {

  $survey_id = $this->encrypt->encode($survey_id_cmn); 
  $survey_id=str_replace(array('+', '/', '='), array('-', '_', '~'), $survey_id);
  }
  else
  {
  $survey_id="";
  }

  if(!empty($processflow_sl2)) {
  $processflow_sl1 = $this->encrypt->encode($processflow_sl2); 
  $processflow_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $processflow_sl1);
  }
  else
  {
    $processflow_sl="";
  }

  if(!empty($survey_defects_sl1)) {
  $survey_defects_sl = $this->encrypt->encode($survey_defects_sl1); 
  $survey_defects_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $survey_defects_sl);
  }
  else
  {
  $survey_defects_sl="";
  }

  if(!empty($status_details_sl)) {
  $status_details_sl1 = $this->encrypt->encode($status_details_sl); 
  $status_details_sl1=str_replace(array('+', '/', '='), array('-', '_', '~'), $status_details_sl1);
  }
  else
  {
  $status_details_sl1="";
  }

  if(!empty($processflow_id_owner)) {
  $processflow_id_owner1 = $this->encrypt->encode($processflow_id_owner); 
  $processflow_id_owner1=str_replace(array('+', '/', '='), array('-', '_', '~'), $processflow_id_owner1);
  }
  else
  {
  $processflow_id_owner1="";
  }
  //echo $processflow_sl2.'--'.$vessel_sl100.'<br>';

  ?>
  <tr>
  <td><?php echo $i; ?><input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>"></td>
  <td><?php echo $reference_number; ?><!-- '_____'.$vessel_sl100;  --></td>
  <td><?php echo $result_vessel['vessel_name'];?> </td>
   <td><?php echo $survey_name; ?></td>
  <td><?php if($form_no) { echo  'Form '.$form_no; } else { echo ""; }  ?></td>
  <td><?php echo $message1; ?><!-- $process_id_status --></td>
  <td><?php echo $message; ?><!-- $status_id --></td>
  <td> 
  <?php 

  // if(($process_id==1 || $process_id==2 || $process_id==3 || $process_id==4) && $stage_count==8 ) && $status==1

  if(($process_id_status==1 || $process_id_status==2 || $process_id_status==3 || $process_id_status==4)  && $stage_count==8 && ($user_id==$sess_usr_id))
  {
  ?>
  <?php if($status==1) { ?>  
  <!-- <a href="<?php //echo $site_url.'/Survey/Edit_Vessel/'.$vessel_sl.'/'.$stage_count; ?>"><button type="button" class="btn btn-primary btn-flat btn-sm"> <i class="fas fa-pen"></i> <small>Edit</small> </button></a> 
  &nbsp;  -->
  <?php //echo $user_id; ?><a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/Forward_Vessel/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>">
  <button type="button" class="btn btn-danger btn-flat btn-sm"> <i class="fas fa-arrow-circle-right"></i> <small> Confirmation </small></button></a> 



  <?php
  }
  else 
  {
  if($reject_count==0)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/View_Vessel/'.$vessel_sl ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm"> <i class="far fa-newspaper"></i> <small>View </small></button></a> 
  <?php
  }
  } 
  }
  if($process_id_status==5 && $status_id==1 && $days_between < 185)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/Add_Form3/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> Form 3 <?php //echo $days_between; ?></small> </button></a> 
  <?php
  }
  if($process_id_status==6 && $status_id==7 && $processflow_id_owner1!="" && ($user_id==$sess_usr_id))
  { 
   ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/surveyIntimation/'.$vessel_sl.'/'.$processflow_id_owner1.'/'.$survey_id1 ?>">
  <button type="button" class="btn btn-success btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> Confirmation </small> </button></a> 
  <?php
  }
if($process_id_status==6 && $status_id==7 && ($user_id==$sess_usr_id))
  { 
    
 ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/surveyIntimation/'.$vessel_sl.'/'.$survey_id1 ?>">
  <button type="button" class="btn btn-success btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> View </small> </button></a> 
  <?php
  }

  if($process_id_status==17 && $status_id==7 && ($user_id==$sess_usr_id))
  { 
    
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/surveyIntimation/'.$vessel_sl.'/'.$survey_id1 ?>">
  <button type="button" class="btn btn-success btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> View </small> </button></a> 
  <?php
  }

  //  if($process_id_status==7 && $status_id==2)
  if(($process_id_status==7 && $status_id==2 && $processflow_sl!="" && ($user_id==$sess_usr_id)) || ($process_id_status==7 && $status_id==7 && $processflow_sl!="" && ($user_id==$sess_usr_id)))
  {

  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/DefectDetails/'.$vessel_sl.'/'.$survey_defects_sl.'/'.$survey_id1.'/'.$processflow_sl ?>">
  <button type="button" class="btn btn-secondary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> View Defect</small> </button></a> 
  <?php
  }

  if($process_id_status==15 && $status_id==4)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/Forward_Vessel_form2/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>">
  <button type="button" class="btn btn-danger btn-flat btn-sm"> <i class="fas fa-arrow-circle-right"></i> <small> Confirmation </small></button></a> 
  <?php
  }
  if($process_id_status==10 && $status_id==1)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/form6_view/'.$vessel_sl.'/'.$survey_id1 ?>"> 
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> Form 6 View</small> </button></a> 
  <?php
  }
  if($process_id_status==10 && $status_id==5)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/form7_view/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> Form 7 Notice</small> </button></a> 
  <?php
  }
  if($process_id_status==1 && $status_id==8)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/form1_payment/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> Payment</small> </button></a> 
  <?php
  }
  if($process_id_status==5 && $status_id==8)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/form3_payment/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> Payment</small> </button></a> 
  <?php
  }

  //if($numberofdays<30 && $numberofdays!=0 && ($process_id_status==14  || $process_id_status==25))
  //if($numberofdays<30 && $numberofdays!=0)
  if($numberofdays<30 && $numberofdays!=0 && $processing_status==0)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/annual_survey/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id2 ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i>Annual survey</small> </button></a> 
  <?php
  }

  if($process_id_status==29 && $status_id==1 && $processing_status==0) 
  //if($numberofdays<30 && $numberofdays!=0)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/annual_survey/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id2 ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i>Annual survey</small> </button></a> 
  <?php
  }





  // if($process_id_status==18 && $status_id==7)
  if(($process_id_status==18 && $status_id==7) || ($process_id_status==18 && $status_id==2))
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/DefectDetails_annual/'.$vessel_sl.'/'.$survey_defects_sl.'/'.$survey_id1.'/'.$processflow_sl ?>">
  <button type="button" class="btn btn-secondary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> View Defect</small> </button></a> 
  <?php
  }if($process_id_status==21 && $status_id==5)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/form7_view_annual/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> Form 7 Notice</small> </button></a> 
  <?php
  }
  //if($numberofdays1<30 && $numberofdays1!=0 && $process_id_status==24 && $processing_status==0)
  if($numberofdays1<30 && $numberofdays1!=0 && $processing_status==0)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/drydock_survey/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id2 ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> Drydock survey</small> </button></a> 
  <?php
  }

 /* if($numberofdays1<30 && $numberofdays1!=0 && $process_id_status==27 && $processing_status==0)
  // if($numberofdays1<30 && $numberofdays1!=0 && $processing_status==0)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/drydock_survey/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id2 ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> Drydock survey</small> </button></a> 
  <?php
  }*/

  if($process_id_status==30 && $status_id==1 && $processing_status==1)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/drydock_survey/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id2 ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> Drydock survey</small> </button></a> 
  <?php
  }

  if($process_id_status==26 && $status_id==2 && ($sess_usr_id==$user_id))
  {
    
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/drydock_confirmation/'.$vessel_sl.'/'.$processflow_id_owner1.'/'.$survey_id ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i>Send confirmation</small> </button></a> 
  <?php
  }


  /*if($process_id_status==27 && $status_id==5 && $numberofdays1>30)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/drydocksurvey_certificate/'.$vessel_sl ?>" target="_blank">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i>View drydock certificate</small> </button></a> 
  <?php
  }*/

  if($status_id==2 && $process_id_status==16)
  {

  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/View_registration_intimation/'.$vessel_sl.'/'.$processflow_id_owner.'/'.$status_details_sl1 ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i>View registration intimation</small> </button></a> 
  <?php
  }
  if($status_id==4 && $process_id_status==16)
  {

  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/resend_registration_intimation/'.$vessel_sl.'/'.$processflow_id_owner.'/'.$status_details_sl1 ?>">
  <button type="button" class="btn btn-primary btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i>Registration Intimation resend</small> </button></a> 
  <?php
  }
  if($process_id_status==38 && $status_id==5)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/generate_certificate/'.$vessel_sl100?>">
  <button type="button" class="btn btn-success btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> View </small> </button></a> 
  <?php
  }  

  if($process_id_status==39 && $status_id==5)
  {
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/generate_certificate_own/'.$vessel_sl100?>">
  <button type="button" class="btn btn-success btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> View </small> </button></a> 
  <?php
  }  

  if($process_id_status==31 && $status_id==1)
  {
    //echo $status;
  ?>
  <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/additional_payment/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>">
  <button type="button" class="btn btn-success btn-flat btn-sm">  
  <small> <i class="fas fa-plus-square"></i> Pending payment </small> </button></a> 
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
<th>Ref. No</th>
<th>Vessel Name</th>
<th>Activity Type</th>
<th>Form</th>
<th>Process</th>
<th>Status</th>
<th>Action </th>
</tr>
</tfoot>  

</table>

</div>
</div>