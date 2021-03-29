<canvas id="areaChart" ></canvas>
<script>
 $(function () {
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
    }

    //Create the line chart
var myChart=areaChart.Doughnut(areaChartDatan,bigpieOptions);
	//document.getElementById("js-legend").innerHTML =   myChart.generateLegend();
 });
</script>