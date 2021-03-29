<script type="text/javascript" language="javascript">
$(document).ready(function() {
      
  $('#registration_list').validate({
    rules:
    { 
      registration_eng:{required:true },
      registration_mal:{required:true },
      location:{required:true },
    },
    messages:
    {
      registration_eng:{required:"<font color='red'>Please Enter registration!</span>"},
      registration_mal:{required:"<font color='red'>Please Enter registration in Malayalam!</span>"},
      location:{required:"<font color='red'>Please Select Location!</span>"},
 
    },
    errorPlacement: function(error, element)
    {
      if ( element.is(":input") ) { error.appendTo( element.parent() ); }
      else { error.insertAfter( element ); }
    }

  });

});



function add_registration()
{
  $("#view_registration").hide();
  $("#edit_registration").hide();
  $("#add_registration").show();
}
  
function delete_registration()
{
  $("#add_registration").hide();
  $("#edit_registration").hide();
  $("#view_registration").show();
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

function ins_registration()
{ 
  var registration_eng     = $("#registration_eng").val(); 
  var registration_mal     = $("#registration_mal").val();
  var registration_desc_eng= $("#registration_desc_eng").val(); 
  var registration_desc_mal= $("#registration_desc_mal").val(); 
      
  if(registration_eng=="")
  {
    alert("Registration in English Required");
    $("#registration_eng").focus();
    return false;
            
  }
  if(registration_mal=="")
  {
    alert("Registration in Malayalam Required");
    $("#registration_mal").focus();
    return false;
  }
  
    //alert(registration_eng);    
  $.ajax({
    url : "<?php echo site_url('Super_Ctrl/Super/add_registration')?>",
    type: "POST",
    data:{registration_eng:registration_eng, registration_mal:registration_mal, registration_desc_eng:registration_desc_eng, registration_desc_mal:registration_desc_mal},
    dataType: "JSON",
    success: function(data)
    { //alert(data['status']);exit;
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
        $("#registration_eng").val('');
        $("#registration_mal").val('');
        $("#registration_desc_eng").val('');/*67255395400*/
        $("#registration_desc_mal").val('');
       
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
        url : "<?php echo site_url('Super_Ctrl/Super/status_registration/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}

function del_registration(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/delete_registration/')?>",
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
function edit_registration(id){ //alert(id);
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/edit_registration')?>",
        type: "POST",
        data:{ id:id},
        //dataType: "JSON",
        success: function(data)
        {
          //alert(data);
          $("#edit_registration").show();
          $("#add_registration").hide();
          $("#edit_registration").html(data);
          
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
  
function cancel_registration(id,i)
{
  $("#view_registration").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_registration_btn_"+i).show();
  $("#save_registration_"+i).hide();
  $("#cancel_registration_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}

function save_registration(id)
{ alert(id);exit;
  var edit_registration_eng     = $("#edit_registration_eng").val(); 
  var edit_registration_mal     = $("#edit_registration_mal").val(); 
  var edit_tagline_eng   = $("#edit_tagline_eng").val(); 
  var edit_tagline_mal   = $("#edit_tagline_mal").val();
  var edit_location      = $("#edit_location").val();
  
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  

  if(edit_registration_eng=="")
  {
      alert("registration in English Required");
      $("#edit_registration_eng").focus();
      return false;
      
  }
        
  if(edit_registration_mal=="")
  {
      alert("registration in Malayalam Required");
      $("#edit_registration_mal").focus();
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
  if (regex.exec(edit_registration_eng) == null) 
  {
    alert("Only alphabets and characters like .-_ are allowed in English registration.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in English registration.</font>";
    document.getElementById("edit_registration_eng").value = null;
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
          url : "<?php echo site_url('Super_Ctrl/Super/save_registration/')?>",
          type: "POST",
          data:{ id:id,edit_registration_eng:edit_registration_eng,edit_registration_mal:edit_registration_mal,edit_tagline_eng:edit_tagline_eng,edit_tagline_mal:edit_tagline_mal,location:location},
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
    <span class="badge bg-darkmagenta innertitle "> Registration </span>
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
  <div id="resp_msg">
    <!-- <div id="msgDiv" class="alert  alert-dismissible" style="display:none"></div>  -->
  </div>
    
    <!--  ---------------------------------- To fill Form PHP Code  ----------------------------------------------- -->
    <?php 
        $attributes = array("class" => "form-horizontal", "id" => "registration_list", "name" => "registration_list" , "novalidate");
    
    
          echo form_open("Super_Ctrl/Super/save_registration", $attributes);
     ?>
    <!-- <form name="registration_list" id="registration_list" method="post"   action="<?php echo $site_url.'/Super_Ctrl/Super/add_registration'?>" > -->
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_registration_list">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_registration()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New registration</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    


    <div class="row py-3" id="add_registration" style="display:none;">

      <div class="col-6">
          <input type="text" name="registration_eng" maxlength="150" id="registration_eng" class="form-control "  placeholder=" Enter title in English" autocomplete="off"/>
      </div>
      <div class="col-6">
          <input type="text" name="registration_mal" maxlength="150" id="registration_mal" class="form-control "  placeholder=" Enter title in Malayalam" autocomplete="off"/>
      </div>
      <div class="col-12 py-2">
        <label class="p-2 innertitle bg-blue"> Description in English</label>
          <textarea name="registration_desc_eng" id="registration_desc_eng" class="form-control summernote"  placeholder=" Description in English"></textarea>
      </div>
      <div class="col-12 py-2">
         <label class="p-2 innertitle bg-blue"> Description in Malayalam</label>
          <textarea name="registration_desc_mal" id="registration_desc_mal" class="form-control summernote "  placeholder=" Description in Malayalam"></textarea>
      </div>

      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="button" name="registration_ins" id="registration_ins" value="Add Registration Info" class="btn btn-info btn-flat" onClick="ins_registration()"  />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="registration_del" id="registration_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_registration()"  />
      </div> <!-- end of col6 -->
    </div> <!-- end of add row -->

<div class="row py-3" id="edit_registration" style="display:none;">
    </div>

    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
          <thead>
            <tr>
              <th id="sl">Sl.No</th>
              <th id="col_name">Registration</th>
              <th id="col_name">Registration in Malayalam</th>
              <th id="col_name">Location</th>
              <th>Status</th>
              <th id="th_div"></th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          <?php
          //print_r($data);
          $i=1;
          foreach($registration_list as $rowmodule){
          $id     = $rowmodule['bodycontent_sl'];
          $loc_id = $rowmodule['bodycontent_location_sl'];
          $loc    = $this->Super_model->get_location_byid($loc_id);
          foreach($loc as $loc_res){
            $location_name = $loc_res['location_name'];
          }
          ?>
            <tr id="<?php echo $i;?>">
              <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
              <td id="col_div_<?php echo $i; ?>">
                <div id="first_<?php echo $i;?>" ><?php echo $rowmodule['bodycontent_engtitle'];?></div>
               <!--  <div id="hide_<?php echo $i;?>"  style="display:none">
                  <input maxlength="20" class="div300" type="text" name="edit_title_eng_<?php echo $i;?>"  id="edit_title_eng_<?php  echo $i;?>" value="<?php echo $rowmodule['bodycontent_engtitle'];?>" onchange="check_dup_title_edit(<?php echo $i;?>);"   autocomplete="off"/>
                </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>  -->
              </td>
              <td id="col_div1_<?php echo $i; ?>">
                <div id="first1_<?php echo $i;?>" ><?php echo $rowmodule['bodycontent_maltitle'];?></div>
                <!-- <div id="hide1_<?php echo $i;?>"  style="display:none">
                  <input maxlength="20" class="div300" type="text" name="edit_title_mal_<?php echo $i;?>"  id="edit_title_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['bodycontent_maltitle'];?>" onchange="check_dup_title_edit(<?php echo $i;?>);"   autocomplete="off"/>
                </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>  -->
              </td>
              <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $location_name;?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none">
                  <select name="edit_location_<?php echo $i;?>" id="edit_location_<?php echo $i;?>" class="form-control js-example-basic-single" style="width: 100%;">
                    <option value="">Select Location</option> 
                    <?php foreach($location as $loc_res){ ?>
                    <option value="<?php echo $loc_res['location_sl']; ?>"<?php if($loc_res['location_sl']==$loc_id) { ?> selected="selected" <?php } ?>><?php echo $loc_res['location_name']; ?></option>
                       <?php }  ?>
                  </select>
                  </div>
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
                    <!-- <button name="edit_title_btn_<?php echo $i;?>" id="edit_title_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_title(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>  -->  
                    <button name="edit_registration_btn_<?php echo $i;?>" id="edit_registration_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_registration(<?php echo $id;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>          
                  </div>
                  <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_registration_<?php echo $i;?>" id="save_registration_<?php echo $i;?>" onclick="save_registration(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_registration_<?php echo $i;?>" id="cancel_registration_<?php echo $i;?>" onclick="cancel_registration(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                  </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['bodycontent_ctype']==1)
          {
          ?>
                  <button class="btn btn-sm btn-flat btn-point btn-danger " type="button" onclick="if(confirm('Are you sure to Delete registration?')){ del_registration(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_ctype'];?>);}"> <i class="fas fa-trash-alt"></i> </button>
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