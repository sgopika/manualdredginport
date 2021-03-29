 <select class="form-control select2 div200" name="engine_placement_id[]" id="engine_placement_id" required="required">
                         <option value="">Select</option>
                    <?php
                    foreach ($inboard_outboard as $res_inboard_outboard)
                   {
                        ?>
                     <option value="<?php echo $res_inboard_outboard['inboard_outboard_sl']; ?>"> <?php echo $res_inboard_outboard['inboard_outboard_name']; ?>  </option>
                    <?php
                   }
                    ?>
                
                </select>