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

 $fuel_details=$this->Survey_model->get_fuel_details();
  $data['fuel_details'] =	$fuel_details;
$date=date('m-d-Y');
$heading_id1=26;
$form_id=6;
$label_details=$this->Survey_model->get_label_details_ajax($form_id,$heading_id1);
$data['label_details']=$label_details;
//print_r($label_details);
$static_array = array_column($label_details, 'label_sl');

if(!empty($label_control_details))
{

$var_row=0;
$var_color=0;// 0-odd, 1-even
foreach ($label_control_details as $key) {

	$label_id=$key['label_id'];


$value190='<div class="form-group mt-2 mb-2">
    <input type="text" name="declaration_issue_date" value="'.$date.'" id="declaration_issue_date"  class="form-control dob"   data-validation="required"  required/>
</div>';

$value191='<div class="form-group mt-2 mb-2">
   <textarea name="form6_remarks" id="form6_remarks" data-validation="required"  required  onkeypress="return IsAddress(event);" onpaste="return false;"> </textarea>
</div>';

$value192='<div class="form-group mt-2 mb-2">
  <textarea name="repair_details" id="repair_details" data-validation="required"  required  onkeypress="return IsAddress(event);" onpaste="return false;"></textarea>
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

