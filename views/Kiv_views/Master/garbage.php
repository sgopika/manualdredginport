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
//$('#garbage_ins').click( function() {     
   $('#garbage').validate({
      rules:
               { 
          garbage_name:{required:true,
          alphaonly:true,
          maxlength:50, },

          garbage_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             garbage_name:{required:"<font color='red'>Please enter Garbage Name</span>",
             alphaonly:"<font color='red'>Only Alphabets and characters like .-_ allowed</font>",
             maxlength:"<font color='red'>Maximum 50 Characters allowed</font>"},
             
             garbage_code:{required:"<font color='red'>Please enter Garbage Code</span>",
             nospecialmin:"<font color='red'>Only Alphabets Allowed</font>",
             maxlength:"<font color='red'>Maximum 4 Character allowed</font>"},
 
               },
      errorPlacement: function(error, element)
                     {
                        if ( element.is(":input") ) { error.appendTo( element.parent() ); }
                        else { error.insertAfter( element ); }
                     }
    });
//});
<!-------------------------------->


/*$('#save_garbage_1').click( function() { alert("dd");
        $("#garbage").validate({
      rules:
               { 
          edit_garbage_1:{required:true,
          alphaonly:true,
          maxlength:30, },

          edit_garbage_code_1:{required:true,
          alphaonly:true,
          maxlength:4, },
                     },
      messages:
               {
             edit_garbage_1:{required:"<font color='red'>Please enter Garbage Name</span>",
             alphaonly:"<font color='red'>Only Alphabets Allowed</font>",
             maxlength:"<font color='red'>Maximum 30 Characters allowed</font>"},
             
             edit_garbage_code_1:{required:"<font color='red'>Please enter Garbage Code</span>",
             alphaonly:"<font color='red'>Only Alphabets Allowed</font>",
             maxlength:"<font color='red'>Maximum 4 Character allowed</font>"},
 
               },
      errorPlacement: function(error, element)
                     {
                        if ( element.is(":input") ) { error.appendTo( element.parent() ); }
                        else { error.insertAfter( element ); }
                     }
    });  
    }); 

function avoid_Special()
{
 myString = new String("*&^%$#@") //list of special char.
 if(myString.indexOf(document.getElementById("save_garbage_1").value) != -1)
 alert("Special char not allowed");
 return false;

}*/
<!--------------------------------> 
});

function add_garbage()
{
    $("#view_garbage").hide();
  $("#add_garbage").show();
}
  
function delete_garbage()
{
  $("#add_garbage").hide();
  $("#view_garbage").show();
  $("#msgDiv").hide();
}
function ins_garbage()
{
    var garbage_ins   = $("#garbage_ins").val(); 
    var garbage_name  = $("#garbage_name").val(); 
    var garbage_mal_name= $("#garbage_mal_name").val(); 
    var garbage_code  = $("#garbage_code").val();
    var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(garbage_name=="")
        {
            alert("Garbage Name Required");
            $("#garbage_name").focus();
            return false;
            
        }
        
        if(garbage_code=="")
        {
            alert("Garbage Code Required");
            $("#garbage_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_garbage/')?>",
          type: "POST",
          data:{garbage_ins:garbage_ins, garbage_name:garbage_name,garbage_mal_name:garbage_mal_name,garbage_code:garbage_code,'csrf_test_name': csrf_token},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#garbage_name").val('');
              $("#garbage_mal_name").val('');
              $("#garbage_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_garbage/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_garbage(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_garbage/')?>",
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


function edit_garbage(id,i)
{
  $("#view_garbage").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_garbage_btn_"+i).hide();
  $("#save_garbage_"+i).show();
  $("#cancel_garbage_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_garbage(id,i)
{
  $("#view_garbage").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_garbage_btn_"+i).show();
  $("#save_garbage_"+i).hide();
  $("#cancel_garbage_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}


function save_garbage(id,i)
{
    
  var edit_garbage= $("#edit_garbage_"+i).val();
  var edit_garbage_code= $("#edit_garbage_code_"+i).val();
  var edit_garbage_mal= $("#edit_garbage_mal_"+i).val();
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;


  if(edit_garbage=="")
        {
            alert("Garbage Name Required");
            $("#edit_garbage_"+i).focus();
            return false;
            
        }
        
        if(edit_garbage_code=="")
        {
            alert("Garbage Code Required");
            $("#edit_garbage_code_"+i).focus();
            return false;
        }
       
  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_garbage) == null) 
  {
        alert("Garbage name can contain only alphabets and characters like .-_");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Garbage name can contain only alphabets and characters like .-_ </font>";
        document.getElementById("edit_garbage").value = null;
        return false;
    } 
      if (regcd.exec(edit_garbage_code) == null) 
  {
        alert("Only Alphabets Allowed in Garbage code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Garbage code.</font>";
        document.getElementById("edit_garbage_code").value = null;
        return false;
    }   
    
  
  if(edit_garbage=="" ||  edit_garbage_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Garbage Name And Garbage Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_garbage/')?>",
          type: "POST",
          data:{ id:id,edit_garbage:edit_garbage,edit_garbage_mal:edit_garbage_mal,edit_garbage_code:edit_garbage_code,'csrf_test_name': csrf_token},
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
    <span class="badge bg-darkmagenta innertitle "> Garbage </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "garbage", "name" => "garbage" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_garbage", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_garbage", $attributes);
    }?>
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_garbage">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
          <button type="button" class="btn btn-sm btn-primary" onClick="add_garbage()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Garbage</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_garbage" style="display:none;">
             <div class="col-4">
             <input type="text" name="garbage_name" maxlength="50" id="garbage_name" class="form-control "  placeholder=" Enter Garbage Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="garbage_mal_name" maxlength="50" id="garbage_mal_name" class="form-control"   placeholder=" Enter Garbage Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="garbage_code" id="garbage_code" maxlength="4" class="form-control"  placeholder=" Enter Garbage Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="garbage_ins" id="garbage_ins" value="Save Garbage" class="btn btn-info btn-flat" onClick="ins_garbage()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3">
            <input type="button" name="garbage_del" id="garbage_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_garbage()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Garbage Name</th>
                  <th id="col_name1">Garbage Name(Malayalam)</th>
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
        foreach($garbage as $rowmodule){
        $id = $rowmodule['garbage_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['garbage_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="50" class="div300" type="text" name="edit_garbage_<?php echo $i;?>"  id="edit_garbage_<?php  echo $i;?>" value="<?php echo $rowmodule['garbage_name'];?>" onkeypress="return checkSpcialChar(event)" onchange="check_dup_garbage_edit(<?php echo $i;?>);"   autocomplete="off"/> 
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['garbage_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_garbage_mal_<?php echo $i;?>"  id="edit_garbage_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['garbage_mal_name'];?>" onchange="check_dup_garbage_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['garbage_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_garbage_code<?php echo $i;?>"  id="edit_garbage_code_<?php  echo $i;?>" value="<?php echo $rowmodule['garbage_code'];?>" onchange="check_dup_garbage_code_edit(<?php echo $i;?>);"    autocomplete="off"/><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                 </div>
                </td>
                 <td>
                  <?php  if($rowmodule['garbage_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['garbage_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['garbage_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_garbage_btn_<?php echo $i;?>" id="edit_garbage_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_garbage(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>             
                        </div>
                        
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">

<button class="btn btn-sm btn-success btn-flat" type="button" name="save_garbage_<?php echo $i;?>" id="save_garbage_<?php echo $i;?>" onclick="save_garbage(<?php echo $id;?>,<?php echo $i;?>);" onkeypress="return checkSpcialChar(event)" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                       

<button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_garbage_<?php echo $i;?>" id="cancel_garbage_<?php echo $i;?>" onclick="cancel_garbage(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete garbage?')){ del_garbage(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete garbage?')){ del_garbage(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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