<section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > 
         <strong>Sand Booking </strong> </button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
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
              <h3 class="box-title"><strong>Vehicle Details added Successfully</strong></a></h3>
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
            <td><i>Allotted Date</i></td><td><strong><?php echo strtoupper(date("d-m-Y",strtotime(str_replace('-', '/',$data_vehiclepass[0]['	customer_booking_allotted_date']))));?></strong></td>
            </tr>
            </table>
			
		
            <br>
			 <center><a href="<?php echo $site_url.'/Master/generatepass/'.encode_url($data_vehiclepass[0]['customer_booking_id']);?>"><button class="btn btn-sm bg-blue btn-flat" type="button">  &nbsp; Print PASS </button></a>
           </center>
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