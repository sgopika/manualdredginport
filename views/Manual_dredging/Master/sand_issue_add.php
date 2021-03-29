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
	  $("#txtvehicleregno").change(function()
	  {
		 // var vehicleregno=$("#txtvehicleregno").val();
//		  
//		  $.post("<?php echo $site_url?>/Report/checkvehicleblocked/",{vehicleregno:vehicleregno},function(data)
//						{
//			  alert(data); exit();
//							$('#unit').html(data);
//						});
		//  var regarray = ["KL01AQ2841"];
		var regarray = [""];
		 var str=$("#txtvehicleregno").val(); 
		var strt = str.replace(/[_\W]+/g,"");
		var stru=strt.toUpperCase();
		 var a = regarray.indexOf(stru);
		 //alert(strt);
		 if(a>=0)
		 {
			 $("#txtvehicleregno").val("");
			 alert("This Vehicle has been Blocked");
			 
		 }
	  });
	  /* $("#txtdrlicenseno").blur(function()
	  {
		 var str=$("#txtdrlicenseno").val(); 
		var strt = str.replace(/[_\W]+/g,"");
		var stru=strt.toUpperCase();
		 //alert(strt);
		 if(stru=="131005701999")
		 {
			 $("#txtdrlicenseno").val("");
			 alert("This Driver has been Blocked,convicted of having comitted a fraud");
			 
		 }
		
	  }); */
});
  </script>

<!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Sand issue</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<nav>
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_zone_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Sand issue</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->

     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 



        <?php if( $this->session->flashdata('msg')){ 

		   	echo $this->session->flashdata('msg');

		   }?>


<div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">

    <!-- Main content -->
    
     
        <div class="col-md-9">
          <!-- /.box -->
        <div class="box" >
       
		  
            
        <div class="box box-primary box-blue-bottom">
            <div class="box-header ">
              <h3 class="box-title"><?php
			
			   if(isset($int_userpost_sl)){?>Edit<?php } else {?> <?php }?>
              <a href="<?php echo site_url("Manual_dredging/Master/sand_issue_add"); ?>"><strong>Sand Issue Details</strong></a><?php /*?><a href="<?php echo site_url("Master/getChellanHtmlContent"); ?>"><strong>Sand Issue Details</strong></a><?php */?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "sand_issue_add", "name" => "sand_issue_add");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "sand_issue_add", "name" => "sand_issue_add", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Master/sand_issue_add", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/sand_issue_add", $attributes);
		}?>
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		
              <table id="vacbtable" class="table table-bordered table-striped">

      
	  <?php foreach($get_bookingapprovedadded as $rowmodule){ ?>
	   <tr >
  
      		<td>Token No/ID<font color="#FF0000">*</font></td>
      		<td><input  readonly="true" type="text" name="txttokenno" id="txttokenno" value="<?php echo $rowmodule['customer_booking_token_number']; ?>" /><input type="hidden" name="hid_bookingid" id="hid_bookingid" value="<?php echo $rowmodule['customer_booking_id']; ?>"  />
           </td> 
      	</tr>

		<tr >
  
      		<td>Requested Ton<font color="#FF0000">*</font></td>
      		<td><?php echo $rowmodule['customer_booking_request_ton']; ?>
           </td> 
      	</tr>
		 <tr >
      		<td>Challan Number<font color="#FF0000">*</font></td>
      		<td><input type="text" readonly name="txtchallanno" id="txtchallanno" value="<?php echo $rowmodule['customer_booking_chalan_number'];?>" />
           </td>
      	</tr>
	  <tr >
      		<td>Challan Date<font color="#FF0000">*</font></td>
      		<td>
 
				
                 <input type="text" readonly class="form-control"  value="<?php echo date("d/m/Y h:i:s", strtotime(str_replace('-', '/',$rowmodule['challan_timestamp'] )));?>" name="txtchallandate" id="txtchallandate"  onChange="check_dates();" >
           </td>
      	</tr>
		<tr >
  
      		<td>Challan Amount<font color="#FF0000">*</font>
			<?php  $challanamt=$rowmodule['customer_booking_chalan_amount']; 
			///$sandrate = $permitamount["sand_rate"]; 
			
			//$challanamt = $requestton * $sandrate;
			?>
			</td>
      		<td> 	<input readonly type="text" name="txtchallanamt" id="txtchallanamt" value="<?php echo $challanamt; ?>" />
           </td>
      	</tr>
	  
	<?php  } ?>
			
        <tr >
  
      		<td>Vehicle Make<font color="#FF0000">*</font></td>
      		<td><textarea name="txtvehiclemake" id="txtvehiclemake"></textarea>
           </td>
      	</tr>
		<tr >
      		<td>Vehicle Registration Number<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="txtvehicleregno"  id="txtvehicleregno"  class="form-control"  maxlength="100" autocomplete="off" required/> </td>
      	</tr>
		<tr >
      		<td>Driver Name<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="txtdrivername"  id="txtdrivername"  class="form-control"  maxlength="100" autocomplete="off" required/> </td>
      	</tr>
		<tr >
      		<td>Driver License Number<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="txtdrlicenseno"  id="txtdrlicenseno"  class="form-control"  maxlength="100" autocomplete="off" required/> </td>
      	</tr>
      		<tr >
      		<td>Driver Mobile Number<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="txtdrmobno"  id="txtdrmobno"  class="form-control"  maxlength="10" autocomplete="off" required/> </td>
      	</tr>

	  </table>
  		 
 		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
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
<!--          </div>
            </div>
-->			 </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->
  </div>
</div>