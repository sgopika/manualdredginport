<script type="text/javascript" language="javascript">
$(document).ready(function() {
      
  $('#title_list').validate({
    rules:
    { 
      title_eng:{required:true },
      title_mal:{required:true },
      location:{required:true },
    },
    messages:
    {
      title_eng:{required:"<font color='red'>Please Enter Title!</span>"},
      title_mal:{required:"<font color='red'>Please Enter Title in Malayalam!</span>"},
      location:{required:"<font color='red'>Please Select Location!</span>"},
 
    },
    errorPlacement: function(error, element)
    {
      if ( element.is(":input") ) { error.appendTo( element.parent() ); }
      else { error.insertAfter( element ); }
    }

  });

});



function add_title()
{
  $("#view_title").hide();
  $("#edit_title").hide();
  $("#add_title").show();
}
  
function delete_title()
{
  $("#add_title").hide();
  $("#edit_title").hide();
  $("#view_title").show();
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

function ins_title()
{
  var title_eng     = $("#title_eng").val(); 
  var title_mal     = $("#title_mal").val(); 
  var tagline_eng   = $("#tagline_eng").val(); 
  var tagline_mal   = $("#tagline_mal").val();
  var location      = $("#location").val();
  
      
  if(title_eng=="")
  {
    alert("Title in English Required");
    $("#title_eng").focus();
    return false;
            
  }
  if(title_mal=="")
  {
    alert("Title in Malayalam Required");
    $("#title_mal").focus();
    return false;
  }
  if(location=="")
  {
    alert("Location Required");
    $("#location").focus();
    return false;
  }
    //alert(title_eng);    
  $.ajax({
    url : "<?php echo site_url('Super_Ctrl/Super/add_title')?>",
    type: "POST",
    data:{title_eng:title_eng, title_mal:title_mal, tagline_eng:tagline_eng, tagline_mal:tagline_mal, location:location},
    dataType: "JSON",
    success: function(data)
    { //alert(data['status']);exit;
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
        $("#resp_msg").html(html);
        
        /*$('#example1').DataTable().ajax.reload();*/
        $("#title_eng").val('');
        $("#title_mal").val('');
        $("#tagline_eng").val('');
        $("#tagline_mal").val('');
        $("#location").val('');

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
        url : "<?php echo site_url('Super_Ctrl/Super/status_title/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}

function del_title(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/delete_title/')?>",
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
function edit_title(id){ //alert(id);
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/edit_title')?>",
        type: "POST",
        data:{ id:id},
        //dataType: "JSON",
        success: function(data)
        {
          //alert(data);
          $("#edit_title").show();
          $("#add_title").hide();
          $("#edit_title").html(data);
          
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
  
function cancel_title(id,i)
{
  $("#view_title").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_title_btn_"+i).show();
  $("#save_title_"+i).hide();
  $("#cancel_title_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}

function save_title(id)
{ alert(id);exit;
  var edit_title_eng     = $("#edit_title_eng").val(); 
  var edit_title_mal     = $("#edit_title_mal").val(); 
  var edit_tagline_eng   = $("#edit_tagline_eng").val(); 
  var edit_tagline_mal   = $("#edit_tagline_mal").val();
  var edit_location      = $("#edit_location").val();
  
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  

  if(edit_title_eng=="")
  {
      alert("Title in English Required");
      $("#edit_title_eng").focus();
      return false;
      
  }
        
  if(edit_title_mal=="")
  {
      alert("Title in Malayalam Required");
      $("#edit_title_mal").focus();
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
  if (regex.exec(edit_title_eng) == null) 
  {
    alert("Only alphabets and characters like .-_ are allowed in English title.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in English title.</font>";
    document.getElementById("edit_title_eng").value = null;
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
          url : "<?php echo site_url('Super_Ctrl/Super/save_title/')?>",
          type: "POST",
          data:{ id:id,edit_title_eng:edit_title_eng,edit_title_mal:edit_title_mal,edit_tagline_eng:edit_tagline_eng,edit_tagline_mal:edit_tagline_mal,location:location},
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
    <span class="badge bg-darkmagenta innertitle "> Title </span>
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
  <div id="resp_msg">
    <!-- <div id="msgDiv" class="alert  alert-dismissible" style="display:none"></div> --> 
  </div>
    
    <!--  ---------------------------------- To fill Form PHP Code  ----------------------------------------------- -->
    <?php 
        $attributes = array("class" => "form-horizontal", "id" => "title_list", "name" => "title_list" , "novalidate");
    
    
          echo form_open("Super_Ctrl/Super/save_title", $attributes);
     ?>
    <!-- <form name="title_list" id="title_list" method="post"   action="<?php echo $site_url.'/Super_Ctrl/Super/add_title'?>" > -->
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_title_list">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_title()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Title</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    


    <div class="row py-3" id="add_title" style="display:none;">
      <div class="col-2">
          <input type="text" name="title_eng" maxlength="100" id="title_eng" class="form-control "  placeholder=" Enter Title in English" autocomplete="off"/>
      </div>
      <div class="col-2">
          <input type="text" name="title_mal" maxlength="100" id="title_mal" class="form-control "  placeholder=" Enter Title in Malayalam" autocomplete="off"/>
      </div>
      <div class="col-3">
          <textarea name="tagline_eng" id="tagline_eng" placeholder=" Enter Tagline in English"></textarea><!-- <input type="text" name="tagline_eng" maxlength="150" id="tagline_eng" class="form-control "  placeholder=" Enter Tagline in English" autocomplete="off"/> -->
      </div>
      <div class="col-3">
          <textarea name="tagline_mal" id="tagline_mal" placeholder=" Enter Tagline in Malayalam"></textarea><!-- <input type="text" name="tagline_mal" maxlength="150" id="tagline_mal" class="form-control "  placeholder=" Enter Tagline in Malayalam" autocomplete="off"/> -->
      </div> 
      <div class="col-2">
        <select name="location" id="location" class="form-control js-example-basic-single" style="width: 100%;">
          <option value="">Select Location</option> 
          <?php foreach($location as $loc_res){ ?>
          <option value="<?php echo $loc_res['location_sl']; ?>"><?php echo $loc_res['location_name']; ?></option>
             <?php }  ?>
        </select>
      </div>  <!-- end of col4 -->
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="button" name="title_ins" id="title_ins" value="Add Title" class="btn btn-info btn-flat" onClick="ins_title()"  />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="title_del" id="title_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_title()"  />
      </div> <!-- end of col6 -->
    </div> <!-- end of add row -->

<div class="row py-3" id="edit_title" style="display:none;">
    </div>

    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
          <thead>
            <tr>
              <th id="sl">Sl.No</th>
              <th id="col_name">Title</th>
              <th id="col_name">Malayalam Title</th>
              <th id="col_name">Location</th>
              <th>Status</th>
              <th id="th_div"></th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          <?php
          //print_r($title_list);
          $i=1;
          foreach($title_list as $rowmodule){
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
                  <button class="btn btn-sm btn-flat btn-point btn-primary " type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_status_sl'];?>);"  > <i class="far fa-bell"></i>   </button> 
                  <?php
                  }
                  else{
                    ?>
                     <button class="btn btn-sm btn-flat btn-point btn-warning"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_status_sl'];?>);"> <i class=" fas fa-bell-slash
"></i>  </button> 
                    <?php
                  }
                  ?>
                </td>
                <td>
                  <div id="edit_div_<?php echo $i;?>">
                    <!-- <button name="edit_title_btn_<?php echo $i;?>" id="edit_title_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_title(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>  -->  
                    <button name="edit_title_btn_<?php echo $i;?>" id="edit_title_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_title(<?php echo $id;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>          
                  </div>
                  <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_title_<?php echo $i;?>" id="save_title_<?php echo $i;?>" onclick="save_title(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_title_<?php echo $i;?>" id="cancel_title_<?php echo $i;?>" onclick="cancel_title(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                  </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['bodycontent_ctype']==1)
          {
          ?>
                  <button class="btn btn-sm btn-flat btn-point btn-danger " type="button" onclick="if(confirm('Are you sure to Delete title?')){ del_title(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_ctype'];?>);}"> <i class="fas fa-trash-alt"></i> </button>
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