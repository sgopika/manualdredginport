<script type="text/javascript">
    $(".select2").select2();
</script>
<!-- Load All Static Controls of Hull Details-->
<?php 

 $crew_type=$this->Survey_model->get_crewType();
        $data['crew_type'] =	$crew_type;

        $crew_class=$this->Survey_model->get_crewClass();
        $data['crew_class'] =	$crew_class;


if(!empty($label_control_details))
{

$var_row=0;
$var_color=0;// 0-odd, 1-even
foreach ($label_control_details as $key) {

	$label_id=$key['label_id'];
	

	?>
	<!-- Creating New Row -->



<div class="row no-gutters">
<div class="col-12 border-top border-bottom ">
<div class="row">
	<div class="col-3 d-flex justify-content-center">Type</div> <!-- end of div col -->
	<div class="col-2 d-flex justify-content-center">Name</div> <!-- end of div col -->
	<div class="col-2 d-flex justify-content-center">Class</div> <!-- end of div col -->
	<div class="col-3 d-flex justify-content-center">License Number </div> <!-- end of div col -->
	<div class="col-2 d-flex justify-content-center"> </div> <!-- end of div col -->
</div>
</div>
</div>

<div class="row no-gutters">
<div class="col-12 border-top border-bottom ">
<div class="row">
	<div class="col-3 d-flex justify-content-center">
	<select class="form-control select2" name="crew_type_sl[]" id="crew_type_sl1" title="" data-validation="required" >
	<option value="">Select</option>
	<?php  foreach ($crew_type as $res_crew_type)
	{
	?>
	<option value="<?php echo $res_crew_type['crew_type_sl']?>"> <?php echo $res_crew_type['crew_type_name']?></option>
	<?php
	}   
	?>
	</select>
	</div> <!-- end of div col -->
	<div class="col-2 d-flex justify-content-center"> 
	<input type="text" name="name_of_type[]" value="" id="name_of_type1"  class="form-control"  autocomplete="off" placeholder="Enter name" data-validation="required" required  /> </div> <!-- end of div col -->

	<div class="col-2 d-flex justify-content-center"><select class="form-control select2" name="crew_class_sl[]" id="crew_class_sl1" title="" data-validation="required" >
	<option value="">Select</option>
	<?php  foreach ($crew_class as $res_crew_class)
	{
	?>
	<option value="<?php echo $res_crew_class['crew_class_sl']?>"> <?php echo $res_crew_class['crew_class_name']?></option>
	<?php
	}   
	?>
	</select></div> <!-- end of div col -->

	<div class="col-3 d-flex justify-content-center"><input type="text" name="license_number_of_type[]" value="" id="license_number_of_type1"  class="form-control"  autocomplete="off" placeholder="Enter license number" data-validation="required" required  />  </div> <!-- end of div col -->
		<div class="col-2 d-flex justify-content-center"> </div> <!-- end of div col -->
</div>
</div>
</div>

<span id="insert_newrow"></span>


<div class="col-12 d-flex justify-content-start"><button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="addmore" id="addmore" ><i class="fas fa-plus-square"></i>&nbsp;Addmore</button>
</div>
<input type="hidden" name="rowcount" id="rowcount" value="1">


<?php 
 }
	}
	?>


<script type="text/javascript">
$(document).ready(function(){

$("#addmore").click(function() 
{
var cnt=parseInt($("#rowcount").val());


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
      url:"<?php echo site_url('/Kiv_Ctrl/Survey/add_crew/')?>"+passcnt,
      success: function(data)
      { 
      $("#insert_newrow").append(data);
      }
    });

});

});

	
</script>