<?php 
if(isset($ownerDet_rws)){ 
?>
<input type="hidden" class="form-control" id="profile_status" name="profile_status" value="<?php echo $ownerDet_rws;?>">
<?php
  if($ownerDet_rws>0){ 
    foreach($ownerDet as $owner){
        $own_id        = $owner['user_master_id'];
        $own_name      = $owner['user_name'];
        $own_address   = $owner['user_address'];
    } 
?>
  <div class="row no-gutters eventab">
    <div class="col-6 px-2 py-2"><font color="blue"><strong>The Buyer <?php echo $own_name; ?> is a Registered Vessel Owner!!!</strong></font><input type="hidden" class="form-control" id="buyer_id" name="buyer_id" value="<?php echo $own_id;?>">
    </div>
  </div> 
  <div class="row no-gutters oddtab">
    <div class="col-3 px-2 py-2"> Declaration of Buyer</div>
      <div class="col-3 px-2 py-2"> 
        <input type="file" name="buyer_decl_upload" id="buyer_decl_upload" >
      </div>
  </div> <!-- end of row -->
  <div class="row no-gutters eventab">
    <div class="col-3 px-2 py-2">Declaration of Seller</div>
      <div class="col-3 px-2 py-2"> 
        <input type="file" name="seller_decl_upload" id="seller_decl_upload" >
      </div>
    </div>
  </div>
  <div class="row no-gutters oddtab">
    <div class="col-3 px-2 py-2">Notary Attested Copy</div>
      <div class="col-3 px-2 py-2"> 
        <input type="file" name="notary_upload" id="notary_upload" >
      </div>
    </div>
  </div>

<?php
  } else {
?>
  <div class="row no-gutters eventab">
    <div class="col-6 px-2 py-2"><font color="red"><strong>The Buyer is not a Registered Vessel Owner!!!!!!</strong></font>
    </div>
  </div> 
  <div class="row no-gutters oddtab">
    <div class="col-3 px-2 py-2"> Buyer Name</div>
      <div class="col-3 px-2 py-2"> 
        <input type="text" class="form-control" id="buyer_name" name="buyer_name" placeholder="Name of Buyer" data-validation="required"  required="required">
      </div>
  </div> <!-- end of row -->
  <div class="row no-gutters eventab">
    <div class="col-3 px-2 py-2">Buyer Address</div>
      <div class="col-3 px-2 py-2"> 
        <textarea class="form-control" id="buyer_address" name="buyer_address" placeholder="Address of Buyer" data-validation="required" onkeypress="return IsAddress(event);" required="required"></textarea>
      </div>
    </div>
  </div>
  <div class="row no-gutters oddtab">
    <div class="col-3 px-2 py-2">ID Card of Buyer</div>
      <div class="col-3 px-2 py-2"> 
        <input type="file" name="idcard_upload" id="idcard_upload" />
      </div>
    </div>
  </div>



  
<?php
  }
?>

<?php 
} ?>
