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
      
   $('#pollution_controldevice').validate({
      rules:
               { 
          pollution_controldevice_name:{required:true,
          alphaonly:true,
          maxlength:50, },

          pollution_controldevice_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             pollution_controldevice_name:{required:"<font color='red'>Please enter Pollution Control Device Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 50 Characters allowed</font>"},
             
             pollution_controldevice_code:{required:"<font color='red'>Please enter Pollution Control Device Code</span>",
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

function add_pollution_controldevice()
{
    $("#view_pollution_controldevice").hide();
  $("#add_pollution_controldevice").show();
}
  
function delete_pollution_controldevice()
{
  $("#add_pollution_controldevice").hide();
  $("#view_pollution_controldevice").show();
  $("#msgDiv").hide();
}
function ins_pollution_controldevice()
{
    var pollution_controldevice_ins     = $("#pollution_controldevice_ins").val(); 
    var pollution_controldevice_name    = $("#pollution_controldevice_name").val(); 
    var pollution_controldevice_mal_name  = $("#pollution_controldevice_mal_name").val(); 
    var pollution_controldevice_code    = $("#pollution_controldevice_code").val();
    var csrf_token              = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(pollution_controldevice_name=="")
        {
            alert("Pollution control device Name Required");
            $("#pollution_controldevice_name").focus();
            return false;
            
        }
        
        if(pollution_controldevice_code=="")
        {
            alert("Pollution_controldevice Code Required");
            $("#pollution_controldevice_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_pollution_controldevice/')?>",
          type: "POST",
          data:{pollution_controldevice_ins:pollution_controldevice_ins, pollution_controldevice_name:pollution_controldevice_name,pollution_controldevice_mal_name:pollution_controldevice_mal_name,pollution_controldevice_code:pollution_controldevice_code,'csrf_test_name': csrf_token},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#pollution_controldevice_name").val('');
              $("#pollution_controldevice_mal_name").val('');
              $("#pollution_controldevice_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_pollution_controldevice/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_pollution_controldevice(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_pollution_controldevice/')?>",
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


function edit_pollution_controldevice(id,i)
{
  $("#view_pollution_controldevice").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_pollution_controldevice_btn_"+i).hide();
  $("#save_pollution_controldevice_"+i).show();
  $("#cancel_pollution_controldevice_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_pollution_controldevice(id,i)
{
  $("#view_pollution_controldevice").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_pollution_controldevice_btn_"+i).show();
  $("#save_pollution_controldevice_"+i).hide();
  $("#cancel_pollution_controldevice_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_pollution_controldevice(id,i)
{
  var edit_pollution_controldevice= $("#edit_pollution_controldevice_"+i).val();
  var edit_pollution_controldevice_code= $("#edit_pollution_controldevice_code_"+i).val();
  var edit_pollution_controldevice_mal= $("#edit_pollution_controldevice_mal_"+i).val();
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;



  if(edit_pollution_controldevice=="")
        {
            alert("Pollution Control Device Name Required");
            $("#edit_pollution_controldevice_"+i).focus();
            return false;
            
        }
        
        if(edit_pollution_controldevice_code=="")
        {
            alert("Pollution Control Device Code Required");
            $("#edit_pollution_controldevice_code_"+i).focus();
            return false;
        }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_pollution_controldevice) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Pollution Control Device Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Pollution Control Device Name.</font>";
        document.getElementById("edit_pollution_controldevice").value = null;
        return false;
    } 
      if (regcd.exec(edit_pollution_controldevice_code) == null) 
  {
        alert("Only Alphabets Allowed in Pollution Control Device Code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Pollution Control Device Code.</font>";
        document.getElementById("edit_pollution_controldevice_code").value = null;
        return false;
    } 


  if(edit_pollution_controldevice=="" ||  edit_pollution_controldevice_code==""){
      $("#msgDiv").show();
      pollution_controldevice.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Pollution Control Device Name And Pollution Control Device Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_pollution_controldevice/')?>",
          type: "POST",
          data:{ id:id,edit_pollution_controldevice:edit_pollution_controldevice,edit_pollution_controldevice_mal:edit_pollution_controldevice_mal,edit_pollution_controldevice_code:edit_pollution_controldevice_code,'csrf_test_name': csrf_token},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              pollution_controldevice.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
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
    <span class="badge bg-darkmagenta innertitle "> Pollution Control Device </span>
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
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_pollution_controldevice">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_pollution_controldevice()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Pollution Control Device</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_pollution_controldevice" style="display:none;">
             <div class="col-4">
             <input type="text" name="pollution_controldevice_name" maxlength="50" id="pollution_controldevice_name" class="form-control "  placeholder=" Enter Pollution Control Device Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="pollution_controldevice_mal_name"  maxlength="50" id="pollution_controldevice_mal_name" class="form-control"   placeholder=" Enter Pollution Control Device Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="pollution_controldevice_code" maxlength="4" id="pollution_controldevice_code" class="form-control"  placeholder=" Enter Pollution Control Device Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="pollution_controldevice_ins" id="pollution_controldevice_ins" value="Save Pollution Control Device" class="btn btn-info btn-flat" onClick="ins_pollution_controldevice()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3">
            <input type="button" name="pollution_controldevice_del" id="pollution_controldevice_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_pollution_controldevice()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Pollution Control Device Name</th>
                  <th id="col_name1">Pollution Control Device Name(Malayalam)</th>
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
        foreach($pollution_controldevice as $rowmodule){
        $id = $rowmodule['pollution_controldevice_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['pollution_controldevice_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="50" class="div300" type="text" name="edit_pollution_controldevice_<?php echo $i;?>"  id="edit_pollution_controldevice_<?php  echo $i;?>" value="<?php echo $rowmodule['pollution_controldevice_name'];?>" onchange="check_dup_pollution_controldevice_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['pollution_controldevice_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_pollution_controldevice_mal_<?php echo $i;?>"  id="edit_pollution_controldevice_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['pollution_controldevice_mal_name'];?>" onchange="check_dup_pollution_controldevice_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['pollution_controldevice_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_pollution_controldevice_code<?php echo $i;?>"  id="edit_pollution_controldevice_code_<?php  echo $i;?>" value="<?php echo $rowmodule['pollution_controldevice_code'];?>" onchange="check_dup_pollution_controldevice_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['pollution_controldevice_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['pollution_controldevice_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['pollution_controldevice_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_pollution_controldevice_btn_<?php echo $i;?>" id="edit_pollution_controldevice_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_pollution_controldevice(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>             
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_pollution_controldevice_<?php echo $i;?>" id="save_pollution_controldevice_<?php echo $i;?>" onclick="save_pollution_controldevice(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_pollution_controldevice_<?php echo $i;?>" id="cancel_pollution_controldevice_<?php echo $i;?>" onclick="cancel_pollution_controldevice(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete pollution_controldevice?')){ del_pollution_controldevice(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete pollution_controldevice?')){ del_pollution_controldevice(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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