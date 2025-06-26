@extends('layoutmodule::admin.main')

@section('title')
    تقرير بالزيارات للمستخدمين
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

                                <div class="col-lg-4 col-md-4">
                                    <h4 class="card-title" style="float: right;">
                                        <i class="fa fa-file-text-o"></i>&nbsp;
                                        تقرير بالزيارات للمستخدمين
                                    </h4>
                                    {{-- <h4 class="card-title" style="float: right;">تث</h4> --}}
                                    {{-- {{dd()}} --}}
                                    {{-- <div class="filters">
                                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="icon-filter"></i>
                                            فلتر
                                        </a>
                                        <div class="dropdown-menu arrow dropdown-filter">
                                            <input type="hidden" id="fltr_val" value="@if (app('request')->fltr != null) {{ app('request')->fltr }} @endif" />

                                            <button class="dropdown-item filter-item-reg" type="button" data-val="0">
                                                الكل
                                            </button>
                                            @foreach ($statuses as $status)
                                                <button class="dropdown-item filter-item-reg" type="button" style="background-color: {{$status->color}}" data-val="{{$status->id}}">
                                                {{$status->status}}
                                            </button>
                                            @endforeach
                                                <button class="dropdown-item filter-item-reg" type="button" data-val="101">
                                                    مستلمي الشهادة
                                                </button>
                                                <button class="dropdown-item filter-item-reg" type="button" data-val="100">
                                                    غير مستلمي الشهادة
                                                </button>
                                        </div>
                                    </div> --}}


                                    {{-- <div class="filters" style="display: none">
                                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="icon-sort"></i>
                                            ترتيب
                                        </a>
                                        <div class="dropdown-menu arrow dropdown-sort">
                                            <input type="hidden" id="sort_val"
                                                value="@if (app('request')->srt != null) {{ app('request')->srt }} @endif" />

                                            <button class="dropdown-item sort-item-reg" type="button" data-val="no">
                                                افتراضي
                                            </button>
                                            <button class="dropdown-item sort-item-reg" type="button"
                                                data-val="date_az">
                                                تاريخ التقديم الاقدم
                                            </button>
                                            <button class="dropdown-item sort-item-reg" type="button"
                                                data-val="date_za">
                                                تاريخ التقديم الاحدث
                                            </button>
                                        </div>
                                    </div> --}}

                                </div>

                                <div class="col-lg-5 col-md-4 col-sm-3 col-xs-12">
                                    {{-- <div class="header-search">
                                        <label>بحث</label>
                                        <input value='@if (app('request')->srch != null){{ app('request')->srch }}@endif' id="srchInput-reg" />
                                        <button class="srch-icon-reg">
                                            <i class="icon-search7"></i>
                                        </button>
                                        <a href="#" class="clear-reg">إلغاء</a>
                                    </div> --}}
                                </div>

                                <div class="col-lg-5 col-md-6 col-sm-9 col-xs-12">
                                    {{-- @if (in_array('can_manage_money', auth()->user()->privileges_keys())) --}}
                                    <div class="filters">
                                        <a id="export">
                                            <i class="icon-file-excel"></i>
                                            تصدير ملف اكسل
                                        </a>
                                    </div>
                                    {{-- @endif --}}
                                </div>

                                <div class="col-lg-4 col-md-4" style="display: none">
                                    <div class="fltr-date-range-reg">
                                        <label>الفترة:</label>
                                        من
                                        <input
                                            value='@if (app('request')->dateRngFrm != null) {{ app('request')->dateRngFrm }} @endif'
                                            id="dateRngFrm" class="pickadate" />
                                        &nbsp;
                                        الي
                                        <input
                                            value='@if (app('request')->dateRngTo != null) {{ app('request')->dateRngTo }} @endif'
                                            id="dateRangTo" class="pickadate" />

                                        <button class="drnge-icon-reg">
                                            <i class="icon-search7"></i>
                                        </button>
                                        <a href="#" class="clear-dateRang">إلغاء</a>
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
                                                <th>المستخدم</th>
                                                <th>الوقت / التاريخ</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($logs as $log)
                                                <tr>
                                                    <td class="strong">
                                                        {{ $log->loggable->name }}
                                                    </td>
                                                    <td>
                                                        {{ $log->login_time }}
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
            var url = '{{ url(Auth::getDefaultDriver().'/reports/ReportUsersLog') }}';
            $(document).ready(function() {
                //Export///
                $("#export").click(function(event) {
                    document.location.href = url + '?export=yes';
                });
                ////////

            });
        </script>
    @endpush

@endsection
