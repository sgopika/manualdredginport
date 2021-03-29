<table id="vacbtable_n" class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th id="col_name">Customer Name</th>
                   <th id="col_name">Customer Registration No</th>
                  <th id="col_name">Token No</th>
				    <th id="col_name">Mobile No</th>
                   	  <th id="col_name">Alloted Date</th>
					    <th id="col_name">Booking Status</th>
						<th id="col_name">Duplicate Pass</th>
                  			<!--<th>Status</th>-->
                  
                </tr>
                </thead>
                <tbody id="showbuk1">
                <?php
			
				 $i=1;
				  foreach($get_customerapproval as $rowmodule){
					 $id = $rowmodule['customer_registration_id'];
            $bkid = encode_url($rowmodule['customer_booking_id']);
					  
					  
					?>
					
					<tr id="<?php echo $i;?>">
                    <td>
                    <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_name']);?></div>
                    </td>
                    <td>
                    <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_reg_no']);?></div>
                    </td>
                    
                    <td id="col_div_<?php echo $i; ?>">
                   <div><?php echo strtoupper($rowmodule['customer_booking_token_number']);?></div>
                    </td>
                    <td id="col_div_<?php echo $i; ?>">
                        <div><?php echo strtoupper($rowmodule['customer_phone_number']);?></div>
                        </td>
                    
					<td id="col_div_<?php echo $i; ?>">
                   <div><?php if($rowmodule['customer_booking_allotted_date']=="0000-00-00"){ echo "----------";}else{ echo strtoupper(date("d-m-Y",strtotime(str_replace('-', '/',$rowmodule['customer_booking_allotted_date']))));} ?></div>
                    </td>
                    
                   			
						<td><b><?php if($rowmodule['customer_request_status']==1){ echo "Waiting for approval";} else if($rowmodule['customer_request_status']==2){ echo "Approved";} else{ echo "Rejected"; }?></b>
              <br>
              <b style="color: #158A08"><?php if($rowmodule['customer_booking_pass_issue_user']!=0 ){ echo "Sand Taken";} else{ echo "Sand Not Taken"; }?></b>
            </td>
             <td id="col_div_<?php echo $i; ?>"><?php if($rowmodule['customer_booking_pass_issue_user']!=0 ){ ?>
                   <div><a href="<?php echo site_url("Manual_dredging/Master/generatepass_duplicate/$bkid");?>">Download</a></div> <?php } ?>
                    </td>
	                
                        
						
					</tr>
					<?php
					$i++; 
				}
               // echo form_close(); ?>
                </tbody>
               
              </table>
             <script type="text/javascript">
    $(document).ready(function() {
      $("#profile_div").show();
      $("#request_div").hide();

  /*  $('input').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
    });
*/
    $('#example').DataTable({
      "oLanguage": { "sSearch": "" } 
    });
    $('.dataTables_filter input[type="search"]').attr('placeholder','Search').css({});

    $('.dob').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
  });
  
$('#inspection_date').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
  });
  


    }); //Jquery End

      /*$('#inbox_link').click(function(){ 
      $("#profile_div").hide();
      $("#request_div").show();
      $("#inbox_link").addClass("list-group-item-primary");
      return false; });*/

      $('#profile_button').click(function(){ 
      $("#profile_div").show();
      $("#request_div").hide();
      
      $("#inbox_link").removeClass("list-group-item-primary");
      return false; });

      

     </script>