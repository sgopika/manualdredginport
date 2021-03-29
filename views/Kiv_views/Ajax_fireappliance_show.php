

<?php
$firepumptype                   =   $this->Survey_model->get_firepumptype();
$data1['firepumptype']          =   $firepumptype;

$bilgepumptype                  =   $this->Survey_model->get_bilgepumptype();
$data1['bilgepumptype']         =   $bilgepumptype;

$firepumpsize                   =   $this->Survey_model->get_firepumpsize();
$data1['firepumpsize']          =   $firepumpsize;

$nozzletype                     =   $this->Survey_model->get_nozzletype();
$data1['nozzletype']            =   $nozzletype;

$portable_fire_ext              =   $this->Survey_model->get_portable_fire_ext();
$data1['portable_fire_ext']     =   $portable_fire_ext;

$equipment_material             =   $this->Survey_model->get_equipment_material();
$data1['equipment_material']    =   $equipment_material;

?>




<?php 
$heading_id1=5;
$form_id=1;
$label_details=$this->Survey_model->get_label_details_ajax($form_id,$heading_id1);
$data['label_details']=$label_details;
$static_array = array_column($label_details, 'label_sl');  

  $i=1;
    if(!empty($label_control_details))
    {   
        $var_row=0;
$var_color=0;// 0-odd, 1-even
        foreach ($label_control_details as $key) {


         

$label_id1=$key['label_id'];
if($label_id1==51)
{
      @$value_id51=$key['value_id'];
}
else
{
    @$value_id51='';
}

$value46='<div class="row">
                <div class="col-3 d-flex justify-content-center">Name</div>     <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Number</div>   <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Capacity</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Size</div>     <!-- end of div col -->
                </div>';
$j=1;
foreach($firepumptype as $res_firepumptype)
{

  if($j%2==1)
  $style      ='eventab';
   else
     $style      ='oddtab';
      
    $value46.='<div class="row mt-1 mb-1 '. $style.' " >
                <div class="col-3 d-flex justify-content-center"> '. $key['label_name'].'-'.$res_firepumptype['firepumptype_name'].'   <input type="hidden" name="firepumptype_sl1[]" value="'. $res_firepumptype['firepumptype_sl'].'"></div>     <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center"><input type="text" name="number1[]" value="" id="number'.$j.'"  class="form-control"  maxlength="2" autocomplete="off" title="Enter Number of '. $res_firepumptype['firepumptype_name'].'" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return Isdot(this.id);"  onpaste="return false;"/></div>   <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center"> 
                <div class="input-group">
                <input type="text" name="capacity1[]" value="" id="capacity'.$j.'"  class="form-control"  maxlength="5" autocomplete="off"  title="Enter Capacity of '. $res_firepumptype['firepumptype_name'].'"  onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);"  onpaste="return false;"/>

               
                    <div class="input-group-append">
                    <div class="input-group-text">m<sup>3</sup>/hr</div>  <!-- end of text -->
                    </div> <!-- end of input group append -->
                    </div> <!-- end of input-group -->
                    </div> <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center"> <select class="form-control select2 " name="firepumpsize_id1[]" id="size1"  title="Select Size of '. $res_firepumptype['firepumptype_name'].'" >
                    <option value="">Select</option>';
                foreach ($firepumpsize as $res_firepumpsize)
                        {
                    
              $value46.=' <option value="'.$res_firepumpsize['firepumpsize_sl'].'"> '. $res_firepumpsize['firepumpsize_name'].'  </option>';
                  }   
                $value46.='</select></div>     <!-- end of div col -->
                </div>';

$j++;
}
$value46.='<input type="hidden" name="firepump_count" value="'.($j-1).'">';  


$value47= ' <div class="row">
             <div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
             <div class="col-6 d-flex justify-content-center">

                  <div class="form-group mt-2 mb-2">
                  <select class="form-control select2"  data-placeholder="Select the list" name="material_id1" title="Select Material of fire mains" data-validation="required" >';

        foreach ($equipment_material as $res_equipment_material)
        {

        $value47.= '<option value="'. $res_equipment_material['equipment_material_sl'].'"> '.$res_equipment_material['equipment_material_name'].' </option>';

        }   
        $value47.='</select>
                  </div>

             </div> <!-- end of col-6 -->
             </div> <!-- end of row -->  ';

$value48= ' <div class="row">
             <div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
             <div class="col-6 d-flex justify-content-center">

                  <div class="form-group mt-2 mb-2">
                  <div class="input-group">
            <input type="text" name="diameter1" value="32" id="diameter1"  class="form-control"  maxlength="30" autocomplete="off" title="Enter Diameter of fire mains" onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);"  onpaste="return false;"/><div class="input-group-append">
                <div class="input-group-text">mm</div> 
            </div> 
            </div>
                  </div>

             </div> <!-- end of col-6 -->
             </div> <!-- end of row -->  ';


$value49= ' <div class="row">
             <div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
             <div class="col-6 d-flex justify-content-center">

                  <div class="form-group mt-2 mb-2">
                   <input type="text" name="number2" value="" id="number_hydrant"  class="form-control"  maxlength="30" autocomplete="off" title="Enter Number of hydrants" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return Isdot(this.id);"  onpaste="return false;"/>
                  </div>

             </div> <!-- end of col-6 -->
             </div> <!-- end of row -->  ';


$value50= ' <div class="row">
             <div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
             <div class="col-6 d-flex justify-content-center">

                  <div class="form-group mt-2 mb-2">
                    <input type="text" name="number3" value="" id="number_hose" readonly="readonly"  class="form-control"  maxlength="30" autocomplete="off"  onchange="return Isdot(this.id);"/>
                  </div>

             </div> <!-- end of col-6 -->
             </div> <!-- end of row -->  ';


$value51= ' <div class="row">
             <div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
             <div class="col-6 d-flex justify-content-center">

                  <div class="form-group mt-2 mb-2">




                        <select class="form-control select2" multiple="multiple" data-placeholder="Select the list" name="nozzle_type[]" data-validation="required" >


                  <option value="">Select</option>';
                 foreach ($nozzletype as $res_nozzletype)
                {
                    if($res_nozzletype['equipment_sl']==$value_id51) 
                    {
                
               $value51.='<option value="'. $res_nozzletype['equipment_sl'].'" selected> '.$res_nozzletype['equipment_name'].' </option>';
                    }
                    else
                    {
             $value51.='  <option value="'. $res_nozzletype['equipment_sl'].'"> '. $res_nozzletype['equipment_name'].'  </option>';
                    }
                
                }  
                $value51.='</select>
                  </div>

             </div> <!-- end of col-6 -->
             </div> <!-- end of row -->  ';




$value82='<div class="row">
                <div class="col-3 d-flex justify-content-center">Name</div>     <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Number</div>   <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Capacity</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Size</div>     <!-- end of div col -->
                </div>';
$j=1;
foreach($bilgepumptype as $res_bilgepumptype)
 {

  if($j%2==1)
  $style      ='oddtab';
   else
     $style      ='eventab';

    $value82.='<div class="row mt-1 '. $style.' "">
                <div class="col-3 d-flex justify-content-center"> '. $key['label_name'].'-'.$res_bilgepumptype['bilgepumptype_name'].'  <input type="hidden" name="bilgepumptype_sl[]" value="'.$res_bilgepumptype['bilgepumptype_sl'].'"></div>     <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center">
               <input type="text" name="number_bilge[]" value="" id="number_bilge'.$j.'"  class="form-control"  maxlength="2" autocomplete="off" title="Enter Number of '. $res_firepumptype['firepumptype_name'].'" data-validation="required"  onkeypress="return IsNumeric(event);" onchange="return Isdot(this.id);"/>
                </div>   <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center"> 
                <div class="input-group">
                <input type="text" name="capacity_bilge[]" value="" id="capacity_bilge'.$j.'"  class="form-control"  maxlength="5" autocomplete="off" title="Enter Capacity of '. $res_firepumptype['firepumptype_name'].'"    onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);"/>

               
                    <div class="input-group-append">
                    <div class="input-group-text">m<sup>3</sup>/hr</div>  <!-- end of text -->
                    </div> <!-- end of input group append -->
                    </div> <!-- end of input-group -->
                    </div> <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center">  <select class="form-control select2" name="firepumpsize_id_bilge[]" id="size" title="Select Size of '. $res_firepumptype['firepumptype_name'].'"  >
                 
                    <option value="">Select</option>';
                 foreach ($firepumpsize as $res_firepumpsize)
                        {
                    
              $value82.='<option value="'.$res_firepumpsize['firepumpsize_sl'].'"> '. $res_firepumpsize['firepumpsize_name'].'  </option>';
                
                        }   
                  
                $value82.='</select></div>     <!-- end of div col -->
                </div>';

$j++;
}
$value82.='<input type="hidden" name="bilgepump_count" value="'.($j-1).'">';  




$value52='<div class="row">
                <div class="col-4 d-flex justify-content-center">Name</div>     <!-- end of div col -->
                <div class="col-4 d-flex justify-content-center">Number</div>   <!-- end of div col -->
                <div class="col-4 d-flex justify-content-center">Capacity</div> <!-- end of div col -->
                </div>';
$j=1;
foreach($portable_fire_ext as $result_port)
 {

  if($j%2==1)
  $style      ='eventab';
   else
     $style      ='oddtab';

    $value52.='<div class="row mt-1 mb-1 '.$style.'">
                <div class="col-4 d-flex justify-content-center"> '. $key['label_name'].'-'.$result_port['portable_fire_extinguisher_name'].'  <input type="hidden" name="fire_extinguisher_type_id[]" value="'.$result_port['portable_fire_extinguisher_sl'].'"> </div>     <!-- end of div col -->

                <div class="col-4 d-flex justify-content-center">
              <input type="text" name="fire_extinguisher_number[]" value="" id="fire_extinguisher_number'.$j.'"  class="form-control"  maxlength="30" autocomplete="off" placeholder="Number" title="Enter Number of '.$result_port['portable_fire_extinguisher_name'].'" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return Isdot(this.id);"/>
                </div>   <!-- end of div col -->

                <div class="col-4 d-flex justify-content-center"> 
               <input type="text" name="fire_extinguisher_capacity[]" value="" id="fire_extinguisher_capacity'.$j.'"  class="form-control"  maxlength="30" autocomplete="off" placeholder="Capacity" title="Enter Capacity of '. $result_port['portable_fire_extinguisher_name'].'"  onkeypress="return IsDecimal(event);" onchange="return Isdot(this.id);"/>
               
                    </div> <!-- end of input-group -->
                    </div> <!-- end of div col -->
';

$j++;
}


$value52.='<input type="hidden" name="fireext_count" value="'.($j-1).'">';  



    $label_id=$key['label_id'];
    //$static_array=array(46,47,48,49,50,51,52,82);
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
 
   }
  
}
?>


 <script type="text/javascript">
  $(document).ready(function() {
          $('.select2').select2({ width:'resolve' });
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


<script>
    $("#number_hydrant").change(function(){
      var hydrant= $("#number_hydrant").val();
      $("#number_hose").val(hydrant);
      
       });
      
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
</script>