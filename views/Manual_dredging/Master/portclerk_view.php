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
<script>
$(document).ready(function()
{
				$('#piebox').click(function()
				{
					//alert("hello");
					var port_id=$('#port').val();
					var period =$('#period').val();
					//var z_id =$('#zone').val();
					$.post("<?php echo $site_url?>/Port/Piechart/",{port_id:port_id,period:period},function(data)
						{
							//alert("hello");
							$('#showpie').html(data);
						});
				});
				$('#dowbox').click(function()
				{
					//alert("hello");
					var port_id=$('#portdc').val();
					var period =$('#periodc').val();
					$.post("<?php echo $site_url?>/Port/dowchart/",{port_id:port_id,period:period},function(data)
						{
							//alert("hello");
							$('#showd').html(data);
						});
				});
				$('#barbox').click(function()
				{
					//alert("hello");
					var port_id=$('#portbc').val();
					var period =$('#periodb').val();
					$.post("<?php echo $site_url?>/Port/barchart/",{port_id:port_id,period:period},function(data)
						{
							//alert("hello");
							$('#showbar').html(data);
						});
				});
				/*
				$('#port').change(function()
				{
					//alert("hello");
					var port_id=$('#port').val();
					//var period =$('#periodb').val();
					$.post("<?php echo $site_url?>/Port/getzone/",{port_id:port_id},function(data)
						{
							//alert("hello");
							$('#zone').html(data);
						});
				});
				$('#portdc').change(function()
				{
					//alert("hello");
					var port_id=$('#portdc').val();
					//var period =$('#periodb').val();
					$.post("<?php echo $site_url?>/Port/getzone/",{port_id:port_id},function(data)
						{
							//alert("hello");
							$('#zonedc').html(data);
						});
				});
				$('#portbc').change(function()
				{
					//alert("hello");
					var port_id=$('#portbc').val();
					//var period =$('#periodb').val();
					$.post("<?php echo $site_url?>/Port/getzone/",{port_id:port_id},function(data)
						{
							//alert("hello");
							$('#zonebc').html(data);
						});
				});*/
});
</script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
       </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Port Clerk</h3>

              
            </div>
            <!-- /.box-header -->
            
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <?php
                 
                 foreach($module_assign as $menunamenew)
{
	$path=$menunamenew['module_path'];
	$name=$menunamenew['module_name'];
	if($menunamenew['module_id']==1){$tnew=$tn1;$status='Pending';}else if($menunamenew['module_id']==2){$tnew=$tn2;$status='Pending';} else{$tnew='';$status='';}
				  ?>
                <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                    <i class="fas fa-unlock-alt"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title"><a class="no-link" href="<?php echo site_url($path);?>"><?php echo $name; ?></a></span>
              <span class="info-box-text"><?php echo $tnew .'-'.$status; ?>  </span>
            </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
                
                <?php } ?>

                <!-- /.col -->

                  <div class="col-3 p-2">
            <!-- ---------------- start of card --- ------------------------ -->
                  <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                    <i class="fas fa-unlock-alt"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body">
                      <h5 class="card-title">
                        <a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/ch_pw">  CHANGE PASSWORD </a>
                      </h5>
                      <p class="card-text"><small class="text-muted">  NEW </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- start of card --- ------------------------ -->
        </div> <!-- end of col3/4 -->
                
                
                <!-- /.col -->
                
                
                
                <!-- /.col -->
                
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!--- CHART DIVS -->
      
            
            
      <!-- CHATY DIV ENDS HERE -->
      <!-- NEXT MAIN DIV --->
      
      <!-- /.row -->
      <!-- NEXT MAIN DIV END -->
     
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- Sparkline -->
<script src="<?php echo base_url();?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url();?>assets/plugins/chartjs/Chart.min.js"></script>
<!-- ./wrapper -->
