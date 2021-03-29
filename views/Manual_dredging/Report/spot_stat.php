

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


        <div class="col-md-9">

          <!-- /.box -->

        <div class="box" >

        <?php if($this->session->flashdata('msg'))

		{ 

		   	echo $this->session->flashdata('msg');

		}

		?>

      <!--      </div> -->

		  

            

        <div class="box box-primary box-blue-bottom">
        	<a style="width: 120px;margin: 15px 0px 8px 0px;" align="left" href="<?php echo base_url(); ?>" class="btn btn-secondary" >Home</a>

            <div class="box-header "><button class="btn btn-primary btn-flat disabled" type="button" >Port-wise alloted Ton for Spot Booking</button>

              <h3 class="box-title"></h3>

              <?php 
				// print_r($zas); ?>

                  <table  class="table table-bordered table-striped">

                  	<tr>

                    <th>Sl No</th>

                    <th>Port ,Kadavu</th>

                    <th>Allowed Ton</th>

                    <th>Balance Ton</th>

                    </tr>

                    <?php 

					$i=1;
/*foreach( $spot_statnew as $index => $code )
{
	?>
	<td><?php echo $i; ?></td>

                    <td><?php echo $spot_stat[$index]['vchr_portoffice_name'].' , '.$spot_stat[$index]['zone_name']; ?></td>

                    <td><?php echo $spot_stat[$index]['spot_limit_quantity']; ?></td>
                    <td>
                    <?php
				if($spot_stat[$index]['spot_limit_zone_id']==$code['preferred_zone'])
					{  
						echo "ff".$code['tontotal'];
					}
					else 
					{
					 echo "gg".$spot_stat[$index]['spot_limit_balance'];?>
				<?php

					}?>
	</td>
					  </tr>
	<?php
  $i++;
}
		*/			  
					  
					foreach($spot_stat as $zs){ ?>

                    <tr>

                    <td><?php echo $i; ?></td>

                    <td><?php echo $zs['vchr_portoffice_name'].' , '.$zs['zone_name']; ?></td>

                    <td><?php echo $zs['spot_limit_quantity']; ?></td>

                    <td><?php echo $zs['spot_limit_balance'];?></td>

                    </tr>

                    <?php

					$i++;

					}

					?>

       	    </table>

            </div>

            

        

            <!-- /.box-header -->

           

            <!-- form start -->

            <?php 

			//print_r($get_userposting_details);

			// echo $get_userposting_details[0]['int_userpost_user_sl'];

			if(isset($int_userpost_sl)){

        $attributes = array("class" => "form-horizontal", "id" => "addzone", "name" => "addzone");

			} else {

       $attributes = array("class" => "form-horizontal", "id" => "addzone", "name" => "addzone", "onSubmit" => "return validate_chk();");

			}

        

		//print_r($editres); echo $editres[0]['intUserTypeID'];

		if(isset($int_userpost_sl)){

       		echo form_open("Master/pc_user_addN", $attributes);

		} else {

		echo form_open("Master/pc_user_addN", $attributes);

			

		}?>

		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />

    

		

        

      <div id="show"></div>

 		<div class="form-group">

        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">



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

  </section>
</body>
 

