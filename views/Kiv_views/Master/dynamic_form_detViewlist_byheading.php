<script type="text/javascript" language="javascript">
  function goBack() 
{ 
  window.history.back();
} 
  function toggle_status(id,status)
{
  var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
  $.ajax({
        url : "<?php echo site_url('Master/status_dynamic_form/')?>",
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
        url : "<?php echo site_url('Master/delete_dynamic_form/')?>",
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
  <div class="col-4 breaddiv mt-2">
    <span class="badge bg-darkmagenta innertitle "> Dynamic Form - Based on Heading Name </span>
  </div>  <!-- end of col4 -->
  <div class="col-8">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb justify-content-end">
     <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
      &nbsp; / &nbsp;
     <li><a class="breadcrumb-item" href="<?php echo $site_url."/Kiv_Ctrl/Master/dynamicform_byvessel"?>">Dynamic Forms List 1 (All)</a></li>

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
          $attributes = array("class" => "form-horizontal", "id" => "dynamic_form_detViewlist_byheading", "name" => "dynamic_form_detViewlist_byheading" , "novalidate");
          
          if(isset($editres)){
                echo form_open("Master/detListViewDynamicform_byvesselform", $attributes);
          } else {
            echo form_open("Master/detListViewDynamicform_byvesselform", $attributes);
       }?>
               
    <!--  ---------------------------------- End of fill Form PHP Code  ----------------------------------------------- -->                
    <div class="row py-3" id="view_enginetype">
         <!-- ----------------------------------------- Add Button  ----------------------------------------------   --- -->
         <div class="col-6 d-flex justify-content-start">
          <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/add_dynamic_form"?>"><button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Dynamic Form</button></a>
         </div> <!-- end of div6 -->
        <div class="col-6 d-flex justify-content-end">
          <a class="btn btn-flat btn-point btn-success" href="<?php echo $site_url."/Kiv_Ctrl/Master/copyDynamicform"?>"> <i class="far fa-copy"></i> &nbsp;Copy Dynamic Form</a>
         </div> <!-- end of col12 -->
                  <!-- ------------------------------------- End of Add Button  -------------------------------------------   --- -->
    </div> <!-- end of view row -->
    <div class="row">
      <div class="box-header col-12" id="add_enginetype" style="display:none;"></div>
    </div> <!-- end of row -->
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
            <th>Form Name</th>
            <th>Heading Name</th>
            <th>Date</th>
            <th>Status</th>
            <th></th>
            <th></th>
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
               $start_date_view  = $start_date_view[2]."/".$start_date_view[1]."/".$start_date_view[0];
               $end_date_view  = explode('-', $end_date);
               $end_date_view  = $end_date_view[2]."/".$end_date_view[1]."/".$end_date_view[0];
         ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $dynamic_value['vesseltype_name']; ?></td>
            <td><?php echo $dynamic_value['vessel_subtype_name']; ?></td>
            <td><?php if($dynamic_value['hullmaterial_id']==9999){echo "All";}else{echo $dynamic_value['hullmaterial_name'];} ?></td>
            <td><?php echo $dynamic_value['length_over_deck']; ?></td>
            <td><?php if($dynamic_value['engine_inboard_outboard']==9999){echo "All";}else{echo $dynamic_value['inboard_outboard_name'];} ?></td>
            <td><?php echo $dynamic_value['document_type_name']; ?></td>
            <td><?php echo $dynamic_value['heading_name']; ?></td>
            <?php if($dynamic_value['end_date']=='0000-00-00'){$msg="dd/mm/yyyy";}else{$msg=$end_date_view;} ?>
            <td><?php echo "From ".$start_date_view." To ".$msg; ?><input type="hidden" name="hid_startDate" id="hid_startDate" value="<?php echo $start_date; ?>"><input type="hidden" name="hid_endDate" id="hid_endDate" value="<?php echo $end_date; ?>"></td>
            <td><?php  
            if($dynamic_value['status']=='1')  { ?>
                <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $dynamic_value['status'];?>);"  > <i class="fa fa-fw  fa-check"></i></button> 
            <?php }  else { ?>
                <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $dynamic_value['status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 
            <?php  } ?>
            </td>
            <td>
                <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/edit_dynamic_form/$head_id/$vess_id/$vess_sub_id/$length_over_deck/$hullmaterial_id/$engine_inboard_outboard/$form_id/$start_date/$end_date"?>">
                <button name="edit_dynamic_page_btn_<?php echo $i;?>" id="edit_bank_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" >  <i class="fas fa-pencil-alt"></i>  </button><!--&nbsp; Edit-->
                </a>   
            </td>
            <td> <?php
            if($dynamic_value['delete_status']==1) { ?>
                <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Dynamic Form Details?')){ del_dynamic_fields(<?php echo $head_id;?>,<?php echo $dynamic_value['delete_status'];?>,<?php echo $dynamic_value['form_id'];?>,<?php echo $dynamic_value['vesseltype_id'];?>,<?php echo $vess_sub_id;?>,<?php echo $length_over_deck;?>,<?php echo $hullmaterial_id;?>,<?php echo $engine_inboard_outboard;?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>
            <?php } else { ?>
                <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Dynamic Form Details?')){ del_dynamic_fields(<?php echo $head_id;?>,<?php echo $dynamic_value['delete_status'];?>,<?php echo $dynamic_value['form_id'];?>,<?php echo $dynamic_value['vesseltype_id'];?>,<?php echo $vess_sub_id;?>,<?php echo $length_over_deck;?>,<?php echo $hullmaterial_id;?>,<?php echo $engine_inboard_outboard;?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>
            <?php } ?>
            </td>
          </tr>
        <?php $i++;} ?>
      </tbody>
                <?php
                 echo form_close(); ?>
              </table>
              <!-- ----------------------------------------------------- end of table column ------------------------------------- -->
              </div> <!-- end of table col12 -->
    </div> <!-- end of table row -->
</div> <!-- end of container-fluid -->
<!---------------------------------------- end of main content area  ---------------------------------------- -->