<?php
$code=rand(1000,9999);
  $_SESSION["cap_code"]=$code;
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


<script type="text/javascript">
$(document).ready(function(){



$("#captchareload").click(function()
{
  $("#captcha").val('');
  $.post("<?php echo base_url()?>recaptcha.php",function(data)
  {
    var newcap="<?php echo base_url()?>captcha.php?id="+data;
    $('#capchaimg').attr('src',newcap);
    //  var enc_data=data;
    var enc_data=btoa(data);
    $('#pass2').val(enc_data);
  });
});

$("#captcha").change(function()
{
  var cap_code=$("#captcha").val();
  //alert(cap_code);exit;
  if(cap_code=="")
  {
  alert('Please Enter Captcha code as shown !!!', 'Captcha Code Not Entered');
  $("#captcha").focus();

  }
  else if(btoa(cap_code)!=document.getElementById("pass2").value)
  {
  alert('Captcha Code Entered not correct !!!!');
  $("#captcha").val('');
  $("#captcha").focus();

  }
  else{//alert("ddddd");
  }
});



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
             url:"<?php echo site_url('Kiv_Ctrl/Registration/mobileverify')?>",
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
    //alert(email_id);
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
 //alert(user_idcard_id);
  var user_idcard_number= $("#user_idcard_number").val();

 var user_idcard = user_idcard_number.length; 
 //alert(user_idcard);
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
             url:"<?php echo site_url('Kiv_Ctrl/Registration/username_verify')?>",
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


$("#user_idcard_id").change(function(){
var user_idcard_id=$("#user_idcard_id").val();
   if(user_idcard_id!='')
     {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({type: "POST",
             url:"<?php echo site_url('Kiv_Ctrl/Registration/user_idcard_id_name')?>",
            data: { user_idcard_id: user_idcard_id,'csrf_test_name': csrf_token},
             success: function(data)
             { 
              
              $("#showmsg").html(data);
               $("#user_idcard_number").val(data+' number');
                $("#showmsg1").html(data);
              
             }
       });  
     }
});

//----------Jquery End-------//
}); 


/*function validate_file(file) 
{
  var str=$('#my-file-selector1').val();
  var n = str.includes(".php");
  if(n==false)
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
    alert('Sorry, invalid extension. Only jpg and png images are allowed');
    $('#my-file-selector1').val('');
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
ret/*urn 'image/jpeg'
case '504B0304':*/
return 'image/jpg'
case '504B0304':
return 'application/zip'
default:
return 'Unknown filetype'
}
}
}
/*

function validate_aadhar(file1) 
{
const uploads = []
const fileSelector = document.getElementById('my-file-selector2')
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
  const container = document.getElementById('files2');
  const uploadedFiles = uploads.map((file) => {
    $("#filestext2").val(file.binaryFileType);

    return `<div>
    Upload Error: ${file.binaryFileType}<br>
    </div>`
  });
  //container.innerHTML = uploadedFiles.join('');
  var imgtype=$("#filestext2").val();
  if(imgtype=='Unknown filetype')
  {
    $("#my-file-selector2").val('');
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
}*/
function validate_aadhar(file) 
{
  var count1=file.match(/[.]/g).length; 
  if(count1>1)
  {
    alert('Sorry, invalid extension. Only pdf files are allowed');
    $('#my-file-selector2').val('');
    return false;
  }
  else if(count1==1)
  {
    var extension = $('#my-file-selector2').val().split('.').pop().toLowerCase();
     if($.inArray(extension, ['pdf']) == -1)  
    {
      alert('Sorry, invalid extension. Only  pdf files are allowed');
      $('#my-file-selector2').val('');
      return false;
    }
  }
  else
  {

  }
} 

function validate_pan(file) 
{
  var count1=file.match(/[.]/g).length; 
  if(count1>1)
  {
    alert('Sorry, invalid extension. Only pdf files are allowed');
    $('#my-file-selector3').val('');
    return false;
  }
  else if(count1==1)
  {
    var extension = $('#my-file-selector3').val().split('.').pop().toLowerCase();
     if($.inArray(extension, ['pdf']) == -1)  
    {
      alert('Sorry, invalid extension. Only  pdf files are allowed');
      $('#my-file-selector3').val('');
      return false;
    }
  }
  else
  {

  }
} 

function validate_sign(file) 
{
  var count1=file.match(/[.]/g).length; 
  if(count1>1)
  {
    alert('Sorry, invalid extension. Only pdf files are allowed');
    $('#my-file-selector4').val('');
    return false;
  }
  else if(count1==1)
  {
    var extension = $('#my-file-selector4').val().split('.').pop().toLowerCase();
     if($.inArray(extension, ['pdf']) == -1)  
    {
      alert('Sorry, invalid extension. Only  pdf files are allowed');
      $('#my-file-selector4').val('');
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

<?php
   $attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
      echo form_open("Kiv_Ctrl/Registration/NewUser_Registration", $attributes);
      ?>

<!--<form class="needs-validation" novalidate name="form1" id="form1" action="" method="post" enctype="multipart/form-data"> -->
<div class="container"> 
  <div class="row">
    <div class="col">      <img src="<?php echo base_url(); ?>plugins/img/logo.png"  alt="PortInfo">
    </div>
     <div class="col-4 border-left pb-2">
      <i class="fas fa-user-plus mt-5 text-primary"></i> <font class="text-primary"> <span class="eng-content"> Customer Registration | Vessel Owner </span><span class="mal-content mal_content_reg">     ഉപഭോക്തൃ രജിസ്ട്രേഷൻ |  ബോട്ടുടമകളുടെ രജിസ്ട്രേഷൻ  </span> </font>  <hr>
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
  <p class="text-primary"> <strong> <em> <font face="Book Antiqua">  <span class="mal-content mal_content_reg"> </span> <span class="eng-content">  Registration form for registering as Kerala Inland Vessel Owner. </span> </font>  <span class="mal-content mal_content_reg">  കേരള ഉൾനാടൻ ജലഗതഗതം  | ബോട്ടുടമകൾക്കുള്ള രജിസ്ട്രേഷൻ ഫോം </span> </em> </strong> </p> 
  <p class="text-primary"> <em> <span class="mal-content mal_content_reg"> </span> <span class="eng-content">  You can now register as a vessel owner by filling the registration form. All the fields are mandatory except occupation address. If your age is less than 18, you have to add guardian details. You can also add details of agent (if you have any) and co-owner(s). On successful registration, username and password will be sent to your email and mobile. You can also add/edit details by login to the site 
  <a href="http://portinfo.kerala.gov.in" target="_blank" class="btn btn-sm btn-outline-primary"> portinfo.kerala.gov.in </a>
    after completing your registration. Do not press back button or refresh button while registration is in process. </span>
     <span class="mal-content mal_content_reg text-justify">

      നിർദ്ദിഷ്ട രജിസ്ട്രേഷൻ ഫോം വഴി ഉപഭോക്താക്കൾക്ക് ബോട്ടുടമകളായി രജിസ്റ്റർ ചെയ്യാവുന്നതാണ്. എല്ലാ വിവരങ്ങളും നിർബന്ധമായി പൂരിപ്പിക്കേണ്ടതാണ്. അപൂർണ്ണ വിവരങ്ങൾ ഉള്ള ഫോം രജിസ്റ്റർ ചെയ്യുവാൻ സാധിക്കുന്നതല്ല. ഉപഭോക്താവ് 18-വയസ്സിൽ താഴെയാണെങ്കിൽ, രക്ഷിതാവിന്റെ വിവരങ്ങൾ കൂടി അടുത്ത് ഫോമിൽ രജിസ്റ്റർ ചെയ്യേണ്ടതാണ്. രജിസ്റ്റർ ഫോം മുഖേന ഏജന്റിന്റെ വിവരങ്ങൾ, സഹ ഉടമകളുടെ വിവരങ്ങൾ എന്നിവ രജിസ്റ്റർ ചെയ്യാവുന്നതുമാണ്. രജിസ്റ്റർ ചെയ്തതിന് ശേഷം ഉപഭോക്താക്കളുടെ യൂസർ നെയിം പാസ്സ്‌‌വേർഡ് എന്നിവ ഉപഭോക്താവ് നൽകിയിട്ടുള്ള ഈമെയിൽ ഐഡി, മൊബൈൽ നമ്പർ എന്നിവയിൽ ലഭ്യമാകുന്നതാണ്. <a href="http://portinfo.kerala.gov.in" target="_blank" class="btn btn-sm btn-outline-primary"> portinfo.kerala.gov.in </a>  എന്ന സൈറ്റിൽ ലോഗിൻ ചെയ്ത്, ഉപഭോക്താവിന് പ്രൊഫൈൽ എഡിറ്റ് ചെയ്യാവുന്നതാണ്. രജിസ്ട്രേഷൻ ചെയ്യുന്ന സമയത്ത് Back/Refresh Button എന്നിവ ഉപയോഗിക്കാതിരിക്കുക.</span>   </em> </p>
     <!-- Button to Open the Modal -->
<button type="button" class="btn btn-secondary btn-point btn-sm" data-toggle="modal" data-target="#instruction_modal">
  നിർദ്ദേശങ്ങൾ മലയാളത്തിൽ ലഭിക്കുന്നതിന് ഇവിടെ ക്ലിക്ക് ചെയ്യുക
</button>
</div> <!-- end of alert -->
  </div> <!-- end of col12 alert -->
 </div> <!-- end of alert row -->


<!-- The Modal -->
<div class="modal" id="instruction_modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title mal_content">രജിസ്ട്രേഷൻ  ഫോം പൂരിപ്പിക്കുന്നതിനുള്ള നിർദ്ദേശങ്ങൾ  </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> <!-- ene of modal header -->

      <!-- Modal body -->
      <div class="modal-body mal_content_reg">
        <?php include ('instruction.php'); ?>
      </div> <!-- end of modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> <!-- end of modal footer -->

    </div> <!-- end of modal content -->
  </div> <!-- end of modal dialog -->
</div> <!-- end of modal div -->

<div class="col-md-12"> <?php if( $this->session->flashdata('msg')) {  echo $this->session->flashdata('msg'); } ?> </div>

  <div class="row oddrows">
   <div class="col-2 border-top border-bottom ">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> പേര് </span> <span class="eng-content"> Name </span> </em><font color="red">* </font> </p>
    </div>
    <div class="col border-top border-bottom">
             <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> <i class="fas fa-user-tag"></i> </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Vessel owner's name" name="user_name" id="user_name" required onkeypress="return alpbabetspace(event);"  maxlength="50">
                    <div class="invalid-tooltip"> Please enter your name  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-top border-bottom border-left">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> ജനനതീയ്യതി  </span> <span class="eng-content"> Date of birth</span> </em><font color="red">* </font></p>
    </div>
    <div class="col border-top border-bottom">
       <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control dob" placeholder="Date of birth" name="user_dob" id="user_dob" required>
                    <div class="invalid-tooltip"> Please enter your dob. </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
	</div> <!-- end of 1st row -->
    <div class="row evenrows">
   <div class="col-2 border-bottom ">
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> മൊബൈൽ നമ്പർ  </span> <span class="eng-content"> Mobile Number </span> </em><font color="red">* </font></p>
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
      <p class="mt-4 text-secondary"><em> <span class="mal-content mal_content_reg"> ഈമെയിൽ ഐഡി </span> <span class="eng-content"> Email Id </span> </em><font color="red">* </font></p>
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


  <div class="row oddrows">
   <div class="col-2 border-bottom">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> സംസ്ഥാനം  </span> <span class="eng-content"> State</span> </em><font color="red">* </font></p>
    </div>

            <div class="col border-bottom">
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
            
            </div>


    <div class="col-2 border-bottom border-left">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> ജില്ല </span> <span class="eng-content"> District </span></em><font color="red">* </font></p>
    </div>


    <div class="col border-bottom">
    	 <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                   <select class="custom-select select2" id="user_district_id" required name="user_district_id">
                    </select>
                    <div class="invalid-tooltip"> Please select District  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>


  </div> <!-- end of 9th row -->

  <div class="row evenrows">
   <div class="col-2 border-bottom">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg">മേൽവിലാസം  </span> <span class="eng-content"> Address</span> </em><font color="red">* </font></p>
    </div>
    <div class="col border-bottom">
         <div class="form-group mt-3">
                 
                   <textarea class="form-control" aria-label="With textarea" id="user_address" rows="4"  name="user_address" required onkeypress="return IsAddress(event);" maxlength="100"  ></textarea>
                   <div class="invalid-tooltip"> Please enter your Address </div>
                 
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> ഓഫീസ് വിലാസം </span> <span class="eng-content"> Company Address</span> </em></p> 
    </div>
    <div class="col border-bottom">
         <div class="form-group mt-3">
                 
                   <textarea class="form-control" aria-label="With textarea"  name="user_occupation_address" rows="4" id="user_occupation_address" onkeypress="return IsAddress(event);" maxlength="100"></textarea>
                   <div class="invalid-tooltip"> Please enter your Office Address</div>
                  
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 4th row -->
  <div class="row oddrows">
    <div class="col-2 border-bottom">
      <p class="col-3 mt-4 text-secondary"><em><span class="mal-content mal_content_reg">ജോലി  </span> <span class="eng-content"> Occupation</span></em><font color="red">* </font></p>
    </div>
    <div class="col border-bottom">
      <div class="form-group mt-3">
                  
                   <select class="custom-select select2" id="inputGroupSelect01" required name="user_occupation_id">
                     <option value="">Select</option>
    <?php foreach ($occupation as $res_occupation)
    {
    ?>
    <option value="<?php echo $res_occupation['occupation_sl']; ?>"><?php echo $res_occupation['occupation_name'];?></option>
    <?php
    } 
    ?>
                    </select>
                    <div class="invalid-tooltip"> Please select your Occupation</div>
                  
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>

    <div class="col border-bottom border-left">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="agent_status" value="" name="agent_status">
              <label class="form-check-label" for="agent_status" ><p class="mt-4 text-secondary"><em>&nbsp; <span class="mal-content mal_content_reg"> ഏജന്റ് ഉണ്ടോ?</span> <span class="eng-content"> Do you have an agent/builder ? </span> </em></p></label>
              <input type="hidden" name="hdnagent" id="hdnagent" value="0">
              <input type="hidden" name="hdnminor" id="hdnminor" value="0">
            </div> 
    </div>
    <div class="col-4 border-bottom border-left d-flex flex-grow-1">
      

       <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="co_owner_status" value="" name="co_owner_status">

              <label class="form-check-label" for="co_owner_status"> <p class="mt-3 text-secondary" ><em>&nbsp; <span class="mal-content mal_content_reg"> സഹ ഉടമകൾ ഉണ്ടോ? </span> <span class="eng-content"> Do you have co-owners ? </span> </em></p></label>
               <input type="hidden" name="hdn_co_owner" id="hdn_co_owner" value="0">
             <div class="form-group col mt-3" id="co_owner_num_div" style="display: none;">
                   <span id="show_co_owner_count"> <input type="text" class="form-control" placeholder="Number" name="co_owner_count" id="co_owner_count" onkeypress="return IsNumeric(event);" maxlength="1" > 
                  <span id="textval1"></span></span>
              </div> 
            </div> 

    </div>


  </div> <!-- end of 7th row -->
  <div class="row evenrows">
   <div class="col-2 border-bottom ">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> തിരിച്ചറിയൽ കാർഡ് </span> <span class="eng-content"> Identity Card</span></em><font color="red">* </font></p>
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
                    <div class="invalid-tooltip"> Please select an ID Card  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg">തിരിച്ചറിയൽ കാർഡ് നമ്പർ  </span> <span class="eng-content"><span id="showmsg"></span> Number</span> </em><font color="red">* </font></p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-address-card"></i></span>
                    </div>
                    <input type="text" class="form-control"  name="user_idcard_number" id="user_idcard_number" maxlength="15" onkeypress="return IsAlphanumeric(event);">
                    <div class="invalid-tooltip"> Please enter valid Identity Card Number  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 6th row -->

  <div class="row oddrows">
   <div class="col-2 border-bottom ">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg">ഫോട്ടോ അപ്‌‌ലോഡ് ചെയ്യുക </span> <span class="eng-content"> Upload Photograph</span></em><font color="red">* </font></p>
    </div>

    <div class="col border-bottom ">
     <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                    </div><div id="files"></div>
                    <input type="hidden" id="filestext" name="filestext">
                   <!--  <input type="file" class="form-control-file" id="my-file-selector1" onChange="validate_file(this.value)" name="user_photo" required value="" >   -->

                   <input type="file" class="form-control-file" id="my-file-selector1" onClick="validate_file(this.value)" name="user_photo" required value=""  >

                   <div class="invalid-tooltip"> Please upload your Photo  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left ">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg"> ഐഡി കാർഡ് അപ്‌‌ലോഡ് ചെയ്യുക  </span> <span class="eng-content"> Upload <span id="showmsg1"> </span> </span></em><font color="red">* </font></p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend"> 
                    </div>
                    <div id="files2"></div>
                    <input type="hidden" id="filestext2" name="filestext2">
                    <input type="file" class="form-control-file" id="my-file-selector2"  name="aadhar_document" onChange="validate_aadhar(this.value)" required >
                    <div class="invalid-tooltip"> Please upload your ID Card </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 5th row -->


  <div class="row evenrows">
   <div class="col-2 border-bottom ">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg">----- </span> <span class="eng-content"> PAN card number</span></em><font color="red"> </font></p>
    </div>
    <div class="col border-bottom ">
     <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                    </div>
                    <input type="text" class="form-control" placeholder="PAN card number" name="pan_card_number" id="pan_card_number" maxlength="15" onkeypress="return IsAlphanumeric(event);">
                    <div class="invalid-tooltip"> Please enter valid PAN card Number  </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left ">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg">------ </span> <span class="eng-content"> Upload PAN Card </span></em><font color="red"> </font></p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend"> 
                    </div>
                    <input type="file" class="form-control-file" id="my-file-selector3"  name="pancard_document" onChange="validate_pan(this.value)" >
                    <div class="invalid-tooltip"> Please upload your PAN Card </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
  </div> <!-- end of 5th row -->


  <div class="row oddrows">
   <div class="col-2 border-bottom ">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg">----- </span> <span class="eng-content"> Signature upload</span></em><font color="red"> </font></p>
    </div>
    <div class="col border-bottom ">
     <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                    </div>
                     <input type="file" class="form-control-file" id="my-file-selector4"  name="signature" onChange="validate_sign(this.value)"  >
                    <div class="invalid-tooltip"> Please upload your signature </div>
                  </div>
                  <span id="textval1"></span>
   </div> <!-- end of form group -->
    </div>
    <div class="col-2 border-bottom border-left ">
      <p class="mt-4 text-secondary"><em><span class="mal-content mal_content_reg">&nbsp; </span> <span class="eng-content"> &nbsp; </span></em><font color="red"> </font></p>
    </div>
    <div class="col border-bottom ">
      <div class="form-group mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend"> 
                    </div>
                   <!--  <input type="file" class="form-control-file" id="my-file-selector2"  name="pancard_document"  > -->
                    <div class="invalid-tooltip"> &nbsp;</div>
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
  			 <div class="col-9">
  			 	<p class="em text-danger"> <span class="mal-content mal_content_reg"> ഫോട്ടോ അപ്‌‌ലോഡ് ചെയ്യുന്നതിനുള്ള മാർഗ്ഗനിർദ്ദേശങ്ങൾ  </span> <span class="eng-content"> Instruction for uploading Photograph</span> <i class="far fa-file-image"></i> </p>
  			 	 <font class="text-success"> <span class="mal-content mal_content_reg"> ഫോർമാറ്റ് : JPG, PNG എന്നിവ മാത്രം. പരമാവധി സൈസ് : 1 എം.ബി. ഫോട്ടൊയുടെ പരമാവധി നീളവും വീതിയും : 350 px X 150 px. </span> <span class="eng-content"> Format: .JPG and .PNG only. Size: less than 1 MB.  Image resolution (height x width) : 350 px X 150 px. </span> </font>
  			 	<br> <span class="mal-content mal_content_reg"> <a href="http://registration.cdit.org" target="_blank" class="btn btn-outline-success btn-sm">  ഫോട്ടൊയുടെ സൈസ് കുറക്കുന്നതിന് ഇവിടെ ക്ളിക്ക് ചെയ്യാവുന്നതാണ്. </a> </span> <span class="eng-content">  <a href="http://registration.cdit.org" target="_blank" class="btn btn-outline-success btn-sm"> Click here for resizing larger images </a> </span>
  			 </div> <!-- end of col-9 -->
  			 <div class="col-3">
  			 	<p class="em text-danger"> <span class="mal-content mal_content_reg"> ഐഡി കാർഡ് അപ്‌‌ലോഡ് ചെയ്യുന്നതിനുള്ള മാർഗ്ഗനിർദ്ദേശങ്ങൾ  </span> <span class="eng-content">  Instruction for uploading Document/ID Card </span> </p>
  			 	 <font class="text-success"><i class="far fa-file-pdf"></i> <span class="mal-content mal_content_reg"> ഫോർമാറ്റ് : PDF മാത്രം. പരമാവധി സൈസ് : 1 എം.ബി. </span> <span class="eng-content"> Format: PDF. Size: <  1 MB.</span> </font>
				</div> <!-- end of col-3 -->
      </div> <!-- end of inner row -->
               </div>  <!-- end of alert div -->
    </div> <!-- end of col-12 -->
  </div> <!-- end of alert  row -->
  
<div class="row border-bottom evenrows">
<div class="col mt-2 mb-1">
  <!-- <input type="hidden" name="username" id="username" value=""> -->
<span class="mal-content mal_content_reg"> <a class="btn btn-secondary" href="<?php echo base_url()."index.php/Main_login/index"?>"><i class="fas fa-home" ></i> &nbsp; &nbsp; ഹോം</a> </span> <span class="eng-content"> 
<a class="btn btn-secondary" href="<?php echo base_url()."index.php/Main_login/index"?>"><i class="fas fa-home" ></i> &nbsp; &nbsp; Home</a> </span>
  <!-- <button type="button" class="btn btn-secondary">Home</button> -->
</div>


<!-- <div class="col mt-1 mb-3"> 
	<div class="g-recaptcha" data-sitekey="6LfjJXUUAAAAANiuQP5xLuHrcbu7nV-3FYxNCb4z" data-type="image" data-size='invisible' data-callback="">
    
  </div>
</div>  -->   

     
           <div class="col mt-8 mb-1">
             <label>Please enter the code</label><font color="#FF0000">*</font>
     <input name="captcha" type="text" class="validate[required,custom[onlyLetterNumber]]"  id="captcha" autocomplete="off"  placeholder="Enter Captcha" size="10" maxlength="4" style="text-align:center" onKeyPress="return event.charCode >= 48 && event.charCode <= 57" required="true" title="Please Enter the Captcha !!!!">
          <?php $rr=base64_encode($_SESSION['cap_code']);?>
           <img src="<?php echo base_url()?>captcha.php?id=<?php echo $code; ?>" id="capchaimg"/>
             <input name="pass2" type="hidden" class="tb4" id="pass2" size="24"  value=<?php echo $rr;?>>
             
          <img src="<?php echo base_url()?>plugins/img/Refresh.png"  style="cursor:pointer" id="captchareload"  >
          </div>
        </div>
<div class="row border-bottom">
  <div class="col mt-5 mb-1"></div>
<div class="col mt-2">
  <span class="mal-content mal_content_reg"> <button class="btn btn-success text-white" type="submit" name="btnsubmit" id="btnsubmit"> <i class="far fa-save"></i>&nbsp; &nbsp; രജിസ്റ്റർ ചെയ്യുക  </button>
  </span> <span class="eng-content"> 
  <button class="btn btn-success text-white btn-sm" type="submit" name="btnsubmit" id="btnsubmit">
   <i class="far fa-save"></i>&nbsp; &nbsp; Save </button> </span>
</div>
<div class="col mt-5 mb-1"></div>
</div><!-- end of 8th row -->
</div> <!-- end of main container -->
 <?php echo form_close(); ?>
<!--</form> -->
</section> <!-- end of main section -->
</body>

<script language="javascript">
 $('#co_owner_status').on('ifChecked', function () { $('#co_owner_num_div').show(); });
 $('#co_owner_status').on('ifUnchecked', function () { $('#co_owner_count').val(''); $('#co_owner_num_div').hide(); });

 $('#agent_status').on('ifChecked', function () { $('#hdnagent').val(1); });
$('#agent_status').on('ifUnchecked', function () { $('#hdnagent').val(0); });

$('#co_owner_status').on('ifChecked', function () { $('#hdn_co_owner').val(1); });
$('#co_owner_status').on('ifUnchecked', function () { $('#hdn_co_owner').val(0); });
    



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




//------JQUERY END-------------//
});


</script>

