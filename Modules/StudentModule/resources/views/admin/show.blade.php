@extends('layoutmodule::admin.main')

@section('title')
    {{ $student->name }}
@endsection

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
                                                <tr>
                                                    <td class="strong"> {{ $reg->course->FullName }}</td>
                                                    <td>{{ $reg->course->start_at }}</td>
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
                                                    {{-- <td class="align-center">
                                                        @if ($reg->is_exam_paid == 0)
                                                        <i class="fa fa-close red list-boolean-icon"></i>
                                                        @else
                                                        <i class="fa fa-check green list-boolean-icon"></i>                                                        
                                                        @endif
                                                    </td> --}}
                                                    <td class="align-center"
                                                        style="font-weight:bold; background-color: {{ $reg->status->color }} ">
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


                                                    <td style="width: 420px">
                                                        <a class="btn-sm btn-warning one-reg" href="#"
                                                            id="{{ $reg->id }}" role="button" data-toggle="modal"
                                                            data-target="#modal-reg-{{ $reg->id }}">التفاصيل</a>


                                                        <a class="btn-sm btn-primary one-reg"
                                                            href="{{ route(Auth::getDefaultDriver() . '.courses.show', $reg->course->id) }}">استعراض
                                                            الدورة</a>

                                                        {{-- <a class="btn-sm btn-warning one-pay" href="#"
                                                            id="{{ $reg->id }}" role="button" data-toggle="modal"
                                                            data-target="#modal-pay-{{ $reg->id }}">الدفعات</a> --}}

                                                        {{-- <a class="btn-sm btn-danger"
                                                href="{{route(Auth::getDefaultDriver().'.courses.delete_reg',$reg->id)}}"
                                                onclick="return confirm('هل انت متأكد انك تريد حذف هذا الطلب ؟')"
                                                role="button">حذف</a> --}}
                                                    </td>
                                                </tr>

                                                <div class="modal fade text-xs-left reg-modal"
                                                    id="modal-reg-{{ $reg->id }}" tabindex="-1" role="dialog"
                                                    aria-labelledby="myModalLabel90" aria-hidden="true">
                                                    <div class="modal-dialog" role="document" style="max-width: 800px;">
                                                        <div class="modal-content">
                                                            <div id="reg-{{ $reg->id }}-info" style="">
                                                                <div class="modal-body content-reports reg-modal"
                                                                    style="padding:0">
                                                                    <div class="statistic-table custom-bar">
                                                                        <div class="content-body">
                                                                            <section class="card">
                                                                                <div class="card-header">
                                                                                    <h4 class="card-title"
                                                                                        style="float: right;">
                                                                                        <i class="icon-desktop"></i>
                                                                                        &nbsp;&nbsp;
                                                                                        {{ $reg->course->FullName }}
                                                                                    </h4>

                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>

                                                                                </div>
                                                                                <div class="card-block reg-template">
                                                                                    <div class="card-text col-md-12">

                                                                                        <div class="row">
                                                                                            <div class="col-md-12 align-center"
                                                                                                style="padding:10px 0;margin-bottom: 25px;font-weight:bold; background-color: {{ $reg->status->color }} ">
                                                                                                @if ($reg->is_leave == 1)
                                                                                                    [ مغادر ]
                                                                                                    &nbsp;&nbsp;&nbsp;
                                                                                                @endif
                                                                                                {{ $reg->status->status }}
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    تبدأ في</div>
                                                                                                <div
                                                                                                    class="col-lg-4 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    {{ $reg->course->start_at }}
                                                                                                </div>

                                                                                                <div
                                                                                                    class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    تنتهي في</div>
                                                                                                <div
                                                                                                    class="col-lg-4 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    {{ $reg->course->end_at }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    السعر المتفق عليه</div>
                                                                                                <div
                                                                                                    class="col-lg-4 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    @if ($reg->main_price == $reg->price)
                                                                                                        {{ $reg->price }}
                                                                                                    @else
                                                                                                        &nbsp;
                                                                                                        <span
                                                                                                            class="small"
                                                                                                            style="text-decoration: line-through">{{ $reg->main_price }}</span>
                                                                                                        <span
                                                                                                            class="price">{{ $reg->price }}</span>
                                                                                                    @endif
                                                                                                    ر.س
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>


                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    السعر النهائي</div>
                                                                                                <div
                                                                                                    class="col-lg-4 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    {{ $reg->price }}
                                                                                                    ر.س
                                                                                                </div>

                                                                                                <div
                                                                                                    class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    الخصم</div>
                                                                                                <div
                                                                                                    class="col-lg-4 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    {{ $reg->DiscountAmount }}
                                                                                                    ر.س
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    رسوم الاختبار</div>
                                                                                                <div
                                                                                                    class="col-lg-4 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    {{ $reg->course->exam_fees }}
                                                                                                    ر.س
                                                                                                </div>


                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    تم التسجيل عن طريق
                                                                                                </div>
                                                                                                <div
                                                                                                    class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    @if ($reg->registered_by)
                                                                                                        {{ $reg->registered_by }}
                                                                                                    @else
                                                                                                        ----
                                                                                                    @endif
                                                                                                </div>
                                                                                                <div
                                                                                                    class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    تاريخ التقديم</div>
                                                                                                <div
                                                                                                    class="col-lg-4 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    {{ \Carbon\Carbon::parse($reg->created_at)->format('d-m-Y') }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    تم استلام الشهادة </div>
                                                                                                <div
                                                                                                    class="col-lg-9 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    @if ($reg->is_recive_cert == 1)
                                                                                                        <i
                                                                                                            class="fa fa-check green list-boolean-icon"></i>
                                                                                                    @else
                                                                                                        <i
                                                                                                            class="fa fa-close red list-boolean-icon"></i>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade text-xs-left pay-modal"
                                                    id="modal-pay-{{ $reg->id }}" tabindex="-1" role="dialog"
                                                    aria-labelledby="myModalLabel90" aria-hidden="true">
                                                    <div class="modal-dialog" role="document" style="max-width: 800px;">
                                                        <div class="modal-content">
                                                            <div id="pay-{{ $reg->id }}-info" style="">
                                                                <div class="modal-body content-reports pay-modal"
                                                                    style="padding:0">
                                                                    <div class="statistic-table custom-bar">
                                                                        <form class="card-form" id="payActionForm"
                                                                            method="POST"
                                                                            action='{{ route(Auth::getDefaultDriver() . '.courses.pay_action') }}'>
                                                                            @csrf
                                                                            <input type="hidden" id="id"
                                                                                name="id"
                                                                                value="{{ $reg->id }}" />
                                                                            <div class="content-body">
                                                                                {{-- <section class="card"> --}}
                                                                                <div class="card-header">
                                                                                    <h4 class="card-title"
                                                                                        style="float: right;">
                                                                                        الدفعات لدورة :
                                                                                        {{ $reg->course->FullName }}
                                                                                    </h4>

                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>

                                                                                <div class="card-block pay-template">
                                                                                    <div class="card-text col-md-12">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4">
                                                                                                <label><b>سعر الدورة
                                                                                                        :</b></label>
                                                                                                <span>
                                                                                                    {{ number_format($reg->price, 2) }}
                                                                                                    ر.س
                                                                                                </span>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label><b>المدفوع
                                                                                                        :</b></label>
                                                                                                <span style="color:green">
                                                                                                    {{ number_format($reg->payments->sum('amount'), 2) }}
                                                                                                    ر.س
                                                                                                </span>
                                                                                            </div>

                                                                                            <div class="col-md-4">
                                                                                                <label><b>المتبقي
                                                                                                        :</b></label>
                                                                                                <span style="color:red">
                                                                                                    {{ number_format($reg->price - $reg->payments->sum('amount'), 2) }}
                                                                                                    ر.س
                                                                                                </span>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="card-block pay-template">
                                                                                    <div class="card-text col-md-12">
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <h4 class="card-title"
                                                                                                    style="float: right;">
                                                                                                    الدفعات</h4>
                                                                                            </div>

                                                                                            @if ($reg->payments->count() > 0)
                                                                                                @foreach ($reg->payments as $payment)
                                                                                                    <div class="col-md-12">
                                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                        <b> {{ $payment->amount }}
                                                                                                            ر.س
                                                                                                        </b>
                                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                        ({{ $payment->paid_at }})
                                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                        [
                                                                                                        {{ $payment->pay_type }}
                                                                                                        ]
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            @endif

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="card-block pay-template"
                                                                                    style="margin-bottom: 20px">
                                                                                    <div class="card-text col-md-12">
                                                                                        <div class="row">

                                                                                            <div class="col-md-12">
                                                                                                <h4 class="card-title"
                                                                                                    style="float: right;">
                                                                                                    تسجيل دفع جديد</h4>
                                                                                            </div>

                                                                                            <div class="col-md-3">
                                                                                                <label>القيمة :</label>
                                                                                                <span>
                                                                                                    <input type="text"
                                                                                                        id="amount"
                                                                                                        class="form-control"
                                                                                                        name="amount" />
                                                                                                </span>
                                                                                            </div>

                                                                                            <div class="col-md-4">
                                                                                                <label for="paid_at">تاريخ
                                                                                                    الدفع :</label>
                                                                                                <span>
                                                                                                    <input type="text"
                                                                                                        id="paid_at"
                                                                                                        class="form-control pickadate"
                                                                                                        name="paid_at" />
                                                                                                </span>
                                                                                            </div>

                                                                                            <div class="col-md-3">
                                                                                                <label for="paid_at">نوع
                                                                                                    الدفع :</label>
                                                                                                <span>
                                                                                                    <select id="pay_type"
                                                                                                        name="pay_type"
                                                                                                        class="form-control">
                                                                                                        <option
                                                                                                            value="كاش">
                                                                                                            كاش</option>
                                                                                                        <option
                                                                                                            value="تحويل">
                                                                                                            تحويل</option>
                                                                                                        <option
                                                                                                            value="شبكه">
                                                                                                            شبكه</option>
                                                                                                    </select>
                                                                                                </span>
                                                                                            </div>

                                                                                            <div class="col-md-2"
                                                                                                style="text-align: center">
                                                                                                <label>&nbsp;</label>
                                                                                                <span>
                                                                                                    <br />
                                                                                                    <a class="btn btn-success pay"
                                                                                                        href="#">دفع</a>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                {{-- </section> --}}
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                            <label for="registered_by">تم التسجيل عن طريق :
                                                                <span class="hint">*</span>
                                                            </label>
                                                            <span>
                                                                <input class="form-control currency-after" type="text"
                                                                    id="registered_by" name="registered_by" required />
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


                var actvRegID = 0;
                var actvPayID = 0;

                ///Reg Details
                $('.one-reg').click(function() {
                    actvRegID = this.id;
                    $('#modal-reg-info div.modal-content').html($('#reg-' + actvRegID + '-info').html());
                });

                $('.reg-modal .changeRegDate').click(function() {
                    $('#reg-' + actvRegID + '-info .regDateDV').hide();
                    $('#reg-' + actvRegID + '-info .chooseNewDateDV').show();
                    $('#reg-' + actvRegID + '-info #chngDate').val(1);
                });

                $('.reg-modal .resetRegDate').click(function() {
                    $('#reg-' + actvRegID + '-info .chooseNewDateDV').hide();
                    $('#reg-' + actvRegID + '-info .regDateDV').show();
                    $('#reg-' + actvRegID + '-info #chngDate').val(0);
                });

                $('.reg-modal .accept').click(function() {
                    $('#reg-' + actvRegID + '-info #reg-action').val('accept');
                    $('#reg-' + actvRegID + '-info #regActionForm').submit();
                    return;
                });
                $('.reg-modal .reject').click(function() {
                    $('#reg-' + actvRegID + '-info #reg-action').val('reject');
                    $('#reg-' + actvRegID + '-info #regActionForm').submit();
                    return;
                });
                $('.reg-modal .waiting').click(function() {
                    $('#reg-' + actvRegID + '-info #reg-action').val('waiting');
                    $('#reg-' + actvRegID + '-info #regActionForm').submit();
                    return;
                });


                //Pay
                $('.one-pay').click(function() {
                    actvRegID = this.id;
                    $('#modal-pay-info div.modal-content').html($('#pay-' + actvRegID + '-info').html());
                });
                $('.pay-modal .pay').click(function() {
                    //console.log(actvRegID);
                    $('#pay-' + actvRegID + '-info #payActionForm').submit();
                    return;
                });

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
    @endpush
@endsection

@section('vendor-js')
@endsection

@section('page-level-js')
@endsection
