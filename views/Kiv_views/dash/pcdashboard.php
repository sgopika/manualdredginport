
<!-- Container Class overridden for edge free design -->
<div class="main-content">  
  <div class="row no-gutters">
  <div class="col-2 ui-color"> 
    <div class="row">
      <div class="col-12 text-primary kivheader">
        <button type="button" class="btn btn-primary btn-block kivbutton"><i class="fas fa-ship"></i> Kerala Inland Vessel</button>
      </div> <!-- end of col012 text-primary kiv-header -->
      <div class="col-12">
      <ul class="list-group ui-color">

    <a href="#" class="list-group-item list-group-item-action text-primary" id="inbox_link">
    <i class="fas fa-inbox"></i> Requests <span class="badge badge-info badge-pill"><?php echo @$count; ?></span>
    </a>

   <!--  <a href="<?php //echo $site_url.'/Bookofregistration/form13List_pc' ?>" class="list-group-item list-group-item-action text-primary" id="inbox_link">
    <i class="fas fa-inbox"></i> Registration Requests <span class="badge badge-info badge-pill"><?php //echo @$count; ?></span>
    </a>
 -->

    <a href="<?php echo $site_url.'/Kiv_Ctrl/Survey/listapproved_payment' ?>" class="list-group-item list-group-item-action text-primary" id="activities_link">
    <i class="fas fa-bookmark"></i> Approved payment <span class="badge badge-info badge-pill"><?php echo @$count_payment; ?></span>
    </a>
<!--
    <a href="#" class="list-group-item list-group-item-action text-primary" id="surveyor_link">
    <i class="fas fa-chalkboard-teacher"></i> link3 <span class="badge badge-info badge-pill"></span>
    </a>
            
    <a href="#" class="list-group-item list-group-item-action text-primary" id="memo_link">
    <i class="fas fa-poll-h"></i>link4<span class="badge badge-info badge-pill"></span>
    </a>

    <a href="#" class="list-group-item list-group-item-action text-primary" id="form4_link">
    <i class="fas fa-receipt"></i> link5<span class="badge badge-info badge-pill"></span>
    </a>
     
    <a href="#" class="list-group-item list-group-item-action text-primary" id="book_link">
    <i class="fas fa-server"></i> link6<span class="badge badge-info badge-pill"></span>
    </a>
  -->

      </ul> 
      </div> <!-- end oc col-12  inside row -->
      </div> <!-- end of row inside col-2 -->
      </div> <!-- end of col-2 -->

  <div class="col-10">
    <div class="row no-gutters">

  <!--     <div class="col-12" id="request_div">
      <?php  //include 'pc_datajquery.php'; ?>
      </div>  -->

      <div class="col-12" id="profile_div">
      <?php  include 'pcprofile.php'; ?>
      </div> <!-- end of col-12 wrapping profile -->

    </div> <!-- end of row no-guter 2nd -->
  </div> <!-- end of col-10 -->

  </div> <!-- end of row no-gutter 1st -->
  <div class="row no-gutters">
    <div class="col-12"> 
      <div class="card">
 



</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of another row -->

<div class="row">
  <div class="col-12">
    <div class="card">
 <!--  <div class="card-header text-primary">
   <i class="fas fa-stamp"></i> Surveys
  </div> -->
  <div class="card-body layoutcolor">
    <div class="row">
     
     <!--
      <div class="col-3">
    <div class="row no-gutters widgetcolor">
      <div class="col-3 border-right border-white iconcol d-flex justify-content-center align-items-center">
       <i class="far fa-flag"></i>
      </div> 
      <div class="col-9">
        <div class="row no-gutters">
          <div class="col-12 border-bottom border-white d-flex justify-content-left align-items-center widgetmain">
            &nbsp; &nbsp; Initial Survey 
          </div> 
          <div class="col-12 d-flex justify-content-left align-items-center widgetsec">
            &nbsp; &nbsp; Requests &nbsp; &nbsp; <span class="badge badge-secondary badge-pill">0</span> 
          </div> 
        </div> 
      </div>
    </div> 
  </div> 
  
  
      <div class="col-3">
    <div class="row no-gutters widgetcolor">
      <div class="col-3 border-right border-white iconcol d-flex justify-content-center align-items-center">
       <i class="fas fa-anchor"></i>
      </div> 
      <div class="col-9">
        <div class="row no-gutters">
          <div class="col-12 border-bottom border-white d-flex justify-content-left align-items-center widgetmain">
            &nbsp; &nbsp; Annual Survey 
          </div> 
          <div class="col-12 d-flex justify-content-left align-items-center widgetsec">
            &nbsp; &nbsp; Requests &nbsp; &nbsp; <span class="badge badge-secondary badge-pill">0-</span> 
          </div> 
        </div> 
      </div> 
    </div> 
  </div> 


      <div class="col-3">
    <div class="row no-gutters widgetcolor">
      <div class="col-3 border-right border-white iconcol d-flex justify-content-center align-items-center">
        <i class="fas fa-eraser"></i>
      </div> 
      <div class="col-9">
        <div class="row no-gutters">
          <div class="col-12 border-bottom border-white d-flex justify-content-left align-items-center widgetmain">
            &nbsp; &nbsp; Drydock Survey 
          </div> 
          <div class="col-12 d-flex justify-content-left align-items-center widgetsec">
           &nbsp; &nbsp; Requests &nbsp; &nbsp; <span class="badge badge-secondary badge-pill">0-</span> 
          </div> 
        </div> 
      </div> 
    </div> 
  </div> 


      <div class="col-3">
    <div class="row no-gutters widgetcolor">
      <div class="col-3 border-right border-white iconcol d-flex justify-content-center align-items-center">
       <i class="far fa-compass"></i>
      </div> 
      <div class="col-9">
        <div class="row no-gutters">
          <div class="col-12 border-bottom border-white d-flex justify-content-left align-items-center widgetmain">
            &nbsp; &nbsp; Special Survey 
          </div> 
          <div class="col-12 d-flex justify-content-left align-items-center widgetsec">
            &nbsp; &nbsp; Requests &nbsp; &nbsp; <span class="badge badge-secondary badge-pill">0-</span> 
          </div> 
        </div> 
      </div> 
    </div> 
  </div> 
-->

    <div> <!-- end of card-body -->
</div> <!-- end of card -->
  </div> <!-- end of col-12 -->
</div> <!-- end of 5th row -->
<div class="row nogutters">
<div class="col-12">
<div class="card">
 <!--  <div class="card-header text-primary">
   <i class="fas fa-search"></i> Search &amp; Reports
  </div> -->

<!--   <div class="card-body layoutcolor">
    <div class="row  ">
          <div class="col-3">
          <button type="button" class="btn btnwidget1 btn-block btn-lg"><i class="fas fa-wrench"></i>
          Initial Completed</button>
          </div>
          <div class="col-3">
          <button type="button" class="btn btnwidget2 btn-block btn-lg"><i class="fas fa-toggle-on"></i>
          Annual Completed</button>
          </div>
          <div class="col-3">
          <button type="button" class="btn btnwidget3 btn-block btn-lg"><i class="fab fa-steam-symbol"></i>
          Drydock Completed</button>
          </div>
          <div class="col-3">
          <button type="button" class="btn btnwidget4 btn-block btn-lg"> <i class="fab fa-wpforms"></i>
           Custom Reports </button>
          </div>
    </div> 
  </div>  -->


</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of 6th row -->
<div class="row nogutters">
<div class="col-12">
<div class="card">
  <div class="card-header text-primary">
    <div class="row no-gutters">
    <div class="col-3">
   <i class="fas fa-project-diagram"></i> Utilities
 </div>
 <div class="col-9 d-flex justify-content-end">
  Tariff &nbsp;&nbsp;|&nbsp;&nbsp; Payments &nbsp;&nbsp;|&nbsp;&nbsp; Communication &nbsp;&nbsp;|&nbsp;&nbsp; Registered Vessels &nbsp;&nbsp;|&nbsp;&nbsp; Timeline
 </div>
</div>
  </div>
</div> <!-- end of card -->
</div> <!-- end of col-12 -->
</div> <!-- end of 7th row -->
</div> <!-- end of container div -->