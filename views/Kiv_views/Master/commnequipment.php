
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
      
   $('#commnequipment').validate({
      rules:
               { 
          commnequipment_name:{required:true,
          alphaonly:true,
          maxlength:20, },

          commnequipment_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
             commnequipment_name:{required:"<font color='red'>Please enter Communication Equipment Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed in Communication Equipment Name.</font>",
             maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"},
             
             commnequipment_code:{required:"<font color='red'>Please enter Communication Equipment Code</span>",
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

function add_commnequipment()
{
    $("#view_commnequipment").hide();
  $("#add_commnequipment").show();
}
  
function delete_commnequipment()
{
  $("#add_commnequipment").hide();
  $("#view_commnequipment").show();
  $("#msgDiv").hide();
}
function ins_commnequipment()
{
    var commnequipment_ins    = $("#commnequipment_ins").val(); 
    var commnequipment_name   = $("#commnequipment_name").val(); 
    var commnequipment_mal_name = $("#commnequipment_mal_name").val(); 
    var commnequipment_code   = $("#commnequipment_code").val();
    var csrf_token            = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(commnequipment_name=="")
        {
            alert("Communication Equipment Name Required");
            $("#commnequipment_name").focus();
            return false;
            
        }
        
        if(commnequipment_code=="")
        {
            alert("Communication Equipment Code Required");
            $("#commnequipment_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_commnequipment/')?>",
          type: "POST",
          data:{commnequipment_ins:commnequipment_ins, commnequipment_name:commnequipment_name,commnequipment_mal_name:commnequipment_mal_name,commnequipment_code:commnequipment_code,'csrf_test_name': csrf_token},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#commnequipment_name").val('');
              $("#commnequipment_mal_name").val('');
              $("#commnequipment_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_commnequipment/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_commnequipment(id,status)
{
  
    var csrf_token            = '<?php echo $this->security->get_csrf_hash(); ?>';
    $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_commnequipment/')?>",
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


function edit_commnequipment(id,i)
{
  $("#view_commnequipment").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_commnequipment_btn_"+i).hide();
  $("#save_commnequipment_"+i).show();
  $("#cancel_commnequipment_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_commnequipment(id,i)
{
  $("#view_commnequipment").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_commnequipment_btn_"+i).show();
  $("#save_commnequipment_"+i).hide();
  $("#cancel_commnequipment_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_commnequipment(id,i)
{
  var edit_commnequipment= $("#edit_commnequipment_"+i).val();
  var edit_commnequipment_code= $("#edit_commnequipment_code_"+i).val();
  var edit_commnequipment_mal= $("#edit_commnequipment_mal_"+i).val();
  var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;
  

  if(edit_commnequipment=="")
        {
            alert("Communication Equipment Name Required");
            $("#edit_commnequipment_"+i).focus();
            return false;
            
        }
          
        if(edit_commnequipment_code=="")
        {
            alert("Communication Equipment Code Required");
            $("#edit_commnequipment_code_"+i).focus();
            return false;
        }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_commnequipment) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Communication Equipment name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Communication Equipment name.</font>";
        document.getElementById("edit_commnequipment").value = null;
        return false;
    } 
      if (regcd.exec(edit_commnequipment_code) == null) 
  {
        alert("Only Alphabets Allowed in Communication Equipment code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Communication Equipment code.</font>";
        document.getElementById("edit_commnequipment_code").value = null;
        return false;
    } 



  if(edit_commnequipment=="" ||  edit_commnequipment_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Communication Equipment Name And Communication Equipment Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_commnequipment/')?>",
          type: "POST",
          data:{ id:id,edit_commnequipment:edit_commnequipment,edit_commnequipment_mal:edit_commnequipment_mal,edit_commnequipment_code:edit_commnequipment_code,'csrf_test_name': csrf_token},
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
    <span class="badge bg-darkmagenta innertitle "> Communication Equipment </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "commnequipment", "name" => "commnequipment" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_commnequipment", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_commnequipment", $attributes);
    }?>
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_commnequipment">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
          <button type="button" class="btn btn-sm btn-primary" onClick="add_commnequipment()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Communication Equipment</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_commnequipment" style="display:none;">
             <div class="col-4">
             <input type="text" name="commnequipment_name" id="commnequipment_name" class="form-control "  placeholder=" Enter Communication Equipment Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="commnequipment_mal_name" maxlength="30" id="commnequipment_mal_name" class="form-control"   placeholder=" Enter Communication Equipment Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="commnequipment_code" id="commnequipment_code" class="form-control"  placeholder=" Enter Communication Equipment Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="commnequipment_ins" id="commnequipment_ins" value="Save Communication Equipment" class="btn btn-info btn-flat" onClick="ins_commnequipment()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="commnequipment_del" id="commnequipment_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_commnequipment()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Communication Equipment Name</th>
                  <th id="col_name1">Communication Equipment Name(Malayalam)</th>
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
        foreach($commnequipment as $rowmodule){
        $id = $rowmodule['commnequipment_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['commnequipment_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="30" class="div300" type="text" name="edit_commnequipment_<?php echo $i;?>"  id="edit_commnequipment_<?php  echo $i;?>" value="<?php echo $rowmodule['commnequipment_name'];?>" onchange="check_dup_commnequipment_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['commnequipment_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="30" class="div300"  type="text" name="edit_commnequipment_mal_<?php echo $i;?>"  id="edit_commnequipment_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['commnequipment_mal_name'];?>" onchange="check_dup_commnequipment_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['commnequipment_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_commnequipment_code<?php echo $i;?>"  id="edit_commnequipment_code_<?php  echo $i;?>" value="<?php echo $rowmodule['commnequipment_code'];?>" onchange="check_dup_commnequipment_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['commnequipment_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['commnequipment_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['commnequipment_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_commnequipment_btn_<?php echo $i;?>" id="edit_commnequipment_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_commnequipment(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>            
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_commnequipment_<?php echo $i;?>" id="save_commnequipment_<?php echo $i;?>" onclick="save_commnequipment(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_commnequipment_<?php echo $i;?>" id="cancel_commnequipment_<?php echo $i;?>" onclick="cancel_commnequipment(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Communication Equipment?')){ del_commnequipment(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Communication Equipment?')){ del_commnequipment(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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