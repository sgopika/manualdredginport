<?php
$zone_in=$zones[0]['zoneid'];
$zn=explode(',',$zone_in);
//print_r($zn);
$flg=0;
foreach($zone as $z)
{
	if(in_array($z['zone_id'],$zn))
	{
		
	}
	else
	{
		$flg=1;
	?>
        <input type="checkbox" name="vch_material_amt_zone[]" value="<?php echo $z['zone_id'];?>" id="vch_designation_name"   />&nbsp;<?php  echo $z['zone_name']." ,";?>
        <?php
	}
}
if($flg==0)
{
	echo "no zones left";
}
?>
