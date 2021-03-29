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
<link href="<?php echo base_url('assets/datepicker-bootsrap/css/datepicker.css'); ?>" rel="stylesheet" media="screen">
   <script src="<?php echo base_url('assets/datepicker-bootsrap/js/bootstrap-datepicker.js');?>"></script>
   
    <script >
    function numberofworkers(no_of_workers){
    	//alert("sssss");
		newvalue = $("#number_of_workers").val();
		if(newvalue>no_of_workers){
			if(no_of_workers==0)
			{
				alert('There is no workers registered for this LSGD!!! Please complete worker registration before Monthly Permit');
				window.location.href="<?php echo base_url() ?>/index.php/Manual_dredging/Master/workerregistration";	
			}else{
				alert('The no of workers should not exceed '+no_of_workers);
			}
			$("#number_of_workers").val(no_of_workers);
		}else if(newvalue<no_of_workers){
			worker_quantity = '<?php echo  $worker_quantity ?>';
			$("#permit_requested_ton").val(worker_quantity*newvalue);
			
		}
	}
	
	function permitrequested_ton(quantity){
		newquantity = $("#permit_requested_ton").val();
		noworker = $("#number_of_workers").val();
		worker_quantity = '<?php echo  $worker_quantity ?>';
		quantity=noworker*worker_quantity;
		if(newquantity>quantity){
			alert('Sorry! maximum allowed quantity is '+quantity);
			$("#permit_requested_ton").val(quantity);
		}
	}
    </script>
    <div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 <?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Monthly Permit</button>
		</div>

    <div class="col-12 d-flex justify-content-end">
     
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Port/port_lsgd_main"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/monthlyPermit"); ?>"><strong>Monthly Permit </strong></a></li>
		 
        <li class="breadcrumb-item"><a href="#"><strong><?php if(isset($int_userpost_sl)){?>Edit<?php } else {?>Add <?php }?> Monthly Permit </strong></a></li>
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
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        		$attributes = array("class" => "form-horizontal", "id" => "monthlyPermit", "name" => "monthlyPermit");
			} else {
       			$attributes = array("class" => "form-horizontal", "id" => "monthlyPermit", "name" => "monthlyPermit", "onSubmit" => "return validate_chk();");
			}
        
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_userpost_sl)){
       		echo form_open("Manual_dredging/Master/monthlyPermit_edit", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/monthlypermit_add", $attributes);
		}?>
                
                
                 <div class="row p-3">
          <div class="col-md-6 d-flex justify-content-center px-2">
                
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
      
    
    
    
		
	
        
        <input type="hidden" class="form-control" name="end_date"  value="<?php echo @$end_date?>" id="end_date" >
        <input type="hidden" class="form-control" name="start_date"  value="<?php echo @$start_date?>" id="end_date" >
       Number of workers<font color="#FF0000">*</font>
          </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
                    <input type="text" name="number_of_workers" value="<?php if(isset($number_of_workers )){echo $number_of_workers;} else { echo set_value('number_of_workers');} ?>" id="number_of_workers"  class="form-control"  maxlength="100" onBlur="numberofworkers(<?php echo $number_of_workers;?>)" autocomplete="off" required/> 
              </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
                    Required Quantity of sand<font color="#FF0000">*</font>
           </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
                    <input type="text" name="permit_requested_ton" value="<?php if(isset($permit_requested_ton )){echo $permit_requested_ton;} else { echo set_value('permit_requested_ton');} ?>" onBlur="permitrequested_ton(<?php echo $permit_requested_ton; ?>)" id="permit_requested_ton"  class="form-control"  maxlength="100" autocomplete="off" required/> 
              </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Remarks
          </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
                    <textarea name="permit_remarks" id="permit_remarks" class="form-control"></textarea>
                </div>
           </div>
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
                </div>            
              
		<?php echo form_close(); ?>
<!--  </div> <!-- end of container -->