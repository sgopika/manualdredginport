
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

$commnequipment                   =   $this->Survey_model->get_commnequipment();
$data1['commnequipment']          =   $commnequipment;

$navgnequipments                  =   $this->Survey_model->get_navgnequipments();
$data1['navgnequipments']         =   $navgnequipments;

$pollution_controldevice          =   $this->Survey_model->get_pollution_controldevice();
$data1['pollution_controldevice'] =   $pollution_controldevice;

$sourceofwater                    =   $this->Survey_model->get_sourceofwater();
$data1['sourceofwater']           =   $sourceofwater;

?>



<?php 

$heading_id1=6;
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


$value53= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
    <select class="form-control select2" multiple="multiple" data-placeholder="Select the list" name="list1[]" data-validation="required">
    <option value="">Select</option>';
    foreach ($commnequipment as $res_commnequipment)
    {
    $value53.='<option value="'.$res_commnequipment['equipment_sl'].'"> '.$res_commnequipment['equipment_name'].'  </option>';
    } 
    $value53.='</select>

</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';



$value54= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
    <select class="form-control select2 " multiple="multiple" data-placeholder="Select the list" name="list2[]" data-validation="required" >
    <option value="">Select</option>';
    foreach ($navgnequipments as $res_navgnequipments)
    {
    $value54.='<option value="'. $res_navgnequipments['equipment_sl'].'"> '.$res_navgnequipments['equipment_name'].'  </option>';
    } 
    $value54.='</select>
    
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';


$value55= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
    <input type="checkbox" class="minimal" name="sewage_treatment" value="1" >
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';



$value56= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
   <input type="checkbox" class="minimal" name="solid_waste"  value="1">
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';

$value57= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
    <input type="checkbox" class="minimal" name="sound_pollution"  value="1">
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';




$value58= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
    <select class="form-control select2" multiple="multiple" data-placeholder="Select the list" name="list3[]" data-validation="required">
                 <option value="">Select</option>';
                 foreach ($pollution_controldevice as $res_pollution_controldevice)
            {
        
              $value58.='  <option value="'.$res_pollution_controldevice['equipment_sl'].'"> '. $res_pollution_controldevice['equipment_name'].'  </option>';
              
            }
               $value58.='  </select>
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';

$value59= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
<div class="input-group">
    <input type="text" name="water_consumption" value="" id="water_consumption"  class="form-control"  maxlength="5" autocomplete="off" title="Enter Water consumption per day" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" onpaste="return false;"/>
    <div class="input-group-append">
    <div class="input-group-text">L</div> 
    </div> 
 </div>   
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';


$value60= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
    <select class="form-control select2 div200" name="source_of_water" id="source_of_water" title="Select Source of water" data-validation="required">
                <option value="">Select</option>';
                foreach ($sourceofwater as $res_sourceofwater)
            {
               $value60.='<option value="'. $res_sourceofwater['sourceofwater_sl'].'"> '. $res_sourceofwater['sourceofwater_name'].'  </option>';
            } 
                $value60.='  </select>
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';



$value75= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
    <label>
                  <input type="radio" name="fire_alarm" id="fire_alarm_y" value="1" checked> &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="fire_alarm"  id="fire_alarm_n"  value="0" > &nbsp;No
                </label>
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';



$value76= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
     <label>
                  <input type="radio" name="engine_room" id="engine_room_y" value="1" checked> &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="engine_room"  id="engine_room_n"  value="0" > &nbsp;No
                </label>
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';



$value77= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
     <label>
                  <input type="radio" name="flashback_arrestor" id="flashback_arrestor_y" value="1" checked> &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="flashback_arrestor"  id="flashback_arrestor_n"  value="0" > &nbsp;No
                </label>
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';



$value78= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
   <label>
                  <input type="radio" name="cylinder" id="cylinder_y" value="1" checked> &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="cylinder"  id="cylinder_n"  value="0" > &nbsp;No
                </label>
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';


$value79= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
                <label>
                  <input type="radio" name="gally" id="gally_y" value="1" checked> &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="gally"  id="gally_n"  value="0" > &nbsp;No
                </label>
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';



$value80= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$key['label_name'].' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
              <label>
                  <input type="radio" name="hand_rail" id="hand_rail_y" value="1" checked> &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="hand_rail"  id="hand_rail_n"  value="0" > &nbsp;No
                </label>
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';



    $label_id=$key['label_id'];
 //$static_array=array(53,54,55,56,57,58,59,60,75,76,77,78,79,80);
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
