<script>
$(document).ready(function()
{
	checkedStat = "<?php echo $permit_status; ?>";	
	if(checkedStat==2){
		$("#approved_quantity").css("display","");
	}
});
function permitStatus(status_val){
	if(status_val==0){
		//confirm("Are you sure to approve the permit ?");
		if (confirm('Are you sure to reject the permit ?')) {
			//alert('Please Confirm the Approved Amount of Sand before submit');
			//$("#approved_quantity").css("display","none");
		} else {
			window.location.reload();
		}
		//$("#approved_quantity").css("display","table-row");
	}
	if(status_val==2){
		
		$("#approved_quantity").css("display","table-row");
	}
}
function permitApproved_ton(quantity){
	newquantity = $("#permit_approved_ton").val();
	if(newquantity>quantity){
		alert('Sorry! maximum allowed quantity is '+quantity);
		$("#permit_approved_ton").val(quantity);
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
        
		 <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/monthlypermitapproval"); ?>"> Monthly Permit</a></li>
        <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Monthly Permit VIEW </strong></a></li>
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
			
       		$attributes = array("class" => "form-horizontal", "id" => "monthlyPermit", "name" => "monthlyPermit", "onSubmit" => "return validate_chk();");
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
       		echo form_open("Manual_dredging/Master/monthlypermitapprovalview", $attributes);
		?>

		 <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">

			<input type="hidden" name="hid" value="<?php if(isset($permit_id)){ echo $permit_id;} ?>" />
		Period : 
		</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<?php if(isset($period)){ echo $period;}   ?>
			</div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   LSG : 
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<?php if(isset($lsgd_name)){ echo $lsgd_name;}   ?>
			</div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Zone :
			 </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<?php if(isset($zone_name)){ echo $zone_name;}   ?>
			</div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
		   Number of workers : 
		   </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<?php if(isset($number_of_workers)){ echo $number_of_workers;}   ?>
			</div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Quantity Requested : 
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<?php if(isset($permit_requested_ton)){ echo $permit_requested_ton;}   ?>
			</div>
		</div> <!-- end of row -->
        
        
        <?php if ($permit_status==1) { ?>
        
			<div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
				Approve/Reject<font color="#FF0000">*</font>
				</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
					<input type="radio" name="permit_status" value="0" id="permit_status"  class=""  maxlength="100" onClick="permitStatus(this.value)" autocomplete="off" <?php if ($permit_status==3) {echo "checked";}?> />	Reject<br>
					<input type="radio" name="permit_status" value="2" id="permit_status"  class=""  maxlength="100" onClick="permitStatus(this.value)" autocomplete="off" <?php if ($permit_status==2) {echo "checked";}?> />	Approve
				</div>
		</div> <!-- end of row -->
			
			 <div class="row p-3" id="approved_quantity" style="display:none">
           <div class="col-md-6 d-flex justify-content-center px-2"   >
			Approved Quantity<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
		<input type="text" name="permit_approved_ton" value="<?php if(isset($permit_requested_ton)){ echo $permit_requested_ton ;}?>" id="permit_approved_ton"  class="form-control"  maxlength="100" onBlur="permitApproved_ton(<?php echo $permit_requested_ton ?>)" autocomplete="off" required/>
		</div>
		</div> <!-- end of row -->
 		<?php }else{
			
			 
			if($permit_status==1){
				 $statusValue='Approval Pending';
				 $butclass='btn btn-sm bg-blue';
			}else if($permit_status==2){
				$statusValue='Approved';
				$butclass='btn btn-sm bg-green';
			}else if($permit_status==3){
				$statusValue='Rejected';
				$butclass='btn btn-sm bg-red';
			}
		?> 
		
		<div class="row p-3" id="approved_quantity">
           <div class="col-md-6 d-flex justify-content-center px-2">
        	Request Status<font color="#FF0000">*</font>
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			 <font class="<?php echo $butclass ?>"><?php echo $statusValue ?></font>
			</div>
		</div> <!-- end of row -->
           <div class="row p-3" id="approved_quantity">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Approved Quantity<font color="#FF0000">*</font>
				</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
				<input readonly type="text" name="permit_approved_ton" value="<?php if(isset($permit_requested_ton)){ echo $permit_requested_ton ;}?>" id="permit_approved_ton"  class="form-control"  maxlength="100" onBlur="permitApproved_ton(<?php echo $permit_requested_ton ?>)" autocomplete="off" /> 
				</div>
		</div> <!-- end of row -->
           
		
		<?php } ?>
         <?php if ($permit_status==1) { ?>
         <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Remarks
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<textarea name="permit_approved_remarks" value="" id="permit_approved_remarks"  class="form-control"  maxlength="100" autocomplete="off"></textarea>
			</div>
		</div> <!-- end of row -->
        <?php }else{  ?>
        <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
			Approval/Rejection Remarks
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
			<textarea disabled name="permit_approved_remarks" value="" id="permit_approved_remarks"  class="form-control"  maxlength="100" maxheight="100" autocomplete="off"><?php if(isset($permit_approved_remarks)){ echo $permit_approved_remarks ;}?></textarea>
			</div>
		</div> <!-- end of row -->
        <?php } ?>
	  
	  
	  <?php if ($permit_status==1) { ?>
	  <div class="row px-5 py-5" >
 		
        <div class="col-12 d-flex justify-content-center">
		<input type="hidden" name="hId" value="<?php  if(isset($permit_id)){echo $permit_id;}?>" />
		<?php if(isset($permit_id)){?>
		 <input id="btn_add" name="btn_add" type="submit" class="px-4 btn btn-primary" value="Update" />
		<?php } else{?>
		               <input id="btn_add" name="btn_add" type="submit" class=" px-4 btn btn-primary" value="Save"/>


		<?php } ?>
        <input id="btn_cancel" name="btn_cancel" type="reset" class=" mx-4 btn btn-danger" value="Cancel" />
    
         </div> <!-- end of col 12 -->
         
	</div> <!-- end of row -->
	  
		
		<?php }
		else
		{ ?> 
		
		 <!--<input style="width: 120px;margin: 15px 0px 8px 0px;" id="btn_add" name="btn_add" type="button" onClick="gotoHome()" class="btn btn-primary" value="Back"/>-->
         <a style="width: 120px;margin-left: 340px;" href="<?php echo base_url(); ?>index.php/Manual_dredging/Master/monthlypermitapproval" class="btn btn-primary">Back</a>
         <a style="width: 120px;margin-left: 30px;" href="<?php echo base_url(); ?>index.php/Manual_dredging/Master/dashboard" class="btn btn-primary">Home</a>
		
		<?php } 
		 echo form_close(); ?>
		</div> <!-- end of container -->
  