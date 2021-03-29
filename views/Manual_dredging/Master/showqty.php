<option value="">select</option>

<?php

if($zone_id==26)

{

?>
<option value="1">3</option>
<option value="2">5</option>

<?php

}

else

{

?>

<?php

/*if($zone_id==2)

{

	?>

    <option value="3">7</option>

    <?php

}*/

$aqt=$get_quantity_details[0]['quantity_master_id'];

$aaq=explode(',',$aqt);

//print_r($aaq);

foreach($qty as $q)

{

	$qid=$q['quantity_master_id'];

	if(in_array($qid,$aaq))

	{

?>

<option value="<?php  echo $qid;?>" ><?php  echo $q['quantity_master_name'];?></option>

<?php

	}

}

}

?>