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
  		$("#userposting").validate({
		rules: {
				int_material: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				vch_material_amt: {
					required: true,
					number: true,
					maxlength: 20,
				},
				vch_material_sd: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				int_material_status: {
					required: true,
					maxlength: 20,
				},
		},
		messages: {
				int_material: {
					required: "<font color='#FF0000'> Select Material required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_material_amt: {
					required: "<font color='#FF0000'> Material Amount Required!!</font>",
					number:"<font color='#FF0000'> numbers only!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_material_sd: {
					required: "<font color='#FF0000'> Start Date required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				int_material_status: {
					required: "<font color='#FF0000'>Status Required!!</font>",
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
	$('#int_material').change(function()
				{
					var mat_id=$('#int_material').val();
					$.post("<?php echo $site_url?>/Master/getzoneAjax/",{mat_id:mat_id},function(data)
						{
							//alert("ffff");
							$('#shows').html(data);
						});
				});			
	$('#vch_material_amt_zone').click(function(){
		$('#show').toggle();
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
		 <li><a href="<?php echo site_url("Port/mech_rate"); ?>"> Material Rate</a></li>
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
			  //echo $matid;
			
			   if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Material Rate</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "userposting", "name" => "userposting");
			} else {
				$matids=explode(',',$matid);
       $attributes = array("class" => "form-horizontal", "id" => "userposting", "name" => "userposting", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Port/edit_mechmaterialrate", $attributes);
		} else {
		echo form_open("Port/add_mech_matrate", $attributes);
			
		}
		$emat=$material_ex;
		$ex_mat=explode(',',$emat);
		//print_r($ex_mat);
		?>
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo encode_url($int_userpost_sl);} ?>" />
		
              <table id="vacbtable" class="table table-bordered table-striped">

      
        <tr >
  
      		<td>Material<font color="#FF0000">*</font></td>
      		<td>
            <select  name="int_material"  id="int_material"  class="form-control"  maxlength="100" <?php if(isset($int_userpost_sl))
			{ ?> disabled="disabled"<?php } ?>>
            <?php 
			if(isset($int_userpost_sl))
			{
			foreach($material as $mat)
			{
			?>
            <option value="<?php echo $mat['material_master_id']; ?>" <?php if($mat['material_master_id']==$material_det[0]['material_id']){ ?> selected="selected" <?php } ?>><?php echo $mat['material_master_name']; ?></option>
            <?php
			}	
			}
			else
			{
			?>
            <option selected="selected" value="">--select--</option>
            <?php
			foreach($material as $mat)
			{
				if(!in_array($mat['material_master_id'],$ex_mat))
				{
			?>
            <option value="<?php echo $mat['material_master_id']; ?>"><?php echo $mat['material_master_name']; ?></option>
            <?php
				}
			}
			}
			?>
            </select> 
            
            </td>
      	</tr>
        <tr >
  
      		<td>Amount<font color="#FF0000">*</font></td>
      		<td>
           <input type="text" name="vch_material_amt"  <?php if(isset($int_userpost_sl)){ ?> value="<?php echo $material_det[0]['mat_amount'];?>" <?php } ?>id="vch_designation_name"  class="form-control"  maxlength="100" autocomplete="off" /> 
            </td>
      	</tr><!--
        <tr >
  
      		<td>Tick if rates are different for different zones<font color="#FF0000">*</font></td>
      		<td>
           <input type="checkbox" name="vch_material_amt_dzone" value="true" id="vch_material_amt_zone" <?php if(isset($int_userpost_sl))
			{ if($material_det[0]['materialrate_domain']==3){ ?> checked="checked" <?php } }?>   /> 
            </td>
      	</tr>
        <tr id='show' <?php 
		if(isset($int_userpost_sl))
			{ 
				if($material_det[0]['materialrate_domain']==3)
				{ 
				}
				else 
				{?>
                style="display:none"  
				<?php 
				} 
			}else {?> style="display:none" <?php  }?> >
  
      		<td>Select Zones<font color="#FF0000">*</font></td>
      		<td>
            <?php 
		if(isset($int_userpost_sl))
			{ 
			$sz=$material_det[0]['materialrate_zone'];
			$sza=explode(',',$sz);
			foreach($zone as $z)
			{
			?>
           <input type="checkbox" name="vch_material_amt_zone[]" value="<?php echo $z['zone_id'];?>" id="vch_designation_name" <?php if(in_array($z['zone_id'],$sza)){?> checked="checked" <?php } ?>   />&nbsp;<?php  echo $z['zone_name']." ,";
			}
			}
			else
			{
				?>
                <div id="shows">
                </div>
                <?php  
			}
		  ?>
             </td>
      	</tr>
        -->
         <tr >
  
      		<td>Start Date<font color="#FF0000">*</font></td>
      		<td>
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
           <input type="text" name="vch_material_sd" value="<?php if(isset($int_userpost_sl)){ echo date("d/m/Y", strtotime(str_replace('-', '/',$material_det[0]['start_date'])));}else { echo date('d/m/Y');} ?>" id="vch_material_sd"  class="form-control"  data-inputmask="'alias': 'dd/mm/yyyy'" onChange="check_dates();" data-mask  maxlength="100" autocomplete="off" /> 
            </div>
            <span id="startdatediv" ></span>
            </td>
      	</tr>
         <tr >
  <?php
				   if(isset($int_userpost_sl)){
				  if($material_det[0]['end_date']!='0000-00-00 00:00:00')
				  {
				  $end_date=date("d/m/Y", strtotime(str_replace('-', '/',$material_det[0]['end_date'] ))); 
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
           <input type="text" name="vch_material_ed"<?php if(!isset($int_userpost_sl)){ ?> disabled="disabled" <?php }?> value="<?php if(isset($int_userpost_sl)){ echo $end_date; }?>" id="vch_material_ed"  class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" onChange="check_dates();" data-mask  maxlength="100" autocomplete="off" />
           </div>
            <span id="startdatediv" ></span> 
            </td>
      	</tr>
       	<tr >
  
      		<td>Status<font color="#FF0000">*</font></td>
      		<td>
            <select  name="int_material_status"  id="int_material_status"  class="form-control"  maxlength="100">
            <?php if(isset($int_userpost_sl)){
				  foreach($status as $s)
			    {
				?>
            <option value="<?php echo $s['status_id'];?>" <?php if($s['status_id']==$material_det[0]['mdrate_status']) { ?> selected="selected" <?php } ?> ><?php echo $s['status_name'];?></option>
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
    $(function(){
	  $("#vch_material_sd").datepicker();
	  $("#vch_material_ed").datepicker();
	  });
</script>