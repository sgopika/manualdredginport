
<!-- Page specific script starts here -->
<script type="text/javascript" language="javascript">

function toggle_status(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Master/status_userposting/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}

function del_userposing(id,status)
{
	$.ajax({
				url : "<?php echo site_url('Master/delete_userposting/')?>",
				type: "POST",
				data:{ id:id,stat:status},
				dataType: "JSON",
				success: function(data)
				{
					window.location.reload(true);
				}
			});
}

</script>
 <!-- Page specific script Ends Here -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" >Police Case</button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>">Master</a></li>
        <li><a href="#"><strong>Communication</strong></a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
        <div class="col-md-9">
          <!-- /.box -->
          <div class="box" >
             <?php if( $this->session->flashdata('msg')){ 
		   	echo $this->session->flashdata('msg');
		   }?>
			<?php 
        $attributes = array("class" => "form-horizontal", "id" => "police_case", "name" => "police_case" , "novalidate");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($editres)){
       		echo form_open("Master/police_case_add", $attributes);
		} else {
			echo form_open("Master/police_case_add", $attributes);
		}?>
            <div class="box-header" id="view_designation">
              <a href="<?php echo $site_url.'/Master/police_case_add';?>"> <button class="btn btn-primary btn-flat" type="button" > <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Communication</button>
              </a>
            </div>
            <div class="box-body">
              <table id="vacbtable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th id="sl">Sl.No</th>
                  <th id="col_name">Token Number</th>
				  <th id="col_name">Station Name</th>
                  <th id="col_name">Reference Number</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
				//print_r($data);
				 $i=1; foreach($get_policecase_list as $rowmodule){
					 $id = $rowmodule['police_case_id'];
					?>
					<tr id="<?php echo $i;?>">
						<td  id="sl_div_<?php echo $i; ?>"> <?php echo $i; ?> </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['police_case_token_number']);?></div>
                        </td>
						<td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['police_case_office']);?></div>
                        </td>
                        <td id="col_div_<?php echo $i; ?>">
                        <div id="first_<?php echo $i;?>"><?php echo strtoupper($rowmodule['police_case_reference_number']);?></div>
                        </td>
						<?php 
							if ($rowmodule['police_case_replied_user']==NULL) {
								?>
								<td> <button class="btn btn-sm btn-success btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['police_case_replied_user'];?>);"  > <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp;Waiting &nbsp;&nbsp; </button> </td>
								<?php
							}
							else {
								?>
								<td> <button class="btn btn-sm btn-info btn-flat" type="button" onclick="toggle_status(<?php echo $id;?>,<?php echo $rowmodule['police_case_replied_user'];?>);"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Replied  </button> </td>
								<?php
							} ?>
					</tr>
					<?php
					$i++; 
				}
                echo form_close(); ?>
                </tbody>
               
              </table>
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