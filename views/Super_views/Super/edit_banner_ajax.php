<?php if(isset($editDet)){

foreach($editDet as $edt_res){
  $bodycontent_sl           = $edt_res['bodycontent_sl'];
  $bodycontent_engtitle     = $edt_res['bodycontent_engtitle'];
  $bodycontent_maltitle     = $edt_res['bodycontent_maltitle'];
  $bodycontent_link         = $edt_res['bodycontent_link'];
  $bodycontent_buttonclass  = $edt_res['bodycontent_buttonclass'];
  $bodycontent_icon         = $edt_res['bodycontent_icon'];
  $bodycontent_order        = $edt_res['bodycontent_order'];
  $bodycontent_location_sl  = $edt_res['bodycontent_location_sl'];
}
?>

      
      <div class="col-6">
          <input type="text" name="edit_banner_eng" maxlength="100" id="edit_banner_eng" class="form-control "  value="<?php echo $bodycontent_engtitle;?>" autocomplete="off"/>
          <input type="hidden" name="id"  id="id" value="<?php echo $bodycontent_sl;?>" />
      </div>
      <div class="col-6">
          <input type="text" name="edit_banner_mal" maxlength="100" id="edit_banner_mal" class="form-control "  value="<?php echo $bodycontent_maltitle;?>" autocomplete="off"/>
      </div>

      <div class="col-2 pt-3 "><font color="#29208c">Enter Link</font></div>
      <div class="col-4 pt-3 ">
          <input type="text" name="edit_banner_link" maxlength="150" id="edit_banner_link" class="form-control "  value="<?php echo $bodycontent_link?>" autocomplete="off"/> 
      </div>
      <div class="col-2 pt-3 "><font color="#29208c">Enter Button Class</font></div>
      <div class="col-4 pt-3 ">
          <input type="text" name="edit_button_class" maxlength="150" id="edit_button_class" class="form-control "  value="<?php echo $bodycontent_buttonclass;?>" autocomplete="off"/> 
      </div> 

      <div class="col-2 pt-3 "><font color="#29208c">Enter Icon</font></div>
      <div class="col-4 pt-3 ">
          <input type="text" name="edit_banner_icon" maxlength="150" id="edit_banner_icon" class="form-control "  value="<?php echo $bodycontent_icon;?>" autocomplete="off"/> 
      </div>
      <div class="col-2 pt-3 "><font color="#29208c">Enter Menu Order</font></div>
      <div class="col-1 pt-3 ">
          <input type="text" name="edit_banner_order" maxlength="1" id="edit_banner_order" class="form-control "  value="<?php echo $bodycontent_order;?>" autocomplete="off"/> 
      </div>      
      <div class="col-3 pt-3 ">
        <select name="edit_location" id="edit_location" class="form-control js-example-basic-single" style="width: 100%;">
          <option value="">Select Location</option> 
          <?php foreach($location as $loc_res){ ?>
          <option value="<?php echo $loc_res['location_sl']; ?>"<?php if($loc_res['location_sl']==$bodycontent_location_sl) { ?> selected="selected" <?php } ?>><?php echo $loc_res['location_name']; ?></option>
             <?php }  ?>
        </select>
      </div>  <!-- end of col4 -->
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="submit" name="banner_upd" id="banner_upd" value="Edit Banner" class="btn btn-info btn-flat" onclick="save_banner($bodycontent_sl)" />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="banner_del" id="banner_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_banner()"  />
      </div> <!-- end of col6 -->
    
<?php } ?>