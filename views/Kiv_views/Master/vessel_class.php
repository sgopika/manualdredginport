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
      
   $('#vessel_class').validate({
      rules:
               { 
          vessel_class_name:{required:true,
          alphaonly:true,
          maxlength:20, },

          vessel_class_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             vessel_class_name:{required:"<font color='red'>Please enter Vessel Class Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
             
             vessel_class_code:{required:"<font color='red'>Please enter Vessel Class Code</span>",
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

function add_vessel_class()
{
      $("#view_vessel_class").hide();
  $("#add_vessel_class").show();
}
  
function delete_vessel_class()
{
  $("#add_vessel_class").hide();
  $("#view_vessel_class").show();
  $("#msgDiv").hide();
}
function ins_vessel_class()
{
    var vessel_class_ins    = $("#vessel_class_ins").val(); 
    var vessel_class_name   = $("#vessel_class_name").val(); 
    var vessel_class_mal_name = $("#vessel_class_mal_name").val(); 
    var vessel_class_code   = $("#vessel_class_code").val();
      
  if(vessel_class_name=="")
        {
            alert("Vessel Class Name Required");
            $("#vessel_class_name").focus();
            return false;
            
        }
        
        if(vessel_class_code=="")
        {
            alert("Vessel Class Code Required");
            $("#vessel_class_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_vessel_class/')?>",
          type: "POST",
          data:{vessel_class_ins:vessel_class_ins, vessel_class_name:vessel_class_name,vessel_class_mal_name:vessel_class_mal_name,vessel_class_code:vessel_class_code},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#vessel_class_name").val('');
              $("#vessel_class_mal_name").val('');
              $("#vessel_class_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_vessel_class/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_vessel_class(id,status)
{
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_vessel_class/')?>",
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


function edit_vessel_class(id,i)
{
  $("#view_vessel_class").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_vessel_class_btn_"+i).hide();
  $("#save_vessel_class_"+i).show();
  $("#cancel_vessel_class_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_vessel_class(id,i)
{
  $("#view_vessel_class").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_vessel_class_btn_"+i).show();
  $("#save_vessel_class_"+i).hide();
  $("#cancel_vessel_class_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_vessel_class(id,i)
{
  var edit_vessel_class= $("#edit_vessel_class_"+i).val();
  var edit_vessel_class_code= $("#edit_vessel_class_code_"+i).val();
  var edit_vessel_class_mal= $("#edit_vessel_class_mal_"+i).val();
  var re = /^[ A-Za-z0-9]*$/;


  if(edit_vessel_class=="")
        {
            alert("Vessel Class Name Required");
            $("#edit_vessel_class_"+i).focus();
            return false;
            
        }
          
        if(edit_vessel_class_code=="")
        {
            alert("Vessel Class Code Required");
            $("#edit_vessel_class_code_"+i).focus();
            return false;
        }


  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_vessel_class) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Vessel Class Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Vessel Class Name.</font>";
        document.getElementById("edit_vessel_class").value = null;
        return false;
    } 
      if (regcd.exec(edit_vessel_class_code) == null) 
  {
        alert("Only Alphabets Allowed in Vessel Class Code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Vessel Class Code.</font>";
        document.getElementById("edit_vessel_class_code").value = null;
        return false;
    } 



  if(edit_vessel_class=="" ||  edit_vessel_class_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Vessel Class Name And Vessel Class Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_vessel_class/')?>",
          type: "POST",
          data:{ id:id,edit_vessel_class:edit_vessel_class,edit_vessel_class_mal:edit_vessel_class_mal,edit_vessel_class_code:edit_vessel_class_code},
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
    <span class="badge bg-darkmagenta innertitle "> Vessel Class </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "vessel_class", "name" => "vessel_class" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_vessel_class", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_vessel_class", $attributes);
    }?>
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_vessel_class">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_vessel_class()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Vessel Class</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_vessel_class" style="display:none;">
             <div class="col-4">
             <input type="text" name="vessel_class_name" maxlength="20" id="vessel_class_name" class="form-control "  placeholder=" Enter Vessel Class Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="vessel_class_mal_name" maxlength="50" id="vessel_class_mal_name" class="form-control"   placeholder=" Enter Vessel Class Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="vessel_class_code" maxlength="4" id="vessel_class_code" class="form-control"  placeholder=" Enter vessel_class Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="vessel_class_ins" id="vessel_class_ins" value="Save Vessel Class" class="btn btn-info btn-flat" onClick="ins_vessel_class()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="vessel_class_del" id="vessel_class_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_vessel_class()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">vessel_class Name</th>
                  <th id="col_name1">vessel_class Name(Malayalam)</th>
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
        foreach($vessel_class as $rowmodule){
        $id = $rowmodule['vessel_class_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['vessel_class_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_vessel_class_<?php echo $i;?>"  id="edit_vessel_class_<?php  echo $i;?>" value="<?php echo $rowmodule['vessel_class_name'];?>" onchange="check_dup_vessel_class_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['vessel_class_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_vessel_class_mal_<?php echo $i;?>"  id="edit_vessel_class_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['vessel_class_mal_name'];?>" onchange="check_dup_vessel_class_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['vessel_class_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_vessel_class_code<?php echo $i;?>"  id="edit_vessel_class_code_<?php  echo $i;?>" value="<?php echo $rowmodule['vessel_class_code'];?>" onchange="check_dup_vessel_class_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['vessel_class_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['vessel_class_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['vessel_class_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_vessel_class_btn_<?php echo $i;?>" id="edit_vessel_class_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_vessel_class(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>            
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_vessel_class_<?php echo $i;?>" id="save_vessel_class_<?php echo $i;?>" onclick="save_vessel_class(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_vessel_class_<?php echo $i;?>" id="cancel_vessel_class_<?php echo $i;?>" onclick="cancel_vessel_class(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Vessel Class?')){ del_vessel_class(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Vessel Class?')){ del_vessel_class(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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