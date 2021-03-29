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
				int_zone: {
					required: true,
					//no_special_check: true,
					maxlength: 20,
				},
				int_lsg: {
					required: true,
					maxlength: 20,
				},
				vch_worker_qty: {
					required: true,
					no_special_check: true,
					number:true,
					maxlength: 4,
				},
				vch_order_no: {
					required: true,
					//number:true,
				},
				vch_reg_date: {
					required: true,
					//number:true,vch_material_sd
				},
				vch_material_sd: {
					required: true,
					//number:true,vch_material_sd
				},
				int_status: {
					required: true,
					//number:true,vch_material_sd
				},
				vch_remark: {
					required: true,
					no_special_check: true,
					//number:true,vch_material_sdload_place
				},
				load_place: {
					required: true,
					no_special_check: true,
					//number:true,vch_material_sdload_place
				},
		},
		messages: {
				int_zone: {
					required: "<font color='#FF0000'> Zone required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				int_lsg: {
					required: "<font color='#FF0000'> Lsgd Required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 20 characters allowed!!</font>",
				},
				vch_worker_qty: {
					required: "<font color='#FF0000'> Worker Quantity required!!</font>",
					maxlength: "<font color='#FF0000'> Maximum 4 characters allowed!!</font>",
					no_special_check:"<font color='#FF0000'> Special characters not allowed!!</font>",
					number: "<font color='#FF0000'>Numbers Only!!</font>",
				},
				vch_order_no: {
					required: "<font color='#FF0000'> Order No Required!!</font>",
				},
				vch_reg_date: {
					required: "<font color='#FF0000'> Registration Date Required!!</font>",
				},
				vch_material_sd: {
					required: "<font color='#FF0000'> Start Date Required!!</font>",
				},
				int_status: {
					required: "<font color='#FF0000'> Status Required!!</font>",
				},
				vch_remark: {
					required: "<font color='#FF0000'> Remark Required!!</font>",
					no_special_check:"<font color='#FF0000'> Special characters not allowed!!</font>",
				},
				load_place: {
					required: "<font color='#FF0000'> Loading Place Required!!</font>",
					no_special_check:"<font color='#FF0000'> Special characters not allowed!!</font>",
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
			 if (startdate > enddate ) 
			 { 
			 	document.getElementById("start_date").value='';
				document.getElementById("end_date").value='';
				document.getElementById('enddatediv').innerHTML="<font color='red'><b>Start Date Cannot be greater than end date!!!</b></font>";
				document.getElementById('startdatediv').innerHTML="";
				return false; 
			} 
			else
			 {
				document.getElementById('startdatediv').innerHTML="";
				document.getElementById('enddatediv').innerHTML="";
			}
		}
}
			

</script>
<script type="text/javascript">
$(document).ready(function()
{
	$('#vch_worker_qty').blur(function()
				{
					//alert("hii");
					var nofw=$('#vch_worker_qty').val();
					if(nofw!='')
					{
						var wq = <?php echo $wq;?>;
						var qty=nofw*wq;
						$('#vch_monthly_qty').val(qty);
					}
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
 
});
</script>
<script type="text/javascript">
$(document).ready(function()
{
	$('#vch_material_sde').change(function()
				{
					//alert("h");
					var fromd=$('#vch_material_sd').val();
					var tod=$('#vch_reg_date').val();
					if(tod=='')
					{
						alert('select registration date');
					}
					else
					{
					var dateArf = fromd.split('/');
                    var newDatef = dateArf[2] + '/' + dateArf[1] + '/' + dateArf[0].slice(-2);
					var dateArt = tod.split('/');
                    var newDatet = dateArt[2] + '/' + dateArt[1] + '/' + dateArt[0].slice(-2);
					var x=newDatet+"/"+newDatef;
					//alert(x);
					if((newDatef==newDatet)||(newDatef > newDatet))
					{
					}
					else
					{
						$('#vch_reg_date').val('');
						$('#vch_material_sd').val('');
   						alert("Invalid Date Range");
					}
					}
				});
				
});


//----------------------------------------------------------------------------------------------------------------------------------------				
				 $(document).ready(function() {
				  $("#vch_material_sd").change(function() {
				 
            var selectedDate = $("#vch_material_sd").val();
			
		  var arr = selectedDate.split("/");
            var date = new Date(arr[2]+"-"+arr[1]+"-"+arr[0]);
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var minDate = new Date(y + 1, m, d - 1);
            $("#vch_material_ed").datepicker('setDate', minDate);
		
});
});
//-------------------------------------------------------------------------------------------------------------------------
</script>
   <!-------------------------------------------------------------------------------->
 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Assign Zone Details</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
          <li class="breadcrumb-item"><a href="#"><strong>Assign Kadavu to LSG</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
   <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>
   
   <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "userposting", "name" => "userposting");
			} else {
			$zone=$zone[0]['zoneid'];
			$zn=explode(',',$zone);
       $attributes = array("class" => "form-horizontal", "id" => "userposting", "name" => "userposting", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Master/assignzone_edit", $attributes);
		} else {
		echo form_open("Manual_dredging/Master/assignzone_add", $attributes);
			
		}?>
		<div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
            <a href="<?php echo $site_url.'/Manual_dredging/Master/zone_add';?>">
             <button type="button" class="btn btn-sm btn-primary" > <i class="fa fa-plus-circle"></i>&nbsp; Assign Kadavu </button>
              </a>
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    
    
    
    
    <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo encode_url($int_userpost_sl);} ?>" />
		<?php // print_r($lsg_zone); ?>
        
      		Select Zone<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_zone" id="int_zone"  class="form-control"  maxlength="100"  <?php if(isset($int_userpost_sl)){ ?> disabled="disabled" <?php } ?>>
            <option selected="selected" value="">--select--</option>
            <?php
			if(isset($int_userpost_sl))
				{
					?>
					<option value="<?php echo $lsg_zone[0]['zone_id']; ?>" selected="selected"><?php echo $lsg_zone[0]['zone_name']; ?></option>
					<?php
                }
				else
				{
				foreach($zones as $z)
				{
					if(in_array($z['zone_id'],$zn))
					{
				?>
                	<option value="<?php echo $z['zone_id']; ?>"><?php echo $z['zone_name']; ?></option>
                <?php
					}
				}
				}
				?>
            </select> 
           </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           Select LSG<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_lsg" value="" id="int_lsg"  class="form-control"  maxlength="100" <?php if(isset($int_userpost_sl)){ ?> disabled="disabled" <?php } ?>>
            	<option selected="selected">--select--</option>
                <?php
				if(isset($int_userpost_sl))
				{
					?>
					<option value="<?php echo $lsg_zone[0]['lsg_id'] ?>" selected="selected"><?php echo $lsg_zone[0]['lsgd_name'] ?></option>
					<?php
                }
				else
				{
				foreach($lsgd as $ls)
				{
					?>
						<option value="<?php echo $ls['lsgd_id'] ?>"><?php echo $ls['lsgd_name'] ?></option>
					<?php
				}
				}
				?>
            </select> 
           </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
           Registration Fee<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <?php
            if(isset($int_userpost_sl))
				{
					?>
                 <input type="text" name="vch_reg_fee" value="<?php echo $lsg_zone[0]['lsg_zone_registration_fee']; ?>" id="vch_reg_fee"  class="form-control"  maxlength="100" autocomplete="off" readonly /> 
                <?php
                }
                else
                {
					?>
            <input type="text" name="vch_reg_fee" value="<?php foreach($fee as $f) { if($f['fee_master_id']==1){echo $f['fee_master_fee'];} } ?>" id="vch_reg_fee"  class="form-control"  maxlength="100" autocomplete="off" readonly /> 
            	<?php
				}
				?>
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Jetty Fee<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <?php
             if(isset($int_userpost_sl))
				{
					?>
                 <input type="text" name="vch_jetty_fee" value="<?php echo $lsg_zone[0]['lsg_zone_jetty_fee']; ?>" id="vch_jetty_fee"  class="form-control"  maxlength="100" autocomplete="off" readonly /> 
                <?php
                }
                else
                {
					?>
           <input type="text" name="vch_jetty_fee" value="<?php foreach($fee as $f) { if($f['fee_master_id']==2){echo $f['fee_master_fee'];} } ?>" id="vch_jetty_fee"  class="form-control"  maxlength="100" autocomplete="off" readonly /> 
           <?php
				}
				?>
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Number of workers<font color="#FF0000">*</font>
          </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <?php
            if(isset($int_userpost_sl))
				{
					?>
                 <input type="text" name="vch_worker_qty" value="<?php echo $lsg_zone[0]['lsg_zone_number_of_workers']; ?>" id="vch_worker_qty"  class="form-control"  maxlength="100" autocomplete="off" /> 
                <?php
                }
				else
				{?>
           <input type="text" name="vch_worker_qty" value="" id="vch_worker_qty"  class="form-control"  maxlength="100" autocomplete="off" /> 
            <?php
				}
				?>
            	
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">File Number<font color="#FF0000">*</font>
          </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
             <?php
            if(isset($int_userpost_sl))
				{
					?>
                 <input type="text" name="vch_order_no" value="<?php echo $lsg_zone[0]['lsg_zone_order_number']; ?>" id="vch_order_no"  class="form-control"  maxlength="100" autocomplete="off" /> 
                <?php
                }
				else
				{?>
                
           <input type="text" name="vch_order_no" value="" id="vch_order_no"  class="form-control"  maxlength="100" autocomplete="off" /> 
           <?php
				}
				?>
           </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Registration Date<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                   <?php
            if(isset($int_userpost_sl))
				{
					?>
                 <input type="date" name="vch_reg_date" value="<?php echo $lsg_zone[0]['lsg_zone_registration_date'];//date("d/m/Y", strtotime(str_replace('-', '/',$lsg_zone[0]['lsg_zone_registration_date'] ))); ?>" id="vch_reg_date"  class="form-control dob"   onChange="check_dates();"    /> 
                <?php
                }
				else
				{
				$datereg = date("d-M-Y");
				
				//echo "dfgdfgdfg";
				?>
				<input type="text" name="vch_reg_date" id="vch_reg_date"   value="<?php echo  $datereg;?>" class="form-control"  autocomplete="off"  readonly />
          
            <?php
				}
			?>
            </div>
            <span id="startdatediv" ></span>
              </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Monthly Quantity<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
             <?php
            if(isset($int_userpost_sl))
				{
					?>
                  <input type="text" name="vch_monthly_qty" value="<?php echo  $lsg_zone[0]['lsg_zone_monthly_ton']; ?>" id="vch_monthly_qty"  class="form-control" readonly  maxlength="100" autocomplete="off" /> 
                <?php
                }
				else
				{?>
           <input type="text" name="vch_monthly_qty" value="" id="vch_monthly_qty"  class="form-control" readonly  maxlength="100" autocomplete="off" /> 
           <?php
				}
				?>
           </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Start Date<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                    <?php
            if(isset($int_userpost_sl))
				{
					?>
                    <input type="date" name="vch_material_sd" value="<?php echo $lsg_zone[0]['lsg_zone_start_date']; ?>" id="vch_material_sd"  class="form-control dob"   onChange="check_dates();"   maxlength="100" autocomplete="off" /> 
                <?php
                }
				else
				{?>
           <input type="date" name="vch_material_sd" value="" id="vch_material_sd"  class="form-control dob"   onChange="check_dates();"   maxlength="100" autocomplete="off" /> 
           <?php
				}
				?>
            </div>
            <span id="startdatediv" ></span>
             </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">End Date<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <?php
                   if(isset($int_userpost_sl))
					{
					if($lsg_zone[0]['lsg_zone_end_date']=='0000-00-00')
					{
						$enddate="";
					}
					else
					{
						$enddate=date("d/m/Y", strtotime(str_replace('-', '/',$lsg_zone[0]['lsg_zone_end_date'] )));
					}
					
					$modificator = ' +1 year -1 day';
					$renewalDate = date('d-m-Y', strtotime($rows['CoverStartDate'] . $modificator));
					//echo "wewewewew--".$renewalDate;
					?>
                    <input type="date" name="vch_material_ed" value="<?php echo $enddate; ?>" id="vch_material_ed"  class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" onChange="check_dates();" data-mask  maxlength="100" autocomplete="off" />
                    <?php
				}
				else
				{
					?>
           <input type="date" name="vch_material_ed" value="" id="vch_material_ed"  class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" onChange="check_dates();" data-mask  maxlength="100" autocomplete="off" readonly />
           <?php
				}
			?>
           </div>
            <span id="startdatediv" ></span> 
             </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Loading Place<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
             <?php
            if(isset($int_userpost_sl))
				{
					?>
                      <input type="text" name="load_place" id="load_place" value="<?php echo $lsg_zone[0]['lsg_zone_loading_place']; ?>"  class="form-control"   maxlength="100" autocomplete="off" />
                <?php
                }
				else
				{?>
           <input type="text" name="load_place" id="load_place"  class="form-control"   maxlength="100" autocomplete="off" /> 
           <?php
				}
				?>
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Status<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select  name="int_status" value="" id="int_status"  class="form-control"  maxlength="100">
            <?php if(isset($int_userpost_sl)){
				  foreach($status as $s)
			    {
				?>
            <option value="<?php echo $s['status_id'];?>" <?php if($s['status_id']==$lsg_zone[0]['lsg_zone_status']) { ?> selected="selected" <?php } ?> ><?php echo $s['status_name'];?></option>
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
            <option value="<?php echo $s['status_id'];?>" <?php if($s['status_id']==1) {?> selected="selected" <?php } ?> ><?php echo $s['status_name'];?></option>
            <?php
			}
			}
			?>
            </select> 
            
           </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Remark<font color="#FF0000">*</font></div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <textarea  name="vch_remark"  class="form-control" id="vch_remark" maxlength="100"><?php if(isset($int_userpost_sl)){ echo $lsg_zone[0]['lsg_zone_remarks']; }?></textarea> 
            </div>
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
 
$(function(){
	 // $("#vch_material_sd").datepicker();
	 //$('#vch_material_sd').datepicker('setStartDate', new Date());
	//  $("#vch_material_ed").datepicker();
	//   $("#vch_reg_date").datepicker();
	  //$('#vch_reg_date').datepicker('setStartDate', new Date());
	  // $( "#vch_reg_date" ).datepicker({minDate: new Date()});
	  });
</script>