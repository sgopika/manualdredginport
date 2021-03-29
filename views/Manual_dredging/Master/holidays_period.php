<script>
	$(document).ready(function(){
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
});
</script>
<script src=<?php echo base_url("plugins/js/jquery.validate.min.js");?>></script>
<script type="text/javascript">
	function list_dates()
	{
		//alert("hai");
		var month =$("#month option:selected").val();
		var month_name =$("#month option:selected").text();
		var year = $("#year option:selected").val();
		var zone_id =$("#zoneid option:selected").val();
		//alert(month_name);
		//alert(year);
		/*if((zone_id==""))
			{
				document.getElementById('zonediv').innerHTML="<font color='red'><b>Please Select the Zone !!!</b></font>";
				
			}*/
		if((month=="")&&(year==""))
			{
				document.getElementById('monthdiv').innerHTML="<font color='red'><b>Please Select the Month !!!</b></font>";
				document.getElementById('yeardiv').innerHTML="";
			}
		if((month=="")&&(year!=""))
			{
				document.getElementById('monthdiv').innerHTML="<font color='red'><b>Please Select the Month !!!</b></font>";
				document.getElementById('yeardiv').innerHTML="";
			}
		if((month!="")&&(year==""))
			{
				document.getElementById('yeardiv').innerHTML="<font color='red'><b>Please Select the Year !!!</b></font>";
				document.getElementById('monthdiv').innerHTML="";
			}
		if((month!="")&&(year!="")){
			
				document.getElementById('monthdiv').innerHTML="";
				document.getElementById('yeardiv').innerHTML="";
				//Checking Holiday Already Set
				var period_name=month_name+' '+year;
				var port_id='<?php echo $port_id ;?>';
				
				$.post("<?php echo $site_url?>/Manual_dredging/Master/holiday_checking_Ajax",{period_name:period_name,port_id:port_id,zone_id:zone_id},function(data)
				{	
					//alert(data);
					//$('#daterangearray').html(data);
					if(data==0){
						
						$('#daterangearrayRow').css("display","table-row");
						//var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);	
						var date = new Date();
						var lastDay = new Date(year,month, 0);
						var lastDate = lastDay.getDate();
						var start_date=year+'/'+month+'/01';
						var end_date=year+'/'+month+'/'+lastDate;
						$("#start_date").val(start_date);
						$("#end_date").val(end_date);
						//alert(start_date+' '+end_date);exit();
						$.post("<?php echo $site_url?>/Manual_dredging/Master/createDateRangeArr",{start_date:start_date,end_date:end_date},function(data)
						{	
							//$('#daterangearray').html(data);
						});
						
					}else if(data==1){
						
						/*$("#month").val("");
						$("#year").val("");*/
						//window.location.reload();
						alert('Sorry ! Holidys for the Period "'+period_name+'" was Already Set!, Please use the Edit Holiday Option !!');	
					}
				});
				
		}
	}
	
	function displayCommentBox(idDate){
		//alert($('#checkbx1:checkbox:checked').length);
		/*if($('#checkbx'+idDate).is(":checked")==true){
			$('#textbx'+idDate).css('display','block');
		}
		if($('#checkbx'+idDate).is(":checked")==false){
			$('#textbx'+idDate).css('display','none');
		}*/
		$('#textbx'+idDate).css('display','block');
		$('#textbx'+idDate).prop('required', 'true');
		$('#textbx'+idDate).removeAttr('disabled');
	}
	function hideCommentBox(idDate){
		$('#textbx'+idDate).css('display','none');
		$('#textbx'+idDate).prop('disabled', 'true');
		$('#textbx'+idDate).removeAttr('required');
	}
	
	</script>

	
	<div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?><?php }?>

         <strong>Holiday Settings</strong></button>
		</div>
		
     <div class="col-12 d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/holidaysettings"); ?>"><strong>Holiday Settings </strong></a></li>
         
       
      </ol>
</div>

    <!-- Main content -->
   	<div class="col-md-12">
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      <!--      </div> -->
		 </div> <!-- end of co12 -->
		</div> <!-- end of row -->  

	
	
       <div class="row p-3 justify-content-center" >
          
             <h5 class="" style="margin:5px;align:center;">Please Select the Month and Year to Add Holiday for that Period</h5>
            </div>
           
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "holidays_add", "name" => "holidays_add","onSubmit" => "return check_dates();");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "holidays_add", "name" => "holidays_add","onSubmit" => "return check_dates();");
			}
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		//echo form_open("Master/holidays_edit", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/holidays_add", $attributes);
		}?>
		
		 <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
        
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		
      
        
        
        <?php
			$range_before=(date('Y')-10);
			$range_after=(date('Y')+10);
			$yearArray = range($range_before,$range_after);
			// set the month array
			$formattedMonthArray = array(
				"01" => "January", "02" => "February", "03" => "March", "04" => "April",
				"05" => "May", "06" => "June", "07" => "July", "08" => "August",
				"09" => "September", "10" => "October", "11" => "November", "12" => "December",
			);
			$current_month=date('m');
		?>
		
        	
                        Select Zone<font color="#FF0000">*</font>
						</div>
                       <div class="col-md-4 d-flex justify-content-center px-2">
						
                            <select id="zoneid" name="zoneid" class="form-control" onchange="list_dates();" >
							<option value="">--Select--</option>
							<?php foreach($get_zone_details as $rowzone){ ?>
							<option value="<?php echo $rowzone['zone_id']; ?>" >
							<?php echo $rowzone['zone_name']; ?></option>
							<?php } ?>
							</select>
                        <span id="zonediv" ></span>
                       
						</div>
                
		</div>
		
         <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
		  Select Month<font color="#FF0000">*</font>
		  </div>
                 <div class="col-md-4 d-flex justify-content-center px-2"  id="month">       
                            <select name="month" class="form-control" onChange="list_dates();" style="width:40%">
                                <option value="">Select Month</option>
                                <?php
                                foreach ($formattedMonthArray as $key => $month) {
                                    
									echo '<option value="'.$key.'">'.$month.'</option>';
                                }
                                ?>
                            </select>
                        
                        <span id="monthdiv" ></span>
				</div>
                
		</div> 
       
        <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
        	
                       Select Year<font color="#FF0000">*</font>
					   </div>
					    <div class="col-md-4 d-flex justify-content-center px-2" id="year">
                        
                            <select name="year" class="form-control" onChange="list_dates();" style="width:40%">
                                <option value="">Select Year</option>
                                <?php
                                foreach ($yearArray as $year) {
                                   	 echo '<option value="'.$year.'">'.$year.'</option>';
                                }
                                ?>
                            </select>
                        
                        <span id="yeardiv" ></span>
					</div>
				
       </div> 
        
      
	  </table>
  		 
 		<div class="row px-5 py-5">
 		
        <div class="col-12 d-flex justify-content-center">
		<input type="hidden" name="hId" value="<?php  if(isset($int_designation_sl)){echo $int_designation_sl;}?>" />
        <input type="hidden" id="start_date" name="start_date" value="">
        <input type="hidden" id="end_date"  name="end_date" value="">
		<?php if(isset($int_designation_sl)){?>
		 <input id="btn_add" name="btn_holy_period" type="submit" class="btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_holy_period" name="btn_holy_period" type="submit" class="btn btn-primary" value="Go"/>


		<?php } ?>
        &nbsp;<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
        </div>
        </div>
		

    
          
              
		   <?php echo form_close(); ?>
</div>
  