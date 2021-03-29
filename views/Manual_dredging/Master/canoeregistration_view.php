<?php
//print_r($_REQUEST);
?>
<!-------------------------------------------------------------------------------->
 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Canoe Registration</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end"><nav>
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
          <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/canoeregistration"); ?>"><strong>Canoe Registration</strong></a></li>
          <li class="breadcrumb-item"><a href="#"><strong>Canoe Registration view</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
<div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
            <a href="<?php echo $site_url.'/Manual_dredging/Master/canoeregistration_add';?>">
             <button type="button" class="btn btn-sm btn-primary" > <i class="fa fa-plus-circle"></i>&nbsp; Add New Canoe </button>
              </a>
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->

<div class="row">
		<div class="col-12">
		<!-- ///////////////////////// start of table column //////////////////////---- -->
		<table id="example1" class="table table-bordered table-striped table-hover">
        <tr >
      		<td>Registration Number<font color="#FF0000">*</font></td>
      		<td ><?php if(isset($canoe_registration_number )){echo $canoe_registration_number;} ?> </td>
      	</tr>
        
        <tr >
      		<td>Canoe Name<font color="#FF0000">*</font></td>
      		<td ><?php if(isset($canoe_name )){echo $canoe_name;}?> </td>
      	</tr>
        
        <tr >
      		<td>Capacity<font color="#FF0000">*</font></td>
      		<td ><?php if(isset($canoe_capacity )){echo $canoe_capacity;} ?> </td>
      	</tr>
        
        <tr >
      		<td>Number of workers<font color="#FF0000">*</font></td>
      		<td ><?php if(isset($number_of_workers )){echo $number_of_workers;}?></td>
      	</tr>
        
        <tr>
      		<td>Registration Fee<font color="#FF0000">*</font></td>
      		<td ><?php if(isset($canoe_registration_fee )){echo $canoe_registration_fee;} ?></td>
      	</tr>
       
		<tr >
      		<td>Select Zone<font color="#FF0000">*</font></td>
      		<td><?php if(isset($zone_name )){echo $zone_name;} ?></td>
      	</tr>
       
		<tr >
      		<td>Status<font color="#FF0000">*</font></td>
      		<td><?php if($canoe_status==1){echo '<font class="btn btn-sm bg-green">Active</font>';}else{ echo '<font class="btn btn-sm bg-red">Inactive</font>';} ?></td>
      	</tr>

	  </table>
  <!-- ----------------------------------------------------- end of table column ------------------------------------- -->
              </div> <!-- end of table col10 -->
               <!-- end of col2 -->
	</div>
  
  
   
   </div> <!-- ui innerpage closed-->
   
   