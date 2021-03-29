<?php //$sess_usr_id  =   $this->session->userdata('user_sl'); 
$sess_usr_id  =   $this->session->userdata('int_userid');
      ?>
<div class="ui-innerpage">
 <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
        <thead>
          <tr><th colspan="10"><font size="4">Requests</font></th></tr>
            <tr>
                <th>#</th>
                  <th>Vessel Name</th>
                  <th>Ref. No</th>
                  <th>Vessel Type</th>
                  <th>Owner Name</th>
                  <th>Form</th>
                  <th>Activity Type</th>
                  <th>Forward Date</th>
                  <th>Process</th>
                  <th>Verify</th>
            </tr>
        </thead>
        <tbody>
            <?php
               $i=1;
               // hhhhhhhhhhhh
                
                foreach($initial_data as $res)
                {
                  //print_r($initial_data);
                  $vessel_sl2        = $res['vessel_sl'];
                  $vessel_type_id   = $res['vessel_type_id'];


                  $process_flow         =   $this->Survey_model->get_process_flow_show($vessel_sl2, $sess_usr_id);

                  $data['process_flow'] =   $process_flow;
                              //print_r($process_flow);
                  if(!empty($process_flow)) 
                  {
                    $current_status_id    =   $process_flow[0]['current_status_id'];
                  $processflow_sl2       =   $process_flow[0]['processflow_sl'];
                  
                  $status               =   $process_flow[0]['status'];

                  @$process_id          =   $process_flow[0]['process_id'];
                  @$survey_id2           =   $process_flow[0]['survey_id'];
                  }
                  


                  $get_vessel_created_user         =   $this->Survey_model->get_vessel_created_user($vessel_sl2);
                  $data['get_vessel_created_user'] =   $get_vessel_created_user;

                  @$customer_name=$get_vessel_created_user[0]['user_name'];

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

                  $application_date=date("d-m-Y", strtotime($res['status_change_date']));
                 // $processflow_sl=$res['processflow_sl'];
                $processflow_id=$res['processflow_sl'];

                  $process_name       = $this->Survey_model->get_process_name($process_id);
                  $data['process_name']   =   $process_name;
                   $process=$process_name[0]['process_name'];

                  $survey_name      = $this->Survey_model->get_survey_name($survey_id2);
                  $data['survey_name']  =   $survey_name;
                  if(!empty($survey_name))
                  {
                    $survey=$survey_name[0]['survey_name'];
                  }
                  else
                  {
                    $survey="";
                  }
                  


                  //Status display

                //$current_status         =   $this->Survey_model->get_status_details($vessel_sl2,$survey_id2);
                  $current_status         =   $this->Survey_model->get_status_details_vessel_sl($vessel_sl2);
                $data['current_status'] =   $current_status;


                 if(!empty($current_status))
                {
                  
                  $status_details_sl =$current_status[0]['status_details_sl'];
                }

                @$status_id=$current_status[0]['current_status_id'];
                @$sending_user_id=$current_status[0]['sending_user_id'];
                @$receiving_user_id=$current_status[0]['receiving_user_id'];
                @$process_id_status=$current_status[0]['process_id'];


                $user_type_details           =   $this->Survey_model->get_user_master($receiving_user_id);
                $data['user_type_details']    =   $user_type_details;
                @$usertype_name =$user_type_details[0]['user_type_type_name'];

                $form_number           =   $this->Survey_model->get_form_number_cs($process_id);
                $data['form_number']    =   $form_number;
                $cs_fm_no=   $form_number[0]['form_no'];
              

                if($process_id_status==1)
                {
                  $message1='<span class="badge badge-success">Form 1 payment</span>';
                }
                   if($process_id_status==5)
                {
                  $message1='<span class="badge badge-success">Form 3 payment</span>';
                }

             
                if($process_id_status==7)
                {
                  $message1='<span class="badge badge-success">Form 4 payment</span>';
                }

                if($process_id_status==15)
                {
                  $message1='<span class="badge badge-success">Form 2 payment</span>';
                }
                if($process_id_status==18)
                {
                  $message1='<span class="badge badge-success">Form 4 payment</span>';
                }

                if($process_id_status==14)
                {
                  $message1='<span class="badge badge-success">Registration</span>';
                }
                if($process_id_status==38)
                {
                  $message1='<span class="badge badge-success">Name Change payment</span>';
                }
                if($process_id_status==39)
                {
                  $message1='<span class="badge badge-success">Ownership Change<br/> payment</span>';
                }
                if($process_id_status==40)
                {
                  $message1='<span class="badge badge-success">Transfer Vessel<br/> payment</span>';
                }
                 if($process_id_status==41)
                {
                  $message1='<span class="badge badge-success">Duplicate Certificate<br/> payment</span>';
                }
                if($process_id_status==42)
                {
                  $message1='<span class="badge badge-success">Renewal of registration</span>';
                }

                  if($process_id_status==26)
                {
                  $message1='<span class="badge badge-success">Drydock</span>';
                }
              /*
              if($process_id_status==3)
                {
                  $message1='<span class="badge badge-success">Hull Inspection</span>';
                }
                 if($process_id_status==4)
                {
                  $message1='<span class="badge badge-success">Final Inspection</span>';
                }

               

                 if($process_id_status==8)
                {
                  $message1='<span class="badge badge-success">Form 5 Verification</span>';
                }

                 if($process_id_status==9)
                {
                  $message1='<span class="badge badge-success">Form 6 Verification</span>';
                }

                  if($process_id_status==11)
                {
                  $message1='<span class="badge badge-success">Form 8 application</span>';
                }
                  if($process_id_status==12)
                {
                  $message1='<span class="badge badge-success">Form 9 application</span>';
                }

                 if($process_id_status==13)
                {
                  $message1='<span class="badge badge-success">Form 10 application</span>';
                }*/
                

                 if($process_id==1 || $process_id==2 || $process_id==3 || $process_id==4 ||  $process_id=='')
                  {
                    $form_no=1;
                  }
                  else
                  {

                    $form_no=$cs_fm_no;

                  }

$survey_name      = $this->Survey_model->get_survey_name($survey_id2);
                  $data['survey_name']  =   $survey_name;
                  if(!empty($survey_name))
                  {
                    $survey=$survey_name[0]['survey_name'];
                  }
                  else
                  {
                    $survey=$message1;
                  }

$vessel_sl1 = $this->encrypt->encode($vessel_sl2); 
$vessel_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

$survey_id1 = $this->encrypt->encode($survey_id2); 
$survey_id=str_replace(array('+', '/', '='), array('-', '_', '~'), $survey_id1);

$processflow_sl1 = $this->encrypt->encode($processflow_sl2); 
$processflow_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $processflow_sl1);

$status_details_sl1 = $this->encrypt->encode($status_details_sl); 
$status_details_sl2=str_replace(array('+', '/', '='), array('-', '_', '~'), $status_details_sl1);

                ?>
                
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $res['vessel_name']; ?></td>
                <td><?php echo $res['reference_number']; ?></td>
                <td><?php echo $vessel_type_name; ?></td>
                <td><?php echo $customer_name; ?></td>
                <td>Form&nbsp; <?php echo $form_no;?></td>
                <td><?php echo $survey; ?></td>
                <td><?php echo $application_date; ?> </td>
                <td><?php echo $message1; ?></td>
                <td>
                <?php if($status==1 && ($process_id==1 || $process_id==2 || $process_id==3 || $process_id==4 ||  $process_id=='')) { ?>
                <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/Verify_payment_pc/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-primary btn-flat btn-sm">Verify payment form <?php echo $form_no; ?></a>
                <?php
              }
              elseif($process_id==5)
              {
                ?>
                 <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/Verify_payment_pc_form3/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-primary btn-flat btn-sm">Verify payment form <?php echo $form_no; ?></a>
                <?php
              }
               elseif($process_id==7)
              {
                ?>
                 <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/Verify_payment_pc_form4/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-primary btn-flat btn-sm">Verify payment form <?php echo $form_no; ?></a>
                <?php
              }
              
               elseif($process_id==15) {
                ?>
                <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/Verify_payment_pc_form2/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-secondary btn-flat btn-sm">Verify payment form <?php echo $form_no; ?></a>
                <?php
              
              }

                elseif($process_id==18) {
                ?>
                <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/Verify_payment_pc_form4_annual/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-secondary btn-flat btn-sm">Verify payment form <?php echo $form_no; ?></a>
                <?php
              }
              elseif($process_id==26) {
                ?>
                <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/Verify_payment_pc_drydock/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-secondary btn-flat btn-sm">Verify drydock payment</a>
                <?php
              }
               elseif($process_id==14) {
                ?>
                <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/Verify_payment_pc_registration/'.$vessel_sl.'/'.$processflow_sl.'/'.$status_details_sl ?>" class="btn btn-secondary btn-flat btn-sm">Verify registration payment</a>
                <?php
              }
              /////namechange payment process
              elseif($process_id==38) {
                ?>
                <a href="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/Verify_payment_pc_form11/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-primary btn-flat btn-sm">Verify payment form <?php echo $form_no; ?></a>
                <?php
              }
              /////ownership change payment process
              elseif($process_id==39) {
                ?>
                <a href="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/Verify_payment_pc_form18/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-primary btn-flat btn-sm">Verify payment form <?php echo $form_no; ?></a>
                <?php
              }
              /////transfer vessel payment process
              elseif($process_id==40) {
                ?>
                <a href="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/Verify_payment_pc_form18_trans/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-primary btn-flat btn-sm">Verify payment form <?php echo $form_no; ?></a>
                <?php
              }
              /////duplicate certificate payment process
              elseif($process_id==41) {
                ?>
                <a href="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/Verify_payment_pc_form20/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id ?>" class="btn btn-primary btn-flat btn-sm">Verify payment form <?php echo $form_no; ?></a>
                <?php
              }
                elseif($process_id==42) {
                ?>
                <a href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/Verify_payment_pc_renewal_reg/'.$vessel_sl.'/'.$processflow_sl.'/'.$status_details_sl2 ?>" class="btn btn-primary btn-flat btn-sm">Verify payment form <?php echo $form_no; ?></a>
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
       <tfoot> <tr>
                <th>#</th>
                  <th>Vessel Name</th>
                  <th>Ref. No</th>
                  <th>Vessel Type</th>
                  <th>Owner Name</th>
                  <th>Form</th>
                  <th>Activity Type</th>
                  <th>Forward Date</th>
                  <th>Process</th>
                  <th>Verify</th>
            </tr></tfoot>
    </table>
  </div>