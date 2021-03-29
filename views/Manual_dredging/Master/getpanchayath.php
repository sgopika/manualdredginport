<option selected value="">select</option>
<?php
foreach($panchayath as $panch)
{
?>
<option value="<?php echo $panch['panchayath_name']; ?>"><?php echo $panch['panchayath_name']; ?></option>
<?php
}
?>