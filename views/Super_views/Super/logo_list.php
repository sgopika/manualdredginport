<script type="text/javascript" language="javascript">
$(document).ready(function() {
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});




  
//----photo checking------//
var _URL = window.URL || window.webkitURL;
    
   $('#my-file-selector1').change(function(){ 
 
      var f=this.files[0];
      var fsize=f.size;
        if(fsize>1000000)
        {
          alert("Photo Size should not exceed 1MB (1024 KB)");
          $("#my-file-selector1").val('');

          return false;
        }
 var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function() {
           // alert(this.width + " " + this.height);
                var widthimg=this.width;
                var heightmg=this.height;

                 if((widthimg>149 && widthimg<351) && (heightmg>149 && heightmg<351))
                {
                    //alert("ok");
                }
                else
                {
                  alert("Error in Upload! Width or Height exceeded");
                  $('#my-file-selector1').val('');
                  return false;
                }
        };
        img.src = _URL.createObjectURL(file);

    }

});


        
  $('#logo_list').validate({
    rules:
    { 
      logo_upload:{required:true },

      location:{required:true },
    },
    messages:
    {
      logo_upload:{required:"<font color='red'>Please Upload Logo!</span>"},
             
      location:{required:"<font color='red'>Please Select Location!</span>"},
 
    },
    errorPlacement: function(error, element)
    {
      if ( element.is(":input") ) { error.appendTo( element.parent() ); }
      else { error.insertAfter( element ); }
    }

  });

});


function ins_logo()
{  
  var data      = new FormData();
  var form_data = $('#logo_list').serializeArray();
  //alert(cntcount);
  $.each(form_data, function (key, input)
  {
    data.append(input.name, input.value);
  });

  var var1      = $('input[name="logo_upload"]').val();
  //alert(var1);
  var location  = $("#location").val(); //alert(location);
  if(var1!='undefined')
  {
    var file_data = $('input[name="logo_upload"]').prop('files')[0];  
    if(file_data!='undefined')
    {
      data.append("logo_upload", file_data);
    }
  }
  else
  {
    
  }

  
  $.ajax({
    url : "<?php echo site_url('Super_Ctrl/Super/add_logo')?>",
    type: "POST",
    dataType:"JSON",
    data: data,
    contentType: false,       
    cache: false,             
    processData:false, 
    success: function(data)
    {
      /*alert(data);
      alert(data['val_errors']);*/
      //exit;
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

        $("#logo_upload").val('');
        $("#location").val('');
        window.location.reload(true);
      }
      else{
        window.location.reload(true);
      }
     
    }
  });

}

function add_logo()
{
  $("#view_logo").hide();
  $("#add_logo").show();
}
  
function delete_logo()
{
  $("#add_logo").hide();
  $("#view_logo").show();
  $("#msgDiv").hide();
}

/*function validate_file(file) 
{
var extension = $('#my-file-selector1').val().split('.').pop().toLowerCase();
if($.inArray(extension, ['png','jpg','jpeg']) == -1) {
alert('Sorry, invalid extension. Only jpg and png images are allowed');
$('#my-file-selector1').val('');
return false;
}
} */
/*function validate_file(file) 
{
  var count1=file.match(/[.]/g).length; 
  if(count1>1)
  {
    alert('Sorry, invalid extension. Only jpg and png images are allowed');
    $('#my-file-selector1').val('');
    return false;
  }
  else if(count1==1)
  {
    var extension = $('#my-file-selector1').val().split('.').pop().toLowerCase();
    if($.inArray(extension, ['png','jpg','jpeg']) == -1) 
    {
      alert('Sorry, invalid extension. Only jpg and png images are allowed');
      $('#my-file-selector1').val('');
      return false;
    }
  }
  else
  {

  }
} */
function validate_fileold(file1) 
{
const uploads = []
const fileSelector = document.getElementById('my-file-selector1')
fileSelector.addEventListener('change', (event) => {
console.time('FileOpen')
const file = event.target.files[0]
const filereader = new FileReader()
filereader.onloadend = function(evt) 
{
  if (evt.target.readyState === FileReader.DONE) 
  {
    const uint = new Uint8Array(evt.target.result)
    let bytes = []
    uint.forEach((byte) => {
    bytes.push(byte.toString(16))
    })
    const hex = bytes.join('').toUpperCase();
    uploads.push({
    filename: file.name,
    filetype: file.type ? file.type : 'Unknown/Extension missing',
    binaryFileType: getMimetype(hex),
    hex: hex
    })
    render();
  }
  console.timeEnd('FileOpen');
}
const blob = file.slice(0, 4);
filereader.readAsArrayBuffer(blob);
})

const render = () => {
  const container = document.getElementById('files');
  const uploadedFiles = uploads.map((file) => {
    $("#filestext").val(file.binaryFileType);

    return `<div>
    Upload Error: ${file.binaryFileType}<br>
    </div>`
  });
  //container.innerHTML = uploadedFiles.join('');
  var imgtype=$("#filestext").val();
  if(imgtype=='Unknown filetype')
  {
    $("#my-file-selector1").val('');
    container.innerHTML ='<span style="color:red">Unknown filetype</span>';
  }
  else
  {
    container.innerHTML ='<span style="color:green">Actual filetype</span>';
  }

}



const getMimetype = (signature) => {
switch (signature) {
case '89504E47':
return 'image/png'
case '47494638':
return 'image/gif'
case '25504446':
return 'application/pdf'
case 'FFD8FFDB':
case 'FFD8FFE0':
return 'image/jpeg'
case '504B0304':
return 'application/zip'
default:
return 'Unknown filetype'
}
}
}

function validate_file(file) 
{
   //alert(file);
  var count1=file.match(/[.]/g).length; 
 // alert(count1);
  if(count1>1)
  {
    alert('Sorry, invalid extension. Only png,jpg / jpeg files are allowed');
    $('#my-file-selector1').val('');
    return false;
  }
  else if(count1==1)
  {
    var extension = file.val().split('.').pop().toLowerCase();
   // alert(extension);
     if($.inArray(extension, ['png','jpg','jpeg']) == -1)  
    {
      alert('Sorry, invalid extension. Only  png,jpg / jpeg files are allowed');
      $('#my-file-selector1').val('');
      return false;
    }
  }
  else
  {
//alert("ss");
  }
} 


function toggle_status(id,status)
{
 
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/status_logo/')?>",
        type: "POST",
        data:{ id:id,stat:status},
        dataType: "JSON",
        success: function(data)
        {
          window.location.reload(true);
        }
      });
}
  function del_logo(id,status)
{
  var csrf_token    = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Super_Ctrl/Super/delete_logo/')?>",
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


function edit_logo(id,i)
{
  $("#view_logo").hide();
  $("#first_"+i).hide();
  $("#first1_"+i).hide();
  $("#first2_"+i).hide();
  $("#hide_"+i).show();
  $("#hide1_"+i).show();
  $("#hide2_"+i).show();
  $("#edit_logo_btn_"+i).hide();
  $("#save_logo_"+i).show();
  $("#cancel_logo_"+i).show();
  $("#edit_div_"+i).hide();
  $("#save_div_"+i).show();
} 
  
function cancel_logo(id,i)
{
  $("#view_logo").show();
  $("#first_"+i).show();
  $("#first1_"+i).show();
  $("#first2_"+i).show();
  $("#hide_"+i).hide();
  $("#hide1_"+i).hide();
  $("#hide2_"+i).hide();
  $("#edit_logo_btn_"+i).show();
  $("#save_logo_"+i).hide();
  $("#cancel_logo_"+i).hide();
  $("#edit_div_"+i).show();
  $("#save_div_"+i).hide();
  $("#valid_err_msg_name_"+i).hide();
  $("#valid_err_msg_code_"+i).hide();
}
  
function save_logo(id,i)
{ 
   alert(id);
  var data      = new FormData();
  var form_data = $('#logo_list').serializeArray();
  //alert(cntcount);
  $.each(form_data, function (key, input)
  {
    data.append(input.name, input.value);
  });
//alert("edit_logo_"+i);
  var var1      = $('input[name="#edit_logo_"'+'i]').val();

 
  alert(var1);
  var location  = $("#edit_location_"+i).val();
  if(var1=='undefined')
  {
    var file_data = $('input[name="#edit_logo_'+'i]').prop('files')[0];  alert(file_data);
    if(file_data!='undefined')
    {
      data.append("logo_upload", file_data);
    }
  }
  else
  {
    
  }

   $.ajax({
    url : "<?php echo site_url('Super_Ctrl/Super/edit_logo')?>",
    type: "POST",
    dataType:"JSON",
    data: data,
    contentType: false,       
    cache: false,             
    processData:false, 
    success: function(data)
    { //alert(data);
      /*alert(data);
      alert(data['val_errors']);*/
      //exit;
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

        $("#logo_upload").val('');
        $("#location").val('');

      }
      else{
        window.location.reload(true);
      }
     
    }
  });

  
}


  
  
  
</script>
<!----------------------------------------start of breadcrumb bar -------------------------------------- ------- -->
<div class="container-fluid ui-innerpage">
<div class="row py-1">
  <div class="col-4 breaddiv">
    <span class="badge bg-darkmagenta innertitle "> Logo </span>
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
    
   <?php  $attributes = array("id" => "logo_list", "name" => "logo_list", "enctype"=> "multipart/form-data");

    echo form_open("Super_Ctrl/Super/add_logo", $attributes);
    ?>



    <!--<form name="logo_list" id="logo_list" method="post"  enctype="multipart/form-data" action="<?php echo $site_url.'/Super_Ctrl/Super/add_logo'?>" > -->
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_logo_list">
        <div class="col-12">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <button type="button" class="btn btn-sm btn-primary" onClick="add_logo()"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Logo</button>
         
         <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
         </div> <!-- end of col12 -->
    </div> <!-- end of view row -->
    <div class="row py-3" id="add_logo" style="display:none;">
      <div class="col-2">
          Upload Logo
      </div> <!-- end of col34 -->
      <div class="col-6"><div id="files"></div>
                    <input type="hidden" id="filestext" name="filestext">
        <input type="file" name="logo_upload" id="my-file-selector1"  onClick="validate_file(this.value)" >
      </div> <!-- end of col34 -->
      <div class="col-4">
        <select name="location" id="location" class="form-control js-example-basic-single" style="width: 100%;">
          <option value="">Select Location</option> 
          <?php foreach($location as $loc_res){ ?>
          <option value="<?php echo $loc_res['location_sl']; ?>"><?php echo $loc_res['location_name']; ?></option>
             <?php }  ?>
        </select>
      </div>  <!-- end of col4 -->
             <div class="col-6 pt-3 d-flex justify-content-end">
             <input type="button" name="logo_ins" id="logo_ins" value="Publish Logo" class="btn btn-info btn-flat" onClick="ins_logo()"  />
             </div>  <!-- end of col6 -->
             <div class="col-6 pt-3 ">
            <input type="button" name="logo_del" id="logo_del" value="Cancel" class="btn btn-danger btn-flat" onClick="delete_logo()"  />
            </div> <!-- end of col6 -->
    </div> <!-- end of add row -->

    <?php
                 echo form_close(); ?>

    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
               
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Logo</th>
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
        foreach($logo_list as $rowmodule){
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
                    <div id="first_<?php echo $i;?>" >
                      <a target=""  class="pop"><img src="<?php echo base_url().'uploads/Logo/'.$rowmodule['bodycontent_image'];?>" class="pop" id="imageresource" data-toggle="modal" data-target="#myModal" style="width:50px">
</a></div>
                     <div id="hide_<?php echo $i;?>"  style="display:none">
                      <input type="file" class="form-control-file" name="edit_logo_<?php echo $i;?>" id="my-file-selector1"  onChange="validate_file(this.value)" value=""  >
                      <!-- <input maxlength="20" class="div300" type="text" name="edit_logo_<?php echo $i;?>"  id="edit_logo_<?php  echo $i;?>" value="<?php echo $rowmodule['bodycontent_image'];?>" onchange="check_dup_logo_edit(<?php echo $i;?>);"   autocomplete="off"/> -->
                 </div><div id="valid_err_msg_name_<?php echo $i; ?>"></div> 
                </td>
                
                
                 <td id="col_div1_<?php echo $i; ?>">
                 <div id="first1_<?php echo $i;?>"><?php echo $location_name;?></div>
                 <div id="hide1_<?php echo $i;?>" style="display:none">
                  <select name="edit_location_<?php echo $i;?>" id="edit_location_<?php echo $i;?>" class="form-control js-example-basic-single" style="width: 100%;">
                    <option value="">Select Location</option> 
                    <?php foreach($location as $loc_res){ ?>
                    <option value="<?php echo $loc_res['location_sl']; ?>"<?php if($loc_res['location_sl']==$loc_id) { ?> selected="selected" <?php } ?>><?php echo $loc_res['location_name']; ?></option>
                       <?php }  ?>
                  </select>
                  <!-- <input maxlength="50" class="div300"  type="text" name="edit_searchlight_size_mal_<?php echo $i;?>"  id="edit_searchlight_size_mal_<?php  echo $i;?>" value="<?php echo $rowmodule['searchlight_size_mal_name'];?>" onchange="check_dup_searchlight_size_mal_edit(<?php echo $i;?>);"    autocomplete="off"/> -->
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
                  <!-- <div id="edit_div_<?php echo $i;?>">
                    <button name="edit_logo_btn_<?php echo $i;?>" id="edit_logo_btn_<?php echo $i;?>" class="btn btn-sm btn-flat btn-point btn-success" type="button" onclick="edit_logo(<?php echo $id;?>,<?php echo $i;?>);" >   <i class="fas fa-pencil-alt
"></i> &nbsp; Edit </button>            
                  </div> -->
                  <div id="save_div_<?php echo $i;?>" style="display:none" class="div150">
                       
                        <button class="btn btn-sm btn-success btn-flat" type="button" name="save_logo_<?php echo $i;?>" id="save_logo_<?php echo $i;?>" onclick="save_logo(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">    &nbsp; Save  </button> &nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning btn-flat" type="button" name="cancel_logo_<?php echo $i;?>" id="cancel_logo_<?php echo $i;?>" onclick="cancel_logo(<?php echo $id;?>,<?php echo $i;?>);" style="display:none">   &nbsp; Cancel  </button> 
                  </div>
                  </td>
                  <td>
                  <?php
          if($rowmodule['bodycontent_ctype']==1)
          {
          ?>
                  <button class="btn btn-sm btn-flat btn-point btn-danger " type="button" onclick="if(confirm('Are you sure to Delete logo?')){ del_logo(<?php echo $id;?>,<?php echo $rowmodule['bodycontent_ctype'];?>);}"> <i class="fas fa-trash-alt"></i> </button>
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
                
              </table>
              <!-- ----------------------------------------------------- end of table column ------------------------------------- -->
              </div> <!-- end of table col12 -->
    </div> <!-- end of table row -->

    <!-- The Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <!-- <h4 class="modal-title" id="myModalLabel">Image preview</h4> -->
      </div>
      <div class="modal-body">
        <img src="" id="imagepreview" style="width: 400px; height: 264px;" >
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>Close</button>
      </div> -->
    </div>
  </div>
</div>
</div>
</div> <!-- end of container-fluid -->
<script>
// Get the modal


$('.pop').click(function(){
  var src= $(this).attr('src');
  $('#imagepreview').attr('src',src);
  $('#myModal').show();
})
$('.close').click(function(){
$('#myModal').hide();
})
</script>

<!---------------------------------------- end of main content area  ---------------------------------------- -->