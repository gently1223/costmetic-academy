<?php include(app_path().'/common/header.php'); ?>

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
                                                
                                                <div class="btn-actions-pane-right actions-icon-btn">
                                                    <a href="<?php echo url('create-cv'); ?>"><button type="button" class="btn-shadow btn btn-wide btn-success">
                                                    <span class="btn-icon-wrapper pr-1 opacity-7">
                                                        <i class="fa fa-plus"></i>
                                                    </span>
                                                    <?php echo trans('forms.create_new'); ?>
                                                    </button></a>
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
                                                        <th><?php echo trans('forms.created_on'); ?></th>
                                                        <th><?php echo trans('dashboard.actions'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if(!empty($cvs)) {
                                                            foreach($cvs as $cv) {
                                                        ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $cv->title; ?>
                                                            <?php if($cv->status=='2') { ?>
                                                            <p style="color:red;"><i class="fa fa-times"></i> <?php echo trans('forms.rejected'); ?></p>
                                                            <p><?php echo trans('forms.reason'); ?>: <?php echo $cv->reason; ?></p>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php if($cv->pdf=='') echo trans('forms.not_generated').'<br>'; else echo "<a href='".url('company_files/cvs/'.$cv->pdf)."' target='_blank' style='text-decoration:underline;'>".$cv->pdf."</a><br>"; 
                                                        
                                                        if($cv->attachment!='') echo '<br>'.trans('forms.attachment').": <a href='".url('company_files/attachments/'.$cv->attachment)."' target='_blank' style='text-decoration:underline;'>".$cv->attachment."</a><br>";
                                                            ?></td>
                                                        <td>
                                                            <?php echo date_format(new DateTime($cv->on_date),'d-m-Y'); ?>
                                                            <p style="color:#777;"><?php echo date_format(new DateTime($cv->on_date),'H:i'); ?></p>
                                                        </td>
                                                        <td>
                                                            <?php if($cv->status=='2') { ?>
                                                            <a href="<?php echo url('create-cv/'.$cv->id); ?>"><button class="btn btn-success mb-1">Edit &amp; Re-submit</button></a>
                                                            <br>
                                                            <?php } ?>
                                                            
                                                            <form action="" method="post" style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="delete" value="<?php echo $cv->id; ?>">
                                                        <button class="border-0 btn-transition btn btn-danger" onclick="return confirm('Do you really want to delete this CV?');">
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

<?php include(app_path().'/common/footer.php'); ?>
