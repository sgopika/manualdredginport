<div id="tarif_updt_msgdiv" class="alert alert-success text-center" style="display: none;">Tariff Details Updated!!!</div>
<div id="tarif_del_msgdiv" class="alert alert-success text-center" style="display: none;">Tariff Details Deleted!!!</div>
<div id="tarif_exists_msgdiv" class="alert alert-danger text-center" style="display: none;">Cannot Add Tariff, Given Details Already Exists!!!</div>
<table class="table table-bordered table-striped" id="example1"><!--id="tabAjax"-->
<thead  bgcolor="f6f7f4">
  <tr>
      <th> Sl.No </th>
      <th> Tonnage Type </th>
      <th> From Ton</th>
      <th> To Ton</th>
      <th> From Day</th>
      <th> To Day</th>
      <th> Amount </th>
      <th> Min. Amount</th>
      <th> Fine Amount</th>
      <th> </th>
      <th> </th>  
  </tr>
</thead>

<tbody>
      <?php 
            $i=1;foreach ($tariffTable as $tariffDet) { 
            $id=$tariffDet['tariff_sl'];

            $tariff_from_ton=$tariffDet['tariff_from_ton'];
            if($tariff_from_ton==123456789)
            {
               $tariff_from_ton=" - ";
            }

            $tariff_to_ton=$tariffDet['tariff_to_ton'];
            if($tariff_to_ton==123456789)
            {
               $tariff_to_ton=" - ";
            }


            $tariff_from_day=$tariffDet['tariff_from_day'];
            if($tariff_from_day==123456789)
            {
               $tariff_from_day=" - ";
            }

            $tariff_to_day=$tariffDet['tariff_to_day'];
            if($tariff_to_day==123456789)
            {
               $tariff_to_day=" - ";
            }

            $tariff_amount=$tariffDet['tariff_amount'];

            $tariff_min_amount=$tariffDet['tariff_min_amount'];
            if($tariff_min_amount==0)
            {
               $tariff_min_amount=" - ";
            }

            $tariff_fine_amount=$tariffDet['tariff_fine_amount'];
            if($tariff_fine_amount==0)
            {
               $tariff_fine_amount=" - ";
            }

            $tariff_tonnagetype=$tariffDet['tariff_tonnagetype_id'];

            $helperTonnageName=$this->Master_model->get_tonnage_typeHelper($tariff_tonnagetype);
            $tonnageName=$helperTonnageName[0]['tonnagetype_name'];

      ?>               
                  
  <tr id="view_tr_<?php echo $i;?>">
      <td> <?php echo $i; ?></td>

      <td> <?php echo $tonnageName; ?></td>

      <td> <?php echo $tariff_from_ton; ?>
      <input type="hidden" name="hidden_from_ton_<?php echo $i;?>" id="hidden_from_ton_<?php echo $i;?>"  value="<?php echo $tariffDet['tariff_from_ton']; ?>">
      </td>

      <td> <?php echo $tariff_to_ton; ?>
      <input type="hidden" id="hidden_to_ton_<?php echo $i;?>" name="hidden_to_ton_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_to_ton']; ?>">
      </td>

     
      <td> <?php echo $tariff_from_day; ?>
      <input type="hidden"  id="hidden_from_day_<?php echo $i;?>" name="hidden_from_day_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_from_day'] ?>">
      </td>

      <td> <?php echo $tariff_to_day; ?>
      <input type="hidden" id="hidden_to_day_<?php echo $i;?>" name="hidden_to_day_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_to_day']; ?>">
      </td>

      <td> <?php echo $tariff_amount; ?>
      <input type="hidden" class="form-control" id="hidden_amount_<?php echo $i;?>" name="hidden_amount_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_amount']; ?>">
      </td>

      <td> <?php echo $tariff_min_amount; ?>
      <input type="hidden" class="form-control" id="hidden_min_amount_<?php echo $i;?>" name="hidden_min_amount_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_min_amount']; ?>">
      </td>

      <td> <?php echo $tariff_fine_amount; ?>
      <input type="hidden" class="form-control" id="hidden_fine_amount_<?php echo $i;?>" name="hidden_fine_amount_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_fine_amount']; ?>">
      <input type="hidden" class="form-control" id="hidden_tonnagetype_id_<?php echo $i;?>" name="hidden_tonnagetype_id_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_tonnagetype_id']; ?>">
      <input type="hidden" class="form-control" id="hidden_day_type_<?php echo $i;?>" name="hidden_day_type_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_day_type']; ?>">
      </td>

      <td>  
     	<button name="edit_tariff_btn_<?php echo $i;?>" id="edit_tariff_btn_<?php echo $i;?>" type="button" class="btn btn-sm bg-green btn-flat" onclick="edit_tariff_inline(<?php echo $i;?>,<?php echo $id;?>);" >   <i class="fas fa-pencil-alt"></i> </button>    
      </td>

      <td>  
      	<button name="delete_tariff_btn_<?php echo $i;?>" id="delete_tariff_btn_<?php echo $i;?>" type="button" class="btn btn-sm bg-red btn-flat" onclick="delete_tariff_inline(<?php echo $i;?>,<?php echo $id;?>);" >   <i class="fas fa-trash-alt"></i>  </button>
       </td>
  </tr>

  <tr id="edit_tr_<?php echo $i;?>" style="display: none;">
      <td> <?php echo $i; ?></td>

      <td> <?php echo $tonnageName; ?></td>
      
      <td> 
      	<?php if($tariffDet['tariff_from_ton']!=123456789) {?>
      	<input type="text" class="form-control" id="edit_tariff_from_ton_<?php echo $i;?>" name="edit_tariff_from_ton_<?php echo $i;?>" value="<?php echo $tariff_from_ton; ?>"><span style="color: red;">*</span>
      	<?php } else { echo $tariff_from_ton; ?>
      	<input type="hidden" name="edit_tariff_from_ton_<?php echo $i;?>" id="edit_tariff_from_ton_<?php echo $i;?>"  value="<?php echo $tariffDet['tariff_from_ton']; ?>">
      	<?php } ?>
      	<div id="valMsg_fromTon_edit_<?php echo $i;?>" style="display:none"><font color='red'>From Ton Required!!</font></div>
      	<div id="numvalMsg_fromTon_edit_<?php echo $i;?>" style="display:none"><font color='red'>Only Numbers allowed in From Ton!!</font></div>
      </td>

      <td> 
      	<?php if($tariffDet['tariff_to_ton']!=123456789) {?>
      	<input type="text" class="form-control" id="edit_tariff_to_ton_<?php echo $i;?>" name="edit_tariff_to_ton_<?php echo $i;?>" value="<?php echo $tariff_to_ton; ?>"><span style="color: red;">*</span>
      	<?php } else { echo $tariff_to_ton;  ?>
      	<input type="hidden" id="edit_tariff_to_ton_<?php echo $i;?>" name="edit_tariff_to_ton_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_to_ton']; ?>">
      	<?php } ?>
      	<div id="valMsg_toTon_edit_<?php echo $i;?>" style="display:none"><font color='red'>To Ton Required!!</font></div>
      	<div id="numvalMsg_toTon_edit_<?php echo $i;?>" style="display:none"><font color='red'>Only Numbers allowed in To Ton!!</font></div>
      </td>

     
      
      <td> 
      	<?php if($tariffDet['tariff_from_day']!=123456789) {?>
      	<input type="text" class="form-control" id="edit_tariff_from_day_<?php echo $i;?>" name="edit_tariff_from_day_<?php echo $i;?>" value="<?php echo $tariff_from_day; ?>"><span style="color: red;">*</span>
      	<?php } else { echo $tariff_from_day; ?>
      	<input type="hidden"  id="edit_tariff_from_day_<?php echo $i;?>" name="edit_tariff_from_day_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_from_day'] ?>">
      	<?php  } ?>
      	<div id="valMsg_fromDay_edit_<?php echo $i;?>" style="display:none"><font color='red'>From Day Required!!</font></div>
      	<div id="numvalMsg_fromDay_edit_<?php echo $i;?>" style="display:none"><font color='red'>Only Numbers allowed in From Day!!</font></div>
      </td>

      <td> 
      	<?php if($tariffDet['tariff_to_day']!=123456789) {?>
      	<input type="text" class="form-control" id="edit_tariff_to_day_<?php echo $i;?>" name="edit_tariff_to_day_<?php echo $i;?>" value="<?php echo $tariff_to_day; ?>"><span style="color: red;">*</span>
      	<?php } else { echo $tariff_to_day;  ?>
      	<input type="hidden" class="form-control" id="edit_tariff_to_day_<?php echo $i;?>" name="edit_tariff_to_day_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_to_day']; ?>">
      	<?php } ?><div id="valMsg_toDay_edit_<?php echo $i;?>" style="display:none"><font color='red'>To Day Required!!</font></div>
      	<div id="numvalMsg_toDay_edit_<?php echo $i;?>" style="display:none"><font color='red'>Only Numbers allowed in To Day!!</font></div>
      </td>
      
      <td> 
      	<?php if($tariffDet['tariff_amount']!=0) {?>
      	<input type="text" class="form-control" id="edit_tariff_amount_<?php echo $i;?>" name="edit_tariff_amount_<?php echo $i;?>" value="<?php echo $tariff_amount; ?>"><span style="color: red;">*</span>
      	<?php } else { echo $tariff_amount;  ?>
      	<input type="hidden" class="form-control" id="edit_tariff_amount_<?php echo $i;?>" name="edit_tariff_amount_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_amount']; ?>">
      	<?php } ?>
      	<div id="valMsg_amt_edit_<?php echo $i;?>" style="display:none"><font color='red'>Amount Required!!</font></div>
      	<div id="numvalMsg_amount_edit_<?php echo $i;?>" style="display:none"><font color='red'>Only Numbers allowed in Amount!!</font></div>
      </td>

      <td> <?php if($tariffDet['tariff_min_amount']!=0) {?>
      	<input type="text" class="form-control" id="edit_tariff_min_amount_<?php echo $i;?>" name="edit_tariff_min_amount_<?php echo $i;?>" value="<?php echo $tariff_min_amount; ?>"><span style="color: red;">*</span>
      	<?php } else { echo $tariff_min_amount; ?>
      	<input type="hidden" class="form-control" id="edit_tariff_min_amount_<?php echo $i;?>" name="edit_tariff_min_amount_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_min_amount']; ?>">
      	<?php } ?>
      	<div id="valMsg_minAmt_edit_<?php echo $i;?>" style="display:none"><font color='red'>Minimum Amount Required!!</font></div>
      	<div id="numvalMsg_minamount_edit_<?php echo $i;?>" style="display:none"><font color='red'>Only Numbers allowed in Minimum Amount!!</font></div>
      </td>
      
      <td> <?php if($tariffDet['tariff_fine_amount']!=0) {?>
      	<input type="text" class="form-control" id="edit_tariff_fine_amount_<?php echo $i;?>" name="edit_tariff_fine_amount_<?php echo $i;?>" value="<?php echo $tariff_fine_amount; ?>"><span style="color: red;">*</span>
      	<?php } else { echo $tariff_fine_amount; ?>
      	<input type="hidden" class="form-control" id="edit_tariff_fine_amount_<?php echo $i;?>" name="edit_tariff_fine_amount_<?php echo $i;?>" value="<?php echo $tariffDet['tariff_fine_amount']; ?>">
      	<?php } ?>
      	<div id="valMsg_fineAmt_edit_<?php echo $i;?>" style="display:none"><font color='red'>Fine Amount Required!!</font></div>
      	<div id="numvalMsg_fineamount_edit_<?php echo $i;?>" style="display:none"><font color='red'>Only Numbers allowed in Minimum Amount!!</font></div>
      </td>

      <td>  <button name="save_tariff_btn_<?php echo $i;?>" id="save_tariff_btn_<?php echo $i;?>" class="" type="button"  onclick="save_tariff_inline(<?php echo $i;?>,<?php echo $id;?>);" >  <i class="fas fa-pencil-alt"></i> </button> </td>

      <td>  
     <button name="cancel_tariff_btn_<?php echo $i;?>" id="cancel_tariff_btn_<?php echo $i;?>" class="" type="button" onclick="cancel_tariff_inline(<?php echo $i;?>,<?php echo $id;?>);" >  <i class="fas fa-trash-alt"></i> </button>  </td>     
      
  </tr>

      <?php $i++;}  ?>
 </tbody>

 <tfoot  bgcolor="f6f7f4">
  <tr>
      <th> Sl.No </th>
      <th> Tonnage Type </th>
      <th> From Ton</th>
      <th> To Ton</th>
      <th> From Day</th>
      <th> To Day</th>
      <th> Amount </th>
      <th> Min. Amount</th>
      <th> Fine Amount</th>
      <th> </th>
      <th> </th>  
  </tr>
</tfoot>             
</table>