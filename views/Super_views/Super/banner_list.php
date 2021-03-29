<script type="text/javascript" language="javascript">
$(document).ready(function() {
      
  $('#banner_list').validate({
    rules:
    { 
      banner_eng:{required:true },
      banner_mal:{required:true },
      location:{required:true },
    },
    messages:
    {
      banner_eng:{required:"<font color='red'>Please Enter banner!</span>"},
      banner_mal:{required:"<font color='red'>Please Enter banner in Malayalam!</span>"},
      location:{required:"<font color='red'>Please Select Location!</span>"},
 
    },
    errorPlacement: function(error, element)
    {
      if ( element.is(":input") ) { error.appendTo( element.parent() ); }
      else { error.insertAfter( element ); }
    }

  });

});



function add_banner()
{
  $("#view_banner").hide();
  $("#edit_banner").hide();
  $("#add_banner").show();
}
  
function delete_banner()
{
  $("#add_banner").hide();
  $("#edit_banner").hide();
  $("#view_banner").show();
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

function ins_banner()
{ 
  var banner_eng     = $("#banner_eng").val(); 
  var banner_mal     = $("#banner_mal").val(); 
  var banner_link    = $("#banner_link").val(); 
  var button_class   = $("#button_class").val();
  var banner_icon    = $("#banner_icon").val();
  var banner_order   = $("#banner_order").val();
  var location       = $("#location").val();
  
      
  if(banner_eng=="")
  {
    alert("Banner in English Required");
    $("#banner_eng").focus();
    return false;
            
  }
  if(banner_mal=="")
  {
    alert("Banner in Malayalam Required");
    $("#banner_mal").focus();
    return false;
  }
  if(location=="")
  {
    alert("Location Required");
    $("#location").focus();
    return false;
  }
    //alert(banner_eng);    
  $.ajax({
    url : "<?php echo site_url('Super_Ctrl/Super/add_banner')?>",
    type: "POST",
    data:{banner_eng:banner_eng, banner_mal:banner_mal, banner_link:banner_link, button_class:button_class, banner_icon:banner_icon, banner_order:banner_order, location:location},
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
        $("#resp_msg").html(html);

        $("#banner_eng").val('');
        $("#banner_mal").val('');
        $("#banner_link").val('');
        $("#button_class").val('');
        $("#banner_icon").val('');
        $("#banner_order").val('');
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
        url : "<?php echo site_url('Super_Ctrl/Super/status_banner/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}

function del_banner(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/delete_banner/')?>",
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
function edit_banner(id){ //alert(id);
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/edit_banner')?>",
        type: "POST",
        data:{ id:id},
        //dataType: "JSON",
        success: function(data)
        {
          //alert(data);
          $("#edit_banner").show();
          $("#add_banner").hide();
          $("#edit_banner").html(data);
          
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
  
function cancel_banner(id,i)
{
  $("#view_banner").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_banner_btn_"+i).show();
  $("#save_banner_"+i).hide();
  $("#cancel_banner_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}

function save_banner(id)
{ alert(id);exit;
  var edit_banner_eng     = $("#edit_banner_eng").val(); 
  var edit_banner_mal     = $("#edit_banner_mal").val(); 
  var edit_tagline_eng   = $("#edit_tagline_eng").val(); 
  var edit_tagline_mal   = $("#edit_tagline_mal").val();
  var edit_location      = $("#edit_location").val();
  
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  

  if(edit_banner_eng=="")
  {
      alert("banner in English Required");
      $("#edit_banner_eng").focus();
      return false;
      
  }
        
  if(edit_banner_mal=="")
  {
      alert("banner in Malayalam Required");
      $("#edit_banner_mal").focus();
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
  if (regex.exec(edit_banner_eng) == null) 
  {
    alert("Only alphabets and characters like .-_ are allowed in English banner.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in English banner.</font>";
    document.getElementById("edit_banner_eng").value = null;
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
          url : "<?php echo site_url('Super_Ctrl/Super/save_banner/')?>",
          type: "POST",
          data:{ id:id,edit_banner_eng:edit_banner_eng,edit_banner_mal:edit_banner_mal,edit_tagline_eng:edit_tagline_eng,edit_tagline_mal:edit_tagline_mal,location:location},
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
    <span class="badge bg-darkmagenta innertitle "> Banner </span>
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
    <div id="msgDiv" class="alert  alert-dismissible" style="display:none"></div> 
  </div>
    
    <!--  ---------------------------------- To fill Form PHP Code  ----------------------------------------------- -->
    <?php 
        $attributes = array("class" => "form-horizontal", "id" => "banner_list", "name" => "banner_list" , "novalidate");
    
    
          echo form_open("Super_Ctrl/Super/save_banner", $attributes);
     ?>
    <!-- <form name="banner_list" id="banner_list" method="post"   action="<?php echo $site_url.'/Super_Ctrl/Super/add_banner'?>" > -->
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_banner_list">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_banner()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Banner</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    


    <div class="row py-3" id="add_banner" style="display:none;">

      <div class="col-6">
          <input type="text" name="banner_eng" maxlength="150" id="banner_eng" class="form-control "  placeholder=" Enter Menu name in English" autocomplete="off"/>
      </div>
      <div class="col-6">
          <input type="text" name="banner_mal" maxlength="150" id="banner_mal" class="form-control "  placeholder=" Enter Menu name in Malayalam" autocomplete="off"/>
      </div>

      <div class="col-2 pt-3 "><font color="#29208c">Enter Link</font></div>
      <div class="col-4 pt-3 ">
          <input type="text" name="banner_link" maxlength="150" id="banner_link" class="form-control "  placeholder=" Controller/function_name/id-number" autocomplete="off"/> 
      </div>
      <div class="col-2 pt-3 "><font color="#29208c">Enter Button Class</font></div>
      <div class="col-4 pt-3 ">
          <input type="text" name="button_class" maxlength="150" id="button_class" class="form-control "  placeholder=" eg: btn btn-primary btn-flat " autocomplete="off"/> 
      </div> 

      <div class="col-2 pt-3 "><font color="#29208c">Enter Icon</font></div>
      <div class="col-4 pt-3 ">
          <input type="text" name="banner_icon" maxlength="150" id="banner_icon" class="form-control "  placeholder=" eg: fas fa-anchor" autocomplete="off"/> 
      </div>
      <div class="col-2 pt-3 "><font color="#29208c">Enter Menu Order</font></div>
      <div class="col-1 pt-3 ">
          <input type="text" name="banner_order" maxlength="1" id="banner_order" class="form-control "  placeholder="1-5" autocomplete="off"/> 
      </div>      
      <div class="col-3 pt-3 ">
        <select name="location" id="location" class="form-control js-example-basic-single" style="width: 100%;">
          <option value="">Select Location</option> 
          <?php foreach($location as $loc_res){ ?>
          <option value="<?php echo $loc_res['location_sl']; ?>"><?php echo $loc_res['location_name']; ?></option>
             <?php }  ?>
        </select>
      </div>  <!-- end of col4 -->
      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="button" name="banner_ins" id="banner_ins" value="Add banner" class="btn btn-info btn-flat" onClick="ins_banner()"  />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="banner_del" id="banner_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_banner()"  />
      </div> <!-- end of col6 -->
    </div> <!-- end of add row -->

<div class="row py-3" id="edit_banner" style="display:none;">
    </div>

    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
          <thead>
            <tr>
              <th id="sl">Sl.No</th>
              <th id="col_name">Banner</th>
              <th id="col_name">Malayalam Banner</th>
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
          foreach($banner_list as $rowmodule){
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
                    <button name="edit_banner_btn_<?php echo $i;?>" id="edit_banner_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_banner(<?php echo $id;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>          
                  </div>
                  <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_banner_<?php echo $i;?>" id="save_banner_<?php echo $i;?>" onclick="save_banner(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_banner_<?php echo $i;?>" id="cancel_banner_<?php echo $i;?>" onclick="cancel_banner(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                  </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['bodycontent_ctype']==1)
          {
          ?>
                  <button class="btn btn-sm btn-flat btn-point btn-danger " type="button" onclick="if(confirm('Are you sure to Delete banner?')){ del_banner(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_ctype'];?>);}"> <i class="fas fa-trash-alt"></i> </button>
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
</div>

<!---------------------------------------- end of main content area  ---------------------------------------- -->