<?php
 //----------- Vessel Details -----------//

if(!empty($vessel_details)) {
  $vessel_sl=$vessel_details[0]['vessel_sl'];
}
else
{
  $vessel_sl="";
}
if(!empty($vessel_sl))
{


$slt_processflow          = $this->Survey_model->get_processflow_timeline($vessel_sl);
$data['slt_processflow']  = $slt_processflow;
?>

<?php 
if(!empty($slt_processflow))
{
  $vessel_id             = $slt_processflow[0]['vessel_id'];
  $vessel_details_viewpage           = $this->Survey_model->get_vessel_details_viewpage($vessel_id);
  $data['vessel_details_viewpage']  = $vessel_details_viewpage;
  foreach($vessel_details_viewpage as $res_vessel)
  {
    $vessel_name                =     $res_vessel['vessel_name'];
    $vessel_survey_number       =     $res_vessel['vessel_survey_number'];
    $official_number            =     $res_vessel['official_number'];
    $reference_number           =     $res_vessel['reference_number'];
    @$vessel_registry_port_id   =     $res_vessel['vessel_registry_port_id'];
    @$plying_limit              =     $res_vessel['plying_limit'];
    @$vessel_gross_tonnage      =     $res_vessel['grt'];
    @$vessel_net_tonnage        =     $res_vessel['nrt'];
    $vessel_registration_number =     $res_vessel['vessel_registration_number'];
    $vessel_length              =     $res_vessel['vessel_length'];
    $vessel_breadth             =     $res_vessel['vessel_breadth'];
    $vessel_depth               =     $res_vessel['vessel_depth'];
    $vessel_yearofbuilt         =     $res_vessel['vessel_expected_completion'];
    $operation_area             =     $res_vessel['area_of_operation'];
    @$cargo_nature              =     $res_vessel['cargo_nature'];
    $sewage_treatment           =     $res_vessel['sewage_treatment'];
    $solid_waste                =     $res_vessel['solid_waste'];
    $sound_pollution            =     $res_vessel['sound_pollution'];
    $stability_test_status_id   =     $res_vessel['stability_test_status_id'];
    $lower_deck_passenger       =     $res_vessel['lower_deck_passenger'];
    $upper_deck_passenger       =     $res_vessel['upper_deck_passenger'];
    $four_cruise_passenger      =     $res_vessel['four_cruise_passenger'];
    $first_aid_box              =     $res_vessel['first_aid_box'];
    $condition_of_equipment     =     $res_vessel['condition_of_equipment'];
    $repair_details_nature      =     $res_vessel['repair_details_nature'];
    $validity_fire_extinguisher1=     $res_vessel['validity_fire_extinguisher'];
    $validity_of_insurance1     =     $res_vessel['validity_of_insurance'];
    $validity_of_certificate1   =     $res_vessel['validity_of_certificate'];
    $form10_remarks             =     $res_vessel['form10_remarks'];
    $validity_fire_extinguisher =     date("d-m-Y", strtotime($validity_fire_extinguisher1));
    //$validity_of_insurance      =     date("d-m-Y", strtotime($validity_of_insurance1));
    $validity_of_certificate    =     date("d-m-Y", strtotime($validity_of_certificate1));
    $vessel_category_id         =     $res_vessel['vessel_category_id'];
    $vessel_subcategory_id      =     $res_vessel['vessel_subcategory_id'];
    $vessel_type_id             =     $res_vessel['vessel_type_id'];
    $vessel_subtype_id          =     $res_vessel['vessel_subtype_id'];
    @$owner_id                  =     $res_vessel['user_id'];
    
   //_________________Get customer name and address_____________________//
    $customer_details=$this->Survey_model->get_customer_details($owner_id);
    $data['customer_details']=$customer_details;
    if(!empty($customer_details)) 
    {
      foreach($customer_details as $res_owner)
      {
        $owner_name     = $res_owner['user_name'];
        $owner_address  = $res_owner['user_address'];
        $owner_phone  = $res_owner['user_master_ph'];
        $owner_email  = $res_owner['user_master_email'];
      }
    }
    else
    {
      $owner_name   ="";
      $owner_address  ="";
    }

    if($validity_fire_extinguisher=='01-01-1970')
    {
      $validity_fire_extinguisher="-";
    }
    else
    {
      $validity_fire_extinguisher=$validity_fire_extinguisher;
    }
    /*if($validity_of_insurance=='01-01-1970')
    {
      $validity_of_insurance="-";
    }
    else
    {
      $validity_of_insurance=$validity_of_insurance;
    }*/
    if($validity_of_certificate=='01-01-1970')
    {
      $validity_of_certificate="-";
    }
    else
    {
      $validity_of_certificate=$validity_of_certificate;
    }
    //_________________Get port of registry name________________//
    if(!empty($vessel_registry_port_id))
    {
      $portofregistry          =   $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
      $data['portofregistry']  =   $portofregistry;
      $portofregistry_name     =   $portofregistry[0]['vchr_portoffice_name'];
    }
    else
    {
      $portofregistry_name="";
    }
    //_________________Get vessel category name________________//
    if($vessel_category_id!=0)
    {
      $vessel_category_id       =   $this->Survey_model->get_vessel_category_id($vessel_category_id);
      $data['vessel_category_id']   = $vessel_category_id;
      $vessel_category_name     = $vessel_category_id[0]['vesselcategory_name'];
    }
    else
    {
      $vessel_category_name='';
    }
    //_________________Get vessel sub category name________________//
    if($vessel_subcategory_id!=0)
    {
      $vessel_subcategory_id      =   $this->Survey_model->get_vessel_subcategory_id($vessel_subcategory_id);
      $data['vessel_subcategory_id']  = $vessel_subcategory_id;
      @$vessel_subcategory_name   = $vessel_subcategory_id[0]['vessel_subcategory_name'];
    }
    else
    {
      $vessel_subcategory_name='';
    }
    //_________________Get vessel type name________________//
    if($vessel_type_id!=0)
    {
      $vessel_type_id       =   $this->Survey_model->get_vessel_type_id($vessel_type_id);
      $data['vessel_type_id']   = $vessel_type_id;
      $vesseltype_name      = $vessel_type_id[0]['vesseltype_name'];
    }
    else
    {
      $vesseltype_name='';
    }
    //_________________Get vessel sub type name________________//  
    if($vessel_subtype_id!=0)
    {
      $vessel_subtype_id      =   $this->Survey_model->get_vessel_subtype_id($vessel_subtype_id);
      $data['vessel_subtype_id']  = $vessel_subtype_id;
      $vessel_subtype_name    = $vessel_subtype_id[0]['vessel_subtype_name'];
    }
    else
    {
      $vessel_subtype_name='';
    }
    //_____________________get initial survey date_____________________________//
    $process_id1=1;
    $initial_survey_id1=1;
    $initial_survey_done=$this->Survey_model->get_survey_done_vessel($process_id1,$initial_survey_id1,$vessel_id);
    $data['initial_survey_done']  = $initial_survey_done;
    if(!empty($initial_survey_done))
    {
      $actual_date=date("d-m-Y", strtotime($initial_survey_done[0]['actual_date']));
    }
    else
    {
      $actual_date="";
    }
    //_____________get vessel main______________________//
    $vessel_main=$this->Survey_model->get_vessel_main($vessel_id);
    $data['vessel_main']  = $vessel_main;
    if(!empty($vessel_main))
    {
      $vesselmain_reg_date=date("d-m-Y", strtotime($vessel_main[0]['vesselmain_reg_date']));
      $next_reg_renewal_date=date("d-m-Y", strtotime($vessel_main[0]['next_reg_renewal_date']));
      $vesselmain_annual_date=date("d-m-Y", strtotime($vessel_main[0]['vesselmain_annual_date']));
      $vesselmain_drydock_date=date("d-m-Y", strtotime($vessel_main[0]['vesselmain_drydock_date']));
    }
    //_____________________get next annual survey date_____________________________//
    $process_id1=1;
    $subprocess_id2=2;
    $next_annual_details=$this->Survey_model->get_vessel_timeline_nextdate($vessel_id,$process_id1,$subprocess_id2);
    $data['next_annual_details']  = $next_annual_details;
    if(!empty($next_annual_details))
    {
      $next_annual_date=date("d-m-Y", strtotime($next_annual_details[0]['scheduled_date']));
    }
    else
    {
      $next_annual_date="";
    }
   //_____________________get next drydock survey date_____________________________//
    $process_id1=1;
    $subprocess_id3=3;
    $next_drydock_details=$this->Survey_model->get_vessel_timeline_nextdate($vessel_id,$process_id1,$subprocess_id3);
    $data['next_drydock_details']  = $next_drydock_details;
    if(!empty($next_drydock_details))
    {
      $next_drydock_date=date("d-m-Y", strtotime($next_drydock_details[0]['scheduled_date']));
    }
    else
    {
      $next_drydock_date="";
    }
    //_____________________get pcb date_____________________________//
    $pollution_details=$this->Survey_model->get_vessel_pollution($vessel_id);
    $data['pollution_details']  = $pollution_details;
    if(!empty($pollution_details))
    {
      $pcb_reg_date=date("d-m-Y", strtotime($pollution_details[0]['pcb_reg_date']));
      $validity_of_pcb=date("d-m-Y", strtotime($pollution_details[0]['pcb_expiry_date']));
    }
    else
    {
      $pcb_reg_date="";
      $validity_of_pcb="";
    }
        
//_____________________get insurance date_____________________________//
    $insurance_details=$this->Survey_model->get_insurance_details($vessel_id);
    $data['insurance_details']  = $insurance_details;
    if(!empty($insurance_details))
    {
      $vessel_insurance_date=date("d-m-Y", strtotime($insurance_details[0]['vessel_insurance_date']));
      $vessel_insurance_validity=date("d-m-Y", strtotime($insurance_details[0]['vessel_insurance_validity']));
    }
    else
    {
      $vessel_insurance_date="";
      $vessel_insurance_validity="";
    }




  }
 //-----------------Get Namechange Log details----------------//    
  $namechg_dt           =   $this->Vessel_change_model->getnamechange_vessel($vessel_id);
  $data['namechg_dt']   =   $namechg_dt;

  //-----------------Get Ownerchange Log details----------------//    
  $ownerchg_dt          =   $this->Vessel_change_model->getownerchange_vessel($vessel_id);
  $data['ownerchg_dt']  =   $ownerchg_dt;

   //-----------------Get Ownerchange Log details----------------//    
  $transfrvsl_dt        =   $this->Vessel_change_model->gettransfer_vessel($vessel_id);
  $data['transfrvsl_dt']=   $transfrvsl_dt;
  
  //-----------------Get Ownerchange Log details----------------//    
  $dupcert_dt           =   $this->Vessel_change_model->get_dupcert_details($vessel_id);
  $data['dupcert_dt']   =   $dupcert_dt;

   //-----------------Get Renewal of registration Log details----------------//    
  $renewal_dt           =   $this->Vessel_change_model->get_renewal_details($vessel_id);
  $data['renewal_dt']   =   $renewal_dt;
   ?>

   <div class="modal-header bg-tan">
        <h5 class="modal-title text-danger" id="exampleModalLongTitle">Registration Number : <?php echo $vessel_registration_number; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> <!-- end of modal header -->
      <div class="modal-body bg-tanblur">
          <div class="row  no-gutters">
            <div class="col-12 border-white">
              <p class="px-0 text-dark"> Owner Name : <?php echo $owner_name; ?>  </p>
            </div> <!-- end of col12 -->
            <div class="col-12 border-white">
              <p class="pt-2 text-dark"> Vessel Name : <?php echo $vessel_name; ?>  </p>
            </div> <!-- end of col12 -->
            <div class="col-12 border-white">
              <p class="pt-2 text-dark"> Vessel Details : <?php echo $vesseltype_name; ?> - <?php echo $vessel_subtype_name;  ?>, <?php echo $vessel_category_name; ?> - <?php echo $vessel_subcategory_name;  ?>   </p>
            </div> <!-- end of col12 -->
            <div class="col-12 border-white">
              <p class="pt-2 text-dark"> Port of registry: <?php echo $portofregistry_name; ?>, Year of built: <?php echo $vessel_yearofbuilt;  ?> </p>
            </div> <!-- end of col12 -->  
            </div> <!-- end of row -->
            <div class="row no-gutters">
            <div class="col-12 ">
              <p class="pt-2 alert-warning"> Certificate details  </p>
            </div> <!-- end of col12 -->
            <div class="col-12 border-white">
               <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col"></th>
                <th scope="col">Previous renewal date</th>
                <th scope="col">Next renewal date</th>
              </tr>
            </thead>
            <tbody>
              <tr class="text-dark">
                <td> Registration </td>
                <td><?php echo $vesselmain_reg_date; ?></td>
                <td><?php echo $next_reg_renewal_date; ?> </td>
              </tr>
              <tr class="text-dark">
                <td> Annual Survey </td>
                <td><?php echo $vesselmain_annual_date; ?></td>
                <td><?php echo $next_annual_date; ?></td>
              </tr>
               <tr class="text-dark">
                <td> Drydock Survey </td>
                <td><?php echo $vesselmain_drydock_date; ?></td>
                <td><?php echo $next_drydock_date; ?> </td>
              </tr>
              <tr class="text-dark">
                <td> Pollution control </td>
                <td><?php echo $pcb_reg_date; ?></td>
                <td><?php echo $validity_of_pcb; ?> </td>
              </tr>
               <tr class="text-dark">
                <td> Insurance </td>
                <td><?php echo $vessel_insurance_date; ?></td>
                <td><?php echo $vessel_insurance_validity; ?> </td>
              </tr>
        

              </tbody>
              </table>
            </div> <!-- end of col12 -->
          </div> <!-- end of row -->

          <div class="row no-gutters">
            <div class="col-12 ">
              <p class="pt-2 alert-warning"> Ownership History  </p>
            </div> <!-- end of col12 -->
            <?php 
            if(!empty($namechg_dt))
            { 
            ?>
            <div class="col-12">
              <p class="pt-2 text-success"> Name change  </p>
            </div>
            <div class="col-12 border-white">
               <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Old Owner of Vessel</th>
                <th scope="col">New Owner of Vessel</th>
                 <th scope="col">w.e.f. date</th>
              </tr>
            </thead>
            <?php 
 
    foreach($namechg_dt as $nmdet ){
      $old_vessel_name  =   $nmdet['old_vessel_name'];
      $new_vessel_name  =   $nmdet['new_vessel_name'];
      $registered_date  =   date("d/m/Y", strtotime($nmdet['registered_date']));
      $approved_date    =   date("d/m/Y", strtotime($nmdet['approved_date']));
?>
            <tbody>
              <tr class="text-dark">
                <td><?php echo $old_vessel_name;?></td>
                <td><?php echo $new_vessel_name;?></td>
                <td><?php echo $approved_date;?></td>
              </tr>
             </tbody>
            <?php 
            } 
            ?>
              </table>
            </div> <!-- end of col12 -->
            <?php
            }
            ?>
<!-- Ownership Change of vessel -->
<?php 
if(!empty($ownerchg_dt))
{ 
?>
            <div class="col-12">
              <p class="pt-2 text-success">Ownership Change of vessel  </p>
            </div>
            <div class="col-12 border-white">
               <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Old Owner of Vessel</th>
                <th scope="col">New Owner of Vessel</th>
                 <th scope="col">w.e.f. date</th>
              </tr>
            </thead>
           <?php 
 //print_r($ownerchg_dt);
//exit;
foreach($ownerchg_dt as $owndet)
{
  $transfer_seller_id  =   $owndet['transfer_seller_id'];
  $trans_seller        =   $this->Vessel_change_model->get_owner($transfer_seller_id);
  if(!empty($trans_seller))
  {
    foreach($trans_seller as $sell_res)
    {
      $seller            =   $sell_res['user_name'];
    }
  }
  else
  {
    $seller            ="";
  }
 
  $transfer_buyer_id   =   $owndet['transfer_buyer_id'];
  $trans_buyer         =   $this->Vessel_change_model->get_owner($transfer_buyer_id);
  
  if(!empty($trans_buyer))
  {
    foreach($trans_buyer as $buy_res)
    {
      $buyer             =   $buy_res['user_name'];
    }
  }
  else
  {
     $buyer             ="";
  }

 
  $registered_date     =   date("d/m/Y", strtotime($owndet['registered_date']));
  $approved_date       =   date("d/m/Y", strtotime($owndet['approved_date']));
  
?>
            <tbody>
              <tr class="text-dark">
                <td><?php echo $seller;?></td>
                <td><?php echo $buyer;?></td>
                <td><?php echo $approved_date;?></td>
              </tr>
             </tbody>
            <?php 
            } 
            ?>
              </table>
            </div> <!-- end of col12 -->
            <?php
            }
            ?>

  <!-- Transfer of vessel -->
<?php 
if(!empty($transfrvsl_dt))
{ 
?>
            <div class="col-12">
              <p class="pt-2 text-success">Transfer of vessel </p>
            </div>
            <div class="col-12 border-white">
               <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Port of Registry From</th>
                <th scope="col">Port of Registry To</th>
                 <th scope="col">w.e.f. date</th>
              </tr>
            </thead>
        <?php 
  //if(!empty($transfrvsl_dt))
  //{  
    foreach($transfrvsl_dt as $trandet ){
      $transfer_type                 =   $trandet['transfer_based_changetype'];
      if($transfer_type==0){
        $transfer_typ                =   "Transfer Outside Kerala";
      } elseif ($transfer_type==1) {
        $transfer_typ                =   "Transfer Within Kerala (Only Port Changes)";
      } elseif ($transfer_type==3) {
        $transfer_typ                =   "Transfer Within Kerala (Both Port and Ownership Changes)";
      }
      $transfer_seller_id            =   $trandet['transfer_seller_id'];
      if($transfer_seller_id!=0){
        $trans_seller                =   $this->Vessel_change_model->get_owner($transfer_seller_id);
        foreach($trans_seller as $sell_res){
          $seller                    =   $sell_res['user_name'];
        }
      } else {
        $seller                      =   '';
      }
      $transfer_buyer_id             =   $trandet['transfer_buyer_id'];
      if($transfer_buyer_id!=0){
        $trans_buyer                 =   $this->Vessel_change_model->get_owner($transfer_buyer_id);
        foreach($trans_buyer as $buy_res){
          $buyer                     =   $buy_res['user_name'];
        }
      } else {
        $buyer                      =   '';
      }
      $transfer_portofregistry_from  =   $trandet['transfer_portofregistry_from'];
      if($transfer_portofregistry_from!=0){
        $portofregistryfm            =   $this->Survey_model->get_registry_port_id($transfer_portofregistry_from);
        foreach($portofregistryfm as $portofregistryfm_res){
          $portofregistryfm_name     =   $portofregistryfm_res['vchr_portoffice_name'];
        }
      } else {
        $portofregistryfm_name       =   '';
      }
      $transfer_portofregistry_to    =   $trandet['transfer_portofregistry_to'];
      if($transfer_portofregistry_to!=0){
        $portofregistryto            =   $this->Survey_model->get_registry_port_id($transfer_portofregistry_to);
        foreach($portofregistryto as $portofregistryto_res){
          $portofregistryto_name     =   $portofregistryto_res['vchr_portoffice_name'];
        }
      } else {
        $portofregistryto_name       =   '';
      }
      $transfer_state                =   $trandet['transfer_state_id'];
      if($transfer_state!=0){
        $transferstate               =   $this->Vessel_change_model->get_state($transfer_state);
        foreach($transferstate as $state_res){
          $state_name                =   $state_res['state_name'];
        }
      } else {
        $state_name                  =   '';
      }
      $registered_date               =   date("d/m/Y", strtotime($trandet['registered_date']));
      $approved_date                 =   date("d/m/Y", strtotime($trandet['approved_date']));
?>
            <tbody>
              <tr class="text-dark">
                <td><?php echo $portofregistryfm_name;?></td>
                <td><?php echo $portofregistryto_name;?></td>
                <td><?php echo $approved_date;?></td>
              </tr>
             </tbody>
            <?php 
            } 
            ?>
              </table>
            </div> <!-- end of col12 -->
            <?php
            }
            ?>          

  <!-- Duplicate Certificate -->
<?php 
if(!empty($dupcert_dt))
{ 
?>
            <div class="col-12">
              <p class="pt-2 text-success">Duplicate Certificate </p>
            </div>
            <div class="col-12 border-white">
               <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col"></th>
                <th scope="col">Duplicate Certificate Type</th>
                 <th scope="col">w.e.f. date</th>
              </tr>
            </thead>
       <?php 
  
    foreach($dupcert_dt as $dupdet ){
      $duplicate_cert_type        =   $dupdet['duplicate_cert_type'];
      $duplicate_cert_issue_date  =   date("d/m/Y", strtotime($dupdet['duplicate_cert_issue_date']));
      
?>
            <tbody>
              <tr class="text-dark">
                <td><?php //echo $portofregistryfm_name;?></td>
                <td><?php if($duplicate_cert_type==1){echo "Certificate of Registration";} else {echo "Book of Registration";}?></td>
                <td><?php echo $duplicate_cert_issue_date;?></td>
              </tr>
             </tbody>
            <?php 
            } 
            ?>
              </table>
            </div> <!-- end of col12 -->
            <?php
            }
            ?>   

  <!-- Renewal of registration -->
<?php 
if(!empty($renewal_dt))
{ 
?>
            <div class="col-12">
              <p class="pt-2 text-success">Renewal of registration </p>
            </div>
            <div class="col-12 border-white">
               <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Reference number</th>
                <th scope="col">Renewal request date</th>
                 <th scope="col">w.e.f. date</th>
              </tr>
            </thead>
       <?php 
    foreach($renewal_dt as $renewal ){
      $ref_number        =   $renewal['ref_number'];
      $registration_renewal_req_date  =   date("d/m/Y", strtotime($renewal['registration_renewal_req_date']));
      $registration_renewal_approve_date = date("d/m/Y", strtotime($renewal['registration_renewal_approve_date']));
?>
            <tbody>
              <tr class="text-dark">
                <td><?php echo $ref_number;?></td>
                <td><?php echo $registration_renewal_req_date; ?></td>
                <td><?php echo $registration_renewal_approve_date;?></td>
              </tr>
             </tbody>
            <?php 
            } 
            ?>
              </table>
            </div> <!-- end of col12 -->
            <?php
            }
            ?>   



         </div> <!-- end of row -->
      </div> <!-- end of modal body -->
  <?php 
} 

}
else
{
  echo "0";
}
?>
