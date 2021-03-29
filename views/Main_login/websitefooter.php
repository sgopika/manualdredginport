<!-- Footer TAB  -->
<div class="row ">
<?php if(isset($footer)){  foreach($footer as $footer_res){ $foot_sl = $footer_res['bodycontent_sl']; $foot_title = $footer_res['bodycontent_engtitle']; $foot_maltitle= $footer_res['bodycontent_maltitle']; ?>
<div class="port-content-footer col-6 footer_heading">
	<div class="footer-col palefont">
		<p class="palefont footer_link mtitlefont"> <?php if(isset($val)){ echo $foot_maltitle; } else {echo $foot_title;}?> </p>
		<?php $footer_item_list  =  $this->Main_login_model->get_active_footer_item($foot_sl); 
		foreach($footer_item_list as $footer_item_list_res){
			$footitem_sl = $footer_item_list_res['bodycontent_sl']; $footitem_title = $footer_item_list_res['bodycontent_engtitle']; $footitem_maltitle= $footer_item_list_res['bodycontent_maltitle'];$footer_item_link= $footer_item_list_res['bodycontent_link'];
				if(isset($val)){ $id="1";} else { $id="2";}
			?>
		<a href="<?php echo base_url()."index.php/Main_login/footer_item_desc/$id/$footitem_sl"?>" ><p class="palefont mcontentfont footer_link" ><?php if(isset($val)){ echo $footitem_maltitle; } else {echo $footitem_title;}?></p></a>
	<?php }?>
	</div>	
</div>	

<?php }}?>


<div class="col-12 port-content-footer footer-col text-center mcontentfont">
<p class="palefont"><?php if(isset($val)){if($val==1){?> പകര്‍പ്പവകാശം @ കേരള മാരിടൈം ബോർഡ് &nbsp; &nbsp; &nbsp; രൂപകല്പനയും സാങ്കേതിക സഹായവും: സി-ഡിറ്റ് <?php } else {?>Copyright @ Kerala Martime Board &nbsp; &nbsp; &nbsp; Designed and Developed by C-DIT  <?php } } else {?> Copyright @ Kerala Martime Board &nbsp; &nbsp; &nbsp; Designed and Developed by C-DIT <?php }?> </p>
</div>
</div> <!-- end of footer row -->
<!--  End of Footer TAB  -->
</div> <!-- end of container fluid  -->  
<!--  inside container fluid to be closed in website-footer.php ends here  -->
