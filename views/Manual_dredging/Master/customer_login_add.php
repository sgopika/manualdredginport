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
			
				
				
	 $('#userposting').validate(
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
 //function passwordgenerate()
// {
//document.getElementById('txtcustrpassword').value= Math.random().toString(36).slice(-8);
//document.getElementById('txtcustrconfpassword').value=document.getElementById('txtcustrpassword').value;
// }

</script>
    <section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?>
         <strong>Customer Request Processing </strong> </button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>"> Master</a></li>
		 <li><a href="<?php echo site_url("Master/customer_requestprocessing"); ?>"><strong>Customer Login</strong></a></li>
        <li><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?></strong></a><a href="<?php echo site_url("Master/canoeRegistration"); ?>"><strong>&nbsp;Customer Login Details</strong></a></li>
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
			
			   if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?>
              <a href="<?php echo site_url("Master/customer_requestprocessing_add"); ?>"><strong>Customer Login Details</strong></a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "customer_login_add", "name" => "customer_login_add");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "customer_login_add", "name" => "customer_login_add", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Master/customer_login_add", $attributes);
		} else {
			echo form_open("Master/customer_login_add", $attributes);
		}?>
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		<?php foreach($customerAppvd_data as $row){?> <input type="hidden" name="hid_usermasterid" id="hid_usermasterid" value="<?php echo encode_url($row['customer_public_user_id']);  ?>" />
	<?php	$cust_id=$row['customer_registration_id'];
	$serialno=$cust_id+1;
		 } ?>
              <table id="vacbtable" class="table table-bordered table-striped">

      <tr>
	  <td>User Name</td><?php foreach($portcode as $row){ $portcode= $row['vchr_officecode']; } 
	  $year=date("y");
	  ?>
	  <td><input type="text" name="txtcustrname"  id="txtcustrname"  class="form-control" value="<?php echo $year.$portcode.$serialno?>"   maxlength="100" autocomplete="off" readonly="true" required/></td></tr>
        <tr >
  
      		<td>Password<font color="#FF0000">*</font></td>
      		<td><input type="password" name="txtcustrpassword"  id="txtcustrpassword"  value="<?php echo $year.$portcode.$serialno?>"  class="form-control"  maxlength="100" autocomplete="off" readonly="true" required/>
           </td>
      	</tr>
		<tr >
        
       
        
        
      		<td>Confirm Password<font color="#FF0000">*</font></td>
      		<td ><input type="password" name="txtcustrconfpassword"  id="txtcustrconfpassword" value="<?php echo $year.$portcode.$serialno?>"  class="form-control" readonly="true"  maxlength="100" autocomplete="off" required/> </td>
      	</tr>

	  </table>
  		 
 		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
		<?php if(isset($int_designation_sl)){?>
		 <input id="btn_add" name="btn_add" type="submit" disabled="disabled" style="display:none" class="btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" disabled="disabled" style="display:none" class="btn btn-primary" value="Save"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" disabled="disabled" style="display:none" value="Cancel" />
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