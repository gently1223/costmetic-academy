
<style>
    .daterangepicker { z-index: 2000 !important; }
    
    #completed_to_do .widget-content .widget-content-left .widget-heading{
        text-decoration: line-through;
    }
</style>
<div class="row">
                                            <div class="col-sm-12 col-lg-12">
                                                <div class="card-hover-shadow-2x mb-3 card">
                                                    <div class="d-block card-header mt-3 pb-0">
                                                        <h5 class="float-left pt-1"><?php echo trans('dashboard.todo_list'); ?></h5>
                                                        
                                                        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#add-task" onclick="$('#task_id').val('0'); $('#task_title').val(''); $('#task_description').val(''); $('#task_assign_to').val('0'); $('#task_assign_to_user').val('0'); $('#modal-title-task').text('<?php echo trans('dashboard.add_todo'); ?>'); $('#reminder').prop('checked', false); $('#reminder_field').attr('readonly', true); $('#file_name').hide(); $('#task_assign_to').val('').trigger('change.select2'); $('#task_priority').val('');"><?php echo trans('dashboard.add_todo'); ?></button>
                                                    </div>
                                                    <div class="scroll-area-sm">
                                                        <div class="scrollbar-container ps ps--active-y">
                                                            <div class="p-2">
                                                                <ul class="todo-list-wrapper list-group list-group-flush" id="tasks">
                                                                    <?php 
                                                                    if(!empty($todos)) {
                                                                        foreach($todos as $todo) {
                                                                            if($todo['todo']->status=='1') continue;
                                                                    ?>
                                                                    <li class="list-group-item" id="task-<?php echo $todo['todo']->id; ?>">
                                                                        <div class="todo-indicator bg-info"></div>
                                                                        <div class="widget-content p-0">
                                                                            <div class="widget-content-wrapper">
                                                                                <div class="widget-content-left mr-2">
                                                                                    <div class="custom-checkbox custom-control">
                                                                                        <input type="checkbox" name="todo" value="<?php echo $todo['todo']->id; ?>" onclick="update_status(this)" <?php if($todo['todo']->status=='1') echo 'checked'; ?> id="exampleCustomCheckbox<?php echo $todo['todo']->id; ?>" class="custom-control-input"><label class="custom-control-label" for="exampleCustomCheckbox<?php echo $todo['todo']->id; ?>">&nbsp;</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="widget-content-left mr-3">
                                                                                    <div class="widget-content-left">
                                                                                        <?php 
                                                                            $image='';
                                                                            if($todo['contact']!='NA') {
                                                                            if($todo['contact']->profile_image!='')
                                                                            $url=url('images/profile/'.$todo['contact']->profile_image);
                                                                            else
                                                                            $url=url('images/avatar.jpg');
                                                                            $image='<img width="42" class="rounded" src="'.$url.'" alt="'.$todo['contact']->name.'" title="'.$todo['contact']->name.'">';
                                                                            }
                                                                            echo $image;
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="widget-content-left">
                                                                                    <div class="widget-heading"><?php echo $todo['todo']->title; 
                                                                            if($todo['todo']->priority=='1') echo " <i class='fa fa-arrow-up' style='color:red; font-weight:bold;'></i>";
                                                                            else if($todo['todo']->priority=='2') echo " <i class='fa fa-arrow-up' style='color:green; font-weight:bold;'></i>";
                                                                            else if($todo['todo']->priority=='3') echo " <i class='fa fa-arrow-down' style='color:yellow; font-weight:bold;'></i>";
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="widget-subheading"><?php echo $todo['todo']->description; ?>
                                                                                    </div>
                                                                                    
                                                                                    <div class="widget-subheading">
                                                                                        <?php 
                                                                            $due_date=date_format(new DateTime($todo['todo']->due_date),'d-m-Y');
                                                                            if(date('d-m-Y')>$due_date) $s='end';
                                                                            else $s='start';
                                                                            echo '<i class="fa fa-hourglass-'.$s.'"></i> <font style="text-decoration:underline;">'.$due_date.'</font> &nbsp;'; ?>
                                                                                        
                                                                                        <?php if(!empty($todo['todo']->file)) echo '<i class="fa fa-paperclip"></i> <a href="'.url('to_do_files/'.$todo['todo']->file).'" target="_blank" style="text-decoration:underline;">'.$todo['todo']->file.'</a> &nbsp;'; ?>
                                                                                        
                                                                                        <?php if($todo['todo']->reminder=='1') echo '<i class="fa fa-bell"></i> <font style="text-decoration:underline;">'.date_format(new DateTime($todo['todo']->reminder_date),'d-m-Y h:i a').'</font>'; ?>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                                <div class="widget-content-right">
                                                                                    <button class="border-0 btn-transition btn btn-outline-success" onclick="edit_task('<?php echo $todo['todo']->id; ?>', '<?php echo $todo['todo']->title; ?>', '<?php echo $todo['todo']->priority; ?>', '<?php echo $todo['todo']->description; ?>', '<?php echo date_format(new DateTime($todo['todo']->due_date),'d-m-Y'); ?>', '<?php echo $todo['todo']->assign_to; ?>', '<?php echo $todo['todo']->reminder; ?>', '<?php echo date_format(new DateTime($todo['todo']->reminder_date),'d-m-Y h:i A'); ?>', '<?php echo $todo['todo']->user_type; ?>')" data-toggle="modal" data-target="#add-task">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </button>
                                                                                    <button class="border-0 btn-transition btn btn-outline-danger" onclick="delete_todo('<?php echo $todo['todo']->id; ?>')">
                                                                                        <i class="fa fa-trash-alt"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <?php } } ?>
                                                                </ul>
                                                                
                                                                <div id="accordion-to-do" class="accordion-wrapper mb-3">
                                                    <div class="">
                                                        <div id="headingOne" class="card-header" style="background:#E2E2E0;">
                                                            <button type="button" data-toggle="collapse" data-target="#collapseOne1-to-do" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed" style="text-decoration:none;">
                                                                <h5 class="m-0 p-0 pl-2" style="font-size:18px;"><i class="fa fa-check-square pr-3"></i> <?php echo trans('dashboard.completed_todos'); ?></h5>
                                                            </button>
                                                        </div>
                                                        <div data-parent="#accordion-to-do" id="collapseOne1-to-do" aria-labelledby="headingOne" class="collapse" style="">
                                                            <div class="card-body pl-0">
                                                                
                                                                    <ul class="todo-list-wrapper list-group list-group-flush" id="completed_to_do">
                                                                    <?php 
                                                                    if(!empty($todos)) {
                                                                        foreach($todos as $todo) {
                                                                            if($todo['todo']->status=='0') continue;
                                                                    ?>
                                                                    <li class="list-group-item" id="task-<?php echo $todo['todo']->id; ?>">
                                                                        <div class="todo-indicator bg-info"></div>
                                                                        <div class="widget-content p-0">
                                                                            <div class="widget-content-wrapper">
                                                                                <div class="widget-content-left mr-2">
                                                                                    <div class="custom-checkbox custom-control">
                                                                                        <input type="checkbox" name="todo" value="<?php echo $todo['todo']->id; ?>" onclick="update_status(this)" <?php if($todo['todo']->status=='1') echo 'checked'; ?> id="exampleCustomCheckbox<?php echo $todo['todo']->id; ?>" class="custom-control-input"><label class="custom-control-label" for="exampleCustomCheckbox<?php echo $todo['todo']->id; ?>">&nbsp;</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="widget-content-left mr-3">
                                                                                    <div class="widget-content-left">
                                                                                        <?php 
                                                                            $image='';
                                                                            if($todo['contact']!='NA') {
                                                                            if($todo['contact']->profile_image!='')
                                                                            $url=url('images/profile/'.$todo['contact']->profile_image);
                                                                            else
                                                                            $url=url('images/avatar.jpg');
                                                                            $image='<img width="42" class="rounded" src="'.$url.'" alt="'.$todo['contact']->name.'" title="'.$todo['contact']->name.'">';
                                                                            }
                                                                            echo $image;
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="widget-content-left">
                                                                                    <div class="widget-heading"><?php echo $todo['todo']->title; 
                                                                            if($todo['todo']->priority=='1') echo " <i class='fa fa-arrow-up' style='color:red; font-weight:bold;'></i>";
                                                                            else if($todo['todo']->priority=='2') echo " <i class='fa fa-arrow-up' style='color:green; font-weight:bold;'></i>";
                                                                            else if($todo['todo']->priority=='3') echo " <i class='fa fa-arrow-down' style='color:yellow; font-weight:bold;'></i>";
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="widget-subheading"><?php echo $todo['todo']->description; ?>
                                                                                    </div>
                                                                                    
                                                                                    <div class="widget-subheading">
                                                                                        <?php 
                                                                            $due_date=date_format(new DateTime($todo['todo']->due_date),'d-m-Y');
                                                                            if(date('d-m-Y')>$due_date) $s='end';
                                                                            else $s='start';
                                                                            echo '<i class="fa fa-hourglass-'.$s.'"></i> <font style="text-decoration:underline;">'.$due_date.'</font> &nbsp;'; ?>
                                                                                        
                                                                                        <?php if(!empty($todo['todo']->file)) echo '<i class="fa fa-paperclip"></i> <a href="'.url('to_do_files/'.$todo['todo']->file).'" target="_blank" style="text-decoration:underline;">'.$todo['todo']->file.'</a> &nbsp;'; ?>
                                                                                        
                                                                                        <?php if($todo['todo']->reminder=='1') echo '<i class="fa fa-bell"></i> <font style="text-decoration:underline;">'.date_format(new DateTime($todo['todo']->reminder_date),'d-m-Y h:i a').'</font>'; ?>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                                <div class="widget-content-right">
                                                                                    <button class="border-0 btn-transition btn btn-outline-success" onclick="edit_task('<?php echo $todo['todo']->id; ?>', '<?php echo addslashes($todo['todo']->title); ?>', '<?php echo addslashes($todo['todo']->priority); ?>', '<?php echo addslashes($todo['todo']->description); ?>', '<?php echo date_format(new DateTime($todo['todo']->due_date),'d-m-Y'); ?>', '<?php echo $todo['todo']->assign_to; ?>', '<?php echo $todo['todo']->reminder; ?>', '<?php echo date_format(new DateTime($todo['todo']->reminder_date),'d-m-Y h:i A'); ?>')" data-toggle="modal" data-target="#add-task">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </button>
                                                                                    <button class="border-0 btn-transition btn btn-outline-danger" onclick="delete_todo('<?php echo $todo['todo']->id; ?>')">
                                                                                        <i class="fa fa-trash-alt"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <?php } } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                                
                                                            </div>
                                                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 200px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 51px;"></div></div></div>
                                                    </div>
                                                    <!--<div class="d-block text-right card-footer">
                                                    </div>-->
                                                </div>
                                            </div>
                                        </div>

