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
				//alert("asdasd");
					var custaadhar=$('#txtcutomeraadhar').val();
					$.post("<?php echo $site_url?>/Master/getcustomerdetails_ajax/",{custaadhar:custaadhar},function(data)
						{
						//alert(data);exit();
						
							$('#showbuk').html(data);
						});
				});
				
				
				
});


//---------------------------------------not added in hari copy ---------------------16/06/2017------------------------------------------- 



</script>
 <!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" >Customer Registration Request Processing</button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>">Master</a></li>
        <li><a href="#"><strong>Customer Registration Request Processing</strong></a></li>
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
       		echo form_open("Master/customer_requestprocessing", $attributes);
		} else {
			echo form_open("Master/customer_requestprocessing", $attributes);
		}*/?>
            
            <div class="box-body">
			<table class="table table-bordered table-striped">
          <tr>
          	<td>Customer Aadhar Number / Registration Number</td>
          	<td>
            <input type="text" name="txtcutomeraadhar"  id="txtcutomeraadhar" />
            </td>
           </tr>
          <tr><td colspan="2"><center><button id="show_buk" class="btn btn-success">Submit</button></center></td></tr>
          </table>
		   <div id="showbuk"></div>
              
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