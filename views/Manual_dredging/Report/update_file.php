
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
    <section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 Update File </button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard"); ?>"> Master</a></li>
        <li><a href="#"><strong>Update File </strong></a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
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
            <div class="box-header ">
              <h3 class="box-title">Update Your File</h3>
              
              <p>&nbsp;</p>
              
             <?php 
        $attributes = array("class" => "form-horizontal", "id" => "addzone", "name" => "addzone");
		echo form_open_multipart("Report/update_myfile", $attributes);	
		?>
		<input type="hidden" name="hid" value="<?php echo $sec_reg[0]['cus_reg_id']; ?>" />
        <table class="table table-striped table-bordered table-hover">
        
        <tr><td>Permit/Tax Recipt Number</td><td><?php echo $sec_reg[0]['customer_permit_number']; ?></td></tr>
        <tr><td>Upload Permit/Tax Recipt</td><td><input type="file" name="txt_permit" id="txt_permit"/>
         <p id="error1" style="display:none; color:#FF0000;">
Invalid Image Format! Image Format Must Be PDF.
</p>
<p id="error2" style="display:none; color:#FF0000;">
Maximum File Size Limit is 1MB.
</p>
        </td></tr>
        </table>
    
		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
		
		<input id="btn_rep" name="btn_add" type="submit" class="btn btn-primary" value="Update"/>
        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
       
        </div>
        </div>
        <?php
		echo form_close();
		?>
                  
            </div>
                   
            <!-- /.box-header -->
           
            <!-- form start -->
        
        
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
//$('input[type="submit"]').prop("disabled", true);
$(document).ready(function() {
    
	var a=0;
//binds to onchange event of your input field
$('#txt_permit').bind('change', function() {
if ($('input:submit').attr('disabled',false)){
	$('input:submit').attr('disabled',true);
	}
var ext = $('#txt_permit').val().split('.').pop().toLowerCase();
if ($.inArray(ext, ['pdf']) == -1){
	$('#error1').slideDown("slow");
	$('#error2').slideUp("slow");
	a=0;
	}else{
	var picsize = (this.files[0].size);
	if (picsize > 1000000){
	$('#error2').slideDown("slow");
	a=0;
	}else{
	a=1;
	$('#error2').slideUp("slow");
	}
	$('#error1').slideUp("slow");
	if (a==1){
		$('input:submit').attr('disabled',false);
		}
}
});
});

</script>
