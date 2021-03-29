<?php
 
 for($i=1; $i<=$number;$i++)
        {
?> 
<tr>
            <td colspan="2"> Bulk head placement</td>
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" name="bulk_head_placement[]" id="bulk_head_placement">
                  <option value="">Select</option>
                <?php foreach ($bulk_head_placement as $res_bulkhead)
						{
					?>
               <option value="<?php echo $res_bulkhead['bulkhead_placement_sl']; ?>"> <?php echo $res_bulkhead['bulkhead_placement_name'];?>  </option>
                <?php
						}	?>
                
                </select>
              </div>
             
           </td>
            <td> Bulk head thickness</td>
            <td> <div class="div100"> <div class="input-group">
            <input type="text" name="bulk_head_thickness[]" value="" id="bulk_head_thickness"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">mm</span> 
            </div> </div></td>
</tr>

<?php
        }
        ?>