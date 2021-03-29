
    <section class="content-header">
     <h1>
         <button class="btn btn-primary btn-flat disabled" type="button" > View Userposting </button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo site_url("Master/dashboard_master"); ?>"> Master</a></li>
		   <li><a href="<?php echo site_url("Master/userposting"); ?>">Userposting</a></li>

        <li><a href="#"><strong> View Userposting </strong></a></li>
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
      <!--      </div> -->
		  
            
        <div class="box box-primary">
            <div class="box-header ">
              <h3 class="box-title"> View Userposting </h3>
          </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
        $attributes = array("class" => "form-horizontal", "id" => "designation_add", "name" => "designation_add");
		//print_r($editres); echo $editres[0]['intUserTypeID'];
		if(isset($int_designation_sl)){
       		echo form_open("Master/designation_edit", $attributes);
		} else {
			echo form_open("Master/designation_add", $attributes);
		}?>

		
              <table id="vacbtable" class="table table-bordered table-striped">

      	<tr >
      		<td>User</td>
      		<td ><?php if(isset($user)){echo $user;} ?>
           
            
            </td>
      	</tr>
		
			<tr >
      		<td>Designation</td>
      		<td ><?php if(isset($designation)){echo $designation;} ?>
           
            
            </td>
      	</tr>
		
		<tr >
      		<td>Range</td>
      		<td ><?php if(isset($range)){echo $range;} ?>
           
            
            </td>
      	</tr>
		
		<tr >
      		<td>Unit</td>
      		<td ><?php if(isset($unit)){echo $unit;} ?>
           
            
            </td>
      	</tr>
		<tr >
      		<td>Usergroup</td>
      		<td ><?php if(isset($usergroup)){echo $usergroup;} ?>
           
            
            </td>
      	</tr>
		<?php if(@$get_section_names){?>
			<tr >
      		<td>Section</td>
      		<td ><?php echo $get_section_names;?>
            </td>
      	</tr>
		<?php } ?>
		<tr>
      		<td>Start date</td>
      		<td ><?php if(isset($start)){echo $start;} ?>
           
            
            </td>
      	</tr>
		<tr>
      		<td>End date</td>
      		<td ><?php if(isset($end)){echo $end;} ?>
           
            
            </td>
      	</tr>
      	
      
      	

	  </table>
  		 
 		<div class="form-group">
        <div class="col-sm-offset-4 col-lg-8 col-sm-6 text-left"></div>
        </div>
		

    
          
              
		   <?php echo form_close(); ?>
<!--          </div>
            </div>
-->			 </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->
  </section>
<!-- /.content -->