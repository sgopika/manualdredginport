<script type="text/javascript" language="javascript">
$(document).ready(function() {
      
  $('#registration_item_list').validate({
    rules:
    { 
      registration_item_eng:{required:true },
      registration_item_mal:{required:true },
      location:{required:true },
    },
    messages:
    {
      registration_item_eng:{required:"<font color='red'>Please Enter Registration Item!</span>"},
      registration_item_mal:{required:"<font color='red'>Please Enter Registration Item in Malayalam!</span>"},
      location:{required:"<font color='red'>Please Select Location!</span>"},
 
    },
    errorPlacement: function(error, element)
    {
      if ( element.is(":input") ) { error.appendTo( element.parent() ); }
      else { error.insertAfter( element ); }
    }

  });

});

function check_order(val){
  if(val>5){
    alert("The order limit must be between 1 and 5!!!");
    $("#registration_item_order").val('');
    $("#registration_item_order").focus();
    return false;
  }
}

function add_registration_item()
{
  $("#view_registration_item").hide();
  $("#edit_registration_item").hide();
  $("#add_registration_item").show();
}
  
function delete_registration_item()
{
  $("#add_registration_item").hide();
  $("#edit_registration_item").hide();
  $("#view_registration_item").show();
  $("#msgDiv").hide();
}

$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});

function ins_registration_item()
{ 
  var registration_item_eng     = $("#registration_item_eng").val(); 
  var registration_item_mal     = $("#registration_item_mal").val();
  var registration_item_icon    = $("#registration_item_icon").val(); 
  var registration_item_link    = $("#registration_item_link").val();
  var registration_item_order   = $("#registration_item_order").val(); 
      
  if(registration_item_eng=="")
  {
    alert("Registration Item in English Required");
    $("#registration_item_eng").focus();
    return false;
            
  }
  if(registration_item_mal=="")
  {
    alert("Registration Item in Malayalam Required");
    $("#registration_item_mal").focus();
    return false;
  }

  if(registration_item_link=="")
  {
    alert("Registration Item Link Required");
    $("#registration_item_mal").focus();
    return false;
  }
  
    //alert(registration_item_eng);    
  $.ajax({
    url : "<?php echo site_url('Super_Ctrl/Super/add_registration_item')?>",
    type: "POST",
    data:{registration_item_eng:registration_item_eng, registration_item_mal:registration_item_mal, registration_item_icon:registration_item_icon, registration_item_link:registration_item_link, registration_item_order:registration_item_order},
    dataType: "JSON",
    success: function(data)
    { //alert(data);exit;
      if(data['val_errors']!=""){
        //$("#msgDiv").show();
        var html ="";
        if(data['status']=="true")
        {
          var btn = "btn-success";
        }
        else
        {
          var btn = "btn-danger";
        }

        html ='<div id="msgDiv" class="alert '+btn+' alert-dismissible" >'+data['val_errors']+'</div>'
        //document.getElementById('msgDiv').innerHTML=""+data['val_errors']+"";
        //$("#example1").ajax.reload();

        $("#resp_msg").html(html);
        $("#registration_item_eng").val('');
        $("#registration_item_mal").val('');
        $("#registration_item_icon").val('');/*67255395400*/
        $("#registration_item_link").val('');
        $("#registration_item_order").val('');
       
      }
      else{
        window.location.reload(true);
      }
    }
  });
    
}



function toggle_status(id,loc,status)
{ 
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/status_registration_item/')?>",
        type: "POST",
        data:{ id:id,stat:status,loc:loc},
        dataType: "JSON",
        success: function(data)
        {// alert(data['val_errors']);exit;
          window.location.reload(true);


        }
      });
}

function del_registration_item(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/delete_registration_item/')?>",
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
function edit_registration_item(id){ //alert(id);
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/edit_registration_item')?>",
        type: "POST",
        data:{ id:id},
        //dataType: "JSON",
        success: function(data)
        {
          //alert(data);
          $("#edit_registration_item").show();
          $("#add_registration_item").hide();
          $("#edit_registration_item").html(data);

          window.location.hash="#edit_registration_item";
          
        }
  });

}

/*function edit_title(id,i)
{
  $("#view_title").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_title_btn_"+i).hide();
  $("#save_title_"+i).show();
  $("#cancel_title_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} */
  
function cancel_registration_item(id,i)
{
  $("#view_registration_item").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_registration_item_btn_"+i).show();
  $("#save_registration_item_"+i).hide();
  $("#cancel_registration_item_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}

function save_registration_item(id)
{ alert(id);exit;
  var edit_registration_item_eng     = $("#edit_registration_item_eng").val(); 
  var edit_registration_item_mal     = $("#edit_registration_item_mal").val(); 
  var edit_tagline_eng   = $("#edit_tagline_eng").val(); 
  var edit_tagline_mal   = $("#edit_tagline_mal").val();
  var edit_location      = $("#edit_location").val();
  
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  

  if(edit_registration_item_eng=="")
  {
      alert("Registration Item in English Required");
      $("#edit_registration_item_eng").focus();
      return false;
      
  }
        
  if(edit_registration_item_mal=="")
  {
      alert("Registration Item in Malayalam Required");
      $("#edit_registration_item_mal").focus();
      return false;
  } 

  if(edit_tagline_eng=="")
  {
      alert("Tagline in English Required");
      $("#edit_tagline_eng").focus();
      return false;
      
  }
        
  if(edit_tagline_mal=="")
  {
      alert("Tagline in Malayalam Required");
      $("#edit_tagline_mal").focus();
      return false;
  }

  if(edit_location=="")
  {
      alert("Location Required");
      $("#edit_location").focus();
      return false;
  }

  var regex = new RegExp("^[a-zA-Z\ \.\_\-]+$");
  var regcd = new RegExp("^[a-zA-Z]+$");
  if (regex.exec(edit_registration_item_eng) == null) 
  {
    alert("Only alphabets and characters like .-_ are allowed in English Registration Item.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in English Registration Item.</font>";
    document.getElementById("edit_registration_item_eng").value = null;
    return false;
  } 
  if (regex.exec(edit_tagline_eng) == null) 
  {
    alert("Only Alphabets and characters like .-_ are Allowed in English tagline.");
    document.getElementById("valid_err_msg_code_"+i).innerHTML ="<font color='red'>Only Alphabets and characters like .-_ are Allowed in English tagline.</font>";
    document.getElementById("edit_tagline_eng").value = null;
        return false;
  } 


  
  else{
    $.ajax({
          url : "<?php echo site_url('Super_Ctrl/Super/save_registration_item/')?>",
          type: "POST",
          data:{ id:id,edit_registration_item_eng:edit_registration_item_eng,edit_registration_item_mal:edit_registration_item_mal,edit_tagline_eng:edit_tagline_eng,edit_tagline_mal:edit_tagline_mal,location:location},
          dataType: "JSON",
          success: function(data)
          {
            if(data['val_errors']!=""){
              
              $("#msgDiv").show();
              document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
              //$("#example1").ajax.reload();

              
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
    <span class="badge bg-darkmagenta innertitle "> Registration Menu Item </span>
  </div>  <!-- end of col4 -->
  <div class="col-8">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
     <li><a href="<?php echo $site_url."/Super_Ctrl/Super/SuperHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
  </ol>
</nav>
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
<!---------------------------------------- end of breadcrumb bar -------------------------------------- ------- -->
<!---------------------------------------- start of main content area  ---------------------------------------- -->
  <div id="resp_msg" >
    <!-- <div id="msgDiv" class="alert  alert-dismissible" style="display:none"></div>  -->
  </div>
    
    <!--  ---------------------------------- To fill Form PHP Code  ----------------------------------------------- -->
    <?php 
        $attributes = array("class" => "form-horizontal", "id" => "registration_item_list", "name" => "registration_item_list" , "novalidate");
    
    
          echo form_open("Super_Ctrl/Super/save_registration_item", $attributes);
     ?>
    <!-- <form name="registration_item_list" id="registration_item_list" method="post"   action="<?php echo $site_url.'/Super_Ctrl/Super/add_registration_item'?>" > -->
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_registration_item_list">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_registration_item()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Registration Item</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    


    <div class="row py-3" id="add_registration_item" style="display:none;">

      <div class="col-6">
          <input type="text" name="registration_item_eng" maxlength="150" id="registration_item_eng" class="form-control "  placeholder=" Enter title in English" autocomplete="off"/>
      </div>
      <div class="col-6">
          <input type="text" name="registration_item_mal" maxlength="150" id="registration_item_mal" class="form-control "  placeholder=" Enter title in Malayalam" autocomplete="off"/>
      </div>

      <div class="col-1 pt-3 "><font color="#29208c">Enter Icon</font></div>
      <div class="col-3 pt-3 ">
          <input type="text" name="registration_item_icon" maxlength="150" id="registration_item_icon" class="form-control "  placeholder=" eg: fas fa-anchor" autocomplete="off"/> 
      </div>
      <div class="col-1 pt-3 "><font color="#29208c">Enter Link</font></div>
      <div class="col-4 pt-3 ">
          <input type="text" name="registration_item_link" maxlength="150" id="registration_item_link" class="form-control "  placeholder=" Controller/function_name/id-number" autocomplete="off"/> 
      </div>
      <div class="col-2 pt-3 "><font color="#29208c">Enter Menu Order</font></div>
      <div class="col-1 pt-3 ">
          <input type="text" name="registration_item_order" maxlength="1" id="registration_item_order" class="form-control "  placeholder="1-5" autocomplete="off" onchange="check_order(this.value);" /> 
      </div>

      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="button" name="registration_item_ins" id="registration_item_ins" value="Add Menu Item" class="btn btn-info btn-flat" onClick="ins_registration_item()"  />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="registration_item_del" id="registration_item_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_registration_item()"  />
      </div> <!-- end of col6 -->
    </div> <!-- end of add row -->

<div class="row py-3" id="edit_registration_item" style="display:none;">
    </div>

    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
          <thead>
            <tr>
              <th id="sl">Sl.No</th>
              <th id="col_name">Registration Item</th>
              <th id="col_name">Registration Item in Malayalam</th>
              <th id="col_name">Location</th>
              <th>Status</th>
              <th id="th_div"></th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          <?php
          //print_r($data);
          $i=1;
          foreach($registration_item_list as $rowmodule){
          $id     = $rowmodule['bodycontent_sl'];
          $loc_id = $rowmodule['bodycontent_location_sl'];
          $loc    = $this->Super_model->get_location_byid($loc_id);
          foreach($loc as $loc_res){
            $location_name = $loc_res['location_name'];
          }
          ?>
            <tr id="<?php echo $i;?>">
              <td id="sl_div_<?php echo $i; ?>"><?php  echo $i;  ?> </td>
              <td id="col_div_<?php echo $i; ?>">
                <div id="first_<?php echo $i;?>" ><?php echo $rowmodule['bodycontent_engtitle'];?></div>
               <!--  <div id="hide_<?php echo $i;?>"  style="display:none">
                  <input maxlength="20" class="div300" type="text" name="edit_title_eng_<?php echo $i;?>"  id="edit_title_eng_<?php  echo $i;?>" value="<?php echo $rowmodule['bodycontent_engtitle'];?>" onchange="check_dup_title_edit(<?php echo $i;?>);"   autocomplete="off"/>
                </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>  -->
              </td>
              <td id="col_div1_<?php echo $i; ?>">
                <div id="first1_<?php echo $i;?>" ><?php echo $rowmodule['bodycontent_maltitle'];?></div>
                <!-- <div id="hide1_<?php echo $i;?>"  style="display:none">
                  <input maxlength="20" class="div300" type="text" name="edit_title_mal_<?php echo $i;?>"  id="edit_title_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['bodycontent_maltitle'];?>" onchange="check_dup_title_edit(<?php echo $i;?>);"   autocomplete="off"/>
                </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div>  -->
              </td>
              <td id="col_div2_<?php echo $i; ?>">
                 <div id="first2_<?php echo $i;?>"><?php echo $location_name;?></div>
                 <div id="hide2_<?php echo $i;?>" style="display:none">
                  <select name="edit_location_<?php echo $i;?>" id="edit_location_<?php echo $i;?>" class="form-control js-example-basic-single" style="width: 100%;">
                    <option value="">Select Location</option> 
                    <?php foreach($location as $loc_res){ ?>
                    <option value="<?php echo $loc_res['location_sl']; ?>"<?php if($loc_res['location_sl']==$loc_id) { ?> selected="selected" <?php } ?>><?php echo $loc_res['location_name']; ?></option>
                       <?php }  ?>
                  </select>
                  </div>
                </td>
                
               
                <td>
                  <?php  if($rowmodule['bodycontent_status_sl']=='1')
                  {
                  ?>
                  <button class="btn btn-sm btn-flat btn-point btn-primary " type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $loc_id;?>,<?php echo $rowmodule['bodycontent_status_sl'];?>);"  > <i class="far fa-bell"></i>   </button> 
                  <?php
                  }
                  else{
                    ?>
                     <button class="btn btn-sm btn-flat btn-point btn-warning"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $loc_id;?>,<?php echo $rowmodule['bodycontent_status_sl'];?>);"> <i class=" fas fa-bell-slash
"></i>  </button> 
                    <?php
                  }
                  ?>
                </td>
                <td>
                  <div id="edit_div_<?php echo $i;?>">
                    <!-- <button name="edit_title_btn_<?php echo $i;?>" id="edit_title_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_title(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>  -->  
                    <button name="edit_registration_item_btn_<?php echo $i;?>" id="edit_registration_item_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_registration_item(<?php echo $id;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>          
                  </div>
                  <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_registration_item_<?php echo $i;?>" id="save_registration_item_<?php echo $i;?>" onclick="save_registration_item(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_registration_item_<?php echo $i;?>" id="cancel_registration_item_<?php echo $i;?>" onclick="cancel_registration_item(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                  </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['bodycontent_ctype']==1)
          {
          ?>
                  <button class="btn btn-sm btn-flat btn-point btn-danger " type="button" onclick="if(confirm('Are you sure to Delete Registration Item?')){ del_registration_item(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_ctype'];?>);}"> <i class="fas fa-trash-alt"></i> </button>
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


<!---------------------------------------- end of main content area  ---------------------------------------- -->