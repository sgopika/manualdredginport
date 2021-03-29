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

  <link rel="stylesheet" href=<?php echo base_url("assets/plugins/datepicker/datepicker3.css"); ?>>

   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>

      <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>

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

	$('#rangeoffice').change(function()

				{

					var rangeoffice=$('#rangeoffice').val();

					$.post("<?php echo $site_url?>/Manual_dredging/Master/getUnitAjax/",{range_office:rangeoffice},function(data)

						{

							$('#unit').html(data);

						});

				});

$('#portdc').change(function()

				{

					//alert("hello");

					var port_id=$('#portdc').val();

					//getamt(port_id);

					//var period =$('#periodb').val();

					$.post("<?php echo $site_url?>/Manual_dredging/Port/getzones_for_p/",{port_id:port_id},function(data)

						{

							//alert("hello");

							$('#zone_id').html(data);

						});

				});

$('#zone_id').change(function()

	{

	var port_id=$('#portdc').val();

	var zone_id=$('#zone_id').val();

	

	

	//alert(zone_id);

	getamt(port_id,zone_id);

	});

});



function getamt(port_id,zone_id)

{

	$.post("<?php echo $site_url?>/Manual_dredging/Port/getqty/",{port_id:port_id,zone_id:zone_id},function(data)

						{

							//alert("hello");

							$('#quantity_id').html(data);

						});

}

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


<div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Zone</button>
		</div>
		
     <div class="col-12 d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/customer_home"); ?>"> Home</a></li>
         <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/customer_booking"); ?>"> Customer Booking </a></li>
       
      </ol>
</div>

    <!-- Main content -->
   	<div class="col-md-12">
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      <!--      </div> -->
		 </div> <!-- end of co12 -->
		</div> <!-- end of row -->  

   

            <?php 

			//print_r($get_userposting_details);

			// echo $get_userposting_details[0]['int_userpost_user_sl'];

			if(isset($int_userpost_sl)){

        $attributes = array("class" => "form-horizontal", "id" => "customer_login_add", "name" => "customer_login_add");

			} else {

       $attributes = array("class" => "form-horizontal", "id" => "customer_login_add", "name" => "customer_login_add", "onSubmit" => "return validate_chk();");

			}

        

		//print_r($editres); echo $editres[0]['intUserTypeID'];

		if(isset($int_userpost_sl)){

       		echo form_open("Manual_dredging/Master/customer_booking_add", $attributes);

		} else {

			echo form_open("Manual_dredging/Master/customer_booking_add", $attributes);

		}?>

<div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">



		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />

		

<?php  foreach($customerreg_data as $rowmodule){   ?><input type="hidden" name="hid_custid" id="hid_custid" value="<?php echo $rowmodule['customer_registration_id'];  ?>" /> <?php } ?>



            Select Port
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
	   <select name="portdc" id="portdc" class="form-control">

                <option selected="selected" value="">select</option>

                <?php 

				foreach($port_det as $pd)

				{

				?>

                <option value="<?php echo $pd['int_portoffice_id'];?>"><?php echo $pd['vchr_portoffice_name'];?></option>

                <?php

				}

				?>

         </select>

       </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
	  Select Zone<font color="#FF0000">*</font>
	  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">

            <select name="zone_id" id="zone_id" class="form-control">

            </select>
</div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
	  Select Required Ton<font color="#FF0000">*</font>
	 </div>
           <div class="col-md-4 d-flex justify-content-start px-2">

           <select name="quantity_id" id="quantity_id"   class="form-control"  >

           	 

           </select> 

            
</div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Route to the Unloading Place<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<textarea class="form-control" name="txtrouteunloadplace" id="txtrouteunloadplace"></textarea>

          </div>
		   </div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Distance to the Unloading Place<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<input type="text" name="txtdistanceunloadplace"  id="txtdistanceunloadplace"  class="form-control"  maxlength="100" autocomplete="off" required/>
			</div>
		   </div> <!-- end of row -->
           

  		 

 		<div class="row px-5 py-5">
 		
        <div class="col-12 d-flex justify-content-center">

		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />

		<?php if(isset($int_designation_sl)){?>

		 <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />

		<?php } else{?>

		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save"/>





		<?php } ?>

       &nbsp; <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />

        </div>

        </div>
        
	   <?php echo form_close(); ?>
	   <?php echo form_close(); ?>

</div> <!-- end of container -->