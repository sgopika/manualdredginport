<?php  

$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$survey_id1         = $this->uri->segment(6);

 $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
 $vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl=$this->encrypt->decode($processflow_sl); 

$survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
$survey_id=$this->encrypt->decode($survey_id); 




$engineset 			=	$this->Survey_model->get_no_of_engineset_dynamic($vessel_id,$survey_id);
$data['engineset']	=	$engineset;
//print_r($engineset);
if(!empty($engineset))
{
	@$no_of_engineset 	=	$engineset[0]['engine_count'];
}




$engine_details 		=	$this->Survey_model->get_engine_details_dynamic($vessel_id,$survey_id);
$data['engine_details']	=	$engine_details;

//print_r($engine_details);
//$engine_sl= $key['engine_sl'];
$portofregistry			    = 	$this->Survey_model->get_portofregistry();
$data['portofregistry'] 	=	$portofregistry;
                         

$vessel=$this->Survey_model->get_vessel($vessel_id);
$data['vessel']=$vessel;

if(!empty($vessel))
{

 	$vessel_registry_port_id=$vessel[0]['vessel_registry_port_id'];
}


if($tariff_form3!=0)
{
	  @$tariff_amount=$tariff_form3[0]['tariff_amount'];
}
else
{
	 $tariff_amount=0;
}

 ?>


<script>
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
</script>
<script language="javascript">
    
$(document).ready(function(){

$("#tab2next").hide(); //proceed
$("#btnsubmit").hide(); //submit


$("#tab1next").click(function()
{
 //if($("#form1").isValid())
 // {

 var no_of_engineset=$("#no_of_engineset").val();
 var data = new FormData();
  var form_data = $('#form1').serializeArray();
//alert(cntcount);
  $.each(form_data, function (key, input)
  {
    data.append(input.name, input.value);
  });

var var1=$('input[name="builder_certificate_document"]').val();
//alert(var1);

var var2=$('input[name="chainport_test_certificate"]').val();
var var3=$('input[name="chainstarboard_test_certificate"]').val();



if(var1!='undefined')
{
	 var file_data = $('input[name="builder_certificate_document'+'"]').prop('files')[0];  
      if(file_data!='undefined')
      {
        data.append("builder_certificate_document", file_data);
      }
}
else
{
	
}

//if(var2!='undefined')
if($('input[name="chainport_test_certificate"]').length)
{
   var file_data = $('input[name="chainport_test_certificate'+'"]').prop('files')[0];  
      if(file_data!='undefined')
      {
        data.append("chainport_test_certificate", file_data);
      }
  }
  else
  {
  	
  }
       
//if(var3!='undefined')
if($('input[name="chainstarboard_test_certificate"]').length)
{
	  var file_data = $('input[name="chainstarboard_test_certificate'+'"]').prop('files')[0];  
      if(file_data!='undefined')
      {
        data.append("chainstarboard_test_certificate", file_data);
      }
 }
  else
  {
  	
  }

   for(var j=0; j<=no_of_engineset; j++)
  {
    if($('input[name="test_certificate_upload'+j+'"]').length)
    {
      var file_data = $('input[name="test_certificate_upload'+j+'"]').prop('files')[0];  
      if(file_data!='undefined')
      {
        data.append("test_certificate_upload"+j, file_data);
      }
    }
  }

    $.ajax({
    url : "<?php echo site_url('Kiv_Ctrl/Survey/Form3_details_entry')?>",
    type: "POST",
  
   	  data: data,
      contentType: false,       
      cache: false,             
      processData:false, 
    success: function(data)
    {
    	//alert(data);
    	//exit;
    	
     alert("Form 3 Details inserted Successfully");
      $('.nav-item a[href="#tab2"]').tab('show');
      }
    });
//  }
}); 







$("#pay_now").click(function()
{
	$("#tab2next").show(); //proceed
	$("#btnsubmit").hide(); //submit
});


$("#pay_later").click(function()
{
	$("#tab2next").hide(); //proceed
	$("#btnsubmit").show(); //submit
});


  //------------------- Payment Details ---------------// 
 

$("#btnsubmit").click(function()
{
  if($("#form2").isValid())
  { 
  /*var form = $("#form");
  form.validate();
  if(form.valid())
  {*/
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/not_payment_details_form3')?>",
      type: "POST",
      data:$('#form2').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
        
        alert("Please pay fees later");
        window.location.href = "<?php echo site_url('Kiv_Ctrl/Survey/SurveyHome'); ?>";
      }
    }); 
  }
});

  
	
//------------JQUERY END--------------------//	

});

function IsNumeric(e) 
{
	var unicode = e.charCode ? e.charCode : e.keyCode;
	if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)) 
	{
	    return true;
	}
	else 
	{
	    window.alert("This field accepts only Numbers");
	    return false;
	}
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
        
</script>
<?php 

$current_status         =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status'] =   $current_status;
@$status_details_sl     =   $current_status[0]['status_details_sl'];


$process_id 			=	$vessel_details[0]['process_id']; 
$current_status_id 		=	$vessel_details[0]['current_status_id'];
          
           
            $previous_module_id           =   $vessel_details[0]['previous_module_id'];
            $user_type_user_id            =   $this->Survey_model->get_user_type_user_id($previous_module_id);
            $data['user_type_user_id']    =   $user_type_user_id;
            @$user_type_id1               =   $user_type_user_id[0]['current_position'];
            @$user_id1                    =   $user_type_user_id[0]['user_id'];

            if(@$user_type_id1=='')
            {
              $user_type_id=4;///Chief surveyor new user_type_id=11
            }
            else
            {
              $user_type_id=$user_type_id1;
            }

            if(@$user_id1=='')
            {
              $user_id=4;
            }
            else
            {
              $user_id=$user_id1;
            }

?>

<!-- Design Start -->

<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ">  <!-- Container Class overridden for edge free design -->
  <div class="row">
  <div class="col-12"> 
  	<div class="row">
  	
      

<div class="col-2 mt-1 ml-5">
  			 <button type="button" class="btn btn-primary kivbutton btn-block"> Form 3</button> 
  		</div> <!-- end of col-2 -->
      <div class="col mt-2 text-primary">
       FORM No. 3  [ See Rule 6 (4) ]  Particulars to be furnished for Survey of  New Vessel or Vessels which are to be surveyed for the first time
      </div>



  	</div> <!-- inner row -->
  </div> <!-- end of col-12 add-button header -->
  <div class="col-12 mt-2 ml-2 newfont">  
  	<?php //include ('tab.php'); ?>





<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="form3tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="form3Details" aria-selected="true">Form 3 Entry</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" id="form3fees" data-toggle="tab" href="#tab2" role="tab" aria-controls="form3fees" aria-selected="true">Form 3 fees</a>
  </li>
</ul>

<!-- ______________________ form 3 Details Start _________________________ -->

<div class="tab-content " id="myTabContent">

<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="form3tab">
<!-- start of content in tab pane -->

<!-- <form name="form1" id="form1" method="post" class="form1"  action="<?php //echo $site_url.'/Survey/Form3_details_entry'?>" enctype="multipart/form-data" >
 -->
<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
  echo form_open("Kiv_Ctrl/Survey/Form3_details_entry", $attributes);
  ?> 

<input type="hidden" name="no_of_engineset" id="no_of_engineset" value="<?php echo $no_of_engineset; ?>">
<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<input type="hidden" name="current_position" id="current_position" value="<?php echo $user_type_id; ?>">
<input type="hidden" name="current_status_id" id="current_status_id" value="<?php echo $current_status_id 
; ?>">


<?php 
//$i=1;

$heading_id1=18;
$form_id=3;
$label_details=$this->Survey_model->get_label_details_ajax($form_id,$heading_id1);
$data['label_details']=$label_details;

$static_array = array_column($label_details, 'label_sl');
if(!empty($label_control_details_head2))
{

$var_row=0;
$var_color=0;
foreach ($label_control_details_head2 as $key) {
	$label_id=$key['label_id'];
	# code...

$value83='<div class="form-group mt-2 mb-2">
		<input type="text" name="hull_year_of_built" value="" id="hull_year_of_built"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Year of Built of Hull"  data-validation="required number" onkeypress="return IsNumeric(event);" />Eg:2012
			</div>';
$value84='<div class="form-group mt-2 mb-2">
			<input type="file" name="builder_certificate_document" id="builder_certificate_document" onChange="validate_file(this.value,this.id)" >
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











<?php 





$heading_id2=19;
$form_id=3;
$label_details1=$this->Survey_model->get_label_details_ajax($form_id,$heading_id2);
$data['label_details1']=$label_details1;
$static_array1 = array_column($label_details1, 'label_sl');

//print_r($label_details1);

	if(!empty($label_control_details_head3))
	{
		$var_row=0;
		$var_color=0;

	$j=0;
	foreach ($label_control_details_head3 as $key) {
		
$value85='<div class="form-group mt-2 mb-2">
			<input type="text" name="make_year[]" value="" id="make_year"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Year of Built of Engine"  data-validation="required number" onkeypress="return IsNumeric(event);"  />Eg:2012
			</div>';			
$value86='<div class="form-group mt-2 mb-2">
			<input type="file" name="test_certificate_upload'.$j.'" id="test_certificate_upload" onChange="validate_file(this.value,this.id)">
			</div>';


	$label_id=$key['label_id'];

	if(in_array($label_id,$static_array1))
	{
		$g = "value".$label_id;
		$label_controls1= ${$g};

	}
	else
	{
		
		$label_controls1='';
	}
		

 ?>


<?php //for($i=1;$i<=$no_of_engineset;$i++) { 
	$i=1;
foreach($engine_details as $key1) {
		?>

<div class="row no-gutters">

		<input type="hidden" name="hdn_engine_sl[]" value="<?php echo $key1['engine_sl']?>"> 
		<div class="col-6 border-top border-bottom border-left pl-2">
    <p class="mt-3 mb-3"><?php echo  $key['label_name'];?> of engine <?php echo $i; ?> </p>
    </div>
		<div class="col-6 border-top border-bottom border-left pl-2">
   <?php  echo $label_controls1;  //echo $key['label_controls']; ?>
    </div>

</div>

 <?php
 $i++;
	}
?>

<!-- Copy ends here based on database comparison -->

<?php 
} // End of for each;
$j++;
}

?>

<?php 
	//$i=1;

$heading_id3=20;
$form_id=3;
$label_details3=$this->Survey_model->get_label_details_ajax($form_id,$heading_id3);
$data['label_details3']=$label_details3;
$static_array3 = array_column($label_details3, 'label_sl');
//print_r($label_details3);

if(!empty($label_control_details_head4))
{
$var_row=0;
$var_color=0;

foreach ($label_control_details_head4 as $key) {
	

$value87='<div class="form-group mt-2 mb-2">
			<input type="file" name="chainport_test_certificate" id="chainport_test_certificate" onChange="validate_file(this.value,this.id)">
			</div>';
$value88='<div class="form-group mt-2 mb-2">
			<input type="file" name="chainstarboard_test_certificate" id="chainstarboard_test_certificate" onChange="validate_file(this.value,this.id)">
			</div>';

	 $label_id=$key['label_id'];
	

if(in_array($label_id,$static_array3))
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

<div class="row no-gutters eventab">		
<div class="col-12 d-flex justify-content-end">
<button type="button" class="btn btn-primary btn-flat  btn-point btn-md" name="tab1next" id="tab1next" ><i class="far fa-save"></i>&nbsp;Save &amp; proceed</button>
</div> <!-- End of button col -->
	</div>		
<!-- </form> --> <?php echo form_close(); ?>
  </div><!-- end of tab-pane 1 -->

<!-- ______________________ form 3 Details  End_________________________ -->

<!--________________________ Payment Start_____________________________ -->

<div class="tab-pane fade " id="tab2" role="tabpanel" aria-labelledby="paymenttab">
<!-- <form name="form2" id="form2" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/add_payment_details_form3' ?>" enctype="multipart/form-data"> -->  
	<?php
$attributes = array("class" => "form-horizontal", "id" => "form2", "name" => "form2", "enctype"=> "multipart/form-data");
  echo form_open("Kiv_Ctrl/Survey/add_payment_details_form3", $attributes);
  ?> 

<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<input type="hidden" name="current_position" id="current_position" value="<?php echo $user_type_id; ?>">
<input type="hidden" name="current_status_id" id="current_status_id" value="<?php echo $current_status_id 
; ?>">


<div class="row no-gutters eventab">
<div class="col-3 border-top border-bottom"> <p class="mt-3 mb-3">Port of Registry</p></div>
<div class="col-3 border-top border-bottom"><p class="mt-3 mb-3">
   <select class="form-control select2 " name="portofregistry_sl" id="portofregistry_sl"  title="" data-validation="required">
  <option value="">Select</option>
  <?php   foreach ($portofregistry as $res_portofregistry)
  {
  ?>
  <option value="<?php echo $res_portofregistry['int_portoffice_id']; ?>"<?php //if($vessel_registry_port_id==$res_portofregistry['portofregistry_sl']) { echo "selected"; } ?>><?php echo $res_portofregistry['vchr_portoffice_name'];?>  </option>
  <?php    }    ?>
  </select></p>
</div>

<div class="col-3 border-top border-bottom border-left pl-2"><p class="mt-3 mb-3">Bank</p></div>
<div class="col-3 border-top border-bottom"><p class="mt-3 mb-3"><div class="input-group">
   
   
 <select class="form-control select2 " name="bank_sl" id="bank_sl"  title="" data-validation="required">
  <option value="">Select</option> 
  <?php   foreach ($bank as $res_bank)
  {
  ?>
  <option value="<?php echo $res_bank['bank_sl'];?>" ><?php echo $res_bank['bank_name'];?>  </option>
  <?php    }    ?>
  </select>

    </div></p> </div>

</div>


<div class="row no-gutters oddtab">
<div class="col-3 border-top border-bottom"> <p class="mt-3 mb-3">Amount</p></div>
<div class="col-3 border-top border-bottom"><p class="mt-3 mb-3">
 <input type="text" class="form-control" name="dd_amount" value="<?php echo "1"; ?>" readonly id="dd_amount" maxlength="8" autocomplete="off"  required ></p>
</div>

<div class="col-3 border-top border-bottom border-left pl-2"><p class="mt-3 mb-3"></p></div>
<div class="col-3 border-top border-bottom"><p class="mt-3 mb-3"><div class="input-group">
    </div></p> </div>

</div>



<div class="row no-gutters mx-0 mt-5 mb-5">
<div class="col-6 d-flex justify-content-end pr-5">
 <button type="button" class="btn btn-success btn-flat btn-point btn-lg" name="pay_now" id="pay_now"><i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;&nbsp;Pay Now</button> 

</div>
<div class="col-6 d-flex justify-content-start pl-5">
<button type="button" class="btn btn-secondary  btn-flat  btn-point btn-lg" name="pay_later" id="pay_later" ><i class="fas fa-business-time"></i>&nbsp;&nbsp;&nbsp;Pay Later</button>
</div>
</div>


 <div class="row mx-0 mb-3 no-gutters eventab" id="submitbtn">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">
</div> 
<div class="col-1 d-flex justify-content-end">
 <button type="submit" class="btn btn-primary btn-flat  btn-point btn-md" name="tab2next" id="tab2next" ><i class="far fa-save"></i>&nbsp;&nbsp;Save &amp; Proceed</button>
<button type="button" class="btn btn-success btn-flat  btn-point btn-md" name="btnsubmit" id="btnsubmit" ><i class="far fa-save"></i>&nbsp;Submit</button>
</div>
</div> 

<!-- </form> --> <?php echo form_close(); ?>
</div>
<!--________________________ Payment End_____________________________ -->



</div> <!-- end of tab -content -->
  </div> <!-- end of col-12 main col -->
</div> <!-- end of main row -->
</div> <!-- end of container div -->

<!-- Design End -->

<script type="text/javascript">
$(document).ready(function()
{


$("#hull_year_of_built").change(function()
{

var newdate=$("#hull_year_of_built").val();
var len=newdate.length;
if(len<4)
{
	alert("Invalid year");
	$("#hull_year_of_built").val('');
}

var GivenDate = newdate.split("-").reverse();
var CurrentDate = new Date();
GivenDate = new Date(GivenDate);

if(GivenDate > CurrentDate)
{
    alert('Invalid year');
    $("#hull_year_of_built").val('');
}
});



$("#make_year").change(function()
{
 
var newdate=$("#make_year").val();
var len=newdate.length;
if(len<4)
{
	alert("Invalid year");
	$("#make_year").val('');
}

var GivenDate = newdate.split("-").reverse();
var CurrentDate = new Date();
GivenDate = new Date(GivenDate);

if(GivenDate > CurrentDate)
{
    alert('Invalid date');
    $("#make_year").val('');
}
});




});


var _URL = window.URL || window.webkitURL;
function validate_file(file,myid) 
{
  var fsize = $('#'+myid)[0].files[0].size;
  var filename=file;
  var extension = filename.split('.').pop().toLowerCase();

  if($.inArray(extension, ['pdf','doc','docx','odt']) == -1) 
  {
    alert('Sorry, invalid extension.');
    $("#"+myid).val('');
    return false;
  }

  if(fsize>1000000)
  {
    alert("File Size is Exeed 1MB (1024 KB)");
    $("#"+myid).val('');
    return false;
  }
}  

      function IsNumeric(e) 
        {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)) 
        {
                return true;
        }
        else 
        {
                window.alert("This field accepts only Numbers");
                return false;
        }
        }


</script>








