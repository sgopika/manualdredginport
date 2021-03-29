              <table id="vacbtable_d" class="table table-bordered table-striped">

                <thead>

                <tr>

                  <th id="sl">Sl.No</th>

                  <th>Customer Name</th>

                  <th>Quantity of sand in Tons</th>

                  <th>Customer Mobile No</th>

                  <th>Unloading place</th>

                  <th>Lorry Reg No</th>

                       <th>Driver License No</th>
                       <th>Driver Mobile No</th>
                  <th>Pass Issue Time</th>

                </tr>

                </thead>

                <tbody>

                <?php

				//print_r($data);

				$allegation=array();

				 $i=1; 

				 foreach($t_sandpass as $rowmodule){

					 $sat=0;

					 $id = $rowmodule['customer_booking_id'];

					?>

					<tr id="<?php echo $i;?>">

						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>

                        <td id="col_div_<?php echo $i; ?>">

                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_name']);?></div>

                        <td id="col_div_<?php echo $i; ?>">

                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_booking_request_ton']);?></div>

                        </div>

                        </td>

                        <td id="col_div_<?php echo $i; ?>">

                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_phone_number']);?></div>

                        </div>

                        </td>

                        <td><?php echo strtoupper($rowmodule['customer_unloading_place']);?></td>

                        <td><?php echo strtoupper($rowmodule['customer_booking_vehicle_registration_number']);?></td>

                         <td><?php echo strtoupper($rowmodule['customer_booking_driver_license']);?></td>
                          <td><?php echo strtoupper($rowmodule['customer_booking_driver_mobile']);?></td>
 					<td><?php echo strtoupper($rowmodule['customer_booking_pass_issue_timestamp']);?></td>
					</tr>

					<?php

					$i++; 

				}

                echo form_close(); ?>

                </tbody>

               

              </table>

              <script>

  $(function () {

    $('#vacbtable_d').DataTable({

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