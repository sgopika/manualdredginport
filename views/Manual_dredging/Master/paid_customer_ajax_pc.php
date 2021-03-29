            <?php echo form_open('Manual_dredging/Port/movetoresrve');?>
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th>Select</th>
                  <th>Customer Name</th>
                  <th>Booked Date</th>
                  <th>Requested Amount in Tons</th>
                  <th>Token No</th>
                  <th>Chellan Amount</th>
                  <th>Amount Paid </th>
                  <th>Alotted Date</th>
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
                        <td>
                        <?php
						
						if($balance_sand >= $rowmodule['customer_booking_request_ton'])
						{
							$balance_sand=$balance_sand-$rowmodule['customer_booking_request_ton'];
						?>
                        <input type="checkbox" name="chk[]" checked="checked"  onclick="this.checked = true;" value="<?php echo $rowmodule['customer_booking_id']; ?>" />
                        <?php
						}
						?>
                        </td>
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
					</tr>
					<?php
					$i++; 
				}
                //echo form_close(); ?>
                </tbody>
               
              </table>
              <div>
              <center>
              <button class="btn btn-success">Move To Reserve Day</button>
              </center>
              </div>
            <?php
			echo form_close();
			?>
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