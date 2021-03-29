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
      
   $('#plyingstate').validate({
      rules:
               { 
          plyingstate_name:{required:true,
          alphaonly:true,
          maxlength:20, },

          plyingstate_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             plyingstate_name:{required:"<font color='red'>Please enter Plying State Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 30 Characters allowed</font>"},
             
             plyingstate_code:{required:"<font color='red'>Please enter Plying State Code</span>",
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

function add_plyingstate()
{
    $("#view_plyingstate").hide();
  $("#add_plyingstate").show();
}
  
function delete_plyingstate()
{
  $("#add_plyingstate").hide();
  $("#view_plyingstate").show();
  $("#msgDiv").hide();
}
function ins_plyingstate()
{
    var plyingstate_ins     = $("#plyingstate_ins").val(); 
    var plyingstate_name    = $("#plyingstate_name").val(); 
    var plyingstate_mal_name  = $("#plyingstate_mal_name").val(); 
    var plyingstate_code    = $("#plyingstate_code").val();
    var csrf_token        = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(plyingstate_name=="")
        {
            alert("plyingstate Name Required");
            $("#plyingstate_name").focus();
            return false;
            
        }
        
        if(plyingstate_code=="")
        {
            alert("plyingstate Code Required");
            $("#plyingstate_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Master/add_plyingstate/')?>",
          type: "POST",
          data:{plyingstate_ins:plyingstate_ins, plyingstate_name:plyingstate_name,plyingstate_mal_name:plyingstate_mal_name,plyingstate_code:plyingstate_code,'csrf_test_name': csrf_token},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#plyingstate_name").val('');
              $("#plyingstate_mal_name").val('');
              $("#plyingstate_code").val('');
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
        url : "<?php echo site_url('Master/status_plyingstate/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_plyingstate(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Master/delete_plyingstate/')?>",
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


function edit_plyingstate(id,i)
{
  $("#view_plyingstate").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_plyingstate_btn_"+i).hide();
  $("#save_plyingstate_"+i).show();
  $("#cancel_plyingstate_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_plyingstate(id,i)
{
  $("#view_plyingstate").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_plyingstate_btn_"+i).show();
  $("#save_plyingstate_"+i).hide();
  $("#cancel_plyingstate_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_plyingstate(id,i)
{
  var edit_plyingstate= $("#edit_plyingstate_"+i).val();
  var edit_plyingstate_code= $("#edit_plyingstate_code_"+i).val();
  var edit_plyingstate_mal= $("#edit_plyingstate_mal_"+i).val();
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;



  if(edit_plyingstate=="")
        {
            alert("Plying State Name Required");
            $("#edit_plyingstate_"+i).focus();
            return false;
            
        }
        
        if(edit_plyingstate_code=="")
        {
            alert("Plying State Code Required");
            $("#edit_plyingstate_code_"+i).focus();
            return false;
        }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_plyingstate) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Plying State Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Plying State Name.</font>";
        document.getElementById("edit_plyingstate").value = null;
        return false;
    } 
      if (regcd.exec(edit_plyingstate_code) == null) 
  {
        alert("Only Alphabets Allowed in Plying State Code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Plying State Code.</font>";
        document.getElementById("edit_plyingstate_code").value = null;
        return false;
    } 


  if(edit_plyingstate=="" ||  edit_plyingstate_code==""){
      $("#msgDiv").show();
      plyingstate.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Plying State Name And Plying State Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Master/edit_plyingstate/')?>",
          type: "POST",
          data:{ id:id,edit_plyingstate:edit_plyingstate,edit_plyingstate_mal:edit_plyingstate_mal,edit_plyingstate_code:edit_plyingstate_code,'csrf_test_name': csrf_token},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              plyingstate.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
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
    <span class="badge bg-darkmagenta innertitle "> Name </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "plyingstate", "name" => "plyingstate" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Master/add_plyingstate", $attributes);
    } else {
      echo form_open("Master/add_plyingstate", $attributes);
    }?>
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_plyingstate">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_plyingstate()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Plying State</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_plyingstate" style="display:none;">
             <div class="col-4">
             <input type="text" name="plyingstate_name" maxlength="20" id="plyingstate_name" class="form-control col-md-3"  placeholder=" Enter Plying State Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="plyingstate_mal_name" maxlength="50" id="plyingstate_mal_name" class="form-control"   placeholder=" Enter Plying State Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="plyingstate_code" maxlength="4" id="plyingstate_code" class="form-control"  placeholder=" Enter Plying State Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6">
             <input type="button" name="plyingstate_ins" id="plyingstate_ins" value="Save Plying State" class="btn btn-info btn-flat" onClick="ins_plyingstate()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6">
            <input type="button" name="plyingstate_del" id="plyingstate_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_plyingstate()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Plying State Name</th>
                  <th id="col_name1">Plying State Name(Malayalam)</th>
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
        foreach($plyingstate as $rowmodule){
        $id = $rowmodule['plyingstate_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['plyingstate_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_plyingstate_<?php echo $i;?>"  id="edit_plyingstate_<?php  echo $i;?>" value="<?php echo $rowmodule['plyingstate_name'];?>" onchange="check_dup_plyingstate_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['plyingstate_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_plyingstate_mal_<?php echo $i;?>"  id="edit_plyingstate_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['plyingstate_mal_name'];?>" onchange="check_dup_plyingstate_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['plyingstate_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_plyingstate_code<?php echo $i;?>"  id="edit_plyingstate_code_<?php  echo $i;?>" value="<?php echo $rowmodule['plyingstate_code'];?>" onchange="check_dup_plyingstate_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['plyingstate_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['plyingstate_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['plyingstate_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_plyingstate_btn_<?php echo $i;?>" id="edit_plyingstate_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_plyingstate(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>             
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_plyingstate_<?php echo $i;?>" id="save_plyingstate_<?php echo $i;?>" onclick="save_plyingstate(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_plyingstate_<?php echo $i;?>" id="cancel_plyingstate_<?php echo $i;?>" onclick="cancel_plyingstate(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete plyingstate?')){ del_plyingstate(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete plyingstate?')){ del_plyingstate(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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