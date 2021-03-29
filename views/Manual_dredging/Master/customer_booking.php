
<!-- Page specific script starts here -->
<script type="text/javascript" language="javascript">

function toggle_status(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Master/status_userposting/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}

function del_userposing(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Master/delete_userposting/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}

</script>
 <!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" >Customer Login</button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>">Master</a></li>
        <li><a href="#"><strong>Customer Booking Details</strong></a></li>
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
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "customer_booking", "name" => "customer_booking" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Manual_dredging/Master/customer_booking_add", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/customer_booking_add", $attributes);
		}?>
            <div class="box-header" id="view_designation">
              <a href="<?php echo $site_url.'/Master/customer_booking_add';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Add Customer Booking Details</button>
              </a>
            </div>
            <div class="box-body">
              <table id="vacbtable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Customer Name</th>
                    <th id="col_name">Aadhar Number</th>
					  <th id="col_name">Permit Number</th>
					    <th id="col_name">Ton Needed</th> 
						<th>View</th>
						 <th>Add Booking</th>
                  			
                 
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				 $i=1; foreach($customerreg_booking as $rowmodule){
					 $id = $rowmodule['customer_registration_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_name']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div><?php echo strtoupper($rowmodule['customer_aadhar_number']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($rowmodule['customer_permit_number']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($rowmodule['customer_max_allotted_ton']);?></div>
                        </td>
							<?php /*?>if ($rowmodule['customer_registration_id']==1) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button" onClick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['customer_registration_id'];?>);"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else {
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button" onClick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['customer_registration_id'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
								<?php
							} ?><?php */?>
							<td>  <a href="<?php echo $site_url.'/Master/customerregistration_view/'.encode_url($id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; View  </button></a> </td>
							
							<td>  <a href="<?php echo $site_url.'/Master/customer_booking_add/'.encode_url($id);?>"><button class="btn btn-sm bg-green btn-flat" type="button">  &nbsp; Add Booking  </button></a> </td>
						<?php /*?><td id="td_div_<?php echo $i;?>"> 
                        <div id="edit_div_<?php echo $i;?>">
                        <a href="<?php echo $site_url.'/Master/customer_booking_add/'.encode_url($id);?>"> <button name="edit_designation_btn_<?php echo $i;?>" id="edit_designation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button">  <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit  </button> 	</a> 					
                        </div>
                       
                        </td><?php */?>
						
					</tr>
					<?php
					$i++; 
				}
                echo form_close(); ?>
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->
  </section>
<!-- /.content -->