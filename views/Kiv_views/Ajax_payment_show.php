<?php 

if(!empty($tariff_amount))
{
	 @$amount=$tariff_amount;
}
else
{
	 $amount=0;	
}

 ?>
<div class="col-md-12 col-lg-12">
<div class="col-md-6 col-lg-6">Amount</div>

<div class="col-md-6 col-lg-6"> <div class="input-group">
    <span class="input-group-addon"><i class="fas fa-rupee-sign"></i></span> <?php echo @$amount; ?>
    <input type="hidden" class="form-control" name="dd_amount" value="<?php echo @$amount; ?>" id="dd_amount" maxlength="8" autocomplete="off"  required readonly>
    </div></div>
</div>
