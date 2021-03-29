<script>
$(document).ready(function() {
        window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    });

</script>
<script>
//var i=1;
$(document).ready(function(){
    $("#printpass").click(function(){
	var strVal = $("#hidbookid").val();
	$("#printpass").hide();
	$("#showhome").show();
	var url = "<?php echo $site_url?>/Manual_dredging/Master/generatepass/"+strVal;
	$(location).attr('href',url);
	//var parseInt(i)+1;;
    });
});
</script>
<section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > 
         <strong>Sand Booking</strong></button>
      </h1>
</section>
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
        <div class="col-md-9">
          <!-- /.box -->
        <div class="box" >
        <?php if(isset($suc)){ 
		
		?>
		   	<div class="alert alert-success text-center"><?php echo $suc;?> </div>
          <?php    
		   }?>
      <!--      </div> -->
		  
            
        <div class="box box-primary box-blue-bottom">
            <div class="box-header ">
              <h3 class="box-title"><strong>Vehicle Pass details</strong></a> added Successfully..... </h3>
            </div>
           
            <table id="vacbtable" class="table table-bordered table-striped">
			
            <tr>
            <td><i>Requested Amount in Tons</i></td><td><strong><?php echo $data_vehiclepass[0]['customer_booking_request_ton'];?></strong></td>
            </tr>
            <tr>
            <td><i>Priority No</i></td><td><strong><?php echo $data_vehiclepass[0]['customer_booking_priority_number'];?></strong></td>
            </tr>
            <tr>
            <td><i>Token No</i></td><td><strong><?php echo $data_vehiclepass[0]['customer_booking_token_number'];?></strong></td>
            </tr>
			 <tr>
            <td><i>Booked Date</i></td><td><strong><?php echo strtoupper(date("d-m-Y",strtotime(str_replace('-', '/',$data_vehiclepass[0]['customer_booking_requested_timestamp']))));?></strong></td><input type="hidden" id="hidbookid" name="hidbookid" value="<?php echo encode_url($data_vehiclepass[0]['customer_booking_id']);?>" />
            </tr>
            </table>
			
		
            <br>
			 <center><button class="btn btn-sm bg-blue btn-flat" type="button" id="printpass">  &nbsp; Print PASS </button>
           </center>
           <div id="showhome" style="display:none"><a href="<?php echo site_url("Manual_dredging/Master/sand_issue")?>"><button class="btn btn-sm bg-blue btn-flat" type="button" id="printpass"> Go Back To Sand Issue</button></a></div>
           <p>&nbsp;</p>
<!--          </div>
            </div>
-->			 </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->
  </section>