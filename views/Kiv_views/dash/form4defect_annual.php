<?php 

/*$user_type_id              =   $this->session->userdata('user_type_id');
 $sess_usr_id   =   $this->session->userdata('user_sl');*/

  $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');

$usertype_master           =   $this->Survey_model->get_usertype_master($user_type_id);
$data['usertype_master']   =   $usertype_master;
if(!empty($usertype_master))
{
   $usertype_name          =   $usertype_master[0]['user_type_type_name'];
}
?>

<script>
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});


</script>
<script language="javascript">
    
$(document).ready(function()
{
    $("#survey3").hide();
    $("#survey4").hide();
    $("#show_defect").hide();

$("#defect_status").change(function(){

    var defect_status=$("#defect_status").val();
    
        $("#category").val(''); 
       // $("#time_period").val(''); 
        $("#direction_to_rectify").val(''); 
        $("#defect_details").val(''); 
        $("#defect_intimation").val(''); 
       // $("#placeofsurvey_sl").val(''); 
        $("#date_of_survey").val(''); 
       // $("#time_of_survey").val(''); 
        $("#remarks").val('');
      

    //1-no defect; 2-defect found
    if(defect_status==1)
    {
      $("#survey3").show();
      $("#survey4").show();
      $("#show_defect").hide();
    }
     if(defect_status==2)
    {
      $("#survey3").hide();
      $("#survey4").show();
      $("#show_defect").show();
    }
     if(defect_status=="")
    {
      $("#survey3").hide();
      $("#survey4").hide();

       
    }
});

function view_details(id)
  {
       $.post("Ajax_current_assignments.php",{id:id},function(data)
      {
        $("#disp_details").html(data);
      });
  }


//-----Jquery End----//
});
</script>
<?php 
   
/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$survey_id1         = $this->uri->segment(6);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl=$this->encrypt->decode($processflow_sl); 

$survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
$survey_id=$this->encrypt->decode($survey_id); 
/*_____________________Decoding End___________________*/

if(!empty($survey_intimation))
{
  //print_r($survey_intimation);
    $date                   =   date("d-m-Y", strtotime($survey_intimation[0]['intimation_created_timestamp']));
    $survey_number          =   $survey_intimation[0]['survey_number'];
    $remarks                =   $survey_intimation[0]['remarks'];
    $vessel_name            =   $survey_intimation[0]['vessel_name'];
    $reference_number       =   $survey_intimation[0]['reference_number'];
    $date_of_survey         =   date("d-m-Y", strtotime($survey_intimation[0]['date_of_survey']));
    $time_of_survey         =   $survey_intimation[0]['time_of_survey'];
    $placeofsurvey_name     =   $survey_intimation[0]['placeofsurvey_name'];
    $placeofsurvey_name     =   $survey_intimation[0]['placeofsurvey_name'];
    $owner_name             =   $survey_intimation[0]['user_name'];
    $owner_address          =   $survey_intimation[0]['user_address'];
    $owner_user_type_id     =   $survey_intimation[0]['user_master_id_user_type'];
    $owner_user_id          =   $survey_intimation[0]['vessel_created_user_id'];
    $placeofsurvey_id       =   $survey_intimation[0]['placeofsurvey_id'];
}  

    $current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
    $data['current_status1']  =   $current_status1;
    $status_details_sl        =   $current_status1[0]['status_details_sl'];

?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
     <?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php }?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php }?>
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage " >
<div class="col-12">
<!-- inside content in container -->
<div class="container letterform">
<!-- inside container -->
<!-- <form name="form1" id="form1" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/form4defect_detection_annual/'.$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1 ?>" enctype="multipart/form-data"> -->

  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
  echo form_open("Kiv_Ctrl/Survey/form4defect_detection_annual/".$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1, $attributes);
  ?>

<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id ; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $owner_user_id; ?>">
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $owner_user_type_id; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<!-- hidden fields end -->
<div class="row no-gutters">
<div class="col-6 d-flex justify-content-start mt-2">
<button class="btn btn-sm btn-point btn-flat btn-outline-primary">Form 4</button>
</div>
<div class="col-6 d-flex justify-content-end mt-2">
<button class="btn btn-sm btn-point btn-flat btn-outline-success"> <i class="fas fa-print"></i> &nbsp; Print</button>
</div>
<div class="col-12 d-flex justify-content-center text-primary mt-4"> <u> <strong> Defect Details </strong> </u> </div>
</div> <!-- end of row -->
<div class="row no-gutters oddrow mt-3 py-2 text-primary">
<div class="col-3 pl-2"> Reference Number</div> 
<div class="col-3 text-secondary"> <?php echo $reference_number;?></div>
<div class="col-3 pl-2"> Date of Entry</div>
<div class="col-3 text-secondary"> <?php echo date('d-m-Y');?></div>
</div> <!-- end of row -->
<div class="row no-gutters evenrow py-2 text-primary">
<div class="col-6 pl-2"> Whether the vessel has any defect</div>
<div class="col-6 text-secondary px-4"> <select name="defect_status" id="defect_status"  >
<option value="" >Select</option>
<option value="1">No</option>
<option value="2">Yes</option>   
</select> </div>
</div>
<div id="show_defect" class="text-primary">
<div class="row no-gutters oddrow py-2">
<div class="col-3 pl-2"> Defect noticed by</div> 
<div class="col-3 text-secondary"> <?php echo $usertype_name; ?> </div>
<div class="col-3 pl-2"> Period allotted for clearing the defect</div>
<div class="col-3">
 <div class="row"> <div class="col-6 d-flex justify-content-end">
 <input type="text" name="time_period" value="30" id="time_period"  class="form-control" maxlength="2"  data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/> </div> 
 <div class="col-6 d-flex justify-content-start"> days </div> </div>
 </div>
</div> <!-- end of row -->
<div class="row no-gutters evenrow py-2">
<div class="col-2 pl-2"> Direction to Rectify</div> 
<div class="col-10"> <textarea name="direction_to_rectify" data-validation="required" id="remarks" rows="3" cols="90" ></textarea></div>
</div>
<div class="row no-gutters oddrow py-2">
<div class="col-2 pl-2"> Details of Defects</div>
<div class="col-10"> <textarea name="defect_details" data-validation="required" id="defect_details" rows="3" cols="90"></textarea></div>
</div> <!-- end of row -->
<div class="row no-gutters evenrow py-1">
<div class="col-6 text-primary pl-2"> Upload Document</div> 
<div class="col-6"> <input type="file" name="defect_intimation" id="defect_intimation" onChange="validate_file(this.value,this.id)">
</div>
</div> <!-- end of row -->
<div class="row no-gutters oddrow"> 
<div class="col-4 d-flex justify-content-center text-success py-2"> <strong> 
<i class="far fa-calendar-alt"></i> &nbsp; <u>  Survey Schedule </u> </strong> </div>
<div class="col-4 d-flex justify-content-center py-2 "> 

<button class="btn btn-sm btn-point btn-flat btn-outline-light text-danger" type="button" data-toggle="modal" data-target="#myModal" onclick="view_details(<?php echo  $sess_usr_id; ?>)"> <i class="fas fa-clock"></i> &nbsp; View current assignments </button>
   </div>




<div class="col-4 d-flex justify-content-center py-2 "> 
<button class="btn btn-sm btn-point btn-flat btn-outline-warning text-primary" type="button"> <i class="fas fa-comments"></i> &nbsp; View remarks </button> </div>
</div>

<div class="row no-gutters evenrow py-2">
<div class="col-2 pl-2"> Place of Survey</div> 
<div class="col-2 px-2"> <select name="placeofsurvey_sl" id="placeofsurvey_sl" class="form-control select2" data-validation="required">
    <option value="">Select</option>
    <?php foreach($placeof_survey as $res_placeof_survey)
    { 
        ?>
   <option value="<?php echo $res_placeof_survey['placeofsurvey_sl']; ?>" <?php if($placeofsurvey_id==$res_placeof_survey['placeofsurvey_sl']) { echo "selected"; } ?>><?php echo $res_placeof_survey['placeofsurvey_name']; ?></option>
<?php
    } 
    ?>
   </select>
   </div>
<div class="col-2 pl-2 "> Date of Survey</div>
<div class="col-2 px-2"> <input type="date" class="form-control dob" id="date_of_survey" name="date_of_survey" data-validation="required"></div>
<div class="col-2 pl-2"> Time of Survey</div> 
<div class="col-2 px-2"> <input type="text" class="form-control" value="10:00 AM" name="time_of_survey" id="time_of_survey" /></div>
</div> <!-- end of row -->

<div class="row no-gutters oddrow py-2">
<div class="col-2 pl-2"> Remarks</div>
<div class="col-6 px-2"> <textarea name="remarks" data-validation="required" id="remarks" rows="3" cols="90"></textarea></div>
</div> <!-- end of row -->

</div> <!-- end of show_defect div -->
<div class="row no-gutters py-2 oddrow" id="survey3">
<div class="col-6 pl-2 text-primary"> Category </div> 
<div class="col-6 px-4"> 
  <select name="category" id="category"  >
  <option value="" >Select</option>
  <option value="1">Category A</option>
  <option value="2">Category B</option>   
  </select>
</div>
</div> <!-- end of survey3 row -->
<div class="row no-gutters py-2 mb-3" id="survey4">
<div class="col-12 d-flex justify-content-center"> 
<!-- <input type="submit" class="btn btn-info btn-space" name="btnsubmit"  value="Submit "> -->
<button type="submit" class="btn btn-flat btn-sm btn-success btn-point" id="btnsubmit">Send &nbsp; <i class="fas fa-arrow-right"></i> </button>
</div>
</div>  <!-- end of survey4 row -->
<!-- </form> --> <?php echo form_close(); ?>
<!-- end of inside container -->
</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->


<script language="javascript">
$(document).ready(function(){

$("#printform").click(function () 
{
    //Copy the element you want to print to the print-me div.
    $("#form4view").clone().appendTo("#form4view-print");
    //Apply some styles to hide everything else while printing.
    $("body").addClass("printing");
    //Print the window.
    window.print();
    //Restore the styles.
    $("body").removeClass("printing");
    //Clear up the div.
    $("#form4view-print").empty();
});





});

  $(document).ready(function() {
    $('.select2').select2();
});
var _URL = window.URL || window.webkitURL;
function validate_file(file,defect_intimation) 
{
  var fsize = $('#'+defect_intimation)[0].files[0].size;
  var filename=file;
  var extension = filename.split('.').pop().toLowerCase();

  if($.inArray(extension, ['pdf','doc','docx','odt','jpg','jpeg','png']) == -1) 
  {
    alert('Sorry, invalid extension.');
    $("#"+defect_intimation).val('');
    return false;
  }

  if(fsize>1000000)
  {
    alert("File Size is Exeed 1MB (1024 KB)");
    $("#"+defect_intimation).val('');
    return false;
  }
}
function IsDecimal(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58) || (unicode == 46 )) 
  {
      return true;
  }
  else 
  {
      window.alert("This field accepts only Numbers");
      return false;
  }
} 

function IsZero(id)
{
  var strvalue=document.getElementById(id).value; 
  if((strvalue==0) || (strvalue=='.'))
  {
    alert("Invalid Number");
   document.getElementById(id).value='';
    document.getElementById(id).focus();
    return false;
  }
}



</script>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Current assignments</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="disp_details">Data here Modal body..
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
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

 
