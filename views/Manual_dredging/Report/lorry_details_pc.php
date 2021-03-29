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
<script>
function getconfirm()
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
 <!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">LSGD Details</span>
	</div>  <!-- end of col4 -->
	<?php 
	$sess_user_type			=	$this->session->userdata('int_usertype');
	 //echo "fff".$sess_user_type;
	if($sess_user_type==3)
	{ 
		$url=site_url("Manual_dredging/Master/pcdredginghome");
	 }
	 else if($sess_user_type==4)
	{ 
		$url=site_url("Manual_dredging/Port/port_lsgd_main");
	 }
	  else
	   {
	    $url=site_url('Manual_dredging/Port/port_clerk_main');
	}
	?>
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
       
         <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Report/lorry"); ?>"> Lorry</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Vehicle Details</strong></a></li>
      </ol>
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
                  <th id="sl">Sl.No</th>
                  <th>Lorry RegNo</th>
                  <th>Owner Name</th>
                  <th>Mobile No</th>
                  <th>Lorry Capacity</th>
                  <th>Zone</th>
                  <th>No Of Trips</th>
                  <th>Status</th>
                  <th>Block / Activate</th>
                  <th>Cancel Registration</th>
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				$allegation=array();
				 $i=1; 
				 foreach($lorry as $rowmodule){
					 $sat=0;
					 $id = $rowmodule['lorry_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
                       	<td><?php  echo $rowmodule['lorry_reg_no']; ?></td>
                        <td><?php  echo $rowmodule['owner_name']; ?></td>
                        <td><?php  echo $rowmodule['contact_no']; ?></td>
                        <td><?php  echo $rowmodule['lorry_cap']; ?></td>
                         <td><?php  echo $rowmodule['zone_name']; ?></td>
                        <td><?php  echo $rowmodule['last_trip']; ?></td>
                        <?php 
							if ($rowmodule['status']==1) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else if($rowmodule['status']==2) {
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
								<?php
							} else
							{?>
                            <td> <button class="btn btn-sm btn-warning btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Cancelled  </button> </td>
                            <?php
                            }
							?>
                            <td><?php if ($rowmodule['status']==1) {?><a href="<?php echo site_url("Manual_dredging/Report/b_lorry"); ?>/<?php echo $id;?>" >Block</a><?php }else {?><a href="<?php echo site_url("Manual_dredging/Report/a_lorry"); ?>/<?php echo $id;?>">Activate</a><?php } ?></td>
                            <td>
                            <a onclick="return getconfirm()" href="<?php echo site_url("Manual_dredging/Report/c_lorry"); ?>/<?php echo $id;?>" >Cancel</a>
                            </td>
					</tr>
					<?php
					$i++; 
				}
                echo form_close(); ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
     