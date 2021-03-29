<?php
foreach($panchayath_mal as $panch)
{
	?>
    <input type="hidden" name="int_lsgd_name" value="<?php echo $panch['panchayath_name']; ?>" />
    <input type="hidden" name="tb_lsg_id" value="<?php echo $panch['panchayath_sl']; ?>" />
    <input type="hidden" name="int_lsgd_name_mal" value="<?php echo $panch['panchayath_local']; ?>" />
    <?php

 echo $panch['panchayath_local']; 

}
?>