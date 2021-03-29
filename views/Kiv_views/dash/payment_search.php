<?php 
$moduleid        = 2;
$modenc          = $this->encrypt->encode($moduleid); 
$modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');
$user_sl                 =   $this->Survey_model->get_user_sl($sess_usr_id);
$data['user_sl']         =   $user_sl;
if(!empty($user_sl))
{
  $user_master_port_id=   $user_sl[0]['user_master_port_id'];
}
else
{
  $user_master_port_id= 0;
}
?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==3) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome/<?php echo $modidenc;?>"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==14) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==11) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<!-- <form name="form1" id="form1" method="post" class="form1" > -->
    <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/payment_search", $attributes);
?>
<div class="main-content ui-innerpage">
<div class="row no-gutters p-1 justify-content-center">
    <div class="col-10 text-center">
      <div class="alert bg-darkslateblue" role="alert">
        Owner details wise search
      </div> <!-- end of alert -->
      </div> <!-- end of col10 -->
      <div class="col-10 px-3">
  <div class="row no-gutter py-2 bg-gray">
    <div class="col-2">
    <label class=" innertitle"> Search By : </label>
  </div> <!-- end of col2 -->
  <div class="col-2 pt-2">
    <select name="search_id" id="search_id" onchange="search(this.value);" class="form-control js-example-basic-single" style="width: 100%;">
                  <option value="">--SELECT--</option> 
                  <option value="1">Mobile Number</option> 
                  <option value="2">Email ID</option> 
                  <?php if($user_type_id=='14') { ?> <option value="3">KIV Number</option>  <?php } ?>
    </select>
  </div> <!-- end of col2 -->
  <div class="col-4 pt-1"> 
    <input type="text" class="form-control"  name="search_mob" id="search_mob" minlength="10" maxlength="11" placeholder="Specify Mobile Number" onkeypress="return IsNumeric(event);" style="display: none;" autocomplete="off">
    <input type="text" class="form-control"  name="search_mail" id="search_mail" onchange="return validateEmail(this.value);" placeholder="Enter Mail ID" style="display: none;">
    <input type="text" class="form-control"  name="search_kiv" id="search_kiv" placeholder="Enter KIV Number" style="display: none;">
  </div> <!-- end of col-4 -->
  <div class="col-4 pt-1"><input type="hidden" name="portofregistry_id" id="portofregistry_id" value="<?php echo $user_master_port_id ?>">
    <button class="btn btn-flat btn-point bg-darkslategray px-4" type="submit" onclick="search_det();" id="Search_btn" name="Search_btn" style="display: none;"><i class="fab fa-searchengin"></i> Search</button>
  </div> <!-- end of col4 -->
  </div> <!-- end of inner row -->
  <!-- <div id="resp_msg" class="py-2"> </div> -->
</div> <!-- end of col10 -->
</div> <!-- end of row -->
<!--------------------------------------- starting results ----------------------------------- -->
<?php if(!empty($transaction_details)) 
{
$search_id       = $this->security->xss_clean($this->input->post('search_id'));
$customer_name=$transaction_details[0]['customer_name'];
$mobile_no=$transaction_details[0]['mobile_no'];
$email_id=$transaction_details[0]['email_id'];

  $vessel_id=$transaction_details[0]['vessel_id'];
  $vessel_main=$this->Survey_model->get_vessel_main($vessel_id);
  $data['vessel_main']  = $vessel_main;
  //print_r($vessel_main);
  if(!empty($vessel_main))
  {
   $vesselmain_reg_number1=$vessel_main[0]['vesselmain_reg_number'];
  if($vesselmain_reg_number1==0)
  {
   $vesselmain_reg_number="";
  }
  else
  {
   $vesselmain_reg_number=$vesselmain_reg_number1;
  }

  }
  else
  {
  $vesselmain_reg_number="";
  }

if($search_id ==1)
{
  $desc="Mobile number";
}
if($search_id ==2)
{
  $desc="Email id";
}
if($search_id ==3)
{
  $desc="KIV number";
}
?>
<div class="row no-gutters p-1 justify-content-center">
   <div class="col-10 p-2 bg-gray-active">
      <div class="row no-gutters">
        <div class="col-12 p-2 ">
        <span class="text-midnightblue"> Showing details of </span> <span class=""> <?php echo $customer_name; ?>&nbsp;(&nbsp;<i class="fas fa-mobile-alt"></i>&nbsp;&nbsp;<?php echo $mobile_no; ?>&nbsp;&nbsp;&nbsp;<i class="far fa-envelope"></i>&nbsp;&nbsp;<?php echo $email_id; ?>)<?php if($vesselmain_reg_number1) { ?> &nbsp; KIV number: <?php echo $vesselmain_reg_number1; ?> <?php } ?></span> 
      </div> <!-- end of col8 -->
      </div> <!-- end of inner row -->
       </div>  <!-- end of col10 -->
<div class="col-12 px-1 py-2 d-flex justify-content-end">
<button type="button" class="btn btn-sm btn-flat btn-point bg-firebrick "><i class="fas fa-file-pdf"></i>&nbsp; Print </button> &nbsp;
      &nbsp; 
<button type="button" class="btn btn-sm btn-flat btn-point bg-darkcyan "> <i class="fas fa-file-excel"></i>&nbsp;  Excel </button>
    </div> <!-- end of col12 -->
    <div class="col-12 p-1 text-center">
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
          <thead class="thead-light">
            <tr>
              <th> # </th>
              <th> Amount </th>
              <th> Transaction Date</th>
              <th> Status message</th>
              <th> Order status</th>
              <th> Gateway </th>
              <th> Activity</th> 
              <th> KIV number</th>
              <th> Port of Registry</th>
            </tr> 
             </thead>
             <tbody>
            <?php   $total=0; $i=1;
            foreach ($transaction_details as $key ) 
            {

               date_default_timezone_set("Asia/Kolkata");
              $transaction_id=$key['transaction_id'];
              $bank_ref_no=$key['bank_ref_no'];
              $token_no=$key['token_no'];
              $vessel_id=$key['vessel_id'];
              $form_number=$key['form_number'];
              $customer_name=$key['customer_name'];
              $mobile_no=$key['mobile_no'];
              $email_id=$key['email_id'];
              $payment_mode=$key['payment_mode'];
              $order_status=$key['order_status'];
              $status_message=$key['status_message'];
              $amount=$key['amount'];
              $transaction_date= date('d-m-Y h:i:s',  strtotime($key['transaction_date']));
              $portofregistry_id=$key['port_id'];

              $payment      =   $this->Survey_model->get_payment($transaction_id);
              $data['payment']  = $payment;
              if(!empty($payment))
              {
                $survey_id=$key['survey_id'];
              }
              else
              {
                $survey_id=0;
              }
             $portofregistry_id=$key['port_id'];
              $bank_id=$key['bank_id'];

              if(!empty($bank_id ))
              {

               $bankname      =   $this->Survey_model->get_bankname($bank_id);
                $data['bankname']  = $bankname;
                if(!empty($bankname))
                {
                  $bank_name=$bankname[0]['bank_name'];
                }
                else
                {
                   $bank_name="";
                }
              }
              else
              {
                $bank_name="";
              }


              if(!empty($survey_id))
              {
              $survey_name          =   $this->Survey_model->get_survey_name($survey_id);
              $data['survey_name']  =   $survey_name;
              if(!empty($survey_name))
              {
                $survey               =   $survey_name[0]['survey_name'];
              }
              else
              {
                $survey       ="";
              }
            }
            else
            {
              $survey       ="";
            }
          if(!empty($portofregistry_id))
          {
          $portofregistry          =   $this->Survey_model->get_registry_port_id($portofregistry_id);
          $data['portofregistry']  =   $portofregistry;
          if(!empty($portofregistry))
          {
            $portofregistry_name     =   $portofregistry[0]['vchr_portoffice_name'];
          }
          else
          {
            $portofregistry_name     = "";
          }
          
          }
          else
          {
          $portofregistry_name="";
          }
/*$vessel_main=$this->Survey_model->get_vessel_main($vessel_id);
    $data['vessel_main']  = $vessel_main;
    if(!empty($vessel_main))
    {
      $vesselmain_reg_number1=$vessel_main[0]['vesselmain_reg_number'];
      if($vesselmain_reg_number1==0)
      {
        $vesselmain_reg_number="";
      }
      else
      {
        $vesselmain_reg_number=$vesselmain_reg_number1;
      }
      
    }
    else
    {
      $vesselmain_reg_number="";
    }*/

          ?>
               <tr>
              <td> <?php echo $i; ?> </td>
              <td> <?php $total=$total+$amount; echo $amount?> </td>
              <td> <?php echo $transaction_date; ?></td>
             <td> <?php echo $status_message;  ?></td>
              <td> <?php echo $order_status; ?></td>
               <td> <?php echo $bank_name; ?> </td>
              <td> <?php echo $survey; ?></td>
              <td><?php echo $vesselmain_reg_number; ?></td>
              <td> <?php echo $portofregistry_name; ?></td>
            </tr>  
            <?php
           $i++;
            } 
             ?> 
          </tbody>     
           <tfoot>
                  <th colspan="9"> Total Amount <i class="fas fa-rupee-sign"></i> <span class="mtitlefont"> <?php echo $total; ?> </span> </th>
            </tfoot>   
        </table>
      </div> <!-- end of table responsive -->
    </div> <!-- end of col10 -->
   </div> <!-- end of table display row -->
 <?php 
 }
 else
 {
  if($no_data=="0")
  {
    ?>
    
    <?php
  }
  else
  {
  ?>
   <div class="alert text-red text-center" role="alert"><span class="badge bg-gray py-2 px-3">No data found</span></div>
  <?php
  }
 }
 ?>
</div> <!--- end of main-content container -->

<!-- </form> --> <?php echo form_close(); ?>

<script type="text/javascript">
$(document).ready(function() {

//End of jquery
});
function search(id)
{
 
  if(id==""){
     $("#Search_val").hide();
     $("#Search_btn").hide();
  } else {
    
    if(id=='1'){

      $("#Search_val").show();
      $("#Search_btn").show();
      $("#search_mob").show();
      $("#search_mail").hide();
      $("#search_kiv").hide();

    } else if(id=='2'){

      $("#Search_val").show();
      $("#Search_btn").show(); 
      $("#search_mob").hide();
      $("#search_mail").show();
      $("#search_kiv").hide();

    } else if(id=='3'){

      $("#Search_val").show();
      $("#Search_btn").show();
      $("#search_mob").hide();
      $("#search_mail").hide();
      $("#search_kiv").show();

    }

    
  }
}

function alpbabetspace(e) {
     var k;
     document.all ? k = e.keyCode : k = e.which;
     return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k==32);
}

function IsNumeric(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)) 
  {
    return true;
  }
  else 
  {
    window.alert("This field accepts only numbers!!");
    return false;
  }
}

function validateEmail(email) {
 
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if( !emailReg.test( email ) ) {
    alert("Invalid Email!!");
    document.getElementById('search_mail').value='';
      return false;
  } else {
      return true;
  }
}

function IsAddress(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 32) || (unicode == 44) || (unicode == 47) || (unicode == 40) || (unicode == 41) || (unicode == 45) || (unicode >64 && unicode<91) || (unicode > 47 && unicode < 58) || (unicode > 96 && unicode < 123) || (unicode==8) || (unicode==46) ) 
  {
          return true;
  }
  else 
  {
        window.alert("Not Allowed");
          return false;  
  }
}   

function search_det()
{
  var search_id   = document.getElementById('search_id').value;
  var search_mob  = document.getElementById('search_mob').value;
  var search_mail = document.getElementById('search_mail').value;
  var search_kiv  = document.getElementById('search_kiv').value;
  if(search_id=='')
  {
    alert("Specify the type of search!!!")
    document.getElementById('search_id').focus();
    return false;
  } 
  else 
  {
    if(search_id==1)
    {
      if(search_mob=='')
      {
        alert("Specify the Mobile Number!!!")
        document.getElementById('search_mob').focus();
        return false;
      } 
    } 
    else if(search_id==2)
    {
      if(search_mail=='')
      {
        alert("Enter Mail ID!!!")
        document.getElementById('search_mail').focus();
        return false;
      } 
    } 
    else if(search_id==3)
    {

      if(search_kiv==''){

        alert("Enter KIV Number!!!")
        document.getElementById('search_kiv').focus();
        return false;
      } 
    }



  }
}
</script>