@extends('layoutmodule::admin.main')

@section('title')
    الطلاب
@endsection


@section('content')
    <div class="content-wrapper container-fluid">
        <div class="content-header">
            <div class="content-header-left mb-2 breadcrumb-new col">
                <h3>
                    <i class="fa fa-graduation-cap"></i>
                    &nbsp;
                    قائمة الطلاب المسجلين
                </h3>
            </div>
        </div>

        @include('layoutmodule::admin.flash')

        <?php
        // print_r(app('request')->srch);
        ?>
        <div class="content-body">

            <div class="row">
                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-left media-middle">
                                        <i class="fa fa-graduation-cap teal font-large-2 float-xs-right"></i>
                                    </div>
                                    <div class="media-body text-xs-right">
                                        <h3 class="teal">{{ $students->total() }}</h3>
                                        <h5>الطلاب المسجلين</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-5 col-md-4 col-sm-3 col-xs-12">
                                    {{-- <div class="filters">
                                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="icon-filter"></i>
                                                Filter
                                            </a>
                                        <div class="dropdown-menu arrow dropdown-filter"> --}}
                                    <input type="hidden" id="fltr_val" value="@if (app('request')->fltr != null) {{ app('request')->fltr }} @endif" />

                                    {{-- <button class="dropdown-item filter-item" type="button" data-val="no">
                                                    No Filer
                                                </button>
                                                <button class="dropdown-item filter-item" type="button" data-val="1">
                                                    Active
                                                </button>
                                                <button class="dropdown-item filter-item" type="button" data-val="2">
                                                    Not Active
                                                </button>
                                            </div>
                                        </div> --}}

                                    <div class="filters" @if (Auth::guard('user')->check()) style="display:none" @endif>
                                        <input type="hidden" id="fltr_brnch_val" value="@if(app('request')->brnch != null){{ app('request')->brnch }}@endif" />
                                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="icon-sort"></i>
                                            الفرع
                                        </a>
                                        <div class="dropdown-menu arrow dropdown-filter">
                                            <input type="hidden" id="fltr_brnch" value="@if (app('request')->fltr != null) {{ app('request')->fltr }} @endif" />

                                            <button class="dropdown-item filter-item-brnch" type="button" data-val="no">
                                                الكل
                                            </button>
                                            @foreach ($branches as $branch)
                                            <button class="dropdown-item filter-item-brnch" type="button" data-val="{{$branch->id}}">
                                                {{$branch->name}}
                                            </button>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="filters">
                                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="icon-sort"></i>
                                            ترتيب
                                        </a>
                                        <div class="dropdown-menu arrow dropdown-sort">
                                            <input type="hidden" id="sort_val" value="@if(app('request')->srt != null){{ app('request')->srt }}@endif" />

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

                                <div class="col-lg-5 col-md-6 col-sm-9 col-xs-12">
                                    <div class="header-search">
                                        <label>بحث</label>
                                        <input value='@if (app('request')->srch != null) {{ app('request')->srch }} @endif'
                                            id="srchInput" />
                                        <button class="srch-icon">
                                            <i class="icon-search7"></i>
                                        </button>
                                        <a href="#" class="clear">إلغاء</a>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <a class="btn btn-success round btn-min-width mr-1 mb-1"
                                        href="{{ route(Auth::getDefaultDriver() . '.students.add') }}" role="button">تسجيل
                                        طالب جديد</a>

                                    {{-- <a class="btn btn-danger round btn-min-width mr-1 mb-1"
                                        href="{{route(Auth::getDefaultDriver().'.students.archived')}}" role="button">الأرشيف</a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr class="head">
                                            <th>الطالب</th>
                                            @if (Auth::guard('admin')->check())
                                                <th>الفرع</th>
                                            @endif
                                            <th>الجوال</th>
                                            <th>رقم الهوية</th>
                                            <th class="align-center">عدد الدورات المسجل فيها</th>
                                            <th>تاريخ التسجيل</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($students))
                                            @foreach ($students as $student)
                                                <tr>
                                                    <td>{{ $student->name }}</td>
                                                    @if (Auth::guard('admin')->check())
                                                        <td>
                                                            {{ $student->branch->name }}
                                                        </td>
                                                    @endif
                                                    <td>
                                                        {{ $student->phone1 }}
                                                    </td>
                                                    <td>
                                                        {{ $student->id_nu }}
                                                    </td>
                                                    <td class="align-center">
                                                        {{ $student->courses_regs->count() }}
                                                    </td>
                                                    <td>
                                                        {{ $student->created_at }}
                                                    </td>
                                                    <td class="action">
                                                        <a class="btn btn-warning"
                                                            href="{{ route(Auth::getDefaultDriver() . '.students.view', $student->id) }}"
                                                            role="button">عرض</a>

                                                        {{-- @if (in_array('can_del_students', auth()->user()->privileges_keys())) --}}
                                                        @if(Auth::guard('admin')->check())
                                                        <a class="btn btn-danger"
                                                            href="{{ route(Auth::getDefaultDriver() . '.students.delete', $student->id) }}"
                                                            onclick="return confirm('هل انت متأكد انك تريد حذف هذا الطالب و جميع الدورات المسجل فيها ؟')"
                                                            role="button">حذف</a>
                                                        @endif
                                                        {{-- @endif --}}


                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                {{ $students->appends(request()->query())->links('layoutmodule::admin.custom_pagination') }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            var url = "{{ url(Auth::getDefaultDriver()) }}" + '/students';
        </script>
    @endpush
@endsection
