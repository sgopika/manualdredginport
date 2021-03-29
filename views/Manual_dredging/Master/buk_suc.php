<script>

$(document).ready(function() {

        window.history.pushState(null, "", window.location.href);        

        window.onpopstate = function() {

            window.history.pushState(null, "", window.location.href);

        };

    });

</script>

<script>

function getprint()

{

	window.print();

	window.location="<?php echo site_url('Manual_dredging/Master/customer_home');?>";

}

</script>

<div class="container-fluid ui-innerpage">
     <div class="row py-3">
       
    
     <div class="col-12 d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url("Manual_dredging/Master/customer_home"); ?>"> Home</a></li>
      
       
      </ol>
</div>

   
    </div> <!-- end of row -->  

   

    <!-- Main content -->

   

      <div class="row" align="center">

        <div class="col-12">

          <!-- /.box -->

      

        <?php if(isset($suc)){ 

		

		?>

		   	<div class="alert alert-success text-center"><?php echo $suc;?> </div>

          <?php    

		   }?>

           </div>
         </div>

		  

            

        <div class="row">

            <div class="col-12 ">

              <h3 class="box-title"><strong>Sand Booking Details</strong></a></h3>

            </div>

           

            <table id="vacbtable" class="table table-bordered table-striped">

			<tr>

            <td><i>Port</i></td><td><strong><?php echo $buk_del[0]['vchr_portoffice_name'];?></strong></td>

            </tr>

			<tr>

            <td><i>Booking Zone</i></td><td><strong><?php echo $buk_del[0]['zone_name'];?></strong></td>

            </tr>

			<tr>

            <td><i>Customer Name</i></td><td><strong><?php echo $buk_del[0]['customer_name'];?></strong></td>

            </tr>

            <tr>

            <td><i>Customer Registration No</i></td><td><strong><?php echo $buk_del[0]['customer_reg_no'];?></strong></td>

            </tr>

            <?php 

			if(isset($stat_u))

			{

			?>

            <tr>

            <td><i>പ്രതീക്ഷിക്കുന്ന മണൽ വിതരണ തീയ്യതി</i></td><td><strong><?php echo $posdate;?></strong></td>

            </tr>

            <?php

			} 

			?>

            <tr>

            <td><i>Requested Quantity in Tons</i></td><td><strong><?php echo $buk_del[0]['customer_booking_request_ton'];?></strong></td>

            </tr>

            <tr>

            <td><i>Priority No</i></td><td><strong><?php echo $buk_del[0]['customer_booking_priority_number'];?></strong></td>

            </tr>

            <tr>

            <td><i>Token No</i></td><td><strong><?php echo $buk_del[0]['customer_booking_token_number'];?></strong></td>

            </tr>

			 <tr>

            <td><i>Booked Date</i></td><td><strong><?php echo strtoupper(date("d-m-Y",strtotime(str_replace('-', '/',$buk_del[0]['customer_booking_requested_timestamp']))));?></strong></td>

            </tr>

            </table>

			<div>പോർട്ട് കോൺസെർവേറ്ററുടെ അനുമതി കിട്ടുന്ന മുറയ്ക്ക് SMS  മുഖേന നിങ്ങളെ തിയതി അറിയിക്കുന്നതാണ് .കൂടാതെ Customer-login-ൽ Sand Booking History വഴിയും മണൽ ലഭ്യമാക്കുന്ന തിയതി അറിയാൻ കഴിയും.

</div>

            <br/>

			<div>Sand Booking History യിൽ നിന്നും ചെല്ലാൻ ഡൌൺലോഡ് ചെയ്തു print എടുത്തതിനു ശേഷം മണൽ ലഭ്യമാക്കുന്നതിന്  അനുവദിച്ച തിയതിക്ക് മുൻപ്‌ അടുത്തുള്ള വിജയ ബാങ്കിന്റെ ശാഖയിൽ  തുക അടച്ചതിനു ശേഷം ആധാർ കാർഡ് ഉം ,ചെല്ലാൻ ഉം ആയി ബുക്ക് ചെയ്ത സോണിൽ അനുവദിച്ച തിയതിക്ക് വരേണ്ടതാണ്.        </div>

            <br>

			<div>മണൽ എടുക്കാൻ വരുന്ന ആളുടെ സ്വയം സാക്ഷ്യപ്പെടുത്തിയ  ആധാർ കാർഡിന്റെ കോപ്പി കുടി കൊണ്ടുവരേണ്ടതാണ്.</div>

			<br />

			<div>ലഭിച്ചിട്ടുള്ള യൂസർ ഐഡി ഉം പാസ്സ്‌വേർഡ് ഉം മറ്റാരുമായും പങ്ക്‌ വെയ്ക്കാതിരിക്കുക</div>

			<br/>

			<div>താങ്കളുടെ ആധാർ കാർഡും പണമടച്ച ചെല്ലാനും മറ്റാർക്കും കൈമാറാതിരിക്കാൻ പ്രത്യേകം ശ്രദ്ധിക്കണം.</div>

           <center> <button onClick="getprint()">Print</button></center>

           <p>&nbsp;</p>
         </div></div>
       </div>

