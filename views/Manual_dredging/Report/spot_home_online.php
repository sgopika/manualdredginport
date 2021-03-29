 <script>

$(function($) {

    // this script needs to be loaded on every page where an ajax POST may happen

    $.ajaxSetup({

        data: {

            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'

        }

    }); 

});

</script>
<script>
document.onkeydown = function(e) {
if(event.keyCode == 123) {
return false;
}
if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'H'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'A'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'F'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
return false;
}
}
</script>
<script>
/* To Disable Inspect Element */
$(document).bind("contextmenu",function(e) {
 e.preventDefault();
});

$(document).keydown(function(e){
    if(e.which === 123){
       return false;
    }
});
</script>


    <body>
<section class="login-block">
	<div class="container">
		<div class="row">
    <div class="col">      <img src="<?php echo base_url(); ?>plugins/img/logo.png"  alt="PortInfo">
    </div>
     <div class="col-4 border-left pb-2">
      <i class="fas fa-user-plus mt-5 text-primary"></i> <font class="text-primary"> 
      	<span class="eng-content"> Spot Booking  </span><br>
      	<span class="mal-content mal_content_reg">   സ്പോട്ട്  ബുക്കിംഗ്  </span> </font>  <hr>
     <!--  <button type="button" class="btn btn-primary btn-point btn-flat eng-content" id="mal-button" >Malayalam</button>
      <button type="button" class="btn btn-primary btn-point btn-flat mal-content" id="eng-button">English</button> -->
    </div> 
 </div>


      <!-- Info boxes -->

        <p>
        <marquee style="color:#FF0000">

        ** ONLINE SPOT BOOKING FACILITY AVAILABLE BETWEEN  <b>11:30 AM  TO 4:30 PM  </b>||**<b>പൊന്നാനി പോർട്ടിലെ ബുക്കിംഗ്  സംവിധാനം (16-10-2019) മുതൽ  ഈ  വെബ്‌സൈറ്റിയിൽ  ഉണ്ടായിരിക്കുന്നതല്ല .</b>||***** സ്പോട്ട്  ബുക്കിംഗ്  നടത്തുന്നവർ  അതാതു  കടവുകളിലെ  മണൽ  പരിശോധിച്ച്  ഉപയോഗക്ഷമത  ഉറപ്പു വരുത്തേണ്ടതാണ്.||***** സ്പോട്ട് ബുക്കിംഗ് നടത്തുന്ന ഉപഭോക്താക്കൾ തങ്ങൾക്ക് അനുവദിക്കുന്ന തീയതിയിൽ തന്നെ മണൽ എടുക്കേണ്ടതാണ്.  ഒരു ബുക്കിംഗിന്  ഒരു പ്രാവശ്യം മാത്രമേ തീയതി അനുവദിക്കുകയുള്ളൂ.||*****ഡോർ ഡെലിവറി സംവിധാനത്തിൽ ബുക്ക് ചെയ്ത ഉപഭോക്താവ് മണലെടുക്കാൻ വാഹനം കൊണ്ടുവരേണ്ടതില്ല.

        </marquee>
        </p>

      <!-- /.row -->

 			<h2 class="box-title" align="center">Spot Booking Online </h2>
       <a style="width: 120px;margin: 15px 0px 8px 0px;" align="left" href="<?php echo base_url(); ?>" class="btn btn-secondary" >Home</a>
 			<hr>
 			<br>



      <div class="row">

        <div class="col-md-12">

          <div class="box">

           

            <div class="box-footer">

              <div class="row">

                

                <div class="col-sm-3 col-xs-6">

                  <div class="info-box">

            <span class="info-box-icon bg-green"><i class="ion ion-ios-email"></i></span>



            <div class="info-box-content">

              <span class="info-box-number">

			 <?php  $bookingtime_data= $this->Master_model->customerspotbooking_timecheck();

			$starttime=$bookingtime_data[0]['spotbooking_master_start'];

			$endtime=$bookingtime_data[0]['spotbooking_master_end'];

			$start_time=strtotime($starttime);

			$end_time=strtotime($endtime);

			//echo date_default_timezone_get();

			//echo date('Y-M-d h:i:s');

			//exit;

			$current_time=strtotime("now");

		if($current_time >= $start_time && $current_time <= $end_time)

		{ 
			$today=date('Y-m-d');		
			$url=site_url("Manual_dredging/Report/add_spot_registrationpayment");
	
		}
		else
		{
			$url='#';
		}?>

			  <a class="btn btn-primary" href="<?php echo $url;?>">Spot Registration</a></span>

            </div>

            <!-- /.info-box-content -->

          </div>

          <!-- /.info-box -->

                </div>
                
                

              

                <div class="col-sm-3 col-xs-5">

                  <div class="info-box">

            <span class="info-box-icon bg-orange"><i class="ion ion-ios-calendar"></i></span>



            <div class="info-box-content">

			<?php $today=date('d-m-Y');?>

              <span class="info-box-number"><a class="btn btn-primary" href="<?php echo site_url("Manual_dredging/Report/spot_status"); ?>">Booking Limit <br>[<?php echo $today?>]</a></span>

            </div>

            <!-- /.info-box-content -->

          </div>

          <!-- /.info-box -->

                </div>

                
 <div class="col-sm-3 col-xs-5">

                  <div class="info-box">

            <span class="info-box-icon bg-orange"><i class="ion ion-ios-calendar"></i></span>



            <div class="info-box-content">

     

            </div>

            <!-- /.info-box-content -->

          </div>

          <!-- /.info-box -->

                </div>
                

                <!-- /.col -->

                

            

                  

                <!-- /.col -->

                

                

                <!-- /.col -->

              </div>

              <!-- /.row -->

            </div>

            <!-- /.box-footer -->

          </div>

          <!-- /.box -->

        </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

      <!--- CHART DIVS -->

      

            

            

      <!-- CHATY DIV ENDS HERE -->

      <!-- NEXT MAIN DIV --->

      

      <!-- /.row -->









      <!-- NEXT MAIN DIV END -->
      <br>
 <div style="background: #F8F8F8">
      <h1 align="center" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br>

         <button  class="btn btn-success btn-flat disabled" type="button" >Spot Booking Instructions</button>

      </h1>
      &nbsp;
     <p>
     
     <ul>
     <li>സ്പോട്ട് ബുക്കിംഗ് രജിസ്ട്രേഷൻ  സമയം  11:30 am   മുതൽ  4:30 PM വരെ   ആയിരിക്കും.</li>&nbsp;
     <li>ഓൺലൈൻ  പെയ്‌മെന്റ്  സംവിധാനം വഴി മാത്രമേ സ്പോട്ട് ബുക്കിങ്ങിനു പണമടയ്ക്കുവാൻ സാധിക്കുകയുള്ളു.</li>&nbsp;
    <li>
സ്പോട്ട് ബുക്കിംഗ് വഴി  മണൽ ലഭ്യമാക്കുന്നതിന്  ആധാർ നിർബന്ധമാണ് .</li> &nbsp;
     <li>
സ്പോട്ട് ബുക്കിങിൽ  സമയത്തു നൽകുന്ന ആധാർ തന്നെ ആയിരിക്കണം മണൽ എടുക്കുന്ന സമയത്തു കൊണ്ടുവരേണ്ടത് അല്ലാത്ത പക്ഷം ആ ബുക്കിംഗ് നിരസിക്കുന്നത് .</li>&nbsp;
    <li>
ഏതെങ്കിലും കാരണവശാൽ സ്പോട്ട്  ബുക്കിംഗ് നിരസിക്കുകയാണെക്കിൽ  500 രൂപ കുറച്ച് ബാക്കി  തുക മാത്രമേ തിരികെ ലഭിക്കുകയുള്ളൂ .</li>&nbsp;
    <li>
തിരികെ തുക ലഭ്യമാക്കുന്നതിന് അതാത് പോർട്ട് ഓഫീസിൽ അപേക്ഷ നൽകേണ്ടതാണ് .</li>&nbsp;
    <li>പോർട്ട് ഓഫീസർ അപേക്ഷ പരിശോധിച്ചതിനു ശേഷം അർഹമായ തുക ഉപഭോക്താവ് ടി തുക അടയ്ക്കുന്നതിന് ഉപയോഗിച്ച അക്കൗണ്ടിലേക്ക് നിക്ഷേപിക്കുന്നതാണ്.</li>&nbsp;
    
    <li><font color="#DF1D20">സ്പോട്ട് ബുക്കിംഗ് വഴി മണൽ ലഭ്യമാക്കുന്നതിന് നൽകുന്ന  മൊബൈൽ  നമ്പർ, ഒരിക്കൽ അപേക്ഷിച്ചു  കഴിഞ്ഞാൽ പിന്നെ അതെ മൊബൈൽ നമ്പർ 2 ദിവസത്തിന് ശേഷം മാത്രമേ നൽകാൻ പാടുള്ളു അല്ലാത്ത പക്ഷം അപേക്ഷ നിരസിക്കുന്നതാണ് .</font></li>&nbsp;
    
    
    
    </ul>
    </p>
     	
     </div>
     


    </section>

   </body>
