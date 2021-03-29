<?php if(isset($editDet)){

foreach($editDet as $edt_res){
  $webnotification_sl           = $edt_res['webnotification_sl'];
  $webnotification_engtitle     = $edt_res['webnotification_engtitle'];
  $webnotification_maltitle     = $edt_res['webnotification_maltitle']; 
  $webnotification_engcontent   = $edt_res['webnotification_engcontent'];
  $webnotification_malcontent   = $edt_res['webnotification_malcontent'];
  
}
?>

      
      <div class="col-6">
          <input type="text" name="edit_web_notfn_eng" maxlength="100" id="edit_web_notfn_eng" class="form-control "  value="<?php echo $webnotification_engtitle;?>" autocomplete="off"/>
          <input type="hidden" name="id"  id="id" value="<?php echo $webnotification_sl;?>" />
          
      </div>
      <div class="col-6">
          <input type="text" name="edit_web_notfn_mal" maxlength="100" id="edit_web_notfn_mal" class="form-control "  value="<?php echo $webnotification_maltitle;?>" autocomplete="off"/>
      </div>
      <div class="col-12">
        <label class="p-2 innertitle bg-blue"> Description in English</label>
          <textarea name="edit_web_notfn_content_eng" id="edit_web_notfn_content_eng" class="summernote" placeholder=" Enter Content in English"><?php echo $webnotification_engcontent;?></textarea>
          
          
      </div>
      <div class="col-12">
        <label class="p-2 innertitle bg-blue"> Description in Malayalam</label>
          <textarea name="edit_web_notfn_content_mal" id="edit_web_notfn_content_mal" class="summernote"  placeholder=" Enter Content in Malayalam"><?php echo $webnotification_malcontent;?></textarea>
          
      </div>
      
      
      
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="submit" name="web_notfn_upd" id="web_notfn_upd" value="Edit Notification" class="btn btn-info btn-flat" onclick="save_web_notfn($webnotification_sl)" />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="web_notfn_del" id="web_notfn_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_web_notfn()"  />
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