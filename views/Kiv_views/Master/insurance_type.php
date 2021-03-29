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
      
   $('#insurance_type').validate({
      rules:
               { 
          insurance_type_name:{required:true,
          alphaonly:true,
          maxlength:40, },

          insurance_type_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             insurance_type_name:{required:"<font color='red'>Please enter Insurance Type Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 40 Characters allowed</font>"},
             
             insurance_type_code:{required:"<font color='red'>Please enter Insurance Type Code</span>",
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

function add_insurance_type()
{
      $("#view_insurance_type").hide();
  $("#add_insurance_type").show();
}
  
function delete_insurance_type()
{
  $("#add_insurance_type").hide();
  $("#view_insurance_type").show();
  $("#msgDiv").hide();
}
function ins_insurance_type()
{
    var insurance_type_ins    = $("#insurance_type_ins").val(); 
    var insurance_type_name   = $("#insurance_type_name").val(); 
    var insurance_type_mal_name = $("#insurance_type_mal_name").val(); 
    var insurance_type_code   = $("#insurance_type_code").val();
    var csrf_token        = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(insurance_type_name=="")
        {
            alert("Insurance Type Name Required");
            $("#insurance_type_name").focus();
            return false;
            
        }
        
        if(insurance_type_code=="")
        {
            alert("Insurance Type Code Required");
            $("#insurance_type_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_insurance_type/')?>",
          type: "POST",
          data:{insurance_type_ins:insurance_type_ins, insurance_type_name:insurance_type_name,insurance_type_mal_name:insurance_type_mal_name,insurance_type_code:insurance_type_code,'csrf_test_name': csrf_token },
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#insurance_type_name").val('');
              $("#insurance_type_mal_name").val('');
              $("#insurance_type_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_insurance_type/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token },
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_insurance_type(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_insurance_type/')?>",
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


function edit_insurance_type(id,i)
{
  $("#view_insurance_type").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_insurance_type_btn_"+i).hide();
  $("#save_insurance_type_"+i).show();
  $("#cancel_insurance_type_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_insurance_type(id,i)
{
  $("#view_insurance_type").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_insurance_type_btn_"+i).show();
  $("#save_insurance_type_"+i).hide();
  $("#cancel_insurance_type_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_insurance_type(id,i)
{
  var edit_insurance_type= $("#edit_insurance_type_"+i).val();
  var edit_insurance_type_code= $("#edit_insurance_type_code_"+i).val();
  var edit_insurance_type_mal= $("#edit_insurance_type_mal_"+i).val();
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;



  

  if(edit_insurance_type=="")
        {
            alert("Insurance Type Name Required");
            $("#edit_insurance_type_"+i).focus();
            return false;
            
        }
        
        if(edit_insurance_type_code=="")
        {
            alert("Insurance Type Code Required");
            $("#edit_insurance_type_code").focus();
            return false;
        }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_insurance_type) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Insurance Type Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>SOnly alphabets and characters like .-_ are allowed in Insurance Type Name.</font>";
        document.getElementById("edit_insurance_type").value = null;
        return false;
    } 
      if (regcd.exec(edit_insurance_type_code) == null) 
  {
        alert("Only Alphabets allowed in Insurance Type code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets allowed in Insurance Type code.</font>";
        document.getElementById("edit_insurance_type_code").value = null;
        return false;
    } 



  if(edit_insurance_type=="" ||  edit_insurance_type_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Insurance Type And Insurance Type Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_insurance_type/')?>",
          type: "POST",
          data:{ id:id,edit_insurance_type:edit_insurance_type,edit_insurance_type_mal:edit_insurance_type_mal,edit_insurance_type_code:edit_insurance_type_code,'csrf_test_name': csrf_token },
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
    <span class="badge bg-darkmagenta innertitle "> Insurance Type </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "insurance_type", "name" => "insurance_type" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_insurance_type", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_insurance_type", $attributes);
    }?>
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_insurance_type">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_insurance_type()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Insurance Type</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_insurance_type" style="display:none;">
             <div class="col-4">
             <input type="text" name="insurance_type_name" maxlength="40" id="insurance_type_name" class="form-control "  placeholder=" Enter Insurance Type Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="insurance_type_mal_name" maxlength="50" id="insurance_type_mal_name" class="form-control"   placeholder=" Enter Insurance Type Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="insurance_type_code"  maxlength="4" id="insurance_type_code" class="form-control"  placeholder=" Enter Insurance Type Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="insurance_type_ins" id="insurance_type_ins" value="Save Insurance Type" class="btn btn-info btn-flat" onClick="ins_insurance_type()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="insurance_type_del" id="insurance_type_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_insurance_type()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Insurance Type Name</th>
                  <th id="col_name1">Insurance Type Name(Malayalam)</th>
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
        foreach($insurance_type as $rowmodule){
        $id = $rowmodule['insurance_type_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['insurance_type_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="40" class="div300" type="text" name="edit_insurance_type_<?php echo $i;?>"  id="edit_insurance_type_<?php  echo $i;?>" value="<?php echo $rowmodule['insurance_type_name'];?>" onchange="check_dup_insurance_type_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['insurance_type_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_insurance_type_mal_<?php echo $i;?>"  id="edit_insurance_type_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['insurance_type_mal_name'];?>" onchange="check_dup_insurance_type_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['insurance_type_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_insurance_type_code<?php echo $i;?>"  id="edit_insurance_type_code_<?php  echo $i;?>" value="<?php echo $rowmodule['insurance_type_code'];?>" onchange="check_dup_insurance_type_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['insurance_type_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['insurance_type_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['insurance_type_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_insurance_type_btn_<?php echo $i;?>" id="edit_insurance_type_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_insurance_type(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>            
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_insurance_type_<?php echo $i;?>" id="save_insurance_type_<?php echo $i;?>" onclick="save_insurance_type(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_insurance_type_<?php echo $i;?>" id="cancel_insurance_type_<?php echo $i;?>" onclick="cancel_insurance_type(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Insurance Type?')){ del_insurance_type(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Insurance Type?')){ del_insurance_type(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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