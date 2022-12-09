<?php use App\Http\Controllers\admin\coaching_offers; ?>
<?php include(app_path() . '/common/panel/header.php'); ?>
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
                </div>
            </div>
        </div>
        <div class="app-inner-layout__content pt-0">
            <div class="tab-content">
                <div class="container-fluid">
                    <div class="card mb-3">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            </div>

                            <div class="btn-actions-pane-right actions-icon-btn">
                                <button type="button" class="btn-shadow btn btn-wide btn-success" onclick="$('#form-box').slideToggle()">
                                    <span class="btn-icon-wrapper pr-1 opacity-7">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    <?php echo trans('forms.add_new'); ?>
                                </button>
                            </div>

                        </div>
                        <?php if (Session::has('error')) { ?>
                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                        <?php } ?>
                        <?php if (Session::has('success')) { ?>
                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                        <?php } ?>
                        <p class="alert alert-success" id="success-message" style="display: none;"></p>

                        <div id="form-box" style="display: none;">
                            <div class="main-card mb-2 card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo trans('forms.add_new_course_offer'); ?></h5>
                                    <form id="onSubmit" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="exampleEmail11" class=""><?php echo trans('forms.please_select'); ?> <font style="color:red;">*</font></label>
                                                    <select name="course_id" class="form-control course" required>
                                                        <option value="" disabled selected><?php echo trans('forms.select_coaching'); ?></option>
                                                        @foreach($courses as $key)
                                                        <option value="{{$key->id}}">{{$key->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="exampleEmail11" class=""><?php echo trans('forms.offer_name'); ?> <font style="color:red;">*</font></label>
                                                    <input name="name" id="offer_name" type="text" class="form-control" required value="{{old('name')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="examplePassword11" class=""><?php echo trans('forms.begin_date'); ?> <font style="color:red;">*</font> </label><span style="float:right" id="bewilligungs_zeitraum"></span>
                                                    <input type="text" class="form-control date_range required" name="begin_date" required id="period_field2" value="{{old('begin_date')}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="examplePassword11" class=""><?php echo trans('forms.valid_till'); ?> <font style="color:red;">*</font></label>
                                                    <input type="text" class="form-control valid_till required" name="valid_until" required id="period_field2" value="{{old('valid_date')}}" readonly>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="exampleEmail11" class="">{{trans('forms.select_products_modules')}}</label>
                                                <div id="treeview_container" class="hummingbird-treeview well h-scroll-large">
                                                    <input type="hidden" name="products_selected" id="selected_products">
                                                    <ul id="treeview-products-1" class="hummingbird-base">

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="exampleEmail11" class=""><?php echo trans('forms.coach'); ?> <font style="color:red;">*</font></label>
                                                    <select name="coach_id" class="form-control coach_id" required style="width:100%;" style="width:100%;">
                                                        <option value="" disabled selected><?php echo trans('forms.please_select'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="examplePassword11" class=""><?php echo trans('forms.max_hours'); ?> <font style="color:red;">*</font></label>
                                                    <input type="number" class="form-control max_hours" name="max_hours" required value="{{old('max_hours')}}" readonly>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="position-relative form-group">
                                                    <label for="examplePassword11" class=""><?php echo trans('forms.min_ue_per_week'); ?> <font style="color:red;">*</font></label>
                                                    <input type="number" class="form-control min_ue_per_week" name="min_ue_per_week" required value="{{old('min_ue_per_week')}}">

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="position-relative form-group">
                                                    <label for="examplePassword11" class=""><?php echo trans('forms.min_appt_per_week'); ?> <font style="color:red;">*</font></label>
                                                    <input type="number" class="form-control min_appt_per_week" name="min_appt_per_week" required value="{{old('min_appt_per_week')}}">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="examplePassword11" class=""><?php echo trans('forms.notes'); ?> <font style="color:red;">*</font></label>
                                                    <textarea   class="form-control notes" name="notes" cols=4 rows=4  >{{old('notes')}}</textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <p class="alert alert-danger" id="course-error" style="display:none;"></p>
                                        <button class="mt-2 btn btn-primary save-offer"><?php echo trans('forms.submit'); ?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table style="width: 100%;" id="example3" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo trans('dashboard.course_name') . ' - ' . trans('dashboard.offer_name');?></th>
                                       
                                        <th style="width: 20%"><?php echo trans('dashboard.begin_end_date') . '<br/>' . trans('dashboard.valid_date'); ?></th>
                                      
                                        <th><?php echo trans('forms.coach'); ?></th>
                                        <th><?php echo trans('forms.approved_hours') . ' / ' . trans('forms.max_hours'); ?></th>
                                        
                                        <th><?php echo trans('forms.min_ue_per_week'); ?></th>
                                        <th><?php echo trans('forms.min_appt_per_week'); ?></th>
                                        <th><?php echo trans('forms.status') . ' & ' . trans('dashboard.actions'); ?></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($offers)) {
                                        foreach ($offers as $offer) {
                                            $color = '';
                                            if($offer->status == 0) {
                                                $status = trans('forms.sent');
                                                
                                            } elseif($offer->status == 1) {
                                                $status = trans('forms.pending_approval');
                                                $color = 'style="background-color: red;color:#ffff"';
                                            } else {
                                                $status = trans('forms.completed');
                                            }
                                    ?>
                                            <tr {!! $color !!}>
                                                <td><?php echo $offer->title . ' - ' . $offer->name; ?>
                                                @if($offer->pdf_file != '')
                                               <br/><a href="{{url('company_files/coaching_offers/'.$offer->pdf_file)}}" class="btn btn-warning btn-sm" target="_blank">Lehrauftrag</a>
                                               
                                                @endif
                                                
                                                </td>
                                                
                                                <td><?php echo date('d.m.Y', strtotime($offer->begin_date)); ?> - <?php echo date('d.m.Y', strtotime($offer->end_date)) . '<br/>' . date('d.m.Y', strtotime($offer->valid_until)); ?></td>
                                                
                                                <td><?php echo $offer->con_name; ?></td>
                                                <td><?php echo coaching_offers::get_approved_ue($offer->id) . ' / ' . $offer->max_hours;  ?></td>
                                               
                                                <td><?php echo $offer->min_ue_per_week; ?></td>
                                                <td><?php echo $offer->min_appt_per_week; ?></td>
                                                <td>{{$status}}<br/>
                                                    <a href="{{route('admin.view-offer', $offer->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a> &nbsp; @if($offer->status != 0) <a href="{{route('admin.view-appointments', $offer->id)}}" class="btn btn-success btn-sm"><i class="fa fa-calendar"></i></a> &nbsp; @endif @if($offer->status != 2) <a href="{{route('admin.delete-offer', $offer->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> @endif
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
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
<?php include(app_path() . '/common/panel/footer.php'); ?>
<script src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>
    var editor = null;
    ClassicEditor.create(document.querySelector("#editor"), {
            toolbar: [
                "bold",
                "italic",
                "link",
                "bulletedList",
                "numberedList",
                "blockQuote",
                "undo",
                "redo"
            ]
        })
        .then(editor => {
            //debugger;
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    function check_data() {
        $("#course-error").hide();
        var period = $("#period_field2").val();
        var dates = period.split(' - ');
        if (dates[0] == dates[1]) {
            $("#course-error").text('<?php echo trans('forms.beginning_end_same'); ?>');
            $("#course-error").show();
            return false;
        }

        return true;
    }
    var current_date = new Date();
    current_date.setDate(current_date.getDate() + 14);

    $('.date_range').daterangepicker({
        startDate: new Date(),
        minDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });

    //16-12-2021
    $('.course').on('change', function() {
        let id = $(this).val();
        $.LoadingOverlay("show");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: "{{route('admin.get-lectures')}}",
            data: {
                id: id
            },
            dataType: "json",
            type: 'POST',
            success: function(data) {
                $.LoadingOverlay("hide");
                if (data.success) {

                    $('select[name="coach_id"]').empty().append($('<option>').text("{{trans('forms.please_select')}}").attr('value', '').attr('disabled', 'disabled').attr('selected', 'selected')).attr('required', true);
                    $.each(data.lecturers, function(i, value) {
                        var name = value.coach.name;
                        var id = value.coach.id;
                        $('select[name="coach_id"]').append($('<option>').text(name).attr('value', id));
                    });
                    $(".max_hours").val("");
                    $(".coach_id").val("")
                    $(".hummingbird-base").html(data.treeview);
                    console.log(data.date_info.end);
                    //console.log($("#bewilligungs_zeitraum"));
                    bewilligungs_zeitraum.innerText = "Bewilligungszeitraum: " + data.date_info.begin + ' - ' + data.date_info.end;
                    //$("#bewilligungs_zeitraum").textContent = "Bewilligungszeitraum: " + data.date_info.begin + ' - ' + data.date_info.end;
                    $('.date_range').daterangepicker({
                        startDate: data.date_info.begin,
                        endDate: data.date_info.end,
                        minDate: data.date_info.begin,
                        maxDate:  data.date_info.end,
                        locale: {
                            format: 'DD-MM-YYYY'
                        }
                    });
  
                    $(".valid_till").daterangepicker({
                        singleDatePicker: true,
                        startDate: current_date,
                        minDate: current_date,
                        maxDate: current_date,
                        locale: {
                            format: 'DD-MM-YYYY'
                        }
                    });
                }
            }
        });
    });
</script>
<script>
    $("#treeview-products-1").hummingbird();
    $(function() {
        $(".valid_till").daterangepicker({
            singleDatePicker: true,
            startDate: current_date,
            minDate: current_date,
            maxDate: current_date,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        $(".save-offer").on("click", function() {
            //get the action-url of the form
            var actionurl = "{{route('admin.manage_offers')}}";
            $.LoadingOverlay("show");
            //do your own request an handle the results
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: actionurl,
                type: 'post',
                data: $("#onSubmit").serialize(),
                dataType: "json",
                success: function(data) {
                    $.LoadingOverlay("hide");
                    if (data.success) {
                        // $(".course").val('');
                        // $("#offer_name").val("");
                        // $(".max_hours").val("");
                        // $(".coach_id").val("")
                        // $(".hummingbird-base").html('');
                        // $("#success-message").text(data.message).css('display', 'block');
                        // $("#course-error").text(data.message).css('display', 'none');
                        location.reload();
                    } else {
                        $("#course-error").text(data.message).css('display', 'block');
                        return false;
                    }
                }
            });
            return false;
        });
    });

    function item_selected(p_id) {
        var old_files = $("#selected_products").val();
        if (old_files != '')
            var files = old_files.split(',');
        else var files = [];
        files.push(p_id);
        var new_files = files.join(',');
        $("#selected_products").val(new_files);
    }

    function item_selected2(p_id, m_id) {
        var old_files = $("#selected_modules_" + p_id).val();
        if (old_files != '')
            var files = old_files.split(',');
        else var files = [];
        files.push(m_id);
        var new_files = files.join(',');
        $("#selected_modules_" + p_id).val(new_files);
    }

    function item_selected12(p_id) {
        var old_files = $("#selected_products2").val();
        if (old_files != '')
            var files = old_files.split(',');
        else var files = [];
        files.push(p_id);
        var new_files = files.join(',');
        $("#selected_products2").val(new_files);
    }

    function item_selected22(p_id, m_id) {
        var old_files = $("#selected_modules2_" + p_id).val();
        if (old_files != '')
            var files = old_files.split(',');
        else var files = [];
        files.push(m_id);
        var new_files = files.join(',');
        $("#selected_modules2_" + p_id).val(new_files);
    }

    function select_items(th, checkboxes) {
        if ($(th).is(':checked')) $(checkboxes).prop('checked', true);
        else $(checkboxes).prop('checked', false);
    }

    function select_product(id) {
        var count = 0;
        var mdid = 0;
        var sum_hours = 0;
        $(".items_detail-" + id).each(function() {
            if ($(this).is(':checked'))
            {
                var item_id = $(this).val();
                count += parseInt(1);
                mdid = $(this).attr('mdid');
                var lession = $("#item_id_"+item_id).val();
                sum_hours += parseInt(lession);
            }
            else
            {
                mdid = $(this).attr('mdid');
            }   
        });
        if (count > 0) {
            $("#p-" + id).prop('checked', true);
            $("#m-" + mdid).prop('checked', true);
            $(".max_hours").val(sum_hours).attr({"max" : sum_hours,"min" : 0 });
        } else {
            $("#p-" + id).prop('checked', false);
            $("#m-" + mdid).prop('checked', false);
            $(".max_hours").val(sum_hours).attr({"max" : sum_hours,"min" : 0 });
        }

    }

    function sum_lession(pid)
    {
        var sum_hours = 0;
        $(".items_detail-" + pid).each(function() {
            if ($(this).is(':checked'))
            {
                var item_id = $(this).val();
                var lession = $("#item_id_"+item_id).val();
                sum_hours += parseInt(lession);
            }
        });
        $(".max_hours").val(sum_hours).attr({"max" : sum_hours,"min" : 0 });
    }
</script>