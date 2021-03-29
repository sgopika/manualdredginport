<div class="main-content ui-innerpage">  
  <div class="row no-gutters ui-color">
    <div class="col-2 text-primary kivheader">
        <button type="button" class="btn btn-primary btn-block kivbutton">Kerala Maritime Board</button>
      </div> <!-- end of col2 text-primary kiv-header -->
      <div class="col-10 d-flex justify-content-end">
          <a href="#" class="btn btn-primary btn-point btn-sm my-1 mr-5 align-middle "> <i class="fas fa-unlock-alt"></i> &nbsp; Change Password </a> 
      </div> <!-- end of col10 -->
  </div> <!-- end of main row -->
  <!-- --------------------------- Start of Dash board for PC  --------------------------------------------- -->
  <!-- start of inside content -->
<div class="row no-gutters">
  <div class="col-12 ">
    <div class="card">
      <div class="card-header  bg-blue">
        <i class="fas fa-tachometer-alt "></i>&nbsp; <em class="h6 ">  Port Conservator Dashboard</em>
      </div> <!-- end of card header -->
      <div class="card-body alert-light">
        
        <div class="row no-gutters ">
          <!-- col-3 -->
          <div class="col-3 d-flex justify-content-center">
            <div class="card" >
              <div class="card-body py-5">
                <div id="img " class="text-center text-primary  "><i class="fas fa-truck-moving h2 "></i> </div>
                <div id="textpart " class="text-center mt-2 ">  <a href="<?php echo base_url()."index.php/Kiv_Ctrl/Survey/pcdredginghome"?>" class="btn btn-block btn-lidefaultght btn-sm bg-blue">  Manual Dredging </a> 
                </div>
            </div> <!-- end of card body py-5 -->
          </div>
          </div> <!-- end of col-3 -->
          <!-- ./col-3 -->
          <!-- col-3 -->
          <div class="col-3 d-flex justify-content-center">
            <div class="card" >
              <div class="card-body py-5">
              <div id="img " class="text-center text-primary ">   <i class="fas fa-water h2"></i>  </div>
                <div id="textpart " class="text-center mt-2 ">  <a href="<?php echo base_url()."index.php/Kiv_Ctrl/Survey/pckivhome"?>" class="btn btn-block btn-default btn-sm bg-blue">  Kerala Inland Vessel  </a> 
                </div>
            </div> <!-- end of card body py-5 -->
          </div>
          </div> <!-- end of col-3 -->
          <!-- ./col-3 -->
          <!-- col-3 -->
          <div class="col-3 d-flex justify-content-center">
            <div class="card" >
              <div class="card-body py-5">
              <div id="img " class="text-center text-primary "><i class="fas fa-ship h2"></i></div>
                <div id="textpart " class="text-center mt-2 ">  <a href="" class="btn btn-block btn-default btn-sm  bg-blue">  Landing & Shipping </a> 
                </div>
            </div> <!-- end of card body py-5 -->
          </div>
          </div> <!-- end of col-3 -->
          <!-- ./col-3 -->
          <!-- col-3 -->
          <div class="col-3 d-flex justify-content-center">
            <div class="card" >
              <div class="card-body py-5">
              <div id="img " class="text-center text-primary "> <i class="fas fa-window-restore h2"></i> </div>
                <div id="textpart " class="text-center mt-2 ">  <a href="" class="btn btn-block btn-default btn-sm  bg-blue">  Competency </a> 
                </div>
            </div> <!-- end of card body py-5 -->
          </div>
          </div> <!-- end of col-3 -->
          <!-- ./col-3 -->
        </div> <!-- end of row -->
      </div> <!-- end of card body -->
    </div> <!-- end of card -->
  </div> <!-- end of col-12 -->
</div> <!-- end of row -->
<!-- end of inside content -->
<!-- ---------------------------------- start of accordion div -- ---------------------------------------------------------- -->
<div class="row px-2">
  <div class="col-12 my-2 pl-5">
    <p class="h5 text-primary">  <i class="fas fa-exclamation-circle "></i>     Notifications </p>
  </div> <!-- end of col12 -->
  <div class="col-12">
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Manual Dredging
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <div class="alert alert-primary" role="alert">
          A simple primary alert—check it out!
        </div>
        <div class="alert alert-secondary" role="alert">
          A simple secondary alert—check it out!
        </div>
        <div class="alert alert-success" role="alert">
          A simple success alert—check it out!
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Kerala Inland Vessel
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
              <div class="alert alert-danger" role="alert">
        A simple danger alert—check it out!
      </div>
      <div class="alert alert-warning" role="alert">
        A simple warning alert—check it out!
      </div>
      <div class="alert alert-info" role="alert">
        A simple info alert—check it out!
      </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Landing &amp; Shipping
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
          <!--- -->
          <div class="alert alert-primary" role="alert">
          A simple danger alert—check it out!
        </div>
        <div class="alert alert-warning" role="alert">
          A simple warning alert—check it out!
        </div>
        <div class="alert alert-dark" role="alert">
          A simple info alert—check it out!
        </div>
      </div>
    </div>
  </div>
</div>
</div> <!-- end of col12 -->
</div> <!-- end of row -->
<!-- ---------------------------------- End  of accordion div -- ---------------------------------------------------------- -->
  <!-- --------------------------- End of Dash board for PC  ----------------------------------------------- -->
</div> <!-- end of main-content container -->