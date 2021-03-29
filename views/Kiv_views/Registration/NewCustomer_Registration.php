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

  $(".mal-content").hide();

  $("#mal-button").click(function(){
  $(".eng-content").hide();
  $(".mal-content").show();
});
$("#eng-button").click(function(){
  $(".eng-content").show();
  $(".mal-content").hide();
});

$("#user_state_id").change(function(){
  var user_state_id=$("#user_state_id").val();
  if(user_state_id != '')
  { 
    $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('/Kiv_Ctrl/Registration/district/')?>"+user_state_id,
    success: function(data)
    {         
      $("#user_district_id").html(data);
    }
    });
  }

});

 
$("#user_name").change(function(){

var user_name=$("#user_name").val();
//alert(user_name.length);

if(user_name.length<4)
{
   alert("Name should contain atleast 4 characters");
        $("#user_name").val('');
        $("#user_name").focus();
}
/*var strArray = user_name.match(/(\d+)/g);
    var i = 0;
    for(i=0; i<strArray.length;i++)
    {
      var strnum=strArray[i];

      if(strnum.length>0)
      {
        alert("Invalid Name");
        $("#user_name").val('');
        $("#user_name").focus();
      }
    }*/
});

$("#user_address").change(function(){

var user_address=$("#user_address").val();

if(user_address.length<10)
{
   alert("Address should contain atleast 10 characters");
        $("#user_address").val('');
        $("#user_address").focus();
}

});


$("#user_occupation_address").change(function(){
var user_occupation_address=$("#user_occupation_address").val();
if(user_occupation_address.length<10)
{
   alert("Occupation address should contain atleast 10 characters");
  $("#user_occupation_address").val('');
  $("#user_occupation_address").focus();
}
});
// 

//----photo checking------//
var _URL = window.URL || window.webkitURL;
    
   $('#my-file-selector1').change(function(){
 
      var f=this.files[0];
      var fsize=f.size;
        if(fsize>1000000)
        {
          alert("Photo Size should not exceed 1MB (1024 KB)");
          $("#my-file-selector1").val('');

          return false;
        }
 var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function() {
           // alert(this.width + " " + this.height);
                var widthimg=this.width;
                var heightmg=this.height;

                 if((widthimg>149 && widthimg<351) && (heightmg>149 && heightmg<351))
                {
                    //alert("ok");
                }
                else
                {
                  alert("Error in Upload! Width or Height exceeded");
                  $('#my-file-selector1').val('');
                  return false;
                }
        };
        img.src = _URL.createObjectURL(file);

    }

});

  //checking pdf size  
   $('#my-file-selector2').change(function(){
 
      var f=this.files[0];
      var fsize=f.size;
        if(fsize>1000000)
        {
          alert("PDF size should not exceed 1MB (1024 KB)");
          $("#my-file-selector2").val('');

          return false;
        }
 

});


$("#user_mobile_number").change(function(){
    var mob=$("#user_mobile_number").val();

    var mob_length = mob.length; 
    if(mob_length<10)
    {
      alert('Please enter 10 digit mobile number');
      $("#user_mobile_number").val('');
     // $("#user_mobile_number").focus();
      return false;
    }

 if(mob!='')
     {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({type: "POST",
             url:"<?php echo site_url('Kiv_Ctrl/Registration/mobileverify/')?>",
            data: { mob: mob,'csrf_test_name': csrf_token},
             success: function(data)
             { 
              if(data == "1")
              {
                alert("This mobile number already exists");
                $("#user_mobile_number").val('');
                $("#user_mobile_number").focus();
              }
             }
       });  
     }

  });

$("#user_email").change(function(){
    var email_id=$("#user_email").val();
    alert(email_id);
   if(email_id!='')
     {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({type: "POST",
             url:"<?php echo site_url('Kiv_Ctrl/Registration/email_id_verify/')?>",
            data: { email_id: email_id,'csrf_test_name': csrf_token},
             success: function(data)
             { 
              if(data == "1")
              {
                alert("This Email Id  already exists");
                $("#user_email").val('');
                $("#user_email").focus();
                 
              }
             }
       });  
     }
   
 
   
 });  

$("#user_idcard_number").change(function(){
 var user_idcard_id= $("#user_idcard_id").val();
  var user_idcard_number= $("#user_idcard_number").val();

 var user_idcard = user_idcard_number.length; 
 if(user_idcard<4)
 {
  alert('Atleast 4 characters required');
    $("#user_idcard_number").val('');
    $("#user_idcard_number").focus();
    return false;
 }
 
 if(user_idcard_id==1 && user_idcard!=12 )
 {
    alert('Please enter 12 digit Aadhar number');
    $("#user_idcard_number").val('');
    $("#user_idcard_number").focus();
    return false;
 }


 if(user_idcard_number!='')
     {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({type: "POST",
             url:"<?php echo site_url('/Kiv_Ctrl/Registration/idcard_verify/')?>",
            data: { user_idcard_number: user_idcard_number,'csrf_test_name': csrf_token},
             success: function(data)
             { 
              if(data == "1")
              {
                alert("This Id card number already exists");
                $("#user_idcard_number").val('');
                $("#user_idcard_number").focus();
                 
              }
             }
       });  
     }

});



  $("#co_owner_count").change(function(){
    var owner_count=$("#co_owner_count").val();
    if(owner_count>8 || owner_count==0)
    { 
      alert('You can enter number from 1 to 8 only');
      $("#co_owner_count").val('');
      return false;
    }

  });

var currentTime = new Date();
var year = currentTime.getFullYear();


var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
} 

if(mm<10) {
    mm = '0'+mm
} 

today = mm + '/' + dd + '/' + yyyy;



$("#user_dob").change(function(){
 var user_dob   =  $("#user_dob").val();
 var last2      =   user_dob.substr(-4);


var datearray = user_dob.split("/");

var newdate = datearray[1] + '/' + datearray[0] + '/' + datearray[2];

var date1 = new Date(today);
var date2 = new Date(newdate);
var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 

   if((year-last2)<=18)
   {
       $("#hdnminor").val(1);
   }
   else
   {
    $("#hdnminor").val(0);
   }
   if(((last2-year)>0) || ((year-last2)>99) || (diffDays>0) )
   {
    alert("Invalid Date of Birth");
    $("#user_dob").val('');
    $("#user_dob").focus();
   }
});




$("#username").change(function(){
var username=$("#username").val();
   if(username!='')
     {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({type: "POST",
             url:"<?php echo site_url('/Kiv_Ctrl/Registration/username_verify/')?>",
            data: { username: username,'csrf_test_name': csrf_token},
             success: function(data)
             { 
              if(data == "1")
              {
                alert("This username already exists");
                $("#username").val('');
                $("#username").focus();
              }
             }
       });  
     }
});

$("#btnsubmit").click(function(){
  var st=$("#hdn_co_owner").val(); 
  var cnt=$("#co_owner_count").val(); 
  //alert(st);
   if(st==1 && cnt=='')
   {
    alert("Enter number of co-owners");
    return false;
   }
   else
   {
    return true;
   }

});

//----------Jquery End-------//
}); 


function validate_file(file) {
var extension = $('#my-file-selector1').val().split('.').pop().toLowerCase();
if($.inArray(extension, ['png','jpg','jpeg']) == -1) {
alert('Sorry, invalid extension. Only jpg and png images are allowed');
$('#my-file-selector1').val('');
return false;
}
} 


function validate_aadhar(file) {
var extension = $('#my-file-selector2').val().split('.').pop().toLowerCase();
if($.inArray(extension, ['pdf']) == -1) {
alert('Sorry, invalid extension.Only PDF files are allowed');
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
    window.alert("This field accepts only numbers");
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
      document.getElementById('user_email').value='';
        return false;
    } else {
        return true;
    }
}

function IsAddress(e) 
        {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if ((unicode == 32) || (unicode == 44) || (unicode == 47) || (unicode == 40) || (unicode == 41) || (unicode == 45) || (unicode >64 && unicode<91) || (unicode > 47 && unicode < 58) || (unicode > 96 && unicode < 123) || (unicode==8) || (unicode==46) ) 
        {
                return true;
        }
        else 
        {
              window.alert("Not Allowed");
                return false;  
        }
        }    
 function IsAlphanumeric(e) 
        {
        var unicode = e.charCode ? e.charCode : e.keyCode;
       if ( (unicode >64 && unicode<91) || (unicode > 47 && unicode < 58) || (unicode==47) || (unicode == 45) || (unicode == 8))  
        {
                return true;
        }
        else 
        {
                window.alert("This field accepts Capital letters(A-Z), numbers with hyphen(-) and slash (/) ");
                return false;
        }
        }


</script>


<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- _____________ Include the above in your HEAD tag ______________________________-->
<body>
<section class="login-block">
<form class="needs-validation" novalidate name="form1" id="form1" action="" method="post" enctype="multipart/form-data">
<div class="container"> 
  <div class="row">
    <div class="col">      <img src="<?php echo base_url(); ?>plugins/img/logo.png"  alt="PortInfo">
    </div>
    <div class="col-4 border-left pb-2">
      <i class="fas fa-user-plus mt-5 text-primary"></i> <font class="text-primary"><span class="eng-content"> Customer Registration | Sand Pass</span></font> <span class="mal-content mal_content_reg">     ഉപഭോക്തൃ രജിസ്ട്രേഷൻ | മണൽ പാസ്സ് </span> <hr>
      <button type="button" class="btn btn-primary btn-point btn-flat eng-content" id="mal-button" >Malayalam</button>
      <button type="button" class="btn btn-primary btn-point btn-flat mal-content" id="eng-button">English</button>
    </div> 
 </div>
 <div class="row">
  <div class="col-12">
    <div class="alert alert-info fade in alert-dismissible show" id="coowner_reg">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true" style="font-size:20px">&times;</span>
</button> 
  <p class="text-primary"> <strong> <em> <font face="Book Antiqua"> <span class="eng-content">  Registration form for sand pass customer registration. </span>  </font> <span class="mal-content mal_content_reg"> മണൽ പാസ്സ് ലഭിക്കുന്നതിനുള്ള ഉപഭോക്തൃ രജിസ്ട്രേഷൻ ഫോം. </span> </em> </strong> </p> 
  <p class="text-primary"> <em> <span class="eng-content"> You can now register for sand pass by filling the registration form. All the fields are mandatory. On successful registration, username and password will be sent to your email and mobile. You can also add/edit details by login to the site 
  <a href="http://portinfo.kerala.gov.in" target="_blank" class="btn btn-sm btn-outline-primary"> portinfo.kerala.gov.in </a>
    after completing your registration. Do not press back button or refresh button while registration is in process. Please enter the details only in English </span> 
    <span class="mal-content mal_content_reg text-justify">
മണൽ പാസ്സ് ലഭിക്കുന്നതിനായുള്ള രജിസ്ട്രേഷൻ ഇവിടെ ചെയ്യാവുന്നതാണ്. എല്ലാ വിവരങ്ങളും ചേർത്ത് ഫോം പൂരിപ്പിക്കേണ്ടതാണ്. അപൂർണ്ണമായ ഫോം രജിസ്റ്റർ ചെയ്യാൻ സാധിക്കുന്നതല്ല. രജിസ്റ്റർ ചെയ്തതിന് ശേഷം ഉപഭോക്താവ് നൽകിയിട്ടുള്ള ഈമെയിൽ ഐ.ഡി., മൊബൈൽ നമ്പർ എന്നിവയിലേക്ക് സൈറ്റിൽ ലോഗിൻ ചെയ്യാനുള്ള യൂസർ നെയിം, പാസ്സ്‌‌വേഡ് എന്നിവ ലഭിക്കുന്നതാണ്. <a href="http://portinfo.kerala.gov.in" target="_blank" class="btn btn-sm btn-outline-primary"> portinfo.kerala.gov.in </a> എന്ന സൈറ്റിൽ ലോഗിൻ ചെയ്ത് മണൽ പാസ്സിനായി അപേക്ഷിക്കാവുന്നതാണ്. രജിസ്ട്രേഷൻ ചെയ്യുന്ന സമയത്ത് back/refresh ബട്ടണുകൾ ക്ലിക്ക് ചെയ്യാതിരിക്കുക. രജിസ്ട്രേഷൻ ഫോം ഇംഗ്ളീഷിൽ മാത്രം പൂരിപ്പീക്കുക. മലയാളത്തിൽ വിവരങ്ങൾ ചേർക്കരുത്. </span> </em>    </p>
     <!-- Button to Open the Modal -->
<button type="button" class="btn btn-secondary btn-point btn-sm " data-toggle="modal" data-target="#instruction_modal">
  <span class="mal_content" > നിർദ്ദേശങ്ങൾ മലയാളത്തിൽ ലഭിക്കുന്നതിന് ഇവിടെ ക്ലിക്ക് ചെയ്യുക </span>
</button>
</div> <!-- end of alert -->
  </div> <!-- end of col12 alert -->
 </div> <!-- end of alert row -->


<!-- The Modal -->
<div class="modal" id="instruction_modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title mal_content">രജിസ്ട്രേഷൻ  ഫോം പൂരിപ്പിക്കുന്നതിനുള്ള നിർദ്ദേശങ്ങൾ  </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> <!-- ene of modal header -->

      <!-- Modal body -->
      <div class="modal-body mal_content_reg">
        <?php include ('sandpass_instruction.php'); ?>
      </div> <!-- end of modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> <!-- end of modal footer -->

    </div> <!-- end of modal content -->
  </div> <!-- end of modal dialog -->
</div> <!-- end of modal div -->

  <div class="row oddrows">
    <div class="col-2 border-top border-bottom ">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> ആധാർ നമ്പർ </span> <span class="eng-content"> Aadhar Number </span>  </em><font color="red">* </font></p>
    </div>
    <div class="col border-top border-bottom">
       <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-certificate"></i></span>
                    </div>
                    <input type="text" class="form-control " placeholder="Aadhar Number" name="user_dob" id="user_dob" required>
                    <div class="invalid-tooltip"> Please enter your Aadhar Number. </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
   <div class="col-2 border-top border-bottom border-left">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> ഉപഭോക്താവിന്റെ പേര് </span> <span class="eng-content"> Name</span> </em><font color="red">* </font> </p>
    </div>
    <div class="col border-top border-bottom">
             <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> <i class="fas fa-user-tag"></i> </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Customer name" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);"  maxlength="50">
                    <div class="invalid-tooltip"> Please enter your name  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
	</div> <!-- end of 1st row -->
    <div class="row evenrows">
   <div class="col-2 border-bottom ">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> മൊബൈൽ നമ്പർ  </span> <span class="eng-content"> Mobile Number  </span> </em><font color="red">* </font></p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Valid 10 digit mobile number" name="user_mobile_number" id="user_mobile_number" required maxlength="10" onkeypress="return IsNumeric(event);" >
                    <div class="invalid-tooltip"> Please enter your mobile number </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left ">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> ഈമെയിൽ ഐ.ഡി </span> <span class="eng-content"> Email Id   </span> </em><font color="red">* </font></p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-envelope"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Email Id" name="user_email" id="user_email" required onchange="return validateEmail(this.value);" >
                    <div class="invalid-tooltip"> Please enter your email </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 2nd row -->
    <div class="row alert-success">
      <div class="col-12 d-flex justify-content-center text-secondary my-4">
        <span class="mal-content mal_content_reg"> സ്ഥിര മേൽവിലാസം </span> <span class="eng-content"> Permanent Address </span> 
      </div> <!-- end of col12 -->
    </div> <!-- end of row -->
    <!-- ------------------------------------------ -- Start of Permanent Address Details ----------------------------------------- -->
  <div class="row oddrows">
    <div class="col-2 border-top border-bottom ">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> വീട്ട് നമ്പർ </span> <span class="eng-content">  House Number </span>   </em><font color="red">* </font></p>
    </div>
    <div class="col border-top border-bottom">
       <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-building"></i></span>
                    </div>
                    <input type="text" class="form-control " placeholder="House number" name="user_dob" id="user_dob" required>
                    <div class="invalid-tooltip"> Please enter your house number. </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
   <div class="col-2 border-top border-bottom border-left">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> വീട്ട് പേര് </span> <span class="eng-content">  House Name </span>   </em><font color="red">* </font> </p>
    </div>
    <div class="col border-top border-bottom">
             <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> <i class="fas fa-warehouse"></i> </span>
                    </div>
                    <input type="text" class="form-control" placeholder="House name" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);"  maxlength="50">
                    <div class="invalid-tooltip"> Please enter your house name  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
  </div> <!-- end of 1st row -->
  <div class="row evenrows">
            <div class="col-4 border-bottom">

            <div class="form-group mt-3">
            <div class="input-group">
            <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
            </div> <!-- prepend div -->
            <select class="custom-select select2" name="user_state_id" id="user_state_id" required >
            <option value="">Select State</option>
            <?php foreach ($state as $res_state)
            {
            ?>
            <option value="<?php echo $res_state['state_code']; ?>"><?php echo $res_state['state_name'];?></option>
            <?php
            } 
            ?>
            </select>
            <div class="invalid-tooltip"> Please select State </div>
            </div> <!-- input group -->
            </div> <!-- end of form group -->
            </div>  <!-- end of col -->
            <div class="col-4 border-bottom border-left">
       <div class="form-group mt-3">
                  <div class="input-group btn-point">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                   <select class="custom-select select2 btn-point" id="user_district_id2" required name="user_district_id">
                    </select>
                    <div class="invalid-tooltip"> Please select local body  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
    <div class="col-4 border-bottom border-left">
    	 <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-map-pin"></i></i></span>
                    </div>
                   <select class="custom-select select2" id="user_district_id" required name="user_district_id">
                    </select>
                    <div class="invalid-tooltip"> Please select post office  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
  </div> <!-- end of 9th row -->
   <div class="row oddrows">
    <div class="col-2 border-top border-bottom ">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> പിൻകോഡ് </span> <span class="eng-content">  Pincode </span>   </em><font color="red">* </font></p>
    </div>
    <div class="col border-top border-bottom">
       <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                    </div>
                    <input type="text" class="form-control " placeholder="Pincode" name="user_dob" id="user_dob" required>
                    <div class="invalid-tooltip"> Please enter your pincode. </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
   <div class="col-2 border-top border-bottom border-left">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> സ്ഥലം </span> <span class="eng-content">  Place </span>   </em><font color="red">* </font> </p>
    </div>
    <div class="col border-top border-bottom">
             <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> <i class="fas fa-map-signs"></i> </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Place name" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);"  maxlength="50">
                    <div class="invalid-tooltip"> Please enter place name  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
  </div> <!-- end of 1st row -->
  <!-- ------------------------------------------ -- End of Permanent Address Details ----------------------------------------- -->
  <!-- ------------------------------------------ -- Start of Work Site Address Details ----------------------------------------- -->
  <div class="row alert-success">
      <div class="col-12 d-flex justify-content-center text-secondary pt-3">
        <p class="pt-3"> <span class="mal-content mal_content_reg"> നിർമ്മാണം/നവീകരണം നടത്തുന്ന സ്ഥലത്തിന്റെ വിവരങ്ങൾ   </span> <span class="eng-content">  Work Site Address Details </span>   </p>
        &nbsp;&nbsp;&nbsp;
        <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="agent_status" value="" name="agent_status">
              <label class="form-check-label" for="agent_status" ><p class="pt-3 text-secondary"><em>&nbsp; <span class="mal-content mal_content_reg"> സ്ഥിരതാമസ സ്ഥലത്താണെങ്കിൽ ഇവിടെ ക്ലിക്ക് ചെയ്യുക  </span> <span class="eng-content">  Click here if the address is same as above. </span>   </em></p></label>
            </div>
      </div> <!-- end of col12 -->
    </div> <!-- end of row -->
  <div class="row oddrows">
    <div class="col-2 border-top border-bottom ">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> വീട്ട് നമ്പർ </span> <span class="eng-content">  House Number </span> </em><font color="red">* </font></p>
    </div>
    <div class="col border-top border-bottom">
       <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-building"></i></span>
                    </div>
                    <input type="text" class="form-control " placeholder="House number" name="user_dob" id="user_dob" required>
                    <div class="invalid-tooltip"> Please enter your house number. </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
   <div class="col-2 border-top border-bottom border-left">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> വീട്ട് പേര് </span> <span class="eng-content">  House Name </span> </em><font color="red">* </font> </p>
    </div>
    <div class="col border-top border-bottom">
             <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> <i class="fas fa-warehouse"></i> </span>
                    </div>
                    <input type="text" class="form-control" placeholder="House name" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);"  maxlength="50">
                    <div class="invalid-tooltip"> Please enter your house name  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
  </div> <!-- end of 1st row -->
  <div class="row evenrows">
            <div class="col-4 border-bottom">
            <div class="form-group mt-3">
            <div class="input-group">
            <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
            </div> <!-- prepend div -->
            <select class="custom-select select2" name="user_state_id" id="user_state_id" required >
            <option value="">Select State</option>
            <?php foreach ($state as $res_state)
            {
            ?>
            <option value="<?php echo $res_state['state_code']; ?>"><?php echo $res_state['state_name'];?></option>
            <?php
            } 
            ?>
            </select>
            <div class="invalid-tooltip"> Please select State </div>
            </div> <!-- input group -->
            </div> <!-- end of form group -->
            </div>  <!-- end of col -->
            <div class="col-4 border-bottom border-left">
       <div class="form-group mt-3">
                  <div class="input-group btn-point">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                   <select class="custom-select select2 btn-point" id="user_district_id2" required name="user_district_id">
                    </select>
                    <div class="invalid-tooltip"> Please select local body  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
    <div class="col-4 border-bottom border-left">
       <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-map-pin"></i></i></span>
                    </div>
                   <select class="custom-select select2" id="user_district_id" required name="user_district_id">
                    </select>
                    <div class="invalid-tooltip"> Please select post office  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
  </div> <!-- end of 9th row -->
   <div class="row oddrows">
    <div class="col-2 border-top border-bottom ">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> പിൻകോഡ് </span> <span class="eng-content">  Pincode </span> </em><font color="red">* </font></p>
    </div>
    <div class="col border-top border-bottom">
       <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                    </div>
                    <input type="text" class="form-control " placeholder="Pincode" name="user_dob" id="user_dob" required>
                    <div class="invalid-tooltip"> Please enter your pincode. </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
   <div class="col-2 border-top border-bottom border-left">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> സ്ഥലം </span> <span class="eng-content">  Place </span>  </em><font color="red">* </font> </p>
    </div>
    <div class="col border-top border-bottom">
             <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> <i class="fas fa-map-signs"></i> </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Place name" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);"  maxlength="50">
                    <div class="invalid-tooltip"> Please enter place name  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
  </div> <!-- end of 1st row -->
  <!-- ------------------------------------------ -- End  of Work Site Address Details ----------------------------------------- -->
 <div class="row alert-success">
      <div class="col-12 d-flex justify-content-center text-secondary py-3">
        <span class="mal-content mal_content_reg"> മണൽ ടണ്ണിന്റെ വിശദവിവരങ്ങൾ  </span> <span class="eng-content">  Tonnage Details </span> 
      </div> <!-- end of col12 -->
    </div> <!-- end of row -->
    <div class="row oddrows">
      <div class="col-1 border-bottom border-top text-secondary pt-3">
        <span class="mal-content mal_content_reg"> ആവശ്യകത  </span> <span class="eng-content">  Purpose </span>  * 
      </div> <!-- end of col2 -->
      <div class="col-3 border-bottom border-top text-secondary">
        <div class="form-group mt-3">
            <div class="input-group">
            <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
            </div> <!-- prepend div -->
            <select class="custom-select select2" name="user_state_id" id="user_state_id" required >
            <option value="">Select Purpose</option>
            <?php foreach ($state as $res_state)
            {
            ?>
            <option value="<?php echo $res_state['state_code']; ?>"><?php echo $res_state['state_name'];?></option>
            <?php
            } 
            ?>
            </select>
            <div class="invalid-tooltip"> Please select State </div>
            </div> <!-- input group -->
            </div> <!-- end of form group -->
      </div> <!-- end of col2 -->
      <div class="col-2 border-bottom border-top border-left text-secondary pt-3">
        Plinth Area (in Sq.m) *
      </div> <!-- end of col2 -->
      <div class="col-2 border-bottom border-top text-secondary">
        <div class="form-group mt-3">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Plinth area" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);"  maxlength="50">
                    <div class="input-group-append">
                      <span class="input-group-text"> Sq.m </span>
                    </div>
                    <div class="invalid-tooltip"> Please enter plint area  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
      </div> <!-- end of col2 -->
      <div class="col border-bottom border-left border-top text-secondary pt-3">
        <span class="mal-content mal_content_reg"> ആവശ്യമുള്ള ടൺ മണൽ   </span> <span class="eng-content">  Max. Required Ton </span>  *
      </div> <!-- end of col2 -->
      <div class="col">
        <div class="form-group mt-3">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Max Ton" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);"  maxlength="50">
                     <div class="input-group-prepend">
                      <span class="input-group-text"> Ton </span>
                    </div>
                    <div class="invalid-tooltip"> Please enter maximum ton required  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
      </div> <!-- end of col2 -->
    </div> <!-- end of row -->

    <div class="row evenrows">
      <div class="col-2 border-bottom border-top text-secondary pt-3">
        <span class="mal-content mal_content_reg"> പെർമിറ്റ് നമ്പർ    </span> <span class="eng-content">  Permit Number </span> *
      </div> <!-- end of col2 -->
      <div class="col-2 border-bottom border-top text-secondary">
        <div class="form-group mt-3">
     <input type="text" class="form-control" placeholder="Permit number" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);"  maxlength="50">
        <div class="invalid-tooltip"> Please enter permit number.  </div>
        <span id="textval1"></span>
</div> <!-- end of form group -->
      </div> <!-- end of col2 -->
      <div class="col-2 border-bottom border-top border-left text-secondary pt-3">
         <span class="mal-content mal_content_reg"> പെർമിറ്റ് തീയ്യതി  </span> <span class="eng-content">  Permit Date </span>  *
      </div> <!-- end of col2 -->
      <div class="col-2 border-bottom border-top text-secondary">
        <div class="form-group mt-3">
                    <input type="text" class="form-control dob" placeholder="Permit date" name="user_dob" id="user_dob" required>
                    <div class="invalid-tooltip"> Please enter permit date. </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
      </div> <!-- end of col2 -->
      <div class="col border-bottom border-left border-top text-secondary pt-3">
         <span class="mal-content mal_content_reg"> പെർമിറ്റ് അതോറിറ്റി </span> <span class="eng-content">  Permit Authority </span>  *
      </div> <!-- end of col2 -->
      <div class="col">
        <div class="form-group mt-3">
     <input type="text" class="form-control" placeholder="Permit Authority" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);"  maxlength="50">
        <div class="invalid-tooltip"> Please enter permit authority.  </div>
        <span id="textval1"></span>
</div> <!-- end of form group -->
      </div> <!-- end of col2 -->
    </div> <!-- end of row -->

  <div class="row oddrows">
   <div class="col-2 border-bottom">
      <p class="mt-5 text-secondary"><em><span class="mal-content mal_content_reg"> നിർമ്മാണ സ്ഥലത്തേക്കുള്ള ദൂരം  </span> <span class="eng-content">   Distance to worksite </span>   </em><font color="red">* </font></p>
    </div>
    <div class="col-3 border-bottom">
         <div class="form-group mt-5">
          <div class="input-group">
     <input type="text" class="form-control" placeholder="Distance" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);"  maxlength="50">
     <div class="input-group-append">
                      <span class="input-group-text">KM</span>
                    </div>
                  </div>
        <div class="invalid-tooltip"> Please enter distance to worksite.  </div>
        <span id="textval1"></span>
</div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left">
      <p class="mt-5 text-secondary"><em><span class="mal-content mal_content_reg"> നിർമ്മാണ സ്ഥലത്തേക്കുള്ള വഴി </span> <span class="eng-content">   Route to Work site </span> * </em></p> 
    </div>
    <div class="col border-bottom">
         <div class="form-group mt-3">
                 
                   <textarea class="form-control" aria-label="With textarea"  name="user_occupation_address" rows="4" id="user_occupation_address" onkeypress="return IsAddress(event);" maxlength="100"></textarea>
                   <div class="invalid-tooltip"> Please enter route to work site</div>
                  
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 4th row -->
   <div class="row evenrows">
    <div class="col-2 border-top border-bottom ">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> മണൽ ഇറക്കേണ്ട സ്ഥലം  </span> <span class="eng-content">   Unloading Place  </span>  </em><font color="red">* </font></p>
    </div>
    <div class="col border-top border-bottom">
       <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-drafting-compass"></i></span>
                    </div>
                    <input type="text" class="form-control " placeholder="Place name" name="user_dob" id="user_dob" required>
                    <div class="invalid-tooltip"> Please ente the unloading place. </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div> <!-- end of col -->
   <div class="col-2 border-top border-bottom border-left">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg">   മണൽ എടുക്കുന്ന തുറമുഖം   </span> <span class="eng-content">   Desired Port </span>    </em><font color="red">* </font> </p>
    </div>
    <div class="col border-top border-bottom">
             <div class="form-group mt-3">
            <div class="input-group">
            <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
            </div> <!-- prepend div -->
            <select class="custom-select select2" name="user_state_id" id="user_state_id" required >
            <option value="">Select Port</option>
            <?php foreach ($state as $res_state)
            {
            ?>
            <option value="<?php echo $res_state['state_code']; ?>"><?php echo $res_state['state_name'];?></option>
            <?php
            } 
            ?>
            </select>
            <div class="invalid-tooltip"> Please select State </div>
            </div> <!-- input group -->
            </div> <!-- end of form group -->
    </div> <!-- end of col -->
  </div> <!-- end of 1st row -->
  <div class="row oddrows">
   <div class="col-2 border-bottom ">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg">   ആധാർ കാർഡ് അപ്‌‌ലോഡ് ചെയ്യുക  </span> <span class="eng-content">   Upload Aadhar Card </span>  </em><font color="red">* </font></p>
    </div>
    <div class="col border-bottom ">
     <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                    </div>
                    <input type="file" class="form-control-file" id="my-file-selector1" onChange="validate_file(this.value)" name="user_photo" required value="" >



                    <div class="invalid-tooltip"> Please upload your aadhar card  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left ">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg">   പെർമിറ്റ് അപ്‌‌ലോഡ് ചെയ്യുക   </span> <span class="eng-content">Upload Building Permit  </span> </em><font color="red">* </font></p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend"> 
                    </div>
                    <input type="file" class="form-control-file" id="my-file-selector2"  name="aadhar_document" onChange="validate_aadhar(this.value)" required >
                    <div class="invalid-tooltip"> Please upload your building permit</div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 5th row -->
  
  <div class="row oddsrows">
    <div class="col-12">
      <div class="alert alert-danger fade in alert-dismissible show mt-3" id="agent_reg">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true" style="font-size:20px">&times;</span>
</button> 
 			 
  			 <div class="row">
  			 <div class="col-12">
  			 	<p class="em">  <i class="fas fa-upload"></i> <font class="text-success"> 
            <span class="mal-content mal_content_reg"> ആധാർ കാർഡ്/പെർമിറ്റ് അപ്‌‌ലോഡ് ചെയ്യുന്നതിന്റെ മാർഗ്ഗനിർദ്ദേശങ്ങൾ.   </span> <span class="eng-content"> Instruction for uploading Aadhar Card and Building Permit.  </span> 
           </font> &nbsp;&nbsp;&nbsp;
  			 	 <font class="text-dark"> <span class="mal-content mal_content_reg"> JPG, PDF ഫയലുകൾ മാത്രം അപ്‌‌ലോഡ് ചെയ്യുക. അപ്‌‌ലോഡ് ചെയ്യുന്ന ഫയലിന്റെ പരമാവധി സൈസ് 200 കെ.ബി.യിൽ താഴെ മാത്രമെന്ന് ഉറപ്പ് വരുത്തുക.   </span> <span class="eng-content"> Format: .JPG and .PDF only. Maximum allowed file size: less than 200 KB.   </span>   </font> </p>
  			 	<br> 
  			 </div> <!-- end of col-9 -->
  			 
      </div> <!-- end of inner row -->
               </div>  <!-- end of alert div -->
    </div> <!-- end of col-12 -->
  </div> <!-- end of alert  row -->
  <div class="row oddrows">
    <div class="col-12">
      <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="agent_status" value="" name="agent_status">
              &nbsp; &nbsp;&nbsp;&nbsp;
              <label class="form-check-label" for="agent_status" ><p class="mt-4 text-secondary"><em>
                  <span class="mal-content mal_content_reg">   
                    മുകളിൽ ചേർത്തിരിക്കുന്ന വിവരങ്ങൾ എല്ലാം സത്യസന്ധമാണെന്ന് ഇതിനാൽ സാക്ഷ്യപ്പെടുത്തുന്നു.
                  </span> <span class="eng-content">
                I certify that the information submitted in this application is true and correct to the best of my knowledge. <br>
                I further understand that any false statements may result in denial or revocation of the service.
                 </span> 

                
               </em></p></label>
            </div> <!-- end of form check -->
    </div> <!-- end of col12 -->
  </div> <!-- end of disclaime row -->
<div class="row border-bottom evenrows">
<div class="col py-2">
  <!-- <input type="hidden" name="username" id="username" value=""> -->
<span class="eng-content">
<a class="btn btn-secondary  btn-block btn-flat btn-point" href="<?php echo base_url()."index.php/Master/index"?>"><i class="fas fa-home" ></i> &nbsp; &nbsp; Home</a> </span> <span class="mal-content mal_content"> <a class="btn btn-secondary  btn-block btn-flat btn-point" href="<?php echo base_url()."index.php/Master/index"?>"><i class="fas fa-home" ></i> &nbsp; &nbsp;  ഹോം </a> 
 </span>
  <!-- <button type="button" class="btn btn-secondary">Home</button> -->
</div>
<div class="col py-2">
	
</div>
<div class="col py-2"> 
</div>
<div class="col py-2"> 
	<div class="g-recaptcha" data-sitekey="6LfjJXUUAAAAANiuQP5xLuHrcbu7nV-3FYxNCb4z" data-type="image" data-size='invisible' data-callback="">
    
  </div>
</div>    
<div class="col py-2">
  <span class="eng-content">
  <button class="btn btn-success text-white btn-flat btn-block btn-point" type="submit" name="btnsubmit" id="btnsubmit"> <i class="far fa-save"></i>&nbsp; &nbsp; Save </button> </span> <span class="mal-content mal_content"> <button class="btn btn-success text-white btn-flat btn-block btn-point" type="submit" name="btnsubmit" id="btnsubmit"> <i class="far fa-save"></i>&nbsp; &nbsp; രജിസ്റ്റർ ചെയ്യുക </button> </span>
</div>
</div><!-- end of 8th row -->
<div class="row">
  <div class="col-12 d-flex justify-content-center text-muted py-1">
    <em> <span class="mal_content mal-content"> </span> <span class="eng-content"> Designed and Developed by C-DIT  </span> </em>
  </div> <!-- end of col12 -->
</div> <!-- end of row -->
</div> <!-- end of main container -->
</form>
</section> <!-- end of main section -->
</body>

<script language="javascript">
 $('#co_owner_status').on('ifChecked', function () { $('#co_owner_num_div').show(); });
 $('#co_owner_status').on('ifUnchecked', function () { $('#co_owner_count').val(''); $('#co_owner_num_div').hide(); });

/*var jq14 = jQuery.noConflict(true);
(function ($) {*/

$(document).ready(function(){

$("#form1").validate({

rules: 
{
  user_idcard_id      : {required:true,},
 user_idcard_number  : {required:true,},

   co_owner_count        : {required:{depends: function(element) 
                          {
                          if($("input[name='co_owner_status']:checked").val()=='1')
                          return true;
                            else
                          return false;
                          }
                              }
                            },

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
  user_idcard_id      : {required:"<font color='red'>Required!!</font>",},
  co_owner_count      : {required:"<font color='red'>Required!!</font>",},
  user_idcard_number  : {required:"<font color='red'>Required!!</font>",},
},
});
//-----------Validation End-----------//

/*$('#minor_status').on('ifChecked', function () { $('#hdnminor').val(1); });
$('#minor_status').on('ifUnchecked', function () { $('#hdnminor').val(0); });*/


$('#agent_status').on('ifChecked', function () { $('#hdnagent').val(1); });
$('#agent_status').on('ifUnchecked', function () { $('#hdnagent').val(0); });

$('#co_owner_status').on('ifChecked', function () { $('#hdn_co_owner').val(1); });
$('#co_owner_status').on('ifUnchecked', function () { $('#hdn_co_owner').val(0); });
    

//------JQUERY END-------------//
});


</script>
