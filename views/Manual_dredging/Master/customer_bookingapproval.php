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
<script type="text/javascript">
$(document).ready(function()
{

	$('#show_buk').click(function()
				{
					var zone_id=$('#zoneid').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getbookedzonedetails_ajax/",{zone_id:zone_id},function(data)
						{
						//alert(data);exit();
						
							$('#showbuk').html(data);
						});
				});
				
				
				
});


//---------------------------------------not added in hari copy ---------------------16/06/2017------------------------------------------- 

<?php
if(isset($pass_zoneid))
{
	?>
	$(document).ready(function()
	{
					var zone_id=<?php echo $pass_zoneid ?>;
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getbookedzonedetails_ajax/",{zone_id:zone_id},function(data)
						{
						//alert(data);exit();
						
							$('#showbuk').html(data);
						});
	});
	<?php
}
?>

</script>
<!-------------------------------------------------------------------------------->
 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Customer Booking Approval</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
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
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
          <li class="breadcrumb-item"><a href="#"><strong>Customer Booking Approval</strong></a></li>
      </ol>
</nav>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
 <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 

  <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "customer_bookingapproval", "name" => "customer_bookingapproval" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		?>

		
		
		
		<div class="row p-3">
			<div class="col-md-6 d-flex justify-content-center px-2">

			Select Zone
			</div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select id="zoneid" name="zoneid" class="form-control" >
			<option value="">--Select--</option>
		   	<?php foreach($get_zone_details as $rowzone)
			{ ?>
			<option value="<?php echo $rowzone['zone_id']; ?>" <?php if(isset($pass_zoneid))
{  if($pass_zoneid==$rowzone['zone_id']) { ?> selected <?php } } ?> > <?php echo $rowzone['zone_name']; ?> </option>
            <?php } ?>
            </select>
			 </div>
		</div> <!-- end of row -->
          <div class="row p-3">
           <div class="col-12 d-flex justify-content-center px-2">
			<center><button id="show_buk" class="btn btn-success">Submit</button></center>
			 </div>
		</div> <!-- end of row -->
		
		<div class="row">
		<div class="col-12">
		<!-- --------------------------------------------- start of table column ------------------------------------- -->
              <table id="example" class="table table-bordered table-striped">

		  <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Customer Name</th>
                  <th >Phone Number</th>
				  <th >Permit Number</th>
				  <th >Ton Needed</th>
                  <th >Booked Date</th>
				  <th id="th_div"> Approve</th>
                 
                </tr>
                </thead>
                <tbody id="showbuk"></tbody></table>
		</div></div>
		
          <!--<div class="row p-3" id="showbuk">
		  </div> ---->
          
 
   </div> <!-- ui innerpage closed-->         