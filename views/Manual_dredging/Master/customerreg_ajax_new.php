<table id="vacbtable_n" class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th id="col_name">Customer Name</th>
				    <th id="col_name">Mobile No</th>
                    <th>Username</th>
					  <th id="col_name">Permit Number</th>
					    <th id="col_name">Ton Needed</th>
						 <th id="col_name">Status</th>
                         <th>Remarks</th>
                         <th>Customer Details</th>
                         <th>Booking History</th>
						 <th>Resend Password</th>
                  			<!--<th>Status</th>-->
                  
                </tr>
                </thead>
                <tbody id="showbuk1">
                <?php
			
				 $i=1;
				  foreach($get_customerapproval as $rowmodule){
					 $id = $rowmodule['customer_registration_id'];
					?>
					
					<tr id="<?php echo $i;?>">
                    	<td>
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_name']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div><?php echo strtoupper($rowmodule['customer_phone_number']);?></div>
                        </td>
                        <td><?php echo strtoupper($rowmodule['user_master_name']);?></td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($rowmodule['customer_permit_number']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($rowmodule['customer_max_allotted_ton']);?></div>
                        </td>
						<td><b><?php if($rowmodule['customer_request_status']==1){ echo "Waiting for approval";} else if($rowmodule['customer_request_status']==2){ echo "Approved";} else{ echo "Rejected"; }?></b></td>
					
						<td><?php echo $rowmodule['customer_registration_remarks']; ?></td>
                        <td><a target="_new" href="<?php echo base_url();?>index.php/Manual_dredging/Report/customerregistration_dtview/<?php echo encode_url($rowmodule['customer_registration_id']);?>">Customer Details</a></td>
                        <td><?php if($rowmodule['customer_request_status']==2){ ?><a target="_new" href="<?php echo base_url();?>index.php/Manual_dredging/Report/view_customer_info/<?php echo encode_url($rowmodule['customer_public_user_id']);?>">View More</a><?php } else if($rowmodule['customer_request_status']==3) {?>
                        <a target="_new" href="<?php echo site_url("Manual_dredging/Master/down_my_file");?>/<?php echo $rowmodule['aadhar_uploadname']; ?>">Adhaar</a>&nbsp; 
                        <a href="<?php echo site_url("Manual_dredging/Master/down_my_file");?>/<?php echo $rowmodule['permit_uploadname']; ?>">Permit/Tax</a> <?php } else { echo "N/A";}?></td>
						<td><?php if($rowmodule['customer_used_ton']==0 && $rowmodule['customer_request_status']==2){?><a target="_new" href="<?php echo base_url();?>index.php/Manual_dredging/Report/resend_view/<?php echo encode_url($rowmodule['customer_registration_id']);?>"><input class="btn btn-success" type="button" id="search" value="Send" /></a><?php }?></td>
					</tr>
					<?php
					$i++; 
				}
               // echo form_close(); ?>
                </tbody>
               
              </table>
             
			   <script>
  $(function () {
    $('#vacbtable_n').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "sScrollX": "960px",
	  "columnDefs": [
	  {
		  "targets": [-1, 0],
		  "searchable": false
	  },{
      "targets": [0],
      "width": "50px"
    },
	{
"targets": [-3],
"width": "120px"
    },{
"targets": [-1, -2, -3, 0],
"sortable": false
    }
	  ]
    });
  });
</script>﻿