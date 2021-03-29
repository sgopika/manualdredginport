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
      
   $('#sound_signal').validate({
      rules:
               { 
          sound_signal_name:{required:true,
          alphaonly:true,
          maxlength:30, },

          sound_signal_code:{required:true,
          alphaonly:true,
          maxlength:4, },
                     },
      messages:
               {
             sound_signal_name:{required:"<font color='red'>Please enter Sound Signal Name</span>",
             alphaonly:"<font color='red'>Only alphabets and characters like .-_ are allowed.</font>",
             maxlength:"<font color='red'>Maximum 30 Characters allowed</font>"},
             
             sound_signal_code:{required:"<font color='red'>Please enter Sound Signal Code</span>",
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

function add_sound_signal()
{
    $("#view_sound_signal").hide();
  $("#add_sound_signal").show();
}
  
function delete_sound_signal()
{
  $("#add_sound_signal").hide();
  $("#view_sound_signal").show();
  $("#msgDiv").hide();
}
function ins_sound_signal()
{
    var sound_signal_ins    = $("#sound_signal_ins").val(); 
    var sound_signal_name   = $("#sound_signal_name").val(); 
    var sound_signal_mal_name = $("#sound_signal_mal_name").val(); 
    var sound_signal_code   = $("#sound_signal_code").val();
    var csrf_token        = '<?php echo $this->security->get_csrf_hash(); ?>';
      
  if(sound_signal_name=="")
        {
            alert("Sound Signal Name Required");
            $("#sound_signal_name_"+i).focus();
            return false;
            
        }
        
        if(sound_signal_code=="")
        {
            alert("Sound Signal Code Required");
            $("#sound_signal_code_"+i).focus();
            return false;
        }
        
        $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/add_sound_signal/')?>",
          type: "POST",
          data:{sound_signal_ins:sound_signal_ins, sound_signal_name:sound_signal_name,sound_signal_mal_name:sound_signal_mal_name,sound_signal_code:sound_signal_code},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              $("#sound_signal_name").val('');
              $("#sound_signal_mal_name").val('');
              $("#sound_signal_code").val('');
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
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_sound_signal/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_sound_signal(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_sound_signal/')?>",
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


function edit_sound_signal(id,i)
{
  $("#view_sound_signal").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_sound_signal_btn_"+i).hide();
  $("#save_sound_signal_"+i).show();
  $("#cancel_sound_signal_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_sound_signal(id,i)
{
  $("#view_sound_signal").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_sound_signal_btn_"+i).show();
  $("#save_sound_signal_"+i).hide();
  $("#cancel_sound_signal_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_sound_signal(id,i)
{
  var edit_sound_signal= $("#edit_sound_signal_"+i).val();
  var edit_sound_signal_code= $("#edit_sound_signal_code_"+i).val();
  var edit_sound_signal_mal= $("#edit_sound_signal_mal_"+i).val();
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  

  if(edit_sound_signal=="")
        {
            alert("Sound Signal Name Required");
            $("#edit_sound_signal").focus();
            return false;
            
        }
        
        if(edit_sound_signal_code=="")
        {
            alert("Sound Signal Code Required");
            $("#edit_sound_signal_code").focus();
            return false;
        }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
    if (regex.exec(edit_sound_signal) == null) 
  {
        alert("Only alphabets and characters like .-_ are allowed in Sound Signal Name.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in Sound Signal Name.</font>";
        document.getElementById("edit_sound_signal").value = null;
        return false;
    } 
      if (regcd.exec(edit_sound_signal_code) == null) 
  {
        alert("Only Alphabets Allowed in Sound Signal Code.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets Allowed in Sound Signal Code.</font>";
        document.getElementById("edit_sound_signal_code").value = null;
        return false;
    } 

  if(edit_sound_signal=="" ||  edit_sound_signal_code==""){
      $("#msgDiv").show();
      document.getElementById('msgDiv').innerHTML="<font color='#fff'>Please Enter Sound Signal Name And Sound Signal Code</font>";
  }

  else{
    $.ajax({
          url : "<?php echo site_url('Kiv_Ctrl/Master/edit_sound_signal/')?>",
          type: "POST",
          data:{ id:id,edit_sound_signal:edit_sound_signal,edit_sound_signal_mal:edit_sound_signal_mal,edit_sound_signal_code:edit_sound_signal_code},
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
    <span class="badge bg-darkmagenta innertitle "> Sound Signal </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "sound_signal", "name" => "sound_signal" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/add_sound_signal", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/add_sound_signal", $attributes);
    }?>
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_sound_signal">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_sound_signal()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Sound Signal</button>
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_sound_signal" style="display:none;">
             <div class="col-4">
             <input type="text" name="sound_signal_name" maxlength="30" id="sound_signal_name" class="form-control "  placeholder=" Enter Sound Signal Name" autocomplete="off"/>
             </div> <!-- end of col34 -->
              <div class="col-4">
            <input type="text" name="sound_signal_mal_name" maxlength="50" id="sound_signal_mal_name" class="form-control"   placeholder=" Enter Sound Signal Malayalam Name" autocomplete="off"/>
             </div>  <!-- end of col4 -->
              <div class="col-4">
            <input type="text" name="sound_signal_code" maxlength="4" id="sound_signal_code" class="form-control"  placeholder=" Enter sound_signal Code" autocomplete="off"/>
             </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="sound_signal_ins" id="sound_signal_ins" value="Save Sound Signal" class="btn btn-info btn-flat" onClick="ins_sound_signal()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="sound_signal_del" id="sound_signal_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_sound_signal()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Sound Signal Name</th>
                  <th id="col_name1">Sound Signal Name(Malayalam)</th>
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
        foreach($sound_signal as $rowmodule){
        $id = $rowmodule['sound_signal_sl'];
          ?>
                <tr id="<?php echo $i;?>">
                <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
                
                <td id="col_div_<?php echo $i; ?>">
                    <div id="first_<?php echo $i;?>" ><?php echo strtoupper($rowmodule['sound_signal_name']);?></div>
                    <div id="hide_<?php echo $i;?>"  style="display:none"><input maxlength="30" class="div300" type="text" name="edit_sound_signal_<?php echo $i;?>"  id="edit_sound_signal_<?php  echo $i;?>" value="<?php echo $rowmodule['sound_signal_name'];?>" onchange="check_dup_sound_signal_edit(<?php echo $i;?>);"   autocomplete="off"/>
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $rowmodule['sound_signal_mal_name'];?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none"><input maxlength="50" class="div300"  type="text" name="edit_sound_signal_mal_<?php echo $i;?>"  id="edit_sound_signal_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['sound_signal_mal_name'];?>" onchange="check_dup_sound_signal_mal_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div>
                </td>
                
                <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $rowmodule['sound_signal_code'];?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none"><input maxlength="4" class="div80" type="text" name="edit_sound_signal_code<?php echo $i;?>"  id="edit_sound_signal_code_<?php  echo $i;?>" value="<?php echo $rowmodule['sound_signal_code'];?>" onchange="check_dup_sound_signal_code_edit(<?php echo $i;?>);"    autocomplete="off"/>
                 </div><div id="valid_err_msg_code_<?php echo $i; ?>"></div>
                </td>
                 <td>
                  <?php  if($rowmodule['sound_signal_status']=='1')
          {
          ?>
          <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['sound_signal_status'];?>);"  > <i class="fa fa-fw  fa-check"></i>   </button> 
          <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['sound_signal_status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php
          }
          ?>
                 </td>
                  <td>
                   <div id="edit_div_<?php echo $i;?>">
                        <button name="edit_sound_signal_btn_<?php echo $i;?>" id="edit_sound_signal_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" onclick="edit_sound_signal(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt"></i> &nbsp; Edit </button>            
                        </div>
                      <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_sound_signal_<?php echo $i;?>" id="save_sound_signal_<?php echo $i;?>" onclick="save_sound_signal(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_sound_signal_<?php echo $i;?>" id="cancel_sound_signal_<?php echo $i;?>" onclick="cancel_sound_signal(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                        </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['delete_status']==1)
          {
          ?>
                  <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Sound Signal?')){ del_sound_signal(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
                  <?php
          }
          else{
            ?>
             <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Sound Signal?')){ del_sound_signal(<?php echo $id;?>,<?php echo $rowmodule['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> </button>
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