<style>
.margin{
	width:43%;	
	
}

</style>
 
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
					var z_id =$('#zone').val();
					$.post("<?php echo $site_url?>/Master/Piechart/",{port_id:port_id,period:period,zone_id:z_id},function(data)
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
					var z_id =$('#zonedc').val();
					$.post("<?php echo $site_url?>/Master/dowchart/",{port_id:port_id,period:period,zone_id:z_id},function(data)
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
					var z_id =$('#zonebc').val();
					$.post("<?php echo $site_url?>/Master/barchart/",{port_id:port_id,period:period,zone_id:z_id},function(data)
						{
							//alert("hello");
							$('#showbar').html(data);
						});
				});
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
				});
});
</script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
       </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion icon ion-compose"></i></span>

            <div class="info-box-content">
              <span class="info-box-number"><a href="<?php echo site_url("Port/cu_reg_pd"); ?>">Customer Registration</a></span>
              <span class="info-box-text"><?php echo $tn1; ?> Pending</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-briefcase"></i></span>

            <div class="info-box-content">
              <span class="info-box-number"><a href="<?php echo site_url("Port/cus_reg_det_pd"); ?>">Customer Booking</a></span>
              <span class="info-box-text"><?php echo $tn2;?> PENDING</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-document-text"></i></span>

            <div class="info-box-content">
              <span class="info-box-number"><a href="<?php echo site_url("Port/mon_pt_ap_pd"); ?>">Monthly Permit</a></span>
              <span class="info-box-text"><?php echo $tot_per_pend;?> PENDING </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-number"><a href="<?php echo site_url("Master/workerqty_master"); ?>">Worker Quantity</a></span>
              </div>
              
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Customer Booking Pattern</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>August 22, 2017</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                
                <div class="col-md-4">
                  
                  <!-- NEXT SUB DIV -->
                  <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Settings</h3>

              <div class="box-tools pull-right">
                
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <a href="<?php echo site_url("Master/material"); ?>"><button type="button" class="btn bg-maroon btn-flat margin">Material Share</button></a>
             <a href="<?php echo site_url("Master/material_rate"); ?>"><button type="button" class="btn bg-purple btn-flat margin">Material Rate</button></a>
             <a href="<?php echo site_url("Master/taxname_master"); ?>"><button type="button" class="btn bg-orange btn-flat margin">Tax</button></a>
             <a href="<?php echo site_url("Master/taxcalculator"); ?>"><button type="button" class="btn bg-olive btn-flat margin">Tax Rate Setting</button></a>
             <a href="<?php echo site_url("Master/construction_master"); ?>"><button type="button" class="btn bg-maroon btn-flat margin">Construction Type</button></a>
             <a href="<?php echo site_url("Master/plintharea_master"); ?>"><button type="button" class="btn bg-purple btn-flat margin">Plinth Area</button></a>
             <a href="<?php echo site_url("Master/cutoff_master"); ?>"><button type="button" class="btn bg-orange btn-flat margin">Permit Cutoff Days</button></a>
             <a href="<?php echo site_url("Master/booking_master"); ?>"><button type="button" class="btn bg-olive btn-flat margin">Booking Time</button></a>
             <a href="<?php echo site_url("Master/portconserv_master"); ?>"><button type="button" class="btn bg-maroon btn-flat margin">User Management</button></a>
             <a href="<?php echo site_url("Master/quantity_master"); ?>"><button type="button" class="btn bg-orange btn-flat margin">Quantity</button></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
	<!-- NEXT SUB DIV -->
    
                  <!--<div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="ion ion-ios-briefcase"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Master Settings</span>
              <span class="info-box-number"></span>

              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
                  <span class="progress-description">
                    Zone, LSGD, Bank, Quantity, Rate
                  </span>
            </div>
            <!-- /.info-box-content -->
          <!--</div>-->
                 
          <!-- /.info-box -->
         
          <!-- /.info-box -->
                  <!-- /.progress-group -->
                  
                </div>
                
                
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                
                <div class="col-sm-3 col-xs-6">
                  <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="ion ion-ios-email"></i></span>

            <div class="info-box-content">
              <span class="info-box-number"><a href="<?php echo site_url("Port/mailbox");?>">Mail Box</a></span>
              <span class="info-box-text"><?php echo $tn; ?> New </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="info-box">
            <span class="info-box-icon bg-maroon"><i class="ion ion-pricetags"></i></span>

            <div class="info-box-content">
              <span class="info-box-number"><a href="#">Communication</a></span>
              <span class="info-box-text"><?php echo $tn3;?> New Question(s)</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-printer"></i></span>

            <div class="info-box-content">
             
              <span class="info-box-number"><a href="<?php echo site_url("Master/dregport_master"); ?>">Active Ports</a></span>
              <span class="info-box-text"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
                </div>
                <div class="col-sm-3 col-xs-6">
                  <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-stats-bars"></i></span>

            <div class="info-box-content">
              <span class="info-box-number"><a href="<?php echo site_url("Port/user_logs_pd"); ?>">Logs</a></span>
              <span class="info-box-text"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
                </div>
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
      <div class="col-md-4">
            	<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Payment Splitup</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <select name="port" id="port">
                <option selected="selected" value="">select</option>
                <?php foreach($port_det as $pd)
				{
					if(in_array($pd['int_portoffice_id'],$po_port_arr)){	?>
						<option value="<?php echo $pd['int_portoffice_id'];?>"><?php echo $pd['vchr_portoffice_name'];?></option>
						<?php
					}
				}
				?>
				</select>
                <select id="zone"></select>
                <select name="period" id="period">
                <option selected="selected" value="">select</option>
                <?php foreach($permit as $p)
				{
					?>
                <option value="<?php echo $p['monthly_permit_period_name'];?>"><?php echo $p['monthly_permit_period_name'];?></option>
                <?php
				}
				?>
                </select>
                <button id="piebox">Generate</button><p>&nbsp;</p>
              <div class="row">
                <div class="col-md-6">
                  <div class="chart" id="showpie">
                    <canvas id="areaChart" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                <ul class="chart-legend clearfix">
                    <li><i class="fa fa-circle-o" style="color:#f56954"></i> Labour charge</li>
                    <li><i class="fa fa-circle-o" style="color:#00a65a"></i> Government charge</li>
                    <li><i class="fa fa-circle-o" style="color:#f39c12"></i> LSGD share</li>
                    <li><i class="fa fa-circle-o" style="color:#00c0ef"></i> Cleaning charge</li>
                    <li><i class="fa fa-circle-o" style="color:#3c8dbc"></i> Royalty</li>
                    <li><i class="fa fa-circle-o" style="color:#d2d6de"></i> Vehicle Pass</li>
                  </ul>
                  
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              
            </div>
            <!-- /.footer -->
          </div>
            </div>
            <div class="col-md-4">
            	<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Sand Allotment Details</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <select name="portdc" id="portdc">
                <option selected="selected" value="">select</option>
                <?php 
				foreach($port_det as $pd)
				{
				if(in_array($pd['int_portoffice_id'],$po_port_arr)){	?>
                	<option value="<?php echo $pd['int_portoffice_id'];?>"><?php echo $pd['vchr_portoffice_name'];?></option>
               		<?php
					}
				}
				?>
			</select>
            <select id="zonedc">
            </select>
            <select name="periodc" id="periodc">
                <option selected="selected" value="">select</option>
                <?php foreach($permit as $p)
				{
					?>
                <option value="<?php echo $p['monthly_permit_period_name'];?>"><?php echo $p['monthly_permit_period_name'];?></option>
                <?php
				}
				?>
            </select>
            <button id="dowbox">Generate</button><p>&nbsp;</p>
              <div class="row">
                <div class="col-md-6">
                  <div id="showd" class="chart">
                    <canvas id="pieChart"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                  <ul class="chart-legend clearfix">
                    <li><i class="fa fa-circle-o text-#f56954" style="color:#f56954"></i> Permit Requests</li>
                    <li><i class="fa fa-circle-o text-#00a65a" style="color:#00a65a"></i> Permit Approved</li>
                    <li><i class="fa fa-circle-o text-#f39c12" style="color:#f39c12"></i> Total Booking</li>
                    <li><i class="fa fa-circle-o text-#00c0ef" style="color:#00c0ef"></i> Booking Approved</li>
                    <li><i class="fa fa-circle-o text-#3c8dbc" style="color:#3c8dbc"></i> Booking Rejected</li>
                    <li><i class="fa fa-circle-o text-#d2d6de" style="color:#d2d6de"></i> Total Sand Pass</li>
                    <li><i class="fa fa-circle-o text-#F63" style="color:#F63"></i> Balance Sand</li>
                    
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              
            </div>
            <!-- /.footer -->
          </div>
            </div>
            <div class="col-md-4">
            	<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Allotment Details</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <select name="portbc" id="portbc">
                <option selected="selected" value="">select</option>
                <?php foreach($port_det as $pd)
				{
					if(in_array($pd['int_portoffice_id'],$po_port_arr)){	?>
                		<option value="<?php echo $pd['int_portoffice_id'];?>"><?php echo $pd['vchr_portoffice_name'];?></option>
                		<?php
					}
				}
				?>
				</select>
                <select id="zonebc"></select>
                <select name="periodb" id="periodb">
                <option selected="selected" value="">select</option>
                <?php foreach($fin_year as $fy)
				{
					?>
                <option value="<?php echo $fy['intFinancialYearID'];?>"><?php echo $fy['chrFinancialYear'];?></option>
                <?php
				}
				?>
                </select>
                <button id="barbox">Generate</button>
              <div class="chart" id="showbar">
                <canvas id="barChart" height="96px"></canvas>
                <div id="js-legend-do-bar" class="chart-legend clearfix"></div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              
            </div>
            <!-- /.footer -->
          </div>
            </div>
      <!-- CHATY DIV ENDS HERE -->
      <!-- NEXT MAIN DIV --->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Customer Booking Pattern</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>August 22, 2017</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChartn" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Sand allottment at port</strong>
                  </p>

                  <div class="progress-group">
                    <span class="progress-text">Total Booking</span>
                    <span class="progress-number"><b><?php echo $tn5; ?></b>/<?php echo $tn4; ?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Total Issued</span>
                    <span class="progress-number"><b><?php echo $tn6; ?></b>/<?php echo $tn5; ?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Balance</span>
                    <span class="progress-number"><b><?php echo $tn8; ?></b>/<?php echo $tn7; ?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                
                <div class="col-sm-3 col-xs-6">
                  <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="ion ion-ios-email"></i></span>

            <div class="info-box-content">
              <span class="info-box-number"><a href="<?php echo site_url("Port/portofficer_master");?>">Port Officer</a></span>
              
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="info-box">
            <span class="info-box-icon bg-maroon"><i class="ion ion-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-number"><a href="<?php echo site_url("Master/police_case_pc");?>">Change Date</a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-printer"></i></span>

            <div class="info-box-content">
             
              <span class="info-box-number"><a href="<?php echo site_url("Master/fee_master"); ?>">Fee Master</a></span>
              <span class="info-box-text"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
                </div>
                <div class="col-sm-3 col-xs-6">
                  <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-stats-bars"></i></span>

            <div class="info-box-content">
              <span class="info-box-number">Rejected Process</span>
              <span class="info-box-text"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
                </div>
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
<script>
  $(function () {
	  var areaChartData = {
      labels  : [ <?php foreach($permit as $p)
				{
					echo "'".$p['monthly_permit_period_name']."',";
				}
				?>],
      datasets: [
        {
          label               : 'Total Sand Booking',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($totpermitbar as $tpb)
				{
					echo $tpb.",";
				}
				?>]
        },
        {
          label               : 'Total Sand Pass',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($totsandpassbar as $tsb)
				{
					echo $tsb.",";
				}
				?>]
        }
      ]
    }
	 var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
	 // legend             : true,
      //String - A legend template
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true,
  };
   
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)
//*
    var areaChartDatan = [
      {
        value    : '<?php echo $total1;?>',
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Labour charge'
      },
      {
        value    : '<?php echo $total2;?>',
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'Government charge'
      },
      {
        value    : '<?php echo $total3;?>',
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'LSGD share'
      },
      {
        value    : '<?php echo $total4;?>',
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Cleaning charge'
      },
      {
        value    : '<?php echo $total5;?>',
        color    : '#3c8dbc',
        highlight: '#3c8dbc',
        label    : 'Royalty'
      },
      {
        value    : '<?php echo $total6;?>',
        color    : '#d2d6de',
        highlight: '#d2d6de',
        label    : 'Vehicle Pass'
      }
    ]
	var bigpieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 0, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
    }

    //Create the line chart
   	var myChart=areaChart.Doughnut(areaChartDatan,bigpieOptions);
	//document.getElementById("js-legend").innerHTML =   myChart.generateLegend();
    //-------------
    //- LINE CHART -
    //--------------
    //var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
    //var lineChart                = new Chart(lineChartCanvas)
   // var lineChartOptions         = areaChartOptions
   // lineChartOptions.datasetFill = false
   // lineChart.Line(areaChartData, lineChartOptions)

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)
    var PieData        = [
      {
        value    : <?php echo $totperreq;?>,
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Permit Requests'
      },
      {
        value    : <?php echo $totperreqAp;?>,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'Permit Approved'
      },
      {
        value    : <?php echo $totsreq;?>,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'Total Booking'
      },
      {
        value    : <?php echo $totsreqa;?>,
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Booking Approved'
      },
      {
        value    : <?php echo $totsreqr;?>,
        color    : '#3c8dbc',
        highlight: '#3c8dbc',
        label    : 'Booking Rejected'
      },
      {
        value    : <?php echo $totspass;?>,
        color    : '#d2d6de',
        highlight: '#d2d6de',
        label    : 'Total Sand Pass'
      },
	  {
        value    : <?php echo $balsand;?>,
        color    : '#F63',
        highlight: '#F63',
        label    : 'Balance Sand'
      }
    ]
    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var myChartdo=pieChart.Doughnut(PieData, pieOptions)
	//document.getElementById("js-legend-do").innerHTML =   myChartdo.generateLegend();
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    var myChartdo=barChart.Bar(barChartData, barChartOptions);
	//document.getElementById("js-legend-do-bar").innerHTML =   myChartdo.generateLegend();
	
	// LINe
	var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas);
  var salesChartCanvasn = $("#salesChartn").get(0).getContext("2d");
  // This will get the first returned node in the jQuery collection.
  var salesChartn = new Chart(salesChartCanvasn);

  var salesChartData = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
      {
        label: "Electronics",
        fillColor: "rgb(210, 214, 222)",
        strokeColor: "rgb(210, 214, 222)",
        pointColor: "rgb(210, 214, 222)",
        pointStrokeColor: "#c1c7d1",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgb(220,220,220)",
        data: [65, 59, 80, 81, 56, 55, 40]
      },
      {
        label: "Digital Goods",
        fillColor: "rgba(60,141,188,0.9)",
        strokeColor: "rgba(60,141,188,0.8)",
        pointColor: "#3b8bba",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: [28, 48, 40, 19, 86, 27, 90]
      }
    ]
  };

  var salesChartOptions = {
    //Boolean - If we should show the scale at all
    showScale: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: false,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    //Boolean - Whether the line is curved between points
    bezierCurve: true,
    //Number - Tension of the bezier curve between points
    bezierCurveTension: 0.3,
    //Boolean - Whether to show a dot for each point
    pointDot: false,
    //Number - Radius of each point dot in pixels
    pointDotRadius: 4,
    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth: 1,
    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius: 20,
    //Boolean - Whether to show a stroke for datasets
    datasetStroke: true,
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth: 2,
    //Boolean - Whether to fill the dataset with a color
    datasetFill: true,
    //String - A legend template
    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: true,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);
  salesChartn.Line(salesChartData, salesChartOptions);
	///

  })
</script>