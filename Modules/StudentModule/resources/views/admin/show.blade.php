@extends('layoutmodule::admin.main')

@section('title')
    {{ $student->name }}
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Allow modal to show dropdown properly */
        #modal-assign-course .modal-body {
            overflow: visible !important;
        }

        #modal-assign-course .card-block {
            overflow: visible !important;
        }

        /* Select2 styling */
        .select2-container {
            width: 100% !important;
        }

        .select2-container--open .select2-dropdown {
            z-index: 2000 !important;
        }

        /* Ensure search input is visible and functional */
        .select2-search__field {
            width: 100% !important;
            padding: 6px !important;
        }

        .select2-results {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')


    <div class="content-wrapper container-fluid">
        <div class="content-header">
            <div class="content-header-left mb-2 breadcrumb-new col">
                <h3>
                    {{ $student->name }}
                </h3>
            </div>
        </div>

        @include('layoutmodule::admin.flash')

        <div class="content-body">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                {{-- <div class="col-5">
                                <h2> الدورات</h2>
                            </div> --}}
                                <div class="col-lg-9"></div>
                                <div class="col-lg-3">
                                    @cannot('view_only')
                                        @if (Auth::guard('admin')->check() || Auth::user()->can('can_edit'))
                                            <a class="btn btn-warning"
                                                href="{{ route(Auth::getDefaultDriver() . '.students.edit', $student->id) }}"
                                                role="button">تعديل</a>
                                        @endif
                                    @endcannot

                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="card-block profile profile-view">
                                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 col">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                            الاسم
                                        </div>
                                        <div class="col-lg-8 col-md-4 col-sm-12 col-xs-12 col">
                                            {{ $student->name }}
                                        </div>
                                    </div>

                                    @if (Auth::guard('admin')->check())
                                        <div class="row">
                                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                                الفرع
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col">
                                                {{ $student->branch->name }}
                                            </div>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                            رقم الهوية / الإقامة
                                        </div>
                                        <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col">
                                            {{ $student->id_nu }}
                                        </div>


                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                            تاريخ الانتهاء
                                        </div>
                                        <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col">
                                            @if ($student->id_expire_date)
                                                {{ $student->id_expire_date }}
                                            @else
                                                ---
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                            الجوال
                                        </div>
                                        <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col">
                                            @if ($student->phone1)
                                                {{ $student->phone1 }}
                                            @else
                                                ---
                                            @endif
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                            جوال آخر للتواصل
                                        </div>
                                        <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col">
                                            @if ($student->phone2)
                                                {{ $student->phone2 }}
                                            @else
                                                ---
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                            المدينة
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col">
                                            {{ $student->city->name }}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                            قطاع العمل
                                        </div>
                                        <div class="col-lg-8 col-md-4 col-sm-12 col-xs-12 col">
                                            {{ $student->company }}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                            البريد الألكتروني
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col">
                                            {{ $student->email }}
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                            تاريخ الميلاد
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col">
                                            @if ($student->birthdate)
                                                {{ $student->birthdate }}
                                            @else
                                                ---
                                            @endif
                                        </div>

                                        <div class="col-lg-1 col-md-2 col-sm-12 col-xs-12 col label">
                                            الجنسية
                                        </div>
                                        <div class="col-lg-1 col-md-3 col-sm-12 col-xs-12 col">
                                            @if ($student->nationality)
                                                {{ $student->nationality }}
                                            @else
                                                ---
                                            @endif
                                        </div>

                                        <div class="col-lg-1 col-md-2 col-sm-12 col-xs-12 col label">
                                            النوع
                                        </div>
                                        <div class="col-lg-1 col-md-3 col-sm-12 col-xs-12 col">
                                            @if ($student->gender == 'male')
                                                ذكر
                                            @else
                                                أنثي
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                            المؤهل الدراسي
                                        </div>
                                        <div class="col-lg-8 col-md-4 col-sm-12 col-xs-12 col">
                                            @if ($student->academic_qualification)
                                                {{ $student->academic_qualification }}
                                            @else
                                                ---
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label">
                                            ملاحظات
                                        </div>
                                        <div class="col-lg-8 col-md-4 col-sm-12 col-xs-12 col">
                                            @if ($student->notes)
                                                {{ $student->notes }}
                                            @else
                                                ---
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="content-header">
            <div class="content-header-left mb-2 breadcrumb-new col">
                <h3>
                    الدورات
                </h3>
            </div>
        </div>
        <div class="content-body">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-8"></div>
                                <div class="col-lg-2 col-md-6 col-xs-6"></div>
                                <div class="col-lg-2 col-md-6 col-xs-6">
                                    @cannot('view_only')
                                        <a class="btn btn-success round btn-min-width mr-1 mb-1" href="#" role="button"
                                            data-toggle="modal" data-target="#modal-assign-course"><i class="fa fa-plus"></i>
                                            أضف الطالب الي دورة</a>
                                    @endcannot
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr class="head">
                                            <th style="width: 200px">الدورة</th>
                                            <th>تاريخ الدورة</th>
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
                                        @if (!empty($student->courses_regs))
                                            @foreach ($student->courses_regs as $reg)
                                                <tr id="reg{{ $reg->id }}">
                                                    <td class="strong"> {{ $reg->course->FullName }}</td>
                                                    <td>{{ $reg->course->start_at }}</td>
                                                    <td>
                                                        <div>
                                                            <span class="regprice" reg_id="{{ $reg->id }}">{{ $reg->price }}</span>
                                                            @if ($reg->main_price != $reg->price)
                                                            <br>
                                                            <span class="small" style="text-decoration: line-through">{{ $reg->main_price }}</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>{{ number_format($reg->coursePaidAmount, 2) }}</td>
                                                    <td>
                                                        @if ($reg->is_free == 1)
                                                            0.00
                                                        @else
                                                            <span class="remaining_amount" reg_id="{{ $reg->id }}">{{ number_format($reg->price - $reg->coursePaidAmount, 2) }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-center paid_status"
                                                        style="font-weight:bold; background-color: {{ $reg->status->color }} ">
                                                        <div style="display: none" class="paid_status_id">{{ $reg->is_course_paid }}</div>
                                                        <div style="display: none" class="paid_exam_id">{{ $reg->is_exam_paid }}</div>
                                                        @if ($reg->is_leave == 1)
                                                            [ مغادر ] &nbsp;&nbsp;&nbsp;
                                                        @endif
                                                        {{ $reg->status->status }}
                                                    </td>

                                                    <td class="align-center">
                                                        @if ($reg->is_recive_cert == 1)
                                                            <i class="fa fa-check green list-boolean-icon"></i>
                                                        @else
                                                            <i class="fa fa-close red list-boolean-icon"></i>
                                                        @endif
                                                    </td>

                                                    <td style="width: 520px">
                                                        <a class="btn-sm btn-success"
                                                            href="{{ route(Auth::getDefaultDriver() . '.courses.show', $reg->course->id) }}">استعراض
                                                            الدورة</a>

                                                        {{-- التفاصيل / الدفعات / تغيير حالة الدفع / حذف — same as course page --}}
                                                        @include('coursemodule::admin.partials.reg_actions')
                                                    </td>
                                                </tr>

                                                @include('coursemodule::admin.partials.reg_modals')
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Assign To Course -->

        <div class="modal fade text-xs-left modal-assign-course" id="modal-assign-course" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel90" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 800px;">
                <div class="modal-content">
                    <div style="">
                        <div class="modal-body content-reports modal-assign-course" style="padding:0">
                            <div class="statistic-table custom-bar">

                                <form class="card-form" id="AssginToCourseForm" method="POST"
                                    action='{{ route(Auth::getDefaultDriver() . '.courses.assign_student') }}'>
                                    @csrf
                                    <input type="hidden" id="student_id" name="student_id"
                                        value="{{ $student->id }}" />
                                    <div class="content-body">
                                        <section class="card">
                                            <div class="card-header">
                                                <h4 class="card-title" style="float: right;">
                                                    <i class="fa fa-plus"></i>
                                                    أضف الطالب الي دورة
                                                </h4>

                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>

                                            </div>

                                            <div class="card-block pay-template">
                                                <div class="card-text col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label for="course_id">أختر الدورة :
                                                                <span class="hint">*</span>
                                                            </label>
                                                            <span>
                                                                <select class="form-control" id="course_id"
                                                                    name="course_id">
                                                                    <option value="">اختر دورة...</option>
                                                                    @if (!empty($courses))
                                                                        @foreach ($courses as $course)
                                                                            <option value="{{ $course->id }}"
                                                                                data-price="{{ $course->price }}">
                                                                                {{ $course->FullName }}
                                                                                {{-- (من
                                                                                {{ \Carbon\Carbon::parse($course->start_at)->format('d-m-Y') }}
                                                                                الي
                                                                                {{ \Carbon\Carbon::parse($course->end_at)->format('d-m-Y') }}) --}}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="price">سعر الدورة :
                                                                <span class="hint">*</span>
                                                            </label>
                                                            <span>
                                                                <input class="form-control currency-after" type="text"
                                                                    disabled id="price" name="price"
                                                                    style="width:100px" required />
                                                            </span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="new_price">سعر الدورة المتفق عليه :
                                                                <span class="hint">*</span>
                                                            </label>
                                                            <span>
                                                                <input class="form-control currency-after" type="text"
                                                                    id="new_price" name="new_price"
                                                                    style="width:100px" />
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="reg_by_employee_id">تم التسجيل عن طريق :
                                                                <span class="hint">*</span>
                                                            </label>
                                                            <span>
                                                                <select class="form-control regby-select" id="reg_by_employee_id" name="reg_by_employee_id" dir="rtl" required>
                                                                    <option value="">-- اختر الموظف --</option>
                                                                    @foreach ($employees as $employee)
                                                                        <option value="{{ $employee->id }}" @selected(old('reg_by_employee_id') == $employee->id)>{{ $employee->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-block pay-template">
                                                <div class="card-text col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12" style="text-align: center">
                                                            <input type="submit" class="btn btn-success" value="حـفـظ">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize Select2 for course search
                function initSelect2() {
                    // Destroy existing instance if any
                    if ($('#course_id').data('select2')) {
                        $('#course_id').select2('destroy');
                    }

                    // Initialize Select2 and append dropdown to body
                    $('#course_id').select2({
                        placeholder: 'اختر دورة...',
                        allowClear: true,
                        width: 'resolve',
                        dropdownParent: $('#modal-assign-course').find('.modal-body'),
                        matcher: function(params, data) {
                            // If there are no search terms, return all of the data
                            if ($.trim(params.term) === '') {
                                return data;
                            }

                            // Do not display the item if there is no 'text' property
                            if (typeof data.text === 'undefined') {
                                return null;
                            }

                            // `params.term` should be the term that is used for searching
                            // `data.text` is the text that is displayed for the data object
                            if (data.text.indexOf(params.term) > -1) {
                                var modifiedData = $.extend({}, data, true);
                                return modifiedData;
                            }

                            // Return `null` if the term does not match
                            return null;
                        },
                        tags: false,
                        selectOnClose: false
                    });
                }

                // "تم التسجيل عن طريق" in assign form → Select2 (RTL)
                function initAssignRegBySelect() {
                    var $el = $('#reg_by_employee_id');
                    if ($el.data('select2')) {
                        $el.select2('destroy');
                    }
                    $el.select2({
                        dir: 'rtl',
                        width: 'resolve',
                        placeholder: '-- اختر الموظف --',
                        dropdownParent: $('#modal-assign-course').find('.modal-body'),
                        language: {
                            noResults: function() {
                                return 'لا توجد نتائج';
                            }
                        }
                    });
                }

                // Initialize on page load
                setTimeout(function() {
                    initSelect2();
                    initAssignRegBySelect();
                }, 500);

                // Reinitialize when modal is shown
                $('#modal-assign-course').on('show.bs.modal', function() {
                    setTimeout(function() {
                        initSelect2();
                        initAssignRegBySelect();
                    }, 300);
                });

                //$('#modal-pay-1').modal('show');


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
                    if (key == 13) // the enter key code
                    {
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
                $('.filter-sts-item-reg').click(function(event) {
                    event.preventDefault();
                    var e = $(this);
                    $('#fltr_sts_val').val(e.data('val'));
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

                    ////Filter Status////
                    var fltrStsVal = $('#fltr_sts_val').val();
                    var filterStsParam = (fltrStsVal != '' && fltrStsVal != 0) ? "fltr_sts=" + fltrStsVal : "";
                    //////////

                    /////Filter Date Range////
                    var dateRngFromVal = $('.fltr-date-range-reg #dateRngFrm').val();
                    var dateRngToVal = $('.fltr-date-range-reg #dateRangTo').val();
                    var dateRngParam = (dateRngFromVal != '' || dateRngToVal != '') ? "dateRngFrm=" + dateRngFromVal +
                        "&dateRngTo=" + dateRngToVal : "";
                    /////////////


                    var finalParams = "";
                    if (srchParam != "") {
                        finalParams += (srchParam + "&");
                    }
                    if (sortParam != "") {
                        finalParams += (sortParam + "&");
                    }
                    if (filterStsParam != "") {
                        finalParams += (filterStsParam + "&");
                    }
                    if (dateRngParam != "") {
                        finalParams += (dateRngParam + "&");
                    }

                    finalParams = finalParams.replace(/&\s*$/, ""); //remove the last (&)
                    return finalParams != "" ? "?" + finalParams : "";
                }

                ////////////////////



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

                ////////// Show selected course price///////
                updateCoursePrice();
                $('#modal-assign-course #course_id').change(updateCoursePrice);

                function updateCoursePrice() {
                    var selectedPrice = $('#modal-assign-course #course_id').find('option:selected').data('price');
                    $('#modal-assign-course #price').val("$" + selectedPrice);
                    $('#modal-assign-course #price').val(selectedPrice);

                    $('#modal-assign-course #new_price').val("$" + selectedPrice);
                    $('#modal-assign-course #new_price').val(selectedPrice);
                }
                /////////////////////////////////////////
            });
        </script>
        @include('coursemodule::admin.partials.reg_modals_js')
    @endpush
@endsection

@section('vendor-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('page-level-js')
@endsection
