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
    <li class="breadcrumb-item"><a class="no-link"  href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==3) { ?>
    <li class="breadcrumb-item"><a class="no-link"  href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome/<?php echo $modidenc;?>"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a class="no-link"  href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==14) { ?>
    <li class="breadcrumb-item"><a class="no-link"  href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==11) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
</nav> 
<!-- End of breadcrumb -->
<?php 
$sess_usr_id    = $this->session->userdata('int_userid'); 

$attributes = array("class" => "form-horizontal", "id" => "form_tariff", "name" => "form_tariff" , "novalidate"); 
              echo form_open("Kiv_Ctrl/Survey/index", $attributes);  
  ?>
<!-- -------------------------- Main Content container starts here ---------------------------------------- -->
<div class="main-content ui-innerpage p-1">
	<div class="row no-gutters p-1 justify-content-center">
		<div class="col-8 text-center">
			<div class="alert bg-darkorchid" role="alert">
				Tariff Calculator 
			</div> <!-- end of alert -->
		</div> <!-- end of col6 --> 
		<div class="col-8">
			<div class="row no-gutters p-2 bg-white">
				<div class="col-6">
					Vessel Type
				</div> 
				<div class="col-6">
					<select class="form-control contentfont" name="vesselType_name" id="vesselType_name">
			            <?php foreach($vesselType as $vesl_typ_res){
			                $mal_name = $vesl_typ_res['vesseltype_mal_name']; 
			                $name     = $vesl_typ_res['vesseltype_name']; 
			              ?>
			              <option value="<?php echo $vesl_typ_res['vesseltype_sl'];?>"><?php if(isset($val)){ echo $mal_name;} else { echo $name;}?> </option>
			            <?php }?>  
			          </select>
				</div> 
			</div> <!-- end of row -->
			<div class="row no-gutters p-2 ">
				<div class="col-6">
					Vessel Sub Type
				</div> 
				<div class="col-6">
					 <input type="hidden" name="val" id="val" value="<?php if(isset($val)){ echo $val; } else { echo "2";}?>">
			                <select name="vessel_subtype_name" id="vessel_subtype_name" class="form-control " style="width: 100%;" >
			                  <option value="">Select Vessel SubType</option>                  
			                </select>
				</div> 
			</div> <!-- end of row -->
			<div class="row no-gutters p-2  bg-white">
				<div class="col-6">
					Activity
				</div> 
				<div class="col-6">
					 <input type="hidden" name="val" id="val" value="<?php if(isset($val)){ echo $val; } else { echo "2";}?>">
                        <select class="form-control " style="width: 100%;" id="surveyName" name="surveyName" >
                  <option value="">Select Survey Type</option> 
                  <?php foreach($surveyType as $survey){ 
                    $mal_name = $survey['survey_mal_name']; 
                    $name     = $survey['survey_name']; 

                    ?>
                  <option value="<?php echo $survey['survey_sl']; ?>" id="<?php echo $survey['survey_sl']; ?>"><?php if(isset($val)){ echo $mal_name;} else { echo $name;}?></option>
                  <?php }  ?>
                </select>
				</div> 
			</div> <!-- end of row -->
			<div class="row no-gutters p-2">
				<div class="col-6">
					Form
				</div> 
				<div class="col-6">
					<select class="form-control " style="width: 100%;" id="formtypeName" name="formtypeName">
                  <option value="">Select Form</option> 
                  <?php foreach($formName as $form){ 
                    $mal_name = $form['document_type_mal_name']; 
                    $name     = $form['document_type_name'];
                    ?>
                  <option value="<?php echo $form['document_type_sl']; ?>" id="<?php echo $form['document_type_sl']; ?>"><?php if(isset($val)){ echo $mal_name;} else { echo $name;}?></option>
                  <?php }  ?>
                </select>
				</div> 
			</div> <!-- end of row -->
			<div class="row no-gutters p-2  bg-white">
				<div class="col-6">
					 Tonnage
				</div> 
				<div class="col-6">
					<div class="input-group col-8 port-content-noborder">
				        <input type="text" class="form-control" placeholder="Specify tonnage" name="tonnage" id="tonnage" aria-label="Tonnage" aria-describedby="basic-addon2">
				        <div class="input-group-append">
				          <span class="input-group-text" id="basic-addon2">Ton</span>
				        </div>
				      </div> <!-- end of input group -->
				</div> 
			</div> <!-- end of row -->
			<div class="row no-gutters p-2">
				<div class="col-12 text-center">
					 <button type="button" name="tariff_calc" id="tariff_calc" class="btn btn-point bg-royalblue contentfont"> <i class="fas fa-square-root-alt"></i> &nbsp; Calculate Tariff </button>
				</div> 
			</div> <!-- end of row -->
		</div> <!-- end of col8 -->
	</div> <!-- end of row -->
	<div class="row no-gutters p-2 justify-content-center" >
		<div class="col-8 text-center">
			<div class="alert bg-fuchsia-active text-white" role="alert"  id="tariff_amt_div">
			</div> 
		</div> <!-- end of col12 -->
	</div> <!-- end of row -->
</div> <!-- end of main-content -->
<!-- -------------------------- Main Content container ends here ---------------------------------------- -->
<?php  echo form_close(); ?>  
<script type="text/javascript">
	$(document).ready(function(){
		   $("#tariff_amt_div").hide();   
		});

  $("#vesselType_name").change(function()
  { 
    var vesseltype_id=$("#vesselType_name").val(); 
    var val=$("#val").val(); 
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';

    if(vesseltype_id != '')
    {
    
      $.ajax
        ({ 
          type: "POST",
          url:"<?php echo site_url('/Main_login/tariff_vesselsubtype_ajax/')?>",
          data:{vesseltype_id:vesseltype_id, val:val, 'csrf_test_name': csrf_token},
          success: function(data)
          {   //alert(data); exit;    
          $("#vessel_subtype_name").html(data);      
            
          }
        });
    }
  });
  $("#tariff_calc").click(function()
  { 
    var vesselType_name     = $("#vesselType_name").val(); 
    var vessel_subtype_name = $("#vessel_subtype_name").val(); 
    var surveyName          = $("#surveyName").val();
    var formtypeName        = $("#formtypeName").val();
    var tonnage             = $("#tonnage").val();
    var val                 = $("#val").val();
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';

    if(surveyName==''){
      alert("Survey Type Required!!!");
      $("#surveyName").focus();
      return false;
    }
    else if(formtypeName==''){
      alert("Form Required!!!");
      $("#formtypeName").focus();
      return false;
    } 
    else if(tonnage==''){
      alert("Tonnage Required!!!");
      $("#tonnage").focus();
      return false;
    }
    else {
      $.ajax
        ({ 
          type: "POST",
          url:"<?php echo site_url('/Main_login/tariff_calculate_ajax/')?>",
          data:{vesselType_name:vesselType_name,vessel_subtype_name:vessel_subtype_name,surveyName:surveyName,formtypeName:formtypeName, tonnage:tonnage, val:val, 'csrf_test_name': csrf_token},
          success: function(data)
          {   //alert(data); exit;    
          	$("#tariff_amt_div").show(); 
          $("#tariff_amt_div").html(data);      
            
          }
        });
    }
  });
</script>