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
      
   $('#chainport_type').validate({    
      rules:
               { 
          chainporttype_name:{required:true,
          alphaonly:true,
          maxlength:20, },

          chainporttype_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             chainporttype_name:{required:"<font color='red'>Please enter Chainport Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed in Chainport Name.</font>",
             maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
             
             chainporttype_code:{required:"<font color='red'>Please enter Chainport Code</span>",
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

function add_chainporttype()
{
    $("#view_chainporttype").hide();
  $("#add_chainporttype").show();
}
  
function delete_chainporttype()
{
  $("#add_chainporttype").hide();
  $("#view_chainporttype").show();
  $("#msgDiv").hide();
}
function ins_chainporttype()
{
    var chainporttype_ins   = $("#chainporttype_ins").val(); 
    var chainporttype_name    = $("#chainporttype_name").val(); 
    var chainporttype_mal_name  = $("#chainporttype_mal_name").val(); 
    var chainporttype_code    = $("#chainporttype_code").val();
    var csrf_token            = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(chainporttype_name=="")
        {
            alert("Chainport Type Name Required");
            $("#chainporttype_name").focus();
            return false;
            
        }
        
        if(chainporttype_code=="")
        {
            alert("Chain Port Type Code Required");
            $("#chainporttype_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_chainporttype/')?>",
          type: "POST",
          data:{chainporttype_ins:chainporttype_ins, chainporttype_name:chainporttype_name,chainporttype_mal_name:chainporttype_mal_name,chainporttype_code:chainporttype_code,'csrf_test_name': csrf_token},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#chainporttype_name").val('');
              $("#chainporttype_mal_name").val('');
              $("#chainporttype_code").val('');
            }
            else{
              window.location.reload(true);
            }
          }
        });
    
}
function toggle_status(id,status)
{
  
  
    var csrf_token            = '<?php echo $this->security->get_csrf_hash(); ?>';
    $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_chainporttype/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_chainporttype(id,status)
{
  
    var csrf_token            = '<?php echo $this->security->get_csrf_hash(); ?>';
    $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_chainporttype/')?>",
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


function edit_chainporttype(id,i)
{
  $("#view_chainporttype").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_chainporttype_btn_"+i).hide();
  $("#save_chainporttype_"+i).show();
  $("#cancel_chainporttype_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_chainporttype(id,i)
{
  $("#view_chainporttype").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_chainporttype_btn_"+i).show();
  $("#save_chainporttype_"+i).hide();
  $("#cancel_chainporttype_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_chainporttype(id,i)
{
  var edit_chainporttype     = $("#edit_chainporttype_"+i).val();
  var edit_chainporttype_code= $("#edit_chainporttype_code_"+i).val();
  var edit_chainporttype_mal = $("#edit_chainporttype_mal_"+i).val();
  var csrf_token             = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;


  if(edit_chainporttype=="")
        {
            alert("Chain port type Name Required");
            $("#edit_chainporttype_"+i).focus();
            return false;
            
        }
          
        if(edit_chainporttype_code=="")
        {
            alert("Chain port type Code Required");
            $("#edit_chainporttype_code_"+i).focus();
            return false;
        }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_chainporttype) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Chain port type name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Chain Port Type name.</font>";
        document.getElementById("edit_chainporttype").value = null;
        return false;
    } 
      if (regcd.exec(edit_chainporttype_code) == null) 
  {
        alert("Only Alphabets Allowed in Chain Port Type code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Chain Port Type code.</font>";
        document.getElementById("edit_chainporttype_code").value = null;
        return false;
    } 



  if(edit_chainporttype=="" ||  edit_chainporttype_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter chain port type And Chain Port Type Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_chainporttype/')?>",
          type: "POST",
          data:{ id:id,edit_chainporttype:edit_chainporttype,edit_chainporttype_mal:edit_chainporttype_mal,edit_chainporttype_code:edit_chainporttype_code,'csrf_test_name': csrf_token},
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
    <span class="badge bg-darkmagenta innertitle "> Chain Port Type </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "chainport_type", "name" => "chainport_type" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_chainporttype", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_chainporttype", $attributes);
    }?>
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_chainporttype">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_chainporttype()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Chain Port Type</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_chainporttype" style="display:none;">
             <div class="col-4">
             <input type="text" name="chainporttype_name" maxlength="20" id="chainporttype_name" class="form-control "  placeholder=" Enter Chainport Type Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="chainporttype_mal_name" maxlength="50" id="chainporttype_mal_name" class="form-control"   placeholder=" Enter Chainport Type Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="chainporttype_code" maxlength="4" id="chainporttype_code" class="form-control"  placeholder=" Enter Chainport Type Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="chainporttype_ins" id="chainporttype_ins" value="Save Chain Port Type" class="btn btn-info btn-flat" onClick="ins_chainporttype()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
             <input type="button" name="chainporttype_del" id="chainporttype_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_chainporttype()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Chain Port Type Name</th>
                  <th id="col_name1">Chain Port Type Name(Malayalam)</th>
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
        foreach($chainporttype as $rowmodule){
        $id = $rowmodule['chainporttype_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['chainporttype_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_chainporttype_<?php echo $i;?>"  id="edit_chainporttype_<?php  echo $i;?>" value="<?php echo $rowmodule['chainporttype_name'];?>" onchange="check_dup_chainporttype_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['chainporttype_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_chainporttype_mal_<?php echo $i;?>"  id="edit_chainporttype_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['chainporttype_mal_name'];?>" onchange="check_dup_chainporttype_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['chainporttype_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_chainporttype_code<?php echo $i;?>"  id="edit_chainporttype_code_<?php  echo $i;?>" value="<?php echo $rowmodule['chainporttype_code'];?>" onchange="check_dup_chainporttype_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['chainporttype_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['chainporttype_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['chainporttype_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_chainporttype_btn_<?php echo $i;?>" id="edit_chainporttype_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_chainporttype(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>             
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_chainporttype_<?php echo $i;?>" id="save_chainporttype_<?php echo $i;?>" onclick="save_chainporttype(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_chainporttype_<?php echo $i;?>" id="cancel_chainporttype_<?php echo $i;?>" onclick="cancel_chainporttype(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Chain Port Type?')){ del_chainporttype(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Chain Port Type?')){ del_chainporttype(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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