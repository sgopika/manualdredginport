
<?php 
$dis_id=$this->input->post('customerwork_distid');

/*?><input type="text" name="customer_perm_pin_code" id="customer_perm_pin_code" value=" <?php foreach($getpincode_data as $permpincode){ echo $permpincode['vchr_PinCode']; } ?>" /><?php */?>
<div class="row evenrows">
          <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
		  LocalBody<font color="#FF0000">*</font></span>
		 </div>
           <div class="col-md-4 m-2">
		  <select name="customer_work_lsg_id" id="customer_work_lsg_id"   class="form-control"  >
           	 <option value="">SELECT</option>
           	<?php foreach($panchayath as $work_localbody){?>
			
			<option value="<?php  echo $work_localbody['panchayath_sl'];?>" ><?php  echo $work_localbody['panchayath_name'];?></option>
             <?php } ?>
			
              
           </select>
		  </div>
		   </div> <!-- end of row -->
           <div class="row oddrows">
           <div class="col-md-6 m-2"><span class="eng-content offset-6 text-content-left">
Post office<font color="#FF0000">*</font></span>
</div>
           <div class="col-md-4 m-2">
<select name="customer_work_post_office" id="customer_work_post_office"   class="form-control"  >
           	 <option value="">SELECT</option>
           		<?php foreach($postoffice as $work_postoff_id){?>
               	<option value="<?php  echo $work_postoff_id['PostOfficeId'];?>"><?php  echo $work_postoff_id['vchr_BranchOffice'];?></option>
             <?php } ?>
           </select>
		   
		   </div></div>
				
<script type="text/javascript">
$('#customer_work_post_office').change(function()
				{
					var customerwork_post_office=$('#customer_work_post_office').val();
					$.post("<?php echo $site_url?>/Manual_dredging/Master/getWorkPincode/",{customerwork_post_office:customerwork_post_office},function(data)
						{
						//alert(data);
						//var demo=$("#customer_work_lsg_id option :selected").text();
						//alert("dfgdfgdfgdg");
							$('#workpincodenew').html(data);
							
						});
						
				});
				$('#customer_work_lsg_id').change(function()
				{
					
						var x = document.getElementById("customer_work_lsg_id").selectedIndex;
						var y = document.getElementById("customer_work_lsg_id").options;
						var lsgname = y[x].text;
					
						document.getElementById("customer_permit_authority").value=lsgname;
						
						
				});
				</script>				
				