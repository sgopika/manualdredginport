<canvas id="pieChart" ></canvas>
<script>
 $(function () {
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
	document.getElementById("js-legend-do").innerHTML =   myChartdo.generateLegend();
 });
</script>