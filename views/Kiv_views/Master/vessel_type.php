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
      
   $('#vessel_type').validate({
      rules:
               { 
          vesseltype_name:{
          required:true,
          alphaonly:true,
          maxlength:20, },


          vesseltype_code:{
          required:true,
          alphaonly:true,
          maxlength:4, },
                        },
      messages:
               {
         vesseltype_name:{
         required:"<font color='red'>Please enter Vessel type Name</span>",
         alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
         maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"
             },
         
         vesseltype_code:{
         required:"<font color='red'>Please enter Vessel type Code</span>",
         alphaonly:"<font color='red'>Only Alphabets Allowed</font>",
         maxlength:"<font color='red'>Maximum 4 Character allowed</font>"
             },
 
               },
      errorPlacement: function(error, element)
                     {
                        if ( element.is(":input") ) { error.appendTo( element.parent() ); }
                        else { error.insertAfter( element ); }
                     }
    }); 
});
function add_vesseltype()
{
      $("#view_vesseltype").hide();
  $("#add_vesseltype").show();
}
  
function delete_vesseltype()
{
  $("#add_vesseltype").hide();
  $("#view_vesseltype").show();
  $("#msgDiv").hide();
}
function ins_vesseltype()
{
    var vesseltype_insert   = $("#vesseltype_insert").val(); 
    var vesseltype_name   = $("#vesseltype_name").val(); 
    var vesseltype_mal_name   = $("#vesseltype_mal_name").val(); 
    var vesseltype_code   = $("#vesseltype_code").val();
      
  if(vesseltype_name=="")
        {
            alert("Vessel Type Name Required");
            $("#vesseltype_name").focus();
            return false;
            
        }
        
        if(vesseltype_code=="")
        {
            alert("Vessel Type Code Required");
            $("#vesseltype_code").focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_vesseltype/')?>",
          type: "POST",
          data:{vesseltype_insert:vesseltype_insert, vesseltype_name:vesseltype_name,vesseltype_mal_name:vesseltype_mal_name,vesseltype_code:vesseltype_code},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#vesseltype_name").val('');
              $("#vesseltype_mal_name").val('');
              $("#vesseltype_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_vesseltype/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_vesseltype(id,status)
{
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_vesseltype/')?>",
        type: "POST",
        data:{ id:id,stat:status},
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


function edit_vesseltype(id,i)
{
  $("#view_vesseltype").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_vesseltype_btn_"+i).hide();
  $("#save_vesseltype_"+i).show();
  $("#cancel_vesseltype_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_vesseltype(id,i)
{
  $("#view_vesseltype").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_vesseltype_btn_"+i).show();
  $("#save_vesseltype_"+i).hide();
  $("#cancel_vesseltype_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_vesseltype(id,i)
{
  var edit_vesseltype= $("#edit_vesseltype_"+i).val();
  var edit_vesseltype_code= $("#edit_vesseltype_code_"+i).val();
  var edit_vesseltype_mal= $("#edit_vesseltype_mal_"+i).val();
  var re = /^[ A-Za-z0-9]*$/;


  if(edit_vesseltype=="")
        {
            alert("Vessel Type Name Required");
            $("#edit_vesseltype_"+i).focus();
            return false;
            
        }
          
        if(edit_vesseltype_code=="")
        {
            alert("Vessel Type Code Required");
            $("#edit_vesseltype_code_"+i).focus();
            return false;
        }



  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");

    if (regex.exec(edit_vesseltype) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Vessel type Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Vessel type Name.</font>";
        document.getElementById("edit_vesseltype").value = null;
        return false;
    } 
      if (regcd.exec(edit_vesseltype_code) == null) 
  {
        alert("Only Alphabets Allowed in Vessel type Code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Vessel type Code.</font>";
        document.getElementById("edit_vesseltype_code").value = null;
        return false;
    } 


  if(edit_vesseltype=="" ||  edit_vesseltype_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Vessel type name And Vessel type Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_vesseltype/')?>",
          type: "POST",
          data:{ id:id,edit_vesseltype:edit_vesseltype,edit_vesseltype_mal:edit_vesseltype_mal,edit_vesseltype_code:edit_vesseltype_code},
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
    <span class="badge bg-darkmagenta innertitle "> Vessel Type </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "vessel_type", "name" => "vessel_type" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_vesseltype", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_vesseltype", $attributes);
    }?>
    
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_vesseltype">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_vesseltype()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Vessel Type</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_vesseltype" style="display:none;">
             <div class="col-4">
             <input type="text" name="vesseltype_name" maxlength="20" id="vesseltype_name" class="form-control"  placeholder=" Enter Vessel Type Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="vesseltype_mal_name" maxlength="50" id="vesseltype_mal_name" class="form-control"   placeholder=" Enter Vessel Type Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="vesseltype_code" id="vesseltype_code" maxlength="4" class="form-control"  placeholder=" Enter Vessel Type Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="vesseltype_insert" id="vesseltype_insert" value="Save Vessel Type" class="btn btn-info btn-flat" onClick="ins_vesseltype()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="vesseltype_del" id="vesseltype_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_vesseltype()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Vessel Type Name</th>
                  <th id="col_name1">Vessel Type Name(Malayalam)</th>
                  <th id="col_name2">Code</th>
                  <th>Status</th>
                  <th id="th_div"></th>
                  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                 <?php
        
        $i=1;
        foreach($vesseltype as $rowmodule){
        $id = $rowmodule['vesseltype_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['vesseltype_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="20" class="div300" type="text" name="edit_vesseltype_<?php echo $i;?>"  id="edit_vesseltype_<?php  echo $i;?>" value="<?php echo $rowmodule['vesseltype_name'];?>" onchange="check_dup_vesseltype_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['vesseltype_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_vesseltype_mal_<?php echo $i;?>"  id="edit_vesseltype_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['vesseltype_mal_name'];?>" onchange="check_dup_vesseltype_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['vesseltype_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_vesseltype_code<?php echo $i;?>"  id="edit_vesseltype_code_<?php  echo $i;?>" value="<?php echo $rowmodule['vesseltype_code'];?>" onchange="check_dup_vesseltype_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['vesseltype_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['vesseltype_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['vesseltype_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_vesseltype_btn_<?php echo $i;?>" id="edit_vesseltype_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_vesseltype(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>            
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_vesseltype_<?php echo $i;?>" id="save_vesseltype_<?php echo $i;?>" onclick="save_vesseltype(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_vesseltype_<?php echo $i;?>" id="cancel_vesseltype_<?php echo $i;?>" onclick="cancel_vesseltype(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Vessel type?')){ del_vesseltype(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Vessel Type?')){ del_vesseltype(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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