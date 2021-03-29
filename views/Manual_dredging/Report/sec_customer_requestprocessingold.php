<script>
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
</script>
<script type="text/javascript">
$(document).ready(function()
{

	$('#show_buk').click(function()
				{
				//alert("asdasd");
					var custaadhar=$('#txtcutomeraadhar').val();
					$.post("<?php echo $site_url?>/Report/getcustomerdetails_ajax/",{custaadhar:custaadhar},function(data)
						{
						//alert(data);//exit();
						
							$('#showbuk').html(data);
						});
				});
				
				
				
});


//---------------------------------------not added in hari copy ---------------------16/06/2017------------------------------------------- 



</script>
<!-- Page specific script starts here -->
<script type="text/javascript" language="javascript">

function toggle_status(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Master/status_userposting/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}

function del_userposing(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Master/delete_userposting/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}

</script>
 <!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" >Second Registration View</button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>">Master</a></li>
        <li><a href="#"><strong>Second Registration View</strong></a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
        <div class="col-md-9">
          <!-- /.box -->
          <div class="box" >
             <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "customer_requestprocessing", "name" => "customer_requestprocessing" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		/*if(isset($editres)){
       		echo form_open("Master/customer_requestprocessing_add", $attributes);
		} else {
			echo form_open("Master/customer_requestprocessing_add", $attributes);
		}*/?>
            
            <div class="box-body">
            <table class="table table-bordered table-striped">
          <tr>
          	<td>Customer Aadhar Number / Registration Number</td>
          	<td>
            <input type="text" name="txtcutomeraadhar"  id="txtcutomeraadhar" />
            </td>
           </tr>
          <tr><td colspan="2"><center><button type="button" id="show_buk" name="show_buk" class="btn btn-success">Submit</button></center></td></tr>
          </table>
          <div id="showbuk">
              <table id="vacbtable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Customer Name</th>
				    <th id="col_name">Phone Number</th>
                   <th>District Name</th>
                    <th>Booking TimeStamp</th>
					  <th id="col_name">Permit Number</th>
					    <th id="col_name">Ton Needed</th>
						<!-- <th id="col_name">View</th>-->
                  			<!--<th>Status</th>-->
                  
                </tr>
                </thead>
                <tbody>
                <?php
			

				 $i=1;
				  foreach($customerreg_details as $rowmodule){
					 $id = $rowmodule['customer_registration_id'];
					  
					 
					?>
					
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['customer_name']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div><?php echo strtoupper($rowmodule['customer_phone_number']);?></div>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div><?php echo strtoupper($rowmodule['district_name']);?></div>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div><?php echo $rowmodule['customer_registration_timestamp'];  ?>
					</div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($rowmodule['customer_permit_number']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div ><?php echo strtoupper($rowmodule['customer_max_allotted_ton']);?></div>
                        </td>
						<?php /*?><td> 
					<?php
					 
					  $regdate=$rowmodule['customer_registration_timestamp'];
					$approvecheck_details= $this->Reports_model->get_approvaldet($portid,$regdate);
					  
						  $val=count($approvecheck_details);
					  if($val==0)
					  {
							?>
						 <a href="<?php echo $site_url.'/Master/customerregistration_view/'.encode_url($id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; View & Approve </button></a> </td>
					<!--<td>  <a href="<?php echo $site_url.'/Master/customer_requestprocessing_add/'.encode_url($id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; Approve </button></a> </td>-->
						
						<?php } else {echo "In Queue";}?></td><?php */?>
					</tr>
					<?php
					$i++; 
				}
             echo form_close(); 
					?>
                </tbody>
               
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->
  </section>
<!-- /.content -->