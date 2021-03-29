
<body>
    <section id="nav-bar">
      <h6>.</h6>
        <nav class="navbar navbar-expand-lg navbar-light">
         
          <?php if(isset($logo)){ foreach($logo as $logo_res){ $logo_name = $logo_res['bodycontent_image']; }}?>
          <a class="navbar-brand"><img aria-label="logo-label" src="<?php echo base_url(); ?>uploads/Logo/<?php echo $logo_name;?>" alt='..' ></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item ">
                <?php if(isset($val)){
                  if($val==1){?>
                  <a class="nav-link contentfont customfont" href="<?php echo base_url()."index.php/Main_login/index"?>"> ഇംഗ്ലീഷ്</a>
                <?php } else { ?>
                  <a class="nav-link contentfont customfont" href="<?php echo base_url()."index.php/Main_login/index_mal"?>"> Malayalam</a> 
                  <?php }
                } else {?>
                    <a class="nav-link contentfont customfont" href="<?php echo base_url()."index.php/Main_login/index_mal"?>"> Malayalam</a>
                
                  
                   <?php }?> 
              </li>
               <li class="nav-item ">
                           </li>
              <li class="nav-item  " >
                <?php if(isset($val)){ $valu = $val; } else { $valu = "2";}?>
                <a class="nav-link contentfont customfont" href="<?php echo base_url()."index.php/Main_login/notfns_detail/$valu"?>"><?php if(isset($val)){if($val==1){?>അറിയിപ്പുകൾ<?php } else { ?>Notifications<?php }} else {?>Notifications<?php }?></a>
              </li>
              <li class="nav-item " id="lastnav">
                <a href="#about" class="btn btn-primary btn-flat btn-sm contentfont"><i class="fas fa-file-pdf"></i>&nbsp;KIV Forms</a>
              </li>
            </ul>
          </div>
        </nav>
    </section>

