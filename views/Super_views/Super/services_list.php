<script type="text/javascript" language="javascript">
$(document).ready(function() {
      
  $('#services_list').validate({
    rules:
    { 
      services_eng:{required:true },
      services_mal:{required:true }
      
    },
    messages:
    {
      services_eng:{required:"<span><font color='red'>Please Enter Service Name in English!</span>"},
      services_mal:{required:"<span><font color='red'>Please Enter Service Name in Malayalam!</span>"}
      
 
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


function add_services()
{
  $("#view_services").hide();
  $("#edit_services").hide();
  $("#add_services").show();
}
  
function delete_services()
{
  $("#add_services").hide();
  $("#edit_services").hide();
  $("#view_services").show();
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

function ins_services()
{ 

  var services_eng     = $("#services_eng").val(); 
  var services_mal     = $("#services_mal").val();
  
      
  if(services_eng=="")
  {
    alert("Service Name in English Required");
    $("#services_eng").focus();
    return false;
            
  }
  if(services_mal=="")
  {
    alert("Service Name in Malayalam Required");
    $("#services_mal").focus();
    return false;
  }
  
  
    //alert(ports_eng);    
  $.ajax({
    url : "<?php echo site_url('Super_Ctrl/Super/add_services')?>",
    type: "POST",
    data:{services_eng:services_eng, services_mal:services_mal},
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
        $("#services_eng").val('');
        $("#services_mal").val('');
       
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
        url : "<?php echo site_url('Super_Ctrl/Super/status_services/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        //dataType: "JSON",
        success: function(data)
        { //alert(data['val_errors']);exit;
          window.location.reload(true);


        }
      });
}

function del_services(id,status)
{ 
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/delete_services/')?>",
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
/*function edit_services(id){ //alert(id);
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/edit_services')?>",
        type: "POST",
        data:{ id:id},
        //dataType: "JSON",
        success: function(data)
        {
          //alert(data);
          $("#edit_services").show();
          $("#add_services").hide();
          $("#edit_services").html(data);
          
        }
  });

}*/
function edit_services(id,i)
{
  $("#view_services").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_services_btn_"+i).hide();
  $("#save_services_"+i).show();
  $("#cancel_services_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_services(id,i)
{
  $("#view_services").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_services_btn_"+i).show();
  $("#save_services_"+i).hide();
  $("#cancel_services_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}

function save_services(id,i)
{ //alert(id);exit;
  var edit_services_eng = $("#edit_services_eng_"+i).val();
  var edit_services_mal = $("#edit_services_mal_"+i).val();
  
  
  
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  

  if(edit_services_eng=="")
  {
      alert("Service in English Required");
      $("#edit_services_eng").focus();
      return false;
      
  }
        
  if(edit_services_mal=="")
  {
      alert("Service in Malayalam Required");
      $("#edit_services_mal").focus();
      return false;
  } 

 
  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
  if (regex.exec(edit_services_eng) == null) 
  {
    alert("Only alphabets and characters like .-_ are allowed in English Registration Item.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in English Registration Item.</font>";
    document.getElementById("edit_services_eng").value = null;
    return false;
  } 
  


  
  else{
    $.ajax({
          url : "<?php echo site_url('Super_Ctrl/Super/edit_services/')?>",
          type: "POST",
          data:{ id:id,edit_services_eng:edit_services_eng,edit_services_mal:edit_services_mal},
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
             
             
            }
            else{
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
    <span class="badge bg-darkmagenta innertitle "> Services </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "services_list", "name" => "services_list" );
    
    
          //echo form_open("Super_Ctrl/Super/save_services", $attributes);
     ?>
    <!-- <form name="services_list" id="services_list" method="post"   action="<?php echo $site_url.'/Super_Ctrl/Super/add_services'?>" > -->
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_services_list">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_services()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Service</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    


    <div class="row py-3" id="add_services" style="display:none;">

      <div class="col-6">
          <input type="text" name="services_eng" maxlength="30" id="services_eng" class="form-control "  placeholder=" Enter Service Name in English" onkeypress="return alpbabetspace(event);" autocomplete="off"/>
      </div>
      <div class="col-6">
          <input type="text" name="services_mal" maxlength="50" id="services_mal" class="form-control "  placeholder=" Enter Service Name in Malayalam" autocomplete="off"/>
      </div>

      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="button" name="services_ins" id="services_ins" value="Add Service" class="btn btn-info btn-flat" onClick="ins_services()"  />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="services_del" id="services_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_services()"  />
      </div> <!-- end of col6 -->
    </div> <!-- end of add row -->

<div class="row py-3" id="edit_services" style="display:none;">
    </div>

    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
          <thead>
            <tr>
              <th id="sl">Sl.No</th>
              <th id="col_name">Service</th>
              <th id="col_name">Service in Malayalam</th>
              <!-- <th id="col_name">Location</th> -->
              <th>Status</th>
              <th id="th_div"></th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          <?php
          //print_r($data);
          $i=1;
          foreach($services_list as $rowmodule){
          $id     = $rowmodule['services_sl'];
          
          ?>
            <tr id="<?php echo $i;?>">
              <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
              <td id="col_div_<?php echo $i; ?>">
                <div id="first_<?php echo $i;?>" ><?php echo $rowmodule['services_engtitle'];?></div>
                <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_services_eng_<?php echo $i;?>"  id="edit_services_eng_<?php  echo $i;?>" value="<?php echo $rowmodule['services_engtitle'];?>"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
              </td>
              <td id="col_div1_<?php echo $i; ?>">
                <div id="first1_<?php echo $i;?>" ><?php echo $rowmodule['services_maltitle'];?></div>
                <div id="hide1_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_services_mal_<?php echo $i;?>"  id="edit_services_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['services_maltitle'];?>"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
              </td>
             
                
               
                <td>
                  <?php  if($rowmodule['services_status']=='1')
                  {
                  ?>
                  <button class="btn btn-sm btn-flat btn-point btn-primary " type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['services_status'];?>);"  > <i class="far fa-bell"></i>   </button> 
                  <?php
                  }
                  else{
                    ?>
                     <button class="btn btn-sm btn-flat btn-point btn-warning"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['services_status'];?>);"> <i class=" fas fa-bell-slash
"></i>  </button> 
                    <?php
                  }
                  ?>
                </td>
                <td>
                  <div id="edit_div_<?php echo $i;?>">
                   
                    <button name="edit_services_btn_<?php echo $i;?>" id="edit_services_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_services(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>          
                  </div>
                  <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_services_<?php echo $i;?>" id="save_services_<?php echo $i;?>" onclick="save_services(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_services_<?php echo $i;?>" id="cancel_services_<?php echo $i;?>" onclick="cancel_services(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                  </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['services_ctype']==1)
          {
          ?>
                  <button class="btn btn-sm btn-flat btn-point btn-danger " type="button" onclick="if(confirm('Are you sure to Delete Service?')){ del_services(<?php echo $id;?>,<?php echo $rowmodule['services_ctype'];?>);}"> <i class="fas fa-trash-alt"></i> </button>
                  <?php
          }
          ?>
                  </td>
                 
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