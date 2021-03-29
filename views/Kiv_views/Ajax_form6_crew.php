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
<!-- Load All Static Controls of Hull Details-->
<?php 

 		$crew_type=$this->Survey_model->get_crewType();
        $data['crew_type'] =	$crew_type;

        $crew_class=$this->Survey_model->get_crewClass();
        $data['crew_class'] =	$crew_class;


$heading_id1=25;
$form_id=6;
$label_details=$this->Survey_model->get_label_details_ajax($form_id,$heading_id1);
$data['label_details']=$label_details;
$static_array = array_column($label_details, 'label_sl');


	
$value186='
  <select class="form-control select2" name="crew_type_sl[]" id="crew_type_sl1" title="" data-validation="required" >
  <option value="">Select</option>';
   foreach ($crew_type as $res_crew_type)
  {
  
  $value186.='<option value="'.$res_crew_type['crew_type_sl'].'"> '.$res_crew_type['crew_type_name'].'</option>';
  }   
  $value186.='</select>
  ';


$value187='<input type="text" name="name_of_type[]" value="" id="name_of_type1"  class="form-control"  autocomplete="off" placeholder="Enter name" data-validation="required" required onkeypress="return IsAddress(event);" onpaste="return false;"/>';

  $value188='<select class="form-control select2" name="crew_class_sl[]" id="crew_class_sl1" title="" data-validation="required" >
  <option value="">Select</option>';
  foreach ($crew_class as $res_crew_class)
  {
  
  $value188.='<option value="'. $res_crew_class['crew_class_sl'].'"> '. $res_crew_class['crew_class_name'].'</option>';
  
  }   
  
  $value188.='</select>';

  $value189='<input type="text" name="license_number_of_type[]" value="" id="license_number_of_type1"  class="form-control"  autocomplete="off" placeholder="Enter license number" data-validation="required" required onkeypress="return IsAlphanumeric(event);" onpaste="return false;" /> '; 





if(!empty($label_control_details))
{

$var_row=0;
$var_color=0;// 0-odd, 1-even

  
$html='<div class="row no-gutters mt-1 eventab">
<div class="col-12 d-flex justify-content-center text-center"> 
Master and Serang Details
</div>
</div>';


$html.='<div class="row no-gutters mt-0 oddtab">';

$var_i = 0;
foreach ($label_control_details as $key) {

   $label_id=$key['label_id'];
   $label_name=$key['label_name'];
$html.='<div class="col-3 d-flex justify-content-start">'
.$label_name.'</div>';
}
$html.='</div>';




$html.='<div class="row no-gutters mt-1 eventab">';
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
  $html.='<div class="col-3 d-flex justify-content-start">'.$label_controls1.'</div>';
}
$html.='</div>';
$html.='<div class="col-2 d-flex justify-content-center"> </div> 
</div>
</div>
</div>
<span id="insert_newrow"></span>


<div class="col-12 d-flex justify-content-start"><button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="addmore" id="addmore" ><i class="fas fa-plus-square"></i>&nbsp;Addmore</button>
</div>

<input type="hidden" name="rowcount" id="rowcount" value="1">
<input type="hidden" name="vessel_id" id="vessel_id" value="'.$vesselId.'">'; 




}
echo  $html;
?>
<script type="text/javascript">
$(document).ready(function(){

$("#addmore").click(function() 
{
var cnt=parseInt($("#rowcount").val());
var vessel_id=$("#vessel_id").val();


//var ncnt=parseInt(cnt+1);
if(cnt==false)
{
	$("#rowcount").val('2');
}
else
{
	$("#rowcount").val(cnt+1);
}

var passcnt=parseInt($("#rowcount").val());
 $.ajax
    ({
      type: "POST",
      url:"<?php echo site_url('/Kiv_Ctrl/Survey/add_crew/')?>"+passcnt+'/'+vessel_id,
      success: function(data)
      { 
      	//alert(data);
      $("#insert_newrow").append(data);
      }
    });

});

});

	
</script>

