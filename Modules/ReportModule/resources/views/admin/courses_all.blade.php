@extends('layoutmodule::admin.main')

@section('title')
تقرير بالطلاب لكل دورة
@endsection

@push('styles')
    {{-- <link href="{{ url('/admin-assets/vendors/js/pickers/hijri-date-picker/dist/css/bootstrap-datetimepicker.css?v2') }}"
        rel="stylesheet" /> --}}
@endpush

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
                                        تقرير بالطلاب لكل دورة
                                    </h4>

                                    <div class="filters" style="display: none">
                                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="icon-sort"></i>
                                            ترتيب
                                        </a>
                                        <div class="dropdown-menu arrow dropdown-sort">
                                            <input type="hidden" id="sort_val"
                                                value="@if(app('request')->srt != null){{ app('request')->srt }}@endif" />

                                            <button class="dropdown-item sort-item" type="button" data-val="no">
                                                افتراضي
                                            </button>
                                            <button class="dropdown-item sort-item" type="button" data-val="name_az">
                                                بالاسم أ-ي
                                            </button>
                                            <button class="dropdown-item sort-item" type="button" data-val="name_za">
                                                بالاسم ي-أ
                                            </button>
                                            <button class="dropdown-item sort-item" type="button" data-val="reg_az">
                                                تاريخ التسجيل الاقدم
                                            </button>
                                            <button class="dropdown-item sort-item" type="button" data-val="reg_za">
                                                تاريخ التسجيل الاحدث
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-5 col-md-4 col-sm-3 col-xs-12">
                                    <div class="header-search" style="display: none">
                                        <label>بحث</label>
                                        <input value='@if (app('request')->srch != null) {{ app('request')->srch }} @endif'
                                            id="srchInput" />
                                        <button class="srch-icon-reg">
                                            <i class="icon-search7"></i>
                                        </button>
                                        <a href="#" class="clear-reg">إلغاء</a>
                                    </div>
                                </div>

                                <div class="col-lg-5 col-md-6 col-sm-9 col-xs-12">
                                    
                                    <div class="filters" @if (Auth::guard('user')->check()) style="display:none" @endif>
                                        <input type="hidden" id="fltr_brnch_val" value="@if(app('request')->brnch != null){{ app('request')->brnch }}@endif" />
                                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="icon-sort"></i>
                                            الفرع
                                        </a>
                                        <div class="dropdown-menu arrow dropdown-filter">
                                            <input type="hidden" id="fltr_brnch"
                                                value="@if (app('request')->fltr != null) {{ app('request')->fltr }} @endif" />

                                            <button class="dropdown-item filter-item-brnch" type="button" data-val="no">
                                                الكل
                                            </button>
                                            @foreach ($branches as $branch)
                                                <button class="dropdown-item filter-item-brnch" type="button"
                                                    data-val="{{ $branch->id }}">
                                                    {{ $branch->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- <div class="filters">
                                        <a id="export-excel">
                                            <i class="icon-file-excel"></i>
                                            تصدير ملف اكسل
                                        </a>
                                    </div> --}}
                                </div>

                                <div class="col-lg-4 col-md-4" style="display: none">
                                    <div class="fltr-date-range-reg">
                                        <label>الفترة:</label>
                                        <div class="form-group">
                                            من
                                            <input
                                                value='@if (app('request')->dateRngFrm != null) {{ app('request')->dateRngFrm }} @endif'
                                                id="dateRngFrm" class="form-control hijri-datepicker" />
                                            &nbsp;
                                            الي
                                            <input
                                                value='@if (app('request')->dateRngTo != null) {{ app('request')->dateRngTo }} @endif'
                                                id="dateRangTo" class="form-control hijri-datepicker" />
                                        </div>
                                        <button class="drnge-icon-reg">
                                            <i class="icon-search7"></i>
                                        </button>
                                        <a href="#" class="clear-dateRang">إلغاء</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if ($courses->count() > 0)
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr class="head">
                                                {{-- <th style="padding: 0.75rem 0;width:40px;">&nbsp;</th> --}}
                                                <th>اسم الدورة</th>
                                                @if (Auth::guard('admin')->check())
                                                    <th>الفرع</th>
                                                @endif                                                
                                                <th>تاريخ بداية الدورة</th>
                                                <th>تاريخ انتهاء الدورة</th>
                                                {{-- <th>السعر المتفق عليه</th>
                                                <th>رسوم الاختبار</th> --}}
                                                <th class="align-center">الطلاب</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($courses as $course)
                                                <tr>
                                                    {{-- <td class="strong" style="padding: 0.75rem 0;background-color: {{$reg->status->color}} ">&nbsp;</td> --}}
                                                    <td class="strong">
                                                        <label for="{{ $course->id }}">
                                                            <a href="{{ route(Auth::getDefaultDriver() . '.courses.show', $course->id) }}">{{ $course->fullName }}</a>
                                                        </label>
                                                    </td>
                                                    @if (Auth::guard('admin')->check())
                                                        <td>{{ $course->branch->name }}</td>
                                                    @endif
                                                    <td>{{ $course->start_at }}</td>
                                                    <td>{{ $course->end_at }}</td>
                                                    {{-- <td>{{ $course->price }} ر.س</td>
                                                    <td>{{ $course->exam_fees }} ر.س</td> --}}
                                                    <td class="align-center">
                                                        {{ $course->courses_regs->count() }}
                                                    </td>
                                                    <td>
                                                        <a class="btn-sm btn-success one-reg" href="{{ route(Auth::getDefaultDriver().'.reports.course_students', $course->id) }}" role="button"> تقرير الطلاب المسجلين <i class="icon-file-excel"></i></a>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
            var url = '{{ url(Auth::getDefaultDriver() . '/reports/ReportAllCourses') }}';
        </script>

        {{-- <script
            src="{{ url('/admin-assets/vendors/js/pickers/hijri-date-picker/dist/js/bootstrap-hijri-datetimepicker.min.js?v2') }}">
        </script> --}}

        {{-- <script type="text/javascript">
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
        </script> --}}
    @endpush

@endsection
