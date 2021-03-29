<select class="form-control select2 div200" name="propulsion_material_id[]" id="propulsion_material_id" required="required">
                   
                         <?php
                    foreach ($propulsionshaft_material as $res_material)
                   {
                        ?>
                     <option value="<?php echo $res_material['propulsionshaft_material_sl']; ?>"> <?php echo $res_material['propulsionshaft_material_name']; ?>  </option>
                    <?php
                   }
                    ?>
                </select>