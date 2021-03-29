<script>
$(document).ready(function() {
        window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    });
</script>
<script>
function getprint()
{
	window.print();
	window.location="<?php echo site_url('Master/dashboard');?>";
}
</script>
<!-------------------------------------------------------------------------------->
 <div class="container-fluid ui-innerpage">
 
<div class="row py-1">
	<div class="col-4 breaddiv">
		<span class="badge bg-darkmagenta innertitle mt-2">Work Done</span>
	</div>  <!-- end of col4 -->
	
	<div class="col-8 d-flex justify-content-end">
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/pcdredginghome"); ?>"> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Report/report"); ?>"> Reports</a></li>
          <li class="breadcrumb-item"><a href="#"><strong>Work Done </strong></a></li>
      </ol>
</div> <!-- end of col-8 -->

</div> <!-- end of row -->
 <!-- end of settings row -->
 <!-------------------------------------------------------------------------------->
 <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 

<div class="row py-3" id="view_vesselcategory">
		<div class="col-12">
<?php $currentdate=date('d-m-Y');?>
              <h3 class="box-title"><strong>Details done  <?php echo $currentdate;  ?></strong></a></h3>
            </div>
           </div>
         <div class="row">
		<div class="col-12">
		<!-- ///////////////////////// start of table column //////////////////////---- -->
		<table id="example" class="table table-bordered table-striped table-hover">
			<tr>
				<td>Number of Customer Registered </td><td><?php foreach ($cus_bal as $status){echo $status['cntreg'];} ?></td></tr>
           <td>Number of Registration Approved </td><td><?php foreach ($cus_baltwo as $statustwo)
{
	$cntregtwo= $statustwo['cntregtwo'];
	$userid=$statustwo['customer_decission_user_id'];
	$userdet=$this->db->query("select user_master_name from user_master where user_master_id='$userid' and user_master_status=1");
	$user_det=$userdet->result_array();
	
	//while($user_det=$userdet->result_array())
	//{
		$name=$user_det[0]["user_master_name"];
		echo $name."-> ".$cntregtwo;
	echo "<br>";
	//}
	
} ?></td></tr>
              </table>
		
              <!-- ----------------------------------------------------- end of table column ------------------------------------- -->
              </div> <!-- end of table col10 -->
               <!-- end of col2 -->
	</div>
  
  
   
   </div> <!-- ui innerpage closed-->
   