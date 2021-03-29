		 <?php 
        $attributes = array("class" => "form-horizontal", "id" => "instform", "name" => "instform");
        echo form_open("settings/index", $attributes);
		//print_r($data);
		?>
<div class="row custom-inner">
  <div class="col-md-6">
    <div class="box box-danger">
      <div class="box-header">
        <h3 class="box-title">Dashboard</h3>
      </div>
      <div class="box-body">
        <!-- Date dd/mm/yyyy -->
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"> </i> 
              <ul class="nav child_menu">
                <li><a href="<?php echo site_url("Master/material"); ?>">Material</a></li>
                <li><a href="<?php echo site_url("Master/material_rate"); ?>">Material Rate</a></li>
                <li><a href="<?php echo site_url("Master/taxname_master"); ?>">Tax Name</a></li>
                <li><a href="<?php echo site_url("Master/taxcalculator"); ?>">Tax Calculator</a></li>
                <li><a href="<?php echo site_url("Master/construction_master"); ?>">Construction Master</a></li>
                <li><a href="<?php echo site_url("Master/plintharea_master"); ?>">Plinth Area Calculator</a></li>
                <li><a href="<?php echo site_url("Master/cutoff_master"); ?>">Add Cutoff Date</a></li>
                 <li><a href="<?php echo site_url("Master/booking_master"); ?>">Add Booking Time</a></li>
                <li><a href="<?php echo site_url("Master/quantity_master"); ?>">Quantity Master</a></li>
                <li><a href="<?php echo site_url("Master/workerqty_master"); ?>">Worker Quantity</a></li>
                <li><a href="<?php echo site_url("Master/dregport_master"); ?>">Assign Dredging Port</a></li>
                <li><a href="<?php echo site_url("Master/portconserv_master"); ?>">Create Port Conservator</a></li>
                <li><a href="<?php echo site_url("Master/chart"); ?>">Chart</a></li>
                <li><a href="<?php echo site_url("Port/mailbox"); ?>">MailBox</a></li>
              </ul>
            </div>
          </div>
          <!-- /.input group -->
        </div>
        <!-- /.form group -->
        <!-- Date mm/dd/yyyy -->
        
        <!-- /.form group -->
        <!-- phone mask -->
       
        <!-- /.form group -->
        <!-- IP mask -->
       
        <!-- /.form group -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <!-- /.box -->
  </div>
  <!-- /.col (left) -->
  <!-- /.col (right) -->
</div>
