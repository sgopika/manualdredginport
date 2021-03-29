<option value="">select</option>
<?php
foreach($getdata_userttype as $z)
{
	?>
    <option value="<?php echo $z['user_master_id'];?>"><?php echo $z['user_master_name'].'('.$z['zone_name'].')'; ?></option>
    <?php
}
?>