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

      
      <div class="col-4">
          <input type="text" name="edit_terms_condns_eng" maxlength="100" id="edit_terms_condns_eng" class="form-control "  value="<?php echo $bodycontent_engtitle;?>" autocomplete="off"/>
          <input type="hidden" name="id"  id="id" value="<?php echo $bodycontent_sl;?>" />
          
      </div>
      <div class="col-4">
          <input type="text" name="edit_terms_condns_mal" maxlength="100" id="edit_terms_condns_mal" class="form-control "  value="<?php echo $bodycontent_maltitle;?>" autocomplete="off"/>
      </div>
      
      <div class="col-4">
        <select name="edit_location" id="edit_location" class="form-control js-example-basic-single" style="width: 100%;">
          <option value="">Select Location</option> 
          <?php //foreach($location as $loc_res){ ?>
          <option value="7"<?php if($bodycontent_location_sl==7){?> selected=selected <?php } ?>>Footer 1</option>
          <option value="8"<?php if($bodycontent_location_sl==8){?> selected=selected <?php } ?>>Footer 2</option>
          <option value="9"<?php if($bodycontent_location_sl==9){?> selected=selected <?php } ?>>Footer 3</option>
          <option value="10"<?php if($bodycontent_location_sl==10){?> selected=selected <?php } ?>>Footer 4</option>
             <?php //}  ?>
        </select>
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
        <input type="submit" name="terms_condn_upd" id="terms_condn_upd" value="Edit Terms & Condition" class="btn btn-info btn-flat" onclick="save_web_notfn($bodycontent_sl)" />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="terms_condn_del" id="terms_condn_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_terms_condn()"  />
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