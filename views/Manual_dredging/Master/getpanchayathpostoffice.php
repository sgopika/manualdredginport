<?php 
$dis_id=$this->input->post('customer_perm_distid');

/*?><input type="text" name="customer_perm_pin_code" id="customer_perm_pin_code" value=" <?php foreach($getpincode_data as $permpincode){ echo $permpincode['vchr_PinCode']; } ?>" /><?php */?>
<div class="row oddrows">
          <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
LocalBody<font color="#FF0000">*</font></span>
</div>
           <div class="col-md-4 m-2">
<select name="customer_perm_lsg_id" id="customer_perm_lsg_id"   class="form-control"  >
           	 <option value="">SELECT</option>
           	<?php foreach($panchayath as $perm_localbody){?>
			
			<option value="<?php  echo $perm_localbody['panchayath_sl'];?>" ><?php  echo $perm_localbody['panchayath_name'];?></option>
             <?php } ?>
			
              
           </select>
		   </div>
		   </div> <!-- end of row -->
           <div class="row evenrows">
           <div class="col-md-6 m-2">
           	<span class="eng-content offset-6 text-content-left">
Post office<font color="#FF0000">*</font></span>
</div>
           <div class="col-md-4 m-2">
<select name="customer_perm_post_office" id="customer_perm_post_office"   class="form-control"  >
           	 <option value="">SELECT</option>
           		<?php foreach($postoffice as $perm_postoff_id){?>
               	<option value="<?php  echo $perm_postoff_id['PostOfficeId'];?>"><?php  echo $perm_postoff_id['vchr_BranchOffice'];?></option>
             <?php } ?>
           </select>
		   </div></div>
				
<script type="text/javascript">
$('#customer_perm_post_office').change(function()
				{
					var customerperm_post_office=$('#customer_perm_post_office').val();
					
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getPermPincode/",{custmer_perm_postoff:customerperm_post_office},function(data)
						{
								$('#permpincode').html(data);
						});
				});
</script>				
				