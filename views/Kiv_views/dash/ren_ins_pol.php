<?php //$sess_usr_id  =   $this->session->userdata('user_sl'); 
$sess_usr_id    = $this->session->userdata('int_userid');?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ui-innerpage">
  <div class="row no-gutters px-5">
    <div class="col-12 px-5">
      <div class="table-responsive">
         <?php //print_r($vessel_det); 

    $date   =   date('d-m-Y');   

    foreach($vessel_det as $vessel_det_res){
      $vessel_id                = $vessel_det_res['vesselmain_vessel_id'];
      $vessel_name              = $vessel_det_res['vesselmain_vessel_name'];
      $vesselmain_reg_number    = $vessel_det_res['vesselmain_reg_number'];
      $vesselmain_reg_date      = date("d-m-Y", strtotime($vessel_det_res['vesselmain_reg_date']));
      $next_reg_renewal_date    = date("d-m-Y", strtotime($vessel_det_res['next_reg_renewal_date']));
      $vesselmain_annual_date   = date("d-m-Y", strtotime($vessel_det_res['vesselmain_annual_date']));
      $vesselmain_drydock_date  = date("d-m-Y", strtotime($vessel_det_res['vesselmain_drydock_date']));

      //_____________________get next annual survey date_____________________________//
    $process_id1    = 1;
    $subprocess_id2 = 2;
    $next_annual_details        = $this->Survey_model->get_vessel_timeline_nextdate($vessel_id,$process_id1,$subprocess_id2);
    $data['next_annual_details']= $next_annual_details;
    if(!empty($next_annual_details))
    {
      $next_annual_date         = date("d-m-Y", strtotime($next_annual_details[0]['scheduled_date']));
    }
    else
    {
      $next_annual_date   = "";
    }
   //_____________________get next drydock survey date_____________________________//
    $process_id1    = 1;
    $subprocess_id3 = 3;
    $next_drydock_details           = $this->Survey_model->get_vessel_timeline_nextdate($vessel_id,$process_id1,$subprocess_id3);
    $data['next_drydock_details']   = $next_drydock_details;
    if(!empty($next_drydock_details))
    {
      $next_drydock_date            = date("d-m-Y", strtotime($next_drydock_details[0]['scheduled_date']));
    }
    else
    {
      $next_drydock_date  = "";
    }
    //_____________________get pcb date_____________________________//
    $pollution_details              = $this->Survey_model->get_vessel_pollution($vessel_id);
    $data['pollution_details']      = $pollution_details;
    
    if(!empty($pollution_details))
    {
      $pcb_reg_date                 = date("d-m-Y", strtotime($pollution_details[0]['pcb_reg_date']));
      $validity_of_pcb              = date("d-m-Y", strtotime($pollution_details[0]['pcb_expiry_date']));
    }
    else
    {
      $pcb_reg_date       = "";
      $validity_of_pcb    = "";
    }
        
//_____________________get insurance date_____________________________//
    $insurance_details=$this->Survey_model->get_insurance_details($vessel_id);
    $data['insurance_details']  = $insurance_details;
    if(!empty($insurance_details))
    {
      $vessel_insurance_date=date("d-m-Y", strtotime($insurance_details[0]['vessel_insurance_date']));
      $vessel_insurance_validity=date("d-m-Y", strtotime($insurance_details[0]['vessel_insurance_validity']));
    }
    else
    {
      $vessel_insurance_date="";
      $vessel_insurance_validity="";
    }
  $processflow           =   $this->Survey_model->get_processflow_vessel($vessel_id);
  $data['processflow']   =   $processflow;
  
  if(!empty($processflow))
  {
    $processflow_id     = $processflow[0]['processflow_sl'];
    $survey_id      = $processflow[0]['survey_id'];
 }
 else
 {
  $processflow_id     = 0;
    $survey_id      = 0;
 }

 $vessellist_owner=$this->Survey_model->get_vessellist_owner($vessel_id);
  $data['vessellist_owner']  = $vessellist_owner; //print_r($vessellist_owner);
  if(!empty($vessellist_owner))
  {
    $processing_status=$vessellist_owner[0]['processing_status'];
  }
  else
  {
    $processing_status="";
  }

  $status_details           =   $this->Survey_model->get_status_details_vessel_sl($vessel_id);
  $data['status_details']   =   $status_details;
  if(!empty($status_details))
  {
    $status_details_sl2=$status_details[0]['status_details_sl'];
  }

$vessel_id1 = $this->encrypt->encode($vessel_id); 
$vessel_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_id1);

$processflow_id1 = $this->encrypt->encode($processflow_id); 
$processflow_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $processflow_id1);

$survey_id1 = $this->encrypt->encode($survey_id); 
$survey_id2=str_replace(array('+', '/', '='), array('-', '_', '~'), $survey_id1);


 $status_details_sl1    = $this->encrypt->encode($status_details_sl2); 
$status_details_sl     = str_replace(array('+', '/', '='), array('-', '_', '~'), $status_details_sl1);


  ?>
  <div class="alert bg-darkcyan btn-point">
   <p class="counterfont "> Registration Number   :  <?php echo $vesselmain_reg_number.' ( '.$vessel_name.' )';?> </p>
  </div>
  <table class="table table-striped table-hover table-sm">
            <thead class="bg-light-blue">
              <tr>
                <th scope="col"></th>
                <th scope="col" class="counterfont"> <strong>  <em> Previous renewal date </em></th>
                <th scope="col" class="counterfont"> <strong>  <em> Next renewal date </em></th>
                  <th> </th>
              </tr>
            </thead>
            <tbody class="bcontentfont">
              <tr class="">
                <td class="pl-4 text-midnightblue "><strong>   <em>  Registration </em></strong> </td>
                <td class="text-olive"><strong> <?php echo $vesselmain_reg_date; ?> </strong></td>
                <td class="<?php if(strtotime($date) < strtotime($next_reg_renewal_date)) {?>text-fuchsia<?php } else {?>text-crimson<?php } ?>"><strong><?php echo $next_reg_renewal_date; ?> </strong></td>

               <!--  <td> <?php if(strtotime($date) < strtotime($next_reg_renewal_date) && $processing_status==0) { ?>  <?php } else {?> <a href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/send_renewal_application/'.$vessel_sl.'/'.$processflow_sl.'/'.$status_details_sl;?>" >
                  <button class="btn btn-flat btn-point btn-sm bg-chocolate"><i class="fas fa-rupee-sign"></i> &nbsp; Renew </button></a> <?php } ?></td> -->

                    <td><?php 
                    if((strtotime($date) < strtotime($next_reg_renewal_date)) && $processing_status==1) 
                      { echo ""; ?>  <?php } 
                    elseif((strtotime($date) > strtotime($next_reg_renewal_date)) && $processing_status==0) { ?> <a href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/send_renewal_application/'.$vessel_sl.'/'.$processflow_sl.'/'.$status_details_sl ?>"><button class="btn btn-flat btn-point btn-sm bg-chocolate"><i class="fas fa-rupee-sign"></i> &nbsp; Renew </button> </a> <?php } 
                    elseif ((strtotime($date) < strtotime($next_reg_renewal_date)) && $processing_status==0){ echo ""; } 
                    elseif ((strtotime($date) > strtotime($next_reg_renewal_date)) && $processing_status==1) { echo "Another process"; }
                     ?>

               </td>


              </tr>
              <tr class="">
                <td class="pl-4 text-midnightblue"> <strong>  <em> Annual Survey </em> </strong></td>
                <td class="text-olive"><strong><?php echo $vesselmain_annual_date; ?> </strong></td>
                <td class="<?php if(strtotime($date) < strtotime($next_annual_date)) {?>text-fuchsia<?php } else {?>text-crimson<?php } ?>"><strong><?php echo $next_annual_date; ?></strong></td>

               <!--  <td> <?php if((strtotime($date) < strtotime($next_annual_date)) && $processing_status==0) { ?>  <?php } else { ?>
                 <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/annual_survey/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id2 ?>"><button class="btn btn-flat btn-point btn-sm bg-chocolate"><i class="fas fa-rupee-sign"></i> &nbsp; Renew </button> </a> <?php } ?>
               </td> -->

               <td> <?php if((strtotime($date) < strtotime($next_annual_date)) && $processing_status==1) { echo ""; ?>  <?php } elseif((strtotime($date) >strtotime($next_annual_date)) && $processing_status==0)  {  ?>
                 <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/annual_survey/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id2 ?>"><button class="btn btn-flat btn-point btn-sm bg-chocolate"><i class="fas fa-rupee-sign"></i> &nbsp; Renew </button> </a> <?php } elseif ((strtotime($date) < strtotime($next_annual_date)) && $processing_status==1){ echo ""; } ?>
               </td>



              </tr>
               <tr class="">
                <td class="pl-4 text-midnightblue"> <strong>  <em> Drydock Survey  </em> </strong></td>
                <td class="text-olive"><strong><?php echo $vesselmain_drydock_date; ?> </strong></td>
                <td class="<?php if(strtotime($date) < strtotime($next_drydock_date)) {?>text-fuchsia<?php } else {?>text-crimson<?php } ?>"><strong><?php echo $next_drydock_date; ?></strong> 
                </td>

               <!--  <td> <?php if((strtotime($date) < strtotime($next_drydock_date)) && $processing_status==0) {  ?>  <?php } else { ?> <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/drydock_survey/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id2 ?>"><button class="btn btn-flat btn-point btn-sm bg-chocolate"><i class="fas fa-rupee-sign"></i> &nbsp; Renew </button></a> <?php } ?></td> -->

                <td> <?php if((strtotime($date) < strtotime($next_drydock_date)) && $processing_status==1) { echo ""; ?>  <?php } elseif((strtotime($date) >strtotime($next_drydock_date)) && $processing_status==0)  {  ?>
                 <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/drydock_survey/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id2 ?>"><button class="btn btn-flat btn-point btn-sm bg-chocolate"><i class="fas fa-rupee-sign"></i> &nbsp; Renew </button> </a> <?php } elseif ((strtotime($date) < strtotime($next_drydock_date)) && $processing_status==1){ echo ""; } ?>
               </td>

              </tr>
              <tr class="">
                <td class="pl-4 text-midnightblue"> <strong>  <em> Pollution control  </em> </strong></td>
                <td class="text-olive"><strong><?php echo $pcb_reg_date; ?> </strong></td>
                <td class="<?php if(strtotime($date) < strtotime($validity_of_pcb)) { ?>text-fuchsia<?php } else {?>text-crimson<?php } ?>"><strong><?php echo $validity_of_pcb; ?></strong> </td>
                <td> <?php if(strtotime($date) < strtotime($validity_of_pcb)) {?>  <?php } else {?> 
                  <a href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/renewal_pollution/'.$vessel_sl.'/'.$processflow_sl.'/'.$status_details_sl;?>"><button class="btn btn-flat btn-point btn-sm bg-chocolate"><i class="fas fa-rupee-sign"></i> &nbsp; Renew </button> </a>
                  <?php } ?></td>
              </tr>
               <tr class="">
                <td class="pl-4 text-midnightblue"> <strong>  <em> Insurance  </em> </strong></td>
                <td class="text-olive"><strong><?php echo $vessel_insurance_date; ?> </strong></td>
                <td class="<?php if(strtotime($date) < strtotime($vessel_insurance_validity)) {?> text-fuchsia <?php } else {?>text-crimson <?php } ?>"><strong><?php echo $vessel_insurance_validity; ?></strong> </td>
                <td> <?php if(strtotime($date) < strtotime($vessel_insurance_validity)) {?>  <?php } else {?> 
                  <a href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/send_insurance_application/'.$vessel_sl.'/'.$processflow_sl.'/'.$status_details_sl;?>">
                    <button class="btn btn-flat btn-point btn-sm bg-chocolate"><i class="fas fa-rupee-sign"></i> &nbsp; Renew </button> </a><?php } ?> </td>
              </tr>
              </tbody>
            </table>
              <?php } ?>
      </div> <!-- end of table div -->
    </div>  <!-- end of col12 -->
  </div> <!-- end of row -->
</div> <!-- end of main content -->