<?php if(isset($editDet)){

foreach($editDet as $edt_res){
  $portservices_sl            = $edt_res['portservices_sl'];
  $portservices_port_sl       = $edt_res['portservices_port_sl'];
  $portservices_services_sl   = $edt_res['portservices_services_sl']; 
  $portservice_service_exp    = explode(',', $portservices_services_sl);
  $cnt_service                = count($portservice_service_exp);
  for($j=0;$j<$cnt_service;$j++){
    $portservice_id           = $portservice_service_exp[$j];
  }                      
}
?>

      
      <div class="col-6">
         <select name="edit_port" id="edit_port" class="form-control js-example-basic-single" style="width: 100%;">
          <option value="">Select Port </option> 
          <?php foreach($ports as $port_res){ ?>
          <option value="<?php echo $port_res['int_portoffice_id']; ?>"<?php if($port_res['int_portoffice_id']==$portservices_port_sl){?> selected=selected <?php }?>><?php echo $port_res['vchr_portoffice_name']; ?></option>
             <?php }  ?>
        </select>
          <input type="hidden" name="id"  id="id" value="<?php echo $portservices_sl;?>" />
          
      </div>
      <div class="col-6">
          <select name="edit_services[]" id="edit_services" class="form-control js-example-basic-single" style="width: 100%;" multiple="multiple">
          <option value="">Select Services </option> 
          <?php foreach($services as $service_res){ ?>
          <option value="<?php echo $service_res['services_sl']; ?>" <?php for($j=0;$j<$cnt_service;$j++){
                    $portservice_id           = $portservice_service_exp[$j];
                    if($service_res['services_sl']==$portservice_id){ ?> selected <?php } }?>><?php echo $service_res['services_engtitle']; ?></option>
          <?php }  ?>
        </select>
      </div>
      
      
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="submit" name="portservice_upd" id="portservice_upd" value="Edit Port-Service Mapping" class="btn btn-info btn-flat" onclick="save_portservice($portservices_sl)" />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="port_del" id="port_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_port()"  />
      </div> <!-- end of col6 -->
    
<?php } ?>