 <select class="form-control select2" name="engine_type_id[]" id="engine_type_id" required="required">
                  <option value="">Select</option>
                         <?php
                    foreach ($engine_type as $res_engine_type)
                   {
                        ?>
                     <option value="<?php echo $res_engine_type['enginetype_sl']; ?>"> <?php echo $res_engine_type['enginetype_name']; ?>  </option>
                    <?php
                   }
                    ?>
                </select>