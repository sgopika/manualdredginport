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
      
   $('#surveyactivity').validate({
      rules:
               { 
          surveyactivity_name:{required:true,
          alphaonly:true,
          maxlength:20, },

          surveyactivity_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             surveyactivity_name:{required:"<font color='red'>Please enter Survey Activity Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
             
             surveyactivity_code:{required:"<font color='red'>Please enter Survey Activity Code</span>",
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

function add_surveyactivity()
{
      $("#view_surveyactivity").hide();
  $("#add_surveyactivity").show();
}
  
function delete_surveyactivity()
{
  $("#add_surveyactivity").hide();
  $("#view_surveyactivity").show();
  $("#msgDiv").hide();
}
function ins_surveyactivity()
{
    var surveyactivity_ins    = $("#surveyactivity_ins").val(); 
    var surveyactivity_name   = $("#surveyactivity_name").val(); 
    var surveyactivity_mal_name = $("#surveyactivity_mal_name").val(); 
    var surveyactivity_code   = $("#surveyactivity_code").val();
      
  if(surveyactivity_name=="")
        {
            alert("surveyactivity Name Required");
            $("#surveyactivity_name").focus();
            return false;
            
        }
        
        if(surveyactivity_code=="")
        {
            alert("surveyactivity Code Required");
            $("#surveyactivity_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_surveyactivity/')?>",
          type: "POST",
          data:{surveyactivity_ins:surveyactivity_ins, surveyactivity_name:surveyactivity_name,surveyactivity_mal_name:surveyactivity_mal_name,surveyactivity_code:surveyactivity_code},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#surveyactivity_name").val('');
              $("#surveyactivity_mal_name").val('');
              $("#surveyactivity_code").val('');
            }
            else{
              window.location.reload(true);
            }
          }
        });
    
}
function toggle_status(id,status)
{
  
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_surveyactivity/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_surveyactivity(id,status)
{
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_surveyactivity/')?>",
        type: "POST",
        data:{ id:id,stat:status},
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


function edit_surveyactivity(id,i)
{
  $("#view_surveyactivity").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_surveyactivity_btn_"+i).hide();
  $("#save_surveyactivity_"+i).show();
  $("#cancel_surveyactivity_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_surveyactivity(id,i)
{
  $("#view_surveyactivity").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_surveyactivity_btn_"+i).show();
  $("#save_surveyactivity_"+i).hide();
  $("#cancel_surveyactivity_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_surveyactivity(id,i)
{
  var edit_surveyactivity= $("#edit_surveyactivity_"+i).val();
  var edit_surveyactivity_code= $("#edit_surveyactivity_code_"+i).val();
  var edit_surveyactivity_mal= $("#edit_surveyactivity_mal_"+i).val();
  var re = /^[ A-Za-z0-9]*$/;



  

  if(edit_surveyactivity=="")
        {
            alert("Survey Activity Name Required");
            $("#edit_surveyactivity_"+i).focus();
            return false;
            
        }
        
        if(edit_surveyactivity_code=="")
        {
            alert("Survey Activity Code Required");
            $("#edit_surveyactivity_code_"+i).focus();
            return false;
        }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_surveyactivity) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Survey Activity Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Survey Activity Name.</font>";
        document.getElementById("edit_surveyactivity").value = null;
        return false;
    } 
      if (regcd.exec(edit_surveyactivity_code) == null) 
  {
        alert("Only Alphabets Allowed< in Survey Activity Code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed< in Survey Activity Code.</font>";
        document.getElementById("edit_surveyactivity_code").value = null;
        return false;
    } 



  if(edit_surveyactivity=="" ||  edit_surveyactivity_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Survey Activity Name And Survey Activity Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_surveyactivity/')?>",
          type: "POST",
          data:{ id:id,edit_surveyactivity:edit_surveyactivity,edit_surveyactivity_mal:edit_surveyactivity_mal,edit_surveyactivity_code:edit_surveyactivity_code},
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
    <span class="badge bg-darkmagenta innertitle "> Survey Activity </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "surveyactivity", "name" => "surveyactivity" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_surveyactivity", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_surveyactivity", $attributes);
    }?>
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_surveyactivity">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_surveyactivity()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Survey Activity</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_surveyactivity" style="display:none;">
             <div class="col-4">
             <input type="text" name="surveyactivity_name" maxlength="20" id="surveyactivity_name" class="form-control "  placeholder=" Enter Survey Activity Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="surveyactivity_mal_name" maxlength="50" id="surveyactivity_mal_name" class="form-control"   placeholder=" Enter Survey Activity Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="surveyactivity_code" id="surveyactivity_code" maxlength="4" class="form-control"  placeholder=" Enter Survey Activity Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
              <input type="button" name="surveyactivity_ins" id="surveyactivity_ins" value="Save Survey Activity" class="btn btn-info btn-flat" onClick="ins_surveyactivity()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="surveyactivity_del" id="surveyactivity_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_surveyactivity()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Survey Activity Name</th>
                  <th id="col_name1">Survey Activity Name(Malayalam)</th>
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
        foreach($surveyactivity as $rowmodule){
        $id = $rowmodule['surveyactivity_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['surveyactivity_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_surveyactivity_<?php echo $i;?>"  id="edit_surveyactivity_<?php  echo $i;?>" value="<?php echo $rowmodule['surveyactivity_name'];?>" onchange="check_dup_surveyactivity_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['surveyactivity_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_surveyactivity_mal_<?php echo $i;?>"  id="edit_surveyactivity_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['surveyactivity_mal_name'];?>" onchange="check_dup_surveyactivity_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['surveyactivity_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_surveyactivity_code<?php echo $i;?>"  id="edit_surveyactivity_code_<?php  echo $i;?>" value="<?php echo $rowmodule['surveyactivity_code'];?>" onchange="check_dup_surveyactivity_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['surveyactivity_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['surveyactivity_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['surveyactivity_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_surveyactivity_btn_<?php echo $i;?>" id="edit_surveyactivity_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_surveyactivity(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>            
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_surveyactivity_<?php echo $i;?>" id="save_surveyactivity_<?php echo $i;?>" onclick="save_surveyactivity(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_surveyactivity_<?php echo $i;?>" id="cancel_surveyactivity_<?php echo $i;?>" onclick="cancel_surveyactivity(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete surveyactivity?')){ del_surveyactivity(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete surveyactivity?')){ del_surveyactivity(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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