<script type="text/javascript" language="javascript">
$(document).ready(function() {
      
  $('#footer_list').validate({
    rules:
    { 
      footer_eng:{required:true },
      footer_mal:{required:true },
      location:{required:true },
    },
    messages:
    {
      footer_eng:{required:"<font color='red'>Please Enter Registration Item!</span>"},
      footer_mal:{required:"<font color='red'>Please Enter Registration Item in Malayalam!</span>"},
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
  if(val>3){
    alert("The order limit must be between 1 and 3!!!");
    $("#footer_order").val('');
    $("#footer_order").focus();
    return false;
  }
}

function add_footer()
{
  $("#view_footer").hide();
  $("#edit_footer").hide();
  $("#add_footer").show();
}
  
function delete_footer()
{
  $("#add_footer").hide();
  $("#edit_footer").hide();
  $("#view_footer").show();
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

function ins_footer()
{ 
  var footer_eng     = $("#footer_eng").val(); 
  var footer_mal     = $("#footer_mal").val();
  var footer_order   = $("#footer_order").val(); 
      
  if(footer_eng=="")
  {
    alert("Footer Menu in English Required");
    $("#footer_eng").focus();
    return false;
            
  }
  if(footer_mal=="")
  {
    alert("Footer Menu in Malayalam Required");
    $("#footer_mal").focus();
    return false;
  }

  
    //alert(footer_eng);    
  $.ajax({
    url : "<?php echo site_url('Super_Ctrl/Super/add_footer')?>",
    type: "POST",
    data:{footer_eng:footer_eng, footer_mal:footer_mal, footer_order:footer_order},
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
        $("#footer_eng").val('');
        $("#footer_mal").val('');
       $("#footer_order").val('');
       
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
        url : "<?php echo site_url('Super_Ctrl/Super/status_footer/')?>",
        type: "POST",
        data:{ id:id,stat:status,loc:loc},
        //dataType: "JSON",
        success: function(data)
        { //alert(data['val_errors']);exit;
          window.location.reload(true);


        }
      });
}

function del_footer(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/delete_footer/')?>",
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
function edit_footer(id){ //alert(id);
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/edit_footer')?>",
        type: "POST",
        data:{ id:id},
        //dataType: "JSON",
        success: function(data)
        {
          //alert(data);
          $("#edit_footer").show();
          $("#add_footer").hide();
          $("#edit_footer").html(data);
          
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
  
function cancel_footer(id,i)
{
  $("#view_footer").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_footer_btn_"+i).show();
  $("#save_footer_"+i).hide();
  $("#cancel_footer_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}

function save_footer(id)
{ alert(id);exit;
  var edit_footer_eng     = $("#edit_footer_eng").val(); 
  var edit_footer_mal     = $("#edit_footer_mal").val(); 
  var edit_tagline_eng   = $("#edit_tagline_eng").val(); 
  var edit_tagline_mal   = $("#edit_tagline_mal").val();
  var edit_location      = $("#edit_location").val();
  
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  var re = /^[ A-Za-z0-9]*$/;

  

  if(edit_footer_eng=="")
  {
      alert("Registration Item in English Required");
      $("#edit_footer_eng").focus();
      return false;
      
  }
        
  if(edit_footer_mal=="")
  {
      alert("Registration Item in Malayalam Required");
      $("#edit_footer_mal").focus();
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
  if (regex.exec(edit_footer_eng) == null) 
  {
    alert("Only alphabets and characters like .-_ are allowed in English Registration Item.");
    document.getElementById("valid_err_msg_name_"+i).innerHTML ="<font color='red'>Only alphabets and characters like .-_ are allowed in English Registration Item.</font>";
    document.getElementById("edit_footer_eng").value = null;
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
          url : "<?php echo site_url('Super_Ctrl/Super/save_footer/')?>",
          type: "POST",
          data:{ id:id,edit_footer_eng:edit_footer_eng,edit_footer_mal:edit_footer_mal,edit_tagline_eng:edit_tagline_eng,edit_tagline_mal:edit_tagline_mal,location:location},
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
    <span class="badge bg-darkmagenta innertitle "> Footer Menu </span>
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
        $attributes = array("class" => "form-horizontal", "id" => "footer_list", "name" => "footer_list" , "novalidate");
    
    
          echo form_open("Super_Ctrl/Super/save_footer", $attributes);
     ?>
    <!-- <form name="footer_list" id="footer_list" method="post"   action="<?php echo $site_url.'/Super_Ctrl/Super/add_footer'?>" > -->
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_footer_list">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_footer()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Footer</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    


    <div class="row py-3" id="add_footer" style="display:none;">

      <div class="col-4">
          <input type="text" name="footer_eng" maxlength="150" id="footer_eng" class="form-control "  placeholder=" Enter title in English" autocomplete="off"/>
      </div>
      <div class="col-4">
          <input type="text" name="footer_mal" maxlength="150" id="footer_mal" class="form-control "  placeholder=" Enter title in Malayalam" autocomplete="off"/>
      </div>

      <div class="col-2 pt-2 "><font color="#29208c">Enter Menu Order</font></div>
      <div class="col-1 pt-2 ">
          <input type="text" name="footer_order" maxlength="1" id="footer_order" class="form-control "  placeholder="1-3" autocomplete="off" onchange="check_order(this.value);" /> 
      </div>

      <div class="col-6 pt-3 d-flex justify-content-end">
        <input type="button" name="footer_ins" id="footer_ins" value="Add Footer Menu" class="btn btn-info btn-flat" onClick="ins_footer()"  />
      </div>  <!-- end of col6 -->
      <div class="col-6 pt-3 ">
        <input type="button" name="footer_del" id="footer_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_footer()"  />
      </div> <!-- end of col6 -->
    </div> <!-- end of add row -->

<div class="row py-3" id="edit_footer" style="display:none;">
    </div>

    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
          <thead>
            <tr>
              <th id="sl">Sl.No</th>
              <th id="col_name">Footer</th>
              <th id="col_name">Footer in Malayalam</th>
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
          foreach($footer_list as $rowmodule){
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
                    <button name="edit_footer_btn_<?php echo $i;?>" id="edit_footer_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_footer(<?php echo $id;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>          
                  </div>
                  <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_footer_<?php echo $i;?>" id="save_footer_<?php echo $i;?>" onclick="save_footer(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_footer_<?php echo $i;?>" id="cancel_footer_<?php echo $i;?>" onclick="cancel_footer(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                  </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['bodycontent_ctype']==1)
          {
          ?>
                  <button class="btn btn-sm btn-flat btn-point btn-danger " type="button" onclick="if(confirm('Are you sure to Delete Footer Menu?')){ del_footer(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_ctype'];?>);}"> <i class="fas fa-trash-alt"></i> </button>
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