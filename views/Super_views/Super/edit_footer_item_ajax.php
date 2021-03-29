<?php if(isset($editDet)){

foreach($editDet as $edt_res){
  $bodycontent_sl           = $edt_res['bodycontent_sl'];
  $bodycontent_engtitle     = $edt_res['bodycontent_engtitle'];
  $bodycontent_maltitle     = $edt_res['bodycontent_maltitle']; 
  $bodycontent_engcontent   = $edt_res['bodycontent_engcontent'];
  $bodycontent_malcontent   = $edt_res['bodycontent_malcontent'];
  $bodycontent_order        = $edt_res['bodycontent_order'];
  $bodycontent_link         = $edt_res['bodycontent_link'];
  $bodycontent_location_sl  = $edt_res['bodycontent_location_sl'];
}
?>

      
      <div class="col-6">
          <input type="text" name="edit_footer_item_eng" maxlength="100" id="edit_footer_item_eng" class="form-control "  value="<?php echo $bodycontent_engtitle;?>" autocomplete="off"/>
          <input type="hidden" name="id"  id="id" value="<?php echo $bodycontent_sl;?>" />
          <input type="hidden" name="edit_location"  id="edit_location" value="<?php echo $bodycontent_location_sl;?>" />
      </div>
      <div class="col-6">
          <input type="text" name="edit_footer_item_mal" maxlength="100" id="edit_footer_item_mal" class="form-control "  value="<?php echo $bodycontent_maltitle;?>" autocomplete="off"/>
      </div>
      
      
      <div class="col-2 pt-3 "><font color="#29208c">Enter Menu Order</font></div>
      <div class="col-1 pt-3 ">
          <input type="text" name="edit_footer_item_order" maxlength="1" id="edit_footer_item_order" class="form-control "  value="<?php echo $bodycontent_order;?>" autocomplete="off"/> 
      </div>

       <div class="col-2 pt-3"><font color="#29208c">Enter Link</font></div>
      <div class="col-4 pt-3 ">
          <input type="text" name="footer_item_link" maxlength="150" id="footer_item_link" class="form-control "  value="<?php echo $bodycontent_link;?>" autocomplete="off"/> 
      </div>

       <div class="col-3 pt-3">
        <select name="edit_location" id="edit_location" class="form-control js-example-basic-single" style="width: 100%;">
          <option value="">Select Location</option> 
          <?php foreach($footer_list as $footer_list_res){ ?>
            <option value="<?php echo $footer_list_res['bodycontent_sl']; ?>"<?php if($footer_list_res['bodycontent_sl']==$bodycontent_location_sl){?> selected=selected <?php }?>><?php echo $footer_list_res['bodycontent_engtitle']; ?></option>
         
             <?php }  ?>
        </select>
      </div>  <!-- end of col4 -->
     
     

      <div class="col-12 py-2">
         <label class="p-2 innertitle bg-blue"> Description in English</label>
          <textarea name="edit_footer_item_tagline_eng" id="edit_footer_item_tagline_eng" class="summernote" placeholder=" Enter Tagline in English"><?php echo $bodycontent_engcontent;?></textarea>
          
      </div>
      <div class="col-12 py-2" >
         <label class="p-2 innertitle bg-blue"> Description in Malayalam</label>
          <textarea name="edit_footer_item_tagline_mal" id="edit_footer_item_tagline_mal" class="summernote" placeholder=" Enter Tagline in English"><?php echo $bodycontent_malcontent;?></textarea>
      </div>
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="submit" name="footer_upd" id="footer_upd" value="Edit Footer" class="btn btn-info btn-flat" onclick="save_footer($bodycontent_sl)" />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="footer_del" id="footer_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_footer()"  />
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