<?php

//print_r($_REQUEST);

?>



  <link rel="stylesheet" href=<?php echo base_url("assets/plugins/datepicker/datepicker3.css"); ?>>

   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>

      <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>

	  <script type="text/javascript">

	 	$(document).ready(function()

			  {

				

			



		 jQuery.validator.addMethod("nospecial", function(value, element) {

        return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);

			});    	

			

				

				

	 $('#sand_issue').validate(

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
   	<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Sand Issue</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_zone_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Sand Issue</strong></a></li>
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

        

		//print_r($editres); echo $editres[0]['intUserTypeID'];

		if(isset($int_userpost_sl)){

       		echo form_open("Manual_dredging/Report/sand_issue_nw", $attributes);

		} else {

			echo form_open("Manual_dredging/Report/sand_issue_nw", $attributes);

		}?>

		<div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">

		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />

		

              <table class="table table-bordered table-striped">



      <tr>

	   <tr >

  

      		<td>Token No/ID<font color="#FF0000">*</font></td>

      		<td><input   type="text" name="txttokenno" id="txttokenno"  />

           </td>

      	</tr>

		 <tr >

      		<td>Aadhar Number<font color="#FF0000">*</font></td>

      		<td><input type="text" name="txtaadharno" id="txtaadharno" maxlength="12" />

           </td>

      	</tr>

	  <tr >

    	</tr>



	  </table>

  		 

 		<div class="form-group">

        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">

		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />

		

		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="View"/>

    </div>

        </div>

	    

		   <?php echo form_close(); ?>



           <table id="example" class="table table-bordered table-striped">

                <thead>

                <tr>

                  <th id="sl">Sl.No</th>

                  <th>Customer Name</th>

                  <th>Mobile No</th>

                  <th>Requested Ton</th>

                  <th>Allotted Date</th>

                  <th>Unloading Place</th>

                  <th>Token</th>

                  <th>Status</th>

                </tr>

                </thead>

                <tbody>

                <?php

				//print_r($data);

				$allegation=array();

				 $i=1; 

				 foreach($to_data as $rowmodule){

					 $sat=0;

					 $id = $rowmodule['spotreg_id'];

					?>

					<tr id="<?php echo $i;?>">

						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>

                       	<td><?php  echo $rowmodule['spot_cusname']; ?></td>

                        <td><?php  echo $rowmodule['spot_phone']; ?></td>

                        <td><?php  echo $rowmodule['spot_ton']; ?></td>

                        <td><?php echo strtoupper(date("d-m-Y",strtotime(str_replace('-', '/',$rowmodule['spot_alloted'])))); ?></td>

                        <td><?php  echo $rowmodule['spot_unloading']; ?></td>

                        <td><?php  echo $rowmodule['spot_token']; ?></td>

                        <?php 

							if ($rowmodule['payment_status']==1) {

								?>

								<td> <button class="btn btn-sm btn-success btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Paid &nbsp;&nbsp; </button> </td>

								<?php

							}

							else {

								?>

								<td> <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Pending  </button> </td>

								<?php

							} ?>

					</tr>

					<?php

					$i++; 

				}

                echo form_close(); ?>

                </tbody>

               

              </table>

<!--          </div>

            </div>

-->			 </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

       