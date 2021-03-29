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
                <li><a href="<?php echo site_url("Master/userposting"); ?>">User Posting</a></li>
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
