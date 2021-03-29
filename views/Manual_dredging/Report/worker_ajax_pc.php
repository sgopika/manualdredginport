             <?php echo form_open('Port/movetoresrve');?>
             <a href="<?php echo base_url("index.php/Manual_dredging/Report/worker_report/");?><?php echo encode_url($zoneid);?>" target="_new"><font color="#FF0000" size="+1">Download Report</font></a>
            <br>
             <p>&nbsp;</p>
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  
                  <th>Worker Name</th>
                  <th>Phone</th>
                  
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				$allegation=array();
				 $i=1; 
				 
				 foreach($reg_worker_list as $rowmodule){
					 $sat=0;
					 $id = $rowmodule['worker_registration_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
                       
                        <td><?php echo strtoupper($rowmodule['worker_registration_name']); ?></td>
                        <td>
                        <?php echo strtoupper($rowmodule['worker_registration_phone_number']);?>
                        </td>
                     	</tr>
					<?php
					$i++; 
				}
                //echo form_close(); ?>
                </tbody>
               
              </table>
             
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