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
      
   $('#formtype_location').validate({
      rules:
               { 
          formtype_location_name:{required:true,
          alphaonly:true,
          maxlength:20, },

          formtype_location_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             formtype_location_name:{required:"<font color='red'>Please enter Form Type Location Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed</font>",
             maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
             
             formtype_location_code:{required:"<font color='red'>Please enter Form Type Location Code</span>",
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

function add_formtype_location()
{
    $("#view_formtype_location").hide();
  $("#add_formtype_location").show();
}
  
function delete_formtype_location()
{
  $("#add_formtype_location").hide();
  $("#view_formtype_location").show();
  $("#msgDiv").hide();
}
function ins_formtype_location()
{
    var formtype_location_ins   = $("#formtype_location_ins").val(); 
    var formtype_location_name    = $("#formtype_location_name").val(); 
    var formtype_location_mal_name  = $("#formtype_location_mal_name").val(); 
    var formtype_location_code    = $("#formtype_location_code").val();
    var csrf_token          = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(formtype_location_name=="")
        {
            alert("Form Type Location Name Required");
            $("#formtype_location_name").focus();
            return false;
            
        }
        
        if(formtype_location_code=="")
        {
            alert("Form Type Location Code Required");
            $("#formtype_location_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_formtype_location/')?>",
          type: "POST",
          data:{formtype_location_ins:formtype_location_ins, formtype_location_name:formtype_location_name,formtype_location_mal_name:formtype_location_mal_name,formtype_location_code:formtype_location_code,'csrf_test_name': csrf_token },
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#formtype_location_name").val('');
              $("#formtype_location_mal_name").val('');
              $("#formtype_location_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_formtype_location/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token },
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_formtype_location(id,status)
{
  var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_formtype_location/')?>",
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


function edit_formtype_location(id,i)
{
  $("#view_formtype_location").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_formtype_location_btn_"+i).hide();
  $("#save_formtype_location_"+i).show();
  $("#cancel_formtype_location_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_formtype_location(id,i)
{
  $("#view_formtype_location").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_formtype_location_btn_"+i).show();
  $("#save_formtype_location_"+i).hide();
  $("#cancel_formtype_location_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
}
  
function save_formtype_location(id,i)
{
  var edit_formtype_location= $("#edit_formtype_location_"+i).val();
  var edit_formtype_location_code= $("#edit_formtype_location_code_"+i).val();
  var edit_formtype_location_mal= $("#edit_formtype_location_mal_"+i).val();
  var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  if(edit_formtype_location=="")
        {
            alert("Form Type Location Name Required");
            $("#edit_formtype_location_"+i).focus();
            return false;
            
        }
        
        if(edit_formtype_location_code=="")
        {
            alert("Form Type Location Code Required");
            $("#edit_formtype_location_code_"+i).focus();
            return false;
        }


  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_formtype_location) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Form Type Location name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Form Type Location name.</font>";
        document.getElementById("edit_formtype_location").value = null;
        return false;
    } 
      if (regcd.exec(edit_formtype_location_code) == null) 
  {
        alert("Special Characters are not allowed in Form Type Location code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Special Characters are not allowed in Form Type Location code.</font>";
        document.getElementById("edit_formtype_location_code").value = null;
        return false;
    } 


  if(edit_formtype_location=="" ||  edit_formtype_location_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Form Type Location And Form Type Location Type Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_formtype_location/')?>",
          type: "POST",
          data:{ id:id,edit_formtype_location:edit_formtype_location,edit_formtype_location_mal:edit_formtype_location_mal,edit_formtype_location_code:edit_formtype_location_code,'csrf_test_name': csrf_token },
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
    <span class="badge bg-darkmagenta innertitle "> Form Type Location </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "formtype_location", "name" => "formtype_location" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_formtype_location", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_formtype_location", $attributes);
    }?>
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_formtype_location">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
          <button type="button" class="btn btn-sm btn-primary" onClick="add_formtype_location()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Form Type Location</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_formtype_location" style="display:none;">
             <div class="col-4">
             <input type="text" name="formtype_location_name" maxlength="20" id="formtype_location_name" class="form-control "  placeholder=" Enter Form Type Location Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="formtype_location_mal_name" maxlength="50" id="formtype_location_mal_name" class="form-control"   placeholder=" Enter Form Type Location Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="formtype_location_code" maxlength="4" id="formtype_location_code" class="form-control"  placeholder=" Enter Form Type Location Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="formtype_location_ins" id="formtype_location_ins" value="Save Form Type Location" class="btn btn-info btn-flat" onClick="ins_formtype_location()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="formtype_location_del" id="formtype_location_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_formtype_location()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Form Type Location Name</th>
                  <th id="col_name1">Form Type Location Name(Malayalam)</th>
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
        foreach($formtype_location as $rowmodule){
        $id = $rowmodule['formtype_location_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['formtype_location_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_formtype_location_<?php echo $i;?>"  id="edit_formtype_location_<?php  echo $i;?>" value="<?php echo $rowmodule['formtype_location_name'];?>" onchange="check_dup_formtype_location_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['formtype_location_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_formtype_location_mal_<?php echo $i;?>"  id="edit_formtype_location_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['formtype_location_mal_name'];?>" onchange="check_dup_formtype_location_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['formtype_location_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_formtype_location_code<?php echo $i;?>"  id="edit_formtype_location_code_<?php  echo $i;?>" value="<?php echo $rowmodule['formtype_location_code'];?>" onchange="check_dup_formtype_location_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['formtype_location_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['formtype_location_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['formtype_location_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_formtype_location_btn_<?php echo $i;?>" id="edit_formtype_location_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_formtype_location(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>             
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_formtype_location_<?php echo $i;?>" id="save_formtype_location_<?php echo $i;?>" onclick="save_formtype_location(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_formtype_location_<?php echo $i;?>" id="cancel_formtype_location_<?php echo $i;?>" onclick="cancel_formtype_location(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Form Type Location?')){ del_formtype_location(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Form Type Location?')){ del_formtype_location(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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