@extends('layoutmodule::admin.main')

@section('title')
    {{ $course->name }}
@endsection

@push('styles')
<link href="{{url('/admin-assets/vendors/js/pickers/hijri-date-picker/dist/css/bootstrap-datetimepicker.css?v2')}}"
    rel="stylesheet" />
@endpush


@section('content')

    <div class="content-wrapper container-fluid">
        <div class="content-header">
            <div class="content-header-left mb-2 breadcrumb-new col">
                <h3>
                    <i class="fa fa-desktop"></i>
                    &nbsp;
                    {{-- {{ $course->id }} --}}
                    {{ $course->FullName }}
                    ({{ $course->start_at }} - {{ $course->end_at }})
                </h3>
            </div>
        </div>

        @include('layoutmodule::admin.flash')

        <div class="content-body">
            <div class="row">

                <!-- Course Info -->
                <div class="col-xl-12 col-lg-12 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block profile course-view">
                                <div class="row">

                                    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-6 col label">
                                        تبدأ في :
                                        &nbsp;
                                        <span class="font-normal">{{ $course->start_at }}</span>

                                        &nbsp;&nbsp;
                                        تنتهي في :
                                        &nbsp;
                                        <span class="font-normal">{{ $course->end_at }}</span>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 col label">
                                        سعر الدورة :
                                        &nbsp;
                                        <span class="font-normal">{{ $course->price }} ر.س</span>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 col label">
                                        رسوم الاختبار :
                                        &nbsp;
                                        <span class="font-normal">{{ $course->exam_fees }} ر.س</span>
                                    </div>

                                    {{-- <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 col label">
                                        الفرع :
                                        &nbsp;
                                        <span class="font-normal">{{ $course->branch->name }}</span>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -->

                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-left media-middle">
                                        <i class="fa fa-graduation-cap teal font-large-2 float-xs-right"></i>
                                    </div>
                                    <div class="media-body text-xs-right">
                                        <h3 class="teal">{{ $courses_regs->count() }}</h3>
                                        <h5>عدد الطلاب</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- @if (in_array('can_manage_money', auth()->user()->privileges_keys())) --}}
                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-left media-middle">
                                        <i class="icon icon-moneybag teal font-large-2 float-xs-right"></i>
                                    </div>
                                    <div class="media-body text-xs-right">
                                        <h3 class="teal">{{ $courses_regs->where('is_free',0)->sum('price') }}</h3>
                                        <h5>إجمالي الإيراد</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-left media-middle">
                                        <i class="icon icon-money1 teal font-large-2 float-xs-right"></i>
                                    </div>
                                    <?php
                                    // $paid = 0;
                                    // if (!empty($courses_regs)) {
                                    //     foreach ($courses_regs as $one_reg) {
                                    //         $paid = $paid + $one_reg->payments->sum('coursePaidAmount');
                                    //     }
                                    // }
                                    ?>
                                    <div class="media-body text-xs-right">
                                        {{-- <h3 class="teal">{{ $paid }}</h3> --}}
                                        <h3 class="teal">{{ $courses_regs->sum('coursePaidAmount') }}</h3>
                                        <h5>إجمالي المدفوع</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-left media-middle">
                                        <i class="fa fa-money teal font-large-2 float-xs-right"></i>
                                    </div>
                                    <div class="media-body text-xs-right">
                                        <h3 class="teal">{{ $courses_regs->where('is_free',0)->sum('price') - $courses_regs->sum('coursePaidAmount') }}</h3>
                                        <h5>إجمالي المتبقي</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @endif --}}
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">

                                <div class="col-lg-5 col-md-4 col-sm-3 col-xs-12">
                                    {{-- {{dd()}} --}}
                                    <div class="filters">
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
                                    </div>


                                    <div class="filters" style="display: none">
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
                                    </div>

                                </div>

                                <div class="col-lg-5 col-md-6 col-sm-9 col-xs-12">
                                    <div class="header-search">
                                        <label>بحث</label>
                                        <input value='@if (app('request')->srch != null){{ app('request')->srch }}@endif' id="srchInput-reg" />
                                        <button class="srch-icon-reg">
                                            <i class="icon-search7"></i>
                                        </button>
                                        <a href="#" class="clear-reg">إلغاء</a>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    {{-- @if (in_array('can_manage_money', auth()->user()->privileges_keys())) --}}
                                     {{-- <div class="filters">
                                        <a id="export">
                                            <i class="icon-file-excel"></i>
                                            تصدير ملف اكسل
                                        </a>
                                    </div>   --}}
                                    {{-- @endif --}}
                                </div>

                                <div class="col-lg-4 col-md-4" style="display: none">
                                    <div class="fltr-date-range-reg">
                                        <label>الفترة:</label>
                                        من
                                        <input
                                            value='@if (app('request')->dateRngFrm != null) {{ app('request')->dateRngFrm }} @endif' id="dateRngFrm" class="hijri-datepicker" />
                                        &nbsp;
                                        الي
                                        <input
                                            value='@if (app('request')->dateRngTo != null) {{ app('request')->dateRngTo }} @endif' id="dateRangTo" class="hijri-datepicker" />

                                        <button class="drnge-icon-reg">
                                            <i class="icon-search7"></i>
                                        </button>
                                        <a href="#" class="clear-dateRang">إلغاء</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if ($courses_regs->count() > 0)
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr class="head">
                                                {{-- <th style="padding: 0.75rem 0;width:40px;">&nbsp;</th> --}}
                                                <th>الطالب</th>
                                                {{-- <th>تاريخ التقديم</th> --}}
                                                <th>السعر المتفق عليه</th>
                                                <th>المدفوع</th>
                                                <th>الباقي</th>
                                                {{-- <th style="text-align: center">سدد رسوم الاختبار</th> --}}
                                                <th class="align-center">الحالة</th>
                                                <th style="text-align: center">استلم الشهادة</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            {{-- {{dd($courses_regs->toArray())}} --}}
                                            @foreach ($courses_regs as $reg)
                                                <tr id="reg{{ $reg->id }}">
                                                    {{-- <td class="strong" style="padding: 0.75rem 0;background-color: {{$reg->status->color}} ">&nbsp;</td> --}}
                                                    <td class="strong">
                                                        <label
                                                            for="{{ $reg->id }}">{{ $reg->student->name }}</label>
                                                    </td>
                                                    {{-- <td>{{$reg->created_at}}</td> --}}
                                                    <td>
                                                        <div>
                                                            <span class="regprice" reg_id="{{ $reg->id }}">{{ $reg->price }}</span>
                                                            @if ($reg->main_price != $reg->price)
                                                            <br>
                                                            <span class="small" style="text-decoration: line-through">{{ $reg->main_price }}</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>{{ number_format($reg->coursePaidAmount,2) }}</td>
                                                    <td>
                                                        @if ($reg->is_free == 1)
                                                            0.00
                                                        @else
                                                        <div>
                                                            <span class="remaining_amount" reg_id="{{ $reg->id }}">{{ number_format($reg->price - $reg->coursePaidAmount, 2) }}</span>
                                                        </div>
                                                        @endif
                                                    </td>
                                                    {{-- <td class="align-center">
                                                        @if($reg->is_exam_paid == 0)
                                                        <i class="fa fa-close red list-boolean-icon"></i>
                                                        @else
                                                        <i class="fa fa-check green list-boolean-icon"></i>
                                                        @endif
                                                    </td> --}}


                                                     <td class="align-center paid_status" style="font-weight:bold; background-color: {{ $reg->is_lawer == 1 ? '#a0670c' : $reg->status->color }} ">
                                                        <div style="display: none" class="paid_status_id">{{ $reg->is_course_paid }}</div>
                                                        <div style="display: none" class="paid_exam_id">{{ $reg->is_exam_paid }}</div>
                                                        @if ($reg->is_leave == 1)
                                                            [ مغادر ] &nbsp;&nbsp;&nbsp;
                                                        @endif
                                                        @if ($reg->is_lawer == 1)
                                                            [ محال إلى القضاء ] &nbsp;&nbsp;&nbsp;
                                                        @endif
                                                        {{ $reg->status->status }}
                                                    </td>

                                                    <td class="align-center">
                                                        @if($reg->is_recive_cert == 0)
                                                        <i class="fa fa-close red list-boolean-icon"></i>
                                                        @else
                                                        <i class="fa fa-check green list-boolean-icon"></i>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @include('coursemodule::admin.partials.reg_actions')
                                                    </td>
                                                </tr>

                                                @include('coursemodule::admin.partials.reg_modals')
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
            //$('#modal-reg-2').modal('show');

            var url = '{{ url(Auth::getDefaultDriver().'/courses/show/' . $course->id) }}';
            $(document).ready(function() {
                $('.pickadate').pickadate({
                    weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    format: 'dd-mm-yyyy',
                    formatSubmit: 'yyyy-mm-dd',
                    showMonthsShort: true,
                    today: false,
                    close: 'Close',
                    selectYears: 20,
                    selectMonths: true,
                    min: new Date(2021, 1, 1),
                    // max: new Date(),
                    // clear: '[All]',
                    // onSet: function (context) {
                    //     getInvoicesByDate();
                    // }
                });

                $(".select-dropdown__button").click(function() {
                    return false;
                });

                $('input[name=target]').change(function(event) {
                    showTargets();
                });

                function showTargets() {
                    var target = $('input[name=target]:checked').val();
                    $(".target-select").hide();
                    $("." + $('input[name=target]:checked').val() + "-select").show();

                }


                ////////Search &  Filter & Sort//////
                var searchSortFilterParams = '';
                //Search//
                $('#srchInput-reg').keypress(function(e) {
                    var key = e.which;
                    if (key == 13){         // the enter key code
                        $('button[class="srch-icon-reg"]').click();
                        return false;
                    }
                });
                $(".srch-icon-reg").click(function(event) {
                    searchSortFilterParams = collectSearchSortFilterParamsRegs();
                    document.location.href = url + searchSortFilterParams;
                });
                $(".header-search .clear-reg").on('click', function() {
                    $('#srchInput-reg').val('');
                    searchSortFilterParams = collectSearchSortFilterParamsRegs();
                    document.location.href = url + searchSortFilterParams;
                });
                /////
                ///Sort///
                $('.sort-item-reg').click(function(event) {
                    event.preventDefault();
                    var e = $(this);
                    $('#sort_val').val(e.data('val'));
                    searchSortFilterParams = collectSearchSortFilterParamsRegs();
                    document.location.href = url + searchSortFilterParams;
                });
                /////

                //Filter Satus////
                $('.filter-item-reg').click(function(event) {
                    event.preventDefault();
                    var e = $(this);
                    $('#fltr_val').val(e.data('val'));
                    searchSortFilterParams = collectSearchSortFilterParamsRegs();
                    document.location.href = url + searchSortFilterParams;
                });
                /////
                /////
                //Filter Date Range//
                $(".fltr-date-range-reg .drnge-icon-reg").click(function(event) {
                    searchSortFilterParams = collectSearchSortFilterParamsRegs();
                    document.location.href = url + searchSortFilterParams;
                });
                $(".fltr-date-range-reg .clear-dateRang").on('click', function() {
                    $('.fltr-date-range-reg #dateRngFrm').val('');
                    $('.fltr-date-range-reg #dateRangTo').val('');
                    searchSortFilterParams = collectSearchSortFilterParamsRegs();
                    document.location.href = url + searchSortFilterParams;
                });
                /////

                //Export///
                $("#export").click(function(event) {
                    // alert(searchSortFilterParams);
                    // return false;
                    searchSortFilterParams = collectSearchSortFilterParamsRegs();
                    if (searchSortFilterParams != '') {
                        document.location.href = url + searchSortFilterParams + '&export=yes';
                    } else {
                        document.location.href = url + '?export=yes';
                    }
                });
                ////////



                /*$('#export-excel').click(function(){
                    searchSortFilterParams = collectSearchSortFilterParamsRegs();
                    // alert(url + searchSortFilterParams);
                    if(searchSortFilterParams != ''){
                        document.location.href = url + searchSortFilterParams + '&export=yes';
                    }else{
                        document.location.href = url + '?export=yes';
                    }

                });*/

                function collectSearchSortFilterParamsRegs() {
                    /////Search////
                    var srchVal = $('#srchInput-reg').val();
                    var srchParam = srchVal != '' ? "srch=" + srchVal : "";
                    /////////////

                    ////Sort////
                    var sortVal = $('#sort_val').val();
                    var sortParam = (sortVal != '' && sortVal != 'no') ? "srt=" + sortVal : "";
                    //////////

                    ////Filter////
                    var fltrStsVal = $('#fltr_val').val();
                    if(fltrStsVal < 100){
                        var filterParam = (fltrStsVal != '' && fltrStsVal != 0) ? "fltr_sts=" + fltrStsVal : "";
                    }else{
                        var filterParam = (fltrStsVal != '' && fltrStsVal != 0) ? "fltr_crt=" + (fltrStsVal - 100) : "";
                    }
                    //////////

                    /////Filter Date Range////
                    var dateRngFromVal = $('.fltr-date-range-reg #dateRngFrm').val();
                    var dateRngToVal = $('.fltr-date-range-reg #dateRangTo').val();
                    var dateRngParam = (dateRngFromVal != '' || dateRngToVal != '') ? "dateRngFrm=" + dateRngFromVal + "&dateRngTo=" + dateRngToVal : "";
                    /////////////


                    var finalParams = "";
                    if (srchParam != "") {
                        finalParams += (srchParam + "&");
                    }
                    if (sortParam != "") {
                        finalParams += (sortParam + "&");
                    }
                    if (filterParam != "") {
                        finalParams += (filterParam + "&");
                    }
                    if (dateRngParam != "") {
                        finalParams += (dateRngParam + "&");
                    }

                    finalParams = finalParams.replace(/&\s*$/, ""); //remove the last (&)
                    return finalParams != "" ? "?" + finalParams : "";
                }

                ////////////////////


            });
        </script>


        <script src="{{url('/admin-assets/vendors/js/pickers/hijri-date-picker/dist/js/bootstrap-hijri-datetimepicker.min.js?v2')}}"> </script>

        <script type="text/javascript">
            $(document).ready(function () {
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
        @include('coursemodule::admin.partials.reg_modals_js')
    @endpush

@endsection
