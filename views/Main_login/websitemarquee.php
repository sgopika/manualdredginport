<div class="container-fluid">
  	<div class="marquee contentfont bg-darkslateblue text-white">
   <p> 
  	<?php if(isset($marquee)){  foreach($marquee as $marquee_res){ $mar_title = $marquee_res['webnotification_engtitle']; $mar_maltitle= $marquee_res['webnotification_maltitle']; $mar_content = $marquee_res['webnotification_engcontent']; $mar_malcontent = $marquee_res['webnotification_malcontent'];
  	 if(isset($val)){ echo $mar_maltitle; } else { echo $mar_title; }?>
              <?php }}?>
 </p>  	
  </div> <!-- end of marquee div -->
</div> <!-- end of container fluid for alerts -->
<!--Alert Marquee Section ends here -->
<!--LOGIN AND REGISTRATION TAB -->