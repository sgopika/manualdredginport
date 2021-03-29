<script>
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
</script>
<script type="text/javascript" language="javascript">
function search(id)
{
 
  if(id==""){
     $("#Search_val").hide();
     $("#Search_btn").hide();
  } else {
    
    if(id=='1'){

      $("#Search_val").show();
      $("#Search_btn").show();
      $("#search_mob").show();
      $("#search_mail").hide();
      $("#search_kiv").hide();

    } else if(id=='2'){

      $("#Search_val").show();
      $("#Search_btn").show(); 
      $("#search_mob").hide();
      $("#search_mail").show();
      $("#search_kiv").hide();

    } else if(id=='3'){

      $("#Search_val").show();
      $("#Search_btn").show();
      $("#search_mob").hide();
      $("#search_mail").hide();
      $("#search_kiv").show();

    }

    
  }
}

function alpbabetspace(e) {
     var k;
     document.all ? k = e.keyCode : k = e.which;
     return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k==32);
}

function IsNumeric(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)) 
  {
    return true;
  }
  else 
  {
    window.alert("This field accepts only numbers!!");
    return false;
  }
}

function validateEmail(email) {
 
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if( !emailReg.test( email ) ) {
    alert("Invalid Email!!");
    document.getElementById('search_mail').value='';
      return false;
  } else {
      return true;
  }
}

function IsAddress(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 32) || (unicode == 44) || (unicode == 47) || (unicode == 40) || (unicode == 41) || (unicode == 45) || (unicode >64 && unicode<91) || (unicode > 47 && unicode < 58) || (unicode > 96 && unicode < 123) || (unicode==8) || (unicode==46) ) 
  {
          return true;
  }
  else 
  {
        window.alert("Not Allowed");
          return false;  
  }
}   

function search_det(){

  var search_id   = document.getElementById('search_id').value;
  var search_mob  = document.getElementById('search_mob').value;
  var search_mail = document.getElementById('search_mail').value;
  var search_kiv  = document.getElementById('search_kiv').value;

  if(search_id==''){

    alert("Specify the type of search!!!")
    document.getElementById('search_id').focus();
    return false;

  } else {

    if(search_id==1){

      if(search_mob==''){

        alert("Specify the Mobile Number!!!")
        document.getElementById('search_mob').focus();
        return false;

      } else {

        $.ajax({

          url : "<?php echo site_url('Super_Ctrl/Super/search_profile')?>",
          type: "POST",
          data:{search_id:search_id, search_mob:search_mob},
          //dataType: "JSON",
          success: function(data)
          { 
            //alert(data);exit;
            $("#search_detail").html(data);

          } 

        }); 

      }

    } else if(search_id==2){

      if(search_mail==''){

        alert("Enter Mail ID!!!")
        document.getElementById('search_mail').focus();
        return false;

      } else {

        $.ajax({

          url : "<?php echo site_url('Super_Ctrl/Super/search_profile')?>",
          type: "POST",
          data:{search_id:search_id, search_mail:search_mail},
          //dataType: "JSON",
          success: function(data)
          { 

            //alert(data);exit;
            $("#search_detail").html(data);

          } 

        });

      }

    } else if(search_id==3){

      if(search_kiv==''){

        alert("Enter KIV Number!!!")
        document.getElementById('search_kiv').focus();
        return false;

      } else {

        $.ajax({

          url : "<?php echo site_url('Super_Ctrl/Super/search_profile')?>",
          type: "POST",
          data:{search_id:search_id, search_kiv:search_kiv},
          //dataType: "JSON",
          success: function(data)
          { 

            //alert(data);exit;
            $("#search_detail").html(data);

          } 

        });

      }

    }
  }
  
}

function edit_registration(){ 
  
  $("#hide_address").show();
  $("#hide_ph").show();
  $("#hide_email").show();
  $("#save_div").show();
  $("#address").hide();
  $("#phone").hide();
  $("#email").hide();
  $("#edit_div").hide();
  
 
}

function cancel_registration(){ 
  
  $("#hide_address").hide();
  $("#hide_ph").hide();
  $("#hide_email").hide();
  $("#save_div").hide();
  $("#address").show();
  $("#phone").show();
  $("#email").show();
  $("#edit_div").show();
  
 
}
function save_registration(){ 
 
  var id            = document.getElementById('hid_id').value;
  var edit_address  = document.getElementById('edit_address').value;
  var edit_ph       = document.getElementById('edit_ph').value;
  var edit_email    = document.getElementById('edit_email').value; 

  if(edit_address==''){

    alert("Enter Address!!!")
    document.getElementById('edit_address').focus();
    return false;
  
  }

  if(edit_ph==''){

    alert("Enter Mobile Number!!!")
    document.getElementById('edit_ph').focus();
    return false;
  
  } 

  if(edit_email==''){

    alert("Enter Email ID!!!")
    document.getElementById('edit_email').focus();
    return false;
  
  }

  else{

    $.ajax({
          url : "<?php echo site_url('Super_Ctrl/Super/save_profile')?>",
          type: "POST",
          data:{ id:id,edit_address:edit_address,edit_ph:edit_ph,edit_email:edit_email},
          dataType: "JSON",
          success: function(data)
          {
            //alert(data);exit;
            if(data['val_errors']!=""){
              
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
              $("#hide_address").hide();
              $("#hide_ph").hide();
              $("#hide_email").hide();
              $("#save_div").hide();
              $("#address").show();
              $("#phone").show();
              $("#email").show();
              $("#edit_div").show();
            }else{
          window.location.reload(true);
            }
          }
    });
  }
}
</script> 

<div class="main-content ui-innerpage">
<nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end">
           <li><a href="<?php echo $site_url."/Super_Ctrl/Super/SuperHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
        </ol>
</nav>
<!---------------------------------------- end of breadcrumb bar -------------------------------------- ------- -->
<?php 
    $attributes = array("class" => "form-horizontal", "id" => "ports_list", "name" => "ports_list" );
    echo form_open("Super_Ctrl/Super/search_profile", $attributes);
?>
<div class="row no-gutters p-1 justify-content-center">
<div class="col-10">
<div class="alert bg-aqua-active text-center" role="alert">
  <i class="fas fa-user-edit"></i> &nbsp; Edit Profile of Vessel Owner
</div> <!-- end of alert -->
</div> <!-- end of col10 -->
<div class="col-10 px-3">
  <div class="row no-gutter py-2 bg-gray">
    <div class="col-2">
    <label class=" innertitle"> Search By : </label>
  </div> <!-- end of col2 -->
  <div class="col-2 pt-2">
    <select name="search_id" id="search_id" onchange="search(this.value);" class="form-control js-example-basic-single" style="width: 100%;">
                  <option value="">--SELECT--</option> 
                  <option value="1">Mobile Number</option> 
                  <option value="2">Email ID</option> 
                  <option value="3">KIV Number</option> 
    </select>
  </div> <!-- end of col2 -->
  <div class="col-4 pt-1">
    <input type="text" class="form-control"  name="search_mob" id="search_mob" minlength="10" maxlength="11" placeholder="Specify Mobile Number" onkeypress="return IsNumeric(event);" style="display: none;" autocomplete="off">
    <input type="text" class="form-control"  name="search_mail" id="search_mail" onchange="return validateEmail(this.value);" placeholder="Enter Mail ID" style="display: none;">
    <input type="text" class="form-control"  name="search_kiv" id="search_kiv" placeholder="Enter KIV Number" style="display: none;">
  </div> <!-- end of col-4 -->
  <div class="col-4 pt-1">
    <button class="btn btn-flat btn-point bg-darkslategray px-4" type="button" onclick="search_det();" id="Search_btn" name="Search_btn" style="display: none;"><i class="fab fa-searchengin"></i> Search</button>
  </div> <!-- end of col4 -->
  </div> <!-- end of inner row -->
  <div id="resp_msg" class="py-2"> </div>
</div> <!-- end of col10 -->
</div> <!-- end of row -->
<?php echo form_close();?>
<div class="row no-gutters px-5" id="search_detail">
</div> <!-- end of result row -->
</div> <!-- end of main-content container -->