<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo "Page name here"; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row custom-inner">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <button class="btn btn-sm btn-primary" type="button"> <i class="fa fa-fw fa-plus-circle"></i> &nbsp;&nbsp;Add New </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl.No</th>
                  <th>Designation</th>
                  <th>Status</th>
                  <th> v</th>
                  <th> e</th>
                  <th> d </th>
                  
                </tr>
                </thead>
                <tbody>
                <?php
					
				for ($i=1;$i<=50;$i++){
					?>
					<tr>
						<td> <?php echo $i; ?> </td>
						<td> Designation </td>
						<?php 
							if ($i % 2 != 0) {
								?>
								<td> <button class="btn btn-sm btn-success" type="button"> <i class="fa fa-fw  fa-check-circle-o"></i> &nbsp;&nbsp; Active &nbsp;&nbsp; </button> </td>
								<?php
							}
							else {
								?>
								<td> <button class="btn btn-sm btn-info" type="button"> <i class="fa fa-fw  fa-minus"></i> &nbsp; Inactive  </button> </td>
								<?php
							} ?>
						
						<td>  <button class="btn btn-sm bg-olive-active" type="button"> <i class="fa fa-fw  fa-folder-open-o"></i> &nbsp; View  </button>  </td>
						<td> <button class="btn btn-sm bg-purple" type="button"> <i class="fa fa-fw  fa-pencil"></i> &nbsp; Edit  </button> </td>
						<td> <button class="btn btn-sm btn-danger" type="button"> <i class="fa fa-fw fa-trash"></i> &nbsp; Delete  </button> </td>
					</tr>
					<?php
				}
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Sl.No</th>
                  <th>Designation</th>
                  <th>Status</th>
                  <th> v</th>
                  <th> e</th>
                  <th> d </th>
                  
                </tr>
                </tfoot>
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
  </div>
  <!-- /.content-wrapper -->