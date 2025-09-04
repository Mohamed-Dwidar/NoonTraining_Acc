@extends('layoutmodule::admin.main')

@section('title')
تقرير بالطلاب المسددين
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
                                        تقرير بالطلاب المسددين
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
                                            value='@if (app('request')->dateRngFrm != null) {{ app('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    request')->dateRngFrm }} @endif'
                                            id="dateRngFrm" class="pickadate" />
                                        &nbsp;
                                        الي
                                        <input
                                            value='@if (app('request')->dateRngTo != null) {{ app('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    request')->dateRngTo }} @endif'
                                            id="dateRangTo" class="pickadate" />

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
                                                <th>الدورة</th>
                                                <th>الجوال</th>
                                                <th>السعر المتفق عليه</th>
                                                <th>المدفوع</th>
                                                <th>الباقي</th>
                                                <th style="text-align: center">الحالة</th>
                                                <th style="text-align: center">مسجل عن طريق</th>
                                                {{-- <th style="text-align: center">سدد رسوم الاختبار</th> --}}
                                                <th style="text-align: center">استلم الشهادة</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($courses_regs as $reg)
                                                <tr>
                                                    {{-- <td class="strong" style="padding: 0.75rem 0;background-color: {{$reg->status->color}} ">&nbsp;</td> --}}
                                                    <td class="strong">
                                                        <label for="{{ $reg->id }}">
                                                            <a
                                                                href="{{ route(Auth::getDefaultDriver().'.students.view', $reg->student->id) }}">{{ $reg->student->name }}</a>
                                                        </label>
                                                    </td>
                                                    <td class="strong">
                                                        <label>
                                                            <a
                                                                href="{{ route(Auth::getDefaultDriver().'.students.view', $reg->student->id) }}">{{ $reg->course->FullName }}</a>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label>{{ $reg->student->phone1 }}</label>
                                                    </td>

                                                    <td>
                                                        @if ($reg->main_price == $reg->price)
                                                            {{ $reg->price }}
                                                        @else
                                                            <div>
                                                                <span class="regprice"
                                                                    reg_id="{{ $reg->id }}">{{ $reg->price }}</span>
                                                                <br>
                                                                <span class="small"
                                                                    style="text-decoration: line-through">{{ $reg->main_price }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($reg->coursePaidAmount, 2) }}</td>
                                                    <td>
                                                        @if ($reg->is_free == 1)
                                                            0.00
                                                        @else
                                                            {{ number_format($reg->price - $reg->coursePaidAmount, 2) }}
                                                        @endif
                                                    </td>

                                                    <td class="align-center" style="font-weight:bold; background-color: {{ $reg->status->color }} ">
                                                        @if ($reg->is_leave == 1)
                                                        [ مغادر ] &nbsp;&nbsp;&nbsp;
                                                        @endif
                                                        {{$reg->status->status}}
                                                    </td>
                                                    <td class="align-center">
                                                           <label> {{ $reg->registered_by }}</label>
                                                    </td>

                                                    <td class="align-center">
                                                        @if ($reg->is_recive_cert == 0)
                                                            <i class="fa fa-close red list-boolean-icon"></i>
                                                        @else
                                                            <i class="fa fa-check green list-boolean-icon"></i>
                                                        @endif
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
            var url = '{{ url(Auth::getDefaultDriver().'/reports/ReportStudentsByCompany') }}';
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
