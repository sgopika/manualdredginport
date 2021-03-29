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
					var tokenno=$('#tokenno').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Report/getbookingdetails_ajax_new/",{tokenno:tokenno},function(data)
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
				url : "<?php echo site_url('Manual_dredging/Master/status_userposting/')?>",
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
				url : "<?php echo site_url('Manual_dredging/Master/delete_userposting/')?>",
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

<div class="container-fluid ui-innerpage">
     <div class="row py-3">
        <div class="col-md-4">
         <button class="btn btn-primary btn-flat disabled" type="button" > 
		 Spot Booking Search</button>
		</div>

    <div class="col-12 d-flex justify-content-end">
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
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>"> Home</a></li>
         <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Report/spot"); ?>"> Spot</a></li>
       
        <li class="breadcrumb-item"><a href="#"><strong> Spot Booking Search </strong></a></li>
      </ol>
    </div>
    <!-- Main content -->
    
        <div class="col-md-12">
          <!-- /.box -->
        
        <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
      </div> <!-- end of co12 -->
		</div> <!-- end of row -->  


			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "customer_login", "name" => "customer_login" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Manual_dredging/Master/customer_login_add", $attributes);
		} else {
			echo form_open("Manual_dredging/Master/customer_login_add", $attributes);
		}?>
            <?php /*?><div class="box-header" id="view_designation">
              <a href="<?php echo $site_url.'/Master/customer_login_add';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Add Customer Login Details</button>
              </a>
            </div><?php */?>
           <p>&nbsp;</p>
           <p>&nbsp;</p>
           
           
            <div class="row p-3">
                <div class="col-md-6 d-flex justify-content-center px-2">
                    Transaction No/Order No
               </div>
           <div class="col-md-4 d-flex justify-content-start px-2">
                    <input type="text" name="tokenno" id="tokenno" class="form-control"  />
               </div>
		</div> <!-- end of row -->
           <div class="row p-3">
           <div class="col-md-12 d-flex justify-content-center px-2">
            <center><input class="btn btn-success" type="button" id="search" value="Search" /></center>
                </div>
		</div> <!-- end of row -->
          
            <div class="row p-3">
              <div  class="col-md-12 d-flex justify-content-center px-2" id="showres"></div>
            </div>
           
 </div> <!-- end of container -->          