<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Edit Tariff</h4>
	      </div>
	      <div class="modal-body">
	        <form action="<?php echo base_url('Master/editTariff_popup'); ?>" method="post">
	        	<input type="hidden" name="eid" id="eid">
			  <div class="form-group">
			    <label for="Materials Name">Materials Name: </span></label>
			    <select class="form-control" id="materials_name" onchange="get_qty_val(this.value)">
					<!-- <optgroup> -->
						<option value="">Change  Materials</option>
						<?php //foreach($lib as $val){ ?>
						<option value="<?php //echo $val['id'];?>"><?php //echo $val['material_name'];?></option>
						<?php } ?>
					<!-- </optgroup> -->
				</select>
			  </div>
			  <div class="form-group">
			    <label for="Quantity">Change Quantity:</label>
			    <input type="text" class="form-control" id="quantity">
			  </div>
			  <div class="form-group">
			    <label for="Price">Price:</label>
			    <input type="text" class="form-control" id="m_price">
			  </div>
			  <div class="form-group">
			    <label for="discountprice">Discountprice Price:</label>
			    <input type="number" class="form-control discountprice" id="dis_price">
			  </div>
			  <div class="form-group">
			    <label for="Total">Total Price:</label>
			    <input type="text" class="form-control totalvalue" id="total_price">
			  </div>
			  <button type="button" onclick="material_update()" class="btn btn-info">Submit</button>
			</form>
	      </div>
	    </div>
	</div>
</div>