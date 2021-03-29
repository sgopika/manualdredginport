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
          <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/workerregistration"); ?>"><strong>Worker Registration</strong></a></li>
          <li class="breadcrumb-item"><a href="#"><strong>Worker Registration view</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
 
            <div class="row">
    <div class="col-12">
      <?php if( $this->session->flashdata('msg')){ 
        echo $this->session->flashdata('msg');
       }?>
      <h3 class="box-title"> Worker Details</h3>


    </div></div>

<div class="row">
    <div class="col-12">
    <!-- ///////////////////////// start of table column //////////////////////---- -->
    <table id="example1" class="table table-bordered table-striped table-hover">
      
        <tr>
      		<td>Aadhar Number<font color="#FF0000">*</font></td>
      		<td ><?php if(isset($worker_adhar_no )){echo $worker_adhar_no;} ?> </td>
      	</tr>
        
        <tr >
      		<td>Name<font color="#FF0000">*</font></td>
      		<td ><?php if(isset($worker_name )){echo $worker_name;}  ?></td>
      	</tr>
        
        <tr >
      		<td>Father’s Name<font color="#FF0000">*</font></td>
      		<td ><?php if(isset($worker_father_name )){echo $worker_father_name;} ?></td>
      	</tr>
        
        <tr >
      		<td>Address<font color="#FF0000">*</font></td>
      		 <td><?php if(isset($worker_address )){echo $worker_address;} ?></td>
      	</tr>
        
         <tr >
      		<td>Mobile Number <font color="#FF0000">*</font></td>
      		<td ><?php if(isset($worker_phone_number )){echo $worker_phone_number;} ?></td>
      	</tr>
        
		<tr >
      		<td>Zone<font color="#FF0000">*</font></td>
      		<td><?php if(isset($zone_name )){echo $zone_name;} ?></td>
      	</tr>
       
		<tr >
      		<td>Status<font color="#FF0000">*</font></td>
      		<td><?php if($worker_status==1){echo '<font class="btn btn-sm bg-green">Active</font>';}else{ echo '<font class="btn btn-sm bg-red">Inactive</font>';} ?></td>
      	</tr>

	  </table>
  		 
 		
<!--          </div>
            </div>
-->			 </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        