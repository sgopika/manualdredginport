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
      
   $('#user_type').validate({
      rules:
               { 
          user_type_name:{required:true,
          nospecial:true,
          maxlength:50, },

          /*user_type_code:{required:true,
          alphaonly:true,
          maxlength:4, },*/
                     },
      messages:
               {
             user_type_name:{required:"<font color='red'>Please enter User Type Name</span>",
             nospecial:"<font color='red'>Only alphabets,numbers and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 50 Characters allowed</font>"},
             
            /* user_type_code:{required:"<font color='red'>Please enter User Type Code</span>",
             alphaonly:"<font color='red'>Only Alphabets Allowed</font>",
             maxlength:"<font color='red'>Maximum 4 Character allowed</font>"},*/
 
               },
      errorPlacement: function(error, element)
                     {
                        if ( element.is(":input") ) { error.appendTo( element.parent() ); }
                        else { error.insertAfter( element ); }
                     }
    }); 
});

function add_user_type()
{
      $("#view_user_type").hide();
  $("#add_user_type").show();
}
  
function delete_user_type()
{
  $("#add_user_type").hide();
  $("#view_user_type").show();
  $("#msgDiv").hide();
}
function ins_user_type()
{
    var user_type_ins   = $("#user_type_ins").val(); 
    var user_type_name    = $("#user_type_name").val(); 
    var user_type_mal_name  = $("#user_type_mal_name").val(); 
    var user_type_code    = $("#user_type_code").val();
      
  if(user_type_name=="")
        {
            alert("User Type Name Required");
            $("#user_type_name").focus();
            return false;
            
        }
        
        if(user_type_code=="")
        {
            alert("User Type Code Required");
            $("#user_type_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_user_type/')?>",
          type: "POST",
          data:{user_type_ins:user_type_ins, user_type_name:user_type_name,user_type_mal_name:user_type_mal_name,user_type_code:user_type_code},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#user_type_name").val('');
              $("#user_type_mal_name").val('');
              $("#user_type_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_user_type/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_user_type(id,status)
{
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_user_type/')?>",
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


function edit_user_type(id,i)
{
  $("#view_user_type").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_user_type_btn_"+i).hide();
  $("#save_user_type_"+i).show();
  $("#cancel_user_type_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_user_type(id,i)
{
  $("#view_user_type").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_user_type_btn_"+i).show();
  $("#save_user_type_"+i).hide();
  $("#cancel_user_type_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
}
  
function save_user_type(id,i)
{
  var edit_user_type= $("#edit_user_type_"+i).val();
  //var edit_user_type_code= $("#edit_user_type_code_"+i).val();
  //var edit_user_type_mal= $("#edit_user_type_mal_"+i).val();
  var re = /^[ A-Za-z0-9]*$/;


  if(edit_user_type=="")
        {
            alert("User Type Name Required");
            $("#edit_user_type_"+i).focus();
            return false;
            
        }
          
        
  var regex = new RegExp("^[a-zA-Z0-9\ \.\_\-]+$");
    if (regex.exec(edit_user_type) == null) 
  {
        alert("Special Characters are not allowed in User Type Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Special Characters are not allowed in User Type Name.</font>";
        document.getElementById("edit_user_type").value = null;
        return false;
    } 
      


  if(edit_user_type==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter User Type Name</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_user_type/')?>",
          type: "POST",
          data:{ id:id,edit_user_type:edit_user_type},
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
    <span class="badge bg-darkmagenta innertitle "> User Type </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "user_type", "name" => "user_type" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_user_type", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_user_type", $attributes);
    }?>
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_user_type">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_user_type()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New User Type</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_user_type" style="display:none;">
             <div class="col-4">
             
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="user_type_name" maxlength="50" id="user_type_name" class="form-control"  placeholder=" Enter User Type Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="user_type_ins" id="user_type_ins" value="Save User Type" class="btn btn-info btn-flat" onClick="ins_user_type()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="user_type_del" id="user_type_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_user_type()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">User Type Name</th>
                  <!--<th id="col_name1">User Type Name(Malayalam)</th>
                  <th id="col_name2">Code</th>-->
                  <th>Status</th>
                  <th id="th_div"></th>
                  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                 <?php
        //print_r($data);
        $i=1;
        foreach($user_type as $rowmodule){
        $id = $rowmodule['user_type_id'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['user_type_type_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="50" class="div300" type="text" name="edit_user_type_<?php echo $i;?>"  id="edit_user_type_<?php  echo $i;?>" value="<?php echo $rowmodule['user_type_type_name'];?>" onchange="check_dup_user_type_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
               <!--  <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['user_type_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input class="div300"  type="text" name="edit_user_type_mal_<?php echo $i;?>"  id="edit_user_type_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['user_type_mal_name'];?>" onchange="check_dup_user_type_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>-->
                
               <!-- <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['user_type_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input class="div80" type="text" name="edit_user_type_code<?php echo $i;?>"  id="edit_user_type_code_<?php  echo $i;?>" value="<?php echo $rowmodule['user_type_code'];?>" onchange="check_dup_user_type_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>-->
                 <td>
                  <?php  if($rowmodule['user_type_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['user_type_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['user_type_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_user_type_btn_<?php echo $i;?>" id="edit_user_type_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_user_type(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>             
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_user_type_<?php echo $i;?>" id="save_user_type_<?php echo $i;?>" onclick="save_user_type(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_user_type_<?php echo $i;?>" id="cancel_user_type_<?php echo $i;?>" onclick="cancel_user_type(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                 <!--  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete User Type?')){ del_user_type(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete User Type?')){ del_user_type(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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