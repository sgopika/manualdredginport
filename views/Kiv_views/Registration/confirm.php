<?php  

$id   = $this->uri->segment(4);
$from = $this->uri->segment(5);
$to = $this->uri->segment(6);
$page= $this->uri->segment(7);

/* $user_name       = $owner_details[0]['user_name'];
 $user_password   = $owner_details[0]['user_password'];*/
 $user_name       = $owner_details[0]['user_master_name'];
$user_password   = $owner_details[0]['user_decrypt_pwd'];


$minor_details       =  $this->Registration_model->get_minor_details($id);
$data['minor_details']   =  $minor_details;

$minor_status    = $minor_details[0]['minor_status'];
$agent_status    = $minor_details[0]['agent_status'];
$co_owner_status = $minor_details[0]['co_owner_status'];
$co_owner_count  = $minor_details[0]['co_owner_count'];




 @$table_count_guardian        = $guardian_count_details[0]['cnt'];
 @$table_count_agent           = $agent_count_details[0]['cnt'];
 @$table_count_coowner         = $co_owner_count_details[0]['cnt'];

/*minor agent coowner
0       0     0
0       0     1
0       1     0
0       1     1

1       0     0
1       0     1
1       1     0
1       1     1

*/


if($page=='ag')
{
  $page_url='Kiv_Ctrl/Registration/NewUser_Registration_agent';
}
if($page=='co')
{
  $page_url='Kiv_Ctrl/Registration/NewUser_Registration_co_owner';
}


    
 ?>

<!-- _____________ Include the above in your HEAD tag _____________-->

<?php 
       /* 1 - owner 2-guardian 3 -agent 4 -coowner
          1  -- 2,3,4,0
          2  -- 3,4,0
          3  -- 4,0 */

       // $from = 2;
        //$to = 3;

        if($from == 1)
         {
           $message = '<div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">Registration Successful!</h4>
        <p>Your application for registering as a vessel owner at Department of Ports, Governmet of Kerala has been completed. Your login credential has been sent to your mobile number and email provided in the first form. <br> Username :'.$user_name.'  <br> Password : '.$user_password.'</p>
        <hr>
        <p class="mb-0">Do not disclose your login credential. Change your password on first login.</p>
        <hr>';
         }
         elseif($from == 2)
         {
          $message = '<div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">Guardian details added!</h4>
        <p> You have successfully added guardian details. You can edit the details after login to the website. </p>
          <hr>';
         }
         elseif($from == 3)
         {
          $message = '<div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">Agent details added!</h4>
        <p> You have successfully added agent details. You can edit the details after login to the website. </p>
          <hr>';
         }
         elseif($from == 4)
         {
          $message = '<div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">Co-owner details added!</h4>
        <p> You have successfully added co-owner details. You can edit the details after login to the website. </p>
          <hr>';
          // Here we have to set to variable to 5 
         }


  



         if($to == 0)
         {
          $message.= ' Please check your email '.@$user_email.' and mobile number'.@$user_mobile_number.' for your login credentials (username and password).<hr> 

         <a class="btn btn-primary btn-flat btn-point" href="'.base_url().'"index.php/Main_login/index"><i class="fas fa-home"></i> Home</a>


      </div> ';
         }
         elseif($to == 2)
         {
          $message.= 'Since you are minor, please enter Guardian details <br>
           <a class="btn btn-primary btn-flat" href="'.base_url().'index.php/Kiv_Ctrl/Registration/NewUser_Registration_guardian"><i class="fas fa-user-plus"></i>Add Guardian Details </a>

           <br><br> Note: You can skip this step, and add Guardian details later by login to the website using the login credentials. <br> <br>


<a class="btn btn-success btn-flat" href="'.base_url().'index.php/'.$page_url.'"><i class="fas fa-forward"></i>Skip this step</a>

           


      </div>';

         }
         elseif($to == 3)
         {
                $message.= 'You have opted for an agent, please enter Agent details. <br> <br>
       <a class="btn btn-primary btn-flat" href="'.base_url().'index.php/Kiv_Ctrl/Registration/NewUser_Registration_agent"><i class="fas fa-user-plus"></i>Add Agent Details </a>


            <br><br> Note: You can skip this step, and add Agent details later by login to the website using the login credentials. <br> <br>



<a class="btn btn-success btn-flat" href="'.base_url().'index.php/'.$page_url.'"><i class="fas fa-forward"></i>Skip this step</a>



      </div>';

         }

         
         elseif($to == 4)
         {
          $message.= 'You have mentioned about '.$co_owner_count.' co-owner(s), Please enter their details. <br> <br> 
         

             <a class="btn btn-primary btn-flat" href="'.base_url().'index.php/Kiv_Ctrl/Registration/NewUser_Registration_co_owner"><i class="fas fa-user-plus"></i>Add Co-owner Details</a>

          <br><br> Note: You can skip this step, and add Co-owner details later by login to the website using the login credentials. You will now be redirected to login page. <br> <br>



          <a class="btn btn-success btn-flat" href="'.base_url().'index.php/Main_login/index"><i class="fas fa-home"></i>&nbsp;Home</a>



      </div>';
         }


          elseif($to == 5)
         {
          $message.= 'You have mentioned about another co-owner too, Please enter their details. <br> <br> 

            <a class="btn btn-primary btn-flat" href="'.base_url().'index.php/Kiv_Ctrl/Registration/NewUser_Registration_co_owner"><i class="fas fa-user-plus"></i>Add Co-owner Details </a>
          
           <br><br> Note: You can skip this step, and add additional Co-owner details later by login to the website using the login credentials. You will now be redirected to login page. <br> <br>


           <a class="btn btn-success btn-flat" href="'.base_url().'index.php/Main_login/index"><i class="fas fa-home"></i>&nbsp;Home</a>


     


      </div>';
         }

         elseif($to == 6)
         {
          $message.= 'Registration Completed <br> <br> <a class="btn btn-success btn-flat" href="'.base_url().'"index.php/Main_login/index"><i class="fas fa-home"></i>&nbsp;Home</a>


      </div>';
         }




         //value of $to ==5 will change to $to == 0 after adding all the coowners

     
         //<a class="btn btn-success btn-flat" href="'.base_url().'index.php/'.$page_url.'"><i class="fa fa-forward" aria-hidden="true">Skip this step</i></a>

         // <a class="btn btn-success btn-flat" href="'.base_url().'index.php/Registration/Skip"><i class="fa fa-forward" aria-hidden="true">Skip this step</i></a>


      ?>


<!-- Include the above in your HEAD tag -->
<section class="login-block">
<!-- <form class="needs-validation" novalidate> -->
    <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Registration/confirm", $attributes);
?>
<div class="container"> 
  <div class="row mt-1">
    <div class="col">
      <img src="<?php echo base_url(); ?>plugins/img/goklogo5.png"  alt="PortInfo">
    </div> <!-- end of col -->
    <div class="col-4">
      <i class="fa fa-ship fa-fw mt-5 text-primary" aria-hidden="true"></i>  <font class="text-primary">Kerala Inland Vessel </font> 
    </div>  <!-- end of  col-4 -->
 </div> <!-- end of row -->
  <div class="row mt-4">
    <div class="col">
      <?php echo $message; ?>
    </div> <!-- end of col -->
  </div> <!-- end of next row -->

</div> <!-- end of main container -->
 <?php echo form_close(); ?>
<!--</form> -->
</section> <!-- end of main section -->

<script type="text/javascript">
$(document).ready(function(){

  
  });
