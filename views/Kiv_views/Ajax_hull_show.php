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

$hullmaterial					= 	$this->Survey_model->get_hullmaterial();
$data['hullmaterial']			=	$hullmaterial;

$hullplating_material   		= 	$this->Survey_model->get_hullplating_material();
$data['hullplating_material']	=	$hullplating_material;

$bulk_head_placement 			= 	$this->Survey_model->get_bulk_head_placement();
$data['bulk_head_placement']	=	$bulk_head_placement; 

$heading_id1=2;
$form_id=1;
$label_details=$this->Survey_model->get_label_details_ajax($form_id,$heading_id1);
$data['label_details']=$label_details;
//print_r($label_details);

$static_array = array_column($label_details, 'label_sl');
//print_r($label_control_details);
if(!empty($label_control_details))
{

$var_row=0;
$var_color=0;// 0-odd, 1-even
foreach ($label_control_details as $key) {

	$label_id=$key['label_id'];
	# code...
//	$inarray 	=array(1,2,5,6,9,10,13,14,17,18,21,22,25,26,29,30);
	 
	$label_id1=$key['label_id'];

if($label_id1==11)
	{
		  @$value_id11=$key['value_id'];
	}
	else
	{
		@$value_id11=''; 
	}


	if($label_id1==12)
	{
		  @$value_id12=$key['value_id'];
	}
	else
	{
		@$value_id12=''; 
	}


	if($label_id1==13)
	{
		  @$value_id13=$key['value_id'];
	}
	else
	{
		@$value_id13=''; 
	}

	if($label_id1==14)
	{
		  @$value_id14=$key['value_id'];
	}
	else
	{
		@$value_id14=''; 
	}

	if($label_id1==15)
	{
		  @$value_id15=$key['value_id'];
	}
	else
	{
		@$value_id15=''; 
	}


if($label_id1==16)
	{
		  @$value_id16=$key['value_id'];
	}
	else
	{
		@$value_id16=''; 
	}

if($label_id1==17)
	{
		  @$value_id17=$key['value_id'];
	}
	else
	{
		@$value_id17=''; 
	}

if($label_id1==18)
	{
		  @$value_id18=$key['value_id'];
	}
	else
	{
		@$value_id18=''; 
	}

if($label_id1==19)
	{
		  @$value_id19=$key['value_id'];
	}
	else
	{
		@$value_id19=''; 
	}

if($label_id1==20)
	{
		  @$value_id20=$key['value_id'];
	}
	else
	{
		@$value_id20=''; 
	}

if($label_id1==21)
	{
		  @$value_id21=$key['value_id'];
	}
	else
	{
		@$value_id21=''; 
	}

if($label_id1==22)
	{
		  @$value_id22=$key['value_id'];
	}
	else
	{
		@$value_id22=''; 
	}

if($label_id1==224)
	{
		  @$value_id224=$key['value_id'];
	}
	else
	{
		@$value_id224=''; 
	}


$value11='<div class="form-group mt-2 mb-2">
		<input type="text" name="hull_name" value="'.$value_id11.'" id="hull_name"  class="form-control"  maxlength="30" autocomplete="off" title="Enter Name of Builder" data-validation="required" onkeypress="return alpbabetspace(event);" onchange="return checklength(this.id)" onpaste="return false;"/>
		</div>';

$value12='<div class="form-group mt-2 mb-2">
<textarea class="form-control" rows="3" name="hull_address" id="hull_address"  title="Address of Hull Builder"  onkeypress="return IsAddress(event);" onchange="return checklength(this.id)" maxlength="250" required="required"  onpaste="return false;"></textarea></div>';

$value13='<div class="form-group mt-2 mb-2">
		<select class="form-control select2" name="hullmaterial_id" id="hullmaterial_id" title="Select Materil of Hull" data-validation="required">
		<option value="">Select</option>';
		 foreach ($hullmaterial as $res_hullmaterial)
		{
		$value13.='<option value="'.$res_hullmaterial['hullmaterial_sl'] .'" >'.$res_hullmaterial['hullmaterial_name'].'</option>';

		}	
		$value13.='</select></div>';

$value14='<div class="form-group mt-2 mb-2"> 
			<div class="input-group">
			<input type="text" name="hull_thickness" value="'.$value_id14.'" id="hull_thickness"  class="form-control"  maxlength="2" autocomplete="off" title="Enter Thickness of Hull" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" onpaste="return false;"/>
		 	<div class="input-group-append">
            	<div class="input-group-text">mm</div> 
          	</div> 
		</div>
		 </div> ';

/*$value15='<div class="form-group mt-2 mb-2">
		<select class="form-control select2" name="hullplating_material_id" id="hullplating_material_id" title="Select Hull Plating Material" data-validation="required">
		<option value="">Select</option>';		 
		 foreach ($hullplating_material as $res_hullplating_material)
		{
			if($res_hullplating_material['hullplating_material_sl']==$value_id15) 
			{
				$value15.='<option value="'.$res_hullplating_material['hullplating_material_sl'] .'" selected>'.$res_hullplating_material['hullplating_material_name'].'</option>'; 
			}
			else
			{

			$value15.='<option value="'.$res_hullplating_material['hullplating_material_sl'] .'" >'.$res_hullplating_material['hullplating_material_name'].'</option>'; 
			}
		}
		$value15.='</select></div>';*/

$value15='<div class="form-group mt-2 mb-2">
		<select class="form-control select2" name="hullplating_material_id" id="hullplating_material_id" title="Select Hull Plating Material" data-validation="required">
		<option value="">Select</option>';		 
		 foreach ($hullmaterial as $res_hullplating_material)
		{
			if($res_hullplating_material['hullmaterial_sl']==$value_id13) 
			{
				$value15.='<option value="'.$res_hullplating_material['hullmaterial_sl'] .'" selected>'.$res_hullplating_material['hullmaterial_name'].'</option>'; 
			}
			else
			{

			$value15.='<option value="'.$res_hullplating_material['hullmaterial_sl'] .'" >'.$res_hullplating_material['hullmaterial_name'].'</option>'; 
			}
		}
		$value15.='</select></div>';



$value16='<div class="form-group mt-2 mb-2">
			<div class="input-group">
			<input type="text" name="hull_plating_material_thickness" value="" id="hull_plating_material_thickness"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Thickness of Hull Plating Material" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" readonly onpaste="return false;"/>
		 	<div class="input-group-append">
            	<div class="input-group-text">mm</div> 
          	</div>
		</div> </div>';

$value17='<div class="form-group mt-2 mb-2">
		<input type="text" name="yard_accreditation_number" value="'.$value_id17.'" id="yard_accreditation_number"  class="form-control"  maxlength="20" autocomplete="off" title="Enter Yard Accreditation Number"  data-validation="required alphanumeric" onkeypress="return IsAddress(event);"  onchange="return checklength(this.id)" onpaste="return false;"/>
		</div>';

$value18='<div class="form-group mt-2 mb-2">
		<div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
            </div>
		    <input type="text" class="form-control expdate dob" id="expiry_date" name="yard_accreditation_expiry_date" title="Enter Expiry Date" data-validation="required">
		   </div>
		</div>';

$value19='<div class="form-group mt-2 mb-2">
		<label>
		<input type="radio" name="freeboard_status_id" id="freeboard_status_id_y" value="1" checked> &nbsp;Yes
		</label> &nbsp; &nbsp;
		<label>
		<input type="radio" name="freeboard_status_id"  id="freeboard_status_id_n"  value="0" > &nbsp;No
		</label>
		</div>';


$value20='<div class="form-group mt-2 mb-2" id="bulk_heads_show" >
		<input type="text" name="bulk_heads" value="'.$value_id20.'" id="bulk_heads"  class="form-control"  maxlength="3" autocomplete="off" onkeypress="return IsNumeric(event);" title="Enter Number of Bulk Head" data-validation="number" onchange="return Isdot(this.id);" onpaste="return false;"/>
		</div>';

		$value224='<div class="form-group mt-2 mb-2">
		<input type="text" name="height_of_freeboard" value="'.$value_id224.'" id="height_of_freeboard"  class="form-control"  maxlength="2" autocomplete="off" onkeypress="return IsNumeric(event);" title="Enter height of free board" data-validation="number" onchange="return Isdot(this.id);" onpaste="return false;"/>
		</div>';



	$label_id=$key['label_id'];  

	
	

	//$static_array=array(11,12,13,14,15,16,17,18,19,20); 

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
$("input[type='radio'][name='freeboard_status_id']").click(function() 
{
  if ($("input[type='radio'][name='freeboard_status_id']:checked").val()=='0')
  {
           var num=$("#num_bulk").val();
           //var num=$("#bulk_heads").val();
           //alert(num);
           for(i=1; i<=num;$i++)
           {
                $('#bulk_head_placement'+i).val($(this).data('val')).trigger('change');
              $("#bulk_head_thickness"+i).val('');
           }
          
            $("#bulk_heads_show").hide();  
            $("#num_bulk").hide();
      $("#show_headplacement").hide();
       }
       else
       {
      $("#bulk_heads").val('');
      $("#bulk_heads_show").show();  
      $("#num_bulk").show();
      }
});  


$("#bulk_heads").change(function()
{
    var num=$("#bulk_heads").val();
    if(num!='')
  { 
  $.ajax
    ({
      type: "POST",
      url:"<?php echo site_url('/Kiv_Ctrl/Survey/no_of_bulkhead/')?>"+num,
      success: function(data)
      { 
          //alert(data);
      $("#show_headplacement").show();
      $("#show_headplacement").html(data).find(".div200").select2();
      }
    });
  }

  else
  {
  	$("#show_headplacement").hide();
  }
    //alert(num);
});


$("#hull_thickness").change(function()
{
    var num=$("#hull_thickness").val();
    if(num!=0)
    {
    	if(num>17)
    	{
    		alert("Thickness of hull is not exceed 16mm");
    		$("#hull_thickness").val('');
    		$("#hull_thickness").focus();
    	}
    	else
    	{
    		$("#hull_plating_material_thickness").val(num);
    	}
    }
    });

$("#expiry_date").change(function()
{
var yard_accreditation_expiry_date=$("#expiry_date").val(); 
var CurrentDate = new Date();
var GivenDate1 = yard_accreditation_expiry_date.split("/").reverse().join("-");
var GivenDate = new Date(GivenDate1);
if(GivenDate < CurrentDate)
{
	alert("Invalid Date");
	$("#expiry_date").val('');
}
});




});

</script>
<script>
function checklength(id)
{
  var strvalue=document.getElementById(id).value;  
  //alert(strvalue);
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