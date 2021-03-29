<?php
//print_r($_REQUEST);
?>

  <link href="<?php echo base_url('assets/datepicker-bootsrap/css/datepicker.css'); ?>" rel="stylesheet" media="screen">
   <script src="<?php echo base_url('assets/datepicker-bootsrap/js/bootstrap-datepicker.js');?>"></script>
   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>
      <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>
  
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
  		$("#addwqty").validate({
		rules: {
				vch_worker_qty: {
					required: true,
				//no_special_check: true,
				number:true,
				minlength: 1,
				maxlength: 2,
				},
				vch_worker_sd: {
					required: true,
					//maxlength: 20,
				},
				int_worker_status: {
					required: true,
					maxlength: 20,
				},
		},
		messages: {
				vch_worker_qty: {
					required: "<font color='#FF0000'> Worker Quantity required!!</font>",
					number: "<font color='#FF0000'> Numbers Only!!</font>",
					minlength: "<font color='#FF0000'> Minimum 1 characters allowed!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 2 characters allowed!!</font>",
				},
				vch_material_sd: {
					required: "<font color='#FF0000'> start date Required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
					
				},
				int_worker_status: {
					required: "<font color='#FF0000'> Status Required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
		},
    	errorElement: "span",
        errorPlacement: function(error, element) {
                error.appendTo(element.parent());
        }

 		});
	
	});
</script>	
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
    <section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Material Rate</button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>"> Master</a></li>
		 <li><a href="<?php echo site_url("Master/material_rate"); ?>"> Material Rate</a></li>
        <li><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Material Rate </strong></a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
        <div class="col-md-9">
          <!-- /.box -->
        <div class="box" >
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      <!--      </div> -->
		  
            
        <div class="box box-primary box-blue-bottom">
            <div class="box-header ">
              <h3 class="box-title"><?php
			
			   if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Worker Quantity </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "addwqty", "name" => "addwqty", "onSubmit" => "return validate_chk();");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "addwqty", "name" => "addwqty", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Master/workerqty_master_edit", $attributes);
		} else {
		echo form_open("Master/workerqty_add", $attributes);
			
		}?>
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo encode_url($int_userpost_sl);} ?>" />
		
              <table id="vacbtable" class="table table-bordered table-striped">
        <tr >
  
      		<td>Worker Quantity<font color="#FF0000">*</font></td>
      		<td>
           <input type="text" name="vch_worker_qty" value="<?php if(isset($int_userpost_sl)){ echo $wqty[0]['worker_quantity']; }?>" id="vch_worker_qty"  class="form-control"  maxlength="100" autocomplete="off" /> 
            </td>
      	</tr>
         <tr >
  
      		<td>Start Date<font color="#FF0000">*</font></td>
      		<td>
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
           <input type="text" name="vch_worker_sd" value="<?php if(isset($int_userpost_sl)){ echo date("d/m/Y", strtotime(str_replace('-', '/',$wqty[0]['worker_quantity_start_date'] )));}else { echo date('d/m/Y');} ?>" id="vch_worker_sd"  class="form-control"  data-inputmask="'alias': 'dd/mm/yyyy'" onChange="check_dates();" data-mask  maxlength="100" autocomplete="off" /> 
            </div>
            <span id="startdatediv" ></span>
            </td>
      	</tr>
         <tr >
   <?php
				  if(isset($int_userpost_sl))
				  {
				  if($wqty[0]['worker_quantity_end_date']!='0000-00-00')
				  {
				  $end_date=date("d/m/Y", strtotime(str_replace('-', '/',$wqty[0]['worker_quantity_end_date'] ))); 
				  }
				  else
				  {
					   $end_date='';
				  }
				  }
				  ?>
      		<td>End Date<font color="#FF0000">*</font></td>
      		<td>
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
           <input type="text" name="vch_worker_ed" value="<?php if(isset($int_userpost_sl)){ echo $end_date;} ?>" id="vch_worker_ed"  class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" onChange="check_dates();" data-mask  maxlength="100" autocomplete="off" />
           </div>
            <span id="startdatediv" ></span> 
            </td>
      	</tr>
       	<tr >
  
      		<td>Status<font color="#FF0000">*</font></td>
      		<td>
            <select  name="int_worker_status"  id="int_worker_status"  class="form-control"  maxlength="100">
            <?php if(isset($int_userpost_sl)){
				  foreach($status as $s)
			    {
				?>
            <option value="<?php echo $s['status_id'];?>" <?php if($s['status_id']==$wqty[0]['worker_quantity_status']) { ?> selected="selected" <?php } ?> ><?php echo $s['status_name'];?></option>
            <?php
			}
			}
			else
			{
			?>
            <option value="" selected="selected">--select--</option>
            <?php foreach($status as $s)
			{
				?>
            <option value="<?php echo $s['status_id'];?>" <?php if($s['status_id']==1) {?> selected="selected" <?php } ?>><?php echo $s['status_name'];?></option>
            <?php
			}
			}
			?>
            </select> 
            
            </td>
      	</tr>
	  </table>
  		 
 		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_designation_sl)){?>
		 <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
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
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();


  });
</script>
<script>
$(function(){
	$("#vch_worker_sd").datepicker();
	$("#vch_worker_ed").datepicker();
	});
</script>