 <select class="form-control select2 div200" name="engine_model_id[]" id="engine_model_id" required="required">
                         <option value="">Select</option>
                         <?php
                    foreach ($model_number as $res_model_number)
                   {
                        ?>
                     <option value="<?php echo $res_model_number['modelnumber_sl']; ?>"> <?php echo $res_model_number['modelnumber_name']; ?>  </option>
                    <?php
                   }
                    ?>
                         
                 
                </select>