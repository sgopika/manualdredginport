<!-- <script src="<?php echo base_url(); ?>plugins/js/jquery.min.js"></script> -->
<script src="<?php echo base_url(); ?>plugins/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fontawesome/js/all.min.js"></script>
<script src="<?php echo base_url();?>plugins/summernote/summernote-bs4.js"></script>
<script>

$(document).ready(function() {
  $("#captchareload").click(function(){
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
            //alert("SDDDDD");
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

  $("#contactcaptcha").change(function()
          {
            //alert("SDDDDD");
         var cap_code=$("#contactcaptcha").val();
         //alert(cap_code);exit;
         if(cap_code=="")
{
alert('Please Enter Captcha code as shown !!!', 'Captcha Code Not Entered');
$("#contactcaptcha").focus();

}
else if(btoa(cap_code)!=document.getElementById("contactpass").value)
{
  alert('Captcha Code Entered not correct !!!!');
    $("#contactcaptcha").val('');
    $("#contactcaptcha").focus();
    
  }
  else{
  }
         
         
         
       });
 

			
    $('#form1').validate({
      rules:
               { 
          user_name:{required:true,
           },

          user_password:{required:true,
          },
                     },
      messages:
               {
             user_name:{required:"<font color='red'>Required</span>",
             },
             
             user_password:{required:"<font color='red'>Required</span>",
             },
               },
      errorPlacement: function(error, element)
                     {
                        if ( element.is(":input") ) { error.appendTo( element.parent() ); }
                        else { error.insertAfter( element ); }
                     }
    }); 
});


/* $('.summernote').summernote({
        
        tabsize: 2,
        height: 400
      });*/
    $('.summernote').summernote({
    tabsize: 2,
    height: 400,
    width: '100%',
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
    ],
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

$("#port").change(function()
  { 
    var port=$("#port").val(); //alert(port);
    var val=$("#val").val(); 
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';

    if(port!= '')
    {
      $.ajax
        ({ 
          type: "POST",
          url:"<?php echo site_url('/Main_login/port_services_ajax/')?>",
          data:{port:port, val:val, 'csrf_test_name': csrf_token},
          success: function(data)
          {   //alert(data); //exit;    
          $("#port_services").html(data);      
            
          }
        });
    } 
    
  });

$("#office").change(function()
  { 
    var office=$("#office").val(); //alert(office);exit;
    var val=$("#val").val(); 
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';

    if(office!= '')
    {
      $.ajax
        ({ 
          type: "POST",
          url:"<?php echo site_url('/Main_login/port_locate_ajax/')?>",
          data:{office:office, val:val, 'csrf_test_name': csrf_token},
          dataType: "JSON",
          success: function(data)
          {   //jquery.parseJSON(data); exit; 

          $("#default_map").hide();   
          $("#map_loca").show();   
          $("#map_loca").html(data['map']);     
          $("#office_locate").html(data['address']);      
             
            
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
          $("#tariff_amt_div").html(data);      
            
          }
        });
    }

   
    
  });

$("#cntct_submit").click(function()
  { //alert("hiii");exit;
    var from_mail_id     = $("#from_mail_id").val(); 
    var services_mail    = $("#services_mail").val(); 
    var subject          = $("#subject").val();
    var message          = $("#message").val();
    var val              = $("#val").val();
    var contactpass       = $("#contactpass").val();
    var contactcaptcha    = $("#contactcaptcha").val();
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';

    if(from_mail_id==''){
      alert("Enter Your Mail ID!!!");
      $("#from_mail_id").focus();
      return false;
    }
    else if(services_mail==''){
      alert("Select Service Type!!!");
      $("#services_mail").focus();
      return false;
    } 
    else if(subject==''){
      alert("Specify Subject!!!");
      $("#subject").focus();
      return false;
    }
    else if(message==''){
      alert("Specify Message!!!");
      $("#message").focus();
      return false;
    }
    else {

      $.ajax
        ({ 
          type: "POST",
          url:"<?php echo site_url('/Main_login/Send_mail_ajax/')?>",
          data:{from_mail_id:from_mail_id,services_mail:services_mail,subject:subject,message:message,contactpass:contactpass,contactcaptcha:contactcaptcha, val:val, 'csrf_test_name': csrf_token},
          success: function(data)
          {   //alert(data); exit;
          $("#send_mail_div").hide();
          $("#success_mail_div").show();
          $("#success_mail_div").html(data);      
            
          }
        });
    }

   
    
  });
/*_____________________________Track vessel__________________________*/
$("#track_vessel").click(function()
{
  var vessel_registration_number     = $("#vessel_registration_number").val(); 
  if(vessel_registration_number=="")
  {
    alert("Enter vessel registration number");
  }
  else
  {
    var encregnum1=btoa(vessel_registration_number);
    var encregnum = encregnum1.split("=").join("~");
    // alert(encregnum);
    $.ajax
    ({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/show_track_vessel/')?>"+encregnum,
      type: "POST",
      //data:$('#form1').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
        //alert(data);exit;
        if(data)
        {
          $("#track_content").html(data); 
          $("#track_myModal").modal('show'); 
        }
        /* else
        {
        $("#track_content").html('No data found'); 
        $("#track_myModal").modal('show'); 
        }*/
      }
    });
  }
});


$("#track_ref_number").click(function()
{
  var reference_number     = $("#reference_number").val(); 
  if(reference_number=="")
  {
    alert("Enter reference number");
  }
  else
  {
    $.ajax
    ({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/show_track_ref_number/')?>"+reference_number,
      type: "POST",
      success: function(data)
      {
        //alert(data);
        if(data)
        {
          $("#track_ref_content").html(data); 
          $("#track_ref_myModal").modal('show'); 
        }
      }
    });
  }
});    


</script>
</body>
</html>