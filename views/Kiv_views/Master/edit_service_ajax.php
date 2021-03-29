<?php if(isset($editDet)){

foreach($editDet as $edt_res){
  $bodycontent_sl           = $edt_res['bodycontent_sl'];
  $bodycontent_engtitle     = $edt_res['bodycontent_engtitle'];
  $bodycontent_maltitle     = $edt_res['bodycontent_maltitle']; 
  $bodycontent_engcontent   = $edt_res['bodycontent_engcontent'];
  $bodycontent_malcontent   = $edt_res['bodycontent_malcontent'];
  
}
?>

      
      <div class="col-6">
          <input type="text" name="edit_services_eng" maxlength="100" id="edit_services_eng" class="form-control "  value="<?php echo $bodycontent_engtitle;?>" autocomplete="off"/>
          <input type="hidden" name="id"  id="id" value="<?php echo $bodycontent_sl;?>" />
          
      </div>
      <div class="col-6">
          <input type="text" name="edit_services_mal" maxlength="100" id="edit_services_mal" class="form-control "  value="<?php echo $bodycontent_maltitle;?>" autocomplete="off"/>
      </div>
      <div class="col-12 py-2">
        <label class="p-2 innertitle bg-blue"> Description in English</label>
          <textarea name="edit_content_eng" id="edit_content_eng" class="summernote" placeholder=" Enter Content in English"><?php echo $bodycontent_engcontent;?></textarea>
          
          
      </div>
      <div class="col-12 py-2">
         <label class="p-2 innertitle bg-blue"> Description in Malayalam</label>
          <textarea name="edit_content_mal" id="edit_content_mal" class="summernote" placeholder=" Enter Content in Malayalam"><?php echo $bodycontent_malcontent;?></textarea>
          
      </div>
       
      
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="submit" name="services_upd" id="services_upd" value="Edit Services" class="btn btn-info btn-flat" onclick="save_services($bodycontent_sl)" />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="services_del" id="services_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_services()"  />
      </div> <!-- end of col6 -->
    
<?php } ?>
<script >
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
</script>