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
<?php 
        if($this->session->flashdata('msg'))
          {
            echo $this->session->flashdata('msg');
          }
        ?>
         <?php 
          $attributes = array("class" => "form-horizontal", "id" => "tariff_view", "name" => "tariff_view" , "novalidate");
          
          if(isset($editres)){
                echo form_open("Kiv_Ctrl/Master/dynamic_form", $attributes);
          } else {
            echo form_open("Kiv_Ctrl/Master/viewTariff", $attributes);
       }?>
<div class="container-fluid ui-innerpage">
    <div class="row pt-2">
    <div class="col-6">
      <span class="badge bg-darkmagenta innertitle ">View Tariff Details</span>
    </div> <!-- end of col6 -->
    <div class="col-6 d-flex justify-content-end">
     <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end">
           <li><a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/MasterHome"?>"><i class="fas fa-home"></i>&nbsp; Home</a></li>
        </ol>
      </nav>
    </div> <!-- end of col6 -->
  </div> <!-- end of row -->
  <div class="row pt-2">
        <div class="col-6 d-flex justify-content-start"> 
          <button type="button" class="btn btn-primary btn-flat btn-point" data-toggle="modal" data-target="#instruction_modal">Instructions for adding Tariff details</button>
        </div>
        <div class="col-6 d-flex justify-content-end">
              <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/addTariff"?>" class="btn btn-success btn-flat btn-point"><i class="fas fa-plus-circle"></i>&nbsp; Add Tariff Details</a>
        </div> <!-- end of col6 -->
        <div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div> 
        <div class="col-12" id="tariff_view_msgDiv" style="display:none;"></div>
      </div> <!-- end of row -->
<div class="row pt-2">
  <div class="col-12 d-flex justify-content-center">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
          <tr>
            <th>Sl.No</th>
            <th>Activity</th>
            <th>Form Name</th>
            <th>Vessel Type Name</th>
            <th>Vessel Sub Type Name</th>
            <th>Date</th>
            <th>View</th>
          </tr>
      </thead>

      <tbody>
         <?php $i=1; foreach ($tariff_list as $tariff_value) {
               $id=$tariff_value['tariff_sl'];
               $activity_id=$tariff_value['tariff_activity_id'];
               $form_id=$tariff_value['tariff_form_id'];
               $vessel_type_id=$tariff_value['tariff_vessel_type_id'];
               $vessel_subtype_id=$tariff_value['tariff_vessel_subtype_id'];
               $start_date=$tariff_value['start_date'];
               $end_date=$tariff_value['end_date'];
               $survey_name=$tariff_value['survey_name'];
               $form_name=$tariff_value['document_type_name'];
               $vesseltype_name=$tariff_value['vesseltype_name'];
               $vessel_subtype_name=$tariff_value['vessel_subtype_name'];
               $start_date_view  = explode('-', $start_date);
               @$start_date_view  = $start_date_view[2]."/".$start_date_view[1]."/".$start_date_view[0];

                if(!empty($end_date))
                {
                   $end_date_view  = explode('-', $end_date);
                               @$end_date_view  = $end_date_view[2]."/".$end_date_view[1]."/".$end_date_view[0];
                }
                else
                {
                  $end_date_view="";
                }
         ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $survey_name; ?></td>
            <td><?php echo $form_name; ?></td>
            <td><?php echo $vesseltype_name; ?></td>
            <td><?php echo $vessel_subtype_name; ?></td>
            <?php if($tariff_value['end_date']=='0000-00-00'){$msg="dd/mm/yyyy";}else{$msg=$end_date_view;} ?>
            <td><?php echo "From ".$start_date_view." To ".$msg; ?><input type="hidden" name="hid_startDate" id="hid_startDate" value="<?php echo $start_date; ?>"><input type="hidden" name="hid_endDate" id="hid_endDate" value="<?php echo $end_date; ?>"></td>            
            <td>                
                <a class="no-link" href="<?php echo $site_url."/Kiv_Ctrl/Master/detViewTariff/$activity_id/$form_id/$vessel_type_id/$vessel_subtype_id/$start_date/$end_date"?>">
                <button name="edit_dynamic_page_btn_<?php echo $i;?>" id="edit_bank_btn_<?php echo $i;?>" class="btn btn-sm bg-blue btn-flat" type="button" >   <i class="fa fa-fw fa-plus-circle"></i>  </button>
                </a>
            </td>           
          </tr>
        <?php $i++;} ?>
      </tbody>
      <tfoot>
          <tr>
            <th>Sl.No</th>
            <th>Activity</th>
            <th>Form Name</th>
            <th>Vessel Type Name</th>
            <th>Vessel Sub Type Name</th>
            <th>Date</th>
            <th>View</th>
          </tr>
      </tfoot>
</table>
  </div> <!-- end of col12 -->
</div> <!-- end of row -->
</div> <!-- end of container fluid -->
<!-- ---------------------------------------------------------- Modal Window starts Here -------------------------------------------- -->
      <!-- The Modal -->
<div class="modal" id="instruction_modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">രജിസ്ട്രേഷൻ  ഫോം പൂരിപ്പിക്കുന്നതിനുള്ള നിർദ്ദേശങ്ങൾ  </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> <!-- ene of modal header -->
      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
  <div class="col-12"> <p class="text-danger"> <em> <strong>
    വിവരങ്ങൾ ഇംഗ്ളീഷിൽ മാത്രം പൂരിപ്പിക്കുക.</strong> </em> </p>
  </div> <!-- end of col -->
  <div class="col-2">
    Name 
  </div> <!-- end of col6 -->
  <div class="col-10">
    ഉടമയുടെ പേര് ടൈപ്പ് ചെയ്യുക. കുത്ത്, കോമ എന്നിവ ഉപയോഗിക്കാതിരിക്കുക. <hr>
  </div> <!-- end of col6 -->
  <div class="col-2">
  Date of birth </div>
  <div class="col-10">
    ഉടമയുടെ ജനനത്തീയ്യതി.  18 വയസ്സിന് താഴെയുള്ള ഉടമകൾ, രക്ഷിതാവിന്റെ വിവരങ്ങൾ അടുത്ത് ഫോമിൽ ചേർക്കേണ്ടതാണ്.  <hr>
  </div>
  <div class="col-2"> Mobile</div>
  <div class="col-10"> 
    നിങ്ങളുടെ 10 അക്ക മൊബൈൽ നമ്പർ നൽകുക. എല്ലാ വിവരങ്ങളും നിർദ്ദേശങ്ങളും ഈ മൊബൈൽ നമ്പറിൽ എസ്.എം.എസ് ആയി ലഭിക്കുന്നതാണ്. <hr>
  </div>
  <div class="col-2"> Email Id</div>
  <div class="col-10"> നിങ്ങളുടെ ഈമെയിൽ ഐഡി നൽകുക.
  എല്ലാ വിവരങ്ങളും നിർദ്ദേശങ്ങളും നിങ്ങൾ കൊടുത്തിരിക്കുന്ന ഈമെയിൽ ഐഡിയിൽ അലർട്ട് ആയി ലഭിക്കുന്നതാണ്. <hr>
  </div>
  <div class="col-2"> State</div>
  
  <div class="col-10"> 
    നിങ്ങളുടെ മേൽവിലാസം ഉൾപ്പെടുന്ന സംസ്ഥാനം തിരഞ്ഞെടുക്കുക. <hr>
  </div>
  <div class="col-2"> District</div>
  
  <div class="col-10"> 
    നിങ്ങളുടെ മേൽവിലാസം ഉൾപ്പെടുന്ന ജില്ല തിരഞ്ഞെടുക്കുക. <hr>
  </div>
  <div class="col-2"> Address</div>
  <div class="col-10"> 
    നിങ്ങളുടെ മേൽവിലാസം നൽകുക. മേൽവിലാസം ടൈപ്പ് ചെയ്യുമ്പോൾ  ഇംഗ്ളീഷ് അക്ഷരങ്ങൾ അക്കങ്ങൾ / (‌ ) , - . എന്നിവ മാത്രം ഉപയോഗിക്കുക. <hr> 
  </div>
  <div class="col-2"> Occupation address</div>
  <div class="col-10"> 
    നിങ്ങളുടെ ഔദ്യോഗിക മേൽവിലാസം നൽകുക. മേൽവിലാസം ടൈപ്പ് ചെയ്യുമ്പോൾ  ഇംഗ്ളീഷ് അക്ഷരങ്ങൾ അക്കങ്ങൾ / (‌ ) , - . എന്നിവ മാത്രം ഉപയോഗിക്കുക. <hr>
  </div>
  <div class="col-2"> Occupation</div>
  <div class="col-10"> 
    നിങ്ങളുടെ ഉദ്യോഗം തിരഞ്ഞെടുക്കുക. ലിസ്റ്റ് ചെയ്തവയിൽ നിങ്ങളുടെ ഉദ്യോഗം കാണുന്നില്ലെങ്കിൽ  Others എന്ന് തിരഞ്ഞെടുക്കുക. <hr>
  </div>
  <div class="col-2"> Do you have an agent ?</div>
  <div class="col-10">
    നിങ്ങൾ ഏജന്റ് മുഖേനയാണ് രജിസ്ട്രേഷനും മറ്റ് നടപടികളും നടത്തുന്നതെങ്കിൽ Do you have an agent എന്നത് സെലക്ട് ചെയ്യുക. 
    ഏജന്റിന്റെ വിവരങ്ങൾ അടുത്ത ഫോമിൽ ചേർക്കാവുന്നതാണ്. <hr>
   </div>
  <div class="col-2"> Do you co-owners ?</div>
  <div class="col-10"> 
    നിങ്ങൾക്ക് സഹഉടമകളുണ്ടെങ്കിൽ, Do you have co-owners എന്നത് സെലക്ട് ചെയ്യുക. തുടർന്ന് എത്ര സഹ ഉടമകൾ ഉണ്ടെന്ന് രേഖപ്പെടുത്തുക. <hr>
  </div>
  <div class="col-2"> Number of co-owner(s)</div>
  <div class="col-10"> 
    എത്ര സഹ ഉടമകൾ ഉണ്ടെന്ന് രേഖപ്പെടുത്തുക. 1 മുതൽ 8 സഹ ഉടമകളെ നിങ്ങൾക്ക് ചേർക്കാം. സഹഉടമകളുടെ വിവരങ്ങൾ അടുത്ത ഫോമിൽ രേഖപ്പെടുത്താവുന്നതാണ്. <hr>
  </div>
  <div class="col-2"> Identity Card</div>
  <div class="col-10"> 
    നിങ്ങളുടെ തിരിച്ചറിയൽ രേഖ തിരഞ്ഞെടുക്കുക. <hr>
  </div>
  <div class="col-2"> Identity Card number</div>
  <div class="col-10"> 
    നിങ്ങളുടെ തിരിച്ചറിയിൽ കാർഡിലെ നമ്പർ രേഖപ്പെടുത്തുക. ആധാർ ആണ് നൽകുന്നതെങ്കിൽ 12 അക്കം മാത്രം ടൈപ്പ് ചെയ്യുക. ഉദാഹരണം: 123412341234 <hr>
  </div>
  <div class="col-2">Upload Photograph </div>
  <div class="col-10"> 
    നിങ്ങളുടെ ഫോട്ടോഗ്രാഫ് അപ്‌‌ലോഡ് ചെയ്യുക. jpg/jpeg/png എന്നീ ഫോർമാറ്റിലുള്ള ഫോട്ടോകൾ മാത്രം അപ്‌‌ലോഡ് ചെയ്യുക. ചിത്രങ്ങളുടെ പരമാവധി സൈസ് : 50kbയിൽ താഴെ മാത്രം.
ചിത്രത്തിന്റെ നീളം  പരമാവധി 350 പിക്സലും വീതി പരമാവധി 150 പിക്സലും മാത്രം. <br>
നിങ്ങളുടെ ഫോട്ടോഗ്രാഫ് വലിയ സൈസിൽ ഉള്ളതാണെങ്കിൽ   <a href="http://registration.cdit.org" target="_blank" class="btn btn-outline-success btn-sm"> Click here for resizing larger images </a> എന്ന ലിങ്ക് ക്ളിക്ക് ചെയ്യുക. തുടർന്ന് വരുന്ന സൈറ്റ് സന്ദർശിക്കുക എന്നിട്ട് നിങ്ങളുടെ ഫോട്ടോ അവിടെ അപ്‌‌ലോഡ് ചെയ്തിട്ട് ഇമേജ് റീസൈസ് ചെയ്ത് ചെറുതാക്കുക. ആ ഇമേജ് ഡൗൺലോഡ് ചെയ്യുക. തുടർന്ന് റീസൈസ് ചെയ്ത് ചെറുതാക്കിയ ഇമേജ് ഇവിടെ അപ്‌‌ലോഡ് ചെയ്യുക.<hr>
  </div>
  <div class="col-2"> Upload Identity Card</div>
  <div class="col-10"> 
    നിങ്ങളുടെ തിരിച്ചറിയൽ കാർഡ് അപ്‌‌ലോഡ് ചെയ്യുക. തിരിച്ചറിയിൽ കാർഡിന്റെ ഫോർമാറ്റ് PDFൽ മാത്രം അപ്‌‌ലോഡ് ചെയ്യുക.
തിരിച്ചറിയൽ കാർഡിന്റെ അനുവദനീയമായ സൈസ് 1 എം.ബി.ക്ക് താഴെ മാത്രം. <hr>
  </div>
  <div class="col-6">
  </div> <!-- end of col6 -->
  <div class="col-6">
  </div> <!-- end of col6 -->
</div> <!-- end of row -->
      </div> <!-- end of modal body -->
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> <!-- end of modal footer -->
    </div> <!-- end of modal content -->
  </div> <!-- end of modal dialog -->
</div> <!-- end of modal div -->
<!-- ---------------------------------------------------------- Modal Window ends Here -------------------------------------------- -->