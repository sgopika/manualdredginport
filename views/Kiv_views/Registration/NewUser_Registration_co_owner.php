<?php $count        = $this->session->userdata('co_owner_count'); ?>
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

if(user_name.length<4)
{
   alert("Name should contain atleast 3 characters");
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

//----pdf checking------//
/*var _URL = window.URL || window.webkitURL;
    
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
*/



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




/*$("#user_aadhar_id").change(function(){
    var aadhar_id=$("#user_aadhar_id").val();

    var aadhar_length = aadhar_id.length; 
    if(aadhar_length<12)
    {
      alert('Please enter 12 Digit Aadhar Number');
      $("#user_aadhar_id").val('');
      return false;
    }

  });
*/


  

/*$("#user_dob").change(function(){
 var user_dob=  $("#user_dob").val();
  var last2 = user_dob.substr(-4);
   if(last2>2000)
   {
       alert("Invalid Date of Birth");
        $("#user_dob").val('');
        return false;
   }
});
*/






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
             url:"<?php echo site_url('Kiv_Ctrl/Registration/idcard_verify')?>",
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
 var last2      = user_dob.substr(-4);


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

   if(((year-last2)>99) || (diffDays>0))
   {
        alert("Invalid Date of Birth");
        $("#user_dob").val('');
        return false;
   }
  
});






//----------Jquery End-------//
}); 


/*function validate_file(file) {
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
} */

/*function validate_file(file) 
{
  var count1=file.match(/[.]/g).length; 
  if(count1>1)
  {
    alert('Sorry, invalid extension. Only jpg and png images are allowed');
    $('#my-file-selector1').val('');
    return false;
  }
  else if(count1==1)
  {
    var extension = $('#my-file-selector1').val().split('.').pop().toLowerCase();
    if($.inArray(extension, ['png','jpg','jpeg']) == -1) 
    {
      alert('Sorry, invalid extension. Only jpg and png images are allowed');
      $('#my-file-selector1').val('');
      return false;
    }
  }
  else
  {

  }
}*/
function validate_file(file1) 
{
const uploads = []
const fileSelector = document.getElementById('my-file-selector1')
fileSelector.addEventListener('change', (event) => {
console.time('FileOpen')
const file = event.target.files[0]
const filereader = new FileReader()
filereader.onloadend = function(evt) 
{
  if (evt.target.readyState === FileReader.DONE) 
  {
    const uint = new Uint8Array(evt.target.result)
    let bytes = []
    uint.forEach((byte) => {
    bytes.push(byte.toString(16))
    })
    const hex = bytes.join('').toUpperCase();
    uploads.push({
    filename: file.name,
    filetype: file.type ? file.type : 'Unknown/Extension missing',
    binaryFileType: getMimetype(hex),
    hex: hex
    })
    render();
  }
  console.timeEnd('FileOpen');
}
const blob = file.slice(0, 4);
filereader.readAsArrayBuffer(blob);
})

const render = () => {
  const container = document.getElementById('files');
  const uploadedFiles = uploads.map((file) => {
    $("#filestext").val(file.binaryFileType);

    return `<div>
    Upload Error: ${file.binaryFileType}<br>
    </div>`
  });
  //container.innerHTML = uploadedFiles.join('');
  var imgtype=$("#filestext").val();
  if(imgtype=='Unknown filetype')
  {
    $("#my-file-selector1").val('');
    container.innerHTML ='<span style="color:red">Unknown filetype</span>';
  }
  else
  {
    container.innerHTML ='<span style="color:green">Actual filetype</span>';
  }

}



const getMimetype = (signature) => {
switch (signature) {
case '89504E47':
return 'image/png'
case '47494638':
return 'image/gif'
case '25504446':
return 'application/pdf'
case 'FFD8FFDB':
case 'FFD8FFE0':
return 'image/jpeg'
case '504B0304':
return 'application/zip'
default:
return 'Unknown filetype'
}
}
}
function validate_aadhar(file) 
{
  var count1=file.match(/[.]/g).length; 
  if(count1>1)
  {
    alert('Sorry, invalid extension. Only jpg and png images are allowed');
    $('#my-file-selector2').val('');
    return false;
  }
  else if(count1==1)
  {
    var extension = $('#my-file-selector2').val().split('.').pop().toLowerCase();
     if($.inArray(extension, ['pdf']) == -1)  
    {
      alert('Sorry, invalid extension. Only jpg and png images are allowed');
      $('#my-file-selector2').val('');
      return false;
    }
  }
  else
  {

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
                window.alert("This field accepts Alphanumeric with hyphen(-) and slash (/) ");
                return false;
        }
        }


</script>

<!-- _____________ Include the above in your HEAD tag ______________________________-->
<body>
<section class="login-block">
<!-- <form class="needs-validation" novalidate name="form1" id="form1" action="" method="post" enctype="multipart/form-data"> -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Registration/NewUser_Registration_co_owner", $attributes);
?>
  
<div class="container"> 


  <div class="row">
    <div class="col">      <img src="<?php echo base_url(); ?>plugins/img/logo.png"  alt="PortInfo">
    <input type="hidden" value="<?php echo $count; ?>" name="co_owner_count" id="co_owner_count">
    </div>
    <div class="col-4 border-left pb-2">
      <i class="fas fa-user-plus mt-5 text-primary"></i> <font class="text-primary"> <span class="eng-content"> Co-owners details </span><span class="mal-content mal_content_reg">   സഹ‌‌ ഉടമകളുടെ രജിസ്ട്രേഷൻ    </span> </font>  <hr>
      <button type="button" class="btn btn-primary btn-point btn-flat eng-content" id="mal-button" >Malayalam</button>
      <button type="button" class="btn btn-primary btn-point btn-flat mal-content" id="eng-button">English</button>
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
  //for($i=1; $i<=$count;$i++)
  //{
  ?>
 <div class="alert alert-info fade in alert-dismissible show" id="guardian_reg">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true" style="font-size:20px">&times;</span>
</button> 
  <p class="text-primary"> <strong> <em>  <span class="mal-content mal_content_reg"> സഹ‌‌ ഉടമകളുടെ രജിസ്ട്രേഷൻ ഫോം </span> <span class="eng-content">  <font face="Book Antiqua"> Co-owner Registration Form </font> </span> </em> </strong> </p>
  <font class="text-primary">  <span class="mal-content mal_content_reg"> സഹ ബോട്ടുടമകളുടെ വിവരങ്ങൾ ഇവിടെ രജിസ്റ്റർ ചെയ്യുക. എല്ലാ വിവരങ്ങളും നിർബന്ധമായും ചേർത്ത് ഫോം പൂരിപ്പിക്കേണ്ടതാണ്. അപൂർണ്ണമായ ഫോം രജിസ്റ്റർ ചെയ്യുവാൻ സാധിക്കുന്നതല്ല. </span> <span class="eng-content">  Please enter details about your co-owner. All fields are mandatory. Your login credential will not be shared with your co-owner(s). All intimations will be sent to vessel owner's email id and mobile number only. </span>
     <span class="mal-content mal_content_reg"> </span> <span class="eng-content"> 
  <a href="http://portinfo.kerala.gov.in" target="_blank" class="btn btn-sm btn-outline-success"> Click here for more details </a>
</span>
    </font>
</div> <!-- end of alert div -->
  <div class="row oddrows">
   <div class="col-2 border-top border-bottom">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> പേര് </span> <span class="eng-content"> Name</span> </em><font color="red">*</font></p>
    </div>
    <div class="col border-top border-bottom">
             <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-user-circle"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Co-owner name" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);" maxlength="50">
                    <div class="invalid-tooltip"> Please enter Co-owner Name  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-top border-bottom border-left">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> ജനനതീയ്യതി </span> <span class="eng-content"> Date of birth </span> </em><font color="red">*</font></p>
    </div>
    <div class="col border-top border-bottom">
       <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control dob" placeholder="Date of birth" name="user_dob" id="user_dob" required>
                    <div class="invalid-tooltip"> Please enter dob. </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 1st row -->



    <div class="row evenrows">
   <div class="col-2 border-bottom ">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg">മൊബൈൽ നമ്പർ  </span> <span class="eng-content"> Mobile Number</span> </em><font color="red">*</font></p>
    </div>
    <div class="col border-bottom">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Valid 10 digit mobile number" name="user_mobile_number" id="user_mobile_number" required maxlength="10" onkeypress="return IsNumeric(event);" value="<?php //echo $user_mobile_number; ?>">
                    <div class="invalid-tooltip"> Please enter Co Owner Mobile Number </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> ഈമെയിൽ ഐഡി</span> <span class="eng-content"> Email Id </span></em><font color="red">*</font></p>
    </div>
    <div class="col border-bottom">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-envelope"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Email Id" name="user_email" id="user_email" required onchange="return validateEmail(this.value);" value="<?php //echo $user_email; ?>">
                    <div class="invalid-tooltip"> Please enter Co Owner Email </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 2nd row -->

  <div class="row oddrows">
   <div class="col-2 border-bottom ">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg">മേൽവിലാസം  </span> <span class="eng-content"> Address </span></em><font color="red">*</font></p>
    </div>
    <div class="col border-bottom">
         <div class="form-group mt-3">
                  <div class="input-group">
                   <textarea class="form-control" aria-label="With textarea" id="user_address"  name="user_address" required ><?php //echo $user_address ;?></textarea>
                   <div class="invalid-tooltip"> Please enter Co-owner Address </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-6 border-bottom border-left">
     
    </div>
  </div> <!-- end of 4th row -->
  
  <div class="row evenrows">
   <div class="col-2 border-bottom ">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> തിരിച്ചറിയൽ കാർഡ്</span> <span class="eng-content"> Identity Card</span></em><font color="red">*</font></p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-address-book"></i></span>
                    </div>
                       <select class="custom-select select2" id="user_idcard_id" name="user_idcard_id">
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
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg">തിരിച്ചറിയൽ കാർഡ് നമ്പർ  </span> <span class="eng-content"> ID Card Number </span></em><font color="red">*</font></p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-address-card"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="ID Card number" name="user_idcard_number" id="user_idcard_number" maxlength="15" onkeypress="return IsAlphanumeric(event);">
                    <div class="invalid-tooltip"> Please enter valid identity card number  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 6th row -->
  

  <!-- end of 7th row -->
<div class="row border-bottom oddrows">

<div class="col mt-3 mb-3"> </div>    
<div class="col-2 mt-3 mb-1">  <input type="hidden" name="hdnminor" id="hdnminor" value="0">
   <span class="mal-content mal_content_reg"> <button class="btn btn-success text-white btn-block btn-sm btn-point" type="submit" name="btnsubmit" id="btnsubmit"> <i class="far fa-save"></i> &nbsp; &nbsp; രജിസ്റ്റർ ചെയ്യുക  </button></span> <span class="eng-content"> 
  <button class="btn btn-success text-white btn-block btn-sm btn-point" type="submit" name="btnsubmit" id="btnsubmit"> <i class="far fa-save"></i> &nbsp; &nbsp; Save </button> </span>
</div>
</div><!-- end of 8th row -->

</div> <!-- end of main container -->
 <?php echo form_close(); ?>
<!--</form> -->

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


 




    

//------JQUERY END-------------//
});


</script>
