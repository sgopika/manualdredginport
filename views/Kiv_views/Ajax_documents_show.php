 <style type="text/css">
        .wellwhite {
            background-color: rgb(255, 255, 255);
            border-radius:0px !important;
            vertical-align: middle;
        }
        .well {
          border-radius:0px !important ;
          vertical-align: middle;
        }
        .labeldivision1{
            min-height: 60px;
             vertical-align: middle;
              border-radius:0px !important;
              background-color:#fff;
              padding: 1%;
        }
        .labeldivision2{
            min-height: 60px;
             vertical-align: middle;
              border-radius:0px !important;
              background-color:#f5f5f5;
              padding: 1%;
        }

    </style>

    <?php
   $list_document                =  $this->Survey_model->get_list_document();
      $data['list_document']     =  $list_document;


    ?>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding" id="doc_placing_div" >
<!-- Inside Heading div -->
<!-- Dynamic css classes to be loaded -->
<!-- class=well -->

<?php 

$heading_id1=7;
$form_id=1;
$label_details=$this->Survey_model->get_label_details_ajax($form_id,$heading_id1);
$data['label_details']=$label_details;
$static_array = array_column($label_details, 'label_sl');

  
    if(!empty($label_control_details))
    {   
      $var_row=0;
$var_color=0;// 0-odd, 1-even


        $i=1;
        foreach ($label_control_details as $key) {


           

$value_id1=$key['value_id'];


$value_id=rtrim($value_id1,",");

$myarr=(explode(",",$value_id));



 
$j=1;
foreach($list_document as $res_list_document)
{
if(in_array($res_list_document['document_sl'],$myarr))
    {
$count=count($list_document);

$listname=$res_list_document['document_name'];
$sl=$res_list_document['document_sl'];

//$value61='<input type="file" name="myFile'.$i.'">';
/*$value61= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$listname.$sl.' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
<input type="file" name="myFile'.$i.'">
</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';*/
 

$value61= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$listname.' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
<input type="file" name="myFile'.$sl.'" onChange="validate_file(this.value,this.id)" id="myFile'.$sl.'">
<input type="hidden" value="'.$count.'" name="cntcount" id="cntcount">

</div>
</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';



        if($var_color==0){
            $style='oddtab';
            $var_color=1;
        }
        else {
           $style="eventab";
           $var_color=0;
        }
?>
    <!-- Creating New Row -->
    <div class="row no-gutters  <?php echo $style; ?>">
    <div class="col-12">
    <?php echo $value61; ?>
    </div> <!-- end of col-12 -->
    </div> <!-- end of row --> 

<?php
$i++;
    }

$j++;
//$label_controls1=$value61;


 } 

//echo $value61;
}
}
?>
 </div>
 <script type="text/javascript">
var _URL = window.URL || window.webkitURL;
function validate_file(file,myid) 
{
  var fsize = $('#'+myid)[0].files[0].size;
  var filename=file;
  var extension = filename.split('.').pop().toLowerCase();

  if($.inArray(extension, ['pdf','doc','docx','odt']) == -1) 
  {
    alert('Sorry, invalid extension.');
    $("#"+myid).val('');
    return false;
  }

  if(fsize>1000000)
  {
    alert("File Size is Exeed 1MB (1024 KB)");
    $("#"+myid).val('');
    return false;
  }
} 
 </script>

