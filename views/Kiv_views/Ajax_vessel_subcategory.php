<?php
if(isset($vessel_subcategory))
{  
?>
		  <option value="">Select</option>
		  <?php foreach ($vessel_subcategory as $result) {;?>
		  <option value="<?php echo $result['vessel_subcategory_sl'];?>"><?php echo $result['vessel_subcategory_name'];?></option>
		  
		  <?php } ?>

<?php }   ?> 