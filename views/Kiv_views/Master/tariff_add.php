<script type="text/javascript">
 $(document).ready(function(){

  $('#refreshBtn').click(function () {
    location.reload();
    })

   $("#surveyName").change(function()
  {
    var surveyName=$("#surveyName").val();
    if(surveyName != '')
    {
      $('#valMsg_surname').hide();   
    }   
  });

  $("#formtypeName").change(function()
  {
    var formtypeName=$("#formtypeName").val();
    if(formtypeName != '')
    {
      $('#valMsg_form').hide();   
    }   
  });

  $("#vessel_subtype_name").change(function()
  {
    var vessel_subtype_name=$("#vessel_subtype_name").val();
    if(vessel_subtype_name != 0)
    {
      $('#valMsg_vessubname').hide();   
    }   
  });

  $("#startDate").change(function()
  {
        var dateString=$("#startDate").val();
        if(dateString != '')
        {
          $('#valMsg_sdate').hide();   
        }

        var regcd = new RegExp("^[0-9\/]+$");
        if (regcd.exec(dateString) == null) 
        {
        $('#valMsg_sdate').html("<p style='color:red;'>Only Number and / allowed.</p>");         
        document.getElementById("startDate").value = null;
        return false;
        } 

        dateString = dateString.split("/").reverse().join("-");
            
        var dateString1 = document.getElementById('endDate').value;
        dateString1 = dateString1.split("/").reverse().join("-");

        var myDate = new Date(dateString);
        var myDate1 = new Date(dateString1);
        var today = new Date();

        if(myDate1!='')
        {
            if(myDate1 < myDate)
            { 
                $('#valMsg_sdate').show();
                $('#valMsg_sdate').html("<p style='color:red;'>Start Date Should be Smaller than End Date.</p>");
                return false;
            }
        }
        else
        { 
            $('#valMsg_sdate').hide();
            return true;
        }  
  });

$("#endDate").change(function()
  { 
        var dateString1=$("#startDate").val();
        var dateString2=$("#endDate").val();
       
        var regcd = new RegExp("^[0-9\/]+$");
        if (regcd.exec(dateString2) == null) 
        {
        $('#valMsg_edate').show();
        $('#valMsg_edate').html("<p style='color:red;'>Only Number and / allowed.</p>");         
        document.getElementById("endDate").value = null;
        return false;
        } 

        dateString1 = dateString1.split("/").reverse().join("-");
        dateString2 = dateString2.split("/").reverse().join("-");  

        var myDate1 = new Date(dateString1);
        var myDate2 = new Date(dateString2);
        var today = new Date();
        
        if ( myDate2 < today ) 
        { 
            $('#valMsg_edate').show();
            $('#valMsg_edate').html("<p style='color:red;'>You Cannot Enter Previous End Date .</p>");
            return false;
        }
        else if(myDate2 <= myDate1)
        { 
            $('#valMsg_edate').show();
            $('#valMsg_edate').html("<p style='color:red;'>End Date Should be greater than Start Date.</p>");
            return false;
        }
        else
        { 
            $('#valMsg_sdate').hide();
            $('#valMsg_edate').hide();
            return true;
        }     
   
  });

  $("#amount").change(function()
  {
    var amount=$("#amount").val();
    if((amount != '')||(amount != 0))
    {
          var regnum = new RegExp("^[0-9]+$");
          
          if (regnum.exec(amount) == null) 
          {
          alert("Only Numbers allowed in Amount.");
          document.getElementById("valMsg_amount").innerHTML ="<font color='red'>Only Numbers allowed in Amount.</font>";
          document.getElementById("amount").value = 0;
          return false;
          } 
          
          else
          {
            $('#valMsg_amount').hide();
          }
    }
       
  });

  $("#min_amount").change(function()
  {
    var min_amount=$("#min_amount").val();
    if((min_amount != '')||(min_amount != 0))
    {
          var regnum = new RegExp("^[0-9]+$");
          
          if (regnum.exec(min_amount) == null) 
          {
          alert("Only Numbers allowed in Minimum Amount.");
          //$('#valMsg_minAmount').show();
          document.getElementById("valMsg_minAmount").innerHTML ="<font color='red'>Only Numbers allowed in Minimum Amount.</font>";
          document.getElementById("min_amount").value = 0;
          return false;
          } 
          
          else
          {
            $('#valMsg_minAmount').hide();
          } 
    }  
  });

  $("#fine_amount").change(function()
  {
    var fine_amount=$("#fine_amount").val();
    if((fine_amount != '')||(fine_amount != 0))
    {
          var regnum = new RegExp("^[0-9]+$");
          
          if (regnum.exec(fine_amount) == null) 
          {
          alert("Only Numbers allowed in Fine Amount.");
          document.getElementById("valMsg_fineAmount").innerHTML ="<font color='red'>Only Numbers allowed in Fine Amount.</font>";
          document.getElementById("fine_amount").value = 0;
          return false;
          } 
          
          else
          {
            $('#valMsg_fineAmount').hide();
          }    
    }   
  });

  $("#vesseltype_name").change(function()
  {
    var vesseltype_id=$("#vesseltype_name").val();
    var csrf_token='<?php echo $this->security->get_csrf_hash(); ?>';

    if(vesseltype_id != '')
    {
    $('#valMsg_vesname').hide();
    $.ajax
      ({
        type: "POST",
        url:"<?php echo site_url('/Kiv_Ctrl/Master/tariff_vesselsubtype_ajax/')?>",
        data:{vesseltype_id:vesseltype_id,'csrf_test_name': csrf_token},
        success: function(data)
        {   //alert(data);     
        $("#vessel_subtype_name").html(data);      
          
        }
      });
    }
  });

  $("#tonnage_type").change(function()
  {
    var tonnage_type=$("#tonnage_type").val();//alert(tonnage_type);
    if(tonnage_type!=0)
    {
    $("#valMsg_tngType").hide();  
    }
    
    if(tonnage_type==1)
    {
    $("#range_ton_div").hide();
    }

    if(tonnage_type==2)
    {    
    $("#range_ton_div").hide();
    }

    if(tonnage_type==3)
    {
    $("#range_ton_div").show();    
    }

    if(tonnage_type==0)
    {
    $("#range_ton_div").hide();
    }

  });

  $("#day_type").change(function()
  {
    var day_type=$("#day_type").val();//alert(day_type);
    
    if(day_type!=0)
    {
    $("#valMsg_tarDay").hide();  
    }

    if(day_type!=2)
    {
    $("#range_day_div").hide();
    }

    if(day_type==2)
    {
    $("#range_day_div").show();
    }

  });

  $("#from_ton").change(function()
  {
    
    var from_ton=$("#from_ton").val();from_ton=parseInt(from_ton);//alert(from_ton);
    var to_ton=$("#to_ton").val();to_ton=parseInt(to_ton);//alert(to_ton);

    if((from_ton !='')&&(to_ton != ''))
    {
    let result = from_ton >= to_ton; // assign the result of the comparison
    if(result==true)
    { //alert("change");
    $("#from_ton").val('');
    alert("From ton should be smaller than To ton.");
    $("#valMsg_fromTon").show();
    document.getElementById("valMsg_fromTon").innerHTML ="<font color='red'>From ton should be smaller than To ton.</font>";
    //document.getElementById("from_ton").value = '';
    return false;
    }
  }
  });

  $("#to_ton").change(function()
  {
    
    var from_ton=$("#from_ton").val();from_ton=parseInt(from_ton);//alert(from_ton);
    var to_ton=$("#to_ton").val();to_ton=parseInt(to_ton);//alert(to_ton);

    if((from_ton !='')&&(to_ton != ''))
    {

    //if(to_ton <= from_ton)
    let result = to_ton <= from_ton; // assign the result of the comparison
    if(result==true)
    {      
    $("#to_ton").val('');
    alert("To ton should be greater than From ton");
    $("#valMsg_toTon").show();
    document.getElementById("valMsg_toTon").innerHTML ="<font color='red'>To ton should be greater than From ton.</font>";
    return false;
    }

    }
  });

  $("#from_day").change(function()
  {
    
    var from_day=$("#from_day").val();from_day=parseInt(from_day);
    var to_day=$("#to_day").val();to_day=parseInt(to_day);

    if((from_day !='')&&(to_day != ''))
    {
    let result = from_day >= to_day; // assign the result of the comparison
    if(result==true)
    {
    alert("From day should be smaller than To day.");
    $("#valMsg_fromDay").show();
    document.getElementById("valMsg_fromDay").innerHTML ="<font color='red'>From day should be smaller than To day.</font>";
    document.getElementById("from_day").value = '';
    return false;
    }

  }
  });

  $("#to_day").change(function()
  {
    
    var from_day=$("#from_day").val();from_day=parseInt(from_day);
    var to_day=$("#to_day").val();to_day=parseInt(to_day);

    if((from_day !='')&&(to_day != ''))
    {
    let result = to_day <= from_day; // assign the result of the comparison
    if(result==true)
    {
    alert("To day should be greater than From day");
    $("#valMsg_toDay").show();
    document.getElementById("valMsg_toDay").innerHTML ="<font color='red'>To day should be greater than From day.</font>";
    document.getElementById("to_day").value = '';
    return false;
    }
  }
  });                
 });

function viewAddTariff()
{
    var surveyName          = $("#surveyName").val(); //alert(surveyName);
    var formtypeName        = $("#formtypeName").val();//alert(formtypeName); 
    var vesseltype_name     = $("#vesseltype_name").val(); //alert(vesseltype_name);
    var subType             = $("#vessel_subtype_name").val(); if(subType==''){subType=0;}else{subType=subType;}//alert(subType);
    var startDate           = $("#startDate").val();//alert(startDate);
    var endDate             = $("#endDate").val();//alert(endDate);,'csrf_test_name': csrf_token

         if ($("#surveyName").val() == '') 
            {
                $('#valMsg_surname').show();
                return false;
            }

            if ($("#formtypeName").val() == '') 
            {
                $('#valMsg_form').show();
                return false;
            }

            if ($("#vesseltype_name").val() == '') 
            {
                $('#valMsg_vesname').show();
                return false;
            }

            if( $('#vessel_subtype_name').has('option').length > 0 )
            {
            //var aa=$(this).find(":selected").text();alert(aa);
            if ($("#vessel_subtype_name").val() == '') 
              {
                  $('#valMsg_vessubname').show();
                  return false;
              }
            }

            if ($("#startDate").val() == '') 
            {
                $('#valMsg_sdate').show();
                $('#valMsg_sdate').html("<p style='color:red;'>Start Date Required.</p>");
                return false;
            }

           if ($("#endDate").val() != '') 
           {
                  var dateString1=$("#startDate").val();
                  var dateString2=$("#endDate").val();
                 
                  var regcd = new RegExp("^[0-9\/]+$");
                  if (regcd.exec(dateString2) == null) 
                  {
                  $('#valMsg_edate').show();
                  $('#valMsg_edate').html("<p style='color:red;'>Only Number and / allowed.</p>");         
                  document.getElementById("endDate").value = null;
                  return false;
                  } 

                  dateString1 = dateString1.split("/").reverse().join("-");
                  dateString2 = dateString2.split("/").reverse().join("-");  

                  var myDate1 = new Date(dateString1);
                  var myDate2 = new Date(dateString2);
                  var today = new Date();
                      
                  if ( myDate2 < today ) 
                  { 
                      $('#valMsg_edate').show();
                      $('#valMsg_edate').html("<p style='color:red;'>You Cannot Enter Previous End Date .</p>");
                      return false;
                  }
                  else if(myDate2 < myDate1)
                  { 
                      $('#valMsg_edate').show();
                      $('#valMsg_edate').html("<p style='color:red;'>End Date Should be greater than Start Date.</p>");
                      return false;
                  }        
            }                                                                     //&&($("#endDate").val() != '')*/

    if (($("#surveyName").val() != '')&&($("#formtypeName").val() != '')&&($("#vesseltype_name").val() != '')&&($("#startDate").val() != ''))
    {
        startDate = startDate.split("/").reverse().join("-");     
        if(endDate=='')
          {
            endDate='0000-00-00';
          }
        else
          {
          endDate   = endDate.split("/").reverse().join("-");
          }
    
        $.ajax({
            type: "POST",
            url: "<?php echo $site_url; ?>/Kiv_Ctrl/Master/viewTariff_Ajax/"+surveyName+"/"+formtypeName+"/"+vesseltype_name+"/"+subType+"/"+startDate+"/"+endDate,
            success: function(data)
            { //alert(data);
              
              $("#tableshow_div").show();        
              $("#example1").html(data);//$("#tabAjax").html(data);

              $("#selection_div").show();

              $("#surveyName").prop('disabled',true);
              $("#formtypeName").prop('disabled',true);
              $("#vesseltype_name").prop('disabled',true);
              $("#vessel_subtype_name").prop('disabled',true);
              $("#startDate").prop('disabled',true);
              $("#endDate").prop('disabled',true); 
       
            }
        });
    }
}

function ins_tariff()
{
    var surveyName          = $("#surveyName").val(); //alert(surveyName);
    var formtypeName        = $("#formtypeName").val();//alert(formtypeName); 
    var vesseltype_name     = $("#vesseltype_name").val(); //alert(vesseltype_name);
    var subType             = $("#vessel_subtype_name").val(); if(subType==''){subType=0;}else{subType=subType;}//alert(subType);
    var startDate           = $("#startDate").val();//alert(startDate);
    var endDate             = $("#endDate").val();//alert(endDate);
    var tonnage_type        = $("#tonnage_type").val(); //alert(tonnage_type);
    var from_ton            = $("#from_ton").val();//alert(from_ton); 
    var to_ton              = $("#to_ton").val(); //alert(to_ton);
    var day_type            = $("#day_type").val();//alert(day_type);
    var from_day            = $("#from_day").val();//alert(from_day);
    var to_day              = $("#to_day").val(); //alert(to_day);
    var amount              = $("#amount").val();//alert(amount);
    var min_amount          = $("#min_amount").val();//alert(min_amount);
    var fine_amount         = $("#fine_amount").val();//alert(fine_amount);

            if ($("#tonnage_type").val() == 0) 
            {
                $('#valMsg_tngType').show();
                return false;
            }


            if($("#tonnage_type").val()==2)
            { 
                document.getElementById("from_ton").value = '';
                document.getElementById("to_ton").value = '';

                from_ton=123456789;
                to_ton=123456789;
            }

            if($("#tonnage_type").val()==3)
            {  
                if((from_ton != '')||(to_ton != ''))
                {
                      var regnum = new RegExp("^[0-9]+$");
                      
                      if (regnum.exec(from_ton) == null) 
                      {
                      alert("Only Numbers allowed in From Ton.");
                      document.getElementById("valMsg_fromTon").innerHTML ="<font color='red'>Only Numbers allowed in From Ton.</font>";
                      document.getElementById("from_ton").value = '';
                      return false;
                      } 
                      
                      else
                      { 
                        from_ton=parseInt(from_ton);
                        to_ton=parseInt(to_ton);

                        let result = from_ton >= to_ton; //alert( result );// assign the result of the comparison                        
                        if(result==true)
                        {
                        alert("From ton should be smaller than To ton.");
                        $("#valMsg_fromTon").show();
                        document.getElementById("valMsg_fromTon").innerHTML ="<font color='red'>From ton should be smaller than To ton.</font>";
                        document.getElementById("from_ton").value = '';
                        return false;
                        }
                        else
                        {
                          $('#valMsg_fromTon').hide();
                        }
                      }

                      if (regnum.exec(to_ton) == null) 
                      {
                      alert("Only Numbers allowed in From Ton.");
                      document.getElementById("valMsg_toTon").innerHTML ="<font color='red'>Only Numbers allowed in To Ton.</font>";
                      document.getElementById("to_ton").value = '';
                      return false;
                      } 
                                         
                      else
                      {
                        from_ton=parseInt(from_ton);
                        to_ton=parseInt(to_ton);

                        let result = to_ton <= from_ton; //alert( result );// assign the result of the comparison                        
                        if(result==true)
                        {
                        alert("To ton should be greater than From ton");
                        $("#valMsg_toTon").show();
                        document.getElementById("valMsg_toTon").innerHTML ="<font color='red'>To ton should be greater than From ton.</font>";
                        document.getElementById("to_ton").value = '';
                        return false;
                        } 
                        else
                        {
                        $('#valMsg_toTon').hide();
                        }
                      } 
                } 
                if((from_ton == ''))
                {
                      $('#valMsg_fromTon').show();
              document.getElementById("valMsg_fromTon").innerHTML ="<font color='red'>From ton Required.</font>";
                      return false;
                }  
                if((to_ton == '')||(to_ton == 0))
                //if((to_ton == ''))
                {
                      $('#valMsg_toTon').show();
              document.getElementById("valMsg_toTon").innerHTML ="<font color='red'>To ton Required.</font>";
                      return false;
                }

                
            }

            if(($("#tonnage_type").val()==1)||($("#tonnage_type").val()==0)) 
            {
                document.getElementById("from_ton").value = '';
                document.getElementById("to_ton").value = '';
                from_ton=123456789;
                to_ton=123456789;
            }
/*------------------------------------------------------------------------------------*/
            if ($("#day_type").val() == 0) 
            {
                $('#valMsg_tarDay').show();
                return false;
            }

            if($("#day_type").val()==2)
            { 
                if((from_day != '')||(to_day != ''))
                {
                      var regnum = new RegExp("^[0-9]+$");
                      
                      if (regnum.exec(from_day) == null) 
                      {
                          alert("Only Numbers allowed in From Day.");
                          document.getElementById("valMsg_perTon").innerHTML ="<font color='red'>Only Numbers allowed in From Day.</font>";
                          document.getElementById("from_day").value = '';
                          return false;
                      } 
                      
                      else
                      { 
                          from_day=parseInt(from_day);
                          to_day=parseInt(to_day);

                          let result = from_day >= to_day; // assign the result of the comparison
                          //alert( result );
                          if(result==true)
                          {
                          $("#from_day").val('');
                          alert("From day should be smaller than To day.");
                          $("#valMsg_fromDay").show();
                          document.getElementById("valMsg_fromDay").innerHTML ="<font color='red'>From day should be smaller than To day.</font>";
                          return false;
                          }
                          else
                          {
                            $('#valMsg_fromDay').hide();
                          }
                      } 

                      if (regnum.exec(to_day) == null) 
                      {
                          alert("Only Numbers allowed in To Day.");
                          document.getElementById("valMsg_perTon").innerHTML ="<font color='red'>Only Numbers allowed in To Day.</font>";
                          document.getElementById("to_day").value = '';
                          return false;
                      } 
                      
                     else
                      {
                          from_day=parseInt(from_day);
                          to_day=parseInt(to_day);
                          let result = to_day <= from_day; // assign the result of the comparison
                          //alert( result );
                          if(result==true)
                          {
                          alert("To day should be greater than From day");
                          document.getElementById("to_day").value = '';
                          $("#valMsg_toDay").show();
                          document.getElementById("valMsg_toDay").innerHTML ="<font color='red'>To day should be greater than From day.</font>";
                          return false;
                          }
                          else
                          {
                            $('#valMsg_toDay').hide();
                          }
                      } 
                } 
             
                if((from_day == ''))
                {
                      $('#valMsg_fromDay').show();
                      return false;
                } 
                if((to_day == '')||(to_day == 0))
                //if((to_day == ''))
                {
                      $('#valMsg_toDay').show();
                      return false;
                }  
              }

              if(($("#day_type").val()==1)||($("#day_type").val()==0)) 
              {
                  document.getElementById("from_day").value = '';
                  document.getElementById("to_day").value = '';
                  from_day=123456789;
                  to_day=123456789;
              }

            if (($("#amount").val() == '')||($("#amount").val() == 0)) 
            {
                $('#valMsg_amount').show();
                return false;
            }
   
    startDate = startDate.split("/").reverse().join("-");
    
    if(endDate=='')
      {
        endDate='0000-00-00';
      }
    else
      {
      endDate   = endDate.split("/").reverse().join("-");
      }

    if(tonnage_type!=0)
    {
      $("#tonnage_type").prop('disabled',true);
    }

    if(day_type!=0)
    {
      $("#day_type").prop('disabled',true);
    }

     $.ajax({
          type: "POST",
          url: "<?php echo $site_url; ?>/Kiv_Ctrl/Master/addTariff_Ajax/"+surveyName+"/"+formtypeName+"/"+vesseltype_name+"/"+subType+"/"+startDate+"/"+endDate+"/"+tonnage_type+"/"+from_ton+"/"+to_ton+"/"+day_type+"/"+from_day+"/"+to_day+"/"+amount+"/"+min_amount+"/"+fine_amount,
          success: function(data)
          { //alert(data);
            
            $("#tableshow_div").show();        
            $("#example1").html(data);//$("#tabAjax").html(data);
            
          }
        });
}

function edit_tariff_inline(i,id)
{
$("#edit_tr_"+i).show();
$("#view_tr_"+i).hide();
}

function save_tariff_inline(i,id)
{ //alert(id);
  /*Selected value from page*/
  var surveyName          = $("#surveyName").val();//alert(surveyName); 
  var formtypeName        = $("#formtypeName").val();//alert(formtypeName); 
  var vesseltype_name     = $("#vesseltype_name").val(); //alert(vesseltype_name);
  var subType             = $("#vessel_subtype_name").val(); if(subType==''){subType=0;}else{subType=subType;}//alert(subType);
  var startDate           = $("#startDate").val();//alert(startDate);
  var endDate             = $("#endDate").val();//alert(endDate);

  startDate = startDate.split("/").reverse().join("-");
    
    if(endDate=='')
      {
        endDate='0000-00-00';
      }
    else
      {
      endDate   = endDate.split("/").reverse().join("-");
      }
  /*Selected value from page*/
 
  /*Edited value to update to db*/
  var tariff_from_ton        = $("#edit_tariff_from_ton_"+i).val(); //alert(tariff_from_ton);
  var tariff_to_ton          = $("#edit_tariff_to_ton_"+i).val(); //alert(tariff_to_ton);
  //var tariff_per_ton         = $("#edit_tariff_per_ton_"+i).val(); //alert(tariff_per_ton);
  var tariff_from_day        = $("#edit_tariff_from_day_"+i).val(); //alert(tariff_from_day);
  var tariff_to_day          = $("#edit_tariff_to_day_"+i).val(); //alert(tariff_to_day);
  var tariff_amount          = $("#edit_tariff_amount_"+i).val(); //alert(tariff_amount);
  var tariff_min_amount      = $("#edit_tariff_min_amount_"+i).val(); //alert(tariff_min_amount);
  var tariff_fine_amount     = $("#edit_tariff_fine_amount_"+i).val(); //alert(tariff_fine_amount);
  /*Edited value to update to db*/

  /*Old value from db*/
  var hidden_day_type     = $("#hidden_day_type_"+i).val(); //alert(day_type);
  var hidden_tonnage_type = $("#hidden_tonnagetype_id_"+i).val(); //alert(tonnage_type);
  var hidden_from_ton     = $("#hidden_from_ton_"+i).val(); //alert(hidden_from_ton);
  var hidden_to_ton       = $("#hidden_to_ton_"+i).val(); //alert(hidden_to_ton);
  //var hidden_per_ton      = $("#hidden_per_ton_"+i).val(); //alert(hidden_per_ton);
  var hidden_from_day     = $("#hidden_from_day_"+i).val(); //alert(hidden_from_day);
  var hidden_to_day       = $("#hidden_to_day_"+i).val(); //alert(hidden_to_day);
  var hidden_amount       = $("#hidden_amount_"+i).val(); //alert(hidden_amount);
  var hidden_min_amount   = $("#hidden_min_amount_"+i).val(); //alert(hidden_min_amount);
  var hidden_fine_amount  = $("#hidden_fine_amount_"+i).val(); //alert(hidden_fine_amount);
  /*Old value from db*/

  var regnum = new RegExp("^[0-9]+$");

  if(tariff_from_ton=='')
  {
      alert("From Ton Required");
      $("#valMsg_fromTon_edit_"+i).show();
      $("#edit_tariff_from_ton_"+i).focus();
      return false;
  }
  else
  {
      if (regnum.exec(tariff_from_ton) == null) 
      {
          alert("Only Numbers allowed in From Ton.");
          $("#numvalMsg_fromTon_edit_"+i).show();
          document.getElementById("edit_tariff_from_ton_"+i).value = null;
          $("#edit_tariff_from_ton_"+i).focus();
          return false;
      } 
                        
      else
      {
          $('#valMsg_fromTon_edit_'+i).hide();
      }
  
  }

  if(tariff_to_ton=='')
    {
      alert("To Ton Required");
      $("#valMsg_toTon_edit_"+i).show();
      $("#edit_tariff_to_ton_"+i).focus();
      return false;
  }
  else
  {
    if (regnum.exec(tariff_to_ton) == null) 
        {
            alert("Only Numbers allowed in To Ton.");
            $("#numvalMsg_toTon_edit_"+i).show();
            $("#edit_tariff_to_ton_"+i).focus();
            document.getElementById("edit_tariff_to_ton_"+i).value = null;
            return false;
        } 
                      
      else
        {
            $('#valMsg_toTon_edit_'+i).hide();
            $('#numvalMsg_toTon_edit_'+i).hide();
        }
  
  }

  if(tariff_from_day=='')
  {
      alert("From Day Required");
      $("#valMsg_fromDay_edit_"+i).show();
      $("#edit_tariff_from_day_"+i).focus();
      return false;
  }

  else
  {
    if (regnum.exec(tariff_from_day) == null) 
        {
            alert("Only Numbers allowed in From Day.");
            $("#numvalMsg_fromDay_edit_"+i).show();
            document.getElementById("edit_tariff_from_day_"+i).value = null;
            $("#edit_tariff_from_day_"+i).focus();
            return false;
        } 
                      
    else
        {
            $('#valMsg_fromDay_edit_'+i).hide();
            $("#numvalMsg_fromDay_edit_"+i).hide();
        }
  
  }

  if(tariff_to_day=='')
  {
      alert("To Day Required");
      $("#valMsg_toDay_edit_"+i).show();
      $("#edit_tariff_to_day_"+i).focus();
      return false;
  }
  else
  {
    if (regnum.exec(tariff_to_day) == null) 
        {
            alert("Only Numbers allowed in To Day.");
            $("#numvalMsg_toDay_edit_"+i).show();
            document.getElementById("edit_tariff_to_day_"+i).value = null;
            $("#edit_tariff_to_day_"+i).focus();
            return false;
        } 
                      
      else
        {
            $('#valMsg_toDay_edit_'+i).hide();
            $("#numvalMsg_toDay_edit_"+i).hide();
        }
  
  }

  if(tariff_amount=='')
  {
      alert("Amount Required");
      $("#valMsg_amt_edit_"+i).show();
      $("#edit_tariff_amount_"+i).focus();
      return false;
  }
  else
  {
    if (regnum.exec(tariff_amount) == null) 
        {
            alert("Only Numbers allowed in Amount.");
            $("#numvalMsg_amount_edit_"+i).show();
            document.getElementById("edit_tariff_amount_"+i).value = null;
            $("#edit_tariff_amount_"+i).focus();
            return false;
        } 
                      
      else
        {
            $('#valMsg_amt_edit_'+i).hide();
            $('#numvalMsg_amount_edit_'+i).hide();
        }
  
  }

  if(tariff_min_amount!='')
  {
    if (regnum.exec(tariff_min_amount) == null) 
        {
            alert("Only Numbers allowed in Minimum Amount.");
            $("#numvalMsg_minamount_edit_"+i).show();
            document.getElementById("edit_tariff_min_amount_"+i).value = null;
            $("#edit_tariff_min_amount_"+i).focus();
            return false;
        } 
                      
    else
        {
            $('#numvalMsg_minamount_edit_'+i).hide();
        }
  
  }

  if(tariff_fine_amount!='')
  {
      if (regnum.exec(tariff_fine_amount) == null) 
      {
          alert("Only Numbers allowed in Minimum Amount.");
          $("#numvalMsg_fineamount_edit_"+i).show();
          document.getElementById("edit_tariff_fine_amount_"+i).value = null;
          $("#edit_tariff_fine_amount_"+i).focus();
          return false;
      } 
                      
      else
      {
          $('#numvalMsg_fineamount_edit_'+i).hide();
      }
  
  }

  if((tariff_from_ton!='')&&(tariff_to_ton!='')&&(tariff_from_day!='')&&(tariff_amount!='')&&(tariff_min_amount!='')&&(tariff_fine_amount!=''))
  {
    $.ajax({
          type: "POST",
          url: "<?php echo $site_url; ?>/Kiv_Ctrl/Master/editTariff_ajax/"+id+"/"+tariff_from_ton+"/"+tariff_to_ton+"/"+tariff_from_day+"/"+tariff_to_day+"/"+tariff_amount+"/"+tariff_min_amount+"/"+tariff_fine_amount+"/"+surveyName+"/"+formtypeName+"/"+vesseltype_name+"/"+subType+"/"+startDate+"/"+endDate+"/"+hidden_tonnage_type+"/"+hidden_day_type+"/"+hidden_from_ton+"/"+hidden_to_ton+"/"+hidden_from_day+"/"+hidden_to_day+"/"+hidden_amount+"/"+hidden_min_amount+"/"+hidden_fine_amount,

          success: function(data)
          { //alert(data);          
            
          $("#edit_tr_"+i).hide();
          $("#view_tr_"+i).show(); 
            $("#tableshow_div").show();        
            $("#example1").html(data);//$("#tabAjax").html(data);
            if(data=="existing") 
            {
            $("#tarif_exists_msgdiv").show(); 
            $("#tarif_updt_msgdiv").hide();
            }
          }
        });
  }
}

function cancel_tariff_inline(i,id)
{
$("#edit_tr_"+i).hide();
$("#view_tr_"+i).show();
}

function delete_tariff_inline(i,id)
{ //alert(id);
    
    /*Fetch the data to reload the table div, to view updated db while deletion*/
    var surveyName          = $("#surveyName").val();//alert(surveyName); 
    var formtypeName        = $("#formtypeName").val();//alert(formtypeName); 
    var vesseltype_name     = $("#vesseltype_name").val(); //alert(vesseltype_name);
    var subType             = $("#vessel_subtype_name").val(); if(subType==''){subType=0;}else{subType=subType;}//alert(subType);
    var startDate           = $("#startDate").val();//alert(startDate);
    var endDate             = $("#endDate").val();//alert(endDate);
    startDate = startDate.split("/").reverse().join("-");
    
    if(endDate=='')
      {
        endDate='0000-00-00';
      }
    else
      {
      endDate   = endDate.split("/").reverse().join("-");
      }

      $.ajax({
          type: "POST",
          url: "<?php echo $site_url; ?>/Kiv_Ctrl/Master/deleteTariff_ajax/"+surveyName+"/"+formtypeName+"/"+vesseltype_name+"/"+subType+"/"+startDate+"/"+endDate+"/"+id,
          success: function(data)
          { //alert(data);            
                  
          $("#edit_tr_"+i).hide();
          $("#view_tr_"+i).show();
          //$("#tarif_del_msgdiv").show(); 
            $("#tableshow_div").show();        
            $("#example1").html(data);//$("#tabAjax").html(data); 
            
          }
        });
}
</script>
        <?php 
        if($this->session->flashdata('msg'))
          {
            echo $this->session->flashdata('msg');
          }
        ?>
           
       <?php 
          $attributes = array("class" => "form-horizontal", "id" => "tariff_add", "name" => "tariff_add" , "novalidate");
          
          if(isset($editres)){
                echo form_open("Kiv_Ctrl/Master/dynamic_form", $attributes);
          } else {
            echo form_open("Kiv_Ctrl/Master/addTariff", $attributes);
       }?>
<div class="container-fluid ui-innerpage">
    <div class="row pt-2">
    <div class="col-6">
      <span class="badge bg-darkmagenta innertitle "> Add Tariff Details</span>
    </div> <!-- end of col6 -->
    <div class="col-6 d-flex justify-content-end">
     <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end">
           <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
        </ol>
      </nav>
    </div> <!-- end of col6 -->
  </div> <!-- end of row -->
  <div class="row pt-2">
        <div class="col-6 d-flex justify-content-start"> 
          <button type="button" class="btn btn-primary btn-flat btn-point" data-toggle="modal" data-target="#instruction_modal">Instructions for adding Tariff details</button>
        </div>
        <div class="col-6 d-flex justify-content-end">
          <button type="button" name="refreshBtn" id="refreshBtn" class="btn btn-flat btn-default btn-sm pull-right"> <i class="fas fa-sync-alt"></i>  Refresh </button>
        </div> <!-- end of col6 -->
        <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
      </div> <!-- end of row -->
<div class="row mt-2 p-2 bg-tariffcolor" id="main_criteria_div">
  <div class="col-2">
    <div class="form-group">
                <p class="lead">Activity <span style="color: red;">*</span></p>
                <select class="form-control " style="width: 100%;" id="surveyName" name="surveyName" required>
                  <option value="">Select Survey Type</option> 
                  <?php foreach($surveyType as $survey){ ?>
                  <option value="<?php echo $survey['survey_sl']; ?>" id="<?php echo $survey['survey_sl']; ?>"><?php echo $survey['survey_name']; ?></option>
                  <?php }  ?>
                </select>
              </div> <!-- end of form group -->
              <div id="valMsg_surname" style="display:none"><font color='red'>Survey Type Required!!</font></div>
  </div> <!-- end of col2 -->
   <div class="col-2">
     <div class="form-group">
                <p class="lead">Form <span style="color: red;">*</span></p>
                <select class="form-control " style="width: 100%;" id="formtypeName" name="formtypeName">
                  <option value="">Select Form</option> 
                  <?php foreach($formName as $form){ ?>
                  <option value="<?php echo $form['document_type_sl']; ?>" id="<?php echo $form['document_type_sl']; ?>"><?php echo $form['document_type_name']; ?></option>
                  <?php }  ?>
                </select>
              </div> <!-- end of form group -->
              <div id="valMsg_form" style="display:none"><font color='red'>Form Name Required!!</font></div>
  </div> <!-- end of col2 -->
   <div class="col-2">
    <div class="form-group">
                <p class="lead"> Vessel Type<span style="color: red;">*</span></p>
                <select class="form-control " style="width: 100%;" name="vesseltype_name" id="vesseltype_name">
                  <option value="">Select Vessel Type</option>
                  <option value="9999">All</option>
                  <?php foreach($vesselType as $vessel){ ?>
                  <option value="<?php echo $vessel['vesseltype_sl']; ?>" id="<?php echo $vessel['vesseltype_sl']; ?>"><?php echo $vessel['vesseltype_name']; ?></option>
                  <?php }  ?>
                </select>
              </div> <!-- end of form group -->
              <div id="valMsg_vesname" style="display:none"><font color='red'>Vessel Type Required!!</font></div>
  </div> <!-- end of col2 -->
   <div class="col-2" id="subvesselDiv">
    <div class="form-group">
                <p class="lead">Vessel SubType</p>
                <select name="vessel_subtype_name" id="vessel_subtype_name" class="form-control " style="width: 100%;" >
                  <option value="">Select Vessel SubType</option>                  
                </select>
              </div> <!-- end of form group -->
              <div id="valMsg_vessubname" style="display:none"><font color='red'>Vessel Sub Type Required!!</font></div>
  </div> <!-- end of col2 -->
   <div class="col-2">
    <div class="form-group">
                <p class="lead">Start Date <span style="color: red;">*</span></p>
                <input type="text" class="form-control dob" id="startDate" name="startDate" placeholder="Enter Start Date" autocomplete="off" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
              </div> <!-- end of form group -->
              <div id="valMsg_sdate" style="display:none"><font color='red'>Start Date Required!!</font></div>
  </div> <!-- end of col2 -->
   <div class="col-2">
     <div class="form-group">
                <p class="lead">End Date </p>
                <input type="text" class="form-control dob" id="endDate" name="endDate" placeholder="Enter End Date" autocomplete="off" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
              </div> <!-- end of form group -->
              <div id="valMsg_edate" style="display:none"><font color='red'></font></div>
  </div> <!-- end of col2 -->
  <div class="col-12 d-flex justify-content-end" id="show_div">
    <button type="button" class="btn btn-point bg-darkslategray btn-flat" id="add_tariff" name="add_tariff" onclick="viewAddTariff()"> <i class="fas fa-rupee-sign"></i>&nbsp; Select Tariff </button> 
  </div> <!-- end of col12 -->
</div> <!-- end of main criteria row -->
<div class="row mb-2 p-2 bg-tariffcolor2  divtop" id="selection_div" style="display: none;">
              <div class="col-2" id="tonselect_div">
                 <div class="form-group">
                <p class="lead">Tonnage  <span style="color: red;">*</span> </p>
                <select class="form-control "  style="width: 100%;" name="tonnage_type" id="tonnage_type">
                  <option value="0">Select</option>
                  <?php foreach($tonnage as $ton){ ?>
                  <option value="<?php echo $ton['tonnagetype_sl']; ?>" id="<?php echo $ton['tonnagetype_sl']; ?>"><?php echo $ton['tonnagetype_name']; ?></option>
                  <?php }  ?>
                </select>
              </div> <!-- end of form group -->
              <div id="valMsg_tngType" style="display:none"><font color='red'>Tonnage Type Required!!</font></div>
              </div>
              <!-- end of col-2 -->
              <div class="col-2" id="range_ton_div" style="display: none;" >
              <div class="col-6">
                 <div class="form-group">
                <p class="lead">From <span style="color: red;">*</span></p>
                <input type="text" class="form-control" id="from_ton" name="from_ton" placeholder="From Ton"  maxlength="5">
              </div> <!-- end of form group -->
              <div id="valMsg_fromTon" style="display:none"><font color='red'>From Ton Required!!</font></div>
              </div>
              <!-- end of col-6 -->
              <div class="col-6">
                 <div class="form-group">
                <p class="lead">To <span style="color: red;">*</span></p>
                <input type="text" class="form-control" id="to_ton" name="to_ton" placeholder="To Ton"  maxlength="5">
              </div> <!-- end of form group -->
              <div id="valMsg_toTon" style="display:none"><font color='red'>To Ton Required!!</font></div>
              </div>
              <!-- end of col-6 -->
            </div> <!-- end of col-2 rangeton div-->
            <div class="col-2" id="dayselect_div">
                 <div class="form-group">
                <p class="lead"> Days <span style="color: red;">*</span> </p>

                <select class="form-control "  style="width: 100%;" name="day_type" id="day_type">
                  <option value="0">Select</option>
                  <?php foreach($tariffDay as $tday){ ?>
                  <option value="<?php echo $tday['tariffdaytype_sl']; ?>" id="<?php echo $tday['tariffdaytype_sl']; ?>"><?php echo $tday['tariffdaytype_name']; ?></option>
                  <?php }  ?>
                </select>
              </div> <!-- end of form group -->
              <div id="valMsg_tarDay" style="display:none"><font color='red'>Day Type Required!!</font></div>
              </div>
              <!-- end of col-2 -->
              <div class="col-8" id="perday_div" style="display: none;"></div>
               <div class="col-2" id="range_day_div" style="display: none;">
              <div class="col-6">
                 <div class="form-group">
                <p class="lead">From <span style="color: red;">*</span> </p>
                <input type="text" class="form-control" id="from_day" name="from_day" placeholder="From" maxlength="7">
              </div> <!-- end of form group -->
              <div id="valMsg_fromDay" style="display:none"><font color='red'>From Day Required!!</font></div>
              </div>
              <!-- end of col-6 -->
              <div class="col-6">
                 <div class="form-group">
                <p class="lead">To <span style="color: red;">*</span> </p>
                <input type="text" class="form-control" id="to_day" name="to_day" placeholder="To"  maxlength="7">
              </div> <!-- end of form group -->
              <div id="valMsg_toDay" style="display:none"><font color='red'>To Day Required!!</font></div>
              </div>
              <!-- end of col-6 -->
            </div> <!-- end of col-2 rangeton div-->
            <div class="col-1">
                 <div class="form-group">
                <p class="lead">Amount <span style="color: red;"></span> </p>
                <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" value="0" maxlength="7">
              </div> <!-- end of form group -->
              <div id="valMsg_amount" style="display:none"><font color='red'>Amount Required!!</font></div>
              </div> <!-- end of col1 -->
              <div class="col-1">
                 <div class="form-group">
                <p class="lead"> Minimum </p>
                <input type="email" class="form-control" id="min_amount" name="min_amount" placeholder="Minimum" value="0" maxlength="7">
              </div> <!-- end of form group -->
              <div id="valMsg_minAmount" style="display:none"><font color='red'>Minimum Amount Required!!</font></div>
              </div> <!-- end of col1 -->
              <div class="col-1">
                 <div class="form-group">
                <p class="lead">Fine  </p>
                <input type="email" class="form-control" id="fine_amount" name="fine_amount" placeholder="Fine" value="0" maxlength="7">
              </div> <!-- end of form group -->
              <div id="valMsg_fineAmount" style="display:none"><font color='red'>Fine Amount Required!!</font></div>
              </div> <!-- end of col1 -->
               <div class="col-12 d-flex justify-content-end"> 
                <div class="form-group">
                <button type="button" class="btn btn-point bg-darkolivegreen btn-flat" onclick="ins_tariff();"> <i class="fas fa-plus-square"></i>&nbsp; Add Tariff Rate</button> 
              </div> <!-- end of form group -->
              </div> <!-- end of col12 -->
</div> <!-- end of selection row -->
<div class="row py-2" id="tableshow_div" style="display: none;">
  <table class="table table-bordered" id="example1">
                <tr>
                  <th> Sl.No </th>
                  <th> Tonnage Type </th>
                  <th> From Ton</th>
                  <th> To Ton</th>
                  <th> From Day</th>
                  <th> To Day</th>
                  <th> Amount </th>
                  <th> Min. Amount</th>
                  <th> Fine Amount</th>
                  <th> </th>
                  <th> </th>  
                </tr>
                <?php $i=1;foreach ($tariffList as $tariffDet) { ?>               
                <tr>
                  <td> <?php echo $i; ?></td>
                  <td> <?php echo $tariffDet['tonnagetype_name']; ?></td>
                  <th> <?php echo $tariffDet['tariff_from_ton']; ?></th>
                  <td> <?php echo $tariffDet['tariff_to_ton']; ?></td>
                  <td> <?php echo $tariffDet['tariff_from_day']; ?></td>
                  <td> <?php echo $tariffDet['tariff_to_day']; ?> </td>
                  <td> <?php echo $tariffDet['tariff_amount']; ?></td>
                  <td> <?php echo $tariffDet['tariff_min_amount']; ?></td>
                  <td> <?php echo $tariffDet['tariff_fine_amount']; ?></td>
                  <td>  <i class="fas fa-pencil-alt"></i> </td>
                  <td>  <i class="fas fa-trash-alt"></i></td>
                </tr>
                <?php $i++;}  ?>
              </table>
</div> <!-- end of table row -->
</div> <!-- end of containe  fluid -->
 <?php  echo form_close(); ?>   
<!-- ---------------------------------------------------------- Modal Window starts Here -------------------------------------------- -->
      <!-- The Modal -->
<div class="modal" id="instruction_modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">രജിസ്ട്രേഷൻ  ഫോം പൂരിപ്പിക്കുന്നതിനുള്ള നിർദ്ദേശങ്ങൾ  </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> <!-- ene of modal header -->
      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
  <div class="col-12"> <p class="text-danger"> <em> <strong>
    വിവരങ്ങൾ ഇംഗ്ളീഷിൽ മാത്രം പൂരിപ്പിക്കുക.</strong> </em> </p>
  </div> <!-- end of col -->
  <div class="col-2">
    Name 
  </div> <!-- end of col6 -->
  <div class="col-10">
    ഉടമയുടെ പേര് ടൈപ്പ് ചെയ്യുക. കുത്ത്, കോമ എന്നിവ ഉപയോഗിക്കാതിരിക്കുക. <hr>
  </div> <!-- end of col6 -->
  <div class="col-2">
  Date of birth </div>
  <div class="col-10">
    ഉടമയുടെ ജനനത്തീയ്യതി.  18 വയസ്സിന് താഴെയുള്ള ഉടമകൾ, രക്ഷിതാവിന്റെ വിവരങ്ങൾ അടുത്ത് ഫോമിൽ ചേർക്കേണ്ടതാണ്.  <hr>
  </div>
  <div class="col-2"> Mobile</div>
  <div class="col-10"> 
    നിങ്ങളുടെ 10 അക്ക മൊബൈൽ നമ്പർ നൽകുക. എല്ലാ വിവരങ്ങളും നിർദ്ദേശങ്ങളും ഈ മൊബൈൽ നമ്പറിൽ എസ്.എം.എസ് ആയി ലഭിക്കുന്നതാണ്. <hr>
  </div>
  <div class="col-2"> Email Id</div>
  <div class="col-10"> നിങ്ങളുടെ ഈമെയിൽ ഐഡി നൽകുക.
  എല്ലാ വിവരങ്ങളും നിർദ്ദേശങ്ങളും നിങ്ങൾ കൊടുത്തിരിക്കുന്ന ഈമെയിൽ ഐഡിയിൽ അലർട്ട് ആയി ലഭിക്കുന്നതാണ്. <hr>
  </div>
  <div class="col-2"> State</div>
  
  <div class="col-10"> 
    നിങ്ങളുടെ മേൽവിലാസം ഉൾപ്പെടുന്ന സംസ്ഥാനം തിരഞ്ഞെടുക്കുക. <hr>
  </div>
  <div class="col-2"> District</div>
  
  <div class="col-10"> 
    നിങ്ങളുടെ മേൽവിലാസം ഉൾപ്പെടുന്ന ജില്ല തിരഞ്ഞെടുക്കുക. <hr>
  </div>
  <div class="col-2"> Address</div>
  <div class="col-10"> 
    നിങ്ങളുടെ മേൽവിലാസം നൽകുക. മേൽവിലാസം ടൈപ്പ് ചെയ്യുമ്പോൾ  ഇംഗ്ളീഷ് അക്ഷരങ്ങൾ അക്കങ്ങൾ / (‌ ) , - . എന്നിവ മാത്രം ഉപയോഗിക്കുക. <hr> 
  </div>
  <div class="col-2"> Occupation address</div>
  <div class="col-10"> 
    നിങ്ങളുടെ ഔദ്യോഗിക മേൽവിലാസം നൽകുക. മേൽവിലാസം ടൈപ്പ് ചെയ്യുമ്പോൾ  ഇംഗ്ളീഷ് അക്ഷരങ്ങൾ അക്കങ്ങൾ / (‌ ) , - . എന്നിവ മാത്രം ഉപയോഗിക്കുക. <hr>
  </div>
  <div class="col-2"> Occupation</div>
  <div class="col-10"> 
    നിങ്ങളുടെ ഉദ്യോഗം തിരഞ്ഞെടുക്കുക. ലിസ്റ്റ് ചെയ്തവയിൽ നിങ്ങളുടെ ഉദ്യോഗം കാണുന്നില്ലെങ്കിൽ  Others എന്ന് തിരഞ്ഞെടുക്കുക. <hr>
  </div>
  <div class="col-2"> Do you have an agent ?</div>
  <div class="col-10">
    നിങ്ങൾ ഏജന്റ് മുഖേനയാണ് രജിസ്ട്രേഷനും മറ്റ് നടപടികളും നടത്തുന്നതെങ്കിൽ Do you have an agent എന്നത് സെലക്ട് ചെയ്യുക. 
    ഏജന്റിന്റെ വിവരങ്ങൾ അടുത്ത ഫോമിൽ ചേർക്കാവുന്നതാണ്. <hr>
   </div>
  <div class="col-2"> Do you co-owners ?</div>
  <div class="col-10"> 
    നിങ്ങൾക്ക് സഹഉടമകളുണ്ടെങ്കിൽ, Do you have co-owners എന്നത് സെലക്ട് ചെയ്യുക. തുടർന്ന് എത്ര സഹ ഉടമകൾ ഉണ്ടെന്ന് രേഖപ്പെടുത്തുക. <hr>
  </div>
  <div class="col-2"> Number of co-owner(s)</div>
  <div class="col-10"> 
    എത്ര സഹ ഉടമകൾ ഉണ്ടെന്ന് രേഖപ്പെടുത്തുക. 1 മുതൽ 8 സഹ ഉടമകളെ നിങ്ങൾക്ക് ചേർക്കാം. സഹഉടമകളുടെ വിവരങ്ങൾ അടുത്ത ഫോമിൽ രേഖപ്പെടുത്താവുന്നതാണ്. <hr>
  </div>
  <div class="col-2"> Identity Card</div>
  <div class="col-10"> 
    നിങ്ങളുടെ തിരിച്ചറിയൽ രേഖ തിരഞ്ഞെടുക്കുക. <hr>
  </div>
  <div class="col-2"> Identity Card number</div>
  <div class="col-10"> 
    നിങ്ങളുടെ തിരിച്ചറിയിൽ കാർഡിലെ നമ്പർ രേഖപ്പെടുത്തുക. ആധാർ ആണ് നൽകുന്നതെങ്കിൽ 12 അക്കം മാത്രം ടൈപ്പ് ചെയ്യുക. ഉദാഹരണം: 123412341234 <hr>
  </div>
  <div class="col-2">Upload Photograph </div>
  <div class="col-10"> 
    നിങ്ങളുടെ ഫോട്ടോഗ്രാഫ് അപ്‌‌ലോഡ് ചെയ്യുക. jpg/jpeg/png എന്നീ ഫോർമാറ്റിലുള്ള ഫോട്ടോകൾ മാത്രം അപ്‌‌ലോഡ് ചെയ്യുക. ചിത്രങ്ങളുടെ പരമാവധി സൈസ് : 50kbയിൽ താഴെ മാത്രം.
ചിത്രത്തിന്റെ നീളം  പരമാവധി 350 പിക്സലും വീതി പരമാവധി 150 പിക്സലും മാത്രം. <br>
നിങ്ങളുടെ ഫോട്ടോഗ്രാഫ് വലിയ സൈസിൽ ഉള്ളതാണെങ്കിൽ   <a href="http://registration.cdit.org" target="_blank" class="btn btn-outline-success btn-sm"> Click here for resizing larger images </a> എന്ന ലിങ്ക് ക്ളിക്ക് ചെയ്യുക. തുടർന്ന് വരുന്ന സൈറ്റ് സന്ദർശിക്കുക എന്നിട്ട് നിങ്ങളുടെ ഫോട്ടോ അവിടെ അപ്‌‌ലോഡ് ചെയ്തിട്ട് ഇമേജ് റീസൈസ് ചെയ്ത് ചെറുതാക്കുക. ആ ഇമേജ് ഡൗൺലോഡ് ചെയ്യുക. തുടർന്ന് റീസൈസ് ചെയ്ത് ചെറുതാക്കിയ ഇമേജ് ഇവിടെ അപ്‌‌ലോഡ് ചെയ്യുക.<hr>
  </div>
  <div class="col-2"> Upload Identity Card</div>
  <div class="col-10"> 
    നിങ്ങളുടെ തിരിച്ചറിയൽ കാർഡ് അപ്‌‌ലോഡ് ചെയ്യുക. തിരിച്ചറിയിൽ കാർഡിന്റെ ഫോർമാറ്റ് PDFൽ മാത്രം അപ്‌‌ലോഡ് ചെയ്യുക.
തിരിച്ചറിയൽ കാർഡിന്റെ അനുവദനീയമായ സൈസ് 1 എം.ബി.ക്ക് താഴെ മാത്രം. <hr>
  </div>
  <div class="col-6">
  </div> <!-- end of col6 -->
  <div class="col-6">
  </div> <!-- end of col6 -->
</div> <!-- end of row -->
      </div> <!-- end of modal body -->
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> <!-- end of modal footer -->
    </div> <!-- end of modal content -->
  </div> <!-- end of modal dialog -->
</div> <!-- end of modal div -->
<!-- ---------------------------------------------------------- Modal Window ends Here -------------------------------------------- -->