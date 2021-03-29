         <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th>Customer Name</th>
                  <th>Phone No</th>
                  <th>Booked Date</th>
                  <th>Sand Quantity</th>
				  <th>Challan Amount</th>
                  <th>Token No</th>
                  <th>Priority No</th>
                  <th>Alotted Date</th>
                  <th>Status</th>               
                  </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				$allegation=array();
				 $i=1; 
				 foreach($cust_book_his as $rowmodule){
					 $sat=0;
					 $id = $rowmodule['customer_booking_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td > <?php echo $i; ?> </td>
                        <td><?php echo strtoupper($rowmodule['customer_name']);?></td>
                        <td><?php echo $rowmodule['customer_phone_number'];  ?></td>
                        <td>
                        <?php echo date("d/m/Y h:i:s", strtotime(str_replace('-', '/',$rowmodule['customer_booking_requested_timestamp'] )));
//echo strtoupper($rowmodule['customer_booking_requested_timestamp']);
?>
                        </td>
                        <td  >
                       <?php echo strtoupper($rowmodule['customer_booking_request_ton']);?>
                      
                        </td>
						<td><?php echo $rowmodule['customer_booking_chalan_amount'];?></td>
                        <td><?php echo strtoupper($rowmodule['customer_booking_token_number']);?>
                        </td>
                        <td><?php echo strtoupper($rowmodule['customer_booking_priority_number']);?></td>
						<td><?php echo strtoupper($rowmodule['customer_booking_allotted_date']);?>
                        </td>
                        <td>
						<?php 
							if ($rowmodule['customer_booking_decission_status']==0) {
								?>
								 <button class="btn btn-sm btn-success btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp;&nbsp; Waiting For Approval &nbsp;&nbsp; </button> 
								<?php
							}
							else if($rowmodule['customer_booking_decission_status']==2)
							{
								$curd=date('Y-m-d');
								if(($rowmodule['customer_booking_allotted_date']<$curd)&&($rowmodule['customer_booking_pass_issue_user']==''))
								{
									$sat=1;
									?>
                                     <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Sand Not Taken </button> 
                                    <?php
								}
								else if($rowmodule['customer_booking_pass_issue_user']!=0)
								{
									$sat=1;
									?>
								 <button class="btn btn-sm btn-success btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp; Sand Issued </button> 
								<?php
								}
								else
								{
								?>
							 <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp; Approved </button> 
								<?php
								}
							} ?>
                            </td>
					</tr>
					<?php
					$i++; 
				}
                echo form_close(); ?>
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