<option value="">select</option>
<option value="0">All Zones</option>
<?php
foreach($zone as $z)
{
	?>
    <option value="<?php echo $z['zone_id'];?>"><?php echo $z['zone_name']; ?></option>
    <?php
}
?>