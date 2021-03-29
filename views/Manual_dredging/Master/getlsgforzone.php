 <?php
foreach($lsgd as $z)
{
?>
                <input type="hidden" name="int_lsg" value="<?php echo $z['lsgd_id'] ?>" />
<?php echo $z['lsgd_name'] ?>
                <?php
				}
				?>