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

$heading_id1=24;
$form_id=6;
$label_details=$this->Survey_model->get_label_details_ajax($form_id,$heading_id1);
$data['label_details']=$label_details;
$static_array = array_column($label_details, 'label_sl');

if(!empty($label_control_details))
{

$var_row=0;
$var_color=0;// 0-odd, 1-even
foreach ($label_control_details as $key) {

	$label_id=$key['label_id'];
	 

/*$value177='<div class="form-group mt-2 mb-2">
		<select class="form-control select2" name="fuel_used_id" id="fuel_used_id" title="Enter Materil of Hull" data-validation="required">
		<option value="">Select</option>';
		 foreach ($fuel_details as $res_fuel_details)
		{
		$value174.='<option value="'.$res_fuel_details['fuel_sl'] .'" >'.$res_fuel_details['fuel_name'].'</option>';

		}	
		$value174.='</select></div>';*/

$value177=' <div class="col-3 border-bottom  ">    
      <div class="form-group mt-2 mb-2">
          <input type="text" name="passenger_capacity" value="" id="passenger_capacity"  class="form-control"  autocomplete="off" placeholder="Enter passenger capacity" data-validation="required" required onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" onpaste="return false;"/> 
      </div> <!-- end of form group -->
    </div>';



$value178='<div class="form-group mt-2 mb-2">
    <label>
                  <input type="radio" name="capacity_visible" id="passenger_capacity_visible_y" value="1" checked > &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="capacity_visible"  id="passenger_capacity_visible_n"  value="0" > &nbsp;No
                </label>
</div>';

$value179='<div class="form-group mt-2 mb-2">
  <label>
                  <input type="radio" name="railing_status_id" id="railing_status_id_y" value="1" checked> &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="railing_status_id"  id="railing_status_id_n"  value="0" > &nbsp;No
                </label>
</div>';

$value180='<div class="form-group mt-2 mb-2">
  <label>
                  <input type="radio" name="sand_box" id="sand_box_y" value="1" checked > &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="sand_box"  id="sand_box_n"  value="0" > &nbsp;No
                </label>
</div>';



$value181='<div class="form-group mt-2 mb-2">
  <label>
                  <input type="radio" name="life_jacket" id="life_jacket_y" value="1" checked> &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="life_jacket"  id="life_jacket_n"  value="0"> &nbsp;No
                </label>
</div>';

$value182=' <div class="col-3 border-bottom  ">    
      <div class="form-group mt-2 mb-2">
          <input type="text" name="cabin_height" value="" id="cabin_height"  class="form-control"  autocomplete="off" placeholder="Enter Internal height of cabin" data-validation="required" required onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" onpaste="return false;"/> 
      </div> <!-- end of form group -->
    </div>';

 	$value183=' <div class="col-3 border-bottom  ">    
      <div class="form-group mt-2 mb-2">
          <input type="text" name="freeboard_height" value="" id="freeboard_height"  class="form-control"  autocomplete="off" placeholder="Enter Height of freeboard" data-validation="required" required onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" onpaste="return false;"/> 
      </div> <!-- end of form group -->
    </div>';

 	$value184='<div class="form-group mt-2 mb-2">
  <label>
                  <input type="radio" name="light_status_id" id="light_status_id_y" value="1" checked> &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="light_status_id"  id="light_status_id_n"  value="0" > &nbsp;No
                </label>
</div>';

$value185='<div class="form-group mt-2 mb-2">
  <label>
                  <input type="radio" name="boat_accomodation_condition_status_id" id="boat_accomodation_conditiond_y" value="1" checked> &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="boat_accomodation_condition_status_id"  id="boat_accomodation_condition_n"  value="0" > &nbsp;No
                </label>
</div>';


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

