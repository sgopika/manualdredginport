
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
	$('#date_int').change(function()
				{
					var zone=$('#zone_int').val();
					var fromd=$('#date_int').val();
   						$.post("<?php echo $site_url?>/Manual_dredging/Report/get_alt_cus/",{zone:zone,fromd:fromd},function(data)
						{
							$('#show').html(data);
						});
				});				
});
</script>
<!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Interval Settings</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
         <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Report/spot"); ?>"> Spot</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Interval Settings</strong></a></li>
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
	 <div class="col-md-12">
                &nbsp;Click Here -> Spot Booking Home<a href="<?php echo site_url(); ?>/Manual_dredging/Report/spot" title="Go to SpotBooking Home"> <span class="glyphicon glyphicon-home" aria-hidden="false"></span></a>
            <p>&nbsp;</p>
              <hr />
              <?php
			  $flag=0;
			  foreach($buk_int as $rowmodule)
			  {
				  if($rowmodule['buk_stat']==1)
				  {
					  $flag=1;
				  }
			  }
			  echo form_open('Manual_dredging/Report/settings_interval') ;
			  ?>
         </div>
              
              
             <table class="table table-bordered table-striped" <?php if($flag==1){?> style="display:none"  <?php } ?>>
             <tr><td>Booking Interval</td><td><input type="text" name="txt_intrvl" id="txt_intrvl" class="form-control" /></td>
             </tr>
             <tr><td colspan="2"><input type="submit" value="Set Interval" /></td></tr>  
             </table>
             <?php echo form_close(); ?>
                  
            
            <p>&nbsp;</p>
            <table id="vacbtable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th>Booking Interval</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				$allegation=array();
				 $i=1; 
				 foreach($buk_int as $rowmodule){
					 $sat=0;
					 $id = $rowmodule['buk_int_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
                       	<td><?php  echo $rowmodule['buk_time']; ?></td>
                        <td><?php  echo $rowmodule['buk_start_date']; ?></td>
                        <td><?php  echo $rowmodule['buk_end_date']; ?></td>
                        <?php 
							if ($rowmodule['buk_stat']==1) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else {
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
								<?php
							} ?>
                            <td><?php if ($rowmodule['buk_stat']==1) {?><a href="<?php echo site_url("Manual_dredging/Report/c_interval"); ?>/<?php echo $id;?>" >Cancel</a><?php }else {?>Cancelled<?php } ?></td>
					</tr>
					<?php
					$i++; 
				}
                echo form_close(); ?>
                </tbody>
               
              </table>
            </div>

        
            <!-- /.box-header -->
           
            <!-- form start -->
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
 <script>
  $(function () {
    //Initialize Select2 Elements
   // $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#vch_material_sd").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#vch_material_ed").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();


  });
  $(function(){
	  $("#vch_material_sd").datepicker();
	  $("#vch_material_ed").datepicker();
	  });
</script>
