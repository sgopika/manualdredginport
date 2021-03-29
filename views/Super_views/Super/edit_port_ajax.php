<?php if(isset($editDet)){

foreach($editDet as $edt_res){
  $portoffice_sl            = $edt_res['int_portoffice_id'];
  $portoffice_engtitle      = $edt_res['vchr_portoffice_name'];
  $portoffice_maltitle      = $edt_res['portofregistry_mal_name']; 
  $portoffice_engaddress    = $edt_res['vchr_portoffice_address'];
  $portoffice_maladdress    = $edt_res['vchr_portoffice_maladdress'];
  $portoffice_phone         = $edt_res['vchr_portoffice_phone'];
  $portoffice_email         = $edt_res['vchr_portoffice_email'];
  $portoffice_map           = $edt_res['portoffice_map'];
}
?>

      
      <div class="col-3">
          <input type="text" name="edit_ports_eng" maxlength="100" id="edit_ports_eng" class="form-control "  value="<?php echo $portoffice_engtitle;?>" onkeypress="return alpbabetspace(event);" autocomplete="off"/>
          <input type="hidden" name="id"  id="id" value="<?php echo $portoffice_sl;?>" />
          
      </div>
      <div class="col-3">
          <input type="text" name="edit_ports_mal" maxlength="100" id="edit_ports_mal" class="form-control "  value="<?php echo $portoffice_maltitle;?>" autocomplete="off"/>
      </div>
      <div class="col-3">
          <textarea name="edit_address_eng" id="edit_address_eng"><?php echo $portoffice_engaddress;?></textarea>
          
      </div>
      <div class="col-3">
          <textarea name="edit_address_mal" id="edit_address_mal"><?php echo $portoffice_maladdress;?></textarea>
      </div>
      
      <div class="col-3 pt-2 ">
          <input type="text" name="edit_ports_phone" maxlength="11" id="edit_ports_phone" class="form-control "  value="<?php echo $portoffice_phone;?>"   onkeypress="return IsNumeric(event);" autocomplete="off"  /> 
      </div>

      <div class="col-3">
        <input type="text" name="edit_ports_mail" maxlength="150" id="edit_ports_mail" class="form-control "  value="<?php echo $portoffice_email;?>" autocomplete="off" onchange="return validateEmail(this.value);"  /> 
      </div>  <!-- end of col4 -->
      <div class="col-6">
          <textarea name="edit_ports_map" id="edit_ports_map" placeholder="Enter Map coordinates"><?php echo $portoffice_map?></textarea>
      </div> 
      
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="submit" name="port_upd" id="port_upd" value="Edit Port Office" class="btn btn-info btn-flat" onclick="save_port($portoffice_sl)" />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="port_del" id="port_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_port()"  />
      </div> <!-- end of col6 -->
    
<?php } ?>