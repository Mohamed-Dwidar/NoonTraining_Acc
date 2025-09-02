@extends('layoutmodule::admin.main')

@section('title')
    التقارير
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
                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route(Auth::getDefaultDriver().'.reports.students_all') }}">
                                <div class="card-block">
                                    <div class="media">
                                        <div class="media-body text-xs-center">
                                            <h3 class="teal"> </h3>
                                            <h5>تقرير بكامل الطلاب</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route(Auth::getDefaultDriver().'.reports.courses') }}">
                                <div class="card-block">
                                    <div class="media">
                                        <div class="media-body text-xs-center">
                                            <h3 class="teal"> </h3>
                                            <h5>تقرير بالطلاب لكل دورة</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route(Auth::getDefaultDriver().'.reports.students_not_paid') }}">
                                <div class="card-block">
                                    <div class="media">
                                        <div class="media-body text-xs-center">
                                            <h3 class="teal"> </h3>
                                            <h5>تقرير بالطلاب الغير مسددين إطلاقاٌ</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route(Auth::getDefaultDriver().'.reports.students_installment_pay') }}">
                                <div class="card-block">
                                    <div class="media">
                                        <div class="media-body text-xs-center">
                                            <h3 class="teal"> </h3>
                                            <h5>تقرير بالطلاب عليهم أقساط</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route(Auth::getDefaultDriver().'.reports.students_exam_mot_paid') }}">
                                <div class="card-block">
                                    <div class="media">
                                        <div class="media-body text-xs-center">
                                            <h3 class="teal"> </h3>
                                            <h5>تقرير بالطلاب عليهم رسوم الاختبار فقط</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route(Auth::getDefaultDriver().'.reports.students_paid') }}">
                                <div class="card-block">
                                    <div class="media">
                                        <div class="media-body text-xs-center">
                                            <h3 class="teal"> </h3>
                                            <h5>تقرير بالطلاب المسددين</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route(Auth::getDefaultDriver().'.reports.students_recive_cert') }}">
                                <div class="card-block">
                                    <div class="media">
                                        <div class="media-body text-xs-center">
                                            <h3 class="teal"> </h3>
                                            <h5>تقرير بالطلاب المستلمين للشهادات</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route(Auth::getDefaultDriver().'.reports.students_not_recive_cert') }}">
                                <div class="card-block">
                                    <div class="media">
                                        <div class="media-body text-xs-center">
                                            <h3 class="teal"> </h3>
                                            <h5>تقرير بالطلاب الغير مستلمين للشهادات</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                @if (Auth::guard('admin')->check())
                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route(Auth::getDefaultDriver().'.reports.users_log') }}">
                                <div class="card-block">
                                    <div class="media">
                                        <div class="media-body text-xs-center">
                                            <h3 class="teal"> </h3>
                                        <h5>تقرير بالعمليات للمستخدمين</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route(Auth::getDefaultDriver().'.reports.students_leave') }}">
                                <div class="card-block">
                                    <div class="media">
                                        <div class="media-body text-xs-center">
                                            <h3 class="teal"> </h3>
                                            <h5>تقرير بالطلاب المغادرين</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="">
                                <div class="card-block">
                                    <div class="media">
                                        <div class="media-body text-xs-center">
                                            <h3 class="teal"> </h3>
                                            <h5>تقرير بالطلاب حسب قطاع العمل</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div> --}}
            </div>

        </div>
    </div>
@endsection
