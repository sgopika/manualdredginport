
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
					var tod=$('#vch_material_ed').val();
					//alert(tod);
   						$.post("<?php echo $site_url?>/Report/gen_salereport/",{zone:zone,fromd:fromd,tod:tod},function(data)
						{
							$('#show').html(data);
						});
				});
				
});
</script>
   <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Sale Report</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<?php if($sess_user_type==3) { ?> 
    		<ol class="breadcrumb">
             
		<li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
       
         <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Report/lorry"); ?>"> Lorry</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Vehicle Details</strong></a></li>
    </ol>
    <?php
}
else
	{
		?> <ol class="breadcrumb">
             
		<li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_zone_main"); ?>"> Home</a></li>
       
         
        <li class="breadcrumb-item"><a href="#"><strong>Vehicle Details</strong></a></li>
    </ol>
    <?php
}
?>

</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
 <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 

        <?php if($this->session->flashdata('msg'))
		{ 
		   	echo $this->session->flashdata('msg');
		}
		?>

		  
            
        <div class="box box-primary box-blue-bottom">
            <div class="box-header ">
              <h3 class="box-title"></h3>
                  <table  class="table table-bordered table-striped">
                  	<tr>
                    	<td>Select Zone</td>
                        <td>
                        	<select class="form-control" name="int_zone" id="int_zone">
                            	<option selected="selected">select</option>
                                <?php
									foreach($zone as $z)
									{
										?>
                                        <option value="<?php echo $z['zone_id']; ?>"><?php echo $z['zone_name']; ?></option>
                                        <?php
									}
								?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    <td>From Date</td>
                    <td> <input type="text" name="vch_material_sd"  id="vch_material_sd"  class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'"  data-mask  maxlength="100" autocomplete="off" />
                       </div>
                        <span id="startdatediv" ></span> </td>
                    </tr>
                     <tr>
                    <td>To Date</td>
                    <td> <input type="text" name="vch_material_ed"  id="vch_material_ed"  class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'"  data-mask  maxlength="100" autocomplete="off" />
                       </div>
                        <span id="enddatediv" ></span> </td>
                    </tr>
       	    </table>
            </div>
            <div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
		
		<input id="btn_rep" name="btn_add" type="button" class="btn btn-primary" value="View"/>
        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
       
        </div>
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
    
		
        
      <p id="show" align="center"></p>
      
               
                
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
<script>
  $(function () {
    $('#vacbtable_d').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "sScrollX": "960px",
	  "columnDefs": [
	  {
		  "targets": [-1, 0],
		  "searchable": false
	  },{
      "targets": [0],
      "width": "50px"
    },
	{
"targets": [-3],
"width": "120px"
    },{
"targets": [-1, -2, -3, 0],
"sortable": false
    }
	  ]
    });
  });
</script>﻿
