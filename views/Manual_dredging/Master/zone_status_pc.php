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
					var period=$('#periodc').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Port/get_zone_bal/",{zone_id:zone_id,period:period},function(data)
						{
							$('#showbuk').html(data);
						});
				});
				
				
				
});


//---------------------------------------not added in hari copy ---------------------16/06/2017------------------------------------------- 



</script>
<!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Zone Status</span>
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
        <li class="breadcrumb-item"><a href="#"><strong>Zone Status</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
<div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
              <h3 class="box-title"><strong>Customer Booking</strong>&nbsp;&nbsp;<a href="<?php echo site_url(); ?>/Manual_dredging/Report/get_zone_allot">Get Zone Allotment</a></h3>
            </div>
</div>
             <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "customer_bookingapproval", "name" => "customer_bookingapproval" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		?>
          <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Select Zone
           </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
            <select id="zoneid" name="zoneid" class="form-control" >
                <option value="">--Select--</option>
                <?php foreach($zone as $rowzone){ ?>
                <option value="<?php echo $rowzone['zone_id']; ?>" ><?php echo $rowzone['zone_name']; ?></option>
                <?php } ?>
            </select>
            </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Permit Period
           </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
           <select name="periodc" id="periodc" class="form-control">
                <option selected="selected" value="">select</option>
                <?php foreach($permit as $p)
				{
					?>
                <option value="<?php echo $p['monthly_permit_period_name'];?>"><?php echo $p['monthly_permit_period_name'];?></option>
                <?php
				}
				?>
                </select>
           </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-12 d-flex justify-content-center px-2">
               <center><button id="show_buk" class="btn btn-success">Submit</button></center>
          </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-12 d-flex justify-content-center px-2" id="showbuk">
          </div>
          
           
          </div>
    </div>