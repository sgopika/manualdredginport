<?php  
//$sess_usr_id  =   $this->session->userdata('user_sl'); 
$sess_usr_id    = $this->session->userdata('int_userid');
?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="col-12"> 
    <div class="row">
      <div class="col-2 mt-1 ml-5">
         <button type="button" class="btn btn-primary kivbutton btn-block"> Form 12 List</button> 
      </div> <!-- end of col-2 -->
     <!--  <div class="col mt-2 text-primary">
        List of Applications for registration 
      </div> -->
    </div> <!-- inner row -->
</div> <!-- end of col-12 add-button header --> 
<div class="main-content ui-innerpage">
  <div class="table-responsive">
 <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
        <thead>
          <tr><th colspan="7"><font size="4">List of Applications for registration</font></th></tr>
            <tr>
                  <th>#</th>
                  <th>Vessel Name</th>
                  <th>Ref. No</th>
                  <th>Vessel Type</th>
                  <th>Form</th>
                  <th>Certificate of Survey Created Date</th>
                  <th>Proceed to registration</th>
            </tr>
        </thead>
        <tbody>
  <?php
  $i=1;
  //@$customer_name1=$customer_details1[0]['user_name'];

  foreach($initial_data as $res1)
  {
  $vessel_sl2             = $res1['vessel_sl'];
  $vessel_type_id        = $res1['vessel_type_id'];
  $processflow_sl2        = $res1['processflow_sl'];
  $current_status_id     = $res1['current_status_id'];
  $status                = $res1['status'];
   
  $process_id            = $res1['process_id'];
  $survey_id             = $res1['survey_id'];

  $vessel_type_name      = $res1['vesseltype_name'];
  $form_name             = $res1['process_name'];                  

  $declaration_issue_date=date("d-m-Y", strtotime($res1['declaration_issue_date']));                 

  /*$current_status        =  $this->Survey_model->get_status_details($vessel_sl,$survey_id);
  $data['current_status']=  $current_status;*/
  //$status_details_sl =$current_status[0]['status_details_sl'];

  /*helper function*/
  $current_status        =  $this->Survey_model->get_status_details($vessel_sl2,$survey_id);//print_r($current_status);

  foreach ($current_status as  $value) 
  {
    $status_details_sl2 = $value['status_details_sl'];
    /*echo $status_id         = "status_id=".$value['current_status_id'];
    echo $sending_user_id   = "sending_user_id=".$value['sending_user_id'];
    echo $receiving_user_id = "receiving_user_id=".$value['receiving_user_id'];
    echo $process_id_status = "process_id_status=".$value['process_id'];"<br>";*/                    
  }

  $vessel_sl1 = $this->encrypt->encode($vessel_sl2); 
  $vessel_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

  $processflow_sl1 = $this->encrypt->encode($processflow_sl2); 
  $processflow_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $processflow_sl1);

  $status_details_sl1 = $this->encrypt->encode($status_details_sl2); 
  $status_details_sl=str_replace(array('+', '/', '='), array('-', '_', '~'), $status_details_sl1);

//Processing status starting

$get_processing_status           =   $this->Survey_model->get_processing_status($vessel_sl2);
$data['get_processing_status']   =   $get_processing_status;
if(!empty($get_processing_status))
{
  $processing_status=$get_processing_status[0]['processing_status'];
}
else
{
  $processing_status=0;
}

  $status_details     =   $this->Survey_model->get_form_number($vessel_sl2);
    $data['status_details'] = $status_details;
    if(!empty($status_details))
    {
       $process_name     =   $status_details[0]['process_name'];

    }
    else
    {
       $process_name     ="another";
    }

$process="This vessel is in ". $process_name. " processing...";
//Processing status ending 




  ?>
                
                <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $res1['vessel_name']; ?></td>
                <td><?php echo $res1['reference_number']; ?></td>
                <td><?php echo $vessel_type_name; ?></td>
                <td><?php echo $form_name;?></td>
                <td><?php echo $declaration_issue_date; ?> </td>
                <td>
                <?php if($process_id==14 && $current_status_id==1 && $processing_status==0) { ?>
                <!--<a href="<?php //echo $site_url.'/Survey/csTask/'.$vessel_sl.'/'.$processflow_sl.'/'.$survey_id  ?>" class="btn btn-danger btn-xs">Verify</a>-->
                <a href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/form12/'.$vessel_sl.'/'.$processflow_sl.'/'.$status_details_sl;?>" class="btn btn-danger btn-xs">Proceed to registration</a>
                <?php
              }     else { echo $process; }   
                
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
                  <th>Form</th>
                  <th>Certificate of Survey Created Date</th>
                  <th>Proceed to registration</th>
            </tr>
        </tfoot>
    </table>
</div>
</div>
     <script type="text/javascript">
  $(document).ready(function() {
          $('.select2').select2({ width:'100%' });
      });

  (function($){ 
  $('.dob').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
  });
  
})(jQuery);


 </script>