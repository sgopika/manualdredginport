
<?php
$flag=0;
				 $i=1; 
foreach($get_bookingapproval as $rowmodule){
					 $id = $rowmodule['customer_booking_id'];
					 $regid=$rowmodule['customer_booking_registration_id'];
					?>
					
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
                        <div ><?php echo strtoupper($rowmodule['customer_booking_request_ton']);?></div>
                        </td>
						
							<?php /*?>if ($rowmodule['customer_booking_id']==1) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button" onClick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['customer_booking_id'];?>);"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else {
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button" onClick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['customer_booking_id'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
								<?php
							} ?><?php */?>
							<!--<td>  <a href="<?php echo $site_url.'/Manual_dredging/Master/customerregistration_view/'.encode_url($regid);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; View  </button></a> </td>-->
						<td id="td_div_<?php echo $i;?>"> 
                        <div id="edit_div_<?php echo $i;?>">
                        <a href="<?php echo $site_url.'/Manual_dredging/Master/customer_bookingapproval_add/'.encode_url($id);?>"> <button <?php if($flag==1){ ?> disabled="disabled" <?php } ?> name="edit_designation_btn_<?php echo $i;?>" id="edit_designation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" <?php if($rowmodule['customer_booking_decission_status']==0){$flag=1;}?> >  <i class="fa fa-fw  fa-pencil"></i> &nbsp; Approval  </button> 	</a> 					
                        </div>
                       
                        </td>
						
					
<?php
$i++; 
}
?>