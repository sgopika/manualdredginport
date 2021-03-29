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
					$.post("<?php echo $site_url?>/Manual_dredging/Report/getcustomerdetails_ajax/",{custaadhar:custaadhar},function(data)
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
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Second Registration View</span>
	</div>  <!-- end of col4 -->
		<?php 
	$sess_user_type			=	$this->session->userdata('int_usertype');
	 //echo "fff".$sess_user_type;
	if($sess_user_type==3)
	{ 
		$url=site_url("Manual_dredging/Master/pcdredginghome");
	 }
	  else
	   {
	    $url=site_url('Manual_dredging/Port/port_clerk_main');
	}
	?>
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="#"><strong>Second Registration View</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 

             <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "customer_requestprocessing", "name" => "customer_requestprocessing" , "novalidate");
		?>
            
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">
               Customer Aadhar Number / Registration Number
           </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <input type="text" name="txtcutomeraadhar"  id="txtcutomeraadhar" />
           </div>
           </div>
     <div class="row p-3">
           <div class="col-md-12 d-flex justify-content-center px-2">
     
          <center>
              <button type="button" id="show_buk" name="show_buk" class="btn btn-success">Submit</button></center>
           </div>
     </div>
    <div class="row p-3">
           <div class="col-12 d-flex justify-content-center px-2" id="showbuk">
          
              <table id="example" class="table table-bordered table-striped">
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
                  			<th>Status</th>
                  
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
						 <td> 
					<?php
					 
					  $regdate=$rowmodule['customer_registration_timestamp'];
					$approvecheck_details= $this->Reports_model->get_approvaldet($portid,$regdate);
					  
						  $val=count($approvecheck_details);
					  if($val==0)
					  {
							?>
						 <a href="<?php echo $site_url.'/Manual_dredging/Report/seccustomerregistration_view/'.encode_url($id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; View & Approve </button></a> </td>
					<?php /*?><td>  <a href="<?php echo $site_url.'/Master/customer_requestprocessing_add/'.encode_url($id);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; Approve </button></a> </td><?php */?>
						
						<?php } else {echo "In Queue";}?></td> 
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
    </div>                    