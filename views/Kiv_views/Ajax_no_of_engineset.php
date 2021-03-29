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
<!-- Load All Static Controls of Hull Details-->
<?php 

  $inboard_outboard         =   $this->Survey_model->get_inboard_outboard();
  $data['inboard_outboard'] =   $inboard_outboard;

  $model_number             =   $this->Survey_model->get_model_number();
  $data['model_number']     =   $model_number;

  $engine_type              =   $this->Survey_model->get_engine_type();
  $data['engine_type']      =   $engine_type;


  $gear_type          = $this->Survey_model->get_gear_type();
  $data['gear_type']  = $gear_type;

$propulsionshaft_material         = $this->Survey_model->get_propulsionshaft_material();
$data['propulsionshaft_material'] = $propulsionshaft_material;

$heading_id1=3;
$form_id=1;
$label_details          = $this->Survey_model->get_label_details_ajax($form_id,$heading_id1);
$data['label_details']  = $label_details;
$static_array           = array_column($label_details, 'label_sl');

?>


<?php 
//echo $number;
 
 for($k=1; $k<=$number;$k++)
        {
          

     ?>



<div class="d-flex justify-content-end mt-2"><button type="button" class="btn btn-danger btn-sm btn-flat btn-point" name="remove" id="remove<?php echo $k; ?>" onclick="remove_tb(<?php echo $k; ?>)"><i class="fas fa-trash-alt"></i>&nbsp;Remove</button></div>


<div class="col-12 mt-2" id="engine_set<?php echo $k; ?>">

<!-- Inside Heading div -->
<!-- Dynamic css classes to be loaded -->
<!-- class=well -->

<?php 
  $i=1;
  if(!empty($label_control_details))
  {
$var_row=0;
$var_color=0;// 0-odd, 1-even

foreach ($label_control_details as $key) {

  # code...
/*  $inarray  =array(1,2,5,6,9,10,13,14,17,18,21,22,25,26,29,30);
  $style    ='well wellwhite';

  if(in_array($i,$inarray,true))
  {
    $style1='well';

  }*/

$label_id1=$key['label_id'];


if($label_id1==29)
{
    @$value_id29=$key['value_id'];
}
else
{
  @$value_id29='';
}

if($label_id1==30)
{
    @$value_id30=$key['value_id'];
}
else
{
  @$value_id30='';
}


if($label_id1==32)
{
    @$value_id32=$key['value_id'];
}
else
{
  @$value_id32='';
}

if($label_id1==33)
{
    @$value_id33=$key['value_id'];
}
else
{
  @$value_id33='';
}
$value23='';



$value24='<div class="form-group mt-2 mb-2">
            <input type="text" name="engine_number[]" value="" id="engine_number'.$k.'"  class="form-control"  maxlength="15" autocomplete="off" title="Enter Engine Number" data-validation="required alphanumeric" onchange="IsZero(this.id);" onpaste="return false;"/>                      </div>';

$value26='<div class="col-md-12"> 
          <div class="row no-gutters">
          <div class="col-6">
          <div class="form-group mt-2 mb-2">
          <input type="text" name="bhp[]" value="" id="bhp'.$k.'"  class="form-control"  maxlength="5" autocomplete="off" onchange="get_kw('.$k.')" title="Enter BHP" data-validation="required" onkeypress="return IsDecimal(event);" onpaste="return false;" />
          </div>
          </div>
          <div class="col-6" id="show_bhp_kw">
          <div class="form-group mt-2 mb-2">
          <div class="input-group">
          <input type="text" class="form-control"  name="bhp_kw[]" id="bhp_kw'.$k.'" value="" readonly="readonly">
           <div class="input-group-append">
              <div class="input-group-text">KW</div> 
            </div><!-- end of input-group-append -->
          </div><!-- end of input-group -->
          </div><!-- end of form group -->
           </div><!-- end of col-8 -->
      </div> <!-- end of row -->
      </div><!-- end of col-12 -->     ';
 
$value27=' <div class="form-group mt-2 mb-2">
            <input type="text" name="manufacturer_name[]" value="" id="manufacturer_name'.$k.'"  class="form-control"  maxlength="30" autocomplete="off" title="Enter Name of Manufacturer" data-validation="required alphanumeric" onkeypress="return alpbabetspace(event);" onchange="checklength1('.$k.')" onpaste="return false;"/>
            </div>';

$value28='<div class="form-group mt-2 mb-2">
            <input type="text" name="manufacturer_brand[]" value="" id="manufacturer_brand'.$k.'"  class="form-control"  maxlength="30" autocomplete="off" onkeypress="return alpbabetspace(event);" onchange="return checklength(this.id)" readonly/>
            </div>';

$value29='<div class="form-group mt-2 mb-2">
<select class="form-control select2" name="engine_model_id[]" id="engine_model_id'.$k.'" title="Select Type of Engine" data-validation="required">
<option value="">Select</option>';

foreach ($model_number as $res_model_number)
{

if($res_model_number['modelnumber_sl']==$value_id29) 
{
$value29.='<option value="'.$res_model_number['modelnumber_sl'] .'" selected>'.$res_model_number['modelnumber_name'].'</option>'; 
}
else
{
$value29.='<option value="'.$res_model_number['modelnumber_sl'] .'" >'.$res_model_number['modelnumber_name'].'</option>'; 
}

}

$value29.='</select>
</div>';

 

$value30='<div class="form-group mt-2 mb-2">
<select class="form-control select2" name="engine_type_id[]" id="engine_type_id" title="Select Type of Engine" data-validation="required"><option value="">Select</option>';

foreach ($engine_type as $res_engine_type)
{

if($res_engine_type['enginetype_sl']==$value_id30) 
{
$value30.='<option value="'.$res_engine_type['enginetype_sl'] .'" selected>'.$res_engine_type['enginetype_name'].'</option>'; 
}
else
{
$value30.='<option value="'.$res_engine_type['enginetype_sl'] .'" >'.$res_engine_type['enginetype_name'].'</option>'; 
}

}

$value30.='</select>
</div>';

 
$value31='<div class="form-group mt-2 mb-2">
<div class="input-group">
            <input type="text" name="propulsion_diameter[]" value="" id="propulsion_diameter'.$k.'"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Diameter of propulsion shaft"  onkeypress="return IsDecimal(event);" onchange="Isdot(this.id);" onpaste="return false;"/>
            <div class="input-group-append">
              <div class="input-group-text">cm</div> 
            </div>
           
           </div> </div>';



  $value32='<div class="form-group mt-2 mb-2">
                     <select class="form-control select2" name="propulsion_material_id[]" id="propulsion_material_id" title="Select Material of propulsion shaft" data-validation="required"><option value="">Select</option>';
  foreach ($propulsionshaft_material as $res_material)
 {
if($res_material['propulsionshaft_material_sl']==$value_id32) 
{
$value32.='<option value="'.$res_material['propulsionshaft_material_sl'] .'" selected>'.$res_material['propulsionshaft_material_name'].'</option>'; 
}
else
{
$value32.='<option value="'.$res_material['propulsionshaft_material_sl'] .'" >'.$res_material['propulsionshaft_material_name'].'</option>'; 
}
}
$value32.='</select></div>';

    $value33=' <div class="form-group mt-2 mb-2">
                     <select class="form-control select2" name="gear_type_id[]" id="gear_type_id" title="Select Type of Gear" data-validation="required">                
                    <option value="">Select</option>';
          foreach ($gear_type as $res_gear_type)
          {
          if($res_gear_type['geartype_sl']==$value_id33) 
          {
          $value33.='<option value="'.$res_gear_type['geartype_sl'] .'" selected>'.$res_gear_type['geartype_name'].'</option>'; 
          }
          else
          {
          $value33.='<option value="'.$res_gear_type['geartype_sl'].'" >'.$res_gear_type['geartype_name'].'</option>'; 
          }
          }
          $value33.=  '</select> </div>';





   $value34='<div class="form-group mt-2 mb-2">
            <input type="text" name="gear_number[]" value="" id="gear_number'.$k.'"  class="form-control"  maxlength="1" autocomplete="off" title="Enter Number of Gear"  onkeypress="return IsDecimal(event);" onchange="Isdot(this.id);" onpaste="return false;"/>
            </div>';

$value73='<div class="form-group mt-2 mb-2">
            <input type="text" name="model_number[]" value="" id="model_number'.$k.'"  class="form-control"  maxlength="30" autocomplete="off" title="Enter Model Number" data-validation="required alphanumeric" onchange="return IsZero(this.id);" onpaste="return false;"/>
            </div>';

 



  $label_id=$key['label_id'];
 // $static_array=array(24,25,26,27,28,29,30,31,32,33,34,73);
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
  if($var_row==0)
  { 
    $var_row=1;
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
    <div class="col-3 border-top border-bottom ">
      <p class="mt-3 mb-3"> <?php echo $key['label_name']; ?> </p>
      </div>

      <div class="col-3 border-top border-bottom ">
      <?php  echo $label_controls1; ?>
      </div>

  <?php
  }
  else
  {
    $var_row=0;
    ?>
    <div class="col-3 border-top border-bottom border-left pl-2">
      <p class="mt-3 mb-3"> <?php echo $key['label_name']; ?> </p>
      </div> <!-- end of col-3 -->

      <div class="col-3 border-top border-bottom">
      <?php  echo $label_controls1; ?>
      </div> <!-- end of col-3 -->
      </div> <!-- end of row -->
    <?php
  } //End of var_row condition
} //End of Foreach

if($var_row==1)
{
  ?>
  <div class="col-6"></div>
  </div> <!-- end of unclosed row -->
<?php
}
}
?>


</div>
<?php
}
?>


<script>

 $(document).ready(function() {


/*
$("#manufacturer_name"+i).change(function() { 
  alert("chfghfgh");

      var strvalue=($("#manufacturer_name"+i).val());
     
    $("#manufacturer_brand"+i).val(strvalue);

});*/


});

 function checklength1(i)
 {
 
   var strvalue=($("#manufacturer_name"+i).val());
  //alert(strvalue);
    var len=strvalue.length;
  if(len<4)
  {
    alert("Minimum 4 character");
   document.getElementById(id).value='';
    document.getElementById(id).focus();
    return false;
  }
  else
  {
    $("#manufacturer_brand"+i).val(strvalue);
  }


  
 }
    function get_kw(i)
    {

      var strvalue=($("#bhp"+i).val());
     //alert(strvalue);
      if((strvalue==0) || (strvalue=='.'))
      {
      alert("Invalid Number");
      $("#bhp"+i).val('');
      $("#bhp_kw"+i).val('');
      }
      else
      {
         var bhp=parseInt($("#bhp"+i).val());
          
        //var total=round((0.745699872)*bhp);
        var total=((0.745699872)*bhp);
       //alert(total);
        var result=  total.toFixed(2); 
        $("#bhp_kw"+i).val(result);
      }
   
    }
    
    function remove_tb(i)
    {
        var engineno=parseInt($("#no_of_engineset").val());
        var newval=engineno-1;
        $("#no_of_engineset").val(newval);
        $("#engine_set"+i).remove();
        $("#remove"+i).remove();
               
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
