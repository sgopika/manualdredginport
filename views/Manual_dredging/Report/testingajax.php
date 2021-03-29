   <table id="vacbtable_n" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Customer Name</th>
				    <th id="col_name">Phone Number</th>
                  
                    <th>Booking TimeStamp</th>
					  <th id="col_name">Permit Number</th>
					    <th id="col_name">Ton Needed</th>
						<!-- <th id="col_name">View</th>-->
                  			<th>Status</th>
                  
                </tr>
                </thead>
                 <tbody id="showbuk1">
                <?php
			

				 $i=1;
				   foreach($get_customerapproval as $rowmodule){
					 $id = $rowmodule['customer_registration_id'];
					  
					 
					?>
					
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_name']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div><?php echo strtoupper($rowmodule['customer_phone_number']);?></div>
                        </td>
                        
                        <td id="col_div_<?php echo $i; ?>">
                        <div><?php echo $rowmodule['customer_registration_timestamp'];  ?>
					</div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($rowmodule['customer_permit_number']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($rowmodule['customer_max_allotted_ton']);?></div>
                        </td>
						 <td> 
					<?php
					 
					  $regdate=$rowmodule['customer_registration_timestamp'];
					$approvecheck_details= $this->Reports_model->get_approvaldet($portid,$regdate);
					  
						  $val=count($approvecheck_details);
					  if($val==0)
					  {
							?>
						 <a href="<?php echo $site_url.'/Report/seccustomerregistration_view/'.encode_url($id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; View & Approve </button></a> </td>
					<?php /*?><td>  <a href="<?php echo $site_url.'/Master/customer_requestprocessing_add/'.encode_url($id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; Approve </button></a> </td><?php */?>
						
						<?php } else {echo "In Queue";}?></td> 
					</tr>
					<?php
					$i++; 
				}
            // echo form_close(); 
					?>
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
</script>