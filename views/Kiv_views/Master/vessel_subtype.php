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
            
     $('#vessel_subtype').validate({
            rules:
                     { 
                  vessel_subtype_name:{
                  required:true,
                  alphaonly:true,
                  maxlength:20, },


                  vessel_subtype_code:{
                  required:true,
                  alphaonly:true,
                  maxlength:4, },
                            },
            messages:
                     {
                 vessel_subtype_name:{
                 required:"<font color='red'>Please enter Vessel type Name</span>",
                 alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
                 maxlength:"<font color='red'>Maximum 20 Characters allowed</font>"
                         },
                 
                 vessel_subtype_code:{
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
function add_vessel_subtype()
{
    $("#view_vessel_subtype").hide();
    $("#add_vessel_subtype").show();
}
    
function delete_vessel_subtype()
{
    $("#add_vessel_subtype").hide();
    $("#view_vessel_subtype").show();
    $("#msgDiv").hide();
}
function ins_vessel_subtype()
{
        var vessel_subtype_ins          = $("#vessel_subtype_ins").val(); 
                var vessel_subtype_vesseltype_id    = $("#vessel_subtype_vesseltype_id").val(); 
        var vessel_subtype_name             = $("#vessel_subtype_name").val(); 
        var vessel_subtype_mal_name         = $("#vessel_subtype_mal_name").val(); 
        var vessel_subtype_code         = $("#vessel_subtype_code").val();
            
            
    if(vessel_subtype_vesseltype_id=="")
        {
            alert("Select Type Name");
           
            return false;
            
        }
        
        if(vessel_subtype_name=="")
        {
            alert("Vessel Sub Type Name Required");
            $("#vessel_subtype_name").focus();
            return false;
        }
        if(vessel_subtype_code=="")
        {
            alert("Vessel Sub Type Code Required");
            $("#vessel_subtype_code").focus();
            return false;
        }
        
        
        
                $.ajax({
                    url : "<?php echo site_url('Kiv_Ctrl/Master/add_vessel_subtype/')?>",
                    type: "POST",
                    data:{vessel_subtype_ins:vessel_subtype_ins, vessel_subtype_name:vessel_subtype_name,vessel_subtype_mal_name:vessel_subtype_mal_name,vessel_subtype_code:vessel_subtype_code,vessel_subtype_vesseltype_id:vessel_subtype_vesseltype_id},
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data['val_errors']!=""){
                            $("#msgDiv").show();
                            document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
                            $("#vessel_subtype_name").val('');
                            $("#vessel_subtype_mal_name").val('');
                            $("#vessel_subtype_code").val('');
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
                url : "<?php echo site_url('Kiv_Ctrl/Master/status_vessel_subtype/')?>",
                type: "POST",
                data:{ id:id,stat:status},
                dataType: "JSON",
                success: function(data)
                {
                    window.location.reload(true);
                }
            });
}
    function del_vessel_subtype(id,status)
{
    $.ajax({
                url : "<?php echo site_url('Kiv_Ctrl/Master/delete_vessel_subtype/')?>",
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


function edit_vessel_subtype(id,i)
{
    $("#view_vessel_subtype").hide();
        $("#first0_"+i).hide();
    $("#first_"+i).hide();
    $("#first1_"+i).hide();
    $("#first2_"+i).hide();
        $("#hide0_"+i).show();
    $("#hide_"+i).show();
    $("#hide1_"+i).show();
    $("#hide2_"+i).show();
    $("#edit_vessel_subtype_btn_"+i).hide();
    $("#save_vessel_subtype_"+i).show();
    $("#cancel_vessel_subtype_"+i).show();
    $("#edit_div_"+i).hide();
    $("#save_div_"+i).show();
}   
    
function cancel_vessel_subtype(id,i)
{
    $("#view_vessel_subtype").show();
    $("#first_"+i).show();
    $("#first1_"+i).show();
    $("#first2_"+i).show();
        $("#first0_"+i).show();//new
    $("#hide0_"+i).hide();//new
    $("#hide_"+i).hide();
    $("#hide1_"+i).hide();
    $("#hide2_"+i).hide();
    $("#edit_vessel_subtype_btn_"+i).show();
    $("#save_vessel_subtype_"+i).hide();
    $("#cancel_vessel_subtype_"+i).hide();
    $("#edit_div_"+i).show();
    $("#save_div_"+i).hide();
    $("#valid_err_msg_name_"+i).hide();
    $("#valid_err_msg_code_"+i).hide();
}
    
function save_vessel_subtype(id,i)
{
    
        var edit_vessel_subtype_vesseltype_id= $("#edit_vessel_subtype_vesseltype_id_"+i).val();
        var edit_vessel_subtype= $("#edit_vessel_subtype_"+i).val();
    var edit_vessel_subtype_code= $("#edit_vessel_subtype_code_"+i).val();
    var edit_vessel_subtype_mal= $("#edit_vessel_subtype_mal_"+i).val();
    var re = /^[ A-Za-z0-9]*$/;


    if(edit_vessel_subtype_vesseltype_id=="")
        {
            alert("Select Vessel Type");
            $("#edit_nozzletype_"+i).focus();
            return false;
            
        }


    if(edit_vessel_subtype=="")
        {
            alert("Vessel Sub Type Name Required");
            $("#edit_vessel_subtype_"+i).focus();
            return false;
            
        }
            
        if(edit_vessel_subtype_code=="")
        {
            alert("Vessel Sub Type Code Required");
            $("#edit_vessel_subtype_code_"+i).focus();
            return false;
        }
    var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
    var regcd = new RegExp("^[a-zA-Z]+$");

    
    if (regex.exec(edit_vessel_subtype) == null) 
    {
            alert("Only alphabets and characters like .-_ are allowed in Vessel sub type Name.");
        document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Vessel sub type Name.</font>";
            document.getElementById("edit_vessel_subtype").value = null;
            return false;
    } 
        if (regcd.exec(edit_vessel_subtype_code) == null) 
    {
            alert("Only Alphabets Allowed in Vessel sub type Code.");
        document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Vessel sub type Code.</font>";
            document.getElementById("edit_vessel_subtype_code").value = null;
            return false;
    } 



    if(edit_vessel_subtype=="" ||  edit_vessel_subtype_code==""){
            $("#msgDiv").show();
            document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter vessel sub type And Vessel sub type Code</font>";
    }

    else{
        $.ajax({
                    url : "<?php echo site_url('Kiv_Ctrl/Master/edit_vessel_subtype/')?>",
                    type: "POST",
                    data:{ id:id,edit_vessel_subtype_vesseltype_id:edit_vessel_subtype_vesseltype_id,edit_vessel_subtype:edit_vessel_subtype,edit_vessel_subtype_mal:edit_vessel_subtype_mal,edit_vessel_subtype_code:edit_vessel_subtype_code},
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
        <span class="badge bg-darkmagenta innertitle ">Vessel Sub Type</span>
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
        $attributes = array("class" => "form-horizontal", "id" => "vessel_subtype", "name" => "vessel_subtype" , "novalidate");
        
        if(isset($editres)){
            echo form_open("Kiv_Ctrl/Master/add_vessel_subtype", $attributes);
        } else {
            echo form_open("Kiv_Ctrl/Master/add_vessel_subtype", $attributes);
        }?>
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_vessel_subtype">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_vessel_subtype()"> <i class="fa fa-plus-circle"></i> &nbsp; Add New Vessel Sub Type</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_vessel_subtype" style="display:none;">
             <div class="col-3">
             <select name="vessel_subtype_vesseltype_id" id="vessel_subtype_vesseltype_id" class="form-control select2 ">
                     <option value="">Select</option> 
                      <?php foreach($vessel_type as $vesseltype_id){ ?>
                <option value="<?php echo $vesseltype_id['vesseltype_sl']; ?>" id="<?php echo $vesseltype_id['vesseltype_sl']; ?>"><?php echo $vesseltype_id['vesseltype_name']; ?></option>
                <?php }  ?>
                 </select> 
             </div> <!-- end of col3 -->
              <div class="col-3">
            <input type="text" name="vessel_subtype_name" maxlength="20" id="vessel_subtype_name" class="form-control"  placeholder=" Enter Vessel Sub Type Name" autocomplete="off"/>
             </div>  <!-- end of col3 -->
              <div class="col-3">
            <input type="text" name="vessel_subtype_mal_name" maxlength="50" id="vessel_subtype_mal_name" class="form-control"   placeholder=" Enter Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col3 -->
             <div class="col-3">
            <input type="text" name="vessel_subtype_code" maxlength="4" id="vessel_subtype_code" class="form-control"  placeholder=" Vessel Sub Type Code" autocomplete="off"/>
             </div>  <!-- end of col3 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="vessel_subtype_ins" id="vessel_subtype_ins" value="Save Vessel Sub Type" class="btn btn-info btn-flat" onClick="ins_vessel_subtype()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="vessel_subtype_del" id="vessel_subtype_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_vessel_subtype()"  />
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
                   <th id="col_name">Vessel Sub Type Name</th>
                  <th id="col_name1">Vessel Sub Type Name(Malayalam)</th>
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
                    foreach($vessel_subtype as $rowmodule){
                    $subtype_vesseltype_id = $rowmodule['vessel_subtype_vesseltype_id'];
                    $id = $rowmodule['vessel_subtype_sl'];
                    ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div0_<?php echo $i; ?>">
                  <div id="first0_<?php echo $i;?>" class="col-md-3">
                    <div class="form-group">
                  <?php echo $rowmodule['vesseltype_name'];  ?>

                  </div>
                    </div>
                    
                    <div id="hide0_<?php echo $i;?>"  class="col-md-3" style="display:none">
                        
                 <select name="edit_vessel_subtype_vesseltype_id_<?php echo $i;?>"  id="edit_vessel_subtype_vesseltype_id_<?php  echo $i;?>"   class="form-control select2 div200">
                <?php foreach($vessel_type as $vesseltype_id){ ?>
                <option value="<?php echo $vesseltype_id['vesseltype_sl']; ?>" id="<?php echo $vesseltype_id['vesseltype_sl']; ?>" <?php if($vesseltype_id['vesseltype_sl']==$subtype_vesseltype_id) { echo "selected"; } ?>><?php echo $vesseltype_id['vesseltype_name']; ?></option>
                
                <?php }  ?>
                 </select> 
                        
                   
                 </div>
                </td>
                
                
               <!-- <td><?php //echo $rowmodule['vesselcategory_name'];  ?></td> -->
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" class="col-md-3"><?php echo strtoupper($rowmodule['vessel_subtype_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  class="col-md-3" style="display:none"><input maxlength="20" type="text" class="div300" name="edit_vessel_subtype_<?php echo $i;?>"  id="edit_vessel_subtype_<?php  echo $i;?>" value="<?php echo $rowmodule['vessel_subtype_name'];?>" onchange="check_dup_vessel_subtype_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
               
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['vessel_subtype_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" type="text" class="div300" name="edit_vessel_subtype_mal_<?php echo $i;?>"  id="edit_vessel_subtype_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['vessel_subtype_mal_name'];?>" onchange="check_dup_vessel_subtype_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['vessel_subtype_code'];?></div>
                
                 <div id="hide2_<?php echo $i;?>" style="display:none" >
                     
                     <input type="text" class="div80" maxlength="4" name="edit_vessel_subtype_code<?php echo $i;?>"  id="edit_vessel_subtype_code_<?php  echo $i;?>" value="<?php echo $rowmodule['vessel_subtype_code'];?>" onchange="check_dup_vessel_subtype_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
              
                </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                    <?php  if($rowmodule['vessel_subtype_status']=='1')
                    {
                    ?>
                    <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['vessel_subtype_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>  </button> 
                    <?php
                    }
                    else{
                        ?>
                         <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['vessel_subtype_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
                        <?php
                    }
                    ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_vessel_subtype_btn_<?php echo $i;?>" id="edit_vessel_subtype_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_vessel_subtype(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>                      
                        </div>
                   <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_vessel_subtype_<?php echo $i;?>" id="save_vessel_subtype_<?php echo $i;?>" onclick="save_vessel_subtype(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-danger btn-flat" type="button" name="cancel_vessel_subtype_<?php echo $i;?>" id="cancel_vessel_subtype_<?php echo $i;?>" onclick="cancel_vessel_subtype(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                 <!-- <span class="glyphicon glyphicon-pencil">Edit</span>-->
                  </td>
                  <td>
                  <?php
                    if($rowmodule['delete_status']==1)
                    {
                    ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Vessel Sub Type?')){ del_vessel_subtype(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>
                  <?php
                    }
                    else{
                        ?>
                         <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Vessel Sub Type?')){ del_vessel_subtype(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>
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