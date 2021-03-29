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
      
   $('#portofregistry').validate({
      rules:
               { 
          portofregistry_name:{required:true,
          alphaonly:true,
          maxlength:20, },

          portofregistry_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             portofregistry_name:{required:"<font color='red'>Please enter Port of registry Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
             
             portofregistry_code:{required:"<font color='red'>Please enter port of registry Code</span>",
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

function add_portofRegistry()
{ 
      $("#view_portofregistry").hide();
  $("#add_portofRegistry").show();
}
  
function delete_portofregistry()
{
  $("#add_portofRegistry").hide();
  $("#view_portofregistry").show();
  $("#msgDiv").hide();
}
function ins_portofregistry()
{
    var portofregistry_ins    = $("#portofregistry_ins").val(); 
    var portofregistry_name   = $("#portofregistry_name").val(); 
    var portofregistry_mal_name = $("#portofregistry_mal_name").val(); 
    var portofregistry_code   = $("#portofregistry_code").val();
    var csrf_token        = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(portofregistry_name=="")
        {
            alert("Port of registry Name Required");
            $("#portofregistry_name").focus();
            return false;
            
        }
        
        if(portofregistry_code=="")
        {
            alert("Port of registry Code Required");
            $("#portofregistry_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_portofRegistry/')?>",
          type: "POST",
          data:{portofregistry_ins:portofregistry_ins, portofregistry_name:portofregistry_name,portofregistry_mal_name:portofregistry_mal_name,portofregistry_code:portofregistry_code,'csrf_test_name': csrf_token},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#portofregistry_name").val('');
              $("#portofregistry_mal_name").val('');
              $("#portofregistry_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_portofRegistry/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_portofregistry(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_portofregistry/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token},
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


function edit_portofregistry(id,i)
{
  $("#view_portofregistry").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_portofregistry_btn_"+i).hide();
  $("#save_portofregistry_"+i).show();
  $("#cancel_portofregistry_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_portofregistry(id,i)
{
  $("#view_portofregistry").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_portofregistry_btn_"+i).show();
  $("#save_portofregistry_"+i).hide();
  $("#cancel_portofregistry_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_portofregistry(id,i)
{
  var edit_portofregistry= $("#edit_portofregistry_"+i).val();
  var edit_portofregistry_code= $("#edit_portofregistry_code_"+i).val();
  var edit_portofregistry_mal= $("#edit_portofregistry_mal_"+i).val();
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;



  

  if(edit_portofregistry=="")
        {
            alert("Port of registry Name Required");
            $("#edit_portofregistry_"+i).focus();
            return false;
            
        }
        
        if(edit_portofregistry_code=="")
        {
            alert("Port of registry Code Required");
            $("#edit_portofregistry_code_"+i).focus();
            return false;
        }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_portofregistry) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Port of registry Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Port of registry Name.</font>";
        document.getElementById("edit_portofregistry").value = null;
        return false;
    } 
      if (regex.exec(edit_portofregistry_code) == null) 
  {
        alert("Only Alphabets Allowed in Port of registry Code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Port of registry Code.</font>";
        document.getElementById("edit_portofregistry_code").value = null;
        return false;
    } 


  if(edit_portofregistry=="" ||  edit_portofregistry_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Port of registry name And Port of Registry Code</font>";
  }

  else{ 
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_portofregistry/')?>",
          type: "POST",
          data:{ id:id,edit_portofregistry:edit_portofregistry,edit_portofregistry_mal:edit_portofregistry_mal,edit_portofregistry_code:edit_portofregistry_code,'csrf_test_name': csrf_token},
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
    <span class="badge bg-darkmagenta innertitle "> Port of Registry </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "portofregistry", "name" => "portofregistry" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_portofRegistry", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_portofRegistry", $attributes);
    }?>
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_portofregistry">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_portofRegistry()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Port of Registry</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_portofRegistry" style="display:none;">
             <div class="col-4">
             <input type="text" name="portofregistry_name" maxlength="20" id="portofregistry_name" class="form-control "  placeholder=" Enter Port of registry Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="portofregistry_mal_name" maxlength="50" id="portofregistry_mal_name" class="form-control"   placeholder=" Enter Port of registry Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="portofregistry_code" maxlength="4" id="portofregistry_code" class="form-control"  placeholder=" Enter Port of registry Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="portofregistry_ins" id="portofregistry_ins" value="Save Port of Registry" class="btn btn-info btn-flat" onClick="ins_portofregistry()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="vesselcategory_del" id="vesselcategory_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_portofregistry()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Port of Registry Name</th>
                  <th id="col_name1">Port of Registry(Malayalam)</th>
                  <th id="col_name2">Code</th>
                  <th>Status</th>
                  <th id="th_div"></th>
                  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                 <?php
        //print_r($portofregistry);
        $i=1;
        foreach($portofregistry as $rowmodule){
        $id = $rowmodule['int_portoffice_id'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['vchr_portoffice_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_portofregistry_<?php echo $i;?>"  id="edit_portofregistry_<?php  echo $i;?>" value="<?php echo $rowmodule['vchr_portoffice_name'];?>" onchange="check_dup_portofregistry_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['portofregistry_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_portofregistry_mal_<?php echo $i;?>"  id="edit_portofregistry_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['portofregistry_mal_name'];?>" onchange="check_dup_portofregistry_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['vchr_officecode'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_portofregistry_code<?php echo $i;?>"  id="edit_portofregistry_code_<?php  echo $i;?>" value="<?php echo $rowmodule['vchr_officecode'];?>" onchange="check_dup_portofregistry_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['kiv_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['kiv_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['kiv_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_portofregistry_btn_<?php echo $i;?>" id="edit_portofregistry_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_portofregistry(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>            
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_portofregistry_<?php echo $i;?>" id="save_portofregistry_<?php echo $i;?>" onclick="save_portofregistry(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_portofregistry_<?php echo $i;?>" id="cancel_portofregistry_<?php echo $i;?>" onclick="cancel_portofregistry(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <!-- <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Port of Registry?')){ del_portofregistry(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Port of Registry?')){ del_portofregistry(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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