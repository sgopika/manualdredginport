

                <div class="form-group">
                <select class="form-control select2 div200" name="bulk_head_placement[]" id="bulk_head_placement" required="required">
                  <option value="">Select</option>
                <?php foreach ($bulk_head_placement as $res_bulkhead)
						{
					?>
               <option value="<?php echo $res_bulkhead['bulkhead_placement_sl']; ?>"> <?php echo $res_bulkhead['bulkhead_placement_name'];?>  </option>
                <?php
						}	?>
                
                </select>
              </div> 
