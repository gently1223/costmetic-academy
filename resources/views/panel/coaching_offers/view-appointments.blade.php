<?php

include(app_path() . '/common/panel/header.php');
$days_i = 0;
?>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="<?php echo url('hummingbird/hummingbird-treeview.css'); ?>" rel="stylesheet" type="text/css">
<style>
    .hummingbird-treeview * {
        font-size: 18px;
    }
</style>
<div class="app-inner-layout app-inner-layout-page">
    <div class="app-inner-layout__wrapper">
        <div class="app-inner-layout__sidebar">
            <div class="app-layout__sidebar-inner dropdown-menu-rounded">
                <div class="nav flex-column">
                    <div class="nav-item-header text-primary nav-item">Dashboards
                        Examples</div>
                    <a class="dropdown-item active" href="analytics-dashboard.html">Analytics</a>
                    <a class="dropdown-item" href="management-dashboard.html">Management</a>
                    <a class="dropdown-item" href="advertisement-dashboard.html">Advertisement</a>
                    <a class="dropdown-item" href="index.html">Helpdesk</a> <a class="dropdown-item" href="monitoring-dashboard.html">Monitoring</a>
                    <a class="dropdown-item" href="crypto-dashboard.html">Cryptocurrency</a>
                    <a class="dropdown-item" href="pm-dashboard.html">Project
                        Management</a> <a class="dropdown-item" href="product-dashboard.html">Product</a> <a class="dropdown-item" href="statistics-dashboard.html">Statistics</a>
                </div>
            </div>
        </div>
        <div class="app-inner-layout__content pt-0">
            <div class="tab-content">
                <div class="container-fluid">
                    <div class="card mb-3">
                        <?php if (Session::has('error')) { ?>
                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                        <?php } ?>
                        <?php if (Session::has('success')) { ?>
                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                        <?php } ?>

                        <div class="card-body">
                            <form class="" method="post" id="app_form">
                                <input type="hidden" name="offer_id" value="@if(count($appointments) > 0) {{$appointments[0]->offer_id}} @endif">
                                <table style="width: 100%;" id="example3" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="check_all_appointments" id="checkAll"></th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Unterrichtsform</th>
                                            <th>Module Name > Module Item</th>
                                            <th>UE</th>
                                            <th>Room</th>
                                            <th>Dozenten</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $send = 0;
                                        if (count($appointments) > 0) {
                                            foreach ($appointments as $appointment) { ?>
                                                <tr id="app-<?php echo $appointment->id; ?>">
                                                    <td style="width: 20px;">
                                                        <center>
                                                            @if($appointment->status == 1 || $appointment->status == 3 || $appointment->status == 2 || $appointment->status == 0)
                                                            <input type="hidden" name="appointment_ids[]" value="{{$appointment->id}}">
                                                            <input type="checkbox" name="appointments[<?php echo $appointment->id; ?>]" class="check_appointments">
                                                            @endif
                                                        </center>
                                                    </td>
                                                    <td><?php echo date('d-m-Y',strtotime($appointment->date)); ?></td>
                                                    <td><?php echo $appointment->time . ' - ' . $appointment->time_end; ?></td>
                                                    <td><?php if ($appointment->appointment_form == 'Presence') echo 'Präsenz';
                                                        elseif ($appointment->appointment_form == 'Digital') echo 'Digital';
                                                        elseif ($appointment->appointment_form == 'Self-Learning') echo 'Selbstlernheit';
                                                        elseif ($appointment->appointment_form == 'Other') echo 'Andere';
                                                        else echo 'Unbekannt'; ?></td>
                                                    
                                                    <td><?php echo $appointment->title; ?></td>
                                                    <td><?php echo $appointment->ue; ?></td>
                                                    <td><?php echo $appointment->name; ?></td>
                                                    <td><?php echo $appointment->c_name; ?></td>
                                                    <td>

                                                        <?php
                                                        /*
                                                                 * status = 0 = created
                                                                 * status = 1 = accepted
                                                                 * status = 2 = sent
                                                                 * status = 3 = deleted (after sent)
                                                                 * status = 4 = rejected
                                                                 * status = 5 = Changed thru admin
                                                                 */
                                                        if ($appointment->status == '1') {
                                                            echo '<span style="color:#3ac47d;"><i class="fa fa-check"></i> Akzeptiert</span>'; //Accepted
                                                        } else if ($appointment->status == '2')
                                                            echo 'Wird geprüft'; //Sent
                                                        else if ($appointment->status == '4')
                                                            echo 'Abgelehnt'; //Rejected
                                                        else if ($appointment->status == '0')
                                                            echo 'Erstellt';
                                                        else if ($appointment->status == '5')
                                                            echo 'Geändert durch Admin';    
                                                        ?>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                                <div>
                                    <p class="alert alert-danger" id="course-error" style="display: none;"></p>
                                    <button class="mt-2 btn btn-success edit_appointment" type="button"><?php echo trans('forms.edit_appointments'); ?></button>
                                    <button class="mt-2 btn btn-primary update_appointment" type="button"><?php echo trans('forms.approve_appointments'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(".update_appointment").on("click", function(e) {
        //get the action-url of the form
        var actionurl = "{{route('admin.update-appointment')}}";
        $.LoadingOverlay("show");
        //do your own request an handle the results
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: actionurl,
            type: 'post',
            data: $("#app_form").serialize(),
            dataType: "json",
            success: function(data) {
            	console.log("before loading overlay");
                $.LoadingOverlay("hide");
                console.log("after loading overlay");
                if (data.success) {
                	console.log("inside data.success");
                    alert(data.message);
                    location.reload();
                } else {
                console.log("inside data.success else");
                    $("#course-error").text(data.message).css('display', 'block');
                    return false;
                }
            }
        });
        return false;
    });

    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $(".edit_appointment").on("click", function(e) {
        //get the action-url of the form
        var actionurl = "{{route('admin.edit-appointment')}}";
        $.LoadingOverlay("show");
        //do your own request an handle the results
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: actionurl,
            type: 'post',
            data: $("#app_form").serialize(),
            dataType: "json",
            success: function(data) {
                $.LoadingOverlay("hide");
                if (data.status) {
                   window.location.href = "{{route('admin.update-appointments')}}";
                } else {
                    $("#course-error").text(data.message).css('display', 'block');
                    return false;
                }
            }
        });
        return false;
    });
</script>
<?php include(app_path() . '/common/panel/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>