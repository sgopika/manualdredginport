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

<script type="text/javascript" language="javascript">

$(document).ready(function(){

$("#all_heading").click(function()
{
    $("#second_criteria_div").show();
    $("#third_criteria_div").hide();
    $("#main_criteria_div").hide();
});

$("#particular_heading").click(function()
{
    $("#third_criteria_div").show();
    $("#second_criteria_div").hide();
    $("#main_criteria_div").hide();
});

$("#formName").change(function()
{
    $("#main_criteria_div").hide();
    var formName=$("#formName").val();//alert(formName);
    
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';  
      
    if(formName != '')
    {  
    $.ajax
      ({ 
        type: "POST",
        url:"<?php echo site_url('/Kiv_Ctrl/Master/dynamic_form_Datalist_ajax/')?>",
        data:{formName:formName,'csrf_test_name': csrf_token},
        success: function(data)
        { //alert(data); 
       
        $("#table_div").show();      
        $("#ajax_tbl").html(data);
        $("#third_criteria_div").hide();
        $("#second_criteria_div").hide();
        }
      });
    }

});   

$("#formId").change(function()
{
    $("#main_criteria_div").hide();

    var form_id=$("#formId").val();
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';  
      
    if(form_id != '')
    {  
    $("#part_heading_head_view").show();    
    $.ajax
      ({
        type: "POST",
        url:"<?php echo site_url('/Kiv_Ctrl/Master/dynamic_formname_ajax/')?>",
        data:{form_id:form_id,'csrf_test_name': csrf_token},
        success: function(data)
        {
        $("#table_div").show();       
        $("#heading_name").html(data);
        }
      });
    }

}); 

$("#heading_name").change(function()
{
    var form_id=$("#formId").val();
    var heading_name=$("#heading_name").val();//alert(heading_name);alert(form_id);
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';  
      
    if(form_id != '' && heading_name != '')
    {  
    $("#part_heading_head_view").show();    
    $.ajax
      ({ 
        type: "POST",
        url:"<?php echo site_url('/Kiv_Ctrl/Master/dynamic_formHeading_Datalist_ajax/')?>",
        data:{form_id:form_id,heading_name:heading_name,'csrf_test_name': csrf_token},
        success: function(data)
        { //alert(data);      
        $("#ajax_tbl").html(data);
        }
      });
    }

});   

});

//function copyFormData(vesselId,subvesselId,hullId,lengthOverDeck,engineInboardOutboard,formId,headingId,startDate,endDate)
function copyFormData(id)
{ 
  var vesselId = $("#hid_vesselId_"+id).val();//alert(vesselId);
  var subvesselId   = $("#hid_subvesselId_"+id).val();//alert(subvesselId);
  var hullId = $("#hid_hullId_"+id).val();//alert(hullId);
  var lengthOverDeck   = $("#hid_lengthOverDeck_"+id).val();//alert(lengthOverDeck);
  var engineInboardOutboard   = $("#hid_engineInboardOutboard_"+id).val();//alert(engineInboardOutboard);
  var formId   = $("#hid_formId_"+id).val();//alert(formId);
  var startDate = $("#hid_startDate_"+id).val();//alert(startDate);
  var endDate   = $("#hid_endDate_"+id).val();//alert(endDate);

  /*To display Source table data*/
  var vesselName = $("#hid_vesselName_"+id).val();//alert(vesselName);
  var subvesselName = $("#hid_subvesselName_"+id).val();//alert(subvesselName);
  if (subvesselName=='') {subvesselName="Nil";}
  var hullName = $("#hid_hullName_"+id).val();//alert(hullName);
  var boardName = $("#hid_engineInboardOutboardName_"+id).val();//alert(boardName);
  var hidformName = $("#hid_formName_"+id).val();//alert(hidformName);
  /*To display Source table data*/

  $.ajax({
            type: "text",
            url: "<?php echo $site_url; ?>/Kiv_Ctrl/Master/copyFormData_ajax/"+vesselId+"/"+subvesselId+"/"+hullId+"/"+lengthOverDeck+"/"+engineInboardOutboard+"/"+formId+"/"+startDate+"/"+endDate+"/"+vesselName+"/"+subvesselName+"/"+hullName+"/"+boardName+"/"+hidformName, 
            dataType: "text",  
            cache:false,
            success: 
            function(result)
            { alert(result);
              $("#paste_div").show();
              $("#second_criteria_div").hide();
              $("#third_criteria_div").hide();
              $("#table_div").hide();  
              $("#paste_div").html(result);
              $('.js-example-basic-single').select2();
              $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
              $("[data-mask]").inputmask();
            }
        });    
}

function copyFormHeadingData(id)
{ 
  var vesselId = $("#hid_vesselId_"+id).val();//alert(vesselId);
  var subvesselId   = $("#hid_subvesselId_"+id).val();//alert(subvesselId);
  var hullId = $("#hid_hullId_"+id).val();//alert(hullId);
  var lengthOverDeck   = $("#hid_lengthOverDeck_"+id).val();//alert(lengthOverDeck);
  var engineInboardOutboard   = $("#hid_engineInboardOutboard_"+id).val();//alert(engineInboardOutboard);
  var formId   = $("#hid_formId_"+id).val();//alert(formId);
  var headingId   = $("#hid_headingId_"+id).val();//alert(hid_headingId_);
  var startDate = $("#hid_startDate_"+id).val();//alert(startDate);
  var endDate   = $("#hid_endDate_"+id).val();//alert(endDate);

  /*To display Source table data*/
  var vesselName = $("#hid_vesselName_"+id).val();//alert(vesselName);
  var subvesselName = $("#hid_subvesselName_"+id).val();//alert(subvesselName);
  if (subvesselName=='') {subvesselName="Nil";}
  var hullName = $("#hid_hullName_"+id).val();//alert(hullName);
  var boardName = $("#hid_engineInboardOutboardName_"+id).val();//alert(boardName);
  var hidformName = $("#hid_formName_"+id).val();//alert(hidformName);
  var headingName   = $("#hid_headingName_"+id).val();//alert(headingName);
  /*To display Source table data*/

  $.ajax({
            type: "text",
            url: "<?php echo $site_url; ?>/Kiv_Ctrl/Master/copyFormHeadingData_ajax/"+vesselId+"/"+subvesselId+"/"+hullId+"/"+lengthOverDeck+"/"+engineInboardOutboard+"/"+formId+"/"+headingId+"/"+startDate+"/"+endDate+"/"+vesselName+"/"+subvesselName+"/"+hullName+"/"+boardName+"/"+hidformName+"/"+headingName, 
            dataType: "text",  
            cache:false,
            success: 
            function(result)
            {   
              $("#paste_div").show();
              $("#second_criteria_div").hide();
              $("#third_criteria_div").hide();
              $("#table_div").hide();  
              $("#paste_div").html(result);
              //$(".select2").select2();
              $('.js-example-basic-single').select2();/*changed on 11-10-2020*/
              $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
              $("[data-mask]").inputmask();

              $("#copiedAjax").html(result);
              $('.js-example-basic-single').select2();
              $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
              $("[data-mask]").inputmask();
            }
        });
  
}

function startDate() 
  { 
        var dateString = document.getElementById('start_date').value; 

        if(dateString != '')
        {
          $('#msgVal_startdate').hide();
        }
        
        var regcd = new RegExp("^[0-9\/]+$");
        if (regcd.exec(dateString) == null) 
        {
          $('#msgVal_startdate').html("<p style='color:red;'>Only Number and / allowed.</p>");
         
          document.getElementById("start_date").value = null;
          return false;
          }

        dateString = dateString.split("/").reverse().join("-");
        
        var dateString1 = document.getElementById('end_date').value;
        dateString1 = dateString1.split("/").reverse().join("-");

        var myDate = new Date(dateString);
        var myDate1 = new Date(dateString1);
        var today = new Date();

         if(myDate1!='')
        {
            if(myDate1 < myDate)
            { 
                $('#msgVal_startdate').show();
                $('#msgVal_startdate').html("<p style='color:red;'>Start Date Should be Smaller than End Date.</p>");
                return false;
            }
        }
        else
        { 
            $('#msgVal_startdate').hide();
            return true;
        }
  }

  function endDate() 
  {
        var dateString1 = document.getElementById('start_date').value;
        dateString1 = dateString1.split("/").reverse().join("-");

        var dateString2 = document.getElementById('end_date').value;
        dateString2 = dateString2.split("/").reverse().join("-");

        var myDate1 = new Date(dateString1);
        var myDate2 = new Date(dateString2);
        var today = new Date();
        
        if ( myDate2 < today ) 
        { 
            $('#msgVal_enddate').show();
            $('#msgVal_enddate').html("<p style='color:red;'>You Cannot Enter Previous End Date .</p>");
            return false;
        }
        else if(myDate2 <= myDate1)
        { 
            $('#msgVal_enddate').show();
            $('#msgVal_enddate').html("<p style='color:red;'>End Date Should be greater than Start Date.</p>");
            return false;
        }
        else
        { 
            $('#msgVal_startdate').hide();
            $('#msgVal_enddate').hide();
            return true;
        }
  }
</script>
<div class="container-fluid ui-innerpage">
  <div class="row pt-2">
    <div class="col-6">
      <span class="badge bg-darkmagenta innertitle "> Copy Dynamic Form </span>
    </div> <!-- end of col6 -->
    <div class="col-6 d-flex justify-content-end">
     <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end">
           <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
            &nbsp; / &nbsp;
           <li><a class="no-link"  href="<?php echo $site_url."/Kiv_Ctrl/Master/viewCopyDynamicform"?>"> View Copy Dynamic Form</a></li>
        </ol>
      </nav>
    </div> <!-- end of col6 -->
  </div> <!-- end of row -->
  <div class="row pt-2" id="main_criteria_div">
    <div class="col-12 d-flex justify-content-center divborder py-2 m-2" >
      <a class="btn btn-block btn-default btn-lg"> All Forms </a> 
    </div>
    <div class="col-12 d-flex justify-content-center divborder py-2 m-2" >
      <a class="btn btn-block btn-default btn-lg"  name="all_heading" id="all_heading">   Particular Form </a> 
    </div>
    <div class="col-12 d-flex justify-content-center divborder py-2 m-2" >
      <a class="btn btn-block btn-default btn-lg"  name="particular_heading" id="particular_heading"> Particular Heading  </a>
    </div>
  </div> <!-- end of main criteria row -->
  <div class="row" id="second_criteria_div" style="display: none;">
      <div class="col-12 d-flex justify-content-end">
        <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/copyDynamicform"?>" ><i class="fas fa-long-arrow-alt-left"></i> &nbsp; Back </a>
      </div> <!-- end of col12 -->
      <div class="col-12 d-flex justify-content-center">
        <div class="form-group">
          <select name="formName" id="formName" class="form-control js-example-basic-single" style="width: 100%;">
            <option value="">Select Form</option> 
            <?php foreach($form as $form_name){ ?>
            <option value="<?php echo $form_name['document_type_sl']; ?>" ><?php echo $form_name['document_type_name']; ?></option>
            <?php }  ?>
          </select> 
        </div> <!-- end of form group -->
      </div> <!-- end of col12 -->
      <div class="col-12 d-flex justify-content-center">
        <button type="button" class="btn btn-flat btn-point btn-info btn-sm btn-flat pull-right">List Vessels</button>
      </div> <!-- end of col12 -->
  </div> <!-- end of second criteria row -->
  <div class="row" id="third_criteria_div" style="display: none;">
      <div class="col-12 d-flex justify-content-end">
        <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/copyDynamicform"?>"  class="btn btn-default btn-flat btn-sm pull-right"><i class="fas fa-long-arrow-alt-left"></i> &nbsp; Back </a>
      </div> <!-- end of col12 -->
      <div class="col-12 d-flex justify-content-center">
        <div class="form-group" id="part_heading_form_view">
          <p class="lead">Select Form</p>
          <select name="formId" id="formId" class="form-control js-example-basic-single" style="width: 100%;">
            <option value="">Select Form</option> 
            <?php foreach($form as $form_name){ ?>
            <option value="<?php echo $form_name['document_type_sl']; ?>" id="<?php echo $form_name['document_type_sl']; ?>"><?php echo $form_name['document_type_name']; ?></option>
            <?php }  ?>
          </select>
        </div> <!-- end of form group -->
      </div> <!-- end of col12 -->
      <div class="col-12 d-flex justify-content-center">
        <div class="form-group" id="part_heading_head_view">
          <p class="lead">Select Heading</p>
          <select name="heading_name" id="heading_name" class="form-control js-example-basic-single" style="width: 100%;">
            <option value="">Select Heading</option> 
            <?php foreach($heading as $heading_id){ ?>
            <option value="<?php echo $heading_id['heading_sl']; ?>" id="<?php echo $heading_id['heading_sl']; ?>"><?php echo $heading_id['heading_name']; ?></option>
            <?php }  ?>
          </select>
        </div> <!-- end of form group -->
      </div> <!-- end of col12 -->
      <div class="col-12 d-flex justify-content-center">
        <button type="button" class="btn btn-flat btn-point btn-info btn-sm btn-flat pull-right">List Vessels</button>
      </div> <!-- end of col12 -->
  </div> <!-- end of third criteria row -->
  <div class="row"   id="table_div" style="display: none;">
       <div class="col-12 d-flex justify-content-end">
        <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/copyDynamicform"?>"  class="btn btn-default btn-flat btn-sm pull-right"><i class="fas fa-long-arrow-alt-left"></i> &nbsp; Back </a>
      </div> 
      <!-- <div class="col-12 d-flex justify-content-center"> -->
      <div id="ajax_tbl"></div>
      <!-- <table id="example1" class="table table-bordered table-striped">
            </table> -->
      <!-- </div> --> <!-- end of col12 -->
  </div> <!-- end of table div -->
  <div class="row" id="paste_div"  style="display: none;">pastediv
      <div class="col-12" >

      </div><!-- End of Paste Div -->
  </div> <!-- end of paste row -->
</div> <!-- end of container fluid -->