<script type="text/javascript" language="javascript">
 
</script>



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1>
<button type="button" class="btn bg-primary btn-flat margin">View Copied Dynamic Form</button>
      </h1>
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
       <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/viewCopyDynamicform"?>"></i>  <span class="badge bg-blue"> View Copy Dynamic Page </span> </a></li>
        <!-- <li><a href="#"><span class="badge bg-blue"> Page2  </span></a></li>-->
      </ol></ol>
    </section>
    <!-- Bread Crumb Section Ends Here .... -->
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
      <div class="col-md-12">
         
         
         <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
       

        <?php 
        if($this->session->flashdata('msg'))
          {
            echo $this->session->flashdata('msg');
          }
        ?>
               

      


 <?php 
    $attributes = array("class" => "form-horizontal", "id" => "copy_dynamic_form_viewlist", "name" => "copy_dynamic_form_viewlist" , "novalidate");
    
    if(isset($editres)){
          echo form_open("Kiv_Ctrl/Master/dynamic_form", $attributes);
    } else {
      echo form_open("Kiv_Ctrl/Master/detListViewCopyDynamicform", $attributes);
 }?>

<div class="box">
  <div class="box-header">
            
        <!--<div class="box-header" id="view_enginetype">
             <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/add_dynamic_form"?>"><button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-plus-circle"></i>&nbsp; Add New Dynamic Form</button></a>
        </div>-->
        <div class="box-header col-md-12" id="add_enginetype" style="display:none;"></div>
 

<div class="box-body">

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
            <th>Heading Name</th>
            <th>Date</th>
            <!--<th>Label Name</th>-->
            <!--<th>Status</th>
            <th></th>
            <th></th>-->
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
            <td><?php echo $dynamic_value['heading_name']; ?></td>
            <?php if($dynamic_value['end_date']=='0000-00-00'){$msg="dd/mm/yyyy";}else{$msg=$end_date_view;} ?>
            <td><?php echo "From ".$start_date_view." To ".$msg; ?><input type="hidden" name="hid_startDate" id="hid_startDate" value="<?php echo $start_date; ?>"><input type="hidden" name="hid_endDate" id="hid_endDate" value="<?php echo $end_date; ?>"></td>
            <!--<td><?php echo $dynamic_value['label_name']; ?></td>-->            
            

            <!--<td><?php  
            /*if($dynamic_value['status']=='1')  { ?>

                <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $dynamic_value['status'];?>);"  > <i class="fa fa-fw  fa-check"></i></button> 
            
            <?php }  else { ?>

                <button class="btn btn-sm btn-info btn-flat"  type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $dynamic_value['status'];?>);"> <i class="fa fa-fw fa-minus-circle"></i>  </button> 

            <?php  } */?>
            </td>

            <td>
                <?php //echo $site_url."/Kiv_Ctrl/Master/edit_dynamic_form/$id"?>
                <a href="<?php //echo $site_url."/Master/edit_dynamic_form/$head_id/$vess_id/$vess_sub_id/$length_over_deck/$hullmaterial_id/$engine_inboard_outboard/$form_id/$start_date/$end_date"?>">
                <button name="edit_dynamic_page_btn_<?php echo $i;?>" id="edit_bank_btn_<?php echo $i;?>" class="btn btn-sm bg-purple btn-flat" type="button" >   <i class="fa fa-fw  fa-pencil"></i>  </button>
                </a>   
            </td>

            <td> <?php
            /*if($dynamic_value['delete_status']==1) { ?>
          
         
                <!--<button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Dynamic Form Details?')){ del_dynamic_fields(<?php echo $id;?>,<?php echo $dynamic_value['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>-->
                <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Dynamic Form Details?')){ del_dynamic_fields(<?php echo $head_id;?>,<?php echo $dynamic_value['delete_status'];?>,<?php echo $dynamic_value['form_id'];?>,<?php echo $dynamic_value['vesseltype_id'];?>,<?php echo $vess_sub_id;?>,<?php echo $length_over_deck;?>,<?php echo $hullmaterial_id;?>,<?php echo $engine_inboard_outboard;?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>

            <?php } else { ?>

                <!--<button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Dynamic Form Details?')){ del_dynamic_fields(<?php echo $id;?>,<?php echo $dynamic_value['delete_status'];?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>-->
                <button class="btn btn-sm btn-danger btn-flat" type="button" onclick="if(confirm('Are you sure to Delete Dynamic Form Details?')){ del_dynamic_fields(<?php echo $head_id;?>,<?php echo $dynamic_value['delete_status'];?>,<?php echo $dynamic_value['form_id'];?>,<?php echo $dynamic_value['vesseltype_id'];?>,<?php echo $vess_sub_id;?>,<?php echo $length_over_deck;?>,<?php echo $hullmaterial_id;?>,<?php echo $engine_inboard_outboard;?>);}"> <i class="fa fa-fw fa-times"></i> &nbsp;   </button>
            <?php } */?>
            </td>-->

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
            <th>Heading Name</th>
            <th>Date</th>
            <!--<th>Label Name</th>-->
            <!--<th>Status</th>
            <th></th>
            <th></th>-->                
          </tr>
      </tfoot>


</table>
</div>
        <!-- end of  /.box-body -->
        
          <?php  echo form_close(); ?>
        
  </div>
            <!-- /.box-body -->
          </div>             
                    
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  