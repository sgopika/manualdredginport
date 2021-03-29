<?php 
$sess_usr_id            = $this->session->userdata('int_userid'); 
?>
<!-- Start of breadcrumb -->
<nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="col-12"> 
    <div class="row">
      <div class="col-4 mt-1 ml-5">
         <button type="button" class="btn btn-primary kivbutton btn-block"> Registered Vessel List For Transfer of Vessel</button> 
      </div> <!-- end of col-2 -->
    </div> <!-- inner row -->
</div> <!-- end of col-12 add-button header --> 
<div class="main-content ui-innerpage">
  <div class="table-responsive">
  <!-- <table id="example" class="display mytableheader" style="width:100%" border="0"> -->
    <table id="example" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
    <thead>
      <tr><th colspan="9"><font size="4">Transfer of Vessel-Registered Vessel List</font></th></tr>
      <tr>
        <th>#</th>
        <th>Vessel Name</th>
        <th>Reg. No</th>
        <th>Vessel Type</th>
        <th>Reg. Date</th>
        <th>Proceed to Ownership Change</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $i=1;
    foreach($vessel_list as $res1)
    { 
      $vessel_sl2                     = $res1['vesselmain_vessel_id'];
      $vesselmain_sl                  = $res1['vesselmain_sl'];
      $current_status_id              = $res1['current_status_id'];
      $processing_status              = $res1['processing_status'];
      $process_id                     = $res1['process_id'];
      $survey_id                      = $res1['survey_id'];
      $declaration_issue_date         = date("d-m-Y", strtotime($res1['vesselmain_reg_date']));                 
      /*helper function*/
      $current_status                 = $this->Vessel_change_model->get_status_details($vessel_sl2,$survey_id);

      foreach ($current_status as  $value) 
      {
        $status_details_sl2           = $value['status_details_sl'];
                
      }

      $check_ownershipchange          = $this->Vessel_change_model->check_vessel_transfer_pay($vessel_sl2,$vesselmain_sl); 
      if(!empty($check_ownershipchange)){
        foreach($check_ownershipchange as $res_chk){
          $pay_status                 = $res_chk['payment_status'];
        }
      } else { 
        $pay_status=2;
      }

      $vessel_sl1                     = $this->encrypt->encode($vessel_sl2); 
      $vessel_sl1                     = str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

      $status_details_sl1             = $this->encrypt->encode($status_details_sl2); 
      $status_details_sl              = str_replace(array('+', '/', '='), array('-', '_', '~'), $status_details_sl1);

      $get_processflowsl              = $this->Vessel_change_model->get_process_flow_sl($vessel_sl2); 
      if(!empty($get_processflowsl)){
        $processflow_sl2              = $get_processflowsl[0]['processflow_sl'];
        $process_id                   = $get_processflowsl[0]['process_id'];
      }
      $processflow_sl1                = $this->encrypt->encode($processflow_sl2); 
      $processflow_sl                 = str_replace(array('+', '/', '='), array('-', '_', '~'), $processflow_sl1);
      ?>
                
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $res1['vesselmain_vessel_name'];//.'____'.$vessel_sl2; ?></td>
        <td><?php echo $res1['vesselmain_reg_number']; ?></td>
        <td><?php echo $res1['vesselmain_vessel_type']; ?></td>
        <td><?php echo $declaration_issue_date; ?> </td>
        <td>
        <?php 
        if($processing_status==0){ 
          if(isset($pay_status)){if($pay_status==0){?>
            <a href="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/payment_details_form18_trans/'.$vessel_sl1.'/'.$processflow_sl.'/'.$status_details_sl;?>" class="btn btn-danger btn-xs">Transfer Vessel Payment Pending</a>
          <?php } else if($pay_status==2){ ?> 
            <a href="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/transfervessel/'.$vessel_sl1.'/'.$processflow_sl.'/'.$status_details_sl;?>" class="btn btn-danger btn-xs">Proceed to Transfer Vessel</a>
          <?php } else if($pay_status==1){ ?>   
            <a href="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/transfervessel/'.$vessel_sl1.'/'.$processflow_sl.'/'.$status_details_sl;?>" class="btn btn-danger btn-xs">Proceed to Transfer Vessel</a> 
          <?php } }?>     
        <?php } else {?>
          <a class="btn btn-info btn-xs"><?php if($process_id==38){?> Vessel Name Change Processing <?php } else if($process_id==39){ ?> Vessel Ownership Change Processing <?php } else if($process_id==40){ ?> Transfer Vessel Processing <?php } else if($process_id==41){ ?> Duplicate Certificate Processing <?php } ?></a> 
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
        <th>Reg. No</th>
        <th>Vessel Type</th>
        <th>Reg. Date</th>
        <th>Proceed to Ownership Change</th>
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