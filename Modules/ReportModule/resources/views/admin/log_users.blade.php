@extends('layoutmodule::admin.main')

@section('title')
    تقرير بالعمليات للمستخدمين
@endsection


@section('content')

    <div class="content-wrapper container-fluid">
        <div class="content-header">
            <div class="content-header-left mb-2 breadcrumb-new col">
                <h3>
                    <i class="fa fa-file-text-o"></i>
                    &nbsp;
                    التقارير
                </h3>
            </div>
        </div>

        @include('layoutmodule::admin.flash')

        <div class="content-body">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">

                                <div class="col-lg-3 col-md-4">
                                    <h4 class="card-title" style="float: right;">
                                        <i class="fa fa-file-text-o"></i>&nbsp;
                                        تقرير بالعمليات للمستخدمين
                                    </h4>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="filters">
                                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="icon-filter"></i>
                                            فلتر المسنخدمين
                                        </a>
                                        <div class="dropdown-menu arrow dropdown-filter">
                                            <input type="hidden" id="usr_val"
                                                @if (app('request')->usr != null) value="{{ app('request')->usr }}" @endif />
                                            <button class="dropdown-item filter-item-reg" type="button" data-val="0">
                                                الكل
                                            </button>
                                            @foreach ($admins as $admin)
                                                <button class="dropdown-item filter-item-reg" type="button"
                                                    data-val="admin">
                                                    {{ $admin->name }}
                                                </button>
                                            @endforeach

                                            @foreach ($users as $user)
                                                <button class="dropdown-item filter-item-reg" type="button"
                                                    data-val="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </button>
                                            @endforeach

                                        </div>
                                    </div>

                                    <div class="filters">
                                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="icon-filter"></i>
                                            فلتر الفروع
                                        </a>
                                        <div class="dropdown-menu arrow dropdown-filter">
                                            <input type="hidden" id="brnch_val"
                                                @if (app('request')->brnch != null) value="{{ app('request')->brnch }}" @endif />
                                            <button class="dropdown-item filter-item-reg" type="button" data-val="0">
                                                الكل
                                            </button>
                                            @foreach ($branches as $branch)
                                                <button class="dropdown-item filter-item-reg" type="button"
                                                    data-val="{{ $branch->id }}">
                                                    {{ $branch->name }}
                                                </button>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4">
                                    <div class="fltr-date-range-reg">
                                        <label>الفترة:</label>
                                        من
                                        <input
                                            @if (app('request')->dateRngFrm != null) value="{{ app('request')->dateRngFrm }}" @endif
                                            id="dateRngFrm" class="pickadate" />
                                        &nbsp;
                                        الي
                                        <input
                                            @if (app('request')->dateRngTo != null) value="{{ app('request')->dateRngTo }}" @endif
                                            id="dateRangTo" class="pickadate" />

                                        <button class="drnge-icon-reg">
                                            <i class="icon-search7"></i>
                                        </button>
                                        <a href="#" class="clear-dateRang">إلغاء</a>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-8 col-sm-3 col-xs-12" style="text-align: left;">
                                    <div class="filters">
                                        <a id="export">
                                            <i class="icon-file-excel"></i>
                                            تصدير ملف اكسل
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if ($logs->count() > 0)
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr class="head">
                                                <th>الوقت / التاريخ</th>
                                                <th>المستخدم</th>
                                                <th>الفرع</th>
                                                <th>نوع العملية</th>
                                                <th>وصف العملية</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($logs as $log)
                                                <tr>
                                                    <td>
                                                        {{ $log->created_at->format('Y-m-d | H:i') }}
                                                    </td>
                                                    <td class="strong">
                                                        {{ $log->userable->name }}
                                                    </td>
                                                    <td>
                                                       @if($log->userable && $log->userable->branch)
                                                        {{ $log->userable->branch->name }}
                                                       @else
                                                       ---
                                                       @endif
                                                    </td>
                                                    <td>
                                                        {{ $log->action }}
                                                    </td>

                                                    <td>
                                                        {{ $log->description }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $logs->appends(request()->query())->links('layoutmodule::admin.custom_pagination') }}
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12" style="text-align: center;padding: 50px 0">
                                        لا يوجد طلاب
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    @push('scripts')
        <script>
            var url = '{{ url(Auth::getDefaultDriver() . '/reports/ReportUsersLog') }}';
            $(document).ready(function() {

                // Unified filter/export logic
                function reloadWithFilters(isExport = false) {
                    var usr = $('#usr_val').val() || '';
                    var brnch = $('#brnch_val').val() || '';
                    var dateRngFrm = $('#dateRngFrm').val() || '';
                    var dateRngTo = $('#dateRangTo').val() || '';
                    var params = [];
                    if (usr) params.push('usr=' + encodeURIComponent(usr));
                    if (brnch) params.push('brnch=' + encodeURIComponent(brnch));
                    if (dateRngFrm) params.push('dateRngFrm=' + encodeURIComponent(dateRngFrm));
                    if (dateRngTo) params.push('dateRngTo=' + encodeURIComponent(dateRngTo));
                    if (isExport) params.push('export=yes');
                    var query = params.length ? ('?' + params.join('&')) : '';
                    window.location.href = url + query;
                }

                // Export button
                $("#export").click(function(event) {
                    event.preventDefault();
                    reloadWithFilters(true);
                });

                // User filter
                $('.filter-item-reg').click(function() {
                    var val = $(this).data('val');
                    if ($(this).closest('.dropdown-filter').find('#usr_val').length) {
                        $('#usr_val').val(val);
                    }
                    if ($(this).closest('.dropdown-filter').find('#brnch_val').length) {
                        $('#brnch_val').val(val);
                    }
                    reloadWithFilters();
                });

                // Date range filter
                $('.drnge-icon-reg').click(function() {
                    reloadWithFilters();
                });

                // Clear date range
                $('.clear-dateRang').click(function(e) {
                    e.preventDefault();
                    $('#dateRngFrm').val('');
                    $('#dateRangTo').val('');
                    reloadWithFilters();
                });
            });
        </script>



        <script type="text/javascript">
            $(document).ready(function() {

                $('.pickadate').pickadate({
                    weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    format: 'dd-mm-yyyy',
                    formatSubmit: 'yyyy-mm-dd',
                    showMonthsShort: true,
                    today: false,
                    close: 'Close',
                    // clear: '[All]',
                    // onSet: function (context) {
                    //     getInvoicesByDate();
                    // }
                });
            });
        </script>


        <script
            src="{{ url('/admin-assets/vendors/js/pickers/hijri-date-picker/dist/js/bootstrap-hijri-datetimepicker.min.js?v2') }}">
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                initHijrDatePickerDefault();
            });

            function initHijrDatePickerDefault() {
                $(".hijri-datepicker").hijriDatePicker({
                    locale: "ar-sa",
                    format: "DD-MM-YYYY",
                    actualFormat: "DD-MM-YY",
                    hijriFormat: "iYYYY-iMM-iDD",
                    dayViewHeaderFormat: "MMMM YYYY",
                    hijriDayViewHeaderFormat: "iMMMM iYYYY",
                    showSwitcher: false,
                    allowInputToggle: true,
                    useCurrent: true,
                    isRTL: true,
                    viewMode: 'days',
                    keepOpen: false,
                    hijri: true,
                    debug: true,
                    showClear: false,
                    showTodayButton: false,
                    showClose: false,
                });
            }
        </script>
    @endpush

@endsection
