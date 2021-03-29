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
<script type="text/javascript">
$(document).ready(function()
{
	$('#search').click(function()
				{
				//alert("asdasd");
					var custaadhar=$('#regid').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getcustomerdetails_ajax_new/",{custaadhar:custaadhar},function(data)
						{
						//alert(data);exit();
						//alert(data);
							$('#showres').html(data);
						});
				});
				
				
				
});


//---------------------------------------not added in hari copy ---------------------16/06/2017------------------------------------------- 



</script>
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
		<span class="badge bg-darkmagenta innertitle mt-2">Registered Customer</span>
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
        <li class="breadcrumb-item"><a href="#"><strong>Registered Customer</strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
     <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
  
             <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "customer_login", "name" => "customer_login" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Manual_dredging/Master/customer_login_add", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/customer_login_add", $attributes);
		}?>
           <div class="row p-3">
           <div class="col-md-6 d-flex justify-content-center px-2">Aadhar No/Registration ID'
           </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
               <input type="text" name="regid" id="regid" class="form-control"  />
          </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-12 d-flex justify-content-center px-2">
            <center><input class="btn btn-success" type="button" id="search" value="Search" /></center>
           </div>
           </div>
            
            <div class="row p-3">
           <div class="col-md-12 d-flex justify-content-center px-2" id="showres">
              </div>
            </div>
           </div>