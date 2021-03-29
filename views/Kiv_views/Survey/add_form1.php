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

 $vessel_id1         = $this->uri->segment(4);
 $stage_count1    = $this->uri->segment(5);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$stage_count=str_replace(array('-', '_', '~'), array('+', '/', '='), $stage_count1);
 $stage_count=$this->encrypt->decode($stage_count); 


 $vessel_condition     =   $this->Survey_model->get_vessel_details_dynamic($vessel_id);
    $data['vessel_condition'] = $vessel_condition;
    //print_r($vessel_condition);
    if(!empty($vessel_condition))
    {
      $vessel_type_id=$vessel_condition[0]['vessel_type_id'];
      $vessel_subtype_id=$vessel_condition[0]['vessel_subtype_id'];
      $vessel_length1=$vessel_condition[0]['vessel_length'];
      $hullmaterial_id=$vessel_condition[0]['hullmaterial_id'];
      $engine_placement_id=$vessel_condition[0]['engine_placement_id'];
        
  }
if($stage_count==1)
{
  $active2="show active";
}
else
{
  $active2="";
}

if($stage_count==2)
{
  $active3="show active";
}
else
{
   $active3="";
}

if($stage_count==3)
{
  $active4="show active";
}
else
{
  $active4="";
}

if($stage_count==4)
{
  $active5="show active";
}
else
{
  $active5="";
}

if($stage_count==5)
{
  $active6="show active";
}
else
{
  $active6="";
}
if($stage_count==6)
{
  $active7="show active";
}
else
{
  $active7="";
}

if($stage_count==7)
{
  $active8="show active";
}
else
{
  $active8="";
}


?>

<script language="javascript">
    
$(document).ready(function(){


var stage_count=$("#hdn_stage_count").val();
//alert(stage_count);

if(stage_count==1)
{
  $("#vesseltab").hide();

  var vessel_id=$("#vessel_id").val();
  //alert(vessel_id);
  $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/hull_details_form2/')?>"+vessel_id,
    success: function(data)
    {    
  // alert(data)     ;
      $("#hulldetails").html(data).find(".select2").select2();
    }
    });
}

if(stage_count==2)
{
  $("#vesseltab").hide();
  $("#hulltab").hide();
  var vessel_id=$("#vessel_id").val();
  //alert(vessel_id);
  $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/engine_details_form3/')?>"+vessel_id,
    success: function(data)
    {         
      $("#engine1").html(data).find(".select2").select2();
    }
    });


}
if(stage_count==3)
{
  $("#vesseltab").hide();
  $("#hulltab").hide();
  $("#enginetab").hide();
  var vessel_id=$("#vessel_id").val();
  //alert(vessel_id);
  $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/equipment_details_form4/')?>"+vessel_id,
    success: function(data)
    {         
      $("#equipment1").html(data).find(".select2").select2();
    }
    });

  }


if(stage_count==4)
{
  $("#vesseltab").hide();
  $("#hulltab").hide();
  $("#enginetab").hide();
  $("#equipmenttab").hide();
 var vessel_id=$("#vessel_id").val();
  //alert(vessel_id);
  $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/fireappliance_details_form5/')?>"+vessel_id,
    success: function(data)
    {         
      $("#fireappliance1").html(data).find(".select2").select2();
    }
    });


  }
if(stage_count==5)
{
  $("#vesseltab").hide();
  $("#hulltab").hide();
  $("#enginetab").hide();
  $("#equipmenttab").hide();
  $("#fireappliancetab").hide();
 var vessel_id=$("#vessel_id").val();
  $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/otherequipment_details_form6/')?>"+vessel_id,
    success: function(data)
    {         
      $("#otherequipment1").html(data).find(".select2").select2();
    }
    });

}
if(stage_count==6)
{
  $("#vesseltab").hide();
  $("#hulltab").hide();
  $("#enginetab").hide();
  $("#equipmenttab").hide();
  $("#fireappliancetab").hide();
  $("#otherequipmentstab").hide();
   var vessel_id=$("#vessel_id").val();
  $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/document_details_form7/')?>"+vessel_id,
    success: function(data)
    {         
      $("#documents1").html(data).find(".select2").select2();
    }
    });
 
}
if(stage_count==7)
{
  $("#vesseltab").hide();
  $("#hulltab").hide();
  $("#enginetab").hide();
  $("#equipmenttab").hide();
  $("#fireappliancetab").hide();
  $("#otherequipmentstab").hide();
  $("#documenttab").hide();

  /*var vessel_id=$("#vessel_id").val();
  $.ajax
    ({
    type: "POST",
    url:"<?php //echo site_url('/Kiv_Ctrl/Survey/payment_details_form8/')?>"+vessel_id,
    success: function(data)
    {         
      $("#documents1").html(data).find(".select2").select2();
    }
    });*/
}

/*vesseltab
hulltab
enginetab
equipmenttab
fireappliancetab
fireappliancetab
otherequipmentstab
documenttab
paymenttab*/


$("#portshow").hide();
$("#bankshow").hide();

$("#payment").hide();
$("#tab8next").hide(); //proceed
$("#btnsubmit").hide(); //submit






  $("#bulk_heads_show").show(); //hide when Particulars of Hull Tab Load
  $("#num_bulk").show();

  $("#show_headplacement").hide();

  $("#show_vessel_length_overall").hide();
  $("#Ton").hide();
  $("#Ton_upperdeck").hide();
  $("#over_deck_id").hide();
  $("#over_deck_id_value").hide();
  $("#upper_deck_id").hide();
  $("#upper_deck_id_value").hide();



$("#vessel_length").change(function() 
{
  var vessel_length=($("#vessel_length").val());
  var vessel_length_overall2=($("#vessel_length_overall").val());
  //alert(vessel_length);
   //alert(vessel_length_overall2);

   if(vessel_length_overall2==null)
   {
    vessel_length_overall=0;
   }
   else
   {
    vessel_length_overall=vessel_length_overall2;
   }


  if(vessel_length >vessel_length_overall)
  {
    alert("Vessel length is not exceed  Length overall");
    $("#vessel_length").val('');
    $("#vessel_length").focus();
    //return false;
  }
});



   
$("#vessel_length_overall").change(function() 
{
  var iszero=($("#vessel_length_overall").val());
  


  if( (iszero==0)  || (iszero=='.'))
  {
    alert("Invalid Number");
    $("#vessel_length_overall").val('');
    $("#vessel_length_overall").focus();
    return false;
  }

  var vessel_length=($("#vessel_length").val());

 if(vessel_length>iszero)
  {
    alert("Vessel length is not exceed  Length overall");
    $("#vessel_length_overall").val('');
    $("#vessel_length_overall").focus();
    //return false;
  }

});




   
$("#vessel_no_of_deck").change(function() 
{
  var no_deck=($("#vessel_no_of_deck").val());
  if((no_deck==0) || (no_deck=='.') )
  {
    alert("Invalid Number");

    $("#vessel_length").val('');
      $("#vessel_breadth").val('');
      $("#vessel_depth").val('');
      $("#vessel_upperdeck_length").val('');
      $("#vessel_upperdeck_breadth").val('');
      $("#vessel_upperdeck_depth").val('');
    
    $("#over_deck_id").hide();
    $("#over_deck_id_value").hide();
    $("#upper_deck_id").hide();
    $("#upper_deck_id_value").hide();

    $("#vessel_no_of_deck").val('');
    $("#vessel_no_of_deck").focus();
    return false;
  }

  if(no_deck==1)
  {
    $("#over_deck_id").show();
    $("#over_deck_id_value").show();
        $("#vessel_length").val('');
        $("#vessel_breadth").val('');
        $("#vessel_depth").val('');
        $("#vessel_upperdeck_length").val('');
        $("#vessel_upperdeck_breadth").val('');
        $("#vessel_upperdeck_depth").val('');
    $("#upper_deck_id").hide();
    $("#upper_deck_id_value").hide();
  }
 // else
 else if(no_deck==2)
  {
      $("#vessel_length").val('');
      $("#vessel_breadth").val('');
      $("#vessel_depth").val('');
      $("#vessel_upperdeck_length").val('');
      $("#vessel_upperdeck_breadth").val('');
      $("#vessel_upperdeck_depth").val('');
    $("#over_deck_id").show();
    $("#over_deck_id_value").show();
    $("#upper_deck_id").show();
    $("#upper_deck_id_value").show();
  }
  else
  {
    alert("Invalid Number");
      $("#vessel_length").val('');
      $("#vessel_breadth").val('');
      $("#vessel_depth").val('');
      $("#vessel_upperdeck_length").val('');
      $("#vessel_upperdeck_breadth").val('');
      $("#vessel_upperdeck_depth").val('');

    $("#over_deck_id").hide();
    $("#over_deck_id_value").hide();
    $("#upper_deck_id").hide();
    $("#upper_deck_id_value").hide();


    $("#vessel_no_of_deck").val('');  
    $("#vessel_no_of_deck").focus();
    return false;
  }
});
      
$("#month_id").change(function()
{
  var month_id=$("#month_id").val();
  var vessel_expected_completion=$("#vessel_expected_completion").val();

  var mm    =   new Date().getMonth();
  var newmm =   mm+1;
  var year  =   new Date().getFullYear();

  if((month_id<newmm && vessel_expected_completion<year) || (month_id<newmm && vessel_expected_completion==year))
  {
    alert("Invalid Month");
    $("#month_id").val('');
  }

});


      

      
      
$("#datepicker3").change(function()
{
  
var newdate=$("#datepicker3").val();
var GivenDate = newdate.split("-").reverse();
var CurrentDate = new Date();
GivenDate = new Date(GivenDate);

if(GivenDate < CurrentDate)
{
    alert('Invalid date');
    $("#datepicker3").val('');
}



});

  
           
  //-------------------Vessel Details---------------//  
  //----tab1 Click Start----//    


$("#tab1next").click(function() 
{
  /* var form = $("#form1");
  form.validate();
   if(form.valid())
  {*/
  if($("#form1").isValid())
 {


    var vessel_type_id    = $("#vessel_type_id").val();
    var vessel_subtype_id   = $("#vessel_subtype_id").val();
    var vessel_length     = $("#vessel_length").val();
    var hullmaterial_id   = $("#hullmaterial_id").val();
    var engine_placement_id = $("#engine_placement_id").val();
    


    $.ajax({
    url : "<?php echo site_url('Kiv_Ctrl/Survey/add_vessel_details')?>",
    type: "POST",
    //dataType: "JSON",
    data:$('#form1').serialize(),
    success: function(data)
    {
     // alert(data);

      if(data==1)
      {
        alert("No data found");
        location.reload();
        
      }

      else{
        $(".hdn_vessel_type").val(vessel_type_id);
        $(".hdn_vessel_subtype").val(vessel_subtype_id);
        $(".hdn_vessel_length").val(vessel_length);
        $(".hdn_engine_inboard_outboard").val(engine_placement_id);
        $(".hdn_hullmaterial_id").val(hullmaterial_id);

        alert("Vessel Details inserted Successfully");
        $('.nav-item a[href="#tab2"]').tab('show');
        $("#hulldetails").html(data).find(".select2").select2(); 
        
      }
     
          
    }

    

    });
  }

});  //----tab1 Click End----//  

$("#vessel_category_id").change(function()
{
  var vessel_category_id=$("#vessel_category_id").val();
  if(vessel_category_id != '')
  { 
    $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/vessel_subcategory/')?>"+vessel_category_id,
    success: function(data)
    {         
      $("#vessel_subcategory_id").html(data);
    }
    });
  }
});
        
        
        
        
  
  
$("#vessel_type_id").change(function()
{
  var vessel_type_id=$("#vessel_type_id").val();


  if(vessel_type_id==1)
  {
    $("#show_vessel_length_overall").show();
  }
  else
  {
    $("#vessel_length_overall").val('');
    $("#show_vessel_length_overall").hide();
  }

  if(vessel_type_id != '')
  { 
    $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/vessel_subtype/')?>"+vessel_type_id,
    success: function(data)
    {         
      $("#vessel_subtype_id").html(data);
    }
    });


    $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/vessel_type_id/')?>"+vessel_type_id,
    success: function(data)
    {         
      if(data==1)     
      {

        $("#show_vessel_length_overall").show();
      }
      else
      {
        $("#vessel_length_overall").val('');
        $("#show_vessel_length_overall").hide();
      }
    }
    });



  }
});


        
$("#vessel_subtype_id").change(function()
{
  
  var vessel_subtype_id=$("#vessel_subtype_id").val();

  $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/vessel_subtype_id/')?>"+vessel_subtype_id,
    success: function(data)
    {   
      if(data==1)     
      {

        $("#show_vessel_length_overall").show();
      }
      else
      {
        $("#vessel_length_overall").val('');
        $("#show_vessel_length_overall").hide();
      }
    }
    });




});
  
$("#check_tonnage").click(function()
{
  var vessel_length     = $("#vessel_length").val();
  var vessel_breadth    = $("#vessel_breadth").val();
  var vessel_depth    = $("#vessel_depth").val();
  var tonnage       =   (((vessel_length)*(vessel_breadth)*(vessel_depth))/2.83);
  var result        =   Math.round(tonnage);
  $("#Ton").show();
  $("#show_tonnage").html(result).append(' Ton');
});
        
       
$("#check_tonnage_upperdeck").click(function()
{
  var vessel_upperdeck_length=$("#vessel_upperdeck_length").val();
  var vessel_upperdeck_breadth=$("#vessel_upperdeck_breadth").val();
  var vessel_upperdeck_depth=$("#vessel_upperdeck_depth").val();
  var tonnage_upperdeck=(((vessel_upperdeck_length)*(vessel_upperdeck_breadth)*(vessel_upperdeck_depth))/2.83);
  var result= Math.round(tonnage_upperdeck);
  $("#Ton_upperdeck").show();
  $("#show_upperdeck_tonnage").html(result).append(' Ton');
});  
      
       
   
  
//--tab2 click start---// 
$("#tab2next").click(function()
{
  /*var form = $("#form2");
  form.validate();
    if(form.valid())
  {*/
    if($("#form2").isValid()){
    $.ajax({
    url : "<?php echo site_url('Kiv_Ctrl/Survey/add_hull_details')?>",
    type: "POST",
    //dataType: "JSON",
    data:$('#form2').serialize(),
    success: function(data)
    {

      alert("Hull Details inserted Successfully");
      $('.nav-item a[href="#tab3"]').tab('show');
      $("#engine1").html(data).find(".select2").select2();
    }
    });
  }
     
}); 

$("#hullmaterial_id").change(function()
{
  var id=$("#hullmaterial_id").val();
  if(id==2)
  {
    $('#hullplating_material_id').attr("disabled", 'true'); 
  }
  else
  {
    $('#hullplating_material_id').removeAttr("disabled");
  }
});
//---tab2 click End---//
      
      //------------------- Particulars of Engine ---------------//     
$("#chg_engine").click(function()
{
  var no_of_engineset=$("#no_of_engineset").val();
  if(no_of_engineset!='')
  { 
    $.ajax({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/no_of_engineset/')?>"+no_of_engineset,
    success: function(data)
    { 
      $("#show_engine_set").html(data).find(".select2").select2();
    }
    });
  }
});
         

       
//-----tab3 click start------//
$("#tab3next").click(function() 
{
  /*var form = $("#form3");
  form.validate();
  if(form.valid())
  {*/
  //var engine_placement_id=$("#engine_placement_id").val();

  if($("#form3").isValid())
  {
    $.ajax({
    url : "<?php echo site_url('Kiv_Ctrl/Survey/add_engine_details')?>",
    type: "POST",
    data:$('#form3').serialize(),
    //dataType: "JSON",
    success: function(data)
    {
      //$(".hdn_engine_inboard_outboard").val(engine_placement_id); 
      alert("Engine Details inserted Successfully");
       $('.nav-item a[href="#tab4"]').tab('show');
      $("#equipment1").html(data).find(".select2").select2(); 
    }
    });
  } 
}); //---tab3 click End---//
  
  
  
     
   
 
   //------------------- Particulars of Equipment ---------------// 
  //-----tab4 click start------//
 $("#tab4next").click(function()
 {
   

  
/*
    weight1 
    material_id1
    weight2

    material_id2
    weight3
    material_id3
    size4
    length4
    equipment_type_id4 
    
    size5
    length5
    equipment_type_id5
    
    size6
    number6
    material_id6
    number7
    power7
    size7 
    number8 
    number9 
    nav_equipment_id
    sound_equipment_id
    
*/
 /*var form = $("#form4");
  form.validate();
  if(form.valid())
  {*/
  if($("#form4").isValid())
  {
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/add_equipment_details')?>",
      type: "POST",
      data:$('#form4').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
        
            alert("Equipment Details inserted Successfully");
       $('.nav-item a[href="#tab5"]').tab('show');
        $("#fireappliance1").html(data).find(".select2").select2(); 
      }
    });   
  }

});  //---tab4 click End---//

 
  //------------------- Particulars of Fire Appliance ---------------// 
  //-----tab5 click start------//
  
$("#tab5next").click(function()
{
  /* 
  number1
  capacity1
  size1
  material_id1 
  diameter1
  number2
  number3
  nozzle_type
  fire_extinguisher_number[]
  */
 /* var form = $("#form5");
  form.validate();
  if(form.valid())
  {*/
  if($("#form5").isValid())
  { 
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/add_fire_appliance')?>",
      type: "POST",
      data:$('#form5').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
        alert("Fire Appliance Details inserted Successfully");
        $('.nav-item a[href="#tab6"]').tab('show');
        $("#otherequipment1").html(data).find(".select2").select2(); 
      }
    }); 
  }
});
  
//------tab5 click End---//
    
  
   
  
  //------------------- Particulars of Other Equipments ---------------// 
  //-----tab6 click start------//
  
$("#tab6next").click(function() 
{
    /* 
    list1 
    list2 
    list3 
    sewage_treatment
    solid_waste
    sound_pollution
    water_consumption 
    source_of_water
    */

 /* var form = $("#form6");
  form.validate();
  if(form.valid())
  { */
if($("#form6").isValid())
  {
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/add_other_equipments')?>",
      type: "POST",
      data:$('#form6').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
     
        alert("Other Equipments Details inserted Successfully");
        $('.nav-item a[href="#tab7"]').tab('show');
        $("#documents1").html(data).find(".select2").select2(); 
      }
    }); 
  }
});
  
//------tab6 click End---//
  


  //------------------- Particulars of Documents ---------------// 
  //-----tab7 click start------//
  
$("#tab7next").click(function(e) 
{

 /* var cntcount=$("#cntcount").val();
  var data = new FormData();
  var form_data = $('#form7').serializeArray();
  $.each(form_data, function (key, input)
  {
    data.append(input.name, input.value);
  });

  for(var j=1; j<=9; j++)
  {

    if($('input[name="myFile'+j+'"]').length)
    {

      var file_data = $('input[name="myFile'+j+'"]').prop('files')[0];  
     alert(file_data);
      if(file_data!='undefined')
      {
        data.append("myFile"+j, file_data);
      }

    }
       
  }

  if($("#form7").isValid()) 
  {   
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/add_vessel_documents')?>",
      type: "POST",
      data:$('#form7').serialize(),
      success: function(data)
      {
        
        alert("Vessel Documents Details inserted Successfully");

        $('.nav-item a[href="#tab8"]').tab('show');
          //$("#payment").html(data).find(".select2").select2();

      }
    }); 
  }    */ 


var data = new FormData(this.form);
if($("#form7").isValid()) 
  {   
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/add_vessel_documents')?>",
      type: "POST",
        data: data,
        processData: false,
        contentType: false,
      success: function(data)
      {
        
        alert("Vessel Documents Details inserted Successfully");

        $('.nav-item a[href="#tab8"]').tab('show');
          //$("#payment").html(data).find(".select2").select2();

      }
    }); 
  } 

});

 
     
     
     
        
        
//------tab7 click End------//
  
  
  
$("#btnsubmit").click(function()
{
 
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/not_payment_details')?>",
      type: "POST",
      data:$('#form8').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
        
        alert("Please pay fees later");
        window.location.href = "<?php echo site_url('Kiv_Ctrl/Survey/SurveyHome'); ?>";
      }
    }); 
  
});


  
//------tab8 click End---//
$("#pay_now").click(function(){

 //if($("#form8").isValid())
 // { 
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/showpayment')?>",
      type: "POST",
      data:$('#form8').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
       $("#portshow").show();
       $("#bankshow").show();
       
        $("#payment").show();
       $("#tab8next").show(); //proceed
        $("#btnsubmit").hide(); //submit

//alert(data);
        $("#payment").html(data).find(".select2").select2();
        
      }
    }); 
 // }

});

$("#pay_later").click(function()
{

 //if($("#form8").isValid())
 // { 
$("#portshow").hide();  
$("#bankshow").hide(); 
$("#payment").hide();
$("#tab8next").hide(); //proceed
$("#btnsubmit").show(); //submit
//}

});


$("#vessel_expected_completion").change(function()
{
var vessel_expected_completion=$("#vessel_expected_completion").val();
if(vessel_expected_completion>3000)
{
  alert("Invalid year");
  $("#vessel_expected_completion").val('');
  $("#vessel_expected_completion").focus();
}
});


/*$("#expiry_date").change(function()
{
  var yard_accreditation_expiry_date=$("#expiry_date").val(); 
  var today   = new Date();
  var dd      = today.getDate();
  var mm      = today.getMonth()+1; //January is 0!
  var yyyy    = today.getFullYear();

  if(dd<10)
  {
    dd='0'+dd;
  } 
  if(mm<10)
  {
    mm='0'+mm;
  } 

  var today1 = dd+'/'+mm+'/'+yyyy;
  if(yard_accreditation_expiry_date<today1)
  {
    alert("Invalid Date");
    $("#expiry_date").val('');
  }
});*/

    $("#tab2back").click(function() {
                $('.nav-item a[href="#tab1"]').tab('show');
    });
    
    $("#tab3back").click(function() {
                $('.nav-item a[href="#tab2"]').tab('show');
    });
    
    $("#tab4back").click(function() {
                $('.nav-item a[href="#tab3"]').tab('show');
    });
      
    $("#tab5back").click(function() {
                $('.nav-item a[href="#tab4"]').tab('show');
    });
    
    $("#tab6back").click(function() {
                $('.nav-item a[href="#tab5"]').tab('show');
    });
  
    $("#tab7back").click(function() {
                $('.nav-item a[href="#tab6"]').tab('show');
    });

     $("#tab8back").click(function() {
                $('.nav-item a[href="#tab7"]').tab('show');
    });
  


//---Jquery End--------------//
});

</script>
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

function IsDecimal(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58) || (unicode == 46 )) 
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
       if ( (unicode >64 && unicode<91) || (unicode > 47 && unicode < 58) || (unicode > 96 && unicode < 123) && (unicode==32) && (unicode == 45))  
        {
               window.alert("not Allowed");
                return false; 
        }
        else 
        {
             return true;   
        }
        }

function checklength(id)
{
  var strvalue=document.getElementById(id).value;  
  //alert(strvalue);
    var len=strvalue.length;
  if(len<4)
  {
    alert("Minimum 4 character");
   document.getElementById(id).value='';
    document.getElementById(id).focus();
    return false;
  }
}

function IsZero(id)
{
  var strvalue=document.getElementById(id).value; 
  if((strvalue==0) || (strvalue=='.'))
  {
    alert("Invalid Number");
   document.getElementById(id).value='';
    document.getElementById(id).focus();
    return false;
  }
}


function alphaNumeric(e) 
        {
      var k;
     document.all ? k = e.keyCode : k = e.which;
     return ((k > 64 && k < 91) || (k > 96 && k < 123) || (k > 47 && k < 58) || k == 45 || k==32);

    } 
</script>

<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <!--  <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ">  <!-- Container Class overridden for edge free design -->
  <div class="row no-gutters">
  <div class="col-12"> 
  	<div class="row no-gutters">
  		<div class="col-2 mt-1 ml-5">
  			 <button type="button" class="btn btn-primary kivbutton btn-block"> Form 1</button> 
  		</div> <!-- end of col-2 -->
      <div class="col mt-2 text-primary">
        See Rule 5 (1) - Form for expressing the intention to build a new vessel
      </div>
  	</div> <!-- inner row -->
  </div> <!-- end of col-12 add-button header -->

  <div class="col-12 mt-2 ml-2 newfont">  
  	<?php //include ('tab.php'); ?>
    <input type="hidden" name="hdn_stage_count" id="hdn_stage_count" value="<?php echo $stage_count; ?>">
<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">




<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="vesseltab" data-toggle="tab" href="#tab1" role="tab" aria-controls="VesselDetails" aria-selected="true">Vessel Details</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="hulltab" data-toggle="tab" href="#tab2" role="tab" aria-controls="Hull" aria-selected="false">Hull Details</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" id="enginetab" data-toggle="tab" href="#tab3" role="tab" aria-controls="Engine" aria-selected="false">Engine Details</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" id="equipmenttab" data-toggle="tab" href="#tab4" role="tab" aria-controls="Equipment" aria-selected="false">Particulars of Equipment</a>
  </li>

   <li class="nav-item">
    <a class="nav-link" id="fireappliancetab" data-toggle="tab" href="#tab5" role="tab" aria-controls="FireAppliance" aria-selected="false">Particulars of Fire Appliance</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" id="otherequipmentstab" data-toggle="tab" href="#tab6" role="tab" aria-controls="OtherEquipments" aria-selected="false">Other Equipments</a>
  </li>

   <li class="nav-item">
    <a class="nav-link" id="documenttab" data-toggle="tab" href="#tab7" role="tab" aria-controls="Document" aria-selected="false">Document</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" id="paymenttab" data-toggle="tab" href="#tab8" role="tab" aria-controls="Payment" aria-selected="false">Payment</a>
  </li>

</ul>

<div class="tab-content " id="myTabContent">

<!-- ______________________ Vessel Details  Start_________________________ -->

<div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="vesseltab">

<!-- start of content in tab pane -->
<!-- <form name="form1" id="form1" method="post" class="form1" >  -->
<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Survey/add_vessel_details", $attributes);
?>
<div class="row no-gutters mx-3 mb-3 mt-2">
<div class="col-12">
<div class="row no-gutters oddtab">
<div class="col-3 border-bottom ves_div1">
<p class="mt-3 mb-3"> Type of vessel </p>
</div><!-- end of col-2 ves_div1 -->
<div class="col-3 border-bottom  ves_div1">
      <div class="form-group mt-2 mb-2">
          <select class="custom-select select2" name="vessel_type_id" id="vessel_type_id" title="Select Vessel Type" data-validation="required">
         <option value="">Select</option>
    <?php foreach ($vesseltype as $res_vesseltype)
    {
    ?>
    <option value="<?php echo $res_vesseltype['vesseltype_sl']; ?>"> <?php echo $res_vesseltype['vesseltype_name'];?>  </option>
    <?php
    } 
    ?>
          </select> 
      </div> <!-- end of form group -->
    </div> <!-- end of col-2 ves_div1 -->
    <div class="col-3 border-bottom border-left ves_div1">
      <p class="mt-3 mb-3 "> Subtype of vessel </p>
    </div>
    <div class="col-3 border-bottom ves_div1 ">
       <div class="form-group mt-2 mb-2">
              <select class="custom-select select2" name="vessel_subtype_id" id="vessel_subtype_id" title="Select Vessel Sub Type" > </select>
   </div> <!-- end of form group -->
    </div>
   </div> <!-- end of oddtab row in tab-pane -->
   <div class="row no-gutters eventab">
    <div class="col-3 border-bottom">
      <p class="mt-3 mb-3">Material of hull</p>
    </div> <!-- end of col-2 -->
    <div class="col-3 border-bottom">
      <div class="form-group mt-2 mb-2">
      <select class="custom-select select2" name="hullmaterial_id" id="hullmaterial_id" title="Enter Material of hull" data-validation="required">
          <option value="">Select</option>
           <option value="9999">All</option>
    <?php foreach ($hullmaterial as $res_hullmaterial)
    {
    ?>
    <option value="<?php echo $res_hullmaterial['hullmaterial_sl']; ?>"> <?php echo $res_hullmaterial['hullmaterial_name'];?>  </option>
    <?php
    } 
    ?>
            </select>
      </div> <!-- end of form group -->
    </div> <!-- end of col -->
    <div class="col-3 border-bottom border-left ">
      <p class="mt-2 mb-3">Whether Engine inboard/outboard</p>
    </div>
    <div class="col-3 border-bottom ">
      <div class="form-group mt-2 mb-2">
                  <select class="custom-select select2" name="engine_placement_id" id="engine_placement_id" title="Select Engine inboard/outboard" data-validation="required">
                <option value="">Select</option>
                <option value="9999">All</option>
                    <?php
                    foreach ($inboard_outboard as $res_inboard_outboard)
                   {
                        ?>
                     <option value="<?php echo $res_inboard_outboard['inboard_outboard_sl']; ?>" <?php //if($res_inboard_outboard['inboard_outboard_sl']==$sltid1) { echo "selected"; }?>> <?php echo $res_inboard_outboard['inboard_outboard_name']; ?>  </option>
                    <?php
                   }
                    ?>

                  </select>
   </div> <!-- end of form group -->
    </div><!-- end of col -->
   </div> <!-- end of eventab -->
   <div class="row no-gutters oddtab">
    <div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3">Vessel name</p>
    </div>
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
                <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" title="Enter Vessel Name" data-validation="required" required onkeypress="return alphaNumeric(event);" onchange="return checklength(this.id)" />
      </div> <!-- end of form group -->
    </div>
    <div class="col-3 border-top border-bottom border-left ves_div1">
      <p class="mt-3 mb-3"> Proposed month and year of completion </p>
    </div>
    <div class="col-2 border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
          <select class="form-control select2" name="month_id" id="month_id" title="Select Month" data-validation="required">
            <option value="">Select</option>
    <?php foreach ($month as $res_month)
    {
    ?>
    <option value="<?php echo $res_month['month_sl']; ?>"> <?php echo $res_month['month_name'];?>  </option>
    <?php
    } 
    ?>
              </select>
      </div> <!-- end of form group -->
    </div>
    <div class="col-1 border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
          <input type="text" name="vessel_expected_completion" value="2019" id="vessel_expected_completion"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Proposed Year of Completion"  data-validation="number"/>
      </div> <!-- end of form group -->
    </div>
   </div> <!-- end of oddtab -->

    <div class="row no-gutters eventab">
    <div class="col-3 border-bottom ves_div2">
      <p class="mt-3 mb-3">Category of vessel</p>
    </div> <!-- end of col-2 -->
    <div class="col-3 border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
      <select class="form-control select2" name="vessel_category_id" id="vessel_category_id" title="Select Vessel Category" data-validation="required">
           <option value="">Select</option>
    <?php foreach ($vesselcategory as $res_vesselcategory)
    {
    ?>
    <option value="<?php echo $res_vesselcategory['vesselcategory_sl']; ?>"> <?php echo $res_vesselcategory['vesselcategory_name'];?> </option>
    <?php
    } 
    ?> 
            </select>
      </div> <!-- end of form group -->
    </div> <!-- end of col -->
    <div class="col-3 border-bottom border-left ves_div2">
      <p class="mt-3 mb-3">Sub category of vessel</p>
    </div>
    <div class="col-3 border-bottom ves_div2">
      <div class="form-group mt-2 mb-2">
                  <select class="form-control select2" name="vessel_subcategory_id" id="vessel_subcategory_id" title="Select Vessel SubCategory">
        </select>
   </div> <!-- end of form group -->
    </div>
   </div> <!-- end of eventab -->
   <div class="row no-gutters oddtab">
    <div class="col-3 border-top border-bottom ves_div1">
      <p class="mt-3 mb-3"> Length overall </p>
    </div>
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
        <div class="input-group">
            <input type="text" name="vessel_length_overall" value="" id="vessel_length_overall"  class="form-control"  maxlength="3" autocomplete="off" title="Length Over All" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/>
              <div class="input-group-append">
                <div class="input-group-text">m</div> 
              </div> <!-- end of input-group-append -->
          </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div>
    <div class="col-3 border-top border-bottom border-left ves_div1">
      <p class="mt-3 mb-3">  Number of deck </p>
    </div>
    <div class="col border-top border-bottom ves_div1">
      <div class="form-group mt-2 mb-2">
          <input type="text" name="vessel_no_of_deck" value="" id="vessel_no_of_deck"  class="form-control"  maxlength="1" autocomplete="off" title="Enter Number of Deck"  data-validation="required" onkeypress="return IsDecimal(event);"/>
      </div> <!-- end of form group -->
    </div>
   </div> <!-- end of oddtab -->
   <div class="row no-gutters eventab divheight" id="over_deck_id">
    <div class="col-3 d-flex justify-content-center align align-items-center"> Length over the deck
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Breadth
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Depth
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Tonnage
    </div> <!-- end of col-3 flex -->
   </div> <!-- end of eventab -->
   <div class="row no-gutters oddtab" id="over_deck_id_value">

    <div class="col-3 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
      <div class="input-group">
        <input type="text" class="form-control" name="vessel_length" value="" id="vessel_length" maxlength="5" autocomplete="off" title="Enter Vessel Length" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);">
          <div class="input-group-append">
            <div class="input-group-text">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->
    <div class="col-3 d-flex justify-content-center" > 
      <div class="form-group mt-2 mb-2">
      <div class="input-group">
        <input type="text" name="vessel_breadth" value="" id="vessel_breadth"  class="form-control"  maxlength="5" autocomplete="off" title="Enter Vessel Breadth" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/>
          <div class="input-group-append ">
            <div class="input-group-text ">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->

    <div class="col-3 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
      <div class="input-group">
        <input type="text" name="vessel_depth" value="" id="vessel_depth"  class="form-control"  maxlength="5" autocomplete="off" title="Enter Vessel Depth" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/>
          <div class="input-group-append">
            <div class="input-group-text">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->
    <div class="col-2 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
        <button type="button" class="btn bg-secondary text-white btn-flat" id="check_tonnage"> Check </button>
      </div>
    </div>
    <div class="col d-flex justify-content-center" id="Ton"> 
      <font color="#00f" id="show_tonnage">  </font>  
    </div> <!-- end of col-3 d-flex -->
   </div> <!-- end of oddtab -->


   <div class="row no-gutters eventab divheight" id="upper_deck_id">
    <div class="col-3 d-flex justify-content-center align align-items-center"> Length upper the deck
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Breadth
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Depth
    </div> <!-- end of col-3 flex -->
    <div class="col-3 d-flex justify-content-center align-items-center"> Tonnage
    </div> <!-- end of col-3 flex -->
   </div> <!-- end of eventab -->
   <div class="row no-gutters oddtab" id="upper_deck_id_value">
    <div class="col-3 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
      <div class="input-group">
        <input type="text" class="form-control" name="vessel_upperdeck_length" value="" id="vessel_upperdeck_length" maxlength="4" autocomplete="off" title="Enter Vessel Length Upper the Deck" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/>
          <div class="input-group-append">
            <div class="input-group-text">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->
    <div class="col-3 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">

      <div class="input-group">
        <input type="text" name="vessel_upperdeck_breadth" value="" id="vessel_upperdeck_breadth"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Vessel Breadth Upper the Deck" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/>
          <div class="input-group-append">
            <div class="input-group-text">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->

      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->
    <div class="col-3 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
      <div class="input-group">
        <input type="text" name="vessel_upperdeck_depth" value="" id="vessel_upperdeck_depth"  class="form-control"  maxlength="4" autocomplete="off"  title="Enter Vessel Depth Upper the Deck" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/>
          <div class="input-group-append">
            <div class="input-group-text">m</div> 
          </div> <!-- end of input-group-append -->
      </div> <!-- end of input-group -->
      </div> <!-- end of form group -->
    </div><!-- end of col-3 d-flex -->
    <div class="col-2 d-flex justify-content-center"> 
      <div class="form-group mt-2 mb-2">
        <button type="button" class="btn bg-secondary text-white btn-flat" id="check_tonnage_upperdeck"> Check </button>
      </div>
    </div>
    <div class="col d-flex justify-content-center" id="Ton_upperdeck"> 
      <font color="#00f" id="show_upperdeck_tonnage">  </font>  
    </div> <!-- end of col-3 d-flex -->
   </div> <!-- end of oddtab -->
   <div class="row no-gutters eventab d-flex justify-content-end">
    <div class="col-2 py-2"> 
     <button type="button" class="btn btn-primary btn-flat  btn-point btn-md" name="tab1next" id="tab1next" ><i class="far fa-save"></i>&nbsp;&nbsp;Save &amp; Proceed</button>
    </div> <!-- end of col-2 save col -->
   </div> <!-- end of eventab -->
    </div> <!-- end of col-12 inside row in the tab pane -->
    </div> <!-- end of main inside row in the tab pane -->
<!-- </form> -->  <?php echo form_close(); ?>
  </div><!-- end of tab-pane 1 -->

<!-- ______________________ Vessel Details  End_________________________ -->



<!-- ______________________ Particulars of Hull Start_________________________ -->

<div class="tab-pane fade <?php echo $active2; ?>" id="tab2" role="tabpanel" aria-labelledby="hulltab">
<!-- <form name="form2" id="form2" method="post" > -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form2", "name" => "form2");
echo form_open("Kiv_Ctrl/Survey/add_hull_details", $attributes);
?>

<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vessel_type_id; ?>" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vessel_subtype_id; ?>" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $vessel_length1; ?>" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_placement_id; ?>" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hullmaterial_id; ?>" > 

<div class="row no-gutters mx-0 mt-2">
<div class="col-12"  id="hulldetails"> </div> <!-- End of content col -->
</div><!-- End of content row -->
<table id="show_headplacement" class="table table-bordered table-striped"></table>


<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">
</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
 <button type="button" class="btn btn-primary btn-flat  btn-point btn-md" name="tab2next" id="tab2next" ><i class="far fa-save"></i>&nbsp;&nbsp;Save &amp; Proceed</button>
</div>
</div> <!-- End of button row -->
<!-- </form> --> <?php echo form_close(); ?>
<!-- end of content in tab pane -->
</div><!-- end of tab-pane 2 -->
<!-- ______________________ Particulars of Hull End_________________________ -->



<!-- ______________________ Engine Details Start_________________________ -->

<div class="tab-pane fade <?php echo $active3;?>" id="tab3" role="tabpanel" aria-labelledby="enginetab">
<!-- start of content in tab pane -->
<!-- <form name="form3" id="form3" method="post" > -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form3", "name" => "form3", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Survey/add_engine_details", $attributes);
?>
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vessel_type_id; ?>" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vessel_subtype_id; ?>" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $vessel_length1; ?>" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_placement_id; ?>" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hullmaterial_id; ?>" > 


<div class="row no-gutters mx-0 mt-2 eventab">
<div class="col-6">Number of engine sets </div> 
<div class="col-3"> 
  <div class="form-group mt-2 mb-2">
  <div class="input-group" id="engine1"> </div>  
  <div class="input-group-append">
  <button type="button" class="btn btn-primary btn-flat" id="chg_engine" name="chg_engine"> Go </button>
  </div><!-- end of input-group-append -->
 
  </div> 
  </div>
  </div>

<div class="row no-gutters mx-0 mt-2">
<div class="col-12"  id="show_engine_set"> </div> <!-- End of content col -->
</div><!-- End of content row -->

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">
</div> 
<div class="col-1 d-flex justify-content-end">
 <button type="button" class="btn btn-primary btn-flat  btn-point btn-md" name="tab3next" id="tab3next" ><i class="far fa-save"></i>&nbsp;&nbsp;Save &amp; Proceed</button>
</div>
</div> 

<!-- </form> --><?php echo form_close(); ?>

<!-- end of content in tab pane -->
</div><!-- end of tab-pane 3 -->

<!-- ______________________ Engine Details End_________________________ -->

<!-- ______________________ Equipment Details Start_________________________ -->

<div class="tab-pane fade <?php echo $active4;?>" id="tab4" role="tabpanel" aria-labelledby="equipmenttab">
<!-- start of content in tab pane -->
<!-- <form name="form4" id="form4" method="post" > -->
    <?php
$attributes = array("class" => "form-horizontal", "id" => "form4", "name" => "form4");
echo form_open("Kiv_Ctrl/Survey/add_equipment_details", $attributes);
?>
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vessel_type_id; ?>" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vessel_subtype_id; ?>" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $vessel_length1; ?>" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_placement_id; ?>" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hullmaterial_id; ?>" > 


<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="equipment1">
</div>  <!-- end of col-12 -->
</div> <!-- end of row -->

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div> <!-- end of col-10 -->
<div class="col-1 d-flex justify-content-end">
<!-- <button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="tab4back" id="tab4back"><i class="fas fa-step-backward"></i>&nbsp;Back</button>  --> 
</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
 <button type="button" class="btn btn-primary btn-flat  btn-point btn-md" name="tab4next" id="tab4next" ><i class="far fa-save"></i>&nbsp;&nbsp;Save &amp; Proceed</button>
</div> <!-- end of button col -->
</div> <!-- end of row -->
<!-- </form> --><?php echo form_close(); ?>
</div> <!-- end of tab-pane -->
<!-- ______________________ Equipment Details End_________________________ -->


<!-- ______________________ Fire Appliance Details Start_________________________ -->

<div class="tab-pane fade <?php echo $active5;?>" id="tab5" role="tabpanel" aria-labelledby="fireappliancetab">
<!-- start of content in tab pane -->
<!-- <form name="form5" id="form5" method="post" > -->
    <?php
$attributes = array("class" => "form-horizontal", "id" => "form5", "name" => "form5", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Survey/add_fire_appliance", $attributes);
?>
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vessel_type_id; ?>" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vessel_subtype_id; ?>" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $vessel_length1; ?>" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_placement_id; ?>" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hullmaterial_id; ?>" > 



<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="fireappliance1">
</div>  <!-- end of col-12 -->
</div> <!-- end of row -->

<div class="row mx-0 mb-3 no-gutters oddtab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">
<!-- <button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="tab5back" id="tab5back"><i class="fas fa-step-backward"></i>&nbsp;Back</button>  --> 
</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
 <button type="button" class="btn btn-primary btn-flat  btn-point btn-md" name="tab5next" id="tab5next" ><i class="far fa-save"></i>&nbsp;&nbsp;Save &amp; Proceed</button>
</div>
</div>

<!-- </form> --><?php echo form_close(); ?>
</div>
<!-- ______________________ Fire Appliance Details End_________________________ -->

              
<!--________________________ Other Equipment Start_____________________________ -->

<div class="tab-pane fade <?php echo $active6;?>" id="tab6" role="tabpanel" aria-labelledby="otherequipmentstab">
<!-- <form name="form6" id="form6" method="post">  --> 
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form6", "name" => "form6", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Survey/add_other_equipments", $attributes);
?>
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vessel_type_id; ?>" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vessel_subtype_id; ?>" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $vessel_length1; ?>" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_placement_id; ?>" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hullmaterial_id; ?>" > 



<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="otherequipment1">
</div>  <!-- end of col-12 -->
</div> <!-- end of row -->

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">
<!-- <button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="tab6back" id="tab6back"><i class="fas fa-step-backward"></i>&nbsp;Back</button>   -->
</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
 <button type="button" class="btn btn-primary btn-flat  btn-point btn-md" name="tab6next" id="tab6next" ><i class="far fa-save"></i>&nbsp;&nbsp;Save &amp; Proceed</button>
</div>
</div>
<!-- </form> -->
</div>
<!--________________________ Other Equipment End_____________________________ -->



<!--________________________ Document Start_____________________________ -->

<div class="tab-pane fade <?php echo $active7;?>" id="tab7" role="tabpanel" aria-labelledby="documenttab">

<!-- <form name="form7" id="form7" method="post" action="" enctype="multipart/form-data"> -->  
   <?php
$attributes = array("class" => "form-horizontal", "id" => "form7", "name" => "form7", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Survey/add_vessel_documents", $attributes);
?>

<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vessel_type_id; ?>" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vessel_subtype_id; ?>" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $vessel_length1; ?>" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_placement_id; ?>" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hullmaterial_id; ?>" > 



<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="documents1">
</div>  <!-- end of col-12 -->
</div> <!-- end of row -->

<!-- <div class="row no-gutters">
    <div class="col-3 border-top border-bottom ">
    <p class="mt-3 mb-3"> Preferred Inspection Date </p>
    </div>

    <div class="col-3 border-top border-bottom ">
    <div class="input-group">
    <div class="input-group-prepend">
    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
    </div>
   

     <input type="text" class="form-control dob" id="datepicker3" name="vessel_pref_inspection_date" title="Enter Preferred Inspection Date" data-validation="required" maxlength="10">

    </div>
    </div>

</div> -->

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">
<!-- <button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="tab7back" id="tab7back"><i class="fas fa-step-backward"></i>&nbsp;Back</button>  --> 
</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
 <button type="button" class="btn btn-primary btn-flat  btn-point btn-md" name="tab7next" id="tab7next" ><i class="far fa-save"></i>&nbsp;&nbsp;Save &amp; Proceed</button>
</div>
</div>

<!-- </form> --> <?php echo form_close(); ?> 

</div>
<!--________________________ Document End_____________________________ -->


<!--________________________ Payment Start_____________________________ -->

<div class="tab-pane fade <?php echo $active8;?>" id="tab8" role="tabpanel" aria-labelledby="paymenttab">
<!-- <form name="form8" id="form8" method="post"  action="<?php //echo $site_url.'/Kiv_Ctrl/Survey/add_payment_details/'?>"> -->  
   <?php
$attributes = array("class" => "form-horizontal", "id" => "form8", "name" => "form8", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Survey/add_payment_details", $attributes);
?>
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vessel_type_id; ?>" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vessel_subtype_id; ?>" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $vessel_length1; ?>" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_placement_id; ?>" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hullmaterial_id; ?>" > 
<input type="hidden" class="vessel_id" name="vessel_id" value="<?php echo $vessel_id; ?>" > 

<!-- <div class="row no-gutters mx-0 mt-2" id="payment">
</div> -->

<!--____________________________ -->



<div class="row no-gutters mx-0 mt-5 mb-5">
<div class="col-6 d-flex justify-content-end pr-5">
 <button type="button" class="btn btn-success btn-flat btn-point btn-lg" name="pay_now" id="pay_now"><i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;&nbsp;Pay Now</button> 

</div>
<div class="col-6 d-flex justify-content-start pl-5">
<button type="button" class="btn btn-secondary  btn-flat  btn-point btn-lg" name="pay_later" id="pay_later" ><i class="fas fa-business-time"></i>&nbsp;&nbsp;&nbsp;Pay Later</button>
</div>
</div>

 <div class="row no-gutters mx-0 mt-2" id="portshow">
<div class="col-md-12 col-lg-12">
<div class="col-md-6 col-lg-6">Port of Registry</div>
<div class="col-md-6 col-lg-6"> 
   <select class="form-control select2 " name="portofregistry_sl" id="portofregistry_sl"  title="" data-validation="required">
  <option value="">Select</option>
  <?php   foreach ($portofregistry as $res_portofregistry)
  {
  ?>
  <option value="<?php echo $res_portofregistry['int_portoffice_id']; ?>"><?php echo $res_portofregistry['vchr_portoffice_name'];?>  </option>
  <?php    }    ?>
  </select>
</div>
</div>
</div>

 <div class="row no-gutters mx-0 mt-2" id="bankshow">
<div class="col-md-12 col-lg-12">
<div class="col-md-6 col-lg-6">Select Bank</div>
<div class="col-md-6 col-lg-6"> 
   <select class="form-control select2 " name="bank_sl" id="bank_sl"  title="" data-validation="required">
  <option value="">Select</option> 
  <?php   foreach ($bank as $res_bank)
  {
  ?>
  <option value="<?php echo $res_bank['bank_sl'];?>" ><?php echo $res_bank['bank_name'];?>  </option>
  <?php    }    ?>
  </select>
</div>
</div>
</div>

<div class="row no-gutters mx-0 mt-2" id="payment">
</div>


 <div class="row mx-0 mb-3 no-gutters eventab" id="submitbtn">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">
</div> 
<div class="col-1 d-flex justify-content-end">
 <button type="submit" class="btn btn-primary btn-flat  btn-point btn-md" name="tab8next" id="tab8next" ><i class="far fa-save"></i>&nbsp;&nbsp;Save &amp; Proceed</button>
<button type="button" class="btn btn-success btn-flat  btn-point btn-md" name="btnsubmit" id="btnsubmit" ><i class="far fa-save"></i>&nbsp;Submit</button>
</div>
</div> 

<!-- </form> --><?php echo form_close(); ?>

</div>
<!--________________________ Payment End_____________________________ -->



</div> <!-- end of tab -content -->
</div> <!-- end of col-12 main col -->
</div> <!-- end of main row -->
</div> <!-- end of container div -->

 <script type="text/javascript">
  $(document).ready(function() {
          $('.select2').select2({ width: 'resolve' });

      });
      </script>