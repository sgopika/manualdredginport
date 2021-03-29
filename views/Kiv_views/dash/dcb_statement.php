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
<!-- <form name="form1" id="form1" method="post" class="form1" >  -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/dcb_statement", $attributes);
?>
<div class="main-content ui-innerpage">
  <div class="row no-gutters p-1 justify-content-center">
    <div class="col-10 text-center">
      <div class="alert bg-darkslateblue" role="alert">
        DCB Statement
      </div> <!-- end of alert -->
      </div> <!-- end of col8 -->
      <div class="col-10 text-center">
        <div class="row no-gutters px-1 pt-2 pb-1 justify-content-center bg-gray">
          <div class="col-2 py-2">
            Activity
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            <select class="form-control btn-point js-example-basic-single select2" name="survey_sl[]" id="survey_sl" multiple="multiple" required="required"  data-placeholder="Select the list" >
              <option value="">Select</option>
              <option value="0">All</option>
                <?php foreach($survey_type as $res_survey_type) { ?>
                <option class="initial" value="<?php echo $res_survey_type['survey_sl']?>"><?php echo $res_survey_type['survey_name']; ?></option>
              <?php } ?></select> 
          </div> <!-- end of col-3 -->
          <div class="col-2 py-2">
            Payment Gateway
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
             <select class="form-control btn-point js-example-basic-single select2"  name="bank_sl[]" id="bank_sl" multiple="multiple" required="required"  data-placeholder="Select the list">
              <option value="">Select Gateway</option> 
               <option value="0">All</option>
                <?php foreach ($bank as $res_bank)
                {
                ?>
                <option value="<?php echo $res_bank['bank_sl'];?>" ><?php echo $res_bank['bank_name'];?>  </option>
                <?php    }    ?>
                </select>
            </select>
          </div> <!-- end of col-3 -->
        </div> <!-- end of inner row 2-->
        <div class="row no-gutters px-1 pt-2 pb-1 justify-content-center">
          <div class="col-2 py-2">
            From Date
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            <div class="input-group col-8 port-content-noborder">
                <input type="date" class="form-control dob" placeholder="" name="from_date" id="from_date" aria-label="Fromdate" aria-describedby="basic-addon2" required="required" value="<?php echo date('Y-m-d', strtotime('-30 days'));?>">
                <div class="input-group-append">
                 <!--  <span class="input-group-text" id="basic-addon2"> <i class="far fa-calendar-alt"></i> </span> -->
                </div>
              </div> <!-- end of input group -->
          </div> <!-- end of col-3 -->
          <div class="col-2 py-2">
            To Date
          </div> <!-- end of col-3 -->
          <div class="col-4 py-2">
            <div class="input-group col-8 port-content-noborder">
                <input type="date" class="form-control dob" placeholder="" name="to_date" id="to_date" aria-label="Todate" aria-describedby="basic-addon2" required="required" value="<?php echo date('Y-m-d');?>">
                <div class="input-group-append">
                 <!--  <span class="input-group-text" id="basic-addon2"> <i class="far fa-calendar-alt"></i> </span> -->
                </div>
              </div> <!-- end of input group -->
          </div> <!-- end of col-3 -->
        </div> <!-- end of inner row 1-->
        
        <div class="row no-gutters px-1 pt-2 pb-1 justify-content-center bg-gray">
          <div class="col-12 text-center py-2"><input type="hidden" name="portofregistry_id" id="portofregistry_id" value="<?php echo $user_master_port_id ?>">
            <button type="submit" class="btn btn-point btn-flat bg-darkmagenta"> <i class="fas fa-money-check"></i> &nbsp; View DCB Statement</button>
          </div>  <!-- end of col12 -->
        </div> <!-- end of inner row 3 -->
      </div> <!-- end of col8 -->
   </div> <!-- end of row -->
<?php if(!empty($dcb_statement)) 
{
  $survey_sl1       = $this->security->xss_clean($this->input->post('survey_sl'));
  $bank_sl1         = $this->security->xss_clean($this->input->post('bank_sl'));
  $from_date1      = $this->security->xss_clean($this->input->post('from_date'));
  $to_date1        = $this->security->xss_clean($this->input->post('to_date'));
  $portofregistry_id1 = $this->security->xss_clean($this->input->post('portofregistry_id'));


 
if(!empty($survey_sl1))
{
  foreach($survey_sl1 as $res1)
  {
    $survey_sl =$res1;
    if($survey_sl!=0)
    {
      $survey_name          =   $this->Survey_model->get_survey_name($survey_sl);
      $data['survey_name']  =   $survey_name;
      if(!empty($survey_name))
      {
        $survey1[]               =   $survey_name[0]['survey_name'];
      }
      else
      {
        $survey1       ="";
      }
      
      @$survey1_name    = implode(", ",$survey1);
      $hdn_survey1[]=$survey_sl;
      $hdn_survey    = implode(", ",$hdn_survey1);
     
    }
    else
    {
      @$survey1_name    ="ALL";
      $hdn_survey=0;
      /*$survey_name          =   $this->Survey_model->get_survey_master();
      $data['survey_name']  =   $survey_name;
      if(!empty($survey_name))
      {
        foreach($survey_name as $res_survey_name)
        {
          $survey1[]               =   $res_survey_name['survey_name'];
        }
      }
      else
      {
        $survey1       ="";
      }
      @$survey1_name    = implode(", ",$survey1);*/
           
    }
  }
}
else
{
   $survey1_name="";
}




if(!empty($bank_sl1)) 
{
  foreach($bank_sl1 as $res2)
  {
    $bank_sl =$res2;
    if($bank_sl!=0)
    {
      $bankname      =   $this->Survey_model->get_bankname($bank_sl);
      $data['bankname']  = $bankname;
      if(!empty($bankname))
      {
        $bankname1[]               =   $bankname[0]['bank_name'];
      }
      else
      {
        $bankname1       ="";
      }
      @$bankname1_name    = implode(", ",$bankname1);
      $hdn_bank1[]=$bank_sl;
      $hdn_bank    = implode(", ",$hdn_bank1);
    }
    else
    {
      $bankname1_name    ="ALL";
       $hdn_bank=0;
      /*$bank                     =   $this->Survey_model->get_bank_favoring();
      $data['bank']             =   $bank;
      if(!empty($bank))
      {
        foreach($bank as $res_bank)
        {
          $bankname1[]               =   $res_bank['bank_name'];
        }
      }
      else
      {
        $bankname1       ="";
      }
      @$bankname1_name    = implode(", ",$bankname1);*/
    }
  }
}
else
{
  $bankname1_name    ="";
}
 if(!empty($portofregistry_id1))
{
  $portofregistry1          =   $this->Survey_model->get_registry_port_id($portofregistry_id1);
  $data['portofregistry1']  =   $portofregistry1;
  if(!empty($portofregistry1))
  {
    $portofregistry_name1     =   $portofregistry1[0]['vchr_portoffice_name'];
  }
  else
  {
    $portofregistry_name1     = "";
  }
}
else
{
  $portofregistry_name1="";
}
 $from_date = date('d-m-Y',  strtotime($from_date1));
 $to_date = date('d-m-Y',  strtotime($to_date1));
 //63713
?>
   <div class="row no-gutters p-1 justify-content-center">
    <div class="col-12 p-1 text-center">
      <div class="alert bg-gray-active text-black" role="alert">
        Showing payment details for <span class="badge bg-gray py-2 px-3">  <?php echo $survey1_name; ?>  </span> activities at  <span class="badge  bg-gray py-2 px-3"> <?php echo $portofregistry_name1; ?></span> Port of Registry through  <span class="badge bg-gray py-2 px-3">  <?php echo $bankname1_name; ?> </span> Payment Gateway(s). <br> <br>
        From  <span class="badge bg-gray py-2 px-3"> <?php echo $from_date; ?></span>  to  <span class="badge  bg-gray py-2 px-3"> <?php echo  $to_date ; ?> </span>
      </div>  <!-- end of alert -->
    </div> <!-- end of col12 -->

    <div class="col-12 p-1 d-flex justify-content-end">
      <button type="button" id="print_button" class="btn btn-sm btn-flat btn-point bg-firebrick"><i class="fas fa-file-pdf"></i>&nbsp; Print </button> &nbsp;
      &nbsp; 
      <button type="button" class="btn btn-sm btn-flat btn-point bg-darkcyan "> <i class="fas fa-file-excel"></i>&nbsp;  Excel </button>
    <input type="hidden" name="survey_sl1" id="survey_sl1" value="<?php echo $hdn_survey; ?>">
    <input type="hidden" name="bank_sl1" id="bank_sl1" value="<?php echo $hdn_bank; ?>"> 
      <input type="hidden" name="from_date1" id="from_date1" value="<?php echo $from_date1; ?>">
      <input type="hidden" name="to_date1" id="to_date1" value="<?php echo $to_date1; ?>">
      <input type="hidden" name="portofregistry_id1" id="portofregistry_id1" value="<?php echo $portofregistry_id1; ?>">
 
    </div> <!-- end of col12 -->

    <div class="col-12 p-1 text-center">
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="example1_info">
          <thead class="thead-light">
            <tr>
              <th> # </th>
              <th> Amount </th>
              <th> Gateway </th>
              <th> Transaction Id</th>
              <th> Transaction Date</th>
              <th> Payment Mode</th>
              <th> Activity</th>
               <th> KIV Number</th>
              <th> Port of Registry</th>
            </tr> 
             </thead>
             <tbody>
            <?php   $total=0; $i=1;
            foreach ($dcb_statement as $key ) 
            {
              $vessel_id=$key['vessel_id'];
              $survey_id=$key['survey_id'];
              $form_number=$key['form_number'];
              $paymenttype_id=$key['paymenttype_id'];
              $dd_amount=$key['dd_amount'];
              $dd_number=$key['dd_number'];
              $dd_date=$key['dd_date'];
              $portofregistry_id=$key['portofregistry_id'];
              $bank_id=$key['bank_id'];
              $branch_name=$key['branch_name'];
              $payment_mode=$key['payment_mode'];
              $transaction_id=$key['transaction_id'];
              date_default_timezone_set("Asia/Kolkata");
              $payment_created_timestamp=$key['payment_created_timestamp'];
              $time      = date('d-m-Y h:i:s',  strtotime($payment_created_timestamp));
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
            $vessel_main=$this->Survey_model->get_vessel_main($vessel_id);
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
    }
          ?>
             <tr>
              <td> <?php echo $i; ?> </td>
              <td> <?php $total=$total+$dd_amount; echo $dd_amount?> </td>
              <td> <?php echo $bank_name; ?> </td>
              <td> <?php echo $transaction_id;  ?></td>
              <td> <?php echo $time; ?></td>
              <td> <?php echo $payment_mode; ?></td>
              <td> <?php echo $survey; ?></td>
              <td> <?php echo $vesselmain_reg_number; ?></td>
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
</div> <!-- end of main content -->
<!-- </form> --> <?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function() {
$("#from_date").change(function()
{
    var newdate=$("#from_date").val();
    var CurrentDate = new Date();
    GivenDate = new Date(newdate);
    if(GivenDate > CurrentDate)
    {
      alert('Invalid date');
      $("#from_date").val('');
    }
});

$("#to_date").change(function()
{
    var newdate=$("#to_date").val();
    var CurrentDate = new Date();
    GivenDate = new Date(newdate);
    if(GivenDate > CurrentDate)
    {
      alert('Invalid date');
      $("#to_date").val('');
    }
});
$("#print_button").click(function()
{
 var survey_sl1=$("#survey_sl1").val(); 
 var bank_sl1=$("#bank_sl1").val(); 
 var from_date1=$("#from_date1").val(); 
 var to_date1=$("#to_date1").val(); 
 var portofregistry_id1=$("#portofregistry_id1").val();
 
});
$("#survey_sl").change(function()
{
var survey_sl=$("#survey_sl").val(); 
var len=$('#survey_sl option').length;

if(survey_sl==0)
{
  for(var i=2; i<=len;i++)
  {
    //alert(i);
    $('#survey_sl option[value="'+i+'"]').attr("disabled", true);
  }
}

});


//End of jquery
});


</script>