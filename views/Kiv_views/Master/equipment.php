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
      
   $('#equipment').validate({
      rules:
               { 
          equipment_type_id:{required:true, },

          equipment_name:{required:true,
          alphaonly:true,
          maxlength:50, },

          equipment_code:{required:true,
          nospecialmin:true,
          maxlength:4, },
                     },
      messages:
               {
         equipment_type_id:{required:"<font color='red'>Please enter Equipment Name</span>" },

         equipment_name:{required:"<font color='red'>Please enter Equipment Name</span>",
         alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
         maxlength:"<font color='red'>Maximum 50 Characters allowed</font>"},
         
         equipment_code:{required:"<font color='red'>Please enter Equipment Code</span>",
         nospecialmin:"<font color='red'>Only Alphabets Allowed</font>",
         maxlength:"<font color='red'>Maximum 4 Character allowed.</font>"},
 
               },
      errorPlacement: function(error, element)
                     {
                        if ( element.is(":input") ) { error.appendTo( element.parent() ); }
                        else { error.insertAfter( element ); }
                     }
    }); 
});


function add_equipment()
{
    $("#view_equipment").hide();
    $("#add_equipment").show();
}
  
function delete_equipment()
{
  $("#add_equipment").hide();
  $("#view_equipment").show();
  $("#msgDiv").hide();
}
function ins_equipment()
{
    var equipment_ins   = $("#equipment_ins").val(); 
    var equipment_type_id   = $("#equipment_type_id").val(); 
    var equipment_name    = $("#equipment_name").val(); 
    var equipment_mal_name          = $("#equipment_mal_name").val(); 
    var equipment_code    = $("#equipment_code").val();
    var equipment_measurement = $("#equipment_measurement").val();
    var csrf_token            = '<?php echo $this->security->get_csrf_hash(); ?>';
      
      
  if(equipment_type_id=="")
        {
            alert("Select Equipment Type Name");
           
            return false;
            
        }
        
        if(equipment_name=="")
        {
            alert("Equipment Name Required");
            $("#equipment_name").focus();
            return false;
        }
        if(equipment_code=="")
        {
            alert("Equipment Code Required");
            $("#equipment_code").focus();
            return false;
        }
        
        
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_equipment/')?>",
          type: "POST",
          data:{equipment_ins:equipment_ins, equipment_name:equipment_name,equipment_mal_name:equipment_mal_name,equipment_code:equipment_code,equipment_measurement:equipment_measurement,equipment_type_id:equipment_type_id,'csrf_test_name': csrf_token },
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#equipment_name").val('');
              $("#equipment_mal_name").val('');
              $("#equipment_code").val('');
              $("#equipment_measurement").val('');
            }
            else{
              window.location.reload(true);
            }
          }
        });
    
}
function toggle_status(id,status)
{
  
  var csrf_token           = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_equipment/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token },
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_equipment(id,status)
{
  var csrf_token           = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_equipment/')?>",
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


function edit_equipment(id,i)
{
  $("#view_equipment").hide();
  $("#first0_"+i).hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#first3_"+i).hide();
  $("#hide0_"+i).show();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#hide3_"+i).show();
  $("#edit_equipment_btn_"+i).hide();
  $("#save_equipment_"+i).show();
  $("#cancel_equipment_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_equipment(id,i)
{
  $("#view_equipment").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#first3_"+i).show();
  $("#first0_"+i).show();//new
  $("#hide0_"+i).hide();//new
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#hide3_"+i).hide();
  $("#edit_equipment_btn_"+i).show();
  $("#save_equipment_"+i).hide();
  $("#cancel_equipment_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_equipment(id,i)
{
    
  var edit_equipment_type_id= $("#edit_equipment_type_id_"+i).val();
  var edit_equipment= $("#edit_equipment_"+i).val();
  var edit_equipment_code= $("#edit_equipment_code_"+i).val();
  var edit_equipment_measurement= $("#edit_equipment_measurement_"+i).val();
  var edit_equipment_mal= $("#edit_equipment_mal_"+i).val();
  var csrf_token           = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;


  if(edit_equipment=="")
        {
            alert("Equipment Name Required");
            $("#edit_equipment_"+i).focus();
            return false;
            
        }
          
        if(edit_equipment_code=="")
        {
            alert("Equipment Code Required");
            $("#edit_equipment_code_"+i).focus();
            return false;
        }


  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_equipment) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Equipment name.");
        document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Equipment name.</font>";
        document.getElementById("edit_equipment").value = null;
        return false;
    } 
      if (regcd.exec(edit_equipment_code) == null) 
  {
        alert("Only Alphabets Allowed in Equipment code.");
        document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Equipment code.</font>";
        document.getElementById("edit_equipment_code").value = null;
        return false;
    } 


  if(edit_equipment=="" ||  edit_equipment_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Equipment Name And Equipment Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_equipment/')?>",
          type: "POST",
          data:{ id:id,edit_equipment_type_id:edit_equipment_type_id,edit_equipment:edit_equipment,edit_equipment_mal:edit_equipment_mal,edit_equipment_code:edit_equipment_code,edit_equipment_measurement:edit_equipment_measurement,'csrf_test_name': csrf_token },
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
    <span class="badge bg-darkmagenta innertitle "> Equipment </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "equipment", "name" => "equipment" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_equipment", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_equipment", $attributes);
    }?>
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_equipment">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_equipment()"> <i class="fa fa-plus-circle"></i> &nbsp; Add New Equipment</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_equipment" style="display:none;">
             <div class="col-4">
             <input type="text" name="equipment_name" maxlength="20" id="equipment_name" class="form-control"  placeholder=" Enter Equipment Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="equipment_mal_name" maxlength="50" id="equipment_mal_name" class="form-control"   placeholder=" Enter Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="equipment_code" maxlength="4"  id="equipment_code" class="form-control"  placeholder=" Equipment Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="equipment_ins" id="equipment_ins" value="Save Equipment" class="btn btn-info btn-flat" onClick="ins_equipment()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3">
            <input type="button" name="equipment_del" id="equipment_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_equipment()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Equipment Type Name</th>
                   <th id="col_name">Equipment Name</th>
                  <th id="col_name1">Equipment Name(Malayalam)</th>
                  <th id="col_name2">Code</th>
      <th>Measurment</th>
                  <th>Status</th>
                  <th id="th_div"></th>
                  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                 <?php
    //print_r($data);
                    $i=1;
                    foreach($equipment as $rowmodule){
                    $type_id = $rowmodule['equipment_type_id'];
        $msmnt_id= $rowmodule['equipment_measurement'];
                    $id = $rowmodule['equipment_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div0_<?php echo $i; ?>">
                  <div id="first0_<?php echo $i;?>" class="col-md-12">
                    <div class="form-group">
                  <?php echo $rowmodule['equipment_type_name'];  ?>
    
                  </div>
                    </div>
                    
                  <div id="hide0_<?php echo $i;?>"  class="col-md-12" style="display:none">
                        
                 <select name="edit_equipment_type_id_<?php echo $i;?>"  id="edit_equipment_type_id_<?php  echo $i;?>"   class="form-control select2 div100">
                <?php foreach($equipment_type as $equipmenttype_id){ ?>
                <option value="<?php echo $equipmenttype_id['equipment_type_sl']; ?>" id="<?php echo $equipmenttype_id['equipment_type_sl']; ?>" <?php if($equipmenttype_id['equipment_type_sl']==$type_id) { echo "selected"; } ?>><?php echo $equipmenttype_id['equipment_type_name']; ?></option>
                
                <?php }  ?>
                 </select> 
                        
                   
                 </div>
                </td>              
                
               <!-- <td><?php //echo $rowmodule['vesselcategory_name'];  ?></td> -->
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" class="col-md-12"><?php echo strtoupper($rowmodule['equipment_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  class="div40" style="display:none"><input maxlength="20" type="text" class="div40" name="edit_equipment_<?php echo $i;?>"  id="edit_equipment_<?php  echo $i;?>" value="<?php echo $rowmodule['equipment_name'];?>" onchange="check_dup_equipment_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
               
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['equipment_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" type="text" class="div40" name="edit_equipment_mal_<?php echo $i;?>"  id="edit_equipment_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['equipment_mal_name'];?>" onchange="check_dup_equipment_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['equipment_code'];?></div>
                
                 <div id="hide2_<?php echo $i;?>" style="display:none" >
                     
                     <input maxlength="4" type="text" class="div40" name="edit_equipment_code<?php echo $i;?>"  id="edit_equipment_code_<?php  echo $i;?>" value="<?php echo $rowmodule['equipment_code'];?>" onchange="check_dup_equipment_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
              
                </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>

    




                
                <td id="col_div3_<?php echo $i; ?>">
                  <div id="first3_<?php echo $i;?>" class="col-md-12">
                    <div class="form-group">
                  <?php echo $rowmodule['measurement_name'];  ?>

                  </div>
                    </div>
                    
                    <div id="hide3_<?php echo $i;?>"  class="col-md-12" style="display:none">
                        
                 <select name="edit_equipment_measurement_<?php echo $i;?>"  id="edit_equipment_measurement_<?php  echo $i;?>"   class="form-control select2 div100">
                <?php foreach($equipment_measurement as $measurement){ ?>
                <option value="<?php echo $measurement['measurement_sl']; ?>" id="<?php echo $measurement['measurement_sl']; ?>" <?php if($measurement['measurement_sl']==$msmnt_id) { echo "selected"; } ?>><?php echo $measurement['measurement_name']; ?></option>
                
                <?php }  ?>
                 </select> 
                        
                   
                 </div>
                </td>  
            


                 <td>
                  <?php  if($rowmodule['equipment_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['equipment_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>  </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['equipment_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_equipment_btn_<?php echo $i;?>" id="edit_equipment_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_equipment(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>             
                        </div>
                   <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_equipment_<?php echo $i;?>" id="save_equipment_<?php echo $i;?>" onclick="save_equipment(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-danger btn-flat" type="button" name="cancel_equipment_<?php echo $i;?>" id="cancel_equipment_<?php echo $i;?>" onclick="cancel_equipment(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                 <!-- <span class="glyphicon glyphicon-pencil">Edit</span>-->
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Equipment?')){ del_equipment(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Equipment?')){ del_equipment(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>
            <?php
          }
          ?>
                  <!--<span class="badge bg-blue">Delete</span>--></td>
                 
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