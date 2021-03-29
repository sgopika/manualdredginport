<script>
$(document).ready(function() {
    $('#example1').DataTable({
      "oLanguage": { "sSearch": "" } 
    });
    $('#example2').DataTable({
      "oLanguage": { "sSearch": "" } 
    });
   
    $('.dataTables_filter input[type="search"]').attr('placeholder','Search').css({});
    $('.js-example-basic-single').select2();
    
});

$('.dob').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
});

/* $('.summernote').summernote({
        
        tabsize: 2,
        height: 400
      });*/
        $('.summernote').summernote({
    tabsize: 2,
    height: 400,
    width: '100%',
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
    ],
  });

  /* $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
  });   
   */
</script>

