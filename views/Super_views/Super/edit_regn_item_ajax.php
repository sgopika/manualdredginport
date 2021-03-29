<?php if(isset($editDet)){

foreach($editDet as $edt_res){
  $bodycontent_sl           = $edt_res['bodycontent_sl'];
  $bodycontent_engtitle     = $edt_res['bodycontent_engtitle'];
  $bodycontent_maltitle     = $edt_res['bodycontent_maltitle'];
  $bodycontent_icon         = $edt_res['bodycontent_icon'];
  $bodycontent_link         = $edt_res['bodycontent_link'];
  $bodycontent_order        = $edt_res['bodycontent_order'];
  $bodycontent_location_sl  = $edt_res['bodycontent_location_sl'];
}
?>

      
      <div class="col-6">
          <input type="text" name="edit_registration_item_eng" maxlength="100" id="edit_registration_item_eng" class="form-control "  value="<?php echo $bodycontent_engtitle;?>" autocomplete="off"/>
          <input type="hidden" name="id"  id="id" value="<?php echo $bodycontent_sl;?>" />
          <input type="hidden" name="edit_location"  id="edit_location" value="<?php echo $bodycontent_location_sl;?>" />
      </div>
      <div class="col-6">
          <input type="text" name="edit_registration_item_mal" maxlength="100" id="edit_registration_item_mal" class="form-control "  value="<?php echo $bodycontent_maltitle;?>" autocomplete="off"/>
      </div>
      <div class="col-1 pt-3 "><font color="#29208c">Enter Icon</font></div>
      <div class="col-3 pt-3 ">
          <input type="text" name="edit_registration_item_icon" maxlength="150" id="edit_registration_item_icon" class="form-control "  value="<?php echo $bodycontent_icon;?>" autocomplete="off"/> 
      </div>
      <div class="col-1 pt-3 "><font color="#29208c">Enter Link</font></div>
      <div class="col-4 pt-3 ">
          <input type="text" name="edit_registration_item_link" maxlength="150" id="edit_registration_item_link" class="form-control "  value="<?php echo $bodycontent_link;?>" autocomplete="off"/> 
      </div>
      <div class="col-2 pt-3 "><font color="#29208c">Enter Menu Order</font></div>
      <div class="col-1 pt-3 ">
          <input type="text" name="edit_registration_item_order" maxlength="1" id="edit_registration_item_order" class="form-control "  value="<?php echo $bodycontent_order;?>" autocomplete="off"/> 
      </div>

      
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="submit" name="regn_item_upd" id="regn_item_upd" value="Edit Registration Item" class="btn btn-info btn-flat" onclick="save_banner($bodycontent_sl)" />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="regn_item_del" id="regn_item_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_registration_item()"  />
      </div> <!-- end of col6 -->
    
<?php } ?>