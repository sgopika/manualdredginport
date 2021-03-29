
                <!-- <table id="example" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Customer Name</th>
                  <th >Phone Number</th>
				  <th >Permit Number</th>
				  <th >Ton Needed</th>
                  <th >Booked Date</th>
				  
                  <th id="th_div"> Approve</th>
                 
                </tr>
                </thead>
                <tbody id="showbuk1">-->
                <?php
				//echo '<pre>';print_r($get_bookingapproval);
				$flag=0;
				 $i=1; 
				 foreach($get_bookingapproval as $rowmodule){
					 $id = $rowmodule['customer_booking_id'];
					 $regid=$rowmodule['customer_booking_registration_id'];
					?>
					<tr id="demo">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_name']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div><?php echo strtoupper($rowmodule['customer_phone_number']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($rowmodule['customer_permit_number']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($rowmodule['customer_booking_request_ton']);?></div>
                        </td>
						<td>
                        <?php echo date("d/m/Y h:i:s", strtotime(str_replace('-', '/',$rowmodule['customer_booking_requested_timestamp'] )));
							//echo $rowmodule['customer_booking_requested_timestamp'];	
						?>
                        </td>
						<td id="td_div_<?php echo $i;?>"> 
                        <div id="edit_div_<?php echo $i;?>">
                        <a href="<?php if($flag==1){}else{ echo $site_url.'/Manual_dredging/Master/customer_bookingapproval_add/'.encode_url($id); }?>"> <button <?php if($flag==1){ ?> disabled="disabled" <?php } ?> name="edit_designation_btn_<?php echo $i;?>" id="edit_designation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" <?php if($rowmodule['customer_booking_decission_status']==0){$flag=1;}?> >  <i class="fa fa-fw  fa-pencil"></i> &nbsp; Approval  </button> 	</a> 					
                        </div>
                       
                        </td>
						
					</tr>
					<?php
					$i++; 
				}
                 ?>
                 <!-- </tbody>
               
              </table> -->
             