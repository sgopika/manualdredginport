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

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1>
<button type="button" class="btn bg-primary btn-flat margin"> Page Description</button>
      </h1>
      <!-- Important; the following two ol class has to be kept, its not mistake -->
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>index.php/Survey/SurveyHome"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
       <!-- <li><a href="#"></i>  <span class="badge bg-blue"> Page1 </span> </a></li>
        <li><a href="#"><span class="badge bg-blue"> Page2  </span></a></li>-->
      </ol> </ol> 
      <!-- End of two ol -->
    </section>
    <!-- Bread Crumb Section Ends Here .... -->
    <!-- Header Section ends here -->
    <!-- Main content -->
    <section class="content">
   <!-- Main Content starts here -->
    <!-- PANEL ROW START -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border bg-info">
              <h3 class="box-title"><i class="fa fa-fw  fa-history"></i> <font color="0000ff"> Survey </font> </font></h3>
            </div>
            <!-- /.box-header -->

<div class="box-body bg-info">
    <div class="row">
    <div class="col-md-12">

      <!-- Inside Div -->
      <!-- BOX 1-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <!-- <a href="surveydashboard.php">-->
      <a href="<?php echo base_url();?>index.php/Survey/InitialSurvey">
      <div class="info-box">
      <span class="info-box-icon bg-orange"><i class="fa fa-fw fa-sort-amount-desc"></i></span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Initial Survey  </font> </h4>  <br><br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </a>
      </div>
      <!-- /.col -->
      <!-- BOX 1 END -->

      <!-- BOX 2-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
      <span class="info-box-icon bg-lime"><i class="fa fa-fw fa-graduation-cap"></i></span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Annual Survey  </font> </h4>  <br><br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- BOX 2 END -->


      <!-- BOX 3-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
      <span class="info-box-icon bg-purple"><i class="fa fa-fw fa-line-chart"></i></span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Dry Dock Survey  </font> </h4>  <br><br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- BOX 3 END -->
      

      <!-- BOX 4-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
      <span class="info-box-icon bg-primary"><i class="fa fa-fw fa-crop"></i></span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Special Survey  </font> </h4>  <br><br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- BOX 4 END -->


    <!-- End of inside Div -->

    </div>
    <!-- /.col -->
    </div>
<!-- /.row -->
</div>


            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- PANEL ROW END -->
      
      <!-- PANEL ROW START -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border bg-info">
              <h3 class="box-title"><i class="fa fa-fw  fa-cloud-upload"></i> <font color="0000ff"> Utilties </font> </font></h3>
            </div>
    <!-- /.box-header -->
    <div class="box-body bg-info">
    <div class="row">
    <div class="col-md-12">

      <!-- Inside Div -->
      <!-- BOX 1-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
      <span class="info-box-icon bg-lime"><i class="fa fa-fw fa-files-o"></i></span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Registration  </font> </h4>  <br><br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- BOX 1 END -->

      <!-- BOX 2-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
      <span class="info-box-icon bg-purple"><i class="fa fa-fw  fa-file-code-o"></i></span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Name Change </font> </h4>  <br><br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- BOX 2 END -->

      <!-- BOX 3-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
      <span class="info-box-icon bg-primary"><i class="fa fa-fw fa-crosshairs"></i></span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Renewal of <br> Registration  </font> </h4>  <br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- BOX 3 END -->

      <!-- BOX 4-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
      <span class="info-box-icon bg-blue"><i class="fa fa-fw fa-briefcase"></i></span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Ownership<br> change  </font> </h4>  <br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- BOX 4 END -->

      <!-- BOX 5-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-fw fa-object-ungroup"></i></span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Duplicate<br>Certificate  </font> </h4>  <br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- BOX 5 END -->

      <!-- BOX 6-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-fw fa-paper-plane"></i></span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Alteration of<br>Vessel  </font> </h4>  <br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- BOX 6 END -->

      <!-- BOX 7-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
      <span class="info-box-icon bg-maroon"><i class="fa fa-fw  fa-quote-right"></i> </span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Tab 7  </font> </h4>  <br><br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- BOX 7 END -->

      <!-- BOX 8-->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
      <span class="info-box-icon bg-maroon"><i class="fa fa-fw  fa-quote-right"></i> </span>
      <div class="info-box-content bg-default">
      <span class="info-box-text"> <h4> <font color="#0000ff"> Tab8  </font> </h4>  <br><br></span>
      </div>
      <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- BOX 8 END -->

    <!-- End of inside Div -->

    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- ./box-body -->



          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- PANEL ROW END -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->