<script type="text/javascript" language="javascript">
$(document).ready(function() {
      
  $('#services_list').validate({
    rules:
    { 
      services_eng:{required:true },
      services_mal:{required:true },
      location:{required:true },
    },
    messages:
    {
      services_eng:{required:"<font color='red'>Please Enter services!</span>"},
      services_mal:{required:"<font color='red'>Please Enter services in Malayalam!</span>"},
      location:{required:"<font color='red'>Please Select Location!</span>"},
 
    },
    errorPlacement: function(error, element)
    {
      if ( element.is(":input") ) { error.appendTo( element.parent() ); }
      else { error.insertAfter( element ); }
    }

  });

});



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
  var services_eng  = $("#services_eng").val(); 
  var services_mal  = $("#services_mal").val(); 
  var content_eng   = $("#content_eng").val(); 
  var content_mal   = $("#content_mal").val();
  
      
  if(services_eng=="")
  {
    alert("Title in English Required");
    $("#services_eng").focus();
    return false;
            
  }
  if(services_mal=="")
  {
    alert("Title in Malayalam Required");
    $("#services_mal").focus();
    return false;
  }
  
    //alert(services_eng);    
  $.ajax({
    url : "<?php echo site_url('Kiv_Ctrl/Master/add_services')?>",
    type: "POST",
    data:{services_eng:services_eng, services_mal:services_mal, content_eng:content_eng, content_mal:content_mal},
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
        $("#resp_msg").html(html);

        $("#services_eng").val('');
        $("#services_mal").val('');
        $("#content_eng").val('');
        $("#content_mal").val('');
        

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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_services/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}

function del_services(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_services/')?>",
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
function edit_services(id){ //alert(id);
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/edit_services')?>",
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

function save_services(id)
{ alert(id);exit;
  var edit_services_eng     = $("#edit_services_eng").val(); 
  var edit_services_mal     = $("#edit_services_mal").val(); 
  var edit_content_eng   = $("#edit_content_eng").val(); 
  var edit_content_mal   = $("#edit_content_mal").val();
  
  
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  

  if(edit_services_eng=="")
  {
      alert("services in English Required");
      $("#edit_services_eng").focus();
      return false;
      
  }
        
  if(edit_services_mal=="")
  {
      alert("services in Malayalam Required");
      $("#edit_services_mal").focus();
      return false;
  } 

  if(edit_content_eng=="")
  {
      alert("Tagline in English Required");
      $("#edit_content_eng").focus();
      return false;
      
  }
        
  if(edit_content_mal=="")
  {
      alert("Tagline in Malayalam Required");
      $("#edit_content_mal").focus();
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
  if (regex.exec(edit_services_eng) == null) 
  {
    alert("Only alphabets and characters like .-_ are allowed in English services.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in English services.</font>";
    document.getElementById("edit_services_eng").value = null;
    return false;
  } 
  if (regex.exec(edit_content_eng) == null) 
  {
    alert("Only Alphabets and characters like .-_ are Allowed in English tagline.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets and characters like .-_ are Allowed in English tagline.</font>";
    document.getElementById("edit_content_eng").value = null;
        return false;
  } 
else{
    $.ajax({
          url : "<?php echo site_url('Super_Ctrl/Super/save_services/')?>",
          type: "POST",
          data:{ id:id,edit_services_eng:edit_services_eng,edit_services_mal:edit_services_mal,edit_content_eng:edit_content_eng,edit_content_mal:edit_content_mal,location:location},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
            }else{
          
          window.location.reload(true);

            }
          }
        });
    }
}  
</script>
<!-- ------------------------------- Main Content Container starts here ----------------------- -->
<div class="main-content ui-innerpage px-1">
  <div class="row py-1">
  <div class="col-4 breaddiv">
    <span class="badge bg-darkmagenta innerservices "> Services </span>
  </div>  <!-- end of col4 -->
  <div class="col-8">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
     <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
  </ol>
</nav>
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
<div id="resp_msg" class="p-2">
    <div id="msgDiv" class="alert  alert-dismissible" style="display:none"></div> 
</div>
<?php 
        $attributes = array("class" => "form-horizontal", "id" => "services_list", "name" => "services_list" , "novalidate");
      echo form_open("Kiv_Ctrl/Master/save_services", $attributes);
?>
<div class="row py-3 px-2" id="view_services_list">
        <div class="col-12">
         <button type="button" class="btn btn-sm btn-primary" onClick="add_services()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Service</button>
         </div> <!-- end of col12 -->
</div> <!-- end of view row -->
<div class="row py-3 px-2" id="add_services" style="display:none;">
      <div class="col-6">
          <input type="text" name="services_eng" maxlength="100" id="services_eng" class="form-control "  placeholder=" Enter title in English" autocomplete="off"/>
      </div>
      <div class="col-6">
          <input type="text" name="services_mal" maxlength="100" id="services_mal" class="form-control "  placeholder=" Enter title in Malayalam" autocomplete="off"/>
      </div>
      <div class="col-12 py-2">
        <label class="p-2 innertitle bg-blue"> Description in English</label>
          <textarea name="content_eng" id="content_eng" class="summernote" placeholder=" Enter Content in English"></textarea>
      </div>
      <div class="col-12 py-2">
        <label class="p-2 innertitle bg-blue"> Description in Malayalam</label>
          <textarea name="content_mal" id="content_mal" class="summernote" placeholder=" Enter Content in Malayalam"></textarea>
      </div> 
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="button" name="services_ins" id="services_ins" value="Add Services" class="btn btn-info btn-flat" onClick="ins_services()"  />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="services_del" id="services_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_services()"  />
      </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
<!-- ---------------------------------- end of add row ----------------------------------------- -->
<div class="row py-3 px-2" id="edit_services" style="display:none;">
 </div>
 <div class="row p-2">
        <div class="col-12">
        <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th id="sl">Sl.No</th>
              <th id="col_name">Services</th>
              <th id="col_name">Services in Malayalam</th>
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
          $id     = $rowmodule['bodycontent_sl'];
          ?>
            <tr id="<?php echo $i;?>">
              <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
              <td id="col_div_<?php echo $i; ?>">
                <div id="first_<?php echo $i;?>" ><?php echo $rowmodule['bodycontent_engtitle'];?></div>
              </td>
              <td id="col_div1_<?php echo $i; ?>">
                <div id="first1_<?php echo $i;?>" ><?php echo $rowmodule['bodycontent_maltitle'];?></div>
              </td>
                <td>
                  <?php  if($rowmodule['bodycontent_status_sl']=='1')
                  {
                  ?>
                  <button class="btn btn-sm btn-flat btn-point btn-primary " type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_status_sl'];?>);"  > <i class="far fa-bell"></i>   </button> 
                  <?php
                  }
                  else{
                    ?>
                     <button class="btn btn-sm btn-flat btn-point btn-warning"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_status_sl'];?>);"> <i class=" fas fa-bell-slash
"></i>  </button> 
                    <?php
                  }
                  ?>
                </td>
                <td>
                  <div id="edit_div_<?php echo $i;?>">
                    <button name="edit_services_btn_<?php echo $i;?>" id="edit_services_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_services(<?php echo $id;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>          
                  </div>
                  <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_services_<?php echo $i;?>" id="save_services_<?php echo $i;?>" onclick="save_services(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_services_<?php echo $i;?>" id="cancel_services_<?php echo $i;?>" onclick="cancel_services(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                  </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['bodycontent_ctype']==1)
          {
          ?>
                  <button class="btn btn-sm btn-flat btn-point btn-danger " type="button" onclick="if(confirm('Are you sure to Delete Service?')){ del_services(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_ctype'];?>);}"> <i class="fas fa-trash-alt"></i> </button>
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
              </table>
            </div> <!-- end of table responsive -->
         </div> <!-- end of table col12 -->
    </div> <!-- end of table row -->
    <?php echo form_close(); ?>
</div> <!-- end of main content div -->
<!-- ------------------------------- Main Content Container ends here ----------------------- -->