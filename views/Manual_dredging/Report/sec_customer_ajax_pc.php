             <?php echo form_open('Port/movetoresrve');?>
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  
                  <th>Customer Name</th>
                  <th>Booked Date</th>
                  <th>Requested Amount in Tons</th>
                  <th>Token No</th>
                  <th>Chellan Amount</th>
                  <th>Amount Paid </th>
                  <th>Alotted Date</th>
                  <th>Approve</th>
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				$allegation=array();
				 $i=1; 
				 $balance_sand=$bal_sand;
				 foreach($cust_book_his as $rowmodule){
					 $sat=0;
					 $id = $rowmodule['customer_booking_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
                       
                        <td><?php echo strtoupper($rowmodule['customer_name']); ?></td>
                        <td>
                        <?php echo strtoupper($rowmodule['customer_booking_requested_timestamp']);?>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_booking_request_ton']);?></div>
                        </div>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_booking_token_number']);?></div>
                        </div>
                        </td>
						
                                <td><?php echo  $rowmodule['challan_amount'] ?></td>
								<td><?php echo  $rowmodule['transaction_amount'] ?></td>
								
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper(date("d-m-Y",strtotime(str_replace('-', '/',$rowmodule['customer_booking_allotted_date']))));?></div>
                        </div>
                        </td>
                         <?php 
                        if($rowmodule['customer_booking_request_status']==1){$url='#';}else{ $url= $site_url.'/Manual_dredging/Report/pc_approve_secbooked_request/'.encode_url($id);}
                        ?>
                         <td> <a href="<?php echo $url; ?>">  <button name="edit_allegation_btn_<?php echo $i;?>" id="edit_allegation_btn_<?php echo $i;?>" class="btn btn-sm btn-info btn-flat" type="button" <?php if($rowmodule['customer_booking_request_status']==1){ ?> disabled="disabled" <?php }?> >   <i class="fa fa-fw  fa-pencil"></i> &nbsp;Approve </button> </a></td>
					</tr>
					<?php
					$i++; 
				}
                //echo form_close(); ?>
                </tbody>
               
              </table>
             
            <?php
			echo form_close();
			?>
			<script>
  $(function () {
    $('#example').DataTable({
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