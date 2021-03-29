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
<?php
      $length = count($copiedData);
      $primaryValue='';
      for ($i = 0; $i < $length; $i++) 
      {
       $primaryValue.=$copiedData[$i]['dynamic_field_sl'].",";
      }
      $primaryValue=rtrim($primaryValue,", ");
 ?>

<script type="text/javascript" language="javascript">
$("#vesseltype_name").change(function(){
    
    var vesseltype_id=$("#vesseltype_name").val();//alert(vesseltype_id);
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';

    if(vesseltype_id != '')
    { 
    $("#vesseltype_name_hidden").val(vesseltype_id);


    $('#msgVal1').hide();
    $.ajax
      ({
        type: "POST",
        url:"<?php echo site_url('/Kiv_Ctrl/Master/dynamic_vesselsubtype_ajax')?>",
        data:{vesseltype_id:vesseltype_id,'csrf_test_name': csrf_token},
        success: function(data)
        {        
        $("#vessel_subtype_name").html(data);
        }
      });
    }
  });

$('#dynamicCopy_ins').click(function () { 

            if ($("#vesseltype_name").val() == '') {
                $('#msgVal1').show();
                return false;
            }

            if ($("#hullmaterial_name").val() == '') {
                $('#msgVal_hull').show();
                return false;
            }

            if ($("#engine_inboard_outboard").val() == '') {
                $('#msgVal_inout').show();
                return false;
            }


            if ($("#length_over_deck").val() == '') {
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
                      
            if ($("#start_date").val() == '') {
                $('#msgVal_startdate').show();
                return false;
            }


            if (($("#vesseltype_name").val() != '')&&($("#hullmaterial_name").val() != '')&&($("#engine_inboard_outboard").val() != '')&&($("#length_over_deck").val() != '')&&($("#document_type_name").val() != '')&&($("#heading_name").val() != '')&&($("#start_date").val() != '')){ 
                return true;
            }
})


</script>
        <?php 
        if($this->session->flashdata('msg'))
          {
            echo $this->session->flashdata('msg');
          }
        ?>

<?php 
    $attributes = array("class" => "form-horizontal", "id" => "addCopiedForm_Ajax", "name" => "addCopiedForm_Ajax" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/edit_dynamic_form", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/copyFormData_ajax", $attributes);
 }?>
<div class="row  no-gutters">
 <div id="msgDiv" class="alert alert-info alert-dismissible col-12" style="display:none"></div> 

  <div class="col-12 d-flex justify-content-end">
          <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/copyDynamicform"?>"  class="btn btn-default btn-flat"><i class="fas fa-long-arrow-alt-left"></i> &nbsp; Back </a>
 </div> <!-- end of col12 -->
</div> <!-- end of row -->

<div class="row no-gutters">
  <div class="col-4">
    <div class="row  no-gutters sourcehead">
      <div class="col-12 d-flex justify-content-center">
        <i class="fas fa-server"></i>&nbsp;&nbsp;Source Vessel
      </div> <!-- end of inner col12 -->
    </div>
      <div class="row  no-gutters ">
      <div class="col-12">
          <ul class="list-group list-group-unbordered">               
        <li class="list-group-item">&nbsp; Vessel Types <div class="pull-right"> <span class="pull-leftlabel label-primary"><?php echo urldecode($vesselName); ?></span> </div></li>
          
        <li class="list-group-item">&nbsp; Vessel Sub Type <div class="pull-right"> <span class="pull-rightlabel label-primary"><?php echo urldecode($subvesselName); ?></span></div></li>
          
        <li class="list-group-item">&nbsp; Hull Material <div class="pull-right"> <span class="pull-rightlabel label-success"><?php echo urldecode($hullName); ?></span></div></li>
          
        <li class="list-group-item">&nbsp; Engine  <div class="pull-right"> <span class="pull-rightlabel label-success"><?php echo $boardName; ?></span></div></li>
          
        <li class="list-group-item">&nbsp; Length Over the Deck  <div class="pull-right"> <span class="pull-rightlabel label-success"><?php echo $lengthOverDeck; ?>m</span></div></li>
         
        <li class="list-group-item">  &nbsp; Start Date <div class="pull-right">  <span class="pull-rightlabel label-info"><?php echo $startDate; ?></span></div></li>
          
        <li class="list-group-item"> &nbsp; End Date  <div class="pull-right"> <span class="pull-rightlabel label-info"><?php echo $endDate; ?> </span></div></li>
          
        <li class="list-group-item">&nbsp; Form Name  <div class="pull-right"> <span class="pull-rightlabel label-warning"><?php echo urldecode($hidformName); ?></span></div></li>

    </ul>
      </div> <!-- end of inner col12 -->
    </div> <!-- end of inner row -->
  </div> <!-- end of col4 -->
  <div class="col-1" style="padding-top: 20%;">
    <i class="fa fa-fw   fa-angle-double-right fa-3x"></i>
  </div> <!-- end of col1 -->
  <div class="col-7 ">
    <div class="row no-gutters desthead">
      <div class="col-12 d-flex justify-content-center">
        <i class="fas fa-database"></i>&nbsp;&nbsp;Destination Vessel 
      </div> <!-- end of col12 -->
    </div>
    <div class="row no-gutters destbody">
      <div class="col-6">
        <div class="form-group2">
                  <p class="lead"> Vessel Type </p>
                  <!-- <select name="vesseltype_name" id="vesseltype_name" class="form-control js-example-basic-single"  > js-example-basic-single changed as select2 (the base copy from local system ), bcoz some errors and design split occurs.-->   
                  <select name="vesseltype_name" id="vesseltype_name" class="form-control select2"  >     
                  <option value="">Select Vessel Type</option> 
                  <?php foreach($vessel_type as $vesseltype_ids){ ?>
                  <option value="<?php echo $vesseltype_ids['vesseltype_sl']; ?>" id="<?php echo $vesseltype_ids['vesseltype_sl']; ?>"><?php  echo $vesseltype_ids['vesseltype_name']; ?></option>
                  <?php }  ?>
                  </select> <div id="msgVal1" style="display:none"><font color='red'>Vessel Type Required!!</font></div>
                  <input type="hidden" name="vesseltype_name_hidden" id="vesseltype_name_hidden">
              </div> <!-- end of form group -->
      </div> <!-- end of col6 -->
      <div class="col-6">
        <div class="form-group">
                  <p class="lead">Vessel SubType</p>
                  <!-- <select name="vessel_subtype_name" id="vessel_subtype_name" class="form-control js-example-basic-single "> -->
                  <select name="vessel_subtype_name" id="vessel_subtype_name" class="form-control select2 ">
                  <option value="">Select Vessel Sub Type</option> 
                  <?php foreach($vesselsub_type as $vesselsubtype_id){ ?>
                  <option value="<?php echo $vesselsubtype_id['vessel_subtype_sl']; ?>" id="<?php echo $vesselsubtype_id['vessel_subtype_sl']; ?>"><?php echo $vesselsubtype_id['vessel_subtype_name']; ?></option>
                  <?php }  ?>
                  </select> 
                  <input type="hidden" name="vessel_subtype_name_hidden" id="vessel_subtype_name_hidden">
              </div> <!-- end of form group -->
      </div> <!-- end of col6 -->
      <div class="col-6">
          <div class="form-group">
                 <p class="lead">Hull Material </p>
                  <!-- <select name="hullmaterial_name" id="hullmaterial_name" class="form-control js-example-basic-single" style="width: 100%;"> -->
                  <select name="hullmaterial_name" id="hullmaterial_name" class="form-control select2" style="width: 100%;">
                  <option value="">Select Hull Material</option> 
                  <option value="9999" id="9999">All</option> 
                  <?php foreach($hullmaterial as $hull){ ?>
                  <option value="<?php echo $hull['hullmaterial_sl']; ?>" id="<?php echo $hull['hullmaterial_sl']; ?>"><?php echo $hull['hullmaterial_name']; ?></option>
                  <?php }  ?>
                 </select>
                 <input type="hidden" name="hullmaterial_name_hidden" id="hullmaterial_name_hidden"> 
                 <div id="msgVal_hull" style="display:none"><font color='red'>Hull Material Required!!</font>
                 </div>
                 </div> <!-- end of form group -->
      </div> <!-- end of col6 -->
      <div class="col-6">
        <div class="form-group">
        <p class="lead">Engine <!--Inboard/Outboard--></p>
                <!-- <select name="engine_inboard_outboard" id="engine_inboard_outboard" class=" form-control js-example-basic-single" style="width: 100%;"> -->
                <select name="engine_inboard_outboard" id="engine_inboard_outboard" class=" form-control select2" style="width: 100%;">
                <option value="">Select</option>                  
                <option value="9999" id="9999">All</option> 
                <?php foreach($boardtype as $board){ ?>
                <option value="<?php echo $board['inboard_outboard_sl']; ?>" id="<?php echo $board['inboard_outboard_sl']; ?>"><?php echo $board['inboard_outboard_name']; ?></option>
                <?php }  ?>
                </select>
               <input type="hidden" name="engine_inboard_outboard_hidden" id="engine_inboard_outboard_hidden">
               <div id="msgVal_inout" style="display:none"><font color='red'>Select Engine Inboard/Outboard!!</font> </div>
              </div> <!-- end of form group -->
      </div> <!-- end of col6 -->
      <div class="col-6">
       <div class="form-group">
                <p class="lead">Length Over the Deck </p>
                  <div class="input-group">
                    <input type="text" class="form-control" maxlength="2" autocomplete="off" title="Enter Length Over the Deck" data-validation="number" name="length_over_deck" value="" id="length_over_deck"  aria-label="length" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <span class="input-group-text" id="basic-addon2">m</span>
                    </div>
                   <input type="hidden" name="length_over_deck_hidden" id="length_over_deck_hidden">
                    <div id="msgVal_lod" style="display:none"> 
                  <font color='red'>Length Over the Deck Required!!</font>
                  </div>
                </div> <!--input group -->
                </div> 
                  <!-- end of form group -->
      </div> <!-- end of col6 -->
      <div class="col-6">
        <div class="form-group">
                  <p class="lead">Start Date </p>
                  <input type="text" name="start_date" maxlength="50" id="start_date" class="form-control dob" value=""   placeholder="Enter Start Date"  onchange="startDate()"  autocomplete="off" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                  
                  <div id="msgVal_startdate" style="display:none"><font color='red'>Start Date Required!!</font></div>
                  <div id="ajx_dup_check_div" style="display:none"></div>
                </div> <!-- end of form group -->
      </div> <!-- end of col6 -->
      <div class="col-6">
         <div class="form-group">
                <p class="lead">End Date </p>
                  <input type="text" name="end_date" maxlength="50" id="end_date" class="form-control dob" value=""  placeholder="Enter End Date"  onchange="endDate()"  autocomplete="off" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                  
                </div> <!-- end of form group -->
                <div id="msgVal_enddate" style="display:none"><font color='red'>End Date Required!!</font></div>
      </div> <!-- end of col6 -->
      <div class="col-6">
        <p class="lead">. </p>
         <input type="hidden" name="hidformId" value="<?php echo urldecode($hidformId); ?>" id="hidformId"  class="form-control"  autocomplete="off" />
      </div>
      <div class="col-12 d-flex justify-content-end">
         <input type="hidden" name="copiedPrimaryValue_hidden" id="copiedPrimaryValue_hidden" value="<?php echo $primaryValue; ?>">
                  <input type="submit" class="btn btn-point btn-danger pull-right" name="dynamicCopy_ins" value="Copy Details" id="dynamicCopy_ins" ><?php //onClick="ins_dynamicCopyform()" commented on 28-10-2020?>
                  
      </div> <!-- end of col6 -->
    </div> <!-- end of row -->
  </div> <!-- end of col7 -->
</div> <!-- end of row -->
<?php  echo form_close(); ?>