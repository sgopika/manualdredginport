<footer class="footer">
   <p class="h6 text-white"> <small> All Rights Reserved </small> </p>
   <p class="h6 text-white"> <small> Designed and Developed by C-DIT </small> </p>
</footer>
<!-- All Javascript Files are included below -->
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
    $('#example').DataTable({
      "oLanguage": { "sSearch": "" } 
    });
    $('.dataTables_filter input[type="search"]').attr('placeholder','Search').css({});
    });
     </script>
  </body>
</html>