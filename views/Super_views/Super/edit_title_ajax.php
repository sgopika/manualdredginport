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

      
      <div class="col-2">
          <input type="text" name="edit_title_eng" maxlength="100" id="edit_title_eng" class="form-control "  value="<?php echo $bodycontent_engtitle;?>" autocomplete="off"/>
          <input type="hidden" name="id"  id="id" value="<?php echo $bodycontent_sl;?>" />
      </div>
      <div class="col-2">
          <input type="text" name="edit_title_mal" maxlength="100" id="edit_title_mal" class="form-control "  value="<?php echo $bodycontent_maltitle;?>" autocomplete="off"/>
      </div>
      <div class="col-3">
          <textarea name="edit_tagline_eng" id="edit_tagline_eng" placeholder=" Enter Tagline in English"><?php echo $bodycontent_engcontent;?></textarea>
      </div>
      <div class="col-3">
          <textarea name="edit_tagline_mal" id="edit_tagline_mal" placeholder=" Enter Tagline in Malayalam"><?php echo $bodycontent_malcontent;?></textarea>
      </div> 
      <div class="col-2">
        <select name="edit_location" id="edit_location" class="form-control js-example-basic-single" style="width: 100%;">
          <option value="">Select Location</option> 
          <?php foreach($location as $loc_res){ ?>
          <option value="<?php echo $loc_res['location_sl']; ?>"<?php if($loc_res['location_sl']==$bodycontent_location_sl) { ?> selected="selected" <?php } ?>><?php echo $loc_res['location_name']; ?></option>
             <?php }  ?>
        </select>
      </div>  <!-- end of col4 -->
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="submit" name="title_upd" id="title_upd" value="Edit Title" class="btn btn-info btn-flat" onclick="save_title($bodycontent_sl)" />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="title_del" id="title_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_title()"  />
      </div> <!-- end of col6 -->
    
<?php } ?>