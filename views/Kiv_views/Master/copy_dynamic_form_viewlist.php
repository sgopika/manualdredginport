<script type="text/javascript" language="javascript">
  function toggle_status(id,status)
{
  
  var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/status_dynamic_form/')?>",
        type: "POST",
        data:{ id:id,stat:status,'csrf_test_name': csrf_token },
        dataType: "JSON",
        success: function(data)
        { 
          window.location.reload(true);
        }
      });
}
  function del_dynamic_fields(id,status,form_id,vesseltype_id,vess_sub_id,length_over_deck,hullmaterial_id,engine_inboard_outboard)
{ //,start_date,end_date
  var start_date = $("#hid_startDate").val();//alert(start_date);
  var end_date   = $("#hid_endDate").val();//alert(end_date);
  var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Kiv_Ctrl/Master/delete_dynamic_form/')?>",
        type: "POST",       

       data:{ id:id,stat:status,form_id:form_id,vesseltype_id:vesseltype_id,vess_sub_id:vess_sub_id,length_over_deck:length_over_deck,hullmaterial_id:hullmaterial_id,engine_inboard_outboard:engine_inboard_outboard,start_date:start_date,end_date:end_date,'csrf_test_name': csrf_token },
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
</script>
        <?php 
          $attributes = array("class" => "form-horizontal", "id" => "copy_dynamic_form_viewlist", "name" => "copy_dynamic_form_viewlist" , "novalidate");
          
          if(isset($editres)){
                echo form_open("Kiv_Ctrl/Master/dynamic_form", $attributes);
          } else {
            echo form_open("Kiv_Ctrl/Master/viewCopyDynamicform", $attributes);
       }?>  
<div class="container-fluid ui-innerpage">
    <div class="row pt-2">
    <div class="col-6">
      <span class="badge bg-darkmagenta innertitle "> View Copy Dynamic Form </span>
    </div> <!-- end of col6 -->
    <div class="col-6 d-flex justify-content-end">
     <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end">
           <li><a class="no-link"  href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
        </ol>
      </nav>
    </div> <!-- end of col6 -->
  </div> <!-- end of row -->
  <?php 
        if($this->session->flashdata('msg'))
          {
            echo $this->session->flashdata('msg');
          }
        ?>

      <div class="row pt-2">
        <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 

        <div class="col-6 d-flex justify-content-start"> 
          <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/add_dynamic_form"?>" class="btn btn-primary btn-flat btn-point"><i class="fas fa-plus-circle"></i>&nbsp; Add Dynamic Form</a>
        </div>
        <div class="col-6 d-flex justify-content-end"> 
          <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/copyDynamicform"?>" class="btn btn-success btn-flat btn-point"> <i class="fas fa-copy"></i>&nbsp;Copy Dynamic Form </a>
        </div>
      </div> <!-- end of row -->
      <div class="row pt-2" id="add_enginetype" >
        <div class="col-12 d-flex justify-content-center">
          <table id="example1" class="table table-bordered table-striped">
      <thead>
          <tr>
            <th>Sl.No</th>
            <th>Vessel Type Name</th>
            <th>Vessel Sub Type Name</th>
            <th>Hull Material</th>
            <th>Length Over the Deck</th>
            <th>Inboard/Outboard</th>
            <th>Form Name</th>
            <th>Date</th>
            <th>View</th>
          </tr>
      </thead>
      <tbody>
         <?php $i=1; foreach ($dynamic_form as $dynamic_value) {
               $id=$dynamic_value['dynamic_field_sl'];
               $head_id=$dynamic_value['heading_id'];
               $vess_id=$dynamic_value['vesseltype_id'];
               $vess_sub_id=$dynamic_value['vessel_subtype_id'];
               $length_over_deck=$dynamic_value['length_over_deck'];
               $hullmaterial_id=$dynamic_value['hullmaterial_id'];
               $engine_inboard_outboard=$dynamic_value['engine_inboard_outboard'];
               $form_id=$dynamic_value['form_id'];
               $start_date=$dynamic_value['start_date'];
               $end_date=$dynamic_value['end_date'];
               $start_date_view  = explode('-', $start_date);
               @$start_date_view  = $start_date_view[2]."/".$start_date_view[1]."/".$start_date_view[0];
               $end_date_view  = explode('-', $end_date);
               @$end_date_view  = $end_date_view[2]."/".$end_date_view[1]."/".$end_date_view[0];
         ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $dynamic_value['vesseltype_name']; ?></td>
            <td><?php echo $dynamic_value['vessel_subtype_name']; ?></td>
            <td><?php if($dynamic_value['hullmaterial_id']==9999){echo "All";}else{echo $dynamic_value['hullmaterial_name'];} ?></td>
            <td><?php echo $dynamic_value['length_over_deck']; ?></td>
            <td><?php if($dynamic_value['engine_inboard_outboard']==9999){echo "All";}else{echo $dynamic_value['inboard_outboard_name'];} ?></td>
            <td><?php echo $dynamic_value['document_type_name']; ?></td>
            <?php if($dynamic_value['end_date']=='0000-00-00'){$msg="dd/mm/yyyy";}else{$msg=$end_date_view;} ?>
            <td><?php echo "From ".$start_date_view." To ".$msg; ?><input type="hidden" name="hid_startDate" id="hid_startDate" value="<?php echo $start_date; ?>"><input type="hidden" name="hid_endDate" id="hid_endDate" value="<?php echo $end_date; ?>"></td>
            <td>                
                <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/detListViewCopyDynamicform/$vess_id/$vess_sub_id/$length_over_deck/$hullmaterial_id/$engine_inboard_outboard/$form_id/$start_date/$end_date"?>">
                <button name="edit_dynamic_page_btn_<?php echo $i;?>" id="edit_bank_btn_<?php echo $i;?>" class="btn btn-sm bg-blue btn-flat" type="button" >   <i class="fa fa-fw fa-plus-circle"></i>  </button>
                </a>   
            </td>
          </tr>
        <?php $i++;} ?>
      </tbody>
      <tfoot>
          <tr>
            <th>Sl.No</th>
            <th>Vessel Type Name</th>
            <th>Vessel Sub Type Name</th>
            <th>Hull Material</th>
            <th>Length Over the Deck</th>
            <th>Inboard/Outboard</th>
            <th>Form Name</th>
            <th>Date</th>
            <th>View</th>
          </tr>
      </tfoot>
    </table>
        </div>
      </div> <!-- end of row -->
</div> <!-- end of container fluid row -->
<?php  echo form_close(); ?>