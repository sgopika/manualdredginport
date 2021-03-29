<option value="">select</option>

<?php

foreach($zone as $z)

{
if($z['zone_id']!=26){
	?>

    <option value="<?php echo $z['zone_id'];?>"><?php echo $z['zone_name']; ?></option>

    <?php
}

}

?>