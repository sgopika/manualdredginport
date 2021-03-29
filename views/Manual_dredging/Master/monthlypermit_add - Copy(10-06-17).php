<?php
//print_r($_REQUEST);
?>

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
				document.getElementById('startdatediv').innerHTML="";
				document.getElementById('enddatediv').innerHTML="";
				
				start_date=$("#start_date").val();
				//current_date=Date('D MMM, YYYY');
				var d = new Date();
				var n = d.getDate();
				var m = d.getMonth();
				var y = d.getFullYear();
				var startdate 	= start_date.split('/');
			 	startdate 	= new Date(startdate[2], startdate[1], startdate[0]); 
				var enddate 	= end_date.split('/'); 
				enddate 	= new Date(enddate[2], enddate[1], enddate[0]); 
				if(y==startdate[2]){
					if(m==startdate[1]){
						if(startdate[0]<n ){
							alert('Select a date after current date!');
						}else{
							if(startdate[0]>25 ){
								alert('Permit for this month can only done before 25-'+m+'-'+y+'  !');
								$("#start_date").val('');
							}else{
								if(enddate[0]>31 ){
									alert('Permit for this month can only till 31-'+m+'-'+y+'  !');
									$("#end_date").val('');
								}else{
										
								}		
							}	
						}
					}else{
						//alert('Permit for the given month is not Active');
						if(startdate[1]==m+1){
								//alert('Permit for this month can only done before 25-'+m+'-'+y+'  !');
								if(startdate[0]>25 ){
									alert('Permit for this month can only done before 25-'+(m+1)+'-'+y+'  !');
									$("#start_date").val('');
								}else{
									if(enddate[0]>31 ){
										alert('Permit for this month can only till 31-'+(m+1)+'-'+y+'  !');
										$("#end_date").val('');
									}else{
											
									}		
								}	
						}else{
								
						}		alert('Permit for the given month is not Active');
					}
				}else{
					alert('Permit for the given year is not Active');	
				}
				
				 /*var startdate 	= start_date.split('/');
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
				}*/
			}
	}
	
	</script>
    <script>
    function numberofworkers(no_of_workers){
		newvalue = $("#number_of_workers").val();
		if(newvalue>no_of_workers){
			alert('The no of workers should not exceed '+no_of_workers);
			$("#number_of_workers").val(no_of_workers);
		}
	}
	
	function permitrequested_ton(quantity){
		newquantity = $("#permit_requested_ton").val();
		if(newquantity>quantity){
			alert('Sorry! maximum allowed quantity is '+quantity);
			$("#permit_requested_ton").val(quantity);
		}
	}
    </script>
    
  
    <section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?>
         <strong>Monthly Permit </strong> </button>
	</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>"> Master</a></li>
		 <li><a href="<?php echo site_url("Master/monthlyPermit"); ?>"><strong>Monthly Permit </strong></a></li>
        <li><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?></strong></a><a href="<?php echo site_url("Master/monthlypermit_add"); ?>"><strong>Monthly Permit </strong></a></li>
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
              <strong>Monthly Permit </strong></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        		$attributes = array("class" => "form-horizontal", "id" => "monthlyPermit", "name" => "monthlyPermit");
			} else {
       			$attributes = array("class" => "form-horizontal", "id" => "monthlyPermit", "name" => "monthlyPermit", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Master/monthlyPermit_edit", $attributes);
		} else {
			echo form_open("Master/monthlypermit_add", $attributes);
		}?>
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		
		<table id="vacbtable" class="table table-bordered table-striped">
        <tr >
      		<td>Start date<font color="#FF0000">*</font></td>
      		<td>
         		<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
				  <?php
				  if(isset( $get_userposting_details[0]['dte_userpost_startdate'])){
				$dte_userpost_startdate = $get_userposting_details[0]['dte_userpost_startdate'];
					$start_date = explode('-', $dte_userpost_startdate);
					$start_date =$start_date[2]."-".$start_date[1]."-".$start_date[0];
				  }
					$start_date = set_value('start_date') == true ?  set_value('start_date'): @$start_date ; 
				  ?>
                <input type="text" class="form-control"  value="<?php echo @$start_date?>" name="start_date" id="start_date" data-inputmask="'alias': 'dd/mm/yyyy'" onChange="check_dates();" data-mask>
              </div>
				<span id="startdatediv" ></span>
            </td>
      	</tr>
        <tr >
      		<td>End date<font color="#FF0000">*</font></td>
      		<td>
           <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
				   <?php
				    if(isset( $get_userposting_details[0]['dte_userpost_enddate'])){
					$dte_userpost_enddate = $get_userposting_details[0]['dte_userpost_enddate'];
					$end_date = explode('-', $dte_userpost_enddate);
					$end_date =$end_date[2]."-".$end_date[1]."-".$end_date[0];
				  }
					$end_date = set_value('end_date') == true ?  set_value('end_date'): @$end_date ;

				  ?>
                  <input type="text" class="form-control" name="end_date"  value="<?php echo @$end_date?>" id="end_date" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onChange="check_dates();">
                </div>
				<span id="enddatediv" ></span>
            </td>
      	</tr>
        
        <tr >
      		<td>Number of workers<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="number_of_workers" value="<?php if(isset($number_of_workers )){echo $number_of_workers;} else { echo set_value('number_of_workers');} ?>" id="number_of_workers"  class="form-control"  maxlength="100" onBlur="numberofworkers(<?php echo $number_of_workers;?>)" autocomplete="off" required/> </td>
      	</tr>
        
        <tr >
      		<td>Required Quantity of sand<font color="#FF0000">*</font></td>
      		<td ><input type="text" name="permit_requested_ton" value="<?php if(isset($permit_requested_ton )){echo $permit_requested_ton;} else { echo set_value('permit_requested_ton');} ?>" onBlur="permitrequested_ton(<?php echo $permit_requested_ton; ?>)" id="permit_requested_ton"  class="form-control"  maxlength="100" autocomplete="off" required/> </td>
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
  $(function() {
    $("#start_date").datepicker();
	$("#end_date").datepicker();
	
  });
</script>