<script type="text/javascript" language="javascript">
$(document).ready(function() {
      
  $('#web_notfn_list').validate({
    rules:
    { 
      web_notfn_eng:{required:true },
      web_notfn_mal:{required:true },
      location:{required:true },
    },
    messages:
    {
      web_notfn_eng:{required:"<font color='red'>Please Enter web_notfn!</span>"},
      web_notfn_mal:{required:"<font color='red'>Please Enter web_notfn in Malayalam!</span>"},
      location:{required:"<font color='red'>Please Select Location!</span>"},
 
    },
    errorPlacement: function(error, element)
    {
      if ( element.is(":input") ) { error.appendTo( element.parent() ); }
      else { error.insertAfter( element ); }
    }

  });

});



function add_web_notfn()
{
  $("#view_web_notfn").hide();
  $("#edit_web_notfn").hide();
  $("#add_web_notfn").show();
}
  
function delete_web_notfn()
{
  $("#add_web_notfn").hide();
  $("#edit_web_notfn").hide();
  $("#view_web_notfn").show();
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

function ins_web_notfn()
{
  var web_notfn_eng = $("#web_notfn_eng").val(); 
  var web_notfn_mal = $("#web_notfn_mal").val(); 
  var content_eng   = $("#content_eng").val(); 
  var content_mal   = $("#content_mal").val();
  var location      = $("#location").val();
  
      
  if(web_notfn_eng=="")
  {
    alert("Title in English Required");
    $("#web_notfn_eng").focus();
    return false;
            
  }
  if(web_notfn_mal=="")
  {
    alert("Title in Malayalam Required");
    $("#web_notfn_mal").focus();
    return false;
  }
  
    //alert(web_notfn_eng);    
  $.ajax({
    url : "<?php echo site_url('Kiv_Ctrl/Master/add_web_notfn')?>",
    type: "POST",
    data:{web_notfn_eng:web_notfn_eng, web_notfn_mal:web_notfn_mal, content_eng:content_eng, content_mal:content_mal},
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

        $("#web_notfn_eng").val('');
        $("#web_notfn_mal").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_web_notfn/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}

function del_web_notfn(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_web_notfn/')?>",
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
function edit_web_notfn(id){ //alert(id);
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/edit_web_notfn')?>",
        type: "POST",
        data:{ id:id},
        //dataType: "JSON",
        success: function(data)
        {
          //alert(data);
          $("#edit_web_notfn").show();
          $("#add_web_notfn").hide();
          $("#edit_web_notfn").html(data);
          
        }
  });

}

/*function edit_web_notfn(id,i)
{
  $("#view_web_notfn").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_web_notfn_btn_"+i).hide();
  $("#save_web_notfn_"+i).show();
  $("#cancel_web_notfn_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} */
  
function cancel_web_notfn(id,i)
{
  $("#view_web_notfn").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_web_notfn_btn_"+i).show();
  $("#save_web_notfn_"+i).hide();
  $("#cancel_web_notfn_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}

function save_web_notfn(id)
{ alert(id);exit;
  var edit_web_notfn_eng     = $("#edit_web_notfn_eng").val(); 
  var edit_web_notfn_mal     = $("#edit_web_notfn_mal").val(); 
  var edit_content_eng   = $("#edit_content_eng").val(); 
  var edit_content_mal   = $("#edit_content_mal").val();
  var edit_location      = $("#edit_location").val();
  
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  

  if(edit_web_notfn_eng=="")
  {
      alert("web_notfn in English Required");
      $("#edit_web_notfn_eng").focus();
      return false;
      
  }
        
  if(edit_web_notfn_mal=="")
  {
      alert("web_notfn in Malayalam Required");
      $("#edit_web_notfn_mal").focus();
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
  if (regex.exec(edit_web_notfn_eng) == null) 
  {
    alert("Only alphabets and characters like .-_ are allowed in English web_notfn.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in English web_notfn.</font>";
    document.getElementById("edit_web_notfn_eng").value = null;
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
          url : "<?php echo site_url('Super_Ctrl/Super/save_web_notfn/')?>",
          type: "POST",
          data:{ id:id,edit_web_notfn_eng:edit_web_notfn_eng,edit_web_notfn_mal:edit_web_notfn_mal,edit_content_eng:edit_content_eng,edit_content_mal:edit_content_mal,location:location},
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
<!-- ------------------------------ --- Container starts here ----------------------- -->
<div class="main-content ui-innerpage">
  <div class="row py-1 px-2">
  <div class="col-4 breaddiv">
    <span class="badge bg-darkmagenta innerweb_notfn "> Web Notifications </span>
  </div>  <!-- end of col4 -->
  <div class="col-8">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
     <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
  </ol>
</nav>
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
<div id="resp_msg">
    <div id="msgDiv" class="alert  alert-dismissible" style="display:none"></div> 
</div>
<?php 
  $attributes = array("class" => "form-horizontal", "id" => "web_notfn_list", "name" => "web_notfn_list" , "novalidate");
  echo form_open("Kiv_Ctrl/Master/save_web_notfn", $attributes);
?>
<div class="row py-3 px-2" id="view_web_notfn_list">
        <div class="col-12">
         <button type="button" class="btn btn-sm btn-primary" onClick="add_web_notfn()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Web Notification</button>
         </div> <!-- end of col12 -->
</div> <!-- end of view row -->
<!-- ------------------------ Add row starts here -------------------------------- -->
<div class="row py-3 px-2" id="add_web_notfn" style="display:none;">
      <div class="col-6">
          <input type="text" name="web_notfn_eng" maxlength="100" id="web_notfn_eng" class="form-control "  placeholder=" Enter title in English" autocomplete="off"/>
      </div>
      <div class="col-6">
          <input type="text" name="web_notfn_mal" maxlength="100" id="web_notfn_mal" class="form-control "  placeholder=" Enter title in Malayalam" autocomplete="off"/>
      </div>
      <div class="col-12 py-2">
        <label class="p-2 innertitle bg-blue"> Description in English</label>
          <textarea name="content_eng" id="content_eng" class="summernote" placeholder=" Enter Content in English"></textarea>
      </div>
      <div class="col-12 py-2">
        <label class="p-2 innertitle bg-blue"> Description in Malayalam</label>
          <textarea name="content_mal" id="content_mal" class="summernote"  placeholder=" Enter Content in Malayalam"></textarea>
      </div> 
      
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="button" name="web_notfn_ins" id="web_notfn_ins" value="Add Notification" class="btn btn-info btn-flat" onClick="ins_web_notfn()"  />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="web_notfn_del" id="web_notfn_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_web_notfn()"  />
      </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
<!-- ------------------------ Add row ends here -------------------------------- -->
<div class="row py-3" id="edit_web_notfn" style="display:none;">
</div>
    <div class="row p-2">
        <div class="col-12 table-responsive">
        <table id="example1" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th id="sl">Sl.No</th>
              <th id="col_name">Web Notification</th>
              <th id="col_name">Malayalam Web Notification</th>
              <th>Status</th>
              <th id="th_div"></th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          <?php
          //print_r($data);
          $i=1;
          foreach($web_notfn_list as $rowmodule){
          $id     = $rowmodule['webnotification_sl'];
         
          ?>
            <tr id="<?php echo $i;?>">
              <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
              <td id="col_div_<?php echo $i; ?>">
                <div id="first_<?php echo $i;?>" ><?php echo $rowmodule['webnotification_engtitle'];?></div>
              
              </td>
              <td id="col_div1_<?php echo $i; ?>">
                <div id="first1_<?php echo $i;?>" ><?php echo $rowmodule['webnotification_maltitle'];?></div>
              </td>
                <td>
                  <?php  if($rowmodule['webnotification_status']=='1')
                  {
                  ?>
                  <button class="btn btn-sm btn-flat btn-point btn-primary " type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['webnotification_status'];?>);"  > <i class="far fa-bell"></i>   </button> 
                  <?php
                  }
                  else{
                    ?>
                     <button class="btn btn-sm btn-flat btn-point btn-warning"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['webnotification_status'];?>);"> <i class=" fas fa-bell-slash
"></i>  </button> 
                    <?php
                  }
                  ?>
                </td>
                <td>
                  <div id="edit_div_<?php echo $i;?>">
                    <button name="edit_web_notfn_btn_<?php echo $i;?>" id="edit_web_notfn_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_web_notfn(<?php echo $id;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>          
                  </div>
                  <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_web_notfn_<?php echo $i;?>" id="save_web_notfn_<?php echo $i;?>" onclick="save_web_notfn(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_web_notfn_<?php echo $i;?>" id="cancel_web_notfn_<?php echo $i;?>" onclick="cancel_web_notfn(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                  </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['webnotification_ctype']==1)
          {
          ?>
                  <button class="btn btn-sm btn-flat btn-point btn-danger " type="button" onclick="if(confirm('Are you sure to Delete Notification?')){ del_web_notfn(<?php echo $id;?>,<?php echo $rowmodule['webnotification_ctype'];?>);}"> <i class="fas fa-trash-alt"></i> </button>
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
              </div> <!-- end of table col12 -->
    </div> <!-- end of table row -->
    <?php echo form_close(); ?>
</div> <!-- end of main content container -->
<!-- ------------------------------ --- Container ends here ----------------------- -->