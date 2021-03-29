<script type="text/javascript" language="javascript">
$(document).ready(function() {
      
  $('#ports_list').validate({
    rules:
    { 
      ports_eng:{required:true },
      ports_mal:{required:true },
      address_eng:{required:true },
      address_mal:{required:true },
      ports_phone:{required:true, digits:true },
      ports_mail:{required:true },
      ports_map:{required:true }

    },
    messages:
    {
      ports_eng:{required:"<span><font color='red'>Please Enter Port Name in English!</span>"},
      ports_mal:{required:"<span><font color='red'>Please Enter Port Name in Malayalam!</span>"},
      address_eng:{required:"<span><font color='red'>Please Specify address in english!</span>"},
      address_mal:{required:"<span><font color='red'>Please Specify address in malayalam!</span>"},
      ports_phone:{required:"<span><font color='red'>Please Enter Phone Number!</span>",digits:"<span><font color='red'>Only digits allowed!</span>"},
      ports_mail:{required:"<span><font color='red'>Please Specify Email!</span>"},
      ports_map:{required:"<span><font color='red'>Please Specify Map Coordinates!</span>"},
 
    },
    errorPlacement: function(error, element)
    {
      if ( element.is(":input") ) { error.appendTo( element.parent() ); }
      else { error.insertAfter( element ); }
    }

  });


});

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
    window.alert("This field accepts only numbers");
    return false;
  }
}

function validateEmail(email) {
 
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( email ) ) {
      alert("Invalid Email");
      document.getElementById('ports_mail').value='';
        return false;
    } else {
        return true;
    }
}

function check_order(val){
  if(val>10){
    alert("The order limit must be between 1 and 10!!!");
    $("#ports_order").val('');
    $("#ports_order").focus();
    return false;
  }
}

function add_ports()
{
  $("#view_ports").hide();
  $("#edit_ports").hide();
  $("#add_ports").show();
}
  
function delete_ports()
{
  $("#add_ports").hide();
  $("#edit_ports").hide();
  $("#view_ports").show();
  $("#msgDiv").hide();
}

$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});

function ins_ports()
{ 

  var ports_eng     = $("#ports_eng").val(); 
  var ports_mal     = $("#ports_mal").val();
  var address_eng   = $("#address_eng").val(); 
  var address_mal   = $("#address_mal").val();
  var ports_phone   = $("#ports_phone").val(); 
  var ports_mail    = $("#ports_mail").val(); 
  var ports_map     = $("#ports_map").val();  
      
  if(ports_eng=="")
  {
    alert("Ports in English Required");
    $("#ports_eng").focus();
    return false;
            
  }
  if(ports_mal=="")
  {
    alert("Ports in Malayalam Required");
    $("#ports_mal").focus();
    return false;
  }
  if(address_eng=="")
  {
    alert("Address in English Required");
    $("#address_eng").focus();
    return false;
            
  }
  if(address_mal=="")
  {
    alert("Address in Malayalam Required");
    $("#address_mal").focus();
    return false;
  }
  if(ports_phone=="")
  {
    alert("Phone Number Required");
    $("#ports_phone").focus();
    return false;
  } else {
    var mob_length = ports_phone.length; 
    if(mob_length<10)
    {
      alert('Please enter 10 digit mobile number');
      $("#ports_phone").val('');
      return false;
    }
  }
   if(ports_mail=="")
  {
    alert("Email ID Required");
    $("#ports_mail").focus();
    return false;
  }
  
    //alert(ports_eng);    
  $.ajax({
    url : "<?php echo site_url('Super_Ctrl/Super/add_ports')?>",
    type: "POST",
    data:{ports_eng:ports_eng, ports_mal:ports_mal,address_eng:address_eng, address_mal:address_mal, ports_phone:ports_phone, ports_mail:ports_mail, ports_map:ports_map},
    dataType: "JSON",
    success: function(data)
    { //alert(data);exit;
      if(data['val_errors']!=""){
        //$("#msgDiv").show();
        var html ="";
        if(data['status']=="true")
        {
          var btn = "btn-success";
        }
        else
        {
          var btn = "btn-danger";
        }

        html ='<div id="msgDiv" class="alert '+btn+' alert-dismissible" >'+data['val_errors']+'</div>'
        //document.getElementById('msgDiv').innerHTML=""+data['val_errors']+"";
        //$("#example1").ajax.reload();

        $("#resp_msg").html(html);
        $("#ports_eng").val('');
        $("#ports_mal").val('');
        $("#address_eng").val('');
        $("#address_mal").val('');
       $("#ports_phone").val('');
       $("#ports_mail").val('');
      }
      else{
        window.location.reload(true);
      }
    }
  });
    
}



function toggle_status(id,status)
{ 
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/status_ports/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        //dataType: "JSON",
        success: function(data)
        { //alert(data['val_errors']);exit;
          window.location.reload(true);


        }
      });
}

function del_ports(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/delete_ports/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          if(data['result']==1)
          {
            window.location.reload(true);
          }
        }
  });
}
function edit_ports(id){ //alert(id);
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/edit_ports')?>",
        type: "POST",
        data:{ id:id},
        //dataType: "JSON",
        success: function(data)
        {
          //alert(data);
          $("#edit_ports").show();
          $("#add_ports").hide();
          $("#edit_ports").html(data);
          
        }
  });

}
/*function edit_title(id,i)
{
  $("#view_title").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_title_btn_"+i).hide();
  $("#save_title_"+i).show();
  $("#cancel_title_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} */
  
function cancel_ports(id,i)
{
  $("#view_ports").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_ports_btn_"+i).show();
  $("#save_ports_"+i).hide();
  $("#cancel_ports_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}

function save_ports(id)
{ alert(id);exit;
  var edit_ports_eng     = $("#edit_ports_eng").val(); 
  var edit_ports_mal     = $("#edit_ports_mal").val(); 
  var edit_tagline_eng   = $("#edit_tagline_eng").val(); 
  var edit_tagline_mal   = $("#edit_tagline_mal").val();
  var edit_location      = $("#edit_location").val();
  
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  

  if(edit_ports_eng=="")
  {
      alert("Registration Item in English Required");
      $("#edit_ports_eng").focus();
      return false;
      
  }
        
  if(edit_ports_mal=="")
  {
      alert("Registration Item in Malayalam Required");
      $("#edit_ports_mal").focus();
      return false;
  } 

  if(edit_tagline_eng=="")
  {
      alert("Tagline in English Required");
      $("#edit_tagline_eng").focus();
      return false;
      
  }
        
  if(edit_tagline_mal=="")
  {
      alert("Tagline in Malayalam Required");
      $("#edit_tagline_mal").focus();
      return false;
  }

  if(edit_location=="")
  {
      alert("Location Required");
      $("#edit_location").focus();
      return false;
  }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
  if (regex.exec(edit_ports_eng) == null) 
  {
    alert("Only alphabets and characters like .-_ are allowed in English Registration Item.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in English Registration Item.</font>";
    document.getElementById("edit_ports_eng").value = null;
    return false;
  } 
  if (regex.exec(edit_tagline_eng) == null) 
  {
    alert("Only Alphabets and characters like .-_ are Allowed in English tagline.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets and characters like .-_ are Allowed in English tagline.</font>";
    document.getElementById("edit_tagline_eng").value = null;
        return false;
  } 


  
  else{
    $.ajax({
          url : "<?php echo site_url('Super_Ctrl/Super/save_ports/')?>",
          type: "POST",
          data:{ id:id,edit_ports_eng:edit_ports_eng,edit_ports_mal:edit_ports_mal,edit_tagline_eng:edit_tagline_eng,edit_tagline_mal:edit_tagline_mal,location:location},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              //$("#example1").ajax.reload();

              
            }else{
          
          window.location.reload(true);

            }
          }
        });
    }
}  
 
</script>
<!----------------------------------------start of breadcrumb bar -------------------------------------- ------- -->
<div class="container-fluid ui-innerpage">
<div class="row py-1">
  <div class="col-4 breaddiv">
    <span class="badge bg-darkmagenta innertitle "> Ports </span>
  </div>  <!-- end of col4 -->
  <div class="col-8">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
     <li><a href="<?php echo $site_url."/Super_Ctrl/Super/SuperHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
  </ol>
</nav>
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
<!---------------------------------------- end of breadcrumb bar -------------------------------------- ------- -->
<!---------------------------------------- start of main content area  ---------------------------------------- -->
  <div id="resp_msg" >
    <!-- <div id="msgDiv" class="alert  alert-dismissible" style="display:none"></div>  -->
  </div>
    
    <!--  ---------------------------------- To fill Form PHP Code  ----------------------------------------------- -->
    <?php 
        $attributes = array("class" => "form-horizontal", "id" => "ports_list", "name" => "ports_list" );
    
    
          echo form_open("Super_Ctrl/Super/save_ports", $attributes);
     ?>
    <!-- <form name="ports_list" id="ports_list" method="post"   action="<?php echo $site_url.'/Super_Ctrl/Super/add_ports'?>" > -->
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_ports_list">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_ports()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Port</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    


    <div class="row py-3" id="add_ports" style="display:none;">

      <div class="col-3">
          <input type="text" name="ports_eng" maxlength="30" id="ports_eng" class="form-control "  placeholder=" Enter Port Name in English" onkeypress="return alpbabetspace(event);" autocomplete="off"/>
      </div>
      <div class="col-3">
          <input type="text" name="ports_mal" maxlength="50" id="ports_mal" class="form-control "  placeholder=" Enter Port Name in Malayalam" autocomplete="off"/>
      </div>

      <div class="col-3">
          <textarea name="address_eng" id="address_eng" placeholder="Address in English"></textarea><!-- <input type="text" name="tagline_eng" maxlength="150" id="tagline_eng" class="form-control "  placeholder=" Enter Tagline in English" autocomplete="off"/> -->
      </div>
      <div class="col-3">
          <textarea name="address_mal" id="address_mal" placeholder=" Address in Malayalam"></textarea><!-- <input type="text" name="tagline_mal" maxlength="150" id="tagline_mal" class="form-control "  placeholder=" Enter Tagline in Malayalam" autocomplete="off"/> -->
      </div> 

      <div class="col-3 pt-2 ">
          <input type="text" name="ports_phone" maxlength="11" id="ports_phone" class="form-control "  placeholder="Enter Phone Number" onkeypress="return IsNumeric(event);" autocomplete="off"  /> 
      </div>

      <div class="col-3">
        <input type="text" name="ports_mail" maxlength="150" id="ports_mail" class="form-control "  placeholder="Enter Email" autocomplete="off" onchange="return validateEmail(this.value);"  /> 
      </div>  <!-- end of col4 -->
      <div class="col-6">
          <textarea name="ports_map" id="ports_map" placeholder="Enter Map coordinates"></textarea><!-- <input type="text" name="tagline_mal" maxlength="150" id="tagline_mal" class="form-control "  placeholder=" Enter Tagline in Malayalam" autocomplete="off"/> -->
      </div> 
      

      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="button" name="ports_ins" id="ports_ins" value="Add Port Office" class="btn btn-info btn-flat" onClick="ins_ports()"  />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="del_ports" id="del_ports" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_ports()"  />
      </div> <!-- end of col6 -->
    </div> <!-- end of add row -->

<div class="row py-3" id="edit_ports" style="display:none;">
    </div>

    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
          <thead>
            <tr>
              <th id="sl">Sl.No</th>
              <th id="col_name">Port</th>
              <th id="col_name">Port in Malayalam</th>
              <!-- <th id="col_name">Location</th> -->
              <th>Status</th>
              <th id="th_div"></th>
              <!-- <th>&nbsp;</th> -->
            </tr>
          </thead>
          <tbody>
          <?php
          //print_r($data);
          $i=1;
          foreach($ports_list as $rowmodule){
          $id     = $rowmodule['int_portoffice_id'];
          
          ?>
            <tr id="<?php echo $i;?>">
              <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
              <td id="col_div_<?php echo $i; ?>">
                <div id="first_<?php echo $i;?>" ><?php echo $rowmodule['vchr_portoffice_name'];?></div>
              
              </td>
              <td id="col_div1_<?php echo $i; ?>">
                <div id="first1_<?php echo $i;?>" ><?php echo $rowmodule['portofregistry_mal_name'];?></div>
                
              </td>
             
                
               
                <td>
                  <?php  if($rowmodule['int_status']=='1')
                  {
                  ?>
                  <button class="btn btn-sm btn-flat btn-point btn-primary " type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['int_status'];?>);"  > <i class="far fa-bell"></i>   </button> 
                  <?php
                  }
                  else{
                    ?>
                     <button class="btn btn-sm btn-flat btn-point btn-warning"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['int_status'];?>);"> <i class=" fas fa-bell-slash
"></i>  </button> 
                    <?php
                  }
                  ?>
                </td>
                <td>
                  <div id="edit_div_<?php echo $i;?>">
                   
                    <button name="edit_ports_btn_<?php echo $i;?>" id="edit_ports_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_ports(<?php echo $id;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>          
                  </div>
                  <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_ports_<?php echo $i;?>" id="save_ports_<?php echo $i;?>" onclick="save_ports(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_ports_<?php echo $i;?>" id="cancel_ports_<?php echo $i;?>" onclick="cancel_ports(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                  </div>
                  </td>
                  <!-- <td>
                  <?php
          if($rowmodule['bodycontent_ctype']==1)
          {
          ?>
                  <button class="btn btn-sm btn-flat btn-point btn-danger " type="button" onclick="if(confirm('Are you sure to Delete Footer Item?')){ del_ports(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_ctype'];?>);}"> <i class="fas fa-trash-alt"></i> </button>
                  <?php
          }
          ?>
                  </td> -->
                 
                </tr>
                <?php
          $i++;
        }
          ?>
              
                </tbody>
                <?php
                 echo form_close(); ?>
              </table>
              <!-- ----------------------------------------------------- end of table column ------------------------------------- -->
              </div> <!-- end of table col12 -->
    </div> <!-- end of table row -->

</div>
<!---------------------------------------- end of main content area  ---------------------------------------- -->