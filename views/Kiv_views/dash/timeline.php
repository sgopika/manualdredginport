<?php 
$moduleid        = 2;
$modenc          = $this->encrypt->encode($moduleid); 
$modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');
?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==3) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome/<?php echo $modidenc;?>"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==14) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==11) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ui-innerpage">
<!-- <form name="form1" method="post" action=""> -->

<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/timeline", $attributes);
?>


 <div class="row p-1">
 <div class="col-4 d-flex justify-content-end">Select vessel</div>
<div class="col-4 d-flex justify-content-start">
<select class="form-control btn-point js-example-basic-single select2" name="vessel_id" id="vessel_id"  required>
    <option value="">Select</option>
      <?php foreach($vessel_details as $res_vessel_details) { ?>
      <option value="<?php echo $res_vessel_details['vessel_sl']?>"><?php echo $res_vessel_details['vessel_name']; ?><?php if(!empty($res_vessel_details['vessel_registration_number'])) { echo "---".$res_vessel_details['vessel_registration_number']; } ?></option>
    <?php } ?></select>
</div>  
<div class="col-4 d-flex justify-content-start"><input type="submit" value="Submit" class="btn bg-purple-active btn-flat  btn-point btn-md" name="btnsubmit" id="btnsubmit"  ></div> 
</div>  
<!-- </form> --> <?php echo form_close(); ?>
<?php if(!empty($slt_processflow))
{
   $vessel_id             = $slt_processflow[0]['vessel_id'];
   $vessel_name           = $this->Survey_model->get_vessel_name_timeline($vessel_id);
    $data['vessel_name']  = $vessel_name;
?>
<div class="row p-2 justify-content-center">
  <div class="col-8 px-5 text-center">
    <div class="alert px-2 bg-fuchsia-active" role="alert">
    <?php echo $vessel_name[0]['vessel_name'].'---'.$vessel_name[0]['vessel_registration_number']; ?>
  </div> 
  </div> <!-- end of col12 -->
</div> <!-- end of row -->
  

<div class="row p-1">

  <div class="col-md-12 p-2">
    
            <div class="main-timeline pl-3">
              <?php foreach ($slt_processflow as $key ) 
        {
          $status_change_date   = $key['status_change_date']; 
          $current_status_id    = $key['current_status_id']; 
          $process_id_status    = $key['process_id'];
          $survey_id            = $key['survey_id'];
          $user_id              = $key['user_id'];
           /*____________________________get process name_______________________*/
          $process         =   $this->Survey_model->get_process_name($process_id_status);
          $data['process'] =   $process;
          if(!empty($process))
          {
            $process_name   =   $process[0]['process_name'];
          }
          else
          {
            $process_name  ="";
          }
        /*____________________________get activity name_______________________*/
        $survey_name       = $this->Survey_model->get_survey_name($survey_id);
        $data['survey_name']  =   $survey_name;
        if(!empty($survey_name))
        {
          $survey_name=$survey_name[0]['survey_name'];
        }
        else
        {
          if($process_id_status==14)
          {
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
          else { $survey_name="";}
        }

         /*____________________________get Form number details_______________________*/

          $form_number_cs=  $this->Survey_model->get_form_number_cs($process_id_status);
          $data['form_number_cs']     =   $form_number_cs;
          if(!empty($form_number_cs))
          {
             $formnumber=$form_number_cs[0]['form_no'];
          }
          else
          {
            $formnumber=0;
          }
          if($formnumber!=0)
          {
             $form_payment_details=$this->Survey_model->get_form3_tariff($vessel_id,$survey_id,$formnumber);
          $data['form_payment_details']  =   $form_payment_details;
          
          if(!empty($form_payment_details))
          {
           $form_payment_amount=$form_payment_details[0]['dd_amount'];
           $form_payment_date=date("d-m-Y", strtotime($form_payment_details[0]['dd_date']));
          }
          else
          {
          $form_payment_amount=0;
          $form_payment_date="";
          }
          }
         

         /*____________________________get user details_______________________*/
          $user_details=$this->Survey_model->get_user_master($user_id);
          $data['user_details']=$user_details;
          if(!empty($user_details))
          {
            $iniated_approved_username=$user_details[0]['user_master_fullname'];
            $iniated_approved_usertype=$user_details[0]['user_type_type_name'];
          }
          else
          {
            $iniated_approved_username="";
            $iniated_approved_usertype="";
          }

        /*____________________________get details_______________________*/

        if($current_status_id ==1) //Process Initated
        {
            $heading1     = "Issue date";
            $date         = date("d-m-Y", strtotime($status_change_date));
            $heading2     = "";
            $heading3     = "Amount to be payed :".$form_payment_amount ;
            $heading4     = "Payment date :".$form_payment_date;
        }
        if($current_status_id ==5) //Process Approved
        {

          $heading1   = "Approved date";
          $date       = date("d-m-Y", strtotime($status_change_date));
          $name       = $iniated_approved_username;
          $heading2   = "Approved by :" .$name;
          $heading3   = "";
          $heading4   = "";
        }
  ?>
            <div class="timeline">
                    <a href="#" class="timeline-content">
                        <div class="timeline-year">
                            <span><?php echo $heading1; ?> : <?php echo $date; ?></span>
                        </div>
                        <div class="timeline-icon">
                         <i class="fas fa-bell"></i>
                        </div>
                        <div class="inner-content">
                            <h3 class="title"><?php echo $process_name; ?>  &nbsp;-&nbsp; <?php echo $survey_name; ?> 
                          </h3>
                            <p class="description">
                                <?php echo $heading2; ?><br>
                                <?php echo $heading3; ?><br>
                                <?php echo $heading4; ?><br>
                            </p>
                        </div> <!-- end of inner content -->
                    </a>
                </div> <!-- end of timeline -->
                    <?php }  ?>
            </div> <!-- end of main-timeline div -->
        </div> <!-- end of col 12 -->
</div> <!-- end of row -->
<?php } ?>
</div> <!-- end of main content container div -->