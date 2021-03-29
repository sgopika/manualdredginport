<?php 
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');
$modid=2;
$modidenc     = $this->encrypt->encode($modid); 
$modidenc    = str_replace(array('+', '/', '='), array('-', '_', '~'), $modidenc);
//print_r($reprint_req_pc_dt);
foreach($reprint_req_pc_dt as $rep_req_res){
$vesselmain_vessel_id =$rep_req_res['vesselmain_vessel_id'];
$vesselmain_vessel_name =$rep_req_res['vesselmain_vessel_name'];
$vesselmain_reg_number  =$rep_req_res['vesselmain_reg_number'];
$user_master_fullname   =$rep_req_res['user_master_fullname'];
$user_master_email      =$rep_req_res['user_master_email'];
$user_master_ph         =$rep_req_res['user_master_ph'];
$reprint_reqtimestamp=$rep_req_res['reprint_reqtimestamp'];
$reprint_request_reason=$rep_req_res['reprint_request_reason'];
if($reprint_request_reason==1){
  $reason = "Damage in Number Plate";
} else if($reprint_request_reason==2){
  $reason = "Transfer of Vessel"; 
}else if($reprint_request_reason==3){
  $reason = "Others"; 
}
$print_count=$rep_req_res['print_count'];
}

?>

<script type="text/javascript">
$(document).ready(function() {
  $(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
 }); 

  function reprint_req(id){
   
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/reprint_request/')?>",
      type: "POST",
      dataType:"JSON",
      data:{  id:id},
      
      success: function(data)
      { //alert(data);exit;
       if(data['val_errors']!=""){
        //$("#msgDiv").show();
        var html ="";
        if(data['status']=="true")
        {
          var btn = "btn-success";
        }
        else
        {
          var btn = "btn-danger";
        }

        html ='<div id="msgDiv" class="alert '+btn+' alert-dismissible" >'+data['val_errors']+'</div>'
        //document.getElementById('msgDiv').innerHTML=""+data['val_errors']+"";
        $("#resp_msg").html(html);
      } 
    }

    });
  }
</script>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==3) { ?>
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/reprint_approve_list"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==14) { ?>
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==11) { ?>
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
 <div id="resp_msg"><?php if(isset($resp_msg)){echo $resp_msg; }?>
    <div id="msgDiv" class="alert  alert-dismissible" style="display:none"></div> 
  </div>
<form name="reprint_list" id="reprint_list" method="post"   action="<?php echo $site_url.'/Kiv_Ctrl/Survey/reprint_status_update'?>" >
  <div class="main-content ui-innerpage">
  <div class="row no-gutters p-1 justify-content-center">
    <div class="col-10 text-center">
      <div class="alert bg-darkslateblue" role="alert">
        Reprint - Vessel Details
      </div> <!-- end of alert -->
      </div> <!-- end of col8 -->
      <div class="col-10 text-center">
        <div class="row no-gutters px-1 pt-2 pb-1 justify-content-center bg-gray">
          <div class="col-2 py-2">
            Vessel Name
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            <?php echo $vesselmain_vessel_name;?>
            <!-- <select class="form-control btn-point js-example-basic-single select2" name="survey_sl[]" id="survey_sl" multiple="multiple" required="required"  data-placeholder="Select the list" >
              <option value="">Select</option>
              <option value="0">All</option>
                </select>  -->
          </div> <!-- end of col-3 -->
          <div class="col-2 py-2">
            Registration Number
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
             <?php echo $vesselmain_reg_number;?>
          </div> <!-- end of col-3 -->
        </div> <!-- end of inner row 2-->
        <div class="row no-gutters px-1 pt-2 pb-1 justify-content-center">
          <div class="col-2 py-2">
            Owner Name
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            <?php echo $user_master_fullname;?>
          </div> <!-- end of col-3 -->
          <div class="col-2 py-2">
            Phone
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            <?php echo $user_master_ph;?>
          </div> <!-- end of col-3 -->
        </div> <!-- end of inner row 1-->
         <div class="row no-gutters px-1 pt-2 pb-1 justify-content-center">
          <div class="col-2 py-2">
            Mail ID
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            <?php echo $user_master_email;?>
          </div> <!-- end of col-3 -->
          <div class="col-2 py-2">
            Reprint Request Date
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            <?php echo $reprint_reqtimestamp;?>
          </div> <!-- end of col-3 -->
        </div> <!-- end of inner row 1-->
        <div class="row no-gutters px-1 pt-2 pb-1 justify-content-center">
          <div class="col-2 py-2">
            Reprint Request Reason
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            <?php echo $reason;?>
          </div> <!-- end of col-3 -->
          <div class="col-2 py-2">
            Status
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vesselmain_vessel_id;?>">
            <select class="form-control btn-point js-example-basic-single select2" name="status" id="status" required="required"  data-placeholder="Select" onchange="show_div(this.value);">
              <option value="">Select</option>
              <option value="1">Approve</option>
              <option value="2">Cancel</option>
            </select>
          </div> <!-- end of col-3 -->
          <div class="col-2 py-2" id="remarks_div" style="display: none;">
            Remarks
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2" id="remarks_div1" style="display: none;">
            <textarea name="remarks" id="remarks" class="form-control"></textarea>
          </div> <!-- end of col-3 -->
        </div> <!-- end of inner row 1-->
        <div class="row no-gutters px-1 pt-2 pb-1 justify-content-center">
          <button type="submit" class="btn  btn-flat btn-point bg-mediumorchid" ><i class="fas fa-file-archive"></i>&nbsp; Submit </button>
        </div> <!-- end of inner row 1-->
        
      </div> <!-- end of col8 -->
   </div> <!-- end of row -->

</div> <!-- end of main content -->
</form>
<script type="text/javascript">
  function show_div(id){
    if(id==2){
      $("#remarks_div").show();
      $("#remarks_div1").show();
    } else {
      $("#remarks_div").hide();
      $("#remarks_div1").hide();
    }
  }
</script>








