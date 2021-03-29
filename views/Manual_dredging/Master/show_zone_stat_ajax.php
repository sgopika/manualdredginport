
<br/>
           <table id="example" class="table table-bordered table-striped">
                <thead>
                    <tr><td><table><tr><td>Permit Approved Quantity per Month <strong> <?php echo $tot_sand; ?> Tons</strong></td></tr></table></td></tr>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th>Date</th>
                  <th id="col_name">Allowed Quantity</th>
                  <th>Booked Quantity</th>
                  <th>Reserve Day</th>
                  <th>Spot Booking</th>
                  <th>Balance Quantity</th>
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				$allegation=array();
				 $i=1; 
				// $balance_sand=$bal_sand;
				 foreach($daily_det as $rowmodule){
					//$sat=0;
					 //$id = $rowmodule['customer_booking_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
                        <td><?php echo $rowmodule['daily_log_date']; ?></td>
                        <td><?php echo $rowmodule['daily_log_total']; ?></td>
                        <td><?php echo $rowmodule['daily_log_booked']; ?></td>
                        <td><?php echo $rowmodule['dailylog_reserve']; ?></td>
                        <td><?php echo $rowmodule['dailylog_spot']; ?></td>
                        <td><?php echo $rowmodule['daily_log_balance']; ?></td>	
					</tr>
					<?php
					$i++; 
				}
                //echo form_close(); ?>
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