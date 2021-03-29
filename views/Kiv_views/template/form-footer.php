<footer class="footer">
   <p class="h6 text-white"> <small> All Rights Reserved </small> </p>
   <p class="h6 text-white"> <small> Designed and Developed by C-DIT </small> </p>
</footer>
    <!-- Bootstrap, Popper, JQuery -->
    <script src="<?php echo base_url(); ?>plugins/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/js/bootstrap.min.js"></script>
    <!-- Fontawesome Javascript -->
    <script src="<?php echo base_url(); ?>plugins/fontawesome/js/all.min.js"></script>
    <!-- iCheck, Select2 and Input Mask -->
    <script src="<?php echo base_url(); ?>plugins/js/icheck.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/js/inputmask.js"></script>
    <script src="<?php echo base_url(); ?>plugins/js/select2.full.min.js"></script>
      <!-- <script src="<?php //echo base_url(); ?>plugins/js/jquery.min.js"></script> -->

 <script type="text/javascript">
  $(document).ready(function() {
          $('.select2').select2({ width:'100%' });
      });

  (function($){ 
  $('.dob').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
  });
  
})(jQuery);
 </script>
 </body>
</html>