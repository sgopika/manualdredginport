<?php 


 $vessDetails          = $this->Survey_model->get_vessel_details_dynamic($vessel_id);
        $data['vessDetails']  =  $vessDetails; 

        $vesselType     = $vessDetails[0]['vessel_type_id'];
        $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
        $lengthOverDeck = $vessDetails[0]['vessel_length'];
        $engine_id      = $vessDetails[0]['engine_placement_id'];
        $hull_id        = $vessDetails[0]['hullmaterial_id'];
        
// load ajax page      
$form_id=5;
$heading_id=14;

$label_control_details = $this->Survey_model->get_label_control_details($vesselType,$vesselSubtype,$lengthOverDeck, $hull_id, $engine_id, $form_id, $heading_id);
$data['label_control_details']    =  $label_control_details;
$heading_id1=14;
$form_id=5;
$label_details=$this->Survey_model->get_label_details_ajax($form_id,$heading_id1);
$data['label_details']=$label_details;
$static_array = array_column($label_details, 'label_sl');



	$value132='<select class="form-control select2" name="crew_type_sl[]" id="crew_type_sl1" title="" data-validation="required" required="required">
	<option value="">Select</option>';
	 foreach ($crew_type as $res_crew_type)
	{
	
	$value132.='<option value="'.$res_crew_type['crew_type_sl'].'"> '.$res_crew_type['crew_type_name'].'</option>';
	
	}   
	$value132.='</select>';

$value133='<input type="text" name="name_of_type[]" value="" id="name_of_type1"  class="form-control"  autocomplete="off" placeholder="Enter name" data-validation="required" required="required"  onpaste="return false;" onkeypress="return IsAddress(event);"/>';

	$value134='<select class="form-control select2" name="crew_class_sl[]" id="crew_class_sl1" title="" data-validation="required" required="required">
	<option value="">Select</option>';
	foreach ($crew_class as $res_crew_class)
	{
	$value134.='<option value="'. $res_crew_class['crew_class_sl'].'"> '. $res_crew_class['crew_class_name'].'</option>';
	
	}   
	$value134.='</select>';

	$value135='<input type="text" name="license_number_of_type[]" value="" id="license_number_of_type1"  class="form-control"  autocomplete="off" placeholder="Enter license number" data-validation="required" required="required"  onpaste="return false;" onkeypress="return IsAddress(event);"/>'; 



if(!empty($label_control_details))
{

$var_row=0;
$var_color=0;// 0-odd, 1-even

$html='<div class="row no-gutters mt-1 eventab" id="rmv'.$number.'">';
foreach ($label_control_details as $key1) {

	$label_id=$key1['label_id'];
	 $label_name=$key1['label_name'];

if(in_array($label_id,$static_array))
{
	$g = "value".$label_id;
	$label_controls1= ${$g};
}
else
{
	$label_controls1='';
}

$html.='<div class="col-3 d-flex justify-content-start">'.$label_controls1.'</div> ';
	
}

$html.='<div class="col-3 d-flex justify-content-start"><button type="button" class="btn btn-danger btn-flat  btn-point btn-sm clickfun" name="removerow" id="'.$number.'" ><i class="fas fa-trash"></i>&nbsp;Remove</button> </div> </div>
</div></div>';

}
echo  $html;
 ?>



<script type="text/javascript">
$(document).ready(function(){

$(".clickfun").click(function(){
	var idnum=this.id;
	//alert(idnum);
	$("crew_type_sl"+idnum).val('');
	$("name_of_type"+idnum).val('');
	$("crew_class_sl"+idnum).val('');
	$("license_number_of_type"+idnum).val('');
	$("#rmv"+idnum).remove();

});

});

</script>


 <script type="text/javascript">
  $(document).ready(function() {
          $('.select2').select2({ width:'100%' });
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