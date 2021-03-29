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
<!----------------------------------------start of breadcrumb bar -------------------------------------- ------- -->
<div class="container-fluid ui-innerpage">
<div class="row py-1">
  <div class="col-4 breaddiv">
    <span class="badge bg-darkmagenta innertitle "> Dynamic Form List </span>
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
     <?php 
        if($this->session->flashdata('msg'))
          {
            echo $this->session->flashdata('msg');
          }
        ?> 
    <!--  ---------------------------------- To fill Form PHP Code  ----------------------------------------------- -->
     <?php 
    $attributes = array("class" => "form-horizontal", "id" => "dynamic_form_list_byvessel", "name" => "dynamic_form_list_byvessel" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/dynamic_form", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/dynamicform_byvessel", $attributes);
 }?>
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_enginetype">
               <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
        <div class="col-6 d-flex justify-content-start">
          <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/add_dynamic_form"?>"><button type="button" class="btn btn-flat btn-point btn-primary"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Dynamic Form</button></a>
        </div> <!-- end of col6 -->
        <div class="col-6 d-flex justify-content-end">
         <a class="btn btn-flat btn-success btn-point" href="<?php echo $site_url."/Kiv_Ctrl/Master/copyDynamicform"?>"><i class="far fa-copy"></i>&nbsp; Copy Dynamic Form </a>
         </div> <!-- end of col12 -->
          <div class="box-header col-12" id="add_enginetype" style="display:none;"></div>
                  <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
    </div> <!-- end of view row -->
    <div class="row">
        <div class="col-12">
        <!-- --------------------------------------------- start of table column ------------------------------------- -->
        <table id="example1" class="table table-bordered table-striped table-hover">
           <thead>
          <tr>
            <th>Sl.No</th>
            <th>Vessel Type Name</th>
            <th>Vessel Sub Type Name</th>
            <th>Hull Material</th>
            <th>Length Over the Deck</th>
            <th>Inboard/Outboard</th>
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
               $start_date=$dynamic_value['start_date'];
               $end_date=$dynamic_value['end_date'];
               $start_date_view  = explode('-', $start_date);
               @$start_date_view  = $start_date_view[2]."/".$start_date_view[1]."/".$start_date_view[0];
               $end_date_view  = explode('-', $end_date);
               @$end_date_view  = $end_date_view[2]."/".$end_date_view[1]."/".$end_date_view[0];
               if($dynamic_value['end_date']=='0000-00-00'){$msg="dd/mm/yyyy";}else{$msg=$end_date_view;}
         ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $dynamic_value['vesseltype_name']; ?></td>
            <td><?php echo $dynamic_value['vessel_subtype_name']; ?></td>
            <td><?php if($dynamic_value['hullmaterial_id']==9999){echo "All";}else{echo $dynamic_value['hullmaterial_name'];} ?></td>
            <td><?php echo $dynamic_value['length_over_deck']; ?></td>
            <td><?php if($dynamic_value['engine_inboard_outboard']==9999){echo "All";}else{echo $dynamic_value['inboard_outboard_name'];} ?></td>
            <td><?php echo "From ".$start_date_view." To ".$msg; ?><input type="hidden" name="hid_startDate" id="hid_startDate" value="<?php echo $start_date; ?>"><input type="hidden" name="hid_endDate" id="hid_endDate" value="<?php echo $end_date; ?>"></td>
            <td>                
                <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/detListViewDynamicform_byvessel/$vess_id/$vess_sub_id/$length_over_deck/$hullmaterial_id/$engine_inboard_outboard/$start_date/$end_date"?>"> 
                <button name="edit_dynamic_page_btn_<?php echo $i;?>" id="edit_bank_btn_<?php echo $i;?>" class="btn btn-sm bg-blue btn-flat" type="button" >   <i class="fa fa-fw fa-plus-circle"></i>  </button>  </a>   
            </td>
          </tr>
        <?php $i++;} ?>
      </tbody>
   </table>
              <!-- ----------------------------------------------------- end of table column ------------------------------------- -->
      </div> <!-- end of table col12 -->
    </div> <!-- end of table row -->
    <?php echo form_close(); ?>
</div> <!-- end of container-fluid -->
<!---------------------------------------- end of main content area  ---------------------------------------- -->