<table id="vacbtable_d" class="table table-bordered table-striped">
                <thead>
                 <tr>
                  	<th id="sl">Sl No</th>
                    <th>Select</th>
        			<th>Customer Name</th>
        			<th>Mobile No</th>
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				 $id=1; 
				 foreach($buk_data as $sp)
				 {

					?>
					<tr id="<?php echo $id;?>">
					<td id="sl_div_<?php echo $id; ?>"><?php echo $id; ?></td>
                    <td><input type="checkbox" name="text_mob[]" value="<?php echo $sp['customer_phone_number']; ?>" /></td>    
    				<td><?php echo $sp['customer_name']; ?></td>
    				<td><?php echo $sp['customer_phone_number']; ?></td>
					</tr>
                  
					<?php
					$id++; 
				}
                ?>
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