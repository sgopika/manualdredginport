
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

<script type="text/javascript">

$(document).ready(function()

{

	$('#btn_rep').click(function()

				{

					var zone=$('#int_zone').val();

					var fromd=$('#vch_material_sd').val();

					//alert(fromd);

					//var tod=$('#vch_material_ed').val();

					//var dateArf = fromd.split('/');

                    //var newDatef = dateArf[2] + '/' + dateArf[1] + '/' + dateArf[0].slice(-2);

				//	var dateArt = tod.split('/');

                  //  var newDatet = dateArt[2] + '/' + dateArt[1] + '/' + dateArt[0].slice(-2);

					//alert(newDatet);

					/*if(newDatef > newDatet)

					{

   						alert("Invalid Date Range");

					}

					else

					{*/

   						$.post("<?php echo $site_url?>/Manual_dredging/Report/gen_salereport/",{zone:zone,fromd:fromd},function(data)

						{

							$('#show').html(data);

						});

					/*}*/

				});

				

});

</script>

 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Spot Registration</span>
	</div>  <!-- end of col4 -->
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
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Report/spot"); ?>"> Spot</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Spot Registration</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 



        <?php if($this->session->flashdata('msg'))

		{ 

		   	echo $this->session->flashdata('msg');

		}

		?>

      <!--      </div> -->
   <div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
              <table id="example" class="table table-bordered table-striped">

                  <thead>

                  <tr>

                  <th>Sl NO</th>

                  <th>Customer Name</th>

                  <th>Customer Phone</th>
                  <th>Token No</th>
                  <th>Alloted Date</th>

                  <th>Ton Needed</th>

				  <th>Date</th>

                  <th>Payment Status</th>

                  <th>Sand Issue Status</th>

                  <th>Download</th>

                  </tr>

                  </thead>

                  <tbody>

                  <?php

				  $i=1;
				  if(($buk_data) != null){
				  foreach($buk_data as $row)

				  {

					  ?>

                      <tr>

                      	<td><?php echo $i;  ?></td>

                      	<td><?php echo $row['spot_cusname']; ?></td>

                        <td><?php echo $row['spot_phone']; ?></td>
                        <td><?php echo $row['spot_token']; ?></td>
                        <td><?php if($row['spot_alloted']!=''){echo date("d-m-Y", strtotime(str_replace('-', '/',$row['spot_alloted'] )));}else{} ?></td>

                        <td><?php echo $row['spot_ton']; ?></td>

						 <td><?php echo $row['spot_timestamp']; ?></td>

						

                        <td><?php if($row['transaction_status']==1){ echo "Paid";}else { echo "pending"; } ?></td>

                        <td><?php if($row['pass_isue_user']!=0){ echo "Sand Issued";}else { echo "pending"; } ?></td>

           <!--             <td><a href="<?php echo site_url(); ?>/Report/getchallan/<?php echo encode_url($row['spotreg_id']);?>" target="_new">Download Challan</a></td>
-->
                      </tr>

                      <?php

					  $i++;

				  }
				}

				  ?>

                    </tbody>

       	   		  </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
     