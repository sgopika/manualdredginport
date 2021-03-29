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
      
   $('#modelnumber').validate({
      rules:
               { 
          modelnumber_name:{required:true,
          alphaonly:true,
          maxlength:20, },

          modelnumber_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             modelnumber_name:{required:"<font color='red'>Please enter Model Number Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
             
             modelnumber_code:{required:"<font color='red'>Please enter Model Number Code</span>",
             nospecialmin:"<font color='red'>Only Alphabets Allowed</font>",
             maxlength:"<font color='red'>Maximum 4 Character allowed</font>"},
 
               },
      errorPlacement: function(error, element)
                     {
                        if ( element.is(":input") ) { error.appendTo( element.parent() ); }
                        else { error.insertAfter( element ); }
                     }
    }); 
});

function add_modelnumber()
{
      $("#view_modelnumber").hide();
  $("#add_modelnumber").show();
}
  
function delete_modelnumber()
{
  $("#add_modelnumber").hide();
  $("#view_modelnumber").show();
  $("#msgDiv").hide();
}
function ins_modelnumber()
{
    var modelnumber_ins     = $("#modelnumber_ins").val(); 
    var modelnumber_name    = $("#modelnumber_name").val(); 
    var modelnumber_mal_name  = $("#modelnumber_mal_name").val(); 
    var modelnumber_code    = $("#modelnumber_code").val();
    var csrf_token        = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(modelnumber_name=="")
        {
            alert("Model Number Name Required");
            $("#modelnumber_name").focus();
            return false;
            
        }
        
        if(modelnumber_code=="")
        {
            alert("Model Number Code Required");
            $("#modelnumber_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_modelnumber/')?>",
          type: "POST",
          data:{modelnumber_ins:modelnumber_ins, modelnumber_name:modelnumber_name,modelnumber_mal_name:modelnumber_mal_name,modelnumber_code:modelnumber_code,'csrf_test_name': csrf_token},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#modelnumber_name").val('');
              $("#modelnumber_mal_name").val('');
              $("#modelnumber_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_modelnumber/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_modelnumber(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_modelnumber/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token},
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


function edit_modelnumber(id,i)
{
  $("#view_modelnumber").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_modelnumber_btn_"+i).hide();
  $("#save_modelnumber_"+i).show();
  $("#cancel_modelnumber_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_modelnumber(id,i)
{
  $("#view_modelnumber").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_modelnumber_btn_"+i).show();
  $("#save_modelnumber_"+i).hide();
  $("#cancel_modelnumber_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_modelnumber(id,i)
{
  var edit_modelnumber= $("#edit_modelnumber_"+i).val();
  var edit_modelnumber_code= $("#edit_modelnumber_code_"+i).val();
  var edit_modelnumber_mal= $("#edit_modelnumber_mal_"+i).val();
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;
  

  if(edit_modelnumber=="")
        {
            alert("Model Number Name Required");
            $("#edit_modelnumber_"+i).focus();
            return false;
            
        }
        
        if(edit_modelnumber_code=="")
        {
            alert("Model Number Code Required");
            $("#edit_modelnumber_code_"+i).focus();
            return false;
        }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");


    if (regex.exec(edit_modelnumber) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Model Number Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Model Number Name.</font>";
        document.getElementById("edit_modelnumber").value = null;
        return false;
    } 
      if (regcd.exec(edit_modelnumber_code) == null) 
  {
        alert("Only Alphabets Allowed in Model Number Code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Model Number Code.</font>";
        document.getElementById("edit_modelnumber_code").value = null;
        return false;
    } 




  if(edit_modelnumber=="" ||  edit_modelnumber_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Model Number Name And Model Number Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_modelnumber/')?>",
          type: "POST",
          data:{ id:id,edit_modelnumber:edit_modelnumber,edit_modelnumber_mal:edit_modelnumber_mal,edit_modelnumber_code:edit_modelnumber_code,'csrf_test_name': csrf_token},
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
    <span class="badge bg-darkmagenta innertitle "> Model Number </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "modelnumber", "name" => "modelnumber" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_modelnumber", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_modelnumber", $attributes);
    }?>
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_modelnumber">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_modelnumber()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Model Number</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_modelnumber" style="display:none;">
             <div class="col-4">
             <input type="text" name="modelnumber_name"maxlength="20" id="modelnumber_name" class="form-control "  placeholder=" Enter Model Number Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="modelnumber_mal_name"maxlength="50" id="modelnumber_mal_name" class="form-control"   placeholder=" Enter Model Number Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="modelnumber_code"maxlength="4" id="modelnumber_code" class="form-control"  placeholder=" Enter Model Number Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="modelnumber_ins" id="modelnumber_ins" value="Save Model Number" class="btn btn-info btn-flat" onClick="ins_modelnumber()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="modelnumber_del" id="modelnumber_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_modelnumber()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Model Number Name</th>
                  <th id="col_name1">Model Number Name(Malayalam)</th>
                  <th id="col_name2">Code</th>
                  <th>Status</th>
                  <th id="th_div"></th>
                  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                 <?php
        //print_r($data);
        $i=1;
        foreach($modelnumber as $rowmodule){
        $id = $rowmodule['modelnumber_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['modelnumber_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_modelnumber_<?php echo $i;?>"  id="edit_modelnumber_<?php  echo $i;?>" value="<?php echo $rowmodule['modelnumber_name'];?>" onchange="check_dup_modelnumber_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['modelnumber_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_modelnumber_mal_<?php echo $i;?>"  id="edit_modelnumber_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['modelnumber_mal_name'];?>" onchange="check_dup_modelnumber_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['modelnumber_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_modelnumber_code<?php echo $i;?>"  id="edit_modelnumber_code_<?php  echo $i;?>" value="<?php echo $rowmodule['modelnumber_code'];?>" onchange="check_dup_modelnumber_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['modelnumber_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['modelnumber_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['modelnumber_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_modelnumber_btn_<?php echo $i;?>" id="edit_modelnumber_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_modelnumber(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>             
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_modelnumber_<?php echo $i;?>" id="save_modelnumber_<?php echo $i;?>" onclick="save_modelnumber(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_modelnumber_<?php echo $i;?>" id="cancel_modelnumber_<?php echo $i;?>" onclick="cancel_modelnumber(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Model Number?')){ del_modelnumber(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Model Number?')){ del_modelnumber(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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
</div> <!-- end of container-fluid -->
<!---------------------------------------- end of main content area  ---------------------------------------- -->