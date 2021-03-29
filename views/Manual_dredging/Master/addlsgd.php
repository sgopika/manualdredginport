<?php
//print_r($_REQUEST);
?>

  
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
  		$("#addlsgd").validate({
		rules: {
				int_lsgd_port: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				int_lsgd_dist: {
					required: true,
					maxlength: 20,
				},
				int_lsgd_name: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				int_lsgd_name_mal: {
					required: true,
					maxlength: 20,
				},
				vch_lsgd_adrs: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				vch_lsgd_phone: {
					required: true,
					number:true,
					minlength: 10,
					maxlength: 10,
				},
		},
		messages: {
				int_lsgd_port: {
					required: "<font color='#FF0000'> Port required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				int_lsgd_dist: {
					required: "<font color='#FF0000'> Lsgd Required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				int_lsgd_name: {
					required: "<font color='#FF0000'> Lsgd Name required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				int_lsgd_name_mal: {
					required: "<font color='#FF0000'> Lasgd Unicode Required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_lsgd_adrs: {
					required: "<font color='#FF0000'> Address required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_lsgd_phone: {
					required: "<font color='#FF0000'> Phone Number Required!!</font>",
					number:"<font color='#FF0000'> Numbers Only!!</font>",
					minlength:  "<font color='#FF0000'> 10 characters needed!!</font>",
					maxlength:"<font color='#FF0000'> Only 10 characters Allowed!!</font>",
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
$(document).ready(function()
{
	$('#int_lsgd_port').change(function()
				{
					//var csrf = $('input[name="csrf_vacb_token"]').val();
					var port_id=$('#int_lsgd_port').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getDistAjax/",{dist_id:port_id},function(data)
						{
							$('#int_lsgd_dist').html(data);
						});
				});
	$('#int_lsgd_dist').change(function()
				{
					var csrf = $('input[name="csrf_vacb_token"]').val();
					var dist_id=$('#int_lsgd_dist').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getPanchayathAjax/",{dist_id:dist_id,csrf_token:csrf},function(data)
						{
							$('#int_lsgd_name').html(data);
						});
				});
	$('#int_lsgd_name').change(function()
				{
		//alert("sdsdsd");
					var csrf = $('input[name="csrf_vacb_token"]').val();
					var panch_id=$('#int_lsgd_name').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getPanchayathmalAjax/",{panch_id:panch_id,csrf_token:csrf},function(data)
						{
					//	alert(data);
							$('#show_mal').html(data);
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
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> LSGD</button>
		</div>

    <div class="col-12 d-flex justify-content-end">
     
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
        
		 <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/lsgd"); ?>"> Lsgd</a></li>
        <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> LSGD </strong></a></li>
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
		       
        <?php
			
		if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "addlsgd", "name" => "userposting", "onSubmit" => "return validate_chk();");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "addlsgd", "name" => "userposting", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl))
		{
       		echo form_open("Manual_dredging/Master/lsgd_edit", $attributes);
		} else {
		echo form_open("Manual_dredging/Master/lsgd_add", $attributes);
			
		}?>




		 <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
			<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo encode_url($int_userpost_sl);} ?>" />
		
             Port<font color="#FF0000">*</font>
         	</div>
           <div class="col-md-4 d-flex justify-content-start px-2">

            <select  name="int_lsgd_port"  id="int_lsgd_port"  class="form-control"  maxlength="100" readonly <?php if(isset($int_userpost_sl)){?> disabled="disabled"<?php } ?>>
            <?php
			foreach($port as $prt)
			{
			?>
			<option value="<?php echo $prt['int_portoffice_id'];?>"> <?php echo $prt['vchr_portoffice_name'];  ?></option>
            <?php
			}
			?>
            <?php 
			if(isset($int_userpost_sl)){
				foreach($port as $prt)
			{
			?>
			<option value="<?php echo $prt['int_portoffice_id'];?>" <?php if($prt['int_portoffice_id']==$lsgd[0]['lsgd_port_id']){?> selected="selected" <?php } ?> > <?php echo $prt['vchr_portoffice_name'];  ?></option>
            <?php
			}
			}
			?>
            </select> 
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
            	District<font color="#FF0000">*</font>
        	</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_lsgd_dist" id="int_lsgd_dist"   class="form-control" maxlength="100"  readonly="true" <?php if(isset($int_userpost_sl)){?> disabled="disabled"<?php } ?>>
            <option value="<?php echo $di[0]['district_id'];?>"selected="selected"> <?php echo $di[0]['district_name'];  ?></option>
            <?php 
			if(isset($int_userpost_sl)){
				foreach($dist as $di)
			{
			?>
			<option value="<?php echo $di['district_id'];?>" <?php if($di['district_id']==$lsgd[0]['lsgd_district_id']){?> selected="selected" <?php } ?> > <?php echo "gfgfgf" .$di['district_name'];  ?></option>
            <?php
			}
			}
			?>            
            </select> 
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           	LSGD Name<font color="#FF0000">*</font>
           </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_lsgd_name"  id="int_lsgd_name"  class="form-control"  maxlength="100" <?php if(isset($int_userpost_sl)){ ?> disabled="disabled" <?php } ?>>
            <option selected="selected" value="">--select--</option>
            <?php
			foreach($lsg as $lli)
			{
			?>
			<option value="<?php echo $lli['panchayath_sl'];?>"> <?php echo $lli['panchayath_name'];  ?></option>
            <?php
			}
			?>
            <?php 
			if(isset($int_userpost_sl)){
				foreach($lsg as $li)
			{
			?>
			<option value="<?php echo $li['panchayath_name'];?>" <?php if($li['panchayath_name']==$lsgd[0]['lsgd_name']){?> selected="selected" <?php } ?> > <?php echo $li['panchayath_name'];  ?></option>
            <?php
			}
			}
			?>        
            </select> 
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           	Name in Malayalam<font color="#FF0000">*</font>
           	</div>
           <div class="col-md-4 d-flex justify-content-start px-2" id="show_mal">
        	
           <?php if(isset($int_userpost_sl)){?> <input type="text" name="int_lsgd_name_mal" value="<?php  echo $lsgd[0]['lsgd_name_unicode'];?>" id="int_lsgd_name_mal"  class="form-control"  maxlength="100" autocomplete="off" <?php if(isset($int_userpost_sl)){ ?> disabled="disabled" <?php } ?> /> <?php } ?>      
               </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           	Address<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <textarea name="vch_lsgd_adrs" id="vch_lsgd_adrs" class="form-control"><?php if(isset($int_userpost_sl)){ echo $lsgd[0]['lsgd_address'];} ?></textarea>
           </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           	Phone No<font color="#FF0000">*</font> </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <input type="text" name="vch_lsgd_phone" id="vch_lsgd_phone"  class="form-control" value="<?php if(isset($int_userpost_sl)){
				 echo $lsgd[0]['lsgd_phone_number'];} ?>"  maxlength="10" autocomplete="off" />           </div>
		</div> <!-- end of row -->
  		 
 		<div class="row px-5 py-5" >
 		
        <div class="col-12 d-flex justify-content-center">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_designation_sl)){?>
		 <input id="btn_add" name="btn_add" type="submit" class="px-4 btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class=" px-4 btn btn-primary" value="Save"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class=" mx-4 btn btn-danger" value="Cancel" />
    
         </div> <!-- end of col 12 -->
         
	</div> <!-- end of row -->
	
		<?php echo form_close(); ?>
</div> <!-- end of container -->
  

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