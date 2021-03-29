

	  <script type="text/javascript">
	 	$(document).ready(function()
			  {
				
			

		 jQuery.validator.addMethod("nospecial", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);
			});    	
			
				
				
	 $('#userposting').validate(
		         {
			     rules:
			         { 
				  user:{required:true,
				//  nospecial:true,
							},
		 designation:{required:true,
				//  nospecial:true,
							},
							 usergroup:{required:true,
				//  nospecial:true,
							},
							 rangeoffice:{required:true,},
							 unitname:{required:true,},
							start_date:{required:true,},
							  end_date:{required:true,},
				
				     },
					 
			  messages:
			         {
						
						user:{required:"<font color='red'>Please select user</span>",
						},	
						designation:{required:"<font color='red'>Please select designation</span>",
						},
						usergroup:{required:"<font color='red'>Please select user group</span>",
						},	
						rangeoffice:{required:"<font color='red'>Please select range</span>",},
						start_date:{required:"<font color='red'>Please select start date</span>",},
						end_date:{required:"<font color='red'>Please select end date</span>",},
						unitname:{required:"<font color='red'>Please select unit</span>",},

									
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
/* To Disable Inspect Element */
$(document).bind("contextmenu",function(e) {
 e.preventDefault();
});

$(document).keydown(function(e){
    if(e.which === 123){
       return false;
    }
});
</script>
<script>
document.onkeydown = function(e) {
if(event.keyCode == 123) {
return false;
}
if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'H'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'A'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'F'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
return false;
}
}
</script>
<script>
function maxton_calculate()
{
	var plintharea=document.getElementById("customer_plinth_area").value;
	var max_ton=(plintharea*0.33).toFixed(2);

	if(max_ton>100)
	{
		alert("Plinth Area must be less than 303 ");
		document.getElementById("customer_plinth_area").value='';
		document.getElementById("customer_max_allotted_ton").value='';
	}
	else
	{
		document.getElementById("customer_max_allotted_ton").value=max_ton;
	}
}
function check_dates(){
	    var start_date = document.getElementById("start_date").value;
		var end_date = document.getElementById("end_date").value;
		//alert(start_date);
		//alert(end_date);
		if((start_date=="")&&(end_date==""))
		{
				document.getElementById('startdatediv').innerHTML="<font color='red'><b>Please Enter Start date and End date!!!</b></font>";
				document.getElementById('enddatediv').innerHTML="";
		}
		else if((start_date=="")&&(end_date!=""))
		{
				document.getElementById('startdatediv').innerHTML="<font color='red'><b>Please Enter Start date!!!</b></font>";
				document.getElementById('enddatediv').innerHTML="";
		}
		else if((start_date!="")&&(end_date==""))
		{
				document.getElementById('enddatediv').innerHTML="<font color='red'><b>Please Enter end date!!!</b></font>";
				document.getElementById('startdatediv').innerHTML="";
		}
		else
		{	
			 var startdate 	= start_date.split('/');
			 startdate 	= new Date(startdate[2], startdate[1], startdate[0]); 
			 var enddate 	= end_date.split('/'); 
			 enddate 	= new Date(enddate[2], enddate[1], enddate[0]); 
			 if (startdate > enddate ) { 
			 	document.getElementById("start_date").value='';
				document.getElementById("end_date").value='';
				document.getElementById('enddatediv').innerHTML="<font color='red'><b>Start Date Cannot be greater than end date!!!</b></font>";
				document.getElementById('startdatediv').innerHTML="";
				return false; 
			} else {
				document.getElementById('startdatediv').innerHTML="";
				document.getElementById('enddatediv').innerHTML="";
			}
		}
}
			

</script>
<script type="text/javascript">
$(document).ready(function()
{
	$('#customer_max_allotted_ton').change(function()
				{
					var requestedton=$('#customer_max_allotted_ton').val();
					var construct_masterid=$('#customer_purpose').val();
					
					$.post("<?php echo $site_url?>/Manual_dredging/Master/Checkallotedton/",{requestedton:requestedton,construct_masterid:construct_masterid},function(data)
						{
					//	alert(data);
						if(data==1){document.getElementById("lbldisplay").innerHTML ='';}else{ alert("Please enter request ton"); $( "#customer_max_allotted_ton" ).val('');$( "#customer_max_allotted_ton" ).focus();}
							
						});
				});
				
				
});
</script>
<script type="text/javascript">
$(document).ready(function()
{
	$('#rangeoffice').change(function()
				{
					var rangeoffice=$('#rangeoffice').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getUnitAjax/",{range_office:rangeoffice},function(data)
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
 
function checkconstruction()
{
	var purpose=document.getElementById("customer_purpose").value;
	if(purpose==1)
	{
		$("#plintharea_tr").css("display","table-row");
		document.getElementById("customer_max_allotted_ton").value='';
		document.getElementById("lbldisplay").innerHTML ="";
	}
	else
	{
		$("#plintharea_tr").css("display","none");
		document.getElementById("customer_max_allotted_ton").value='';
		
		document.getElementById("lbldisplay").innerHTML ="Maximum Ton alloted is 6 !!!";
	}
}
</script>
   
   <body>
 
<section class="login-block">
      <div class="container">
      	
      	<div class="row">
    <div class="col">      <img src="<?php echo base_url(); ?>plugins/img/logo.png"  alt="PortInfo">
    </div>
     <div class="col-4 border-left pb-2">
      <i class="fas fa-user-plus mt-5 text-primary"></i> <font class="text-primary"> 
      	<span class="eng-content"> Spot Booking  </span><br>
      	<span class="mal-content mal_content_reg">   സ്പോട്ട്  ബുക്കിംഗ്  </span> </font>  <hr>
     <!--  <button type="button" class="btn btn-primary btn-point btn-flat eng-content" id="mal-button" >Malayalam</button>
      <button type="button" class="btn btn-primary btn-point btn-flat mal-content" id="eng-button">English</button> -->
    </div> 
 </div>
        <div class="rows">
          <!-- /.box -->
        <div class="col-12" >

        	 <h3 align="center" class="box-title">Spot Registration</h3>
        	 <hr>

        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      <!--      </div> -->
		  
            
        <div class="box box-primary box-blue-bottom">
            
            <?php 
			
        $attributes = array("class" => "form-horizontal", "id" => "customerregistration_add", "name" => "customerregistration_add");
		
       		echo form_open("Manual_dredging/Report/Onlinepayment_spot", $attributes);
		
			?>
	
      <input type="hidden" name="hash" id="hash" value="<?php echo $hash ?>"/>
    
	 
	    <input type="hidden" name="surl" value="http://localhost/apyu/response.php" />   <!--Please change this parameter value with your success page absolute url like http://mywebsite.com/response.php. -->
		 <input type="hidden" name="furl" value="http://localhost/apyu/response.php" /><!--Please change this parameter value with your failure page absolute url like http://mywebsite.com/response.php. -->
	  
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		
              <table id="vacbtable" class="table table-bordered table-striped">

    <?php //print_r($get_bookingdata); exit();
	foreach ($get_bookingdata as $rowsmodule){ ?>
        <tr >
      		<td>Token Number <font color="#FF0000">*</font>
      		  
      		  <input type="hidden" name="hid_bookingid" id="hid_bookingid" value="<?php echo $rowsmodule['spotreg_id']; ?>" readonly /> </td>
      		<td ><?php echo $rowsmodule['spot_token'];?></td>
      	</tr>
        
        <tr >
      		<td>Name<font color="#FF0000">*</font></td>
      		<td ><?php echo $rowsmodule['spot_cusname']; ?> </td>
      	</tr>
        
        <tr >
      		<td>Mobile Number <font color="#FF0000">*</font></td>
      		<td ><?php echo $rowsmodule['spot_phone']; ?> </td>
      	</tr>
          <tr >
      		<td>Requested Ton<font color="#FF0000">*</font></td>
      		<td ><?php echo $rowsmodule['spot_ton']; ?> </td>
      	</tr>
     
        <tr >
      		<td>Amount<font color="#FF0000">*</font></td>
      		<td ><?php echo $rowsmodule['spot_amount']; ?> </td>
      	</tr>
		<tr >
      		<td>Email <font color="#FF0000">*</font></td>
      		<td ><input type="text"  name="custemail" id="custemail" value="abcd@gmail.com"  /> </td>
      	</tr>
		  <?php } ?>
		  <tr >
      		<td>Select Bank <font color="#FF0000">*</font></td>
      		<td >
      		<select  name="banktype"  id="banktype"  class="form-control"  maxlength="100">

            <option value="" selected="selected">--select--</option>

            <?php foreach($get_banktype as $p)

			{

		?>

            <option value="<?php echo $p['bank_type_id'];?>"><?php echo $p['bank_name'];?></option>

            <?php

				

			}

			?>

            </select>
      		</td>
      	</tr>
	  </table>
  		 <script type="text/javascript">
        function vali()
		{
			var a=confirm("are you sure?");
			if(a==true)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
        </script> 
 		<div class="form-group" align="center">
        <div class="col-12 text-center">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		
		 <?php if(!$hash) { ?>
            <td colspan="4"><input class="btn btn-primary" type="submit" value="Submit" />&nbsp;<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" /></td>
          <?php } ?>
        </div>
        </div>
		

    </form>
          
              
		   <?php //echo form_close(); ?>
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
  </section>
