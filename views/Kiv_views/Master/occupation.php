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
      
   $('#occupation').validate({
      rules:
               { 
          occupation_name:{required:true,
          alphaonly:true,
          maxlength:50, },

          occupation_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             occupation_name:{required:"<font color='red'>Please enter Occupation Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 50 Characters allowed</font>"},
             
             occupation_code:{required:"<font color='red'>Please enter occupation Code</span>",
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

function add_occupation()
{
    $("#view_occupation").hide();
  $("#add_occupation").show();
}
  
function delete_occupation()
{
  $("#add_occupation").hide();
  $("#view_occupation").show();
  $("#msgDiv").hide();
}
function ins_occupation()
{
    var occupation_ins    = $("#occupation_ins").val(); 
    var occupation_name   = $("#occupation_name").val(); 
    var occupation_mal_name = $("#occupation_mal_name").val(); 
    var occupation_code   = $("#occupation_code").val();
    var csrf_token      = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(occupation_name=="")
        {
            alert("occupation Name Required");
            $("#occupation_name").focus();
            return false;
            
        }
        
        if(occupation_code=="")
        {
            alert("occupation Code Required");
            $("#occupation_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_occupation/')?>",
          type: "POST",
          data:{occupation_ins:occupation_ins, occupation_name:occupation_name,occupation_mal_name:occupation_mal_name,occupation_code:occupation_code,'csrf_test_name': csrf_token},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#occupation_name").val('');
              $("#occupation_mal_name").val('');
              $("#occupation_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_occupation/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_occupation(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_occupation/')?>",
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


function edit_occupation(id,i)
{
  $("#view_occupation").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_occupation_btn_"+i).hide();
  $("#save_occupation_"+i).show();
  $("#cancel_occupation_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_occupation(id,i)
{
  $("#view_occupation").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_occupation_btn_"+i).show();
  $("#save_occupation_"+i).hide();
  $("#cancel_occupation_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_occupation(id,i)
{
  var edit_occupation= $("#edit_occupation_"+i).val();
  var edit_occupation_code= $("#edit_occupation_code_"+i).val();
  var edit_occupation_mal= $("#edit_occupation_mal_"+i).val();
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;


if(edit_occupation=="")
        {
            alert("Occupation Name Required");
            $("#edit_occupation_"+i).focus();
            return false;
            
        }
        
        if(edit_occupation_code=="")
        {
            alert("Occupation Code Required");
            $("#edit_occupation_code_"+i).focus();
            return false;
        }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_occupation) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Occupation Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Occupation Name.</font>";
        document.getElementById("edit_occupation").value = null;
        return false;
    } 
      if (regcd.exec(edit_occupation_code) == null) 
  {
        alert("Only Alphabets Allowed in Occupation Code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Occupation Code.</font>";
        document.getElementById("edit_occupation_code").value = null;
        return false;
    } 

  if(edit_occupation=="" ||  edit_occupation_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Occupation Name And occupation Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_occupation/')?>",
          type: "POST",
          data:{ id:id,edit_occupation:edit_occupation,edit_occupation_mal:edit_occupation_mal,edit_occupation_code:edit_occupation_code,'csrf_test_name': csrf_token},
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
    <span class="badge bg-darkmagenta innertitle "> Occupation </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "occupation", "name" => "occupation" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_occupation", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_occupation", $attributes);
    }?>
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_occupation">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
          <button type="button" class="btn btn-sm btn-primary" onClick="add_occupation()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New occupation</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_occupation" style="display:none;">
             <div class="col-4">
             <input type="text" name="occupation_name" id="occupation_name" maxlength="50" class="form-control "  placeholder=" Enter occupation Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="occupation_mal_name" maxlength="50" id="occupation_mal_name" class="form-control"   placeholder=" Enter occupation Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="occupation_code" id="occupation_code" maxlength="4" class="form-control"  placeholder=" Enter occupation Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="occupation_ins" id="occupation_ins" value="Save occupation" class="btn btn-info btn-flat" onClick="ins_occupation()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="occupation_del" id="occupation_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_occupation()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Occupation Name</th>
                  <th id="col_name1">Occupation Name(Malayalam)</th>
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
        foreach($occupation as $rowmodule){
        $id = $rowmodule['occupation_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['occupation_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="50" class="div300" type="text" name="edit_occupation_<?php echo $i;?>"  id="edit_occupation_<?php  echo $i;?>" value="<?php echo $rowmodule['occupation_name'];?>" onchange="check_dup_occupation_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['occupation_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_occupation_mal_<?php echo $i;?>"  id="edit_occupation_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['occupation_mal_name'];?>" onchange="check_dup_occupation_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['occupation_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_occupation_code<?php echo $i;?>"  id="edit_occupation_code_<?php  echo $i;?>" value="<?php echo $rowmodule['occupation_code'];?>" onchange="check_dup_occupation_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['occupation_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['occupation_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['occupation_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_occupation_btn_<?php echo $i;?>" id="edit_occupation_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_occupation(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>            
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_occupation_<?php echo $i;?>" id="save_occupation_<?php echo $i;?>" onclick="save_occupation(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_occupation_<?php echo $i;?>" id="cancel_occupation_<?php echo $i;?>" onclick="cancel_occupation(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete occupation?')){ del_occupation(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete occupation?')){ del_occupation(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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