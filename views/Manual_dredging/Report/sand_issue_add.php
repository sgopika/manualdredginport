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

 <link rel="stylesheet" href=<?php echo base_url("assets/datepicker-bootsrap/css/datepicker3.css"); ?>>

  <script src="<?php echo base_url('assets/datepicker-bootsrap/js/bootstrap-datepicker.js');?>"></script>

    <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>

      <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>

	  <script type="text/javascript">

	 	$(document).ready(function()

			  {

				

			



		 jQuery.validator.addMethod("nospecial", function(value, element) {

        return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);

			},$.validator.format("<font color='red'>No Special characters allowed.</span>")); 

			jQuery.validator.addMethod("namewithspace", function(value, element) {

			return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);

			},$.validator.format("<font color='red'>Space allowed.</span>"));    	

			jQuery.validator.addMethod("exactlength", function(value, element, param) {

		 		return this.optional(element) || value.length == param;

			}, $.validator.format("<font color='red'>Please enter exactly {0} characters.</span>"));


				//txtchallanno,txtchallandate,txtvehiclemake, txtvehicleregno, txtdrivername,txtdrlicenseno

				

	 $('#sand_issue_add').validate(

		         {

			     rules:

			         { 

						txtchallanno:{required:true,},

		 				txtchallandate:{required:true,},

						txtvehiclemake:{required:true,},

						txtvehicleregno:{required:true,},

						txtdrivername:{required:true,namewithspace:true,nospecial:true,},

						txtdrlicenseno:{required:true,nospecial:true,},
						 txtdrmobno:{required:true,

							exactlength:10,

							nospecial:true,

							digits: true,

							

							},
						  

					},

					 

			  messages:

			         {

						

						txtchallanno:{required:"<font color='red'>Please Enter Challan Number</span>",

						},	

						txtchallandate:{required:"<font color='red'>Please select Challan Date</span>",

						},

						txtvehiclemake:{required:"<font color='red'>Please Enter Vehicle Details</span>",

						},	

						txtvehicleregno:{required:"<font color='red'>Please Enter Vehicle Registration Number</span>",},

						txtdrivername:{required:"<font color='red'>Please Enter Driver Name</span>",},

						txtdrlicenseno:{required:"<font color='red'>Please Enter Driver License Number</span>",},
						  txtdrmobno:{required:"<font color='red'>Please Enter Driver Mobile Number</span>",},
						 
					    }	,

					 

						errorPlacement: function(error, element)

                                              {

                                                   if ( element.is(":input") ) 

                                                       {

                                                             error.appendTo( element.parent() );

                                                       }

                                               else

                                                       { 

                                                             error.insertAfter( element );

                                                       }

                                             }

					 		

		   });	

				



	

});







</script>

<script>

  $(function () {

    //Initialize Select2 Elements

   // $(".select2").select2();



    //Datemask dd/mm/yyyy

    //$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    //Datemask2 mm/dd/yyyy

   // $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});

    //Money Euro

   // $("[data-mask]").inputmask();



 $("#txtchallandate").datepicker();

  });

  

 

</script>

<script>

function check_dates()

{

		var todayTime = new Date();

   		var month = todayTime .getMonth() + 1;

   		 var day = todayTime .getDate();

   		var year = todayTime .getFullYear();

  		 var  todays = day+ "/" +  month + "/" + year;

		 var challandate=document.getElementById("txtchallandate").value;

		var currentDate = Date.parse(todays);

		 var challan_date = Date.parse(challandate);



		if(challan_date <= currentDate)

		{

		

		}

		else

		{

		alert("Challan Date Must be less than today");

		document.getElementById("txtchallandate").value='';

		document.getElementById("txtchallandate").focus();

		

		}

}

			



</script>

<script type="text/javascript">

$(document).ready(function()

{

	$('#rangeoffice').change(function()

				{

					var rangeoffice=$('#rangeoffice').val();

					$.post("<?php echo $site_url?>/Master/getUnitAjax/",{range_office:rangeoffice},function(data)

						{

							$('#unit').html(data);

						});

				});

});

function validate_chk(){			

     	checked = document.querySelectorAll('input[type="checkbox"]:checked').length;

			if(checked<1) {

				document.getElementById('scnDiv').innerHTML="<font color='red'><b>Atleast one Section to be selected!!!</b></font>";

				return false;

			}

}

function showSection(val){

		var x = document.getElementById("unitname").selectedIndex;

		var y = document.getElementById("unitname").options;

		unit_name = y[x].text;

		//alert(unit_name);

	if(unit_name=="DIRECTORATE"){

		document.getElementById('section_id').style.display='';

	}else{

		document.getElementById('section_id').style.display='none';

	}

}

 



</script>

  <script>

  $(document).ready(function() {

	  $("#txtvehicleregno").blur(function()

	  {

		 var str=$("#txtvehicleregno").val(); 

		var strt = str.replace(/[_\W]+/g,"");

		var stru=strt.toUpperCase();

		 //alert(strt);

		 /*if(stru=="KL17D8339" )

		 {

			 $("#txtvehicleregno").val("");

			 alert("This Vehicle has been Blocked,convicted of having comitted a fraud");

			 

		 }*/

	  });

	   $("#txtdrlicenseno").blur(function()

	  {

		 var str=$("#txtdrlicenseno").val(); 

		var strt = str.replace(/[_\W]+/g,"");

		var stru=strt.toUpperCase();

		 //alert(strt);

		/* if(stru=="131005701999")

		 {

			 $("#txtdrlicenseno").val("");

			 alert("This Driver has been Blocked,convicted of having comitted a fraud");

			 

		 }*/

	  });

});

  </script>
  <!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Sand Issue Add</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_zone_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Sand Issue Add</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>
  
          <?php if( $this->session->flashdata('msg')){ 

		   	echo $this->session->flashdata('msg');

		   }?>

            <?php 

			if(isset($int_userpost_sl)){

        $attributes = array("class" => "form-horizontal", "id" => "sand_issue_add", "name" => "sand_issue_add");

			} else {

       $attributes = array("class" => "form-horizontal", "id" => "sand_issue_add", "name" => "sand_issue_add", "onSubmit" => "return validate_chk();");

			}

      
		if(isset($int_userpost_sl)){

       		echo form_open("Manual_dredging/Report/sand_issue_add", $attributes);

		} else {

			echo form_open("Manual_dredging/Report/sand_issue_add", $attributes);

		}?>

		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />

		

             <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">

	  <?php 
		  foreach($get_bookingapprovedadded as $rowmodule){ ?>

	  Token No/ID<font color="#FF0000">*</font>
	  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input  readonly="true" type="text" name="txttokenno" id="txttokenno" value="<?php echo $rowmodule['spot_token']; ?>" /><input type="hidden" name="hid_bookingid" id="hid_bookingid" value="<?php echo $rowmodule['spotreg_id']; ?>"  />
 </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Name<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<?php echo $rowmodule['spot_cusname']; ?>
 </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Requested Ton<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<?php echo $rowmodule['spot_ton']; ?>
 </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Challan Number<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" readonly name="txtchallanno" id="txtchallanno" value="<?php echo $rowmodule['spot_challan'];?>" />
 </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Challan Date<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">		

                 <input type="text" readonly class="form-control"  value="<?php echo date("d/m/Y h:i:s", strtotime(str_replace('-', '/',$rowmodule['challan_timestamp'] )));?>" name="txtchallandate" id="txtchallandate"  onChange="check_dates();" >
 </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Challan Amount<font color="#FF0000">*</font>

			<?php  $challanamt=$rowmodule['spot_amount']; 

			?>

			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input readonly type="text" name="txtchallanamt" id="txtchallanamt" value="<?php echo $challanamt; ?>" />
 </div>
		   </div> <!-- end of row -->
           

	  

	<?php  } ?>
		<div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			
			Vehicle Make<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<textarea name="txtvehiclemake" id="txtvehiclemake"></textarea>
 </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Vehicle Registration Number<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="txtvehicleregno"  id="txtvehicleregno"  class="form-control"  maxlength="100" autocomplete="off" required/> 
			 </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Driver Name<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="txtdrivername"  id="txtdrivername"  class="form-control"  maxlength="100" autocomplete="off" required/> 
			 </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Driver License Number<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="txtdrlicenseno"  id="txtdrlicenseno"  class="form-control"  maxlength="100" autocomplete="off" required/>
			 </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Driver Mobile Number<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="txtdrmobno"  id="txtdrmobno"  class="form-control"  maxlength="10" autocomplete="off" required/> 
			 </div>
		   </div> <!-- end of row -->
           
              

 		<div class="row px-5">
 		
        <div class="col-12 d-flex justify-content-center">

		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />

		<?php if(isset($int_designation_sl)){?>

		 <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />

		<?php } else{?>

		           <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Done"/>

		<?php } ?>

        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />

        </div>

      </div>

		
		   <?php echo form_close(); ?>

		 </div>

          