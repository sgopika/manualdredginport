

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

      <script src=<?php echo base_url("assets/datepicker-bootsrap/js/bootstrap-datepicker.js");?>></script>
<style>
	.switch {
  position: relative;
  display: inline-block;
  width: 137px;
  height: 35px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ca2222;
  -webkit-transition: .4s;
  transition: .4s;
   border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 30px;
  left: 10px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #2ab934;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(90px);
  -ms-transform: translateX(90px);
  transform: translateX(90px);
}

/*------ ADDED CSS ---------*/
.slider:after
{
 content:'Not alloted';
 color: white;
 display: block;
 position: absolute;
 transform: translate(-50%,-50%);
 top: 50%;
 left: 50%;
 font-size: 9px;
 font-family: Verdana, sans-serif;
}

input:checked + .slider:after
{  
  content:'Alloted';
}

/*--------- END --------*/
</style>
	  <script type="text/javascript">

	$(document).ready(function() {

		jQuery.validator.addMethod("no_special_check", function(value, element) {

        	return this.optional(element) || /^[a-zA-Z0-9\s.-]+$/.test(value);

		});

		jQuery.validator.addMethod("name_check", function(value, element) {

        	return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);

		});

		jQuery.validator.addMethod("act_check",function (value,element)    {

			return this.optional(element)||/^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s]+$/.test(value);

		});

		jQuery.validator.addMethod("address_check",function (value,element)    {

			return this.optional(element)||/^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s\,]+$/.test(value);

		});

		jQuery.validator.addMethod("email_check", function(value, element)	 {

			  return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);

		});

  		$("#addzone").validate({

		rules: {

				int_port: {

					required: true,

					//no_special_check: true,

					maxlength: 20,

				},

				vch_un: {

					required: true,

					maxlength: 20,

				},

				vch_ph: {

					required: true,

					number:true,

					minlength: 10,

					maxlength: 10,

				},

		},

		messages: {

				int_port: {

					required: "<font color='#FF0000'> select port!!</font>",

					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",

				},

				vch_un: {

					required: "<font color='#FF0000'> username required!!</font>",

					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",

				},

				vch_ph: {

					required: "<font color='#FF0000'> Phone required!!</font>",

					number: "<font color='#FF0000'> Only Numberss!!</font>",

					minlength: "<font color='#FF0000'> Minimum 10 characters needed!!</font>",

					maxlength: "<font color='#FF0000'> Maximum 10 characters allowed!!</font>",

				},

		},

    	errorElement: "span",

        errorPlacement: function(error, element) {

                error.appendTo(element.parent());

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
<script>
function myFunction() {
  var checkBox = document.getElementById("allotstatus");
  //var text = document.getElementById("text");
  if (checkBox.checked == true)
  {
	  var checkstat=1;
	  $.post("<?php echo $site_url?>/Manual_dredging/Report/get_spotdet/",{checkstat:checkstat},function(data)

						{
		//  alert("on");

							$('#spotdata').html(data);
							$("#allotstatus").attr("checked","checked");

						});
   // 
  } 
			 else 
			 {
			 
			 var checkstat=2;
			 $.post("<?php echo $site_url?>/Manual_dredging/Report/get_spotdet/",{checkstat:checkstat},function(data)
//
						{
//alert("o");
							$('#spotdata').html(data);

						});
    //alert("off");
  }
}
</script>
<script type="text/javascript">

$(document).ready(function()

{

	//$('#allotstatus').change(function()

	//			{

	//				var zone=$('#allotstatus').val();
	//	alert(zone);

					//var fromd=$('#date_int').val();

   					//	$.post("<?php echo $site_url?>/Report/get_alt_cus/",{zone:zone,fromd:fromd},function(data)
//
					//	{

					//		$('#show').html(data);

					//	});

	//			});	

	$('#date_int').change(function()

				{

					var zone=$('#zone_int').val();

					var fromd=$('#date_int').val();

   						$.post("<?php echo $site_url?>/Manual_dredging/Report/get_alt_cus/",{zone:zone,fromd:fromd},function(data)

						{

							$('#show').html(data);

						});

				});	

	

	$('#txt_zone').change(function()

				{

					var zone=$('#txt_zone').val();

					var fromd=$('#txt_date').val();

   						$.post("<?php echo $site_url?>/Manual_dredging/Report/get_balance_ton/",{zone:zone,fromd:fromd},function(data)

						{

							//alert(data);

							$('#baltonid').html(data);

						});

				});
	$('#txt_date').change(function()

				{

					var zone=$('#txt_zone').val();

					var fromd=$('#txt_date').val();

   						$.post("<?php echo $site_url?>/Manual_dredging/Report/get_balance_ton/",{zone:zone,fromd:fromd},function(data)

						{

							//alert(data);

							$('#baltonid').html(data);

						});

				});
//----------------------------------------------------------------chech_spot_token_aloted
	
	$('#txt_token').change(function()

				{

					var tokenno=$('#txt_token').val();

					//alert(tokenno);

   						$.post("<?php echo $site_url?>/Manual_dredging/Report/chech_spot_token_aloted/",{tokenno:tokenno},function(data)

						{
							//alert(data);//exit();
							if(data==0)
							{
								alert("Already alotted for this token number....");
								$('#txt_token').val('');
								$('#txt_token').focus();
							}
							else
							{
								var res=data.split("&");
								//alert(res[0]);
								$('#txt_zone').val(res[0]).attr("selected", "selected");
								//$('#txt_zone').val(res[1]);
								document.getElementById("txt_zone1").value=res[1];
								//$('#txt_zone').val()=data;
								
							}
							//alert(data);

							//$('#baltonid').html(data);

						});

				});
	//--------------------------------------------------
});

</script>

<div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 Assign Spot Kadavu</button>
		</div>
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
    <div class="col-12 d-flex justify-content-end">
     
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Report/spot"); ?>"> Spot</a></li>	 
        <li class="breadcrumb-item"><a href="#"><strong>Assign Spot Kadavu </strong></a></li>
      </ol>
    </div>
    <!-- Main content -->
    
        <div class="col-md-12">
          <!-- /.box -->
        
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      </div> <!-- end of co12 -->
		</div> <!-- end of row -->  


<div class="row p-3">
          <div class="col-md-12 d-flex justify-content-left px-2">



            &nbsp;Click Here -> Spot Booking Home<a href="<?php echo site_url(); ?>/Manual_dredging/Report/spot" title="Go to SpotBooking Home"> <span class="glyphicon glyphicon-home" aria-hidden="false"></span></a>

            <p>&nbsp;</p>
          </div>
</div>

               <?php

			   echo form_open('Manual_dredging/Report/spot_reg_details');

			   ?>
                
<div class="row p-3">
          <div class="col-md-12 d-flex justify-content-left px-2">                

			   
               <label class="switch">
  <input type="checkbox" id="allotstatus" name="allotstatus"  onClick="myFunction();">
  <div class="slider round"><span class="on"></span><span class="off"></span></div>
</label>
                           </div>
          </div>
   <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
              Enter Token No
         </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
              <input type="text" id="txt_token" name="txt_token" required="required" />
          </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
                       Select Date
          </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
               <input type="date" name="txt_date" id="txt_date" required="required" />
           </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
                       Select Kadavu
           </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
               <select name="txt_zone" id="txt_zone"><option value="">select kadavu</option><?php foreach($zone as $z){?> 
               <option value="<?php echo $z['zone_id']; ?>" <?php //print_r($zoneid);//if($zoneid==$z['zone_id']) {echo "selected";} ?> ><?php echo $z['zone_name'];?></option><?php } ?></select><input type="hidden" id="txt_zone1" name="txt_zone1" />
           </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2" id="baltonid">

           
                </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-12 d-flex justify-content-center px-2">

             <input type="submit" name="alt" value="Approve" class="btn btn-primary"/></div>
		</div> <!-- end of row -->
          
			   <?php

			   echo form_close();

			   ?>
               
              <hr />
              

    
      <div class="row">
		<div class="col-12" id="spotdata">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
              <table id="example" class="table table-bordered table-striped">
            

                <thead>

                <tr>

                  <th id="sl">Sl.No</th>

                  <th>Customer Name</th>
                  <th>Mobile No</th>
				   <th>Preferred Zone</th>
				   <th>Booked Date(Type)</th>
                  <th>Requested Ton</th>
	              <th>Allotted Date</th>
                  <th>Token</th>
                  <th>Lorry Type</th>
                  <th>Status</th>

                </tr>

                </thead>

                <tbody>

                <?php

				//print_r($data);

				$allegation=array();

				 $i=1; 

				 foreach($spot as $rowmodule){

					 $sat=0;

					 $id = $rowmodule['spotreg_id'];
					 $lorrytype=$rowmodule['lorry_type'];

					 if($lorrytype==1)
					 	{
					 		$lorryname='Kadavu lorry';
					 	}
					 	else if($lorrytype==2)
					 	{
					 		$lorryname='KSMDCL lorry';
					 	}
					 	else
					 	{
					 		$lorryname='';
					 	}
					?>

					<tr id="<?php echo $i;?>">

						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>

                       	<td><?php  echo $rowmodule['spot_cusname']; ?></td>

                        <td><?php  echo $rowmodule['spot_phone']; ?></td>

						 <td><?php foreach($zone as $zonename){if($zonename['zone_id']==$rowmodule['preferred_zone']){ echo $zonename['zone_name'];} }?></td>

						  <td><?php  echo  $rowmodule['spot_timestamp'];//date("d/m/Y", strtotime(str_replace('-', '/',$rowmodule['spot_timestamp'] )));?><br/> <?php //if($rowmodule['spot_booking_type']==1){echo  "(Spot)";}else if($rowmodule['spot_booking_type']==2){?> <font color="#2C0DF3" style="font-weight: bold;" ><?php //echo "(Door)";?></font><?php //} ?></td>
                        <td><?php  echo $rowmodule['spot_ton']; ?></td>
                        <td><?php  if($rowmodule['spot_alloted']==""){ echo "0000-00-00";}else {echo date("d/m/Y", strtotime(str_replace('-', '/',$rowmodule['spot_alloted'] ))); } ?></td>
						<td><?php  echo $rowmodule['spot_token']; ?></td>
                        <td><?php  echo $lorryname; ?></td>
                        <td> 
                        <?php 
							if ($rowmodule['payment_status']==1)
							 {
								if($rowmodule['print_status']==1)
								{
								?>
                                <button class="btn btn-sm btn-danger btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Sand Issued &nbsp;&nbsp; </button> 
                                <?php	

								}

								else

								{

								?>
                                
								<button class="btn btn-sm btn-success btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Paid &nbsp;&nbsp; </button> 		
							<?php

								}

							}
							else {
								?>
								 <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Pending  </button> 
								<?php
							} ?>
					</td>
					</tr>
					<?php
					$i++; 
				}
                echo form_close(); ?>

                </tbody>

               

              </table>
    </div>
    </div>
    </div>
</div>

           