<?php if(isset($editDet)){

foreach($editDet as $edt_res){
  $bodycontent_sl           = $edt_res['bodycontent_sl'];
  $bodycontent_engtitle     = $edt_res['bodycontent_engtitle'];
  $bodycontent_maltitle     = $edt_res['bodycontent_maltitle'];
  $bodycontent_order        = $edt_res['bodycontent_order'];
  $bodycontent_location_sl  = $edt_res['bodycontent_location_sl'];
}
?>

      
      <div class="col-4">
          <input type="text" name="edit_footer_eng" maxlength="100" id="edit_footer_eng" class="form-control "  value="<?php echo $bodycontent_engtitle;?>" autocomplete="off"/>
          <input type="hidden" name="id"  id="id" value="<?php echo $bodycontent_sl;?>" />
          <input type="hidden" name="edit_location"  id="edit_location" value="<?php echo $bodycontent_location_sl;?>" />
      </div>
      <div class="col-4">
          <input type="text" name="edit_footer_mal" maxlength="100" id="edit_footer_mal" class="form-control "  value="<?php echo $bodycontent_maltitle;?>" autocomplete="off"/>
      </div>
      
      <div class="col-2 pt-3 "><font color="#29208c">Enter Menu Order</font></div>
      <div class="col-2 pt-3 ">
          <input type="text" name="edit_footer_order" maxlength="1" id="edit_footer_order" class="form-control "  value="<?php echo $bodycontent_order;?>" autocomplete="off"/> 
      </div>

      
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="submit" name="footer_upd" id="footer_upd" value="Edit Footer" class="btn btn-info btn-flat" onclick="save_footer($bodycontent_sl)" />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="footer_del" id="footer_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_footer()"  />
      </div> <!-- end of col6 -->
    
<?php } ?>