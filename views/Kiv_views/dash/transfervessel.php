<script language="javascript">

function IsNumeric(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)) 
  {
      return true;
  }
  else 
  {
      window.alert("This field accepts only Numbers");
      return false;
  }
}
function validateEmail(email) {
 
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( email ) ) {
      alert("Invalid Email");
      document.getElementById('newowner_mail').value='';
        return false;
    } else {
        return true;
    }
}
function validateEmailout(email) {
 
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( email ) ) {
      alert("Invalid Email");
      document.getElementById('newowner_mail_out').value='';
        return false;
    } else {
        return true;
    }
}
</script>
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

<!-- <div class="alert alert-primary" role="alert"> -->
<!-- Start of breadcrumb -->
<nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/VesselChange/transfervessel_list">List Page</a></li>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ">  <!-- Container Class overridden for edge free design -->
  <div class="row">
    <div class="col-12"> 
      <div class="row">
        <div class="col-2 mt-1 ml-5">
           <button type="button" class="btn btn-primary kivbutton btn-block"> Form 19</button> 
        </div> <!-- end of col-2 -->
        <div class="col mt-2 text-primary">
          Transfer of Registered Vessels 
        </div>
      </div> <!-- inner row -->
    </div> <!-- end of col-12 add-button header --> 
    <div class="col-12 mt-2 ml-2 newfont">
<!--__________________________________________________________________________-->
      <div id="form12show">
        <div class="row no-gutters">
          <div class="col-12 ">
            <div class="table-responsive">
              <table class="table table-hover ">
                <tbody>
                <?php 
                //print_r($vesselDet); 
                foreach ($vesselDet as $vesselDetails) 
                {

                  $vessel_sl					       =  $vesselDetails['vessel_sl'];
                  $vessel_survey_number			 =  $vesselDetails['vessel_survey_number'];
                  $vessel_name					     =  $vesselDetails['vessel_name'];
                  $reference_number				   =  $vesselDetails['reference_number'];
                  $build_date					       =  $vesselDetails['build_date'];
                  $vessel_registry_port_id	 =  $vesselDetails['vessel_registry_port_id'];
                  $vessel_total_tonnage			 =  $vesselDetails['vessel_total_tonnage'];
                  $vessel_registration_number=  $vesselDetails['vessel_registration_number'];
                  $vessel_expected_completion=  $vesselDetails['vessel_expected_completion'];
                  
                }
                $reg_port                    = $this->Vessel_change_model->get_registry_port_id($vessel_registry_port_id);
                if(!empty($reg_port))
                {
                  foreach($reg_port as $res_port)
                  {
                    $portofregistry_name     = $res_port['vchr_portoffice_name'];
                        
                  }
                } 
                $user_details                = $this->Bookofregistration_model->get_user_id($vessel_sl);
                $data['user_details']        = $user_details;
                if(!empty($user_details))
                {
                  	$id                      = $user_details[0]['user_id'];
                  	$customer_details        = $this->Bookofregistration_model->get_customer_details($id);
                	  $data['customer_details']= $customer_details;

                    if(!empty($customer_details))
                    {
                      foreach($customer_details as $res_customer)
                      {
                        $user_name           = $res_customer['user_name'];
                        $user_address        = $res_customer['user_address'];
                      }
                    } 

                }
                else

                {
                  $user_name                 = "";
                  $user_address              = "";
                }

                $survey_id                   = 1;
                $engine_details              = $this->Survey_model->get_engine_details($vessel_sl,$survey_id);
                $data['engine_details']      = $engine_details;


                if(!empty($engine_details)) 
                {
                  foreach($engine_details as $key_engine)
                  {
                    $engine_type_id          = $key_engine['engine_type_id'];
                    $bhp1[]                  = $key_engine['bhp'];
                    $make_year1[]            = $key_engine['make_year'];

                    $engine_type             = $this->Survey_model->get_enginetype_name($engine_type_id);
                    $data['engine_type']     = $engine_type;
                    $engine_type_name1[]     = $engine_type[0]['enginetype_name'];

                  }
                  $bhp                       = implode(", ", $bhp1);
                  $make_year                 = implode(", ", $make_year1);
                  $engine_type_name          = implode(", ", $engine_type_name1);
                }


                $vessel_sl1                  = $this->encrypt->encode($vessel_sl); 
                $vessel_sl2                  = str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

                $status_details_sl1          = $this->encrypt->encode($status_details_sl); 
                $status_details_sl2          = str_replace(array('+', '/', '='), array('-', '_', '~'), $status_details_sl1);

                $processflow_sl1             = $this->encrypt->encode($processflow_sl); 
                $processflow_sl2             = str_replace(array('+', '/', '='), array('-', '_', '~'), $processflow_sl1);

                ?>

                <tr>
                  <td>Survey number</td>
                  <td><?php echo $vessel_survey_number; ?></td>
                  <td>Engine Make</td>
                  <td><?php echo $engine_type_name?></td>
                </tr>
                <tr>
                  <td>Vessel Name</td>
                  <td><?php echo $vessel_name; ?></td>
                  <td>BHP</td>
                  <td><?php echo $bhp; ?></td>
                </tr>
                <tr>
                  <td>Reference Number</td>
                  <td><?php echo $reference_number; ?></td>
                  <td>Tariff for Registration</td>
                  <td>Rs. <?php echo $tariff_amount; ?></td>
                </tr>
                <tr>
                  <td>Year of Make</td>
                  <td><?php echo $make_year; ?></td>
                  <td>Registration Number</td>
                  <td><?php echo $vessel_registration_number; ?></td>
                </tr>
                <tr>
                  <td colspan="2">Port of Registry</td>
                  <td colspan="2"><?php echo $portofregistry_name; ?></td>
                </tr>
                <?php $cnt=count($vesselDet);  ?>
    
                </tbody>
              </table>
            </div> <!-- end of table div -->
          </div> <!--end of col12 -->
        </div> <!--end of row -->
      
      <form name="form12" id="form12" method="post"  enctype="multipart/form-data" action="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/payment_details_form18_trans/'.$vessel_sl2.'/'.$processflow_sl2.'/'.$status_details_sl2 ?>">
  


      <div class="row no-gutters eventab">
          <div class="col-3 px-2 py-2">Transfer Type</div>
          <div class="col-6 px-2 py-2"> 
            <input tabindex="10" type="radio" value="1" name="transfer_type" id="transfer_type">
            <label> Transfer within Kerala  </label> 
            <input tabindex="10" type="radio" value="2" name="transfer_type" id="transfer_type">
            <label> Transfer Outside Kerala </label> 
          </div>
      </div>
      <div id="transfer_within_div" style="display: none;">
          <div class="row no-gutters oddtab">
            <div class="col-3 px-2 py-2">If Change in Owner</div>
            <div class="col-6 px-2 py-2"> 
              <input  tabindex="10" type="radio" value="1" name="owner_change" id="owner_change">
              <label> Yes </label>&nbsp;&nbsp;&nbsp;&nbsp;
              <input tabindex="10" type="radio" value="2" name="owner_change" id="owner_change">
              <label> No </label> 
            </div>
          </div>
      </div>
      <div id="transfer_within_noowner_div" style="display: none;">
        <div class="row no-gutters oddtab">
          <div class="col-3 px-2 py-2">New Port of Registry</div>
          <div class="col-3 px-2 py-2"> 
            <select class="form-control select2" name="portofregistry_slno" id="portofregistry_slno" title="Select  Plying Port of Registry" data-validation="required">
                <option value="">Select</option>
                <?php foreach ($plyingPort as $plyPort) { ?>
                  <option value="<?php echo $plyPort['int_portoffice_id']; ?>" <?php if($vessel_registry_port_id==$plyPort['int_portoffice_id'] ){ echo "selected";}?>><?php echo $plyPort['vchr_portoffice_name']; ?></option>
                <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div id="transfer_within_owner_div" style="display: none;">
        <div class="row no-gutters eventab">
            <div class="col-3 px-2 py-2"> Mobile Number of New Owner</div>
            <div class="col-3 px-2 py-2"> 
              <input type="text" class="form-control" id="newowner_mob" name="newowner_mob" placeholder="Mobile number of New Owner" data-validation="required number" onkeypress="return IsNumeric(event);" maxlength="11">
            </div>
        </div> <!-- end of row -->
        <div class="row no-gutters eventab">
            <div class="col-3 px-2 py-2">Email ID of New Owner</div>
            <div class="col-3 px-2 py-2"> 
              <input type="text" class="form-control" id="newowner_mail" name="newowner_mail" placeholder="Email ID of New Owner" data-validation="required" onchange="return validateEmail(this.value);" >
            </div><!-- <input type="button" class="btn btn-success btn-flat btn-point btn-sm" name="btnverify" value="Verify" id="btnverify"> --><div class="col-3 px-2 py-2">
              <button type="button" class="btn btn-primary btn-flat btn-sm" name="btnverify" id="btnverify"> <i class="fas fa-check"></i><small> Verify </small></button></div>
        </div> <!-- end of row -->
        <div id="existowner_div" style="display: none;">
            
          </div>
          <div class="row no-gutters oddtab" id="port" style="display: none;">
            <div class="col-3 px-2 py-2">New Port of Registry</div>
            <div class="col-3 px-2 py-2"> 
              <select class="form-control select2" name="portofregistry_sl" id="portofregistry_sl" title="Select  Plying Port of Registry" data-validation="required">
                  <option value="">Select</option>
                  <?php foreach ($plyingPort as $plyPort) { ?>
                    <option value="<?php echo $plyPort['int_portoffice_id']; ?>" <?php if($vessel_registry_port_id==$plyPort['int_portoffice_id'] ){ echo "selected";}?>><?php echo $plyPort['vchr_portoffice_name']; ?></option>
                  <?php } ?>
              </select>
            </div>
          </div> 
      </div>
      <div id="transfer_outside_div" style="display: none;">
          <div class="row no-gutters eventab">
            <div class="col-3 px-2 py-2"> State</div>
              <div class="col-3 px-2 py-2"> 
                <select class="form-control select2" name="state_sl" id="state_sl" title="Select State" data-validation="required">
                  <option value="">Select</option>
                  <?php foreach ($states as $stt) { ?>
                    <option value="<?php echo $stt['state_sl']; ?>" ><?php echo $stt['state_name']; ?></option>
                  <?php } ?>
              </select>
              </div>
          </div>
          <div class="row no-gutters oddtab">
            <div class="col-3 px-2 py-2"> Buyer Name</div>
              <div class="col-3 px-2 py-2"> 
                <input type="text" class="form-control" id="buyer_name_out" name="buyer_name_out" placeholder="Name of Buyer" data-validation="required">
              </div>
          </div>
          <div class="row no-gutters eventab">
            <div class="col-3 px-2 py-2">Buyer Address</div>
              <div class="col-3 px-2 py-2"> 
                <textarea class="form-control" id="buyer_address_out" name="buyer_address_out" placeholder="Address of Buyer" data-validation="required"></textarea>
              </div>
          </div>
          <div class="row no-gutters eventab">
            <div class="col-3 px-2 py-2"> Mobile Number of New Owner</div>
            <div class="col-3 px-2 py-2"> 
              <input type="text" class="form-control" id="newowner_mob_out" name="newowner_mob_out" placeholder="Mobile number of New Owner" data-validation="required number" onkeypress="return IsNumeric(event);" maxlength="11">
            </div>
          </div>
          <div class="row no-gutters eventab">
            <div class="col-3 px-2 py-2">Email ID of New Owner</div>
            <div class="col-3 px-2 py-2"> 
              <input type="text" class="form-control" id="newowner_mail_out" name="newowner_mail_out" placeholder="Email ID of New Owner" data-validation="required" onchange="return validateEmailout(this.value);" >
            </div><!-- <input type="button" class="btn btn-success btn-flat btn-point btn-sm" name="btnverify" value="Verify" id="btnverify"> -->
          </div>
          <div class="row no-gutters oddtab">
            <div class="col-3 px-2 py-2"> Declaration of Buyer</div>
              <div class="col-3 px-2 py-2"> 
                <input type="file" name="buyer_decl_upload_out" id="buyer_decl_upload_out" >
              </div>
          </div> <!-- end of row -->
          <div class="row no-gutters eventab">
            <div class="col-3 px-2 py-2">Declaration of Seller</div>
              <div class="col-3 px-2 py-2"> 
                <input type="file" name="seller_decl_upload_out" id="seller_decl_upload_out" >
              </div>
          </div>
          <div class="row no-gutters oddtab">
            <div class="col-3 px-2 py-2">ID Card of Buyer</div>
              <div class="col-3 px-2 py-2"> 
                <input type="file" name="idcard_upload_out" id="idcard_upload_out" />
              </div>
          </div>
  
        </div>
</div> <!-- end of formshowdiv -->


<div id="form12pay" style="display: none;">
  <div class="row no-gutters  mx-0 mt-5 mb-5">
    <div class="col-6 d-flex justify-content-end pr-5" >
      <input type="submit" class="btn btn-success btn-flat btn-point btn-lg" name="btnsubmit" value="Submit" id="btnsubmit">&nbsp;&nbsp;&nbsp; 
 
     <input type="hidden" value="<?php echo $vessel_sl; ?>" id="vessel_sl" name="vessel_sl">
     <input type="hidden" value="<?php echo $processflow_sl; ?>" id="processflow_sl" name="processflow_sl">
     <input type="hidden" value="<?php echo $status_details_sl; ?>" id="status_details_sl" name="status_details_sl">
     <input type="hidden" value="<?php echo $vessel_registry_port_id; ?>" id="vessel_registry_port_id" name="vessel_registry_port_id">
     <input type="hidden" value="<?php echo $tariff_amount; ?>" id="dd_amount" name="dd_amount">

    </div>
  </div>
</div> <!-- end of form12pay -->

</form>
<!--__________________________________________________________________________-->
</div>
</div> <!-- end of main row -->
</div> <!-- end of container div --> <!-- end of container div -->

<script src="<?php echo base_url(); ?>plugins/js/jquery.validate.js"></script> 
<script src="<?php echo base_url(); ?>plugins/jquery.form-validator.js"></script>
 <script src="<?php echo base_url(); ?>plugins/js/inputmask.js"></script> 
<script>
  $(document).ready(function(){
////////transfer type
    $('input:radio[name="transfer_type"]').change(function(){
 
       if (this.value == '1') {  
        $("#transfer_within_div").show();
        $("#form12pay").hide();
        $("#transfer_outside_div").hide();
        $("#transfer_within_owner_div").hide();
        $("#transfer_within_noowner_div").hide();
      }
      else if (this.value == '2'){
        $("#transfer_outside_div").show();
        $("#form12pay").show();
        $("#transfer_within_div").hide();
        $("#transfer_within_owner_div").hide();
        $("#transfer_within_noowner_div").hide();
      }
      
    });
////////owner change
    $('input:radio[name="owner_change"]').change(function(){
 
      if (this.value == '1') {  
        $("#transfer_within_owner_div").show();
        $("#transfer_within_noowner_div").hide();
        $("#form12pay").hide();
      }
      else if (this.value == '2'){ 
        $("#transfer_within_noowner_div").show();
        $("#form12pay").show();
        $("#transfer_within_owner_div").hide();
      }
      
    });
//////////submit
    $("#btnsubmit").click(function()
    { 
      var regex                   = new RegExp("^[a-zA-Z][a-zA-Z0-9]+$");
      var regexname               = new RegExp("^[a-zA-Z\ \-]+$");
      var regexnum                = new RegExp("^[0-9]+$");

      var transfer_type           = $("input[name='transfer_type']:checked").val(); 
      ///Transfer within kerala(start)
      if(transfer_type==1){
        var owner_change          = $("input[name='owner_change']:checked").val(); 
        ///Change in ownership and port of registry(start)
        if(owner_change==1){
          var newowner_mob        = $('#newowner_mob').val();
          var newowner_mail       = $('#newowner_mail').val();
          var profile_status      = $('#profile_status').val();
          var portofregistry_sl   = $('#portofregistry_sl').val();

          if(portofregistry_sl=="")
            {
              alert("New Port of Registry Required!!!");
              $("#portofregistry_sl").focus();
              return false;
            }

          if(newowner_mob=="")
          {
            alert("Mobile Number Required!!!");
            $("#newowner_mob").focus();
            return false;
          }
          
          if(newowner_mail=="")
          {
            alert("Email ID Required!!!");
            $("#newowner_mail").focus();
            return false;
          }
          ///New User
          if(profile_status==0){
            var idcard_upload       = $('#idcard_upload').val();
            if(idcard_upload=="")
            {
              alert("ID Card Required!!!");
              $("#idcard_upload").focus();
              return false;
            }
          } 
          ///Existing User
          else if(profile_status>0){

            var buyer_decl_upload   = $('#buyer_decl_upload').val();
            if(buyer_decl_upload=="")
            {
              alert("Buyer Declaration Required!!!");
              $("#buyer_decl_upload").focus();
              return false;
            }

            var seller_decl_upload  = $('#seller_decl_upload').val();
            if(seller_decl_upload=="")
            {
              alert("Seller Declaration Required!!!");
              $("#seller_decl_upload").focus();
              return false;
            }

            var notary_upload       = $('#notary_upload').val();
            if(notary_upload=="")
            {
              alert("Notary Required!!!");
              $("#notary_upload").focus();
              return false;
            }
          
          }


        }
        ///Change in ownership and port of registry(end)
        ///Change in only port of registry(start)
        else {
          var portofregistry_slno   = $('#portofregistry_slno').val();
            if(portofregistry_slno=="")
            {
              alert("New Port of Registry Required!!!");
              $("#portofregistry_slno").focus();
              return false;
            }
        }
      } 
       ///Transfer within kerala(end)
      ///Transfer outside kerala(start)
      else {
          var state               = $('#state_sl').val();
          if(state=="")
          {
            alert("Select State to which vessel to be transfered!!!");
            $("#state").focus();
            return false;
          }
          var buyer_name_out      = $('#buyer_name_out').val();
          if(buyer_name_out=="")
          {
            alert("Buyer Name Required!!!");
            $("#buyer_name_out").focus();
            return false;
          } 
          else if (regexname.exec(buyer_name_out) == null) 
          {
          alert("Only alphabets,space and - allowed in Buyer Name.");
          $("#buyer_name_out").val(''); 
          $("#buyer_name_out").focus();
          return false;
          }
          var buyer_address_out   = $('#buyer_address_out').val();
          if(buyer_address_out=="")
          {
            alert("Buyer Address Required!!!");
            $("#buyer_address_out").focus();
            return false;
          }
          /*else if (regex.exec(buyer_address_out) == null) 
          {
          alert("No Special Characters allowed in Buyer Address.");
          $("#buyer_address_out").val(''); 
          $("#buyer_address_out").focus();
          return false;
          } */
          var newowner_mob_out    = $('#newowner_mob_out').val();
          if(newowner_mob_out=="")
          {
            alert("Mobile Number Required!!!");
            $("#newowner_mob_out").focus();
            return false;
          } 
          else if (regexnum.exec(newowner_mob_out) == null) 
          {
          alert("Only numbers allowed in Mobile.");
          $("#newowner_mob_out").val(''); 
          $("#newowner_mob_out").focus();
          return false;
          }
          var newowner_mail_out       = $('#newowner_mail_out').val();
          if(newowner_mail_out=="")
          {
            alert("Email ID Required!!!");
            $("#newowner_mail_out").focus();
            return false;
          } 
          
          var buyer_decl_upload_out   = $('#buyer_decl_upload_out').val();
          if(buyer_decl_upload_out=="")
          {
            alert("Buyer Declaration Required!!!");
            $("#buyer_decl_upload_out").focus();
            return false;
          }

          var seller_decl_upload_out  = $('#seller_decl_upload_out').val();
          if(seller_decl_upload_out=="")
          {
            alert("Seller Declaration Required!!!");
            $("#seller_decl_upload_out").focus();
            return false;
          }

          var idcard_upload_out       = $('#idcard_upload_out').val();
          if(idcard_upload_out=="")
          {
            alert("ID Card Required!!!");
            $("#idcard_upload_out").focus();
            return false;
          }
      }
       ///Transfer outside kerala(end)
    }); 

  });
  
  
//_________________________________________________________________________________________________//
//To submit page, on button click of pay now
$("#btnverify").click(function()
{ 


  var regex     = new RegExp("^[a-zA-Z][a-zA-Z0-9]+$");
  var regexname = new RegExp("^[a-zA-Z\ \-]+$");
  var regexnum  = new RegExp("^[0-9]+$");
  

  var newowner_mob=$('#newowner_mob').val();
  var newowner_mail=$('#newowner_mail').val();
  

  

  if(newowner_mob=="")
  {
      alert("Mobile Number Required");
      $("#newowner_mob").focus();
      return false;
  }
  else if (regexnum.exec(newowner_mob) == null) 
  {
      alert("Mobile Number should be in digits!!!");
      $("#newowner_mob").val(''); 
      $("#newowner_mob").focus();
      return false;
  }

  if(newowner_mail=="")
  {
      alert("Email ID Required!!!");
      $("#newowner_mail").focus();
      return false;
  }
  
  else {
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/VesselChange/Vessel_owner_check')?>",
      type: "POST",
      data:$('#form12').serialize(),
      //dataType: "JSON",
      success: function(data)
      { //alert(data);exit;
        //alert(data);
         
            $("#existowner_div").show();
            $("#port").show();
            $("#existowner_div").html(data);
            $("#form12pay").show();
         
         
      }
    });

  }

});


//_________________________________________________________________________________________________//


</script>