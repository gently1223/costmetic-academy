<?php include(app_path().'/common/panel/header.php'); ?>

                    <div class="app-inner-layout app-inner-layout-page">
                        <div class="app-inner-layout__wrapper">
                            <div class="app-inner-layout__sidebar">
                                <div class="app-layout__sidebar-inner dropdown-menu-rounded">
                                    <div class="nav flex-column">
                                        <div class="nav-item-header text-primary nav-item">
                                            Dashboards Examples
                                        </div>
                                        <a class="dropdown-item active" href="analytics-dashboard.html">Analytics</a>
                                        <a class="dropdown-item" href="management-dashboard.html">Management</a>
                                        <a class="dropdown-item" href="advertisement-dashboard.html">Advertisement</a>
                                        <a class="dropdown-item" href="index.html">Helpdesk</a>
                                        <a class="dropdown-item" href="monitoring-dashboard.html">Monitoring</a>
                                        <a class="dropdown-item" href="crypto-dashboard.html">Cryptocurrency</a>
                                        <a class="dropdown-item" href="pm-dashboard.html">Project Management</a>
                                        <a class="dropdown-item" href="product-dashboard.html">Product</a>
                                        <a class="dropdown-item" href="statistics-dashboard.html">Statistics</a>
                                    </div>                            </div>
                            </div>
                            <div class="app-inner-layout__content pt-0">
                                <div class="tab-content">
                                    <div class="container-fluid">
                                        <div class="card mb-3">
                                            <div class="card-header-tab card-header">
                                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                                </div>
                                                
                                                
                                            </div>
                                            <?php if(Session::has('error')) { ?>
                                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                            <?php if(isset($_GET['s'])) { ?>
                                            <p class="alert alert-success">Thank You, you have successfully signed the contract.</p>
                                            <?php } ?>
                                                
                                            <div class="card-body">
                                                <table style="width: 100%;" id="example3"
                                                       class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo trans('dashboard.cv'); ?></th>
                                                        <th><?php echo trans('dashboard.pdf'); ?></th>
                                                        <th style="max-width:150px;"><?php echo trans('forms.contact'); ?></th>
                                                        <th><?php echo trans('forms.added_on'); ?></th>
                                                        <th style="min-width:70px;"><?php echo trans('dashboard.actions'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if(!empty($cvs)) {
                                                            foreach($cvs as $cv) {
                                                        ?>
                                                    <tr>
                                                        <td>
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#cv" onclick="show_cv('<?php echo $cv['cv']->id; ?>', '<?php echo $cv['cv']->title; ?>')" style="text-decoration:underline;"><?php echo $cv['cv']->title; ?></a>
                                                            <?php if($cv['cv']->status=='1') { ?>
                                                            <p style="color:green;"><i class="fa fa-check"></i> <?php echo trans('forms.accepted'); ?></p>
                                                            <?php } else if($cv['cv']->status=='2') { ?>
                                                            <p style="color:red;"><i class="fa fa-times"></i> <?php echo trans('forms.rejected'); ?></p>
                                                            <p><?php echo trans('forms.reason'); ?>: <?php echo $cv['cv']->reason; ?></p>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php 
                                                                if(!empty($cv['cv']->pdf))
                                                                {
                                                                    echo "<a href='".url('company_files/cvs/'.$cv['cv']->pdf)."' target='_blank' style='text-decoration:underline;'>".$cv['cv']->pdf."</a><br>";
                                                                } else echo trans('forms.not_generated').'<br>';
                                                                
                                                                if($cv['cv']->attachment!='') echo '<br>'.trans('forms.attachment').": <a href='".url('company_files/attachments/'.$cv['cv']->attachment)."' target='_blank' style='text-decoration:underline;'>".$cv['cv']->attachment."</a><br>";
                                                            ?>
                                                        </td>
                                                        <td style="max-width:150px;">
                                                            <?php echo $cv['user']->name; ?>
                                                            <p style="color:#777;"><?php echo $cv['user']->email; ?></p>
                                                        </td>
                                                        <td>
                                                            <?php echo date_format(new DateTime($cv['cv']->on_date),'d-m-Y'); ?>
                                                            <p style="color:#777;"><?php echo date_format(new DateTime($cv['cv']->on_date),'H:i'); ?></p>
                                                        </td>
                                                        <td>
                                                            <!--<button class="border-0 btn-transition btn btn-secondary mb-1" data-toggle="modal" data-target="#notes-<?php echo $cv['cv']->id; ?>">
                                                            <i class="fa fa-comments"></i>
                                                            </button>-->
                                                            
                                                            <?php if($cv['cv']->status=='0') { ?>
                                                            <br>
                                                            <form action="" method="post" style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="accept" value="<?php echo $cv['cv']->id; ?>">
                                                        <button class="border-0 btn-transition btn btn-success mb-1" onclick="return confirm('Are you sure you want to accept this CV?');">
                                                        <i class="fa fa-thumbs-up"></i>
                                                        </button>
                                                        </form>
                                                            
                                                        <button class="border-0 btn-transition btn btn-danger mb-1" onclick="$('#reject_id').val('<?php echo $cv['cv']->id; ?>'); $('#modal-title-reject').text('<?php echo trans('forms.reject') ?> - <?php echo $cv['cv']->title; ?>')" data-toggle="modal" data-target="#reject">
                                                        <i class="fa fa-thumbs-down"></i>
                                                        </button>
                                                            <br>
                                                            <?php } ?>
                                                            
                                                            <form action="" method="post" style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="delete" value="<?php echo $cv['cv']->id; ?>">
                                                        <button class="border-0 btn-transition btn btn-outline-danger" onclick="return confirm('Do you really want to delete this CV?');">
                                                        <i class="fa fa-trash"></i>
                                                        </button>
                                                        </form>
                                                        </td>
                                                    </tr>
                                                    <?php } } ?>
                                                    </tbody>
                                                    <tfoot>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php include(app_path().'/common/panel/footer.php'); ?>

<div class="modal fade" id="cv" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title-cv"></h4>
              </div>
              <div class="modal-body text-center">
                  <iframe src="" style="width:700px; border:1px solid black;" frameborder="0" scrolling="no" onload="resizeIframe(this)" id="cv_iframe_cover_page"></iframe>
                  <iframe src="" style="width:700px; border:1px solid black;" frameborder="0" scrolling="no" onload="resizeIframe(this)" id="cv_iframe_cover_letter"></iframe>
                  <iframe src="" style="width:700px; border:1px solid black;" frameborder="0" scrolling="no" onload="resizeIframe(this)" id="cv_iframe_resume"></iframe>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><?php echo trans('forms.close'); ?></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post">
                    <input type="hidden" name="reject" id="reject_id">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title-reject"></h4>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                  <div class="row">
                      <div class="col-12 col-lg-12">
                          <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo trans('forms.reason_reject'); ?></label>
                              <textarea class="form-control" name="reason" rows="6" required></textarea>
                          </div>
                      </div>
                  </div>
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="add-appointment-close"><?php echo trans('forms.cancel'); ?></button>
                <button type="submit" class="btn btn-primary pull-right" style="margin-right:10px;" id="submit_btn"><?php echo trans('forms.submit'); ?></button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<?php 
if(!empty($sick_leaves)) {
    foreach($sick_leaves as $leave) {
?>
<div class="modal fade" id="notes-<?php echo $leave['leave']->id; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post">
                    <input type="hidden" name="notes_id" value="<?php echo $leave['leave']->id; ?>">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title"><?php echo $leave['user']->name; ?></h4>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                  <div class="row">
                      <div class="col-12 col-lg-12">
                          <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo trans('forms.notes'); ?></label>
                              <textarea class="form-control" name="notes" rows="6"><?php echo $leave['leave']->notes; ?></textarea>
                          </div>
                      </div>
                  </div>
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="add-appointment-close"><?php echo trans('forms.cancel'); ?></button>
                <button type="submit" class="btn btn-primary pull-right" style="margin-right:10px;" id="submit_btn"><?php echo trans('forms.submit'); ?></button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<?php } } ?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="<?php echo url('assets/plugins/dropzone/dropzone.js'); ?>"></script>
<script>
    function show_cv(id, name)
    {
        $("#modal-title-cv").text(name);
        $("#cv_iframe_cover_page").attr('src', '<?php echo url('admin/cover-page/?cv='); ?>'+id);
        $("#cv_iframe_cover_letter").attr('src', '<?php echo url('admin/cover-letter/?cv='); ?>'+id);
        $("#cv_iframe_resume").attr('src', '<?php echo url('admin/resume/?cv='); ?>'+id);
    }
</script>