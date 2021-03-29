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
      
   $('#towing').validate({
      rules:
               { 
          towing_name:{required:true,
          alphaonly:true,
          maxlength:50, },

          towing_code:{required:true,
          alphaonly:true,
          maxlength:4, },
                     },
      messages:
               {
             towing_name:{required:"<font color='red'>Please enter Towing Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 50 Characters allowed</font>"},
             
             towing_code:{required:"<font color='red'>Please enter Towing Code</span>",
             alphaonly:"<font color='red'>Only Alphabets Allowed</font>",
             maxlength:"<font color='red'>Maximum 4 Character allowed</font>"},
 
               },
      errorPlacement: function(error, element)
                     {
                        if ( element.is(":input") ) { error.appendTo( element.parent() ); }
                        else { error.insertAfter( element ); }
                     }
    }); 
});

function add_towing()
{
      $("#view_towing").hide();
  $("#add_towing").show();
}
  
function delete_towing()
{
  $("#add_towing").hide();
  $("#view_towing").show();
  $("#msgDiv").hide();
}
function ins_towing()
{
    var towing_ins    = $("#towing_ins").val(); 
    var towing_name   = $("#towing_name").val(); 
    var towing_mal_name = $("#towing_mal_name").val(); 
    var towing_code   = $("#towing_code").val();
      
  if(towing_name=="")
        {
            alert("Towing Name Required");
            $("#towing_name").focus();
            return false;
            
        }
        
        if(towing_code=="")
        {
            alert("Towing Code Required");
            $("#towing_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_towing/')?>",
          type: "POST",
          data:{towing_ins:towing_ins, towing_name:towing_name,towing_mal_name:towing_mal_name,towing_code:towing_code},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#towing_name").val('');
              $("#towing_mal_name").val('');
              $("#towing_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_towing/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_towing(id,status)
{
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_towing/')?>",
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


function edit_towing(id,i)
{
  $("#view_towing").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_towing_btn_"+i).hide();
  $("#save_towing_"+i).show();
  $("#cancel_towing_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_towing(id,i)
{
  $("#view_towing").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_towing_btn_"+i).show();
  $("#save_towing_"+i).hide();
  $("#cancel_towing_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_towing(id,i)
{
  var edit_towing= $("#edit_towing_"+i).val();
  var edit_towing_code= $("#edit_towing_code_"+i).val();
  var edit_towing_mal= $("#edit_towing_mal_"+i).val();
  var re = /^[ A-Za-z0-9]*$/;



  

  if(edit_towing=="")
        {
            alert("Towing Name Required");
            $("#edit_towing_"+i).focus();
            return false;
            
        }
        
        if(edit_towing_code=="")
        {
            alert("Towing Code Required");
            $("#edit_towing_code_"+i).focus();
            return false;
        }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_towing) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Towing Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Towing Name.</font>";
        document.getElementById("edit_towing").value = null;
        return false;
    } 
      if (regcd.exec(edit_towing_code) == null) 
  {
        alert("Only Alphabets Allowed in Towing Code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Towing Code.</font>";
        document.getElementById("edit_towing_code").value = null;
        return false;
    } 



  if(edit_towing=="" ||  edit_towing_code==""){
      $("#msgDiv").show();
      towing.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Towing Name And Towing Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_towing/')?>",
          type: "POST",
          data:{ id:id,edit_towing:edit_towing,edit_towing_mal:edit_towing_mal,edit_towing_code:edit_towing_code},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              towing.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
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
    <span class="badge bg-darkmagenta innertitle "> Towing </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "towing", "name" => "towing" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_towing", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_towing", $attributes);
    }?>
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_towing">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_towing()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Towing</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_towing" style="display:none;">
             <div class="col-4">
             <input type="text" name="towing_name" id="towing_name" maxlength="50" class="form-control "  placeholder=" Enter Towing Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="towing_mal_name" maxlength="50" id="towing_mal_name" class="form-control"   placeholder=" Enter Towing Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="towing_code" id="towing_code" maxlength="4" class="form-control"  placeholder=" Enter Towing Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="towing_ins" id="towing_ins" value="Save Towing" class="btn btn-info btn-flat" onClick="ins_towing()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="towing_del" id="towing_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_towing()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Towing Name</th>
                  <th id="col_name1">Towing Name(Malayalam)</th>
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
        foreach($towing as $rowmodule){
        $id = $rowmodule['towing_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['towing_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="50" class="div300" type="text" name="edit_towing_<?php echo $i;?>"  id="edit_towing_<?php  echo $i;?>" value="<?php echo $rowmodule['towing_name'];?>" onchange="check_dup_towing_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['towing_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_towing_mal_<?php echo $i;?>"  id="edit_towing_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['towing_mal_name'];?>" onchange="check_dup_towing_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['towing_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_towing_code<?php echo $i;?>"  id="edit_towing_code_<?php  echo $i;?>" value="<?php echo $rowmodule['towing_code'];?>" onchange="check_dup_towing_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['towing_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['towing_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['towing_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_towing_btn_<?php echo $i;?>" id="edit_towing_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_towing(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>            
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_towing_<?php echo $i;?>" id="save_towing_<?php echo $i;?>" onclick="save_towing(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_towing_<?php echo $i;?>" id="cancel_towing_<?php echo $i;?>" onclick="cancel_towing(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete towing?')){ del_towing(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete towing?')){ del_towing(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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