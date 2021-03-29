<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mailbox
        <small><?php echo $tn; ?> new messages</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url("Master/dashboard");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Mailbox</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="<?php echo site_url("Port/compose");?>" class="btn btn-primary btn-block margin-bottom">Compose</a>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
               <li><a href="<?php echo site_url("Port/mailbox");?>"><i class="fa fa-inbox"></i> Inbox
                  <span class="label label-primary pull-right"><?php echo $tn; ?></span></a></li>
                <li class="active"> <a href="<?php echo site_url("Port/senditem");?>"><i class="fa fa-envelope-o"></i> Sent</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Labels</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="#"><i class="fa fa-circle-o text-red"></i> Important</a></li>
                <li><a href="#"><i class="fa fa-circle-o text-green"></i> Promotions</a></li>
                <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Social</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Sent Items</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                 
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
               
                <div class="btn-group">
                 
                </div>
                <!-- /.btn-group -->
                
                <div class="pull-right">
                  
                  <div class="btn-group">
                    
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table id="example" class="table table-hover table-striped">
                 <thead style="display:none">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                </thead>
                  <tbody>
                  <?php foreach($sent as $s) 
				  {?>
                  <tr style="color:<?php if($s['tbl_usertypeid']==2){ echo "red"; } else if($s['tbl_usertypeid']==3){echo "green";} else {echo "light-blue";} ?>">
                    <td><input name="chk[]" value="<?php echo $s['tbl_inboxid']; ?>" type="checkbox"></td>
                    <td class="mailbox-star"><a href="#"><i class="fa fa-send text-green"></i></a></td>
                    <td class="mailbox-name"><a href="<?php echo $site_url.'/Port/readmail/'.encode_url($s['tbl_inboxid']);?>"><?php echo $s['user_master_name']; ?></a></td>
                    <td class="mailbox-subject"><b><?php echo $s['tbl_subject']; ?></b> - <?php echo strip_tags(substr($s['tbl_message'],0,120)); ?>...
                    </td>
                    <td class="mailbox-date">
					<?php
							$now=date('Y-m-d H:i:s');
							$send=$s['tbl_date'];
                            $start_date = new DateTime($send);
                            $since_start = $start_date->diff(new DateTime($now));
                            $y=$since_start->y; //.' years<br>';
                            $m=$since_start->m; //.' months<br>';
                            $d=$since_start->d; //.' days<br>';
                            $h=$since_start->h; //.' hours<br>';
                            $i=$since_start->i; //.' minutes<br>';
                            $s=$since_start->s; //.' seconds<br>';
                            if($y==0)
                            {
                                if($m==0)
                                {
                                    if($d==0)
                                    {
                                        if($h==0)
                                        {
                                            if($i==0)
                                            {
                                                echo $s.' seconds ago';
                                            }
                                            else
                                            {
                                                echo $i.' minutes ago';
                                            }
                                        }
                                        else
                                        {
                                            echo $h.' hours ago';
                                        }
                                    }
                                    else
                                    {
                                        echo $d.' days ago';
                                    }
                                }
                                else
                                {
                                    echo $m.' months ago';
                                }
                            }
                            else
                            {
                                echo $y.' years ago';
                            }
                    ?>
                    </td>
                  </tr>
                  <?php
				  }
				  ?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
               
                <div class="btn-group">
                  
                </div>
                <!-- /.btn-group -->
               
                <div class="pull-right">
                  
                  <div class="btn-group">
                   
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
$(document).ready(function() {
    $('#example').DataTable( {
		"dom": '<lf<t>ip>',
		 "pageLength": 50,
		 "info": true,
		 //"bLengthChange": false,
        "paging":         true
    } );
} );
</script>