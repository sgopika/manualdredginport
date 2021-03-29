<?php if(isset($editDet)){

foreach($editDet as $edt_res){
  $bodycontent_sl           = $edt_res['bodycontent_sl'];
  $bodycontent_engtitle     = $edt_res['bodycontent_engtitle'];
  $bodycontent_maltitle     = $edt_res['bodycontent_maltitle'];
  $bodycontent_engcontent   = $edt_res['bodycontent_engcontent'];
  $bodycontent_malcontent   = $edt_res['bodycontent_malcontent'];
  $bodycontent_location_sl  = $edt_res['bodycontent_location_sl'];
}
?>

      
      <div class="col-6">
          <input type="text" name="edit_registration_eng" maxlength="100" id="edit_registration_eng" class="form-control "  value="<?php echo $bodycontent_engtitle;?>" autocomplete="off"/>
          <input type="hidden" name="id"  id="id" value="<?php echo $bodycontent_sl;?>" />
          <input type="hidden" name="edit_location"  id="edit_location" value="<?php echo $bodycontent_location_sl;?>" />
      </div>
      <div class="col-6">
          <input type="text" name="edit_registration_mal" maxlength="100" id="edit_registration_mal" class="form-control "  value="<?php echo $bodycontent_maltitle;?>" autocomplete="off"/>
      </div>
      <div class="col-12 py-2">
         <label class="p-2 innertitle bg-blue"> Description in English</label>
          <textarea name="edit_registration_desc_eng" id="edit_registration_desc_eng" class="form-control summernote"  placeholder=" Description in English"><?php echo $bodycontent_engcontent;?></textarea>
      </div>
      <div class="col-12 py-2">
         <label class="p-2 innertitle bg-blue"> Description in Malayalam</label>
          <textarea name="edit_registration_desc_mal" id="edit_registration_desc_mal" class="form-control summernote"  placeholder=" Description in Malayalam"><?php echo $bodycontent_malcontent;?></textarea>
      </div>

      
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="submit" name="regn_upd" id="regn_upd" value="Edit Registration" class="btn btn-info btn-flat" onclick="save_banner($bodycontent_sl)" />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="regn_del" id="regn_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_registration()"  />
      </div> <!-- end of col6 -->
    
<?php } ?>
<script >
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
</script>