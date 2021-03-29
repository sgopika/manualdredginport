<script>
  $(function () {
    $('#vacbtable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "sScrollX": "990px",
	  "columnDefs": [
	  {
		  "targets": [-1,-2,-3, 0],
		  "searchable": false
	  },{
      "targets": [-1, 0],
      "width": "50px"
    },{
"targets": [-3],
"width": "80px"
    },{
"targets": [-1, -2, -3, 0],
"sortable": false
    },{
"targets": [1],
"width": "250px"
    },{
"targets": [2],
"width": "50px"
    }
	  ]
    });

    
    
  });
</script>