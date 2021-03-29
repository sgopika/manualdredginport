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

 $garbage_details=$this->Survey_model->get_garbage_details();
        $data['garbage_details'] =	$garbage_details;
        //print_r($garbage_details);

$heading_id1=28;
$form_id=10;
$label_details=$this->Survey_model->get_label_details_ajax($form_id,$heading_id1);
$data['label_details']=$label_details;
$static_array = array_column($label_details, 'label_sl');



if(!empty($label_control_details))
{

$var_row=0;
$var_color=0;// 0-odd, 1-even
foreach ($label_control_details as $key) {

	$label_id=$key['label_id'];


$value_id1=$key['value_id'];
$value_id=rtrim($value_id1,",");
$myarr=(explode(",",$value_id));



$value198='<div class="form-group mt-2 mb-2">
<input type="text" name="number17_adult" value="" id="number17_adult"  class="form-control"  maxlength="2" autocomplete="off" title="Enter number of life jacket in adult" placeholder="Enter number of life jacket in adult" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" onpaste="return false;"/></div>
   <input type="hidden" name="hdn_equipment_id17" value="17">
   <input type="hidden" name="hdn_equipment_id18" value="18">
   <input type="hidden" name="hdn_equipment_id19" value="19"> 
  <input type="hidden" name="hdn_equipment_type_id11" value="11">';

$value199='<div class="form-group mt-2 mb-2"> <input type="text" name="number17_children" value="" id="number17_children"  class="form-control"  maxlength="2" autocomplete="off" title="Enter number of life jacket in children" placeholder="Enter number of life jacket in children" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);" onpaste="return false;"/> </div>';

$value200='<div class="form-group mt-2 mb-2"><input type="text" name="number18" value="" id="number18"  class="form-control"  maxlength="2" autocomplete="off" title="Enter number of life boat" placeholder="Enter number of life boat" data-validation="required" onkeypress="return IsDecimal(event);" onpaste="return false;"/></div>';

$value201=' <input type="text" name="capacity18" value="" id="capacity18"  class="form-control"  maxlength="2" autocomplete="off" title="Enter capacity of life boat" placeholder="Enter capacity of life boat" data-validation="required" onkeypress="return IsDecimal(event);" onpaste="return false;"/>';

$value202='<div class="form-group mt-2 mb-2"><input type="text" name="number19" value="" id="number19"  class="form-control"  maxlength="2" autocomplete="off" title="Enter number of life raft" placeholder="Enter number of life raft" data-validation="required" onkeypress="return IsDecimal(event);" onpaste="return false;"/></div>';

$value203='<div class="form-group mt-2 mb-2"><input type="text" name="capacity19" value="" id="capacity19"  class="form-control"  maxlength="2" autocomplete="off" title="Enter capacity of life raft" placeholder="Enter capacity of life raft" data-validation="required" onkeypress="return IsDecimal(event);" onpaste="return false;"/></div>';
if($label_id==204)
{


 
$j=1;
foreach($garbage_details as $res_garbage_details)
{
if(in_array($res_garbage_details['garbage_sl'],$myarr))
    {
 $count=count($garbage_details);

$listname=$res_garbage_details['garbage_name'];
$sl=$res_garbage_details['garbage_sl'];


$value204[]='<div class="row">
<div class="col-6 d-flex justify-content-center">'.$listname.' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
 <label><input type="radio" name="garbage'.$sl.'" id="garbage_y'.$sl.'" value="'.$sl.'" > &nbsp;Yes</label> &nbsp; &nbsp;
  <label><input type="radio" name="garbage'.$sl.'" id="garbage_n'.$sl.'"  value="0" checked> &nbsp;No</label>
 <input type="hidden" value="'.$count.'" name="cntcount" id="cntcount"> 

</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row --> ';




}

$j++;
}

if(!empty($value204))
{
	$value204    = implode(" ",$value204);
}
else
{
	$value204    ="";
}

}

 

/*$value205=' <div class="form-group mt-2 mb-2">
  <label><input type="radio" name="food_grane_black" id="food_grane_black_y" value="1" > &nbsp;Yes</label> &nbsp; &nbsp;
  <label><input type="radio" name="food_grane_black" id="food_grane_black_n"  value="0" checked> &nbsp;No</label>
  </div>';

$value206='<div class="form-group mt-2 mb-2">  
  <label><input type="radio" name="purple_blue" id="purple_blue_y" value="1" > &nbsp;Yes</label> &nbsp; &nbsp;
  <label><input type="radio" name="purple_blue" id="purple_blue_n" value="0" checked> &nbsp;No</label>
  </div>';

$value207=' <div class="form-group mt-2 mb-2">
  <label><input type="radio" name="glass_crockery" id="glass_crockery_y" value="1" > &nbsp;Yes</label> &nbsp; &nbsp;
  <label><input type="radio" name="glass_crockery" id="glass_crockery_n" value="0" checked> &nbsp;No</label>
  </div>';

$value208='<div class="form-group mt-2 mb-2">  
  <label><input type="radio" name="oily_water" id="oily_water_y" value="1" > &nbsp;Yes</label> &nbsp; &nbsp;
  <label><input type="radio" name="oily_water" id="oily_water_n" value="0" checked> &nbsp;No</label>
  </div>';
*/

$value209=' <div class="form-group mt-2 mb-2">
  <label><input type="radio" name="first_aid_box" id="first_aid_box_y" value="1" checked> &nbsp;Yes</label> &nbsp; &nbsp;
  <label><input type="radio" name="first_aid_box" id="first_aid_box_n" value="0" > &nbsp;No</label>
  </div>';

  $value210=' <div class="form-group mt-2 mb-2">  
  <label><input type="radio" name="condition_of_equipment" id="condition_of_equipment_y" value="1" checked> &nbsp;Yes</label> &nbsp; &nbsp;
  <label><input type="radio" name="condition_of_equipment" id="condition_of_equipment_n" value="0" > &nbsp;No</label>
  </div>';


$label_id=$key['label_id'];  


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


} // end of main IF



?>

