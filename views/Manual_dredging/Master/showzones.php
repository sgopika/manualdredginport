<option value="">select</option>

<?php

foreach($zone as $z)

{

if($z['zone_id']!=26){//-----on 25/09/18. enable on 17/12/18

	?>

	 <option value="<?php echo $z['zone_id'];?>"><?php echo $z['zone_name']; ?></option>

    <?php

	}

}

?>