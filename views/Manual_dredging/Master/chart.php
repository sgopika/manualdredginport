<?php
//print_r($_REQUEST);
?>
 <?php // echo $total1;?>
 <style>
 #js-legend ul {
  list-style: none;
}

#js-legend ul li {
  float: left;
  display: block;
  padding-left: 5px;
  position: relative;
  margin-bottom: 4px;
  border-radius: 5px;
  padding: 2px 8px 2px 22px;
  font-size: 10px;
  cursor: default;
  -webkit-transition: background-color 200ms ease-in-out;
  -moz-transition: background-color 200ms ease-in-out;
  -o-transition: background-color 200ms ease-in-out;
  transition: background-color 200ms ease-in-out;
}

#js-legend li span {
  display: block;
  position: absolute;
  left: 0;
  top: 0;
  width: 20px;
  height: 100%;
  border-radius: 5px;
}
#js-legend-do ul {
  list-style: none;
}

#js-legend-do ul li {
  float: left;
  display: block;
  padding-left: 2px;
  position: relative;
  margin-bottom: 4px;
  border-radius: 5px;
  padding: 2px 5px 2px 22px;
  font-size: 10px;
  cursor: default;
  -webkit-transition: background-color 200ms ease-in-out;
  -moz-transition: background-color 200ms ease-in-out;
  -o-transition: background-color 200ms ease-in-out;
  transition: background-color 200ms ease-in-out;
}

#js-legend-do li span {
  display: block;
  position: absolute;
  left: 0;
  top: 0;
  width: 20px;
  height: 100%;
  border-radius: 5px;
}
#js-legend-do-bar ul {
  list-style: none;
}

#js-legend-do-bar ul li {
  float: left;
  display: block;
  padding-left: 2px;
  position: relative;
  margin-bottom: 4px;
  border-radius: 5px;
  padding: 2px 5px 2px 22px;
  font-size: 10px;
  cursor: default;
  -webkit-transition: background-color 200ms ease-in-out;
  -moz-transition: background-color 200ms ease-in-out;
  -o-transition: background-color 200ms ease-in-out;
  transition: background-color 200ms ease-in-out;
}

#js-legend-do-bar li span {
  display: block;
  position: absolute;
  left: 0;
  top: 0;
  width: 20px;
  height: 100%;
  border-radius: 5px;
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
  <link rel="stylesheet" href=<?php echo base_url("assets/plugins/datepicker/datepicker3.css"); ?>>
   <script src="<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.js");?>"></script>
   <script src="<?php echo base_url("assets/plugins/input-mask/jquery.inputmask.date.extensions.js");?>"></script>
   <script src="<?php echo base_url("assets/plugins/chartjs/Chart.js");?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url("assets/plugins/fastclick/fastclick.js");?>"></script>
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
<!-- AdminLTE App -->

    <section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" >Chart</button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>
    <!-- Main content -->
   <section class="content">
      <div class="row">
        <div class="col-md-4">
          <!-- AREA CHART -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Payment Splitup</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body" id="pie">
              	<select name="port" id="port">
                <option selected="selected" value="">select</option>
                <?php foreach($port_det as $pd)
				{
					?>
                <option value="<?php echo $pd['int_portoffice_id'];?>"><?php echo $pd['vchr_portoffice_name'];?></option>
                <?php
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
                
                <div id="showpie">
                
                <canvas id="areaChart" style="height:150px"></canvas>
                <div id="js-legend" class="chart-legend clearfix"></div>
             	</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		</div>
         <div class="col-md-4">
          <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Sand Allotment Details</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
            <select name="portdc" id="portdc">
                <option selected="selected" value="">select</option>
                <?php 
				foreach($port_det as $pd)
				{
				?>
                <option value="<?php echo $pd['int_portoffice_id'];?>"><?php echo $pd['vchr_portoffice_name'];?></option>
                <?php
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
              <div id="showd">
              <canvas id="pieChart" style="height:150px"></canvas>
               <div id="js-legend-do" class="chart-legend clearfix"></div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
         
		
        </div>
         
        <!-- /.col (LEFT) -->
        <div class="col-md-4">
          <!-- LINE CHART -->
         
          <!-- /.box -->

          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Allotment Details</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
            <select name="portbc" id="portbc">
                <option selected="selected" value="">select</option>
                <?php foreach($port_det as $pd)
				{
					?>
                <option value="<?php echo $pd['int_portoffice_id'];?>"><?php echo $pd['vchr_portoffice_name'];?></option>
                <?php
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
                <canvas id="barChart" style="height:230px"></canvas>
                <div id="js-legend-do-bar" class="chart-legend clearfix"></div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col (RIGHT) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- jQuery 3 -->

<!-- ChartJS -->
<script src="<?php echo base_url("assets/plugins/chartjs/Chart.js");?>"></script>
<!-- Sparkline -->
<script src="<?php echo base_url("assets/plugins/sparkline/jquery.sparkline.min.js");?>"></script>
<!-- FastClick -->

<!-- page script -->
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
	  legendTemplate: '<ul>' + '<% for (var i=0; i<segments.length; i++) { %>' + '<li>' + '<span style=\"background-color:<%=segments[i].fillColor%>\"></span>' + '<% if (segments[i].label) { %><%= segments[i].label %><% } %>' + '</li>' + '<% } %>' + '</ul>'
  };
   
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)
//*
    var areaChartDatan = [
      {
        value    : <?php echo $total1;?>,
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Labour charge'
      },
      {
        value    : <?php echo $total2;?>,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'Government charge'
      },
      {
        value    : <?php echo $total3;?>,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'LSGD share'
      },
      {
        value    : <?php echo $total4;?>,
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Cleaning charge'
      },
      {
        value    : <?php echo $total5;?>,
        color    : '#3c8dbc',
        highlight: '#3c8dbc',
        label    : 'Royalty'
      },
      {
        value    : <?php echo $total6;?>,
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
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }

    //Create the line chart
   	var myChart=areaChart.Doughnut(areaChartDatan,bigpieOptions);
	document.getElementById("js-legend").innerHTML =   myChart.generateLegend();
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
        value    : <?php echo $balsand-2900;?>,
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
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var myChartdo=pieChart.Doughnut(PieData, pieOptions)
	document.getElementById("js-legend-do").innerHTML =   myChartdo.generateLegend();
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
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    var myChartdo=barChart.Bar(barChartData, barChartOptions);
	document.getElementById("js-legend-do-bar").innerHTML =   myChartdo.generateLegend();

  })
</script>