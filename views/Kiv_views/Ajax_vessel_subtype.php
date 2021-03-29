<?php
if(isset($vessel_subtype))
{  
?>
		  <option value="">Select</option>
		  <?php foreach ($vessel_subtype as $result) {;?>
		  <option value="<?php echo $result['vessel_subtype_sl'];?>"><?php echo $result['vessel_subtype_name'];?></option>
		  <?php } ?>

<?php }   ?> 