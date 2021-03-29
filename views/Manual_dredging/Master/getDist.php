<option value="" selected="selected">--select--</option>
            <?php foreach($district as $dist)
			{
				?>
                <option value="<?php echo $dist['district_id']; ?>"><?php echo $dist['district_name'] ?></option>
				<?php
			}
			?>