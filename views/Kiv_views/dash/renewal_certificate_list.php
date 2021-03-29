<?php //$sess_usr_id  =   $this->session->userdata('user_sl');
$sess_usr_id    = $this->session->userdata('int_userid'); ?>
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
      <div class="col-4 mt-1 ml-5">
         <button type="button" class="btn btn-primary kivbutton btn-block"> Registered Vessel List For Renewal of registration</button> 
      </div> <!-- end of col-2 -->
      <!-- <div class="col mt-2 text-primary">
        List of Registered Vessels 
      </div> -->
    </div> <!-- inner row -->
</div> <!-- end of col-12 add-button header --> 
<div class="main-content ui-innerpage">
  <div class="table-responsive">
 <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
        <thead>
            <tr><th colspan="9"><font size="4">Renewal of registration-Registered Vessel List</font></th></tr>
            <tr>
                  <th>#</th>
                  <th>Vessel Name</th>
                  <th>Reg. No</th>
                  <th>Vessel Type</th>
                  <th>Reg. Date</th>
                  <th>Next Renewal. Date</th>
                  <th>Proceed to Renewal</th>
            </tr>
        </thead>
        <tbody>
  <?php
  $i=1;
 
 //print_r($vessel_list);
// exit;
foreach($vessel_list as $res1)
{ 
  $vessel_sl2           = $res1['vesselmain_vessel_id'];
  $vesselmain_sl        = $res1['vesselmain_sl'];
  $processing_status    = $res1['processing_status'];

  $declaration_issue_date = date("d-m-Y", strtotime($res1['vesselmain_reg_date']));   
 
 $next_reg_renewal_date       = date('d-m-Y', strtotime($res1['next_reg_renewal_date']));   

  $date1_ts    = strtotime($declaration_issue_date);
  $date2_ts    = strtotime($next_reg_renewal_date);
  $diff        = $date2_ts - $date1_ts;
  $numberofdays= round($diff / 86400); 


$get_processflowsl     = $this->Bookofregistration_model->get_process_flow_sl($vessel_sl2);
    if(!empty($get_processflowsl)){
      $processflow_sl2     = $get_processflowsl[0]['processflow_sl'];
      $process_id          = $get_processflowsl[0]['process_id']; 
      $survey_id          = $get_processflowsl[0]['survey_id'];
    }


  $current_status        =  $this->Bookofregistration_model->get_status_details($vessel_sl2,$survey_id);
    foreach ($current_status as  $value) 
    {
      $status_details_sl2  = $value['status_details_sl'];
              
    }

   $vessel_sl1            = $this->encrypt->encode($vessel_sl2); 
    $vessel_sl1            = str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

     $status_details_sl1    = $this->encrypt->encode($status_details_sl2); 
    $status_details_sl     = str_replace(array('+', '/', '='), array('-', '_', '~'), $status_details_sl1);
    

    $processflow_sl1       = $this->encrypt->encode($processflow_sl2); 
    $processflow_sl        = str_replace(array('+', '/', '='), array('-', '_', '~'), $processflow_sl1);

  ?>
  <tr>
  <td><?php echo $i; ?></td>
  <td><?php echo $res1['vesselmain_vessel_name'];//.'____'.$vessel_sl2; ?></td>
  <td><?php echo $res1['vesselmain_reg_number']; ?></td>
  <td><?php echo $res1['vesselmain_vessel_type']; ?></td>
  <td><?php echo $declaration_issue_date; ?> </td>
  <td><?php echo $next_reg_renewal_date; ?> </td>
  <td>
     <?php 
   //if($processing_status==0 && $numberofdays<30){ 
    if($processing_status==0){
      ?>
<a href="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/send_renewal_application/'.$vessel_sl1.'/'.$processflow_sl.'/'.$status_details_sl;?>" class="btn btn-danger btn-xs">Send Application</a>
      <?php

     }
     else
     {
      echo "Vessel is another process";
      //echo "Renewal active on 30 days early";
     
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
<th>Reg. No</th>
<th>Vessel Type</th>
<th>Reg. Date</th>
 <th>Next Renewal. Date</th>
<th>Proceed to Renewal</th>
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