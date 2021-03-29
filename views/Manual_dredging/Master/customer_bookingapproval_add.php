<?php

//print_r($_REQUEST);

?>
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

					$.post("<?php echo $site_url?>/Master/getUnitAjax/",{range_office:rangeoffice},function(data)

						{

							$('#unit').html(data);

						});

				});

	$('#cl').click(function(){

		$('#show').toggle("slide");

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

<div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Customer Booking Approval </button>
		</div>

    <div class="col-12 d-flex justify-content-end">
     <?php 
	$sess_user_type			=	$this->session->userdata('int_usertype');
	 //echo "fff".$sess_user_type;
	if($sess_user_type==3)
	{ 
		$url=site_url("Manual_dredging/Master/pcdredginghome");
	 }
	  else
	   {
	    $url=site_url('Manual_dredging/Port/port_clerk_main');
	}
	?>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
        
		 <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/customer_bookingapproval"); ?>"> Customer Booking</a></li>
        <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Customer Booking Approval  </strong></a></li>
      </ol>
    </div>
    <!-- Main content -->


<div class="col-md-12">
          <!-- /.box -->
        
        <?php if( $this->session->flashdata('msg'))
		{ 
		   	echo $this->session->flashdata('msg');
		   }?>
      </div> <!-- end of co12 -->
		</div> <!-- end of row -->  


            <?php
			if(isset($empty_stats))

			{

				?>

                <div class="alert alert-warning">

    			<a href="#" class="close" data-dismiss="alert">&times;</a>

    			<strong>Warning!</strong> There are no available dates.

				</div>

				<?php

			}

			else

			{

			?>

            <?php 

			$req_ton=$booking_approval_addVw[0]['customer_booking_request_ton'];

			$bal_ton=$booking_approval_addVw[0]['customer_unused_ton'];

			}

			//print_r($get_userposting_details);

			// echo $get_userposting_details[0]['int_userpost_user_sl'];

			if(isset($int_userpost_sl))
			{

        $attributes = array("class" => "form-horizontal", "id" => "customer_bookingapproval_add", "name" => "customer_bookingapproval_add");

			} 
			else 
			{

       $attributes = array("class" => "form-horizontal", "id" => "customer_bookingapproval_add", "name" => "customer_bookingapproval_add", "onSubmit" => "return validate_chk();");

			}

        

		//print_r($editres); echo $editres[0]['intUserTypeID'];

		if(isset($int_userpost_sl)){

       		echo form_open("Manual_dredging/Master/customer_bookingapproval_add", $attributes);

		} else {

			echo form_open("Manual_dredging/Master/customer_bookingapproval_add", $attributes);

		}?>
		<div class="row p-3" style="font-weight: bold;background-color: lightpink;">
          <div class="col-md-6 d-flex justify-content-center px-2"  style="background-color: lightpink;">
			<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
				<input type="hidden" name="cus_perno" id="cus_perno" value="<?php echo $booking_approval_addVw[0]['customer_booking_monthly_permit_id'];?>" class="form-control" readonly />

       <?php

	
	$get_buk_phone=$this->db->query("select daily_log_balance from daily_log where daily_log_date='$allt_date' and daily_log_zone_id='$zoneid'");

					$data_user=$get_buk_phone->result_array();
					$balton=$data_user[0]['daily_log_balance'];?>
						<input type="hidden" name="cus_phone" value="<?php echo $cus_phone; ?>" />
		
			Balance Ton (<?php echo date("d-m-Y", strtotime(str_replace('/', '-',$allt_date))); ?>)
				</div>
				<div class="col-md-4 d-flex justify-content-start px-2">
					<font  color="#F02528";  ><?php echo $balton; ?></font>
				</div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Customer name
		  </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		   <?php  foreach($booking_approval_addVw as $rowmodule){  ?><input type="text" name="txtcustrname"  id="txtcustrname"  class="form-control" value="<?php echo strtoupper($rowmodule['customer_name']);?>" readonly  maxlength="100" autocomplete="off" required/><input type="hidden" name="hid_custbookid" id="hid_custbookid" value="<?php echo $rowmodule['customer_booking_id']  ?>" /> <?php } ?>
		 </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Alloted Date
		    </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		<input type="text" name="altdate" id="altdate" value="<?php echo date("d-m-Y", strtotime(str_replace('/', '-',$allt_date)));?>" class="form-control" readonly />
		</div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		Alloted Amount in Tons
		 </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		<input type="text" name="alttone" id="alttone" value="<?php echo $booking_approval_addVw[0]['customer_booking_request_ton'];?>" class="form-control" readonly />
		</div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Route To Worksite<font color="#FF0000">*</font>
			 </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<?php echo $booking_approval_addVw[0]['customer_booking_route'];?>
			</div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Distance<font color="#FF0000">*</font>
			 </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<?php echo $booking_approval_addVw[0]['customer_booking_distance'];?>
			</div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Booking Status<font color="#FF0000">*</font>
		    </div>
           <div class="col-md-4 d-flex justify-content-start px-2">

           <?php

		    if($req_ton > $bal_ton)

			{

				?>

				<div class="alert alert-warning">

    			<a href="#" class="close" data-dismiss="alert">&times;</a>

    			<strong>Warning!</strong> Requsted Quantity Higher than Customer Balance !!!.

				</div>

                Reject <input type="radio" name="radiobookingStatus" checked="checked"  value="3" />

                <?php

			}

			else

			{

            ?>

            Approve  <input type="radio" name="radiobookingStatus"  value="2"  checked="checked" />

            Reject <input type="radio" name="radiobookingStatus"  value="3" />

           <?php 

			}

			?>

          </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Remarks<font color="#FF0000">*</font>
			 </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<textarea name="txtremarks" id="txtremarks" class="form-control"></textarea> 
			</div>
		</div> <!-- end of row -->
          
		 <div class="row px-5 py-5" >
 		
        <div class="col-12 d-flex justify-content-center">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
			<?php if(isset($int_designation_sl))
			{ ?>
				<input id="btn_add" name="btn_add" type="submit" class="px-4 btn btn-primary" value="Update" />
		<?php } 
		else{
			?>
		     <input id="btn_add" name="btn_add" type="submit" class=" px-4 btn btn-primary" value="Save"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class=" mx-4 btn btn-danger" value="Cancel" />
    
         </div> <!-- end of col 12 -->
         
	</div> <!-- end of row -->
	
		<?php echo form_close(); ?>
</div> <!-- end of container --> 
		  