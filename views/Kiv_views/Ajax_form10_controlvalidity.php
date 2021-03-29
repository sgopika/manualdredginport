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

$heading_id1=29;
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


$value211=' <div class="form-group mt-2 mb-2"><input type="text" name="upper_deck_passenger" value="" id="upper_deck_passenger"  class="form-control"  maxlength="2" autocomplete="off" title="Enter number of upper deck" placeholder="Enter number of upper deck" data-validation="required" onkeypress="return IsDecimal(event);" onpaste="return false;"/>
  </div>';

$value212=' <div class="form-group mt-2 mb-2"><input type="text" name="lower_deck_passenger" value="" id="lower_deck_passenger"  class="form-control"  maxlength="2" autocomplete="off" title="Enter number of lower deck" placeholder="Enter number of lower deck" data-validation="required" onkeypress="return IsDecimal(event);" onpaste="return false;"/>
  </div>  ';


$value213='<div class="form-group mt-2 mb-2"><input type="text" name="four_cruise_passenger" value="" id="four_cruise_passenger"  class="form-control"  maxlength="2" autocomplete="off" title="Enter number of four day cruise" placeholder="Enter number of four day cruise" data-validation="required" onkeypress="return IsDecimal(event);" onpaste="return false;"/>
  </div>';

$value214=' <div class="form-group mt-2 mb-2">  
 <input type="text" name="validity_of_insurance" value="" id="validity_of_insurance"  class="form-control dob"  maxlength="10" autocomplete="off" title="Enter validity of insurance" placeholder="Enter validity of insurance" data-validation="required" onpaste="return false;"/>
  </div>';


$value215='  <div class="form-group mt-2 mb-2">
  <input type="text" name="validity_fire_extinguisher" value="" id="validity_fire_extinguisher"  class="form-control dob"  maxlength="10" autocomplete="off" title="Enter validity of fire extinguisher" placeholder="dd/mm/yyyy" data-validation="required" onpaste="return false;"/>
  </div>';

$value216='<div class="form-group mt-2 mb-2"> 
 <input type="text" name="next_drydock_date" value="" id="next_drydock_date"  class="form-control dob"  maxlength="10" autocomplete="off" title="Enter next dry dock date" placeholder="dd/mm/yyyy" data-validation="required" />
  </div>';

$value217=' <div class="form-group mt-2 mb-2">
  <input type="text" name="validity_of_certificate" value="" id="validity_of_certificate"  class="form-control dob"  maxlength="10" autocomplete="off" title="Enter validity of the certificate"placeholder="dd/mm/yyyy" data-validation="required" />
  </div>';

$value218='<div class="form-group mt-2 mb-2">  
<textarea name="form10_remarks" id="form10_remarks" rows="5" cols="30" data-validation="required" onpaste="return false;" onkeypress="return IsAddress(event);"></textarea>  </div>';



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


<script>
$(document).ready(function() {
$("#validity_of_certificate").change(function()
{
var validity_of_certificate=$("#validity_of_certificate").val(); 
var CurrentDate = new Date();
var GivenDate1 = validity_of_certificate.split("/").reverse().join("-");
var GivenDate = new Date(GivenDate1);
if(GivenDate < CurrentDate)
{
	alert("Invalid Date");
	$("#validity_of_certificate").val('');
}
});



$("#validity_fire_extinguisher").change(function()
{
var validity_fire_extinguisher=$("#validity_fire_extinguisher").val(); 
var CurrentDate = new Date();
var GivenDate1 = validity_fire_extinguisher.split("/").reverse().join("-");
var GivenDate = new Date(GivenDate1);
if(GivenDate < CurrentDate)
{
	alert("Invalid Date");
	$("#validity_fire_extinguisher").val('');
}
});

});
</script>