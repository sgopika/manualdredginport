               
                <table id="vacbtable_u" class="table table-bordered table-striped">

                <thead>

                <tr>

                  <th id="sl">Sl.No</th>

                  <th>Customer Name</th>

                  <th>Mobile No</th>

				   <th>Preferred Zone</th>

				   <th>Booked Date(Type)</th>

                  <th>Requested Ton</th>

	                 <th>Allotted Date</th>

                 
					<th>Token</th>
                  
				<th>Lorry Type</th>
                  

                  <th>Status</th>

                </tr>

                </thead>

                <tbody>

                <?php

				//print_r($data);

				$allegation=array();

				 $i=1; 

				 foreach($spot as $rowmodule){

					 $sat=0;

					 $id = $rowmodule['spotreg_id'];
					  $lorrytype=$rowmodule['lorry_type'];
 if($lorrytype==1){$lorryname='Kadavu lorry';}else if($lorrytype==2){$lorryname='Other lorry';}else{$lorryname='';}
					?>

					<tr id="<?php echo $i;?>">

						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>

                       	<td><?php  echo $rowmodule['spot_cusname']; ?></td>

                        <td><?php  echo $rowmodule['spot_phone']; ?></td>

						 <td><?php foreach($zone as $zonename){if($zonename['zone_id']==$rowmodule['preferred_zone']){ echo $zonename['zone_name'];} }?></td>

						  <td><?php  echo date("d/m/Y", strtotime(str_replace('-', '/',$rowmodule['spot_timestamp'] )));?><br/> <?php if($rowmodule['spot_booking_type']==1){echo  "(Spot)";}else if($rowmodule['spot_booking_type']==2){?> <font color="#2C0DF3" style="font-weight: bold;" ><?php echo "(Door)";?></font><?php } ?></td>

						 

                        <td><?php  echo $rowmodule['spot_ton']; ?></td>

                        <td><?php  if($rowmodule['spot_alloted']==""){ echo "0000-00-00";}else {echo date("d/m/Y", strtotime(str_replace('-', '/',$rowmodule['spot_alloted'] ))); } ?></td>

                        
							<td><?php  echo $rowmodule['spot_token']; ?></td>
                        
 						<td><?php  echo $lorryname; ?></td>
                        
<td>
                        <?php 

							if ($rowmodule['payment_status']==1)

							 {

								if($rowmodule['print_status']==1)

								{

								?>

                                 <button class="btn btn-sm btn-danger btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Sand Issued &nbsp;&nbsp; </button> 

                                <?php	

								}

								else

								{

								?>
				 <button class="btn btn-sm btn-success btn-flat" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Paid &nbsp;&nbsp; </button>

							<?php

								}

							}

							else {

								?>

								 <button class="btn btn-sm btn-info btn-flat" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Pending  </button> 

								<?php

							} ?>
</td>
					</tr>

					<?php

					$i++; 

				}

                echo form_close(); ?>

                </tbody>

               

              </table>

              <script>

  $(function () {

    $('#vacbtable_u').DataTable({

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