<?php
//print_r($_REQUEST);
?>
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
 <link rel="stylesheet" href=<?php echo base_url("assets/datepicker-bootsrap/css/datepicker3.css"); ?>>
   <script src="<?php echo base_url('assets/datepicker-bootsrap/js/bootstrap-datepicker.js');?>"></script>
   <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>></script>
      <script src=<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>></script>
	   <script src=<?php echo base_url("assets/aadhar/Verhoeff.js");?>></script>
	  <script type="text/javascript">
	
		 jQuery.validator.addMethod("nospecial", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);
			},$.validator.format("<font color='red'>No Special characters allowed.</span>")); 
			   	
			jQuery.validator.addMethod("namewithspace", function(value, element) {
			return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
			},$.validator.format("<font color='red'>Characters and Space allowed.</span>"));
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
		jQuery.validator.addMethod("exactlength", function(value, element, param) {
		 		return this.optional(element) || value.length == param;
			}, $.validator.format("<font color='red'>Please enter exactly {0} characters.</span>"));
			
	
</script>
    <section class="content-header">
          
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
		  
            
        <div class="box box-primary box-green-bottom">
       
            <div class="box-header ">
               <h3 class="box-title" > <p align="center"  ><strong>Pass Details</strong>
	 <?php
			if($pass_msg==1)
			{
				$msg='Valid Pass';
				$class='alert alert-info alert-success';
			}
		 else if($pass_msg==2)
		 {
			$msg='Invalid Pass'; 
			 $class='alert alert-info alert-danger';
		 }
		else
		{
			$msg='Pass not Scanned';
			$class='alert alert-info';
		}	   
				   
				   
				$this->load->model('Master_model');	
				   if($pass_type==1)
				  {
					  foreach($data_vehiclepass as $datavehiclepass)
		{
		$lsgdid                  = $datavehiclepass['customer_booking_lsg_id'];
		$zoneid                  = $datavehiclepass['customer_booking_zone_id'];
		$customerregistration_id = $datavehiclepass['customer_booking_registration_id'];
		$tokenno		=	$datavehiclepass['customer_booking_token_number'];
		$permitno		=	$datavehiclepass['customer_permit_number'];
		$vehicleno		=	$datavehiclepass['customer_booking_vehicle_registration_number'];
		$driverlicense	=	$datavehiclepass['customer_booking_driver_license'];
		$requestton		=	$datavehiclepass['customer_booking_request_ton'];
		$bookingroute	=	$datavehiclepass['customer_booking_route'];
		$distance		=   $datavehiclepass['customer_booking_distance'];
		$passissuedate	=	date("d-m-Y H:i:s",strtotime(str_replace('-', '/',$datavehiclepass['customer_booking_pass_issue_timestamp'])));
				}  
				
		$lsgzonedetails=$this->db->query("select * from lsg_zone where lsg_zone.lsg_id ='$lsgdid' and lsg_zone.zone_id='$zoneid'");
		$lsgzone_details=$lsgzonedetails->result_array();
		$data['lsgzone_details']=$lsgzone_details;
				
		$loadingplace	=	$lsgzone_details[0]['lsg_zone_loading_place'];
		
		//$lsgdetails=$this->db->query("select * from lsgd where lsgd_id ='$lsgdid' and lsgd_status=1");
		//$lsg_details=$lsgdetails->result_array();
		//print_r($lsg_details); break;
		//$data['lsg_details']=$lsg_details;
		
		
		//$lsgdename		=	$lsg_details[0]['lsgd_name'];
		//$lsgdaddress	=	$lsg_details[0]['lsgd_address'];
		//$lsgdphoneno	=	$lsg_details[0]['lsgd_phone_number'];
		$customerregdetails=$this->db->query("select customer_name,customer_phone_number,customer_unused_ton,customer_perm_house_number,customer_perm_house_name,customer_perm_house_place,customer_unloading_place,customer_perm_house_place from customer_registration where customer_registration_id ='$customerregistration_id'");
		$customerregdetails=$customerregdetails->result_array();
		$data['customerregdetails']=$customerregdetails;
		
		
	$customername		=	$customerregdetails[0]['customer_name'];
	$customerphone		=	$customerregdetails[0]['customer_phone_number'];
	$unloadplace		=	$customerregdetails[0]['customer_unloading_place'];
		
		
		//-------------------------------------------------------------------------
		$timetaken		= ($distance*3);
	//$roundtime=round($timetaken,2);
	//$roundtimenew=explode('.',$roundtime);
	$totamount		=	$data_vehiclepass[0]['transaction_amount'];
	$currentdate=date('d-m-Y H:i:s');
				  
				  }
				  else
				  {
	$customername	=	$data_vehiclepass[0]['spot_cusname'];
	$customerphone	=	$data_vehiclepass[0]['spot_phone'];
	$tokenno		=	$data_vehiclepass[0]['spot_token'];
	$vehicleno		=	$data_vehiclepass[0]['spot_vehicleRegno'];
	$driverlicense	=	$data_vehiclepass[0]['spot_license'];
	$requestton		=	$data_vehiclepass[0]['spot_ton'];
	$bookingroute	=	$data_vehiclepass[0]['spot_route'];
	$passissuedate	=	date("d-m-Y H:i:s",strtotime(str_replace('-', '/',$data_vehiclepass[0]['pass_issue_timestamp'])));
	
	$unloadplace	=	$data_vehiclepass[0]['spot_unloading'];
	$printstatus	=   $data_vehiclepass[0]['spot_unloading'];
	$totamount		=	$data_vehiclepass[0]['transaction_amount'];
	$currentdate=date('d-m-Y H:i:s');  
				  }
		
				  
				  
				  ?>
			  <table border="0" style="text-align:left;" width="100%">
		<thead style="font-weight:50">

		<tr>
		<th width="60%"> Token Number</th>
		<th width="40%">: <?php echo $tokenno;?></th>
		</tr>
		<tr>
		<th> Customer name</th>
		<th>: <?php echo $customername;?></th>
		</tr>
		<?php if($pass_type==1) {?>
		<tr>
		<th>Permit No</th>
		<th>: <?php echo $permitno?></th>
		</tr><?php } ?>
		<tr>
		  <th> Vehicle Number</th>
		  <th>: <?php echo  $vehicleno; ?></th>
		  </tr>
		<tr>
		  <th> Driver License No</th>
		  <th>: <?php echo  $driverlicense;?></th>
		  </tr>
		<tr>
		  <th> Quantity of Dredged Material(in Ton)</th>
		  <th>: <?php echo  $requestton;	?></th>
		  </tr>
		<tr>
		  <th> Loading Place</th>
		  <th>: <?php echo $loadingplace; ?></th>
		  </tr>
		<tr>
		  <th> Unloading Place</th>
		  <th>: <?php echo $unloadplace; ?></th>
		  </tr>
		<tr>
		  <th> Vehicle Pass Issued Date & Time</th>
		  <th>: <?php echo $passissuedate; ?></th>
		  </tr>
		<tr>
		  <th> Route</th>
		  <th>: <?php echo $bookingroute; ?></th>
		  </tr>
		<tr>
		<th>Duration of Pass</th>
		<th>: <?php echo $this->Master_model->convertToHoursMinsnew($timetaken, '%02d hours %02d mins');?></th>
		</tr>
		<tr>
		<th>Cost of Sand</th>
		<th>: <?php echo $totamount;?></th>
		</tr>
		
		
		</thead>
		</table>
		<p class="<?php echo $class;?>"><?php echo $msg?></p>
		<hr/>
				  </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
			//print_r($get_userposting_details);
			// echo $get_userposting_details[0]['int_userpost_user_sl'];
			if(isset($int_userpost_sl)){
        $attributes = array("class" => "form-horizontal", "id" => "customerregistration_add", "name" => "customerregistration_add", "enctype"=> "multipart/form-data");
			} else {
       $attributes = array("class" => "form-horizontal", "id" => "customerregistration_add", "name" => "customerregistration_add", "onSubmit" => "return validate_chk();", "enctype"=> "multipart/form-data");
			}
        // echo form_open_multipart("registration/upload_byelawform_view/$society_id",$attributes);
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		//if(isset($int_userpost_sl)){
       	//	echo form_open_multipart("Master/customerregistration_add", $attributes);
		//} else {
			echo form_open("Master/customerregistration_add", $attributes);
		//}?>
		<input type="hidden" name="hid" value="<?php if(isset($int_userpost_sl)){ echo $int_userpost_sl;} ?>" />
		
              
  		 
 		
		

    
          
              
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
</script>