<?php
if(isset($district))
{  
?>
		  <option value="">Select</option>
		  <?php foreach ($district as $result) { ?>
		  <option value="<?php echo $result['district_code'];?>"><?php echo $result['district_name'];?></option>
		  <?php } ?>

<?php }   ?> 