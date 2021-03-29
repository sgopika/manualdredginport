 <script type="text/javascript">
  $(document).ready(function() {
          $('.select2').select2({ width: 'resolve' });

      });

  (function($){ 
  $('.dob').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
  });
  
})(jQuery);


 </script>
<?php

$equipment_details              =   $this->Survey_model->get_equipment_details();
$data1['equipment_details']     =   $equipment_details; 

$equipment_material             =   $this->Survey_model->get_equipment_material();
$data1['equipment_material']    =   $equipment_material; 

$equipment_type                 =   $this->Survey_model->get_equipment_type();
$data1['equipment_type']        =   $equipment_type;

$chainport_type                 =   $this->Survey_model->get_chainport_type();
$data1['chainport_type']        =   $chainport_type;

$searchlight_size               =   $this->Survey_model->get_searchlight_size();
$data1['searchlight_size']      =   $searchlight_size;

$navigation_light               =   $this->Survey_model->get_navigation_light();
$data1['navigation_light']      =   $navigation_light;

$sound_signals                  =   $this->Survey_model->get_sound_signals();
$data1['sound_signals']         =   $sound_signals;

$rope_material                  =   $this->Survey_model->get_rope_material();
$data1['rope_material']         =   $rope_material;

$heading_id1=4;
$form_id=1;
$label_details=$this->Survey_model->get_label_details_ajax($form_id,$heading_id1);
$data['label_details']=$label_details;
$static_array = array_column($label_details, 'label_sl');
 
// print_r($label_control_details);
    $i=1;
    if(!empty($label_control_details))
    {   
      
      $var_row=0;
$var_color=0;// 0-odd, 1-even

foreach ($label_control_details as $key) {

$label_id1=$key['label_id'];
if($label_id1==44)
{
      @$value_id44=$key['value_id'];
}
else
{
    @$value_id44='';
}


         $value35='
                <div class="row">
                <div class="col-4"></div>
                <div class="col-4 d-flex justify-content-center">Weight</div> <!-- end of div col -->
                <div class="col-4 d-flex justify-content-center">Material</div> <!-- end of div col -->
                </div>
                <div class="row">
                <div class="col-4 d-flex justify-content-center">'.$key['label_name'].'</div> <!-- end of div col -->
                <div class="col-4 d-flex justify-content-center">
                <div class="form-group mt-2 mb-2">
                <div class="input-group">
                   <input type="text" name="weight1" value="" id="weight1"  class="form-control "  maxlength="5" autocomplete="off" title="Enter Weight of Anchor Port"  onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);" />
                   <div class="input-group-append">
                   <div class="input-group-text">Kg</div>  <!-- end of text -->
                   </div> <!-- end of input group append -->
                </div> <!-- end of input-group -->
                </div> <!-- end of form-group -->
                </div> <!-- end of div col -->
                <div class="col-4 d-flex justify-content-center">
                  <div class="form-group mt-2 mb-2">
                    <select class="form-control select2" name="material_id1" id="material_id1" title="Select Material of Anchor Port">';
                        foreach ($equipment_material as $res_equipment_material) {
                            $value35.= '<option value="'.$res_equipment_material['equipment_material_sl'].'"> '.$res_equipment_material['equipment_material_name'].' </option>'; }   
                    $value35.= '</select>
                    </div> <!-- end of div form-group select -->
                </div> <!-- end of div col --> </div> <!-- end of row --> ';




$value36='
                <div class="row">
                <div class="col-4"></div>
                <div class="col-4 d-flex justify-content-center">Weight</div> <!-- end of div col -->
                <div class="col-4 d-flex justify-content-center">Material</div> <!-- end of div col -->
                </div>
                <div class="row">
                <div class="col-4 d-flex justify-content-center">'.$key['label_name'].'</div> <!-- end of div col -->
                <div class="col-4 d-flex justify-content-center">
                <div class="form-group mt-2 mb-2">
                <div class="input-group">
                   <input type="text" name="weight2" value="" id="weight2"  class="form-control "  maxlength="5" autocomplete="off" title="Enter Weight of Anchor Starboard"  onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);" />
                   <div class="input-group-append">
                   <div class="input-group-text">Kg</div>  <!-- end of text -->
                   </div> <!-- end of input group append -->
                </div> <!-- end of input-group -->
                </div> <!-- end of form-group -->
                </div> <!-- end of div col -->
                <div class="col-4 d-flex justify-content-center">
                  <div class="form-group mt-2 mb-2">
                    <select class="form-control select2" name="material_id2" id="material_id2" title="Select Material of Anchor Starboard" >';
                        foreach ($equipment_material as $res_equipment_material) {
                            $value36.= '<option value="'.$res_equipment_material['equipment_material_sl'].'"> '.$res_equipment_material['equipment_material_name'].' </option>'; }   
                    $value36.= '</select>
                    </div> <!-- end of div form-group select -->
                </div> <!-- end of div col --> </div> <!-- end of row --> ';

$value37='
                <div class="row">
                <div class="col-4"></div>
                <div class="col-4 d-flex justify-content-center">Weight</div> <!-- end of div col -->
                <div class="col-4 d-flex justify-content-center">Material</div> <!-- end of div col -->
                </div>
                <div class="row">
                <div class="col-4 d-flex justify-content-center">'.$key['label_name'].'</div> <!-- end of div col -->
                <div class="col-4 d-flex justify-content-center">
                <div class="form-group mt-2 mb-2">
                <div class="input-group">
                  <input type="text" name="weight3" value="" id="weight3"  class="form-control "  maxlength="5" autocomplete="off" title="Enter Weight of Anchor Spare"  onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);" />
                   <div class="input-group-append">
                   <div class="input-group-text">Kg</div>  <!-- end of text -->
                   </div> <!-- end of input group append -->
                </div> <!-- end of input-group -->
                </div> <!-- end of form-group -->
                </div> <!-- end of div col -->
                <div class="col-4 d-flex justify-content-center">
                  <div class="form-group mt-2 mb-2">
                    <select class="form-control select2" name="material_id3" id="material_id3" title="Select Material of Anchor Spare" >';
                        foreach ($equipment_material as $res_equipment_material) {
                            $value37.= '<option value="'.$res_equipment_material['equipment_material_sl'].'"> '.$res_equipment_material['equipment_material_name'].' </option>'; }   
                    $value37.= '</select>
                    </div> <!-- end of div form-group select -->
                </div> <!-- end of div col --> </div> <!-- end of row --> ';





$value38='
                <div class="row">
                <div class="col-3"></div>
                <div class="col-3 d-flex justify-content-center">Length</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Size</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Type</div> <!-- end of div col -->
                </div>

                <div class="row">
                <div class="col-3 d-flex justify-content-center">'.$key['label_name'].'</div> <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center">

                      <div class="form-group mt-2 mb-2">
                      <div class="input-group">
                      <input type="text" name="length4" value="" id="length4"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Length of Chain Port"  onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);"/>
                      <div class="input-group-append">
                      <div class="input-group-text">m</div>  <!-- end of text -->
                      </div> <!-- end of input group append -->
                      </div> <!-- end of input-group -->
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col -->


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                      <div class="input-group">
                      <input type="text" name="size4" value="" id="size4"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Length of Chain Port"  onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);"/>
                      <div class="input-group-append">
                      <div class="input-group-text">mm</div>  <!-- end of text -->
                      </div> <!-- end of input group append -->
                      </div> <!-- end of input-group -->
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col --> 


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                     <select class="form-control select2 " name="chainport_type_id4" id="chainport_type_id" title="Select Type of Chain Port" >
                 <option value="">Select</option>';
                foreach ($chainport_type as $res_chainport_type)
                        {
               $value38.='<option value="'.$res_chainport_type['chainporttype_sl'].'"> '. $res_chainport_type['chainporttype_name'].'  </option>';
                        }   
                $value38.='</select>
                      </div> <!-- end of div form-group select -->
                      </div> <!-- end of col-3 -->


                </div> <!-- end of row --> ';





$value39='
                <div class="row">
                <div class="col-3"></div>
                <div class="col-3 d-flex justify-content-center">Length</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Size</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Type</div> <!-- end of div col -->
                </div>

                <div class="row">
                <div class="col-3 d-flex justify-content-center">'.$key['label_name'].'</div> <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center">

                      <div class="form-group mt-2 mb-2">
                      <div class="input-group">
                       <input type="text" name="length5" value="" id="length5"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Length of Chain Starboard" onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);"  onpaste="return false;"/>
                      <div class="input-group-append">
                      <div class="input-group-text">m</div>  <!-- end of text -->
                      </div> <!-- end of input group append -->
                      </div> <!-- end of input-group -->
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col -->


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                      <div class="input-group">
                      <input type="text" name="size5" value="" id="size5"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Size of Chain Starboard"  onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);"  onpaste="return false;"/>
                      <div class="input-group-append">
                      <div class="input-group-text">mm</div>  <!-- end of text -->
                      </div> <!-- end of input group append -->
                      </div> <!-- end of input-group -->
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col --> 


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                      <select class="form-control select2" name="chainport_type_id5" id="chainport_type_id" title="Select Type of Chain Starboard">
        <option value="">Select</option>';
        foreach ($chainport_type as $res_chainport_type)
        {
        $value39.='<option value="'.$res_chainport_type['chainporttype_sl'].'"> '. $res_chainport_type['chainporttype_name'].'  </option>';
        }   
        $value39.='</select>
                      </div> <!-- end of div form-group select -->
                      </div> <!-- end of col-3 -->


                </div> <!-- end of row --> ';

$value40='
                <div class="row">
                <div class="col-3"></div>
                <div class="col-3 d-flex justify-content-center">Number</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Size</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Material</div> <!-- end of div col -->
                </div>

                <div class="row">
                <div class="col-3 d-flex justify-content-center">'.$key['label_name'].'</div> <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center">

                      <div class="form-group mt-2 mb-2">
                      <div class="input-group">
                       <input type="text" name="number6" value="" id="number6"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Number of Rope"  onkeypress="return IsNumeric(event);" onchange="return Isdot(this.id);"  onpaste="return false;"/>
                      
                      
                      </div> <!-- end of input-group -->
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col -->


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                      <div class="input-group">
                      <input type="text" name="size6" value="" id="size6"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Size of Rope" onkeypress="return IsNumeric(event);" onchange="return Isdot(this.id);"  onpaste="return false;"/>
                      <div class="input-group-append">
                      <div class="input-group-text">mm</div>  <!-- end of text -->
                      </div> <!-- end of input group append -->
                      </div> <!-- end of input-group -->
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col --> 


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                      <select class="form-control select2 " name="material_id6" id="material_id" title="Select Material of Rope" >
                 <option value="">Select</option>';
               foreach ($rope_material as $res_rope_material)
                        {
                    
              $value40.='<option value="'.$res_rope_material['ropematerial_sl'].'"> '.$res_rope_material['ropematerial_name'].'  </option>';
                
                        }  
                  
                $value40.='</select>
                      </div> <!-- end of div form-group select -->
                      </div> <!-- end of col-3 -->

                </div> <!-- end of row --> ';

$value41='
                <div class="row">
                <div class="col-3"></div>
                <div class="col-3 d-flex justify-content-center">Number</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Power</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Size</div> <!-- end of div col -->
                </div>

                <div class="row">
                <div class="col-3 d-flex justify-content-center">'.$key['label_name'].'</div> <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center">

                      <div class="form-group mt-2 mb-2">
                     
                        <input type="text" name="number7" value="" id="number7"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Number of Search Light"  onkeypress="return IsNumeric(event);" onchange="return Isdot(this.id);"/>
                      
                      
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col -->


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                      <div class="input-group">
                     <input type="text" name="power7" value="" id="power7"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Power of Search Light"  onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);"  onpaste="return false;"/>
                      <div class="input-group-append">
                      <div class="input-group-text">nm</div>  <!-- end of text -->
                      </div> <!-- end of input group append -->
                      </div> <!-- end of input-group -->
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col --> 


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                      <select class="form-control select2 " name="size7" id="size" title="Select Size of Search Light" >
                   <option value="">Select</option>';
                foreach ($searchlight_size as $res_searchlight_size)
                        {
                
              $value41.= '<option value="'. $res_searchlight_size['searchlight_size_sl'].'">'. $res_searchlight_size['searchlight_size_name'].'</option>';
                
                        }  
                  
              $value41.='  </select>
                      </div> <!-- end of div form-group select -->
                      </div> <!-- end of col-3 -->

                </div> <!-- end of row --> ';

 $value42= ' <div class="row">
             <div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
             <div class="col-6 d-flex justify-content-center">

                  <div class="form-group mt-2 mb-2">
                   <input type="text" name="number8" value="" id="number8"  class="form-control"  maxlength="30" autocomplete="off" title="Enter Number of life buoys" onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);"  onpaste="return false;"/>
                  </div>

             </div> <!-- end of col-6 -->
             </div> <!-- end of row -->  ';
  $value43= ' <div class="row">
             <div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
             <div class="col-6 d-flex justify-content-center">

                  <div class="form-group mt-2 mb-2">
                    <input type="text" name="number9" value="" id="number9"  class="form-control"  maxlength="30" autocomplete="off" title="Enter Number of life buoys buoyant apparatus" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"  onpaste="return false;"/>
                  </div>

             </div> <!-- end of col-6 -->
             </div> <!-- end of row -->  ';
             
 $value44= ' <div class="row">
             <div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
             <div class="col-6 d-flex justify-content-center">

                  <div class="form-group mt-2 mb-2">
                   <select name="nav_equipment_id[]" class="form-control select2 " multiple="multiple" data-placeholder="Select the list" data-validation="required"   >

                  


                 <option value="">Select</option>';

               foreach ($navigation_light as $res_navigation_light)
                        {


                    if($res_navigation_light['equipment_sl']==$value_id44) 
                    {
                
               $value44.='<option value="'. $res_navigation_light['equipment_sl'].'" selected> '.$res_navigation_light['equipment_name'].' </option>';
                    }
                    else
                    {
               $value44.='<option value="'. $res_navigation_light['equipment_sl'].'"> '.$res_navigation_light['equipment_name'].' </option>';
                    }

                   
                        }   
                $value44.='</select>  
                  </div>

             </div> <!-- end of col-6 -->
             </div> <!-- end of row -->  ';

                          
               
 $value45= '<div class="row">
             <div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
             <div class="col-6 d-flex justify-content-center">

                  <div class="form-group mt-2 mb-2">
                  <select name="sound_equipment_id[]" class="form-control select2 " multiple="multiple" data-placeholder="Select the list"   data-validation="required" >
                 <option value="">Select</option>';
              foreach ($sound_signals as $res_sound_signals)
                        {
                
              $value45.=' <option value="'.$res_sound_signals['equipment_sl'].'"> '. $res_sound_signals['equipment_name'].'  </option>';
                
                        }   
              $value45.=' </select>
                  </div>

             </div> <!-- end of col-6 -->
             </div> <!-- end of row -->  ';




    $label_id=$key['label_id'];
   // $static_array=array(35,36,37,38,39,40,41,42,43,44,45,74);
    //$static_array=array(35,36,37,38,39,40,41,42,43,44,45); correct
    if(in_array($label_id,$static_array))
    {
        $g = "value".$label_id;
        $label_controls1= ${$g};
    }
    else
    {
        
        $label_controls1='';
    }
   
   
           
    // Placing Div Elements from here
   
        if($var_color==0){
            $style='oddtab';
            $var_color=1;
        }
        else {
           $style="eventab";
           $var_color=0;
        }
    ?>
    <!-- Creating New Row -->
    <div class="row no-gutters  <?php echo $style; ?>">
    <div class="col-12">
    <?php echo $label_controls1; ?>
    </div> <!-- end of col-12 -->
    </div> <!-- end of row -->
 
<?php
} //End of Foreach


} // end of main IF
?>




<script>
     $("#id_ap1").hide();
      $("#id_ap2").hide();
      $("#id_ap3").hide();
      
     $("#id_cp1").hide(); 
     $("#id_cp2").hide(); 
      $("#no_of_anchor").change(function(){
         var no_of_anchor=$("#no_of_anchor").val();
         if(no_of_anchor>3)
         {
             alert("Invalid Number");
             $("#no_of_anchor").val('');
         }
        
        else
        {
         if(no_of_anchor==1)
         {
                $("#id_ap1").show();
                $("#id_ap2").hide();
                $("#id_ap3").hide();
                $("#id_cp1").show(); 
                $("#id_cp2").hide();
         }
         else
         {
                $("#id_ap1").show();
                $("#id_ap2").show();
                $("#id_ap3").show();
                $("#id_cp1").show(); 
                $("#id_cp2").show();
         }
     }
         
     });

      </script>
      <script>
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

function Isdot(id)
{
  var strvalue=document.getElementById(id).value; 
  if((strvalue=='.'))
  {
    alert("Invalid Number");
   document.getElementById(id).value='';
    document.getElementById(id).focus();
    return false;
  }
}

</script>