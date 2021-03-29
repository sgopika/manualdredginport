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
<script type="text/javascript">
$(document).ready(function(){

$("#user_state_id").change(function(){
  var user_state_id=$("#user_state_id").val();
  if(user_state_id != '')
  { 
    $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Registration/district/')?>"+user_state_id,
    success: function(data)
    {         
      $("#user_district_id").html(data);
    }
    });
  }

});
 
$("#user_name").change(function(){

var user_name=$("#user_name").val();
var strArray = user_name.match(/(\d+)/g);
    var i = 0;
    for(i=0; i<strArray.length;i++)
    {
      var strnum=strArray[i];
      if(strnum.length>0)
      {
        alert("Invalid Name");
        $("#user_name").val('');
      }
    }
});

//----pdf checking------//
var _URL = window.URL || window.webkitURL;
    
   $('#my-file-selector1').change(function(){
 
      var f=this.files[0];
      var fsize=f.size;
        if(fsize>1000000)
        {
          alert("Photo Size is Exeed 1MB (1024 KB)");
          $("#my-file-selector1").val('');

          return false;
        }
 

});

  


$("#user_mobile_number").change(function(){
    var mob=$("#user_mobile_number").val();

    var mob_length = mob.length; 
    if(mob_length<10)
    {
      alert('Please enter 10 Digit Mobile Number');
      $("#user_mobile_number").val('');
      return false;
    }

 if(mob!='')
     {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({type: "POST",
             url:"<?php echo site_url('Kiv_Ctrl/Registration/mobileverify')?>",
            data: { mob: mob,'csrf_test_name': csrf_token},
             success: function(data)
             { 
              if(data == "1")
              {
                alert("The Mobile Number is already Exist");
                $("#user_mobile_number").val('');
                $("#user_mobile_number").focus();
              }
             }
       });  
     }

  });

$("#user_email").change(function(){
    var email_id=$("#user_email").val();
   if(email_id!='')
     {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({type: "POST",
             url:"<?php echo site_url('Kiv_Ctrl/Registration/email_id_verify')?>",
            data: { email_id: email_id,'csrf_test_name': csrf_token},
             success: function(data)
             { 
              if(data == "1")
              {
                alert("This Email Address is already Exist");
                $("#user_email").val('');
              }
             }
       });  
     }
   
 
   
 });  




$("#user_aadhar_id").change(function(){
    var aadhar_id=$("#user_aadhar_id").val();

    var aadhar_length = aadhar_id.length; 
    if(aadhar_length<12)
    {
      alert('Please enter 12 Digit Aadhar Number');
      $("#user_aadhar_id").val('');
      return false;
    }

  });



  

$("#user_dob").change(function(){
 var user_dob=  $("#user_dob").val();
  var last2 = user_dob.substr(-4);
   if(last2>2000)
   {
       alert("Invalid Date of Birth");
        $("#user_dob").val('');
        return false;
   }
});



//----------Jquery End-------//
}); 


function validate_file(file) {
var extension = $('#my-file-selector1').val().split('.').pop().toLowerCase();
if($.inArray(extension, ['pdf']) == -1) {
alert('Sorry, invalid extension.');
$('#my-file-selector1').val('');
return false;
}
} 


function validate_aadhar(file) {
var extension = $('#my-file-selector2').val().split('.').pop().toLowerCase();
if($.inArray(extension, ['pdf']) == -1) {
alert('Sorry, invalid extension.');
$('#my-file-selector2').val('');
return false;
}

} 

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

function alpbabetspace(e) {
     var k;
     document.all ? k = e.keyCode : k = e.which;
     return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k==32);
}

function validateEmail(email) {
 
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( email ) ) {
      alert("Invalid Email");
      document.getElementById('email_id').value='';
        return false;
    } else {
        return true;
    }
}
 

</script>


<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- _____________ Include the above in your HEAD tag ______________________________-->
<body>
<section class="login-block">
<form class="needs-validation" novalidate name="form1" id="form1" action="" method="post">
<div class="container"> 
  <div class="row">
    <div class="col">      <img src="<?php echo base_url(); ?>plugins/registration/img/goklogo5.png"  alt="PortInfo">
    <input type="hidden" value="<?php echo $count; ?>" name="co_owner_count" id="co_owner_count">
    </div>
    <div class="col-4 border-left">
      <i class="fa fa-user-plus fa-fw mt-5 text-primary" aria-hidden="true"></i> <font class="text-primary">New Registration | Co Owner</font> 
    </div> 
    <?php 
foreach ($get_user_details  as $user)
{
$user_sl              = $user['user_sl'];
$user_address         = $user['user_address'];
$user_mobile_number   = $user['user_mobile_number'];
$user_email           = $user['user_email'];
$user_district_id     = $user['user_district_id'];
$user_state_id        = $user['user_state_id'];


  $district     =   $this->Registration_model->get_district($user_state_id);
    $data['district'] = $district;

  }
?>
 </div>
 <input type="hidden" value="<?php //echo $user_sl; ?>" name="user_sl[]" id="user_sl<?php //echo $i; ?>" >
  <?php 
  for($i=1; $i<=$count;$i++)
  {
  ?>

 <div><b>Co Owner&nbsp; <?php echo $i; ?></b></div>
  <div class="row ">
   <div class="col-2 border-top border-bottom oddrows">
      <p class="mt-4"><em>Name </em></p>
    </div>
    <div class="col border-top border-bottom oddrows">
             <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-user-circle fa-fw" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Co Owner Name" name="user_name[]" id="user_name<?php echo $i; ?>" required onkeypress="return alpbabetspace(event);">
                    <div class="invalid-tooltip"> Please enter Co Owner Name  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-top border-bottom border-left oddrows">
      <p class="mt-4"><em>Date of birth </em></p>
    </div>
    <div class="col border-top border-bottom oddrows">
       <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-calendar fa-fw" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control dob" placeholder="Date of birth" name="user_dob[]" id="user_dob<?php echo $i; ?>" required>
                    <div class="invalid-tooltip"> Please enter Co Owner dob. </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 1st row -->



    <div class="row ">
   <div class="col-2 border-bottom evenrows">
      <p class="mt-4"><em>Mobile Number </em></p>
    </div>
    <div class="col border-bottom evenrows">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-mobile fa-fw" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Valid 10 digit mobile number" name="user_mobile_number[]" id="user_mobile_number<?php echo $i; ?>" required maxlength="10" onkeypress="return IsNumeric(event);" value="<?php echo $user_mobile_number; ?>">
                    <div class="invalid-tooltip"> Please enter Co Owner Mobile Number </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left evenrows">
      <p class="mt-4"> <em>Email Id </em></p>
    </div>
    <div class="col border-bottom evenrows">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Email Id" name="user_email[]" id="user_email<?php echo $i; ?>" required onchange="return validateEmail(this.value);" value="<?php echo $user_email; ?>">
                    <div class="invalid-tooltip"> Please enter Co Owner Email </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 2nd row -->


  <div class="row ">
   <div class="col-2 border-bottom oddrows ">
      <p class="mt-4"><em>State </em></p>
    </div>

            <div class="col border-bottom oddrows">
            <div class="form-group mt-3">
            <div class="input-group">
            <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-map-pin fa-fw" aria-hidden="true"></i></span>
            </div>
            <select class="custom-select select2" name="user_state_id[]" id="user_state_id<?php echo $i; ?>" required >
            <option value="">Select State</option>
            <?php foreach ($state as $res_state)
            {
            ?>
            <option value="<?php echo $res_state['state_code']; ?>" <?php if($user_state_id==$res_state['state_code']) { echo "selected";} ?> ><?php echo $res_state['state_name'];?></option>
            <?php
            } 
            ?>
            </select>
            <div class="invalid-tooltip"> Please select State </div>
            </div>
            <span id="textval1"></span>
            </div> <!-- end of form group -->
            </div>


    <div class="col-2 border-bottom border-left oddrows">
      <p class="mt-4"><em>District </em></p>
    </div>


    <div class="col border-bottom oddrows">
       <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-map-pin fa-fw" aria-hidden="true"></i></span>
                    </div>
                   <select class="custom-select select2" id="user_district_id<?php echo $i; ?>" required name="user_district_id[]">
                   <?php
if(isset($district))
{  
?>
      <option value="">Select</option>
      <?php foreach ($district as $result) { ?>
      <option value="<?php echo $result['district_code'];?>" <?php if($user_district_id==$result['district_code']) { echo "selected"; } ?>><?php echo $result['district_name'];?></option>
      <?php } ?>

<?php }   ?> 


                    </select>
                    <div class="invalid-tooltip"> Please select District  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>


  </div> <!-- end of 9th row -->


  <div class="row ">
   <div class="col-2 border-bottom evenrows ">
      <p class="mt-4"><em>Aadhar Number</em></p>
    </div>
    <div class="col border-bottom evenrows">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-id-card-o fa-fw" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="12 digit aadhar number" name="user_aadhar_id[]" id="user_aadhar_id<?php echo $i; ?>" required onkeypress="return IsNumeric(event);" maxlength="12">
                    <div class="input-group-append" >
                        <button class="btn btn-success" type="submit">Verify</button> 
                      </div>
                      <div class="invalid-tooltip"> Please enter Co Owner's 12 digit Aadhar number </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left evenrows">
      <p class="mt-4"><em>Occupation</em></p>
    </div>
    <div class="col border-bottom evenrows">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-building-o  fa-fw" aria-hidden="true"></i></span>
                    </div>
                   <select class="custom-select select2" id="user_occupation_id<?php echo $i; ?>" required name="user_occupation_id[]">
                     <option value="">Select</option>
    <?php foreach ($occupation as $res_occupation)
    {
    ?>
    <option value="<?php echo $res_occupation['occupation_sl']; ?>"><?php echo $res_occupation['occupation_name'];?></option>
    <?php
    } 
    ?>
                    </select>
                    <div class="invalid-tooltip"> Please select Co Owner Occupation</div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 3rd row -->
  <div class="row ">
   <div class="col-2 border-bottom oddrows">
      <p class="mt-4"><em>Address </em></p>
    </div>
    <div class="col border-bottom oddrows">
         <div class="form-group mt-3">
                  <div class="input-group">
                   <textarea class="form-control" aria-label="With textarea" id="user_address<?php echo $i; ?>"  name="user_address[]" required ><?php echo $user_address ;?></textarea>
                   <div class="invalid-tooltip"> Please enter Co Owner Address </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left oddrows">
      <p class="mt-4"><em>Occupation Address </em></p>
    </div>
    <div class="col border-bottom oddrows">
         <div class="form-group mt-3">
                  <div class="input-group">
                   <textarea class="form-control" aria-label="With textarea" required name="user_occupation_address[]" id="user_occupation_address<?php echo $i; ?>" onkeypress="return IsAddress(event);"></textarea>
                   <div class="invalid-tooltip"> Please enter Co Owner Office Address</div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 4th row -->
  
  <div class="row evenrows">
   <div class="col-2 border-bottom ">
      <p class="mt-4"><em>Identity Card</em></p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-id-badge fa-fw" aria-hidden="true"></i></span>
                    </div>
                       <select class="custom-select select2" id="user_idcard_id<?php echo $i; ?>" name="user_idcard_id[]">
                      <option value="">Select</option>
    <?php foreach ($idcard as $res_idcard)
    {
    ?>
    <option value="<?php echo $res_idcard['idcard_sl']; ?>"><?php echo $res_idcard['idcard_name'];?></option>
    <?php
    } 
    ?>
                    </select>
                    <div class="invalid-tooltip"> Please select an ID card  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left ">
      <p class="mt-4"> <em>Id Card Number </em></p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-id-card fa-fw" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="ID Card number" name="user_idcard_number[]" id="user_idcard_number<?php echo $i; ?>" maxlength="12">
                    <div class="invalid-tooltip"> Please enter valid identity card number  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 6th row -->
  



  <div class="row oddrows">
   <div class="col border-bottom">
              <div class="form-check form-check-inline ml-5">
              <input class="form-check-input" type="checkbox" id="minor_status<?php echo $i; ?>" value="<?php echo $i; ?>" name="minor_status[]">

              <label class="form-check-label" for="minor_status"> <p class="mt-4"><em>&nbsp; Are you a minor ? </em></p></label>
     
            </div>
    </div>
    <div class="col border-bottom border-left">
            <div class="form-check form-check-inline">
               <input type="text" name="hdnminor[]" id="hdnminor<?php echo $i; ?>" value="">
            </div> 
    </div>

     <div class="col-5 border-bottom border-left d-flex flex-grow-1">
      

       <div class="form-check form-check-inline">
             
             <div class="form-group col mt-3" id="" style="display: none;">
                  
              </div> 
            </div> 

    </div> 


  </div>  

<?php
}
?>


  <!-- end of 7th row -->
<div class="row border-bottom evenrows">
<div class="col mt-4 mb-1">

<!-- <a class="btn btn-secondary" href="<?php //echo base_url()."index.php/Master/index"?>"><i class="fas fa-home"></i>&nbsp;Home</a> -->

</div>
<div class="col mt-4 mb-1">
  
</div>
<div class="col mt-3 mb-3"> 
</div>
<div class="col mt-1 mb-3"> 
  <div class="g-recaptcha" data-sitekey="6LeG33EUAAAAAKQS4MlMmFRFhLQQTN3k4AGWWukO"></div>
</div>    
<div class="col mt-4 mb-1">
  <button class="btn btn-success" type="submit" name="btnsubmit" id="btnsubmit">Submit</button>
</div>
</div><!-- end of 8th row -->
</div> <!-- end of main container -->
</form>
</section> <!-- end of main section -->
</body>
<script language="javascript">

$(document).ready(function(){

  var count=$("#co_owner_count").val();


$("#form1").validate({

rules: 
{
 

     user_idcard_number   : {required:{depends: function(element) 
                          {
                          if($("#user_idcard_id").val()!='')
                          return true;
                            else
                          return false;
                          }
                              }
                            },                       



  
},
messages: 
{
   user_idcard_number  : {required:"<font color='red'>Required!!</font>",},
},
});
//-----------Validation End-----------//


  $('.form-check-input').on('ifChecked', function () 
    { 
      var id= $(this).val()

      $('#hdnminor'+id).val(1); 
  });


$('.form-check-input').on('ifUnchecked', function () 
{ 
var id= $(this).val()
$('#hdnminor'+id).val(''); 
});





    

//------JQUERY END-------------//
});


</script>
