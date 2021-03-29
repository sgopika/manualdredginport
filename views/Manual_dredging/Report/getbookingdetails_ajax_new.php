<table id="vacbtable_n" class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th id="col_name">Customer Name</th>   
                  <th id="col_name">Token No</th>
				    <th id="col_name">Mobile No</th>
                  	  <th id="col_name">Transaction/Order No</th>
                   	  <th id="col_name">Alloted Date</th>
					    <th id="col_name">Booking Status</th>
					    <th id="col_name">Duplicate Pass</th>
						
                  			<!--<th>Status</th>-->
                  
                </tr>
                </thead>
                <tbody >
                <?php
			
				 $i=1;
				  foreach($get_customerapproval as $rowmodule){
					 $id = $rowmodule['spotreg_id'];
					  $bkid=encode_url($rowmodule['spot_token']);
					  
					?>
					
					<tr id="<?php echo $i;?>">
                    <td>
                    <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['spot_cusname']);?></div>
                    </td>
                    <td>
                    <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['spot_token']);?></div>
                    </td>
                    
                    <td id="col_div_<?php echo $i; ?>">
                   <div><?php echo strtoupper($rowmodule['spot_phone']);?></div>
                    </td>
                    <td id="col_div_<?php echo $i; ?>">
                        <div><?php echo strtoupper($rowmodule['transaction_id']);?></div>
                        </td>
                    
					<td id="col_div_<?php echo $i; ?>">
                   <div><?php if($rowmodule['spot_alloted']=="0000-00-00"){ echo "----------";}else{ echo strtoupper(date("d-m-Y",strtotime(str_replace('-', '/',$rowmodule['spot_alloted']))));} ?></div>
                    </td>
                    
                   			
						<td><b style="color: #158A08"><?php if($rowmodule['print_status']==1 ){ echo "Sand Taken";} else{ echo "Sand Not Taken"; }?></b></td>
	                
                        <td id="col_div_<?php echo $i; ?>"><?php if($rowmodule['print_status']==1 ){ ?>
                   <div><a href="<?php echo site_url("Manual_dredging/Report/generatepass_duplicate/$bkid");?>">Download</a></div> <?php } ?>
                    </td>
						
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