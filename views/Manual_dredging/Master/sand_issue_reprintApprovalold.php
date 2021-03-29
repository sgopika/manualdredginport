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
    <section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?> <?php }?>
         <strong>Sand issue Pass Request </strong> </button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>"> Master</a></li>
		 <li><a href="<?php echo site_url("Master/customer_booking"); ?>"><strong>Sand Issue</strong></a></li>
        <li><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?> <?php }?></strong></a><a href="<?php echo site_url("Master/canoeRegistration"); ?>"><strong>&nbsp;Sand Issue Pass Request</strong></a></li>
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
			
			   if(isset($int_userpost_sl)){?>Edit<?php } else {?> <?php }?>
              <a href="<?php echo site_url("Master/sand_issue_add"); ?>"><strong>Sand Issue Pass Request</strong></a>
			  <!--<a href="<?php echo site_url("Master/generatepass/".encode_url(1)); ?>"><strong>asdasdas</strong></a></h3>-->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "sand_issue_add", "name" => "sand_issue_add");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "sand_issue_add", "name" => "sand_issue_add", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Master/sand_issue_reprintApproval", $attributes);
		} else {
			echo form_open("Master/sand_issue_reprintApproval", $attributes);
		}?>
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		<input type="hidden" name="bid" value="<?php echo $datareprintview[0]['customer_booking_id']; ?>" />
              <table id="vacbtable" class="table table-bordered table-striped">

      <tr>
	  <tr><td>Customer name</td><td><?php  foreach($datareprintview as $rowmodule){  ?><input type="text" name="txtcustrname"  id="txtcustrname"  class="form-control" value="<?php echo strtoupper($rowmodule['customer_name']);?>" readonly="true"   autocomplete="off" required/><input type="hidden" name="hid_passid" id="hid_passid" value="<?php echo $rowmodule['sandpass_reprint_id']  ?>" /> <?php } ?></td></tr>
	   <tr >
  
      		<td>Token No/ID<font color="#FF0000">*</font></td>
      		<td><input   type="text" name="txttokenno" id="txttokenno" disabled="disabled" readonly="true"  value="<?php echo $rowmodule['token_no']  ?>" />
           </td>
      	</tr>
		 <tr >
      		<td>Aadhar Number<font color="#FF0000">*</font></td>
      		<td><input type="text" name="txtaadharno" id="txtaadharno"  disabled="disabled" readonly="true"  value="<?php echo $rowmodule['customer_aadhaar_no']  ?>"/>
           </td>
      	</tr>
	  <tr >
	  <td>Reason<font color="#FF0000">*</font></td>
      		<td><textarea name="txtreason" id="txtreason" readonly="readonly" disabled="disabled"> <?php echo $rowmodule['sandreprint_reason']  ?></textarea>
    	</tr>
 <tr >
  
      		<td>Booking Status<font color="#FF0000">*</font></td>
      		<td>Approve  <input type="radio" name="radiobookingStatus"  value="2"  checked="checked" />
                Reject <input type="radio" name="radiobookingStatus"  value="3"  />
           </td>
      	</tr>
		   <tr >
      		<td>Remarks<font color="#FF0000">*</font></td>
      		<td ><textarea name="txtremarks" id="txtremarks" class="form-control"></textarea> </td>
      	</tr>
	  </table>
  		 
 		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		
		               <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Send"/>  
       			 		
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