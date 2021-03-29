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
               <li><a href="<?php echo site_url("Master/zone"); ?>">Zone</a></li>
                <li><a href="<?php echo site_url("Master/lsgd"); ?>">LSGD</a></li>
                <li><a href="<?php echo site_url("Master/quantity_pc"); ?>">Quantity</a></li>
                <li><a href="<?php echo site_url("Master/bank"); ?>">Bank</a></li>
                <li><a href="<?php echo site_url("Master/assignzone"); ?>">Assign Zone to LSG</a></li>
                <li><a href="<?php echo site_url("Master/assignzone_sec"); ?>">Assign Zone to Section</a></li>
                <li><a href="<?php echo site_url("Master/canoeregistration"); ?>">Canoe Registration</a></li>
                <li><a href="<?php echo site_url("Master/monthlypermitapproval"); ?>">Monthly Permit Approval</a></li>
                <li><a href="<?php echo site_url("Master/holidaysettings"); ?>">Holiday Settings</a></li>
                <li><a href="<?php echo site_url("Master/customer_requestprocessing"); ?>">Customer Registration Process</a></li>	
                <li><a href="<?php echo site_url("Master/customer_bookingapproval"); ?>">Customer Booking Approve</a></li>	
                <li><a href="<?php echo site_url("Master/customer_login"); ?>">Customer Login Details</a></li>
                <li><a href="<?php echo site_url("Master/police_case_pc");?>">Police Case</a></li>
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
