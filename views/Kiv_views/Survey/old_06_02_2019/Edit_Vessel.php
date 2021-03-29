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

<script language="javascript">

$(document).ready(function()
{


if($("#vessel_length_overall").val()==0)
{
  $("#show_vessel_length_overall").hide();
}
else
{
  $("#show_vessel_length_overall").show();
}

if($("#hdn_tonnage").val()==0)
{
  $("#Ton").hide();
}
else
{
   $("#Ton").show();
}
      


$("#vessel_category_id").change(function()
{
  var vessel_category_id=$("#vessel_category_id").val();
  if(vessel_category_id != '')
  { 
    $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('/Survey/vessel_subcategory/')?>"+vessel_category_id,
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
  if(vessel_type_id=='1')
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
      url:"<?php echo site_url('/Survey/vessel_subtype/')?>"+vessel_type_id,
      success: function(data)
      {         
        $("#vessel_subtype_id").html(data);
      }
    });
  }
});

        
$("#vessel_subtype_id").change(function()
{
  var vessel_type_id=$("#vessel_type_id").val();
  var vessel_subtype_id=$("#vessel_subtype_id").val();
  if(vessel_type_id==7 && vessel_subtype_id==3)
  {
    $("#show_vessel_length_overall").show();
  }
  else
  {
    $("#vessel_length_overall").val('');
    $("#show_vessel_length_overall").hide();
  }
});
  
$("#check_tonnage").click(function()
{
  var vessel_length=$("#vessel_length").val();
  var vessel_breadth=$("#vessel_breadth").val();
  var vessel_depth=$("#vessel_depth").val();
  var tonnage=(((vessel_length)*(vessel_breadth)*(vessel_depth))/2.83);
  var result= Math.round(tonnage);
  $("#Ton").show();
  $("#show_tonnage").html(result).append(' Ton');
});
//-------------------Particulars of Hull---------------//    
     
$("input[type='radio'][name='freeboard_status_id']").click(function() 
{
  var hdn_bulkheads =$("#hdn_bulkheads").val();
  var chkvalue=$("input[type='radio'][name='freeboard_status_id']:checked").val();
  if ((chkvalue=='0') && hdn_bulkheads!='0')
  {
  /*
  var num=$("#num_bulk").val();
  for(i=1; i<=num;$i++){
  $('#bulk_head_placement'+i).val($(this).data('val')).trigger('change');
  $("#bulk_head_thickness"+i).val('');
  }
  */
    $("#bulk_heads_show").hide();  
    $("#num_bulk").hide();
    $("#show_headplacement").hide();
  }
  if ((chkvalue=='1') && hdn_bulkheads!='0')
  {
    $("#bulk_heads_show").show();  
    $("#num_bulk").show();
    $("#show_headplacement").show();
  }
  /*
  if ((chkvalue=='0') && hdn_bulkheads=='0')
  {
  $("#num_bulk").show();
  }
  if ((chkvalue=='1') && hdn_bulkheads=='0')
  {
  }
  */
  //else {
  // $("#bulk_heads").val('');
  //$("#show_headplacement").show();
  //$("#bulk_heads_show").show();  
  // $("#num_bulk").show();
  //}
});  
   
   
   
$("#bulkhead_add").click(function()
{
  var cnt= parseInt($("#bulk_heads").val());
  var newcnt=cnt+1;
  $("#bulk_heads").val(newcnt);
  //var tbrow='<tr><td  colspan="4" id="show_bk">'+bulkhead_placement();+'</td></tr>';
  var tbrow='<tr><td>Bulk head placement</td><td >'+bulkhead_placement()+'</td><td>Bulk head thickness</td><td><div class="div100"> <div class="input-group"><input type="text" name="bulk_head_thickness[]" value="" id="bulk_head_thickness"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">mm</span> </div> </div></td><td><input type="hidden" value="2" id="delete_status" name="delete_status[]"><button type="button" class="btn btn-warning pull-right rm_tr" name="remove" id="remove">Remove</button></td></tr>';
  $("#show_headplacement").append(tbrow).find(".div200").select2();

  $(".rm_tr").click(function()
  {
  var cnt1= parseInt($("#bulk_heads").val());
  var newcnt1=cnt1-1;
  //alert(newcnt1);
  $("#bulk_heads").val(newcnt1);
  $(this).parent().parent().remove();
  });
});
  

$("#add_engine_set").click(function()
{
  var no_of_engineset=parseInt($("#no_of_engineset").val());
  var new_no_of_engineset=no_of_engineset+1;
  $("#no_of_engineset").val(new_no_of_engineset);
  var cnt3= parseInt($("#engineset_no").val());
  var newcnt3=cnt3+1;
  $("#engineset_no").val(newcnt3);  

  var tbadd='<div id="sh_engine" ><div ><input type="text" value="2" id="delete_status" name="delete_status_engine[]"><button type="button" class="btn btn-warning pull-right rm_tr_engine" name="remove" id="remove">Remove</button></div><table id="engine_set_new" class="table table-bordered table-striped"><tr><td colspan="5" align="right"></td></tr><tr> <td colspan="5">Engine Set</td> </tr><tr> <td>Engine Number </td><td>&nbsp;</td><td><div class="div100"> <div class="form-group"><input type="text" name="engine_number[]" value="" id="engine_number"  class="form-control"  maxlength="30" autocomplete="off" /></div> </div> </td><td>&nbsp; </td></tr><tr><td colspan="2"> Whether Engine inboard/outboard</td><td><div class="form-group">'+inboard_outboard()+'</div></td><td> BHP</td><td> <div class="div100"> <div class="form-group"><input type="text" name="bhp[]" value="" id="bhp"  class="form-control"  maxlength="30" autocomplete="off" onchange="get_kw()"/></div> </div>&nbsp;<span id="show_bhp_kw"><input type="text" name="bhp_kw[]" id="bhp_kw" value="" readonly=""></span>KW</td></tr><tr><td colspan="2"> Name of manufacturer</td><td> <div class="div350"> <div class="form-group"><input type="text" name="manufacturer_name[]" value="" id="manufacturer_name"  class="form-control"  maxlength="30" autocomplete="off" /></div> </div></td><td> Brand of manufacturer</td><td> <div class="div350"> <div class="form-group"><input type="text" name="manufacturer_brand[]" value="" id="manufacturer_brand"  class="form-control"  maxlength="30" autocomplete="off" /></div> </div></td></tr><tr><td colspan="2"> Model number of engine</td><td><div class="form-group">'+model_number()+'</div></td><td> Type of engine</td><td><div class="form-group">'+engine_type()+'</div></td></tr><tr><td colspan="2"> Diameter of propulsion shaft</td><td> <div class="div100"> <div class="input-group"><input type="text" name="propulsion_diameter[]" value="" id="propulsion_diameter"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">cm</span></div> </div></td><td> Material of propulsion shaft</td><td><div class="form-group">'+propulsionshaft_material()+'</div></td></tr><tr><td colspan="2"> Type of gear</td><td><div class="form-group">'+gear_type()+'</div></td><td> Number of gear</td><td> <div class="div100"> <div class="form-group"><input type="text" name="gear_number[]" value="" id="gear_number"  class="form-control"  maxlength="30" autocomplete="off" /></div> </div></td></tr></table></div>';

  $("#show_engine_set").append(tbadd).find(".div200").select2();

  $(".rm_tr_engine").click(function()
  {
    $("#sh_engine").remove();
    var cnt1      = parseInt($("#no_of_engineset").val());
    var newcnt1   = cnt1-1;
    $("#no_of_engineset").val(newcnt1);
    var cnt2      = parseInt($("#engineset_no").val());
    var newcnt2   = cnt2-1;
    $("#engineset_no").val(newcnt2); 
  });
});


 //--------------------Editing Started--------------------------------//
 
//-------------------Vessel Details---------------//  
//----tab1 Click Start----//  

$("#tab1next").click(function() 
{
var vessel_sl                   =$("#vessel_sl").val();
var vessel_name                 =$("#vessel_name").val();
var vessel_expected_completion  =$("#vessel_expected_completion").val();
var vessel_category_id          =$("#vessel_category_id").val();
var vessel_subcategory_id       =$("#vessel_subcategory_id").val();
var vessel_type_id              =$("#vessel_type_id").val();
var vessel_subtype_id           =$("#vessel_subtype_id").val();
var vessel_length_overall       =$("#vessel_length_overall").val(); 
var vessel_length               =$("#vessel_length").val();
var vessel_breadth              =$("#vessel_breadth").val();
var vessel_depth                =$("#vessel_depth").val();
 if(vessel_name=="")
 {
     alert("Enter Vessel Name");
     $("#vessel_name").focus();
     return false;
 }
   $.ajax({
          url : "<?php echo site_url('Survey/Edit_vessel_details/')?>",
          type: "POST",
         /* data:{
              vessel_sl:vessel_sl,
              vessel_name:vessel_name,
              vessel_expected_completion:vessel_expected_completion,
              vessel_category_id:vessel_category_id,
              vessel_subcategory_id:vessel_subcategory_id,
              vessel_type_id:vessel_type_id,
              vessel_subtype_id:vessel_subtype_id,
              vessel_length_overall:vessel_length_overall,
              vessel_length:vessel_length,
              vessel_breadth:vessel_breadth,
              vessel_depth:vessel_depth
	},*/
   data:$('#form1').serialize(),
          
          success: function(data)
          {
            //alert(data);
	          alert("Vessel Details Updated Successfully");
            $('.nav-tabs a[href="#tab_2"]').tab('show');
          }
	
});
   
});  
//----tab1 Click End----//  




//--tab2 click start---//	
$("#tab2next").click(function() 
{
 var hull_name                      =$("#hull_name").val();
 var hull_address                   =$("#hull_address").val();
 var hullmaterial_id                =$("#hullmaterial_id").val();
 var hull_thickness                 =$("#hull_thickness").val();
 var hullplating_material_id        =$("#hullplating_material_id").val();
 var hull_plating_material_thickness=$("#hull_plating_material_thickness").val();
 var freeboard_status_id            =$("#freeboard_status_id").val();
 var bulk_heads                     =$("#bulk_heads").val();
 var yard_accreditation_number      =$("#yard_accreditation_number").val();
 var yard_accreditation_expiry_date =$("#yard_accreditation_expiry_date").val();
 var bulk_head_placement            =$("#bulk_head_placement").val();
 var bulk_head_thickness            =$("#bulk_head_thickness").val();
 
  $.ajax({
    url : "<?php echo site_url('Survey/Edit_hull_details/')?>",
    type: "POST",
     data:$('#form2').serialize(),
    //dataType: "JSON",
    success: function(data)
    {
        
         alert("Hull Details Updated Successfully");
        $('.nav-tabs a[href="#tab_3"]').tab('show');
    }
  });
   
}); //---tab2 click End---//

//-----tab3 click start------//
$("#tab3next").click(function() 
{
/*
var no_of_engineset=$("#no_of_engineset").val();
  engine_placement_id
  bhp
  manufacturer_name
  manufacturer_brand
  engine_model_id
  engine_type_id
  propulsion_diameter
  propulsion_material_id
  gear_type_id
  gear_number
 */

  $.ajax({
          url : "<?php echo site_url('Survey/Edit_engine_details/')?>",
          type: "POST",
          data:$('#form3').serialize(),
          //dataType: "JSON",
          success: function(data)
          {
              //alert(data);
              alert("Engine Details Updated Successfully");
	            $('.nav-tabs a[href="#tab_4"]').tab('show');
    	    }
    });
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
        $.ajax({
        url : "<?php echo site_url('Survey/Edit_equipment_details/')?>",
        type: "POST",
        data:$('#form4').serialize(),
        //dataType: "JSON",
        success: function(data)
        {
   // alert(data);
            alert("Equipment Details Updated Successfully");
            $('.nav-tabs a[href="#tab_5"]').tab('show');
  	    }
  });   


});  //---tab4 click End---//

//------------------- Particulars of Fire Appliance ---------------// 
  //-----tab5 click start------//
	
$("#tab5next").click(function() {
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

  $.ajax({
        url : "<?php echo site_url('Survey/Edit_fire_appliance/')?>",
        type: "POST",
        data:$('#form5').serialize(),
        //dataType: "JSON",
        success: function(data)
        {
          //  alert(data);
            alert("Fire Appliance Details Updated Successfully");
            $('.nav-tabs a[href="#tab_6"]').tab('show');
  	    }
  }); 
});
	
//------tab5 click End---//


	//------------------- Particulars of Other Equipments ---------------// 
  //-----tab6 click start------//
	
$("#tab6next").click(function() {
    
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

  $.ajax({
        url : "<?php echo site_url('Survey/Edit_other_equipments/')?>",
        type: "POST",
        data:$('#form6').serialize(),
        //dataType: "JSON",
        success: function(data)
        {
        //alert(data);
            alert("Other Equipments Details Updated Successfully");
            $('.nav-tabs a[href="#tab_7"]').tab('show');
  	    }
  }); 

});
	
//------tab6 click End---//



	//------------------- Particulars of Documents ---------------// 
  //-----tab7 click start------//
	
$("#tab7next").click(function(e) 
{
  var data = new FormData();

  var form_data = $('#form7').serializeArray();
  $.each(form_data, function (key, input) 
  {
  data.append(input.name, input.value);
  });
  for(var j=1; j<=7; j++)
  {

  var file_data = $('input[name="myFile'+j+'"]')[0].files;
  for (var i = 0; i < file_data.length; i++) {
  data.append("myFile"+j+"[]", file_data[i]);
  }
  }
  data.append('key', 'value');
      
      
   $.ajax({
          url : "<?php echo site_url('Survey/Edit_vessel_documents/')?>",
          type: "POST",
        //data:$('#form7').serialize(),
          data: data,
          contentType: false,       
          cache: false,             
          processData:false, 
            
            success: function(data)
            {
               // alert(data);
                alert("Vessel Documents Updated Successfully");
                $('.nav-tabs a[href="#tab_8"]').tab('show');
      	    }
      }); 
		
});

//------tab7 click End---//
	
	
	
  
	//------------------- Payment Details ---------------// 
  //-----tab8 click start------//
	
$("#tab8next").click(function() 
{
    /*
     paymenttype_id  
     dd_amount
     dd_number
     dd_date 
     portofregistry_id
     bank_id
    branch_name
     */
  $.ajax({
          url : "<?php echo site_url('Survey/Edit_payment_details/')?>",
          type: "POST",
          data:$('#form8').serialize(),
          //dataType: "JSON",
          success: function(data)
          {
              //alert(data);
              alert("Payment Details Updated Successfully");
              window.location.href = "<?php echo site_url('Survey/InitialSurvey'); ?>";
    	    }
    }); 

});
	
//------tab8 click End---//
  
	



                        
  $("#tab2back").click(function() {
                $('.nav-tabs a[href="#tab_1"]').tab('show');
    });
  	
    $("#tab3back").click(function() {
                $('.nav-tabs a[href="#tab_2"]').tab('show');
    });
    
    $("#tab4back").click(function() {
                $('.nav-tabs a[href="#tab_3"]').tab('show');
    });
      
    $("#tab5back").click(function() {
                $('.nav-tabs a[href="#tab_4"]').tab('show');
    });
    
    $("#tab6back").click(function() {
                $('.nav-tabs a[href="#tab_5"]').tab('show');
    });
	
    $("#tab8back").click(function() {
                $('.nav-tabs a[href="#tab_7"]').tab('show');
    });
    $("#tab7back").click(function() {
                $('.nav-tabs a[href="#tab_6"]').tab('show');
    });
	
	
	
    
  $("#number_hydrant").change(function()
  {
      var hydrant= $("#number_hydrant").val();
      $("#number_hose").val(hydrant);
      
  });
 
 
 
//---------JQUERY END---------------//
}); 

function bulkhead_placement()
{
  var resultdata=$.ajax
  ({
    type: "POST",
    url:"<?php echo site_url('/Survey/bulk_heads_add/')?>",
    success: function(data)
    {         
    },
    async:false,       
  });
  return resultdata.responseText;
}

function inboard_outboard()
{
  var resultdata=$.ajax
  ({
  type: "POST",
  url:"<?php echo site_url('/Survey/inboard_outboard_add/')?>",
  success: function(data)
  {         

  },
  async:false,       
  });
  return resultdata.responseText;
}

function model_number()
{
    var resultdata=$.ajax
  ({
    type: "POST",
    url:"<?php echo site_url('/Survey/model_number_add/')?>",
    success: function(data)
    {         
      
    },
     async:false,       
  });
  return resultdata.responseText;
}


function engine_type()
{
  var resultdata=$.ajax
  ({
  type: "POST",
  url:"<?php echo site_url('/Survey/engine_type_add/')?>",
  success: function(data)
  {         

  },
  async:false,       
  });
  return resultdata.responseText;
}

function gear_type()
{
  var resultdata=$.ajax
  ({
  type: "POST",
  url:"<?php echo site_url('/Survey/gear_type_add/')?>",
  success: function(data)
  {         

  },
  async:false,       
  });
  return resultdata.responseText;
}

function propulsionshaft_material()
{
  var resultdata=$.ajax
  ({
  type: "POST",
  url:"<?php echo site_url('/Survey/propulsionshaft_material_add/')?>",
  success: function(data)
  {         

  },
  async:false,       
  });
  return resultdata.responseText;
}

        
        
        

function remove_tb(i)
{

  var bulk_heads=$("#bulk_heads").val();
  var newbulk=bulk_heads-1;
  $("#bulk_heads").val(newbulk);
  if(newbulk==0)
  {
    $("#freeboard_status_id_n").prop("checked", true);
  }
  $("#remove"+i).remove();
  $("#show_rmv"+i).html('Removed');
  $('#bulk_head_placement'+i).attr("disabled", 'true'); 
  $('#bulk_head_thickness'+i).attr('readonly', 'true');
  $("#rmv_bulkhead"+i).css('background-color', 'gray');  
  $("#delete_status"+i).val('1');
}
           
   
  
function get_kw(i)
{
  var bhp=parseInt($("#bhp"+i).val());
  var total=(0.745699872)*bhp;
  var result=  total.toFixed(2); 
  $("#bhp_kw"+i).val(result);
}
    
function remove_engine_tb(i)
{
  var no_of_engineset=$("#no_of_engineset").val();
  var new_no_of_engineset=no_of_engineset-1;
  $("#no_of_engineset").val(new_no_of_engineset);
  //$("#engine_set"+i).remove();
  //$("#remove_engine_tb"+i).remove();
  var dltsts=parseInt('1');
  $("#delete_status_engine"+i).val(dltsts);
  $("#engine_set"+i).find("input,button,textarea,select").attr("disabled", "disabled");
  $("#remove_engine_tb"+i).remove();
}

</script>

<?php 
//-------------------Vessel Details--------------//
$vessel_id    = $this->uri->segment(3);
$stage_count  = $this->uri->segment(4);
 
$vessel_name                  =   $vessel_details[0]['vessel_name'];
$vessel_expected_completion   =   $vessel_details[0]['vessel_expected_completion'];
$vessel_category_id           =   $vessel_details[0]['vessel_category_id'];
$vessel_type_id               =   $vessel_details[0]['vessel_type_id'];
$vessel_subcategory_id        =   $vessel_details[0]['vessel_subcategory_id'];
$vessel_subtype_id            =   $vessel_details[0]['vessel_subtype_id'];
$vessel_length_overall        =   $vessel_details[0]['vessel_length_overall'];
$vessel_length                =   $vessel_details[0]['vessel_length'];
$vessel_depth                 =   $vessel_details[0]['vessel_depth'];
$vessel_breadth               =   $vessel_details[0]['vessel_breadth'];
$vessel_expected_tonnage      =   $vessel_details[0]['vessel_expected_tonnage'];
$vessel_sl                    =   $vessel_details[0]['vessel_sl'];
$month_id                     =   $vessel_details[0]['month_id'];

$vessel_upperdeck_length      =   $vessel_details[0]['vessel_upperdeck_length'];
$vessel_upperdeck_breadth     =   $vessel_details[0]['vessel_upperdeck_breadth'];
$vessel_upperdeck_depth       =   $vessel_details[0]['vessel_upperdeck_depth'];
$vessel_no_of_deck            =   $vessel_details[0]['vessel_no_of_deck'];

 

//-----------------Hull Details------------------------//
$hull_name                           = $hull_details[0]['hull_name'];
$hull_address                        = $hull_details[0]['hull_address'];
$hullmaterial_id                     = $hull_details[0]['hullmaterial_id'];
$hull_thickness                      = $hull_details[0]['hull_thickness'];
$hullplating_material_id             = $hull_details[0]['hullplating_material_id'];
$hull_plating_material_thickness     = $hull_details[0]['hull_plating_material_thickness'];
$yard_accreditation_number           = $hull_details[0]['yard_accreditation_number'];
$yard_accreditation_expiry_date_input= $hull_details[0]['yard_accreditation_expiry_date'];
$yard_accreditation_expiry_date      = date("d-m-Y", strtotime($yard_accreditation_expiry_date_input));
$bulk_heads                          = $hull_details[0]['bulk_heads'];
$freeboard_status_id                 = $hull_details[0]['freeboard_status_id'];
$hull_sl                             = $hull_details[0]['hull_sl'];

//-------------------Engine Details---------------------------//
 $number_of_enginecount              = $engine_details_count[0]['engine_count'];
 
 //-------------------Equipment Details---------------------------//
 
 $weight1          =   $anchorport_equipment[0]['weight'];
 /* if($weight12==0)
 {
     $weight1=0;
 }
 else {
     $weight1=$weight12;
 }
 */
$material_id1      =   $anchorport_equipment[0]['material_id'];
$id1               =   $anchorport_equipment[0]['equipment_details_sl'];

$weight2           =   $anchorstarboard_equipment[0]['weight'];
$material_id2      =   $anchorstarboard_equipment[0]['material_id'];
$id2               =   $anchorstarboard_equipment[0]['equipment_details_sl'];

$weight3           =   $anchorspare_equipment[0]['weight'];
$material_id3      =   $anchorspare_equipment[0]['material_id'];
$id3               =   $anchorspare_equipment[0]['equipment_details_sl'];

$size4             =   $chainport_equipment[0]['size'];
$length4           =   $chainport_equipment[0]['length'];
$chainport_type_id4=   $chainport_equipment[0]['chainport_type_id'];
$id4               =   $chainport_equipment[0]['equipment_details_sl'];

$size5             =   $chainstarboard_equipment[0]['size'];
$length5           =   $chainstarboard_equipment[0]['length'];
$chainport_type_id5=   $chainstarboard_equipment[0]['chainport_type_id'];
$id5               =   $chainstarboard_equipment[0]['equipment_details_sl'];

$size6             =   $rope_equipment[0]['size'];
$number6           =   $rope_equipment[0]['number'];
$material_id6      =   $rope_equipment[0]['material_id'];
$id6               =   $rope_equipment[0]['equipment_details_sl'];


$number7           =   $searchlight_equipment[0]['number'];
$power7            =   $searchlight_equipment[0]['power'];
$size7             =   $searchlight_equipment[0]['size'];
$id7               =   $searchlight_equipment[0]['equipment_details_sl'];

$number8            =   $lifebuoys_equipment[0]['number'];
$id8                =   $lifebuoys_equipment[0]['equipment_details_sl'];

$number9            =   $lifebuoysbuoyant_equipment[0]['number'];
$id9                =   $lifebuoysbuoyant_equipment[0]['equipment_details_sl'];

   
   
 
  //-------------------Fire Appliance Equipment Details---------------------------//              
         
 $material_id1_firemains    =$firemains_equipment[0]['material_id'];
 $diameter1                 =$firemains_equipment[0]['diameter'];
 $id1_fire                  =$firemains_equipment[0]['equipment_details_sl'];
 $number_hydrants           =$hydrants_equipment[0]['number'];
 $id2_fire                  =$hydrants_equipment[0]['equipment_details_sl'];
 $number_hose               =$hose_equipment[0]['number'];
 $id3_fire                  =$hose_equipment[0]['equipment_details_sl'];
 
 
 //--------------------other equipment Details--------------//
 $sewage_treatment          =$vessel_details[0]['sewage_treatment'];
 $solid_waste               =$vessel_details[0]['solid_waste'];
 $sound_pollution           =$vessel_details[0]['sound_pollution'];
 $water_consumption         =$vessel_details[0]['water_consumption'];
 $source_of_water           =$vessel_details[0]['source_of_water'];
//--------------Documents------------//
$vessel_pref_inspection_date=$vessel_details[0]['vessel_pref_inspection_date'];
$pref_date                  =date("d-m-Y", strtotime($vessel_pref_inspection_date));
  
  //---------------Payment Details----------------//
  
$paymenttype_id           = $payment_details[0]['paymenttype_id'];
$dd_amount                = $payment_details[0]['dd_amount'];
$dd_number                = $payment_details[0]['dd_number'];
$dd_date1                 = $payment_details[0]['dd_date'];

$dd_date                  = date("d-m-Y", strtotime($dd_date1));
$portofregistry_id        = $payment_details[0]['portofregistry_id'];
$bank_id                  = $payment_details[0]['bank_id'];
$branch_name              = $payment_details[0]['branch_name'];
$payment_sl               =$payment_details[0]['payment_sl'];

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
<button type="button" class="btn bg-primary btn-flat margin"> Form 1 </button>
      <!-- Important; the following two ol class has to be kept, its not mistake -->
      <ol class="breadcrumb">
      <ol class="breadcrumb">
       <li><a href="<?php echo $site_url."/Survey/SurveyHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
<li><a href="<?php echo $site_url."/Survey/InitialSurvey"?>"></i>  <span class="badge bg-blue"> Initial Survey DashBoard </span> </a></li>       
 <li><a href="#"></i>  <span class="badge bg-blue"> Form 1 Edit </span> </a></li>
      </ol> </ol> 
      <!-- End of two ol -->
    </section>
    <!-- Bread Crumb Section Ends Here .... -->
    <!-- Header Section ends here -->
    <!-- Main content -->
    <section class="content">
   <!-- Main Content starts here -->

     <div class="row custom-inner">
      <!-- start inner custom row -->

        <div class="col-md-12">
          <div class="box box-solid">
          <div class="box-header with-border">
              <h3 class="box-title" style="color: #00f">Form 1 </h3>
              <p>  See Rule 5 (1) - Form for expressing the intention to build a new vessel  </p>
            </div>
              <div class="box-body">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <!--<li class="active"><a href="#tab_1" data-toggle="tab">Vessel Details</a></li>-->
              <li><a href="#tab_1" data-toggle="tab">Vessel Details</a></li>
              <li><a href="#tab_2" data-toggle="tab">Particulars of Hull</a></li>
              <li><a href="#tab_3" data-toggle="tab">Particulars of Engine</a></li>
              <li><a href="#tab_4" data-toggle="tab">Particulars of Equipment</a></li>
              <li><a href="#tab_5" data-toggle="tab">Particulars of Fire Appliance</a></li>
              <li><a href="#tab_6" data-toggle="tab">Other Equipments</a></li>
              <li><a href="#tab_7" data-toggle="tab">Documents</a></li>
              <li><a href="#tab_8" data-toggle="tab">Payment</a></li>
             
            </ul>
            <div class="tab-content">
             
                  
                   
<!-- ___________________________ Vessel Details _________________________  -->


<div class="tab-pane active" id="tab_1">
<form name="form1" id="form1" method="post" > 
<input type="hidden" name="vessel_sl" value="<?php echo $vessel_sl; ?>" id="vessel_sl">

  <table id="vacbtable" class="table table-bordered table-striped">
    <tr> 
      <td  colspan="2"> <font color="#282626"> <small> യാനത്തിന്റെ പേര്  / </small>  <h5>Vessel name  </h5> </font> </td>
      <td > <div class="div350"> <div class="form-group">
      <input type="text" name="vessel_name"  id="vessel_name" value="<?php echo $vessel_name; ?>"  class="form-control"  maxlength="30" autocomplete="off"/>
      <div> </div> </td> 
      <td >  <font color="#282626"> <small> നിർമ്മാണം പൂർത്തീകരിക്കാവുന്ന വർഷം / </small>  <h5>Proposed year of completion  </h5> </font></td>
      <td > <div class="div100"><div class="form-group">
      <input type="text" name="vessel_expected_completion" value="<?php echo $vessel_expected_completion; ?>" id="vessel_expected_completion"  class="form-control"  maxlength="4" autocomplete="off"  /> 
      </div></div>
      <div class="div200">
      <div class="form-group">
      <select class="form-control select2" name="month_id" id="month_id" title="Select Month" data-validation="required">
      <option value="">Select</option>
      <?php foreach ($month as $res_month)
      {
      ?>
      <option value="<?php echo $res_month['month_sl']; ?>" <?php if($month_id==$res_month['month_sl']) { echo "selected"; } ?>> <?php echo $res_month['month_name'];?>  </option>
      <?php
      } ?>

      </select>
      </div>
      </div>
      </td>
    </tr>

    <tr> 
      <td colspan="2"> <font color="#282626"> <small> യാനത്തിന്റെ വിഭാഗം / </small>  <h5> Category of vessel </h5> </font> </td>
      <td> <div class="div200">
      <div class="form-group">
      <select class="form-control select2" name="vessel_category_id" id="vessel_category_id" >

      <option value="">Select</option>
      <?php foreach ($vesselcategory as $res_vesselcategory)
      {
      $vesselcategory_sl=$res_vesselcategory['vesselcategory_sl'];
      ?>
      <option value="<?php echo $res_vesselcategory['vesselcategory_sl']; ?>" <?php if($vessel_category_id==$vesselcategory_sl) { echo "selected"; } ?>> <?php echo $res_vesselcategory['vesselcategory_name'];?>  </option>
      <?php
      } ?>

      </select>
      </div>
      <!-- /.form-group -->
      </div></td>
      <td><font color="#282626"> <small> യാനത്തിന്റെ ഉപവിഭാഗം / </small>  <h5> Sub category of vessel</h5> </font></td>
      <td> <div class="div200">
      <div class="form-group">
      <select class="form-control select2" name="vessel_subcategory_id" id="vessel_subcategory_id" >

      <option value="">Select</option>
      <?php foreach ($vessel_subcategory as $result) {;?>
      <option value="<?php echo $result['vessel_subcategory_sl'];?>" <?php if($vessel_subcategory_id==$result['vessel_subcategory_sl']){ echo "selected"; } ?>><?php echo $result['vessel_subcategory_name'];?></option>
      <?php } ?>
      </select>
      </div>
      <!-- /.form-group -->
      </div>
      </td>
    </tr>

    <tr> 
      <td colspan="2"> <font color="#282626"> <small> യാനത്തിന്റെ തരം / </small>  <h5> Type of vessel</h5> </font></td>
      <td> <div class="div200">
      <div class="form-group">
      <select class="form-control select2" name="vessel_type_id" id="vessel_type_id">
      <option value="">Select</option>
      <?php foreach ($vesseltype as $res_vesseltype)
      {
      ?>
      <option value="<?php echo $res_vesseltype['vesseltype_sl']; ?>" <?php if($vessel_type_id==$res_vesseltype['vesseltype_sl']) { echo "selected"; }?> <> <?php echo $res_vesseltype['vesseltype_name'];?>  </option>
      <?php
      }
      ?>
      </select>
      </div>
      <!-- /.form-group -->
      </div></td>
      <td><font color="#282626"> <small> യാനത്തിന്റെ സബ്ടൈപ്പ് / </small>  <h5>  Sub-type of vessel</h5> </font></td>
      <td> <div class="div200">
      <div class="form-group">
      <select class="form-control select2" name="vessel_subtype_id" id="vessel_subtype_id" >  
      <option value="">Select</option>
      <?php foreach ($vessel_subtype as $result) {;?>
      <option value="<?php echo $result['vessel_subtype_sl'];?>" <?php if($vessel_subtype_id==$result['vessel_subtype_sl']) { echo "selected"; } ?> ><?php echo $result['vessel_subtype_name'];?></option>
      <?php } ?>
      </select>
      </div>
      <!-- /.form-group -->
      </div>
      </td>
    </tr>

    <tr id="show_vessel_length_overall"> 
      <td  colspan="2"> <font color="#282626"> <small>  </small>  <h5>Length Overall  </h5> </font> </td>
      <td > <div class="div100"> <div class="input-group">
      <input type="text" name="vessel_length_overall" value="<?php echo $vessel_length_overall; ?>" id="vessel_length_overall"  class="form-control"  maxlength="30" autocomplete="off"/>
      <span class="input-group-addon">m</span>
      <div> </div> </td> 
      <td >  </td>
      <td > </td>
    </tr>

    <tr>
      <td colspan="2" class="div200"> <font color="#282626"> <small> നീളം / </small>  <h5> Length </h5> </font> </td> 
      <td> <font color="#282626"> <small> വീതി / </small>  <h5>Breadth </h5> </font></td> 
      <td> <font color="#282626"> <small> ആഴം / </small>  <h5>Depth </h5> </font></td> 
      <td> <font color="#282626"> <small> ഭാരം / </small>  <h5> Tonnage </h5> </font> </td> 
    </tr>
    <tr>  
      <td colspan="2"> <div class="div100">
      <div class="input-group">
      <input type="text" class="form-control" name="vessel_length" value="<?php echo $vessel_length; ?>" id="vessel_length" maxlength="4" autocomplete="off">
      <span class="input-group-addon">m</span>
      </div>
      </div></td> 
      <td> <div class="div100"> <div class="input-group">
      <input type="text" name="vessel_breadth" value="<?php echo $vessel_breadth; ?>" id="vessel_breadth"  class="form-control"  maxlength="4" autocomplete="off" />
      <span class="input-group-addon">m</span>
      </div></div></td> 
      <td> <div class="div100"> <div class="input-group">
      <input type="text" name="vessel_depth" value="<?php echo $vessel_depth; ?>" id="vessel_depth"  class="form-control"  maxlength="4" autocomplete="off" />
      <span class="input-group-addon">m</span>
      </div> </div></td> 
      <td> <div class="">
      <div class="col-md-12">
      <div class="col-md-6">
      <div class="form-group">
      <button type="button" class="btn bg-olive btn-flat" id="check_tonnage"> Check </button>
      </div>
      </div>

      <div class="col-md-6" id="Ton">
      <font color="#00f" id="show_tonnage"><input type="hidden" name="hdn_tonnage" value="<?php echo 
      $vessel_expected_tonnage; ?>" ><?php echo $vessel_expected_tonnage; ?>&nbsp; Ton  </font>
      <div class="progress progress-xs">
      <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">                  
      </div>
      </div>
      </div>
      </div>
      </div> 
      </td> 
    </tr>

    <tr >
      <td colspan="5">  <button type="button" class="btn btn-info pull-right" name="tab1next" id="tab1next">Next</button> </td>
    </tr>

  </table>
</form>  
</div>
 <!-- /. end of tab-pane 1-->


<!--  _________________________  Particulars of Hull _________________________  -->

<div class="tab-pane" id="tab_2">
<form name="form2" id="form2" method="post" >
  <table id="vacbtable" class="table table-bordered table-striped">
  <input type="hidden" name="vessel_id" value="<?php echo $vessel_id; ?>" id="">
  <input type="hidden" name="stage_count" value="<?php echo $stage_count; ?>" id="">
  <input type="hidden" name="hull_sl" value="<?php echo $hull_sl; ?>" id="hull_sl">
  
  <tr> 
  <td colspan="2"> Name of builder of hull</td>
    <td> <div class="div350"> <div class="form-group">
    <input type="text" name="hull_name" value="<?php echo $hull_name; ?>" id="hull_name"  class="form-control"  maxlength="30" autocomplete="off" /></div> </div></td>
    <td> Address of builder of hull</td>
    <td> <div class="div350">
    <div class="form-group">
    <textarea class="form-control" rows="3" name="hull_address" id="hull_address"  ><?php echo $hull_address; ?></textarea>
    </div>
    <!-- end of text area -->
    </div></td>
  </tr>

  <tr> 
    <td colspan="2"> Material of hull</td>   
    <td> 
    <div class="form-group">
    <select class="form-control select2 div200" name="hullmaterial_id" id="hullmaterial_id" >
    <option value="">Select</option>
    <?php foreach ($hullmaterial as $res_hullmaterial)
    {
    ?>
    <option value="<?php echo $res_hullmaterial['hullmaterial_sl']; ?>" <?php if($hullmaterial_id==$res_hullmaterial['hullmaterial_sl']) { echo "selected"; } ?>> <?php echo $res_hullmaterial['hullmaterial_name'];?>  </option>
    <?php 
    }
     ?>

    </select>
    </div>
    <!-- /.form-group -->
    </td>
    <td> Thickness of hull</td>
    <td> <div class="div100"> <div class="input-group">
    <input type="text" name="hull_thickness" value="<?php echo $hull_thickness; ?>" id="hull_thickness"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">mm</span>
    </div> </div>
    </td>
  </tr>

  <tr> 
    <td colspan="2"> Hull plating material</td> 
    <td> 
    <div class="form-group">
    <select class="form-control select2 div200" name="hullplating_material_id" id="hullplating_material_id" >
    <?php foreach ($hullplating_material as $res_hullplating_material)
    {
    ?>
    <option value="<?php echo $res_hullplating_material['hullplating_material_sl']; ?>" <?php if($hullplating_material_id==$res_hullplating_material['hullplating_material_sl']) { echo "selected"; } ?>> <?php echo $res_hullplating_material['hullplating_material_name'];?>  </option>
    <?php
    } 
    ?>
    </select>
    </div>
    </td>
    <td> Thickness of hull plating material</td>
    <td> <div class="div100"> <div class="input-group">
    <input type="text" name="hull_plating_material_thickness" value="<?php echo $hull_plating_material_thickness; ?>" id="hull_plating_material_thickness"  class="form-control"  maxlength="30" autocomplete="off" />
    <span class="input-group-addon">mm</span>
    </div> </div></td>
  </tr>

  <tr> 
    <td colspan="2"> Yard Accreditation certificate number</td>
    <td> <div class="div200"> <div class="form-group">
    <input type="text" name="yard_accreditation_number" value="<?php echo $yard_accreditation_number; ?>" id="yard_accreditation_number"  class="form-control"  maxlength="30" autocomplete="off" />
    </div> </div></td>
    <td>Expiry Date</td>
    <td>   <div class="div250">
    <div class="form-group">
    <div class="input-group date">
    <div class="input-group-addon">
    <i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control" id="datepicker2" name="yard_accreditation_expiry_date" value="<?php echo $yard_accreditation_expiry_date; ?>">
    </div>
    <!-- /.input group -->
    </div>
    <!-- /.form group -->
    </div></td>
  </tr>

  <tr> 
    <td colspan="2"> Whether with a deck above freeboard </td>
    <td> <div class="form-group">
    <label>
    <input type="radio" name="freeboard_status_id" id="freeboard_status_id_y" value="1" class="freeboard_status_id" <?php echo ($freeboard_status_id== 1) ?  "checked" : "" ;  ?>> &nbsp;Yes
    </label> &nbsp; &nbsp;
    <label>
    <input type="radio" name="freeboard_status_id"  id="freeboard_status_id_n"  value="0" <?php echo ($freeboard_status_id== 0) ?  "checked" : "" ;  ?> class="freeboard_status_id" > &nbsp;No
    </label>
    </div>
    <!-- end of radio --></td>
    <td><span id="num_bulk" >Number of Bulk Head</span>  </td>
    <td> <div class="div100"> <div class="form-group" id="bulk_heads_show" >

    <input type="text" name="bulk_heads" value="<?php echo $bulk_heads; ?>" id="bulk_heads"  class="form-control"  maxlength="30" autocomplete="off" readonly/>
    <input type="hidden" name="hdn_bulkheads" id="hdn_bulkheads" value="<?php echo $bulk_heads; ?>" >
    </div> </div></td>
  </tr>

  <tr>
    <td colspan="4">
      <table id="show_headplacement" class="table table-bordered table-striped">
      <?php
      $i=1; 
      foreach($hull_bulkhead_details as $res_hull_bulkhead)
      {
      $bulk_head_placement_id=$res_hull_bulkhead['bulk_head_placement'];
      $hull_bulkhead_details_sl=$res_hull_bulkhead['hull_bulkhead_details_sl'];
      $delete_status=$res_hull_bulkhead['delete_status'];
      $bulk_head_placement      =   $this->Survey_model->get_bulk_head_placement();
      $data['bulk_head_placement']   = $bulk_head_placement; 
      ?>
      <tr id="rmv_bulkhead<?php echo $i; ?>">
      <td> Bulk head placement</td>
      <td> 
      <div class="form-group">
      <select class="form-control select2 div200" name="bulk_head_placement[]" id="bulk_head_placement<?php echo $i; ?>">
      <option value="">Select</option>
      <?php foreach ($bulk_head_placement as $res_bulkhead)
      {
      ?>
      <option value="<?php echo $res_bulkhead['bulkhead_placement_sl']; ?>" <?php  if($bulk_head_placement_id==$res_bulkhead['bulkhead_placement_sl']) {echo "selected";}?>> <?php echo $res_bulkhead['bulkhead_placement_name'];?>  </option>
      <?php
      } 
      ?>
      </select>
      </div>
      </td>
      <td> Bulk head thickness</td>
      <td> <div class="div100"> <div class="input-group">
      <input type="text" name="bulk_head_thickness[]" value="<?php echo $res_hull_bulkhead['bulk_head_thickness']; ?>" id="bulk_head_thickness<?php echo $i; ?>"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">mm</span> 
      </div> </div> <input type="hidden" name="hull_bulkhead_details_sl[]" value="<?php echo $hull_bulkhead_details_sl; ?>" id=""> </td>
      <td>
      <input type="hidden" value="<?php  echo $delete_status; ?>" id="delete_status<?php echo $i; ?>" name="delete_status[]">
      <button type="button" class="btn btn-warning pull-right" name="remove" id="remove<?php echo $i; ?>" onclick="remove_tb(<?php echo $i; ?>)">Remove</button> <span id="show_rmv<?php echo $i; ?>"> </span></td>
      </tr>
      <?php 
      $i++;
      }
      ?>
      </table>
    </td>
  </tr>

  <tr>
    <td colspan="4">
    <button type="button" name="bulkhead_add" id="bulkhead_add">Add More</button>
    </td>
  </tr>
  <tr> 
    <td colspan="5"> 
    <button type="button" class="btn btn-info pull-right btn-space" name="tab2next" id="tab2next">Next</button>
    <button type="button" class="btn btn-warning pull-right btn-space" name="tab2back" id="tab2back">Back</button>  
    </td>
  </tr>
  </table>
</form>
</div>
<!-- /. end of tab-pane 2 -->
         
<!-- _________________________  Particulars of Engine _________________________  -->

<!-- /. end of tab-pane 2 -->
<div class="tab-pane" id="tab_3">
<form name="form3" id="form3" method="post">
<input type="hidden" name="vessel_id" value="<?php echo $vessel_id; ?>" id="vessel_id">
<input type="hidden" name="stage_count" value="<?php echo $stage_count; ?>" id="stage_count">

<table id="vacbtable" class="table table-bordered table-striped">
  <tr> 
    <td colspan="3">  Number of engine sets</td>
    <td colspan="2">  <div class="div100">
    <div class="input-group input-group-sm">
    <input type="text" class="form-control" readonly name="no_of_engineset" id="no_of_engineset" value="<?php echo $number_of_enginecount; ?>" >
    <input type="hidden" class="form-control" readonly name="engineset_no" id="engineset_no" value="<?php echo $number_of_enginecount; ?>" >    
    <span class="input-group-btn"> </span>
    </div>
    <!-- /input-group -->
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="5" align="left" >
    <button type="button" name="add_engine_set" id="add_engine_set" >Add More</button>
    <?php 
    $i=1;
    foreach ($engine_details as $res_engine_details) {

    $bhp                  = $res_engine_details['bhp'];
    $engine_number        = $res_engine_details['engine_number'];
    $engine_placement_id  = $res_engine_details['engine_placement_id'];
    $bhp_kw               = $res_engine_details['bhp_kw'];
    $manufacturer_name    = $res_engine_details['manufacturer_name'];
    $manufacturer_brand   = $res_engine_details['manufacturer_brand'];
    $engine_model_id      = $res_engine_details['engine_model_id'];
    $engine_type_id       = $res_engine_details['engine_type_id'];
    $propulsion_diameter  = $res_engine_details['propulsion_diameter'];
    $propulsion_material_id = $res_engine_details['propulsion_material_id'];
    $gear_type_id         = $res_engine_details['gear_type_id'];
    $gear_number          = $res_engine_details['gear_number']; 
    $engine_sl            = $res_engine_details['engine_sl']; 
    $delete_status        = $res_engine_details['delete_status'];

    ?> 
    <div><button type="button" class="btn btn-warning pull-right" name="remove" id="remove_engine_tb<?php echo $i; ?>" onclick="remove_engine_tb(<?php echo $i; ?>)">Remove</button></div>
    <input type="hidden" name="engine_sl[]" value="<?php echo $engine_sl; ?>" id="">
    <div id="show_engine_set"> 
      <table id="engine_set<?php echo $i; ?>" class="table table-bordered table-striped">
      <tr>
      <td colspan="5" align="right"> 
      </td>
      </tr>
      <tr> <td colspan="5"> Engine Set # <?php echo $i; ?>
      <input type="hidden" name="delete_status_engine[]" id="delete_status_engine<?php  echo $i; ?>" value="<?php echo $delete_status; ?>"> </td> </tr>
      <tr>
      <td>Engine Number </td>
      <td>&nbsp; </td>
      <td><div class="div100"> <div class="form-group">
      <input type="text" name="engine_number[]" value="<?php echo $engine_number; ?>" id="engine_number<?php echo $i; ?>"  class="form-control"  maxlength="30" autocomplete="off" />
      </div> </div> </td>
      <td>&nbsp; </td>
      </tr>
      <tr>
      <td colspan="2"> Whether Engine inboard/outboard</td>
      <td> 
      <div class="form-group">

      <select class="form-control select2 div200" name="engine_placement_id[]" id="engine_placement_id" >
      <option value="">Select</option>
      <?php
      foreach ($inboard_outboard as $res_inboard_outboard)
      {
      ?>
      <option value="<?php echo $res_inboard_outboard['inboard_outboard_sl']; ?>" <?php if($engine_placement_id==$res_inboard_outboard['inboard_outboard_sl']) { echo "selected"; }?>> <?php echo $res_inboard_outboard['inboard_outboard_name']; ?>  </option>
      <?php
      }
      ?>

      </select>
      </div>
      </td>
      <td> BHP</td>
      <td> <div class="div100"> <div class="form-group">
      <input type="text" name="bhp[]" value="<?php echo $bhp; ?>" id="bhp<?php echo $i; ?>"  class="form-control"  maxlength="30" autocomplete="off" onchange="get_kw(<?php echo $i; ?>)"/>
      </div> </div>&nbsp;<span id="show_bhp_kw"><input type="text" name="bhp_kw[]" id="bhp_kw<?php echo $i; ?>" value="<?php echo $bhp_kw; ?>" readonly=""></span>KW</td>
      </tr>
      <tr>  
      <td colspan="2"> Name of manufacturer</td>
      <td> <div class="div350"> <div class="form-group">
      <input type="text" name="manufacturer_name[]" value="<?php echo $manufacturer_name; ?>" id="manufacturer_name"  class="form-control"  maxlength="30" autocomplete="off" />
      </div> </div></td>
      <td> Brand of manufacturer</td>
      <td> <div class="div350"> <div class="form-group">
      <input type="text" name="manufacturer_brand[]" value="<?php echo $manufacturer_brand; ?>" id="manufacturer_brand"  class="form-control"  maxlength="30" autocomplete="off" />
      </div> </div></td>
      </tr>
      <tr>
      <td colspan="2"> Model number of engine</td>
      <td> 
      <div class="form-group">
      <select class="form-control select2 div200" name="engine_model_id[]" id="engine_model_id" >
      <option value="">Select</option>
      <?php
      foreach ($model_number as $res_model_number)
      {
      ?>
      <option value="<?php echo $res_model_number['modelnumber_sl']; ?>" <?php if($engine_model_id==$res_model_number['modelnumber_sl']) { echo "selected"; } ?>> <?php echo $res_model_number['modelnumber_name']; ?>  </option>
      <?php
      }
      ?>
      </select>
      </div>
      </td>
      <td> Type of engine</td>
      <td> 
      <div class="form-group">
      <select class="form-control select2 div200" name="engine_type_id[]" id="engine_type_id" >
      <option value="">Select</option>
      <?php
      foreach ($engine_type as $res_engine_type)
      {
      ?>
      <option value="<?php echo $res_engine_type['enginetype_sl']; ?>" <?php if($engine_type_id==$res_engine_type['enginetype_sl']) { echo "selected"; }  ?>> <?php echo $res_engine_type['enginetype_name']; ?>  </option>
      <?php
      }
      ?>
      </select>
      </div>
      </td>
      </tr> 
      <tr>
      <td colspan="2"> Diameter of propulsion shaft</td>
      <td> <div class="div100"> <div class="input-group">
      <input type="text" name="propulsion_diameter[]" value="<?php echo $propulsion_diameter; ?>" id="propulsion_diameter"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">cm</span>
      </div> </div></td>
      <td> Material of propulsion shaft</td> 
      <td> 
      <div class="form-group">
      <select class="form-control select2 div200" name="propulsion_material_id[]" id="propulsion_material_id" >
      <?php
      foreach ($propulsionshaft_material as $res_material)
      {
      ?>
      <option value="<?php echo $res_material['propulsionshaft_material_sl']; ?>" <?php if($propulsion_material_id==$res_material['propulsionshaft_material_sl']) {echo "selected"; } ?>>  <?php echo $res_material['propulsionshaft_material_name']; ?>  </option>
      <?php
      }
      ?>
      </select>
      </div>
      </td>
      </tr>
      <tr>
      <td colspan="2"> Type of gear</td>
      <td> 
      <div class="form-group">
      <select class="form-control select2 div200" name="gear_type_id[]" id="gear_type_id" >

      <option value="">Select</option>
      <?php
      foreach ($gear_type as $res_gear_type)
      {
      ?>
      <option value="<?php echo $res_gear_type['geartype_sl']; ?>" <?php if($gear_type_id==$res_gear_type['geartype_sl']) { echo "selected"; } ?>> <?php echo $res_gear_type['geartype_name']; ?>  </option>
      <?php
      }
      ?>
      </select>
      </div>
      </td>
      <td> Number of gear</td>
      <td> <div class="div100"> <div class="form-group">
      <input type="text" name="gear_number[]" value="<?php echo $gear_number;?>" id="gear_number"  class="form-control"  maxlength="30" autocomplete="off" />
      </div> </div></td>
      </tr>
      </table>
    <?php
    $i++;
    }
    ?>
    </div>
    </td>
  </tr>
  <tr> 
    <td colspan="5"> 
    <button type="button" class="btn btn-info pull-right btn-space" name="tab3next" id="tab3next">Save</button>
    <button type="button" class="btn btn-warning pull-right btn-space" name="tab3back" id="tab3back">Back</button>  
    </td> 
  </tr>
</table>
</form>
</div>
<!-- /. end of tab-pane 3-->
              
              
<!-- _________________________  Particulars of Equipment _________________________  -->
              
              
              
<div class="tab-pane" id="tab_4">

<table id="vacbtable" class="table table-bordered table-striped">
</table>
<form name="form4" id="form4" method="post">    
<input type="hidden" name="vessel_id" value="<?php echo $vessel_id; ?>" id="">
<input type="hidden" name="stage_count" value="<?php echo $stage_count; ?>" id=""> 
<input type="hidden" name="id1" value="<?php echo $id1; ?>">
<input type="hidden" name="id2" value="<?php echo $id2; ?>">
<input type="hidden" name="id3" value="<?php echo $id3; ?>">
<input type="hidden" name="id4" value="<?php echo $id4; ?>">
<input type="hidden" name="id5" value="<?php echo $id5; ?>">
<input type="hidden" name="id6" value="<?php echo $id6; ?>">
<input type="hidden" name="id7" value="<?php echo $id7; ?>">
<input type="hidden" name="id8" value="<?php echo $id8; ?>">
<input type="hidden" name="id9" value="<?php echo $id9; ?>">


<table id="vacbtable" class="table table-bordered table-striped">


<tr> <td colspan="5"> Anchor</td> </tr>
<tr> <td colspan="3"> </td> <td> Weight</td> <td> Material </td>  </tr>
<tr> <td colspan="2"> </td> <td > Port</td> 
<td>  <div class="div100"> <div class="input-group">
<input type="text" name="weight1" value="<?php echo $weight1; ?>" id="weight1"  class="form-control "  maxlength="30" autocomplete="off" /><span class="input-group-addon">Kg</span>
</div> </div> </td> 
<td> 
<div class="form-group">
<select class="form-control select2 div200" name="material_id1" id="material_id1" >

<?php foreach ($equipment_material as $res_equipment_material)
{
?>
<option value="<?php echo $res_equipment_material['equipment_material_sl']; ?>" <?php if($material_id1==$res_equipment_material['equipment_material_sl']) { echo "selected"; }  ?>> <?php echo $res_equipment_material['equipment_material_name'];?>  </option>
<?php
}	?>

</select>
</div>


</td>  </tr>
<tr> <td colspan="2"> </td> <td > Starboard</td> 
<td> <div class="div100"> <div class="input-group">
<input type="text" name="weight2" value="<?php echo $weight2; ?>" id="weight2"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">Kg</span>
</div> </div></td> 
<td> 

<div class="form-group">
<select class="form-control select2 div200" name="material_id2" id="material_id2">

<?php foreach ($equipment_material as $res_equipment_material)
{
?>
<option value="<?php echo $res_equipment_material['equipment_material_sl']; ?>" <?php if($material_id2==$res_equipment_material['equipment_material_sl']) { echo "selected"; }  ?>> <?php echo $res_equipment_material['equipment_material_name'];?>  </option>
<?php
}	?>

</select>
</select>
</div>

</td>  </tr>


<tr> <td colspan="2"> </td> <td > Spare </td> 
<td> <div class="div100"> <div class="input-group">
<input type="text" name="weight3" value="<?php echo $weight3; ?>" id="weight3"  class="form-control"  maxlength="30" autocomplete="off" /> <span class="input-group-addon">Kg</span>
</div> </div></td> 
<td> 
<div class="form-group">
<select class="form-control select2 div200" name="material_id3" id="material_id3">

<?php foreach ($equipment_material as $res_equipment_material)
{
?>
<option value="<?php echo $res_equipment_material['equipment_material_sl']; ?>" <?php if($material_id2==$res_equipment_material['equipment_material_sl']) { echo "selected"; }  ?>> <?php echo $res_equipment_material['equipment_material_name'];?>  </option>
<?php
}	?>


</select>
</div>

</td>  </tr>

<tr> <td colspan="5"> Chain</td> </tr>
<tr> <td> </td> <td> </td> <td> Length </td>  <td> Size </td> <td> Type</td>  </tr>
<tr> <td> </td> <td > Port</td> 
<td> <div class="div100"> <div class="input-group">
<input type="text" name="length4" value="<?php echo $length4; ?>" id="length"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">m</span>
</div> </div> </td>
<td>   <div class="div100"> <div class="input-group">
<input type="text" name="size4" value="<?php echo $size4; ?>" id="size"  class="form-control"  maxlength="30" autocomplete="off" />
<span class="input-group-addon">mm</span>
</div> </div></td> 


<td>  
<div class="form-group">
<select class="form-control select2 div200" name="chainport_type_id4" id="chainport_type_id">
<option value="">Select</option>
<?php foreach ($chainport_type as $res_chainport_type)
{
?>
<option value="<?php echo $res_chainport_type['chainporttype_sl']; ?>" <?php if($chainport_type_id4==$res_chainport_type['chainporttype_sl']) { echo "selected"; }?> > <?php echo $res_chainport_type['chainporttype_name'];?>  </option>
<?php
}	?>

</select>
</select>
</div>


</td> 
</tr>
<tr> <td> </td> <td > Starboard</td> 

<td>  <div class="div100"> <div class="input-group">
<input type="text" name="length5" value="<?php echo $length5; ?>" id="length"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">m</span>
</div> </div></td> 
<td> <div class="div100"> <div class="input-group">
<input type="text" name="size5" value="<?php echo $size5; ?>" id="size"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">mm</span>
</div> </div></td> 
<td>  
<div class="form-group">
<select class="form-control select2 div200" name="chainport_type_id5" id="chainport_type_id">
<option value="">Select</option>
<?php foreach ($chainport_type as $res_chainport_type)
{
?>
<option value="<?php echo $res_chainport_type['chainporttype_sl']; ?>" <?php if($chainport_type_id5==$res_chainport_type['chainporttype_sl']) { echo "selected"; }?>> <?php echo $res_chainport_type['chainporttype_name'];?>  </option>
<?php
}	?>


</select>
</select>
</div>


</td> 
</tr>
<tr> <td colspan="5"> Rope</td> </tr>
<tr> <td colspan="2"></td> <td> Size </td>  <td> Number </td>  <td> Material</td> </tr>
<tr> <td colspan="2"></td> 
<td> <div class="div100"> <div class="input-group">
<input type="text" name="number6" value="<?php echo $number6; ?>" id="number"  class="form-control"  maxlength="30" autocomplete="off" />
<span class="input-group-addon">mm</span>
</div> </div> </td> 
<td>   <div class="div100"> <div class="form-group">
<input type="text" name="size6" value="<?php echo $size6; ?>" id="size"  class="form-control"  maxlength="30" autocomplete="off" />

</div> </div></td> 


<td>  
<div class="form-group">
<select class="form-control select2 div200" name="material_id6" id="material_id">
<option value="">Select</option>
<?php foreach ($rope_material as $res_rope_material)
{
?>
<option value="<?php echo $res_rope_material['ropematerial_sl']; ?>" <?php if($material_id6==$res_rope_material['ropematerial_sl']) { echo "selected"; }?>> <?php echo $res_rope_material['ropematerial_name'];?>  </option>
<?php
}	?>

</select>
</div>

</td>
</tr>
</tr>
<tr> <td colspan="5"> Search Light</td> </tr>
<tr> <td colspan="2"> </td> <td> Number </td> <td> Power </td> <td> Size</td>  </tr>
<tr> <td colspan="2"> </td> 

<td> <div class="div100"> <div class="form-group">
<input type="text" name="number7" value="<?php echo $number7; ?>" id="number"  class="form-control"  maxlength="30" autocomplete="off" />
</div> </div> </td> 
<td>   <div class="div100"> <div class="input-group">
<input type="text" name="power7" value="<?php echo $power7; ?>" id="power"  class="form-control"  maxlength="30" autocomplete="off" />
<span class="input-group-addon">nm</span>
</div> </div></td> 
<td>  
<div class="form-group">
<select class="form-control select2 div200" name="size7" id="size" >
<option value="">Select</option>
<?php foreach ($searchlight_size as $res_searchlight_size)
{
?>
<option value="<?php echo $res_searchlight_size['searchlight_size_sl']; ?>" <?php if($size7==$res_searchlight_size['searchlight_size_sl']) { echo "selected"; }?>> <?php echo $res_searchlight_size['searchlight_size_name'];?>  </option>
<?php
}	?>

</select>
</div>

</td>
</tr>
<tr> 
<td colspan="3"> Number of life buoys </td> 
<td colspan="2"> <div class="div100"> <div class="form-group">
<input type="text" name="number8" value="<?php echo $number8; ?>" id="number"  class="form-control"  maxlength="30" autocomplete="off" />
</div> </div></td>
</tr>
<tr> 
<td colspan="3"> Life buoys buoyant apparatus with self-ignited light or with buoyant lanyard </td> 
<td colspan="2"> <div class="div100"> <div class="form-group">
<input type="text" name="number9" value="<?php echo $number9; ?>" id="number"  class="form-control"  maxlength="30" autocomplete="off" />
</div> </div></td>
</tr>


<tr> 
<td colspan="3"> Navigation light particulars </td> 
<td colspan="2"> 

<div class="form-group">




<select name="nav_equipment_id[]" class="form-control select2 div350" multiple="multiple" data-placeholder="Select the list"  >


<option value="">Select</option>
<?php foreach ($navigation_light as $res_navigation_light)
{
foreach($navlightparticulars_equipment as $res){
$equipment_id= $res['equipment_id'];
?>
<option value="<?php echo $res_navigation_light['equipment_sl']; ?>" <?php if($equipment_id==$res_navigation_light['equipment_sl']) { echo "selected"; } ?>> <?php echo $res_navigation_light['equipment_name'];?>  </option>
<?php
}
}?>
</select>


</div>
</td>
</tr>
<tr> 
<td colspan="3"> Sound signals </td> 
<td colspan="2"> 

<div class="form-group">
<select class="form-control select2 div350" multiple="multiple" data-placeholder="Select the list" name="sound_equipment_id[]"  >

<option value="">Select</option>
<?php foreach ($sound_signals as $res_sound_signals)
{
foreach($soundsignals_equipment as $res){
$equipment_id= $res['equipment_id'];

?>
<option value="<?php echo $res_sound_signals['equipment_sl']; ?>" <?php if($equipment_id==$res_sound_signals['equipment_sl']) { echo "selected"; } ?>> <?php echo $res_sound_signals['equipment_name'];?>  </option>
<?php
}
}?>
</select>
</div>
</td>
</tr>

<tr> <td colspan="5"> 
<button type="button" class="btn btn-info pull-right btn-space" name="tab4next" id="tab4next">Save</button>
<button type="button" class="btn btn-warning pull-right btn-space" name="tab4back" id="tab4back">Back</button>  

</td> </tr>
</table>
</form>     

</div>
<!-- /. end of tab-pane 4-->

<!-- _________________________  Particulars of Fire Appliance _________________________  -->

<div class="tab-pane" id="tab_5">
<form name="form5" id="form5" method="post"> 
<input type="hidden" name="id1_fire" value="<?php echo $id1_fire; ?>">
<input type="hidden" name="id2_fire" value="<?php echo $id2_fire; ?>">
<input type="hidden" name="id3_fire" value="<?php echo $id3_fire; ?>">
<input type="hidden" name="vessel_id" value="<?php echo $vessel_id; ?>" id="">
<input type="hidden" name="stage_count" value="<?php echo $stage_count; ?>" id=""> 
<table id="vacbtable" class="table table-bordered table-striped">
  <tr>
  <td colspan="5"> Fire pumps</td>
  </tr>
  <tr> 
    <td colspan="2"> </td> 
    <td> Number </td> 
    <td> Capacity </td>
    <td> Size</td> 
  </tr>
  <?php
  foreach($firepump_details as $res_firepumptype)
  {
  $number1_firepump   = $res_firepumptype['number'];
  $capacity1_firepump = $res_firepumptype['capacity'];
  $firepumpsize_id1   = $res_firepumptype['firepumpsize_id'];

  ?>
  <tr> 
    <td colspan="2" align="right"><input type="hidden" name="firepumptype_sl1[]" value="<?php echo $res_firepumptype['firepumps_details_sl']; ?>"><?php echo $res_firepumptype['firepumptype_name']; ?> </td> 
    <td>   <div class="div100"> <div class="form-group">
    <input type="text" name="number1[]" value="<?php echo $number1_firepump; ?>" id="number"  class="form-control"  maxlength="30" autocomplete="off" />
    </div> </div></td> 

    <td> <div class="div150"> <div class="input-group">
    <input type="text" name="capacity1[]" value="<?php echo $capacity1_firepump; ?>" id="capacity"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">m<sup>3</sup>/hr</span>
    </div> </div> </td> 
    <td>  
    <div class="form-group">
    <select class="form-control select2 div200" name="firepumpsize_id1[]" id="size" >
    <option value="">Select</option>
    <?php foreach ($firepumpsize as $res_firepumpsize)
    {
    ?>
    <option value="<?php echo $res_firepumpsize['firepumpsize_sl']; ?>" <?php if($firepumpsize_id1==$res_firepumpsize['firepumpsize_sl']) { echo "selected"; } ?>> <?php echo $res_firepumpsize['firepumpsize_name'];?>  </option>
    <?php
    }
    ?>
    </select>
    </div>
    </td> 
  </tr>
  <?php
  }
  ?>

  <tr> 
    <td  colspan="2"> Material of fire mains </td>
    <td > 
    <div class="form-group">
    <select class="form-control select2 div200"  data-placeholder="Select the list" name="material_id1" >
    <?php foreach ($equipment_material as $res_equipment_material)
    {
    ?>
    <option value="<?php echo $res_equipment_material['equipment_material_sl']; ?>" <?php if($material_id1_firemains==$res_equipment_material['equipment_material_sl']) { echo "selected"; } ?>> <?php echo $res_equipment_material['equipment_material_name'];?>  </option>
    <?php
    }
    ?>
    </select>
    </div>
    </td>
    <td > Diameter of fire mains</td>
    <td > 
    <div class="div100"><div class="input-group">
    <input type="text" name="diameter1" value="<?php echo $diameter1; ?>" id="diameter"  class="form-control"  maxlength="30" autocomplete="off"  /><span class="input-group-addon">mm</span>
    </div></div>
    </td>
  </tr> 

  <tr> 
    <td  colspan="2"> Number of hydrants </td>
    <td > <div class="div100"> <div class="form-group">
    <input type="text" name="number2" value="<?php echo $number_hydrants; ?>" id="number_hydrant"  class="form-control"  maxlength="30" autocomplete="off"/>
    <div> </div> </td>
    <td > Number of hose</td>
    <td > <div class="div100"><div class="form-group">
    <input type="text" name="number3" value="<?php echo $number_hose; ?>" id="number_hose" readonly="readonly"  class="form-control"  maxlength="30" autocomplete="off"  />
    </div></div>
    </td>
  </tr>

  <tr> 
    <td colspan="3">  Nozzles </td> 
    <td colspan="2"> 
    <div class="form-group">
    <select class="form-control select2 div350" multiple="multiple" data-placeholder="Select the list" name="nozzle_type[]" >
    <option value="">Select</option>
    <?php foreach ($nozzletype as $res_nozzletype)
    {
    foreach($nozzletype_equipment as $result)
    {
    $equipment_id=$result['equipment_id'];   

    ?>
    <option value="<?php echo $res_nozzletype['equipment_sl']; ?>" <?php if($equipment_id==$res_nozzletype['equipment_sl']) {echo "selected"; }?>> <?php echo $res_nozzletype['equipment_name'];?>  </option>
    <?php
    }
    }	?>
    </select>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="5"> Portable fire extinguishers</td> 
  </tr>
  <?php 
  $j=1;

  foreach($portable_fire_devices as $res_portable) 
  {
  $fire_extinguisher_sl       =   $res_portable['fire_extinguisher_sl'];
  $fire_extinguisher_type_id  =   $res_portable['fire_extinguisher_type_id'];
  $fire_extinguisher_number   =   $res_portable['fire_extinguisher_number'];
  $fire_extinguisher_capacity =   $res_portable['fire_extinguisher_capacity'];

  ?> 
  <tr>
    <td>&nbsp; </td>
    <td colspan="2">
    <input type="hidden" value="<?php echo $fire_extinguisher_sl; ?>" name="fire_extinguisher_sl[]">
    <input type="hidden" value="<?php echo $fire_extinguisher_type_id; ?>" name="fire_extinguisher_type_id[]"> <?php echo $j; ?>.&nbsp;<?php echo $res_portable['portable_fire_extinguisher_name']?> 
    </td> 
    <td> 
    <div class="div100"> <div class="form-group">
    <input type="text" name="fire_extinguisher_number[]" value="<?php echo $fire_extinguisher_number; ?>" id="fire_extinguisher_number"  class="form-control"  maxlength="30" autocomplete="off" placeholder="Number" />
    </div> </div></td>
    <td> 
    <div class="div100"> <div class="form-group">
    <input type="text" name="fire_extinguisher_capacity[]" value="<?php echo $fire_extinguisher_capacity; ?>" id="fire_extinguisher_capacity"  class="form-control"  maxlength="30" autocomplete="off" placeholder="Capacity" />
    </div> </div></td>
  </tr>
  <?php
  $j++;
  }
  ?>
  <tr>
    <td colspan="5"> 
    <button type="button" class="btn btn-info pull-right btn-space" name="tab5next" id="tab5next">Save</button>
    <button type="button" class="btn btn-warning pull-right btn-space" name="tab5back" id="tab5back">Back</button>  
    </td> 
  </tr>
</table>

</form>

</div>
<!-- /. end of tab-pane 5-->

              
<!-- _________________________  Other Equipment _________________________  -->

<div class="tab-pane" id="tab_6">
<form name="form6" id="form6" method="post">  
<input type="hidden" name="vessel_id" value="<?php echo $vessel_id; ?>" id="">
<input type="hidden" name="stage_count" value="<?php echo $stage_count; ?>" id=""> 
<table id="vacbtable" class="table table-bordered table-striped">
  <tr> 
    <td colspan="3"> Particulars of communication equipments  </td> 
    <td colspan="2"> 
    <div class="form-group">
    <select class="form-control select2 div500" multiple="multiple" data-placeholder="Select the list" name="list1[]"  >
    <option value="">Select</option>
    <?php foreach ($commnequipment as $res_commnequipment)
    {
    foreach($get_commnequipment_equipment as $res1)
    {
    $equipment_id_commn=$res1['equipment_id'];
    ?>
    <option value="<?php echo $res_commnequipment['equipment_sl']; ?>" <?php if($equipment_id_commn==$res_commnequipment['equipment_sl']) { echo "selected"; } ?>> <?php echo $res_commnequipment['equipment_name'];?>  </option>
    <?php
    }	
    }	
    ?>
    </select>
    </div>
    </td>
  </tr>

  <tr> 
    <td colspan="3"> Particulars of navigation equipments </td> 
    <td colspan="2"> 
    <div class="form-group">
    <select class="form-control select2 div500" multiple="multiple" data-placeholder="Select the list" name="list2[]" >
    <option value="">Select</option>
    <?php foreach ($navgnequipments as $res_navgnequipments)
    {

    foreach($get_navgnequipments_equipment as $res2)
    {
    $equipment_id_navgn=$res2['equipment_id']; 

    ?>
    <option value="<?php echo $res_navgnequipments['equipment_sl']; ?>" <?php if($equipment_id_navgn==$res_navgnequipments['equipment_sl']) { echo "selected"; } ?>> <?php echo $res_navgnequipments['equipment_name'];?>  </option>
    <?php
    }	}	?>
    </select>
    </div>
    </td>
  </tr>

  <tr> 
    <td colspan="3"> Type of pollution control devices </td> 
    <td colspan="2"> 
    <div class="form-group">
    <select class="form-control select2 div500" multiple="multiple" data-placeholder="Select the list" name="list3[]" >
    <option value="">Select</option>
    <?php foreach ($pollution_controldevice as $res_pollution_controldevice)
    {
    foreach($get_pollncntrl_equipment as $res3)
    {
    $equipment_id_polln=$res3['equipment_id'];   
    ?>
    <option value="<?php echo $res_pollution_controldevice['equipment_sl']; ?>" <?php if($equipment_id_polln==$res_pollution_controldevice['equipment_sl']) { echo "selected"; } ?>> <?php echo $res_pollution_controldevice['equipment_name'];?>  </option>
    <?php
    }
    }	
    ?>
    </select>
    </div>
    </td>
  </tr>

  <tr>
    <td> (Tick whether applicable) </td>
    <td colspan="4"> 
    <div class="col-md-12">
    <div class="form-group">
    <label>
    <input type="checkbox" class="minimal" name="sewage_treatment" value="1" <?php echo ($sewage_treatment== 1) ?  "checked" : "" ;  ?>> &nbsp;&nbsp;&nbsp;Whether there is sewage treatment and disposal
    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label>
    <input type="checkbox" class="minimal" name="solid_waste"  value="1" <?php echo ($solid_waste== 1) ?  "checked" : "" ;  ?>> &nbsp;&nbsp;&nbsp;Whether there is solid waste processing and disposal
    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label>
    <input type="checkbox" class="minimal" name="sound_pollution"  value="1" <?php echo ($sound_pollution== 1) ?  "checked" : "" ;  ?>> &nbsp;&nbsp;&nbsp;Whether there is sound pollution control 
    </label>
    </div>
    </div>
    </td>
  </tr>

  <tr>  
    <td colspan="2"> Water consumption per day </td> 
    <td> <div class="div100"> <div class="input-group">
    <input type="text" name="water_consumption" value="<?php echo $water_consumption; ?>" id="water_consumption"  class="form-control"  maxlength="30" autocomplete="off"  /><span class="input-group-addon">L</span>
    </div> </div></td>
    <td> Source of water </td>
    <td> 
    <div class="form-group">
    <select class="form-control select2 div200" name="source_of_water" id="source_of_water" >
    <option value="">Select</option>
    <?php foreach ($sourceofwater as $res_sourceofwater)
    {
    ?>
    <option value="<?php echo $res_sourceofwater['sourceofwater_sl']; ?>" <?php if($source_of_water==$res_sourceofwater['sourceofwater_sl']) { echo "selected"; }  ?>> <?php echo $res_sourceofwater['sourceofwater_name'];?>  </option>
    <?php
    }
    ?>
    </select>
    </div>
    <!-- /.form-group -->
    </td>
  </tr>
  <tr> 
    <td colspan="5"> 
    <button type="button" class="btn btn-info pull-right btn-space" name="tab6next" id="tab6next">Save</button>
    <button type="button" class="btn btn-warning pull-right btn-space" name="tab6back" id="tab6back">Back</button>  
    </td> 
  </tr>
</table>
</form>
</div>
<!-- /. end of tab-pane 6-->
            
<!-- _________________________  Documents _________________________  -->
<div class="tab-pane" id="tab_7">


<form name="form7" id="form7" method="post" action="" enctype="multipart/form-data">  
<input type="hidden" name="vessel_id" value="<?php echo $vessel_id; ?>" id="">
<input type="hidden" name="stage_count" value="<?php echo $stage_count; ?>" id=""> 
<table id="vacbtable" class="table table-bordered table-striped">
  <?php
  $i=1;
  foreach($list_document_vessel as $res_list_document)
  {
  $document_sl=$res_list_document['document_sl'];
  $doc_file= 	$this->Survey_model->get_doc_file_edit($vessel_id, $document_sl);

  $document_id= @$doc_file->document_id;
  $filename= @$doc_file->document_name;
  $fileupload_details_sl=@$doc_file->fileupload_details_sl;

  if($filename==NULL)
  {
  $msg_disp='<font color="#7a29c6">  <b> No </b>  </font>';
  }
  else {
  $msg_disp='<font color="#7a29c6"> <a href="'.base_url().'uploads/survey/'.$document_id.'/'.$filename.'" download> <b> View </b> </a> </font>';
  }
  ?>
  <tr>
    <td >
    <input type="hidden" value="<?php echo $fileupload_details_sl; ?>" id="" name="fileupload_details_sl<?php echo $i;  ?>">
    <?php echo $res_list_document['document_name']; ?><input type="hidden" name="document_id<?php echo $i;  ?>" value="<?php echo $res_list_document['document_sl']; ?>"> </td>
    <td colspan="4"> 
    <div class="div400">
    <label class="btn bg-green btn-sm" for="my-file-selector<?php echo $i; ?>">
    <input id="my-file-selector<?php echo $i; ?>" type="file" style="display:none" name="myFile<?php echo $i;  ?>"  onchange="$('#upload-file-info'+<?php echo $i; ?>).html(this.files[0].name)"> Upload File  </label>
    <span class="label label-info"  id="upload-file-info<?php echo $i; ?>"></span>
    </div> <?php echo $msg_disp; ?>
    </td>
  </tr>
  <?php
  $i++;
  }
  ?>
  <tr>
    <td>Preferred Inspection date</td>
    <td colspan="4" > 
    <div class="div250">
    <div class="form-group">
    <div class="input-group date">
    <div class="input-group-addon">
    <i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control" id="datepicker3" name="vessel_pref_inspection_date" value="<?php echo $pref_date; ?>">
    </div>
    </div>
    </div>
    </td>
  </tr>  

  <tr>
    <td colspan="5"> 
    <button type="button" class="btn btn-info pull-right btn-space" name="tab7next" id="tab7next">Save</button>
    <button type="button" class="btn btn-warning pull-right btn-space" name="tab7back" id="tab7back">Back</button>  
    </td>
  </tr>
</table>
</form>
</div>
<!-- /. end of tab-pane 7--> 
              
<!---------------------- Payment Details--------------------------------- --> 
<div class="tab-pane" id="tab_8">
<form name="form8" id="form8" method="post">  
<input type="hidden" name="vessel_id" value="<?php echo $vessel_id; ?>" id="">
<input type="hidden" name="stage_count" value="<?php echo $stage_count; ?>" id=""> 
<table id="vacbtable" class="table table-bordered table-striped">
  <tr> 
    <td colspan="2"><input type="hidden" name="payment_sl" value="<?php echo $payment_sl; ?>" id="payment_sl" > Payment Type</td>
    <td colspan="3"> 
    <div class="form-group">
    <select class="form-control select2 div200" name="paymenttype_id" id="paymenttype_id" >
    <option value="">Select</option>
    <?php foreach ($paymenttype as $res_paymenttype)
    {
    ?>
    <option value="<?php echo $res_paymenttype['paymenttype_sl']; ?>" <?php  if($paymenttype_id==$res_paymenttype['paymenttype_sl']) { echo "selected"; }  ?>> <?php echo $res_paymenttype['paymenttype_name'];?>  </option>
    <?php
    }	
    ?>
    </select>
    </div>
    <!-- /.form-group -->
    </td>
  </tr>

  <tr>
    <td> DD Amount </td>
    <td> 
    <div class="div150">
    <div class="input-group">
    <span class="input-group-addon"><i class="fa fa-inr"></i></span>
    <input type="text" class="form-control" name="dd_amount" value="<?php echo $dd_amount; ?>" id="dd_amount" maxlength="8" autocomplete="off">
    </div>
    </div>
    </td> 
    <td> DD Number </td>
    <td><div class="div100"> <div class="form-group">
    <input type="text" name="dd_number" value="<?php echo $dd_number; ?>" id="dd_number"  class="form-control"  maxlength="6" autocomplete="off"  />&nbsp;6 digits
    </div> </div>
    </td>
  </tr>
  <tr> 
    <td> DD Date </td> 
    <td> <div class="div250">
    <div class="form-group">
    <div class="input-group date">
    <div class="input-group-addon">
    <i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control" id="datepicker1" name="dd_date" value="<?php echo $dd_date; ?>" >
    </div>
    <!-- /.input group -->
    </div>
    <!-- /.form group -->
    </div></td> 
    <td> Favoring </td> 
    <td> <div class="form-group">
    <select class="form-control select2 div200" name="portofregistry_id" id="portofregistry_id" >
    <option value="">Select</option>
    <?php foreach ($portofregistry as $res_portofregistry)
    {
    ?>
    <option value="<?php echo $res_portofregistry['portofregistry_sl']; ?>" <?php  if($portofregistry_id==$res_portofregistry['portofregistry_sl']) { echo "selected"; }  ?>> <?php echo $res_portofregistry['portofregistry_name'];?>  </option>
    <?php
    }	
    ?>
    </select>
    </div>
    <!-- /.form-group --> 
    </td> 
  </tr>
  <tr> 
    <td> Bank </td> 
    <td><div class="form-group">
    <select class="form-control select2 div200" name="bank_id">
    <option value="">Select</option>
    <?php foreach ($bank as $res_bank)
    {
    ?>
    <option value="<?php echo $res_bank['bank_sl']; ?>" <?php if($bank_id==$res_bank['bank_sl']) { echo "selected"; }  ?>> <?php echo $res_bank['bank_name'];?>  </option>
    <?php
    }	
    ?>
    </select>
    </div>
    <!-- /.form-group --> </td>
    <td> Payable at </td> <td><div class="div250"> <div class="form-group">
    <input type="text" name="branch_name" value="<?php echo $branch_name; ?>" id="branch_name"  class="form-control"  maxlength="50" autocomplete="off"  />&nbsp;Branch Name
    </div> </div> 
    </td> 
  </tr>

  <tr> 
    <td colspan="5"> 
    <button type="button" class="btn btn-info pull-right btn-space" name="tab8next" id="tab8next">Submit</button>
    <button type="button" class="btn btn-warning pull-right btn-space" name="tab8back" id="tab8back">Back</button>  
    </td> 
  </tr>

</table>
</form>
</div>

<!-- /. end of tab-pane 8-->   

                </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
     </div>
     <!-- End of Row Custom-Inner -->
  <!-- Main Content Ends here -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->