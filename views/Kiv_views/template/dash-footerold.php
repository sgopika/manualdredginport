<footer class="footer">
   <p class="h6 text-white"> <small> All Rights Reserved </small> </p>
   <p class="h6 text-white"> <small> Designed and Developed by C-DIT </small> </p>
</footer>
<!-- All Javascript Files are included below -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo base_url(); ?>plugins/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/js/bootstrap.min.js"></script>
    <!-- Fontawesome Javascript -->
    <script src="<?php echo base_url(); ?>plugins/fontawesome/js/all.min.js"></script>
    <!-- Datatable Javascript -->
    <script src="<?php echo base_url(); ?>plugins/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/js/dataTables.bootstrap4.min.js"></script>
     
     <script type="text/javascript">
    $(document).ready(function() {
      $("#profile_div").show();
      $("#request_div").hide();

  /*  $('input').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
    });
*/
    $('.mytableheader').DataTable({
      "pageLength": 10,
      "bLengthChange" : false,
      "bInfo":true,  

      "oLanguage": { "sSearch": "" } 
    });

    
    $('.dataTables_filter input[type="search"]').attr('placeholder','Search').css({});

    $('.dob').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
  });
  
$('#inspection_date').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
  });
  


    }); //Jquery End

      $('#inbox_link').click(function(){ 
      $("#profile_div").hide();
      $("#request_div").show();
      $("#inbox_link").addClass("list-group-item-primary");
      return false; });

      $('#profile_button').click(function(){ 
      $("#profile_div").show();
      $("#request_div").hide();
      
      $("#inbox_link").removeClass("list-group-item-primary");
      return false; });

      

     </script>
  </body>
</html>
