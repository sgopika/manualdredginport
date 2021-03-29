<table id="example1" class="table table-bordered table-striped">
      <thead>
          <tr>
            <th>Sl.No</th>
            <th>Vessel Type Name</th>
            <th>Vessel Sub Type Name</th>
            <th>Hull Material</th>
            <th>Length Over the Deck</th>
            <th>Inboard/Outboard</th>
            <th>Form Name</th>
            <th>Heading Name</th>
            <th>Date</th>
            <th></th>            
          </tr>
      </thead>

      <tbody>
         <?php $i=1; foreach ($dataList as $dynamic_value) {
               $id=$dynamic_value['dynamic_field_sl'];
               $head_id=$dynamic_value['heading_id'];
               $vess_id=$dynamic_value['vesseltype_id'];
               $vess_sub_id=$dynamic_value['vessel_subtype_id'];
               $length_over_deck=$dynamic_value['length_over_deck'];
               $hullmaterial_id=$dynamic_value['hullmaterial_id'];
               $engine_inboard_outboard=$dynamic_value['engine_inboard_outboard'];
               $form_id=$dynamic_value['form_id'];
               $start_date=$dynamic_value['start_date'];
               $end_date=$dynamic_value['end_date'];

               $start_date_view  = explode('-', $start_date);
               $start_date_view  = $start_date_view[2]."/".$start_date_view[1]."/".$start_date_view[0];

               $end_date_view  = explode('-', $end_date);
               $end_date_view  = $end_date_view[2]."/".$end_date_view[1]."/".$end_date_view[0];
         ?>
           
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $dynamic_value['vesseltype_name']; ?></td>
            <td><?php echo $dynamic_value['vessel_subtype_name']; ?></td>
            <td><?php if($dynamic_value['hullmaterial_id']==9999){echo "All";}else{echo $dynamic_value['hullmaterial_name'];} ?></td>
            <td><?php echo $dynamic_value['length_over_deck']; ?></td>
            <td><?php if($dynamic_value['engine_inboard_outboard']==9999){echo "All";}else{echo $dynamic_value['inboard_outboard_name'];} ?></td>
            <td><?php echo $dynamic_value['document_type_name']; ?></td>
            <td><?php echo $dynamic_value['heading_name']; ?></td>
            <?php if($dynamic_value['end_date']=='0000-00-00'){$msg="dd/mm/yyyy";}else{$msg=$end_date_view;} ?>
            <td><?php echo "From ".$start_date_view." To ".$msg; ?><input type="hidden" name="hid_startDate" id="hid_startDate" value="<?php echo $start_date; ?>"><input type="hidden" name="hid_endDate" id="hid_endDate" value="<?php echo $end_date; ?>"></td>  
            <td><button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $dynamic_value['status'];?>);"> <i class="fa fa-fw fa-copy (alias)"></i>  </button></td>                 

          </tr>

        <?php $i++;} ?>

      </tbody>
                
      <tfoot>
          <tr>
            <th>Sl.No</th>
            <th>Vessel Type Name</th>
            <th>Vessel Sub Type Name</th>
            <th>Hull Material</th>
            <th>Length Over the Deck</th>
            <th>Inboard/Outboard</th>
            <th>Form Name</th>
            <th>Heading Name</th>
            <th>Date</th>  
            <th></th>                  
          </tr>
      </tfoot>


</table>