<script type="text/javascript" language="javascript">
$(document).ready(function() {
        
     jQuery.validator.addMethod("nospecial", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]{1,}[a-zA-Z0-9\s.-]+$/.test(value);
      });     
      
     jQuery.validator.addMethod("nospecialmin", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]+$/.test(value);
      }); 
     jQuery.validator.addMethod("alphaonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]{1,}[a-zA-Z\s.-]+$/.test(value);
      });     
      
   $('#user').validate({
      rules:
               { 
          user_name:{required:true,
          nospecial:true,
          maxlength:50, },

          user_password:{required:true,
          nospecial:true,
          maxlength:50, },
                     },
      messages:
               {
             user_name:{
             required:"<font color='red'>Please enter User Name</span>",
             nospecial:"<font color='red'>Only alphabets,numbers and characters like .-_ are allowed</font>",
             maxlength:"<font color='red'>Maximum 50 Characters allowed</font>"},
             
             user_password:{
             required:"<font color='red'>Please enter User Password</span>",
             nospecial:"<font color='red'>Only alphabets,numbers and characters like .-_ are allowed</font>",
             maxlength:"<font color='red'>Maximum 50 Character allowed</font>"},
 
               },
      errorPlacement: function(error, element)
                     {
                        if ( element.is(":input") ) { error.appendTo( element.parent() ); }
                        else { error.insertAfter( element ); }
                     }
    }); 
});

function add_user()
{
    $("#view_user").hide();
  $("#add_user").show();
}
  
function delete_user()
{
  $("#add_user").hide();
  $("#view_user").show();
  $("#msgDiv").hide();
}
function ins_user()
{
    var user_ins    = $("#user_ins").val(); 
    var user_name   = $("#user_name").val(); 
    var user_password = $("#user_password").val();
      
  if(user_name=="")
        {
            alert("User Name Required");
            $("#user_name").focus();
            return false;
            
        }
        
        if(user_password=="")
        {
            alert("User Password Required");
            $("#user_password").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_user/')?>",
          type: "POST",
          data:{user_ins:user_ins, user_name:user_name,user_password:user_password},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#user_name").val('');
              $("#user_password").val('');
            }
            else{
              window.location.reload(true);
            }
          }
        });
    
}
function toggle_status(id,status)
{
  
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_user/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_user(id,status)
{
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_user/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {//alert(data['result']);
          if(data['result']==1)
          {
            window.location.reload(true);
          }
        }
      });
}


function edit_user(id,i)
{
  $("#view_user").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_user_btn_"+i).hide();
  $("#save_user_"+i).show();
  $("#cancel_user_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_user(id,i)
{
  $("#view_user").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_user_btn_"+i).show();
  $("#save_user_"+i).hide();
  $("#cancel_user_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_user(id,i)
{
  var edit_user= $("#edit_user_"+i).val();
  var edit_user_password= $("#edit_user_password_"+i).val();
  //var re = /^[ A-Za-z0-9]*$/;



  var regex = new RegExp("^[a-zA-Z0-9\ \.\-]+$");
    if (regex.exec(edit_user) == null) 
  {
        alert("Only alphabets,numbers and characters like .-_ are allowed in User Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in User Name.</font>";
        document.getElementById("edit_user").value = null;
        return false;
    } 
      if (regex.exec(edit_user_password) == null) 
  {
        alert("Only alphabets,numbers and characters like .-_ are allowed in User Pasword.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in User Pasword.</font>";
        document.getElementById("edit_user_password").value = null;
        return false;
    } 



  if(edit_user=="" ||  edit_user_password==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter User Name And User Password</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_user/')?>",
          type: "POST",
          data:{ id:id,edit_user:edit_user,edit_user_password:edit_user_password},
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
<!----------------------------------------start of breadcrumb bar -------------------------------------- ------- -->
<div class="container-fluid ui-innerpage">
<div class="row py-1">
  <div class="col-4 breaddiv">
    <span class="badge bg-darkmagenta innertitle "> User </span>
  </div>  <!-- end of col4 -->
  <div class="col-8">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
     <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
  </ol>
</nav>
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
<!---------------------------------------- end of breadcrumb bar -------------------------------------- ------- -->
<!---------------------------------------- start of main content area  ---------------------------------------- -->
    <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
    <!--  ---------------------------------- To fill Form PHP Code  ----------------------------------------------- -->
    <?php 
        $attributes = array("class" => "form-horizontal", "id" => "user", "name" => "user" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_user", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_user", $attributes);
    }?>
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_vesselcategory">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_vesselcategory" style="display:none;">
             <div class="col-4">
             
             </div> <!-- end of col34 -->
              <div class="col-4">
            
             </div>  <!-- end of col4 -->
              <div class="col-4">
            
             </div>  <!-- end of col4 -->
             <div class="col-6">
             
             </div>  <!-- end of col6 -->
             <div class="col-6">
            
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <!--<th id="sl">Sl.No</th>
                  <th id="col_name">User Name</th>
                  <th id="col_name1">Password</th>
                  <th>Status</th>
                  <th id="th_div"></th>
                  <th>&nbsp;</th>-->
                  <th>Sl.No</th>
                  <th>User Name</th>
                  <th>Password</th>
                  <th>Status</th>
                  <th></th>
                  <th>&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                <?php
        //print_r($user);
        $i=1;
        foreach($user as $rowmodule){
        $id = $rowmodule['user_master_id'];
        ?>

                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['user_master_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="50" class="div300" type="text" name="edit_user_<?php echo $i;?>"  id="edit_user_<?php  echo $i;?>" value="<?php echo $rowmodule['user_master_name'];?>" onchange="check_dup_user_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['user_decrypt_pwd'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300" type="text" name="edit_user_password<?php echo $i;?>"  id="edit_user_password_<?php  echo $i;?>" value="<?php echo $rowmodule['user_decrypt_pwd'];?>" onchange="check_dup_user_password_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['user_master_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['user_master_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['user_master_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_user_btn_<?php echo $i;?>" id="edit_user_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_user(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>            
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_user_<?php echo $i;?>" id="save_user_<?php echo $i;?>" onclick="save_user(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_user_<?php echo $i;?>" id="cancel_user_<?php echo $i;?>" onclick="cancel_user(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <!-- <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete User?')){ del_user(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else
          {
          ?>
          <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete User?')){ del_user(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
          <?php
          }
          ?> -->
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
</div> <!-- end of container-fluid -->
<!---------------------------------------- end of main content area  ---------------------------------------- -->