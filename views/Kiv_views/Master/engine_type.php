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
      
   $('#engine_type').validate({
      rules:
               { 
          enginetype_name:{required:true,
          alphaonly:true,
          maxlength:20, },

          enginetype_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             enginetype_name:{required:"<font color='red'>Please enter Engine Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
             
             enginetype_code:{required:"<font color='red'>Please enter Engine Code</span>",
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

function add_enginetype()
{
      $("#view_enginetype").hide();
  $("#add_enginetype").show();
}
  
function delete_enginetype()
{
  $("#add_enginetype").hide();
  $("#view_enginetype").show();
  $("#msgDiv").hide();
}
function ins_enginetype()
{
    var enginetype_ins    = $("#enginetype_ins").val(); 
    var enginetype_name   = $("#enginetype_name").val(); 
    var enginetype_mal_name = $("#enginetype_mal_name").val(); 
    var enginetype_code   = $("#enginetype_code").val();
    var csrf_token          = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(enginetype_name=="")
        {
            alert("Engine Type Name Required");
            $("#enginetype_name").focus();
            return false;
            
        }
        
        if(enginetype_code=="")
        {
            alert("Engine Type Code Required");
            $("#enginetype_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_enginetype/')?>",
          type: "POST",
          data:{enginetype_ins:enginetype_ins, enginetype_name:enginetype_name,enginetype_mal_name:enginetype_mal_name,enginetype_code:enginetype_code,'csrf_test_name': csrf_token },
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#enginetype_name").val('');
              $("#enginetype_mal_name").val('');
              $("#enginetype_code").val('');
            }
            else{
              window.location.reload(true);
            }
          }
        });
    
}
function toggle_status(id,status)
{
  
  var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_enginetype/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token },
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_enginetype(id,status)
{
  var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_enginetype/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token },
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


function edit_enginetype(id,i)
{
  $("#view_enginetype").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_enginetype_btn_"+i).hide();
  $("#save_enginetype_"+i).show();
  $("#cancel_enginetype_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_enginetype(id,i)
{
  $("#view_enginetype").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_enginetype_btn_"+i).show();
  $("#save_enginetype_"+i).hide();
  $("#cancel_enginetype_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_enginetype(id,i)
{
  var edit_enginetype= $("#edit_enginetype_"+i).val();
  var edit_enginetype_code= $("#edit_enginetype_code_"+i).val();
  var edit_enginetype_mal= $("#edit_enginetype_mal_"+i).val();
  var csrf_token         = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_enginetype) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Engine Type Name.");
      document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Engine Type Name.</font>";
        document.getElementById("edit_enginetype").value = null;
        return false;
    } 
      if (regcd.exec(edit_enginetype_code) == null) 
  {
        alert("Only Alphabets Allowed in Engine Type Code.");
      document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Engine Type Code.</font>";
        document.getElementById("edit_enginetype_code").value = null;
        return false;
    } 



  if(edit_enginetype=="" ||  edit_enginetype_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Engine Type Name And Engine Type Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_enginetype/')?>",
          type: "POST",
          data:{ id:id,edit_enginetype:edit_enginetype,edit_enginetype_mal:edit_enginetype_mal,edit_enginetype_code:edit_enginetype_code,'csrf_test_name': csrf_token },
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
    <span class="badge bg-darkmagenta innertitle "> Engine Type </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "engine_type", "name" => "engine_type" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_enginetype", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_enginetype", $attributes);
    }?>
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_enginetype">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_enginetype()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Engine Type</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_enginetype" style="display:none;">
             <div class="col-4">
             <input type="text" name="enginetype_name" maxlength="20" id="enginetype_name" class="form-control "  placeholder=" Enter Engine Type Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="enginetype_mal_name" maxlength="50" id="enginetype_mal_name" class="form-control"   placeholder=" Enter Engine Type Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="enginetype_code" maxlength="4" id="enginetype_code" class="form-control"  placeholder=" Enter Engine Type Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="enginetype_ins" id="enginetype_ins" value="Save Engine Type" class="btn btn-info btn-flat" onClick="ins_enginetype()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="enginetype_del" id="enginetype_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_enginetype()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Engine Type Name</th>
                  <th id="col_name1">Engine Type Name(Malayalam)</th>
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
        foreach($enginetype as $rowmodule){
        $id = $rowmodule['enginetype_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['enginetype_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_enginetype_<?php echo $i;?>"  id="edit_enginetype_<?php  echo $i;?>" value="<?php echo $rowmodule['enginetype_name'];?>" onchange="check_dup_enginetype_edit(<?php echo $i;?>);"   autocomplete="off"/><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                 </div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['enginetype_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_enginetype_mal_<?php echo $i;?>"  id="edit_enginetype_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['enginetype_mal_name'];?>" onchange="check_dup_enginetype_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['enginetype_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_enginetype_code<?php echo $i;?>"  id="edit_enginetype_code_<?php  echo $i;?>" value="<?php echo $rowmodule['enginetype_code'];?>" onchange="check_dup_enginetype_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['enginetype_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['enginetype_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['enginetype_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_enginetype_btn_<?php echo $i;?>" id="edit_enginetype_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_enginetype(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>            
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_enginetype_<?php echo $i;?>" id="save_enginetype_<?php echo $i;?>" onclick="save_enginetype(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_enginetype_<?php echo $i;?>" id="cancel_enginetype_<?php echo $i;?>" onclick="cancel_enginetype(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Engine Type?')){ del_enginetype(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Engine Type?')){ del_enginetype(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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