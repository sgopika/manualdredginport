 <select class="form-control select2 div200" name="gear_type_id[]" id="gear_type_id" required="required">
                 
                    <option value="">Select</option>
                         <?php
                    foreach ($gear_type as $res_gear_type)
                   {
                        ?>
                     <option value="<?php echo $res_gear_type['geartype_sl']; ?>"> <?php echo $res_gear_type['geartype_name']; ?>  </option>
                    <?php
                   }
                    ?>
                </select>