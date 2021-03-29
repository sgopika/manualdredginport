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
function checkboxVal(checkLabId)
{  
  $("#lab_"+checkLabId).prop('checked', true);  
} 

function checkboxVal_change(checkLabId)
{    
  $("#lab_"+checkLabId).prop('checked', true);
  var checkbox_label= $("#lab_"+checkLabId).val(); 
  var checkbox_label_value= $("#lab_values_"+checkLabId).val();
  if((checkbox_label_value=='')||(checkbox_label_value==null))
  {
    $("#lab_"+checkLabId).prop('checked', false);
  }
  var field_type=$("#lab_values_"+checkLabId).attr('type');
  if((checkbox_label_value != '')&&(field_type=="text"))
  {
    var firstChar=checkbox_label_value.charAt(0);
    if(firstChar==',')
    {
      $("#lab_values_"+checkLabId).val('');
      $("#lab_"+checkLabId).prop('checked', false);
      alert("Label Value cannot starts with Comma(,).");
      document.getElementById("valid_err_msg_"+checkLabId).innerHTML ="<font color='red'>Label Value cannot starts with Comma(,).</font>";
      return false;
    }
    var lastChar = checkbox_label_value[checkbox_label_value.length -1];
    if(lastChar==',')
    {
      $("#lab_values_"+checkLabId).val('');
      $("#lab_"+checkLabId).prop('checked', false);
      alert("Label Value cannot ends with Comma(,).");
      document.getElementById("valid_err_msg_"+checkLabId).innerHTML ="<font color='red'>Label Value cannot ends with Comma(,).</font>";
      return false;
    }
    var searchTerm = ',,';
    var reptCom = checkbox_label_value.indexOf(searchTerm);//alert(reptCom);
    if(reptCom!=-1)
    {
      $("#lab_values_"+checkLabId).val('');
      $("#lab_"+checkLabId).prop('checked', false);
      alert("Use Comma(,) Only Between Two Numbers.");
      document.getElementById("valid_err_msg_"+checkLabId).innerHTML ="<font color='red'>Use Comma(,) Only Between Two Numbers.</font>";
      return false;
    }
    var regex = new RegExp("^[0-9\,]+$");
    if (regex.exec(checkbox_label_value) == null) 
    {
      $("#lab_values_"+checkLabId).val('');
      $("#lab_"+checkLabId).prop('checked', false);
      alert("Only Numbers and ,(comma) are allowed in Label Value.");
      document.getElementById("valid_err_msg_"+checkLabId).innerHTML ="<font color='red'>Only Numbers and ,(comma) are allowed in Label Value.</font>";
      return false;
    } 
  }
}

function checkedVal(checkLabId)
{   
  var checkedorNot=document.getElementById("lab_"+checkLabId).checked;
  var field_type=$("#lab_values_"+checkLabId).attr('type');
  if((checkedorNot == true)&&(field_type!="text"))
  {
    alert("Select Data From List");
    document.getElementById("lab_values_"+checkLabId).focus();
    var checkbox_label_value=$("#lab_values_"+checkLabId).val();
    if(checkbox_label_value==null)
    { 
      $("#lab_"+checkLabId).prop('checked', false);
    }
  }
  if((checkedorNot == false)&&(field_type!="text"))
  {   
    //alert("uncheck");alert(checkbox_label_value);
    if(checkbox_label_value==undefined)
    { 
      alert("If you need to uncheck checkbox, deselect data from Select List");
      $("#lab_"+checkLabId).prop('checked', true);
    }
  }
}

function startDate_commented_fn() 
{ 
  var vesseltype_name=$("#vesseltype_name").val();
  var vessel_subtype_name=$("#vessel_subtype_name").val();
  var length_over_deck=$("#length_over_deck").val();
  var hullmaterial_name=$("#hullmaterial_name").val();
  var engine_inboard_outboard=$("#engine_inboard_outboard").val();
  var document_type_name=$("#document_type_name").val();
  var heading_name=$("#heading_name").val();
  var start_date=$("#start_date").val();
  var end_date=$("#end_date").val();        
  var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';
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
  dateString1 = dateString1.split("/").reverse().join("-");alert(dateString);alert(dateString1);
  var myDate = new Date(dateString);
  var myDate1 = new Date(dateString1);
  var today = new Date();
  $.ajax
  ({
    type: "POST",
    url:"<?php echo site_url('/Kiv_Ctrl/Master/duplicationCheck_ajx/')?>",
    data:{vesseltype_name:vesseltype_name,vessel_subtype_name:vessel_subtype_name,length_over_deck:length_over_deck,hullmaterial_name:hullmaterial_name,engine_inboard_outboard:engine_inboard_outboard,document_type_name:document_type_name,heading_name:heading_name,start_date:start_date,end_date:end_date,'csrf_test_name': csrf_token},
    success: function(data)
    {   
      //alert(data); 
      if(data=="insertionpossible")
      {
        $("#ajx_dup_check_div").show();  
        $("#ajx_dup_check_div").html(data);
      }
      if(data=="dataexisting")
      {
        $("#ajx_dup_check_div").show();  
        $("#ajx_dup_check_div").html("<font color='red'>Data already existing!!</font>");
        $("#start_date").val("");
      }
      if(data=="enddatenull")
      {
        $("#ajx_dup_check_div").show();  
        $("#ajx_dup_check_div").html("<font color='red'>End date not mentioned!!</font>");
        $("#start_date").val("");
      }
      if(data=="noduplication")
      {
        $("#ajx_dup_check_div").show();  
        $("#ajx_dup_check_div").html("<font color='red'>No duplication!!</font>");
      }
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
  dateString = dateString.split("/").reverse().join("-");//alert(dateString);
  $("#start_date_hidden").val(dateString);
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
  $("#end_date_hidden").val(dateString2);
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
function dynamic_date_commented_on_/01/11/2020()
{ alert("dynamic_date");
  var vesseltype_name         = $("#vesseltype_name_hidden").val();
    var vessel_subtype_name     = $("#vessel_subtype_name_hidden").val();
    var form_id                 = $("#document_type_name_hidden").val();
    var heading_id              = $("#heading_name").val();
    var engine_inboard_outboard = $("#engine_inboard_outboard_hidden").val();
    var hullmaterial_name       = $("#hullmaterial_name_hidden").val();//alert(hullmaterial_name);
    var length_over_deck        = $("#length_over_deck_hidden").val();//alert(length_over_deck);
    var start_date              = $("#start_date_hidden").val();//alert(start_date);
    var end_date                = $("#end_date_hidden").val();//alert(end_date);
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';  
   $.ajax
      ({
        type: "POST",
        url:"<?php echo site_url('/Kiv_Ctrl/Master/dynamic_labels_date/')?>",
        data:{form_id:form_id,heading_id:heading_id,engine_inboard_outboard:engine_inboard_outboard,hullmaterial_name:hullmaterial_name,vesseltype_name:vesseltype_name,vessel_subtype_name:vessel_subtype_name,length_over_deck:length_over_deck,'csrf_test_name': csrf_token},
        dataType:'json',
        success: function(data)
        { alert(data);
          var date11=data[0];
          var date21=data[1];
          $('#date1').val(date11);
          $('#date2').val(date21);
        }
      });
}

$(document).ready(function()
{

  $('#refreshBtn').click(function () 
  {
    location.reload();
  });

  $('#dynamic_ins').click(function () 
  {
    if ($("#vesseltype_name").val() == '') 
    {
      $('#msgVal1').show();
      return false;
    }
    if ($("#hullmaterial_name").val() == '') 
    {
      $('#msgVal_hull').show();
      return false;
    }
    if ($("#length_over_deck").val() == '') 
    {
      $('#msgVal_lod').show();
      return false;
    }
    else if($("#length_over_deck").val() != '')
    {
      var regex = new RegExp("^[0-9]+$");
      var length_over_deck=$("#length_over_deck").val();
      if (regex.exec(length_over_deck) == null) 
      {
        $("#length_over_deck").val('');
        alert("Only Numbers are allowed in Length Over the Deck.");
        $('#msgVal_lod').show();
        document.getElementById("msgVal_lod").innerHTML ="<font color='red'>Only Numbers are allowed in Length Over the Deck.</font>";
        return false;
      } 
    }
    if ($("#engine_inboard_outboard").val() == '') 
    {
      $('#msgVal_inout').show();
      return false;
    }
    if ($("#start_date").val() == '') 
    {
      $('#msgVal_startdate').show();
      return false;
    }
    if ($("#document_type_name").val() == '') 
    {
      $('#msgVal2').show();
      return false;
    }
    if ($("#heading_name").val() == '') 
    {
      $('#msgVal3').show();
      return false;
    }
    if (($("#vesseltype_name").val() != '')&&($("#hullmaterial_name").val() != '')&&($("#engine_inboard_outboard").val() != '')&&($("#length_over_deck").val() != '')&&($("#document_type_name").val() != '')&&($("#heading_name").val() != '')&&($("#start_date").val() != ''))
    {
      return true;
    }
  });

  $("#vessel_subtype_name").change(function()
  {
    var vessel_subtype_name=$("#vessel_subtype_name").val();
    if(vessel_subtype_name != '')
    { 
      /*set disabled values to hidden field, for insertion*/
      $("#vessel_subtype_name_hidden").val(vessel_subtype_name);   
    }
  });

  $("#hullmaterial_name").change(function()
  {
    var hullmaterial_name=$("#hullmaterial_name").val();
    if(hullmaterial_name != '')
    { 
      /*set disabled values to hidden field, for insertion*/
      $("#hullmaterial_name_hidden").val(hullmaterial_name);
      $('#msgVal_hull').hide();
    }
  });

  $("#engine_inboard_outboard").change(function()
  {
    var engine_inboard_outboard=$("#engine_inboard_outboard").val();
    if(engine_inboard_outboard != '')
    {
      /*set disabled values to hidden field, for insertion*/
      $("#engine_inboard_outboard_hidden").val(engine_inboard_outboard);
      $('#msgVal_inout').hide();
    }
  });

  $("#length_over_deck").change(function()
  {
    var length_over_deck=$("#length_over_deck").val();
    if(length_over_deck != '')
    { 
      /*set disabled values to hidden field, for insertion*/
      $("#length_over_deck_hidden").val(length_over_deck);
      $('#msgVal_lod').hide();
    }
  });

  $("#vesseltype_name").change(function()
  {

    var vesseltype_id=$("#vesseltype_name").val();
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';
    if(vesseltype_id != '')
    { 
      $("#vesseltype_name_hidden").val(vesseltype_id);
      $('#msgVal1').hide();
      $.ajax
      ({
        type: "POST",
        url:"<?php echo site_url('/Kiv_Ctrl/Master/dynamic_vesselsubtype_ajax/')?>",
        data:{vesseltype_id:vesseltype_id,'csrf_test_name': csrf_token},
        success: function(data)
        {        
          $("#vessel_subtype_name").html(data);
        }
      });
    }
  });

  $("#document_type_name").change(function()
  {
    var form_id=$("#document_type_name").val();
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';
    var hullmaterial_name=$("#hullmaterial_name").val();
    var engine_inboard_outboard=$("#engine_inboard_outboard").val();
    $("#document_type_name_hidden").val(form_id);
    if ($("#vesseltype_name").val() == '') 
    {
      $('#msgVal1').show();
      $("#document_type_name").val('');
      return false;
    }
    else if ($("#length_over_deck").val() == '') 
    {
      $('#msgVal_lod').show();
      $("#document_type_name").val('');
      return false;
    }    
    else if ($("#hullmaterial_name").val() == '') 
    {
      $('#msgVal_hull').show();
      $("#document_type_name").val('');
      return false;
    }
    else if ($("#engine_inboard_outboard").val() == '') 
    {
      $('#msgVal_inout').show();
      $("#document_type_name").val('');
      return false;
    }
    else if ($("#start_date").val() == '') 
    {
      $('#msgVal_startdate').show();
      $("#document_type_name").val('');
      return false;
    }
    else if ($("#form_id").val() == '') 
    {
      $('#msgVal2').show();
      return false;
    }
    else //if(form_id != '')
    { 
      $('#msgVal2').hide(); 
      if ($("#end_date").val() == ''){alert("If having any end date, specify it.");}
      $.ajax
      ({
        type: "POST",
        url:"<?php echo site_url('/Kiv_Ctrl/Master/dynamic_formname_ajax/')?>",
        data:{form_id:form_id,'csrf_test_name': csrf_token},
        success: function(data)
        {        
          $("#heading_name").html(data);
        }
      });
    }
  });       

  $("#heading_name").change(function()
  { alert("dynamic_labels_ajax");
    var vesseltype_name         = $("#vesseltype_name_hidden").val();
    var vessel_subtype_name     = $("#vessel_subtype_name_hidden").val();
    var form_id                 = $("#document_type_name_hidden").val();
    var heading_id              = $("#heading_name").val();
    var engine_inboard_outboard = $("#engine_inboard_outboard_hidden").val();
    var hullmaterial_name       = $("#hullmaterial_name_hidden").val();//alert(hullmaterial_name);
    var length_over_deck        = $("#length_over_deck_hidden").val();//alert(length_over_deck);
    var start_date              = $("#start_date_hidden").val();//alert(start_date);
    var end_date                = $("#end_date_hidden").val();//alert(end_date);
    var csrf_token              ='<?php echo $this->security->get_csrf_hash(); ?>';  
   
    
    if(form_id != '' && heading_id != '')
    {      
      var date1                   =$('#date1').val();
      var date2                   =$('#date2').val();
      $('#msgVal3').hide(); 
      $.ajax
      ({
        type: "POST",
        url:"<?php echo site_url('/Kiv_Ctrl/Master/dynamic_labels_ajax/')?>",
        data:{form_id:form_id,heading_id:heading_id,engine_inboard_outboard:engine_inboard_outboard,hullmaterial_name:hullmaterial_name,vesseltype_name:vesseltype_name,vessel_subtype_name:vessel_subtype_name,length_over_deck:length_over_deck,start_date:start_date,end_date:end_date,date1:date1,date2:date2,'csrf_test_name': csrf_token},
        success: function(data)
        {     
          alert(data);
          if(data==1)
          {
            alert("Values corresponding to selected criteria exists");
            location.reload();
          }
          else
          {
            $("#label_list").html(data);
            $(".select2").select2();
            $("#vesseltype_name").prop('disabled',true);
            $("#vessel_subtype_name").prop('disabled',true);
            $("#hullmaterial_name").prop('disabled',true);
            $("#length_over_deck").prop('disabled',true);
            $("#engine_inboard_outboard").prop('disabled',true);
            $("#document_type_name").prop('disabled',true);
            $("#start_date").prop('disabled',true);
            $("#end_date").prop('disabled',true);
            var headingStatus=$("#headingStatus").val();//alert(headingStatus);
            if(headingStatus=="existing")
            {
              $("#dynamic_ins").prop('disabled',true);
            }
            else if(headingStatus!="existing")
            {
              $("#dynamic_ins").prop('disabled',false); 
            }
          }
        }
      });
    } 
  }); 
  //End of JQUERY 
});

</script>
<div class="container-fluid">
  <div class="row pt-2">
    <div class="col-6">
      <span class="badge bg-darkmagenta innertitle "> Dynamic Form Design </span>
    </div> <!-- end of col6 -->
    <div class="col-6 d-flex justify-content-end">
     <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end">
           <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
            &nbsp; / &nbsp;
           <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/dynamicform_byvessel"?>">Dynamic Forms List 1 (All)</a></li>
        </ol>
      </nav>
    </div> <!-- end of col6 -->
  </div> <!-- end of row -->
  <div class="row">
     <div class="col-12 d-flex justify-content-end">
      <button type="button" name="refreshBtn" id="refreshBtn" class="btn btn-flat btn-default btn-sm pull-right"> <i class="fas fa-sync-alt"></i>  Refresh </button>
    </div> <!-- end of col12 -->
    <div id="msgDiv" class="alert alert-info alert-dismissible col-12" style="display:none"></div> 
  </div> <!-- end of row -->
  <!-- ------------------------------------------------- php codes ---------------------------------------------------- -->
    <?php 
        if($this->session->flashdata('msg'))
          {
            echo $this->session->flashdata('msg');
          }

        if($this->session->flashdata('val'))
          {
            $addResult=$this->session->flashdata('val');
            //print_r($addResult);
            $vesseltype_id            = $addResult['vesseltype_id'];
            $vesseltype_name          = $addResult['vesseltype_name'];
            $vessel_subtype_id        = $addResult['vessel_subtype_id'];
            $vessel_subtype_name      = $addResult['vessel_subtype_name'];
            $hullmaterial_id          = $addResult['hullmaterial_id'];
            $hullmaterial_name        = $addResult['hullmaterial_name'];
            $length_over_deck         = $addResult['length_over_deck'];
            $engine_inboard_outboard  = $addResult['engine_inboard_outboard'];
            $inboard_outboard_name    = $addResult['inboard_outboard_name'];
            $start_date_db               = $addResult['start_date'];
            $end_date_db                = $addResult['end_date'];
            
            $start_date = explode('-', $start_date_db);
            $start_date = $start_date[2]."/".$start_date[1]."/".$start_date[0];
            if(!empty($end_date_db))
            {
              $end_date = explode('-', $end_date_db);
             $end_date = $end_date[2]."/".$end_date[1]."/".$end_date[0];
            }
            else
            {
              $end_date ="";
            }

             
          }

          $attributes = array("class" => "form-horizontal", "id" => "dynamic_form", "name" => "dynamic_form" , "novalidate");
    
         if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/edit_dynamic_form", $attributes);
          $cnt                      = count($editres);
          $dynamic_field_sl         = $editres[0]['dynamic_field_sl'];
          $vesseltype_id            = $editres[0]['vesseltype_id'];
          $vesseltype_name          = $editres[0]['vesseltype_name'];
          $vessel_subtype_id        = $editres[0]['vessel_subtype_id'];
          $vessel_subtype_name      = $editres[0]['vessel_subtype_name'];
          $hullmaterial_id          = $editres[0]['hullmaterial_id'];
          $hullmaterial_name        = $editres[0]['hullmaterial_name'];
          $length_over_deck         = $editres[0]['length_over_deck'];
          $engine_inboard_outboard  = $editres[0]['engine_inboard_outboard'];
          $inboard_outboard_name    = $editres[0]['inboard_outboard_name'];
          $form_id                  = $editres[0]['form_id'];
          $document_type_name       = $editres[0]['document_type_name'];          
          $heading_id               = $editres[0]['heading_id'];
          $heading_name             = $editres[0]['heading_name'];
          $label_id                 = $editres[0]['label_id'];
          $label_name               = $editres[0]['label_name'];
          $value_id                 = $editres[0]['value_id'];
          $start_date               = $editres[0]['start_date'];
          $end_date                 = $editres[0]['end_date'];
          
          $start_date = explode('-', $start_date);
          $start_date = $start_date[2]."/".$start_date[1]."/".$start_date[0];

          $end_date = explode('-', $end_date);
          $end_date = $end_date[2]."/".$end_date[1]."/".$end_date[0];
          } else {
            echo form_open("Kiv_Ctrl/Master/add_dynamic_form", $attributes);
          }
        ?>
        <!-- ------------------------------------------------- php codes ---------------------------------------------------- -->
  <div class="row py-2">
   <div class="col-12 d-flex justify-content-end">
    <table class="table table-bordered table-striped">
        <?php if(isset($addResult)){ ?>
          <input type="text" name="vesseltype_name_hidden" id="vesseltype_name_hidden" value="<?php echo $vesseltype_id;?>"/>
          <input type="text" name="vessel_subtype_name_hidden" id="vessel_subtype_name_hidden" value="<?php echo $vessel_subtype_id;?>"/>
          <input type="text" name="length_over_deck_hidden" id="length_over_deck_hidden" value="<?php echo $length_over_deck;?>"/>
          <input type="text" name="hullmaterial_name_hidden" id="hullmaterial_name_hidden" value="<?php echo $hullmaterial_id;?>"/>
          <input type="text" name="engine_inboard_outboard_hidden" id="engine_inboard_outboard_hidden" value="<?php echo $engine_inboard_outboard;?>"/>
          <input type="text" name="start_date_hidden" id="start_date_hidden" value="<?php echo $start_date_db;?>"/>
          <input type="text" name="end_date_hidden" id="end_date_hidden" value="<?php echo $end_date_db;?>"/>
        <?php } ?>
        <tr>   
   <td>Vessel Type Name<span style="color: red;">*</span></td>
   <td>       
            <select name="vesseltype_name" id="vesseltype_name" class="form-control" <?php if((isset($editres))||(isset($addResult))){?> disabled <?php } ?>>
                <?php if(isset($editres)){?>
                <option value="<?php echo $vesseltype_id;?>" id="<?php echo $vesseltype_id;?>"><?php echo $vesseltype_name;?></option>  
                <?php } ?>
                <?php if(isset($addResult)){?>
                <option value="<?php echo $vesseltype_id;?>" id="<?php echo $vesseltype_id;?>"><?php echo $vesseltype_name;?></option>  
                <?php } ?>
                <option value="">Select Vessel Type</option> 
                <?php foreach($vessel_type as $vesseltype_ids){ ?>
                <option value="<?php echo $vesseltype_ids['vesseltype_sl']; ?>" id="<?php echo $vesseltype_ids['vesseltype_sl']; ?>"><?php  echo $vesseltype_ids['vesseltype_name']; ?></option>
                <?php }  ?>
            </select> <div id="msgVal1" style="display:none"><font color='red'>Vessel Type Required!!</font></div>
            <input type="hidden" name="vesseltype_name_hidden" id="vesseltype_name_hidden">
   </td>
   <td>Vessel Sub Type Name</td> 
   <td>       
            <select name="vessel_subtype_name" id="vessel_subtype_name" class="form-control" <?php if((isset($editres))||(isset($addResult))){?> disabled <?php } ?>>
                <?php if(isset($editres)){ ?>
                <option value="<?php echo $vessel_subtype_id; ?>" id="<?php echo $vessel_subtype_id; ?>"><?php echo $vessel_subtype_name; ?></option>  
                <?php } ?>
                <?php if(isset($addResult)){?>
                <option value="<?php echo $vessel_subtype_id; ?>" id="<?php echo $vessel_subtype_id; ?>"><?php echo $vessel_subtype_name; ?></option>  
                <?php } ?>
                <option value="">Select Vessel Sub Type</option> 
                <?php foreach($vesselsub_type as $vesselsubtype_id){ ?>
                <option value="<?php echo $vesselsubtype_id['vessel_subtype_sl']; ?>" id="<?php echo $vesselsubtype_id['vessel_subtype_sl']; ?>"><?php echo $vesselsubtype_id['vessel_subtype_name']; ?></option>
                <?php }  ?>
            </select> 
            <input type="hidden" name="vessel_subtype_name_hidden" id="vessel_subtype_name_hidden">
  </td>   
  </tr>
        <tr> 
         <td>Hull Material<span style="color: red;">*</span></td>
         <td>        
                 <select name="hullmaterial_name" id="hullmaterial_name" class="form-control " <?php if((isset($editres))||(isset($addResult))){?> disabled <?php } ?>>
                      <?php if(isset($editres)){?>
                      <option value="<?php echo $hullmaterial_id; ?>" id="<?php echo $hullmaterial_id; ?>"><?php if($hullmaterial_id==9999){echo "All";}else{echo $hullmaterial_name;}?></option>
                      <?php } ?>
                      <?php if(isset($addResult)){?>
                      <option value="<?php echo $hullmaterial_id; ?>" id="<?php echo $hullmaterial_id; ?>"><?php if($hullmaterial_id==9999){echo "All";}else{echo $hullmaterial_name;}?></option>
                      <?php } ?>
                      <option value="">Select Hull Material</option> 
                      <option value="9999" id="9999">All</option> 
                      <?php foreach($hullmaterial as $hull){ ?>
                      <option value="<?php echo $hull['hullmaterial_sl']; ?>" id="<?php echo $hull['hullmaterial_sl']; ?>"><?php echo $hull['hullmaterial_name']; ?></option>
                      <?php }  ?>
                 </select>
                 <input type="hidden" name="hullmaterial_name_hidden" id="hullmaterial_name_hidden"> 
                 <div id="msgVal_hull" style="display:none"><font color='red'>Hull Material Required!!</font> </div>
         </td>
         <td>Length Over the Deck<span style="color: red;">*</span></td> 
         <td>       
                 <input type="text" class="form-control" name="length_over_deck" maxlength="4" id="length_over_deck" class="form-control" value="<?php if((isset($editres))||(isset($addResult))){ echo $length_over_deck;}?>" <?php if((isset($editres))||(isset($addResult))){?> readonly <?php } ?>  placeholder="Enter Length Over the Deck" autocomplete="off"/>
                 <input type="hidden" name="length_over_deck_hidden" id="length_over_deck_hidden">
                 <div id="msgVal_lod" style="display:none">     
                <font color='red'>Length Over the Deck Required!!</font>            </div>   
         </td>
         </td>
       </tr> 
       <tr> 
   <td>Inboard/Outboard<span style="color: red;">*</span></td>
   <td>        
           <select name="engine_inboard_outboard" id="engine_inboard_outboard" class="form-control" <?php if((isset($editres))||(isset($addResult))){?> disabled <?php } ?>>
                <?php if((isset($editres))||(isset($addResult))){?>
                <option value="<?php echo $engine_inboard_outboard; ?>" id="<?php echo $engine_inboard_outboard; ?>"><?php if($engine_inboard_outboard==9999){echo "All";}else{echo $inboard_outboard_name;} ?></option>
                <?php } ?>
                <option value="">Select</option>                  
                <option value="9999" id="9999">All</option> 
                <?php foreach($boardtype as $board){ ?>
                <option value="<?php echo $board['inboard_outboard_sl']; ?>" id="<?php echo $board['inboard_outboard_sl']; ?>"><?php echo $board['inboard_outboard_name']; ?></option>
                <?php }  ?>
           </select>
           <input type="hidden" name="engine_inboard_outboard_hidden" id="engine_inboard_outboard_hidden">
           <div id="msgVal_inout" style="display:none"><font color='red'>Select Engine Inboard/Outboard!!</font> </div>
   </td>
   <td colspan="2"> </td>
  </tr> 
  <tr> 
   <td>Start Date<span style="color: red;">*</span></td>
   <td>        
           <input type="text" class="form-control dob" name="start_date" maxlength="10" id="start_date" class="form-control" value="<?php if((isset($editres))||(isset($addResult))){ echo $start_date;}?>" <?php if((isset($editres))||(isset($addResult))){?> readonly <?php } ?>  placeholder="Enter Start Date"  onchange="startDate()"  autocomplete="off" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
           <input type="hidden" name="start_date_hidden" id="start_date_hidden">
           <div id="msgVal_startdate" style="display:none"><font color='red'>Start Date Required!!</font></div>
           <div id="ajx_dup_check_div" style="display:none"></div>
   </td>
   <td>End Date</td> 
   <td>       
           <input type="text" class="form-control dob" name="end_date" maxlength="10" id="end_date" class="form-control" value="<?php if((isset($editres))||(isset($addResult))){ echo $end_date;}?>" <?php if(((isset($editres))||(isset($addResult)))&&($end_date!='00/00/0000')){?> readonly <?php } ?>  placeholder="Enter End Date"  onchange="endDate()"  autocomplete="off" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
           <input type="hidden" name="end_date_hidden" id="end_date_hidden">
           <div id="msgVal_enddate" style="display:none"><font color='red'>End Date Required!!</font></div>
   </td>
 </tr> 
      <tr> 
       <td>Form Name<span style="color: red;">*</span></td>
       <td>        
               <select name="document_type_name" id="document_type_name" class="form-control"<?php if(isset($editres)){?> disabled <?php } ?>>
                    <?php if(isset($editres)){?>
                    <option value="<?php echo $form_id; ?>" id="<?php echo $form_id; ?>"><?php echo $document_type_name; ?></option>
                    <?php } ?>
                    <option value="">Select Form</option> 
                    <?php foreach($formname as $form_ids){ ?>
                    <option value="<?php echo $form_ids['document_type_sl']; ?>" id="<?php echo $form_ids['document_type_sl']; ?>"><?php echo $form_ids['document_type_name']; ?></option>
                    <?php }  ?>
               </select>
               <input type="hidden" name="document_type_name_hidden" id="document_type_name_hidden">
               <div id="msgVal2" style="display:none"><font color='red'>Form Name Required!!</font>  </div>
       </td>
       <td>Heading Name<span style="color: red;">*</span></td> 
       <td>       
          <input type="hidden" name="date1" id="date1" value="">
          <input type="hidden" name="date2" id="date2" value="">

               <select name="heading_name" id="heading_name" class="form-control" <?php if(isset($editres)){?> disabled <?php } ?> onclick="dynamic_date()" >
                    <?php if(isset($editres)){?>
                    <option value="<?php echo $heading_id; ?>" id="<?php echo $heading_id; ?>"><?php echo $heading_name; ?></option>
                    <?php } ?>
                    <option value="">Select Heading</option> 
                    <?php foreach($heading as $heading_id){ ?>
                    <option value="<?php echo $heading_id['heading_sl']; ?>" id="<?php echo $heading_id['heading_sl']; ?>"><?php echo $heading_id['heading_name']; ?></option>
                    <?php }  ?>
               </select> <div id="msgVal3" style="display:none"><font color='red'>Heading Required!!</font> </div>
       </td>
 </tr> 
 <?php if(isset($editres)){?>
   <tr>
    <td colspan="4">
      <!--- ----------------------------------------------- Inner Table starts here -------------------------------------------- -->
             <table class="table table-bordered table-striped">

      <?php 
         if(isset($editres)){ foreach ($editres as $value) { 
         $label_id=$value['label_id'];
         $label_name=$value['label_name'];
         $table_name =$value['table_name'];
         $value_id=$value['value_id'];
         $label_status=$value['label_value_status'];
         $hullmaterial_id=$value['hullmaterial_id'];
         $engine_inboard_outboard=$value['engine_inboard_outboard'];
        if($table_name=='')
        { 
       
        if($label_id==8)
        {//length over the deck
      ?>
      <tr>
          <td>
          <input type="checkbox" <?php if($label_status!=0){ ?> checked="checked" <?php } ?> name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>"  onclick="checkedVal(<?php echo $label_id;?>)"></td>
          <td><?php echo $label_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td>Value</td>
          <td><input type="text" name="lab_values_<?php echo $label_id;?>" id="lab_values_<?php echo $label_id;?>" onchange="checkboxVal_change(<?php echo $label_id;?>)" onclick="checkboxVal(<?php echo $label_id;?>)" maxlength="50" class="form-control" placeholder=" Enter Values" autocomplete="off">
          <input type="hidden" name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>" >
          <input type="hidden" name="lab_values_<?php echo $label_id;?>" id="lab_values_<?php echo $label_id;?>" value="">
          <div id="valid_err_msg_<?php echo $label_id; ?>"></div>
          </td>
      </tr>
      <?php
        }
        else
        {
      ?>
      <tr>
          <td>
          <input type="checkbox" <?php if($label_status!=0){ ?> checked="checked" <?php } ?> name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>"  onclick="checkedVal(<?php echo $label_id;?>)"></td>
          <td><?php echo $label_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td>Value</td>
          <td><input type="text" value="<?php echo $value_id;?>" name="lab_values_<?php echo $label_id;?>" id="lab_values_<?php echo $label_id;?>" onchange="checkboxVal_change(<?php echo $label_id;?>)" onclick="checkboxVal(<?php echo $label_id;?>)" maxlength="50" class="form-control" placeholder=" Enter Values" autocomplete="off"><div id="valid_err_msg_<?php echo $label_id; ?>"></div></td>
      </tr>
      <?php
        }  
        } 
      if($table_name!='')
        { 
          $tab_det  = explode('_',$table_name);
          $tab_det_val  = $tab_det[1];
          $tab_det_val2 = $tab_det[2];
          if((isset($tab_det[3]))&&($tab_det[3] != "master"))
          {
            $tab_det_val3 = $tab_det[3];            
            $tab_det_val    = $tab_det[1]."_".$tab_det[2]."_".$tab_det_val3;            
          }
          else if((isset($tab_det[3]))&&($tab_det[3] == "master"))
          {                       
            $tab_det_val    = $tab_det[1]."_".$tab_det[2];            
          }
          else
          {
            $tab_det_val    = $tab_det[1];
          }
          $tab_sl=$tab_det_val."_sl";
          $tab_name=$tab_det_val."_name";

          $helper_table=$this->Master_model->get_specific_table($table_name);//print_r($helper_table);
          
          $value_id  = explode(',',$value_id);
        if($label_id==25)
          { 
          ?>
          <tr>
            <td>
      <input type="checkbox" <?php if($label_status!=0){ ?> checked="checked" <?php } ?> disabled name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>" onclick="checkedVal(<?php echo $label_id;?>)"></td>
      <td><?php echo $label_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td>Value</td>
      <td>
        <select  class="js-example-basic-single" disabled name="lab_values_<?php echo $label_id;?>" id="lab_values_<?php echo $label_id;?>" onclick="checkboxVal(<?php echo $label_id;?>)" onchange="checkboxVal_change(<?php echo $label_id;?>)" >
    <?php   
          foreach ($helper_table as $value) 
                  {
                    if($engine_inboard_outboard==9999){$value[$tab_sl]=9999;$value[$tab_name]="All";}
                    if($value[$tab_sl]==$engine_inboard_outboard)
                    {
    ?>                      
          <option value="<?php echo $value[$tab_sl];?>" selected="selected" ><?php echo $value[$tab_name];?></option>
    <?php             }

                  }
    ?>
           </select>
           <input type="hidden" name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>" >
           <input type="hidden" name="lab_values_<?php echo $label_id;?>" id="lab_values_<?php echo $label_id;?>" value="<?php echo $value[$tab_sl];?>">
      </td>
      </tr>
    <?php }
          else if($label_id==13)
          { 
    ?>
    <tr>
      <td>
      <input type="checkbox" <?php if($label_status!=0){ ?> checked="checked" <?php } ?> disabled name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>" onclick="checkedVal(<?php echo $label_id;?>)"></td>
      <td><?php echo $label_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td>Value</td>
      <td>
        <select  class="js-example-basic-single" disabled name="lab_values_<?php echo $label_id;?>" id="lab_values_<?php echo $label_id;?>" onclick="checkboxVal(<?php echo $label_id;?>)" onchange="checkboxVal_change(<?php echo $label_id;?>)">
    <?php   
          foreach ($helper_table as $value) 
                  {
                    if($hullmaterial_id==9999){$value[$tab_sl]=9999;$value[$tab_name]="All";}
                    if($value[$tab_sl]==$hullmaterial_id)
                    {
    ?>                      
          <option value="<?php echo $value[$tab_sl];?>" selected="selected" ><?php echo $value[$tab_name];?></option>
    <?php             }
                  }
    ?>
           </select>
           <input type="hidden" name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>" >
           <input type="hidden" name="lab_values_<?php echo $label_id;?>" id="lab_values_<?php echo $label_id;?>" value="<?php echo $value[$tab_sl];?>">
    </td>
    </tr>

    <?php     } 
          else if($label_id==5)
          { //Vessel type
    ?>
    <tr>
      <td>
      <input type="checkbox" <?php if($label_status!=0){ ?> checked="checked" <?php } ?> disabled name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>" onclick="checkedVal(<?php echo $label_id;?>)"></td>
      <td><?php echo $label_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td>Value</td>
      <td>
        <select  class="js-example-basic-single" disabled name="lab_values_<?php echo $label_id;?>" id="lab_values_<?php echo $label_id;?>" onclick="checkboxVal(<?php echo $label_id;?>)" onchange="checkboxVal_change(<?php echo $label_id;?>)">
          <?php   
          foreach ($helper_table as $value) 
                  {
                    if($value[$tab_sl]==$vesseltype_id)
                    {   ?>                      
          <option value="<?php echo $value[$tab_sl];?>" selected="selected" ><?php echo $value[$tab_name];?></option>
            <?php             }     }  ?>
           </select>
           <input type="hidden" name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>" >
           <input type="hidden" name="lab_values_<?php echo $label_id;?>" id="lab_values_<?php echo $label_id;?>" value="<?php echo $value[$tab_sl];?>">
          </td>
          </tr>
          <?php } 

                else if($label_id==6)
                { //Vessel sub type
          ?>
          <tr>
      <td>
      <input type="checkbox" <?php if($label_status!=0){ ?> checked="checked" <?php } ?> disabled name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>" onclick="checkedVal(<?php echo $label_id;?>)"></td>
      <td><?php echo $label_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td>Value</td>
      <td>
        <select  class="js-example-basic-single" disabled name="lab_values_<?php echo $label_id;?>" id="lab_values_<?php echo $label_id;?>" onclick="checkboxVal(<?php echo $label_id;?>)" onchange="checkboxVal_change(<?php echo $label_id;?>)">
              <?php   
                    foreach ($helper_table as $value) 
                            {
                              
                              if($value[$tab_sl]==$vessel_subtype_id)
                              {
              ?>                      
                    <option value="<?php echo $value[$tab_sl];?>" selected="selected" ><?php echo $value[$tab_name];?></option>
              <?php            }

                            }
              ?>
           </select>
          <input type="hidden" name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>" >
           <input type="hidden" name="lab_values_<?php echo $label_id;?>" id="lab_values_<?php echo $label_id;?>" value="<?php echo $value[$tab_sl];?>">
          </td>
          </tr>

          <?php     } 
                    else 
                    {
            ?> 
          <tr>
          <td>
          <input type="checkbox" <?php if($label_status!=0){ ?> checked="checked" <?php } ?> name="lab[]" id="lab_<?php echo $label_id;?>" value="<?php echo $label_id;?>"  onclick="checkedVal(<?php echo $label_id;?>)"></td>
          <td><?php echo $label_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td>Value</td>
          <td>
            <select  class="js-example-basic-single"  multiple="multiple" data-placeholder="Select the List" name="lab_values_<?php echo $label_id;?>[]" id="lab_values_<?php echo $label_id;?>" onchange="checkboxVal_change(<?php echo $label_id;?>)" onclick="checkboxVal(<?php echo $label_id;?>)"  >
              
                    <?php 
                        foreach ($helper_table as $value) 
                        {
                          $helper_tab_sl=$value[$tab_sl]; 
                            
                            if(in_array($helper_tab_sl, $value_id))
                  { ?>
          <option value="<?php echo $value[$tab_sl];?>" selected ><?php echo $value[$tab_name];?></option>
            <?php   
                }
                else
                {
            ?> 
                        <option value="<?php echo $value[$tab_sl];?>" ><?php echo $value[$tab_name];?></option>
            <?php   
                } 
                }
            ?>
            </select> <div id="valid_err_msg_<?php echo $label_id; ?>"></div> 
          </td>
      </tr>
      <?php  } } ?>
      <?php } } ?>

             </table>
      <!--- ----------------------------------------------- Inner Table ends here -------------------------------------------- -->
    </td>
  </tr>
       <?php } ?>
        <tr><td colspan="4"><table id="label_list" class="table table-bordered table-striped"></table></td></tr> 
      </table>
  </div> <!-- end of col12 -->
  <div id="label_lists" class="col-12"></div>
  <div class="col-12 d-flex justify-content-end py-2">
    <input type="submit" class="btn btn-success btn-flat btn-point pull-right" name="dynamic_ins" value="Save Details" id="dynamic_ins" onClick="ins_dynamicform()"> 
          <?php if(isset($editres)){ ?>
          <input type="hidden" name="dynamic_field_sl" id="dynamic_field_sl" value="<?php echo $heading_id;?>"/>
          <input type="hidden" name="vesseltype_name" id="vesseltype_name" value="<?php echo $vesseltype_id;?>"/>
          <input type="hidden" name="vessel_subtype_name" id="vessel_subtype_name" value="<?php echo $vessel_subtype_id;?>"/>
          <input type="hidden" name="hullmaterial_name" id="hullmaterial_name" value="<?php echo $hullmaterial_id;?>"/>
          <input type="hidden" name="heading_name" id="heading_name" value="<?php echo $heading_id;?>"/>
          <input type="hidden" name="document_type_name" id="document_type_name" value="<?php echo $form_id;?>"/>
          <input type="hidden" name="start_date" id="start_date" value="<?php echo $start_date;?>"/>
        <?php } ?>
  </div> <!-- end of col12 -->
  </div> <!-- end of row -->
  <?php  echo form_close(); ?>
</div> <!-- end of container fluid -->